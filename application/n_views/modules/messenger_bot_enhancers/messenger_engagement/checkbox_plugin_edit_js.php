<script>
    var base_url = "<?php echo site_url(); ?>";
    $("document").ready(function () {

        $('.color-picker-rgb').colorpicker({
            format: 'hex'
        });
        $('.new_button_block,.redirect_block,.display_button_block').css('display', 'none');

        // $(document).on('change', '#new_or_old', function(event) {
        // 	event.preventDefault();

        // 	var checkBox = document.getElementById("new_or_old");
        // 		if (checkBox.checked == true)
        // 		{
        // 			$('.new_button_block').show(500);
        // 			$('.existing_button_block').hide(500);

        // 		}
        // 		else
        // 		{
        // 			$('.new_button_block').hide(500);
        // 			$('.existing_button_block').show(500);

        // 		}


        // 	});
        $(document).on('change', '#redirect_or_not', function (event) {

            var r_or_not = document.getElementById("redirect_or_not");

            if (r_or_not.checked == true) {
                $('.redirect_block').show(500);
                $('.display_messsage_block').hide(500);
            } else {
                $('.display_messsage_block').show(500);
                $('.redirect_block').hide(500);
                if ($('input[name=add_button_with_message]').prop('checked'))
                    $('.display_button_block').show();
                else
                    $('.display_button_block').hide();
            }

        });

        $(document).on('click', '#add_button_with_message', function (event) {

            var btnw_msg = document.getElementById('add_button_with_message');
            if (btnw_msg.checked == true)
                $('.display_button_block').show(500);
            else
                $('.display_button_block').hide(500);

        });

        $(document).on('change', '#page', function (event) {
            event.preventDefault();

            var page_id = $(this).val();
            var id = $("#hidden_id").val();
            var table_name = "messenger_bot_engagement_checkbox";

            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/get_template_label_dropdown_edit",
                data: {page_id: page_id, id: id, table_name: table_name},
                dataType: 'JSON',
                success: function (response) {

                    if (page_id == "") {
                        $("#create_label_checkbox_plugin,.add_template,.ref_template").css('display', 'none');
                        $("#create_label_checkbox_plugin").attr('page_id_for_label', '');
                        $(".add_template").attr('page_id_add_postback', '');
                        $(".ref_template").attr('page_id_refresh_postback', '');

                    } else {

                        $("#create_label_checkbox_plugin,.add_template,.ref_template").css('display', 'block');
                        $("#create_label_checkbox_plugin").attr('page_id_for_label', page_id);
                        $(".add_template").attr('page_id_add_postback', page_id);
                        $(".ref_template").attr('page_id_refresh_postback', page_id);
                    }

                    $("#template_id").html(response.template_option);
                    $("#label_ids").html(response.label_option);
                    $("#put_script").html(response.script);
                }

            });
        });


        // ===================== add & refresh postback section ====================

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = $(".add_template").attr("page_id_add_postback");
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
            $(this).find('iframe').attr('src', iframe_link);
        });
        // getting postback list and making iframe

        // add postback template modal
        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();

            var page_id = $(this).attr("page_id_add_postback");
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $("#template_id").val();
            var page_id = $(this).attr("page_id_refresh_postback");

            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: base_url + "home/common_get_postback",
                data: {page_id: page_id},
                success: function (response) {
                    $("#template_id").html(response).val(current_val);
                    $('#template_id').select2({
                        width: '100%',
                    });
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_val = $("#template_id").val();
            var page_id = $(".add_template").attr("page_id_add_postback");
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "home/common_get_postback",
                data: {page_id: page_id},
                success: function (response) {
                    $("#template_id").html(response);
                    $('#template_id').select2({
                        width: '100%',
                    });
                }
            });
        });

        // ============================ Add & refresh Postback Section ===============================


        // create an new label and put inside label list
        $(document).on('click', '#create_label_checkbox_plugin', function (e) {
            e.preventDefault();

            var page_id = $(this).attr('page_id_for_label');

            swal.fire({
                title: "<?php echo $this->lang->line('Label Name'); ?>",
                input: "text",
                confirmButtonText: "<?php echo $this->lang->line('Create'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('Cancel'); ?>",
                showCancelButton: true,
            })
                .then((value) => {
                    if (value.isDenied || value.isDismissed) {
                        return;
                    }
                    var label_name = `${value.value}`;
                    if (label_name != "" && label_name != 'null') {
                        $("#save_changes").addClass("btn-progress");
                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo site_url();?>home/common_create_label_and_assign",
                            data: {page_id: page_id, label_name: label_name},
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
                                    $('#label_ids').append(newOption).trigger('change');
                                }
                            }
                        });
                    }
                });
        });

        $(document).on('click', '#get_button', get_button);

        function get_button() {

            var page = $("#page").val();
            var domain_name = $("#domain_name").val();
            var id_or_class_value = $("#id_or_class_value").val();
            var new_button_display = $("#new_button_display").val();
            var template_id = $("#template_id").val();
            var reference = $("#reference").val();

            if (page == "") {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select a page.'); ?>", 'error');
                return false;
            }

            if (domain_name == "") {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please put your domain name.'); ?>", 'error');
                return false;
            }

            // if($('#new_or_old').val()=='1' && new_button_display=='')
            // {
            // 	swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please enter new button text.'); ?>", 'error');
            // 	return false;
            // }

            // if($('#new_or_old').val()=='0' && id_or_class_value=='')
            // {
            // 	swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please enter ID/class value.'); ?>", 'error');
            // 	return false;
            // }


            if ($("#redirect_or_not").val() == "1") {
                if ($("#success_redirect_url").val() == '') {
                    swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('OPT-IN success redirect URL is required.'); ?>", 'error');
                    return false;
                }
            } else {
                if ($('input[name=add_button_with_message]').prop('checked')) {
                    if ($("#success_button").val() == '' || $("#success_url").val() == '') {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Missing OPT-IN success button parameters.'); ?>", 'error');
                        return false;
                    }
                }
            }

            if (template_id == '') {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select OPT-IN inbox confirmation message template.'); ?>", 'error');
                return false;
            }

            if (reference == '') {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please enter an reference.'); ?>", 'error');
                return false;
            }


            $("#response").attr('class', '').html('');
            $('#get_button').addClass('btn-progress');

            var queryString = new FormData($("#plugin_form")[0]);
            // var new_or_old = document.getElementById("new_or_old");
            var redirect_or_not = document.getElementById("redirect_or_not");
            // if(new_or_old.checked == true)
            // 	queryString.append('new_button','1');
            // else
            // 	queryString.append('new_button','0');
            if (redirect_or_not.checked == true)
                queryString.append('redirect', '1');
            else
                queryString.append('redirect', '0');
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/checkbox_plugin_edit_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {

                    if (response == '1') {

                        swal.fire("<?php echo $this->lang->line('Updated Successfully'); ?>", "<?php echo $this->lang->line('Plugin has been updated successfully.') ?>", 'success').then(function () {
                            window.location = base_url + "messenger_bot_enhancers/checkbox_plugin_list/" + page + "/1";
                        });
                        $("#get_button").removeClass('btn-progress');
                    } else {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Something went wrong') ?>", 'error');
                        $("#get_button").removeClass('btn-progress');
                    }


                }

            });

        }

        $("#page").val('<?php echo $xdata["page_id"];?>').attr('disabled', 'disabled').change();
        $("#domain_name").val('<?php echo $xdata["domain_name"];?>').attr('disabled', 'disabled');
        $("#language").val('<?php echo $xdata["language"];?>');

        var skin = '<?php echo $xdata["skin"];?>';
        $('input[type="radio"][name="skin"][value="' + skin + '"]').attr('checked', 'checked');

        var center_align = '<?php echo $xdata["center_align"];?>';
        $('input[type="radio"][name="center_align"][value="' + center_align + '"]').attr('checked', 'checked');

        var btn_size = '<?php echo $xdata["btn_size"];?>';
        $('input[type="radio"][name="btn_size"][value="' + btn_size + '"]').attr('checked', 'checked');

        /*
        var js_event='<?php echo $xdata["js_event"];?>';
		$('input[type="radio"][name="js_event"][value="'+js_event+'"]').attr('checked','checked');

		var new_button='<?php echo $xdata["new_button"];?>';
		if(new_button == '1')
			$('#new_or_old').click();

		var element_type='<?php echo $xdata["element_type"];?>';
		$('input[type="radio"][name="element_type"][value="'+element_type+'"]').attr('checked','checked');

		var new_button_position='<?php echo $xdata["new_button_position"];?>';
		$('input[type="radio"][name="new_button_position"][value="'+new_button_position+'"]').attr('checked','checked');
		*/

        var add_button_with_message = '<?php echo $xdata["add_button_with_message"];?>';
        if (add_button_with_message == '1')
            $('#add_button_with_message').click();

        /*
        $("#id_or_class_value").val('<?php echo $xdata["id_or_class_value"];?>');
		$("#new_button_bg_color").val('<?php echo $xdata["new_button_bg_color"];?>').change();
		$("#new_button_color").val('<?php echo $xdata["new_button_color"];?>').change();
		$("#new_button_bg_color_hover").val('<?php echo $xdata["new_button_bg_color_hover"];?>').change();
		$("#new_button_color_hover").val('<?php echo $xdata["new_button_color_hover"];?>').change();
		*/

        $("#button_click_success_message").val("<?php echo $xdata['button_click_success_message'];?>");
        $("#success_redirect_url").val('<?php echo $xdata["success_redirect_url"];?>');
        $("#success_button").val('<?php echo $success_button;?>');
        $("#success_url").val('<?php echo $success_url;?>');
        $("#success_button_bg_color").val('<?php echo $success_button_bg_color;?>').change();
        $("#success_button_color").val('<?php echo $success_button_color;?>').change();
        $("#success_button_bg_color_hover").val('<?php echo $success_button_bg_color_hover;?>').change();
        $("#success_button_color_hover").val('<?php echo $success_button_color_hover;?>').change();

        var redirect_or_not = '<?php echo $xdata["redirect"];?>'
        if (redirect_or_not == '1')
            $('#redirect_or_not').click();

        $("#validation_error").val('<?php echo $xdata["validation_error"];?>');
        $("#reference").val('<?php echo $xdata["reference"];?>').attr('disabled', 'disabled');

    });
</script>