<?php

class Openai_api{

    function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->helper('my_helper');
        $this->CI->load->library('session');
        $this->CI->load->model('basic');


        if (file_exists(APPPATH . 'n_generator_config.php')) {
            include(APPPATH . 'n_generator_config.php');
            $this->n_gen_config = $n_gen_config;
        }

    }

    public function open_ai_completion($api_key,$prompt,$model="text-davinci-003",$max_tokens=1500,$instruction="AI Agent",$description="description in the flow",$human,$user_id){
        $text_completion_model=array("text-davinci-003", "text-davinci-002", "text-curie-001", "text-babbage-001",
            "text-ada-001", "davinci", "curie", "babbage", "ada");

        $chat_completion_model=array("gpt-4", "gpt-4-0314", "gpt-4-32k", "gpt-4-32k-0314", "gpt-3.5-turbo", "gpt-3.5-turbo-0301");

        $this->engine_type="text";
        $this->engine = $model;

        if(in_array($model,$text_completion_model)){
            $this->engine_type="text";
        }elseif(in_array($model,$chat_completion_model)){
            $this->engine_type="chat";
        }

        if(empty($this->CI->user_id)){
            $this->CI->user_id = $user_id;
        }
        $p_key = $this->get_purchase_code();

        $this->api_key = openssl_decrypt($this->n_gen_config['openai_api'],"AES-128-ECB", 'nstok-'.$p_key);

        $min = ($this->n_gen_config['cost_per1k_tokens'] / 2);
        if ($this->get_credits() <= $min) {
            $oai_return['choices'][0]['text'] = $this->CI->lang->line("Something Wrong: Error ".__LINE__);
            return $this->oai_return($oai_return);
        }

        $prompt = str_replace(array(
            'Human :', 'AI:'
        ), array(
            ' Human:', ' AI:'
        ), $prompt);

        if($this->api_key=='nvx_backend'){

            $return_text = $this->generate($prompt);

            if(!empty($return_text['error'])){
                $return_text = $return_text['error'];
            }

            $oai_return = array(
                'choices' => array(
                    0 => array(
                        'text' => str_replace('<br />', "\r", $return_text)
                    )
                )
            );

            return $this->oai_return($oai_return);

        }else{
            $system_content=$instruction.".".$description;
            return $this->open_ai_direct($prompt, $system_content, $human, $max_tokens);
        }

    }

    private function open_ai_direct($prompt, $system_content, $human, $max_tokens){
        $oai_return = array(
            'choices' => array(
                0 => array(
                    'text' => ''
                )
            )
        );

        if($this->engine_type=='text'){
            $request_body = [
                "prompt" => $prompt,
                "max_tokens" => $max_tokens,
                "temperature" => 0.4, //creativity
                "top_p" => 1,
                "presence_penalty" => 0.6,
                "frequency_penalty"=> 0,
                "best_of"=> 1,
                "stream" => false,
                "user" => $this->CI->user_id
            ];

            $endpoint = '/v1/engines/'.$this->engine.'/completions';
        }else{
            $request_body = [
                "model" => $this->engine,
                "max_tokens" => $max_tokens,
                "temperature" => 0.4, //creativity
                "top_p" => 1,
                "presence_penalty" => 0.6,
                "frequency_penalty"=> 0,
                "stream" => false,
                "user" => $this->CI->user_id,
                "messages" => array(
                    array(
                        "role"=>"system",
                        "content"=>$system_content
                    ),
                    array(
                        "role"=>"user",
                        "content"=>$human
                    )
                )
            ];

            $endpoint = '/v1/chat/completions';
        }

        $oai_return_curl = $this->oai_send_curl($request_body, $endpoint);

        if(is_array($oai_return_curl) AND $oai_return_curl['status']==0){
            $oai_return['choices'][0]['text'] = $oai_return_curl['message'];
            return $this->oai_return($oai_return);
        }

        $json_array = json_decode($oai_return_curl, true);

        if(!empty($json_array['error'])){
            $oai_return['choices'][0]['text'] = 'OpenAI: '.$json_array['error']['message'];
            return $this->oai_return($oai_return);
        }


        if($this->engine_type=="text"){
            $response_text = $json_array['choices'][0]['text'];
        }else{
            $response_text = $json_array['choices'][0]['message']['content'];
        }
        $oai_return['choices'][0]['text'] = $response_text;



        $this->calc_tokens($json_array['usage'], $this->engine_type);


        $request_body = [
            "prompt" => "<|endoftext|>".$response_text."\n--\nLabel:",
            "max_tokens" => 1,
            "temperature" => 0, //creativity
            "top_p" => 0,
            "logprobs" => 10,
            "stream" => false,
            "frequency_penalty"=>0,
            "presence_penalty"=>0,
            "user" => $this->CI->user_id.'_'.time()
        ];

        $cf_return = $this->oai_send_curl($request_body, '/v1/engines/content-filter-alpha/completions');

        if(is_array($cf_return) AND $cf_return['status']==0){
            $oai_return['choices'][0]['text'] = $cf_return['message'];
            return $this->oai_return($oai_return);
        }

        $json2_array = json_decode($cf_return, true);

        //$json_array["choices"][0]["text"] = $json_array["choices"][0]["text"];

        if($json2_array["choices"][0]["text"]){
            $oai_return['choices'][0]['text'] = $this->CI->lang->line("Generated text is UNSAFE. Please try again");
        }

        return $this->oai_return($oai_return); //$oai_return['choices'][0]['text']
    }

    private function oai_return($oai_return){
        $oai_return['choices'][0]['text'] = $oai_return['choices'][0]['text'];

        return json_encode($oai_return);
    }

    private function oai_send_curl($request_body, $endpoint){
        $headers=array("Content-Type: application/json","Authorization: Bearer {$this->api_key}");

        $postfields = json_encode($request_body);

        $url="https://api.openai.com".$endpoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postfields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        $err = curl_error($ch);


        if ($err) {
            return array("status"=>0,"message"=>$err);
        } else {
            return $result;
        }
    }

    private function calc_tokens($tokens, $engine_type){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/calc_tokens.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/calc_tokens.php');
            return $return_calc_tokens;
        }
    }

    private function get_credits(){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/get_credits.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/get_credits.php');
            return $return_get_credits;
        }
    }

    private function cg_generate($prompt){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/generate.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/generate.php');
            return $return_text;
        }
    }

    private function get_purchase_code(){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/get_purchase_code.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/get_purchase_code.php');
            return $return_cg_code;
        }
    }

    private function generate($prompt){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/generate.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/generate.php');
            return $return_text;
        }
    }

    private function send_curl($action_api, $data){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/send_curl.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/ai_reply/send_curl.php');
            return $return_resp;
        }
    }

    private function get_domain(){
        if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/getDomain.php')){
            include(APPPATH.'modules/n_generator/include/3rd_support/getDomain.php');
            return $base_url;
        }
    }

    private function _insert_usage_log($module_id=0,$usage_count=0,$user_id=0){

        if($module_id==0 || $usage_count==0) return false;
        if($user_id==0) $user_id=$this->CI->user_id;
        if($user_id==0 || $user_id=="") return false;

        $usage_month=date("n");
        $usage_year=date("Y");
        $where=array("module_id"=>$module_id,"user_id"=>$user_id,"usage_month"=>$usage_month,"usage_year"=>$usage_year);

        $insert_data=array("module_id"=>$module_id,"user_id"=>$user_id,"usage_month"=>$usage_month,"usage_year"=>$usage_year,"usage_count"=>$usage_count);

        if($this->CI->basic->is_exist("usage_log",$where))
        {
            $this->CI->db->set('usage_count', 'usage_count+'.$usage_count, FALSE);
            $this->CI->db->where($where);
            $this->CI->db->update('usage_log');
        }
        else $this->CI->basic->insert_data("usage_log",$insert_data);

        return true;
    }

    private function _check_usage($module_id=0,$request=0,$user_id=0){
        if($module_id==0 || $request==0) return "0";
        if($user_id==0) $user_id=$this->CI->user_id;
        if($user_id==0 || $user_id=="") return false;

        if($this->CI->basic->is_exist("modules",array("id"=>$module_id,"extra_text"=>""),"id")) // not monthly limit modules
        {
            $this->CI->db->select_sum('usage_count');
            $this->CI->db->where('user_id', $user_id);
            $this->CI->db->where('module_id', $module_id);
            $info = $this->CI->db->get('usage_log')->result_array();

            $usage_count=0;
            if(isset($info[0]["usage_count"]))
                $usage_count=$info[0]["usage_count"];
        }
        else
        {
            $usage_month=date("n");
            $usage_year=date("Y");
            $info=$this->CI->basic->get_data(
                "usage_log",
                $where=array("where"=>array("usage_month"=>$usage_month,"usage_year"=>$usage_year,"module_id"=>$module_id,"user_id"=>$user_id)
                ), '', '',  1
            );
            $usage_count=0;
            if(isset($info[0]["usage_count"]))
                $usage_count=$info[0]["usage_count"];
        }



        $monthly_limit=array();
        $bulk_limit=array();
        $module_ids=array();


        $package_data = $this->CI->basic->get_data("users", $where=array("where"=>array("users.id"=>$user_id)),"package.*,users.user_type",array('package'=>"users.package_id=package.id,left"), 1);
        $package_info=array();
        if(array_key_exists(0, $package_data))
            $package_info=$package_data[0];
        if($package_info['user_type'] == 'Admin') return "1";


        if(isset($package_info["bulk_limit"]))    $bulk_limit=json_decode($package_info["bulk_limit"],true);
        if(isset($package_info["monthly_limit"])) $monthly_limit=json_decode($package_info["monthly_limit"],true);
        if(isset($package_info["module_ids"]))    $module_ids=explode(',', $package_info["module_ids"]);

        $return = "0";
        if(in_array($module_id, $module_ids) && $bulk_limit[$module_id] > 0 && $bulk_limit[$module_id]<$request)
            $return = "2"; // bulk limit crossed | 0 means unlimited
        else if(in_array($module_id, $module_ids) && $monthly_limit[$module_id] > 0 && $monthly_limit[$module_id]<($request+$usage_count))
            $return = "3"; // montly limit crossed | 0 means unlimited
        else  $return = "1"; //success

        return $return;
    }
}