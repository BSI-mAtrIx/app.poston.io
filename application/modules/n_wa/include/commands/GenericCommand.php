<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Generic message command
 *
 * Gets executed when any type of message is sent.
 *
 * In this conversation-related context, we must ensure that active conversations get executed correctly.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\ChatAction;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\InputMedia\InputMediaPhoto;
use Longman\TelegramBot\Entities\File;
use Longman\TelegramBot\Request;
use PDO;
use Exception;


class GenericCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'generic';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $need_mysql = true;

    /**
     * Command execute method if MySQL is required but not available
     *
     * @return ServerResponse
     */
    public function executeNoDb(): ServerResponse
    {
        // Do nothing
        return Request::emptyResponse();
    }



    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {

        // If you use deep-linking, get the parameter like this:
        // $deep_linking_parameter = $this->getMessage()->getText(true);

        $this->n_pdo  = DB::getPdo();

        $this->n_bot_data = $this->telegram->bot_data;

        $callback_query = $this->getCallbackQuery();

        if(!empty($callback_query)){
            $callback_data  = $callback_query->getData();
            $callback_text  = $callback_query->getText();
            $this->n_message = $callback_query->getMessage();
            $this->n_command = '';

            $callback_query->answer();
            $this->n_user    = $callback_query->getFrom();
            $this->n_from = $this->n_user;
            $this->n_user_id = $this->n_user->getId();
        }else{
            $this->n_message = $this->getMessage();
            $this->n_message_id = $this->n_message->getMessageId();
            $this->n_text    = trim($this->n_message->getText(true));

            $this->n_command = $this->n_message->getCommand();

            $this->n_user    = $this->n_message->getFrom();
            $this->n_from = $this->n_user;
            $this->n_user_id = $this->n_user->getId();

        }
        $this->n_chat    = $this->n_message->getChat();
        $this->n_chat_id = $this->n_chat->getId();

        // Conversation start
        $this->conversation = new Conversation($this->n_user_id, $this->n_chat_id, $this->getName());

        // Load any existing notes from this conversation
        $notes = &$this->conversation->notes;
        !is_array($notes) && $notes = [];

        // Load the current state of the conversation
        $last_node_id = $notes['last_node_id'] ?? 0;
        $userinput = $notes['userinput'] ?? 'default';

        //Request::emptyResponse();

        //$this->debug_mess($this->n_user_id);
//        $this->debug_mess($this->n_bot_data['input_json']);


        //first check command whoami
        if ($this->n_command == 'whoami' AND $this->n_bot_data['com_whoami']==1) {
            return $this->whoami();
        }

        if ($this->n_command == 'brand' AND $this->n_bot_data['brand_command']==true) {
            return $this->send_message('This bot using: '.$this->n_bot_data['brand_text']);
        }

        //second: check for command / OR send no command found
        if(!empty($this->n_command)){
            $where = 'command = "'.$this->n_command.'"';
            $postbacks = $this->get_sql($where);

            if(empty($postbacks)){
                $return_message = $this->n_bot_data['bot_command_no_match'];
                $return_message = $this->message_hash($return_message, $this->n_user, $this->n_command);

                return $this->replyToChat($return_message);
            }else{
                $notes['last_node_id'] = $postbacks[0]['node_id'];
                $this->conversation->update();

                return $this->build_message($postbacks);
            }
        }

        //third: check button reply
        if(!empty($callback_data)){
            $data_next = array(
                'last_node_id' => $last_node_id,
                'callback' => $callback_data
            );

            $parse = $this->next_callback($data_next);

            if($parse == false){
                return $this->message_not_match();
            }

            return $parse;
        }

        //fourth: check trigger and USERINPUT false
        //get last node_id
        //check trigger for last node id
        //if not find check for start triggers
        if(!empty($this->n_text) AND $userinput=='default'){
            $data_next = array(
                //'last_node_id' => $last_node_id,
                'keyword' => $this->n_text
            );

            return $this->trigger_check($data_next);
        }

        if(!empty($this->n_text) AND $userinput=='userinput'){
            $data_next = array(
                'last_node_id' => $last_node_id,
                'user_response' => $this->n_text
            );

            return $this->next_step($data_next);
        }

        if ($this->n_message->getLocation() !== null) {
            $notes['longitude'] = $this->n_message->getLocation()->getLongitude();
            $notes['latitude']  = $this->n_message->getLocation()->getLatitude();
            $this->conversation->update();

            $this->update_user('n_address', $notes['longitude'].', '.$notes['latitude']);

            $where = 'node_id = '.$last_node_id;
            $parse = $this->get_sql($where);

            $p[0]['config'] = preg_replace("/[\r\n]+/", " ",$parse[0]['config']);
            $p_c = json_decode($p[0]['config'], true);

            if(!empty($p_c['buttons'])){
                foreach($p_c['buttons'] as $k => $v){
                    if($v['action']=='request_location'){
                        $next_origin_id = $v['origin_id'];
                        break;
                    }
                }

                $parse_next = json_decode($parse[0]['next_id'], true);
                if(empty($parse_next)){
                    return $this->message_not_match();
                }

                $next_id = array_key_first($parse_next[$next_origin_id]);

                $data_next = array(
                    'last_node_id' => $next_id,
                    'current_step' => true
                );

                return $this->next_step($data_next);
            }else{
                return $this->message_not_match();
            }

        }


        if ($this->n_message->getContact() !== null) {
            $notes['phone_number'] = $this->n_message->getContact()->getPhoneNumber();
            $this->conversation->update();

            $this->update_user('n_phone', $notes['phone_number']);

            $where = 'node_id = '.$last_node_id;
            $parse = $this->get_sql($where);

            $p[0]['config'] = preg_replace("/[\r\n]+/", " ",$parse[0]['config']);
            $p_c = json_decode($p[0]['config'], true);

            if(!empty($p_c['buttons'])){
                foreach($p_c['buttons'] as $k => $v){
                    if($v['action']=='request_contact'){
                        $next_origin_id = $v['origin_id'];
                        break;
                    }
                }

                $parse_next = json_decode($parse[0]['next_id'], true);
                if(empty($parse_next)){
                    return $this->message_not_match();
                }

                $next_id = array_key_first($parse_next[$next_origin_id]);

                $data_next = array(
                    'last_node_id' => $next_id,
                    'current_step' => true
                );

                return $this->next_step($data_next);
            }else{
                return $this->message_not_match();
            }


        }

        //five: google dialog or anothers

        //sixth: no reply
        return true;
    }

    private function next_callback($data){
        //current node
        $where = 'node_id = '.$data['last_node_id'];
        $parse = $this->get_sql($where);

        if(isset($data['current_step']) AND $data['current_step']==true){
            return $this->parse_message_data($parse);
        }

        if(!empty($parse[0])){
            $parse_next = json_decode($parse[0]['next_id'], true);
            if(empty($parse_next[$data['callback']])){
                //prev node
                $parse_prev = json_decode($parse[0]['prev_id'], true);
                if(empty($parse_prev)){
                    return $this->message_not_match();
                }
                $data['last_node_id'] = array_key_first($parse_prev[array_key_first($parse_prev)]);
                return $this->next_callback($data);
            }else{
                if($this->n_bot_data['inline_show_selected']==1){
                    $p[0]['config'] = preg_replace("/[\r\n]+/", " ",$parse[0]['config']);
                    $p_c = json_decode($p[0]['config'], true);

                    if(!empty($p_c['buttons'])){
                        foreach($p_c['buttons'] as $k => $v){
                            if($v['origin_id']==$data['callback']){
                                $this->send_message('*'.$this->n_bot_data['lang_selected'].':* '.$v['name'], 'markdown');
                                break;
                            }
                        }
                    }



                }

                $data['current_step'] = true;
                $data['last_node_id'] = array_key_first($parse_next[$data['callback']]);
                return $this->next_callback($data);
            }
        }else{
            return $this->message_not_match();
        }
    }

    private function next_step($data){
        //current node
        $where = 'node_id = '.$data['last_node_id'];
        $parse = $this->get_sql($where);

        if(isset($data['current_step']) AND $data['current_step']==true){
            return $this->parse_message_data($parse);
        }

        if(!empty($parse[0])){
            $parse_next = json_decode($parse[0]['next_id'], true);
            if(empty($parse_next['number'])){
                //prev node
                $parse_prev = json_decode($parse[0]['prev_id'], true);
                if(empty($parse_prev)){
                    return $this->message_not_match();
                }
                $data['last_node_id'] = array_key_first($parse_prev['message']);
                return $this->next_step($data);
            }else{
                //next node
                $data['current_step'] = true;
                $data['last_node_id'] = array_key_first($parse_next['number']);
                return $this->next_step($data);
            }
        }else{
            return $this->message_not_match();
        }
    }

    private function parse_message_data($resp){
        switch($resp[0]['type']){
            case 'trigger';
                break;
            case 'message';
                $notes = &$this->conversation->notes;
                $notes['last_node_id'] = $resp[0]['node_id'];
                $this->conversation->update();
                return $this->build_message($resp);
                break;
            case 'condition';
                return $this->condition_check($resp);
                break;
        }
    }

    private function trigger_check($data){
        $triggers = $this->get_sql('type = "trigger"', 0);
        if(empty($triggers)){
            return $this->message_not_match();
        }
        $return_resp = false;
        $return_resp_disabled = false;
        $data['keyword'] = strtolower($data['keyword']);
        foreach($triggers as $k => $v) {
            $p=array();
            $p['config'] = preg_replace("/[\r\n]+/", " ", $v['config']);
            $p['config'] = json_decode($p['config'], true);
            $p['keyword'] = strtolower($p['config']['keyword']);

            if(empty($p['config']['trigger_action'])){
                $p['config']['trigger_action'] = 'disabled';
            }
            switch ($p['config']['trigger_action']) {
                case 'contains';
                case 'has_value';
                    if (strpos($data['keyword'], $p['keyword']) !== false) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'equal';
                    if ($data['keyword'] == $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'less_than';
                    if ($data['keyword'] < $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'greater_than';
                    if ($data['keyword'] > $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'greater_than_or_equal';
                    if ($data['keyword'] >= $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'less_than_or_equal';
                    if ($data['keyword'] <= $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'not_equal';
                    if ($data['keyword'] != $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'start_with';
                     if (substr($data['keyword'], 0, strlen($p['keyword'])) === $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                         $return_id = $v['id'];
                         break;
                     }
                    break;
                case 'end_with';
                    if (substr($data['keyword'], -strlen($p['keyword'])) === $p['keyword']) {
                        $return_resp = true;
                        $return_node_id = $v['next_id'];
                        $return_id = $v['id'];
                        break;
                    }
                    break;
                case 'disabled';

                    break;
            }
            if($return_resp){
                break;
            }
        }

        if($return_resp){
            $parse_next = json_decode($return_node_id, true);
            if(empty($parse_next)){
                return $this->message_not_match();
            }

            $this->sent_plus($return_id);

            $next_id = array_key_first($parse_next['message']);

            $resp = $this->get_sql('node_id = '.$next_id, 1);
            if(empty($resp)){
                return $this->message_not_match();
            }

            return $this->build_message($resp);
        }

        if($return_resp==false){
            return $this->message_not_match();
        }

    }

    private function check_operand($input, $match, $operand){
        $return_resp = false;
        switch ($operand) {
            case 'contains';
            case 'has_value';
                if (strpos($input, $match) !== false) {
                    $return_resp = true;
                }
                break;
            case 'equal';
                if ($input == $match) {
                    $return_resp = true;
                }
                break;
            case 'less_than';
                if ($input < $match) {
                    $return_resp = true;
                }
                break;
            case 'greater_than';
                if ($input > $match) {
                    $return_resp = true;
                }
                break;
            case 'greater_than_or_equal';
                if ($input >= $match) {
                    $return_resp = true;
                }
                break;
            case 'less_than_or_equal';
                if ($input <= $match) {
                    $return_resp = true;
                }
                break;
            case 'not_equal';
                if ($input != $match) {
                    $return_resp = true;
                }
                break;
            case 'start_with';
                if (substr($input, 0, strlen($match)) === $match) {
                    $return_resp = true;
                }
                break;
            case 'end_with';
                if (substr($input, -strlen($match)) === $match) {
                    $return_resp = true;
                }
                break;
        }

        return $return_resp;
    }


    private function condition_check($resp){
        $pc = preg_replace("/[\r\n]+/", " ",$resp[0]['config']);
        $pc = json_decode($pc, true);

        $result = $this->check_operand($this->n_text, $pc['keyword'], $pc['trigger_action']);

        $parse_next = json_decode($resp[0]['next_id'], true);
        if(empty($parse_next)){
            return $this->message_not_match();
        }

        if($result){
            $data_next = array(
                'last_node_id' => array_key_first($parse_next['true']),
                'current_step' => true
            );
        }else{
            $data_next = array(
                'last_node_id' => array_key_first($parse_next['false']),
                'current_step' => true
            );
        }

        $this->sent_plus($resp[0]['id']);
        return $this->next_step($data_next);
    }


    private function message_not_match(){
        $return_message = $this->n_bot_data['bot_mess_no_match'];
        $return_message = $this->message_hash($return_message, $this->n_user, $this->n_command);

//        return $this->replyToChat($return_message);
        $data = [
            'chat_id'    => $this->n_chat_id,
            'text' => $return_message,
            'reply_markup' => Keyboard::remove(['selective' => true])
        ];
        return Request::sendMessage($data);
    }

    private function debug_mess($message){
        if(is_array($message)){
            $message = json_encode($message);
        }
        $data = [
            'chat_id'    => $this->n_chat_id,
            'text' =>  $message,
        ];
        Request::sendMessage($data);
    }

    private function send_message($message, $markdown=''){
        if(is_array($message)){
            $message = json_encode($message);
        }
        $data = [
            'chat_id'    => $this->n_chat_id,
            'text' =>  $message,
        ];
        if($markdown!=''){
            $data['parse_mode'] = 'markdown';
        }
        Request::sendMessage($data);
    }

    private function get_sql($where, $limit = 1 ){
        try {
            $query ='SELECT * FROM `' . TB_TELEGRAM_POSTBACK . '`
                    where '.$where;
            if($limit > 0){
                $query .= ' LIMIT '.$limit;
            }
            $sth = $this->n_pdo->prepare($query);

            $sth->execute();

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new TelegramException($e->getMessage());
        }
    }

    private function get_user_label(){
        try {
            $query ='SELECT labels FROM `' . TB_USER . '`
                    where id='.$this->n_user_id;
                $query .= ' LIMIT 1';
            $sth = $this->n_pdo->prepare($query);

            $sth->execute();

            $labels = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $labels[0]['labels'];
        } catch (PDOException $e) {
            throw new TelegramException($e->getMessage());
        }
    }

    private function update_user($column, $value ){
        try {
            $query ="UPDATE `" . TB_USER . "`
                    SET ".$column." = '".$value."'
                    where id=".$this->n_user_id;

            $sth = $this->n_pdo->query($query);

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new TelegramException($e->getMessage());
        }
    }

    private function update_user_cs($value){
        try {
            $query ="UPDATE `" . TB_USER . "`
                    ".$value."
                    where id=".$this->n_user_id;

            $sth = $this->n_pdo->query($query);

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new TelegramException($e->getMessage());
        }
    }

    private function sent_plus($id){
        try {
            $query ="UPDATE `" . TB_TELEGRAM_POSTBACK . "`
                    SET STAT_SENT = STAT_SENT+1
                    where id=".$id;

            $sth = $this->n_pdo->query($query);

        } catch (PDOException $e) {
            throw new TelegramException($e->getMessage());
        }
    }

    private function build_message($postbacks){
        $this->sent_plus($postbacks[0]['id']);


        $postbacks[0]['config'] = preg_replace("/[\r\n]+/", " ",$postbacks[0]['config']);
        $postback_config = json_decode($postbacks[0]['config'], true);

        $notes = &$this->conversation->notes;

        if(!empty($postback_config['step_action'])){
            $notes['userinput'] = $postback_config['step_action'];
        }

        if(!empty($postback_config['points']) AND is_numeric($postback_config['points'])){

            if (strpos($postback_config['points'], '+') !== false) {
                $sql_points = "SET npoints = npoints".$postback_config['points']."";
            }elseif (strpos($postback_config['points'], '-') !== false) {
                $sql_points = "SET npoints = npoints".$postback_config['points']."";
            }else{
                $sql_points = "SET npoints = ".$postback_config['points']."";
            }

            $this->update_user_cs($sql_points);


        }

        if(empty($postback_config['step_action']) AND $postback_config['step_action']!='default' AND !empty($notes['userinput'])){
            $notes['userinput'] = 'default';
        }

        $user_label = $this->get_user_label();
        $user_label = json_decode($user_label, true);
        if(!is_array($user_label)){
            $user_label = array();
        }

        if(!empty($postback_config['label_add'])){
            $label_add = $postback_config['label_add'];
            if(!empty($label_add)){
                $user_label = array_merge($label_add, $user_label);
            }
        }

        if(!empty($postback_config['label_rem'])){
            $label_rem = $postback_config['label_rem'];
            if(!empty($label_rem)){
                foreach($label_rem as $k => $v){
                    array_splice($user_label, array_search($v, $user_label), 1);
                }
            }
        }
        $user_label = array_unique($user_label);
        $user_label = json_encode($user_label);
        $this->update_user('labels', $user_label);



        $notes['last_node_id'] = $postbacks[0]['node_id'];
        $this->conversation->update();


            if($postback_config['typing']==true){
                Request::sendChatAction([
                    'chat_id' => $this->n_chat_id,
                    'action'  => ChatAction::TYPING,
                ]);
            }

            $inline_keyboard_array = array();
            $keyboard_array = array();
            $second_array_reply = array();
            $inline_keyboard = array();

            if(is_array($postback_config['buttons']) AND count($postback_config['buttons'])>0){
                foreach($postback_config['buttons'] as $k => $v){

                    if(empty($inline_keyboard_array[$v['row']])){
                        $inline_keyboard_array[$v['row']] = array();
                    }

                    switch($v['action']){
                        case 'message';

                            $inline_keyboard_array[$v['row']][] = array(
                                'text' => $v['name'],
                                'callback_data' => $v['origin_id']
                            );

//                            $keyboard_array[] = (new KeyboardButton($v['name']))->setRequestContact(true);

                            break;

                        case 'request_contact';
                            $keyboard_array[] = (new KeyboardButton($v['name']))->setRequestContact(true);
                            break;

                        case 'request_location';
                            $keyboard_array[] = (new KeyboardButton($v['name']))->setRequestLocation(true);
                            break;

                        case 'url';

                            $inline_keyboard_array[$v['row']][] = array(
                                'text' => $v['name'],
                                'url' => $v['value']
                            );

                            break;
                    }


                }

                switch(count($inline_keyboard_array)){
                    case 1;
                        $inline_keyboard = new InlineKeyboard(reset($inline_keyboard_array));
                        break;

                    case 2;
                        $inline_keyboard = new InlineKeyboard(
                            reset($inline_keyboard_array),
                            next($inline_keyboard_array)
                        );
                        break;
                    case 3;
                        $inline_keyboard = new InlineKeyboard(
                            reset($inline_keyboard_array),
                            next($inline_keyboard_array),
                            next($inline_keyboard_array)
                        );
                        break;
                    case 4;
                        $inline_keyboard = new InlineKeyboard(
                            reset($inline_keyboard_array),
                            next($inline_keyboard_array),
                            next($inline_keyboard_array),
                            next($inline_keyboard_array)
                        );
                        break;
                }

                if(!empty($keyboard_array)){
                    $inline_keyboard =  (new Keyboard(
                        $keyboard_array
                    ))->setOneTimeKeyboard(true)
                        ->setResizeKeyboard(true)
                        ->setSelective(true);
                }

                $second_array_reply['reply_markup'] = $inline_keyboard;
            }


            $return_message = $this->message_hash($postbacks[0]['message'], $this->n_user, $this->n_command);

            if ($this->n_chat->isGroupChat() || $this->n_chat->isSuperGroup()) {
                // Force reply is applied by default so it can work with privacy on
                $second_array_reply['reply_markup'] = Keyboard::forceReply(['selective' => true]);
            }

            if(!empty($inline_keyboard)){
                $reply_markup = $inline_keyboard;
            }else{
                $reply_markup = Keyboard::remove(['selective' => true]);
            }





        if(!empty($return_message)){
            $data = [
                'chat_id'    => $this->n_chat_id,
                'text' => $return_message,
                'reply_markup' => $reply_markup
            ];

            if(!empty($postback_config['markdown']) AND $postback_config['markdown']==true){
                $data['parse_mode'] = 'markdown';
            }

            $needed_return = Request::sendMessage($data);
        }

        if(!empty($needed_return)){
            return $needed_return;
        }

    }

    private function message_hash($mess, $from, $command = ''){
        $search = array(
            '[first_name]',
            '[last_name]',
            '[username]',
            '[command]'
        );

        $replace = array(
            $from->getFirstName(),
            $from->getLastName(),
            $from->getUsername(),
            $command
        );

        return str_replace($search, $replace, $mess);
    }

    private function whoami(){
        $data = [
            'chat_id'             => $this->n_chat_id,
            'reply_to_message_id' => $this->n_message_id,
        ];

        // Send chat action "typing..."
        Request::sendChatAction([
            'chat_id' => $this->n_chat_id,
            'action'  => ChatAction::TYPING,
        ]);

        $caption = sprintf(
            'Your Id: %d' . PHP_EOL .
            'Name: %s %s' . PHP_EOL .
            'Username: %s',
            $this->n_user_id,
            $this->n_from->getFirstName(),
            $this->n_from->getLastName(),
            $this->n_from->getUsername()
        );

        // Fetch the most recent user profile photo
        $limit  = 1;
        $offset = null;

        $user_profile_photos_response = Request::getUserProfilePhotos([
            'user_id' => $this->n_user_id,
            'limit'   => $limit,
            'offset'  => $offset,
        ]);

        if ($user_profile_photos_response->isOk()) {
            /** @var UserProfilePhotos $user_profile_photos */
            $user_profile_photos = $user_profile_photos_response->getResult();

            if ($user_profile_photos->getTotalCount() > 0) {
                $photos = $user_profile_photos->getPhotos();

                // Get the best quality of the profile photo
                $photo   = end($photos[0]);
                $file_id = $photo->getFileId();

                $data['photo']   = $file_id;
                $data['caption'] = $caption;

                return Request::sendPhoto($data);
            }
        }

        // No Photo just send text
        $data['text'] = $caption;

        return Request::sendMessage($data);
    }


}