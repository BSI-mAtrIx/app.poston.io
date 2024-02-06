<?php
/*
Addon Name: NVX Theme Dashboard helper
Unique Name: n_theme
Project ID: 1019
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.9103
Description: NVX Theme Dashboard helper
*/
require_once("application/controllers/Home.php"); // loading home controller
include("application/libraries/Facebook/autoload.php");
require(APPPATH.'modules/n_theme/vendor/autoload.php');

use GeoIp2\Database\Reader;

class N_theme extends Home
{
    public $key = "70591F6C003CF201";
    private $product_id = 7;
    private $product_base = "n_theme";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 1.9102;
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
        if ($function_name != "webhook_callback")  //todo: cronjob
        {
            // all addon must be login protected
            //------------------------------------------------------------------------------------------
            if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
            // if you want the addon to be accessed by admin and member who has permission to this addon
            //-------------------------------------------------------------------------------------------

            switch ($function_name) {
                case 'settings';
                case 'save_settings';
                case 'activate';
                case 'deactivate';
                case 'delete';
                case 'page_save';
                case 'page_load';
                case 'editor_page';
                case 'faq_edit';
                case 'faq_save';
                case 'install_arabic';
                case 'install_theme_lang';
                case 'custom_domain_admin';
                case 'custom_domain_admin_save';
                case 'custom_domain_admin_delete';
                case 'helper_page';
                case 'reinstall_database';
                case 'helper_page_remove';
                case 'update_maxmind';
                case 'test_maxmind';
                    if ($this->session->userdata('user_type') != 'Admin') {
                        redirect('home/login_page', 'location');
                        exit();
                    }
                    break;

                case 'custom_domain';

                    break;
            }


        }

        $this->load->library('encryption');

        $addon_lang = 'n_theme';
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_lang.php')) {
            $this->lang->load($addon_lang, $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        } else {
            $this->lang->load($addon_lang, 'english', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/english');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($addon_lang . '_custom', $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        }

    }

    public function editor_page($page_lang = '')
    {
        if (empty($page_lang)) {
            redirect('home/login_page', 'location');
        }
        $data = array();
        $data['page_lang'] = $page_lang;
        $this->load->view('n_editor_main.php', $data);
    }

    public function install_arabic()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if (file_exists(APPPATH . 'n_views/language/arabic/n_theme_arabic.php')) {
            if (!file_exists(APPPATH . 'language/arabic/upload_lang.php')) {
                @rename(APPPATH . 'n_views/language/arabic', APPPATH . '/language/arabic/');
                echo 'Arabic translation installed and added to automatic updates.';
            } else {
                if (file_exists(APPPATH . 'language/arabic/upload_lang.php')) {
                    echo 'Arabic translation installed and added to automatic updates.';
                } else {
                    echo 'Please backup your files from application/language/arabic/ and remove arabic folder.';
                }
            }
        } else {
            echo 'Not found arabic translation';
        }
        exit;
    }

    public function install_theme_lang()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        $this->load->helper('directory');
        $map = directory_map(APPPATH . 'language', 1);


        foreach ($map as $k => $v) {
            $v = str_replace('/', '', $v);
            if (file_exists(APPPATH . 'n_views/language/' . $v . '/ntheme_lang.php')) {
                if (!file_exists(APPPATH . 'language/' . $v . '/ntheme_lang.php')) {
                    @rename(APPPATH . 'n_views/language/' . $v . '/ntheme_lang.php', APPPATH . '/language/' . $v . '/ntheme_lang.php');
                    echo $v . ' translation installed and added to automatic updates.' . "<br />";
                } else {
                    if (file_exists(APPPATH . 'language/' . $v . '/ntheme_lang.php')) {
                        echo $v . ' translation installed and added to automatic updates.' . "<br />";
                    } else {
                        echo 'Please backup your files from application/language/' . $v . '/ and remove arabic folder.' . "<br />";
                    }
                }
            } else {
                if (file_exists(APPPATH . 'language/' . $v . '/ntheme_lang.php')) {
                    echo $v . ' translation installed and added to automatic updates.' . "<br />";
                    continue;
                }
                echo 'Not found ' . $v . ' translation. Send request to Mario Devado or create bug report' . "<br />";
                if ($v == 'arabic') {
                    echo 'If you installed Arabic language not need send request. <br/>';
                }
            }
        }

        exit;
    }

    public function page_save($lang_page)
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        //$data = json_decode(file_get_contents("php://input"),true);


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }

        if (file_put_contents(APPPATH . '/n_eco_user/' . $lang_page . '.php', file_get_contents("php://input")) === FALSE) {
            echo json_encode("FAILED");
        } else {
            echo json_encode("SUCCESS");
        }


    }

    public function page_load($lang_page)
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        //$data = json_decode(file_get_contents("php://input"),true);


        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }

        if (file_exists(APPPATH . '/n_eco_user/' . $lang_page . '.php')) {
            echo file_get_contents(APPPATH . '/n_eco_user/' . $lang_page . '.php');
        } else {
            echo '';
        }


    }

    public function ecommerce_builder($shop_id)
    {
        if ($this->session->userdata('logged_in') != 1) exit();


        //$this->session->userdata("ecommerce_selected_store") //171616942658 ///"user_id" => $this->user_id
        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("store_unique_id" => $shop_id, "user_id" => $this->user_id)));
        if (!isset($xdata[0])) {
            $this->error_404();
            return;
        }

        $data = array();
        $data['code_before_body'] = '';
        if (file_exists(APPPATH . '/n_eco_user/before_body_store_id_' . $xdata[0]['id'] . '.php')) {
            $data['code_before_body'] = file_get_contents(APPPATH . '/n_eco_user/before_body_store_id_' . $xdata[0]['id'] . '.php');
        }

        $data['codes_before_head'] = '';
        if (file_exists(APPPATH . '/n_eco_user/before_head_store_id_' . $xdata[0]['id'] . '.php')) {
            $data['codes_before_head'] = file_get_contents(APPPATH . '/n_eco_user/before_head_store_id_' . $xdata[0]['id'] . '.php');
        }

        $data['codes_custom_css'] = '';

        if (file_exists(APPPATH . '/n_eco_user/codes_custom_css_store_id_' . $xdata[0]['id'] . '.php')) {
            $data['codes_custom_css'] = file_get_contents(APPPATH . '/n_eco_user/codes_custom_css_store_id_' . $xdata[0]['id'] . '.php');
        }


        $data['title'] = $this->lang->line('Ecommerce builder');
        $data['page_edit'] = 'contact_page_shopid';
        $data['shop_id_short'] = $xdata[0]['id'];
        $data['shop_id'] = $xdata[0]['store_unique_id'];
        $this->load->view('ecommerce_builder.php', $data);
    }

    public function upload_image_only($file_name)
    {
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }
        $file_name = trim($file_name);

        $upload_dir = FCPATH . 'upload/ecommerce';

        // Makes upload directory
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > 5 * 1024 * 1024) {
                $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
                echo json_encode(array('status' => '0', 'message' => $message));
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
                    echo json_encode(array('status' => '0', 'message' => $message));
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = $file_name . '_' . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (!@move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(array('status' => '0', 'message' => $message));
                    exit;
                }

                // Returns response
                echo '"' . $filename . '"';
            }
        }
    }


    public function save_builder($shop_id)
    {
        if ($this->session->userdata('logged_in') != 1) exit();
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        //$this->session->userdata("ecommerce_selected_store") //171616942658 ///"user_id" => $this->user_id
        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array(
            "store_unique_id" => $shop_id,
            "user_id" => $this->user_id
        )));
        if (!isset($xdata[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("something went wrong, please try once again.")));
            return;
        }


        if ($_POST) {

            $this->csrf_token_check();

            foreach ($_POST['_data'] as $k => $v) {
                $this->form_validation->set_rules($k, '<b>' . $this->lang->line($k) . '</b>', 'trim');
            }

            if ($this->form_validation->run() == false) {
                echo json_encode(array('status' => '0', 'message' => $this->lang->line("something went wrong, please try once again.")));
            } else {

                $arr_n = array();
                foreach ($_POST['_data'] as $k => $v) {
                    $v = str_replace(array('apos', 'quot'), array('&apos;', '&quot;'), $v);
                    $arr_n[$k] = str_replace('%23', '#', addslashes(strip_tags($v)));
                }

                include(APPPATH . 'n_views/default_ecommerce_builder.php');
                if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php')) {
                    include(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php');
                }
                $n_new = "<?php \n";

                foreach ($n_eco_builder_config as $k => $v) {
                    if (isset($arr_n[$k])) {
                        $v = $arr_n[$k];
                    }
                    if ($k == 'whatsapp_send_order_button') {
                        $whatsapp_send_order_button = strip_tags($v);
                    }
                    if ($k == 'whatsapp_phone_number') {
                        $whatsapp_phone_number = strip_tags($v);
                    }
                    if ($k == 'whatsapp_send_order_text') {
                        $whatsapp_send_order_text = $v;
                    }
                    $n_new .= "\$n_eco_builder_config['" . $k . "'] = '$v';\n";
                }

                if (isset($whatsapp_send_order_button)) {
                    $update_data = array(
                        'whatsapp_send_order_button' => $whatsapp_send_order_button,
                        'store_id' => $xdata[0]['id'],
                        'user_id' => $this->user_id
                    );
                    $get_data = $this->basic->get_data("ecommerce_config", array("where" => array("store_id" => $xdata[0]['id'])));
                    if (isset($get_data[0])) {
                        $this->basic->update_data("ecommerce_config", array("store_id" => $xdata[0]['id']), $update_data);
                    } else {
                        $this->basic->insert_data("ecommerce_config", $update_data);
                    }
                }
                if (isset($whatsapp_phone_number)) {
                    $update_data = array(
                        'whatsapp_phone_number' => isset($whatsapp_phone_number) ? $whatsapp_phone_number : "",
                        'store_id' => $xdata[0]['id']
                    );
                    $this->basic->update_data("ecommerce_config", array("store_id" => $xdata[0]['id']), $update_data);
                }
                if (isset($whatsapp_send_order_text)) {
                    $update_data = array(
                        'whatsapp_send_order_text' => isset($whatsapp_send_order_text) ? $whatsapp_send_order_text : "",
                        'store_id' => $xdata[0]['id']
                    );
                    $this->basic->update_data("ecommerce_config", array("store_id" => $xdata[0]['id']), $update_data);
                }

                $myfile = APPPATH . '/n_eco_user/';
                if (!file_exists($myfile)) {
                    mkdir($myfile, 0755, true);
                }
                $myfile = APPPATH . '/n_eco_user/builder/';
                if (!file_exists($myfile)) {
                    mkdir($myfile, 0755, true);
                }

                file_put_contents(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php', $n_new, LOCK_EX);
                echo json_encode(array('status' => '1', 'message' => $this->lang->line("Settings saved")));
            }
        }
    }


    public function index()
    {
        if ($this->session->userdata('logged_in') != 1) exit();

        if ($this->session->userdata('user_type') != 'Admin')
            redirect('home/login_page', 'location');

        exit;

//        $data['title'] = $this->lang->line('Instagram accounts');
//        $data['body'] = 'account_import';
//        $data['page_title'] = $data['title'];
//
//        $this->_viewcontroller($data);
    }

    public function settings()
    {
        $this->_viewcontroller(array("body" => "settings", "page_title" => $this->lang->line("settings")));
    }

    public function change_data_dash(){
        $this->csrf_token_check();

        $startDate = $this->input->post('startDate');
        if(!empty($startDate)){
            $this->session->set_userdata('d_start_date', $startDate);
        }

        $endDate = $this->input->post('endDate');
        if(!empty($endDate)){
            $this->session->set_userdata('d_end_date', $endDate);
        }

        $page_id = $this->input->post('page_id');
        if(!empty($page_id)){
            $this->session->set_userdata('d_page_mix', $page_id);
        }

        echo json_encode(array('status'=>true));
    }

    private function set_data_dash(){
        if(!empty($this->session->userdata('d_page_mix'))){
            $this->d_page_mix = $this->session->userdata('d_page_mix');
        }

        if(!empty($this->session->userdata('d_start_date'))){
            $this->d_start_date = $this->session->userdata('d_start_date');
        }

        if(!($this->session->userdata('d_end_date'))){
            $this->d_end_date = $this->session->userdata('d_end_date');
        }

        if(!empty($this->d_page_mix)){
            $pg = explode('_', $this->d_page_mix);

            $this->d_page_id = $pg[1];
            $this->d_media_type= $pg[0];
        }


    }

    public function demo_dashboard($default_value = '0'){
        $this->member_validity();
        $this->is_broadcaster_exist = $this->broadcaster_exist();


        $this->demo_dashboard = 1;

        $this->month_name_array = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        );


        $start_date = new DateTime("-30 days");
        if(!empty($this->d_start_date)){
            $start_date = new DateTime($this->d_start_date);
        }
        $this->start_date = $start_date;

        $end_date = new DateTime("today");
        if(!empty($this->d_end_date)){
            $end_date = new DateTime($this->d_end_date);
        }
        $this->end_date = $end_date;

            $data['pages_not_exist'] = $default_value;


        $data['period_range'] = $start_date->format("m/d/Y").' - '.$end_date->format("m/d/Y");
        $data['demo_dashboard'] = 1;
        $data['start_date'] = $start_date->format("m/d/Y");
        $data['end_date'] = $end_date->format("m/d/Y");

        $this->set_range_from_periood($start_date, $end_date);

        $data['total_subscribers'] = rand(0,1000);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start_date, $interval, $end_date);
        foreach ($period as $dt) {
            $this->base_range_data[$dt->format($this->format_date)] = array(
                'x' => $dt->format($this->format_date),
                'y' => 0
            );

            $this->base_range_data_clear[$dt->format($this->format_date)] = 0;

            $this->base_range_data_range[$dt->format($this->format_date)] = $dt->format($this->format_date);

        }


        foreach ($this->base_range_data as $k => $v) {
            $data['uns_data_checking'][$k] = rand(-10,0);
        }

        foreach ($this->base_range_data as $k => $v) {
            $data['sub_data_checking'][$k] = rand(0,15);
        }
        $data['other_dashboard'] = 0;
        $data['refferer_source_info']['checkbox_plugin']['subscribers'] = rand(0,20);
        $data['refferer_source_info']['customer_chat_plugin']['subscribers'] = rand(0,20);
        $data['refferer_source_info']['sent_to_messenger']['subscribers'] = rand(0,20);
        $data['refferer_source_info']['me_link']['subscribers'] = rand(0,20);
        $data['refferer_source_info']['direct']['subscribers'] = rand(0,20);
        $data['refferer_source_info']['comment_private_reply']['subscribers'] = rand(0,20);

        $data['refferer_source_info']['checkbox_plugin']['title'] = $this->lang->line("Checkbox Plugin");
        $data['refferer_source_info']['customer_chat_plugin']['title'] = $this->lang->line("Customer Chat Plugin");
        $data['refferer_source_info']['sent_to_messenger']['title'] = $this->lang->line("Sent to Messenger Plugin");
        $data['refferer_source_info']['me_link']['title'] = $this->lang->line("m.me Link");
        $data['refferer_source_info']['direct']['title'] = $this->lang->line("Direct From Facebook");
        $data['refferer_source_info']['direct']['subscribers'] = 0;
        $data['refferer_source_info']['comment_private_reply']['title'] = $this->lang->line("Comment Private Reply");


        foreach ($this->base_range_data as $k => $v) {
            $data['male_subscribers'][$k] = rand(0,20);
            $data['female_subscribers'][$k] = rand(0,20);
            $data['male_female_date_list'][$k] = rand(0,20);
        }

        $data['male_female_date_list'] = $this->base_range_data_range;
        $data['total_list_date_list'] = $this->base_range_data_clear;



        $data['stats_date_list'] = $this->base_range_data_clear;


        foreach ($this->base_range_data as $k => $v) {
            $data['stats_subscriber_gain'][$k] = rand(0,20);
            $data['stats_email_gain'][$k] = rand(0,20);
            $data['stats_phone_gain'][$k] = rand(0,20);
        }



        $data['pending_email_campaigns'] = rand(0,20);
        $data['processing_email_campaigns'] =rand(0,20);
        $data['completed_email_campaigns'] = rand(0,20);
        $data['stopped_email_campaigns'] = rand(0,20);


        $data['email_successfully_sent'] = rand(0,20);
        $data['total_emailCampaign_thread'] = rand(0,20);
        $data['total_email_campaigns'] = rand(0,20);



        $data['pending_sms_campaigns'] = rand(0,20);
        $data['processing_sms_campaigns'] = rand(0,20);
        $data['completed_sms_campaigns'] = rand(0,20);
        $data['stopped_sms_campaigns'] = rand(0,20);


        $data['sms_successfully_sent'] = rand(0,20);
        $data['total_smsCampaign_thread'] = rand(0,20);
        $data['total_sms_campaigns'] = rand(0,20);



        $data['pending_posting_campaigns'] = rand(0,20);
        $data['processing_posting_campaigns'] = rand(0,20);
        $data['completed_posting_campaigns'] = rand(0,20);




        // $data['total_subscribers'] = $total_subscribers;


        $data['body'] = 'new_dashboard';
        $data['page_title'] = $this->lang->line('Dashboard');
        $this->_viewcontroller($data);
    }

    public function new_dashboard($default_value = '0', $user_id_from_get = 0){
        $this->member_validity();
        $this->is_broadcaster_exist = $this->broadcaster_exist();
        $this->default_value=$default_value;
        $this->set_data_dash();

        $this->month_name_array = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        );

        if($this->session->userdata('user_type') != 'Admin'){
            $this->default_value='0';
        }

        $user_id = $this->user_id;
        if ($default_value == '0') {
            $user_id = $this->user_id;
            $data['other_dashboard'] = '0';
            $this->default_value='0';
        } else {
            $user_id = $user_id_from_get;
            if ($default_value == 'system'){
                $data['system_dashboard'] = 'yes';
            }else {
                $user_info = $this->basic->get_data('users', array('where' => array('id' => $user_id)));
                $data['user_name'] = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
                $data['user_email'] = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
                $data['system_dashboard'] = 'no';
            }

            $data['other_dashboard'] = '1';
        }
        $data['demo_dashboard'] = 0;

        $this->dash_user_id = $user_id;

        if ($default_value != 'system'){
            $where['where']['user_id'] = $user_id;
        }

        if ($this->is_demo === '1' && $data['other_dashboard'] === '1' && isset($data['system_dashboard']) && $data['system_dashboard'] === 'no') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }


        $data['page_info'] = $this->basic->get_data(
            "facebook_rx_fb_page_info",
            array(
                "where"=>
                    array(
                        "user_id"=>$user_id,
                        //"facebook_rx_fb_user_info_id"=>$this->session->userdata("facebook_rx_fb_user_info"),
                        "bot_enabled"=>"1")
            ),
            $select='',
            $join='',
            $limit='',
            $start=NULL,
            $order_by='page_name ASC');


        if(!empty($data['page_info'][0]) and empty($this->session->userdata('d_page_mix'))){
            $this->d_page_mix = 'fb_'.$data['page_info'][0]['id'];
            $this->session->set_userdata('d_page_mix', $this->d_page_mix);
        }

        $data['pages_not_exist'] = 0;
        if(empty($data['page_info'][0])){
            $data['pages_not_exist'] = 1;
        }


        if(
            empty($data['page_info'][0])
            AND empty($this->session->userdata('d_page_mix'))
        ){
            $this->demo_dashboard($data['pages_not_exist']);
//            $data['body'] = 'new_dash_empty';
//            $data['page_title'] = $this->lang->line('Dashboard');
//            $this->_viewcontroller($data);
            return;
        }


        $media_type='fb';
        if(!empty($this->d_media_type)){
            $media_type = $this->d_media_type;
            $data['media_type'] = $media_type;
            $this->d_media_type = $media_type;
        }else{
            $data['media_type'] = $media_type;
            $this->d_media_type = $media_type;
        }


        if(!empty($this->d_page_id)){
            $d_page_id = $this->d_page_id;
        }else{
            $data['page_id'] = $data['page_info'][0]['id'];
            $d_page_id = $data['page_id'];
            $this->d_page_id = $d_page_id;
        }

        //get post

        // post MEDIA_ID
        // post PERIOD

        $start_date = new DateTime($this->session->userdata('d_start_date') ?: "-30 days");
        $end_date = new DateTime($this->session->userdata('d_end_date') ?: "today");

        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $data['period_range'] = $start_date->format("m/d/Y").' - '.$end_date->format("m/d/Y");
        $data['start_date'] = $start_date->format("m/d/Y");
        $data['end_date'] = $end_date->format("m/d/Y");

        $this->set_range_from_periood($start_date, $end_date);

        $data['total_subscribers'] = $this->get_subsciber_count_box();

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start_date, $interval, $end_date);

        foreach ($period as $dt) {
            $formattedDate = $dt->format($this->format_date);
            $this->base_range_data[$formattedDate] = ['x' => $formattedDate, 'y' => 0];
            $this->base_range_data_clear[$formattedDate] = 0;
            $this->base_range_data_range[$formattedDate] = $formattedDate;
        }

        $endFormattedDate = $end_date->format($this->format_date);
        if(empty($this->base_range_data[$endFormattedDate])){
            $this->base_range_data[$endFormattedDate] = ['x' => $endFormattedDate, 'y' => 0];
            $this->base_range_data_clear[$endFormattedDate] = 0;
            $this->base_range_data_range[$endFormattedDate] = $endFormattedDate;
        }


        $data['uns_data_checking'] = $this->get_uns_data_checking();
        $data['sub_data_checking'] = $this->get_sub_data_checking();
        $data['refferer_source_info'] = $this->get_refferer_source_info();

        $ret = $this->get_subs_info();

        $data['male_subscribers'] = $ret['male_subscribers'];
        $data['female_subscribers'] = $ret['female_subscribers'];
        $data['male_female_date_list'] = $ret['male_female_date_list'];
        $data['total_list_date_list'] = $ret['total_list_date_list'];

        $ret = $this->get_subs_stats_info();

        $data['stats_subscriber_gain'] = $ret['subscriber_gain'];
        $data['stats_email_gain'] = $ret['email_gain'];
        $data['stats_phone_gain'] = $ret['phone_gain'];
        $data['stats_date_list'] = $ret['date_list'];

        $ret = $this->get_email_cpg_chart();

        $data['pending_email_campaigns'] = $ret['pending_email_campaigns'];
        $data['processing_email_campaigns'] = $ret['processing_email_campaigns'];
        $data['completed_email_campaigns'] = $ret['completed_email_campaigns'];
        $data['stopped_email_campaigns'] = $ret['stopped_email_campaigns'];


        $data['email_successfully_sent'] = $ret['email_successfully_sent'];
        $data['total_emailCampaign_thread'] = $ret['total_emailCampaign_thread'];
        $data['total_email_campaigns'] = $ret['total_email_campaigns'];


        $ret = $this->get_sms_cpg_chart();

        $data['pending_sms_campaigns'] = $ret['pending_sms_campaigns'];
        $data['processing_sms_campaigns'] = $ret['processing_sms_campaigns'];
        $data['completed_sms_campaigns'] = $ret['completed_sms_campaigns'];
        $data['stopped_sms_campaigns'] = $ret['stopped_sms_campaigns'];


        $data['sms_successfully_sent'] = $ret['sms_successfully_sent'];
        $data['total_smsCampaign_thread'] = $ret['total_smsCampaign_thread'];
        $data['total_sms_campaigns'] = $ret['total_sms_campaigns'];

        $ret = $this->get_posting_cpg_chart();

        $data['pending_posting_campaigns'] = $ret['pending'];
        $data['processing_posting_campaigns'] = $ret['processing'];
        $data['completed_posting_campaigns'] = $ret['completed'];




        // $data['total_subscribers'] = $total_subscribers;


        $data['body'] = 'new_dashboard';
        $data['page_title'] = $this->lang->line('Dashboard');
        $this->_viewcontroller($data);
    }

    private function get_email_cpg_chart(){
        $select_from_email_lists = [
            'COUNT(id) as total_email_campaigns',
            'SUM(posting_status="0") as pending_email_campaigns',
            'SUM(posting_status="1") as processing_email_campaigns',
            'SUM(posting_status="2") as completed_email_campaigns',
            'SUM(posting_status="3") as stopped_email_campaigns',
            'SUM(successfully_sent) as email_successfully_sent',
            'SUM(total_thread) as total_emailCampaign_thread',
        ];

        $where_email_lists = [
            'where' => [
                'user_id' => $this->dash_user_id,
                'DATE(created_at) >=' => $this->start_date->format("Y-m-d"),
                'DATE(created_at) <=' => $this->end_date->format("Y-m-d"),
            ]
        ];

        $email_campaigns = $this->basic->get_data("email_sending_campaign", $where_email_lists, $select_from_email_lists);

        if(count($email_campaigns) >= 1) {
            $email_campaigns[0] = array_map(function ($value) {
                return $value ?? 0;
            }, $email_campaigns[0]);

            return [
                'pending_email_campaigns' => $email_campaigns[0]['pending_email_campaigns'],
                'processing_email_campaigns' => $email_campaigns[0]['processing_email_campaigns'],
                'completed_email_campaigns' => $email_campaigns[0]['completed_email_campaigns'],
                'stopped_email_campaigns' => $email_campaigns[0]['stopped_email_campaigns'],
                'email_successfully_sent' => $email_campaigns[0]['email_successfully_sent'],
                'total_emailCampaign_thread' => $email_campaigns[0]['total_emailCampaign_thread'],
                'total_email_campaigns' => $email_campaigns[0]['total_email_campaigns'],
            ];
        }

        return [];
    }

    private function get_sms_cpg_chart(){
        $ret = array(
            'pending_sms_campaigns' => 0,
            'processing_sms_campaigns' => 0,
            'completed_sms_campaigns' => 0,
            'stopped_sms_campaigns' => 0,
            'sms_successfully_sent' => 0,
            'total_smsCampaign_thread' => 0,
            'total_sms_campaigns' => 0,
        );

        $select_from_email_lists = array(
            'COUNT(id) as total_sms_campaigns',
            'SUM(posting_status="0") as pending_sms_campaigns',
            'SUM(posting_status="1") as processing_sms_campaigns',
            'SUM(posting_status="2") as completed_sms_campaigns',
            'SUM(posting_status="3") as stopped_sms_campaigns',
            'SUM(successfully_sent) as sms_successfully_sent',
            'SUM(total_thread) as total_smsCampaign_thread',
        );
        $where_email_lists = array(
            'where'=>array(
                'user_id'=>$this->user_id,
                'DATE(created_at) >=' => $this->start_date->format("Y-m-d"),
                'DATE(created_at) <=' => $this->end_date->format("Y-m-d"),
            )
        );
        $email_campaigns = $this->basic->get_data("sms_sending_campaign",$where_email_lists,$select_from_email_lists);



        if(count($email_campaigns) >= 1) {
            $total_email_campaigns = $email_campaigns[0]['total_sms_campaigns'] ?? 0;
            $pending_email_campaigns = $email_campaigns[0]['pending_sms_campaigns'] ?? 0;
            $processing_email_campaigns = $email_campaigns[0]['processing_sms_campaigns'] ?? 0;
            $completed_email_campaigns = $email_campaigns[0]['completed_sms_campaigns'] ?? 0;
            $email_sent_successfully = $email_campaigns[0]['sms_successfully_sent'] ?? 0;
            $email_campaigns_total_thread = $email_campaigns[0]['total_smsCampaign_thread'] ?? 0;
            $stopped_email_campaigns = $email_campaigns[0]['stopped_sms_campaigns'] ?? 0;

            $ret = array(
                'pending_sms_campaigns' => $pending_email_campaigns,
                'processing_sms_campaigns' => $processing_email_campaigns,
                'completed_sms_campaigns' => $completed_email_campaigns,
                'stopped_sms_campaigns' => $stopped_email_campaigns,

                'sms_successfully_sent' => $email_sent_successfully,
                'total_smsCampaign_thread' => $email_campaigns_total_thread,
                'total_sms_campaigns' => $total_email_campaigns,
            );
        }


        return $ret;
    }

    private function get_posting_cpg_chart(){
        $ret = array(
            'pending' => 0,
            'processing' => 0,
            'completed' => 0,
            'stopped' => 0,
            'successfully_sent' => 0,
            'thread' => 0,
            'total_campaigns' => 0,
        );

        $select_from_email_lists = array(
            'COUNT(id) as total_campaigns',
            'SUM(posting_status=0) as pending',
            'SUM(posting_status=1) as processing',
            'SUM(posting_status=2) as completed',
            //'SUM(successfully_sent) as successfully_sent',
            //'SUM(total_thread) as thread',
        );
        $where_email_lists = array(
            'where'=>array(
                'user_id'=>$this->dash_user_id,
                'DATE(schedule_time) >=' => $this->start_date->format("Y-m-d"),
                'DATE(schedule_time) <=' => $this->end_date->format("Y-m-d"),
            )
        );
        $email_campaigns = $this->basic->get_data("facebook_rx_auto_post",$where_email_lists,$select_from_email_lists);
        $email_campaigns = $this->basic->get_data("facebook_rx_auto_post",$where_email_lists,$select_from_email_lists);



        if(count($email_campaigns) >= 1) {
            $total_campaigns = $email_campaigns[0]['total_campaigns'] ?? 0;

            $pending = $email_campaigns[0]['pending'] ?? 0;
            $processing = $email_campaigns[0]['processing'] ?? 0;
            $completed = $email_campaigns[0]['completed'] ?? 0;

            $successfully_sent = $email_campaigns[0]['successfully_sent'] ?? 0;
           // $thread = $email_campaigns[0]['thread'] ?? 0;


            $ret = array(
                'pending' => $pending,
                'processing' => $processing,
                'completed' => $completed,

                'successfully_sent' => $successfully_sent,
               // 'thread' => $thread,
                'total_campaigns' => $total_campaigns,
            );
        }


        return $ret;
    }

    private function get_subsciber_count_box(){
        $where = array(
            'where' => array(
                'DATE(subscribed_at) >=' => $this->start_date->format("Y-m-d"),
                'DATE(subscribed_at) <=' => $this->end_date->format("Y-m-d"),
                'permission' => '1'
            )
        );
        if ($this->default_value != 'system'){
            $where['where']['user_id'] = $this->dash_user_id;
            $where['where']['page_table_id'] = $this->d_page_id;
            $where['where']['social_media'] = $this->d_media_type;
        }
        $select = array('count(id) as subscribers');
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select);
        $subscribed = isset($subscriber_info[0]['subscribers']) ? $subscriber_info[0]['subscribers'] : 0;
        return $subscribed;
    }

    private function get_subs_stats_info(){
        $total_subscribers = $this->base_range_data_clear;
        $email_subscribers = $this->base_range_data_clear;
        $phone_subscribers = $this->base_range_data_clear;
        $male_female_date_list = $this->base_range_data_range;

        $date_format = 'DATE(subscribed_at)';
        $where = array(
            'where' => array(
                "$date_format >=" => $this->start_date->format("Y-m-d"),
                "$date_format <=" => $this->end_date->format("Y-m-d"),
            )
        );
        if ($this->default_value != 'system'){
            $where['where'] += [
                'user_id' => $this->dash_user_id,
                'page_table_id' => $this->d_page_id,
                'social_media' => $this->d_media_type
            ];
        }

        $select = ['COUNT(id) as subscriber_gain','SUM(email != "") as email_gain','SUM(phone_number != "") as phone_gain','date_format(subscribed_at,"'.$this->period_select_sql.'") as subscribed_at'];

        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', 'date_format(subscribed_at,"'.$this->period_group_sql.'") asc', 'date_format(subscribed_at,"'.$this->period_group_sql.'")');
        foreach ($subscriber_info as $value){
            $total_subscribers[$value['subscribed_at']] = $value['subscriber_gain'];
            $email_subscribers[$value['subscribed_at']] = $value['email_gain'];
            $phone_subscribers[$value['subscribed_at']] = $value['phone_gain'];
        }

        return [
            'subscriber_gain' => $total_subscribers,
            'email_gain' => $email_subscribers,
            'phone_gain' => $phone_subscribers,
            'date_list' => $male_female_date_list
        ];
    }

    private function get_data_checking($permission){
        $where = array(
            'where' => array(
                'subscribed_at >=' => $this->start_date->format("Y-m-d"),
                'subscribed_at <=' => $this->end_date->format("Y-m-d"),
                'permission' => $permission
            )
        );
        if ($this->default_value != 'system'){
            $where['where']['user_id'] = $this->dash_user_id;
            $where['where']['page_table_id'] = $this->d_page_id;
            $where['where']['social_media'] = $this->d_media_type;
        }

        $group_by = 'date_format(subscribed_at,"'.$this->period_group_sql.'")';
        $order_by = 'subscribed_at asc';

        $select = array('count(id) as y, date_format(subscribed_at,"'.$this->period_select_sql.'") AS x');
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', $order_by, $group_by);

        $data_checking = $this->base_range_data;

        foreach ($subscriber_info as $k => $v) {
            if($permission == '0') {
                $v['y'] = -$v['y'];
            }
            $data_checking[$v['x']] = $v;
        }

        return $data_checking;
    }

    public function get_uns_data_checking(){
        return $this->get_data_checking('0');
    }

    public function get_sub_data_checking(){
        return $this->get_data_checking('1');
    }

