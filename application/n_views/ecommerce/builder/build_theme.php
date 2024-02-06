<?php
if (isset($_GET['builder']) and $_GET['builder'] == 1) {
    if (function_exists('opcache_reset')) {
        opcache_reset();
    }
}
$js_store_id = isset($social_analytics_codes['store_id']) ? $social_analytics_codes['store_id'] : $social_analytics_codes['id'];
$js_store_unique_id = isset($social_analytics_codes['store_unique_id']) ? $social_analytics_codes['store_unique_id'] : "";

include(FCPATH . 'application/n_views/config.php');
include(APPPATH . 'n_views/default_ecommerce_builder.php');

if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $js_store_unique_id . '.php')) {
    include(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $js_store_unique_id . '.php');
}

if (isset($_GET['builder']) and $_GET['builder'] == 1) {
    if (isset($_GET['new_var'])) {
        $new_var = json_decode($_GET['new_var'], TRUE);
        foreach ($new_var as $k => $v) {
            $v = str_replace(array('apos', 'quot'), array('&apos;', '&quot;'), $v);
            $n_eco_builder_config[$k] = $v;
        }
    }
}

include(APPPATH . 'n_views/ecommerce/builder/variables.php');
include(FCPATH . 'application/n_views/include/function_helper_theme.php');

$rtl_on = false;
$body = str_replace('ecommerce/', '', $body);
?>

