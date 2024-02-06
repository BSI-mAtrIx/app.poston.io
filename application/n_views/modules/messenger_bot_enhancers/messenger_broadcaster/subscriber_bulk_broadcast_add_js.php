<?php
$areyousure = $this->lang->line("Are you sure?");
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

    <script type="text/javascript">
        var base_url = "<?php echo base_url();?>";

        $(".schedule_block_item").hide();

        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });


        $(document).on('change', 'input[name=schedule_type]', function () {
            if ($("input[name=schedule_type]:checked").val() == "later")
                $(".schedule_block_item").show();
            else {
                $("#schedule_time").val("");
                $("#time_zone").val("");
                $(".schedule_block_item").hide();
            }
        });

        $(document).on('change', '#broadcast_type', function () {
            var broadcast_type = $(this).val();
            var schedule_type = $("input[name=schedule_type]:checked").val();
            if (broadcast_type != "Non Promo") {
                $("#message_tag_con").hide();
                $("#schedule_time_block").hide();
                $(".schedule_block_item ").hide();
            } else {
                $("#message_tag_con").show();
                $("#schedule_time_block").show();
                if (schedule_type == "later") $(".schedule_block_item").show();
                // $("#message_tag").val('NON_PROMOTIONAL_SUBSCRIPTION').trigger('change');
            }
        });

        $(document).ready(function (e) {

            $(document).on('click', '.media_template_modal', function () {
                $("#media_template_modal").modal();
            });

        });
    </script>


    <script type="text/javascript">


        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
        var base_url = "<?php echo site_url(); ?>";

        var js_array = [<?php echo '"' . implode('","', $postback_id_array) . '"' ?>];

        var areyousure = "<?php echo $areyousure;?>";

        var text_with_button_counter = 1;
        var generic_template_button_counter = 1;
        var carousel_template_counter = 1;

        function showerror(error_message) {
            swal.fire('<?php echo $this->lang->line("Warning"); ?>', error_message, 'warning');
        }

        $(document).ready(function () {

            $("#text_reply_1, #quick_reply_text_1, #text_with_buttons_input_1").emojioneArea({
                <?php if ($rtl_on) {
                    echo "dir: 'rtl',";
                } ?>
                autocomplete: false,
                pickerPosition: "bottom"
            });


            var multiple_template_add_button_counter = 1;
            $(document).on('click', '#multiple_template_add_button', function (e) {
                e.preventDefault();
                multiple_template_add_button_counter++
                $("#multiple_template_div_" + multiple_template_add_button_counter).show();
                if (multiple_template_add_button_counter == 3)
                    $("#multiple_template_add_button").hide();
            });

            var image_upload_limit = "<?php echo $image_upload_limit; ?>";
            var video_upload_limit = "<?php echo $video_upload_limit; ?>";
            var audio_upload_limit = "<?php echo $audio_upload_limit; ?>";
            var file_upload_limit = "<?php echo $file_upload_limit; ?>";

            <?php for($template_type = 1;$template_type <= 1;$template_type++){ ?>

            var template_type_order = "#template_type_<?php echo $template_type ?>";

            $(document).on('change', "#template_type_<?php echo $template_type ?>", function () {

                var selected_template = $("#template_type_<?php echo $template_type ?>").val();
                selected_template = selected_template.replace(/ /gi, "_");

                var template_type_array = ['text', 'image', 'audio', 'video', 'file', 'quick_reply', 'text_with_buttons', 'generic_template', 'carousel', 'list', 'media'];
                template_type_array.forEach(templates_hide_show_function);

                function templates_hide_show_function(item, index) {
                    var template_type_preview_div_name = "#" + item + "_preview_div";

                    // alert(template_type_preview_div_name);

                    var template_type_div_name = "#" + item + "_div_<?php echo $template_type; ?>";
                    if (selected_template == item) {
                        $(template_type_div_name).show();
                        $(template_type_preview_div_name).show();
                    } else {
                        $(template_type_div_name).hide();
                        $(template_type_preview_div_name).hide();
                    }


                    if (selected_template == 'text') {

                        $("#text_reply_<?php echo $template_type; ?>").emojioneArea({
                            <?php if ($rtl_on) {
                                echo "dir: 'rtl',";
                            } ?>
                            autocomplete: false,
                            pickerPosition: "bottom"
                        });
                    }


                    if (selected_template == 'media') {
                        $("#media_row_1_<?php echo $template_type; ?>").show();
                    }


                    if (selected_template == 'quick_reply') {
                        $("#quick_reply_row_1_<?php echo $template_type; ?>").show();

                        $("#quick_reply_text_<?php echo $template_type; ?>").emojioneArea({
                            <?php if ($rtl_on) {
                                echo "dir: 'rtl',";
                            } ?>
                            autocomplete: false,
                            pickerPosition: "bottom"
                        });

                    }

                    if (selected_template == 'text_with_buttons') {
                        $("#text_with_buttons_row_1_<?php echo $template_type; ?>").show();

                        $("#text_with_buttons_input_<?php echo $template_type; ?>").emojioneArea({
                            <?php if ($rtl_on) {
                                echo "dir: 'rtl',";
                            } ?>
                            autocomplete: false,
                            pickerPosition: "bottom"
                        });

                    }

                    if (selected_template == 'generic_template') {
                        $("#generic_template_row_1_<?php echo $template_type; ?>").show();
                    }

                    if (selected_template == 'carousel') {
                        $("#carousel_div_1_<?php echo $template_type; ?>").show();
                        $("#carousel_row_1_1_<?php echo $template_type; ?>").show();
                    }

                    if (selected_template == 'list') {
                        $("#list_div_1_<?php echo $template_type; ?>").show();
                        $("#list_div_2_<?php echo $template_type; ?>").show();
                    }

                }
            });

            $("#image_reply_<?php echo $template_type; ?>").uploadFile({
                url: base_url + "messenger_bot/upload_image_only",
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
                    var delete_url = "<?php echo site_url('messenger_bot/delete_uploaded_file');?>";
                    $.post(delete_url, {op: "delete", name: data},
                        function (resp, textStatus, jqXHR) {
                            $("#image_reply_field_<?php echo $template_type; ?>").val('');
                            $("#image_reply_div_<?php echo $template_type; ?>").hide();
                        });

                },
                onSuccess: function (files, data, xhr, pd) {
                    var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                    $("#image_reply_field_<?php echo $template_type; ?>").val(data_modified);
                    $("#image_reply_div_<?php echo $template_type; ?>").show().attr('src', data_modified);
                }
            });


            $("#video_reply_<?php echo $template_type; ?>").uploadFile({
                url: base_url + "messenger_bot/upload_live_video",
                fileName: "myfile",
                maxFileSize: video_upload_limit * 1024 * 1024,
                showPreview: false,
                returnType: "json",
                dragDrop: true,
                showDelete: true,
                multiple: false,
                maxFileCount: 1,
                acceptFiles: ".flv,.mp4,.wmv,.WMV,.MP4,.FLV",
                deleteCallback: function (data, pd) {
                    var delete_url = "<?php echo site_url('messenger_bot/delete_uploaded_live_file');?>";
                    $.post(delete_url, {op: "delete", name: data},
                        function (resp, textStatus, jqXHR) {
                            $("#video_reply_field_<?php echo $template_type; ?>").val('');
                            $("#video_tag_<?php echo $template_type; ?>").hide();
                        });

                },
                onSuccess: function (files, data, xhr, pd) {
                    var file_path = base_url + "upload/video/" + data;
                    $("#video_reply_field_<?php echo $template_type; ?>").val(file_path);
                    $("#video_tag_<?php echo $template_type; ?>").show();
                    $("#video_reply_div_<?php echo $template_type; ?>").attr('src', file_path);
                }
            });

            $("#audio_reply_<?php echo $template_type; ?>").uploadFile({
                url: base_url + "messenger_bot/upload_audio_file",
                fileName: "myfile",
                maxFileSize: audio_upload_limit * 1024 * 1024,
                showPreview: false,
                returnType: "json",
                dragDrop: true,
                showDelete: true,
                multiple: false,
                maxFileCount: 1,
                acceptFiles: ".amr,.mp3,.wav,.WAV,.MP3,.AMR",
                deleteCallback: function (data, pd) {
                    var delete_url = "<?php echo site_url('messenger_bot/delete_audio_file');?>";
                    $.post(delete_url, {op: "delete", name: data},
                        function (resp, textStatus, jqXHR) {
                            $("#audio_reply_field_<?php echo $template_type; ?>").val('');
                            $("#audio_tag_<?php echo $template_type; ?>").hide();
                        });

                },
                onSuccess: function (files, data, xhr, pd) {
                    var file_path = base_url + "upload/audio/" + data;
                    $("#audio_reply_field_<?php echo $template_type; ?>").val(file_path);
                    $("#audio_tag_<?php echo $template_type; ?>").show();
                    $("#audio_reply_div_<?php echo $template_type; ?>").attr('src', file_path);
                }
            });

            $("#file_reply_<?php echo $template_type; ?>").uploadFile({
                url: base_url + "messenger_bot/upload_general_file",
                fileName: "myfile",
                maxFileSize: file_upload_limit * 1024 * 1024,
                showPreview: false,
                returnType: "json",
                dragDrop: true,

                showDelete: true,
                multiple: false,
                maxFileCount: 1,
                acceptFiles: ".doc,.docx,.pdf,.txt,.ppt,.pptx,.xls,.xlsx,.DOC,.DOCX,.PDF,.TXT,.PPT,.PPTX,.XLS,.XLSX",
                deleteCallback: function (data, pd) {
                    var delete_url = "<?php echo site_url('messenger_bot/delete_general_file');?>";
                    $.post(delete_url, {op: "delete", name: data},
                        function (resp, textStatus, jqXHR) {
                            $("#file_reply_field_<?php echo $template_type; ?>").val('');
                        });

                },
                onSuccess: function (files, data, xhr, pd) {
                    var file_path = base_url + "upload/file/" + data;
                    $("#file_reply_field_<?php echo $template_type; ?>").val(file_path);
                }
            });

            $("#generic_image_<?php echo $template_type; ?>").uploadFile({
                url: base_url + "messenger_bot/upload_image_only",
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
                    var delete_url = "<?php echo site_url('messenger_bot/delete_uploaded_file');?>";
                    $.post(delete_url, {op: "delete", name: data},
                        function (resp, textStatus, jqXHR) {
                            $("#generic_template_image_<?php echo $template_type; ?>").val('');
                        });

                },
                onSuccess: function (files, data, xhr, pd) {
                    var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                    $("#generic_template_image_<?php echo $template_type; ?>").val(data_modified);
                }
            });


            <?php for($i = 1; $i <= 10; $i++) : ?>
            $("#generic_imageupload_<?php echo $i; ?>_<?php echo $template_type; ?>").uploadFile({
                url: base_url + "messenger_bot/upload_image_only",
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
                    var delete_url = "<?php echo site_url('messenger_bot/delete_uploaded_file');?>";
                    $.post(delete_url, {op: "delete", name: data},
                        function (resp, textStatus, jqXHR) {
                            $("#carousel_image_<?php echo $i; ?>_<?php echo $template_type; ?>").val('');
                        });

                },
                onSuccess: function (files, data, xhr, pd) {
                    var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                    $("#carousel_image_<?php echo $i; ?>_<?php echo $template_type; ?>").val(data_modified);
                }
            });
            <?php endfor; ?>


            <?php for($i = 1; $i <= 4; $i++) : ?>
            $("#list_imageupload_<?php echo $i; ?>_<?php echo $template_type; ?>").uploadFile({
                url: base_url + "messenger_bot/upload_image_only",
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
                    var delete_url = "<?php echo site_url('messenger_bot/delete_uploaded_file');?>";
                    $.post(delete_url, {op: "delete", name: data},
                        function (resp, textStatus, jqXHR) {
                            $("#list_image_<?php echo $i; ?>_<?php echo $template_type; ?>").val('');
                        });

                },
                onSuccess: function (files, data, xhr, pd) {
                    var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                    $("#list_image_<?php echo $i; ?>_<?php echo $template_type; ?>").val(data_modified);
                }
            });
            <?php endfor; ?>


            var media_counter_<?php echo $template_type; ?> = 1;

            $(document).on('click', "#media_add_button_<?php echo $template_type; ?>", function (e) {
                e.preventDefault();

                var button_id = media_counter_<?php echo $template_type; ?>;
                var media_text = "#media_text_" + button_id + "_<?php echo $template_type; ?>";
                var media_type = "#media_type_" + button_id + "_<?php echo $template_type; ?>";

                var media_text_check = $(media_text).val();
                if (media_text_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                    return;
                }

                var media_type_check = $(media_type).val();
                if (media_type_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                    return;
                } else if (media_type_check == 'post_back') {

                    var media_post_id = "#media_post_id_" + button_id + "_<?php echo $template_type; ?>";
                    var media_post_id_check = $(media_post_id).val();
                    if (media_post_id_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                        return;
                    }


                } else if (media_type_check == 'web_url' || media_type_check == 'web_url_compact' || media_type_check == 'web_url_tall' || media_type_check == 'web_url_full') {
                    var media_web_url = "#media_web_url_" + button_id + "_<?php echo $template_type; ?>";
                    var media_web_url_check = $(media_web_url).val();
                    if (media_web_url_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                        return;
                    }
                } else if (media_type_check == 'phone_number') {
                    var media_call_us = "#media_call_us_" + button_id + "_<?php echo $template_type; ?>";
                    var media_call_us_check = $(media_call_us).val();
                    if (media_call_us_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                        return;
                    }
                }

                media_counter_<?php echo $template_type; ?>++;

                // remove button hide for current div and show for next div
                $(media_type).parent().parent().next().next().hide();
                var next_item_remove_parent_div = $(media_type).parent().parent().parent().next().attr('id');
                $("#" + next_item_remove_parent_div + " div:last").show();

                var x = media_counter_<?php echo $template_type; ?>;
                $("#media_row_" + x + "_<?php echo $template_type; ?>").show();
                if (media_counter_<?php echo $template_type; ?> == 3)
                    $("#media_add_button_<?php echo $template_type; ?>").hide();
            });


            var quick_reply_button_counter_<?php echo $template_type; ?> = 1;

            $(document).on('click', "#quick_reply_add_button_<?php echo $template_type; ?>", function (e) {
                e.preventDefault();

                var button_id = quick_reply_button_counter_<?php echo $template_type; ?>;
                var quick_reply_button_text = "#quick_reply_button_text_" + button_id + "_<?php echo $template_type; ?>";
                var quick_reply_post_id = "#quick_reply_post_id_" + button_id + "_<?php echo $template_type; ?>";
                var quick_reply_button_type = "#quick_reply_button_type_" + button_id + "_<?php echo $template_type; ?>";

                quick_reply_button_type = $(quick_reply_button_type).val();

                var quick_reply_post_id_check = $(quick_reply_post_id).val();
                if (quick_reply_button_type == 'post_back') {
                    if (quick_reply_post_id_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                        return;
                    }

                    var quick_reply_button_text_check = $(quick_reply_button_text).val();

                    if (quick_reply_button_text_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                        return;
                    }

                }
                if (quick_reply_button_type == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                    return;
                }


                quick_reply_button_counter_<?php echo $template_type; ?>++;

                // remove button hide for current div and show for next div
                var div_id = "#quick_reply_button_type_" + button_id + "_<?php echo $template_type; ?>";
                $(div_id).parent().parent().next().next().hide();
                var next_item_remove_parent_div = $(div_id).parent().parent().parent().next().attr('id');
                $("#" + next_item_remove_parent_div + " div:last").show();

                var x = quick_reply_button_counter_<?php echo $template_type; ?>;
                $("#quick_reply_row_" + x + "_<?php echo $template_type; ?>").show();

                if (quick_reply_button_counter_<?php echo $template_type; ?> == 3)
                    $("#quick_reply_add_button_<?php echo $template_type; ?>").hide();

            });


            var text_with_button_counter_<?php echo $template_type; ?> = 1;

            $(document).on('click', "#text_with_button_add_button_<?php echo $template_type; ?>", function (e) {
                e.preventDefault();

                var button_id = text_with_button_counter_<?php echo $template_type; ?>;
                var text_with_buttons_text = "#text_with_buttons_text_" + button_id + "_<?php echo $template_type; ?>";
                var text_with_button_type = "#text_with_button_type_" + button_id + "_<?php echo $template_type; ?>";

                var text_with_buttons_text_check = $(text_with_buttons_text).val();
                if (text_with_buttons_text_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                    return;
                }

                var text_with_button_type_check = $(text_with_button_type).val();
                if (text_with_button_type_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                    return;
                } else if (text_with_button_type_check == 'post_back') {

                    var text_with_button_post_id = "#text_with_button_post_id_" + button_id + "_<?php echo $template_type; ?>";
                    var text_with_button_post_id_check = $(text_with_button_post_id).val();
                    if (text_with_button_post_id_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                        return;
                    }
                } else if (text_with_button_type_check == 'web_url' || text_with_button_type_check == 'web_url_compact' || text_with_button_type_check == 'web_url_tall' || text_with_button_type_check == 'web_url_full') {
                    var text_with_button_web_url = "#text_with_button_web_url_" + button_id + "_<?php echo $template_type; ?>";
                    var text_with_button_web_url_check = $(text_with_button_web_url).val();
                    if (text_with_button_web_url_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                        return;
                    }
                } else if (text_with_button_type_check == 'phone_number') {
                    var text_with_button_call_us = "#text_with_button_call_us_" + button_id + "_<?php echo $template_type; ?>";
                    var text_with_button_call_us_check = $(text_with_button_call_us).val();
                    if (text_with_button_call_us_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                        return;
                    }
                }

                text_with_button_counter_<?php echo $template_type; ?>++;

                // remove button hide for current div and show for next div
                $(text_with_button_type).parent().parent().next().next().hide();
                var next_item_remove_parent_div = $(text_with_button_type).parent().parent().parent().next().attr('id');
                $("#" + next_item_remove_parent_div + " div:last").show();

                var x = text_with_button_counter_<?php echo $template_type; ?>;
                $("#text_with_buttons_row_" + x + "_<?php echo $template_type; ?>").show();
                if (text_with_button_counter_<?php echo $template_type; ?> == 3)
                    $("#text_with_button_add_button_<?php echo $template_type; ?>").hide();
            });


            var generic_with_button_counter_<?php echo $template_type; ?> = 1;

            $(document).on('click', "#generic_template_add_button_<?php echo $template_type; ?>", function (e) {
                e.preventDefault();

                var button_id = generic_with_button_counter_<?php echo $template_type; ?>;
                var generic_template_button_text = "#generic_template_button_text_" + button_id + "_<?php echo $template_type; ?>";
                var generic_template_button_type = "#generic_template_button_type_" + button_id + "_<?php echo $template_type; ?>";

                var generic_template_button_text_check = $(generic_template_button_text).val();
                if (generic_template_button_text_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                    return;
                }

                var generic_template_button_type_check = $(generic_template_button_type).val();
                if (generic_template_button_type_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                    return;
                } else if (generic_template_button_type_check == 'post_back') {

                    var generic_template_button_post_id = "#generic_template_button_post_id_" + button_id + "_<?php echo $template_type; ?>";
                    var generic_template_button_post_id_check = $(generic_template_button_post_id).val();
                    if (generic_template_button_post_id_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                        return;
                    }

                } else if (generic_template_button_type_check == 'web_url' || generic_template_button_type_check == 'web_url_full' || generic_template_button_type_check == 'web_url_compact' || generic_template_button_type_check == 'web_url_tall') {

                    var generic_template_button_web_url = "#generic_template_button_web_url_" + button_id + "_<?php echo $template_type; ?>";
                    var generic_template_button_web_url_check = $(generic_template_button_web_url).val();
                    if (generic_template_button_web_url_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                        return;
                    }
                } else if (generic_template_button_type_check == 'phone_number') {
                    var generic_template_button_call_us = "#generic_template_button_call_us_" + button_id + "_<?php echo $template_type; ?>";
                    var generic_template_button_call_us_check = $(generic_template_button_call_us).val();
                    if (generic_template_button_call_us_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                        return;
                    }
                }

                generic_with_button_counter_<?php echo $template_type; ?>++;

                // remove button hide for current div and show for next div
                $(generic_template_button_type).parent().parent().next().next().hide();
                var next_item_remove_parent_div = $(generic_template_button_type).parent().parent().parent().next().attr('id');
                $("#" + next_item_remove_parent_div + " div:last").show();

                var x = generic_with_button_counter_<?php echo $template_type; ?>;

                $("#generic_template_row_" + x + "_<?php echo $template_type; ?>").show();
                if (generic_with_button_counter_<?php echo $template_type; ?> == 3)
                    $("#generic_template_add_button_<?php echo $template_type; ?>").hide();
            });


            <?php for($j = 1; $j <= 10; $j++) : ?>

            var carousel_add_button_counter_<?php echo $j; ?>_<?php echo $template_type; ?> = 1;

            $(document).on('click', "#carousel_add_button_<?php echo $j; ?>_<?php echo $template_type; ?>", function (e) {
                e.preventDefault();

                var y = carousel_add_button_counter_<?php echo $j; ?>_<?php echo $template_type; ?>;

                var carousel_button_text = "#carousel_button_text_<?php echo $j; ?>_" + y + "_<?php echo $template_type; ?>";
                var carousel_button_type = "#carousel_button_type_<?php echo $j; ?>_" + y + "_<?php echo $template_type; ?>";

                var carousel_button_text_check = $(carousel_button_text).val();
                if (carousel_button_text_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                    return;
                }

                var carousel_button_type_check = $(carousel_button_type).val();
                if (carousel_button_type_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                    return;
                } else if (carousel_button_type_check == 'post_back') {

                    var carousel_button_post_id = "#carousel_button_post_id_<?php echo $j;?>_" + y + "_<?php echo $template_type; ?>";
                    var carousel_button_post_id_check = $(carousel_button_post_id).val();
                    if (carousel_button_post_id_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                        return;
                    }
                } else if (carousel_button_type_check == 'web_url' || carousel_button_type_check == 'web_url_compact' || carousel_button_type_check == 'web_url_tall' || carousel_button_type_check == 'web_url_full') {

                    var carousel_button_web_url = "#carousel_button_web_url_<?php echo $j;?>_" + y + "_<?php echo $template_type; ?>";
                    var carousel_button_web_url_check = $(carousel_button_web_url).val();
                    if (carousel_button_web_url_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                        return;
                    }
                } else if (carousel_button_type_check == 'phone_number') {
                    var carousel_button_call_us = "#carousel_button_call_us_<?php echo $j;?>_" + y + "_<?php echo $template_type; ?>";
                    var carousel_button_call_us_check = $(carousel_button_call_us).val();
                    if (carousel_button_call_us_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                        return;
                    }
                }

                carousel_add_button_counter_<?php echo $j; ?>_<?php echo $template_type; ?> ++;

                // remove button hide for current div and show for next div
                $(carousel_button_type).parent().parent().next().next().hide();
                var next_item_remove_parent_div = $(carousel_button_type).parent().parent().parent().next().attr('id');
                $("#" + next_item_remove_parent_div + " div:last").show();

                var x = carousel_add_button_counter_<?php echo $j; ?>_<?php echo $template_type; ?>;

                $("#carousel_row_<?php echo $j; ?>_" + x + "_<?php echo $template_type; ?>").show();
                if (carousel_add_button_counter_<?php echo $j; ?>_<?php echo $template_type; ?> == 3)
                    $("#carousel_add_button_<?php echo $j; ?>_<?php echo $template_type; ?>").hide();

            });
            <?php endfor; ?>


            var carousel_template_counter_<?php echo $template_type; ?>= 1;

            $(document).on('click', '#carousel_template_add_button_<?php echo $template_type; ?>', function (e) {
                e.preventDefault();

                var carousel_image = "#carousel_image_" + carousel_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
                var carousel_image_check = $(carousel_image).val();


                var carousel_title = "#carousel_title_" + carousel_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
                var carousel_title_check = $(carousel_title).val();
                if (carousel_title_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide carousel title')?>");

                    return;
                }

                var carousel_subtitle = "#carousel_subtitle_" + carousel_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
                var carousel_subtitle_check = $(carousel_subtitle).val();


                var carousel_image_destination_link = "#carousel_image_destination_link_" + carousel_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
                var carousel_image_destination_link_check = $(carousel_image_destination_link).val();

                carousel_template_counter_<?php echo $template_type; ?>++;

                var x = carousel_template_counter_<?php echo $template_type; ?>;

                $("#carousel_div_" + x + "_<?php echo $template_type; ?>").show();
                $("#carousel_row_" + x + "_1" + "_<?php echo $template_type; ?>").show();
                if (carousel_template_counter_<?php echo $template_type; ?> == 10)
                    $("#carousel_template_add_button_<?php echo $template_type; ?>").hide();
            });


            var list_template_counter_<?php echo $template_type; ?>= 2;

            $(document).on('click', '#list_template_add_button_<?php echo $template_type; ?>', function (e) {
                e.preventDefault();

                var list_button_text = "#list_with_buttons_text_<?php echo $template_type; ?>";
                var list_button_type = "#list_with_button_type_<?php echo $template_type; ?>";

                var list_button_text_check = $(list_button_text).val();
                if (list_button_text_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                    return;
                }

                var list_button_type_check = $(list_button_type).val();
                if (list_button_type_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                    return;
                } else if (list_button_type_check == 'post_back') {

                    var list_button_post_id = "#list_with_button_post_id_<?php echo $template_type; ?>";
                    var list_button_post_id_check = $(list_button_post_id).val();
                    if (list_button_post_id_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                        return;
                    }
                } else if (list_button_type_check == 'web_url' || list_button_type_check == 'web_url_full' || list_button_type_check == 'web_url_tall' || list_button_type_check == 'web_url_compact') {

                    var list_button_web_url = "#list_with_button_web_url_<?php echo $template_type; ?>";
                    var list_button_web_url_check = $(list_button_web_url).val();
                    if (list_button_web_url_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                        return;
                    }
                } else if (list_button_type_check == 'phone_number') {
                    var list_button_call_us = "#list_with_button_call_us_<?php echo $template_type; ?>";
                    var list_button_call_us_check = $(list_button_call_us).val();
                    if (list_button_call_us_check == '') {
                        showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                        return;
                    }
                }


                var prev_list_image_counter = eval(list_template_counter_<?php echo $template_type; ?>+ "-1");
                var list_image_1 = "#list_image_" + prev_list_image_counter + "_" +<?php echo $template_type; ?>;
                var list_image_check_1 = $(list_image_1).val();
                if (list_image_check_1 == '') {
                    showerror("<?php echo $this->lang->line('Please provide your reply image')?>");

                    return;
                }

                var list_image = "#list_image_" + list_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
                var list_image_check = $(list_image).val();
                if (list_image_check == '') {
                    showerror("<?php echo $this->lang->line('Please provide your reply image')?>");

                    return;
                }

                var prev_list_title_counter = eval(list_template_counter_<?php echo $template_type; ?>+ "-1");
                var list_title_1 = "#list_title_" + prev_list_title_counter + "_" +<?php echo $template_type; ?>;
                var list_title_check_1 = $(list_title_1).val();
                if (list_title_check_1 == '') {
                    showerror("<?php echo $this->lang->line('Please Provide list title')?>");

                    return;
                }

                var list_title = "#list_title_" + list_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
                var list_title_check = $(list_title).val();
                if (list_title_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide list title')?>");

                    return;
                }

                var prev_list_dest_counter = eval(list_template_counter_<?php echo $template_type; ?>+ "-1");
                var list_image_destination_link_1 = "#list_image_destination_link_" + prev_list_dest_counter + "_" +<?php echo $template_type; ?>;
                var list_image_destination_link_check_1 = $(list_image_destination_link_1).val();
                if (list_image_destination_link_check_1 == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Image Click Destination Link')?>");

                    return;
                }

                var list_image_destination_link = "#list_image_destination_link_" + list_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
                var list_image_destination_link_check = $(list_image_destination_link).val();
                if (list_image_destination_link_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Image Click Destination Link')?>");

                    return;
                }

                list_template_counter_<?php echo $template_type; ?>++;

                var x = list_template_counter_<?php echo $template_type; ?>;

                $("#list_div_" + x + "_<?php echo $template_type; ?>").show();
                if (list_template_counter_<?php echo $template_type; ?> == 4)
                    $("#list_template_add_button_<?php echo $template_type; ?>").hide();
            });

            <?php } ?>


            $(document).on('change', '.media_type_class', function () {
                var button_type = $(this).val();
                var which_number_is_clicked = $(this).attr('id');
                which_number_is_clicked_main = which_number_is_clicked.split('_');
                which_number_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 2];
                var which_block_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 1];

                if (button_type == 'post_back') {
                    $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " input").val("");
                    $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#media_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#media_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    var option_id = $(this).children(":selected").attr("id");
                    if (option_id == "unsubscribe_postback") {
                        $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " input").val("UNSUBSCRIBE_QUICK_BOXER");
                        $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    }
                    if (option_id == "resubscribe_postback") {
                        $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " input").val("RESUBSCRIBE_QUICK_BOXER");
                        $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    }
                } else if (button_type == 'web_url' || button_type == 'web_url_compact' || button_type == 'web_url_tall' || button_type == 'web_url_full') {
                    $("#media_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#media_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                } else if (button_type == 'phone_number') {
                    $("#media_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#media_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                } else {
                    $("#media_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#media_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#media_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
            });


            $(document).on('change', '.quick_reply_button_type_class', function () {
                var button_type = $(this).val();
                var which_number_is_clicked = $(this).attr('id');
                var which_block_is_clicked = "";

                which_number_is_clicked_main = which_number_is_clicked.split('_');
                which_number_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 2];
                which_block_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 1];

                if (button_type == 'post_back') {
                    $("#quick_reply_button_text_" + which_number_is_clicked + "_" + which_block_is_clicked).removeAttr('readonly');
                    $("#quick_reply_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                } else {
                    $("#quick_reply_button_text_" + which_number_is_clicked + "_" + which_block_is_clicked).attr('readonly', 'readonly');
                    $("#quick_reply_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                // alert(which_number_is_clicked);
            });


            $(document).on('change', '.text_with_button_type_class', function () {
                var button_type = $(this).val();
                var which_number_is_clicked = $(this).attr('id');
                which_number_is_clicked_main = which_number_is_clicked.split('_');
                which_number_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 2];
                var which_block_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 1];

                if (button_type == 'post_back') {
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='UNSUBSCRIBE_QUICK_BOXER']").remove();
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#text_with_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#text_with_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    var option_id = $(this).children(":selected").attr("id");
                    if (option_id == "unsubscribe_postback") {
                        $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "UNSUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('unsubscribe');?>"));
                        $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("UNSUBSCRIBE_QUICK_BOXER");
                        $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    }
                } else if (button_type == 'web_url' || button_type == 'web_url_compact' || button_type == 'web_url_tall' || button_type == 'web_url_full') {
                    $("#text_with_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#text_with_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                } else if (button_type == 'phone_number') {
                    $("#text_with_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#text_with_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                } else {
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#text_with_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#text_with_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                // alert(which_number_is_clicked);
            });


            $(document).on('change', '.generic_template_button_type_class', function () {
                var button_type = $(this).val();
                var which_number_is_clicked = $(this).attr('id');
                which_number_is_clicked_main = which_number_is_clicked.split('_');
                which_number_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 2];
                which_block_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 1];

                if (button_type == 'post_back') {
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='UNSUBSCRIBE_QUICK_BOXER']").remove();
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#generic_template_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#generic_template_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    var option_id = $(this).children(":selected").attr("id");
                    if (option_id == "unsubscribe_postback") {
                        $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "UNSUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('unsubscribe');?>"));
                        $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("UNSUBSCRIBE_QUICK_BOXER");
                        $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    }
                } else if (button_type == 'web_url' || button_type == 'web_url_compact' || button_type == 'web_url_tall' || button_type == 'web_url_full') {
                    $("#generic_template_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#generic_template_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                } else if (button_type == 'phone_number') {
                    $("#generic_template_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                    $("#generic_template_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                } else {
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#generic_template_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                    $("#generic_template_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                // alert(which_number_is_clicked);
            });


            $(document).on('change', '.carousel_button_type_class', function () {
                var button_type = $(this).val();
                var which_number_is_clicked = $(this).attr('id');
                which_number_is_clicked = which_number_is_clicked.split('_');

                var first = which_number_is_clicked[which_number_is_clicked.length - 2];
                var second = which_number_is_clicked[which_number_is_clicked.length - 3];

                var block_template_third = which_number_is_clicked[which_number_is_clicked.length - 1];

                if (button_type == 'post_back') {
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select option[value='UNSUBSCRIBE_QUICK_BOXER']").remove();
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).show();
                    $("#carousel_button_web_url_div_" + second + "_" + first + "_" + block_template_third).hide();
                    $("#carousel_button_call_us_div_" + second + "_" + first + "_" + block_template_third).hide();
                    var option_id = $(this).children(":selected").attr("id");
                    if (option_id == "unsubscribe_postback") {
                        $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").append($("<option></option>").attr("value", "UNSUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('unsubscribe');?>"));
                        $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").val("UNSUBSCRIBE_QUICK_BOXER");
                        $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).hide();

                    }
                } else if (button_type == 'web_url' || button_type == 'web_url_compact' || button_type == 'web_url_tall' || button_type == 'web_url_full') {
                    $("#carousel_button_web_url_div_" + second + "_" + first + "_" + block_template_third).show();
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).hide();
                    $("#carousel_button_call_us_div_" + second + "_" + first + "_" + block_template_third).hide();
                } else if (button_type == 'phone_number') {
                    $("#carousel_button_call_us_div_" + second + "_" + first + "_" + block_template_third).show();
                    $("#carousel_button_web_url_div_" + second + "_" + first + "_" + block_template_third).hide();
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).hide();
                } else {
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).hide();
                    $("#carousel_button_web_url_div_" + second + "_" + first + "_" + block_template_third).hide();
                    $("#carousel_button_call_us_div_" + second + "_" + first + "_" + block_template_third).hide();
                }
                // alert(which_number_is_clicked);
            });


            $(document).on('change', '.list_with_button_type_class', function () {
                var button_type = $(this).val();
                var which_number_is_clicked = $(this).attr('id');
                which_number_is_clicked_main = which_number_is_clicked.split('_');
                var which_block_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 1];

                if (button_type == 'post_back') {
                    $("#list_with_button_postid_div_" + which_block_is_clicked + " input").val("");
                    $("#list_with_button_postid_div_" + which_block_is_clicked).show();
                    $("#list_with_button_web_url_div_" + which_block_is_clicked).hide();
                    $("#list_with_button_call_us_div_" + which_block_is_clicked).hide();
                    var option_id = $(this).children(":selected").attr("id");
                    if (option_id == "unsubscribe_postback") {
                        $("#list_with_button_postid_div_" + which_block_is_clicked + " input").val("UNSUBSCRIBE_QUICK_BOXER");
                        $("#list_with_button_postid_div_" + which_block_is_clicked).hide();
                    }
                    if (option_id == "resubscribe_postback") {
                        $("#list_with_button_postid_div_" + which_block_is_clicked + " input").val("RESUBSCRIBE_QUICK_BOXER");
                        $("#list_with_button_postid_div_" + which_block_is_clicked).hide();
                    }
                } else if (button_type == 'web_url' || button_type == 'web_url_compact' || button_type == 'web_url_tall' || button_type == 'web_url_full') {
                    $("#list_with_button_web_url_div_" + which_block_is_clicked).show();
                    $("#list_with_button_postid_div_" + which_block_is_clicked).hide();
                    $("#list_with_button_call_us_div_" + which_block_is_clicked).hide();
                } else if (button_type == 'phone_number') {
                    $("#list_with_button_call_us_div_" + which_block_is_clicked).show();
                    $("#list_with_button_postid_div_" + which_block_is_clicked).hide();
                    $("#list_with_button_web_url_div_" + which_block_is_clicked).hide();
                } else {
                    $("#list_with_button_postid_div_" + which_block_is_clicked).hide();
                    $("#list_with_button_web_url_div_" + which_block_is_clicked).hide();
                    $("#list_with_button_call_us_div_" + which_block_is_clicked).hide();
                }
            });


            $(document).on('click', '.item_remove', function () {
                var counter_variable = $(this).attr('counter_variable');
                var row_id = $(this).attr('row_id');

                var first_column_id = $(this).attr('first_column_id');
                var second_column_id = $(this).attr('second_column_id');
                var add_more_button_id = $(this).attr('add_more_button_id');

                var item_remove_postback = $(this).attr('third_postback');
                var item_remove_weburl = $(this).attr('third_weburl');
                var item_remove_callus = $(this).attr('third_callus');

                $("#" + first_column_id).val('');
                $("#" + first_column_id).removeAttr('readonly');
                var item_remove_button_type = $("#" + second_column_id).val();
                $("#" + second_column_id).val('');

                if (item_remove_button_type == 'post_back') {
                    $("#" + item_remove_postback).val('');
                } else if (item_remove_button_type == 'web_url' || item_remove_button_type == 'web_url_compact' || item_remove_button_type == 'web_url_full' || item_remove_button_type == 'web_url_tall' || item_remove_button_type == 'web_url_birthday') {
                    $("#" + item_remove_weburl).val('');
                } else
                    $("#" + item_remove_callus).val('');

                $("#" + row_id).hide();
                eval(counter_variable + "--");
                var temp = eval(counter_variable);

                if (temp != 1) {
                    var previous_item_remove_div = $("#" + row_id).prev('div').attr('id');
                    $("#" + previous_item_remove_div + " div:last").show();
                }
                $(this).parent().hide();

                if (temp < 3) $("#" + add_more_button_id).show();

            });


            $(document).on('click', '#submit', function (e) {
                e.preventDefault();

                var campaign_name = $("#campaign_name").val();
                $("#error_message").addClass("hidden");

                if (campaign_name == "") {
                    showerror("<?php echo $this->lang->line('Please give a campaign name')?>");

                    return;
                }

                if ($("#page").val() == "") {
                    showerror("<?php echo $this->lang->line('Please select a page first')?>");

                    return;
                }

                if ($("#broadcast_type").val() == "Non Promo" && $("#message_tag").val() == "") {
                    showerror("<?php echo $this->lang->line('Please select a message tag')?>");
                    return;
                }

                var page_subscriber = parseInt($("#page_subscriber").html());
                if (page_subscriber == 0 || page_subscriber == "") {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Page does not have any subscriber to send message."); ?>', 'warning');
                    return;
                }

                for (var m = 1; m <= multiple_template_add_button_counter; m++) {
                    var template_type = $("#template_type_" + m).val();

                    if (template_type == 'text') {
                        var text_reply = $("#text_reply_" + m).val();
                        if (text_reply == '') {
                            showerror("<?php echo $this->lang->line('Please provide your message')?>");

                            return;
                        }
                    }

                    if (template_type == "image") {
                        var image_reply_field = $("#image_reply_field_" + m).val();
                        if (image_reply_field == '') {
                            showerror("<?php echo $this->lang->line('Please provide your image')?>");

                            return;
                        }
                    }

                    if (template_type == "audio") {
                        var audio_reply_field = $("#audio_reply_field_" + m).val();
                        if (audio_reply_field == '') {
                            showerror("<?php echo $this->lang->line('Please provide your audio')?>");

                            return;
                        }
                    }

                    if (template_type == "video") {
                        var video_reply_field = $("#video_reply_field_" + m).val();
                        if (video_reply_field == '') {
                            showerror("<?php echo $this->lang->line('Please provide your video')?>");

                            return;
                        }
                    }


                    if (template_type == "file") {
                        var file_reply_field = $("#file_reply_field_" + m).val();
                        if (file_reply_field == '') {
                            showerror("<?php echo $this->lang->line('Please provide your file')?>");

                            return;
                        }
                    }


                    if (template_type == "media") {
                        var media_input = $("#media_input_" + m).val();
                        if (media_input == '') {
                            showerror("<?php echo $this->lang->line('Please Provide Your Media URL')?>");

                            return;
                        }

                        var facebook_url = media_input.match(/business.facebook.com/g);
                        var facebook_url2 = media_input.match(/www.facebook.com/g);

                        if (facebook_url == null && facebook_url2 == null) {
                            showerror("<?php echo $this->lang->line('Please provide Facebook content URL as Media URL')?>");

                            return;
                        }

                        var submited_media_counter = eval("media_counter_" + m);

                        for (var n = 1; n <= submited_media_counter; n++) {

                            var media_text = "#media_text_" + n + "_" + m;
                            var media_type = "#media_type_" + n + "_" + m;

                            var media_text_check = $(media_text).val();
                            if (media_text_check == '') {
                                showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                                return;
                            }

                            var media_type_check = $(media_type).val();
                            if (media_type_check == '') {
                                showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                                return;
                            } else if (media_type_check == 'post_back') {

                                var media_post_id = "#media_post_id_" + n + "_" + m;
                                var media_post_id_check = $(media_post_id).val();
                                if (media_post_id_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                                    return;
                                }


                            } else if (media_type_check == 'web_url' || media_type_check == 'web_url_compact' || media_type_check == 'web_url_tall' || media_type_check == 'web_url_full') {
                                var media_web_url = "#media_web_url_" + n + "_" + m;
                                var media_web_url_check = $(media_web_url).val();
                                if (media_web_url_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                                    return;
                                }
                            } else if (media_type_check == 'phone_number') {
                                var media_call_us = "#media_call_us_" + n + "_" + m;
                                var media_call_us_check = $(media_call_us).val();
                                if (media_call_us_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                                    return;
                                }
                            }
                        }

                    }

                    if (template_type == "quick reply") {
                        var quick_reply_text = $("#quick_reply_text_" + m).val();
                        if (quick_reply_text == '') {
                            showerror("<?php echo $this->lang->line('Please provide your message')?>");

                            return;
                        }
                        var submited_quick_reply_button_counter = eval("quick_reply_button_counter_" + m);

                        for (var n = 1; n <= submited_quick_reply_button_counter; n++) {
                            var quick_reply_button_text = "#quick_reply_button_text_" + n + "_" + m;
                            var quick_reply_post_id = "#quick_reply_post_id_" + n + "_" + m;
                            var quick_reply_button_type = "#quick_reply_button_type_" + n + "_" + m;

                            quick_reply_button_type = $(quick_reply_button_type).val();

                            var quick_reply_post_id_check = $(quick_reply_post_id).val();
                            if (quick_reply_button_type == 'post_back') {
                                if (quick_reply_post_id_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                                    return;
                                }

                                var quick_reply_button_text_check = $(quick_reply_button_text).val();

                                if (quick_reply_button_text_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                                    return;
                                }

                            }
                            if (quick_reply_button_type == '') {
                                showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                                return;
                            }
                        }
                    }


                    if (template_type == "text with buttons") {
                        var text_with_buttons_input = $("#text_with_buttons_input_" + m).val();
                        if (text_with_buttons_input == '') {
                            showerror("<?php echo $this->lang->line('Please provide your message')?>");

                            return;
                        }

                        var submited_text_with_button_counter = eval("text_with_button_counter_" + m);

                        for (var n = 1; n <= submited_text_with_button_counter; n++) {

                            var text_with_buttons_text = "#text_with_buttons_text_" + n + "_" + m;
                            var text_with_button_type = "#text_with_button_type_" + n + "_" + m;

                            var text_with_buttons_text_check = $(text_with_buttons_text).val();
                            if (text_with_buttons_text_check == '') {
                                showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                                return;
                            }

                            var text_with_button_type_check = $(text_with_button_type).val();
                            if (text_with_button_type_check == '') {
                                showerror("<?php echo $this->lang->line('Please Provide Your Button Type')?>");

                                return;
                            } else if (text_with_button_type_check == 'post_back') {

                                var text_with_button_post_id = "#text_with_button_post_id_" + n + "_" + m;
                                var text_with_button_post_id_check = $(text_with_button_post_id).val();
                                if (text_with_button_post_id_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                                    return;
                                }
                            } else if (text_with_button_type_check == 'web_url' || text_with_button_type_check == 'web_url_compact' || text_with_button_type_check == 'web_url_tall' || text_with_button_type_check == 'web_url_full') {
                                var text_with_button_web_url = "#text_with_button_web_url_" + n + "_" + m;
                                var text_with_button_web_url_check = $(text_with_button_web_url).val();
                                if (text_with_button_web_url_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                                    return;
                                }
                            } else if (text_with_button_type_check == 'phone_number') {
                                var text_with_button_call_us = "#text_with_button_call_us_" + n + "_" + m;
                                var text_with_button_call_us_check = $(text_with_button_call_us).val();
                                if (text_with_button_call_us_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                                    return;
                                }
                            }
                        }

                    }

                    if (template_type == "generic template") {
                        var generic_template_image = $("#generic_template_image_" + m).val();

                        var generic_template_title = $("#generic_template_title_" + m).val();
                        if (generic_template_title == '') {
                            showerror("<?php echo $this->lang->line('Please give the title')?>");

                            return;
                        }

                        var generic_template_subtitle = $("#generic_template_subtitle_" + m).val();

                        var submited_generic_button_counter = eval("generic_with_button_counter_" + m);
                        for (var n = 1; n <= submited_generic_button_counter; n++) {
                            var generic_template_button_text = "#generic_template_button_text_" + n + "_" + m;
                            var generic_template_button_type = "#generic_template_button_type_" + n + "_" + m;

                            var generic_template_button_text_check = $(generic_template_button_text).val();
                            var generic_template_button_type_check = $(generic_template_button_type).val();

                            if (generic_template_button_text_check == '' && generic_template_button_type_check != '') {
                                showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                                return;
                            }

                            if (generic_template_button_type_check == 'post_back') {

                                var generic_template_button_post_id = "#generic_template_button_post_id_" + n + "_" + m;
                                var generic_template_button_post_id_check = $(generic_template_button_post_id).val();
                                if (generic_template_button_post_id_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                                    return;
                                }

                            } else if (generic_template_button_type_check == 'web_url' || generic_template_button_type_check == 'web_url_full' || generic_template_button_type_check == 'web_url_compact' || generic_template_button_type_check == 'web_url_tall') {

                                var generic_template_button_web_url = "#generic_template_button_web_url_" + n + "_" + m;
                                var generic_template_button_web_url_check = $(generic_template_button_web_url).val();
                                if (generic_template_button_web_url_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                                    return;
                                }
                            } else if (generic_template_button_type_check == 'phone_number') {
                                var generic_template_button_call_us = "#generic_template_button_call_us_" + n + "_" + m;
                                var generic_template_button_call_us_check = $(generic_template_button_call_us).val();
                                if (generic_template_button_call_us_check == '') {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                                    return;
                                }
                            }
                        }

                    }


                    if (template_type == "carousel") {
                        var submited_carousel_template_counter = eval("carousel_template_counter_" + m);
                        for (var n = 1; n <= submited_carousel_template_counter; n++) {
                            var carousel_image = "#carousel_image_" + n + "_" + m;
                            var carousel_image_check = $(carousel_image).val();


                            var carousel_title = "#carousel_title_" + n + "_" + m;
                            var carousel_title_check = $(carousel_title).val();
                            if (carousel_title_check == '') {
                                showerror("<?php echo $this->lang->line('Please Provide carousel title')?>");

                                return;
                            }

                            var carousel_subtitle = "#carousel_subtitle_" + n + "_" + m;
                            var carousel_subtitle_check = $(carousel_subtitle).val();

                            var carousel_image_destination_link = "#carousel_image_destination_link_" + n + "_" + m;
                            var carousel_image_destination_link_check = $(carousel_image_destination_link).val();

                        }

                        <?php for($j = 1; $j <= 5; $j++) : ?>
                        var submited_carousel_add_button_counter = eval("carousel_add_button_counter_<?php echo $j; ?>_" + m);
                        for (var n = 1; n <= submited_carousel_add_button_counter; n++) {
                            var carousel_button_text = "#carousel_button_text_<?php echo $j; ?>_" + n + "_" + m;
                            var carousel_button_type = "#carousel_button_type_<?php echo $j; ?>_" + n + "_" + m;

                            if ($(carousel_button_type).parent().parent().parent().is(":visible")) {
                                var carousel_button_text_check = $(carousel_button_text).val();
                                var carousel_button_type_check = $(carousel_button_type).val();

                                if (carousel_button_text_check == '' && carousel_button_type_check != "") {
                                    showerror("<?php echo $this->lang->line('Please Provide Your Button Text')?>");

                                    return;
                                }


                                if (carousel_button_type_check == 'post_back') {

                                    var carousel_button_post_id = "#carousel_button_post_id_<?php echo $j;?>_" + n + "_" + m;
                                    var carousel_button_post_id_check = $(carousel_button_post_id).val();
                                    if (carousel_button_post_id_check == '') {
                                        showerror("<?php echo $this->lang->line('Please Provide Your PostBack Id')?>");

                                        return;
                                    }
                                } else if (carousel_button_type_check == 'web_url' || carousel_button_type_check == 'web_url_compact' || carousel_button_type_check == 'web_url_tall' || carousel_button_type_check == 'web_url_full') {

                                    var carousel_button_web_url = "#carousel_button_web_url_<?php echo $j;?>_" + n + "_" + m;
                                    var carousel_button_web_url_check = $(carousel_button_web_url).val();
                                    if (carousel_button_web_url_check == '') {
                                        showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                                        return;
                                    }
                                } else if (carousel_button_type_check == 'phone_number') {
                                    var carousel_button_call_us = "#carousel_button_call_us_<?php echo $j;?>_" + n + "_" + m;
                                    var carousel_button_call_us_check = $(carousel_button_call_us).val();
                                    if (carousel_button_call_us_check == '') {
                                        showerror("<?php echo $this->lang->line('Please Provide Your Phone Number')?>");

                                        return;
                                    }
                                }
                            }
                        }
                        <?php endfor; ?>

                    }
                }

                var schedule_type = $("input[name=schedule_type]:checked").val();
                var schedule_time = $("#schedule_time").val();
                var time_zone = $("#time_zone").val();
                if (schedule_type == 'later' && (schedule_time == "" || time_zone == "")) {
                    showerror("<?php echo $this->lang->line('Please select schedule time/time zone.')?>");

                    return;
                }

                $("#submit").addClass("btn-progress");

                $("input:not([type=hidden])").each(function () {
                    if ($(this).is(":visible") == false)
                        $(this).attr("disabled", "disabled");
                });

                var report_link = base_url + "messenger_bot_enhancers/subscriber_broadcast_campaign";
                var queryString = new FormData($("#messenger_bot_form")[0]);
                $.ajax({
                    type: 'POST',
                    url: base_url + "messenger_bot_enhancers/subscriber_bulk_broadcast_add_action",
                    data: queryString,
                    dataType: 'JSON',
                    // async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        if (response.status == '1') {
                            var success_message = "<?php echo $this->lang->line('Campaign have been submitted successfully.'); ?> <a href='" + report_link + "'><?php echo $this->lang->line('See report here.'); ?></a>";
                            var span = document.createElement("span");
                            span.innerHTML = success_message;
                            swal.fire({
                                title: '<?php echo $this->lang->line("Campaign Submitted"); ?>',
                                html: span,
                                icon: 'success'
                            }).then((value) => {
                                window.location.href = report_link;
                            });
                        } else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error').then((value) => {
                            window.location.href = report_link;
                        });

                        $("#submit").removeClass("btn-progress");
                        $("#submit_status").hide();

                    }

                });

            });


            $(document).on('click', '.add_template', function (e) {
                e.preventDefault();
                var page_id = $("#page").val();
                if (page_id == "") {
                    showerror("<?php echo $this->lang->line('Please select a page first')?>");
                    return false;
                }
                $("#add_template_modal").modal();
            });

            $(document).on('click', '.ref_template', function (e) {
                e.preventDefault();
                refresh_template();
            });

            $('#add_template_modal').on('hidden.bs.modal', function (e) {
                refresh_template();
            });

            $('#add_template_modal').on('shown.bs.modal', function () {
                var page_id = $("#page").val();
                var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
                $(this).find('iframe').attr('src', iframe_link);
            });

        });

        function refresh_template() {
            var page_id = $("#page").val();
            if (page_id == "") {
                showerror("<?php echo $this->lang->line('Please select a page first')?>");
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/get_postback",
                data: {page_id: page_id},
                success: function (response) {
                    $(".push_postback").html(response);
                }
            });
        }
    </script>

<?php include(FCPATH . "application/n_views/modules/messenger_bot_enhancers/messenger_broadcaster/summary_js.php") ?>

<?php
if(file_exists(APPPATH.'n_sgp/tools/spintax.php')){
    include(APPPATH.'n_sgp/tools/spintax.php');
}