//    private function get_uns_data_checking(){
//        $where = array(
//            'where' => array(
//                'date_format(subscribed_at,"%Y-%m-%d") >=' => $this->start_date->format("Y-m-d"),
//                'date_format(subscribed_at,"%Y-%m-%d") <=' => $this->end_date->format("Y-m-d"),
//                'permission' => '0'
//            )
//        );
//        if ($this->default_value != 'system'){
//            $where['where']['user_id'] = $this->dash_user_id;
//            $where['where']['page_table_id'] = $this->d_page_id;
//            $where['where']['social_media'] = $this->d_media_type;
//        }
//
//        $group_by = 'date_format(subscribed_at,"'.$this->period_group_sql.'")';
//        $order_by = 'subscribed_at asc';
//
//        $select = array('count(id) as y, date_format(subscribed_at,"'.$this->period_select_sql.'") AS x');
//        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', $order_by, $group_by);
//        $data['uns_data_checking'] = $subscriber_info;
//
//        $uns_data_checking = $this->base_range_data;
//
//        foreach ($data['uns_data_checking'] as $k => $v) {
//            $v['y'] = -$v['y'];
//            $uns_data_checking[$v['x']] = $v;
//        }
//
//        return $uns_data_checking;
//    }

//    private function get_sub_data_checking(){
//        $where = array(
//            'where' => array(
//                'date_format(subscribed_at,"%Y-%m-%d") >=' => $this->start_date->format("Y-m-d"),
//                'date_format(subscribed_at,"%Y-%m-%d") <=' => $this->end_date->format("Y-m-d"),
//                'permission' => '1'
//            )
//        );
//        if ($this->default_value != 'system'){
//            $where['where']['user_id'] = $this->dash_user_id;
//            $where['where']['page_table_id'] = $this->d_page_id;
//            $where['where']['social_media'] = $this->d_media_type;
//        }
//
//        $group_by = 'date_format(subscribed_at,"'.$this->period_group_sql.'")';
//        $order_by = 'subscribed_at asc';
//
//        $select = array('count(id) as y, date_format(subscribed_at,"'.$this->period_select_sql.'") AS x');
//        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', $order_by, $group_by);
//
//
//
//        $data['uns_data_checking'] = $subscriber_info;
//
//        $sub_data_checking = $this->base_range_data;
//
//        foreach ($data['uns_data_checking'] as $k => $v) {
//            $v['y'] = $v['y'];
//            $sub_data_checking[$v['x']] = $v;
//        }
//
//        return $sub_data_checking;
//    }

    private function get_subs_info(){
        $male_list = $female_list = $total_list = $this->base_range_data_clear;
        $male_female_date_list = $this->base_range_data_range;

        $where = [
            'where' => [
                'DATE(subscribed_at) >=' => $this->start_date->format('Y-m-d'),
                'DATE(subscribed_at) <=' => $this->end_date->format('Y-m-d'),
                'is_bot_subscriber' => '1'
            ]
        ];
        if ($this->default_value != 'system'){
            $where['where']['user_id'] = $this->dash_user_id;
            $where['where']['page_table_id'] = $this->d_page_id;
            $where['where']['social_media'] = $this->d_media_type;
        }
        $select = ['count(id) as subscribers', 'gender', 'date_format(subscribed_at,"'.$this->period_select_sql.'") as subscribed_at'];
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', 'date_format(subscribed_at,"'.$this->period_group_sql.'") asc', 'date_format(subscribed_at,"'.$this->period_group_sql.'"),gender');

        foreach ($subscriber_info as $value) {
            if ($value['gender'] == 'male') {
                $male_list[$value['subscribed_at']] = $value['subscribers'];
            } else {
                $female_list[$value['subscribed_at']] = $value['subscribers'];
            }
            $total_list[$value['subscribed_at']] += $value['subscribers'];
            $male_female_date_list[$value['subscribed_at']] = $value['subscribed_at'];
        }

        return [
            'male_subscribers' => $male_list,
            'female_subscribers' => $female_list,
            'male_female_date_list' => $male_female_date_list,
            'total_list_date_list' => $total_list
        ];
    }





    private function get_refferer_source_info(){
        $refferer_source_info = array(
            'checkbox_plugin' => array('title' => $this->lang->line("Checkbox Plugin")),
            'customer_chat_plugin' => array('title' => $this->lang->line("Customer Chat Plugin")),
            'sent_to_messenger' => array('title' => $this->lang->line("Sent to Messenger Plugin")),
            'me_link' => array('title' => $this->lang->line("m.me Link")),
            'direct' => array('title' => $this->lang->line("Direct From Facebook"), 'subscribers' => 0),
            'comment_private_reply' => array('title' => $this->lang->line("Comment Private Reply"))
        );

        $where = array(
            'where' => array(
                'DATE(subscribed_at) >=' => $this->start_date->format("Y-m-d"),
                'DATE(subscribed_at) <=' => $this->end_date->format("Y-m-d"),
                'permission' => '1'
            )
        );

        if ($this->default_value != 'system'){
            $where['where']['user_id'] = $this->dash_user_id;
            $where['where']['page_table_id'] = $this->d_page_id;
            $where['where']['social_media'] = $this->d_media_type;
        }

        $select = array('count(id) as subscribers', 'refferer_source');
        $subscriber_refferer_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', '', 'refferer_source');

        foreach ($subscriber_refferer_info as $value) {
            if ($value['refferer_source'] == 'checkbox_plugin')
                $refferer_source_info['checkbox_plugin']['subscribers'] = $value['subscribers'];
            else if ($value['refferer_source'] == 'CUSTOMER_CHAT_PLUGIN')
                $refferer_source_info['customer_chat_plugin']['subscribers'] = $value['subscribers'];
            else if ($value['refferer_source'] == 'SEND-TO-MESSENGER-PLUGIN')
                $refferer_source_info['sent_to_messenger']['subscribers'] = $value['subscribers'];
            else if ($value['refferer_source'] == 'SHORTLINK')
                $refferer_source_info['me_link']['subscribers'] = $value['subscribers'];
            else if ($value['refferer_source'] == 'FB PAGE' || $value['refferer_source'] == '')
                    $refferer_source_info['direct']['subscribers'] += $value['subscribers'];
            else if ($value['refferer_source'] == 'COMMENT PRIVATE REPLY')
                $refferer_source_info['comment_private_reply']['subscribers'] = $value['subscribers'];
            }

        return $refferer_source_info;
    }


    private function set_range_from_periood($start, $end){
        $difference = $start->diff($end);

        if($difference->days >= (365*2)){
            $this->period_sql = "%Y";
            $this->period_group_sql = "%Y";

            $this->period_select_sql = "%Y";
            $this->format_date = "Y";
        }
        elseif($difference->days >= 32 && $difference->days < (365*2)){
            $this->period_sql = "%Y-%m";
            $this->period_group_sql = "%M%Y";

            $this->period_select_sql = "%m.%Y";
            $this->format_date = "m.Y";
        }
        elseif($difference->days < 32){
            $this->period_sql = "%Y-%m-%d";
            $this->period_group_sql = "%D%M%Y";

            $this->period_select_sql = "%d.%m.%Y";
            $this->format_date = "d.m.Y";
        }
    }

    public function save_settings()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        if ($_POST) {

            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('use_nviews_login_page', '<b>' . $this->lang->line("Use NVX theme login page style?") . '</b>', 'trim');
            $this->form_validation->set_rules('rtl_langs', '<b>' . $this->lang->line("RTL languages, use comma for seperate language") . '</b>', 'trim');
            $this->form_validation->set_rules('current_theme', '<b>' . $this->lang->line("Default color scheme") . '</b>', 'trim');
            $this->form_validation->set_rules('recommend_photoswipe_resolution', '<b>' . $this->lang->line("Photoswipe (full view photo) recommend photo resolution. 0x0 is auto") . '</b>', 'trim');
            $this->form_validation->set_rules('hide_login_via_email', '<b>' . $this->lang->line("Hide login via email on login page") . '</b>', 'trim');
            $this->form_validation->set_rules('show_renew_button', '<b>' . $this->lang->line("Show renew button for trial package and before expire X days") . '</b>', 'trim');
            $this->form_validation->set_rules('show_renew_button_days', '<b>' . $this->lang->line("Before X days show renew button (disabled if renew button hidden)") . '</b>', 'trim');
            $this->form_validation->set_rules('livicon_icon_style', '<b>' . $this->lang->line("Sidebar icon style") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icons', '<b>' . $this->lang->line("Sidebar icon Family") . '</b>', 'trim');

            $this->form_validation->set_rules('dashboard_section_1_on', '<b>' . $this->lang->line("Custom dashboard section (view for all)") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_section_1_only_admin', '<b>' . $this->lang->line("Custom dashboard section (view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_section_1_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('page_help_view', '<b>' . $this->lang->line("Help page editor (BETA)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_help_only_admin', '<b>' . $this->lang->line("Help page (only view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_help_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('page_faq_view', '<b>' . $this->lang->line("FAQ page editor (BETA)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_faq_only_admin', '<b>' . $this->lang->line("FAQ page (only view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_faq_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('greetings_on', '<b>' . $this->lang->line("Show greetings") . '</b>', 'trim');
            $this->form_validation->set_rules('greetings_random', '<b>' . $this->lang->line("Type greetings") . '</b>', 'trim');

            $this->form_validation->set_rules('start_modal_show', '<b>' . $this->lang->line("Welcome modal (view for all)") . '</b>', 'trim');
            $this->form_validation->set_rules('start_modal_only_admin', '<b>' . $this->lang->line("Welcome modal (only view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('start_modal_default', '<b>' . $this->lang->line("Default welcome modal (empty for no display)") . '</b>', 'trim');
            $this->form_validation->set_rules('start_modal_always_show', '<b>' . $this->lang->line("Welcome modal always show on start dashboard") . '</b>', 'trim');
            $this->form_validation->set_rules('login_page_text_show', '<b>' . $this->lang->line("Login page text (replace image)") . '</b>', 'trim');
            $this->form_validation->set_rules('login_page_text_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('disable_example_dashboard', '<b>' . $this->lang->line("Show example dashboard button") . '</b>', 'trim');

            $this->form_validation->set_rules('ecommerce_product_gallery', '<b>' . $this->lang->line("Max photos in product gallery") . '</b>', 'trim');

            $this->form_validation->set_rules('default_lang_flowbuilder', '<b>' . $this->lang->line("Default language flow builder") . '</b>', 'trim');
            $this->form_validation->set_rules('default_flowbuilder', '<b>' . $this->lang->line("Version flow builder") . '</b>', 'trim');
            $this->form_validation->set_rules('show_lang_selector', '<b>' . $this->lang->line("Hide language selector") . '</b>', 'trim');


            $this->form_validation->set_rules('is_external_off', '<b>' . $this->lang->line("Menu manager is_external open in new cart?") . '</b>', 'trim');
            $this->form_validation->set_rules('payment_text_header_sidebar', '<b>' . $this->lang->line("Sidebar menu: Payment header text") . '</b>', 'trim');
            $this->form_validation->set_rules('payment_text_sidebar', '<b>' . $this->lang->line("Sidebar menu: Payment link tex") . '</b>', 'trim');


            $this->form_validation->set_rules('pwa_on', '<b>' . $this->lang->line("PWA On / Off") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_name', '<b>' . $this->lang->line("PWA app name") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_short_name', '<b>' . $this->lang->line("PWA app short name") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_description', '<b>' . $this->lang->line("PWA app description") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_theme_color', '<b>' . $this->lang->line("PWA theme color") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_background_color', '<b>' . $this->lang->line("PWA background color") . '</b>', 'trim');

            $this->form_validation->set_rules('pwa_apple_status_bar', '<b>' . $this->lang->line("apple-mobile-web-app-status-bar-style") . '</b>', 'trim');

            $this->form_validation->set_rules('eco_custom_domain', '<b>' . $this->lang->line("Custom domain") . '</b>', 'trim');
            $this->form_validation->set_rules('custom_domain_host', '<b>' . $this->lang->line("Main URL host (your app)") . '</b>', 'trim');

            $this->form_validation->set_rules('wildcard_domain', '<b>' . $this->lang->line("Wildcard Domain for ecommerce / landing page builder without http") . '</b>', 'trim');


            $this->form_validation->set_rules('theme_appeareance_on', '<b>' . $this->lang->line("theme_appeareance_on") . '</b>', 'trim');
            $this->form_validation->set_rules('theme_sidebar_color', '<b>' . $this->lang->line("theme_sidebar_color") . '</b>', 'trim');
            $this->form_validation->set_rules('dark_icon_color', '<b>' . $this->lang->line("dark_icon_color") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_text_color', '<b>' . $this->lang->line("sidebar_text_color") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_color', '<b>' . $this->lang->line("primary_color") . '</b>', 'trim');
            $this->form_validation->set_rules('btn_primary_color_hover', '<b>' . $this->lang->line("Button primary hover color") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_background', '<b>' . $this->lang->line("dashboard_background") . '</b>', 'trim');

            $this->form_validation->set_rules('light_primary_color', '<b>' . $this->lang->line("light_primary_color") . '</b>', 'trim');

            $this->form_validation->set_rules('danger_color', '<b>' . $this->lang->line("danger_color") . '</b>', 'trim');

            $this->form_validation->set_rules('success_color', '<b>' . $this->lang->line("success_color") . '</b>', 'trim');
            $this->form_validation->set_rules('warning_color', '<b>' . $this->lang->line("warning_color") . '</b>', 'trim');

            $this->form_validation->set_rules('nav_font', '<b>' . $this->lang->line("nav_font") . '</b>', 'trim');

            $this->form_validation->set_rules('body_font', '<b>' . $this->lang->line("body_font") . '</b>', 'trim');

            $this->form_validation->set_rules('nav_font_rtl', '<b>' . $this->lang->line("nav_font_rtl") . '</b>', 'trim');
            $this->form_validation->set_rules('body_font_rtl', '<b>' . $this->lang->line("body_font_rtl") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_color_hover', '<b>' . $this->lang->line("primary_color_hover") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_outline_color', '<b>' . $this->lang->line("primary_outline_color") . '</b>', 'trim');

            $this->form_validation->set_rules('body_font_font_size', '<b>' . $this->lang->line("body_font_font_size") . '</b>', 'trim');
            $this->form_validation->set_rules('card_title_font_size', '<b>' . $this->lang->line("card_title_font_size") . '</b>', 'trim');
            $this->form_validation->set_rules('body_font_font_size_rtl', '<b>' . $this->lang->line("body_font_font_size_rtl") . '</b>', 'trim');
            $this->form_validation->set_rules('card_title_font_size_rtl', '<b>' . $this->lang->line("card_title_font_size_rtl") . '</b>', 'trim');

            $this->form_validation->set_rules('signup_page_view', '<b>' . $this->lang->line("signup_page_view") . '</b>', 'trim');
            $this->form_validation->set_rules('signup_page_default_view', '<b>' . $this->lang->line("signup_page_default_view") . '</b>', 'trim');
            $this->form_validation->set_rules('helper_default_lang', '<b>' . $this->lang->line("helper_default_lang") . '</b>', 'trim');
            $this->form_validation->set_rules('helper_animation', '<b>' . $this->lang->line("helper_animation") . '</b>', 'trim');

            $this->form_validation->set_rules('package_qa_show', '<b>' . $this->lang->line("package_qa_show") . '</b>', 'trim');
            $this->form_validation->set_rules('package_qa_only_admin', '<b>' . $this->lang->line("package_qa_only_admin") . '</b>', 'trim');
            $this->form_validation->set_rules('package_qa_default', '<b>' . $this->lang->line("package_qa_default") . '</b>', 'trim');

            $this->form_validation->set_rules('spain_lang_icon', '<b>' . $this->lang->line("spain_lang_icon") . '</b>', 'trim');

            $this->form_validation->set_rules('welcome_modal_button_text_arabic', '<b>' . $this->lang->line("welcome_modal_button_text_arabic") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_english', '<b>' . $this->lang->line("welcome_modal_button_text_english") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_bengali', '<b>' . $this->lang->line("welcome_modal_button_text_bengali") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_dutch', '<b>' . $this->lang->line("welcome_modal_button_text_dutch") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_english', '<b>' . $this->lang->line("welcome_modal_button_text_english") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_french', '<b>' . $this->lang->line("welcome_modal_button_text_french") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_german', '<b>' . $this->lang->line("welcome_modal_button_text_german") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_greek', '<b>' . $this->lang->line("welcome_modal_button_text_greek") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_italian', '<b>' . $this->lang->line("welcome_modal_button_text_italian") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_polish', '<b>' . $this->lang->line("welcome_modal_button_text_polish") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_portuguese', '<b>' . $this->lang->line("welcome_modal_button_text_portuguese") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_russian', '<b>' . $this->lang->line("welcome_modal_button_text_russian") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_spanish', '<b>' . $this->lang->line("welcome_modal_button_text_spanish") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_turkish', '<b>' . $this->lang->line("welcome_modal_button_text_turkish") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_vietnamese', '<b>' . $this->lang->line("welcome_modal_button_text_vietnamese") . '</b>', 'trim');


            $this->form_validation->set_rules('sidebar_icon_help_bx', '<b>' . $this->lang->line("sidebar_icon_help_bx") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icon_help_livicons', '<b>' . $this->lang->line("sidebar_icon_help_livicons") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icon_faq_bx', '<b>' . $this->lang->line("sidebar_icon_faq_bx") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icon_faq_livicons', '<b>' . $this->lang->line("sidebar_icon_faq_livicons") . '</b>', 'trim');


            $this->form_validation->set_rules('n_paymongo_gateway_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_gateway_gcash_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_gcash_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_gateway_paymaya_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_paymaya_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_gateway_grab_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_grab_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_sec', '<b>' . $this->lang->line("n_paymongo_sec") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_pub', '<b>' . $this->lang->line("n_paymongo_pub") . '</b>', 'trim');

            $this->form_validation->set_rules('theme_mobile_full_width', '<b>' . $this->lang->line("theme_mobile_full_width") . '</b>', 'trim');
            $this->form_validation->set_rules('import_account_fb_alert', '<b>' . $this->lang->line("import_account_fb_alert") . '</b>', 'trim');

            $this->form_validation->set_rules('account_activation_view', '<b>' . $this->lang->line("account_activation_view") . '</b>', 'trim');
            $this->form_validation->set_rules('account_activation_default_view', '<b>' . $this->lang->line("account_activation_default_view") . '</b>', 'trim');
            $this->form_validation->set_rules('forgot_password_view', '<b>' . $this->lang->line("forgot_password_view") . '</b>', 'trim');
            $this->form_validation->set_rules('forgot_password_default_view', '<b>' . $this->lang->line("forgot_password_default_view") . '</b>', 'trim');

            $this->form_validation->set_rules('current_sidebar', '<b>' . $this->lang->line("current_sidebar") . '</b>', 'trim');


            $this->form_validation->set_rules('n_payu_latam_sandbox', '<b>' . $this->lang->line("n_payu_latam_sandbox") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_enabled', '<b>' . $this->lang->line("n_payu_latam_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_merchantid', '<b>' . $this->lang->line("n_payu_latam_merchantid") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_accountid', '<b>' . $this->lang->line("n_payu_latam_accountid") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_api_key', '<b>' . $this->lang->line("n_payu_latam_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_enabled', '<b>' . $this->lang->line("n_coinbase_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_shared_secret', '<b>' . $this->lang->line("n_coinbase_shared_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_api_key', '<b>' . $this->lang->line("n_coinbase_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_section_init', '<b>' . $this->lang->line("dashboard_section_init") . '</b>', 'trim');

            $this->form_validation->set_rules('login_change_language', '<b>' . $this->lang->line("login_change_language") . '</b>', 'trim');

            $this->form_validation->set_rules('n_moamalat_enabled', '<b>' . $this->lang->line("n_moamalat_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_testmode', '<b>' . $this->lang->line("n_moamalat_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_merchant_id', '<b>' . $this->lang->line("n_moamalat_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_terminal_id', '<b>' . $this->lang->line("n_moamalat_terminal_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_secret_key', '<b>' . $this->lang->line("n_moamalat_secret_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_sadad_enabled', '<b>' . $this->lang->line("n_sadad_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sadad_testmode', '<b>' . $this->lang->line("n_sadad_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sadad_secret_key', '<b>' . $this->lang->line("n_sadad_secret_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_tap_secret', '<b>' . $this->lang->line("n_tap_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tap_on', '<b>' . $this->lang->line("n_tap_on") . '</b>', 'trim');

            $this->form_validation->set_rules('sitemap_disable', '<b>' . $this->lang->line("sitemap_disable") . '</b>', 'trim');
            $this->form_validation->set_rules('webhook_disable', '<b>' . $this->lang->line("webhook_disable") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_disable', '<b>' . $this->lang->line("pwa_disable") . '</b>', 'trim');

            $this->form_validation->set_rules('n_tdsp_auth_key', '<b>' . $this->lang->line("n_tdsp_auth_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_store_id', '<b>' . $this->lang->line("n_tdsp_store_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_sandbox', '<b>' . $this->lang->line("n_tdsp_sandbox") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_enabled', '<b>' . $this->lang->line("n_tdsp_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_stripe_product_image', '<b>' . $this->lang->line("n_stripe_product_image") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_secret_key', '<b>' . $this->lang->line("n_stripe_secret_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_enabled', '<b>' . $this->lang->line("n_stripe_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_subscription_enabled', '<b>' . $this->lang->line("n_stripe_subscription_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('onesignal_enabled', '<b>' . $this->lang->line("onesignal_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('onesignal_app_key', '<b>' . $this->lang->line("onesignal_app_key") . '</b>', 'trim');
            $this->form_validation->set_rules('saved_template_hide_save_btn', '<b>' . $this->lang->line("saved_template_hide_save_btn") . '</b>', 'trim');

            $this->form_validation->set_rules('n_mastercard_merchant_id', '<b>' . $this->lang->line("n_mastercard_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_api_pass', '<b>' . $this->lang->line("n_mastercard_api_pass") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_enabled', '<b>' . $this->lang->line("n_mastercard_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_testmode', '<b>' . $this->lang->line("n_mastercard_testmode") . '</b>', 'trim');

            $this->form_validation->set_rules('n_epayco_pkey', '<b>' . $this->lang->line("n_epayco_pkey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_api_private_key', '<b>' . $this->lang->line("n_epayco_api_private_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_enabled', '<b>' . $this->lang->line("n_epayco_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_testmode', '<b>' . $this->lang->line("n_epayco_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_checkout', '<b>' . $this->lang->line("n_epayco_checkout") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_subs_enabled', '<b>' . $this->lang->line("n_epayco_subs_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_sellix_api_key', '<b>' . $this->lang->line("n_sellix_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_webhook_secret', '<b>' . $this->lang->line("n_sellix_webhook_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_merchant', '<b>' . $this->lang->line("n_sellix_merchant") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_enabled', '<b>' . $this->lang->line("n_sellix_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_subs_enabled', '<b>' . $this->lang->line("n_sellix_subs_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_credits_on', '<b>' . $this->lang->line("n_credits_on") . '</b>', 'trim');

            $this->form_validation->set_rules('n_chapa_secret_key', '<b>' . $this->lang->line("n_chapa_secret_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_chapa_enabled', '<b>' . $this->lang->line("n_chapa_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_zaincash_enabled', '<b>' . $this->lang->line("n_zaincash_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_testmode_enabled', '<b>' . $this->lang->line("n_zaincash_testmode_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_merchant_secret', '<b>' . $this->lang->line("n_zaincash_merchant_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_MSISDN', '<b>' . $this->lang->line("n_zaincash_MSISDN") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_merchant_id', '<b>' . $this->lang->line("n_zaincash_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_convert_price', '<b>' . $this->lang->line("n_zaincash_convert_price") . '</b>', 'trim');

            $this->form_validation->set_rules('dp_on', '<b>' . $this->lang->line("dp_on") . '</b>', 'trim');
            $this->form_validation->set_rules('dp_fixed_show', '<b>' . $this->lang->line("dp_fixed_show") . '</b>', 'trim');
            $this->form_validation->set_rules('dp_country_on', '<b>' . $this->lang->line("dp_country_on") . '</b>', 'trim');
            $this->form_validation->set_rules('dp_coupons_show', '<b>' . $this->lang->line("dp_coupons_show") . '</b>', 'trim');
            $this->form_validation->set_rules('dp_country_maxmind_db_key', '<b>' . $this->lang->line("dp_country_maxmind_db_key") . '</b>', 'trim');

            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->settings();
            } else {
                // assign
                $use_nviews_login_page = addslashes(strip_tags($this->input->post('use_nviews_login_page', true)));
                $rtl_langs = addslashes(strip_tags($this->input->post('rtl_langs', true)));
                $current_theme = addslashes(strip_tags($this->input->post('current_theme', true)));
                $recommend_photoswipe_resolution = addslashes(strip_tags($this->input->post('recommend_photoswipe_resolution', true)));
                $hide_login_via_email = addslashes(strip_tags($this->input->post('hide_login_via_email', true)));
                $show_renew_button = addslashes(strip_tags($this->input->post('show_renew_button', true)));
                $show_renew_button_days = addslashes(strip_tags($this->input->post('show_renew_button_days', true)));
                $livicon_icon_style = addslashes(strip_tags($this->input->post('livicon_icon_style', true)));
                $sidebar_icons = addslashes(strip_tags($this->input->post('sidebar_icons', true)));
                $arabic_lang_icon = addslashes(strip_tags($this->input->post('arabic_lang_icon', true)));
                $hebrew_lang_icon = addslashes(strip_tags($this->input->post('hebrew_lang_icon', true)));
                $dashboard_section_1_on = addslashes(strip_tags($this->input->post('dashboard_section_1_on', true)));
                $dashboard_section_1_only_admin = addslashes(strip_tags($this->input->post('dashboard_section_1_only_admin', true)));
                $dashboard_section_1_default = addslashes(strip_tags($this->input->post('dashboard_section_1_default', true)));
                $page_help_view = addslashes(strip_tags($this->input->post('page_help_view', true)));
                $page_help_only_admin = addslashes(strip_tags($this->input->post('page_help_only_admin', true)));
                $page_help_default = addslashes(strip_tags($this->input->post('page_help_default', true)));

                $page_faq_view = addslashes(strip_tags($this->input->post('page_faq_view', true)));
                $page_faq_only_admin = addslashes(strip_tags($this->input->post('page_faq_only_admin', true)));
                $page_faq_default = addslashes(strip_tags($this->input->post('page_faq_default', true)));

                $greetings_on = addslashes(strip_tags($this->input->post('greetings_on', true)));
                $greetings_random = addslashes(strip_tags($this->input->post('greetings_random', true)));

                $start_modal_show = addslashes(strip_tags($this->input->post('start_modal_show', true)));
                $start_modal_only_admin = addslashes(strip_tags($this->input->post('start_modal_only_admin', true)));
                $start_modal_default = addslashes(strip_tags($this->input->post('start_modal_default', true)));
                $start_modal_always_show = addslashes(strip_tags($this->input->post('start_modal_always_show', true)));

                $login_page_text_show = addslashes(strip_tags($this->input->post('login_page_text_show', true)));
                $login_page_text_default = addslashes(strip_tags($this->input->post('login_page_text_default', true)));
                $disable_example_dashboard = addslashes(strip_tags($this->input->post('disable_example_dashboard', true)));
                $ecommerce_product_gallery = addslashes(strip_tags($this->input->post('ecommerce_product_gallery', true)));

                $default_lang_flowbuilder = addslashes(strip_tags($this->input->post('default_lang_flowbuilder', true)));
                $default_flowbuilder = addslashes(strip_tags($this->input->post('default_flowbuilder', true)));
                $show_lang_selector = addslashes(strip_tags($this->input->post('show_lang_selector', true)));

                $is_external_off = addslashes(strip_tags($this->input->post('is_external_off', true)));
                $payment_text_header_sidebar = addslashes(strip_tags($this->input->post('payment_text_header_sidebar', true)));
                $payment_text_sidebar = addslashes(strip_tags($this->input->post('payment_text_sidebar', true)));

                $pwa_on = addslashes(strip_tags($this->input->post('pwa_on', true)));
                $pwa_name = addslashes(strip_tags($this->input->post('pwa_name', true)));
                $pwa_short_name = addslashes(strip_tags($this->input->post('pwa_short_name', true)));
                $pwa_description = addslashes(strip_tags($this->input->post('pwa_description', true)));

                $pwa_theme_color = addslashes(strip_tags($this->input->post('pwa_theme_color', true)));
                $pwa_background_color = addslashes(strip_tags($this->input->post('pwa_background_color', true)));

                $pwa_apple_status_bar = addslashes(strip_tags($this->input->post('pwa_apple_status_bar', true)));

                $base_path = realpath(APPPATH . '../assets/img');

                $eco_custom_domain = addslashes(strip_tags($this->input->post('eco_custom_domain', true)));
                $custom_domain_host = addslashes(strip_tags($this->input->post('custom_domain_host', true)));

                $wildcard_domain = addslashes(strip_tags($this->input->post('wildcard_domain', true)));

                $theme_appeareance_on = addslashes(strip_tags($this->input->post('theme_appeareance_on', true)));
                $theme_sidebar_color = addslashes(strip_tags($this->input->post('theme_sidebar_color', true)));
                $dark_icon_color = addslashes(strip_tags($this->input->post('dark_icon_color', true)));
                $sidebar_text_color = addslashes(strip_tags($this->input->post('sidebar_text_color', true)));

                $primary_color = addslashes(strip_tags($this->input->post('primary_color', true)));
                $btn_primary_color_hover = addslashes(strip_tags($this->input->post('btn_primary_color_hover', true)));
                $dashboard_background = addslashes(strip_tags($this->input->post('dashboard_background', true)));
                $light_primary_color = addslashes(strip_tags($this->input->post('light_primary_color', true)));
                $danger_color = addslashes(strip_tags($this->input->post('danger_color', true)));
                $success_color = addslashes(strip_tags($this->input->post('success_color', true)));

                $warning_color = addslashes(strip_tags($this->input->post('warning_color', true)));
                $nav_font = addslashes(strip_tags($this->input->post('nav_font', true)));
                $body_font = addslashes(strip_tags($this->input->post('body_font', true)));
                $nav_font_rtl = addslashes(strip_tags($this->input->post('nav_font_rtl', true)));
                $body_font_rtl = addslashes(strip_tags($this->input->post('body_font_rtl', true)));

                $primary_color_hover = addslashes(strip_tags($this->input->post('primary_color_hover', true)));

                $primary_outline_color = addslashes(strip_tags($this->input->post('primary_outline_color', true)));

                $body_font_font_size = addslashes(strip_tags($this->input->post('body_font_font_size', true)));
                $card_title_font_size = addslashes(strip_tags($this->input->post('card_title_font_size', true)));

                $body_font_font_size_rtl = addslashes(strip_tags($this->input->post('body_font_font_size_rtl', true)));
                $card_title_font_size_rtl = addslashes(strip_tags($this->input->post('card_title_font_size_rtl', true)));

                $signup_page_view = addslashes(strip_tags($this->input->post('signup_page_view', true)));
                $signup_page_default_view = addslashes(strip_tags($this->input->post('signup_page_default_view', true)));

                $helper_default_lang = addslashes(strip_tags($this->input->post('helper_default_lang', true)));
                $helper_animation = addslashes(strip_tags($this->input->post('helper_animation', true)));

                $package_qa_show = addslashes(strip_tags($this->input->post('package_qa_show', true)));

                $package_qa_only_admin = addslashes(strip_tags($this->input->post('package_qa_only_admin', true)));
                $package_qa_default = addslashes(strip_tags($this->input->post('package_qa_default', true)));

                $spain_lang_icon = addslashes(strip_tags($this->input->post('spain_lang_icon', true)));

                $welcome_modal_button_text_arabic = addslashes(strip_tags($this->input->post('welcome_modal_button_text_arabic', true)));
                $welcome_modal_button_text_english = addslashes(strip_tags($this->input->post('welcome_modal_button_text_english', true)));
                $welcome_modal_button_text_bengali = addslashes(strip_tags($this->input->post('welcome_modal_button_text_bengali', true)));
                $welcome_modal_button_text_dutch = addslashes(strip_tags($this->input->post('welcome_modal_button_text_dutch', true)));
                $welcome_modal_button_text_english = addslashes(strip_tags($this->input->post('welcome_modal_button_text_english', true)));
                $welcome_modal_button_text_french = addslashes(strip_tags($this->input->post('welcome_modal_button_text_french', true)));
                $welcome_modal_button_text_german = addslashes(strip_tags($this->input->post('welcome_modal_button_text_german', true)));
                $welcome_modal_button_text_greek = addslashes(strip_tags($this->input->post('welcome_modal_button_text_greek', true)));
                $welcome_modal_button_text_italian = addslashes(strip_tags($this->input->post('welcome_modal_button_text_italian', true)));
                $welcome_modal_button_text_polish = addslashes(strip_tags($this->input->post('welcome_modal_button_text_polish', true)));
                $welcome_modal_button_text_portuguese = addslashes(strip_tags($this->input->post('welcome_modal_button_text_portuguese', true)));
                $welcome_modal_button_text_russian = addslashes(strip_tags($this->input->post('welcome_modal_button_text_russian', true)));
                $welcome_modal_button_text_spanish = addslashes(strip_tags($this->input->post('welcome_modal_button_text_spanish', true)));
                $welcome_modal_button_text_turkish = addslashes(strip_tags($this->input->post('welcome_modal_button_text_turkish', true)));
                $welcome_modal_button_text_vietnamese = addslashes(strip_tags($this->input->post('welcome_modal_button_text_vietnamese', true)));

                $sidebar_icon_help_bx = addslashes(strip_tags($this->input->post('sidebar_icon_help_bx', true)));
                $sidebar_icon_help_livicons = addslashes(strip_tags($this->input->post('sidebar_icon_help_livicons', true)));
                $sidebar_icon_faq_bx = addslashes(strip_tags($this->input->post('sidebar_icon_faq_bx', true)));
                $sidebar_icon_faq_livicons = addslashes(strip_tags($this->input->post('sidebar_icon_faq_livicons', true)));

                $n_paymongo_gateway_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_enabled', true)));
                $n_paymongo_gateway_gcash_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_gcash_enabled', true)));
                $n_paymongo_gateway_paymaya_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_paymaya_enabled', true)));
                $n_paymongo_gateway_grab_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_grab_enabled', true)));
                $n_paymongo_sec = addslashes(strip_tags($this->input->post('n_paymongo_sec', true)));
                $n_paymongo_pub = addslashes(strip_tags($this->input->post('n_paymongo_pub', true)));

                $theme_mobile_full_width = addslashes(strip_tags($this->input->post('theme_mobile_full_width', true)));
                $import_account_fb_alert = addslashes(strip_tags($this->input->post('import_account_fb_alert', true)));

                $account_activation_view = addslashes(strip_tags($this->input->post('account_activation_view', true)));
                $account_activation_default_view = addslashes(strip_tags($this->input->post('account_activation_default_view', true)));
                $forgot_password_view = addslashes(strip_tags($this->input->post('forgot_password_view', true)));
                $forgot_password_default_view = addslashes(strip_tags($this->input->post('forgot_password_default_view', true)));

                $current_sidebar = addslashes(strip_tags($this->input->post('current_sidebar', true)));

                $n_payu_latam_sandbox = addslashes(strip_tags($this->input->post('n_payu_latam_sandbox', true)));
                $n_payu_latam_enabled = addslashes(strip_tags($this->input->post('n_payu_latam_enabled', true)));
                $n_payu_latam_merchantid = addslashes(strip_tags($this->input->post('n_payu_latam_merchantid', true)));
                $n_payu_latam_accountid = addslashes(strip_tags($this->input->post('n_payu_latam_accountid', true)));
                $n_payu_latam_api_key = addslashes(strip_tags($this->input->post('n_payu_latam_api_key', true)));
                $n_coinbase_enabled = addslashes(strip_tags($this->input->post('n_coinbase_enabled', true)));
                $n_coinbase_shared_secret = addslashes(strip_tags($this->input->post('n_coinbase_shared_secret', true)));
                $n_coinbase_api_key = addslashes(strip_tags($this->input->post('n_coinbase_api_key', true)));
                $dashboard_section_init = addslashes(strip_tags($this->input->post('dashboard_section_init', true)));

                $login_change_language = addslashes(strip_tags($this->input->post('login_change_language', true)));

                $n_moamalat_enabled = addslashes(strip_tags($this->input->post('n_moamalat_enabled', true)));
                $n_moamalat_testmode = addslashes(strip_tags($this->input->post('n_moamalat_testmode', true)));
                $n_moamalat_merchant_id = addslashes(strip_tags($this->input->post('n_moamalat_merchant_id', true)));
                $n_moamalat_terminal_id = addslashes(strip_tags($this->input->post('n_moamalat_terminal_id', true)));
                $n_moamalat_secret_key = addslashes(strip_tags($this->input->post('n_moamalat_secret_key', true)));

                $n_sadad_enabled = addslashes(strip_tags($this->input->post('n_sadad_enabled', true)));
                $n_sadad_testmode = addslashes(strip_tags($this->input->post('n_sadad_testmode', true)));
                $n_sadad_secret_key = addslashes(strip_tags($this->input->post('n_sadad_secret_key', true)));

                $n_tap_secret = addslashes(strip_tags($this->input->post('n_tap_secret', true)));
                $n_tap_on = addslashes(strip_tags($this->input->post('n_tap_on', true)));

                $mashkor_api_key = addslashes(strip_tags($this->input->post('mashkor_api_key', true)));
                $mashkor_auth_key = addslashes(strip_tags($this->input->post('mashkor_auth_key', true)));

                $sitemap_disable = addslashes(strip_tags($this->input->post('sitemap_disable', true)));
                $webhook_disable = addslashes(strip_tags($this->input->post('webhook_disable', true)));
                $pwa_disable = addslashes(strip_tags($this->input->post('pwa_disable', true)));

                $n_tdsp_auth_key = addslashes(strip_tags($this->input->post('n_tdsp_auth_key', true)));
                $n_tdsp_store_id = addslashes(strip_tags($this->input->post('n_tdsp_store_id', true)));
                $n_tdsp_sandbox = addslashes(strip_tags($this->input->post('n_tdsp_sandbox', true)));
                $n_tdsp_enabled = addslashes(strip_tags($this->input->post('n_tdsp_enabled', true)));

                $n_stripe_product_image = addslashes(strip_tags($this->input->post('n_stripe_product_image', true)));
                $n_stripe_secret_key = addslashes(strip_tags($this->input->post('n_stripe_secret_key', true)));
                $n_stripe_enabled = addslashes(strip_tags($this->input->post('n_stripe_enabled', true)));
                $n_stripe_subscription_enabled = addslashes(strip_tags($this->input->post('n_stripe_subscription_enabled', true)));

                $onesignal_enabled = addslashes(strip_tags($this->input->post('onesignal_enabled', true)));
                $onesignal_app_key = addslashes(strip_tags($this->input->post('onesignal_app_key', true)));
                $saved_template_hide_save_btn = addslashes(strip_tags($this->input->post('saved_template_hide_save_btn', true)));

                $n_mastercard_merchant_id = addslashes(strip_tags($this->input->post('n_mastercard_merchant_id', true)));
                $n_mastercard_api_pass = addslashes(strip_tags($this->input->post('n_mastercard_api_pass', true)));
                $n_mastercard_enabled = addslashes(strip_tags($this->input->post('n_mastercard_enabled', true)));
                $n_mastercard_testmode = addslashes(strip_tags($this->input->post('n_mastercard_testmode', true)));

                $n_epayco_pkey = addslashes(strip_tags($this->input->post('n_epayco_pkey', true)));
                $n_epayco_enabled = addslashes(strip_tags($this->input->post('n_epayco_enabled', true)));
                $n_epayco_testmode = addslashes(strip_tags($this->input->post('n_epayco_testmode', true)));
                $n_epayco_checkout = addslashes(strip_tags($this->input->post('n_epayco_checkout', true)));
                $n_epayco_api_private_key = addslashes(strip_tags($this->input->post('n_epayco_api_private_key', true)));
                $n_epayco_subs_enabled = addslashes(strip_tags($this->input->post('n_epayco_subs_enabled', true)));

                $n_sellix_api_key = addslashes(strip_tags($this->input->post('n_sellix_api_key', true)));
                $n_sellix_webhook_secret = addslashes(strip_tags($this->input->post('n_sellix_webhook_secret', true)));
                $n_sellix_merchant = addslashes(strip_tags($this->input->post('n_sellix_merchant', true)));
                $n_sellix_enabled = addslashes(strip_tags($this->input->post('n_sellix_enabled', true)));
                $n_sellix_subs_enabled = addslashes(strip_tags($this->input->post('n_sellix_subs_enabled', true)));

                $n_credits_on = addslashes(strip_tags($this->input->post('n_credits_on', true)));

                $n_chapa_secret_key = addslashes(strip_tags($this->input->post('n_chapa_secret_key', true)));
                $n_chapa_enabled = addslashes(strip_tags($this->input->post('n_chapa_enabled', true)));

                $n_zaincash_enabled = addslashes(strip_tags($this->input->post('n_zaincash_enabled', true)));
                $n_zaincash_testmode_enabled = addslashes(strip_tags($this->input->post('n_zaincash_testmode_enabled', true)));
                $n_zaincash_merchant_secret = addslashes(strip_tags($this->input->post('n_zaincash_merchant_secret', true)));
                $n_zaincash_MSISDN = addslashes(strip_tags($this->input->post('n_zaincash_MSISDN', true)));
                $n_zaincash_merchant_id = addslashes(strip_tags($this->input->post('n_zaincash_merchant_id', true)));
                $n_zaincash_convert_price = addslashes(strip_tags($this->input->post('n_zaincash_convert_price', true)));

                $dp_on = addslashes(strip_tags($this->input->post('dp_on', true)));
                $dp_fixed_show = addslashes(strip_tags($this->input->post('dp_fixed_show', true)));
                $dp_country_on = addslashes(strip_tags($this->input->post('dp_country_on', true)));
                $dp_coupons_show = addslashes(strip_tags($this->input->post('dp_coupons_show', true)));
                $dp_country_maxmind_db_key = addslashes(strip_tags($this->input->post('dp_country_maxmind_db_key', true)));

            }

            $this->load->library('upload');
            include(FCPATH . 'application/n_views/config.php');

            if ($n_moamalat_secret_key != '*****') {
                $n_moamalat_secret_key = openssl_encrypt($n_moamalat_secret_key, "AES-128-ECB", $n_config['cipher']);
            }


            $ios_splash = array('ipad_splash', 'ipadpro1_splash', 'ipadpro2_splash', 'ipadpro3_splash', 'iphone5_splash', 'iphone6_splash', 'iphoneplus_splash', 'iphonex_splash', 'iphonexr_splash', 'iphonexsmax_splash', '8_3__iPad_Mini_portrait', '10_2__iPad_portrait', '10_9__iPad_Air_portrait', 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait', 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait', 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait', '8.3__iPad_Mini_landscape', '9_7__iPad_Pro__7_9__iPad_mini__9_7__iPad_Air__9_7__iPad_landscape', '10_2__iPad_landscape', '10_5__iPad_Air_landscape', '10_9__iPad_Air_landscape', '11__iPad_Pro__10_5__iPad_Pro_landscape', '12_9__iPad_Pro_landscape', '4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape', 'iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4_7__iPhone_SE_landscape', 'iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape', 'iPhone_11__iPhone_XR_landscape', 'iPhone_11_Pro_Max__iPhone_XS_Max_landscape', 'iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape', 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape', 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape', 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape', 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape');
            $splash = array();
            foreach ($ios_splash as $k) {
                $splash[$k] = '';
                if (!empty($n_config[$k])) {
                    $splash[$k] = $n_config[$k];
                }
                if ($_FILES[$k]['size'] != 0) {
                    $photo = $k . ".png";
                    $config = array(
                        "allowed_types" => "png",
                        "upload_path" => $base_path,
                        "overwrite" => true,
                        "file_name" => $photo,
                        'max_size' => 5 * 1024 * 1024,
                        'max_width' => '3000',
                        'max_height' => '3000'
                    );
                    $this->upload->initialize($config);
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload($k)) {
                        $this->session->set_userdata($k, $this->upload->display_errors());
                        return $this->settings();
                    }
                    $splash[$k] = '/assets/img/' . $k . '.png';
                }
            }

            $pwa_icon_512 = '';
            if (!empty($n_config['pwa_icon_512'])) {
                $pwa_icon_512 = $n_config['pwa_icon_512'];
            }
            if ($_FILES['pwa_icon_512']['size'] != 0) {
                $photo = "pwa_icon_512.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '512',
                    'max_height' => '512'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('pwa_icon_512')) {
                    $this->session->set_userdata('pwa_icon_512', $this->upload->display_errors());
                    return $this->settings();
                }
                $pwa_icon_512 = '/assets/img/pwa_icon_512.png';
            }

            $dark_logo_path = '';
            if (!empty($n_config['dark_logo'])) {
                $dark_logo_path = $n_config['dark_logo'];
            }
            if ($_FILES['dark_logo']['size'] != 0) {
                $photo = "dark_logo.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_logo')) {
                    $this->session->set_userdata('dark_logo_error', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_logo_path = '/assets/img/dark_logo.png';
            }

            $light_icon_path = '';
            if (!empty($n_config['light_icon'])) {
                $light_icon_path = $n_config['light_icon'];
            }
            if ($_FILES['light_icon']['size'] != 0) {
                $photo = "light_icon.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('light_icon')) {
                    $this->session->set_userdata('light_icon', $this->upload->display_errors());
                    return $this->settings();
                }
                $light_icon_path = '/assets/img/light_icon.png';
            }

            $dark_icon_path = '';
            if (!empty($n_config['dark_icon'])) {
                $dark_icon_path = $n_config['dark_icon'];
            }
            if ($_FILES['dark_icon']['size'] != 0) {
                $photo = "dark_icon.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_icon')) {
                    $this->session->set_userdata('dark_icon', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_icon_path = '/assets/img/dark_icon.png';
            }

            $light_icon_rtl = '';
            if (!empty($n_config['light_icon_rtl'])) {
                $light_icon_rtl = $n_config['light_icon_rtl'];
            }
            if ($_FILES['light_icon_rtl']['size'] != 0) {
                $photo = "light_icon_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('light_icon_rtl')) {
                    $this->session->set_userdata('light_icon_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $light_icon_rtl = '/assets/img/light_icon_rtl.png';
            }

            $dark_icon_rtl = '';
            if (!empty($n_config['dark_icon_rtl'])) {
                $dark_icon_rtl = $n_config['dark_icon_rtl'];
            }
            if ($_FILES['dark_icon_rtl']['size'] != 0) {
                $photo = "dark_icon_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_icon_rtl')) {
                    $this->session->set_userdata('dark_icon_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_icon_rtl = '/assets/img/dark_icon_rtl.png';
            }

            $dark_logo_rtl = '';
            if (!empty($n_config['dark_logo_rtl'])) {
                $dark_logo_rtl = $n_config['dark_logo_rtl'];
            }
            if ($_FILES['dark_logo_rtl']['size'] != 0) {
                $photo = "dark_logo_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_logo_rtl')) {
                    $this->session->set_userdata('dark_logo_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_logo_rtl = '/assets/img/dark_logo_rtl.png';
            }

            $light_logo_rtl = '';
            if (!empty($n_config['light_logo_rtl'])) {
                $light_logo_rtl = $n_config['light_logo_rtl'];
            }
            if ($_FILES['light_logo_rtl']['size'] != 0) {
                $photo = "light_logo_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('light_logo_rtl')) {
                    $this->session->set_userdata('light_logo_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $light_logo_rtl = '/assets/img/light_logo_rtl.png';
            }


            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_config['dev_mode'] = false;\n";
            $app_my_config_data .= "\$n_config['extra_function'] = false;\n";

            $app_my_config_data .= "\$n_config['dark_logo'] = '$dark_logo_path';\n";
            $app_my_config_data .= "\$n_config['light_icon'] = '$light_icon_path';\n";
            $app_my_config_data .= "\$n_config['dark_icon'] = '$dark_icon_path';\n";

            $app_my_config_data .= "\$n_config['use_nviews_login_page'] = '$use_nviews_login_page';\n";
            $app_my_config_data .= "\$n_config['rtl_langs'] = '$rtl_langs';\n";
            $app_my_config_data .= "\$n_config['current_theme'] = '$current_theme';\n";
            $app_my_config_data .= "\$n_config['recommend_photoswipe_resolution'] = '$recommend_photoswipe_resolution';\n";
            $app_my_config_data .= "\$n_config['hide_login_via_email'] = '$hide_login_via_email';\n";
            $app_my_config_data .= "\$n_config['show_renew_button'] = '$show_renew_button';\n";
            $app_my_config_data .= "\$n_config['show_renew_button_days'] = '$show_renew_button_days';\n";
            $app_my_config_data .= "\$n_config['livicon_icon_style'] = '$livicon_icon_style';\n";
            $app_my_config_data .= "\$n_config['sidebar_icons'] = '$sidebar_icons';\n";
            $app_my_config_data .= "\$n_config['arabic_lang_icon'] = '$arabic_lang_icon';\n";
            $app_my_config_data .= "\$n_config['hebrew_lang_icon'] = '$hebrew_lang_icon';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_1_on'] = '$dashboard_section_1_on';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_1_only_admin'] = '$dashboard_section_1_only_admin';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_1_default'] = '$dashboard_section_1_default';\n";
            $app_my_config_data .= "\$n_config['page_help_default'] = '$page_help_default';\n";
            $app_my_config_data .= "\$n_config['page_help_only_admin'] = '$page_help_only_admin';\n";
            $app_my_config_data .= "\$n_config['page_help_view'] = '$page_help_view';\n";
            $app_my_config_data .= "\$n_config['page_faq_view'] = '$page_faq_view';\n";
            $app_my_config_data .= "\$n_config['page_faq_only_admin'] = '$page_faq_only_admin';\n";
            $app_my_config_data .= "\$n_config['page_faq_default'] = '$page_faq_default';\n";
            $app_my_config_data .= "\$n_config['greetings_on'] = '$greetings_on';\n";
            $app_my_config_data .= "\$n_config['greetings_random'] = '$greetings_random';\n";
            $app_my_config_data .= "\$n_config['start_modal_show'] = '$start_modal_show';\n";
            $app_my_config_data .= "\$n_config['start_modal_only_admin'] = '$start_modal_only_admin';\n";
            $app_my_config_data .= "\$n_config['start_modal_default'] = '$start_modal_default';\n";
            $app_my_config_data .= "\$n_config['start_modal_always_show'] = '$start_modal_always_show';\n";
            $app_my_config_data .= "\$n_config['login_page_text_show'] = '$login_page_text_show';\n";
            $app_my_config_data .= "\$n_config['login_page_text_default'] = '$login_page_text_default';\n";
            $app_my_config_data .= "\$n_config['disable_example_dashboard'] = '$disable_example_dashboard';\n";
            $app_my_config_data .= "\$n_config['ecommerce_product_gallery'] = '$ecommerce_product_gallery';\n";
            $app_my_config_data .= "\$n_config['default_lang_flowbuilder'] = '$default_lang_flowbuilder';\n";
            $app_my_config_data .= "\$n_config['default_flowbuilder'] = '$default_flowbuilder';\n";
            $app_my_config_data .= "\$n_config['show_lang_selector'] = '$show_lang_selector';\n";
            $app_my_config_data .= "\$n_config['is_external_off'] = '$is_external_off';\n";
            $app_my_config_data .= "\$n_config['payment_text_header_sidebar'] = '$payment_text_header_sidebar';\n";
            $app_my_config_data .= "\$n_config['payment_text_sidebar'] = '$payment_text_sidebar';\n";

            $app_my_config_data .= "\$n_config['pwa_on'] = '$pwa_on';\n";
            $app_my_config_data .= "\$n_config['pwa_name'] = '$pwa_name';\n";
            $app_my_config_data .= "\$n_config['pwa_short_name'] = '$pwa_short_name';\n";
            $app_my_config_data .= "\$n_config['pwa_description'] = '$pwa_description';\n";
            $app_my_config_data .= "\$n_config['pwa_theme_color'] = '$pwa_theme_color';\n";
            $app_my_config_data .= "\$n_config['pwa_background_color'] = '$pwa_background_color';\n";
            $app_my_config_data .= "\$n_config['pwa_icon_512'] = '$pwa_icon_512';\n";
            $app_my_config_data .= "\$n_config['pwa_apple_status_bar'] = '$pwa_apple_status_bar';\n";

            $app_my_config_data .= "\$n_config['eco_custom_domain'] = '$eco_custom_domain';\n";
            $app_my_config_data .= "\$n_config['custom_domain_host'] = '$custom_domain_host';\n";
            $app_my_config_data .= "\$n_config['wildcard_domain'] = '$wildcard_domain';\n";

            $app_my_config_data .= "\$n_config['theme_appeareance_on'] = '$theme_appeareance_on';\n";
            $app_my_config_data .= "\$n_config['theme_sidebar_color'] = '$theme_sidebar_color';\n";
            $app_my_config_data .= "\$n_config['dark_icon_color'] = '$dark_icon_color';\n";
            $app_my_config_data .= "\$n_config['sidebar_text_color'] = '$sidebar_text_color';\n";
            $app_my_config_data .= "\$n_config['primary_color'] = '$primary_color';\n";
            $app_my_config_data .= "\$n_config['light_primary_color'] = '$light_primary_color';\n";
            $app_my_config_data .= "\$n_config['danger_color'] = '$danger_color';\n";
            $app_my_config_data .= "\$n_config['success_color'] = '$success_color';\n";

            $app_my_config_data .= "\$n_config['warning_color'] = '$warning_color';\n";
            $app_my_config_data .= "\$n_config['nav_font'] = '$nav_font';\n";
            $app_my_config_data .= "\$n_config['body_font'] = '$body_font';\n";
            $app_my_config_data .= "\$n_config['nav_font_rtl'] = '$nav_font_rtl';\n";
            $app_my_config_data .= "\$n_config['body_font_rtl'] = '$body_font_rtl';\n";
            $app_my_config_data .= "\$n_config['light_icon_rtl'] = '$light_icon_rtl';\n";
            $app_my_config_data .= "\$n_config['dark_icon_rtl'] = '$dark_icon_rtl';\n";
            $app_my_config_data .= "\$n_config['dark_logo_rtl'] = '$dark_logo_rtl';\n";
            $app_my_config_data .= "\$n_config['light_logo_rtl'] = '$light_logo_rtl';\n";
            $app_my_config_data .= "\$n_config['primary_color_hover'] = '$primary_color_hover';\n";
            $app_my_config_data .= "\$n_config['primary_outline_color'] = '$primary_outline_color';\n";

            $app_my_config_data .= "\$n_config['body_font_font_size'] = '$body_font_font_size';\n";
            $app_my_config_data .= "\$n_config['card_title_font_size'] = '$card_title_font_size';\n";
            $app_my_config_data .= "\$n_config['body_font_font_size_rtl'] = '$body_font_font_size_rtl';\n";
            $app_my_config_data .= "\$n_config['card_title_font_size_rtl'] = '$card_title_font_size_rtl';\n";

            $app_my_config_data .= "\$n_config['signup_page_view'] = '$signup_page_view';\n";
            $app_my_config_data .= "\$n_config['signup_page_default_view'] = '$signup_page_default_view';\n";

            $app_my_config_data .= "\$n_config['helper_default_lang'] = '$helper_default_lang';\n";
            $app_my_config_data .= "\$n_config['helper_animation'] = '$helper_animation';\n";
            $app_my_config_data .= "\$n_config['package_qa_show'] = '$package_qa_show';\n";
            $app_my_config_data .= "\$n_config['package_qa_only_admin'] = '$package_qa_only_admin';\n";
            $app_my_config_data .= "\$n_config['package_qa_default'] = '$package_qa_default';\n";

            $app_my_config_data .= "\$n_config['welcome_modal_button_text_arabic'] = '$welcome_modal_button_text_arabic';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_english'] = '$welcome_modal_button_text_english';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_bengali'] = '$welcome_modal_button_text_bengali';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_dutch'] = '$welcome_modal_button_text_dutch';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_english'] = '$welcome_modal_button_text_english';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_french'] = '$welcome_modal_button_text_french';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_german'] = '$welcome_modal_button_text_german';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_greek'] = '$welcome_modal_button_text_greek';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_italian'] = '$welcome_modal_button_text_italian';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_polish'] = '$welcome_modal_button_text_polish';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_portuguese'] = '$welcome_modal_button_text_portuguese';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_russian'] = '$welcome_modal_button_text_russian';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_spanish'] = '$welcome_modal_button_text_spanish';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_turkish'] = '$welcome_modal_button_text_turkish';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_vietnamese'] = '$welcome_modal_button_text_vietnamese';\n";

            $app_my_config_data .= "\$n_config['sidebar_icon_help_bx'] = '$sidebar_icon_help_bx';\n";
            $app_my_config_data .= "\$n_config['sidebar_icon_help_livicons'] = '$sidebar_icon_help_livicons';\n";
            $app_my_config_data .= "\$n_config['sidebar_icon_faq_bx'] = '$sidebar_icon_faq_bx';\n";
            $app_my_config_data .= "\$n_config['sidebar_icon_faq_livicons'] = '$sidebar_icon_faq_livicons';\n";

            $app_my_config_data .= "\$n_config['btn_primary_color_hover'] = '$btn_primary_color_hover';\n";
            $app_my_config_data .= "\$n_config['dashboard_background'] = '$dashboard_background';\n";

            $app_my_config_data .= "\$n_config['spain_lang_icon'] = '$spain_lang_icon';\n";

            $app_my_config_data .= "\$n_config['n_paymongo_gateway_enabled'] = '$n_paymongo_gateway_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_gateway_gcash_enabled'] = '$n_paymongo_gateway_gcash_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_gateway_paymaya_enabled'] = '$n_paymongo_gateway_paymaya_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_gateway_grab_enabled'] = '$n_paymongo_gateway_grab_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_sec'] = '$n_paymongo_sec';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_pub'] = '$n_paymongo_pub';\n";

            $app_my_config_data .= "\$n_config['theme_mobile_full_width'] = '$theme_mobile_full_width';\n";
            $app_my_config_data .= "\$n_config['import_account_fb_alert'] = '$import_account_fb_alert';\n";

            $app_my_config_data .= "\$n_config['account_activation_view'] = '$account_activation_view';\n";
            $app_my_config_data .= "\$n_config['account_activation_default_view'] = '$account_activation_default_view';\n";
            $app_my_config_data .= "\$n_config['forgot_password_view'] = '$forgot_password_view';\n";
            $app_my_config_data .= "\$n_config['forgot_password_default_view'] = '$forgot_password_default_view';\n";
            $app_my_config_data .= "\$n_config['current_sidebar'] = '$current_sidebar';\n";

            $app_my_config_data .= "\$n_config['n_payu_latam_sandbox'] = '$n_payu_latam_sandbox';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_enabled'] = '$n_payu_latam_enabled';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_merchantid'] = '$n_payu_latam_merchantid';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_accountid'] = '$n_payu_latam_accountid';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_api_key'] = '$n_payu_latam_api_key';\n";
            $app_my_config_data .= "\$n_config['n_coinbase_enabled'] = '$n_coinbase_enabled';\n";
            $app_my_config_data .= "\$n_config['n_coinbase_shared_secret'] = '$n_coinbase_shared_secret';\n";
            $app_my_config_data .= "\$n_config['n_coinbase_api_key'] = '$n_coinbase_api_key';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_init'] = '$dashboard_section_init';\n";

            $app_my_config_data .= "\$n_config['n_moamalat_enabled'] = '$n_moamalat_enabled';\n";
            $app_my_config_data .= "\$n_config['n_moamalat_testmode'] = '$n_moamalat_testmode';\n";
            $app_my_config_data .= "\$n_config['n_moamalat_merchant_id'] = '$n_moamalat_merchant_id';\n";
            $app_my_config_data .= "\$n_config['n_moamalat_terminal_id'] = '$n_moamalat_terminal_id';\n";

            $app_my_config_data .= "\$n_config['n_sadad_enabled'] = '$n_sadad_enabled';\n";
            $app_my_config_data .= "\$n_config['n_sadad_testmode'] = '$n_sadad_testmode';\n";
            $app_my_config_data .= "\$n_config['n_sadad_secret_key'] = '$n_sadad_secret_key';\n";

            $app_my_config_data .= "\$n_config['n_tap_secret'] = '$n_tap_secret';\n";
            $app_my_config_data .= "\$n_config['n_tap_on'] = '$n_tap_on';\n";

            $app_my_config_data .= "\$n_config['mashkor_api_key'] = '$mashkor_api_key';\n";
            $app_my_config_data .= "\$n_config['mashkor_auth_key'] = '$mashkor_auth_key';\n";

            $app_my_config_data .= "\$n_config['sitemap_disable'] = '$sitemap_disable';\n";
            $app_my_config_data .= "\$n_config['webhook_disable'] = '$webhook_disable';\n";
            $app_my_config_data .= "\$n_config['pwa_disable'] = '$pwa_disable';\n";

            $app_my_config_data .= "\$n_config['n_tdsp_auth_key'] = '$n_tdsp_auth_key';\n";
            $app_my_config_data .= "\$n_config['n_tdsp_store_id'] = '$n_tdsp_store_id';\n";
            $app_my_config_data .= "\$n_config['n_tdsp_sandbox'] = '$n_tdsp_sandbox';\n";
            $app_my_config_data .= "\$n_config['n_tdsp_enabled'] = '$n_tdsp_enabled';\n";

            $app_my_config_data .= "\$n_config['n_stripe_product_image'] = '$n_stripe_product_image';\n";
            $app_my_config_data .= "\$n_config['n_stripe_secret_key'] = '$n_stripe_secret_key';\n";
            $app_my_config_data .= "\$n_config['n_stripe_enabled'] = '$n_stripe_enabled';\n";
            $app_my_config_data .= "\$n_config['n_stripe_subscription_enabled'] = '$n_stripe_subscription_enabled';\n";

            $app_my_config_data .= "\$n_config['onesignal_enabled'] = '$onesignal_enabled';\n";
            $app_my_config_data .= "\$n_config['onesignal_app_key'] = '$onesignal_app_key';\n";
            $app_my_config_data .= "\$n_config['saved_template_hide_save_btn'] = '$saved_template_hide_save_btn';\n";

            $app_my_config_data .= "\$n_config['n_mastercard_merchant_id'] = '$n_mastercard_merchant_id';\n";
            $app_my_config_data .= "\$n_config['n_mastercard_api_pass'] = '$n_mastercard_api_pass';\n";
            $app_my_config_data .= "\$n_config['n_mastercard_enabled'] = '$n_mastercard_enabled';\n";
            $app_my_config_data .= "\$n_config['n_mastercard_testmode'] = '$n_mastercard_testmode';\n";

            $app_my_config_data .= "\$n_config['n_epayco_pkey'] = '$n_epayco_pkey';\n";
            $app_my_config_data .= "\$n_config['n_epayco_enabled'] = '$n_epayco_enabled';\n";
            $app_my_config_data .= "\$n_config['n_epayco_testmode'] = '$n_epayco_testmode';\n";
            $app_my_config_data .= "\$n_config['n_epayco_checkout'] = '$n_epayco_checkout';\n";
            $app_my_config_data .= "\$n_config['n_epayco_api_private_key'] = '$n_epayco_api_private_key';\n";
            $app_my_config_data .= "\$n_config['n_epayco_subs_enabled'] = '$n_epayco_subs_enabled';\n";

            if ($n_moamalat_secret_key != '*****') {
                $app_my_config_data .= "\$n_config['n_moamalat_secret_key'] = '$n_moamalat_secret_key';\n";
            }


            $app_my_config_data .= "\$n_config['login_change_language'] = '$login_change_language';\n";

            $app_my_config_data .= "\$n_config['n_sellix_api_key'] = '$n_sellix_api_key';\n";
            $app_my_config_data .= "\$n_config['n_sellix_webhook_secret'] = '$n_sellix_webhook_secret';\n";
            $app_my_config_data .= "\$n_config['n_sellix_merchant'] = '$n_sellix_merchant';\n";
            $app_my_config_data .= "\$n_config['n_sellix_enabled'] = '$n_sellix_enabled';\n";
            $app_my_config_data .= "\$n_config['n_sellix_subs_enabled'] = '$n_sellix_subs_enabled';\n";

            $app_my_config_data .= "\$n_config['n_credits_on'] = '$n_credits_on';\n";

            $app_my_config_data .= "\$n_config['n_chapa_secret_key'] = '$n_chapa_secret_key';\n";
            $app_my_config_data .= "\$n_config['n_chapa_enabled'] = '$n_chapa_enabled';\n";

            $app_my_config_data .= "\$n_config['n_zaincash_enabled'] = '$n_zaincash_enabled';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_testmode_enabled'] = '$n_zaincash_testmode_enabled';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_merchant_secret'] = '$n_zaincash_merchant_secret';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_MSISDN'] = '$n_zaincash_MSISDN';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_merchant_id'] = '$n_zaincash_merchant_id';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_convert_price'] = '$n_zaincash_convert_price';\n";

            $app_my_config_data .= "\$n_config['dp_on'] = '$dp_on';\n";
            $app_my_config_data .= "\$n_config['dp_fixed_show'] = '$dp_fixed_show';\n";
            $app_my_config_data .= "\$n_config['dp_country_maxmind_db_key'] = '$dp_country_maxmind_db_key';\n";
            $app_my_config_data .= "\$n_config['dp_coupons_show'] = '$dp_coupons_show';\n";
            $app_my_config_data .= "\$n_config['dp_country_on'] = '$dp_country_on';\n";


            if(empty($n_config['new_cipher'])){
                $new_cipher = md5('e0c206d1376c35a2dc973cccb25c3155' . time() . base_url(''));
            }else{
                $new_cipher = $n_config['new_cipher'];
            }

            $app_my_config_data .= "\$n_config['new_cipher'] = '$new_cipher';\n";



            foreach ($splash as $k => $v) {
                $app_my_config_data .= "\$n_config['" . $k . "'] = '$v';\n";
            }

            file_put_contents(APPPATH . 'n_views/config_user.php', $app_my_config_data, LOCK_EX); //writting  application/config/my_config

            $eco_cd = "<?php \n";
            $eco_cd .= "\$ncd_config['eco_custom_domain'] = '$eco_custom_domain';\n";
            $eco_cd .= "\$ncd_config['custom_domain_host'] = '$custom_domain_host';\n";
            $eco_cd .= "\$ncd_config['wildcard_domain'] = '$wildcard_domain';\n";

            file_put_contents(APPPATH . 'custom_domain.php', $eco_cd, LOCK_EX); //writting  application/config/my_config

            if ($pwa_on == 'true') {
                $json_icons_arr = '';
                $size = array(384, 192, 180, 152, 144, 128, 120, 96, 76, 72);
                if (file_exists(FCPATH . '/assets/img/pwa_icon_512.png')) {
                    foreach ($size as $k) {
                        $img = $this->resize_image(FCPATH . '/assets/img/pwa_icon_512.png', $k, $k);
                        imagepng($img, FCPATH . '/assets/img/pwa_icon_' . $k . '.png');
                        $json_icons_arr .= ',
                            {
                                "src": "/assets/img/pwa_icon_' . $k . '.png",
                                "sizes": "' . $k . 'x' . $k . '",
                                "type": "image/png"
                            }';
                    }
                } else {
                    $pwa_icon_512 = '';
                }

                $simple_manifest_json = '{
                    "name": "' . $pwa_name . '",
                    "short_name": "' . $pwa_short_name . '",
                    "description": "' . $pwa_description . '",
                    "orientation": "portrait",
                    "start_url": "/?utm_source=pwa_homescreen",
                    "display": "standalone",
                    "theme_color": "' . $pwa_theme_color . '",
                    "background_color": "' . $pwa_background_color . '",
                    "related_applications": [{
						"platform": "webapp",
						"url": "' . base_url() . '/manifest.json"
					}],
                    "icons": [
                        {
                            "src": "' . $pwa_icon_512 . '",
                            "sizes": "512x512",
                            "type": "image/png"
                        }' . $json_icons_arr . '
                    ]
                }';

                file_put_contents(FCPATH . 'manifest.json', $simple_manifest_json, LOCK_EX);

                $serviceworker = "self.addEventListener('install', event => {

});

self.addEventListener('activate', event => {

});

self.addEventListener('fetch', event => {

});";


                file_put_contents(FCPATH . 'serviceworker.js', $serviceworker, LOCK_EX);


            } else {
                if (file_exists(FCPATH . 'manifest.json')) {
                    @unlink(FCPATH . 'manifest.json');
                    @unlink(FCPATH . 'serviceworker.json');
                }
            }

            $this->session->set_flashdata('success_message', 1);
            redirect('n_theme/settings', 'location');


        }


    }

    public function reinstall_database($rem = 0)
    {
        $db_v_file = "<?php \n";
        $db_v_file .= "\$n_db_version= 0;\n";

        $show_debug = 1;

        if ($rem == 0) {
            file_put_contents(APPPATH . 'n_db_version.php', $db_v_file, LOCK_EX);
            redirect(
                base_url('n_theme/reinstall_database/1'), 'Location'
            );
        } else {
            if (file_exists(APPPATH . 'n_views/include/db_update.php')) {
                include(APPPATH . 'n_views/include/db_update.php');
            }
        }


        echo 'Done. You can close this tab.';
    }

    private function resize_image($file, $w, $h)
    {
        list($width, $height) = getimagesize($file);
        $src = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($w, $h);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
        return $dst;
    }

    public function ecommerce_codes()
    {
        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
        if (!isset($xdata[0])) exit();

        $data = array();
        $data['iframe'] = '1';
        $data['body'] = "eccomerce_marketing";
        $data['code_before_body'] = '';
        $data['codes_custom_css'] = '';

        if (file_exists(APPPATH . '/n_eco_user/codes_custom_css_store_id_' . $xdata[0]['id'] . '.php')) {
            $data['codes_custom_css'] = file_get_contents(APPPATH . '/n_eco_user/codes_custom_css_store_id_' . $xdata[0]['id'] . '.php');
        }

        if (file_exists(APPPATH . '/n_eco_user/before_body_store_id_' . $xdata[0]['id'] . '.php')) {
            $data['code_before_body'] = file_get_contents(APPPATH . '/n_eco_user/before_body_store_id_' . $xdata[0]['id'] . '.php');
        }


        $this->_viewcontroller($data);
    }

    public function bot_instagram()
    {
        $this->is_engagement_exist = $this->engagement_exist();
        $data['body'] = 'menu_block_instagram';
        $data['page_title'] = $this->lang->line('Instagram Bot');
        $this->_viewcontroller($data);
    }

    public function ecommerce_marketing_save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') redirect('home/access_forbidden', 'location');

        if ($_POST) {
            $this->csrf_token_check();
            //$this->form_validation->set_rules('codes_before_body', '<b>' . $this->lang->line("You can add here Facebook Pixel, Google Pixel, Facebook Messenger codes. You can also put any other codes before <code>&lt;/body&gt;</code> tag. ") . '</b>', 'trim');


            $codes_before_body = $this->input->post('codes_before_body');

            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
            if (!isset($xdata[0])) exit();

            $myfile = APPPATH . '/n_eco_user/';
            if (!file_exists($myfile)) {
                mkdir($myfile, 0755, true);
            }

            file_put_contents(APPPATH . '/n_eco_user/before_body_store_id_' . $xdata[0]['id'] . '.php', $codes_before_body, LOCK_EX); //writting  application/config/my_config

            $this->session->set_flashdata('success_message', 1);
            redirect('n_theme/ecommerce_codes', 'location');

        }

    }

    public function ecommerce_marketing_save_new($store_unique_id = '', $file = 'body')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') redirect('home/access_forbidden', 'location');

        if ($_POST) {
            $this->csrf_token_check();
            //$this->form_validation->set_rules('codes_before_body', '<b>' . $this->lang->line("You can add here Facebook Pixel, Google Pixel, Facebook Messenger codes. You can also put any other codes before <code>&lt;/body&gt;</code> tag. ") . '</b>', 'trim');


            $codes_before_body = $this->input->post('codes_before_body');

            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("store_unique_id" => $store_unique_id, "user_id" => $this->user_id)));
            if (!isset($xdata[0])) exit();

            $myfile = APPPATH . '/n_eco_user/';
            if (!file_exists($myfile)) {
                mkdir($myfile, 0755, true);
            }

            file_put_contents(APPPATH . '/n_eco_user/before_' . $file . '_store_id_' . $xdata[0]['id'] . '.php', json_decode($codes_before_body, true), LOCK_EX);

            $this->session->set_flashdata('success_message', 1);
            echo json_encode(array('status' => '1', 'message' => $this->lang->line("Settings saved")));

        }

    }

    public function copy_to($store_unique_id = '', $lang = '')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') redirect('home/access_forbidden', 'location');

        if ($_POST) {
            $this->csrf_token_check();
            //$this->form_validation->set_rules('codes_before_body', '<b>' . $this->lang->line("You can add here Facebook Pixel, Google Pixel, Facebook Messenger codes. You can also put any other codes before <code>&lt;/body&gt;</code> tag. ") . '</b>', 'trim');


            $file = $this->input->post('file');

            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("store_unique_id" => $store_unique_id, "user_id" => $this->user_id)));
            if (!isset($xdata[0])) exit();

            $myfile = APPPATH . '/n_eco_user/';
            if (!file_exists($myfile)) {
                mkdir($myfile, 0755, true);
            }

            $copy_from = APPPATH . 'n_eco_user/' . $file . '_' . $xdata[0]['id'] . '_p.php';
            $copy_to = APPPATH . 'n_eco_user/' . $file . '_' . $xdata[0]['id'] . '_p' . $lang . '.php';

            if (!file_exists($myfile)) {
                mkdir($myfile, 0755, true);
            }

            if (!file_exists($copy_from)) {
                echo json_encode(array('status' => '0', 'message' => $this->lang->line("You dont have created default language item.")));
                exit;
            }

            if (file_exists($copy_to)) {
                @unlink($copy_to);
            }

            @copy($copy_from, $copy_to);

            $this->session->set_flashdata('success_message', 1);
            echo json_encode(array('status' => '1', 'message' => $this->lang->line("Settings saved")));

        }

    }

    public function ecommerce_save_codes_custom_css($store_unique_id = '')
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') redirect('home/access_forbidden', 'location');

        if ($_POST) {
            $this->csrf_token_check();
            //$this->form_validation->set_rules('codes_before_body', '<b>' . $this->lang->line("You can add here Facebook Pixel, Google Pixel, Facebook Messenger codes. You can also put any other codes before <code>&lt;/body&gt;</code> tag. ") . '</b>', 'trim');


            $codes_before_body = $this->input->post('data_codes_custom_css');

            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("store_unique_id" => $store_unique_id, "user_id" => $this->user_id)));
            if (!isset($xdata[0])) exit();

            $myfile = APPPATH . '/n_eco_user/';
            if (!file_exists($myfile)) {
                mkdir($myfile, 0755, true);
            }

            file_put_contents(APPPATH . '/n_eco_user/codes_custom_css_store_id_' . $xdata[0]['id'] . '.php', json_decode($codes_before_body, true), LOCK_EX); //writting  application/config/my_config

            $this->session->set_flashdata('success_message', 1);
            echo json_encode(array('status' => '1', 'message' => $this->lang->line("Settings saved")));

        }

    }

    public function ecommerce_settings()
    {
        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
        if (!isset($xdata[0])) exit();

        $data = array();
        $data['iframe'] = '1';
        $data['body'] = "ecommerce_settings";
        $data['code_before_body'] = '';


        include(APPPATH . '/n_views/default_ecommerce.php');


        if (file_exists(APPPATH . 'n_eco_user/store_settings_' . $xdata[0]['id'] . '.php')) {
            include(APPPATH . 'n_eco_user/store_settings_' . $xdata[0]['id'] . '.php');
        }


        $data['n_store_settings'] = $n_eco_config;
        $this->_viewcontroller($data);
    }

    public function ecommerce_settings_save()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        if ($_POST) {

            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('footer_mobile_menu', '<b>' . $this->lang->line("Enable mobile footer menu?") . '</b>', 'trim');
            $this->form_validation->set_rules('addthis_show', '<b>' . $this->lang->line("Enable addthis on product view") . '</b>', 'trim');
            // $this->form_validation->set_rules('addthis_code', '<b>' . $this->lang->line("Addthis Javascript code") . '</b>');
            $this->form_validation->set_rules('show_store_name', '<b>' . $this->lang->line("Show store name in header") . '</b>', 'trim');
            $this->form_validation->set_rules('store_logo_show', '<b>' . $this->lang->line("Logo store in header") . '</b>', 'trim');
            $this->form_validation->set_rules('contact_page_on', '<b>' . $this->lang->line("Enable contact page") . '</b>', 'trim');
            $this->form_validation->set_rules('addthis_class', '<b>' . $this->lang->line("Class name for addthis") . '</b>', 'trim');
            $this->form_validation->set_rules('footer_mobile_text', '<b>' . $this->lang->line("Enable mobile footer text menu?") . '</b>', 'trim');


            $this->form_validation->set_rules('theme_appeareance_on', '<b>' . $this->lang->line("Appearence On") . '</b>', 'trim');
            $this->form_validation->set_rules('nav_font', '<b>' . $this->lang->line("Navigation google fonts name") . '</b>', 'trim');
            $this->form_validation->set_rules('body_font', '<b>' . $this->lang->line("Body google fonts name") . '</b>', 'trim');
            $this->form_validation->set_rules('body_font_font_size', '<b>' . $this->lang->line("Body font size") . '</b>', 'trim');
            $this->form_validation->set_rules('card_title_font_size', '<b>' . $this->lang->line("Card title font size") . '</b>', 'trim');
            $this->form_validation->set_rules('theme_sidebar_color', '<b>' . $this->lang->line("Semi dark sidebar color") . '</b>', 'trim');
            $this->form_validation->set_rules('dark_icon_color', '<b>' . $this->lang->line("Sidebar icon color") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_text_color', '<b>' . $this->lang->line("Sidebar text color") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_color', '<b>' . $this->lang->line("Primary color") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_outline_color', '<b>' . $this->lang->line("Primary outline color") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_color_hover', '<b>' . $this->lang->line("Primary hover color") . '</b>', 'trim');
            $this->form_validation->set_rules('light_primary_color', '<b>' . $this->lang->line("Light primary color") . '</b>', 'trim');
            $this->form_validation->set_rules('danger_color', '<b>' . $this->lang->line("Danger color") . '</b>', 'trim');
            $this->form_validation->set_rules('success_color', '<b>' . $this->lang->line("Success color") . '</b>', 'trim');
            $this->form_validation->set_rules('warning_color', '<b>' . $this->lang->line("Warning color") . '</b>', 'trim');


            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->ecommerce_settings();
            } else {
                // assign
                $footer_mobile_menu = addslashes(strip_tags($this->input->post('footer_mobile_menu', true)));

                $addthis_show = addslashes(strip_tags($this->input->post('addthis_show', true)));
                $addthis_code = $this->input->post('addthis_code');
                $show_store_name = addslashes(strip_tags($this->input->post('show_store_name', true)));
                $store_logo_show = addslashes(strip_tags($this->input->post('store_logo_show', true)));
                $contact_page_on = addslashes(strip_tags($this->input->post('contact_page_on', true)));
                $addthis_class = addslashes(strip_tags($this->input->post('addthis_class', true)));
                $footer_mobile_text = addslashes(strip_tags($this->input->post('footer_mobile_text', true)));

                $theme_appeareance_on = addslashes(strip_tags($this->input->post('theme_appeareance_on', true)));
                $theme_sidebar_color = addslashes(strip_tags($this->input->post('theme_sidebar_color', true)));
                $dark_icon_color = addslashes(strip_tags($this->input->post('dark_icon_color', true)));
                $sidebar_text_color = addslashes(strip_tags($this->input->post('sidebar_text_color', true)));
                $primary_color = addslashes(strip_tags($this->input->post('primary_color', true)));
                $primary_outline_color = addslashes(strip_tags($this->input->post('primary_outline_color', true)));
                $light_primary_color = addslashes(strip_tags($this->input->post('light_primary_color', true)));
                $danger_color = addslashes(strip_tags($this->input->post('danger_color', true)));
                $success_color = addslashes(strip_tags($this->input->post('success_color', true)));
                $warning_color = addslashes(strip_tags($this->input->post('warning_color', true)));

                $primary_color_hover = addslashes(strip_tags($this->input->post('primary_color_hover', true)));
                $nav_font = addslashes(strip_tags($this->input->post('nav_font', true)));
                $body_font = addslashes(strip_tags($this->input->post('body_font', true)));
                $body_font_font_size = addslashes(strip_tags($this->input->post('body_font_font_size', true)));
                $card_title_font_size = addslashes(strip_tags($this->input->post('card_title_font_size', true)));


                $addthis_class = str_replace("'", "\'", $addthis_class);

                if ($footer_mobile_menu == '') {
                    $footer_mobile_menu = 'false';
                }

                $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
                if (!isset($xdata[0])) exit();

            }

            $eco_save = "<?php \n";
            $eco_save .= "\$n_eco_config['footer_mobile'] = '$footer_mobile_menu';\n";

            $eco_save .= "\$n_eco_config['addthis_show'] = '$addthis_show';\n";
            $eco_save .= "\$n_eco_config['addthis_code'] = '$addthis_code';\n";
            $eco_save .= "\$n_eco_config['show_store_name'] = '$show_store_name';\n";
            $eco_save .= "\$n_eco_config['store_logo_show'] = '$store_logo_show';\n";
            $eco_save .= "\$n_eco_config['contact_page_on'] = '$contact_page_on';\n";
            $eco_save .= "\$n_eco_config['addthis_class'] = '$addthis_class';\n";
            $eco_save .= "\$n_eco_config['footer_mobile_text'] = '$footer_mobile_text';\n";

            $eco_save .= "\$n_eco_config['theme_appeareance_on'] = '$theme_appeareance_on';\n";
            $eco_save .= "\$n_eco_config['theme_sidebar_color'] = '$theme_sidebar_color';\n";
            $eco_save .= "\$n_eco_config['dark_icon_color'] = '$dark_icon_color';\n";
            $eco_save .= "\$n_eco_config['sidebar_text_color'] = '$sidebar_text_color';\n";
            $eco_save .= "\$n_eco_config['primary_color'] = '$primary_color';\n";
            $eco_save .= "\$n_eco_config['primary_outline_color'] = '$primary_outline_color';\n";
            $eco_save .= "\$n_eco_config['light_primary_color'] = '$light_primary_color';\n";
            $eco_save .= "\$n_eco_config['danger_color'] = '$danger_color';\n";
            $eco_save .= "\$n_eco_config['success_color'] = '$success_color';\n";
            $eco_save .= "\$n_eco_config['warning_color'] = '$warning_color';\n";
            $eco_save .= "\$n_eco_config['primary_color_hover'] = '$primary_color_hover';\n";
            $eco_save .= "\$n_eco_config['nav_font'] = '$nav_font';\n";
            $eco_save .= "\$n_eco_config['body_font'] = '$body_font';\n";
            $eco_save .= "\$n_eco_config['body_font_font_size'] = '$body_font_font_size';\n";
            $eco_save .= "\$n_eco_config['card_title_font_size'] = '$card_title_font_size';\n";


            $myfile = APPPATH . '/n_eco_user/';
            if (!file_exists($myfile)) {
                mkdir($myfile, 0755, true);
            }

            file_put_contents(APPPATH . '/n_eco_user/store_settings_' . $xdata[0]['id'] . '.php', $eco_save, LOCK_EX); //writting  application/config/my_config

            $this->session->set_flashdata('success_message', 1);
            redirect('n_theme/ecommerce_settings', 'location');
        }


    }

    public function help()
    {
        $this->_viewcontroller(array("body" => "help_page_base", "page_title" => $this->lang->line("Help")));
    }

    public function faq()
    {
        $this->_viewcontroller(array("body" => "faq_page_base", "page_title" => $this->lang->line("FAQ")));
    }


    public function faq_edit($lang_faq, $file_save = 'faq')
    {
        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }

        if (file_exists(APPPATH . '/n_eco_user/' . $file_save . '_' . $lang_faq . '.php')) {
            $data_json = json_decode(file_get_contents(APPPATH . '/n_eco_user/' . $file_save . '_' . $lang_faq . '.php'), true);
        } else {
            $data_json = '';
        }

        $this->_viewcontroller(array("body" => "faq_edit", "page_title" => $file_save . ' ' . $this->lang->line("edit"), 'lang_faq' => $lang_faq, 'data_json' => $data_json, 'file_save' => $file_save));

    }

    public function faq_save($lang_faq, $file_save = 'faq')
    {

        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }


        file_put_contents(APPPATH . '/n_eco_user/' . $file_save . '_' . $lang_faq . '.php', json_encode($_POST));

        $this->session->set_flashdata('success_message', 1);
        redirect('n_theme/faq_edit/' . $lang_faq . '/' . $file_save, 'location');


    }

    public function alerts_edit($lang_faq = 'all', $file_save = 'alerts')
    {
        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }

        if (file_exists(APPPATH . '/n_eco_user/' . $file_save . '_' . $lang_faq . '.php')) {
            $data_json = json_decode(file_get_contents(APPPATH . '/n_eco_user/' . $file_save . '_' . $lang_faq . '.php'), true);
        } else {
            $data_json = '';
        }

        $this->_viewcontroller(array("body" => "alerts_edit", "page_title" => $this->lang->line("Alerts edit"), 'lang_faq' => $lang_faq, 'data_json' => $data_json, 'file_save' => $file_save));

    }

    public function alerts_save($lang_faq = 'all', $file_save = 'alerts')
    {

        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }


        file_put_contents(APPPATH . '/n_eco_user/' . $file_save . '_' . $lang_faq . '.php', json_encode($_POST));

        $this->session->set_flashdata('success_message', 1);
        redirect('n_theme/alerts_edit', 'location');


    }


    public function user_editor_page($id_store = 0, $page_lang = '')
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }

        if (empty($id_store)) {
            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
            if (!isset($xdata[0])) {
                redirect('home/login_page', 'location');
            }
        } else {
            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $id_store, "user_id" => $this->user_id)));
            if (!isset($xdata[0])) {
                redirect('home/login_page', 'location');
            }
        }

        $data = array();
        $data['page_edit'] = 'contact_page_' . $xdata[0]['id'] . '_p' . $page_lang;
        $this->load->view('n_user_editor_main.php', $data);
    }

    public function ecommerce_home_editor_page($id_store = 0, $page_lang = '')
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }

        if (empty($id_store)) {
            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
            if (!isset($xdata[0])) {
                redirect('home/login_page', 'location');
            }
        } else {
            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $id_store, "user_id" => $this->user_id)));
            if (!isset($xdata[0])) {
                redirect('home/login_page', 'location');
            }
        }

        $data = array();
        $data['page_edit'] = 'home_page_' . $xdata[0]['id'] . '_p' . $page_lang;
        $this->load->view('n_user_editor_main.php', $data);
    }

    public function welcome_modal_editor($id_store = 0, $page_lang = '')
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }

        if (empty($id_store)) {
            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
            if (!isset($xdata[0])) {
                redirect('home/login_page', 'location');
            }
        } else {
            $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $id_store, "user_id" => $this->user_id)));
            if (!isset($xdata[0])) {
                redirect('home/login_page', 'location');
            }
        }

        $data = array();
        $data['page_edit'] = 'modal_popup_' . $xdata[0]['id'] . '_p' . $page_lang;
        $this->load->view('n_user_editor_main.php', $data);
    }


    public function user_page_save($lang_page)
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        //$data = json_decode(file_get_contents("php://input"),true);


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
        if (!isset($xdata[0])) exit();

        if (strpos($lang_page, '_' . $xdata[0]['id'] . '_p') !== false) {
        } else {
            echo json_encode("FAILED");
            exit;
        }

        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }

        if (file_put_contents(APPPATH . '/n_eco_user/' . $lang_page . '.php', file_get_contents("php://input")) === FALSE) {
            echo json_encode("FAILED");
        } else {
            echo json_encode("SUCCESS");
        }


    }

    public function user_page_load($lang_page)
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        //$data = json_decode(file_get_contents("php://input"),true);


        $myfile = APPPATH . '/n_eco_user/';
        if (!file_exists($myfile)) {
            mkdir($myfile, 0755, true);
        }

        if (file_exists(APPPATH . '/n_eco_user/' . $lang_page . '.php')) {
            echo file_get_contents(APPPATH . '/n_eco_user/' . $lang_page . '.php');
        } else {
            echo '';
        }


    }

    public function module_search()
    {

        echo '{
 "listItems": [';

        echo '    
   {"name":"' . $this->lang->line('Bot Settings') . '", "url":"' . base_url() . 'messenger_bot/bot_list","icon":"bx bxs-cog"},
   {"name":"' . $this->lang->line('Post-back Manager') . '", "url":"' . base_url() . 'messenger_bot/template_manager","icon":"bx bxs-grid"},
   {"name":"' . $this->lang->line('Manage Templates') . '", "url":"' . base_url() . 'messenger_bot/otn_template_manager","icon":"bx bxs-checkbox-checked"},
   {"name":"' . $this->lang->line('OTN Report') . '", "url":"' . base_url() . 'messenger_bot/otn_subscribers","icon":"bx bx-bullseye"},
   {"name":"' . $this->lang->line('Whitelisted Domains') . '", "url":"' . base_url() . 'messenger_bot/domain_whitelist","icon":"bx bx-check-circle"},
   {"name":"' . $this->lang->line('Checkbox Plugin') . '", "url":"' . base_url() . 'messenger_bot_enhancers/checkbox_plugin_list","icon":"bx bxs-checkbox-checked"},
   {"name":"' . $this->lang->line('Send to Messenger') . '", "url":"' . base_url() . 'messenger_bot_enhancers/send_to_messenger_list","icon":"bx bx-paper-plane"},
   {"name":"' . $this->lang->line('dashboard') . '", "url":"' . base_url() . 'dashboard/","icon":"bx bx-home-alt"},
   ';
        if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '201', '202', '204', '206', '220', '222', '223', '251', '256'])) > 0) {
            echo '{"name":"' . $this->lang->line('Comment template management...') . '", "url":"' . base_url() . 'comment_automation/comment_template_manager","icon":"bx bx-comment"},';
        }

        if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '220', '222', '223', '256'])) > 0) {
            echo '{"name":"' . $this->lang->line('Reply template management...') . '", "url":"' . base_url() . 'comment_automation/template_manager","icon":"bx bx-comment"},';
        }

        if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '204', '206', '251'])) > 0) {
            echo '{"name":"' . $this->lang->line('Campaign Automation management...') . '", "url":"' . base_url() . 'comment_automation/index","icon":"bx bx-comment"},';
        }

        if ($this->basic->is_exist("add_ons", array("project_id" => 29))) {
            if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['201', '202'])) > 0) {
                echo '{"name":"' . $this->lang->line('Tag campaign management...') . '", "url":"' . base_url() . 'comment_reply_enhancers/post_list","icon":"bx bx-comment"},';
            }
        }

        if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '201', '202', '204', '206'])) > 0) {
            echo '{"name":"' . $this->lang->line('All campaign reports...') . '", "url":"' . base_url() . 'comment_automation/comment_section_report","icon":"bx bx-comment"},';
        }

        if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['278', '279'])) > 0) {

            if ($this->config->item('instagram_reply_enable_disable') == '1') {
                echo '{"name":"' . $this->lang->line("Instagram") . ' ' . $this->lang->line('Reply template management...') . '", "url":"' . base_url() . 'instagram_reply/template_manager","icon":"bx bx-comment"},
                 {"name":"' . $this->lang->line("Instagram") . ' ' . $this->lang->line('Campaign Automation management...') . '", "url":"' . base_url() . 'instagram_reply/get_account_lists","icon":"bx bx-comment"},
                 {"name":"' . $this->lang->line("Instagram") . ' ' . $this->lang->line('All campaign reports...') . '", "url":"' . base_url() . 'instagram_reply/reports","icon":"bx bx-comment"},
                ';
            }

            if (file_exists(APPPATH . "modules/n_igstats/controllers/N_igstats.php")) {
                echo '
                {"name":"' . $this->lang->line("Instagram") . ' ' . $this->lang->line('Statistics') . '", "url":"' . base_url() . 'n_igstats/index","icon":"bx bx-line-chart"},';
            }
        }

        if ($this->session->userdata('user_type') == 'Admin' || in_array(80, $this->module_access)) {
            echo '{"name":"' . $this->lang->line("Report of auto comment reply & private reply.") . ' ' . $this->lang->line('See Report') . '", "url":"' . base_url() . 'comment_automation/all_auto_reply_report","icon":"bx bx-line-chart"},';
        }

        if ($this->session->userdata('user_type') == 'Admin' || in_array(80, $this->module_access)) {
            echo '{"name":"' . $this->lang->line("Report of auto comment reply & private reply.") . ' ' . $this->lang->line('See Report') . '", "url":"' . base_url() . 'comment_automation/all_auto_reply_report","icon":"bx bx-line-chart"},';
        }

        if ($this->basic->is_exist("add_ons", array("project_id" => 29))) {
            if ($this->session->userdata('user_type') == 'Admin' || in_array(201, $this->module_access)) {
                echo '{"name":"' . $this->lang->line("Report of bulk tag in single comment.") . ' ' . $this->lang->line('See Report') . '", "url":"' . base_url() . 'comment_reply_enhancers/bulk_tag_campaign_list","icon":"bx bx-line-chart"},';
            }

            if ($this->session->userdata('user_type') == 'Admin' || in_array(202, $this->module_access)) {
                echo '{"name":"' . $this->lang->line("Report of tag in each reply of comment.") . ' ' . $this->lang->line('See Report') . '", "url":"' . base_url() . 'comment_reply_enhancers/bulk_comment_reply_campaign_list","icon":"bx bx-line-chart"},';
            }

            if ($this->session->userdata('user_type') == 'Admin' || in_array(204, $this->module_access)) {
                echo '{"name":"' . $this->lang->line("Report of comment reply & private reply of full pages.") . ' ' . $this->lang->line('See Report') . '", "url":"' . base_url() . 'comment_reply_enhancers/all_response_report","icon":"bx bx-line-chart"},';
            }

            if ($this->session->userdata('user_type') == 'Admin' || in_array(206, $this->module_access)) {
                echo '{"name":"' . $this->lang->line("Report of sharing & liking by other page's you own.") . ' ' . $this->lang->line('See Report') . '", "url":"' . base_url() . 'comment_reply_enhancers/all_like_share_report","icon":"bx bx-line-chart"},';
            }

            echo '{"name":"' . $this->lang->line("Sync Subscribers") . '", "url":"' . base_url() . 'subscriber_manager/sync_subscribers","icon":"bx bx-sync"},';


            echo '{"name":"' . $this->lang->line("Bot Subscribers") . '", "url":"' . base_url() . 'subscriber_manager/bot_subscribers","icon":"bx bx-user-circle"},';

            echo '{"name":"' . $this->lang->line("Labels/Tags") . '", "url":"' . base_url() . 'subscriber_manager/contact_group","icon":"bx bx-purchase-tag-alt"},';

            if ($this->basic->is_exist("modules", array("id" => 263)) || $this->basic->is_exist("modules", array("id" => 264))) {
                if ($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array('263', '264'))) != 0) {
                    echo '{"name":"' . $this->lang->line("Manage contacts by groups, sms/email campaign...") . '", "url":"' . base_url() . 'sms_email_manager/contact_group_list","icon":"bx bx-group"},';

                    echo '{"name":"' . $this->lang->line("Manage contacts, import, sms/email campaign...") . '", "url":"' . base_url() . 'sms_email_manager/contact_list","icon":"bx bx-book"},';


                }
            }

            if ($this->basic->is_exist("modules", array("id" => 290))) {
                if ($this->session->userdata('user_type') == 'Admin' || in_array(290, $this->module_access)) {
                    echo '{"name":"' . $this->lang->line("Email Phone Opt-in Form Builder") . '", "url":"' . base_url() . 'email_optin_form_builder","icon":"bx  bxl-pocket"},';

                }
            }

            echo '{"name":"' . $this->lang->line("Create opt-in Form") . '", "url":"' . base_url() . 'email_optin_form_builder/create_email_optin_form","icon":"bx bx-plus-circle"},';


            echo '{"name":"' . $this->lang->line("Post-back Manager") . ' ' . $this->lang->line("Create with classic editor") . '", "url":"' . base_url() . 'messenger_bot/create_new_template","icon":"bx bx-plus-circle"},';

            echo '{"name":"' . $this->lang->line("Webview builder") . ' ' . $this->lang->line("Create New Form") . '", "url":"' . base_url() . 'messenger_bot_connectivity","icon":"bx bx-plus-circle"},';


            echo '{"name":"' . $this->lang->line("Add woocommerce abandoned cart plugin") . '", "url":"' . base_url() . 'woocommerce_abandoned_cart/recovery_plugin_add","icon":"bx bx-plus-circle"},';

            echo '{"name":"' . $this->lang->line("User Input Flow Campaign") . '", "url":"' . base_url() . 'custom_field_manager/campaign_list","icon":"bx bx-plus-circle"},';
            echo '{"name":"' . $this->lang->line("Custom Fields") . '", "url":"' . base_url() . 'custom_field_manager/custom_field_list","icon":"bx bx-plus-circle"},';


            echo '{"name":"' . $this->lang->line("MailChimp Integration") . '", "url":"' . base_url() . 'email_auto_responder_integration/mailchimp_list","icon":"bx bx-mail-send"},';
            echo '{"name":"' . $this->lang->line("Sendinblue Integration") . '", "url":"' . base_url() . 'email_auto_responder_integration/sendinblue_list","icon":"bx bx-mail-send"},';
            echo '{"name":"' . $this->lang->line("Activecampaign Integration") . '", "url":"' . base_url() . 'email_auto_responder_integration/activecampaign_list","icon":"bx bx-mail-send"},';
            echo '{"name":"' . $this->lang->line("Mautic Integration") . '", "url":"' . base_url() . 'email_auto_responder_integration/mautic_list","icon":"bx bx-mail-send"},';
            echo '{"name":"' . $this->lang->line("Acelle Integration") . '", "url":"' . base_url() . 'email_auto_responder_integration/acelle_list","icon":"bx bx-mail-send"},';

            echo '{"name":"' . $this->lang->line("Custom data collection form for messenger bot") . '", "url":"' . base_url() . 'messenger_bot_connectivity/webview_builder_manager","icon":"bx bx-detail"},';

            echo '{"name":"' . $this->lang->line("Connect bot data with 3rd party apps") . '", "url":"' . base_url() . 'messenger_bot_connectivity/json_api_connector","icon":"bx bx-plug"},';

            echo '{"name":"' . $this->lang->line("Saved exported bot settings") . '", "url":"' . base_url() . 'messenger_bot/saved_templates","icon":"bx bxs-save"},';

            echo '{"name":"' . $this->lang->line("Visual Flow Builder") . '", "url":"' . base_url() . 'visual_flow_builder/flowbuilder_manager","icon":"bx bxs-network-chart"},';

            echo '{"name":"' . $this->lang->line("Non-promo with tag, 24H structured message broadcast to messenger bot subscribers") . '", "url":"' . base_url() . 'messenger_bot_enhancers/subscriber_broadcast_campaign","icon":"bx bx-group"},';
            echo '{"name":"' . $this->lang->line("One-Time Notification request follow-up message broadcasting") . '", "url":"' . base_url() . 'messenger_bot_broadcast/otn_subscriber_broadcast_campaign","icon":"bx bx-group"},';
            echo '{"name":"' . $this->lang->line("SMS API Settings") . '", "url":"' . base_url() . 'sms_email_manager/sms_api_lists","icon":"bx bx-plug"},';
            echo '{"name":"' . $this->lang->line("SMS Campaign") . '", "url":"' . base_url() . 'sms_email_manager/sms_campaign_lists","icon":"bx bxs-chat"},';
            echo '{"name":"' . $this->lang->line("Templates for SMS Sequecne Message...") . '", "url":"' . base_url() . 'sms_email_sequence/template_lists/sms","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("SMTP API") . '", "url":"' . base_url() . 'sms_email_manager/smtp_config","icon":"bx bx-plug"},';
            echo '{"name":"' . $this->lang->line("Mandrill API") . '", "url":"' . base_url() . 'sms_email_manager/mandrill_api_config","icon":"bx bx-plug"},';
            echo '{"name":"' . $this->lang->line("Sendgrid API") . '", "url":"' . base_url() . 'sms_email_manager/sendgrid_api_config","icon":"bx bx-plug"},';
            echo '{"name":"' . $this->lang->line("Mailgun API") . '", "url":"' . base_url() . 'sms_email_manager/mailgun_api_config","icon":"bx bx-plug"},';

            echo '{"name":"' . $this->lang->line("Email Campaign") . '", "url":"' . base_url() . 'sms_email_manager/email_campaign_lists","icon":"bx bx-envelope"},';
            echo '{"name":"' . $this->lang->line("Templates for Email Sequecne Message...") . '", "url":"' . base_url() . 'sms_email_manager/template_lists/email","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Sequence Campaing for external Contacts...") . '", "url":"' . base_url() . 'sms_email_sequence/external_sequence_lists","icon":"bx bx-envelope"},';
            echo '{"name":"' . $this->lang->line("WoocCommerce Integration") . '", "url":"' . base_url() . 'woocommerce_integration","icon":"bx bx-plug"},';


            echo '{"name":"' . $this->lang->line("Import Facebook Accounts") . '", "url":"' . base_url() . 'social_accounts/index","icon":"bx bx-plus-circle"},';
            echo '{"name":"' . $this->lang->line("Import Social Accounts") . '", "url":"' . base_url() . 'comboposter/social_accounts","icon":"bx bx-plus-circle"},';

            echo '{"name":"' . $this->lang->line("Multimedia Post") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'ultrapost/text_image_link_video","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Multimedia Post") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'ultrapost/text_image_link_video_poster","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Carousel, Slideshow") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'ultrapost/carousel_slider_post","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Carousel, Slideshow") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'ultrapost/carousel_slider_poster","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Facebook Livestreaming") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'ultrapost/live_scheduler_list","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Facebook Livestreaming") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'ultrapost/carousel_slider_poster","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Call to Action") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'ultrapost/cta_post","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Call to Action") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'ultrapost/cta_poster","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Post on Instagram account...") . '", "url":"' . base_url() . 'instagram_poster","icon":"bx bx-list-ul"},';

            echo '{"name":"' . $this->lang->line("Image Poster") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'comboposter/image_post/campaigns","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Image Poster") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'comboposter/image_post/create","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Text Post") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'comboposter/text_post/campaigns","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Text Post") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'comboposter/text_post/create","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Video Post") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'comboposter/video_post/campaigns","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Video Post") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'comboposter/video_post/create","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Link Post") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'comboposter/link_post/campaigns","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("Link Post") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'comboposter/link_post/create","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("HTML Post") . ' ' . $this->lang->line("Campaign List") . '", "url":"' . base_url() . 'comboposter/html_post/campaigns","icon":"bx bx-list-ul"},';
            echo '{"name":"' . $this->lang->line("HTML Post") . ' ' . $this->lang->line("Create new Post") . '", "url":"' . base_url() . 'comboposter/html_post/create","icon":"bx bx-list-plus"},';

            echo '{"name":"' . $this->lang->line("Upload Text, Image, Link posts via CSV file") . '", "url":"' . base_url() . 'post_planner","icon":"bx bx-list-ul"},';

            echo '{"name":"' . $this->lang->line("Auto Post") . ' ' . $this->lang->line("RSS feed post") . '", "url":"' . base_url() . 'autoposting/settings","icon":"bx bx-rss"},';
            echo '{"name":"' . $this->lang->line("Auto Post") . ' ' . $this->lang->line("WP feed post") . '", "url":"' . base_url() . 'auto_feed_post/wordpress_settings","icon":"bx bxl-wordpress"},';
            echo '{"name":"' . $this->lang->line("Auto Post") . ' ' . $this->lang->line("YouTube video post") . '", "url":"' . base_url() . 'auto_feed_post/youtube_settings","icon":"bx bxl-youtube"},';

            echo '{"name":"' . $this->lang->line("Create campaigns using CTA, Event or Offer posts") . ' ' . $this->lang->line("Google My Business") . '", "url":"' . base_url() . 'gmb/posts","icon":"bx bx-list-plus"},';
            echo '{"name":"' . $this->lang->line("Create campaings using images or videos") . ' ' . $this->lang->line("Google My Business") . '", "url":"' . base_url() . 'gmb/media_campaigns","icon":"bx bx-list-plus"},';
            echo '{"name":"' . $this->lang->line("Create campaigns using RSS auto posts") . ' ' . $this->lang->line("Google My Business") . '", "url":"' . base_url() . 'gmb/rss","icon":"bx bx-list-plus"},';

            if (!file_exists(FCPATH . 'modules/marketing/controllers/Marketing.php')) {
                echo '{"name":"' . $this->lang->line("Interest Explorer") . ' ' . $this->lang->line("Facebook Hidden Interest Explorer for ADS targeting") . '", "url":"' . base_url() . 'marketing/get_interest","icon":"bx bx-chart"},';
            }
            echo '{"name":"' . $this->lang->line("Website Comparison") . ' ' . $this->lang->line("Social existency (share, like, comment...)") . '", "url":"' . base_url() . 'search_tools/comparision","icon":"bx bx-adjust"},';
            if ($this->config->item('instagram_reply_enable_disable')) {
                echo '{"name":"' . $this->lang->line("Hashtag Search") . ' ' . $this->lang->line("Search Top & Recent media with hashtag in Instagram") . '", "url":"' . base_url() . 'instagram_reply/hashTag_search","icon":"bx bx-purchase-tag-alt"},';
            }

            //echo '{"name":"' . $this->lang->line("").'", "url":"' . base_url() . ',"icon":"bx bx-"},';

        }

        echo '
           {"name":"' . $this->lang->line('Facebook Account Import') . '", "url":"' . base_url() . 'social_accounts/index","icon":"bx bx-import"}
 ]
}';


    }

    public function fix_menu()
    {

        $sql_cust = "DELETE from `menu_child_1` where url like '%n_theme/settings%' ";
        $this->db->query($sql_cust);
        $sql_cust = "DELETE from `menu_child_1` where url like '%n_theme/custom_domain_admin%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu_child_1` where url LIKE '%n_theme/settings%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT parent_id, serial FROM `menu_child_1` where url LIKE '%update_system%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'NVX Theme Settings', 'fa fa-layer-group', 'n_theme/settings', " . ($parent_id_to_add['serial'] + 1) . ", '', '0', '1', '0', '0', '0', '0', " . $parent_id_to_add['parent_id'] . ");";
                $this->db->query($sql_cust);
                $sql_cust = "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'Ecommerce Custom Domain', 'fa fa-layer-group', 'n_theme/custom_domain_admin', " . ($parent_id_to_add['serial'] + 1) . ", '', '0', '1', '0', '0', '0', '0', " . $parent_id_to_add['parent_id'] . ");";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }

        echo "Done";

    }

    public function custom_domain()
    {
        $data = array();
        $data['body'] = "eccomerce_custom_domain";
        $data['iframe'] = '1';
        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));
        if (!isset($xdata[0])) exit();
        $eco_shop_id = $xdata[0]['store_unique_id'];
        $data['shop_id'] = $xdata[0]['id'];

        if ($this->session->userdata('user_type') != 'Admin' && !in_array(3100, $this->module_access)) {
            $data['no_access'] = true;
            $data['custom_id'] = $eco_shop_id;
        } else {
            $data['no_access'] = false;

            $n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
                "custom_id" => $xdata[0]['id'],
                "module" => '1',
                "active !=" => '2',
                "user_id" => $this->user_id
            )
            ));

            if (empty($n_cd_data)) {
                $data['host_url'] = '';
            } else {
                $data['host_url'] = $n_cd_data[0]['host_url'];
            }

            $whdata = $this->basic->get_data("n_webhook", array("where" => array("store_id" => $xdata[0]['id'], "user_id" => $this->user_id)));

            if (!empty($whdata[0])) {
                $data['wh_domains'] = explode(',', $whdata[0]['domains']);
                $data['wh_error_log'] = json_decode($whdata[0]['error_log'], true);
            }


            $data['custom_id'] = $eco_shop_id;
            $data['n_eco_cd'] = $n_cd_data;

        }
        $this->_viewcontroller($data);
    }

    public function custom_domain_admin_save()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $this->ajax_check();
        $this->csrf_token_check();
        $app_table_id = $this->input->post('id', true);
        $this->basic->update_data(
            'n_custom_domain',
            array('id' => $app_table_id),
            array('active' => 1)
        );

        echo json_encode(array('status' => '1', 'message' => $this->lang->line("Custom domain activated")));

    }

    public function custom_domain_admin_delete()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $this->ajax_check();
        $this->csrf_token_check();
        $app_table_id = $this->input->post('id', true);

        $this->basic->delete_data('n_custom_domain', array('id' => $app_table_id));

        echo json_encode(array('status' => '1', 'message' => $this->lang->line("Custom domain deleted")));

    }

    public function helper_page_remove()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $this->ajax_check();
        $this->csrf_token_check();
        $page_id = $this->input->post('page_id', true);

        if (file_exists(APPPATH . 'n_eco_user/helper_' . $page_id . '.php')) {
            @unlink(APPPATH . 'n_eco_user/helper_' . $page_id . '.php');
        }

        echo json_encode(array('status' => '1', 'message' => $this->lang->line("Helper page deleted")));

    }

    public function custom_domain_admin()
    {
        $n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
            "active == 0 OR active == 2"
        )
        ));
        $data = array();
        $data['body'] = "eccomerce_custom_domain_admin";
        $data['page_title'] = "Custom Domain Admin";
        $data['n_cd_data'] = $n_cd_data;

        $this->_viewcontroller($data);
    }

    public function helper_page()
    {
//        $json = '';
//        $newarr = array();
//        $json = json_decode($json, true);
//        foreach($json['listItems'] as $k => $v){
//            $newarr[] =  trim(str_replace(array(base_url(),' '), '', $v['url']));
//        }
//        echo json_encode($newarr);

        $data = array();
        $data['body'] = "helper_pages";
        $data['page_title'] = "Helper pages";
        $data['all_pages'] = $this->all_pages();

        $this->_viewcontroller($data);

    }

    private function all_pages()
    {
        return json_decode('
["messenger_bot\/template_manager\/ig","custom_field_manager\/custom_field_list\/ig","custom_field_manager\/campaign_list\/ig","bot_instagram","messenger_bot\/bot_list","messenger_bot\/template_manager","messenger_bot\/otn_template_manager","messenger_bot\/otn_subscribers","messenger_bot\/domain_whitelist","messenger_bot_enhancers\/checkbox_plugin_list","messenger_bot_enhancers\/send_to_messenger_list","dashboard","comment_automation\/comment_template_manager","comment_automation\/template_manager","comment_automation\/index","comment_reply_enhancers\/post_list","comment_automation\/comment_section_report","instagram_reply\/template_manager","instagram_reply\/get_account_lists","instagram_reply\/reports","n_igstats\/index","comment_automation\/all_auto_reply_report","comment_automation\/all_auto_reply_report","comment_reply_enhancers\/bulk_tag_campaign_list","comment_reply_enhancers\/bulk_comment_reply_campaign_list","comment_reply_enhancers\/all_response_report","comment_reply_enhancers\/all_like_share_report","subscriber_manager\/sync_subscribers","subscriber_manager\/bot_subscribers","subscriber_manager\/contact_group","sms_email_manager\/contact_group_list","sms_email_manager\/contact_list","email_optin_form_builder","email_optin_form_builder\/create_email_optin_form","messenger_bot\/create_new_template","messenger_bot_connectivity","woocommerce_abandoned_cart\/recovery_plugin_add","custom_field_manager\/campaign_list","custom_field_manager\/custom_field_list","email_auto_responder_integration\/mailchimp_list","email_auto_responder_integration\/sendinblue_list","email_auto_responder_integration\/activecampaign_list","email_auto_responder_integration\/mautic_list","email_auto_responder_integration\/acelle_list","messenger_bot_connectivity\/webview_builder_manager","messenger_bot_connectivity\/json_api_connector","messenger_bot\/saved_templates","visual_flow_builder\/flowbuilder_manager","messenger_bot_enhancers\/subscriber_broadcast_campaign","messenger_bot_broadcast\/otn_subscriber_broadcast_campaign","sms_email_manager\/sms_api_lists","sms_email_manager\/sms_campaign_lists","sms_email_sequence\/template_lists\/sms","sms_email_manager\/smtp_config","sms_email_manager\/mandrill_api_config","sms_email_manager\/sendgrid_api_config","sms_email_manager\/mailgun_api_config","sms_email_manager\/email_campaign_lists","sms_email_manager\/template_lists\/email","sms_email_sequence\/external_sequence_lists","woocommerce_integration","social_accounts\/index","comboposter\/social_accounts","ultrapost\/text_image_link_video","ultrapost\/text_image_link_video_poster","ultrapost\/carousel_slider_post","ultrapost\/carousel_slider_poster","ultrapost\/live_scheduler_list","ultrapost\/carousel_slider_poster","ultrapost\/cta_post","ultrapost\/cta_poster","instagram_poster","comboposter\/image_post\/campaigns","comboposter\/image_post\/create","comboposter\/text_post\/campaigns","comboposter\/text_post\/create","comboposter\/video_post\/campaigns","comboposter\/video_post\/create","comboposter\/link_post\/campaigns","comboposter\/link_post\/create","comboposter\/html_post\/campaigns","comboposter\/html_post\/create","post_planner","autoposting\/settings","auto_feed_post\/wordpress_settings","auto_feed_post\/youtube_settings","gmb\/posts","gmb\/media_campaigns","gmb\/rss","marketing\/get_interest","search_tools\/comparision","instagram_reply\/hashTag_search","social_accounts\/index"]', true);
    }

    public function custom_domain_save()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        if ($_POST) {

            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('custom_id', '<b>' . $this->lang->line("custom_id") . '</b>', 'trim');
            $this->form_validation->set_rules('eco_custom_domain', '<b>' . $this->lang->line("You can connect your own domain to an ecommerce store. Enter the domain name below without http, www.") . '</b>', 'trim');
            $this->form_validation->set_rules('eco_custom_domain_new', '<b>' . $this->lang->line("You can connect your own domain to an ecommerce store. Enter the domain name below without http, www.") . '</b>', 'trim');

            $post = $this->input->post();

            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->custom_domain();
            } else {
                // assign
                $eco_custom_domain = addslashes(strip_tags($this->input->post('eco_custom_domain', true)));
                $eco_custom_domain_new = addslashes(strip_tags($this->input->post('eco_custom_domain_new', true)));
                $eco_custom_domain_current = addslashes(strip_tags($this->input->post('eco_custom_domain_current', true)));

                if (!empty($eco_custom_domain_current)) {
                    $eco_custom_domain = $eco_custom_domain_current;
                }

                if (empty($eco_custom_domain)) {
                    $this->session->set_flashdata('error_message', 1);
                    redirect('n_theme/custom_domain', 'location');
                }

                if (!empty($eco_custom_domain_new)) {
                    $eco_custom_domain_delete = $eco_custom_domain;
                    $eco_custom_domain = $eco_custom_domain_new;
                }

                $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));

                if (!isset($xdata[0])) {
                    $this->session->set_flashdata('error_message', 1);
                    redirect('n_theme/custom_domain', 'location');
                }


                if ($eco_custom_domain != 'delete' and $eco_custom_domain != 'DELETE') {

                    $c_data = $this->basic->get_data("n_custom_domain", array(
                        "where" => array(
                            "host_url" => $eco_custom_domain
                        )
                    ));

                    if (isset($c_data[0])) {
                        $this->session->set_flashdata('error_message', 1);
                        redirect('n_theme/custom_domain', 'location');
                    }

                    $insert_data = array(
                        'host_url' => $eco_custom_domain,
                        'active' => 0,
                        'module' => 1, //1 - ecommerce
                        'user_id' => $this->user_id,
                        'pwa_active' => 0,
                        'custom_id' => $post['custom_id'],
                        'sitemap' => 0,
                    );

                    $rdb = $this->db->insert("n_custom_domain", $insert_data);
                }

                if (!empty($eco_custom_domain_delete)) {
                    $update_data = array(
                        'active' => '2'
                    );
                    $this->basic->update_data('n_custom_domain', array('host_url' => $eco_custom_domain_delete, 'user_id' => $this->user_id), $update_data);
                }

                if ($this->session->userdata('license_type') == 'double') {
                    $tc = array();
                    $tc['ticket_title'] = 'New custom domain for activate';
                    $tc['ticket_text'] = 'Custom domain to activate: ' . $post['eco_custom_domain'];
                    $tc['user_id'] = $this->user_id;
                    $tc['support_category'] = 2;
                    $tc['ticket_open_time'] = date("Y-m-d H:i:s");
                    $this->basic->insert_data('fb_simple_support_desk', $tc);
                }


            }
            $this->session->set_flashdata('success_message', 1);
            redirect('n_theme/custom_domain', 'location');
        }
    }

    public function custom_domain_pwa_save()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));

        if (!isset($xdata[0])) {
            $this->session->set_flashdata('error_message', 1);
            redirect('n_theme/custom_domain', 'location');
        }

        $shop_id = $xdata[0]['store_unique_id'];
        $s_id = $xdata[0]['id'];

        if ($_POST) {

            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('pwa_on', '<b>' . $this->lang->line("PWA On / Off") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_name', '<b>' . $this->lang->line("PWA app name") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_short_name', '<b>' . $this->lang->line("PWA app short name") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_description', '<b>' . $this->lang->line("PWA app description") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_theme_color', '<b>' . $this->lang->line("PWA theme color") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_background_color', '<b>' . $this->lang->line("PWA background color") . '</b>', 'trim');

            $this->form_validation->set_rules('pwa_apple_status_bar', '<b>' . $this->lang->line("apple-mobile-web-app-status-bar-style") . '</b>', 'trim');


            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->custom_domain();
            } else {
                // assign
                $base_path = realpath(APPPATH . '../upload/ecommerce');

                include(APPPATH . 'n_views/default_ecommerce_builder.php');
                if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php')) {
                    include(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php');
                }

                $pwa_on = addslashes(strip_tags($this->input->post('pwa_on', true)));
                $pwa_name = addslashes(strip_tags($this->input->post('pwa_name', true)));
                $pwa_short_name = addslashes(strip_tags($this->input->post('pwa_short_name', true)));
                $pwa_description = addslashes(strip_tags($this->input->post('pwa_description', true)));

                $pwa_theme_color = addslashes(strip_tags($this->input->post('pwa_theme_color', true)));
                $pwa_background_color = addslashes(strip_tags($this->input->post('pwa_background_color', true)));

                $pwa_apple_status_bar = addslashes(strip_tags($this->input->post('pwa_apple_status_bar', true)));

                $ios_splash = array('ipad_splash', 'ipadpro1_splash', 'ipadpro2_splash', 'ipadpro3_splash', 'iphone5_splash', 'iphone6_splash', 'iphoneplus_splash', 'iphonex_splash', 'iphonexr_splash', 'iphonexsmax_splash', '8_3__iPad_Mini_portrait', '10_2__iPad_portrait', '10_9__iPad_Air_portrait', 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait', 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait', 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait', '8.3__iPad_Mini_landscape', '9_7__iPad_Pro__7_9__iPad_mini__9_7__iPad_Air__9_7__iPad_landscape', '10_2__iPad_landscape', '10_5__iPad_Air_landscape', '10_9__iPad_Air_landscape', '11__iPad_Pro__10_5__iPad_Pro_landscape', '12_9__iPad_Pro_landscape', '4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape', 'iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4_7__iPhone_SE_landscape', 'iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape', 'iPhone_11__iPhone_XR_landscape', 'iPhone_11_Pro_Max__iPhone_XS_Max_landscape', 'iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape', 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape', 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape', 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape', 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape');

                $splash = array();
                foreach ($ios_splash as $k) {
                    $splash[$k] = '';
                    if (!empty($n_eco_builder_config[$k])) {
                        $splash[$k] = $n_eco_builder_config[$k];
                    }
                    if ($_FILES[$k]['size'] != 0) {
                        $photo = $s_id . '_' . $k . ".png";

                        $config = array(
                            "allowed_types" => "png",
                            "upload_path" => $base_path,
                            "overwrite" => true,
                            "file_name" => $photo,
                            'max_size' => 5 * 1024 * 1024,
                            'max_width' => '3000',
                            'max_height' => '3000'
                        );
                        $this->upload->initialize($config);
                        $this->load->library('upload', $config);


                        if (!$this->upload->do_upload($k)) {
                            $this->session->set_userdata($k, $this->upload->display_errors());
//                            var_dump($this->upload->display_errors());
//                            exit;
                            return $this->custom_domain();
                        }
                        $splash[$k] = '/upload/ecommerce/' . $s_id . '_' . $k . '.png';

                    }
                }

                $pwa_icon_512 = '';
                if (!empty($n_eco_builder_config['pwa_icon_512'])) {
                    $pwa_icon_512 = $n_eco_builder_config['pwa_icon_512'];
                }
                if ($_FILES['pwa_icon_512']['size'] != 0) {
                    $photo = $s_id . '_' . "pwa_icon_512.png";
                    $config = array(
                        "allowed_types" => "png",
                        "upload_path" => $base_path,
                        "overwrite" => true,
                        "file_name" => $photo,
                        'max_size' => 5 * 1024 * 1024,
                        'max_width' => '512',
                        'max_height' => '512'
                    );
                    $this->upload->initialize($config);
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('pwa_icon_512')) {
                        $this->session->set_userdata('pwa_icon_512', $this->upload->display_errors());
                        return $this->settings();
                    }
                    $pwa_icon_512 = '/upload/ecommerce/' . $s_id . '_pwa_icon_512.png';
                }


                $n_eco_builder_config['pwa_on'] = $pwa_on;
                $n_eco_builder_config['pwa_name'] = $pwa_name;
                $n_eco_builder_config['pwa_short_name'] = $pwa_short_name;
                $n_eco_builder_config['pwa_description'] = $pwa_description;
                $n_eco_builder_config['pwa_theme_color'] = $pwa_theme_color;
                $n_eco_builder_config['pwa_background_color'] = $pwa_background_color;
                $n_eco_builder_config['pwa_icon_512'] = $pwa_icon_512;
                $n_eco_builder_config['pwa_apple_status_bar'] = $pwa_apple_status_bar;

                foreach ($splash as $k => $v) {
                    $n_eco_builder_config[$k] = $v;
                }


                $n_new = "<?php \n";
                foreach ($n_eco_builder_config as $k => $v) {
                    if (isset($arr_n[$k])) {
                        $v = $arr_n[$k];
                    }
                    $n_new .= "\$n_eco_builder_config['" . $k . "'] = '$v';\n";
                }
                file_put_contents(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php', $n_new, LOCK_EX);

                if ($pwa_on == 'true') {
                    $json_icons_arr = '';
                    $size = array(384, 192, 180, 152, 144, 128, 120, 96, 76, 72);
                    if (file_exists(FCPATH . '/upload/ecommerce/' . $s_id . '_pwa_icon_512.png')) {
                        foreach ($size as $k) {
                            $img = $this->resize_image(FCPATH . '/upload/ecommerce/' . $s_id . '_pwa_icon_512.png', $k, $k);
                            imagepng($img, FCPATH . '/upload/ecommerce/' . $s_id . '_pwa_icon_' . $k . '.png');
                            $json_icons_arr .= ',
                            {
                                "src": "/upload/ecommerce/' . $s_id . '_pwa_icon_' . $k . '.png",
                                "sizes": "' . $k . 'x' . $k . '",
                                "type": "image/png"
                            }';
                        }
                    } else {
                        $pwa_icon_512 = '';
                    }

                    $n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
                        "custom_id" => $this->session->userdata("ecommerce_selected_store"),
                        "user_id" => $this->user_id
                    )
                    ));

                    if (empty($n_cd_data)) {
                        $host_url = base_url();
                    } else {
                        $host_url = $n_cd_data[0]['host_url'];
                    }

                    $simple_manifest_json = '{
                    "name": "' . $pwa_name . '",
                    "short_name": "' . $pwa_short_name . '",
                    "description": "' . $pwa_description . '",
                    "orientation": "portrait",
                    "start_url": "/?utm_source=pwa_homescreen",
                    "display": "standalone",
                    "theme_color": "' . $pwa_theme_color . '",
                    "background_color": "' . $pwa_background_color . '",
                    "related_applications": [{
						"platform": "webapp",
						"url": "/' . $s_id . '_manifest.json"
					}],
                    "icons": [
                        {
                            "src": "' . $pwa_icon_512 . '",
                            "sizes": "512x512",
                            "type": "image/png"
                        }' . $json_icons_arr . '
                    ]
                }';

                    file_put_contents(FCPATH . $s_id . '_manifest.json', $simple_manifest_json, LOCK_EX);

                    if (!file_exists(FCPATH . 'serviceworker.js')) {
                        $serviceworker = "self.addEventListener('install', event => {

});

