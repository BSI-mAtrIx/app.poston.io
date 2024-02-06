<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 1;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
?>


<div id="put_script"></div>


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

<div class="section-body">
    <form action="#" enctype="multipart/form-data" id="plugin_form">
        <div class="row">
            <div class="col-12">
                <div class="card main_card shadow-none">
                    <div class="card-body p-0">
                        <div class="row">

                            <?php if ($this->basic->is_exist("add_ons", array("unique_name" => "ecommerce_digital_product")) && $this->basic->is_exist("modules", array("id" => 316))) : ?>
                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(316, $this->module_access)) : ?>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Store Type") ?> *</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="custom-switch">
                                                    <input type="radio" name="store_type" value="physical"
                                                           id="store_type" class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"><?php echo $this->lang->line('Physical'); ?></span>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="custom-switch">
                                                    <input type="radio" name="store_type" value="digital"
                                                           id="store_type" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"><?php echo $this->lang->line('Digital'); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Select page"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Select page") ?>"
                                       data-content='<?php echo $this->lang->line("Select your Facebook page for which you want to create the store.") . $this->lang->line("Skip selecting page if you plan to use this store outside Messenger.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <?php $page_info[0] = $this->lang->line("None"); ?>
                                <?php echo form_dropdown('page', $page_info, '0', 'class="select2 form-control" id="page" style="width:100%;"'); ?>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Store name"); ?> *
                                </label>
                                <input type="text" name="store_name" id="store_name" class="form-control">
                            </div>

                            <div class="form-group col-6 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Email"); ?> *
                                </label>
                                <input type="email" name="store_email" id="store_email" class="form-control">
                            </div>

                            <div class="form-group col-6 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Mobile/phone"); ?>
                                </label>
                                <input type="text" name="store_phone" id="store_phone" class="form-control">
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label>
                                    <?php echo $this->lang->line("Country"); ?> *
                                </label>
                                <?php
                                $country_names[''] = $this->lang->line("Select");
                                echo form_dropdown('store_country', $country_names, '', 'class="select2 form-control" id="store_country" style="width:100%;"');
                                ?>
                            </div>

                            <div class="form-group col-6 col-md-4">
                                <label>
                                    <?php echo $this->lang->line("State"); ?> *
                                </label>
                                <input type="text" name="store_state" id="store_state" class="form-control">
                            </div>

                            <div class="form-group col-6 col-md-4">
                                <label>
                                    <?php echo $this->lang->line("City"); ?> *
                                </label>
                                <input type="text" name="store_city" id="store_city" class="form-control">
                            </div>

                            <div class="form-group col-12 col-md-8">
                                <label>
                                    <?php echo $this->lang->line("Street address"); ?> *
                                </label>
                                <input type="text" name="store_address" id="store_address" class="form-control">
                            </div>

                            <div class="form-group col-6 col-md-2">
                                <label>
                                    <?php echo $this->lang->line("Postal code"); ?> *
                                </label>
                                <input type="text" name="store_zip" id="store_zip" class="form-control">
                            </div>

                            <div class="form-group col-6 col-md-2">
                                <label>
                                    <?php echo $this->lang->line("Locale"); ?> *
                                </label>
                                <?php echo form_dropdown('store_locale', $locale_list, $this->language, 'class="select2 form-control" id="store_locale" style="width:100%;"'); ?>
                            </div>

                            <div class="col-12 col-md-6 d-none">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Logo'); ?>
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Logo"); ?>"
                                           data-content="<?php echo $this->lang->line("Maximum: 1MB, Format: JPG/PNG, Recommended dimension : 200x50"); ?> / 120x120"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <div id="store-logo-dropzone" class="dropzone mb-1">
                                        <div class="dz-default dz-message">
                                            <input class="form-control" name="store_logo" id="store_logo" type="hidden">
                                            <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                              title='<?php echo $this->lang->line("Upload"); ?>'
                                                                              data-toggle="tooltip"
                                                                              style="font-size: 35px;color: #6777ef;"></i> </span>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-none">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Favicon'); ?>
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Favicon"); ?>"
                                           data-content="<?php echo $this->lang->line("Maximum: 1MB, Format: JPG/PNG, Recommended dimension : 100x100"); ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <div id="store-favicon-dropzone" class="dropzone mb-1">
                                        <div class="dz-default dz-message">
                                            <input class="form-control" name="store_favicon" id="store_favicon"
                                                   type="hidden">
                                            <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                              title='<?php echo $this->lang->line("Upload"); ?>'
                                                                              data-toggle="tooltip"
                                                                              style="font-size: 35px;color: #6777ef;"></i> </span>
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>

                            <div class="form-group col-6 col-md-6 mt-2">
                                <label>
                                    <?php echo $this->lang->line("Facebook Pixel ID"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Facebook Pixel ID"); ?>"
                                       data-content="<?php echo $this->lang->line("In Desktop Facebook Messenger, pixel tracking may not work properly as it loads in Facebook iframe."); ?>"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="pixel_id" id="pixel_id" class="form-control"
                                       placeholder="<?php echo $this->lang->line('Example : '); ?> 1123241077781024">
                            </div>

                            <div class="form-group col-6 col-md-6 mt-2">
                                <label>
                                    <?php echo $this->lang->line("Google Analytics ID"); ?>
                                </label>
                                <input type="text" name="google_id" id="google_id" class="form-control"
                                       placeholder="<?php echo $this->lang->line('Example : '); ?> UA-118292462-1">
                            </div>


                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="status"> <?php echo $this->lang->line('Status'); ?> *</label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="status" id="status" value="1"
                                               class="custom-control-input" checked>
                                        <label class="custom-control-label mr-1" for="status"></label>
                                        <span><?php echo $this->lang->line('Online'); ?></span>
                                        <span class="text-danger"><?php echo form_error('status'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <br><br>
                            <div class="form-group col-12 mt-2">
                                <label type="button" data-toggle="collapse" data-target="#collapseExample"
                                       aria-expanded="false" aria-controls="collapseExample"
                                       class="pointer text-primary" style="font-size: 14px"><b><i
                                                class="bx bx-notepad"></i> <?php echo $this->lang->line('Terms of service'); ?>
                                    </b></label>
                                <div class="collapse" id="collapseExample"><textarea name="terms_use_link"
                                                                                     class="form-control visual_editor"></textarea>
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <label type="button" data-toggle="collapse" data-target="#collapseExample2"
                                       aria-expanded="false" aria-controls="collapseExample2"
                                       class="pointer text-primary" style="font-size: 14px"><b><i
                                                class="bx bx-dollar-circle"></i> <?php echo $this->lang->line('Refund policy'); ?>
                                    </b></label>
                                <div class="collapse" id="collapseExample2"><textarea name="refund_policy_link"
                                                                                      class="form-control visual_editor"></textarea>
                                </div>
                            </div>


                            <div class="form-group col-12 col-md-8 d-none">
                                <label>
                                    <?php echo $this->lang->line("Select label"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Select label") ?>"
                                       data-content='<?php echo $this->lang->line("Will assign to this label after successful checkout.") ?> <?php echo $this->lang->line("You must select page to fill this list with data."); ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php echo form_dropdown('label_ids[]', array(), '', 'style="height:45px;overflow:hidden;width:100%;" multiple="multiple" class="select2 form-control" id="label_ids"'); ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-none">
                    <div class="card-footer p-0">
                        <button class="btn btn-primary" id="get_button" name="get_button" type="button"><i
                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Store"); ?>
                        </button>
                        <button class="btn btn-light float-right" onclick="ecommerceGoBack()" type="button"><i
                                    class="bx bx-time"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>


<?php include(APPPATH . 'n_views/ecommerce/store_style.php'); ?>
