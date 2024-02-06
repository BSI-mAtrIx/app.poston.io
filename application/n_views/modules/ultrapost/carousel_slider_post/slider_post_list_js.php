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

        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%',
        });

        // $('.datepicker').datetimepicker({
        //     theme:'light',
        //     format:'Y-m-d',
        //     formatDate:'Y-m-d',
        //     timepicker:false
        // });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        var base_url = '<?php echo base_url(); ?>';

        setTimeout(function () {
            $('#post_date_range').daterangepicker({
                locale: daterange_locale,
                ranges: {
                    '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
                    '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
                    '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function (start, end) {
                $('#post_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
            });
        }, 2000);

        // datatable section started
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'ultrapost/carousel_slider_post_list_data',
                    "type": 'POST',
                    data: function (d) {
                        d.page_id = $('#page_id').val();
                        d.campaign_name = $('#campaign_name').val();
                        d.post_date_range = $('#post_date_range_val').val();
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
                    targets: [3, 5, 6, 7, 8],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 3, 6, 7, 9],
                    sortable: false
                },
                {
                    targets: [6],
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
                        data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                        data = data.replaceAll('fas fa-play', 'bx bx-play');

                        return data;
                    }
                },
            ],
            // fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
            // if(areWeUsingScroll)
            // {
            //     if (perscroll) perscroll.destroy();
            //       perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
            // }
            // },
            // scrollX: 'auto',
            // fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
            //   if(areWeUsingScroll)
            //   {
            //     if (perscroll) perscroll.destroy();
            //     perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
            //   }
            // }
        });

        $(document.body).on('change', '#page_id', function (event) {
            event.preventDefault();
            table.draw();
        });


        $(document.body).on('change', '#post_date_range_val', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document.body).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });
        // End of datatable section


        // report table started
        var table1 = '';
        $(document).on('click', '.view_report', function (e) {
            e.preventDefault();
            var perscroll1;
            var table_id = $(this).attr('table_id');

            $("#put_row_id").val(table_id);

            $("#view_report_modal").modal();

            if (table1 == '') {
                table1 = $("#mytable1").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: false,
                    order: [[1, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'ultrapost/ajax_carousel_slide_report',
                        type: 'POST',
                        data: function (d) {
                            d.table_id = $("#put_row_id").val();
                            d.searching1 = $("#searching1").val();
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
                            targets: [0, 1, 3, 4, 5, 6],
                            className: 'text-center'
                        },
                        {
                            targets: [0, 1, 2, 3, 4, 7],
                            sortable: false
                        }
                    ],
                    // fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
                    //   if(areWeUsingScroll)
                    //   {
                    //     if (perscroll1) perscroll1.destroy();
                    //     perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
                    //   }
                    // },
                    // scrollX: 'auto',
                    // fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                    //   if(areWeUsingScroll)
                    //   {
                    //     if (perscroll1) perscroll1.destroy();
                    //     perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
                    //   }
                    // }
                });
            } else table1.draw();
        });

        $(document).on('keyup', '#searching1', function (event) {
            event.preventDefault();
            table1.draw();
        });

        $('#view_report_modal').on('hidden.bs.modal', function () {
            $("#put_row_id").val('');
            $("#searching1").val("");
            table.draw();
        });
        $('#embed_code_modal').on('hidden.bs.modal', function () {
            table.draw();
        });
        // End of reply table


        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: "<?php echo $this->lang->line('Do you really want to delete this post from the database?'); ?>",
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var id = $(this).attr('id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('ultrapost/carousel_slider_delete_post')?>",
                            data: {id: id},
                            success: function (response) {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been deleted successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table.draw();
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.delete_p', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: "<?php echo $this->lang->line('This is main campaign, if you want to delete it, rest of the sub campaign will be deleted. Do you really want to delete this post from the database?'); ?>",
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var id = $(this).attr('id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('ultrapost/carousel_slider_delete_post')?>",
                            data: {id: id},
                            success: function (response) {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been deleted successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table.draw();
                            }
                        });
                    }
                });

        });


        $(document.body).on('click', '.embed_code', function () {

            var id = $(this).attr("id");
            var loading = '<img src="<?php echo base_url('assets/pre-loader/Fading squares2.gif');?>" class="center-block">';
            $("#embed_code_content").html(loading);
            $("#embed_code_modal").modal();

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('ultrapost/carousel_slider_get_embed_code')?>",
                data: {id: id},
                success: function (response) {
                    $("#embed_code_content").html(response);
                }
            });
        });


        // only pending campaign
        $(document).on('click', '.not_see_report', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Only parent campaign has shown report.'); ?>", "error");
        });

        $(document).on('click', '.not_published', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, this post is not published yet.'); ?>", 'error');
        });

        $(document).on('click', '.not_editable', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Only Pending Campaigns Are Editable.'); ?>", 'error');
        });

        $(document).on('click', '.not_delete_campaign', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Processing Campaign Can not be deleted.'); ?>", 'error');
        });

        $(document).on('click', '.not_embed_code', function (event) {
            event.preventDefault();
            swal.fire("", "<?php echo $this->lang->line('Sorry, Embed code is only available for published video posts.'); ?>", 'error');
        });

    });
</script>
