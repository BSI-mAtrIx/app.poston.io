<?php
/*
Addon Name: Paymongo Payment Gateway addon for NVX Theme Dashboard
Unique Name: n_paymongo
Project ID: 1103
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.5
Description: Paymongo Payment Gateway
*/
require_once("application/controllers/Home.php"); // loading home controller
include("application/libraries/Facebook/autoload.php");

include(APPPATH.'n_views/include/function_class.php');

class N_paymongo extends Home
{
    public $key = "F745300A4E3EBA97";
    private $product_id = "10";
    private $product_base = "n_paymongo";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 1.5;
    /* @var self */
    private static $selfobj = null;
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

        $function_name = $this->uri->segment(2);
        if (
            $function_name != "webhook_callback"
            and $function_name != "card_eco"
            and $function_name != "card_eco_charge"
            and $function_name != "webhook"
            and $function_name != "webhook_ecommerce"
            and $function_name != "n_payment_button_another_ecommerce"
            and $function_name != "n_payment_button_paymaya_return_ecommerce"
            and $function_name != "n_payment_button_paymaya_ecommerce"
        ) {
            // all addon must be login protected
            //------------------------------------------------------------------------------------------
            if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
            // if you want the addon to be accessed by admin and member who has permission to this addon
            //-------------------------------------------------------------------------------------------

//                   if($this->session->userdata('user_type') != 'Admin' && !in_array(3200,$this->module_access) )
//                    {
//                        redirect('home/login_page', 'location');
//                        exit();
//                    }

        }
        $this->load->library('encryption');

        $addon_lang = '/n_paymongo';
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_lang.php')) {
            $this->lang->load($addon_lang, $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        } else {
            $this->lang->load($addon_lang, 'english', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/english');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($addon_lang . '_custom', $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        }

    }


    public function index()
    {
        exit;
        if ($this->session->userdata('logged_in') != 1) exit();

        if ($this->session->userdata('user_type') != 'Admin' && !in_array(3200, $this->module_access))
            redirect('home/login_page', 'location');

        $data['title'] = $this->lang->line('Instagram accounts');
        $data['body'] = 'account_import';
        $data['page_title'] = $data['title'];

        $this->_viewcontroller($data);
    }

    public function n_payment_button($package_id = 0)
    {
        if ($package_id == 0) exit;

        $this->csrf_token_check();

        $config_data = $this->basic->get_data("payment_config");
        if (!isset($config_data[0])) {
            $buttons_html = '<div class="alert alert-warning alert-has-icon">
                                  <div class="alert-icon"><i class="far fa-credit-card"></i></div>
                                  <div class="alert-body">
                                    <div class="alert-title">' . $this->lang->line("Warning") . '</div>
                                    ' . $this->lang->line("No payment method found") . '
                                  </div>
                                </div>';
        }
        $config_data = $config_data[0];

        $cancel_url = base_url() . "payment/transaction_log?action=cancel";
        $success_url = base_url() . "payment/transaction_log?action=success";

        $payment_amount = 0;
        $package_name = "";
        $package_validity = "";
        $package_id = $package_id;
        $package_data = $this->basic->get_data("package", $where = array("where" => array("package.id" => $package_id)));
        if (is_array($package_data) && array_key_exists(0, $package_data)) {
            $payment_amount = $package_data[0]["price"];
            $package_name = $package_data[0]["package_name"];
            $package_validity = $package_data[0]["validity"];
            $validity_extra_info = $package_data[0]["validity_extra_info"];
            $validity_extra_info = explode(',', $validity_extra_info);
        } else {
            // echo $this->lang->line("something went wrong, please try again.");
            exit();
        }

        $where['where'] = array('deleted' => '0');
        $payment_config = $this->basic->get_data('payment_config', $where, $select = '');
        $currency = $payment_config[0]["currency"];
        $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);
        $user_first_name = isset($user_info[0]['first_name']) ? $user_info[0]['first_name'] : '';
        $user_last_name = isset($user_info[0]['last_name']) ? $user_info[0]['last_name'] : '';
        $user_email = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
        $user_name = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
        $user_mobile = isset($user_info[0]['mobile']) ? $user_info[0]['mobile'] : '';

        include(FCPATH . 'application/n_views/config.php');

        $n_paymongo_sec = isset($n_config['n_paymongo_sec']) ? $n_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($n_config['n_paymongo_pub']) ? $n_config['n_paymongo_pub'] : '';

        $paymongo_ret = array();

        //post data
        $name = strip_tags($this->input->post('name', true));
//        $ccnumber = strip_tags($this->input->post('ccnumber', true));
//        $ccmonth = strip_tags($this->input->post('ccmonth', true));
//        $ccyear = strip_tags($this->input->post('ccyear', true));
//        $cvv = strip_tags($this->input->post('cvv', true));


        $bill_email = $user_email;


        //generate payment method
//        $n_paymongo_string = '{"data":{"attributes":{"details":{"card_number":"'.$ccnumber.'","exp_month":'.$ccmonth.',"exp_year":'.$ccyear.',"cvc":"'.$cvv.'"},"billing":{"name":"'.$name.'","email":"'.$bill_email.'"},"type":"card"}}}';
//
//        $ch = curl_init('https://api.paymongo.com/v1/payment_methods');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//            'Authorization: Basic '.base64_encode($n_paymongo_sec)
//        ));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $response = curl_exec($ch);
//        $paymongo_js = json_decode($response, true);
//
//
//
//        if(!empty($paymongo_js['errors'])){
//            echo json_encode(array('error' => $paymongo_js['errors'][0]));
//            exit;
//        }

        //$paymongo_ret['pm'] = $paymongo_js['data']['id'];

        //generate payment intent

        $n_paymongo_string = '{"data":{"attributes":{"amount":' . $payment_amount . '00,"payment_method_allowed":["card","paymaya"],"payment_method_options":{"card":{"request_three_d_secure":"any"}},"currency":"PHP","description":"Order Package ID ' . $package_id . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);

