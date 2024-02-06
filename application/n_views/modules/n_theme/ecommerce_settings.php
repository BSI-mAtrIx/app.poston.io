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

<div class="section-body">
    <div class="">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body p-0">
                    <form class="form-horizontal text-c row"
                          action="<?php echo site_url() . 'n_theme/ecommerce_settings_save'; ?>" method="POST">
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                        <div class="row">

                            <div class="col-12 col-md-6 mb-1">
                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                    <input type="checkbox" class="custom-control-input"
                                           value="true" <?php if ($n_store_settings['footer_mobile'] == 'true') {
                                        echo 'checked';
                                    } ?> id="footer_mobile_menu" name="footer_mobile_menu">
                                    <label class="custom-control-label mr-1" for="footer_mobile_menu"></label>
                                    <span><?php echo $this->lang->line("Enable mobile footer menu?"); ?></span>
                                    <span class="text-danger"><?php echo form_error('footer_mobile_menu'); ?></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                    <input type="checkbox" class="custom-control-input"
                                           value="true" <?php if ($n_store_settings['footer_mobile_text'] == 'true') {
                                        echo 'checked';
                                    } ?> id="footer_mobile_text" name="footer_mobile_text">
                                    <label class="custom-control-label mr-1" for="footer_mobile_text"></label>
                                    <span><?php echo $this->lang->line("Enable mobile footer text menu?"); ?></span>
                                    <span class="text-danger"><?php echo form_error('footer_mobile_text'); ?></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <h6><?php echo $this->lang->line("Show store name in header"); ?></h6>
                                <div class="form-group">
                                    <?php
                                    $select_lan = false;
                                    if (isset($n_store_settings['show_store_name'])) {
                                        $select_lan = $n_store_settings['show_store_name'];
                                    }
                                    $options = array();
                                    $options['true'] = 'Show';
                                    $options['false'] = 'Hide';

                                    echo form_dropdown('show_store_name', $options, $select_lan, 'class="select2 form-control" id="show_store_name"'); ?>
                                </div>
                                <span class="text-danger"><?php echo form_error('show_store_name'); ?></span>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <h6><?php echo $this->lang->line("Logo store in header"); ?></h6>
                                <div class="form-group">
                                    <?php
                                    $select_lan = false;
                                    if (isset($n_store_settings['store_logo_show'])) {
                                        $select_lan = $n_store_settings['store_logo_show'];
                                    }
                                    $options = array();
                                    $options['favicon'] = 'Favicon (recommend with store name)';
                                    $options['logo'] = 'Logo (recommend with hidden store name )';
                                    $options['none'] = 'Hide logo/favicon';

                                    echo form_dropdown('store_logo_show', $options, $select_lan, 'class="select2 form-control" id="store_logo_show"'); ?>
                                </div>
                                <span class="text-danger"><?php echo form_error('store_logo_show'); ?></span>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <h6><?php echo $this->lang->line("Enable addthis on product view"); ?></h6>
                                <div class="form-group">
                                    <?php
                                    $select_lan = false;
                                    if (isset($n_store_settings['addthis_show'])) {
                                        $select_lan = $n_store_settings['addthis_show'];
                                    }
                                    $options = array();
                                    $options['true'] = 'Show';
                                    $options['false'] = 'Hide';

                                    echo form_dropdown('addthis_show', $options, $select_lan, 'class="select2 form-control" id="addthis_show"'); ?>
                                </div>
                                <span class="text-danger"><?php echo form_error('addthis_show'); ?></span>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <p><?php echo $this->lang->line("Addthis Javascript code (inline sharing toolbox)"); ?></p>
                                <fieldset class="form-group">
                                    <textarea class="form-control" id="addthis_code" name="addthis_code" rows="18"
                                              placeholder="Textarea" spellcheck="false"
                                              data-ms-editor="true"><?php echo $n_store_settings['addthis_code']; ?></textarea>
                                </fieldset>
                                <span class="text-danger"><?php echo form_error('addthis_code'); ?></span>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <h6><?php echo $this->lang->line("Enable contact page"); ?></h6>
                                <div class="form-group">
                                    <?php
                                    $select_lan = false;
                                    if (isset($n_store_settings['contact_page_on'])) {
                                        $select_lan = $n_store_settings['contact_page_on'];
                                    }
                                    $options = array();
                                    $options['true'] = 'Show';
                                    $options['false'] = 'Hide';

                                    echo form_dropdown('contact_page_on', $options, $select_lan, 'class="select2 form-control" id="contact_page_on"'); ?>
                                </div>
                                <span class="text-danger"><?php echo form_error('contact_page_on'); ?></span>

                                <a class="btn btn-primary mb-5" href="<?php echo base_url(); ?>n_theme/user_editor_page"
                                   target="_blank"><i class="bx bx-edit"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Edit contact page (BETA)"); ?></span></a>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <fieldset>
                                    <label for="addthis_class"><?php echo $this->lang->line("Class name for addthis"); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='bx bxl-css3'></i></span>
                                        </div>
                                        <input type="text" id="addthis_class" name="addthis_class" class="form-control"
                                               value="<?php echo $n_store_settings['addthis_class']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('addthis_class'); ?></span>
                                </fieldset>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-12 col-md-6 mb-1">
                                <h6><?php echo $this->lang->line("Appearence On"); ?></h6>
                                <div class="form-group">
                                    <?php
                                    $select_lan = false;
                                    if (isset($n_store_settings['theme_appeareance_on'])) {
                                        $select_lan = $n_store_settings['theme_appeareance_on'];
                                    }
                                    $options = array();
                                    $options['true'] = 'Custom';
                                    $options['false'] = 'Default theme';

                                    echo form_dropdown('theme_appeareance_on', $options, $select_lan, 'class="select2 form-control" id="theme_appeareance_on"'); ?>
                                </div>
                                <span class="text-danger"><?php echo form_error('theme_appeareance_on'); ?></span>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <fieldset>
                                    <label for="nav_font"><?php echo $this->lang->line('Navigation google fonts name'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='bx bx-font'></i></span>
                                        </div>
                                        <input type="text" id="nav_font" name="nav_font" class="form-control"
                                               value="<?php echo $n_store_settings['nav_font']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('nav_font'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-6 mb-1">
                                <fieldset>
                                    <label for="body_font"><?php echo $this->lang->line('Body google fonts name'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='bx bx-font'></i></span>
                                        </div>
                                        <input type="text" id="body_font" name="body_font" class="form-control"
                                               value="<?php echo $n_store_settings['body_font']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('body_font'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="body_font_font_size"><?php echo $this->lang->line('Body font size'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='bx bx-font-size'></i></span>
                                        </div>
                                        <input type="text" id="body_font_font_size" name="body_font_font_size"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['body_font_font_size']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('body_font_font_size'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="card_title_font_size"><?php echo $this->lang->line('Card title font size'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class='bx bx-font-size'></i></span>
                                        </div>
                                        <input type="text" id="card_title_font_size" name="card_title_font_size"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['card_title_font_size']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('card_title_font_size'); ?></span>
                                </fieldset>
                            </div>

                        </div>

                        <div class="row" id="colors_in">

                            <div class="col-12 col-md-4 mb-1 d-none">
                                <fieldset>
                                    <label for="theme_sidebar_color"><?php echo $this->lang->line('Semi dark sidebar color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="theme_sidebar_color" name="theme_sidebar_color"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['theme_sidebar_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('theme_sidebar_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1 d-none">
                                <fieldset>
                                    <label for="dark_icon_color"><?php echo $this->lang->line('Sidebar icon color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="dark_icon_color" name="dark_icon_color"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['dark_icon_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('dark_icon_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1 d-none">
                                <fieldset>
                                    <label for="sidebar_text_color"><?php echo $this->lang->line('Sidebar text color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="sidebar_text_color" name="sidebar_text_color"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['sidebar_text_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('sidebar_text_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="primary_color"><?php echo $this->lang->line('Primary color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="primary_color" name="primary_color" class="form-control"
                                               value="<?php echo $n_store_settings['primary_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('primary_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="primary_outline_color"><?php echo $this->lang->line('Primary outline color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="primary_outline_color" name="primary_outline_color"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['primary_outline_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('primary_outline_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="primary_color_hover"><?php echo $this->lang->line('Primary hover color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="primary_color_hover" name="primary_color_hover"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['primary_color_hover']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('primary_color_hover'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="light_primary_color"><?php echo $this->lang->line('Light primary color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="light_primary_color" name="light_primary_color"
                                               class="form-control"
                                               value="<?php echo $n_store_settings['light_primary_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('light_primary_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="danger_color"><?php echo $this->lang->line('Danger color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="danger_color" name="danger_color" class="form-control"
                                               value="<?php echo $n_store_settings['danger_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('danger_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="success_color"><?php echo $this->lang->line('Success color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="success_color" name="success_color" class="form-control"
                                               value="<?php echo $n_store_settings['success_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('success_color'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-4 mb-1">
                                <fieldset>
                                    <label for="warning_color"><?php echo $this->lang->line('Warning color'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="warning_color" name="warning_color" class="form-control"
                                               value="<?php echo $n_store_settings['warning_color']; ?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('warning_color'); ?></span>
                                </fieldset>
                            </div>


                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bx-save"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>