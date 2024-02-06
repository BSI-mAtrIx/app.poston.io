<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <title><?php echo $title; ?></title>

    <?php
    $l = $this->lang;


    $include_dropzone = 0;
    $include_upload = 1;
    $include_perfectscroll = 1;
    $include_jqueryui = 1;
    include(FCPATH . 'application/n_views/config.php');
    include(APPPATH . 'n_views/default_ecommerce_builder.php');
    if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php')) {
        include(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $shop_id . '.php');
    }


    $current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language");
    if (strpos(strtolower($n_config['rtl_langs']), strtolower($current_language)) !== false) {
        $bfont_default = 'IBM+Plex+Sans';
        $nfont_default = 'Rubik';
        if ($bfont_default != $n_config['body_font_rtl']) {
            $bfont_default = str_replace(' ', '+', $n_config['body_font_rtl']);
        }
        if ($nfont_default != $n_config['nav_font_rtl']) {
            $nfont_default = str_replace(' ', '+', $n_config['nav_font_rtl']);
        }
        ?>
        <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
              rel="stylesheet">
    <?php } else {
        $bfont_default = 'IBM+Plex+Sans';
        $nfont_default = 'Rubik';
        if ($bfont_default != $n_config['body_font']) {
            $bfont_default = str_replace(' ', '+', $n_config['body_font']);
        }
        if ($nfont_default != $n_config['nav_font']) {
            $nfont_default = str_replace(' ', '+', $n_config['nav_font']);
        }
        ?>
        <link href="https://fonts.googleapis.com/css?family=<?php echo $bfont_default; ?>:300,400,500,600%7C<?php echo $nfont_default; ?>:300,400,500,600,700"
              rel="stylesheet">
    <?php }
    include(FCPATH . 'application/n_views/include/function_helper_theme.php');
    if (file_exists(FCPATH . 'manifest.json') and $n_config['pwa_on'] == 'true') {
        ?>
        <meta name="apple-mobile-web-app-capable" content="yes"/>

        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_72.png" rel="apple-touch-icon">
        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_76.png" rel="apple-touch-icon" sizes="76x76">
        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_120.png" rel="apple-touch-icon" sizes="120x120">
        <link href="<?php echo base_url(); ?>assets/img/pwa_icon_152.png" rel="apple-touch-icon" sizes="152x152">
    <?php } ?>


    <!-- JQuery -->
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/vendors.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <link rel=stylesheet
          href="<?php echo base_url(); ?>plugins/alertifyjs/css/alertify.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
    <link rel=stylesheet
          href="<?php echo base_url(); ?>plugins/alertifyjs/css/themes/default.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/forms/select/select2.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>plugins/alertifyjs/alertify.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/extensions/nouislider.min.css?ver=<?php echo $n_config['theme_version']; ?>">

    <?php
    if (strpos(strtolower($n_config['rtl_langs']), strtolower($current_language)) !== false) {
        include(FCPATH . 'application/n_views/include/css_include_back_rtl.php');
        $rtl_on = true;
    } else {
        $rtl_on = false;
        include(FCPATH . 'application/n_views/include/css_include_back.php');
    }
    $upload_js = false;

    ?>

    <style>
        .ajax-upload-dragdrop {
            max-width: 225px;
            text-align: center !important;
        }

        .ajax-upload-dragdrop span {
            display: block;
            width: 100%;
            margin-top: 10px;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .ajax-file-upload-statusbar {
            max-width: 205px
        }

        .ajax-file-upload-filename, .ajax-file-upload-progress {
            max-width: 195px
        }

        #scroll_this {
            height: 100vh;
            position: sticky;
        }

        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .panel_dis {
            display: none;
        }

        ul.sort li {
            padding-left: 15px;
            padding-right: 15px;
        }

        ul.sort .handle {
            padding: 0 5px;
            margin-right: 10px;
            background-color: rgba(0, 0, 0, .1);
            cursor: move;
            font-size: 1.2rem;
        }
    </style>
