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


        $(document).on("click", ".copy", function (event) {
            event.preventDefault();

            $(this).html('<?php echo $this->lang->line("Copied!"); ?>');
            var that = $(this);

            var text = $(this).parent().parent().parent().find('code').text();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();

            setTimeout(function () {
                $(that).html('<?php echo $this->lang->line("Copy"); ?>');
            }, 2000);

        });


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
                    "url": base_url + 'vidcasterlive/live_scheduler_list_data',
                    "type": 'POST',
                    data: function (d) {
                        d.post_type = $('#post_type').val();
                        d.searching = $('#searching').val();
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
                    targets: [0, 1, 3, 5, 6, 7, 8, 9, 10],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 2, 4, 5, 6, 10],
                    sortable: false
                },
                {
                    targets: [6, 10],
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
                        data = data.replaceAll('fa fa-bug', 'bx bx-bug');
                        data = data.replaceAll('302px', '400px');


                        return data;
                    }
                },
            ],
            // fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
            //   if(areWeUsingScroll)
            //   {
            //     if (perscroll) perscroll.destroy();
            //     perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
            //   }
            // },
            // scrollX: 'auto',
            // fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
            //   if(areWeUsingScroll)
            //   {
            //     if (perscroll) perscroll.destroy();
            //     perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
            //   }
            // }
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


        $(document).on('change', '#post_type', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('change', '#post_date_range_val', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });
        // End of datatable section


        $('#embed_code_modal').on('hidden.bs.modal', function () {
            table.draw();
        });
        // End of reply table

        $(document.body).on('click', '.ffmpeg_log', function () {
            var id = $(this).attr("id");
            var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>';
            $("#ffmpeg_log_content").html(loading);
            $("#ffmpeg_log_modal").modal();

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('vidcasterlive/get_ffmpeg_log')?>",
                data: {id: id},
                success: function (response) {
                    $("#ffmpeg_log_content").html(response);
                }
            });
        });


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
                            url: "<?php echo base_url('vidcasterlive/delete_post')?>",
                            data: {id: id},
                            success: function (response) {
                                if (response == '1')
                                    iziToast.success({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Campaign has been deleted successfully."); ?>',
                                        position: 'bottomRight'
                                    });
                                else
                                    iziToast.error({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Something went wrong, please try again later."); ?>',
                                        position: 'bottomRight'
                                    });
                                table.draw();
                            }
                        });
                    }
                });

        });


        $(document).on('click', '.embed_code', function () {
            var id = $(this).attr("id");
            var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>';
            $("#embed_code_content").html(loading);
            $("#embed_code_modal").modal();

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('vidcasterlive/get_embed_code')?>",
                data: {id: id},
                success: function (response) {

                    response = response.replaceAll('h2', 'h4');
                    $("#embed_code_content").html(response);
                    Prism.highlightElement($('#test')[0]);
                    $(".toolbar-item").find('a').addClass('copy');
                }
            });
        });

        $(document).on('click', '.stream_info', function () {
            var id = $(this).attr("id");
            var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>';
            $("#stream_info_loading").html(loading);
            $("#stream_info_content").hide();
            $("#stream_info_modal").modal();

            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('vidcasterlive/get_stream_info')?>",
                data: {id: id},
                dataType: 'JSON',
                success: function (response) {
                    $("#stream_info_loading").hide();
                    $("#stream_info_content").show();

                    $("#server_url").text(response.server_url);
                    $("#stream_key").text(response.stream_key);
                    $("#stream_url").text(response.stream_url);

                    Prism.highlightElement($('#server_url')[0]);
                    Prism.highlightElement($('#stream_key')[0]);
                    Prism.highlightElement($('#stream_url')[0]);

                    $(".toolbar-item").find('a').addClass('copy');
                }
            });
        });


    });
</script>
