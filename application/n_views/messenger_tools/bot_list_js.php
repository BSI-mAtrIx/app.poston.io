<script type="text/javascript">
    $(document).ready(function () {
        // $('[data-toggle="tooltip"]').tooltip();
        $('body').addClass('menu-collapsed');
        $('.brand-logo').removeClass('d-none');
        $('#bot_list_select').select2();
    });

    function htmlspecialchars_decode(str) {
        if (typeof (str) == "string") {
            str = str.replace("&amp;", /&/g);
            str = str.replace("&quot;", /"/g);
            str = str.replace("&#039;", /'/g);
            str = str.replace("&#92;", /\\/g);
            str = str.replace("&lt;", /</g);
            str = str.replace("&gt;", />/g);
        }
        return str;
    }

    function refresh_sequence_list(page_table_id, campaign_type, current_campaign_id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>" + "messenger_bot/refresh_sequence_campaign_lists",
            data: {
                page_table_id: page_table_id,
                campaign_type: campaign_type,
                current_campaign_id: current_campaign_id
            },
            success: function (response) {
                if (campaign_type == "sms") {
                    $("#sequence_sms_campaign_id").html(response);
                }

                if (campaign_type == "email") {
                    $("#sequence_email_campaign_id").html(response);
                }
            }
        });
    }

    $(document).ready(function () {

        var base_url = "<?php echo base_url(); ?>";

        $(document).on('shown.bs.collapse', '.collapse', function (e) {
            // $(this).parent().prev().children().css("font-size",'40px');
            $(".collapse").not(this).collapse('hide');
        });


        $(document).on('hidden.bs.collapse', '.collapse', function (e) {
            // $(this).parent().prev().children().css("font-size",'22px');

        });

        $(document).on('click', '.btn', function (e) {
            // $(this).parent().prev().children().css("font-size",'22px');
            $('[data-toggle="tooltip"]').tooltip('hide');
        });


        $(document).on('click', '.variables', function (e) {
            $("#variable_display_section").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');
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

        $(document).on('change', '#switch_media', function (event) {
            event.preventDefault();
            var switch_media_type = $('input[name=switch_media]:checked').val();
            if (typeof (switch_media_type) == 'undefined') {
                switch_media_type = 'ig';
            }

            $.ajax({
                url: base_url + 'home/switch_to_media',
                type: 'POST',
                data: {media_type: switch_media_type},
                success: function (response) {
                    window.location.assign('<?php echo base_url('messenger_bot/bot_list'); ?>');
                }
            });
        });

        $(document).on('click', '.refresh_campaign_lists', function (event) {
            event.preventDefault();
            var page_table_id = $('#bot_list_select').val();
            var campaign_type = $(this).attr("cam_type");
            if (campaign_type == 'sms') var current_campaign_id = $("#sequence_sms_campaign_id").val();
            if (campaign_type == 'email') var current_campaign_id = $("#sequence_email_campaign_id").val();

            refresh_sequence_list(page_table_id, campaign_type, current_campaign_id);
        });

        $(document).on('click', '#add_more_question_button', function (event) {
            event.preventDefault();

            var question_block_counter = $("#question_block_counter").val();
            question_block_counter = parseInt(question_block_counter, 10) + 1;

            var postback_drop_down = '';
            var page_table_id = $('#bot_list_select').val();
            var hidden_media_type = $("#hidden_media_type").val();
            var get_data_url = base_url + "messenger_bot/get_postback";
            if (hidden_media_type == 'ig')
                get_data_url = base_url + "messenger_bot/get_ig_postback";

            $.ajax({
                type: 'POST',
                url: get_data_url,
                data: {page_id: page_table_id, is_from_add_button: '0'},
                success: function (response) {
                    var upper_limit = 0;
                    if (hidden_media_type == 'ig') upper_limit = 5;
                    else upper_limit = 11;

                    if (question_block_counter < upper_limit) {
                        $('.add_more_question_block').before('<div class="single_question_block"><p class="clearfix"><b><?php echo $this->lang->line('Question Block'); ?></b> <button class="btn btn-sm btn-outline-secondary float-right remove_question_div"><i class="bx bx-time"></i> <?php echo $this->lang->line('Remove'); ?></button></p><div class="input-group" style="margin-bottom: 5px;"><div class="input-group-prepend"><div class="input-group-text" style="font-weight: bold;"><?php echo $this->lang->line("Type your question"); ?></div></div><input class="form-control" type="text" name="questions[]"></div><div class="input-group"><div class="input-group-prepend"><div class="input-group-text" style="font-weight: bold;"><?php echo $this->lang->line("Reply Message Template"); ?></div></div><select class="form-control" id="select_tag_id_' + question_block_counter + '" name="question_replies[]">' + response + '</select></div><a href="" class="add_template float-left"><i class="bx bx-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template"); ?></a><a href="" class="ref_template float-right"><i class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?></a><br/></div>');

                        $("#question_block_counter").val(question_block_counter);
                    } else
                        $("#add_more_question_button").attr('disabled', 'true');

                }
            });


        });

        $(document).on('click', '.remove_question_div', function (event) {
            event.preventDefault();

            var parent_div = $(this).parent().parent();
            $(parent_div).remove();

            var question_block_counter = parseInt($("#question_block_counter").val(), 10);
            $("#question_block_counter").val(question_block_counter - 1);
            $("#add_more_question_button").removeAttr('disabled');
        });

        $(document).on('change', '#ice_breaker_status', function () {
            var ice_breaker_status = $(this).val();
            if (ice_breaker_status == '1') $("#questionaries_block").show();
            else $("#questionaries_block").hide();
        });

        $(document).on('click', '#ice_breaker_info', function (event) {
            $("#ice_breaker_info_modal").modal();
        });


        $(document).on('click', '.add_template', function (e) {
            e.preventDefault();
            var select_tag = $(this).prev()[0].children.item(1);
            var current_id = $(select_tag).attr('id');
            var current_val = $(select_tag).val();
            var page_id = $('#bot_list_select').val();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }
            $("#add_template_modal").attr("current_id", current_id);
            $("#add_template_modal").attr("current_val", current_val);
            $("#add_template_modal").modal();
        });

        $(document).on('click', '.ref_template', function (e) {
            e.preventDefault();
            var select_tag = $(this).prev().prev()[0].children.item(1);
            var current_val = $(select_tag).val();
            var current_id = $(select_tag).attr('id');

            var page_id = $('#bot_list_select').val();

            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }

            var hidden_media_type = $("#hidden_media_type").val();
            var get_data_url = base_url + "messenger_bot/get_postback";
            if (hidden_media_type == 'ig')
                get_data_url = base_url + "messenger_bot/get_ig_postback";

            $.ajax({
                type: 'POST',
                url: get_data_url,
                data: {page_id: page_id},
                // dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response).val(current_val);
                }
            });
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var current_val = $("#add_template_modal").attr("current_val");
            var page_id = $('#bot_list_select').val();
            if (page_id == "") {
                swal.fire('<?php echo $this->lang->line("Error"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", 'error');
                return false;
            }

            var hidden_media_type = $("#hidden_media_type").val();
            var get_data_url = base_url + "messenger_bot/get_postback";
            if (hidden_media_type == 'ig')
                get_data_url = base_url + "messenger_bot/get_ig_postback";

            $.ajax({
                type: 'POST',
                url: get_data_url,
                data: {page_id: page_id, is_from_add_button: '1'},
                // dataType: 'JSON',
                success: function (response) {
                    $("#" + current_id).html(response);
                }
            });
        });

        // getting postback list and making iframe
        $('#add_template_modal').on('shown.bs.modal', function () {
            var page_id = $('#bot_list_select').val();
            var media_type = "<?php echo $media_type; ?>";
            var rand_time = "<?php echo time(); ?>";
            var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id + "/0/" + media_type + "?lev=" + rand_time;
            // var iframe_link="<?php echo base_url('messenger_bot/create_new_template/1/');?>"+page_id;
            $(this).find('iframe').attr('src', iframe_link);
        });
        // getting postback list and making iframe


        $("#mailchimp_list_id,#sms_api_id,#email_api_id,#sendinblue_list_id2,#activecampaign_list_id2,#mautic_list_id2,#acelle_list_id2,#sequence_sms_api_id,#sequence_email_api_id").select2({width: "100%"});

        $('#bot_list_select').on('change', function (e) {
            e.preventDefault();
            $('#middle_column .waiting').show();
            $('#middle_column_content').hide();
            $('#right_column .waiting').show();
            $('#right_column .main_card').hide();

            var page_table_id = $('#bot_list_select').val();
            //$('.page_list_item').removeClass('active');
            //$(this).addClass('active');

            var media_type = "<?php echo $media_type; ?>";

            var analytics_bot_href = "<?php echo base_url('/messenger_bot_analytics/result/'); ?>" + page_table_id;
            var tree_bot_href = "<?php echo base_url('messenger_bot/tree_view/'); ?>" + page_table_id;
            var visual_flow_url = "<?php echo base_url('visual_flow_builder/flowbuilder_manager/'); ?>" + page_table_id;

            $(".export_bot").attr('table_id', page_table_id);
            $(".import_bot").attr('table_id', page_table_id);

            $(".analytics_bot").attr('href', analytics_bot_href).attr('target', '_BLANK');
            $(".tree_bot").attr('href', tree_bot_href).attr('target', '_BLANK');
            $(".visual_flow_campaigns").attr('href', visual_flow_url).attr('target', '_BLANK');
            /* Analytics Page herf create */
            var analytics_page_href = "<?php echo base_url('/page_analytics/analytics/') ?>" + page_table_id;
            $(".analytics_page").attr('href', analytics_page_href).attr('target', '_BLANK');
            /* Analytics Page herf create End */

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>messenger_bot/get_page_details",
                data: {page_table_id: page_table_id, media_type: media_type},
                dataType: 'JSON',
                success: function (response) {
                    $("#mailchimp_list_id").val(response.selected_mailchimp_list_ids).trigger('change');
                    $("#sendinblue_list_id2").val(response.selected_sendinblue_list_ids).trigger('change');
                    $("#activecampaign_list_id2").val(response.selected_activecampaign_list_ids).trigger('change');
                    $("#mautic_list_id2").val(response.selected_mautic_list_ids).trigger('change');
                    $("#acelle_list_id2").val(response.selected_acelle_list_ids).trigger('change');

                    $("#sms_api_id").val(response.sms_api_id).trigger('change');
                    $("#sms_reply_message").val(response.sms_reply_message);

                    $("#email_api_id").val(response.email_api_id).trigger('change');
                    $("#email_reply_message").val(response.email_reply_message);
                    $("#email_reply_subject").val(response.email_reply_subject);

                    // sms email drip addon
                    $("#sequence_sms_campaign_div").html(response.sequence_sms_div_html);
                    $("#sequence_email_campaign_div").html(response.sequence_email_div_html);
                    $("#sequence_sms_api_id").val(response.sequence_sms_api_id).trigger('change');
                    $("#sequence_email_api_id").val(response.sequence_email_api_id).trigger('change');
                    $("#sequence_sms_campaign_id").val(response.sequence_sms_campaign_id).trigger('change');
                    $("#sequence_email_campaign_id").val(response.sequence_email_campaign_id).trigger('change');

                    // sms email drip addon

                    response.ice_breaker_html = response.ice_breaker_html.replace('fa fa-plus-circle', 'bx bx-plus-circle');
                    response.ice_breaker_html = response.ice_breaker_html.replace('fa fa-refresh', 'bx bx-refresh');
                    response.ice_breaker_html = response.ice_breaker_html.replace('add_template ', 'add_template  ');

                    $("#questionaries_block").html(response.ice_breaker_html);
                    $("#ice_breaker_status").val(response.ice_breaker_status);
                    if (response.ice_breaker_status == '0')
                        $("#questionaries_block").hide();
                    else
                        $("#questionaries_block").show();

                    var data = response.middle_column_content;

                    data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                    data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                    data = data.replaceAll('fas fa-map', 'bx bx-map');
                    data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                    data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                    data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                    data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                    data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');

                    data = data.replaceAll('fas fa-code', 'bx bx-code');
                    data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                    data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                    data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                    data = data.replaceAll('far fa-copy', 'bx bx-copy');
                    data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                    data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                    data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                    data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                    data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                    data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                    data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                    data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                    data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                    data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                    data = data.replaceAll('fa fa-user', 'bx bx-user');
                    data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                    data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                    data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                    data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                    data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                    data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                    data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                    data = data.replaceAll('fas fa-key', 'bx bx-key');
                    data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                    data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                    data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                    data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                    data = data.replaceAll('fa fa-send', 'bx bx-send');
                    data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                    data = data.replaceAll('fa fa-code', 'bx bx-code');
                    data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                    data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                    data = data.replaceAll('fas fa-play', 'bx bx-play');
                    data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                    data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                    data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                    data = data.replaceAll('swal(', 'swal.fire(');
                    data = data.replaceAll('rounded-circle', 'rounded-circle');
                    data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                    data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                    data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                    data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                    data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                    data = data.replaceAll('padding-10', 'p-10');
                    data = data.replaceAll('padding-left-10', 'pl-10');
                    data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                    data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                    data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                    data = data.replaceAll('fas fa-city', 'bx bxs-city');
                    data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                    data = data.replaceAll('fas fa-at', 'bx bx-at');
                    data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                    data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                    data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                    data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                    data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                    data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                    data = data.replaceAll('"></i>', ' mr-1"></i>');
                    data = data.replaceAll('-slash', '');
                    data = data.replaceAll('col-12', 'col-12 p-0');
                    data = data.replaceAll('class="card-body"', 'class="card-body pb-1"');


                    $("#middle_column_content").html(data).show();
                    $('#middle_column .waiting').hide();
                    // $("#reply_settings").click();
                    $("#bot_flow_settings").click();
                    $("#getstarted_button_edit_url").attr('href', response.getstarted_button_edit_url);


                    response.action_buttons_str = response.action_buttons_str.replaceAll('h4', 'h5');


                    response.action_buttons_str = response.action_buttons_str.replaceAll('Get-started Template', '<?php echo $this->lang->line('Get-started Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('No Match Template', '<?php echo $this->lang->line('No Match Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Un-subscribe Template', '<?php echo $this->lang->line('Un-subscribe Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Re-subscribe Template', '<?php echo $this->lang->line('Re-subscribe Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Email Quick Reply Template', '<?php echo $this->lang->line('Email Quick Reply Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Phone Quick Reply Template', '<?php echo $this->lang->line('Phone Quick Reply Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Location Quick Reply Template', '<?php echo $this->lang->line('Location Quick Reply Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Birthday Quick Reply Template', '<?php echo $this->lang->line('Birthday Quick Reply Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Chat with Human Template', '<?php echo $this->lang->line('Chat with Human Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Chat with Robot Template', '<?php echo $this->lang->line('Chat with Robot Template'); ?>');

                    response.action_buttons_str = response.action_buttons_str.replaceAll('Story Mention Template', '<?php echo $this->lang->line('Story Mention Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Story Private Reply Template', '<?php echo $this->lang->line('Story Private Reply Template'); ?>');
                    response.action_buttons_str = response.action_buttons_str.replaceAll('Message Unsend Private Reply Template', '<?php echo $this->lang->line('Message Unsend Private Reply Template'); ?>');


                    $("#action_button_settings_lists").html(response.action_buttons_str);

                    response.sequence_message_button_str = response.sequence_message_button_str.replaceAll('Messenger Sequence', '<?php echo $this->lang->line('Messenger Sequence'); ?>');
                    response.sequence_message_button_str = response.sequence_message_button_str.replaceAll('SMS/Email Sequence', '<?php echo $this->lang->line('SMS/Email Sequence'); ?>');


                    $("#sequence_message_settings_lists").html(response.sequence_message_button_str);


                    response.messenger_engagment_str = response.messenger_engagment_str.replaceAll('Checkbox plugin', '<?php echo $this->lang->line('Checkbox plugin'); ?>');
                    response.messenger_engagment_str = response.messenger_engagment_str.replaceAll('Send to Messenger', '<?php echo $this->lang->line('Send to Messenger'); ?>');
                    response.messenger_engagment_str = response.messenger_engagment_str.replaceAll('M.me Link', '<?php echo $this->lang->line('M.me Link'); ?>');
                    response.messenger_engagment_str = response.messenger_engagment_str.replaceAll('Customer Chat Plugin', '<?php echo $this->lang->line('Customer Chat Plugin'); ?>');


                    $("#messenger_engagement_settings_lists").html(response.messenger_engagment_str);


                    response.user_input_flow_str = response.user_input_flow_str.replaceAll('User Input Flow', '<?php echo $this->lang->line('User Input Flow'); ?>');
                    response.user_input_flow_str = response.user_input_flow_str.replaceAll('Custom Fields', '<?php echo $this->lang->line('Custom Fields'); ?>');

                    $("#user_input_settings_lists").html(response.user_input_flow_str);
                }
            });
        });

        $(document).on('click', '.iframed', function (e) {
            e.preventDefault();
            var iframe_url = $(this).attr('href');
            var iframe_height = $(this).attr('data-height');
            $("#right_column_content iframe").attr('src', iframe_url).show();
            $("#right_column_bottom_content").hide();
            // $("#right_column_content iframe").attr('height',iframe_height);
            $("#right_column .main_card").show();
            $('#right_column .waiting').hide();

            var find_block = $(this).parent().parent().attr('block-name');
            if (typeof find_block !== 'undefined' && find_block !== false) {
                //$(".has_children").attr(find_block).addClass('active');
            }

            $(window).scrollTop(94);
            if ($(this).hasClass("collapse_items")) {
                $('.iframed').not(this).parent().parent().prev().removeClass('text-primary font-weight-bold');
                $(this).parent().parent().prev().addClass('text-primary font-weight-bold');
                $('.collapse_items').removeClass('active');
                $(this).addClass('active');
                $('.card-condensed').removeClass('active');
            } else {

                $('.card-condensed').removeClass('active');
                $(this).parents('.card-condensed').addClass('active');
            }

            var title = '';
            if ($(this).hasClass('dropdown-item')) title = $(this).html();
            else {
                title = $(this).parents('.card-condensed').children('.card-icon').html();

                if ($(this).parents('.card-condensed').children('.card-body').children('h5').html() != undefined) {
                    title += $(this).parents('.card-condensed').children('.card-body').children('h5').html();
                } else {
                    title += $(this).parents('.card-condensed').children('.card-body').children('h4').html();
                }

            }
            $("#right_column_title").html(title);

        });

        $(document).on('click', '.has_childs', function (event) {
            event.preventDefault();
            $('.has_childs').removeClass("active");
            $(this).removeClass("active");
        });

        $(document).on('click', '.check_review_status_class', function (e) {
            e.preventDefault();
            var auto_id = $(this).attr('data-id');
            if (auto_id == "") return false;
            $(this).addClass('btn-progress');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>messenger_bot_enhancers/check_review_status",
                data: {auto_id: auto_id}, // database id
                dataType: 'json',
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');

                    if (response.status == "0")
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    else {
                        swal.fire('<?php echo $this->lang->line("Status"); ?>', response.message, 'success').then((value) => {
                            $('#bot_list_select').val($('#bot_list_select').val()).trigger("change");
                        });
                    }

                }
            });

        });

        $(document.body).on('click', '.estimate_now_class', function (e) {
            e.preventDefault();
            var auto_id = $(this).attr('data-id');
            var successfully = "<?php echo $this->lang->line("Estimation was run successfully"); ?>";
            var waiting = "<?php echo $this->lang->line("Please wait 20 seconds"); ?>";
            var estimate_now = "<?php echo $this->lang->line("Estimate Quick Send Reach"); ?>";

            if (auto_id == "") return false;
            $(this).addClass('btn-progress');
            swal.fire('<?php echo $this->lang->line(""); ?>', waiting, '');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>messenger_bot_enhancers/estimate_reach",
                data: {auto_id: auto_id}, // database id
                dataType: 'json',
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');

                    if (response.status == "0")
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    else
                        swal.fire('<?php echo $this->lang->line("Estimated reach"); ?>', response.message, 'success').then((value) => {
                            $('#bot_list_select').val($('#bot_list_select').val()).trigger("change");
                        });
                }
            });

        });

        $('#err-log, #import_bot_modal, #export_bot_modal').on('hidden.bs.modal', function () {
            $('#bot_list_select').val($('#bot_list_select').val()).trigger("change");
        });

        var table1 = '';
        $(document).on('click', '.error_log_report', function (e) {
            e.preventDefault();
            var media_type = "<?php echo $media_type; ?>";
            var table_id = $(this).attr('table_id');
            $("#put_page_id").val(table_id);
            $("#media_type_error").val(media_type);
            var base_url = '<?php echo site_url();?>';

            // $("#error_response_div").html('<div class="text-center waiting previewLoader"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size: 40px;"></i></div>');

            $("#err-log").modal();

            setTimeout(function () {
                if (table1 == '') {
                    var perscroll1;
                    var base_url = "<?php echo base_url(); ?>";
                    table1 = $("#mytable1").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[3, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'messenger_bot/error_log_report',
                            type: 'POST',
                            data: function (d) {
                                d.table_id = $("#put_page_id").val();
                                d.error_search = $("#error_searching").val();
                                d.media_type_error = $("#media_type_error").val();
                            }
                        },
                        language:
                            {
                                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: '',
                                className: 'text-center'
                            },
                            {
                                targets: [0, 3],
                                sortable: false
                            },
                            {
                                targets: [2, 3, 4],
                                "render": function (data, type, row) {
                                    data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                                    data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                                    data = data.replaceAll('fas fa-map', 'bx bx-map');
                                    data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                                    data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                                    data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                                    data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                                    data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
                                    data = data.replaceAll('fas fa-code', 'bx bx-code');
                                    data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('far fa-copy', 'bx bx-copy');
                                    data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                                    data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                                    data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                                    data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                                    data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                                    data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                                    data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                                    data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                                    data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                                    data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                                    data = data.replaceAll('fa fa-user', 'bx bx-user');
                                    data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                                    data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                                    data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                                    data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                                    data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                                    data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                                    data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                                    data = data.replaceAll('fas fa-key', 'bx bx-key');
                                    data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                                    data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                                    data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                                    data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                                    data = data.replaceAll('fa fa-send', 'bx bx-send');
                                    data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                                    data = data.replaceAll('fa fa-code', 'bx bx-code');
                                    data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                                    data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                                    data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                                    data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                                    data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                                    data = data.replaceAll('swal(', 'swal.fire(');
                                    data = data.replaceAll('rounded-circle', 'rounded-circle');
                                    data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                                    data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                                    data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                                    data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                                    data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                                    data = data.replaceAll('padding-10', 'p-10');
                                    data = data.replaceAll('padding-left-10', 'pl-10');
                                    data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                                    data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                                    data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                                    data = data.replaceAll('fas fa-city', 'bx bxs-city');
                                    data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                                    data = data.replaceAll('fas fa-at', 'bx bx-at');
                                    data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                                    data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                                    data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                                    data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                                    data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                                    data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                                    data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                                    data = data.replaceAll('far fa-hand-point-right', 'bx bxs-hand-right');
                                    data = data.replaceAll('fas fa-cogs', 'bx bx-cog');

                                    return data;
                                }
                            },
                        ],
                        fnInitComplete: function () { // when initialization is completed then apply scroll plugin
                            if (areWeUsingScroll) {
                                if (perscroll1) perscroll1.destroy();
                                perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if (areWeUsingScroll) {
                                if (perscroll1) perscroll1.destroy();
                                perscroll1 = new PerfectScrollbar('#mytable1_wrapper .dataTables_scrollBody');
                            }
                        },
                        "drawCallback": function (settings) {
                            $('table [data-toggle="tooltip"]').tooltip('dispose');
                            $('table [data-toggle="tooltip"]').tooltip(
                                {
                                    placement: 'left',
                                    container: 'body',
                                    html: true,
                                    template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                                }
                            );
                        }
                    });
                } else table1.draw();
            }, 1000);


        });

        $(document).on('keyup', '#error_searching', function (event) {
            event.preventDefault();
            table1.draw();
        });

        // Action Button Settings block
        $(document).on('click', '.action_button_settings', function (event) {
            event.preventDefault();
            $('.card-condensed').removeClass('active');
            $(this).parents('.card-condensed').addClass('active');
            $(window).scrollTop(94);
            title = $(this).parents('.card-condensed').children('.card-icon').html();
            title += $(this).parents('.card-condensed').children('.card-body').children('h5').html();
            $("#right_column_title").html(title);
            $("#right_column_content iframe").hide();
            $("#right_column_bottom_content").show();
            $("#mark_seen_chat_settings").hide();
            $("#enable_start_button_modal").hide();
            $("#sequence_message_settings_block").hide();
            $("#messenger_engagement_settings_block").hide();
            $("#user_input_settings_block").hide();
            $("#action_button_settings_block").show();
        });

        $(document).on('click', '.reset_action_settings', function (event) {
            event.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Warning"); ?>',
                text: '<?php echo $this->lang->line("Are you sure to reset action button settings?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willreset) => {
                    if (willreset.isConfirmed) {
                        $(this).addClass('btn-progress');
                        var page_table_id = $('#bot_list_select').val();

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: base_url + "social_accounts/reset_action_settings",
                            dataType: 'json',
                            data: {page_table_id},
                            success: function (response) {
                                if (response.status == 1) {
                                    $(this).removeClass('btn-progress');

                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                                        $(".page_list_item.active").click();
                                    });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            },
                            error: function (response) {
                                var span = document.createElement("span");
                                span.innerHTML = response.responseText;
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Error!"); ?>',
                                    content: span,
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
        });

        // Sequence Message Settings Block
        $(document).on('click', '.sequence_message_settings', function (event) {
            event.preventDefault();
            $('.card-condensed').removeClass('active');
            $(this).parents('.card-condensed').addClass('active');

            $(window).scrollTop(94);

            title = $(this).parents('.card-condensed').children('.card-icon').html();
            title += $(this).parents('.card-condensed').children('.card-body').children('h5').html();
            $("#right_column_title").html(title);
            $("#right_column_content iframe").hide();
            $("#right_column_bottom_content").show();
            $("#mark_seen_chat_settings").hide();
            $("#enable_start_button_modal").hide();
            $("#sequence_message_settings_block").show();
            $("#messenger_engagement_settings_block").hide();
            $("#user_input_settings_block").hide();
            $("#action_button_settings_block").hide();
        });

        // Engagement Settings Block
        $(document).on('click', '.messenger_engagement_settings', function (event) {
            event.preventDefault();
            $('.card-condensed').removeClass('active');
            $(this).parents('.card-condensed').addClass('active');
            $(window).scrollTop(94);
            title = $(this).parents('.card-condensed').children('.card-icon').html();
            title += $(this).parents('.card-condensed').children('.card-body').children('h5').html();
            $("#right_column_title").html(title);
            $("#right_column_content iframe").hide();
            $("#right_column_bottom_content").show();
            $("#mark_seen_chat_settings").hide();
            $("#enable_start_button_modal").hide();
            $("#sequence_message_settings_block").hide();
            $("#messenger_engagement_settings_block").show();
            $("#user_input_settings_block").hide();
            $("#action_button_settings_block").hide();
        });

        // User Input flow Settings Block
        $(document).on('click', '.user_input_flow_settings', function (event) {
            event.preventDefault();
            $('.card-condensed').removeClass('active');
            $(this).parents('.card-condensed').addClass('active');
            $(window).scrollTop(94);
            title = $(this).parents('.card-condensed').children('.card-icon').html();
            title += $(this).parents('.card-condensed').children('.card-body').children('h5').html();
            $("#right_column_title").html(title);
            $("#right_column_content iframe").hide();
            $("#right_column_bottom_content").show();
            $("#mark_seen_chat_settings").hide();
            $("#enable_start_button_modal").hide();
            $("#sequence_message_settings_block").hide();
            $("#messenger_engagement_settings_block").hide();
            $("#user_input_settings_block").show();
            $("#action_button_settings_block").hide();
        });


        $(document).on('click', '.enable_start_button', function (e) {
            e.preventDefault();
            $('.card-condensed').removeClass('active');
            $(this).parents('.card-condensed').addClass('active');
            $(window).scrollTop(94);
            title = $(this).parents('.card-condensed').children('.card-icon').html();
            title += $(this).parents('.card-condensed').children('.card-body').children('h5').html();
            $("#right_column_title").html(title);

            var page_id = $(this).attr('sbutton-enable');
            var started_button_enabled = $(this).attr('sbutton-status');
            var welcome_message = htmlspecialchars_decode($(this).attr('welcome-message'));

            $("#welcome_message").val(welcome_message).click();
            $("#started_button_enabled").val(started_button_enabled);

            if (started_button_enabled == '0') $("#delay_con2").hide();
            else $("#delay_con2").show();

            $("#right_column_content iframe").hide();
            $("#right_column_bottom_content").show();
            $("#mark_seen_chat_settings").hide();
            $("#action_button_settings_block").hide();
            $("#sequence_message_settings_block").hide();
            $("#messenger_engagement_settings_block").hide();
            $("#user_input_settings_block").hide();

            $("#enable_start_button_submit").attr("table_id", page_id);
            $("#enable_start_button_modal").show();

            /**Load Emoji For Welcome Screen Message on Get Started Button ***/
            $("#welcome_message").emojioneArea({
                <?php if ($rtl_on) {
                    echo "dir: 'rtl',";
                } ?>
                autocomplete: false,
                pickerPosition: "bottom"
            });
        });


        $(document).on('click', '#enable_start_button_submit', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');
            $("#page_info_table_id_icebreaker").val(table_id);
            var media_type = "<?php echo $media_type; ?>";
            // var welcome_message = $("#welcome_message").val();
            // var started_button_enabled = $("#started_button_enabled").val();
            $(this).addClass('btn-progress');
            var queryString = new FormData($("#getstarted_icebreaker_form")[0]);
            $.ajax
            ({
                type: 'POST',
                url: base_url + 'messenger_bot/get_started_welcome_message',
                // data:{table_id:table_id,welcome_message:welcome_message,started_button_enabled:started_button_enabled},
                data: queryString,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == '0') {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    } else {
                        if (response.ice_breaker_status == '1')
                            iziToast.success({
                                title: '',
                                message: response.ice_breaker_message,
                                position: 'bottomRight'
                            });
                        else iziToast.error({
                            title: '',
                            message: response.ice_breaker_message,
                            position: 'bottomRight'
                        });

                        if (media_type == "fb") {
                            if (response.get_started_status == '1')
                                iziToast.success({
                                    title: '',
                                    message: response.get_started_message,
                                    position: 'bottomRight'
                                });
                            else iziToast.error({
                                title: '',
                                message: response.get_started_message,
                                position: 'bottomRight'
                            });
                        }

                    }
                }
            });

        });

        $(document).on('change', '#started_button_enabled', function () {
            var started_button_enabled = $(this).val();
            if (started_button_enabled == '1') $("#delay_con2").show();
            else $("#delay_con2").hide();
        });


        $(document).on('click', '.enable_general_settings', function (e) {
            e.preventDefault();
            $('.card-condensed').removeClass('active');
            $(this).parents('.card-condensed').addClass('active');
            $(window).scrollTop(94);
            title = $(this).parents('.card-condensed').children('.card-icon').html();
            title += $(this).parents('.card-condensed').children('.card-body').children('h5').html();
            $("#right_column_title").html(title);

            var table_id = $(this).attr('table_id');
            var chat_human_email = $(this).attr('chat_human_email');
            var mark_seen_status = $(this).attr('mark_seen_status');
            var no_match_found_reply = $(this).attr('no_match_found_reply');

            if (no_match_found_reply == 'enabled') {
                $("#no_match_found_reply").prop("checked", true);
                $("#no_match_found_reply").val('enabled');
            } else {
                $("#no_match_found_reply").prop("checked", false);
                $("#no_match_found_reply").val('disabled');
            }


            $("#mark_seen_status").val(mark_seen_status);
            $("#chat_human_email").val(chat_human_email);


            $("#right_column_content iframe").hide();
            $("#right_column_bottom_content").show();
            $("#enable_start_button_modal").hide();
            $("#action_button_settings_block").hide();
            $("#sequence_message_settings_block").hide();
            $("#messenger_engagement_settings_block").hide();
            $("#user_input_settings_block").hide();

            $("#mark_seen_save_button").attr("table_id", table_id);
            $("#mark_seen_chat_settings").show();
        });

        $(document).on('change', 'input[name=no_match_found_reply]', function () {
            var checked_property = $("#no_match_found_reply").prop("checked");
            if (checked_property)
                $("#no_match_found_reply").val('enabled');
            else
                $("#no_match_found_reply").val('disabled');

        });


        $(document).on('click', '#mark_seen_save_button', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');
            var mark_seen_status = $("#mark_seen_status").val();
            var chat_human_email = $("#chat_human_email").val();
            var no_match_found_reply = $("#no_match_found_reply").val();
            var mailchimp_list_id = $("#mailchimp_list_id").val();
            var sendinblue_list_id = $("#sendinblue_list_id2").val();
            var activecampaign_list_id = $("#activecampaign_list_id2").val();
            var mautic_list_id = $("#mautic_list_id2").val();
            var acelle_list_id = $("#acelle_list_id2").val();

            var sms_api_id = $("#sms_api_id").val();
            var sms_reply_message = $("#sms_reply_message").val();

            var email_api_id = $("#email_api_id").val();
            var email_reply_message = $("#email_reply_message").val();
            var email_reply_subject = $("#email_reply_subject").val();


            var sequence_sms_api_id = $("#sequence_sms_api_id").val();
            var sequence_email_api_id = $("#sequence_email_api_id").val();
            var sequence_sms_campaign_id = $("#sequence_sms_campaign_id").val();
            var sequence_email_campaign_id = $("#sequence_email_campaign_id").val();
            var media_type = "<?php echo $media_type; ?>";

            $(this).addClass('btn-progress');
            $.ajax
            ({
                type: 'POST',
                url: base_url + 'messenger_bot/mark_seen_chat_human_settings',
                data: {
                    table_id: table_id,
                    mark_seen_status: mark_seen_status,
                    chat_human_email: chat_human_email,
                    no_match_found_reply: no_match_found_reply,
                    mailchimp_list_id: mailchimp_list_id,
                    sendinblue_list_id: sendinblue_list_id,
                    activecampaign_list_id: activecampaign_list_id,
                    mautic_list_id: mautic_list_id,
                    acelle_list_id: acelle_list_id,
                    sms_api_id: sms_api_id,
                    sms_reply_message: sms_reply_message,
                    email_api_id: email_api_id,
                    email_reply_message: email_reply_message,
                    email_reply_subject: email_reply_subject,
                    sequence_sms_api_id: sequence_sms_api_id,
                    sequence_email_api_id: sequence_email_api_id,
                    sequence_sms_campaign_id: sequence_sms_campaign_id,
                    sequence_email_campaign_id: sequence_email_campaign_id,
                    media_type: media_type
                },
                dataType: 'JSON',
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == '1')
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                    else iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                }
            });

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

        $(document).on('click', '.getstarted_lead_first_name', function () {
            var textAreaTxt = $(this).parent().next().next().next().children('.emojionearea-editor').html();

            // Remove last br tag as emojiarea place a extra br tag for spaces.
            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);

            var txtToAdd = " {{user_first_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().children('.emojionearea-editor').click();
        });

        $(document).on('click', '.getstarted_lead_last_name', function () {
            var textAreaTxt = $(this).parent().next().next().next().next().children('.emojionearea-editor').html();

            // Remove last br tag as emojiarea place a extra br tag for spaces.
            var lastIndex = textAreaTxt.lastIndexOf("<br>");
            var lastTag = textAreaTxt.substr(textAreaTxt.length - 4);
            lastTag = lastTag.trim(lastTag);

            if (lastTag == "<br>")
                textAreaTxt = textAreaTxt.substring(0, lastIndex);

            var txtToAdd = " {{user_last_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $(this).parent().next().next().next().next().children('.emojionearea-editor').html(new_text);
            $(this).parent().next().next().next().next().children('.emojionearea-editor').click();
        });

        $(document).on('click', '.sms_api_first_name', function () {
            var $txt = $("#sms_reply_message");
            var caretPos = $txt[0].selectionStart;
            var textAreaTxt = $txt.val();
            var txtToAdd = " {{user_first_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });

        $(document).on('click', '.sms_api_last_name', function () {
            var $txt = $("#sms_reply_message");
            var caretPos = $txt[0].selectionStart;
            var textAreaTxt = $txt.val();
            var txtToAdd = " {{user_last_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });

        $(document).on('click', '.email_api_first_name', function () {
            var $txt = $("#email_reply_message");
            var caretPos = $txt[0].selectionStart;
            var textAreaTxt = $txt.val();
            var txtToAdd = " {{user_first_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });

        $(document).on('click', '.email_api_last_name', function () {
            var $txt = $("#email_reply_message");
            var caretPos = $txt[0].selectionStart;
            var textAreaTxt = $txt.val();
            var txtToAdd = " {{user_last_name}} ";
            var new_text = textAreaTxt + txtToAdd;
            $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
        });


    });

    $("document").ready(function () {
        var session_value = "<?php echo $this->session->userdata('bot_list_get_page_details_page_table_id'); ?>";
        if (session_value == '') $('#bot_list_select').val($('#bot_list_select').val()).trigger("change");
        else $('#bot_list_select').val(session_value).trigger("change");


        var base_url = "<?php echo base_url(); ?>";

        $(document).on('click', '.import_bot', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');
            $("#import_id").val(table_id);
            $(".post_to").prop("checked", false);
            $("#json_upload_input").val('');
            $("#import_bot_modal").modal();
        });

        $(document).on('click', '#import_bot_submit', function (e) {
            e.preventDefault();
            var template_id = $("#template_id").val();
            var filename = $("#json_upload_input").val();

            if (template_id == "" && filename == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('You must select a template or upload one.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress');

            var queryString = new FormData($("#import_bot_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/import_bot_check",
                dataType: 'JSON',
                data: queryString,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == '1') {
                        var json_upload_input = response.json_upload_input;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Warning!"); ?>',
                            text: response.message,
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
                                        url: "<?php echo site_url();?>messenger_bot/import_bot",
                                        // dataType: 'json',
                                        data: {
                                            json_upload_input: json_upload_input,
                                            page_id: response.page_id,
                                            template_id: response.template_id
                                        },
                                        success: function (response2) {
                                            $(this).removeClass('btn-progress');
                                            var success_message = response2;
                                            var span = document.createElement("span");
                                            span.innerHTML = success_message;
                                            swal.fire({
                                                title: '<?php echo $this->lang->line("Import Status"); ?>',
                                                html: span,
                                                icon: 'success'
                                            });
                                        }
                                    });
                                }
                            });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });
        });

        $(document).on('click', '#cancel_import_bot', function (e) {
            e.preventDefault();
            $("#import_bot_modal").modal('hide');
        });


        $(document).on('click', '.export_bot', function (e) {
            e.preventDefault();
            var table_id = $(this).attr('table_id');
            var media_type = $(this).attr('media_type');
            $("#export_id").val(table_id);
            $("#export_media_type").val(media_type);

            $('#allowed_package_ids').val(null).trigger('change');
            $("#template_name").val('');
            $("#template_description").val('');
            $("#template_preview_image").val('');
            $("#only_me_input").prop("checked", true);
            $("#other_user_input").prop("checked", false);
            $("#allowed_package_ids_con").addClass('hidden')

            $("#export_bot_modal").modal();
        });

        $(document).on('change', 'input[name=template_access]', function () {
            var template_access = $(this).val();
            if (template_access == 'private') $("#allowed_package_ids_con").addClass('hidden');
            else $("#allowed_package_ids_con").removeClass('hidden');
        });

        $(document).on('click', '#export_bot_submit', function (e) {
            e.preventDefault();
            var template_name = $("#template_name").val();
            var template_access = $('input[name=template_access]:checked').val();
            var allowed_package_ids = $("#allowed_package_ids").val();

            if (template_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('Please provide template name.');?>", 'warning');
                return;
            }

            if (template_access == "public" && allowed_package_ids == null) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', "<?php echo $this->lang->line('You must choose user packages to give them template access.');?>", 'warning');
                return;
            }

            $(this).addClass('btn-progress');
            var queryString = new FormData($("#export_bot_form")[0]);
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/export_bot",
                dataType: 'JSON',
                data: queryString,
                cache: false,
                contentType: false,
                processData: false,
                context: this,
                success: function (response) {
                    $(this).removeClass('btn-progress');

                    var success_message = response.message;
                    var span = document.createElement("span");
                    span.innerHTML = success_message;
                    swal.fire({
                        title: '<?php echo $this->lang->line("Export Status"); ?>',
                        html: span,
                        icon: 'success'
                    });
                }
            });

        });

        $(document).on('click', '#cancel_bot_submit', function (e) {
            e.preventDefault();
            $("#export_bot_modal").modal('hide');
        });


        $("#allowed_package_ids").select2({width: "100%"});

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        $(document).on('click', '.load_preview_modal', function (e) {
            e.preventDefault();
            var item_type = $(this).attr('item_type');
            var file_path = $(this).next().val();
            var user_id = "<?php echo $this->user_id; ?>";

            var res = file_path.match(/http/g);
            if (file_path != '' && res === null)
                file_path = base_url + "upload/image/" + user_id + "/" + file_path;

            $("#preview_text_field").val(file_path);
            if (item_type == 'image') {
                $("#modal_preview_image").attr('src', file_path);
                $("#image_preview_div_modal").show();
                $("#video_preview_div_modal").hide();
                $("#audio_preview_div_modal").hide();

            }
            $("#modal_for_preview").modal();
        });

        var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
        var image_upload_limit = "<?php echo $image_upload_limit; ?>";
        $("#template_preview_image_div").uploadFile({
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
                        $("#template_preview_image").val('');
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = base_url + "upload/image/" + user_id + "/" + data;
                $("#template_preview_image").val(data_modified);
            }
        });

        $("#json_upload").uploadFile({
            url: base_url + "messenger_bot/upload_json_template",
            fileName: "myfile",
            showPreview: false,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            acceptFiles: ".json",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('messenger_bot/upload_json_template_delete');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                        $("#json_upload_input").val('');
                        $(".type1,.type2").show();
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = data;
                $("#json_upload_input").val(data_modified);
                $("#template_id").val('');
                $(".type1,.type2").hide();
            }
        });


    });