        $paymongo_ret['client_key'] = $paymongo_js['data']['attributes']['client_key'];
        echo json_encode(array('paymongo_client_key' => $paymongo_ret));
    }

    public function charge($package_id = 0, $payment_intent = '')
    {
        if ($package_id == 0) exit;

        include(FCPATH . 'application/n_views/config.php');

        $n_paymongo_sec = isset($n_config['n_paymongo_sec']) ? $n_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($n_config['n_paymongo_pub']) ? $n_config['n_paymongo_pub'] : '';


        $package_id = $package_id;
        $package_data = $this->basic->get_data("package", $where = array("where" => array("package.id" => $package_id)));
        if (is_array($package_data) && array_key_exists(0, $package_data)) {
            $payment_amount = $package_data[0]["price"];
            $package_name = $package_data[0]["package_name"];
            $package_validity = $package_data[0]["validity"];
            $validity_extra_info = $package_data[0]["validity_extra_info"];
            $validity_extra_info = explode(',', $validity_extra_info);
        } else {
            // echo $this->lang->line("something went wrong, please try again.");
            exit();
        }

        $where['where'] = array('deleted' => '0');
        $payment_config = $this->basic->get_data('payment_config', $where, $select = '');
        $currency = $payment_config[0]["currency"];
        $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);
        $user_first_name = isset($user_info[0]['first_name']) ? $user_info[0]['first_name'] : '';
        $user_last_name = isset($user_info[0]['last_name']) ? $user_info[0]['last_name'] : '';
        $user_email = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
        $user_name = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
        $user_mobile = isset($user_info[0]['mobile']) ? $user_info[0]['mobile'] : '';


        $cancel_url = base_url() . "payment/transaction_log?action=cancel";
        $success_url = base_url() . "payment/transaction_log?action=success";
        $user_id = $this->user_id;
        $receiver_email = $user_email;

        $simple_where['where'] = array('user_id' => $user_id);
        $select = array('cycle_start_date', 'cycle_expired_date');

        $prev_payment_info = $this->basic->get_data('transaction_history', $simple_where, $select, $join = '', $limit = '1', $start = 0, $order_by = 'ID DESC', $group_by = '');

        $prev_cycle_expired_date = "";

        if (is_array($package_data) && array_key_exists(0, $package_data))
            $price = $package_data[0]["price"];
        $validity = $package_data[0]["validity"];

        $validity_str = '+' . $validity . ' day';

        foreach ($prev_payment_info as $info) {
            $prev_cycle_expired_date = $info['cycle_expired_date'];
        }

        if ($prev_cycle_expired_date == "") {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))) {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))) {
            $cycle_start_date = date("Y-m-d", strtotime('+1 day', strtotime($prev_cycle_expired_date)));
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        }

        //check payment intent
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents/' . $payment_intent);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);

        if ($paymongo_js['data']['attributes']['status'] == 'succeeded') {

            $currency = 'PHP';
            $transaction_id = $paymongo_js['data']['attributes']['payments'][0]['id'];
            $payment_date = $paymongo_js['data']['attributes']['payments'][0]['attributes']['paid_at'];
            $country = $paymongo_js['data']['attributes']['payments'][0]['attributes']['billing']['address']['country'];
            if (empty($country)) {
                $country = '';
            }

            $insert_data = array(
                "verify_status" => "",
                "first_name" => "",
                "last_name" => "",
                "paypal_email" => "PAYMONGO CARD",
                "receiver_email" => $receiver_email,
                "country" => $country,
                "payment_date" => $payment_date,
                "payment_type" => "PAYMONGO CARD",
                "transaction_id" => $transaction_id,
                "user_id" => $user_id,
                "package_id" => $package_id,
                "cycle_start_date" => $cycle_start_date,
                "cycle_expired_date" => $cycle_expired_date,
                "paid_amount" => $payment_amount,
                //"stripe_card_source"=>$stripe_card_source
            );


            $this->basic->insert_data('transaction_history', $insert_data);
            $this->session->set_userdata("payment_success", 1);

            $table = 'users';
            $where = array('id' => $user_id);
            $data = array('expired_date' => $cycle_expired_date, "package_id" => $package_id, "bot_status" => "1");
            $this->basic->update_data($table, $where, $data);


            $product_short_name = $this->config->item('product_short_name');
            $from = $this->config->item('institute_email');
            $mask = $this->config->item('product_name');
            $subject = "Payment Confirmation";
            $where = array();
            $where['where'] = array('id' => $user_id);
            $user_email = $this->basic->get_data('users', $where, $select = '');

            $payment_confirmation_email_template = $this->basic->get_data("email_template_management", array('where' => array('template_type' => 'stripe_payment')), array('subject', 'message'));

            if (isset($payment_confirmation_email_template[0]) && $payment_confirmation_email_template[0]['subject'] != '' && $payment_confirmation_email_template[0]['message'] != '') {

                $to = $user_email;
                $url = base_url();
                $subject = $payment_confirmation_email_template[0]['subject'];
                $message = str_replace(array('#PRODUCT_SHORT_NAME#', '#APP_SHORT_NAME#', '#CYCLE_EXPIRED_DATE#', '#SITE_URL#', '#APP_NAME#'), array($product_short_name, $product_short_name, $cycle_expired_date, $url, $mask), $payment_confirmation_email_template[0]['message']);
                //send mail to user
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

            } else {

                $to = $user_email;
                $subject = "Payment Confirmation";
                $message = "Congratulation,<br/> we have received your payment successfully. Now you are able to use {$product_short_name} system till {$cycle_expired_date}.<br/><br/>Thank you,<br/><a href='" . base_url() . "'>{$mask}</a> team";
                //send mail to user
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

            }

            // new payment made email
            $paypal_new_payment_made_email_template = $this->basic->get_data("email_template_management", array('where' => array('template_type' => 'stripe_new_payment_made')), array('subject', 'message'));

            if (isset($paypal_new_payment_made_email_template[0]) && $paypal_new_payment_made_email_template[0]['subject'] != '' && $paypal_new_payment_made_email_template[0]['message'] != '') {

                $to = $from;
                $subject = $paypal_new_payment_made_email_template[0]['subject'];
                $message = str_replace('#PAID_USER_NAME#', $user_email[0]['name'], $paypal_new_payment_made_email_template[0]['message']);
                //send mail to admin
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

                echo json_encode(array('redirect' => $success_url));

            } else {

                $to = $from;
                $subject = "New Payment Made";
                $message = "New payment has been made by {$user_name}";
                //send mail to admin
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);
            }

            $redirect_url = base_url() . "payment/transaction_log?action=success";

            // affiliate Section
            if ($this->addon_exist('affiliate_system')) {
                $get_affiliate_id = $this->basic->get_data("users", ['where' => ['id' => $user_id]], ['affiliate_id']);
                $affiliate_id = isset($get_affiliate_id[0]['affiliate_id']) ? $get_affiliate_id[0]['affiliate_id'] : 0;
                if ($affiliate_id != 0) {
                    $this->affiliate_commission($affiliate_id, $user_id, 'payment', $price);
                }
            }

            if ($this->config->item("auto_relogin_after_purchase") == '1') {

                $this->session->unset_userdata('user_type');
                $this->session->unset_userdata('logged_in');
                $this->session->unset_userdata('username');
                $this->session->unset_userdata('user_id');
                $this->session->unset_userdata('download_id');
                $this->session->unset_userdata('user_login_email');
                $this->session->unset_userdata('expiry_date');
                $this->session->unset_userdata('brand_logo');

                $this->subscriber_login($user_id);
            }

            redirect($redirect_url, 'refresh');
            exit;

        } else {
            echo json_encode(
                array(
                    'status' => $paymongo_js['data']['attributes']['status'],
                    'error' => $paymongo_js['data']['attributes']['last_payment_error']
                )
            );

            exit();
        }

        //$charge = OmiseCharge::retrieve($this->input->post('omiseToken',true));
        //$charge->capture();

    }

    public function n_payment_button_another($package_id = 0, $type = 'gcash')
    {
        if ($package_id == 0) exit;

        $config_data = $this->basic->get_data("payment_config");
        if (!isset($config_data[0])) {
            $buttons_html = '<div class="alert alert-warning alert-has-icon">
                                  <div class="alert-icon"><i class="far fa-credit-card"></i></div>
                                  <div class="alert-body">
                                    <div class="alert-title">' . $this->lang->line("Warning") . '</div>
                                    ' . $this->lang->line("No payment method found") . '
                                  </div>
                                </div>';
        }
        $config_data = $config_data[0];

        $cancel_url = base_url() . "payment/transaction_log?action=cancel";
        $success_url = base_url() . "payment/transaction_log?action=success";
//
//        $success_url=base_url()."n_paymongo/n_payment_button_gcash_return";

        $payment_amount = 0;
        $package_name = "";
        $package_validity = "";
        $package_id = $package_id;
        $package_data = $this->basic->get_data("package", $where = array("where" => array("package.id" => $package_id)));
        if (is_array($package_data) && array_key_exists(0, $package_data)) {
            $payment_amount = $package_data[0]["price"];
            $package_name = $package_data[0]["package_name"];
            $package_validity = $package_data[0]["validity"];
            $validity_extra_info = $package_data[0]["validity_extra_info"];
            $validity_extra_info = explode(',', $validity_extra_info);
        } else {
            // echo $this->lang->line("something went wrong, please try again.");
            exit();
        }

        $where['where'] = array('deleted' => '0');
        $payment_config = $this->basic->get_data('payment_config', $where, $select = '');
        $currency = $payment_config[0]["currency"];
        $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);
        $user_first_name = isset($user_info[0]['first_name']) ? $user_info[0]['first_name'] : '';
        $user_last_name = isset($user_info[0]['last_name']) ? $user_info[0]['last_name'] : '';
        $user_email = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
        $user_name = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
        $user_mobile = isset($user_info[0]['mobile']) ? $user_info[0]['mobile'] : '';
        $name = $user_name;

        include(FCPATH . 'application/n_views/config.php');

        $n_paymongo_sec = isset($n_config['n_paymongo_sec']) ? $n_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($n_config['n_paymongo_pub']) ? $n_config['n_paymongo_pub'] : '';

        $paymongo_ret = array();

        //post data


        $user_id = $this->user_id;
        $bill_email = $user_email;

        $n_paymongo_string = '{"data":{"attributes":{"amount":' . $payment_amount . '00,"redirect":{"success":"' . $success_url . '","failed":"' . $cancel_url . '"},"billing":{"name":"' . $name . '","email":"' . $bill_email . '"},"type":"' . $type . '","currency":"PHP"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/sources');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);


        $simple_where['where'] = array('user_id' => $user_id);
        $select = array('cycle_start_date', 'cycle_expired_date');

        $prev_payment_info = $this->basic->get_data('transaction_history', $simple_where, $select, $join = '', $limit = '1', $start = 0, $order_by = 'ID DESC', $group_by = '');

        $prev_cycle_expired_date = "";

        if (is_array($package_data) && array_key_exists(0, $package_data))
            $price = $package_data[0]["price"];
        $validity = $package_data[0]["validity"];

        $validity_str = '+' . $validity . ' day';

//        foreach($prev_payment_info as $info){
//            $prev_cycle_expired_date=$info['cycle_expired_date'];
//        }

        $prev_cycle_expired_date = isset($user_info[0]['expired_date']) ? $user_info[0]['expired_date'] : '';

        if ($prev_cycle_expired_date == "") {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))) {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))) {
            $cycle_start_date = date("Y-m-d", strtotime('+1 day', strtotime($prev_cycle_expired_date)));
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        }

        $currency = 'PHP';
        $transaction_id = $paymongo_js['data']['id'];
        $user_id = $this->user_id;
        $receiver_email = $user_email;
        if (empty($country)) {
            $country = '';
        }

        $insert_data = array(
            "verify_status" => "",
            "first_name" => "",
            "last_name" => "",
            "paypal_email" => $type,
            "receiver_email" => $receiver_email,
            "country" => '',
            "payment_date" => 'processing',
            "payment_type" => strtoupper($type) . " processing",
            "transaction_id" => $transaction_id,
            "user_id" => $user_id,
            "package_id" => $package_id,
            "cycle_start_date" => $cycle_start_date,
            "cycle_expired_date" => $cycle_expired_date,
            "paid_amount" => 0,
            //"stripe_card_source"=>$stripe_card_source
        );

        $this->basic->insert_data('transaction_history', $insert_data);


        redirect(
            $paymongo_js['data']['attributes']['redirect']['checkout_url'],
            'location'
        );

//        $n_paymongo_string = '{"data":{"attributes":{"amount":'.$payment_amount.'00,"source":{"id":"'.$paymongo_js["data"]["id"].'","type":"source"},"currency":"PHP","description":"Order Package ID '.$package_id.'"}}}';
//        $ch = curl_init('https://api.paymongo.com/v1/payments');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//            'Authorization: Basic '.base64_encode($n_paymongo_sec)
//        ));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $response = curl_exec($ch);
//
//        $paymongo_pay = json_decode($response,true);
//
//        var_dump($paymongo_pay);

