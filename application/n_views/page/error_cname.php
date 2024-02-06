<?php
include(FCPATH . 'application/n_views/config.php');
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo $this->config->item('product_name') . " | " . $page_title; ?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>n_assets/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700"
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
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/assets/css/style.css?ver=<?php echo $n_config['theme_version']; ?>">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page"
      data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- not authorized start -->
            <section class="row flexbox-container">
                <div class="col-xl-7 col-md-8 col-12">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-body text-center bg-transparent">
                            <img src="<?php echo base_url(); ?>n_assets/app-assets/images/pages/not-authorized.png"
                                 class="img-fluid" alt="not authorized" width="400">
                            <h1 class="my-2 error-title"><?php echo $page_title; ?></h1>
                            <p><?php echo $message; ?></p>
                            <?php
                            $url_back = base_url();
                            ?>

                            <a href="<?php echo $url_back; ?>"
                               class="btn btn-primary round glow mt-2"><?php echo $this->lang->line("Go back to home"); ?></a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- not authorized end -->

        </div>
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
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/configs/vertical-menu-dark.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/core/app-menu.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/core/app.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/components.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/footer.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->

</body>
<!-- END: Body-->
</html>