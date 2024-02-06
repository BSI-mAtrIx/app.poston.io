<style>
    /* Manual payment style */
    #manual-payment-modal #additional-info {
        height: 160px !important;
    }


</style>


<?php
$pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';
$sslcommerz_mode = isset($ecommerce_config['sslcommerz_mode']) ? $ecommerce_config['sslcommerz_mode'] : "live";
`$is_order_schedule` = isset($ecommerce_config['is_order_schedule']) ? $ecommerce_config['is_order_schedule'] : "0";

$is_delivery_note = isset($ecommerce_config['is_delivery_note']) ? $ecommerce_config['is_delivery_note'] : "0";
$store_pickup_title = isset($ecommerce_config['store_pickup_title']) ? $ecommerce_config['store_pickup_title'] : "Store Pickup";


$manual_payment_instruction = isset($ecommerce_config['manual_payment_instruction']) ? $ecommerce_config['manual_payment_instruction'] : '';
$order_title = $this->lang->line("Checkout");
$order_date = date("jS M,Y", strtotime($webhook_data_final['updated_at']));

// $confirmation_response = json_decode($webhook_data_final['confirmation_response'],true);
$wc_buyer_location = json_decode($webhook_data_final['user_location'], true);
if (!is_array($wc_buyer_location)) $wc_buyer_location = array();
$currency = $webhook_data_final['currency'];
$currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : '$';
$wc_email_bill = $webhook_data_final['email'];


$delivery_time = $webhook_data_final['delivery_time'];
if ($delivery_time = '0000-00-00 00:00:00') $delivery_time = '';


$payment_method = $webhook_data_final['payment_method'];
if ($payment_method == '') $payment_method = '<span class="badge badge-danger">' . $this->lang->line("Incomplete") . '</span>';
else $payment_method = $payment_method . " " . $webhook_data_final['card_ending'];


$buyer_country = isset($country_names[$webhook_data_final["buyer_country"]]) ? ucwords(strtolower($country_names[$webhook_data_final["buyer_country"]])) : $webhook_data_final["buyer_country"];

// $buyer_address = $webhook_data_final["buyer_address"]."<br>".$webhook_data_final["buyer_state"]." ".$webhook_data_final["buyer_zip"]."<br>".$buyer_country;
$store_name = $webhook_data_final['store_name'];
$store_address = "<i class='bx bx-map-pin'></i> " . $webhook_data_final["store_address"] . ", " . $webhook_data_final["store_state"] . ", " . $webhook_data_final["store_city"] . ", " . $store_country_formatted . " " . $webhook_data_final["store_zip"] . " <br><i class='bx bx-paper-plane'></i> " . $webhook_data_final['store_phone'] . ", " . $webhook_data_final['store_email'];
$store_phone = $webhook_data_final["store_phone"];
$store_email = $webhook_data_final["store_email"];
$subscriber_id_database = $webhook_data_final["subscriber_id"];
$store_unique_id = $webhook_data_final["store_unique_id"];

$table_data = '';
$i = 0;
// $subtotal_count = 0;
foreach ($product_list as $key => $value) {

}

$coupon_info2 = "";
if ($coupon_code != '' && $coupon_type == "fixed cart")
    $coupon_info2 =
        '<li class="list-group-item d-flex justify-content-between align-items-center no_border text-muted pl-3 pr-3 pt-1 pb-1">
  ' . $this->lang->line("Discount") . '<span class="font-weight-bold text-dark">-' . $currency_left . mec_number_format($coupon_amount, $decimal_point, $thousand_comma) . $currency_right . '</span>
</li>';

$tax_info = "";
if ($total_tax > 0)
    $tax_info =
        '<li class="list-group-item d-flex justify-content-between align-items-center no_border text-muted pl-3 pr-3 pt-1 pb-1">
  ' . $this->lang->line("Tax") . '<span class="font-weight-bold text-dark">+' . $currency_left . mec_number_format($total_tax, $decimal_point, $thousand_comma) . $currency_right . '</span>
</li>';

