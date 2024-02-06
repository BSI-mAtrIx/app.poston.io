<?php
$somethingwentwrong = $this->lang->line("something went wrong.");
$doyoureallywanttodeletethisbot = $this->lang->line("do you really want to delete this bot?");
$areyousure = $this->lang->line("are you sure");
?>

<script type="text/javascript">
    $(document).ready(function (e) {

        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });

        $(".push_postback").select2({
            tags: true,
            width: '100%'
        });


        var default_page = "<?php echo $default_page; ?>";
        if (default_page != '') page_change_action();


        $(document).on('change', '#page_table_id', function () {
            page_change_action();
        });


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
            }).then((value) => {

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


        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = $(".add_template").attr("page_id_add_postback");
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
            $(this).find('iframe').attr('src', iframe_link);
        });
        refresh_template("0");
        $("#loader").addClass('hidden');
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
                url: base_url + "messenger_bot/get_postback",
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


        function refresh_template(is_from_add_button = '1') {
            var page_id = $(this).attr("page_id_ref_postback");
            if (page_id == "") {
                alertify.alert('<?php echo $this->lang->line("Alert"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", function () {
                });
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/get_otn_postback_refresh",
                data: {page_id: page_id, order_by: "template_name", is_from_add_button: is_from_add_button},
                success: function (response) {
                    $(".push_postback").html(response);
                }
            });
        }

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
                $(".show_label #create_label_postback").attr("page_id_for_label", page_id); // put page_table_id for create label
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

</script>


<script type="text/javascript">
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
    var base_url = "<?php echo site_url(); ?>";

    <?php foreach($page_list as $key=>$value) : ?>
    var js_array_<?php echo $key ?> = [<?php echo ""; ?>];
    <?php endforeach; ?>


    var areyousure = "<?php echo $areyousure;?>";

    $(document).ready(function () {

        function hasDuplicates(array) {
            var valuesSoFar = Object.create(null);
            for (var i = 0; i < array.length; ++i) {
                var value = array[i];
                if (value in valuesSoFar) {
                    return true;
                }
                valuesSoFar[value] = true;
            }
            return false;
        }


        $(document).on('click', '#submit', function (e) {
            e.preventDefault();

            var bot_name = $("#bot_name").val();
            var template_postback_id = $("#template_postback_id").val();
            var reply_postback_id = $("#reply_postback_id").val();

            var reg = /^[0-9a-z_ -]+$/i;
            var output = reg.test(template_postback_id);
            if (output === false) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line('There is disallowed characters in your main PostBack Id')?>', 'warning');
                return;
            }

            var page_table_id = $("#page_table_id").val();


            var keyword_type = $("input[name=keyword_type]:checked").val();

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

            var queryString = new FormData($("#messenger_bot_form")[0]);
            $.ajax({
                context: this,
                type: 'POST',
                url: base_url + "messenger_bot/otn_create_template_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == '1') {
                        var link = "<?php echo site_url('messenger_bot/otn_template_manager/'); ?>" + page_table_id + '/1';
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', "<?php echo $this->lang->line('Template has been created successfully.'); ?>", 'success').then((value) => {
                            window.location.assign(link);
                        });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }

                }

            });

        });


    });
</script>