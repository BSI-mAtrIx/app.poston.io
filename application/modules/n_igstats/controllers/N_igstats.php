<?php
/*
Addon Name: Instagram Extended Statistics
Unique Name: instagram_extended_statistics
Modules:
{
   "3008":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"0",
      "extra_text":"",
      "module_name":"Instagram Extended Statistics"
   }
}
Project ID: 1018
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.5
Description: Instagram Extended Statistics
*/
require_once("application/controllers/Home.php"); // loading home controller
include("application/libraries/Facebook/autoload.php");

class N_igstats extends Home
{
    public $key = "FA3345E7844CA8C6";
    private $product_id = "6";
    private $product_base = "n_igstats";
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
        if ($function_name != "webhook_callback" && $function_name != "user_insight_public") {
            // all addon must be login protected
            //------------------------------------------------------------------------------------------
            if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
            // if you want the addon to be accessed by admin and member who has permission to this addon
            //-------------------------------------------------------------------------------------------

            if ($this->session->userdata('user_type') != 'Admin' && !in_array(3008, $this->module_access)) {
                redirect('home/login_page', 'location');
                exit();
            }

        }
        $this->load->library('encryption');

        $addon_lang = 'n_igstats';
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_lang.php')) {
            $this->lang->load($addon_lang, $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        } else {
            $this->lang->load($addon_lang, 'english', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/english');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($addon_lang . '_custom', $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        }

        $orig_file = APPPATH.'views/comment_automation/comment_growth_tools.php';
        $new_file = APPPATH.'modules/n_igstats/views/comment_growth_tools.php';
        if(file_exists($orig_file) AND file_exists($new_file)){
            @unlink($orig_file);
            @rename($new_file, $orig_file);
        }

    }


    public function index()
    {
        if ($this->session->userdata('logged_in') != 1) exit();

        if ($this->session->userdata('user_type') != 'Admin' && !in_array(3008, $this->module_access))
            redirect('home/login_page', 'location');

//         if ($this->session->userdata("instagram_reply_user_info") == 0 && $this->config->item("instagram_backup_mode") == 1)
//             redirect('instagram_reply/facebook_config', 'refresh');
//             
        ////
//         $this->load->library("influencerlib");

        $data['title'] = $this->lang->line('Instagram accounts');

        $data['body'] = 'account_import';


        $data['page_title'] = $data['title'];

//         $redirect_url = base_url() . "user/influencer/refresh_login_callback";
//         $fb_login_button = $this->influencerlib->login_for_user_access_token($redirect_url);
//         $data['fb_login_button'] = $fb_login_button;
//         

        $where['where'] = array('user_id' => $this->session->userdata('user_id'));
        $existing_accounts = $this->basic->get_data('facebook_rx_fb_page_info', $where);

        $show_import_account_box = 1;
        $data['show_import_account_box'] = 1;
        if (!empty($existing_accounts)) {
            $i = 0;
            foreach ($existing_accounts as $value) {
                if (empty($value['instagram_business_account_id'])) {
                    continue;
                }

                $where['where'] = array('id' => $value['facebook_rx_fb_user_info_id']);
                $fb_id = $this->basic->get_data('facebook_rx_fb_user_info', $where);
                $fb_id = $fb_id[0];

                $existing_account_info[$i]['need_to_delete'] = $fb_id['need_to_delete'];
                if ($fb_id['need_to_delete'] == '1') {
                    $show_import_account_box = 0;
                    $data['show_import_account_box'] = $show_import_account_box;
                }


                $existing_account_info[$i]['fb_id'] = $fb_id['fb_id'];
                $existing_account_info[$i]['userinfo_table_id'] = $fb_id['id'];
                $existing_account_info[$i]['name'] = $fb_id['name'];
                $existing_account_info[$i]['email'] = $fb_id['email'];
                $existing_account_info[$i]['user_access_token'] = $fb_id['access_token'];
                $valid_or_invalid = $this->access_token_validity_check_for_user($fb_id['access_token']);
                if ($valid_or_invalid) {
                    $existing_account_info[$i]['validity'] = 'yes';
                } else {
                    $existing_account_info[$i]['validity'] = 'no';
                }


                $existing_account_info[$i]['page_list'] = array($value);
                if (!empty($page_count)) {
                    $existing_account_info[$i]['total_pages'] = count($existing_account_info[$i]['page_list']);
                } else $existing_account_info[$i]['total_pages'] = 0;


//                 $table_name_bot = "instagram_reply_page_info";
//                 $where_bot = array();
//                 $where_bot['where'] = array('instagram_reply_user_info_id' => $value['id']);
//                 $instra_info = $this->basic->get_data($table_name_bot, $where_bot);


                $existing_account_info[$i]['instra_info_list'] = array($value);
                if (!empty($instra_info)) {
                    $existing_account_info[$i]['total_instra_account'] = count($existing_account_info[$i]['instra_info_list']);
                } else $existing_account_info[$i]['total_instra_account'] = 0;
                $i++;
            }
            if (empty($existing_account_info)) {
                $data['existing_accounts'] = null;
            } else {
                $data['existing_accounts'] = $existing_account_info;
            }

        } else $data['existing_accounts'] = '0';
        $this->_viewcontroller($data);
    }

    public function user_insight($auto_id = 0)
    {

        if (empty($auto_id)) {
            redirect('/my404', 'location');
        }

        $or_to_date = date("Y-m-d H:i");
        $or_from_date = date("Y-m-d H:i", strtotime("$or_to_date-28 days"));

        $this->load->model('basic');
        $user_id = $this->session->userdata('user_id');


        if (empty($user_id)) {
            $wheres = array("id" => $auto_id, 'updated_at != ' => null, 'user_id' => $this->user_id);
        } else {
            $wheres = array("id" => $auto_id, 'user_id' => $this->user_id);
        }


        $api_call_info = $this->basic->get_data("facebook_rx_fb_page_info", array("where" => $wheres));
        if (empty($api_call_info)) {
            redirect('/my404', 'location');
        }


        $business_account_id = isset($api_call_info[0]['instagram_business_account_id']) ? $api_call_info[0]['instagram_business_account_id'] : "";
        $access_token = isset($api_call_info[0]['page_access_token']) ? $api_call_info[0]['page_access_token'] : "";

        $instagram_reply_user_info_id = isset($api_call_info[0]['facebook_rx_fb_user_info_id']) ? $api_call_info[0]['facebook_rx_fb_user_info_id'] : "";

        $config_data = $this->basic->get_data("facebook_rx_fb_user_info", array("where" => array("id" => $instagram_reply_user_info_id)));
        $instagram_reply_login_database_id = isset($config_data[0]['facebook_rx_config_id']) ? $config_data[0]['facebook_rx_config_id'] : 0;

        $this->app_initialize($instagram_reply_login_database_id);


        $metric = 'phone_call_clicks,text_message_clicks,email_contacts,get_directions_clicks,website_clicks,impressions,reach,follower_count,profile_views';
        $period = "day&since={$or_from_date}&until={$or_to_date}";

        $clicks = $this->user_insight_lib($business_account_id, $metric, $period, $access_token);


        $temp = isset($clicks) ? $clicks : array();
        $clicks_type_data = array();
        $impressions_data = array();
        $follower_count_data = array();

        foreach ($temp as $full_value) {
            $name = $full_value['name'];
            $i = 0;
            foreach ($full_value['values'] as $value) {

                $clicks_type_data[$i]['date'] = $value['end_time']->format('Y-m-d');
                $impressions_data[$i]['date'] = $value['end_time']->format('Y-m-d');
                $reach_data[$i]['date'] = $value['end_time']->format('Y-m-d');
                $follower_count_data[$i]['date'] = $value['end_time']->format('Y-m-d');

                if ($name == "phone_call_clicks") {
                    $clicks_type_data[$i]['phone_call'] = $value['value'];
                }

                if ($name == "text_message_clicks") {
                    $clicks_type_data[$i]['text_message'] = $value['value'];
                }

                if ($name == "website_clicks") {
                    $clicks_type_data[$i]['website'] = $value['value'];
                }

                if ($name == "get_directions_clicks") {
                    $clicks_type_data[$i]['get_directions'] = $value['value'];
                }

                if ($name == "impressions") {
                    $impressions_data[$i]['impressions'] = $value['value'];
                }

                if ($name == "email_contacts") {
                    $clicks_type_data[$i]['email_contacts'] = $value['value'];
                }

                if ($name == "online_followers") {
                    $reach_data[$i]['online_followers'] = $value['value'];
                }

                if ($name == "reach") {
                    $reach_data[$i]['reach'] = $value['value'];
                }

                if ($name == "profile_views") {
                    $reach_data[$i]['profile_views'] = $value['value'];
                }


                if ($name == "follower_count") {
                    $follower_count_data[$i]['follower_count'] = $value['value'];
                }
                $i++;
            }
        }

        $data['clicks_type_data_description'] = $this->lang->line("Daily: The number of clicks like Phone, Text, Website, Get directions");
        $data['clicks_type_data'] = json_encode($clicks_type_data);

        $data['impressions_data_description'] = $this->lang->line("Daily: The number of impressions that came from all of your posts. (Total Count)");
        $data['impressions_data'] = json_encode($impressions_data);

        $data['reach_data_description'] = $this->lang->line("Daily: The number of reach that came from all of your posts. (Total Count)");
        $data['reach_data'] = json_encode($reach_data);

        $data['follower_count_description'] = $this->lang->line("Daily: The number of follower");
        $data['follower_count_data'] = json_encode($follower_count_data);

        // audience
        $audience_metric = 'audience_gender_age,audience_locale,audience_country,audience_city,online_followers';
        $audience_period = "lifetime";
        $audience = $this->user_insight_lib($business_account_id, $audience_metric, $audience_period, $access_token);

        foreach ($audience as $audience_value) {
            $name = $audience_value['name'];
            $i = 0;
            foreach ($audience_value['values'] as $value) {
                if ($name == "audience_country") {
                    $test_country = $audience_value;
                }

                if ($name == "audience_city") {
                    $test_city = $audience_value;
                }

                if ($name == "audience_locale") {
                    $test_locale = $audience_value;
                }

                if ($name == "audience_gender_age") {
                    $test_gender_age = $audience_value;
                }

//                 if ($name == "online_followers") {
//                    var_dump($audience_value);
//                 }

                $i++;
            }
        }

        $test1 = isset($test_locale['values']) ? $test_locale['values'] : array();
        $reach_by_audience_locale_data = array();
        $reach_by_audience_locale_data_temp = array();
        if (!empty($test1)) {
            for ($i = 0; $i < count($test1); $i++) {
                $aa = isset($test1[$i]['value']) ? $test1[$i]['value'] : array();
                foreach (array_keys($aa + $reach_by_audience_locale_data_temp) as $value) {
                    $reach_by_audience_locale_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($reach_by_audience_locale_data_temp[$value]) ? $reach_by_audience_locale_data_temp[$value] : 0);
                }
            }
        }

        $country_names = $this->get_country_names();
        $language_names = $this->get_language_names();
        $reach_locale_list = '';
        $colors_array = array("#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092");
        if (!empty($reach_by_audience_locale_data_temp)) {
            $i = 0;
            $j = 0;
            arsort($reach_by_audience_locale_data_temp);
            foreach ($reach_by_audience_locale_data_temp as $key => $value) {
                if ($key == 'GB') $key = 'UK';
                $key_array = explode("_", $key);

                $lang_code = $key_array[0];
                $country_code = $key_array[1];

                $country = isset($country_names[$country_code]) ? $country_names[$country_code] : $country_code;
                $language = isset($language_names[$lang_code]) ? $language_names[$lang_code] : $lang_code;
                $label = $language . ", " . $country;
                $reach_by_audience_locale_data[$i] = array(
                    'value' => $value,
                    'color' => $colors_array[$j],
                    'highlight' => $colors_array[$j],
                    'label' => $label
                );
                $reach_locale_list .= '<li><i class="fa fa-circle" style="color: ' . $colors_array[$j] . ';"></i> ' . $label . ' : ' . $value . '</li>';
                $i++;
                $j++;
                if ($j == 19) $j = 0;
            }
        }

        $data['reach_by_audience_locale_description'] = $this->lang->line("total reach by user locale[last 28 days]");
        $data['reach_locale_list'] = $reach_locale_list;
        $data['reach_by_audience_locale_data'] = json_encode($reach_by_audience_locale_data);
        $data['pageinfo'] = $api_call_info;


        $test2 = isset($test_country['values']) ? $test_country['values'] : array();

        $reach_by_user_country_data = array();
        $reach_by_user_country_data_temp = array();
        if (!empty($test2)) {
            for ($i = 0; $i < count($test2); $i++) {
                $aa = isset($test2[$i]['value']) ? $test2[$i]['value'] : array();
                foreach (array_keys($aa + $reach_by_user_country_data_temp) as $value) {
                    $reach_by_user_country_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($reach_by_user_country_data_temp[$value]) ? $reach_by_user_country_data_temp[$value] : 0);
                }
            }
        }


