<?php
$min = ($this->n_gen_config['cost_per1k_tokens'] / 2);

    $action_api = 'ai_bot_reply';

    $data = array();
    $data['textarea'] = $prompt;

    $data['language'] = '';
    $data['creativity'] = 0.7;
    $data['tone'] = '';
    $data['textarea_c1'] = '';

    if(isset($this->engine)){
        $data['ai_engine'] = $this->engine;
    }elseif(isset($this->n_gen_config['engine']) and $this->n_gen_config['engine']==1) {
        $data['ai_engine'] = 'gpt4';
    }

    $resp = $this->send_curl($action_api, $data);

    $json_ar = json_decode($resp, true);

    if (!empty($json_ar['status']) and $json_ar['status'] == 'ok') {

        $json_ar['message']['cp_update'] = $this->calc_tokens($json_ar['message']['tokens'], $json_ar['message']['engine_type']);
        unset($json_ar['message']['tokens']);


        $json_ar['message']['text'] = str_replace('Generated text is UNSAFE. This means that the text contains profane language, prejudiced or hateful language, something that could be NSFW, or text that portrays certain groups/people in a harmful manner.', $this->CI->lang->line('Generated text is UNSAFE. This means that the text contains profane language, prejudiced or hateful language, something that could be NSFW, or text that portrays certain groups/people in a harmful manner.'), $json_ar['message']['text']);

        $return_text = $json_ar['message']['text'];
    }else{
        $return_text = $json_ar;
    }


