<div class="card shadow-none bg-transparent panel_dis" style="display:none;" data-panel="mobile_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Mobile settings") ?>
        </h4>
    </div>

    <?php
    $id_header = 'accordionMobile1';
    $controls_header = 'Mobile';
    $i = 0;
    ?>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="<?php echo $id_header; ?>">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Sticky footer menu'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show sticky footer menu"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_mobile_menu', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Type buttons"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu_only_icons'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu_only_icons'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('Icon + text');
                            $options['true'] = $this->lang->line('Only Icon');

                            echo form_dropdown('show_mobile_menu_only_icons', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu_only_icons"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu_only_icons'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Button: home"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu_home'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu_home'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_mobile_menu_home', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu_home"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu_home'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Button: cart"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu_cart'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu_cart'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_mobile_menu_cart', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu_cart"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu_cart'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Button: account"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu_account'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu_account'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_mobile_menu_account', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu_account"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu_account'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Button: contact"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu_contact'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu_contact'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_mobile_menu_contact', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu_contact"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu_contact'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Button: orders"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu_orders'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu_orders'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_mobile_menu_orders', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu_orders"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu_orders'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Floating menu"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['menu_mobile_float'])) {
                                $select_lan = $n_eco_builder_config['menu_mobile_float'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('menu_mobile_float', $options, $select_lan, 'class="make_change form-control" id="menu_mobile_float"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('menu_mobile_float'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <label for="menu_mobile_float_max_pos"
                               class="text-white"><?php echo $l->line('Floating menu position in menu'); ?></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="number" id="menu_mobile_float_max_pos" class="form-control make_change"
                                   value="<?php echo $n_eco_builder_config['menu_mobile_float_max_pos']; ?>"
                                   placeholder="<?php echo $l->line('Floating menu position in menu'); ?>"/>
                            <div class="form-control-position">
                                <i class="bx bx-list-ul"></i>
                            </div>
                        </fieldset>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_mobile_float_background"
                                   class="text-white"><?php echo $this->lang->line('Floating menu button background color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="menu_mobile_float_background" name="menu_mobile_float_background"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['menu_mobile_float_background']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('menu_mobile_float_background'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Mobile footer show button BACK"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_mobile_menu_back'])) {
                                $select_lan = $n_eco_builder_config['show_mobile_menu_back'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_mobile_menu_back', $options, $select_lan, 'class="make_change form-control" id="show_mobile_menu_back"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_mobile_menu_back'); ?></span>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>