</head>
<body class="vertical-layout  2-columns overflow-hidden vertical-menu-modern menu-fixed menu-expanded expanded"
      data-id="<?php echo $shop_id; ?>">
<div class="main-menu menu-dark" style="width: 300px!important;">
    <form>
        <input type="hidden" name="csrf_token" id="csrf_token"
               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
        <div class="main-menu-content">
            <div class="row ml-0 mr-0">
                <div class="col-2 border-r2 bg-secondary bg-darken-3 pr-0 pl-0 section_buttons" style="height: 100vh;">
                    <a id="header_but" href="<?php echo base_url(); ?>dashboard"
                       class="btn p-0 bg-secondary rounded-0 bg-darken-4 border-0 text-center mx-auto"
                       title="<?php echo $this->lang->line("Go to Dashboard") ?>" data-toggle="tooltip"
                       data-placement="right">
                        <?php if (isset($n_config['dark_icon']) and file_exists(FCPATH . $n_config['dark_icon'])) { ?>
                            <img src="<?php echo base_url();
                            echo $n_config['dark_icon']; ?>" class="img-fluid" style="padding: 6px"/>
                        <?php } else { ?>
                            <i class="bx bx-home font-large-1 bx-tada-hover text-white"
                               style="margin: 1px 9px 10px 9px;"></i>
                        <?php } ?>
                    </a>
                    <button id="misc_but" class="mt-2 action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Miscellaneous") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bxs-wrench font-large-1 primary bx-tada-hover"></i>
                    </button>
                    <button id="styles_but" class="action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Main Styles") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bxs-color-fill font-large-1 text-white  bx-tada-hover"></i>
                    </button>
                    <button id="mobile_but" class="action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Mobile settings") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bx-mobile-alt font-large-1 text-white  bx-tada-hover"></i>
                    </button>

                    <button id="header_but" class="mt-2 action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Header") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bxs-dock-top font-large-1 white bx-tada-hover"></i>
                    </button>
                    <button id="slider_but" class="action bg-transparent border-0 text-center mx-auto d-none"
                            title="<?php echo $this->lang->line("Slider") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bx-slider font-large-1 text-white  bx-tada-hover"></i>
                    </button>
                    <button id="front_product_but" class="action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Frontend product view") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bxs-store font-large-1 text-white  bx-tada-hover"></i>
                    </button>
                    <button id="footer_but" class="action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Footer") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bxs-dock-bottom font-large-1 white bx-tada-hover"></i>
                    </button>


                    <button id="category_but" class="action mt-2 bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Category") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bx-category font-large-1 text-white  bx-tada-hover"></i>
                    </button>
                    <button id="special_but" class="action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Special pages") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bx-news font-large-1 text-white  bx-tada-hover"></i>
                    </button>
                    <button id="prodsing_but" class="action bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Product single") ?>" data-toggle="tooltip"
                            data-placement="right">
                        <i class="bx bx-package font-large-1 text-white  bx-tada-hover"></i>
                    </button>


                </div>
                <div class="col-10 p-0 bg-secondary bg-lighten-1" id="panels_dis">
                    <div id="scroll_this">
                        <?php

                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/misc.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/frontend.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/header.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/styles.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/category.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/slider.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/specialpages.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/mobile.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/product.php');
                        include(APPPATH . 'n_views/modules/n_theme/n_views/panels/footer.php');
                        ?>


                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="content border-left-3" style="margin-left: 300px;">
    <div class="content-wrapper p-0">
        <div class="bg-secondary bg-darken-1">
            <div class="row">
                <div class="col-3">
                    <button class="action bg-transparent border-0 text-center mx-auto show_home"
                            title="<?php echo $this->lang->line("Show home store") ?>" data-toggle="tooltip"
                            data-placement="bottom">
                        <i class="bx bx-home font-large-1 text-white bx-tada-hover"></i>
                    </button>
                    <button class="action bg-transparent border-0 text-center mx-auto builder_restore_defaults"
                            title="<?php echo $this->lang->line("Restore defaults settings") ?>" data-toggle="tooltip"
                            data-placement="bottom">
                        <i class="bx bx-reset font-large-1 text-white bx-tada-hover"></i>
                    </button>
                </div>
                <div class="col-6 text-center">
                    <button class="iframe_view_style bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Mobile view") ?>" data-toggle="tooltip"
                            data-placement="bottom" data-view_as="mobile">
                        <i class="bx bx-mobile-alt font-large-1 text-white bx-tada-hover"></i>
                    </button>
                    <button class="iframe_view_style bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $this->lang->line("Tablet view") ?>" data-toggle="tooltip"
                            data-placement="bottom" data-view_as="tablet">
                        <i class="bx bx-mobile-landscape font-large-1 text-white bx-tada-hover"></i>
                    </button>
                    <button class="iframe_view_style bg-transparent border-0 text-center mx-auto"
                            title="<?php echo $l->line("Desktop view") ?>" data-toggle="tooltip" data-placement="bottom"
                            data-view_as="desktop">
                        <i class="bx bx-desktop font-large-1 text-primary bx-tada-hover"></i>
                    </button>
                </div>

            </div>
        </div>
        <div id="iframe_wrapper" class="bg-secondary d-flex" style="height:calc( 100vh - 31px );">
            <iframe id="if_scroll" src="<?php echo base_url('ecommerce/store/' . $shop_id); ?>?builder=1" class="m-auto"
                    frameborder="0" style="height: calc( 100vh - 31px );" width="100%"></iframe>
        </div>

    </div>

