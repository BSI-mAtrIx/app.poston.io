<?php
    if($n_config['dp_on']=='true'){
        include(APPPATH.'n_views/member/buy_package_js_dynamic.php');
    }else{
        include(APPPATH.'n_views/member/buy_package_js_classic.php');
    }
?>