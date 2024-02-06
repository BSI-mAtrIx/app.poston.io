<form><input type="hidden" name="csrf_token" id="csrf_token"
             value="<?php echo $this->session->userdata('csrf_token_session'); ?>"></form>
<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php') and $webhook_data_final['n_paymongo_enabled'] == '1') {
    include(APPPATH . 'modules/n_paymongo/views/ecommerce.php');
} ?>

<?php

if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php') and $webhook_data_final['n_moamalat_enabled'] == '1') {
    include(APPPATH . 'modules/n_moamalat/views/ecommerce.php');
} ?>
<script>
    var current_url = "<?php echo $current_url; ?>";
    var base_url = "<?php echo site_url(); ?>";
    var cart_id = '<?php echo $order_no;?>';
    var store_id = '<?php echo $webhook_data_final["store_id"];?>';
    var store_type = '<?php echo $webhook_data_final["store_type"];?>';
    var subscriber_id = '<?php echo $subscriber_id;?>';

    var order_schedule = '<?php echo $order_schedule;?>';
    var today = new Date();
    var maxday = new Date();
    if (order_schedule == 'today') maxday = today;
    else if (order_schedule == 'tomorrow') maxday.setDate(maxday.getDate() + 1);
    else if (order_schedule == 'week') maxday.setDate(maxday.getDate() + 6);
    else maxday = false;

    function load_address_list() {
        $("#proceed_checkout").addClass('btn-progress');
        $.ajax({
            context: this,
            type: 'POST',
            url: base_url_js + "/get_buyer_address_list/1",
            data: {subscriber_id: subscriber_id, store_id: store_id},
            success: function (response) {
                $("#put_delivery_address_list").html(response);
                $("#proceed_checkout").removeClass('btn-progress');
            }
        });
    }

    $("document").ready(function () {

        setTimeout(function () {
            load_address_list();
        }, 500);

        $('#delivery_time').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            maxDate: maxday
        });

        $(document).on('click tap', '#apply_coupon', function (e) {
            e.preventDefault();
            var coupon_code = $("#coupon_code").val();

            $("#apply_coupon").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {coupon_code, cart_id, subscriber_id},
                url: '<?php echo _link('ecommerce/apply_coupon'); ?>',
                success: function (response) {
                    $("#apply_coupon").removeClass("btn-progress");
                    if (response.status == '0') swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                    else {
                        swal.fire("<?php echo $this->lang->line('Success'); ?>", response.message, 'success');
                        window.location.replace(current_url);
                    }
                }
            });

        });

        $(document).on('change', '#store_pickup', function (e) {
            var store_pickup = '0';
            if ($(this).is(':checked')) store_pickup = '1';
            $.ajax({
                type: 'POST',
                data: {cart_id, subscriber_id, store_pickup},
                url: '<?php echo _link('ecommerce/apply_store_pickup'); ?>',
                success: function (response) {
                    window.location.replace(current_url);
                }
            });

        });

        $(document).on('click tap', '#proceed_checkout', function (e) {
            e.preventDefault();
            $("#payment_options").html('');
            var input_name;
            var address_data = new Object();
            var pickup_point_details = $("#pickup_point_details").val();
            var delivery_address_id = $("#select_delivery_address").val();
            var delivery_note = $("#delivery_note").val();
            var delivery_time = $("#delivery_time").val();
            var store_pickup = '0';
            if ($("#store_pickup").is(':checked')) store_pickup = '1';

            if (store_type == 'physical') {
                if (!delivery_address_id && $("#store_pickup").is(':checked') == false) {
                    swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select delivery address or pickup point before you proceed.');?>", 'error');
                    return false;
                }
            }
            var subscriber_first_name = '<?php echo $wc_first_name;?>';
            var subscriber_last_name = '<?php echo $wc_last_name;?>';
            var subscriber_auto_id = '<?php echo $webhook_data_final['subscriber_auto_id'] ?? 0 ?>';
            var subscriber_country = '<?php echo $store_country;?>';
            var param = {
                cart_id: cart_id,
                subscriber_id: subscriber_id,
                subscriber_first_name: subscriber_first_name,
                subscriber_last_name: subscriber_last_name,
                delivery_address_id: delivery_address_id,
                store_pickup: store_pickup,
                pickup_point_details: pickup_point_details,
                delivery_note: delivery_note,
                subscriber_country: subscriber_country,
                store_id: store_id,
                delivery_time: delivery_time,
                subscriber_auto_id: subscriber_auto_id
            };
            var mydata = JSON.stringify(param);
            $("#proceed_checkout").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {mydata: mydata},
                url: '<?php echo _link('ecommerce/proceed_checkout'); ?>',
                success: function (response) {
                    $("#proceed_checkout").removeClass("btn-progress");
                    if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        if (response.login_popup)
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error"); ?>',
                                html: span,
                                icon: 'error'
                            }).then((value) => {
                                $("#login_form").trigger('click');
                            });
                        else swal.fire({title: '<?php echo $this->lang->line("Error"); ?>', html: span, icon: 'error'});
                    } else if (response.status == '2') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        swal.fire({title: '<?php echo $this->lang->line("Oops!"); ?>', html: span, icon: 'warning'});
                    } else {
                        $("#payment_options").html(response.html);
                        $.magnificPopup.open({
                            type: 'inline',
                            items: {
                                src: '#payment-options-modal'
                            },
                            preloader: false,
                            modal: true
                        });
                        <?php if(file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php') and $webhook_data_final['n_omise_enabled'] == '1'){ ?>
                        omise_prepare();
                        <?php } ?>
                        <?php if(file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php') and $webhook_data_final['n_paymongo_enabled'] == '1'){ ?>
                        paymongo_prepare();
                        <?php } ?>
                        <?php if(file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php') and $webhook_data_final['n_paymentwall_enabled'] == '1'){ ?>
                        //paymentwall_prepare();
                        <?php } ?>
                        // $("#manual-payment-ins-modal .modal-body").html(response.manual_payment_instruction);
                        // $("html, body").animate({ scrollTop: $(document).height() }, 100);
                        // $("#proceed_checkout").parent().hide();
                    }
                }
            });

        });

        $(document).on('click tap', '#manual-payment-button', function () {
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#manual-payment-modal'
                },
                preloader: false,
                modal: true
            });
        });

        $(document).on('click tap', '#mollie-payment-button', function (e) {
            e.preventDefault();
            var redirect_url = $(this).attr('href');
            window.top.location.href = redirect_url;
        });

        $(document).on('click tap', '#cod-payment-button', function (e) {
            e.preventDefault();
            var cart_id = '<?php echo $order_no;?>';
            var subscriber_id = '<?php echo $subscriber_id;?>';
            $("#cod-payment-button").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {cart_id, subscriber_id},
                url: '<?php echo _link('ecommerce/cod_payment'); ?>',
                success: function (response) {
                    $("#cod-payment-button").removeClass("btn-progress");
                    if (response.error) {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.error, 'error');
                    } else {
                        if (n_custom_domain == 1) {
                            response.redirect = response.redirect.replaceAll('ecommerce/', '');
                        }
                        window.location.href = response.redirect;
                    }
                }

            });
        });

        // Handles form submit
        $(document).on('click tap', '#manual-payment-submit', function () {

            // Reference to the current el
            var that = this;

            // Shows spinner
            $(that).addClass('btn-progress');
            var formData = new FormData($("#manaul_payment_data")[0]);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'JSON',
                url: '<?php echo _link('ecommerce/manual_payment'); ?>',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.success) {

                        $(that).removeClass('btn-progress');
                        empty_form_values();
                        $('#manual-payment-modal').magnificPopup('close');
                        if (n_custom_domain == 1) {
                            response.redirect = response.redirect.replaceAll('ecommerce/', '');
                        }
                        window.location.href = response.redirect;
                    }

                    if (response.error) {

                        $(that).removeClass('btn-progress');

                        var span = document.createElement("span");
                        span.innerHTML = response.error;

                        swal.fire({
                            icon: 'error',
                            title: '<?php echo $this->lang->line('Error'); ?>',
                            html: span,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    $(that).removeClass('btn-progress');
                },
            });
        });


        // Empties form values
        function empty_form_values() {
            $('#paid-amount').val('');
            $('#additional-info').val('');
            $('#paid-currency').prop("selectedIndex", 0);
            $("#manual-payment-file").val('');
            // Clears added file
        }

        $(document).on('click tap', '.delete_item', function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var subscriber_id = '<?php echo $subscriber_id;?>';
            var cart_id = '<?php echo $order_no;?>';
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {id, cart_id, subscriber_id},
                url: '<?php echo _link('ecommerce/delete_cart_item'); ?>',
                success: function (response) {
                    if (response.status == '0') {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                    } else {
                        window.location.replace(current_url);
                    }

                }
            });

        });

        $(document).on('focusout change', '.quantity', function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var action = $(this).attr("data-action");
            var quantity = $(this).val();

            quantity = parseInt(quantity);

            if (quantity == 0) {
                $('.delete_item[data-id=' + id + ']').trigger('click');
                return;
            }


            $(".add_to_cart").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                data: {id, action, cart_id, store_id, subscriber_id, quantity},
                url: '<?php echo _link('ecommerce/update_cart_item_checkout_input'); ?>',
                success: function (response) {
                    if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        if (response.login_popup)
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error"); ?>',
                                html: span,
                                icon: 'error'
                            }).then((value) => {
                                $("#login_form").trigger('click');
                            });
                        else swal.fire({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            html: span,
                            icon: 'error'
                        }).then((value) => {
                            window.location.reload();
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        });

        $(document).on('click touchstart', '.add_to_cart2', function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var action = $(this).attr("data-action");
            var quantity = $(this).attr("data-quantity");
            quantity = parseInt(quantity);
            if (quantity <= 1 && action == 'remove') {
                $('.delete_item[data-id=' + id + ']').trigger('click');
                return;
            }

            $(".add_to_cart").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                data: {id, action, cart_id, store_id, subscriber_id, quantity},
                url: '<?php echo _link('ecommerce/update_cart_item_checkout'); ?>',
                dataType: 'json',
                success: function (response) {
                    if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        if (response.login_popup)
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error"); ?>',
                                html: span,
                                icon: 'error'
                            }).then((value) => {
                                $("#login_form").trigger('click');
                            });
                        else swal.fire({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            html: span,
                            icon: 'error'
                        }).then((value) => {
                            window.location.reload();
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        });

        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    });
