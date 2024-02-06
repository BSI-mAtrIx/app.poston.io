<?php

$Doyouwanttopausethiscampaign = $this->lang->line("do you want to pause this campaign?");
$Doyouwanttostartthiscampaign = $this->lang->line("do you want to start this campaign?");
$Doyouwanttodeletethisrecordfromdatabase = $this->lang->line("do you want to delete this record from database?");
$Youdidntselectanyoption = $this->lang->line("you didn't select any option.");
$Youdidntprovideallinformation = $this->lang->line("you didn't provide all information.");
$Youdidntprovideallinformation = $this->lang->line("you didn't provide all information.");
$Doyouwanttostarthiscampaign = $this->lang->line("do you want to start this campaign?");

$edit = $this->lang->line("Edit");
$report = $this->lang->line("Report");
$deletet = $this->lang->line("Delete");
$pausecampaign = $this->lang->line("Pause Campaign");
$startcampaign = $this->lang->line("Start Campaign");

$doyoureallywanttoReprocessthiscampaign = $this->lang->line("Force Reprocessing means you are going to process this campaign again from where it ended. You should do only if you think the campaign is hung for long time and didn't send message for long time. It may happen for any server timeout issue or server going down during last attempt or any other server issue. So only click OK if you think message is not sending. Are you sure to Reprocessing ?");
$alreadyEnabled = $this->lang->line("this campaign is already enable for processing.");

