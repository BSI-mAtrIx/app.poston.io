<?php
$n_wa_conf = array();
$n_wa_conf['bsp_on'] = '';
$n_wa_conf['bsp_config_id'] = '';
$n_wa_conf['bsp_on_version'] = '';
$n_wa_conf['api_customer_on'] = 'checked';
$n_wa_conf['api_system_user_access_token'] = '';
$n_wa_conf['api_wa_id_credit_line'] = '';
$n_wa_conf['api_wa_credit_id'] = 'disabled';
$n_wa_conf['system_user_access_token'] = '';
$n_wa_conf['api_wa_system_user_token'] = '';
$n_wa_conf['business_id'] = '';
$n_wa_conf['api_wa_currency'] = 'USD';

$n_wa_conf['min_cp_warning_email'] = '1000';
$n_wa_conf['min_cp_warning_email_title'] = 'Low CP balance alert - Action Required';
$n_wa_conf['min_cp_warning_email_text'] = 'Hi,

We hope this email finds you well. We wanted to bring to your attention that your credit points (CP) balance on our platform has become critically low. This serves as a gentle reminder that certain functionalities will soon be temporarily disabled if your CP count is exhausted.

Our platform provides a range of valuable services and features that directly rely on your CP balance. Once your CP falls below a certain threshold, some functions will be automatically paused until your CP balance is replenished. We understand how important these functionalities are to you, and we want to ensure uninterrupted access to our platforms full potential.

Platform name';
$n_wa_conf['empty_cp_warning_email_title'] = 'Insufficient CP Balance on Our Platform';
$n_wa_conf['empty_cp_warning_email_text'] = 'Hi,

I hope this email finds you well. We regret to inform you that your Credit Point (CP) balance on our platform has been completely depleted, which currently limits your ability to access and utilize our functions.

Our platform relies on CPs to facilitate the usage of various features and services. Unfortunately, due to your exhausted CP balance, certain functionalities are temporarily unavailable to you. We understand the inconvenience this may cause and want to assist you in replenishing your CP balance promptly.

Platform name';

if(file_exists(APPPATH.'modules/n_wa/include/config_local.php')){
    require(APPPATH.'modules/n_wa/include/config_local.php');
}
