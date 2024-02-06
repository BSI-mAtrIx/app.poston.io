<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
?>
<script src="<?php echo base_url(); ?>plugins/emoji/dist/emojionearea.js" type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script type="text/javascript">
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="popover"]').on('click', function (e) {
        e.preventDefault();
        return true;
    });
</script>

<script>
    $("document").ready(function () {

        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });

        $("#video_message, #slider_message").emojioneArea({
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


        var base_url = "<?php echo base_url(); ?>";

        var makeScheduleValEmptyifscheduleisNow = $("input[name=schedule_type]:checked").val();
        if (makeScheduleValEmptyifscheduleisNow == 'now') $("#schedule_time").val("");


        var content_counter = 1;
        $("#content_counter").val(content_counter);
        $("#add_more").click(function () {
            content_counter++;
            if (content_counter == 5)
                $("#add_more").hide();
            $("#content_counter").val(content_counter);

            $("#slider_conten_" + content_counter).show();

        });


        $("#video_block,.auto_share_post_block_item,.auto_comment_block_item,.auto_reply_block_item,.schedule_block_item,.preview_video_block,.preview_img_block").hide();

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

        $(document).on('change', 'input[name=schedule_type]', function () {

            var scheduletype = $("input[name=schedule_type]:checked").val();

            if (typeof (scheduletype) == "undefined")
                $(".schedule_block_item").show();
            else {
                $("#schedule_time").val("");
                $("#time_zone").val("");
                $("#repeat_times").val("");
                $("#time_interval").val("");
                $(".schedule_block_item").hide();
            }
        });

        $(document).on('change', 'input[name=auto_comment]', function () {
            if ($("input[name=auto_comment]:checked").val() == "1")
                $(".auto_comment_block_item").show();
            else $(".auto_comment_block_item").hide();
        });


        $(document).on('click', '.post_type', function () {

            var post_type = $(this).attr("id");

            if (post_type == "video_post") {
                $("#slider_block").hide();
                $("#video_block").show();
                $('.post_type').removeClass("active");
                $('#submit_post').attr("submit_type", "video_submit");
            } else if (post_type == "slider_post") {
                $("#video_block").hide();
                $("#slider_block").show();
                $('.post_type').removeClass("active");
                $('#submit_post').attr("submit_type", "slider_submit");
            }

            $(this).addClass("active");
        });


        $("#submit_post").click(function () {

            // var campaign_name = $("#campaign_name").val().trim();
            // if(campaign_name == '')
            // {
            // 	alert("Campaign Name is required");
            // 	return;
            // }

            var content_type = $(this).attr('submit_type');
            $("#content_type").val(content_type);

            if (content_type == 'slider_submit') {
                // var slider_message = $("#slider_message").val().trim();
                // if(slider_message == ''){
                // 	alert('Message is required for slider posting.');
                // 	return;
                // }

                var image_link_counter = 0;

                for (var i = 1; i <= 5; i++) {
                    var slider_image_link = $("#post_image_link_" + i).val().trim();
                    if (slider_image_link != '')
                        image_link_counter++;
                }

                if (image_link_counter < 2) {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please provide atleast two images and corresponding information.');?>", 'warning');
                    return;
                }
            } else {
                // var video_message = $("#video_message").val().trim();
                // if(video_message == ''){
                // 	alert('Message is required for video posting.');
                // 	return;
                // }

                var video_image_counter = 0;

                for (var i = 1; i <= 7; i++) {
                    var video_image_link = $("#video_image_link_" + i).val().trim();
                    if (video_image_link != '')
                        video_image_counter++;
                }

                if (video_image_counter < 3) {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please provide atleast three images and corresponding information.');?>", 'warning');
                    return;
                }

            }

            var post_to_profile = $("input[name=post_to_profile]:checked").val();
            var post_to_pages = $("#post_to_pages").val();
            if (typeof (post_to_pages) == 'undefined' || post_to_pages == "") {
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

            var queryString = new FormData($("#video_slider_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "ultrapost/carousel_slider_add_post_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');
                    var report_link = "<a href='" + base_url + "ultrapost/carousel_slider_post'> <?php echo $this->lang->line('Click here to see report'); ?></a>";

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

        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        var video_upload_limit = "<?php echo $video_upload_limit; ?>";

        $("#post_image_1").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
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
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#post_image_link_1").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#post_image_link_1").val(data_modified);
            }
        });


        $("#post_image_2").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
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
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#post_image_link_2").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#post_image_link_2").val(data_modified);
            }
        });


        $("#post_image_3").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
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
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#post_image_link_3").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#post_image_link_3").val(data_modified);
            }
        });


        $("#post_image_4").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
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
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#post_image_link_4").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#post_image_link_4").val(data_modified);
            }
        });


        $("#post_image_5").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
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
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#post_image_link_5").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#post_image_link_5").val(data_modified);
            }
        });


        var video_content_counter = 1;
        $("#video_content_counter").val(video_content_counter);
        $("#add_more_video_image").click(function () {
            video_content_counter++;
            if (video_content_counter == 7)
                $("#add_more_video_image").hide();
            $("#video_content_counter").val(video_content_counter);

            $("#video_image_div_" + video_content_counter).show();

        });


        $("#video_images_1").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#video_image_link_1").val("");
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#video_image_link_1").val(data_modified);
            }

        });

        $("#video_images_2").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#video_image_link_2").val("");
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#video_image_link_2").val(data_modified);
            }

        });

        $("#video_images_3").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#video_image_link_3").val("");
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#video_image_link_3").val(data_modified);
            }

        });

        $("#video_images_4").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#video_image_link_4").val("");
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#video_image_link_4").val(data_modified);
            }

        });

        $("#video_images_5").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#video_image_link_5").val("");
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#video_image_link_5").val(data_modified);
            }

        });

        $("#video_images_6").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#video_image_link_6").val("");
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#video_image_link_6").val(data_modified);
            }

        });

        $("#video_images_7").uploadFile({
            url: base_url + "ultrapost/carousel_slider_upload_image_only",
            fileName: "myfile",
            maxFileSize: image_upload_limit * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".png,.jpg,.jpeg",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('ultrapost/carousel_slider_delete_uploaded_file');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#video_image_link_7").val("");
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload_caster/carousel_slider/" + data;
                $("#video_image_link_7").val(data_modified);
            }

        });


    });
</script>


<?php
if($content_generator){
    include(APPPATH.'modules/n_generator/include/modal_message_universal.php');
}
?>
