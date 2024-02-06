<style type="text/css" media="screen">
    #payment_options .list-group-item-action {
        margin-bottom: 30px;
    }

    #payment_options .list-group-item-action {
        margin-bottom: 30px;
    }

    #payment_options img {
        margin-right: 20px;
    }
</style>
<?php
require(APPPATH.'modules/n_theme/vendor/autoload.php');
use GeoIp2\Database\Reader;
$include_upload = 1;  //upload_js
$include_dropzone = 1;
$include_select2 = 1;

$payment_package_sorted = array();

foreach ($payment_package as $key => $value) {
    $payment_package_sorted[$value['id']] = $value;
}

if($n_config['dp_country_on']=='true'){
    $reader = new Reader(APPPATH.'modules/n_theme/db/GeoLite2-Country/GeoLite2-Country.mmdb');
    $record = $reader->country($_SERVER['REMOTE_ADDR']);

    $dp_country = $record->country->geonameId;
}else{
    $dp_country = 0;
}

if(!empty($this->session->userdata('razorpay_payment_amount'))){
    ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php

}
?>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url(); ?>payment/buy_package"><?php echo $this->lang->line("Payment"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $this->lang->line("Invoice Details"); ?></h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" data-bitwarden-watching="1">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_name"><?php echo $this->lang->line('Name'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="inv_name" class="form-control button_fnc" name="inv_name" placeholder="<?php echo $this->lang->line('Name'); ?>" value="<?php echo (isset($user_invoice['inv_name']) ? $user_invoice['inv_name'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_bus_name"><?php echo $this->lang->line('Business Name (optional)'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="inv_bus_name" class="form-control button_fnc" name="inv_bus_name" placeholder="<?php echo $this->lang->line('Business Name'); ?>" value="<?php echo (isset($user_invoice['inv_bus_name']) ? $user_invoice['inv_bus_name'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class='bx bxs-business'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_vat_number"><?php echo $this->lang->line('VAT Number (optional)'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="inv_vat_number" class="form-control button_fnc" name="inv_vat_number" placeholder="<?php echo $this->lang->line('VAT Number (optional)'); ?>" value="<?php echo (isset($user_invoice['inv_vat_number']) ? $user_invoice['inv_vat_number'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class='bx bx-coin'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_country"><?php echo $this->lang->line("Country"); ?></label>
                                        <select name='inv_country' id='inv_country' class='select2 form-control button_fnc'>
                                            <?php
                                            foreach ($country_list as $key => $value) {
                                                if($key==0){continue;}
                                                $selected_curr = '';
                                                if(isset($user_invoice['inv_country']) and  $user_invoice['inv_country'] == $key) {$selected_curr = "selected='selected'";}else{
                                                    if (isset($dp_country) and  $dp_country == $key) {$selected_curr = "selected='selected'";}
                                                }
                                                $value = str_replace(' IN_EU', '', $value);
                                                echo '<option value="' . $key . '" ' . $selected_curr . ' >' . $value  . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('country_restriction'); ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_street"><?php echo $this->lang->line('Street'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="inv_street" class="form-control button_fnc" name="inv_street" placeholder="<?php echo $this->lang->line('Street'); ?>" value="<?php echo (isset($user_invoice['inv_street']) ? $user_invoice['inv_street'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class='bx bxs-buildings' ></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_postcode"><?php echo $this->lang->line('Postcode'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="inv_postcode" class="form-control button_fnc" name="inv_postcode" placeholder="<?php echo $this->lang->line('Postcode'); ?>" value="<?php echo (isset($user_invoice['inv_postcode']) ? $user_invoice['inv_postcode'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class='bx bx-barcode' ></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_city"><?php echo $this->lang->line('City'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="text" id="inv_city" class="form-control button_fnc" name="inv_city" placeholder="<?php echo $this->lang->line('City'); ?>" value="<?php echo (isset($user_invoice['inv_city']) ? $user_invoice['inv_city'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class='bx bxs-city' ></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_email"><?php echo $this->lang->line('Email'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="email" id="inv_email" class="form-control button_fnc" name="inv_email" placeholder="<?php echo $this->lang->line('Email'); ?>" value="<?php echo (isset($user_invoice['inv_email']) ? $user_invoice['inv_email'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-mail-send"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inv_mobile"><?php echo $this->lang->line('Mobile'); ?></label>
                                        <div class="position-relative has-icon-left">
                                            <input type="number" id="inv_mobile" class="form-control button_fnc" name="inv_mobile" placeholder="<?php echo $this->lang->line('Mobile'); ?>" value="<?php echo (isset($user_invoice['inv_mobile']) ? $user_invoice['inv_mobile'] : '' ); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-mobile"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card" id="summary_cart">

                <?php

                $pack_det = $payment_package_sorted[$package_id];
                $pack_det['return_json'] = json_decode($pack_det['return_json'],true);
?>

                <div class="card-header ">
                    <h4 class="font-weight-normal col-12"><?php echo $this->lang->line('Package'); ?>: <?php echo $pack_det['return_json']['ps']['package_name']; ?></h4>
                </div>
                <div class="card-body p-0">
                    <div class="scrollit mb-2 p-1"
                         style="height: 450px;  position: relative; overflow: auto;">
                        <ul class="list-unstyled" id="pricing-details">
                            <?php foreach($pack_det['return_json']['details'] as $k => $v){

                                echo '<li><strong class="font-small-5">'.$v['title'].'</strong><br />';

                                foreach($v['sliders'] as $k2 => $v2){

                                    if($v2['is_unlimited'] == 1){
                                       $price_period_1 = $this->lang->line('Unlimited');
                                       $price_period_2 = $this->lang->line('Unlimited');
                                    }else{
                                        if(isset($pack_det['return_json']['ps']['fixed_price'])){
                                            $price_period_1 = $v2['selected_val'];
                                            $price_period_2 = $v2['selected_val'];
                                        }else{
                                            $price_period_1 = $v2['selected_val'].' * '.$v2['price_unit_period_1'].' '.$pack_det['return_json']['currency'];
                                            $price_period_2 = $v2['selected_val'].' * '.$v2['price_unit_period_2'].' '.$pack_det['return_json']['currency'];
                                        }
                                    }

                                    if(isset($pack_det['return_json']['ps']['fixed_price'])){
                                        echo '<span class="font-small-4">'.$v2['lang_title'].'</span>'.
                                            '<br />'.
                                            '<span class="font-small-3 price_period_1_show">'.$price_period_1.'</span>'.
                                            '<span class="font-small-3 price_period_2_show" style="display:none;">'.$price_period_2.'</span>'.
                                            '<br />';
                                    }else{
                                        echo '<span class="font-small-4">'.$v2['lang_title'].'</span>'.
                                            '<br />'.
                                            '<span class="font-small-3 price_period_1_show">'.$price_period_1.'</span>'.
                                            '<strong class="font-small-4 price_period_1_show float-right">'.$v2['total_price_period_1'].' '.$pack_det['return_json']['currency'].'</strong>'.
                                            '<span class="font-small-3 price_period_2_show" style="display:none;">'.$price_period_2.'</span>'.
                                            '<strong class="font-small-4 price_period_2_show float-right" style="display:none;">'.$v2['total_price_period_2'].' '.$pack_det['return_json']['currency'].'</strong><br />';
                                    }
                                }
                                echo '</li>';

                            } ?>

                        </ul>
                        <ul class="list-unstyled" id="free-details">
                            <?php
                            if(!empty($pack_det['return_json']['free_tools'])){
                                echo '<hr><li><strong class="font-small-5">'.$this->lang->line('You get also for free:').'</strong></li>';

                                foreach($pack_det['return_json']['free_tools'] as $k => $v){

                                    echo '<li><strong class="font-small-5">'.$v['title'].'</strong><br />';

                                    foreach($v['sliders'] as $k2 => $v2){

                                        echo '<span class="font-small-4">'.$v2['lang_title'].'</span><br />';

                                    }
                                    echo '</li>';

                                }
                            }
                        ?>
                        </ul>
                    </div>
                    <hr />
                    <div class="pl-1 pr-1">
                        <ul class="list-unstyled pricing-summary">
                            <li>
                                <strong class="font-medium-1"><?php echo $this->lang->line('Summary'); ?></strong>
                            </li>

                            <li class="font-small-4" id="show_coupon" style="display:none;">
                                <?php
                                echo $this->lang->line('Discount coupon'); ?>
                                <span class=" pr-1" style="position: absolute;
    right: 0;" id="summary_total_price_1">- <span id="coupon_value_fixed"></span> <?php echo $pack_det['return_json']['currency']; ?></span>
                            </li>

                            <li class="font-small-4" id="show_vat" style="display:none;">
                                <?php
                                echo $this->lang->line('VAT'); ?> (<span id="vat_value"></span>%)
                                <span class=" pr-1" style="position: absolute;
    right: 0;" id="summary_total_price_1"><span id="vat_value_fixed"></span> <?php echo $pack_det['return_json']['currency']; ?></span>
                            </li>

                            <li class="font-bold">
                                <?php
                                $period_type = $pack_det[ 'return_json']['ps']['period_type'];

                                echo '<strong>'.$this->lang->line('Total'); ?> (<span id="period_1_summary"><?php echo $pack_det[ 'return_json']['summary']['period_'.$period_type.'_name']; ?></span>)</strong>
                                <strong class="font-medium-1 pr-1" style="position: absolute;
    right: 0;" id="summary_total_price_1"><span id="new_price_vat_update"><?php echo $pack_det[ 'return_json']['summary']['total_price_'.$period_type]; ?></span> <?php echo $pack_det['return_json']['currency']; ?></strong>
                            </li>

                        </ul>

                        <?php if($n_config['dp_coupons_show']=='true'){ ?>
                        <a href="#" id="show_field_coupon"><?php echo $this->lang->line('Click here to apply coupon code'); ?></a>
                        <div class="row" id="coupon_field" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="coupon_code"><?php echo $this->lang->line('Discount coupon'); ?></label>
                                    <div class="position-relative">
                                        <input type="text" id="coupon_code" class="form-control" name="coupon_code" placeholder="<?php echo $this->lang->line('Discount coupon'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary btn-small" id="apply_coupon"><?php echo $this->lang->line('Apply'); ?></button>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
<hr />
                    <div class="row pl-1 pr-1" id="coupon_activate_packge_div" style="display: none;">
                        <div class="col-12">
                            <a href="#" id="coupon_activate_packge"
                               class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 align-items-center">
                                    <h6 class="mb-1"><?php echo $this->lang->line("Activate package"); ?></h6>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="pl-1 pr-1" id="payment_options">
                        <p><strong class="font-medium-1"><?php echo $this->lang->line('Select payment method: '); ?></strong></p>
                        <?php echo $buttons_html; ?>

                        <div class="row">

                            <?php
                            if ($n_config['omise_on'] == 'true' AND isset($pms['omise_on'])) { ?>
                                <div class="col-12">
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start"
                                       id="omise-button">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img class="rounded" width="60" height="60"
                                                                           src="https://cdn.omise.co/assets/dashboard/images/omise-logo.png"></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line('Pay with Omise'); ?></h6>
                                        </div>
                                    </a>
                                    <form name="checkoutForm" method="POST"
                                          action="<?php echo base_url('n_omise/charge/' . $package_id); ?>" class="d-none">
                                        <p>
                                            <button type="submit" id="omise-checkout-button-1"><?php echo $this->lang->line('Pay with Omise'); ?></button>
                                        </p>
                                    </form>
                                </div>
                            <?php } ?>


                            <?php
                            if ($n_config['n_tap_on'] == 'true' AND isset($pms['n_tap_on'])) { ?>
                                <div class="col-12">
                                    <a href="<?php echo base_url('n_tap/payment_button/' . $package_id); ?>" class="list-group-item list-group-item-action flex-column align-items-start"
                                       id="tap-button">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img class="rounded" width="60" height="60"
                                                                           src="https://websiteimages.b-cdn.net/tap_logo.svg"></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line('Pay with tap'); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php
                            //and $payment_package_sorted[$package_id]['currency'] == PHP
                            if ($n_config['n_paymongo_gateway_enabled'] == 'true' and $payment_package_sorted[$package_id]['price'] >= 100 AND isset($pms['n_paymongo_gateway_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#"
                                       class="list-group-item list-group-item-action flex-column align-items-start paymongo_pay_card">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img class="rounded" style="padding: 10px; width: 100%;"
                                                                           height="60"
                                                                           src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/6041194a54fc8f4dfc8730bd_Paymongo_Final_Main_Logo_2020_RGB_green_horizontal.svg"></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Paymongo (Card)"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_paymongo_gateway_gcash_enabled'] == 'true' and $payment_package_sorted[$package_id]['price'] >= 100 AND isset($pms['n_paymongo_gateway_gcash_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="<?php echo base_url('n_paymongo/n_payment_button_another.' . $package_id . '/gcash'); ?>"
                                       class="list-group-item list-group-item-action flex-column align-items-start paymongo_pay_card">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img class="rounded" style="padding: 10px;" height="60"
                                                                           src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/61813aa32092e2e51bb79638_gcash.png"></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with GCash"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_paymongo_gateway_paymaya_enabled'] == 'true' and $payment_package_sorted[$package_id]['price'] >= 100 AND isset($pms['n_paymongo_gateway_paymaya_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="<?php echo base_url('n_paymongo/n_payment_button_paymaya/' . $package_id); ?>"
                                       class="list-group-item list-group-item-action flex-column align-items-start paymongo_pay_card">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img class="rounded" style="padding: 10px;" height="60"
                                                                           src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/61813aa32092e23be8b79637_PayMaya.svg"></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with PayMaya"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_paymongo_gateway_grab_enabled'] == 'true' and $payment_package_sorted[$package_id]['price'] >= 100 AND isset($pms['n_paymongo_gateway_grab_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="<?php echo base_url('n_paymongo/n_payment_button_another.' . $package_id . '/grab_pay'); ?>"
                                       class="list-group-item list-group-item-action flex-column align-items-start paymongo_pay_card">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img class="rounded" style="padding: 10px;" height="60"
                                                                           src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/61813aa32092e2ae96b79636_GrabPay.svg"></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Grab Pay"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_paymentwall_enabled'] == 'true' AND isset($pms['n_paymentwall_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="<?php echo base_url('n_paymentwall/n_payment_button/' . $package_id); ?>"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <svg style="width:60px; padding: 10px;" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 315 41">
                                                    <defs></defs>
                                                    <path d="M85 10.6C85 8.4 83.5 7 81.5 7h-5.8v7h5.8c2 .1 3.5-1.3 3.5-3.4M67.5 31.7V0h15c6.7 0 10.3 4.8 10.3 10.6 0 5.7-3.6 10.5-10.3 10.5h-6.8v10.6h-8.2zm39.5-6v-2c-.8-1-2.3-1.6-3.8-1.6-1.8 0-3.4.9-3.4 2.7 0 1.8 1.6 2.7 3.4 2.7 1.5-.2 2.9-.7 3.8-1.8m0 6v-2.4c-1.6 1.7-3.9 2.8-6.7 2.8-3.3 0-7.4-2.4-7.4-7.6 0-5.6 4.1-7.4 7.4-7.4 2.8 0 5 1 6.7 2.7V17c0-2-1.6-3.3-4.3-3.3-2.1 0-4.4.9-6.1 2.4l-2.4-4.6c2.8-2.5 6.3-3.6 9.6-3.6 5.2 0 9.9 2 9.9 9.2v14.5l-6.7.1zm10.3 2.4c.5.3 1.2.4 1.7.4 1.6 0 2.5-.4 2.9-1.3l.5-1.1L113.6 9l7.2-.1 5 14.5 4.7-14.6 7.2-.1-9.4 26.2c-1.7 4.9-4.9 5.9-9 6.1-.6 0-2.2-.1-2.9-.4l.9-6.5zm48.9-2.4V17.6c0-1.8-.7-3.1-2.8-3.1-1.9 0-3 1.3-3.8 2.2v15h-7.4V17.6c0-1.8-.7-3.1-2.8-3.1-1.8 0-3 1.3-3.8 2.2v15H139V8.8h6.6v2.6c1.6-1.3 3.8-3.4 7.2-3.4 3.1 0 5.3 1.4 6.2 4.1 1.2-2 4-4.1 7.4-4.1 4 0 6.4 2.2 6.4 6.9v16.8h-6.6zm20.5-18c-3 0-4.1 2.2-4.4 3.9h8.8c-.2-1.8-1.3-3.9-4.4-3.9m-11.5 6.4c0-6.7 4.7-12 11.4-12 6.4 0 10.9 5 10.9 12.8V22h-15.2c.4 2.6 2.3 4.3 5.4 4.3 1.5 0 4.1-.6 5.3-1.9l2.9 4.6c-2.1 2-5.7 3.1-9 3.1-6.6 0-11.7-4.6-11.7-12M214 31.7V18.3c0-2.8-1.2-3.8-3.4-3.8-2 0-3.2 1.2-4 2.2v15H200V8.8h6.6v2.6c1.6-1.6 4-3.4 7.6-3.4 4.9 0 7.3 3 7.3 7.3v16.4H214zm11.5-6.3V15h-3.3V8.8h3.3V2.6h7.4v6.2h4.1V15h-4.1v8.4c0 1.3.6 2.3 1.8 2.3.8 0 1.5-.3 1.7-.6l1.3 5.5c-.8.9-2.7 1.5-5.3 1.5-4.3 0-6.9-2.3-6.9-6.7m34.4 6.3l-4-14.2-4.1 14.2h-7.3l-6.4-22.9h7l3.5 14.1 4.2-14.1h6.1l4.2 14.1 3.5-14.1h7l-6.3 22.9zm27.4-6v-2c-.8-1-2.2-1.6-3.7-1.6-1.8 0-3.4.9-3.4 2.7 0 1.8 1.5 2.7 3.4 2.7 1.4-.2 2.8-.7 3.7-1.8m0 6v-2.4c-.8 1.7-3.8 2.8-6.6 2.8-3.3 0-7.3-2.4-7.3-7.6 0-5.6 4-7.4 7.3-7.4 2.8 0 5.8 1 6.6 2.7V17c0-2-1.5-3.3-4.3-3.3-2.1 0-4.3.9-6 2.4l-2.4-4.6c2.8-2.5 6.7-3.6 9.9-3.6 5.2 0 10.2 2 10.2 9.2v14.5l-7.4.1zM307.9 0h6.6v31.7h-6.6zM298 0h6.6v31.7H298z"></path>
                                                    <path fill="#ffc013"
                                                          d="M39.1 31.5l3.2-8.9h12l3.2 8.9zm-19.2 0l3.2-8.9h12.1l3.2 8.9zm9.6-11.3l3.2-8.8h11.9l3.2 8.8zm-19.3 0l3.2-8.8h12l3.2 8.8zM.6 31.5l3.2-8.9h12l3.2 8.9zM19.9 9.3L23.1.5h12l3.2 8.8z"></path>
                                                </svg>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Paymentwall"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_payu_latam_enabled'] == 'true' AND isset($pms['n_payu_latam_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="<?php echo base_url('n_payu_latam/n_payment_button/' . $package_id); ?>"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img style="width:60px; padding: 10px;"
                                                                           src="https://argentina.payu.com/wp-content/themes/global-website/assets/src/images/payu-logo.svg"/></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with PayU LATAM"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_coinbase_enabled'] == 'true' AND isset($pms['n_coinbase_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="<?php echo base_url('n_coinbase/n_payment_button/' . $package_id); ?>"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img style="width:60px; padding: 10px;"
                                                                           src="https://images.ctfassets.net/q5ulk4bp65r7/3TBS4oVkD1ghowTqVQJlqj/2dfd4ea3b623a7c0d8deb2ff445dee9e/Consumer_Wordmark.svg"/></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Coinbase"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_moamalat_enabled'] == 'true' AND isset($pms['n_moamalat_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_moamalat"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img style="width:60px; padding: 10px;"
                                                                           src="<?php echo base_url(); ?>n_assets/img/moamalat.jpg"/></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with MOAMALAT"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_sadad_enabled'] == 'true' AND isset($pms['n_sadad_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_sadad"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:60px; padding: 10px;" src="<?php echo base_url(); ?>n_assets/img/sadad.png"/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with SADAD"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_tdsp_enabled'] == 'true' AND isset($pms['n_tdsp_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_tdsp"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:60px; padding: 10px;"  src="https://store.pay.net.ly/media/t-lync.png"/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with t-lync"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_stripe_enabled'] == 'true' AND isset($pms['n_stripe_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_stripe"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:80px;" src="<?php echo base_url('n_assets/img/stripe_new.png'); ?>"/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Stripe Checkout"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php
                            if ($n_config['n_stripe_subscription_enabled'] == 'true'
                                AND ($payment_package_sorted[$package_id]['validity'] == 30 OR $payment_package_sorted[$package_id]['validity'] == 365) AND isset($pms['n_stripe_subscription_enabled'])
                            ) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_stripe_sub"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted"><img style="width:80px;"
                                                                           src="<?php echo base_url('n_assets/img/stripe_new.png'); ?>"/></small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Stripe Subscription"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                            $has_stripe_cust_id = 0;
                            $n_stripe_cust_id = 0;
                            ?>

                            <?php

                            $n_user = $this->basic->get_data("users",array("where"=>array("users.id"=>$this->session->userdata("user_id"))),"users.*");

                            if(!empty($n_user[0]['n_stripe_cust_id'])){
                                $n_stripe_cust_id = $n_user[0]['n_stripe_cust_id'];
                                $has_stripe_cust_id = 1;
                            }

                            if ($n_config['n_stripe_subscription_enabled'] == 'true'
                                AND $has_stripe_cust_id == 1 AND isset($pms['n_stripe_subscription_enabled'])
                            ) { ?>
                                <div class="col-12">
                                    <a href="#" id="stripe_manage"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:80px;" src="<?php echo base_url('n_assets/img/stripe_new.png'); ?>"/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Manage Subscription"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_mastercard_enabled'] == 'true' AND isset($pms['n_mastercard_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_mastercard"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:80px;" src="https://mtf.mastercard.co.za/content/dam/public/mastercardcom/mea/za/logos/mc-logo-52.svg"/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Mastercard"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php
                            if ($n_config['n_epayco_enabled'] == 'true' AND ($currency == 'USD' OR $currency == 'COP') AND isset($pms['n_epayco_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_epayco"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:80px;" src="<?php echo base_url(); ?>n_assets/img/Logo-EPAYCO---RGB-1.png"/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with ePayco"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php
                            //$currency = 'USD';
                            if ($n_config['n_epayco_subs_enabled'] == 'true' AND ($currency == 'USD' OR $currency == 'COP') AND isset($pms['n_epayco_subs_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_epayco_subs"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:80px;" src="<?php echo base_url(); ?>n_assets/img/Logo-EPAYCO---RGB-1.png"/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with ePayco Subscription"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php

                            if ($n_config['n_sellix_enabled'] == 'true' AND isset($pms['n_sellix_enabled'])) { ?>
                                <div class="d-none" id="n_sellix_hidden_button">
                                    <button
                                            data-sellix-product=""
                                            data-sellix-custom-user_id=""
                                            data-sellix-custom-insert_id=""

                                            type="submit"
                                            alt="Buy Now with sellix.io"
                                    ></button>
                                </div>


                                <div class="col-12">
                                    <a href="#" id="pay_sellix"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:80px;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJFYmVuZV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAzMzg2LjcgOTcwLjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMzODYuNyA5NzAuNzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiMxZjFmMWY7fQo8L3N0eWxlPgo8Zz4KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0yNjUuNywyNjYuOGwyNjMtODcuOEw1MTEsMjUzLjhjMjIuOCw1LjQsNDcuNiwxMi42LDc1LDIyLjRjNjAuOCwyMS43LDExNS45LDQ2LjksMTY1LjQsNzUuNWwxMDkuNC0yMzAuNQoJCWMtNTIuMS0zMy0xMTMuNS01OS41LTE4NC4zLTc5LjRjLTcwLjgtMjAtMTQxLjctMzAtMjEyLjktMzBjLTc4LjEsMC0xNDYuNywxMi4yLTIwNS44LDM2LjVjLTU5LjEsMjQuMy0xMDQuNiw1OS4zLTEzNi43LDEwNC44CgkJQzg5LDE5OC44LDcyLjksMjUyLDcyLjksMzEyLjdjMCw2Mi41LDE1LjYsMTEyLjQsNDYuOSwxNDkuOGMzMS4yLDM3LjMsNjguMyw2NC45LDExMS4zLDgyLjdjNDMsMTcuOCw5Ni42LDM0LjksMTYwLjgsNTEuNAoJCWMxNy4zLDQuMywzMi42LDguNCw0Ni45LDEyLjZsMTctNzEuOWwyMDQuMywxNjAuOWwtMjYyLjksODcuOGwxNC4xLTU5LjhjLTMzLjgtNi44LTcxLjEtMTgtMTEzLjEtMzUuMQoJCUMyMjguOCw2NjIuOCwxNzEsNjI4LjcsMTI1LDU4OC44TDEzLDgxNi43YzU5LjksNDYsMTMwLjksODIuMiwyMTMsMTA4LjdjODIsMjYuNSwxNjMuNCwzOS43LDI0NC4xLDM5LjcKCQljNzEuMiwwLDEzNS45LTEwLjksMTk0LjEtMzIuNmM1OC4yLTIxLjcsMTA0LjQtNTQuOSwxMzguNy05OS42YzM0LjMtNDQuNyw1MS41LTEwMCw1MS41LTE2NmMwLTY0LjMtMTYuMS0xMTYuMS00OC4yLTE1NS42CgkJYy0zMi4xLTM5LjUtNjkuNy02OC40LTExMi43LTg2LjZjLTQzLTE4LjItOTctMzYuNS0xNjIuMS01NC43Yy0xNi41LTQuNC0zMS04LjYtNDQuNy0xMi43TDQ3MCw0MjcuN0wyNjUuNywyNjYuOHoiLz4KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xMjMxLjksMzAzLjZjLTIwMy4xLDAtMzQyLjUsMTQ3LjEtMzQyLjUsMzI5LjVjMCwyMDcuMSwxNTMuNiwzMzAuOCwzNTAuMywzMzAuOAoJCWM5My43LDAsMjA1LjgtMjQuNywyNjguMy03OC4ybC05Ni40LTE0NC41Yy0zMS4yLDI3LjMtMTA5LjQsNDQuMy0xNDQuNiw0NC4zYy03Ni44LDAtMTIyLjQtMzkuMS0xMzUuNC03OS40aDQyNy4xdi00OC4yCgkJQzE1NTguOCw0MzYuNCwxNDE2LjgsMzAzLjYsMTIzMS45LDMwMy42eiBNMTEyOSw1NTcuNWM3LjgtMjguNiwzMS4yLTc1LjUsMTAyLjgtNzUuNWM3NS42LDAsOTcuNyw0OC4yLDEwNC4yLDc1LjVIMTEyOXoiLz4KCTxyZWN0IHg9IjE2MzkuNSIgeT0iNzkuNiIgY2xhc3M9InN0MCIgd2lkdGg9IjIzNC40IiBoZWlnaHQ9Ijg2OC42Ii8+Cgk8cmVjdCB4PSIyMDA0LjEiIHk9Ijc5LjYiIGNsYXNzPSJzdDAiIHdpZHRoPSIyMzQuNCIgaGVpZ2h0PSI4NjguNiIvPgoJPHJlY3QgeD0iMjM2OC44IiB5PSIzMTkuMiIgY2xhc3M9InN0MCIgd2lkdGg9IjIzNC40IiBoZWlnaHQ9IjYyOSIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTI0ODYsMTAuNmMtNzIuOSwwLTEzMS42LDU4LjYtMTMxLjYsMTMxLjVjMCw3Mi45LDU4LjYsMTMxLjYsMTMxLjYsMTMxLjZjNzIuOSwwLDEzMS41LTU4LjYsMTMxLjUtMTMxLjYKCQlDMjYxNy41LDY5LjIsMjU1OC45LDEwLjYsMjQ4NiwxMC42eiIvPgoJPHBvbHlnb24gY2xhc3M9InN0MCIgcG9pbnRzPSIzMTU1LjMsNjI1LjIgMzM0OCwzMTkuMiAzMDkxLjUsMzE5LjIgMzAwNi44LDQ2Ni40IDI5MjIuMiwzMTkuMiAyNjY1LjYsMzE5LjIgMjg1OC40LDYyNS4yIAoJCTI2NTIuNiw5NDguMiAyOTA3LjgsOTQ4LjIgMzAwOC4xLDc4MS41IDMxMDUuOCw5NDguMiAzMzYyLjMsOTQ4LjIgCSIvPgo8L2c+Cjwvc3ZnPgo="/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Sellix"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php

                            if ($n_config['n_sellix_subs_enabled'] == 'true' AND isset($pms['n_sellix_subs_enabled'])) { ?>
                                <div class="d-none" id="n_sellix_hidden_button_subs">
                                    <button
                                            data-sellix-product=""
                                            data-sellix-custom-user_id=""
                                            data-sellix-custom-insert_id=""

                                            type="submit"
                                            alt="Buy Now with sellix.io"
                                    ></button>
                                </div>
                                <div class="col-12">
                                    <a href="#" id="pay_sellix_subs"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted">
                                                <img style="width:80px;" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJFYmVuZV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAzMzg2LjcgOTcwLjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMzODYuNyA5NzAuNzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiMxZjFmMWY7fQo8L3N0eWxlPgo8Zz4KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0yNjUuNywyNjYuOGwyNjMtODcuOEw1MTEsMjUzLjhjMjIuOCw1LjQsNDcuNiwxMi42LDc1LDIyLjRjNjAuOCwyMS43LDExNS45LDQ2LjksMTY1LjQsNzUuNWwxMDkuNC0yMzAuNQoJCWMtNTIuMS0zMy0xMTMuNS01OS41LTE4NC4zLTc5LjRjLTcwLjgtMjAtMTQxLjctMzAtMjEyLjktMzBjLTc4LjEsMC0xNDYuNywxMi4yLTIwNS44LDM2LjVjLTU5LjEsMjQuMy0xMDQuNiw1OS4zLTEzNi43LDEwNC44CgkJQzg5LDE5OC44LDcyLjksMjUyLDcyLjksMzEyLjdjMCw2Mi41LDE1LjYsMTEyLjQsNDYuOSwxNDkuOGMzMS4yLDM3LjMsNjguMyw2NC45LDExMS4zLDgyLjdjNDMsMTcuOCw5Ni42LDM0LjksMTYwLjgsNTEuNAoJCWMxNy4zLDQuMywzMi42LDguNCw0Ni45LDEyLjZsMTctNzEuOWwyMDQuMywxNjAuOWwtMjYyLjksODcuOGwxNC4xLTU5LjhjLTMzLjgtNi44LTcxLjEtMTgtMTEzLjEtMzUuMQoJCUMyMjguOCw2NjIuOCwxNzEsNjI4LjcsMTI1LDU4OC44TDEzLDgxNi43YzU5LjksNDYsMTMwLjksODIuMiwyMTMsMTA4LjdjODIsMjYuNSwxNjMuNCwzOS43LDI0NC4xLDM5LjcKCQljNzEuMiwwLDEzNS45LTEwLjksMTk0LjEtMzIuNmM1OC4yLTIxLjcsMTA0LjQtNTQuOSwxMzguNy05OS42YzM0LjMtNDQuNyw1MS41LTEwMCw1MS41LTE2NmMwLTY0LjMtMTYuMS0xMTYuMS00OC4yLTE1NS42CgkJYy0zMi4xLTM5LjUtNjkuNy02OC40LTExMi43LTg2LjZjLTQzLTE4LjItOTctMzYuNS0xNjIuMS01NC43Yy0xNi41LTQuNC0zMS04LjYtNDQuNy0xMi43TDQ3MCw0MjcuN0wyNjUuNywyNjYuOHoiLz4KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xMjMxLjksMzAzLjZjLTIwMy4xLDAtMzQyLjUsMTQ3LjEtMzQyLjUsMzI5LjVjMCwyMDcuMSwxNTMuNiwzMzAuOCwzNTAuMywzMzAuOAoJCWM5My43LDAsMjA1LjgtMjQuNywyNjguMy03OC4ybC05Ni40LTE0NC41Yy0zMS4yLDI3LjMtMTA5LjQsNDQuMy0xNDQuNiw0NC4zYy03Ni44LDAtMTIyLjQtMzkuMS0xMzUuNC03OS40aDQyNy4xdi00OC4yCgkJQzE1NTguOCw0MzYuNCwxNDE2LjgsMzAzLjYsMTIzMS45LDMwMy42eiBNMTEyOSw1NTcuNWM3LjgtMjguNiwzMS4yLTc1LjUsMTAyLjgtNzUuNWM3NS42LDAsOTcuNyw0OC4yLDEwNC4yLDc1LjVIMTEyOXoiLz4KCTxyZWN0IHg9IjE2MzkuNSIgeT0iNzkuNiIgY2xhc3M9InN0MCIgd2lkdGg9IjIzNC40IiBoZWlnaHQ9Ijg2OC42Ii8+Cgk8cmVjdCB4PSIyMDA0LjEiIHk9Ijc5LjYiIGNsYXNzPSJzdDAiIHdpZHRoPSIyMzQuNCIgaGVpZ2h0PSI4NjguNiIvPgoJPHJlY3QgeD0iMjM2OC44IiB5PSIzMTkuMiIgY2xhc3M9InN0MCIgd2lkdGg9IjIzNC40IiBoZWlnaHQ9IjYyOSIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTI0ODYsMTAuNmMtNzIuOSwwLTEzMS42LDU4LjYtMTMxLjYsMTMxLjVjMCw3Mi45LDU4LjYsMTMxLjYsMTMxLjYsMTMxLjZjNzIuOSwwLDEzMS41LTU4LjYsMTMxLjUtMTMxLjYKCQlDMjYxNy41LDY5LjIsMjU1OC45LDEwLjYsMjQ4NiwxMC42eiIvPgoJPHBvbHlnb24gY2xhc3M9InN0MCIgcG9pbnRzPSIzMTU1LjMsNjI1LjIgMzM0OCwzMTkuMiAzMDkxLjUsMzE5LjIgMzAwNi44LDQ2Ni40IDI5MjIuMiwzMTkuMiAyNjY1LjYsMzE5LjIgMjg1OC40LDYyNS4yIAoJCTI2NTIuNiw5NDguMiAyOTA3LjgsOTQ4LjIgMzAwOC4xLDc4MS41IDMxMDUuOCw5NDguMiAzMzYyLjMsOTQ4LjIgCSIvPgo8L2c+Cjwvc3ZnPgo="/>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Sellix Subscription"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_chapa_enabled'] == 'true' AND isset($pms['n_chapa_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_chapa"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted" style="width:80px;     margin-right: 20px;">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 167 63" style="enable-background:new 0 0 167 63;" xml:space="preserve">
                                <style type="text/css">
                                    .st0 {
                                        opacity: 0.59;
                                        fill: #8DC63F;
                                        enable-background: new;
                                    }

                                    .st1 {
                                        opacity: 0.59;
                                        fill: #7DC242;
                                        enable-background: new;
                                    }

                                    .st2 {
                                        fill: #7DC242;
                                    }
                                </style>
                                                    <path class="st0" d="M11.8,26.2h23.5l0,0l0,0c0,3.6-2.9,6.5-6.5,6.5c0,0,0,0,0,0h-17c-1.8,0-3.3-1.5-3.3-3.3l0,0l0,0
                                C8.6,27.7,10,26.2,11.8,26.2L11.8,26.2L11.8,26.2z"></path>
                                                    <path class="st0" d="M35.1,17.6l-4.7,6.5h6.2c3.6,0,6.5-2.9,6.5-6.5c0,0,0,0,0,0H35.1z"></path>
                                                    <path class="st0" d="M22.4,24l4.6-6.4H11.9C16.3,17.6,20.4,20.1,22.4,24z"></path>
                                                    <path class="st2" d="M22.4,24.1l0-0.1l-0.1,0.1H22.4z"></path>
                                                    <path class="st2" d="M27.2,17.4L27,17.6L22.4,24l0,0.1h-0.1l-1.5,2.1l-4.9,6.7c-1.9,2.2-5.3,2.5-7.5,0.6S5.9,28.2,7.8,26
                                c1-1.1,2.4-1.8,3.9-1.9h10.7l0.1-0.1c-2-3.9-6.1-6.4-10.5-6.4l0,0h-0.7C4.6,18-0.4,23.6,0,30.1s6,11.5,12.5,11.1
                                c3.4-0.2,6.6-1.9,8.6-4.5l0.4-0.6l0,0l7.2-9.9l1.5-2.1l4.7-6.5l1.2-1.6C33.4,13.9,29.3,14.5,27.2,17.4z"></path>
                                                    <path class="st2" d="M81.3,21.5v2.4c0.6-0.6,1.2-1,2-1.3c0.8-0.3,1.7-0.5,2.5-0.5c4.6,0,6.9,2.7,6.9,8.1v11l0,0
                                c-3.1,0-5.7-2.6-5.7-5.7v-4.9c0.1-0.9-0.2-1.8-0.8-2.5c-0.6-0.6-1.3-0.9-2.1-0.8c-0.8,0-1.5,0.3-2.1,0.8c-0.6,0.7-0.8,1.6-0.8,2.5
                                v10.6l0,0c-3.2,0-5.7-2.5-5.7-5.7c0,0,0,0,0,0V15.8l0,0C78.7,15.7,81.3,18.3,81.3,21.5C81.3,21.5,81.3,21.5,81.3,21.5z"></path>
                                                    <path class="st2" d="M116.1,31.9c0-1.8,0.5-3.5,1.5-4.9c1-1.5,2.3-2.7,3.9-3.5c2.8-1.5,6.2-1.7,9.2-0.6c1.3,0.5,2.4,1.2,3.4,2.1
                                c1,0.9,1.8,2,2.3,3.1c0.6,1.2,0.8,2.6,0.8,3.9c0,1.3-0.3,2.7-0.9,3.9c-0.5,1.2-1.3,2.3-2.3,3.1c-1,0.9-2.1,1.6-3.4,2.1
                                c-2.6,0.9-5.4,0.9-7.9,0l-0.4-0.2l-0.4-0.2v7.6l0,0c-3.2,0-5.7-2.6-5.7-5.7L116.1,31.9z M121.8,32c0,0.8,0.2,1.6,0.7,2.3
                                c0.4,0.7,1,1.3,1.8,1.7c0.7,0.4,1.5,0.6,2.3,0.6c0.8,0,1.7-0.2,2.4-0.6c0.7-0.4,1.3-1,1.8-1.7c0.4-0.7,0.7-1.5,0.7-2.3
                                c0-1.3-0.5-2.5-1.4-3.3c-1.9-1.8-4.9-1.8-6.7,0C122.4,29.6,121.8,30.7,121.8,32L121.8,32z"></path>
                                                    <path class="st2" d="M148.6,22.1c-5.4,0-9.8,4.4-9.8,9.8s4.4,9.8,9.8,9.8c2.1,0,4.1-0.7,5.8-1.9c1,1.2,2.4,1.9,4,1.9v-9.8
                                C158.4,26.5,154,22.1,148.6,22.1z M148.6,36.6c-2.6,0-4.6-2.1-4.6-4.7c0-2.6,2.1-4.6,4.7-4.6c2.6,0,4.6,2.1,4.6,4.7c0,0,0,0,0,0
                                C153.2,34.5,151.1,36.6,148.6,36.6C148.6,36.6,148.6,36.6,148.6,36.6z"></path>
                                                    <path class="st2" d="M104.4,22.1c-5.4,0-9.8,4.4-9.8,9.8c0,5.4,4.4,9.8,9.8,9.8c2.1,0,4.1-0.7,5.8-1.9c1,1.2,2.4,1.9,4,1.9v-9.8
                                C114.2,26.5,109.8,22.1,104.4,22.1z M104.4,36.6c-2.6,0-4.7-2.1-4.7-4.6s2.1-4.7,4.6-4.7c2.6,0,4.7,2.1,4.7,4.6c0,0,0,0,0,0
                                C109,34.5,107,36.6,104.4,36.6z"></path>
                                                    <path class="st2" d="M64.7,35.8c-3.9,0-7-3.2-7-7c0-3.9,3.2-7,7-7c1.9,0,3.6,0.8,4.9,2.1l4.1-4c-4.9-5-13-5.1-18-0.2s-5.1,13-0.2,18
                                s13,5.1,18,0.2c0,0,0.1-0.1,0.1-0.1l-4-4C68.4,35.1,66.6,35.8,64.7,35.8z"></path>
                            </svg>
                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with Chapa"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if ($n_config['n_zaincash_enabled'] == 'true' AND isset($pms['n_zaincash_enabled'])) { ?>
                                <div class="col-12">
                                    <a href="#" id="pay_zaincash"
                                       class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 align-items-center">
                                            <small class="text-muted" style="width:80px;     margin-right: 20px;">


                                                <svg xmlns="http://www.w3.org/2000/svg" width="92.5" height="37" viewBox="0 0 92.5 37">
                                                    <g id="ZainCash_Logo" data-name="ZainCash Logo" transform="translate(-2.105 -9.979)">
                                                        <g id="Group_3" data-name="Group 3" transform="translate(2.105 9.979)">
                                                            <g id="Group_1" data-name="Group 1" transform="translate(52.697 25.552)">
                                                                <path id="Path_2" data-name="Path 2" d="M50.77,35.495a3.052,3.052,0,0,0-1.167-.922,3.486,3.486,0,0,0-1.462-.322,3.917,3.917,0,0,0-1.669.347,3.832,3.832,0,0,0-1.278.947,4.358,4.358,0,0,0-.823,1.407,5.022,5.022,0,0,0-.292,1.729,4.7,4.7,0,0,0,.278,1.63,4.128,4.128,0,0,0,.8,1.355,3.733,3.733,0,0,0,1.278.922,4.116,4.116,0,0,0,1.707.339,3.376,3.376,0,0,0,1.647-.385,3.548,3.548,0,0,0,1.2-1.077l1.245.939a5.066,5.066,0,0,1-.43.485,4.366,4.366,0,0,1-.815.631,5.889,5.889,0,0,1-1.222.553,5.2,5.2,0,0,1-1.652.24,5.371,5.371,0,0,1-2.329-.493,5.707,5.707,0,0,1-3.268-5.135,6.357,6.357,0,0,1,.416-2.329,5.506,5.506,0,0,1,1.162-1.845A5.172,5.172,0,0,1,45.886,33.3a6.01,6.01,0,0,1,2.307-.43,5.617,5.617,0,0,1,2.115.416,3.952,3.952,0,0,1,1.7,1.278l-1.231.939Z" transform="translate(-42.516 -32.862)"/>
                                                                <path id="Path_3" data-name="Path 3" d="M54.837,33.072h1.338l4.659,10.89H59.11l-1.093-2.69H52.835l-1.077,2.69H50.035l4.8-10.89Zm2.646,6.905-2.029-5h-.03l-2.062,5h4.122Z" transform="translate(-39.922 -32.794)"/>
                                                                <path id="Path_4" data-name="Path 4" d="M59.67,41.756a2.444,2.444,0,0,0,1.021.884,3.051,3.051,0,0,0,1.283.284,2.618,2.618,0,0,0,.754-.116,2.277,2.277,0,0,0,.7-.347,1.889,1.889,0,0,0,.515-.57,1.526,1.526,0,0,0,.2-.785,1.172,1.172,0,0,0-.4-.961,3.472,3.472,0,0,0-.991-.553c-.394-.149-.826-.292-1.291-.43a5.214,5.214,0,0,1-1.291-.575,3.154,3.154,0,0,1-.991-.991,3.089,3.089,0,0,1-.4-1.685,2.857,2.857,0,0,1,.206-1.016,2.816,2.816,0,0,1,.653-.983,3.637,3.637,0,0,1,1.145-.746,4.24,4.24,0,0,1,1.685-.3,5.924,5.924,0,0,1,1.707.245,2.95,2.95,0,0,1,1.429,1l-1.2,1.093a1.986,1.986,0,0,0-.785-.691,2.5,2.5,0,0,0-1.154-.262,2.717,2.717,0,0,0-1.021.162,1.788,1.788,0,0,0-.653.416,1.452,1.452,0,0,0-.347.545,1.692,1.692,0,0,0-.1.54,1.365,1.365,0,0,0,.4,1.06,3.145,3.145,0,0,0,.991.6,12.084,12.084,0,0,0,1.291.416,5.572,5.572,0,0,1,1.291.515,3.011,3.011,0,0,1,.991.892,2.619,2.619,0,0,1,.4,1.545,3.242,3.242,0,0,1-.3,1.415,3.128,3.128,0,0,1-.807,1.06,3.6,3.6,0,0,1-1.2.661,4.628,4.628,0,0,1-1.476.231,5.408,5.408,0,0,1-1.985-.369A3.26,3.26,0,0,1,58.451,42.8l1.214-1.046Z" transform="translate(-37.018 -32.865)"/>
                                                                <path id="Path_5" data-name="Path 5" d="M65.475,33.072H66.95v4.521h5.644V33.072h1.476v10.89H72.595V38.978H66.95v4.984H65.475Z" transform="translate(-34.596 -32.794)"/>
                                                            </g>
                                                            <g id="Group_2" data-name="Group 2">
                                                                <path id="Path_6" data-name="Path 6" d="M67.554,37.019V22.673a3.233,3.233,0,0,0-.845-2.43,3.412,3.412,0,0,0-2.5-.916,1.946,1.946,0,0,0-.256.011V33.683a3.221,3.221,0,0,0,.845,2.425,3.421,3.421,0,0,0,2.489.919c.083,0,.179,0,.264-.008Zm.328-21.168a2.127,2.127,0,1,0-2.128,2.138,2.127,2.127,0,0,0,2.128-2.138ZM57.1,30.067v3.614a3.221,3.221,0,0,0,.845,2.425,3.434,3.434,0,0,0,2.495.919c.083,0,.179,0,.262-.008V29.308a10.044,10.044,0,0,0-2.508-7.286A9.374,9.374,0,0,0,51.2,19.208a9,9,0,0,0-9.3,9.286c0,5.253,3.527,8.6,8.1,8.6,3.527,0,5.644-2.1,5.644-4.566a5.11,5.11,0,0,0-.914-2.842C54.217,32.34,52.755,33.8,50.4,33.8c-2.514,0-4.725-1.909-4.725-5.393s2.216-5.766,5.537-5.766a5.517,5.517,0,0,1,4.009,1.578C56.411,25.4,57.1,27.2,57.1,30.064h0Zm28.1,2.213a.138.138,0,0,1-.11-.069c-2.583-3.371-7.324-9.581-8.354-10.936-1.088-1.418-1.938-1.884-3.064-1.884a2.631,2.631,0,0,0-1.966.8,3.474,3.474,0,0,0-.776,2.381V33.681a3.2,3.2,0,0,0,.845,2.425,3.327,3.327,0,0,0,2.434.919,1.611,1.611,0,0,0,.2-.008V24.276c0-.091.041-.143.1-.143s.074.019.11.074c1.514,1.975,7.263,9.507,8.365,10.922s1.936,1.893,3.053,1.893a2.631,2.631,0,0,0,1.969-.792,3.466,3.466,0,0,0,.779-2.381V22.736a3.272,3.272,0,0,0-.845-2.436,3.344,3.344,0,0,0-2.437-.913c-.072,0-.124,0-.2.006V32.138c0,.091-.044.138-.1.138h0Zm-56.628,1.33c-.143,0-.223-.047-.223-.143a.275.275,0,0,1,.121-.179c1.107-.9,8.42-6.809,9.535-7.727,1.938-1.564,2.346-2.328,2.346-3.44a2.343,2.343,0,0,0-.812-1.768,4.274,4.274,0,0,0-2.883-.77H24.2v.2a3.344,3.344,0,0,0,.46,1.813A3.179,3.179,0,0,0,27.4,22.734h8.177c.146,0,.223.044.223.119s-.036.108-.127.177c-1.156.941-7.908,6.4-9.593,7.747-1.944,1.564-2.332,2.342-2.332,3.451a2.339,2.339,0,0,0,.812,1.76,4.271,4.271,0,0,0,2.891.778H40.48v-.124a2.938,2.938,0,0,0-.815-2.229c-.636-.588-1.459-.8-3-.8H28.566Z" transform="translate(3.707 -13.726)"/>
                                                                <path id="Path_7" data-name="Path 7" d="M22.776,22.64A3.42,3.42,0,0,0,18.9,19.164c-4.835.372-5.457,5.882-2.31,6.232,3.29.37,4.469-3.117,4.532-3.313h0c.008.237.182,5.032-4.7,5.032a3.8,3.8,0,0,1-3.844-3.876c0-2.668,2.591-5.322,6.245-5.462a5.479,5.479,0,0,1,4.452,1.465c2.153,2.157,1.534,6.2-.209,8.2A8.523,8.523,0,0,1,12.8,29.788C9.172,28.16,7.875,23.448,10.07,19.5a10.228,10.228,0,0,1,8.78-4.682c6.4,0,9.642,4.544,9.059,9.885a15.047,15.047,0,0,1-4.078,8.3c-5.05,5.5-12.473,6.6-17.151,3.735a7.815,7.815,0,0,1-3.739-7.6,7.819,7.819,0,0,0,3.345,5.614,11.307,11.307,0,0,0,14.835-2.119c-4.642,3.476-10.069,3.424-13.775,1C3.946,31.427,3.013,27,4.676,22.615c-.834,3.906.507,7.529,3.455,9.416,4.6,2.941,11.292,1.25,15.512-3.487a8.8,8.8,0,0,0,2.236-5.78c-.044-3.313-2.349-6.287-7-6.287s-8.056,3.7-8.056,6.778a5.075,5.075,0,0,0,5.394,5.369c3.053,0,6.559-1.909,6.559-5.984Z" transform="translate(-2.896 -13.348)"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>

                                            </small>
                                            <h6 class="mb-1"><?php echo $this->lang->line("Pay with ZainCash"); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div id="button_place"></div>
                    <br>
                    <?php
                    if ($last_payment_method != '') {

                        $payment_type = ($has_reccuring == 'true') ? $this->lang->line('Recurring') : $this->lang->line('Manual');

                        echo '<br><div class="alert alert-light alert-has-icon">
                      <div class="alert-icon"><i class="bx bx-bulb"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">' . $this->lang->line("Last Payment") . '</div>
                        ' . $this->lang->line("Last Payment") . ' : ' . $last_payment_method . ' (' . $payment_type . ')
                      </div>
                    </div>';
                    } ?>



                    <div class="text-center">
                        <?php if ('yes' == $manual_payment): ?>
                            <button type="button" id="manual-payment-button"
                                    class="btn btn-outline-warning "><?php echo $this->lang->line('Manual Payment'); ?></button>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>






    <div class="card d-none" >
        <div class="card-header">
            <h4><i class="bx bx-cart"></i> <?php echo $this->lang->line("Payment Options"); ?></h4>
        </div>
        <div class="card-body">

<?php


if(!empty($pack_det["currency"])){
    $curency_icon = $pack_det["currency"];
}
 ?>

            <h5 class="mb-1"><i class="bx bx-info-circle"></i> <?php
                echo $this->lang->line('Order Package').': ';
                echo $pack_det['package_name']; ?></h5>
            <table class="table table-borderless mb-0 w-25">
                <tbody>
                <tr>
                    <td><?php echo $this->lang->line('Price'); ?>:</td>
                    <td> <?php echo $curency_icon; ?> <?php echo $pack_det["price"] ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('Days'); ?>:</td>
                    <td><?php echo $pack_det['validity']; ?></td>
                </tr>
                </tbody>
            </table>


        </div>
        <div class="card-footer">

        </div>
    </div>
</div>


<?php if ('yes' == $manual_payment): ?>
    <div class="modal fade" role="dialog" id="manual-payment-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bx-receipt"></i> <?php echo $this->lang->line("Manual payment"); ?></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">

                        <?php if (isset($manual_payment_instruction) && !empty($manual_payment_instruction)): ?>
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <!-- Manual payment instruction -->
                                    <h6 class="display-6"><i
                                                class="bx bx-bulb"></i> <?php echo $this->lang->line('Manual payment instructions'); ?>
                                    </h6>
                                    <?php echo $manual_payment_instruction; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Paid amount and currency -->
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="paid-amount"><i
                                                class="bx bx-receipt"></i> <?php echo $this->lang->line('Paid Amount'); ?>
                                        :</label>
                                    <input type="number" name="paid-amount" id="paid-amount" class="form-control"
                                           min="1">
                                    <input type="hidden" id="selected-package-id" value="<?php echo $package_id; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="paid-currency"><i
                                                class="bx bx-dollar-circle"></i> <?php echo $this->lang->line('Currency'); ?>
                                    </label>
                                    <?php echo form_dropdown('paid-currency', $currency_list, $currency, ['id' => 'paid-currency', 'class' => 'select2 form-control', 'style' => 'width:100%']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Image upload - Dropzone -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="bx bx-paperclip"></i> <?php echo $this->lang->line('Attachment'); ?> <?php echo $this->lang->line('(Max 5MB)'); ?>
                                    </label>
                                    <div id="manual-payment-dropzone" class="dropzone mb-1">
                                        <div class="dz-default dz-message">
                                            <input class="form-control" name="uploaded-file" id="uploaded-file"
                                                   type="hidden">
                                            <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                              style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                        </div>
                                    </div>
                                    <span class="text-danger">Allowed types: pdf, doc, txt, png, jpg and zip</span>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="paid-amount"><i
                                                class="bx bx-info-circle"></i> <?php echo $this->lang->line('Additional Info'); ?>
                                        :</label>
                                    &nbsp;
                                    <textarea name="additional-info" id="additional-info"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                    </div><!-- ends container -->
                </div><!-- ends modal-body -->

                <!-- Modal footer -->
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" id="manual-payment-submit" class="btn btn-primary"><span
                                class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash"></i>
                        <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

