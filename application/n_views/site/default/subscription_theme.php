<?php
include(FCPATH . 'application/n_views/config.php');
include(FCPATH . 'application/n_views/include/function_helper_theme.php');
function _e_scanAll($myDir)
{
    $dirTree = array();
    $di = new RecursiveDirectoryIterator($myDir, RecursiveDirectoryIterator::SKIP_DOTS);

    $i = 0;
    foreach (new RecursiveIteratorIterator($di) as $filename) {

        $dir = str_replace($myDir, '', dirname($filename));
        // $dir = str_replace('/', '>', substr($dir,1));

        $org_dir = str_replace("\\", "/", $dir);

        if ($org_dir)
            $file_path = $org_dir . "/" . basename($filename);
        else
            $file_path = basename($filename);

        $file_full_path = $myDir . "/" . $file_path;
        $file_size = filesize($file_full_path);
        $file_modification_time = filemtime($file_full_path);

        $dirTree[$i]['file'] = $file_full_path;
        $i++;
    }
    return $dirTree;
}

function _e_language_list()
{
    $myDir = APPPATH . 'language';
    $file_list = _e_scanAll($myDir);
    foreach ($file_list as $file) {
        $i = 0;
        $one_list[$i] = $file['file'];
        $one_list[$i] = str_replace("\\", "/", $one_list[$i]);
        $one_list_array[] = explode("/", $one_list[$i]);
    }
    foreach ($one_list_array as $value) {
        $pos = count($value) - 2;
        $lang_folder = $value[$pos];
        $final_list_array[] = $lang_folder;
    }
    $final_array = array_unique($final_list_array);
    $array_keys = array_values($final_array);
    foreach ($final_array as $value) {
        $uc_array_valus[] = ucfirst($value);
    }
    $array_values = array_values($uc_array_valus);
    $final_array_done = array_combine($array_keys, $array_values);
    return $final_array_done;
}

$language_info = _e_language_list();
$current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language");

