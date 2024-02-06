<?php
$n_cart_items = count($product_list);

$coupon_code = $webhook_data_final['coupon_code'];
$coupon_type = $webhook_data_final['coupon_type'];
$coupon_amount = $webhook_data_final['discount'];

$subtotal = $webhook_data_final['subtotal'];
$shipping_cost = $webhook_data_final["shipping"];
$total_tax = $webhook_data_final["tax"];
$checkout_amount = $webhook_data_final['payment_amount'];

$is_store_pickup = isset($ecommerce_config['is_store_pickup']) ? $ecommerce_config['is_store_pickup'] : "0";
$is_home_delivery = isset($ecommerce_config['is_home_delivery']) ? $ecommerce_config['is_home_delivery'] : "1";

$is_order_schedule = isset($ecommerce_config['is_order_schedule']) ? $ecommerce_config['is_order_schedule'] : "0";
$delivery_time = $webhook_data_final['delivery_time'];
if ($delivery_time = '0000-00-00 00:00:00') $delivery_time = '';

$hide_both = '';
$hide_delivery_address = '';
$hide_store_pickup = '';
$check_store_pickup = '';

if ($is_store_pickup == '0' && $is_home_delivery == '0') {
    $hide_both = 'd-none';
} else if ($is_store_pickup == '0' && $is_home_delivery == '1') {
    $hide_store_pickup = 'd-none';
} else if ($is_store_pickup == '1' && $is_home_delivery == '0') {
    $hide_delivery_address = 'd-none';
    $check_store_pickup = 'checked';
} else if ($is_store_pickup == '1' && $is_home_delivery == '1') {
    if ($webhook_data_final['store_pickup'] == '1' || $pickup != '') {
        $check_store_pickup = 'checked';
        $hide_delivery_address = 'd-none';
    }
}
if ($webhook_data_final['store_type'] == 'digital') {
    $hide_store_pickup = 'd-none';
}

$current_url = current_url();
$current_url = mec_add_get_param($current_url, array("subscriber_id" => $subscriber_id));
if (isset($_GET['builder'])) {
    $current_url = $current_url . '&builder=1';
}

$wc_phone_bill = $webhook_data_final['phone_number'];
$buyerphone = !empty($webhook_data_final['buyer_mobile']) ? $webhook_data_final['buyer_mobile'] : $wc_phone_bill;

$order_no = $webhook_data_final['id'];
$order_url = _link("ecommerce/order/" . $order_no);

$order_schedule = isset($ecommerce_config['order_schedule']) ? $ecommerce_config['order_schedule'] : "any";
$order_schedule_html = $order_schedule_button = ''; //todo

$wc_first_name = $webhook_data_final['first_name'];
$wc_last_name = $webhook_data_final['last_name'];

$store_country = $webhook_data_final["store_country"];
$store_country_formatted = isset($country_names[$webhook_data_final["store_country"]]) ? ucwords(strtolower($country_names[$webhook_data_final["store_country"]])) : $webhook_data_final["store_country"];

$subtotal = mec_number_format($subtotal, $decimal_point, $thousand_comma);
$checkout_amount = mec_number_format($checkout_amount, $decimal_point, $thousand_comma);
$coupon_amount = mec_number_format($coupon_amount, $decimal_point, $thousand_comma);

$is_delivery_note = isset($ecommerce_config['is_delivery_note']) ? $ecommerce_config['is_delivery_note'] : "0";
$store_pickup_title = isset($ecommerce_config['store_pickup_title']) ? $ecommerce_config['store_pickup_title'] : "Store Pickup";

$store_name = $webhook_data_final['store_name'];
$store_address = "" . $webhook_data_final["store_address"] . ", " . $webhook_data_final["store_state"] . ", " . $webhook_data_final["store_city"] . ", " . $store_country_formatted . " " . $webhook_data_final["store_zip"] . " <br><i class='w-icon-envelop3'></i> " . $webhook_data_final['store_phone'] . ", " . $webhook_data_final['store_email'];

if (!empty($currency_left)) {
    $currency_left = $currency_left . ' ';
}
?>

