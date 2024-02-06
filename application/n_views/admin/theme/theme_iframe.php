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
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">

    <?php
    $uri_last = md5(current_url());

    include(FCPATH . 'application/n_views/config.php');
    $current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language");
    if (strpos(strtolower($n_config['rtl_langs']), strtolower($current_language)) !== false) {
        $bfont_default = 'IBM+Plex+Sans';
        $nfont_default = 'Rubik';
        if ($n_config['theme_appeareance_on'] == 'true') {
            $bfont_default = str_replace(' ', '+', $n_config['body_font_rtl']);
            $nfont_default = str_replace(' ', '+', $n_config['nav_font_rtl']);
        }
        ?>
        <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
              rel="stylesheet">
    <?php } else {
        $bfont_default = 'IBM+Plex+Sans';
        $nfont_default = 'Rubik';
        if ($n_config['theme_appeareance_on'] == 'true') {
            $bfont_default = str_replace(' ', '+', $n_config['body_font']);
            $nfont_default = str_replace(' ', '+', $n_config['nav_font']);
        }
        ?>
        <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
              rel="stylesheet">
    <?php } ?>
    <?php

    if ($rtl_on) {
        include(FCPATH . 'application/n_views/include/css_include_back_rtl.php');
    } else {
        include(FCPATH . 'application/n_views/include/css_include_back.php');
    }
    $upload_js = false;
    ?>

    <script type="text/javascript">
        window.addEventListener('load', function () {
            $(".preloading_body").fadeOut("slow");
        }, false);
    </script>

    <style type="text/css">
        body {
            height: initial !important;
            background: transparent !important;
        }

        textarea, .multi_layout {
            background: transparent !important;
        }

        body.dark-layout #main_iframe > div .modal-content {
            background: transparent !important;
        }

        body.light-layout #main_iframe.ecommerce .modal-content,
        body.semi-dark-layout #main_iframe.ecommerce .modal-content {
            background: #ffffff !important;
        }


        .preloading_body i {
            font-size: 40px;
            display: table-cell;
            vertical-align: middle;
            padding: 30px 0;
        }

        .preloading_body {
            height: 100%;
            width: 100%;
            display: table;
        }

        body.dark-layout .card {
            background: #1A233A;
        }


        /* loader */
    </style>

    <?php
    if ($rtl_on) {
        $nav_font = $n_config['nav_font_rtl'];
        $body_font = $n_config['body_font_rtl'];
        echo '<script> var ndir = "rtl" </script>';
        echo '<style> *{direction: rtl!important;} </style>';
        //left: initial!important;
        echo '<style>
    .select2-container{
        
        right: 0px!important;
    }
</style>';
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

        body {
            font-family: "<?php echo $body_font; ?>", Helvetica, Arial, serif !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "<?php echo $nav_font; ?>", Helvetica, Arial, serif;
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

        input.dz-hidden-input {
            position: initial;
            display: none;
        }

    </style>

    <?php if ($n_config['theme_appeareance_on'] == 'true') {
        include(APPPATH . 'n_views/include/custom_style.php');
    }
    $n_str = explode('/', $body);
    if (!empty($n_str[0])) {
        $add_n_class = $n_str[0];
    } else {
        $add_n_class = '';
    }

    $body_l = $body;
    if ($this->_module != null) {
        $body = 'modules/' . $this->_module . '/' . $body;
    }
    ?>
</head>
<?php
$n_theme_on_load = get_cookie('layout-name');
if (!empty($n_theme_on_load)) {
    $layout_on_load = $n_theme_on_load;
} else {
    $layout_on_load = $n_config['current_theme'];
}
?>
<body class="<?php echo $layout_on_load;
echo ' ' . $uri_last; ?>" id="main_iframe">
<div class="text-center preloading_body">
    <i class="bx bx-loader-alt bx-spin blue text-center"></i>
</div>

<div class="card shadow-none overflow-hidden <?php echo $add_n_class; ?>" style="border:0!important;">

    <?php
//    if ($this->_module != null) {
//        $body = 'modules/' . $this->_module . '/' . $body;
//    }

    //$this->load->view($body);
    $body = str_replace('.php', '', $body);
    if ($n_config['dev_mode'] == true) {
        print('File:<pre>application/n_views/' . $body . '.php</pre>');
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


<?php
include(FCPATH . 'application/n_views/include/js_include_back.php');
include(FCPATH . 'application/n_views/include/js_include_back_function.php');
?>


<?php

if (!empty($addon_page) and file_exists(FCPATH . 'application/' . $addon_page . '_js.php')) {
    var_dump('application/' . $addon_page . '_js.php');
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
    window.addEventListener("message", receiveMessage, false);

    function receiveMessage(event) {
        if (event.data == "light-layout") {
            body.removeClass("light-layout").addClass("dark-layout");
            mainMenu.removeClass("menu-light").addClass("menu-dark");
            navbar.removeClass("navbar-light").addClass("navbar-dark");
        }
        if (event.data == "dark-layout") {
            body.removeClass("dark-layout").addClass("light-layout");
            mainMenu.removeClass("menu-dark").addClass("menu-light");
            navbar.removeClass("navbar-dark").addClass("navbar-light");
        }
    }

    if (Cookies.get('layout-name') == 'dark-layout') {
        body.removeClass("semi-dark-layout").addClass("dark-layout");
        mainMenu.removeClass("menu-light").addClass("menu-dark");
        navbar.removeClass("navbar-dark").addClass("navbar-dark");
    }


</script>


</body>
</html>
<!--Todo: check this file-->
<!--<link rel="stylesheet" href="--><?php //echo base_url('assets/css/system/inline.css?ver='. $n_config['theme_version']);?><!--">-->