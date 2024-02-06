<?php
$n_year = '';
foreach (range(date('Y'), date('Y') + 15) as $year) {
    $n_year .= '<option>' . $year . '</option>';
}
?>


<div class="modal fade" id="payment-paymongo-3ds" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $this->lang->line("Paymongo Action Required"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="paymongo_iframe" src="" style="width: 100%;border: 0;min-height: 370px;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal"><i class="bx bx-x"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payment-options-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><strong>Paymongo Credit Card</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="text-center mt-4 mb-4 paymongo_card_loader" style="display: none;">
                    <h5>Processing</h5>
                    <i class="bx bx-sync bx-spin font-large-5"></i>
                </div>

                <div class="alert alert-icon alert-warning alert-bg alert-inline show-code-action"
                     id="paymongo_amount_tolower" style="display: none;">
                    <span>Pay with Paymongo allow only for payment amout higher than 100 PHP</span>
                </div>

                <div class="alert alert-icon alert-warning alert-bg alert-inline show-code-action" id="paymongo_error"
                     style="display: none;">
                    <h4 class="alert-title">
                        <i class="w-icon-exclamation-triangle"></i></h4>
                    <span class="paymongo_error"></span>
                </div>

                <div class="paymongo_card_details">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="paymongo_name">Name</label>
                                <input class="form-control" id="paymongo_name" type="text" placeholder="Enter your name"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="paymongo_ccnumber">Credit Card Number</label>
                                <input required id="paymongo_ccnumber" name="paymongo_ccnumber" class="form-control"
                                       placeholder="0000 0000 0000 0000" type="tel" inputmode="numeric"
                                       pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="paymongo_ccmonth">Month</label>
                            <select class="form-control" id="paymongo_ccmonth" required>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="paymongo_ccyear">Year</label>
                            <select class="form-control" id="paymongo_ccyear" required>

                                <?php echo $n_year; ?>

                            </select>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="paymongo_cvv">CVV/CVC</label>
                                <input class="form-control" id="paymongo_cvv" type="text" placeholder="123" required>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="n_paymongo_pay_with_card"
                       class="btn btn-block btn-dark btn-icon-right btn-rounded btn-checkout place-order btn-next"
                       id="paymongo-checkout-button">PAY WITH CARD <i class="bx bx-right-arrow-alt"></i></a>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-x"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function check_PI(n_paymongo_paymentIntentId) {
        $.ajax({
            context: this,
            type: 'POST',
            dataType: 'JSON',
            url: base_url + 'n_paymongo/charge/' + $('#selected-package-id').val() + '/' + n_paymongo_paymentIntentId,
            success: function (response) {
                if (response.hasOwnProperty('redirect')) {
                    window.location.replace(response.redirect);
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

    //click on .paymongo_pay_card show form
    $(".paymongo_pay_card").on("click tap", function (e) {
        e.preventDefault()
        $('.paymongo_card_details').show();
        $("#payment-options-modal").modal();
    });

    $("#n_paymongo_pay_with_card").on("click tap", function (e) {
        e.preventDefault()
        $('.paymongo_card_details').hide();
        $('.paymongo_card_loader').show();
        $('#paymongo_error').hide();

        var paymongo_name = $('#paymongo_name').val();
        var paymongo_ccnumber = $('#paymongo_ccnumber').val();
        var paymongo_ccmonth = parseInt($('#paymongo_ccmonth').val());
        var paymongo_ccyear = parseInt($('#paymongo_ccyear').val());
        var paymongo_cvv = $('#paymongo_cvv').val();
        var csrf_token = '<?php echo $this->session->userdata('csrf_token_session'); ?>';

        $.ajax({
            context: this,
            dataType: 'JSON',
            type: 'POST',
            url: base_url + 'n_paymongo/n_payment_button/' + $('#selected-package-id').val(),
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
                        Authorization: `Basic <?php echo base64_encode($n_config['n_paymongo_pub']); ?>`
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
                                        email: "<?php echo $this->session->userdata('user_login_email'); ?>",
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
                                Authorization: `Basic <?php echo base64_encode($n_config['n_paymongo_pub']); ?>`
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
                                    $("#payment-paymongo-3ds").modal();

                                    $("#payment-paymongo-3ds .close").on("click tap", function (e) {
                                        // setTimeout(function(){
                                        //     $.magnificPopup.open({
                                        //         type: 'inline',
                                        //         items: {
                                        //             src: '#payment-options-modal'
                                        //         },
                                        //         preloader: false,
                                        //         modal: true
                                        //     });
                                        // }, 500);
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
</script>