</div>


<?php
include(FCPATH . 'application/n_views/include/js_include_back.php');
include(FCPATH . 'application/n_views/include/js_include_back_function.php');
?>
<script>
    var category_perpage = "<?php echo $n_eco_builder_config['category_perpage']; ?>";
    var front_featured_products_rows = "<?php echo $n_eco_builder_config['front_featured_products_rows']; ?>";
    var front_deals_products_rows = "<?php echo $n_eco_builder_config['front_deals_products_rows']; ?>";
    var front_sales_products_rows = "<?php echo $n_eco_builder_config['front_sales_products_rows']; ?>";
    var new_products_rows = "<?php echo $n_eco_builder_config['new_products_rows']; ?>";

    var Variables_lang = "<?php echo $this->lang->line("Variables"); ?>";


    var product_single_width_0_items_related = "<?php echo $n_eco_builder_config['product_single_width_0_items_related']; ?>";
    var product_single_width_576_items_related = "<?php echo $n_eco_builder_config['product_single_width_576_items_related']; ?>";
    var product_single_width_768_items_related = "<?php echo $n_eco_builder_config['product_single_width_768_items_related']; ?>";
    var product_single_width_992_items_related = "<?php echo $n_eco_builder_config['product_single_width_992_items_related']; ?>";

    var areyousure = "<?php echo $this->lang->line("are you sure") . ' ' . $this->lang->line("restore default settings?"); ?>";
    var yes = "<?php echo $this->lang->line("yes"); ?>";
    var no = "<?php echo $this->lang->line("no"); ?>";

    var copy_to_header = "<?php echo $this->lang->line("Select the language to which to copy the selected item?"); ?>";
    var copy_to_select = "<?php echo $this->lang->line("Select language"); ?>";

    var copy_to_you_need = "<?php echo $this->lang->line("Please select correct language"); ?>"

    var warning = "<?php echo $this->lang->line("Warning"); ?>";
    var success = "<?php echo $this->lang->line("Success"); ?>";
    var error = "<?php echo $this->lang->line("Success"); ?>";

    var error_min_val = "<?php echo $this->lang->line("Minimum value not set"); ?>";

</script>
<?php
ksort($language_info);
$swal_langs = array();
foreach ($language_info as $key_lang => $value_lang) {
    $swal_langs[strtolower($key_lang)] = $value_lang;
} ?>

<script>
    var swal_copy_to_langs = <?php echo json_encode($swal_langs); ?>;
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/js/spectrum/spectrum.min.css"/>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/nouislider.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/js/spectrum/spectrum.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/js/ebuilder.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

</body>
</html>