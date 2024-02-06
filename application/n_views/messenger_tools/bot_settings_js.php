<script type="text/javascript">
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
    var base_url = "<?php echo site_url(); ?>";

    //var drop_menu = '<?php //echo $drop_menu;?>//';
    //setTimeout(function(){
    //    $("#mytable_filter").append(drop_menu);
    //}, 1000);

    var visual_flow_builder_exist = "<?php echo $visual_flow_builder_exist; ?>";
    if (visual_flow_builder_exist == 'yes')
        var shortable_column = [5];
    else
        var shortable_column = [4];

    var table = $("#mytable").DataTable({
        language:
            {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        columnDefs: [
            {
                targets: shortable_column,
                sortable: false
            }
        ]
    });

    $(document).ready(function (e) {


        $(".ecommerce_product_info").select2({
            maximumSelectionLength: 10
        });

        // Main Reply Sortable, Added by Konok 22.08.2020
        $("#main_reply_sort").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});


        $("#keywordtype_postback_id").select2();

        $(document).on('click', '.bs-dropdown-to-select-group .dropdown-menu li', function (event) {
            var $target = $(event.currentTarget);
            $target.closest('.bs-dropdown-to-select-group')
                .find('[data-bind="bs-drp-sel-value"]').val($target.attr('data-value'))
                .end()
                .children('.dropdown-toggle').dropdown('toggle');
            $target.closest('.bs-dropdown-to-select-group')
                .find('[data-bind="bs-drp-sel-label"]').text($target.context.textContent);
            return false;
        });

        $(document).on('change', '.ecommerce_store_info', function (e) {
            e.preventDefault();
            var product_dropdown_div = $(this).attr("product_dropdown_id");
            var store_id = $(this).val();
            var page_id = $("#page_table_id").val();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: base_url + 'messenger_bot/get_storewise_products',
                data: {page_auto_id: page_id, store_id: store_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#" + product_dropdown_div).html(response.dropdown);
                }
            });
        });

    });
</script>


