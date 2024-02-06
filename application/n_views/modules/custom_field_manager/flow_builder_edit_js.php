<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script>
    var base_url = "<?php echo site_url(); ?>";
    $("document").ready(function () {

        $(".total_question_container").sortable({cancel: '.emojionearea-editor, select ,input, textarea, span, a , i'});

        $(".selected_custom_field").select2({
            tags: true
        });


        $(document).on('select2:select', '.selected_custom_field', function (e) {
            var tag = e.params.data.id;
            var type_of = e.params.data.disabled;
            if (typeof type_of == 'undefined') {
                var id = $(this).attr('id');
                var reply_type_id = $(this).attr('reply_type_id');
                var reply_type = $("#" + reply_type_id).val();
                $.ajax({
                    context: this,
                    type: 'POST',
                    dataType: 'JSON',
                    url: "<?php echo site_url();?>custom_field_manager/ajax_custom_field_insert",
                    data: {custom_field_name: tag, selected_reply_type: reply_type},
                    success: function (response) {
                        if (response.status == 'insert')
                            $("#" + id).html(response.message);
                    }
                });
            }
        });


        $('body').on('shown.bs.popover', function (e) {
            $(".select2").select2();
        });

        $(document).on('click', '.variables', function (e) {
            $("#variable_display_section").html('<div class="text-center waiting"><i class="bx bx-sync bx-spin blue text-center"></i></div>');
            $('#variable_data_modal').modal();
            var media_type = "<?php echo $media_type; ?>";
            $.ajax({
                context: this,
                type: 'POST',
                // dataType:'JSON',
                url: "<?php echo site_url();?>custom_field_manager/ajax_get_variables",
                data: {media_type: media_type},
                success: function (response) {
                    $("#variable_display_section").html(response);
                }
            });
        });


        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var page_id = $("#page_table_id").val();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning!"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'warning');
                return false;
            }
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $("#postback_id").val();
            var page_id = $("#page_table_id").val();
            var media_type = "<?php echo $media_type; ?>";
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning!"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'warning');
                return false;
            }

            var get_postback_url = base_url + "messenger_bot/get_postback";
            if (media_type == 'ig') {
                get_postback_url = base_url + "messenger_bot/get_ig_postback";
            }

            $.ajax({
                type: 'POST',
                url: get_postback_url,
                data: {page_id: page_id},
                success: function (response) {
                    $('#postback_id').select2('destroy');
                    $("#postback_id").html(response).val(current_val);
                    $('#postback_id').select2({
                        width: '100%'
                    });
                }
            });
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {

            var rand_time = "<?php echo time(); ?>";
            var media_type = "<?php echo $media_type; ?>";
            var page_id = $("#page_table_id").val();
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id + "/0/" + media_type + "?lev=" + rand_time;
            $(this).find('iframe').attr('src', iframe_link);

        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var page_id = $("#page_table_id").val();
            var media_type = "<?php echo $media_type; ?>";
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning!"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'warning');
                return false;
            }

            var get_postback_url = base_url + "messenger_bot/get_postback";
            if (media_type == 'ig') {
                get_postback_url = base_url + "messenger_bot/get_ig_postback";
            }

            $.ajax({
                type: 'POST',
                url: get_postback_url,
                data: {page_id: page_id},
                success: function (response) {
                    $('#postback_id').select2('destroy');
                    $("#postback_id").html(response);
                    $('#postback_id').select2({
                        width: '100%'
                    });
                }
            });
        });

        var question_counter = 0;
        $(document).on('click', '.add_question', function (e) {
            e.preventDefault();
            var reply_type = ''
            var question_category = '';
            question_counter = question_counter + 1;
            var question_type = $(this).attr('id');
            if (question_type == 'keyboard_input') {
                reply_type = $(this).attr('reply_type');
                question_category = 'keyboard_input';
            } else
                question_category = 'multiple_choice';

            var page_table_id = $("#page_table_id").val();
            var media_type = "<?php echo $media_type; ?>";

            if (page_table_id === '') {
                swal.fire('<?php echo $this->lang->line("Warning!"); ?>', '<?php echo $this->lang->line("Please select a page first"); ?>', 'warning');
                return false;
            }


            $.ajax({
                url: '<?php echo base_url('custom_field_manager/ajax_add_question_content'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    question_counter: question_counter,
                    reply_type: reply_type,
                    question_category: question_category,
                    page_table_id: page_table_id,
                    media_type: media_type
                },
                success: function (response) {
                    response.content = response.content.replaceAll('fas fa-cogs', 'bx bx-cog');
                    $(".total_question_container").append(response.content);
                    $(".edit_input_section").css("display", "none");
                }
            });

        });

        $(document).on('click', '.append_icon', function (event) {
            event.preventDefault();

            var blockDivId = $(this).attr('id');
            $("#block_" + blockDivId).find("#edit_input_section_" + blockDivId).toggle(100);
            $(".edit_input_section").not("#edit_input_section_" + blockDivId).css("display", "none");

        });

        $(document).on('change', '.selected_reply_type', function (event) {
            event.preventDefault();
            var blockDivId = $(this).attr('div_id');
            var checkbox_div_id = $(this).attr('checkbox_div_id');
            var phone_checkbox_div_id = $(this).attr('phone_checkbox_div_id');
            var block_array = blockDivId.split("_");
            var random_variable = block_array.pop();
            var custom_field_id = "selected_custom_field_" + random_variable;
            var selected_reply_type = $(this).val();

            if (selected_reply_type == 'Email')
                $("#" + checkbox_div_id).removeClass('d-none');
            else
                $("#" + checkbox_div_id).addClass('d-none');

            if (selected_reply_type == 'Phone')
                $("#" + phone_checkbox_div_id).removeClass('d-none');
            else
                $("#" + phone_checkbox_div_id).addClass('d-none');

            $.ajax({
                url: '<?php echo base_url('custom_field_manager/get_customfield_on_replytype'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {selected_reply_type: selected_reply_type},
                success: function (response) {
                    $("#" + custom_field_id).html(response.content);
                }
            });
        });

        $(document).on('change', '#page_table_id', function (event) {
            event.preventDefault();
            var page_table_id = $(this).val();
            var media_type = "<?php echo $media_type; ?>";

            $.ajax({
                url: '<?php echo base_url('custom_field_manager/get_postback_dropdown'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {page_table_id: page_table_id, media_type: media_type},
                success: function (response) {
                    $("#postback_id").html(response.content);
                    $('#postback_id').select2('destroy');
                    $("#postback_id").html(response);
                    $('#postback_id').select2({
                        width: '100%'
                    });
                }
            });
        });

        $(document).on('click', '.add_more_button', function (event) {
            event.preventDefault();
            var blockDivId = $(this).attr('div_id');
            var block_array = blockDivId.split("_");
            var random_variable = block_array.pop();
            var content = '<input type="text" class="form-control mb-2 multiple_input_more" name="multiple_choice[' + random_variable + '][]" id="multiple_choice[' + random_variable + '][]" placeholder="' + '<?php echo $this->lang->line("Another Option"); ?>' + '">';
            $("#" + blockDivId).append(content);
        });


        $(document).on('click', '.delete_single_block', function (e) {
            e.preventDefault();
            question_counter = question_counter - 1;
            var single_block_div_id = $(this).attr('single_block_div_id');
            var popover_div_id = $(this).attr('popover_id');
            $("#" + popover_div_id).click();
            $("#" + single_block_div_id).remove();
        });


        $(document).on('click', '.custom_items', function (event) {
            event.preventDefault();
            $(".custom_items").removeClass("active");
            $(this).addClass("active");
        });

        $(document).on('click', '#submit_flowbuilder', submit_flowbuilder);

        function submit_flowbuilder() {

            var valid = true;
            if ($('input.type_questions').length === 0) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Please add atleast one question"); ?>', 'warning');
                return false;
            }

            $('input.type_questions').each(function () {
                if (!$(this).val() || $(this).val() === 'undefined' || $(this).val() === null) {
                    valid = false;
                }
            })
            if (!valid) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Please fill all the questions"); ?>', 'warning');
                return false;
            }

            var campaign_name = $("#Campaign_name").val();
            var page_name = $("#page_table_id").val();
            var postback = $("#postback_id").val();
            var media_type = '<?php echo $media_type; ?>';

            if (campaign_name == '') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Campaign Name is required"); ?>', 'warning');
                return false;
            }

            if (page_name == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Please select a Page"); ?>', 'warning');
                return false;
            }

            if (postback == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Please Select a Postback"); ?>', 'warning');
                return false;
            }


            $('#submit_flowbuilder').addClass('btn-progress');

            var queryString = new FormData($("#flowbuilder_form")[0]);

            $.ajax({
                type: 'POST',
                url: base_url + "custom_field_manager/edit_question_submit",
                data: queryString,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#submit_flowbuilder").removeClass('btn-progress');
                    if (response.status == '1') {
                        var assign_url = "<?php echo base_url('custom_field_manager/campaign_list/' . $media_type); ?>";
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                            location.assign(assign_url);
                        });
                    } else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                },
                error: function (response) {
                    var span = document.createElement("span");
                    span.innerHTML = response.responseText;
                    swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                }

            });

        }

    });
</script>