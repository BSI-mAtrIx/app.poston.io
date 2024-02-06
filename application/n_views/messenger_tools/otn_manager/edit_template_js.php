<script type="text/javascript">

    $(document).ready(function () {

        $(".dropdown-item").select2({
            tags: true,
            width: '100%'
        });

    });

</script>


<script type="text/javascript">

    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
    var base_url = "<?php echo site_url(); ?>";
    var areyousure = "<?php echo $areyousure;?>";


    <?php foreach($page_list as $key=>$value) : ?>
    var js_array_<?php echo $key ?> = [<?php echo ""; ?>];
    <?php endforeach; ?>




    $(document).ready(function () {


        $(document).on('change', '#page_table_id', function () {
            page_change_action();
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = $(".add_template").attr("page_id_add_postback");
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
            $(this).find('iframe').attr('src', iframe_link);
        });

        // refresh_template("0");
        // $("#loader").addClass('hidden');
        // getting postback list and making iframe
        //
        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var current_id = $(this).prev().prev().attr("id");
            var page_id = $(this).attr("page_id_add_postback");
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").attr("current_id", current_id);
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var current_val = $(this).prev().prev().prev().val();
            var current_id = $(this).prev().prev().prev().attr("id");
            var page_id = $(this).attr("page_id_ref_postback");
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/get_otn_postback_refresh",
                data: {page_id: page_id},
                success: function (response) {
                    $("#" + current_id).html(response).val(current_val);
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var page_id = $(".add_template").attr("page_id_add_postback");
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/get_otn_postback_refresh",
                data: {page_id: page_id},
                success: function (response) {
                    $("#" + current_id).html(response);
                }
            });
        });


        function page_change_action() {
            var page_id = $('#page_table_id').val();
            if (page_id == '') return;

            $(".add_template").attr("page_id_add_postback", page_id);
            $(".ref_template").attr("page_id_ref_postback", page_id);

            $.ajax({
                type: 'POST',
                url: base_url + 'messenger_bot/get_otn_reply_postback',
                data: {page_auto_id: page_id},
                dataType: 'JSON',
                success: function (response) {
                    setTimeout(function () {
                        $(".push_postback").html(response.dropdown);
                    }, 500);
                }
            });

            $('.show_label').addClass('hidden');
            $.ajax({
                type: 'POST',
                url: base_url + 'messenger_bot/get_label_dropdown',
                data: {page_id: page_id},
                dataType: 'JSON',
                success: function (response) {
                    $("#create_label_postback").attr("page_id_for_label", page_id); // put page_table_id for create label
                    $('.show_label').removeClass('hidden');
                    setTimeout(function () {
                        $('#first_dropdown').html(response.first_dropdown);
                    }, 500);
                }
            });

            $('.dropdown_con').addClass('hidden');
            var is_drip_campaigner_exist = '<?php echo $this->is_drip_campaigner_exist;?>';
            var is_sms_email_drip_campaigner_exist = '<?php echo $this->is_sms_email_drip_campaigner_exist;?>';
            if (is_drip_campaigner_exist == false && is_sms_email_drip_campaigner_exist == false) return;

            $.ajax({
                type: 'POST',
                url: base_url + 'messenger_bot/get_drip_campaign_dropdown',
                data: {page_id: page_id},
                dataType: 'JSON',
                success: function (response) {
                    $('.dropdown_con').removeClass('hidden');
                    setTimeout(function () {
                        $('#dripcampaign_dropdown').html(response.dropdown_value);
                    }, 500);

                }
            });
            // $('.dropdown_con').removeClass('hidden');
        }

        // create an new label and put inside label list
        $(document).on('click', '#create_label_postback', function (e) {
            e.preventDefault();

            var page_id = $(this).attr('page_id_for_label');

            swal.fire({
                title: "<?php echo $this->lang->line('Label Name'); ?>",
                input: "text",
                confirmButtonText: "<?php echo $this->lang->line('New Label'); ?>",
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


        $(document).on('click', '#submit', function (e) {
            e.preventDefault();

            var bot_name = $("#bot_name").val();
            var template_postback_id = $("#template_postback_id").val();
            var reply_postback_id = $("#reply_postback_id").val();

            var page_table_id = $("#page_table_id").val();
            var new_variable_name = "js_array_" + page_table_id;

            if (bot_name == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please Give Template Name')?>", 'warning');
                return;
            }

            if (page_table_id == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select a page')?>", 'warning');
                return;
            }

            if (template_postback_id == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please give a postback ID')?>", 'warning');
                return;
            }

            if (reply_postback_id == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please select a reply postback ID')?>", 'warning');
                return;
            }


            $(this).addClass('btn-progress');

            $("input:not([type=hidden])").each(function () {
                if ($(this).is(":visible") == false)
                    $(this).attr("disabled", "disabled");
            });


            var iframe = "<?php echo $iframe;?>";
            var temp_url = base_url + "messenger_bot/otn_edit_template_action"

            var queryString = new FormData($("#messenger_bot_form")[0]);
            $.ajax({
                context: this,
                type: 'POST',
                url: temp_url,
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == "1") {
                        if (iframe == '1') {
                            $(this).attr('disabled', 'disabled');
                            swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');
                        } else {
                            var link = "<?php echo $redirect_url; ?>";
                            swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                                window.location.assign(link);
                            });

                        }

                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }

            });

        });

    });
</script>