<script type="text/javascript">


    var js_array = [<?php echo '"' . implode('","', $postback_id_array) . '"' ?>];

    var areyousure = "<?php echo $areyousure;?>";

    var text_with_button_counter = 1;
    var generic_template_button_counter = 1;
    var carousel_template_counter = 1;
    $(document).ready(function () {


        $(document).on('click', '.media_template_modal', function () {
            $("#media_template_modal").modal();
        });


        /**Load Emoji For first Text Reply Field By Default***/
        $("#text_reply_1").emojioneArea({
            <?php if ($rtl_on) {
                echo "dir: 'rtl',";
            } ?>
            autocomplete: false,
            pickerPosition: "bottom"
        });

        // getting postback list and making iframe
        var page_id = "<?php echo $page_info['id'];?>";
        var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
        $('#add_template_modal').on('shown.bs.modal', function () {
            $(this).find('iframe').attr('src', iframe_link);
        });
        refresh_template("0");
        $("#loader").addClass('hidden');
        // getting postback list and making iframe


        var keyword_type = $("input[name=keyword_type]").val();
        if (keyword_type == 'reply') {
            $("#keywords_div").show();
        } else {
            $("#keywords_div").hide();
        }

        $(document).on('change', 'input[name=keyword_type]', function () {
            if ($("input[name=keyword_type]").val() == "reply") {
                $("#keywords_div").show();
            } else {
                $("#keywords_div").hide();
            }
        });


        var multiple_template_add_button_counter = 1;
        $(document).on('click', '#multiple_template_add_button', function (e) {
            e.preventDefault();
            multiple_template_add_button_counter++

            $("#text_reply_" + multiple_template_add_button_counter).emojioneArea({
                <?php if ($rtl_on) {
                    echo "dir: 'rtl',";
                } ?>
                autocomplete: false,
                pickerPosition: "bottom"
            });

            $("#multiple_template_div_" + multiple_template_add_button_counter).show();

            var previous_div_id_counter = multiple_template_add_button_counter - 1;
            $("#multiple_template_div_" + previous_div_id_counter).find(".remove_reply").hide();

            if (multiple_template_add_button_counter == 6) {
                $("#multiple_template_add_button").hide();
            }
        });


        $(document).on('click', '.remove_reply', function () {
            var remove_reply_counter_variable = "multiple_template_add_button_counter";
            var remove_reply_row_id = $(this).attr('row_id');
            $("#" + remove_reply_row_id).find('textarea,input,select').val('');

            $("#" + remove_reply_row_id).hide();
            eval(remove_reply_counter_variable + "--");
            var temp = eval(remove_reply_counter_variable);
            if (temp != 1) {
                $("#multiple_template_div_" + temp).find(".remove_reply").show();
            }
            if (temp < 6) $("#multiple_template_add_button").show();
        });

        // remove carousel template
        $(document).on('click', '.remove_carousel_template', function () {
            var remove_carousel_counter_variable = $(this).attr('counter_variable');
            var template_add_button = $(this).attr('template_add_button');
            var remove_carousel_row_id = $(this).attr('current_row_id');
            var previous_carousel_row_id = $(this).attr('previous_row_id');
            $("#" + remove_carousel_row_id).find('textarea,input,select').val('');
            $("#" + remove_carousel_row_id).hide();
            eval(remove_carousel_counter_variable + "--");
            var temp = eval(remove_carousel_counter_variable);
            if (temp != 1) {
                $("#" + previous_carousel_row_id).find(".remove_carousel_template").show();
            }
            if (temp < 10) $("#" + template_add_button).show();
        });


        var keyword_type = $("input[name=keyword_type]").val();
        if (keyword_type == 'post-back') {
            $("#postback_div").show();
        }

        $(document).on('change', 'input[name=keyword_type]', function () {
            if ($("input[name=keyword_type]").val() == "post-back") {
                $("#postback_div").show();
            } else {
                $("#postback_div").hide();
            }
        });

        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        var video_upload_limit = "<?php echo $video_upload_limit; ?>";
        var audio_upload_limit = "<?php echo $audio_upload_limit; ?>";
        var file_upload_limit = "<?php echo $file_upload_limit; ?>";

        <?php for($template_type = 1;$template_type <= 6;$template_type++){ ?>


        $("#quick_reply_sort_<?php echo $template_type ?>").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});
        $("#media_postback_sort_<?php echo $template_type ?>").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});
        $("#text_button_sort_<?php echo $template_type ?>").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});
        $("#carousel_reply_sort_<?php echo $template_type ?>").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});
        $("#generic_button_sort_<?php echo $template_type ?>").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});

        // for carousel button , need to run an loop to apply sorting to all carousel reply button.

        <?php for($carousel_number = 1;$carousel_number <= 10;$carousel_number++){ ?>

        $("#carousel_button_sort_<?php echo $carousel_number ?>_<?php echo $template_type ?>").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});

        <?php } ?>



        var template_type_order = "#template_type_<?php echo $template_type ?>";

        $(document).on('change', "#template_type_<?php echo $template_type ?>", function () {

            var selected_template = $("#template_type_<?php echo $template_type ?>").val();
            selected_template = selected_template.replace(/ /gi, "_");

            var template_type_array = ['text', 'image', 'audio', 'video', 'file', 'quick_reply', 'text_with_buttons', 'generic_template', 'carousel', 'list', 'media', 'One_Time_Notification', 'User_Input_Flow', 'Ecommerce'];
            template_type_array.forEach(templates_hide_show_function);

            function templates_hide_show_function(item, index) {
                var template_type_preview_div_name = "#" + item + "_preview_div";
                var template_type_div_name = "#" + item + "_div_<?php echo $template_type; ?>";
                var delay_and_typing_on_div = "#delay_and_typing_on_<?php echo $template_type; ?>";

                if (selected_template == item) {
                    $(template_type_div_name).show();
                    $(template_type_preview_div_name).show();
                } else {
                    $(template_type_div_name).hide();
                    $(template_type_preview_div_name).hide();
                }
                $(delay_and_typing_on_div).show();

                if (selected_template == 'User_Input_Flow') {
                    var selected_input_flow_count = "<?php echo $template_type + 1 ?>";
                    for (var input_flow = selected_input_flow_count; input_flow <= multiple_template_add_button_counter; input_flow++) {
                        remove_reply_row_id = "multiple_template_div_" + input_flow;
                        $("#" + remove_reply_row_id).find('textarea,input,select').val('');
                        $("#" + remove_reply_row_id).find(".remove_reply").show();
                        $("#" + remove_reply_row_id).hide();
                    }
                    $(delay_and_typing_on_div).hide();
                    $("#multiple_template_add_button").hide();
                    multiple_template_add_button_counter = <?php echo $template_type; ?>;
                    $("#multiple_template_div_<?php echo $template_type; ?>").find(".remove_reply").show();
                } else
                    $("#multiple_template_add_button").show();

                if (selected_template == 'text') {

                    $("#text_reply_<?php echo $template_type; ?>").emojioneArea({
                        <?php if ($rtl_on) {
                            echo "dir: 'rtl',";
                        } ?>
                        autocomplete: false,
                        pickerPosition: "bottom"
                    });
                }

                if (selected_template == 'One_Time_Notification') {
                    $(delay_and_typing_on_div).hide();
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
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
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
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
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
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
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


        var media_counter_<?php echo $template_type; ?> = 1;

        $(document).on('click', "#media_add_button_<?php echo $template_type; ?>", function (e) {
            e.preventDefault();

            var button_id = media_counter_<?php echo $template_type; ?>;
            var media_text = "#media_text_" + button_id + "_<?php echo $template_type; ?>";
            var media_type = "#media_type_" + button_id + "_<?php echo $template_type; ?>";

            var media_text_check = $(media_text).val();
            if (media_text_check == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                return;
            }

            var media_type_check = $(media_type).val();
            if (media_type_check == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
                return;
            } else if (media_type_check == 'post_back') {

                var media_post_id = "#media_post_id_" + button_id + "_<?php echo $template_type; ?>";
                var media_post_id_check = $(media_post_id).val();
                if (media_post_id_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                    return;
                }

            } else if (media_type_check == 'web_url' || media_type_check == 'web_url_compact' || media_type_check == 'web_url_tall' || media_type_check == 'web_url_full') {
                var media_web_url = "#media_web_url_" + button_id + "_<?php echo $template_type; ?>";
                var media_web_url_check = $(media_web_url).val();
                if (media_web_url_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                    return;
                }
            } else if (media_type_check == 'phone_number') {
                var media_call_us = "#media_call_us_" + button_id + "_<?php echo $template_type; ?>";
                var media_call_us_check = $(media_call_us).val();
                if (media_call_us_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
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
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                    return;
                }

                var quick_reply_button_text_check = $(quick_reply_button_text).val();

                if (quick_reply_button_text_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                    return;
                }

            }
            if (quick_reply_button_type == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
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

            if (quick_reply_button_counter_<?php echo $template_type; ?> == 11)
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
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                return;
            }

            var text_with_button_type_check = $(text_with_button_type).val();
            if (text_with_button_type_check == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
                return;
            } else if (text_with_button_type_check == 'post_back') {

                var text_with_button_post_id = "#text_with_button_post_id_" + button_id + "_<?php echo $template_type; ?>";
                var text_with_button_post_id_check = $(text_with_button_post_id).val();
                if (text_with_button_post_id_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                    return;
                }
            } else if (text_with_button_type_check == 'web_url' || text_with_button_type_check == 'web_url_compact' || text_with_button_type_check == 'web_url_tall' || text_with_button_type_check == 'web_url_full') {
                var text_with_button_web_url = "#text_with_button_web_url_" + button_id + "_<?php echo $template_type; ?>";
                var text_with_button_web_url_check = $(text_with_button_web_url).val();
                if (text_with_button_web_url_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                    return;
                }
            } else if (text_with_button_type_check == 'phone_number') {
                var text_with_button_call_us = "#text_with_button_call_us_" + button_id + "_<?php echo $template_type; ?>";
                var text_with_button_call_us_check = $(text_with_button_call_us).val();
                if (text_with_button_call_us_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
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
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                return;
            }

            var generic_template_button_type_check = $(generic_template_button_type).val();
            if (generic_template_button_type_check == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
                return;
            } else if (generic_template_button_type_check == 'post_back') {

                var generic_template_button_post_id = "#generic_template_button_post_id_" + button_id + "_<?php echo $template_type; ?>";
                var generic_template_button_post_id_check = $(generic_template_button_post_id).val();
                if (generic_template_button_post_id_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                    return;
                }

            } else if (generic_template_button_type_check == 'web_url' || generic_template_button_type_check == 'web_url_compact' || generic_template_button_type_check == 'web_url_tall' || generic_template_button_type_check == 'web_url_full') {

                var generic_template_button_web_url = "#generic_template_button_web_url_" + button_id + "_<?php echo $template_type; ?>";
                var generic_template_button_web_url_check = $(generic_template_button_web_url).val();
                if (generic_template_button_web_url_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                    return;
                }
            } else if (generic_template_button_type_check == 'phone_number') {
                var generic_template_button_call_us = "#generic_template_button_call_us_" + button_id + "_<?php echo $template_type; ?>";
                var generic_template_button_call_us_check = $(generic_template_button_call_us).val();
                if (generic_template_button_call_us_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
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
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                return;
            }

            var carousel_button_type_check = $(carousel_button_type).val();
            if (carousel_button_type_check == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
                return;
            } else if (carousel_button_type_check == 'post_back') {

                var carousel_button_post_id = "#carousel_button_post_id_<?php echo $j;?>_" + y + "_<?php echo $template_type; ?>";
                var carousel_button_post_id_check = $(carousel_button_post_id).val();
                if (carousel_button_post_id_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                    return;
                }
            } else if (carousel_button_type_check == 'web_url' || carousel_button_type_check == 'web_url_compact' || carousel_button_type_check == 'web_url_full' || carousel_button_type_check == 'web_url_tall') {

                var carousel_button_web_url = "#carousel_button_web_url_<?php echo $j;?>_" + y + "_<?php echo $template_type; ?>";
                var carousel_button_web_url_check = $(carousel_button_web_url).val();
                if (carousel_button_web_url_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                    return;
                }
            } else if (carousel_button_type_check == 'phone_number') {
                var carousel_button_call_us = "#carousel_button_call_us_<?php echo $j;?>_" + y + "_<?php echo $template_type; ?>";
                var carousel_button_call_us_check = $(carousel_button_call_us).val();
                if (carousel_button_call_us_check == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
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
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide carousel title')?>", 'warning');
                return;
            }

            var carousel_subtitle = "#carousel_subtitle_" + carousel_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
            var carousel_subtitle_check = $(carousel_subtitle).val();

            var carousel_image_destination_link = "#carousel_image_destination_link_" + carousel_template_counter_<?php echo $template_type; ?>+ "_" +<?php echo $template_type; ?>;
            var carousel_image_destination_link_check = $(carousel_image_destination_link).val();


            carousel_template_counter_<?php echo $template_type; ?>++;

            var x = carousel_template_counter_<?php echo $template_type; ?>;
            // remove template
            var previous_template_counter = x - 1;
            $("#carousel_div_" + previous_template_counter + "_<?php echo $template_type; ?>").find(".remove_carousel_template").hide();

            $("#carousel_div_" + x + "_<?php echo $template_type; ?>").show();
            $("#carousel_row_" + x + "_1" + "_<?php echo $template_type; ?>").show();
            if (carousel_template_counter_<?php echo $template_type; ?> == 10)
                $("#carousel_template_add_button_<?php echo $template_type; ?>").hide();
        });


        <?php } ?>



        $(document).on('click', '.item_remove', function () {
            var counter_variable = $(this).attr('counter_variable');
            var row_id = $(this).attr('row_id');

            var first_column_id = $(this).attr('first_column_id');
            var second_column_id = $(this).attr('second_column_id');
            var add_more_button_id = $(this).attr('add_more_button_id');

            var item_remove_postback = $(this).attr('third_postback');
            var item_remove_weburl = $(this).attr('third_weburl');
            var item_remove_callus = $(this).attr('third_callus');

            var template_type = $(this).attr('template_type');

            $("#" + first_column_id).val('');
            $("#" + first_column_id).removeAttr('readonly');
            var item_remove_button_type = $("#" + second_column_id).val();
            $("#" + second_column_id).val('');

            if (item_remove_button_type == 'post_back') {
                if (item_remove_postback != '')
                    $("#" + item_remove_postback).val('');
            } else if (item_remove_button_type == 'web_url' || item_remove_button_type == 'web_url_compact' || item_remove_button_type == 'web_url_full' || item_remove_button_type == 'web_url_tall' || item_remove_button_type == 'web_url_birthday' || item_remove_button_type == 'web_url_email' || item_remove_button_type == 'web_url_phone' || item_remove_button_type == 'web_url_location') {
                if (item_remove_weburl != '')
                    $("#" + item_remove_weburl).val('');
            } else {
                if (item_remove_callus != '')
                    $("#" + item_remove_callus).val('');
            }

            $("#" + row_id).hide();
            eval(counter_variable + "--");
            var temp = eval(counter_variable);

            if (temp != 1) {
                var previous_item_remove_div = $("#" + row_id).prev('div').attr('id');
                $("#" + previous_item_remove_div + " div:last").show();
            }
            $(this).parent().hide();

            if (template_type == 'quick_reply') {
                if (temp < 11) $("#" + add_more_button_id).show();
            } else {
                if (temp < 3) $("#" + add_more_button_id).show();
            }

        });


        $(document).on('click', '.delete_bot', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var somethingwentwrong = "<?php echo $somethingwentwrong; ?>";
            var doyoureallywanttodeletethisbot = "<?php echo $doyoureallywanttodeletethisbot; ?>";
            var link = "<?php echo $redirect_url; ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Delete Bot Reply"); ?>',
                text: doyoureallywanttodeletethisbot,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $(this).addClass('btn-progress');
                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>messenger_bot/delete_bot",
                            data: {id: id},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                if (response == '1') {
                                    swal.fire('<?php echo $this->lang->line("Reply Deleted"); ?>', "<?php echo $this->lang->line('Bot reply has been deleted successfully.'); ?>", 'success').then((value) => {
                                        window.location.assign(link);
                                    });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', somethingwentwrong, 'error');
                                }
                            }
                        });
                    }
                });


        });


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
        });


        $(document).on('change', '.text_with_button_type_class', function () {
            var button_type = $(this).val();
            var which_number_is_clicked = $(this).attr('id');
            which_number_is_clicked_main = which_number_is_clicked.split('_');
            which_number_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 2];
            var which_block_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 1];

            if (button_type == 'post_back') {
                $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='UNSUBSCRIBE_QUICK_BOXER']").remove();
                $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='RESUBSCRIBE_QUICK_BOXER']").remove();
                $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='YES_START_CHAT_WITH_HUMAN']").remove();
                $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='YES_START_CHAT_WITH_BOT']").remove();
                $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                $("#text_with_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                $("#text_with_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                var option_id = $(this).children(":selected").attr("id");
                if (option_id == "unsubscribe_postback") {
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "UNSUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('unsubscribe');?>"));
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("UNSUBSCRIBE_QUICK_BOXER");
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                if (option_id == "resubscribe_postback") {
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "RESUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('re-subscribe');?>"));
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("RESUBSCRIBE_QUICK_BOXER");
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                if (option_id == "human_postback") {
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "YES_START_CHAT_WITH_HUMAN").text("<?php echo $this->lang->line('Chat with Human');?>"));
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("YES_START_CHAT_WITH_HUMAN");
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                if (option_id == "robot_postback") {
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "YES_START_CHAT_WITH_BOT").text("<?php echo $this->lang->line('Chat with Robot');?>"));
                    $("#text_with_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("YES_START_CHAT_WITH_BOT");
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
        });


        $(document).on('change', '.generic_template_button_type_class', function () {
            var button_type = $(this).val();
            var which_number_is_clicked = $(this).attr('id');
            which_number_is_clicked_main = which_number_is_clicked.split('_');
            which_number_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 2];
            which_block_is_clicked = which_number_is_clicked_main[which_number_is_clicked_main.length - 1];

            if (button_type == 'post_back') {
                $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='UNSUBSCRIBE_QUICK_BOXER']").remove();
                $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='RESUBSCRIBE_QUICK_BOXER']").remove();
                $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='YES_START_CHAT_WITH_HUMAN']").remove();
                $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select option[value='YES_START_CHAT_WITH_BOT']").remove();
                $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).show();
                $("#generic_template_button_web_url_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                $("#generic_template_button_call_us_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                var option_id = $(this).children(":selected").attr("id");
                if (option_id == "unsubscribe_postback") {
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "UNSUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('unsubscribe');?>"));
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("UNSUBSCRIBE_QUICK_BOXER");
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                if (option_id == "resubscribe_postback") {
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "RESUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('re-subscribe');?>"));
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("RESUBSCRIBE_QUICK_BOXER");
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                if (option_id == "human_postback") {
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "YES_START_CHAT_WITH_HUMAN").text("<?php echo $this->lang->line('Chat with Human');?>"));
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("YES_START_CHAT_WITH_HUMAN");
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked).hide();
                }
                if (option_id == "robot_postback") {
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").append($("<option></option>").attr("value", "YES_START_CHAT_WITH_BOT").text("<?php echo $this->lang->line('Chat with Robot');?>"));
                    $("#generic_template_button_postid_div_" + which_number_is_clicked + "_" + which_block_is_clicked + " select").val("YES_START_CHAT_WITH_BOT");
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
                $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select option[value='RESUBSCRIBE_QUICK_BOXER']").remove();
                $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select option[value='YES_START_CHAT_WITH_HUMAN']").remove();
                $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select option[value='YES_START_CHAT_WITH_BOT']").remove();
                $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).show();
                $("#carousel_button_web_url_div_" + second + "_" + first + "_" + block_template_third).hide();
                $("#carousel_button_call_us_div_" + second + "_" + first + "_" + block_template_third).hide();
                var option_id = $(this).children(":selected").attr("id");
                if (option_id == "unsubscribe_postback") {
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").append($("<option></option>").attr("value", "UNSUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('unsubscribe');?>"));
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").val("UNSUBSCRIBE_QUICK_BOXER");
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).hide();
                }
                if (option_id == "resubscribe_postback") {
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").append($("<option></option>").attr("value", "RESUBSCRIBE_QUICK_BOXER").text("<?php echo $this->lang->line('re-subscribe');?>"));
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").val("RESUBSCRIBE_QUICK_BOXER");
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).hide();
                }
                if (option_id == "human_postback") {
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").append($("<option></option>").attr("value", "YES_START_CHAT_WITH_HUMAN").text("<?php echo $this->lang->line('Chat with Human');?>"));
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").val("YES_START_CHAT_WITH_HUMAN");
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third).hide();
                }
                if (option_id == "robot_postback") {
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").append($("<option></option>").attr("value", "YES_START_CHAT_WITH_BOT").text("<?php echo $this->lang->line('Chat with Robot');?>"));
                    $("#carousel_button_postid_div_" + second + "_" + first + "_" + block_template_third + " select").val("YES_START_CHAT_WITH_BOT");
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
        });


        $(document).on('click', '#submit', function (e) {
            e.preventDefault();

            //Added By Konok for main reply sorting 22.08.2020
            var main_reply_sort_order = $("#main_reply_sort").sortable("serialize");
            $("#main_reply_sort_order").val(main_reply_sort_order);


            var bot_name = $("#bot_name").val();
            var keyword_type = $("input[name=keyword_type]").val();

            if (typeof ($("input[name=keyword_type]").val()) == 'undefined') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select a reply type form (Reply/Post-back/No Match/Get Started)');?>", 'warning');
                return;
            }

            if (bot_name == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Give Bot Name');?>", 'warning');
                return;
            }


            if (keyword_type == 'post-back') {
                if ($("#keywordtype_postback_id").val() == '' || typeof ($("#keywordtype_postback_id").val()) == 'undefined' || $("#keywordtype_postback_id").val() == null) {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please provide postback id');?>", 'warning');
                    return;
                }
            }

            if (keyword_type == 'reply') {
                var keywords_list = $("#keywords_list").val();
                if (keywords_list == '') {
                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Keywords In Comma Separated');?>", 'warning');
                    return;
                }
            }

            for (var m = 1; m <= multiple_template_add_button_counter; m++) {
                var template_type = $("#template_type_" + m).val();

                if (template_type == 'Ecommerce') {
                    var ecommerce_store_id = $("#ecommerce_store_id" + m).val();
                    if (ecommerce_store_id == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Select an Ecommerce Store')?>", 'warning');
                        return;
                    }

                    var ecommerce_product_ids = $("#ecommerce_product_ids" + m).val();
                    if (ecommerce_product_ids == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select atleast one product for carousel/generic reply')?>", 'warning');
                        return;
                    }
                }

                if (template_type == 'text') {
                    var text_reply = $("#text_reply_" + m).val();
                    if (text_reply == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Reply Message')?>", 'warning');
                        return;
                    }
                }

                if (template_type == 'User Input Flow') {
                    var flow_campaign_id_ = $("#flow_campaign_id_" + m).val();
                    if (flow_campaign_id_ == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Select a Flow Campaign')?>", 'warning');
                        return;
                    }
                }

                if (template_type == "image") {
                    var image_reply_field = $("#image_reply_field_" + m).val();
                    if (image_reply_field == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Reply Image')?>", 'warning');
                        return;
                    }
                }

                if (template_type == "One Time Notification") {
                    var otn_title = $("#otn_title_" + m).val();
                    var otn_postback = $("#otn_postback_" + m).val();
                    if (otn_title == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide OTN Title')?>", 'warning');
                        return;
                    }
                    if (otn_postback == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Select an OTN Postback')?>", 'warning');
                        return;
                    }
                }

                if (template_type == "audio") {
                    var audio_reply_field = $("#audio_reply_field_" + m).val();
                    if (audio_reply_field == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Reply Audio')?>", 'warning');
                        return;
                    }
                }

                if (template_type == "video") {
                    var video_reply_field = $("#video_reply_field_" + m).val();
                    if (video_reply_field == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Reply Video')?>", 'warning');
                        return;
                    }
                }


                if (template_type == "file") {
                    var file_reply_field = $("#file_reply_field_" + m).val();
                    if (file_reply_field == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Reply File')?>", 'warning');
                        return;
                    }
                }


                if (template_type == "media") {

                    // Added by Konok 22-08-2020 , store order quick reply button list in hidden field.
                    var media_postback_sort_order = $("#media_postback_sort_" + m).sortable("toArray");
                    $("#media_postback_sort_order_" + m).val(media_postback_sort_order);


                    var media_input = $("#media_input_" + m).val();
                    if (media_input == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Media URL')?>", 'warning');
                        return;
                    }

                    var facebook_url = media_input.match(/business.facebook.com/g);
                    var facebook_url2 = media_input.match(/www.facebook.com/g);

                    if (facebook_url == null && facebook_url2 == null) {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please provide Facebook content URL as Media URL')?>", 'warning');
                        return;
                    }

                    var submited_media_counter = eval("media_counter_" + m);

                    for (var n = 1; n <= submited_media_counter; n++) {

                        var media_text = "#media_text_" + n + "_" + m;
                        var media_type = "#media_type_" + n + "_" + m;

                        var media_text_check = $(media_text).val();
                        if (media_text_check == '') {
                            swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                            return;
                        }

                        var media_type_check = $(media_type).val();
                        if (media_type_check == '') {
                            swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
                            return;
                        } else if (media_type_check == 'post_back') {

                            var media_post_id = "#media_post_id_" + n + "_" + m;
                            var media_post_id_check = $(media_post_id).val();
                            if (media_post_id_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                                return;
                            }

                        } else if (media_type_check == 'web_url' || media_type_check == 'web_url_compact' || media_type_check == 'web_url_tall' || media_type_check == 'web_url_full') {
                            var media_web_url = "#media_web_url_" + n + "_" + m;
                            var media_web_url_check = $(media_web_url).val();
                            if (media_web_url_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                                return;
                            }
                        } else if (media_type_check == 'phone_number') {
                            var media_call_us = "#media_call_us_" + n + "_" + m;
                            var media_call_us_check = $(media_call_us).val();
                            if (media_call_us_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
                                return;
                            }
                        }
                    }

                }


                if (template_type == "quick reply") {

                    // Added by Konok 22-08-2020 , store order quick reply button list in hidden field.
                    var quick_reply_sort_order = $("#quick_reply_sort_" + m).sortable("toArray");
                    $("#quick_reply_sort_order_" + m).val(quick_reply_sort_order);

                    var quick_reply_text = $("#quick_reply_text_" + m).val();
                    if (quick_reply_text == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Reply Message')?>", 'warning');
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
                            if (quick_reply_post_id_check == '' || quick_reply_post_id_check == null) {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                                return;
                            }

                            var quick_reply_button_text_check = $(quick_reply_button_text).val();

                            if (quick_reply_button_text_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                                return;
                            }

                        }
                        if (quick_reply_button_type == '') {
                            swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
                            return;
                        }
                    }
                }


                if (template_type == "text with buttons") {

                    // Added by Konok 22-08-2020 , store order quick reply button list in hidden field.
                    var text_button_sort_order = $("#text_button_sort_" + m).sortable("toArray");
                    $("#text_button_sort_order_" + m).val(text_button_sort_order);


                    var text_with_buttons_input = $("#text_with_buttons_input_" + m).val();
                    if (text_with_buttons_input == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Reply Message')?>", 'warning');
                        return;
                    }

                    var submited_text_with_button_counter = eval("text_with_button_counter_" + m);

                    for (var n = 1; n <= submited_text_with_button_counter; n++) {

                        var text_with_buttons_text = "#text_with_buttons_text_" + n + "_" + m;
                        var text_with_button_type = "#text_with_button_type_" + n + "_" + m;

                        var text_with_buttons_text_check = $(text_with_buttons_text).val();
                        if (text_with_buttons_text_check == '') {
                            swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                            return;
                        }

                        var text_with_button_type_check = $(text_with_button_type).val();
                        if (text_with_button_type_check == '') {
                            swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Type')?>", 'warning');
                            return;
                        } else if (text_with_button_type_check == 'post_back') {

                            var text_with_button_post_id = "#text_with_button_post_id_" + n + "_" + m;
                            var text_with_button_post_id_check = $(text_with_button_post_id).val();
                            if (text_with_button_post_id_check == '' || text_with_button_post_id_check == null) {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                                return;
                            }

                        } else if (text_with_button_type_check == 'web_url' || text_with_button_type_check == 'web_url_compact' || text_with_button_type_check == 'web_url_tall' || text_with_button_type_check == 'web_url_full') {
                            var text_with_button_web_url = "#text_with_button_web_url_" + n + "_" + m;
                            var text_with_button_web_url_check = $(text_with_button_web_url).val();
                            if (text_with_button_web_url_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                                return;
                            }
                        } else if (text_with_button_type_check == 'phone_number') {
                            var text_with_button_call_us = "#text_with_button_call_us_" + n + "_" + m;
                            var text_with_button_call_us_check = $(text_with_button_call_us).val();
                            if (text_with_button_call_us_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
                                return;
                            }
                        }
                    }

                }

                if (template_type == "generic template") {

                    // Added by Konok 22-08-2020 , store order Generic reply button list in hidden field.
                    var generic_button_sort_order = $("#generic_button_sort_" + m).sortable("toArray");
                    $("#generic_button_sort_order_" + m).val(generic_button_sort_order);


                    var generic_template_image = $("#generic_template_image_" + m).val();

                    var generic_template_title = $("#generic_template_title_" + m).val();
                    if (generic_template_title == '') {
                        swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please give the title')?>", 'warning');
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
                            swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                            return;
                        }

                        if (generic_template_button_type_check == 'post_back') {

                            var generic_template_button_post_id = "#generic_template_button_post_id_" + n + "_" + m;
                            var generic_template_button_post_id_check = $(generic_template_button_post_id).val();
                            if (generic_template_button_post_id_check == '' || generic_template_button_post_id_check == null) {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                                return;
                            }

                        } else if (generic_template_button_type_check == 'web_url' || generic_template_button_type_check == 'web_url_compact' || generic_template_button_type_check == 'web_url_tall' || generic_template_button_type_check == 'web_url_full') {

                            var generic_template_button_web_url = "#generic_template_button_web_url_" + n + "_" + m;
                            var generic_template_button_web_url_check = $(generic_template_button_web_url).val();
                            if (generic_template_button_web_url_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                                return;
                            }
                        } else if (generic_template_button_type_check == 'phone_number') {
                            var generic_template_button_call_us = "#generic_template_button_call_us_" + n + "_" + m;
                            var generic_template_button_call_us_check = $(generic_template_button_call_us).val();
                            if (generic_template_button_call_us_check == '') {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
                                return;
                            }
                        }
                    }

                }


                if (template_type == "carousel") {

                    // Added by Konok 22-08-2020 , store order Generic reply button list in hidden field.
                    var carousel_reply_sort_order = $("#carousel_reply_sort_" + m).sortable("toArray");
                    $("#carousel_reply_sort_order_" + m).val(carousel_reply_sort_order);


                    var submited_carousel_template_counter = eval("carousel_template_counter_" + m);
                    for (var n = 1; n <= submited_carousel_template_counter; n++) {
                        var carousel_image = "#carousel_image_" + n + "_" + m;
                        var carousel_image_check = $(carousel_image).val();

                        var carousel_title = "#carousel_title_" + n + "_" + m;
                        var carousel_title_check = $(carousel_title).val();
                        if (carousel_title_check == '') {
                            swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide carousel title')?>", 'warning');
                            return;
                        }

                        var carousel_subtitle = "#carousel_subtitle_" + n + "_" + m;
                        var carousel_subtitle_check = $(carousel_subtitle).val();

                        var carousel_image_destination_link = "#carousel_image_destination_link_" + n + "_" + m;
                        var carousel_image_destination_link_check = $(carousel_image_destination_link).val();

                    }

                    <?php for($j = 1; $j <= 10; $j++) : ?>

                    var carousel_button_sort_order = $("#carousel_button_sort_<?php echo $j; ?>_" + m).sortable("toArray");
                    $("#carousel_button_sort_order_<?php echo $j; ?>_" + m).val(carousel_button_sort_order);


                    var submited_carousel_add_button_counter = eval("carousel_add_button_counter_<?php echo $j; ?>_" + m);
                    for (var n = 1; n <= submited_carousel_add_button_counter; n++) {
                        var carousel_button_text = "#carousel_button_text_<?php echo $j; ?>_" + n + "_" + m;
                        var carousel_button_type = "#carousel_button_type_<?php echo $j; ?>_" + n + "_" + m;

                        if ($(carousel_button_type).parent().parent().parent().is(":visible")) {
                            var carousel_button_text_check = $(carousel_button_text).val();
                            var carousel_button_type_check = $(carousel_button_type).val();

                            if (carousel_button_text_check == '' && carousel_button_type_check != "") {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Button Text')?>", 'warning');
                                return;
                            }

                            if (carousel_button_type_check == 'post_back') {

                                var carousel_button_post_id = "#carousel_button_post_id_<?php echo $j;?>_" + n + "_" + m;
                                var carousel_button_post_id_check = $(carousel_button_post_id).val();
                                if (carousel_button_post_id_check == '' || carousel_button_post_id_check == null) {
                                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your PostBack Id')?>", 'warning');
                                    return;
                                }
                            } else if (carousel_button_type_check == 'web_url' || carousel_button_type_check == 'web_url_compact' || carousel_button_type_check == 'web_url_full' || carousel_button_type_check == 'web_url_tall') {

                                var carousel_button_web_url = "#carousel_button_web_url_<?php echo $j;?>_" + n + "_" + m;
                                var carousel_button_web_url_check = $(carousel_button_web_url).val();
                                if (carousel_button_web_url_check == '') {
                                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Web Url')?>", 'warning');
                                    return;
                                }
                            } else if (carousel_button_type_check == 'phone_number') {
                                var carousel_button_call_us = "#carousel_button_call_us_<?php echo $j;?>_" + n + "_" + m;
                                var carousel_button_call_us_check = $(carousel_button_call_us).val();
                                if (carousel_button_call_us_check == '') {
                                    swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Provide Your Phone Number')?>", 'warning');
                                    return;
                                }
                            }
                        }


                    }
                    <?php endfor; ?>

                }


            }


            $(this).addClass('btn-progress');


            $("input:not([type=hidden])").each(function () {
                if ($(this).is(":visible") == false)
                    $(this).attr("disabled", "disabled");
            });


            var queryString = new FormData($("#messenger_bot_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/ajax_generate_messenger_bot",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    swal.fire('<?php echo $this->lang->line("Reply Created"); ?>', "<?php echo $this->lang->line('Bot reply has been added successfully.'); ?>", 'success').then((value) => {
                        location.reload();
                    });
                },
                error: function (response) {
                    var span = document.createElement("span");
                    span.innerHTML = response.responseText;
                    swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                }

            });

        });


        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        $(document).on('click', '#add_bot_settings', function (e) {
            e.preventDefault();
            $("#add_bot_settings_modal").removeClass('hidden');
            $(".box.box-widget.widget-user-2").hide();
            $("#bot_success").hide();
            $("#bot_list_datatable").hide();
            // $('html, body').animate({scrollTop: $("#add_bot_settings_modal").offset().top}, 2000);
        });

        $(document).on('click', '.lead_first_name', function () {

            var textAreaTxt = $(this).parent().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #LEAD_USER_FIRST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().children('.emojionearea-editor').click();


        });

        $(document).on('click', '.lead_last_name', function () {

            var textAreaTxt = $(this).parent().next().next().next().next().children('.emojionearea-editor').html();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);


            var txtToAdd = " #LEAD_USER_LAST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().next().children('.emojionearea-editor').click();


        });

        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var current_id = $(this).prev().attr("id");
            var page_id = "<?php echo $page_info['id'];?>";
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").attr("current_id", current_id);
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $(this).prev().prev().val();
            var current_id = $(this).prev().prev().attr("id");
            var page_id = "<?php echo $page_info['id'];?>";
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/get_postback",
                data: {page_id: page_id},
                success: function (response) {
                    $("#" + current_id).html(response).val(current_val);
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var page_id = "<?php echo $page_info['id'];?>";
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/get_postback",
                data: {page_id: page_id},
                success: function (response) {
                    $("#" + current_id).html(response);
                }
            });
        });


        $(document).on('click', '.bot_status_btn', function (event) {
            event.preventDefault();

            let table_id = $(this).attr('table_id');

            swal.fire({
                title: 'Warning',
                text: '<?php echo $this->lang->line("Do you really want to change this state?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true
            }).then(willChangeState => {
                if (willChangeState) {
                    $.ajax({
                        url: '<?php echo base_url("messenger_bot/change_bot_state"); ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {table_id: table_id},
                        success: function (response) {

                            if (response.status == 'success') {
                                iziToast.success({
                                    title: '<?php echo $this->lang->line("Success"); ?>',
                                    message: response.message,
                                    position: 'bottomRight'
                                });
                            } else if (response.status == 'error') {
                                iziToast.error({
                                    title: '<?php echo $this->lang->line("Error"); ?>',
                                    message: response.message,
                                    position: 'bottomRight'
                                });
                            }

                            window.location.reload();
                        }
                    });

                }
            });
        });


    });

    function refresh_template(is_from_add_button = '1') {
        var page_id = "<?php echo $page_info['id'];?>";
        if (page_id == "") {
            alertify.alert('<?php echo $this->lang->line("Alert"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", function () {
            });
            return false;
        }
        $.ajax({
            type: 'POST',
            url: base_url + "messenger_bot/get_postback",
            data: {page_id: page_id, order_by: "template_name", is_from_add_button: is_from_add_button},
            success: function (response) {
                $(".push_postback").html(response);
            }
        });
    }

</script>