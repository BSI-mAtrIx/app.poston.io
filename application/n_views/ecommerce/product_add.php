<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 1;
$include_cropper = 1;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$jodit = 1;
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

<?php
$config_currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
$config_currency_icon = isset($this->currency_icon[$config_currency]) ? $this->currency_icon[$config_currency] : "$";
?>

<div class="row">
    <div class="col-12">

        <form class="form-horizontal" action="<?php echo site_url() . 'ecommerce/add_product_action'; ?>" method="POST">
            <input type="hidden" id="store_id" name="store_id"
                   value="<?php echo $this->session->userdata("ecommerce_selected_store"); ?>">
            <input type="hidden" id="store_type" name="store_type" value="<?php echo $store_type; ?>">
            <div class="card shadow-none">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="product_name"> <?php echo $this->lang->line("Product name") ?> *</label>
                                <input name="product_name" value="<?php echo set_value('product_name'); ?>"
                                       class="form-control" type="text">
                                <span class="text-danger"><?php echo form_error('product_name'); ?></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="form-group">
                                <label for="original_price"> <?php echo $this->lang->line("Original price") ?> *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $config_currency_icon; ?></span>
                                    </div>
                                    <input name="original_price" value="<?php echo set_value('original_price'); ?>"
                                           class="form-control" type="text">
                                </div>
                                <span class="text-danger"><?php echo form_error('original_price'); ?></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="form-group">
                                <label for="sell_price"> <?php echo $this->lang->line("Sell price") ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Sell Price"); ?>"
                                       data-content="<?php echo $this->lang->line("Put offer price if it is on sale"); ?>"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $config_currency_icon; ?></span>
                                    </div>
                                    <input name="sell_price" value="<?php echo set_value('sell_price'); ?>"
                                           class="form-control" type="text">
                                </div>
                                <span class="text-danger"><?php echo form_error('sell_price'); ?></span>
                            </div>
                        </div>
                    </div>

                    <?php if ($this->is_ecommerce_related_product_addon_exist) : ?>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="name"> <?php echo $this->lang->line("Related Products") ?></label>
                                    <?php echo form_dropdown('related_product_ids[]', $product_lists, set_value('related_product_ids'), 'class="form-control select2" multiple="multiple" id="related_product_ids"'); ?>
                                </div>
                                <span class="red"><?php echo form_error('related_product_ids'); ?></span>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="name"> <?php echo $this->lang->line("Upsell Product") ?></label>
                                    <?php echo form_dropdown('upsell_product_id', $product_list, set_value('upsell_product_id'), 'class="form-control select2" id="upsell_product_id"'); ?>
                                </div>
                                <span class="red"><?php echo form_error('upsell_product_id'); ?></span>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="name"> <?php echo $this->lang->line("Downsell Product") ?></label>
                                    <?php echo form_dropdown('downsell_product_id', $product_list, set_value('downsell_product_id'), 'class="form-control select2" id="downsell_product_id"'); ?>
                                </div>
                                <span class="red"><?php echo form_error('downsell_product_id'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12 col-md-4 d-none">
                            <div class="form-group">
                                <label for="name"> <?php echo $this->lang->line("Store") ?> *</label>
                                <?php echo form_dropdown('', $store_list, $this->session->userdata("ecommerce_selected_store"), 'disabled class="select2 form-control"'); ?>
                                <span class="text-danger"><?php echo form_error('store_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="name"> <?php echo $this->lang->line("Category") ?></label>
                                <?php echo form_dropdown('category_id', $category_list, set_value('category_id'), 'class="select2 form-control" id="category_id"'); ?>
                            </div>
                            <span class="text-danger"><?php echo form_error('category_id'); ?></span>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Attributes'); ?></label>
                                <?php echo form_dropdown('attribute_ids[]', $attribute_list, set_value('attribute_ids'), 'class="select2 form-control" id="attribute_ids" multiple'); ?>
                                <span class="text-danger"><?php echo form_error('attribute_ids'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="product_video_id"> <?php echo $this->lang->line("Product Video") ?>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Product Video"); ?>"
                                       data-content="<?php echo $this->lang->line("Provide YouTube Video id"); ?>"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input name="product_video_id" value="<?php echo set_value('product_video_id'); ?>"
                                       class="form-control" type="text"
                                       placeholder="<?php echo $this->lang->line("Provide YouTube Video id"); ?>">
                                <span class="red"><?php echo form_error('product_video_id'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2" id="attribute_values">
                    </div>


                    <div class="row mt-1">
                        <div class="col-12 col-md-12 product_desc">
                            <div class="form-group">
                                <label for="product_description"> <?php echo $this->lang->line("Product description") ?></label>
                                <textarea name="product_description"
                                          class="form-control product_description"><?php echo set_value('product_description'); ?></textarea>
                                <span class="text-danger"><?php echo form_error('product_description'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 purchase_no_before">
                            <div class="form-group">
                                <label for="purchase_note"> <?php echo $this->lang->line("Purchase note") ?></label>
                                <textarea name="purchase_note"
                                          class="form-control purchase_note"><?php echo set_value('purchase_note'); ?></textarea>
                                <span class="text-danger"><?php echo form_error('purchase_note'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Thumbnail'); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Thumbnail"); ?>"
                                       data-content="<?php echo $this->lang->line("Maximum: 1MB, Format: JPG/PNG, Preference: Square image, Recommended dimension : 500x500"); ?>"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div id="thumb-dropzone" class="dropzone mb-1">
                                    <div class="dz-default dz-message">
                                        <input class="form-control" name="thumbnail" id="uploaded-file" type="hidden">
                                        <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                          style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('thumbnail'); ?></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Featured  Images'); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Featured  Images"); ?>"
                                       data-content="<?php echo $this->lang->line("Upto 3 images, Maximum: 1MB each, Format: JPG/PNG, Preference: Square image, Recommended dimension : 500x500"); ?>"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div id="feature-dropzone" class="dropzone mb-1">
                                    <div class="dz-default dz-message">
                                        <input class="form-control" name="featured_images" id="featured-uploaded-file"
                                               type="hidden">
                                        <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                          style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('featured_images'); ?></span>
                            </div>
                        </div>

                        <?php if (isset($store_type) && $store_type == 'digital') : ?>
                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Upload Product'); ?>
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Product File"); ?>"
                                           data-content="<?php echo $this->lang->line("Upload your product file here."); ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <div id="product-file-dropzone" class="dropzone mb-1">
                                        <div class="dz-default dz-message">
                                            <input class="form-control" name="product_file" id="uploaded-product-file"
                                                   type="hidden">
                                            <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                              style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                        </div>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('product_file'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php

                    $checked2 = "checked";
                    if (validation_errors()) {
                        if (set_value('status') == '1') $checked2 = "checked";
                        else $checked2 = "";
                    }
                    $checked3 = "checked";
                    if (validation_errors()) {
                        if (set_value('taxable') == '1') $checked3 = "checked";
                        else $checked3 = "";
                    }
                    $checked4 = "";
                    if (validation_errors()) {
                        if (set_value('stock_display') == '1') $checked4 = "checked";
                        else $checked4 = "";
                    }
                    $checked5 = "";
                    if (validation_errors()) {
                        if (set_value('stock_prevent_purchase') == '1') $checked5 = "checked";
                        else $checked5 = "";
                    }
                    ?>

                    <?php if (isset($store_type) && $store_type == 'physical') : ?>
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <?php $default_stock_item = set_value('stock_item') != '' ? set_value('stock_item') : 0; ?>
                                    <label for="status"> <?php echo $this->lang->line('Item in stock'); ?> *</label><br>
                                    <input name="stock_item" value="<?php echo $default_stock_item; ?>"
                                           class="form-control" type="number" min="0">
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label for="stock_display"> <?php echo $this->lang->line('Display stock'); ?>
                                        *</label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="stock_display" id="stock_display" value="1"
                                               class="custom-control-input" <?php echo $checked4; ?>>
                                        <label class="custom-control-label mr-1" for="stock_display"></label>
                                        <span><?php echo $this->lang->line('Yes'); ?></span>
                                        <span class="text-danger"><?php echo form_error('stock_display'); ?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label for="stock_prevent_purchase"> <?php echo $this->lang->line('Prevent purchase if out of stock'); ?>
                                        *</label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="stock_prevent_purchase" id="stock_prevent_purchase"
                                               value="1" class="custom-control-input" <?php echo $checked5; ?>>
                                        <label class="custom-control-label mr-1" for="stock_prevent_purchase"></label>
                                        <span><?php echo $this->lang->line('Yes'); ?></span>
                                        <span class="text-danger"><?php echo form_error('stock_prevent_purchase'); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $system_is_preparation_time = isset($ecommerce_config['is_preparation_time']) ? $ecommerce_config['is_preparation_time'] : "0";
                    $system_preparation_time = isset($ecommerce_config['preparation_time']) ? $ecommerce_config['preparation_time'] : "";
                    $system_preparation_time_unit = isset($ecommerce_config['preparation_time_unit']) ? $ecommerce_config['preparation_time_unit'] : "";
                    ?>

                    <div class="row <?php if ($system_is_preparation_time == '0') echo 'd-none'; ?>">
                        <div class="col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("Preparation time"); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $this->lang->line("Time"); ?></span>
                                    </div>
                                    <?php
                                    $arr = array
                                    (
                                        '' => $this->lang->line('Time unit'),
                                        'minutes' => $this->lang->line('minutes'),
                                        'hours' => $this->lang->line('Hours'),
                                        'days' => $this->lang->line('Days')
                                    );
                                    ?>
                                    <input type="text"
                                           placeholder="<?php echo $this->lang->line('example : 10 or 10-15'); ?>"
                                           name="preparation_time" class="form-control"
                                           value="<?php echo $system_preparation_time; ?>">
                                    <?php echo form_dropdown('preparation_time_unit', $arr, $system_preparation_time_unit, "class='form-control'"); ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6 col-md-4">
                            <div class="form-group">
                                <label for="status"> <?php echo $this->lang->line('Status'); ?> *</label><br>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="status" id="status" value="1"
                                           class="custom-control-input" <?php echo $checked2; ?>>
                                    <label class="custom-control-label mr-1" for="status"></label>
                                    <span><?php echo $this->lang->line('Online'); ?></span>
                                    <span class="text-danger"><?php echo form_error('status'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="form-group">
                                <label for="taxable"> <?php echo $this->lang->line('Taxable'); ?> *</label><br>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="taxable" id="taxable" value="1"
                                           class="custom-control-input" <?php echo $checked3; ?>>
                                    <label class="custom-control-label mr-1" for="taxable"></label>
                                    <span><?php echo $this->lang->line('Yes'); ?></span>
                                    <span class="text-danger"><?php echo form_error('taxable'); ?></span>
                                </label>
                            </div>
                        </div>


                        <?php if ($this->basic->is_exist('add_ons', array('unique_name' => 'ecommerce_related_products'))
                            && $this->basic->is_exist("modules", array("id" => 317))) : ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin'
                                || in_array(317, $this->module_access)) : ?>
                                <div class="col-6 col-md-4">
                                    <div class="form-group">
                                        <label for="is_featured"> <?php echo $this->lang->line('Featured'); ?></label><br>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="is_featured" value="1"
                                                   class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Yes'); ?></span>
                                            <span class="red"><?php echo form_error('is_featured'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>


                </div>

                <div class="card-footer p-0" style="margin-bottom: 200px">
                    <button name="submit" type="submit" class="btn btn-primary" onclick="beforeSubmit();"><i
                                class="bx bxs-save"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <button type="button" class="btn btn-secondary float-right"
                            onclick='goBack("ecommerce/product_list",0)'><i class="bx bx-trash"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
                </div>
            </div>
        </form>
    </div>
</div>


<style type="text/css">
    .dropzone {
        min-height: 150px !important;
    }

    .dropzone .dz-message {
        margin: 2em !important;
    }
</style>


<style type="text/css">

    .card .card-header {
        line-height: 30px;
        min-height: 0px;
        padding: 5px 25px;
    }

    .card .card-header h4 {
        font-size: 13px;
    }

    .attribute_values_body {
        padding-bottom: 0px;
    }

    .attribute_values_body .form-control {
        height: 30px !important;
        line-height: 30px !important;
    }

    .attribute_values_body .form-control:not(.form-control-sm):not(.form-control-lg) {
        padding: 0 5px !important;
    }

    .form-group {
        margin-bottom: 15px;
    }
</style>