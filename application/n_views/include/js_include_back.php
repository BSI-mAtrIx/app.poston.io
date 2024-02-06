<!-- BEGIN: Vendor JS-->
<?php include(APPPATH . "n_views/include/js_variables.php"); ?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/vendors.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php if (isset($include_jqueryui) and $include_jqueryui == 1) { ?>
    <script src="<?php echo base_url(); ?>n_assets/js/jquery-ui/jquery-ui.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/plugins/izitoast/js/iziToast.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/ui/prism.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/configs/vertical-menu-dark.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php if ($n_config['theme_appeareance_on'] == 'true') { ?>
    <script>
        // Menu Icon Color Config
        var menuIconColorsObj = {
            iconStrokeColor: "<?php echo $n_config['dark_icon_color']; ?>",
            iconSolidColor: "<?php echo $n_config['dark_icon_color']; ?>",
            iconFillColor: "#d4ebf9",
            iconStrokeColorAlt: "#5A8DEE"
        };


        // Active Menu Icon Color Config
        var menuActiveIconColorsObj = {
            iconStrokeColor: "<?php echo $n_config['dark_icon_color']; ?>",
            iconSolidColor: "<?php echo $n_config['dark_icon_color']; ?>",
            iconFillColor: "#d4ebf9",
            iconStrokeColorAlt: "#5A8DEE"
        };
    </script>
<?php } ?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/core/app-menu.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/core/app.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/js/js.cookie.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/js/iframe-resizer/iframeResizer.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/js/iframe-resizer/iframeResizer.contentWindow.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="<?php echo base_url(); ?>n_assets/app-assets/js/scripts/popover/popover.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<!-- END: Page JS-->


<script>

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

    $(".dont_hide_dropdown_fb").click(function (e) {
        e.stopPropagation();
        $("#collapseExampleFBA").show()
    });

    $(".dont_hide_dropdown_gmb").click(function (e) {
        e.stopPropagation();
        $("#collapseExampleGMB").show()
    });

    $("#datatableSelectAllRows").change(function () {
        if ($(this).is(':checked'))
            $(".datatableCheckboxRow").prop("checked", true);
        else
            $(".datatableCheckboxRow").prop("checked", false);
    });


    var $this = $(this);
    var body = $("body");
    var navbar = $(".header-navbar");
    var currentLayout = '<?php echo $n_config['current_theme']; ?>';
    var mainMenu = $(".main-menu");
</script>


<script>
    function goBack(link, insert_or_update, add_base_url) //used to go back to list as crud
    {

        // insert_or_update does not have any effect from v6.0
        if (typeof (insert_or_update) === 'undefined') insert_or_update = 0;
        if (typeof (add_base_url) === 'undefined') add_base_url = 1;

        var mes = '';
        mes = "<?php echo $this->lang->line('Your data may not be saved.');?>";
        swal.fire({
            title: "<?php echo $this->lang->line("Do you want to go back?");?>",
            text: mes,
            icon: "warning",
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    if (add_base_url == 1)
                        link = "<?php echo site_url();?>" + link;
                    window.location.assign(link);
                }
            });
    }

    $(document).on('click', '.are_you_sure', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        var mes = '<?php echo $this->lang->line("Do you really want to delete it?");?>';
        swal.fire({
            title: "<?php echo $this->lang->line("Are you sure?");?>",
            text: mes,
            icon: "warning",
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    window.location.href = link;
                }
            });
    });

    $(document).on('click', '.are_you_sure_datatable', function (e) {
        e.preventDefault();
        var link = $(this).attr("href");
        var refresh = $(this).attr("data-refresh");
        var csrf_token = $(this).attr('csrf_token');
        if (typeof (csrf_token) === 'undefined') csrf_token = '';
        var mes = '<?php echo $this->lang->line("Do you really want to delete it?");?>';
        swal.fire({
            title: "<?php echo $this->lang->line("Are you sure?");?>",
            text: mes,
            icon: "warning",
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $(this).addClass('btn-progress btn-danger').removeClass('btn-outline-danger');
                    $.ajax({
                        context: this,
                        url: link,
                        type: 'POST',
                        dataType: 'JSON',
                        data: {csrf_token: csrf_token},
                        success: function (response) {
                            $(this).removeClass('btn-progress btn-danger').addClass('btn-outline-danger');
                            if (response.status == 1) {
                                iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                                if (refresh != '0') {
                                    if ($(this).hasClass('non_ajax')) $(this).parent().parent().hide();
                                    else $('#mytable').DataTable().ajax.reload();
                                }
                            } else iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                        }
                    });
                }
            });
    });

    $(".account_switch").click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '<?php echo site_url("social_accounts/fb_rx_account_switch");?>',
            type: 'POST',
            data: {id: id},
            success: function (response) {
                location.reload();
            }
        })

    });

    $(".gmb_account_switch").click(function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '<?php echo site_url("social_accounts/gmb_account_switch");?>',
            type: 'POST',
            data: {id: id},
            success: function (response) {
                location.reload();
            }
        })

    });


    //
    // $(document).on('click','.menu-toggle',function(e){
    //     $('.brand-logo').addClass('d-none');
    // });
    //
    // $(document).on('click','.modern-nav-toggle',function(e){
    //     $('.brand-logo').removeClass('d-none');
    // });
    $('.brand-logo').removeClass('d-none');


</script>


<script type="text/javascript">

    $(document).on('click touch', '.social_switch', function (e) {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>home/switch_to_media",
            data: {},
            success: function (response) {
                location.reload();
            }
        });
    });

    function search_in_class(obj, class_name) {
        var filter = $(obj).val().toUpperCase();
        $('.' + class_name).each(function () {
            var content = $(this).text().trim();

            if (content.toUpperCase().indexOf(filter) > -1) {
                $(this).css('display', '');
            } else $(this).css('display', 'none');
        });
    }

    function search_in_ul(obj, ul_id) {  // obj = 'this' of jquery, ul_id = id of the ul
        var filter = $(obj).val().toUpperCase();
        $('#' + ul_id + ' li').each(function () {
            var content = $(this).text().trim();

            if (content.toUpperCase().indexOf(filter) > -1) {
                $(this).css('display', '');
            } else $(this).css('display', 'none');
        });
    }

    function search_in_table(obj, ul_id) {  // obj = 'this' of jquery, ul_id = id of the ul
        var filter = $(obj).val().toUpperCase();

        $('#' + ul_id + ' tr').each(function () {
            var content = $(this).text().trim();

            if (content.toUpperCase().indexOf(filter) > -1) {
                $(this).css('display', '');
            } else $(this).css('display', 'none');
        });
    }

    function search_in_div(obj, ul_id) {  // obj = 'this' of jquery, ul_id = id of the ul
        var filter = $(obj).val().toUpperCase();
        $('#' + ul_id + ' div').each(function () {
            var content = $(this).text().trim();

            if (content.toUpperCase().indexOf(filter) > -1) {
                $(this).css('display', '');
            } else $(this).css('display', 'none');
        });
    }

    function get_current_datetime(){
        var d = new Date();
        return d.toLocaleString();
    }
</script>