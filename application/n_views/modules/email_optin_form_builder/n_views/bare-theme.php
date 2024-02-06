<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= htmlspecialchars($form['form_name']) ?></title>
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.png">

    <!-- General CSS Files -->
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/fontawesome/css/v4-shims.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap-social/bootstrap-social.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/ionicons/css/ionicons.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css?ver=<?php echo $n_config['theme_version']; ?>">

    <!-- Template CSS -->
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/css/style.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/css/components.css?ver=<?php echo $n_config['theme_version']; ?>">

    <!-- Custom -->
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/css/custom.css?ver=<?php echo $n_config['theme_version']; ?>">

    <!-- General JS Scripts -->
    <script src="<?php echo base_url(); ?>assets/modules/jquery.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/popper.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/tooltip.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/stisla.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

</head>

<body class="optin_direct_form_body_bg">
<div id="app">
    <div class="main-wrapper">
        <div class="container">
            <?php $this->load->view($body) ?>
        </div>
    </div>
</div>
</body>
</html>
