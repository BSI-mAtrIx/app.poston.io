<?php
$somethingwentwrong = $this->lang->line("something went wrong.");
$pleasewait = $this->lang->line("please wait") . '...';
$areyousure = $this->lang->line("are you sure");
$startcommenternames = $this->lang->line("Start typing commenter names you want to excude from tag list");
$list_of_commenters = $this->lang->line("List of commenters which this campaign will tag");
$campaign_name_is_required = $this->lang->line("Campaign name is required.");
$tag_content_is_required = $this->lang->line("Tag content is required.");
$you_have_not_selected_commenters = $this->lang->line("You have not selected commenters.");
$no_subscribed_commenter_found = $this->lang->line("No subscribed commenter found.");
$reply_content_is_required = $this->lang->line("Reply content is required.");
$pleaseselectscheduletimetimezone = $this->lang->line("Please select schedule time/time zone.");
$item_per_range = $this->config->item('item_per_range');
if ($item_per_range == '') $item_per_range = 50;
$tag_machine_enabled_post_list_id = $xdata[0]["tag_machine_enabled_post_list_id"];
?>
<script>
    var base_url = "<?php echo site_url(); ?>";
    var somethingwentwrong = "<?php echo $somethingwentwrong;?>";
    var pleasewait = "<?php echo $pleasewait;?>";
    var areyousure = "<?php echo $areyousure;?>";
    var startcommenternames = "<?php echo $startcommenternames;?>";
    var item_per_range = "<?php echo $item_per_range;?>";
    var list_of_commenters = "<?php echo $list_of_commenters;?>";
    var campaign_name_is_required = "<?php echo $campaign_name_is_required;?>";
    var tag_content_is_required = "<?php echo $tag_content_is_required;?>";
    var you_have_not_selected_commenters = "<?php echo $you_have_not_selected_commenters;?>";
    var no_subscribed_commenter_found = "<?php echo $no_subscribed_commenter_found;?>";
    var reply_content_is_required = "<?php echo $reply_content_is_required;?>"
    var tag_machine_enabled_post_list_id = "<?php echo $tag_machine_enabled_post_list_id;?>"
</script>

<script>

    $("document").ready(function () {

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        $('.exclude_autocomplete').tokenize({
            datas: base_url + "comment_reply_enhancers/commenter_autocomplete/" + tag_machine_enabled_post_list_id,
            placeholder: startcommenternames,
            dropdownMaxItems: 20,
            tokensMaxItems: item_per_range
        });


        $(document).on('click', '#submit_post', function () {
            event.preventDefault();

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

            var schedule_type = 'later';
            var schedule_time = $("#schedule_time").val();
            var time_zone = $("#time_zone").val();
            var pleaseselectscheduletimetimezone = "<?php echo $pleaseselectscheduletimetimezone; ?>";
            if (schedule_type == 'later' && (schedule_time == "" || time_zone == "")) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select schedule time/time zone.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var queryString = new FormData($("#bulk_tag_campaign_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "comment_reply_enhancers/edit_bulk_tag_campaign_action",
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
                            title: '<?php echo $this->lang->line("Campagin has been updated successfully."); ?>',
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


        $("#image_video_upload").uploadFile({
            url: base_url + "comment_reply_enhancers/upload_image_video",
            fileName: "myfile",
            maxFileSize: 100 * 1024 * 1024,
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
                // var data_modified = base_url+"upload/commenttagmachine/"+data;
                $("#uploaded_image_video").val(data);
                $("#img_preview").hide();
                $("#vid_preview").hide();
            }
        });

        // to preview attachment if available
        $(document).on('click', '#img_preview,#vid_preview', function (event) {
            event.preventDefault();

            $("#preview_modal").modal();

            var imgSrc = $("#img_preview").attr("img-src");
            var vidSrc = $("#vid_preview").attr("vid-src");
            if (imgSrc != "" && typeof (imgSrc) != "undefined") {
                $(".modal-body").append('<img id="showImage" src="' + imgSrc + '" alt="" style="width:100%">');
            }

            if (vidSrc != "" && typeof (vidSrc) != "undefined") {
                $(".modal-body").append('<video width="100%" controls style="border:1px solid #ccc"><source src="' + vidSrc + '"></video>');
            }


        });

        $("#preview_modal").on('hidden.bs.modal', function () {
            $(".modal-body").html("");
        });

    });
</script>