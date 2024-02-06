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

    $(document).ready(function ($) {
        var areWeUsingScroll = false;
        //TODO: areWeUsingScroll
        var base_url = '<?php echo base_url(); ?>';
        var perscroll_external_contacts_sequence_table;
        var external_contacts_sequence_table = $("#mytable_external_sequence").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'sms_email_sequence/external_sequence_lists_data',
                    "type": 'POST',
                    data: function (d) {
                        d.sequence_search = $('#sequence_search').val();
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
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: '',
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
                        data = data.replaceAll('161px', '230px');
                        data = data.replaceAll('far fa-clock', 'bx bx-time');

                        return data;
                    }
                },
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll_external_contacts_sequence_table) perscroll_external_contacts_sequence_table.destroy();
                    perscroll_external_contacts_sequence_table = new PerfectScrollbar('#mytable_external_sequence_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll_external_contacts_sequence_table) perscroll_external_contacts_sequence_table.destroy();
                    perscroll_external_contacts_sequence_table = new PerfectScrollbar('#mytable_external_sequence_wrapper .dataTables_scrollBody');
                }
            },
            "drawCallback": function (settings) {
                $('table [data-toggle="tooltip"]').tooltip('dispose');
                $('table [data-toggle="tooltip"]').tooltip(
                    {
                        placement: 'left',
                        container: 'body',
                        html: true,
                        template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    }
                );
            }
        });

        $(document).on('keyup', '#sequence_search', function (event) {
            event.preventDefault();
            external_contacts_sequence_table.draw();
        });


        $(document).on('click', '.delete_campaign', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var cam_type = $(this).attr("campaign_type");
            var somethingwentwrong = "<?php echo $this->lang->line('Something went wrong, please try once again.'); ?>";

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this campaign?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $(this).parent().prev().addClass('btn-progress');
                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('sms_email_sequence/delete_sequecne_campaign')?>",
                            data: {id: id, cam_type: cam_type},
                            success: function (response) {
                                $(this).parent().prev().removeClass('btn-progress');
                                if (response == '1') {
                                    iziToast.success({
                                        title: '',
                                        message: "<?php echo $this->lang->line('Camapign has been deleted successfully.')?>",
                                        position: 'bottomRight'
                                    });
                                    external_contacts_sequence_table.draw();
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', somethingwentwrong, 'error');
                                }


                            }
                        });
                    }
                });
        });

        $(document).on('click', '.message_content', function (e) {
            e.preventDefault();
            var campaign_id = $(this).attr('data-id'); // campaign id
            var is_day = $(this).attr('data-day');
            $('#sms_email_message_content_modal_content').html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');
            $("#sms_email_message_content_modal").modal();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>sms_email_sequence/get_campaign_report",
                data: {campaign_id: campaign_id, is_day: is_day},
                success: function (response) {
                    $('#sms_email_message_content_modal_content').html(response);
                }
            });
        });

    });
</script>