<?php if ($n_cart_items == 0) : ?>
    <div class="invoice p-0 pt-2 shadow-none bg-light text-center pb-2">
        <div class="empty-state">
            <img class="img-fluid" style="height: 200px"
                 src="<?php echo base_url($n_eco_builder_config['empty_cart_image']); ?>" alt="image">
            <h2 class="mt-0"><?php echo $this->lang->line("Cart is empty"); ?></h2>
            <p class="lead"><?php echo $this->lang->line("There is no product added to cart. Please browse our store and add them to cart to continue."); ?></p>
            <?php
            $browse = _link('ecommerce/store/' . $js_store_unique_id);
            $browse = mec_add_get_param($browse, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
            ?>
            <a href="<?php echo $browse; ?>" class="btn btn-outline-primary mt-4"><i
                        class="w-icon-store"></i> <?php echo $this->lang->line("Browse Store"); ?></a>
        </div>
    </div>
<?php endif; ?>

<style>
    .button_checkout_hide{
        display: none!important;
    }
    .payment-accordion {
        border:0!important;
    }

    #search {
        margin-bottom:0;
    }
    table.order-table .product-name{
        white-space: normal;
    }
</style>
<?php if ($n_cart_items > 0) : ?>
    <!-- Start of Main -->
    <main class="main cart checkout">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                    <li><?php echo $l->line('Checkout'); ?></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">

                <form class="form checkout-form" action="#" method="post">
                    <div class="row mb-9">
                        <div class="col-lg-7 pr-lg-4 mb-4">
                            <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                <?php echo $l->line('Billing Details'); ?>
                            </h3>
                            <div class="row gutter-sm">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="firstname"><?php echo $this->lang->line('First name'); ?>*</label>
                                        <input type="text" class="form-control form-control-md" name="firstname" id="firstname"
                                               value="<?php echo $billing_ad['firstname']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="lastname"><?php echo $this->lang->line('Last name'); ?>*</label>
                                        <input type="text" class="form-control form-control-md" name="lastname" id="lastname"
                                               value="<?php echo $billing_ad['last_name']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <label for="company-name">Company name (optional)</label>
                                <input type="text" class="form-control form-control-md" name="company-name" id="company-name">
                            </div>
                            <div class="form-group">
                                <label for="country"><?php echo $this->lang->line('country'); ?>*</label>
                                <div class="select-box">
                                    <select id="country" name="country" class="form-control form-control-md select2">
                                    <?php echo $billing_ad['country_options']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="street">
                                    <?php echo $this->lang->line('Street address'); ?>*</label>
                                <input type="text" placeholder="<?php echo $this->lang->line('House number and street name'); ?>" value="<?php echo $billing_ad['street']; ?>" id="street"
                                       class="form-control form-control-md mb-2" name="street" required>
                            </div>
                            <div class="row gutter-sm">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">
                                            <?php echo $this->lang->line('Town / city'); ?></label>
                                        <input type="text" class="form-control form-control-md" name="city" value="<?php echo $billing_ad['city']; ?>" required id="city">
                                    </div>
                                    <div class="form-group">
                                        <label for="zip">
                                            <?php echo $this->lang->line('ZIP Code'); ?></label>
                                        <input type="text" class="form-control form-control-md" name="zip" id="zip"  value="<?php echo $billing_ad['zip']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state-new"><?php echo $this->lang->line('State'); ?>*</label>
                                        <div class="select-box">
                                            <select id="state-new" name="state-new" class="form-control form-control-md">
                                                <option value="<?php echo $billing_ad['state']; ?>" selected><?php echo $billing_ad['state']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"><?php echo $this->lang->line('Phone'); ?> *</label>
                                        <input type="text" class="form-control form-control-md" name="phone" id="phone" value="<?php echo $billing_ad['mobile']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-7">
                                <label for="email"><?php echo $this->lang->line('Email address'); ?>*</label>
                                <input type="email" class="form-control form-control-md" name="email" id="email" value="<?php echo $billing_ad['email']; ?>" required>
                            </div>
                            <div class="form-group checkbox-toggle pb-2">
                                <input type="checkbox" class="custom-checkbox" id="shipping-toggle" value="1"
                                       name="shipping-toggle">
                                <label for="shipping-toggle"><?php echo $this->lang->line('Ship to a different address?'); ?></label>
                            </div>
                            <div class="checkbox-content">


                                <?php if ($webhook_data_final['store_type'] == "physical") { ?>
                                    <label><?php echo $this->lang->line("Delivery address"); ?></label>
                                    <div class="text-small pt-1 text-muted <?php echo $hide_delivery_address; ?>"
                                         id="put_delivery_address_list"></div>
                                <?php } ?>


                                <div class="row gutter-sm">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="delivery_firstname"><?php echo $this->lang->line("First name"); ?>*</label>
                                            <input type="text" class="form-control form-control-md" name="delivery_firstname"
                                                   id="delivery_firstname" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="delivery_lastname"><?php echo $this->lang->line("Last name"); ?>*</label>
                                            <input type="text" class="form-control form-control-md" name="delivery_lastname"
                                                   id="delivery_lastname"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-none">
                                    <label for="delivery_company"><?php echo $this->lang->line("Company name (optional)"); ?></label>
                                    <input type="text" class="form-control form-control-md" name="delivery_company" id="delivery_company">
                                </div>
                                <div class="form-group">
                                    <label for="delivery_country"><?php echo $this->lang->line("Country"); ?>*</label>
                                    <div class="select-box">
                                        <select name="delivery_country" id="delivery_country" class="form-control form-control-md select2">
                                            <?php echo $billing_ad['country_options']; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="delivery_address"><?php echo $this->lang->line("Street address"); ?>*</label>
                                    <input type="text" placeholder="<?php echo $this->lang->line('House number and street name'); ?>"
                                           class="form-control form-control-md mb-2" name="delivery_address" id="delivery_address" required>
                                </div>
                                <div class="row gutter-sm">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="delivery_town"><?php echo $this->lang->line("City"); ?></label>
                                            <input type="text" class="form-control form-control-md" name="delivery_town" id="delivery_town"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="delivery_postcode"><?php echo $this->lang->line("Postcode"); ?></label>
                                            <input type="text" class="form-control form-control-md" name="delivery_postcode" id="delivery_postcode"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="delivery_state">
                                                <?php echo $this->lang->line('State'); ?> *</label>
                                            <input type="text" class="form-control form-control-md"  id="delivery_state" name="delivery_state" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="delivery_phone"><?php echo $this->lang->line('Phone'); ?> *</label>
                                            <input type="text" class="form-control form-control-md" name="delivery_phone" id="delivery_phone" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="delivery_email"><?php echo $this->lang->line('Email'); ?> *</label>
                                        <input type="text" class="form-control form-control-md" name="delivery_email" id="delivery_email" value="" required>
                                    </div>
                                </div>
                            </div>

                            <?php if ($n_eco_builder_config['show_show_delivery_note'] == 'always_show' or $n_eco_builder_config['show_show_delivery_note'] == 'show') { ?>
                                <div class="form-group mt-3">
                                    <label for="order-notes"><?php echo $n_eco_builder_config['text_show_delivery_note']; ?></label>
                                    <textarea id="delivery_note" class="form-control mb-0" id="order-notes"
                                              name="order-notes" cols="30"
                                              rows="4"
                                              placeholder="Notes about your order, e.g special notes for delivery"><?php echo $webhook_data_final["delivery_note"]; ?></textarea>
                                </div>
                            <?php } ?>

                            <?php
                            $browse = _link('ecommerce/store/' . $js_store_unique_id);
                            $browse = mec_add_get_param($browse, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                            ?>

                            <div class="coupon-toggle mt-6">
                                <?php echo $l->line('Have a coupon?'); ?> <a href="#"
                                                                             class="show-coupon font-weight-bold text-uppercase text-dark"><?php echo $l->line('Enter your code'); ?></a>
                            </div>
                            <div class="coupon-content mb-4">
                                <form class="coupon">
                                    <p><?php echo $l->line('If you have a coupon code, please apply it below.'); ?></p>
                                    <div class="input-wrapper-inline">
                                        <input type="text" id="coupon_code" name="coupon_code"
                                               class="form-control form-control-md mr-1 mb-2"
                                               placeholder="<?php echo $this->lang->line("Enter coupon code here..."); ?>"
                                               value="<?php echo $coupon_code; ?>"/>
                                        <button class="btn button btn-rounded btn-coupon mb-2"
                                                id="apply_coupon"><?php echo $this->lang->line("Apply Coupon"); ?></button>
                                    </div>
                                </form>
                            </div>

                            <div class="cart-action mb-6">
                                <a href="<?php echo $browse; ?>"
                                   class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i
                                            class="w-icon-long-arrow-left"></i><?php echo $l->line('Continue Shopping'); ?>
                                </a>

                            </div>
                        </div>
                        <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                            <div class="order-summary-wrapper sticky-sidebar">
                                <h3 class="title text-uppercase ls-10"><?php echo $l->line('Your Order'); ?></h3>
                                <div class="order-summary">
                                    <table class="order-table">
                                        <thead>
                                        <tr>
                                            <th colspan="2">
                                                <b><?php echo $l->line('Product'); ?></b>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $i = 0;
                                        foreach ($product_list

                                        as $key => $value) {

                                        $title = isset($value['product_name']) ? $value['product_name'] : "";
                                        $quantity = isset($value['quantity']) ? $value['quantity'] : 1;
                                        $price = isset($value['unit_price']) ? $value['unit_price'] : 0;
                                        $item_total = $price * $quantity;

                                        $item_total = mec_number_format($item_total, $decimal_point, $thousand_comma);
                                        $price = mec_number_format($price, $decimal_point, $thousand_comma);
                                        $image_url = (isset($value['thumbnail']) && !empty($value['thumbnail'])) ? base_url('upload/ecommerce/' . $value['thumbnail']) : base_url('assets/img/example-image.jpg');

                                        if (isset($value["woocommerce_product_id"]) && !is_null($value["woocommerce_product_id"]) && isset($value['thumbnail']) && !empty($value['thumbnail']))
                                            $image_url = $value["thumbnail"];
                                        $permalink = _link("ecommerce/product/" . $value['product_id']);
                                        $attribute_info = (is_array(json_decode($value["attribute_info"], true))) ? json_decode($value["attribute_info"], true) : array();

                                        $attribute_query_string_array = array();
                                        $attribute_query_string = "";
                                        foreach ($attribute_info as $key2 => $value2) {
                                            $urlencode = is_array($value2) ? implode(',', $value2) : $value2;
                                            $attribute_query_string_array[] = "option" . $key2 . "=" . urlencode($urlencode);
                                        }
                                        $attribute_query_string = implode("&", $attribute_query_string_array);
                                        if (!empty($attribute_query_string_array)) $attribute_query_string = "&quantity=" . $quantity . "&" . $attribute_query_string;

                                        $attribute_print = "";
                                        if (!empty($attribute_info)) {
                                            $attribute_print_tmp = array();
                                            foreach ($attribute_info as $key2 => $value2) {
                                                $attribute_print_tmp[] = is_array($value2) ? implode('+', array_values($value2)) : $value2;
                                            }
                                            $attribute_print = "(<small class='text-muted'>" . implode(', ', $attribute_print_tmp) . "</small>)";
                                        }
                                        // if($subscriber_id!='') $permalink.="?subscriber_id=".$subscriber_id.$attribute_query_string;

                                        if ($subscriber_id != '' || $pickup != "")
                                            $permalink = mec_add_get_param($permalink, array("subscriber_id" => $subscriber_id, "pickup" => $pickup)) . $attribute_query_string;


                                        $i++;
                                        $off = $value["coupon_info"];
                                        if ($off != "") $off = "(-" . $off . ")";


                                        ?>

                                        <tr class="bb-no">
                                            <td class="product-name"><?php echo $title; ?>
                                                <span><?php echo $attribute_print; ?></span> <i
                                                        class="fas fa-times"></i> <span
                                                        class="product-quantity"><?php echo $quantity; ?></span></td>
                                            <td class="product-total text-uppercase"><?php echo $currency_left . $item_total . $currency_right; ?></td>
                                        </tr>

                                        <tr>

                                            <?php //echo $off;
                                            ?>
                                            <?php } ?>


                                        <tr class="cart-subtotal bb-no">
                                            <td>
                                                <b><?php echo $this->lang->line("Subtotal"); ?></b>
                                            </td>
                                            <td>
                                                <b><?php echo $currency_left . $subtotal . $currency_right; ?></b>
                                            </td>
                                        </tr>

                                        <tr class="cart-subtotal bb-no <?php if ($coupon_code == '' && $coupon_type != "fixed cart") {
                                            echo 'd-none';
                                        } ?>">
                                            <td>
                                                <b><?php echo $this->lang->line("Discount"); ?></b>
                                            </td>
                                            <td>
                                                <b>-<?php echo $currency_left . mec_number_format($coupon_amount, $decimal_point, $thousand_comma) . $currency_right; ?></b>
                                            </td>
                                        </tr>

                                        <tr class="cart-subtotal bb-no">
                                            <td>
                                                <b><?php echo $this->lang->line("Tax"); ?></b>
                                            </td>
                                            <td>
                                                <b><?php echo $currency_left . mec_number_format($total_tax, $decimal_point, $thousand_comma) . $currency_right; ?></b>
                                            </td>
                                        </tr>


                                        </tbody>
                                        <tfoot>
                                        <tr class="shipping-methods">
                                            <td colspan="2" class="text-left">
                                                <h4 class="title title-simple bb-no mb-1 pb-0 pt-3"><?php echo $this->lang->line('Shipping methods'); ?>
                                                </h4>

                                                <p id="we_cant_delivery" style="display: none;">
                                                    <?php echo $this->lang->line("We cant delivery to this address"); ?>
                                                </p>

                                                <ul id="shipping-method" class="mb-4">

                                                    <?php
                                                    $hidden_code_new = '';
                                                    foreach($delivery_methods as $key => $val){
                                                        ?>

                                                        <?php if($val['special_type']=='pickup'){ ?>
                                                            <li class="" id="dm_payment_<?php echo $val['id']; ?>" style="display: none;">

                                                                <div class="custom-radio">
                                                                    <input type="radio"
                                                                           data-name="<?php echo $this->lang->line($val['name']); ?>" class="custom-control-input" data-cod="<?php echo $val['cod']; ?>" name="shipping"
                                                                           value="<?php echo $val['id']; ?>" id="store_pickup" />
                                                                    <label for="store_pickup" class=" custom-control-label color-dark"><?php echo $this->lang->line($val['name']);
                                                                        $val['default_price'] = '<span id="price_'.$val['id'].'">'.$val['default_price'].'</span>';
                                                                        echo ': '.$currency_left . $val['default_price'] . $currency_right;
                                                                    ?></label>
                                                                </div>


                                                                <div class="form-group">
                                                                    <select class="form-control" style="overflow-x: hidden;"
                                                                            name="pickup_point_details" id="pickup_point_details">
                                                                        <option value="<?php echo $this->lang->line("Counter") . " : " . $store_address; ?>"><?php echo $this->lang->line("Counter") . " : " . $store_address; ?></option>
                                                                        <?php
                                                                        foreach ($pickup_point_list as $key => $value) {
                                                                            $tmp = $value['point_name'] . ' : ' . $value['point_details'];
                                                                            $select_it = '';
                                                                            if ($pickup != "" && $pickup == $value['id']) $select_it = 'selected';
                                                                            else if ($webhook_data_final['pickup_point_details'] == $tmp) $select_it = 'selected';
                                                                            echo '<option value="' . $tmp . '" ' . $select_it . '>' . $tmp . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                            </li>
                                                       <?php continue; } ?>

                                                        <?php if($val['special_type']==''){
                                                            $mashkor = '';
                                                            $mashkor_class = '';
                                                            $mashkor_type = '';
                                                            $mashkor_price = '';
                                                            if(file_exists(APPPATH.'/modules/n_mashkar/controllers/N_mashkar.php')){

                                                                if(!empty($val['mashkor'])){
                                                                    $val['mashkor'] = json_decode($val['mashkor'],true);
                                                                    $mashkor = '<a class="btn btn-primary"  id="btn_mashkor_modal" href="#" style="display:none;">'.$this->lang->line('Edit location').'</a>';
                                                                    $mashkor_class = 'btn_click_mashkor';
                                                                    if($val['mashkor']['mashkor_cod_card']=='on'){
                                                                        $mashkor_type = 'data-type-mashkor="mashkor_cod_card"';
                                                                        $val['default_price'] = '...';
                                                                        $mashkor_price = 'class="mashkor_price_delivery"';
                                                                    }
                                                                    if($val['mashkor']['mashkor_online']=='on'){
                                                                        $mashkor_type = 'data-type-mashkor="mashkor_online"';
                                                                        $val['default_price'] = '...';
                                                                        $mashkor_price = 'class="mashkor_price_delivery"';
                                                                    }
                                                                    if($val['mashkor']['mashkor_cod_cash']=='on'){
                                                                        $mashkor_type = 'data-type-mashkor="mashkor_cod_cash"';
                                                                        $val['default_price'] = '...';
                                                                        $mashkor_price = 'class="mashkor_price_delivery"';
                                                                    }
                                                                }


                                                            }

                                                            ?>
                                                            <li id="dm_payment_<?php echo $val['id']; ?>" style="display: none;">
                                                                <div class="custom-radio delivery">
                                                                    <input type="radio" id="delivery_<?php echo $val['id']; ?>" data-cod="<?php echo $val['cod']; ?>" value="<?php echo $val['id']; ?>" <?php echo $mashkor_type; ?>
                                                                           data-name="<?php echo $this->lang->line($val['name']); ?>"
                                                                           class="custom-control-input <?php echo $mashkor_class; ?>" name="shipping">
                                                                    <label for="delivery_<?php echo $val['id']; ?>"
                                                                           class="custom-control-label color-dark">

                                                                        <?php

                                                                        echo $this->lang->line($val['name']);
                                                                        $val['default_price'] = '<span '.$mashkor_price.'  id="price_'.$val['id'].'">'.$val['default_price'].'</span>';
                                                                        echo ': '.$currency_left . $val['default_price'] . $currency_right;



                                                                        ?>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        <?php continue; } ?>



                                                     <?php } ?>




                                                </ul>

                                                <?php

                                                    if(!empty($mashkor)){
                                                        echo $mashkor;
                                                    }

                                                ?>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>
                                                <b><?php echo $this->lang->line("Delivery Charge"); ?></b>
                                            </th>
                                            <td>
                                                <b>
                                                    <?php echo $currency_left; ?>
                                                    <span id="delivery_price_summary">
                                                        <?php echo mec_number_format($shipping_cost, $decimal_point, $thousand_comma); ?>
                                                    </span>
                                                    <?php $currency_right; ?>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>
                                                <b><?php echo $this->lang->line("Total"); ?></b>
                                            </th>
                                            <td>
                                                <b>
                                                    <?php echo $currency_left; ?>
                                                    <span id="total_price_summary" data-base_price="<?php echo ($webhook_data_final['payment_amount']-$shipping_cost); ?>">
                                                        <?php echo $checkout_amount; ?>
                                                    </span>
                                                    <?php $currency_right; ?>
                                                </b>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <div class="payment-methods" id="payment_method">
                                        <h4 class="title font-weight-bold ls-25 pb-0 mb-1"><?php echo $this->lang->line('Payment Methods'); ?></h4>
                                        <div class="accordion payment-accordion">

                                                <?php
                                                //var_dump($pm);
                                                $hidden_code = '';
                                                $hidden_code_newaction = '';

                                                foreach($pm as $key => $val){
                                                    if(empty($val['modal'])){
                                                        $val['modal'] = 0;
                                                    }


                                                    if($val['action'] == 'redirect'){
                                                        $action_href = 'href="#'.$val['id'].'" action_href="'.$val['href'].'"';
                                                    }

                                                    if($val['action'] == 'onlick' OR $val['action'] == 'onclick'){
                                                        $action_href = 'href="#'.$val['id'].'" action_id="'.$val['action_id'].'" 

                                                        action_class="'.$val['action_class'].'"
                                                        action_modal="'.$val['modal'].'"
                                                        ';

                                                        if(isset($val['url_get_button'])){
                                                            $action_href .= 'data-get-button="'.$val['url_get_button'].'"';
                                                        }
                                                    }

                                                    $is_cod = '';
                                                    if(isset($val['cod']) AND $val['cod']=='1'){
                                                        $is_cod = 'cod';
                                                    }

                                                    echo '
                                            <div class="card '.$is_cod.'">

                                                <div class="card-header">
                                                    <a '.$action_href.' class="expand">'.$val['title'].'</a>
                                                </div>
                                                <div id="'.$val['id'].'"   class="card-body collapsed" style="display: none;">
                                                    <p class="mb-0">
                                                        '.$val['description'].'
                                                    </p>
                                                </div>
                                                
                                                </div> 
                                                ';

                                                    $hidden_code .= $val['hidden_code'];

                                                }
                                                ?>

                                        </div>
                                    </div>

                                    <?php if ($is_order_schedule == '1') { ?>
                                        <a href="#"
                                           class="choose_time_delivery font-weight-bold"><?php echo $this->lang->line("Choose delivery time"); ?></a>
                                        <div class="input-group pt-2 mb-5" id="choose_time_delivery" style="display: none">
                                            <input type="text" class="form-control" id="delivery_time" name="delivery_time"
                                                   style="height:50px;"
                                                   placeholder="<?php echo $this->lang->line("Set delivery time"); ?>"
                                                   value="<?php echo $delivery_time; ?>"/>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group place-order pt-6">
                                        <button id="new_proceed_checkout" class="btn btn-dark btn-block btn-rounded"><?php echo $this->lang->line('Place Order'); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>






            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
<?php endif; ?>



