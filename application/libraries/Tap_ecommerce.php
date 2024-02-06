<?php
class Tap_ecommerce{

	public $amount;
	public $currency="USD";
	public $action_url;
	public $first_name;
	public $last_name;
	public $email;
	public $config_data;
	public $store_id;
	public $CI;
	
	public function __construct(){
		
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		//$this->store_id = $store_id;
		
			
		$databae_name= $this->CI->db->database;
	}
	
    public function payment($tap_secret_api_key, $amount, $user_id, $first_name, $last_name, $email, $store_id, $cart_id, $subscriber_id, $payment_amount, $currency, $store_name)
    {
		
		// $query = $this->CI->db->get('ecommerce_config', array("where" => array("store_id" => $store_id)));
		// $config_data = $query->result_array();
		
        $payment = [
            "amount" => round($amount, 2),
            "description" =>  'Hello, please pay and confirm your order Thanks For made order.',
            "currency" => $currency,
            "receipt" => [
                "email" => true,
                "sms" => true
            ],
            "customer"=> [
                "first_name"=> $first_name,
                "last_name"=> $last_name,
                "email"=> $email,
            ],
            "source"=> [
                "id"=> "src_card"
            ],
            "redirect"=> [
                "url"=> site_url()."ecommerce/tap_callback/".$tap_secret_api_key."/".$store_id.'/'.$cart_id.'/'.$subscriber_id.'/'.$payment_amount.'/'.$currency.'/'.urlencode($store_name)
            ]
        ];
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.tap.company/v2/charges",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($payment),
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . $tap_secret_api_key, // SECRET API KEY
            "content-type: application/json"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response);
		//print_r($response);
        return redirect($response->transaction->url, 'refresh');
    }
    
    function set_button($tap_secret_api_key, $user_id,$store_id, $cart_id, $subscriber_id, $payment_amount, $currency, $store_name){
        
		$button ="
		<a id='tap_clone' href='" . site_url() . "ecommerce/tap_payment_ecommerce/".$tap_secret_api_key."/".$this->amount."/".$user_id."/".$this->first_name."/".$this->last_name."/".$this->email."/".$store_id.'/'.$cart_id.'/'.$subscriber_id.'/'.$payment_amount.'/'.$currency.'/'.urlencode($store_name)."' style='background: #12181f;' class='list-group-item list-group-item-action flex-column align-items-start'>
		    <div class='w-70 align-items-center' >
		      <small class='text-muted'><img class='rounded' loading='lazy' style='margin: 0px auto;width: fit-content;display: block;' width='60' height='60' src='".base_url('assets/img/payment/tap_logo.svg')."'></small>
		    </div>
		</a>";
		
		return $button;
	
	}

    public function callback($input_id, $tap_secret_api_key)
    {
		// $query = $this->CI->db->get('ecommerce_config', array("where" => array("store_id" => $store_id)));
		// $this->config_data = $query->result_array();
		
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.tap.company/v2/charges/".$input_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{}",
        CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $tap_secret_api_key // SECRET API KEY
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $responseTap = json_decode($response);
        
        return $responseTap;
        // if ($responseTap->status == 'CAPTURED') {
            
        //     // return redirect()->route('tap.form')->with('success','Payment Successfully Made.');
        // }

        // return redirect()->route('tap.form')->with('error','Something Went Wrong.');
    }
}
