<?php
$data['ai_key'] = $this->n_gen_config['openai_api'] ;
$data['domain'] = $this->get_domain();
$data['purchase_code'] = $this->get_purchase_code();
$data['user_id'] = $this->CI->user_id.'_'.time();


$data = json_encode($data);

$ch = curl_init('https://api.nvxgroup.com/ContentgeneratorV6/api' . '/' . $action_api);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:64.0) Gecko/20100101 Firefox/64.0');
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
$response = curl_exec($ch);
$info = curl_getinfo($ch);
$error = curl_error($ch);
curl_close($ch);


if ($info['http_code'] != 200) {
    $return_resp = $this->CI->lang->line('Something wrong. Please try again later. SC_24');
}

$return_resp = $response;