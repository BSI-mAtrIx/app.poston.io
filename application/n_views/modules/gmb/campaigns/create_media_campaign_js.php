<script>
    $("document").ready(function () {

        var base_url = "<?php echo base_url(); ?>",
            gmb_dummy_img_url = "<?php echo base_url('assets/images/demo_image.png'); ?>";

        // Emoji
        $("#media_description").emojioneArea({
            <?php if ($rtl_on) {
                echo "dir: 'rtl',";
            } ?>
            autocomplete: false,
            pickerPosition: "bottom",
            // hideSource: false,
        });

        var today = new Date();
        var next_date = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());

        // DateTimePicker
        $('.datepicker_x').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            maxDate: next_date
        })

        // Popover
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        var makeScheduleValEmptyifscheduleisNow = $("input[name=schedule_type]:checked").val();
        if (makeScheduleValEmptyifscheduleisNow == 'now') {
            $("#schedule_time").val("");
        }

        $(document).on('change', '#schedule_type', function (e) {
            e.preventDefault();

            // Schedule
            if (false === $('#schedule_type').prop('checked')) {
                $('#schedule-post-box').removeClass('d-none');
            } else {
                $('#schedule-post-box').addClass('d-none');
                $('#schedule_time').val('');
                $('#time_zone').val('');
            }

        });

        function findFileType(str) {
            var allowed_img_extension = ['.jpeg', '.jpg', '.png', '.gif'];
            var allowed_vid_extension = ['.flv', '.3gp', '.mp4', '.mov', '.avi', '.mts', '.m4v', '.mkv', '.mpeg', '.ogv', '.webm'];
            var extension = str.substring(str.lastIndexOf('.'));

            var foundImg = allowed_img_extension.indexOf(extension);
            var foundVid = allowed_vid_extension.indexOf(extension);

            return (foundImg !== -1) ? 'image' : ((foundVid !== -1) ? 'video' : null);
        }

        // Tricks to know mime type of a file
        var input_el = $('ajax-upload-id-*');
        $(document).on('change', input_el, (event) => {
            if (event.target.files) {
                window.xit_gmb_file_mime_type = event.target.files[0].type
            } else {
                window.xit_gmb_file_mime_type = null;
            }
        });

        // Uploads media
        $("#media_file").uploadFile({
            url: base_url + 'gmb/media_campaign_upload',
            fileName: 'media_file',
            maxFileSize: <?php echo $file_upload_limit; ?> * 1024 * 1024,
            showPreview: false,
            returnType: 'json',
            dragDrop: true,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: '.jpeg, .jpg, .png, .gif, .flv, .ogg, .webm, .3gpp, .mp4, .mkv, .mpeg, .mov, .avi, .wmv, .m4v',
            deleteCallback: function (data, pd) {
                var delete_url = '<?php echo site_url('gmb/delete_media_campaign_upload'); ?>';
                $.post(delete_url, {op: 'delete', name: data}, function (resp, textStatus, jqXHR) {
                        var result = JSON.parse(resp),
                            preview_img = $('.preview_img'),
                            preview_block = $('.post_preview_block');

                        preview_block.find('video').remove();
                        preview_img.attr('src', gmb_dummy_img_url);
                        preview_img.show();

                        // if (true === result.status) {
                        // }
                    }
                );
            },
            onSuccess: function (files, data, xhr, pd) {

                // files - an array of user provided files' name
                // data - an object with status and filename attributes
                // pd - an object containing progress bar data

                if (false === data.status) {
                    swal.fire({
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                        text: data.message,
                        icon: 'error',
                        button: '<?php echo $this->lang->line('Ok'); ?>'
                    });

                    exit;
                }

                if (true === data.status) {
                    var file_type = findFileType(data.filename),
                        preview_block = $('.post_preview_block'),
                        preview_img = $('.preview_img'),
                        media_url = base_url + 'upload/xerobiz/media/' + data.filename;

                    console.log(file_type);

                    if ('image' === file_type) {
                        // Removes video if there is any
                        preview_block.find('video').remove();

                        // Hides demo image first
                        preview_img.hide();

                        // Updates src of image and displays it
                        preview_img.attr('src', media_url);
                        preview_img.show();

                    } else if ('video' === file_type) {
                        var mime_type = window.xit_gmb_file_mime_type;
                        var vid = '<video controls width="100%" height="auto">';
                        vid += '<source src="' + media_url + '" type="' + mime_type + '">';
                        vid += 'Your browser does not support the video tag.';
                        vid += '</video>';
                        preview_img.hide();
                        preview_block.prepend(vid);
                    }

                }
            },
            onError: function (files, status, errMsg, pd) {

                //files: list of files
                //status: error status
                //errMsg: error message

                swal.fire({
                    title: '<?php echo $this->lang->line('Info!'); ?>',
                    text: errMsg,
                    icon: 'info',
                    button: '<?php echo $this->lang->line('Ok'); ?>'
                });
            }
        });

        // Submits form data
        $(document).on('click', '#create_media_campaign', function () {

            $(this).addClass('btn-progress');
            var that = $(this);

            var formData = new FormData($("#auto_media_poster_form")[0]);

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('gmb/handle_media_campaign'); ?>',
                data: formData,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');
                    if (false === response.status) {
                        if (response.message) {
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error!"); ?>',
                                text: response.message,
                                icon: 'error'
                            });
                            return;
                        }

                        var error_content = '';
                        if (response.errors) {
                            for (var error_item of Object.values(response.errors)) {
                                error_content += '<span class="d-block">' + error_item + '</span>';
                            }

                            var span = document.createElement("span");
                            span.innerHTML = error_content;
                            swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                        }
                    } else if (true === response.status) {
                        if (response.message) {
                            swal.fire({
                                title: '<?php echo $this->lang->line("Success!"); ?>',
                                text: response.message,
                                icon: "success",
                                button: '<?php echo $this->lang->line("Ok"); ?>',
                            })
                                .then((willDelete) => {
                                    if (willDelete.isConfirmed) {
                                        window.location.href = base_url + 'gmb/media_campaigns';
                                    }
                                });
                        }
                    }
                }
            });
        });
    });
</script>