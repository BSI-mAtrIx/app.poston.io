<?php
$somethingwentwrong = $this->lang->line("Something went wrong.");
$Doyouwanttopausethiscampaign = $this->lang->line("Do you want to pause this campaign? Pause campaign may not stop the campaign immediately if it is currently processing by cron job. This will affect from next cron job run after it finish currently processing messages.");
$whenitpause = $this->lang->line("This will affect from next cron job run after it finish currently processing messages.");
$Doyouwanttostartthiscampaign = $this->lang->line("Do you want to resume this campaign?");
$doyoureallywanttodeletethiscampaign = $this->lang->line("Do you really want to delete this campaign?");
$alreadyEnabled = $this->lang->line("This campaign is already enabled for processing.");
$doyoureallywanttoReprocessthiscampaign = $this->lang->line("Force Reprocessing means you are going to process this campaign again from where it ended. You should do only if you think the campaign is hung for long time and didn't send message for long time. It may happen for any server timeout issue or server going down during last attempt or any other server issue. So only click OK if you think message is not sending. Are you sure to Reprocessing ?");
$wanttounsubscribe = $this->lang->line("Do you really want to unsubscribe this user?");

?>
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

    var somethingwentwrong = "<?php echo $somethingwentwrong; ?>";
    var Doyouwanttopausethiscampaign = "<?php echo $Doyouwanttopausethiscampaign; ?>";
    var whenitpause = "<?php echo $whenitpause; ?>";
    var Doyouwanttostartthiscampaign = "<?php echo $Doyouwanttostartthiscampaign; ?>";
    var doyoureallywanttodeletethiscampaign = "<?php echo $doyoureallywanttodeletethiscampaign; ?>";
    var alreadyEnabled = "<?php echo $alreadyEnabled; ?>";
    var doyoureallywanttoReprocessthiscampaign = "<?php echo $doyoureallywanttoReprocessthiscampaign; ?>";
    var wanttounsubscribe = "<?php echo $wanttounsubscribe; ?>";

    $('#campaign_date_range').daterangepicker({
        locale: daterange_locale,
        ranges: {
            '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
            '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
            '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        $('#campaign_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
    });

    var perscroll;
    var table1 = '';
    table1 = $("#mytable").DataTable({
        serverSide: true,
        processing: true,
        bFilter: false,
        order: [[12, "desc"]],
        pageLength: 10,
        ajax: {
            url: base_url + 'messenger_bot_enhancers/subscriber_broadcast_campaign_data',
            type: 'POST',
            data: function (d) {
                d.search_page_id = $('#search_page_id').val();
                d.search_value = $('#search_value').val();
                d.search_status = $('#search_status').val();
                d.campaign_date_range = $('#campaign_date_range_val').val();
                d.csrf_token = $("#csrf_token").val();
            }
        },
        language:
            {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        columnDefs: [
            {
                targets: [1, 10],
                visible: false
            },
            {
                targets: [4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                className: 'text-center'
            },
            {
                targets: [0, 6, 8],
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
                    data = data.replaceAll('208px', '350px');
                    data = data.replaceAll('fas fa-sync', 'bx bx-sync');

                    return data;
                }
            },
        ],
        fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
            // if(areWeUsingScroll)
            // {
            //   if (perscroll) perscroll.destroy();
            //   perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
            // }
        },
        scrollX: 'auto',
        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
            // if(areWeUsingScroll)
            // {
            //   if (perscroll) perscroll.destroy();
            //   perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
            // }
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


    $("document").ready(function () {

        $(document).on('change', '#search_page_id', function (e) {
            table1.draw();
        });

        $(document).on('change', '#search_status', function (e) {
            table1.draw();
        });

        $(document).on('change', '#campaign_date_range_val', function (event) {
            event.preventDefault();
            table1.draw();
        });

        $(document).on('click', '#search_action', function (event) {
            event.preventDefault();
            table1.draw();
        });

        var table2 = '';
        $(document).on('click', '.sent_report', function (e) {

            e.preventDefault();

            var id = $(this).attr('cam-id');
            var csrf_token = $("#csrf_token").val();

            $('#hidden_cam_id').val(id);

            $("#sent_report_modal").modal();

            $("#sent_report_body").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size: 50px"></i></div><br/>');
            setTimeout(function () {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>messenger_bot_enhancers/campaign_sent_status",
                    data: {id: id, csrf_token: csrf_token},
                    dataType: 'JSON',
                    success: function (response) {
                        $("#sent_report_body").html(response.response1);

                        if (table2 == '') {
                            setTimeout(function () {
                                $("#mytable2_filter").append(response.response3);
                                $("[data-toggle=\'tooltip\']").tooltip();
                            }, 1000);

                            var perscroll2;
                            table2 = $("#mytable2").DataTable({
                                serverSide: true,
                                processing: true,
                                bFilter: true,
                                order: [[3, "desc"]],
                                pageLength: 10,
                                ajax: {
                                    url: '<?php echo base_url("messenger_bot_enhancers/campaign_sent_status_data"); ?>',
                                    type: 'POST',
                                    dataSrc: function (json) {
                                        //$(".table-responsive").niceScroll();
                                        return json.data;
                                    },
                                    data: function (d) {
                                        d.campaign_id = $('#hidden_cam_id').val();
                                        d.csrf_token = $("#csrf_token").val();
                                    }
                                },
                                language:
                                    {
                                        url: '<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json');?>'
                                    },
                                dom: '<"top"f>rt<"bottom"lip><"clear">',
                                columnDefs: [
                                    {
                                        targets: [1, 7],
                                        visible: false
                                    },
                                    {
                                        targets: [0, 4, 5, 6, 7, 8],
                                        className: 'text-center'
                                    }
                                ],
                                fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
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
                        } else table2.draw();
                    }
                });


            }, 1000);


        });

    });


    $(document).on('click', '.restart_button', function (e) {
        e.preventDefault();
        var table_id = $(this).attr('table_id');
        var csrf_token = $("#csrf_token").val();

        swal.fire({
            title: '<?php echo $this->lang->line("Force Resume"); ?>',
            text: Doyouwanttostartthiscampaign,
            icon: 'warning',
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('messenger_bot_enhancers/restart_campaign')?>",
                        data: {table_id: table_id, csrf_token: csrf_token},
                        success: function (response) {
                            $(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');
                            if (response == '1') {
                                $("#sent_report_modal").modal('hide');
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been resumed by force successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table1.draw();
                            } else iziToast.error({title: '', message: somethingwentwrong, position: 'bottomRight'});
                        }
                    });
                }
            });

    });

    $(document).on('click', '.force', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var csrf_token = $("#csrf_token").val();
        var alreadyEnabled = "<?php echo $alreadyEnabled; ?>";
        var doyoureallywanttoReprocessthiscampaign = "<?php echo $doyoureallywanttoReprocessthiscampaign; ?>";

        swal.fire({
            title: '<?php echo $this->lang->line("Force Re-process Campaign"); ?>',
            text: doyoureallywanttoReprocessthiscampaign,
            icon: 'warning',
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('messenger_bot_enhancers/force_reprocess_campaign')?>",
                        data: {id: id, csrf_token: csrf_token},
                        success: function (response) {
                            $(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

                            if (response == '1') {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been re-processed by force successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table1.draw();
                            } else iziToast.error({title: '', message: alreadyEnabled, position: 'bottomRight'});
                        }
                    });
                }
            });

    });

    $(document).on('click', '.pause_campaign_info', function (e) {
        e.preventDefault();
        var table_id = $(this).attr('table_id');
        var csrf_token = $("#csrf_token").val();

        swal.fire({
            title: '<?php echo $this->lang->line("Pause Campaign"); ?>',
            text: Doyouwanttopausethiscampaign,
            icon: 'warning',
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('messenger_bot_enhancers/ajax_campaign_pause')?>",
                        data: {table_id: table_id, csrf_token: csrf_token},
                        success: function (response) {
                            $(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

                            if (response == '1') {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been paused successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table1.draw();
                            } else iziToast.error({title: '', message: somethingwentwrong, position: 'bottomRight'});
                        }
                    });
                }
            });

    });

    $(document).on('click', '.play_campaign_info', function (e) {
        e.preventDefault();
        var table_id = $(this).attr('table_id');
        var csrf_token = $("#csrf_token").val();

        swal.fire({
            title: '<?php echo $this->lang->line("Resume Campaign"); ?>',
            text: Doyouwanttostartthiscampaign,
            icon: 'warning',
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('messenger_bot_enhancers/ajax_campaign_play')?>",
                        data: {table_id: table_id, csrf_token: csrf_token},
                        success: function (response) {
                            $(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

                            if (response == '1') {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been resumed successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table1.draw();
                            } else iziToast.error({title: '', message: somethingwentwrong, position: 'bottomRight'});
                        }
                    });
                }
            });

    });


    $(document).on('click', '.delete', function (e) {
        e.preventDefault();

        var id = $(this).attr('id');
        var csrf_token = $("#csrf_token").val();
        if (typeof (id) === 'undefined') {
            swal.fire('', '<?php echo $this->lang->line("This campaign is in processing state and can not be deleted.");?>', 'warning');
            return;
        }

        swal.fire({
            title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
            text: doyoureallywanttodeletethiscampaign,
            icon: 'warning',
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo base_url('messenger_bot_enhancers/subscriber_delete_campaign')?>",
                        data: {id: id, csrf_token: csrf_token},
                        success: function (response) {
                            $(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

                            if (response == '1') {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been deleted successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table1.draw();
                            } else iziToast.error({title: '', message: somethingwentwrong, position: 'bottomRight'});
                        }
                    });
                }
            });

    });


</script>
