<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php echo $this->config->item('product_name') . " | " . $page_title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap-social/bootstrap-social.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/fontawesome/css/v4-shims.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/css/style.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/css/components.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/css/custom.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>assets/modules/jquery.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
</head>

<body>
<div id="app">
    <section class="section">
        <?php echo $this->load->view($body); ?>
    </section>
</div>
</body>