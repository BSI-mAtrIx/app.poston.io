<script>
    var base_url = "<?php echo site_url(); ?>";
    $("document").ready(function () {

        $('.color-picker-rgb').colorpicker({
            format: 'hex'
        });


        $(document).on('change', '#page', function (event) {
            var page_id = $(this).val();
            var id = $("#hidden_id").val();
            var table_name = "messenger_bot_engagement_2way_chat_plugin";
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/get_template_label_dropdown_edit",
                data: {page_id: page_id, id: id, table_name: table_name},
                dataType: 'JSON',
                success: function (response) {

                    if (page_id == "") {
                        $("#create_label_custom_plugin,.add_template,.ref_template").css('display', 'none');
                        $("#create_label_custom_plugin").attr('page_id_for_label', '');
                        $(".add_template").attr('page_id_add_postback', '');
                        $(".ref_template").attr('page_id_refresh_postback', '');
                    } else {
                        $("#create_label_custom_plugin,.add_template,.ref_template").css('display', 'block');
                        $("#create_label_custom_plugin").attr('page_id_for_label', page_id);
                        $(".add_template").attr('page_id_add_postback', page_id);
                        $(".ref_template").attr('page_id_refresh_postback', page_id);
                    }

                    $("#template_id").html(response.template_option);
                    $("#label_ids").html(response.label_option);
                    $("#put_script").html(response.script);
                }

            });

        });


        // create an new label and put inside label list
        $(document).on('click', '#create_label_custom_plugin', function (e) {
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
                        width: '100%'
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
                        width: '100%'
                    });
                }
            });
        });

        // ============================ Add & refresh Postback Section ===============================


        $(document).on('click', '#get_button', get_button);

        function get_button() {

            var page = $("#page").val();
            var domain_name = $("#domain_name").val();
            var template_id = $("#template_id").val();
            var reference = $("#reference").val();
            var logged_in = $("#logged_in").val();
            var logged_out = $("#logged_out").val();
            if (page == "") {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select a page.'); ?>", 'error');
                return false;
            }

            if (template_id == '') {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select OPT-IN inbox confirmation message template.'); ?>", 'error');
                return false;
            }

            if (reference == '') {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please enter an reference.'); ?>", 'error');
                return false;
            }


            if (logged_in.length > 80) {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Logged in greeting text can be maximum 80 characters long.') ?>", 'error');
                return false;
            }

            if (logged_out.length > 80) {
                swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Logged out greeting text can be maximum 80 characters long.') ?>", 'error');
                return false;
            }

            $('#get_button').addClass('btn-progress');
            var label_ids = $('#label_ids').val();

            var queryString = new FormData($("#plugin_form")[0]);

            if (label_ids == '')
                queryString.append('label_ids[]', '');

            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/customer_chat_edit_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == '1') {

                        swal.fire("<?php echo $this->lang->line('Updated Successfully'); ?>", response.message, 'success').then(function () {
                            window.location = base_url + "messenger_bot_enhancers/customer_chat_plugin_list/" + page + '/1';
                        });
                        $("#get_button").removeClass('btn-progress');
                    } else {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                        $("#get_button").removeClass('btn-progress');
                    }


                }

            });

        }

        $('#get_plugin_modal').on('hidden.bs.modal', function () {
            window.location.href = base_url + "messenger_bot_enhancers/customer_chat_plugin_list";
        });

        $(document).on('click', '#copy_js_code', function (event) {
            event.preventDefault();
            var copyText = document.getElementById("copy_code");
            copyText.select();
            document.execCommand("copy");
            iziToast.success({
                title: "",
                message: "<?php echo $this->lang->line('Copied to clipboard') ?>",
            });

        });
        $("#page").change();

    });
</script>