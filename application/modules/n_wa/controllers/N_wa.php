<?php
/*
Addon Name: WhatsApp Bot Addon
Unique Name: n_wa
Modules:
{
   "4112":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"",
      "module_name":"WhatsApp Bot Connected"
   },
   "4114":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"per bot",
      "module_name":"WhatsApp Bot Subscribers limit"
   },
   "4116":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"",
      "module_name":"WhatsApp Bot Platform Brand Name"
   },
   "4118":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"",
      "module_name":"WhatsApp Bot Custom API"
   }
}
Project ID: 1133
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.42
Description: WhatsApp Bot Addon
*/
require_once("application/controllers/Home.php"); // loading home controller
require_once("application/modules/n_wa/vendor/autoload.php"); // loading home controller

use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Message\Template\Component;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Row;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;

class N_wa extends Home
{
    public $key = "E6030EE6B2BD14C3";
    private $product_id = "19";
    private $product_base = "n_wa";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 1.42;
    /* @var self */
    private static $selfobj = null;
    public $fb;

    private $url_api = "https://api.nvxgroup.com/whatsapp/api";
    private $n_gen_config = array();

    public $app_id = "";
    public $app_secret = "";
    public $user_access_token = "";
    public $network_id = "";
    public $net_id = "";
    public $token = "";
    public $current_ad_acc = "";

    public $graph_api = "v15.0";


    public $info = array();


    public $addon_data = array();



    public function __construct()
    {
        parent::__construct();
        //$this->load->config('instagram_reply_config');// config
        // getting addon information in array and storing to public variable
        // addon_name,unique_name,module_id,addon_uri,author,author_uri,version,description,controller_name,installed
        //------------------------------------------------------------------------------------------
        $addon_path = APPPATH . "modules/" . strtolower($this->router->fetch_class()) . "/controllers/" . ucfirst($this->router->fetch_class()) . ".php"; // path of addon controller
        $addondata = $this->get_addon_data($addon_path);
        $this->addon_data = $addondata;
        $this->user_id = $this->session->userdata('user_id'); // user_id of logged in user, we may need it

        $function_name = $this->uri->segment(2);
        if (
            $function_name != "webhook"
        ) {
            // all addon must be login protected
            //------------------------------------------------------------------------------------------
            if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
            // if you want the addon to be accessed by admin and member who has permission to this addon
            //-------------------------------------------------------------------------------------------

            if($this->session->userdata('user_type') != 'Admin' && (!in_array(4112,$this->module_access) AND !in_array(4112,$this->module_access)) )
            {
                redirect('home/login_page', 'location');
                exit();
            }

        }
        $this->load->library('encryption');

        $addon_lang = 'n_wa';
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '_' . $addon_lang . '_lang.php')) {
            $this->lang->load($this->language . '_' . $addon_lang . '_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        } else {
            $this->lang->load('english_' . $addon_lang . '_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '_' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($this->language . '_' . $addon_lang . '_custom_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        }

        if (is_dir(APPPATH . 'modules/'.$addon_lang.'/thirdn/')) {
            $path_unlink = APPPATH . "../assets/thirdn_".$addon_lang."/";
            if (is_dir($path_unlink)) {
                $this->delete_files($path_unlink);
            }
            @rename(APPPATH . "modules/".$addon_lang."/thirdn/", APPPATH . "../assets/thirdn_".$addon_lang."/");
        }

        if (is_dir(APPPATH . 'modules/'.$addon_lang.'/plugins/')) {
            $path_unlink = APPPATH . "../plugins/".$addon_lang."/";
            if (is_dir($path_unlink)) {
                $this->delete_files($path_unlink);
            }
            @rename(APPPATH . "modules/".$addon_lang."/plugins/", APPPATH . "../plugins/".$addon_lang."/");
        }

        if (
            $function_name != "activate"
        ) {
            if (file_exists(APPPATH . 'nwa_db_version.php')) {
                include(APPPATH . 'nwa_db_version.php');
            }
            if (empty($current_verion)) {
                $current_verion = 1;
            }
            include(APPPATH . 'modules/n_wa/include/db_update.php');
        }

        if (file_exists(APPPATH . 'n_generator_config.php')) {
            include(APPPATH . 'n_generator_config.php');
            $this->n_gen_config = $n_gen_config;
        }

    }

    private function save_vdb($v, $show_debug = 0)
    {
        if ($show_debug == 1) {
            echo 'Current DB version: ' . $v . "<br /> <br />";
        }

        $db_v_file = "<?php \n";
        $db_v_file .= "\$current_verion= '$v';\n";

        file_put_contents(APPPATH . 'nwa_db_version.php', $db_v_file, LOCK_EX);
    }

    public function editor($bot_id = ''){
        if ($this->session->userdata('user_type') != 'Admin' && !in_array(4112, $this->module_access)) redirect('home/login', 'location');

        if(empty($bot_id)){
            redirect('n_wa', 'location');
        }

        $bot = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array(
                    'id' => $bot_id,
                    'user_id' => $this->user_id
                ),
                '',
                '',
                1
            )
        );

        if(empty($bot[0])){
            redirect('home/login', 'location');
        }

        $data = array();

        $data['page_title'] = $this->lang->line('Flow builder');
        $data['bot_id'] = $bot_id;
