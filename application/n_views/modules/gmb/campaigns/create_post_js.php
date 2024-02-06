<script>
    $("document").ready(function () {

        var gmb_dummy_img_url = "<?php echo base_url('assets/images/demo_image.png'); ?>";
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
        })

        // Popover
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        var base_url = "<?php echo base_url(); ?>";
        var makeScheduleValEmptyifscheduleisNow = $("input[name=schedule_type]:checked").val();
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

        // Make post-tab global
        window.gmb_post_tab_type = 'cta_post';
        var link = $('.preview_og_info_link'),
            date_time = $('.preview_og_info_date'),
            desc = $('.preview_og_info_desc'),
            title = $('.preview_og_info_title'),
            coupon_box = $('.preview_og_info_coupon'),
            coupon_code = $('.preview_coupon_code'),
            coupon_date = $('.preview_coupon_date');

        $(document).on('click', '#cta_post, #event_post, #offer_post', function (e) {
            e.preventDefault();

            // Gets the ID
            var post_type = $(this).attr('id');

            // Make post-tab global
            window.gmb_post_tab_type = post_type;

            // Sets value to hidden field
            $('#submitted_post_type').val(post_type)

            if ('cta_post' === post_type) {
                // Hides unnecessary blocks
                $('#common-fields')
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
                if ('CALL' !== window.gmb_cta_action_type) {
                    if (window.gmb_cta_action_url && window.gmb_cta_action_type) {
                        var button = generateButton(window.gmb_cta_action_url, window.gmb_cta_action_type, 'primary');
                        link.html(button);
                    }
                }

                if (window.gmb_post_summery) {
                    $(title).html(window.gmb_post_summery);
                }
            } else if ('event_post' === post_type) {
                // Hides unnecessary blocks
                $('#cta_block')
                    .add('#offer_block')
                    .add(link)
                    .add(coupon_box)
                    .add(coupon_date)
                    .addClass('d-none');

                // Shows necessary blocks
                $('#event_block')
                    .add('#common-fields')
                    .add('#message_textarea')
                    .add(title)
                    .add(date_time)
                    .add(desc)
                    .removeClass('d-none');

                // Refills preview
                if (window.gmb_post_title) {
                    title.text(window.gmb_post_title);
                }

                if (window.gmb_post_summery) {
                    desc.text(window.gmb_post_summery);
                }

                if (window.gmb_start_date_time && window.gmb_end_date_time) {
                    date_time.find('span').remove();
                    date_time.append('<span class="text-muted small d-block text-left">' + window.gmb_start_date_time + ' - ' + window.gmb_end_date_time + '</span>')
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
                    .add('#common-fields')
                    .add(title)
                    .add(date_time)
                    .add(desc)
                    .add(link)
                    .add(coupon_box)
                    .add(coupon_date)
                    .removeClass('d-none');

                // Refills preview
                if (window.gmb_post_title) {
                    title.text(window.gmb_post_title);
                }

                if (window.gmb_start_date_time && window.gmb_end_date_time) {
                    date_time.find('span').remove();
                    date_time.append('<span class="text-muted small d-block text-left">' + window.gmb_start_date_time + ' - ' + window.gmb_end_date_time + '</span>')
                }

                if (window.gmb_offer_redeem_url) {
                    link.html(window.gmb_offer_redeem_url);
                }

                if (window.gmb_offer_coupon_code) {
                    coupon_box.removeClass('d-none');
                    coupon_code.text(window.gmb_offer_coupon_code);

                    if (window.gmb_start_date_time2 && window.gmb_end_date_time2) {
                        coupon_date.find('span').remove();
                        coupon_date.append('<span class="text-muted d-block text-center"><?php echo $this->lang->line('Valid'); ?> ' + window.gmb_start_date_time2 + ' - ' + window.gmb_end_date_time2 + '</span>');
                    }
                }

                if (window.gmb_post_summery) {
                    desc.text(window.gmb_post_summery);
                }

                $('#submit_post').attr("submit_type", "image_submit");
            }

            $(this).addClass("active");
        });

        function generateButton(url, name, type, block = false) {
            var state = block ? ' btn-block' : '';
            var button_text = ('CALL' === name) ? 'Call Now' : name;
            return '<a class="btn btn-' + type + '' + state + '" href="' + url + '" target="_blank">' + button_text + '</a>';
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

        $(document).on(
            'keyup change',
            '#cta_action_type, '
            + '#cta_action_url, '
            + '#post_title, '
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
                    window.gmb_cta_action_type = $(this).val();
                    var button = generateButton(window.gmb_cta_action_url, window.gmb_cta_action_type, 'primary');
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
                    window.gmb_cta_action_url = $(this).val();
                    var button = '<a class="btn btn-primary" href="' + window.gmb_cta_action_url + '" target="_blank">' + window.gmb_cta_action_type + '</a>';
                    $(link).html(button);
                }

                // Handles EVENT post preview
                if ('post_title' === elm.id) {
                    window.gmb_post_title = $(this).val();
                    $(title).text($(this).val());
                }

                if ('start_date_time' === elm.id) {
                    var start_date = moment($(this).val());
                    if (start_date.isValid()) {
                        window.gmb_start_date_time = start_date.format('MMM D hh:MMA');
                        window.gmb_start_date_time2 = start_date.format('D/M/YYYY hh:MMA');
                    }

                    if (window.gmb_start_date_time && window.gmb_end_date_time) {
                        date_time.find('span').remove();
                        date_time.append('<span class="text-muted small d-block text-left">' + window.gmb_start_date_time + '-' + window.gmb_end_date_time + '</span>')
                    }

                    if (window.gmb_start_date_time2 && window.gmb_end_date_time2) {
                        coupon_date.find('span').remove();
                        coupon_date.append('<span class="text-muted d-block text-center"><?php echo $this->lang->line('Valid'); ?> ' + window.gmb_start_date_time2 + ' - ' + window.gmb_end_date_time2 + '</span>');
                    }
                }

                if ('end_date_time' === elm.id) {
                    var end_date = moment($(this).val());
                    if (end_date.isValid()) {
                        window.gmb_end_date_time = end_date.format('MMM D HH:MM A');
                        window.gmb_end_date_time2 = end_date.format('D/M/YYYY HH:MM A');
                    }
                    if (window.gmb_start_date_time && window.gmb_end_date_time) {
                        date_time.find('span').remove();
                        date_time.append('<span class="text-muted small d-block text-left">' + window.gmb_start_date_time + '-' + window.gmb_end_date_time + '</span>')
                    }

                    if (window.gmb_start_date_time2 && window.gmb_end_date_time2) {
                        coupon_date.find('span').remove();
                        coupon_date.append('<span class="text-muted d-block text-center"><?php echo $this->lang->line('Valid'); ?> ' + window.gmb_start_date_time2 + ' - ' + window.gmb_end_date_time2 + '</span>');
                    }
                }

                // Handles OFFER post preview
                if ('offer_coupon_code' === elm.id) {
                    window.gmb_offer_coupon_code = $(this).val();
                    $(coupon_box).removeClass('d-none');
                    $('.preview_coupon_code').text(window.gmb_offer_coupon_code);
                }
                if ('offer_redeem_url' === elm.id) {
                    var redeem_text = '<?php echo $this->lang->line("Redeem Online"); ?>';
                    var redeem_url = '<a href="' + $(this).val() + '" target="_blank">' + redeem_text + '</a>';
                    window.gmb_offer_redeem_url = redeem_url;
                    $(link).html(redeem_url);
                }

                // Summery
                if ('emojionearea-editor' === elm.className) {
                    window.gmb_post_summery = elm.innerText;
                    if ('cta_post' === window.gmb_post_tab_type) {
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

        function findFileType(str) {
            var allowed_img_extension = ['.jpeg', '.jpg', '.png', '.gif'];
            var allowed_vid_extension = ['.flv', '.3gp', '.mp4', '.mov', '.avi', '.wmv'];
            var extension = str.substring(str.lastIndexOf('.'));

            var foundImg = allowed_img_extension.indexOf(extension);
            var foundVid = allowed_vid_extension.indexOf(extension);

            return (foundImg !== -1) ? 'image' : ((foundVid !== -1) ? 'video' : null);
        }

        // Uploads media
        $("#media_url_upload").uploadFile({
            url: base_url + "gmb/upload_post_media",
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
                var delete_url = "<?php echo site_url('gmb/delete_post_media'); ?>";
                $.post(delete_url, {op: 'delete', name: data},
                    function (resp, textStatus, jqXHR) {
                        if ('success' === textStatus) {
                            $('#media_url').val('');
                            $('.post_preview_block .preview_img').attr('src', gmb_dummy_img_url);
                            $('.post_preview_block .preview_img').show();
                        }
                    }
                );
            },
            onSuccess: function (files, data, xhr, pd) {
                var gmb_image_src = base_url + 'upload/xerobiz/' + data;
                $('#media_url').val(gmb_image_src);
                $('.post_preview_block .preview_img').attr('src', gmb_image_src);
            }
        });

        // Submits form data
        $(document).on('click', '#submit_post', function () {

            $(this).addClass('btn-progress');
            var that = $(this);

            var formData = new FormData($("#auto_poster_form")[0]);

            console.log(formData);

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
                                button: '<?php echo $this->lang->line("Ok"); ?>',
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