</script>


<div class="n_modal mfp-hide" id="deliveryAddressModal">
    <div>
        <h4><?php echo $this->lang->line("Delivery Address"); ?></h4>
        <div class="modal-body" id="deliveryAddressModalBody">

        </div>
        <button type="button" id="new_address" class="btn btn-primary btn-block no_radius p-3 m-0"><i
                    class="w-icon-plus"></i> <?php echo $this->lang->line("Add Address"); ?></button>
        <button type="button" id="save_address" data-close="0"
                class="btn btn-primary btn-block no_radius p-3 m-0 d-none"><i
                    class="w-icon-check-solid"></i> <?php echo $this->lang->line("Save Address"); ?> </button>
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>


<div class="n_modal mfp-hide" id="payment-options-modal">
    <div class="">
        <h4><?php echo $this->lang->line("Payment Options"); ?></h4>
        <div class="modal-body" id="payment_options">

        </div>
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>

<div class="n_modal mfp-hide" id="manual-payment-modal">
    <div class="">
        <h4><?php echo $this->lang->line("Manual payment"); ?></h4>
        <div class="modal-body">
            <div class="container p-0">

                <form action="#" method="POST" id="manaul_payment_data" enctype="multipart/form-data">
                    <?php if (isset($manual_payment_instruction) && !empty($manual_payment_instruction)): ?>
                        <div class="alert alert-success alert-block alert-inline mb-4">
                            <h4 class="alert-title">
                                <i class="w-icon-dots-circle"></i><?php echo $this->lang->line('Instructions'); ?></h4>

                            <?php echo $manual_payment_instruction; ?>
                            <button class="btn btn-link btn-close">
                                <i class="close-icon"></i>
                            </button>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $order_no; ?>">
                    <input type="hidden" name="subscriber_id" id="subscriber_id" value="<?php echo $subscriber_id; ?>">

                    <!-- Paid amount and currency -->
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="paid-amount"><?php echo $this->lang->line('Paid Amount'); ?></label>
                                <input type="number" name="paid-amount" id="paid-amount" class="form-control" min="1">
                                <input type="hidden" id="selected-package-id">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="paid-currency"><?php echo $this->lang->line('Currency'); ?></label>
                                <?php echo form_dropdown('paid-currency', $currency_list, $currency, ['id' => 'paid-currency', 'class' => 'form-control select2', 'style' => 'width:100%']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Additional Info -->
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for="paid-amount"><?php echo $this->lang->line('Additional Info'); ?></label>
                                <textarea name="additional-info" id="additional-info" class="form-control"></textarea>
                            </div>
                        </div>
                        <!-- Image upload - Dropzone -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="d-flex" style="width:100%;">
                                    <span class="header-left">
                                        <?php echo $this->lang->line('Attachment'); ?><?php echo $this->lang->line('(Max 5MB)'); ?>
                                    </span>
                                    <span class="header-right"><?php echo $this->lang->line("Allowed types"); ?>: pdf, doc, txt, png, jpg, zip</span>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="manual-payment-file"
                                           name="manual-payment-file">
                                    <label class="custom-file-label"
                                           for="manual-payment-file"><?php echo $l->line('Choose file'); ?></label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button type="button" id="manual-payment-submit" class="btn btn-primary mt-2"><i
                                class="w-icon-check-solid"></i> <?php echo $this->lang->line('Submit'); ?></button>
                </form>

            </div><!-- ends container -->
        </div><!-- ends modal-body -->
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>
