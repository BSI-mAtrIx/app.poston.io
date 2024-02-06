<div class="card shadow-none bg-transparent panel_dis" data-panel="header_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Header") ?>
        </h4>
    </div>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="accordionHeaders1">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading1" class="card-header border-0 pl-1 pr-1" role="tablist" data-toggle="collapse"
                     data-target="#accordion1" aria-expanded="false" aria-controls="accordion1">
                    <span class="collapse-title text-white"><?php echo $l->line('Upload store logo'); ?></span>

                </div>

                <div id="accordion1" role="tabpanel" data-parent="#accordionHeaders1" aria-labelledby="heading1"
                     class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Light store logo'); ?></p>
                        <div id="eco_upload_logo"><?php echo $l->line("upload") ?></div>
                        <div class="d-flex">
                            <img id="eco_upload_logo_img" class="mx-auto img-fluid" style="    width: auto;
        max-height: 60px;" src="<?php echo base_url($n_eco_builder_config['store_logo_light']); ?>"/>
                        </div>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Dark store logo'); ?></p>
                        <div id="eco_upload_dark_logo"><?php echo $this->lang->line("upload") ?></div>
                        <div class="d-flex">
                            <img id="eco_upload_dark_logo_img" class="mx-auto img-fluid" style="    width: auto;
        max-height: 60px;" src="<?php echo base_url($n_eco_builder_config['store_logo_dark']); ?>"/>
                        </div>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Light store icon'); ?></p>
                        <div id="store_dark_icon"><?php echo $this->lang->line("upload") ?></div>
                        <div class="d-flex">
                            <img id="store_dark_icon_img" class="mx-auto img-fluid" style="    width: auto;
        max-height: 60px;" src="<?php echo base_url($n_eco_builder_config['store_dark_icon']); ?>"/>
                        </div>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Dark store icon'); ?></p>
                        <div id="store_light_icon"><?php echo $this->lang->line("upload") ?></div>
                        <div class="d-flex">
                            <img id="store_light_icon_img" class="mx-auto img-fluid" style="    width: auto;
        max-height: 60px;" src="<?php echo base_url($n_eco_builder_config['store_light_icon']); ?>"/>
                        </div>
                    </div>


                </div>
            </div>


            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading2" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion2" aria-expanded="false" aria-controls="accordion2">
                    <span class="collapse-title text-white"><?php echo $l->line('Logo settings'); ?></span>
                </div>
                <div id="accordion2" role="tabpanel" data-parent="#accordionHeaders1" aria-labelledby="heading2"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show store name in header"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['show_store_name'])) {
                                $select_lan = $n_eco_builder_config['show_store_name'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('show_store_name', $options, $select_lan, 'class="make_change form-control" id="show_store_name"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('show_store_name'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Logo store in header"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['store_logo_show'])) {
                                $select_lan = $n_eco_builder_config['store_logo_show'];
                            }
                            $options = array();
                            $options['favicon'] = $this->lang->line('Favicon (recommend with store name)');
                            $options['logo'] = $this->lang->line('Logo (recommend with hidden store name )');
                            $options['none'] = $this->lang->line('Hide logo/favicon');

                            echo form_dropdown('store_logo_show', $options, $select_lan, 'class="form-control make_change" id="store_logo_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('store_logo_show'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Color logo store in header"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['header_color_logo'])) {
                                $select_lan = $n_eco_builder_config['header_color_logo'];
                            }
                            $options = array();
                            $options['light'] = $this->lang->line('Light');
                            $options['dark'] = $this->lang->line('Dark');

                            echo form_dropdown('header_color_logo', $options, $select_lan, 'class="form-control make_change" id="header_color_logo"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('header_color_logo'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="logo_height_header"
                                   class="text-white"><?php echo $l->line('Logo height'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="logo_height_header" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['logo_height_header']; ?>"
                                       placeholder="<?php echo $l->line('Logo height'); ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('PX'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="logo_width_header"
                                   class="text-white"><?php echo $l->line('Logo width'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="logo_width_header" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['logo_width_header']; ?>"
                                       placeholder="<?php echo $l->line('Logo width'); ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('PX'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="store_name_font_size"
                                   class="text-white"><?php echo $l->line('Store name font size'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="store_name_font_size" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['store_name_font_size']; ?>"
                                       placeholder="<?php echo $l->line('Store name font size'); ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('PX'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="store_name_font_color"
                                   class="text-white"><?php echo $this->lang->line('Store name color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="store_name_font_color" name="store_name_font_color"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['store_name_font_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('store_name_font_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="store_name_font_color_hover"
                                   class="text-white"><?php echo $this->lang->line('Store name hover color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="store_name_font_color_hover" name="store_name_font_color_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['store_name_font_color_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('store_name_font_color_hover'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading3" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion3" aria-expanded="false" aria-controls="accordion3">
                    <span class="collapse-title text-white"><?php echo $l->line('Menu header style'); ?></span>
                </div>
                <div id="accordion3" role="tabpanel" data-parent="#accordionHeaders1" aria-labelledby="heading2"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_background"
                                   class="text-white"><?php echo $this->lang->line('Header menu background'); ?></label>
                            <div class="input-group">
                                <input type="text" id="menu_background" name="menu_background"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['menu_background']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('menu_background'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_font_color"
                                   class="text-white"><?php echo $this->lang->line('Header menu font color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="menu_font_color" name="menu_font_color"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['menu_font_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('menu_font_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_font_color_hover"
                                   class="text-white"><?php echo $this->lang->line('Header menu font hover color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="menu_font_color_hover" name="menu_font_color_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['menu_font_color_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('menu_font_color_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_font_color_active"
                                   class="text-white"><?php echo $this->lang->line('Header menu font active color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="menu_font_color_active" name="menu_font_color_active"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['menu_font_color_active']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('menu_font_color_active'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading4" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion4" aria-expanded="false" aria-controls="accordion3">
                    <span class="collapse-title text-white"><?php echo $l->line('Header settings'); ?></span>
                </div>
                <div id="accordion4" role="tabpanel" data-parent="#accordionHeaders1" aria-labelledby="heading4"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <label for="header_text"
                               class="text-white"><?php echo $l->line('Welcome text in header'); ?></label>
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <textarea class="form-control make_change" id="header_text" rows="3"
                                              name="header_text"
                                              placeholder="<?php echo $l->line('Welcome text in header'); ?>"><?php echo $n_eco_builder_config['header_text']; ?></textarea>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Hide search"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['header_search'])) {
                                $select_lan = $n_eco_builder_config['header_search'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('Hide');
                            $options['true'] = $this->lang->line('Show');

                            echo form_dropdown('header_search', $options, $select_lan, 'class="make_change form-control" id="header_search"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('header_search'); ?></span>

                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Breadcrumb hiding"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['breadcrumb_hide'])) {
                                $select_lan = $n_eco_builder_config['breadcrumb_hide'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('Show');
                            $options['true'] = $this->lang->line('Hide');

                            echo form_dropdown('breadcrumb_hide', $options, $select_lan, 'class="make_change form-control" id="breadcrumb_hide"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('breadcrumb_hide'); ?></span>

                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Menu style"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['menu_style'])) {
                                $select_lan = $n_eco_builder_config['menu_style'];
                            }
                            $options = array();
                            $options['classic_menu'] = $this->lang->line('Classic menu');
                            $options['swiper'] = $this->lang->line('Swiper menu');
                            $options['both'] = $this->lang->line('both');

                            echo form_dropdown('menu_style', $options, $select_lan, 'class="make_change form-control" id="menu_style"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('menu_style'); ?></span>

                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Animate welcome message"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['header_welcome_animate'])) {
                                $select_lan = $n_eco_builder_config['header_welcome_animate'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('Mobile only');
                            $options['true'] = $this->lang->line('All devices');

                            echo form_dropdown('header_welcome_animate', $options, $select_lan, 'class="make_change form-control" id="header_welcome_animate"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('header_welcome_animate'); ?></span>

                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading55" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion5" aria-expanded="false" aria-controls="accordion5">
                    <span class="collapse-title text-white"><?php echo $l->line('Swiper menu settings'); ?></span>
                </div>
                <div id="accordion5" role="tabpanel" data-parent="#accordionHeaders1" aria-labelledby="heading5"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Swiper style"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['menu_swiper_text_only'])) {
                                $select_lan = $n_eco_builder_config['menu_swiper_text_only'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('With category images');
                            $options['true'] = $this->lang->line('Without category images');

                            echo form_dropdown('menu_swiper_text_only', $options, $select_lan, 'class="make_change form-control" id="menu_swiper_text_only"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('menu_swiper_text_only'); ?></span>

                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_spacebetween"
                                   class="text-white"><?php echo $l->line('Space between elements'); ?></label>
                            <div class="input-group">
                                <input type="number" id="menu_swiper_spacebetween" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_spacebetween']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('PX'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_slidesoerview"
                                   class="text-white"><?php echo $l->line('Slides per view (<480px)'); ?></label>
                            <div class="input-group">
                                <input type="number" id="menu_swiper_slidesoerview" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_slidesoerview']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('Slides'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_spv_480"
                                   class="text-white"><?php echo $l->line('Slides per view (480px<)'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="menu_swiper_spv_480" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_spv_480']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('Slides'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>


                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_spv_576"
                                   class="text-white"><?php echo $l->line('Slides per view (576px<)'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="menu_swiper_spv_576" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_spv_576']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('Slides'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>


                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_spv_768"
                                   class="text-white"><?php echo $l->line('Slides per view (768px<)'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="menu_swiper_spv_768" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_spv_768']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('Slides'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>


                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_spv_992"
                                   class="text-white"><?php echo $l->line('Slides per view (992px<)'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="menu_swiper_spv_992" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_spv_992']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('Slides'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_spv_1200"
                                   class="text-white"><?php echo $l->line('Slides per view (1200px<)'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="menu_swiper_spv_1200" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_spv_1200']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('Slides'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_spacebetween_1200"
                                   class="text-white"><?php echo $l->line('Space between elements (1200px<)'); ?></label>
                            <div class="input-group">
                                <input type="number" id="menu_swiper_spacebetween_1200" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_spacebetween_1200']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="basic-addon2"><?php echo $l->line('PX'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_name_hover_color"
                                   class="text-white"><?php echo $this->lang->line('Category color hover'); ?></label>
                            <div class="input-group">
                                <input type="text" id="menu_swiper_name_hover_color" name="menu_swiper_name_hover_color"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_name_hover_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('menu_swiper_name_hover_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="menu_swiper_radius"
                                   class="text-white"><?php echo $l->line('Eclipse radius'); ?></label>
                            <div class="input-group">
                                <input type="number" id="menu_swiper_radius" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['menu_swiper_radius']; ?>"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><?php echo $l->line('%'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>


                </div>
            </div>


        </div>
    </div>
</div>