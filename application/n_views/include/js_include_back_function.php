<?php if (isset($include_upload) and $include_upload == 1) { ?>
    <link href="<?php echo base_url(); ?>n_assets/css/uploadfile.css?ver=<?php echo $n_config['theme_version']; ?>"
          rel="stylesheet">
    <script src="<?php echo base_url('n_assets/js/jquery.uploadfile.min.js?ver=' . $n_config['theme_version']); ?>"></script>
    <style>
        .ajax-file-upload-error {
            color: #ff0000;
        }
    </style>
<?php } ?>

<?php if (isset($include_datetimepicker) and $include_datetimepicker == 1) { ?>
    <link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
          rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>

<?php if (isset($include_emoji) and $include_emoji == 1) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/css/emojionearea.min.css"
          media="screen">
    <script src="<?php echo base_url(); ?>plugins/emoji/dist/emojionearea.js" type="text/javascript"></script>
<?php } ?>

<?php if (isset($include_colorpicker) and $include_colorpicker == 1) { ?>
    <link rel="stylesheet"
          href="<?php echo base_url('n_assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css?ver=' . $n_config['theme_version']); ?>">
    <script src="<?php echo base_url(); ?>n_assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>

<?php if (isset($include_summernote) and $include_summernote == 1) { ?>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>n_assets/plugins/summernote/summernote-bs4.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>n_assets/plugins/summernote/summernote-bs4.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script>
        if (jQuery().summernote) {
            $(".summernote").summernote({
                dialogsInBody: true,
                minHeight: 250,
            });
            $(".summernote-simple").summernote({
                dialogsInBody: true,
                minHeight: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['paragraph']]
                ]
            });
        }
    </script>
<?php } ?>

<?php if (isset($include_datatable) and $include_datatable == 1) { ?>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <style>
        .tooltip {
            top: -32px !important;
        }

        .bs-tooltip-top .arrow {
            bottom: 1px !important;
        }
    </style>
<?php } ?>

<?php if (isset($include_cropper) and $include_cropper == 1) { ?>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>n_assets/js/cropper/cropper.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>n_assets/js/cropper/cropper.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/js/cropper/jquery-cropper.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<?php } ?>

<?php if (isset($include_dropzone) and $include_dropzone == 1) { ?>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/file-uploaders/dropzone.min.css?ver=<?php echo $n_config['theme_version']; ?>">

    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/file-uploaders/dropzone.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script>Dropzone.autoDiscover = false;</script>
<?php } ?>

<script>
    var areWeUsingScroll = false;
    //TODO: areWeUsingScroll
</script>

<?php if (isset($include_mCustomScrollBar) and $include_mCustomScrollBar == 1) { ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>plugins/scrollbar/jquery.mCustomScrollbar.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>plugins/scrollbar/jquery.mCustomScrollbar.concat.min.js"
            type="text/javascript"></script>
<?php } ?>

<?php if (isset($include_tagsinput) and $include_tagsinput == 1) { ?>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>

<?php if (isset($include_alertify) and $include_alertify == 1) { ?>
    <script src="/plugins/alertifyjs/alertify.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <?php if ($rtl_on) { ?>
        <!-- include the RTL css files-->
        <link rel=stylesheet
              href="/plugins/alertifyjs/css/alertify.rtl.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
        <link rel=stylesheet
              href="/plugins/alertifyjs/css/themes/bootstrap.rtl.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>

        <!-- then override glossary values -->
        <script type="text/javascript">
            alertify.defaults.glossary.title = 'أليرتفاي جي اس';
            alertify.defaults.glossary.ok = 'موافق';
            alertify.defaults.glossary.cancel = 'إلغاء';
        </script>
    <?php } else { ?>
        <link rel=stylesheet
              href="/plugins/alertifyjs/css/alertify.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
        <link rel=stylesheet
              href="/plugins/alertifyjs/css/themes/bootstrap.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
    <?php } ?>
<?php } ?>

<?php if (isset($include_morris) and $include_morris == 1) { ?>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<?php } ?>

<?php if (isset($include_chartjs) and $include_chartjs == 1) { ?>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/charts/chart.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>

<?php if (isset($include_owlcar) and $include_owlcar == 1) { ?>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>

<?php if (isset($include_prism) and $include_prism == 1) { ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/ui/prism.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/ui/prism.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>

<?php if (isset($include_perfectscroll) and $include_perfectscroll == 1) { ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/perfect-scrollbar/perfect-scrollbar.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/perfectscrollbar/perfect-scrollbar.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>


<?php
$jodit_cg = false;
if (isset($jodit) and $jodit == 1) { ?>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>n_assets/js/jodit-3.10.2/build/jodit.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>n_assets/js/jodit-3.10.2/build/jodit.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<?php
    if(file_exists(APPPATH.'modules/n_generator/include/3rd_support/jodit.php')){
        include(APPPATH.'modules/n_generator/include/3rd_support/jodit.php');
        $jodit_cg = true;
    }

} ?>

