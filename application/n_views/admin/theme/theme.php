<?php
define('NVX', 1);
$sgp_exists = false;
if(file_exists(APPPATH.'sgp.php')){
    $sgp_exists = true;
}
include(FCPATH . 'application/n_views/config.php');
include(FCPATH . 'application/n_views/include/function_helper_theme.php');
$current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language");
if (strpos(strtolower($n_config['rtl_langs']), strtolower($current_language)) !== false) {
    $rtl_on = true;
    $html_lang = 'data-textdirection="rtl"';
} else {
    $rtl_on = false;
    $html_lang = 'data-textdirection="ltr"';
}

?>
<!DOCTYPE html>
<html class="loading" lang="<?php echo LangToCode($current_language, $n_config); ?>" <?php echo $html_lang; ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo $this->config->item('product_name') . " | " . $page_title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">

    <?php
    if (strpos(strtolower($n_config['rtl_langs']), strtolower($current_language)) !== false) {
        $bfont_default = 'IBM+Plex+Sans';
        $nfont_default = 'Rubik';
        if ($bfont_default != $n_config['body_font_rtl']) {
            $bfont_default = str_replace(' ', '+', $n_config['body_font_rtl']);
        }
        if ($nfont_default != $n_config['nav_font_rtl']) {
            $nfont_default = str_replace(' ', '+', $n_config['nav_font_rtl']);
        }
    } else {
        $bfont_default = 'IBM+Plex+Sans';
        $nfont_default = 'Rubik';
        if ($bfont_default != $n_config['body_font']) {
            $bfont_default = str_replace(' ', '+', $n_config['body_font']);
        }
        if ($nfont_default != $n_config['nav_font']) {
            $nfont_default = str_replace(' ', '+', $n_config['nav_font']);
        }
    } ?>
    <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
          rel="stylesheet">



    <?php


    if (file_exists(FCPATH . 'manifest.json') and $n_config['pwa_on'] == 'true') {
        include(APPPATH.'n_views/admin/theme/pwa_splash.php');
    }

    if ($rtl_on) {
        include(FCPATH . 'application/n_views/include/css_include_back_rtl.php');
    } else {
        include(FCPATH . 'application/n_views/include/css_include_back.php');
    }
    $upload_js = false;
    ?>


    <script>
        window.resizeIframe = function (obj) {
            return;
        }
    </script>
    <style>
        @media all and (display-mode: standalone) {

        }

        @media screen and (max-device-width: 450px) {
            #add_template_modal .row, #add_template_modal .modal-body {
                margin-left: 0px !important;
                margin-right: 0px !important;
            }

            #add_template_modal {
                padding: 0 !important;
            }

            #add_template_modal .modal-body {
                margin: 0 !important;
                padding: 5px !important;
            }
        }


        <?php if($n_config['theme_mobile_full_width']=='true'){ ?>
        @media (max-width: 575.98px) {
            html .content .content-wrapper {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }

        <?php } ?>

    </style>

    <?php
    if ($rtl_on) {
        $nav_font = $n_config['nav_font_rtl'];
        $body_font = $n_config['body_font_rtl'];
        echo '<script> var ndir = "rtl" </script>';
        echo '<style> *{direction: rtl!important;} </style>';
    } else {
        $nav_font = $n_config['nav_font'];
        $body_font = $n_config['body_font'];
        echo '<script> var ndir = "ltr" </script>';
    }
    ?>
    <style>
        .navigation {
            font-family: "<?php echo $nav_font; ?>", Helvetica, Arial, serif !important;
        }

        body, .table th, .table td {
            font-family: "<?php echo $body_font; ?>", Helvetica, Arial, serif !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "<?php echo $nav_font; ?>", Helvetica, Arial, serif;
        }

    </style>

    <?php if ($n_config['theme_appeareance_on'] == 'true') {
        include(APPPATH . 'n_views/include/custom_style.php');
    } ?>

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

    <?php
    $n_theme_on_load = get_cookie('layout-name');
    if (!empty($n_theme_on_load)) {
        $layout_on_load = $n_theme_on_load;
    } else {
        $layout_on_load = $n_config['current_theme'];
    }

    $n_theme_on_sidebar = get_cookie('modern-nav-toggle');
    if (!empty($n_theme_on_sidebar)) {
        $n_theme_on_sidebar = $n_theme_on_sidebar;
    } else {
        $n_theme_on_sidebar = $n_config['current_sidebar'];
    }

    $body_l = $body;
    if ($this->_module != null) {
        $body = 'modules/' . $this->_module . '/' . $body;
    }

    //$this->load->view($body);
    $body = str_replace('.php', '', $body);

    ?>
<body class="vertical-layout vertical-menu-modern <?php echo $layout_on_load; ?> <?php echo $n_theme_on_sidebar; ?> 2-columns  navbar-sticky footer-static  " id="<?php echo str_replace("/", '_', $body); ?>"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<?php
include(FCPATH . 'application/n_views/admin/theme/header.php');
include(FCPATH . 'application/n_views/admin/theme/sidebar.php');
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php

        if ($n_config['dev_mode'] == true) {
            print('File:<pre>application/n_views/' . $body . '.php</pre>');
        }

        if ($n_config['import_account_fb_alert'] == 'alert_all') {
            $where_alert['where'] = array('user_id' => $this->user_id);
            $existing_accounts_alert = $this->basic->get_data('facebook_rx_fb_user_info', $where_alert);

            if (empty($existing_accounts_alert)) {
                echo '<div class="alert alert-warning mb-1" role="alert"><a href="' . base_url('/social_accounts/index') . '" class="text-white">';
                echo $this->lang->line('You haven not connected any account yet.');
                echo '</a></div>';
            }
        }

        if ($body_l == 'n_addon_loader') {
            $body = 'modules/' . $this->_module . '/views/' . $body_l;
            if (file_exists(FCPATH . 'application/' . $body . '.php')) {
                include(FCPATH . 'application/' . $body . '.php');
            } else {
                var_dump('application/' . $body . '.php');
            }
        } else {
            if (file_exists(FCPATH . 'application/n_views/' . $body . '.php')) {
                include(FCPATH . 'application/n_views/' . $body . '.php');
            } else {
                var_dump('application/n_views/' . $body . '.php');
            }
        }


        //include(FCPATH.'application/n_views/admin/theme/footer.php');

        ?>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-left d-inline-block"><?php echo date('Y'); ?> &copy; <?php echo $this->config->item("product_short_name") . " "; ?></span>
        <!--            <span class="float-right d-sm-inline-block d-none">-->
        <!--                Created with<i class="bx bxs-heart pink mx-50 font-small-3"></i>by MD-->
        <!--            </span>-->
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
    </p>
</footer>


<?php
include(FCPATH . 'application/n_views/include/js_include_back.php');
include(FCPATH . 'application/n_views/include/js_include_back_function.php');
?>



<?php


if (!empty($addon_page) and file_exists(FCPATH . 'application/' . $addon_page . '_js.php')) {
    include(FCPATH . 'application/' . $addon_page . '_js.php');
}

if (file_exists(FCPATH . 'application/n_views/' . $body . '_js.php')) {
    include(FCPATH . 'application/n_views/' . $body . '_js.php');
}


if (file_exists(FCPATH . 'n_assets/js/system/' . $body . '.js?ver=' . $n_config['theme_version'])) {
    echo '<script src="' . base_url("n_assets/js/system/" . $body . ".js?ver=" . $n_config['theme_version']) . '"></script>';
} else {
    if ($n_config['dev_mode'] == true) {
        var_dump(FCPATH . 'n_assets/js/system/' . $body . '.js?ver=' . $n_config['theme_version']);
    }
}

if (!empty($include_js_uni)) {
    include $include_js_uni;
}

if (!empty($include_js_uni_2)) {
    include $include_js_uni_2;
}

?>

<?php if (isset($include_select2) and $include_select2 == 1) { ?>
    <script>
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
            });
        });
    </script>
