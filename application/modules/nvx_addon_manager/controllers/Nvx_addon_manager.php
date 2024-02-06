<?php
/*
Addon Name: NVX Addon Manager
Unique Name: nvx_addon_manager
Modules:
{
}
Project ID: 1012
Addon URI: https://nvxgroup.com
Author: MD
Author URI: https://nvxgroup.com
Version: 1.991
Description: NVX Addon Manager
*/


require_once("application/controllers/Home.php"); // loading home controller
class Nvx_addon_manager extends Home
{
    public $key = "";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
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


            if ($this->session->userdata('user_type') != 'Admin') {

                redirect('home/access_forbidden', 'location');
                exit();
            }

        }

        $addon_lang = 'nvx_addon_manager';
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
        if ($this->session->userdata('user_type') != 'Admin') redirect('home/login', 'location');
        $data['body'] = 'nvx_addon_manager';
        $data['page_title'] = $this->lang->line('NVX addon manager');
        //todo: check for ini allow_fopen_url
//        ini_set("allow_url_fopen", 1);
//        if (ini_get("allow_url_fopen") == 1) {
//            echo "allow_url_fopen is ON";
//        } else {
//            echo "allow_url_fopen is OFF";
//        }
//        print ini_get("allow_url_fopen");
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        if (function_exists("file_get_contents")) {
            $body = file_get_contents("https://nvxgroup.com/products.json", false, stream_context_create($arrContextOptions));
            $nviews_body = file_get_contents("https://nvxgroup.com/nviews.json", false, stream_context_create($arrContextOptions));
            $nviews_news = file_get_contents("https://nvxgroup.com/nviews_news.json", false, stream_context_create($arrContextOptions));

            $resp = json_decode($body, true);

            $data['nviews'] = array();
            $data['nviews']['installed'] = 0;
            $data['nviews']['version'] = 0;
            $data['nviews']['downloaded'] = 0;
            $data['nviews']['activated'] = 0;
            $data['nviews']['KEY'] = '70591F6C003CF201';
            $data['nviews']['PID'] = 7;
            $data['nviews']['BASE'] = 'N_task';
            $data['nviews']['URL_Product'] = "<a title='Check shop' class='btn btn-outline-primary' href='https://nvxgroup.com/shop/pre-order-re-design-dashboard-xerochat/'><i class='fa fa-store bx bx-store'></i> Check shop</a>";
            $data['nviews']['news'] = $nviews_body;
            $data['nviews']['news_news'] = $nviews_news;
            $data['nviews']['Name'] = 'Theme dashboard';
            if (file_exists(APPPATH . 'n_views/config.php')) {
                include(APPPATH . 'n_views/config.php');
                $data['nviews']['installed'] = 1;
                $data['nviews']['downloaded'] = 1;
                $data['nviews']['version'] = (float)$n_config['theme_version'];
                $data['nviews']['Latest_Version'] = 0;
            }

            if (file_exists(APPPATH . 'third_party/MX/Loader_xerochat_original.php')) {
                $data['nviews']['activated'] = 1;
            } else {
                $data['nviews']['activated'] = 0;
            }


            $sql = "project_id = 7";
            $this->db->where($sql);
            $db_data = $this->basic->get_data("nvx_addons");

            if (count($db_data) == 0) {
                $data['nviews']['code'] = 0;
            } else {
                $this->key = $data['nviews']['KEY'];
                if ($this->nvx_lic($db_data[0]['code'], $data['nviews']['version'], 7, 'N_task') == false) {
                    $data['nviews']['code'] = 0;
                } else {
                    $data['nviews']['code'] = 1;

                    $update_p = $this->nvx_update(7, $db_data[0]['code'], $data['nviews']['version']);
                    if (!empty($update_p)) {
                        $data['nviews']['Latest_Version'] = (float)$update_p->new_version;
                        $data['nviews']['changelog'] = $update_p->sections['changelog'];
                        $data['nviews']['update_check'] = $update_p;
                    }

                }

            } //end else


            $data['products'] = array();

            foreach ($resp as $value) {
                $data['products'][$value['XID']] = $value;
                if (file_exists(APPPATH . 'modules/' . $value['DIR'] . '/controllers/' . ucfirst($value['DIR']) . '.php')) {
                    $data['products'][$value['XID']]['addon_data'] = $this->get_addon_data(APPPATH . 'modules/' . $value['DIR'] . '/controllers/' . ucfirst($value['DIR']) . '.php');
                    $data['products'][$value['XID']]['addon_data']['downloaded'] = 1;
                    $data['products'][$value['XID']]['addon_data']['version'] = (float)$data['products'][$value['XID']]['addon_data']['version'];

                } else {
                    $data['products'][$value['XID']]['addon_data'] = array();
                    $data['products'][$value['XID']]['addon_data']['version'] = 0;
                    $data['products'][$value['XID']]['addon_data']['installed'] = 0;
                    $data['products'][$value['XID']]['addon_data']['downloaded'] = 0;
                }

                if ($value['XID'] == 1012) {
                    $data['products'][$value['XID']]['addon_data']['code'] = 1;
                    $data['products'][$value['XID']]['changelog'] = $value['Changelog'];
                } else {
                    $sql = "project_id = " . $value['PID'];
                    $this->db->where($sql);
                    $db_data = $this->basic->get_data("nvx_addons");

                    if (count($db_data) == 0) {
                        $data['products'][$value['XID']]['addon_data']['code'] = 0;
                    } else {
                        $this->key = $value['KEY'];
                        if ($this->nvx_lic($db_data[0]['code'], $data['products'][$value['XID']]['addon_data']['version'], $value['PID'], $value['BASE']) == false) {
                            $data['products'][$value['XID']]['addon_data']['code'] = 0;
                        } else {
                            $data['products'][$value['XID']]['addon_data']['code'] = 1;

                            $update_p = $this->nvx_update($value['PID'], $db_data[0]['code'], $data['products'][$value['XID']]['addon_data']['version']);
                            if (!empty($update_p)) {
                                $data['products'][$value['XID']]['Latest_Version'] = (float)$update_p->new_version;
                                $data['products'][$value['XID']]['changelog'] = $update_p->sections['changelog'];


                                $data['products'][$value['XID']]['update_check'] = $update_p;
                            }

                        }

                    }
                }

            }

        } else {
            //todo: error
            echo "Function file_get_contents not exist";
            return false;
        }


        $this->_viewcontroller($data);

    }

    public function install_update_nviews()
    {

        if (!$this->input->is_ajax_request())
            exit();

        $xid = 7;


        if (!function_exists('mkdir')) {
            $response = array('status' => '0', 'message' => 'mkdir() function is not working! See log and update manually.');
            echo json_encode($response);
            exit();
        }

        if (!class_exists('ZipArchive')) {
            if (!isset($response)) {
                $response = array('status' => '0', 'message' => 'ZipArchive is not working! See log and update manually.');
                echo json_encode($response);
                exit();
            }
        }

        $sql = "project_id = " . $xid;
        $this->db->where($sql);
        $db_data = $this->basic->get_data("nvx_addons");

        if (count($db_data) == 0) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Purchase code is not valid or already used.')));
            exit();
        }

        $myfile = FCPATH;
        if (!is_writable($myfile)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
            exit();
        }

        $myfile = FCPATH . '/application';
        if (!is_writable($myfile)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
            exit();
        }

        $myfile = FCPATH . 'application/third_party/MX/Loader.php';
        if (!is_writable($myfile)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
            exit();
        }

        $myfile = FCPATH . 'application/config/routes.php';
        if (!is_writable($myfile)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
            exit();
        }


        if (file_exists(APPPATH . 'n_views/config.php')) {
            include(APPPATH . 'n_views/config.php');
            $version = (float)$n_config['theme_version'];

            $myfile = FCPATH . '/n_assets';
            if (!is_writable($myfile)) {
                echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
                exit();
            }

            $myfile = FCPATH . '/application/n_views';
            if (!is_writable($myfile)) {
                echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
                exit();
            }

        } else {
            $version = 0;
        }

        $update_p = $this->nvx_update($xid, $db_data[0]['code'], $version);
        if (empty($update_p->download_link)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Update not found')));
            exit();
        }
        $fileUrl = $update_p->download_link;

        $path = APPPATH . "cache/nvx_download";
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $myfile = APPPATH . "cache/nvx_download";
        if (!is_writable($myfile)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..' . ' ' . $myfile . ' LINE: ' . __LINE__)));
            exit();
        }

        $saveTo = $path . "/update.zip";
        $fp = fopen($saveTo, 'w+');
        if ($fp === false) {
            echo json_encode(array("status" => 0, "message" => "Error: Could not access the save  path.." . ' LINE: ' . __LINE__));
            exit();
        }

        $ch = curl_init($fileUrl);
        curl_setopt($ch, CURLOPT_FILE, $fp);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_exec($ch);
        if (curl_errno($ch)) {
            echo json_encode(array("status" => 0, "message" => curl_error($ch)));
            exit();
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);


