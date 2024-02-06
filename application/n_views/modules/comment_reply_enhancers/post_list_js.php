<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
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
<link rel="stylesheet" href="<?php echo base_url(); ?>plugins/multiselect_tokenize/jquery.tokenize.css"
      type="text/css"/>
<script src="<?php echo base_url(); ?>plugins/multiselect_tokenize/jquery.tokenize.js" type="text/javascript"></script>


<script>
    var base_url = "<?php echo site_url(); ?>";
    var somethingwentwrong = "<?php echo $somethingwentwrong;?>";
    var pleasewait = "<?php echo $pleasewait;?>";
    var startcommenternames = "<?php echo $startcommenternames;?>";
    var item_per_range = "<?php echo $item_per_range;?>";
    var list_of_commenters = "<?php echo $list_of_commenters;?>";
    var campaign_name_is_required = "<?php echo $campaign_name_is_required;?>";
    var tag_content_is_required = "<?php echo $tag_content_is_required;?>";
    var you_have_not_selected_commenters = "<?php echo $you_have_not_selected_commenters;?>";
    var no_subscribed_commenter_found = "<?php echo $no_subscribed_commenter_found;?>";
    var reply_content_is_required = "<?php echo $reply_content_is_required;?>";

    var image_upload_limit = "<?php echo $image_upload_limit; ?>";
    var video_upload_limit = "<?php echo $video_upload_limit; ?>";

    $("document").ready(function () {

        var areWeUsingScroll = false;
        // $(document).ready(function() {
        //     'use strict';
        //
        //     $(".select2").select2({
        //         dropdownAutoWidth: true,
        //         width: '100%',
        //
        //     });
        // });

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        $(".schedule_block_item").hide();
        $(".schedule_block_item2").hide();

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
                    "url": base_url + 'comment_reply_enhancers/post_list_data',
                    "type": 'POST',
                    data: function (d) {
                        d.page_id = $('#page_id').val();
                        d.post_id = $('#post_id').val();
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
                    targets: [2],
                    "render": function (data, type, row) {
                        data = data.replaceAll('<img ', '<img onerror="this.onerror=null;" ');
                        data = data.replaceAll('null;', "null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>'");
                        return data;
                    }
                },
                {
                    targets: [2, 4, 5, 6, 7, 8, 9, 10, 11],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 2, 4, 5, 6, 7],
                    sortable: false
                },
                {
                    targets: [5, 6, 7, 8, 9],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-code', 'bx bx-code');
                        data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                        data = data.replaceAll('far fa-copy', 'bx bx-copy');
                        data = data.replaceAll('fa fa-trash', 'bx bx-trash');
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

                        return data;
                    },
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

        $(document).on('change', '#post_date_range_val', function (event) {
            event.preventDefault();
            table.draw();
        });

        var post_id = "<?php echo $post_id; ?>";
        if (post_id != 0) $("#search_submit").click();

        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });


        var table2 = '';
        $(document).on('click', '.show_comment_list', function (e) {
            e.preventDefault();
            var base_url = "<?php echo base_url(); ?>";
            var table_id = $(this).attr('table_id');
            var page_id = $(this).attr('page_id');
            var page_name = $(this).attr('page_name');
            var post_id = $(this).attr('post_id');
            var page_post_link = '<a class="orange" target="_BLANK" href="https://facebook.com/' + page_id + '"><i class="bx bx-news-o"></i> ' + page_name + '</a> <a target="_BLANK" href="https://facebook.com/' + post_id + '"> (Visit Post)</a>';
            var download_button = "<?php echo $this->lang->line("Download comment list info"); ?>";
            var drop_menu = "<a href='" + base_url + "comment_reply_enhancers/download_comment_list_info/" + table_id + "' class='float-right' target='_blank' ><button class='btn btm-lg btn-outline-info download_comment_list_info'><i class='bx bx-cloud-download'></i> " + download_button + "</button></a>";

            $("#put_comment_table_id").val(table_id);
            $(".page_post_link").html(page_post_link);
            $("#comment_list_modal").modal();


            if (table2 == '') {
                setTimeout(function () {
                    $("#mytable2_filter").append(drop_menu);
                }, 2000);

                var perscroll2;
                table2 = $("#mytable2").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: true,
                    order: [[3, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'comment_reply_enhancers/post_comment_list',
                        type: 'POST',
                        data: function (d) {
                            d.table_id = $("#put_comment_table_id").val();
                            // d.commenter_searching = $("#commenter_searching").val();
                        }
                    },
                    language:
                        {
                            url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                        },
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    columnDefs: [
                        {
                            targets: '',
                            className: 'text-center'
                        },
                        {
                            targets: [0, 2, 4],
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
            } else table2.draw();

        });


        var table1 = '';
        $(document).on('click', '.show_commenter_list', function (e) {
            e.preventDefault();
            var base_url = "<?php echo base_url(); ?>";
            var table_id = $(this).attr('table_id');
            var page_id = $(this).attr('page_id');
            var page_name = $(this).attr('page_name');
            var post_id = $(this).attr('post_id');
            var page_post_link = '<a class="orange" target="_BLANK" href="https://facebook.com/' + page_id + '"><i class="bx bx-news-o"></i> ' + page_name + '</a> <a target="_BLANK" href="https://facebook.com/' + post_id + '"> (Visit Post)</a>';
            var download_button = "<?php echo $this->lang->line("Download commenter list info"); ?>";
            var drop_menu = "<a href='" + base_url + "comment_reply_enhancers/download_commenter_list_info/" + table_id + "' class='float-right' target='_blank' ><button class='btn btm-lg btn-outline-info download_comment_list_info'><i class='bx bx-cloud-download'></i> " + download_button + "</button></a>";

            $("#put_table_id").val(table_id);
            $(".page_post_link").html(page_post_link);
            $("#commenter_list_modal").modal();


            if (table1 == '') {
                setTimeout(function () {
                    $("#mytable1_filter").append(drop_menu);
                }, 2000);

                var perscroll1;
                table1 = $("#mytable1").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: true,
                    order: [[3, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'comment_reply_enhancers/post_commenter_list',
                        type: 'POST',
                        data: function (d) {
                            d.table_id = $("#put_table_id").val();
                            // d.commenter_searching = $("#commenter_searching").val();
                        }
                    },
                    language:
                        {
                            url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                        },
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    columnDefs: [
                        {
                            targets: '',
                            className: 'text-center'
                        },
                        {
                            targets: [0, 2, 4],
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
                    }
                });
            } else table1.draw();

        });

        // End of datatable section


        $(document).on('change', 'input[name=schedule_type]', function () {
            var scheduletype = $("input[name=schedule_type]:checked").val();

            if (typeof (scheduletype) == "undefined")
                $(".schedule_block_item").show();
            else {
                $("#schedule_time").val("");
                $("#time_zone").val("");
                $(".schedule_block_item").hide();
            }
        });

        $(document).on('change', 'input[name=schedule_type2]', function () {
            var scheduletype2 = $("input[name=schedule_type2]:checked").val();
            if (typeof (scheduletype2) == "undefined")
                $(".schedule_block_item2").show();
            else {
                $("#schedule_time2").val("");
                $("#time_zone2").val("");
                $(".schedule_block_item2").hide();
            }
        });


        var areyousureyouwanttorescan = '<?php echo $areyousureyouwanttorescan; ?>';
        $(document).on('click', '.rescan_comments', function (e) {
            e.preventDefault();
            swal.fire({
                title: '',
                text: areyousureyouwanttorescan,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
                context: this,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var page_id = $(this).attr("page-id");
                        var post_id = $(this).attr("post-id");
                        var enable_id = $(this).attr("enable-id");
                        var btn_id = "rescan_" + page_id + "_" + post_id;
                        $("#" + btn_id).addClass('btn-primary btn-progress').removeClass('btn-outline-primary');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('comment_reply_enhancers/rescan_commenter_info')?>",
                            data: {page_id: page_id, post_id: post_id, enable_id: enable_id},
                            success: function (response) {
                                $(this).removeClass('btn-primary btn-progress').addClass('btn-outline-primary');
                                iziToast.success({
                                    title: '',
                                    message: '<?php echo $this->lang->line("Post Comments Has been Updated Successfully."); ?>',
                                    position: 'bottomRight'
                                });
                                table.draw();
                            }
                        });
                    }
                });

        });

        $(document).on('click', '.commenter_subscribe_unsubscribe', function () {
            $(this).html(pleasewait).addClass('disabled');
            var subscribe_unsubscribe_status = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>comment_reply_enhancers/subscribe_unsubscribe_status_change",
                data: {subscribe_unsubscribe_status: subscribe_unsubscribe_status},
                success: function (response) {
                    $("#" + subscribe_unsubscribe_status).parent().html(response);
                }
            });
        });

        $(document).on('click', '.create_bulk_tag_campaign', function () {
            event.preventDefault();

            $("#comment_bulk_tag_campaign").modal();
            var post_val = $(this).attr("id");
            var exploded = [];
            exploded = post_val.split('-');
            var tag_machine_enabled_post_list_id = exploded[1];
            var tag_campaign_tag_machine_commenter_count = exploded[2];
            $("#tag_campaign_tag_machine_enabled_post_list_id").val(tag_machine_enabled_post_list_id);
            $("#tag_campaign_tag_machine_commenter_count").val(tag_campaign_tag_machine_commenter_count);

            // $('.include_autocomplete').tokenize({
            //      datas: base_url+"comment_reply_enhancers/commenter_autocomplete/"+tag_machine_enabled_post_list_id,
            //      placeholder: list_of_commenters,
            //      dropdownMaxItems: 20,
            //      tokensMaxItems: item_per_range
            //  });

            // make the schedule time field empty as it's filled with current date at initial stage
            var makeScheduleValEmptyifscheduleisNow = $("input[name=schedule_type]:checked").val();
            if (makeScheduleValEmptyifscheduleisNow == 'now') $("#schedule_time").val("");

            $('.exclude_autocomplete').tokenize({
                datas: base_url + "comment_reply_enhancers/commenter_autocomplete/" + tag_machine_enabled_post_list_id,
                placeholder: startcommenternames,
                dropdownMaxItems: 20,
                tokensMaxItems: item_per_range
            });

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>comment_reply_enhancers/commenter_range_option",
                data: {tag_machine_enabled_post_list_id: tag_machine_enabled_post_list_id},
                success: function (response) {
                    $("#commenter_range").html(response);
                }
            });
            $("#loading_div").hide();

        });


        $("#image_video_upload").uploadFile({
            url: base_url + "comment_reply_enhancers/upload_image_video",
            fileName: "myfile",
            maxFileSize: video_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF,.flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_reply_enhancers/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#uploaded_image_video").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                // var data_modified = base_url+"upload/comment_reply_enhancers/"+data;
                $("#uploaded_image_video").val(data);
            }
        });

        $("#image_video_upload2").uploadFile({
            url: base_url + "comment_reply_enhancers/upload_image_video",
            fileName: "myfile",
            maxFileSize: video_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg,.JPEG,.JPG,.PNG,.gif,.GIF,.flv,.mp4,.wmv,.WMV,.MP4,.FLV",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('comment_reply_enhancers/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#uploaded_image_video2").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                // var data_modified = base_url+"upload/comment_reply_enhancers/"+data;
                $("#uploaded_image_video2").val(data);
            }
        });


        $(document).on('click', '#submit_post', function () {

            var campaign_name = $("#campaign_name").val();
            var message = $("#message").val();
            var commenter_range = $("#commenter_range").val();

            if (campaign_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Campaign name is required.');?>", 'warning');
                return;
            }

            if (message == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Tag content is required.');?>", 'warning');
                return;
            }

            if (commenter_range == "" || commenter_range == null || typeof (commenter_range) == "undefined") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('You have not selected commenters.');?>", 'warning');
                return;
            }

            var schedule_type = $("input[name=schedule_type]:checked").val();
            var schedule_time = $("#schedule_time").val();
            var time_zone = $("#time_zone").val();
            var pleaseselectscheduletimetimezone = "<?php echo $pleaseselectscheduletimetimezone; ?>";
            if (typeof (schedule_type) == 'undefined' && (schedule_time == "" || time_zone == "")) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select schedule time/time zone.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var queryString = new FormData($("#bulk_tag_campaign_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "comment_reply_enhancers/create_bulk_tag_campaign_action",
                data: queryString,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == '1') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Campagin has been created successfully."); ?>',
                            html: span,
                            icon: 'success'
                        });
                    } else {
                        var span = document.createElement("span");
                        span.innerHTML = '';
                        swal.fire({title: response.message, html: span, icon: 'error'});
                    }
                }
            });

        });


        $(document).on('click', '.bulk_comment_reply_campaign', function () {
            $("#bulk_comment_reply_campaign").modal();
            var post_val = $(this).attr("id");
            var exploded = [];
            exploded = post_val.split('-');
            var tag_machine_enabled_post_list_id = exploded[1];
            var tag_campaign_tag_machine_comment_count = exploded[2];
            $("#bulk_comment_reply_campaign_enabled_post_list_id").val(tag_machine_enabled_post_list_id);
            $("#bulk_comment_reply_campaign_commenter_count").val(tag_campaign_tag_machine_comment_count);

            // make the schedule time field empty as it's filled with current date at initial stage
            var makeScheduleValEmptyifscheduleisNow2 = $("input[name=schedule_type2]:checked").val();
            if (makeScheduleValEmptyifscheduleisNow2 == 'now')
                $("#schedule_time2").val("");
        });

        $(document).on('click', '#submit_post2', function () {

            var campaign_name = $("#campaign_name2").val();
            var message = $("#message2").val();

            if (campaign_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Campaign name is required.');?>", 'warning');
                return;
            }

            if (message == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Reply content is required.');?>", 'warning');
                return;
            }

            var schedule_type = $("input[name=schedule_type2]:checked").val();
            var schedule_time = $("#schedule_time2").val();
            var time_zone = $("#time_zone2").val();
            var pleaseselectscheduletimetimezone = "<?php echo $pleaseselectscheduletimetimezone; ?>";

            if (typeof (schedule_type) == 'undefined' && (schedule_time == "" || time_zone == "")) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select schedule time/time zone.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var queryString = new FormData($("#bulk_comment_reply_campaign_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "comment_reply_enhancers/create_comment_reply_campaign_action",
                data: queryString,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == '1') {

                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Campagin has been created successfully."); ?>',
                            html: span,
                            icon: 'success'
                        });
                    } else {

                        var span = document.createElement("span");
                        span.innerHTML = '';
                        swal.fire({title: response.message, html: span, icon: 'error'});
                    }
                }
            });

        });

        $(document).on('click', '#lead_first_name', function () {
            var caretPos = $("#message2")[0].selectionStart;
            var textAreaTxt = $("#message2").val();
            var txtToAdd = " #LEAD_USER_FIRST_NAME# ";
            $("#message2").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });

        $(document).on('click', '#lead_last_name', function () {

            var caretPos = $("#message2")[0].selectionStart;
            var textAreaTxt = $("#message2").val();
            var txtToAdd = " #LEAD_USER_LAST_NAME# ";
            $("#message2").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });

        $(document).on('click', '#lead_tag_name', function () {

            var caretPos = $("#message2")[0].selectionStart;
            var textAreaTxt = $("#message2").val();
            var txtToAdd = " #TAG_USER# ";
            $("#message2").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });

        $('#comment_bulk_tag_campaign').on('hidden.bs.modal', function () {
            $("#bulk_tag_campaign_form").trigger('reset');
            table.draw();
        });

        $('#bulk_comment_reply_campaign').on('hidden.bs.modal', function () {
            $("#bulk_comment_reply_campaign_form").trigger('reset');
            table.draw();
        });

        daterange_locale.format = 'YYYY-MM-DD hh:mm';

        $('.datetimepicker2').daterangepicker({
            locale: daterange_locale,
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            drops: "up"
        });

        $('.datetimepicker3').daterangepicker({
            locale: daterange_locale,
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            drops: "up"
        });

    });
</script>
