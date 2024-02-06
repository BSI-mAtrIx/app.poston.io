<?php
/*
Addon Name: Meta ADS Manager AI addon for Chatpion
Unique Name: n_adsmanager
Modules:
{
   "3300":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"Ads account",
      "module_name":"Meta Ads Manager"
   }
}
Project ID: 1109
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 0.612
Description: Meta ADS Manager AI
*/
require_once("application/controllers/Home.php"); // loading home controller
include(APPPATH . "modules/n_adsmanager/vendor/facebook/graph-sdk/src/Facebook/autoload.php");


class N_adsmanager extends Home
{
    public $key = "B0B0A7F8C2D580C2";
    private $product_id = "13";
    private $product_base = "n_adsmanager";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 0.612;
    /* @var self */
    private static $selfobj = null;
    public $fb;

    private $url_api = "https://api.nvxgroup.com/adsmanager_v4/api";
    private $n_gen_config = array();

    public $app_id = "";
    public $app_secret = "";
    public $user_access_token = "";
    public $network_id = "";
    public $net_id = "";
    public $token = "";
    public $current_ad_acc = "";


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

                   if($this->session->userdata('user_type') != 'Admin' && !in_array(3300,$this->module_access) )
                    {
                        redirect('home/login_page', 'location');
                        exit();
                    }

        }
        $this->load->library('encryption');

        $addon_lang = $this->product_base;
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '_' . $addon_lang . '_lang.php')) {
            $this->lang->load($this->language . '_' . $addon_lang . '_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        } else {
            $this->lang->load('english_' . $addon_lang . '_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '_' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($this->language . '_' . $addon_lang . '_custom_lang', '', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/');
        }

        if (is_dir(APPPATH . 'modules/'.$addon_lang.'/thirdn/')) {
            $path_unlink = FCPATH . "assets/".$addon_lang."/";
            if (is_dir($path_unlink)) {
                $this->delete_files($path_unlink);
            }
            @rename(APPPATH . "modules/".$addon_lang."/thirdn/", FCPATH . "assets/".$addon_lang."/");
        }

        if ($this->user_id != "") {
            $this->database_id = $this->session->userdata("fb_rx_login_database_id");
            $facebook_config = $this->basic->get_data("facebook_rx_config", array("where" => array("id" => $this->database_id)));
            if (isset($facebook_config[0])) {
                $this->app_id = $facebook_config[0]["api_id"];
                $this->app_secret = $facebook_config[0]["api_secret"];
                $this->user_access_token = $facebook_config[0]["user_access_token"];
            }
        }

        $this->fb = new Facebook\Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => 'v16.0',
        ]);

        include(APPPATH . 'modules/n_adsmanager/include/default_config.php');
        $this->n_config = $n_ad_config;

    }

    private function fb_connect(){
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = array(
            'ads_management',
            'ads_read',
            //'business_management',
            'read_insights'
        );
        $redirect_url = base_url('n_adsmanager/fb_connect_save');
        $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);

