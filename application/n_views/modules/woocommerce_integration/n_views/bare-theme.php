<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php echo isset($page_title) ? $page_title : $this->config->item('product_name'); ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png'); ?>">

    <!-- General CSS Files -->
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/fontawesome/css/v4-shims.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/file-uploaders/dropzone.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css?ver=<?php echo $n_config['theme_version']; ?>">
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
    <script src="<?php echo base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/stisla.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!-- JS Libraies -->
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/file-uploaders/dropzone.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!-- Template JS File -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <style type="text/css">
        html {
            overflow-x: hidden;
        }

        @media only screen and (max-width: 760px) {
            #device-check {
                display: none;
            }
        }

        .bg-light {
            background: #f8f9fa !important
        }

        .data-card .table td {
            border: none !important;
            padding: 0 !important;
        }

        .data-card .table-bordered tbody {
            border: none !important;
        }

        table.dataTable.no-footer {
            border-bottom-width: 0 !important;
        }

        .data-card .dataTables_length, .data-card .dataTables_info {
            display: none !important;
        }

        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            justify-content: center !important;
        }

        .modal {
            padding-right: 0 !important;
        }

        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content {
            /*height: auto;*/
            height: 100%;
            border-radius: 0;
        }

        .modal-body {
            height: calc(100% - 58px);
            overflow-y: auto;
        }

        .modal-footer {
            height: 58px;
        }

        .modal .form-group {
            margin-bottom: 10px;
        }

        .modal-header i {
            font-size: 20px;
        }

        .refund_terms {
            margin-top: 10px;
            padding-left: 15px;
        }

        .list-group-flush {
            border: none;
        }

        .list-group-flush .list-group-item {
            border-color: #e4e6fc;
        }

        #dismiss {
            line-height: 0;
        }

        #dismiss i {
            font-size: 20px;
        }

        #sidebar .list-group-item {
            padding: 0;
            font-size: 12px;
        }

        #sidebar .list-group-item i {
            padding-right: 10px;
        }

        #sidebar a, #sidebar a:hover, #sidebar a:focus {
            /*color: inherit;*/
            text-decoration: none;
            transition: all 0.3s;
        }

        #sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            height: 100vh;
            z-index: 999;
            color: #fff;
            transition: all 0.3s;
            overflow-y: auto;
            box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
        }

        #sidebar.active {
            left: 0;
        }

        #sidebar .sidebar-header {
            padding: 25px 15px 0 15px;
        }

        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
        }

        a[data-toggle="collapse"] {
            position: relative;
        }

        a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
            content: '' !important;
            display: block;
            position: absolute;
            right: 20px;
            font-family: 'Glyphicons Halflings';
            font-size: 0.6em;
        }

        a[aria-expanded="true"]::before {
            content: '\e260';
        }

        ul ul a {
            font-size: 0.9em !important;
            padding-left: 30px !important;
            background: #6d7fcc;
        }

        .d-print-thermal {
            display: none;
        }

        .fa-star.text-small {
            font-size: 10px;
        }

        /*.swal-overlay{z-index: 1000;}  */
    </style>
</head>

<body class="bg-light">
<a id="login_form" class="d-none"></a> <!-- needed to open login modal -->
<div id="device-check"></div>

<div id="app">
    <!-- <div class="overlay"></div> -->
    <div class="main-wrapper h-100">
        <div class="container" id="d-main-container">
            <?php
            if (isset($body)) $this->load->view($body);
            else echo $output;
            ?>
        </div>
    </div>


</div>
</body>
</html>

<script type="text/javascript">
    var is_mobile = areWeUsingScroll = false;
    var is_in_iframne = false;
    if (window.location !== window.parent.location) is_in_iframne = true;

    $(document).ready(function () {
        if ($('#device-check').css('display') == 'none') {
            is_mobile = true;
        }
        if (!is_mobile || is_in_iframne) {
            // $("#sidebar").niceScroll();
            // $(".modal-body").niceScroll();
            $(".category_container").niceScroll();
            $(".makescroll").niceScroll();
        }
    });
</script>