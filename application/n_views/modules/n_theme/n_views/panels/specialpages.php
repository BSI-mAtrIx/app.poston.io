<div class="card shadow-none bg-transparent panel_dis" style="display:none;" data-panel="special_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Special pages") ?>
        </h4>
    </div>

    <?php
    $id_header = 'accordionSpecial1';
    $controls_header = 'Special';
    $i = 0;
    ?>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="<?php echo $id_header; ?>">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Contact page'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <div class="card-body bg-secondary text-white pl-1 pr-1">
                            <h6 class="text-white"><?php echo $this->lang->line("Turn on contact page"); ?></h6>
                            <div class="form-group">
                                <?php
                                $select_lan = false;
                                if (isset($n_eco_builder_config['contact_page_on'])) {
                                    $select_lan = $n_eco_builder_config['contact_page_on'];
                                }
                                $options = array();
                                $options['true'] = $this->lang->line('On');
                                $options['false'] = $this->lang->line('Off');

                                echo form_dropdown('contact_page_on', $options, $select_lan, 'class="make_change form-control" id="contact_page_on"'); ?>
                            </div>
                            <span class="text-danger"><?php echo form_error('contact_page_on'); ?></span>
                        </div>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <div class="col-12 p-0 text-center mb-1">
                            <a class="btn btn-primary action_iframe" href="#"
                               data-action="<?php echo base_url(); ?>n_theme/user_editor_page/<?php echo $shop_id_short; ?>"
                               target="_blank"><i class="bx bx-edit"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("Edit contact page") . ' (default language)'; ?></span></a>
                        </div>
                        <div class="col-12 p-0 text-center mb-1">
                            <a class="btn btn-secondary copy_to" data-file="contact_page" href="#" target="_blank"><i
                                        class="bx bx-edit"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("Copy (default language)"); ?></span></a>
                        </div>
                        <?php
                        $language_info = _e_language_list();
                        ksort($language_info);
                        foreach ($language_info as $key_lang => $value_lang) { ?>
                            <div class="col-12 p-0 text-center mb-1">

                                <a class="btn btn-primary action_iframe" href="#"
                                   data-action="<?php echo base_url(); ?>n_theme/user_editor_page/<?php echo $shop_id_short . '/' . strtolower($key_lang); ?>"
                                   target="_blank"><i class="bx bx-edit"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Edit homepage") . ' (' . $key_lang . ')'; ?></span></a>

                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>

            <?php $i++; ?>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Home page editor'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <div class="card-body bg-secondary text-white pl-1 pr-1">
                            <h6 class="text-white"><?php echo $this->lang->line("Turn on custom home page"); ?></h6>
                            <div class="form-group">
                                <?php
                                $select_lan = false;
                                if (isset($n_eco_builder_config['home_page_editor_on'])) {
                                    $select_lan = $n_eco_builder_config['home_page_editor_on'];
                                }
                                $options = array();
                                $options['true'] = $this->lang->line('On');
                                $options['false'] = $this->lang->line('Off');

                                echo form_dropdown('home_page_editor_on', $options, $select_lan, 'class="make_change form-control" id="home_page_editor_on"'); ?>
                            </div>
                            <span class="text-danger"><?php echo form_error('home_page_editor_on'); ?></span>
                        </div>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <div class="col-12 p-0 text-center mb-1">
                            <a class="btn btn-primary action_iframe" href="#"
                               data-action="<?php echo base_url(); ?>n_theme/ecommerce_home_editor_page/<?php echo $shop_id_short; ?>"
                               target="_blank"><i class="bx bx-edit"></i><span
                                        class="align-middle ml-25"><?php echo $this->lang->line("Edit homepage") . ' (default language)'; ?></span></a>

                        </div>
                        <div class="col-12 p-0 text-center mb-1">
                            <a class="btn btn-secondary copy_to" data-file="home_page" href="#" target="_blank"><i
                                        class="bx bx-edit"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("Copy (default language)"); ?></span></a>
                        </div>
                        <?php
                        ksort($language_info);
                        foreach ($language_info as $key_lang => $value_lang) { ?>
                            <div class="col-12 p-0 text-center mb-1">

                                <a class="btn btn-primary action_iframe" href="#"
                                   data-action="<?php echo base_url(); ?>n_theme/ecommerce_home_editor_page/<?php echo $shop_id_short . '/' . strtolower($key_lang); ?>"
                                   target="_blank"><i class="bx bx-edit"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Edit homepage") . ' (' . $key_lang . ')'; ?></span></a>

                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php $i++; ?>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Modal/Popup editor'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <div class="card-body bg-secondary text-white pl-1 pr-1">
                            <h6 class="text-white"><?php echo $this->lang->line("Turn on modal/popup"); ?></h6>
                            <div class="form-group">
                                <?php
                                $select_lan = false;
                                if (isset($n_eco_builder_config['welcome_modal_show'])) {
                                    $select_lan = $n_eco_builder_config['welcome_modal_show'];
                                }
                                $options = array();
                                $options['true'] = $this->lang->line('On');
                                $options['false'] = $this->lang->line('Off');

                                echo form_dropdown('welcome_modal_show', $options, $select_lan, 'class="make_change form-control" id="welcome_modal_show"'); ?>
                            </div>
                            <span class="text-danger"><?php echo form_error('welcome_modal_show'); ?></span>
                        </div>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="logo_height_header"
                                   class="text-white"><?php echo $l->line('Modal max width'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="welcome_modal_maxwidth"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['welcome_modal_maxwidth']; ?>"
                                       placeholder="<?php echo $l->line('Modal max width'); ?>"
                                       aria-describedby="welcome_modal_maxwidth2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="welcome_modal_maxwidth2"><?php echo $l->line('PX'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="welcome_modal_timeout"
                                   class="text-white"><?php echo $l->line('Modal show after X seconds'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="welcome_modal_timeout" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['welcome_modal_timeout']; ?>"
                                       placeholder="<?php echo $l->line('Modal show after X seconds'); ?>"
                                       aria-describedby="welcome_modal_timeout2">
                                <div class="input-group-append">
                                    <span class="input-group-text"
                                          id="welcome_modal_timeout2"><?php echo $l->line('sec'); ?></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <div class="col-12 p-0 text-center mb-1">
                            <a class="btn btn-primary action_iframe" href="#"
                               data-action="<?php echo base_url(); ?>n_theme/welcome_modal_editor/<?php echo $shop_id_short; ?>"
                               target="_blank"><i class="bx bx-edit"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("Edit modal") . ' (default language)'; ?></span></a>
                        </div>
                        <div class="col-12 p-0 text-center mb-1">
                            <a class="btn btn-secondary copy_to" data-file="modal_popup" href="#" target="_blank"><i
                                        class="bx bx-edit"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("Copy (default language)"); ?></span></a>
                        </div>
                        <?php
                        ksort($language_info);
                        foreach ($language_info as $key_lang => $value_lang) { ?>
                            <div class="col-12 p-0 text-center mb-1">

                                <a class="btn btn-primary action_iframe" href="#"
                                   data-action="<?php echo base_url(); ?>n_theme/welcome_modal_editor/<?php echo $shop_id_short . '/' . strtolower($key_lang); ?>"
                                   target="_blank"><i class="bx bx-edit"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Edit modal") . ' (' . $key_lang . ')'; ?></span></a>

                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>