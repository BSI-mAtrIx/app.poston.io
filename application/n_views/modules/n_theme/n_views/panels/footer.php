<div class="card shadow-none bg-transparent panel_dis" style="display:none;" data-panel="footer_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Footer Settings") ?>
        </h4>
    </div>

    <?php
    $id_header = 'accordionFoot1';
    $controls_header = 'Foot';
    $i = 0;
    ?>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="<?php echo $id_header; ?>">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Settings'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading<?php echo $i; ?>" class="collapse bg-secondary border-top-darken-2">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="footer_background"
                                   class="text-white"><?php echo $this->lang->line('Footer background'); ?></label>
                            <div class="input-group">
                                <input type="text" id="footer_background" name="footer_background"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['footer_background']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('footer_background'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="footer_background_text_color"
                                   class="text-white"><?php echo $this->lang->line('Footer text color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="footer_background_text_color" name="footer_background_text_color"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['footer_background_text_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('footer_background_text_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="footer_background_link_color"
                                   class="text-white"><?php echo $this->lang->line('Footer link color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="footer_background_link_color" name="footer_background_link_color"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['footer_background_link_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('footer_background_link_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="footer_background_link_color_hover"
                                   class="text-white"><?php echo $this->lang->line('Footer link hover color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="footer_background_link_color_hover"
                                       name="footer_background_link_color_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['footer_background_link_color_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('footer_background_link_color_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show All Rights Reserved"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['hide_all_rights_footer'])) {
                                $select_lan = $n_eco_builder_config['hide_all_rights_footer'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Hide');
                            $options['false'] = $this->lang->line('Show');

                            echo form_dropdown('hide_all_rights_footer', $options, $select_lan, 'class="make_change form-control" id="hide_all_rights_footer"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('hide_all_rights_footer'); ?></span>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  d-none">
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
                            $options['buy_now'] = $this->lang->line('Buy now');

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


        </div>
    </div>
</div>