</script>


<script type="text/javascript">

    $(document).ready(function () {

        var base_url = "<?php echo base_url(); ?>";
        var table2 = '';
        $(document).on('click', '.error_log_report2', function (e) {
            e.preventDefault();
            var auto_responder_type = $(this).attr('data-type');
            $("#auto_responder_type").val(auto_responder_type);

            /**Distinguish email auto responder like MailChimp,Sendinblue etc**/

            var autoresponder_service_name = "";
            if (auto_responder_type == 'Email Autoresponder') {

                autoresponder_service_name = $(this).attr('data-service');
                $("#autoresponder_service_name").val(autoresponder_service_name);

            }

            $("#err-log2").modal();

            setTimeout(function () {
                if (table2 == '') {
                    var perscroll2;
                    table2 = $("#mytable2").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[6, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'messenger_bot/error_log_report_autoreponder',
                            type: 'POST',
                            data: function (d) {
                                d.error_search = $("#error_searching2").val();
                                d.auto_responder_type = $("#auto_responder_type").val();
                                d.autoresponder_service_name = $("#autoresponder_service_name").val();

                            }
                        },
                        language:
                            {
                                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: [1, 2, 4, 5, 6, 7],
                                className: 'text-center'
                            },
                            {
                                targets: [0, 7],
                                sortable: false
                            },
                            {
                                targets: [4],
                                visible: false
                            },
                            {
                                targets: [7],
                                "render": function ( data, type, row ) {
                                    data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                                    data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                                    data = data.replaceAll('fas fa-map', 'bx bx-map');
                                    data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                                    data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                                    data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                                    data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                                    data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
                                    data = data.replaceAll('fas fa-code', 'bx bx-code');
                                    data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('far fa-copy', 'bx bx-copy');
                                    data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                                    data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                                    data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                                    data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                                    data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                                    data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                                    data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                                    data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                                    data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                                    data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                                    data = data.replaceAll('fa fa-user', 'bx bx-user');
                                    data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                                    data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                                    data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                                    data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                                    data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                                    data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                                    data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                                    data = data.replaceAll('fas fa-key', 'bx bx-key');
                                    data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                                    data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                                    data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                                    data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                                    data = data.replaceAll('fa fa-send', 'bx bx-send');
                                    data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                                    data = data.replaceAll('fa fa-code', 'bx bx-code');
                                    data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                                    data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                                    data = data.replaceAll('fas fa-play', 'bx bx-play');
                                    data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                                    data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                                    data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                                    data = data.replaceAll('swal(', 'swal.fire(');
                                    data = data.replaceAll('rounded-circle', 'rounded-circle');
                                    data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                                    data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                                    data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                                    data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                                    data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                                    data = data.replaceAll('padding-10', 'p-10');
                                    data = data.replaceAll('padding-left-10', 'pl-10');
                                    data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                                    data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                                    data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                                    data = data.replaceAll('fas fa-city', 'bx bxs-city');
                                    data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                                    data = data.replaceAll('fas fa-at', 'bx bx-at');
                                    data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                                    data = data.replaceAll('<div class="dropdown-title">Options</div>', '<h6 class="dropdown-header">Options</h6>');
                                    data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                                    data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                                    data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                                    data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                                    data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                                    data = data.replaceAll('fa fa-info-circle', 'bx bx-info-circle');
                                    data = data.replaceAll('fas fa-id-card', 'bx bxs-id-card');
                                    data = data.replaceAll('fas fa-mars', 'bx bx-male-sign');
                                    data = data.replaceAll('fas fa-language', 'bx bx-flag');
                                    data = data.replaceAll('fas fa-globe', 'bx bx-globe');
                                    data = data.replaceAll('far fa-clock', 'bx bx-time');
                                    data = data.replaceAll('fas fa-ellipsis-v', 'bx bx-dots-vertical-rounded');
                                    data = data.replaceAll('far fa-hand-point-right', 'bx bxs-hand-right');
                                    data = data.replaceAll('fas fa-cogs', 'bx bx-cog');
                                    data = data.replaceAll('far fa-pause-circle', 'bx bx-pause-circle');
                                    data = data.replaceAll('fas fa-retweet', 'bx bxs-share');
                                    data = data.replaceAll('fas fa-sync-alt', 'bx bx-sync');
                                    data = data.replaceAll('fas fa-sync', 'bx bx-sync');
                                    data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
                                    data = data.replaceAll('far fa-stop-circle', 'bx bx-stop-circle');
                                    data = data.replaceAll('far fa-play-circle', 'bx bx-play-circle');
                                    data = data.replaceAll('fa fa-bug', 'bx bx-bug');

                                    return data;
                                }
                            },
                        ],
                        fnInitComplete: function () { // when initialization is completed then apply scroll plugin
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        },
                        "drawCallback": function (settings) {
                            $('table [data-toggle="tooltip"]').tooltip('dispose');
                            $('table [data-toggle="tooltip"]').tooltip(
                                {
                                    placement: 'left',
                                    container: 'body',
                                    html: true,
                                    template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                                }
                            );
                        }
                    });
                } else table2.draw();
            }, 1000);

        });

        $(document).on('keyup', '#error_searching2', function (event) {
            event.preventDefault();
            table2.draw();
        });

        $(document).on('click', '.error_response', function (e) {
            e.preventDefault();
            $(this).removeClass('btn-outline-danger').addClass("btn-danger").addClass('btn-progress');
            var id = $(this).attr('data-id');

            $.ajax
            ({
                type: 'POST',
                url: base_url + 'messenger_bot/error_log_response',
                data: {id: id},
                context: this,
                success: function (response) {
                    $(this).addClass('btn-outline-danger').removeClass("btn-danger").removeClass('btn-progress');

                    var success_message = response;
                    var span = document.createElement("span");
                    span.innerHTML = success_message;
                    swal.fire({title: '<?php echo $this->lang->line("API Response"); ?>', html: span, icon: 'info'});
                }
            });
        });

    });
</script>