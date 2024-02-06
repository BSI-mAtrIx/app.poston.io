<?php
require(APPPATH.'modules/n_theme/vendor/autoload.php');
use GeoIp2\Database\Reader;

if($n_config['dp_country_on']=='true'){
    $reader = new Reader(APPPATH.'modules/n_theme/db/GeoLite2-Country/GeoLite2-Country.mmdb');
    $record = $reader->country($_SERVER['REMOTE_ADDR']);

    $dp_country = '"'.$record->country->geonameId.'"';
}else{
    $dp_country = '"0"';
}

if($dynamic_load==1){
    $dp_plan = array();
}else{
    $dp_plan = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => $dp_country, 'active' => 1, 'fixed_plan' => 1]], '', '', 1);
    if(empty($dp_plan)){
        $dp_plan = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => '"0"', 'active' => 1, 'fixed_plan' => 1]], '', '', 1);
    }
}


function parse_slider($slider, $id_type){
    $exp = explode(';', $slider);
    $ar1 = array(
        'min_value' => $exp[0],
        'price' => $exp[$id_type], //1 or 2
        'is_unlimited' => $exp[3],
    );
    return $ar1;
}

include(APPPATH.'modules/n_theme/lib/default_plan.php');

$dp_parsed_plans = array();
if(!empty($dp_plan) AND $n_config['dp_fixed_show']=='true'){
    foreach($dp_plan as $dpv){
        $dpv['config'] = json_decode($dpv['config'], true);

        $dpv['config']['config_plan'] = array_replace_recursive($dp_default, $dpv['config']['config_plan']);
        if(!empty($dpv['config']['period_1']['price_fixed'])){
            $dp_parsed_plans[] = array(
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
        }

        if(!empty($dpv['config']['period_2']['price_fixed'])){
            $dp_parsed_plans[] = array(
                'name' => $dpv['name'],
                'id' => $dpv['id'],
                'id_type' => 2,
                'validity_type' => $dpv['config']['period_2']['type'],
                'validity_value' => $dpv['config']['period_2']['value'],
                'price' => $dpv['config']['period_2']['price_fixed'],
                'currency' => $dpv['currency'],
                'config_plan' => $dpv['config']['config_plan'],
                'highlight' => $dpv['highlight']
            ); //price2
        }
    }


}

$dp_plan_dyn = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => $dp_country, 'active' => 1, 'fixed_plan' => 0]], '', '', 1);
if(empty($dp_plan_dyn)){
    $dp_plan_dyn = $this->basic->get_data('price_dynamic_plans', ['where' => ['country like' => '"0"', 'active' => 1, 'fixed_plan' => 0]], '', '', 1);
}

if(!empty($dp_plan_dyn) AND empty($dp_plan) OR $n_config['dp_fixed_show']=='false'){
    $dp_parsed_plans_dyn = array();
    foreach($dp_plan_dyn as $dpv){
        $dpv['config'] = json_decode($dpv['config'], true);

        $dpv['config']['config_plan'] = array_replace_recursive($dp_default, $dpv['config']['config_plan']);

            $dp_parsed_plans_dyn[] = array(
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

            $dp_parsed_plans_dyn[] = array(
                'name' => $dpv['name'],
                'id' => $dpv['id'],
                'id_type' => 2,
                'validity_type' => $dpv['config']['period_2']['type'],
                'validity_value' => $dpv['config']['period_2']['value'],
                'price' => $dpv['config']['period_2']['price_fixed'],
                'currency' => $dpv['currency'],
                'config_plan' => $dpv['config']['config_plan'],
                'highlight' => $dpv['highlight']
            ); //price2

    }


    include(APPPATH.'n_views/member/buy_package_dynamic_dynamic.php');
}

$activated_url_dynamic = 0;
if(!empty($dp_plan_dyn) AND !empty($dp_plan)){
    $activated_url_dynamic = 1;
}
//load fixed plans
if(!empty($dp_plan) AND $n_config['dp_fixed_show'] =='true'){
    include(APPPATH.'n_views/member/buy_package_dynamic_fixed.php');
}

?>