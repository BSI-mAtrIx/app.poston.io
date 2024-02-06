<?php
/*
Addon Name: Mashkar Order
Unique Name: n_mashkar
Project ID: 3099
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.05
Description: Mashkar Order
*/
require_once("application/controllers/Home.php"); // loading home controller

class N_mashkar extends Home
{
    public $key = "271E0A66E9504ED6";
    private $product_id = "33";
    private $product_base = "n_mashkar";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
	private $nvx_version = 1.05;
	/* @var self*/
    private static $selfobj=null;
    public $fb;


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

        $function_name=$this->uri->segment(2);
        if($function_name!="webhook")  //todo: cronjob
        {
             // all addon must be login protected
              //------------------------------------------------------------------------------------------
              if ($this->session->userdata('logged_in')!= 1) redirect('home/login', 'location');          
              // if you want the addon to be accessed by admin and member who has permission to this addon
              //-------------------------------------------------------------------------------------------

                   if($this->session->userdata('user_type') != 'Admin' && !in_array(268,$this->module_access) )
                    {
                        redirect('home/login_page', 'location');
                        exit();
                    }

        }
        $this->load->library('encryption');

        $addon_lang = 'n_mashkar';
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

        include(FCPATH . 'application/n_views/config.php');
        $this->nconfig = $n_config;

    }
    
    
    public function index()
    {
        if ($this->session->userdata('logged_in') != 1) exit();
        
        if ($this->session->userdata('user_type') != 'Admin' && !in_array(268, $this->module_access))
            redirect('home/login_page', 'location');

        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'main_view';
        $data['page_title'] = $this->lang->line('page title');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');

        $this->_viewcontroller($data);
    }

    public function integration($store_id=0)
    {

        if(empty($store_id)){
            redirect('home/login_page', 'location');
        }

        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'integration';
        $data['page_title'] = $this->lang->line('Mashkor Integration');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');
        $data["iframe"] = "1";

        $data_mash = $this->basic->get_data('ecommerce_store',
            array(
                'where' => array(
                    'id' => $store_id,
                    'user_id' => $this->user_id
                ),
                '',
                '',
                1
            )
        );

        $data["mash_conf"] = '';
        $data["n_store_id"] = $store_id;

        if(!empty($data_mash[0]['mashkor'])){
            $data["mash_conf"] = json_decode($data_mash[0]['mashkor'], true);
        }else{
            //redirect('home/login_page', 'location');
        }


        if (!empty($_POST)) {
            //$this->form_validation->set_rules('auth_key', $this->lang->line('Authorization key'), 'required');
            $this->form_validation->set_rules('google_api', $this->lang->line('Google API Key Website restriction'), 'required');
            $this->form_validation->set_rules('google_api_2', $this->lang->line('Google API Key Server side'), 'required');
            //$this->form_validation->set_rules('x_api_key', $this->lang->line('x-api-key'), 'required');
            $this->form_validation->set_rules('branch_id', $this->lang->line('Branch ID'), 'required');
            $this->form_validation->set_rules('sandbox', $this->lang->line('Sandbox enabled'));
//            $this->form_validation->set_rules('price_5', $this->lang->line('0-5 km'), 'required');
//            $this->form_validation->set_rules('price_8', $this->lang->line('5-8 km'), 'required');
//            $this->form_validation->set_rules('price_1km', $this->lang->line('8+ km'), 'required');
            $this->form_validation->set_rules('customer_name', $this->lang->line('Pickup name'), 'required');
            $this->form_validation->set_rules('paci_number', $this->lang->line('PACI number'));
            $this->form_validation->set_rules('mobile_number', $this->lang->line('Mobile Number'), 'required');
            $this->form_validation->set_rules('latitude', $this->lang->line('latitude'), 'required');
            $this->form_validation->set_rules('longitude', $this->lang->line('longitude'), 'required');
            $this->form_validation->set_rules('area', $this->lang->line('Pick up area'), 'required');
            $this->form_validation->set_rules('block', $this->lang->line('Block'), 'required');
            $this->form_validation->set_rules('street', $this->lang->line('Street'), 'required');
            $this->form_validation->set_rules('building', $this->lang->line('Building (optional)'));
            $this->form_validation->set_rules('landmark', $this->lang->line('Landmark (optional)'));
            $this->form_validation->set_rules('address', $this->lang->line('address'));

            if ($this->form_validation->run() == false){
                unset($_POST);
                return $this->integration($store_id);
        } else {
            $auth_key = strip_tags($this->input->post('auth_key'));
            $x_api_key = strip_tags($this->input->post('x_api_key'));
            $branch_id = strip_tags($this->input->post('branch_id'));
            $sandbox = strip_tags($this->input->post('sandbox'));
            $google_api = strip_tags($this->input->post('google_api'));
            $google_api_2 = strip_tags($this->input->post('google_api_2'));
            $price_5 = strip_tags($this->input->post('price_5'));
            $price_8 = strip_tags($this->input->post('price_8'));
            $price_1km = strip_tags($this->input->post('price_1km'));
            $customer_name = strip_tags($this->input->post('customer_name'));
            $paci_number = strip_tags($this->input->post('paci_number'));
            $mobile_number = strip_tags($this->input->post('mobile_number'));
            $latitude = strip_tags($this->input->post('latitude'));
            $longitude = strip_tags($this->input->post('longitude'));
            $area = strip_tags($this->input->post('area'));
            $block = strip_tags($this->input->post('block'));
            $street = strip_tags($this->input->post('street'));
            $building = strip_tags($this->input->post('building'));
            $landmark = strip_tags($this->input->post('landmark'));
            $address = strip_tags($this->input->post('address'));

            $save_db = array(
                'config' => array(
                    'auth_key' => $auth_key,
                    'x_api_key' => $x_api_key,
                    'branch_id' => $branch_id,
                    'sandbox' => $sandbox,
                    'google_api' => $google_api,
                    'google_api_2' => $google_api_2,
                ),
                'price' => array(
                    'price_5' => $price_5,
                    'price_8' => $price_8,
                    'price_1km' => $price_1km
                ),
                'pickup' => array(
                    'customer_name' => $customer_name,
                    'paci_number' => $paci_number,
                    'mobile_number' => $mobile_number,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'area' => $area,
                    'block' => $block,
                    'street' => $street,
                    'building' => $building,
                    'landmark' => $landmark,
                    'address' => $address
                )
            );

            $update_store = array('mashkor' => json_encode($save_db));

            $check = $this->basic->update_data("ecommerce_store", array("id" => $store_id), $update_store);

            $data["mash_conf"] = $save_db;
        }
    }


        unset($_POST);
        $this->_viewcontroller($data);
    }

    public function get_order_details(){
        $this->ajax_check();
        $this->csrf_token_check();

        $ecom_check = $this->basic->get_data('ecommerce_store',
            array(
                'where' => array(
                    'id' => $this->session->userdata("ecommerce_selected_store"),
                    'user_id' => $this->user_id
                ),
                '',
                '',
                1
            )
        );

        if(empty($ecom_check[0])){
            $this->return_json(0, 'You dont have access to this resource');
        }

        $cart_id = $this->input->post('cart_id');
        $cart_data = $this->basic->get_data("ecommerce_cart", array("where" => array("id" => $cart_id)));

        if(!empty($cart_data[0])){
            $cart_data = $cart_data[0];
            $buyer_first_name = isset($cart_data['buyer_first_name']) ? $cart_data['buyer_first_name'] : '';
            $buyer_last_name = isset($cart_data['buyer_last_name']) ? $cart_data['buyer_last_name'] : '';
            $buyer_email = isset($cart_data['buyer_email']) ? $cart_data['buyer_email'] : '';
            $buyer_mobile = isset($cart_data['buyer_mobile']) ? $cart_data['buyer_mobile'] : '';
            $buyer_country = isset($cart_data['buyer_country']) ? $cart_data['buyer_country'] : '-';
            $buyer_state = isset($cart_data['buyer_state']) ? $cart_data['buyer_state'] : '-';
            $buyer_city = isset($cart_data['buyer_city']) ? $cart_data['buyer_city'] : '-';
            $buyer_address = isset($cart_data['buyer_address']) ? $cart_data['buyer_address'] : '-';
            $buyer_zip = isset($cart_data['buyer_zip']) ? $cart_data['buyer_zip'] : '-';


            if (empty($buyer_first_name)) $buyer_first_name = isset($cart_data['bill_email']) ? $cart_data['bill_email'] : '';
            if (empty($buyer_last_name)) $buyer_last_name = isset($cart_data['bill_mobile']) ? $cart_data['bill_mobile'] : '';
            if (empty($buyer_email)) $buyer_email = isset($cart_data['bill_email']) ? $cart_data['bill_email'] : '';
            if (empty($buyer_mobile)) $buyer_mobile = isset($cart_data['bill_mobile']) ? $cart_data['bill_mobile'] : '';
            if (empty($buyer_country)) $buyer_country = isset($cart_data['bill_email']) ? $cart_data['bill_email'] : '';
            if (empty($buyer_state)) $buyer_state = isset($cart_data['bill_mobile']) ? $cart_data['bill_mobile'] : '';
            if (empty($buyer_city)) $buyer_city = isset($cart_data['bill_email']) ? $cart_data['bill_email'] : '';
            if (empty($buyer_address)) $buyer_address = isset($cart_data['bill_mobile']) ? $cart_data['bill_mobile'] : '';
            if (empty($buyer_zip)) $buyer_zip = isset($cart_data['bill_mobile']) ? $cart_data['bill_mobile'] : '';

            $payment_amount = isset($cart_data['payment_amount']) ? $cart_data['payment_amount'] : 0;
            $payment_method = isset($cart_data['payment_method']) ? $cart_data['payment_method'] : "Cash on Delivery";

            $mashkor_details = json_decode($cart_data['mashkor_details'], true);

            if(!is_array($mashkor_details)){
                $mashkor_details = array(
                    'lat' => '',
                    'lng' => ''
                );
            }

            $return_data = array(
                'first_name' => $buyer_first_name,
                'last_name' => $buyer_last_name,
                'email' => $buyer_email,
                'mobile' => $buyer_mobile,
                'country' => $buyer_country,
                'state' => $buyer_state,
                'city' => $buyer_city,
                'address' => $buyer_address,
                'zip' => $buyer_zip,
                'payment_amount' => $payment_amount,
                'payment_method' => $payment_method,
                'mashkor_type' => $cart_data['mashkor_delivery'],
                'lat' => $mashkor_details['lat'],
                'lng' => $mashkor_details['lng'],
                'vendor_id' => $cart_data['id'],
                'mashkor' => $mashkor_details
            );


            $this->return_json(1, $return_data);

        }else{
            //show error js
        }
    }

    public function create_order(){
        $this->ajax_check();
        $this->csrf_token_check();

        $ecom_check = $this->basic->get_data('ecommerce_store',
            array(
                'where' => array(
                    'id' => $this->session->userdata("ecommerce_selected_store"),
                    'user_id' => $this->user_id
                ),
                '',
                '',
                1
            )
        );

        if(empty($ecom_check[0]['mashkor'])){
            $this->return_json(0, 'Mashkor details is empty');
        }else{
            $mash_conf = json_decode($ecom_check[0]['mashkor'], true);
        }

        if(empty($ecom_check[0])){
            $this->return_json(0, 'You dont have access to this resource');
        }

        $post_cart_id = $this->input->post('cart_id');
        $mashkor_type = $this->input->post('mashkor_type');
        $customer_name = $this->input->post('customer_name');
        $mobile_number = $this->input->post('mobile_number');
        $amount_to_collect = $this->input->post('amount_to_collect');
        $vendor_order_id = $this->input->post('vendor_order_id');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $landmark = $this->input->post('landmark');
        $area = $this->input->post('area');
        $block = $this->input->post('block');
        $street = $this->input->post('street');
        $building = $this->input->post('building');
        $room_number = $this->input->post('room_number');

        $data = array(
            "branch_id" => $mash_conf['config']['branch_id'],
            "customer_name" => $customer_name,
            "payment_type" => $mashkor_type,
            "mobile_number" => $mobile_number,
            "amount_to_collect" => $amount_to_collect, "vendor_order_id" => $vendor_order_id,
            "pick_up" => array(
                "customer_name" => $mash_conf['pickup']['customer_name'],
                "paci_number" => $mash_conf['pickup']['paci_number'],
                "mobile_number" => $mash_conf['pickup']['mobile_number'],
                "latitude" => $mash_conf['pickup']['latitude'],
                "longitude" => $mash_conf['pickup']['longitude'],
                "area" => $mash_conf['pickup']['area'],
                "block" => $mash_conf['pickup']['block'],
                "street" => $mash_conf['pickup']['street'],
                "building" => $mash_conf['pickup']['building'],
                "landmark" => $mash_conf['pickup']['landmark'],
                "address" => $mash_conf['pickup']['address']
            ),
            "drop_off" => array(
                "paci_number" => "",
                "latitude" => $latitude,
                "longitude" => $longitude,
                "landmark" => $landmark,
                "area" => $area,
                "block" => $block,
                "street" => $street,
                "building" => $building,
                "floor" => "",
                "room_number" => $room_number,
                "address" => ""
            )
        );

        $ch = curl_init();

        $sanbox_url = 'https://kw-ppd-api-services.mashkor.com/v1/b/ig/order/create';
        $live_url = 'https://kw-api-services.mashkor.com/v1/b/ig/order/create';

        curl_setopt($ch, CURLOPT_URL, $live_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->nconfig['mashkor_auth_key'],
            "x-api-key: ".$this->nconfig['mashkor_api_key']
        ));

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        $resp = json_decode($response,true);

        if($info['http_code']!=200 && $info['http_code']!=201 && $info['http_code']!=0){
            if(!empty($resp['message'])){
                $this->return_json(0, $resp['message']);
            }
            $this->return_json(0, $response);
        }

        $update_data = array(
            'mashkor_id' =>  $resp['data']['order_number'],
            'mashkor_status' => 0,
            'status' => 'approved'
        );

        $this->basic->update_data("ecommerce_cart",
            array("id"=>$post_cart_id),
            $update_data);

        $this->return_json(1, $this->lang->line('Order created in Mashkor'));
    }

    public function webhook(){
        $response_raw=file_get_contents("php://input");
        if(!isset($response_raw) || $response_raw=='') exit;

        $response = json_decode($response_raw, true);

        if(!empty($response['vendor_order_id'])){
            $update_data = array(
                'mashkor_status' => $response['order_status']
            );

            if($response['order_status']==4 OR $response['order_status']==5){
                $update_data['status'] = 'shipped';
            }

            if($response['order_status']==10){
                $update_data['status'] = 'delivered';
            }

            if($response['order_status']==11){
                $update_data['status'] = 'rejected';
            }

            $this->basic->update_data("ecommerce_cart",
                array(
                    "id"=>$response['vendor_order_id'],
                    "mashkor_id"=>$response['order_number']

                ),
                $update_data);
        }
    }

    public function test_mashkor(){
        $this->ajax_check();
        $this->csrf_token_check();

        $ecom_check = $this->basic->get_data('ecommerce_store',
            array(
                'where' => array(
                    'id' => $this->session->userdata("ecommerce_selected_store"),
                    'user_id' => $this->user_id
                ),
                '',
                '',
                1
            )
        );

        if(empty($ecom_check[0]['mashkor'])){
            $this->return_json(0, 'Mashkor details is empty');
        }else{
            $mash_conf = json_decode($ecom_check[0]['mashkor'], true);
        }

        $test_dsitance = 7;

        $ch = curl_init();

        $sandbox_url = 'https://kw-ppd-api-services.mashkor.com/v1/b/ig/get-distance-based-delivery-fee-estimate';
        $live_url = 'https://kw-api-services.mashkor.com/v1/b/ig/get-distance-based-delivery-fee-estimate';


        curl_setopt($ch, CURLOPT_URL, $live_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);

        $check_auth = array(
            'branch_id' => $mash_conf['config']['branch_id'],
            'distance' => $test_dsitance
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($check_auth));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$this->nconfig['mashkor_auth_key'],
            "x-api-key: ".$this->nconfig['mashkor_api_key']
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response,true);

        if(!empty($response['message'])){
            $this->return_json(0, $this->lang->line('Test API Mashkor is Failed. API return: ').json_encode($response));
        }else{
            $this->return_json(1, $this->lang->line('Test API Mashkor is Passed.').json_encode($response));
        }


    }



    private function return_json($status, $message = '')
    {
        if (!empty($message)) {
            if (is_array($message)) {
                echo json_encode([
                    'status' => $status,
                    'message' => $message,
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

    
    
    //////core do not touch
    public function activate()
    {
        $this->ajax_check();

        $addon_controller_name=ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        $purchase_code=$this->input->post('purchase_code');

        if(empty($purchase_code)){
            $sql = "project_id = ".$this->product_id;
            $this->db->where($sql);
            $db_data = $this->basic->get_data("nvx_addons");

            if(count($db_data) > 0) {
                $purchase_code = $db_data[0]['code']; 
            }else{
                echo json_encode(array('status'=>'0','message'=>$this->lang->line('Add-on purchase code has not been provided.')));
                exit();
            }
        }


          if($this->nvx_lic($purchase_code)==false){
                echo json_encode(array('status'=>'0','message'=>$this->lang->line('Purchase code is not valid or already used.')));
                exit();
          }
          
        //this addon system support 2-level sidebar entry, to make sidebar entry you must provide 2D array like below
         $sidebar=array();
        // mysql raw query needed to run, it's an array, put each query in a seperate index, create table query must should IF NOT EXISTS
        $sql=array
        (

        );

        $menu_exists = $this->db->query(" SELECT id FROM `menu_child_1` where url LIKE '%n_igposter%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT parent_id, serial FROM `menu_child_1` where url LIKE '%ultrapost%' ")->row_array();
        if(!$menu_exists){
            try{
                $sql_cust = "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'Instagram Statistics', 'fa fa-signal', 'n_igposter/', ".($parent_id_to_add['serial']+1).", '3009', '0', '1', '0', '0', '0', '0', ".$parent_id_to_add['parent_id'].");" ;
                $this->db->query($sql_cust);
            }catch(Exception $e){

            }
        }
        
        //send blank array if you does not need sidebar entry,send a blank array if your addon does not need any sql to run
        $this->register_addon($addon_controller_name,$sidebar,$sql,$purchase_code);
    }

    public function deactivate(){        
        echo json_encode(array('status'=>'0','message'=>$this->lang->line('For deactivate addon please use our NVX Addon Manager. Download: https://nvxgroup.com/addon-manager/')));
        exit();   
    }
    
    public function delete(){        
        $this->ajax_check();

        $addon_controller_name=ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        $add_inf = $this->get_addon_data(APPPATH.'modules/'.$this->router->fetch_class().'/controllers/'.$addon_controller_name.'.php');
        if($add_inf['installed']==1){
            echo json_encode(array('status'=>'0','message'=>$this->lang->line('Please first deactivate addon using our NVX Addon Manager. Download: https://nvxgroup.com/addon-manager/')));
            exit();   
        }
        
        
        // mysql raw query needed to run, it is an array, put each query in a seperate index, drop table/column query should have IF EXISTS
        $sql=array
        (
          0 => "DELETE from `menu` where module_access = 3009",
        );  
        
        // deletes add_ons,modules and menu, menu_child1 table ,custom sql as well as module folder, no need to send sql or send blank array if you does not need any sql to run on delete
        $this->delete_addon($addon_controller_name,$sql);         
    }
    
    private function nvx_lic($purchase_code){
        $error = '';
        $param    = $this->getParam( $purchase_code );
        $response = $this->_request( 'product/active/'.$this->product_id, $param, $error );

        return $response->status;
    }
    
    private function encrypt($plainText,$password='') {
        if(empty($password)){
            $password=$this->key;
        }
        $plainText=rand(10,99).$plainText.rand(10,99);
        $method = 'aes-256-cbc';
        $key = substr( hash( 'sha256', $password, true ), 0, 32 );
        $iv = substr(strtoupper(md5($password)),0,16);
        return base64_encode( openssl_encrypt( $plainText, $method, $key, OPENSSL_RAW_DATA, $iv ) );
    }
    
    private function decrypt($encrypted,$password='') {
        if(empty($password)){
      		$password=$this->key;
      	}
        $method = 'aes-256-cbc';
        $key = substr( hash( 'sha256', $password, true ), 0, 32 );
        $iv = substr(strtoupper(md5($password)),0,16);
        $plaintext=openssl_decrypt( base64_decode( $encrypted ), $method, $key, OPENSSL_RAW_DATA, $iv );
        return substr($plaintext,2,-2);
    }
    
    private function processs_response($response){
        $resbk="";
          if ( ! empty( $response ) ) {
              if ( ! empty( $this->key ) ) {
                $resbk=$response;
                  $response = $this->decrypt( $response );
              }
              $response = json_decode( $response );

              if ( is_object( $response ) ) {
                  return $response;
              } else {
                $response=new stdClass();
                $response->status = false;
                $bkjson=@json_decode($resbk);
                if(!empty($bkjson->msg)){
                    $response->msg    = $bkjson->msg;
                }else{
                    $response->msg    = "Response Error, contact with the author or update the plugin or theme";
                }
                  $response->data = NULL;
                  return $response;

              }
          }
          $response=new stdClass();
          $response->msg    = "unknown response";
          $response->status = false;
          $response->data = NULL;

          return $response;
    }
    
    private function _request( $relative_url, $data, &$error = '' ) {
        $response         = new stdClass();
        $response->status = false;
        $response->msg    = "Empty Response";
        $curl             = curl_init();
        $finalData        = json_encode( $data );
        if ( ! empty( $this->key ) ) {
            $finalData = $this->encrypt( $finalData );
        }
        $url = rtrim( $this->server_host, '/' ) . "/" . ltrim( $relative_url, '/' );

        //curl when fall back
        curl_setopt_array( $curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $finalData,
            CURLOPT_HTTPHEADER     => array(
                "Content-Type: text/plain",
                "cache-control: no-cache"
            ),
        ) );
        $serverResponse = curl_exec( $curl );
        //echo $response;
        $error = curl_error( $curl );
        curl_close( $curl );
        if ( ! empty( $serverResponse ) ) {
            return $this->processs_response($serverResponse);
        }
        $response->msg    = "unknown response";
        $response->status = false;
        $response->data = NULL;
        return $response;
    }

    private function getParam( $purchase_key ) {
        $req               = new stdClass();
        $req->license_key  = $purchase_key;
        // $req->email        = ! empty( $admin_email ) ? $admin_email : $this->getEmail();
        $req->domain       = $this->getDomain();
        $req->app_version  = $this->nvx_version;
        $req->product_id   = $this->product_id;
        $req->product_base = $this->product_base;

        return $req;
    }
    
    private function getDomain() {
	    $base_url = ( ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == "on" ) ? "https" : "http" );
	    $base_url .= "://" . $_SERVER['HTTP_HOST'];
	    $base_url .= str_replace( basename( $_SERVER['SCRIPT_NAME'] ), "", $_SERVER['SCRIPT_NAME'] );
	    return $base_url;

    } 
    

    
}