//        $this->return_json(
//            'ok',
//            array('url' => $loginUrl)
//        );

        return $loginUrl;
    }

    public function fb_connect_save()
    {
        // Define the callback status
        $check = 0;

        // Obtain the user access token from redirect
        $helper = $this->fb->getRedirectLoginHelper();

        // Get the user access token
        $access_token = $helper->getAccessToken(site_url('n_adsmanager/fb_connect_save'));

        // Convert it to array
        $access_token = (array)$access_token;

        // Get array value
        $access_token = array_values($access_token);

        if (isset($access_token[0])) {

            try {
                $response = $this->fb->get(
                    '/me/adaccounts?fields=name', //removed: ,business
                    $access_token[0]
                );
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                $this->view_main(
                    array('text' => 'Graph returned an error: ' . $e->getMessage())
                );
                return;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                $this->view_main(
                    array('text' => 'Facebook SDK returned an error: ' . $e->getMessage())
                );
                return;
            }

            $graphNode = $response->getGraphEdge();

            if ($graphNode->asArray()) {

                $accounts = $graphNode->asArray();

                foreach ($accounts as $account) {
                    $account_id = $account['id'];
                    $extra = '';
                    $account_name = $account['name'];
                    $this->add_network('fb_ad_account', $account_id, 1, $this->user_id, '', $access_token[0], '', $account_name, $extra);
                }

                $check = 1;
            } else {
                $check = 2;
            }

        }

        if ($check === 1) {
            redirect('n_adsmanager/?fb_action=all_ad_accounts_were_connected', 'location');
        } else if ($check === 2) {
            redirect('n_adsmanager/?fb_action=no_ad_accounts', 'location');
        } else {
            redirect('n_adsmanager/?fb_action=error_occurred', 'location');
        }
    }

    private function add_network($name, $net_id, $type, $user_id, $expires, $token, $secret, $user_name, $extra)
    {
        if(empty($secret)){$secret=NULL;}

        // First verify if the account was already added
        $this->db->select('network_id');
        $this->db->from('ads_networks');
        $this->db->where(array(
                'network_name' => strtolower($name),
                'net_id' => $net_id,
                'user_id' => $user_id,
                'type' => $type
            )
        );

        // Add new row
        $data = array(
            'network_name' => strtolower($name),
            'net_id' => $net_id,
            'user_id' => $user_id,
            'type' => $type,
            'user_name' => $user_name,
            'date' => date('Y-m-d h:i:s'),
            'expires' => $expires,
            'token' => $token,
            'extra' => $extra
        );

        if ($secret) {
            $data['secret'] = $secret;
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            unset($data['date']);
            $this->db->update('ads_networks', $data, array(
                    'net_id' => $net_id,
                    'user_id' => $user_id,
                )
            );
            $result = $query->result();
            return $result[0]->network_id;
        }



        $this->db->insert('ads_networks', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        } else {
            return false;
        }

    }

    private function get_networks($user_id, $type, $start, $limit, $key = NULL)
    {

        $this->db->select('*');
        $this->db->from('ads_networks');
        $this->db->where(array(
            'user_id' => $user_id,
            'type' => $type
        ));

        if ($key) {
            $key = $this->db->escape_like_str($key);
            $this->db->like('user_name', $key);
        }

        $this->db->order_by('network_id', 'desc');

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            if ($limit) {
                $results = $query->result_array();
                return $results;
            } else {
                return $query->num_rows();
            }
        } else {
            return false;
        }

    }

    private function get_account($network_id = 0, $try = 0)
    {

        $this->db->select('*');
        $this->db->from('ads_networks');

        if ($network_id != 0) {
            $this->db->where('network_id', $network_id);
        }
        $this->db->where('user_id', $this->user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            if($try==0){
                return $this->get_account(0, 1);
            }
            return false;
        }

    }

    private function load_countries()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));

        $js_ret = $this->send_curl('load_countries', array('search' => $search));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_custom_audience_select()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));

        $js_ret = $this->send_curl('load_custom_audience_select', array('search' => $search));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function activate_account()
    {
        //check for 2 days interval
//$this->current_ad_acc['active_expire']
//        if(){
//
//        }else{
//
//        }

        $js_ret = $this->send_curl('activate_account', array());
        $js_ret = json_decode($js_ret, true);

        if ($js_ret['status'] == 1) {
            $update_data = array('active_expire' => $js_ret['data']['active_expire']);
            $this->basic->update_data("ads_networks", array('user_id' => $this->user_id, 'network_id' => $this->network_id), $update_data);

            $this->return_json('ok', 'Ad account activated');
        } else {
            echo json_encode($js_ret);
        }

    }

    private function search_for_targeting_suggestions()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));
        $page = $this->input->post('page', true);

        $js_ret = $this->send_curl('search_for_targeting_suggestions', array('search' => $search, 'page' => $page));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_cities()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));
        $code = $this->input->post('region', true);

        $js_ret = $this->send_curl('load_cities', array('search' => $search, 'region' => $code));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_regions()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));
        $code = addslashes(strip_tags($this->input->post('code', true)));

        $js_ret = $this->send_curl('load_regions', array('search' => $search, 'code' => $code));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }


    private function stop_autorenew_account()
    {
        $js_ret = $this->send_curl('stop_autorenew_account', array());
        $js_ret = json_decode($js_ret, true);

        $update_data = array('auto_renew' => $js_ret['data']['auto_renew']);
        $this->basic->update_data("ads_networks", array('user_id' => $this->user_id, 'network_id' => $this->network_id), $update_data);

        $this->return_json('ok', "This account's auto renew has been disabled.");
    }

    private function change_account()
    {
        $ad_account_id = addslashes(strip_tags($this->input->post('ad_account', true)));

        $ad_acc = $this->get_account($ad_account_id);
        if (!empty($ad_acc[0])) {
            $this->session->set_userdata('n_selected_ad_acc', $ad_acc[0]['network_id']);
        }
        $this->return_json('ok', "Ad account changed.");
    }

    private function account_overview()
    {
        $period = addslashes(strip_tags($this->input->post('period', true)));

        $js_ret = $this->send_curl('account_overview', array("period" => $period));
        $js_ret = json_decode($js_ret, true);

        if($js_ret['status']==0){

        }else{
            $js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);
        }



        echo json_encode($js_ret);
    }

    private function load_campaigns_by_pagination()
    {
        $url = addslashes(strip_tags($this->input->post('url', true)));

        $js_ret = $this->send_curl('load_campaigns_by_pagination', array('url' => $url));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_ad_sets_by_pagination()
    {
        $url = addslashes(strip_tags($this->input->post('url', true)));

        $js_ret = $this->send_curl('load_ad_sets_by_pagination', array('url' => $url));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_ads_by_pagination()
    {
        $url = addslashes(strip_tags($this->input->post('url', true)));

        $js_ret = $this->send_curl('load_ads_by_pagination', array('url' => $url));

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_pixel_conversions_by_pagination()
    {
        $url = addslashes(strip_tags($this->input->post('url', true)));

        $js_ret = $this->send_curl('load_pixel_conversions_by_pagination', array('url' => $url));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function custom_audiences_list()
    {
        $url = addslashes(strip_tags($this->input->post('url', true)));

        $js_ret = $this->send_curl('custom_audiences_list', array('url' => $url));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function select_ad_campaign()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));

        $js_ret = $this->send_curl('select_ad_campaign', array('search' => $search));
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_select_ad_sets()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));
        $campaign_id = addslashes(strip_tags($this->input->post('params', true)));

        $data = array(
            'search' => $search,
            'campaign_id' => $campaign_id,
        );

        $js_ret = $this->send_curl('load_select_ad_sets', $data);
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function select_facebook_campaign()
    {
        $campaign_id = addslashes(strip_tags($this->input->post('campaign_id', true)));

        $data = array(
            'campaign_id' => $campaign_id,
        );

        $js_ret = $this->send_curl('select_facebook_campaign', $data);
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        if (isset($js_ret['status']) and $js_ret['status'] == 'false_alert') {
            $js_ret['message'] = $this->lang->line($js_ret['message']);
        }
        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_account_pages()
    {

        $search = addslashes(strip_tags($this->input->post('search', true)));

        $data = array(
            'search' => $search,
        );

        $js_ret = $this->send_curl('load_account_pages', $data);
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

//        if($js_ret['status']=='false_alert'){
//            $js_ret['message'] = $this->lang->line($js_ret['message']);
//        }
        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function create_facebook_campaign()
    {

        $name = addslashes(strip_tags($this->input->post('ads_crt_campaign_name', true)));
        $objective = addslashes(strip_tags($this->input->post('ads_crt_campaign_objective', true)));
        $status = addslashes(strip_tags($this->input->post('ads_crt_campaign_status', true)));
        $special_ad_category = addslashes(strip_tags($this->input->post('ads_crt_campaign_special', true)));

        $cpg_start_time = addslashes(strip_tags($this->input->post('cpg_start_time', true)));
        $cpg_end_time = addslashes(strip_tags($this->input->post('cpg_end_time', true)));

        if (empty($name)) {
            $message_js = $this->lang->line('Field "name" cannot be empty.');
            $this->return_json($message_js);
        }

        $data = array(
            'name' => $name,
            'objective' => $objective,
            'status' => $status,
            'special_ad_category' => $special_ad_category,
            'cpg_start_time' => $cpg_start_time,
            'cpg_end_time' => $cpg_end_time,
        );



        $js_ret = $this->send_curl('create_facebook_campaign', $data);

        $js_ret = json_decode($js_ret, true);

        if($js_ret['message']['success']==FALSE) {
            $js_ret['message']['message'] = $this->lang->line($js_ret['message']['message']);
            $js_ret['message']['description'] = $this->lang->line($js_ret['message']['description']);
        }
        echo json_encode($js_ret);
    }

    private function create_facebook_adset()
    {

        $selected_placements = array();

        $this->form_validation->set_rules('adset_select_ad_campaign', 'Campaign ID', 'trim|required');

        $this->form_validation->set_rules('ads_adset_name', 'Ad Set Name', 'trim');
        $this->form_validation->set_rules('ad_objective', 'Ad Objective', 'trim');
        $this->form_validation->set_rules('ads_campaign_optimization_goal', 'Optimization Goal', 'trim');
        $this->form_validation->set_rules('billing_event_description', 'Billing Event', 'trim');
        $this->form_validation->set_rules('ad_set_placement_facebook_feeds', 'Placements', 'trim');
        $this->form_validation->set_rules('ad_set_placement_instagram_feed', 'Placements', 'trim');
        $this->form_validation->set_rules('ad_set_placement_messenger_inbox', 'Placements', 'trim');

        $this->form_validation->set_rules('ads_adset_target_cost', 'Target Cost', 'trim');
        $this->form_validation->set_rules('ads_adset_daily_budget', 'Daily Budget', 'trim');

        $this->form_validation->set_rules('ad_set_default_country', 'Countries', 'trim');
        $this->form_validation->set_rules('select_regions', 'Regions', '');
        $this->form_validation->set_rules('select_cities', 'Cities', '');

        $this->form_validation->set_rules('ads_campaign_age_from_list', 'Age From', 'trim');
        $this->form_validation->set_rules('ads_campaign_age_to_list', 'Age To', 'trim');

        $this->form_validation->set_rules('ads_campaign_ad_genders', 'Gender', '');

        $this->form_validation->set_rules('ads_campaign_select_type', 'Device Type', '');

        $this->form_validation->set_rules('ad_set_custom_audience_exclude_list', 'Age From', 'trim');
        $this->form_validation->set_rules('ad_set_custom_audience_include_list', 'Age To', 'trim');

        $this->form_validation->set_rules('adset_start_time', 'Age From', 'trim');
        $this->form_validation->set_rules('adset_end_time', 'Age To', 'trim');

        $this->form_validation->set_rules('ad_set_status', 'ad_set_status', 'trim');
        $this->form_validation->set_rules('ads_adset_daily_budget_set', 'ads_adset_daily_budget_set', 'trim');
        $this->form_validation->set_rules('ads_adset_lifetime_budget', 'ads_adset_lifetime_budget', 'trim');

        //$this->form_validation->set_rules('adset_creation_filter_fb_pages', 'Adset Facebook Page ID', 'trim');

        if (($this->form_validation->run() !== false)) {

            $campaign_id = addslashes(strip_tags($this->input->post('adset_select_ad_campaign', true)));
            $ad_objective = addslashes(strip_tags($this->input->post('ad_objective', true)));

            $ad_set_name = addslashes(strip_tags($this->input->post('ads_adset_name', true)));

            $optimization_goal = addslashes(strip_tags($this->input->post('ads_campaign_optimization_goal', true)));
            $billing_event = addslashes(strip_tags($this->input->post('billing_event_description', true)));

            $ad_set_placement_facebook_feeds = addslashes(strip_tags($this->input->post('ad_set_placement_facebook_feeds', true)));
            $ad_set_placement_instagram_feed = addslashes(strip_tags($this->input->post('ad_set_placement_instagram_feed', true)));
            $ad_set_placement_messenger_inbox = addslashes(strip_tags($this->input->post('ad_set_placement_messenger_inbox', true)));

            $selected_placements[] = $ad_set_placement_facebook_feeds;
            $selected_placements[] = $ad_set_placement_instagram_feed;
            $selected_placements[] = $ad_set_placement_messenger_inbox;

            $target_cost = addslashes(strip_tags($this->input->post('ads_adset_target_cost', true)));
            $daily_budget = addslashes(strip_tags($this->input->post('ads_adset_daily_budget', true)));
            $countries = addslashes(strip_tags($this->input->post('ad_set_default_country', true)));

            $select_regions = $this->input->post('select_regions', true);
            $select_cities = $this->input->post('select_cities', true);

            $gender = $this->input->post('ads_campaign_ad_genders', true);
            $age_from = addslashes(strip_tags($this->input->post('ads_campaign_age_from_list', true)));
            $age_to = addslashes(strip_tags($this->input->post('ads_campaign_age_to_list', true)));

            $ads_campaign_select_type = $this->input->post('ads_campaign_select_type', true);

            $adset_fb_page_id_strip = $this->input->post('adset_creation_filter_fb_pages', true);

            $adset_fb_page_id = '';
            if(!empty($adset_fb_page_id_strip)){
                $adset_fb_page_id = addslashes(strip_tags($adset_fb_page_id_strip));
            }

            $interest_suggestions = $this->input->post('search_for_targeting_suggestions', true);

            $ad_set_custom_audience_exclude_list = addslashes(strip_tags($this->input->post('ad_set_custom_audience_exclude_list', true)));
            $ad_set_custom_audience_include_list = addslashes(strip_tags($this->input->post('ad_set_custom_audience_include_list', true)));

            $adset_start_time = addslashes(strip_tags($this->input->post('adset_start_time', true)));
            $adset_end_time = addslashes(strip_tags($this->input->post('adset_end_time', true)));

            $ad_set_status = addslashes(strip_tags($this->input->post('ad_set_status', true)));
            $ads_adset_daily_budget_set = addslashes(strip_tags($this->input->post('ads_adset_daily_budget_set', true)));
            $ads_adset_lifetime_budget = addslashes(strip_tags($this->input->post('ads_adset_lifetime_budget', true)));

            if (empty($ad_set_name)) {
                $message_js = $this->lang->line('Field "name" cannot be empty.');
                $this->return_json($message_js);
            }

            // Verify if ad sets placements are selected
            if (empty($selected_placements)) {

//            $response[] = array(
//                'success' => FALSE,
//                'message' => $this->CI->lang->line('no_ad_set_placement_selected'),
//                'description' => $this->CI->lang->line('select_at_least_one_placement')
//            );

                $message_js = $this->lang->line('no_ad_set_placement_selected');
                $this->return_json($message_js);

            }

            $data = array(
                'name' => $ad_set_name,
                'optimization_goal' => $optimization_goal,
                'billing_event' => $billing_event,
                'target_cost' => $target_cost,
                'daily_budget' => $daily_budget,
                'countries' => $countries,
                'regions' => $select_regions,
                'cities' => $select_cities,
                'campaign_id' => $campaign_id,
                'selected_placements' => $selected_placements,
                'age_from' => $age_from,
                'age_to' => $age_to,
                'genders' => $gender,
                'device_type' => $ads_campaign_select_type,
                'adset_fb_page_id' => $adset_fb_page_id,
                'objective' => $ad_objective,
                'ad_set_custom_audience_exclude_list' => $ad_set_custom_audience_exclude_list,
                'ad_set_custom_audience_include_list' => $ad_set_custom_audience_include_list,
                'adset_start_time' => $adset_start_time,
                'adset_end_time' => $adset_end_time,

                'ad_set_status' => $ad_set_status,
                'ads_adset_daily_budget_set' => $ads_adset_daily_budget_set,
                'ads_adset_lifetime_budget' => $ads_adset_lifetime_budget,
            );


            if ($interest_suggestions) {
                $data['interest_suggestions'] = $interest_suggestions;
            }

            $js_ret = $this->send_curl('create_adsets', $data);

            $js_ret = json_decode($js_ret, true);

            if (!empty($js_ret['message']['description'])) {
                $js_ret['message']['description'] = $this->lang->line($js_ret['message']['description']);
                $js_ret['message']['message'] = $this->lang->line($js_ret['message']['message']);
                $js_ret['message']['message'] = $this->lang->line($js_ret['message']['message']);
            }

            echo json_encode($js_ret);
        } else {

            $message_js = $this->lang->line('ad_set_not_created_successfully');
            $this->return_json($message_js);
        }
    }

    private function load_posts_for_boosting()
    {

        $selected_placements = array();

        $this->form_validation->set_rules('network', 'network', 'trim|required');
        $this->form_validation->set_rules('key', 'key', 'trim');
        $this->form_validation->set_rules('page_id', 'page_id', 'trim');



        if (($this->form_validation->run() !== false)) {

            $network = addslashes(strip_tags($this->input->post('network', true)));
            $key = addslashes(strip_tags($this->input->post('key', true)));

            $page_id = addslashes(strip_tags($this->input->post('page_id', true)));


            $data = array(
                'network' => $network,
                'key' => $key,
                'page_id' => $page_id,
            );


            $js_ret = $this->send_curl('load_posts_for_boosting', $data);

            $js_ret = json_decode($js_ret, true);

            if (!empty($js_ret['message']['message'])) {
                //$js_ret['message']['description'] = $this->lang->line($js_ret['message']['description']);
                $js_ret['message']['message'] = $this->lang->line($js_ret['message']['message']);
                //$js_ret['message']['message'] = $this->lang->line($js_ret['message']['message']);
            }

            echo json_encode($js_ret);
        } else {

            $message_js = $this->lang->line('no_posts_fond');
            $this->return_json($message_js);
        }
    }


    private function upload_image_ad_api($data)
    {
        $js_ret = $this->send_curl('upload_image_ad_api', $data);

        $js_ret = json_decode($js_ret, true);

        return $js_ret;
    }


    public function index()
    {
        $this->view_main();
    }

    public function view_main($info_msg = null){
        $data = array();

        if(!empty($_GET['action'])) {
            switch ($_GET['action']) {
                case 'admin_save_settings';
                    if ($this->session->userdata('user_type') == "Admin") {
                        if ($this->save_config()) {
                            $data['n_info']['message'] = $this->lang->line('Settings saved');
                            $data['n_info']['status'] = 'success';
                        } else {
                            $data['n_info']['message'] = $this->lang->line('Something wrong');
                            $data['n_info']['status'] = 'danger';
                        }
                    }
                    break;
            }
        }


        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'main_view';
        $data['page_title'] = $this->lang->line('Meta ADS Manager');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');

        $data['n_ad_config'] = $this->n_config;

        $data['info_msg'] = $info_msg;


        $data['login_to_fb_url'] = $this->fb_connect();

        $data['ad_acc'] = $this->get_networks($this->user_id, 1, '', 9999, '');

        if (empty($this->session->userdata('n_selected_ad_acc'))) {
            if (!empty($data['ad_acc'][0]['network_id'])) {
                $this->session->set_userdata('n_selected_ad_acc', $data['ad_acc'][0]['network_id']);
            }
        }

        if (!empty($this->session->userdata('n_selected_ad_acc'))) {
            $data['current_ad_acc'] = $this->get_account($this->session->userdata('n_selected_ad_acc'));
        } else {
            $data['current_ad_acc'] = $this->get_account(0);
        }

        if (empty($data['current_ad_acc'])) {
            $data['current_ad_acc'] = 0;
        } else {
            $data['current_ad_acc'] = $data['current_ad_acc'][0];
            $this->session->set_userdata('n_selected_ad_acc', $data['current_ad_acc']['network_id']);
            $this->network_id = $data['current_ad_acc']['network_id'];
            $this->net_id = $data['current_ad_acc']['net_id'];
            $this->token = $data['current_ad_acc']['token'];
        }

        $data['content_generator'] = 'false';
        if(file_exists(APPPATH.'modules/n_generator/controllers/N_generator.php')){
            $data['content_generator'] = 'true';
        }
        if($data['content_generator']=='true'){
            $data['sdk_locale'] = $this->sdk_locale();
            $data['config_sdk_locale'] = 'en_US';
            $data['config_creativity'] = 'Optimal';
            $data['config_tone'] = 'Passionate';

            $json = $this->gen_get_user_config();
            if (!empty($json)) {
                $data['config_sdk_locale'] = $json['language'];
                $data['config_creativity'] = $json['creativity'];
                $data['config_tone'] = $json['tone'];
                $data['config_autosave'] = $json['autosave'];
            }
        }

        $this->_viewcontroller($data);
    }

    private function gen_get_user_config()
    {
        if (!empty($this->session->userdata("n_content_settings"))) {
            return json_decode($this->session->userdata("n_content_settings"), true);
        } else {
            $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);

            return json_decode($user_info[0]['n_content_settings'], true);
        }
    }

    private function display_error()
    {

    }

    private function save_config()
    {
        if(empty($_POST)){return false;}
        $this->csrf_token_check();

        $this->form_validation->set_rules('ads_image_size', '<b>' . $this->lang->line("ads_image_size") . '</b>', 'trim');
        $this->form_validation->set_rules('ads_video_size', '<b>' . $this->lang->line("ads_video_size") . '</b>', 'trim');

        if ($this->form_validation->run() == false) {
            return false;
        } else {
            $ads_image_size = addslashes(strip_tags($this->input->post('ads_image_size', true)));
            $ads_video_size = addslashes(strip_tags($this->input->post('ads_video_size', true)));

            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_ad_config['ads_image_size'] = '$ads_image_size';\n";
            $app_my_config_data .= "\$n_ad_config['ads_video_size'] = '$ads_video_size';\n";

            file_put_contents(APPPATH . 'n_adsmanager_config.php', $app_my_config_data, LOCK_EX);

            include(APPPATH . 'modules/n_adsmanager/include/default_config.php');
            $this->n_config = $n_ad_config;

            return true;
        }


    }

    private function get_purchase_code()
    {
        $xdata = $this->basic->get_data("nvx_addons", array("where" => array("name" => 'n_adsmanager')));
        if (!isset($xdata[0])) exit();

        return $xdata[0]['code'];
    }

    public function config()
    {
        exit;
        if ($this->session->userdata('user_type') != 'Admin') {
            redirect('home/login_page', 'location');
        }

        $data = array();
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'config';
        $data['page_title'] = $this->lang->line('Content Generator');
        $data['credits'] = $this->get_credits();

        $data['cost_per1k_tokens'] = '600';

        if (file_exists(APPPATH . 'n_generator_config.php')) {
            include(APPPATH . 'n_generator_config.php');
            $data['cost_per1k_tokens'] = $n_gen_config['cost_per1k_tokens'];
        }

        if ($_POST) {
            $return_save = $this->save_config($n_gen_config);
            if (is_int($return_save)) {
                $data['cost_per1k_tokens'] = $return_save;
            }
        }

        $data['openai_api'] = '*****';

        $this->session->set_flashdata('success_message', 1);
        $this->_viewcontroller($data);
    }

    public function api($endpoint, $cust_1 = 0)
    {
        $this->csrf_token_check();
        if (!$this->input->is_ajax_request()) {
            $this->return_json('Bad Request');
        }

        if (!empty($this->session->userdata('n_selected_ad_acc'))) {
            $data['current_ad_acc'] = $this->get_account($this->session->userdata('n_selected_ad_acc'));
            $data['current_ad_acc'] = $data['current_ad_acc'][0];

            $this->current_ad_acc = $data['current_ad_acc'];
            $this->network_id = $data['current_ad_acc']['network_id'];
            $this->net_id = $data['current_ad_acc']['net_id'];
            $this->token = $data['current_ad_acc']['token'];

        } else {
            $this->return_json('Bad Request');
        }

//        if(file_exists(APPPATH.'n_generator_config.php')){
//            include(APPPATH.'n_generator_config.php');
//            $this->n_gen_config = $n_gen_config;
//        }else{
//            $this->return_json('Not found configuration. Please contact with administration.');
//            exit;
//        }
        //$n_gen_config['cost_per1k_tokens'];
        switch ($endpoint) {
            case 'activate_account';
                $this->activate_account();
                break;
            case 'stop_autorenew_account';
                $this->stop_autorenew_account();
                break;
            case 'change_account';
                $this->change_account();
                break;
            case 'account_overview';
                $this->account_overview();
                break;
            case 'load_campaigns_by_pagination';
                $this->load_campaigns_by_pagination();
                break;
            case 'load_ad_sets_by_pagination';
                $this->load_ad_sets_by_pagination();
                break;
            case 'load_ads_by_pagination';
                $this->load_ads_by_pagination();
                break;
            case 'load_pixel_conversions_by_pagination';
                $this->load_pixel_conversions_by_pagination();
                break;
            case 'select_ad_campaign';
                $this->select_ad_campaign();
                break;
            case 'load_select_ad_sets';
                $this->load_select_ad_sets();
                break;
            case 'select_facebook_campaign';
                $this->select_facebook_campaign();
                break;
            case 'load_account_pages';
                $this->load_account_pages();
                break;
            case 'create_facebook_campaign';
                $this->create_facebook_campaign();
                break;
            case 'load_countries';
                $this->load_countries();
                break;
            case 'load_regions';
                $this->load_regions();
                break;
            case 'load_cities';
                $this->load_cities();
                break;

            case 'save_user_config';
                $this->save_user_config();
                break;

            case 'search_for_targeting_suggestions';
                $this->search_for_targeting_suggestions();
                break;

            case 'create_facebook_adset';
                $this->create_facebook_adset();
                break;

            case 'create_pixel_conversion';
                $this->create_pixel_conversion();
                break;

            case 'load_all_pixel_coversions';
                $this->load_all_pixel_coversions();
                break;

            case 'load_coversions_by_id';
                $this->load_coversions_by_id();
                break;

            case 'load_account_fb';
                $this->load_account_fb();
                break;

            case 'create_facebook_campaign_ad';
                $this->create_facebook_campaign_ad();
                break;

            case 'set_token_for_user_id';
                $this->set_token_for_user_id();
                break;

            case 'generate_preview_ad';
                $this->generate_preview_ad();
                break;

            case 'load_posts_for_boosting';
                $this->load_posts_for_boosting();
                break;

            case 'account_currency';
                $this->account_currency();
                break;

            case 'load_postback_message';
                $this->load_postback_message();
                break;

            case 'custom_audiences_list';
                $this->custom_audiences_list();
                break;

            case 'load_custom_audience_select';
                $this->load_custom_audience_select();
                break;

            case 'custom_audience_bot_select_source';
                $this->custom_audience_bot_select_source();
                break;

            case 'ads_custom_audience_source_labels';
                $this->ads_custom_audience_source_labels();
                break;

            case 'create_custom_audience_batch';
                $this->create_custom_audience_batch();
                break;

            case 'update_status';
                $this->update_status();
                break;

            default;
                $this->return_json('Bad Request');
                break;
        }
    }

    private function update_status()
    {
        $type = $this->input->post('type', true);
        $id = $this->input->post('ad_id', true);
        $status = $this->input->post('status', true);  //paused or active

        $data = array(
            'type' => $type,
            'ad_id' => $id,
            'status' => $status,
        );

        $js_ret = $this->send_curl('update_status', $data);

        $js_ret = json_decode($js_ret, true);

        echo json_encode($js_ret);
    }

    private function create_custom_audience_batch(){
        $audience_source = $this->input->post('audience_source');
        $bot_source = $this->input->post('bot_source');
        $bot_labels = $this->input->post('bot_labels');
        $fb_data = $this->input->post('fb_data');
        $audience_id = $this->input->post('audience_id');
        $ads_custom_audience_name = $this->input->post('ads_custom_audience_name');
        $ads_custom_audience_description = $this->input->post('ads_custom_audience_description');
		$audience_data = $this->input->post('audience_data');


        $session_id = time();
        $batch_seq = 1;
        $last_batch_flag = false;
        $progress = 'batch_resume'; //or done
        $custom_audience_id = null;
        $start_id = 0;
        $last_id = 0;
        $max_data_per_request = 500;
		$num_received_total = 0;

        if(!empty($fb_data['last_id'])){
            $last_id = $fb_data['last_id'];
            $custom_audience_id = $audience_data['custom_audience_id'];
			$num_received_total = $fb_data['num_received_total'];
			$batch_seq = $fb_data['session']['batch_seq'];
			$session_id = $fb_data['session']['session_id'];
			$start_id = $fb_data['last_id'];
		}


        switch($audience_source){
            case 'messenger_subscribers_id':

                $page_id = $bot_source;
                $label_id = $bot_labels;

                $start = $start_id;
                $limit = $max_data_per_request;
                $order_by='id asc';

                $where_custom="messenger_bot_subscriber.user_id = ".$this->user_id." AND facebook_rx_fb_user_info_id = ".$this->session->userdata('facebook_rx_fb_user_info');


                $join = array(
                    'facebook_rx_fb_page_info'=>"facebook_rx_fb_page_info.id=messenger_bot_subscriber.page_table_id,left"
                );

//                if($social_media=='ig') $this->db->where('social_media', 'ig');
//                else
                $this->db->where('social_media !=', 'ig');
                if($page_id!=""){
                    $this->db->where("page_table_id", $page_id);
                }
                // if($label_id!="") $this->db->where("FIND_IN_SET('$label_id',messenger_bot_subscriber.contact_group_id) !=", 0);
                $join['messenger_bot_subscribers_label'] = "messenger_bot_subscriber.id=messenger_bot_subscribers_label.subscriber_table_id,left";

                if($label_id != 'all' AND $label_id != '' ){
                    $this->db->where('messenger_bot_subscribers_label.contact_group_id',$label_id);
                }

                $table="messenger_bot_subscriber";
                $select = "messenger_bot_subscriber.*,page_name,insta_username,GROUP_CONCAT(messenger_bot_subscribers_label.contact_group_id separator ',') as single_contact_table_id";

                $this->db->where($where_custom);
				$this->db->where('messenger_bot_subscriber.id >', $start_id); 
				
                $info=$this->basic->get_data($table,$where='',$select,$join,$limit,0,$order_by,$group_by='messenger_bot_subscriber.id');



                $this->db->where($where_custom);

//                if($social_media=='ig') $this->db->where('social_media', 'ig');
//                else
                $this->db->where('social_media !=', 'ig');


                if($label_id!="all"){
                    $this->db->where('messenger_bot_subscribers_label.contact_group_id',$label_id);
                }
                if($page_id!=""){
                    $this->db->where("page_table_id", $page_id);
                }
                $total_rows_array=$this->basic->count_row($table,$where='',$count=$table.".id",$join,'','','',$group_by='messenger_bot_subscriber.id');

                $total_result=$total_rows_array[0]['total_rows'];

                if(!empty($info)) {
                    $payload = array();
                    $payload['schema'] = array('PAGEUID');
					$payload['is_raw'] = true;
					$payload['page_ids'] = array($page_id);
					$payload['data'] = array();

                    foreach($info as $k => $v){
                        $payload['data'][] = array($v['subscribe_id']);

						$payload['page_ids'] = array($v['page_id']);
                        $last_id = $v['id'];
                    }

                    if(count($payload['data']) < $max_data_per_request){
                        $last_batch_flag = true;
                        $progress = 'done';
                    }
                }else{
                    $data = array(
                        'error' => $this->lang->line('Subscribers not found for selected data.')
                    );

                    echo json_encode($data);
                    exit;
                }

                break;
            case 'whatsapp_phone_numbers':
                if(file_exists(APPPATH.'modules/n_wa/controllers/N_wa.php')){
                    $where = array(
                        'user_id' => $this->user_id,
                        'id' => $bot_source
                    );
                    $page_access = $this->basic->get_data("n_wa_bots",
                        array("where" => $where),
                        '',
                        '',
                        1
                    );

                    if(!empty($page_access[0])){

                        $where = array(
                            'phone !=' => '',
                        );
                        if(!empty($bot_labels) AND $bot_labels!='all' AND $bot_labels!=''){
                            $this->db->where('labels like ', '\'%"'.$bot_labels.'"%\' ', false);
                        }

                        $info = $this->basic->count_row("nwa_".$bot_source."_user",
                            array("where" => $where),
                            '',
                            ''
                        );

                        $total_result=$info[0]['total_rows'];

                        $where = array(
                            'phone !=' => '',
                            'id >' => $start_id
                        );
                        if(!empty($bot_labels) AND $bot_labels!='all' AND $bot_labels!=''){
                            $this->db->where('labels like ', '\'%"'.$bot_labels.'"%\' ', false);
                        }

                        $info = $this->basic->get_data("nwa_".$bot_source."_user",
                            array("where" => $where),
                            '',
                            ''
                        );

                        if(!empty($info)) {
                            $payload = array();
                            $payload['schema'] = array('PHONE_SHA256');
                            $payload['data'] = array();

                            foreach($info as $k => $v){
                                $phone_number = str_replace('+', '', $v['phone']);
                                $phone_number = ltrim($phone_number, "0");
                                $payload['data'][] = array(hash("sha256", $phone_number));

                                $last_id = $v['id'];
                            }

                            if(count($payload['data']) < $max_data_per_request){
                                $last_batch_flag = true;
                                $progress = 'done';
                            }
                        }else{
                            $data = array(
                                'error' => $this->lang->line('Subscribers not found for selected data.')
                            );

                            echo json_encode($data);
                            exit;
                        }
                    }
                }
                break;
            case 'telegram_phone_numbers':
                if(file_exists(APPPATH.'modules/n_telegram/controllers/N_telegram.php')) {
                    $where = array(
                        'user_id' => $this->user_id,
                        'id' => $bot_source
                    );
                    $page_access = $this->basic->get_data("n_telegram_bots",
                        array("where" => $where),
                        '',
                        '',
                        1
                    );

                    if(!empty($page_access[0])){

                        $where = array(
                            'n_phone !=' => '',
                        );
                        if(!empty($bot_labels) AND $bot_labels!='all' AND $bot_labels!=''){
                            $this->db->where('labels like ', '\'%"'.$bot_labels.'"%\' ', false);
                        }

                        $info = $this->basic->count_row("nt_".$bot_source."_user",
                            array("where" => $where),
                            '',
                            ''
                        );

                        $total_result=$info[0]['total_rows'];

                        $where = array(
                            'n_phone !=' => '',
                            'id >' => $start_id
                        );
                        if(!empty($bot_labels) AND $bot_labels!='all' AND $bot_labels!=''){
                            $this->db->where('labels like ', '\'%"'.$bot_labels.'"%\' ', false);
                        }

                        $info = $this->basic->get_data("nt_".$bot_source."_user",
                            array("where" => $where),
                            '',
                            ''
                        );

                        if(!empty($info)) {
                            $payload = array();
                            $payload['schema'] = array('PHONE_SHA256');
                            $payload['data'] = array();

                            foreach($info as $k => $v){
                                $phone_number = str_replace('+', '', $v['n_phone']);
                                $phone_number = ltrim($phone_number, "0");
                                $payload['data'][] = array(hash("sha256", $phone_number));

                                $last_id = $v['id'];
                            }

                            if(count($payload['data']) < $max_data_per_request){
                                $last_batch_flag = true;
                                $progress = 'done';
                            }
                        }else{
                            $data = array(
                                'error' => $this->lang->line('Subscribers not found for selected data.')
                            );

                            echo json_encode($data);
                            exit;
                        }
                    }
                }
                break;
            default:
                break;
        }

            $data = array(
                'data' => $payload,
                'fb_data' => array(
                    'session' => array(
                        "session_id" => $session_id,
                        "batch_seq" => $batch_seq, //from 1
                        "last_batch_flag" => $last_batch_flag, // if last true
                        "estimated_num_total" => count($payload['data']) // optional
                    ),
                    'last_id' => $last_id,
					'total_data' => $total_result,
					'num_received_total' => $num_received_total,
                ),
                'audience_data' => array(
                    'custom_audience_id' => $custom_audience_id,
                    'ads_custom_audience_name' => $ads_custom_audience_name,
                    'ads_custom_audience_description' => $ads_custom_audience_description
                ),
                'progress' => $progress
            );

            $js_ret = $this->send_curl('create_custom_audience_batch', $data);
           
			echo $js_ret;
    }

    private function ads_custom_audience_source_labels(){
        $params = $this->input->post('params');
        $search = $this->input->post('search');

        $postbacks_data = array();
        $postbacks_data[] = array(
            'id' => 'all',
            'text' => $this->lang->line('ALL')
        );


        switch($params['audience_source']){
            case 'messenger_subscribers_id':
                $where = array(
                    "user_id" => $this->user_id,
					"page_id" => $params['bot_source'],
                    "invisible" => '0'
                );
                if(!empty($search)){
                    $where['group_name'] = '%'.$search.'%';
                }

                $page_ci_id = $this->basic->get_data("messenger_bot_broadcast_contact_group",
                    array("where" => $where),
                    '',
                    '',
                    30
                );
                if(!empty($page_ci_id)) {
                    foreach ($page_ci_id as $k => $v) {
                        $postbacks_data[] = array(
                            'id' => $v['id'],
                            'text' => $v['group_name']
                        );
                    }
                }

                break;
            case 'whatsapp_phone_numbers':
                if(file_exists(APPPATH.'modules/n_wa/controllers/N_wa.php')){
                    $where = array(
                        'user_id' => $this->user_id,
                        'id' => $params['bot_source']
                    );
                    $page_access = $this->basic->get_data("n_wa_bots",
                        array("where" => $where),
                        '',
                        '',
                        1
                    );
                    if(!empty($page_access[0])){
                        $where = array(

                        );
                        if(!empty($search)){
                            $where['label_name'] = '%'.$search.'%';
                        }
                        $page_ci_id = $this->basic->get_data("nwa_".$params['bot_source']."_labels",
                            array("where" => $where),
                            '',
                            '',
                            30
                        );
                        if(!empty($page_ci_id)) {
                            foreach ($page_ci_id as $k => $v) {
                                $postbacks_data[] = array(
                                    'id' => $v['id'],
                                    'text' => $v['label_name']
                                );
                            }
                        }
                    }

                }
                break;
            case 'telegram_phone_numbers':
                if(file_exists(APPPATH.'modules/n_telegram/controllers/N_telegram.php')) {
                    $where = array(
                        'user_id' => $this->user_id,
                        'id' => $params['bot_source']
                    );
                    $page_access = $this->basic->get_data("n_telegram_bots",
                        array("where" => $where),
                        '',
                        '',
                        1
                    );
                    if (!empty($page_access[0])) {
                        $where = array();
                        if (!empty($search)) {
                            $where['label_name'] = '%' . $search . '%';
                        }
                        $page_ci_id = $this->basic->get_data("nt_" . $params['bot_source'] . "_labels",
                            array("where" => $where),
                            '',
                            '',
                            30
                        );
                        if (!empty($page_ci_id)) {
                            foreach ($page_ci_id as $k => $v) {
                                $postbacks_data[] = array(
                                    'id' => $v['id'],
                                    'text' => $v['label_name']
                                );
                            }
                        }
                    }
                }
                break;
            default:
                break;
        }


        $data = array(
            'success' => TRUE,
            'message' => array(
                'select' => array('data' => $postbacks_data)
            )
        );

        echo json_encode($data);
    }

    private function custom_audience_bot_select_source(){
        $params = $this->input->post('params');
        $search = $this->input->post('search');

        $postbacks_data = array();

        $data = array(
            'success' => TRUE,
            'message' => array(
                'select' => array('data' => '')
            ),
        );

        switch($params['audience_source']){
            case 'messenger_subscribers_id':

                $where = array(
                    "user_id" => $this->user_id,
                );
                if(!empty($search)){
                    $where['page_name'] = '%'.$search.'%';
                }
                $page_ci_id = $this->basic->get_data("facebook_rx_fb_page_info",
                    array("where" => $where),
                    '',
                    '',
                    30
                );
                if(!empty($page_ci_id)) {
                    foreach ($page_ci_id as $k => $v) {
                        $postbacks_data[] = array(
                            'id' => $v['id'],
                            'text' => $v['page_name']
                        );
                    }
                }

                break;
            case 'whatsapp_phone_numbers':
                if(file_exists(APPPATH.'modules/n_wa/controllers/N_wa.php')){
                    $where = array(
                        "user_id" => $this->user_id,
                    );
                    if(!empty($search)){
                        $where['number_phone'] = '%'.$search.'%';
                    }
                    $page_ci_id = $this->basic->get_data("n_wa_bots",
                        array("where" => $where),
                        '',
                        '',
                        30
                    );
                    if(!empty($page_ci_id)) {
                        foreach ($page_ci_id as $k => $v) {
                            $postbacks_data[] = array(
                                'id' => $v['id'],
                                'text' => $v['number_phone']
                            );
                        }
                    }
                }
                break;
            case 'telegram_phone_numbers':
                if(file_exists(APPPATH.'modules/n_telegram/controllers/N_telegram.php')){
                    $where = array(
                        "user_id" => $this->user_id,
                    );
                    if(!empty($search)){
                        $where['bot_name'] = '%'.$search.'%';
                    }
                    $page_ci_id = $this->basic->get_data("n_telegram_bots",
                        array("where" => $where),
                        '',
                        '',
                        30
                    );
                    if(!empty($page_ci_id)) {
                        foreach ($page_ci_id as $k => $v) {
                            $postbacks_data[] = array(
                                'id' => $v['id'],
                                'text' => $v['bot_name']
                            );
                        }
                    }
                }
                break;
            default:
                break;
        }


        $data = array(
            'success' => TRUE,
            'message' => array(
                'select' => array('data' => $postbacks_data)
            )
        );

        echo json_encode($data);
    }

    private function load_postback_message(){
        $page_id = $this->input->post('page_id');
        $search = $this->input->post('search');

        $page_ci_id = $this->basic->get_data("facebook_rx_fb_page_info",
            array("where" => array(
                    "user_id" => $this->user_id,
                    'page_id' => $page_id,
                )
            ),
            '',
            '',
            1
        );

        $data = array(
            'success' => TRUE,
            'select' => array('data' => ''),
        );

        if(!empty($page_ci_id)){
            $where = array(
                "user_id" => $this->user_id,
                'page_id' => $page_ci_id[0]['id']
            );
            if(!empty($search)){
                $where['bot_name'] = '%'.$search.'%';
            }
            $postbacks = $this->basic->get_data("messenger_bot_postback",
                array("where" => $where),
                '',
                '',
                50
            );



            $postbacks_data = array();

            if(!empty($postbacks[0])){

                foreach($postbacks as $k => $v){
                    $postbacks_data[] = array(
                        'id' => $v['postback_id'],
                        'text' => $v['bot_name']
                    );
                }

                $data = array(
                    'success' => TRUE,
                    'select' => array('data' => $postbacks_data),
                );

            }
        }

        echo json_encode($data);

    }

    private function account_currency(){
            $data = array(
            );

            $js_ret = $this->send_curl('account_currency', $data);

            echo $js_ret;
    }

    private function generate_preview_ad()
    {

        $selected_placements = array();

        $this->form_validation->set_rules('fb_page_id', 'Facebook Page ID', 'trim');
        $this->form_validation->set_rules('instagram_id', 'Instagram ID', 'trim');

        $this->form_validation->set_rules('ad_text', 'Ad Text', 'trim');
        $this->form_validation->set_rules('website_url', 'Website Url', 'trim');
        $this->form_validation->set_rules('headline', 'Headline', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('adimage', 'Ad Image', 'trim');
        $this->form_validation->set_rules('video_id', 'Ad Video', 'trim');
        $this->form_validation->set_rules('pixel_id', 'Pixel ID', 'trim');
        $this->form_validation->set_rules('pixel_conversion_id', 'Pixel Conversion ID', 'trim');
        $this->form_validation->set_rules('preview_image', 'Preview Image', 'trim');
        $this->form_validation->set_rules('post_id', 'Post ID', 'trim');

        if (($this->form_validation->run() !== false)) {

            $objective = $this->input->post('objective');
            $fb_page_id = $this->input->post('fb_page_id');
            $instagram_id = $this->input->post('instagram_id');


            $ad_text = $this->input->post('ad_text');
            $website_url = $this->input->post('website_url');
            $ad_name = $this->input->post('ad_name');
            $headline = $this->input->post('headline');
            $description = $this->input->post('description');
            $adimage = $this->input->post('adimage');
            $advideo = $this->input->post('video_id');

            $pixel_id = $this->input->post('pixel_id');
            $pixel_conversion_id = $this->input->post('pixel_conversion_id');
            $preview_image = $this->input->post('preview_image');
            $post_id = $this->input->post('post_id');

            $adset_id = $this->input->post('adset_id');

            $adset_promoted_object = $this->input->post('adset_promoted_object');
            $messages_buttons = $this->input->post('messages_buttons');
            $ad_img_title = $this->input->post('ad_img_title');
            $ad_img_subtitle = $this->input->post('ad_img_subtitle');

            $data = array(
                'objective' => $objective,
                'ad_name' => $ad_name,
                'ad_text' => $ad_text,
                'website_url' => $website_url,
                'adimage' => $adimage,
                'preview_image' => $preview_image,
                'advideo' => $advideo,
                'fb_page_id' => $fb_page_id,
                'instagram_id' => $instagram_id,
                'headline' => $headline,
                'description' => $description,
                'adset_id' => $adset_id,
                'pixel_id' => $pixel_id,
                'post_id' => $post_id,
                'pixel_conversion_id' => $pixel_conversion_id,
                'adset_promoted_object' => $adset_promoted_object,
                'messages_buttons' => $messages_buttons,
                'ad_img_title' => $ad_img_title,
                'ad_img_subtitle' => $ad_img_subtitle,
            );


            $js_ret = $this->send_curl('generate_preview_ad', $data);

            $js_ret = json_decode($js_ret, true);

            if (!empty($js_ret['message']['description'])) {
                $js_ret['message']['description'] = $this->lang->line($js_ret['message']['description']);
                $js_ret['message']['message'] = $this->lang->line($js_ret['message']['message']);
            }

            echo json_encode($js_ret);
        } else {

            $message_js = $this->lang->line('ad_set_not_created_successfully');
            $this->return_json($message_js);
        }
    }

    private function create_facebook_campaign_ad()
    {

        $selected_placements = array();

        $this->form_validation->set_rules('fb_page_id', 'Facebook Page ID', 'trim');
        $this->form_validation->set_rules('instagram_id', 'Instagram ID', 'trim');

        $this->form_validation->set_rules('ad_text', 'Ad Text', 'trim');
        $this->form_validation->set_rules('website_url', 'Website Url', 'trim');
        $this->form_validation->set_rules('headline', 'Headline', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('adimage', 'Ad Image', 'trim');
        $this->form_validation->set_rules('advideo', 'Ad Video', 'trim');
        $this->form_validation->set_rules('pixel_id', 'Pixel ID', 'trim');
        $this->form_validation->set_rules('pixel_conversion_id', 'Pixel Conversion ID', 'trim');
        $this->form_validation->set_rules('preview_image', 'Preview Image', 'trim');
        $this->form_validation->set_rules('post_id', 'Post ID', 'trim');
        $this->form_validation->set_rules('ad_creativity_status', 'ad_creativity_status', 'trim');

        $this->form_validation->set_rules('ad_creativity_details_messages_select_type', 'ad_creativity_details_messages_select_type', 'trim');

        if (($this->form_validation->run() !== false)) {

            $objective = $this->input->post('objective');
            $fb_page_id = $this->input->post('fb_page_id');
            $instagram_id = $this->input->post('instagram_id');


            $ad_text = $this->input->post('ad_text');
            $website_url = $this->input->post('website_url');
            $ad_name = $this->input->post('ad_name');
            $headline = $this->input->post('headline');
            $description = $this->input->post('description');
            $adimage = $this->input->post('adimage');
            $advideo = $this->input->post('video_id');

            $pixel_id = $this->input->post('pixel_id');
            $pixel_conversion_id = $this->input->post('pixel_conversion_id');
            $preview_image = $this->input->post('preview_image');
            $post_id = $this->input->post('post_id');

            $adset_id = $this->input->post('adset_id');

            $adset_promoted_object = $this->input->post('adset_promoted_object');
            $messages_buttons = $this->input->post('messages_buttons');
            $ad_img_title = $this->input->post('ad_img_title');
            $ad_img_subtitle = $this->input->post('ad_img_subtitle');

            $ad_creativity_status = $this->input->post('ad_creativity_status');

            $ad_img_subtitle = $this->input->post('ad_img_subtitle');
            $ad_creativity_details_messages_select_type = $this->input->post('ad_creativity_details_messages_select_type');


            $data = array(
                'objective' => $objective,
                'ad_name' => $ad_name,
                'ad_text' => $ad_text,
                'website_url' => $website_url,
                'adimage' => $adimage,
                'preview_image' => $preview_image,
                'advideo' => $advideo,
                'fb_page_id' => $fb_page_id,
                'instagram_id' => $instagram_id,
                'headline' => $headline,
                'description' => $description,
                'adset_id' => $adset_id,
                'pixel_id' => $pixel_id,
                'post_id' => $post_id,
                'pixel_conversion_id' => $pixel_conversion_id,

                'adset_promoted_object' => $adset_promoted_object,
                'messages_buttons' => $messages_buttons,
                'ad_img_title' => $ad_img_title,
                'ad_img_subtitle' => $ad_img_subtitle,
                'ad_creativity_details_messages_select_type' => $ad_creativity_details_messages_select_type,

                'ad_creativity_status' => $ad_creativity_status
            );


            $js_ret = $this->send_curl('create_facebook_campaign_ad', $data);

            $js_ret = json_decode($js_ret, true);

            if (!empty($js_ret['message']['description'])) {
                if(!empty($js_ret['message']['description']['error']['error_user_msg'])){
                    $js_ret['message']['description'] = $js_ret['message']['description']['error']['error_user_msg'];
                }

                $js_ret['message']['description'] = $this->lang->line($js_ret['message']['description']);
                $js_ret['message']['message'] = $this->lang->line($js_ret['message']['message']);
            }

            if (!empty($js_ret['message']) AND !is_array($js_ret['message'])) {
                $js_ret['message'] = $this->lang->line($js_ret['message']);
            }

            echo json_encode($js_ret);
        } else {

            $message_js = $this->lang->line('ad_set_not_created_successfully');
            $this->return_json($message_js);
        }
    }

    private function set_token_for_user_id()
    {
        if ($this->session->userdata('user_type') != "Admin") {
            $this->return_json('Only Admin');
        }

        $access_token = $this->input->post('access_token');
        $a_user_id = $this->input->post('a_user_id');

        if (isset($access_token)) {

            try {
                $response = $this->fb->get(
                    '/me/adaccounts?fields=name', //removed: ,business
                    $access_token
                );
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                $this->return_json(
                    'error',
                    array('text' => 'Graph returned an error: ' . $e->getMessage())
                );
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                $this->return_json(
                    'error',
                    array('text' => 'Facebook SDK returned an error: ' . $e->getMessage())
                );
                exit;
            }

            $graphNode = $response->getGraphEdge();

            if ($graphNode->asArray()) {

                $accounts = $graphNode->asArray();

                foreach ($accounts as $account) {
                    $account_id = $account['id'];
                    $extra = '';
                    $account_name = $account['name'];
                    $this->add_network('fb_ad_account', $account_id, 1, $a_user_id, '', $access_token, '', $account_name, $extra);
                }

                $check = 1;
            } else {
                $check = 2;
            }

        }

        if ($check === 1) {
            $this->return_json(
                'ok',
                'all_ad_accounts_were_connected'
            );
        } else if ($check === 2) {
            $this->return_json(
                'error',
                'no_ad_accounts'
            );
        } else {
            $this->return_json(
                'error',
                'error_occurred'
            );
        }
    }

    private function load_account_fb()
    {

        $search = addslashes(strip_tags($this->input->post('search', true)));

        $data = array(
            'search' => $search,
        );

        $js_ret = $this->send_curl('load_account_fb', $data);
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

//        if($js_ret['status']=='false_alert'){
//            $js_ret['message'] = $this->lang->line($js_ret['message']);
//        }
        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_coversions_by_id()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));
        $pixel_id = addslashes(strip_tags($this->input->post('pixel_id', true)));

        $data = array(
            'search' => $search,
            'pixel_id' => $pixel_id
        );

        $js_ret = $this->send_curl('load_coversions_by_id', $data);
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }

    private function load_all_pixel_coversions()
    {
        $search = addslashes(strip_tags($this->input->post('search', true)));

        $data = array(
            'search' => $search,
        );

        $js_ret = $this->send_curl('load_all_pixel_coversions', $data);
        //var_dump($js_ret);

        $js_ret = json_decode($js_ret, true);

        //$js_ret['message']['words'] = $this->translate_words($js_ret['message']['words']);

        echo json_encode($js_ret);
    }


    private function create_pixel_conversion()
    {

        // Add form validation

        $this->form_validation->set_rules('ads_pixel_conversion_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('ads_pixel_conversion_url', 'Conversion Url', 'trim|required');
        $this->form_validation->set_rules('ads_select_conversion_type', 'Conversion Type', 'trim|required');

        // Get data
        $name = $this->input->post('ads_pixel_conversion_name');
        $conversion_url = $this->input->post('ads_pixel_conversion_url');
        $conversion_type = $this->input->post('ads_select_conversion_type');


        if (empty($name)) {
            $message_js = $this->lang->line('Field "name" cannot be empty.');
            $this->return_json($message_js);
        }

        $data = array(
            'name' => $name,
            'conversion_url' => $conversion_url,
            'conversion_type' => $conversion_type,
        );

        $js_ret = $this->send_curl('create_pixel_conversion', $data, 0);

        $js_ret = json_decode($js_ret, true);

        echo json_encode($js_ret);
    }

    private function papi($endpoint, $data_api = array())
    {
        if (!empty($this->session->userdata('n_selected_ad_acc'))) {
            $data['current_ad_acc'] = $this->get_account($this->session->userdata('n_selected_ad_acc'));
            $data['current_ad_acc'] = $data['current_ad_acc'][0];

            $this->current_ad_acc = $data['current_ad_acc'];
            $this->network_id = $data['current_ad_acc']['network_id'];
            $this->net_id = $data['current_ad_acc']['net_id'];
            $this->token = $data['current_ad_acc']['token'];


        } else {
            $this->return_json('Bad Request');
        }

//        if(file_exists(APPPATH.'n_generator_config.php')){
//            include(APPPATH.'n_generator_config.php');
//            $this->n_gen_config = $n_gen_config;
//        }else{
//            $this->return_json('Not found configuration. Please contact with administration.');
//            exit;
//        }
        //$n_gen_config['cost_per1k_tokens'];
        switch ($endpoint) {
            case 'upload_image_ad_api';
                $resp = $this->upload_image_ad_api($data_api);
                break;


            default;
                $this->return_json('Bad Request');
                break;
        }

        if (!empty($resp['status']) and $resp['status'] != 'ok') {

        }

        return $resp;
    }

    public function upload_image_ad()
    {
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = APPPATH . '../upload/ads_manager';

        // Makes upload directory
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > $this->n_config['ads_image_size'] * 1024 * 1024) {
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

                if (!$_FILES['file']['type']) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $check_format = array('image/bmp', 'image/jpeg', 'image/gif');
                if (!in_array($_FILES['file']['type'], $check_format)) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = "ad_image_" . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (!@move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }


                $data = array();
                $data['file_name'] = $filename;
                $data['file_url'] = base_url() . 'upload/ads_manager/' . $filename;

                $resp = $this->papi('upload_image_ad_api', $data);

                if (!empty($resp['message']['message']) and $resp['status'] != 'ok') {
                    $message = $this->lang->line($resp['message']['message']);
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $resp['filename'] = $filename;

                @unlink($dest_file);

                // Returns response
                echo json_encode($resp);
            }
        }


    }

    public function upload_ad_video(){
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = APPPATH . '../upload/ads_manager';

        // Makes upload directory
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > $this->n_config['ads_video_size'] * 1024 * 1024) {
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

                if (!$_FILES['file']['type']) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $check_format = array('image/gif', 'video/mp4', 'video/webm', 'video/avi', 'video/mov');
                if (!in_array($_FILES['file']['type'], $check_format)) {
                    $message = $this->lang->line('Invalid file type');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = "ad_video_" . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (!@move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }


                $data = array();
                $data['file_name'] = $filename;
                $data['file_url'] = base_url() . 'upload/ads_manager/' . $filename;
                $data['dest_file']  = $dest_file;

                $resp = $this->ad_video_upload_to_fb($data);

                //var_dump($resp);
                if (!empty($resp['message']['message']) and $resp['status'] != 'ok') {
                    $message = $this->lang->line($resp['message']['message']);
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $resp['filename'] = $filename;

                @unlink($dest_file);

                // Returns response
                echo json_encode($resp);
            }
        }


    }

    private function ad_video_upload_to_fb($data)
    {

        if (!empty($this->session->userdata('n_selected_ad_acc'))) {
            $data['current_ad_acc'] = $this->get_account($this->session->userdata('n_selected_ad_acc'));
            $data['current_ad_acc'] = $data['current_ad_acc'][0];

            $this->current_ad_acc = $data['current_ad_acc'];
            $this->network_id = $data['current_ad_acc']['network_id'];
            $this->net_id = $data['current_ad_acc']['net_id'];
            $this->token = $data['current_ad_acc']['token'];

        } else {
            $this->return_json('Bad Request');
            exit;
        }


        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $this->fb->post(
                '/' . $this->net_id . '/advideos',
                array (
                    'source' => $this->fb->videoToUpload($data['dest_file']),
                ),
                $this->token
            );
        } catch(Facebook\Exceptions\FacebookResponseException $e) {

            $message = array(
                'success' => FALSE,
                'message' => $this->lang->line('file_not_uploaded')
            );

            return json_encode($message);
        } catch(Facebook\Exceptions\FacebookSDKException $e) {

            $message = array(
                'success' => FALSE,
                'message' => $this->lang->line('file_not_uploaded')
            );

            return json_encode($message);
        }

        $data = $response->getDecodedBody();

        return $data;
    }

    public function delete_ads_image(){
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        // Upload dir path
        $upload_dir = APPPATH . '../upload/ads_manager';

        // Grabs filename
        $filename = (string)$this->input->post('filename');
        $filename_exp = explode('_', $filename);
        if (!isset($filename_exp['2']) || $filename_exp['2'] != $this->user_id) exit();

        // Prepares file path
        $filepath = $upload_dir . DIRECTORY_SEPARATOR . $filename;

        // Tries to remove file
        if (file_exists($filepath)) {
            // Deletes file from disk
            unlink($filepath);

            // Clears the file from cache
            clearstatcache();

            echo json_encode(['deleted' => 'yes']);
            exit();
        }

        echo json_encode(['deleted' => 'yes']);
    }


    private function return_json($status, $message = '')
    {
        if (!empty($message)) {
            if (is_array($message)) {
                echo json_encode([
                    'status' => $status,
                    'message' => json_encode($message),
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

    private function send_curl($endpoint, $data, $debug = 0)
    {
        $data['domain'] = $this->getDomain();
        $data['purchase_code'] = $this->get_purchase_code();
        $data['user_id'] = $this->user_id;

        $data['network_id'] = $this->network_id;
        $data['net_id'] = $this->net_id;
        $data['token'] = openssl_encrypt($this->token, "AES-128-ECB", 'nstok-' . $this->get_purchase_code());

        $data['app_id'] = $this->app_id;
        $data['app_secret'] = openssl_encrypt($this->app_secret, "AES-128-ECB", 'nstok-' . $this->get_purchase_code());

        $data = json_encode($data);

        $ch = curl_init($this->url_api . '/' . $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:64.0) Gecko/20100101 Firefox/64.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($debug == 1) {
            ini_set('xdebug.var_display_max_depth', -1);
            ini_set('xdebug.var_display_max_children', -1);
            ini_set('xdebug.var_display_max_data', -1);
            var_dump('------------------------------------------------');
            var_dump($response);
            var_dump($error);
            var_dump('------------------------------------------------');
        }


        if ($info['http_code'] != 200) {
            $this->return_json('Something wrong. Please try again later.');
        }


        return $response;
    }


    private function translate_words($words)
    {
        if (!is_array($words)) {
            return false;
        }
        foreach ($words as $k => $v) {
            $words[$k] = $this->lang->line($v);
        }
        return $words;
    }

    public function fix_menu()
    {
        $sql_cust = "DELETE from `menu` where url like '%n_adsmanager%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_adsmanager%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%ultrapost%' ")->row_array();
        if (!$menu_exists) {
            try {
                $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'Meta ADS', 'fas fa-robot', 'n_adsmanager/', " . $parent_id_to_add['serial'] . ", '3300', '0', '0', '0', '0', '0', '', '0', '0')";
                $this->db->query($sql_cust);
            } catch (Exception $e) {

            }
        }
        echo 'done';
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
            0 => "CREATE TABLE IF NOT EXISTS `ads_account` (
                              `ads_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `network_id` bigint(20) NOT NULL,
                              `network` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                            );",

            1 => "CREATE TABLE IF NOT EXISTS `ads_networks` (
                              `network_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `network_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                              `net_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                              `type` int(4) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              `user_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                              `date` datetime NOT NULL,
                              `expires` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                              `token` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                              `secret` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                              `extra` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                            );",

            2 => "ALTER TABLE `ads_networks` ADD `active_expire` DATETIME NULL DEFAULT NULL;",

            3 => "ALTER TABLE `ads_networks` ADD `auto_renew` INT(1) NOT NULL DEFAULT '1';"

        );

        $sql_cust = "DELETE from `menu` where url like '%n_adsmanager%' ";
        $this->db->query($sql_cust);

        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_adsmanager%' ")->row_array();
        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%ultrapost%' ")->row_array();
        if (!$menu_exists) {

            $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'Meta ADS', 'fas fa-robot', 'n_adsmanager/', " . $parent_id_to_add['serial'] . ", '3300', '0', '0', '0', '0', '0', '', '0', '0')";
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