<script type="text/javascript">
    function paymongo_prepare() {
        //click on .paymongo_pay_card show form
        $(".paymongo_pay_card").on("click", function (e) {
            e.preventDefault()
            $('.paymongo_card_details').show();
        });

        $("#n_paymongo_pay_with_card").on("click", function (e) {
            e.stopPropagation();
            e.preventDefault()
            $('.paymongo_card_details').hide();
            $('.paymongo_card_loader').show();

            var paymongo_name = $('#paymongo_name').val();
            var paymongo_ccnumber = $('#paymongo_ccnumber').val();
            var paymongo_ccmonth = parseInt($('#paymongo_ccmonth').val());
            var paymongo_ccyear = parseInt($('#paymongo_ccyear').val());
            var paymongo_cvv = $('#paymongo_cvv').val();
            var csrf_token = $('#csrf_token').val();


            $.ajax({
                context: this,
                dataType: 'JSON',
                type: 'POST',
                url: $('.paymongo_card_details').attr("action"),
                data: {
                    // name:paymongo_name,
                    // ccnumber:paymongo_ccnumber,
                    // ccmonth:paymongo_ccmonth,
                    // ccyear:paymongo_ccyear,
                    // cvv:paymongo_cvv,
                    csrf_token: csrf_token
                },
                success: function (response) {
                    if (response.hasOwnProperty('error')) {
                        $('.paymongo_card_details').show();
                        $('.paymongo_card_loader').hide();
                        $('#paymongo_error').show();
                        $('.paymongo_error').html(response.error.detail);
                    }

                    //var n_paymongo_paymentMethodId = response.paymongo_client_key.pm;
                    var n_paymongo_pub = response.paymongo_client_key.client_key;
                    var n_paymongo_paymentIntentId = n_paymongo_pub.split('_client')[0];
                    $.ajax({
                        context: this,
                        type: 'POST',
                        dataType: 'JSON',
                        url: 'https://api.paymongo.com/v1/payment_methods',
                        contentType: 'application/json',
                        headers: {
                            Authorization: `Basic <?php echo base64_encode($ecommerce_config['n_paymongo_pub']); ?>`
                        },
                        data:
                            JSON.stringify({
                                data: {
                                    attributes: {
                                        details: {
                                            card_number: paymongo_ccnumber,
                                            exp_year: paymongo_ccyear,
                                            exp_month: paymongo_ccmonth,
                                            cvc: paymongo_cvv,
                                        },
                                        billing: {
                                            name: paymongo_name,
                                            email: "<?php echo $webhook_data_final['email']; ?>",
                                        },
                                        type: "card"
                                    }
                                }
                            }),
                        success: function (response) {
                            if (response.hasOwnProperty('error')) {
                                $('.paymongo_card_details').show();
                                $('.paymongo_card_loader').hide();
                                $('#paymongo_error').show();
                                $('.paymongo_error').html(response.error.detail);
                            }

                            var n_paymongo_paymentMethodId = response.data.id;

                            $.ajax({
                                context: this,
                                type: 'POST',
                                dataType: 'JSON',
                                url: 'https://api.paymongo.com/v1/payment_intents/' + n_paymongo_paymentIntentId + '/attach',
                                headers: {
                                    Authorization: `Basic <?php echo base64_encode($ecommerce_config['n_paymongo_pub']); ?>`
                                },
                                data: {
                                    data: {
                                        attributes: {
                                            client_key: n_paymongo_pub,
                                            payment_method: n_paymongo_paymentMethodId
                                        }
                                    }
                                },
                                success: function (response) {
                                    var paymentIntent = response.data;
                                    var paymentIntentStatus = paymentIntent.attributes.status;
                                    if (paymentIntentStatus === 'awaiting_next_action') {
                                        // Render your modal for 3D Secure Authentication since next_action has a value. You can access the next action via paymentIntent.attributes.next_action.
                                        $('#paymongo_iframe').attr('src', paymentIntent.attributes.next_action.redirect.url);
                                        $.magnificPopup.open({
                                            type: 'inline',
                                            items: {
                                                src: '#payment-paymongo-3ds'
                                            },
                                            preloader: false,
                                            modal: true
                                        });

                                        $("#payment-paymongo-3ds .mfp-close").on("click", function (e) {
                                            setTimeout(function () {
                                                $.magnificPopup.open({
                                                    type: 'inline',
                                                    items: {
                                                        src: '#payment-options-modal'
                                                    },
                                                    preloader: false,
                                                    modal: true
                                                });
                                            }, 500);
                                            setTimeout(function () {
                                                check_PI(n_paymongo_paymentIntentId)
                                            }, 2000);
                                        });

                                    } else if (paymentIntentStatus === 'succeeded') {
                                        check_PI(n_paymongo_paymentIntentId);
                                    } else if (paymentIntentStatus === 'awaiting_payment_method') {
                                        check_PI(n_paymongo_paymentIntentId);
                                    } else if (paymentIntentStatus === 'processing') {
                                        setTimeout(function () {
                                            check_PI(n_paymongo_paymentIntentId)
                                        }, 4000);
                                    }
                                }
                            }).fail(function (jqXHR) {
                                var response = jqXHR.responseJSON;
                                $('.paymongo_card_details').show();
                                $('.paymongo_card_loader').hide();
                                $('#paymongo_error').show();
                                $('.paymongo_error').html(response.errors[0].detail);
                            });
                        }
                    }).fail(function (jqXHR) {
                        var response = jqXHR.responseJSON;
                        $('.paymongo_card_details').show();
                        $('.paymongo_card_loader').hide();
                        $('#paymongo_error').show();
                        $('.paymongo_error').html(response.errors[0].detail);
                    });

                }
            }).fail(function (jqXHR) {
                var response = jqXHR.responseJSON;
                $('.paymongo_card_details').show();
                $('.paymongo_card_loader').hide();
                $('#paymongo_error').show();
                $('.paymongo_error').html(response.errors[0].detail);
            });

        });


        function check_PI(n_paymongo_paymentIntentId) {
            $.ajax({
                context: this,
                type: 'POST',
                dataType: 'JSON',
                url: base_url + 'n_paymongo/card_eco_charge/' + store_id + '/' + cart_id + '/' + subscriber_id + '/' + n_paymongo_paymentIntentId,
                success: function (response) {
                    if (response.hasOwnProperty('redirect')) {
                        window.location.replace(base_url_js + response.redirect);
                    }
                    if (response.hasOwnProperty('status')) {
                        if (response.error != null) {
                            $('.paymongo_error').html(response.error.failed_message);
                        } else {
                            $('.paymongo_error').html('Payment failed. Try again');
                        }
                        $('#paymongo_error').show();
                        $('.paymongo_card_details').show();
                        $('.paymongo_card_loader').hide();
                    }

                }
            });
        }


    }
</script>


<div class="n_modal mfp-hide" id="payment-paymongo-3ds">
    <div class="">
        <h4><?php echo $this->lang->line("Paymongo Action Required"); ?></h4>
        <div class="modal-body">
            <iframe id="paymongo_iframe" src="" style="width: 100%;border: 0;min-height: 370px;"></iframe>
        </div>
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>