$shipping_info = "";
if ($shipping_cost > 0)
    $shipping_info =
        '<li class="list-group-item d-flex justify-content-between align-items-center no_border text-muted pl-3 pr-3 pt-1 pb-1">
  ' . $this->lang->line("Delivery Charge") . '<span class="font-weight-bold text-dark">+' . $currency_left . mec_number_format($shipping_cost, $decimal_point, $thousand_comma) . $currency_right . '</span>
</li>';
// $coupon_code." (".$currency_icon.$coupon_amount.")";      

//if($webhook_data_final['action_type']!='checkout') $subtotal = $subtotal_count;
$subtotal = mec_number_format($subtotal, $decimal_point, $thousand_comma);
$checkout_amount = mec_number_format($checkout_amount, $decimal_point, $thousand_comma);
$coupon_amount = mec_number_format($coupon_amount, $decimal_point, $thousand_comma);

$output = "";
$after_checkout_details =
    '<li class="list-group-item d-flex justify-content-between align-items-center no_radius no_border pl-3 pr-3 pt-1 pb-1">
  ' . $this->lang->line("Total") . '<span class="font-weight-bold text-primary">' . $currency_left . $checkout_amount . $currency_right . '</span>
</li>';

$apply_coupon = '
<a class="collpase_link float-left text-dark" data-toggle="collapse" href="#collapsecoupon" role="button" aria-expanded="false" aria-controls="collapsecoupon"><i class="bx bx-gift ml-0"></i> ' . $this->lang->line("Apply Coupon") . '</a>

<a class="float-right text-dark showProfile" href="#"><i class="bx bx-map-pin"></i> ' . $this->lang->line("Billing Address") . '</a> 
<div class="input-group collapse pt-2" id="collapsecoupon">

  <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="' . $this->lang->line("Coupon Code") . '" value="' . $coupon_code . '">
  <div class="input-group-append">
    <button class="btn btn-primary" type="button" id="apply_coupon"><i class="bx bx-check-circle"></i> ' . $this->lang->line("Apply") . '</button>
  </div>
</div>';

$delivery_note = '';
if ($is_delivery_note == '1')
    $delivery_note = '<div class="mt-3 pb-2">
<a class="collpase_link text-dark" data-toggle="collapse" href="#collapsenote" role="button" aria-expanded="false" aria-controls="collapsenote"><i class="bx bx-note ml-0"></i> ' . $this->lang->line("Write a note") . '</a>
<div class="input-group collapse pt-2 show" id="collapsenote">
  <textarea class="form-control" id="delivery_note" name="delivery_note">' . $webhook_data_final["delivery_note"] . '</textarea>
</div>';

$seller_info =
    '<h6 class="mt-3">' . $this->lang->line("Seller") . '</h6>
<p class="section-lead ml-0">
' . $store_address . '<br>
' . $store_email . '<br>' . $store_phone . '
</p>
';


$coupon_details =
    '<div class="col-12 mt-2 mb-2">
  ' . $apply_coupon . '                   
</div>';

$seller_details =
    '<div class="col-8 col-md-5">
  ' . $seller_info . '                     
</div>';
?>
<?php
// $hide_delivery_address = '';
// $hide_store_pickup = 'd-none';
// $check_store_pickup = '';
// $height = '120px';
// if($is_store_pickup=='1')
// {
//   $hide_store_pickup = '';
//   $height = '190px;';
//   if($webhook_data_final['store_pickup']=='1' || $pickup!='')
//   {
//     $hide_delivery_address = 'd-none';
//     $check_store_pickup = 'checked';
//     $height = '80px';
//   }
// }


$order_schedule_html = $order_schedule_button = '';
if ($is_order_schedule == '1') {
    $order_schedule_button = '
      <br><a class="collpase_link text-dark" data-toggle="collapse" href="#collapsetime" role="button" aria-expanded="false" aria-controls="collapsetime"><i class="bx bx-time ml-0"></i> ' . $this->lang->line("Choose delivey time") . '</a>';

    $show_time = $delivery_time != '' ? 'show' : '';

    $order_schedule_html = '   
      <div class="input-group collapse pt-2 ' . $show_time . '" id="collapsetime">
        <input type="text" class="form-control" id="delivery_time" readonly name="delivery_time" style="height:50px;" placeholder="' . $this->lang->line("Set delivery time") . '" value="' . $delivery_time . '">
      </div>';
}
?>


