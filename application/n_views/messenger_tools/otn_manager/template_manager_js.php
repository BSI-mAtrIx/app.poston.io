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

    //var drop_menu = '<?php //echo $drop_menu;?>//';
    //setTimeout(function(){
    //  $("#mytable_filter").append(drop_menu);
    //}, 1000);


    <?php if(!empty($page_info) and $page_id == 0 and $iframe == 0){ ?>
    window.location.href = base_url + 'messenger_bot/otn_template_manager/' + $('#bot_list_select').val();
    <?php } ?>

    <?php if(!empty($page_info) and $page_id != 0 and $iframe == 0){ ?>
    $('#bot_list_select').val(<?php echo $page_id; ?>);
    <?php } ?>

    $(document).on('change', '#bot_list_select', function (event) {
        window.location.href = base_url + 'messenger_bot/otn_template_manager/' + $('#bot_list_select').val();
    });

    $(document).ready(function () {
        var areWeUsingScroll = false;
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });

        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'messenger_bot/otn_template_manager_data',
                type: 'POST',
                data: function (d) {
                    d.page_id = $('#page_id').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 2, 3],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 2, 4, 5, 10],
                    sortable: false
                },
                {
                    targets: [10],
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

        var table2 = '';
        var perscroll2;

        $(document).on('click', '.get_otn_subscribers', function (event) {
            event.preventDefault();
            var get_subscriber_page_id = $(this).attr('page_table_id');
            $("#get_subscribers_page_id").val(get_subscriber_page_id);
            $("#otn_subscribers_modal").modal();

            setTimeout(function () {
                if (table2 == '') {

                    table2 = $("#mytable2").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[7, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'messenger_bot/otn_subscribers_data',
                            type: 'POST',
                            data: function (d) {
                                d.page_table_id = $('#get_subscribers_page_id').val();
                                d.postback_id = $('#postback_id').val();
                            }
                        },
                        language:
                            {
                                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: [0, 1],
                                visible: false
                            },
                            {
                                targets: '',
                                className: 'text-center'
                            },
                            {
                                targets: [0, 4, 6],
                                sortable: false
                            }
                        ],
                        fnInitComplete: function () { // when initialization is completed then apply scroll plugin
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        }
                    });

                } else {
                    table2.draw();
                }
            }, 1000);


        });

        $('#otn_subscribers_modal').on('hidden.bs.modal', function () {
            event.preventDefault();

            $("#postback_id").val('');
            table.draw();
        });


        $(document).on('click', '.delete_template', function (e) {
            e.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Delete!"); ?>',
                text: '<?php echo $this->lang->line("If you delete this template, all the token corresponding this template will also be deleted. Do you want to detete this template?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var base_url = '<?php echo site_url();?>';
                        $(this).addClass('btn-progress');
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>messenger_bot/otn_ajax_delete_template_info",
                            // dataType: 'json',
                            data: {table_id: table_id},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                if (response == 'success') {
                                    iziToast.success({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Template and all the corresponding token has been deleted successfully."); ?>',
                                        position: 'bottomRight'
                                    });
                                    table.draw();
                                } else if (response == 'no_match') {
                                    iziToast.error({
                                        title: '',
                                        message: '<?php echo $this->lang->line("No Template is found for this user with this ID."); ?>',
                                        position: 'bottomRight'
                                    });
                                } else {
                                    $("#delete_template_modal_body").html(response);
                                    $("#delete_template_modal").modal();
                                }
                            }
                        });
                    }
                });


        });


    });


</script>