// 		$newFileName = APPPATH.'modules/';
//
//         if ( !is_writable(dirname($newFileName))) {
//             echo json_encode(array('status'=>'0','message'=>$this->lang->line(dirname($newFileName) . ' must writable!!!')));
//             exit();
//         }

        if ($statusCode == 200) {
            $zip = new ZipArchive;
            if ($zip->open($saveTo) === TRUE) {
                $zip->extractTo($path);
                $zip->close();

                unlink($path . "/update.zip");

                if (file_exists($path . '/n_views')) {

                    if (file_exists(APPPATH . 'n_views/config_user.php')) {
                        @unlink($path . '/n_views/config_user.php');
                        @rename(APPPATH . 'n_views/config_user.php', $path . '/n_views/config_user.php');
                    }

                    if (!file_exists(FCPATH . '/application/third_party/MX/Loader_xerochat_original.php')) {
                        //file not exist
                        @rename(FCPATH . '/application/third_party/MX/Loader.php', FCPATH . '/application/third_party/MX/Loader_xerochat_original.php');
                        @rename($path . '/third_party/Loader.php', FCPATH . '/application/third_party/MX/Loader.php');
                    } else {
                        //file exist
                        @unlink(FCPATH . '/application/third_party/MX/Loader.php');
                        @rename($path . '/third_party/Loader.php', FCPATH . '/application/third_party/MX/Loader.php');
                    }

                    if (!file_exists(FCPATH . 'application/config/routes_orig.php')) {
                        //file not exist
                        @rename(FCPATH . 'application/config/routes.php', FCPATH . 'application/config/routes_orig.php');
                        @rename($path . '/third_party/routes.php', FCPATH . 'application/config/routes.php');
                    } else {
                        //file exist
                        @unlink(FCPATH . 'application/config/routes.php');
                        @rename($path . '/third_party/routes.php', FCPATH . 'application/config/routes.php');
                    }

                    if (file_exists(APPPATH . 'controllers/Custom_cname.php')) {
                        @unlink(APPPATH . 'controllers/Custom_cname.php');
                    }
                    @rename($path . '/third_party/Custom_cname.php', FCPATH . 'application/controllers/Custom_cname.php');

                    $myfile = FCPATH . '/n_assets/';
                    if (!file_exists($myfile)) {
                        mkdir($myfile, 0755, true);
                    }
                    if (!is_writable($myfile)) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
                        exit();
                    } else {
                        $this->delete_files($myfile);
                        @rename($path . '/n_assets/', $myfile);
                    }

                    $myfile = FCPATH . '/application/modules/n_theme/';
                    if (!file_exists($myfile)) {
                        mkdir($myfile, 0755, true);
                    }
                    if (!is_writable($myfile)) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
                        exit();
                    } else {
                        $this->delete_files($myfile);
                        @rename($path . '/n_theme/', $myfile);
                    }

                    $myfile = FCPATH . '/application/n_views';
                    if (!file_exists($myfile)) {
                        mkdir($myfile, 0755, true);
                    }
                    if (!is_writable($myfile)) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line('Error: Could not access the save path..') . ' ' . $myfile . ' LINE: ' . __LINE__));
                        exit();
                    } else {
                        $this->delete_files($myfile);
                        @rename($path . '/n_views', $myfile);
                    }

                    $myfile = $path . '/n_assets/';
                    if (file_exists($myfile)) {
                        $this->delete_files($path . '/n_assets/');
                    }

                    $myfile = $path . '/third_party/';
                    if (file_exists($myfile)) {
                        $this->delete_files($path . '/third_party/');
                    }

                    $myfile = $path . '/n_views/';
                    if (file_exists($myfile)) {
                        $this->delete_files($path . '/n_views/');
                    }

                    if (file_exists(APPPATH . 'language/arabic/n_theme_arabic.php')) {
                        $this->delete_files(APPPATH . '/language/arabic/');
                        @rename(APPPATH . 'n_views/language/arabic', APPPATH . '/language/arabic/');
                    }

                    if (file_exists(APPPATH . 'n_views/include/db_update.php')) {
                        include(APPPATH . 'n_views/include/db_update.php');
                    }


                    echo json_encode(array("status" => 1, "message" => "Success: The install/update operation was complete!"));

                    exit();


                } else {

                    $this->delete_files($path);
                    echo json_encode(array("status" => 0, "message" => "Error: Failed to extract the update file."));
                    exit();

                }

            } else {
                $this->delete_files($path);
                echo json_encode(array("status" => 0, "message" => "Error: Could not open the update bundle"));
                exit();
            }

        } else {
            echo json_encode(array("status" => 0, "message" => "Error: Could not download the update file."));
            exit();
        }

    }


    public function purchase_code()
    {

        $this->ajax_check();
        $purchase_code = $this->input->post('purchase_code');
        $xid = $this->input->post('xid');
        $base = $this->input->post('base');
        $key = $this->input->post('key');

        $this->key = trim($key);

        if ($this->nvx_lic($purchase_code, 0, $xid, $base) == false) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Purchase code is not valid or already used.')));
            exit();
        } else {
            $sql = "project_id = " . $xid;
            $this->db->where($sql);
            $db_data = $this->basic->get_data("nvx_addons");

            if (count($db_data) == 0) {
                $processed_data = array();
                $processed_data['project_id'] = $xid;
                $processed_data['name'] = $base;
                $processed_data['code'] = $purchase_code;
                $processed_data['status'] = 1;
                $this->basic->insert_data("nvx_addons", $processed_data);
            } else {
                $processed_data = array();
                $processed_data['code'] = $purchase_code;
                $this->basic->update_data("nvx_addons", array("project_id" => $xid), $processed_data);
            }

            echo json_encode(array('status' => '1', 'message' => $this->lang->line('Purchase code changed.')));
            exit();
        }
    }


    public function activate()
    {

        $this->ajax_check();

        $addon_controller_name = ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        // $purchase_code=$this->input->post('purchase_code');
        //$this->addon_credential_check($purchase_code,strtolower($addon_controller_name)); // retuns json status,message if error
        $purchase_code = 'not_needed';

        //this addon system support 2-level sidebar entry, to make sidebar entry you must provide 2D array like below
        $sidebar = array();
        // mysql raw query needed to run, it's an array, put each query in a seperate index, create table query must should IF NOT EXISTS
        $sql = array
        (
            //1=>"INSERT INTO `modules` (`id`, `module_name`, `add_ons_id`, `extra_text`, `limit_enabled`, `bulk_limit_enabled`, `deleted`) VALUES (NULL, 'Hidden Interest Explorer', '3003', '', '1', '0', '0')",


//             1=> "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'NVX Addon Manager', 'fa fa-layer-group', 'nvx_addon_manager/', '17', '', '0', '1', '0', '0', '0', '0', '2');",

            0 => "CREATE TABLE `nvx_addons` ( `id` INT NOT NULL AUTO_INCREMENT , `project_id` INT NOT NULL , `name` VARCHAR(255) NOT NULL , `code` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`project_id`));",

            1 => "ALTER TABLE `nvx_addons` ADD `status` INT(1) NOT NULL AFTER `code`;"

        );

        $menu_exists = $this->db->query(" SELECT id FROM `menu_child_1` where url LIKE '%nvx_addon_manager%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT parent_id, serial FROM `menu_child_1` where url LIKE '%update_system%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'NVX Addon Manager', 'fa fa-layer-group', 'nvx_addon_manager/', " . ($parent_id_to_add['serial'] + 1) . ", '', '0', '1', '0', '0', '0', '0', " . $parent_id_to_add['parent_id'] . ");";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }

        //send blank array if you does not need sidebar entry,send a blank array if your addon does not need any sql to run
        $this->register_addon($addon_controller_name, $sidebar, $sql, $purchase_code);
    }

    public function fix_menu()
    {

        $sql_cust = "DELETE from `menu_child_1` where url like '%nvx_addon_manager%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu_child_1` where url LIKE '%nvx_addon_manager%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT parent_id, serial FROM `menu_child_1` where url LIKE '%update_system%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'NVX Addon Manager', 'fa fa-layer-group', 'nvx_addon_manager/', " . ($parent_id_to_add['serial'] + 1) . ", '', '0', '1', '0', '0', '0', '0', " . $parent_id_to_add['parent_id'] . ");";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }

        echo "Done";

    }

    public function fix_database()
    {

        try {
            $sql_cust = "CREATE TABLE `nvx_addons` ( `id` INT NOT NULL AUTO_INCREMENT , `project_id` INT NOT NULL , `name` VARCHAR(255) NOT NULL , `code` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`project_id`));";
            $this->db->query($sql_cust);

            $sql_cust = "ALTER TABLE `nvx_addons` ADD `status` INT(1) NOT NULL AFTER `code`;";
            $this->db->query($sql_cust);
        } catch (Exception $e) {

        }

        echo "Done";

    }

    public function update_script()
    {

        if (!$this->input->is_ajax_request())
            exit();

        $xid = $this->input->post('xid');
        $dir = $this->input->post('dir');

        if (!function_exists('mkdir')) {
            $response = array('status' => '0', 'message' => 'mkdir() function is not working! See log and update manually.');
            echo json_encode($response);
            exit();
        }

        if (!class_exists('ZipArchive')) {
            if (!isset($response)) {
                $response = array('status' => '0', 'message' => 'ZipArchive is not working! See log and update manually.');
                echo json_encode($response);
                exit();
            }
        }

        $sql = "project_id = " . $xid;
        $this->db->where($sql);
        $db_data = $this->basic->get_data("nvx_addons");

        if (count($db_data) == 0) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Purchase code is not valid or already used.')));
            exit();
        }

        if (file_exists(APPPATH . 'modules/' . $dir . '/controllers/' . ucfirst($dir) . '.php')) {
            $add_data = $this->get_addon_data(APPPATH . 'modules/' . $dir . '/controllers/' . ucfirst($dir) . '.php');
            $version = (float)$add_data['version'];
        } else {
            $version = 0;
        }

        $update_p = $this->nvx_update($xid, $db_data[0]['code'], $version);

        if (empty($update_p->download_link)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Update not found')));
            exit();
        }


        $fileUrl = $update_p->download_link;

        $path = APPPATH . "cache/nvx_download";
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $saveTo = $path . "/update.zip";
        $fp = fopen($saveTo, 'w+');
        if ($fp === false) {
            echo json_encode(array("status" => 0, "message" => "Error: Could not access the save  path.."));
            exit();
        }

        $ch = curl_init($fileUrl);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_exec($ch);
        if (curl_errno($ch)) {
            echo json_encode(array("status" => 0, "message" => Exception(curl_error($ch))));
            exit();
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);