self.addEventListener('activate', event => {

});

self.addEventListener('fetch', event => {

});";


                        file_put_contents(FCPATH . 'serviceworker.js', $serviceworker, LOCK_EX);
                    }

                }


            }
            $this->session->set_flashdata('success_message', 1);
            redirect('n_theme/custom_domain', 'location');
        }
    }

    public function custom_domain_webhook_save()
    {
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        if ($_POST) {

            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('custom_id', '<b>' . $this->lang->line("custom_id") . '</b>', 'trim');
            //$this->form_validation->set_rules('wh_domain', '<b>' . $this->lang->line("Domain for receive webhook") . '</b>', 'trim');
            $this->form_validation->set_rules('send_all_orders', '<b>' . $this->lang->line("send_all_orders") . '</b>', 'trim');
            $this->form_validation->set_rules('send_all_products', '<b>' . $this->lang->line("send_all_products") . '</b>', 'trim');

            $post = $this->input->post();

            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->custom_domain();
            } else {
                // assign
                $custom_id = addslashes(strip_tags($this->input->post('custom_id', true)));
                $wh_domain = $this->input->post('wh_domain');
                $send_all_orders = addslashes(strip_tags($this->input->post('send_all_orders', true)));
                $send_all_products = addslashes(strip_tags($this->input->post('send_all_products', true)));


                if (empty($wh_domain)) {
                    $this->session->set_flashdata('error_message', 1);
                    redirect('n_theme/custom_domain', 'location');
                }

                $this->load->helper('url');
                foreach ($wh_domain as $whk => $whv) {
                    if (!empty($whv) AND !filter_var($whv, FILTER_VALIDATE_URL)) {
                        $this->session->set_flashdata('error_message', 1);
                        redirect('n_theme/custom_domain', 'location');
                    }
                }



                $wh_domain_db = implode(',', $wh_domain);


                $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("id" => $this->session->userdata("ecommerce_selected_store"), "user_id" => $this->user_id)));

                if (!isset($xdata[0])) {
                    $this->session->set_flashdata('error_message', 1);
                    redirect('n_theme/custom_domain', 'location');
                }

                $whdata = $this->basic->get_data("n_webhook", array("where" => array("store_id" => $xdata[0]['id'], "user_id" => $this->user_id)));

                if (empty($whdata[0])) {
                    $insert_data = array(
                        'store_id' => $xdata[0]['id'],
                        'user_id' => $this->user_id,
                        'order_wh' => $send_all_orders,
                        'product_wh' => $send_all_products,
                        'domains' => $wh_domain_db
                    );

                    $rdb = $this->db->insert("n_webhook", $insert_data);
                } else {

                    $update_data = array(
                        'store_id' => $xdata[0]['id'],
                        'user_id' => $this->user_id,
                        'order_wh' => $send_all_orders,
                        'product_wh' => $send_all_products,
                        'domains' => $wh_domain_db
                    );

                    $rdb = $this->basic->update_data("n_webhook", array('id' => $whdata[0]['id']), $update_data);

                }

                if (!empty($send_all_orders) and $send_all_orders == '1') {
                    $send_all_orders = 0;
                } else {
                    $send_all_orders = 2;
                }
                $this->basic->update_data("ecommerce_cart", array('store_id' => $xdata[0]['id'], 'action_type !=' => 'add'), array('n_wh' => $send_all_orders));

                if (!empty($send_all_products) and $send_all_products == '1') {
                    $send_all_products = 0;
                } else {
                    $send_all_products = 2;
                }
                $this->basic->update_data("ecommerce_product", array('store_id' => $xdata[0]['id']), array('n_wh' => $send_all_products));


            }
            $this->session->set_flashdata('success_message', 1);
            redirect('n_theme/custom_domain', 'location');
        }
    }

    public function upload_assets($type_upload = 'ecommerce')
    {

        // Kicks out if not a ajax request
        // $this->ajax_check();

        if ($type_upload == 'ecommerce') {
            $upload_dir = FCPATH . 'upload/ecommerce/' . $this->user_id;
            $upload_prefix = 'upload/ecommerce/' . $this->user_id;
        } else {
            $upload_dir = FCPATH . 'upload/assets';
            $upload_prefix = 'upload/assets';
        }

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $resultArray = array();
        foreach ($_FILES as $file) {
            $fileName = $file['name'];
            $tmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            if ($file['error'] != UPLOAD_ERR_OK) {
                error_log($file['error']);
                echo json_encode(['error' => $file['error']]);
                exit;
            }


            if ($fileSize > 5 * 1024 * 1024) {
                $message = $this->lang->line('The file size exceeds the limit. Please remove the file and upload again.');
                echo json_encode(['error' => $message]);
                exit;
            }


            $post_fileName = $fileName;
            $post_fileName_array = explode('.', $post_fileName);
            $ext = array_pop($post_fileName_array);

            $new_filename = str_replace('.' . $ext, '', $post_fileName);

            //$filename = implode('.', $post_fileName_array);
            $filename = strtolower(strip_tags(str_replace(' ', '-', $post_fileName)));
            $filename = $new_filename . '_' . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

            $allow_ext = ['png', 'jpg', 'jpeg'];
            if (!in_array(strtolower($ext), $allow_ext)) {
                $message = $this->lang->line('Invalid file type');
                echo json_encode(['error' => $message]);
                exit;
            }

            $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
            if (!@move_uploaded_file($tmpName, $dest_file)) {
                $message = $this->lang->line('That was not a valid upload file.');
                echo json_encode(['error' => $message]);
                exit;
            }

            $result = array(
                'name' => $file['name'],
                'type' => 'image',
                'src' => base_url($upload_prefix . '/' . $filename),
//                'height'=>350,
//                'width'=>250
            );
            // we can also add code to save images in database here.
            array_push($resultArray, $result);
        }
        $response = array('data' => $resultArray);
        echo json_encode($response);
    }


    public function builder_restore_default_settings($shop_id)
    {
        if ($this->session->userdata('logged_in') != 1) exit();
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        //$this->session->userdata("ecommerce_selected_store") //171616942658 ///"user_id" => $this->user_id
        $xdata = $this->basic->get_data("ecommerce_store", array("where" => array("store_unique_id" => $shop_id)));
        if (!isset($xdata[0])) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line("something went wrong, please try once again.")));
            return;
        }


        if ($_POST) {

            $this->csrf_token_check();

            if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php')) {
                unlink(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php');
            }

            $language_info = $this->_language_list();
            ksort($language_info);
            foreach ($language_info as $key_lang => $value_lang) {
                if (file_exists(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p' . strtolower($key_lang) . '.php')) {
                    unlink(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p' . strtolower($key_lang) . '.php');
                }
                if (file_exists(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p' . strtolower($key_lang) . '.php')) {
                    unlink(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p' . strtolower($key_lang) . '.php');
                }
                if (file_exists(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p' . strtolower($key_lang) . '.php')) {
                    unlink(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p' . strtolower($key_lang) . '.php');
                }
            }

            if (file_exists(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p.php')) {
                unlink(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p.php');
            }
            if (file_exists(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p.php')) {
                unlink(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p.php');
            }
            if (file_exists(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p.php')) {
                unlink(APPPATH . '/n_eco_user/builder/home_page_' . $shop_id . '_p.php');
            }

            echo json_encode(array('status' => '1', 'message' => $this->lang->line("Settings restored")));
        }
    }

    public function dashboard($default_value = '0')
    {
        $this->member_validity();
        $this->is_broadcaster_exist = $this->broadcaster_exist();
        if ($this->session->userdata('user_type') != 'Admin') $default_value = '0';
        if ($default_value == '0') {
            $user_id = $this->user_id;
            $data['other_dashboard'] = '0';
        } else {
            $user_id = $default_value;
            if ($default_value == 'system')
                $data['system_dashboard'] = 'yes';
            else {
                $user_info = $this->basic->get_data('users', array('where' => array('id' => $user_id)));
                $data['user_name'] = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
                $data['user_email'] = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
                $data['system_dashboard'] = 'no';
            }

            $data['other_dashboard'] = '1';
        }

        if ($this->is_demo === '1' && $data['other_dashboard'] === '1' && isset($data['system_dashboard']) && $data['system_dashboard'] === 'no') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }


        $current_year = date("Y");
        $lastyear = $current_year - 1;
        $current_month = date("Y-m");
        $current_date = date("Y-m-d");
        $data['month_number'] = date('m');

        // first item section
        $total_subscribers = 0;
        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'YEAR(subscribed_at)'  => date("Y"),
                'permission' => '1'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $select = array('count(id) as subscribers');
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select);
        $subscribed = isset($subscriber_info[0]['subscribers']) ? $subscriber_info[0]['subscribers'] : 0;
        $data['subscribed'] = $subscribed;

        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'YEAR(subscribed_at)'  => date("Y"),
                'MONTH(unsubscribed_at)' => date("m"),
                'permission' => '0'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $select = array('count(id) as unsubscribers');
        $unsubscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select);
        $unsubscribed = isset($unsubscriber_info[0]['unsubscribers']) ? $unsubscriber_info[0]['unsubscribers'] : 0;
        $data['unsubscribed'] = $unsubscribed;

        $total_subscribers = $subscribed + $unsubscribed;
        $data['total_subscribers'] = $total_subscribers;

        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'YEAR(subscribed_at)'  => date("Y"),
                'MONTH(unsubscribed_at)' => date("m")
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $select = array('sum(successfully_sent) as total_message_sent');
        $conversation_message_sent_info = $this->basic->get_data("facebook_ex_conversation_campaign", $where, $select);
        $total_conversion_message_sent = isset($conversation_message_sent_info[0]['total_message_sent']) ? $conversation_message_sent_info[0]['total_message_sent'] : 0;

        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'YEAR(subscribed_at)'  => date("Y"),
                'MONTH(unsubscribed_at)' => date("m")
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        if ($this->is_broadcaster_exist) {
            $select = array('sum(successfully_sent) as total_message_sent');
            $broadcast_message_sent_info = $this->basic->get_data("messenger_bot_broadcast_serial", $where, $select);
        }
        $total_broadcast_message_sent = isset($broadcast_message_sent_info[0]['total_message_sent']) ? $broadcast_message_sent_info[0]['total_message_sent'] : 0;
        $data['total_message_sent'] = $total_conversion_message_sent + $total_broadcast_message_sent;

        // end of first item section


        // second item section [last 7 days subscribers]
        $last_seven_day = date("Y-m-d", strtotime("$current_date - 7 days"));
        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'subscribed_at >=' => 'DATE_SUB(NOW(), INTERVAL 7 DAY)'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $select = array('count(id) as subscribers', 'DATE(subscribed_at) as subscribed_at');
        $seven_days_subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', 'DATE(subscribed_at) asc', 'DATE(subscribed_at)');
        $seven_days_subscriber_chart_label = array();
        $seven_days_subscriber_chart_data = array();
        $seven_days_subscriber_gain = 0;
        if (!empty($seven_days_subscriber_info)) {
            foreach ($seven_days_subscriber_info as $value) {
                array_push($seven_days_subscriber_chart_label, date("jS M y", strtotime($value['subscribed_at'])));
                array_push($seven_days_subscriber_chart_data, $value['subscribers']);
                $seven_days_subscriber_gain = $seven_days_subscriber_gain + $value['subscribers'];
            }
        }
        $data['seven_days_subscriber_chart_label'] = $seven_days_subscriber_chart_label;
        $data['seven_days_subscriber_chart_data'] = $seven_days_subscriber_chart_data;
        $data['seven_days_subscriber_gain'] = $seven_days_subscriber_gain;
        // end of second item section

        // third item section [24 hour interaction]
        $current_time = new DateTime();
        $yesterday = $current_time->modify('-1 day')->format('Y-m-d H:i:s');
        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'last_subscriber_interaction_time >=' => $yesterday
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $select = array('count(id) as subscribers', 'date_format(last_subscriber_interaction_time,"%Y-%m-%d %H:%i") as subscribed_at');
        $hourly_subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', 'date_format(last_subscriber_interaction_time,"%Y-%m-%d %H") asc', 'date_format(last_subscriber_interaction_time,"%Y-%m-%d %H")');
        $hourly_subscriber_chart_label = array();
        $hourly_subscriber_chart_data = array();
        $hourly_subscriber_gain = 0;
        if (!empty($hourly_subscriber_info)) {
            foreach ($hourly_subscriber_info as $value) {
                array_push($hourly_subscriber_chart_label, date("h A", strtotime($value['subscribed_at'])));
                array_push($hourly_subscriber_chart_data, $value['subscribers']);
                $hourly_subscriber_gain = $hourly_subscriber_gain + $value['subscribers'];
            }
        }
        $data['hourly_subscriber_chart_label'] = $hourly_subscriber_chart_label;
        $data['hourly_subscriber_chart_data'] = $hourly_subscriber_chart_data;
        $data['hourly_subscriber_gain'] = $hourly_subscriber_gain;
        // end of third item section

        // forth item section [male vs female subscriber]
        $male_list = array();
        $female_list = array();
        $male_female_date_list = array();
        $past_thirty_day = date("Y-m-d", strtotime($current_date . " -30 days"));
        $where = array(
            'where' => array(
                'subscribed_at >=' => $past_thirty_day,
                'is_bot_subscriber' => '1'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $select = array(
            'date(subscribed_at) as subscribed_at',
            'sum(case when gender = "male" then 1 else 0 end) as male_subscribers',
            'sum(case when gender = "female" then 1 else 0 end) as female_subscribers'
        );
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', 'subscribed_at asc', 'subscribed_at');

        $male_list = array();
        $female_list = array();
        $male_female_date_list = array();
        foreach ($subscriber_info as $value) {
            $male_list[$value['subscribed_at']] = $value['male_subscribers'];
            $female_list[$value['subscribed_at']] = $value['female_subscribers'];

            $formated_date = date("jS M", strtotime($value['subscribed_at']));
            $male_female_date_list[$value['subscribed_at']] = $formated_date;
        }

        $largest_values = array();
        $max_value = 1;
        if (!empty($male_list)) array_push($largest_values, max($male_list));
        if (!empty($female_list)) array_push($largest_values, max($female_list));
        if (!empty($largest_values)) $max_value = max($largest_values);
        if ($max_value > 10) $data['step_size'] = floor($max_value / 10);
        else $data['step_size'] = 1;

        $data['male_subscribers'] = $male_list;
        $data['female_subscribers'] = $female_list;
        $data['male_female_date_list'] = $male_female_date_list;
        // end of forth item section [male vs female subscriber]

        // fifth item section [email,phone,birthdate,locale gain]

        $where = array(
            'where' => array(
                'permission' => '1'
            ),
            'where_greater_than'=>array(
                'subscribed_at' => date('Y-m-01 00:00:00', strtotime($current_month))
            ),
            'where_less_than'=>array(
                'subscribed_at' => date('Y-m-t 23:59:59', strtotime($current_month))
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;

        $select = array(
            'SUM(CASE WHEN gender = "male" AND email != "" THEN 1 ELSE 0 END) as email_male',
            'SUM(CASE WHEN gender = "female" AND email != "" THEN 1 ELSE 0 END) as email_female',
            'SUM(CASE WHEN gender = "male" AND phone_number != "" THEN 1 ELSE 0 END) as phone_male',
            'SUM(CASE WHEN gender = "female" AND phone_number != "" THEN 1 ELSE 0 END) as phone_female',
            'SUM(CASE WHEN gender = "male" THEN 1 ELSE 0 END) as birthdate_male',
            'SUM(CASE WHEN gender = "female" THEN 1 ELSE 0 END) as birthdate_female'
        );

        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select)[0];

        $combined_info = array(
            'email' => array(
                'male' => $subscriber_info['email_male'],
                'female' => $subscriber_info['email_female'],
                'total_email_gain' => $subscriber_info['email_male'] + $subscriber_info['email_female']
            ),
            'phone' => array(
                'male' => $subscriber_info['phone_male'],
                'female' => $subscriber_info['phone_female'],
                'total_phone_gain' => $subscriber_info['phone_male'] + $subscriber_info['phone_female']
            ),
            'birthdate' => array(
                'male' => $subscriber_info['birthdate_male'],
                'female' => $subscriber_info['birthdate_female'],
                'total_birthdate_gain' => $subscriber_info['birthdate_male'] + $subscriber_info['birthdate_female']
            )
        );

        foreach ($combined_info as $key => $value) {
            $percentage_info = $this->get_percentage($value['male'], $value['female']);
            $combined_info[$key]['male_percentage'] = $percentage_info[0];
            $combined_info[$key]['female_percentage'] = $percentage_info[1];
        }


        $data['combined_info'] = $combined_info;
        // end of fifth item section [email,phone,birthdate,locale gain]

        // sixth item section [latest subscribers]
        $page_list = array();
        $latest_subscriber_list = array();
        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'permission' => '1',
                'is_bot_subscriber' => '1'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $latest_subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, '', '', 6, '', 'subscribed_at desc');

        $where = array(
            'where' => array()
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $page_info = $this->basic->get_data('facebook_rx_fb_page_info', $where, array('id', 'page_name', 'page_id'));
        foreach ($page_info as $value) {
            $page_list[$value['id']]['page_name'] = $value['page_name'];
            $page_list[$value['id']]['page_id'] = $value['page_id'];
        }
        $i = 0;
        foreach ($latest_subscriber_info as $value) {
            $latest_subscriber_list[$i]['first_name'] = $value['first_name'];
            $latest_subscriber_list[$i]['last_name'] = $value['last_name'];
            $latest_subscriber_list[$i]['full_name'] = $value['full_name'];
            if ($value['link'] == '')
                $latest_subscriber_list[$i]['link'] = 'disabled';
            else
                $latest_subscriber_list[$i]['link'] = $value['link'];

            $latest_subscriber_list[$i]['subscribed_at'] = date_time_calculator($value['subscribed_at'], true);
            $latest_subscriber_list[$i]['subscribe_id'] = $value['subscribe_id'];
            $latest_subscriber_list[$i]['page_name'] = $page_list[$value['page_table_id']]['page_name'];
            $latest_subscriber_list[$i]['page_id'] = $page_list[$value['page_table_id']]['page_id'];

            $profile_pic = ($value['profile_pic'] != "") ? $value["profile_pic"] : base_url('assets/img/avatar/avatar-1.png');
            $latest_subscriber_list[$i]['image_path'] = ($value["image_path"] != "") ? base_url($value["image_path"]) : $profile_pic;

            $i++;
        }
        $data['latest_subscriber_list'] = $latest_subscriber_list;
        // end sixth item section [latest subscribers]


        // item section [latest 24h subscribers]
        $current_time = date("Y-m-d H:i:s");
        $yesterday = date("Y-m-d H:i:s", strtotime($current_time . " -1 day"));
        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                'last_subscriber_interaction_time >=' => $yesterday
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $latest_24hsubscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, '', '', 6, '', 'last_subscriber_interaction_time desc');

        $i = 0;
        $latest_24hsubscriber_list = array();
        foreach ($latest_24hsubscriber_info as $value) {
            $latest_24hsubscriber_list[$i]['first_name'] = $value['first_name'];
            $latest_24hsubscriber_list[$i]['last_name'] = $value['last_name'];
            $latest_24hsubscriber_list[$i]['full_name'] = $value['full_name'];
            $latest_24hsubscriber_list[$i]['link'] = $value['link'];
            $latest_24hsubscriber_list[$i]['last_subscriber_interaction_time'] = date_time_calculator($value['last_subscriber_interaction_time'], true);
            $latest_24hsubscriber_list[$i]['subscribe_id'] = $value['subscribe_id'];
            $latest_24hsubscriber_list[$i]['page_name'] = $page_list[$value['page_table_id']]['page_name'];
            $latest_24hsubscriber_list[$i]['page_id'] = $page_list[$value['page_table_id']]['page_id'];

            $profile_pic = ($value['profile_pic'] != "") ? $value["profile_pic"] : base_url('assets/img/avatar/avatar-1.png');
            $latest_24hsubscriber_list[$i]['image_path'] = ($value["image_path"] != "") ? base_url($value["image_path"]) : $profile_pic;

            $i++;
        }
        $data['latest_24hsubscriber_list'] = $latest_24hsubscriber_list;
        // end item section [latest 24h subscribers]

        // seventh item section [top sources of subscribers]
        $refferer_source_info = array();
        $refferer_source_info['checkbox_plugin']['title'] = $this->lang->line("Checkbox Plugin");
        $refferer_source_info['customer_chat_plugin']['title'] = $this->lang->line("Customer Chat Plugin");
        $refferer_source_info['sent_to_messenger']['title'] = $this->lang->line("Sent to Messenger Plugin");
        $refferer_source_info['me_link']['title'] = $this->lang->line("m.me Link");
        $refferer_source_info['direct']['title'] = $this->lang->line("Direct From Facebook");
        $refferer_source_info['direct']['subscribers'] = 0;
        $refferer_source_info['comment_private_reply']['title'] = $this->lang->line("Comment Private Reply");
        $where = array(
            'where' => array(
                // 'user_id' => $user_id,
                // 'date_format(subscribed_at,"%Y-%m")' => $current_month,
                'permission' => '1'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $select = array('count(id) as subscribers', 'refferer_source');
        $subscriber_refferer_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', '', 'refferer_source');

        $refferer_source_mapping = [
            'checkbox_plugin' => 'checkbox_plugin',
            'CUSTOMER_CHAT_PLUGIN' => 'customer_chat_plugin',
            'SEND-TO-MESSENGER-PLUGIN' => 'sent_to_messenger',
            'SHORTLINK' => 'me_link',
            'FB PAGE' => 'direct',
            '' => 'direct',
            'COMMENT PRIVATE REPLY' => 'comment_private_reply'
        ];

        foreach ($subscriber_refferer_info as $value) {
            $source = $refferer_source_mapping[$value['refferer_source']] ?? null;
            if ($source) {
                if ($source == 'direct') {
                    $refferer_source_info[$source]['subscribers'] += $value['subscribers'];
                } else {
                    $refferer_source_info[$source]['subscribers'] = $value['subscribers'];
                }
            }
        }
        $data['refferer_source_info'] = $refferer_source_info;
        // end of seventh item section [top sources of subscribers]


        // last auto reply report section
        $where = array(
            'where' => array()
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $last_auto_reply_post_info = $this->basic->get_data('facebook_ex_autoreply_report', $where, $select = '', $join = '', $limit = '6', $start = NULL, 'reply_time DESC');

        $data['my_last_auto_reply_data'] = $last_auto_reply_post_info;
        // end of last auto reply report section


        // upcoming facebook poster campaign section
        $where = array(
            'where' => array(
                'posting_status' => '0'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $scheduled_auto_post_campaign = $this->basic->get_data('facebook_rx_auto_post', $where, $select = '', $join = '', $limit = 5, $start = NULL, 'schedule_time ASC');
        $where = array(
            'where' => array(
                'posting_status' => '0'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $scheduled_cta_post_campaign = $this->basic->get_data('facebook_rx_cta_post', $where, $select = '', $join = '', $limit = 5, $start = NULL, 'schedule_time ASC');
        $where = array(
            'where' => array(
                'posting_status' => '0'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $scheduled_carousel_slider_campaign = $this->basic->get_data('facebook_rx_slider_post', $where, $select = '', $join = '', $limit = 5, $start = NULL, 'schedule_time ASC');

        $upcoming_post_campaign_array = array();

        foreach ($scheduled_auto_post_campaign as $value)
            $upcoming_post_campaign_array[] = $value;
        foreach ($scheduled_cta_post_campaign as $value)
            $upcoming_post_campaign_array[] = $value;
        foreach ($scheduled_carousel_slider_campaign as $value)
            $upcoming_post_campaign_array[] = $value;

        usort($upcoming_post_campaign_array, function ($a, $b) {
            if ($a['schedule_time'] == $b['schedule_time'])
                return 0;
            else if ($a['schedule_time'] > $b['schedule_time'])
                return 1;
            else
                return -1;
        });
        $data['upcoming_post_campaign_array'] = $upcoming_post_campaign_array;
        // end of upcoming facebook poster campaign section

        // recently completed facebook poster campaign
        $where = array(
            'where' => array(
                'posting_status' => '2'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $all_time_auto_post = $this->basic->get_data('facebook_rx_auto_post', $where, $select = '', $join = '', $limit = 5, $start = NULL, 'last_updated_at DESC');
        $where = array(
            'where' => array(
                'posting_status' => '2'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $all_time_cta_post = $this->basic->get_data('facebook_rx_cta_post', $where, $select = '', $join = '', $limit = 5, $start = NULL, 'last_updated_at DESC');
        $where = array(
            'where' => array(
                'posting_status' => '2'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $all_time_slider_post = $this->basic->get_data('facebook_rx_slider_post', $where, $select = '', $join = '', $limit = 5, $start = NULL, 'last_updated_at DESC');

        $recently_completed_post_array = array();
        foreach ($all_time_auto_post as $value)
            $recently_completed_post_array[] = $value;
        foreach ($all_time_cta_post as $value)
            $recently_completed_post_array[] = $value;
        foreach ($all_time_slider_post as $value)
            $recently_completed_post_array[] = $value;
        usort($recently_completed_post_array, function ($a, $b) {
            if ($a['last_updated_at'] == $b['last_updated_at'])
                return 0;
            else if ($a['last_updated_at'] < $b['last_updated_at'])
                return 1;
            else
                return -1;
        });
        $data['recently_completed_post_array'] = $recently_completed_post_array;
        // end of recently completed facebook poster campaign

        $where = array(
            'where' => array(
                'posting_status' => '2'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        $recently_message_sent_completed_campaing_info = $this->basic->get_data('facebook_ex_conversation_campaign', $where, $select = '', $join = '', $limit = '5', $start = NULL, 'added_at DESC');

        $where = array(
            'where' => array(
                'posting_status' => '0'
            )
        );
        if ($default_value != 'system') $where['where']['user_id'] = $user_id;
        // $upcoming_message_sent_campaign_info = $this->basic->get_data('facebook_ex_conversation_campaign',$where,$select='',$join='',$limit='5',$start=NULL,'added_at DESC');

        $data['recently_message_sent_completed_campaing_info'] = $recently_message_sent_completed_campaing_info;
        // $data['upcoming_message_sent_campaign_info'] = $upcoming_message_sent_campaign_info;

        $data['body'] = 'dashboard/dashboard';
        $data['page_title'] = $this->lang->line('Dashboard');
        $this->_viewcontroller($data);
    }

    public function get_first_div_content($system_dashboard = 'no')
    {
        $this->ajax_check();
        $this->is_broadcaster_exist = $this->broadcaster_exist();
        $month_no = $this->input->post('month_no', true);
        if ($month_no == 'year')
            $search_year = date("Y");
        else
            $search_month = date("Y-{$month_no}");

        // first item section
        $total_subscribers = 0;
        $where_simple = array();
        if ($system_dashboard == 'no')
            $where_simple['user_id'] = $this->user_id;
        $where_simple['permission'] = '1';
        if ($month_no == 'year')
            $where_simple['YEAR(subscribed_at)'] = $search_year;
        else
            $where_simple['date_format(subscribed_at,"%Y-%m")'] = $search_month;

        $where = array(
            'where' => $where_simple
        );
        $select = array('count(id) as subscribers');
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select);

        $subscribed = isset($subscriber_info[0]['subscribers']) ? $subscriber_info[0]['subscribers'] : 0;

        $data['subscribed'] = custom_number_format($subscribed);

        $where_simple = array();
        if ($system_dashboard == 'no')
            $where_simple['user_id'] = $this->user_id;
        $where_simple['permission'] = '0';
        if ($month_no == 'year')
            $where_simple['YEAR(unsubscribed_at)'] = $search_year;
        else
            $where_simple['date_format(unsubscribed_at,"%Y-%m")'] = $search_month;
        $where = array(
            'where' => $where_simple
        );
        $select = array('count(id) as unsubscribers');
        $unsubscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select);
        $unsubscribed = isset($unsubscriber_info[0]['unsubscribers']) ? $unsubscriber_info[0]['unsubscribers'] : 0;


        $data['unsubscribed'] = custom_number_format($unsubscribed);
        $total_subscribers = $subscribed + $unsubscribed;
        $data['total_subscribers'] = custom_number_format($total_subscribers);

        $where_simple = array();
        if ($system_dashboard == 'no')
            $where_simple['user_id'] = $this->user_id;
        if ($month_no == 'year')
            $where_simple['YEAR(completed_at)'] = $search_year;
        else
            $where_simple['date_format(completed_at,"%Y-%m")'] = $search_month;
        $where = array(
            'where' => $where_simple
        );
        $select = array('sum(successfully_sent) as total_message_sent');
        $conversation_message_sent_info = $this->basic->get_data("facebook_ex_conversation_campaign", $where, $select);
        $total_conversion_message_sent = isset($conversation_message_sent_info[0]['total_message_sent']) ? $conversation_message_sent_info[0]['total_message_sent'] : 0;

        $where_simple = array();
        if ($system_dashboard == 'no')
            $where_simple['user_id'] = $this->user_id;
        if ($month_no == 'year')
            $where_simple['YEAR(completed_at)'] = $search_year;
        else
            $where_simple['date_format(completed_at,"%Y-%m")'] = $search_month;
        $where = array(
            'where' => $where_simple
        );
        $select = array('sum(successfully_sent) as total_message_sent');
        if ($this->is_broadcaster_exist) {
            $broadcast_message_sent_info = $this->basic->get_data("messenger_bot_broadcast_serial", $where, $select);
        }
        $total_broadcast_message_sent = isset($broadcast_message_sent_info[0]['total_message_sent']) ? $broadcast_message_sent_info[0]['total_message_sent'] : 0;
        $total_message_sent = $total_conversion_message_sent + $total_broadcast_message_sent;
        $data['total_message_sent'] = custom_number_format($total_message_sent);
        // end of first item section
        echo json_encode($data, true);
    }

    public function get_subscriber_data_div($system_dashboard = 'no')
    {
        $this->ajax_check();
        $period = $this->input->post('period', true);
        $today = date("Y-m-d");
        $last_seven_day = date("Y-m-d", strtotime("$today - 7 days"));
        $this_month = date("Y-m");
        $this_year = date("Y");

        // fifth item section [email,phone,birthdate,locale gain]

        // email section
        $where_simple = array();
        if ($system_dashboard == 'no')
            $where_simple['user_id'] = $this->user_id;

        if ($period == 'today')
            $where_simple['DATE(subscribed_at)'] = $today;
        else if ($period == 'week')
            $where_simple['DATE(subscribed_at) >='] = $last_seven_day;
        else if ($period == 'month')
            $where_simple['DATE(subscribed_at) ='] = $this_month;
        else if ($period == 'year')
            $where_simple['DATE(subscribed_at)'] = $this_year;

        $where_simple['permission'] = '1';
        $where_simple['email !='] = '';
        $where = array(
            'where' => $where_simple
        );
        $select = array('count(id) as subscribers', 'gender');
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', '', 'gender');
        $combined_info['email']['male'] = 0;
        $combined_info['email']['female'] = 0;
        foreach ($subscriber_info as $value) {
            if ($value['gender'] == 'male')
                $combined_info['email']['male'] = number_format($value['subscribers']);
            else
                $combined_info['email']['female'] = number_format($value['subscribers']);
        }
        $combined_info['email']['total_email_gain'] = number_format($combined_info['email']['male'] + $combined_info['email']['female']);
        $percentage_info = $this->get_percentage($combined_info['email']['male'], $combined_info['email']['female']);
        $combined_info['email']['male_percentage'] = $percentage_info[0] . '%';
        $combined_info['email']['female_percentage'] = $percentage_info[1] . '%';
        // end of email section

        // phone section
        $where_simple = array();
        if ($system_dashboard == 'no')
            $where_simple['user_id'] = $this->user_id;

        if ($period == 'today')
            $where_simple['DATE(subscribed_at)'] = $today;
        else if ($period == 'week')
            $where_simple['DATE(subscribed_at) >='] = $last_seven_day;
        else if ($period == 'month')
            $where_simple['date_format(subscribed_at,"%Y-%m")'] = $this_month;
        else if ($period == 'year')
            $where_simple['YEAR(subscribed_at)'] = $this_year;

        $where_simple['permission'] = '1';
        $where_simple['phone_number !='] = '';
        $where = array(
            'where' => $where_simple
        );
        $select = array('count(id) as subscribers', 'gender');
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', '', 'gender');
        $combined_info['phone']['male'] = 0;
        $combined_info['phone']['female'] = 0;
        foreach ($subscriber_info as $value) {
            if ($value['gender'] == 'male')
                $combined_info['phone']['male'] = number_format($value['subscribers']);
            else
                $combined_info['phone']['female'] = number_format($value['subscribers']);
        }
        $combined_info['phone']['total_phone_gain'] = number_format($combined_info['phone']['male'] + $combined_info['phone']['female']);
        $percentage_info = $this->get_percentage($combined_info['phone']['male'], $combined_info['phone']['female']);
        $combined_info['phone']['male_percentage'] = $percentage_info[0] . '%';
        $combined_info['phone']['female_percentage'] = $percentage_info[1] . '%';
        // end of phone section


        // birthdate section
        $where_simple = array();
        if ($system_dashboard == 'no')
            $where_simple['user_id'] = $this->user_id;
        if ($period == 'today')
            $where_simple['DATE(subscribed_at)'] = $today;
        else if ($period == 'week')
            $where_simple['DATE(subscribed_at) >='] = $last_seven_day;
        else if ($period == 'month')
            $where_simple['date_format(subscribed_at,"%Y-%m")'] = $this_month;
        else if ($period == 'year')
            $where_simple['YEAR(subscribed_at)'] = $this_year;
        $where_simple['permission'] = '1';
        $where = array(
            'where' => $where_simple
        );
        $select = array('count(id) as subscribers', 'gender');
        $subscriber_info = $this->basic->get_data('messenger_bot_subscriber', $where, $select, '', '', '', '', 'gender');
        $combined_info['birthdate']['male'] = 0;
        $combined_info['birthdate']['female'] = 0;
        foreach ($subscriber_info as $value) {
            if ($value['gender'] == 'male')
                $combined_info['birthdate']['male'] = number_format($value['subscribers']);
            else
                $combined_info['birthdate']['female'] = number_format($value['subscribers']);
        }
        $combined_info['birthdate']['total_birthdate_gain'] = number_format($combined_info['birthdate']['male'] + $combined_info['birthdate']['female']);
        $percentage_info = $this->get_percentage($combined_info['birthdate']['male'], $combined_info['birthdate']['female']);
        $combined_info['birthdate']['male_percentage'] = $percentage_info[0] . '%';
        $combined_info['birthdate']['female_percentage'] = $percentage_info[1] . '%';
        // end of birthdate section

        // end of fifth item section [email,phone,birthdate,locale gain]

        echo json_encode($combined_info, true);
    }


    public function get_percentage($first_number, $second_number)
    {
        if ($first_number == 0 && $second_number == 0)
            return [(float)0, (float)0];

        $total = (int)$first_number + (int)$second_number;

        $first_percent = ($first_number / $total) * 100;
        $second_percent = ($second_number / $total) * 100;

        return [(float)$first_percent, (float)$second_percent];
    }

    public function update_maxmind(){
        include(FCPATH . 'application/n_views/config.php');


        $client = new \tronovav\GeoIP2Update\Client(array(
            'license_key' => $n_config['dp_country_maxmind_db_key'],
            'dir' => APPPATH.'modules/n_theme/db',
            'editions' => array('GeoLite2-Country', 'GeoLite2-City'),
        ));
        $client->run();
        echo '<pre>';
        print_r($client->updated());
        print_r($client->errors());
        echo '</pre>';
    }

    public function test_maxmind(){

        $reader = new Reader(APPPATH.'modules/n_theme/db/GeoLite2-Country/GeoLite2-Country.mmdb');

        $record = $reader->country($_SERVER['REMOTE_ADDR']);

        echo '<pre>';
        print_r($record->country);
        echo '</pre>';

        $reader = new Reader(APPPATH.'modules/n_theme/db/GeoLite2-City/GeoLite2-City.mmdb');

        $record = $reader->city($_SERVER['REMOTE_ADDR']);

        echo '<pre>';
        print_r($record->city);
        echo '</pre>';
    }


    //////core
    public function activate()
    {
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
        ();

        //send blank array if you does not need sidebar entry,send a blank array if your addon does not need any sql to run
        $this->register_addon($addon_controller_name, $sidebar, $sql, $purchase_code);
    }

    public function deactivate()
    {
        echo json_encode(array('status' => '0', 'message' => $this->lang->line('For deactivate addon please use our NVX Addon Manager. Download: https://nvxgroup.com/addon-manager/')));
        exit();
    }

    public function delete()
    {
        $this->ajax_check();

        $addon_controller_name = ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        $add_inf = $this->get_addon_data(APPPATH . 'modules/' . $this->router->fetch_class() . '/controllers/' . $addon_controller_name . '.php');
        if ($add_inf['installed'] == 1) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Please first deactivate addon using our NVX Addon Manager. Download: https://nvxgroup.com/addon-manager/')));
            exit();
        }


        // mysql raw query needed to run, it is an array, put each query in a seperate index, drop table/column query should have IF EXISTS
        $sql = array
        (
            0 => "DELETE from `menu` where module_access = 3009",
        );

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