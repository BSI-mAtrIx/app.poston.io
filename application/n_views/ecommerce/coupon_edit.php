<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 1;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
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

<?php $this->load->view('admin/theme/message'); ?>

<div class="row">
    <div class="col-12">

        <form class="form-horizontal" action="<?php echo site_url() . 'ecommerce/edit_coupon_action'; ?>" method="POST">
            <input type="hidden" name="hidden_id" value="<?php echo $xdata['id']; ?>">
            <div class="card shadow-none">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <?php $default_store = set_value('store_id') != '' ? set_value('store_id') : $xdata['store_id']; ?>
                                <label for="name"> <?php echo $this->lang->line("Store") ?> *</label>
                                <?php echo form_dropdown('store_id', $store_list, $default_store, 'disabled class="select2 form-control" id="store_id"'); ?>
                                <span class="text-danger"><?php echo form_error('store_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name"> <?php echo $this->lang->line("Products") ?> <a href="#"
                                                                                                  data-placement="top"
                                                                                                  data-toggle="popover"
                                                                                                  data-trigger="focus"
                                                                                                  title="<?php echo $this->lang->line("Products"); ?>"
                                                                                                  data-content="<?php echo $this->lang->line("Choose products you want to apply this coupon, selecting no product means it will apply for all."); ?>"><i
                                                class='bx bx-info-circle'></i> </a></label>
                                <div id="product_con">
                                    <?php echo form_dropdown('product_ids[]', array(), '', 'multiselect class="select2 form-control" id="product_ids"'); ?>
                                </div>
                                <span class="text-danger"><?php echo form_error('product_ids'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="coupon_type"> <?php echo $this->lang->line('Coupon Type'); ?> *</label>
                                <div class="custom-switches-stacked mt-2">
                                    <div class="row">
                                        <?php
                                        $i = 0;
                                        foreach ($coupon_type_list as $key => $value) {
                                            $i++;
                                            if (set_value('coupon_type') != '' && $value == set_value('coupon_type')) $checked = "checked";
                                            else if ($value == $xdata['coupon_type']) $checked = "checked";
                                            else $checked = "";
                                            ?>
                                            <div class="col-4">
                                                <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="radio" name="coupon_type"
                                                           id="coupon_type_<?php echo $value; ?>"
                                                           value="<?php echo $value; ?>" <?php echo $checked; ?>
                                                           class="coupon_type custom-control-input">
                                                    <label class="custom-control-label mr-1"
                                                           for="coupon_type_<?php echo $value; ?>"></label>
                                                    <span><?php echo $this->lang->line(ucfirst($value)); ?></span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('coupon_type'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="coupon_code"> <?php echo $this->lang->line("Coupon Code") ?> *</label>
                                <input name="coupon_code"
                                       value="<?php echo (set_value('coupon_code') != '') ? set_value('coupon_code') : $xdata['coupon_code']; ?>"
                                       class="form-control" type="text">
                                <span class="text-danger"><?php echo form_error('coupon_code'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="coupon_amount"><?php echo $this->lang->line("Coupon Amount") ?> *</label>
                                <input name="coupon_amount"
                                       value="<?php echo (set_value('coupon_amount') != '') ? set_value('coupon_amount') : $xdata['coupon_amount']; ?>"
                                       class="form-control" type="text">
                                <span class="text-danger"><?php echo form_error('coupon_amount'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="hidden">
                        <div class="col-12 col-md-6">
                            <?php $expired_date_default = $xdata['expiry_date'];
                            ?>
                            <div class="form-group">
                                <label for="expiry_date"> <?php echo $this->lang->line("Expiry Date") ?> *</label>
                                <input name="expiry_date"
                                       value="<?php echo (set_value('expiry_date') != "") ? set_value('expiry_date') : $expired_date_default; ?>"
                                       class="form-control datepicker_x" type="text">
                                <span class="text-danger"><?php echo form_error('expiry_date'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="max_usage_limit"><?php echo $this->lang->line("Max Usage Limit") ?> </label>
                                <input name="max_usage_limit"
                                       value="<?php echo (set_value('max_usage_limit') != '') ? set_value('max_usage_limit') : $xdata['max_usage_limit']; ?>"
                                       class="form-control" type="number" min='0'>
                                <span class="text-danger"><?php echo form_error('max_usage_limit'); ?></span>
                            </div>
                        </div>
                    </div>


                    <?php
                    $checked2 = '';
                    if (validation_errors() && set_value('status') == '1') $checked2 = "checked";
                    else if ($xdata['status'] == '1') $checked2 = "checked";

                    $checked3 = '';
                    if (validation_errors() && set_value('free_shipping_enabled') == '1') $checked3 = "checked";
                    else if ($xdata['free_shipping_enabled'] == '1') $checked3 = "checked";
                    ?>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="status"> <?php echo $this->lang->line('Status'); ?> *</label><br>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="status" id="status" value="1"
                                           class="custom-control-input" <?php echo $checked2; ?>>
                                    <label class="custom-control-label mr-1" for="status"></label>
                                    <span><?php echo $this->lang->line('Active'); ?></span>
                                    <span class="text-danger"><?php echo form_error('status'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="free_shipping_enabled"> <?php echo $this->lang->line('Free Shipping?'); ?></label><br>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="free_shipping_enabled" id="free_shipping_enabled"
                                           value="1" class="custom-control-input" <?php echo $checked3; ?>>
                                    <label class="custom-control-label mr-1" for="free_shipping_enabled"></label>
                                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                                    <span class="text-danger"><?php echo form_error('free_shipping_enabled'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Coupon apply'); ?> *</label>
                                <?php
                                $select_lan = $xdata['coupon_apply'];
                                $options = array();
                                $options['sale_price'] = $this->lang->line('Apply for SALE price');
                                $options['original_price'] = $this->lang->line('Apply for ORIGINAL price');
                                $options['no_discount_sale'] = $this->lang->line('No discount for SALE price');



                                echo form_dropdown('coupon_apply', $options, $select_lan, 'class="select2 form-control" id="sale_price"'); ?>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="card-footer p-0">
                    <button name="submit" type="submit" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <button type="button" class="btn btn-secondary float-right"
                            onclick='goBack("ecommerce/coupon_list",0)'><i class="bx bx-trash"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
if (validation_errors()) $xproduct_ids = is_array(set_value('product_ids')) ? set_value('product_ids') : array();
else $xproduct_ids = ($xdata['product_ids'] == '0') ? array() : explode(',', $xdata['product_ids']);
?>
