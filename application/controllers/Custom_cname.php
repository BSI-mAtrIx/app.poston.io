<?php
//Version v1.9103
require_once("application/controllers/Ecommerce.php"); // loading home controller

if (!function_exists('mec_number_format')) {
    function mec_number_format($number, $decimal_point = 0, $thousand_comma = '0')
    {
        $decimal_point_count = strlen(substr(strrchr($number, "."), 1));


        if ($decimal_point_count > 0 && $decimal_point == 0) $decimal_point = $decimal_point_count; // if setup no deciaml place but the number is naturally float, we can not just skip it

        $number = (float)$number;
        $comma = $thousand_comma == '1' ? ',' : '';
        return number_format($number, $decimal_point, '.', $comma);
    }
}

include(APPPATH.'n_views/include/function_class.php');


class custom_cname extends Ecommerce
{
    var $nstore_id = 0;
    var $check_cn = true;
    var $webhook_url = array();
    var $lp_on = false;
    var $ncd = null;

    public function __construct()
    {
        //parent::__construct();
        Home::__construct();

        $this->load->helpers(array('ecommerce_helper'));

        $function_name = $this->uri->segment(2);
        if (file_exists(APPPATH . 'custom_domain.php')) {
            include(APPPATH . 'custom_domain.php');
            if ($ncd_config['eco_custom_domain'] == 'true') {
                if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
                    $function_name = $this->uri->segment(1);
                }
            }
        }


        if ($function_name == null) {
            $function_name = 'index';
        }


        $private_functions = array("", "", "qr_code", "download_qr", "qr_code_action", "qr_code_live", "notification_settings", "notification_settings_action", "reset_notification", "reset_reminder", "reminder_settings", "reminder_settings_action", "store_list", "copy_url", "order_list", "change_payment_status", "order_list_data", "reminder_send_status_data", "reminder_response", "add_store", "add_store_action", "edit_store", "edit_store_action", "product_list", "product_list_data", "delete_store", "add_product", "add_product_action", "edit_product", "edit_product_action", "delete_product", "payment_accounts", "payment_accounts_action", "attribute_list", "attribute_list_data", "ajax_create_new_attribute", "ajax_get_attribute_update_info", "ajax_update_attribute", "delete_attribute", "category_list", "category_list_data", "ajax_create_new_category", "ajax_get_category_update_info", "ajax_update_category", "delete_category", "coupon_list", "coupon_list_data", "add_coupon", "add_coupon_action", "edit_coupon", "edit_coupon_action", "delete_coupon", "upload_product_thumb", "delete_product_thumb", "upload_store_logo", "delete_store_logo", "upload_store_favicon", "delete_store_favicon", "download_csv", "upload_featured_image", "delete_featured_image", "pickup_point_list", "pickup_point_list_data", "ajax_create_new_pickup_point", "ajax_get_pickup_point_update_info", "ajax_update_pickup_point", "delete_pickup_point", "appearance_settings", "appearance_settings_action", "business_hour_settings", "business_hour_settings_action", "customer_list", "customer_list_data", "change_user_password_action", "download_result", "sort_category", "copy_product", "latest_order_api", "delete_shipping_zone", "ajax_update_shipping_zone", "ajax_get_states_shipping_zone", "ajax_get_shipping_zone_update_info", "ajax_create_new_shipping_zone", "shipping_zone_list_data", "shipping_zone_list", "get_all_delivery_methods", "delete_delivery_methods", "ajax_update_delivery_methods", "ajax_get_delivery_methods_update_info", "ajax_create_new_delivery_methods", "delivery_methods_list_data", "delivery_methods_list");

        if (in_array($function_name, $private_functions)) {
            if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
            if ($this->session->userdata('user_type') != 'Admin' && !in_array(268, $this->module_access)) redirect('home/login', 'location');
            $this->member_validity();
        }
        $this->currency_icon = $this->get_country_new('currecny_icon');
        $this->editor_allowed_tags = '<h1><h2><h3><h4><h5><h6><a><b><strong><p><i><div><span><ul><li><ol><blockquote><code><table><tr><td><th><iframe><img>';
        $this->login_to_continue = $this->lang->line("Please login to continue.");

        $check_cn = true;
        if (file_exists(APPPATH . 'custom_domain.php')) {
            if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
                $xdata = $this->basic->get_data("n_custom_domain", array("where" => array("host_url" => $_SERVER['HTTP_HOST'])));
                if (isset($xdata[0])){
                    $this->ncd = $xdata[0];
                    if($this->ncd['module']==2){
                        $this->lp_on = true;
                    }
                }
            }

            if ($ncd_config['eco_custom_domain'] == 'true' AND $this->lp_on==false) {
                if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
                    $n_cd_data = $this->check_access();
                    $this->nstore_id = $n_cd_data[0]['store_unique_id'];
                    $check_cn = false;
                } elseif ($this->uri->segment(2) == 'store') {
                    $eco_host = $_SERVER['HTTP_HOST'];
                    $nstoreid = $this->get_store_ids($this->uri->segment(3));
                    if ($nstoreid != 0) {
                        $n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
                            "custom_id" => $nstoreid,
                            "active" => 1,
                        )));
                        if (!empty($n_cd_data[0])) {
                            $subscriber_id = $this->session->userdata($nstoreid . "ecom_session_subscriber_id");
                            if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);

                            $nruil = mec_add_get_param('https://' . $n_cd_data[0]['host_url'], array("subscriber_id" => $subscriber_id));
                            redirect($nruil, 'location');
                        }
                    }

                }
            }
        }

        if($this->lp_on == false){
            if ($check_cn == true and !empty($this->uri->segment(2))) {
                if (empty($this->uri->segment(3))) {
                    return;
                }

                switch ($this->uri->segment(2)) {
                    case 'cart';
                    case 'checkout';
                        $n_uri_where = array("ecommerce_cart.id" => $this->uri->segment(3));
                        $n_uri_data = $this->basic->get_data("ecommerce_cart", array('where' => $n_uri_where));

                        if (empty($n_uri_data[0]['store_id'])) {
                            return;
                        }
                        $this->nstore_id = $this->get_store_uq($n_uri_data[0]['store_id']);
                        break;

                    case 'category';

                        $n_uri_where = array("ecommerce_category.id" => $this->uri->segment(3));
                        $n_uri_data = $this->basic->get_data("ecommerce_category", array('where' => $n_uri_where));
                        if (empty($n_uri_data[0]['store_id'])) {
                            return;
                        }
                        $this->nstore_id = $this->get_store_uq($n_uri_data[0]['store_id']);
                        break;

                    case 'my_account';
                        $this->nstore_id = $this->get_store_uq($this->uri->segment(3));
                        break;

                    default;
                        $this->nstore_id = $this->uri->segment(3);
                        break;
                }
            }


            $this->check_cn = $check_cn;

            if (empty($this->is_ecommerce_related_product_exist)) {
                $this->is_ecommerce_related_product_exist = false;
            }
        }




    }

    public function index($page = '', $page2 = '')
    {
        if($this->lp_on){
                $this->view_landing_page($page, $page2);
        }else{
            if(!empty($page)){
                $this->load->view('page/error');
                return;
            }
            $store_id = $this->get_store_id(0);
            $this->store($store_id);
        }

    }

    public function mailform($lp_id){
        include(APPPATH.'modules/n_page_builder/include/lp_mailform.php');
    }

    private function view_landing_page($page, $page2){
        include(APPPATH.'modules/n_page_builder/include/lp_load.php');
    }

    public function reset_password_action(){
        $this->ajax_check();
        $store_id = strip_tags($this->input->post("store_id",true));
        $email = strip_tags($this->input->post("email",true));

        $info = $this->basic->get_data(
            "messenger_bot_subscriber",
            array(
                "where"=>array(
                    "email"=>$email,
                    //"password"=>$password,
                    "subscriber_type"=>"system",
                    "store_id"=>$store_id
                )
            )
        );

        if (count($info) == 0) {
            echo json_encode(array("status"=>"0","message"=>$this->lang->line("invalid email")));
        }else{
            $token = md5(time().$store_id.$email);
            $user_where = [
                'email' => $email,
                "subscriber_type"=>"system",
                'store_id' => $store_id
            ];
            $user_data = [
                'reset_pass_requested' => time(),
                'reset_pass_token' => $token
            ];
            $this->basic->update_data('messenger_bot_subscriber', $user_where, $user_data);

            $cart_where = array('where'=>array("id"=>$info[0]['store_id']));
            $store_config = $this->basic->get_data("ecommerce_store",$cart_where);
            if(empty($store_config)){exit;}
            $store_config = $store_config[0];

            $email_api_id = isset($store_config['email_api_id'])?$store_config['email_api_id']:'0';
            $configure_email_table = isset($store_config['configure_email_table'])?$store_config['configure_email_table']:'';

            if($email!="" && $email_api_id!='0'){

                $reset_password_url = 'ecommerce/reset_password/' . $store_config['store_unique_id'].'?token='.$token;
$reset_password_url= base_url($reset_password_url);

$html_email_build = '<p>'.$this->lang->line('Dear').', '.$info[0]['first_name'].'!</p>
<p>'.$this->lang->line('To reset your password  click the link below:').'</p>

<p><a href="'.$reset_password_url.'" target="_blank">'.$reset_password_url.'</a></p>

<p>'.$this->lang->line('If you did not request a password reset from Our store, you can safely ignore this email.').'</p>

<p>'.$this->lang->line('Yours truly').', <br />
'.$store_config['store_name'].'</p>';


                $email_subject = $this->lang->line('Reset Password').' '.$store_config['store_name'];
                $from_email = "";

                if ($configure_email_table == "email_smtp_config") {
                    $from_email = "smtp_".$email_api_id;
                }elseif ($configure_email_table == "email_mandrill_config"){
                    $from_email = "mandrill_".$email_api_id;
                }elseif ($configure_email_table == "email_sendgrid_config"){
                    $from_email = "sendgrid_".$email_api_id;
                }elseif ($configure_email_table == "email_mailgun_config"){
                    $from_email = "mailgun_".$email_api_id;
                }

                if(trim($html_email_build)!=''){
                    try{
                        $response = $this->_email_send_function($from_email, $html_email_build, $email, $email_subject, $attachement='', $filename='',$this->user_id);

                        if(isset($response) && !empty($response) && $response == "Submited"){
                            echo json_encode(array("status"=>"1","message"=>$this->lang->line("Check your email for confirmation reset password")));
                        }else{
                            echo json_encode(array("status"=>"0","message"=>$this->lang->line("Email cant be send to you. Please contact with store administration.")));
                        }
                    }catch(Exception $e) {
                        $message_sent_id = $e->getMessage();
                    }
                }
            }else{
                echo json_encode(array("status"=>"0","message"=>$this->lang->line("Email cant be send to you. Please contact with store administration.")));
            }
        }
    }

    public function reset_password_action_step_two(){
        $this->ajax_check();
        $store_id = strip_tags($this->input->post("store_id",true));
        $password = strip_tags($this->input->post("password",true));
        $reset_token = strip_tags($this->input->post("reset_token",true));

        $info = $this->basic->get_data(
            "messenger_bot_subscriber",
            array(
                "where"=>array(
                    "reset_pass_token"=>$reset_token,
                    //"password"=>$password,
                    "subscriber_type"=>"system",
                    "store_id"=>$store_id
                )
            )
        );

        if (count($info) == 0) {
            echo json_encode(array("status"=>"0","message"=>$this->lang->line("invalid email")));
        }else{
            if((time() - $info[0]['reset_pass_requested']) > 24*60*60){
                echo json_encode(array("status"=>"0","message"=>$this->lang->line("Link to reset password expired.")));
            }

            $user_where = [
                'email' => $info[0]['email'],
                "subscriber_type"=>"system",
                'store_id' => $store_id
            ];
            $user_data = [
                'password' => md5($password),
                'reset_pass_requested' => 'null',
                'reset_pass_token' => 'null'
            ];
            $this->basic->update_data('messenger_bot_subscriber', $user_where, $user_data);

            echo json_encode(array("status"=>"1","message"=>$this->lang->line("Password to your account are now reseted. You can login now using new password.")));
        }
    }

    public function reset_password($store_unique_id = '')
    {
        $store_data = $this->initial_load_store($store_unique_id);
        $subscriber_id = $this->session->userdata($store_data[0]['id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);


        $subscriber_id = $this->session->userdata($store_data[0]['id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        if ($subscriber_id != "") {
            redirect($this->return_base_url_php('ecommerce/store/' . $store_data[0]['store_unique_id']), 'location');
            exit();
        }

        $fb_app_id = $this->get_app_id();
        $data = array(
            'body' => "reset_password",
            "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Reset Password"),
            "fb_app_id" => $fb_app_id
        );
        $data["social_analytics_codes"] = $store_data[0];
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_data[0]['id']);
        $ecommerce_config = $this->get_ecommerce_config($store_data[0]['id']);
        $data['ecommerce_config'] = $ecommerce_config;

        $category_list = $this->get_category_list($store_data[0]['id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

//        $data["attribute_list"] = $this->get_attribute_list($store_id);
//        $data['currency_icons'] = $this->get_country_new('currecny_icon');
//        $data['ecommerce_config'] = $ecommerce_config;
//        $data['current_cart'] = $this->get_current_cart($subscriber_id,$store_id);
//        $data["show_search"] = true;
//        $data["show_header"] = true;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function login_signup($store_unique_id = '')
    {
        $store_data = $this->initial_load_store($store_unique_id);
        $subscriber_id = $this->session->userdata($store_data[0]['id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);


        $subscriber_id = $this->session->userdata($store_data[0]['id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        if ($subscriber_id != "") {
            redirect($this->return_base_url_php('ecommerce/store/' . $store_data[0]['store_unique_id']), 'location');
            exit();
        }

        $fb_app_id = $this->get_app_id();
        $data = array(
            'body' => "login_signup",
            "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Login / Sign Up"),
            "fb_app_id" => $fb_app_id
        );
        $data["social_analytics_codes"] = $store_data[0];
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_data[0]['id']);
        $ecommerce_config = $this->get_ecommerce_config($store_data[0]['id']);
        $data['ecommerce_config'] = $ecommerce_config;

        $category_list = $this->get_category_list($store_data[0]['id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

//        $data["attribute_list"] = $this->get_attribute_list($store_id);
//        $data['currency_icons'] = $this->get_country_new('currecny_icon');
//        $data['ecommerce_config'] = $ecommerce_config;
//        $data['current_cart'] = $this->get_current_cart($subscriber_id,$store_id);
//        $data["show_search"] = true;
//        $data["show_header"] = true;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function my_orders($store_id = 0)
    {
        $this->my_account($store_id);
    }

    public function logout_n(){
        exit;

        //$this->ajax_check();
        //$store_id = $this->input->post("store_id",true);
        $store_unique_id = $this->input->get("store_unique_id",true);

        var_dump($this->nstore_id); exit;

        $subscriber_id = $this->input->get("subscriber_id",true);
        $this->session->unset_userdata($this->nstore_id."ecom_session_subscriber_id");
        if(strpos($subscriber_id, "sys") !== false && !empty($store_unique_id)){
            redirect($this->return_base_url_php('ecommerce/store/' . $store_unique_id), 'location');
            exit();
        }

    }

    public function my_account($store_id = 0, $subpage = 'my_orders')
    {
        if ($store_id == 0) {
            $store_id = $this->get_store_id($store_id);
        }
        $n_subscriber_info = array();
        $where_subs = array();

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");

        $login_needed = false;
        if ($subscriber_id != "") $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $store_id);
        else {
            if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
            if ($subscriber_id != "") $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
            //$n_subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => $where_subs));
        }

        if ($subscriber_id == '') $login_needed = true;
        else {
            $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");
            $n_subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => $where_subs), '', '', 1);
            if ($subscriber_info[0]['total_rows'] == 0) $login_needed = true;
        }

        $store_data = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $store_id)), "store_name,store_unique_id,store_logo,store_favicon,terms_use_link,refund_policy_link,store_locale,is_rtl,pixel_id,google_id,id,user_id");
        if ($store_id == 0 || !isset($store_data[0])) {
            $not_found = $this->lang->line("Order data not found.");
            echo '<br/><h1 style="text-align:center">' . $not_found . '</h1>';
            exit();
        }
        if ($login_needed) {
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $store_data[0]['store_unique_id']), 'location');
            exit();
        }

        $this->_language_loader($store_data[0]['store_locale']);
        $data['store_data'] = $store_data[0];
        $data['store_id'] = $store_id;
        $data['subscriber_id'] = $subscriber_id;
        $data['body'] = 'ecommerce/my_orders';
        $data['page_title'] = $this->lang->line('My Orders');
        $data['status_list'] = $this->get_payment_status();
        $data["fb_app_id"] = $this->get_app_id();
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_id);
        $data['ecommerce_config'] = $this->get_ecommerce_config($store_id);
        $data["social_analytics_codes"] = $store_data[0];
        if ($login_needed) {
            $data['body'] = 'ecommerce/login_to_continue';
            $data['page_title'] = $this->lang->line('Login to Continue');
        }

        $category_list = $this->get_category_list($store_data[0]['id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        $data["n_subscriber_info"] = $n_subscriber_info[0];
        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function my_orders_data()
    {
        $this->ajax_check();
        $search_value = $this->input->post("search_value");
        $subscriber_id = $this->input->post("search_subscriber_id");
        $pickup = $this->input->post("search_pickup");
        $store_id = $this->input->post("search_store_id");
        $search_status = $this->input->post("search_status");
        $search_date_range = $this->input->post("search_date_range");

        $display_columns_sort =
            array(
                "#",
                "CHECKBOX",
                "id",
                'discount',
                'transaction_id'
            );

        $display_columns =
            array(
                "#",
                'order-id',
                'order-date',
                'order-status',
                'order-total',
                'order-action',

                "CHECKBOX",
                "id",
                'discount',
                'transaction_id'
            );
        $search_columns = array('coupon_code', 'transaction_id', 'ecommerce_cart.id');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns_sort[$sort_index]) ? $display_columns_sort[$sort_index] : 'ecommerce_cart.id';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by = $sort . " " . $order;

        if ($search_status != "") $this->db->where(array("ecommerce_cart.status" => $search_status));
        $where_custom = "action_type='checkout' AND ecommerce_cart.subscriber_id = '" . $subscriber_id . "' AND store_id=" . $store_id;

        if ($search_value != '') {
            foreach ($search_columns as $key => $value)
                $temp[] = $value . " LIKE " . "'%$search_value%'";
            $imp = implode(" OR ", $temp);
            $where_custom .= " AND (" . $imp . ") ";
        }
        if ($search_date_range != "") {
            $exp = explode('|', $search_date_range);
            $from_date = isset($exp[0]) ? $exp[0] : "";
            $to_date = isset($exp[1]) ? $exp[1] : "";
            if ($from_date != "Invalid date" && $to_date != "Invalid date")
                $where_custom .= " AND ecommerce_cart.updated_at >= '{$from_date}' AND ecommerce_cart.updated_at <='{$to_date}'";
        }
        $this->db->where($where_custom);

        $table = "ecommerce_cart";
        $select = "ecommerce_cart.id,action_type,ecommerce_cart.user_id,store_id,subscriber_id,coupon_code,coupon_type,discount,payment_amount,currency,ordered_at,transaction_id,card_ending,payment_method,manual_additional_info,manual_filename,paid_at,ecommerce_cart.status,ecommerce_cart.updated_at,ecommerce_store.store_name,status_changed_note,mashkor_status,mashkor_id";
        $join = array('ecommerce_store' => "ecommerce_store.id=ecommerce_cart.store_id,left");
        $info = $this->basic->get_data($table, $where = '', $select, $join, $limit, $start, $order_by, $group_by = '');

        if ($search_status != "") $this->db->where(array("ecommerce_cart.status" => $search_status));
        $this->db->where($where_custom);
        $total_rows_array = $this->basic->count_row($table, $where = '', $count = $table . ".id", $join, $group_by = '');

        $total_result = $total_rows_array[0]['total_rows'];

        $payment_status = $this->get_payment_status();
        $time = 0;
        $currency_position = "left";
        $decimal_point = 0;
        $thousand_comma = '0';
        foreach ($info as $key => $value) {
            $time++;
            if ($time == 1) {
                $ecommerce_config = $this->get_ecommerce_config($value["store_id"]);
                $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
                $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
                $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
            }

            $config_currency = isset($value['currency']) ? $value['currency'] : "USD";

            if ($value['coupon_code'] != '')
                $info[$key]['discount'] = mec_number_format($info[$key]['discount'], $decimal_point, $thousand_comma);
            else $info[$key]['discount'] = "";

            $payment_amount = $value['currency'] . " " . mec_number_format($info[$key]['payment_amount'], $decimal_point, $thousand_comma);

            if ($info[$key]['payment_method'] == 'Cash on Delivery') $pay = "Cash";
            else $pay = $info[$key]['payment_method'];

            $payment_method = $pay . " " . $info[$key]['card_ending'];
            if (trim($payment_method) == "") $payment_method = "x";

            $transaction_id = ($info[$key]['transaction_id'] != "") ? "<b class='text-primary'>" . $info[$key]['transaction_id'] . "</b>" : "x";

            $updated_at = date("M j,y H:i", strtotime($info[$key]['updated_at']));

            if ($value["paid_at"] != '0000-00-00 00:00:00') {
                $paid_at = date("M j, y H:i", strtotime($info[$key]['paid_at']));
            } else $paid_at = 'x';

            $st1 = $st2 = "";
            $file = base_url('upload/ecommerce/' . $value['manual_filename']);
            $st1 = ($value['payment_method'] == 'Manual') ? $this->handle_attachment($value['id'], $file, true) : "";

            if ($value['payment_method'] == 'Manual')
                $st2 = '<a data-id="' . $value['id'] . '" href="#" class="dropdown-item has-icon additional_info" itle="" data-original-title="' . $this->lang->line("Additional Info") . '"><i class="fas fa-info-circle"></i> ' . $this->lang->line("Payment Info") . '</a>';

            if ($value["action_type"] == "checkout") $invoice = $this->return_base_url_php("ecommerce/order/" . $value['id']);
            else $invoice = $this->return_base_url_php("ecommerce/cart/" . $value['id']);
            $invoice = mec_add_get_param($invoice, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

            $payment_status = $info[$key]['status'];

            if ($payment_status == 'pending') $payment_status_badge = "<span class='text-danger'>" . $this->lang->line("Pending") . "</span>";
            else if ($payment_status == 'approved') $payment_status_badge = "<span class='text-primary'>" . $this->lang->line("Approved") . "</span>";
            else if ($payment_status == 'rejected') $payment_status_badge = "<span class='text-danger'>" . $this->lang->line("Rejected") . "</span>";
            else if ($payment_status == 'shipped') $payment_status_badge = "<span class='text-info'>" . $this->lang->line("Shipped") . "</span>";
            else if ($payment_status == 'delivered') $payment_status_badge = "<span class='text-info'>" . $this->lang->line("Delivered") . "</span>";
            else if ($payment_status == 'completed') $payment_status_badge = "<span class='text-success'>" . $this->lang->line("Completed") . "</span>";

            if(!empty($info[$key]['mashkor_id'])){
                $payment_status_badge .= '<br />Mashkor ID: '.$info[$key]['mashkor_id'];
                switch ($info[$key]['mashkor_status']) {
                    case 0:
                        $info[$key]['mashkor_status'] = 'New';
                        break;
                    case 1:
                        $info[$key]['mashkor_status'] = 'Confirmed';
                        break;
                    case 2:
                        $info[$key]['mashkor_status'] = 'Assigned';
                        break;
                    case 3:
                        $info[$key]['mashkor_status'] = 'Pickup Started';
                        break;
                    case 4:
                        $info[$key]['mashkor_status'] = 'Picked Up';
                        break;
                    case 5:
                        $info[$key]['mashkor_status'] = 'In Delivery';
                        break;
                    case 6:
                        $info[$key]['mashkor_status'] = 'Arrived Destination';
                        break;
                    case 10:
                        $info[$key]['mashkor_status'] = 'Delivered';
                        break;
                    case 11:
                        $info[$key]['mashkor_status'] = 'Canceled';
                        break;
                    default:
                        $info[$key]['mashkor_status'] = 'Unknown Status';
                        break;
                }

                $payment_status_badge .= '<br />Mashkor Status: '.$this->lang->line($info[$key]['mashkor_status']);
            }

            $payment_status_note = ($info[$key]['status_changed_note'] != '') ? htmlspecialchars($info[$key]['status_changed_note']) : "";

            $info[$key]['order-id'] = '<a class="text-job text-primary" href="' . $invoice . '">' . " #" . $value["id"] . "</a>";
            $info[$key]['order-date'] = $updated_at;
            $info[$key]['order-status'] = $payment_status_badge;
            $info[$key]['order-total'] = $payment_amount;
            $info[$key]['order-action'] = '<div style="display:flex; min-width: 200px;flex-direction: column;"><a href="' . $invoice . '" class="dropdown-item has-icon"><i class="fas fa-receipt"></i> ' . $this->lang->line("Invoice") . '</a>' . $st1 . $st2 . '</div>';

//            var_dump($info);
//            $info[$key]['my_data'] = '
//    <div class="activities">
//    <div class="activity">
//    <div class="activity-detail w-100 mb-2">
//    <div class="mb-2">
//    <span class="text-job">'.$updated_at.'</span>
//    <span class="bullet"></span>
//    <a class="text-job text-primary" href="'.$invoice.'">'." #".$value["id"]." (".$payment_amount.')</a>
//    <div class="float-right dropdown ml-3">
//    <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
//    <div class="dropdown-menu">
//    <div class="dropdown-title">'.$this->lang->line("Options").'</div>
//    <a href="'.$invoice.'" class="dropdown-item has-icon"><i class="fas fa-receipt"></i> '.$this->lang->line("Invoice").'</a>
//    '.$st1.'
//    '.$st2.'
//    </div>
//    </div>
//    <span class="float-right text-small">'.$payment_status_badge.'</span>
//    </div>
//    <p>'.$payment_status_note.'</p>
//    </div>
//    </div>
//    </div>';


        }
        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns, $start, $primary_key = "id");
        $data['is_rtl'] = (isset($store_data[0]['is_rtl']) && $store_data[0]['is_rtl'] == '1') ? true : false;
        echo json_encode($data);
    }

    public function order($id = 0) // if $id passed means not ajax, it's loading view
    {
        $pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';
        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
        $store_data_temp = $this->basic->get_data("ecommerce_cart", array("where" => array("id" => $id)), "store_id");
        $store_id_temp = isset($store_data_temp[0]['store_id']) ? $store_data_temp[0]['store_id'] : "0";

        $is_ajax = $this->input->post('is_ajax', true);
        if ($id == 0) $id = $this->input->post('webhook_id', true);
        $subscriber_id = "";

        if ($is_ajax == '1') // ajax call | means it's being loaded inside xerochat admin panel
        {
            $this->ajax_check();
            if ($this->session->userdata('logged_in') != 1) {
                echo '<div class="alert alert-danger text-center">' . $this->lang->line("Access Forbidden") . '</div>';
                exit();
            }
        } else // view load
        {
            $subscriber_id = $this->session->userdata($store_id_temp . "ecom_session_subscriber_id");
            if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true); // if loaded via webview then we will get this
        }

        if ($subscriber_id == "" && $this->session->userdata('logged_in') != 1 and !empty($store_data_temp)) {
            //echo $this->login_to_continue;
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $this->get_store_uq($store_data_temp[0]['store_id'])), 'location');
            exit();
        }

        $select2 = array("ecommerce_cart.*", "first_name", "last_name", "full_name", "profile_pic", "user_location", "email", "image_path", "phone_number", "store_name", "store_type", "store_email", "store_favicon", "store_phone", "store_logo", "store_address", "store_zip", "store_city", "store_country", "store_state", "store_unique_id", "terms_use_link", "refund_policy_link", "store_locale", "is_rtl", "pixel_id", "google_id");
        $join2 = array('messenger_bot_subscriber' => "messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left", 'ecommerce_store' => "ecommerce_store.id=ecommerce_cart.store_id,left");
        $where_simple2 = array("ecommerce_cart.id" => $id);
        if ($subscriber_id != "") $where_simple2['ecommerce_cart.subscriber_id'] = $subscriber_id;
        else $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
        $where2 = array('where' => $where_simple2);
        $webhook_data = $this->basic->get_data("ecommerce_cart", $where2, $select2, $join2);

        if (!isset($webhook_data[0])) {
            $not_found = $this->lang->line("Sorry, we could not find the order you are looking for.");
            if ($is_ajax == '1') echo '<div class="alert alert-danger text-center">' . $not_found . '</div>';
            else echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $not_found . '</h2>';
            exit();
        }
        $webhook_data_final = $webhook_data[0];
        if ($is_ajax != '1') $this->_language_loader($webhook_data_final['store_locale']);
        $country_names = $this->get_country_new();
        $currency_icons = $this->get_country_new('currecny_icon');
        $order_title = $this->lang->line("Order");

        $ecommerce_config = $this->get_ecommerce_config($webhook_data_final['store_id']);
        $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
        $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
        $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
        $whatsapp_send_order_button = isset($ecommerce_config['whatsapp_send_order_button']) ? $ecommerce_config['whatsapp_send_order_button'] : '0';
        $whatsapp_phone_number = isset($ecommerce_config['whatsapp_phone_number']) ? $ecommerce_config['whatsapp_phone_number'] : '';
        $whatsapp_send_order_text = isset($ecommerce_config['whatsapp_send_order_text']) ? $ecommerce_config['whatsapp_send_order_text'] : "";
        // echo "<pre>"; print_r($ecommerce_config); exit;


        $join = array('ecommerce_product' => "ecommerce_product.id=ecommerce_cart_item.product_id,left");
        $product_list = $this->basic->get_data("ecommerce_cart_item", array('where' => array("cart_id" => $id)), array("ecommerce_cart_item.*", "product_name", "thumbnail", "taxable", "woocommerce_product_id"), $join);

        $order_date = date("jS M,Y", strtotime($webhook_data_final['updated_at']));
        $order_date2 = date("d M,y H:i", strtotime($webhook_data_final['updated_at']));
        $wc_first_name = $webhook_data_final['first_name'];
        $wc_last_name = $webhook_data_final['last_name'];
        $wc_buyer_bill = ($webhook_data_final['bill_first_name'] != '') ? $webhook_data_final['bill_first_name'] . " " . $webhook_data_final['bill_last_name'] : $wc_first_name . " " . $wc_last_name;
        $confirmation_response = json_decode($webhook_data_final['confirmation_response'], true);
        $currency = $webhook_data_final['currency'];
        $currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : '$';
        $wc_email_bill = $webhook_data_final['bill_email'];
        $wc_phone_bill = $webhook_data_final['bill_mobile'];
        if(empty($wc_phone_bill)){
            $wc_phone_bill = $webhook_data_final['buyer_mobile'];
        }
        $shipping_cost = $webhook_data_final["shipping"];
        $total_tax = $webhook_data_final["tax"];
        $checkout_amount = $webhook_data_final['payment_amount'];
        $coupon_code = $webhook_data_final['coupon_code'];
        $coupon_type = $webhook_data_final['coupon_type'];
        $coupon_amount = $webhook_data_final['discount'];
        $subtotal = $webhook_data_final['subtotal'];
        $payment_status = $webhook_data_final['status'];
        $currency_left = $currency_right = "";
        if ($currency_position == 'left') $currency_left = $currency_icon;
        if ($currency_position == 'right') $currency_right = $currency_icon;

        $payment_method = $webhook_data_final['payment_method'];
        if ($payment_method != '') $payment_method = $payment_method . " " . $webhook_data_final['card_ending'];

        if ($payment_status == 'pending' && $webhook_data_final['action_type'] == 'checkout') $payment_status_badge = "<span class='text-danger'><i class='fas fa-spinner'></i> " . $this->lang->line("Pending") . "</span>";
        else if ($payment_status == 'approved') $payment_status_badge = "<span class='text-primary'><i class='fas fa-thumbs-up'></i> " . $this->lang->line("Approved") . "</span>";
        else if ($payment_status == 'rejected') $payment_status_badge = "<span class='text-warning'><i class='fas fa-thumbs-down'></i> " . $this->lang->line("Rejected") . "</span>";
        else if ($payment_status == 'shipped') $payment_status_badge = "<span class='text-info'><i class='fas fa-truck'></i> " . $this->lang->line("Shipped") . "</span>";
        else if ($payment_status == 'delivered') $payment_status_badge = "<span class=text-info'><i class='fas fa-truck-loading'></i> " . $this->lang->line("Delivered") . "</span>";
        else if ($payment_status == 'completed') $payment_status_badge = "<span class='text-success'><i class='fas fa-check-circle'></i> " . $this->lang->line("Completed") . "</span>";
        else $payment_status_badge = $payment_status_badge = "<span class='text-danger'><i class='fas fa-times'></i> " . $this->lang->line("Incomplete") . "</span>";

        $order_no = $webhook_data_final['id'];
        $order_url = base_url("ecommerce/order/" . $order_no);

        $buyer_country = isset($country_names[$webhook_data_final["buyer_country"]]) ? ucwords(strtolower($country_names[$webhook_data_final["buyer_country"]])) : $webhook_data_final["buyer_country"];
        $store_country = isset($country_names[$webhook_data_final["store_country"]]) ? ucwords(strtolower($country_names[$webhook_data_final["store_country"]])) : $webhook_data_final["store_country"];

        $tmp_buter_state = $webhook_data_final["buyer_state"];
        if (!empty($webhook_data_final["buyer_zip"])) $tmp_buter_state = $tmp_buter_state . ' ' . $webhook_data_final["buyer_zip"];
        $buyer_address_array = array($webhook_data_final["buyer_address"], $webhook_data_final["buyer_city"], $tmp_buter_state, $buyer_country);
        $buyer_address_array = array_filter($buyer_address_array);
        $buyer_address = implode('<br>', $buyer_address_array);
        $store_name = $webhook_data_final['store_name'];
        $store_type = $webhook_data_final['store_type'];
        $store_address = $webhook_data_final["store_address"] . "<br>" . $webhook_data_final["store_city"] . "<br>" . $webhook_data_final["store_state"] . " " . $webhook_data_final["store_zip"] . "<br>" . $store_country;
        $store_phone = $webhook_data_final["store_phone"];
        $store_email = $webhook_data_final["store_email"];
        $subscriber_id_database = $webhook_data_final["subscriber_id"];
        $store_unique_id = $webhook_data_final["store_unique_id"];
        $store_address2 = $webhook_data_final["store_address"] . "<br>" . $webhook_data_final["store_city"] . ", " . $webhook_data_final["store_state"] . ", " . $store_country . "<br>" . $store_phone;

        $table_bordered = ($is_ajax == '1') ? '' : 'table-bordered';
        $table_data = '<table class="shop_table cart-totals mb-5 mt-5">
										<tbody>											<tr>
												<td colspan="2" class="border-top-0">
													<strong class="text-color-dark">' . $this->lang->line('Product') . '</strong>
												</td>
											</tr>';
        $i = 0;
        $subtotal_count = 0;
        $table_data_print = '
    <table>
    <thead>
    <tr>
    <th class="description">' . $this->lang->line("Item") . '</th>
    <th class="price">' . $this->lang->line("Price") . '</th>
    </tr>
    </thead>
    <tbody>';

        $whatsapp_message_product_info = array();
        foreach ($product_list as $key => $value) {
            $title = isset($value['product_name']) ? $value['product_name'] : "";
            $quantity = isset($value['quantity']) ? $value['quantity'] : 1;
            $price = isset($value['unit_price']) ? $value['unit_price'] : 0;
            $item_total = $price * $quantity;
            $subtotal_count += $item_total;
            $item_total = mec_number_format($item_total, $decimal_point, $thousand_comma);
            $price = mec_number_format($price, $decimal_point, $thousand_comma);

            $image_url = (isset($value['thumbnail']) && !empty($value['thumbnail'])) ? base_url('upload/ecommerce/' . $value['thumbnail']) : base_url('assets/img/example-image.jpg');
            if (isset($value["woocommerce_product_id"]) && !is_null($value["woocommerce_product_id"]) && isset($value['thumbnail']) && !empty($value['thumbnail']))
                $image_url = $value["thumbnail"];

            $permalink = $this->return_base_url_php("ecommerce/product/" . $value['product_id']);
            $attribute_info = (is_array(json_decode($value["attribute_info"], true))) ? json_decode($value["attribute_info"], true) : array();

            $attribute_query_string_array = array();
            $attribute_query_string = "";
            foreach ($attribute_info as $key2 => $value2) {
                $urlencode = is_array($value2) ? implode(',', $value2) : $value2;
                $attribute_query_string_array[] = "option" . $key2 . "=" . urlencode($urlencode);
            }
            $attribute_query_string = implode("&", $attribute_query_string_array);
            if (!empty($attribute_query_string_array)) $attribute_query_string = "&quantity=" . $quantity . "&" . $attribute_query_string;

            $attribute_print = "";
            $attribute_print_for_whatsapp = "";
            if (!empty($attribute_info)) {
                $attribute_print_tmp = array();
                foreach ($attribute_info as $key2 => $value2) {
                    $attribute_print_tmp[] = is_array($value2) ? implode('+', array_values($value2)) : $value2;
                }
                $attribute_print = "<small class='text-muted'>" . implode(', ', $attribute_print_tmp) . "</small>";
                $attribute_print_for_whatsapp = implode(', ', $attribute_print_tmp);
            }

            if (!empty($attribute_print_for_whatsapp)) {
                $attribute_print_for_whatsapp = ' (' . $attribute_print_for_whatsapp . ')';
            }
            // if($subscriber_id!='') $permalink.="?subscriber_id=".$subscriber_id.$attribute_query_string;

            if ($subscriber_id != '' || $pickup != "")
                $permalink = mec_add_get_param($permalink, array("subscriber_id" => $subscriber_id, "pickup" => $pickup)) . $attribute_query_string;

            // for whatsapp send order message
            $product_info = $title . $attribute_print_for_whatsapp . ' - ' . $quantity . ' piece' . ' - ' . $currency_icon . $price;
            array_push($whatsapp_message_product_info, $product_info);
            // for whatsapp send order message
            if (!empty($currency_left)) {
                $currency_left = $currency_left . ' ';
            }

            $i++;
            $off = $value["coupon_info"];
            if ($off != "") $off .= " " . $this->lang->line("OFF");
            $table_data .= '											<tr>
												<td> 
												<a href="' . $permalink . '" class="d-print-none-thermal d-print-none">
													<strong class="d-block text-color-dark line-height-1 font-weight-semibold">' . $title . '<span class="product-qty"> x' . $quantity . '</span></strong></a>
													<span class="text-1 text-uppercase">' . $attribute_print . ' ' . $currency_left . $price . $currency_right . '</span>
													
													
												</td>
												<td class="text-right align-top">
													<strong class="amount font-weight-medium text-uppercase">' . $currency_left . $item_total . $currency_right . '</strong>
												</td>
											</tr>';


            $table_data_print .= '
      <tr>
      <th class="description">' . $title . ' (' . $quantity . ')<br><small>' . $attribute_print . '</small></th>
      <th class="price">' . $currency_left . $item_total . $currency_right . '</th>
      </tr>';
        }

        $table_data_print .= '</tbody></table>';

        if ($coupon_code == "") $coupon_info = "";
        else $coupon_info = '<div class="section-title">' . $this->lang->line("Coupon") . ' : ' . $coupon_code . '</div>';

        $coupon_info2 = "";
        if ($coupon_code != '' && $coupon_type == "fixed cart")
            $coupon_info2 =
                '<div class="invoice-detail-item">
    <div class="invoice-detail-name">' . $this->lang->line("Discount") . '</div>
    <div class="invoice-detail-value text-uppercase">-' . $currency_left . mec_number_format($coupon_amount, $decimal_point, $thousand_comma) . $currency_right . '</div>
    </div>';

        $tax_info = "";
        if ($total_tax > 0)
            $tax_info =
                '<div class="invoice-detail-item">
    <div class="invoice-detail-name">' . $this->lang->line("Tax") . '</div>
    <div class="invoice-detail-value text-uppercase">+' . $currency_left . mec_number_format($total_tax, $decimal_point, $thousand_comma) . $currency_right . '</div>
    </div>';

        $shipping_info = "";
        if ($shipping_cost > 0)
            $shipping_info =
                '<div class="invoice-detail-item">
    <div class="invoice-detail-name">' . $this->lang->line("Delivery Charge") . ' ('.$this->lang->line($webhook_data_final['n_shipping_method']).') </div>
    <div class="invoice-detail-value text-uppercase">+' . $currency_left . mec_number_format($shipping_cost, $decimal_point, $thousand_comma) . $currency_right . '</div>
    </div>';

        $delivery_time = !empty($webhook_data_final['delivery_time']) ? "" . $webhook_data_final['delivery_time'] . "" : "";

        $shipping_info .=
            '<div class="invoice-detail-item">
    <div class="invoice-detail-name">' . $this->lang->line("Delivery Time") .' </div>
    <div class="invoice-detail-value text-uppercase">' . $delivery_time . '</div>
    </div>';


        // $coupon_code." (".$currency_icon.$coupon_amount.")";

        if ($webhook_data_final['action_type'] != 'checkout') $subtotal = $subtotal_count;
        $subtotal = mec_number_format($subtotal, $decimal_point, $thousand_comma);
        $checkout_amount = mec_number_format($checkout_amount, $decimal_point, $thousand_comma);
        $coupon_amount = mec_number_format($coupon_amount, $decimal_point, $thousand_comma);

        if ($subscriber_id == '') {
            $wc_buyer_bill_formatted = '<a href="' . base_url('subscriber_manager/bot_subscribers/' . $subscriber_id_database) . '">' . $wc_buyer_bill . '</a>'; //todo: bad url
            $store_name_formatted = '<a href="' . $this->return_base_url_php('ecommerce/store/' . $store_unique_id) . '">' . $store_name . '</a>';
            $store_image = ($webhook_data_final['store_logo'] != '' && $is_ajax != '1') ? '<div class="col-lg-12 text-center d-print-none-thermal"><a href="' . $this->return_base_url_php('ecommerce/store/' . $store_unique_id) . '"><img style="max-height:50px" src="' . base_url("upload/ecommerce/" . $webhook_data_final['store_logo']) . '"></a><hr class="m-3 mb-4"></div>' : '';
        } else {
            $wc_buyer_bill_formatted = $wc_buyer_bill;
            $tempu = $this->return_base_url_php('ecommerce/store/' . $store_unique_id);
            $tempu = mec_add_get_param($tempu, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
            $store_name_formatted = '<a href="' . $tempu . '">' . $store_name . '</a>';
            $store_image = ($webhook_data_final['store_logo'] != '' && $is_ajax != '1') ? '<div class="col-lg-12 text-center d-print-none-thermal"><a href="' . $tempu . '"><img style="max-height:50px" src="' . base_url("upload/ecommerce/" . $webhook_data_final['store_logo']) . '"></a><hr class="m-3 mb-4"></div>' : '';
        }

        if ($is_ajax == '1') $order_details = '<h5>' . $order_title . ' #<a href="' . $order_url . '">' . $order_no . '</a></h5>';
        else $order_details = '<h5>' . $order_title . ' #' . $order_no . '</h5>';


        $order_details_print = '<h5>#' . $order_no . ' (' . $order_date2 . ')</h5>';


        $output = "";
        $coupon_details_print = "";
        $after_checkout_details = "";
        $payment_method_deatils = '';

        $coupon_details = '<div class="col-7">' . $payment_method_deatils . '</div>';

        $hide_on_modal = '';
        $hide_on_modal_md = 'd-sm-block';
        if ($is_ajax == '1') {
            $hide_on_modal = 'd-none';
            $hide_on_modal_md = 'd-none';
        }

        if ($webhook_data_final['action_type'] == 'checkout') {
            $after_checkout_details =
                $coupon_info2 . $shipping_info . $tax_info . '
      <hr class="mt-2 mb-2">
      <div class="invoice-detail-item">
      <div class="invoice-detail-name">' . $this->lang->line("Total") . '</div>
      <div class="invoice-detail-value text-uppercase">(' . $currency . ') ' . $currency_left . $checkout_amount . $currency_right . '</div>
      </div>';

            $delivery_note = !empty($webhook_data_final['delivery_note']) ? "<br>(" . $webhook_data_final['delivery_note'] . ")" : "";

            $receipt_name = !empty($webhook_data_final['buyer_first_name']) ? $webhook_data_final['buyer_first_name'] . " " . $webhook_data_final['buyer_last_name'] : $wc_buyer_bill;
            $recipt_address = $webhook_data_final['store_pickup'] == '1' ? $webhook_data_final['pickup_point_details'] : $buyer_address;
            $contact_address = $webhook_data_final["buyer_email"];
            if (!empty($webhook_data_final["buyer_mobile"])) $contact_address .= ' , ' . $webhook_data_final["buyer_mobile"];

          if($webhook_data_final['store_pickup'] == '1'){
              $name_deliver_to = "Store Pickup";
          }else{
              $name_deliver_to = "Deliver to";
          }

            $coupon_details =
                '<div class="col-7 d-print-none-thermal">
      ' . $coupon_info . $payment_method_deatils . '
      <div class="title">' . $this->lang->line($name_deliver_to) . ' ('.$this->lang->line($webhook_data_final['n_shipping_method']).') </div>
      <p class="section-lead ml-0">
      ' . $receipt_name . "<br>" . $recipt_address . '<br>' . $contact_address . '<small>' . $delivery_note . '</small>
      </p>  
      </div>';

            $coupon_details_print =
                '<div class="d-print-thermal ' . $hide_on_modal . '">' . $order_details_print . '</div>
      <div class="d-print-thermal ' . $hide_on_modal . '">
      <p class="section-lead m-0 text-center small">
      ' . $store_address2 . '
      </p>
      <br>
      <p class="section-lead m-0 text-left">
      ' . $this->lang->line("Customer") . " : " . $receipt_name . "<br>" . $recipt_address . '
      </p>  
      </div>';
        }
        $padding = ($is_ajax == '1') ? "padding:40px" : "padding:25px;margin:20px 0;";

        $user_loc = "";
        if ($webhook_data_final['bill_first_name'] == '') {
            $tmp = json_decode($webhook_data_final['user_location'], true);
            if (is_array($tmp)) {
                $user_country = isset($tmp['country']) ? $tmp['country'] : "";
                $country_name = isset($country_names[$user_country]) ? ucwords(strtolower($country_names[$user_country])) : $user_country;
                $tmp["country"] = $country_name;
                if (isset($tmp["state"]) && isset($tmp["zip"])) {
                    $tmp["state"] = $tmp["state"] . " " . $tmp["zip"];
                    unset($tmp["zip"]);
                }
                $user_loc = implode('<br>', $tmp);
            }
        } else {
            $user_country = isset($webhook_data_final['bill_country']) ? $webhook_data_final['bill_country'] : "";
            $country_name = isset($country_names[$user_country]) ? ucwords(strtolower($country_names[$user_country])) : $user_country;

            $tmp = array($webhook_data_final['bill_address'], $webhook_data_final['bill_city'], $webhook_data_final['bill_state'], $country_name);
            if (isset($tmp["bill_state"]) || isset($tmp["bill_zip"])) $tmp["bill_state"] = $tmp["bill_state"] . " " . $tmp["bill_zip"];
            unset($tmp["bill_zip"]);
            $tmp = array_filter($tmp);
            $user_loc = implode('<br>', $tmp);
        }

        $pay_message = "";
        if ($subscriber_id != "") {
            $payment_action = $this->input->get("action", true);
            $payment_status_message = $payment_status = '';
            if ($payment_action != "") {
                if ($payment_action == "success") {
                    $invoice_link = $this->return_base_url_php("ecommerce/my_orders/" . $webhook_data_final['store_id']);
                    $invoice_link = mec_add_get_param($invoice_link, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                    $message = "<i class='fas fa-check-circle'></i> " . $this->lang->line('Your payment has been received successfully and order will be processed soon. It may take few seconds to change your payment status depending on PayPal request.');
                    $payment_status = '1';
                    $payment_status_message = $message;
                } else if ($payment_action == "success3") {
                    $invoice_link = $this->return_base_url_php("ecommerce/my_orders/" . $webhook_data_final['store_id']);
                    $invoice_link = mec_add_get_param($invoice_link, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                    $message = "<i class='fas fa-check-circle'></i> " . $this->lang->line('Your payment has been received successfully and order will be processed soon.');
                    $payment_status = '1';
                    $payment_status_message = $message;
                } else if ($payment_action == "success2") {
                    $invoice_link = $this->return_base_url_php("ecommerce/my_orders/" . $webhook_data_final['store_id']);
                    $invoice_link = mec_add_get_param($invoice_link, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                    $message = "<i class='fas fa-check-circle'></i> " . $this->lang->line('Your order has been placed successfully and is now being reviewed.');
                    $payment_status = '1';
                    $payment_status_message = $message;
                } else if ($payment_action == "cancel") {
                    $message = "<i class='fas fa-times-circle'></i> " . $this->lang->line('Payment was failed to process.');
                    $payment_status = '0';
                    $payment_status_message = $message;
                }
            }

            if ($payment_status == '1')
                $pay_message = "<div class='alert alert-success d-print-none-thermal text-center mt-2 mb-0 ml-0 mr-0'>" . $payment_status_message . "</div>";
            else if ($payment_status == '0')
                $pay_message = "<div class='alert alert-danger d-print-none-thermal text-center mt-2 mb-0 ml-0 mr-0'>" . $payment_status_message . "</div>";
        }

        $hide_order = '';
        $no_order = '';
        if (count($product_list) == 0) {
            $hide_order = 'd-none';
            $no_order = '
      <div class="col-12">
      <div class="empty-state">
      <img class="img-fluid" style="height: 300px" src="' . base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg') . '" alt="image">
      <h2 class="mt-0">' . $this->lang->line("Cart is empty") . '</h2>
      <p class="lead">' . $this->lang->line("There is no product added to cart.") . '</p>
      </div>
      </div>
      ';
        }

        $print_button_text = ($this->session->userdata('user_id') != '') ? $this->lang->line("Large") . ' <b>A4</b>' : '<i class="fas fa-print"></i> ' . $this->lang->line("Print");
        $thermal_hide = ($this->session->userdata('user_id') != '') ? '' : 'd-none';
        $go_back_hide = ($this->session->userdata('user_id') != '') ? 'd-none' : '';

        $tempu2 = $this->return_base_url_php('ecommerce/store/' . $store_unique_id);
        $tempu2 = mec_add_get_param($tempu2, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

        $output .=
            '<div class="d-print-none pt-2 text-center d-block m-auto ' . $hide_on_modal_md . '">
   
    <p class="mb-0 ' . $thermal_hide . '"><b>' . $this->lang->line("Print Options") . '</b></p>
    <div class="text-center" role="group" aria-label="">
    <button type="button" id="large-print" class="btn-sm btn btn-outline-primary print-options no_radius">' . $print_button_text . '</button>
    <button type="button" id="thermal-print" class="' . $thermal_hide . ' btn-sm btn btn-outline-primary print-options no_radius">' . $this->lang->line("Thermal") . ' <b>80mm</b></button>
    <button type="button" id="mobile-print" class="' . $thermal_hide . ' btn-sm btn btn-outline-primary print-options no_radius">' . $this->lang->line("Thermal") . ' <b>57mm</b></button>
    </div>
    </div>';

        $userid = $webhook_data_final['user_id'];
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $userid]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $output .= '<div class="text-center mt-3 ext_buttons">';
        // this section is for send order to whatsapp (start)
        if ($this->basic->is_exist("modules", array("id" => 310))) {

            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(310, $store_user_module_ids)) {

                $product_names_string = implode("\r\n", $whatsapp_message_product_info);

                if ($whatsapp_send_order_text == '') {
                    $whatsapp_send_order_text = 'New Order #{{order_no}}

            Customer: {{customer_info}}

            {{product_info}}

            Order Status: {{order_status}}
            Order URL: {{order_url}}
            Payment Method: {{payment_method}}

            Tax: {{tax}}
            Total Price: {{total_price}}
            {{delivery_address}}';
                }

                if (isset($recipt_address))
                    $recipt_address = str_replace("<br>", "\r\n", $recipt_address);
                else
                    $recipt_address = "";

                $order_urrls = $this->return_base_url_php("ecommerce/order/" . $order_no . '?subscriber_id=' . $subscriber_id . "&action=success2");
                $taxes = $currency_left . mec_number_format($total_tax, $decimal_point, $thousand_comma);

                $whatsapp_send_order_text = str_replace(array('{{order_no}}', '{{customer_info}}', '{{product_info}}', '{{order_status}}', '{{order_url}}', '{{payment_method}}', '{{tax}}', '{{total_price}}', '{{delivery_address}}'), array($order_no, $wc_buyer_bill, $product_names_string, $webhook_data_final['status'], $order_urrls, $payment_method, $taxes, $currency_icon . $checkout_amount, $recipt_address), $whatsapp_send_order_text);

                $output_js = '';

                // echo "<pre>"; print_r($whatsapp_send_order_text); exit;
                if ($whatsapp_send_order_button == '1' && $this->session->userdata('logged_in') != 1) {
                    $output .= '<div class="send_order_whatsapp mr-1 d-inline"></div>';
                    $output_js .= "<script>
            var is_mobile = false;
            var whatsapp_button = '';
            $(document).ready(function() {
              if( $('#device-check').css('display')=='none') {
                is_mobile = true;
                whatsapp_button = '<a href=\"whatsapp://send/?phone=" . $whatsapp_phone_number . "&text=" . urlencode($whatsapp_send_order_text) . "\" class=\"btn btn-success\"><i class=\"fab fa-whatsapp\"></i> " . $this->lang->line('Send Order In WhatsApp') . "</a>';
                } else {
                  whatsapp_button = '<a href=\"https://api.whatsapp.com/send?phone=phone=" . $whatsapp_phone_number . "&text=" . urlencode($whatsapp_send_order_text) . "\" class=\"btn btn-success\"><i class=\"fab fa-whatsapp\"></i> " . $this->lang->line('Send Order In WhatsApp') . "</a>';
                }
                $('.send_order_whatsapp').html(whatsapp_button);
                });
                </script>";
                }
            }
        }
        // this section is for send order to whatsapp (end)

        if (isset($store_type) && $store_type == 'digital') {
            if ($this->basic->is_exist("modules", array("id" => 316))) {
                if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(316, $store_user_module_ids)) {
                    if ($this->session->userdata('logged_in') != 1) {
                        $output .= '<div class="ml-1 d-inline"><a target="_BLANK" href="' . base_url("ecommerce/digital_product_orders/") . $store_id_temp . '/' . $order_no . '?subscriber_id=' . $subscriber_id . '" class="btn btn-primary"><i class="fas fa-cloud-download-alt"></i> Download Orders</a></div>';
                    }
                }

            }
        }
        $output .= '</div>';

        $output .= '<section class="section" id="print-area">
        ' . $pay_message . '
        <div class="section-body">
        <div class="invoice" style="border:1px solid #dee2e6;' . $padding . '">
        <div class="invoice-print">
        <div class="row">
        ' . $store_image . '
        <h4 class="d-print-thermal ' . $hide_on_modal . '">' . $store_name . '</h4>
        ' . $no_order . '
        <div class="col-lg-12 ' . $hide_order . '">
        <div class="invoice-title d-print-none-thermal">
        <div class="d-md-flex justify-content-between py-3 px-4 my-4  d-print-none-thermal">
								<div class="text-center">
									<span>
										' . $this->lang->line('Order Number') . ' <br>
										<strong class="text-color-dark">' . $order_details . '</strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										' . $this->lang->line('Date') . ' <br>
										<strong class="text-color-dark">' . $order_date . '</strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										' . $this->lang->line('Email') . ' <br>
										<strong class="text-color-dark">' . $wc_email_bill . '</strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										' . $this->lang->line('Total') . ' <br>
										<strong class="text-color-dark text-uppercase">(' . $currency . ') ' . $currency_left . $checkout_amount . $currency_right . '</strong>
									</span>
								</div>
								<div class="text-center mt-4 mt-md-0">
									<span>
										' . $this->lang->line('Payment Method') . ' <br>
										<strong class="text-color-dark">' . $payment_status_badge . '<br>' . $payment_method . '</strong>
									</span>
								</div>
							</div>

        </div>
        <br class="d-print-none-thermal">
        <div class="row d-print-none-thermal">
        <div class="col-6">
        <address>
        <strong>' . $this->lang->line("Bill to") . ':</strong><br><br>
        ' . $wc_buyer_bill_formatted . '
        <br>                        
        <span class="d-print-none-thermal">' . $user_loc . '<br>                     
        ' . $wc_email_bill . '<br>                         
        ' . $wc_phone_bill . '</span>
        </address>
        </div>
        <div class="col-6 text-right">
        <address>
        <strong>' . $this->lang->line("Seller") . ':</strong><br><br>
        ' . $store_name_formatted . '<br>
        ' . $store_address . '<br>
        </address>
        </div>
        </div>
        <div class="d-print-thermal">' . $coupon_details_print . ' '. $this->lang->line("Phone").': ' . $wc_phone_bill . '</div>
        </div>
        </div>

        <div class="row ' . $hide_order . '">
        <div class="col-md-12 shop-table ">
        <span class="d-print-none-thermal">' . $table_data . '</tbody>
									</table></span>
        <span class="d-print-thermal ' . $hide_on_modal . '">' . $table_data_print . '</span>
        <div class="row">
        ' . $coupon_details . '
        <div class="col-5 text-right">
        <div class="invoice-detail-item"  style="margin-top: 20px;">
        <div class="invoice-detail-name">' . $this->lang->line("Subtotal") . '</div>
        <div class="invoice-detail-value text-uppercase">' . $currency_left . $subtotal . $currency_right . '</div>
        </div>
        ' . $after_checkout_details . '
        </div>
        </div>
        </div>
        </div>
        </div>              
        </div>
        </div>
        </section>';
        if (!$is_ajax) $output .= "<div style='height:60px'></div>";

        if ($webhook_data_final['action_type'] == 'checkout' && $is_ajax == '1') {
            $messenger_confirmation_badge = '<span class="badge badge-light badge-pill">' . $this->lang->line("Unknown") . '</span>';
            if (isset($confirmation_response['messenger'])) {
                if (isset($confirmation_response['messenger']['status']) && $confirmation_response['messenger']['status'] == '1') $messenger_confirmation_badge = '<span data-toggle="tooltip" title="' . htmlspecialchars($confirmation_response['messenger']['response']) . '" class="badge badge-success badge-pill">' . $this->lang->line("Sent") . '</span>';
                else if (isset($confirmation_response['messenger']['status']) && $confirmation_response['messenger']['status'] == '0') $messenger_confirmation_badge = '<span data-toggle="tooltip" title="' . htmlspecialchars($confirmation_response['messenger']['response']) . '" class="badge badge-danger badge-pill">' . $this->lang->line("Error") . '</span>';
                else $messenger_confirmation_badge = '<span class="badge badge-dark badge-pill">' . $this->lang->line("Not Set") . '</span>';
            }
            $messenger_li = '<li class="list-group-item d-flex justify-content-between align-items-center">
          ' . $this->lang->line("Messenger Confirmation") . '
          ' . $messenger_confirmation_badge . '
          </li>';

            $sms_li = $email_li = "";
            if ($this->session->userdata('user_type') == 'Admin' || in_array(264, $this->module_access)) {
                $sms_confirmation_badge = '<span class="badge badge-light badge-pill">' . $this->lang->line("Unknown") . '</span>';
                if (isset($confirmation_response['sms'])) {
                    if (isset($confirmation_response['sms']['status']) && $confirmation_response['sms']['status'] == '1') $sms_confirmation_badge = '<span data-toggle="tooltip" title="' . htmlspecialchars($confirmation_response['sms']['response']) . '" class="badge badge-success badge-pill">' . $this->lang->line("Sent") . '</span>';
                    else if (isset($confirmation_response['sms']['status']) && $confirmation_response['sms']['status'] == '0') $sms_confirmation_badge = '<span data-toggle="tooltip" title="' . htmlspecialchars($confirmation_response['sms']['response']) . '" class="badge badge-danger badge-pill">' . $this->lang->line("Error") . '</span>';
                    else $sms_confirmation_badge = '<span class="badge badge-dark badge-pill">' . $this->lang->line("Not Set") . '</span>';
                }
                $sms_li = '<li class="list-group-item d-flex justify-content-between align-items-center">
            ' . $this->lang->line("SMS Confirmation") . '
            ' . $sms_confirmation_badge . '
            </li>';
            }

            if ($this->session->userdata('user_type') == 'Admin' || in_array(263, $this->module_access)) {
                $email_confirmation_badge = '<span class="badge badge-light badge-pill">' . $this->lang->line("Unknown") . '</span>';
                if (isset($confirmation_response['email'])) {
                    if (isset($confirmation_response['email']['status']) && $confirmation_response['email']['status'] == '1') $email_confirmation_badge = '<span data-toggle="tooltip" title="' . htmlspecialchars($confirmation_response['email']['response']) . '" class="badge badge-success badge-pill">' . $this->lang->line("Sent") . '</span>';
                    else if (isset($confirmation_response['email']['status']) && $confirmation_response['email']['status'] == '0') $email_confirmation_badge = '<span data-toggle="tooltip" title="' . htmlspecialchars($confirmation_response['email']['response']) . '" class="badge badge-danger badge-pill">' . $this->lang->line("Error") . '</span>';
                    else $email_confirmation_badge = '<span class="badge badge-dark badge-pill">' . $this->lang->line("Not Set") . '</span>';
                }
                $email_li = '<li class="list-group-item d-flex justify-content-between align-items-center">
            ' . $this->lang->line("Email Confirmation") . '
            ' . $email_confirmation_badge . '
            </li>';
            }
            $output .=
                '
          <section class="section">
          <div class="section-body">
          <div class="invoice" style="border:1px solid #dee2e6;">
          <div class="invoice-print">
          <div class="row">
          <div class="col-12">
          <div class="invoice-title">
          <h6>' . $this->lang->line("Checkout Confirmation") . '</h6>
          <div class="invoice-number"></div>
          </div>
          <hr>
          <ul class="list-group">
          ' . $messenger_li . $sms_li . $email_li . '
          </ul>
          </div>
          </div>              
          </div>
          </div>
          </div>
          </section>
          ';
            $output .= "<script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";
        }

        $output .= "<style>.section .section-title{margin:20px 0 20px 0;}</style>";

        if ($is_ajax == '1') {
            if ($webhook_data_final['action_type'] == 'checkout') $report_where = array("where" => array("cart_id" => $id, "is_sent" => "1"));
            else $report_where = array("where" => array("cart_id" => $id));

            $reminder_report_data = $this->basic->get_data("ecommerce_reminder_report", $report_where, '', '', '', '', 'sent_at DESC');

            $tableBody = '';
            $trsl = 0;
            foreach ($reminder_report_data as $keyReport => $valueReport) {
                $trsl++;

                if ($valueReport["is_sent"] == '1' && $valueReport["sent_at"] != "0000-00-00 00:00:00")
                    $sent_time_tmp = date("M j, y H:i", strtotime($valueReport["sent_at"]));
                else $sent_time_tmp = '<span class="text-muted">X<span>';

                $subscriber_id_tmp = "<a href='" . base_url("subscriber_manager/bot_subscribers/" . $valueReport['subscriber_id']) . "' target='_BLANK'>" . $valueReport['subscriber_id'] . "</a>";
                $last_updated_at_tmp = date("M j, y H:i", strtotime($valueReport['last_updated_at']));

                $response_tmp = "<a class='btn btn-sm btn-outline-primary woo_error_log' href='' data-id='" . $valueReport['id'] . "'><i class='fas fa-plug'></i> " . $this->lang->line('Response') . "</a>";
                $cart_id_tmp = "<a target='_BLANK' href='" . base_url('ecommerce/order/' . $valueReport['cart_id']) . "'>" . $this->lang->line('Order') . '#' . $valueReport['cart_id'] . "</a>";

                $tableBody .= '
            <tr>
            <td>' . $trsl . '</td>
            <td class="text-center">' . $valueReport["last_completed_hour"] . '</td>
            <td>' . $response_tmp . '</td>
            <td class="text-center">' . $sent_time_tmp . '</td>
            <td>' . $cart_id_tmp . '</td>
            </tr>';
            }
            if (empty($reminder_report_data)) $tableBody .= '<tr><td class="text-center" colspan="5">' . $this->lang->line("No data found") . '</td></tr>';

            if (count($product_list) > 0) $output .= '
          <section class="section">
          <div class="section-body">
          <div class="invoice" style="border:1px solid #dee2e6;">
          <div class="invoice-print">
          <div class="row">
          <div class="col-12">
          <div class="invoice-title">
          <h6>' . $this->lang->line("Abandoned Cart Reminder Report") . '</h6>
          <div class="invoice-number"></div>
          </div>
          <hr>
          <div class="data-card">
          <div class="table-responsive2">
          <table class="table table-bordered" id="myTableReport">
          <thead>
          <tr>
          <th>#</th>
          <th>' . $this->lang->line("Reminder Hour") . '</th>
          <th>' . $this->lang->line("API Response") . '</th>
          <th>' . $this->lang->line("Sent at") . '</th>
          <th>' . $this->lang->line("Order") . '</th>
          </tr>
          </thead>
          <tbody>' . $tableBody . '</tbody>
          </table>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </section>';

            if ($webhook_data_final['action_type'] == 'checkout' && $is_ajax == '1') {
                $resp = json_decode($webhook_data_final['checkout_source_json'], true);
                $resp = "<pre>" . var_export($resp, true) . "</pre>";
                $output .= '
            <section class="section">
            <div class="section-body">
            <div class="invoice" style="border:1px solid #dee2e6;">
            <div class="invoice-print">
            <div class="row">
            <div class="col-12">
            <div class="invoice-title">
            <h6>' . $this->lang->line("Payment API Response") . '</h6>
            <div class="invoice-number"></div>
            </div>
            <hr>
            ' . $resp . '
            </div>
            </div>
            </div>
            </div>
            </div>
            </section>';
            }

            echo $output;
        } else {
            $fb_app_id = $this->get_app_id();
            $data = array('output' => $output, "page_title" => $store_name . " | Order# " . $order_no, "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $webhook_data_final['store_favicon']));
            $data['current_cart'] = $this->get_current_cart($subscriber_id, $webhook_data_final['store_id']);
            $data['body'] = 'order';
            $data['current_cart'] = $this->get_current_cart($subscriber_id, $webhook_data_final['store_id']);
            $data['ecommerce_config'] = $this->get_ecommerce_config($webhook_data_final["store_id"]);

            $category_list = $this->get_category_list($webhook_data_final["store_id"], true);
            $cat_info = array();
            foreach ($category_list as $value) {
                $cat_info[$value['id']] = $value['category_name'];
            }
            $data["category_list"] = $cat_info;
            $data["category_list_raw"] = $category_list;

            if (empty($output_js)) {
                $output_js = '';
            }
            $data['output_js'] = $output_js;

            $data["social_analytics_codes"] = $webhook_data_final;
//            include(APPPATH."views/ecommerce/common_style.php");
            $data['is_rtl'] = (isset($webhook_data_final['is_rtl']) && $webhook_data_final['is_rtl'] == '1') ? true : false;

            $this->load->view('ecommerce/bare-theme', $data);
        }

    }

    function empty_cart($store_unique_id = 0)
    {
        $store_unique_id = $this->get_store_id($store_unique_id);
        if ($store_unique_id == 0) exit();

        $store_data = $this->initial_load_store($store_unique_id);
        $n_eco_builder_config = $this->get_config();

        $where_subs = array();
        $n_subscriber_info = array();
        $subscriber_id = $this->session->userdata($store_data[0]['id'] . "ecom_session_subscriber_id");

        if (empty($subscriber_id)) $subscriber_id = $this->input->get("subscriber_id", true);
        if (empty($subscriber_id)) $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $store_data[0]['id']);
        else {

            if (empty($subscriber_id)) $subscriber_id = $this->input->get("subscriber_id", true);
            if (!empty($subscriber_id)) $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
            //$n_subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => $where_subs));
        }

        if (empty($subscriber_id)) $login_needed = true;
        else {
            $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");
            //$n_subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => $where_subs));
            if ($subscriber_info[0]['total_rows'] == 0) $login_needed = true;
            $subscriber_id = $n_subscriber_info[0]['id'];
        }


        if (empty($subscriber_id)) {
            //echo $this->login_to_continue;
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $store_unique_id), 'location');
            exit();
        }

        $fb_app_id = $this->get_app_id();
        $data = array(
            'body' => "empty_cart",
            "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Cart"),
            "fb_app_id" => $fb_app_id
        );
        $data["social_analytics_codes"] = $store_data[0];

        $category_list = $this->get_category_list($store_data[0]['id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;
        $data['subscriber_id'] = $subscriber_id;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    function contact($store_unique_id = 0)
    {
        $store_unique_id = $this->get_store_id($store_unique_id);
        if ($store_unique_id == 0) exit();

        $store_data = $this->initial_load_store($store_unique_id);
        $n_eco_builder_config = $this->get_config();

        $fb_app_id = $this->get_app_id();
        $data = array(
            'body' => "contact",
            "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Contact"),
            "fb_app_id" => $fb_app_id
        );
        $data["social_analytics_codes"] = $store_data[0];

        $category_list = $this->get_category_list($store_data[0]['id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        $import_section = 'false';
        if ($n_eco_builder_config['contact_page_on'] == 'true') {
            if (file_exists(APPPATH . 'n_eco_user/contact_page_' . $store_data[0]['id'] . '_p.php')) {
                $import_section = APPPATH . 'n_eco_user/contact_page_' . $store_data[0]['id'] . '_p.php';
            }
        }

        $data['gjs']['gjs-html'] = '';
        $data['gjs']['gjs-components'] = '';
        $data['gjs']['gjs-assets'] = '';
        $data['gjs']['gjs-css'] = '';
        $data['gjs']['gjs-styles'] = '';

        if ($import_section != 'false') {
            $n_editor_data = file_get_contents($import_section);
            $data['gjs'] = json_decode($n_editor_data, true);
        }


        $this->load->view('ecommerce/bare-theme', $data);
    }

    function terms($store_unique_id = 0)
    {
        $store_unique_id = $this->get_store_id($store_unique_id);
        if ($store_unique_id == 0) exit();

        $store_data = $this->initial_load_store($store_unique_id);
        $n_eco_builder_config = $this->get_config();

        $fb_app_id = $this->get_app_id();
        $data = array(
            'body' => "terms",
            "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Terms"),
            "fb_app_id" => $fb_app_id
        );
        $data["social_analytics_codes"] = $store_data[0];

        $category_list = $this->get_category_list($store_data[0]['id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        $where_subs = array();
        $n_subscriber_info = array();
        $subscriber_id = $this->session->userdata($store_data[0]['id'] . "ecom_session_subscriber_id");


        if (empty($subscriber_id)) $subscriber_id = $this->input->get("subscriber_id", true);
        if (empty($subscriber_id)) $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $store_data[0]['id']);
        else {

            if (empty($subscriber_id)) $subscriber_id = $this->input->get("subscriber_id", true);
            if (!empty($subscriber_id)) $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
            //$n_subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => $where_subs));
        }
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_data[0]['id']);

        $this->load->view('ecommerce/bare-theme', $data);
    }

    function refund_policy($store_unique_id = 0)
    {
        $store_unique_id = $this->get_store_id($store_unique_id);
        if ($store_unique_id == 0) exit();

        $store_data = $this->initial_load_store($store_unique_id);
        $n_eco_builder_config = $this->get_config();

        $fb_app_id = $this->get_app_id();
        $data = array(
            'body' => "refund_policy",
            "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Refund policy"),
            "fb_app_id" => $fb_app_id
        );
        $data["social_analytics_codes"] = $store_data[0];

        $category_list = $this->get_category_list($store_data[0]['id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        $where_subs = array();
        $n_subscriber_info = array();
        $subscriber_id = $this->session->userdata($store_data[0]['id'] . "ecom_session_subscriber_id");


        if (empty($subscriber_id)) $subscriber_id = $this->input->get("subscriber_id", true);
        if (empty($subscriber_id)) $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $store_data[0]['id']);
        else {

            if (empty($subscriber_id)) $subscriber_id = $this->input->get("subscriber_id", true);
            if (!empty($subscriber_id)) $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
            //$n_subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => $where_subs));
        }
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_data[0]['id']);


        $this->load->view('ecommerce/bare-theme', $data);
    }

    private function check_login_eco($store_unique_id)
    {
        $store_id_temp = $this->get_store_id($store_unique_id);
        $subscriber_id = $this->session->userdata($store_id_temp . "ecom_session_subscriber_id");

        if ($subscriber_id == "") {
            $subscriber_id = $this->input->get("subscriber_id", true);
        }

        if ($subscriber_id == "") {
            redirect($this->return_base_url_php('ecommerce/login_signup'), 'location');
            exit();
        }
    }

    private function build_body_data()
    {

    }

    private function base_url_php($uri, $skip = false)
    {
        if (file_exists(APPPATH . 'custom_domain.php')) {
            include(APPPATH . 'custom_domain.php');
        }
        if (isset($_GET['builder']) and $_GET['builder'] == 1 and $skip == false) {
            $uri = $uri . '?builder=1';
        }
        $custom = false;
        if ($ncd_config['eco_custom_domain'] == 'true') {
            if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
                $custom = true;
            }
        }
        if ($custom == true) {
            echo base_url(str_replace('ecommerce/', '', $uri));
        } else {
            echo base_url($uri);
        }
    }

    private function return_base_url_php($uri, $skip = false)
    {
        if (file_exists(APPPATH . 'custom_domain.php')) {
            include(APPPATH . 'custom_domain.php');
        }
        if (isset($_GET['builder']) and $_GET['builder'] == 1 and $skip == false) {
            $uri = $uri . '?builder=1';
        }
        $custom = false;
        if (isset($ncd_config['eco_custom_domain']) and $ncd_config['eco_custom_domain'] == 'true') {
            if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
                $custom = true;
            }
        }
        if ($custom == true) {
            return base_url(str_replace('ecommerce/', '', $uri));
        } else {
            return base_url($uri);
        }
    }

    private function manual_payment_display_attachment($file, $format = false)
    {
        $output = '<div class="mp-display-img d-inline">';
        if ($format) $output .= '<a data-image="' . $file . '" href="' . $file . '" class="dropdown-item has-icon mp-img-item"><i class="fas fa-image"></i> ' . $this->lang->line("View Attachment") . '</a>';
        else {
            $output .= '<a class="mp-img-item btn btn-outline-info" data-image="' . $file . '" href="' . $file . '">';
            $output .= '<i class="fa fa-image"></i>';
            $output .= '</a>';
        }
        $output .= '</div>';
        $output .= '<script>$(".mp-display-img").Chocolat({className: "mp-display-img", imageSelector: ".mp-img-item"});</script>';

        return $output;
    }

    private function handle_attachment($id, $file, $format = false)
    {
        $info = pathinfo($file);
        if (isset($info['extension']) && !empty($info['extension'])) {
            switch (strtolower($info['extension'])) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    return $this->manual_payment_display_attachment($file, $format);
                case 'zip':
                case 'pdf':
                case 'txt':
                    if (!$format) return '<div data-id="' . $id . '" id="mp-download-file" class="btn btn-outline-info" data-toggle="tooltip" title="' . $this->lang->line("Attachment") . '"><i class="fas fa-download"></i></div>';
                    else return '<a data-id="' . $id . '" id="mp-download-file" href="#" class="dropdown-item has-icon"><i class="fas fa-download"></i> ' . $this->lang->line("Download Attachment") . '</a>';
            }
        }
    }

    public function sales($store_unique_id = 0)
    {
        $store_id = $this->get_store_id($store_unique_id);

        if ($store_id == 0) exit();
        $this->load->library('pagination');
        $n_eco_builder_config = $this->get_config();

        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
//        $where_simple = array("ecommerce_category.id"=>$category,"ecommerce_category.status"=>'1');
//        $where = array('where'=>$where_simple);
//        $store_data = $this->basic->get_data("ecommerce_category",$where);


        $store_unique_id = $store_id;
        $where_simple = array("ecommerce_store.store_unique_id" => $store_unique_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);
        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }
        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $product_sort = isset($ecommerce_config["product_sort"]) ? $ecommerce_config["product_sort"] : "name";
        $product_sort_order = isset($ecommerce_config["product_sort_order"]) ? $ecommerce_config["product_sort_order"] : "asc";

        if ($product_sort == "new") $product_sort = "ecommerce_product.id";
        else if ($product_sort == "price") $product_sort = "original_price";
        else if ($product_sort == "sale") $product_sort = "sales_count";
        else if ($product_sort == "random") $product_sort = "rand()";
        else $product_sort = "product_name";

        $n_sort = $this->get_sort($store_id);
        if (!empty($n_sort)) {
            $product_sort = $n_sort['product_sort'];
            $product_sort_order = $n_sort['product_sort_order'];
        }

        if ($product_sort != "rand()") $product_sort = $product_sort . " " . $product_sort_order;

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        $default_where = array(
            'sell_price < original_price AND sell_price !=' => 0,
        );

        $sql = "SELECT count(id) as count_products FROM `ecommerce_product` WHERE sell_price < original_price  AND sell_price != 0 AND `status` = '1' AND deleted = '0' AND store_id = " . $store_id;

        $count_products = $this->db->query($sql)->row_array();
        $count_products = isset($count_products['count_products']) ? $count_products['count_products'] : 0;

        $arra_get = array();
        $per_page = 0;
        if (!empty($_GET['per_page'])) {
            $per_page = $_GET['per_page'];

            $arra_get = $_GET;
            unset($arra_get['per_page']);
        }


        if (count($arra_get) > 0) $config['suffix'] = '&' . http_build_query($arra_get, '', "&");


        $config['base_url'] = $this->return_base_url_php('ecommerce/bestsellers/' . $store_unique_id);
        $config['total_rows'] = $count_products;
        $config['per_page'] = $n_eco_builder_config['pagination_per_page'];
        $config['page_query_string'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination">';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);


        $product_list = $this->get_product_list_array($store_id, $default_where, $product_sort, $config['per_page'], $per_page);
        $product_id_array = $this->get_product_id_array($product_list);

        $review_data_formatted = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("store_id" => $store_id, "hidden" => "0", 'product_id ' . $product_id_array)), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');
            foreach ($review_data as $key => $value) {
                $review_data_formatted[$value['product_id']] = $value;
            }
        }

        $fb_app_id = $this->get_app_id();
        $data = array('body' => "special", "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Products"), "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $store_data[0]['store_favicon']));

        $data['n_title'] = 'front_deals_products_text';
        $data['pagination'] = $this->pagination->create_links();
        $data["review_data"] = $review_data_formatted;
        $data["store_data"] = $store_data[0];
        $data["product_list"] = $product_list;
        $category_list = $this->get_category_list($store_id, true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }

        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }

        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;
        //$data["attribute_list"] = $this->get_attribute_list($store_id);
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $ecommerce_config;
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_id);
        $data["social_analytics_codes"] = $store_data[0];
        $data["show_search"] = true;
        $data["show_header"] = true;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function featured($store_unique_id = 0)
    {
        $store_id = $this->get_store_id($store_unique_id);

        if ($store_id == 0) exit();
        $this->load->library('pagination');
        $n_eco_builder_config = $this->get_config();

        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
//        $where_simple = array("ecommerce_category.id"=>$category,"ecommerce_category.status"=>'1');
//        $where = array('where'=>$where_simple);
//        $store_data = $this->basic->get_data("ecommerce_category",$where);


        $store_unique_id = $store_id;
        $where_simple = array("ecommerce_store.store_unique_id" => $store_unique_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);
        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }
        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $product_sort = isset($ecommerce_config["product_sort"]) ? $ecommerce_config["product_sort"] : "name";
        $product_sort_order = isset($ecommerce_config["product_sort_order"]) ? $ecommerce_config["product_sort_order"] : "asc";

        if ($product_sort == "new") $product_sort = "ecommerce_product.id ASC";
        else if ($product_sort == "price") $product_sort = "original_price";
        else if ($product_sort == "sale") $product_sort = "sales_count";
        else if ($product_sort == "random") $product_sort = "rand()";
        else $product_sort = "product_name";

        $n_sort = $this->get_sort($store_id);
        if (!empty($n_sort)) {
            $product_sort = $n_sort['product_sort'];
            $product_sort_order = $n_sort['product_sort_order'];
        }

        if ($product_sort != "rand()") $product_sort = $product_sort . " " . $product_sort_order;

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        $default_where = array(
            'is_featured' => '1'
        );


        $sql = "SELECT count(id) as count_products FROM `ecommerce_product` WHERE deleted = '0' AND store_id = " . $store_id;

        $count_products = $this->db->query($sql)->row_array();
        $count_products = isset($count_products['count_products']) ? $count_products['count_products'] : 0;

        $arra_get = array();
        $per_page = 0;
        if (!empty($_GET['per_page'])) {
            $per_page = $_GET['per_page'];

            $arra_get = $_GET;
            unset($arra_get['per_page']);
        }


        if (count($arra_get) > 0) $config['suffix'] = '&' . http_build_query($arra_get, '', "&");


        $config['base_url'] = $this->return_base_url_php('ecommerce/bestsellers/' . $store_unique_id);
        $config['total_rows'] = $count_products;
        $config['per_page'] = $n_eco_builder_config['pagination_per_page'];
        $config['page_query_string'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination">';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);


        $product_list = $this->get_product_list_array($store_id, $default_where, $product_sort, $config['per_page'], $per_page);
        $product_id_array = $this->get_product_id_array($product_list);

        $review_data_formatted = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("store_id" => $store_id, "hidden" => "0", 'product_id ' . $product_id_array)), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');
            foreach ($review_data as $key => $value) {
                $review_data_formatted[$value['product_id']] = $value;
            }
        }

        $fb_app_id = $this->get_app_id();
        $data = array('body' => "special", "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Products"), "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $store_data[0]['store_favicon']));

        $data['n_title'] = 'front_featured_products_text';
        $data['pagination'] = $this->pagination->create_links();
        $data["review_data"] = $review_data_formatted;
        $data["store_data"] = $store_data[0];
        $data["product_list"] = $product_list;
        $category_list = $this->get_category_list($store_id, true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }

        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }

        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;
        //$data["attribute_list"] = $this->get_attribute_list($store_id);
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $ecommerce_config;
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_id);
        $data["social_analytics_codes"] = $store_data[0];
        $data["show_search"] = true;
        $data["show_header"] = true;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function new_products($store_unique_id = 0)
    {
        $store_id = $this->get_store_id($store_unique_id);

        if ($store_id == 0) exit();
        $this->load->library('pagination');
        $n_eco_builder_config = $this->get_config();

        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
//        $where_simple = array("ecommerce_category.id"=>$category,"ecommerce_category.status"=>'1');
//        $where = array('where'=>$where_simple);
//        $store_data = $this->basic->get_data("ecommerce_category",$where);


        $store_unique_id = $store_id;
        $where_simple = array("ecommerce_store.store_unique_id" => $store_unique_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);
        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }
        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $product_sort = isset($ecommerce_config["product_sort"]) ? $ecommerce_config["product_sort"] : "name";
        $product_sort_order = isset($ecommerce_config["product_sort_order"]) ? $ecommerce_config["product_sort_order"] : "asc";

        if ($product_sort == "new") $product_sort = "ecommerce_product.id ASC";
        else if ($product_sort == "price") $product_sort = "original_price";
        else if ($product_sort == "sale") $product_sort = "sales_count";
        else if ($product_sort == "random") $product_sort = "rand()";
        else $product_sort = "product_name";


        if ($product_sort != "rand()") $product_sort = $product_sort . " " . $product_sort_order;

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        $default_where = array(//'sell_price < original_price AND sell_price !=' => 0,
        );

        $product_sort = "ecommerce_product.id DESC";

        $n_sort = $this->get_sort($store_id);
        if (!empty($n_sort)) {
            $product_sort = $n_sort['product_sort'];
            $product_sort_order = $n_sort['product_sort_order'];
        }

        $sql = "SELECT count(id) as count_products FROM `ecommerce_product` WHERE deleted = '0' AND store_id = " . $store_id;

        $count_products = $this->db->query($sql)->row_array();
        $count_products = isset($count_products['count_products']) ? $count_products['count_products'] : 0;

        $arra_get = array();
        $per_page = 0;
        if (!empty($_GET['per_page'])) {
            $per_page = $_GET['per_page'];

            $arra_get = $_GET;
            unset($arra_get['per_page']);
        }


        if (count($arra_get) > 0) $config['suffix'] = '&' . http_build_query($arra_get, '', "&");


        $config['base_url'] = $this->return_base_url_php('ecommerce/bestsellers/' . $store_unique_id);
        $config['total_rows'] = $count_products;
        $config['per_page'] = $n_eco_builder_config['pagination_per_page'];
        $config['page_query_string'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination">';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);


        $product_list = $this->get_product_list_array($store_id, $default_where, $product_sort, $config['per_page'], $per_page);
        $product_id_array = $this->get_product_id_array($product_list);

        $review_data_formatted = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("store_id" => $store_id, "hidden" => "0", 'product_id ' . $product_id_array)), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');
            foreach ($review_data as $key => $value) {
                $review_data_formatted[$value['product_id']] = $value;
            }
        }

        $fb_app_id = $this->get_app_id();
        $data = array('body' => "special", "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Products"), "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $store_data[0]['store_favicon']));

        $data['n_title'] = 'new_products_text';
        $data['pagination'] = $this->pagination->create_links();
        $data["review_data"] = $review_data_formatted;
        $data["store_data"] = $store_data[0];
        $data["product_list"] = $product_list;
        $category_list = $this->get_category_list($store_id, true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }

        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }

        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;
        //$data["attribute_list"] = $this->get_attribute_list($store_id);
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $ecommerce_config;
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_id);
        $data["social_analytics_codes"] = $store_data[0];
        $data["show_search"] = true;
        $data["show_header"] = true;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function bestsellers($store_unique_id = 0)
    {
        $store_id = $this->get_store_id($store_unique_id);

        if ($store_id == 0) exit();
        $this->load->library('pagination');
        $n_eco_builder_config = $this->get_config();

        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
//        $where_simple = array("ecommerce_category.id"=>$category,"ecommerce_category.status"=>'1');
//        $where = array('where'=>$where_simple);
//        $store_data = $this->basic->get_data("ecommerce_category",$where);


        $store_unique_id = $store_id;
        $where_simple = array("ecommerce_store.store_unique_id" => $store_unique_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);
        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }
        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $product_sort = isset($ecommerce_config["product_sort"]) ? $ecommerce_config["product_sort"] : "name";
        $product_sort_order = isset($ecommerce_config["product_sort_order"]) ? $ecommerce_config["product_sort_order"] : "asc";

        if ($product_sort == "new") $product_sort = "ecommerce_product.id ASC";
        else if ($product_sort == "price") $product_sort = "original_price";
        else if ($product_sort == "sale") $product_sort = "sales_count";
        else if ($product_sort == "random") $product_sort = "rand()";
        else $product_sort = "product_name";


        if ($product_sort != "rand()") $product_sort = $product_sort . " " . $product_sort_order;

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        $default_where = array(//'sell_price < original_price AND sell_price !=' => 0,
        );

        $product_sort = "sales_count DESC";

        $n_sort = $this->get_sort($store_id);
        if (!empty($n_sort)) {
            $product_sort = $n_sort['product_sort'];
            $product_sort_order = $n_sort['product_sort_order'];
        }

        $sql = "SELECT count(id) as count_products FROM `ecommerce_product` WHERE deleted = '0' AND store_id = " . $store_id;

        $count_products = $this->db->query($sql)->row_array();
        $count_products = isset($count_products['count_products']) ? $count_products['count_products'] : 0;

        $arra_get = array();
        $per_page = 0;
        if (!empty($_GET['per_page'])) {
            $per_page = $_GET['per_page'];

            $arra_get = $_GET;
            unset($arra_get['per_page']);
        }


        if (count($arra_get) > 0) $config['suffix'] = '&' . http_build_query($arra_get, '', "&");


        $config['base_url'] = $this->return_base_url_php('ecommerce/bestsellers/' . $store_unique_id);
        $config['total_rows'] = $count_products;
        $config['per_page'] = $n_eco_builder_config['pagination_per_page'];
        $config['page_query_string'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination">';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);


        $product_list = $this->get_product_list_array($store_id, $default_where, $product_sort, $config['per_page'], $per_page);
        $product_id_array = $this->get_product_id_array($product_list);

        $review_data_formatted = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("store_id" => $store_id, "hidden" => "0", 'product_id ' . $product_id_array)), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');
            foreach ($review_data as $key => $value) {
                $review_data_formatted[$value['product_id']] = $value;
            }
        }

        $fb_app_id = $this->get_app_id();
        $data = array('body' => "special", "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Products"), "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $store_data[0]['store_favicon']));

        $data['n_title'] = 'front_sales_products_text';
        $data['pagination'] = $this->pagination->create_links();
        $data["review_data"] = $review_data_formatted;
        $data["store_data"] = $store_data[0];
        $data["product_list"] = $product_list;
        $category_list = $this->get_category_list($store_id, true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }

        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }

        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;
        //$data["attribute_list"] = $this->get_attribute_list($store_id);
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $ecommerce_config;
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_id);
        $data["social_analytics_codes"] = $store_data[0];
        $data["show_search"] = true;
        $data["show_header"] = true;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function set_sort($store_id, $sort)
    {
        if ($store_id == 0) exit();
        switch ($sort) {
            case 'new_asc';
                $sort_save = $sort;
                break;
            case 'price_asc';
                $sort_save = $sort;
                break;
            case 'sale_asc';
                $sort_save = $sort;
                break;
            case 'random_asc';
                $sort_save = $sort;
                break;
            case 'name_asc';
                $sort_save = $sort;
                break;
            case 'new_desc';
                $sort_save = $sort;
                break;
            case 'price_desc';
                $sort_save = $sort;
                break;
            case 'sale_desc';
                $sort_save = $sort;
                break;
            case 'random_desc';
                $sort_save = $sort;
                break;
            case 'name_desc';
                $sort_save = $sort;
                break;
            case 'sort_default';
                $this->reset_sort($store_id);
                break;
        }
        if (!empty($sort_save)) {
            $this->session->set_userdata($store_id . "_sorting", $sort_save);
        }

    }

    private function reset_sort($store_id)
    {
        if ($store_id == 0) exit();
        $this->session->set_userdata($store_id . "_sorting", null);
    }

    private function get_sort($store_id)
    {
        if ($store_id == 0) exit();
        if (empty($this->session->userdata($store_id . "_sorting"))) {
            return null;
        }
        switch ($this->session->userdata($store_id . "_sorting")) {
            case 'new_asc';
                $product_sort = "ecommerce_product.id";
                $product_sort_order = 'ASC';
                break;
            case 'price_asc';
                $product_sort = "original_price";
                $product_sort_order = 'ASC';
                break;
            case 'sale_asc';
                $product_sort = "sales_count";
                $product_sort_order = 'ASC';
                break;
            case 'random_asc';
                $product_sort = "rand()";
                $product_sort_order = 'ASC';
                break;
            case 'name_asc';
                $product_sort = "product_name";
                $product_sort_order = 'ASC';
                break;
            case 'new_desc';
                $product_sort = "ecommerce_product.id";
                $product_sort_order = 'DESC';
                break;
            case 'price_desc';
                $product_sort = "original_price";
                $product_sort_order = 'DESC';
                break;
            case 'sale_desc';
                $product_sort = "sales_count";
                $product_sort_order = 'DESC';
                break;
            case 'random_desc';
                $product_sort = "rand()";
                $product_sort_order = 'DESC';
                break;
            case 'name_desc';
                $product_sort = "product_name";
                $product_sort_order = 'DESC';
                break;
        }
        $sort_save = array();
        $sort_save['product_sort'] = $product_sort;
        $sort_save['product_sort_order'] = $product_sort_order;

        return $sort_save;

    }


    public function category($category = 0)
    {
        if ($category == 0) exit();
        $this->load->library('pagination');
        $n_eco_builder_config = $this->get_config();

        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
        $where_simple = array("ecommerce_category.id" => $category, "ecommerce_category.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_category", $where);

        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }

        $store_unique_id = $store_data[0]['store_id'];
        $where_simple = array("ecommerce_store.id" => $store_unique_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);

        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $product_sort = isset($ecommerce_config["product_sort"]) ? $ecommerce_config["product_sort"] : "name";
        $product_sort_order = isset($ecommerce_config["product_sort_order"]) ? $ecommerce_config["product_sort_order"] : "asc";

        if ($product_sort == "new") $product_sort = "ecommerce_product.id";
        else if ($product_sort == "price") $product_sort = "original_price";
        else if ($product_sort == "sale") $product_sort = "sales_count";
        else if ($product_sort == "random") $product_sort = "rand()";
        else $product_sort = "product_name";

        $n_sort = $this->get_sort($store_id);
        if (!empty($n_sort)) {
            $product_sort = $n_sort['product_sort'];
            $product_sort_order = $n_sort['product_sort_order'];
        }

        if ($product_sort != "rand()") $product_sort = $product_sort . " " . $product_sort_order;

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        $default_where = array('category_id' => $category);


        $cat_sql = explode('_', $category);
        $sql = "SELECT count(id) as count_products FROM `ecommerce_product` WHERE category_id=" . $cat_sql[0] . "  AND `status` = '1'";

        $count_products = $this->db->query($sql)->row_array();
        $count_products = isset($count_products['count_products']) ? $count_products['count_products'] : 0;

        $arra_get = array();
        $per_page = 0;
        if (!empty($_GET['per_page'])) {
            $per_page = $_GET['per_page'];

            $arra_get = $_GET;
            unset($arra_get['per_page']);
        }


        if (count($arra_get) > 0) $config['suffix'] = '&' . http_build_query($arra_get, '', "&");


        $config['base_url'] = $this->return_base_url_php('ecommerce/category/' . $category);
        $config['total_rows'] = $count_products;
        $config['per_page'] = $n_eco_builder_config['pagination_per_page'];
        $config['page_query_string'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination">';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);


        $product_list = $this->get_product_list_array($store_id, $default_where, $product_sort, $config['per_page'], $per_page);
        $product_id_array = $this->get_product_id_array($product_list);

        $review_data_formatted = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("store_id" => $store_id, "hidden" => "0", 'product_id ' . $product_id_array)), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');
            foreach ($review_data as $key => $value) {
                $review_data_formatted[$value['product_id']] = $value;
            }
        }

        $fb_app_id = $this->get_app_id();
        $data = array('body' => "category", "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Products"), "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $store_data[0]['store_favicon']));


        $data['pagination'] = $this->pagination->create_links();
        $data["review_data"] = $review_data_formatted;
        $data["store_data"] = $store_data[0];
        $data["product_list"] = $product_list;
        $category_list = $this->get_category_list($store_id, true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }

        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }

        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;
        //$data["attribute_list"] = $this->get_attribute_list($store_id);
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $ecommerce_config;
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_id);
        $data["social_analytics_codes"] = $store_data[0];
        $data["show_search"] = true;
        $data["show_header"] = true;
        $data['category_id'] = $category;
        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function search($store_unique_id = 0)
    {
        if (empty($_GET['search'])) {
            exit();
        }
        $this->load->library('pagination');
        $n_eco_builder_config = $this->get_config();

        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
//        $where_simple = array("ecommerce_category.id"=>$category,"ecommerce_category.status"=>'1');
//        $where = array('where'=>$where_simple);
//        $store_data = $this->basic->get_data("ecommerce_category",$where);

        $store_unique_id = $this->get_store_id($store_unique_id);
        if ($store_unique_id == 0) exit();

        $store_data = $this->initial_load_store($store_unique_id);
        $n_eco_builder_config = $this->get_config();

        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }

        $store_id = $store_data[0]['id'];
        $where_simple = array("ecommerce_store.id" => $store_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);

        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $product_sort = isset($ecommerce_config["product_sort"]) ? $ecommerce_config["product_sort"] : "name";
        $product_sort_order = isset($ecommerce_config["product_sort_order"]) ? $ecommerce_config["product_sort_order"] : "asc";

        if ($product_sort == "new") $product_sort = "ecommerce_product.id";
        else if ($product_sort == "price") $product_sort = "original_price";
        else if ($product_sort == "sale") $product_sort = "sales_count";
        else if ($product_sort == "random") $product_sort = "rand()";
        else $product_sort = "product_name";

        if ($product_sort != "rand()") $product_sort = $product_sort . " " . $product_sort_order;

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        $default_where = array('store_id' => $store_id, "product_name" => $_GET['search']);


        //$cat_sql = explode("_", $category);
        $sql = "SELECT count(id) as count_products FROM `ecommerce_product` WHERE store_id=" . $store_id . "  AND `status` = '1' AND product_name LIKE '%" . $_GET['search'] . "%'";

        $count_products = $this->db->query($sql)->row_array();
        $count_products = isset($count_products['count_products']) ? $count_products['count_products'] : 0;

        $arra_get = array();
        $per_page = 0;
        if (!empty($_GET['per_page'])) {
            $per_page = $_GET['per_page'];

            $arra_get = $_GET;
            unset($arra_get['per_page']);
        }


        if (count($arra_get) > 0) $config['suffix'] = '&' . http_build_query($arra_get, '', "&");

        $base_url_n = $this->return_base_url_php('ecommerce/search/' . $store_unique_id);
        $base_url_n = mec_add_get_param($base_url_n, array("subscriber_id" => $subscriber_id, "pickup" => ''));
        $config['base_url'] = $base_url_n;
        $config['total_rows'] = $count_products;
        $config['per_page'] = $n_eco_builder_config['pagination_per_page'];
        $config['page_query_string'] = TRUE;
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination">';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_close'] = '</ul>';

        $this->pagination->initialize($config);


        $product_list = $this->get_product_list_array($store_id, $default_where, $product_sort, $config['per_page'], $per_page);
        $product_id_array = $this->get_product_id_array($product_list);

        $review_data_formatted = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("store_id" => $store_id, "hidden" => "0", 'product_id ' . $product_id_array)), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');
            foreach ($review_data as $key => $value) {
                $review_data_formatted[$value['product_id']] = $value;
            }
        }

        $fb_app_id = $this->get_app_id();
        $data = array('body' => "search", "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Search") . $_GET['search'], "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $store_data[0]['store_favicon']));


        $data['pagination'] = $this->pagination->create_links();
        $data["review_data"] = $review_data_formatted;
        $data["store_data"] = $store_data[0];
        $data["product_list"] = $product_list;
        $category_list = $this->get_category_list($store_id, true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }

        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }

        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;
        //$data["attribute_list"] = $this->get_attribute_list($store_id);
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $ecommerce_config;
        //$data['current_cart'] = $this->get_current_cart($subscriber_id,$store_id);
        $data["social_analytics_codes"] = $store_data[0];
        $data["show_search"] = true;
        $data["show_header"] = true;
        //$data['category_id'] = $category;
        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function add_to_cart_modal()
    {
        $this->ajax_check();
        $product_id = $this->input->post('product_id', true);
        $buy_now = $this->input->post('buy_now', true);
        if ($product_id == 0) {
            echo '<div class="alert alert-danger text-center">' . $this->lang->line("Product not found.") . '</div>';
            exit();
        }
        $where_simple = array("ecommerce_product.id" => $product_id, "ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
        $select = array("ecommerce_product.*", "store_name", "store_unique_id", "store_logo", "store_favicon", "terms_use_link", "refund_policy_link", "store_locale", "pixel_id", "google_id");
        $product_data = $this->basic->get_data("ecommerce_product", $where, $select, $join);

        if (!isset($product_data[0])) {
            echo '<div class="alert alert-danger text-center">' . $this->lang->line("Product not found.") . '</div>';
            exit();
        }
        $subscriber_id = $this->session->userdata($product_data[0]['store_id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->post("subscriber_id", true);

        $user_id = isset($product_data[0]["user_id"]) ? $product_data[0]["user_id"] : 0;
        $attribute_list = $this->get_attribute_list($product_data[0]["store_id"], true);
        $currency_icons = $this->get_country_new('currecny_icon');
        $ecommerce_config = $this->get_ecommerce_config($product_data[0]["store_id"]);
        // $current_cart = $this->get_current_cart($subscriber_id,$product_data[0]['store_id']);
        // $social_analytics_codes = $product_data[0];
        if ($this->addon_exist('ecommerce_product_price_variation')) $attribute_price_map = $this->basic->get_data("ecommerce_attribute_product_price", array("where" => array("product_id" => $product_id)));
        else $attribute_price_map = array();

        $product_data = $product_data[0];
        $hide_add_to_cart = isset($ecommerce_config['hide_add_to_cart']) ? $ecommerce_config['hide_add_to_cart'] : "0";
        $currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
        $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
        $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
        $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
        $currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";
        $quantity_in_cart = 0;
        $output = "";
        $product_attributes = array_filter(explode(',', $product_data['attribute_ids']));
        if (is_array($product_attributes) && !empty($product_attributes)) $have_attributes = true;
        $map_array = array();
        $currency_left = $currency_right = "";
        if ($currency_position == 'left') $currency_left = $currency_icon;
        if ($currency_position == 'right') $currency_right = $currency_icon;
        foreach ($attribute_price_map as $key => $value) {
            $x = $value["amount"] == 0 && $value["price_indicator"] == 'x' ? 'x' : '';
            $ammount_formatted = $currency_left . mec_number_format($value["amount"], $decimal_point, $thousand_comma) . $currency_right;
            $map_array[$value["attribute_id"]][$value["attribute_option_name"]] = $value["amount"] != 0 ? $value["price_indicator"] . $ammount_formatted : $x;
        }

        $imgSrc = ($product_data['thumbnail'] != '') ? base_url('upload/ecommerce/' . $product_data['thumbnail']) : '';
        if (isset($product_data["woocommerce_product_id"]) && !is_null($product_data["woocommerce_product_id"]) && $product_data['thumbnail'] != '')
            $imgSrc = $product_data['thumbnail'];
        $display_price = mec_display_price($product_data['original_price'], $product_data['sell_price'], $currency_icon, '1', $currency_position, $decimal_point, $thousand_comma);

        // $hide_header = $imgSrc=='' ? 'd-none' : '';
        $hide_header = 'd-none';

        $output .= '
<div class="product-details">
    <h2 class="product-title">' . $product_data['product_name'] . '</h2>
    <div class="product-price">' . $display_price . '</div>
</div>



  <article class="article article-style-b mb-1 mt-1 no_shadow">
  <div class="article-header ' . $hide_header . '" style="height:auto !important;">
  <img src="' . $imgSrc . '" class="pb-4" style="width:100% !important;height:auto !impoirtant;">                              
  </div>
  <div class="article-details pt-0 pb-2 pl-1 pr-1">
  <div class="article-title">
  <span class="text-primary" style="font-size:15px !important;"></span>
            
  </div>
  </div>
  </article>';

        $attr_count = 0;
        foreach ($attribute_list as $key => $value) {
            if (in_array($value["id"], $product_attributes)) {
                $attr_count++;
                $name = "attribute_" . $attr_count;
                $options_array = json_decode($value["attribute_values"], true);
                $url_option = "option" . $value["id"];
                $selected = "";

                $star = ($value['optional'] == '0') ? '*' : '';
                $options_print = "";
                $count = 0;
                foreach ($options_array as $key2 => $value2) {
                    $selected_attr = "";
                    $count++;
                    $temp_id = $name . $count;
                    $tempu = isset($map_array[$value["id"]][$value2]) ? $map_array[$value["id"]][$value2] : "";
                    $continue = false;
                    if ($tempu != '') {
                        $first_char = substr($tempu, 0, 1);
                        if ($first_char == 'x') $continue = true;
                    }
                    if ($continue) continue;
                    if ($value['multiselect'] == '1') {
                        $options_print .= '
                                <fieldset class="size">
                                                            <div class="form-checkbox d-flex align-items-center justify-content-between">
                                  <input type="checkbox" data-attr="' . $value["id"] . '" name="' . $name . '"   value="' . $value2 . '" class="custom-checkbox options" id="' . $temp_id . '" data-optional="' . $value["optional"] . '" ' . $selected_attr . '>
                                  <label class="d-inline-block" for="' . $temp_id . '" style="max-width:initial;white-space:nowrap;    padding-left: 2.5rem;">' . $value2 . ' <strong class="text-dark ml-1">' . $tempu . '</strong></label>
                                </div>
                                                   </fieldset>';
                    } else {
                        $options_print .= '                                               
                                                   <fieldset class="size">
                                                            <div>
                                                                <input type="radio" class="custom-checkbox checkbox-round options"  data-attr="' . $value["id"] . '"  name="' . $name . '"  id="' . $value2 . '"  value="' . $value2 . '" id="radio1" data-optional="' . $value["optional"] . '" ' . $selected_attr . '>
                                                                <label for="' . $value2 . '" class="d-inline-block " style="white-space:nowrap;max-width:initial;padding-left:2.5rem;">' . $value2 . ' <strong class="text-dark ml-1">' . $tempu . '</strong></label>
                                                            </div>
                                                   </fieldset>';
                    }

                }

                $output .= '
       <div class="product-form mb-1">
                                <label class="mb-5 font-weight-bold">
                                  ' . $value["attribute_name"] . $star . '
                                </label>
                                <div class="flex-wrap d-flex align-items-center product-size-swatch">
                                 ' . $options_print . '   
                                </div>
                              </div>';
            }
        }

        $n_eco_builder_config = $this->get_config();
        if ($n_eco_builder_config['buy_button_type'] == 'buy_now') {
            $n_eco_builder_config['buy_button_class'] = 'buy_now';
        } else {
            $n_eco_builder_config['buy_button_class'] = '';
        }
        $buy_now_class = $n_eco_builder_config['buy_button_class'];


        $output .= '<div id="calculated_price_basedon_attribute" class="product-price mt-5"></div>';
        if ($hide_add_to_cart == '0'):
            $output .= '<div class="fix-bottom">
                                    <div class="product-form mt-5 d-flex">
                                        <div class="product-qty-form">
                                            <div class="input-group">
                                                <input class="quantity form-control" type="number" data-toggle="tooltip" title="' . $this->lang->line('Currently added to cart') . '" id="item_count"  data-quantityinput="' . $quantity_in_cart . '"
                                                        value="' . $quantity_in_cart . '">
                                                <button class="quantity-plus w-icon-plus  add_to_cart_mdl ' . $buy_now_class . '" data-product-id="' . $product_data['id'] . '" data-attributes="' . $product_data['attribute_ids'] . '" data-action="add" data-toggle="tooltip" title="' . $this->lang->line('Add 1 to Cart') . '"></button>
                                                <button class="quantity-minus w-icon-minus  add_to_cart_mdl ' . $buy_now_class . '" data-product-id="' . $product_data['id'] . '" data-attributes="' . $product_data['attribute_ids'] . '" data-action="remove" data-toggle="tooltip" title="' . $this->lang->line('Remove 1 from Cart') . '"></button>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-cart add_to_cart add_to_cart_mdl ' . $buy_now_class . '" data-product-id="' . $product_data['id'] . '" data-attributes="' . $product_data['attribute_ids'] . '" data-action="add">
                                            <i class="w-icon-cart"></i>
                                            <span>' . $this->lang->line('Add to Cart') . '</span>
                                        </button>
                                    </div>
                                </div>';
        endif;

        $output .= '
 <script>
 var counter=0;
 var current_product_id = "' . $product_data["id"] . '";
 var current_store_id = "' . $product_data["store_id"] . '";
 var currency_icon = "' . $currency_icon . '";
 var currency_position = "' . $currency_position . '";
 var decimal_point = "' . $decimal_point . '";
 var thousand_comma = "' . $thousand_comma . '"; 
 </script>';

        $output .= file_get_contents(APPPATH . 'n_views/ecommerce/attribute_value.php');

        echo $output;

    }

    public function store($store_unique_id = 0)
    {
        //var_dump($_GET); //fb iframe origin
        $store_unique_id = $this->get_store_id($store_unique_id);
        if ($store_unique_id == 0) exit();
        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
        $where_simple = array("ecommerce_store.store_unique_id" => $store_unique_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);

        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }

        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $product_sort = isset($ecommerce_config["product_sort"]) ? $ecommerce_config["product_sort"] : "name";
        $product_sort_order = isset($ecommerce_config["product_sort_order"]) ? $ecommerce_config["product_sort_order"] : "asc";

        if ($product_sort == "new") $product_sort = "ecommerce_product.id";
        else if ($product_sort == "price") $product_sort = "original_price";
        else if ($product_sort == "sale") $product_sort = "sales_count";
        else if ($product_sort == "random") $product_sort = "rand()";
        else $product_sort = "product_name";

        if ($product_sort != "rand()") $product_sort = $product_sort . " " . $product_sort_order;

        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);


        $fb_app_id = $this->get_app_id();
        $data = array('body' => "ecommerce/store_single", "page_title" => $store_data[0]['store_name'] . " | " . $this->lang->line("Home"), "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $store_data[0]['store_favicon']));

        include(APPPATH . 'n_views/default_ecommerce_builder.php');
        if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $store_unique_id . '.php')) {
            include(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $store_unique_id . '.php');
        }

        $default_where = array();
        $product_list = $this->get_product_list_array($store_id, $default_where, $product_sort);
        $product_id_array = $this->get_product_id_array($product_list);
        $data["store_data"] = $store_data[0];
        $data["product_list"] = $product_list;
        $data["store_data"] = $store_data[0];

        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }

        if ($this->is_ecommerce_related_product_exist and $n_eco_builder_config['front_featured_products_show'] == 'true') {
            $default_where = array(
                'is_featured' => '1'
            );

            $order_by = 'rand()';
            $data['featured_list'] = $this->get_product_list_array($store_id, $default_where, $order_by, $n_eco_builder_config['front_featured_products_limit']);
            $product_id_array = $this->get_product_id_array($data['featured_list'], $product_id_array);
        }

        if ($n_eco_builder_config['front_deals_products_show'] == 'true') {
            $default_where = array(
                'sell_price < original_price AND sell_price !=' => 0,
            );
            $order_by = 'rand()';
            $data['deals_list'] = $this->get_product_list_array($store_id, $default_where, $order_by, $n_eco_builder_config['front_deals_products_limit']);
            $product_id_array = $this->get_product_id_array($data['deals_list'], $product_id_array);
        }

        if ($n_eco_builder_config['front_sales_products_show'] == 'true') {
            $default_where = array();
            $order_by = 'sales_count DESC';
            $data['sales_list'] = $this->get_product_list_array($store_id, $default_where, $order_by, $n_eco_builder_config['front_sales_products_limit']);
            $product_id_array = $this->get_product_id_array($data['sales_list'], $product_id_array);
        }

        if ($n_eco_builder_config['new_products_show'] == 'true') {
            $default_where = array();
            $order_by = 'updated_at DESC';
            $data['new_list'] = $this->get_product_list_array($store_id, $default_where, $order_by, $n_eco_builder_config['new_products_products_limit']);
            $product_id_array = $this->get_product_id_array($data['new_list'], $product_id_array);
        }

        $category_list = $this->get_category_list($store_id, true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;


        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }


        //$data["attribute_list"] = $this->get_attribute_list($store_id);


        $review_data_formatted = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("store_id" => $store_id, "hidden" => "0", 'product_id ' . $product_id_array)), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');
            foreach ($review_data as $key => $value) {
                $review_data_formatted[$value['product_id']] = $value;
            }
        }

        $data["review_data"] = $review_data_formatted;

        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $ecommerce_config;
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $store_id);
        $data["social_analytics_codes"] = $store_data[0];
        $data["show_search"] = true;
        $data["show_header"] = true;
        $data['is_rtl'] = (isset($store_data[0]['is_rtl']) && $store_data[0]['is_rtl'] == '1') ? true : false;

        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function cart($id = 0)
    {
        $store_data_temp = $this->basic->get_data("ecommerce_cart", array("where" => array("id" => $id)), "store_id");
        $store_id_temp = isset($store_data_temp[0]['store_id']) ? $store_data_temp[0]['store_id'] : "0";

        $subscriber_id = $this->session->userdata($store_id_temp . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);
        if ($subscriber_id == "") {
            //echo $this->login_to_continue;
            //var_dump($this->get_store_uq($this->nstore_id));
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $this->get_store_uq($store_data_temp[0]['store_id'])), 'location');
            exit();
        }

        $this->update_cart($id, $subscriber_id);

        $select2 = array("ecommerce_store.*", "messenger_bot_subscriber.id as subscriber_auto_id", "ecommerce_cart.*", "first_name", "last_name", "full_name", "profile_pic", "email", "image_path", "phone_number", "user_location", "store_name", "store_type", "store_email", "store_favicon", "store_phone", "store_logo", "store_address", "store_zip", "store_city", "store_phone", "store_email", "store_country", "store_state", "store_unique_id", "refund_policy_link", "terms_use_link", "store_locale", "is_rtl", "pixel_id", "google_id", "mercadopago_enabled", "sslcommerz_enabled");
        $join2 = array('messenger_bot_subscriber' => "messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left", 'ecommerce_store' => "ecommerce_store.id=ecommerce_cart.store_id,left");
        $where_simple2 = array("ecommerce_cart.id" => $id, "action_type !=" => "checkout");
        if ($subscriber_id != "") $where_simple2['ecommerce_cart.subscriber_id'] = $subscriber_id;
        else $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
        $where2 = array('where' => $where_simple2);
        $webhook_data = $this->basic->get_data("ecommerce_cart", $where2, $select2, $join2);
        // echo "<pre>"; print_r($webhook_data); exit;

        if (empty($webhook_data[0])) {

            if ($subscriber_id == "" and empty($this->nstore_id)) {

                $not_found = $this->lang->line("Sorry, we could not find the cart you are looking for.");
                echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $not_found . '</h2>';

            } else {

                $where_simple2 = array("ecommerce_cart.id" => $id);
                if ($subscriber_id != "") $where_simple2['ecommerce_cart.subscriber_id'] = $subscriber_id;
                else $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
                $where2 = array('where' => $where_simple2);
                $webhook_data = $this->basic->get_data("ecommerce_cart", $where2);

                if (!empty($webhook_data[0]['id'])) {
                    redirect($this->return_base_url_php('ecommerce/order/' . $webhook_data[0]['id'], 'location'));
                }

                $product_data = $this->initial_load_store($this->nstore_id);
                $product_data = $product_data[0];


                $fb_app_id = $this->get_app_id();
                $data = array('body' => "empty_cart", "page_title" => $product_data['store_name'], "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $product_data['store_favicon']));

                $category_list = $this->get_category_list($product_data['id'], true);
                $cat_info = array();
                foreach ($category_list as $value) {
                    $cat_info[$value['id']] = $value['category_name'];
                }
                $data["category_list"] = $cat_info;
                $data["category_list_raw"] = $category_list;

                if ($subscriber_id == "") {
                    $data['not_found'] = $this->lang->line("Sorry, we could not find the cart you are looking for.");
                }

                $data['subscriber_id'] = $subscriber_id;
                $data['currency_icons'] = $this->get_country_new('currecny_icon');
                $data['ecommerce_config'] = $this->get_ecommerce_config($this->nstore_id);
                $data['current_cart'] = $this->get_current_cart($subscriber_id, $this->nstore_id);
                $data["social_analytics_codes"] = $product_data;
                $data['current_store_id'] = $this->nstore_id;

                $this->load->view('ecommerce/bare-theme', $data);
                return;
            }
            //todo
            exit();
        }
        $webhook_data_final = $webhook_data[0];
        $ecommerce_config = $this->get_ecommerce_config($webhook_data_final['store_id']);
        $data['ecommerce_config'] = $ecommerce_config;
        $this->_language_loader($webhook_data_final['store_locale']);

        $join = array('ecommerce_product' => "ecommerce_product.id=ecommerce_cart_item.product_id,left");

        $fb_app_id = $this->get_app_id();

        $data['webhook_data_final'] = $webhook_data_final;
        $data['currency_list'] = $this->currecny_list_all();
        $data['country_names'] = $this->get_country_new();
        $data['phonecodes'] = $this->get_country_new('phonecode');
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['product_list'] = $this->basic->get_data("ecommerce_cart_item", array('where' => array("cart_id" => $id)), array("ecommerce_cart_item.*", "product_name", "thumbnail", "taxable", "attribute_ids", "woocommerce_product_id"), $join);
        $data['fb_app_id'] = $fb_app_id;
        $data['favicon'] = base_url('upload/ecommerce/' . $webhook_data_final['store_favicon']);
        $data['page_title'] = $webhook_data_final['store_name'] . " | " . $this->lang->line("Checkout");
        $data['body'] = "ecommerce/cart";
        $data['subscriber_id'] = $subscriber_id;

        $data['current_cart'] = $this->get_current_cart($subscriber_id, $webhook_data_final['store_id']);
        $data["social_analytics_codes"] = $webhook_data_final;
        $data["pickup_point_list"] = $this->basic->get_data("ecommerce_cart_pickup_points", array("where" => array("store_id" => $webhook_data_final['store_id'])));
        $mercadopago_enabled = isset($webhook_data_final['mercadopago_enabled']) ? $webhook_data_final['mercadopago_enabled'] : '0';
        $marcadopago_country = isset($ecommerce_config['marcadopago_country']) ? $ecommerce_config['marcadopago_country'] : 'br';
        $sslcommerz_enabled = isset($webhook_data_final['sslcommerz_enabled']) ? $webhook_data_final['sslcommerz_enabled'] : '0';
        $payment_amount = isset($webhook_data_final['payment_amount']) ? $webhook_data_final['payment_amount'] : '0';
        $mercadopago_button = $sslcommerz_button = '';
        $postdata_array = array();
        if ($mercadopago_enabled == '1') {
            $mercadopago_public_key = isset($ecommerce_config['mercadopago_public_key']) ? $ecommerce_config['mercadopago_public_key'] : '';
            $mercadopago_access_token = isset($ecommerce_config['mercadopago_access_token']) ? $ecommerce_config['mercadopago_access_token'] : '';

            $this->load->library("mercadopago");
            $this->mercadopago->public_key = $mercadopago_public_key;
            $this->mercadopago->redirect_url = base_url("ecommerce/mercadopago_action/" . $id);
            $this->mercadopago->transaction_amount = $payment_amount;
            $this->mercadopago->secondary_button = false;
            $this->mercadopago->button_lang = $this->lang->line('Pay with Mercado Pago');
            $this->mercadopago->marcadopago_url = 'https://www.mercadopago.com.' . $marcadopago_country;
            $mercadopago_button = $this->mercadopago->set_button();
        }

        $category_list = $this->get_category_list($store_data_temp[0]["store_id"], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        if ($sslcommerz_enabled == '1') {
            $postdata_array =
                [
                    'cart_id' => $id
                ];

            $endpoint_url = base_url('ecommerce/sslcommerz_action');
            $sslcommerz_button = '
    <button class="your-button-class" id="sslczPayBtn"
    token="if you have any token validation"
    postdata=""
    order="If you already have the transaction generated for current order"
    endpoint="' . $endpoint_url . '"> Pay With SSLCOMMERZ
    </button>';
        }
        $data["postdata_array"] = $postdata_array;
        $data["mercadopago_button"] = $mercadopago_button;
        $data["sslcommerz_button"] = $sslcommerz_button;
        $data['is_rtl'] = (isset($webhook_data_final['is_rtl']) && $webhook_data_final['is_rtl'] == '1') ? true : false;

        //var_dump($data);
        $this->load->view('ecommerce/bare-theme', $data);

    }

    public function checkout($id = 0)
    {
        $store_data_temp = $this->basic->get_data("ecommerce_cart",array("where"=>array("id"=>$id)),"store_id");
        $store_id_temp = isset($store_data_temp[0]['store_id']) ? $store_data_temp[0]['store_id'] : "0";

        $subscriber_id=$this->session->userdata($store_id_temp."ecom_session_subscriber_id");
        if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);



        if ($subscriber_id == "") {
            //echo $this->login_to_continue;
            //var_dump($this->get_store_uq($this->nstore_id));
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $this->get_store_uq($store_data_temp[0]['store_id'])), 'location');
            exit();
        }

        $this->update_cart($id, $subscriber_id);

        $select2 = array("ecommerce_store.*", "messenger_bot_subscriber.id as subscriber_auto_id", "ecommerce_cart.*", "first_name", "last_name", "full_name", "profile_pic", "email", "image_path", "phone_number", "user_location", "store_name", "store_type", "store_email", "store_favicon", "store_phone", "store_logo", "store_address", "store_zip", "store_city", "store_phone", "store_email", "store_country", "store_state", "store_unique_id", "refund_policy_link", "terms_use_link", "store_locale", "is_rtl", "pixel_id", "google_id", "mercadopago_enabled", "sslcommerz_enabled");
        $join2 = array('messenger_bot_subscriber' => "messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left", 'ecommerce_store' => "ecommerce_store.id=ecommerce_cart.store_id,left");
        $where_simple2 = array("ecommerce_cart.id" => $id, "action_type !=" => "checkout");
        if ($subscriber_id != "") $where_simple2['ecommerce_cart.subscriber_id'] = $subscriber_id;
        else $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
        $where2 = array('where' => $where_simple2);
        $webhook_data = $this->basic->get_data("ecommerce_cart", $where2, $select2, $join2);
        // echo "<pre>"; print_r($webhook_data); exit;

        if (empty($webhook_data[0])) {

            if ($subscriber_id == "" and empty($this->nstore_id)) {

                $not_found = $this->lang->line("Sorry, we could not find the cart you are looking for.");
                echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $not_found . '</h2>';

            } else {

                $where_simple2 = array("ecommerce_cart.id" => $id);
                if ($subscriber_id != "") $where_simple2['ecommerce_cart.subscriber_id'] = $subscriber_id;
                else $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
                $where2 = array('where' => $where_simple2);
                $webhook_data = $this->basic->get_data("ecommerce_cart", $where2);

                if (!empty($webhook_data[0]['id'])) {
                    redirect($this->return_base_url_php('ecommerce/order/' . $webhook_data[0]['id'], 'location'));
                }

                $product_data = $this->initial_load_store($this->nstore_id);
                $product_data = $product_data[0];


                $fb_app_id = $this->get_app_id();
                $data = array('body' => "empty_cart", "page_title" => $product_data['store_name'], "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $product_data['store_favicon']));

                $category_list = $this->get_category_list($product_data['id'], true);
                $cat_info = array();
                foreach ($category_list as $value) {
                    $cat_info[$value['id']] = $value['category_name'];
                }
                $data["category_list"] = $cat_info;
                $data["category_list_raw"] = $category_list;

                if ($subscriber_id == "") {
                    $data['not_found'] = $this->lang->line("Sorry, we could not find the cart you are looking for.");
                }

                $data['subscriber_id'] = $subscriber_id;
                $data['currency_icons'] = $this->get_country_new('currecny_icon');
                $data['ecommerce_config'] = $this->get_ecommerce_config($this->nstore_id);
                $data['current_cart'] = $this->get_current_cart($subscriber_id, $this->nstore_id);
                $data["social_analytics_codes"] = $product_data;
                $data['current_store_id'] = $this->nstore_id;

                $data['address'] = $this->get_buyer_profile_checkout();

                $this->load->view('ecommerce/bare-theme', $data);
                return;
            }
            //todo
            exit();
        }

        $webhook_data_final = $webhook_data[0];
        $ecommerce_config = $this->get_ecommerce_config($webhook_data_final['store_id']);
        $data['ecommerce_config'] = $ecommerce_config;
        $this->_language_loader($webhook_data_final['store_locale']);

        $join = array('ecommerce_product' => "ecommerce_product.id=ecommerce_cart_item.product_id,left");

        $fb_app_id = $this->get_app_id();

        $data['webhook_data_final'] = $webhook_data_final;
        $data['currency_list'] = $this->currecny_list_all();
        $data['country_names'] = $this->get_country_new();
        $data['phonecodes'] = $this->get_country_new('phonecode');
        $data['currency_icons'] = $this->get_country_new('currecny_icon');

        $data['product_list'] = $this->basic->get_data("ecommerce_cart_item", array('where' => array("cart_id" => $id)), array("ecommerce_cart_item.*", "product_name", "thumbnail", "taxable", "attribute_ids", "woocommerce_product_id"), $join);

        $data['fb_app_id'] = $fb_app_id;
        $data['favicon'] = base_url('upload/ecommerce/' . $webhook_data_final['store_favicon']);
        $data['page_title'] = $webhook_data_final['store_name'] . " | " . $this->lang->line("Checkout");
        $data['body'] = "ecommerce/checkout";
        $data['subscriber_id'] = $subscriber_id;

        $data['current_cart'] = $this->get_current_cart($subscriber_id, $webhook_data_final['store_id']);

        $data["social_analytics_codes"] = $webhook_data_final;
        $data["pickup_point_list"] = $this->basic->get_data("ecommerce_cart_pickup_points", array("where" => array("store_id" => $webhook_data_final['store_id'])));
        $mercadopago_enabled = isset($webhook_data_final['mercadopago_enabled']) ? $webhook_data_final['mercadopago_enabled'] : '0';
        $marcadopago_country = isset($ecommerce_config['marcadopago_country']) ? $ecommerce_config['marcadopago_country'] : 'br';
        $sslcommerz_enabled = isset($webhook_data_final['sslcommerz_enabled']) ? $webhook_data_final['sslcommerz_enabled'] : '0';
        $payment_amount = isset($webhook_data_final['payment_amount']) ? $webhook_data_final['payment_amount'] : '0';
        $mercadopago_button = $sslcommerz_button = '';
        $postdata_array = array();


        $category_list = $this->get_category_list($store_data_temp[0]["store_id"], true);
        $cat_info = array();

        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        if ($sslcommerz_enabled == '1') {
            $postdata_array =
                [
                    'cart_id' => $id
                ];

            $endpoint_url = base_url(return_ecommerce_base_url("sslcommerz_action"));
            $sslcommerz_button = '
    <button class="your-button-class" id="sslczPayBtn"
    token="if you have any token validation"
    postdata=""
    order="If you already have the transaction generated for current order"
    endpoint="' . $endpoint_url . '"> Pay With SSLCOMMERZ
    </button>';
        }
        $data["postdata_array"] = $postdata_array;
        $data["mercadopago_button"] = $mercadopago_button;


        $sslcommerz_mode = isset($ecommerce_config['sslcommerz_mode']) ? $ecommerce_config['sslcommerz_mode'] : '0';
        $data["sslcommerz_mode"] = $sslcommerz_mode;
        $data["sslcommerz_button"] = $sslcommerz_button;
        $data['is_rtl'] = (isset($webhook_data_final['is_rtl']) && $webhook_data_final['is_rtl'] == '1') ? true : false;

        $data['billing_ad'] = $this->get_buyer_profile_checkout();

        $p_mydata['store_id'] = $store_id_temp;
        $p_mydata['cart_id'] = $id;
        $data['pm'] = $this->proceed_checkout_n($subscriber_id, 1, $p_mydata);

        $data['delivery_methods'] = $this->get_all_delivery_methods($webhook_data_final['store_id']);

        $data['delivery_methods_worldwide'] = $this->get_all_delivery_methods_worldwide($store_id_temp);


        //var_dump($data);
        $this->load->view('ecommerce/bare-theme', $data);

    }

    public function product($product_id = 0)
    {
        if ($product_id == 0) exit();
        $prodcut_exp = explode('_', $product_id);
        $product_id = $prodcut_exp[0];
        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
        $where_simple = array("ecommerce_product.id" => $product_id, "ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
        $select = array("ecommerce_product.*", "store_name", "store_unique_id", "store_logo", "store_favicon", "terms_use_link", "refund_policy_link", "store_locale", "pixel_id", "google_id");
        $product_data = $this->basic->get_data("ecommerce_product", $where, $select, $join);

        if (!isset($product_data[0])) {
            echo '<br/><h1 style="text-align:center">' . $this->lang->line("Product not found.") . '</h1>';
            exit();
        }
        $this->_language_loader($product_data[0]['store_locale']);

        $related_product_ids = $product_data[0]['related_product_ids'];
        $upsell_product_id = $product_data[0]['upsell_product_id'];
        $downsell_product_id = $product_data[0]['downsell_product_id'];
        $related_product_lists = array();
        $upsell_product_lists = array();
        $downsell_product_lists = array();

        if (isset($related_product_ids) && !empty($related_product_ids)) {

            $related_product_ids = explode(",", $related_product_ids);
            $where_in = array('ecommerce_product.id' => $related_product_ids);
            $where_simple2 = array("ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
            $where2 = array('where' => $where_simple2, 'where_in' => $where_in);
            $join2 = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
            $select2 = array("ecommerce_product.*", "store_name", "store_unique_id", "store_logo", "store_favicon", "terms_use_link", "refund_policy_link", "store_locale", "pixel_id", "google_id");
            $related_product_lists = $this->basic->get_data("ecommerce_product", $where2, $select2, $join2);

        }

        if (isset($upsell_product_id) && $upsell_product_id != 0) {
            $where_in3 = array('ecommerce_product.id' => $upsell_product_id);
            $where_simple3 = array("ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
            $where3 = array('where' => $where_simple3, 'where_in' => $where_in3);
            $join3 = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
            $select3 = array("ecommerce_product.*", "store_name", "store_unique_id", "store_logo", "store_favicon", "terms_use_link", "refund_policy_link", "store_locale", "pixel_id", "google_id");
            $upsell_product_lists = $this->basic->get_data("ecommerce_product", $where3, $select3, $join3);
        }

        if (isset($downsell_product_id) && $downsell_product_id != 0) {
            $where_in4 = array('ecommerce_product.id' => $downsell_product_id);
            $where_simple4 = array("ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
            $where4 = array('where' => $where_simple4, 'where_in' => $where_in4);
            $join4 = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
            $select4 = array("ecommerce_product.*", "store_name", "store_unique_id", "store_logo", "store_favicon", "terms_use_link", "refund_policy_link", "store_locale", "pixel_id", "google_id");
            $downsell_product_lists = $this->basic->get_data("ecommerce_product", $where4, $select4, $join4);
        }

        $subscriber_id = $this->session->userdata($product_data[0]['store_id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);


        $update_visit_count_sql = "UPDATE ecommerce_product SET visit_count=visit_count+1 WHERE id=" . $product_id;
        $this->basic->execute_complex_query($update_visit_count_sql);

        $user_id = isset($product_data[0]["user_id"]) ? $product_data[0]["user_id"] : 0;
        $fb_app_id = $this->get_app_id();
        $data = array('body' => "ecommerce/product_single", "page_title" => $product_data[0]['store_name'] . " | " . $product_data[0]['product_name'], "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $product_data[0]['store_favicon']));


        $review_data = array();
        $review_list_data = array();
        $xreview = array();
        $has_purchase_array = array();
        if ($this->ecommerce_review_comment_exist) {
            $review_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("product_id" => $product_id, "hidden" => "0")), array("product_id", "sum(rating) as total_point", "count(id) as total_review"), "", "", NULL, $order_by = '', $group_by = 'product_id');

            $join = array('messenger_bot_subscriber' => "messenger_bot_subscriber.subscribe_id=ecommerce_product_review.subscriber_id,left");
            $review_list_data = $this->basic->get_data("ecommerce_product_review", array("where" => array("product_id" => $product_id, "hidden" => "0")), array("ecommerce_product_review.*", "first_name", "last_name", "profile_pic", "image_path"), $join, "", NULL, $order_by = 'id DESC');

            if ($subscriber_id != '' && $this->user_id == "") {
                $join_me = array('ecommerce_cart_item' => "ecommerce_cart_item.cart_id=ecommerce_cart.id,left");
                $has_purchase_array = $this->basic->get_data("ecommerce_cart", array("where" => array("subscriber_id" => $subscriber_id, "product_id" => $product_id), "where_not_in" => array("status" => array("pending", "rejected"))), 'ecommerce_cart_item.*,count(cart_id) as total_row', $join_me, '', NULL, '', 'cart_id');
                $xreview = $this->basic->get_data("ecommerce_product_review", array("where" => array("product_id" => $product_id, "subscriber_id" => $subscriber_id)), '');

            }

        }

        // check the ecommerce related products exists or not
        $join222 = ['package' => 'users.package_id=package.id,left'];
        $select222 = ['users.id AS userid', 'users.user_type', 'users.package_id', 'package.*'];
        $get_user_info = $this->basic->get_data("users", ['where' => ['users.id' => $user_id]], $select222, $join222);
        $store_user_module_ids = isset($get_user_info[0]['module_ids']) ? explode(",", $get_user_info[0]['module_ids']) : [];

        $this->is_ecommerce_related_product_exist = false;
        if ($this->basic->is_exist("modules", array("id" => 317))) {
            if ((isset($get_user_info[0]) && $get_user_info[0]['user_type'] == 'Admin') || in_array(317, $store_user_module_ids)) {
                $this->is_ecommerce_related_product_exist = true;
            }
        }
        $data['related_product_lists'] = isset($related_product_lists) ? $related_product_lists : array();
        $data['upsell_product_lists'] = isset($upsell_product_lists) ? $upsell_product_lists : array();
        $data['downsell_product_lists'] = isset($downsell_product_lists) ? $downsell_product_lists : array();
        $data['downsell_product_id'] = isset($downsell_product_id) ? $downsell_product_id : 0;

        $data["review_data"] = $review_data;
        $data["review_list_data"] = $review_list_data;
        $data["xreview"] = $xreview;
        $data["has_purchase_array"] = $has_purchase_array;

        $category_list = $this->get_category_list($product_data[0]["store_id"], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        $data["product_data"] = $product_data[0];
        $data["attribute_list"] = $this->get_attribute_list($product_data[0]["store_id"], true);
        $data['currency_icons'] = $this->get_country_new('currecny_icon');
        $data['ecommerce_config'] = $this->get_ecommerce_config($product_data[0]["store_id"]);
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $product_data[0]['store_id']);
        $data["social_analytics_codes"] = $product_data[0];
        if ($this->addon_exist('ecommerce_product_price_variation')) $data["attribute_price_map"] = $this->basic->get_data("ecommerce_attribute_product_price", array("where" => array("product_id" => $product_id)));
        else $data["attribute_price_map"] = array();
        $data['current_product_id'] = isset($product_data[0]['id']) ? $product_data[0]['id'] : 0;
        $data['current_store_id'] = isset($product_data[0]['store_id']) ? $product_data[0]['store_id'] : 0;
        $data['is_rtl'] = (isset($product_data[0]['is_rtl']) && $product_data[0]['is_rtl'] == '1') ? true : false;
        $this->load->view('ecommerce/bare-theme', $data);
    }

    private function get_attribute_list($store_id = 0, $raw_data = false)
    {
        if ($store_id == 0) $store_id = $this->get_store_id($store_id);
        $at_list = $this->basic->get_data("ecommerce_attribute", array("where" => array("store_id" => $store_id, "status" => "1")), $select = '', $join = '', $limit = '', $start = NULL, $order_by = 'attribute_name ASC');
        if ($raw_data) return $at_list;
        $at_info = array();
        foreach ($at_list as $value) {
            $at_info[$value['id']] = $value['attribute_name'];
        }
        return $at_info;
    }

    private function get_product_list_array($store_id = 0, $default_where = "", $order_by = "", $limit = '', $start = NULL)
    {
        $where_simple = array("store_id" => $store_id, "status" => "1");
        if (isset($default_where['product_name'])) {
            $product_name = $default_where['product_name'];
            $this->db->where(" product_name LIKE " . "'%" . $product_name . "%'");
            unset($default_where['product_name']);
        }
        if (is_array($default_where) && !empty($default_where)) {
            foreach ($default_where as $key => $value) {
                $where_simple[$key] = $value;
            }
        }

        if ($order_by == "") $order_by = "product_name ASC";
        $product_list = $this->basic->get_data("ecommerce_product", array("where" => $where_simple), $select = '', $join = '', $limit, $start, $order_by);

        // echo $this->db->last_query();
        return $product_list;
    }

    public function get_product_list($store_id = '0', $ajax = '0', $multiselect = '0')
    {
        if ($ajax == '1') {
            $this->ajax_check();
            if ($store_id == '' || $store_id == '0') {
                echo form_dropdown('product_ids[]', array(), '', 'class="form-control select2" id="product_ids" multiple');
                echo "<script>$('.select2').select2();</script>";
                exit();
            }
        }

        $product_list = $this->basic->get_data("ecommerce_product", array("where" => array("user_id" => $this->user_id, "store_id" => $store_id, "status" => "1")), $select = '', $join = '', $limit = '', $start = NULL, $order_by = 'product_name ASC');
        $product_info = array();
        foreach ($product_list as $value) {
            $product_info[$value['id']] = $value['product_name'];
        }

        if ($ajax == '0') return $product_info;
        else {
            if ($multiselect == '0') echo form_dropdown('product_id', $product_info, '', 'class="form-control select2" id="product_id"');
            else echo form_dropdown('product_ids[]', $product_info, '0', 'class="form-control select2" id="product_ids" multiple');
            echo "<script>$('.select2').select2();</script>";
        }
    }

    private function get_product_id_array($product_list, $arr = null)
    {
        $exclude_ids = array_map(function ($el) {
            return $el['id'];
        }, $product_list);
        if (!empty($arr)) {
            $arr = str_replace(array('IN (', ')'), '', $arr);
            $arr = explode(',', $arr);
            $exclude_ids = array_unique(array_merge($exclude_ids, $arr), SORT_REGULAR);
        }
        $exclude_ids_query = "IN (" . implode(',', $exclude_ids) . ")";
        return $exclude_ids_query;
    }

    private function get_current_cart($subscriber_id = "", $store_id = 0, $pickup = "", $current_cart_id = '')
    {
        $current_cart = array("cart_count" => 0, "cart_id" => 0, "cart_data" => array());
        $store_id = $this->get_store_id($store_id);

        if (!empty($this->session->userdata($this->nstore_id . '_temp_cart'))) {
            $subscriber_id = $this->session->userdata($this->nstore_id . '_temp_cart');
        }


        if ($store_id != 0 && $subscriber_id != "") {
            $related_product_ids = explode(",", 'add,remove');
            $where_in3 = array('action_type' => $related_product_ids);
            $where_simple2 = array('subscriber_id' => $subscriber_id);
            $where2 = array('where' => $where_simple2, 'where_in' => $where_in3);
            $n_cart_data = $this->basic->get_data("ecommerce_cart", $where2, 'id', '', 1, null, 'id DESC');

            if (empty($n_cart_data[0])) {
                return $current_cart;
            }

            $join = array('ecommerce_cart_item' => "ecommerce_cart.id=ecommerce_cart_item.cart_id,right");
            $where_simple = array("ecommerce_cart.store_id" => $store_id, "action_type!=" => "checkout", "ecommerce_cart.id" => $n_cart_data[0]['id']);
            if ($subscriber_id != "") $where_simple["ecommerce_cart.subscriber_id"] = $subscriber_id;
            else $where_simple["ecommerce_cart.user_id"] = $this->user_id;
            $where = array('where' => $where_simple);
            $select = array("ecommerce_cart.*", "ecommerce_cart_item.id as ecommerce_cart_item_id", "cart_id", "product_id", "unit_price", "coupon_info", "quantity", "attribute_info");
            $cart_data = $this->basic->get_data("ecommerce_cart", $where, $select, $join);


            $cart_id = isset($cart_data[0]['cart_id']) ? $cart_data[0]['cart_id'] : 0;
            $cart_data_final = array();
            foreach ($cart_data as $key => $value) {
                if ($value["quantity"] <= 0) {
                    $this->basic->delete_data("ecommerce_cart_item", array("id" => $value["ecommerce_cart_item_id"]));
                    unset($cart_data[$key]);
                } else $cart_data_final[$value['product_id']] = $value;
            }
            $cart_count = count($cart_data);
            $cart_url = base_url("ecommerce/cart/" . $cart_id);
            $params = array("subscriber_id" => $subscriber_id);
            if (isset($pickup) && $pickup != "") $params['pickup'] = $pickup;
            $cart_url = mec_add_get_param($cart_url, $params);
            if ($cart_count == 0) {
                $this->basic->delete_data("ecommerce_cart", array("id" => $cart_id));
                $cart_id = 0;
                $cart_url = "";
            }
            $current_cart = array("cart_count" => $cart_count, "cart_id" => $cart_id, "cart_url" => $cart_url, "cart_data" => $cart_data_final, "cart_data_raw" => $cart_data);
        }
        return $current_cart;
    }

    public function get_buyer_profile()
    {
        $this->ajax_check();
        $store_id = $this->input->post("store_id", true);
        $login_error = '<p>
    <div class="alert alert-danger text-center">
    ' . $this->lang->line("Please login to continue.") . '<br><br><a href="" id="login_form" class="pointer btn btn-primary">' . $this->lang->line("Login to continue") . '</a>
    </div>
    </p>';

        $where_subs = array();
        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id != "") $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $store_id);
        else {
            if ($subscriber_id == "") $subscriber_id = $this->input->post("subscriber_id", true);
            if ($subscriber_id != "") $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
        }
        if ($subscriber_id == '') {
            echo $login_error;
            exit();
        }
        $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");
        $login_needed = false;
        if ($subscriber_info[0]['total_rows'] == 0) {
            echo $login_error;
            exit();
        }

        $where = array("subscriber_id" => $subscriber_id, 'profile_address' => '1');
        $address_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => $where));
        $country_names = $this->get_country_new();
        $phonecodes = $this->get_country_new('phonecode');
        $first_name = $last_name = $email = $mobile = $country = $city = $state = $address = $zip = $note = '';
        $store_data = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $store_id)), "store_country");
        if (!isset($store_data[0])) {
            echo '<div class="alert alert-danger text-center">' . $this->lang->line("Store not found.") . '</div>';
            exit();
        }

        $is_checkout_country = $is_checkout_state = $is_checkout_city = $is_checkout_zip = $is_checkout_email = $is_checkout_phone = '1';

        if (!isset($address_data[0])) {
            $address_data = $this->basic->get_data("messenger_bot_subscriber", array("where" => array("subscribe_id" => $subscriber_id)), "first_name,last_name,full_name,profile_pic,phone_number,user_location,email");
            $user_location = isset($address_data[0]['user_location']) ? json_decode($address_data[0]['user_location'], true) : array();
            $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
            $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
            $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
            $mobile = isset($address_data[0]['phone_number']) ? $address_data[0]['phone_number'] : '';
            $country = isset($user_location['country']) ? $user_location['country'] : '';
            $city = isset($user_location['city']) ? $user_location['city'] : '';
            $state = isset($user_location['state']) ? $user_location['state'] : '';
            $address = isset($user_location['street']) ? $user_location['street'] : '';
            $zip = isset($user_location['zip']) ? $user_location['zip'] : '';
        } else {
            $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
            $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
            $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
            $mobile = isset($address_data[0]['mobile']) ? $address_data[0]['mobile'] : '';
            $country = isset($address_data[0]['country']) ? $address_data[0]['country'] : '';
            $city = isset($address_data[0]['city']) ? $address_data[0]['city'] : '';
            $state = isset($address_data[0]['state']) ? $address_data[0]['state'] : '';
            $address = isset($address_data[0]['address']) ? $address_data[0]['address'] : '';
            $zip = isset($address_data[0]['zip']) ? $address_data[0]['zip'] : '';
            $note = isset($address_data[0]['note']) ? $address_data[0]['note'] : '';
        }
        $options = "";
        foreach ($country_names as $key => $value) {
            if ($country != '') $selected_country = ($key == $country) ? 'selected' : '';
            else $selected_country = ($key == $store_data[0]['store_country']) ? 'selected' : '';
            $phonecode_attr = isset($phonecodes[$key]) ? $phonecodes[$key] : '';
            $options .= '<option phonecode="' . $phonecode_attr . '" value="' . $key . '" ' . $selected_country . '>' . $value . '</option>';
        }

        $state_city_street_html = $country_html = $email_html = $phone_html = '';

        $state_var = ($is_checkout_state == '1') ? '
        <div class="col-md-4">
        
                                            <div class="form-group mb-3">
                                        <label for="state"> ' . $this->lang->line('State') .'*</label>
                                        <div class="select-box">
                                            <select id="state" name="state" class="form-control form-control-md">
                                                               <option value="' . $state . '" selected>' . $state . '</option>             
                                            </select>
                                        </div>
                                    </div>
</div>
        ' : '';
        $city_var = ($is_checkout_city == '1') ? '
                <div class="col-md-4">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('City') . '</label>
    <input type="text" class="form-control form-control-md"  name="city" value="' . $city . '" placeholder="' . $this->lang->line('City') . '">
</div></div>
        
        
        ' : '';
        $zip_var = ($is_checkout_zip == '1') ? '
                        <div class="col-md-4">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Zip') . '</label>
    <input type="text" class="form-control form-control-md"  name="zip" value="' . $zip . '" placeholder="' . $this->lang->line('Zip') . '">
</div></div>
        
        ' : '';

        if ($state_var != '' || $city_var != '' || $zip_var != '')
            $state_city_street_html .=
                '<div class="row">      
  ' . $state_var . $city_var . $zip_var . '
  </div>';

        $country_names = $this->get_country_new();
        $options = "";
        foreach ($country_names as $key => $value) {
            if ($country != '') $selected_country = ($key == $country) ? 'selected' : '';
            else $selected_country = ($key == $store_data[0]['store_country']) ? 'selected' : '';
            $phonecode_attr = isset($phonecodes[$key]) ? $phonecodes[$key] : '';
            $options .= '<option data-country="'. $value .'" phonecode="' . $phonecode_attr . '" value="' . $key . '" ' . $selected_country . '>' . $value . '</option>';
        }

        if ($is_checkout_country == '1')
            $country_html .=
                '

                          <div class="form-group mb-3">
                                <label for="country">'. $this->lang->line('country').'*</label>
                                <div class="select-box">
                                    <select id="country" name="country" class="form-control form-control-md select2">
                                    '. $options .'
                                    </select>
                                </div>
                            </div>


';

        $email_var = ($is_checkout_email == '1') ? '
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Email') . '</label>
    <input type="text" class="form-control form-control-md" name="email" value="' . $email . '" placeholder="' . $this->lang->line("Email") . '">
</div> ' : '';
        $mobile_var = ($is_checkout_phone == '1') ? '

        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Phone Number') . '</label>
    <span class="input-group-text" id="phonecode_val"></span>
<input type="text" class="form-control form-control-md" name="mobile" value="' . $mobile . '" placeholder="' . $this->lang->line("Phone Number") . '">
</div> ' : '';

        if ($is_checkout_email == '1')
            $email_html .= '

  ' . $email_var . '
';

        if ($is_checkout_phone == '1')
            $phone_html .= '

  ' . $mobile_var . '
';

        echo
            '
<div class="row">

<div class="col-md-6">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('First Name') . '*</label>
      <input type="text" class="form-control form-control-md" name="first_name" placeholder="' . $this->lang->line("First Name") . '*"  class="form-control-plaintext" value="' . $first_name . '">
</div>
</div>

<div class="col-md-6">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Last Name') . '*</label>
  <input type="text" class="form-control form-control-md" name="last_name" placeholder="' . $this->lang->line("Last Name") . '*"  class="form-control-plaintext" value="' . $last_name . '">
</div>
</div>


</div>            


        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Street') . '*</label>
    <input type="text" class="form-control form-control-md"  name="street" value="' . $address . '" placeholder="' . $this->lang->line('Street') . '*">
</div>

  
  ' . $state_city_street_html . '
  ' . $country_html . '
  ' . $email_html . '
  ' . $phone_html;
    }

    private function get_country_new($return = 'country') // country,currency_name,currecny_icon,phonecode
    {

        $countries = $this->basic->get_data("n_countries");

        $output = array();
        foreach ($countries as $key => $value) {

            switch($return){
                case 'country';
                    $output[$value['iso2']] = $value['name'];
                    break;

                case 'country_name';
                    $output[$value['name']] = $value['name'];
                    break;

                case 'country_id';
                    $output[$value['id']] = $value['name'];
                    break;

                case 'currency_name';
                    $output[$value['currency_code']] = $value['currency_code'] . " (" . $value['currency_name'] . ")";
                    break;

                case 'currecny_icon';
                    $output[$value['currency']] = $value['currency_symbol'];
                    break;

                default;
                    $output[$value['iso2']] = $value['phonecode'];
                    break;
            }

        }
        if (isset($output[''])) unset($output['']);

        asort($output);
        return $output;
    }

    private function get_state_new($country = '') // country,currency_name,currecny_icon,phonecode
    {

        $countries = $this->basic->get_data("n_states", array("where" => array("country_id" => $country)));

        $output = array();
        foreach ($countries as $key => $value) {
            $output[$value['id']] = $value['name'];
        }
        if (isset($output[''])) unset($output['']);

        asort($output);
        return $output;
    }

    public function get_buyer_profile_checkout()
    {
        //$this->ajax_check();
        $store_id = $this->get_store_ids($this->nstore_id);


        $where_subs = array();
        $subscriber_id=$this->session->userdata($store_id."ecom_session_subscriber_id");
        $login_needed = false;
        if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$store_id);
        else
        {
            if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);
            if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
        }
        if($subscriber_id=='') $login_needed = true;
        else
        {
            $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
            if($subscriber_info[0]['total_rows']==0) $login_needed = true;
        }
        if ($login_needed == true) {
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $this->nstore_id), 'location');
            exit();
        }

        $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");

        $login_needed = false;
        if ($subscriber_info[0]['total_rows'] == 0) {
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $this->nstore_id), 'location');
            exit();
        }

        $where = array("subscriber_id" => $subscriber_id, 'profile_address' => '1');
        $address_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => $where));
        $country_names = $this->get_country_new();
        $phonecodes = $this->get_country_new('phonecode');
        $first_name = $last_name = $email = $mobile = $country = $city = $state = $address = $zip = $note = '';
        $store_data = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $store_id)), "store_country");
        if (!isset($store_data[0])) {
            echo '<div class="alert alert-danger text-center">' . $this->lang->line("Store not found.") . '</div>';
            exit();
        }

        $is_checkout_country = $is_checkout_state = $is_checkout_city = $is_checkout_zip = $is_checkout_email = $is_checkout_phone = '1';

        if (!isset($address_data[0])) {
            $address_data = $this->basic->get_data("messenger_bot_subscriber", array("where" => array("subscribe_id" => $subscriber_id)), "first_name,last_name,full_name,profile_pic,phone_number,user_location,email");
            $user_location = isset($address_data[0]['user_location']) ? json_decode($address_data[0]['user_location'], true) : array();
            $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
            $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
            $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
            $mobile = isset($address_data[0]['phone_number']) ? $address_data[0]['phone_number'] : '';
            $country = isset($user_location['country']) ? $user_location['country'] : '';
            $city = isset($user_location['city']) ? $user_location['city'] : '';
            $state = isset($user_location['state']) ? $user_location['state'] : '';
            $address = isset($user_location['street']) ? $user_location['street'] : '';
            $zip = isset($user_location['zip']) ? $user_location['zip'] : '';
        } else {
            $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
            $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
            $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
            $mobile = isset($address_data[0]['mobile']) ? $address_data[0]['mobile'] : '';
            $country = isset($address_data[0]['country']) ? $address_data[0]['country'] : '';
            $city = isset($address_data[0]['city']) ? $address_data[0]['city'] : '';
            $state = isset($address_data[0]['state']) ? $address_data[0]['state'] : '';
            $address = isset($address_data[0]['address']) ? $address_data[0]['address'] : '';
            $zip = isset($address_data[0]['zip']) ? $address_data[0]['zip'] : '';
            $note = isset($address_data[0]['note']) ? $address_data[0]['note'] : '';
        }
        $options = "";
        foreach ($country_names as $key => $value) {
            if ($country != '') $selected_country = ($key == $country) ? 'selected' : '';
            else $selected_country = ($key == $store_data[0]['store_country']) ? 'selected' : '';
            $phonecode_attr = isset($phonecodes[$key]) ? $phonecodes[$key] : '';
            $options .= '<option data-country="'. $value .'" phonecode="' . $phonecode_attr . '" value="' . $key . '" ' . $selected_country . '>' . $value . '</option>';
        }

        $data = array();
        $data = array(
            'firstname' => $first_name,
            'last_name' => $last_name,
            'street' => $address,
            'state' => $state,
            'city' => $city,
            'zip' => $zip,
            'country_options' => $options,
            'email' => $email,
            'mobile' => $mobile,

        );



        return $data;
        //echo json_encode($data);


    }

    public function apply_store_delivery_method(){
        $this->ajax_check();
        $cart_id = $this->input->post("cart_id");
        $store_pickup = $this->input->post("store_pickup");
        $subscriber_id = $this->input->post("subscriber_id");
        $delivery_name = $this->input->post("delivery_name");
        $pickup_point_details = $this->input->post("pickup_point_details");

        $zone_id = $this->input->post("zone_id");
        $delivery_id = $this->input->post("delivery_id");

        $details = $this->basic->get_data("ecommerce_zones", array('where' => array('id' => $zone_id)));

        $del_price = 0;

        if(!empty($details[0])){
            $details[0]['delivery_methods'] = json_decode($details[0]['delivery_methods'], true);
            if(!empty($details[0]['delivery_methods'][$delivery_id])){
                $del_price= $details[0]['delivery_methods'][$delivery_id]['price'];
            }
        }

        $cart_data = priv_valid_cart_data($cart_id, $subscriber_id, 'payment_amount, store_id, coupon_code');
        $cart_data = $cart_data[0];

        $coupon_data = $this->get_coupon_data($cart_data['coupon_code'],$cart_data['store_id']);
        if(!empty($coupon_data)){
            $this->basic->update_data("ecommerce_cart",array("id"=>$cart_id),array("shipping"=>0));
        }
        $free_shipping_enabled = isset($coupon_data["free_shipping_enabled"]) ? $coupon_data["free_shipping_enabled"] : "0";

        if($free_shipping_enabled==1){
            $del_price=0;
        }

        $mashkor_details = '';
        if(file_exists(APPPATH.'modules/n_mashkar/include/calc_distance.php')){
            include(APPPATH.'modules/n_mashkar/include/calc_distance.php');
        }

        $this->db->set('payment_amount', 'subtotal+'.$del_price, FALSE);
        $this->basic->update_data(
            "ecommerce_cart",
            array(
                "id"=>$cart_id,
                "subscriber_id"=>$subscriber_id
            ),
            array(
                "store_pickup"=>$store_pickup,
                "n_shipping_method"=>$delivery_name,
                "pickup_point_details"=>$pickup_point_details,
                "shipping" => $del_price,
                "mashkor_details" => json_encode($mashkor_details),
                //"payment_amount" => "SUBTOTAL + ".$del_price
            )
        );


            $cart_data = priv_valid_cart_data($cart_id, $subscriber_id, 'payment_amount, store_id, coupon_code');
            $cart_data = $cart_data[0];

        $ecommerce_config = $this->get_ecommerce_config($cart_data['store_id']);
        $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;


        $json = array(
            'amount' =>  strval(mec_number_format($cart_data['payment_amount'], $decimal_point, '0')),
            'delivery_price' => $del_price,
            'free_shipping' => $free_shipping_enabled
        );


        echo json_encode($json);
    }

    public function get_buyer_address_list($return_dropdown='0')
    {
        $this->ajax_check();
        $store_id = $this->input->post("store_id",true);
        $login_error = '<p>
  <div class="alert alert-danger text-center">
  '.$this->lang->line("Please login to continue.").'<br><br><a href="" id="login_form" class="pointer btn btn-primary">'.$this->lang->line("Login to continue").'</a>
  </div>
  </p>';

        $where_subs = array();
        $subscriber_id=$this->session->userdata($store_id."ecom_session_subscriber_id");
        if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$store_id);
        else
        {
            if($subscriber_id=="") $subscriber_id = $this->input->post("subscriber_id",true);
            if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
        }
        if($subscriber_id=="")
        {
            echo $login_error;
            exit();
        }
        $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
        $login_needed = false;
        if($subscriber_info[0]['total_rows']==0 && $return_dropdown!='1'){
            echo $login_error;
            exit();
        }

        $data_close = $this->input->post("data_close",true);
        if(!isset($data_close) || $data_close=='') $data_close = '0';
        $where = array("subscriber_id"=>$subscriber_id);
        $address_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>$where));
        $country_names =  $this->get_country_names();
        $store_data = $this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$store_id)),"store_country");
        if(!isset($store_data[0]))
        {
            echo '<div class="alert alert-danger text-center">'.$this->lang->line("Store not found.").'</div>';
            exit();
        }

        if($return_dropdown=='1')
        {
            echo '<select class="form-control" name="select_delivery_address" id="select_delivery_address" >';
            foreach ($address_data as $key => $value)
            {
                $country = isset($country_names[$value['country']]) ? $country_names[$value['country']] : $value['country'];
                $store_address_array = array($value['address'],$value['city'],$value['state'],$value['zip'],$country);
                $store_address = implode(',', $store_address_array);
                $default = ($value['profile_address']=='1') ? 'selected' : '';
                $title = (empty($value['title']) && $value['profile_address']=='1') ? $this->lang->line("Same as Billing") : $value['title'];
                if(!empty($title)) $title = $title.': ';

                $data_option = ' 
                data-profile_address="'.$value['profile_address'].'" 
                data-first_name="'.$value['first_name'].'" 
                data-last_name="'.$value['last_name'].'" 
                data-address="'.$value['address'].'" 
                data-city="'.$value['city'].'" 
                data-state="'.$value['state'].'" 
                data-zip="'.$value['zip'].'" 
                data-title="'.$title.'" 
                data-country="'.$country.'" 
                data-mobile="'.$value['mobile'].'" 
                data-email="'.$value['email'].'" 
                ';


                echo '<option value="'.$value['id'].'" '.$default.$data_option.'>'.$title.$value['first_name'].' '.$value['last_name'].' : '.$value["address"].', '.$country.'</option>';
            }
            echo '</select>';
        }
        else
        {
            echo '<div class="list-group">';
            foreach ($address_data as $key => $value)
            {
                $country = isset($country_names[$value['country']]) ? $country_names[$value['country']] : $value['country'];

                $store_address_array = array($value['address'],$value['city'],$value['state'],$value['zip'],$country);

                $store_address = implode(',', $store_address_array);

                $default = ($value['is_default']=='1') ? '<span class="text-primary">'.$this->lang->line("Default").'</span>':'';
                $title = (empty($value['title']) && $value['profile_address']=='1') ? $this->lang->line("Billing") : $value['title'];
                if(!empty($title)) $title = $title.': ';
                echo '      
      <a href="#" data-close="'.$data_close.'" class="list-group-item list-group-item-action flex-column align-items-start saved_address_row" data-profile="'.$value['profile_address'].'" data-id="'.$value['id'].'">
      <div class="d-flex w-100 justify-content-between">
      <h6 class="mb-1">'.$title.$value['first_name'].' '.$value['last_name'].'</h6>
      <!--<small>'.$default.'</small>-->
      </div>
      <small>'.$store_address.'</small>
      </a>';
            }
            echo '</div>';
        }


    }

    public function get_buyer_address()
    {
        $this->ajax_check();


        $id = 0;
        $address_data = array();
        $subscriber_id = $this->input->post("subscriber_id", true);
        $store_id = $this->input->post("store_id", true);
        $operation = $this->input->post("operation", true);

        $country_names = $this->get_country_new();
        $phonecodes = $this->get_country_new('phonecode');
        $first_name = $last_name = $email = $mobile = $country = $city = $state = $address = $zip = $title = '';
        $store_data = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $store_id)), array("store_country", "store_locale"));
        if (!isset($store_data[0])) {
            echo '<div class="alert alert-danger text-center">' . $this->lang->line("Store not found.") . '</div>';
            exit();
        }

        $this->_language_loader($store_data[0]['store_locale']);
        $delete = '';

        if ($operation == 'edit') {
            $id = $this->input->post("id", true);
            $where = array("subscriber_id" => $subscriber_id, 'id' => $id);
            $address_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => $where));
            if (isset($address_data[0])) {
                $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
                $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
                $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
                $mobile = isset($address_data[0]['mobile']) ? $address_data[0]['mobile'] : '';
                $country = isset($address_data[0]['country']) ? $address_data[0]['country'] : '';
                $city = isset($address_data[0]['city']) ? $address_data[0]['city'] : '';
                $state = isset($address_data[0]['state']) ? $address_data[0]['state'] : '';
                $address = isset($address_data[0]['address']) ? $address_data[0]['address'] : '';
                $zip = isset($address_data[0]['zip']) ? $address_data[0]['zip'] : '';
                $title = isset($address_data[0]['title']) ? $address_data[0]['title'] : '';
            }
            $delete = '<a href="#" id="delete_address" data-id="' . $id . '" class="text-danger float-right pb-2"><i class="fas fa-trash"></i> ' . $this->lang->line("Delete") . '</a>';
        } else {
            $address_data = $this->basic->get_data("messenger_bot_subscriber", array("where" => array("subscribe_id" => $subscriber_id)));
            if (isset($address_data[0])) {
                $first_name = isset($address_data[0]['first_name']) ? $address_data[0]['first_name'] : '';
                $last_name = isset($address_data[0]['last_name']) ? $address_data[0]['last_name'] : '';
                $email = isset($address_data[0]['email']) ? $address_data[0]['email'] : '';
                $mobile = isset($address_data[0]['phone_number']) ? $address_data[0]['phone_number'] : '';
                $user_location = isset($address_data[0]['user_location']) ? json_decode($address_data[0]['user_location'], true) : array();
                $country = isset($user_location['country']) ? $user_location['country'] : '';
                $city = isset($user_location['city']) ? $user_location['city'] : '';
                $state = isset($user_location['state']) ? $user_location['state'] : '';
                $address = isset($user_location['street']) ? $user_location['street'] : '';
                $zip = isset($user_location['zip']) ? $user_location['zip'] : '';
            }
        }

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $is_checkout_country = isset($ecommerce_config['is_checkout_country']) ? $ecommerce_config['is_checkout_country'] : '1';
        $is_checkout_state = isset($ecommerce_config['is_checkout_state']) ? $ecommerce_config['is_checkout_state'] : '1';
        $is_checkout_city = isset($ecommerce_config['is_checkout_city']) ? $ecommerce_config['is_checkout_city'] : '1';
        $is_checkout_zip = isset($ecommerce_config['is_checkout_zip']) ? $ecommerce_config['is_checkout_zip'] : '1';
        $is_checkout_email = isset($ecommerce_config['is_checkout_email']) ? $ecommerce_config['is_checkout_email'] : '1';
        $is_checkout_phone = isset($ecommerce_config['is_checkout_phone']) ? $ecommerce_config['is_checkout_phone'] : '1';
        $is_delivery_note = isset($ecommerce_config['is_delivery_note']) ? $ecommerce_config['is_delivery_note'] : '1';


        $options = "";
        foreach ($country_names as $key => $value) {
            if ($country != '') $selected_country = ($key == $country) ? 'selected' : '';
            else $selected_country = ($key == $store_data[0]['store_country']) ? 'selected' : '';
            $phonecode_attr = isset($phonecodes[$key]) ? $phonecodes[$key] : '';
            $options .= '<option phonecode="' . $phonecode_attr . '" value="' . $key . '" ' . $selected_country . '>' . $value . '</option>';
        }

        $state_city_street_html = $country_html = $email_html = $phone_html = '';

        $state_var = ($is_checkout_state == '1') ? ' <div class="col-md-4">
 
 <div class="form-group mb-3">
                                        <label for="state"> ' . $this->lang->line('State') .'*</label>
                                        <div class="select-box">
                                            <select id="state" name="state" class="form-control form-control-md">
                                                               <option value="' . $state . '" selected>' . $state . '</option>             
                                            </select>
                                        </div>
                                    </div>

</div>' : '';
        $city_var = ($is_checkout_city == '1') ? ' <div class="col-md-4">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('City') . '</label>
    <input type="text" class="form-control form-control-md"  name="city" value="' . $city . '" placeholder="' . $this->lang->line('City') . '">
</div></div>' : '';
        $zip_var = ($is_checkout_zip == '1') ? '<div class="col-md-4">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Zip') . '</label>
    <input type="text" class="form-control form-control-md"  name="zip" value="' . $zip . '" placeholder="' . $this->lang->line('Zip') . '">
</div></div>' : '';

        if ($state_var != '' || $city_var != '' || $zip_var != '')
            $state_city_street_html .=
                '<div class="row">      
  ' . $state_var . $city_var . $zip_var . '
  </div>';

        if ($is_checkout_country == '1')
            $country_names = $this->get_country_new();
        $options = "";
        foreach ($country_names as $key => $value) {
            if ($country != '') $selected_country = ($key == $country) ? 'selected' : '';
            else $selected_country = ($key == $store_data[0]['store_country']) ? 'selected' : '';
            $phonecode_attr = isset($phonecodes[$key]) ? $phonecodes[$key] : '';
            $options .= '<option data-country="'. $value .'" phonecode="' . $phonecode_attr . '" value="' . $key . '" ' . $selected_country . '>' . $value . '</option>';
        }

            $country_html .=
                '<div class="form-group mb-3">
                                <label for="country">'. $this->lang->line('country').'*</label>
                                <div class="select-box">
                                    <select id="country" name="country" class="form-control form-control-md select2">
                                    '. $options .'
                                    </select>
                                </div>
</div>';

        $email_var = ($is_checkout_email == '1') ? '<div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Email') . '</label>
    <input type="text" class="form-control form-control-md" name="email" value="' . $email . '" placeholder="' . $this->lang->line("Email") . '">
</div> ' : '';
        $mobile_var = ($is_checkout_phone == '1') ? ' <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Phone Number') . '</label>
    <span class="input-group-text" id="phonecode_val"></span>
<input type="text" class="form-control form-control-md" name="mobile" value="' . $mobile . '" placeholder="' . $this->lang->line("Phone Number") . '">
</div>' : '';

        if ($is_checkout_email == '1')
            $email_html .= '
      
  ' . $email_var . '
';

        if ($is_checkout_phone == '1')
            $phone_html .= '
  
  ' . $mobile_var . '
';

        echo
            $delete . '
  <input type="hidden" name="id" class="form-control-plaintext" value="' . $id . '">

          <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Title') . '</label>
        <input type="text" class="form-control form-control-md""  name="title" value="' . $title . '" placeholder="' . $this->lang->line('Title') . '">
</div>
  

<div class="row">

<div class="col-md-6">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('First Name') . '*</label>
      <input type="text" class="form-control form-control-md" name="first_name" placeholder="' . $this->lang->line("First Name") . '*"  class="form-control-plaintext" value="' . $first_name . '">
</div>
</div>

<div class="col-md-6">
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Last Name') . '*</label>
  <input type="text" class="form-control form-control-md" name="last_name" placeholder="' . $this->lang->line("Last Name") . '*"  class="form-control-plaintext" value="' . $last_name . '">
</div>
</div>


</div>         
  
        <div class="form-group mb-3">
    <label for="firstname">' . $this->lang->line('Street') . '*</label>
    <input type="text" class="form-control form-control-md"  name="street" value="' . $address . '" placeholder="' . $this->lang->line('Street') . '*">
</div>
  
  ' . $state_city_street_html . '
  ' . $country_html . '
  ' . $email_html . '
  ' . $phone_html;
    }

    public function apply_cart_additional_data(){
        $this->ajax_check();
        $data = array();
        $curtime = date("Y-m-d H:i:s");
        $subscriber_id = $this->input->post("subscriber_id", true);
        $cart_id = $this->input->post("cart_id", true);
        $store_id = $this->input->post("store_id", true);

        $new_addr_is_selected = $this->input->post("new_addr_is_selected", true);

        $delivery_address_id = $this->input->post("delivery_address_id", true);
        $delivery_note = $this->input->post("delivery_note", true);

        $delivery_time = $this->input->post("delivery_time", true);


        $ecommerce_config =  $this->get_ecommerce_config($store_id);
        $is_order_schedule = isset($ecommerce_config['is_order_schedule']) ? $ecommerce_config['is_order_schedule'] : '0';

        if($is_order_schedule=='1')
        {
            $check_delivery_time = $delivery_time;
            if($check_delivery_time=="") $check_delivery_time = date("Y-m-d H:i:s");
            $check_date  = date('Y-m-d',strtotime($check_delivery_time));
            $check_day  = date('l',strtotime($check_delivery_time));
            $check_time  = date('H:i:s',strtotime($check_delivery_time));
            $ecommerce_store_business_hours = array();
            if(!empty($check_day))
                $ecommerce_store_business_hours  = $this->basic->get_data("ecommerce_store_business_hours",array("where"=>array("store_id"=>$store_id,"schedule_day"=>$check_day)));
            if(isset($ecommerce_store_business_hours[0]))
            {
                if($ecommerce_store_business_hours[0]['off_day']=='1')
                {
                    echo json_encode(array('status'=>'2','message'=>$this->lang->line('Sorry, but we cannot take the order. We are closed on')." ".$this->lang->line($check_day).'!'));
                    exit();
                }
                else
                {
                    $start_time = $check_date." ".$ecommerce_store_business_hours[0]['start_time'].":00";
                    $end_time = $check_date." ".$ecommerce_store_business_hours[0]['end_time'].":00";

                    $time_ok = false;
                    if(strtotime($check_delivery_time) >= strtotime($start_time) && strtotime($check_delivery_time) <= strtotime($end_time))
                        $time_ok = true;

                    if(!$time_ok)
                    {
                        if($delivery_time=='') echo json_encode(array('status'=>'2','message'=>$this->lang->line('Sorry, but we cannot take the order. We are closed now.')));
                        else echo json_encode(array('status'=>'2','message'=>$this->lang->line('Sorry, but we cannot take the order. We will be closed at the selected time. Please try selecting a new delivery time.')));
                        exit();
                    }

                }
            }
        }


        $billing_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>array("subscriber_id"=>$subscriber_id,"profile_address"=>"1")));
        if(isset($billing_data[0]))
        {
            $bill_first_name = $billing_data[0]['first_name'];
            $bill_last_name = $billing_data[0]['last_name'];
            $bill_country = $billing_data[0]['country'];
            $bill_email = $billing_data[0]['email'];
            $bill_mobile = $billing_data[0]['mobile'];
            $bill_city = $billing_data[0]['city'];
            $bill_state = $billing_data[0]['state'];
            $bill_address = $billing_data[0]['address'];
            $bill_zip = $billing_data[0]['zip'];
        }

        $delivery_data = $this->basic->get_data("ecommerce_cart_address_saved",array("where"=>array("subscriber_id"=>$subscriber_id,"id"=>$delivery_address_id)));
        if(isset($delivery_data[0]))
        {
            $buyer_first_name = $delivery_data[0]['first_name'];
            $buyer_last_name = $delivery_data[0]['last_name'];
            $buyer_country = $delivery_data[0]['country'];
            $buyer_email = $delivery_data[0]['email'];
            $buyer_mobile = $delivery_data[0]['mobile'];
            $buyer_city = $delivery_data[0]['city'];
            $buyer_state = $delivery_data[0]['state'];
            $buyer_address = $delivery_data[0]['address'];
            $buyer_zip = $delivery_data[0]['zip'];
        }else{
            $buyer_first_name = $billing_data[0]['first_name'];
            $buyer_last_name = $billing_data[0]['last_name'];
            $buyer_country = $billing_data[0]['country'];
            $buyer_email = $billing_data[0]['email'];
            $buyer_mobile = $billing_data[0]['mobile'];
            $buyer_city = $billing_data[0]['city'];
            $buyer_state = $billing_data[0]['state'];
            $buyer_address = $billing_data[0]['address'];
            $buyer_zip = $billing_data[0]['zip'];
        }


        $update_data = array(
            "buyer_first_name"=>$buyer_first_name,
            "buyer_last_name"=>$buyer_last_name,
            "buyer_email"=>$buyer_email,
            "buyer_mobile"=>$buyer_mobile,
            "buyer_country"=>$buyer_country,
            "buyer_state"=>$buyer_state,
            "buyer_city"=>$buyer_city,
            "buyer_address"=>$buyer_address,
            "updated_at"=>$curtime,
            "buyer_zip"=>$buyer_zip,

            "bill_first_name"=>$bill_first_name,
            "bill_last_name"=>$bill_last_name,
            "bill_country"=>$bill_country,
            "bill_email"=>$bill_email,
            "bill_mobile"=>$bill_mobile,
            "bill_city"=>$bill_city,
            "bill_state"=>$bill_state,
            "bill_address"=>$bill_address,
            "bill_zip"=>$bill_zip,

            "delivery_note"=>$delivery_note,
            "delivery_time"=>$delivery_time
        );

        $this->basic->update_data("ecommerce_cart",array("id"=>$cart_id,"subscriber_id"=>$subscriber_id,"action_type !="=>"checkout"),$update_data);



        //set and check delivery time




        echo json_encode(array('status' => '1', 'message' => $this->lang->line("Delivery address has been saved successfully.")));

    }

    public function save_address()
    {
        $this->ajax_check();
        $data = array();
        foreach ($_POST as $key => $value) {
            $$key = strip_tags($this->input->post($key, true));
            $data[$key] = $$key;
        }
        if ($subscriber_id == '') {
            echo json_encode(array('status' => '0', 'message' => $this->login_to_continue));
            exit();
        }
        if (isset($mobile) && isset($country_code)) {
            $pos = strpos($mobile, $country_code);
            $country_code_embeded = ($pos !== false && $pos === 0) ? true : false;
            if ($mobile !== '' && !$country_code_embeded) $mobile = $country_code . $mobile;
            if (isset($data["mobile"])) $data["mobile"] = $mobile;
        }

        $data["address"] = $data["street"];
        $data["profile_address"] = "0";
        unset($data['store_id']);
        if (isset($data['country_code'])) unset($data['country_code']);
        unset($data['street']);
        //if(isset($data['id']))unset($data['id']);

        if (isset($data['id']) && $data['id'] != 0)
            $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id, "id" => $data['id']), $data);
        else {
            $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id), array("is_default" => "0"));
            $data["is_default"] = "1";
            $this->basic->insert_data("ecommerce_cart_address_saved", $data);
        }

        echo json_encode(array('status' => '1', 'message' => $this->lang->line("Delivery address has been saved successfully.")));

    }

    public function comment_list_data()
    {
        $this->ajax_check();
        $subscriber_id = $this->input->post("subscriber_id", true); // to load a single comment
        $comment_id = $this->input->post("comment_id", true); // to load a single comment
        $product_id = $this->input->post("product_id", true);
        $store_id = $this->input->post("store_id", true);
        $store_favicon = $this->input->post("store_favicon", true);
        $store_name = strip_tags($this->input->post("store_name", true));
        if ($store_name == "") $store_name = $this->lang->line("Administrator");
        $start = $this->input->post("start", true);
        $limit = $this->input->post("limit", true);

        $select = array("ecommerce_product_comment.*", "first_name", "last_name", "profile_pic", "image_path");
        if (empty($comment_id)) $where = array("where" => array("ecommerce_product_comment.product_id" => $product_id, "hidden" => "0", "parent_product_comment_id" => 0));
        else $where = array("where" => array("ecommerce_product_comment.id" => $comment_id, "hidden" => "0", "parent_product_comment_id" => 0));
        $join = array('messenger_bot_subscriber' => "messenger_bot_subscriber.subscribe_id=ecommerce_product_comment.subscriber_id,left");
        $parent_comment_info = $this->basic->get_data("ecommerce_product_comment", $where, $select, $join, $limit, $start, $order_by = "id DESC");
        $total_rows_array = $this->basic->count_row("ecommerce_product_comment", $where, $count = 'ecommerce_product_comment.id', $join);
        $total_rows = $total_rows_array[0]['total_rows'];
        $parent_ids = array();
        foreach ($parent_comment_info as $key => $value) {
            array_push($parent_ids, $value['id']);
        }
        $parent_ids = array_unique($parent_ids);

        // getting child comments (using same join param and derived parent array)
        $total_comment = count($parent_comment_info);
        $child_comment_info_formatted = array();
        if (!empty($parent_ids)) {
            $child_comment_info = $this->basic->get_data("ecommerce_product_comment", array("where" => array("ecommerce_product_comment.product_id" => $product_id, "hidden" => "0"), "where_in" => array("parent_product_comment_id" => $parent_ids)), $select, $join, $limit = '', $start = NULL, $order_by = "id ASC");
            foreach ($child_comment_info as $key => $value) {
                $total_comment++;
                $child_comment_info_formatted[$value['parent_product_comment_id']][] = $value;
            }
        }

        $html = '';
        $border_bottom = empty($comment_id) ? "border-bottom" : "";
        foreach ($parent_comment_info as $key => $value) {
            $sub_comments = '';
            $divId = "collapse" . $value['id'];
            if (isset($child_comment_info_formatted[$value['id']]))
                foreach ($child_comment_info_formatted[$value['id']] as $key2 => $value2) {
                    if ($value2['subscriber_id'] == '') $commenter2 = $store_name . " <i class='fas fa-user-circle text-primary'></i>";
                    else $commenter2 = $value2["first_name"] . " " . $value2["last_name"];
                    $profile_pic2 = ($value2['profile_pic'] != "") ? $value2["profile_pic"] : base_url('assets/img/avatar/avatar-1.png');
                    $image_path2 = ($value2["image_path"] != "") ? base_url($value2["image_path"]) : $profile_pic2;

                    if ($value2['subscriber_id'] == '' && !empty($store_favicon)) $image_path2 = "<img class='rounded-circle mr-3' style='height:50px;width:50px;' src='" . base_url('upload/ecommerce/' . $store_favicon) . "'>";

                    $hide_link2 = "";
                    if ($this->user_id != '') $hide_link2 = '
                    <a href="#" data-id="' . $value2['id'] . '"  class="btn btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize hide-comment">
                <i class="fa fa-eye-slash"></i>' . $this->lang->line("Hide") . '
            </a>';

                    $new_comment_formatted2 = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $value2["comment_text"]); // find and replace links with ancor tag
                    $sub_comments .= '
                        <li class="comment" id="comment-' . $value2['id'] . '">
                            <div class="comment-body">
                                <figure class="comment-avatar">
                                    <img src="' . $image_path2 . '" onerror="this.onerror=null;this.src=\'' . base_url('assets/img/avatar/avatar-1.png') . '\';" style="border-radius: 50%" alt="Commenter Avatar" width="90" height="90">
                                </figure>
                                <div class="comment-content" style="width: 100%;">
                                    <h4 class="comment-author">
                                        <span>' . $commenter2 . '</span>
                                        <span class="comment-date">' . date("d M,y H:i", strtotime($value2['inserted_at'])) . '</span>
                                    </h4>
                                    <p>' . nl2br($new_comment_formatted2) . '</p>
                                    <div class="comment-action">
                                        ' . $hide_link2 . '
                                    </div>
                                </div>
                            </div>
                        </li>';
                }

            if ($value['subscriber_id'] == '') $commenter = $store_name . " <i class='fas fa-user-circle text-primary'></i>";
            else $commenter = $value["first_name"] . " " . $value["last_name"];
            $profile_pic = ($value['profile_pic'] != "") ? $value["profile_pic"] : base_url('assets/img/avatar/avatar-1.png');
            $image_path = ($value["image_path"] != "") ? base_url($value["image_path"]) : $profile_pic;
            if ($value['subscriber_id'] == '' && !empty($store_favicon)) $image_path = "<img class='rounded-circle mr-3' style='height:50px;width:50px;' src='" . base_url('upload/ecommerce/' . $store_favicon) . "'>";
            $hide_link = "";
            if ($this->user_id != '') $hide_link = '
            <a href="#" data-id="' . $value['id'] . '"  class="btn btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize hide-comment">
                <i class="fa fa-eye-slash"></i>' . $this->lang->line("Hide") . '
            </a>';
            $new_comment_formatted = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $value["comment_text"]); // find and replace links with ancor tag
            $direct_link = $this->return_base_url_php("ecommerce/comment/" . $value['id']);
            if ($subscriber_id != "") $direct_link .= "?subscriber_id=" . $subscriber_id;
            $html .= '
            <li class="comment" id="comment-' . $value['id'] . '">
                <div class="comment-body">
                    <figure class="comment-avatar">
                        <img src="' . $image_path . '" style="border-radius: 50%" alt="Commenter Avatar" width="90" height="90">
                    </figure>
                    <div class="comment-content" style="width: 100%;">
                        <h4 class="comment-author">
                            <a href="' . $direct_link . '">' . $commenter . '</a>
                            <span class="comment-date">' . date("d M,y H:i", strtotime($value['inserted_at'])) . '</span>
                        </h4>
                        <p>' . nl2br($new_comment_formatted) . '</p>
                        <div class="comment-action">
                            <a href="#" data-id="#collapsecom' . $divId . '"  class="collapse_link  btn btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize" role="button" aria-expanded="false" aria-controls="collapsecom' . $divId . '">
                                <i class="far fa-comment"></i>' . $this->lang->line("Reply") . '
                            </a>
                            ' . $hide_link . '
                            <div class="pt-2" id="collapsecom' . $divId . '" style="display: none;">
                                <textarea class="form-control comment_reply" name="comment_reply" style="height:50px !important;"></textarea>
                                <button class="btn btn-dark leave_comment no_radius" parent-id=' . $value["id"] . '><i class="fa fa-reply"></i> ' . $this->lang->line("Reply") . '</button>              
                            </div>
                        </div>
                    </div>
                </div>
                <ul style="margin-top:50px; margin-left: 50px;">
                ' . $sub_comments . '
                </ul>
            </li>

                  
';
        }
        echo json_encode(array("html" => $html, "found" => count($parent_comment_info)));
    }

    public function ajax_get_payment_button($method, $cart_id, $store_id, $subscriber_id = 0 ){
        $this->ajax_check();
        $subscriber_id_bck = $subscriber_id;
        $tmp_store_id = $store_id;

        $where_subs = array();
        $subscriber_id=$this->session->userdata($tmp_store_id."ecom_session_subscriber_id");
        $login_needed = false;

        if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$tmp_store_id);
        else
        {
            if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);
            if($subscriber_id=="") $subscriber_id = $subscriber_id_bck;
            if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
        }
        if($subscriber_id=='') $login_needed = true;
        else
        {
            $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
            if($subscriber_info[0]['total_rows']==0) $login_needed = true;

        }

        if ($login_needed == true) {
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $this->nstore_id), 'location');
            exit();
        }


        $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");
        if ($subscriber_info[0]['total_rows'] == 0) {
            echo json_encode(array('status' => '0', 'message' => $this->login_to_continue, 'login_popup' => '1'));
            exit();
        }

        $select = $this->proceed_checkout_get_select();

        $cart_data = $this->valid_cart_data($cart_id, $subscriber_id, $select);

        if (!isset($cart_data[0]) || (isset($cart_data[0]) && $cart_data[0]["store_id"] == "")) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Order data not found.')));
            exit();
        }
        $this->_language_loader($cart_data[0]['store_locale']);

        $payment_amount = get_payment_amount($cart_id, $subscriber_id);

        $store_id = $cart_data[0]["store_id"];
        $user_id = $cart_data[0]["user_id"];

        $cancel_url = base_url(return_ecommerce_base_url("order/") . $cart_id . "?subscriber_id=" . $subscriber_id . "&action=cancel");
        $success_url = base_url(return_ecommerce_base_url("order/") . $cart_id . "?subscriber_id=" . $subscriber_id . "&action=success");

        $store_name = $cart_data[0]["store_name"];
        $product_name = $store_name . " : " . $this->lang->line("Order") . " #" . $cart_id;

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : 'USD';

        $store_favicon = $cart_data[0]["store_favicon"];
        if ($store_favicon != "") $store_favicon = base_url("upload/ecommerce/" . $store_favicon);

        $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "profile_address" => "1")));
        if (isset($billing_data[0])) {
            $bill_first_name = $billing_data[0]['first_name'];
            $bill_last_name = $billing_data[0]['last_name'];
            $bill_country = $billing_data[0]['country'];
            $bill_email = $billing_data[0]['email'];
            $bill_mobile = $billing_data[0]['mobile'];
            $bill_city = $billing_data[0]['city'];
            $bill_state = $billing_data[0]['state'];
            $bill_address = $billing_data[0]['address'];
            $bill_zip = $billing_data[0]['zip'];
        }
        if (!empty($delivery_address_id) && $store_pickup == '0') {
            $delivery_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "id" => $delivery_address_id)));
            if (isset($delivery_data[0])) {
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id), array("is_default" => '0'));
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id, "id" => $delivery_address_id), array("is_default" => '1'));
                $buyer_first_name = $delivery_data[0]['first_name'];
                $buyer_last_name = $delivery_data[0]['last_name'];
                $buyer_country = $delivery_data[0]['country'];
                $buyer_email = $delivery_data[0]['email'];
                $buyer_mobile = $delivery_data[0]['mobile'];
                $buyer_city = $delivery_data[0]['city'];
                $buyer_state = $delivery_data[0]['state'];
                $buyer_address = $delivery_data[0]['address'];
                $buyer_zip = $delivery_data[0]['zip'];
            }
        } else $buyer_first_name = $buyer_last_name = $buyer_country = "";

        $customer_mobile = $bill_mobile != '' ? $bill_mobile : $buyer_mobile;
        $customer_email = $bill_email != '' ? $bill_email : $buyer_email;
        $customer_first_name = $bill_first_name != '' ? $bill_first_name : $buyer_first_name;
        $customer_last_name = $bill_last_name != '' ? $bill_last_name : $buyer_last_name;
        $customer_name = $customer_first_name . " " . $customer_last_name;


        switch($method){
            case 'paypal';
                $this->load->library('paypal_class_ecommerce');
                $paypal_email = isset($ecommerce_config['paypal_email']) ? $ecommerce_config['paypal_email'] : '';
                $paypal_mode = isset($ecommerce_config['paypal_mode']) ? $ecommerce_config['paypal_mode'] : 'live';



                $this->paypal_class_ecommerce->mode = $paypal_mode;
                $this->paypal_class_ecommerce->cancel_url = $cancel_url;
                $this->paypal_class_ecommerce->success_url = $success_url;
                $this->paypal_class_ecommerce->notify_url = base_url(return_ecommerce_base_url("paypal_action/") . $store_id);
                $this->paypal_class_ecommerce->business_email = $paypal_email;
                $this->paypal_class_ecommerce->amount = $payment_amount;
                $this->paypal_class_ecommerce->user_id = $user_id;
                $this->paypal_class_ecommerce->currency = $currency;
                $this->paypal_class_ecommerce->cart_id = $cart_id;
                $this->paypal_class_ecommerce->subscriber_id = $subscriber_id;
                $this->paypal_class_ecommerce->product_name = $product_name;
                $this->paypal_class_ecommerce->button_lang = $this->lang->line("Pay with PayPal");
                $this->paypal_class_ecommerce->secondary_button = true;
                $paypal_button = $this->paypal_class_ecommerce->set_button();
                $payment_button = '<div class="col-12 col-md-6">' . $paypal_button . '</div>';
            break;

            case 'stripe';
                $stripe_secret_key = isset($ecommerce_config['stripe_secret_key']) ? $ecommerce_config['stripe_secret_key'] : '';
                $stripe_publishable_key = isset($ecommerce_config['stripe_publishable_key']) ? $ecommerce_config['stripe_publishable_key'] : '';
                $stripe_billing_address = isset($ecommerce_config['stripe_billing_address']) ? $ecommerce_config['stripe_billing_address'] : '0';

                $this->load->library('stripe_class_ecommerce');
                $this->stripe_class_ecommerce->secret_key = $stripe_secret_key;
                $this->stripe_class_ecommerce->publishable_key = $stripe_publishable_key;
                $this->stripe_class_ecommerce->title = $store_name;
                $this->stripe_class_ecommerce->description = $this->lang->line("Order") . " #" . $cart_id;
                $this->stripe_class_ecommerce->amount = $payment_amount;
                $this->stripe_class_ecommerce->action_url = base_url(return_ecommerce_base_url("stripe_action/") . $store_id . '/' . $cart_id . '/' . $subscriber_id . '/' . $payment_amount . '/' . $currency . '/' . urlencode($store_name));
                $this->stripe_class_ecommerce->currency = $currency;
                $this->stripe_class_ecommerce->img_url = $store_favicon;
                $this->stripe_class_ecommerce->button_lang = $this->lang->line("Pay with Stripe");
                $this->stripe_class_ecommerce->stripe_billing_address = $stripe_billing_address;
                $this->stripe_class_ecommerce->secondary_button = true;
                $stripe_button = $this->stripe_class_ecommerce->set_button();
                $payment_button = '<div class="col-12 col-md-6">' . $stripe_button . '</div>';
            break;

            case 'razorpay';
                $razorpay_key_id = isset($ecommerce_config['razorpay_key_id']) ? $ecommerce_config['razorpay_key_id'] : '';
                $razorpay_key_secret = isset($ecommerce_config['razorpay_key_secret']) ? $ecommerce_config['razorpay_key_secret'] : '';

                $this->load->library("razorpay_class_ecommerce");

                $this->razorpay_class_ecommerce->key_id = $razorpay_key_id;
                $this->razorpay_class_ecommerce->key_secret = $razorpay_key_secret;
                $this->razorpay_class_ecommerce->title = $store_name;
                $this->razorpay_class_ecommerce->description = $this->lang->line("Order") . " #" . $cart_id;
                $this->razorpay_class_ecommerce->amount = $payment_amount;
                $this->razorpay_class_ecommerce->action_url = base_url(return_ecommerce_base_url("razorpay_action/") . $store_id . '/' . $cart_id . '/' . $subscriber_id);
                $this->razorpay_class_ecommerce->currency = $currency;
                $this->razorpay_class_ecommerce->img_url = $store_favicon;
                $this->razorpay_class_ecommerce->customer_name = $customer_name;
                $this->razorpay_class_ecommerce->customer_email = $customer_email;
                $this->razorpay_class_ecommerce->button_lang = $this->lang->line("Pay with Razorpay");
                $this->razorpay_class_ecommerce->secondary_button = true;
                $razorpay_button = $this->razorpay_class_ecommerce->set_button();
                $payment_button = '<div class="col-12 col-md-6">' . $razorpay_button . '</div>';
                break;

            case 'paystack';
                $paystack_secret_key = isset($ecommerce_config['paystack_secret_key']) ? $ecommerce_config['paystack_secret_key'] : '';
                $paystack_public_key = isset($ecommerce_config['paystack_public_key']) ? $ecommerce_config['paystack_public_key'] : '';

                $this->load->library("paystack_class_ecommerce");

                $this->paystack_class_ecommerce->secret_key = $paystack_secret_key;
                $this->paystack_class_ecommerce->public_key = $paystack_public_key;
                $this->paystack_class_ecommerce->title = $store_name;
                $this->paystack_class_ecommerce->description = $this->lang->line("Order") . " #" . $cart_id;
                $this->paystack_class_ecommerce->amount = $payment_amount;
                $this->paystack_class_ecommerce->action_url = base_url(return_ecommerce_base_url("paystack_action/") . $store_id . '/' . $cart_id . '/' . $subscriber_id);
                $this->paystack_class_ecommerce->currency = $currency;
                $this->paystack_class_ecommerce->img_url = $store_favicon;
                $this->paystack_class_ecommerce->customer_first_name = $customer_first_name;
                $this->paystack_class_ecommerce->customer_last_name = $customer_last_name;
                if ($customer_email != "") $this->paystack_class_ecommerce->customer_email = $customer_email;
                else $this->paystack_class_ecommerce->customer_email = $fake_email;
                $this->paystack_class_ecommerce->button_lang = $this->lang->line("Pay with Paystack");
                $this->paystack_class_ecommerce->secondary_button = true;
                $paystack_button = $this->paystack_class_ecommerce->set_button();
                $payment_button = '<div class="col-12 col-md-6">' . $paystack_button . '</div>';
                break;

            case 'mollie';
                $mollie_api_key = isset($ecommerce_config['mollie_api_key']) ? $ecommerce_config['mollie_api_key'] : '';

                $this->load->library("mollie_class_ecommerce");

                $this->mollie_class_ecommerce->api_key = $mollie_api_key;
                $this->mollie_class_ecommerce->title = $store_name;
                $this->mollie_class_ecommerce->description = $this->lang->line("Order") . " #" . $cart_id;
                $this->mollie_class_ecommerce->amount = $payment_amount;
                $this->mollie_class_ecommerce->action_url = base_url(return_ecommerce_base_url("mollie_action/") . $store_id . '/' . $cart_id . '/' . $subscriber_id);
                $this->mollie_class_ecommerce->currency = $currency;
                $this->mollie_class_ecommerce->img_url = $store_favicon;
                $this->mollie_class_ecommerce->customer_name = $customer_name;
                $this->mollie_class_ecommerce->customer_email = $customer_email;
                $this->mollie_class_ecommerce->ec_order_id = $cart_id;
                $this->mollie_class_ecommerce->button_lang = $this->lang->line("Pay with Mollie");
                $this->mollie_class_ecommerce->secondary_button = true;
                $mollie_button = $this->mollie_class_ecommerce->set_button_ecommerce();
                $payment_button = '<div class="col-12 col-md-6">' . $mollie_button . '</div>';
                break;

            case 'senangpay';
                $senangpay_merchent_id = isset($ecommerce_config['senangpay_merchent_id']) ? $ecommerce_config['senangpay_merchent_id'] : '';
                $senangpay_secret_key = isset($ecommerce_config['senangpay_secret_key']) ? $ecommerce_config['senangpay_secret_key'] : '';
                $senangpay_mode = isset($ecommerce_config['senangpay_mode']) ? $ecommerce_config['senangpay_mode'] : 'live';

                $details = "#" . $cart_id;
                // $hashed_string = md5($senangpay_secret_key.urldecode($details).urldecode($payment_amount).urldecode($cart_id));
                $hashed_string = hash_hmac('sha256', $senangpay_secret_key . urldecode($details) . urldecode($payment_amount) . urldecode($cart_id), $senangpay_secret_key);

                $this->load->library('senangpay');
                $this->senangpay->merchant_id = $senangpay_merchent_id;
                $this->senangpay->secretkey = $senangpay_secret_key;
                $this->senangpay->detail = $details;
                $this->senangpay->amount = $payment_amount;
                $this->senangpay->order_id = $cart_id;
                $this->senangpay->name = $customer_name;
                $this->senangpay->email = $customer_email;
                $this->senangpay->phone = $customer_mobile;
                $this->senangpay->senangpay_mode = $senangpay_mode;
                $this->senangpay->hashed_string = $hashed_string;
                $this->senangpay->secondary_button = true;
                $this->senangpay->button_lang = $this->lang->line('Pay with Senangpay');
                $senangpay_button = $this->senangpay->set_button();
                $payment_button = '<div id="senangpay_btn" class="col-12 col-md-6">' . $senangpay_button . '</div>';
                break;

            case 'xendit';
                $xendit_redirect_url = base_url(return_ecommerce_base_url('xendit_action/')) . $cart_id;
                $xendit_success_redirect_url = base_url(return_ecommerce_base_url('xendit_success/'));
                $xendit_failure_redirect_url = base_url(return_ecommerce_base_url('xendit_fail/'));
                $this->load->library('xendit');
                $this->xendit->xendit_redirect_url = $xendit_redirect_url;
                $this->xendit->xendit_success_redirect_url = $xendit_success_redirect_url;
                $this->xendit->xendit_failure_redirect_url = $xendit_failure_redirect_url;
                $this->xendit->button_lang = $this->lang->line('Pay with Xendit');
                $xendit_button = $this->xendit->set_button();
                $payment_button = '<div class="col-12 col-md-6" id="xendit_btn">' . $xendit_button . '</div>';
                break;

            case 'mercadopago';
                $mercadopago_enabled = $cart_data[0]["mercadopago_enabled"];

                $marcadopago_country = $cart_data[0]["marcadopago_country"];

                    $mercadopago_public_key = isset($ecommerce_config['mercadopago_public_key']) ? $ecommerce_config['mercadopago_public_key'] : '';

                    $mercadopago_access_token = isset($ecommerce_config['mercadopago_access_token']) ? $ecommerce_config['mercadopago_access_token'] : '';

                    $this->load->library("mercadopago");
                    $this->mercadopago->public_key = $mercadopago_public_key;
                    $this->mercadopago->redirect_url =
                        base_url(return_ecommerce_base_url('mercadopago_action/')) . $cart_id;
                    $this->mercadopago->transaction_amount = $payment_amount;
                    $this->mercadopago->secondary_button = false;
                    $this->mercadopago->button_lang = $this->lang->line('Pay with Mercado Pago');
                    $this->mercadopago->marcadopago_url = 'https://www.mercadopago.com.' . $marcadopago_country;
                $payment_button = $this->mercadopago->set_button();
                break;




        }



        echo json_encode(array(
            'button' => $payment_button
        ));
    }

    public function comment($comment_id = 0)
    {
        if ($comment_id == 0) exit();
        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
        if (!$this->ecommerce_review_comment_exist) exit();
        $where_simple = array("ecommerce_product_comment.id" => $comment_id, "ecommerce_product_comment.hidden" => "0", "ecommerce_product.deleted" => "0");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_product' => "ecommerce_product.id=ecommerce_product_comment.product_id,left", 'ecommerce_store' => "ecommerce_product_comment.store_id=ecommerce_store.id,left");
        $select = array("ecommerce_product_comment.*", "product_name", "ecommerce_product.user_id", "store_name", "store_unique_id", "store_logo", "store_favicon", "terms_use_link", "refund_policy_link", "store_locale", "is_rtl", "pixel_id", "google_id");
        $product_data = $this->basic->get_data("ecommerce_product_comment", $where, $select, $join);

        if (!isset($product_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Comment not found.") . '</h2>';
            exit();
        }
        $this->_language_loader($product_data[0]['store_locale']);

        $subscriber_id = $this->session->userdata($product_data[0]['store_id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);

        $user_id = isset($product_data[0]["user_id"]) ? $product_data[0]["user_id"] : 0;
        $fb_app_id = $this->get_app_id();
        $page_title = $product_data[0]['store_name'] . " | " . $product_data[0]['product_name'] . " | " . $this->lang->line("Comment") . "#" . $comment_id;
        $data = array('body' => "ecommerce/comment_single", "page_title" => $page_title, "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $product_data[0]['store_favicon']));

        $category_list = $this->get_category_list($product_data[0]['store_id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        $data["product_data"] = $product_data[0];
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $product_data[0]['store_id']);
        $data["social_analytics_codes"] = $product_data[0];
        $data['current_product_id'] = isset($product_data[0]['product_id']) ? $product_data[0]['product_id'] : 0;
        $data['current_store_id'] = isset($product_data[0]['store_id']) ? $product_data[0]['store_id'] : 0;
        $data['comment_id'] = $comment_id;
        $data['ecommerce_config'] = $this->get_ecommerce_config($product_data[0]["store_id"]);
        $data['is_rtl'] = (isset($product_data[0]['is_rtl']) && $product_data[0]['is_rtl'] == '1') ? true : false;
        $this->load->view('ecommerce/bare-theme', $data);
    }

    private function check_access()
    {
        $eco_host = $_SERVER['HTTP_HOST'];

        $n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
            "host_url" => $eco_host,
            "active" => 1,
        )));
        //var_dump(empty($n_cd_data[0]) AND !isset($n_cd_data[0]));
        if (empty($n_cd_data[0]) and !isset($n_cd_data[0])) {
            include(APPPATH . 'custom_domain.php');
            $page_title = $this->lang->line("404 | Domain not recognized");
            $message = $this->lang->line("The domain you were looking for could not be found.");
            $orig_domain = $ncd_config['custom_domain_host'];
            include(APPPATH . 'n_views/page/error_cname_new.php');
//            $this->load->view('page/error_cname', $data);
            exit;
        }

        $n_cd_data = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $n_cd_data[0]['custom_id'])));
        if (!isset($n_cd_data[0])) {
            include(APPPATH . 'custom_domain.php');
            $page_title = $this->lang->line("404 | Domain not recognized");
            $message = $this->lang->line("The domain you were looking for could not be found.");
            $orig_domain = $ncd_config['custom_domain_host'];

            include(APPPATH . 'n_views/page/error_cname_new.php');
//            $this->load->view('page/error_cname', $data);
            exit;
        }

        $where_q = array(
            "where" => array("id" => $n_cd_data[0]['user_id'])
        );

        $info = $this->basic->get_data('users', $where_q, $select = 'user_type, expired_date, package_id', $join = '', $limit = '', $start = '', $order_by = '', $group_by = '', $num_rows = 1);

        $count = $info['extra_index']['num_rows'];
        if ($count == 0) {
            $page_title = $this->lang->line("404 | Domain not recognized");
            $message = $this->lang->line("The domain you were looking for could not be found.");
            include(APPPATH . 'n_views/page/error_cname.php');
//            $this->load->view('page/error_cname', $data);
            exit;
        }

        $expire_date = strtotime($info[0]['expired_date']);
        $current_date = strtotime(date("Y-m-d"));
        if ($expire_date < $current_date and $info[0]['user_type'] == 'MEMBER') {
            $page_title = $this->lang->line("404 | Domain not recognized");
            $message = $this->lang->line("The domain you were looking has user expired.");
            include(APPPATH . 'n_views/page/error_cname.php');
//            $this->load->view('page/error_cname', $data);
            exit;
        }

        $where_q = array(
            "where" => array("id" => $info[0]['package_id'])
        );
        $info_p = $this->basic->get_data('package', $where_q, $select = 'module_ids', $join = '', $limit = '', $start = '', $order_by = '', $group_by = '', $num_rows = 1);

        $count = $info_p['extra_index']['num_rows'];
        if ($count == 0 and $info[0]['user_type'] == 'MEMBER') {
            $page_title = $this->lang->line("404 | Domain not recognized");
            $message = $this->lang->line("The domain you were looking has user no access to use custom domain.");
            include(APPPATH . 'n_views/page/error_cname.php');
//            $this->load->view('page/error_cname', $data);
            exit;
        }

        if (!empty($info_p[0]) and $info[0]['user_type'] == 'MEMBER') {
            $access_q = explode(',', $info_p[0]['module_ids']);

            if (!in_array(3100, $access_q)) {
                $page_title = $this->lang->line("404 | Domain not recognized");
                $message = $this->lang->line("The domain you were looking has user no access to use custom domain.");
                include(APPPATH . 'n_views/page/error_cname.php');
//            $this->load->view('page/error_cname', $data);
                exit;
            }
        }

        return $n_cd_data;
    }

    private function initial_load_store($store_unique_id)
    {
        if ($store_unique_id == 0) exit();
        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
        $where_simple = array("ecommerce_store.store_unique_id" => $store_unique_id, "ecommerce_store.status" => '1');
        $where = array('where' => $where_simple);
        $store_data = $this->basic->get_data("ecommerce_store", $where);

        if(!empty($store_data[0]['user_id'])){
            $user_info = $this->basic->get_data('users', ['where' => ['id' => $store_data[0]['user_id']]]);
            if(!empty($user_info[0])){
                $expired= strtotime($user_info[0]['expired_date']);
                if($expired<time() AND $user_info[0]['user_type'] != 'Admin'){
                    echo 'Store is inactive'; exit;
                }
            }
        }

        if (!isset($store_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Store not found.") . '</h2>';
            exit();
        }

        $this->_language_loader($store_data[0]['store_locale']);
        $store_id = $store_data[0]['id'];
        $user_id = $store_data[0]['user_id'];

        return $store_data;
    }

    private function get_app_id()
    {
        $fb_app_id_info = $this->basic->get_data('facebook_rx_config', $where = array('where' => array('status' => '1')), "api_id");
        $fb_app_id = isset($fb_app_id_info[0]['api_id']) ? $fb_app_id_info[0]['api_id'] : "";
        return $fb_app_id;
    }

    private function get_ecommerce_config($store_id = '0')
    {
        if ($store_id == '0') $store_id = $this->session->userdata("ecommerce_selected_store");
        $data = $this->basic->get_data("ecommerce_config", array("where" => array("store_id" => $store_id)));

        if(!empty($data[0]['user_id'])){
            $user_info = $this->basic->get_data('users', ['where' => ['id' => $data[0]['user_id']]]);
            if(!empty($user_info[0])){
                $expired= strtotime($user_info[0]['expired_date']);
                if($expired<time() AND $user_info[0]['user_type'] != 'Admin'){
                    echo 'Store is inactive'; exit;
                }
            }
        }


        if (isset($data[0])) return $data[0];
        else return array();
    }

    private function get_category_list($store_id = 0, $raw_data = false)
    {
        if ($store_id == 0) $store_id = $this->session->userdata("ecommerce_selected_store");
        $cat_list = $this->basic->get_data("ecommerce_category", array("where" => array("store_id" => $store_id, "status" => "1")), $select = '', $join = '', $limit = '', $start = NULL, $order_by = 'serial asc, category_name asc');
        if ($raw_data) return $cat_list;
        $cat_info = array();
        foreach ($cat_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        return $cat_info;
    }

    private function get_config()
    {
        include(APPPATH . 'n_views/default_ecommerce_builder.php');
        if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $this->nstore_id . '.php')) {
            include(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $this->nstore_id . '.php');
        }
        return $n_eco_builder_config;
    }

    private function get_store_id($store_id)
    {
        if ($store_id == 0) {
            $store_id = $this->nstore_id;
        }
        if ($store_id == 0) {
            exit();
        }
        return $store_id;
    }

    private function get_store_uq($store_id)
    {
        $store_data_temp = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $store_id)), "store_unique_id");
        if (empty($store_data_temp)) {
            return 0;
        }
        return $store_data_temp[0]['store_unique_id'];
    }

    private function get_store_ids($store_id)
    {
        $store_data_temp = $this->basic->get_data("ecommerce_store", array("where" => array("store_unique_id" => $store_id)), "id");
        if (empty($store_data_temp[0])) {
            return 0;
        }
        return $store_data_temp[0]['id'];
    }

    private function get_payment_status()
    {
        return array('pending' => $this->lang->line('Pending'), 'approved' => $this->lang->line('Approved'), 'rejected' => $this->lang->line('Rejected'), 'shipped' => $this->lang->line('Shipped'), 'delivered' => $this->lang->line('Delivered'), 'completed' => $this->lang->line('Completed'));
    }

    public function new_comment()
    {
        $this->ajax_check();
        $parent_product_comment_id = $this->input->post("parent_product_comment_id", true);
        $product_id = $this->input->post("product_id", true);
        $store_id = $this->input->post("store_id", true);
        $new_comment = $this->input->post("new_comment", true);
        $new_comment = strip_tags($new_comment);
        $product_name = strip_tags($this->input->post("product_name", true));
        $need_to_login = false;


        if ($this->session->userdata("logged_in") == '1') {
            $check_admin = $this->basic->count_row("ecommerce_store", array("where" => array("id" => $store_id, "user_id" => $this->user_id)), "id");
            if ($check_admin[0]['total_rows'] == 0) $need_to_login = true;
        } else {
            $where_subs = array();
            $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
            if ($subscriber_id != "") $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $store_id);
            else {
                if ($subscriber_id == "") $subscriber_id = $this->input->post("subscriber_id", true);
                if ($subscriber_id != "") $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
            }
            if ($subscriber_id == "") $need_to_login = true;
            else {
                $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");
                if ($subscriber_info[0]['total_rows'] == 0) $need_to_login = true;
            }
        }

        if ($need_to_login) {
            echo json_encode(array('status' => '0', 'message' => $this->login_to_continue, "login_popup" => '1'));
            exit();
        }

        $store_data = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $store_id)), array("user_id", "store_name", "store_favicon"));
        $store_name = isset($store_data[0]["store_name"]) ? $store_data[0]["store_name"] : "";
        $store_favicon = isset($store_data[0]["store_favicon"]) ? $store_data[0]["store_favicon"] : "";
        $store_admin_user_id = isset($store_data[0]["user_id"]) ? $store_data[0]["user_id"] : "0";

        $datetime = date("Y-m-d H:i:s");
        $subscriber_id = $this->input->post("subscriber_id", true);

        $anouncement_id = 0;
        $direct_link = "";

        $insert_data = array
        (
            "store_id" => $store_id,
            "product_id" => $product_id,
            "subscriber_id" => $subscriber_id,
            "commented_by_user_id" => $this->user_id,
            "comment_text" => $new_comment,
            "parent_product_comment_id" => $parent_product_comment_id,
            "inserted_at" => $datetime,
            "last_updated_at" => $datetime
        );
        $new_comment = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $new_comment); // find and replace links with ancor tag
        if ($parent_product_comment_id == "") unset($insert_data["parent_product_comment_id"]);
        if ($this->user_id != "") unset($insert_data["subscriber_id"]);
        else unset($insert_data["commented_by_user_id"]);
        $html = '';
        if ($this->basic->insert_data("ecommerce_product_comment", $insert_data)) {
            $insert_id = $this->db->insert_id();
            $direct_link = base_url("ecommerce/comment/" . $insert_id);

            if ($this->user_id != "") {
                $commenter = $store_name . " <i class='fas fa-user-circle text-primary'></i>";

                if (!empty($store_favicon)) $image_path = base_url('upload/ecommerce/' . $store_favicon);
                else $image_path = base_url('assets/img/avatar/avatar-1.png');

            } else {
                $subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => array("subscribe_id" => $subscriber_id)), array("first_name", "last_name", "profile_pic", "image_path"));
                $first_name = isset($subscriber_info[0]['first_name']) ? $subscriber_info[0]['first_name'] : "";
                $last_name = isset($subscriber_info[0]['last_name']) ? $subscriber_info[0]['last_name'] : "";
                $profile_pic_src = isset($subscriber_info[0]['profile_pic']) ? $subscriber_info[0]['profile_pic'] : "";
                $image_path_src = isset($subscriber_info[0]['image_path']) ? $subscriber_info[0]['image_path'] : "";
                $commenter = $first_name . " " . $last_name;

                $profile_pic = ($profile_pic_src != "") ? $profile_pic_src : base_url('assets/img/avatar/avatar-1.png');
                $image_path = ($image_path_src != "") ? base_url($image_path_src) : $profile_pic;
            }

            $description = $this->lang->line("Hello") . " " . $store_name . " " . $this->lang->line("admin") . ",<br><br>";
            $description .= "<b>" . $commenter . "</b> " . $this->lang->line("just commented on ecommerce store") . " <b>" . $store_name . "</b> <i>@" . $product_name . "</i><br><br><blockquote>" . $new_comment . "</blockquote>";
            $description .= $this->lang->line("You can reply this comment here") . " : " . $direct_link . "<br><br>" . $this->lang->line("Thanks");

            if ($this->user_id != $store_admin_user_id) {
                $announcement_insert = array
                (
                    'title' => $this->lang->line("New comment on ecommerce store") . " : " . $store_name,
                    'description' => $description,
                    'status' => "published",
                    'created_at' => $datetime,
                    'user_id' => $store_admin_user_id,
                    'color_class' => 'info',
                    'icon' => 'fas fa-shopping-cart'
                );
                $this->basic->insert_data("announcement", $announcement_insert);
                $anouncement_id = $this->db->insert_id();
            }

            $hide_link = "";
            $hide_lang = empty($parent_product_comment_id) ? " " . $this->lang->line("Hide") : "";
            $hide_class = empty($parent_product_comment_id) ? "pr-3" : "";
            if ($this->user_id != '') $hide_link = '<a data-id="' . $insert_id . '" class="d-inline float-right ' . $hide_class . ' hide-comment text-muted" href="#"><i class="fas fa-eye-slash"></i>' . $hide_lang . '</a>';
            $divId = "collapse" . $insert_id;
            if ($subscriber_id != "") $direct_link .= "?subscriber_id=" . $subscriber_id;

            if (empty($parent_product_comment_id)) {
                $html .= '
                <li class="comment" id="comment-' . $insert_id . '">
                <div class="comment-body">
                    <figure class="comment-avatar">
                        <img src="' . $image_path . '" style="border-radius: 50%" alt="Commenter Avatar" width="90" height="90">
                    </figure>
                    <div class="comment-content" style="width: 100%;">
                        <h4 class="comment-author">
                            <a href="' . $direct_link . '">' . $commenter . '</a>
                            <span class="comment-date">' . date("d M,y H:i", strtotime($datetime)) . '</span>
                        </h4>
                        <p>' . nl2br($new_comment) . '</p>
                        <div class="comment-action">
                        
                      <div class="pt-2 pb-4" id="' . $divId . '">
                        <textarea class="form-control comment_reply" name="comment_reply" style="height:50px !important;"></textarea>
                        <button class="btn btn-dark leave_comment no_radius" parent-id="' . $insert_id . '"><i class="w-icon-reports"></i> ' . $this->lang->line("Reply") . '</button>
           
                      </div>
                        </div>
                    </div>
                </div>

            </li>
                ';
            } else {
                $html .= '

                <div class="comment-body">
                    <figure class="comment-avatar">
                        <img src="' . $image_path . '" style="border-radius: 50%" alt="Commenter Avatar" width="90" height="90">
                    </figure>
                    <div class="comment-content" style="width: 100%;">
                        <h4 class="comment-author">
                            <a href="' . $direct_link . '">' . $commenter . '</a>
                            <span class="comment-date">' . date("d M,y H:i", strtotime($datetime)) . '</span>
                        </h4>
                        <p>' . nl2br($new_comment) . '</p>
                        <div class="comment-action">
                        
                      <div class="pt-2 pb-4" id="' . $divId . '">
                        <textarea class="form-control comment_reply" name="comment_reply" style="height:50px !important;"></textarea>
                        <button class="btn btn-dark leave_comment no_radius" parent-id="' . $insert_id . '"><i class="w-icon-reports"></i> ' . $this->lang->line("Reply") . '</button>
           
                      </div>
                        </div>
                    </div>
                </div>';
            }

            echo json_encode(array('status' => '1', 'message' => $html));
        } else echo json_encode(array('status' => '0', 'message' => $this->lang->line("Something went wrong.")));
    }

    public function new_review()
    {
        $this->ajax_check();
        $this->load->helper("ecommerce");
        $insert_id = $this->input->post("insert_id", true);
        $cart_id = $this->input->post("cart_id", true);
        $product_id = $this->input->post("product_id", true);
        $store_id = $this->input->post("store_id", true);
        $reason = strip_tags($this->input->post("reason", true));
        $rating = $this->input->post("rating", true);
        $review = strip_tags($this->input->post("review", true));
        $product_name = strip_tags($this->input->post("product_name", true));
        $need_to_login = false;

        $where_subs = array();
        $subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
        if ($subscriber_id != "") $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $store_id);
        else {
            if ($subscriber_id == "") $subscriber_id = $this->input->post("subscriber_id", true);
            if ($subscriber_id != "") $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
        }
        if ($subscriber_id == "") $need_to_login = true;
        else {
            $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");
            if ($subscriber_info[0]['total_rows'] == 0) $need_to_login = true;
        }


        if ($need_to_login) {
            echo json_encode(array('status' => '0', 'message' => $this->login_to_continue, "login_popup" => '1'));
            exit();
        }


        $join_me = array('ecommerce_cart_item' => "ecommerce_cart_item.cart_id=ecommerce_cart.id,left");
        $has_purchase_array = $this->basic->count_row("ecommerce_cart", array("where" => array("subscriber_id" => $subscriber_id, "product_id" => $product_id), "where_not_in" => array("status" => array("pending", "rejected"))), 'count(cart_id) as total_row', $join_me, 'cart_id');
        if ($has_purchase_array[0]['total_rows'] == 0) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("You have not purchased this item.")));
            exit();
        }


        $datetime = date("Y-m-d H:i:s");
        if ($cart_id == '') $cart_id = 0;

        $insert_data = array
        (
            "store_id" => $store_id,
            "cart_id" => $cart_id,
            "product_id" => $product_id,
            "subscriber_id" => $subscriber_id,
            "reason" => $reason,
            "rating" => $rating,
            "review" => $review,
            "review_reply" => "",
            "replied_by_user_id" => 0,
            "inserted_at" => $datetime
        );

        if ($this->basic->is_exist("ecommerce_product_review", array("product_id" => $product_id, "subscriber_id" => $subscriber_id), 'id'))
            $this->basic->update_data("ecommerce_product_review", array("product_id" => $product_id, "subscriber_id" => $subscriber_id), $insert_data);
        else {
            $this->basic->insert_data("ecommerce_product_review", $insert_data);
            $insert_id = $this->db->insert_id();
        }


        $store_data = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $store_id)), array("user_id", "store_name", "store_favicon"));
        $store_name = isset($store_data[0]["store_name"]) ? $store_data[0]["store_name"] : "";
        $store_favicon = isset($store_data[0]["store_favicon"]) ? $store_data[0]["store_favicon"] : "";
        $store_admin_user_id = isset($store_data[0]["user_id"]) ? $store_data[0]["user_id"] : "0";

        $subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => array("subscribe_id" => $subscriber_id)), array("first_name", "last_name", "profile_pic", "image_path"));
        $first_name = isset($subscriber_info[0]['first_name']) ? $subscriber_info[0]['first_name'] : "";
        $last_name = isset($subscriber_info[0]['last_name']) ? $subscriber_info[0]['last_name'] : "";
        $commenter = $first_name . " " . $last_name;

        $stars = mec_display_rating_starts($rating);

        $direct_link = base_url("ecommerce/review/" . $insert_id);
        $invoice_link = base_url("ecommerce/order/" . $cart_id);

        $description = $this->lang->line("Hello") . " " . $store_name . " " . $this->lang->line("admin") . ",<br><br>";
        $description .= "<b>" . $commenter . "</b> " . $this->lang->line("just posted a review on ecommerce store") . " <b>" . $store_name . "</b> <i>@" . $product_name . "</i><br><br><blockquote>" . $stars . "<b>" . $reason . "</b> : " . $review . "</blockquote>";
        $description .= $this->lang->line("You can reply this review here") . " : " . $direct_link . "<br><br>";
        $description .= $this->lang->line("You can see the invoice here") . " : " . $invoice_link . "<br><br>" . $this->lang->line("Thanks");

        if ($this->user_id != $store_admin_user_id) {
            $announcement_insert = array
            (
                'title' => $this->lang->line("New review on ") . " : " . $product_name,
                'description' => $description,
                'status' => "published",
                'created_at' => $datetime,
                'user_id' => $store_admin_user_id,
                'color_class' => 'dark',
                'icon' => 'fas fa-star orange'
            );
            $this->basic->insert_data("announcement", $announcement_insert);
        }


        echo json_encode(array('status' => '1', 'message' => $this->lang->line("Review has been submitted successfully.")));
    }

    public function review($review_id = 0)
    {
        if ($review_id == 0) exit();
        $this->ecommerce_review_comment_exist = $this->ecommerce_review_comment_exist();
        if (!$this->ecommerce_review_comment_exist) exit();

        $where_simple = array("ecommerce_product_review.id" => $review_id, "ecommerce_product_review.hidden" => "0", "ecommerce_product.deleted" => "0");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_product' => "ecommerce_product.id=ecommerce_product_review.product_id,left", 'ecommerce_store' => "ecommerce_product_review.store_id=ecommerce_store.id,left", 'messenger_bot_subscriber' => "messenger_bot_subscriber.subscribe_id=ecommerce_product_review.subscriber_id,left");
        $select = array("ecommerce_product_review.*", "product_name", "ecommerce_product.user_id", "store_name", "store_unique_id", "store_logo", "store_favicon", "terms_use_link", "refund_policy_link", "store_locale", "is_rtl", "pixel_id", "google_id", "first_name", "last_name", "profile_pic", "image_path");
        $product_data = $this->basic->get_data("ecommerce_product_review", $where, $select, $join);

        if (!isset($product_data[0])) {
            echo '<br/><h2 style="border:1px solid red;padding:15px;color:red">' . $this->lang->line("Review not found.") . '</h2>';
            exit();
        }
        $this->_language_loader($product_data[0]['store_locale']);

        $subscriber_id = $this->session->userdata($product_data[0]['store_id'] . "ecom_session_subscriber_id");
        if ($subscriber_id == "") $subscriber_id = $this->input->get("subscriber_id", true);

        $user_id = isset($product_data[0]["user_id"]) ? $product_data[0]["user_id"] : 0;
        $fb_app_id = $this->get_app_id();
        $page_title = $product_data[0]['store_name'] . " | " . $product_data[0]['product_name'] . " | " . $this->lang->line("Review") . "#" . $review_id;
        $data = array('body' => "ecommerce/review_single", "page_title" => $page_title, "fb_app_id" => $fb_app_id, "favicon" => base_url('upload/ecommerce/' . $product_data[0]['store_favicon']));

        $category_list = $this->get_category_list($product_data[0]['store_id'], true);
        $cat_info = array();
        foreach ($category_list as $value) {
            $cat_info[$value['id']] = $value['category_name'];
        }
        $data["category_list"] = $cat_info;
        $data["category_list_raw"] = $category_list;

        $data["review_data"] = $product_data;
        $data['current_cart'] = $this->get_current_cart($subscriber_id, $product_data[0]['store_id']);
        $data["social_analytics_codes"] = $product_data[0];
        $data['current_product_id'] = isset($product_data[0]['product_id']) ? $product_data[0]['product_id'] : 0;
        $data['current_store_id'] = isset($product_data[0]['store_id']) ? $product_data[0]['store_id'] : 0;
        $data['review_id'] = $review_id;
        $data['ecommerce_config'] = $this->get_ecommerce_config($product_data[0]["store_id"]);
        $data['is_rtl'] = (isset($product_data[0]['is_rtl']) && $product_data[0]['is_rtl'] == '1') ? true : false;
        $this->load->view('ecommerce/bare-theme', $data);
    }

    public function _language_loader($default_lang = '')
    {

        if (!empty($this->session->userdata("selected_language")) and file_exists(APPPATH . 'language/' . $this->session->userdata("selected_language") . '/v_5_0_a_lang.php')) {
            $default_lang = $this->session->userdata("selected_language");
        }

        HOME::_language_loader($default_lang);

    }

    private function proceed_checkout_get_select(){
        $select = array("store_name", "store_id", "store_unique_id", "store_favicon", "store_locale", "paypal_enabled", "stripe_enabled", "razorpay_enabled", "paystack_enabled", "mollie_enabled", "mercadopago_enabled", "sslcommerz_enabled", "toyyibpay_enabled", "myfatoorah_enabled", "paymaya_enabled", "manual_enabled", "senangpay_enabled", "instamojo_enabled", "xendit_enabled", "cod_enabled", "ecommerce_cart.user_id as user_id", "payment_amount", "label_ids");


        if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php')) {
            $select[] = 'n_omise_enabled';
        }

        if (file_exists(APPPATH . 'modules/n_payu_latam/controllers/N_payu_latam.php')) {
            $select[] = 'n_payu_latam_sandbox';
            $select[] = 'n_payu_latam_enabled';
        }

        if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php')) {
            $select[] = 'n_paymongo_enabled';
            $select[] = 'n_paymongo_paymaya_en';
            $select[] = 'n_paymongo_grab_en';
            $select[] = 'n_paymongo_gcash_en';
        }

        if (file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php')) {
            $select[] = 'n_paymentwall_enabled';
        }

        if (file_exists(APPPATH . 'modules/n_coinbase/controllers/N_coinbase.php')) {
            $select[] = 'n_coinbase_enabled';
        }

        if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php')) {
            $select[] = 'n_moamalat_enabled';
            $select[] = 'n_moamalat_testmode';
        }

        if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php')) {
            $select[] = 'n_tdsp_enabled';
            $select[] = 'n_tdsp_sandbox';
        }

        if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')) {
            $select[] = 'n_stripe_enabled';
        }

        if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
            $select[] = 'n_sadad_enabled';
            $select[] = 'n_sadad_testmode';
        }

        if (file_exists(APPPATH . 'modules/n_tap/controllers/N_tap.php')) {
            $select[] = 'n_tap_on';
        }

        if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php')) {
            $select[] = 'n_epayco_enabled';
            $select[] = 'n_epayco_testmode';
            $select[] = 'n_epayco_checkout';
        }

        if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php')) {
            $select[] = 'n_sellix_enabled';
        }

        if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php')) {
            $select[] = 'n_chapa_enabled';
        }

        if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php')) {
            $select[] = 'n_zaincash_enabled';
            $select[] = 'n_zaincash_testmode_enabled';
        }


         return $select;
    }

    public function proceed_checkout_n($subscriber_id, $for_checkout = 0, $mydata = array())
    {
        //ini_set('xdebug.max_nesting_level', 10000);

        if($for_checkout==0){
            $this->ajax_check();
            $mydata = json_decode($this->input->post("mydata"), true);
        }else{

        }

        $tmp_store_id = isset($mydata['store_id']) ? $mydata['store_id'] : '0';

        $cart_id = isset($mydata["cart_id"]) ? $mydata["cart_id"] : 0;

        $where_subs = array();
        if(empty($this->session->userdata($tmp_store_id."ecom_session_subscriber_id"))){$subscriber_id=$this->session->userdata($tmp_store_id."ecom_session_subscriber_id");}

        $login_needed = false;

        if($subscriber_id!="") $where_subs = array("subscriber_type"=>"system","subscribe_id"=>$subscriber_id,"store_id"=>$tmp_store_id);
        else
        {
            if($subscriber_id=="") $subscriber_id = $this->input->get("subscriber_id",true);
            if($subscriber_id!="") $where_subs = array("subscriber_type!="=>"system","subscribe_id"=>$subscriber_id);
        }
        if($subscriber_id=='') $login_needed = true;
        else
        {
            $subscriber_info = $this->basic->count_row("messenger_bot_subscriber",array("where"=>$where_subs),"id");
            if($subscriber_info[0]['total_rows']==0) $login_needed = true;
        }

        if ($login_needed == true) {
            redirect($this->return_base_url_php('ecommerce/login_signup/' . $this->nstore_id), 'location');
            exit();
        }


        $subscriber_info = $this->basic->count_row("messenger_bot_subscriber", array("where" => $where_subs), "id");
        if ($subscriber_info[0]['total_rows'] == 0) {
            echo json_encode(array('status' => '0', 'message' => $this->login_to_continue, 'login_popup' => '1'));
            exit();
        }

       $select = $this->proceed_checkout_get_select();

        $cart_data = $this->valid_cart_data($cart_id, $subscriber_id, $select);

        if (!isset($cart_data[0]) || (isset($cart_data[0]) && $cart_data[0]["store_id"] == "")) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Order data not found.')));
            exit();
        }
        $this->_language_loader($cart_data[0]['store_locale']);

        $subscriber_first_name = isset($mydata['subscriber_first_name']) ? $mydata['subscriber_first_name'] : '';
        $subscriber_last_name = isset($mydata['subscriber_last_name']) ? $mydata['subscriber_last_name'] : '';
        $subscriber_country = isset($mydata['subscriber_country']) ? $mydata['subscriber_country'] : '';
        $delivery_address_id = isset($mydata['delivery_address_id']) ? $mydata['delivery_address_id'] : '';
        $store_pickup = isset($mydata['store_pickup']) ? $mydata['store_pickup'] : '0';
        $pickup_point_details = isset($mydata['pickup_point_details']) ? strip_tags($mydata['pickup_point_details']) : '';
        $delivery_note = isset($mydata['delivery_note']) ? $this->security->xss_clean(strip_tags($mydata['delivery_note'])) : '';
        $delivery_time = isset($mydata['delivery_time']) ? $this->security->xss_clean(strip_tags($mydata['delivery_time'])) : '';

        $store_id = $cart_data[0]["store_id"];
        $user_id = $cart_data[0]["user_id"];
        $payment_amount = $cart_data[0]["payment_amount"];
        $store_name = $cart_data[0]["store_name"];
        $paypal_enabled = $cart_data[0]["paypal_enabled"];
        $stripe_enabled = $cart_data[0]["stripe_enabled"];
        $toyyibpay_enabled = $cart_data[0]["toyyibpay_enabled"];
        $paymaya_enabled = $cart_data[0]["paymaya_enabled"];
        $myfatoorah_enabled = $cart_data[0]["myfatoorah_enabled"];
        $manual_enabled = $cart_data[0]["manual_enabled"];
        $cod_enabled = $cart_data[0]["cod_enabled"];
        $razorpay_enabled = $cart_data[0]["razorpay_enabled"];
        $paystack_enabled = $cart_data[0]["paystack_enabled"];
        $mollie_enabled = $cart_data[0]["mollie_enabled"];
        $mercadopago_enabled = $cart_data[0]["mercadopago_enabled"];
        $sslcommerz_enabled = $cart_data[0]["sslcommerz_enabled"];
        $senangpay_enabled = $cart_data[0]["senangpay_enabled"];
        $n_omise_enabled = isset($cart_data[0]["n_omise_enabled"]) ? $cart_data[0]["n_omise_enabled"] : 0;
        $n_paymongo_enabled = isset($cart_data[0]["n_paymongo_enabled"]) ? $cart_data[0]["n_paymongo_enabled"] : 0;
        $n_paymongo_paymaya_en = isset($cart_data[0]["n_paymongo_paymaya_en"]) ? $cart_data[0]["n_paymongo_paymaya_en"] : 0;
        $n_paymongo_grab_en = isset($cart_data[0]["n_paymongo_grab_en"]) ? $cart_data[0]["n_paymongo_grab_en"] : 0;
        $n_paymongo_gcash_en = isset($cart_data[0]["n_paymongo_gcash_en"]) ? $cart_data[0]["n_paymongo_gcash_en"] : 0;
        $n_paymentwall_enabled = isset($cart_data[0]["n_paymentwall_enabled"]) ? $cart_data[0]["n_paymentwall_enabled"] : 0;

        $n_payu_latam_enabled = isset($cart_data[0]["n_payu_latam_enabled"]) ? $cart_data[0]["n_payu_latam_enabled"] : 0;
        $n_payu_latam_sandbox = isset($cart_data[0]["n_payu_latam_sandbox"]) ? $cart_data[0]["n_payu_latam_sandbox"] : 0;

        $n_coinbase_enabled = isset($cart_data[0]["n_coinbase_enabled"]) ? $cart_data[0]["n_coinbase_enabled"] : 0;

        $n_moamalat_enabled = isset($cart_data[0]["n_moamalat_enabled"]) ? $cart_data[0]["n_moamalat_enabled"] : 0;
        $n_moamalat_testmode = isset($cart_data[0]["n_moamalat_testmode"]) ? $cart_data[0]["n_moamalat_testmode"] : 0;

        $n_sadad_enabled = isset($cart_data[0]["n_sadad_enabled"]) ? $cart_data[0]["n_sadad_enabled"] : 0;
        $n_sadad_testmode = isset($cart_data[0]["n_sadad_testmode"]) ? $cart_data[0]["n_sadad_testmode"] : 0;

        $n_tap_on = isset($cart_data[0]["n_tap_on"]) ? $cart_data[0]["n_tap_on"] : 0;

        $n_epayco_enabled = isset($cart_data[0]["n_epayco_enabled"]) ? $cart_data[0]["n_epayco_enabled"] : 0;
        $n_epayco_testmode = isset($cart_data[0]["n_epayco_testmode"]) ? $cart_data[0]["n_epayco_testmode"] : 0;
        $n_epayco_checkout = isset($cart_data[0]["n_epayco_checkout"]) ? $cart_data[0]["n_epayco_checkout"] : 0;

        $n_tdsp_sandbox = isset($cart_data[0]["n_tdsp_sandbox"]) ? $cart_data[0]["n_tdsp_sandbox"] : 0;
        $n_tdsp_enabled = isset($cart_data[0]["n_tdsp_enabled"]) ? $cart_data[0]["n_tdsp_enabled"] : 0;

        $n_stripe_enabled = isset($cart_data[0]["n_stripe_enabled"]) ? $cart_data[0]["n_stripe_enabled"] : 0;

        $n_sellix_enabled = isset($cart_data[0]["n_sellix_enabled"]) ? $cart_data[0]["n_sellix_enabled"] : 0;

        $n_chapa_enabled = isset($cart_data[0]["n_chapa_enabled"]) ? $cart_data[0]["n_chapa_enabled"] : 0;

        $n_zaincash_enabled = isset($cart_data[0]["n_zaincash_enabled"]) ? $cart_data[0]["n_zaincash_enabled"] : 0;
        $n_zaincash_testmode_enabled = isset($cart_data[0]["n_zaincash_testmode_enabled"]) ? $cart_data[0]["n_zaincash_testmode_enabled"] : 0;

        $instamojo_enabled = $cart_data[0]["instamojo_enabled"];
        $xendit_enabled = $cart_data[0]["xendit_enabled"];
        $store_favicon = $cart_data[0]["store_favicon"];
        if ($store_favicon != "") $store_favicon = base_url("upload/ecommerce/" . $store_favicon);

        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $paypal_email = isset($ecommerce_config['paypal_email']) ? $ecommerce_config['paypal_email'] : '';
        $paypal_mode = isset($ecommerce_config['paypal_mode']) ? $ecommerce_config['paypal_mode'] : 'live';
        $stripe_secret_key = isset($ecommerce_config['stripe_secret_key']) ? $ecommerce_config['stripe_secret_key'] : '';
        $stripe_publishable_key = isset($ecommerce_config['stripe_publishable_key']) ? $ecommerce_config['stripe_publishable_key'] : '';
        $stripe_billing_address = isset($ecommerce_config['stripe_billing_address']) ? $ecommerce_config['stripe_billing_address'] : '0';
        $razorpay_key_id = isset($ecommerce_config['razorpay_key_id']) ? $ecommerce_config['razorpay_key_id'] : '';
        $razorpay_key_secret = isset($ecommerce_config['razorpay_key_secret']) ? $ecommerce_config['razorpay_key_secret'] : '';
        $paystack_secret_key = isset($ecommerce_config['paystack_secret_key']) ? $ecommerce_config['paystack_secret_key'] : '';
        $paystack_public_key = isset($ecommerce_config['paystack_public_key']) ? $ecommerce_config['paystack_public_key'] : '';
        $mollie_api_key = isset($ecommerce_config['mollie_api_key']) ? $ecommerce_config['mollie_api_key'] : '';
        $mercadopago_public_key = isset($ecommerce_config['mercadopago_public_key']) ? $ecommerce_config['mercadopago_public_key'] : '';
        $mercadopago_access_token = isset($ecommerce_config['mercadopago_access_token']) ? $ecommerce_config['mercadopago_access_token'] : '';
        $sslcommerz_store_id = isset($ecommerce_config['sslcommerz_store_id']) ? $ecommerce_config['sslcommerz_store_id'] : '';
        $sslcommerz_store_password = isset($ecommerce_config['sslcommerz_store_password']) ? $ecommerce_config['sslcommerz_store_password'] : '';
        $marcadopago_country = isset($ecommerce_config['marcadopago_country']) ? $ecommerce_config['marcadopago_country'] : '';
        $senangpay_merchent_id = isset($ecommerce_config['senangpay_merchent_id']) ? $ecommerce_config['senangpay_merchent_id'] : '';
        $senangpay_secret_key = isset($ecommerce_config['senangpay_secret_key']) ? $ecommerce_config['senangpay_secret_key'] : '';
        $senangpay_mode = isset($ecommerce_config['senangpay_mode']) ? $ecommerce_config['senangpay_mode'] : 'live';
        $instamojo_api_key = isset($ecommerce_config['instamojo_api_key']) ? $ecommerce_config['instamojo_api_key'] : '';
        $instamojo_auth_token = isset($ecommerce_config['instamojo_auth_token']) ? $ecommerce_config['instamojo_auth_token'] : '';
        $instamojo_mode = isset($ecommerce_config['instamojo_mode']) ? $ecommerce_config['instamojo_mode'] : 'live';
        $myfatoorah_api_key = isset($ecommerce_config['myfatoorah_api_key']) ? $ecommerce_config['myfatoorah_api_key'] : '';
        $myfatoorah_mode = isset($ecommerce_config['myfatoorah_mode']) ? $ecommerce_config['myfatoorah_mode'] : 'live';
        $toyyibpay_secret_key = isset($ecommerce_config['toyyibpay_secret_key']) ? $ecommerce_config['toyyibpay_secret_key'] : '';
        $toyyibpay_category_code = isset($ecommerce_config['toyyibpay_category_code']) ? $ecommerce_config['toyyibpay_category_code'] : '';
        $toyyibpay_mode = isset($ecommerce_config['toyyibpay_mode']) ? $ecommerce_config['toyyibpay_mode'] : 'live';

        $paymaya_public_key = isset($ecommerce_config['paymaya_public_key']) ? $ecommerce_config['paymaya_public_key'] : '';
        $paymaya_secret_key = isset($ecommerce_config['paymaya_secret_key']) ? $ecommerce_config['paymaya_secret_key'] : '';
        $paymaya_mode = isset($ecommerce_config['paymaya_mode']) ? $ecommerce_config['paymaya_mode'] : 'live';
        $xendit_secret_api_key = isset($ecommerce_config['xendit_secret_api_key']) ? $ecommerce_config['xendit_secret_api_key'] : '';
        $manual_payment_instruction = isset($ecommerce_config['manual_payment_instruction']) ? $ecommerce_config['manual_payment_instruction'] : '';
        $currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : 'USD';
        $is_order_schedule = isset($ecommerce_config['is_order_schedule']) ? $ecommerce_config['is_order_schedule'] : '0';

        $n_omise_pubkey = isset($ecommerce_config['n_omise_pubkey']) ? $ecommerce_config['n_omise_pubkey'] : '';
        $n_omise_seckey = isset($ecommerce_config['n_omise_seckey']) ? $ecommerce_config['n_omise_seckey'] : '';

        $n_paymongo_pub = isset($ecommerce_config['n_paymongo_pub']) ? $ecommerce_config['n_paymongo_pub'] : '';
        $n_paymongo_sec = isset($ecommerce_config['n_paymongo_sec']) ? $ecommerce_config['n_paymongo_sec'] : '';

        $n_paymentwall_pub = isset($ecommerce_config['n_paymentwall_pub']) ? $ecommerce_config['n_paymentwall_pub'] : '';
        $n_paymentwall_sec = isset($ecommerce_config['n_paymentwall_sec']) ? $ecommerce_config['n_paymentwall_sec'] : '';

        $n_payu_latam_merchantid = isset($ecommerce_config['n_payu_latam_merchantid']) ? $ecommerce_config['n_payu_latam_merchantid'] : '';
        $n_payu_latam_accountid = isset($ecommerce_config['n_payu_latam_accountid']) ? $ecommerce_config['n_payu_latam_accountid'] : '';
        $n_payu_latam_api_key = isset($ecommerce_config['n_payu_latam_api_key']) ? $ecommerce_config['n_payu_latam_api_key'] : '';

        $n_coinbase_shared_secret = isset($ecommerce_config['n_coinbase_shared_secret']) ? $ecommerce_config['n_coinbase_shared_secret'] : '';
        $n_coinbase_api_key = isset($ecommerce_config['n_coinbase_api_key']) ? $ecommerce_config['n_coinbase_api_key'] : '';

        $n_moamalat_merchant_id = isset($ecommerce_config['n_moamalat_merchant_id']) ? $ecommerce_config['n_moamalat_merchant_id'] : '';
        $n_moamalat_terminal_id = isset($ecommerce_config['n_moamalat_terminal_id']) ? $ecommerce_config['n_moamalat_terminal_id'] : '';
        $n_moamalat_secret_key = isset($ecommerce_config['n_moamalat_secret_key']) ? $ecommerce_config['n_moamalat_secret_key'] : '';

        $n_sadad_secret_key = isset($ecommerce_config['n_sadad_secret_key']) ? $ecommerce_config['n_sadad_secret_key'] : '';

        $n_tap_secret = isset($ecommerce_config['n_tap_secret']) ? $ecommerce_config['n_tap_secret'] : '';

        $n_epayco_pkey = isset($ecommerce_config['n_epayco_pkey']) ? $ecommerce_config['n_epayco_pkey'] : '';

        $n_tdsp_auth_key = isset($ecommerce_config['n_tdsp_auth_key']) ? $ecommerce_config['n_tdsp_auth_key'] : '';
        $n_tdsp_store_id = isset($ecommerce_config['n_tdsp_store_id']) ? $ecommerce_config['n_tdsp_store_id'] : '';

        $n_paymongo_pub = isset($ecommerce_config['n_sellix_api_key']) ? $ecommerce_config['n_sellix_api_key'] : '';
        $n_paymongo_sec = isset($ecommerce_config['n_sellix_webhook_secret']) ? $ecommerce_config['n_sellix_webhook_secret'] : '';
        $n_paymongo_sec = isset($ecommerce_config['n_sellix_merchant']) ? $ecommerce_config['n_sellix_merchant'] : '';

        $n_chapa_secret_key = isset($ecommerce_config['n_chapa_secret_key']) ? $ecommerce_config['n_chapa_secret_key'] : '';

        if ($is_order_schedule == '1') {
            $check_delivery_time = $delivery_time;
            if ($check_delivery_time == "") $check_delivery_time = date("Y-m-d H:i:s");
            $check_date = date('Y-m-d', strtotime($check_delivery_time));
            $check_day = date('l', strtotime($check_delivery_time));
            $check_time = date('H:i:s', strtotime($check_delivery_time));
            $ecommerce_store_business_hours = array();
            if (!empty($check_day))
                $ecommerce_store_business_hours = $this->basic->get_data("ecommerce_store_business_hours", array("where" => array("store_id" => $store_id, "schedule_day" => $check_day)));
            if (isset($ecommerce_store_business_hours[0])) {
                if ($ecommerce_store_business_hours[0]['off_day'] == '1') {
                    echo json_encode(array('status' => '2', 'message' => $this->lang->line('Sorry, but we cannot take the order. We are closed on') . " " . $this->lang->line($check_day) . '!'));
                    exit();
                } else {
                    $start_time = $check_date . " " . $ecommerce_store_business_hours[0]['start_time'] . ":00";
                    $end_time = $check_date . " " . $ecommerce_store_business_hours[0]['end_time'] . ":00";

                    $time_ok = false;
                    if (strtotime($check_delivery_time) >= strtotime($start_time) && strtotime($check_delivery_time) <= strtotime($end_time))
                        $time_ok = true;

                    if (!$time_ok) {
                        if ($delivery_time == '') echo json_encode(array('status' => '2', 'message' => $this->lang->line('Sorry, but we cannot take the order. We are closed now.')));
                        else echo json_encode(array('status' => '2', 'message' => $this->lang->line('Sorry, but we cannot take the order. We will be closed at the selected time. Please try selecting a new delivery time.')));
                        exit();
                    }

                }
            }
        }

        $buyer_first_name = $bill_first_name = $subscriber_first_name;
        $buyer_last_name = $bill_last_name = $subscriber_last_name;
        $buyer_country = $bill_country = $subscriber_country;
        $buyer_email = $buyer_mobile = $buyer_address = $buyer_state = $buyer_city = $buyer_zip = "";
        $bill_email = $bill_mobile = $bill_city = $bill_state = $bill_address = $bill_zip = "";


        $billing_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "profile_address" => "1")));
        if (isset($billing_data[0])) {
            $bill_first_name = $billing_data[0]['first_name'];
            $bill_last_name = $billing_data[0]['last_name'];
            $bill_country = $billing_data[0]['country'];
            $bill_email = $billing_data[0]['email'];
            $bill_mobile = $billing_data[0]['mobile'];
            $bill_city = $billing_data[0]['city'];
            $bill_state = $billing_data[0]['state'];
            $bill_address = $billing_data[0]['address'];
            $bill_zip = $billing_data[0]['zip'];
        }
        if (!empty($delivery_address_id) && $store_pickup == '0') {
            $delivery_data = $this->basic->get_data("ecommerce_cart_address_saved", array("where" => array("subscriber_id" => $subscriber_id, "id" => $delivery_address_id)));
            if (isset($delivery_data[0])) {
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id), array("is_default" => '0'));
                $this->basic->update_data("ecommerce_cart_address_saved", array("subscriber_id" => $subscriber_id, "id" => $delivery_address_id), array("is_default" => '1'));
                $buyer_first_name = $delivery_data[0]['first_name'];
                $buyer_last_name = $delivery_data[0]['last_name'];
                $buyer_country = $delivery_data[0]['country'];
                $buyer_email = $delivery_data[0]['email'];
                $buyer_mobile = $delivery_data[0]['mobile'];
                $buyer_city = $delivery_data[0]['city'];
                $buyer_state = $delivery_data[0]['state'];
                $buyer_address = $delivery_data[0]['address'];
                $buyer_zip = $delivery_data[0]['zip'];
            }
        } else $buyer_first_name = $buyer_last_name = $buyer_country = "";

        if ($n_omise_enabled == '1' && ($n_omise_pubkey == '' || $n_omise_seckey == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Omise payment settings not found.')));
            exit();
        }

        if ($n_coinbase_enabled == '1' && ($n_coinbase_api_key == '' || $n_coinbase_shared_secret == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Coinbase payment settings not found.')));
            exit();
        }

        if ($n_paymongo_enabled == '1' && ($n_paymongo_pub == '' || $n_paymongo_sec == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Paymongo payment settings not found.')));
            exit();
        }

        if ($n_paymentwall_enabled == '1' && ($n_paymentwall_pub == '' || $n_paymentwall_sec == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Paymentwall payment settings not found.')));
            exit();
        }

        if ($n_payu_latam_enabled == '1' && ($n_payu_latam_merchantid == '' || $n_payu_latam_accountid == '' || $n_payu_latam_api_key == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('PayU LATAM payment settings not found.')));
            exit();
        }

        if ($paypal_enabled == '1' && $paypal_email == '') {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('PayPal payment settings not found.')));
            exit();
        }

        if ($stripe_enabled == '1' && ($stripe_secret_key == '' || $stripe_publishable_key == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Stripe payment settings not found.')));
            exit();
        }
        if ($razorpay_enabled == '1' && ($razorpay_key_id == '' || $razorpay_key_secret == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Razorpay payment settings not found.')));
            exit();
        }
        if ($paystack_enabled == '1' && ($paystack_secret_key == '' || $paystack_public_key == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Paystack payment settings not found.')));
            exit();
        }
        if ($mollie_enabled == '1' && $mollie_api_key == '') {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Mollie payment settings not found.')));
            exit();
        }
        if ($mercadopago_enabled == '1' && ($mercadopago_public_key == '' || $mercadopago_access_token == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Mercado Pago payment settings not found.')));
            exit();
        }
        if ($sslcommerz_enabled == '1' && ($sslcommerz_store_id == '' || $sslcommerz_store_password == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Sslcommerz payment settings not found.')));
            exit();
        }
        if ($senangpay_enabled == '1' && ($senangpay_merchent_id == '' || $senangpay_secret_key == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Senangpay payment settings not found.')));
            exit();
        }
        if ($instamojo_enabled == '1' && ($instamojo_api_key == '' || $instamojo_auth_token == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Instamojo payment settings not found.')));
            exit();
        }
        if ($toyyibpay_enabled == '1' && ($toyyibpay_secret_key == '' || $toyyibpay_category_code == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Toyyibpay payment settings not found.')));
            exit();
        }

        if ($paymaya_enabled == '1' && ($paymaya_secret_key == '' || $paymaya_public_key == '')) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Paymaya payment settings not found.')));
            exit();
        }

        if ($myfatoorah_enabled == '1' && $myfatoorah_api_key == '') {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Myfatoorah payment settings not found.')));
            exit();
        }

        if ($xendit_enabled == '1' && $xendit_secret_api_key == '') {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Xendit payment settings not found.')));
            exit();
        }
        if ($manual_enabled == '1' && $manual_payment_instruction == '') {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Manual payment settings not found.')));
            exit();
        }

        $get_store_labels = $cart_data[0]['label_ids'] ?? "";
        if (!empty($get_store_labels)) {
            if (strpos("sys-", $subscriber_id) === FALSE) {

                $assign_label_ids = explode(",", $get_store_labels);

                foreach ($assign_label_ids as $label) {

                    if (!$this->basic->is_exist("messenger_bot_subscribers_label", array('contact_group_id' => $label, "subscriber_table_id" => $mydata['subscriber_auto_id']))) {
                        $this->basic->insert_data("messenger_bot_subscribers_label", ['contact_group_id' => $label, "subscriber_table_id" => $mydata['subscriber_auto_id']]);
                    }
                }
            }
        }

        $curtime = date("Y-m-d H:i:s");
        $update_data = array
        (
            "store_pickup" => $store_pickup,
            "buyer_first_name" => $buyer_first_name,
            "buyer_last_name" => $buyer_last_name,
            "buyer_email" => $buyer_email,
            "buyer_mobile" => $buyer_mobile,
            "buyer_country" => $buyer_country,
            "buyer_state" => $buyer_state,
            "buyer_city" => $buyer_city,
            "buyer_address" => $buyer_address,
            "buyer_zip" => $buyer_zip,
            "updated_at" => $curtime,
            "buyer_zip" => $buyer_zip,
            "bill_first_name" => $bill_first_name,
            "bill_last_name" => $bill_last_name,
            "bill_country" => $bill_country,
            "bill_email" => $bill_email,
            "bill_mobile" => $bill_mobile,
            "bill_city" => $bill_city,
            "bill_state" => $bill_state,
            "bill_address" => $bill_address,
            "bill_zip" => $bill_zip,
            "pickup_point_details" => $pickup_point_details,
            "delivery_note" => $delivery_note,
            "delivery_time" => $delivery_time,
            "n_wh" => 0
        );

        $this->basic->update_data("ecommerce_cart", array("id" => $cart_id, "subscriber_id" => $subscriber_id, "action_type !=" => "checkout"), $update_data);

        $customer_mobile = $bill_mobile != '' ? $bill_mobile : $buyer_mobile;
        $customer_email = $bill_email != '' ? $bill_email : $buyer_email;
        $customer_first_name = $bill_first_name != '' ? $bill_first_name : $buyer_first_name;
        $customer_last_name = $bill_last_name != '' ? $bill_last_name : $buyer_last_name;
        $customer_name = $customer_first_name . " " . $customer_last_name;
        $only_domain = get_domain_only(base_url());
        $fake_email = "ecommerce@" . $only_domain;

        $paypal_button = $stripe_button = $razorpay_button = $paystack_button = $mollie_button = $manual_button = $mercadopago_button = $sslcommerz_button = $senangpay_button = $instamojo_button = $xendit_button = $cod_button = $toyyibpay_button = $myfatoorah_button = $paymaya_button = "";
        $product_name = $store_name . " : " . $this->lang->line("Order") . " #" . $cart_id;

        $new_checkout = array();


        if ($paypal_enabled == "1") {
            $new_checkout['paypal'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'paypal_clone',
                'id' => 'new_paypal',
                'title' => $this->lang->line("Pay with PayPal"),
                'description' => '',
                'href' => '',
                'url_get_button' => base_url(return_ecommerce_base_url("ajax_get_payment_button/paypal/".$cart_id.'/'.$store_id)),
                'url_get_button_action' => 'submit',
            );
        }

        if ($stripe_enabled == "1") {
            $new_checkout['stripe'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'stripePaymentForm01 .stripe-button-el',
                'title' => $this->lang->line("Pay with Stripe"),
                'id' => 'new_stripe',
                'description' => '',
                'href' => '',
                'url_get_button' => base_url(return_ecommerce_base_url("ajax_get_payment_button/stripe/".$cart_id.'/'.$store_id)),

            );
        }

        if ($razorpay_enabled == "1") {
            $new_checkout['razorpay'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'rzp-button1',
                'id' => 'new_razorpay',
                'title' => $this->lang->line("Pay with RazorPay"),
                'description' => '',
                'href' => '',
                'url_get_button' => base_url(return_ecommerce_base_url("ajax_get_payment_button/razorpay/".$cart_id.'/'.$store_id)),
            );
        }

        if ($paystack_enabled == "1") {
            $new_checkout['paystack'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'paystack_clone',
                'title' => $this->lang->line("Pay with Paystack"),
                'id' => 'new_paystack',
                'description' => '',
                'href' => '',
                'url_get_button' => base_url(return_ecommerce_base_url("ajax_get_payment_button/paystack/".$cart_id.'/'.$store_id)),
            );
        }

        if ($mollie_enabled == "1") {
            $new_checkout['mollie'] = array(
                'hidden_code' => $mollie_button,
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'mollie-payment-button',
                'title' => $this->lang->line("Pay with Mollie Payment"),
                'id' => 'new_mollie',
                'description' => '',
                'href' => '',
                'url_get_button' => base_url(return_ecommerce_base_url("ajax_get_payment_button/mollie/".$cart_id.'/'.$store_id)),
            );
        }

        if ($mercadopago_enabled == '1') {
            $mercadopago_button = '
  <div class="col-12 col-md-6 text-center">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" onclick="document.querySelector(\'.mercadopago-button\').click();">
  <div class="d-flex w-100 align-items-center">
  <small class="text-muted"><img class="rounded" width="60" height="60" src="' . base_url("assets/img/payment/mercadopago.png") . '"></small>
  <h6 class="mb-1">' . $this->lang->line("Pay with Mercado Pago") . '</h6>
  </div>
  </a>
  </div>';

            $new_checkout['mercadopago'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => 'mercadopago-button',
                'action_id' => '',
                'id' => 'new_mercadopago',
                'title' => $this->lang->line("Pay with Mercado Pago"),
                'description' => '',
                'href' => '',
            );
        }

        if ($sslcommerz_enabled == '1') {
            $sslcommerz_button = '
  <div class="col-12 col-md-6 text-center">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" onclick="document.getElementById(\'sslczPayBtn\').click();">
  <div class="d-flex w-100 align-items-center">
  <small class="text-muted"><img class="rounded" width="60" height="60" src="' . base_url("assets/img/payment/sslcommerz.png") . '"></small>
  <h6 class="mb-1">' . $this->lang->line("Pay With SSLCOMMERZ") . '</h6>
  </div>
  </a>
  </div>';

            $new_checkout['sslczpay'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'sslczPayBtn',
                'id' => 'new_sslczpay',
                'title' => $this->lang->line("Pay with SSLCOMMERZ"),
                'description' => '',
                'href' => '',
            );
        }

        if ($senangpay_enabled == '1') {
            $new_checkout['senangpay'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'senangpay_btn a',
                'id' => 'new_senangpay',
                'title' => $this->lang->line("Pay with Senangpay"),
                'description' => '',
                'href' => '',
                'url_get_button' => base_url(return_ecommerce_base_url("ajax_get_payment_button/senangpay/".$cart_id.'/'.$store_id)),
            );
        }

        if ($instamojo_enabled == '1') {
            $redirect_url_instamojo = base_url(return_ecommerce_base_url('instamojo_action/')) . $cart_id;
            $this->load->library('instamojo');
            $this->instamojo->redirect_url = $redirect_url_instamojo;
            $this->instamojo->button_lang = $this->lang->line('Pay with Instamojo');
            $instamojo_button = $this->instamojo->set_button();
            $instamojo_button = '<div class="col-12 col-md-6">' . $instamojo_button . '</div>';

            $new_checkout['instamojo'] = array(
                'hidden_code' => '',
                'action' => 'redirect',
                'action_class' => '',
                'action_id' => '',
                'id' => 'new_instamojo',
                'title' => $this->lang->line("Pay with Instamojo"),
                'description' => '',
                'href' => $redirect_url_instamojo,
            );
        }

        if ($toyyibpay_enabled == '1') {
            $redirect_url_toyyibpay = base_url(return_ecommerce_base_url('toyyibpay_action/')) . $cart_id;
            $this->load->library('toyyibpay');
            $this->toyyibpay->redirect_url = $redirect_url_toyyibpay;
            $this->toyyibpay->button_lang = $this->lang->line('Pay with toyyibpay');
            $toyyibpay_button = $this->toyyibpay->set_button();
            $toyyibpay_button = '<div class="col-12 col-md-6">' . $toyyibpay_button . '</div>';

            $new_checkout['toyyibpay'] = array(
                'hidden_code' => '',
                'action' => 'redirect',
                'action_class' => '',
                'action_id' => '',
                'id' => 'new_toyyibpay',
                'title' => $this->lang->line("Pay with toyyibpay"),
                'description' => '',
                'href' => $redirect_url_toyyibpay,
            );
        }

        if ($paymaya_enabled == '1') {
            $redirect_url_paymaya = base_url(return_ecommerce_base_url('paymaya_action/')) . $cart_id;
            $this->load->library('paymaya');
            $this->paymaya->redirect_url = $redirect_url_paymaya;
            $this->paymaya->button_lang = $this->lang->line('Pay with paymaya');
            $paymaya_button = $this->paymaya->set_button();
            $paymaya_button = '<div class="col-12 col-md-6">' . $paymaya_button . '</div>';

            $new_checkout['paymaya'] = array(
                'hidden_code' => '',
                'action' => 'redirect',
                'action_class' => '',
                'action_id' => '',
                'id' => 'new_paymaya',
                'title' => $this->lang->line("Pay with paymaya"),
                'description' => '',
                'href' => $redirect_url_paymaya,
            );
        }

        if ($myfatoorah_enabled == '1') {
            $redirect_url_myfatoorah = base_url(return_ecommerce_base_url('myfatoorah_action/') ). $cart_id;
            $this->load->library('myfatoorah');
            $this->myfatoorah->redirect_url = $redirect_url_myfatoorah;
            $this->myfatoorah->button_lang = $this->lang->line('Pay with myfatoorah');

            $this->myfatoorah->myfatoorah_currency = $currency;

            $myfatoorah_button = $this->myfatoorah->set_button();
            $myfatoorah_button = '<div class="col-12 col-md-6">' . $myfatoorah_button . '</div>';

            $new_checkout['myfatoorah'] = array(
                'hidden_code' => '',
                'action' => 'redirect',
                'action_class' => '',
                'action_id' => '',
                'id' => 'new_myfatoorah',
                'title' => $this->lang->line("Pay with myfatoorah"),
                'description' => '',
                'href' => $redirect_url_myfatoorah,
            );
        }

        if ($xendit_enabled == '1') {
            $new_checkout['xendit'] = array(
                'hidden_code' => '',
                'action' => 'onclick',
                'action_class' => 'href_action',
                'action_id' => 'xendit_btn a',
                'id' => 'xendit',
                'title' => $this->lang->line("Pay with Xendit"),
                'description' => '',
                'href' => '',
                'url_get_button' => base_url(return_ecommerce_base_url("ajax_get_payment_button/xendit/".$cart_id.'/'.$store_id)),
            );
        }

        if ($manual_enabled == '1') {
            $manual_button = '
  <div class="col-12 col-md-6 text-center">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" id="manual-payment-button">
  <div class="d-flex w-100 align-items-center">
  <small class="text-muted"><img class="rounded" width="60" height="60" src="' . base_url("assets/img/payment/manual.png") . '"></small>
  <h6 class="mb-1">' . $this->lang->line("Manual Payment") . '</h6>
  </div>
  </a>
  </div>';

            $new_checkout['manual'] = array(
                'hidden_code' => $manual_button,
                'action' => 'onclick',
                'action_class' => '',
                'action_id' => 'manual-payment-button',
                'id' => 'new_manual',
                'title' => $this->lang->line("Manual Payment"),
                'description' => '',
                'href' => '',
            );
        }

        if ($cod_enabled == '1') {
            $cod_button = '
  <div class="col-12 col-md-6 text-center">
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" id="cod-payment-button">
  <div class="d-flex w-100 align-items-center">
  <small class="text-muted"><img class="rounded" width="60" height="60" src="' . base_url("assets/img/payment/cod.png") . '"></small>
  <h6 class="mb-1">' . $this->lang->line("Cash on Delivery") . '</h6>
  </div>
  </a>
  </div>';

            $new_checkout['cod'] = array(
                'hidden_code' => $cod_button,
                'action' => 'onlick',
                'action_class' => '',
                'action_id' => 'cod-payment-button',
                'cod' => '1',
                'id' => 'new_cod',
                'title' => $this->lang->line("Cash on Delivery"),
                'description' => '',
                'href' => '',
            );
        }

        $n_omise_btn = '';
        if ($n_omise_enabled == '1') {
            include(APPPATH . 'modules/n_omise/lib/omise_lib.php');
        }

        $n_paymongo_btn = '';
        $paymongo_js = '';
        if ($n_paymongo_sec != '' and $currency == 'PHP') {
            include(APPPATH . 'modules/n_paymongo/lib/paymongo_lib.php');
        }

        $n_paymentwall_btn = '';
        $n_paymentwall_js = '';
        if ($n_paymentwall_enabled == '1') {
            include(APPPATH . 'modules/n_paymentwall/lib/button_ecommerce_lib.php');
        }

        $n_payulatam_btn = '';
        $n_payulatam_js = '';
        if ($n_payu_latam_enabled == '1') {
            include(APPPATH . 'modules/n_payu_latam/lib/button_ecommerce_lib.php');
        }

        $n_coinbase_btn = '';
        $n_coinbase_js = '';
        if ($n_coinbase_enabled == '1') {
            include(APPPATH . 'modules/n_coinbase/lib/button_ecommerce_lib.php');
        }

        $n_moamalat_btn = '';
        $n_moamalat_js = '';
        if ($n_moamalat_enabled == '1') {
            include(APPPATH . 'modules/n_moamalat/lib/button_ecommerce_lib.php');
        }

        $n_tdsp_btn = '';
        $n_tdsp_js = '';
        if ($n_tdsp_enabled == '1') {
            include(APPPATH . 'modules/n_tdsp/lib/button_ecommerce_lib.php');
        }

        $n_new_stripe_btn = '';
        $n_stripe_new_js = '';
        if ($n_stripe_enabled == '1') {
            include(APPPATH . 'modules/n_stripe/lib/button_ecommerce_lib.php');
        }

        $n_sadad_btn = '';
        $n_sadad_js = '';
        if ($n_sadad_enabled == '1') {
            include(APPPATH . 'modules/n_sadad/lib/button_ecommerce_lib.php');
        }

        $n_tap_btn = '';
        $n_tap_js = '';
        if ($n_tap_on == '1') {
            include(APPPATH . 'modules/n_tap/lib/button_ecommerce_lib.php');
        }

        $n_epayco_btn = '';
        $n_epayco_js = '';
        if ($n_epayco_enabled == '1') {
            include(APPPATH . 'modules/n_epayco/lib/button_ecommerce_lib.php');
        }

        $n_sellix_btn = '';
        $n_sellix_js = '';
        if ($n_sellix_enabled == '1') {
            include(APPPATH . 'modules/n_sellix/lib/button_ecommerce_lib.php');
        }

        $n_chapa_btn = '';
        $n_chapa_js = '';
        if ($n_chapa_enabled == '1') {
            include(APPPATH . 'modules/n_chapa/lib/button_ecommerce_lib.php');
        }

        $n_zaincash_btn = '';
        $n_zaincash_js = '';
        if ($n_zaincash_enabled == '1') {
            include(APPPATH . 'modules/n_zaincash/lib/button_ecommerce_lib.php');
        }


        $html = '<div class="row">' . $cod_button . $paypal_button . $stripe_button . $razorpay_button . $paystack_button . $mollie_button . $mercadopago_button . $sslcommerz_button . $senangpay_button . $instamojo_button . $xendit_button . $manual_button . $toyyibpay_button . $myfatoorah_button . $paymaya_button . $n_omise_btn . $n_paymongo_btn . $n_paymentwall_btn . $n_payulatam_btn . $n_coinbase_btn . $n_moamalat_btn . $n_tdsp_btn. $n_new_stripe_btn . $n_sadad_btn . $n_tap_btn . $n_epayco_btn . $n_sellix_btn . $n_chapa_btn . $n_zaincash_btn .'</div>';

        if($for_checkout == 0){
            echo json_encode(array('status' => '1', 'message' => '', 'html' => $html));
        }else{
            //$new_checkout['html'] = $html;
            return $new_checkout;
        }


    }




    private function valid_cart_data($cart_id = 0, $subscriber_id = "", $select = "", $once = 0)
    {
        $join = array('ecommerce_store' => "ecommerce_cart.store_id=ecommerce_store.id,left");
        $where = array('where' => array("ecommerce_cart.subscriber_id" => $subscriber_id, "ecommerce_cart.id" => $cart_id, "action_type!=" => "checkout", "ecommerce_store.status" => "1"));
        if ($select == "") $select = array("ecommerce_cart.*", "tax_percentage", "shipping_charge", "store_unique_id", "store_locale");
        $cart_data = $this->basic->get_data("ecommerce_cart", $where, $select, $join, 1);
        //var_dump($cart_id=0,$subscriber_id="",$select="");
        if (empty($cart_data) and $once == 0) {
            $cart_data = $this->valid_cart_data($cart_id, $this->session->userdata($this->nstore_id . '_temp_cart'), $select, 1);
        }
        return $cart_data;
    }

    public function payment_accounts_action()
    {
        include(FCPATH . 'application/n_views/config.php');
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') redirect('home/access_forbidden', 'location');
        if ($_POST) {
            $this->form_validation->set_rules('paypal_email', '<b>' . $this->lang->line("Paypal Email") . '</b>', 'trim|valid_email');
            $this->form_validation->set_rules('paypal_mode', '<b>' . $this->lang->line("Paypal Sandbox Mode") . '</b>', 'trim');
            $this->form_validation->set_rules('stripe_secret_key', '<b>' . $this->lang->line("Stripe Secret Key") . '</b>', 'trim');
            $this->form_validation->set_rules('stripe_publishable_key', '<b>' . $this->lang->line("Stripe Publishable Key") . '</b>', 'trim');
            $this->form_validation->set_rules('razorpay_key_id', '<b>' . $this->lang->line("Razorpay Key ID") . '</b>', 'trim');
            $this->form_validation->set_rules('razorpay_key_secret', '<b>' . $this->lang->line("Razorpay Key Secret") . '</b>', 'trim');
            $this->form_validation->set_rules('paystack_secret_key', '<b>' . $this->lang->line("Paystack Secret Key") . '</b>', 'trim');
            $this->form_validation->set_rules('paystack_public_key', '<b>' . $this->lang->line("Paystack Public Key") . '</b>', 'trim');
            $this->form_validation->set_rules('mollie_api_key', '<b>' . $this->lang->line("Mollie API Key") . '</b>', 'trim');
            $this->form_validation->set_rules('mercadopago_public_key', '<b>' . $this->lang->line("Mercado Pago Public Key") . '</b>', 'trim');
            $this->form_validation->set_rules('mercadopago_access_token', '<b>' . $this->lang->line("Mercado Pago Acceess Token") . '</b>', 'trim');
            $this->form_validation->set_rules('sslcommerz_store_id', '<b>' . $this->lang->line("Sslcommerz Store ID") . '</b>', 'trim');
            $this->form_validation->set_rules('sslcommerz_store_password', '<b>' . $this->lang->line("Sslcommerz Store Password") . '</b>', 'trim');
            $this->form_validation->set_rules('sslcommerz_mode', '<b>' . $this->lang->line("Sslcommerz Sandbox Mode") . '</b>', 'trim');
            $this->form_validation->set_rules('marcadopago_country', '<b>' . $this->lang->line("marcadopago_country") . '</b>', 'trim');
            $this->form_validation->set_rules('senangpay_merchent_id', '<b>' . $this->lang->line("senangpay_merchent_id") . '</b>', 'trim');
            $this->form_validation->set_rules('senangpay_secret_key', '<b>' . $this->lang->line("senangpay_secret_key") . '</b>', 'trim');
            $this->form_validation->set_rules('senangpay_mode', '<b>' . $this->lang->line("senangpay_mode") . '</b>', 'trim');
            $this->form_validation->set_rules('instamojo_api_key', '<b>' . $this->lang->line("instamojo_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('instamojo_auth_token', '<b>' . $this->lang->line("instamojo_auth_token") . '</b>', 'trim');
            $this->form_validation->set_rules('instamojo_mode', '<b>' . $this->lang->line("instamojo_mode") . '</b>', 'trim');
            $this->form_validation->set_rules('xendit_secret_api_key', '<b>' . $this->lang->line("xendit_secret_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('myfatoorah_mode', '<b>' . $this->lang->line("myfatoorah_mode") . '</b>', 'trim');
            $this->form_validation->set_rules('myfatoorah_api_key', '<b>' . $this->lang->line("myfatoorah_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('senangpay_enabled', '<b>' . $this->lang->line("senangpay_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('toyyibpay_secret_key', '<b>' . $this->lang->line("toyyibpay_secret_key") . '</b>', 'trim');
            $this->form_validation->set_rules('toyyibpay_mode', '<b>' . $this->lang->line("toyyibpay_mode") . '</b>', 'trim');
            $this->form_validation->set_rules('toyyibpay_category_code', '<b>' . $this->lang->line("toyyibpay_category_code") . '</b>', 'trim');
            $this->form_validation->set_rules('paymaya_secret_key', '<b>' . $this->lang->line("paymaya_secret_key") . '</b>', 'trim');
            $this->form_validation->set_rules('paymaya_public_key', '<b>' . $this->lang->line("paymaya_public_key") . '</b>', 'trim');
            $this->form_validation->set_rules('paymaya_mode', '<b>' . $this->lang->line("paymaya_mode") . '</b>', 'trim');
            $this->form_validation->set_rules('senangpay_enabled', '<b>' . $this->lang->line("senangpay_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('instamojo_enabled', '<b>' . $this->lang->line("instamojo_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('xendit_enabled', '<b>' . $this->lang->line("xendit_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('toyyibpay_enabled', '<b>' . $this->lang->line("toyyibpay_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('paymaya_enabled', '<b>' . $this->lang->line("paymaya_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('currency', '<b>' . $this->lang->line("Currency") . '</b>', 'trim');
            $this->form_validation->set_rules('manual_payment_instruction', '<b>' . $this->lang->line("Manual Payment Instruction") . '</b>', 'trim');
            $this->form_validation->set_rules('currency_position', '<b>' . $this->lang->line("Currency Position") . '</b>', 'trim');
            $this->form_validation->set_rules('decimal_point', '<b>' . $this->lang->line("Decimal Point") . '</b>', 'trim|integer');
            $this->form_validation->set_rules('thousand_comma', '<b>' . $this->lang->line("Thousand Comma") . '</b>', 'trim');
            $this->form_validation->set_rules('is_preparation_time', '<b>' . $this->lang->line("Preparation time") . '</b>', 'trim');
            $this->form_validation->set_rules('preparation_time', '<b>' . $this->lang->line("Preparation time") . '</b>', 'trim');
            $this->form_validation->set_rules('preparation_time_unit', '<b>' . $this->lang->line("Preparation time") . '</b>', 'trim');
            $this->form_validation->set_rules('is_order_schedule', '<b>' . $this->lang->line("Scheduled order") . '</b>', 'trim');
            $this->form_validation->set_rules('order_schedule', '<b>' . $this->lang->line("Scheduled order") . '</b>', 'trim');
            $this->form_validation->set_rules('is_guest_login', '<b>' . $this->lang->line("Guest login") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_pubkey', '<b>' . $this->lang->line("n_omise_pubkey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_seckey', '<b>' . $this->lang->line("n_omise_seckey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_enabled', '<b>' . $this->lang->line("n_omise_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_pubkey', '<b>' . $this->lang->line("n_omise_pubkey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_seckey', '<b>' . $this->lang->line("n_omise_seckey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_enabled', '<b>' . $this->lang->line("n_omise_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_pubkey', '<b>' . $this->lang->line("n_omise_pubkey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_seckey', '<b>' . $this->lang->line("n_omise_seckey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_omise_enabled', '<b>' . $this->lang->line("n_omise_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_paymongo_pub', '<b>' . $this->lang->line("n_paymongo_pub") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_sec', '<b>' . $this->lang->line("n_paymongo_sec") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_enabled', '<b>' . $this->lang->line("n_paymongo_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_paymaya_en', '<b>' . $this->lang->line("n_paymongo_paymaya_en") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_grab_en', '<b>' . $this->lang->line("n_paymongo_grab_en") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_gcash_en', '<b>' . $this->lang->line("n_paymongo_gcash_en") . '</b>', 'trim');

            $this->form_validation->set_rules('n_paymentwall_pub', '<b>' . $this->lang->line("n_paymentwall_pub") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymentwall_sec', '<b>' . $this->lang->line("n_paymentwall_sec") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymentwall_enabled', '<b>' . $this->lang->line("n_paymentwall_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_coinbase_enabled', '<b>' . $this->lang->line("n_coinbase_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_shared_secret', '<b>' . $this->lang->line("n_coinbase_shared_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_api_key', '<b>' . $this->lang->line("n_coinbase_api_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_moamalat_enabled', '<b>' . $this->lang->line("n_moamalat_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_testmode', '<b>' . $this->lang->line("n_moamalat_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_merchant_id', '<b>' . $this->lang->line("n_moamalat_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_terminal_id', '<b>' . $this->lang->line("n_moamalat_terminal_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_secret_key', '<b>' . $this->lang->line("n_moamalat_secret_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_sellix_enabled', '<b>' . $this->lang->line("n_sellix_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_merchant', '<b>' . $this->lang->line("n_sellix_merchant") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_webhook_secret', '<b>' . $this->lang->line("n_sellix_webhook_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_api_key', '<b>' . $this->lang->line("n_sellix_api_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_chapa_enabled', '<b>' . $this->lang->line("n_chapa_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_chapa_secret_key', '<b>' . $this->lang->line("n_chapa_secret_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_zaincash_enabled', '<b>' . $this->lang->line("n_zaincash_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_testmode_enabled', '<b>' . $this->lang->line("n_zaincash_testmode_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_MSISDN', '<b>' . $this->lang->line("n_zaincash_MSISDN") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_merchant_id', '<b>' . $this->lang->line("n_zaincash_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_merchant_secret', '<b>' . $this->lang->line("n_zaincash_merchant_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_convert_price', '<b>' . $this->lang->line("n_zaincash_convert_price") . '</b>', 'trim');

            $this->form_validation->set_rules('n_sadad_enabled', '<b>' . $this->lang->line("n_sadad_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sadad_testmode', '<b>' . $this->lang->line("n_sadad_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sadad_secret_key', '<b>' . $this->lang->line("n_sadad_secret_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_tap_on', '<b>' . $this->lang->line("n_tap_on") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tap_secret', '<b>' . $this->lang->line("n_tap_secret") . '</b>', 'trim');

            $this->form_validation->set_rules('n_tdsp_auth_key', '<b>' . $this->lang->line("n_tdsp_auth_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_store_id', '<b>' . $this->lang->line("n_tdsp_store_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_sandbox', '<b>' . $this->lang->line("n_tdsp_sandbox") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_enabled', '<b>' . $this->lang->line("n_tdsp_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_mastercard_merchant_id', '<b>' . $this->lang->line("n_mastercard_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_api_pass', '<b>' . $this->lang->line("n_mastercard_api_pass") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_enabled', '<b>' . $this->lang->line("n_mastercard_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_testmode', '<b>' . $this->lang->line("n_mastercard_testmode") . '</b>', 'trim');

            $this->form_validation->set_rules('n_epayco_pkey', '<b>' . $this->lang->line("n_epayco_pkey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_enabled', '<b>' . $this->lang->line("n_epayco_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_testmode', '<b>' . $this->lang->line("n_epayco_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_checkout', '<b>' . $this->lang->line("n_epayco_checkout") . '</b>', 'trim');

            $this->form_validation->set_rules('n_stripe_enabled', '<b>' . $this->lang->line("n_stripe_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_product_image', '<b>' . $this->lang->line("n_stripe_product_image") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_secret_key', '<b>' . $this->lang->line("n_stripe_secret_key") . '</b>', 'trim');

            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->payment_accounts();
            } else {
                // assign
                $paypal_email = strip_tags($this->input->post('paypal_email', true));
                $paypal_payment_type = strip_tags($this->input->post('paypal_payment_type', true));
                $paypal_mode = strip_tags($this->input->post('paypal_mode', true));
                $stripe_billing_address = strip_tags($this->input->post('stripe_billing_address', true));
                $stripe_secret_key = strip_tags($this->input->post('stripe_secret_key', true));
                $stripe_publishable_key = strip_tags($this->input->post('stripe_publishable_key', true));
                $razorpay_key_id = strip_tags($this->input->post('razorpay_key_id', true));
                $razorpay_key_secret = strip_tags($this->input->post('razorpay_key_secret', true));
                $paystack_secret_key = strip_tags($this->input->post('paystack_secret_key', true));
                $paystack_public_key = strip_tags($this->input->post('paystack_public_key', true));
                $mollie_api_key = strip_tags($this->input->post('mollie_api_key', true));
                $mercadopago_public_key = strip_tags($this->input->post('mercadopago_public_key', true));
                $mercadopago_access_token = strip_tags($this->input->post('mercadopago_access_token', true));
                $sslcommerz_store_id = strip_tags($this->input->post('sslcommerz_store_id', true));
                $sslcommerz_store_password = strip_tags($this->input->post('sslcommerz_store_password', true));
                $sslcommerz_mode = strip_tags($this->input->post('sslcommerz_mode', true));
                $myfatoorah_api_key = strip_tags($this->input->post('myfatoorah_api_key', true));
                $myfatoorah_mode = strip_tags($this->input->post('myfatoorah_mode', true));
                $myfatoorah_enabled = strip_tags($this->input->post('myfatoorah_enabled', true));
                $marcadopago_country = strip_tags($this->input->post('marcadopago_country', true));
                $senangpay_merchent_id = strip_tags($this->input->post('senangpay_merchent_id', true));
                $senangpay_secret_key = strip_tags($this->input->post('senangpay_secret_key', true));
                $senangpay_mode = strip_tags($this->input->post('senangpay_mode', true));
                $instamojo_api_key = strip_tags($this->input->post('instamojo_api_key', true));
                $instamojo_auth_token = strip_tags($this->input->post('instamojo_auth_token', true));
                $instamojo_mode = strip_tags($this->input->post('instamojo_mode', true));
                $xendit_secret_api_key = strip_tags($this->input->post('xendit_secret_api_key', true));

                $paymaya_secret_key = strip_tags($this->input->post('paymaya_secret_key', true));
                $paymaya_public_key = strip_tags($this->input->post('paymaya_public_key', true));
                $paymaya_mode = strip_tags($this->input->post('paymaya_mode', true));

                $toyyibpay_secret_key = strip_tags($this->input->post('toyyibpay_secret_key', true));
                $toyyibpay_category_code = strip_tags($this->input->post('toyyibpay_category_code', true));
                $toyyibpay_mode = strip_tags($this->input->post('toyyibpay_mode', true));
                $currency = strip_tags($this->input->post('currency', true));
                $currency_position = strip_tags($this->input->post('currency_position', true));
                $decimal_point = strip_tags($this->input->post('decimal_point', true));
                $thousand_comma = strip_tags($this->input->post('thousand_comma', true));
                $paypal_enabled = strip_tags($this->input->post('paypal_enabled', true));
                $stripe_enabled = strip_tags($this->input->post('stripe_enabled', true));
                $toyyibpay_enabled = strip_tags($this->input->post('toyyibpay_enabled', true));
                $paymaya_enabled = strip_tags($this->input->post('paymaya_enabled', true));
                $manual_enabled = strip_tags($this->input->post('manual_enabled', true));
                $cod_enabled = strip_tags($this->input->post('cod_enabled', true));
                $razorpay_enabled = strip_tags($this->input->post('razorpay_enabled', true));
                $paystack_enabled = strip_tags($this->input->post('paystack_enabled', true));
                $mollie_enabled = strip_tags($this->input->post('mollie_enabled', true));
                $senangpay_enabled = strip_tags($this->input->post('senangpay_enabled', true));
                $instamojo_enabled = strip_tags($this->input->post('instamojo_enabled', true));
                $xendit_enabled = strip_tags($this->input->post('xendit_enabled', true));
                $mercadopago_enabled = strip_tags($this->input->post('mercadopago_enabled', true));
                $sslcommerz_enabled = strip_tags($this->input->post('sslcommerz_enabled', true));
                $tax_percentage = strip_tags($this->input->post('tax_percentage', true));
                $shipping_charge = strip_tags($this->input->post('shipping_charge', true));
                $is_store_pickup = strip_tags($this->input->post('is_store_pickup', true));
                $is_home_delivery = strip_tags($this->input->post('is_home_delivery', true));
                $is_checkout_country = strip_tags($this->input->post('is_checkout_country', true));
                $is_checkout_state = strip_tags($this->input->post('is_checkout_state', true));
                $is_checkout_city = strip_tags($this->input->post('is_checkout_city', true));
                $is_checkout_zip = strip_tags($this->input->post('is_checkout_zip', true));
                $is_checkout_email = strip_tags($this->input->post('is_checkout_email', true));
                $is_checkout_phone = strip_tags($this->input->post('is_checkout_phone', true));
                $is_delivery_note = strip_tags($this->input->post('is_delivery_note', true));
                $is_preparation_time = strip_tags($this->input->post('is_preparation_time', true));
                $preparation_time = strip_tags($this->input->post('preparation_time', true));
                $preparation_time_unit = strip_tags($this->input->post('preparation_time_unit', true));
                $is_order_schedule = strip_tags($this->input->post('is_order_schedule', true));
                $order_schedule = strip_tags($this->input->post('order_schedule', true));
                $is_guest_login = strip_tags($this->input->post('is_guest_login', true));
                // $manual_payment=$this->input->post('manual_payment');
                $manual_payment = '1';
                $manual_payment_instruction = $this->input->post('manual_payment_instruction', true);

                $n_omise_pubkey = strip_tags($this->input->post('n_omise_pubkey', true));
                $n_omise_seckey = strip_tags($this->input->post('n_omise_seckey', true));
                $n_omise_enabled = strip_tags($this->input->post('n_omise_enabled', true));

                $n_paymongo_pub = strip_tags($this->input->post('n_paymongo_pub', true));
                $n_paymongo_sec = strip_tags($this->input->post('n_paymongo_sec', true));
                $n_paymongo_enabled = strip_tags($this->input->post('n_paymongo_enabled', true));
                $n_paymongo_paymaya_en = strip_tags($this->input->post('n_paymongo_paymaya_en', true));
                $n_paymongo_grab_en = strip_tags($this->input->post('n_paymongo_grab_en', true));
                $n_paymongo_gcash_en = strip_tags($this->input->post('n_paymongo_gcash_en', true));

                $n_paymentwall_pub = strip_tags($this->input->post('n_paymentwall_pub', true));
                $n_paymentwall_sec = strip_tags($this->input->post('n_paymentwall_sec', true));
                $n_paymentwall_enabled = strip_tags($this->input->post('n_paymentwall_enabled', true));

                $n_payu_latam_sandbox = strip_tags($this->input->post('n_payu_latam_sandbox', true));
                $n_payu_latam_enabled = strip_tags($this->input->post('n_payu_latam_enabled', true));

                $n_payu_latam_merchantid = strip_tags($this->input->post('n_payu_latam_merchantid', true));
                $n_payu_latam_accountid = strip_tags($this->input->post('n_payu_latam_accountid', true));
                $n_payu_latam_api_key = strip_tags($this->input->post('n_payu_latam_api_key', true));

                $n_coinbase_api_key = strip_tags($this->input->post('n_coinbase_api_key', true));
                $n_coinbase_shared_secret = strip_tags($this->input->post('n_coinbase_shared_secret', true));
                $n_coinbase_enabled = strip_tags($this->input->post('n_coinbase_enabled', true));

                $n_moamalat_enabled = strip_tags($this->input->post('n_moamalat_enabled', true));
                $n_moamalat_testmode = strip_tags($this->input->post('n_moamalat_testmode', true));
                $n_moamalat_merchant_id = strip_tags($this->input->post('n_moamalat_merchant_id', true));
                $n_moamalat_terminal_id = strip_tags($this->input->post('n_moamalat_terminal_id', true));
                $n_moamalat_secret_key = strip_tags($this->input->post('n_moamalat_secret_key', true));

                $n_sellix_api_key = strip_tags($this->input->post('n_sellix_api_key', true));
                $n_sellix_webhook_secret = strip_tags($this->input->post('n_sellix_webhook_secret', true));
                $n_sellix_merchant = strip_tags($this->input->post('n_sellix_merchant', true));
                $n_sellix_enabled = strip_tags($this->input->post('n_sellix_enabled', true));

                $n_chapa_secret_key = strip_tags($this->input->post('n_chapa_secret_key', true));
                $n_chapa_enabled = strip_tags($this->input->post('n_chapa_enabled', true));

                $n_zaincash_enabled = strip_tags($this->input->post('n_zaincash_enabled', true));
                $n_zaincash_testmode_enabled = strip_tags($this->input->post('n_zaincash_testmode_enabled', true));
                $n_zaincash_MSISDN = strip_tags($this->input->post('n_zaincash_MSISDN', true));
                $n_zaincash_merchant_id = strip_tags($this->input->post('n_zaincash_merchant_id', true));
                $n_zaincash_merchant_secret = strip_tags($this->input->post('n_zaincash_merchant_secret', true));
                $n_zaincash_convert_price = strip_tags($this->input->post('n_zaincash_convert_price', true));

                $n_sadad_enabled = strip_tags($this->input->post('n_sadad_enabled', true));
                $n_sadad_testmode = strip_tags($this->input->post('n_sadad_testmode', true));
                $n_sadad_secret_key = strip_tags($this->input->post('n_sadad_secret_key', true));

                $n_tap_on = strip_tags($this->input->post('n_tap_on', true));
                $n_tap_secret = strip_tags($this->input->post('n_tap_secret', true));

                $n_tdsp_auth_key = strip_tags($this->input->post('n_tdsp_auth_key', true));
                $n_tdsp_store_id = strip_tags($this->input->post('n_tdsp_store_id', true));
                $n_tdsp_sandbox = strip_tags($this->input->post('n_tdsp_sandbox', true));
                $n_tdsp_enabled = strip_tags($this->input->post('n_tdsp_enabled', true));

                $n_mastercard_merchant_id = strip_tags($this->input->post('n_mastercard_merchant_id', true));
                $n_mastercard_api_pass = strip_tags($this->input->post('n_mastercard_api_pass', true));
                $n_mastercard_enabled = strip_tags($this->input->post('n_mastercard_enabled', true));
                $n_mastercard_testmode = strip_tags($this->input->post('n_mastercard_testmode', true));

                $n_epayco_pkey = strip_tags($this->input->post('n_epayco_pkey', true));
                $n_epayco_enabled = strip_tags($this->input->post('n_epayco_enabled', true));
                $n_epayco_testmode = strip_tags($this->input->post('n_epayco_testmode', true));
                $n_epayco_checkout = strip_tags($this->input->post('n_epayco_checkout', true));

                $n_stripe_secret_key = strip_tags($this->input->post('n_stripe_secret_key', true));
                $n_stripe_product_image = strip_tags($this->input->post('n_stripe_product_image', true));
                $n_stripe_enabled = strip_tags($this->input->post('n_stripe_enabled', true));

                $store_type = $this->input->post('store_type', true);
                if ($store_type == 'digital') {
                    $manual_payment_instruction = '';
                    $cod_enabled = '0';
                    $manual_payment = '0';
                }


                if ($paypal_mode == "") $paypal_mode = "live";
                if ($stripe_billing_address == "") $stripe_billing_address = "0";
                if ($sslcommerz_mode == "") $sslcommerz_mode = "live";
                if ($senangpay_mode == "") $senangpay_mode = "live";
                if ($myfatoorah_mode == "") $myfatoorah_mode = "live";
                if ($instamojo_mode == "") $instamojo_mode = "live";
                if ($toyyibpay_mode == "") $toyyibpay_mode = "live";
                if ($paymaya_mode == "") $paymaya_mode = "live";
                if ($manual_payment == "") $manual_payment = "0";
                if ($currency_position == "") $currency_position = "left";
                if ($thousand_comma == "") $thousand_comma = "0";
                if ($decimal_point == "") $decimal_point = "0";

                if ($is_store_pickup == "") $is_store_pickup = "0";
                if ($is_home_delivery == "") $is_home_delivery = "0";
                if ($is_checkout_country == "") $is_checkout_country = "0";
                if ($is_checkout_state == "") $is_checkout_state = "0";
                if ($is_checkout_city == "") $is_checkout_city = "0";
                if ($is_checkout_zip == "") $is_checkout_zip = "0";
                if ($is_checkout_email == "") $is_checkout_email = "0";
                if ($is_checkout_phone == "") $is_checkout_phone = "0";
                if ($is_delivery_note == "") $is_delivery_note = "0";
                if ($is_preparation_time == "") $is_preparation_time = "0";
                if ($is_order_schedule == "") $is_order_schedule = "0";
                if ($is_guest_login == "") $is_guest_login = "0";

                if ($is_preparation_time == '1') {
                    if (!isset($preparation_time) || $preparation_time == "") $preparation_time = "30";
                    if (!isset($preparation_time_unit) || $preparation_time_unit == "") $preparation_time_unit = "minutes";
                }

                if (!isset($order_schedule) || $order_schedule == "") $order_schedule = "any";

                if ($paypal_enabled == '0' && $stripe_enabled == '0' && $manual_enabled == '0' && $cod_enabled == '0' && $razorpay_enabled == '0' && $paystack_enabled == '0' && $mollie_enabled == '0' && $mercadopago_enabled == '0' && $sslcommerz_enabled == '0' && $senangpay_enabled == '0' && $instamojo_enabled == '0' && $xendit_enabled == '0' && $toyyibpay_enabled == '0' && $myfatoorah_enabled == '0' && $paymaya_enabled == '0' && $n_omise_enabled == '0' && $n_paymongo_enabled == '0' && $n_paymentwall_enabled == '0' && $n_payu_latam_enabled == '0' && $n_coinbase_enabled == '0') {
                    $this->session->set_flashdata('error_message', 1);
                    redirect('ecommerce/payment_accounts', 'location');
                    exit();
                }

                if ($store_type == 'physical') {

                    if ($is_store_pickup == '0' && $is_home_delivery == '0') {
                        $this->session->set_flashdata('error_message2', 1);
                        redirect('ecommerce/payment_accounts', 'location');
                        exit();
                    }
                }

                $update_data =
                    array
                    (
                        'paypal_email' => $paypal_email,
                        'paypal_mode' => $paypal_mode,
                        'stripe_billing_address' => $stripe_billing_address,
                        'stripe_secret_key' => $stripe_secret_key,
                        'stripe_publishable_key' => $stripe_publishable_key,
                        'razorpay_key_id' => $razorpay_key_id,
                        'razorpay_key_secret' => $razorpay_key_secret,
                        'paystack_secret_key' => $paystack_secret_key,
                        'paystack_public_key' => $paystack_public_key,
                        'mollie_api_key' => $mollie_api_key,
                        'mercadopago_public_key' => $mercadopago_public_key,
                        'mercadopago_access_token' => $mercadopago_access_token,
                        'sslcommerz_store_id' => $sslcommerz_store_id,
                        'sslcommerz_store_password' => $sslcommerz_store_password,
                        'sslcommerz_mode' => $sslcommerz_mode,
                        'marcadopago_country' => $marcadopago_country,
                        'senangpay_merchent_id' => $senangpay_merchent_id,
                        'senangpay_secret_key' => $senangpay_secret_key,
                        'senangpay_mode' => $senangpay_mode,
                        'instamojo_api_key' => $instamojo_api_key,
                        'instamojo_auth_token' => $instamojo_auth_token,
                        'instamojo_mode' => $instamojo_mode,
                        'paymaya_public_key' => $paymaya_public_key,
                        'paymaya_secret_key' => $paymaya_secret_key,
                        'paymaya_mode' => $paymaya_mode,
                        'myfatoorah_api_key' => $myfatoorah_api_key,
                        'myfatoorah_mode' => $myfatoorah_mode,
                        'xendit_secret_api_key' => $xendit_secret_api_key,
                        'toyyibpay_secret_key' => $toyyibpay_secret_key,
                        'toyyibpay_category_code' => $toyyibpay_category_code,
                        'toyyibpay_mode' => $toyyibpay_mode,
                        'currency' => $currency,
                        'manual_payment' => $manual_payment,
                        'manual_payment_instruction' => $manual_payment_instruction,
                        'user_id' => $this->user_id,
                        'store_id' => $this->session->userdata("ecommerce_selected_store"),
                        'currency_position' => $currency_position,
                        'decimal_point' => $decimal_point,
                        'thousand_comma' => $thousand_comma,
                        'updated_at' => date("Y-m-d H:i:s"),
                        'is_store_pickup' => $is_store_pickup,
                        'is_home_delivery' => $is_home_delivery,
                        'is_checkout_country' => $is_checkout_country,
                        'is_checkout_state' => $is_checkout_state,
                        'is_checkout_city' => $is_checkout_city,
                        'is_checkout_zip' => $is_checkout_zip,
                        'is_checkout_email' => $is_checkout_email,
                        'is_checkout_phone' => $is_checkout_phone,
                        'is_delivery_note' => $is_delivery_note,
                        'is_preparation_time' => $is_preparation_time,
                        'preparation_time' => $preparation_time,
                        'preparation_time_unit' => $preparation_time_unit,
                        'is_order_schedule' => $is_order_schedule,
                        'order_schedule' => $order_schedule,
                        'is_guest_login' => $is_guest_login
                    );

                if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php')) {
                    $update_data['n_omise_pubkey'] = $n_omise_pubkey;
                    $update_data['n_omise_seckey'] = $n_omise_seckey;
                }

                if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php')) {
                    $update_data['n_paymongo_sec'] = $n_paymongo_sec;
                    $update_data['n_paymongo_pub'] = $n_paymongo_pub;
                }

                if (file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php')) {
                    $update_data['n_paymentwall_sec'] = $n_paymentwall_sec;
                    $update_data['n_paymentwall_pub'] = $n_paymentwall_pub;
                }

                if (file_exists(APPPATH . 'modules/n_coinbase/controllers/N_coinbase.php')) {
                    $update_data['n_coinbase_shared_secret'] = $n_coinbase_shared_secret;
                    $update_data['n_coinbase_api_key'] = $n_coinbase_api_key;
                }

                if (file_exists(APPPATH . 'modules/n_payu_latam/controllers/N_payu_latam.php')) {
                    $update_data['n_payu_latam_merchantid'] = $n_payu_latam_merchantid;
                    $update_data['n_payu_latam_accountid'] = $n_payu_latam_accountid;
                    $update_data['n_payu_latam_api_key'] = $n_payu_latam_api_key;
                }

                if (file_exists(APPPATH . 'modules/n_mastercard/controllers/N_mastercard.php')) {
                    $update_data['n_mastercard_merchant_id'] = $n_mastercard_merchant_id;
                    $update_data['n_mastercard_api_pass'] = $n_mastercard_api_pass;
                }

                if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php')) {
                    $update_data['n_epayco_pkey'] = $n_epayco_pkey;
                }

                if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php')) {
                    $update_data['n_moamalat_merchant_id'] = $n_moamalat_merchant_id;
                    $update_data['n_moamalat_terminal_id'] = $n_moamalat_terminal_id;

                    if ($n_moamalat_secret_key != '*****') {
                        $n_moamalat_secret_key = openssl_encrypt($n_moamalat_secret_key, "AES-128-ECB", $n_config['cipher']);
                        $update_data['n_moamalat_secret_key'] = $n_moamalat_secret_key;
                    }
                }

                if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php')) {
                    $update_data['n_sellix_api_key'] = $n_sellix_api_key;
                    $update_data['n_sellix_webhook_secret'] = $n_sellix_webhook_secret;
                    $update_data['n_sellix_merchant'] = $n_sellix_merchant;

                }

                if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php')) {
                    $update_data['n_chapa_secret_key'] = $n_chapa_secret_key;
                }

                if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php')) {
                    $update_data['n_zaincash_merchant_secret'] = $n_zaincash_merchant_secret;
                    $update_data['n_zaincash_MSISDN'] = $n_zaincash_MSISDN;
                    $update_data['n_zaincash_merchant_id'] = $n_zaincash_merchant_id;
                    $update_data['n_zaincash_convert_price'] = $n_zaincash_convert_price;
                }

                if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
                    $update_data['n_sadad_secret_key'] = $n_sadad_secret_key;
                }

                if (file_exists(APPPATH . 'modules/n_tap/controllers/N_tap.php')) {
                    $update_data['n_tap_secret'] = $n_tap_secret;
                }

                if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php')) {
                    $update_data['n_tdsp_auth_key'] = $n_tdsp_auth_key;
                    $update_data['n_tdsp_store_id'] = $n_tdsp_store_id;
                }

                if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')) {
                    $update_data['n_stripe_secret_key'] = $n_stripe_secret_key;
                    $update_data['n_stripe_product_image'] = $n_stripe_product_image;
                }

                $get_data = $this->basic->get_data("ecommerce_config", array("where" => array("store_id" => $this->session->userdata("ecommerce_selected_store"))));
                if (isset($get_data[0]))
                    $this->basic->update_data("ecommerce_config", array("store_id" => $this->session->userdata("ecommerce_selected_store")), $update_data);
                else $this->basic->insert_data("ecommerce_config", $update_data);

                $update_store = array
                (
                    "paypal_enabled" => $paypal_enabled,
                    "stripe_enabled" => $stripe_enabled,
                    "manual_enabled" => $manual_enabled,
                    "razorpay_enabled" => $razorpay_enabled,
                    "paystack_enabled" => $paystack_enabled,
                    "paymaya_enabled" => $paymaya_enabled,
                    "mollie_enabled" => $mollie_enabled,
                    "mercadopago_enabled" => $mercadopago_enabled,
                    "sslcommerz_enabled" => $sslcommerz_enabled,
                    "senangpay_enabled" => $senangpay_enabled,
                    "instamojo_enabled" => $instamojo_enabled,
                    "xendit_enabled" => $xendit_enabled,
                    "toyyibpay_enabled" => $toyyibpay_enabled,
                    "myfatoorah_enabled" => $myfatoorah_enabled,
                    "cod_enabled" => $cod_enabled,
                    "tax_percentage" => $tax_percentage,
                    "shipping_charge" => $shipping_charge
                );
                if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php')) {
                    $update_store['n_omise_enabled'] = $n_omise_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php')) {
                    $update_store['n_chapa_enabled'] = $n_chapa_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php')) {
                    $update_store['n_zaincash_enabled'] = $n_zaincash_enabled;
                    $update_store['n_zaincash_testmode_enabled'] = $n_zaincash_testmode_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php')) {
                    $update_store['n_paymongo_enabled'] = $n_paymongo_enabled;
                    $update_store['n_paymongo_paymaya_en'] = $n_paymongo_paymaya_en;
                    $update_store['n_paymongo_grab_en'] = $n_paymongo_grab_en;
                    $update_store['n_paymongo_gcash_en'] = $n_paymongo_gcash_en;
                }

                if (file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php')) {
                    $update_store['n_paymentwall_enabled'] = $n_paymentwall_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_payu_latam/controllers/N_payu_latam.php')) {
                    $update_store['n_payu_latam_sandbox'] = $n_payu_latam_sandbox;
                    $update_store['n_payu_latam_enabled'] = $n_payu_latam_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_coinbase/controllers/N_coinbase.php')) {
                    $update_store['n_coinbase_enabled'] = $n_coinbase_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php')) {
                    $update_store['n_moamalat_enabled'] = $n_moamalat_enabled;
                    $update_store['n_moamalat_testmode'] = $n_moamalat_testmode;
                }

                if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php')) {
                    $update_store['n_sellix_enabled'] = $n_sellix_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
                    $update_store['n_sadad_enabled'] = $n_sadad_enabled;
                    $update_store['n_sadad_testmode'] = $n_sadad_testmode;
                }

                if (file_exists(APPPATH . 'modules/n_tap/controllers/N_tap.php')) {
                    $update_store['n_tap_on'] = $n_tap_on;
                }

                if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php')) {
                    $update_store['n_tdsp_sandbox'] = $n_tdsp_sandbox;
                    $update_store['n_tdsp_enabled'] = $n_tdsp_enabled;
                }

                if (file_exists(APPPATH . 'modules/n_mastercard/controllers/N_mastercard.php')) {
                    $update_store['n_mastercard_enabled'] = $n_mastercard_enabled;
                    $update_store['n_mastercard_testmode'] = $n_mastercard_testmode;
                }

                if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php')) {
                    $update_store['n_epayco_enabled'] = $n_epayco_enabled;
                    $update_store['n_epayco_testmode'] = $n_epayco_testmode;
                    $update_store['n_epayco_checkout'] = $n_epayco_checkout;
                }

                if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')) {
                    $update_store['n_stripe_enabled'] = $n_stripe_enabled;
                }

                $this->basic->update_data("ecommerce_store", array("id" => $this->session->userdata("ecommerce_selected_store")), $update_store);

                $this->session->set_flashdata('success_message', 1);
                redirect('ecommerce/payment_accounts', 'location');
            }
        }
    }

    private function get_store_list(){
        $store_list = $this->basic->get_data("ecommerce_store", array("where" => array("user_id" => $this->user_id, "status" => "1")), $select = '', $join = '', $limit = '', $start = NULL, $order_by = 'store_name ASC');
        $store_info = array();
        foreach ($store_list as $value) {
            $store_info[$value['id']] = $value['store_name'];
        }
        return $store_info;
    }

    public function add_product()
    {
        $data['body'] = 'ecommerce/product_add';
        $data['page_title'] = $this->lang->line('Add Product') . " : " . $this->session->userdata("ecommerce_selected_store_title");
        $store_list = $this->get_store_list();
        $store_list[''] = $this->lang->line("Select Store");
        $data['store_list'] = $store_list;

        $get_store_type = $this->basic->get_data("ecommerce_store", array("where" => array('id' => $this->session->userdata("ecommerce_selected_store"))), array("store_type"));
        $data['store_type'] = $get_store_type[0]['store_type'];


        $total_rows_array = $this->basic->count_row('ecommerce_product', array('where' => array('store_id' => $this->session->userdata("ecommerce_selected_store"))));

        if (empty($this->session->userdata("package_info")["monthly_limit"])) {
            $total_limit = 0;
        } else {
            $total_limit = json_decode($this->session->userdata("package_info")["monthly_limit"], true);
        }

        if (
            isset($total_limit[4001])
            and $total_limit[4001] != 0
            and $total_rows_array[0]['total_rows'] != 0
            and $total_rows_array[0]['total_rows'] >= $total_limit[4001]
            and $this->session->userdata('user_type') != 'Admin'
        ) {
            echo '<div class="alert border-warning mb-2" role="alert">
            <div class="d-flex align-items-center">
              <i class="bx bx-error-circle"></i>
              <span>' . $this->lang->line("sorry, your bulk limit is exceeded for this module.") . '</span>
            </div>
          </div>';
            $data['body'] = 'clear';
            $data['page_title'] = $this->lang->line('Add Product') . " : " . $this->session->userdata("ecommerce_selected_store_title");
            $data["iframe"] = "1";
            $this->_viewcontroller($data);

        } else {
            $product_lists = $this->get_product_list($this->session->userdata("ecommerce_selected_store"));
            $product_list = $product_lists;
            $product_list[''] = $this->lang->line("Select Product");
            $data['product_list'] = $product_list;
            $data['product_lists'] = $product_lists;

            $category_list = $this->get_category_list();

            $category_list[''] = $this->lang->line("Select Category");
            $data['category_list'] = $category_list;

            $attribute_list = $this->get_attribute_list($this->session->userdata("ecommerce_selected_store"));
            $data['attribute_list'] = $attribute_list;

            $this->is_ecommerce_related_product_addon_exist = false;
            if ($this->basic->is_exist('add_ons', array('unique_name' => 'ecommerce_related_products')) && $this->basic->is_exist("modules", array("id" => 317))) {
                if ($this->session->userdata('user_type') == 'Admin' || in_array(317, $this->module_access)) {
                    $this->is_ecommerce_related_product_addon_exist = true;
                }
            }

            $data['ecommerce_config'] = $this->get_ecommerce_config();
            $data["iframe"] = "1";
            $this->session->unset_userdata('validation_check_attribute_ids');
            $this->_viewcontroller($data);
        }


    }

    public function add_product_action()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
            redirect('home/access_forbidden', 'location');

        if ($_POST) {
            $this->form_validation->set_rules('store_id', '<b>' . $this->lang->line("Store") . '</b>', 'trim|required');
            $this->form_validation->set_rules('product_name', '<b>' . $this->lang->line("Product name") . '</b>', 'trim|required');
            $this->form_validation->set_rules('original_price', '<b>' . $this->lang->line("Original price") . '</b>', 'trim|required|numeric');
            $this->form_validation->set_rules('sell_price', '<b>' . $this->lang->line("Sell price") . '</b>', 'trim|numeric');
            $this->form_validation->set_rules('product_description', '<b>' . $this->lang->line("Product description") . '</b>', 'trim');
            $this->form_validation->set_rules('purchase_note', '<b>' . $this->lang->line("Purchase note") . '</b>', 'trim');
            $this->form_validation->set_rules('thumbnail', '<b>' . $this->lang->line("Thumbnail") . '</b>', 'trim');
            $this->form_validation->set_rules('stock_item', '<b>' . $this->lang->line("Item in stock") . '</b>', 'trim|numeric');
            $this->form_validation->set_rules('product_video_id', '<b>' . $this->lang->line("Product Video") . '</b>', 'trim');

            if ($this->input->post("store_type") == "digital") {
                $this->form_validation->set_rules('product_file', '<b>' . $this->lang->line("Product File") . '</b>', 'trim|required');

            }

            if ($this->form_validation->run() == FALSE) {
                $attribute_ids = $this->input->post('attribute_ids', true);
                $this->session->set_userdata('validation_check_attribute_ids', $attribute_ids);
                $this->add_product();
            } else {
                $attribute_ids = $this->input->post('attribute_ids', true);
                $store_id = $this->input->post('store_id', true);
                $category_id = $this->input->post('category_id', true);
                $attribtue_ids = $this->input->post('attribute_ids', true);
                $product_name = strip_tags($this->input->post('product_name', true));
                $original_price = $this->input->post('original_price', true);
                $sell_price = $this->input->post('sell_price', true);
                $product_description = strip_tags($this->input->post('product_description', true), $this->editor_allowed_tags);
                $purchase_note = strip_tags($this->input->post('purchase_note', true), $this->editor_allowed_tags);
                $thumbnail = $this->input->post('thumbnail', true);
                $featured_images = $this->input->post('featured_images', true);
                $taxable = $this->input->post('taxable', true);
                $status = $this->input->post('status', true);
                $stock_item = $this->input->post('stock_item', true);
                $stock_display = $this->input->post('stock_display', true);
                $stock_prevent_purchase = $this->input->post('stock_prevent_purchase', true);
                $preparation_time = $this->input->post('preparation_time', true);
                $preparation_time_unit = $this->input->post('preparation_time_unit', true);

                $product_file = $this->input->post('product_file', true);
                $store_type = $this->input->post('store_type', true);
                $product_video_id = $this->input->post('product_video_id', true);

                $related_product_ids = $this->input->post('related_product_ids', true);
                $upsell_product_id = $this->input->post('upsell_product_id', true);
                $downsell_product_id = $this->input->post('downsell_product_id', true);
                $is_featured = $this->input->post('is_featured', true);
                if ($upsell_product_id == '') $upsell_product_id = '0';
                if ($downsell_product_id == '') $downsell_product_id = '0';
                if ($is_featured == '') $is_featured = '0';

                if (!isset($related_product_ids) || !is_array($related_product_ids) || empty($related_product_ids))
                    $related_product_ids = '';
                else $related_product_ids = implode(',', $related_product_ids);

                if ($store_type == "physical") {
                    $product_file = '';
                }

                if ($product_description == "<p></p>") $product_description = "";
                if ($purchase_note == "<p></p>") $purchase_note = "";

                if ($status == '') $status = '0';
                if ($taxable == '') $taxable = '0';
                if ($stock_display == '') $stock_display = '0';
                if ($stock_prevent_purchase == '') $stock_prevent_purchase = '0';
                if (!isset($attribute_ids) || !is_array($attribute_ids) || empty($attribute_ids)) $attribute_ids = '';
                else $attribute_ids = implode(',', $attribute_ids);

                if ($stock_item == "") $stock_item = 0;
                if ($stock_display == "") $stock_display = '0';
                if ($stock_prevent_purchase == "") $stock_prevent_purchase = '0';

                $data = array
                (
                    'store_id' => $store_id,
                    'category_id' => $category_id,
                    'attribute_ids' => $attribute_ids,
                    'product_name' => $product_name,
                    'original_price' => $original_price,
                    'sell_price' => $sell_price,
                    'product_description' => $product_description,
                    'product_video_id' => $product_video_id,
                    'purchase_note' => $purchase_note,
                    'thumbnail' => $thumbnail,
                    'featured_images' => $featured_images,
                    'digital_product_file' => $product_file,
                    'taxable' => $taxable,
                    'status' => $status,
                    'stock_item' => $stock_item,
                    'stock_display' => $stock_display,
                    'stock_prevent_purchase' => $stock_prevent_purchase,
                    'preparation_time' => $preparation_time,
                    'preparation_time_unit' => $preparation_time_unit,
                    'user_id' => $this->user_id,
                    'deleted' => '0',
                    'updated_at' => date("Y-m-d H:i:s"),
                    'related_product_ids' => $related_product_ids,
                    'upsell_product_id' => $upsell_product_id,
                    'downsell_product_id' => $downsell_product_id,
                    'is_featured' => $is_featured,
                    'n_wh' => 0,
                );
                // echo "<pre>"; print_r($data); exit;

                if ($this->basic->insert_data('ecommerce_product', $data)) {
                    $product_id = $this->db->insert_id();
                    $this->session->set_flashdata('success_message', 1);
                } else {
                    $product_id = '';
                    $this->session->set_flashdata('error_message', 1);
                }

                $this->sitemap_set_null($store_id);

                if ($this->addon_exist('ecommerce_product_price_variation')) {
                    if ($this->session->userdata('user_type') == 'Admin' || in_array(281, $this->module_access)) {
                        if ($product_id != '') {
                            $insert_data = [];
                            $attribute_ids_array = explode(',', $attribute_ids);
                            foreach ($attribute_ids_array as $attribute_id) {
                                $attribute_values_info = $this->basic->get_data('ecommerce_attribute', ['where' => ['id' => $attribute_id, 'user_id' => $this->user_id]]);
                                $attribute_values = isset($attribute_values_info[0]['attribute_values']) ? json_decode($attribute_values_info[0]['attribute_values'], true) : [];
                                $attribute_option_name = isset($attribute_values_info[0]['attribute_name']) ? $attribute_values_info[0]['attribute_name'] : '';
                                $insert_data['attribute_id'] = $attribute_id;
                                $insert_data['product_id'] = $product_id;
                                foreach ($attribute_values as $key => $value) {
                                    $insert_data['attribute_option_name'] = $value;
                                    $variable_amount = "single_attribute_values_" . $attribute_id . "_" . $key;
                                    $variable_indicator = "single_attribute_names_" . $attribute_id . "_" . $key;
                                    $insert_data['amount'] = $this->input->post($variable_amount, true);
                                    $insert_data['price_indicator'] = $this->input->post($variable_indicator, true);
                                    $this->basic->insert_data('ecommerce_attribute_product_price', $insert_data);
                                }
                            }
                        }
                    }
                }


                redirect('ecommerce/product_list', 'location');

            }
        }
    }

    public function upload_category_thumb()
    {
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = APPPATH . '../upload/ecommerce';

        // Makes upload directory
        if (!file_exists($upload_dir)) {
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

                $allow_ext = ['png', 'jpg', 'jpeg'];
                if (!in_array(strtolower($ext), $allow_ext)) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = "category_" . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (!@move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                // Sets filename to session
                $this->session->set_userdata('category_thumb_uploaded_file', $filename);

                // Returns response
                echo json_encode(['filename' => $filename]);
            }
        }
    }

    public function upload_featured_image()
    {
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = APPPATH . '../upload/ecommerce';

        // Makes upload directory
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > 2 * 1024 * 1024) {
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

                $allow_ext = ['png', 'jpg', 'jpeg'];
                if (!in_array(strtolower($ext), $allow_ext)) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = "fproduct_" . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (!@move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                // Returns response
                echo json_encode(['filename' => $filename]);
            }
        }
    }

    public function ajax_create_new_category()
    {
        $this->ajax_check();
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));

        if ($_POST) {
            $category_name = strip_tags($this->input->post("category_name", true));
            $store_id = $this->input->post("store_id", true);
            $desc = $this->input->post("desc", true);
            $thumbnail = $this->input->post('thumbnail', true);

            $status = $this->input->post("status", true);
            if (!isset($status) || $status == '') $status = '0';

            $inserted_data = array
            (
                "store_id" => $store_id,
                "category_name" => $category_name,
                "status" => $status,
                "user_id" => $this->user_id,
                "thumbnail" => $thumbnail,
                "updated_at" => date("Y-m-d H:i:s"),
                "description" => $desc,
            );

            if ($this->basic->insert_data("ecommerce_category", $inserted_data)) {
                $result['status'] = "1";
                $result['message'] = $this->lang->line("Category has been added successfully.");
            }

            $this->sitemap_set_null($store_id);

            echo json_encode($result);

        }
    }

    public function ajax_get_category_update_info()
    {

        $this->ajax_check();

        $table_id = $this->input->post("table_id");
        $user_id = $this->user_id;

        if ($table_id == "0" || $table_id == "") exit;

        $details = $this->basic->get_data("ecommerce_category", array('where' => array('id' => $table_id, 'user_id' => $user_id)));
        $selected = ($details[0]['status'] == '1') ? 'checked' : '';

        $store_list = $this->get_store_list();
        $store_list[''] = $this->lang->line("Store");

        $form = '<div class="row">
  <div class="col-12">                    
  <form action="#" enctype="multipart/form-data" id="row_update_form" method="post">
  <input type="hidden" name="table_id" value="' . $table_id . '">
  <div class="row">
  <div class="col-12 d-none">
  <div class="form-group">
  <label for="name">' . $this->lang->line("Store") . ' *</label>
  ' . form_dropdown('', $store_list, $details[0]['store_id'], ' style="width:100%;" disabled class="form-control seelct"') . '
  </div>
  </div>
  <div class="col-12">
  <div class="form-group">
  <label>' . $this->lang->line('Category Name') . ' *</label>
  <input type="text" class="form-control" name="category_name2" id="category_name2" value="' . $details[0]['category_name'] . '">
  </div>
  </div>
  <div class="col-12">
  <div class="form-group">
  <label class="custom-switch mt-2">
  <input type="checkbox" name="status2" id="status2" value="1" class="custom-switch-input" ' . $selected . '>
  <span class="custom-switch-indicator"></span>
  <span class="custom-switch-description">' . $this->lang->line('Active') . '</span>
  </label>
  </div>
  </div>
                                  <div class="col-12">
                                    <div class="form-group">
                                        <label>' . $this->lang->line('Category Description') . ' *</label>
                                        <textarea class="form-control" name="desc" id="desc' . $details[0]['id'] . '">' . $details[0]['description'] . '</textarea>
                                    </div>
                                </div>
  <div class="col-12">
  <div class="form-group">
  <label>' . $this->lang->line('Thumbnail') . ' 
  <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Thumbnail") . '" data-content="' . $this->lang->line("Maximum: 500KB, Format: JPG/PNG, Preference: Square image, Recommended dimension : 100x100") . '"><i class="fa fa-info-circle"></i> </a>
  </label>
  <div id="thumb-dropzone2" class="dropzone mb-1">
  <div class="dz-default dz-message">
  <input class="form-control" name="thumbnail2" id="uploaded-file2" type="hidden">
  <span style="font-size: 20px;"><i class="fas fa-cloud-upload-alt" style="font-size: 35px;color: #6777ef;"></i> ' . $this->lang->line('Upload') . '</span>
  </div>
  </div>
  <span class="red">' . form_error('thumbnail2') . '</span>
  </div>
  </div>
  </div>
  </form>
  </div>
  </div>';
        echo $form;
        echo "<script>
  $(document).ready(function() {
    var uploaded_file2 = $('#uploaded-file2');
    

            function delete_uploaded_file2(filename) {
              if('' !== filename) {     
                $.ajax({
                  type: 'POST',
                  dataType: 'JSON',
                  data: { filename },
                  url: '" . base_url('ecommerce/delete_category_thumb') . "',
                  success: function(data) {
                    $('#uploaded-file2').val('');
                  }
                  });
                }
                empty_form_values2();     
              }

              function empty_form_values2() {
                $('#thumb-dropzone2 .dz-preview').remove();
                $('#thumb-dropzone2').removeClass('dz-started dz-max-files-reached');
                Dropzone.forElement('#thumb-dropzone2').removeAllFiles(true);
              }   
              });
              </script>";
    }

    public function ajax_update_category()
    {
        $this->ajax_check();
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));

        if ($_POST) {
            $table_id = $this->input->post("table_id", true);
            $category_name = strip_tags($this->input->post("category_name2", true));
            $thumbnail = $this->input->post("thumbnail2", true);
            $desc = $this->input->post("desc", true);

            $status = $this->input->post("status2", true);
            if (!isset($status) || $status == '') $status = '0';

            $updated_data = array
            (
                "category_name" => $category_name,
                "status" => $status,
                "updated_at" => date("Y-m-d H:i:s"),
                "description" => $desc,
            );
            if ($thumbnail != '') {
                $updated_data['thumbnail'] = $thumbnail;
                // if($xthumbnail!='') @unlink('upload/ecommerce/'.$xthumbnail);
            }

            if ($this->basic->update_data("ecommerce_category", array("id" => $table_id, "user_id" => $this->user_id), $updated_data)) {
                $result['status'] = "1";
                $result['message'] = $this->lang->line("Category has been updated successfully.");
            }

            $store_data = $this->basic->get_data("ecommerce_category", array("where" => array("id" => $table_id)));

            if (!empty($store_data[0]['store_id'])) {
                $this->sitemap_set_null($store_data[0]['store_id']);
            }

            echo json_encode($result);

        }
    }

    public function update_cart_item_checkout()
    {
        $this->ajax_check();
        $id = $this->input->post("id", true);
        $cart_id = $this->input->post("cart_id", true);
        $action = $this->input->post("action", true);
        $n_quantity = intval($this->input->post("quantity", true));

        $where_simple = array("id" => $id, "cart_id" => $cart_id);
        $where = array('where' => $where_simple);
        $product_data = $this->basic->get_data("ecommerce_cart_item", $where);
        if (!isset($product_data[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Product not found.")));
            exit();
        }

        $where_simple = array("ecommerce_product.id" => $product_data[0]['product_id'], "ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
        $select = array("ecommerce_product.*", "store_unique_id", "store_locale");
        $product_data = $this->basic->get_data("ecommerce_product", $where, $select, $join);
        if (!isset($product_data[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Product not found.")));
            exit();
        }


        $stock_item = $product_data[0]['stock_item'];
        $stock_prevent_purchase = $product_data[0]['stock_prevent_purchase'];

        if ($action == 'add') {
            $n_quantity_check = $n_quantity + 1;
        } else {
            $n_quantity_check = $n_quantity - 1;
        }

        if ($stock_prevent_purchase == '1' && $stock_item < $n_quantity_check) {
            $curdate = date("Y-m-d H:i:s");
            $what_action = $action == 'add' ? 'quantity=' . ($stock_item) : 'quantity=' . ($stock_item);
            $sql = "UPDATE ecommerce_cart_item SET " . $what_action . ",updated_at='$curdate' WHERE cart_id='$cart_id' AND id='$id'; ";
            $this->basic->execute_complex_query($sql);

            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Sorry, this item is out of stock.") . '<br />' . $this->lang->line("Available in stock: ") . ' ' . $stock_item, 'quantity' => $n_quantity));

            exit();
        }

        $curdate = date("Y-m-d H:i:s");
        $what_action = $action == 'add' ? 'quantity=' . ($n_quantity + 1) : 'quantity=' . ($n_quantity - 1);
        $sql = "UPDATE ecommerce_cart_item SET " . $what_action . ",updated_at='$curdate' WHERE cart_id='$cart_id' AND id='$id'; ";
        $this->basic->execute_complex_query($sql);
        echo json_encode(array('status' => '1'));
    }

    public function update_cart_item_checkout_input()
    {
        $this->ajax_check();
        $id = $this->input->post("id", true);
        $cart_id = $this->input->post("cart_id", true);
        //$action = $this->input->post("action",true);
        $n_quantity = intval($this->input->post("quantity", true));

        $where_simple = array("id" => $id, "cart_id" => $cart_id);
        $where = array('where' => $where_simple);
        $product_data = $this->basic->get_data("ecommerce_cart_item", $where);
        if (!isset($product_data[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Product not found.")));
            exit();
        }

        $where_simple = array("ecommerce_product.id" => $product_data[0]['product_id'], "ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
        $select = array("ecommerce_product.*", "store_unique_id", "store_locale");
        $product_data = $this->basic->get_data("ecommerce_product", $where, $select, $join);
        if (!isset($product_data[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Product not found.")));
            exit();
        }

        $stock_item = $product_data[0]['stock_item'];
        $stock_prevent_purchase = $product_data[0]['stock_prevent_purchase'];

        if ($action == 'add') {
            $n_quantity_check = $n_quantity + 1;
        } else {
            $n_quantity_check = $n_quantity - 1;
        }

        if ($stock_prevent_purchase == '1' && $stock_item < $n_quantity_check) {
            $curdate = date("Y-m-d H:i:s");
            $what_action = $action == 'add' ? 'quantity=' . ($stock_item) : 'quantity=' . ($stock_item);
            $sql = "UPDATE ecommerce_cart_item SET " . $what_action . ",updated_at='$curdate' WHERE cart_id='$cart_id' AND id='$id'; ";
            $this->basic->execute_complex_query($sql);

            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Sorry, this item is out of stock.") . '<br />' . $this->lang->line("Available in stock: ") . ' ' . $stock_item, 'quantity' => $n_quantity));
            exit();
        }

        $where_simple = array("id" => $id, "cart_id" => $cart_id);
        $where = array('where' => $where_simple);
        $product_data = $this->basic->get_data("ecommerce_cart_item", $where);
        if (!isset($product_data[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Product not found.")));
            exit();
        }


        $where_simple = array("ecommerce_product.id" => $product_data[0]['product_id'], "ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
        $select = array("ecommerce_product.*", "store_unique_id", "store_locale");
        $product_data = $this->basic->get_data("ecommerce_product", $where, $select, $join);
        if (!isset($product_data[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Product not found.")));
            exit();
        }

        $stock_item = $product_data[0]['stock_item'];
        $stock_prevent_purchase = $product_data[0]['stock_prevent_purchase'];

        if ($stock_prevent_purchase == '1' && $stock_item < $n_quantity) {
            $curdate = date("Y-m-d H:i:s");
            $what_action = $action == 'add' ? 'quantity=' . ($stock_item) : 'quantity=' . ($stock_item);
            $sql = "UPDATE ecommerce_cart_item SET " . $what_action . ",updated_at='$curdate' WHERE cart_id='$cart_id' AND id='$id'; ";
            $this->basic->execute_complex_query($sql);

            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Sorry, this item is out of stock.") . '<br />' . $this->lang->line("Available in stock: ") . ' ' . $stock_item, 'quantity' => $n_quantity));
            exit();
        }


        $curdate = date("Y-m-d H:i:s");
        $what_action = 'quantity=' . $n_quantity;
        $sql = "UPDATE ecommerce_cart_item SET " . $what_action . ",updated_at='$curdate' WHERE cart_id='$cart_id' AND id='$id'; ";
        $this->basic->execute_complex_query($sql);
        echo json_encode(array('status' => '1'));
    }

    public function update_cart_item()
    {
        $this->ajax_check();
        $mydata = json_decode($this->input->post("mydata"), true);
        $product_id = isset($mydata['product_id']) ? $mydata['product_id'] : 0;
        $action = isset($mydata['action']) ? $mydata['action'] : 'add';  // add,remove
        $pickup = isset($mydata['pickup']) ? $mydata['pickup'] : '';
        $n_quantity = isset($mydata['quantity']) ? $mydata['quantity'] : '';
        if (empty($n_quantity)) {
            $n_quantity = 1;
        }


        $where_simple = array("ecommerce_product.id" => $product_id, "ecommerce_product.status" => "1", "ecommerce_store.status" => "1");
        $where = array('where' => $where_simple);
        $join = array('ecommerce_store' => "ecommerce_product.store_id=ecommerce_store.id,left");
        $select = array("ecommerce_product.*", "store_unique_id", "store_locale");
        $product_data = $this->basic->get_data("ecommerce_product", $where, $select, $join);
        if (!isset($product_data[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Product not found.")));
            exit();
        }
        $this->_language_loader($product_data[0]['store_locale']);

        /*Added by Konok 23.10.2020 for system outside Messenger*/
        $where_subs = array();
        $subscriber_id = $this->session->userdata($product_data[0]['store_id'] . "ecom_session_subscriber_id");
        if ($subscriber_id != "") $where_subs = array("subscriber_type" => "system", "subscribe_id" => $subscriber_id, "store_id" => $product_data[0]['store_id']);
        else {
            if ($subscriber_id == "") $subscriber_id = isset($mydata['subscriber_id']) ? $mydata['subscriber_id'] : '';
            if ($subscriber_id != "") $where_subs = array("subscriber_type!=" => "system", "subscribe_id" => $subscriber_id);
        }
//        if($subscriber_id=='')
//        {
//            echo json_encode(array('status'=>'0','message'=>$this->login_to_continue,'login_popup'=>'1'));
//            exit();
//        }

        $this->nstore_id = $this->get_store_uq($product_data[0]['store_id']);

        if (!empty($subscriber_id) and !empty($this->session->userdata($this->nstore_id . '_temp_cart'))) {
            $insert_subscriber_id = $this->session->userdata($this->nstore_id . '_temp_cart');
            $update_data = array
            (
                "subscriber_id" => $subscriber_id
            );
            $this->basic->update_data("ecommerce_cart", array("subscriber_id" => $insert_subscriber_id), $update_data);
            $this->session->set_userdata($this->nstore_id . '_temp_cart', null);
        }

        if (empty($subscriber_id)) {
            if (!empty($this->session->userdata($this->nstore_id . '_temp_cart'))) {
                $insert_subscriber_id = $this->session->userdata($this->nstore_id . '_temp_cart');
            } else {
                $insert_subscriber_id = "anon-guest-" . time() . $this->_random_number_generator(6);
                $this->session->set_userdata($this->nstore_id . '_temp_cart', $insert_subscriber_id);
            }
        } else {
            $subscriber_info = $this->basic->get_data("messenger_bot_subscriber", array("where" => $where_subs), array("id", "email", "phone_number"), "", 1);
            $insert_subscriber_id = $subscriber_id;
        }

//
//        if(count($subscriber_info) == 0){
//            echo json_encode(array('status'=>'0','message'=>$this->login_to_continue,'login_popup'=>'1'));
//            exit();
//        }

        $attribute_info = isset($mydata['attribute_info']) ? $mydata['attribute_info'] : array();
        $attribute_info = array_filter($attribute_info);
        $attribute_info_json = json_encode($attribute_info, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $attribute_info_json2 = json_encode($attribute_info, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $message = $cart_url = "";

        $stock_item = $product_data[0]['stock_item'];
        $stock_prevent_purchase = $product_data[0]['stock_prevent_purchase'];

        if ($stock_prevent_purchase == '1' && $stock_item == 0 && $action == 'add') {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Sorry, this item is out of stock. We are not taking any order right now.")));
            exit();
        }

        $store_id = $product_data[0]['store_id'];
        $user_id = $product_data[0]['user_id'];
        $original_price = $product_data[0]['original_price'];
        $sell_price = $product_data[0]['sell_price'];
        $store_unique_id = $product_data[0]['store_unique_id'];
        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
        $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
        $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;

        $buyer_email = isset($subscriber_info[0]['email']) ? $subscriber_info[0]['email'] : "";
        $buyer_phone = isset($subscriber_info[0]['phone_number']) ? $subscriber_info[0]['phone_number'] : "";

        // price calculation based on attribute values
        $calculated_price_info = $this->calculate_price_basedon_attribute($product_id, $attribute_info, $original_price, $sell_price);
        $original_price = $calculated_price_info['calculated_original_price'];
        $sell_price = $calculated_price_info['calculated_sell_price'];

        $price = mec_display_price($original_price, $sell_price, '', '2', $currency_position, $decimal_point, '0');

        $cart_data = $this->basic->get_data("ecommerce_cart", array('where' => array("ecommerce_cart.subscriber_id" => $insert_subscriber_id, "ecommerce_cart.store_id" => $store_id, "action_type!=" => "checkout")));

        $cart_item_data = array();
        if (isset($cart_data[0])) // already have a cart running entry
        {
            $cart_id = isset($cart_data[0]['id']) ? $cart_data[0]['id'] : 0;
            $cart_item_data = $this->basic->get_data("ecommerce_cart_item", array("where" => array("cart_id" => $cart_id)));

            if ($action == "add") {
                $update_cart = [];
                if ($cart_data[0]["buyer_email"] == "") $update_cart['buyer_email'] = $buyer_email;
                if ($cart_data[0]["buyer_mobile"] == "") $update_cart['buyer_mobile'] = $buyer_phone;
                if (!empty($update_cart))
                    $this->basic->update_data('ecommerce_cart', array('id' => $cart_id, 'store_id' => $store_id, 'subscriber_id' => $subscriber_id), $update_cart);
            }
        }

        if (!isset($cart_data[0]) && $action == "remove") // no cart, no removing, securty in case
        {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("Cart not found.")));
            exit();
        }

        $curdate = date("Y-m-d H:i:s");
        if ($action == 'add') // add item
        {
            if (!isset($cart_data[0])) // new cart, create cart first
            {
                $insert_data = array
                (
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'subscriber_id' => $insert_subscriber_id,
                    'currency' => $currency,
                    'status' => "pending",
                    'ordered_at' => $curdate,
                    'payment_method' => '',
                    'updated_at' => $curdate,
                    'initial_date' => $curdate,
                    'confirmation_response' => '[]',
                    'buyer_email' => $buyer_email,
                    'buyer_mobile' => $buyer_phone
                );
                $this->basic->insert_data("ecommerce_cart", $insert_data);
                $cart_id = $this->db->insert_id();
            }

            if ($stock_prevent_purchase == '1' && $stock_item < $n_quantity) {
                echo json_encode(array('status' => '0', 'message' => $this->lang->line("Sorry, this item is out of stock.") . '<br />' . $this->lang->line("Available in stock: ") . ' ' . $stock_item));
                exit();
            }


            if (strpos($attribute_info_json, "'") !== false) $attribute_info_json = addslashes($attribute_info_json);

            $sql = "INSERT INTO ecommerce_cart_item
        (
        store_id,cart_id,product_id,unit_price,quantity,attribute_info,updated_at
        ) 
        VALUES 
        (
        '$store_id','$cart_id','$product_id','$price','$n_quantity','$attribute_info_json','$curdate'
        )
        ON DUPLICATE KEY UPDATE 
        unit_price='$price',quantity='$n_quantity',updated_at='$curdate'; ";
            $this->basic->execute_complex_query($sql);
            // echo $this->db->last_query();

            $message = $this->lang->line("Product has been added to cart successfully.");
        } else // remove item
        {

            if ($stock_prevent_purchase == '1' && $stock_item < $n_quantity) {
                $n_quantity = $stock_item;
            }


            if (strpos($attribute_info_json, "'") !== false) $attribute_info_json = addslashes($attribute_info_json);
            $sql = "UPDATE ecommerce_cart_item SET unit_price='$price',quantity='$n_quantity',updated_at='$curdate' WHERE cart_id='$cart_id' AND product_id='$product_id' AND attribute_info='$attribute_info_json'; ";
            $this->basic->execute_complex_query($sql);
            $message = $this->lang->line("Product has been removed from cart successfully.");
        }

        $this_cart_item = array("quantity" => "1");
        if (!empty($attribute_info)) {
            $this_cart_item_data = $this->basic->get_data("ecommerce_cart_item", array("where" => array("cart_id" => $cart_id, "product_id" => $product_id, "attribute_info" => $attribute_info_json2)), "quantity");
            if (isset($this_cart_item_data[0])) $this_cart_item = $this_cart_item_data[0];
        } else {
            $this_cart_item_data = $this->basic->get_data("ecommerce_cart_item", array("where" => array("cart_id" => $cart_id, "product_id" => $product_id)), "quantity");
            if (isset($this_cart_item_data[0])) $this_cart_item = $this_cart_item_data[0];
        }

        $cart_url = base_url("ecommerce/cart/" . $cart_id);
        $cart_url = mec_add_get_param($cart_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
        $current_cart_data = $this->get_current_cart($insert_subscriber_id, $store_id, $pickup);
        $this->session->set_userdata($this->nstore_id . '_temp_cart', $insert_subscriber_id);
        echo json_encode(array('status' => '1', 'cart_url' => $cart_url, 'message' => $message, "cart_data" => $current_cart_data, "this_cart_item" => $this_cart_item));
    }

    public function update_cart($cart_id = 0, $subscriber_id_passed = '')
    {
        if ($subscriber_id_passed == '') $subscriber_id = $this->input->get_post("subscriber_id");
        else $subscriber_id = $subscriber_id_passed;

        if ($cart_id != 0 && $subscriber_id != '') {
            $cart_data = $this->valid_cart_data($cart_id, $subscriber_id);
            if (isset($cart_data[0])) {
                if ($cart_data[0]["store_unique_id"] != "") // store availabe and online
                {
                    $store_id = $cart_data[0]['store_id'];
                    $user_id = $cart_data[0]['user_id'];

                    $ecommerce_config = $this->get_ecommerce_config($store_id);
                    $currency = isset($ecommerce_config["currency"]) ? $ecommerce_config["currency"] : "USD";
                    $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
                    $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
                    $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
                    $currency_icons = $this->get_country_new('currecny_icon');
                    $currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : '$';

                    $coupon_code = $cart_data[0]['coupon_code'];
                    $tax_percentage = $cart_data[0]['tax_percentage'];
                    $shipping_charge = $cart_data[0]['shipping_charge'];
                    $store_pickup = $cart_data[0]['store_pickup'];

                    $product_list = $this->get_product_list_array($store_id);
                    $cart_item_data = $this->basic->get_data("ecommerce_cart_item", array('where' => array("cart_id" => $cart_id)));

                    $product_list_assoc = array();
                    $cart_item_data_assoc = array();

                    foreach ($product_list as $key => $value) {
                        $product_list_assoc[$value["id"]] = $value;
                    }

                    // foreach($cart_item_data as $key => $value)
                    // {
                    //   $cart_item_data_assoc[$value["product_id"]] = $value;
                    // }
                    // $cart_item_data_new = $cart_item_data_assoc;

                    $coupon_data = array();
                    if ($coupon_code != '') $coupon_data = $this->get_coupon_data($coupon_code, $store_id);
                    $coupon_product_ids = isset($coupon_data["product_ids"]) ? $coupon_data["product_ids"] : '0';
                    $coupon_product_ids_array = array_filter(explode(',', $coupon_product_ids));
                    $free_shipping_enabled = isset($coupon_data["free_shipping_enabled"]) ? $coupon_data["free_shipping_enabled"] : "0";
                    if ($store_pickup == '1') $free_shipping_enabled = '1';
                    $coupon_type = isset($coupon_data["coupon_type"]) ? $coupon_data["coupon_type"] : "";
                    $coupon_amount = isset($coupon_data["coupon_amount"]) ? $coupon_data["coupon_amount"] : 0;
                    $coupon_code_new = isset($coupon_data["coupon_code"]) ? $coupon_data["coupon_code"] : '';

                    $subtotal = 0;
                    $taxable_amount = 0;
                    $discount = 0;
                    $tax = 0;
                    $shipping = 0;
                    foreach ($cart_item_data as $key => $value) {
                        $product_id = $value['product_id'];
                        if (array_key_exists($product_id, $product_list_assoc)) {

                            $attribute_info = json_decode($value['attribute_info'], true);
                            $calculated_price_info = $this->calculate_price_basedon_attribute($product_id, $attribute_info, $product_list_assoc[$product_id]["original_price"], $product_list_assoc[$product_id]["sell_price"]);

                            $original_price = $calculated_price_info['calculated_original_price'];
                            $sell_price = $calculated_price_info['calculated_sell_price'];
                            $new_price = mec_display_price($original_price, $sell_price, '', '2', $currency_position, $decimal_point, '0');

                            $coupon_info = "";

                            if (!empty($coupon_data) && $coupon_amount > 0 && ($coupon_product_ids == "0" || in_array($product_id, $coupon_product_ids_array))) {
                                $new_price = $original_price;

                            if($coupon_data['coupon_apply']=='no_discount_sale' AND $sell_price!=$original_price){
                                $new_price = mec_number_format($new_price, $decimal_point, '0');
                                if($sell_price!=$original_price){
                                    $new_price = $sell_price;
                                }
                            }else{

                                switch($coupon_data['coupon_apply']){
                                    case 'sale_price';
                                        if($sell_price!=$original_price){
                                            $new_price = $sell_price;
                                        }
                                        break;

                                    case 'original_price';
                                        $new_price = $original_price;
                                        break;
                                }

                                $new_price = mec_number_format($new_price, $decimal_point, '0');
                                if ($coupon_type == "percent") {
                                    $disc = ($new_price * $coupon_amount) / 100;
                                    if ($disc < 0) $disc = 0;
                                    $disc = mec_number_format($disc, $decimal_point, '0');

                                    $discount += $disc * $value["quantity"];
                                    $discount = mec_number_format($discount, $decimal_point, '0');

                                    $coupon_info = $coupon_amount . "%";

                                    $new_price = $new_price - $disc;
                                } else if ($coupon_type == "fixed product") {
                                    $new_price = $new_price - $coupon_amount;
                                    if ($new_price < 0) $new_price = 0;
                                    $coupon_info = $currency_icon . $coupon_amount;
                                    $discount += $coupon_amount * $value["quantity"];
                                    $discount = mec_number_format($discount, $decimal_point, '0');
                                }
                                $new_price = mec_number_format($new_price, $decimal_point, '0');
                            }

                            }


                            if ($new_price != mec_number_format($value['unit_price'], $decimal_point, '0'))
                                $this->basic->update_data("ecommerce_cart_item", array("id" => $value['id']), array("unit_price" => $new_price, "coupon_info" => $coupon_info));

                            $total_price = $new_price * $value["quantity"];
                            $subtotal += $total_price;

                            if ($product_list_assoc[$product_id]["taxable"] == '1') $taxable_amount += $new_price * $value["quantity"];
                        } else {
                            $this->basic->delete_data("ecommerce_cart_item", array("id" => $value['id']));
                        }
                    }
                    $subtotal = mec_number_format($subtotal, $decimal_point, '0');

                    if ($tax_percentage > 0) {
                        $tax = ($tax_percentage * $taxable_amount) / 100;
                        $tax = mec_number_format($tax, $decimal_point, '0');
                    }
                    if ($free_shipping_enabled == '0') $shipping = mec_number_format($shipping_charge, $decimal_point, '0');
                    $payment_amount = $subtotal + $shipping + $tax;

                    if (!empty($coupon_data) && $coupon_amount > 0 && $coupon_type == "fixed cart") {
                        $discount = $coupon_amount;
                        $discount = mec_number_format($discount, $decimal_point, '0');
                        $payment_amount = $payment_amount - $discount;
                        if ($payment_amount < 0) $payment_amount = 0;
                    }
                    $payment_amount = mec_number_format($payment_amount, $decimal_point, '0');

                    //$this->basic->delete_data("ecommerce_cart",array("subscriber_id"=>$subscriber_id, 'id != '.$cart_id));

                    $update_data = array
                    (
                        "subtotal" => $subtotal,
                        "tax" => $tax,
                        "shipping" => $shipping,
                        "coupon_code" => $coupon_code_new,
                        "discount" => $discount,
                        "coupon_type" => $coupon_type,
                        "payment_amount" => $payment_amount,
                        "currency" => $currency,
                        "subscriber_id" => $subscriber_id
                    );
                    $this->basic->update_data("ecommerce_cart", array("id" => $cart_id), $update_data);
                    $this->session->set_userdata($this->nstore_id . '_temp_cart', null);
                } else // store not availabe anymore, delete cart
                {
                    $this->basic->delete_data("ecommerce_cart", array("id" => $cart_id));
                    $this->basic->delete_data("ecommerce_cart_item", array("cart_id" => $cart_id));
                }
            }
        }

    }

    public function generate_sitemap($per_query = 30, $api_key = '')
    {
        if (empty($api_key)) {
        }

        $xdata = $this->basic->get_data("n_custom_domain", array("where" => array("sitemap" => 0)), '*', '', $per_query);

        if (!isset($xdata[0])) {
            exit();
        }

        foreach ($xdata as $k => $v) {
            $txt = '';
            $txt .= 'https://' . $v['host_url'] . "\r\n";

            $cdata = $this->basic->get_data("ecommerce_category", array("where" => array("store_id" => $v['custom_id'])));
            if (!empty($cdata[0])) {
                foreach ($cdata as $ck => $cv) {
                    $txt .= 'https://' . $v['host_url'] . "/category/" . $cv['id'] . '_' . url_title($cv['category_name']) . "\r\n";
                }

            }

            $pdata = $this->basic->get_data("ecommerce_product", array("where" => array("store_id" => $v['custom_id'])));
            if (!empty($pdata[0])) {
                foreach ($pdata as $pk => $pv) {
                    $txt .= 'https://' . $v['host_url'] . "/product/" . $pv['id'] . '_' . url_title($pv['product_name']) . "\r\n";
                }

            }

            file_put_contents(APPPATH . '/n_eco_user/sitemap_' . $this->get_store_uq($v['custom_id']) . '.txt', $txt, LOCK_EX);

            $this->basic->update_data("n_custom_domain", array("id" => $v['id']), array('sitemap' => 1));
        }


    }

    public function robots()
    {
        $sitemap_exist = false;

        $sitemap_exist = file_exists(APPPATH . '/n_eco_user/sitemap_' . $this->nstore_id . '.txt');

        if ($sitemap_exist) {
            echo 'Sitemap: ' . base_url() . 'sitemap.txt';
        } else {
            echo $this->lang->line('Not found');
        }

    }

    public function sitemap()
    {
        $sitemap_exist = false;

        $sitemap_exist = file_exists(APPPATH . '/n_eco_user/sitemap_' . $this->nstore_id . '.txt');

        if ($sitemap_exist) {
            include(APPPATH . '/n_eco_user/sitemap_' . $this->nstore_id . '.txt');
        } else {
            echo $this->lang->line('Not found');
        }

    }

    private function sitemap_set_null($store_id)
    {
        $this->basic->update_data("n_custom_domain", array("custom_id" => $store_id), array('sitemap' => 0));
    }

    public function edit_product_action()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
            redirect('home/access_forbidden', 'location');

        if ($_POST) {
            $id = $this->input->post('hidden_id', true);
            // $this->form_validation->set_rules('store_id', '<b>'.$this->lang->line("Store").'</b>', 'trim|required');
            $this->form_validation->set_rules('product_name', '<b>' . $this->lang->line("Product name") . '</b>', 'trim|required');
            $this->form_validation->set_rules('original_price', '<b>' . $this->lang->line("Original price") . '</b>', 'trim|required|numeric');
            $this->form_validation->set_rules('sell_price', '<b>' . $this->lang->line("Sell price") . '</b>', 'trim|numeric');
            $this->form_validation->set_rules('product_description', '<b>' . $this->lang->line("Product description") . '</b>', 'trim');
            $this->form_validation->set_rules('purchase_note', '<b>' . $this->lang->line("Purchase note") . '</b>', 'trim');
            $this->form_validation->set_rules('thumbnail', '<b>' . $this->lang->line("Thumbnail") . '</b>', 'trim');
            $this->form_validation->set_rules('stock_item', '<b>' . $this->lang->line("Item in stock") . '</b>', 'trim|numeric');
            $this->form_validation->set_rules('product_video_id', '<b>' . $this->lang->line("Product") . '</b>', 'trim');

            if ($this->input->post("store_type") == "digital" && $this->input->post("product_file") == '') {
                $this->form_validation->set_rules('product_file', '<b>' . $this->lang->line("Product File") . '</b>', 'trim|required');

            }


            if ($this->form_validation->run() == FALSE) {
                $this->edit_product($id);
            } else {
                $xdata = $this->basic->get_data("ecommerce_product", array('where' => array('id' => $id, "user_id" => $this->user_id)));
                $xthumbnail = isset($xdata[0]['thumbnail']) ? $xdata[0]['thumbnail'] : "";
                $xfeatured_images = isset($xdata[0]['featured_images']) ? $xdata[0]['featured_images'] : "";
                $xdigital_product_file = isset($xdata[0]['digital_product_file']) ? $xdata[0]['digital_product_file'] : "";

                // $store_id=$this->input->post('store_id',true);
                $category_id = $this->input->post('category_id', true);
                $attribute_ids = $this->input->post('attribute_ids', true);
                $product_name = strip_tags($this->input->post('product_name', true));
                $original_price = $this->input->post('original_price', true);
                $sell_price = $this->input->post('sell_price', true);
                $product_description = strip_tags($this->input->post('product_description', true), $this->editor_allowed_tags);
                $purchase_note = strip_tags($this->input->post('purchase_note', true), $this->editor_allowed_tags);
                $thumbnail = $this->input->post('thumbnail', true);
                $featured_images = $this->input->post('featured_images', true);
                $product_file = $this->input->post('product_file', true);
                $taxable = $this->input->post('taxable', true);
                $status = $this->input->post('status', true);
                $stock_item = $this->input->post('stock_item', true);
                $stock_display = $this->input->post('stock_display', true);
                $stock_prevent_purchase = $this->input->post('stock_prevent_purchase', true);
                $preparation_time = $this->input->post('preparation_time', true);
                $preparation_time_unit = $this->input->post('preparation_time_unit', true);
                $product_video_id = $this->input->post('product_video_id', true);

                $related_product_ids = $this->input->post('related_product_ids', true);
                $upsell_product_id = $this->input->post('upsell_product_id', true);
                $downsell_product_id = $this->input->post('downsell_product_id', true);
                $is_featured = $this->input->post('is_featured', true);
                if ($upsell_product_id == '') $upsell_product_id = '0';
                if ($downsell_product_id == '') $downsell_product_id = '0';
                if ($is_featured == '') $is_featured = '0';

                if (!isset($related_product_ids) || !is_array($related_product_ids) || empty($related_product_ids))
                    $related_product_ids = '';
                else $related_product_ids = implode(',', $related_product_ids);

                $store_type = $this->input->post("store_type", true);

                if ($store_type == "physical") {
                    $product_file = '';
                }

                if ($product_description == "<p></p>") $product_description = "";
                if ($purchase_note == "<p></p>") $purchase_note = "";

                if ($status == '') $status = '0';
                if ($taxable == '') $taxable = '0';
                if ($stock_display == '') $stock_display = '0';
                if ($stock_prevent_purchase == '') $stock_prevent_purchase = '0';
                if (!isset($attribute_ids) || !is_array($attribute_ids) || empty($attribute_ids)) $attribute_ids = '';
                else $attribute_ids = implode(',', $attribute_ids);

                $data = array
                (
                    'category_id' => $category_id,
                    'attribute_ids' => $attribute_ids,
                    'product_name' => $product_name,
                    'original_price' => $original_price,
                    'sell_price' => $sell_price,
                    'product_description' => $product_description,
                    'purchase_note' => $purchase_note,
                    'taxable' => $taxable,
                    'status' => $status,
                    'stock_item' => $stock_item,
                    'stock_display' => $stock_display,
                    'stock_prevent_purchase' => $stock_prevent_purchase,
                    'preparation_time' => $preparation_time,
                    'preparation_time_unit' => $preparation_time_unit,
                    'updated_at' => date("Y-m-d H:i:s"),
                    'related_product_ids' => $related_product_ids,
                    'upsell_product_id' => $upsell_product_id,
                    'downsell_product_id' => $downsell_product_id,
                    'is_featured' => $is_featured,
                    'product_video_id' => $product_video_id,
                    'n_wh' => 0,
                );
                if ($thumbnail != '') {
                    $data['thumbnail'] = $thumbnail;
                    if ($xthumbnail != '') @unlink('upload/ecommerce/' . $xthumbnail);
                }

                if ($product_file != '') {
                    $data['digital_product_file'] = $product_file;
                    if ($xdigital_product_file != '') @unlink('upload/ecommerce/digital_product/' . $xdigital_product_file);
                }
                if ($featured_images != '') {
                    $data['featured_images'] = $featured_images;
                    if ($xfeatured_images != '') {
                        $exp = explode(',', $xfeatured_images);
                        foreach ($exp as $key => $value) {
                            @unlink('upload/ecommerce/' . $value);
                        }
                    }
                }

                $success = '0';
                if ($this->basic->update_data('ecommerce_product', array("id" => $id, "user_id" => $this->user_id), $data)) {
                    $success = '1';
                    $this->session->set_flashdata('success_message', 1);
                } else $this->session->set_flashdata('error_message', 1);

                $n_store_data = $this->basic->get_data("ecommerce_product", array("where" => array("id" => $id)));
                if (!empty($n_store_data[0]['store_id'])) {
                    $this->sitemap_set_null($n_store_data[0]['store_id']);
                }

                if ($this->addon_exist('ecommerce_product_price_variation')) {
                    if ($this->session->userdata('user_type') == 'Admin' || in_array(281, $this->module_access)) {
                        if ($success == '1') {
                            $insert_data = [];
                            $attribute_ids_array = explode(',', $attribute_ids);
                            foreach ($attribute_ids_array as $attribute_id) {
                                $this->basic->delete_data('ecommerce_attribute_product_price', ['product_id' => $id, 'attribute_id' => $attribute_id]);
                                $attribute_values_info = $this->basic->get_data('ecommerce_attribute', ['where' => ['id' => $attribute_id, 'user_id' => $this->user_id]]);
                                $attribute_values = isset($attribute_values_info[0]['attribute_values']) ? json_decode($attribute_values_info[0]['attribute_values'], true) : [];
                                $attribute_option_name = isset($attribute_values_info[0]['attribute_name']) ? $attribute_values_info[0]['attribute_name'] : '';
                                $insert_data['attribute_id'] = $attribute_id;
                                $insert_data['product_id'] = $id;
                                foreach ($attribute_values as $key => $value) {
                                    $insert_data['attribute_option_name'] = $value;
                                    $variable_amount = "single_attribute_values_" . $attribute_id . "_" . $key;
                                    $variable_indicator = "single_attribute_names_" . $attribute_id . "_" . $key;
                                    $insert_data['amount'] = is_null($this->input->post($variable_amount, true)) ? 0 : $this->input->post($variable_amount, true);
                                    $insert_data['price_indicator'] = is_null($this->input->post($variable_indicator, true)) ? "+" : $this->input->post($variable_indicator, true);
                                    $this->basic->insert_data('ecommerce_attribute_product_price', $insert_data);
                                }
                            }
                        }
                    }
                }


                redirect('ecommerce/product_list', 'location');

            }
        }
    }

    public function delete_product()
    {
        $this->ajax_check();
        $table_id = $this->input->post("table_id");

        $xdata = $this->basic->get_data("ecommerce_product", array("where" => array("id" => $table_id, "user_id" => $this->user_id)), "thumbnail,featured_images");
        if (!isset($xdata[0])) {
            $response['status'] = '0';
            $response['message'] = $this->lang->line('Something went wrong, please try once again.');
        }
        $xthumbnail = isset($xdata[0]['thumbnail']) ? $xdata[0]['thumbnail'] : "";
        $xfeatured_images = isset($xdata[0]['featured_images']) ? $xdata[0]['featured_images'] : "";

        if (!empty($xdata[0]['store_id'])) {
            $this->sitemap_set_null($xdata[0]['store_id']);
        }

        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));
        if ($table_id == "0" || $table_id == "") {
            echo json_encode($result);
            exit();
        }
        if ($this->basic->update_data("ecommerce_product", array("id" => $table_id, 'user_id' => $this->user_id), array('deleted' => '1', 'n_wh' => '0'))) {
            echo json_encode(array('message' => $this->lang->line("Product has been deleted successfully."), 'status' => '1'));
            if ($xthumbnail != '') @unlink('upload/ecommerce/' . $xthumbnail);
            if ($xfeatured_images != '') {
                $exp = explode(',', $xfeatured_images);
                foreach ($exp as $key => $value) {
                    @unlink('upload/ecommerce/' . $value);
                }
            }

        } else echo json_encode($result);
    }

    public function delete_category()
    {
        $this->ajax_check();
        $table_id = $this->input->post("table_id");
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));
        if ($table_id == "0" || $table_id == "") {
            echo json_encode($result);
            exit();
        }

        $store_data = $this->basic->get_data("ecommerce_category", array("where" => array("id" => $table_id)));
        if (!empty($store_data[0]['store_id'])) {
            $this->sitemap_set_null($store_data[0]['store_id']);
        }

        if ($this->basic->delete_data("ecommerce_category", array("id" => $table_id, 'user_id' => $this->user_id)))
            echo json_encode(array('message' => $this->lang->line("Category has been deleted successfully."), 'status' => '1'));
        else echo json_encode($result);
    }

    public function change_payment_status()
    {
        $this->ajax_check();
        $id = $this->input->post("table_id", true);
        $payment_status = $this->input->post("payment_status", true);
        $status_changed_note = strip_tags($this->input->post("status_changed_note", true));
        $update_data = array("status" => $payment_status, "status_changed_at" => date("Y-m-d H:i:s"), "n_wh" => 0);
        $update_data['status_changed_note'] = $status_changed_note;

        $join = array('ecommerce_store' => "ecommerce_store.id=ecommerce_cart.store_id,left");;
        $cart_data = $this->basic->get_data('ecommerce_cart', array("where" => array("ecommerce_cart.id" => $id)), "buyer_email,buyer_mobile,buyer_first_name,buyer_last_name,bill_email,bill_mobile,ecommerce_cart.id,subscriber_id,page_id,store_name,store_unique_id,ecommerce_store.id as store_id,notification_message,notification_sms_api_id,notification_email_api_id,notification_email_subject,notification_configure_email_table", $join);
        if (!isset($cart_data[0])) {
            echo json_encode(array('status' => '1', 'message' => $this->lang->line("Order data not found.")));
            exit();
        }
        $user_id = $this->user_id;
        $page_id = $cart_data[0]['page_id'];
        $subscriber_id = $cart_data[0]['subscriber_id'];
        $last_name = $cart_data[0]['buyer_last_name'];
        $first_name = $cart_data[0]['buyer_first_name'];
        $email = $cart_data[0]['buyer_email'];
        $mobile = $cart_data[0]['buyer_mobile'];
        $store_name = $cart_data[0]['store_name'];
        $order_no = $cart_data[0]['id'];
        $store_url = base_url("ecommerce/store/" . $cart_data[0]['store_unique_id'] . "?subscriber_id=" . $subscriber_id);
        $invoice_url = base_url("ecommerce/cart/" . $order_no . "?subscriber_id=" . $subscriber_id);
        $order_url = base_url("ecommerce/order/" . $order_no . "?subscriber_id=" . $subscriber_id);
        $my_orders_url = base_url("ecommerce/my_orders/" . $cart_data[0]['store_id'] . "?subscriber_id=" . $subscriber_id);
        $notification_sms_api_id = $cart_data[0]['notification_sms_api_id'];
        $notification_email_api_id = $cart_data[0]['notification_email_api_id'];
        $notification_email_subject = $cart_data[0]['notification_email_subject'];
        $notification_configure_email_table = $cart_data[0]['notification_configure_email_table'];
        if ($notification_email_subject == "") $notification_email_subject = "{{store_name}} | Order Update";
        if (empty($email)) $email = isset($cart_data[0]['bill_email']) ? $cart_data[0]['bill_email'] : '';
        if (empty($mobile)) $mobile = isset($cart_data[0]['bill_mobile']) ? $cart_data[0]['bill_mobile'] : '';
        $api_response = array();

        $subscriber_info_type = $this->basic->get_data("messenger_bot_subscriber", array("where" => array('subscribe_id' => $subscriber_id)), "social_media");
        $social_media_type = $subscriber_info_type[0]['social_media'] ?? 'fb';

        if ($this->basic->update_data("ecommerce_cart", array("id" => $id, "user_id" => $user_id), $update_data)) {
            $notification_default = $this->notification_default();
            $notification_message = json_decode($cart_data[0]['notification_message'], true);
            $messenger_text = isset($notification_message['messenger'][$payment_status]['text']) ? $notification_message['messenger'][$payment_status]['text'] : $notification_default['messenger'];
            $messenger_btn = isset($notification_message['messenger'][$payment_status]['btn']) ? $notification_message['messenger'][$payment_status]['btn'] : 'MY ORDERS';

            $replace_variables = array("store_name" => $store_name, "store_url" => $store_url, "order_no" => $order_no, "order_status" => $payment_status, "invoice_url" => $order_url, "update_note" => $status_changed_note, "first_name" => $first_name, "last_name" => $last_name, "my_orders_url" => $my_orders_url);

            //  Messenger Sending block
            $page_info = $this->basic->get_data("facebook_rx_fb_page_info", array('where' => array('id' => $page_id)), "page_access_token");
            $page_access_token = isset($page_info[0]['page_access_token']) ? $page_info[0]['page_access_token'] : "";

            //  Messenger Sending block
            if ($messenger_text != "") {
                $api_response['messenger'] = array("status" => 0, "response" => "unknown");
                $messenger_text = $this->spin_and_replace_notification($messenger_text, $replace_variables);
                if ($social_media_type == 'fb')
                    $messenger_confirmation_template = array
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
                                    'payload' =>
                                        array
                                        (
                                            'template_type' => 'button',
                                            'text' => $messenger_text,
                                            'buttons' => array(
                                                0 => array(
                                                    "type" => "web_url",
                                                    "url" => $my_orders_url,
                                                    "title" => $messenger_btn,
                                                    "messenger_extensions" => 'true',
                                                    "webview_height_ratio" => 'full'
                                                )
                                            )
                                        ),
                                )
                        )
                    );
                else {
                    $messenger_confirmation_template = array("recipient" => array("id" => $subscriber_id), "message" => array("text" => $messenger_text . '
          ' . $this->lang->line('Order URL') . ': ' . $my_orders_url));
                }
                $api_response['messenger'] = $this->send_messenger_reminder(json_encode($messenger_confirmation_template), $page_access_token, $cart_data[0]['store_id'], $subscriber_id);
            }
            //  Messenger Sending block


            //  SMS Sending block
            if ($mobile != "" && $notification_sms_api_id != '0') {
                $sms_text = isset($notification_message['sms'][$payment_status]) ? $notification_message['sms'][$payment_status] : $notification_default['sms'];
                // $sms_text = str_replace(array("'",'"'),array('`','`'),$sms_text);
                $sms_text = $this->spin_and_replace_notification($sms_text, $replace_variables);

                $api_response['sms'] = array("response" => 'missing param', "status" => '0');

                if (trim($sms_text) != "") {
                    $this->load->library('Sms_manager');
                    $this->sms_manager->set_credentioal($notification_sms_api_id, $user_id);
                    try {
                        $response = $this->sms_manager->send_sms($sms_text, $mobile);

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
                    $api_response['sms'] = $sms_response;
                }

            }
            //  SMS Sending block


            //  Email Sending block
            if ($email != "" && $notification_email_api_id != '0') {
                $email_text = isset($notification_message['email'][$payment_status]) ? $notification_message['email'][$payment_status] : $notification_default['email'];
                $email_text = $this->spin_and_replace_notification($email_text, $replace_variables);
                $notification_email_subject = $this->spin_and_replace_notification($notification_email_subject, $replace_variables);
                $from_email = "";

                if ($notification_configure_email_table == "email_smtp_config") {
                    $from_email = "smtp_" . $notification_email_api_id;
                } elseif ($notification_configure_email_table == "email_mandrill_config") {
                    $from_email = "mandrill_" . $notification_email_api_id;
                } elseif ($notification_configure_email_table == "email_sendgrid_config") {
                    $from_email = "sendgrid_" . $notification_email_api_id;
                } elseif ($notification_configure_email_table == "email_mailgun_config") {
                    $from_email = "mailgun_" . $notification_email_api_id;
                }

                $email_response = array("response" => 'missing param', "status" => '0');
                if (trim($email_text) != '') {
                    try {
                        $response = $this->_email_send_function($from_email, $email_text, $email, $notification_email_subject, $attachement = '', $filename = '', $user_id);

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
                $api_response['email'] = $email_response;
            }
            //  Email Sending block

            $api_response_formatted = '';
            if (!empty($api_response)) {
                $api_response_formatted .= "<h6>" . $this->lang->line("Notification API Response") . "</h6>";
                $api_response_formatted .= "<div class='table-responsive'>";
                $api_response_formatted .= "<table class='table table-bordered table-sm table-striped table-hover'>";
            }

            foreach ($api_response as $key => $value) {
                if ($value['status'] == '1') $api_status = "<span class='badge badge-success'><i class='fas fa-check-circle'></i> " . $this->lang->line("Success") . "</span>";
                else $api_status = "<span class='badge badge-danger'><i class='fas fa-times-circle'></i> " . $this->lang->line("Error") . "</span>";

                $api_response_formatted .= "<tr class='text-center'>";
                $api_response_formatted .= "<td>" . $this->lang->line($key) . "</td>";
                $api_response_formatted .= "<td>" . $api_status . "</td>";
                $api_response_formatted .= "<td>" . $value['response'] . "</td>";
                $api_response_formatted .= "</tr>";
            }

            if (!empty($api_response)) {
                $api_response_formatted .= "</table>";
                $api_response_formatted .= "</div>";
            }

            echo json_encode(array('status' => '1', 'message' => $this->lang->line("Payment status has been updated successfully.") . "<br><br><br>" . $api_response_formatted . "</pre>"));
        } else echo json_encode(array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try again.")));
    }

    private function notification_default()
    {
        return array
        (
            'messenger' => 'Hello {{first_name}},

      Order #{{order_no}} status has been updated to {{order_status}}.
      {{update_note}}

      Thank you,
      {{store_name}} Team',
            'email' => 'Hello {{first_name}},<br/><br/>Order #{{order_no}} status has been updated to {{order_status}}.<br><br>{{update_note}}<br>Invoice : {{invoice_url}} <br/><br/>Thank you,<br/><a href="{{store_url}}">{{store_name}}</a> Team',
            'sms' => 'Order #{{order_no}} status has been updated to {{order_status}}.
      Thanks, {{store_name}}'
        );
    }

    private function spin_and_replace_notification($str = "", $replace = array(), $is_spin = true)
    {
        if (!isset($replace['store_name'])) $replace['store_name'] = '';
        if (!isset($replace['store_url'])) $replace['store_url'] = '';
        if (!isset($replace['order_no'])) $replace['order_no'] = '';
        if (!isset($replace['order_status'])) $replace['order_status'] = '';
        if (!isset($replace['invoice_url'])) $replace['invoice_url'] = '';
        if (!isset($replace['update_note'])) $replace['update_note'] = '';
        if (!isset($replace['first_name'])) $replace['first_name'] = '';
        if (!isset($replace['last_name'])) $replace['last_name'] = '';
        if (!isset($replace['my_orders_url'])) $replace['my_orders_url'] = '';

        $replace_values = array_values($replace);
        $str = str_replace(array("{{store_name}}", "{{store_url}}", "{{order_no}}", "{{order_status}}", "{{invoice_url}}", "{{update_note}}", "{{first_name}}", "{{last_name}}", "{{my_orders_url}}"), $replace_values, $str);
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

    public function n_webhook_order($limit)
    {
        if (empty($api_key)) {
        }

        $cdata = $this->basic->get_data("ecommerce_cart", array("where" => array("n_wh" => 0, "action_type !=" => "add")), '', '', $limit, NULL, 'id desc');

        foreach ($cdata as $ck => $cv) {
            $wh_data = array();
            $wh_data['type'] = 'order';
            $wh_data['data'] = $cv;

            $wh_data['cart_products'] = $this->basic->get_data("ecommerce_cart_item",array("where"=>array("cart_id"=>$cv['id'])),"quantity,product_name,unit_price,coupon_info,attribute_info,thumbnail,product_id,woocommerce_product_id",array('ecommerce_product'=>"ecommerce_cart_item.product_id=ecommerce_product.id,left"));

            $this->n_send_curl_webhook($cv['store_id'], $wh_data);
            $this->basic->update_data("ecommerce_cart", array('id' => $cv['id']), array('n_wh' => 1));
        }
    }

    public function n_webhook_product($limit){
        $cdata = $this->basic->get_data("ecommerce_product", array("where" => array("n_wh" => 0)), '', '', $limit, NULL, 'id desc');

        foreach ($cdata as $ck => $cv) {
            $wh_data = array();
            $wh_data['type'] = 'product';
            $wh_data['data'] = $cv;
            $wh_url_check = $this->n_send_curl_webhook($cv['store_id'], $wh_data);
            if($wh_url_check==false){
                continue;
            }
            $this->basic->update_data("ecommerce_product", array('id' => $cv['id']), array('n_wh' => 1));
        }
    }

    private function n_get_webhook_url($store_id)
    {
        if (empty($this->webhook_url[$store_id])) {
            $whdata = $this->basic->get_data("n_webhook", array("where" => array("store_id" => $store_id)));
        } else {
            return $this->webhook_url[$store_id];
        }

        if (empty($whdata[0])) {
            $this->webhook_url[$store_id] = false;
            return false;
        } else {
            $this->webhook_url[$store_id] = $whdata[0];
            return $whdata[0];
        }

    }

    private function n_update_webhook($wh_id, $error_last, $store_id)
    {
        $current_log = $this->webhook_url[$store_id]['error_log'];
        $utime = time();

        $this->wh_time = ($utime + 1);

        $error_log = array();
        if (!empty($current_log)) {
            $error_log = json_decode($current_log, true);
            if (count($error_log) > 10) {
                ksort($error_log);
                array_shift($error_log);
            }
        }

//
//        if(isset($error_log[time()])){
//            $error_log[$this->wh_time] = $error_last;
//        }else{
//            $error_log[$utime] = $error_last;
//        }

        $error_log[$utime] = $error_last;

        $this->webhook_url[$store_id]['error_log'] = json_encode($error_log);
        $update_data = array(
            'error_log' => $this->webhook_url[$store_id]['error_log'],
        );


        $this->basic->update_data("n_webhook", array('id' => $wh_id), $update_data);
        return true;
    }

    private function n_send_curl_webhook($store_id, $data)
    {
        $url_wh = $this->n_get_webhook_url($store_id);

        if ($url_wh != false) {
            $url_wh['domains'] = explode(',', $url_wh['domains']);

            if(is_array($data)){
                $data = json_encode($data);
            }

            foreach ($url_wh['domains'] as $whk => $whv) {
                $ch = curl_init($whv);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:64.0) Gecko/20100101 Firefox/64.0');
                curl_setopt($ch, CURLOPT_TIMEOUT, 15);
                $response = curl_exec($ch);
                $info = curl_getinfo($ch);
                $error = curl_error($ch);
                curl_close($ch);

                if ($info['http_code'] != 200) {
                    $this->n_update_webhook($url_wh['id'], $error, $store_id);
                }

            }


        }
    }

    public function latest_order_api()
    {

        if (!empty($_POST['store_id'])) {
            $this->csrf_token_check();

            $where_simple = array(
                'where' => "store_id = '" . $_POST['store_id'] . "' AND action_type='checkout' AND (STATUS='status' OR (payment_method='Cash on Delivery' AND status='pending'))"
            );


            $webhook_data = $this->basic->get_data("ecommerce_cart", $where_simple, '', '', 1, NULL, 'id desc');

            if (!empty($webhook_data[0]['id'])) {
                //$webhook_data[0]['id'] = '221';
                echo json_encode(array('status' => '1', 'latest_order_id' => $webhook_data[0]['id']));
                return;
            } else {
                echo json_encode(array('status' => '1', 'latest_order_id' => 0));
                return;
            }
        }
        echo json_encode(array('status' => '0', 'message' => $this->lang->line("something went wrong, please try once again.")));
        return;

    }

    public function delivery_methods_list(){
        $data['body'] = 'ecommerce/delivery_methods_list';
        $data['page_title'] = $this->lang->line('Delivery Methods') . " : " . $this->session->userdata("ecommerce_selected_store_title");
        $store_list = $this->get_store_list();
        $store_list[''] = $this->lang->line("Store");
        $data['store_list'] = $store_list;
        $data["iframe"] = "1";

        $all_categories = $this->basic->get_data("ecommerce_dm", $where = array('where' => array("store_id" => $this->session->userdata("ecommerce_selected_store"))), "", "", "", "", $order_by = "name asc");
        $data["all_categories"] = $all_categories;

        $this->_viewcontroller($data);
    }

    public function delivery_methods_list_data()
    {
        $table = "ecommerce_dm";
        $select = "ecommerce_dm.*";
        $where_custom = '';
        $where_custom = "ecommerce_dm.user_id = " . $this->user_id . " AND ecommerce_dm.store_id = " . $this->session->userdata("ecommerce_selected_store");

        $this->db->where($where_custom);
        $total_rows_array = $this->basic->count_row($table, $where = '', $count = "ecommerce_dm.id", '',  '');
        $total_result = $total_rows_array[0]['total_rows'];

        if($total_result==0){
            $this->create_default_delivery_methods($this->session->userdata("ecommerce_selected_store"), $this->user_id);
        }


        $search_value = $_POST['search']['value'];

        $display_columns = array("#", 'CHECKBOX', 'name', 'enabled', 'actions',);
        $search_columns = array('name');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'serial';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $order_by = $sort . " " . $order;


        if ($search_value != '') {
            foreach ($search_columns as $key => $value)
                $temp[] = $value . " LIKE " . "'%$search_value%'";
            $imp = implode(" OR ", $temp);
            $where_custom .= " AND (" . $imp . ") ";
        }


        $this->db->where($where_custom);
        $info = $this->basic->get_data($table, $where = '', $select, '', $limit, $start, $order_by, $group_by = '');

        $this->db->where($where_custom);
        $total_rows_array = $this->basic->count_row($table, $where = '', $count = "ecommerce_dm.id", '', $group_by = '');
        $total_result = $total_rows_array[0]['total_rows'];

        if($total_result==0){
            $this->create_default_delivery_methods($this->session->userdata("ecommerce_selected_store"), $this->user_id);
        }

        foreach ($info as $key => $value) {


                $info[$key]['actions'] = "<div style='min-width:100px'><a href='#' title='" . $this->lang->line("Edit") . "' data-toggle='tooltip' class='btn btn-circle btn-outline-warning edit_row' table_id='" . $info[$key]['id'] . "'><i class='bx bx-edit'></i></a>";

            if($info[$key]['cant_delete']==0) {
                $info[$key]['actions'] .= "<a href='#' title='" . $this->lang->line("Delete") . "' data-toggle='tooltip' class='ml-1 btn btn-circle btn-outline-danger delete_row' table_id='" . $info[$key]['id'] . "'><i class='bx bx-trash'></i></a></div>
    <script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";

            }

            if ($info[$key]['enabled'] == 1) $info[$key]['enabled'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> " . $this->lang->line('Active') . "</span>";
            else $info[$key]['enabled'] = "<span class='badge badge-status text-danger'><i class='fa fa-times-circle red'></i> " . $this->lang->line('Inactive') . "</span>";
        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns, $start, $primary_key = "id");
        echo json_encode($data);
    }

    public function ajax_create_new_delivery_methods()
    {
        $this->ajax_check();
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));

        if ($_POST) {
            $delivery_name = strip_tags($this->input->post("delivery_name", true));

            $default_price = $this->input->post("default_price", true);
            $store_id = $this->input->post("store_id", true);


            $status = $this->input->post("enable", true);
            if (!isset($status) || $status == '') $status = '0';

            $cod = $this->input->post("cod", true);
            if (!isset($cod) || $cod == '') $cod = '0';


            $mashkor_cod_card = $this->input->post("mashkor_cod_card", true);
            if (!isset($mashkor_cod_card) || $mashkor_cod_card == '') $mashkor_cod_card = '0';
            $mashkor_online = $this->input->post("mashkor_online", true);
            if (!isset($mashkor_online) || $mashkor_online == '') $mashkor_online = '0';
            $mashkor_cod_cash = $this->input->post("mashkor_cod_cash", true);
            if (!isset($mashkor_cod_cash) || $mashkor_cod_cash == '') $mashkor_cod_cash = '0';
            $mashkor = array(
                'mashkor_cod_card' => $mashkor_cod_card,
                'mashkor_online' => $mashkor_online,
                'mashkor_cod_cash' => $mashkor_cod_cash
            );


            $inserted_data = array
            (
                "store_id" => $store_id,
                "name" => $delivery_name,
                "default_price" => $default_price,
                "enabled" => $status,
                "default_dm" => 0,
                "special_type" => '',
                "cod" => $cod,
                "cant_delete" => 0,
                "user_id" => $this->user_id,
                'mashkor' => json_encode($mashkor)
            );

            if ($this->basic->insert_data("ecommerce_dm", $inserted_data)) {
                $result['status'] = "1";
                $result['message'] = $this->lang->line("Delivery method has been added successfully.");
            }

            echo json_encode($result);

        }
    }

    public function ajax_get_delivery_methods_update_info()
    {

        $this->ajax_check();

        $table_id = $this->input->post("table_id");
        $user_id = $this->user_id;

        if ($table_id == "0" || $table_id == "") exit;

        $details = $this->basic->get_data("ecommerce_dm", array('where' => array('id' => $table_id, 'user_id' => $user_id)));
        $selected = ($details[0]['enabled'] == '1') ? 'checked' : '';

        if(!empty($details[0]['mashkor'])){
            $details[0]['mashkor'] = json_decode($details[0]['mashkor'], true);
        }

//        $store_list = $this->get_store_list();
//        $store_list[''] = $this->lang->line("Store");
//        $details[0]['store_name'] = $store_list[''];
//
//        $details[0]['store_list'] = $store_list;

        echo json_encode($details[0]);

    }

    public function ajax_update_delivery_methods()
    {
        $this->ajax_check();
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));

        if ($_POST) {
            $edit_table_id = $this->input->post("edit_table_id", true);

            $delivery_name = $this->input->post("edit_delivery_name", true);

            $default_price = $this->input->post("edit_default_price", true);

            $store_id = $this->input->post("store_id", true);
            $cod = $this->input->post('edit_cod', true);

            $edit_enable = $this->input->post("edit_enable", true);
            if (!isset($edit_enable) || $edit_enable == '') $edit_enable = '0';

            $mashkor_cod_card = $this->input->post("mashkor_cod_card", true);
            if (!isset($mashkor_cod_card) || $mashkor_cod_card == '') $mashkor_cod_card = '0';
            $mashkor_online = $this->input->post("mashkor_online", true);
            if (!isset($mashkor_online) || $mashkor_online == '') $mashkor_online = '0';
            $mashkor_cod_cash = $this->input->post("mashkor_cod_cash", true);
            if (!isset($mashkor_cod_cash) || $mashkor_cod_cash == '') $mashkor_cod_cash = '0';
            $mashkor = array(
                'mashkor_cod_card' => $mashkor_cod_card,
                'mashkor_online' => $mashkor_online,
                'mashkor_cod_cash' => $mashkor_cod_cash
            );


            $updated_data = array
            (
                "name" => $delivery_name,
                "default_price" => $default_price,
                "enabled" => $edit_enable,
                "cod" => $cod,
                'mashkor' => json_encode($mashkor)
            );

            if ($this->basic->update_data("ecommerce_dm", array("id" => $edit_table_id, "user_id" => $this->user_id), $updated_data)) {
                $result['status'] = "1";
                $result['message'] = $this->lang->line("Delivery Method has been updated successfully.");
            }

            echo json_encode($result);

        }
    }

    public function delete_delivery_methods()
    {
        $this->ajax_check();
        $table_id = $this->input->post("table_id");
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));
        if ($table_id == "0" || $table_id == "") {
            echo json_encode($result);
            exit();
        }

        if ($this->basic->delete_data("ecommerce_dm", array("id" => $table_id, 'user_id' => $this->user_id, 'cant_delete' => 0)))
            echo json_encode(array('message' => $this->lang->line("Delivery method has been deleted successfully."), 'status' => '1'));
        else echo json_encode($result);
    }

    public function get_all_delivery_methods( $store_id = 0){
        $table = "ecommerce_dm";
        $select = "ecommerce_dm.*";
        $where_custom = '';
        if($store_id==0){
            $store_id = $this->session->userdata("ecommerce_selected_store");
            $where_custom = "ecommerce_dm.user_id = " . $this->user_id . " AND ecommerce_dm.store_id = " . $store_id;
        }else{
            $where_custom = "enabled = 1 AND ecommerce_dm.store_id = " . $store_id;
        }


        $this->db->where($where_custom);
        $info = $this->basic->get_data($table, $where = '', $select, '', '', '', '', '');

            return $info;
    }

    private function get_all_delivery_methods_worldwide($store_id){
        $table = "ecommerce_zones";
        $select = "ecommerce_zones.*";
        $where_custom = '';

            $where_custom =  "store_id = " . $store_id;
            $where_custom .= " AND active = 1 AND worldwide = 1 " ;



        $this->db->where($where_custom);
        $info = $this->basic->get_data($table, $where = '', $select, '', '', '', '', '');

        if(!empty($info[0])){
            return $info[0];
        }else{
            return '';
        }

    }

    private function create_default_delivery_methods($store_id = 0, $user_id = 0){
        if($store_id != 0){

            $inserted_data = array
            (
                "store_id" => $store_id,
                "name" => $this->lang->line('Store Pickup'),
                "default_price" => 0,
                "enabled" => 0,
                "default_dm" => 0,
                "special_type" => 'pickup',
                "cod" => 1,
                "cant_delete" => 1,
                "user_id" => $user_id,
            );

            $this->basic->insert_data("ecommerce_dm", $inserted_data);

            $inserted_data = array
            (
                "store_id" => $store_id,
                "name" => $this->lang->line('Delivery'),
                "default_price" => 15,
                "enabled" => 1,
                "default_dm" => 1,
                "special_type" => '',
                "cod" => 0,
                "cant_delete" => 1,
                "user_id" => $user_id,
            );

            $this->basic->insert_data("ecommerce_dm", $inserted_data);

        }
    }

    public function shipping_zone_list(){
        $data['body'] = 'ecommerce/shipping_zones_list';
        $data['page_title'] = $this->lang->line('Delivery Methods') . " : " . $this->session->userdata("ecommerce_selected_store_title");
        $store_list = $this->get_store_list();
        $store_list[''] = $this->lang->line("Store");
        $data['store_list'] = $store_list;
        $data["iframe"] = "1";
        $data["country_list"] = $this->get_country_new('country_id');

        $data["delivery_list"] = $this->get_all_delivery_methods();

        $all_categories = $this->basic->get_data("ecommerce_zones", $where = array('where' => array("store_id" => $this->session->userdata("ecommerce_selected_store"))), "", "", "", "", $order_by = "name asc");
        $data["all_categories"] = $all_categories;

        $this->_viewcontroller($data);
    }

    public function shipping_zone_list_data()
    {
        $table = "ecommerce_zones";
        $select = "ecommerce_zones.*";
        $where_custom = '';
        $where_custom = "ecommerce_zones.user_id = " . $this->user_id . " AND ecommerce_zones.store_id = " . $this->session->userdata("ecommerce_selected_store");

        $this->db->where($where_custom);
        $total_rows_array = $this->basic->count_row($table, $where = '', $count = "ecommerce_zones.id", '',  '');
        $total_result = $total_rows_array[0]['total_rows'];

        if($total_result==0){
            $this->create_default_shipping_zone($this->session->userdata("ecommerce_selected_store"), $this->user_id);
        }


        $search_value = $_POST['search']['value'];

        $display_columns = array("#", 'CHECKBOX', 'name', 'active', 'actions',);
        $search_columns = array('name');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'serial';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
        $order_by = $sort . " " . $order;


        if ($search_value != '') {
            foreach ($search_columns as $key => $value)
                $temp[] = $value . " LIKE " . "'%$search_value%'";
            $imp = implode(" OR ", $temp);
            $where_custom .= " AND (" . $imp . ") ";
        }


        $this->db->where($where_custom);
        $info = $this->basic->get_data($table, $where = '', $select, '', $limit, $start, $order_by, $group_by = '');

        $this->db->where($where_custom);
        $total_rows_array = $this->basic->count_row($table, $where = '', $count = "ecommerce_zones.id", '', $group_by = '');
        $total_result = $total_rows_array[0]['total_rows'];

//        if($total_result==0){
//            $this->create_default_delivery_methods($this->session->userdata("ecommerce_selected_store"), $this->user_id);
//        }

        foreach ($info as $key => $value) {


            $info[$key]['actions'] = "<div style='min-width:100px'><a href='#' title='" . $this->lang->line("Edit") . "' data-toggle='tooltip' class='btn btn-circle btn-outline-warning edit_row' table_id='" . $info[$key]['id'] . "'><i class='bx bx-edit'></i></a>";

            if($info[$key]['cant_delete']==0) {
                $info[$key]['actions'] .= "<a href='#' title='" . $this->lang->line("Delete") . "' data-toggle='tooltip' class='ml-1 btn btn-circle btn-outline-danger delete_row' table_id='" . $info[$key]['id'] . "'><i class='bx bx-trash'></i></a></div>
    <script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";

            }

            if ($info[$key]['active'] == 1) $info[$key]['active'] = "<span class='badge badge-status text-success'><i class='fa fa-check-circle green'></i> " . $this->lang->line('Active') . "</span>";
            else $info[$key]['active'] = "<span class='badge badge-status text-danger'><i class='fa fa-times-circle red'></i> " . $this->lang->line('Inactive') . "</span>";
        }

        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns, $start, $primary_key = "id");
        echo json_encode($data);
    }

    public function ajax_create_new_shipping_zone()
    {
        $this->ajax_check();
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));

        if ($_POST) {
            $zone_name = strip_tags($this->input->post("zone_name", true));

            $country_list_ids = $this->input->post("country_list_ids", true);
            $states_list_ids = $this->input->post("states_list_ids", true);


            $store_id = $this->input->post("store_id", true);
            $delivery = $this->input->post('payment');

            $status = $this->input->post("active", true);
            if (!isset($status) || $status == '') $status = '0';

            $allow_order = $this->input->post("allow_order", true);
            if (!isset($allow_order) || $allow_order == '') $allow_order = '0';

            $required_state = $this->input->post("required_state", true);
            if (!isset($required_state) || $required_state == '') $required_state = '0';

            $inserted_data = array
            (
                "store_id" => $store_id,
                "user_id" => $this->user_id,
                "name" => $zone_name,
                "active" => $status,
                "cant_delete" => 0,
                "country" => $country_list_ids,
                "states" => $states_list_ids,
                "delivery_methods" => json_encode($delivery, JSON_FORCE_OBJECT),
                "allow_order" => $allow_order,
                "worldwide" => 0,
                "required_state" => $required_state,
            );

            if ($this->basic->insert_data("ecommerce_zones", $inserted_data)) {
                $result['status'] = "1";
                $result['message'] = $this->lang->line("Shipping zone has been added successfully.");
            }

            echo json_encode($result);

        }
    }

    public function ajax_get_shipping_zone_update_info()
    {

        $this->ajax_check();

        $table_id = $this->input->post("table_id");
        $user_id = $this->user_id;

        if ($table_id == "0" || $table_id == "") exit;

        $details = $this->basic->get_data("ecommerce_zones", array('where' => array('id' => $table_id, 'user_id' => $user_id)));



//        $store_list = $this->get_store_list();
//        $store_list[''] = $this->lang->line("Store");
//        $details[0]['store_name'] = $store_list[''];
//
//        $details[0]['store_list'] = $store_list;

        echo json_encode($details[0]);

    }

    public function ajax_get_shipping_zone()
    {

        $this->ajax_check();

        $country = $this->input->post("country", true);
        $state = $this->input->post("state");
        $store_id = $this->input->post("store_id");

        if ($country == "0" || $country == "") exit;

        $country = str_replace("'", "\'", $country);

        $where = '
            store_id = '.$store_id.'
            AND country LIKE \'%\"'.$country.'\"%\' 
            ';
        $this->db->where($where);
        $details = $this->basic->get_data("ecommerce_zones", '');


        $states = array();
        $states[] = array(
            'text' => $this->lang->line('Search or type state'),
            'id' => ''
        );

        $not_found = 1;

        if(!empty($details[0])){
            foreach($details as $v){
                if($v['states']!='{}' AND !empty($v['states'])){
                    $v['states'] = json_decode($v['states']);
                    foreach($v['states'] as $kk => $vv){
                        $selected = false;
                        if($state == $vv){
                            $selected = true;
                            $not_found = 0;
                        }

                        $states[] = array(
                            'id' => $vv,
                            'text' => $this->lang->line($vv),
                            //'selected' => $selected
                        );
                    }
                }
            }

            if(!empty($state) AND $details[0]['required_state'] == 1 ){
                $where .= '
            AND states LIKE  \'%\"'.$state.'\"%\' 
            ';

                $this->db->where($where);
                $details = $this->basic->get_data("ecommerce_zones", '');
                if(!empty($details[0])){
                    $details_w_states = $details[0];
                }

            }

        }


        if(empty($states[1])){
            //country_id from n_states

            $where = '
                name = "'.$country.'" 
            ';
            $this->db->where($where);
            $c_var = $this->basic->get_data("n_countries", '');

            if(!empty($c_var[0])){
                $c_var = $c_var[0]['id'];

                $ret_states = $this->basic->get_data("n_states", array('where' => array('country_id' => $c_var)));

                if(!empty($ret_states[0])){
                    foreach($ret_states as $vs){
                        $selected = false;
                        if($state == $vs['name']){
                            $selected = true;
                            $not_found = 0;
                        }

                        $states[] = array(
                            'id' => $vs['name'],
                            'text' => $this->lang->line($vs['name']),
                            //'selected' => $selected
                        );
                    }
                }

            }
        }

        if($not_found==1){
            $states[] = array(
                'text' => $state,
                'id' => $state
            );
        }

        if(!empty($details[0]) AND $details[0]['required_state']==0){
            $details[0]['status'] = 1;
            $details[0]['states_data'] = $states;
            echo json_encode($details[0]);
        }elseif(!empty($details_w_states) AND $details_w_states['required_state']==1){
            $details_w_states['status'] = 1;
            $details_w_states['states_data'] = $states;
            echo json_encode($details_w_states);

        }else {
            echo json_encode(array('status' => 0, 'states_data' => $states));
        }

    }

    public function ajax_update_shipping_zone()
    {
        $this->ajax_check();
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));

        if ($_POST) {
            $zone_name = strip_tags($this->input->post("edit_zone_name", true));

            $country_list_ids = $this->input->post("edit_country_list_ids", true);
            $states_list_ids = $this->input->post("edit_states_list_ids", true);

            $edit_table_id = $this->input->post("edit_table_id", true);



            $store_id = $this->input->post("edit_store_id", true);
            $delivery = $this->input->post('edit_payment');

            $status = $this->input->post("edit_active", true);
            if (!isset($status) || $status == '') $status = '0';

            $allow_order = $this->input->post("edit_allow_order", true);
            if (!isset($allow_order) || $allow_order == '') $allow_order = '0';

            $required_state = $this->input->post("edit_required_state", true);
            if (!isset($required_state) || $required_state == '') $required_state = '0';

            $updated_data = array
            (
                "name" => $zone_name,
                "active" => $status,
                "cant_delete" => 0,
                "country" => $country_list_ids,
                "states" => $states_list_ids,
                "delivery_methods" => json_encode($delivery, JSON_FORCE_OBJECT),
                "allow_order" => $allow_order,
                //"worldwide" => 0,
                "required_state" => $required_state,
            );

            if ($this->basic->update_data("ecommerce_zones", array("id" => $edit_table_id, "user_id" => $this->user_id), $updated_data)) {
                $result['status'] = "1";
                $result['message'] = $this->lang->line("Shipping Zone has been updated successfully.");
            }

            echo json_encode($result);

        }
    }

    public function ajax_get_states_shipping_zone()
    {
        $this->ajax_check();
        $result = array('data' => '');

        if ($_POST) {
            $search = $this->input->post("search", true);

            $country_ids = $this->input->post("country_ids", true);

            $table = "n_states";
            $select = "n_states.*";



            $where_custom = '';
            if(!empty($search)){
                $where_custom .= 'name LIKE "%'.$search.'%"';
            }

            if(!empty($country_ids)){
                if(!empty($search)){
                    $where_custom .= ' AND ';
                }
                $where_custom .= "country_id IN (".implode(', ', $country_ids).")";
            }

            if(!empty($where_custom)){
                $this->db->where($where_custom);
            }


            $info = $this->basic->get_data($table, '', $select, '', 100, '', 'name asc', '');


            $result = array();
            foreach ( $info as $v ) {
                $v['text'] = $v['name'];
                $result[] = $v;
            }

            $result = array('data' => $result);

            echo json_encode($result);

        }
    }

    public function delete_shipping_zone()
    {
        $this->ajax_check();
        $table_id = $this->input->post("table_id");
        $result = array('status' => '0', 'message' => $this->lang->line("Something went wrong, please try once again."));
        if ($table_id == "0" || $table_id == "") {
            echo json_encode($result);
            exit();
        }

        if ($this->basic->delete_data("ecommerce_zones", array("id" => $table_id, 'user_id' => $this->user_id, 'cant_delete' => 0)))
            echo json_encode(array('message' => $this->lang->line("Shipping Zone has been deleted successfully."), 'status' => '1'));
        else echo json_encode($result);
    }

    private function create_default_shipping_zone($store_id = 0, $user_id = 0){
        if($store_id != 0){

            $all_delivery = $this->get_all_delivery_methods();

            if(empty($all_delivery)){
                $this->create_default_delivery_methods($store_id, $user_id);
                $all_delivery = $this->get_all_delivery_methods();
            }

            $delivery = array();

            foreach($all_delivery as $key => $val){
                $delivery[$val['id']] = array(
                    'price' => $val['default_price'],
                    'active' => 1,
                    'name' => $val['name'],
                    'cod' => $val['cod'],
                );



            }

            $inserted_data = array
            (
                "store_id" => $store_id,
                "user_id" => $user_id,
                "name" => $this->lang->line('Worldwide'),
                "active" => 1,
                "cant_delete" => 1,
                "country" => '',
                "states" => '',
                "delivery_methods" => json_encode($delivery, JSON_FORCE_OBJECT),
                "allow_order" => 1,
                "worldwide" => 1,
                "required_state" => 0,
            );

            $this->basic->insert_data("ecommerce_zones", $inserted_data);



        }
    }

    private function confirmation_message_sender($cart_id=0,$subscriber_id="")
    {
        if($cart_id==0 || $subscriber_id=="") return false;
        $cart_select = array("ecommerce_cart.*","store_unique_id","page_id","messenger_content","sms_content","sms_api_id","email_content","email_api_id","email_subject","configure_email_table","label_ids","store_name");
        $cart_join = array('ecommerce_store'=>"ecommerce_cart.store_id=ecommerce_store.id,left");
        $cart_where = array('where'=>array("ecommerce_cart.subscriber_id"=>$subscriber_id,"ecommerce_cart.id"=>$cart_id,"ecommerce_store.status"=>"1"));
        $cart_data_2d = $this->basic->get_data("ecommerce_cart",$cart_where,$cart_select,$cart_join);
        if(!isset($cart_data_2d[0])) return false;

        $cart_data = $cart_data_2d[0];

        $store_unique_id = isset($cart_data['store_unique_id'])?$cart_data['store_unique_id']:'';
        $store_id = isset($cart_data['store_id'])?$cart_data['store_id']:'0';
        $user_id = isset($cart_data['user_id'])?$cart_data['user_id']:'0';
        $page_id = isset($cart_data['page_id'])?$cart_data['page_id']:'0';
        $sms_api_id = isset($cart_data['sms_api_id'])?$cart_data['sms_api_id']:'0';
        $sms_content = (isset($cart_data['sms_content']) && !empty($cart_data['sms_content'])) ? json_decode($cart_data['sms_content'],true) : array();
        $email_api_id = isset($cart_data['email_api_id'])?$cart_data['email_api_id']:'0';
        $email_content = (isset($cart_data['email_content']) && !empty($cart_data['email_content'])) ? json_decode($cart_data['email_content'],true) : array();
        $configure_email_table = isset($cart_data['configure_email_table'])?$cart_data['configure_email_table']:'';
        $email_subject = isset($cart_data['email_subject'])?$cart_data['email_subject']:'{{store_name}} | Order Update';
        $messenger_content = (isset($cart_data['messenger_content']) && !empty($cart_data['messenger_content'])) ? json_decode($cart_data['messenger_content'],true) : array();
        $action_type = isset($cart_data['action_type'])?$cart_data['action_type']:'checkout';
        $buyer_first_name = isset($cart_data['buyer_first_name'])?$cart_data['buyer_first_name']:'';
        $buyer_last_name = isset($cart_data['buyer_last_name'])?$cart_data['buyer_last_name']:'';
        $buyer_email = isset($cart_data['buyer_email'])?$cart_data['buyer_email']:'';
        $buyer_mobile = isset($cart_data['buyer_mobile'])?$cart_data['buyer_mobile']:'';
        $buyer_country = isset($cart_data['buyer_country'])?$cart_data['buyer_country']:'-';
        $buyer_state = isset($cart_data['buyer_state'])?$cart_data['buyer_state']:'-';
        $buyer_city = isset($cart_data['buyer_city'])?$cart_data['buyer_city']:'-';
        $buyer_address = isset($cart_data['buyer_address'])?$cart_data['buyer_address']:'-';
        $buyer_zip = isset($cart_data['buyer_zip'])?$cart_data['buyer_zip']:'-';
        $subtotal = isset($cart_data['subtotal'])?$cart_data['subtotal']:0;
        $payment_amount = isset($cart_data['payment_amount'])?$cart_data['payment_amount']:0;
        $currency = isset($cart_data['currency'])?$cart_data['currency']:'USD';
        $shipping = isset($cart_data['shipping'])?$cart_data['shipping']:0;
        $tax = isset($cart_data['tax'])?$cart_data['tax']:0;
        $coupon_code = isset($cart_data['coupon_code'])?$cart_data['coupon_code']:"";
        $discount = isset($cart_data['discount'])?$cart_data['discount']:0;
        $payment_method = isset($cart_data['payment_method'])?$cart_data['payment_method']:"Cash on Delivery";
        $ecom_store_name = isset($cart_data['store_name'])?$cart_data['store_name']:'';
        $ecom_store_email = isset($cart_data['store_email'])?$cart_data['store_email']:'';

        $checkout_url = base_url("ecommerce/cart/".$cart_id."?subscriber_id=".$subscriber_id);
        $order_url = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id);
        $store_url = base_url("ecommerce/store/".$store_unique_id."?subscriber_id=".$subscriber_id);
        $my_orders_url = base_url("ecommerce/my_orders/".$store_id."?subscriber_id=".$subscriber_id);

        if(empty($buyer_email))$buyer_email = isset($cart_data['bill_email'])?$cart_data['bill_email']:'';
        if(empty($buyer_mobile))$buyer_mobile = isset($cart_data['bill_mobile'])?$cart_data['bill_mobile']:'';

        $cart_info =  $this->basic->get_data("ecommerce_cart_item",array("where"=>array("cart_id"=>$cart_id)),"quantity,product_name,unit_price,coupon_info,attribute_info,thumbnail,product_id,woocommerce_product_id",array('ecommerce_product'=>"ecommerce_cart_item.product_id=ecommerce_product.id,left"));

        $curdate = date("Y-m-d H:i:s");

        $buyer_mobile = preg_replace("/[^0-9]+/", "", $buyer_mobile);

        $replace_variables = array(
            "store_name"=>$ecom_store_name,
            "store_url"=>$store_url,
            "order_no"=>$cart_id,
            "order_url"=>$order_url,
            "checkout_url"=>$checkout_url,
            "my_orders_url"=>$my_orders_url,
            "first_name"=>$buyer_first_name,
            "last_name"=>$buyer_last_name,
            "email"=>$buyer_email,
            "mobile"=>$buyer_mobile
        );

        $checkout_info = array();
        $confirmation_response = array();
        if($action_type=='checkout')
        {
            $i=0;
            $elements = array();

            foreach ($cart_info as $key => $value)
            {
                $elements[$i]['title'] = isset($value['product_name']) ? $value['product_name'] : "";

                $attribute_print = "";
                $attribute_info = json_decode($value["attribute_info"],true);
                if(!empty($attribute_info))
                {
                    $attribute_print_tmp = array();
                    foreach ($attribute_info as $key2 => $value2)
                    {
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

                if($value['thumbnail']=='') $image_url = base_url('assets/img/products/product-1.jpg');
                else $image_url = base_url('upload/ecommerce/'.$value['thumbnail']);
                if(isset($value['woocommerce_product_id']) && !is_null($value['woocommerce_product_id']) && $value['thumbnail']!='')
                    $image_url = $value['thumbnail'];


                $elements[$i]['image_url'] = $image_url;
                $i++;
                $update_sales_count_sql = "UPDATE ecommerce_product SET sales_count=sales_count+".$value["quantity"]." WHERE id=".$value["product_id"];
                $this->basic->execute_complex_query($update_sales_count_sql);
                $update_stock_count_sql = "UPDATE ecommerce_product SET stock_item=stock_item-".$value["quantity"]." WHERE stock_item>0 AND id=".$value["product_id"];
                $this->basic->execute_complex_query($update_stock_count_sql);
            }

            if(empty($buyer_address)) $buyer_address = '-';
            if(empty($buyer_city)) $buyer_city = '-';
            if(empty($buyer_zip)) $buyer_zip = '-';
            if(empty($buyer_state)) $buyer_state = '-';
            if(empty($buyer_country)) $buyer_country = '-';

            if($cart_data['store_pickup']=='0')
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

            $recipient_name = $buyer_first_name." ".$buyer_last_name;
            if(trim($recipient_name=="")) $recipient_name="-";

            $summary =array
            (
                "subtotal"=> $subtotal,
                "shipping_cost"=>$shipping,
                "total_tax"=> $tax,
                "total_cost"=> $payment_amount
            );

            $adjustments = array
            (
                0 => array
                (
                    "name"=> $coupon_code,
                    "amount"=> $discount
                )
            );

            $payload = array
            (
                "template_type" => "receipt",
                "recipient_name"=> $recipient_name,
                "order_number"=> $cart_id,
                "currency"=> $currency,
                "payment_method"=> $payment_method,
                "order_url"=> $order_url,
                "timestamp"=> time(),
                "address" => $address,
                "summary" => $summary,
                "elements" => $elements
            );
            if($coupon_code!="") $payload['adjustments'] = $adjustments;

            $messenger_checkout_confirmation = array
            (
                "recipient" => array("id"=>$subscriber_id),
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
            $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array('where'=>array('id'=>$page_id)));
            $page_access_token = isset($page_info[0]['page_access_token']) ? $page_info[0]['page_access_token'] : "";

            // template 1
            $intro_text = isset($messenger_content["checkout"]["checkout_text"]) ? $messenger_content["checkout"]["checkout_text"] : "";
            if($intro_text!="")
            {
                $intro_text = $this->spin_and_replace($intro_text,$replace_variables);
                $messenger_confirmation_template1 = json_encode(array("recipient"=>array("id"=>$subscriber_id),"message"=>array("text"=>$intro_text)));
                $this->send_messenger_reminder($messenger_confirmation_template1,$page_access_token,$store_id,$subscriber_id);
            }

            // template 2
            $messenger_confirmation_template2 = json_encode($messenger_checkout_confirmation);
            $sent_response = $this->send_messenger_reminder($messenger_confirmation_template2,$page_access_token,$store_id,$subscriber_id);

            // template 3
            $after_checkout_text = isset($messenger_content["checkout"]["checkout_text_next"]) ? $messenger_content["checkout"]["checkout_text_next"] : "";
            $after_checkout_btn = isset($messenger_content["checkout"]["checkout_btn_next"]) ? $messenger_content["checkout"]["checkout_btn_next"] : "MY ORDERS";
            if($after_checkout_text!="")
            {
                $after_checkout_text = $this->spin_and_replace($after_checkout_text,$replace_variables);
                $messenger_confirmation_template3 = array
                (
                    "recipient" => array("id"=>$subscriber_id),
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
                                        'buttons'=> array(
                                            0=>array(
                                                "type"=>"web_url",
                                                "url"=>$my_orders_url,
                                                "title"=>$after_checkout_btn,
                                                "messenger_extensions" => 'true',
                                                "webview_height_ratio" => 'full'
                                            )
                                        )
                                    ),
                            )
                    )
                );
                $this->send_messenger_reminder(json_encode($messenger_confirmation_template3),$page_access_token,$store_id,$subscriber_id);
            }
            $confirmation_response['messenger'] = $sent_response;
            // Messenger send block


            //  SMS Sending block
            if($buyer_mobile!="" && $sms_api_id!='0')
            {
                $checkout_text_sms = isset($sms_content['checkout']['checkout_text']) ? $this->spin_and_replace($sms_content['checkout']['checkout_text'],$replace_variables,false) : "";
                $checkout_text_sms = str_replace(array("'",'"'),array('`','`'),$checkout_text_sms);

                $sms_response = array("response"=> 'missing param',"status"=>'0');

                if(trim($checkout_text_sms)!="")
                {
                    $this->load->library('Sms_manager');
                    $this->sms_manager->set_credentioal($sms_api_id,$user_id);
                    try
                    {
                        $response = $this->sms_manager->send_sms($checkout_text_sms, $buyer_mobile);

                        if(isset($response['id']) && !empty($response['id']))
                        {
                            $message_sent_id = $response['id'];
                            $sms_response = array("response"=> $message_sent_id,"status"=>'1');
                        }
                        else
                        {   if(isset($response['status']) && !empty($response['status']))
                        {
                            $message_sent_id = $response["status"];
                            $sms_response = array("response"=> $message_sent_id,"status"=>'0');
                        }
                        }

                    }
                    catch(Exception $e)
                    {
                        $message_sent_id = $e->getMessage();
                        $sms_response = array("response"=> $message_sent_id,"status"=>'0');
                    }
                }

                $confirmation_response['sms']=$sms_response;
            }
            //  SMS Sending block

            //  Email Sending block
            if($buyer_email!="" && $email_api_id!='0')
            {
                $checkout_text_email = isset($email_content['checkout']['checkout_text']) ? $this->spin_and_replace($email_content['checkout']['checkout_text'],$replace_variables,false) : "";
                $email_subject = $this->spin_and_replace($email_subject,$replace_variables,false);
                $from_email = "";

                if ($configure_email_table == "email_smtp_config")
                {
                    $from_email = "smtp_".$email_api_id;
                }
                elseif ($configure_email_table == "email_mandrill_config")
                {
                    $from_email = "mandrill_".$email_api_id;
                }
                elseif ($configure_email_table == "email_sendgrid_config")
                {
                    $from_email = "sendgrid_".$email_api_id;
                }
                elseif ($configure_email_table == "email_mailgun_config")
                {
                    $from_email = "mailgun_".$email_api_id;
                }

                $email_response = array("response"=> 'missing param',"status"=>'0');
                if(trim($checkout_text_email)!='')
                {
                    try
                    {
                        $response = $this->_email_send_function($from_email, $checkout_text_email, $buyer_email, $email_subject, $attachement='', $filename='',$user_id);

                        if(isset($response) && !empty($response) && $response == "Submited")
                        {
                            $message_sent_id = $response;
                            if($message_sent_id=="Submited") $message_sent_id = "Submitted";
                            $email_response = array("response"=> $message_sent_id,"status"=>'1');
                        }
                        else
                        {
                            $message_sent_id = $response;
                            $email_response = array("response"=> $message_sent_id,"status"=>'0');
                        }
                    }
                    catch(Exception $e)
                    {
                        $message_sent_id = $e->getMessage();
                        $email_response = array("response"=> $message_sent_id,"status"=>'0');
                    }
                }
                $confirmation_response['email']=$email_response;
            }
            //  Email Sending block

            $confirmation_response = json_encode($confirmation_response);


            //file_put_contents(APPPATH.'mollie.txt', $confirmation_response, LOCK_EX);

            $this->basic->update_data('ecommerce_cart',array("id"=>$cart_id,"subscriber_id"=>$subscriber_id),array("confirmation_response"=>$confirmation_response));
            if($coupon_code!="")
            {
                $coupon_used_sql = "UPDATE ecommerce_coupon SET used=used+1 WHERE coupon_code='".$coupon_code."' AND store_id=".$store_id;
                $this->basic->execute_complex_query($coupon_used_sql);
            }

        }

        // Email Send to Seller

        $product_short_name = $this->config->item('product_short_name');
        $from = $this->config->item('institute_email');
        $mask = $this->config->item('product_name');
        $where = array();
        $where['where'] = array('id'=>$user_id);
        $user_email = $this->basic->get_data('users',$where,$select='');

        // echo $this->db->last_query();
        $order_confirmation_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'emcommerce_sale_admin')),array('subject','message'));
        if(isset($order_confirmation_email_template[0]) && $order_confirmation_email_template[0]['subject'] != '' && $order_confirmation_email_template[0]['message'] != '')
        {

            $to = $ecom_store_email;
            $url = base_url();

            $subject = str_replace(array('#APP_NAME#','#APP_URL#','#STORE_NAME#','#INVOICE_URL#'),array($mask,$url,$ecom_store_name,$order_url),$order_confirmation_email_template[0]['subject']);

            $message = str_replace(array('#APP_NAME#','#APP_URL#','#STORE_NAME#','#INVOICE_URL#'),array($mask,$url,$ecom_store_name,$order_url),$order_confirmation_email_template[0]['message']);

            //send mail to user
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=1);
        }
        // End of Email Send to Seller



    }

    private function spin_and_replace($str="",$replace = array(),$is_spin=true)
    {
        if(!isset($replace['store_name'])) $replace['store_name'] = '';
        if(!isset($replace['store_url'])) $replace['store_url'] = '';
        if(!isset($replace['order_no'])) $replace['order_no'] = '';
        if(!isset($replace['order_url'])) $replace['order_url'] = '';
        if(!isset($replace['checkout_url'])) $replace['checkout_url'] = '';
        if(!isset($replace['my_orders_url'])) $replace['my_orders_url'] = '';
        if(!isset($replace['first_name'])) $replace['first_name'] = '';
        if(!isset($replace['last_name'])) $replace['last_name'] = '';
        if(!isset($replace['email'])) $replace['email'] = '';
        if(!isset($replace['mobile'])) $replace['mobile'] = '';
        $replace_values = array_values($replace);
        $str = str_replace(array("{{store_name}}","{{store_url}}","{{order_no}}","{{order_url}}","{{checkout_url}}","{{my_orders_url}}","{{first_name}}","{{last_name}}","{{email}}","{{mobile}}"), $replace_values, $str);
        if($is_spin) return spintax_process($str);
        else return $str;
    }

    public function add_store_action()
    {
        $this->ajax_check();
        $status=$this->_check_usage($module_id=268,$request=1);
        if($status=="3")  //monthly limit is exceeded, can not create another campaign this month
        {
            echo json_encode(array("status" => "0", "message" =>$this->lang->line("Limit has been exceeded. You can can not create more stores.")));
            exit();
        }

        $post=$_POST;

        $tag_allowed = array("terms_use_link","refund_policy_link");
        foreach ($post as $key => $value)
        {
            if(!is_array($value) && !in_array($key, $tag_allowed)) $temp = strip_tags($value);
            else $temp = $value;
            $$key=$this->security->xss_clean($temp);
        }

        $created_at = date("Y-m-d H:i:s");    $store_unique_id = $this->user_id.time();
        if($this->basic->is_exist("ecommerce_store",array("store_unique_id"=>$store_unique_id)))
        {
            echo json_encode(array("status" => "0", "message" =>$this->lang->line("Something went wrong, please try again.")));
            exit();
        }

        $this->db->trans_start();

        if(!isset($label_ids)) $label_ids=array();
        if(!isset($status) || $status=='') $status='0';

        $reminder_default = $this->reminder_default();
        $messenger_content = array
        (
            "checkout"=>array
            (
                "checkout_text"=>$reminder_default['messenger']['checkout']['checkout_text'],
                "checkout_text_next" => $reminder_default['messenger']['checkout']['checkout_text_next'],
                "checkout_btn_next"=>"MY ORDERS"
            )
        );
        if($refund_policy_link=="<p></p>") $refund_policy_link="";
        if($terms_use_link=="<p></p>") $terms_use_link="";

        $store_type = $this->input->post('store_type',true);
        if($store_type == '') $store_type = 'physical';

        $cod_enabled = '1';
        if($store_type == 'digital') $cod_enabled = '0';

        $insert_data = array(
            "user_id"=>$this->user_id,
            "page_id"=>$page,
            "created_at"=>$created_at,
            "store_unique_id"=>$store_unique_id,
            "store_type" => $store_type,
            "store_name"=>$store_name,
            "store_logo"=>$store_logo,
            "store_favicon"=>$store_favicon,
            "store_email"=> $store_email,
            "store_phone"=> $store_phone,
            "store_country"=> $store_country,
            "store_state"=> $store_state,
            "store_city"=> $store_city,
            "store_zip"=> $store_zip,
            "store_address"=> $store_address,
            "refund_policy_link"=> strip_tags($refund_policy_link,$this->editor_allowed_tags),
            "terms_use_link"=> strip_tags($terms_use_link,$this->editor_allowed_tags),
            "store_locale"=> $store_locale,
            "pixel_id"=> $pixel_id,
            "google_id"=> $google_id,
            "status"=> $status,
            "label_ids"=>implode(',',$label_ids),
            "messenger_content"=>json_encode($messenger_content),
            "manual_enabled"=>"0",
            "cod_enabled"=>$cod_enabled
        );
        $this->basic->insert_data("ecommerce_store",$insert_data);
        $insert_id = $this->db->insert_id();
        $this->_insert_usage_log($module_id=268,$request=1);
        $this->db->trans_complete();

        //$this->create_default_delivery_methods($insert_id, $this->user_id);
        $this->create_default_shipping_zone($insert_id, $this->user_id);

        if($this->db->trans_status() === false)
        {
            echo json_encode(array('status'=>'0','message'=>"".$this->lang->line('Something went wrong, please try again.')));
            exit();
        }
        else
        {
            $this->session->set_userdata("ecommerce_selected_store",$insert_id);
            echo json_encode(array('status'=>'1','message'=>$this->lang->line('Store has been created successfully.')));
            exit();
        }
    }

    private function reminder_default()
    {
        return array
        (
            'messenger' => array
            (
                'reminder' =>array
                (
                    'reminder_text' => 'Hi {{first_name}},
        You wanted to buy something! Seems like you have forgotten.',
                    'reminder_text_checkout' => 'Stock limited, complete your order before it is out of stock.'
                ),
                'checkout' =>array
                (
                    'checkout_text' => 'Congratulations {{first_name}}!
        Thanks for shopping from our store. You made the right choice. If you need any information, just leave us a message here.',
                    'checkout_text_next' => 'You can see your order history and status here.'
                )
            ),
            'sms' => array
            (
                'reminder' =>array('reminder_text' => 'Hi, you wanted to buy something! Seems like you have forgotten : {{order_url}}
        {{store_name}}'),
                'checkout' =>array('checkout_text' => 'Thanks for shopping from our store. You made the right choice.
        {{store_name}}')
            ),
            'email' => array
            (
                'reminder' =>array('reminder_text' => 'Hi {{first_name}},<br>You wanted to buy something! Seems like you have forgotten. Stock limited, complete your order before it is out of stock : <a href="{{checkout_url}}" target="_blank">Checkout here</a><br><br>Happy shopping :)<br><a href="{{store_url}}" target="_blank">{{store_name}}</a> Team'),
                'checkout' =>array('checkout_text' => 'Congratulations {{first_name}}!<br>Thanks for shopping from our store. You made the right choice. If you need any information, just leave us a message here.<br><br>You can see your order history and status <a href="{{my_orders_url}}" target="_blank"> clicking here</a>. <br><br>Have a nice day :)<br><a href="{{store_url}}" target="_blank">{{store_name}}</a> Team')
            )
        );
    }

    public function store_list()
    {
        if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
        if ($this->session->userdata('user_type') != 'Admin' && !in_array(268, $this->module_access)) redirect('home/login', 'location');
        $this->member_validity();
        $data['body'] = 'ecommerce/store_list';
        $data['page_title'] = $this->lang->line("Ecommerce Store");
        $data['data_days'] = $data_days = 30;

        $store_data=$this->basic->get_data("ecommerce_store",array("where"=>array("ecommerce_store.user_id"=>$this->user_id)),'ecommerce_store.*,page_name,page_profile,facebook_rx_fb_page_info.page_id as fb_page_id',array('facebook_rx_fb_page_info'=>"facebook_rx_fb_page_info.id=ecommerce_store.page_id,left"),'',$start=NULL,$order_by="store_name ASC");

        $default_store_id  = isset($store_data[0]['id']) ? $store_data[0]['id'] : "";


        $store_id = $this->input->post('store_id');
        if($store_id =="" && $this->session->userdata("ecommerce_selected_store")=="")  $store_id = $default_store_id;

        if($store_id!="") $this->session->set_userdata("ecommerce_selected_store",$store_id);

        $store_id = $this->session->userdata("ecommerce_selected_store");

        $current_store_data = $this->get_current_store_data();

        $default_store_type = isset($current_store_data['store_type']) ? $current_store_data['store_type'] : "";

        $default_store_name = isset($current_store_data['store_name']) ? $current_store_data['store_name'] : "";
        $default_store_unique_id = isset($current_store_data['store_unique_id']) ? $current_store_data['store_unique_id'] : "";
        $default_store_title_display = !empty($default_store_unique_id) ? "<a target='_BLANK' href='".base_url("ecommerce/store/".$default_store_unique_id)."'>".$default_store_name."</a>" : "";
        $this->session->set_userdata("ecommerce_selected_store_title_display",$default_store_title_display);
        $this->session->set_userdata("ecommerce_selected_store_title",$default_store_name);
        $this->session->set_userdata("ecommerce_selected_store_type",$default_store_type);

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $currency = $this->input->post('currency');

        if($to_date=='') $to_date = date("Y-m-d");
        if($from_date=='') $from_date = date("Y-m-d",strtotime("$to_date - ".$data_days." days"));

        $ecommerce_config = $this->get_ecommerce_config();
        if($this->input->post('from_date')=="") $from_date=$from_date." 00:00:00";
        if($this->input->post('to_date')=="") $to_date=$to_date." 23:59:59";
        if($this->input->post('currency')=="") $currency= isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";

        $this->session->set_userdata("ecommerce_from_date",$from_date);
        $this->session->set_userdata("ecommerce_to_date",$to_date);
        $this->session->set_userdata("ecommerce_currency",$currency);


        $where_simple2=array();
        $where_simple2['ecommerce_cart.currency'] = $currency;
        $where_simple2['ecommerce_cart.store_id'] = $store_id;
        $where_simple2['ecommerce_cart.user_id'] = $this->user_id;
        $where_simple2['ecommerce_cart.updated_at >='] = $from_date;
        $where_simple2['ecommerce_cart.updated_at <='] = $to_date;
        $where2  = array('where'=>$where_simple2);
        $select2 = array("ecommerce_cart.*","first_name","last_name","full_name","profile_pic","email","image_path");
        $table2 = "ecommerce_cart";
        $join2 = array('messenger_bot_subscriber'=>"messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left");
        //$cart_data = $this->basic->get_data($table2,$where2,$select2,$join2,$limit2='',$start2='',$order_by2='ecommerce_cart.updated_at desc');

        // $i=0;
        // if(isset($store_data[$i]))
        // {
        //   $store_data[$i]["page_name"] = "<a data-toggle='tooltip' data-original-title='".$this->lang->line('Visit Page')."' target='_BLANK' href='https://facebook.com/".$store_data[$i]["fb_page_id"]."'>".$store_data[$i]["page_name"]."</a>";

        //   $store_data[$i]['created_at'] = date('jS F y', strtotime($store_data[$i]['created_at']));
        // }
        // echo "<pre>"; print_r($store_data); exit;

        $data["store_data"] = $store_data;

       // $data["cart_data"] = $cart_data;
        // $data['country_names'] = $this->get_country_names();
        $data['currency_icons'] = $this->currency_icon();
        $data['product_list'] = $this->get_product_list_array($store_id);



        $data['top_products'] = $this->basic->get_data("ecommerce_cart_item",array("where"=>array("ecommerce_cart_item.store_id"=>$store_id,"ecommerce_cart.paid_at >="=>$from_date,"ecommerce_cart.paid_at <="=>$to_date),            "where_not_in" =>
            array(
                'status' => array('pending','rejected'),
            )),"sum(quantity) as sales_count,product_id, sum(unit_price*quantity) as sales_total_amount",$join=array('ecommerce_cart'=>"ecommerce_cart.id=ecommerce_cart_item.cart_id,right"),$limit='10',$start=NULL,$order_by='sales_count desc',$group_by='product_id');

        $data['currecny_list_all'] = $this->currecny_list_all();
        $data['ecommerce_config'] = $ecommerce_config;

        //new ecommerce stats
        $curtime = date("Y-m-d H:i:s");


        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => date("Y-m-d").' 00:00:00',
                    'paid_at <=' => date("Y-m-d").' 23:59:59',
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");

        $db_ret_2 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as orders");

        $where['where']['last_completed_hour >'] = 0;
        $db_ret_3 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as orders");

        if(empty($db_ret[0]['sum_payment_amount'])){
            $db_ret[0]['sum_payment_amount']=0;
        }

        if(empty($db_ret[0]['sum_subtotal'])){
            $db_ret[0]['sum_subtotal']=0;
        }

        if(empty($db_ret_2[0]['orders'])){
            $db_ret_2[0]['orders']=0;
        }

        if(empty($db_ret_3[0]['rec_cart'])){
            $db_ret_3[0]['rec_cart']=0;
        }

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => date("Y-m-d", strtotime('-1 day')).' 00:00:00',
                    'paid_at <=' => date("Y-m-d", strtotime('-1 day')).' 23:59:59',
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $db_ret_old = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");

        if(empty($db_ret_old[0]['sum_payment_amount'])){
            $db_ret_old[0]['sum_payment_amount'] = 0;
        }

        if(empty($db_ret_old[0]['sum_subtotal'])){
            $db_ret_old[0]['sum_subtotal'] = 0;
        }

        if(!empty($db_ret_old[0]['sum_payment_amount']) AND $db_ret_old[0]['sum_payment_amount']>0){
            $change_per = ($db_ret[0]['sum_payment_amount'] - $db_ret_old[0]['sum_payment_amount'] ) / $db_ret_old[0]['sum_payment_amount'] * 100;
        }else{
            $change_per = 100;
        }



        $data['n_stats_today'] = array(
            'value' => $db_ret[0]['sum_payment_amount'],
            'net_sales' => $db_ret[0]['sum_subtotal'],
            'orders' => $db_ret_2[0]['orders'],
            'rec_cart' => $db_ret_3[0]['rec_cart'],
            'val_perc' => round($change_per),
        );

                $where = array(
                    "where"=>
                        array(
                            "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                            'paid_at >=' => date("Y-m").'-1 00:00:00',
                            'paid_at <=' => $curtime,
                        ),
                    "where_not_in" =>
                        array(
                            'status' => array('pending','rejected'),
                        ),
                );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");

        $db_ret_2 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as orders");

        $where['where']['last_completed_hour >'] = '0';
        $db_ret_3 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as rec_cart");

        if(empty($db_ret[0]['sum_payment_amount'])){
            $db_ret[0]['sum_payment_amount']=0;
        }

        if(empty($db_ret[0]['sum_subtotal'])){
            $db_ret[0]['sum_subtotal']=0;
        }

        if(empty($db_ret_2[0]['orders'])){
            $db_ret_2[0]['orders']=0;
        }

        if(empty($db_ret_3[0]['rec_cart'])){
            $db_ret_3[0]['rec_cart']=0;
        }

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => date("Y-m", strtotime('-1 month')).'-1 00:00:00',
                    'paid_at <=' => date("Y-m-d", strtotime($curtime.'-1 month')).' 23:59:59',
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $db_ret_old = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");

        if(empty($db_ret_old[0]['sum_payment_amount'])){
            $db_ret_old[0]['sum_payment_amount'] = 0;
        }

        if(empty($db_ret_old[0]['sum_subtotal'])){
            $db_ret_old[0]['sum_subtotal'] = 0;
        }

        if(!empty($db_ret_old[0]['sum_payment_amount']) AND $db_ret_old[0]['sum_payment_amount']>0){
            $change_per = ($db_ret[0]['sum_payment_amount'] - $db_ret_old[0]['sum_payment_amount'] ) / $db_ret_old[0]['sum_payment_amount'] * 100;
        }else{
            $change_per = 100;
        }

        $data['n_stats_month'] = array(
            'value' => $db_ret[0]['sum_payment_amount'],
            'net_sales' => $db_ret[0]['sum_subtotal'],
            'orders' => $db_ret_2[0]['orders'],
            'rec_cart' => $db_ret_3[0]['rec_cart'],
            'val_perc' => round($change_per),
        );

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => date("Y").'-1-1 00:00:00',
                    'paid_at <=' => $curtime,
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");

        $db_ret_2 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as orders");

        $where['where']['last_completed_hour >'] = '0';
        $db_ret_3 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as rec_cart");

        if(empty($db_ret[0]['sum_payment_amount'])){
            $db_ret[0]['sum_payment_amount']=0;
        }

        if(empty($db_ret[0]['sum_subtotal'])){
            $db_ret[0]['sum_subtotal']=0;
        }

        if(empty($db_ret_2[0]['orders'])){
            $db_ret_2[0]['orders']=0;
        }

        if(empty($db_ret_3[0]['rec_cart'])){
            $db_ret_3[0]['rec_cart']=0;
        }

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => date("Y", strtotime('-1 year')).'-1-1 00:00:00',
                    'paid_at <=' => date("Y-m-d", strtotime($curtime.'-1 year')).' 23:59:59',
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $db_ret_old = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");

        if(empty($db_ret_old[0]['sum_payment_amount'])){
            $db_ret_old[0]['sum_payment_amount'] = 0;
        }

        if(empty($db_ret_old[0]['sum_subtotal'])){
            $db_ret_old[0]['sum_subtotal'] = 0;
        }

        if(!empty($db_ret_old[0]['sum_payment_amount']) AND $db_ret_old[0]['sum_payment_amount']>0){
            $change_per = ($db_ret[0]['sum_payment_amount'] - $db_ret_old[0]['sum_payment_amount'] ) / $db_ret_old[0]['sum_payment_amount'] * 100;
        }else{
            $change_per = 100;
        }

        $data['n_stats_year'] = array(
            'value' => $db_ret[0]['sum_payment_amount'],
            'net_sales' => $db_ret[0]['sum_subtotal'],
            'orders' => $db_ret_2[0]['orders'],
            'rec_cart' => $db_ret_3[0]['rec_cart'],
            'val_perc' => round($change_per),
        );


        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => $from_date,
                    'paid_at <=' => $to_date,
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");

        $db_ret_2 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as orders");

        $where['where']['last_completed_hour >'] = 0;
        $db_ret_3 = $this->basic->get_data("ecommerce_cart",$where,"count(*) as orders");

        if(empty($db_ret[0]['sum_payment_amount'])){
            $db_ret[0]['sum_payment_amount']=0;
        }

        if(empty($db_ret[0]['sum_subtotal'])){
            $db_ret[0]['sum_subtotal']=0;
        }

        if(empty($db_ret_2[0]['orders'])){
            $db_ret_2[0]['orders']=0;
        }

        if(empty($db_ret_3[0]['rec_cart'])){
            $db_ret_3[0]['rec_cart']=0;
        }

//        $where = array(
//            "where"=>
//                array(
//                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
//                    'paid_at >=' => $from_date,
//                    'paid_at <=' => $to_date,
//                ),
//            "where_not_in" =>
//                array(
//                    'status' => array('pending','rejected'),
//                ),
//        );
//        $db_ret_old = $this->basic->get_data("ecommerce_cart",$where,"sum(payment_amount) as sum_payment_amount, sum(subtotal) as sum_subtotal");
//
//        if(empty($db_ret_old[0]['sum_payment_amount'])){
//            $db_ret_old[0]['sum_payment_amount'] = 0;
//        }
//
//        if(empty($db_ret_old[0]['sum_subtotal'])){
//            $db_ret_old[0]['sum_subtotal'] = 0;
//        }
//
//        if(!empty($db_ret_old[0]['sum_payment_amount']) AND $db_ret_old[0]['sum_payment_amount']>0){
//            $change_per = ($db_ret[0]['sum_payment_amount'] - $db_ret_old[0]['sum_payment_amount'] ) / $db_ret_old[0]['sum_payment_amount'] * 100;
//        }else{
//            $change_per = 100;
//        }



        $data['n_stats_period'] = array(
            'value' => $db_ret[0]['sum_payment_amount'],
            'net_sales' => $db_ret[0]['sum_subtotal'],
            'orders' => $db_ret_2[0]['orders'],
            'rec_cart' => $db_ret_3[0]['rec_cart'],
            //'val_perc' => round($change_per),
        );


        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => $from_date,
                    'paid_at <=' => $to_date,
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $select = '
        cast(paid_at as date) as stat_day,
        sum(payment_amount) AS sum_payment_amount,
        sum(subtotal) as sum_subtotal
        ';
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,$select,'','','','stat_day','cast(paid_at as date)');

        $earn_dat = array();
        foreach($db_ret as $v){
            $earn_dat[$v['stat_day']] = array(
                'sum_payment_amount' => $v['sum_payment_amount'],
                'sum_subtotal' => $v['sum_subtotal'],
            );
        }

        $begin = new DateTime($from_date);
        $end = new DateTime($to_date);

        $dates = array();
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);


        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => date("Y").'-1-1 00:00:00',
                    'paid_at <=' => date("Y").'-12-31 23:59:59',
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $select = '
       count(*) as count
        ';
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,$select);

        $all_orders = $db_ret[0]['count'];


        $select = '
          sum(payment_amount) AS sum_payment_amount,
        ';
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,$select);

        if(empty($all_orders)){
            $this_year_av_payment_amount = 0;
        }else{
            $this_year_av_payment_amount = round($db_ret[0]['sum_payment_amount'] / $all_orders);
        }


        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => date("Y", strtotime('-1 year')).'-1-1 00:00:00',
                    'paid_at <=' => date("Y", strtotime('-1 year')).'-12-31 23:59:59',
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected'),
                ),
        );
        $select = '
       count(*) as count
        ';
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,$select);

        $all_orders = $db_ret[0]['count'];



        $select = '
          sum(payment_amount) AS sum_payment_amount,
        ';
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,$select);


        if(empty($all_orders)){
            $last_year_av_payment_amount = 0;
        }else{
            $last_year_av_payment_amount = round($db_ret[0]['sum_payment_amount'] / $all_orders);
        }


        $ret_dates = array();
        $sum_pay = array();
        $sum_subtotal = array();
        $last_year_av_payment_amount_ar = array();
        $this_year_av_payment_amount_ar = array();
        foreach ($period as $dt) {
            $ret_dates[] = $dt->format("Y-m-d");
            $last_year_av_payment_amount_ar[] = $last_year_av_payment_amount;
            $this_year_av_payment_amount_ar[] = $this_year_av_payment_amount;
            if(empty($earn_dat[$dt->format("Y-m-d")])){
                $sum_pay[] = 0;
                $sum_subtotal[] = 0;
            }else{
                $new_date = $earn_dat[$dt->format("Y-m-d")];
                $sum_pay[] = $new_date['sum_payment_amount'];
                $sum_subtotal[] = $new_date['sum_subtotal'];
            }
        }

        $data['earn_stat'] = array(
            'dates'=> implode("','",$ret_dates),
            'sum_pay'=> implode(',',$sum_pay),
            'sum_subtotal'=> implode(',',$sum_subtotal),
            'last_year_av_payment_amount' => implode(',',$last_year_av_payment_amount_ar),
            'this_year_av_payment_amount' => implode(',',$this_year_av_payment_amount_ar),
        );

        //
        $where2  = array(
            "where"=>array(
                "ecommerce_cart_item.store_id"=>$store_id,
                "ecommerce_cart.paid_at >="=>$from_date,
                "ecommerce_cart.paid_at <="=>$to_date
            ),
            "where_not_in" => array(
                'ecommerce_cart.status' => array('pending','rejected'),
            )
        );
        $select2 = array("messenger_bot_subscriber.subscriber_type, count(messenger_bot_subscriber.subscriber_type) as count_type");
        $table2 = "ecommerce_cart_item";
        $join2 = array(
            'ecommerce_cart'=>"ecommerce_cart.id=ecommerce_cart_item.cart_id,right",
            'messenger_bot_subscriber'=>"messenger_bot_subscriber.subscribe_id=ecommerce_cart.subscriber_id,left",

        );
        $order_by='';
        $group_by='';
        $order_sub_type = $this->basic->get_data($table2,$where2,$select2,$join2,$limit2=10,$start2='',$order_by);


        $sub_type_labels = array();
        $sub_type_series = array();

        foreach($order_sub_type as $v){
            if($v['subscriber_type']=='system'){$v['subscriber_type']= $this->lang->line('Direct');}
            $sub_type_labels[] = $v['subscriber_type'];
            $sub_type_series[] = $v['count_type'];
        }

        $data['n_sub_type'] = array(
            'labels'=> implode("','",$sub_type_labels),
            'series'=> implode(",",$sub_type_series),
        );


//
        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => $from_date,
                    'paid_at <=' => $to_date,
                   'action_type' => 'checkout',
                ),
            "where_not_in" =>
                array(
                    'status' => array('pending','rejected','approved'),
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"count(*) as total");
        if(empty($db_ret[0]['total'])){
            $order_complete = 0;
        }else{
            $order_complete = $db_ret[0]['total'];
        }

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => $from_date,
                    'paid_at <=' => $to_date,
                    'action_type' => 'checkout',
                    'status' => 'pending',
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"count(*) as total");
        if(empty($db_ret[0]['total'])){
            $order_placed = 0;
        }else{
            $order_placed = $db_ret[0]['total'];
        }

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'initial_date >=' => $from_date,
                    'initial_date <=' => $to_date,
                    'action_type' => 'add',
                    'status' => 'pending',
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"count(*) as total");

        if(empty($db_ret[0]['total'])){
            $order_cart = 0;
        }else{
            $order_cart = $db_ret[0]['total'];
        }

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'paid_at >=' => $from_date,
                    'paid_at <=' => $to_date,
                    'action_type' => 'checkout',
                    'status' => 'approved',
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"count(*) as total");
        if(empty($db_ret[0]['total'])){
            $order_approved = 0;
        }else{
            $order_approved = $db_ret[0]['total'];
        }

        $where = array(
            "where"=>
                array(
                    "store_id"=>$this->session->userdata("ecommerce_selected_store"),
                    'initial_date >=' => $from_date,
                    'initial_date <=' => $to_date,
                    'action_type' => 'checkout',
                    'status' => 'rejected',
                ),
        );
        $db_ret = $this->basic->get_data("ecommerce_cart",$where,"count(*) as total");
        if(empty($db_ret[0]['total'])){
            $order_rejected = 0;
        }else{
            $order_rejected = $db_ret[0]['total'];
        }


        $data['n_orders_type'] = array(
            'labels'=> "'".$this->lang->line('Completed')."','".$this->lang->line('Placed')."','".$this->lang->line('Added to cart')."','".$this->lang->line('Approved')."','".$this->lang->line('Rejected')."'",
            'series'=> $order_complete.','.$order_placed.','.$order_cart.','.$order_approved.','.$order_rejected,
        );


        $this->_viewcontroller($data);
    }

    private function get_current_store_data()
    {
        $data = $this->basic->get_data("ecommerce_store",array("where"=>array("id"=>$this->session->userdata("ecommerce_selected_store"),"status"=>"1")),"store_type,store_name,id,store_unique_id");
        if(isset($data[0])) return $data[0];
        else return array();
    }

    public function add_coupon_action()
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET')
            redirect('home/access_forbidden','location');

        if($_POST)
        {
            $this->form_validation->set_rules('store_id', '<b>'.$this->lang->line("Store").'</b>', 'trim|required');
            $this->form_validation->set_rules('coupon_code', '<b>'.$this->lang->line("Coupon code").'</b>', 'trim|required|callback_check_coupon');
            $this->form_validation->set_rules('coupon_amount', '<b>'.$this->lang->line("Coupon amount").'</b>', 'trim|required');
            $this->form_validation->set_rules('expiry_date', '<b>'.$this->lang->line("Expiry date").'</b>', 'trim|required');
            $this->form_validation->set_rules('max_usage_limit', '<b>'.$this->lang->line("Max usage limit").'</b>', 'trim|numeric');
            $this->form_validation->set_rules('coupon_apply', '<b>'.$this->lang->line("Coupon apply").'</b>', 'trim');

            if ($this->form_validation->run() == FALSE)
            {
                $this->add_coupon();
            }
            else
            {

                $store_id=$this->input->post('store_id',true);
                $product_ids=$this->input->post('product_ids',true);
                $coupon_type=$this->input->post('coupon_type',true);
                $coupon_code=strip_tags($this->input->post('coupon_code',true));
                $coupon_amount=$this->input->post('coupon_amount',true);
                $expiry_date=$this->input->post('expiry_date',true);
                $max_usage_limit=$this->input->post('max_usage_limit',true);
                $free_shipping_enabled=$this->input->post('free_shipping_enabled',true);
                $status=$this->input->post('status',true);
                $coupon_apply=$this->input->post('coupon_apply',true);

                if($status=='') $status='0';
                if($free_shipping_enabled=='') $free_shipping_enabled='0';
                if(!isset($product_ids) || !is_array($product_ids) || empty($product_ids)) $product_ids = '0';
                else $product_ids = implode(',', $product_ids);

                $data=array
                (
                    'store_id'=>$store_id,
                    'product_ids'=>$product_ids,
                    'coupon_type'=>$coupon_type,
                    'coupon_code'=>$coupon_code,
                    'coupon_amount'=>$coupon_amount,
                    'expiry_date'=>$expiry_date,
                    'max_usage_limit'=>$max_usage_limit,
                    'free_shipping_enabled'=>$free_shipping_enabled,
                    'status'=>$status,
                    'coupon_apply'=>$coupon_apply,
                    'updated_at' => date("Y-m-d H:i:s"),
                    'user_id'=>$this->user_id
                );


                if($this->basic->insert_data('ecommerce_coupon',$data)) $this->session->set_flashdata('success_message',1);
                else $this->session->set_flashdata('error_message',1);

                redirect('ecommerce/coupon_list','location');
            }
        }
    }

    public function edit_coupon_action()
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET')
            redirect('home/access_forbidden','location');

        if($_POST)
        {
            $id=$this->input->post('hidden_id',true);
            // $this->form_validation->set_rules('store_id', '<b>'.$this->lang->line("Store").'</b>', 'trim|required');
            $this->form_validation->set_rules('coupon_code', '<b>'.$this->lang->line("Coupon code").'</b>', 'trim|required|callback_check_coupon');
            $this->form_validation->set_rules('coupon_amount', '<b>'.$this->lang->line("Coupon amount").'</b>', 'trim|required');
            $this->form_validation->set_rules('expiry_date', '<b>'.$this->lang->line("Expiry date").'</b>', 'trim|required');
            $this->form_validation->set_rules('max_usage_limit', '<b>'.$this->lang->line("Max usage limit").'</b>', 'trim|numeric');
            $this->form_validation->set_rules('coupon_apply', '<b>'.$this->lang->line("Coupon apply").'</b>', 'trim');

            if ($this->form_validation->run() == FALSE)
            {
                $this->edit_coupon($id);
            }
            else
            {
                // $store_id=$this->input->post('store_id',true);
                $product_ids=$this->input->post('product_ids',true);
                $coupon_type=$this->input->post('coupon_type',true);
                $coupon_code=strip_tags($this->input->post('coupon_code',true));
                $coupon_amount=$this->input->post('coupon_amount',true);
                $expiry_date=$this->input->post('expiry_date',true);
                $max_usage_limit=$this->input->post('max_usage_limit',true);
                $free_shipping_enabled=$this->input->post('free_shipping_enabled',true);
                $status=$this->input->post('status',true);
                $coupon_apply=$this->input->post('coupon_apply',true);

                if($status=='') $status='0';
                if($free_shipping_enabled=='') $free_shipping_enabled='0';
                if(!isset($product_ids) || !is_array($product_ids) || empty($product_ids)) $product_ids = '0';
                else $product_ids = implode(',', $product_ids);

                $data=array
                (
                    'product_ids'=>$product_ids,
                    'coupon_type'=>$coupon_type,
                    'coupon_code'=>$coupon_code,
                    'coupon_amount'=>$coupon_amount,
                    'expiry_date'=>$expiry_date,
                    'max_usage_limit'=>$max_usage_limit,
                    'free_shipping_enabled'=>$free_shipping_enabled,
                    'status'=>$status,
                    'coupon_apply'=>$coupon_apply,
                    'updated_at' => date("Y-m-d H:i:s")
                );


                if($this->basic->update_data('ecommerce_coupon',array("id"=>$id,"user_id"=>$this->user_id),$data)) $this->session->set_flashdata('success_message',1);
                else $this->session->set_flashdata('error_message',1);
                redirect('ecommerce/coupon_list','location');

            }
        }
    }

    public function myfatoorah_action($cart_id=0)
    {
        $redirect_url_myfatoorah = base_url('ecommerce/myfatoorah_success/'.$cart_id);

        $cart_data = $this->basic->get_data("ecommerce_cart",array("where"=>array("id"=>$cart_id)));
        if(!isset($cart_data[0])) exit();
        $store_id = isset($cart_data[0]['store_id']) ? $cart_data[0]['store_id'] : 0;
        $subscriber_id  = isset($cart_data[0]['subscriber_id']) ? $cart_data[0]['subscriber_id'] : '';
        $payment_amount  = isset($cart_data[0]['payment_amount']) ? $cart_data[0]['payment_amount'] : '0';

        $bill_email = isset($cart_data[0]['bill_email']) ? $cart_data[0]['bill_email'] : '';
        $buyer_email = isset($cart_data[0]['buyer_email']) ? $cart_data[0]['buyer_email'] : '';
        $bill_mobile = isset($cart_data[0]['bill_mobile']) ? $cart_data[0]['bill_mobile'] : '';
        $buyer_mobile = isset($cart_data[0]['buyer_mobile']) ? $cart_data[0]['buyer_mobile'] : '';
        $bill_first_name = isset($cart_data[0]['bill_first_name']) ? $cart_data[0]['bill_first_name'] : '';
        $buyer_first_name = isset($cart_data[0]['buyer_first_name']) ? $cart_data[0]['buyer_first_name'] : '';
        $bill_last_name = isset($cart_data[0]['bill_last_name']) ? $cart_data[0]['bill_last_name'] : '';
        $buyer_last_name = isset($cart_data[0]['buyer_last_name']) ? $cart_data[0]['buyer_last_name'] : '';
        $customer_email = $bill_email!='' ? $bill_email : $buyer_email;

        $customer_mobile = $bill_mobile!='' ? $bill_mobile : $buyer_mobile;
        $customer_email = $bill_email!='' ? $bill_email : $buyer_email;
        $customer_first_name = $bill_first_name!='' ? $bill_first_name : $buyer_first_name;
        $customer_last_name = $bill_last_name!='' ? $bill_last_name : $buyer_last_name;
        $customer_name = $customer_first_name." ".$customer_last_name;
        $ecommerce_config = $this->get_ecommerce_config($store_id);
        $myfatoorah_api_key = isset($ecommerce_config['myfatoorah_api_key']) ? $ecommerce_config['myfatoorah_api_key'] : '';
        $myfatoorah_mode = isset($ecommerce_config['myfatoorah_mode']) ? $ecommerce_config['myfatoorah_mode'] : '';

        $currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : 'USD';

        if($customer_mobile == '')
        {
            $customer_mobile = "01010100101";
        }
        if($customer_email == '')
        {
            $customer_email = "demo@gmail.com";
        }

        $this->load->library('myfatoorah');
        $this->myfatoorah->purpose =$this->lang->line("Order")." #".$cart_id;
        $this->myfatoorah->amount = $payment_amount;
        $this->myfatoorah->myfatoorah_api_key = $myfatoorah_api_key;
        $this->myfatoorah->myfatoorah_mode = $myfatoorah_mode;
        $this->myfatoorah->callbackurl = $redirect_url_myfatoorah;
        $this->myfatoorah->errorUrl = $redirect_url_myfatoorah;
        $this->myfatoorah->buyer_name = $customer_name;
        $this->myfatoorah->phone = $customer_mobile;
        $this->myfatoorah->myfatoorah_currency = $currency;
        $this->myfatoorah->email = $customer_email;
        $this->myfatoorah->button_lang = $this->lang->line('Pay with Myfatoorah');
        $this->myfatoorah->fail_url = base_url("ecommerce/order/".$cart_id."?subscriber_id=".$subscriber_id."&action=cancel");
        if($myfatoorah_mode=='sandbox')
        {
            $this->myfatoorah->myfatoorah_api_url="https://apitest.myfatoorah.com/v2/SendPayment/";
            $this->myfatoorah->api_main_url_success_url = "https://apitest.myfatoorah.com/v2/getPaymentStatus";
        }
        else{
            $this->myfatoorah->myfatoorah_api_url="https://api.myfatoorah.com/v2/SendPayment";
            $this->myfatoorah->api_main_url_success_url = "https://api.myfatoorah.com/v2/getPaymentStatus";
        }
        $this->myfatoorah->get_long_url();
    }

    public function order_list_data()
    {
        $this->ajax_check();
        $ecommerce_config = $this->get_ecommerce_config();
        $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
        $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
        $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';

        $search_value = $this->input->post("search_value");
        $store_id = $this->input->post("search_store_id");
        $search_status = $this->input->post("search_status");
        $search_date_range = $this->input->post("search_date_range");

        $display_columns =
            array(
                "#",
                "CHECKBOX",
                "subscriber_id",
                'store_name',
                'status',
                'discount',
                'payment_amount',
                'currency',
                'invoice',
                'transaction_id',
                'manual_filename',
                'payment_method',
                'updated_at',
                'paid_at'
            );
        $search_columns = array('subscriber_id','coupon_code','transaction_id');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 11;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'updated_at';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by=$sort." ".$order;

        if($store_id!="") $this->db->where(array("store_id"=>$store_id));
        if($search_status!="") $this->db->where(array("ecommerce_cart.status"=>$search_status));
        $where_custom="ecommerce_cart.user_id = ".$this->user_id." AND ecommerce_cart.action_type = 'checkout'";

        if ($search_value != '')
        {
            foreach ($search_columns as $key => $value)
                $temp[] = $value." LIKE "."'%$search_value%'";
            $imp = implode(" OR ", $temp);
            $where_custom .=" AND (".$imp.") ";
        }
        if($search_date_range!="")
        {
            $exp = explode('|', $search_date_range);
            $from_date = isset($exp[0])?$exp[0]:"";
            $to_date = isset($exp[1])?$exp[1]:"";
            if($from_date!="Invalid date" && $to_date!="Invalid date")
                $where_custom .= " AND ecommerce_cart.updated_at >= '{$from_date}' AND ecommerce_cart.updated_at <='{$to_date}'";
        }
        $this->db->where($where_custom);

        $table="ecommerce_cart";
        $select = "ecommerce_cart.id,ecommerce_cart.user_id,store_id,subscriber_id,coupon_code,coupon_type,discount,payment_amount,currency,ordered_at,transaction_id,card_ending,payment_method,manual_additional_info,manual_filename,paid_at,ecommerce_cart.status,ecommerce_cart.updated_at,ecommerce_cart.action_type,ecommerce_store.store_name,ecommerce_store.store_type,ecommerce_cart.mashkor_delivery,mashkor_id,mashkor_status";
        // $select = "ecommerce_cart.*,ecommerce_store.store_name";
        $join = array('ecommerce_store'=>"ecommerce_store.id=ecommerce_cart.store_id,left");
        $info=$this->basic->get_data($table,$where='',$select,$join,$limit,$start,$order_by,$group_by='');
        // echo $this->db->last_query();exit;

        $last_query = $this->db->last_query();
        $xp1 = explode('WHERE', $last_query);
        $xp2 = isset($xp1[1]) ? explode('ORDER', $xp1[1]) : array();
        $latest_order_list_sql = isset($xp2[0]) ? $xp2[0] : "";
        $this->session->set_userdata("latest_order_list_sql",$latest_order_list_sql);

        if($store_id!="") $this->db->where(array("store_id"=>$store_id));
        if($search_status!="") $this->db->where(array("ecommerce_cart.status"=>$search_status));
        $this->db->where($where_custom);
        $total_rows_array=$this->basic->count_row($table,$where='',$count=$table.".id",$join,$group_by='');

        $total_result=$total_rows_array[0]['total_rows'];


        $mashkor_exist = false;
        if(file_exists(APPPATH.'modules/n_mashkar/include/checkout_js.php')){
            $mashkor_exist = true;
        }

        $printnode_exist = false;
        if(file_exists(APPPATH.'modules/n_printnode/controllers/N_printnode.php')){
            $printnode_exist = true;
        }

        $payment_status = $this->get_payment_status();
        foreach($info as $key => $value)
        {
            $config_currency = isset($value['currency']) ? $value['currency'] : "USD";
            // $info[$key]['currency']= isset($this->currency_icon[$config_currency]) ? $this->currency_icon[$config_currency] : "$";

            $info[$key]['subscriber_id']= "<a target='_BLANK' href='".base_url("subscriber_manager/bot_subscribers/".$info[$key]['subscriber_id'])."'>".$info[$key]['subscriber_id']."</a>";

            if($value['coupon_code']!='')
                $info[$key]['discount']= mec_number_format($info[$key]['discount'],$decimal_point,$thousand_comma);
            else $info[$key]['discount'] = "";

            $info[$key]['payment_amount'] = mec_number_format($info[$key]['payment_amount'],$decimal_point,$thousand_comma);
            $info[$key]['payment_method'] = $info[$key]['payment_method']." ".$info[$key]['card_ending'];
            if(trim($info[$key]['payment_method'])=="") $info[$key]['payment_method'] = "x";

            $info[$key]['transaction_id'] = ($info[$key]['transaction_id']!="") ? "<b class='text-primary'>".$info[$key]['transaction_id']."</b>" : "x";

            $updated_at = date("M j, y H:i",strtotime($info[$key]['updated_at']));
            $info[$key]['updated_at'] =  "<div style='min-width:110px;'>".$updated_at."</div>";

            if($value["paid_at"]!='0000-00-00 00:00:00')
            {
                $paid_at = date("M j, y H:i",strtotime($info[$key]['paid_at']));
                $info[$key]['paid_at'] =  "<div style='min-width:110px;'>".$paid_at."</div>";
            }
            else $info[$key]['paid_at'] = 'x';

            $st1=$st2="";
            $file = base_url('upload/ecommerce/'.$value['manual_filename']);
            $st1 = ($value['payment_method']=='Manual') ? $this->handle_attachment($value['id'], $file):"";

            if($value['payment_method']=='Manual')
                $st2 = ' <a data-id="'.$value['id'].'" href="#"  class="btn btn-outline-primary additional_info" data-toggle="tooltip" title="" data-original-title="'.$this->lang->line("Additional Info").'"><i class="fas fa-info-circle"></i></a>';

            $info[$key]['manual_filename'] = ($st1=="" && $st2=="") ? "x" : "<div style='width:100px;'>".$st1.$st2."</div>";

            $disabled_status = '';
            if($info[$key]['store_type'] == 'digital') $disabled_status = 'disabled';

            $info[$key]['status'] = form_dropdown('payment_status', $payment_status, $value["status"],'class="select2 payment_status" '.$disabled_status.' style="width:120px !important;" data-id="'.$value["id"].'" id="payment_status'.$value['id'].'"').'<script>$("#payment_status'.$value['id'].'").select2();$(\'[data-toggle="tooltip"]\').tooltip();</script>';

            $info[$key]['invoice'] =  "<a class='btn btn-outline-primary' data-toggle='tooltip' title='".$this->lang->line("Invoice")."' target='_BLANK' href='".base_url("ecommerce/order/".$value['id'])."'><i class='fas fa-receipt'></i></a>";

            if($mashkor_exist){
                if($value['mashkor_delivery']>0){
                    $info[$key]['status'] .= '<a href="#" class="open_mashkor" data-order_id="'.$value['id'].'">'.$this->lang->line('Mashkor details').'</a>';
                    if(empty($value['mashkor_id'])){
                        $info[$key]['status'] .= '<br />'.$this->lang->line('pending');
                    }
                }
                if(!empty($value['mashkor_id'])){
//                    switch ($value['mashkor_status']) {
//                        case 0:
//                            $n_mashkor_status = 'New';
//                            break;
//                        case 1:
//                            $n_mashkor_status = 'Confirmed';
//                            break;
//                        case 2:
//                            $n_mashkor_status = 'Assigned';
//                            break;
//                        case 3:
//                            $n_mashkor_status = 'Pickup Started';
//                            break;
//                        case 4:
//                            $n_mashkor_status = 'Picked Up';
//                            break;
//                        case 5:
//                            $n_mashkor_status = 'In Delivery';
//                            break;
//                        case 6:
//                            $n_mashkor_status = 'Arrived Destination';
//                            break;
//                        case 10:
//                            $n_mashkor_status = 'Delivered';
//                            break;
//                        case 11:
//                            $n_mashkor_status = 'Canceled';
//                            break;
//                        default:
//                            $n_mashkor_status = 'Unknown Status';
//                            break;
//                    }

                    $info[$key]['status'] .= '<br />'.$this->lang->line('Processed');


                    $info[$key]['status'] .= '<br />'.$this->lang->line('ID').': '.$value['mashkor_id'];
                }
            }

            if($printnode_exist){
                    $info[$key]['invoice'] .= '<a href="#" class="printnode_modal_print" data-order_id="'.$value['id'].'">'.$this->lang->line('PrintNode print').'</a>';
            }

        }
        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="id");
        echo json_encode($data);
    }
}