<div id="place-order" class="list-view product-checkout">
    <div class="checkout-items">
        <?php echo $table_data; ?>
    </div>
    <?php if ($i > 0) : ?>
        <div class="checkout-options">
            <div class="card">
                <div class="card-body">
                    <label class="section-label mb-1"><?php echo $this->lang->line("Cart"); ?><span
                                class="pl-2"><?php echo date("jS M,Y"); ?></span></label>
                    <div class="coupons input-group input-group-merge">
                        <a class="collpase_link float-left text-dark" data-toggle="collapse" href="#collapsecoupon"
                           role="button" aria-expanded="false" aria-controls="collapsecoupon"><i
                                    class="bx bx-gift ml-0"></i> <?php echo $this->lang->line("Apply Coupon"); ?></a>
                        <?php echo '<div class="input-group collapse pt-2" id="collapsecoupon">

  <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="' . $this->lang->line("Coupon Code") . '" value="' . $coupon_code . '">
  <div class="input-group-append">
    <button class="btn btn-primary" type="button" id="apply_coupon"><i class="bx bx-check-circle"></i> ' . $this->lang->line("Apply") . '</button>
  </div></div>'; ?>
                    </div>
                    <hr/>


                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


<div class="modal fade" role="dialog" id="manual-payment-modal" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-receipt"></i> <?php echo $this->lang->line("Manual payment"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bx bx-chevron-left"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container p-0">

                    <form action="#" method="POST" id="manaul_payment_data" enctype="multipart/form-data">
                        <?php if (isset($manual_payment_instruction) && !empty($manual_payment_instruction)): ?>
                            <div class="alert alert-light alert-has-icon">
                                <div class="alert-icon"><i class="bx bx-bulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title"><?php echo $this->lang->line('Instructions'); ?></div>
                                    <?php echo $manual_payment_instruction; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $order_no; ?>">
                        <input type="hidden" name="subscriber_id" id="subscriber_id"
                               value="<?php echo $subscriber_id; ?>">

                        <!-- Paid amount and currency -->
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <div class="form-group">
                                    <label for="paid-amount"><?php echo $this->lang->line('Paid Amount'); ?></label>
                                    <input type="number" name="paid-amount" id="paid-amount" class="form-control"
                                           min="1">
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
                                    <textarea name="additional-info" id="additional-info"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                            <!-- Image upload - Dropzone -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label style="width:100%;">
                                        <?php echo $this->lang->line('Attachment'); ?> <?php echo $this->lang->line('(Max 5MB)'); ?>
                                        <span class="red float-right"><?php echo $this->lang->line("Allowed types"); ?> : pdf, doc, txt, png, jpg & zip</span>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="manual-payment-file"
                                               name="manual-payment-file">
                                        <label class="custom-file-label" for="manual-payment-file">Choose file</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <button type="button" id="manual-payment-submit" class="btn btn-primary mt-2"><i
                                    class="bx bx-check-circle"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span>
                        </button>
                    </form>

                </div><!-- ends container -->
            </div><!-- ends modal-body -->
        </div>
    </div>
</div>

<style type="text/css">
    .delete_item i {
        font-size: 24px !important;
    }

    .cart_actions .input-group-text, .cart_actions button {
        font-size: 14px !important;
        font-weight: normal;
    }

    .collpase_link:hover, .showProfile:hover {
        text-decoration: none;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .section .section-title {
        margin: 20px 0 20px 0;
    }

    #payment_options .list-group-item-action {
        margin-bottom: 30px;
    }

    #payment_options .list-group-item-action {
        margin-bottom: 30px;
    }

    #payment_options img {
        margin-right: 20px;
    }

    @media (max-width: 978px) {
        #proceed_checkout {
            font-weight: bold;
            font-size: 14px;
            border-radius: 0;
            z-index: 99;
            bottom: 78px;
            left: 0;
        }
    }

    }
    .tingle-modal {
        backdrop-filter: none;
    }

    .tingle-modal {
        z-index: 1100;
    }
</style>

<?php include(APPPATH . "n_views/ecommerce/common_style.php"); ?>

<div class="d-none"><?php echo $mercadopago_button; ?></div>
<div class="d-none"><?php echo $sslcommerz_button; ?></div>
