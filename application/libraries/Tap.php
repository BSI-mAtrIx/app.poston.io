<?php
class Tap{

	public $amount;
	public $currency="USD";
	public $action_url;
	public $config_data;
	
	public function __construct(){
		
		$this->CI =& get_instance();
		$this->CI->load->database();

		$query = $this->CI->db->get('payment_config');
		$this->config_data = $query->result_array();
			
		$databae_name= $this->CI->db->database;
	}
	
    public function payment($amount, $user_id, $package_id, $first_name="", $email="")
    {
        $payment = [
            "amount" => round($amount, 2),
            "description" =>  'Hello, please pay and confirm your order Thanks For made order.',
            "currency" => $this->currency,
            "receipt" => [
                "email" => true,
                "sms" => true
            ],
            "customer"=> [
                "first_name"=> $first_name,
                "email"=> $email,
            ],
            "source"=> [
                "id"=> "src_card"
            ],
            "redirect"=> [
                "url"=> site_url()."payment/tap_callback/".$user_id.'/'.$package_id
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
            "authorization: Bearer " . $this->config_data[0]['tap_secret_api_key'], // SECRET API KEY
            "content-type: application/json"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response);

        return redirect($response->transaction->url, 'refresh');
    }
    
    function set_button($user_id, $package_id){
        
		$button ="
		<a href='" . site_url() . "/payment/tap_payment/".$this->amount."/".$user_id."/".$package_id."' style='background: #12181f;' class='list-group-item list-group-item-action flex-column align-items-start'>
		    <div class='w-70 align-items-center' >
		      <small class='text-muted'><img class='rounded' loading='lazy' style='margin: 0px auto;width: fit-content;display: block;' width='60' height='60' src='https://websiteimages.b-cdn.net/tap_logo.svg'></small>
		    </div>
		</a>";
		
		return $button;
	
	}

    public function callback($input_id)
    {
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
                "authorization: Bearer " . $this->config_data[0]['tap_secret_api_key'] // SECRET API KEY
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $responseTap = json_decode($response);
        
        if ($responseTap->response->code != '000') {
            $redirect_url=base_url()."payment/transaction_log?action=cancel";
			redirect($redirect_url, 'refresh');
			exit();
        }
        
        return $responseTap;
        // if ($responseTap->status == 'CAPTURED') {
            
        //     // return redirect()->route('tap.form')->with('success','Payment Successfully Made.');
        // }

        // return redirect()->route('tap.form')->with('error','Something Went Wrong.');
    }
}