<?php } ?>

<script>
    function send_command(command) {
        var right_column_content_js = true;
        if (document.getElementById("right_column_content") == null || document.getElementById("right_column_content").getElementsByTagName('iframe')[0] == null) {
            right_column_content_js = false;
        }
        if (right_column_content_js) {
            document.getElementById("right_column_content").getElementsByTagName('iframe')[0].contentWindow.postMessage(command);
        }
        var right_column_js = true;
        if (document.getElementById("right_column") == null || document.getElementById("right_column").getElementsByTagName('iframe')[0] == null) {
            right_column_js = false;
        }
        if (right_column_js) {
            document.getElementById("right_column").getElementsByTagName('iframe')[0].contentWindow.postMessage(command);
        }
    }

    $(".modern-nav-toggle").on("click", function () {
        if (body.hasClass("menu-collapsed")) {
            Cookies.set('modern-nav-toggle', 'menu-expanded');
        } else {
            Cookies.set('modern-nav-toggle', 'menu-collapsed');
        }
    });

    $(".layout-name").on("click", function () {

        if (body.hasClass("light-layout")) {
            send_command("light-layout");
            body.removeClass("light-layout").addClass("dark-layout");
            mainMenu.removeClass("menu-light").addClass("menu-dark");
            navbar.removeClass("navbar-light").addClass("navbar-dark");
            Cookies.set('layout-name', 'dark-layout');
            return;
        }

        if (body.hasClass("semi-dark-layout")) {
            send_command("light-layout");
            body.removeClass("semi-dark-layout").addClass("dark-layout");
            mainMenu.removeClass("menu-light").addClass("menu-dark");
            navbar.removeClass("navbar-light").addClass("navbar-dark");
            Cookies.set('layout-name', 'dark-layout');
            return;
        }
        <?php if($n_config['current_theme'] == 'semi-dark-layout'){ ?>

        if (body.hasClass("dark-layout")) {
            send_command("dark-layout");
            body.removeClass("dark-layout").addClass("semi-dark-layout");
            mainMenu.removeClass("menu-light").addClass("menu-dark");
            navbar.removeClass("navbar-dark").addClass("navbar-dark");
            Cookies.set('layout-name', 'semi-dark-layout');
            return;
        }

        <?php }elseif($n_config['current_theme'] == 'light-layout' or $n_config['current_theme'] == 'dark-layout'){ ?>

        if (body.hasClass("dark-layout")) {
            send_command("dark-layout");
            body.removeClass("dark-layout").addClass("light-layout");
            mainMenu.removeClass("menu-dark").addClass("menu-light");
            navbar.removeClass("navbar-dark").addClass("navbar-light");
            Cookies.set('layout-name', 'light-layout');
            return;
        }

        <?php } ?>


    });

    if (Cookies.get('layout-name') == 'dark-layout') {
        body.removeClass("semi-dark-layout").addClass("dark-layout");
        mainMenu.removeClass("menu-light").addClass("menu-dark");
        navbar.removeClass("navbar-dark").addClass("navbar-dark");
    }


    $(document).ready(function () {
        iFrameResize({
            log: false,
            minHeight: 700,
        })
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
<?php } ?>

<?php include(FCPATH . 'application/n_views/include/helper_pages.php'); ?>
<?php include(FCPATH . 'application/views/include/google_code.php'); ?>
<?php include(FCPATH . 'application/views/include/fb_px.php'); ?>

</body>
</html>


