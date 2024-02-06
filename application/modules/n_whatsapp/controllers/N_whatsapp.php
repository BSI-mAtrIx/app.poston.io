<?php
/*
Addon Name: NVX Whatsapp Link Generator
Unique Name: nvx_whatsapp
Modules:
{
   "3007":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"0",
      "extra_text":"",
      "module_name":"Whatsapp Link Generator"
   }
}
Project ID: 1017
Addon URI: https://nvxgroup.com
Author: MD
Author URI: https://nvxgroup.com
Version: 1.54
Description: NVX Whatsapp Link Generator
*/


require_once("application/controllers/Home.php"); // loading home controller
class N_whatsapp extends Home
{
    public $key = "5E56671B1E7267CF";
    private $product_id = "5";
    private $product_base = "nvx_whatsapp";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 1.54;
    /* @var self */
    private static $selfobj = null;

    public $addon_data = array();

    public function __construct()
    {
        parent::__construct();
        //$this->load->config('page_response_config');// config
        // getting addon information in array and storing to public variable
        // addon_name,unique_name,module_id,addon_uri,author,author_uri,version,description,controller_name,installed
        //------------------------------------------------------------------------------------------
        $addon_path = APPPATH . "modules/" . strtolower($this->router->fetch_class()) . "/controllers/" . ucfirst($this->router->fetch_class()) . ".php"; // path of addon controller
        $addondata = $this->get_addon_data($addon_path);
        $this->addon_data = $addondata;
        $this->user_id = $this->session->userdata('user_id'); // user_id of logged in user, we may need it
        $function_name = $this->uri->segment(2);
        if ($function_name != "webhook_callback") {
            // all addon must be login protected
            //------------------------------------------------------------------------------------------
            if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
            // if you want the addon to be accessed by admin and member who has permission to this addon
            //-------------------------------------------------------------------------------------------


            if ($this->session->userdata('user_type') != 'Admin' && !in_array(3007, $this->module_access)) {

                redirect('home/access_forbidden', 'location');
                exit();
            }

        }

        $addon_lang = 'n_whatsapp';
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_lang.php')) {
            $this->lang->load($addon_lang, $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        } else {
            $this->lang->load($addon_lang, 'english', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/english');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($addon_lang . '_custom', $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        }

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

        $moveCheck = APPPATH . 'modules/' . $this->router->fetch_class() . '/controllers/';
        if (!is_writable(dirname($moveCheck))) {
            echo json_encode(array('status' => '0', 'message' => dirname($moveCheck) . $this->lang->line(' must writable!!!')));
            exit();
        }

        $moveCheck = APPPATH . '../plugins/nqr/';
        if (is_dir($moveCheck) and !is_writable(dirname($moveCheck))) {
            echo json_encode(array('status' => '0', 'message' => dirname($moveCheck) . $this->lang->line(' must writable!!!')));
            exit();
        }
        if (is_dir($moveCheck)) {
            unset($moveCheck);
        }

        // mysql raw query needed to run, it is an array, put each query in a seperate index, drop table/column query should have IF EXISTS
        $sql = array
        (
            0 => "DELETE from `menu` where url like '%n_whatsapp%' ",
        );

        // deletes add_ons,modules and menu, menu_child1 table ,custom sql as well as module folder, no need to send sql or send blank array if you does not need any sql to run on delete
        $this->delete_addon($addon_controller_name, $sql);
    }

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

        $moveCheck = APPPATH . '../plugins';
        if (!is_writable(dirname($moveCheck))) {
            echo json_encode(array('status' => '0', 'message' => dirname($moveCheck) . $this->lang->line(' must writable!!!')));
            exit();
        }
        if (is_dir(APPPATH . 'modules/n_whatsapp/nqr/')) {
            @rename(APPPATH . "modules/n_whatsapp/nqr/", APPPATH . "../plugins/nqr/");
        }

        //this addon system support 2-level sidebar entry, to make sidebar entry you must provide 2D array like below
        $sidebar = array();
//         // mysql raw query needed to run, it's an array, put each query in a seperate index, create table query must should IF NOT EXISTS
        $sql = array
        ();

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_whatsapp%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%search_tools%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'Whatsapp link generator', 'fa fa-magic', 'n_whatsapp/', " . $parent_id_to_add['serial'] . ", '3007', '0', '0', '0', '0', '0', '', '0', '0')";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }
//         
//         //send blank array if you does not need sidebar entry,send a blank array if your addon does not need any sql to run
        $this->register_addon($addon_controller_name, $sidebar, $sql, $purchase_code);
    }

    public function fix_menu()
    {
        $sql_cust = "DELETE from `menu_child_1` where url like '%n_whatsapp%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_whatsapp%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%search_tools%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'Whatsapp link generator', 'fa fa-magic', 'n_whatsapp/', " . $parent_id_to_add['serial'] . ", '3007', '0', '0', '0', '0', '0', '', '0', '0')";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }
        echo 'done';
    }


    public function index()
    {
        if ($this->session->userdata('user_type') != 'Admin' && !in_array(3007, $this->module_access)) redirect('home/login', 'location');
        $data['body'] = 'whatsapp_url';
        $data['page_title'] = $this->lang->line('whatsapp_link');
        $this->_viewcontroller($data);
    }

///

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

///


}