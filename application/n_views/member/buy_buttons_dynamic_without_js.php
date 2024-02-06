
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', "#show_field_coupon", function (e) {
            e.preventDefault();

            $('#coupon_field').show();
            $('#show_field_coupon').hide();
        });

        function save_invoice(source=0){
            var invoice_data = {};
            invoice_data['inv_name'] = $('#inv_name').val();
            invoice_data['inv_bus_name'] = $('#inv_bus_name').val();
            invoice_data['inv_vat_number'] = $('#inv_vat_number').val();
            invoice_data['inv_country'] = $('#inv_country').val();
            invoice_data['inv_street'] = $('#inv_street').val();
            invoice_data['inv_postcode'] = $('#inv_postcode').val();
            invoice_data['inv_city'] = $('#inv_city').val();
            invoice_data['inv_email'] = $('#inv_email').val();
            invoice_data['inv_mobile'] = $('#inv_mobile').val();

            var to_send = {
                "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>",
                "invoice_data": invoice_data,
                "package_id":  <?php echo $pack_det['id']; ?>,
                "discount_coupon": $('#coupon_code').val(),
                "final_action": source
            };

            $.ajax({
                type: 'POST',
                data: to_send,
                dataType: 'JSON',
                url: base_url + 'price/api/invoice_data',
                success: function (response) {
                    if(response.status==1){
                        if(typeof response.message.new_price != undefined){
                            $('#new_price_vat_update').html(response.message.new_price);
                        }

                        if(typeof response.message.coupon != undefined){
                            if(typeof response.message.coupon.coupon_apply != undefined){
                                if(response.message.coupon.coupon_apply==true){
                                    $('#payment_options').show();
                                    $('#show_coupon').show();
                                    $('#coupon_value_fixed').html(response.message.coupon.discount);

                                    if(typeof response.message.coupon.special && response.message.coupon.special==true){
                                        $('#payment_options').hide();
                                        $('#coupon_activate_packge_div').show();
                                    }
                                }

                                if(response.message.coupon.coupon_apply==false){
                                    swal.fire(response.message.coupon.coupon_info)
                                }

                            }
                        }

                    }else{

                    }
                }
            });
        }


        $(document).on('click', '#coupon_activate_packge', function () {
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

            var to_send = {
                "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>",
                "package_id":  <?php echo $pack_det['id']; ?>,
                "discount_coupon": $('#coupon_code').val(),
                "final_action": 1
            };

            $.ajax({
                type: 'POST',
                data: to_send,
                dataType: 'JSON',
                url: base_url + 'price/api/coupon_special_activate',
                success: function (response) {

                    if(response.status==1){
                        window.location.assign(response.message.redirect);
                    }else{
                        swal.fire(response.message);
                    }
                }
            });
        });


        $(document).on('change', '.button_fnc', function () {
            save_invoice();
        });

        $(document).on('click', '#payment_options a', function () {
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

            save_invoice(1);
        });

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        var base_url = "<?php echo site_url();?>",
            payment_modal = $('#payment_modal');

        function get_payment_button(package) {
            $("#waiting").show();
            $("#button_place").html('');
            $("#payment_modal").modal();
            $.ajax
            ({
                type: 'POST',
                data: {package: package},
                url: base_url + 'payment/payment_button/',
                success: function (response) {
                    $("#waiting").hide();
                    $("#button_place").html(response);
                }

            });
        }

        $(document).on('click', ".choose_package", function (e) {
            e.preventDefault();
            var package = <?php echo $package_id; ?>;

            // Sets package id for manual payment
            $('#selected-package-id').val(package);

            var has_reccuring = <?php echo $has_reccuring; ?>;
            if (has_reccuring) {
                swal.fire("<?php echo $this->lang->line('Subscription Message'); ?>", "<?php echo $this->lang->line('You have already a subscription enabled in paypal. If you want to use different paypal or different package, make sure to cancel your previous subscription from your paypal.');?>")
                    .then((value) => {
                        get_payment_button(package);
                    });
            } else get_payment_button(package);
        });


        save_invoice();

        $(document).on('click', "#apply_coupon", function (e) {
            e.preventDefault();

            save_invoice();
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
                            // $('#selected-package-id').val('');

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
                // $('#selected-package-id').val('');
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

<script>
    var sslcommers_mode = '<?php echo $sslcommers_mode; ?>';
    var ssl_post_data = '<?php echo $postdata_array; ?>';
    var ssl_post_json_data = JSON.parse(ssl_post_data);
    $('#sslczPayBtn').prop('postdata', ssl_post_json_data);

    (function (window, document) {
        var loader = function () {
            var sslcommerzUrl = '';
            if (sslcommers_mode == 'live') sslcommerzUrl = "https://seamless-epay.sslcommerz.com/embed.min.js?";
            else sslcommerzUrl = "https://sandbox.sslcommerz.com/embed.min.js?";
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = sslcommerzUrl + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);

</script>


<?php if ($n_config['omise_on'] == 'true') { ?>
    <script type="text/javascript" src="https://cdn.omise.co/omise.js"></script>
    <script type="text/javascript">
        // Set default parameters
        OmiseCard.configure({
            publicKey: '<?php echo $n_config['omise_public_key']; ?>',
            image: 'https://cdn.omise.co/assets/dashboard/images/omise-logo.png',
            frameLabel: '<?php echo $this->config->item('product_name'); ?>',
        });

        // Configuring your own custom button
        OmiseCard.configureButton('#omise-checkout-button-1', {
            buttonLabel: '<?php echo $this->lang->line('PAY Now');  echo $payment_package_sorted[$package_id]['price']; echo $currency; ?>',
            submitLabel: '<?php echo $this->lang->line('PAY Now'); ?>',
            amount: <?php echo $payment_package_sorted[$package_id]['price'];?>00,
            currency: '<?php echo $currency; ?>',
        });

        // Then, attach all of the config and initiate it by 'OmiseCard.attach();' method
        OmiseCard.attach();

        $(document).ready(function ($) {
            $(document).on('click', '#omise-button', function (event) {
                event.preventDefault();
                $('#omise-checkout-button-1').click();
            });
        });
    </script>
<?php } ?>

<?php if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php') and $n_config['n_paymongo_gateway_enabled'] == 'true') {
    include(APPPATH . 'modules/n_paymongo/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php') and $n_config['n_moamalat_enabled'] == 'true') {
    include(APPPATH . 'modules/n_moamalat/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php') and $n_config['n_tdsp_enabled'] == 'true') {
    include(APPPATH . 'modules/n_tdsp/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php') and $n_config['n_stripe_enabled'] == 'true') {
    include(APPPATH . 'modules/n_stripe/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php') and $n_config['n_sadad_enabled'] == 'true') {
    include(APPPATH . 'modules/n_sadad/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_mastercard/controllers/N_mastercard.php') and $n_config['n_mastercard_enabled'] == 'true') {
    include(APPPATH . 'modules/n_mastercard/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php') and $n_config['n_epayco_enabled'] == 'true' AND ($currency == 'USD' OR $currency == 'COP')) {
    include(APPPATH . 'modules/n_epayco/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php') and $n_config['n_epayco_subs_enabled'] == 'true' AND ($currency == 'USD' OR $currency == 'COP')) {
    include(APPPATH . 'modules/n_epayco/views/dashboard_subscription.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php') and $n_config['n_sellix_enabled'] == 'true') {
    include(APPPATH . 'modules/n_sellix/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php') and $n_config['n_chapa_enabled'] == 'true') {
    include(APPPATH . 'modules/n_chapa/views/dashboard.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php') and $n_config['n_zaincash_enabled'] == 'true') {
    include(APPPATH . 'modules/n_zaincash/views/dashboard.php');
} ?>

<script src="https://cdn.sellix.io/static/js/embed.js"></script>

<link href="https://cdn.sellix.io/static/css/embed.css" rel="stylesheet"/>