//        $data['lp_dir_id'] = $lp_data['id'];
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');
        $data['language'] = $this->editor_langs();
        $data['content_generator'] = 'false';
        if(file_exists(APPPATH.'modules/n_generator/controllers/N_generator.php')){
            $data['content_generator'] = 'true';
        }


        $data['editor_labels'] = json_encode($this->get_labels($bot[0]['id']));
        $data['flow_builder_json'] = $bot[0]['flow_builder'];

        $data['is_whatsapp'] = true;
        $data['is_telegram'] = false;

        if(empty($data['flow_builder_json'])){
            $data['flow_builder_json'] = '{"id":"n_wa@0.1.0","nodes":{"1":{"id":1,"data":{"message":"Hi, this is start message","command":"start","buttons":[],"typing":false,"markdown":false,"step_action":"default","label_add":[],"label_rem":[],"images":{},"points":""},"inputs":{},"outputs":{"number":{"connections":[]}},"position":[63.60687385943572,-109.06567265822206],"name":"Start"}}}';
        }

        $data['flow_builder_json'] = str_replace("'", "\'", $data['flow_builder_json']);

        $stats = $this->basic->get_data('nwa_'.$bot[0]['id'].'_wa_postback',
            '',
            'node_id,STAT_SENT'
        );
        $js_stats = array();
        if(!empty($stats)){
            foreach($stats as $k => $v){
                $js_stats[$v['node_id']] = array(
                    'sent' => $v['STAT_SENT']
                );
            }
        }

        $data['nodes_stats'] = json_encode($js_stats);

        if($data['content_generator']=='true'){
            $data['sdk_locale'] = $this->sdk_locale();
            $data['config_sdk_locale'] = 'en_US';
            $data['config_creativity'] = 'Optimal';
            $data['config_tone'] = 'Passionate';

            $json = $this->gen_get_user_config();
            if (!empty($json)) {
                $data['config_sdk_locale'] = $json['language'];
                $data['config_creativity'] = $json['creativity'];
                $data['config_tone'] = $json['tone'];
                $data['config_autosave'] = $json['autosave'];
            }
        }

        //$this->load->view('editor.php', $data);
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'editor';
        $this->_viewcontroller($data);
    }

    private function gen_get_user_config()
    {
        if (!empty($this->session->userdata("n_content_settings"))) {
            return json_decode($this->session->userdata("n_content_settings"), true);
        } else {
            $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);

            return json_decode($user_info[0]['n_content_settings'], true);
        }
    }

    private function editor_langs(){
        $lang = array();
        $lang['next_step'] = $this->lang->line('next step');
        $lang['start'] = $this->lang->line('start');
        $lang['trigger'] = $this->lang->line('trigger');
        $lang['warning'] = $this->lang->line('warning');
        $lang['keyword'] = $this->lang->line('keyword');
        $lang['node_start_exist'] = $this->lang->line('You cant add more than 1 Start element.');
        $lang['node_start_cant_delete'] = $this->lang->line('You cant remove Start element.');

        $lang['start_from'] = $this->lang->line('Start from');
        $lang['end_to'] = $this->lang->line('End to');
        $lang['contains'] = $this->lang->line('Contains');
        $lang['exactly'] = $this->lang->line('Exactly');
        $lang['message'] = $this->lang->line('message');
        $lang['condition'] = $this->lang->line('condition');
        $lang['send_message'] = $this->lang->line('Send message');

        $lang['search_text'] = $this->lang->line('Search text');

        $lang['start_with'] = $this->lang->line('Start with');
        $lang['end_with'] = $this->lang->line('End with');
        $lang['has_value'] = $this->lang->line('Has value');
        $lang['operator'] = $this->lang->line('operator');

        $lang['sent'] = $this->lang->line('sent');

        $lang['disabled'] = $this->lang->line('disabled');
        $lang['error'] = $this->lang->line('error');
        $lang['full'] = $this->lang->line('full');
        $lang['crop_and_upload'] = $this->lang->line('Crop & upload');
        $lang['cropping_tool'] = $this->lang->line('Cropping tool');
        $lang['edit_caption'] = $this->lang->line('Edit caption');

        $lang['delete'] = $this->lang->line('Delete');
        $lang['clone'] = $this->lang->line('Clone');

        $lang['message_info'] = $this->lang->line('Message longer than 4096 characters split into multiple messages. If empty then send only images, video or files.');
        $lang['ai_prompt'] = $this->lang->line('AI Prompt');
        $lang['ai_prompt_info'] = $this->lang->line('For prompt describe your business, answer. Based on prompt AI generate message for user question.');

        $lang['triggernomatch'] = $this->lang->line('Trigger No Match');
        $lang['node_trigger_no_match_exist'] = $this->lang->line('You cant add more than 1 no match element.');



        $lang['true'] = $this->lang->line('true');
        $lang['false'] = $this->lang->line('false');

        return json_encode($lang);
    }



    public function index(){
        $this->check_bot_exist();
    }

    private function check_bot_limit_usage(){

        if($this->session->userdata('user_type') == 'Admin'){
            return false;
        }

        $table = "n_wa_bots";
        $where = array();
        $where['where'] = array('user_id' => $this->user_id);
        $total_rows_array = $this->basic->count_row($table, $where, "id");

        $package = $this->session->userdata['package_info']['monthly_limit'];
        $package = json_decode($package, true);

        if(!isset($package[4112])){
            return true;
        }

        if($package[4112]==0){
            return false;
        }

        if($package[4112] > $total_rows_array[0]['total_rows']){
            return false;
        }else{
            return true;
        }

    }

    public function view_main($alert_message = ''){
        $data = array();

        if(!empty($_GET['action'])) {
            switch ($_GET['action']) {
                case 'create_subdomain';

                    break;
            }
        }


        $data['alert_message'] = $alert_message;


        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'main_view';
        $data['page_title'] = $this->lang->line('WhatsApp Bot');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');

        //$data['limit_reach'] = $this->check_limit_usage();


        $this->_viewcontroller($data);
    }

    private function check_bot_exist($page = 'bot_settings'){
        $bots = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array('user_id'=>$this->user_id),
                '',
                '',
                1
            )
        );
        if(empty($bots[0])){
            $this->bot_settings();
        }else{
            $this->view_main();
        }
    }

    private function check_bot_id_exist($bot_id = 0, $page = ''){
        $bots = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array(
                    'user_id'=>$this->user_id,
                    'id' => $bot_id
                ),
                '',
                '',
                1
            )
        );
        if(empty($bots[0])){
            $this->view_main();
        }else{
            $this->view_subscriber_manager($bots[0]);
        }
    }

    public function subscriber_manager($bot_id){
        $this->check_bot_id_exist($bot_id, 'subscriber_manager');
    }

    private function view_subscriber_manager($db_data){
        $data = array();

        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'subscriber_manager';
        $data['page_title'] = $this->lang->line('Subscriber Manager');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');
        $data['bot_id'] = $db_data['id'];


        $this->_viewcontroller($data);
    }


    public function help(){
        $data = array();
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'help';
        $data['page_title'] = $this->lang->line('WhatsApp Connection App Instruction');

        $this->_viewcontroller($data);
    }

    public function bot_settings($bot_id = 0, $message = ''){
        require(APPPATH.'modules/n_wa/include/config.php');
        $data = array();

        if($this->check_bot_limit_usage() and $bot_id==0){
            $data['body'] = 'n_addon_loader';
            $data['addon_page'] = 'limit_reached';
            $data['page_title'] = $this->lang->line('WhatsApp Bot');
            return $this->_viewcontroller($data);
        }


        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'bot_settings';
        $data['page_title'] = $this->lang->line('WhatsApp Bot Settings');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');

        $data['bot_data'] = $this->get_bot_data($bot_id);



        $data['bsp_on'] = $n_wa_conf['bsp_on'];
        $data['api_customer_on'] = $n_wa_conf['api_customer_on'];

        $data['bsp_on_version'] = $n_wa_conf['bsp_on_version'];
        $data['bsp_config_id'] = $n_wa_conf['bsp_config_id'];


        $data['readonly'] = '';
        if(!empty($data['bot_data'])){
            $data['readonly'] = 'readonly';
        }

        $data['alert_message'] = $message;

        //$data['limit_reach'] = $this->check_limit_usage();


        $this->_viewcontroller($data);

    }

    private function message_insert_db($msg){
        if(empty($msg)){
                return null;
        }

        foreach($msg as $k => $v){
            if(is_array($v)){
                $msg[$k] = json_encode($v);
            }
        }

        $this->basic->insert_data('nwa_'.$this->bot_data['id'].'_messages',$msg);

    }

    public function webhook($bot_id = 0){
        header("HTTP/1.1 200 OK"); //todo: debug

        $challenge = $this->input->get_post('hub_challenge');
        $verify_token = $this->input->get_post('hub_verify_token');

        if(!empty($verify_token)){
            $bots = $this->basic->get_data('n_wa_bots',
                array(
                    'where' => array(
                        'verify_token' => $verify_token
                    ),
                    '',
                    '',
                    1
                )
            );

            if(!empty($bots[0]) AND $bots[0]['verify_token'] == $verify_token){
                echo $challenge;
            }
            exit;
        }


        $response_raw=file_get_contents("php://input");
        if(!isset($response_raw) || $response_raw=='') exit;

        //file_put_contents(APPPATH.'logs/'.time(), $response_raw);


        $json_response=array("response_raw"=>$response_raw);
        $response = json_decode($response_raw, true);

        if(!empty($response['entry']) AND !empty($response['entry'][0]['changes'][0]['value']['statuses'][0])){
            $stat = $response['entry'][0]['changes'][0]['value']['statuses'][0];
            //file_put_contents(APPPATH.'logs/'.time().'-'.$stat['status'], $response_raw);

            $display_phone_number = $response['entry'][0]['changes'][0]['value']['metadata']['phone_number_id'];
            $display_phone_number = str_replace(array(' ','+'), '', $display_phone_number);
            $this->bot_data = $this->get_wh_bot_data($display_phone_number);
            $this->bot_id = $this->bot_data['id'];

            if(!empty($response['entry'][0]['changes'][0]['value']['contacts'])){
                $chat_id = $response['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
            }else{
//                if(empty($response['entry'][0]['changes'][0]['value'])){
//                    file_put_contents(APPPATH.'logs/'.time().'-empty.php', $response_raw);
//                }
                $chat_id = $response['entry'][0]['changes'][0]['value']['metadata'][0]['phone_number_id'];
            }

            $this->bot_user = array(
                'wa_id' => $chat_id
            );

            $this->user_details = array('id' => $chat_id);
            $this->user_details = $this->getBotUser();

                if(empty($this->user_details['entry_point'])){
                    $this->user_details['entry_point'] = array(
                        'category' => 0,
                        'category_id' => null,
                        'category_charge' => 0,

                        'authentication' => 0,
                        'authentication_id' => null,
                        'authentication_charge' => 0,

                        'marketing' => 0,
                        'marketing_id' => null,
                        'marketing_charge' => 0,

                        'utility' => 0,
                        'utility_id' => null,
                        'utility_charge' => 0,

                        'service' => 0,
                        'service_id' => null,
                        'service_charge' => 0,

                        'referral_conversion' => 0,
                        'referral_conversion_id' => null,
                        'referral_conversion_charge' => 0,
                    );
                }else{
                    $this->user_details['entry_point'] = json_decode($this->user_details['entry_point'], true);
                }

                if(isset($stat['conversation']['origin']['type'])){
                    $conv_type = $stat['conversation']['origin']['type'];
                    $this->conv_type = $conv_type;
                    if(empty($stat['conversation']['expiration_timestamp'])){
                        $stat['conversation']['expiration_timestamp'] = 0;
                    }
                    $conv_exp = $stat['conversation']['expiration_timestamp'];
                    $conv_id = $stat['conversation']['id'];

                    $entry_id_change = false;
                    if(
                        $this->user_details['entry_point'][$conv_type.'_id'] != $conv_id
                    ){
                        $this->user_details['entry_point'][$conv_type] = $conv_exp;
                        $this->user_details['entry_point'][$conv_type.'_id'] = $conv_id;
                        $this->user_details['entry_point'][$conv_type.'_charge'] = 0;
                        $entry_id_change = true;
                    }

                    $conv_db = $this->basic->get_data("nwa_" . $this->bot_id . "_conversations_stats", array("where" => array("conv_id " => $conv_id)));
                    if(empty($conv_db[0])){
                        $conv_arr_insert = array(
                            'conv_id' => $conv_id,
                            'type' => $conv_type,
                            'status' => 0,
                            'timestamp' => $conv_exp,
                            'country' => '',
                            'price' => 0
                        );
                    }else{
                        $conv_arr_update = array(
                            'conv_id' => $conv_id,
                            'type' => $conv_type,
                            'status' => 0,
                            //'timestamp' => $conv_exp,
                            //'country' => '',
                            //'price' => 0
                        );
                    }
                }

                switch($stat['status']){
                    case 'sent':
                        $conv_status_id = 1;
                        if($entry_id_change) {
                            if ($this->user_details['entry_point'][$conv_type . '_charge'] == 0) {
                                $this->user_details['entry_point'][$conv_type . '_charge'] = 1;
                                if ($this->bot_data['bsp_on'] == 1) {
                                    if (empty($conv_db[0])) {
                                        $price_ret = $this->charge_wa_api($chat_id, $this->bot_id, $stat['recipient_id']);
                                        $conv_arr_insert['charged'] = 1;
                                        $conv_arr_insert['price'] = $price_ret['price'];
                                        $conv_arr_insert['country'] = $price_ret['country'];
                                    } else {
                                        if ($conv_db[0]['charged'] == 0) {
                                            $price_ret = $this->charge_wa_api($chat_id, $this->bot_id, $stat['recipient_id']);
                                            $conv_arr_update['price'] = $price_ret['price'];
                                            $conv_arr_update['country'] = $price_ret['country'];
                                        }
                                        $conv_arr_update['charged'] = 1;

                                    }
                                }
                            }
                        }
                    break;

                    case 'delivered':
                            if($entry_id_change) {
                                if ($this->user_details['entry_point'][$conv_type . '_charge'] == 0) {
                                    $this->user_details['entry_point'][$conv_type . '_charge'] = 1;
                                    if ($this->bot_data['bsp_on'] == 1) {
                                        if (empty($conv_db[0])) {
                                            $price_ret = $this->charge_wa_api($chat_id, $this->bot_id, $stat['recipient_id']);
                                            $conv_arr_insert['charged'] = 1;
                                            $conv_arr_insert['price'] = $price_ret['price'];
                                            $conv_arr_insert['country'] = $price_ret['country'];
                                        } else {
                                            if ($conv_db[0]['charged'] == 0) {
                                                $price_ret = $this->charge_wa_api($chat_id, $this->bot_id, $stat['recipient_id']);
                                                $conv_arr_update['price'] = $price_ret['price'];
                                                $conv_arr_update['country'] = $price_ret['country'];
                                            }
                                            $conv_arr_update['charged'] = 1;

                                        }
                                    }
                                }
                            }
                        $conv_status_id = 2;
                        break;

                    case 'failed':
                        $conv_status_id = 3;
                        break;

                    case 'read':
                        $conv_status_id = 4;
                        break;

                    case 'warning':
                        $conv_status_id = 5;
                        break;

                    case 'deleted':
                        $conv_status_id = 6;
                        break;
                }

                if(isset($conv_arr_insert)){
                    $conv_arr_insert['status'] = $conv_status_id;
                    $this->basic->insert_data("nwa_" . $this->bot_id . "_conversations_stats",$conv_arr_insert);
                }
            if(isset($conv_arr_update)){
                $conv_arr_update['status'] = $conv_status_id;
                $this->basic->update_data("nwa_" . $this->bot_id . "_conversations_stats",array('conv_id '=>$conv_id),$conv_arr_update);
            }
            $this->basic->update_data("nwa_" . $this->bot_id . "_messages",array('mess_id'=>$stat['id']),array('status'=>$conv_status_id));

            //todo: update subs

        }

        if(!empty($response['entry']) AND !empty($response['entry'][0]['changes'][0]['value']['messages'])){

            $display_phone_number = $response['entry'][0]['changes'][0]['value']['metadata']['phone_number_id'];

            $display_phone_number = str_replace(array(' ','+'), '', $display_phone_number);


            $this->bot_data = $this->get_wh_bot_data($display_phone_number);

            if(empty($this->bot_data)){
                //file_put_contents(APPPATH.__LINE__.'_'.time(), json_encode('exit'));
                exit;
            }

            $this->bot_data['lang_selected'] = $this->lang->line('selected');
            $this->bot_data['img_dir'] = base_url().'/upload/wa_bot_'.$this->bot_data['id'];

            $table = 'nwa_'.$this->bot_data['id'].'_user';
            $where = array();
            $total_rows_array = $this->basic->count_row($table, $where, "id");

            $chatbot_uid = $response['entry'][0]['changes'][0]['value']['contacts'][0]['wa_id'];
            $package_info = $this->basic->get_data(
                "users",
                array('where'=>array('users.id'=>$this->bot_data['user_id'])),
                array('package_id','user_type','module_ids','monthly_limit'),
                array('package'=>"package.id=users.package_id,left"),
                1
            );
            if(!isset($package_info[0])) return;
            $monthly_limit = json_decode($package_info[0]['monthly_limit'],true);
            $this->monthly_limit = $monthly_limit;
            $this->bot_admin_is = $package_info[0]['user_type'];
            if($package_info[0]['user_type']!='Admin'){

                if(!isset($monthly_limit[4114])){
                    return;
                }

                if($monthly_limit[4114] <= $total_rows_array[0]['total_rows'] AND $monthly_limit[4114]>0){

                    $table = 'nwa_'.$this->bot_data['id'].'_user';
                    $package_info = $this->basic->get_data(
                        $table,
                        array('where'=>array('id'=>$chatbot_uid)),
                        'id',
                        '',
                        1
                    );

                    if(empty($package_info[0])){
                        return;
                    }
                }

            }
            $this->bot_data['brand_command'] = false;
            if(isset($monthly_limit[4116])){
                $this->bot_data['brand_command'] = true;
                $this->bot_data['brand_text'] = $this->config->item('product_name');
            }

            $this->bot_id = $this->bot_data['id'];

            $this->wa_capi = new WhatsAppCloudApi([
                'from_phone_number_id' => $this->bot_data['wa_id'],
                'access_token' => $this->bot_data['access_token'],
            ]);

            $this->bot_user = $response['entry'][0]['changes'][0]['value']['contacts'][0];
            $this->resp_message = $response['entry'][0]['changes'][0]['value']['messages'][0];


            $name = explode(' ', $this->bot_user['profile']['name']);

            $this->user_details = array(
                'id' => $chatbot_uid,
                'phone' => $chatbot_uid,
                'first_name' => $name[0],
                'username' => $this->bot_user['profile']['name'],
                'last_name' => '',
            );

            if(!empty($name[1])){
                $this->user_details['last_name'] = $name[1];
            }

            $this->user_update();

            $this->UsrBI = $this->getBotUser();
            $this->usrNotes = $this->UsrBI['notes'];

            $this->is_cmd = 0;
            $this->n_command = '';

            if($this->bot_data['bsp_on']){
                if(empty($this->UsrBI['entry_point'])){
                    $this->UsrBI['entry_point'] = array(
                        'category' => 0,
                        'category_id' => null,
                        'category_charge' => 0,

                        'authentication' => 0,
                        'authentication_id' => null,
                        'authentication_charge' => 0,

                        'marketing' => 0,
                        'marketing_id' => null,
                        'marketing_charge' => 0,

                        'utility' => 0,
                        'utility_id' => null,
                        'utility_charge' => 0,

                        'service' => 0,
                        'service_id' => null,
                        'service_charge' => 0,

                        'referral_conversion' => 0,
                        'referral_conversion_id' => null,
                        'referral_conversion_charge' => 0,
                    );
                }else{
                    $this->UsrBI['entry_point'] = json_decode($this->UsrBI['entry_point'], true);
                }

            }


            //debug:
//            $this->sendMessage(json_encode($response));

           if(
               empty($this->resp_message['text'])
               and empty($this->resp_message['interactive'])
               and empty($this->resp_message['image'])
               and empty($this->resp_message['audio'])
           ){
                return $this->message_not_match();
            }

           $this->message = null;
           if(!empty($this->resp_message['text']['body'])){
               $this->message = $this->resp_message['text']['body'];
           }



            if(substr($this->message, 0, 1)=='/'){
                $this->is_cmd = 1;
                $this->n_command = str_replace('/','',$this->message);
            }

            $msg = array(
                'chat_id' => $this->bot_user['wa_id'], //from
                //'id' => '', //(unique message id db)
                'user_id' => $this->bot_user['wa_id'], //sender_id
                'date' => date("Y-m-d H:i:s", $this->resp_message['timestamp']),
                'text' => $this->message,
                'entities' => null, //(button clicked by user (postback))
                'media' => null, //(photo > id | filename)
                'reply_markup' => null //(buttons etc)
            );

            if($this->resp_message['type']=='image'){
                $response = $this->wa_capi->downloadMedia($this->resp_message['image']['id']);
                $reflectionObj = new ReflectionObject($response);

                $headers = $reflectionObj->getProperty('headers');
                $headers->setAccessible(true);
                $contentType = $headers->getValue($response)['Content-Type'][0]; // Extract the content type from headers

                $extension = explode('/', $contentType)[1];

                $wafilename = $this->resp_message['image']['id'].'.'.$extension;

                $body = $reflectionObj->getProperty('body');
                $body->setAccessible(true);
                $bodyContent = $body->getValue($response);

                file_put_contents( FCPATH . '/upload/wa_bot_'.$this->bot_data['id'].$wafilename, $bodyContent);

                $caption = '';
                if(!empty($this->resp_message['image']['caption'])){
                    $caption = $this->resp_message['image']['caption'];
                }
                $msg['media'] = array(array(
                    'url' => base_url('/upload/wa_bot_'.$this->bot_data['id'].$wafilename),
                    'caption' => $caption
                ));
            }

            if($this->resp_message['type']=='audio'){
                $response = $this->wa_capi->downloadMedia($this->resp_message['audio']['id']);
                $reflectionObj = new ReflectionObject($response);

                $headers = $reflectionObj->getProperty('headers');
                $headers->setAccessible(true);
                $contentType = $headers->getValue($response)['Content-Type'][0]; // Extract the content type from headers

                $extension = explode('/', $contentType)[1];

                $wafilename = $this->resp_message['audio']['id'].'.'.$extension;

                $body = $reflectionObj->getProperty('body');
                $body->setAccessible(true);
                $bodyContent = $body->getValue($response);

                file_put_contents( FCPATH . '/upload/wa_bot_'.$this->bot_data['id'].'/'.$wafilename, $bodyContent);

                $msg['media'] = array(array(
                    'audio' => base_url('/upload/wa_bot_'.$this->bot_data['id'].'/'.$wafilename),
                ));
            }

            if(empty($this->message) AND !empty($this->resp_message['interactive']) AND $this->resp_message['interactive']['type']=='button_reply'){
                $msg['text'] = '<a class="btn btn-outline-primary" href="#">'.$this->resp_message['interactive']['button_reply']['title'].'</a>';
            }

            $this->message_insert_db($msg);

            if($this->UsrBI['state_human_agents']==1){
                $this->update_user('state_human_agents_new', 1);
                return true;
            }


            if ($this->n_command == 'whoami' AND $this->bot_data['com_whoami']==1) {
                return $this->whoami();
            }

            if ($this->n_command == 'brand' AND $this->bot_data['brand_command']==true) {
                $msg = 'This bot using: '.$this->bot_data['brand_text'];

                return $this->sendMessage($msg);
            }

            if(!empty($this->n_command)){
                $where = array(
                    'command' => $this->n_command
                );
                $postbacks = $this->get_sql($where);

                if(empty($postbacks)){
                    $return_message = $this->bot_data['bot_command_no_match'];

                    return $this->sendMessage($return_message);
                }else{
                    $this->usrNotes['last_node_id'] = $postbacks['node_id'];
                    $this->updateNotes();

                    return $this->buildMessage($postbacks);
                }
            }


            if(!empty($this->resp_message['interactive']) AND $this->resp_message['interactive']['type']=='button_reply'){
                $button_postback = $this->resp_message['interactive']['button_reply']['id'];

                $data_next = array(
                    'last_node_id' => $this->usrNotes['last_node_id'],
                    'callback' => $button_postback
                );

                $parse = $this->next_callback($data_next);

                if($parse == false){
                    return $this->message_not_match();
                }

                return $parse;
            }

            if(empty($this->usrNotes['userinput'])){
                $this->usrNotes['userinput']='default';
            }

            if(!empty($this->message) AND $this->usrNotes['userinput']=='default'){
                $data_next = array(
                    //'last_node_id' => $this->usrNotes['last_node_id'],
                    'keyword' => $this->message
                );
                return $this->trigger_check($data_next);
            }

            if(!empty($this->message) AND $this->usrNotes['userinput']=='userinput'){
                $data_next = array(
                    'last_node_id' => $this->usrNotes['last_node_id'],
                    'user_response' => $this->message
                );
                return $this->next_step($data_next);
            }

            return $this->message_not_match();
            //get user details [notes]
        }


    }

    private function next_step($data){
        //current node
        $where = 'node_id = '.$data['last_node_id'];
        $parse = $this->get_sql($where);

        if(isset($data['current_step']) AND $data['current_step']==true){
            return $this->parse_message_data($parse);
        }

        if(!empty($parse)){
            $parse_next = json_decode($parse['next_id'], true);
            if(empty($parse_next['number'])){
                //prev node
                $parse_prev = json_decode($parse['prev_id'], true);
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

    private function strposa(string $haystack, array $needles, int $offset = 0): bool
    {
        foreach($needles as $needle) {
            if(strpos($haystack, $needle, $offset) !== false) {
                return true; // stop on first true result
            }
        }

        return false;
    }

    private function trigger_check($data){
        $triggers = $this->get_sql(array('type' => "trigger", 'active'=>1), 0);
        if(empty($triggers)){
            return $this->message_not_match();
        }
        $return_resp = false;
        $return_resp_disabled = false;
        $data['keyword'] = strtolower($data['keyword']);
        foreach($triggers as $k => $v) {
            $p=array();
            //$p['config'] = preg_replace("/[\r\n]+/", " ", $v['config']);
            $p['config'] = str_replace(array("\r", "\n"), array("\\r", "\\n"), $v['config']);
            $p['config'] = json_decode($p['config'], true);
            $p['keyword'] = strtolower($p['config']['keyword']);

            if(empty($p['config']['trigger_action'])){
                $p['config']['trigger_action'] = 'disabled';
            }
            switch ($p['config']['trigger_action']) {
                case 'contains';
                case 'has_value';
                    $keyword_array = explode(',', $p['keyword']);
                    if ($this->strposa($data['keyword'], $keyword_array)) {
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

            return $this->buildMessage($resp);
        }

        if($return_resp==false){
            return $this->message_not_match();
        }

    }

    private function next_callback($data){
        //current node
        $where = 'node_id = '.$data['last_node_id'];
        $parse = $this->get_sql($where);

        if(isset($data['current_step']) AND $data['current_step']==true){
            $this->parse_message_data($parse);
            return true;
        }

        if(!empty($parse)){
            $parse_next = json_decode($parse['next_id'], true);
            if(empty($parse_next[$data['callback']])){
                //prev node
                $parse_prev = json_decode($parse['prev_id'], true);
                if(empty($parse_prev)){
                    return $this->message_not_match();
                }
                $data['last_node_id'] = array_key_first($parse_prev[array_key_first($parse_prev)]);
                return $this->next_callback($data);
            }else{

//                if($this->bot_data['inline_show_selected']==1){
//                    $p['config'] = preg_replace("/[\r\n]+/", " ",$parse['config']);
//                    $p_c = json_decode($p['config'], true);
//
//                    if(!empty($p_c['buttons'])){
//                        foreach($p_c['buttons'] as $k => $v){
//                            if($v['origin_id']==$data['callback']){
//                                $this->send_message('*'.$this->bot_data['lang_selected'].':* '.$v['name']);
//                                break;
//                            }
//                        }
//                    }
//                }

                $data['current_step'] = true;
                $data['last_node_id'] = array_key_first($parse_next[$data['callback']]);
                return $this->next_callback($data);
            }
        }else{
            return $this->message_not_match();
        }
    }

    private function parse_message_data($resp){
        switch($resp['type']){
            case 'trigger';
                break;
            case 'message';
                return $this->buildMessage($resp);
                break;
            case 'condition';
                return $this->condition_check($resp);
                break;
        }
    }

    private function condition_check($resp){
        $pc = preg_replace("/[\r\n]+/", " ",$resp['config']);
        $pc = json_decode($pc, true);

        $result = $this->check_operand($this->message, $pc['keyword'], $pc['trigger_action']);
        if(!$result){
            return $this->message_not_match();
        }

        $parse_next = json_decode($resp['next_id'], true);
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

        $this->sent_plus($resp['id']);
        return $this->next_step($data_next);
    }

    private function check_operand($input, $match, $operand){
        $return_resp = false;
        switch ($operand) {
            case 'contains';
            case 'has_value';
                $keyword_array = explode(',',$match);
                if ($this->strposa($input, $keyword_array)) {
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
            default:
                $return_resp = false;
                break;
        }

        return $return_resp;
    }


//    private function message_not_match(){
//        $from_db = 0;
//
//        if($from_db==1){
//
//            return $this->buildMessage($postback);
//        }else{
//            $return_message = $this->bot_data['bot_mess_no_match'];
//            return $this->sendMessage($return_message);
//        }
//    }

    private function message_not_match(){
        $where = array(
            'type' => "no_match",
            'active' => 1
        );
        $parse = $this->get_sql($where);

        if(!empty($parse)){
            $parse_next = json_decode($parse['next_id'], true);
            if(!empty($parse_next['message'])){
                $callback_id = array_key_first($parse_next['message']);

                $where = 'node_id = '.$callback_id;
                $parse = $this->get_sql($where);

                $this->parse_message_data($parse);
                return true;
            }
        }
        $return_message = $this->bot_data['bot_mess_no_match'];
        return $this->sendMessage($return_message);
    }


    private function get_wh_bot_data($bot_wa_id){
        $bots = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array(
                    'wa_id' => $bot_wa_id
                ),
                '',
                '',
                1
            )
        );

        if(!empty($bots[0])){
            require(APPPATH.'n_wa_cipher.php');
            $bots[0]['access_token'] = openssl_decrypt($bots[0]['access_token'], "AES-128-ECB", $bots[0]['user_id'].$n_tg_config['cipher']);

            $bot_com = $this->basic->get_data('nwa_'.$bots[0]['id'].'_wa_postback',
                array(
                    'where' => array(
                        'active' => 1,
                        'command !=' => ''
                    )
                )
            );

            $bots[0]['all_commands'] = $bot_com;

            $bot_current_version = $bots[0]['db_version'];
            $bot_id = $bots[0]['id'];

            require(APPPATH.'modules/n_wa/include/db_bot_update.php');


            return $bots[0];
        }else{
            return array();
        }


    }

    private function get_bot_data($bot_id){

        $bots = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array(
                    'id' => $bot_id
                ),
                '',
                '',
                1
            )
        );

        if(!empty($bots[0])){
            require(APPPATH.'n_wa_cipher.php');
            $bots[0]['access_token'] = openssl_decrypt($bots[0]['access_token'], "AES-128-ECB", $bots[0]['user_id'].$n_tg_config['cipher']);

            $bot_com = $this->basic->get_data('nwa_'.$bots[0]['id'].'_wa_postback',
                array(
                    'where' => array(
                        'active' => 1,
                        'command !=' => ''
                    )
                )
            );

            $bots[0]['all_commands'] = $bot_com;

            $bot_current_version = $bots[0]['db_version'];
            $bot_id = $bots[0]['id'];

            require(APPPATH.'modules/n_wa/include/db_bot_update.php');

            return $bots[0];
        }else{
            return array();
        }


    }

    private function save_bot_db($dbv, $botid){
        $this->basic->update_data("n_wa_bots",array('id'=>$botid),array('db_version'=>$dbv));
    }

//    public function test_sql(){
//
//        var_dump(is_numeric('+10'));
//
//    }


    public function save_bot_settings($botid_ss = 0){
        $this->csrf_token_check();
        require(APPPATH.'modules/n_wa/include/config.php');

        if(!file_exists(APPPATH.'n_wa_cipher.php')){
            $new_cipher = md5('e0c206d1376c35a2dc973cccb25c3155' . time() . base_url(''));
            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_tg_config['cipher'] = '$new_cipher';\n";
            //$n_tg_config = array_merge();
            $n_tg_config['cipher'] = $new_cipher;
            file_put_contents(APPPATH . 'n_wa_cipher.php', $app_my_config_data, LOCK_EX);
        }else{
            require(APPPATH.'n_wa_cipher.php');
        }

        $bot_business_id = $this->input->post('bot_business_id');
        $bot_access_token = $this->input->post('bot_access_token');
        $bot_id_number = $this->input->post('select_bot_id_number');

        $bsp_access_token = $this->input->post('bsp_access_token');
        $bsp_bot_business_id = $this->input->post('bsp_bot_business_id');

        $bsp_on_form = $this->input->post('bsp_on');

        $bsp_on = 0;
        if(!empty($bsp_access_token)){
            $bot_access_token = $bsp_access_token;
            $bsp_on = 1;
        }

        if($bsp_on_form==1){
            $bsp_on = 1;
        }

        if(!empty($bsp_bot_business_id)){
            $bot_business_id = $bsp_bot_business_id;
        }

        if(empty($bot_business_id) OR empty($bot_access_token)){
            $this->bot_settings($botid_ss, array(
                'alert_type' => 'warning',
                'alert_message' => $this->lang->line('Invalid Access Token or Business ID. Please provide correct token.')
            ));
            return;
        }

        $data = array(
            'bot_business_id' => $bot_business_id,
            'bot_access_token' => $bot_access_token,
            'bot_id_number' => $bot_id_number

        );

        $resp = $this->send_curl('getPhoneNumberInfo', $data);
        $resp = json_decode($resp, true);

        if(isset($resp['status']) AND $resp['status']=='0'){
            if(!empty($resp['message']['alert_message'])){
                $message=$resp['message']['alert_message'];
                $alert_type=$resp['message']['alert_type'];
            }else{
                $message=$resp['message'];
                $alert_type='warning';
            }

            $this->bot_settings($botid_ss, array(
                'alert_type' => $alert_type,
                'alert_message' => $this->lang->line($message)
            ));
            return;
        }



        $botId = $resp['message']['data']['id'];
        $verified_name = $resp['message']['data']['verified_name'];

        $display_phone_number = $resp['message']['data']['display_phone_number'];
        $display_phone_number = str_replace(array(' ','+'), '', $display_phone_number);

        $code_verification_status = $resp['message']['data']['code_verification_status'];
        $quality_rating = $resp['message']['data']['quality_rating'];


        $bots = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array(
                    'wa_id' => $botId
                ),
                '',
                '',
                1
            )
        );

        $db_array = array(
            'user_id' => $this->user_id,
            'active' => 1,

            'business_id' => $bot_business_id,
            'access_token' => openssl_encrypt($bot_access_token, "AES-128-ECB", $this->user_id.$n_tg_config['cipher']),
            'number_phone' => $display_phone_number,
            'bot_name' => $verified_name,
            'com_whoami' => 0,

            'wa_id' => $botId,
            'name' => '',

            'bsp_on' => $bsp_on
        );

        if(!empty($bots[0])){
            if($bots[0]['user_id']==$this->user_id){
                $active = $this->input->post('active');
                $bot_mess_no_match = $this->input->post('bot_mess_no_match');
                $bot_command_no_match = $this->input->post('bot_command_no_match');
                $bot_com_whoami = $this->input->post('bot_whoami');
                $inline_show_selected = $this->input->post('inline_show_selected');
                $is_new = $this->input->post('is_new');

                if($is_new){
                    $this->bot_settings(0, array(
                        'alert_type' => 'danger',
                        'alert_message' => $this->lang->line('Bot already existing in our platform for this phone number.')
                    ));
                    return;
                }

                if(empty($bot_mess_no_match) OR empty($bot_command_no_match)){
                    $this->bot_settings($botid_ss, array(
                        'alert_type' => 'warning',
                        'alert_message' => $this->lang->line('Message no match can`t be empty.')
                    ));
                    return;
                }

                $menu_bot = $this->input->post('group-a');

                if(empty($inline_show_selected)){
                    $inline_show_selected = 0;
                }else{
                    $inline_show_selected = 1;
                }

                if(empty($bot_com_whoami)){
                    $bot_com_whoami = 0;
                }else{
                    $bot_com_whoami = 1;
                }

                $db_array['active'] = $active;
                $db_array['menu_bot'] = json_encode($menu_bot);
                $db_array['bot_command_no_match'] = $bot_command_no_match;
                $db_array['bot_mess_no_match'] = $bot_mess_no_match;
                $db_array['bot_config'] = '';
                $db_array['inline_show_selected'] = $inline_show_selected;
                $db_array['com_whoami'] = $bot_com_whoami;



                $commands = array();

//                if(!empty($menu_bot)){
//                    foreach($menu_bot as $k => $v){
//                        if($v['menu_command']!=''){
//                            $commands[] = array('command' => $v['menu_command'], 'description' => $v['menu_description']);
//                        }
//                    }
//                    if ($this->session->userdata('user_type') != 'Admin' ){
//                        $package = $this->session->userdata['package_info']['monthly_limit'];
//                        $package = json_decode($package, true);
//
//                        if(isset($package[4116])){
//                            $commands[] = array('command' => '/brand', 'description' => $this->config->item('product_name'));
//                        }
//                    }
//
//
//                    $resp = $this->send_curl('set_commands', array(
//                        'tg_api' => $token,
//                        'commands' => $commands));
//                    $resp = json_decode($resp, true);
//
//                    if(isset($resp['status']) AND $resp['status']==0){
//                        if(!empty($resp['message']['alert_message'])){
//                            $message=$resp['message']['alert_message'];
//                            $alert_type=$resp['message']['alert_type'];
//                        }else{
//                            $message=$resp['message'];
//                            $alert_type='warning';
//                        }
//
//                        $this->bot_settings($botid_ss, array(
//                            'alert_type' => $alert_type,
//                            'alert_message' => $this->lang->line($message)
//                        ));
//                        return;
//                    }
//
//                }

                if($bsp_on==1){
                    $data_post_webhook_overdrive = array(
                        "override_callback_uri" => base_url().'n_wa/webhook',
                        "verify_token" => $bots[0]['verify_token'],
                        'bot_business_id' => $bot_business_id,
                        'bot_access_token' => $bot_access_token
                    );

                    $resp = $this->send_curl('subscribed_apps', $data_post_webhook_overdrive);

                    if($n_wa_conf['api_wa_credit_id']!='disabled' AND $bots[0]['allocation_config_id']==0){
                        $data_cl = array(
                            'bot_business_id' => $bot_business_id,
                            'bot_access_token' => $n_wa_conf['system_user_access_token'],
                            'credit_id' => $n_wa_conf['api_wa_credit_id'],
                            'waba_id' => $bot_business_id, //user
                            'waba_currency' => $n_wa_conf['api_wa_currency'],
                        );

                        $resp = $this->send_curl('attach_credit_line', $data_cl);
                        $resp = json_decode($resp);
                        if(!empty($resp['allocation_config_id'])){
                            $db_array['allocation_config_id'] = $resp['allocation_config_id'];
                        }
                    }
                }

                $this->basic->update_data("n_wa_bots",
                    array(
                        "id"=>$bots[0]['id'],
                        "user_id"=>$this->user_id,
                    ),
                    $db_array);


                $this->bot_settings($bots[0]['id'], array(
                    'alert_type' => 'success',
                    'alert_message' => $this->lang->line('Bot configuration saved.')
                ));
            }else{
                $this->bot_settings(0, array(
                    'alert_type' => 'danger',
                    'alert_message' => $this->lang->line('Bot already existing in our platform for this token.')
                ));
            }
        }else{
            if($this->check_bot_limit_usage()){return;}


            $db_array['active'] = 1;

            $db_array['flow_builder'] = '';
            $db_array['menu_bot'] = '';

            $verify_token = md5('time() . e0c206d1376c373cccb25c3155'  . base_url(''));
            $db_array['verify_token'] = $verify_token;
            $db_array['as_bsp'] = 0;

            $db_array['bot_config'] = '';
            $db_array['inline_show_selected'] = 1;



            $db_array['db_version'] = 1;

            $bot_command_no_match = $this->lang->line('Sorry [first_name], Command /[command] not found.. :(');
            $bot_mess_no_match = $this->lang->line('Sorry [first_name], message not found.. :(');

            $db_array['bot_command_no_match'] = $bot_command_no_match;
            $db_array['bot_mess_no_match'] = $bot_mess_no_match;

            if($bsp_on==1){
                $data_post_webhook_overdrive = array(
                    "override_callback_uri" => base_url().'n_wa/webhook',
                    "verify_token" => $verify_token,
                    'bot_business_id' => $bot_business_id,
                    'bot_access_token' => $bot_access_token
                );

                $resp = $this->send_curl('subscribed_apps', $data_post_webhook_overdrive);

                if($n_wa_conf['api_wa_credit_id']!='disabled'){
                    $data_cl = array(
                        'bot_business_id' => $bot_business_id,
                        'bot_access_token' => $n_wa_conf['system_user_access_token'],
                        'credit_id' => $n_wa_conf['api_wa_credit_id'],
                        'waba_id' => $bot_business_id, //user
                        'waba_currency' => $n_wa_conf['api_wa_currency'],
                    );

                    $resp = $this->send_curl('attach_credit_line', $data_cl);
                    $resp = json_decode($resp);
                    if(!empty($resp['allocation_config_id'])){
                        $db_array['allocation_config_id'] = $resp['allocation_config_id'];
                    }
                }
            }

            $this->basic->insert_data("n_wa_bots",$db_array);


            $new_bot_id=$this->db->insert_id();


            require(APPPATH.'modules/n_wa/include/structure.php');

            foreach ($sql_cust as $key => $query){
                try {
                    $this->db->query($query);
                } catch(Exception $e) {
                    echo 'query error: '.$query;
                    var_dump($e->getMessage());
                    exit;
                }
            }



            $this->bot_settings($new_bot_id, array(
                'alert_type' => 'success',
                'alert_message' => $this->lang->line('Bot added successfully.')
            ));

        }
    }



//
//    private function save_config()
//    {
//        if(empty($_POST)){return false;}
//        $this->csrf_token_check();
//
//        $this->form_validation->set_rules('ads_image_size', '<b>' . $this->lang->line("ads_image_size") . '</b>', 'trim');
//        $this->form_validation->set_rules('ads_video_size', '<b>' . $this->lang->line("ads_video_size") . '</b>', 'trim');
//
//        if ($this->form_validation->run() == false) {
//            return false;
//        } else {
//            $ads_image_size = addslashes(strip_tags($this->input->post('ads_image_size', true)));
//            $ads_video_size = addslashes(strip_tags($this->input->post('ads_video_size', true)));
//
//            $app_my_config_data = "<?php \n";
//            $app_my_config_data .= "\$n_ad_config['ads_image_size'] = '$ads_image_size';\n";
//            $app_my_config_data .= "\$n_ad_config['ads_video_size'] = '$ads_video_size';\n";
//
//            file_put_contents(APPPATH . 'n_adsmanager_config.php', $app_my_config_data, LOCK_EX);
//
//            include(APPPATH . 'modules/n_adsmanager/include/default_config.php');
//            $this->n_config = $n_ad_config;
//
//            return true;
//        }
//
//
//    }

    private function get_purchase_code()
    {
        $xdata = $this->basic->get_data("nvx_addons", array("where" => array("name" => 'n_wa')));
        if (!isset($xdata[0])) exit();

        return $xdata[0]['code'];
    }

    public function config(){
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }

        require(APPPATH.'modules/n_wa/include/config.php');

        $data = array();
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'config';
        $data['page_title'] = $this->lang->line('Whatsapp Config');

        $data['bsp_on'] = $n_wa_conf['bsp_on'];

        $data['bsp_config_id'] = $n_wa_conf['bsp_config_id'];
        $data['bsp_on_version'] = $n_wa_conf['bsp_on_version'];


        $data['api_customer_on'] = $n_wa_conf['api_customer_on'];

        $data['data_pricing'] = $this->get_default_pricing();

        $data['api_system_user_access_token'] = $n_wa_conf['api_system_user_access_token'];
        $data['api_wa_id_credit_line'] = $n_wa_conf['api_wa_id_credit_line'];
        $data['api_wa_credit_id'] = $n_wa_conf['api_wa_credit_id'];
        $data['business_id'] = $n_wa_conf['business_id'];
        $data['system_user_access_token'] = $n_wa_conf['system_user_access_token'];
        $data['api_wa_currency'] = $n_wa_conf['api_wa_currency'];

        $data['min_cp_warning_email'] = $n_wa_conf['min_cp_warning_email'];
        $data['min_cp_warning_email_title'] = $n_wa_conf['min_cp_warning_email_title'];
        $data['min_cp_warning_email_text'] = $n_wa_conf['min_cp_warning_email_text'];

        $data['empty_cp_warning_email_title'] = $n_wa_conf['empty_cp_warning_email_title'];
        $data['empty_cp_warning_email_text'] = $n_wa_conf['empty_cp_warning_email_text'];

        if(!empty($_POST)){

            if(!empty($_POST['price'])){
                foreach($_POST['price'] as $k => $v){
                    $data['data_pricing'][$k]['price'] = $v;
                }
            }

            $bsp_on = '';
            if(!empty($_POST['bsp_on'])){
                $bsp_on = 'checked';
            }
            $data['bsp_on'] = $bsp_on;

            $bsp_on_version = '';
            if(!empty($_POST['bsp_on_version'])){
                $bsp_on_version = 'checked';
            }
            $data['bsp_on_version'] = $bsp_on_version;

            $api_customer_on = '';
            if(!empty($_POST['api_customer_on'])){
                $api_customer_on = 'checked';
            }
            $data['api_customer_on'] = $api_customer_on;

            $bsp_config_id = $this->input->get_post('bsp_config_id');

            $api_system_user_access_token = $this->input->get_post('api_system_user_access_token');
            $api_wa_id_credit_line = $this->input->get_post('api_wa_id_credit_line');
            $api_wa_credit_id = $this->input->get_post('api_wa_credit_id');
            $api_wa_system_user_token = $this->input->get_post('system_user_access_token');
            $api_wa_currency = $this->input->get_post('api_wa_currency');

            $min_cp_warning_email = $this->input->get_post('min_cp_warning_email');
            $min_cp_warning_email_title = $this->input->get_post('min_cp_warning_email_title');
            $min_cp_warning_email_text = $this->input->get_post('min_cp_warning_email_text');

            $empty_cp_warning_email_title = $this->input->get_post('empty_cp_warning_email_title');
            $empty_cp_warning_email_text = $this->input->get_post('empty_cp_warning_email_text');


            $from = $this->config->item('institute_email');
            $to = $this->session->userdata('user_login_email');
            $mask = $this->config->item("product_name");
            $html = 1;
            $this->_mail_sender($from, $to, $min_cp_warning_email_title, $min_cp_warning_email_text, $mask, $html);
            $this->_mail_sender($from, $to, $empty_cp_warning_email_title, $empty_cp_warning_email_text, $mask, $html);

            $business_id = $this->input->get_post('business_id');

            if(empty($api_wa_credit_id)){
                $api_wa_credit_id = $this->input->get_post('api_wa_credit_id_hidden');
            }

            $data['api_system_user_access_token'] = $api_system_user_access_token;
            $data['api_wa_id_credit_line'] = $api_wa_id_credit_line;
            $data['api_wa_credit_id'] = $api_wa_credit_id;
            $data['api_wa_system_user_token'] = $api_wa_system_user_token;
            $data['api_wa_currency'] = $api_wa_currency;

            $data['min_cp_warning_email'] = $min_cp_warning_email;
            $data['min_cp_warning_email_title'] = $min_cp_warning_email_title;
            $data['min_cp_warning_email_text'] = $min_cp_warning_email_text;

            $data['empty_cp_warning_email_title'] = $empty_cp_warning_email_title;
            $data['empty_cp_warning_email_text'] = $empty_cp_warning_email_text;

            $data['bsp_on_version'] = $bsp_on_version;
            $data['bsp_config_id'] = $bsp_config_id;


            $data['business_id'] = $business_id;


            $pricing_json = json_encode($data['data_pricing']);

            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_wa_conf['pricing'] = '$pricing_json';\n";

            $app_my_config_data .= "\$n_wa_conf['bsp_on'] = '$bsp_on';\n";
            $app_my_config_data .= "\$n_wa_conf['api_customer_on'] = '$api_customer_on';\n";

            $app_my_config_data .= "\$n_wa_conf['api_system_user_access_token'] = '$api_system_user_access_token';\n";

            if(!empty($api_wa_credit_id) and $api_wa_credit_id!='dont'){
                $app_my_config_data .= "\$n_wa_conf['api_wa_credit_id'] = '$api_wa_credit_id';\n";
            }else{
                $api_key = $n_wa_conf['api_wa_id_credit_line'];
                $app_my_config_data .= "\$n_wa_conf['api_wa_credit_id'] = '$api_key';\n";
            }

            $app_my_config_data .= "\$n_wa_conf['api_wa_id_credit_line'] = '$api_wa_id_credit_line';\n";

            $app_my_config_data .= "\$n_wa_conf['system_user_access_token'] = '$api_wa_system_user_token';\n";
            $app_my_config_data .= "\$n_wa_conf['business_id'] = '$business_id';\n";
            $app_my_config_data .= "\$n_wa_conf['api_wa_currency'] = '$api_wa_currency';\n";

            $app_my_config_data .= "\$n_wa_conf['bsp_on_version'] = '$bsp_on_version';\n";
            $app_my_config_data .= "\$n_wa_conf['bsp_config_id'] = '$bsp_config_id';\n";

            $app_my_config_data .= "\$n_wa_conf['min_cp_warning_email'] = '$min_cp_warning_email';\n";
            $app_my_config_data .= "\$n_wa_conf['min_cp_warning_email_title'] = '$min_cp_warning_email_title';\n";
            $app_my_config_data .= "\$n_wa_conf['min_cp_warning_email_text'] = '$min_cp_warning_email_text';\n";
            $app_my_config_data .= "\$n_wa_conf['empty_cp_warning_email_title'] = '$empty_cp_warning_email_title';\n";
            $app_my_config_data .= "\$n_wa_conf['empty_cp_warning_email_text'] = '$empty_cp_warning_email_text';\n";

            file_put_contents(APPPATH.'modules/n_wa/include/config_local.php', $app_my_config_data);
        }

//        $price = $this->get_mapped_country(substr('671860303', 0, 3));
//        $price = $this->get_default_pricing($price);
//        var_dump($price); exit;

        $this->_viewcontroller($data);
    }

    private function get_default_pricing($code = ''){
        $data_pricing = array();
        require(APPPATH.'modules/n_wa/include/config.php');

        if(!empty($n_wa_conf['pricing'])){
            $n_wa_conf['pricing'] = json_decode($n_wa_conf['pricing'], true);
            $data_pricing = $n_wa_conf['pricing'];
        }else{
            $data_pricing[54] = array(
                'name' => 'Argentina',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0618
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0408
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0367
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0316
                    )
                )
            );
            $data_pricing[55] = array(
                'name' => 'Brazil',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0625
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0350
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0315
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0300
                    )
                )
            );
            $data_pricing[56] = array(
                'name' => 'Chile',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0625
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0350
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0315
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0300
                    )
                )
            );
            $data_pricing[57] = array(
                'name' => 'Colombia',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0125
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0085
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0077
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0060
                    )
                )
            );
            $data_pricing[20] = array(
                'name' => 'Egypt',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.1073
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0687
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0618
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0644
                    )
                )
            );
            $data_pricing[33] = array(
                'name' => 'France',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.1432
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0768
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0691
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0859
                    )
                )
            );
            $data_pricing[49] = array(
                'name' => 'Germany',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.1365
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0853
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0768
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0819
                    )
                )
            );
            $data_pricing[91] = array(
                'name' => 'India',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0099
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0042
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0099 //rate not finalized
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0099 //rate not finalized
                    )
                )
            );
            $data_pricing[62] = array(
                'name' => 'Indonesia',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0411
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0200
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0300
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0190
                    )
                )
            );
            $data_pricing[972] = array(
                'name' => 'Israel',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0353
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0188
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0169
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0180
                    )
                )
            );
            $data_pricing[39] = array(
                'name' => 'Italy',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0691
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0420
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0378
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0386
                    )
                )
            );
            $data_pricing[60] = array(
                'name' => 'Malaysia',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0860
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0200
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0180
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0220
                    )
                )
            );
            $data_pricing[52] = array(
                'name' => 'Mexico',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0436
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0266
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0239
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0105
                    )
                )
            );
            $data_pricing[31] = array(
                'name' => 'Netherlands',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.1597
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0800
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0720
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0891
                    )
                )
            );
            $data_pricing[234] = array(
                'name' => 'Nigeria',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0516
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0319
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0287
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0310
                    )
                )
            );
            $data_pricing[92] = array(
                'name' => 'Pakistan',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0473
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0253
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0228
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0142
                    )
                )
            );
            $data_pricing[51] = array(
                'name' => 'Peru',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0703
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0419
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0377
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0179
                    )
                )
            );
            $data_pricing[7] = array(
                'name' => 'Russia',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0802
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0477
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0429
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0398
                    )
                )
            );
            $data_pricing[966] = array(
                'name' => 'Saudi Arabia',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0406
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0252
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0226
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0195
                    )
                )
            );
            $data_pricing[27] = array(
                'name' => 'South Africa',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0379
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0200
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0180
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0168
                    )
                )
            );
            $data_pricing[34] = array(
                'name' => 'Spain',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0615
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0380
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0342
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0369
                    )
                )
            );
            $data_pricing[90] = array(
                'name' => 'Turkey',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0109
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0093
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0083
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0030
                    )
                )
            );
            $data_pricing[971] = array(
                'name' => 'United Arab Emirates',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0340
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0198
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0178
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0190
                    )
                )
            );
            $data_pricing[44] = array(
                'name' => 'United Kingdom',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0705
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0398
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0358
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0388
                    )
                )
            );
            $data_pricing['NorthAmerica'] = array(
                'name' => 'North America',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0250
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0150
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0135
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0088
                    )
                )
            );
            $data_pricing['Africa'] = array(
                'name' => 'Rest of Africa',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0225
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0160
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0144
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0363
                    )
                )
            );
            $data_pricing['Asia'] = array(
                'name' => 'Rest of Asia Pacific',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0732
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0472
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0425
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0224
                    )
                )
            );
            $data_pricing['CentralEurope'] = array(
                'name' => 'Rest of Central & Eastern Europe',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0860
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0619
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0557
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0250
                    )
                )
            );
            $data_pricing['LatinAmerica'] = array(
                'name' => 'Rest of Latin America',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0740
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0494
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0445
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0423
                    )
                )
            );
            $data_pricing['MiddleEast'] = array(
                'name' => 'Rest of Middle East',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0341
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0198
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0178
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0218
                    )
                )
            );
            $data_pricing['WesternEurope'] = array(
                'name' => 'Rest of Western Europe',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0592
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0420
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0378
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0397
                    )
                )
            );
            $data_pricing['Other'] = array(
                'name' => 'Other',
                'price' => array(
                    'marketing' => array(
                        'cp' => 0,
                        'usd' => 0.0604
                    ),
                    'utility' => array(
                        'cp' => 0,
                        'usd' => 0.0338
                    ),
                    'authentication' => array(
                        'cp' => 0,
                        'usd' => 0.0304
                    ),
                    'service' => array(
                        'cp' => 0,
                        'usd' => 0.0145
                    )
                )
            );
        }

        if(!empty($code)){
            if(isset($data_pricing[$code])){
                return $data_pricing[$code];
            }else{
                return $data_pricing['Other'];
            }
        }
        return $data_pricing;
    }

    private function get_mapped_country($code){
        $data = array(
            '93' => 'Asia',
            '355' => 'CentralEurope',
            '213' => 'Africa',
            '244' => 'Africa',
            '54' => '54',
            '374' => 'CentralEurope',
            '61' => 'Asia',
            '43' => 'WesternEurope',
            '994' => 'CentralEurope',
            '973' => 'MiddleEast',
            '880' => 'Asia',
            '375' => 'CentralEurope',
            '32' => 'WesternEurope',
            '229' => 'Africa',
            '591' => 'LatinAmerica',
            '267' => 'Africa',
            '55' => '55',
            '359' => 'CentralEurope',
            '226' => 'Africa',
            '257' => 'Africa',
            '855' => 'Asia',
            '237' => 'Africa',
            '1' => 'NorthAmerica',
            '235' => 'Africa',
            '56' => '56',
            '86' => 'Asia',
            '57' => '57',
            '506' => 'LatinAmerica',
            '385' => 'CentralEurope',
            '420' => 'CentralEurope',
            '45' => 'WesternEurope',
            '1809' => 'LatinAmerica',
            '1829)' => 'LatinAmerica',
            '1849' => 'LatinAmerica',
            '593' => 'LatinAmerica',
            '20' => '20',
            '503' => 'LatinAmerica',
            '291' => 'Africa',
            '251' => 'Africa',
            '358' => 'WesternEurope',
            '33' => '33',
            '241' => 'Africa',
            '220' => 'Africa',
            '995' => 'CentralEurope',
            '49' => '49',
            '233' => 'Africa',
            '30' => 'CentralEurope',
            '502' => 'LatinAmerica',
            '245' => 'Africa',
            '509' => 'LatinAmerica',
            '504' => 'LatinAmerica',
            '852' => 'Asia',
            '36' => 'CentralEurope',
            '91' => '91',
            '62' => '62',
            '964' => 'MiddleEast',
            '353' => 'WesternEurope',
            '972' => '972',
            '39' => '39',
            '225' => 'Africa',
            '1658' => 'LatinAmerica',
            '1876' => 'LatinAmerica',
            '81' => 'Asia',
            '962' => 'MiddleEast',
            '254' => 'Africa',
            '965' => 'MiddleEast',
            '856' => 'Asia',
            '371' => 'CentralEurope',
            '961' => 'MiddleEast',
            '266' => 'Africa',
            '231' => 'Africa',
            '218' => 'Africa',
            '370' => 'CentralEurope',
            '261' => 'Africa',
            '265' => 'Africa',
            '60' => '60',
            '223' => 'Africa',
            '222' => 'Africa',
            '52' => '52',
            '373' => 'CentralEurope',
            '976' => 'Asia',
            '212' => 'Africa',
            '258' => 'Africa',
            '264' => 'Africa',
            '977' => 'Asia',
            '31' => '31',
            '64' => 'Asia',
            '505' => 'LatinAmerica',
            '227' => 'Africa',
            '234' => '234',
            '389' => 'CentralEurope',
            '47' => 'WesternEurope',
            '968' => 'MiddleEast',
            '92' => '92',
            '507' => 'LatinAmerica',
            '675' => 'Asia',
            '595' => 'LatinAmerica',
            '51' => '51',
            '63' => 'Asia',
            '48' => 'CentralEurope',
            '351' => 'WesternEurope',
            '1787' => 'LatinAmerica',
            '1939' => 'LatinAmerica',
            '974' => 'MiddleEast',
            '242' => 'Africa',
            '40' => 'CentralEurope',
            '7' => '7',
            '250' => 'Africa',
            '966' => '966',
            '221' => 'Africa',
            '381' => 'CentralEurope',
            '232' => 'Africa',
            '65' => 'Asia',
            '421' => 'CentralEurope',
            '386' => 'CentralEurope',
            '252' => 'Africa',
            '27' => '27',
            '211' => 'Africa',
            '34' => '34',
            '94' => 'Asia',
            '249' => 'Africa',
            '268' => 'Africa',
            '46' => 'WesternEurope',
            '41' => 'WesternEurope',
            '886' => 'Asia',
            '992' => 'Asia',
            '255' => 'Africa',
            '66' => 'Asia',
            '228' => 'Africa',
            '216' => 'Africa',
            '90' => '90',
            '993' => 'Asia',
            '256' => 'Africa',
            '380' => 'CentralEurope',
            '971' => '971',
            '44' => '44',
            '1' => 'NorthAmerica',
            '598' => 'LatinAmerica',
            '998' => 'Asia',
            '58' => 'LatinAmerica',
            '84' => 'Asia',
            '967' => 'MiddleEast',
            '260' => 'Africa',
        );

        if(isset($data[$code])){
            return $data[$code];
        }else{
            $new_code = substr($code, 0, -1);
            if(empty($new_code)){
                return 'Other';
            }
            return $this->get_mapped_country($new_code);
        }
    }



    public function api($endpoint, $cust_1 = 0)
    {
        //$this->csrf_token_check();
//        if (!$this->input->is_ajax_request()) {
//            $this->return_json('Bad Request');
//        }

        switch ($endpoint) {
            case 'list_bots';
                $this->list_bots();
                break;

            case 'ajax_label_insert';
                $this->ajax_label_insert();
                break;

            case 'save';
                $this->save();
                break;

            case 'upload_image_message';
                $this->upload_image_message($cust_1);
                break;

            case 'delete_image_message';
                $this->delete_image_message($cust_1);
                break;

            case 'get_phone_numbers';
                $this->get_phone_numbers();
                break;

            case 'delete_bot';
                $this->delete_bot();
                break;

            case 'list_subscribers';
                $this->list_subscribers();
                break;

            case 'livechat_filters_labels';
                $this->livechat_filters_labels();
                break;

            case 'ajax_get_contacts';
                $this->ajax_get_contacts();
                break;

            case 'ajax_get_chat';
                $this->ajax_get_chat();
                break;

            case 'ajax_send_message';
                $this->ajax_send_message();
                break;

            case 'ajax_change_human_status';
                $this->ajax_change_human_status();
                break;

            case 'ajax_send_file';
                $this->ajax_send_file();
                break;

            case 'get_bsp';
                $this->get_bsp();
                break;

            case 'get_credit_line';
                $this->get_credit_line();
                break;

            case 'upload_audio';
                $this->upload_audio($cust_1);
                break;

            case 'delete_audio';
                $this->delete_audio($cust_1);
                break;

            case 'upload_file';
                $this->upload_file($cust_1);
                break;

            case 'delete_file';
                $this->delete_file($cust_1);
                break;

            default;
                $this->return_json('Bad Request');
                break;
        }
    }

    private function upload_file($cust_1){
// Kicks out if not a ajax request
        $this->ajax_check();

        if($this->check_access_bot($cust_1) == false){
            $message = $this->lang->line('Action denied');
            echo json_encode(['error' => $message]);
            exit;
        }

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = FCPATH . '/upload/wa_bot_'.$cust_1;

        // Makes upload directory
        if( ! file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Makes upload directory
        if( ! file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > 5242880) {
                $message = $this->lang->line('The file size exceeds the limit. Allowed size is 5MB. Please remove the file and upload again.');
                echo json_encode(['error' => $message]);
                exit;
            }

            // Holds tmp file
            $tmp_file = $_FILES['file']['tmp_name'];

            if (is_uploaded_file($tmp_file)) {

                $post_fileName = $_FILES['file']['name'];
                $post_fileName_array = explode('.', $post_fileName);
                $ext = array_pop($post_fileName_array);

                $allow_ext = ['doc','docx','pdf','txt','xlx','xlsx'];
                if(! in_array(strtolower($ext), $allow_ext)) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = "telegram_".$this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (! @move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                // Sets filename to session
                $this->session->set_userdata('product_thumb_uploaded_file', $filename);

                // Returns response
                echo json_encode([ 'filename' => $filename]);
            }
        }
    }

    private function delete_file($cust_1)
    {
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        if($this->check_access_bot($cust_1) == false){
            $message = $this->lang->line('Action denied');
            echo json_encode(['error' => $message]);
            exit;
        }

        $upload_dir = FCPATH . '/upload/wa_bot_'.$cust_1;

        // Grabs filename
        $filename = (string) $this->input->post('filename');

        // Prepares file path
        $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;

        // Tries to remove file
        if (file_exists($filepath)) {
            // Deletes file from disk
            unlink($filepath);

            echo json_encode(['deleted' => 'yes']);
            exit();
        }

        echo json_encode(['deleted' => 'no']);
    }

    private function upload_audio($cust_1){
// Kicks out if not a ajax request
        $this->ajax_check();

        if($this->check_access_bot($cust_1) == false){
            $message = $this->lang->line('Action denied');
            echo json_encode(['error' => $message]);
            exit;
        }

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = FCPATH . '/upload/wa_bot_'.$cust_1;

        // Makes upload directory
        if( ! file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Makes upload directory
        if( ! file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > 5242880) {
                $message = $this->lang->line('The file size exceeds the limit. Allowed size is 5MB. Please remove the file and upload again.');
                echo json_encode(['error' => $message]);
                exit;
            }

            // Holds tmp file
            $tmp_file = $_FILES['file']['tmp_name'];

            if (is_uploaded_file($tmp_file)) {

                $post_fileName = $_FILES['file']['name'];
                $post_fileName_array = explode('.', $post_fileName);
                $ext = array_pop($post_fileName_array);

                $allow_ext = ['ogg', 'm4a', 'mp3'];
                if(! in_array(strtolower($ext), $allow_ext)) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = "telegram_".$this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (! @move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                // Sets filename to session
                $this->session->set_userdata('product_thumb_uploaded_file', $filename);

                // Returns response
                echo json_encode([ 'filename' => $filename]);
            }
        }
    }

    private function delete_audio($cust_1)
    {
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        if($this->check_access_bot($cust_1) == false){
            $message = $this->lang->line('Action denied');
            echo json_encode(['error' => $message]);
            exit;
        }

        $upload_dir = FCPATH . '/upload/wa_bot_'.$cust_1;

        // Grabs filename
        $filename = (string) $this->input->post('filename');

        // Prepares file path
        $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;

        // Tries to remove file
        if (file_exists($filepath)) {
            // Deletes file from disk
            unlink($filepath);

            echo json_encode(['deleted' => 'yes']);
            exit();
        }

        echo json_encode(['deleted' => 'no']);
    }


    private function get_credit_line(){
        $this->csrf_token_check();

        if ($this->session->userdata('user_type') != 'Admin') {
            echo json_encode(array('status' => 0)); exit;
        }

        if(!file_exists(APPPATH.'n_wa_cipher.php')){
            $new_cipher = md5('e0c206d1376c35a2dc973cccb25c3155' . time() . base_url(''));
            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_tg_config['cipher'] = '$new_cipher';\n";
            //$n_tg_config = array_merge();
            $n_tg_config['cipher'] = $new_cipher;
            file_put_contents(APPPATH . 'n_wa_cipher.php', $app_my_config_data, LOCK_EX);
        }else{
            require(APPPATH.'n_wa_cipher.php');
        }
        require(APPPATH.'modules/n_wa/include/config.php');

        $data = array(
            'bot_business_id' => $n_wa_conf['business_id'],
            'bot_access_token' => $n_wa_conf['system_user_access_token']
        );

        $resp = $this->send_curl('get_credit_line', $data);
        echo $resp;
    }

    private function get_bsp(){
        $this->csrf_token_check();
        $accessToken = $this->input->post('accessToken', true);

        if(!file_exists(APPPATH.'n_wa_cipher.php')){
            $new_cipher = md5('e0c206d1376c35a2dc973cccb25c3155' . time() . base_url(''));
            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_tg_config['cipher'] = '$new_cipher';\n";
            //$n_tg_config = array_merge();
            $n_tg_config['cipher'] = $new_cipher;
            file_put_contents(APPPATH . 'n_wa_cipher.php', $app_my_config_data, LOCK_EX);
        }else{
            require(APPPATH.'n_wa_cipher.php');
        }

        if(empty($accessToken)){
            $return = array(
                'status' => 0,
                'alert_type' => 'warning',
                'message' => $this->lang->line('Invalid Access Token or Business ID. Please provide correct token.')
            );
            echo json_encode($return);
            return;
        }

        if ($this->user_id != "") {
            $facebook_config = $this->basic->get_data("facebook_rx_config", array("where" => array('status'=>'1')));
            if (isset($facebook_config[0])) {
                $n_app_secret = $facebook_config[0]["api_secret"];
                $n_user_access_token = $facebook_config[0]["user_access_token"];
            }
        }

        require(APPPATH.'modules/n_wa/include/config.php');

        if(!empty($data['bsp_on_version'])){
            //get access token
            //$redirect_uri = urlencode('https://www.facebook.com/connect/login_success.html');
            $redirect_uri = base_url('n_wa/bot_settings');
            //$redirect_uri = urlencode($redirect_uri);
            $capi = $this->get_url("https://graph.facebook.com/v18.0/oauth/access_token?client_id={$facebook_config[0]["api_id"]}&client_secret={$n_app_secret}&code={$accessToken}&redirect_uri={$redirect_uri}");
//        var_dump("https://graph.facebook.com/v18.0/oauth/access_token?client_id={$facebook_config[0]["api_id"]}&client_secret={$n_app_secret}&code={$accessToken}&redirect_uri={$redirect_uri}");
//        var_dump($capi);
            echo json_encode(array(
                'status' => 0,
                'message' => $capi
            ));
            return;
        }



        $data = array(
            'bot_business_id' => $accessToken,
            'bot_access_token' => $n_app_secret
        );



        $resp = $this->send_curl('getBSP', $data);
        echo $resp;
    }

    private function ajax_send_file()
    {
        $this->csrf_token_check();

        $params = $this->input->post('params', true);
        $bot_id = $this->input->post('bot_id', true);
        $chat_id = $this->input->post('chat_id', true);

        if (empty($bot_id)) {
            $this->return_json('error', 'Bad Request');
        }


        //check bot exist and USER ID

        $bot_data = $this->get_bot_data($bot_id);

        if (empty($bot_data)) {
            $this->return_json('error', 'Bad Request');
        }

        if ($bot_data['user_id'] != $this->user_id) {
            $this->return_json('error', 'Something Went Wrong, please try once again.');
        }

        $where = array(
            'user_id' => $this->user_id,
            'id' => $bot_id
        );
        $page_access = $this->basic->get_data("n_wa_bots",
            array("where" => $where),
            '',
            '',
            1
        );
        if (!empty($page_access[0])) {
            $this->bot_id = $bot_id;
            $this->n_command = '';
            $this->bot_data = $this->get_wh_bot_data($page_access[0]['wa_id']);

            $this->wa_capi = new WhatsAppCloudApi([
                'from_phone_number_id' => $this->bot_data['wa_id'],
                'access_token' => $this->bot_data['access_token'],
            ]);

            $this->bot_user = array(
                'wa_id' => $chat_id
            );

            $this->user_details = array('id' => $chat_id);
            $this->user_details = $this->getBotUser();

            //get file

            $upload_dir = FCPATH . '/upload/wa_bot_'.$this->bot_id;

            if( ! file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (isset($_FILES['file'])) {

                $file_size = $_FILES['file']['size'];
                if ($file_size > 5 * 1024 * 1024) {
                    $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                // Holds tmp file
                $tmp_file = $_FILES['file']['tmp_name'];

                if (is_uploaded_file($tmp_file)) {
                    $post_fileName = $_FILES['file']['name'];
                    $post_fileName_array = explode('.', $post_fileName);
                    $ext = array_pop($post_fileName_array);

                    $allow_ext = ['png', 'jpg', 'jpeg', 'mp3', 'aac', 'amr', 'ogg', 'opus'];
                    if (!in_array(strtolower($ext), $allow_ext)) {
                        $message = $this->lang->line('Invalid file type');
                        echo json_encode(['error' => $message]);
                        exit;
                    }

                    $filename = implode('.', $post_fileName_array);
                    $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                    $filename = "sended_file_" . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                    // Moves file to the upload dir
                    $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                    if (!@move_uploaded_file($tmp_file, $dest_file)) {
                        $message = $this->lang->line('That was not a valid upload file.');
                        echo json_encode(['error' => $message]);
                        exit;
                    }

                    $allow_ext = ['png', 'jpg', 'jpeg'];
                    if (in_array(strtolower($ext), $allow_ext)) {
                        $message_send['images'] = array(
                            array(
                                'url' => base_url('/upload/wa_bot_'.$this->bot_id.'/'.$filename),
                                'caption' => ''
                            )
                        );
                    }

                    $allow_ext = ['mp3', 'aac', 'amr', 'ogg', 'opus'];
                    if (in_array(strtolower($ext), $allow_ext)) {
                        $message_send['audio'] = array(
                            array(
                                'url' => base_url('/upload/wa_bot_'.$this->bot_id.'/'.$filename)
                            )
                        );
                    }


                    // Returns response
                    echo json_encode(['filename' => $filename]);
                }
            }else{
                //show error
            }
            return $this->sendMessage($message_send);
        }
    }

    private function ajax_change_human_status(){
        $this->csrf_token_check();

        $params = $this->input->post('params', true);
        $bot_id = $params['bot_id'];
        $chat_id = $params['chat_id'];
        $status = $params['status'];

        if(empty($bot_id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $bot_data = $this->get_bot_data($bot_id);

        if(empty($bot_data)){
            $this->return_json('error','Bad Request');
        }

        if($bot_data['user_id']!=$this->user_id){
            $this->return_json('error','Something Went Wrong, please try once again.');
        }

        $where = array(
            'user_id' => $this->user_id,
            'id' => $bot_id
        );
        $page_access = $this->basic->get_data("n_wa_bots",
            array("where" => $where),
            '',
            '',
            1
        );
        if (!empty($page_access[0])) {

            $this->basic->update_data("nwa_" . $bot_id . "_user",array('id'=>$chat_id),array('state_human_agents'=>$status));

            $data = array(
                'status' => TRUE,
                'message' => $status
            );

            echo json_encode($data);
        }
    }

    private function ajax_send_message()
    {
        $this->csrf_token_check();

        $params = $this->input->post('params', true);
        $bot_id = $params['bot_id'];
        $chat_id = $params['chat_id'];
        $message = $params['message'];

        if (empty($bot_id)) {
            $this->return_json('error', 'Bad Request');
        }


        //check bot exist and USER ID

        $bot_data = $this->get_bot_data($bot_id);

        if (empty($bot_data)) {
            $this->return_json('error', 'Bad Request');
        }

        if ($bot_data['user_id'] != $this->user_id) {
            $this->return_json('error', 'Something Went Wrong, please try once again.');
        }

        $where = array(
            'user_id' => $this->user_id,
            'id' => $bot_id
        );
        $page_access = $this->basic->get_data("n_wa_bots",
            array("where" => $where),
            '',
            '',
            1
        );
        if (!empty($page_access[0])) {
            $this->bot_id = $bot_id;
            $this->n_command = '';
            $this->bot_data = $this->get_wh_bot_data($page_access[0]['wa_id']);

            $this->wa_capi = new WhatsAppCloudApi([
                'from_phone_number_id' => $this->bot_data['wa_id'],
                'access_token' => $this->bot_data['access_token'],
            ]);

            $this->bot_user = array(
                'wa_id' => $chat_id
            );

            $this->user_details = array('id' => $chat_id);
            $this->user_details = $this->getBotUser();

            return $this->sendMessage($message);
        }
    }

    private function ajax_get_chat(){
        $this->csrf_token_check();

        $params = $this->input->post('params', true);
//        if(!empty($params)){
//            $params = json_decode($params, true);
//        }
        $bot_id = $params['bot_id'];
        $chat_id = $params['chat_id'];

        if(empty($bot_id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $bot_data = $this->get_bot_data($bot_id);

        if(empty($bot_data)){
            $this->return_json('error','Bad Request');
        }

        if($bot_data['user_id']!=$this->user_id){
            $this->return_json('error','Something Went Wrong, please try once again.');
        }

        $postbacks_data = array();


        $where = array(
            'user_id' => $this->user_id,
            'id' => $bot_id
        );
        $page_access = $this->basic->get_data("n_wa_bots",
            array("where" => $where),
            '',
            '',
            1
        );
        if (!empty($page_access[0])) {
            $where = array();
            $where['chat_id'] = $chat_id;

            $page_ci_id = $this->basic->get_data("nwa_" . $bot_id . "_messages",
                array("where" => $where),
                '',
                '',
                65,
                '',
                'date DESC'
            );

            if (!empty($page_ci_id)) {
                foreach ($page_ci_id as $k => $v) {
                    $photo = null;

                    $postbacks_data[$v['id']] = array(
                        'user_id' => $v['user_id'],
                        'text' => $v['text'],
                        'date' => $v['date'],
                        'reply_markup' => $v['reply_markup'],
                        'media' => $v['media'],
                    );
                }
            }
        }

        ksort($postbacks_data);

        $this->basic->update_data("nwa_" . $bot_id . "_user",array('id'=>$chat_id),array('state_human_agents_new'=>0));

        $data = array(
            'success' => TRUE,
            'message' => array(
                'data' => $postbacks_data
            )
        );

        echo json_encode($data);
    }

    private function ajax_get_contacts(){
        $this->csrf_token_check();

        $params = $this->input->post('params', true);
//        if(!empty($params)){
//            $params = json_decode($params, true);
//        }
        $bot_id = $params['bot_id'];

        if(empty($bot_id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $bot_data = $this->get_bot_data($bot_id);

        if(empty($bot_data)){
            $this->return_json('error','Bad Request');
        }

        if($bot_data['user_id']!=$this->user_id){
            $this->return_json('error','Something Went Wrong, please try once again.');
        }

        $postbacks_data = array();


        $where = array(
            'user_id' => $this->user_id,
            'id' => $bot_id
        );
        $page_access = $this->basic->get_data("n_wa_bots",
            array("where" => $where),
            '',
            '',
            1
        );
        if (!empty($page_access[0])) {
            $where = array();
            if(!empty($params['label_id']) AND $params['label_id']!='all' AND $params['label_id']!=''){
                $this->db->where('labels like ', '\'%"'.$params['label_id'].'"%\'', false);
            }


            if(!empty($params['state_human_agents']) AND $params['state_human_agents']=='true'){
                $where['state_human_agents']=1;
            }

            if(!empty($params['contact_name_search']) AND strlen($params['contact_name_search'])>=3){
                $this->db->like('first_name', $params['contact_name_search']);
                $this->db->or_like('last_name', $params['contact_name_search']);
            }


            $page_ci_id = $this->basic->get_data("nwa_" . $bot_id . "_user",
                array("where" => $where),
                '',
                '',
                100,
                '',
                'updated_at DESC'
            );

            if (!empty($page_ci_id)) {
                foreach ($page_ci_id as $k => $v) {
                    $postbacks_data[] = array(
                        'name' => $v['first_name'].' '.$v['last_name'],
                        'icon' => $this->getInitials($v['first_name'].' '.$v['last_name']),
                        'id' => $v['id'],
                        'labels' => $v['labels'],
                        'state_human_agent' => $v['state_human_agents'],
                        'state_human_agent_new' => $v['state_human_agents_new']
                    );
                }
            }
        }


        $data = array(
            'success' => TRUE,
            'message' => array(
                'data' => $postbacks_data
            )
        );

        echo json_encode($data);
    }

    private function livechat_filters_labels(){
        $this->csrf_token_check();

        $params = $this->input->post('params', true);
//        if(!empty($params)){
//            $params = json_decode($params, true);
//        }
        $bot_id = $params['bot_id'];

        if(empty($bot_id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $bot_data = $this->get_bot_data($bot_id);

        if(empty($bot_data)){
            $this->return_json('error','Bad Request');
        }

        if($bot_data['user_id']!=$this->user_id){
            $this->return_json('error','Something Went Wrong, please try once again.');
        }

        $postbacks_data = array();
        $postbacks_data[] = array(
            'id' => 'all',
            'text' => $this->lang->line('All')
        );

        $where = array(
            'user_id' => $this->user_id,
            'id' => $bot_id
        );
        $page_access = $this->basic->get_data("n_wa_bots",
            array("where" => $where),
            '',
            '',
            1
        );
        if (!empty($page_access[0])) {
            $where = array();
            if (!empty($search)) {
                $where['label_name'] = '%' . $search . '%';
            }
            $page_ci_id = $this->basic->get_data("nwa_" . $bot_id . "_labels",
                array("where" => $where),
                '',
                '',
                30
            );
            if (!empty($page_ci_id)) {
                foreach ($page_ci_id as $k => $v) {
                    $postbacks_data[] = array(
                        'id' => $v['id'],
                        'text' => $v['label_name']
                    );
                }
            }
        }


        $data = array(
            'success' => TRUE,
            'message' => array(
                'select' => array('data' => $postbacks_data)
            )
        );

        echo json_encode($data);
    }

    private function getInitials($string = null) {
        return array_reduce(
            explode(' ', $string),
            function ($initials, $word) {
                $str = strtoupper(sprintf('%s%s', $initials, substr($word, 0, 1)));
                $str = mb_convert_encoding($str, "UTF-8", "UTF-8");
                return $str;
            },
            ''
        );
    }

    private function delete_bot(){
        $this->csrf_token_check();

        $bot_id = $this->input->post('bot_id');

        if(empty($bot_id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $bot_data = $this->get_bot_data($bot_id);



        if(empty($bot_data)){
            $this->return_json('error','Bad Request');
        }

        if($bot_data['user_id']!=$this->user_id){
            $this->return_json('error','Something Went Wrong, please try once again.');
        }
        $bot_id = $bot_data['id'];

        $tb_array = array(
            'nwa_'.$bot_id.'_labels',
            'nwa_'.$bot_id.'_user',
            'nwa_'.$bot_id.'_wa_postback'
        );

        foreach($tb_array AS $v){
            $sql = 'DROP TABLE IF EXISTS '.$v;
            $this->basic->execute_complex_query($sql);
        }

        if ($this->basic->delete_data('n_wa_bots', array("id" => $bot_data['id']))) {
            $this->return_json(1,'OK');
        } else {
            $this->return_json('error','Something Went Wrong, please try once again.');
        }
    }

    private function get_phone_numbers(){
        $this->csrf_token_check();

        if(!file_exists(APPPATH.'n_wa_cipher.php')){
            $new_cipher = md5('e0c206d1376c35a2dc973cccb25c3155' . time() . base_url(''));
            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_tg_config['cipher'] = '$new_cipher';\n";
            //$n_tg_config = array_merge();
            $n_tg_config['cipher'] = $new_cipher;
            file_put_contents(APPPATH . 'n_wa_cipher.php', $app_my_config_data, LOCK_EX);
        }else{
            require(APPPATH.'n_wa_cipher.php');
        }

        $bot_business_id = $this->input->post('bot_business_id');
        $bot_access_token = $this->input->post('bot_access_token');

        if(empty($bot_business_id) OR empty($bot_access_token)){
            $return = array(
                'status' => 0,
                'alert_type' => 'warning',
                'message' => $this->lang->line('Invalid Access Token or Business ID. Please provide correct token.')
            );
            echo json_encode($return);
            return;
        }

        $data = array(
            'bot_business_id' => $bot_business_id,
            'bot_access_token' => $bot_access_token
        );

        $resp = $this->send_curl('getPhoneNumbers', $data);
        echo $resp;
    }

    private function check_access_bot($bot_id){
        $bots = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array('user_id'=>$this->user_id, 'id'=>$bot_id),
                '',
                '',
                1
            )
        );
        if(empty($bots[0])){
            return false;
        }else{
            return true;
        }
    }

    private function upload_image_message($cust_1){
// Kicks out if not a ajax request
        $this->ajax_check();

        if($this->check_access_bot($cust_1) == false){
            $message = $this->lang->line('Action denied');
            echo json_encode(['error' => $message]);
            exit;
        }

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = FCPATH . '/upload/wa_bot_'.$cust_1;

        // Makes upload directory
        if( ! file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > 1048576) {
                $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
                echo json_encode(['error' => $message]);
                exit;
            }

            // Holds tmp file
            $tmp_file = $_FILES['file']['tmp_name'];

            if (is_uploaded_file($tmp_file)) {

                $post_fileName = $_FILES['file']['name'];
                $post_fileName_array = explode('.', $post_fileName);
                $ext = array_pop($post_fileName_array);

                $allow_ext = ['png', 'jpg', 'jpeg', 'gif'];
                if(! in_array(strtolower($ext), $allow_ext)) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = "wa_".$this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (! @move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                // Sets filename to session
                $this->session->set_userdata('product_thumb_uploaded_file', $filename);

                // Returns response
                echo json_encode([ 'filename' => $filename]);
            }
        }
    }

    private function delete_image_message($cust_1){
// Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        if($this->check_access_bot($cust_1) == false){
            $message = $this->lang->line('Action denied');
            echo json_encode(['error' => $message]);
            exit;
        }


        // Upload dir path
        $upload_dir = FCPATH . '/upload/wa_bot_'.$cust_1;

        // Grabs filename
        $filename = (string) $this->input->post('filename');
        $session_filename = $this->session->userdata('product_thumb_uploaded_file');
        if ($filename !== $session_filename) {
            exit;
        }

        // Prepares file path
        $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;

        // Tries to remove file
        if (file_exists($filepath)) {
            // Deletes file from disk
            unlink($filepath);

            // Clears the file from cache
            clearstatcache();

            // Deletes file from session
            $this->session->unset_userdata('product_thumb_uploaded_file');

            echo json_encode(['deleted' => 'yes']);
            exit();
        }

        echo json_encode(['deleted' => 'no']);
    }

    private function save(){
        $this->ajax_check();
        $this->csrf_token_check();

        $return = array();

        $json = strip_tags(trim($this->input->post("json")));
        $bot_id = strip_tags(trim($this->input->post("bot_id")));

        $bot = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array(
                    'id' => $bot_id,
                    'user_id' => $this->user_id
                ),
                '',
                '',
                1
            )
        );

        if(empty($bot[0])){
            $return['error'] = $this->lang->line("Something wrong.");
        }else{
            $db_array = array(
                'flow_builder' => $json,
            );

            $resp = $this->basic->update_data("n_wa_bots",
                array(
                    "id"=>$bot[0]['id'],
                    "user_id"=>$this->user_id
                ),
                $db_array);

            $this->parse_flow_json($json, $bot[0]);

            if($resp){
                $return['status'] = "ok_alert";
                $return['message'] = $this->lang->line("Flow has been saved successfully.");
            }
        }

        echo json_encode($return);
    }

    private function parse_flow_json($json, $bot){
        $json = json_decode($json, true);

        $bot_current_version = $bot['db_version'];
        $bot_id = $bot['id'];
        require(APPPATH.'modules/n_wa/include/db_bot_update.php');

        $this->basic->update_data("nwa_".$bot['id']."_wa_postback",array(),array('active'=>0));

        $row = array();
        $origin_id = time();
        $row = array();
        foreach($json['nodes'] as $k => $v){
            // ID   |  unique_id as originid   |  keyword   |  command   |  message |

            if(empty($v['data']['origin_id'])){
                $origin_id = $origin_id + 1234;
                $v['data']['origin_id'] = $origin_id;
            }

            switch($v['name']){
                case 'Start';
                    $type_message = 'command';
                    break;
                case 'Send Message';
                    $type_message = 'message';
                    break;
                case 'Trigger';
                    $type_message = 'trigger';
                    break;
                case 'TriggerNoMatch';
                    $type_message = 'no_match';
                    break;
                case 'Condition';
                    $type_message = 'condition';
                    break;
            }

            $next_id = array();

            if(!empty($v['outputs'])){
                foreach($v['outputs'] as $out_k => $out_v){
                    $out_origin_id = str_replace('o-', '', $out_k);

                    foreach($out_v['connections'] as $con_k => $con_v) {
                        $next_id[$out_origin_id][$con_v['node']] = $con_v['input'];
                    }
                }
            }

            $prev_id = array();

            if(!empty($v['inputs'])){
                foreach($v['inputs'] as $in_k => $in_v){
                    $out_origin_id = str_replace('o-', '', $in_k);

                    foreach($in_v['connections'] as $con_k => $con_v) {
                        $con_v['output'] = str_replace('o-', '', $con_v['output']);
                        $prev_id[$out_origin_id][$con_v['node']] = $con_v['output'];
                    }
                }
            }
            $v['json_data'] = str_replace("'", "\'", json_encode($v['data'], JSON_UNESCAPED_UNICODE));
            $v['json_data'] = str_replace('\"', '\\\"', $v['json_data']);
            $v['json_data'] = str_replace(array("\r", "\n"), array("\\\r", "\\\n"), $v['json_data']);

            $row = array(
                'unique_id' => $v['data']['origin_id'],
                'type' => $type_message,
                'keyword' => (empty($v['data']['keyword']) ? '' : $v['data']['keyword'] ),
                'command' => (empty($v['data']['command']) ? '' : $v['data']['command'] ),
                'message' => (empty($v['data']['message']) ? '' : str_replace("'", "\'",$v['data']['message']) ),
                'is_survey' => (empty($v['data']['is_survey']) ? 0 : $v['data']['is_survey'] ),
                'config' => (empty($v['data']) ? '' : $v['json_data'] ),
                'active' => 1,
                'next_id' => json_encode($next_id),
                'prev_id' => json_encode($prev_id),
                'node_id' => $v['id'],
            );

            $sql = "INSERT INTO nwa_".$bot['id']."_wa_postback (
	    		unique_id,
	    		type,
	    		keyword,
	    		command,
	    		message,
	    		is_survey,
	    		config,
	    		active,
	    		next_id,
	    		prev_id,
	    		node_id
			) VALUES (
				'{$row['unique_id']}',
				'{$row['type']}',
				'{$row['keyword']}',
				'{$row['command']}',
				'{$row['message']}',
	    		'{$row['is_survey']}',
	    		'{$row['config']}',
	    		'{$row['active']}',
	    		'{$row['next_id']}',
	    		'{$row['prev_id']}',
	    		'{$row['node_id']}'
			) ON DUPLICATE KEY UPDATE
	    		unique_id='{$row['unique_id']}',
	    		type='{$row['type']}',
	    		keyword='{$row['keyword']}',
	    		command='{$row['command']}',
	    		message='{$row['message']}',
	    		is_survey='{$row['is_survey']}',
	    		config='{$row['config']}',
	    		active='{$row['active']}',
	    		next_id='{$row['next_id']}',
	    		prev_id='{$row['prev_id']}',
	    		node_id='{$row['node_id']}'
	    		; ";
            $this->basic->execute_complex_query($sql);

        }


    }

    public function webhook_info($bot_id){
        if(empty($bot_id)){die('bot id not provided');}
        if ($this->session->userdata('user_type') != 'Admin'){redirect('home/login', 'location');}

        $bot_data = $this->get_bot_data($bot_id);
        if(empty($bot_data)){
            echo 'bot id not found'; exit;
        }


        $parse_data = array();

        $table = 'nwa_'.$bot_data['id'].'_user';
        $where = array();
        $total_rows_array = $this->basic->count_row($table, $where, "id");

        $package_info = $this->basic->get_data(
            "users",
            array('where'=>array('users.id'=>$bot_data['user_id'])),
            array('package_id','user_type','module_ids','monthly_limit'),
            array('package'=>"package.id=users.package_id,left"),
            1
        );
        if(!isset($package_info[0])){
            $package = 'no information. exit';
        }else{
            $package = 'found';
            $monthly_limit = json_decode($package_info[0]['monthly_limit'],true);
        }

        $parse_data['addon_information'] = array(
            'bot_active' => $bot_data['active'],
            'package_limit' => $package,
            'user_type' => $package_info[0]['user_type'],
        );

        if(!empty($monthly_limit)){
            $monthly_limit_desc = 'continue';
            $limit_subs= 'continue';
            if(!isset($monthly_limit[4114])){
                $monthly_limit_desc = 'limit not found. exit';
            }else{
                if($monthly_limit[4114] <= $total_rows_array[0]['total_rows'] AND $monthly_limit[4114]>0){
                    $limit_subs = 'limit subscribers. exit';
                }
            }

            $parse_data['addon_information']['user_details_not_apply_for_admin'] = array(
                'limit 4114' => $monthly_limit_desc,
                'limit 4114 subs' => $limit_subs,
            );
        }

        $bot_data['brand_command'] = 'false';
        if(isset($monthly_limit[4116])){
            $bot_data['brand_command'] = 'true';
            $bot_data['brand_text'] = $this->config->item('product_name');
        }
        $parse_data['addon_information']['bot_brand'] = $bot_data['brand_command'];


        $this->print_r2($parse_data);
    }

    private function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
    }

    private function ajax_label_insert(){
        $this->ajax_check();
        $this->csrf_token_check();

        $return = array();

        $label_name = strip_tags(trim($this->input->post("label_name")));
        $bot_id = strip_tags(trim($this->input->post("bot_id")));

        $bot = $this->basic->get_data('n_wa_bots',
            array(
                'where' => array(
                    'id' => $bot_id,
                    'user_id' => $this->user_id
                ),
                '',
                '',
                1
            )
        );

        if(empty($bot[0])){
            $return['status'] = "0";
            $return['error_message'] = $this->lang->line("Label cant created.");
        }else{
            $inserted_data = array(
                'label_name'=> $label_name,
            );

            if($this->basic->insert_data("nwa_".$bot[0]['id']."_labels",$inserted_data)) {
                $return['status'] = "1";
                $return['message'] = $this->lang->line("Label has been created successfully.");
            }

            $return['labels_data'] = $this->get_labels($bot[0]['id']);

        }


        echo json_encode($return);
    }

    private function get_labels($bot_id){
        $bot = $this->basic->get_data("nwa_".$bot_id."_labels");

        foreach($bot as $k => $v){
            $bot[$k]['text'] = $v['label_name'];
            unset($bot[$k]['label_name']);
        }

        return $bot;
    }

    private function list_bots(){
        $this->ajax_check();
        $search_value = $_POST['search']['value'];
        $display_columns = array('id', 'bot_name', 'subscribers');
        $search_columns = array('bot_name');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'edit_date';

        if($sort=='bot_name'){
            $sort='bot_name';
        }
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by = $sort . " " . $order;

        $where = array();
        if ($search_value != '') {
            $or_where = array();
            foreach ($search_columns as $key => $value)
                $or_where[$value . ' LIKE '] = "%$search_value%";
            $where = array('or_where' => $or_where);
        }
        $where['where'] = array('user_id' => $this->user_id);

        $table = "n_wa_bots";
        $select = array("n_wa_bots.*");
        $info = $this->basic->get_data($table, $where, $select, '', $limit, $start, $order_by, $group_by = '');
        $total_rows_array = $this->basic->count_row($table, $where, $count = $table . ".id", '', $group_by = '');
        $total_result = $total_rows_array[0]['total_rows'];

        //load URL for replace PREVIEW button

        $i = 0;
        $base_url = base_url();
        foreach ($info as $key => $value) {
            $info[$i]['bot_name'] = '<a href="' . $base_url . 'n_wa/bot_settings/' . $value['id'] . '">' . $value['bot_name'] .' ('.$value['number_phone'].')' . '</a> ';

            if($info[$i]['active']==1){
                $info[$i]['name'] .= '<div class="badge badge-success">'.$this->lang->line('active').'</div>';
            }else{
                $info[$i]['name'] .= '<div class="badge badge-danger">'.$this->lang->line('draft').'</div>';
            }

            $info[$i]['bot_name'] .= '<div class="row-actions">

            <span><a href="' . $base_url . 'n_wa/bot_settings/' . $value['id'] . '">'.$this->lang->line('edit').'</a> | </span>
            <span><a href="' . $base_url . 'n_wa/subscriber_manager/' . $value['id'] . '">'.$this->lang->line('Subscribers').'</a> | </span>
            ';
            $info[$i]['bot_name'] .= '<span><a href="' . $base_url . 'n_wa/editor/' . $value['id'] . '">'.$this->lang->line('flow builder').'</a> | </span>';

            $info[$i]['bot_name'] .= '<span><a href="' . $base_url . 'n_wa/livechat/' . $value['id'] . '">'.$this->lang->line('Live chat').'</a> | </span>';

            $info[$i]['bot_name'] .= '<span><a href="#" class="delete_bot" data-id="'.$value['id'].'">'.$this->lang->line('delete').'</a></span>';

            $info[$i]['bot_name'] .= '</div>';

            $info[$i]['subscribers'] = $this->get_count_subscribers($value['id']);

            $i++;
        }


        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns, $start, $primary_key = "id");

        echo json_encode($data);
    }

    public function livechat($bot_id){
        if(empty($bot_id)){
            return;
        }

        $bot_data = $this->get_bot_data($bot_id);
        if(empty($bot_data)){
            $this->view_main();
            return;
        }

        $data = array();



        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'livechat';
        $data['bot_id'] = $bot_id;

        $data['page_title'] = $this->lang->line('Livechat');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');

        //$data['limit_reach'] = $this->check_limit_usage();


        $this->_viewcontroller($data);
    }

    private function list_subscribers(){
        $this->ajax_check();
        $bot_id = $this->input->post('bot_id');

        $search_value = $_POST['search']['value'];
        $display_columns = array('id', 'first_name', 'last_name', 'phone', 'labels','created_at', 'updated_at');
        $search_columns = array('first_name','last_name');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'edit_date';

        if($sort=='first_name'){
            $sort='first_name';
        }
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by = $sort . " " . $order;

        $where = array();
        if ($search_value != '') {
            $or_where = array();
            foreach ($search_columns as $key => $value)
                $or_where[$value . ' LIKE '] = "%$search_value%";
            $where = array('or_where' => $or_where);
        }
        //$where['where'] = array('user_id' => $this->user_id);

        $table = "nwa_".$bot_id.'_user';
        $select = array("*");
        $info = $this->basic->get_data($table, $where, $select, '', $limit, $start, $order_by, $group_by = '');
        $total_rows_array = $this->basic->count_row($table, $where, $count = $table . ".id", '', $group_by = '');
        $total_result = $total_rows_array[0]['total_rows'];

        //load URL for replace PREVIEW button

        $labels =  $this->basic->get_data("nwa_".$bot_id.'_labels', '', '*');
        $labels_parsed = array();

        foreach($labels AS $k => $v){
            $labels_parsed[$v['id']] = $v['label_name'];
        }

        $i = 0;
        $base_url = base_url();
        foreach ($info as $key => $v) {

            if(!empty($v['labels'])){
                $v['labels'] = json_decode($v['labels'], true);
                $new_labels = '';
                foreach($v['labels'] as $ky => $val){
                    $new_labels .= '<span>'.$labels_parsed[$val].' </span>';
                }
                $info[$key]['labels'] = $new_labels;
            }else{
                $info[$key]['labels'] = '';
            }

            $i++;
        }


        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns, $start, $primary_key = "id");

        echo json_encode($data);
    }

    private function get_count_subscribers($id, $period='all'){
        $total_rows_array = $this->basic->count_row('nwa_'.$id.'_user', '', 'id');

        return $total_rows_array[0]['total_rows'];
    }


    private function check_access($id){

        if(!is_numeric($id)){
            return $this->info = array(
                'status' => 'warning',
                'info' => $this->lang->line('Action denied. Not found landing page in your account.')
            );
        }

        $where = array();
        $where['where'] = array(
            'user_id' => $this->user_id,
            'id' => $id
        );
        $table = "n_landing_pages";
        $select = array("n_landing_pages.*");
        $info = $this->basic->get_data($table, $where, $select, '', 1);

        if(empty($info[0])){
            return $this->info = array(
                'status' => 'warning',
                'info' => $this->lang->line('Action denied. Not found landing page in your account.')
            );
        }else{
            return $info[0];
        }
    }


    private function return_json($status, $message = '')
    {
        if (!empty($message)) {
            if (is_array($message)) {
                echo json_encode([
                    'status' => $status,
                    'message' => json_encode($message),
                ]);
            } else {
                echo json_encode([
                    'status' => $status,
                    'message' => $this->lang->line($message),
                ]);
            }

        } else {
            echo json_encode(['error' => $status]);
        }
        exit;
    }

    private function get_url($uri, $token = '', $debug = 0){
        $ch=curl_init($uri);
        //curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:64.0) Gecko/20100101 Firefox/64.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        $response = curl_exec( $ch );
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if($debug == 1){
            ini_set('xdebug.var_display_max_depth', -1);
            ini_set('xdebug.var_display_max_children', -1);
            ini_set('xdebug.var_display_max_data', -1);
            var_dump('------------------------------------------------');
            var_dump($response);
            var_dump($error);
            var_dump('------------------------------------------------');
        }


        if($info['http_code']!=200){
            $this->return_json(0, 'something_wrong');
        }

        return $response;
    }

    private function send_capi($endpoint, $data, $debug = 0)
    {

        $data = json_encode($data);


        $ch = curl_init('https://graph.facebook.com/' . $this->graph_api . '/' . $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:64.0) Gecko/20100101 Firefox/64.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->bot_data['access_token']
            )
        );

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        //$this->wa_capi->sendTextMessage($this->bot_user['wa_id'], $response);

        if ($debug == 1) {
            ini_set('xdebug.var_display_max_depth', -1);
            ini_set('xdebug.var_display_max_children', -1);
            ini_set('xdebug.var_display_max_data', -1);
            var_dump('------------------------------------------------');
            var_dump($response);
            var_dump($error);
            var_dump('------------------------------------------------');
        }


        if ($info['http_code'] != 200) {
            $this->return_json('Something wrong. Please try again later.');
        }


        return $response;
    }

    private function send_curl($endpoint, $data, $debug = 0)
    {
        $data['domain'] = $this->getDomain();
        $data['purchase_code'] = $this->get_purchase_code();
        $data['user_id'] = $this->user_id;



        $data = json_encode($data);

        $ch = curl_init($this->url_api . '/' . $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:64.0) Gecko/20100101 Firefox/64.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($debug == 1) {
            ini_set('xdebug.var_display_max_depth', -1);
            ini_set('xdebug.var_display_max_children', -1);
            ini_set('xdebug.var_display_max_data', -1);
            var_dump('------------------------------------------------');
            var_dump($response);
            var_dump($error);
            var_dump('------------------------------------------------');
        }


        if ($info['http_code'] != 200) {
            $this->return_json('Something wrong. Please try again later.');
        }


        return $response;
    }


    public function fix_menu(){

        if ($this->session->userdata('user_type') != 'Admin' ){ redirect('home/login', 'location'); }

        $sql_cust = "DELETE from `menu_child_1` where url like '%n_wa%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_wa%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%messenger_bot/bot_list%' ")->row_array();
        if(empty($parent_id_to_add)){
            $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%messenger_bot%' ")->row_array();
        }
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'WhatsApp bot', 'fas fa-robot', 'n_wa/', " . $parent_id_to_add['serial'] . ", '4112,4114,4116', '0', '0', '0', '0', '0', '', '0', '0')";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }
        echo 'done';
    }

    public function fix_perm(){

        if ($this->session->userdata('user_type') != 'Admin' ){ redirect('home/login', 'location'); }

        $array_json = '{
   "4112":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"",
      "module_name":"WhatsApp Bot Connected"
   },
   "4114":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"per bot",
      "module_name":"WhatsApp Bot Subscribers limit"
   },
   "4116":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"",
      "module_name":"WhatsApp Bot Platform Brand Name"
   },
   "4118":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"",
      "module_name":"WhatsApp Bot Custom API"
   }
}';

        $array = json_decode($array_json, true);

        $xdata = $this->basic->get_data("add_ons", array("where" => array("unique_name" => 'n_wa')));
        $id_add = $xdata[0]['id'];

        foreach($array as $k => $v){
            $sql_cust = "DELETE from `modules` where id  = ".$k ;
            $this->db->query($sql_cust);

            $sql_cust = "INSERT INTO `modules` (`id`, `module_name`, `add_ons_id`, `extra_text`, `limit_enabled`, `bulk_limit_enabled`, `deleted`) VALUES (".$k.", '".$v['module_name']."', ".$id_add.", '".$v['extra_text']."', '".$v['limit_enabled']."', '".$v['bulk_limit_enabled']."', '0')";
            $this->db->query($sql_cust);
        }

        echo 'done';
    }




    //////core
    public function activate()
    {
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }
        $this->ajax_check();

        $addon_controller_name = ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        $purchase_code = $this->input->post('purchase_code');

        if (empty($purchase_code)) {
            $sql = "project_id = " . $this->product_id;
            $this->db->where($sql);
            $db_data = $this->basic->get_data("nvx_addons");

            if (count($db_data) > 0) {
                $purchase_code = $db_data[0]['code'];
            } else {
                echo json_encode(array('status' => '0', 'message' => $this->lang->line('Add-on purchase code has not been provided.')));
                exit();
            }
        }


        if ($this->nvx_lic($purchase_code) == false) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Purchase code is not valid or already used.')));
            exit();
        }

        //this addon system support 2-level sidebar entry, to make sidebar entry you must provide 2D array like below
        $sidebar = array();
        // mysql raw query needed to run, it's an array, put each query in a seperate index, create table query must should IF NOT EXISTS
        $sql = array
        (
            0 => "CREATE TABLE `n_wa_bots` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL , `active` TINYINT(1) NOT NULL , `as_bsp` TINYINT(1) NOT NULL , `business_id` BIGINT NOT NULL , `access_token` VARCHAR(255) NOT NULL , `verify_token` VARCHAR(255) NOT NULL , `number_phone` INT(15) NOT NULL , `db_version` INT(5) NOT NULL DEFAULT '0' , `flow_builder` LONGTEXT NOT NULL , `bot_mess_no_match` TEXT NOT NULL , `bot_command_no_match` TEXT NOT NULL , `menu_bot` TEXT NOT NULL , `bot_config` TEXT NOT NULL , `inline_show_selected` TINYINT(1) NOT NULL , `bot_name` VARCHAR(255) NOT NULL , `wa_id` BIGINT NOT NULL , `name` INT NOT NULL , INDEX (`user_id`), INDEX (`business_id`), UNIQUE (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;",

            1 => "ALTER TABLE `n_wa_bots` CHANGE `access_token` `access_token` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;",

            2 => "ALTER TABLE `n_wa_bots` CHANGE `number_phone` `number_phone` BIGINT(20) NOT NULL;",

            3 => "ALTER TABLE `n_wa_bots` ADD `com_whoami` INT(1) NOT NULL DEFAULT '0';"

        );

        $sql_cust = "DELETE from `menu_child_1` where url like '%n_wa%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_wa%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%messenger_bot%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'WhatsApp bot', 'fas fa-robot', 'n_wa/', " . $parent_id_to_add['serial'] . ", '4112,4114,4116', '0', '0', '0', '0', '0', '', '0', '0')";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }

        //send blank array if you does not need sidebar entry,send a blank array if your addon does not need any sql to run
        $this->register_addon($addon_controller_name, $sidebar, $sql, $purchase_code);
    }

    public function deactivate()
    {
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }
        echo json_encode(array('status' => '0', 'message' => $this->lang->line('For deactivate addon please use our NVX Addon Manager. Download: https://nvxgroup.com/addon-manager/')));
        exit();
    }

    public function delete()
    {
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }
        $this->ajax_check();

        $addon_controller_name = ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        $add_inf = $this->get_addon_data(APPPATH . 'modules/' . $this->router->fetch_class() . '/controllers/' . $addon_controller_name . '.php');
        if ($add_inf['installed'] == 1) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Please first deactivate addon using our NVX Addon Manager. Download: https://nvxgroup.com/addon-manager/')));
            exit();
        }


        // mysql raw query needed to run, it is an array, put each query in a seperate index, drop table/column query should have IF EXISTS
        $sql = array
        ();

        // deletes add_ons,modules and menu, menu_child1 table ,custom sql as well as module folder, no need to send sql or send blank array if you does not need any sql to run on delete
        $this->delete_addon($addon_controller_name, $sql);
    }

    private function nvx_lic($purchase_code)
    {
        $error = '';
        $param = $this->getParam($purchase_code);
        $response = $this->_request('product/active/' . $this->product_id, $param, $error);

        return $response->status;
    }

    private function encrypt($plainText, $password = '')
    {
        if (empty($password)) {
            $password = $this->key;
        }
        $plainText = rand(10, 99) . $plainText . rand(10, 99);
        $method = 'aes-256-cbc';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $iv = substr(strtoupper(md5($password)), 0, 16);
        return base64_encode(openssl_encrypt($plainText, $method, $key, OPENSSL_RAW_DATA, $iv));
    }

    private function decrypt($encrypted, $password = '')
    {
        if (empty($password)) {
            $password = $this->key;
        }
        $method = 'aes-256-cbc';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $iv = substr(strtoupper(md5($password)), 0, 16);
        $plaintext = openssl_decrypt(base64_decode($encrypted), $method, $key, OPENSSL_RAW_DATA, $iv);
        return substr($plaintext, 2, -2);
    }

    private function processs_response($response)
    {
        $resbk = "";
        if (!empty($response)) {
            if (!empty($this->key)) {
                $resbk = $response;
                $response = $this->decrypt($response);
            }
            $response = json_decode($response);

            if (is_object($response)) {
                return $response;
            } else {
                $response = new stdClass();
                $response->status = false;
                $bkjson = @json_decode($resbk);
                if (!empty($bkjson->msg)) {
                    $response->msg = $bkjson->msg;
                } else {
                    $response->msg = "Response Error, contact with the author or update the plugin or theme";
                }
                $response->data = NULL;
                return $response;

            }
        }
        $response = new stdClass();
        $response->msg = "unknown response";
        $response->status = false;
        $response->data = NULL;

        return $response;
    }

    private function _request($relative_url, $data, &$error = '')
    {
        $response = new stdClass();
        $response->status = false;
        $response->msg = "Empty Response";
        $curl = curl_init();
        $finalData = json_encode($data);
        if (!empty($this->key)) {
            $finalData = $this->encrypt($finalData);
        }
        $url = rtrim($this->server_host, '/') . "/" . ltrim($relative_url, '/');

        //curl when fall back
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $finalData,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "cache-control: no-cache"
            ),
        ));
        $serverResponse = curl_exec($curl);
        //echo $response;
        $error = curl_error($curl);
        curl_close($curl);
        if (!empty($serverResponse)) {
            return $this->processs_response($serverResponse);
        }
        $response->msg = "unknown response";
        $response->status = false;
        $response->data = NULL;
        return $response;
    }

    private function getParam($purchase_key)
    {
        $req = new stdClass();
        $req->license_key = $purchase_key;
        // $req->email        = ! empty( $admin_email ) ? $admin_email : $this->getEmail();
        $req->domain = $this->getDomain();
        $req->app_version = $this->nvx_version;
        $req->product_id = $this->product_id;
        $req->product_base = $this->product_base;

        return $req;
    }

    private function getDomain()
    {
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url .= "://" . $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
        return $base_url;

    }

    private function delete_files($dir)
    {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                @rmdir($file->getRealPath());
            } else {
                @unlink($file->getRealPath());
            }
        }
        @rmdir($dir);
    }


    // BOT WEBHOOK PROCESS

    private function user_update(){
        $row = $this->user_details;
        $time_current = date('Y-m-d H:i:s',time());
        $sql = "INSERT INTO nwa_".$this->bot_id."_user (
	    		id,
	    		first_name,
	    		last_name,
	    		language_code,
	    		created_at,
	    		updated_at,
	    		email,
	    		phone,
	    		address,
	    		current_step,
	    		labels,
	    		npoints,
	    		username
			) VALUES (
				'{$row['id']}',
				'{$row['first_name']}',
				'{$row['last_name']}',
				'',
				'{$time_current}',
				'{$time_current}',
				'',
	    		'{$row['phone']}',
	    		'',
	    		0,
	    		'',
	    		0,
	    		'{$row['username']}'
			) ON DUPLICATE KEY UPDATE
	    		id='{$row['id']}',
	    		first_name='{$row['first_name']}',
	    		last_name='{$row['last_name']}',
	    		updated_at='{$time_current}',
	    		phone='{$row['phone']}',
	    		username='{$row['username']}'
	    		; ";
        $this->basic->execute_complex_query($sql);
    }

    private function whoami(){

        $caption = sprintf(
            'Your Id: %d' . PHP_EOL .
            'Name: %s' . PHP_EOL,
            $this->bot_user['wa_id'],
            $this->bot_user['profile']['name']
        );

        $data = array(
            'text' => $caption
        );

       return $this->sendMessage($data);
    }

    private function sendMessage($message){

        if(!is_array($message)){
            $message = $this->message_hash($message);

            $msg = array(
                'chat_id' => $this->bot_user['wa_id'], //from
                //'id' => '', //(unique message id db)
                'user_id' => $this->bot_data['number_phone'], //sender_id
                'date' => date("Y-m-d H:i:s"),
                'text' => $message,
                'entities' => null, //(button clicked by user (postback))
                'media' => null, //(photo > id | filename)
                'reply_markup' => null //(buttons etc)
            );
            $this->message_insert_db($msg);

            $resp_return = $this->wa_capi->sendTextMessage($this->bot_user['wa_id'], $message);
            //file_put_contents(APPPATH.'logs/'.time().'-fromSM', json_encode($resp_return));
        }else{

            $msg = array(
                'chat_id' => $this->bot_user['wa_id'], //from
                //'id' => '', //(unique message id db)
                'user_id' => $this->bot_data['number_phone'], //sender_id
                'date' => date("Y-m-d H:i:s"),
                'text' => null,
                'entities' => null, //(button clicked by user (postback))
                'media' => null, //(photo > id | filename)
                'reply_markup' => null //(buttons etc)
            );

            if(!empty($message['buttons'])){
                $interactive = array();
                $interactive['type'] = 'button';
                $interactive['body'] = array(
                    'text' => ''
                );

                if(!empty($message['images']) AND count($message['images'])==1){
                    $interactive['header'] = array(
                        'type' => 'image',
                        'image' => array(
                            'link' => $message['images'][0]['url'],
                        )
                    );

                    $interactive['body']['text'] = $message['images'][0]['caption'];

                    $msg['media'] = array(
                        array(
                            'url' => $message['images'][0]['url'],
                            'caption' => $message['images'][0]['caption']
                        )
                    );
                 }

                if(!empty($message['text']) AND !empty($message['buttons'])){
                    $buttons = array();
                    foreach($message['buttons'] as $k => $v){
                        $buttons[] = array(
                            'type' => 'reply',
                            'reply' => array(
                                'id' => $v['origin_id'],
                                'title' => $v['name']
                            )
                        );
                    }

                    $interactive['action'] = array(
                        'buttons' => $buttons
                    );

                    $msg['reply_markup'] = $interactive['action'];


                    $interactive['body']['text'] = $this->message_hash($message['text']);

                    $msg['text'] = $interactive['body']['text'];

                    $request_ar = array(
                        'recipient_type' => 'individual',
                        'to' => $this->bot_user['wa_id'],
                        'type' => 'interactive',
                        'interactive' => $interactive,
                        'messaging_product' => 'whatsapp'
                    );

                    $this->message_insert_db($msg);
                    return $this->send_capi($this->bot_data['wa_id']. '/messages', $request_ar);
                }

            }


            if(!empty($message['images']) AND (count($message['images'])>=1 OR empty($message['text']))){
                foreach($message['images'] as $k => $v) {
                    $msg['media'] = array();
                    $msg['media'][] = $v['url'];
                    $link_id = new LinkID($v['url']);
                    $this->message_insert_db($msg);
                    $this->wa_capi->sendImage($this->bot_user['wa_id'], $link_id, $v['caption']);
                }
            }

            if(is_array($message['audio']) AND (count($message['audio'])>=1 OR empty($message['text']))){
                    foreach($message['audio'] as $k => $v) {
                        $msg['media'] = array();
                        $msg['media'][] = array('audio' => $v['url']);
                        $link_id = new LinkID($v['url']);
                        $this->message_insert_db($msg);
                        $this->wa_capi->sendAudio($this->bot_user['wa_id'], $link_id);
                    }

            }

            if(
                !empty($message['text'])
                AND (
                    (empty($message['images'])
                        OR (
                            !empty($message['images']) AND count($message['images'])>1
                        )
                    )
                    OR empty($message['button'])
                )
            ){
                $message['text'] = $this->message_hash($message['text']);
                $msg['text'] = $message['text'];

                try {
                    $response =  $this->wa_capi->sendTextMessage($this->bot_user['wa_id'], $message['text']);
                    $resp = $response->decodedBody();
                    $msg['status']=1;
                    $msg['mess_id']=$resp['messages'][0]['id'];
                } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                    file_put_contents(APPPATH.'logs/'.time().'-error', json_encode($e->response()));
                }

                $this->message_insert_db($msg);
            }

            if(!empty($message['audio']) AND !is_array($message['audio'])){
                $msg['media'] = array();
                $msg['media'][] = array('audio' => $message['audio']);
                $link_id = new LinkID($message['audio']);
                $this->message_insert_db($msg);
                $this->wa_capi->sendAudio($this->bot_user['wa_id'], $link_id);
            }

            if(!empty($message['file']) AND is_array($message['file'])){
                $msg['media'] = array();
                $msg['media'][] = array('document' => $message['file']);
                $link_id = new LinkID($message['file']['dir']);
                $this->message_insert_db($msg);
                $this->wa_capi->sendDocument($this->bot_user['wa_id'], $link_id,$message['file']['file_name'], $message['file']['caption']);
            }

        }


    }

    private function sent_plus($id){
        $this->db->set('STAT_SENT', 'STAT_SENT+1', FALSE);
        $this->basic->update_data('nwa_'.$this->bot_id.'_wa_postback',array('id'=>$id),array());
    }

    private function buildMessage($postbacks){
        $data = array();

        if($postbacks['active']==0){
            return $this->message_not_match();
        }

        if(empty($postbacks['images'])){$postbacks['images'] = null;}
        if(empty($postbacks['step_action'])){$postbacks['step_action'] = null;}
        if(empty($postbacks['buttons'])){$postbacks['buttons'] = null;}
        if(empty($postbacks['audio'])){$postbacks['audio'] = null;}

        $this->sent_plus($postbacks['id']);

        $postbacks['config'] = preg_replace("/[\r\n]+/", " ",$postbacks['config']);
        $postback_config = json_decode($postbacks['config'], true);

        if(!empty($postback_config['state_human_agent']) AND $postback_config['state_human_agent']==true){
            $this->update_user('state_human_agents_new', 1);
            $this->update_user('state_human_agents', 1);
        }

        if(!empty($postback_config['step_action'])){
            $this->usrNotes['userinput'] = $postback_config['step_action'];
        }

        if(
            empty($postback_config['step_action'])
            AND $postback_config['step_action']!='default'
            AND !empty($notes['userinput'])
        ){
            $this->usrNotes['userinput'] = 'default';
        }

        if(!empty($postback_config['points']) AND is_numeric($postback_config['points'])){
            $this->update_user_cs($postback_config['points']);
        }

        if(!is_array($this->UsrBI['labels'])){
            $this->UsrBI['labels'] = array();
        }

        if(!empty($postback_config['label_add'])){
            $label_add = $postback_config['label_add'];
            if(!empty($label_add)){
                $this->UsrBI['labels'] = array_merge($label_add, $this->UsrBI['labels']);
            }
        }

        if(!empty($postback_config['label_rem'])){
            $label_rem = $postback_config['label_rem'];
            if(!empty($label_rem) AND !empty($user_label)){
                foreach($label_rem as $k => $v){
                    array_splice($user_label, array_search($v, $this->UsrBI['labels']), 1);
                }
            }
        }
        $user_label = array_unique($this->UsrBI['labels']);
        $user_label = json_encode($user_label);
        $this->update_user('labels', $user_label);

        $this->usrNotes['last_node_id'] = $postbacks['node_id'];

        if(is_array($postback_config['images']) AND count($postback_config['images'])>0 ){
            $data['images'] = array();

            foreach($postback_config['images'] as $k => $v) {

                $data['images'][] = array(
                    'url' => $this->bot_data['img_dir'] . '/' . $v['filename'],
                    'caption' => $v['caption']
                );

            }
        }

        if(!empty($postback_config['audio']) AND !is_array($postback_config['audio'])){
            $data['audio'] = $this->bot_data['img_dir'] . '/' . $postback_config['audio'];
        }

        if(!empty($postback_config['file']) AND !is_array($postback_config['file'])){
            $data['file'] = array(
                'file_name' => $postback_config['file'],
                'dir' => $this->bot_data['img_dir'] . '/' . $postback_config['file'],
                'caption' => $postback_config['caption']
            );

        }

        if(empty($postback_config['step_action']) AND $postback_config['step_action']!='default' AND !empty($notes['userinput'])){
            $this->usrNotes['userinput'] = 'default';
        }


        if(is_array($postback_config['buttons']) AND count($postback_config['buttons'])>0){
            $data['buttons'] = $postback_config['buttons'];
        }


        if(!empty($postback_config['ai_reply_on']) AND $postback_config['ai_reply_on']==true){
            if(empty($postback_config['engine_version'])){
                $postback_config['engine_version'] = 'engine_v1';
            }
            $data['text'] = $this->cg_generate($postbacks['message'].' '.$this->message, $postback_config['engine_version']);
            $breaks = array("<br />","<br>","<br/>");
            $data['text'] = str_ireplace($breaks, "\r", $data['text']);
        }else{
            $data['text'] = $postbacks['message'];
        }

        $this->updateNotes();
        $this->sendMessage($data);

        $postbacks_next = json_decode($postbacks['next_id'], true);
        if(!empty($postbacks_next)){
            if(!empty($postbacks_next['number'])){
                $callback_id = array_key_first($postbacks_next['number']);

                $where = 'node_id = '.$callback_id;
                $parse = $this->get_sql($where);


                if(!empty($parse)){
                    $parse_config = json_decode($parse['config'], true);
                    if($parse['type']=='message' and $parse_config['step_action']=='default'){
                        $this->parse_message_data($parse);
                    }
                }
            }
        }
    }

    private function setUsrNotes($key, $val){
        if(empty($this->usrNotes)){

        }
    }


    private function update_user($column, $value){
        $this->basic->update_data('nwa_'.$this->bot_id.'_user',array('id'=>$this->user_details['id']),array($column=>$value));
    }

    private function update_user_cs($value){
        $this->basic->update_data('nwa_'.$this->bot_id.'_user',array('id'=>$this->user_details['id']),array('npoints'=>$value));
    }

    private function message_hash($mess){
        $search = array(
            '[first_name]',
            '[last_name]',
            '[username]',
            '[command]'
        );

        $replace = array(
            $this->user_details['first_name'],
            $this->user_details['last_name'],
            $this->user_details['username'],
            $this->n_command
        );

        return str_replace($search, $replace, $mess);
    }

    private function get_sql($where, $limit = 1 ){
        $sql = $this->basic->get_data('nwa_'.$this->bot_id.'_wa_postback',
            array(
                'where' => $where,
                '',
                '',
                $limit
            )
        );

        if($limit==1){
            if(empty($sql[0])){
                return $sql;
            }
            return $sql[0];
        }else{
            return $sql;
        }
    }

    private function getBotUser(){
        $sql = $this->basic->get_data('nwa_'.$this->bot_id.'_user',
            array(
                'where' => array(
                    'id' => $this->user_details['id']
                ),
                '',
                '',
                1
            )
        );
        
        if(empty($sql[0])){
            return array(
                'notes' => '',

            );
        }

        if($sql[0]['notes']!=''){
            $sql[0]['notes'] = json_decode($sql[0]['notes'], true);
        }else{
            $sql[0]['notes'] = array();
        }

        return $sql[0];
    }

    private function updateNotes(){
        $notes = json_encode($this->usrNotes);

        $this->basic->update_data('nwa_'.$this->bot_id.'_user',array('id'=>$this->user_details['id']),array('notes'=>$notes));
    }


    //content_generator_integration v1.4

    private function calc_tokens($tokens, $engine_type){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/calc_tokens.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/calc_tokens.php');
            return $return_calc_tokens;
        }
    }

    private function get_credits(){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/get_credits.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/get_credits.php');
            return $return_get_credits;
        }
    }

    private function cg_send_curl($endpoint, $data){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/send_curl.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/send_curl.php');
            return $return_resp;
        }
    }

    private function cg_generate($prompt, $engine_version){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/generate.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/generate.php');
            return $return_text;
        }
    }

    private function get_cg_purchase_code(){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/get_purchase_code.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/get_purchase_code.php');
            return $return_cg_code;
        }
    }

    private function charge_wa_api($wa_id, $bot_id, $phone){
        require(APPPATH.'modules/n_wa/include/config.php');

        $code = $this->get_mapped_country(substr($phone, 0, 3));
        $price = $this->get_default_pricing($code);

        $price = $price['price'][$this->conv_type]['cp'];

        $usrID = $this->bot_data['user_id'];
        $usrDB = $this->basic->get_data("users", array("where" => array("id " => $usrID)));

        $from = $this->config->item('institute_email');
        $to = $usrDB[0]['email'];
        $mask = $this->config->item("product_name");
        $html = 1;

        $revoke = false;
        if(!empty($usrDB[0])){
            $credits = $usrDB[0]['n_credits'];
            $new_credits = $credits - $price;

            if($new_credits <= $n_wa_conf['min_cp_warning_email']){
                $this->_mail_sender($from, $to, $n_wa_conf['min_cp_warning_email_title'], $n_wa_conf['min_cp_warning_email_text'], $mask, $html);

                $check_time = time() - $this->bot_data['min_cp_warning_email'];
                if($check_time>=(24*60*60) OR $check_time==0){
                    $this->_mail_sender($from, $to, $n_wa_conf['min_cp_warning_email_title'], $n_wa_conf['min_cp_warning_email_text'], $mask, $html);
                    $this->basic->update_data("n_wa_bots",array('id'=>$this->bot_data['id']),array('min_cp_warning_email'=>time()));
                }
            }

            if($new_credits<=0){
                $revoke = true;
                $check_time = time() - $this->bot_data['empty_cp_warning_email'];
                if($check_time>=(24*60*60) OR $check_time==0){
                    $this->_mail_sender($from, $to, $n_wa_conf['empty_cp_warning_email_title'], $n_wa_conf['empty_cp_warning_email_text'], $mask, $html);
                    $this->basic->update_data("n_wa_bots",array('id'=>$this->bot_data['id']),array('empty_cp_warning_email'=>time()));
                }
            }

            $this->basic->update_data("users",array('id'=>$usrID),array('n_credits'=>$new_credits));
        }

        if($revoke AND $this->bot_data['allocation_config_id']!='0'){
            $data_cl = array(
                'bot_business_id' => $this->bot_data['bot_business_id'],
                'bot_access_token' => $n_wa_conf['system_user_access_token'],
                'credit_id' => $n_wa_conf['api_wa_credit_id'],
                'waba_id' => $this->bot_data['bot_business_id'], //user
                'allocation_config_id' => $this->bot_data['allocation_config_id'],
            );

            $resp = $this->send_curl('revoke_credit_line', $data_cl);

            $this->basic->update_data("n_wa_bots",array('id'=>$this->bot_data['id']),array('allocation_config_id'=>0));
        }

        return array(
            'price' => $price,
            'country' => $code
        );
    }

}