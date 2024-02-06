<script type="text/javascript">
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="popover"]').on('click', function (e) {
        e.preventDefault();
        return true;
    });
</script>

<script>

    $("document").ready(function () {

        setTimeout(function () {

            $("#link").blur();

            var cta_type = "<?php echo $all_data[0]["cta_type"]?>";
            if (cta_type == "MESSAGE_PAGE" || cta_type == "LIKE_PAGE")
                $(".cta_value_container_div").hide();
            else $(".cta_value_container_div").show();
            cta_type = cta_type.replace(/_/g, " ");
            cta_type = cta_type.toLowerCase();
            $(".cta-btn").html(cta_type);
            $(".cta-btn").css("text-transform", "capitalize");

            var auto_private_reply_con = "<?php echo $all_data[0]["auto_private_reply"];?>";
            if (auto_private_reply_con == 1) {
                $(".auto_reply_block_item").show();
            } else {
                $(".auto_reply_block_item").hide();
            }

            var auto_comment = "<?php echo $all_data[0]["auto_comment"]?>";
            if (auto_comment == 1) {
                $(".auto_comment_block_item").show();
            } else {
                $(".auto_comment_block_item").hide();
            }

            var auto_share_post = "<?php echo $all_data[0]["auto_share_post"];?>";
            if (auto_share_post == 1) {
                $(".auto_share_post_block_item").show();
            } else {
                $(".auto_share_post_block_item").hide();
            }
        }, 1000);
    });


    $("document").ready(function () {

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

        var base_url = "<?php echo base_url();?>";


        $(".auto_share_post_block_item,.auto_reply_block_item,.auto_comment_block_item,.cta_value_container_div").hide();

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
                $(".schedule_block_item").hide();
            }
        });

        var message_pre = $("#message").val();
        message_pre = message_pre.replace(/[\r\n]/g, "<br />");
        if (message_pre != "") {
            message_pre = message_pre + "<br/><br/>";
            $(".preview_message").html(message_pre);
        }


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
                url: "<?php echo site_url();?>ultrapost/cta_post_meta_info_grabber",
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
                    $("#cta_value").val(link);

                    if (response.image == undefined || response.image == "")
                        $(".preview_img").hide();
                    else $(".preview_img").show();

                    // $(".previewLoader").hide();
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
            }

        });

        $(document).on('blur', '#link_preview_image', function () {
            var link = $("#link_preview_image").val();
            $(".preview_img").attr("src", link).show();

        });

        $(document).on('change', '#cta_type', function () {
            var cta_type = $(this).val();

            if (cta_type == "MESSAGE_PAGE" || cta_type == "LIKE_PAGE")
                $(".cta_value_container_div").hide();
            else $(".cta_value_container_div").show();

            cta_type = cta_type.replace(/_/g, " ");
            cta_type = cta_type.toLowerCase();

            $(".cta-btn").html(cta_type);
            $(".cta-btn").css("text-transform", "capitalize");
        });

        $(document).on('keyup', '#link_caption', function () {
            var link_caption = $("#link_caption").val();
            $(".preview_og_info_title").html(link_caption);

        });

        $(document).on('keyup', '#link_description', function () {
            var link_description = $("#link_description").val();
            $(".preview_og_info_desc").html(link_description);

        });

        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        var video_upload_limit = "<?php echo $video_upload_limit; ?>";

        $("#link_preview_upload").uploadFile({
            url: base_url + "ultrapost/cta_post_upload_link_preview",
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
                var delete_url = "<?php echo site_url('ultrapost/cta_post_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/ctapost/" + data;
                $("#link_preview_image").val(data_modified);
                $(".preview_img").attr("src", data_modified);
            }
        });


        $(document).on('click', '#submit_post', function () {

            if ($("#link").val() == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please paste a link to post.');?>", 'warning');
                return;
            }

            if ($("#cta_value").val() == "" || $("#cta_type").val() == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select cta button type and enter cta button action link.');?>", 'warning');
                return;
            }


            var post_to_pages = $("#post_to_pages").val();
            if (post_to_pages == '' || typeof (post_to_pages) == 'undefined') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select pages to publish this post.');?>", 'warning');
                return;
            }


            var auto_share_post = $("input[name=auto_share_post]:checked").val();
            var auto_share_this_post_by_pages = $("#auto_share_this_post_by_pages").val();
            if ((auto_share_post == '1' && auto_share_this_post_by_pages == null) && $("input[name=auto_share_to_profile]:checked").val() == "No") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select pages to publish this post.');?>", 'warning');
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

            var queryString = new FormData($("#cta_poster_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "ultrapost/edit_cta_post_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');
                    var report_link = "<br/><a href='" + base_url + "ultrapost/cta_post'><?php echo $this->lang->line('Click here to see report'); ?></a>";

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


    });


</script>


<?php
if($content_generator){
    include(APPPATH.'modules/n_generator/include/modal_message_universal.php');
}
?>