<!DOCTYPE html>
<html lang="<?php echo LangToCode($this->language, $n_config); ?>" <?php if (strpos(strtolower($n_config['rtl_langs']), strtolower($this->language)) !== false) {
    echo 'dir="rtl" class="rtl_on"';
    $rtl_on = true;
} ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title><?php echo isset($page_title) ? $page_title : $this->config->item('product_name'); ?></title>

    <meta name="keywords" content="<?php echo $n_eco_builder_config['site_keywords']; ?>"/>
    <meta name="description" content="<?php echo $n_eco_builder_config['site_description']; ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url($n_eco_builder_config['store_favicon']); ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/flag-icon-css/css/flag-icon.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: {families: ['<?php echo $n_eco_builder_config['font_family']; ?>:400,500,600,700,800',]}
        };
        (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '<?php echo base_url();?>n_assets/ecommerce/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>


    <link rel="preload"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/fontawesome-free/webfonts/fa-regular-400.woff2"
          as="font" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/fontawesome-free/webfonts/fa-solid-900.woff2"
          as="font" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/fontawesome-free/webfonts/fa-brands-400.woff2"
          as="font" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload" href="<?php echo base_url(); ?>n_assets/ecommerce/fonts/wolmart.ttf?png09e" as="font"
          type="font/ttf" crossorigin="anonymous">

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/fontawesome-free/css/all.min.css?ver=<?php echo $n_config['theme_version']; ?>">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/owl-carousel/owl.carousel.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/animate/animate.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/magnific-popup/magnific-popup.min.css?ver=<?php echo $n_config['theme_version']; ?>">


    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/photoswipe/photoswipe.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/photoswipe/default-skin/default-skin.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/threesixty-degree/360-degree-riewer.min.css?ver=<?php echo $n_config['theme_version']; ?>">


    <!-- Default CSS -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/css/style.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/css/demo8.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/sweetalert2/sweetalert2.min.css?ver=<?php echo $n_config['theme_version']; ?>">


    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/vendor/swiper/swiper-bundle.min.css?ver=<?php echo $n_config['theme_version']; ?>">


    <?php

    if (file_exists(FCPATH . $store_id . '_manifest.json') and $n_eco_builder_config['pwa_on'] == 'true' and $check_cn_nn == 1) {
        echo '<meta name="theme-color" content="' . $n_eco_builder_config['pwa_theme_color'] . '">';
        echo '<link rel="manifest" href="' . base_url() . $store_id . '_manifest.json">';
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="' . $n_eco_builder_config['pwa_apple_status_bar'] . '">';


        if (!empty($n_eco_builder_config['iphone5_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_iphone5_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_iphone5_splash.png" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['iphone6_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_iphone6_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_iphone6_splash.png" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['iphoneplus_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_iphoneplus_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_iphoneplus_splash.png" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['iphonex_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_iphonex_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_iphonex_splash.png" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['iphonexr_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_iphonexr_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_iphonexr_splash.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['iphonexsmax_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_iphonexsmax_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_iphonexsmax_splash.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['ipad_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_ipad_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_ipad_splash.png" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['ipadpro1_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_ipadpro1_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_ipadpro1_splash.png" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['ipadpro3_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_ipadpro3_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_ipadpro3_splash.png" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_eco_builder_config['ipadpro2_splash']) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_ipadpro2_splash.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_ipadpro2_splash.png" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '8_3__iPad_Mini_portrait';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '10_2__iPad_portrait';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '10_9__iPad_Air_portrait';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_portrait';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '8_3__iPad_Mini_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '9_7__iPad_Pro__7_9__iPad_mini__9_7__iPad_Air__9_7__iPad_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '10_2__iPad_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '10_5__iPad_Air_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '10_9__iPad_Air_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '11__iPad_Pro__10_5__iPad_Pro_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '12_9__iPad_Pro_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = '4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4_7__iPhone_SE_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_11__iPhone_XR_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_11_Pro_Max__iPhone_XS_Max_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }

        $n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape';
        if (!empty($n_eco_builder_config[$n_ios_splash_name]) and file_exists(FCPATH . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png')) {
            echo '<link href="' . base_url() . 'upload/ecommerce/' . $store_id . '_'.$n_ios_splash_name.'.png" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" rel="apple-touch-startup-image" />';
        }



        ?>
        <meta name="apple-mobile-web-app-capable" content="yes"/>

        <link href="<?php echo base_url(); ?>upload/ecommerce/<?php echo $store_id; ?>_pwa_icon_72.png"
              rel="apple-touch-icon">
        <link href="<?php echo base_url(); ?>upload/ecommerce/<?php echo $store_id; ?>_pwa_icon_76.png"
              rel="apple-touch-icon" sizes="76x76">
        <link href="<?php echo base_url(); ?>upload/ecommerce/<?php echo $store_id; ?>_pwa_icon_120.png"
              rel="apple-touch-icon" sizes="120x120">
        <link href="<?php echo base_url(); ?>upload/ecommerce/<?php echo $store_id; ?>_pwa_icon_152.png"
              rel="apple-touch-icon" sizes="152x152">


        <?php
    }

    $home_section = array();
    $home_section['gjs-html'] = '';
    $home_section['gjs-components'] = '';
    $home_section['gjs-assets'] = '';
    $home_section['gjs-css'] = '';
    $home_section['gjs-styles'] = '';

    $default_lang_inc = '';
    if ($this->language != $social_analytics_codes['store_locale']) {
        $default_lang_inc = strtolower($this->language);
    }

    if ($n_eco_builder_config['home_page_editor_on'] == 'true' and file_exists(APPPATH . 'n_eco_user/home_page_' . $js_store_id . '_p' . $default_lang_inc . '.php') and $body == 'store_single') {
        $import_home_section = APPPATH . 'n_eco_user/home_page_' . $js_store_id . '_p' . $default_lang_inc . '.php';
        $n_editor_data = file_get_contents($import_home_section);
        $home_section = json_decode($n_editor_data, true);
    }

    if($rtl_on){ ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>n_assets/ecommerce/css/style-rtl.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <?php } ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/ecommerce/css/style_custom.css?ver=<?php echo $n_config['theme_version']; ?>">
    <style>
        <?php
             echo $home_section['gjs-css'];

            include(APPPATH.'n_views/ecommerce/builder/ecommerce_custom_styles.php');
            echo "\r\n\r\n";
             if (file_exists(APPPATH . '/n_eco_user/codes_custom_css_store_id_' . $js_store_id . '.php')) {
                include(APPPATH . '/n_eco_user/codes_custom_css_store_id_' . $js_store_id . '.php');
            }


             //echo $home_section['gjs-styles'];
        ?>
    </style>

    <script>
        <?php
        echo $home_section['gjs-components'];
        ?>
    </script>

    <?php
    include(APPPATH . 'n_views/ecommerce/builder/misc/og_tags.php');

    if (file_exists(APPPATH . '/n_eco_user/before_head_store_id_' . $js_store_id . '.php')) {
        include(APPPATH . '/n_eco_user/before_head_store_id_' . $js_store_id . '.php');
    }





    ?>

    <?php if ($n_eco_builder_config['onesignal_enabled'] == 'true') { ?>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
            var OneSignal = window.OneSignal || [];
            var initConfig = {
                appId: "<?php echo $n_eco_builder_config['onesignal_app_key'] ; ?>",
                notifyButton: {
                    enable: true
                },
            };
            OneSignal.push(function () {
                OneSignal.SERVICE_WORKER_PARAM = { scope: '/' };
                OneSignal.SERVICE_WORKER_PATH = 'OneSignalSDKWorker.js'
                OneSignal.SERVICE_WORKER_UPDATER_PATH = 'OneSignalSDKUpdaterWorker.js'
                OneSignal.init(initConfig);
            });


        </script>
    <?php } ?>


</head>
<?php
$block_ctrlc = '';
if ($n_eco_builder_config['block_ctrlc'] == 'true') {
    $block_ctrlc = 'oncopy="return false" oncut="return false"';
}

?>
<body <?php echo $block_ctrlc; ?> class="<?php if ($body == 'store_single') {
    echo ' home';
}
if ($body == 'category') {
    echo ' category_page';
} else {
    echo $body;
} ?>">
<div class="page-wrapper">
    <?php //header

    if (file_exists(APPPATH . 'n_views/ecommerce/builder/header/' . $n_eco_builder_config['section_header'] . '.php')) {
        include(APPPATH . 'n_views/ecommerce/builder/header/' . $n_eco_builder_config['section_header'] . '.php');
    }

    if ($n_eco_builder_config['menu_style'] == 'swiper' or $n_eco_builder_config['menu_style'] == 'both') {
        include(APPPATH . 'n_views/ecommerce/builder/category/swiper_elipse.php');
    }

    echo '<div class="row">' . $home_section['gjs-html'] . '</div>';


    if ($n_eco_builder_config['closed_alert'] == 'true') {
        include(APPPATH . 'n_views/ecommerce/builder/misc/alert_closed.php');
    }

    $body = $n_eco_builder_config[$body];
    if (file_exists(APPPATH . 'n_views/ecommerce/builder/pages/' . $body . '.php')) {
        include(APPPATH . 'n_views/ecommerce/builder/pages/' . $body . '.php');
    }

    ?>
</div>


<!-- Start of Scroll Top -->
<a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="w-icon-angle-up"></i></a>
<!-- End of Scroll Top -->

<!-- Plugin JS File -->
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/jquery/jquery.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/parallax/parallax.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/jquery.plugin/jquery.plugin.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/owl-carousel/owl.carousel.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/imagesloaded/imagesloaded.pkgd.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/skrollr/skrollr.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/magnific-popup/jquery.magnific-popup.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/zoom/jquery.zoom.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/jquery.countdown/jquery.countdown.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/sweetalert2/sweetalert2.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/sticky/sticky.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/imagesloaded/imagesloaded.pkgd.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/photoswipe/photoswipe.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/photoswipe/photoswipe-ui-default.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/threesixty-degree/threesixty.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/js/popper.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>n_assets/ecommerce/vendor/swiper/swiper-bundle.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>


<!-- Main JS -->
<script src="<?php echo base_url(); ?>n_assets/ecommerce/js/main.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/js/jquery.blockui.js?ver=<?php echo $n_config['theme_version']; ?>"></script>


<?php include(APPPATH . 'n_views/ecommerce/builder/variables_js.php'); ?>
<script src="<?php echo base_url(); ?>n_assets/ecommerce/js/app_ecommerce.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php
if (file_exists(APPPATH . 'n_views/ecommerce/builder/pages/' . $body . '_js.php')) {
    include(APPPATH . 'n_views/ecommerce/builder/pages/' . $body . '_js.php');
}


if (isset($output_js)) {
    echo $output_js;
}
?>

<script>
    <?php if($n_eco_builder_config['welcome_modal_show'] == 'true' and file_exists(APPPATH . 'n_eco_user/modal_popup_' . $js_store_id . '_p' . $default_lang_inc . '.php')){

    $import_modal_popup_data = array();
    $import_modal_popup_data['gjs-html'] = '';
    $import_modal_popup_data['gjs-components'] = '';
    $import_modal_popup_data['gjs-assets'] = '';
    $import_modal_popup_data['gjs-css'] = '';
    $import_modal_popup_data['gjs-styles'] = '';

    $import_modal_popup = APPPATH . 'n_eco_user/modal_popup_' . $js_store_id . $default_lang_inc . '_p.php';
    $import_modal_popup_data = file_get_contents($import_modal_popup);
    $import_modal_popup_data = json_decode($import_modal_popup_data, true);

    $import_modal_popup_data['gjs-css'] = str_replace(PHP_EOL, '', $import_modal_popup_data['gjs-css']);
    $import_modal_popup_data['gjs-html'] = str_replace(PHP_EOL, '', $import_modal_popup_data['gjs-html']);
    ?>

    if (Wolmart.getCookie('hideNewsletterPopup') !== 'true') {
        setTimeout(function () {
            Wolmart.popup({
                items: {
                    src: '<style><?php echo $import_modal_popup_data['gjs-css']; ?></style><?php echo $import_modal_popup_data['gjs-html']; ?>',
                },
                type: 'inline',
                tLoading: '',
                mainClass: 'mfp-newsletter mfp-fadein-popup',
                callbacks: {
                    beforeClose: function () {
                        // if "do not show" is checked
                        //$('#hide-newsletter-popup')[0].checked &&
                        Wolmart.setCookie('hideNewsletterPopup', true, 7);
                    }
                },
            });
        }, <?php echo $n_eco_builder_config['welcome_modal_timeout']; ?>000);
    }
    <?php } ?>
</script>

<?php
if ($n_eco_builder_config['show_mobile_menu'] == 'true') {
    include(APPPATH . 'n_views/ecommerce/builder/misc/sticky_footer.php');
}

include(APPPATH . 'n_views/ecommerce/builder/footer/footer_v1.php');
include(APPPATH . 'n_views/ecommerce/builder/misc/menu_mobile_main.php');
if ($n_eco_builder_config['menu_mobile_float'] == 'true') {
    include(APPPATH . 'n_views/ecommerce/builder/misc/menu_mobile_float.php');
}


if ($n_eco_builder_config['menu_style'] == 'swiper' or $n_eco_builder_config['menu_style'] == 'both') {
    include(APPPATH . 'n_views/ecommerce/builder/category/swiper_elipse_js.php');
}

if (file_exists(APPPATH . '/n_eco_user/before_body_store_id_' . $js_store_id . '.php')) {
    include(APPPATH . '/n_eco_user/before_body_store_id_' . $js_store_id . '.php');
}


?>

<?php if ($n_eco_builder_config['pwa_on'] == 'true' and $check_cn_nn == 1) { ?>
    <script>
        function registerServiceWorker() {
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('<?php echo base_url();?>serviceworker.js')
                        .then(function (registration) {
                        }, function (err) {
                        });
                });
            }
        }

        registerServiceWorker();
    </script>
    <style>
        .add-to-home {
            display: none;
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            text-align: center;
            color: #fff;
            padding: 10vh 5vw;
            box-sizing: border-box;
            background-color: #000;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.3);
        }

        .blur {
            filter: blur(10px);
            -webkit-filter: blur(10px);
            transition: 0.2s filter linear;
            -webkit-transition: 0.2s -webkit-filter linear;
        }

        .add-to-home .browser-preview {
            margin: -45px 0 40px;
            text-decoration: underline;
            text-align: right;
        }

        .add-to-home .logo-name-container {
            background-image: url('../assets/images/login/cab.svg');
            background-repeat: no-repeat;
            background-position: center 0;
            padding-top: 110px;
            margin: 0 45px;
            font-size: 24px;
            margin-top: 15vh;
            background-size: contain;
            max-height: 130px;
            width: auto;
        }

        .add-to-home .app-name-cont {
            font-size: 24px;
            margin-top: 20px;
        }

        .add-to-home .homescreen-text {
            padding-top: 15vh;
            line-height: 1.5;
            font-size: 18px;
        }

        .add-to-home .icon-addToHome {
            vertical-align: text-bottom;
            width: 35px;
            height: 35px;
            display: inline-block;
            background: url('../assets/images/mobile-sprite.png') no-repeat top left;
            background-size: cover;
        }

        .add-to-home .icon-homePointer {
            margin-top: 5vh;
            background: url('../assets/images/mobile-sprite.png') no-repeat top left;
            background-position: center -40px;
            width: 100%;
            height: 50px;
            background-size: 40px;
            -webkit-animation-duration: 0.5s;
            animation-duration: 0.5s;
            -webkit-animation-name: topToBottom;
            animation-name: topToBottom;
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
            -webkit-animation-direction: alternate;
            animation-direction: alternate;
        }

        @keyframes topToBottom {
            from {
                transform: translate(0, 0);
            }
            to {
                transform: translate(0, 20px);
            }
        }
    </style>
    <script src="<?php echo base_url(); ?>n_assets/js/homescreen_ios.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script>
        window.onload = function () {
            iPhoneInstallOverlay.init({
                blurElement: '.page-wrapper',
                appIconURL: '<?php echo base_url();?>upload/ecommerce/<?php echo $store_id; ?>_pwa_icon_512.png',
                spritesURL: '<?php echo base_url();?>n_assets/img/mobile-sprite.png',
                showOnReload: false,
                appName: '<?php echo $this->config->item('product_short_name'); ?>',
                addText: '<?php echo $this->lang->line('Add to Home Screen'); ?>',
                previewText: '<?php echo $this->lang->line('Continue in browser'); ?>',
                installText: '<?php echo $this->lang->line('To install tap'); ?>',
                chooseText: '<?php echo $this->lang->line('and choose'); ?>'
            });
            //iPhoneInstallOverlay.showOverlay(); // manually showing overlay for demo. Remove this line while integrating in your app.
        }
    </script>
<?php } ?>

<?php if (isset($social_analytics_codes["pixel_id"]) && !empty($social_analytics_codes["pixel_id"])): ?>
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js')
        fbq('init', '<?php echo $social_analytics_codes["pixel_id"];?>');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=<?php echo $social_analytics_codes['pixel_id']; ?>&ev=PageView&noscript=1"
        /></noscript>
<?php endif; ?>


<?php if (isset($social_analytics_codes["google_id"]) && !empty($social_analytics_codes["google_id"])): ?>
    <script async
            src="https://www.googletagmanager.com/gtag/js?id=<?php echo $social_analytics_codes['google_id']; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', '<?php echo $social_analytics_codes["google_id"];?>');
    </script>
<?php endif; ?>





</body>

</html>