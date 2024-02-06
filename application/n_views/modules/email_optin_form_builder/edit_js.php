<script src="<?= base_url('plugins/formbuilder/form-builder.min.js?ver=' . $n_config['theme_version']) ?>"></script>
<script>
    var interval_time = $('#interval_time'),
        uri_canonical_id = '<?php echo $uri_canonical_id; ?>',
        real_canonical_id = '<?php echo $real_canonical_id; ?>',
        response_type = '<?php echo $response_type; ?>';
    var popuptype = $('#popupType');

    if (response_type === "success_message_type") {
        $("#success_message_type").prop('checked', true);
        $("#success_message_div").show();
        $("#redirect_url_div").hide();
    }

    if (response_type === "redirect_url_type") {
        $("#redirect_url_type").prop('checked', true);
        $("#success_message_div").hide();
        $("#redirect_url_div").show();
    }

    $(document).ready(function () {

        var contact_group = $('#contact_group')
        $(contact_group).select2({
            width: '100%',
            placeholder: '<?php echo $this->lang->line('Select Contact Group') ?>'
        })

        var select_sequence_email_campaign_id = $('#sequence_email_campaign_id')
        $(select_sequence_email_campaign_id).select2({
            width: '100%',
        });

        var select_sequence_sms_campaign_id = $('#sequence_sms_campaign_id')
        $(select_sequence_sms_campaign_id).select2({
            width: '100%',
        });

        var select_form_position = $('#form_position')
        $(select_form_position).select2({
            width: '100%',
        })
        var popup_type = $('#popup_type')
        $(popup_type).select2({
            width: '100%',
        });

        $(document).on('change', 'input[name=enable_country_code]', function () {
            if ($("input[name=enable_country_code]:checked").val() == "1") {
                $("#country_code_lists").show();
            } else {

                $("#country_code_lists").hide();

            }
        });


        $(document).on('change', 'input[name=response_type]', function () {
            if ($("input[name=response_type]:checked").val() == "success_message_type") {
                $("#success_message_div").show();
                $("#redirect_url_div").hide();
            } else {
                $("#success_message_div").hide();
                $("#redirect_url_div").show();

            }
        });

        // create an new group and put inside group list
        $(document).on('click', '#create_contact_group', function (e) {
            e.preventDefault();

            swal.fire({
                title: "<?php echo $this->lang->line('Group Name'); ?>",
                input: "text",
                confirmButtonText: "<?php echo $this->lang->line('New Group'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('Cancel'); ?>",
                showCancelButton: true,
            })
                .then((value) => {
                    if (value.isDenied || value.isDismissed) {
                        return;
                    }
                    var group_name = `${value.value}`;
                    if (group_name != "" && group_name != 'null') {
                        $("#save_changes").addClass("btn-progress");
                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo site_url();?>email_optin_form_builder/add_contact_group_action",
                            data: {group_name: group_name},
                            success: function (response) {

                                $("#save_changes").removeClass("btn-progress");

                                if (response.error) {
                                    var span = document.createElement("span");
                                    span.innerHTML = response.error;

                                    swal.fire({
                                        icon: 'error',
                                        title: '<?php echo $this->lang->line('Error'); ?>',
                                        html: span,
                                    });

                                } else {
                                    var newOption = new Option(response.text, response.id, true, true);
                                    console.log();
                                    $('#contact_group').append(newOption).trigger('change');
                                }
                            }
                        });
                    }
                });

        });

        // Hides select boxes primarily

        //$(interval_time).hide()

        // For interval time code . custom for hidden
        $(document).on('change', '#form_position', function () {

            var formPosition = $('#form_position').val()
            $(interval_time).hide()

            if (formPosition == "popup") {
                $(interval_time).show()
                $(popuptype).show();
            } else {
                $(interval_time).hide()
                $(popupType).hide();
            }

        })


        var options = {
            // Makes fields to be used for one time only
            allowOneTimeFields: ['button'],

            disabledSubtypes: {text: ['color', 'password'],},

            // set control position on left side
            controlPosition: 'left',
            disableFields: ['autocomplete', 'textarea', 'radio-group', 'checkbox-group', 'date', 'time', 'number', 'hidden', , 'text', 'select', 'button', 'file'],
            fields: [
                {
                    class: "form-control",
                    label: 'Agreement Text',
                    name: "agreement_text",
                    type: "paragraph",
                    subtype: 'output',
                    icon: '☑'
                },
                {
                    class: "form-control",
                    label: 'Phone number',
                    name: "phone_number",
                    required: true,
                    type: "text",
                    subtype: 'tel',
                    icon: '📋'
                },
                {
                    label: "Email",
                    placeholder: "Enter your Email",
                    type: "text",
                    name: "email",
                    required: true,
                    subtype: "email",
                    icon: "✉"
                },
                {
                    class: "form-control",
                    label: 'Last Name',
                    placeholder: "Enter your Last name",
                    name: "last_name",
                    required: true,
                    type: "text",
                    icon: '📋'
                },
                {
                    class: "form-control",
                    label: "First Name",
                    placeholder: "Enter your first name",
                    name: "first_name",
                    required: true,
                    type: "text",
                    icon: '📰'
                },
                {
                    class: "form-control",
                    label: 'Subscription',
                    name: "button",
                    style: "primary",
                    type: "button",
                    icon: '💬'
                }

            ],

            // Default Form when page is load
            defaultFields: <?php echo $form_data; ?>,
            //control orders
            controlOrder: ["First Name", "Last Name", "Full Name", "Email", "header", "file", "text"],
            // Decides whether controls should be draggable or not
            draggableControls: true,

            // Disables action button
            disabledActionButtons: ['data'], // save, data, clear

            // event to be used when saving data
            onSave: function (e, formData) {
                e.preventDefault()

                // Prepares data
                var parsed_form_data = JSON.parse(formData)

                // Shows error if button field doesn't exist
                if (Array.isArray(parsed_form_data)) {
                    var found = parsed_form_data.find((val) => {
                        if (val && val.hasOwnProperty('type')) {
                            return val.type === 'button'
                        }
                    })

                    if (!found) {
                        swal.fire('<?php echo $this->lang->line('Warning!') ?>', '<?php echo $this->lang->line('You forgot to choose a button field') ?>', 'warning')

                        return
                    }
                }

                // Starts loading state
                e.target.classList.remove('disabled', 'btn-progress')
                e.target.classList.add('disabled', 'btn-progress')


                // Prepares form data to be submitted
                var form_data = {
                    user_id: '<?= md5($user_id) ?>',
                    form_name: $('#form-name').val(),
                    contact_group: $('#contact_group').val(),
                    sequence_email_campaign_id: $('#sequence_email_campaign_id').val(),
                    sequence_sms_campaign_id: $('#sequence_sms_campaign_id').val(),
                    form_position: $('#form_position').val(),
                    popup_type: $('#popup_type').val(),
                    response_type: $("input[name=response_type]:checked").val(),
                    success_message: $("#success_message").val(),
                    redirect_url: $("#redirect_url").val(),
                    image_link: '<?php echo $this->session->userdata("attachment_filename_scheduler"); ?>',
                    uri_canonical_id: uri_canonical_id,
                    real_canonical_id: real_canonical_id,
                    enable_country_code: $("input[name=enable_country_code]:checked").val(),
                    is_double_optin: $("input[name=is_double_optin]:checked").val(),
                    country_code_for_phone: $("#country_code_for_phone").val(),
                    interval_time: $('#interval_time_input').val() * 1000,
                    form_data: formData
                }

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('email_optin_form_builder/save_form_data') ?>',
                    dataType: 'JSON',
                    data: form_data || null,
                    success: function (response) {
                        if (response) {
                            if (response.success === true) {
                                // Shows success message
                                swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success'
                                })

                                // Changes loading state
                                e.target.classList.remove('disabled', 'btn-progress')

                                // Empties fields
                                if (parsed_form_data.length) {
                                    // Clears form name
                                    document.getElementById('form-name').value = ''

                                    // Resets page selection
                                    $('#contact_group').val(null).trigger("change")
                                    $('#sequence_email_campaign_id').val(null).trigger("change")
                                    $('#sequence_sms_campaign_id').val(null).trigger("change")
                                    $('#form_position').val(null).trigger("change")

                                    // Clears form builders
                                    var clearAll = document.querySelector('.clear-all')
                                    $(clearAll).trigger('click')

                                    // Redirects to webview manager
                                    setTimeout(function () {
                                        window.location.replace('<?= base_url('email_optin_form_builder') ?>')
                                    }, 2000)
                                }

                            } else if (response.error === true) {
                                // Shows error message
                                swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                })

                                // Changes loading state
                                e.target.classList.remove('disabled', 'btn-progress')
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('xhr: ', xhr)
                        console.log('status: ', status)

                        // Shows HTTP status error
                        swal.fire({
                            title: 'Error!',
                            text: error,
                            icon: 'error'
                        })
                    }
                })
            },
        }

        $('#optin-form-builder').formBuilder(options)

        $("#uploademail_attachment").uploadFile({
            url: '<?php echo base_url("email_optin_form_builder/ajax_attachment_upload")?>',
            fileName: "file",
            maxFileSize: 1 * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            acceptFiles: ".png,.jpg,.jpeg",
            maxFileCount: 1,
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('email_optin_form_builder/delete_attachment');?>";
                for (var i = 0; i < data.length; i++) {
                    $.post(delete_url, {op: "delete", name: data[i]},
                        function (resp, textStatus, jqXHR) {
                        });
                }
            }
        });

        // $('#optin-form-builder').formBuilder({fields})
    })

    function generate_select_box(
        options_array,
        name_attribute,
        multiple = false
    ) {
        var multi_select = multiple ? 'multiple' : '';
        var str = '';
        str += '<select class="form-control" name="' + name_attribute + '" id="' + name_attribute + '" ' + multi_select + '>';
        str += '<option value=""></option>';

        if (Array.isArray(options_array)) {
            options_array.forEach(option => {
                str += '<option value="' + option.value + '">' + option.text + '</option>';
            });
        }

        str += '</select>';

        return str;
    }
</script>