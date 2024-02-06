<?php
/*
Addon Name: Content Generator addon for Chatpion
Unique Name: n_generator
Modules:
{
   "3230":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"lifetime",
      "module_name":"Content Generator Words (not used move to next month)"
   },
   "3231":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"month",
      "module_name":"Content Generator Words (not used dissapear)"
   },
   "3232":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"Credits (not used move to next month)",
      "module_name":"Content Generator Credits"
   }
}
Project ID: 1108
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.602
Description: Content Generator Unlimited
*/
require_once("application/controllers/Home.php"); // loading home controller


class N_generator extends Home
{
    public $key = "03D353484A144210";
    private $product_id = "16";
    private $product_base = "n_generator";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 1.602;
    /* @var self */
    private static $selfobj = null;
    public $fb;

    private $url_api = "https://api.nvxgroup.com/ContentgeneratorV6/api";
    private $n_gen_config = array();

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
            $function_name != "webhook"
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

        $addon_lang = 'n_generator';

        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '_' . $addon_lang . '_lang.php')) {
            $this->lang->load($this->language . '_' . $addon_lang . '_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        } else {
            $this->lang->load('english_' . $addon_lang . '_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '_' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($this->language . '_' . $addon_lang . '_custom_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        }

        if (is_dir(APPPATH . 'modules/n_generator/thirdn/')) {
            $path_unlink = APPPATH . "../assets/gen_thirdn/";
            if (is_dir($path_unlink)) {
                $this->delete_files($path_unlink);
            }
            @rename(APPPATH . "modules/n_generator/thirdn/", APPPATH . "../assets/gen_thirdn/");
        }

        if (file_exists(APPPATH . 'modules/n_generator/db_update.php')) {
            include(APPPATH . 'modules/n_generator/db_update.php');
            @unlink(APPPATH . 'modules/n_generator/db_update.php');
        }
    }

    public function install_custom_openai(){
       if( $this->session->userdata('user_type') != 'Admin') {
            redirect('n_generator', 'location');
            exit;
        }

        $custom_file = APPPATH . "modules/n_generator/include/Openai_api.php";
        if(file_exists($custom_file)){
            $path_unlink = APPPATH . "libraries/Openai_api.php";
            @unlink($path_unlink);
            @copy($custom_file, $path_unlink);

            echo 'Installation custom file #1 completed. ';
        }

        $custom_file = APPPATH . "modules/n_generator/include/api_credentials.php";
        if(file_exists($custom_file)){
            $path_unlink = APPPATH . "views/admin/openAI/api_credentials.php";
            @unlink($path_unlink);
            @copy($custom_file, $path_unlink);

            echo ' Installation custom file #2 completed.';
        }

        $path_to_file = APPPATH.'controllers/Home.php';
        $file_contents = file_get_contents($path_to_file);


        $file_contents = str_replace('],$description,$human)', '],$description,$human,$user_id)', $file_contents);
        file_put_contents($path_to_file, $file_contents);
        file_put_contents(APPPATH.'custom_oai_library.php', '1');

        echo ' || COMPLETED';
        //change ai_reply_credits to 1 in nvx theme settings
    }


    public function index()
    {
        $this->view_files();
    }

    public function view_files()
    {
        if (!file_exists(APPPATH . 'n_generator_config.php') and $this->session->userdata('user_type') == 'Admin') {
            redirect('n_generator/config', 'location');
            exit;
        }

        $data = array();
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'view_files';
        $data['page_title'] = $this->lang->line('Content Generator');
        $data['credits'] = $this->get_credits();
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');


        $this->_viewcontroller($data);
    }

    private function display_error()
    {

    }

    private function calc_tokens($tokens, $engine_type)
    {
        $cp_user = $this->get_credits();

        if($engine_type=='chat'){
            $prompt_tokens = ($tokens['prompt_tokens'] * $this->n_gen_config['cost_per1k_tokens'] / 1000);
            $completion_tokens = ($tokens['completion_tokens'] * $this->n_gen_config['cost_per1k_tokens'] / 1000);
            $cp_calc = $prompt_tokens + $completion_tokens;
        }else{
            $cp_calc = ($tokens['total_tokens'] * $this->n_gen_config['cost_per1k_tokens'] / 1000);
        }


        $cp_update = $cp_user - $cp_calc;

        $update_data = array();
        $update_data['n_credits'] = $cp_update;
        $this->basic->update_data("users", array('id' => $this->user_id), $update_data);

        return round($cp_update, 2);
    }

    private function get_credits()
    {
        if ($this->session->userdata('user_type') == 'Admin') {
            return 999999999999;
        }

        if (!empty($this->session->userdata['package_info']['monthly_limit'])) {
            $package = $this->session->userdata['package_info']['monthly_limit'];
            $package = json_decode($package, true);
            if (!empty($package[3232]) and $package[3232] > 0) {
                $status=$this->_check_usage(3232,$package[3232]);
                if($status==1){
                    $this->_insert_usage_log(3232, $package[3232]);


                    $update_data = array();
                    //$update_data['n_credits'] = $package[3232];
                    $this->db->set('n_credits', 'n_credits+'.$package[3232], FALSE);
                    $this->basic->update_data("users", array('id' => $this->user_id), $update_data);
                }

            }

            $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);
            return $user_info[0]['n_credits'];
        }

        return 0;
    }

    private function save_document()
    {

        $this->form_validation->set_rules('doc_title', '<b>' . $this->lang->line("doc_title") . '</b>', 'trim');
        $this->form_validation->set_rules('doc_text', '<b>' . $this->lang->line("doc_text") . '</b>');
        $this->form_validation->set_rules('doc_id', '<b>' . $this->lang->line("doc_text") . '</b>', 'trim');

        if ($this->form_validation->run() == false) {
            $this->return_json('Something wrong');
        } else {
            $doc_title = addslashes(strip_tags($this->input->post('doc_title', true)));
            $doc_text = htmlentities($this->input->post('doc_text'));
            $doc_id = addslashes(strip_tags($this->input->post('doc_id', true)));

            $update_data = array();
            $update_data['last_open_date'] = date("Y-m-d H:i:s");
            $update_data['text'] = $doc_text;
            $update_data['last_open_date'] = date("Y-m-d H:i:s");
            $update_data['title'] = $doc_title;

            $this->basic->update_data("n_content_documents", array("id" => $doc_id, "user_id" => $this->user_id), $update_data);

            $this->return_json('ok_alert', 'Document saved');
        }

    }

    private function save_user_config()
    {
        $settings = array();

        $this->form_validation->set_rules('language', '<b>' . $this->lang->line("language") . '</b>', 'trim');
        $this->form_validation->set_rules('creativity', '<b>' . $this->lang->line("creativity") . '</b>', 'trim');
        $this->form_validation->set_rules('tone', '<b>' . $this->lang->line("tone") . '</b>', 'trim');
        $this->form_validation->set_rules('autosave', '<b>' . $this->lang->line("autosave") . '</b>', 'trim');

        if ($this->form_validation->run() == false) {
            $this->return_json('Something wrong');
        } else {
            $language = addslashes(strip_tags($this->input->post('language', true)));
            $creativity = addslashes(strip_tags($this->input->post('creativity', true)));
            $tone = addslashes(strip_tags($this->input->post('tone', true)));
            $autosave = addslashes(strip_tags($this->input->post('autosave', true)));

            $settings['language'] = $language;
            $settings['creativity'] = $creativity;
            $settings['tone'] = $tone;
            $settings['autosave'] = $autosave;

            $this->session->set_userdata("n_content_settings", json_encode($settings));

            $update_data = array();
            $update_data['n_content_settings'] = json_encode($settings);
            $this->basic->update_data("users", array("id" => $this->user_id), $update_data);
            $this->return_json('ok', 'Saved');
        }
    }

    private function history($start_from)
    {
        $start_from = addslashes(strip_tags($this->input->post('load_more', true)));
        $history = $this->basic->get_data('n_content_history', ['where' => ['user_id' => $this->user_id]], '*', '', 10, $start_from, 'id desc ');
        $data = array();
        $data['data'] = $history;
        $data['start'] = ((int)$start_from + 10);
        echo json_encode($data);
    }

    private function get_user_config()
    {
        if (!empty($this->session->userdata("n_content_settings"))) {
            return json_decode($this->session->userdata("n_content_settings"), true);
        } else {
            $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);

            return json_decode($user_info[0]['n_content_settings'], true);
        }
    }

    private function save_config($n_gen_config)
    {
        $this->csrf_token_check();

        $this->form_validation->set_rules('openai_api', '<b>' . $this->lang->line("openai_api") . '</b>', 'trim');
        $this->form_validation->set_rules('cost_per1k_tokens', '<b>' . $this->lang->line("cost_per1k_tokens") . '</b>', 'trim');

        if ($this->form_validation->run() == false) {
            return false;
        } else {
            $openai_api = addslashes(strip_tags($this->input->post('openai_api', true)));
            $cost_per1k_tokens = addslashes(strip_tags($this->input->post('cost_per1k_tokens', true)));

            $gpt4_cost_per1k_tokens_completions = addslashes(strip_tags($this->input->post('gpt4_cost_per1k_tokens_completions', true)));
            $gpt4_cost_per1k_tokens_prompt = addslashes(strip_tags($this->input->post('gpt4_cost_per1k_tokens_prompt', true)));

            $gpt35_cost_per1k_tokens_completions = addslashes(strip_tags($this->input->post('gpt35_cost_per1k_tokens_completions', true)));
            $gpt35_cost_per1k_tokens_prompt = addslashes(strip_tags($this->input->post('gpt35_cost_per1k_tokens_prompt', true)));


            $engine = addslashes(strip_tags($this->input->post('engine', true)));

            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_gen_config['cost_per1k_tokens'] = '$cost_per1k_tokens';\n";

            $app_my_config_data .= "\$n_gen_config['gpt4_cost_per1k_tokens_completions'] = '$gpt4_cost_per1k_tokens_completions';\n";
            $app_my_config_data .= "\$n_gen_config['gpt4_cost_per1k_tokens_prompt'] = '$gpt4_cost_per1k_tokens_prompt';\n";

            $app_my_config_data .= "\$n_gen_config['gpt35_cost_per1k_tokens_completions'] = '$gpt35_cost_per1k_tokens_completions';\n";
            $app_my_config_data .= "\$n_gen_config['gpt35_cost_per1k_tokens_prompt'] = '$gpt35_cost_per1k_tokens_prompt';\n";



            if(isset($engine) and $engine=='1'){
                $app_my_config_data .= "\$n_gen_config['engine'] = 1;\n";
            }else{
                $app_my_config_data .= "\$n_gen_config['engine'] = 0;\n";
            }

            if ($openai_api != '*****') {
                $openai_api = openssl_encrypt($openai_api, "AES-128-ECB", 'nstok-' . $this->get_purchase_code());
                $app_my_config_data .= "\$n_gen_config['openai_api'] = '$openai_api';\n";
            } else {
                $save_to = $n_gen_config["openai_api"];
                $app_my_config_data .= "\$n_gen_config['openai_api'] = '$save_to';\n";
            }

            file_put_contents(APPPATH . 'n_generator_config.php', $app_my_config_data, LOCK_EX);


            return array(
                'cost_per1k_tokens' => (int)$cost_per1k_tokens,
                'gpt4_cost_per1k_tokens_completions' => (int)$gpt4_cost_per1k_tokens_completions,
                'gpt4_cost_per1k_tokens_prompt' => (int)$gpt4_cost_per1k_tokens_prompt,
                'gpt35_cost_per1k_tokens_completions' => (int)$gpt35_cost_per1k_tokens_completions,
                'gpt35_cost_per1k_tokens_prompt' => (int)$gpt35_cost_per1k_tokens_prompt,
                'engine' => (int)$engine,
            );
        }


    }

    private function get_purchase_code()
    {
        $xdata = $this->basic->get_data("nvx_addons", array("where" => array("name" => 'n_generator')));
        if (!isset($xdata[0])) exit();

        return $xdata[0]['code'];
    }

    public function config(){
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }

        $data = array();
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'config';
        $data['page_title'] = $this->lang->line('Content Generator');
        $data['credits'] = $this->get_credits();

        $data['cost_per1k_tokens'] = '200';

        $data['engine'] = '';
        $data['gpt4_cost_per1k_tokens_completions'] = '600';
        $data['gpt4_cost_per1k_tokens_prompt'] = '300';

        $data['gpt35_cost_per1k_tokens_completions'] = '200';
        $data['gpt35_cost_per1k_tokens_prompt'] = '200';



        if (file_exists(APPPATH . 'n_generator_config.php')) {
            include(APPPATH . 'n_generator_config.php');
            $data['cost_per1k_tokens'] = $n_gen_config['cost_per1k_tokens'];
            if(isset($n_gen_config['engine'])){
                $data['gpt4_cost_per1k_tokens_completions'] = $n_gen_config['gpt4_cost_per1k_tokens_completions'];
                $data['gpt4_cost_per1k_tokens_prompt'] = $n_gen_config['gpt4_cost_per1k_tokens_prompt'];
                $data['engine'] = $n_gen_config['engine'];
            }
            if(isset($n_gen_config['gpt35_cost_per1k_tokens_completions'])){
                $data['gpt35_cost_per1k_tokens_completions'] = $n_gen_config['gpt35_cost_per1k_tokens_completions'];
                $data['gpt35_cost_per1k_tokens_prompt'] = $n_gen_config['gpt35_cost_per1k_tokens_prompt'];
            }
        }

        if (!empty($_POST)) {
            $return_data = $this->save_config($n_gen_config);
            unset($_POST);
            $this->session->set_flashdata('success_message', 1);

            $data['cost_per1k_tokens'] = $return_data['cost_per1k_tokens'];
            $data['gpt4_cost_per1k_tokens_completions'] = $return_data['gpt4_cost_per1k_tokens_completions'];
            $data['gpt4_cost_per1k_tokens_prompt'] = $return_data['gpt4_cost_per1k_tokens_prompt'];
            $data['gpt35_cost_per1k_tokens_completions'] = $return_data['gpt35_cost_per1k_tokens_completions'];
            $data['gpt35_cost_per1k_tokens_prompt'] = $return_data['gpt35_cost_per1k_tokens_prompt'];
            if($return_data['engine']==1){
                $n_gen_config['engine'] = $return_data['engine'];
            }

        }

        $data['openai_api'] = '*****';

        if(isset($n_gen_config['engine']) and $n_gen_config['engine']==1){
            $data['engine'] = 'checked';
        }

        $this->_viewcontroller($data);
    }

    public function api($endpoint, $cust_1 = 0)
    {
        $this->csrf_token_check();
        if (!$this->input->is_ajax_request()) {
            $this->return_json('Bad Request');
        }

        if (file_exists(APPPATH . 'n_generator_config.php')) {
            include(APPPATH . 'n_generator_config.php');
            $this->n_gen_config = $n_gen_config;
        } else {

            $this->return_json('Not found configuration. Please contact with administration.');
            exit;
        }
        //$n_gen_config['cost_per1k_tokens'];
        switch ($endpoint) {
            case 'get_credits';
                $this->get_credits();
                break;
            case 'vote';
                $this->vote();
                break;                                                          
            case 'generate';
                $this->generate();
                break;
            case 'history';
                $this->history($cust_1);
                break;
            case 'files';
                $this->files();
                break;
            case 'save_document';
                $this->save_document();
                break;
            case 'delete_document';
                $this->delete_document();
                break;
            case 'save_user_config';
                $this->save_user_config();
                break;
        }
    }

    private function delete_document(){
        $this->csrf_token_check();

        $doc_id = $this->input->post('doc_id');

        if(empty($doc_id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $doc_info = $this->basic->get_data('n_content_documents', ['where' => ['id' => $doc_id, 'user_id' => $this->user_id]]);



        if(empty($doc_info)){
            $this->return_json('error','Bad Request');
        }

        if($doc_info[0]['user_id']!=$this->user_id){
            $this->return_json('error','Something Went Wrong, please try once again.');
        }


        if ($this->basic->delete_data('n_content_documents', array("id" => $doc_info[0]['id']))) {
            $this->return_json(1,'OK');
        } else {
            $this->return_json('error','Something Went Wrong, please try once again.');
        }
    }

    public function editor($id = '')
    {
        $data = array();
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'editor_document';
        $data['page_title'] = $this->lang->line('Editor');
        $data['credits'] = $this->get_credits();
        $data['doc_title'] = '';
        if (empty($id)) {
            $insert_data = array();
            $insert_data['user_id'] = $this->user_id;
            $insert_data['text'] = '';
            $insert_data['last_open_date'] = date("Y-m-d H:i:s");
            $insert_data['create_date'] = date("Y-m-d H:i:s");
            $insert_data['title'] = $this->lang->line('New document');

            $this->basic->insert_data("n_content_documents", $insert_data);
            $insert_id = $this->db->insert_id();


            $doc_title = $insert_data['title'];
            $doc_text = $insert_data['text'];
            $id = $insert_id;
            $data['doc_id'] = $id;
            $data['doc_text'] = $doc_text;
            $data['doc_title'] = $doc_title;
        } else {
            $doc_info = $this->basic->get_data('n_content_documents', ['where' => ['id' => $id, 'user_id' => $this->user_id]]);
            if (!empty($doc_info[0])) {
                $data['doc_id'] = $doc_info[0]['id'];
                $data['doc_text'] = $doc_info[0]['text'];
                $data['doc_title'] = $doc_info[0]['title'];

                $update_data = array();
                $update_data['last_open_date'] = date("Y-m-d H:i:s");
                $this->basic->update_data("n_content_documents", array("id" => $data['doc_id']), $update_data);

            } else {
                $this->display_error();
            }
        }

        $data['sdk_locale'] = $this->sdk_locale();

        $data['history'] = $this->basic->get_data('n_content_history', ['where' => ['user_id' => $this->user_id]], '*', '', 10, NULL, 'id desc');


        $data['config_sdk_locale'] = 'en_US';
        $data['config_creativity'] = 'Optimal';
        $data['config_tone'] = 'Passionate';
        $data['config_autosave'] = 'true';

        require_once(APPPATH.'modules/n_generator/include/frameworks.php');
        $data['frameworks_data'] = json_decode($json, true);

        require_once(APPPATH.'modules/n_generator/include/filters.php');
        $data['filters_data'] = $filters;

        $data['gpt4_enabled'] = 0;
        include(APPPATH . 'n_generator_config.php');
        if(isset($n_gen_config['gpt4_enabled']) AND $n_gen_config['gpt4_enabled']==1){
            $data['gpt4_enabled'] = 1;
        }


        $json = $this->get_user_config();
        if (!empty($json)) {
            $data['config_sdk_locale'] = $json['language'];
            $data['config_creativity'] = $json['creativity'];
            $data['config_tone'] = $json['tone'];
            $data['config_autosave'] = $json['autosave'];
        }

        $this->_viewcontroller($data);
    }

    private function files()
    {
        $this->ajax_check();
        $search_value = $_POST['search']['value'];
        $display_columns = array('id', 'title_url', 'last_open_date', 'create_date');
        $search_columns = array('title');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'last_open_date';

        if($sort=='title_url'){
            $sort='title';
        }
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by = $sort . " " . $order;

        $where = array();
        if ($search_value != '') {
            $or_where = array();
            foreach ($search_columns as $key => $value)
                $or_where[$value . ' LIKE '] = "%$search_value%";
            $where = array('or_where' => $or_where);
        }
        $where['where'] = array('user_id' => $this->user_id);

        $table = "n_content_documents";
        $select = array("n_content_documents.*");
        $info = $this->basic->get_data($table, $where, $select, '', $limit, $start, $order_by, $group_by = '');
        $total_rows_array = $this->basic->count_row($table, $where, $count = $table . ".id", '', $group_by = '');
        $total_result = $total_rows_array[0]['total_rows'];

        $i = 0;
        $base_url = base_url();
        foreach ($info as $key => $value) {
            $info[$i]['title_url'] = '<a href="' . $base_url . 'n_generator/editor/' . $value['id'] . '">' . $value['title'] . '</a>';

            $info[$i]['title_url'] .= '<div class="row-actions">

            <span><a href="' . $base_url . 'n_generator/editor/' . $value['id'] . '">'.$this->lang->line('edit').'</a> | </span>
            ';

            $info[$i]['title_url'] .= '<span><a href="#" class="delete_document" data-id="'.$value['id'].'">'.$this->lang->line('delete').'</a></span>';

            $info[$i]['title_url'] .= '</div>';

            $i++;
        }


        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns, $start, $primary_key = "id");

        echo json_encode($data);
    }

    private function return_json($status, $message = '')
    {
        if (!empty($message)) {
            echo json_encode([
                'status' => $status,
                'message' => $this->lang->line($message),
            ]);
        } else {
            echo json_encode(['error' => $status]);
        }
        exit;
    }

    private function send_curl($endpoint, $data)
    {
        $data['ai_key'] = $this->n_gen_config['openai_api'];
        $data['domain'] = $this->getDomain();
        $data['purchase_code'] = $this->get_purchase_code();
        $data['user_id'] = $this->user_id;

        $data = json_encode($data);

        $ch = curl_init($this->url_api . '/' . $endpoint);
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
            $this->return_json('Something wrong. Please try again later.');
        }

        return $response;
    }

    private function add_to_history($data, $language, $doc_id, $action)
    {
        $insert_data = array();
        $insert_data['user_id'] = $this->user_id;
        $insert_data['ref_id'] = $data['insert_id'];
        $insert_data['vote'] = 'none';
        $insert_data['response'] = $data['text'];
        if(is_array($data['tokens'])){
            $insert_data['credits'] = $data['tokens']['total_tokens'];
        }else{
            $insert_data['credits'] = $data['tokens'];
        }
        $insert_data['action'] = $action;
        $insert_data['document_id'] = $doc_id;
        $insert_data['lang'] = $language;

        $insert_data['date'] = date("Y-m-d H:i:s");

        $this->basic->insert_data("n_content_history", $insert_data);
        return $this->db->insert_id();
    }

    private function vote()
    {
        $id = addslashes(strip_tags($this->input->post('id', true)));
        $feedback = addslashes(strip_tags($this->input->post('feedback', true)));

        $v_data = $this->basic->get_data('n_content_history', ['where' => ['id' => $id, 'user_id' => $this->user_id]]);

        if (!empty($v_data[0])) {

            if ($feedback == 'yes') {
                $feedback2 = 'up';
            } elseif ($feedback == 'no') {
                $feedback2 = 'down';
            } else {
                $feedback2 = 'none';
            }

            $update_data = array();
            $update_data['vote'] = $feedback2;

            $this->basic->update_data("n_content_history", array("id" => $id, "user_id" => $this->user_id), $update_data);

            $data = array();
            $data['ref_id'] = $v_data[0]['ref_id'];
            $data['feedback'] = $feedback;

            $this->send_curl('vote_rating', $data);
        }
        $this->return_json('ok', 'Voted');
    }

    private function generate()
    {
        $min = ($this->n_gen_config['cost_per1k_tokens'] / 2);
        if ($this->get_credits() <= $min) {
            $this->return_json("You don't have enough CreditsPoints");
            exit;
        }

        $this->form_validation->set_rules('action_api', '<b>' . $this->lang->line("action_api") . '</b>', 'trim');
        $this->form_validation->set_rules('textarea', '<b>' . $this->lang->line("textarea") . '</b>', 'trim');
        $this->form_validation->set_rules('doc_id', '<b>' . $this->lang->line("doc_id") . '</b>', 'trim');

        $this->form_validation->set_rules('language', '<b>' . $this->lang->line("language") . '</b>', 'trim');
        $this->form_validation->set_rules('creativity', '<b>' . $this->lang->line("creativity") . '</b>', 'trim');
        $this->form_validation->set_rules('tone', '<b>' . $this->lang->line("tone") . '</b>', 'trim');

        $this->form_validation->set_rules('textarea-c1', '<b>' . $this->lang->line("textarea_c1") . '</b>', 'trim');

        if ($this->form_validation->run() == false) {
            $this->return_json('Something wrong');
        } else {
            $action_api = addslashes(strip_tags($this->input->post('action_api', true)));
            $textarea = addslashes(strip_tags($this->input->post('textarea', true)));
            $doc_id = addslashes(strip_tags($this->input->post('doc_id', true)));

            $api_language = addslashes(strip_tags($this->input->post('language', true)));
            $creativity = addslashes(strip_tags($this->input->post('creativity', true)));
            $tone = addslashes(strip_tags($this->input->post('tone', true)));

            $textarea_c1 = addslashes(strip_tags($this->input->post('textarea_c1', true)));

            $data = array();
            $data['textarea'] = $textarea;

            if(isset($this->n_gen_config['engine']) and $this->n_gen_config['engine']==1) {
                $data['ai_engine'] = 'gpt4';
            }

            $data['language'] = $api_language;
            $data['creativity'] = $creativity;
            $data['tone'] = $tone;
            $data['textarea_c1'] = $textarea_c1;


            $resp = $this->send_curl($action_api, $data);

            $json_ar = json_decode($resp, true);


            if (!empty($json_ar['status']) and $json_ar['status'] == 'ok') {

                $hist_id = $this->add_to_history($json_ar['message'], $api_language, $doc_id, $action_api);

                $json_ar['message']['cp_update'] = $this->calc_tokens($json_ar['message']['tokens'], $json_ar['message']['engine_type']);
                unset($json_ar['message']['tokens']);
                $json_ar['message']['insert_id'] = $hist_id;

                $json_ar['message']['text'] = str_replace('Generated text is UNSAFE. This means that the text contains profane language, prejudiced or hateful language, something that could be NSFW, or text that portrays certain groups/people in a harmful manner.', $this->lang->line('Generated text is UNSAFE. This means that the text contains profane language, prejudiced or hateful language, something that could be NSFW, or text that portrays certain groups/people in a harmful manner.'), $json_ar['message']['text']);


            }

            echo json_encode($json_ar);
        }
    }

    public function fix_menu()
    {
        $sql_cust = "DELETE from `menu_child_1` where url like '%n_generator%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_generator%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%ultrapost%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'AI Content Generator', 'fas fa-robot', 'n_generator/', " . $parent_id_to_add['serial'] . ", '3230,3231,3232', '0', '0', '0', '0', '0', '', '0', '0')";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }
        echo 'done';
    }

    public function fix_charset()
    {
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }
        $sql = "ALTER TABLE `n_content_documents` CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_documents` CHANGE `text` `text` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `vote` `vote` ENUM('none','up','down') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `action` `action` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `response` `response` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `lang` `lang` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        echo 'DONE';
    }

    public function fix_charset_mb4()
    {
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }
        $sql = "ALTER TABLE `n_content_documents` CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_documents` CHANGE `text` `text` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `vote` `vote` ENUM('none','up','down') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `action` `action` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `response` `response` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        $sql = "ALTER TABLE `n_content_history` CHANGE `lang` `lang` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '';";
        $this->db->query($sql);

        echo 'DONE';
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
            0 => "ALTER TABLE `users` ADD `n_credits` INT(11) NOT NULL DEFAULT '0';",

            1 => "CREATE TABLE `n_content_documents` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL , `text` MEDIUMTEXT NOT NULL , `last_open_date` DATETIME NOT NULL , `create_date` DATETIME NOT NULL , UNIQUE (`id`));",

            2 => "CREATE TABLE `n_content_history` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL , `ref_id` INT(11) NOT NULL , `vote` ENUM('none','up','down') NOT NULL , `action` VARCHAR(255) NOT NULL , `response` TEXT NOT NULL , `credits` INT(11) NOT NULL , `document_id` INT(11) NOT NULL , `lang` VARCHAR(50) NOT NULL , `date` DATETIME NOT NULL , UNIQUE (`id`));",

            3 => "ALTER TABLE `users` ADD `n_content_settings` TEXT NOT NULL DEFAULT '';",

            4 => "ALTER TABLE `users` ADD `n_words` INT(11) NOT NULL DEFAULT '0';",

            5 => "ALTER TABLE `users` CHANGE `n_credits` `n_credits` FLOAT(11) NOT NULL DEFAULT '0';",

            6 => "ALTER TABLE `n_content_documents` ADD `title` VARCHAR(255) NOT NULL DEFAULT '';",

            7 => "ALTER TABLE `n_content_documents` CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",

            8 => "ALTER TABLE `n_content_documents` CHANGE `text` `text` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",

            9 => "ALTER TABLE `n_content_history` CHANGE `vote` `vote` ENUM('none','up','down') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;",

            10 => "ALTER TABLE `n_content_history` CHANGE `action` `action` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",

            11 => "ALTER TABLE `n_content_history` CHANGE `response` `response` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';",

            12 => "ALTER TABLE `n_content_history` CHANGE `lang` `lang` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';"

        );

        $sql_cust = "DELETE from `menu_child_1` where url like '%n_generator%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_generator%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%ultrapost%' ")->row_array();
        if (!$menu_exists) {

            $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'AI Content Generator', 'fas fa-robot', 'n_generator/', " . $parent_id_to_add['serial'] . ", '3230,3231,3232', '0', '0', '0', '0', '0', '', '0', '0')";
            $this->db->query($sql_cust);
        }

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
}