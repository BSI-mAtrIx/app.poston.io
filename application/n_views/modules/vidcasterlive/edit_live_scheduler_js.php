<script>
    function htmlspecialchars(str) {
        if (typeof (str) == "string") {
            str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
            str = str.replace(/"/g, "&quot;");
            str = str.replace(/'/g, "&#039;");
            str = str.replace(/</g, "&lt;");
            str = str.replace(/>/g, "&gt;");
        }
        return str;
    }

    $("document").ready(function () {

        $(document).on('click', '.share_crosspost_mean', function (e) {
            e.preventDefault();
            $("#share_crosspost_modal").modal();
        });
        // put the current schedule time to preview section
        var schedule_time = $("#schedule_time").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>vidcasterlive/date_display_formatter",
            data: {schedule_time: schedule_time},
            success: function (response) {
                $(".schedule_time_preview").html(response);
            }
        });
        // end of put the current schedule time to preview section

        $(document).on('blur', '#schedule_time', function () {
            var schedule_time = $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>vidcasterlive/date_display_formatter",
                data: {schedule_time: schedule_time},
                success: function (response) {
                    $(".schedule_time_preview").html(response);
                }
            });
        });

        var emoji_message_div = $("#message").emojioneArea({
            <?php if ($rtl_on) {
                echo "dir: 'rtl',";
            } ?>
            autocomplete: false,
            pickerPosition: "bottom"
            //hideSource: false,
        });


        var base_url = "<?php echo base_url();?>";
        $("#loading").hide();
        $(".preview_direct_block").hide();

        var today = new Date();
        var next_date = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7);
        $('.date_time_picker').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            maxDate: next_date
        })


        var xauto_share_post = "<?php echo $xauto_share_post;?>";
        var xauto_private_reply = "<?php echo $xauto_private_reply;?>";
        var xauto_comment = "<?php echo $xauto_comment;?>";
        var xcreate_event = "<?php echo $xcreate_event;?>";
        var user_id = "<?php echo $user_id;?>";

        if (xauto_share_post == "0") $(".auto_share_post_block_item").hide();
        if (xauto_private_reply == "0") $(".auto_reply_block_item").hide();
        if (xauto_comment == "0") $(".auto_comment_block_item").hide();
        if (xcreate_event == "0") $(".hide_if_no").hide();


        $(document).on('click', '#play-video', function () {
            var video_url = $("#scheduled_video_url").val();
            if (video_url == "") {
                display_alert("<?php echo $this->lang->line("No video found to play");?>");
                return false;
            }
            var src = base_url + "upload_caster/live_video/" + video_url;
            var html = '<video width="100%" border="1" height="auto" controls> <source src="' + src + '">Your browser does not support the video tag.</video>';
            $("#modal-play .modal-body").html(html);
            $("#modal-play").modal();
        });

        $(document).on('click', '#play-image', function () {
            var image_url = $("#image_url").val();
            if (image_url == "") {
                display_alert("<?php echo $this->lang->line("No image found to display");?>");
                return false;
            }
            var src = image_url;
            var html = '<img width="100%" height="auto" src="' + src + '">';
            $("#modal-play .modal-body").html(html);
            $("#modal-play").modal();
        });

        // share or crosspost change section
        var share_or_cross = $("input[name=share_or_cross]:checked").val();
        if (share_or_cross == "crossposting") {
            var go_live_page_id = $("#post_to").val();
            var page_group_user = go_live_page_id.split("-");
            if (page_group_user[0] == 'page') {
                var page_table_id = page_group_user[1];
                var campaign_id = "<?php echo $xdata[0]["id"];?>";
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>vidcasterlive/get_crosspostallowed_pages",
                    data: {page_table_id: page_table_id, campaign_id: campaign_id},
                    success: function (response) {
                        $("#crosspost_this_post_by_pages").html(response);
                    }
                });
            }

            if ($("input[name=crosspost_enable_disable]:checked").val() == '1') $(".crosspost_block_item").show();
            else $(".crosspost_block_item").hide();
            $(".auto_share_post_block_item").hide();
        } else if (share_or_cross == "auto_share") {
            if ($("input[name=auto_share_post]:checked").val() == '1') $(".auto_share_post_block_item").show();
            else $(".auto_share_post_block_item").hide();
            $(".crosspost_block_item").hide();
        } else {
            $(".crosspost_block_item").hide();
            $(".auto_share_post_block_item").hide();
        }

        $(document).on('change', 'input[name=share_or_cross]', function () {
            var go_live_page_id = $("#post_to").val();
            var page_group_user = go_live_page_id.split("-");
            if ($(this).val() == "crossposting") {
                if (page_group_user[0] != 'page')
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("This feature only works for Page post. It will not work if you go live to your any Groups. Please select a page from above list."); ?>', 'warning');

                if (page_group_user[0] == 'page') {
                    var page_table_id = page_group_user[1];
                    var campaign_id = "<?php echo $xdata[0]["id"];?>";
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>vidcasterlive/get_crosspostallowed_pages",
                        data: {page_table_id: page_table_id, campaign_id: campaign_id},
                        success: function (response) {
                            $("#crosspost_this_post_by_pages").html(response);
                        }
                    });
                }

                if ($("input[name=crosspost_enable_disable]:checked").val() == '1') $(".crosspost_block_item").show();
                else $(".crosspost_block_item").hide();
                $(".auto_share_post_block_item").hide();
            } else if ($(this).val() == "auto_share") {
                if (page_group_user[0] != 'page')
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("This feature only works for Page post. It will not work if you go live to your any Groups. Please select a page from above list."); ?>', 'warning');

                if ($("input[name=auto_share_post]:checked").val() == '1') $(".auto_share_post_block_item").show();
                else $(".auto_share_post_block_item").hide();
                $(".crosspost_block_item").hide();
            } else {
                $(".crosspost_block_item").hide();
                $(".auto_share_post_block_item").hide();
            }
        });
        // end of share of crosspost change section


        $(document).on('change', 'input[name=crosspost_enable_disable]', function () {
            if ($("input[name=crosspost_enable_disable]:checked").val() == "1")
                $(".crosspost_block_item").show();
            else $(".crosspost_block_item").hide();
        });

        $(document).on('change', 'input[name=auto_share_post]', function () {
            if ($("input[name=auto_share_post]:checked").val() == "1")
                $(".auto_share_post_block_item").show();
            else $(".auto_share_post_block_item").hide();
        });

        $(document).on('change', 'input[name=auto_private_reply]', function () {
            if ($("input[name=auto_private_reply]:checked").val() == "1")
                $(".auto_reply_block_item").show();
            else $(".auto_reply_block_item").hide();
        });

        $(document).on('change', 'input[name=auto_comment]', function () {
            if ($("input[name=auto_comment]:checked").val() == "1")
                $(".auto_comment_block_item").show();
            else $(".auto_comment_block_item").hide();
        });


        $(document).on('change', 'input[name=schedule_type]', function () {
            if ($("input[name=schedule_type]:checked").val() == "later") {
                $(".hide_if_now").show();
                $(".preview_direct_block").hide();
                $(".preview_only_img_block").show();
                $("#live_text").html(" plans to go live.");
                if ($("input[name=use_system_video]:checked").val() == "no")
                    $("#create_event_no").attr('disabled', 'disabled');

            } else {
                $(".hide_if_now").hide();
                $(".preview_direct_block").show();
                $(".preview_only_img_block").hide();
                $("#live_text").html(" is live now.");
                $("#create_event_no").removeAttr('disabled');
            }

        });

        if ($("input[name=use_system_video]:checked").val() == "yes") {
            $(".system_video").show();
            $("#create_event_no").removeAttr('disabled');
        } else {
            $(".system_video").hide();
            if ($("input[name=schedule_type]:checked").val() == "later")
                $("#create_event_no").attr('disabled', 'disabled');
        }

        $(document).on('change', 'input[name=use_system_video]', function () {
            if ($("input[name=use_system_video]:checked").val() == "yes") {
                $(".system_video").show();
                $("#create_event_no").removeAttr('disabled');
            } else {
                $(".system_video").hide();
                if ($("input[name=schedule_type]:checked").val() == "later")
                    $("#create_event_no").attr('disabled', 'disabled');
            }
        });


        $(document).on('change', 'input[name=create_event]', function () {
            if ($("input[name=create_event]:checked").val() == "1")
                $(".hide_if_no").show();
            else
                $(".hide_if_no").hide();

        });

        $(document).on('click', '.video_format', function () {
            $("#video_format").modal();
        });

        $(document).on('click', '.thumbnail_format', function () {
            $("#thumbnail_format").modal();
        });


        var message_pre = $("#message").val();
        message_pre = htmlspecialchars(message_pre);
        message_pre = message_pre.replace(/[\r\n]/g, "<br />");
        if (message_pre != "") {
            message_pre = message_pre + "<br/><br/>";
            $(".preview_message").html(message_pre);
        }


        $(document).on('keyup', '.emojionearea-editor', function () {
            var message = $("#message").val()
            message = htmlspecialchars(message);
            message = message.replace(/[\r\n]/g, "<br />");
            if (message != "") {
                message = message + "<br/><br/>";
                $(".preview_message").html(message);
                $(".demo_preview").hide();
            }
        });


        $(document).on('blur', '#image_url', function () {
            var link = $("#image_url").val();
            if (link != "") $(".schedule_image_preview").attr("src", link);
            else {
                var default_pic = $("#post_to option:selected").attr("picture");
                $(".schedule_image_preview").attr("src", default_pic);
            }
        });

        // put the selected page values to preview section
        var picture = $("#post_to option:selected").attr("picture");
        var display_name = $("#post_to option:selected").attr("display_name");
        $(".schedule_page_preview_name,.preview_page").html(display_name);

        if ($("#image_url").val() == "")
            $(".schedule_image_preview").attr("src", picture);
        else $(".schedule_image_preview").attr("src", $("#image_url").val());
        $(".preview_cover_img").attr("src", picture);

        var go_live_page_id = $("#post_to").val();
        var page_group_user = go_live_page_id.split("-");
        if (page_group_user[0] == 'page') {
            var page_table_id = page_group_user[1];
            var campaign_id = "<?php echo $xdata[0]["id"];?>";
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>vidcasterlive/get_crosspostallowed_pages",
                data: {page_table_id: page_table_id, campaign_id: campaign_id},
                success: function (response) {
                    $("#crosspost_this_post_by_pages").html(response);
                }
            });
        }
        // end of put selected page values to preview section

        $(document).on('change', '#post_to', function () {
            var picture = $("option:selected", this).attr("picture");
            var display_name = $("option:selected", this).attr("display_name");
            $(".schedule_page_preview_name,.preview_page").html(display_name);

            if ($("#image_url").val() == "")
                $(".schedule_image_preview").attr("src", picture);
            else $(".schedule_image_preview").attr("src", $("#image_url").val());

            $(".preview_cover_img").attr("src", picture);

            var go_live_page_id = $("#post_to").val();
            var page_group_user = go_live_page_id.split("-");
            if (page_group_user[0] == 'page') {
                var page_table_id = page_group_user[1];
                var campaign_id = "<?php echo $xdata[0]["id"];?>";
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>vidcasterlive/get_crosspostallowed_pages",
                    data: {page_table_id: page_table_id, campaign_id: campaign_id},
                    success: function (response) {
                        $("#crosspost_this_post_by_pages").html(response);
                    }
                });
            }
        });

        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        $("#image_url_upload").uploadFile({
            url: base_url + "vidcasterlive/upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024, uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('vidcasterlive/delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/scheduler/" + data;
                $("#image_url").val(data_modified);
                $(".schedule_image_preview").attr("src", data_modified);
            }
        });

        function display_alert(message) {
            swal.fire('<?php echo $this->lang->line("Warning"); ?>', message, 'warning');
        }

        $(document).on('click', '#submit_post', function () {

            var scheduler_name = $("#scheduler_name").val();
            if (scheduler_name == "") {
                display_alert("<?php echo $this->lang->line('Please provide a campaign name.');?>");
                return;
            }

            var scheduled_video_url = $("#scheduled_video_url").val();
            if ($("input[name=use_system_video]:checked").val() == "yes") {
                if (scheduled_video_url == "") {
                    display_alert("<?php echo $this->lang->line('Please upload a video.');?>");
                    return;
                }
            }

            var schedule_type = $("input[name=schedule_type]:checked").val();
            var schedule_time = $("#schedule_time").val();
            var time_zone = $("#time_zone").val();

            if (schedule_type == 'later') {
                if (schedule_time == "") {
                    display_alert("<?php echo $this->lang->line("Please select planned time to go live.");?>");
                    return;
                }

                if (time_zone == "") {
                    display_alert("<?php echo $this->lang->line("Please select a time zone.");?>");
                    return;
                }
            }


            var post_to = $("input[name=post_to]:checked").val();

            if (post_to == "") {
                display_alert("<?php echo $this->lang->line("Please select page/group to go live.");?>");
                return;
            }

            var share_or_cross = $("input[name=share_or_cross]:checked").val();


            if (share_or_cross == 'crossposting') {
                var crosspost_enable = $("input[name=crosspost_enable_disable]:checked").val();
                var crosspost_this_post_by_pages = $("#crosspost_this_post_by_pages").val();
                if (crosspost_enable == '1' && crosspost_this_post_by_pages.length == 0) {
                    display_alert('<?php echo $this->lang->line("Please select pages for crossposting.");?>');
                    return;
                }
            } else if (share_or_cross == 'auto_share') {
                var auto_share_post = $("input[name=auto_share_post]:checked").val();
                var auto_share_this_post_by_pages = $("#auto_share_this_post_by_pages").val();
                if (auto_share_post == '1' && auto_share_this_post_by_pages.length == 0) {
                    display_alert('<?php echo $this->lang->line("Please select pages for auto sharing.");?>');
                    return;
                }
            }

            var auto_private_reply = $("input[name=auto_private_reply]:checked").val();
            var auto_private_reply_text = $("#auto_private_reply_text").val();
            if (auto_private_reply == '1' && auto_private_reply_text == "") {
                display_alert("<?php echo $this->lang->line("Please type private reply message.");?>");
                return;
            }

            var auto_comment = $("input[name=auto_comment]:checked").val();
            var auto_comment_text = $("#auto_comment_text").val();
            if (auto_comment == '1' && auto_comment_text == "") {
                display_alert("<?php echo $this->lang->line("Please type auto comment message.");?>");
                return;
            }

            $(this).addClass('btn-progress');

            var queryString = new FormData($("#live_scheduler_form")[0]);
            $.ajax({
                context: this,
                type: 'POST',
                url: base_url + "vidcasterlive/edit_live_scheduler_action",
                data: queryString,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(this).removeClass('btn-progress');

                    var report_link = "<br/><a href='" + base_url + "vidcasterlive/live_scheduler_list'>" + '<?php echo $this->lang->line("Go to List");?>' + "</a>";
                    var redirect_url = base_url + "vidcasterlive/live_scheduler_list";

                    if (response.status == "1") {
                        var span = document.createElement("span");
                        var display_content = response.message + report_link;
                        span.innerHTML = display_content;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Success"); ?>',
                            html: span,
                            icon: 'success'
                        }).then((value) => {
                            window.location.replace(redirect_url);
                        });
                    } else {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                    }

                },
                error: function (response) {
                    var span = document.createElement("span");
                    span.innerHTML = response.responseText;
                    swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                }

            });

        });

        var video_upload_limit = "<?php echo $video_upload_limit; ?>";
        $("#live_video_upload").uploadFile({
            url: base_url + "vidcasterlive/upload_live_video",
            fileName: "myfile",
            maxFileSize: video_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".avi,.divx,.flv,.mkv,.mov,.mp4,.mpeg,.mpeg4,.mpg,.wmv",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('vidcasterlive/delete_uploaded_live_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                $(".preview_video_block").val(data);
            }
        });


    });
</script>


<?php
if($content_generator){
    include(APPPATH.'modules/n_generator/include/modal_message_universal.php');
}
?>