//        $paymongo_ret['client_key'] = $paymongo_js['data']['attributes']['client_key'];
//        echo json_encode(array('paymongo_client_key' => $paymongo_ret));
    }

    public function n_payment_button_paymaya($package_id = 0)
    {
        if ($package_id == 0) exit;

        $type = 'paymaya';

        $config_data = $this->basic->get_data("payment_config");
        if (!isset($config_data[0])) {
            $buttons_html = '<div class="alert alert-warning alert-has-icon">
                                  <div class="alert-icon"><i class="far fa-credit-card"></i></div>
                                  <div class="alert-body">
                                    <div class="alert-title">' . $this->lang->line("Warning") . '</div>
                                    ' . $this->lang->line("No payment method found") . '
                                  </div>
                                </div>';
        }
        $config_data = $config_data[0];

        $cancel_url = base_url() . "payment/transaction_log?action=cancel";
        $success_url = base_url() . "payment/transaction_log?action=success";
//
//        $success_url=base_url()."n_paymongo/n_payment_button_gcash_return";

        $payment_amount = 0;
        $package_name = "";
        $package_validity = "";
        $package_id = $package_id;
        $package_data = $this->basic->get_data("package", $where = array("where" => array("package.id" => $package_id)));
        if (is_array($package_data) && array_key_exists(0, $package_data)) {
            $payment_amount = $package_data[0]["price"];
            $package_name = $package_data[0]["package_name"];
            $package_validity = $package_data[0]["validity"];
            $validity_extra_info = $package_data[0]["validity_extra_info"];
            $validity_extra_info = explode(',', $validity_extra_info);
        } else {
            // echo $this->lang->line("something went wrong, please try again.");
            exit();
        }

        $where['where'] = array('deleted' => '0');
        $payment_config = $this->basic->get_data('payment_config', $where, $select = '');
        $currency = $payment_config[0]["currency"];
        $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);
        $user_first_name = isset($user_info[0]['first_name']) ? $user_info[0]['first_name'] : '';
        $user_last_name = isset($user_info[0]['last_name']) ? $user_info[0]['last_name'] : '';
        $user_email = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
        $user_name = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
        $user_mobile = isset($user_info[0]['mobile']) ? $user_info[0]['mobile'] : '';
        $name = $user_name;

        include(FCPATH . 'application/n_views/config.php');

        $n_paymongo_sec = isset($n_config['n_paymongo_sec']) ? $n_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($n_config['n_paymongo_pub']) ? $n_config['n_paymongo_pub'] : '';

        $paymongo_ret = array();

        //post data


        $user_id = $this->user_id;
        $bill_email = $user_email;

        //generate payment method
        $n_paymongo_string = '{"data":{"attributes":{"billing":{"name":"' . $name . '","email":"' . $bill_email . '"},"type":"paymaya"}}}';

        $ch = curl_init('https://api.paymongo.com/v1/payment_methods');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $paymongo_met_js = json_decode($response, true);

        if (!empty($paymongo_js['errors'])) {
            echo json_encode(array('error' => $paymongo_js['errors'][0]));
            exit;
        }

        $n_paymongo_string = '{"data":{"attributes":{"amount":' . $payment_amount . '00,"payment_method_allowed":["paymaya"],"payment_method_options":{"card":{"request_three_d_secure":"any"}},"currency":"PHP","description":"Order Package ID ' . $package_id . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_int_js = json_decode($response, true);

        $success_url = base_url() . "n_paymongo/n_payment_button_paymaya_return";
        $n_paymongo_string = '{"data":{"attributes":{"payment_method":"' . $paymongo_met_js['data']['id'] . '","return_url":"' . $success_url . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents/' . $paymongo_int_js['data']['id'] . '/attach');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);


        $simple_where['where'] = array('user_id' => $user_id);
        $select = array('cycle_start_date', 'cycle_expired_date');

        $prev_payment_info = $this->basic->get_data('transaction_history', $simple_where, $select, $join = '', $limit = '1', $start = 0, $order_by = 'ID DESC', $group_by = '');

        $prev_cycle_expired_date = "";

        if (is_array($package_data) && array_key_exists(0, $package_data))
            $price = $package_data[0]["price"];
        $validity = $package_data[0]["validity"];

        $validity_str = '+' . $validity . ' day';

//        foreach($prev_payment_info as $info){
//            $prev_cycle_expired_date=$info['cycle_expired_date'];
//        }

        $prev_cycle_expired_date = isset($user_info[0]['expired_date']) ? $user_info[0]['expired_date'] : '';

        if ($prev_cycle_expired_date == "") {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))) {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))) {
            $cycle_start_date = date("Y-m-d", strtotime('+1 day', strtotime($prev_cycle_expired_date)));
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        }

        $currency = 'PHP';
        $transaction_id = $paymongo_js['data']['id'];
        $user_id = $this->user_id;
        $receiver_email = $user_email;
        if (empty($country)) {
            $country = '';
        }

        $insert_data = array(
            "verify_status" => "",
            "first_name" => "",
            "last_name" => "",
            "paypal_email" => $type,
            "receiver_email" => $receiver_email,
            "country" => '',
            "payment_date" => 'processing',
            "payment_type" => strtoupper($type) . " processing",
            "transaction_id" => $transaction_id,
            "user_id" => $user_id,
            "package_id" => $package_id,
            "cycle_start_date" => $cycle_start_date,
            "cycle_expired_date" => $cycle_expired_date,
            "paid_amount" => 0,
            //"stripe_card_source"=>$stripe_card_source
        );

        $this->basic->insert_data('transaction_history', $insert_data);


        redirect(
            $paymongo_js['data']['attributes']['next_action']['redirect']['url'],
            'location'
        );

//        $n_paymongo_string = '{"data":{"attributes":{"amount":'.$payment_amount.'00,"source":{"id":"'.$paymongo_js["data"]["id"].'","type":"source"},"currency":"PHP","description":"Order Package ID '.$package_id.'"}}}';
//        $ch = curl_init('https://api.paymongo.com/v1/payments');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Accept: application/json',
//            'Content-Type: application/json',
//            'Authorization: Basic '.base64_encode($n_paymongo_sec)
//        ));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $response = curl_exec($ch);
//
//        $paymongo_pay = json_decode($response,true);
//
//        var_dump($paymongo_pay);

