<style>
    .row-actions{display:none;}
    tr:hover .row-actions{display:block;}
</style>
<?php
    $include_datatable = 1;
    $include_select2 = 1;

    $get_plan =  function($value) use ($default_plan){
        $nvalue = explode('.', $value);

        if(isset($nvalue[1])){
            if(isset($default_plan[$nvalue[0]][$nvalue[1]])){
                if(isset($nvalue[2]) AND isset($default_plan[$nvalue[0]][$nvalue[1]][$nvalue[2]])){
                    if(isset($nvalue[3]) AND isset($default_plan[$nvalue[0]][$nvalue[1]][$nvalue[2]][$nvalue[3]])){
                        return $default_plan[$nvalue[0]][$nvalue[1]][$nvalue[2]][$nvalue[3]];
                    }
                    return $default_plan[$nvalue[0]][$nvalue[1]][$nvalue[2]];
                }
                return $default_plan[$nvalue[0]][$nvalue[1]];
            }
        }
    };


?>

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>price/plan_list"><?php echo $this->lang->line('Dynamic Price Plan Configuration'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<form action="<?php echo base_url('price/save_plan/'.$id_plan); ?>" id="plugin_form" method="POST">
<div class="section-body">

    <div class="fixed-top content mt-5 " style="position:fixed!important; min-height: initial!important;">
        <div class="card p-0">
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-8">

                            <div class="row">
                                <fieldset class="form-group col-3">
                                    <label for="gen_min_value_select">min_value_select</label>
                                    <input type="text" class="form-control" id="gen_min_value_select">
                                </fieldset>
                                <fieldset class="form-group col-3">
                                    <label for="gen_price_1_per_unit">Price_1_per_unit</label>
                                    <input type="text" class="form-control" id="gen_price_1_per_unit">
                                </fieldset>
                                <fieldset class="form-group col-3">
                                    <label for="gen_price_2_per_unit">Price_2_per_unit</label>
                                    <input type="text" class="form-control" id="gen_price_2_per_unit">
                                </fieldset>
                                <fieldset class="mt-2 col-3">
                                    <div class="checkbox">
                                        <input type="checkbox" class="checkbox-input" id="gen_is_unlimited" value="1">
                                        <label for="gen_is_unlimited">is_unlimited</label>
                                    </div>
                                </fieldset>
                            </div>
                            <textarea id="result_price_config_gen" style="width:100%">min_value_select</textarea>


                    </div>
                    <div class="col-4 text-center mt-3">
                        <button class="btn btn-primary"><?php echo $this->lang->line('SAVE');?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $this->lang->line("Dynamic Price Plans"); ?></h5>
                </div>
                <div class="card-body">
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">


                        <fieldset>
                            <label for="plan_name"><?php echo $this->lang->line('Package Name (only for admin, when fixed price not applied)'); ?></label>
                            <div class="input-group">
                                <input type="text" id="plan_name" name="plan_name"
                                       class="form-control" value="<?php echo $default_settings['plan_name'];?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('plan_name'); ?></span>
                        </fieldset>

                        <div class="row">
                            <div class="col-3">
                                <fieldset>
                                    <label for="period_1_value"><?php echo $this->lang->line('Period 1 value'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="period_1_value" name="period_1_value"
                                               class="form-control" value="<?php echo $default_settings['period_1_value'];?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('period_1_value'); ?></span>
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="period_1_type"><?php echo $this->lang->line('Period 1 Type'); ?></label>
                                    <?php echo form_dropdown('period_1_type', $period_type, $default_settings['period_1_type'], ['id' => 'paid-period_1_type', 'class' => 'form-control select2', 'style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="col-3">
                                <fieldset>
                                    <label for="period_1_price_fixed"><?php echo $this->lang->line('Period 1 fixed price'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="period_1_price_fixed" name="period_1_price_fixed"
                                               class="form-control" value="<?php echo $default_settings['period_1_price_fixed'];?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('period_1_price_fixed'); ?></span>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <fieldset>
                                    <label for="period_2_value"><?php echo $this->lang->line('Period 2 value'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="period_2_value" name="period_2_value"
                                               class="form-control" value="<?php echo $default_settings['period_2_value'];?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('period_2_value'); ?></span>
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="period_2_type"><?php echo $this->lang->line('Period 2 Type'); ?></label>
                                    <?php echo form_dropdown('period_2_type', $period_type, $default_settings['period_2_type'], ['id' => 'paid-period_2_type', 'class' => 'form-control select2', 'style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="col-3">
                                <fieldset>
                                    <label for="period_2_price_fixed"><?php echo $this->lang->line('Period 2 fixed price'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="period_2_price_fixed" name="period_2_price_fixed"
                                               class="form-control" value="<?php echo $default_settings['period_2_price_fixed'];?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('period_2_price_fixed'); ?></span>
                                </fieldset>
                            </div>


                            <div class="col-6">
                                <div class="form-group">
                                    <label for="currency"><?php echo $this->lang->line("Currency"); ?></label>
                                    <?php
                                    $default_currency = isset($default_settings['currency']) ? $default_settings['currency'] : "USD";
                                    ?>
                                    <select name='currency' id='currency' class='select2 form-control'>
                                        <?php
                                        foreach ($currency_list_all as $key => $value) {
                                            $paypal_supported = in_array($key, $currency_list_all) ? " - PayPal & Stripe" : "";
                                            if ($default_currency == $key) $selected_curr = "selected='selected'";
                                            else $selected_curr = '';
                                            echo '<option value="' . $key . '" ' . $selected_curr . ' >' . str_replace('And', '&', ucwords($value)) . $paypal_supported . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('currency'); ?></span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="payment_methods"><?php echo $this->lang->line("Payment Methods"); ?></label>
                                    <select multiple name='payment_methods[]' id='payment_methods' class='select2 form-control'>
                                        <?php
                                        foreach ($payments_list as $key => $value) {
                                            echo '<option value="' . $key . '">' . $value  . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('payment_methods'); ?></span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="country_restriction"><?php echo $this->lang->line("Country Restriction (works only with IP detection ON (NVX Theme settings))"); ?></label>
                                    <select multiple name='country_restriction' id='country_restriction' class='select2 form-control'>
                                        <?php
                                        foreach ($country_list as $key => $value) {
                                            if ($default_currency == $key) $selected_curr = "selected='selected'";
                                            else $selected_curr = '';
                                            echo '<option value="' . $key . '" ' . $selected_curr . ' >' . $value  . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('country_restriction'); ?></span>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fixed_plan"> <?php echo $this->lang->line('Fixed Plan'); ?></label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="fixed_plan" id="fixed_plan" value="1"
                                               class="custom-control-input" <?php if ($default_settings['fixed_plan'] == 1) echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="fixed_plan"></label>
                                        <span><?php echo $this->lang->line('Fixed'); ?></span>
                                        <span class="text-danger"><?php echo form_error('fixed_plan'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status"> <?php echo $this->lang->line('Status'); ?></label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="status" id="status" value="1"
                                               class="custom-control-input" <?php if ($default_settings['status'] == 1) echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="status"></label>
                                        <span><?php echo $this->lang->line('Active'); ?></span>
                                        <span class="text-danger"><?php echo form_error('status'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="highlight"> <?php echo $this->lang->line('Highlight'); ?></label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="highlight" id="highlight" value="1"
                                               class="custom-control-input" <?php if ($default_settings['highlight'] == 1) echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="highlight"></label>
                                        <span><?php echo $this->lang->line('Active'); ?></span>
                                        <span class="text-danger"><?php echo form_error('highlight'); ?></span>
                                    </label>
                                </div>
                            </div>


                            <div class="col-6">
                                <fieldset>
                                    <label for="dporder"><?php echo $this->lang->line('Order package (apply for fixed plan)'); ?></label>
                                    <div class="input-group">
                                        <input type="number" id="dporder" name="dporder"
                                               class="form-control" value="<?php echo $default_settings['dporder']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('dporder'); ?></span>
                                </fieldset>
                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <strong><?php echo $this->lang->line('This settings apply to collect data for invoice from client'); ?>:</strong>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="vat_collect"> <?php echo $this->lang->line('Collect data for invoice'); ?></label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="vat_collect" id="vat_collect" value="1"
                                               class="custom-control-input" <?php if ($default_settings['vat_collect'] == 1) echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="vat_collect"></label>
                                        <span><?php echo $this->lang->line('ON'); ?></span>
                                        <span class="text-danger"><?php echo form_error('vat_collect'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="vat_included"> <?php echo $this->lang->line('Price has included VAT'); ?></label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="vat_included" id="vat_included" value="1"
                                               class="custom-control-input" <?php if ($default_settings['vat_included'] == 1) echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="vat_included"></label>
                                        <span><?php echo $this->lang->line('ON'); ?></span>
                                        <span class="text-danger"><?php echo form_error('vat_included'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-6 d-none">
                                <fieldset>
                                    <label for="vat_value"><?php echo $this->lang->line('VAT % for plan/zone'); ?></label>
                                    <div class="input-group">
                                        <input type="number" id="vat_value" name="vat_value"
                                               class="form-control" value="<?php echo $default_settings['vat_value']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('vat_value'); ?></span>
                                </fieldset>
                            </div>



                            <div class="col-6">
                                <div class="form-group">
                                    <label for="vat_check_eu"> <?php echo $this->lang->line('Check for EU VAT and set VAT to 0%'); ?></label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="vat_check_eu" id="vat_check_eu" value="1"
                                               class="custom-control-input" <?php if ($default_settings['vat_check_eu'] == 1) echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="vat_check_eu"></label>
                                        <span><?php echo $this->lang->line('ON'); ?></span>
                                        <span class="text-danger"><?php echo form_error('vat_check_eu'); ?></span>
                                    </label>
                                </div>
                            </div>

                        </div>






                    <p><?php echo $this->lang->line('Schema for configuration dynamic price'); ?>: <br />
                        <strong>min_value_selected;Price_1_per_unit;Price_2_per_unit;is_unlimited</strong> <br />
                        <?php echo $this->lang->line('min_value_selected - min value 0, example: 5 is set, then price apply to min 5 accounts facebook accounts'); ?> <br />
                        <?php echo $this->lang->line('Price_1_per_unit - min value 0, apply for period 1, example: 5 is set, then 5 facebook account x 5 price, total 25 [currency]. Only supported dot for cents like 0.00'); ?><br />
                        <?php echo $this->lang->line('Price_2_per_unit - min value 0, apply for period 2, example: 5 is set, then 5 facebook account x 5 price, total 25 [currency]. Only supported dot for cents like 0.00'); ?><br />
                        <?php echo $this->lang->line('is_unlimited - 0 or 1, if set 1 then all counts up than min_value_selected is package unlimited, example: min_value_selected=25, if user select more than 25 is unlimited option (fixed price, not count as per unit)'); ?>
                    </p>

                    <div class="row">
                    <?php

                    include(APPPATH.'modules/n_theme/views/edit_parts/content_generator.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/credits.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/social_posting.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/twitter_posting.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/comment_automation.php');

                    include(APPPATH.'modules/n_theme/views/edit_parts/ecommerce.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/email_sending.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/facebook.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/google.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/messenger.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/sms.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/telegram.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/whatsapp.php');


                    include(APPPATH.'modules/n_theme/views/edit_parts/meta_ads.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/utility.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/hidden_interests.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/landing_page.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/website_builder.php');
                    include(APPPATH.'modules/n_theme/views/edit_parts/image_editor.php');


                    ?>




                    </div>

                </div>
            </div>
</div>
</form>