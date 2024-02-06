<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


function fb_conect()
{
    $helper = $this->fb->getRedirectLoginHelper();
    $permissions = array(
        'ads_management',
        'ads_read',
        'business_management'
    );
    $redirect_url = base_url('n_adsmanager/fb_connect_save');
    $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
}