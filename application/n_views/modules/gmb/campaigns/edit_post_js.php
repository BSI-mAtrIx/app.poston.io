<script>
    var base_url = '<?php echo base_url(); ?>',
        gmb_post_tab_type = '<?php echo $campaign['post_type']; ?>',
        gmb_cta_action_url = '<?php echo $campaign['cta_action_url']; ?>',
        gmb_cta_action_type = '<?php echo $campaign['cta_action_type']; ?>',
        gmb_post_summery = '<?php echo $campaign['summary']; ?>',
        gmb_event_post_title = '<?php echo $campaign['event_post_title']; ?>',
        gmb_start_date_time = '<?php echo $campaign['start_date_time']; ?>',
        gmb_end_date_time = '<?php echo $campaign['end_date_time']; ?>',
        gmb_offer_redeem_url = '<?php echo $campaign['offer_redeem_url']; ?>',
        gmb_offer_coupon_code = '<?php echo $campaign['offer_coupon_code']; ?>',
        gmb_terms_conditions = '<?php echo $campaign['terms_conditions']; ?>',
        gmb_schedule_type = '<?php echo $campaign['schedule_type']; ?>',
        gmb_schedule_time = '<?php echo $campaign['schedule_time']; ?>',
        gmb_time_zone = '<?php echo $campaign['time_zone']; ?>',
        gmb_response = '<?php echo $campaign['response']; ?>',
        gmb_media_url = '<?php echo $campaign['media_url']; ?>',
        gmb_media_type = '<?php echo $campaign['media_type']; ?>',
        gmb_dummy_img_url = '<?php echo base_url('assets/images/demo_image.png'); ?>',
        link = $('.preview_og_info_link'),
        date_time = $('.preview_og_info_date'),
        desc = $('.preview_og_info_desc'),
        title = $('.preview_og_info_title'),
        coupon_box = $('.preview_og_info_coupon');

    $("document").ready(function () {
        function generateButton(url, name, type, block = false) {
            var state = block ? ' btn-block' : '';
            var button_text = ('CALL' === name) ? 'Call Now' : name;
            return '<a class="btn btn-' + type + '' + state + '" href="' + url + '">' + button_text + '</a>';
        }

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

        function handle_post_tabs(post_type) {
            $('#' + post_type).addClass('active');

            if ('cta_post' === post_type) {
                // Hides unnecessary blocks
                $('#event_block')
                    .add('#offer_block')
                    .add(desc)
                    .add(date_time)
                    .add(coupon_box)
                    .addClass('d-none');

                // Displays CTA block
                $('#cta_block')
                    .add(link)
                    .add(title)
                    .removeClass('d-none');

                // Refills preview
                if ('CALL' === gmb_cta_action_type) {
                    $('#cta_action_box').addClass('d-none');
                    $('#cta_action_info').removeClass('d-none');
                    var button = generateButton('#', gmb_cta_action_type, 'primary');
                    $(link).html(button);
                } else {
                    if (gmb_cta_action_url && gmb_cta_action_type) {
                        var button = generateButton(gmb_cta_action_url, gmb_cta_action_type, 'primary');
                        $(link).html(button);
                    }
                }

                if (gmb_post_summery) {
                    $(title).html(gmb_post_summery);
                }
            } else if ('event_post' === post_type) {
                // Hides unnecessary blocks
                $('#cta_block')
                    .add('#offer_block')
                    .add(link)
                    .add(coupon_box)
                    .addClass('d-none');

                // Shows necessary blocks
                $('#event_block')
                    .add('#message_textarea')
                    .add(title)
                    .add(date_time)
                    .add(desc)
                    .removeClass('d-none');

                // Refills preview
                if (gmb_event_post_title) {
                    $(title).text(gmb_event_post_title);
                }

                if (gmb_post_summery) {
                    $(desc).text(gmb_post_summery);
                }

                if (gmb_start_date_time && gmb_end_date_time) {
                    $(date_time).find('span').remove();
                    $(date_time).append('<span class="text-muted small d-block text-left">' + gmb_start_date_time + ' - ' + gmb_end_date_time + '</span>')
                }
            } else if ('offer_post' === post_type) {
                // Hides unnecessary blocks
                $('#cta_block')
                    .add('#event_block')
                    .add(desc)
                    .add(date_time)
                    .addClass('d-none');

                // Shows necessary blocks
                $('#offer_block')
                    .add(title)
                    .add(link)
                    .removeClass('d-none');

                // Refills preview
                if (gmb_offer_redeem_url) {
                    var redeem_text = '<?php echo $this->lang->line("Redeem Online"); ?>';
                    var redeem_url = '<a href="' + gmb_offer_redeem_url + '" target="_blank">' + redeem_text + '</a>';
                    gmb_offer_redeem_url = redeem_url;
                    $(link).html(redeem_url);
                }

                if (gmb_offer_coupon_code) {
                    $(coupon_box).removeClass('d-none');
                    $('.preview_coupon_code').text(gmb_offer_coupon_code);
                }

                if (gmb_post_summery) {
                    $(title).text(gmb_post_summery);
                }
            }
        }

        function findFileType(str) {
            var allowed_img_extension = ['.jpeg', '.jpg', '.png', '.gif'];
            var allowed_vid_extension = ['.flv', '.3gp', '.mp4', '.mov', '.avi', '.wmv'];
            var extension = str.substring(str.lastIndexOf('.'));

            var foundImg = allowed_img_extension.indexOf(extension);
            var foundVid = allowed_vid_extension.indexOf(extension);

            return (foundImg !== -1) ? 'image' : ((foundVid !== -1) ? 'video' : null);
        }

        function handle_media(url) {
            $('#media_url').val(url);
            $('.post_preview_block .preview_img').attr('src', url);
        }

        var emoji_message_div = $("#message").emojioneArea({
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
        });

        // Popover
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        var makeScheduleValEmptyifscheduleisNow = $('input[name=schedule_type]:checked').val();
        if (makeScheduleValEmptyifscheduleisNow == 'now') {
            $("#schedule_time").val("");
        }

        // Preview message
        var message_pre = $('#message').val();
        message_pre = message_pre.replace(/[\r\n]/g, "<br />");
        if (message_pre) {
            message_pre = message_pre + '<br/><br/>';
            $('.preview_message').html(message_pre);
        }

        // Handles default tab
        handle_post_tabs(gmb_post_tab_type);

        // Handles default media
        handle_media(gmb_media_url);

        // Handles default schedule type
        if (!gmb_schedule_type) {
            $('#schedule-post-box').removeClass('d-none');
        }

        // Tabs
        $(document).on('click', '#cta_post, #event_post, #offer_post', function (e) {
            e.preventDefault();

            // Gets the ID
            var post_type = $(this).attr('id');

            // Make post-tab global
            gmb_post_tab_type = post_type;

            // Sets value to hidden field
            $('#submitted_post_type').val(post_type)

            // Handles tabs
            handle_post_tabs(post_type);
        });

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

        // Handles preview data
        $(document).on(
            'keyup change',
            '#cta_action_type, '
            + '#cta_action_url, '
            + '#event_post_title, '
            + '#start_date_time, '
            + '#end_date_time, '
            + '#offer_title, '
            + '#offer_coupon_code, '
            + '#offer_redeem_url,'
            + '.emojionearea-editor, '
            + '#schedule_type',
            function (e) {
                e.preventDefault();

                var elm = $(this)[0];

                // Handles CTA post preview
                if ('cta_action_type' === elm.id) {
                    gmb_cta_action_type = $(this).val();
                    var button = generateButton(gmb_cta_action_url, gmb_cta_action_type, 'primary');
                    $(link).html(button);

                    if ('CALL' === $(this).val()) {
                        $('#cta_action_box').addClass('d-none');
                        $('#cta_action_info').removeClass('d-none');
                    } else {
                        $('#cta_action_info').addClass('d-none');
                        $('#cta_action_box').removeClass('d-none');
                    }
                }

                if ('cta_action_url' === elm.id) {
                    gmb_cta_action_url = $(this).val();
                    var button = '<a class="btn btn-primary" href="' + gmb_cta_action_url + '" target="_blank">' + gmb_cta_action_type + '</a>';
                    $(link).html(button);
                }

                // Handles EVENT post preview
                if ('event_post_title' === elm.id) {
                    gmb_event_post_title = $(this).val();
                    $(title).text($(this).val());
                }

                if ('start_date_time' === elm.id) {
                    var start_date = moment($(this).val());
                    if (start_date.isValid()) {
                        gmb_start_date_time = start_date.format('MMM D hh:MMA');
                    }
                }

                if ('end_date_time' === elm.id) {
                    var end_date = moment($(this).val());
                    if (end_date.isValid()) {
                        gmb_end_date_time = end_date.format('MMM D HH:MM A');
                    }
                    if (gmb_start_date_time && gmb_end_date_time) {
                        $(date_time).find('span').remove();
                        $(date_time).append('<span class="text-muted small d-block text-left">' + gmb_start_date_time + '-' + gmb_end_date_time + '</span>')
                    }
                }

                // Handles OFFER post preview
                if ('offer_coupon_code' === elm.id) {
                    gmb_offer_coupon_code = $(this).val();
                    $(coupon_box).removeClass('d-none');
                    $('.preview_coupon_code').text(gmb_offer_coupon_code);
                }
                if ('offer_redeem_url' === elm.id) {
                    var redeem_text = '<?php echo $this->lang->line("Redeem Online"); ?>';
                    var redeem_url = '<a href="' + $(this).val() + '" target="_blank">' + redeem_text + '</a>';
                    gmb_offer_redeem_url = redeem_url;
                    $(link).html(redeem_url);
                }

                // Summery
                if ('emojionearea-editor' === elm.className) {
                    gmb_post_summery = elm.innerText;
                    if ('cta_post' === gmb_post_tab_type
                        || 'offer_post' === gmb_post_tab_type
                    ) {
                        $(title).text(elm.innerText);
                    } else {
                        $(desc).text(elm.innerText);
                    }
                }

                // Schedule
                if (false === $('#schedule_type').prop('checked')) {
                    $('#schedule-post-box').removeClass('d-none');
                } else {
                    $('#schedule-post-box').addClass('d-none');
                    $('#schedule_time').val('');
                    $('#time_zone').val('');
                }
            }
        );

        // Uploads media
        $('#media_url_upload').uploadFile({
            url: base_url + 'gmb/upload_media',
            fileName: 'xerobiz_file',
            maxFileSize: <?php echo $file_upload_limit; ?> * 1024 * 1024,
            showPreview: false,
            returnType: 'json',
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: 'image/png,image/jpeg,image/gif',
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('gmb/delete_media'); ?>";
                $.post(delete_url, {op: 'delete', name: data},
                    function (resp, textStatus, jqXHR) {
                        if ('success' === textStatus) {
                            $('#media_url').val('');
                            $('.post_preview_block .preview_img').attr('src', gmb_dummy_img_url);
                            $('.post_preview_block .preview_img').removeClass('d-none');
                        }
                    }
                );
            },
            onSuccess: function (files, data, xhr, pd) {
                var gmb_image_src = base_url + 'upload/xerobiz/' + data;
                $('#media_url').val(gmb_image_src);
                $('.post_preview_block .preview_img').attr('src', gmb_image_src);
                $('.post_preview_block .preview_img').removeClass('d-none');
            }
        });

        // Submits form data
        $(document).on('click', '#submit_post', function () {
            $(this).addClass('btn-progress')
            var that = $(this);

            var formData = new FormData($("#auto_poster_form")[0]);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('gmb/create_campaign'); ?>',
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
                                buttons: true,
                            })
                                .then((willDelete) => {
                                    if (willDelete.isConfirmed) {
                                        window.location.href = base_url + 'gmb/posts';
                                    }
                                });
                        }
                    }
                }
            });
        });
    });
</script>