// 		$newFileName = APPPATH.'modules/';
// 
//         if ( !is_writable(dirname($newFileName))) {
//             echo json_encode(array('status'=>'0','message'=>$this->lang->line(dirname($newFileName) . ' must writable!!!')));
//             exit();
//         }

        if ($statusCode == 200) {
            $zip = new ZipArchive;
            if ($zip->open($saveTo) === TRUE) {
                $zip->extractTo($path);
                $zip->close();

                unlink($path . "/update.zip");

                if (file_exists($path . '/' . $dir)) {

                    $newFileName = APPPATH . 'modules/' . $dir;
                    if (!is_writable(dirname($newFileName))) {
                        echo json_encode(array('status' => '0', 'message' => dirname($newFileName) . $this->lang->line(' must writable!!!')));
                        exit();
                    }

                    if (is_dir(APPPATH . 'modules/' . $dir . '/config/')) {
                        @unlink($path . '/' . $dir . '/config/');
                        @rename(APPPATH . 'modules/' . $dir . '/config/', $path . '/' . $dir . '/config/');
                    }

                    $dir_lang = APPPATH . 'modules/' . $dir . '/language';
                    $this->listFolderFiles($dir_lang, $path);

                    $this->delete_files(APPPATH . 'modules/' . $dir);

                    if (!rename($path . '/' . $dir, APPPATH . 'modules/' . $dir)) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line(dirname($newFileName) . ' must writable!!!')));
                        exit();
                    }

                    unlink(APPPATH . 'modules/' . $dir . '/install.txt');

                    $moveCheck = APPPATH . '../plugins';
                    if (!is_writable(dirname($moveCheck))) {
                        echo json_encode(array('status' => '0', 'message' => dirname($moveCheck) . $this->lang->line(' must writable!!!')));
                        exit();
                    }


                    if (is_dir(APPPATH . 'modules/n_image_editor/pixie/')) {
                        $path_unlink = APPPATH . "../plugins/pixie/";
                        if (is_dir($path_unlink)) {
                            $this->delete_files($path_unlink);
                        }
                        @rename(APPPATH . "modules/n_image_editor/pixie/", APPPATH . "../plugins/pixie/");
                    }

                    if (is_dir(APPPATH . 'modules/n2_image_editor/miniPaint/')) {
                        $path_unlink = APPPATH . "../plugins/miniPaint/";
                        if (is_dir($path_unlink)) {
                            $this->delete_files($path_unlink);
                        }
                        @rename(APPPATH . "modules/n2_image_editor/miniPaint/", APPPATH . "../plugins/miniPaint/");
                    }

                    if (is_dir(APPPATH . 'modules/n3_image_editor/tui/')) {
                        $path_unlink = APPPATH . "../plugins/tui/";
                        if (is_dir($path_unlink)) {
                            $this->delete_files($path_unlink);
                        }
                        @rename(APPPATH . "modules/n3_image_editor/tui/", APPPATH . "../plugins/tui/");
                    }

                    if (is_dir(APPPATH . 'modules/n_whatsapp/nqr/')) {
                        $path_unlink = APPPATH . "../plugins/nqr/";
                        if (is_dir($path_unlink)) {
                            $this->delete_files($path_unlink);
                        }
                        @rename(APPPATH . "modules/n_whatsapp/nqr/", APPPATH . "../plugins/nqr/");
                    }


                    echo json_encode(array("status" => 1, "message" => "Success: The update operation was complete!"));

                    exit();


                } else {

                    $this->delete_files($path);
                    echo json_encode(array("status" => 0, "message" => "Error: Failed to extract the update file."));
                    exit();

                }

            } else {
                $this->delete_files($path);
                echo json_encode(array("status" => 0, "message" => "Error: Could not open the update bundle"));
                exit();
            }

        } else {
            echo json_encode(array("status" => 0, "message" => "Error: Could not download the update file."));
            exit();
        }

    }

    public function update_script_manager()
    {

        if (!$this->input->is_ajax_request())
            exit();

        $xid = $this->input->post('xid');
        $dir = 'nvx_addon_manager';

        if (!function_exists('mkdir')) {
            $response = array('status' => '0', 'message' => 'mkdir() function is not working! See log and update manually.');
            echo json_encode($response);
            exit();
        }

        if (!class_exists('ZipArchive')) {
            if (!isset($response)) {
                $response = array('status' => '0', 'message' => 'ZipArchive is not working! See log and update manually.');
                echo json_encode($response);
                exit();
            }
        }


        if (file_exists(APPPATH . 'modules/' . $dir . '/controllers/' . ucfirst($dir) . '.php')) {
            $add_data = $this->get_addon_data(APPPATH . 'modules/' . $dir . '/controllers/' . ucfirst($dir) . '.php');
            $version = (float)$add_data['version'];
        } else {
            $version = 0;
        }

        $fileUrl = 'https://nvxgroup.com/nvx_addon_manager.zip';

        $path = APPPATH . "cache/nvx_download";
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $saveTo = $path . "/update.zip";
        $fp = fopen($saveTo, 'w+');
        if ($fp === false) {
            echo json_encode(array("status" => 0, "message" => "Error: Could not access the save  path.."));
            exit();
        }

        $ch = curl_init($fileUrl);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_exec($ch);
        if (curl_errno($ch)) {
            echo json_encode(array("status" => 0, "message" => Exception(curl_error($ch))));
            exit();
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);


// 		$newFileName = APPPATH.'modules/';
// 
//         if ( !is_writable(dirname($newFileName))) {
//             echo json_encode(array('status'=>'0','message'=>$this->lang->line(dirname($newFileName) . ' must writable!!!')));
//             exit();
//         }

        if ($statusCode == 200) {
            $zip = new ZipArchive;
            if ($zip->open($saveTo) === TRUE) {
                $zip->extractTo($path);
                $zip->close();

                unlink($path . "/update.zip");

                if (file_exists($path . '/' . $dir)) {

                    $newFileName = APPPATH . 'modules/' . $dir;
                    if (!is_writable(dirname($newFileName))) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line(dirname($newFileName) . ' must writable!!!')));
                        exit();
                    }

                    $this->delete_files(APPPATH . 'modules/' . $dir);

                    if (!@rename($path . '/' . $dir, APPPATH . 'modules/' . $dir)) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line(APPPATH . 'modules/' . $dir . ' must writable recursive!!!')));
                        exit();
                    }

                    unlink(APPPATH . 'modules/' . $dir . '/install.txt');

                    echo json_encode(array("status" => 1, "message" => "Success: The update operation was complete!"));

                    exit();


                } else {

                    $this->delete_files($path);
                    echo json_encode(array("status" => 0, "message" => "Error: Failed to extract the update file."));
                    exit();

                }

            } else {
                $this->delete_files($path);
                echo json_encode(array("status" => 0, "message" => "Error: Could not open the update bundle"));
                exit();
            }

        } else {
            echo json_encode(array("status" => 0, "message" => "Error: Could not download the update file."));
            exit();
        }

    }

    public function download_script()
    {

        if (!$this->input->is_ajax_request())
            exit();

        $xid = $this->input->post('xid');
        $dir = $this->input->post('dir');

        if (!function_exists('mkdir')) {
            $response = array('status' => '0', 'message' => 'mkdir() function is not working! See log and update manually.');
            echo json_encode($response);
            exit();
        }

        if (!class_exists('ZipArchive')) {
            if (!isset($response)) {
                $response = array('status' => '0', 'message' => 'ZipArchive is not working! See log and update manually.');
                echo json_encode($response);
                exit();
            }
        }

        $sql = "project_id = " . $xid;
        $this->db->where($sql);
        $db_data = $this->basic->get_data("nvx_addons");

        if (count($db_data) == 0) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Purchase code is not valid or already used.')));
            exit();
        }

        if (file_exists(APPPATH . 'modules/' . $dir . '/controllers/' . ucfirst($dir) . '.php')) {
            $add_data = $this->get_addon_data(APPPATH . 'modules/' . $dir . '/controllers/' . ucfirst($dir) . '.php');
            $version = (float)$add_data['version'];
        } else {
            $version = 0;
        }

        $update_p = $this->nvx_update($xid, $db_data[0]['code'], $version);

        if (empty($update_p->download_link)) {
            echo json_encode(array('status' => '0', 'message' => $this->lang->line('Update not found')));
            exit();
        }


        $fileUrl = $update_p->download_link;

        $path = APPPATH . "cache/nvx_download";
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $saveTo = $path . "/update.zip";
        $fp = fopen($saveTo, 'w+');
        if ($fp === false) {
            echo json_encode(array("status" => 0, "message" => "Error: Could not access the save  path.."));
            exit();
        }

        $ch = curl_init($fileUrl);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_exec($ch);
        if (curl_errno($ch)) {
            echo json_encode(array("status" => 0, "message" => curl_error($ch)));
            exit();
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);


