<?php
/*
Addon Name: NVX Theme Dashboard Dynamic Price Helper
Unique Name: price
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.0
Description: NVX Theme Dashboard helper
*/
require_once("application/controllers/Home.php"); // loading home controller
require(APPPATH.'modules/n_theme/vendor/autoload.php');
use GeoIp2\Database\Reader;

class Price extends Home
{
    public $key = "70591F6C003CF201";
    private $product_id = 7;
    private $product_base = "price_dynamic";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 1.0;
    /* @var self */
    private static $selfobj = null;
    public $fb;

    private $default_plan = null;
    private $config_plan = null;


    public $addon_data = array();

    private $bulk_limit = array();
    private $monthly_limit = array();
    private $modules = array();

    public function __construct()
    {
        parent::__construct();
        //$this->load->config('instagram_reply_config');// config
        // getting addon information in array and storing to public variable
        // addon_name,unique_name,module_id,addon_uri,author,author_uri,version,description,controller_name,installed
        //------------------------------------------------------------------------------------------

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
                case 'plan_list';
                case 'save_plan';
                case 'edit_plan';
                case 'api_admin';
                case 'vat_edit';
                case 'vat_save';

                case 'coupon_edit';
                case 'coupon_save';
                case 'coupon_list';
                    if ($this->session->userdata('user_type') != 'Admin') {
                        redirect('home/login_page', 'location');
                        exit();
                    }
                    break;
            }


        }

        $this->load->library('encryption');

        $addon_lang = 'n_theme';
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_lang.php')) {
            $this->lang->load($addon_lang, $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language.'/');
        } else {
            $this->lang->load($addon_lang, 'english', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/english/');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($addon_lang . '_custom', $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language.'/');
        }

    }

    public function api($endpoint, $cust_1 = 0)
    {
        //$this->csrf_token_check();
//        if (!$this->input->is_ajax_request()) {
//            $this->return_json('Bad Request');
//        }

        switch ($endpoint) {
            case 'get_price_json';
                $this->get_price_json();
                break;
            case 'payment_summary':
                $this->payment_summary();
                break;
            case 'invoice_data':
                $this->invoice_data();
                break;
            case 'coupon_special_activate':
                $this->coupon_special_activate();
                break;

            default;
                $this->return_json('Bad Request');
                break;
        }
    }

    private function invoice_data(){
        $this->ajax_check();
        $this->csrf_token_check();
        include(FCPATH . 'application/n_views/config.php');

        $invoice_data = $this->input->post('invoice_data');
        $package_id = $this->input->post('package_id');

        $coupon = '';
        $vat_check_ue = false;
        $vat_included = false;
        $vat_collect = false;


            $pck = $this->basic->get_data('package', ['where' => ['id' => $package_id]], '', '', 1);
            if(!empty($pck[0]['origin_id'])){
                $ock = $this->basic->get_data('price_dynamic_plans', ['where' => ['id' => $pck[0]['origin_id']]], '', '', 1);
                if(!empty($ock[0])){
                    $ock[0]['config'] = json_decode($ock[0]['config'],true);
                    if($ock[0]['config']['vat']['vat_collect']=='1'){
                        $vat_collect = true;
                        if($ock[0]['config']['vat']['vat_check_eu']=='1'){
                            $vat_check_ue = true;
                        }
                        if($ock[0]['config']['vat']['vat_included']=='1'){
                            $vat_included = true;
                        }
                    }
                }
            }


        $invoice_data['vat_value'] = 0;
        //calculate PRICE include/exclude vat
        if(!empty($invoice_data['inv_country'])AND $vat_included){
            $vat_country = array();
            if(file_exists(APPPATH.'n_theme_vat_list.php')){
                include(APPPATH.'n_theme_vat_list.php');
            }

            $invoice_data['vat_value'] = $vat_country[$invoice_data['inv_country']];
        }

        //check VAT UE
        $invoice_data['vat_ue'] = 'n/a';
        if(!empty($invoice_data['inv_vat_number']) AND $vat_check_ue){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.vatcomply.com/vat?vat_number=".$invoice_data['inv_vat_number']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);

            $vat_details = json_decode($output,true);

            $invoice_data['vat_ue'] = 'not valid';
            if($vat_details['valid']){
                $invoice_data['vat_ue'] = 'valid';
                $invoice_data['vat_value'] = 0;
            }
        }

        if($vat_collect){
            if(!empty($pck[0]['vat_details'])){
                $pck[0]['vat_details'] = json_decode($pck[0]['vat_details'], true);
            }

            if(!empty($pck[0]['vat_details']['untouched_price'])){
                $invoice_data['origin_price'] = $pck[0]['vat_details']['untouched_price'];
            }else{
                $invoice_data['origin_price'] = $pck[0]['price'];
            }
            $invoice_data['untouched_price'] = $invoice_data['origin_price'];

            $coupon = $this->coupon_apply($invoice_data['untouched_price']);
            $invoice_data['origin_price'] = $coupon['price'];

            if($vat_included){
                $invoice_data['vat_calc'] = $invoice_data['origin_price'] / (($invoice_data['vat_value']+100)/100); //netto
                $invoice_data['new_price'] = $invoice_data['origin_price'] ;
                $invoice_data['vat_calc'] = $invoice_data['new_price'] - $invoice_data['vat_calc'];
            }else{
                if($invoice_data['vat_value']===0){
                    $invoice_data['new_price'] = $invoice_data['origin_price'];
                    $invoice_data['vat_calc'] = $invoice_data['new_price'];
                    $invoice_data['vat_calc'] = $invoice_data['new_price'] - $invoice_data['vat_calc'];
                }else{

                    $invoice_data['new_price'] = $invoice_data['origin_price'] * (($invoice_data['vat_value']+100)/100);
                    $invoice_data['vat_calc'] = $invoice_data['new_price'] / (($invoice_data['vat_value']+100)/100);
                    $invoice_data['vat_calc'] = $invoice_data['new_price'] - $invoice_data['vat_calc'];
                }

            }

            $invoice_data['vat_calc'] = round($invoice_data['vat_calc'], 2);
            $invoice_data['new_price'] = round($invoice_data['new_price'], 2);

            $package_update = array(
                'vat_details' => json_encode($invoice_data),
                'price' => $invoice_data['new_price']
            );
            $this->basic->update_data("package",array("id"=>$pck[0]['id']),$package_update);
        }else{
            if(!empty($pck[0]['vat_details'])){
                $pck[0]['vat_details'] = json_decode($pck[0]['vat_details'], true);
            }

            if(!empty($pck[0]['vat_details']['untouched_price'])){
                $invoice_data['origin_price'] = $pck[0]['vat_details']['untouched_price'];
            }else{
                $invoice_data['origin_price'] = $pck[0]['price'];
            }
            $invoice_data['untouched_price'] = $invoice_data['origin_price'];

            $coupon = $this->coupon_apply($invoice_data['untouched_price']);
            $invoice_data['origin_price'] = $coupon['price'];
            $invoice_data['new_price'] = $coupon['price'];
            $invoice_data['vat_calc'] = 0;

            $package_update = array(
                'vat_details' => json_encode($invoice_data),
                'price' => $invoice_data['new_price']
            );
            $this->basic->update_data("package",array("id"=>$pck[0]['id']),$package_update);
        }

        $insert = array(
            'invoice_data' => json_encode($invoice_data)
        );

        //save last used invoice data to user
        $this->basic->update_data("users",array("id"=>$this->user_id),$insert);

        $this->return_json(1,
            array(
                'vat_ue' => $invoice_data['vat_ue'],
                'vat_value' => $invoice_data['vat_value'],
                'vat_collect' => $vat_collect,
                'new_price' => $invoice_data['new_price'],
                'vat_calc' => $invoice_data['vat_calc'],
                'coupon' => $coupon
            )
        );
    }

    private function coupon_apply($price){
        $coupon_code = $this->input->post('discount_coupon');
        $package_id = $this->input->post('package_id');
        $final_action = $this->input->post('final_action');

        $cpdet = $this->basic->get_data('dynamic_coupons', ['where' => ['coupon_code' => $coupon_code]], '', '', 1);

        $return = array(
            'coupon_info' => $this->lang->line('This coupon is invalid'),
            'coupon_apply' => 'bypass',
            'price' => $price
        );

        if(!empty($cpdet[0])){
            $coupon_value = $cpdet[0]['value'];
            if($cpdet[0]['used_count'] >= $cpdet[0]['use_count']){
                $return['coupon_apply'] = false;
                return $return;
            }
            switch($cpdet[0]['value_type']){
                case 'percentage':
                    $return['discount'] = $price * $coupon_value / 100;
                    $price = $price - ($price * $coupon_value / 100);
                    if($price==0){
                        $return['special'] = true;
                    }
                    break;
                case 'fixed':
                    $price = $price - $coupon_value;
                    $return['discount'] = $coupon_value;
                    break;
            }

            if($price<0){
                $price = 0;
            }

            $price = round($price,2);
            $return['discount'] = round($return['discount'],2);

            $return['coupon_apply'] = true;
            $return['price'] = $price;
            //final action button and used_count ++

            if($final_action==1 OR $final_action=='1'){
                $data_up = array('used_count'=>$cpdet[0]['used_count']+1);
                $pck_where = ['id' => $cpdet[0]['id']];
                $this->basic->update_data('dynamic_coupons', $pck_where, $data_up);
            }

            return $return;
        }else{
            if(!empty($coupon_code)){
                $return['coupon_apply'] = false;
                return $return;
            }
        }

        return $return;
    }

    private function payment_summary(){

        $summary_period = $this->input->post('period');

        $pricing = $this->get_price($summary_period);

        $validity_type_arr['D'] = 1;
        $validity_type_arr['W'] = 7;
        $validity_type_arr['M'] = 30;
        $validity_type_arr['Y'] = 365;

        $package_name=$pricing['ps']['package_name'];
        $price=$pricing['ps']['price'];
        $visible=$pricing['ps']['visible'];
        $highlight=$pricing['ps']['highlight'];

        if($visible=='') $visible='0';
        if($highlight=='') $highlight='0';

        $validity_amount=$pricing['ps']['period_value'];
        $validity_type=$pricing['ps']['period'];
        $validity = $validity_amount * $validity_type_arr[$validity_type];
        $validity_extra_info = implode(',', array($validity_amount, $validity_type));


        $bulk_limit=$pricing['ps']['bulk_limit'];
        $monthly_limit=$pricing['ps']['monthly_limit'];

        $modules_str=implode(',', $this->modules);

        $data=array
        (
            'package_name'=>$package_name,
            'price'=>$price,
            'validity'=>$validity,
            'visible'=>$visible,
            'highlight'=>$highlight,
            'validity_extra_info'=>$validity_extra_info,
            'module_ids'=>$modules_str,
            'monthly_limit'=>json_encode($monthly_limit),
            'bulk_limit'=>json_encode($bulk_limit),
            'currency'=> $pricing['ps']['currency'],
            'user_id'=>$this->user_id,
            'return_json'=>json_encode($pricing),
            'origin_id'=>$pricing['ps']['origin_id'],
            'vat_details' => ''
        );


        //get user
        $where = [
            'where' => [
                'id' => $this->user_id
            ],
        ];
        $user_info = $this->basic->get_data('users', $where, '', [], 1);

        if(!empty($user_info)){
            $where = [
                'where' => [
                    'user_id' => $this->user_id,
                    'id !=' => $user_info[0]['package_id']
                ],
            ];
            $pck_info = $this->basic->get_data('package', $where, '', [], 1);
            if(empty($pck_info)){
                $this->basic->insert_data('package',$data);
                $return_id = $this->db->insert_id();
            }else{
                $pck_where = ['id' => $pck_info[0]['id']];
                $this->basic->update_data('package', $pck_where, $data);
                $return_id = $pck_info[0]['id'];
            }
        }

        $data_return = array(
            'id' => $return_id
        );

        $this->return_json(1, $data_return);
    }

    private function get_price_cp($pricing_on = 0){
        include(FCPATH . 'application/n_views/config.php');
        $this->default_plan();

        if($n_config['dp_country_on']=='true'){
            $reader = new Reader(APPPATH.'modules/n_theme/db/GeoLite2-Country/GeoLite2-Country.mmdb');
            $record = $reader->country($_SERVER['REMOTE_ADDR']);

            $dp_country = '"'.$record->country->geonameId.'"';
        }else{
            $dp_country = '"0"';
        }

        $dp_plan_dyn = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => $dp_country, 'active' => 1, 'fixed_plan' => 1]], '', '', 1);
        if(empty($dp_plan_dyn)){
            $dp_plan_dyn = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => '"0"', 'active' => 1, 'fixed_plan' => 1]], '', '', 1);
        }

        if(!empty($dp_plan_dyn)) {
            $dp_parsed_plans_dyn = array();
            foreach ($dp_plan_dyn as $dpv) {
                $dpv['config'] = json_decode($dpv['config'], true);

                $dpv['config']['config_plan'] = array_replace_recursive($this->default_plan, $dpv['config']['config_plan']);

                $dp_parsed_plans_dyn = array(
                    'name' => $dpv['name'],
                    'id' => $dpv['id'],
                    'id_type' => 1,
                    'validity_type' => $dpv['config']['period_1']['type'],
                    'validity_value' => $dpv['config']['period_1']['value'],
                    'price' => $dpv['config']['period_1']['price_fixed'],
                    'currency' => $dpv['currency'],
                    'config_plan' => $dpv['config']['config_plan'],
                    'highlight' => $dpv['highlight']
                ); //price1

                $return = array();
                $period_1 = array();
                $total_price_period_1 = 0;
                $total_price_period_2 = 0;
                $free = array();
                foreach ($dp_parsed_plans_dyn['config_plan'] as $key => $row) {
                    if ($row['enabled'] == 0) {
                        continue;
                    };
                    if ($row['free'] == 1) {
                        $free[$key] = array(
                            'title' => $this->lang->line('dpv_' .$key),
                            'sliders' => array()
                        );
                    }else{

                        $period_1[$key] = array(
                            'title' => $this->lang->line('dpv_' .$key),
                            'sliders' => array()
                        );
                    }

                    foreach ($row['sliders'] as $k => $slider) {
                        if ($row['free'] == 1) {
                            $free[$key]['sliders'][$k] = array(
                                'lang_title' => $slider['lang'],
                            );
                            continue;
                        }
//                        if(!empty($get_post[$key])){

                            if($dpv['fixed_plan']==1){
                                $selected_slider = 'fixed';
                            }else{
                                $selected_slider = $get_post[$key]['slider'][$k];
                            }

                            $price = $this->get_price_slider($slider['config'], $selected_slider);



                            $period_1[$key]['sliders'][$k] = array(
                                'lang_title' => $slider['lang'],
                                'selected_val' => $price['min_value'],
                                'price_unit_period_1' => $price['p1'],
                                'price_unit_period_2' => $price['p2'],
                                'is_unlimited' => (int)$price['is_unlimited'],
                                'total_price_period_1' => $price['p1_total'],
                                'total_price_period_2' => $price['p2_total']
                            );

                            $total_price_period_1 += $price['p1_total'];
                            $total_price_period_2 += $price['p2_total'];

                            if($pricing_on>0){
                                if(isset($slider['monthly_limit'])){
                                    $this->package_user_set($slider['monthly_limit'],$price['min_value']);
                                }
                                if(isset($slider['bulk_limit'])){
                                    $this->package_user_set_bulk($slider['bulk_limit'],$price['min_value']);
                                }
                            }
                        }
//                    }

                    $total_price_period_1 = round($total_price_period_1, 2);
                    $total_price_period_2 = round($total_price_period_2, 2);



                    if($pricing_on>0){
                        $this->package_user_set_modules($row['modules']);
                    }

                    if(empty($period_1[$key]['sliders']) AND $row['free'] == 0){
                        unset($period_1[$key]);
                    }
                }

            }

            $return_json = array(
                'details' => $period_1,
                'free_tools' => $free,
                'currency' => $dp_parsed_plans_dyn['currency'],
                'summary' => array(
                    'total_price_1' => $total_price_period_1,
                    'total_price_2' => $total_price_period_2,
                    'period_1_name' => $dpv['config']['period_1']['value'].' '.$this->lang->line($dpv['config']['period_1']['type']),
                    'period_2_name' => $dpv['config']['period_2']['value'].' '.$this->lang->line($dpv['config']['period_2']['type'])
                )
            );

            if($pricing_on > 0){
                if($pricing_on==1){
                    $price_amount = $dpv['config']['period_1']['price_fixed'];
                    $period_type = $dpv['config']['period_1']['type'];
                }else{
                    $price_amount = $dpv['config']['period_2']['price_fixed'];
                    $period_type = $dpv['config']['period_2']['type'];
                }

                switch($period_type){
                    case 'days';
                        $period_type = "D";
                        break;
                    case 'month';
                        $period_type = "M";
                        break;
                    case 'year';
                        $period_type = "Y";
                        break;
                }

                $return_json['ps'] = array(
                    'package_name' => $dpv['name'].' '.$this->user_id,
                    'price' => $price_amount,
                    'visible' => 0,
                    'highlight' => 0,
                    'period_type' => $pricing_on,
                    'period' => $period_type,
                    'period_value' => $dpv['config']['period_'.$pricing_on]['value'],
                    'monthly_limit' => $this->monthly_limit,
                    'bulk_limit' => $this->bulk_limit,
                    'modules' => $this->modules,
                    'currency' => $dp_parsed_plans_dyn['currency'],
                    'pm' => $dpv['payments_method'],
                    'origin_id'=>$dpv['id'],
                );

            }


            return $return_json;

        }else{
            return array();
        }
    }

    public function create_package($id_package, $id_type){
        $pricing = $this->get_price_cp($id_type);

        $validity_type_arr['D'] = 1;
        $validity_type_arr['W'] = 7;
        $validity_type_arr['M'] = 30;
        $validity_type_arr['Y'] = 365;

        $package_name=$pricing['ps']['package_name'];
        $price=$pricing['ps']['price'];
        $visible=$pricing['ps']['visible'];
        $highlight=$pricing['ps']['highlight'];

        if($visible=='') $visible='0';
        if($highlight=='') $highlight='0';

        $validity_amount=$pricing['ps']['period_value'];
        $validity_type=$pricing['ps']['period'];
        $validity = $validity_amount * $validity_type_arr[$validity_type];
        $validity_extra_info = implode(',', array($validity_amount, $validity_type));


        $bulk_limit=$pricing['ps']['bulk_limit'];
        $monthly_limit=$pricing['ps']['monthly_limit'];

        $modules_str=implode(',', $this->modules);

        $pricing['ps']['fixed_price'] = 1;

        $data=array
        (
            'package_name'=>$package_name,
            'price'=>$price,
            'validity'=>$validity,
            'visible'=>$visible,
            'highlight'=>$highlight,
            'validity_extra_info'=>$validity_extra_info,
            'module_ids'=>$modules_str,
            'monthly_limit'=>json_encode($monthly_limit),
            'bulk_limit'=>json_encode($bulk_limit),
            'currency'=> $pricing['ps']['currency'],
            'user_id'=>$this->user_id,
            'return_json'=>json_encode($pricing),
            'origin_id'=>$pricing['ps']['origin_id'],
            'vat_details' => ''
        );


        //get user
        $where = [
            'where' => [
                'id' => $this->user_id
            ],
        ];
        $user_info = $this->basic->get_data('users', $where, '', [], 1);

        if(!empty($user_info)){
            $where = [
                'where' => [
                    'user_id' => $this->user_id,
                    'id !=' => $user_info[0]['package_id']
                ],
            ];
            $pck_info = $this->basic->get_data('package', $where, '', [], 1);
            if(empty($pck_info)){
                $this->basic->insert_data('package',$data);
                $return_id = $this->db->insert_id();
            }else{
                $pck_where = ['id' => $pck_info[0]['id']];
                $this->basic->update_data('package', $pck_where, $data);
                $return_id = $pck_info[0]['id'];
            }
        }

        $data_return = array(
            'id' => $return_id
        );

        redirect('payment/payment_button/'.$return_id, 'location');
    }

    private function package_user_set($perms, $selected){
        foreach($perms as $k => $v){
            if($v==='set'){
                $this->monthly_limit[$k]=$selected;
                if($v===0){
                    $this->monthly_limit[$k]=$v;
                }
            }else{
                $this->monthly_limit[$k]=$v;
            }
            $this->bulk_limit[$k]=0;
        }
    }

    private function package_user_set_bulk($perms, $selected){
        foreach($perms as $k => $v){
            if($v==='set'){
                $this->bulk_limit[$k]=$selected;
            }else{
                $this->bulk_limit[$k]=$v;
            }
        }
    }

    private function package_user_set_modules($perms){
        foreach($perms as $k => $v){
            $this->modules[$v] = $v;
        }
    }

    private function parse_slider_ar($data, $type){
        $data = explode(PHP_EOL, $data);
        foreach($data as $k => $v){
            $data[$k] = $this->parse_slider($v, $type);
        }
        return $data;
    }

    private function parse_slider($slider, $id_type){
        $exp = explode(';', $slider);
        $ar1 = array(
            'min_value' => $exp[0],
            'price' => $exp[$id_type], //1 or 2
            'is_unlimited' => $exp[3],
        );
        return $ar1;
    }

    private function get_price($pricing_on = 0){
        $this->ajax_check();
        $this->csrf_token_check();
        include(FCPATH . 'application/n_views/config.php');
        $this->default_plan();

        $get_post = $this->input->post('query', true);

        if($n_config['dp_country_on']=='true'){
            $reader = new Reader(APPPATH.'modules/n_theme/db/GeoLite2-Country/GeoLite2-Country.mmdb');
            $record = $reader->country($_SERVER['REMOTE_ADDR']);

            $dp_country = '"'.$record->country->geonameId.'"';
        }else{
            $dp_country = '"0"';
        }

        $dp_plan_dyn = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => $dp_country, 'active' => 1, 'fixed_plan' => 0]], '', '', 1);
        if(empty($dp_plan_dyn)){
            $dp_plan_dyn = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => '"0"', 'active' => 1, 'fixed_plan' => 0]], '', '', 1);
        }

        if(!empty($dp_plan_dyn)) {
            $dp_parsed_plans_dyn = array();
            foreach ($dp_plan_dyn as $dpv) {
                $dpv['config'] = json_decode($dpv['config'], true);

                $dpv['config']['config_plan'] = array_replace_recursive($this->default_plan, $dpv['config']['config_plan']);

                $dp_parsed_plans_dyn = array(
                    'name' => $dpv['name'],
                    'id' => $dpv['id'],
                    'id_type' => 1,
                    'validity_type' => $dpv['config']['period_1']['type'],
                    'validity_value' => $dpv['config']['period_1']['value'],
                    'price' => $dpv['config']['period_1']['price_fixed'],
                    'currency' => $dpv['currency'],
                    'config_plan' => $dpv['config']['config_plan'],
                    'highlight' => $dpv['highlight']
                ); //price1

                $return = array();
                $period_1 = array();
                $total_price_period_1 = 0;
                $total_price_period_2 = 0;
                $free = array();
                foreach ($dp_parsed_plans_dyn['config_plan'] as $key => $row) {
                    if (
                        (empty($get_post[$key]) AND $row['free']==0)
                        OR
                        (isset($get_post[$key]['enabled']) AND $get_post[$key]['enabled'] =='false' AND $row['free']==0)
                    ) {
                        continue;
                    }
                    if ($row['enabled'] == 0) {
                        continue;
                    };
                    if ($row['free'] == 1) {
                        $free[$key] = array(
                            'title' => $this->lang->line('dpv_' .$key),
                            'sliders' => array()
                        );
                    }else{

                        $period_1[$key] = array(
                            'title' => $this->lang->line('dpv_' .$key),
                            'sliders' => array()
                        );
                    }

                    foreach ($row['sliders'] as $k => $slider) {
                        if ($row['free'] == 1) {
                            $free[$key]['sliders'][$k] = array(
                                'lang_title' => $slider['lang'],
                            );
                            if($pricing_on>0){
                                if(isset($slider['monthly_limit'])){
                                    $this->package_user_set($slider['monthly_limit'],'fixed');
                                }
                                if(isset($slider['bulk_limit'])){
                                    $this->package_user_set_bulk($slider['bulk_limit'],'fixed');
                                }
                            }
                            continue;
                        }
                        if(!empty($get_post[$key])){

                            if($dpv['fixed_plan']==1){
                                $selected_slider = 'fixed';
                            }else{
                                $selected_slider = $get_post[$key]['slider'][$k];
                            }

                            $price = $this->get_price_slider($slider['config'], $selected_slider);

                            $period_1[$key]['sliders'][$k] = array(
                                'lang_title' => $slider['lang'],
                                'selected_val' => $get_post[$key]['slider'][$k],
                                'price_unit_period_1' => $price['p1'],
                                'price_unit_period_2' => $price['p2'],
                                'is_unlimited' => (int)$price['is_unlimited'],
                                'total_price_period_1' => $price['p1_total'],
                                'total_price_period_2' => $price['p2_total']
                            );

                            $total_price_period_1 += $price['p1_total'];
                            $total_price_period_2 += $price['p2_total'];

                            if($pricing_on>0){
                                if(isset($slider['monthly_limit'])){
                                    $this->package_user_set($slider['monthly_limit'],$get_post[$key]['slider'][$k]);
                                }
                                if(isset($slider['bulk_limit'])){
                                    $this->package_user_set_bulk($slider['bulk_limit'],$get_post[$key]['slider'][$k]);
                                }
                            }
                        }
                    }

                    $total_price_period_1 = round($total_price_period_1, 2);
                    $total_price_period_2 = round($total_price_period_2, 2);



                    if($pricing_on>0){
                        $this->package_user_set_modules($row['modules']);
                    }

                    if(empty($period_1[$key]['sliders']) AND $row['free'] == 0){
                       unset($period_1[$key]);
                    }
                }

            }

            $return_json = array(
                'details' => $period_1,
                'free_tools' => $free,
                'currency' => $dp_parsed_plans_dyn['currency'],
                'summary' => array(
                    'total_price_1' => $total_price_period_1,
                    'total_price_2' => $total_price_period_2,
                    'period_1_name' => $dpv['config']['period_1']['value'].' '.$this->lang->line($dpv['config']['period_1']['type']),
                    'period_2_name' => $dpv['config']['period_2']['value'].' '.$this->lang->line($dpv['config']['period_2']['type'])
                )
            );

            if($pricing_on > 0){
                if($pricing_on==1){
                    $price_amount = $total_price_period_1;
                    $period_type = $dpv['config']['period_1']['type'];
                }else{
                    $price_amount = $total_price_period_2;
                    $period_type = $dpv['config']['period_2']['type'];
                }

                switch($period_type){
                    case 'days';
                        $period_type = "D";
                    break;
                    case 'month';
                        $period_type = "M";
                        break;
                    case 'year';
                        $period_type = "Y";
                        break;
                }

                $return_json['ps'] = array(
                    'package_name' => $dpv['name'].' '.$this->user_id,
                    'price' => $price_amount,
                    'visible' => 0,
                    'highlight' => 0,
                    'period_type' => $pricing_on,
                    'period' => $period_type,
                    'period_value' => $dpv['config']['period_'.$pricing_on]['value'],
                    'monthly_limit' => $this->monthly_limit,
                    'bulk_limit' => $this->bulk_limit,
                    'modules' => $this->modules,
                    'currency' => $dp_parsed_plans_dyn['currency'],
                    'pm' => $dpv['payments_method'],
                    'origin_id'=>$dpv['id'],
                );

            }


            return $return_json;

        }else{
            return array();
        }
    }

    private function get_price_json(){
        $this->return_json(1, $this->get_price());
    }

    private function get_price_slider($config, $selected_value){
        $data = explode(PHP_EOL, $config);
        $price = array();

        $sel_val = $selected_value;

        foreach($data as $k => $v){
            $parsed_1 = $this->parse_slider($v, 1);
            $parsed_2 = $this->parse_slider($v, 2);
            if($selected_value==='fixed'){
                    $parsed_1 = $this->parse_slider($v, 1);
                    $parsed_2 = $this->parse_slider($v, 2);
                    $price['p1'] = $parsed_1['price'];
                    $price['p2'] = $parsed_2['price'];
                    $price['is_unlimited'] = $parsed_1['is_unlimited'];
                    $sel_val = $parsed_1['min_value'];
            }else{
                foreach($data as $k => $v){
                    if($parsed_1['min_value'] <= $selected_value){
                        $price['p1'] = $parsed_1['price'];
                        $price['p2'] = $parsed_2['price'];
                        $price['is_unlimited'] = $parsed_1['is_unlimited'];
                    }

                }
            }
        }

        if($price['is_unlimited']==0){
            $price['p1_total'] = round($price['p1'] * $sel_val, 2);
            $price['p2_total'] = round($price['p2'] * $sel_val, 2);
        }else{
            $price['p1_total'] = $price['p1'];
            $price['p2_total'] = $price['p2'];
        }

        $price['min_value'] = $sel_val;

        return $price;
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

    public function api_admin($endpoint){
        $this->csrf_token_check();
        if (!$this->input->is_ajax_request()) {
            $this->return_json('Bad Request');
        }

        switch ($endpoint) {
            case 'plans':
                $this->plans();
                break;
            case 'coupons':
                $this->coupons_js();
                break;
            case 'coupon_delete':
                $this->coupon_delete();
                break;
            case 'plan_delete':
                $this->coupon_delete();
                break;
            case 'invoice_upload':
                $this->invoice_upload();
                break;
            case 'invoice_get_data':
                $this->invoice_get_data();
                break;
            case 'invoice_delete_file':
                $this->invoice_delete_file();
                break;

        }
    }

    private function plans(){
        $this->ajax_check();
        $search_value = $_POST['search']['value'];
        $display_columns = array('id', 'name', 'currency', 'fixed_plan');
        $search_columns = array('title');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'name';

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

        $table = "price_dynamic_plans";
        $select = array("price_dynamic_plans.*");
        $info = $this->basic->get_data($table, $where, $select, '', $limit, $start, $order_by, $group_by = '');
        $total_rows_array = $this->basic->count_row($table, $where, $count = $table . ".id", '', $group_by = '');
        $total_result = $total_rows_array[0]['total_rows'];

        $i = 0;
        $base_url = base_url();
        foreach ($info as $key => $value) {
            $info[$i]['name'] = '<a href="' . $base_url . 'price/edit_plan/' . $value['id'] . '">' . $value['name'] . '</a>';

            $info[$i]['name'] .= '<div class="row-actions">

            <span><a href="' . $base_url . 'price/edit_plan/' . $value['id'] . '">'.$this->lang->line('edit').'</a> | </span>
            ';

            $info[$i]['name'] .= '<span><a href="#" class="delete_document" data-id="'.$value['id'].'">'.$this->lang->line('delete').'</a></span>';

            $info[$i]['name'] .= '</div>';

            if($info[$i]['fixed_plan']==1){
                $info[$i]['fixed_plan'] = $this->lang->line('Fixed plan');
            }else{
                $info[$i]['fixed_plan'] = '';
            }

            $i++;
        }


        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($info, $display_columns, $start, $primary_key = "id");

        echo json_encode($data);
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

    public function plan_list(){
        $data = array();
        $data['body'] = '../modules/n_theme/views/n_addon_loader';
        $data['addon_page'] = 'modules/n_theme/views/view_plan_list';
        $data['page_title'] = $this->lang->line('Dynamic Price Plan Configuration');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');



        $this->_viewcontroller($data);
    }



    private function get_plan($value){
        if(empty($this->default_plan)){
            $this->default_plan = $this->default_plan();
        }

        $nvalue = explode('.', $value);

        if(!empty($nvalue[1])){
            if(!empty($this->default_plan[$nvalue[0]][$nvalue[1]])){
                return $this->default_plan[$nvalue[0]][$nvalue[1]];
            }
        }
    }

    private function default_plan(){
        include(APPPATH.'modules/n_theme/lib/default_plan.php');
        $this->default_plan = $dp_default;
    }

    public function edit_plan($id=0){
        $data = array();
        $data['body'] = '../modules/n_theme/views/n_addon_loader';
        $data['addon_page'] = 'modules/n_theme/views/edit_plan';
        $data['page_title'] = $this->lang->line('Edit Dynamic Price Plan');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');
        $data['period_type'] = array(
            'days' => $this->lang->line('days'),
            'month' => $this->lang->line('month'),
            'year' => $this->lang->line('year'),
        );
        $data['currency_list_all'] = $this->currecny_list_all();
        $data['id_plan'] = $id;


        $this->default_plan();


        $current_settings = array();
        if($id>0){
            $edit_plan = $this->basic->get_data('price_dynamic_plans', ['where' => ['id' => $id]], '', '', 1);

            if(!empty($edit_plan[0]['config'])){
                $edit_plan[0]['config'] = json_decode($edit_plan[0]['config'], true);
                if(!empty($edit_plan[0]['config']['config_plan'])){
                    $this->default_plan = array_replace_recursive($this->default_plan, $edit_plan[0]['config']['config_plan']);
                }
                $current_settings = $edit_plan[0];
                $data['pck'] = $edit_plan[0];
            }

        }



        $data['default_settings'] = $this->default_settings($current_settings);

        $data['default_plan'] = $this->default_plan;

        $data['country_list'] = $this->country_list();

        $data['payments_list'] = $this->payments_list();


        $this->_viewcontroller($data);
    }

    public function vat_edit(){
        $data = array();
        $data['body'] = '../modules/n_theme/views/n_addon_loader';
        $data['addon_page'] = 'modules/n_theme/views/edit_vat';
        $data['page_title'] = $this->lang->line('Edit Country Vat');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');

        $vat_country = array();
        if(file_exists(APPPATH.'n_theme_vat_list.php')){
            include(APPPATH.'n_theme_vat_list.php');
        }

        $data['vat_country'] = $vat_country;
        $data['country_list'] = $this->country_list();

        $this->_viewcontroller($data);
    }

    public function vat_save(){
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        if ($_POST) {
            $this->csrf_token_check();

            $vat_data = "<?php \n";
            foreach($_POST as $k => $v){
                if($k=='csrf_token' AND !is_int($k)){continue;}
                $vat_data .= "\$vat_country[".$k."] = ".$v.";\n";
            }

            file_put_contents(APPPATH.'n_theme_vat_list.php', $vat_data, LOCK_EX);
        }

        $this->session->set_flashdata('success_message', 1);
        redirect('price/plan_list', 'location');
    }

    private function default_settings($saved){
        $default_settings = array(
            'plan_name' => ((isset($saved['name'])) ? $saved['name'] : ''),

            'period_1_value' => ((isset($saved['config']['period_1']['value'])) ? $saved['config']['period_1']['value'] : ''),
            'period_1_type' => ((isset($saved['config']['period_1']['type'])) ? $saved['config']['period_1']['type'] : ''),
            'period_1_price_fixed' => ((isset($saved['config']['period_1']['price_fixed'])) ? $saved['config']['period_1']['price_fixed'] : ''),

            'period_2_value' => ((isset($saved['config']['period_2']['value'])) ? $saved['config']['period_2']['value'] : ''),
            'period_2_type' => ((isset($saved['config']['period_2']['type'])) ? $saved['config']['period_2']['type'] : ''),
            'period_2_price_fixed' => ((isset($saved['config']['period_2']['price_fixed'])) ? $saved['config']['period_2']['price_fixed'] : ''),

            'currency' => ((isset($saved['currency'])) ? $saved['currency'] : ''),
            'payment_methods' => '',
            'country_restriction' => '',
            'fixed_plan' => ((isset($saved['fixed_plan'])) ? $saved['fixed_plan'] : ''),

            'status' => ((isset($saved['active'])) ? $saved['active'] : ''),
            'highlight' => ((isset($saved['highlight'])) ? $saved['highlight'] : ''),

            'dporder' => ((isset($saved['dporder'])) ? $saved['dporder'] : ''),

            'vat_value' => ((isset($saved['config']['vat']['vat_value'])) ? $saved['config']['vat']['vat_value'] : ''),
            'vat_collect' => ((isset($saved['config']['vat']['vat_collect'])) ? $saved['config']['vat']['vat_collect'] : ''),
            'vat_included' => ((isset($saved['config']['vat']['vat_included'])) ? $saved['config']['vat']['vat_included'] : ''),
            'vat_data' => ((isset($saved['config']['vat']['vat_data'])) ? $saved['config']['vat']['vat_data'] : ''),
            'vat_check_eu' => ((isset($saved['config']['vat']['vat_check_eu'])) ? $saved['config']['vat']['vat_check_eu'] : ''),
        );

        return $default_settings;
    }

    public function save_plan($id){

        $queryString = file_get_contents('php://input');
        $data = array();
        parse_str($queryString, $data);

        $this->default_plan();
        $default_plan = $this->default_plan;

        $to_json = array();
        foreach($data['data'] as $k => $v){
            $nvalue = explode('.', $k);

            if(isset($nvalue[0])){
                if(isset($nvalue[1])){
                    if(isset($nvalue[2])){
                        if(isset($nvalue[3])){
                            $to_json[$nvalue[0]][$nvalue[1]][$nvalue[2]][$nvalue[3]] = $v;
                            continue;
                        }
                        $to_json[$nvalue[0]][$nvalue[1]][$nvalue[2]] = $v;
                        continue;
                    }
                    $to_json[$nvalue[0]][$nvalue[1]] = $v;
                    continue;
                }
                $to_json[$nvalue[0]] = $v;
                continue;
            }
        }


        if ($_POST) {

            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('plan_name', '<b>' . $this->lang->line("Use NVX theme login page style?") . '</b>', 'trim');


            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->settings();
            } else {
                // assign
                $plan_name = addslashes(strip_tags($this->input->post('plan_name', true)));
                $vat_collect = addslashes(strip_tags($this->input->post('vat_collect', true)));

                $vat_included = addslashes(strip_tags($this->input->post('vat_included', true)));
                $vat_value = addslashes(strip_tags($this->input->post('vat_value', true)));
                $vat_data = addslashes(strip_tags($this->input->post('vat_data', true)));
                $vat_check_eu = addslashes(strip_tags($this->input->post('vat_check_eu', true)));

                $period_1_value = addslashes(strip_tags($this->input->post('period_1_value', true)));
                $period_1_type = addslashes(strip_tags($this->input->post('period_1_type', true)));
                $period_1_price_fixed = addslashes(strip_tags($this->input->post('period_1_price_fixed', true)));
                $period_2_value = addslashes(strip_tags($this->input->post('period_2_value', true)));
                $period_2_type = addslashes(strip_tags($this->input->post('period_2_type', true)));
                $period_2_price_fixed = addslashes(strip_tags($this->input->post('period_2_price_fixed', true)));

                $status = addslashes(strip_tags($this->input->post('status', true)));
                $currency = addslashes(strip_tags($this->input->post('currency', true)));
                $country_restriction = addslashes(strip_tags($this->input->post('country_restriction', true)));
                $highlight = addslashes(strip_tags($this->input->post('highlight', true)));
                $fixed_plan = addslashes(strip_tags($this->input->post('fixed_plan', true)));


                $insert = array();
                $insert['name'] = $plan_name;
                $insert['payments_method'] = json_encode($_POST['payment_methods']);
                $insert['config'] = array(
                    'config_plan' => $to_json,
                    'vat' => array(
                        'vat_collect' => $vat_collect,
                        'vat_included' => $vat_included,
                        'vat_value' => $vat_value,
                        'vat_data' => $vat_data,
                        'vat_check_eu' => $vat_check_eu,
                    ),
                    'period_1' => array(
                        'value' => $period_1_value,
                        'type' => $period_1_type,
                        'price_fixed' => $period_1_price_fixed,
                    ),
                    'period_2' => array(
                        'value' => $period_2_value,
                        'type' => $period_2_type,
                        'price_fixed' => $period_2_price_fixed,
                    )
                );
                $insert['config'] = json_encode($insert['config']);
                $insert['country'] = json_encode($_POST['country_restriction']);
                $insert['active'] = $status;
                $insert['currency'] = $currency;
                $insert['fixed_plan'] = $fixed_plan;
                $insert['highlight'] = $highlight;



                if($id==0){
                    $this->basic->insert_data("price_dynamic_plans",$insert);
                }else{
                    $this->basic->update_data("price_dynamic_plans",array("id"=>$id),$insert);
                }


            }



            $this->session->set_flashdata('success_message', 1);
            redirect('price/plan_list', 'location');
        }


    }

    private function payments_list(){
        $pm = [];
        $pm['pp_button'] = 'PayPal';
        $pm['st_button'] = 'Stripe (old)';
        $pm['razorpay_button'] = 'Razorpay';
        $pm['paystack_button'] = 'Paystack';
        $pm['mollie_button'] = 'Mollie';
        $pm['mercadopago'] = 'Mercadopago';
        $pm['sslcommerz'] = 'SSLCommerz';
        $pm['senangpay'] = 'Senangpay';
        $pm['instamojo'] = 'Instamojo';
        $pm['toyyibpay'] = 'Toyyibpay';
        $pm['myfatoorah'] = 'MyFatoorah';
        $pm['paymaya_button'] = 'PayMaya';
        $pm['xendit'] = 'Xendit';


        if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php')) {
            $pm['omise_on'] = 'Omise';
        }

        if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php')) {
            $pm['n_paymongo_gateway_enabled'] = 'Paymongo';
            $pm['n_paymongo_gateway_gcash_enabled'] = 'Paymongo GCash';
            $pm['n_paymongo_gateway_paymaya_enabled'] = 'Paymongo Paymaya';
            $pm['n_paymongo_gateway_grab_enabled'] = 'Paymongo Grab';
        }
        
        if (file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php')) {
            $pm['n_paymentwall_enabled'] = 'Paymentwall';
        }

        if (file_exists(APPPATH . 'modules/n_payu_latam/controllers/N_payu_latam.php')) {
            $pm['n_payu_latam_enabled'] = 'PayU LATAM';
        }

        if (file_exists(APPPATH . 'modules/n_coinbase/controllers/N_coinbase.php')) {
            $pm['n_coinbase_enabled'] = 'Coinbase';
        }

        if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php')) {
            $pm['n_moamalat_enabled'] = 'Moamalat';
        }

        if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
            $pm['n_sadad_enabled'] = 'Sadad';
        }

        if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php')) {
            $pm['n_tdsp_enabled'] = 'TDSP';
        }

        if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')) {
            $pm['n_stripe_enabled'] = 'Stripe (NEW, NVX Addon)';
            $pm['n_stripe_subscription_enabled'] = 'Stripe Subscription (NVX Addon)';
        }

        if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php')) {
            $pm['n_epayco_enabled'] = 'ePayco';
            $pm['n_epayco_subs_enabled'] = 'ePayco Subscription';
        }

        if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php')) {
            $pm['n_sellix_enabled'] = 'Sellix';
            $pm['n_sellix_subs_enabled'] = 'Sellix Subscription';
        }

        if (file_exists(APPPATH . 'modules/n_mastercard/controllers/N_mastercard.php')) {
            $pm['n_mastercard_enabled'] = 'Mastercard';
        }

        if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php')) {
            $pm['n_chapa_enabled'] = 'Chapa';
        }

        if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php')) {
            $pm['n_zaincash_enabled'] = 'Zaincash';
        }

        if (file_exists(APPPATH . 'modules/n_tap/controllers/N_tap.php')) {
            $pm['n_tap_on'] = 'TAP';
        }

        $pm['manual_payment'] = 'Manual Payment';

        return $pm;
    }

    private function country_list(){
        include(APPPATH.'modules/n_theme/lib/country_list.php');

        return $country;
    }


    public function coupon_list(){
        $data = array();
        $data['body'] = '../modules/n_theme/views/n_addon_loader';
        $data['addon_page'] = 'modules/n_theme/views/view_coupon_list';
        $data['page_title'] = $this->lang->line('Dynamic Price Coupon Configuration');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');

        $this->_viewcontroller($data);
    }

    private function coupons_js(){
        $this->ajax_check();
        $search_value = $_POST['search']['value'];
        $display_columns = array('id', 'coupon_code', 'value_type', 'date', 'use_count', 'coupon_code_clear');
        $search_columns = array('coupon_code');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'id';

        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'desc';
        $order_by = $sort . " " . $order;

        $where = array();
        if ($search_value != '') {
            $or_where = array();
            foreach ($search_columns as $key => $value)
                $or_where[$value . ' LIKE '] = "%$search_value%";
            $where = array('or_where' => $or_where);
        }

        $table = "dynamic_coupons";
        $select = array("dynamic_coupons.*");
        $info = $this->basic->get_data($table, $where, $select, '', $limit, $start, $order_by, $group_by = '');
        $total_rows_array = $this->basic->count_row($table, $where, $count = $table . ".id", '', $group_by = '');
        $total_result = $total_rows_array[0]['total_rows'];

        $i = 0;
        $base_url = base_url();
        $return_js = array();
        foreach ($info as $key => $value) {
            $return_js[$i]['coupon_code'] = '<a href="' . $base_url . 'price/coupon_edit/' . $value['id'] . '">' . $value['coupon_code'] . '</a>';

            $return_js[$i]['coupon_code'] .= '<div class="row-actions">

            <span><a href="' . $base_url . 'price/coupon_edit/' . $value['id'] . '">'.$this->lang->line('edit').'</a> | </span>
            ';

            $return_js[$i]['coupon_code'] .= '<span><a href="#" class="delete_coupon" data-id="'.$value['id'].'">'.$this->lang->line('delete').'</a></span>';

            $return_js[$i]['coupon_code'] .= '</div>';

            $return_js[$i]['value_type'] = $value['value'].' '.$value['value_type'];
            $return_js[$i]['date'] = $value['date_active'].' - '.$value['date_expire'];
            $return_js[$i]['use_count'] = $value['used_count'].' / '.$value['use_count'];

            $return_js[$i]['coupon_code_clear'] = $value['coupon_code'];

            $i++;
        }


        $data['draw'] = (int)$_POST['draw'] + 1;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = convertDataTableResult($return_js, $display_columns, $start, $primary_key = "id");

        echo json_encode($data);
    }

    public function coupon_edit($id=0){
        $data = array();
        $data['body'] = '../modules/n_theme/views/n_addon_loader';
        $data['addon_page'] = 'modules/n_theme/views/coupon_edit';
        $data['page_title'] = $this->lang->line('Edit Dynamic Price Coupon');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');
        $data['period_type'] = array(
            'days' => $this->lang->line('days'),
            'month' => $this->lang->line('month'),
            'year' => $this->lang->line('year'),
        );

        $data['id_coupon'] = $id;
        $data['cinfo'] = array();

        if($id>0){
            $where = [
                'where' => [
                    'id' => $id
                ],
            ];
            $c_info = $this->basic->get_data('dynamic_coupons', $where, '', [], 1);
            if(!empty($c_info[0])){
                $data['cinfo'] = $c_info[0];
            }
        }


        $this->_viewcontroller($data);
    }


    public function coupon_save($id=0){
        $data = array();
        $data['body'] = '../modules/n_theme/views/n_addon_loader';
        $data['addon_page'] = 'modules/n_theme/views/coupon_edit';
        $data['page_title'] = $this->lang->line('Edit Dynamic Price Coupon');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');
        $data['id_coupon'] = $id;
        $data['cinfo'] = array();

        if ($_POST) {
            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('coupon_code', '<b>' . $this->lang->line("coupon_code") . '</b>', 'trim');
            $this->form_validation->set_rules('date_active', '<b>' . $this->lang->line("date_active") . '</b>', 'trim');

            $this->form_validation->set_rules('date_expire', '<b>' . $this->lang->line("date_expire") . '</b>', 'trim');
            $this->form_validation->set_rules('value', '<b>' . $this->lang->line("value") . '</b>', 'trim');
            $this->form_validation->set_rules('value_type', '<b>' . $this->lang->line("value_type") . '</b>', 'trim');
            $this->form_validation->set_rules('use_count', '<b>' . $this->lang->line("use_count") . '</b>', 'trim');
            $this->form_validation->set_rules('used_count', '<b>' . $this->lang->line("used_count") . '</b>', 'trim');
            $this->form_validation->set_rules('active', '<b>' . $this->lang->line("active") . '</b>', 'trim');
            $this->form_validation->set_rules('package_restriction', '<b>' . $this->lang->line("package_restriction") . '</b>', 'trim');
            $this->form_validation->set_rules('generate_count', '<b>' . $this->lang->line("generate_count") . '</b>', 'trim');
            $this->form_validation->set_rules('active', '<b>' . $this->lang->line("active") . '</b>', 'trim');

            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->settings();
            } else {
                // assign
                $coupon_code = addslashes(strip_tags($this->input->post('coupon_code', true)));
                $date_active = addslashes(strip_tags($this->input->post('date_active', true)));
                $date_expire = addslashes(strip_tags($this->input->post('date_expire', true)));
                $value = addslashes(strip_tags($this->input->post('value', true)));
                $value_type = addslashes(strip_tags($this->input->post('value_type', true)));
                $use_count = addslashes(strip_tags($this->input->post('use_count', true)));
                $used_count = addslashes(strip_tags($this->input->post('used_count', true)));
                $package_restriction = addslashes(strip_tags($this->input->post('package_restriction', true)));
                $generate_count = addslashes(strip_tags($this->input->post('generate_count', true)));
                $active = addslashes(strip_tags($this->input->post('active', true)));

                $insert = array();
                $insert['coupon_code'] = $coupon_code;
                $insert['date_active'] = $date_active;
                $insert['date_expire'] = $date_expire;
                $insert['value'] = $value;
                $insert['value_type'] = $value_type;
                $insert['use_count'] = $use_count;
                $insert['used_count'] = $used_count;
                $insert['active'] = $active;
                $insert['user_id'] = 0;

                $insert['config'] = array(
                    'package_restriction' => $package_restriction
                );

                $insert['config'] = json_encode($insert['config']);
                if($id==0){
                    if($generate_count>1){
                        $this->codes = array();
                        for ($i = 0; $i < $generate_count; $i++) {
                            $insert['coupon_code'] = $coupon_code.'_'.$this->gen_uq_code();
                            $this->basic->insert_data("dynamic_coupons",$insert);
                        }
                    }else{
                        $this->basic->insert_data("dynamic_coupons",$insert);
                    }
                }else{
                    $this->basic->update_data("dynamic_coupons",array("id"=>$id),$insert);
                }
            }

        }

        //redirect to coupon_list;
        //$this->_viewcontroller($data);
    }

    private function gen_uq_code(){
        $code = $this->random_code();
        if(isset($this->codes[$code])){
            return $this->gen_uq_code();
        }
        $this->codes[$code] = 1;
        return $code;
    }

    private function random_code(){
        $code = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
        return strtoupper($code);
    }

    private function coupon_delete(){
        $this->csrf_token_check();

        $id = $this->input->post('id');

        if(empty($id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $doc_info = $this->basic->get_data('dynamic_coupons', ['where' => ['id' => $id]]);

        if(empty($doc_info)){
            $this->return_json('error','Bad Request');
        }

        if ($this->basic->delete_data('dynamic_coupons', array("id" => $doc_info[0]['id']))) {
            $this->return_json(1,'OK');
        } else {
            $this->return_json('error','Something Went Wrong, please try once again.');
        }
    }

    private function coupon_special_activate(){
        include(FCPATH . 'application/n_views/config.php');
        $coupon_code = $this->input->post('discount_coupon');
        $package_id = $this->input->post('package_id');
        $final_action = $this->input->post('final_action');


        $pck = $this->basic->get_data('package', ['where' => ['id' => $package_id]], '', '', 1);
        if(!empty($pck[0]['origin_id'])){
            $ock = $this->basic->get_data('price_dynamic_plans', ['where' => ['id' => $pck[0]['origin_id']]], '', '', 1);
            if(!empty($ock[0])){
                $ock[0]['config'] = json_decode($ock[0]['config'],true);
            }
        }else{
            $this->return_json('error','You cant use this function');
            return;
        }

        if(!empty($pck[0]['vat_details'])){
            $pck[0]['vat_details'] = json_decode($pck[0]['vat_details'], true);
        }

        if(!empty($pck[0]['vat_details']['untouched_price'])){
            $invoice_data['origin_price'] = $pck[0]['vat_details']['untouched_price'];
        }else{
            $invoice_data['origin_price'] = $pck[0]['price'];
        }
        $invoice_data['untouched_price'] = $invoice_data['origin_price'];

        $coupon = $this->coupon_apply($invoice_data['untouched_price']);

        if($coupon['price']!=0){
            $this->return_json('error','You cant use this function');
            return;
        }

        if($coupon['coupon_apply']!=true){
            $this->return_json('error','You cant use this function');
            return;
        }



        //verify package
        if ($package_id == 0) exit;
        $this->ajax_check();

        $type = $this->lang->line('Discount Coupon');

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

        //post data
        $user_id = $this->user_id;
        $bill_email = $user_email;


        //generate redirect
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

        if (empty($prev_cycle_expired_date)) {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) < strtotime(date('Y-m-d'))) {
            $cycle_start_date = date('Y-m-d');
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) > strtotime(date('Y-m-d'))) {
            $cycle_start_date = date("Y-m-d", strtotime('+1 day', strtotime($prev_cycle_expired_date)));
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        } else if (strtotime($prev_cycle_expired_date) == strtotime(date('Y-m-d'))) {
            $cycle_start_date = date("Y-m-d", strtotime('+1 day', strtotime($prev_cycle_expired_date)));
            $cycle_expired_date = date("Y-m-d", strtotime($validity_str, strtotime($cycle_start_date)));
        }

        //$currency='PHP';
        $transaction_id = 0;
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
        $insert_id = $this->db->insert_id();



        $curtime = date("Y-m-d H:i:s");

        $returjs = array();
        $returjs['type'] = 'Discount Coupon';
        $returjs['amount'] = 0;
        $returjs['created_at'] = $curtime;
        $returjs['transaction_id'] = $coupon_code;
        $returjs['status'] = 'PAID';


        $this->payment_success($insert_id, $returjs);

        $this->return_json(1,array('redirect' => $success_url));
    }

    private function plan_delete(){
        $this->csrf_token_check();

        $id = $this->input->post('id');

        if(empty($id)){
            $this->return_json('error','Bad Request');
        }


        //check bot exist and USER ID

        $doc_info = $this->basic->get_data('price_dynamic_plans', ['where' => ['id' => $id]]);

        if(empty($doc_info)){
            $this->return_json('error','Bad Request');
        }

        if ($this->basic->delete_data('price_dynamic_plans', array("id" => $doc_info[0]['id']))) {
            $this->return_json(1,'OK');
        } else {
            $this->return_json('error','Something Went Wrong, please try once again.');
        }
    }

    private function payment_success($transaction_id, $returjs)
    {
        $order_info = $this->basic->get_data("transaction_history", $where = array("where" => array("id" => $transaction_id)));
        if (!empty($order_info)) {
            $type = $returjs['type'];

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

            $user_id = $order_info[0]['user_id'];
            $receiver_email = $user_email;

            $cycle_start_date = $order_info[0]['cycle_start_date'];
            $cycle_expired_date = $order_info[0]['cycle_expired_date'];

            if (empty($country)) {
                $country = '';
            }

            $insert_data = array(
                "transaction_id" => $returjs['transaction_id'],
                "paypal_email" => strtoupper($returjs['type']),
                "payment_date" => $returjs['created_at'],
                "payment_type" => strtoupper($type) . " PAID",
                "paid_amount" => $returjs['amount']
            );

            $this->basic->update_data('transaction_history', array('id' => $transaction_id), $insert_data);
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

                //echo json_encode(array('redirect' => $success_url));

            } else {

                $to = $from;
                $subject = "New Payment Made";
                $message = "New payment has been made by {$user_name}";
                //send mail to admin
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html = 1);
            }

            //$redirect_url=base_url()."payment/transaction_log?action=success";

            // affiliate Section
            if ($this->addon_exist('affiliate_system')) {
                $get_affiliate_id = $this->basic->get_data("users", ['where' => ['id' => $user_id]], ['affiliate_id']);
                $affiliate_id = isset($get_affiliate_id[0]['affiliate_id']) ? $get_affiliate_id[0]['affiliate_id'] : 0;
                if ($affiliate_id != 0) {
                    $this->affiliate_commission($affiliate_id, $user_id, 'payment', $price);
                }
            }


        }
    }

    private function invoice_get_data(){
        $this->csrf_token_check();

        $transaction_id = addslashes(strip_tags($this->input->post('transaction_id', true)));
        $package_id = addslashes(strip_tags($this->input->post('package_id', true)));


        $th = $this->basic->get_data('transaction_history', ['where' => ['id' => $transaction_id]], '', '', 1);

        $return_json = array(
            'info_msg' => $this->lang->line('Not found')
        );

        include(APPPATH.'modules/n_theme/lib/country_list.php');

        if(!empty($th[0])){
            $pck = $this->basic->get_data('package', ['where' => ['id' => $package_id]], '', '', 1);
            if(!empty($pck[0])){
                $invoice_details = '';
                $pricing_details = '';
                if(!empty($pck[0]['return_json'])){
                    $rjs = json_decode($pck[0]['return_json'],true);

                    $pricing_details .= $rjs['ps']['package_name'];
                    $pricing_details .= '<br />'.$rjs['ps']['period_value'].' '.$rjs['ps']['period'];
                    $pricing_details .= '<br />PAID: '.$rjs['ps']['price'].' '.$rjs['ps']['currency'];
                }

                if(!empty($pck[0]['vat_details'])){
                    $vjs = json_decode($pck[0]['vat_details'],true);

                    if(!empty($vjs['inv_name'])){
                        $invoice_details .= $vjs['inv_name'];
                    }
                    if(!empty($vjs['inv_bus_name'])){
                        $invoice_details .= '<br />'.$vjs['inv_bus_name'];
                    }
                    if(!empty($vjs['inv_vat_number'])){
                        $invoice_details .= '<br />'.$vjs['inv_vat_number'];
                    }
                    if(!empty($vjs['inv_street'])){
                        $invoice_details .= '<br />'.$vjs['inv_street'];
                    }
                    if(!empty($vjs['inv_postcode'])){
                        $invoice_details .= '<br />'.$vjs['inv_postcode'];
                    }
                    if(!empty($vjs['inv_city'])){
                        $invoice_details .= '<br />'.$vjs['inv_city'];
                    }
                    if(!empty($vjs['inv_country'])){
                        $invoice_details .= '<br />'.$country[$vjs['inv_country']];
                    }
                    if(!empty($vjs['inv_email'])){
                        $invoice_details .= '<br />'.$vjs['inv_email'];
                    }
                    if(!empty($vjs['inv_mobile'])){
                        $invoice_details .= '<br />'.$vjs['inv_mobile'];
                    }
                    if(!empty($vjs['vat_value'])){
                        $invoice_details .= '<br />VAT: '.$vjs['vat_value'].'%';
                    }
                    if(!empty($vjs['vat_ue'])){
                        $invoice_details .= '<br />VAT UE: '.$vjs['vat_ue'];
                    }
                }

                $return_json = array(
                    'invoice_details' => $invoice_details,
                    'pricing_details' => $pricing_details
                );
            }
        }

        $this->return_json(1,$return_json);



    }

    private function invoice_upload(){
// Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $upload_dir = APPPATH . '../upload/invoice/';

        // Makes upload directory
        if( ! file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_dir = 'upload/invoice/'.$this->random_code().'/';

        $upload_dir = APPPATH . '../'.$file_dir;

        // Makes upload directory
        if( ! file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['file'])) {

            $file_size = $_FILES['file']['size'];
            if ($file_size > 5242880) {
                $message = $this->lang->line('The file size exceeds the limit. Allowed size is 5MB. Please remove the file and upload again.');
                echo json_encode(['error' => $message]);
                exit;
            }

            // Holds tmp file
            $tmp_file = $_FILES['file']['tmp_name'];

            if (is_uploaded_file($tmp_file)) {

                $post_fileName = $_FILES['file']['name'];
                $post_fileName_array = explode('.', $post_fileName);
                $ext = array_pop($post_fileName_array);

                $allow_ext = ['pdf', 'doc', 'txt', 'png', 'jpg', 'jpeg', 'zip'];
                if(! in_array(strtolower($ext), $allow_ext)) {
                    $message = $this->lang->line('Are you kidding???');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $filename = implode('.', $post_fileName_array);
                $filename = strtolower(strip_tags(str_replace(' ', '-', $filename)));
                $filename = $filename . '_' . $this->user_id . '_' . time() . substr(uniqid(mt_rand(), true), 0, 6) . '.' . $ext;

                // Moves file to the upload dir
                $dest_file = $upload_dir . DIRECTORY_SEPARATOR . $filename;
                if (! @move_uploaded_file($tmp_file, $dest_file)) {
                    $message = $this->lang->line('That was not a valid upload file.');
                    echo json_encode(['error' => $message]);
                    exit;
                }

                $transaction_id = addslashes(strip_tags($this->input->post('transaction_id', true)));

                $insert = array();
                $insert['n_invoice'] = $file_dir.$filename;
                $this->basic->update_data("transaction_history",array("id"=>$transaction_id),$insert);

                // Returns response
                echo json_encode([ 'filename' => $filename , 'n_dir' => $file_dir.$filename]);
            }
        }
    }

    private function invoice_delete_file()
    {
        // Kicks out if not a ajax request
        $this->ajax_check();

        if ('get' == strtolower($_SERVER['REQUEST_METHOD'])) {
            exit();
        }

        $transaction_id = addslashes(strip_tags($this->input->post('transaction_id', true)));

        $insert = array();
        $insert['n_invoice'] = '';
        $this->basic->update_data("transaction_history",array("id"=>$transaction_id),$insert);


        $n_dir = $this->input->post('n_dir');

        // Prepares file path
        $filepath = FCPATH.$n_dir;

        // Tries to remove file
        if (file_exists($filepath)) {
            // Deletes file from disk
            unlink($filepath);

            // Clears the file from cache
            clearstatcache();

            // Deletes file from session
            $this->session->unset_userdata('manual_payment_uploaded_file');

            echo json_encode(['deleted' => 'yes']);
            exit();
        }



        echo json_encode(['deleted' => 'no']);
    }

}