?>
<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
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
    $("document").ready(function () {

        var areWeUsingScroll = false;
        //todo: areWeUsingScroll


        var base_url = "<?php echo site_url(); ?>";


        // datatable section started
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[7, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'comment_automation/all_auto_reply_report_data',
                    "type": 'POST',
                    data: function (d) {
                        d.page_id = $('#page_id').val();
                        d.campaign_name = $('#campaign_name').val();
                    }
                },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top">rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [0, 2, 5, 6, 8],
                    sortable: false
                },
                {
                    targets: [0, 2, 5, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [6],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                        data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                        data = data.replaceAll('fas fa-map', 'bx bx-map');
                        data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                        data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                        data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                        data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                        data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
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
                        data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                        data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                        data = data.replaceAll('swal(', 'swal.fire(');
                        data = data.replaceAll('rounded-circle', 'rounded-circle');
                        data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                        data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                        data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                        data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                        data = data.replaceAll('padding-10', 'p-10');
                        data = data.replaceAll('padding-left-10', 'pl-10');
                        data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                        data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                        data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                        data = data.replaceAll('fas fa-city', 'bx bxs-city');
                        data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                        data = data.replaceAll('fas fa-at', 'bx bx-at');
                        data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                        data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                        data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                        data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                        data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                        data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                        data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('208px', '308px');
                        data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");

                        return data;
                    }
                },
            ],
            fnInitComplete: function () { // when initialization is completed then apply scroll plugin
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

        $(document).on('change', '#page_id', function (event) {
            event.preventDefault();
            table.draw();
        });

        var post_id = "<?php echo $post_id; ?>";
        if (post_id != 0) $("#search_submit").click();

        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });
        // End of datatable section

        // report table started
        var table1 = '';
        var perscroll1;
        $(document).on('click', '.view_report', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');

            if (table_id != '') {
                $("#put_row_id").val(table_id);
                $("#download").attr("href", base_url + "comment_automation/download_get_reply_info/" + table_id);
            }


            $("#view_report_modal").modal();

            var commnet_hide_delete_addon = "<?php echo $commnet_hide_delete_addon; ?>";
            if (commnet_hide_delete_addon == 1)
                var visible_section = "";
            else
                var visible_section = [9];

            setTimeout(function () {
                if (table1 == '') {

                    table1 = $("#mytable1").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[3, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'comment_automation/ajax_get_reply_info',
                            type: 'POST',
                            data: function (d) {
                                d.table_id = $("#put_row_id").val();
                                d.searching = $("#searching").val();
                            }
                        },
                        language:
                            {
                                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: visible_section,
                                visible: false
                            },
                            {
                                targets: '',
                                className: 'text-center'
                            },
                            {
                                targets: [0, 1, 2, 5, 6, 7, 8, 9],
                                sortable: false
                            }
                        ],
                        fnInitComplete: function () { // when initialization is completed then apply scroll plugin
                            if (areWeUsingScroll) {
                                if (perscroll1) perscroll1.destroy();
                                perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if (areWeUsingScroll) {
                                if (perscroll1) perscroll1.destroy();
                                perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
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
                } else table1.draw();
            }, 1000);

            $("#outside_filter").html('');
            setTimeout(function () {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>comment_automation/get_count_info",
                    data: {table_id: table_id},
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status == '1')
                            $("#outside_filter").html(response.str);
                    }
                });
            }, 2000);

        });

        $(document).on('keyup', '#searching', function (event) {
            event.preventDefault();
            table1.draw();
        });


        $('#view_report_modal').on('hidden.bs.modal', function () {
            $("#download").attr("href", "");
            $("#put_row_id").val('');
            $("#searching").val("");
            table.draw();
        });
        // report table end


        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        $('#edit_auto_reply_message_modal').on('hidden.bs.modal', function () {
            table.draw();
        });

        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        var video_upload_limit = "<?php echo $video_upload_limit; ?>";

        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
        <?php for($k = 1;$k <= 20;$k++) : ?>
        $("#edit_filter_video_upload_<?php echo $k; ?>").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            fileName: "myfile",
            maxFileSize: video_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_filter_video_upload_reply_<?php echo $k; ?>").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#edit_filter_video_upload_reply_<?php echo $k; ?>").val(file_path);
            }
        });


        $("#edit_filter_image_upload_<?php echo $k; ?>").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_filter_image_upload_reply_<?php echo $k; ?>").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#edit_filter_image_upload_reply_<?php echo $k; ?>").val(data_modified);
            }
        });
        <?php endfor; ?>

        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";

        $("#edit_generic_video_upload").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            fileName: "myfile",
            maxFileSize: video_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_generic_video_comment_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#edit_generic_video_comment_reply").val(file_path);
            }
        });


        $("#edit_generic_comment_image").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_generic_image_for_comment_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#edit_generic_image_for_comment_reply").val(data_modified);
            }
        });


        $("#edit_nofilter_video_upload").uploadFile({
            url: base_url + "comment_automation/upload_live_video",
            fileName: "myfile",
            maxFileSize: video_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_nofilter_video_upload_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var file_path = base_url + "upload/video/" + data;
                $("#edit_nofilter_video_upload_reply").val(file_path);
            }
        });


        $("#edit_nofilter_image_upload").uploadFile({
            url: base_url + "comment_automation/upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_automation/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#edit_nofilter_image_upload_reply").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#edit_nofilter_image_upload_reply").val(data_modified);
            }
        });


        var edit = "<?php echo $edit; ?>";
        var report = "<?php echo $report; ?>";
        var deletet = "<?php echo $deletet; ?>";
        var pausecampaign = "<?php echo $pausecampaign; ?>";
        var startcampaign = "<?php echo $startcampaign; ?>";


        var Doyouwanttopausethiscampaign = "<?php echo $Doyouwanttopausethiscampaign; ?>";

        $(document).on('click', '.pause_campaign_info', function (e) {
            e.preventDefault();
            swal.fire({
                title: '',
                text: Doyouwanttopausethiscampaign,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('comment_automation/ajax_autoreply_pause')?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been paused successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table.draw();
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.renew_campaign', function () {
            var table_id = $(this).attr('table_id');
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/ajax_renew_campaign",
                data: {table_id: table_id},
                success: function (response) {
                    table.draw();
                }
            });
        });

        var Doyouwanttostarthiscampaign = "<?php echo $Doyouwanttostarthiscampaign; ?>";
        $(document).on('click', '.play_campaign_info', function (e) {
            e.preventDefault();
            swal.fire({
                title: '',
                text: Doyouwanttostarthiscampaign,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('comment_automation/ajax_autoreply_play')?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Campaign has been started successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table.draw();
                            }
                        });
                    }
                });

        });


        $(document).on('click', '.force', function (e) {
            e.preventDefault();
            var doyoureallywanttoReprocessthiscampaign = "<?php echo $doyoureallywanttoReprocessthiscampaign; ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: doyoureallywanttoReprocessthiscampaign,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var id = $(this).attr('id');
                        var alreadyEnabled = "<?php echo $alreadyEnabled; ?>";

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('comment_automation/force_reprocess_campaign')?>",
                            // dataType: 'json',
                            data: {id: id},
                            success: function (response) {
                                if (response == '1') {
                                    iziToast.success({
                                        title: '',
                                        message: "<?php echo $this->lang->line('Force processing has been enabled successfully.'); ?>",
                                        position: 'bottomRight'
                                    });
                                    table.draw();
                                } else
                                    iziToast.error({title: '', message: alreadyEnabled, position: 'bottomRight'});
                            }
                        });
                    }
                });

        });


        var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $Doyouwanttodeletethisrecordfromdatabase; ?>";
        $(document).on('click', '.delete_report', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: Doyouwanttodeletethisrecordfromdatabase,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('comment_automation/ajax_autoreply_delete')?>",
                            data: {table_id: table_id},
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


        $(document).on('click', '.edit_reply_info', function () {

            var emoji_load_div_list = "";
            $(".previewLoader").show();

            $("#manual_edit_reply_by_post").removeClass('modal');
            $("#edit_auto_reply_message_modal").addClass("modal");
            $("#edit_response_status").html("");


            var table_id = $(this).attr('table_id');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>comment_automation/ajax_edit_reply_info",
                data: {table_id: table_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#edit_first_dropdown").html(response.label_ids_div);
                    $("#edit_auto_reply_page_id").val(response.edit_auto_reply_page_id);

                    $("#dynamic_page_id").val(response.edit_auto_reply_page_id);

                    $("#edit_auto_reply_post_id").val(response.edit_auto_reply_post_id);
                    $("#edit_auto_campaign_name").val(response.edit_auto_campaign_name);
                    $("#edit_auto_reply_post_permalink").val(response.edit_auto_reply_post_permalink);

                    $("#edit_private_message_offensive_words").html(response.postbacks).select2({width: "100%"});
                    $("#edit_generic_message_private").html(response.postbacks).select2({width: "100%"});
                    $("#edit_ai_message_private").html(response.postbacks).select2({width: "100%"});
                    $("#edit_nofilter_word_found_text_private").html(response.postbacks);
                    for (var j = 1; j <= 20; j++) {
                        $("#edit_filter_div_" + j).hide();
                        $("#edit_filter_message_" + j).html(response.postbacks);
                    }

                    // comment hide and delete section
                    if (response.is_delete_offensive == 'hide') {
                        $("#edit_delete_offensive_comment_hide").attr('checked', 'checked');
                    } else {
                        $("#edit_delete_offensive_comment_delete").attr('checked', 'checked');
                    }
                    $("#edit_delete_offensive_comment_keyword").html(response.offensive_words);
                    $("#edit_private_message_offensive_words").val(response.private_message_offensive_words).select2({width: "100%"});
                    /**    make the emoji loads div id in a string for selection . This is the first add. **/
                    // emoji_load_div_list=emoji_load_div_list+"";

                    if (response.hide_comment_after_comment_reply == 'no')
                        $("#edit_hide_comment_after_comment_reply").removeAttr('checked', 'checked');
                    else
                        $("#edit_hide_comment_after_comment_reply").attr('checked', 'checked');
                    // comment hide and delete section


                    $("#edit_" + response.reply_type).prop('checked', true);
                    // added by mostofa on 27-04-2017
                    if (response.comment_reply_enabled == 'no')
                        $("#edit_comment_reply_enabled").removeAttr('checked', 'checked');
                    else
                        $("#edit_comment_reply_enabled").attr('checked', 'checked');

                    if (response.multiple_reply == 'no')
                        $("#edit_multiple_reply").removeAttr('checked', 'checked');
                    else
                        $("#edit_multiple_reply").attr('checked', 'checked');

                    if (response.auto_like_comment == 'no')
                        $("#edit_auto_like_comment").removeAttr('checked', 'checked');
                    else
                        $("#edit_auto_like_comment").attr('checked', 'checked');

                    var inner_content = '<i class="bx bx-time"></i> Remove';

		  	if(response.ai_reply_enabled == '1')
		  	{
		  		$("#edit_filter_message_div").hide();
		  		$("#edit_generic_message_div").hide();
		  		$("#edit_ai_training_data").val(response.ai_training_data).click();
		  		$("#edit_ai_message_div").show();
		  		$("#edit_ai_message_private").val(response.auto_reply_text).click();
		  	}
		  	else
		  	{
                    if (response.reply_type == 'generic') {
                        $("#edit_generic_message_div").show();
                        $("#edit_filter_message_div").hide();
	  		  		$("#edit_ai_message_div").hide();
                        var i = 1;
                        edit_content_counter = i;
                        var auto_reply_text_array_json = JSON.stringify(response.auto_reply_text);
                        auto_reply_text_array = JSON.parse(auto_reply_text_array_json, 'true');
                        $("#edit_generic_message").html(auto_reply_text_array[0]['comment_reply']);
                        $("#edit_generic_message_private").val(auto_reply_text_array[0]['private_reply']);

                        /** Add generic reply textarea id into the emoji load div list***/
                        if (emoji_load_div_list == '')
                            emoji_load_div_list = emoji_load_div_list + "#edit_generic_message";
                        else
                            emoji_load_div_list = emoji_load_div_list + ", #edit_generic_message";


                        // comment hide and delete section

                        $("#edit_generic_image_for_comment_reply_display").attr('src', auto_reply_text_array[0]['image_link']).show();
                        if (auto_reply_text_array[0]['image_link'] == "") {
                            $("#edit_generic_image_for_comment_reply_display").prev('span').removeClass('remove_media').html('');
                            $("#edit_generic_image_for_comment_reply_display").hide();
                        } else
                            $("#edit_generic_image_for_comment_reply_display").prev('span').addClass('remove_media').html(inner_content);


                        var vidreplace = '<source src="' + auto_reply_text_array[0]['video_link'] + '" id="edit_generic_video_comment_reply_display" type="video/mp4">';
                        $("#edit_generic_video_comment_reply_display").parent().html(vidreplace).show();

                        if (auto_reply_text_array[0]['video_link'] == '') {
                            $("#edit_generic_video_comment_reply_display").parent().prev('span').removeClass('remove_media').html('');
                            $("#edit_generic_video_comment_reply_display").parent().hide();
                        } else
                            $("#edit_generic_video_comment_reply_display").parent().prev('span').addClass('remove_media').html(inner_content);


                        $("#edit_generic_image_for_comment_reply").val(auto_reply_text_array[0]['image_link']);
                        $("#edit_generic_video_comment_reply").val(auto_reply_text_array[0]['video_link']);
                        // comment hide and delete section
                    } else {
                        var edit_nofilter_word_found_text = JSON.stringify(response.edit_nofilter_word_found_text);
                        edit_nofilter_word_found_text = JSON.parse(edit_nofilter_word_found_text, 'true');
                        $("#edit_nofilter_word_found_text").html(edit_nofilter_word_found_text[0]['comment_reply']);
                        $("#edit_nofilter_word_found_text_private").val(edit_nofilter_word_found_text[0]['private_reply']);

                        /**Add no match found textarea into emoji load div list***/
                        if (emoji_load_div_list == '')
                            emoji_load_div_list = emoji_load_div_list + "#edit_nofilter_word_found_text";
                        else
                            emoji_load_div_list = emoji_load_div_list + ", #edit_nofilter_word_found_text";


                        // comment hide and delete section

                        $("#edit_nofilter_image_upload_reply_display").attr('src', edit_nofilter_word_found_text[0]['image_link']).show();
                        if (edit_nofilter_word_found_text[0]['image_link'] == "") {
                            $("#edit_nofilter_image_upload_reply_display").prev('span').removeClass('remove_media').html('');
                            $("#edit_nofilter_image_upload_reply_display").hide();
                        } else
                            $("#edit_nofilter_image_upload_reply_display").prev('span').addClass('remove_media').html(inner_content);


                        var vidreplace = '<source src="' + edit_nofilter_word_found_text[0]['video_link'] + '" id="edit_nofilter_video_upload_reply_display" type="video/mp4">';
                        $("#edit_nofilter_video_upload_reply_display").parent().html(vidreplace).show();

                        if (edit_nofilter_word_found_text[0]['video_link'] == '') {
                            $("#edit_nofilter_video_upload_reply_display").parent().prev('span').removeClass('remove_media').html('');
                            $("#edit_nofilter_video_upload_reply_display").parent().hide();
                        } else
                            $("#edit_nofilter_video_upload_reply_display").parent().prev('span').addClass('remove_media').html(inner_content);


                        $("#edit_nofilter_image_upload_reply").val(edit_nofilter_word_found_text[0]['image_link']);
                        $("#edit_nofilter_video_upload_reply").val(edit_nofilter_word_found_text[0]['video_link']);
                        // comment hide and delete section

                        $("#edit_filter_message_div").show();
                        $("#edit_generic_message_div").hide();
	  		  		$("#edit_ai_message_div").hide();

                        var auto_reply_text_array = JSON.stringify(response.auto_reply_text);
                        auto_reply_text_array = JSON.parse(auto_reply_text_array, 'true');

                        for (var i = 0; i < auto_reply_text_array.length; i++) {
                            var j = i + 1;
                            $("#edit_filter_div_" + j).show();
                            $("#edit_filter_word_" + j).val(auto_reply_text_array[i]['filter_word']);
                            var unscape_reply_text = auto_reply_text_array[i]['reply_text'];
                            $("#edit_filter_message_" + j).val(unscape_reply_text);
                            // added by mostofa 25-04-2017
                            var unscape_comment_reply_text = auto_reply_text_array[i]['comment_reply_text'];
                            $("#edit_comment_reply_msg_" + j).html(unscape_comment_reply_text);

                            if (emoji_load_div_list == '')
                                emoji_load_div_list = emoji_load_div_list + "#edit_comment_reply_msg_" + j;
                            else
                                emoji_load_div_list = emoji_load_div_list + ", #edit_comment_reply_msg_" + j;


                            // comment hide and delete section

                            $("#edit_filter_image_upload_reply_display_" + j).attr('src', auto_reply_text_array[i]['image_link']).show();
                            if (auto_reply_text_array[i]['image_link'] == "") {
                                $("#edit_filter_image_upload_reply_display_" + j).prev('span').removeClass('remove_media').html('');
                                $("#edit_filter_image_upload_reply_display_" + j).hide();
                            } else
                                $("#edit_filter_image_upload_reply_display_" + j).prev('span').addClass('remove_media').html(inner_content);


                            var vidreplace = '<source src="' + auto_reply_text_array[i]['video_link'] + '" id="edit_filter_video_upload_reply_display' + j + '" type="video/mp4">';
                            $("#edit_filter_video_upload_reply_display" + j).parent().html(vidreplace).show();
                            if (auto_reply_text_array[i]['video_link'] == '') {
                                $("#edit_filter_video_upload_reply_display" + j).parent().prev('span').removeClass('remove_media').html('');
                                $("#edit_filter_video_upload_reply_display" + j).parent().hide();
                            } else
                                $("#edit_filter_video_upload_reply_display" + j).parent().prev('span').addClass('remove_media').html(inner_content);

                            $("#edit_filter_image_upload_reply_" + j).val(auto_reply_text_array[i]['image_link']);
                            $("#edit_filter_video_upload_reply_" + j).val(auto_reply_text_array[i]['video_link']);
                            // comment hide and delete section
                        }

                        edit_content_counter = i + 1;
                        $("#edit_content_counter").val(edit_content_counter);
                    }
		  	}

                    $("#edit_auto_reply_message_modal").modal();
                }
            });


            setTimeout(function () {

                $(emoji_load_div_list).emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>
                    autocomplete: false,
                    pickerPosition: "bottom"
                });
            }, 2000);

            setTimeout(function () {

                $(".previewLoader").hide();

            }, 5000);


        });

        $(document).on('click', '#edit_add_more_button', function () {
            if (edit_content_counter == 21)
                $("#edit_add_more_button").hide();
            $("#edit_content_counter").val(edit_content_counter);

            $("#edit_filter_div_" + edit_content_counter).show();

            /** Load Emoji For Filter Word when click on add more button during Edit**/

            $("#edit_comment_reply_msg_" + edit_content_counter).emojioneArea({
                <?php if ($rtl_on) {
                    echo "dir: 'rtl',";
                } ?>
                autocomplete: false,
                pickerPosition: "bottom"
            });

            edit_content_counter++;

        });


        $(document).on('click', '#edit_save_button', function () {
            var post_id = $("#edit_auto_reply_post_id").val();
            var edit_auto_campaign_name = $("#edit_auto_campaign_name").val();
            var reply_type = $("input[name=edit_message_type]:checked").val();

		if(reply_type == 'ai_reply') $("#edit_ai_reply_enabled").val('1');
		else $("#edit_ai_reply_enabled").val('0');

            var Youdidntselectanyoption = "<?php echo $Youdidntselectanyoption; ?>";
            var Youdidntprovideallinformation = "<?php echo $Youdidntprovideallinformation; ?>";

            if (typeof (reply_type) === 'undefined') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntselectanyoption, 'warning');
                return false;
            }
            if (reply_type == 'generic') {
                if (edit_auto_campaign_name == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntprovideallinformation, 'warning');
                    return false;
                }
            } else {
                if (edit_auto_campaign_name == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', Youdidntprovideallinformation, 'warning');
                    return false;
                }
            }

            $(this).addClass('btn-progress');

            var queryString = new FormData($("#edit_auto_reply_info_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/ajax_update_autoreply_submit",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == "1") {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                            $("#edit_auto_reply_message_modal").modal('hide');
                            table.draw();
                        });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }

            });

        });


        $(document).on('change', 'input[name=edit_message_type]', function () {
            if ($("input[name=edit_message_type]:checked").val() == "generic") {
                $("#edit_generic_message_div").show();
                $("#edit_filter_message_div").hide();
    		$("#edit_ai_message_div").hide();

                $("#edit_generic_message").emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>
                    autocomplete: false,
                    pickerPosition: "bottom"
                });

    	}
    	else if($("input[name=edit_message_type]:checked").val()=="ai_reply")
    	{
                $("#edit_generic_message_div").hide();
    		$("#edit_filter_message_div").hide();
    		$("#edit_ai_message_div").show();
    	}
    	else
    	{
    		$("#edit_generic_message_div").hide();
    		$("#edit_ai_message_div").hide();
                $("#edit_filter_message_div").show();

                /*** Load Emoji When Filter word click during Edit , by defualt first textarea are loaded & No match found field****/
                $("#edit_comment_reply_msg_1, #edit_nofilter_word_found_text").emojioneArea({
                    <?php if ($rtl_on) {
                        echo "dir: 'rtl',";
                    } ?>
                    autocomplete: false,
                    pickerPosition: "bottom"
                });


            }
        });

        $(document).on('click', '.lead_first_name', function () {

            var textAreaTxt = $(this).parent().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #LEAD_USER_FIRST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().children('.emojionearea-editor').click();

        });

        $(document).on('click', '.lead_last_name', function () {

            var textAreaTxt = $(this).parent().next().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #LEAD_USER_LAST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().next().children('.emojionearea-editor').click();


        });

        $(document).on('click', '.lead_tag_name', function () {
            var textAreaTxt = $(this).parent().next().next().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #TAG_USER# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().next().next().children('.emojionearea-editor').click();

        });


        $(document).on('click', '.cancel_button', function () {
            $("#edit_auto_reply_message_modal").modal('hide');
            table.draw();
        });

        $(document).on('click', '.remove_media', function () {
            $(this).parent().prev('input').val('');
            $(this).parent().hide();
        });

    });

</script>

<script type="text/javascript">
    $("document").ready(function () {
        var base_url = "<?php echo base_url(); ?>";

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var current_id = $(this).prev().prev().attr('id');
            var current_val = $(this).prev().prev().val();
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").attr("current_id", current_id);
            $("#add_template_modal").attr("current_val", current_val);
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $(this).prev().prev().prev().val();
            var current_id = $(this).prev().prev().prev().attr('id');
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/get_private_reply_postbacks",
                data: {page_table_ids: page_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options).val(current_val);
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var current_val = $("#add_template_modal").attr("current_val");
            var page_id = get_page_id();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "comment_automation/get_private_reply_postbacks",
                data: {page_table_ids: page_id, is_from_add_button: '1'},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response.options);
                }
            });
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = get_page_id();
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
            $(this).find('iframe').attr('src', iframe_link);
        });
        // getting postback list and making iframe

    });

    function get_page_id() {
        var page_id = $("#dynamic_page_id").val();
        return page_id;
    }
</script>