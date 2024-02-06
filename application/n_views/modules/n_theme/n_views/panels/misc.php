<div class="card shadow-none bg-transparent panel_dis" style="display:block;" data-panel="misc_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Miscellaneous") ?>
        </h4>
    </div>

    <?php
    $id_header = 'accordionMisc1';
    $controls_header = 'Misc';
    $i = 0;
    ?>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="<?php echo $id_header; ?>">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Store settings'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1 d-none">
                        <h6 class="text-white"><?php echo $this->lang->line("Store type"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['store_type'])) {
                                $select_lan = $n_eco_builder_config['store_type'];
                            }
                            $options = array();
                            $options['classic'] = $this->lang->line('Classic store');
                            $options['one_page'] = $this->lang->line('One page (recommend for restaurants)');

                            echo form_dropdown('store_type', $options, $select_lan, 'class="make_change form-control" id="store_type"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('store_type'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show alert after add to cart"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_alert_add_to_cart'])) {
                                $select_lan = $n_eco_builder_config['product_single_alert_add_to_cart'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('product_single_alert_add_to_cart', $options, $select_lan, 'class="make_change form-control" id="product_single_alert_add_to_cart"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_alert_add_to_cart'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show mini popup after add to cart"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_popup_add_to_cart'])) {
                                $select_lan = $n_eco_builder_config['product_single_popup_add_to_cart'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('product_single_popup_add_to_cart', $options, $select_lan, 'class="make_change form-control" id="product_single_popup_add_to_cart"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_popup_add_to_cart'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show / hide add to cart button"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['hide_add_to_cart'])) {
                                $select_lan = $n_eco_builder_config['hide_add_to_cart'];
                            }
                            $options = array();
                            $options['0'] = $this->lang->line('Show');
                            $options['1'] = $this->lang->line('Hide');

                            echo form_dropdown('hide_add_to_cart', $options, $select_lan, 'class="make_change form-control" id="hide_add_to_cart"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('hide_add_to_cart'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show / hide buy now button"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['hide_buy_now'])) {
                                $select_lan = $n_eco_builder_config['hide_buy_now'];
                            }
                            $options = array();
                            $options['0'] = $this->lang->line('Show');
                            $options['1'] = $this->lang->line('Hide');

                            echo form_dropdown('hide_buy_now', $options, $select_lan, 'class="make_change form-control" id="hide_buy_now"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('hide_buy_now'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="text_show_delivery_note"
                                   class="text-white"><?php echo $this->lang->line('Change text show delivery note'); ?></label>
                            <div class="input-group">
                                <input type="text" id="text_show_delivery_note" name="text_show_delivery_note"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['text_show_delivery_note']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('text_show_delivery_note'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show delivery note"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_show_delivery_note'])) {
                                $select_lan = $n_eco_builder_config['show_show_delivery_note'];
                            }
                            $options = array();
                            $options['none'] = $this->lang->line('Hide');
                            $options['show'] = $this->lang->line('Show after click');
                            $options['always_show'] = $this->lang->line('Always show');

                            echo form_dropdown('show_show_delivery_note', $options, $select_lan, 'class="make_change form-control" id="show_show_delivery_note"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_show_delivery_note'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1  text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Block ctrl + c"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['block_ctrlc'])) {
                                $select_lan = $n_eco_builder_config['block_ctrlc'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('Non block');
                            $options['true'] = $this->lang->line('Block');

                            echo form_dropdown('block_ctrlc', $options, $select_lan, 'class="make_change form-control" id="block_ctrlc"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('block_ctrlc'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Global alert when store is closed"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['closed_alert'])) {
                                $select_lan = $n_eco_builder_config['closed_alert'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('Hide');
                            $options['true'] = $this->lang->line('Show');

                            echo form_dropdown('closed_alert', $options, $select_lan, 'class="make_change form-control" id="closed_alert"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('closed_alert'); ?></span>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i++;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Buttons'); ?></span>
                </div>
                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Buy button type"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['buy_button_type'])) {
                                $select_lan = $n_eco_builder_config['buy_button_type'];
                            }
                            $options = array();
                            $options['add_to_cart'] = $this->lang->line('Add to cart');
                            $options['buy_now'] = ('Buy now');

                            echo form_dropdown('buy_button_type', $options, $select_lan, 'class="make_change form-control" id="buy_button_type"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('buy_button_type'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1  text-white pl-1 pr-1">
                        <fieldset>
                            <label for="buy_button_title"
                                   class="text-white"><?php echo $this->lang->line('Button text buy now'); ?></label>
                            <div class="input-group">
                                <input type="text" id="buy_button_title" name="buy_button_title"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['buy_button_title']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('buy_button_title'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary  text-white pl-1 pr-1">
                        <fieldset>
                            <label for="add_to_cart_button_title"
                                   class="text-white"><?php echo $this->lang->line('Button text add to cart'); ?></label>
                            <div class="input-group">
                                <input type="text" id="add_to_cart_button_title" name="add_to_cart_button_title"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['add_to_cart_button_title']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('add_to_cart_button_title'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1  text-white pl-1 pr-1">
                        <fieldset>
                            <label for="store_pickup_title"
                                   class="text-white"><?php echo $this->lang->line('Store pickup text'); ?></label>
                            <div class="input-group">
                                <input type="text" id="store_pickup_title" name="store_pickup_title"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['store_pickup_title']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('store_pickup_title'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>

            <?php
            if ($this->basic->is_exist("modules", array("id" => 310))) :
                if ($this->session->userdata('user_type') == 'Admin' || in_array(310, $this->module_access)) :
                    ?>
                    <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                        <div id="<?php $i++;
                        echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                             data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>"
                             aria-expanded="false" aria-controls="<?php echo $controls_header; ?>">
                            <span class="collapse-title text-white"><?php echo $l->line('WhatsApp'); ?></span>
                        </div>
                        <div id="<?php echo $controls_header . $i; ?>" role="tabpanel"
                             data-parent="#<?php echo $id_header; ?>" aria-labelledby="heading1"
                             class="collapse bg-secondary border-top-darken-2">
                            <div class="card-body bg-secondary text-white pl-1 pr-1">
                                <h6 class="text-white"><?php echo $this->lang->line("Whatsapp Send Order Button"); ?></h6>
                                <div class="form-group">
                                    <?php
                                    $select_lan = false;
                                    if (isset($n_eco_builder_config['whatsapp_send_order_button'])) {
                                        $select_lan = $n_eco_builder_config['whatsapp_send_order_button'];
                                    }
                                    $options = array();
                                    $options['0'] = $this->lang->line('Hide');
                                    $options['1'] = $this->lang->line('Show');

                                    echo form_dropdown('whatsapp_send_order_button', $options, $select_lan, 'class="make_change form-control" id="whatsapp_send_order_button"'); ?>
                                </div>
                                <span class="text-danger"><?php echo form_error('whatsapp_send_order_button'); ?></span>
                            </div>

                            <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                                <fieldset>
                                    <label for="whatsapp_phone_number"
                                           class="text-white"><?php echo $this->lang->line('Type phone number with country code'); ?></label>
                                    <div class="input-group">
                                        <input type="number" id="whatsapp_phone_number" name="whatsapp_phone_number"
                                               class="form-control make_change"
                                               value="<?php echo $n_eco_builder_config['whatsapp_phone_number']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('whatsapp_phone_number'); ?></span>
                                </fieldset>
                            </div>

                            <div class="card-body bg-secondary text-white pl-1 pr-1">
                                <label for="whatsapp_send_order_text"
                                       class="text-white"><?php echo $l->line('Whatsapp send order text'); ?><span
                                            class="pointer"><i id="variables"
                                                               class="bx bxs-help-circle"></i></span></label>
                                <div class="row">
                                    <div class="col-12">
                                        <fieldset class="form-group">
                                            <textarea class="form-control make_change" id="whatsapp_send_order_text"
                                                      rows="10" name="whatsapp_send_order_text"
                                                      placeholder="<?php echo $l->line('AddThis JS Code URL'); ?>"><?php echo $n_eco_builder_config['whatsapp_send_order_text']; ?></textarea>
                                        </fieldset>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i++;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>"
                     aria-expanded="false" aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('OneSignal'); ?></span>
                </div>
                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel"
                     data-parent="#<?php echo $id_header; ?>" aria-labelledby="heading1"
                     class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("OneSignal Status"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['onesignal_enabled'])) {
                                $select_lan = $n_eco_builder_config['onesignal_enabled'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Enabled');
                            $options['false'] = $this->lang->line('Disabled');

                            echo form_dropdown('onesignal_enabled', $options, $select_lan, 'class="make_change form-control" id="onesignal_enabled"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('onesignal_enabled'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="onesignal_app_key"
                                   class="text-white"><?php echo $this->lang->line('OneSignal App Key'); ?></label>
                            <div class="input-group">
                                <input type="text" id="onesignal_app_key" name="onesignal_app_key"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['onesignal_app_key']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('onesignal_app_key'); ?></span>
                        </fieldset>
                    </div>

                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i++;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Before <code>&lt;/head&gt;</code>'); ?></span>
                </div>
                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p><?php echo $this->lang->line("You can add here Facebook Pixel, Google Pixel, Facebook Messenger codes. You can also put any other codes before <code>&lt;/head&gt;</code> tag. "); ?></p>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="codes_before_head" name="codes_before_head" rows="18"
                                      placeholder="Textarea" spellcheck="false"
                                      data-ms-editor="true"><?php if (!empty($codes_before_head)) {
                                    echo $codes_before_head;
                                } ?></textarea>
                        </fieldset>
                        <button class="btn btn-primary" id="save_codes_before_head" type="submit"><i
                                    class="bx bx-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <span class="text-danger"><?php echo form_error('codes_before_head'); ?></span>
                    </div>
                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i++;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Before <code>&lt;/body&gt;</code>'); ?></span>
                </div>
                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p><?php echo $this->lang->line("You can add here Facebook Pixel, Google Pixel, Facebook Messenger codes. You can also put any other codes before <code>&lt;/body&gt;</code> tag. "); ?></p>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="codes_before_body" name="codes_before_body" rows="18"
                                      placeholder="Textarea" spellcheck="false"
                                      data-ms-editor="true"><?php if (!empty($code_before_body)) {
                                    echo $code_before_body;
                                } ?></textarea>
                        </fieldset>
                        <button class="btn btn-primary" id="save_codes_before_body" type="submit"><i
                                    class="bx bx-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <span class="text-danger"><?php echo form_error('codes_before_body'); ?></span>
                    </div>
                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i++;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('SEO settings'); ?></span>
                </div>
                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">


                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <label for="site_keywords"
                               class="text-white"><?php echo $l->line('Site tag KEYWORDS'); ?></label>
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <textarea class="form-control make_change" id="site_keywords" rows="10"
                                              name="site_keywords"
                                              placeholder="<?php echo $l->line('Site tag KEYWORDS'); ?>"><?php echo $n_eco_builder_config['site_keywords']; ?></textarea>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <label for="site_description"
                               class="text-white"><?php echo $l->line('Site tag DESCRIPTION'); ?></label>
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <textarea class="form-control make_change" id="site_description" rows="10"
                                              name="site_description"
                                              placeholder="<?php echo $l->line('Site tag DESCRIPTION'); ?>"><?php echo $n_eco_builder_config['site_description']; ?></textarea>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Open Graphs Image'); ?></p>
                        <div id="og_image_website"><?php echo $l->line("upload") ?></div>
                        <div class="d-flex">
                            <img id="og_image_website" class="mx-auto img-fluid" style="    width: auto;
        max-height: 60px;" src="<?php echo base_url($n_eco_builder_config['og_image_website']); ?>"/>
                        </div>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i++;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Language settings'); ?></span>
                </div>
                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p><?php echo $this->lang->line('Store multi language<br />If you want change default ecommerce language, please back to ecommerce dashboard and store settings.'); ?></p>
                        <div class="form-group">
                            <?php

                            function _e_scanAll($myDir)
                            {
                                $dirTree = array();
                                $di = new RecursiveDirectoryIterator($myDir, RecursiveDirectoryIterator::SKIP_DOTS);

                                $i = 0;
                                foreach (new RecursiveIteratorIterator($di) as $filename) {

                                    $dir = str_replace($myDir, '', dirname($filename));
                                    // $dir = str_replace('/', '>', substr($dir,1));

                                    $org_dir = str_replace("\\", "/", $dir);

                                    if ($org_dir)
                                        $file_path = $org_dir . "/" . basename($filename);
                                    else
                                        $file_path = basename($filename);

                                    $file_full_path = $myDir . "/" . $file_path;
                                    $file_size = filesize($file_full_path);
                                    $file_modification_time = filemtime($file_full_path);

                                    $dirTree[$i]['file'] = $file_full_path;
                                    $i++;
                                }
                                return $dirTree;
                            }

                            function _e_language_list()
                            {
                                $myDir = APPPATH . 'language';
                                $file_list = _e_scanAll($myDir);
                                foreach ($file_list as $file) {
                                    $i = 0;
                                    $one_list[$i] = $file['file'];
                                    $one_list[$i] = str_replace("\\", "/", $one_list[$i]);
                                    $one_list_array[] = explode("/", $one_list[$i]);
                                }
                                foreach ($one_list_array as $value) {
                                    $pos = count($value) - 2;
                                    $lang_folder = $value[$pos];
                                    $final_list_array[] = $lang_folder;
                                }
                                $final_array = array_unique($final_list_array);
                                $array_keys = array_values($final_array);
                                foreach ($final_array as $value) {
                                    $uc_array_valus[] = ucfirst($value);
                                }
                                $array_values = array_values($uc_array_valus);
                                $final_array_done = array_combine($array_keys, $array_values);
                                return $final_array_done;
                            }

                            $e_language_info = _e_language_list();
                            ksort($e_language_info);

                            $default_lang = $this->basic->get_data("ecommerce_store", array("where" => array("store_unique_id " => $shop_id)));
                            $default_lang = $default_lang[0]['store_locale'];

                            ?>
                            <select class="select2 form-control" id="store_lang" multiple="multiple">
                                <?php
                                foreach ($e_language_info as $key_lang => $value_lang) {
                                    $selected = '';
                                    if (strtolower($value_lang) == $default_lang) {
                                        $selected = 'selected';
                                    }
                                    if (strpos($n_eco_builder_config['store_lang'], strtolower($value_lang)) !== false) {
                                        $selected = 'selected';
                                    }

                                    echo '<option value="' . strtolower($value_lang) . '" ' . $selected . '>' . $value_lang . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>
</div>