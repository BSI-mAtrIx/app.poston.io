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

<?php if ($n_cart_items > 0) : ?>
    <!-- Start of Main -->
    <main class="main cart checkout">
        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                    <li><?php echo $l->line('Cart'); ?></li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <div class="page-content">
            <div class="container">


                <div class="row gutter-lg mb-10">
                    <div class="col-lg-8 pr-lg-4 mb-6">
                        <table class="shop-table cart-table">
                            <thead>
                            <tr>
                                <th class="product-name"><span><?php echo $l->line('Product'); ?></span></th>
                                <th></th>
                                <th class="product-price"><span><?php echo $l->line('Price'); ?></span></th>
                                <th class="product-quantity"><span><?php echo $l->line('Quantity'); ?></span></th>
                                <th class="product-subtotal"><span><?php echo $l->line('Subtotal'); ?></span></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $i = 0;
                            foreach ($product_list as $key => $value) {

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
                                    $attribute_print = "<small class='text-muted'>" . implode(', ', $attribute_print_tmp) . "</small>";
                                }
                                // if($subscriber_id!='') $permalink.="?subscriber_id=".$subscriber_id.$attribute_query_string;

                                if ($subscriber_id != '' || $pickup != "")
                                    $permalink = mec_add_get_param($permalink, array("subscriber_id" => $subscriber_id, "pickup" => $pickup)) . $attribute_query_string;


                                $i++;
                                $off = $value["coupon_info"];
                                if ($off != "") $off = "(-" . $off . ")";


                                ?>

                                <tr>
                                    <td class="product-thumbnail">
                                        <div class="p-relative">
                                            <a href="<?php echo $permalink; ?>">
                                                <figure>
                                                    <img src="<?php echo $image_url; ?>" alt="product"
                                                         width="300" height="338">
                                                </figure>
                                            </a>
                                            <button type="submit" class="btn btn-close delete_item"
                                                    data-id="<?php echo $value['id']; ?>"><i
                                                        class="w-icon-times-circle"></i></button>
                                        </div>
                                    </td>
                                    <td class="product-name">
                                        <a href="<?php echo $permalink; ?>">
                                            <?php echo $title; ?><br/>
                                            <span><?php echo $attribute_print; ?></span>
                                        </a>
                                    </td>
                                    <td class="product-price">
                                        <span class="text-primary text-small"><?php echo $off; ?></span>
                                        <span class="amount text-uppercase"><?php echo $currency_left . $price . $currency_right; ?></span>
                                    </td>
                                    <td class="product-quantity">
                                        <div class="input-group">
                                            <input class="quantity form-control" inputmode="numeric" type="number"
                                                   data-quantityInput="<?php echo $quantity; ?>"
                                                   value="<?php echo $quantity; ?>"
                                                   data-quantity="<?php echo $quantity; ?>"
                                                   data-id="<?php echo $value["id"]; ?>" data-action="add">
                                            <button class="quantity-plus w-icon-plus add_to_cart2"
                                                    data-quantity="<?php echo $quantity; ?>"
                                                    data-id="<?php echo $value["id"]; ?>" data-action="add"></button>
                                            <button class="quantity-minus w-icon-minus add_to_cart2"
                                                    data-quantity="<?php echo $quantity; ?>"
                                                    data-id="<?php echo $value["id"]; ?>" data-action="remove"></button>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount text-uppercase"><?php echo $currency_left . $item_total . $currency_right; ?></span>
                                    </td>
                                </tr>

                            <?php } ?>


                            </tbody>
                        </table>

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
                    <div class="col-lg-4 sticky-sidebar-wrapper">
                        <div class="sticky-sidebar">
                            <div class="cart-summary mb-4">
                                <h3 class="cart-title text-uppercase"><?php echo $this->lang->line("Price Details"); ?></h3>

                                <div class="cart-subtotal  align-items-center justify-content-between <?php if ($coupon_code == '' && $coupon_type != "fixed cart") {
                                    echo 'd-none';
                                } else {
                                    echo 'd-flex';
                                } ?>">
                                    <label class="ls-25"><?php echo $this->lang->line("Discount"); ?></label>
                                    <span class="text-uppercase">-<?php echo $currency_left . mec_number_format($coupon_amount, $decimal_point, $thousand_comma) . $currency_right; ?></span>
                                </div>

                                <div class="cart-subtotal  align-items-center justify-content-between d-flex">
                                    <label class="ls-25"><?php echo $this->lang->line("Subtotal"); ?></label>
                                    <span class="text-uppercase"><?php echo $currency_left . $subtotal . $currency_right; ?></span>
                                </div>

                                <div class="cart-subtotal d-none align-items-center justify-content-between d-flex">
                                    <label class="ls-25"><?php echo $this->lang->line("Delivery Charge"); ?></label>
                                    <span class="">
                                        <?php
                                        //echo $currency_left . mec_number_format($shipping_cost, $decimal_point, $thousand_comma) . $currency_right;
                                        echo '<span class="font-size-sm">'.$this->lang->line('Depend by delivery').'</span>';
                                        ?>
                                    </span>
                                </div>

                                <div class="cart-subtotal  align-items-center justify-content-between d-flex">
                                    <label class="ls-25"><?php echo $this->lang->line("Tax"); ?></label>
                                    <span class="text-uppercase"><?php echo $currency_left . mec_number_format($total_tax, $decimal_point, $thousand_comma) . $currency_right; ?></span>
                                </div>


                                <hr class="divider">
                                <div class="d-none <?php echo $hide_store_pickup; ?>">
                                    <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                                        <input type="checkbox" class="custom-checkbox" name="custom-switch-checkbox"
                                               id="store_pickup" <?php echo $check_store_pickup; ?>/>
                                        <label for="store_pickup"
                                               class="font-size-md"><?php echo $this->lang->line($store_pickup_title); ?></label>
                                    </div>

                                    <div class="form-group d-none <?php echo $hide_store_pickup; ?>">
                                        <select class="form-control <?php if ($check_store_pickup == '') echo 'd-none'; ?>"
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
                                </div>

                                <div class="price-details">

                                    <p><a class="text-dark d-none" id="showProfile" href="#"><i
                                                    class="w-icon-map-marker"></i> <?php echo $this->lang->line("Billing Address"); ?>
                                        </a></p>
                                    <?php if ($webhook_data_final['store_type'] == "physical") { ?>
                                        <h6 class="d-none price-title"><?php echo $this->lang->line("Delivery address"); ?></h6>
                                        <p class="d-none">
                                            <span class="text-dark header-left"><?php echo $this->lang->line("Delivery to"); ?></span>
                                            <a class="header-right <?php echo $hide_delivery_address; ?>" data-close='1'
                                               id="new_address" href="#"><i
                                                        class="w-icon-plus"></i> <?php echo $this->lang->line("New address"); ?>
                                            </a></p>


                                        <div class="d-none text-small pt-1 text-muted <?php echo $hide_delivery_address; ?>"
                                             id="put_delivery_address_list"></div>
                                    <?php } ?>
                                </div>

                                <?php if ($is_order_schedule == '1') { ?>
                                    <hr class="d-none divider mb-6">
                                    <a href="#"
                                       class="d-none choose_time_delivery font-weight-bold"><?php echo $this->lang->line("Choose delivery time"); ?></a>
                                    <div class="input-group pt-2 mb-5" id="choose_time_delivery" style="display: none">
                                        <input type="text" class="form-control" id="delivery_time" name="delivery_time"
                                               style="height:50px;"
                                               placeholder="<?php echo $this->lang->line("Set delivery time"); ?>"
                                               value="<?php echo $delivery_time; ?>"/>
                                    </div>
                                <?php } ?>



                                <?php if ($n_eco_builder_config['show_show_delivery_note'] == 'show') { ?>
                                    <hr class="d-none divider mb-6">
                                    <a href="#"
                                       class="d-none show_delivery font-weight-bold"><?php echo $n_eco_builder_config['text_show_delivery_note']; ?></a>
                                    <div class="input-group pt-2 mb-5" id="show_delivery" style="display: none">
                                        <textarea class="form-control" id="delivery_note"
                                                  name="delivery_note"><?php echo $webhook_data_final["delivery_note"]; ?></textarea>
                                    </div>
                                <?php } ?>

                                <?php if ($n_eco_builder_config['show_show_delivery_note'] == 'always_show') { ?>
                                    <hr class="d-none divider mb-6">
                                    <h6 class="price-title"><?php echo $n_eco_builder_config['text_show_delivery_note']; ?></h6>
                                    <div class="d-none  input-group pt-2 mb-5" id="show_delivery">
                                        <textarea class="form-control" id="delivery_note"
                                                  name="delivery_note"><?php echo $webhook_data_final["delivery_note"]; ?></textarea>
                                    </div>
                                <?php } ?>


                                <hr class="divider mb-6">
                                <div class="order-total d-flex justify-content-between align-items-center">
                                    <label><?php echo $this->lang->line("Total"); ?></label>
                                    <span class="ls-50 text-uppercase"><?php echo $currency_left . $checkout_amount . $currency_right ?></span>
                                </div>
                                <a href="#" id="proceed_checkout_old" type="button"
                                   class="d-none btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout place-order btn-next">
                                    <?php echo $this->lang->line("Proceed Checkout"); ?><i
                                            class="w-icon-long-arrow-right"></i></a>

                                <?php
                                $checkout_url = 'ecommerce/checkout/' . $order_no;
                                $checkout_url = mec_add_get_param($checkout_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                                ?>
                                <a href="<?php e_link($checkout_url); ?>"
                                   class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout place-order btn-next">
                                    <?php echo $this->lang->line("ORDER SUMMARY"); ?><i
                                            class="w-icon-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
<?php endif; ?>