// 		$newFileName = APPPATH.'modules/';
// 
//         if ( !is_writable(dirname($newFileName))) {
//             echo json_encode(array('status'=>'0','message'=>$this->lang->line(dirname($newFileName) . ' must writable!!!')));
//             exit();
//         }

        if ($statusCode == 200) {
            $zip = new ZipArchive;
            if ($zip->open($saveTo) === TRUE) {
                $zip->extractTo($path);
                $zip->close();

                unlink($path . "/update.zip");

                if (file_exists($path . '/' . $dir)) {

                    $newFileName = APPPATH . 'modules/';
                    if (!is_writable(dirname($newFileName))) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line(dirname($newFileName) . ' must writable!!!')));
                        exit();
                    }

                    //$this->delete_files(APPPATH.'modules/'.$dir);

                    if (!rename($path . '/' . $dir, APPPATH . 'modules/' . $dir)) {
                        echo json_encode(array('status' => '0', 'message' => $this->lang->line(dirname($newFileName) . ' must writable!!!')));
                        exit();
                    }

                    //unlink(APPPATH.'modules/'.$dir.'/install.txt');

                    echo json_encode(array("status" => 1, "message" => "Success: The update operation was complete!"));

                    exit();


                } else {

                    $this->delete_files($path);
                    echo json_encode(array("status" => 0, "message" => "Error: Failed to extract the update file."));
                    exit();

                }

            } else {
                $this->delete_files($path);
                echo json_encode(array("status" => 0, "message" => "Error: Could not open the update bundle"));
                exit();
            }

        } else {
            echo json_encode(array("status" => 0, "message" => "Error: Could not download the update file."));
            exit();
        }

    }

    public function n_deactivate()
    {
        $this->ajax_check();

        $xid = $this->input->post('xid');
        $base = $this->input->post('base');
        $key = $this->input->post('key');
        $dir = $this->input->post('dir');

        $this->key = $key;

        $sql = "project_id = " . $xid;
        $this->db->where($sql);
        $db_data = $this->basic->get_data("nvx_addons");

        if (file_exists(APPPATH . 'modules/' . strtolower($dir) . '/controllers/' . ucfirst($dir) . '.php')) {
            $addon_data = $this->get_addon_data(APPPATH . 'modules/' . $dir . '/controllers/' . ucfirst($dir) . '.php');
            $addon_controller_name = ucfirst($addon_data['controller_name']);
        }

        if (count($db_data) > 0) {
            $this->nvx_deactive($message = '', $db_data[0]['code'], $addon_data['version'], $xid, $base);
        }

        $sql_rem = array
        (
            0 => "DELETE from `menu` where url like '%" . strtolower($dir) . "%'",
            1 => "DELETE from `menu_child_1` where url like '%" . strtolower($dir) . "%'",
        );
        if (is_array($sql_rem)) {
            foreach ($sql_rem as $key => $query) {
                try {
                    $this->db->query($query);
                } catch (Exception $e) {

                }
            }
        }

        if (file_exists(APPPATH . 'modules/' . strtolower($dir) . '/controllers/' . ucfirst($dir) . '.php')) {
            $this->unregister_addon(ucfirst($dir));
        }


    }

