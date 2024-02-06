<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= htmlspecialchars($form['form_title']) ?></title>
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
          href="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css?ver=<?php echo $n_config['theme_version']; ?>">
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

    <!--Jquey Date Time Picker -->
    <link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
          rel="stylesheet" type="text/css"/>

    <!--Emoji CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/css/emojionearea.min.css"
          media="screen">

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

    <!-- JS Libraies -->
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!--Jquery Date Time Picker -->
    <script type="text/javascript"
            src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!-- Emoji Library-->
    <script src="<?php echo base_url(); ?>plugins/emoji/dist/emojionearea.js" type="text/javascript"></script>

    <!-- Template JS File -->
    <script src="<?php echo base_url(); ?>assets/js/scripts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!-- Load Facebook Messenger SDK -->

    <script type="text/javascript">


        var PSID;

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/messenger.Extensions.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'Messenger'));


        window.extAsyncInit = function () {

            MessengerExtensions.getContext('<?php echo $fb_app_id; ?>',
                function success(thread_context) {
                    PSID = thread_context.psid;
                },
                function error(err) {
                    console.log(err);
                }
            );

        };


    </script>

</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="container">
            <?php $this->load->view($body) ?>
        </div>
    </div>
</div>
</body>
</html>
