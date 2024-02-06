<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {
        var areWeUsingScroll = false;
        //todo: areWeUsingScroll
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });

        <?php if($page_id == 0 and $iframe == 0){ ?>
        window.location.href = base_url + 'custom_field_manager/custom_field_list/' + $('#bot_list_select').val() + '/0/' + '<?php echo $media_type; ?>';
        <?php } ?>

        <?php if($page_id != 0 and $iframe == 0){ ?>
        $('#bot_list_select').val(<?php echo $page_id; ?>);
        <?php } ?>

        $(document).on('change', '#bot_list_select', function (event) {
            window.location.href = base_url + 'custom_field_manager/custom_field_list/' + $('#bot_list_select').val() + '/0/' + '<?php echo $media_type; ?>';
        });


        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'custom_field_manager/custom_field_list_data',
                "type": 'POST',
                data: function (d) {
                    d.media_type = $('#media_type').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [3, 4, 5],
                    className: 'text-center'
                },
                {
                    targets: [0, 2, 3, 4, 5],
                    sortable: false
                },
                {
                    targets: [5],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-code', 'bx bx-code');
                        data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                        data = data.replaceAll('far fa-copy', 'bx bx-copy');
                        data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                        data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                        data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                        data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                        data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                        data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                        data = data.replaceAll('fa fa-user', 'bx bx-user');
                        data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                        data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                        data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                        data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                        data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                        data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                        data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                        data = data.replaceAll('fas fa-key', 'bx bx-key');
                        data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                        data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                        data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                        data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                        data = data.replaceAll('fa fa-send', 'bx bx-send');
                        data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                        data = data.replaceAll('fa fa-code', 'bx bx-code');
                        data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');

                        return data;
                    }
                },
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            }
        });


        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });
        // end of datatable

        $(document).on('click', '.add_custom_field', function (event) {
            event.preventDefault();
            $("#name_err").text("");
            $("#reply_type_err").text("");
            $("#custom_field_name").val("");
            $("#selected_reply_type").val("").change();
            $("#add_custom_field").modal();
        });

        // create new label
        $(document).on('click', '#create_custom_field', function (event) {
            event.preventDefault();

            $("#name_err").text("");
            $("#reply_type_err").text("");

            custom_field_name = $("#custom_field_name").val();
            selected_reply_type = $("#selected_reply_type").val();
            var media_type = "<?php echo $media_type; ?>";

            if (custom_field_name == '') {
                $("#name_err").text("<?php echo $this->lang->line('Name Is Required') ?>")
                return false;
            }
            if (selected_reply_type == '') {
                $("#reply_type_err").text("<?php echo $this->lang->line('Reply Type Is Required') ?>")
                return false;
            }

            $(this).addClass('btn-progress');
            var that = $(this);

            $.ajax({
                url: '<?php echo base_url('custom_field_manager/ajax_custom_field_insert'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    custom_field_name: custom_field_name,
                    selected_reply_type: selected_reply_type,
                    media_type: media_type
                },
                success: function (response) {
                    $("#result_status").html('');
                    $("#result_status").css({"background": "", "padding": "", "margin": ""});

                    if (response.status == "0") {
                        var errorMessage = JSON.stringify(response, null, 10);
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', errorMessage, "error");
                        $("#result_status").css({"background": "#EEE", "margin": "10px"});

                    } else if (response.status == '1') {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                    }

                    table.draw();
                    $(that).removeClass('btn-progress');
                }
            });


        });

        $(document).on('keyup', '#custom_field_name', function (event) {
            event.preventDefault();
            $("#name_err").text("");
        });

        $(document).on('change', '#selected_reply_type', function (event) {
            event.preventDefault();
            $("#reply_type_err").text("");
        });


        // delete label
        $(document).on('click', '.delete_custom_field', function (event) {
            event.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Custom Field"); ?>',
                text: '<?php echo $this->lang->line("Do you want to delete this custom field?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isDenied || willDelete.isDismissed) {
                        return;
                    }
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr("table_id");
                        var media_type = $(this).attr("media_type");
                        var csrf_token = $("#csrf_token").val();

                        $(this).addClass('btn-danger btn-progress').removeClass('btn-outline-danger');
                        var that = $(this);

                        $.ajax({
                            url: '<?php echo base_url('custom_field_manager/ajax_delete_custom_field'); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {table_id: table_id, csrf_token: csrf_token, media_type: media_type},
                            success: function (response) {
                                if (response.status == 'successfull') {
                                    iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                                } else {
                                    swal.fire("<?php echo $this->lang->line('Error') ?>", response.message, "error");
                                }

                                table.draw();
                                $(that).removeClass('btn-danger btn-progress').addClass('btn-outline-danger');
                            }
                        });
                    }
                });

        });

        $('#add_custom_field').on('hidden.bs.modal', function () {
            $("#name_err").text("");
            $("#reply_type_err").text("");
            $("#custom_field_name").val("");
            $("#selected_reply_type").val("").change();
            table.draw();
        })

    });


</script>