<?php

$somethingwentwrong = $this->lang->line("Something went wrong.Please try again.");
$drop_menu = '<a id="add_bot_settings" href="" class="float-right btn btn-primary"><i class="bx bx-plus-circle"></i> ' . $this->lang->line("Add Sequence") . '</a>';
?>

<script type="text/javascript">
    var day_counter = '<?php echo $default_display;?>';
    var hour_counter = '<?php echo $default_display_hour;?>';
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
    var base_url = "<?php echo site_url(); ?>";
    var page_auto_id = '<?php echo $page_auto_id; ?>';
    var media_type = '<?php echo $media_type; ?>';

    //var drop_menu = '<?php //echo $drop_menu;?>//';
    //setTimeout(function(){
    //    $("#mytable_filter").append(drop_menu);
    //}, 1000);


    var table = $("#mytable").DataTable({
        language:
            {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
        dom: '<"top"f>rt<"bottom"lip><"clear">'
    });


    function refresh_template(push_id) {
        var page_id = '<?php echo $page_auto_id;?>';
        $.ajax({
            type: 'POST',
            url: base_url + "messenger_bot_enhancers/get_postback_sequence",
            data: {page_id: page_id, push_id: push_id, media_type: media_type},
            success: function (response) {
                $("#push_postback" + push_id).html(response);
            }
        });
    }

    function hour_refresh_template(push_id) {
        var page_id = '<?php echo $page_auto_id;?>';
        $.ajax({
            type: 'POST',
            url: base_url + "messenger_bot_enhancers/get_postback_sequence/1",
            data: {page_id: page_id, push_id: push_id, media_type: media_type},
            success: function (response) {
                $("#hour_push_postback" + push_id).html(response);
            }
        });
    }

    $("document").ready(function () {

        var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?><?php echo $page_info['id'] . '/0/' . $media_type;?>";
        $('#add_template_modal').on('shown.bs.modal', function () {
            $(this).find('iframe').attr('src', iframe_link);
        });

        $(".timepicker_x").datetimepicker({
            datepicker: false,
            format: "H:i"
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


        $(document).on('click', '#add_bot_settings', function (e) {
            e.preventDefault();
            $("#add_bot_settings_modal").removeClass('hidden');
            $("#setting_list").hide();
            $(".bot_success").hide();
            $("#error_message").addClass('hidden');
            $('html, body').animate({scrollTop: $("#add_bot_settings_modal").offset().top}, 2000);
        });


        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var push_id = $(this).attr('data-id');
            refresh_template(push_id);
        });

        $(document).on('click', '.hour_ref_template', function (e) {
            e.preventDefault();
            var push_id = $(this).attr('data-id');
            hour_refresh_template(push_id);
        });


        $(document).on('click', '.delete_bot', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            var somethingwentwrong = "<?php echo $somethingwentwrong; ?>";

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this campaign?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $(this).parent().prev().addClass('btn-progress');
                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo base_url('messenger_bot_enhancers/delete_sequecne_campaign')?>",
                            data: {id: id, page_auto_id: page_auto_id},
                            success: function (response) {
                                $(this).parent().prev().removeClass('btn-progress');
                                if (response == '1') {
                                    swal.fire('<?php echo $this->lang->line("Campaign Deleted"); ?>', "<?php echo $this->lang->line('Camapign has been deleted successfully.')?>", 'success');
                                    window.location.assign("<?php echo base_url('messenger_bot_enhancers/sequence_message_campaign/' . $page_auto_id . '/1/');?>" + media_type);
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', somethingwentwrong, 'error');
                                }
                            }
                        });
                    }
                });
        });

        $(document).on('click', '#add_more_day', function (e) {
            e.preventDefault();
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
            if (hour_counter < 2) {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You can not remove the last item.')?>", 'error');
                return false;
            }
            $("#hour_container" + hour_counter).addClass('hidden');
            hour_counter--;
            $('#hour_counter').val(hour_counter);
        });

        $(document).on('change', 'input[name=drip_type]', function () {
            if ($("input[name=drip_type]:checked").val() == "default" || $("input[name=drip_type]:checked").val() == "custom") {
                $("#engagement_block").addClass('hidden');
                $("#loader2").addClass('hidden');
            } else {
                $("#loader2").removeClass('hidden');
                var table_name = $("input[name=drip_type]:checked").val();
                $("#engagement_block").addClass('hidden');

                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('messenger_bot_enhancers/get_engagement_list')?>",
                    data: {table_name: table_name, page_auto_id: page_auto_id},
                    success: function (response) {
                        $("#put_engegement_content").html(response);
                        $("#loader2").addClass('hidden');
                        $("#engagement_block").removeClass('hidden');
                    }
                });

            }
        });

        $(document).on('click', '.message_content', function (e) {
            e.preventDefault();
            var campaign_id = $(this).attr('data-id'); // campaign id
            var is_day = $(this).attr('data-day');
            $('#message_content_modal_content').html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');
            $("#message_content_modal").modal();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>messenger_bot_enhancers/get_campaign_report",
                data: {campaign_id: campaign_id, is_day: is_day, media_type: media_type},
                success: function (response) {
                    $('#message_content_modal_content').html(response);
                }
            });
        });


        $(document).on('click', '#submit_btn', function (e) {
            e.preventDefault();

            var drip_type = $("input[name=drip_type]:checked").val();
            if (drip_type != "default" && drip_type != "custom")
                var engagement_table_id = $("input[name=engagement_table_id]:checked").val();
            if (drip_type != "default" && drip_type != "custom" && typeof (engagement_table_id) === 'undefined') {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('You have not selected any engagement campaign to re-target.')?>", 'error');
                return;
            }

            var message_type = $(".nav-link.active").attr("href");
            if (message_type == "#daywise" && $("#message_tag").val() == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please choose a message tag.')?>", 'error');
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

            var queryString = new FormData($("#plugin_form")[0]);
            $.ajax({
                context: this,
                type: 'POST',
                url: base_url + "messenger_bot_enhancers/create_sequence_campaign_action",
                data: queryString,
                dataType: 'JSON',
                // async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(this).removeClass('btn-progress');

                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Campaign Created"); ?>', response.message, 'success').then((value) => {
                            window.location.assign("<?php echo base_url('messenger_bot_enhancers/sequence_message_campaign/' . $page_auto_id . '/1/');?>" + media_type);
                        });
                    } else swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }

            });

        });

    });
</script>