///

    private function listFolderFiles($dir, $path)
    {
        $ffs = scandir($dir);
        foreach ($ffs as $ff) {
            if ($ff != '.' && $ff != '..') {
                //echo "   Real Path: ". $dir.''.$ff;

                if (strpos($ff, 'custom') !== false) {
                    //echo $dir.'/'.$ff;

                    $ren_to = str_replace(APPPATH . 'modules/', $path . '/', $dir . '/');
                    @mkdir($ren_to, 0755, true);
                    @rename($dir . '/' . $ff, $ren_to . $ff);
                }

                if (is_dir($dir . '/' . $ff))
                    $this->listFolderFiles($dir . '/' . $ff, $path);
            }
        }
    }

    private function delete_files($dir)
    {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                @rmdir($file->getRealPath());
            } else {
                @unlink($file->getRealPath());
            }
        }
        @rmdir($dir);
    }

    public function deactivate()
    {
        echo json_encode(array('status' => '0', 'message' => $this->lang->line('Deactivate not needws. If you want remove NVX Addon Manager please delete addon.')));
        exit();
    }

    public function delete()
    {
        $this->ajax_check();

        $addon_controller_name = ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        $add_inf = $this->get_addon_data(APPPATH . 'modules/' . $this->router->fetch_class() . '/controllers/' . $addon_controller_name . '.php');


        // mysql raw query needed to run, it is an array, put each query in a seperate index, drop table/column query should have IF EXISTS
        $sql = array
        (
            0 => "DELETE from `menu_child_1` where url like '%nvx_addon_manager%' ",
            1 => "DROP TABLE nvx_addons ",
        );

        // deletes add_ons,modules and menu, menu_child1 table ,custom sql as well as module folder, no need to send sql or send blank array if you does not need any sql to run on delete
        $this->delete_addon($addon_controller_name, $sql);
    }

    public function n_theme_activate()
    {
        $this->ajax_check();

        //deactivate
        if (file_exists(APPPATH . 'third_party/MX/Loader_xerochat_original.php')) {
            rename(APPPATH . 'third_party/MX/Loader.php', APPPATH . 'third_party/MX/Loader_ntheme_deactivated.php');
            rename(APPPATH . 'third_party/MX/Loader_xerochat_original.php', APPPATH . 'third_party/MX/Loader.php');
            echo json_encode(array("status" => 1, "message" => "Success: The update operation was complete!"));

            exit();
        }

        //activate
        if (file_exists(APPPATH . 'third_party/MX/Loader_ntheme_deactivated.php')) {
            rename(APPPATH . 'third_party/MX/Loader.php', APPPATH . 'third_party/MX/Loader_xerochat_original.php');
            rename(APPPATH . 'third_party/MX/Loader_ntheme_deactivated.php', APPPATH . 'third_party/MX/Loader.php');
            echo json_encode(array("status" => 1, "message" => "Success: The update operation was complete!"));

            exit();
        }

    }

    private function nvx_lic($purchase_code, $version, $id, $base)
    {
        $error = '';
        $param = $this->getParam($purchase_code, $version, $id, $base);
        $response = $this->_request('product/active/' . $id, $param, $error);
        return $response->status;
    }

    private function nvx_update($id, $purchase_code, $version)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        if (function_exists("file_get_contents")) {
            $body = file_get_contents($this->server_host . "product/update/" . $id . '/' . trim($purchase_code) . '/' . $version, false, stream_context_create($arrContextOptions));
            $responseJson = json_decode($body);
            if (is_object($responseJson) && !empty($responseJson->status) && !empty($responseJson->data->new_version)) {

                $responseJson->data->new_version = !empty($responseJson->data->new_version) ? $responseJson->data->new_version : "";
                $responseJson->data->version = $responseJson->data->new_version;
                $responseJson->data->url = !empty($responseJson->data->url) ? $responseJson->data->url : "";
                $responseJson->data->package = !empty($responseJson->data->download_link) ? $responseJson->data->download_link : "";

                $responseJson->data->sections = (array)$responseJson->data->sections;
                //$responseJson->data->plugin      = "";
                $responseJson->data->icons = (array)$responseJson->data->icons;
                $responseJson->data->banners = (array)$responseJson->data->banners;
                $responseJson->data->banners_rtl = (array)$responseJson->data->banners_rtl;

                return $responseJson->data;
            }
        }
        return NULL;
    }

    private function nvx_deactive($message, $purchase_code, $version, $id, $base)
    {
        if(empty($message)){$message='';}
        $param = $this->getParam($purchase_code, $version, $id, $base);
        $response = $this->_request('product/deactive/' . $id, $param, $message);
        if (empty($response->code)) {
            if (!empty($response->status)) {
                $message = $response->msg;
                return true;
            } else {
                $message = $response->msg;
            }
        } else {
            $message = $response->message;
        }
        return false;
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

        // CURL_SSLVERSION_TLSv1_2 is defined in libcurl version 7.34 or later
        // but unless PHP has been compiled with the correct libcurl headers it
        // won't be defined in your PHP instance.  PHP > 5.5.19 or > 5.6.3
        if (!defined('CURL_SSLVERSION_TLSv1_2')) {
            define('CURL_SSLVERSION_TLSv1_2', 6);
        }

        //curl when fall back
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
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

    private function getParam($purchase_key, $version, $id, $base)
    {
        $req = new stdClass();
        $req->license_key = $purchase_key;
        // $req->email        = ! empty( $admin_email ) ? $admin_email : $this->getEmail();
        $req->domain = $this->getDomain();
        $req->app_version = $version;
        $req->product_id = $id;
        $req->product_base = $base;

        return $req;
    }

    private function getDomain()
    {
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $base_url .= "://" . $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
        return $base_url;

    }

    function encryptObj($obj)
    {
        $text = serialize($obj);

        return $this->encrypt($text);
    }

    private function decryptObj($ciphertext)
    {
        $text = $this->decrypt($ciphertext);

        return unserialize($text);
    }

///


}