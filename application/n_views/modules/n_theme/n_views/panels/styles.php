<div class="card shadow-none bg-transparent panel_dis" data-panel="styles_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Styles") ?>
        </h4>
    </div>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="accordionStyles2">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading1" class="card-header border-0 pl-1 pr-1" role="tablist" data-toggle="collapse"
                     data-target="#accordion1" aria-expanded="false" aria-controls="accordion1">
                    <span class="collapse-title text-white"><?php echo $l->line('Fonts'); ?></span>

                </div>

                <div id="accordion1" role="tabpanel" data-parent="#accordionStyles2" aria-labelledby="heading1"
                     class="collapse bg-secondary border-top-darken-2">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <label for="font_family" class="text-white"><?php echo $l->line('Font family'); ?></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" id="font_family" class="form-control make_change"
                                   value="<?php echo $n_eco_builder_config['font_family']; ?>"
                                   placeholder="<?php echo $l->line('Google Font family'); ?>"/>
                            <div class="form-control-position">
                                <i class="bx bx-font-family"></i>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_header_top"
                                   class="text-white"><?php echo $this->lang->line('Font color header top'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_header_top" name="font_color_header_top"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_header_top']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_header_top'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_header_top_hover"
                                   class="text-white"><?php echo $this->lang->line('Font color header top hover'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_header_top_hover" name="font_color_header_top_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_header_top_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_header_top_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_header_middle"
                                   class="text-white"><?php echo $this->lang->line('Font color header middle'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_header_middle" name="font_color_header_middle"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_header_middle']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_header_middle'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_header_middle_hover"
                                   class="text-white"><?php echo $this->lang->line('Font color header middle hover'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_header_middle_hover"
                                       name="font_color_header_middle_hover" class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_header_middle_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_header_middle_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_headers"
                                   class="text-white"><?php echo $this->lang->line('Font color H1, H2, H3, H4, H5, H6'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_headers" name="font_color_headers"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_headers']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_headers'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_text_light"
                                   class="text-white"><?php echo $this->lang->line('Font color text light'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_text_light" name="font_color_text_light"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_text_light']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_text_light'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_text_dark"
                                   class="text-white"><?php echo $this->lang->line('Font color text dark'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_text_dark" name="font_color_text_dark"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_text_dark']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_text_dark'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_product_cat"
                                   class="text-white"><?php echo $this->lang->line('Font color category product home'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_product_cat" name="font_color_product_cat"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_product_cat']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_product_cat'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>


            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading2" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion2" aria-expanded="false" aria-controls="accordion2">
                    <span class="collapse-title text-white"><?php echo $l->line('miscellaneous'); ?></span>
                </div>
                <div id="accordion2" role="tabpanel" data-parent="#accordionStyles2" aria-labelledby="heading2"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Favicon'); ?></p>
                        <div id="eco_upload_fav"><?php echo $l->line("upload") ?></div>
                        <div class="d-flex">
                            <img id="store_favicon_img" class="mx-auto" style="    width: auto;
        max-height: 60px;" src="<?php echo base_url($n_eco_builder_config['store_favicon']); ?>"/>
                        </div>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading3" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion3" aria-expanded="false" aria-controls="accordion3">
                    <span class="collapse-title text-white"><?php echo $l->line('Style'); ?></span>
                </div>
                <div id="accordion3" role="tabpanel" data-parent="#accordionStyles2" aria-labelledby="heading2"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="background_color_header_top"
                                   class="text-white"><?php echo $this->lang->line('Header top background color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="background_color_header_top" name="background_color_header_top"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['background_color_header_top']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('background_color_header_top'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="background_color_header_middle"
                                   class="text-white"><?php echo $this->lang->line('Header middle background color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="background_color_header_middle"
                                       name="background_color_header_middle" class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['background_color_header_middle']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('background_color_header_middle'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="background_body"
                                   class="text-white"><?php echo $this->lang->line('Content background (body)'); ?></label>
                            <div class="input-group">
                                <input type="text" id="background_body" name="background_body"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['background_body']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('background_body'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="background_page_content"
                                   class="text-white"><?php echo $this->lang->line('Content background (pasge content)'); ?></label>
                            <div class="input-group">
                                <input type="text" id="background_page_content" name="background_page_content"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['background_page_content']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('background_page_content'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading4" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion4" aria-expanded="false" aria-controls="accordion3">
                    <span class="collapse-title text-white"><?php echo $l->line('Buttons product single'); ?></span>
                </div>
                <div id="accordion4" role="tabpanel" data-parent="#accordionStyles2" aria-labelledby="heading4"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="add_to_cart_color_bg"
                                   class="text-white"><?php echo $this->lang->line('Add to cart background'); ?></label>
                            <div class="input-group">
                                <input type="text" id="add_to_cart_color_bg" name="add_to_cart_color_bg"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['add_to_cart_color_bg']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('add_to_cart_color_bg'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="add_to_cart_color_bg_hover"
                                   class="text-white"><?php echo $this->lang->line('Add to cart background hover'); ?></label>
                            <div class="input-group">
                                <input type="text" id="add_to_cart_color_bg_hover" name="add_to_cart_color_bg_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['add_to_cart_color_bg_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('add_to_cart_color_bg_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="add_to_cart_color_font"
                                   class="text-white"><?php echo $this->lang->line('Add to cart font color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="add_to_cart_color_font" name="add_to_cart_color_font"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['add_to_cart_color_font']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('add_to_cart_color_font'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="add_to_cart_color_font_hover"
                                   class="text-white"><?php echo $this->lang->line('Add to cart hover font color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="add_to_cart_color_font_hover" name="add_to_cart_color_font_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['add_to_cart_color_font_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('add_to_cart_color_font_hover'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading4" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion5" aria-expanded="false" aria-controls="accordion5">
                    <span class="collapse-title text-white"><?php echo $l->line('Buttons add to cart home'); ?></span>
                </div>
                <div id="accordion5" role="tabpanel" data-parent="#accordionStyles2" aria-labelledby="heading5"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="home_add_to_cart_color_bg"
                                   class="text-white"><?php echo $this->lang->line('Add to cart background'); ?></label>
                            <div class="input-group">
                                <input type="text" id="home_add_to_cart_color_bg" name="home_add_to_cart_color_bg"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['home_add_to_cart_color_bg']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('home_add_to_cart_color_bg'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="home_add_to_cart_color_bg_hover"
                                   class="text-white"><?php echo $this->lang->line('Add to cart background hover'); ?></label>
                            <div class="input-group">
                                <input type="text" id="home_add_to_cart_color_bg_hover"
                                       name="home_add_to_cart_color_bg_hover" class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['home_add_to_cart_color_bg_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('home_add_to_cart_color_bg_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="home_add_to_cart_color_font"
                                   class="text-white"><?php echo $this->lang->line('Add to cart font color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="home_add_to_cart_color_font" name="home_add_to_cart_color_font"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['home_add_to_cart_color_font']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('home_add_to_cart_color_font'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="home_add_to_cart_color_font_hover"
                                   class="text-white"><?php echo $this->lang->line('Add to cart hover font color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="home_add_to_cart_color_font_hover"
                                       name="home_add_to_cart_color_font_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['home_add_to_cart_color_font_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('home_add_to_cart_color_font_hover'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="heading6" class="card-header border-0 pl-1 pr-1" data-toggle="collapse" role="button"
                     data-target="#accordion6" aria-expanded="false" aria-controls="accordion6">
                    <span class="collapse-title text-white"><?php echo $l->line('Guest login'); ?></span>
                </div>
                <div id="accordion6" role="tabpanel" data-parent="#accordionStyles2" aria-labelledby="heading6"
                     class="collapse bg-secondary border-top-darken-2" aria-expanded="false">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Guest login type button"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['guest_register_form_type'])) {
                                $select_lan = $n_eco_builder_config['guest_register_form_type'];
                            }
                            $options = array();
                            $options['text'] = $this->lang->line('Text');
                            $options['btn'] = $this->lang->line('Button');

                            echo form_dropdown('guest_register_form_type', $options, $select_lan, 'class="make_change form-control" id="guest_register_form_type"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('guest_register_form_type'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="guest_register_form_type_btn_font_color"
                                   class="text-white"><?php echo $this->lang->line('Guest login font color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="guest_register_form_type_btn_font_color"
                                       name="guest_register_form_type_btn_font_color"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['guest_register_form_type_btn_font_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('guest_register_form_type_btn_font_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="guest_register_form_type_btn_font_color_hover"
                                   class="text-white"><?php echo $this->lang->line('Guest login font hover color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="guest_register_form_type_btn_font_color_hover"
                                       name="guest_register_form_type_btn_font_color_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['guest_register_form_type_btn_font_color_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('guest_register_form_type_btn_font_color_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="guest_register_form_type_btn_bg_color"
                                   class="text-white"><?php echo $this->lang->line('Guest login button color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="guest_register_form_type_btn_bg_color"
                                       name="guest_register_form_type_btn_bg_color"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['guest_register_form_type_btn_bg_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('guest_register_form_type_btn_bg_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="guest_register_form_type_btn_bg_color_hover"
                                   class="text-white"><?php echo $this->lang->line('Guest login button hover color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="guest_register_form_type_btn_bg_color_hover"
                                       name="guest_register_form_type_btn_bg_color_hover"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['guest_register_form_type_btn_bg_color_hover']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('guest_register_form_type_btn_bg_color_hover'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="guest_register_form_type_btn_bg_color"
                                   class="text-white"><?php echo $this->lang->line('Guest login text size'); ?></label>
                            <div class="input-group">
                                <input type="text" id="guest_font_size"
                                       name="guest_font_size"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['guest_font_size']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('guest_font_size'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>

            <?php $i = 6;
            $controls_header = 'heading';
            $id_header = 'accordionStyles2'; ?>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i++;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Custom styles' . ' (CSS)'); ?></span>
                </div>
                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p><?php echo $this->lang->line("You can add here Custom CSS styles."); ?></p>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="codes_custom_css" name="codes_custom_css" rows="18"
                                      placeholder="Textarea" spellcheck="false"
                                      data-ms-editor="true"><?php if (!empty($codes_custom_css)) {
                                    echo $codes_custom_css;
                                } ?></textarea>
                        </fieldset>
                        <button class="btn btn-primary" id="save_codes_custom_css" type="submit"><i
                                    class="bx bx-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <span class="text-danger"><?php echo form_error('codes_custom_css'); ?></span>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>