        $country_names = $this->get_country_names();
        $reach_country_list = '';
        $colors_array = array("#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092");
        $colors_array = array_reverse($colors_array);

        if (!empty($reach_by_user_country_data_temp)) {
            $i = 0;
            $j = 0;
            arsort($reach_by_user_country_data_temp);
            foreach ($reach_by_user_country_data_temp as $key => $value) {
                if ($key == 'GB') $key = 'UK';
                $country = isset($country_names[$key]) ? $country_names[$key] : $key;
                $reach_by_user_country_data[$i] = array(
                    'value' => $value,
                    'color' => $colors_array[$j],
                    'highlight' => $colors_array[$j],
                    'label' => $country
                );
                $reach_country_list .= '<li><i class="fa fa-circle" style="color: ' . $colors_array[$j] . ';"></i> ' . $country . ' : ' . $value . '</li>';
                $i++;
                $j++;
                if ($j == 19) $j = 0;
            }
        }

        $data['reach_by_user_country_description'] = $this->lang->line("total reach by user country. (unique users) [last 28 days]");
        $data['reach_country_list'] = $reach_country_list;
        $data['reach_by_user_country_data'] = json_encode($reach_by_user_country_data);

        $test3 = isset($test_city['values']) ? $test_city['values'] : array();

        $user_city_data = '';
        $user_city_data_temp = array();
        if (!empty($test3)) {
            for ($i = 0; $i < count($test3); $i++) {
                $aa = isset($test3[$i]['value']) ? $test3[$i]['value'] : array();
                foreach (array_keys($aa + $user_city_data_temp) as $value) {
                    $user_city_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($user_city_data_temp[$value]) ? $user_city_data_temp[$value] : 0);
                }
            }
        }

        $user_city_data = '<table class="table table-hover table-striped"><tr><th>' . $this->lang->line("sl") . '</th><th>' . $this->lang->line("city") . '</th><th>' . $this->lang->line("total") . '</th></tr>';
        $i = 0;
        if (!empty($user_city_data_temp)) {
            arsort($user_city_data_temp);
            foreach ($user_city_data_temp as $key => $value) {
                $i++;
                $user_city_data .= '<tr><td>' . $i . '</td><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
        }

        $user_city_data .= '</table>';
        $data['user_city_description'] = $this->lang->line("the number of people talking about in city. [last 28 days]");

        $data['user_city_data'] = $user_city_data;

        $test4 = isset($test_gender_age['values']) ? $test_gender_age['values'] : array();

        $user_gender_age_data = '';
        $user_gender_age_data_temp = array();
        if (!empty($test4)) {
            for ($i = 0; $i < count($test4); $i++) {
                $aa = isset($test4[$i]['value']) ? $test4[$i]['value'] : array();
                foreach (array_keys($aa + $user_gender_age_data_temp) as $value) {
                    $user_gender_age_data_temp[$value] = (isset($aa[$value]) ? $aa[$value] : 0) + (isset($user_gender_age_data_temp[$value]) ? $user_gender_age_data_temp[$value] : 0);
                }
            }
        }

        $user_gender_age_data = '
        <table class="table table-hover table-striped">
            <tr>
                <th>' . $this->lang->line("sl") . '</th>
                <th>' . $this->lang->line("gender") . '</th>
                <th>' . $this->lang->line("age range") . '</th>
                <th>' . $this->lang->line("total") . '</th>
            </tr>';

        $i = 0;
        if (!empty($user_gender_age_data_temp)) {
            arsort($user_gender_age_data_temp);
            foreach ($user_gender_age_data_temp as $key => $value) {
                $key_array = explode(".", $key);
                $gender_part = $key_array[0];
                $age_part = $key_array[1];
                if ($gender_part == "F") {
                    $final_gender = "Female";
                } elseif ($gender_part == "M") {
                    $final_gender = "Male";
                } else {
                    $final_gender = "";
                }

                $i++;
                $user_gender_age_data .= '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . $final_gender . '</td>
                    <td>' . $age_part . '</td>
                    <td>' . $value . '</td>
                </tr>';
            }
        }

        $user_gender_age_data .= '</table>';

        $data['user_gender_age_data_description'] = $this->lang->line("the number of people talking about your instagram.");

        $data['user_gender_age_data'] = $user_gender_age_data;

        $data['body'] = "user_insight_public";


        // $auto_id_encrypted  =  $this->encryption->encrypt($auto_id);

        $data['public_link'] = base_url() . 'public_profile/user_insight_public/' . $auto_id;

        $data['title'] = $this->lang->line('Statistics account') . ' ' . $data['pageinfo'][0]['insta_username'];


        $this->_viewcontroller($data);
    }

    private function user_insight_lib($business_account_id = '', $metric = '', $period = '', $access_toke = '')
    {
        $response = $this->fb->get("$business_account_id/insights?metric=$metric&period=$period&access_token=" . $access_toke);
        return $response = $response->getGraphList()->asArray();
    }

    protected function get_country_names()
    {
        $array_countries = array(
            'AF' => 'AFGHANISTAN',
            'AX' => 'ÅLAND ISLANDS',
            'AL' => 'ALBANIA',

            'DZ' => 'ALGERIA',
            'AS' => 'AMERICAN SAMOA',
            'AD' => 'ANDORRA',
            'AO' => 'ANGOLA',
            'AI' => 'ANGUILLA',
            'AQ' => 'ANTARCTICA',
            'AG' => 'ANTIGUA AND BARBUDA',
            'AR' => 'ARGENTINA',
            'AM' => 'ARMENIA',
            'AW' => 'ARUBA',

            'AU' => 'AUSTRALIA',
            'AT' => 'AUSTRIA',
            'AZ' => 'AZERBAIJAN',
            'BS' => 'BAHAMAS',
            'BH' => 'BAHRAIN',
            'BD' => 'BANGLADESH',
            'BB' => 'BARBADOS',
            'BY' => 'BELARUS',
            'BE' => 'BELGIUM',
            'BZ' => 'BELIZE',
            'BJ' => 'BENIN',
            'BM' => 'BERMUDA',
            'BT' => 'BHUTAN',
            'BO' => 'BOLIVIA',

            'BA' => 'BOSNIA AND HERZEGOVINA',
            'BW' => 'BOTSWANA',
            'BV' => 'BOUVET ISLAND',
            'BR' => 'BRAZIL',

            'BN' => 'BRUNEI DARUSSALAM',
            'BG' => 'BULGARIA',
            'BF' => 'BURKINA FASO',
            'BI' => 'BURUNDI',
            'KH' => 'CAMBODIA',
            'CM' => 'CAMEROON',
            'CA' => 'CANADA',
            'CV' => 'CAPE VERDE',
            'KY' => 'CAYMAN ISLANDS',
            'CF' => 'CENTRAL AFRICAN REPUBLIC',
            'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
            'CL' => 'CHILE',
            'CN' => 'CHINA',
            'CX' => 'CHRISTMAS ISLAND',

            'CO' => 'COLOMBIA',
            'KM' => 'COMOROS',
            'CG' => 'CONGO, REPUBLIC OF',
            'CK' => 'COOK ISLANDS',
            'CR' => 'COSTA RICA',
            'CI' => 'CÔTE D\'IVOIRE (IVORY COAST)',
            'HR' => 'CROATIA',
            'CU' => 'CUBA',
            'CW' => 'CURAÇAO',
            'CY' => 'CYPRUS',
            'CZ' => 'ZECH REPUBLIC',
            'DK' => 'DENMARK',
            'DJ' => 'DJIBOUTI',
            'DM' => 'DOMINICA',
            'DC' => 'DOMINICAN REPUBLIC',
            'EC' => 'ECUADOR',
            'EG' => 'EGYPT',
            'SV' => 'EL SALVADOR',
            'GQ' => 'EQUATORIAL GUINEA',
            'ER' => 'ERITREA',
            'EE' => 'ESTONIA',
            'ET' => 'ETHIOPIA',
            'FO' => 'FAEROE ISLANDS',

            'FJ' => 'FIJI',
            'FI' => 'FINLAND',
            'FR' => 'FRANCE',
            'GF' => 'FRENCH GUIANA',

            'GA' => 'GABON',
            'GM' => 'GAMBIA, THE',
            'GE' => 'GEORGIA',
            'DE' => 'GERMANY',
            'GH' => 'GHANA',
            'GI' => 'GIBRALTAR',
            'GR' => 'GREECE',
            'GL' => 'GREENLAND',
            'GD' => 'GRENADA',
            'GP' => 'GUADELOUPE',
            'GU' => 'GUAM',
            'GT' => 'GUATEMALA',
            'GG' => 'GUERNSEY',
            'GN' => 'GUINEA',
            'GW' => 'GUINEA-BISSAU',
            'GY' => 'GUYANA',
            'HT' => 'HAITI',

            'HN' => 'HONDURAS',
            'HK' => 'HONG KONG',
            'HU' => 'HUNGARY',
            'IS' => 'ICELAND',
            'IN' => 'INDIA',
            'ID' => 'INDONESIA',
            'IR' => 'IRAN',
            'IQ' => 'IRAQ',
            'IE' => 'IRELAND',
            'IM' => 'ISLE OF MAN',
            'IL' => 'ISRAEL',
            'IT' => 'ITALY',
            'JM' => 'JAMAICA',
            'JP' => 'JAPAN',
            'JE' => 'JERSEY',
            'JO' => 'JORDAN',
            'KZ' => 'KAZAKHSTAN',
            'KE' => 'KENYA',
            'KI' => 'KIRIBATI',
            'KW' => 'KUWAIT',
            'KG' => 'KYRGYZSTAN',

            'LV' => 'LATVIA',
            'LB' => 'LEBANON',
            'LS' => 'LESOTHO',
            'LR' => 'LIBERIA',
            'LY' => 'LIBYA',
            'LI' => 'LIECHTENSTEIN',
            'LT' => 'LITHUANIA',
            'LU' => 'LUXEMBOURG',
            'MO' => 'MACAO',
            'MK' => 'MACEDONIA',
            'MG' => 'MADAGASCAR',
            'MW' => 'MALAWI',
            'MY' => 'MALAYSIA',
            'MV' => 'MALDIVES',
            'ML' => 'MALI',
            'MT' => 'MALTA',
            'MH' => 'MARSHALL ISLANDS',
            'MQ' => 'MARTINIQUE',
            'MR' => 'MAURITANIA',
            'MU' => 'MAURITIUS',
            'YT' => 'MAYOTTE',
            'MX' => 'MEXICO',
            'FM' => 'MICRONESIA',
            'MD' => 'MOLDOVA',
            'MC' => 'MONACO',
            'MN' => 'MONGOLIA',
            'ME' => 'MONTENEGRO',
            'MS' => 'MONTSERRAT',
            'MA' => 'MOROCCO',
            'MZ' => 'MOZAMBIQUE',
            'MM' => 'MYANMAR',
            'NA' => 'NAMIBIA',
            'NR' => 'NAURU',
            'NP' => 'NEPAL',
            'NL' => 'NETHERLANDS',
            'AN' => 'NETHERLANDS ANTILLES',
            'NC' => 'NEW CALEDONIA',
            'NZ' => 'NEW ZEALAND',
            'NI' => 'NICARAGUA',
            'NE' => 'NIGER',
            'NG' => 'NIGERIA',
            'NU' => 'NIUE',
            'NF' => 'NORFOLK ISLAND',
            'KP' => 'NORTH KOREA',
            'MP' => 'NORTHERN MARIANA ISLANDS',
            'ND' => 'NORWAY',
            'OM' => 'OMAN',
            'PK' => 'PAKISTAN',
            'PW' => 'PALAU',
            'PS' => 'PALESTINIAN TERRITORIES',
            'PA' => 'PANAMA',
            'PG' => 'PAPUA NEW GUINEA',
            'PY' => 'PARAGUAY',
            'PE' => 'PERU',
            'PH' => 'PHILIPPINES',
            'PN' => 'PITCAIRN',
            'PL' => 'POLAND',
            'PT' => 'PORTUGAL',
            'PR' => 'PUERTO RICO',
            'QA' => 'QATAR',
            'RE' => 'RÉUNION',
            'RO' => 'ROMANIA',
            'RU' => 'RUSSIAN FEDERATION',
            'RW' => 'RWANDA',
            'BL' => 'SAINT BARTHÉLEMY',
            'SH' => 'SAINT HELENA',
            'KN' => 'SAINT KITTS AND NEVIS',
            'LC' => 'SAINT LUCIA',

            'PM' => 'SAINT PIERRE AND MIQUELON',
            'VC' => 'SAINT VINCENT AND THE GRENADINES',
            'WS' => 'SAMOA',
            'SM' => 'SAN MARINO',
            'ST' => 'SAO TOME AND PRINCIPE',
            'SA' => 'SAUDI ARABIA',
            'SN' => 'SENEGAL',
            'RS' => 'SERBIA',
            'SC' => 'SEYCHELLES',
            'SL' => 'SIERRA LEONE',
            'SG' => 'SINGAPORE',
            'SX' => 'SINT MAARTEN',
            'SK' => 'SLOVAKIA',
            'SI' => 'SLOVENIA',
            'SB' => 'SOLOMON ISLANDS',
            'SO' => 'SOMALIA',
            'ZA' => 'SOUTH AFRICA',
            'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
            'KR' => 'SOUTH KOREA',
            'SS' => 'SOUTH SUDAN',
            'ES' => 'SPAIN',
            'LK' => 'SRI LANKA',
            'SD' => 'SUDAN',
            'SR' => 'SURINAME',
            'SJ' => 'SVALBARD AND JAN MAYE',
            'SZ' => 'SWAZILAND',
            'SE' => 'SWEDEN',
            'CH' => 'SWITZERLAND',
            'SY' => 'SYRIAN ARAB REPUBLIC',
            'TW' => 'TAIWAN',
            'TJ' => 'TAJIKISTAN',
            'TZ' => 'TANZANIA',
            'TH' => 'THAILAND',
            'TL' => 'TIMOR-LESTE',
            'TG' => 'TOGO',
            'TK' => 'TOKELAU',
            'TO' => 'TONGA',
            'TT' => 'TRINIDAD AND TOBAGO',
            'TN' => 'TUNISIA',
            'TR' => 'TURKEY',
            'TM' => 'TURKMENISTAN',
            'TC' => 'TURKS AND CAICOS ISLANDS',
            'TV' => 'TUVALU',
            'UG' => 'UGANDA',
            'UA' => 'UKRAINE',
            'AE' => 'UNITED ARAB EMIRATES',
            'US' => 'UNITED STATES',
            'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS',
            'UK' => 'UNITED KINGDOM',
            'UY' => 'URUGUAY',
            'UZ' => 'UZBEKISTAN',
            'VU' => 'VANUATU',
            'VA' => 'VATICAN CITY',
            'VN' => 'VIET NAM',
            'VG' => 'VIRGIN ISLANDS, BRITISH',
            'VI' => 'VIRGIN ISLANDS, U.S.',
            'WF' => 'WALLIS AND FUTUNA',
            'EH' => 'WESTERN SAHARA',
            'YE' => 'YEMEN',
            'ZM' => 'ZAMBIA',
            'ZW' => 'ZIMBABWE'
        );
        return $array_countries;
    }

    protected function get_language_names()
    {
        $array_languages = array(
            'ar-XA' => 'Arabic',
            'bg' => 'Bulgarian',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'de' => 'German',
            'el' => 'Greek',
            'en' => 'English',
            'et' => 'Estonian',
            'es' => 'Spanish',
            'fi' => 'Finnish',
            'fr' => 'French',
            'in' => 'Indonesian',
            'ga' => 'Irish',
            'hr' => 'Hindi',
            'hu' => 'Hungarian',
            'he' => 'Hebrew',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'nl' => 'Dutch',
            'no' => 'Norwegian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'sv' => 'Swedish',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sr-CS' => 'Serbian',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'uk-UA' => 'Ukrainian',
            'zh-chs' => 'Chinese (Simplified)',
            'zh-cht' => 'Chinese (Traditional)'
        );
        return $array_languages;
    }

    protected function sdk_locale()
    {
        $config = array(
            'default' => 'Default',
            'af_ZA' => 'Afrikaans',
            'ar_AR' => 'Arabic',
            'az_AZ' => 'Azerbaijani',
            'be_BY' => 'Belarusian',
            'bg_BG' => 'Bulgarian',
            'bn_IN' => 'Bengali',
            'bs_BA' => 'Bosnian',
            'ca_ES' => 'Catalan',
            'cs_CZ' => 'Czech',
            'cy_GB' => 'Welsh',
            'da_DK' => 'Danish',
            'de_DE' => 'German',
            'el_GR' => 'Greek',
            'en_GB' => 'English (UK)',
            'en_PI' => 'English (Pirate)',
            'en_UD' => 'English (Upside Down)',
            'en_US' => 'English (US)',
            'eo_EO' => 'Esperanto',
            'es_ES' => 'Spanish (Spain)',
            'es_LA' => 'Spanish',
            'et_EE' => 'Estonian',
            'eu_ES' => 'Basque',
            'fa_IR' => 'Persian',
            'fb_LT' => 'Leet Speak',
            'fi_FI' => 'Finnish',
            'fo_FO' => 'Faroese',
            'fr_CA' => 'French (Canada)',
            'fr_FR' => 'French (France)',
            'fy_NL' => 'Frisian',
            'ga_IE' => 'Irish',
            'gl_ES' => 'Galician',
            'he_IL' => 'Hebrew',
            'hi_IN' => 'Hindi',
            'hr_HR' => 'Croatian',
            'hu_HU' => 'Hungarian',
            'hy_AM' => 'Armenian',
            'id_ID' => 'Indonesian',
            'is_IS' => 'Icelandic',
            'it_IT' => 'Italian',
            'ja_JP' => 'Japanese',
            'ka_GE' => 'Georgian',
            'km_KH' => 'Khmer',
            'ko_KR' => 'Korean',
            'ku_TR' => 'Kurdish',
            'la_VA' => 'Latin',
            'lt_LT' => 'Lithuanian',
            'lv_LV' => 'Latvian',
            'mk_MK' => 'Macedonian',
            'ml_IN' => 'Malayalam',
            'ms_MY' => 'Malay',
            'my_MM' => 'Burmese - MYANMAR',
            'nb_NO' => 'Norwegian (bokmal)',
            'ne_NP' => 'Nepali',
            'nl_NL' => 'Dutch',
            'nn_NO' => 'Norwegian (nynorsk)',
            'pa_IN' => 'Punjabi',
            'pl_PL' => 'Polish',
            'ps_AF' => 'Pashto',
            'pt_BR' => 'Portuguese (Brazil)',
            'pt_PT' => 'Portuguese (Portugal)',
            'ro_RO' => 'Romanian',
            'ru_RU' => 'Russian',
            'sk_SK' => 'Slovak',
            'sl_SI' => 'Slovenian',
            'sq_AL' => 'Albanian',
            'sr_RS' => 'Serbian',
            'sv_SE' => 'Swedish',
            'sw_KE' => 'Swahili',
            'ta_IN' => 'Tamil',
            'te_IN' => 'Telugu',
            'th_TH' => 'Thai',
            'tl_PH' => 'Filipino',
            'tr_TR' => 'Turkish',
            'uk_UA' => 'Ukrainian',
            'vi_VN' => 'Vietnamese',
            'zh_CN' => 'Chinese (China)',
            'zh_HK' => 'Chinese (Hong Kong)',
            'zh_TW' => 'Chinese (Taiwan)',
        );
        asort($config);
        return $config;
    }

    private function access_token_validity_check_for_user($access_token)
    {
        $config_id = $this->session->userdata('return_configid_used_for_social_login');
        $this->database_id = $config_id;
        $facebook_config = $this->basic->get_data("facebook_rx_config", array("where" => array("id" => $this->database_id)));

        $client_id = $facebook_config[0]["api_id"];
        $result = array();
        $url = "https://graph.facebook.com/v9.0/oauth/access_token_info?client_id={$client_id}&access_token={$access_token}";
        $headers = array("Content-type: application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $st = curl_exec($ch);
        $result = json_decode($st, TRUE);
        if (!isset($result["error"])) return 1;
        else return 0;
    }

    private function app_initialize($fb_rx_login_database_id)
    {

        $this->database_id = $fb_rx_login_database_id;
        $facebook_config = $this->basic->get_data("facebook_rx_config", array("where" => array("id" => $this->database_id)));

        if (isset($facebook_config[0])) {
            if (isset($facebook_config[0]['developer_access']) && $facebook_config[0]['developer_access'] == '1') {
                $encrypt_method = "AES-256-CBC";
                $secret_key = 't8Mk8fsJMnFw69FGG5';
                $secret_iv = '9fljzKxZmMmoT358yZ';
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16);
                $this->app_id = openssl_decrypt(base64_decode($facebook_config[0]["api_id"]), $encrypt_method, $key, 0, $iv);
                $this->app_secret = openssl_decrypt(base64_decode($facebook_config[0]["api_secret"]), $encrypt_method, $key, 0, $iv);
                $this->user_access_token = $facebook_config[0]["user_access_token"];
            } else {
                $this->app_id = $facebook_config[0]["api_id"];
                $this->app_secret = $facebook_config[0]["api_secret"];
                $this->user_access_token = $facebook_config[0]["user_access_token"];
            }
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $this->fb = new Facebook\Facebook([
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
                'default_graph_version' => 'v9.0',
                'fileUpload' => TRUE
            ]);

        }


    }

    public function update_your_account_info()
    {
        if (!$_POST) exit();
        $auto_id = $_POST['id'];

        $table_name = "facebook_rx_fb_page_info";
        $where['where'] = array('id' => $auto_id, 'user_id' => $this->user_id);
        $this->load->model('basic');
        $instagram_reply_page_info = $this->basic->get_data($table_name, $where);

        $page_access_token = isset($instagram_reply_page_info[0]['page_access_token']) ? $instagram_reply_page_info[0]['page_access_token'] : "";

        $instagram_business_account_id = isset($instagram_reply_page_info[0]['instagram_business_account_id']) ? $instagram_reply_page_info[0]['instagram_business_account_id'] : "";
        $instagram_reply_user_info_id = isset($instagram_reply_page_info[0]['facebook_rx_fb_user_info_id']) ? $instagram_reply_page_info[0]['facebook_rx_fb_user_info_id'] : "";

        $config_data = $this->basic->get_data("facebook_rx_fb_user_info", array("where" => array("id" => $instagram_reply_user_info_id)));
        $instagram_reply_login_database_id = isset($config_data[0]['facebook_rx_config_id']) ? $config_data[0]['facebook_rx_config_id'] : 0;


        $this->app_initialize($instagram_reply_login_database_id);
        $instagram_account_info = $this->instagram_account_info($instagram_business_account_id, $page_access_token);

        $instradata = array(
            'insta_followers_count' => isset($instagram_account_info['followers_count']) ? $instagram_account_info['followers_count'] : "",
            'insta_media_count' => isset($instagram_account_info['media_count']) ? $instagram_account_info['media_count'] : "",
            'insta_website' => isset($instagram_account_info['website']) ? $instagram_account_info['website'] : "",
            'insta_biography' => isset($instagram_account_info['biography']) ? $instagram_account_info['biography'] : "",
            'insta_username' => isset($instagram_account_info['username']) ? $instagram_account_info['username'] : "",
        );
        $where = array('id' => $auto_id);
        $this->basic->update_data('facebook_rx_fb_page_info', $where, $instradata);
        // $str = $instagram_account_info['followers_count'];
        $str = "Now you have {$instagram_account_info['followers_count']} followers and {$instagram_account_info['media_count']} media";
        $response = array();
        $response["message"] = $str;
        $response["count"] = $instagram_account_info['followers_count'];
        echo json_encode($response);
    }

    public function instagram_account_info($instagram_account_id, $page_access_token)
    {
        $request = $this->fb->get("{$instagram_account_id}?fields=id,username,followers_count,media_count,website,biography", $page_access_token);
        $response = $request->getGraphObject()->asArray();
        return $response;
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





//        $menu_exists = $this->db->query(" SELECT id FROM `menu_child_1` where url LIKE '%n_igstats%' ")->row_array();
//        $parent_id_to_add = $this->db->query(" SELECT parent_id, serial FROM `menu_child_1` where url LIKE '%instagram_reply/reports%' ")->row_array();
//        if(!$menu_exists){
//            try{
//                $sql_cust = "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'Instagram Statistics', 'fa fa-signal', 'n_igstats/', ".($parent_id_to_add['serial']+1).", '3008', '0', '0', '0', '0', '0', '0', ".$parent_id_to_add['parent_id'].");" ;
//                $this->db->query($sql_cust);
//            }catch(Exception $e){
//
//            }
//        }

//        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%n_igstats%' ")->row_array();
//        $parent_id_to_add = $this->db->query(" SELECT serial FROM `menu` where url LIKE '%search_tools%' ")->row_array();
//        if(!$menu_exists){
//            try{
//                $sql_cust = "INSERT INTO `menu` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`, `is_menu_manager`, `custom_page_id`) VALUES (NULL, 'Instagram Statistics', 'fa fa-signal', 'n_igstats/', ".$parent_id_to_add['serial'].", '3008', '0', '0', '0', '0', '0', '', '0', '0')" ;
//                $this->db->query($sql_cust);
//            }catch(Exception $e){
//
//            }
//        }

        //send blank array if you does not need sidebar entry,send a blank array if your addon does not need any sql to run
        $this->register_addon($addon_controller_name, $sidebar, $sql, $purchase_code);
    }

    public function fix_menu()
    {
        //read the entire string
        $str = file_get_contents(APPPATH . "views/comment_automation/comment_growth_tools.php");

        if (strpos($str, 'n_igstats/index') !== false) {
            echo 'Instagram Statistics added to Comment growth tools 1075';
            exit;
        }


        $off = strripos($str, "</li>");
        var_dump($off);

        $replace_code = '<li class="media">
	 									<img alt="image" class="mr-3" width="50" src="<?php echo base_url("assets/img/icon/clock.png"); ?>">
	 									<div class="media-body">
	 									<a href="<?php echo base_url("n_igstats/index"); ?>"><div class="media-title"><?php echo $this->lang->line("Statistics"); ?></div></a>
                                            <div class="text-job text-muted"><?php echo $this->lang->line("Statistics"); ?></div>
	 									</div>
                                        <div class="media-cta">
                                            <a href="<?php echo base_url("n_igstats/index"); ?>" class="btn btn-outline-primary"><?php echo $this->lang->line("Detail"); ?></a>
                                        </div>
	 								</li>';

        $str = substr_replace($str, $replace_code, $off + 7, 5);


        //write the entire string
        file_put_contents(APPPATH . "views/comment_automation/comment_growth_tools.php", $str);
        echo 'Instagram Statistics added to Comment growth tools';


//        $sql_cust = "DELETE from `menu_child_1` where url like '%n_igstats%' " ;
//        $this->db->query($sql_cust);
//
//        $menu_exists = $this->db->query(" SELECT id FROM `menu_child_1` where url LIKE '%n_igstats%' ")->row_array();
//        $parent_id_to_add = $this->db->query(" SELECT parent_id, serial FROM `menu_child_1` where url LIKE '%instagram_reply/reports%' ")->row_array();
//        if(!$menu_exists){
//            try{
//                $sql_cust = "INSERT INTO `menu_child_1` (`id`, `name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `is_external`, `is_menu_manager`, `custom_page_id`, `parent_id`) VALUES (NULL, 'Instagram Statistics', 'fa fa-signal', 'n_igstats/', ".($parent_id_to_add['serial']+1).", '3008', '0', '0', '0', '0', '0', '0', ".$parent_id_to_add['parent_id'].");" ;
//                $this->db->query($sql_cust);
//            }catch(Exception $e){
//
//            }
//        }
//        echo 'done';
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
            0 => "DELETE from `menu` where module_access = 3008",
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