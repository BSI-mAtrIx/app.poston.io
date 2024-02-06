<script src="https://checkout.razorpay.com/v1/checkout.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/wNumb.js"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/nouislider.min.js"></script>
<script>
    var query_build = {};
    function get_query_build(){
        if(!$('#content_generator_collapsed').is(':checked')){
            slider_content_generator_0_val = 0;
        }else{
            slider_content_generator_0_val = slider_content_generator_0.noUiSlider.get();
        }
        query_build['content_generator'] = {};
        query_build['content_generator']['enabled'] = $('#content_generator_collapsed').is(':checked');
        query_build['content_generator']['slider'] = {};
        query_build['content_generator']['slider'][0] = slider_content_generator_0_val;


        if(!$('#social_posting_collapsed').is(':checked')){
            slider_social_posting_0_val = 0;
        }else{
            slider_social_posting_0_val = slider_social_posting_0.noUiSlider.get();
        }
        if(!$('#social_posting_collapsed').is(':checked')){
            slider_social_posting_1_val = 0;
        }else{
            slider_social_posting_1_val = slider_social_posting_1.noUiSlider.get();
        }
        query_build['social_posting'] = {};
        query_build['social_posting']['enabled'] = $('#social_posting_collapsed').is(':checked');
        query_build['social_posting']['slider'] = {};
        query_build['social_posting']['slider'][0] = slider_social_posting_0_val;
        query_build['social_posting']['slider'][1] = slider_social_posting_1_val;

        if(!$('#twitter_posting_collapsed').is(':checked')){
            slider_twitter_posting_0_val = 0;
        }else{
            slider_twitter_posting_0_val = slider_twitter_posting_0.noUiSlider.get();
        }
        query_build['twitter_posting'] = {};
        query_build['twitter_posting']['enabled'] = $('#twitter_posting_collapsed').is(':checked');
        query_build['twitter_posting']['slider'] = {};
        query_build['twitter_posting']['slider'][0] = slider_twitter_posting_0_val;

        if(!$('#comment_automation_collapsed').is(':checked')){
            slider_comment_automation_0_val = 0;
        }else{
            slider_comment_automation_0_val = slider_comment_automation_0.noUiSlider.get();
        }
        query_build['comment_automation'] = {};
        query_build['comment_automation']['enabled'] = $('#comment_automation_collapsed').is(':checked');
        query_build['comment_automation']['slider'] = {};
        query_build['comment_automation']['slider'][0] = slider_comment_automation_0_val;

        if(!$('#email_sending_collapsed').is(':checked')){
            slider_email_sending_0_val = 0;
        }else{
            slider_email_sending_0_val = slider_email_sending_0.noUiSlider.get();
        }
        query_build['email_sending'] = {};
        query_build['email_sending']['enabled'] = $('#email_sending_collapsed').is(':checked');
        query_build['email_sending']['slider'] = {};
        query_build['email_sending']['slider'][0] = slider_email_sending_0_val;

        if(!$('#twitter_posting_collapsed').is(':checked')){
            slider_twitter_posting_0_val = 0;
        }else{
            slider_twitter_posting_0_val = slider_twitter_posting_0.noUiSlider.get();
        }
        query_build['twitter_posting'] = {};
        query_build['twitter_posting']['enabled'] = $('#twitter_posting_collapsed').is(':checked');
        query_build['twitter_posting']['slider'] = {};
        query_build['twitter_posting']['slider'][0] = slider_twitter_posting_0_val;

        if(!$('#ecommerce_collapsed').is(':checked')){
            slider_ecommerce_0_val = 0;
        }else{
            slider_ecommerce_0_val = slider_ecommerce_0.noUiSlider.get();
        }
        if(!$('#ecommerce_collapsed').is(':checked')){
            slider_ecommerce_1_val = 0;
        }else{
            slider_ecommerce_1_val = slider_ecommerce_1.noUiSlider.get();
        }
        query_build['ecommerce'] = {};
        query_build['ecommerce']['enabled'] = $('#ecommerce_collapsed').is(':checked');
        query_build['ecommerce']['slider'] = {};
        query_build['ecommerce']['slider'][0] = slider_ecommerce_0_val;
        query_build['ecommerce']['slider'][1] = slider_ecommerce_1_val;

        if(!$('#facebook_collapsed').is(':checked')){
            slider_facebook_0_val = 0;
        }else{
            slider_facebook_0_val = slider_facebook_0.noUiSlider.get();
        }
        if(!$('#facebook_collapsed').is(':checked')){
            slider_facebook_1_val = 0;
        }else{
            slider_facebook_1_val = slider_facebook_1.noUiSlider.get();
        }
        if(!$('#facebook_collapsed').is(':checked')){
            slider_facebook_2_val = 0;
        }else{
            slider_facebook_2_val = slider_facebook_2.noUiSlider.get();
        }
        query_build['facebook'] = {};
        query_build['facebook']['enabled'] = $('#facebook_collapsed').is(':checked');
        query_build['facebook']['slider'] = {};
        query_build['facebook']['slider'][0] = slider_facebook_0_val;
        query_build['facebook']['slider'][1] = slider_facebook_1_val;
        query_build['facebook']['slider'][2] = slider_facebook_2_val;

        if(!$('#google_collapsed').is(':checked')){
            slider_google_0_val = 0;
        }else{
            slider_google_0_val = slider_google_0.noUiSlider.get();
        }
        if(!$('#google_collapsed').is(':checked')){
            slider_google_1_val = 0;
        }else{
            slider_google_1_val = slider_google_1.noUiSlider.get();
        }
        query_build['google'] = {};
        query_build['google']['enabled'] = $('#google_collapsed').is(':checked');
        query_build['google']['slider'] = {};
        query_build['google']['slider'][0] = slider_google_0_val;
        query_build['google']['slider'][1] = slider_google_1_val;

        if(!$('#image_editor_collapsed').is(':checked')){
            slider_image_editor_0_val = 0;
        }else{
            slider_image_editor_0_val = slider_image_editor_0.noUiSlider.get();
        }
        query_build['image_editor'] = {};
        query_build['image_editor']['enabled'] = $('#image_editor_collapsed').is(':checked');
        query_build['image_editor']['slider'] = {};
        query_build['image_editor']['slider'][0] = slider_image_editor_0_val;

        if(!$('#messenger_collapsed').is(':checked')){
            slider_messenger_0_val = 0;
        }else{
            slider_messenger_0_val = slider_messenger_0.noUiSlider.get();
        }
        query_build['messenger'] = {};
        query_build['messenger']['enabled'] = $('#messenger_collapsed').is(':checked');
        query_build['messenger']['slider'] = {};
        query_build['messenger']['slider'][0] = slider_messenger_0_val;

        if(!$('#sms_collapsed').is(':checked')){
            slider_sms_0_val = 0;
        }else{
            slider_sms_0_val = slider_sms_0.noUiSlider.get();
        }
        query_build['sms'] = {};
        query_build['sms']['enabled'] = $('#sms_collapsed').is(':checked');
        query_build['sms']['slider'] = {};
        query_build['sms']['slider'][0] = slider_sms_0_val;

        if(!$('#sms_collapsed').is(':checked')){
            slider_telegram_0_val = 0;
        }else{
            slider_telegram_0_val = slider_telegram_0.noUiSlider.get();
        }
        if(!$('#sms_collapsed').is(':checked')){
            slider_telegram_1_val = 0;
        }else{
            slider_telegram_1_val = slider_telegram_1.noUiSlider.get();
        }
        query_build['telegram'] = {};
        query_build['telegram']['enabled'] = $('#sms_collapsed').is(':checked');
        query_build['telegram']['slider'] = {};
        query_build['telegram']['slider'][0] = slider_telegram_0_val;
        query_build['telegram']['slider'][1] = slider_telegram_1_val;

        if(!$('#whatsapp_collapsed').is(':checked')){
            slider_whatsapp_0_val = 0;
        }else{
            slider_whatsapp_0_val = slider_whatsapp_0.noUiSlider.get();
        }
        if(!$('#whatsapp_collapsed').is(':checked')){
            slider_whatsapp_1_val = 0;
        }else{
            slider_whatsapp_1_val = slider_whatsapp_1.noUiSlider.get();
        }
        if(!$('#whatsapp_collapsed').is(':checked')){
            slider_whatsapp_2_val = 0;
        }else{
            slider_whatsapp_2_val = slider_whatsapp_2.noUiSlider.get();
        }
        query_build['whatsapp'] = {};
        query_build['whatsapp']['enabled'] = $('#whatsapp_collapsed').is(':checked');
        query_build['whatsapp']['slider'] = {};
        query_build['whatsapp']['slider'][0] = slider_whatsapp_0_val;
        query_build['whatsapp']['slider'][1] = slider_whatsapp_1_val;
        query_build['whatsapp']['slider'][2] = slider_whatsapp_2_val;

        if(!$('#meta_ads_collapsed').is(':checked')){
            slider_meta_ads_0_val = 0;
        }else{
            slider_meta_ads_0_val = slider_meta_ads_0.noUiSlider.get();
        }
        query_build['meta_ads'] = {};
        query_build['meta_ads']['enabled'] = $('#meta_ads_collapsed').is(':checked');
        query_build['meta_ads']['slider'] = {};
        query_build['meta_ads']['slider'][0] = slider_meta_ads_0_val;

        if(!$('#utility_collapsed').is(':checked')){
            slider_utility_0_val = 0;
        }else{
            slider_utility_0_val = slider_utility_0.noUiSlider.get();
        }
        query_build['utility'] = {};
        query_build['utility']['enabled'] = $('#utility_collapsed').is(':checked');
        query_build['utility']['slider'] = {};
        query_build['utility']['slider'][0] = slider_utility_0_val;

        if(!$('#hidden_interest_collapsed').is(':checked')){
            slider_hidden_interest_0_val = 0;
        }else{
            slider_hidden_interest_0_val = slider_hidden_interest_0.noUiSlider.get();
        }
        query_build['hidden_interest'] = {};
        query_build['hidden_interest']['enabled'] = $('#hidden_interest_collapsed').is(':checked');
        query_build['hidden_interest']['slider'] = {};
        query_build['hidden_interest']['slider'][0] = slider_hidden_interest_0_val;

        if(!$('#landing_page_collapsed').is(':checked')){
            slider_landing_page_0_val = 0;
        }else{
            slider_landing_page_0_val = slider_landing_page_0.noUiSlider.get();
        }
        query_build['landing_page'] = {};
        query_build['landing_page']['enabled'] = $('#landing_page_collapsed').is(':checked');
        query_build['landing_page']['slider'] = {};
        query_build['landing_page']['slider'][0] = slider_landing_page_0_val;

        if(!$('#website_builder_collapsed').is(':checked')){
            slider_website_builder_0_val = 0;
        }else{
            slider_website_builder_0_val = slider_website_builder_0.noUiSlider.get();
        }
        query_build['website_builder'] = {};
        query_build['website_builder']['enabled'] = $('#website_builder_collapsed').is(':checked');
        query_build['website_builder']['slider'] = {};
        query_build['website_builder']['slider'][0] = slider_website_builder_0_val;
    }

    function get_price(){
        $('#summary_cart').block({
            message: '<div class="w-icon-store-seo font-medium-2"></div>',
            overlayCSS: {
                backgroundColor: '#ffffff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });

        get_query_build();

        var to_send = {
            "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>",
            "query": query_build
        };

        var price_details = '';
        var price_summary = '';
        var free_details = '';

        $.ajax({
            type: 'POST',
            data: to_send,
            dataType: 'JSON',
            url: base_url + 'price/api/get_price_json',
            success: function (response) {

                if(response.status==1){
                    $.each(response.message.details, function(key2, val2){
                        price_details +='<li>' +
                            '<strong class="font-small-5">'+val2.title+'</strong>' +
                            '<br />';

                        $.each(val2.sliders, function(key, val){

                            if(val.is_unlimited == 1){
                                price_period_1 = '<?php echo $this->lang->line('Unlimited'); ?>';
                                price_period_2 = '<?php echo $this->lang->line('Unlimited'); ?>';
                            }else{
                                price_period_1 = val.selected_val+' * '+val.price_unit_period_1+' '+response.message.currency;
                                price_period_2 = val.selected_val+' * '+val.price_unit_period_2+' '+response.message.currency;
                            }

                            price_details += '<span class="font-small-4">'+val.lang_title+'</span>' +
                            '<br />' +
                            '<span class="font-small-3 price_period_1_show">'+price_period_1+'</span>' +
                            '<strong class="font-small-4 price_period_1_show float-right">'+val.total_price_period_1+' '+response.message.currency+'</strong>'+
                            '<span class="font-small-3 price_period_2_show" style="display:none;">'+price_period_2+'</span>' +
                            '<strong class="font-small-4 price_period_2_show float-right" style="display:none;">'+val.total_price_period_2+' '+response.message.currency+'</strong><br />';
                        });

                        price_details += '</li>'
                    });
                    $('#pricing-details').html(price_details);

                    free_details +='<hr><li><strong class="font-small-5"><?php echo $this->lang->line('You get also for free:'); ?></strong></li>';
                    if($(response.message.free_tools).length>0){
                        $.each(response.message.free_tools, function(key2, val2){
                            free_details +='<li>' +
                                '<strong class="font-small-5">'+val2.title+'</strong>' +
                                '<br />';

                            $.each(val2.sliders, function(key, val){
                                free_details += '<span class="font-small-4">'+val.lang_title+'</span><br />';
                            });

                            free_details += '</li>'
                        });
                        $('#free-details').html(free_details);
                    }

                    $('#summary_total_price_1').html(response.message.summary.total_price_1 + ' '+ response.message.currency);

                    $('#summary_total_price_2').html(response.message.summary.total_price_2 + ' '+ response.message.currency);

                    $('#period_1_summary').html(response.message.summary.period_1_name);
                    $('#period_2_summary').html(response.message.summary.period_2_name);
                    //prepare_button
                }else{
                    //swal

                }

                $('#summary_cart').unblock();

            }
        });

    }

    function go_to_payment_summary(){
        $('#summary_cart').block({
            message: '<div class="w-icon-store-seo font-medium-2"></div>',
            overlayCSS: {
                backgroundColor: '#ffffff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });

        get_query_build();

        var to_send = {
            "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>",
            "query": query_build,
            "period": $('input[name="summary_period"]:checked').val()
        };

        var price_details = '';
        var price_summary = '';
        var free_details = '';

        $.ajax({
            type: 'POST',
            data: to_send,
            dataType: 'JSON',
            url: base_url + 'price/api/payment_summary',
            success: function (response) {

                if(response.status==1){
                    window.location.assign(base_url + 'payment/payment_button/' + response.message.id);
                }else{
                    //swal
                }

                $('#summary_cart').unblock();

            }
        });

    }

    $(document).ready(function () {
        var direction = 'ltr';
        if ($('html').data('textdirection') == 'rtl') {
            direction = 'rtl';
        }

        const SI_SYMBOLS = ["", "k", "M", "G", "T", "P", "E"];

        const abbreviateNumber = (number, minDigits, maxDigits) => {
            if (number === 0) return number;

            // determines SI symbol
            const tier = Math.floor(Math.log10(Math.abs(number)) / 3);

            // get suffix and determine scale
            const suffix = SI_SYMBOLS[tier];
            const scale = 10 ** (tier * 3);

            // scale the number
            const scaled = number / scale;

            // format number and add suffix
            return scaled.toLocaleString(undefined, {
                minimumFractionDigits: minDigits,
                maximumFractionDigits: maxDigits,
            }) + suffix;
        };



        <?php

        if(!empty($build_js)){
            echo $build_js;
        }

            ?>

        $("#annual_plan_check").on('change', function () {
            if ($(this).is(':checked')) {
                $('.annual_0').hide();
                $('.annual_1').show();
            } else {
                $('.annual_0').show();
                $('.annual_1').hide();
            }
        });

        <?php if (isset($display_hide) AND $display_hide == 1) {
        echo "$('#annual-hide').hide()";
    } ?>

        $(document).on('change', ".dpv_collapsed_open", function(e){
            el = $(this);
            var el_id = el.attr('id');

            if(el.is(':checked')){
                $('#'+el_id+'_open').show();
            }else{
                $('#'+el_id+'_open').hide();
            }

            get_price();
        });



        // Fixes multiple modal issues
        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        var base_url = "<?php echo site_url();?>",
            payment_modal = $('#payment_modal');



        $(document).on('click', ".choose_package", function (e) {
            e.preventDefault();

            var has_reccuring = <?php echo $has_reccuring; ?>;
            if (has_reccuring) {
                swal.fire("<?php echo $this->lang->line('Subscription Message'); ?>", "<?php echo $this->lang->line('You have already a subscription enabled in paypal. If you want to use different paypal or different package, make sure to cancel your previous subscription from your paypal.');?>")
                    .then((value) => {
                        go_to_payment_summary();
                    });
            } else {
                go_to_payment_summary();
            }
        });
    });


</script>

<script>
    $('.scrollit').each(function () {
        const ps = new PerfectScrollbar($(this)[0], {
            suppressScrollX: true,
            wheelSpeed: 1,
            wheelPropagation: false,
        });
    });


</script>

<?php if ('yes' == $manual_payment): ?>
    <script>
        $(document).ready(function () {

            $(document).on('click', '#manual-payment-button', function () {
                $('#payment_modal').modal('toggle');
                $('#manual-payment-modal').modal();
            });

            // Uploads files
            var uploaded_file = $('#uploaded-file');
            Dropzone.autoDiscover = false;
            $("#manual-payment-dropzone").dropzone({
                url: '<?php echo base_url('payment/manual_payment_upload_file'); ?>',
                maxFilesize: 5,
                uploadMultiple: false,
                paramName: "file",
                createImageThumbnails: true,
                acceptedFiles: ".pdf,.doc,.txt,.png,.jpg,.jpeg,.zip",
                maxFiles: 1,
                addRemoveLinks: true,
                success: function (file, response) {
                    var data = JSON.parse(response);

                    // Shows error message
                    if (data.error) {
                        swal.fire({
                            icon: 'error',
                            text: data.error,
                            title: '<?php echo $this->lang->line('Error!'); ?>'
                        });
                        return;
                    }

                    if (data.filename) {
                        $(uploaded_file).val(data.filename);
                    }
                },
                removedfile: function (file) {
                    var filename = $(uploaded_file).val();
                    delete_uploaded_file(filename);
                },
            });

            // Handles form submit
            $(document).on('click', '#manual-payment-submit', function () {

                // Reference to the current el
                var that = this;

                // Shows spinner
                $(that).addClass('disabled btn-progress');

                var data = {
                    paid_amount: $('#paid-amount').val(),
                    paid_currency: $('#paid-currency').val(),
                    package_id: $('#selected-package-id').val(),
                    additional_info: $('#additional-info').val(),
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: '<?php echo base_url('payment/manual_payment'); ?>',
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            // Hides spinner
                            $(that).removeClass('disabled btn-progress');

                            // Empties form values
                            empty_form_values();
                            $('#selected-package-id').val('');

                            // Shows success message
                            swal.fire({
                                icon: 'success',
                                title: '<?php echo $this->lang->line('Success!'); ?>',
                                text: response.success,
                            });

                            // Hides modal
                            $('#manual-payment-modal').modal('hide');
                        }

                        // Shows error message
                        if (response.error) {
                            // Hides spinner
                            $(that).removeClass('disabled btn-progress');

                            swal.fire({
                                icon: 'error',
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                                text: response.error,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        $(that).removeClass('disabled btn-progress');
                    },
                });
            });

            $('#manual-payment-modal').on('hidden.bs.modal', function (e) {
                var filename = $(uploaded_file).val();
                delete_uploaded_file(filename);
                $('#selected-package-id').val('');
            });

            function delete_uploaded_file(filename) {
                if ('' !== filename) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {filename},
                        url: '<?php echo base_url('payment/manual_payment_delete_file'); ?>',
                        success: function (data) {
                            $('#uploaded-file').val('');
                        }
                    });
                }

                // Empties form values
                empty_form_values();
            }

            // Empties form values
            function empty_form_values() {
                $('#paid-amount').val(''),
                    $('.dz-preview').remove();
                $('#additional-info').val(''),
                    $('#paid-currency').prop("selectedIndex", 0);
                $('#manual-payment-dropzone').removeClass('dz-started dz-max-files-reached');

                // Clears added file
                Dropzone.forElement('#manual-payment-dropzone').removeAllFiles(true);
            }

        });
    </script>
<?php endif; ?>