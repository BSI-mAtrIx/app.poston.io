<script type="text/javascript">
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
    var base_url = "<?php echo site_url(); ?>";
    var page_auto_id = '<?php echo $page_auto_id; ?>';

    function refresh_template(push_id, campaign_types, current_template_id) {
        var page_id = '<?php echo $page_auto_id;?>';
        $.ajax({
            type: 'POST',
            url: base_url + "sms_email_sequence/sms_email_template_sequence",
            data: {push_id: push_id, campaign_types: campaign_types, current_template_id: current_template_id},
            success: function (response) {
                $("#sms_email_sequence_templates" + push_id).html(response);
            }
        });
    }

    function hour_refresh_template(push_id, campaign_types, current_template_id) {
        var page_id = '<?php echo $page_auto_id;?>';
        $.ajax({
            type: 'POST',
            url: base_url + "sms_email_sequence/sms_email_template_sequence/1",
            data: {push_id: push_id, campaign_types: campaign_types, current_template_id: current_template_id},
            success: function (response) {
                $("#hour_sms_email_sequence_templates" + push_id).html(response);
            }
        });
    }

    $("document").ready(function () {

        $(".timepicker_x").datetimepicker({
            datepicker: false,
            format: "H:i"
        });

        var campaign_type = '<?php echo $xdata["campaign_type"];?>';
        $('input[type="radio"][name="campaign_types"][value="' + campaign_type + '"]').attr('checked', 'checked');
        $('input[type="radio"][name="campaign_types"][value="' + campaign_type + '"]').trigger('change');

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var campaign_types = $("input[name=campaign_types]:checked").val();
            var push_id = $(this).attr('data-id');
            var current_template_id = $("#template_id" + push_id).val();
            refresh_template(push_id, campaign_types, current_template_id);
        });

        $(document).on('click', '.hour_ref_template', function (e) {
            e.preventDefault();
            var campaign_types = $("input[name=campaign_types]:checked").val();
            var push_id = $(this).attr('data-id');
            var current_template_id = $("#hour_template_id" + push_id).val();
            hour_refresh_template(push_id, campaign_types, current_template_id);
        });

        $(document).on('click', '#add_more_day', function (e) {
            e.preventDefault();
            var day_counter = $("#day_counter").val();
            var how_many_days = '<?php echo $how_many_days;?>';
            how_many_days = parseInt(how_many_days);
            if (day_counter >= how_many_days) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You can add more days.')?>", 'error');
                return false;
            }
            day_counter++;
            $("#day_container" + day_counter).removeClass('hidden');
            $('#day_counter').val(day_counter);
        });

        $(document).on('click', '#remove_last_day', function (e) {
            e.preventDefault();
            var day_counter = $("#day_counter").val();
            if (day_counter < 2) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You can not remove the last item.')?>", 'error');
                return false;
            }
            $("#day_container" + day_counter).addClass('hidden');
            day_counter--;
            $('#day_counter').val(day_counter);
        });

        $(document).on('click', '#add_more_hour', function (e) {
            e.preventDefault();
            var hour_counter = $("#hour_counter").val();
            var how_many_hours = '<?php echo $how_many_hours;?>';
            how_many_hours = parseInt(how_many_hours);
            if (hour_counter >= how_many_hours) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You can not add more hour.')?>", 'error');
                return false;
            }
            hour_counter++;
            $("#hour_container" + hour_counter).removeClass('hidden');
            $('#hour_counter').val(hour_counter);
        });

        $(document).on('click', '#remove_last_hour', function (e) {
            e.preventDefault();
            var hour_counter = $("#hour_counter").val();
            if (hour_counter < 2) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You can not remove the last item.')?>", 'error');
                return false;
            }
            $("#hour_container" + hour_counter).addClass('hidden');
            hour_counter--;
            $('#hour_counter').val(hour_counter);
        });

        $(document).on('change', 'input[name=campaign_types]', function () {
            event.preventDefault();

            var how_many_days = '<?php echo $how_many_days;?>';
            var how_many_hours = '<?php echo $how_many_hours;?>';

            var default_display = '<?php echo $default_display;?>';
            var default_display_hour = '<?php echo $default_display_hour;?>';
            var campaign_types = $("input[name=campaign_types]:checked").val();
            var page_auto_id = '<?php echo $page_auto_id; ?>';
            var current_campaign_id = '<?php echo $xdata["id"];?>';
            var current_campaign_type = '<?php echo $xdata["campaign_type"];?>';

            var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size:60px;padding:100px 0;"></i></div>';
            $("#sequence_body").html(loading);

            $.ajax({
                url: "<?php echo base_url('sms_email_sequence/edited_get_selected_sequence_lists')?>",
                type: 'POST',
                data: {
                    how_many_days: how_many_days,
                    how_many_hours: how_many_hours,
                    default_display: default_display,
                    default_display_hour: default_display_hour,
                    campaign_types: campaign_types,
                    page_auto_id: page_auto_id,
                    current_campaign_id: current_campaign_id,
                    current_campaign_type: current_campaign_type
                },
                success: function (response) {
                    $("#sequence_body").html(response);
                    if (current_campaign_type != campaign_types) {
                        $("#day_counter").val("3");
                        $("#hour_counter").val("3");
                    } else {
                        $("#day_counter").val(default_display);
                        $("#hour_counter").val(default_display_hour);
                    }
                }
            })

        });

        $(document).on('click', '#submit_btn', function (e) {
            e.preventDefault();

            var campaign_types = $("input[name=campaign_types]:checked").val();
            if (campaign_types == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Sequence Type is required.')?>", 'error');
                return;
            }

            var is_day_selected = false;
            $(".template_id").each(function () {
                if ($(this).val() != '') is_day_selected = true;
            });

            var is_hour_selected = false;
            $(".hour_template_id").each(function () {
                if ($(this).val() != '') is_hour_selected = true;
            });

            if (!is_day_selected && !is_hour_selected) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You have not selected template for any day or hour.')?>", 'error');
                return;
            }

            if (is_day_selected) {
                var between_start = $("#between_start").val();
                var between_end = $("#between_end").val();
                var rep1 = parseFloat(between_start.replace(":", "."));
                var rep2 = parseFloat(between_end.replace(":", "."));
                var rep_diff = rep2 - rep1;

                if ((between_start == '' && between_end != '') || (between_start != '' && between_end == '')) {
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You must select both starting and closing time for daily sequence.')?>", 'error');
                    return false;
                }

                if (between_start != "" && between_end != "") {
                    if (rep1 >= rep2 || rep_diff < 1.0) {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Daily sequence starting time must be smaller than closing time and need to have minimum one hour time span.')?>", 'error');
                        return false;
                    }
                    if ($("#timezone").val() == "") {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select time zone for daily sequence.')?>", 'error');
                        return false;
                    }
                }
            }

            $(this).addClass('btn-progress');

            var queryString = new FormData($("#sms_email_sequence_form")[0]);
            $.ajax({
                context: this,
                type: 'POST',
                url: base_url + "sms_email_sequence/edit_sequence_message_campaign_action",
                data: queryString,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Campaign Updated"); ?>', response.message, 'success').then((value) => {
                            window.location.assign("<?php echo base_url('sms_email_sequence/sms_email_sequence_message_campaign/' . $page_auto_id . '/1');?>");
                        });
                    } else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }

            });

        });


        /* Creating Firstname text button for summernote texteditor */
        var firstName = function (context) {
            var ui = $.summernote.ui;

            // create button
            var button = ui.button({
                contents: '<i class="bx bx-user"/> ',
                container: 'body',
                tooltip: '<?php echo $this->lang->line("You can include #FIRST_NAME# variable inside your message. The variable will be replaced by real name when we will send it.") ?>',
                click: function () {
                    context.invoke('editor.insertText', ' #FIRST_NAME# ');
                }
            });

            return button.render();
        }

        /* creating Lastname text button for summernote texteditor */
        var lastName = function (context) {
            var ui = $.summernote.ui;

            // create button
            var button = ui.button({
                contents: '<i class="bx bx-user-circle"></i>',
                container: 'body',
                tooltip: '<?php echo $this->lang->line("You can include #LAST_NAME# variable inside your message. The variable will be replaced by real name when we will send it.") ?>',
                click: function () {
                    context.invoke('editor.insertText', ' #LAST_NAME# ');
                }
            });

            return button.render();
        }

        /* Creating Unsubscriber text button for summernote texteditor */
        var unsubscriberlink = function (context) {
            var ui = $.summernote.ui;

            // create button
            var button = ui.button({
                contents: '<i class="bx bx-bell-slash"/>',
                container: 'body',
                tooltip: '<?php echo $this->lang->line("You can include #UNSUBSCRIBE_LINK# variable inside your message. The variable will be replaced by real value when we will send it.") ?>',
                click: function () {
                    context.invoke('editor.insertText', ' #UNSUBSCRIBE_LINK# ');
                }
            });

            return button.render();
        }

        $(document).on('click', '.lead_first_name', function () {

            var textAreaTxt = $(this).parent().next("textarea").val();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);

            var txtToAdd = " #FIRST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next("textarea").val(new_text);

        });

        $(document).on('click', '.lead_last_name', function () {

            var textAreaTxt = $(this).parent().next().next("textarea").val();

            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);

            var txtToAdd = " #LAST_NAME# ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next("textarea").val(new_text);

        });

        $(document).on('click', '.add_template', function (event) {
            event.preventDefault();
            var campaign_type = $("input[name=campaign_types]:checked").val();
            $("#save_template").attr("button-type", campaign_type);
            $("#sms_email_template_modal").modal();

            if (campaign_type == 'email') {
                $("#name-div").addClass('col-md-6')
                $("#subject-div").css("display", "block");
                // $('#template_contents').summernote('reset');
                // $("#template_contents").summernote();

                $('#template_contents').summernote({
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['codeview']],
                        ['mybutton', ['first_name', 'last_name', 'unsubscriberLink']]
                    ],

                    buttons: {
                        first_name: firstName,
                        last_name: lastName,
                        unsubscriberLink: unsubscriberlink,
                    }
                });

                $(".button-outline").hide();

                $('div.note-group-select-from-files').remove();
            } else {
                $(".button-outline").show();
                $("#subject-div").css("display", "none");
            }

        });

        $(document).on('click', '#save_template', function (event) {
            event.preventDefault();

            var type = $(this).attr("button-type");
            var temp_name = $("#template_name").val();
            var csrf_token = $("#sms_email_sequence_csrf_token").val();
            var temp_subject = "";
            var temp_contents = $("#template_contents").val();

            if (type == 'email') {
                temp_subject = $("#template_subject").val();
            }

            $(this).addClass('btn-progress');

            $.ajax({
                context: this,
                url: base_url + 'sms_email_manager/create_template_action',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    template_type: type,
                    temp_name: temp_name,
                    temp_subject: temp_subject,
                    temp_contents: temp_contents,
                    csrf_token: csrf_token
                },
                success: function (response) {

                    $(this).removeClass('btn-progress');
                    if (true === response.error) {
                        swal.fire({title: 'Error!', text: response.message, icon: 'error'});
                    } else if (response.status == "1") {
                        $("#sms_email_template_modal").modal('hide');
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});

                    }
                }
            })

        });

        $("#sms_email_template_modal").on('hidden.bs.modal', function () {
            $("#template_name").val("");
            $("#template_subject").val("");
            $("#template_contents").val("");
            $("#template_contents").summernote('destroy');
        });


    });
</script>