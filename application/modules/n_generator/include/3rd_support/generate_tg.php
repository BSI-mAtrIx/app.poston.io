<?php
$min = ($this->n_gen_config['cost_per1k_tokens'] / 2);

$return_text = '';
if ($this->get_credits() <= $min) {
    $text = "You don't have enough CreditsPoints";
    $return_text = $text;
}

    $action_api = 'ai_bot_reply';

    $data = array();
    $data['textarea'] = $prompt;

    $data['language'] = '';
    $data['creativity'] = 0.7;
    $data['tone'] = '';
    $data['textarea_c1'] = '';

    if(!empty($engine_version)){
        switch($engine_version){
            case 'engine_v2':
                $data['ai_engine'] = 'gpt-3.5-turbo';
                break;
            case 'engine_v3':
                $data['ai_engine'] = 'gpt4';
                break;
            case 'engine_v1':
            default:
                $data['ai_engine'] = 'text-davinci-003';
                break;
        }
    }else{
        if(isset($this->n_gen_config['engine']) and $this->n_gen_config['engine']==1) {
            $data['ai_engine'] = 'gpt4';
        }
    }

    $resp = $this->cg_send_curl($action_api, $data);

    $json_ar = json_decode($resp, true);


    if (!empty($json_ar['status']) and $json_ar['status'] == 'ok') {

        $json_ar['message']['cp_update'] = $this->calc_tokens($json_ar['message']['tokens'], $json_ar['message']['engine_type']);
        unset($json_ar['message']['tokens']);


        $json_ar['message']['text'] = str_replace('Generated text is UNSAFE. This means that the text contains profane language, prejudiced or hateful language, something that could be NSFW, or text that portrays certain groups/people in a harmful manner.', 'Generated text is UNSAFE. This means that the text contains profane language, prejudiced or hateful language, something that could be NSFW, or text that portrays certain groups/people in a harmful manner.', $json_ar['message']['text']);

        $return_text = $json_ar['message']['text'];
    }else{
        $return_text = $json_ar;
    }


