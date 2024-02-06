<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
?>
<script src="<?php echo base_url(); ?>plugins/emoji/dist/emojionearea.js" type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>

    $("document").ready(function () {

        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });

        var emoji_message_div = $("#message").emojioneArea({
            <?php if ($rtl_on) {
                echo "dir: 'rtl',";
            } ?>
            autocomplete: false,
            pickerPosition: "bottom",
            //hideSource: false,
        });

        var today = new Date();
        var next_date = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
        $('.datepicker_x').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            maxDate: next_date

        })

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        var base_url = "<?php echo base_url();?>";


        var makeScheduleValEmptyifscheduleisNow = $("input[name=schedule_type]:checked").val();
        if (makeScheduleValEmptyifscheduleisNow == 'now')
            $("#schedule_time").val("");

        $("#link_block,#image_block,#video_block,.auto_share_post_block_item,.auto_reply_block_item,.auto_comment_block_item,.schedule_block_item,.preview_video_block,.preview_img_block,.preview_only_img_block").hide();

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

            var scheduleType = $("input[name=schedule_type]:checked").val();

            if (typeof (scheduleType) == "undefined")
                $(".schedule_block_item").show();
            else {
                $("#schedule_time").val("");
                $("#time_zone").val("");
                $("#repeat_times").val("");
                $("#time_interval").val("");
                $(".schedule_block_item").hide();
            }
        });

        var message_pre = $("#message").val();
        message_pre = message_pre.replace(/[\r\n]/g, "<br />");
        if (message_pre != "") {
            message_pre = message_pre + "<br/><br/>";
            $(".preview_message").html(message_pre);
        }


        $(document).on('click', '.post_type', function () {

            var post_type = $(this).attr("id");

            if (post_type == "text_post") {
                $("#link_block,#image_block,#video_block").hide();
                $('.post_type').removeClass("active");
                $('#submit_post').attr("submit_type", "text_submit");
                $('#submit_post_hidden').val("text_submit");
                $(".preview_img_block").hide();
                $(".preview_video_block").hide();
                $(".preview_only_img_block").hide();
                $(".demo_preview").hide();
            } else if (post_type == "link_post") {
                $("#image_block,#video_block").hide();
                $("#link_block").show();
                $('.post_type').removeClass("active")
                $('#submit_post').attr("submit_type", "link_submit");
                $('#submit_post_hidden').val("link_submit");

                $(".demo_preview").hide();
                $(".preview_video_block").hide();
                $(".preview_img_block").show();
                $(".preview_only_img_block").hide();

                var link_pre = $("#link").val();

                if (link_pre != "") {
                    $(".preview_og_info_link").html(link_pre);

                }
                var link_preview_image_pre = $("#link_preview_image").val();
                if (link_preview_image_pre != "") {
                    $(".preview_img").attr("src", link_preview_image_pre);
                }
                var link_caption_pre = $("#link_caption").val();
                if (link_caption_pre != "") {
                    $(".preview_og_info_title").html(link_caption_pre);
                }
                var link_description_pre = $("#link_description").val();
                if (link_description_pre != "") {
                    $(".preview_og_info_desc").html(link_description_pre);
                }

                $("#link").blur();

            } else if (post_type == "image_post") {
                $("#link_block,#video_block").hide();
                $("#image_block").show();
                $('.post_type').removeClass("active");
                $('#submit_post').attr("submit_type", "image_submit");
                $('#submit_post_hidden').val("image_submit");
                $(".preview_img_block").hide();
                $(".preview_video_block").hide();
                $(".demo_preview").hide();
                $(".preview_only_img_block").show();

                var image_url_pre = $("#image_url").val();
                if (image_url_pre != "") {
                    var image_url_array = image_url_pre.split(',');
                    $(".only_preview_img").attr("src", image_url_array[0]);
                }
            } else if (post_type == "video_post") {
                $("#link_block,#image_block").hide();
                $("#video_block").show();
                $('.post_type').removeClass("active");
                $('#submit_post').attr("submit_type", "video_submit");
                $('#submit_post_hidden').val("video_submit");
                $(".demo_preview").hide();
                $(".preview_img_block").hide();
                $(".preview_only_img_block").hide();
                $(".preview_video_block").show();
                var video_url_pre = $("#video_url").val();
                if (video_url_pre != "") {
                    var write_html = '<video width="100%" height="auto" style="border:1px solid #ccc;" controls poster="' + $("#video_thumb_url").val() + '"><source src="' + video_url_pre + '">Your browser does not support the video tag.</video>';
                    $(".preview_video_block").html(write_html);

                }

            }
            $(this).addClass("active");
        });


        $(document).on('blur', '#link', function () {
            var link = $("#link").val();
            if (link == '') return;
            // $(".previewLoader").show();
            $(".preLoader").show();
            $(".preLoader").html('<i class="bx bx-loader-alt bx-spin blue text-center" style="font-size:50px;"></i>');
            $('.preview_img').hide();
            $('.preview_og_info').hide();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>ultrapost/text_image_link_video_meta_info_grabber",
                data: {link: link},
                dataType: 'JSON',
                success: function (response) {

                    $("#link_preview_image").val(response.image);
                    $(".preview_img").attr("src", response.image);
                    $('.preview_img').show();

                    if (typeof (response.image) === 'undefined' || response.image == "")
                        $(".preview_img").hide();
                    else $(".preview_img").show();

                    $("#link_caption").val(response.title);
                    $(".preview_og_info_title").html(response.title);

                    $("#link_description").val(response.description);
                    $(".preview_og_info_desc").html(response.description);

                    var link_author = link;
                    var link_author = link_author.replace("http://", "");
                    var link_author = link_author.replace("https://", "");
                    if (typeof (response.image) != 'undefined' && response.author !== "") link_author = link_author + " | " + response.author;

                    $(".preview_og_info_link").html(link_author);

                    if (response.image == undefined || response.image == "")
                        $(".preview_img").hide();
                    else $(".preview_img").show();

                    $(".preview_img_block").show();
                    $('.preview_og_info').show();
                    $(".preLoader").html("");
                    $(".preLoader").hide();
                }
            });
        });

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


        $(document).on('keyup', '.emojionearea-editor', function () {

            var message = $("#message").val();
            message = htmlspecialchars(message);
            message = message.replace(/[\r\n]/g, "<br />");

            if (message != "") {
                message = message + "<br/><br/>";
                $(".preview_message").html(message);
                $(".demo_preview").hide();
            }
        });

        $(document).on('blur', '#link_preview_image', function () {
            var link = $("#link_preview_image").val();
            $(".preview_img").attr("src", link).show();
            $(".preview_img_block").show();
        });

        $(document).on('keyup', '#link_caption', function () {
            var link_caption = $("#link_caption").val();
            $(".preview_og_info_title").html(link_caption);
            $(".preview_img_block").show();
        });

        $(document).on('keyup', '#link_description', function () {
            var link_description = $("#link_description").val();
            $(".preview_og_info_desc").html(link_description);
            $(".preview_img_block").show();
        });


        $(document).on('blur', '#image_url', function () {

            var link = $("#image_url").val();
            var image_url_array = link.split(',');
            $(".only_preview_img").css("border", "1px solid #ccc");
            $(".only_preview_img").attr("src", image_url_array[0]);
            $(".preview_only_img_block").show();

        });


        $(document).on('blur', '#video_thumb_url', function () {
            var link = $("#video_thumb_url").val();
            if (link != '') {
                $(".previewLoader").show();
                var write_html = '<video width="100%" height="auto" style="border:1px solid #ccc;" controls poster="' + $("#video_thumb_url").val() + '"><source src="' + $("#video_url").val() + '">Your browser does not support the video tag.</video>';
                $(".preview_video_block").html(write_html);
                $(".previewLoader").hide();
            }

        });


        $(document).on('blur', '#video_url', function () {
            var link = $("#video_url").val();
            if (link != '') {
                $(".previewLoader").show();
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>ultrapost/text_image_link_video_youtube_video_grabber",
                    data: {link: link},
                    success: function (response) {
                        if (response != "") {
                            if (response == 'fail') {
                                alertify.alert('<?php echo $this->lang->line("Alert");?>', "<?php echo $this->lang->line('Video URL is invalid or this video is restricted from playback on certain sites.'); ?>", function () {
                                });
                                $("#video_url").val("");
                            } else {
                                $(".previewLoader").show();
                                var write_html = '<video width="100%" height="auto" style="border:1px solid #ccc;" controls poster="' + $("#video_thumb_url").val() + '"><source src="' + response + '">Your browser does not support the video tag.</video>';
                                $(".preview_video_block").html(write_html);
                                $(".previewLoader").hide();
                            }
                            $(".previewLoader").hide();
                        }
                    }
                });


            }

        });

        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        var video_upload_limit = "<?php echo $video_upload_limit; ?>";

        var image_list = [];
        $("#image_url_upload").uploadFile({
            url: base_url + "ultrapost/text_image_link_video_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: true,
            maxFileCount: 5,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/text_image_link_video_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        var item_to_delete = base_url + "upload_caster/text_image_link_video/" + data;
                        image_list = image_list.filter(item => item !== item_to_delete);
                        if (image_list.length > 0)
                            $(".only_preview_img").attr("src", image_list[0]);
                        else
                            $(".only_preview_img").attr("src", '');
                        $("#image_url").val(image_list.join());
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/text_image_link_video/" + data;
                image_list.push(data_modified);
                $("#image_url").val(image_list.join());
                $(".only_preview_img").attr("src", data_modified);
            }
        });


        $("#link_preview_upload").uploadFile({
            url: base_url + "ultrapost/text_image_link_video_upload_link_preview",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/text_image_link_video_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/text_image_link_video/" + data;
                $("#link_preview_image").val(data_modified);
                $(".preview_img").attr("src", data_modified);
            }
        });

        $("#video_url_upload").uploadFile({
            url: base_url + "ultrapost/text_image_link_video_upload_video",
            fileName: "myfile",
            maxFileSize: video_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".3g2,.3gp,.3gpp,.asf,.avi,.dat,.divx,.dv,.f4v,.flv,.m2ts,.m4v,.mkv,.mod,.mov,.mp4,.mpe,.mpeg,.mpeg4,.mpg,.mts,.nsv,.ogm,.ogv,.qt,.tod,.ts,.vob,.wmv",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/text_image_link_video_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/text_image_link_video/" + data;
                var write_html = '<video width="100%" height="auto" style="border:1px solid #ccc;" controls poster="' + $("#video_thumb_url").val() + '"><source src="' + data_modified + '">Your browser does not support the video tag.</video>';
                $(".preview_video_block").html(write_html);
                $("#video_url").val(data_modified);
            }
        });

        $("#video_thumb_url_upload").uploadFile({
            url: base_url + "ultrapost/text_image_link_video_upload_video_thumb",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/text_image_link_video_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/text_image_link_video/" + data;
                $("#video_thumb_url").val(data_modified);
                var write_html = '<video width="100%" height="auto" style="border:1px solid #ccc;" controls poster="' + data_modified + '"><source src="' + $("#video_url").val() + '">Your browser does not support the video tag.</video>';
                $(".preview_video_block").html(write_html);
            }
        });


        $(document).on('click', '#submit_post', function () {

            var post_type = $(this).attr("submit_type");

            if (post_type == "text_submit") {
                if ($("#message").val() == "") {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please type a message to post.');?>", 'warning');
                    return;
                }
            } else if (post_type == "link_submit") {
                if ($("#link").val() == "") {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please paste a link to post.');?>", 'warning');
                    return;
                }
            } else if (post_type == "image_submit") {
                if ($("#image_url").val() == "") {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please paste an image url or uplaod an image to post.');?>", 'warning');
                    return;
                }
            } else if (post_type == "video_submit") {
                if ($("#video_url").val() == "") {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please paste an video url or uplaod an video to post.');?>", 'warning');
                    return;
                }
            }


            var post_to_profile = $("input[name=post_to_profile]:checked").val();
            var post_to_pages = $("#post_to_pages").val();
            var post_to_groups = $("#post_to_groups").val();

            if ((post_to_pages == '' || typeof (post_to_pages) == 'undefined') && (post_to_groups == '' || typeof (post_to_groups) == 'undefined')) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select pages or groups to publish this post.');?>", 'warning');
                return;
            }

            var schedule_type = $("input[name=schedule_type]:checked").val();
            var schedule_time = $("#schedule_time").val();
            var time_zone = $("#time_zone").val();

            if (typeof (schedule_type) == 'undefined' && (schedule_time == "" || time_zone == "")) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select schedule time/time zone.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var queryString = new FormData($("#auto_poster_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "ultrapost/text_image_link_video_add_auto_post_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    var report_link = "<a href='" + base_url + "ultrapost/text_image_link_video'> <?php echo $this->lang->line('Click here to see report'); ?></a>";

                    if (response.status == "1") {
                        var span = document.createElement("span");
                        span.innerHTML = report_link;
                        swal.fire({title: response.message, html: span, icon: 'success'}).then(function () {
                            location.reload()
                        });
                    } else {
                        var span = document.createElement("span");
                        span.innerHTML = report_link;
                        swal.fire({title: response.message, html: span, icon: 'error'});
                    }

                }

            });

        });


        $(document).on('click', '.full-documentation', function () {
            $("#full-documentation-modal").modal();
        })


    });


</script>
