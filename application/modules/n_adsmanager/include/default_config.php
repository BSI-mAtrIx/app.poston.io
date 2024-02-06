<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


$n_ad_config = array();
$n_ad_config['ads_image_size'] = 5;
$n_ad_config['ads_video_size'] = 500;

if(file_exists(APPPATH . 'n_adsmanager_config.php')){
    include(APPPATH . 'n_adsmanager_config.php');
}