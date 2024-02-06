<?php

    echo '<meta name="theme-color" content="' . $n_config['pwa_theme_color'] . '">';
    echo '<link rel="manifest" href="' . base_url() . 'manifest.json">';
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="' . $n_config['pwa_apple_status_bar'] . '">';

    if (!empty($n_config['iphone5_splash']) and file_exists(FCPATH . 'assets/img/iphone5_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/iphone5_splash.png" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['iphone6_splash']) and file_exists(FCPATH . 'assets/img/iphone6_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/iphone6_splash.png" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['iphoneplus_splash']) and file_exists(FCPATH . 'assets/img/iphoneplus_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/iphoneplus_splash.png" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['iphonex_splash']) and file_exists(FCPATH . 'assets/img/iphonex_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/iphonex_splash.png" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['iphonexr_splash']) and file_exists(FCPATH . 'assets/img/iphonexr_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/iphonexr_splash.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['iphonexsmax_splash']) and file_exists(FCPATH . 'assets/img/iphonexsmax_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/iphonexsmax_splash.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['ipad_splash']) and file_exists(FCPATH . 'assets/img/ipad_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/ipad_splash.png" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['ipadpro1_splash']) and file_exists(FCPATH . 'assets/img/ipadpro1_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/ipadpro1_splash.png" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['ipadpro3_splash']) and file_exists(FCPATH . 'assets/img/ipadpro3_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/ipadpro3_splash.png" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

    if (!empty($n_config['ipadpro2_splash']) and file_exists(FCPATH . 'assets/img/ipadpro2_splash.png')) {
        echo '<link href="' . base_url() . 'assets/img/ipadpro2_splash.png" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

$n_ios_splash_name = '8_3__iPad_Mini_portrait';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
}

    $n_ios_splash_name = '10_2__iPad_portrait';
    if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
        echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
    }

$n_ios_splash_name = '10_9__iPad_Air_portrait';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_portrait';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '8_3__iPad_Mini_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '9_7__iPad_Pro__7_9__iPad_mini__9_7__iPad_Air__9_7__iPad_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '10_2__iPad_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '10_5__iPad_Air_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '10_9__iPad_Air_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '11__iPad_Pro__10_5__iPad_Pro_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '12_9__iPad_Pro_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = '4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4_7__iPhone_SE_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_11__iPhone_XR_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_11_Pro_Max__iPhone_XS_Max_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}

$n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape';
if (!empty($n_config[$n_ios_splash_name]) and file_exists(FCPATH . 'assets/img/'.$n_ios_splash_name.'.png')) {
    echo '<link href="' . base_url() . 'assets/img/'.$n_ios_splash_name.'.png" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
}


    ?>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <link href="<?php echo base_url(); ?>assets/img/pwa_icon_72.png" rel="apple-touch-icon">
    <link href="<?php echo base_url(); ?>assets/img/pwa_icon_76.png" rel="apple-touch-icon" sizes="76x76">
    <link href="<?php echo base_url(); ?>assets/img/pwa_icon_120.png" rel="apple-touch-icon" sizes="120x120">
    <link href="<?php echo base_url(); ?>assets/img/pwa_icon_152.png" rel="apple-touch-icon" sizes="152x152">