$rtl_on = false;
if (strpos(strtolower($n_config['rtl_langs']), strtolower($current_language)) !== false) {
    $bfont_default = 'IBM+Plex+Sans';
    $nfont_default = 'Rubik';
    if ($bfont_default != $n_config['body_font_rtl']) {
        $bfont_default = str_replace(' ', '+', $n_config['body_font_rtl']);
    }
    if ($nfont_default != $n_config['nav_font_rtl']) {
        $nfont_default = str_replace(' ', '+', $n_config['nav_font_rtl']);
    }
    $rtl_on = true;
    $html_lang = 'data-textdirection="rtl"';
} else {
    $bfont_default = 'IBM+Plex+Sans';
    $nfont_default = 'Rubik';
    if ($bfont_default != $n_config['body_font']) {
        $bfont_default = str_replace(' ', '+', $n_config['body_font']);
    }
    if ($nfont_default != $n_config['nav_font']) {
        $nfont_default = str_replace(' ', '+', $n_config['nav_font']);
    }
    $html_lang = 'data-textdirection="ltr"';
} ?>
<!DOCTYPE html>
<html class="loading" lang="<?php echo LangToCode($current_language, $n_config); ?>" <?php echo $html_lang; ?>>
<!-- BEGIN: Head-->
<head>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
    <?php
    if (file_exists(FCPATH . 'manifest.json') and $n_config['pwa_on'] == 'true') {
        echo '<meta name="theme-color" content="' . $n_config['pwa_theme_color'] . '">';
        echo '<link rel="manifest" href="' . base_url() . 'manifest.json">';
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="' . $n_config['pwa_apple_status_bar'] . '">';

        if (!empty($n_config['iphone5_splash']) and file_exists(FCPATH . 'assets/img/iphone5_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['iphone6_splash']) and file_exists(FCPATH . 'assets/img/iphone6_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['iphoneplus_splash']) and file_exists(FCPATH . 'assets/img/iphoneplus_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/iphoneplus_splash.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['iphonex_splash']) and file_exists(FCPATH . 'assets/img/iphonex_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['iphonexr_splash']) and file_exists(FCPATH . 'assets/img/iphonexr_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['iphonexsmax_splash']) and file_exists(FCPATH . 'assets/img/iphonexsmax_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['ipad_splash']) and file_exists(FCPATH . 'assets/img/ipad_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['ipadpro1_splash']) and file_exists(FCPATH . 'assets/img/ipadpro1_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['ipadpro3_splash']) and file_exists(FCPATH . 'assets/img/ipadpro3_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />';
        }

        if (!empty($n_config['ipadpro2_splash']) and file_exists(FCPATH . 'assets/img/ipadpro2_splash.png')) {
            echo '<link href="' . base_url() . 'assets/img/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />';
        }

        ?>
        <meta name="apple-mobile-web-app-capable" content="yes"/>

        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_72.png" rel="apple-touch-icon">
        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_76.png" rel="apple-touch-icon" sizes="76x76">
        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_120.png" rel="apple-touch-icon" sizes="120x120">
        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_152.png" rel="apple-touch-icon" sizes="152x152">


        <?php
    }
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo $this->config->item('product_name') . " | " . $page_title; ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.png">

    <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
          rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/vendors.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/bootstrap.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/bootstrap-extended.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/colors.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/components.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/themes/dark-layout.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/themes/semi-dark-layout.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/core/menu/menu-types/vertical-menu.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/css/pages/authentication.css?ver=<?php echo $n_config['theme_version']; ?>">
    <!-- END: Page CSS-->

    <?php
    if ($rtl_on) {
        $nav_font = $n_config['nav_font_rtl'];
        $body_font = $n_config['body_font_rtl'];
        echo '<style> *{direction: rtl!important;} </style>';
    } else {
        $nav_font = $n_config['nav_font'];
        $body_font = $n_config['body_font'];
    }
    ?>
    <style>
        .navigation {
            font-family: "<?php echo $nav_font; ?>", Helvetica, Arial, serif !important;
        }

        body {
            font-family: "<?php echo $body_font; ?>", Helvetica, Arial, serif !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "<?php echo $nav_font; ?>", Helvetica, Arial, serif;
        }

    </style>
    <!-- BEGIN: Custom CSS-->
    <?php
    if ($rtl_on) {
        ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>n_assets/css/style-rtl.css?ver=<?php echo $n_config['theme_version']; ?>">
        <style>.card .heading-elements {
                left: 1.7rem;
                right: auto;
            }</style>
        <?php
    } else {
        ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo base_url(); ?>n_assets/css/style.css?ver=<?php echo $n_config['theme_version']; ?>">
        <?php
    }
    ?>


    <style>
        @media all and (display-mode: standalone) {
            html {
                background-color: #B3C0D0 !important;
                margin-top: 20px;
            }
        }
    </style>
    <!-- END: Custom CSS-->
    <?php
    //    if($rtl_on){
    //        $nav_font = $n_config['nav_font_rtl'];
    //        $body_font = $n_config['body_font_rtl'];
    //    }else{
    //        $nav_font = $n_config['nav_font'];
    //        $body_font = $n_config['body_font'];
    //    }
    ?>
    <style>
        /*.navigation {*/
        /*    font-family: "*/
        <?php //echo $nav_font; ?> /*", Helvetica, Arial, serif!important;*/
        /*}*/
        /*body {*/
        /*    font-family: "*/
        <?php //echo $body_font; ?> /*", Helvetica, Arial, serif!important;*/
        /*}*/
        /*h1, h2, h3, h4, h5, h6{*/
        /*    font-family: "*/
        <?php //echo $nav_font; ?> /*", Helvetica, Arial, serif;*/
        /*}*/
    </style>
    <?php
    if ($n_config['theme_appeareance_on'] == 'true') {
        include(APPPATH . 'n_views/include/custom_style.php');
    }
    ?>

    <?php if ($n_config['onesignal_enabled'] == 'true') { ?>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
            var OneSignal = window.OneSignal || [];
            var initConfig = {
                appId: "<?php echo $n_config['onesignal_app_key'] ; ?>",
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
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page"
      data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php

        if ($this->_module != null) {
            $body = 'modules/' . $this->_module . '/' . $body;
        }

        //$this->load->view($body);
        $body = str_replace('.php', '', $body);

        $n_path = explode('/', $body);

        $n_end = end($n_path);
        switch ($n_end) {
            case 'crediental_check';
                if ($n_end == 'crediental_check') {
                    $n_end = 'credential_check';
                }
            case 'subscription_theme';
            case 'login';
            case 'sign_up';
            case 'forgot_password';
            case 'account_activation';
            case 'password_recovery';
            case 'credential_check';
                $body = '/site/default/' . $n_end;
                break;
        }


        if (file_exists(FCPATH . 'application/n_views/' . $body . '.php')) {
            include(FCPATH . 'application/n_views/' . $body . '.php');
        } else {
            var_dump('application/n_views/' . $body . '.php');
        }
        //include(FCPATH.'application/n_views/admin/theme/footer.php');

        ?>
    </div>
</div>
<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/vendors.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/configs/vertical-menu-dark.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/core/app-menu.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/core/app.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/components.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/footer.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<?php
if (file_exists(FCPATH . 'application/n_views/' . $body . '_js.php')) {
    include(FCPATH . 'application/n_views/' . $body . '_js.php');
}
?>
<script>
    $('document').ready(function () {
        $(".unlock_login").click(function (e) {
            $('form').removeClass('d-none');
        });

        $(".language_switch").click(function (e) {
            e.preventDefault();
            var language = $(this).attr('data-id');
            $.ajax({
                url: '<?php echo site_url("home/language_changer");?>',
                type: 'POST',
                data: {language: language},
                success: function (response) {
                    location.reload();
                }
            });
        });

    });
</script>

<?php if ($n_config['pwa_on'] == 'true') { ?>
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
                blurElement: '.app-content',
                appIconURL: '<?php echo base_url();?>assets/img/light_icon.png',
                spritesURL: '<?php echo base_url();?>n_assets/img/mobile-sprite.png',
                showOnReload: true,
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
<!-- END: Page JS-->

</body>
<!-- END: Body-->
</html>