//        $paymongo_ret['client_key'] = $paymongo_js['data']['attributes']['client_key'];
//        echo json_encode(array('paymongo_client_key' => $paymongo_ret));
    }

    public function webhook()
    {
        header('Content-Type: application/json');
        $request = file_get_contents('php://input');

        $payload = json_decode($request, true);

        $id = $payload['data']['attributes']['data']['id'];

        $order_info = $this->basic->get_data("transaction_history", $where = array("where" => array("transaction_id" => $id)));
        if (!empty($order_info)) {
            $type = $payload['data']['attributes']['type'];

            //if ecommerce or dashboard
            //Order Package ID '.$package_id.'
            $description_order = "Order Package ID " . $order_info[0]['package_id'];
            include(FCPATH . 'application/n_views/config.php');

            $n_paymongo_sec = isset($n_config['n_paymongo_sec']) ? $n_config['n_paymongo_sec'] : '';

            if ($type == 'source.chargeable') {
                //file_put_contents("webhook.txt",$request, FILE_APPEND | LOCK_EX);
                $amount = $payload['data']['attributes']['data']['attributes']['amount'];
                $id = $payload['data']['attributes']['data']['id'];
                $system_gat = $payload['data']['attributes']['data']['attributes']['type'];


                $fields = array("data" => array("attributes" => array("amount" => $amount, "source" => array("id" => $id, "type" => "source"), "currency" => "PHP", "description" => $description_order)));
                $jsonFields = json_encode($fields);


                $ch = curl_init('https://api.paymongo.com/v1/payments');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonFields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($n_paymongo_sec)
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);

                $paymongo_pay = json_decode($response, true);

                $package_id = $order_info[0]['package_id'];
                $package_data = $this->basic->get_data("package", $where = array("where" => array("package.id" => $package_id)));
                if (is_array($package_data) && array_key_exists(0, $package_data)) {
                    $payment_amount = $package_data[0]["price"];
                    $package_name = $package_data[0]["package_name"];
                    $package_validity = $package_data[0]["validity"];
                    $validity_extra_info = $package_data[0]["validity_extra_info"];
                    $validity_extra_info = explode(',', $validity_extra_info);
                } else {
                    // echo $this->lang->line("something went wrong, please try again.");
                    exit();
                }

                $where['where'] = array('deleted' => '0');
                $payment_config = $this->basic->get_data('payment_config', $where, $select = '');
                $currency = $payment_config[0]["currency"];
                $user_info = $this->basic->get_data('users', ['where' => ['id' => $order_info[0]['user_id']]]);
                $user_first_name = isset($user_info[0]['first_name']) ? $user_info[0]['first_name'] : '';
                $user_last_name = isset($user_info[0]['last_name']) ? $user_info[0]['last_name'] : '';
                $user_email = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
                $user_name = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
                $user_mobile = isset($user_info[0]['mobile']) ? $user_info[0]['mobile'] : '';


                $cancel_url = base_url() . "payment/transaction_log?action=cancel";
                $success_url = base_url() . "payment/transaction_log?action=success";
                $user_id = $order_info[0]['user_id'];
                $receiver_email = $user_email;

                $cycle_start_date = $order_info[0]['cycle_start_date'];
                $cycle_expired_date = $order_info[0]['cycle_expired_date'];


                $currency = 'PHP';
                $transaction_id = $payload['data']['attributes']['data']['id'];
                $payment_date = $payload['data']['attributes']['created_at'];

                if (empty($country)) {
                    $country = '';
                }

                $insert_data = array(
                    "paypal_email" => strtoupper($system_gat),
                    "payment_date" => $payment_date,
                    "payment_type" => strtoupper($system_gat),
                    "paid_amount" => $payment_amount,
                );

                $this->basic->update_data('transaction_history', array('transaction_id' => $transaction_id), $insert_data);
                //$this->session->set_userdata("payment_success",1);

                $table = 'users';
                $where = array('id' => $user_id);
                $data = array('expired_date' => $cycle_expired_date, "package_id" => $package_id, "bot_status" => "1");
                $this->basic->update_data($table, $where, $data);


                $product_short_name = $this->config->item('product_short_name');
                $from = $this->config->item('institute_email');
                $mask = $this->config->item('product_name');
                $subject = "Payment Confirmation";
//                    $where = array();
//                    $where['where'] = array('id'=>$user_id);
//                    $user_email = $this->basic->get_data('users',$where,$select='');

                $payment_confirmation_email_template = $this->basic->get_data("email_template_management", array('where' => array('template_type' => 'stripe_payment')), array('subject', 'message'));

                if (isset($payment_confirmation_email_template[0]) && $payment_confirmation_email_template[0]['subject'] != '' && $payment_confirmation_email_template[0]['message'] != '') {

                    $to = $user_email;
                    $url = base_url();
                    $subject = $payment_confirmation_email_template[0]['subject'];
                    $message = str_replace(array('#PRODUCT_SHORT_NAME#', '#APP_SHORT_NAME#', '#CYCLE_EXPIRED_DATE#', '#SITE_URL#', '#APP_NAME#'), array($product_short_name, $product_short_name, $cycle_expired_date, $url, $mask), $payment_confirmation_email_template[0]['message']);
                    //send mail to user
                    $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

                } else {

                    $to = $user_email;
                    $subject = "Payment Confirmation";
                    $message = "Congratulation,<br/> we have received your payment successfully. Now you are able to use {$product_short_name} system till {$cycle_expired_date}.<br/><br/>Thank you,<br/><a href='" . base_url() . "'>{$mask}</a> team";
                    //send mail to user
                    $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

                }

                // new payment made email
                $paypal_new_payment_made_email_template = $this->basic->get_data("email_template_management", array('where' => array('template_type' => 'stripe_new_payment_made')), array('subject', 'message'));

                if (isset($paypal_new_payment_made_email_template[0]) && $paypal_new_payment_made_email_template[0]['subject'] != '' && $paypal_new_payment_made_email_template[0]['message'] != '') {

                    $to = $from;
                    $subject = $paypal_new_payment_made_email_template[0]['subject'];
                    $message = str_replace('#PAID_USER_NAME#', $user_name, $paypal_new_payment_made_email_template[0]['message']);
                    //send mail to admin
                    $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

                    echo json_encode(array('redirect' => $success_url));

                } else {

                    $to = $from;
                    $subject = "New Payment Made";
                    $message = "New payment has been made by {$user_name}";
                    //send mail to admin
                    $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);
                }

                $redirect_url = base_url() . "payment/transaction_log?action=success";

                // affiliate Section
                if ($this->addon_exist('affiliate_system')) {
                    $get_affiliate_id = $this->basic->get_data("users", ['where' => ['id' => $user_id]], ['affiliate_id']);
                    $affiliate_id = isset($get_affiliate_id[0]['affiliate_id']) ? $get_affiliate_id[0]['affiliate_id'] : 0;
                    if ($affiliate_id != 0) {
                        $this->affiliate_commission($affiliate_id, $user_id, 'payment', $price);
                    }
                }

                exit;
            }

            exit;
        }

    }

    public function n_payment_button_another_ecommerce($store_id = '', $cart_id = '', $subscriber_id = '', $type = 'gcash')
    {

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $n_paymongo_sec = isset($ecommerce_config['n_paymongo_sec']) ? $ecommerce_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($ecommerce_config['n_paymongo_pub']) ? $ecommerce_config['n_paymongo_pub'] : '';

        $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "profile_address" => "1")));


        $currency = 'PHP';

        $receiver_email = '';
        $bill_email = '';
        if (!empty($billing_data[0]['email'])) {
            $receiver_email = $billing_data[0]['email'];
            $bill_email = $billing_data[0]['email'];
            $name = $billing_data[0]['first_name'] . ' ' . $billing_data[0]['last_name'];
        } else {
            $delivery_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id)));
            if (isset($delivery_data[0])) {
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id), array("is_default" => '0'));
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id, "id" => $delivery_data[0]['id']), array("is_default" => '1'));
                $buyer_first_name = $delivery_data[0]['first_name'];
                $buyer_last_name = $delivery_data[0]['last_name'];
                $buyer_country = $delivery_data[0]['country'];
                $buyer_email = $delivery_data[0]['email'];
                $buyer_mobile = $delivery_data[0]['mobile'];
                $buyer_city = $delivery_data[0]['city'];
                $buyer_state = $delivery_data[0]['state'];
                $buyer_address = $delivery_data[0]['address'];
                $buyer_zip = $delivery_data[0]['zip'];

                $receiver_email = $delivery_data[0]['email'];
                $bill_email = $delivery_data[0]['email'];
                $name = $delivery_data[0]['first_name'] . ' ' . $delivery_data[0]['last_name'];
            }
        }

        $invoice_link = base_url(return_ecommerce_base_url("order/") . $cart_id . "?subscriber_id=" . $subscriber_id . "&action=success3");
        $cancel_link = base_url(return_ecommerce_base_url("order/") . $cart_id . "?subscriber_id=" . $subscriber_id . "&action=cancel");

        $payment_amount = get_payment_amount($cart_id, $subscriber_id);

        $n_paymongo_string = '{"data":{"attributes":{"amount":' . $payment_amount . '00,"redirect":{"success":"' . $invoice_link . '","failed":"' . $cancel_link . '"},"billing":{"name":"' . $name . '","email":"' . $receiver_email . '"},"type":"' . $type . '","currency":"PHP"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/sources');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);

        $transaction_id = $paymongo_js['data']['id'];
        $payment_date = $paymongo_js['data']['attributes']['created_at'];
        $country = '';
        //$payment_amount = $paymongo_js['data']['attributes']['amount']; //get from PM

        $curtime = date("Y-m-d H:i:s");
        $insert_data = array
        (
            'checkout_account_receiver_email' => $receiver_email,
            'checkout_account_country' => $country,
            'checkout_amount' => $payment_amount,
            'checkout_currency' => $currency,
            'checkout_timestamp' => $payment_date,
            'transaction_id' => $transaction_id,
            'checkout_source_json' => $transaction_id,
            //"checkout_source_json"=>$stripe_card_source,
            'paid_at' => $curtime,
            'status' => 'pending',
            'status_changed_at' => $curtime,
            'action_type' => 'checkout',
            'payment_method' => strtoupper($type)
        );
        $this->basic->update_data('ecommerce_cart', array("id" => $cart_id, "subscriber_id" => $subscriber_id, "action_type !=" => "checkout"), $insert_data);

        if ($cart_id != "" && $subscriber_id != "") {
            $cart_data = $this->valid_cart_data($cart_id, $subscriber_id, $select = "");
            if (isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
        }

        redirect(
            $paymongo_js['data']['attributes']['redirect']['checkout_url'],
            'location'
        );


    }

    public function webhook_ecommerce()
    {
        header('Content-Type: application/json');
        $request = file_get_contents('php://input');

        $payload = json_decode($request, true);

        $id = $payload['data']['attributes']['data']['id'];

        $order_info = $this->basic->get_data("ecommerce_cart", array("where" => array("checkout_source_json" => $id)));

        //file_put_contents("webhookecom.txt",$request, FILE_APPEND | LOCK_EX);
        if (!empty($order_info)) {
            $type = $payload['data']['attributes']['type'];

            $ecommerce_config = $this->get_ecommerce_config($order_info[0]['store_id']);
            $n_paymongo_sec = isset($ecommerce_config['n_paymongo_sec']) ? $ecommerce_config['n_paymongo_sec'] : '';
            $n_paymongo_pub = isset($ecommerce_config['n_paymongo_pub']) ? $ecommerce_config['n_paymongo_pub'] : '';


            $description_order = "Order ID " . $order_info[0]['id'];

            if ($type == 'source.chargeable') {
                //file_put_contents("webhook.txt",$request, FILE_APPEND | LOCK_EX);
                $amount = $payload['data']['attributes']['data']['attributes']['amount'];
                $id = $payload['data']['attributes']['data']['id'];
                $system_gat = $payload['data']['attributes']['data']['attributes']['type'];


                $fields = array("data" => array("attributes" => array("amount" => $amount, "source" => array("id" => $id, "type" => "source"), "currency" => "PHP", "description" => $description_order)));
                $jsonFields = json_encode($fields);


                $ch = curl_init('https://api.paymongo.com/v1/payments');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonFields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($n_paymongo_sec)
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                //file_put_contents("webhookecom2.txt",$response, FILE_APPEND | LOCK_EX);
                $paymongo_pay = json_decode($response, true);


                $currency = 'PHP';

                $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $order_info[0]['subscriber_id'], "profile_address" => "1")));

                $receiver_email = $billing_data[0]['email'];


                $payment_date = $payload['data']['attributes']['created_at'];


                $curtime = date("Y-m-d H:i:s");
                $insert_data = array
                (
                    'paid_at' => $payment_date,
                    'status' => 'approved',
                    'payment_method' => strtoupper($system_gat)
                );
                $this->basic->update_data('ecommerce_cart', array("id" => $order_info[0]['id'], "subscriber_id" => $order_info[0]['subscriber_id']), $insert_data);

                if ($order_info[0]['id'] != "" && $order_info[0]['subscriber_id'] != "") {
                    $cart_data = $this->valid_cart_data($order_info[0]['id'], $order_info[0]['subscriber_id'], $select = "");
                    if (isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
                }

                $this->confirmation_message_sender($order_info[0]['id'], $order_info[0]['subscriber_id']);

                exit;
            }

            exit;
        }

    }


    public function enable_webhook()
    {
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }
        include(FCPATH . 'application/n_views/config.php');
        $n_paymongo_sec = isset($n_config['n_paymongo_sec']) ? $n_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($n_config['n_paymongo_pub']) ? $n_config['n_paymongo_pub'] : '';

        $url = base_url('n_paymongo/webhook');
        $n_paymongo_string = '{"data":{"attributes":{"events":["source.chargeable","payment.paid","payment.failed"],"url":"' . $url . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/webhooks');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_pay = json_decode($response, true);

        if (!empty($paymongo_pay['errors'][0]['code']) and $paymongo_pay['errors'][0]['code'] == 'resource_exists') {
            echo json_encode(array('status' => '1', 'message' => $this->lang->line('webhook has now enabled')));
            exit();
        } else {
            echo json_encode(array('status' => '1', 'message' => $this->lang->line('webhook has now enabled')));
            exit();
        }
    }


    public function enable_webhook_ecommerce($store_id)
    {
        $ecomstore = $this->basic->get_data("ecommerce_config", array("where" => array("store_id" => $store_id)));

        $n_paymongo_sec = isset($ecomstore[0]['n_paymongo_sec']) ? $ecomstore[0]['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($ecomstore[0]['n_paymongo_pub']) ? $ecomstore[0]['n_paymongo_pub'] : '';

        $url = base_url('n_paymongo/webhook_ecommerce');
        $n_paymongo_string = '{"data":{"attributes":{"events":["source.chargeable","payment.paid","payment.failed"],"url":"' . $url . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/webhooks');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_pay = json_decode($response, true);

        if (!empty($paymongo_pay['errors'][0]['code']) and $paymongo_pay['errors'][0]['code'] == 'resource_exists') {
            echo json_encode(array('status' => '1', 'message' => $this->lang->line('webhook has now enabled')));
            exit();
        } else {
            echo json_encode(array('status' => '1', 'message' => $this->lang->line('webhook has now enabled')));
            exit();
        }
    }

    public function update_database()
    {
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }

        $sql = array
        (
            0 => "ALTER TABLE `ecommerce_config` ADD `n_paymongo_pub` VARCHAR(50) NOT NULL DEFAULT '', ADD `n_paymongo_sec` VARCHAR(50) NOT NULL DEFAULT '';",

            1 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_enabled` ENUM('0','1') NOT NULL DEFAULT '0';",

            2 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_paymaya_en` ENUM('0','1') NOT NULL DEFAULT '0';",

            3 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_grab_en` ENUM('0','1') NOT NULL DEFAULT '0';",

            4 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_gcash_en` ENUM('0','1') NOT NULL DEFAULT '0';"

        );

    }


    public function card_eco($store_id = '', $cart_id = '', $subscriber_id = '')
    {
        $this->csrf_token_check();

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $n_paymongo_sec = isset($ecommerce_config['n_paymongo_sec']) ? $ecommerce_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($ecommerce_config['n_paymongo_pub']) ? $ecommerce_config['n_paymongo_pub'] : '';

        $paymongo_ret = array();

        //post data
//        $name = strip_tags($this->input->post('name', true));
//        $ccnumber = strip_tags($this->input->post('ccnumber', true));
//        $ccmonth = strip_tags($this->input->post('ccmonth', true));
//        $ccyear = strip_tags($this->input->post('ccyear', true));
//        $cvv = strip_tags($this->input->post('cvv', true));

        $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "profile_address" => "1")));

        $receiver_email = '';
        $bill_email = '';
        if (!empty($billing_data[0]['email'])) {
            $receiver_email = $billing_data[0]['email'];
            $bill_email = $billing_data[0]['email'];
            $name = $billing_data[0]['first_name'] . ' ' . $billing_data[0]['last_name'];
        } else {
            $delivery_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id)));
            if (isset($delivery_data[0])) {
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id), array("is_default" => '0'));
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id, "id" => $delivery_data[0]['id']), array("is_default" => '1'));
                $buyer_first_name = $delivery_data[0]['first_name'];
                $buyer_last_name = $delivery_data[0]['last_name'];
                $buyer_country = $delivery_data[0]['country'];
                $buyer_email = $delivery_data[0]['email'];
                $buyer_mobile = $delivery_data[0]['mobile'];
                $buyer_city = $delivery_data[0]['city'];
                $buyer_state = $delivery_data[0]['state'];
                $buyer_address = $delivery_data[0]['address'];
                $buyer_zip = $delivery_data[0]['zip'];

                $receiver_email = $delivery_data[0]['email'];
                $bill_email = $delivery_data[0]['email'];
                $name = $delivery_data[0]['first_name'] . ' ' . $delivery_data[0]['last_name'];
            }
        }

        $payment_amount = get_payment_amount($cart_id, $subscriber_id);


        //generate payment intent

        $n_paymongo_string = '{"data":{"attributes":{"amount":' . $payment_amount . '00,"payment_method_allowed":["card","paymaya"],"payment_method_options":{"card":{"request_three_d_secure":"any"}},"currency":"PHP","description":"Order ' . $cart_id . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);

        $paymongo_ret['client_key'] = $paymongo_js['data']['attributes']['client_key'];
        echo json_encode(array('paymongo_client_key' => $paymongo_ret));
    }

    public function card_eco_charge($store_id = '', $cart_id = '', $subscriber_id = '', $payment_intent = '')
    {

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $n_paymongo_sec = isset($ecommerce_config['n_paymongo_sec']) ? $ecommerce_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($ecommerce_config['n_paymongo_pub']) ? $ecommerce_config['n_paymongo_pub'] : '';

        //check payment intent
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents/' . $payment_intent);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);


        //if succed
        if ($paymongo_js['data']['attributes']['status'] == 'succeeded') {

            $currency = 'PHP';

            $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "profile_address" => "1")));

            $receiver_email = $billing_data[0]['email'];

            $transaction_id = $paymongo_js['data']['attributes']['payments'][0]['id'];
            $payment_date = $paymongo_js['data']['attributes']['payments'][0]['attributes']['paid_at'];
            $country = $paymongo_js['data']['attributes']['payments'][0]['attributes']['billing']['address']['country'];
            $payment_amount = $paymongo_js['data']['attributes']['amount']; //get from PM


            $curtime = date("Y-m-d H:i:s");
            $insert_data = array
            (
                'checkout_account_receiver_email' => $receiver_email,
                'checkout_account_country' => $country,
                'checkout_amount' => $payment_amount,
                'checkout_currency' => $currency,
                'checkout_timestamp' => $payment_date,
                'transaction_id' => $transaction_id,
                //"checkout_source_json"=>$stripe_card_source,
                'paid_at' => $curtime,
                'status' => 'approved',
                'status_changed_at' => $curtime,
                'action_type' => 'checkout',
                'payment_method' => 'Paymongo Card'
            );
            $this->basic->update_data('ecommerce_cart', array("id" => $cart_id, "subscriber_id" => $subscriber_id, "action_type !=" => "checkout"), $insert_data);

            if ($cart_id != "" && $subscriber_id != "") {
                $cart_data = $this->valid_cart_data($cart_id, $subscriber_id, $select = "");
                if (isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
            }

            $invoice_link = "order/" . $cart_id . "?subscriber_id=" . $subscriber_id . "&action=success3";
            $this->confirmation_message_sender($cart_id, $subscriber_id);
            echo json_encode(array('redirect' => $invoice_link));
            //redirect($invoice_link, 'location'); //send to JSON
        } else {
            echo json_encode(
                array(
                    'status' => $paymongo_js['data']['attributes']['status'],
                    'error' => $paymongo_js['data']['attributes']['last_payment_error']
                )
            );

            exit();
        }
    }

    public function n_payment_button_paymaya_return()
    {
        include(FCPATH . 'application/n_views/config.php');

        $n_paymongo_sec = isset($n_config['n_paymongo_sec']) ? $n_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($n_config['n_paymongo_pub']) ? $n_config['n_paymongo_pub'] : '';

        $ch = curl_init('https://api.paymongo.com/v1/payment_intents/' . $_GET['payment_intent_id']);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);


        if ($paymongo_js['data']['attributes']['status'] == 'succeeded') {
            $returjs = array();
            $returjs['type'] = $paymongo_js['data']['attributes']['payment_method_allowed'][0];
            $returjs['amount'] = $paymongo_js['data']['attributes']['amount'];
            $returjs['created_at'] = $paymongo_js['data']['attributes']['created_at'];
            $this->payment_success($paymongo_js['data']['id'], $returjs);
        }


    }

    private function payment_success($transaction_id, $returjs)
    {

        $order_info = $this->basic->get_data("transaction_history", $where = array("where" => array("transaction_id" => $transaction_id)));
        if (!empty($order_info)) {
            $type = $returjs['type'];

            //file_put_contents("webhook.txt",$request, FILE_APPEND | LOCK_EX);
            $amount = $returjs['amount'];
            $id = $transaction_id;
            $system_gat = $type;

            $package_id = $order_info[0]['package_id'];
            $package_data = $this->basic->get_data("package", $where = array("where" => array("package.id" => $package_id)));
            if (is_array($package_data) && array_key_exists(0, $package_data)) {
                $payment_amount = $package_data[0]["price"];
                $package_name = $package_data[0]["package_name"];
                $package_validity = $package_data[0]["validity"];
                $validity_extra_info = $package_data[0]["validity_extra_info"];
                $validity_extra_info = explode(',', $validity_extra_info);
            } else {
                // echo $this->lang->line("something went wrong, please try again.");
                exit();
            }

            $where['where'] = array('deleted' => '0');
            $payment_config = $this->basic->get_data('payment_config', $where, $select = '');
            $currency = $payment_config[0]["currency"];
            $user_info = $this->basic->get_data('users', ['where' => ['id' => $order_info[0]['user_id']]]);

            $user_first_name = isset($user_info[0]['first_name']) ? $user_info[0]['first_name'] : '';
            $user_last_name = isset($user_info[0]['last_name']) ? $user_info[0]['last_name'] : '';
            $user_email = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
            $user_name = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
            $user_mobile = isset($user_info[0]['mobile']) ? $user_info[0]['mobile'] : '';


            $cancel_url = base_url() . "payment/transaction_log?action=cancel";
            $success_url = base_url() . "payment/transaction_log?action=success";
            $user_id = $order_info[0]['user_id'];

            $receiver_email = $user_email;

            $cycle_start_date = $order_info[0]['cycle_start_date'];
            $cycle_expired_date = $order_info[0]['cycle_expired_date'];


            $currency = 'PHP';
            $payment_date = $returjs['created_at'];

            if (empty($country)) {
                $country = '';
            }

            $insert_data = array(
                "paypal_email" => strtoupper($system_gat),
                "payment_date" => $payment_date,
                "payment_type" => strtoupper($system_gat),
                "paid_amount" => $payment_amount,
            );

            $this->basic->update_data('transaction_history', array('transaction_id' => $transaction_id), $insert_data);
            //$this->session->set_userdata("payment_success",1);

            $table = 'users';
            $where = array('id' => $user_id);
            $data = array('expired_date' => $cycle_expired_date, "package_id" => $package_id, "bot_status" => "1");
            $this->basic->update_data($table, $where, $data);


            $product_short_name = $this->config->item('product_short_name');
            $from = $this->config->item('institute_email');
            $mask = $this->config->item('product_name');
            $subject = "Payment Confirmation";
//                $where = array();
//                $where['where'] = array('id'=>$user_id);
//                $user_email = $this->basic->get_data('users',$where,$select='');

            $payment_confirmation_email_template = $this->basic->get_data("email_template_management", array('where' => array('template_type' => 'stripe_payment')), array('subject', 'message'));

            if (isset($payment_confirmation_email_template[0]) && $payment_confirmation_email_template[0]['subject'] != '' && $payment_confirmation_email_template[0]['message'] != '') {

                $to = $user_email;
                $url = base_url();
                $subject = $payment_confirmation_email_template[0]['subject'];
                $message = str_replace(array('#PRODUCT_SHORT_NAME#', '#APP_SHORT_NAME#', '#CYCLE_EXPIRED_DATE#', '#SITE_URL#', '#APP_NAME#'), array($product_short_name, $product_short_name, $cycle_expired_date, $url, $mask), $payment_confirmation_email_template[0]['message']);
                //send mail to user
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

            } else {

                $to = $user_email;
                $subject = "Payment Confirmation";
                $message = "Congratulation,<br/> we have received your payment successfully. Now you are able to use {$product_short_name} system till {$cycle_expired_date}.<br/><br/>Thank you,<br/><a href='" . base_url() . "'>{$mask}</a> team";
                //send mail to user
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

            }

            // new payment made email
            $paypal_new_payment_made_email_template = $this->basic->get_data("email_template_management", array('where' => array('template_type' => 'stripe_new_payment_made')), array('subject', 'message'));

            if (isset($paypal_new_payment_made_email_template[0]) && $paypal_new_payment_made_email_template[0]['subject'] != '' && $paypal_new_payment_made_email_template[0]['message'] != '') {

                $to = $from;
                $subject = $paypal_new_payment_made_email_template[0]['subject'];
                $message = str_replace('#PAID_USER_NAME#', $user_name, $paypal_new_payment_made_email_template[0]['message']);
                //send mail to admin
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);

                echo json_encode(array('redirect' => $success_url));

            } else {

                $to = $from;
                $subject = "New Payment Made";
                $message = "New payment has been made by {$user_name}";
                //send mail to admin
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);
            }

            $redirect_url = base_url() . "payment/transaction_log?action=success";

            // affiliate Section
            if ($this->addon_exist('affiliate_system')) {
                $get_affiliate_id = $this->basic->get_data("users", ['where' => ['id' => $user_id]], ['affiliate_id']);
                $affiliate_id = isset($get_affiliate_id[0]['affiliate_id']) ? $get_affiliate_id[0]['affiliate_id'] : 0;
                if ($affiliate_id != 0) {
                    $this->affiliate_commission($affiliate_id, $user_id, 'payment', $price);
                }
            }


            redirect(
                $redirect_url,
                'location'
            );
            exit;
        }

        exit;
    }


    public function n_payment_button_paymaya_ecommerce($store_id = '', $cart_id = '', $subscriber_id = '', $type = 'paymaya')
    {

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $n_paymongo_sec = isset($ecommerce_config['n_paymongo_sec']) ? $ecommerce_config['n_paymongo_sec'] : '';
        $n_paymongo_pub = isset($ecommerce_config['n_paymongo_pub']) ? $ecommerce_config['n_paymongo_pub'] : '';

        $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "profile_address" => "1")));

        $currency = 'PHP';

        $receiver_email = '';
        $bill_email = '';
        if (!empty($billing_data[0]['email'])) {
            $receiver_email = $billing_data[0]['email'];
            $bill_email = $billing_data[0]['email'];
            $name = $billing_data[0]['first_name'] . ' ' . $billing_data[0]['last_name'];
        } else {
            $delivery_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id)));
            if (isset($delivery_data[0])) {
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id), array("is_default" => '0'));
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id, "id" => $delivery_data[0]['id']), array("is_default" => '1'));
                $buyer_first_name = $delivery_data[0]['first_name'];
                $buyer_last_name = $delivery_data[0]['last_name'];
                $buyer_country = $delivery_data[0]['country'];
                $buyer_email = $delivery_data[0]['email'];
                $buyer_mobile = $delivery_data[0]['mobile'];
                $buyer_city = $delivery_data[0]['city'];
                $buyer_state = $delivery_data[0]['state'];
                $buyer_address = $delivery_data[0]['address'];
                $buyer_zip = $delivery_data[0]['zip'];

                $receiver_email = $delivery_data[0]['email'];
                $bill_email = $delivery_data[0]['email'];
                $name = $delivery_data[0]['first_name'] . ' ' . $delivery_data[0]['last_name'];
            }
        }
        $payment_amount = get_payment_amount($cart_id, $subscriber_id);
        $invoice_link = base_url(return_ecommerce_base_url("order/") . $cart_id . "?subscriber_id=" . $subscriber_id . "&action=success3");
        $cancel_link = base_url(return_ecommerce_base_url("order/") . $cart_id . "?subscriber_id=" . $subscriber_id . "&action=cancel");


        $send_arr = array();
        $send_arr['name'] = $name;
        $send_arr['bill_email'] = $bill_email;
        $send_arr['payment_amount'] = $payment_amount;
        $send_arr['shopname'] = time();
        $send_arr['success_url'] = $invoice_link;
        $send_arr['sec_key'] = $n_paymongo_sec;

        $payment_gateway = $this->n_payment_button_paymaya_generate($send_arr);

        $transaction_id = $payment_gateway['id'];
        $payment_date = $payment_gateway['created_at'];
        $country = '';
        //$payment_amount = $paymongo_js['data']['attributes']['amount']; //get from PM


        $insert_data = array
        (
            'checkout_account_receiver_email' => $receiver_email,
            'checkout_account_country' => $country,
            'checkout_amount' => $payment_amount,
            'checkout_currency' => $currency,
            'checkout_timestamp' => $payment_date,
            'transaction_id' => $transaction_id,
            'checkout_source_json' => $transaction_id,
            //"checkout_source_json"=>$stripe_card_source,
            'paid_at' => $curtime,
            'status' => 'pending',
            'status_changed_at' => $curtime,
            'action_type' => 'checkout',
            'payment_method' => strtoupper($type)
        );
        $this->basic->update_data('ecommerce_cart', array("id" => $cart_id, "subscriber_id" => $subscriber_id, "action_type !=" => "checkout"), $insert_data);

        if ($cart_id != "" && $subscriber_id != "") {
            $cart_data = $this->valid_cart_data($cart_id, $subscriber_id, $select = "");
            if (isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
        }

        redirect(
            $payment_gateway['url'],
            'location'
        );


    }

    public function n_payment_button_paymaya_return_ecommerce()
    {
        $order_info = $this->basic->get_data("ecommerce_cart", array("where" => array("checkout_source_json" => $_GET['payment_intent_id'])));

        if (!empty($order_info)) {
            $ecommerce_config = $this->get_ecommerce_config($order_info[0]['store_id']);
            $n_paymongo_sec = isset($ecommerce_config['n_paymongo_sec']) ? $ecommerce_config['n_paymongo_sec'] : '';
            $n_paymongo_pub = isset($ecommerce_config['n_paymongo_pub']) ? $ecommerce_config['n_paymongo_pub'] : '';

            $ch = curl_init('https://api.paymongo.com/v1/payment_intents/' . $_GET['payment_intent_id']);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($n_paymongo_sec)
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            $paymongo_js = json_decode($response, true);


            if ($paymongo_js['data']['attributes']['status'] == 'succeeded') {
                $returjs = array();
                $returjs['type'] = $paymongo_js['data']['attributes']['payment_method_allowed'][0];
                $returjs['amount'] = $paymongo_js['data']['attributes']['amount'];
                $returjs['created_at'] = $paymongo_js['data']['attributes']['created_at'];
                $this->payment_success_ecommerce($paymongo_js['data']['id'], $returjs, $order_info, $ecommerce_config);
            }

        }
    }

    private function payment_success_ecommerce($transaction_id, $returjs, $order_info, $ecommerce_config)
    {
        $type = $returjs['type'];

        $description_order = "Order ID " . $order_info[0]['id'];

        //file_put_contents("webhook.txt",$request, FILE_APPEND | LOCK_EX);
        $amount = $returjs['amount'];
        $id = $transaction_id;
        $system_gat = $type;


        $currency = 'PHP';

        $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $order_info[0]['subscriber_id'], "profile_address" => "1")));

        $receiver_email = $billing_data[0]['email'];


        $payment_date = $returjs['created_at'];


        $curtime = date("Y-m-d H:i:s");
        $insert_data = array
        (
            'paid_at' => $payment_date,
            'status' => 'approved',
            'payment_method' => strtoupper($system_gat)
        );
        $this->basic->update_data('ecommerce_cart', array("id" => $order_info[0]['id'], "subscriber_id" => $order_info[0]['subscriber_id']), $insert_data);

        if ($order_info[0]['id'] != "" && $order_info[0]['subscriber_id'] != "") {
            $cart_data = $this->valid_cart_data($order_info[0]['id'], $order_info[0]['subscriber_id'], $select = "");
            if (isset($cart_data[0]['store_locale'])) $this->_language_loader($cart_data[0]['store_locale']);
        }

        $this->confirmation_message_sender($order_info[0]['id'], $order_info[0]['subscriber_id']);

        $invoice_link = base_url(return_ecommerce_base_url("order/") . $order_info[0]['id'] . "?subscriber_id=" . $order_info[0]['subscriber_id'] . "&action=success3");

        redirect(
            $invoice_link,
            'location'
        );

        exit;
    }

    private function n_payment_button_paymaya_generate($send_arr)
    {

        $name = $send_arr['name'];
        $bill_email = $send_arr['bill_email'];
        $payment_amount = $send_arr['payment_amount'];
        $shopname = $send_arr['shopname'];
        $success_url = $send_arr['success_url'];
        $n_paymongo_sec = $send_arr['sec_key'];

        $type = 'paymaya';

        //generate payment method
        $n_paymongo_string = '{"data":{"attributes":{"billing":{"name":"' . $name . '","email":"' . $bill_email . '"},"type":"paymaya"}}}';

        $ch = curl_init('https://api.paymongo.com/v1/payment_methods');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $paymongo_met_js = json_decode($response, true);

        if (!empty($paymongo_js['errors'])) {
            echo json_encode(array('error' => $paymongo_js['errors'][0]));
            exit;
        }

        $n_paymongo_string = '{"data":{"attributes":{"amount":' . $payment_amount . '00,"payment_method_allowed":["paymaya"],"payment_method_options":{"card":{"request_three_d_secure":"any"}},"currency":"PHP","description":"Order ' . $shopname . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_int_js = json_decode($response, true);

        $success_url = base_url() . "n_paymongo/n_payment_button_paymaya_return_ecommerce";
        $n_paymongo_string = '{"data":{"attributes":{"payment_method":"' . $paymongo_met_js['data']['id'] . '","return_url":"' . $success_url . '"}}}';
        $ch = curl_init('https://api.paymongo.com/v1/payment_intents/' . $paymongo_int_js['data']['id'] . '/attach');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $n_paymongo_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($n_paymongo_sec)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $paymongo_js = json_decode($response, true);


        return array(
            'id' => $paymongo_js['data']['id'],
            'url' => $paymongo_js['data']['attributes']['next_action']['redirect']['url'],
            'created_at' => $paymongo_js['data']['attributes']['created_at']
        );

    }


    private function get_ecommerce_config($store_id = '0')
    {
        if ($store_id == '0') $store_id = $this->session->userdata("ecommerce_selected_store");
        $data = $this->basic->get_data("ecommerce_config", array("where" => array("store_id" => $store_id)));
        if (isset($data[0])) return $data[0];
        else return array();
    }

    private function valid_cart_data($cart_id = 0, $subscriber_id = "", $select = "")
    {
        $join = array('ecommerce_store' => "ecommerce_cart.store_id=ecommerce_store.id,left");
        $where = array('where' => array("ecommerce_cart.subscriber_id" => $subscriber_id, "ecommerce_cart.id" => $cart_id, "action_type!=" => "checkout", "ecommerce_store.status" => "1"));
        if ($select == "") $select = array("ecommerce_cart.*", "tax_percentage", "shipping_charge", "store_unique_id", "store_locale");
        return $cart_data = $this->basic->get_data("ecommerce_cart", $where, $select, $join);
    }

    private function confirmation_message_sender($cart_id = 0, $subscriber_id = "")
    {
        if ($cart_id == 0 || $subscriber_id == "") return false;
        $cart_select = array("ecommerce_cart.*", "store_unique_id", "page_id", "messenger_content", "sms_content", "sms_api_id", "email_content", "email_api_id", "email_subject", "configure_email_table", "label_ids", "store_name");
        $cart_join = array('ecommerce_store' => "ecommerce_cart.store_id=ecommerce_store.id,left");
        $cart_where = array('where' => array("ecommerce_cart.subscriber_id" => $subscriber_id, "ecommerce_cart.id" => $cart_id, "ecommerce_store.status" => "1"));
        $cart_data_2d = $this->basic->get_data("ecommerce_cart", $cart_where, $cart_select, $cart_join);
        if (!isset($cart_data_2d[0])) return false;

        $cart_data = $cart_data_2d[0];

        $store_unique_id = isset($cart_data['store_unique_id']) ? $cart_data['store_unique_id'] : '';
        $store_id = isset($cart_data['store_id']) ? $cart_data['store_id'] : '0';
        $user_id = isset($cart_data['user_id']) ? $cart_data['user_id'] : '0';
        $page_id = isset($cart_data['page_id']) ? $cart_data['page_id'] : '0';
        $sms_api_id = isset($cart_data['sms_api_id']) ? $cart_data['sms_api_id'] : '0';
        $sms_content = (isset($cart_data['sms_content']) && !empty($cart_data['sms_content'])) ? json_decode($cart_data['sms_content'], true) : array();
        $email_api_id = isset($cart_data['email_api_id']) ? $cart_data['email_api_id'] : '0';
        $email_content = (isset($cart_data['email_content']) && !empty($cart_data['email_content'])) ? json_decode($cart_data['email_content'], true) : array();
        $configure_email_table = isset($cart_data['configure_email_table']) ? $cart_data['configure_email_table'] : '';
        $email_subject = isset($cart_data['email_subject']) ? $cart_data['email_subject'] : '{{store_name}} | Order Update';
        $messenger_content = (isset($cart_data['messenger_content']) && !empty($cart_data['messenger_content'])) ? json_decode($cart_data['messenger_content'], true) : array();
        $action_type = isset($cart_data['action_type']) ? $cart_data['action_type'] : 'checkout';
        $buyer_first_name = isset($cart_data['buyer_first_name']) ? $cart_data['buyer_first_name'] : '';
        $buyer_last_name = isset($cart_data['buyer_last_name']) ? $cart_data['buyer_last_name'] : '';
        $buyer_email = isset($cart_data['buyer_email']) ? $cart_data['buyer_email'] : '';
        $buyer_mobile = isset($cart_data['buyer_mobile']) ? $cart_data['buyer_mobile'] : '';
        $buyer_country = isset($cart_data['buyer_country']) ? $cart_data['buyer_country'] : '-';
        $buyer_state = isset($cart_data['buyer_state']) ? $cart_data['buyer_state'] : '-';
        $buyer_city = isset($cart_data['buyer_city']) ? $cart_data['buyer_city'] : '-';
        $buyer_address = isset($cart_data['buyer_address']) ? $cart_data['buyer_address'] : '-';
        $buyer_zip = isset($cart_data['buyer_zip']) ? $cart_data['buyer_zip'] : '-';
        $subtotal = isset($cart_data['subtotal']) ? $cart_data['subtotal'] : 0;
        $payment_amount = isset($cart_data['payment_amount']) ? $cart_data['payment_amount'] : 0;
        $currency = isset($cart_data['currency']) ? $cart_data['currency'] : 'USD';
        $shipping = isset($cart_data['shipping']) ? $cart_data['shipping'] : 0;
        $tax = isset($cart_data['tax']) ? $cart_data['tax'] : 0;
        $coupon_code = isset($cart_data['coupon_code']) ? $cart_data['coupon_code'] : "";
        $discount = isset($cart_data['discount']) ? $cart_data['discount'] : 0;
        $payment_method = isset($cart_data['payment_method']) ? $cart_data['payment_method'] : "Cash on Delivery";
        $ecom_store_name = isset($cart_data['store_name']) ? $cart_data['store_name'] : '';

        $checkout_url = base_url("ecommerce/cart/" . $cart_id . "?subscriber_id=" . $subscriber_id);
        $order_url = base_url("ecommerce/order/" . $cart_id . "?subscriber_id=" . $subscriber_id);
        $store_url = base_url("ecommerce/store/" . $store_unique_id . "?subscriber_id=" . $subscriber_id);
        $my_orders_url = base_url("ecommerce/my_orders/" . $store_id . "?subscriber_id=" . $subscriber_id);

        if (empty($buyer_email)) $buyer_email = isset($cart_data['bill_email']) ? $cart_data['bill_email'] : '';
        if (empty($buyer_mobile)) $buyer_mobile = isset($cart_data['bill_mobile']) ? $cart_data['bill_mobile'] : '';

        $cart_info = $this->basic->get_data("ecommerce_cart_item", array("where" => array("cart_id" => $cart_id)), "quantity,product_name,unit_price,coupon_info,attribute_info,thumbnail,product_id,woocommerce_product_id", array('ecommerce_product' => "ecommerce_cart_item.product_id=ecommerce_product.id,left"));

        $curdate = date("Y-m-d H:i:s");

        $buyer_mobile = preg_replace("/[^0-9]+/", "", $buyer_mobile);

        $replace_variables = array(
            "store_name" => $ecom_store_name,
            "store_url" => $store_url,
            "order_no" => $cart_id,
            "order_url" => $order_url,
            "checkout_url" => $checkout_url,
            "my_orders_url" => $my_orders_url,
            "first_name" => $buyer_first_name,
            "last_name" => $buyer_last_name,
            "email" => $buyer_email,
            "mobile" => $buyer_mobile
        );

        $checkout_info = array();
        $confirmation_response = array();
        if ($action_type == 'checkout') {
            $i = 0;
            $elements = array();

            foreach ($cart_info as $key => $value) {
                $elements[$i]['title'] = isset($value['product_name']) ? $value['product_name'] : "";

                $attribute_print = "";
                $attribute_info = json_decode($value["attribute_info"], true);
                if (!empty($attribute_info)) {
                    $attribute_print_tmp = array();
                    foreach ($attribute_info as $key2 => $value2) {
                        $attribute_print_tmp[] = is_array($value2) ? implode('+', array_values($value2)) : $value2;
                    }
                    $attribute_print = implode(', ', $attribute_print_tmp);
                }

                // $subtitle = array_values(json_decode($value["attribute_info"],true));
                // $subtitle = implode(', ', $subtitle);
                $elements[$i]['subtitle'] = $attribute_print;

                $elements[$i]['quantity'] = isset($value['quantity']) ? $value['quantity'] : 1;
                $elements[$i]['price'] = isset($value['unit_price']) ? $value['unit_price'] : 0;
                $elements[$i]['currency'] = $currency;

                // if($value['thumbnail']=='') $image_url = base_url('assets/img/products/product-1.jpg');
                // else $image_url = base_url('upload/ecommerce/'.$value['thumbnail']);

                if ($value['thumbnail'] == '') $image_url = base_url('assets/img/products/product-1.jpg');
                else $image_url = base_url('upload/ecommerce/' . $value['thumbnail']);
                if (isset($value['woocommerce_product_id']) && !is_null($value['woocommerce_product_id']) && $value['thumbnail'] != '')
                    $image_url = $value['thumbnail'];


                $elements[$i]['image_url'] = $image_url;
                $i++;
                $update_sales_count_sql = "UPDATE ecommerce_product SET sales_count=sales_count+" . $value["quantity"] . " WHERE id=" . $value["product_id"];
                $this->basic->execute_complex_query($update_sales_count_sql);
                $update_stock_count_sql = "UPDATE ecommerce_product SET stock_item=stock_item-" . $value["quantity"] . " WHERE stock_item>0 AND id=" . $value["product_id"];
                $this->basic->execute_complex_query($update_stock_count_sql);
            }

            if (empty($buyer_address)) $buyer_address = '-';
            if (empty($buyer_city)) $buyer_city = '-';
            if (empty($buyer_zip)) $buyer_zip = '-';
            if (empty($buyer_state)) $buyer_state = '-';
            if (empty($buyer_country)) $buyer_country = '-';

            if ($cart_data['store_pickup'] == '0')
                $address = array
                (
                    "street_1" => $buyer_address,
                    "street_2" => "",
                    "city" => $buyer_city,
                    "postal_code" => $buyer_zip,
                    "state" => $buyer_state,
                    "country" => $buyer_country
                );
            else
                $address = array
                (
                    "street_1" => "-",
                    "street_2" => "",
                    "city" => "-",
                    "postal_code" => "-",
                    "state" => "-",
                    "country" => "-"
                );

            $recipient_name = $buyer_first_name . " " . $buyer_last_name;
            if (trim($recipient_name == "")) $recipient_name = "-";

            $summary = array
            (
                "subtotal" => $subtotal,
                "shipping_cost" => $shipping,
                "total_tax" => $tax,
                "total_cost" => $payment_amount
            );

            $adjustments = array
            (
                0 => array
                (
                    "name" => $coupon_code,
                    "amount" => $discount
                )
            );

            $payload = array
            (
                "template_type" => "receipt",
                "recipient_name" => $recipient_name,
                "order_number" => $cart_id,
                "currency" => $currency,
                "payment_method" => $payment_method,
                "order_url" => $order_url,
                "timestamp" => time(),
                "address" => $address,
                "summary" => $summary,
                "elements" => $elements
            );
            if ($coupon_code != "") $payload['adjustments'] = $adjustments;

            $messenger_checkout_confirmation = array
            (
                "recipient" => array("id" => $subscriber_id),
                "messaging_type" => "MESSAGE_TAG",
                "tag" => "POST_PURCHASE_UPDATE",
                'message' => array
                (
                    'attachment' =>
                        array
                        (
                            'type' => 'template',
                            'payload' => $payload
                        )
                )
            );

            // Messenger send block
            $sent_response = array();
            $this->load->library("fb_rx_login");
            $page_info = $this->basic->get_data("facebook_rx_fb_page_info", array('where' => array('id' => $page_id)));
            $page_access_token = isset($page_info[0]['page_access_token']) ? $page_info[0]['page_access_token'] : "";

            // template 1
            $intro_text = isset($messenger_content["checkout"]["checkout_text"]) ? $messenger_content["checkout"]["checkout_text"] : "";
            if ($intro_text != "") {
                $intro_text = $this->spin_and_replace($intro_text, $replace_variables);
                $messenger_confirmation_template1 = json_encode(array("recipient" => array("id" => $subscriber_id), "message" => array("text" => $intro_text)));
                $this->send_messenger_reminder($messenger_confirmation_template1, $page_access_token, $store_id, $subscriber_id);
            }

            // template 2
            $messenger_confirmation_template2 = json_encode($messenger_checkout_confirmation);
            $sent_response = $this->send_messenger_reminder($messenger_confirmation_template2, $page_access_token, $store_id, $subscriber_id);

            // template 3
            $after_checkout_text = isset($messenger_content["checkout"]["checkout_text_next"]) ? $messenger_content["checkout"]["checkout_text_next"] : "";
            $after_checkout_btn = isset($messenger_content["checkout"]["checkout_btn_next"]) ? $messenger_content["checkout"]["checkout_btn_next"] : "MY ORDERS";
            if ($after_checkout_text != "") {
                $after_checkout_text = $this->spin_and_replace($after_checkout_text, $replace_variables);
                $messenger_confirmation_template3 = array
                (
                    "recipient" => array("id" => $subscriber_id),
                    'message' => array
                    (
                        'attachment' =>
                            array
                            (
                                'type' => 'template',
                                'payload' =>
                                    array
                                    (
                                        'template_type' => 'button',
                                        'text' => $after_checkout_text,
                                        'buttons' => array(
                                            0 => array(
                                                "type" => "web_url",
                                                "url" => $my_orders_url,
                                                "title" => $after_checkout_btn,
                                                "messenger_extensions" => 'true',
                                                "webview_height_ratio" => 'full'
                                            )
                                        )
                                    ),
                            )
                    )
                );
                $this->send_messenger_reminder(json_encode($messenger_confirmation_template3), $page_access_token, $store_id, $subscriber_id);
            }
            $confirmation_response['messenger'] = $sent_response;
            // Messenger send block


            //  SMS Sending block
            if ($buyer_mobile != "" && $sms_api_id != '0') {
                $checkout_text_sms = isset($sms_content['checkout']['checkout_text']) ? $this->spin_and_replace($sms_content['checkout']['checkout_text'], $replace_variables, false) : "";
                $checkout_text_sms = str_replace(array("'", '"'), array('`', '`'), $checkout_text_sms);

                $sms_response = array("response" => 'missing param', "status" => '0');

                if (trim($checkout_text_sms) != "") {
                    $this->load->library('Sms_manager');
                    $this->sms_manager->set_credentioal($sms_api_id, $user_id);
                    try {
                        $response = $this->sms_manager->send_sms($checkout_text_sms, $buyer_mobile);

                        if (isset($response['id']) && !empty($response['id'])) {
                            $message_sent_id = $response['id'];
                            $sms_response = array("response" => $message_sent_id, "status" => '1');
                        } else {
                            if (isset($response['status']) && !empty($response['status'])) {
                                $message_sent_id = $response["status"];
                                $sms_response = array("response" => $message_sent_id, "status" => '0');
                            }
                        }

                    } catch (Exception $e) {
                        $message_sent_id = $e->getMessage();
                        $sms_response = array("response" => $message_sent_id, "status" => '0');
                    }
                }

                $confirmation_response['sms'] = $sms_response;
            }
            //  SMS Sending block

            //  Email Sending block
            if ($buyer_email != "" && $email_api_id != '0') {
                $checkout_text_email = isset($email_content['checkout']['checkout_text']) ? $this->spin_and_replace($email_content['checkout']['checkout_text'], $replace_variables, false) : "";
                $email_subject = $this->spin_and_replace($email_subject, $replace_variables, false);
                $from_email = "";

                if ($configure_email_table == "email_smtp_config") {
                    $from_email = "smtp_" . $email_api_id;
                } elseif ($configure_email_table == "email_mandrill_config") {
                    $from_email = "mandrill_" . $email_api_id;
                } elseif ($configure_email_table == "email_sendgrid_config") {
                    $from_email = "sendgrid_" . $email_api_id;
                } elseif ($configure_email_table == "email_mailgun_config") {
                    $from_email = "mailgun_" . $email_api_id;
                }

                $email_response = array("response" => 'missing param', "status" => '0');
                if (trim($checkout_text_email) != '') {
                    try {
                        $response = $this->_email_send_function($from_email, $checkout_text_email, $buyer_email, $email_subject, $attachement = '', $filename = '', $user_id);

                        if (isset($response) && !empty($response) && $response == "Submited") {
                            $message_sent_id = $response;
                            if ($message_sent_id == "Submited") $message_sent_id = "Submitted";
                            $email_response = array("response" => $message_sent_id, "status" => '1');
                        } else {
                            $message_sent_id = $response;
                            $email_response = array("response" => $message_sent_id, "status" => '0');
                        }
                    } catch (Exception $e) {
                        $message_sent_id = $e->getMessage();
                        $email_response = array("response" => $message_sent_id, "status" => '0');
                    }
                }
                $confirmation_response['email'] = $email_response;
            }
            //  Email Sending block

            $confirmation_response = json_encode($confirmation_response);
            $this->basic->update_data('ecommerce_cart', array("id" => $cart_id, "subscriber_id" => $subscriber_id), array("confirmation_response" => $confirmation_response));
            if ($coupon_code != "") {
                $coupon_used_sql = "UPDATE ecommerce_coupon SET used=used+1 WHERE coupon_code='" . $coupon_code . "' AND store_id=" . $store_id;
                $this->basic->execute_complex_query($coupon_used_sql);
            }

        }

        // Email Send to Seller

        $product_short_name = $this->config->item('product_short_name');
        $from = $this->config->item('institute_email');
        $mask = $this->config->item('product_name');
        $where = array();
        $where['where'] = array('id' => $user_id);
        $user_email = $this->basic->get_data('users', $where, $select = '');

        // echo $this->db->last_query();
        $order_confirmation_email_template = $this->basic->get_data("email_template_management", array('where' => array('template_type' => 'emcommerce_sale_admin')), array('subject', 'message'));
        if (isset($order_confirmation_email_template[0]) && $order_confirmation_email_template[0]['subject'] != '' && $order_confirmation_email_template[0]['message'] != '') {

            $to = $user_email[0]['email'];
            $url = base_url();

            $subject = str_replace(array('#APP_NAME#', '#APP_URL#', '#STORE_NAME#', '#INVOICE_URL#'), array($mask, $url, $ecom_store_name, $order_url), $order_confirmation_email_template[0]['subject']);

            $message = str_replace(array('#APP_NAME#', '#APP_URL#', '#STORE_NAME#', '#INVOICE_URL#'), array($mask, $url, $ecom_store_name, $order_url), $order_confirmation_email_template[0]['message']);

            //send mail to user
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);
        }
        // End of Email Send to Seller


    }

    private function spin_and_replace($str = "", $replace = array(), $is_spin = true)
    {
        if (!isset($replace['store_name'])) $replace['store_name'] = '';
        if (!isset($replace['store_url'])) $replace['store_url'] = '';
        if (!isset($replace['order_no'])) $replace['order_no'] = '';
        if (!isset($replace['order_url'])) $replace['order_url'] = '';
        if (!isset($replace['checkout_url'])) $replace['checkout_url'] = '';
        if (!isset($replace['my_orders_url'])) $replace['my_orders_url'] = '';
        if (!isset($replace['first_name'])) $replace['first_name'] = '';
        if (!isset($replace['last_name'])) $replace['last_name'] = '';
        if (!isset($replace['email'])) $replace['email'] = '';
        if (!isset($replace['mobile'])) $replace['mobile'] = '';
        $replace_values = array_values($replace);
        $str = str_replace(array("{{store_name}}", "{{store_url}}", "{{order_no}}", "{{order_url}}", "{{checkout_url}}", "{{my_orders_url}}", "{{first_name}}", "{{last_name}}", "{{email}}", "{{mobile}}"), $replace_values, $str);
        if ($is_spin) return spintax_process($str);
        else return $str;
    }

    private function send_messenger_reminder($message = '', $page_access_token = '', $store_id = 0, $subscriber_id = '')
    {
        if (empty($subscriber_id) || strpos($subscriber_id, "sys") !== false) {
            return $sent_response = array("response" => $this->lang->line("Not a Messenger subscriber, message sending was skipped."), "status" => '1');
        }

        $sent_response = array();
        $this->load->library("fb_rx_login");
        try {
            $response = $this->fb_rx_login->send_non_promotional_message_subscription($message, $page_access_token);

            if (isset($response['message_id'])) {
                $sent_response = array("response" => $response['message_id'], "status" => '1');
            } else {
                if (isset($response["error"]["message"]))
                    $sent_response = array("response" => $response["error"]["message"], "status" => '0');
            }

        } catch (Exception $e) {
            $sent_response = array("response" => $e->getMessage(), "status" => '0');
        }
        return $sent_response;
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
            0 => "ALTER TABLE `ecommerce_config` ADD `n_paymongo_pub` VARCHAR(50) NOT NULL DEFAULT '', ADD `n_paymongo_sec` VARCHAR(50) NOT NULL DEFAULT '';",

            1 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_enabled` ENUM('0','1') NOT NULL DEFAULT '0';",

            2 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_paymaya_en` ENUM('0','1') NOT NULL DEFAULT '0';",

            3 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_grab_en` ENUM('0','1') NOT NULL DEFAULT '0';",

            4 => "ALTER TABLE `ecommerce_store` ADD `n_paymongo_gcash_en` ENUM('0','1') NOT NULL DEFAULT '0';"

        );

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


}