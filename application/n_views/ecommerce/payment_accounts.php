<?php
//todo: 00000 need more changes
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;

?>
<?php

function _link($uri, $domain = '')
{
    $custom = false;
    if ($domain != '') {
        $domain = $domain . '/';
        $custom = true;
    }

    if ($custom == true) {
        if (strpos($uri, 'store') == false) {
            return 'https://' . $domain . str_replace('ecommerce/', '', $uri);
        } else {
            return 'https://' . $domain;
        }


    } else {
        return base_url($uri);
    }
}

$n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
    "custom_id" => $xdata2['id'],
    "user_id" => $this->user_id,
    'active' => 1
)
));

if (empty($n_cd_data)) {
    $custom_domain_set = '';
} else {
    if ($n_cd_data[0]['active'] == 1) {
        $custom_domain_set = $n_cd_data[0]['host_url'];
    } else {
        $custom_domain_set = '';
    }

}

?>
<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ecommerce"); ?>"><?php echo $this->lang->line("E-commerce"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
if ($this->session->flashdata('success_message') == 1)
    echo "<div class='alert alert-success text-center'><i class='bx bx-check-circle'></i> " . $this->lang->line("Your data has been successfully stored into the database.") . "</div><br>";
?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("ecommerce/payment_accounts_action"); ?>" method="POST">
                <input type="hidden" name="store_type" id="store_type" value="<?php echo $xdata2['store_type']; ?>">

                <div class="card shadow-none">
                    <div class="card-body p-0">

                        <div class="accordion" id="accordionWrapa1">
                            <div class="card collapse-header">
                                <div id="heading1" class="card-header" role="tablist" data-toggle="collapse"
                                     data-target="#accordion1"
                                     aria-expanded="false" aria-controls="accordion1">
                                    <span class="collapse-title"><?php echo $this->lang->line("Payment Integration"); ?></span>
                                </div>
                                <div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1"
                                     aria-labelledby="heading1" class="collapse">
                                    <div class="card-body p-0">

                                        <div class="card-body" style="border:1px solid #e4e6fc">

                                            <?php include(APPPATH.'n_views/ecommerce/payment_accounts_ul.php'); ?>

                                            <div class="tab-content">

                                                <div role="tabpanel" class="tab-pane active" id="PayPal" aria-labelledby="PayPal-tab" aria-expanded="true">
                                                    <div class="row">

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="paypal_email"><?php echo $this->lang->line("Paypal Email"); ?> </label>
                                                                <input name="paypal_email" id="paypal_email"
                                                                       value="<?php echo isset($xvalue['paypal_email']) ? $xvalue['paypal_email'] : ""; ?>"
                                                                       class="form-control" type="email">
                                                                <span class="text-danger"><?php echo form_error('paypal_email'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Paypal Sandbox Mode'); ?></label>
                                                                <br>
                                                                <?php
                                                                $paypal_mode = isset($xvalue['paypal_mode']) ? $xvalue['paypal_mode'] : "";
                                                                if ($paypal_mode == '') $paypal_mode = 'live';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="paypal_mode"
                                                                           id="paypal_mode" value="sandbox"
                                                                           class="custom-control-input" <?php if ($paypal_mode == 'sandbox') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="paypal_mode"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('paypal_mode'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Paypal Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $paypal_enabled = isset($xdata2['paypal_enabled']) ? $xdata2['paypal_enabled'] : "";
                                                                if ($paypal_enabled == '') $paypal_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="paypal_enabled"
                                                                           id="paypal_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($paypal_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="paypal_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('paypal_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="Stripe" role="tabpanel" aria-labelledby="Stripe-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="stripe_secret_key"> <?php echo $this->lang->line("Stripe Secret Key"); ?></label>
                                                                <input name="stripe_secret_key" id="stripe_secret_key"
                                                                       value="<?php echo isset($xvalue['stripe_secret_key']) ? $xvalue['stripe_secret_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('stripe_secret_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="stripe_publishable_key"><?php echo $this->lang->line("Stripe Publishable Key"); ?></label>
                                                                <input name="stripe_publishable_key" id="stripe_publishable_key"
                                                                       value="<?php echo isset($xvalue['stripe_publishable_key']) ? $xvalue['stripe_publishable_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('stripe_publishable_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Stripe billing address'); ?></label>
                                                                <br>
                                                                <?php
                                                                $stripe_billing_address = isset($xvalue['stripe_billing_address']) ? $xvalue['stripe_billing_address'] : "";
                                                                if ($stripe_billing_address == '') $stripe_billing_address = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="stripe_billing_address"
                                                                           id="stripe_billing_address" value="1"
                                                                           class="custom-control-input" <?php if ($stripe_billing_address == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="stripe_billing_address"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('stripe_billing_address'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Stripe Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $stripe_enabled = isset($xdata2['stripe_enabled']) ? $xdata2['stripe_enabled'] : "";
                                                                if ($stripe_enabled == '') $stripe_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="stripe_enabled"
                                                                           id="stripe_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($stripe_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="stripe_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('stripe_enabled'); ?></span>
                                                                </label>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="SenangPay" role="tabpanel" aria-labelledby="SenangPay-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <?php $red_url = _link('ecommerce/senangpay_action',$custom_domain_set); ?>
                                                                <small class="text-dark mt-2 d-block"><b><?php echo $this->lang->line('Senangpay return url :'); ?></b> <?php echo "<span class='badge badge-danger p-1 pl-2 pr-2 text-lowercase'>" . $red_url . "</span>"; ?>
                                                                    <a href="#" data-placement="top" data-toggle="popover"
                                                                       data-trigger="focus"
                                                                       title="<?php echo $this->lang->line("Senangpay return url"); ?>"
                                                                       data-content="<?php echo $this->lang->line("please put this redirect url in your senangpay profile`s return url field."); ?>"><i
                                                                                class='bx bx-info-circle'></i> <?php echo $this->lang->line("Details"); ?>
                                                                    </a></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="senangpay_merchent_id"><?php echo $this->lang->line("SenangPay Merchant Id"); ?></label>
                                                                <input name="senangpay_merchent_id" id="senangpay_merchent_id"
                                                                       value="<?php echo isset($xvalue['senangpay_merchent_id']) ? $xvalue['senangpay_merchent_id'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('senangpay_merchent_id'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="senangpay_secret_key"><?php echo $this->lang->line("SenangPay Secret Key"); ?></label>
                                                                <input name="senangpay_secret_key" id="senangpay_secret_key"
                                                                       value="<?php echo isset($xvalue['senangpay_secret_key']) ? $xvalue['senangpay_secret_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('senangpay_secret_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('SenangPay Sandbox Mode'); ?></label>
                                                                <br>
                                                                <?php
                                                                $senangpay_mode = isset($xvalue['senangpay_mode']) ? $xvalue['senangpay_mode'] : "";
                                                                if ($senangpay_mode == '') $senangpay_mode = 'live';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="senangpay_mode"
                                                                           id="senangpay_mode" value="sandbox"
                                                                           class="custom-control-input" <?php if ($senangpay_mode == 'sandbox') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="senangpay_mode"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('senangpay_mode'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Senangpay Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $senangpay_enabled = isset($xdata2['senangpay_enabled']) ? $xdata2['senangpay_enabled'] : "";
                                                                if ($senangpay_enabled == '') $senangpay_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="senangpay_enabled"
                                                                           id="senangpay_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($senangpay_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="senangpay_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('senangpay_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Instamojo" role="tabpanel" aria-labelledby="Instamojo-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="instamojo_api_key"><?php echo $this->lang->line("Instamojo Private Api Key"); ?></label>
                                                                <input name="instamojo_api_key" id="instamojo_api_key"
                                                                       value="<?php echo isset($xvalue['instamojo_api_key']) ? $xvalue['instamojo_api_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('instamojo_api_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="instamojo_auth_token"><?php echo $this->lang->line("Instamojo Private Auth Token"); ?></label>
                                                                <input name="instamojo_auth_token" id="instamojo_auth_token"
                                                                       value="<?php echo isset($xvalue['instamojo_auth_token']) ? $xvalue['instamojo_auth_token'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('instamojo_auth_token'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Instamojo Sandbox Mode'); ?></label>
                                                                <br>
                                                                <?php
                                                                $instamojo_mode = isset($xvalue['instamojo_mode']) ? $xvalue['instamojo_mode'] : "";
                                                                if ($instamojo_mode == '') $instamojo_mode = 'live';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="instamojo_mode"
                                                                           id="instamojo_mode" value="sandbox"
                                                                           class="custom-control-input" <?php if ($instamojo_mode == 'sandbox') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="instamojo_mode"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('instamojo_mode'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Instamojo Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $instamojo_enabled = isset($xdata2['instamojo_enabled']) ? $xdata2['instamojo_enabled'] : "";
                                                                if ($instamojo_enabled == '') $instamojo_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="instamojo_enabled"
                                                                           id="instamojo_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($instamojo_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="instamojo_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('instamojo_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Sslcommerz" role="tabpanel" aria-labelledby="Sslcommerz-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="sslcommerz_store_id"> <?php echo $this->lang->line("Sslcommerz Store ID"); ?></label>
                                                                <input name="sslcommerz_store_id" id="sslcommerz_store_id"
                                                                       value="<?php echo isset($xvalue['sslcommerz_store_id']) ? $xvalue['sslcommerz_store_id'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('sslcommerz_store_id'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="sslcommerz_store_password"><?php echo $this->lang->line("Sslcommerz Store Password"); ?></label>
                                                                <input name="sslcommerz_store_password" id="sslcommerz_store_password"
                                                                       value="<?php echo isset($xvalue['sslcommerz_store_password']) ? $xvalue['sslcommerz_store_password'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('sslcommerz_store_password'); ?></span>

                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Sslcommerz Sandbox Mode'); ?></label>
                                                                <br>
                                                                <?php
                                                                $sslcommerz_mode = isset($xvalue['sslcommerz_mode']) ? $xvalue['sslcommerz_mode'] : "";
                                                                if ($sslcommerz_mode == '') $sslcommerz_mode = 'live';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="sslcommerz_mode"
                                                                           id="sslcommerz_mode" value="sandbox"
                                                                           class="custom-control-input" <?php if ($sslcommerz_mode == 'sandbox') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="sslcommerz_mode"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('sslcommerz_mode'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Sslcommerz  Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $sslcommerz_enabled = isset($xdata2['sslcommerz_enabled']) ? $xdata2['sslcommerz_enabled'] : "";
                                                                if ($sslcommerz_enabled == '') $sslcommerz_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="sslcommerz_enabled"
                                                                           id="sslcommerz_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($sslcommerz_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="sslcommerz_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('sslcommerz_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="tab-pane " id="MercadoPago" role="tabpanel" aria-labelledby="MercadoPago-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="mercadopago_public_key"> <?php echo $this->lang->line("MercadoPago Public Key"); ?></label>
                                                                <input name="mercadopago_public_key" id="mercadopago_public_key"
                                                                       value="<?php echo isset($xvalue['mercadopago_public_key']) ? $xvalue['mercadopago_public_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('mercadopago_public_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="mercadopago_access_token"><?php echo $this->lang->line("Mercado Pago Acceess Token"); ?></label>
                                                                <input name="mercadopago_access_token" id="mercadopago_access_token"
                                                                       value="<?php echo isset($xvalue['mercadopago_access_token']) ? $xvalue['mercadopago_access_token'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('mercadopago_access_token'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for="marcadopago_country"><?php echo $this->lang->line("Mercadopago Country"); ?></label>
                                                                <select name='marcadopago_country' id='marcadopago_country'
                                                                        class='select2 form-control'
                                                                        style='width:100% !important;'>
                                                                    <?php
                                                                    foreach ($marcadopago_country as $key => $value) {
                                                                        if (isset($xvalue['marcadopago_country']) && $key == $xvalue['marcadopago_country']) $selected = 'selected';
                                                                        else $selected = '';
                                                                        echo '<option value="' . $key . '" ' . $selected . '> ' . $value . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <span class="text-danger"><?php echo form_error('country'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('MercadoPago  Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $mercadopago_enabled = isset($xdata2['mercadopago_enabled']) ? $xdata2['mercadopago_enabled'] : "";
                                                                if ($mercadopago_enabled == '') $mercadopago_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="mercadopago_enabled"
                                                                           id="mercadopago_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($mercadopago_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="mercadopago_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('mercadopago_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Mollie" role="tabpanel" aria-labelledby="Mollie-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="mollie_api_key"> <?php echo $this->lang->line("Mollie API Key"); ?></label>
                                                                <input name="mollie_api_key" id="mollie_api_key"
                                                                       value="<?php echo isset($xvalue['mollie_api_key']) ? $xvalue['mollie_api_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('mollie_api_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Mollie Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $mollie_enabled = isset($xdata2['mollie_enabled']) ? $xdata2['mollie_enabled'] : "";
                                                                if ($mollie_enabled == '') $mollie_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="mollie_enabled"
                                                                           id="mollie_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($mollie_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="mollie_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('mollie_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Xendit" role="tabpanel" aria-labelledby="Xendit-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="xendit_secret_api_key"><?php echo $this->lang->line("Xendit Secret Api Key"); ?></label>
                                                                <input name="xendit_secret_api_key" id="xendit_secret_api_key"
                                                                       value="<?php echo isset($xvalue['xendit_secret_api_key']) ? $xvalue['xendit_secret_api_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('xendit_secret_api_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Xendit Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $xendit_enabled = isset($xdata2['xendit_enabled']) ? $xdata2['xendit_enabled'] : "";
                                                                if ($xendit_enabled == '') $xendit_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="xendit_enabled"
                                                                           id="xendit_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($xendit_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="xendit_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('xendit_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Toyyibpay" role="tabpanel" aria-labelledby="Toyyibpay-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="toyyibpay_secret_key"><?php echo $this->lang->line("Toyyibpay Secret Key"); ?></label>
                                                                <input name="toyyibpay_secret_key" id="toyyibpay_secret_key"
                                                                       value="<?php echo isset($xvalue['toyyibpay_secret_key']) ? $xvalue['toyyibpay_secret_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('toyyibpay_secret_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="toyyibpay_category_code"><?php echo $this->lang->line("Toyyibpay Category code"); ?></label>
                                                                <input name="toyyibpay_category_code" id="toyyibpay_category_code"
                                                                       value="<?php echo isset($xvalue['toyyibpay_category_code']) ? $xvalue['toyyibpay_category_code'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('toyyibpay_category_code'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Toyyibpay Sandbox Mode'); ?></label>
                                                                <br>
                                                                <?php
                                                                $toyyibpay_mode = isset($xvalue['toyyibpay_mode']) ? $xvalue['toyyibpay_mode'] : "";
                                                                if ($toyyibpay_mode == '') $toyyibpay_mode = 'live';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="toyyibpay_mode"
                                                                           id="toyyibpay_mode"
                                                                           value="sandbox"
                                                                           class="custom-control-input" <?php if ($toyyibpay_mode == 'sandbox') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1" for="toyyibpay_mode"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('toyyibpay_mode'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Toyyibpay Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $toyyibpay_enabled = isset($xdata2['toyyibpay_enabled']) ? $xdata2['toyyibpay_enabled'] : "";
                                                                if ($toyyibpay_enabled == '') $toyyibpay_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="toyyibpay_enabled"
                                                                           id="toyyibpay_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($toyyibpay_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="toyyibpay_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('toyyibpay_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Paymaya" role="tabpanel" aria-labelledby="Paymaya-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="paymaya_public_key"><?php echo $this->lang->line("Paymaya Public Key"); ?></label>
                                                                <input name="paymaya_public_key" id="paymaya_public_key"
                                                                       value="<?php echo isset($xvalue['paymaya_public_key']) ? $xvalue['paymaya_public_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('paymaya_public_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="paymaya_secret_key"><?php echo $this->lang->line("Paymaya Secret Key"); ?></label>
                                                                <input name="paymaya_secret_key" id="paymaya_secret_key"
                                                                       value="<?php echo isset($xvalue['paymaya_secret_key']) ? $xvalue['paymaya_secret_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('paymaya_secret_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Paymaya Sandbox Mode'); ?></label>
                                                                <br>
                                                                <?php
                                                                $paymaya_mode = isset($xvalue['paymaya_mode']) ? $xvalue['paymaya_mode'] : "";
                                                                if ($paymaya_mode == '') $paymaya_mode = 'live';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="paymaya_mode" id="paymaya_mode"
                                                                           value="sandbox"
                                                                           class="custom-control-input" <?php if ($paymaya_mode == 'sandbox') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1" for="paymaya_mode"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('paymaya_mode'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Paymaya Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $paymaya_enabled = isset($xdata2['paymaya_enabled']) ? $xdata2['paymaya_enabled'] : "";
                                                                if ($paymaya_enabled == '') $paymaya_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="paymaya_enabled"
                                                                           id="paymaya_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($paymaya_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="paymaya_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('paymaya_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Myfatoorah" role="tabpanel" aria-labelledby="Myfatoorah-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="myfatoorah_api_key"><?php echo $this->lang->line("Myfatoorah Api Key"); ?>
                                                                    <a href="#" data-placement="top" data-toggle="popover"
                                                                       title=""
                                                                       data-content="Myfatoorah only Supports KWD, SAR, BHD, AED, QAR, OMR, JOD, EGP  Currency"
                                                                       data-original-title="<?php echo $this->lang->line('Myfatoorah Supported Currency'); ?>"><i
                                                                                class="bx bx-info-circle"></i> </a>
                                                                </label>
                                                                <input name="myfatoorah_api_key" id="myfatoorah_api_key"
                                                                       value="<?php echo isset($xvalue['myfatoorah_api_key']) ? $xvalue['myfatoorah_api_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('myfatoorah_api_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Myfatoorah Sandbox Mode'); ?></label>
                                                                <br>
                                                                <?php
                                                                $myfatoorah_mode = isset($xvalue['myfatoorah_mode']) ? $xvalue['myfatoorah_mode'] : "";
                                                                if ($myfatoorah_mode == '') $myfatoorah_mode = 'live';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="myfatoorah_mode" id="myfatoorah_mode"
                                                                           value="sandbox"
                                                                           class="custom-control-input" <?php if ($myfatoorah_mode == 'sandbox') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1" for="myfatoorah_mode"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('myfatoorah_mode'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Myfatoorah Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $myfatoorah_enabled = isset($xdata2['myfatoorah_enabled']) ? $xdata2['myfatoorah_enabled'] : "";
                                                                if ($myfatoorah_enabled == '') $myfatoorah_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="myfatoorah_enabled"
                                                                           id="myfatoorah_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($myfatoorah_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="myfatoorah_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('myfatoorah_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Razorpay" role="tabpanel" aria-labelledby="Razorpay-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="razorpay_key_id"> <?php echo $this->lang->line("Razorpay Key ID"); ?></label>
                                                                <input name="razorpay_key_id" id="razorpay_key_id"
                                                                       value="<?php echo isset($xvalue['razorpay_key_id']) ? $xvalue['razorpay_key_id'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('razorpay_key_id'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="razorpay_key_secret"><?php echo $this->lang->line("Razorpay Key Secret"); ?></label>
                                                                <input name="razorpay_key_secret" id="razorpay_key_secret"
                                                                       value="<?php echo isset($xvalue['razorpay_key_secret']) ? $xvalue['razorpay_key_secret'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('razorpay_key_secret'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Razorpay Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $razorpay_enabled = isset($xdata2['razorpay_enabled']) ? $xdata2['razorpay_enabled'] : "";
                                                                if ($razorpay_enabled == '') $razorpay_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="razorpay_enabled"
                                                                           id="razorpay_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($razorpay_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="razorpay_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('razorpay_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="tab-pane " id="Paystack" role="tabpanel" aria-labelledby="Paystack-tab" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="paystack_secret_key"> <?php echo $this->lang->line("Paystack Secret Key"); ?></label>
                                                                <input name="paystack_secret_key" id="paystack_secret_key"
                                                                       value="<?php echo isset($xvalue['paystack_secret_key']) ? $xvalue['paystack_secret_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('paystack_secret_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="paystack_public_key"><?php echo $this->lang->line("Paystack Public Key"); ?></label>
                                                                <input name="paystack_public_key" id="paystack_public_key"
                                                                       value="<?php echo isset($xvalue['paystack_public_key']) ? $xvalue['paystack_public_key'] : ""; ?>"
                                                                       class="form-control" type="text">
                                                                <span class="text-danger"><?php echo form_error('paystack_public_key'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Paystack Enabled'); ?></label>
                                                                <br>
                                                                <?php
                                                                $paystack_enabled = isset($xdata2['paystack_enabled']) ? $xdata2['paystack_enabled'] : "";
                                                                if ($paystack_enabled == '') $paystack_enabled = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="paystack_enabled"
                                                                           id="paystack_enabled" value="1"
                                                                           class="custom-control-input" <?php if ($paystack_enabled == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="paystack_enabled"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('paystack_enabled'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <?php if ($xdata2['store_type'] == 'physical') : ?>
                                                    <div class="tab-pane " id="Manual" role="tabpanel" aria-labelledby="Manual-tab" aria-expanded="false">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="manual_payment_instruction"
                                                                    ><?php echo $this->lang->line('Write Manual payment instructions'); ?>
                                                                    </label>
                                                                    <textarea name="manual_payment_instruction"
                                                                              id="manual_payment_instruction"
                                                                              class="form-control visual_editor"><?php echo set_value('manual_payment_instruction', isset($xvalue['manual_payment_instruction']) ? $xvalue['manual_payment_instruction'] : ""); ?></textarea>
                                                                    <span class="text-danger"><?php echo form_error('manual_payment_instruction'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Manual Enabled'); ?></label>
                                                                    <br>
                                                                    <?php
                                                                    $manual_enabled = isset($xdata2['manual_enabled']) ? $xdata2['manual_enabled'] : "";
                                                                    if ($manual_enabled == '') $manual_enabled = '0';
                                                                    ?>
                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="manual_enabled"
                                                                               id="manual_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($manual_enabled == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="manual_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('manual_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($xdata2['store_type'] == 'physical') : ?>
                                                    <div class="tab-pane " id="CoD" role="tabpanel" aria-labelledby="CoD-tab" aria-expanded="false">
                                                        <div class="row">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Cash on delivery Enabled'); ?></label>
                                                                    <br>
                                                                    <?php
                                                                    $cod_enabled = isset($xdata2['cod_enabled']) ? $xdata2['cod_enabled'] : "";
                                                                    if ($cod_enabled == '') $cod_enabled = '0';
                                                                    ?>
                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="cod_enabled"
                                                                               id="cod_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($cod_enabled == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="cod_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('cod_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php
                                                $omise_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php')) {
                                                    $omise_hide = '';

                                                    ?>
                                                    <div class="tab-pane " id="Omise" role="tabpanel" aria-labelledby="Omise-tab" aria-expanded="false">
                                                        <div class="row <?php echo $omise_hide; ?>">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_omise_seckey"> <?php echo $this->lang->line("Omise Secret Key"); ?></label>
                                                                    <input name="n_omise_seckey" id="n_omise_seckey"
                                                                           value="<?php echo isset($xvalue['n_omise_seckey']) ? $xvalue['n_omise_seckey'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_omise_seckey'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_omise_pubkey"><?php echo $this->lang->line("Omise Publishable Key"); ?></label>
                                                                    <input name="n_omise_pubkey" id="n_omise_pubkey"
                                                                           value="<?php echo isset($xvalue['n_omise_pubkey']) ? $xvalue['n_omise_pubkey'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_omise_pubkey'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Omise Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_omise_enabled"
                                                                               id="n_omise_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_omise_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_omise_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_omise_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $paymongo_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php')) {
                                                    $paymongo_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="Paymongo" role="tabpanel" aria-labelledby="Paymongo-tab" aria-expanded="false">
                                                        <div class="row <?php echo $paymongo_hide; ?>">
                                                            <?php if (!empty($xvalue['n_paymongo_sec'])) { ?>
                                                                <div class="col-12 mb-1 mt-1">
                                                                    <a href="#" id="enable_paymongo_webhook"
                                                                       class="btn btn-light-primary"><?php echo $this->lang->line('Enable webhook, need for gcash, grab pay'); ?></a>
                                                                </div>
                                                            <?php } ?>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_paymongo_sec"> <?php echo $this->lang->line("Paymongo Secret Key"); ?></label>
                                                                    <input name="n_paymongo_sec" id="n_paymongo_sec"
                                                                           value="<?php echo isset($xvalue['n_paymongo_sec']) ? $xvalue['n_paymongo_sec'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_paymongo_sec'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_paymongo_pub"><?php echo $this->lang->line("Paymongo Publishable Key"); ?></label>
                                                                    <input name="n_paymongo_pub" id="n_paymongo_pub"
                                                                           value="<?php echo isset($xvalue['n_paymongo_pub']) ? $xvalue['n_paymongo_pub'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_paymongo_pub'); ?></span>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Paymongo Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_paymongo_enabled"
                                                                               id="n_paymongo_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_paymongo_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_paymongo_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_paymongo_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Paymongo GrabPay Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_paymongo_grab_en"
                                                                               id="n_paymongo_grab_en" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_paymongo_grab_en'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_paymongo_grab_en"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_paymongo_grab_en'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Paymongo GCash Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_paymongo_gcash_en"
                                                                               id="n_paymongo_gcash_en" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_paymongo_gcash_en'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_paymongo_gcash_en"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_paymongo_gcash_en'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Paymongo PayMaya Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_paymongo_paymaya_en"
                                                                               id="n_paymongo_paymaya_en" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_paymongo_paymaya_en'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_paymongo_paymaya_en"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_paymongo_paymaya_en'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $paymentwall_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php')) {
                                                    $paymentwall_hide = '';

                                                    ?>
                                                    <div class="tab-pane " id="Paymentwall" role="tabpanel" aria-labelledby="Paymentwall-tab" aria-expanded="false">
                                                        <div class="row <?php echo $paymentwall_hide; ?>">

                                                            <div class="col-12 mt-1 mb-1">
                                                                <?php echo $this->lang->line('Add this to Paymentwall Project Pingback URL:'); ?>
                                                                <p><?php echo _link("n_paymentwall/webhook_ecommerce", $custom_domain_set); ?></p>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_paymentwall_sec"> <?php echo $this->lang->line("Paymentwall Secret Key"); ?></label>
                                                                    <input name="n_paymentwall_sec" id="n_paymentwall_sec"
                                                                           value="<?php echo isset($xvalue['n_paymentwall_sec']) ? $xvalue['n_paymentwall_sec'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_paymentwall_sec'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_paymentwall_pub"><?php echo $this->lang->line("Paymentwall Publishable Key"); ?></label>
                                                                    <input name="n_paymentwall_pub" id="n_paymentwall_pub"
                                                                           value="<?php echo isset($xvalue['n_paymentwall_pub']) ? $xvalue['n_paymentwall_pub'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_paymentwall_pub'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('Paymentwall Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_paymentwall_enabled"
                                                                               id="n_paymentwall_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_paymentwall_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_paymentwall_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_paymentwall_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                <?php } ?>


                                                <?php
                                                $payu_latam_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_payu_latam/controllers/N_payu_latam.php')) {
                                                    $payu_latam_hide = '';

                                                    ?>

                                                    <div class="tab-pane " id="PayULATAM" role="tabpanel" aria-labelledby="PayULATAM-tab" aria-expanded="false">
                                                        <div class="row <?php echo $payu_latam_hide; ?>">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_payu_latam_merchantid"> <?php echo $this->lang->line("PayU LATAM Merchant ID"); ?></label>
                                                                    <input name="n_payu_latam_merchantid"
                                                                           id="n_payu_latam_merchantid"
                                                                           value="<?php echo isset($xvalue['n_payu_latam_merchantid']) ? $xvalue['n_payu_latam_merchantid'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_payu_latam_merchantid'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_payu_latam_accountid"><?php echo $this->lang->line("PayU LATAM Account ID"); ?></label>
                                                                    <input name="n_payu_latam_accountid" id="n_payu_latam_accountid"
                                                                           value="<?php echo isset($xvalue['n_payu_latam_accountid']) ? $xvalue['n_payu_latam_accountid'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_payu_latam_accountid'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_payu_latam_api_key"><?php echo $this->lang->line("PayU LATAM API KEY"); ?></label>
                                                                    <input name="n_payu_latam_api_key" id="n_payu_latam_api_key"
                                                                           value="<?php echo isset($xvalue['n_payu_latam_api_key']) ? $xvalue['n_payu_latam_api_key'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_payu_latam_api_key'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('PayU LATAM Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_payu_latam_enabled"
                                                                               id="n_payu_latam_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_payu_latam_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_payu_latam_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_payu_latam_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for=""><?php echo $this->lang->line('PayU LATAM TestMode Enabled (sandbox)'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_payu_latam_sandbox"
                                                                               id="n_payu_latam_sandbox" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_payu_latam_sandbox'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_payu_latam_sandbox"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_payu_latam_sandbox'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $coinbase_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_coinbase/controllers/N_coinbase.php')) {
                                                    $coinbase_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="Coinbase" role="tabpanel" aria-labelledby="Coinbase-tab" aria-expanded="false">
                                                        <div class="row <?php echo $coinbase_hide; ?>">

                                                            <div class="col-12 mt-1 mb-1">
                                                                <?php echo $this->lang->line('Add this to Coinbase Webhook in Account settings:'); ?>
                                                                <p><?php echo _link("n_coinbase/webhook_ecommerce", $custom_domain_set); ?></p>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_coinbase_shared_secret"> <?php echo $this->lang->line("Coinbase Shared Secret key"); ?></label>
                                                                    <input name="n_coinbase_shared_secret"
                                                                           id="n_coinbase_shared_secret"
                                                                           value="<?php echo isset($xvalue['n_coinbase_shared_secret']) ? $xvalue['n_coinbase_shared_secret'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_coinbase_shared_secret'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_coinbase_api_key"><?php echo $this->lang->line("Coinbase API Key"); ?></label>
                                                                    <input name="n_coinbase_api_key" id="n_coinbase_api_key"
                                                                           value="<?php echo isset($xvalue['n_coinbase_api_key']) ? $xvalue['n_coinbase_api_key'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_coinbase_api_key'); ?></span>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_stripe_enabled"><?php echo $this->lang->line('Coinbase Enabled'); ?></label>
                                                                    <br>
                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_coinbase_enabled"
                                                                               id="n_coinbase_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_coinbase_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_coinbase_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_coinbase_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_moamalat_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php')) {
                                                    $n_moamalat_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="MOAMALAT" role="tabpanel" aria-labelledby="MOAMALAT-tab" aria-expanded="false">
                                                        <h5><?php echo $this->lang->line('Accept bank card payment'); ?></h5>
                                                        <p><?php echo $this->lang->line('To subscribe to the service, please contact your bank to open an account and accept payment by bank card'); ?></p>
                                                        <div class="row <?php echo $n_moamalat_hide; ?>">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_moamalat_merchant_id"> <?php echo $this->lang->line("MOAMALAT Merchant ID"); ?></label>
                                                                    <input name="n_moamalat_merchant_id"
                                                                           id="n_moamalat_merchant_id"
                                                                           value="<?php echo isset($xvalue['n_moamalat_merchant_id']) ? $xvalue['n_moamalat_merchant_id'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_moamalat_merchant_id'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_moamalat_terminal_id"><?php echo $this->lang->line("MOAMALAT Terminal ID"); ?></label>
                                                                    <input name="n_moamalat_terminal_id" id="n_moamalat_terminal_id"
                                                                           value="<?php echo isset($xvalue['n_moamalat_terminal_id']) ? $xvalue['n_moamalat_terminal_id'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_moamalat_terminal_id'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_moamalat_secret_key"><?php echo $this->lang->line("MOAMALAT Secret Key"); ?></label>
                                                                    <input name="n_moamalat_secret_key" id="n_moamalat_secret_key" value="*****"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_moamalat_secret_key'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_moamalat_enabled"><?php echo $this->lang->line('MOAMALAT Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_moamalat_enabled"
                                                                               id="n_moamalat_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_moamalat_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_moamalat_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_moamalat_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_moamalat_testmode"><?php echo $this->lang->line('MOAMALAT Test Mode'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_moamalat_testmode"
                                                                               id="n_moamalat_testmode" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_moamalat_testmode'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_moamalat_testmode"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_moamalat_testmode'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_sadad_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
                                                    $n_sadad_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="SADAD" role="tabpanel" aria-labelledby="SADAD-tab" aria-expanded="false">

                                                        <div class="row <?php echo $n_sadad_hide; ?>">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_sadad_secret_key"><?php echo $this->lang->line("SADAD Secret Key"); ?></label>
                                                                    <input name="n_sadad_secret_key" id="n_sadad_secret_key" value="<?php echo isset($xvalue['n_sadad_secret_key']) ? $xvalue['n_sadad_secret_key'] : ''; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_sadad_secret_key'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_sadad_enabled"><?php echo $this->lang->line('SADAD Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_sadad_enabled"
                                                                               id="n_sadad_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_sadad_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_sadad_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_sadad_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_sadad_testmode"><?php echo $this->lang->line('SADAD Test Mode'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_sadad_testmode"
                                                                               id="n_sadad_testmode" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_sadad_testmode'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_sadad_testmode"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_sadad_testmode'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_tdsp_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php')) {
                                                    $n_tdsp_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="TDSP" role="tabpanel" aria-labelledby="TDSP-tab" aria-expanded="false">
                                                        <h5><?php echo $this->lang->line('Subscribe to T-lync'); ?></h5>
                                                        <p><?php echo $this->lang->line('Please subscribe and fill in the data via the company\'s website and open an account within seconds'); ?><br /> <a href="https://merchant.pay.net.ly/" target="_blank"><?php echo $this->lang->line('Subscribe now'); ?></a></p>

                                                        <div class="row <?php echo $n_tdsp_hide; ?>">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_tdsp_auth_key"> <?php echo $this->lang->line("TDSP Auth Key"); ?></label>
                                                                    <input name="n_tdsp_auth_key"
                                                                           id="n_tdsp_auth_key"
                                                                           value="<?php echo isset($xvalue['n_tdsp_auth_key']) ? $xvalue['n_tdsp_auth_key'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_tdsp_auth_key'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_tdsp_store_id"><?php echo $this->lang->line("TDSP Store ID"); ?></label>
                                                                    <input name="n_tdsp_store_id" id="n_tdsp_store_id"
                                                                           value="<?php echo isset($xvalue['n_tdsp_store_id']) ? $xvalue['n_tdsp_store_id'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_tdsp_store_id'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_tdsp_sandbox"><?php echo $this->lang->line('TDSP Test Mode'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_tdsp_sandbox"
                                                                               id="n_tdsp_sandbox" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_tdsp_sandbox'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_tdsp_sandbox"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_tdsp_sandbox'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_tdsp_enabled"><?php echo $this->lang->line('TDSP Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_tdsp_enabled"
                                                                               id="n_tdsp_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_tdsp_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_tdsp_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_tdsp_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_stripe_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')) {
                                                    $n_stripe_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="Stripe_New" role="tabpanel" aria-labelledby="Stripe_New-tab" aria-expanded="false">
                                                        <div class="row <?php echo $n_stripe_hide; ?>">
                                                            <div class="col-12 ">
                                                                <?php echo $this->lang->line('Add this to Stripe Webhook in Account settings:<br /> Events:<br /> checkout.session.completed<br />'); ?>
                                                                <p><?php echo _link("n_stripe/webhook_ecommerce", $custom_domain_set); ?></p>

                                                                <p><a href="https://dashboard.stripe.com/webhooks" target="_blank">Stripe Webhooks</a></p>

                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_stripe_secret_key"> <?php echo $this->lang->line("Stripe Secret Key"); ?></label>
                                                                    <input name="n_stripe_secret_key"
                                                                           id="n_stripe_secret_key"
                                                                           value="<?php echo isset($xvalue['n_stripe_secret_key']) ? $xvalue['n_stripe_secret_key'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_stripe_secret_key'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_stripe_product_image"><?php echo $this->lang->line("Stripe Checkout Image (optional)"); ?></label>
                                                                    <input name="n_stripe_product_image" id="n_stripe_product_image"
                                                                           value="<?php echo isset($xvalue['n_stripe_product_image']) ? $xvalue['n_stripe_product_image'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_stripe_product_image'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_stripe_enabled"><?php echo $this->lang->line('Stripe  Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_stripe_enabled"
                                                                               id="n_stripe_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_stripe_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_stripe_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_stripe_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>




                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_mastercard_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_mastercard/controllers/N_mastercard.php')) {
                                                    $n_mastercard_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="mastercard" role="tabpanel" aria-labelledby="mastercard-tab" aria-expanded="false">

                                                        <div class="row <?php echo $n_tdsp_hide; ?>">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_mastercard_merchant_id"> <?php echo $this->lang->line("Mastercard Merchant ID"); ?></label>
                                                                    <input name="n_mastercard_merchant_id"
                                                                           id="n_mastercard_merchant_id"
                                                                           value="<?php echo isset($xvalue['n_mastercard_merchant_id']) ? $xvalue['n_mastercard_merchant_id'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_mastercard_merchant_id'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_mastercard_api_pass"><?php echo $this->lang->line("Mastercard API Password"); ?></label>
                                                                    <input name="n_mastercard_api_pass" id="n_mastercard_api_pass"
                                                                           value="<?php echo isset($xvalue['n_mastercard_api_pass']) ? $xvalue['n_mastercard_api_pass'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_mastercard_api_pass'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_mastercard_testmode"><?php echo $this->lang->line('Mastercard Test Mode'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_mastercard_testmode"
                                                                               id="n_mastercard_testmode" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_mastercard_testmode'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_mastercard_testmode"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_mastercard_testmode'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_mastercard_enabled"><?php echo $this->lang->line('Mastercard Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_mastercard_enabled"
                                                                               id="n_mastercard_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_mastercard_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_mastercard_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_mastercard_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>


                                                <?php
                                                $n_epayco_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php')) {

                                                    $n_epayco_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="ePayco" role="tabpanel" aria-labelledby="ePayco-tab" aria-expanded="false">

                                                        <div class="row <?php echo $n_epayco_hide; ?>">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_epayco_pkey"> <?php echo $this->lang->line("ePayco Public Key"); ?></label>
                                                                    <input name="n_epayco_pkey"
                                                                           id="n_epayco_pkey"
                                                                           value="<?php echo isset($xvalue['n_epayco_pkey']) ? $xvalue['n_epayco_pkey'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_epayco_pkey'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_epayco_enabled"><?php echo $this->lang->line('ePayco Test Mode'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_epayco_testmode"
                                                                               id="n_epayco_testmode" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_epayco_testmode'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_epayco_testmode"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_epayco_testmode'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_mastercard_enabled"><?php echo $this->lang->line('ePayco Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_epayco_enabled"
                                                                               id="n_epayco_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_epayco_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_epayco_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_epayco_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_mastercard_enabled"><?php echo $this->lang->line('ePayco Standard Page Checkout'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_epayco_checkout"
                                                                               id="n_epayco_checkout" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_epayco_checkout'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_epayco_checkout"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_epayco_checkout'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_sellix_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php')) {
                                                    $n_sellix_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="Sellix" role="tabpanel" aria-labelledby="Sellix-tab" aria-expanded="false">
                                                        <div class="row <?php echo $n_sellix_hide; ?>">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_sellix_api_key"> <?php echo $this->lang->line("Sellix Api Key"); ?></label>
                                                                    <input name="n_sellix_api_key"
                                                                           id="n_sellix_api_key"
                                                                           value="<?php echo isset($xvalue['n_sellix_api_key']) ? $xvalue['n_sellix_api_key'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_sellix_api_key'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_sellix_webhook_secret"><?php echo $this->lang->line("Sellix Webhook Secret Key"); ?></label>
                                                                    <input name="n_sellix_webhook_secret" id="n_sellix_webhook_secret"
                                                                           value="<?php echo isset($xvalue['n_sellix_webhook_secret']) ? $xvalue['n_sellix_webhook_secret'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_sellix_webhook_secret'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_sellix_merchant"><?php echo $this->lang->line("Sellix Merchant"); ?></label>
                                                                    <input name="n_sellix_merchant" id="n_sellix_merchant"
                                                                           value="<?php echo isset($xvalue['n_sellix_merchant']) ? $xvalue['n_sellix_merchant'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_sellix_merchant'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_sellix_enabled"><?php echo $this->lang->line('Sellix Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_sellix_enabled"
                                                                               id="n_sellix_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_sellix_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_sellix_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_sellix_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>




                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_chapa_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php')) {
                                                    $n_chapa_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="Chapa" role="tabpanel" aria-labelledby="Chapa-tab" aria-expanded="false">
                                                        <div class="row <?php echo $n_chapa_hide; ?>">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_chapa_secret_key"> <?php echo $this->lang->line("Chapa Api Secret Key"); ?></label>
                                                                    <input name="n_chapa_secret_key"
                                                                           id="n_chapa_secret_key"
                                                                           value="<?php echo isset($xvalue['n_chapa_secret_key']) ? $xvalue['n_chapa_secret_key'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_chapa_secret_key'); ?></span>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_chapa_enabled"><?php echo $this->lang->line('Chapa Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_chapa_enabled"
                                                                               id="n_chapa_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_chapa_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_chapa_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_chapa_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>




                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_zaincash_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php')) {
                                                    $n_zaincash_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="ZainCash" role="tabpanel" aria-labelledby="ZainCash-tab" aria-expanded="false">
                                                        <div class="row <?php echo $n_zaincash_hide; ?>">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_zaincash_merchant_secret"> <?php echo $this->lang->line("ZainCash Api Merchant Secret"); ?></label>
                                                                    <input name="n_zaincash_merchant_secret"
                                                                           id="n_zaincash_merchant_secret"
                                                                           value="<?php echo isset($xvalue['n_zaincash_merchant_secret']) ? $xvalue['n_zaincash_merchant_secret'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_zaincash_merchant_secret'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_zaincash_MSISDN"> <?php echo $this->lang->line("ZainCash Api MSISDN"); ?></label>
                                                                    <input name="n_zaincash_MSISDN"
                                                                           id="n_zaincash_MSISDN"
                                                                           value="<?php echo isset($xvalue['n_zaincash_MSISDN']) ? $xvalue['n_zaincash_MSISDN'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_zaincash_MSISDN'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_zaincash_merchant_id"> <?php echo $this->lang->line("ZainCash Api Merchant ID"); ?></label>
                                                                    <input name="n_zaincash_merchant_id"
                                                                           id="n_zaincash_merchant_id"
                                                                           value="<?php echo isset($xvalue['n_zaincash_merchant_id']) ? $xvalue['n_zaincash_merchant_id'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_zaincash_merchant_id'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_zaincash_convert_price"> <?php echo $this->lang->line("ZainCash Convert Price (use 1 for IQD Currency)"); ?></label>
                                                                    <input name="n_zaincash_convert_price"
                                                                           id="n_zaincash_convert_price"
                                                                           value="<?php echo isset($xvalue['n_zaincash_convert_price']) ? $xvalue['n_zaincash_convert_price'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_zaincash_convert_price'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_zaincash_enabled"><?php echo $this->lang->line('ZainCash Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_zaincash_enabled"
                                                                               id="n_zaincash_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_zaincash_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_zaincash_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_zaincash_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_zaincash_testmode_enabled"><?php echo $this->lang->line('ZainCash TestMode Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_zaincash_testmode_enabled"
                                                                               id="n_zaincash_testmode_enabled" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_zaincash_testmode_enabled'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_zaincash_testmode_enabled"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_zaincash_testmode_enabled'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>




                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                $n_tap_hide = 'd-none';
                                                if (file_exists(APPPATH . 'modules/n_tap/controllers/N_tap.php')) {
                                                    $n_tap_hide = '';
                                                    ?>
                                                    <div class="tab-pane " id="tap" role="tabpanel" aria-labelledby="tap-tab" aria-expanded="false">
                                                        <div class="row <?php echo $n_tap_hide; ?>">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="n_tap_secret"> <?php echo $this->lang->line("tap API Secret"); ?></label>
                                                                    <input name="n_tap_secret"
                                                                           id="n_tap_secret"
                                                                           value="<?php echo isset($xvalue['n_tap_secret']) ? $xvalue['n_tap_secret'] : ""; ?>"
                                                                           class="form-control" type="text">
                                                                    <span class="text-danger"><?php echo form_error('n_tap_secret'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4 col-sm-4">
                                                                <div class="form-group">
                                                                    <label for="n_tap_on"><?php echo $this->lang->line('tap Enabled'); ?></label>
                                                                    <br>

                                                                    <label class="custom-switch mt-2">
                                                                        <input type="checkbox" name="n_tap_on"
                                                                               id="n_tap_on" value="1"
                                                                               class="custom-control-input" <?php if ($xdata2['n_tap_on'] == '1') echo 'checked'; ?>>
                                                                        <label class="custom-control-label mr-1"
                                                                               for="n_tap_on"></label>
                                                                        <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                        <span class="text-danger"><?php echo form_error('n_tap_on'); ?></span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card collapse-header">
                                <div id="heading3" class="card-header" data-toggle="collapse" role="button"
                                     data-target="#accordion3"
                                     aria-expanded="false" aria-controls="accordion3">
                                    <span class="collapse-title"><?php echo $this->lang->line("Currency & Formatting"); ?></span>
                                </div>
                                <div id="accordion3" role="tabpanel" data-parent="#accordionWrapa1"
                                     aria-labelledby="heading3" class="collapse"
                                     aria-expanded="false">
                                    <div class="card-body p-0">
                                        <div class="card">
                                            <div class="card-footer p-2" style="border:1px solid #e4e6fc;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="currency"><?php echo $this->lang->line("Currency"); ?></label>
                                                            <?php $default_currency = isset($xvalue['currency']) ? $xvalue['currency'] : "USD"; ?>
                                                            <select name='currency' id='currency' class='select2 form-control'
                                                                    style='width:100% !important;'>
                                                                <?php
                                                                foreach ($currecny_list_all as $key => $value) {
                                                                    $paypal_supported = in_array($key, $currency_list) ? " - PayPal & Stripe" : "";
                                                                    if ($default_currency == $key) $selected_curr = "selected='selected'";
                                                                    else $selected_curr = '';
                                                                    echo '<option value="' . $key . '" ' . $selected_curr . ' >' . str_replace('And', '&', ucwords($value)) . $paypal_supported . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                            <span class="text-danger"><?php echo form_error('currency'); ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="">
                                                                <?php echo $this->lang->line('Right Alignment'); ?>
                                                                <a href="#" data-placement="top" data-toggle="tooltip"
                                                                   title="<?php echo $this->lang->line("Right alignment could be helpful for several currencies. Example display : 25৳"); ?>"><i
                                                                            class="bx bx-info-circle"></i> </a>
                                                            </label>
                                                            <br>
                                                            <?php
                                                            $currency_position = isset($xvalue['currency_position']) ? $xvalue['currency_position'] : "";
                                                            if ($currency_position == '') $currency_position = 'left';
                                                            ?>
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="currency_position"
                                                                       id="currency_position" value="right"
                                                                       class="custom-control-input" <?php if ($currency_position == 'right') echo 'checked'; ?>>
                                                                <label class="custom-control-label mr-1"
                                                                       for="currency_position"></label>
                                                                <span><?php echo $this->lang->line('Yes'); ?></span>
                                                                <span class="text-danger"><?php echo form_error('currency_position'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4 col-sm-4">

                                                        <?php
                                                        $decimal_point = isset($xvalue['decimal_point']) ? $xvalue['decimal_point'] : "";
                                                        if ($decimal_point == '') $decimal_point = '2';
                                                        ?>

                                                        <fieldset>
                                                            <label class="pb-1"
                                                                   for="decimal_point"><?php echo $this->lang->line('Price decimals'); ?>
                                                                <a href="#" data-placement="top" data-toggle="tooltip"
                                                                   title="<?php echo $this->lang->line("If enabled prices will be displayed with two decimal points. Example display : $25.99"); ?>"><i
                                                                            class="bx bx-info-circle"></i> </a></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                                class='bx bx-dollar-circle'></i></span>
                                                                </div>
                                                                <input type="number" id="decimal_point"
                                                                       name="decimal_point" class="form-control"
                                                                       value="<?php echo $decimal_point; ?>">
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('decimal_point'); ?></span>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12 col-md-4 col-sm-4">
                                                        <div class="form-group">
                                                            <label for="">
                                                                <?php echo $this->lang->line('Display Comma'); ?>
                                                                <a href="#" data-placement="top" data-toggle="tooltip"
                                                                   title="<?php echo $this->lang->line("If enabled prices will be displayed comma separated. Example display : $25,000"); ?>"><i
                                                                            class="bx bx-info-circle"></i> </a>

                                                            </label>
                                                            <br>
                                                            <?php
                                                            $thousand_comma = isset($xvalue['thousand_comma']) ? $xvalue['thousand_comma'] : "";
                                                            if ($thousand_comma == '') $thousand_comma = '0';
                                                            ?>
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="thousand_comma"
                                                                       id="thousand_comma" value="1"
                                                                       class="custom-control-input" <?php if ($thousand_comma == '1') echo 'checked'; ?>>
                                                                <label class="custom-control-label mr-1"
                                                                       for="thousand_comma"></label>
                                                                <span><?php echo $this->lang->line('Yes'); ?></span>
                                                                <span class="text-danger"><?php echo form_error('thousand_comma'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card collapse-header">
                                <div id="heading4" class="card-header" data-toggle="collapse" role="button"
                                     data-target="#accordion4"
                                     aria-expanded="false" aria-controls="accordion4">
                                    <span class="collapse-title"><?php echo $this->lang->line("Tax & Delivery Charge"); ?></span>
                                </div>
                                <div id="accordion4" role="tabpanel" data-parent="#accordionWrapa1"
                                     aria-labelledby="heading4" class="collapse"
                                     aria-expanded="false">
                                    <div class="card-body p-0">
                                        <div class="card">
                                            <div class="card-footer p-2" style="border:1px solid #e4e6fc;">
                                                <div class="row">
                                                    <div class="form-group <?php if ($xdata2['store_type'] == 'physical') echo 'col-6 col-md-6'; else echo 'col-12'; ?>">
                                                        <label for="tax_percentage">
                                                            <?php echo $this->lang->line("Tax"); ?> %
                                                        </label>
                                                        <div class="input-group mb-2">
                                                            <input type="number" name="tax_percentage"
                                                                   id="tax_percentage" class="form-control"
                                                                   value="<?php echo $xdata2['tax_percentage']; ?>"
                                                                   min="0" step="0.01">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">%</div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <?php if ($xdata2['store_type'] == 'physical') : ?>
                                                        <div class="form-group col-6 col-md-6 d-none">
                                                            <label for="shipping_charge">
                                                                <?php echo $this->lang->line("Delivery charge"); ?>
                                                            </label>
                                                            <div class="input-group mb-2">
                                                                <input type="number" name="shipping_charge"
                                                                       id="shipping_charge" class="form-control"
                                                                       value="<?php echo $xdata2['shipping_charge']; ?>"
                                                                       min="0" step="0.01">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <?php
                                                                        $currency = isset($xvalue['currency']) ? $xvalue['currency'] : "USD";
                                                                        $currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";
                                                                        echo $currency_icon;
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($xdata2['store_type'] == 'physical') : ?>
                                <div class="card collapse-header">
                                    <div id="heading5" class="card-header" data-toggle="collapse" role="button"
                                         data-target="#accordion5"
                                         aria-expanded="false" aria-controls="accordion4">
                                        <span class="collapse-title"><?php echo $this->lang->line("Delivery Preference"); ?></span>
                                    </div>
                                    <div id="accordion5" role="tabpanel" data-parent="#accordionWrapa1"
                                         aria-labelledby="heading5" class="collapse"
                                         aria-expanded="false">
                                        <div class="card-body p-0">
                                            <div class="card">
                                                <div class="card-footer p-2" style="border:1px solid #e4e6fc;">
                                                    <div class="row">
                                                        <div class="col-6 col-md-4 d-none">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Store Pickup'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_store_pickup = isset($xvalue['is_store_pickup']) ? $xvalue['is_store_pickup'] : "";
                                                                if ($is_store_pickup == '') $is_store_pickup = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_store_pickup"
                                                                           id="is_store_pickup" value="1"
                                                                           class="custom-control-input" checked>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_store_pickup"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_store_pickup'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 col-md-4 d-none">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Home Delivery'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_home_delivery = isset($xvalue['is_home_delivery']) ? $xvalue['is_home_delivery'] : "";
                                                                if ($is_home_delivery == '') $is_home_delivery = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_home_delivery"
                                                                           id="is_home_delivery" value="1"
                                                                           class="custom-control-input" checked>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_home_delivery"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_home_delivery'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 col-md-4 col-sm-4">
                                                            <div class="form-group mb-2">
                                                                <label for=""><?php echo $this->lang->line('Preparation time'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_preparation_time = isset($xvalue['is_preparation_time']) ? $xvalue['is_preparation_time'] : "";
                                                                if ($is_preparation_time == '') $is_preparation_time = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_preparation_time"
                                                                           id="is_preparation_time" value="1"
                                                                           class="custom-control-input" <?php if ($is_preparation_time == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_preparation_time"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_preparation_time'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Delivery Note'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_delivery_note = isset($xvalue['is_delivery_note']) ? $xvalue['is_delivery_note'] : "";
                                                                if($is_delivery_note == '') $is_delivery_note = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_delivery_note"
                                                                           id="is_delivery_note" value="1"
                                                                           class="custom-control-input" <?php if ($is_delivery_note == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_delivery_note"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_delivery_note'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-8">
                                                            <div class="form-group">
                                                                <label for="preparation_time">&nbsp;</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><?php echo $this->lang->line("Time"); ?></span>
                                                                    </div>
                                                                    <?php
                                                                    $preparation_time_unit = isset($xvalue['preparation_time_unit']) ? $xvalue['preparation_time_unit'] : "minutes";
                                                                    $disabled = ($is_preparation_time == '1') ? "" : "disabled";
                                                                    $arr = array
                                                                    (
                                                                        '' => $this->lang->line('Time unit'),
                                                                        'minutes' => $this->lang->line('Minutes'),
                                                                        'hours' => $this->lang->line('Hours'),
                                                                        'days' => $this->lang->line('Days')
                                                                    );
                                                                    ?>
                                                                    <input type="text" id="preparation_time"
                                                                           placeholder="<?php echo $this->lang->line('example : 10 or 10-15'); ?>" <?php echo $disabled; ?>
                                                                           name="preparation_time" class="form-control"
                                                                           value="<?php echo isset($xvalue['preparation_time']) ? $xvalue['preparation_time'] : "30" ?>">
                                                                    <?php echo form_dropdown('preparation_time_unit', $arr, $preparation_time_unit, "class='form-control' {$disabled}"); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group mb-2">
                                                                <label for=""><?php echo $this->lang->line('Scheduled order'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_order_schedule = isset($xvalue['is_order_schedule']) ? $xvalue['is_order_schedule'] : "";
                                                                if ($is_order_schedule == '') $is_order_schedule = '0';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_order_schedule"
                                                                           id="is_order_schedule" value="1"
                                                                           class="custom-control-input" <?php if ($is_order_schedule == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_order_schedule"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_order_schedule'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-8">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <?php
                                                                $order_schedule = isset($xvalue['order_schedule']) ? $xvalue['order_schedule'] : "any";
                                                                $disabled = ($is_order_schedule == '1') ? "" : "disabled";
                                                                $arr = array
                                                                (
                                                                    'today' => $this->lang->line('Only Today'),
                                                                    'tomorrow' => $this->lang->line('Today & Tomorrow'),
                                                                    'week' => $this->lang->line('One Week'),
                                                                    'any' => $this->lang->line('Any')
                                                                );
                                                                ?>
                                                                <div class="input-group mb-2">
                                                                    <?php echo form_dropdown('order_schedule', $arr, $order_schedule, "class='form-control' {$disabled}"); ?>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="card collapse-header">
                                <div id="heading6" class="card-header" data-toggle="collapse" role="button"
                                     data-target="#accordion6"
                                     aria-expanded="false" aria-controls="accordion4">
                                    <span class="collapse-title"><?php echo $this->lang->line("Login Preference"); ?></span>
                                </div>
                                <div id="accordion6" role="tabpanel" data-parent="#accordionWrapa1"
                                     aria-labelledby="heading6" class="collapse"
                                     aria-expanded="false">
                                    <div class="card-body p-0">
                                        <div class="card">
                                            <div class="card-footer p-2" style="border:1px solid #e4e6fc;">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 col-sm-4">
                                                        <div class="form-group mb-2">
                                                            <label for=""><?php echo $this->lang->line('Guest Purchase'); ?></label>
                                                            <br>
                                                            <?php
                                                            $is_guest_login = isset($xvalue['is_guest_login']) ? $xvalue['is_guest_login'] : "0";
                                                            if ($is_guest_login == '') $is_guest_login = '0';
                                                            ?>
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="is_guest_login"
                                                                       id="is_guest_login" value="1"
                                                                       class="custom-control-input" <?php if ($is_guest_login == '1') echo 'checked'; ?>>
                                                                <label class="custom-control-label mr-1"
                                                                       for="is_guest_login"></label>
                                                                <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                <span class="text-danger"><?php echo form_error('is_guest_login'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($xdata2['store_type'] == 'physical') : ?>
                                <div class="card collapse-header d-none">
                                    <div id="heading7" class="card-header" data-toggle="collapse" role="button"
                                         data-target="#accordion7"
                                         aria-expanded="false" aria-controls="accordion4">
                                        <span class="collapse-title"><?php echo $this->lang->line("Address Preference"); ?></span>
                                    </div>
                                    <div id="accordion7" role="tabpanel" data-parent="#accordionWrapa1"
                                         aria-labelledby="heading7" class="collapse"
                                         aria-expanded="false">
                                        <div class="card-body p-0">
                                            <div class="card">
                                                <div class="card-footer p-2" style="border:1px solid #e4e6fc;">
                                                    <div class="row">
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Checkout Country'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_checkout_country = isset($xvalue['is_checkout_country']) ? $xvalue['is_checkout_country'] : "";
                                                                $is_checkout_country = '1';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_checkout_country"
                                                                           id="is_checkout_country" value="1"
                                                                           class="custom-control-input" <?php if ($is_checkout_country == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_checkout_country"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_checkout_country'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Checkout State'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_checkout_state = isset($xvalue['is_checkout_state']) ? $xvalue['is_checkout_state'] : "";
                                                                $is_checkout_state = '1';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_checkout_state"
                                                                           id="is_checkout_state" value="1"
                                                                           class="custom-control-input" <?php if ($is_checkout_state == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_checkout_state"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_checkout_state'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Checkout City'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_checkout_city = isset($xvalue['is_checkout_city']) ? $xvalue['is_checkout_city'] : "";
                                                                $is_checkout_city = '1';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_checkout_city"
                                                                           id="is_checkout_city" value="1"
                                                                           class="custom-control-input" <?php if ($is_checkout_city == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_checkout_city"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_checkout_city'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Checkout Zip'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_checkout_zip = isset($xvalue['is_checkout_zip']) ? $xvalue['is_checkout_zip'] : "";
                                                                $is_checkout_zip = '1';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_checkout_zip"
                                                                           id="is_checkout_zip" value="1"
                                                                           class="custom-control-input" <?php if ($is_checkout_zip == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_checkout_zip"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_checkout_zip'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Checkout Email'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_checkout_email = isset($xvalue['is_checkout_email']) ? $xvalue['is_checkout_email'] : "";
                                                                $is_checkout_email = '1';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_checkout_email"
                                                                           id="is_checkout_email" value="1"
                                                                           class="custom-control-input" <?php if ($is_checkout_email == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_checkout_email"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_checkout_email'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="form-group">
                                                                <label for=""><?php echo $this->lang->line('Checkout Phone'); ?></label>
                                                                <br>
                                                                <?php
                                                                $is_checkout_phone = isset($xvalue['is_checkout_phone']) ? $xvalue['is_checkout_phone'] : "";
                                                                $is_checkout_phone = '1';
                                                                ?>
                                                                <label class="custom-switch mt-2">
                                                                    <input type="checkbox" name="is_checkout_phone"
                                                                           id="is_checkout_phone" value="1"
                                                                           class="custom-control-input" <?php if ($is_checkout_phone == '1') echo 'checked'; ?>>
                                                                    <label class="custom-control-label mr-1"
                                                                           for="is_checkout_phone"></label>
                                                                    <span><?php echo $this->lang->line('Enable'); ?></span>
                                                                    <span class="text-danger"><?php echo form_error('is_checkout_phone'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <div class="card collapse-header <?php if ($xdata2['page_id'] == 0) echo 'd-none'; ?>">
                                <div id="heading8" class="card-header" data-toggle="collapse" role="button"
                                     data-target="#accordion8"
                                     aria-expanded="false" aria-controls="accordion8">
                                    <span class="collapse-title"><?php echo $this->lang->line("Assign Labels"); ?></span>
                                </div>
                                <div id="accordion8" role="tabpanel" data-parent="#accordionWrapa1"
                                     aria-labelledby="heading8" class="collapse">
                                    <div class="card-body p-0">
                                        <div class="card">
                                            <div class="card-footer p-2" style="border:1px solid #e4e6fc;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group mb-2">
                                                            <label for="assign_labels"><?php echo $this->lang->line('Choose Labels (Labels will be assigned to the subscribers after successfull checkout.)'); ?></label>
                                                            <select name="assign_labels[]" id="assign_labels" multiple
                                                                    class="form-control w-100 select2"
                                                                    style="width:100%">
                                                                <?php foreach ($page_labels as $label) {
                                                                    $selected_label = '';
                                                                    $xlabel_ids = explode(",", $xdata2['label_ids']);
                                                                    if (in_array($label['id'], $xlabel_ids)) $selected_label = 'selected';
                                                                    ?>

                                                                    <option value="<?php echo $label['id'] ?>" <?php echo $selected_label; ?>><?php echo $label['group_name'] ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="card-footer p-0">

                        <?php
                        if ($this->session->flashdata('error_message') == 1)
                            echo "<div class='alert alert-danger text-center'><i class='bx bx-time-circle'></i> " . $this->lang->line("You must select at least one checkout payment option.") . "</div><br>";
                        ?>
                        <?php
                        if ($this->session->flashdata('error_message2') == 1)
                            echo "<div class='alert alert-danger text-center'><i class='bx bx-time-circle'></i> " . $this->lang->line("You cannot disable both store pickup and home delivery.") . "</div><br>";
                        ?>
                        <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>



