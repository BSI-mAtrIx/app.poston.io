<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_perfectscroll = 1;
$include_dropzone = 1;



include(FCPATH . 'application/n_views/config.php');


if($n_config['dp_on']=='true'){
    include(APPPATH.'n_views/member/buy_package_dynamic.php');
}else{
    include(APPPATH.'n_views/member/buy_package_classic.php');
}


?>