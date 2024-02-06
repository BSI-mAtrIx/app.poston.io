<?php
    $include_prism=1;
    ?>

<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/forms/select/select2.min.css?ver=<?php echo $n_config['theme_version']; ?>">


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url(); ?>admin/settings"><?php echo $this->lang->line("System"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<?php $save_button = '<div class="heading-elements" style="top:13px;">
            <button type="submit" id="save-btn" class="btn btn-outline-success mr-1 mb-1" >
                <i class="bx bx-save"></i>
                <span class="align-middle ml-25">' . $this->lang->line("Save") . '</span>
            </button>
            <button class="btn btn-outline-danger mr-1 mb-1" onclick=\'goBack("admin/settings")\' type="button"><i class="bx bx-trash"></i><span class="align-middle ml-25">' . $this->lang->line("Cancel") . '</span></button>
          </div>'; ?>

<form class="form-horizontal text-c" enctype="multipart/form-data"
      action="<?php echo site_url() . 'admin/general_settings_action'; ?>" method="POST">
    <input type="hidden" name="csrf_token" id="csrf_token"
           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
    <div class="content-body" id="stacked-pill">

        <div class="bg-transparent shadow-none">
            <div class="row pills-stacked">
                <div class="col-md-3 col-sm-12">
                    <ul class="nav nav-pills flex-column text-center text-md-left">
                        <li class="nav-item">
                            <a href="#brand" class="nav-link align-items-center active" data-toggle="pill"
                               aria-expanded="true">
                                <i class="bx bxs-flag"></i>
                                <?php echo $this->lang->line("Brand"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#preference" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class="bx bx-task"></i>
                                <?php echo $this->lang->line("Preference"); ?>
                            </a>
                        </li>
                        <li class="nav-item"><a href="#logo-favicon" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-images"></i> <?php echo $this->lang->line("Logo & Favicon"); ?></a>
                        </li>
                        <li class="nav-item"><a href="#master-password" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-key"></i> <?php echo $this->lang->line("Master Password"); ?></a>
                        </li>
                        <li class="nav-item"><a href="#subscriber" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-user-circle"></i> <?php echo $this->lang->line("Subscriber"); ?>
                            </a></li>

                        <li class="nav-item"><a href="#persistent-menu" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-menu"></i> <?php echo $this->lang->line("Persistent Menu"); ?></a>
                        </li>

                        <?php if ($this->is_broadcaster_exist) : ?>
                            <li class="nav-item"><a href="#messenger-broadcast" class="nav-link" data-toggle="pill"
                                                    aria-expanded="true"><i
                                            class="bx bx-message"></i> <?php echo $this->lang->line("Messenger Broadcast"); ?>
                                </a></li>
                        <?php endif; ?>

                        <li class="nav-item"><a href="#group-posting" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-share"></i> <?php echo $this->lang->line("Facebook Poster"); ?></a>
                        </li>

                        <?php if ($this->basic->is_exist("modules", array("id" => 263)) || $this->basic->is_exist("modules", array("id" => 264))) { ?>
                            <li class="nav-item"><a href="#sms_email_settings" class="nav-link" data-toggle="pill"
                                                    aria-expanded="true"><i
                                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("SMS/Email Manager"); ?>
                                </a></li>
                        <?php } ?>

                        <li class="nav-item"><a href="#email_auto_responder" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-envelope"></i> <?php echo $this->lang->line("Email Auto Responder"); ?>
                            </a></li>

                        <?php if ($this->session->userdata('license_type') == 'double') { ?>
                            <li class="nav-item"><a href="#support-desk" class="nav-link" data-toggle="pill"
                                                    aria-expanded="true"><i
                                            class="bx bx-support"></i> <?php echo $this->lang->line("Support Desk"); ?>
                                </a></li>
                        <?php } ?>

                        <li class="nav-item"><a href="#file-upload" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-cloud-upload"></i> <?php echo $this->lang->line("File Upload"); ?>
                            </a></li>
                        <li class="nav-item"><a href="#junk_data" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-trash-alt"></i> <?php echo $this->lang->line("Delete Junk Data"); ?>
                            </a></li>

                        <?php if ($this->basic->is_exist("add_ons", array("project_id" => 41))) : ?>
                            <li class="nav-item"><a href="#fb_live" class="nav-link" data-toggle="pill"
                                                    aria-expanded="true"><i
                                            class="bx bx-tv"></i> <?php echo $this->lang->line("Facebook Live Streaming"); ?>
                                </a></li>
                        <?php endif; ?>

                        <li class="nav-item"><a href="#server-status" class="nav-link" data-toggle="pill"
                                                aria-expanded="true"><i
                                        class="bx bx-server"></i> <?php echo $this->lang->line("Server Status"); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="tab-content p-0 bg-transparent shadow-none">
                        <div role="tabpanel" class="tab-pane card active" id="brand" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Brand"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="product_name"><?php echo $this->lang->line("Application Name"); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="product_name" id="product_name"
                                                   value="<?php echo $this->config->item('product_name'); ?>"
                                                   class="form-control" type="text"
                                                   placeholder="<?php echo $this->lang->line("Application Name"); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-globe"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('product_name'); ?></span>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="product_short_name"><?php echo $this->lang->line("Application Short Name"); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="product_short_name" id="product_short_name"
                                                   value="<?php echo $this->config->item('product_short_name'); ?>"
                                                   class="form-control" type="text"
                                                   placeholder="<?php echo $this->lang->line("Application Short Name"); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bxs-compass"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('product_short_name'); ?></span>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="slogan"><?php echo $this->lang->line("Slogan"); ?></label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input name="slogan" id="slogan"
                                               value="<?php echo $this->config->item('slogan'); ?>"
                                               class="form-control" type="text"
                                               placeholder="<?php echo $this->lang->line("Slogan"); ?>">
                                        <div class="form-control-position">
                                            <i class="bx bx-tag"></i>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('slogan'); ?></span>
                                    </fieldset>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="institute_name"><?php echo $this->lang->line("Company Name"); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="institute_name" id="institute_name"
                                                   value="<?php echo $this->config->item('institute_address1'); ?>"
                                                   class="form-control" type="text"
                                                   placeholder="<?php echo $this->lang->line("Company Name"); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-briefcase"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('institute_name'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="institute_address"><?php echo $this->lang->line("Company Address"); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="institute_address" id="institute_address"
                                                   value="<?php echo $this->config->item('institute_address2'); ?>"
                                                   class="form-control" type="text"
                                                   placeholder="<?php echo $this->lang->line("Company Address"); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-pin"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('institute_address'); ?></span>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="institute_email"><?php echo $this->lang->line("Company Email"); ?>
                                            *</label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="institute_email" id="institute_email"
                                                   value="<?php echo $this->config->item('institute_email'); ?>"
                                                   class="form-control" type="email"
                                                   placeholder="<?php echo $this->lang->line("Company Email"); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-envelope"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('institute_email'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="institute_mobile"><?php echo $this->lang->line("Company Phone"); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="institute_mobile" id="institute_mobile"
                                                   value="<?php echo $this->config->item('institute_mobile'); ?>"
                                                   class="form-control" type="text"
                                                   placeholder="<?php echo $this->lang->line("Company Phone"); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-phone"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('institute_mobile'); ?></span>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div role="tabpanel" class="tab-pane card" id="preference" aria-labelledby="preference"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Preference"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12 col-md-6">

                                        <h6><?php echo $this->lang->line("Language"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = "english";
                                            if ($this->config->item('language') != "") $select_lan = $this->config->item('language');
                                            echo form_dropdown('language', $language_info, $select_lan, 'class="select2 form-control" id="language"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('language'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <h6><?php echo $this->lang->line("Time Zone");
                                            echo " (" . date("Y-m-d H:i:s") . ")"; ?></h6>
                                        <div class="form-group">
                                            <?php $time_zone[''] = $this->lang->line('Time Zone');
                                            echo form_dropdown('time_zone', $time_zone, $this->config->item('time_zone'), 'class="select2 form-control" id="time_zone"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('time_zone'); ?></span>
                                    </div>
                                </div>

                                <div class="form-group d-none">
                                    <?php
                                    $is_rtl = $this->config->item('is_rtl');
                                    if ($is_rtl == '') $is_rtl = '0';
                                    ?>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="is_rtl" value="1"
                                               class="custom-switch-input" <?php if ($is_rtl == '1') echo 'checked'; ?>>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><?php echo $this->lang->line('RTL'); ?></span>
                                        <span class="red"><?php echo form_error('is_rtl'); ?></span>
                                    </label>
                                </div>


                                <div class="form-group">
                                    <?php
                                    $force_https = $this->config->item('force_https');
                                    if ($force_https == '') $force_https = '0';
                                    ?>
                                    <fieldset>
                                        <div class="checkbox">
                                            <input type="checkbox" name="force_https" id="force_https" value="1"
                                                   class="checkbox-input" <?php if ($force_https == '1') echo 'checked'; ?>>
                                            <label for="force_https"><?php echo $this->lang->line('Force HTTPS'); ?>
                                                ?</label>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('force_https'); ?></span>
                                    </fieldset>
                                </div>

                                <div class="form-group">
                                    <!-- <label for="email_sending_option"><i class="bx bx-at"></i> <?php echo $this->lang->line('Email Sending Option'); ?></label>  -->
                                    <?php
                                    $email_sending_option = $this->config->item('email_sending_option');
                                    if ($email_sending_option == '') $email_sending_option = 'php_mail';
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <fieldset>
                                                <div class="radio">
                                                    <input type="radio" name="email_sending_option" value="php_mail"
                                                           id="radio1" <?php if ($email_sending_option == 'php_mail') echo 'checked'; ?>>
                                                    <label for="radio1"><?php echo $this->lang->line('Use PHP Email Function'); ?></label>
                                                </div>
                                            </fieldset>

                                        </div>
                                        <div class="col-12 col-md-6">
                                            <fieldset>
                                                <div class="radio">
                                                    <input type="radio" name="email_sending_option" id="radio2"
                                                           value="smtp" <?php if ($email_sending_option == 'smtp') echo 'checked'; ?>>
                                                    <label for="radio2"><?php echo $this->lang->line('Use SMTP Email'); ?>
                                                        &nbsp;:&nbsp;<a
                                                                href="<?php echo base_url('admin/smtp_settings'); ?>"
                                                                class="float-right"> <?php echo $this->lang->line("SMTP Setting"); ?> </a>
                                                    </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('email_sending_option'); ?></span>
                                </div>

                                <div class="row">

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $enable_signup_form = $this->config->item('enable_signup_form');
                                            if ($enable_signup_form == '') $enable_signup_form = '1';
                                            ?>
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" name="enable_signup_form"
                                                           id="enable_signup_form" value="1"
                                                           class="checkbox-input" <?php if ($enable_signup_form == '1') echo 'checked'; ?>>
                                                    <label for="enable_signup_form"><?php echo $this->lang->line('Display Signup Page'); ?>
                                                        ?</label>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('enable_signup_form'); ?></span>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $enable_signup_activation = $this->config->item('enable_signup_activation');
                                            if ($enable_signup_activation == '') $enable_signup_activation = '1';
                                            ?>
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" name="enable_signup_activation"
                                                           id="enable_signup_activation" value="1"
                                                           class="checkbox-input" <?php if ($enable_signup_activation == '1') echo 'checked'; ?>>
                                                    <label for="enable_signup_activation"><?php echo $this->lang->line('Signup Email Activation'); ?>
                                                        ?</label>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('enable_signup_activation'); ?></span>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $instagram_reply_enable_disable = $this->config->item('instagram_reply_enable_disable');
                                            if ($instagram_reply_enable_disable == '') $instagram_reply_enable_disable = '0';
                                            ?>
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" name="instagram_reply_enable_disable"
                                                           id="instagram_reply_enable_disable" value="1"
                                                           class="checkbox-input" <?php if ($instagram_reply_enable_disable == '1') echo 'checked'; ?>>
                                                    <label for="instagram_reply_enable_disable"><?php echo $this->lang->line('Enable Features'); ?>
                                                        ?</label>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('instagram_reply_enable_disable'); ?></span>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div role="tabpanel" class="tab-pane card" id="logo-favicon" aria-labelledby="logo-favicon"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Logo & Favicon"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-6">
                                        <fieldset class="form-group">
                                            <label for="logo"><?php echo $this->lang->line("logo"); ?> (png)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                                <label class="custom-file-label"
                                                       for="inputGroupFile01"><?php echo $this->lang->line("Choose File"); ?></label>
                                                <small><?php echo $this->lang->line("Max Dimension"); ?> : 700 x
                                                    200, <?php echo $this->lang->line("Max Size"); ?> : 500KB </small>
                                            </div>
                                            <span class="text-danger"> <?php echo $this->session->userdata('logo_error');
                                                $this->session->unset_userdata('logo_error'); ?></span>
                                        </fieldset>
                                    </div>
                                    <div class="col-6 my-auto text-center">
                                        <img class="img-fluid" src="<?php echo base_url() . 'assets/img/logo.png'; ?>"
                                             alt="Logo"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <fieldset class="form-group">
                                            <label for="favicon"><?php echo $this->lang->line("Favicon"); ?>
                                                (png)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="favicon"
                                                       name="favicon">
                                                <label class="custom-file-label"
                                                       for="inputGroupFile01"><?php echo $this->lang->line("Choose File"); ?></label>
                                                <small><?php echo $this->lang->line("Dimension"); ?> : 100 x
                                                    100, <?php echo $this->lang->line("Max Size"); ?> : 50KB </small>
                                            </div>
                                            <span class="text-danger"> <?php echo $this->session->userdata('favicon_error');
                                                $this->session->unset_userdata('favicon_error'); ?></span>
                                        </fieldset>
                                    </div>
                                    <div class="col-6 my-auto text-center">
                                        <img class="img-fluid"
                                             src="<?php echo base_url() . 'assets/img/favicon.png'; ?>" alt="Favicon"
                                             style="max-width:50px;"/>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane card" id="master-password"
                             aria-labelledby="master-password" aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Master Password"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="master_password"><?php echo $this->lang->line("Master Password (will be used for login as user)"); ?></label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" class="form-control" name="master_password"
                                               value="******" id="master_password"
                                               placeholder="<?php echo $this->lang->line("Master Password (will be used for login as user)"); ?>">
                                        <div class="form-control-position">
                                            <i class="bx bxs-key"></i>
                                        </div>

                                    </fieldset>
                                    <span class="text-danger"><?php echo form_error('master_password'); ?></span>
                                    <div class="text-danger mt-1"><?php echo $this->lang->line('Set different than admin password.'); ?></div>
                                </div>
                                <div class="row d-none">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $backup_mode = $this->config->item('backup_mode');
                                            if ($backup_mode == '') $backup_mode = '0';
                                            ?>
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input" name="backup_mode"
                                                           id="backup_mode1"
                                                           value="1" <?php if ($backup_mode == '1') echo 'checked'; ?>>
                                                    <label for="backup_mode1"><?php echo $this->lang->line('Give access to user to set their own Facebook APP'); ?>
                                                        ?</label>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('backup_mode'); ?></span>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane card" id="subscriber" aria-labelledby="subscriber"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Subscriber"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 d-none">
                                        <div class="form-group">
                                            <?php
                                            $messengerbot_subscriber_avatar_download_limit_per_cron_job = $this->config->item('messengerbot_subscriber_avatar_download_limit_per_cron_job');
                                            if ($messengerbot_subscriber_avatar_download_limit_per_cron_job == "") $messengerbot_subscriber_avatar_download_limit_per_cron_job = 25;
                                            ?>
                                            <label for="messengerbot_subscriber_avatar_download_limit_per_cron_job"><?php echo $this->lang->line("Avatar download limit per cron job"); ?></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control"
                                                       name="messengerbot_subscriber_avatar_download_limit_per_cron_job"
                                                       id="messengerbot_subscriber_avatar_download_limit_per_cron_job"
                                                       value="<?php echo $messengerbot_subscriber_avatar_download_limit_per_cron_job; ?>"
                                                       placeholder="<?php echo $this->lang->line("Avatar download limit per cron job"); ?>"
                                                       min="1">
                                                <div class="form-control-position">
                                                    <i class="bx bx-sort-down"></i>
                                                </div>
                                            </fieldset>
                                            <span class="text-danger"><?php echo form_error('messengerbot_subscriber_avatar_download_limit_per_cron_job'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php
                                            $messengerbot_subscriber_profile_update_limit_per_cron_job = $this->config->item('messengerbot_subscriber_profile_update_limit_per_cron_job');
                                            if ($messengerbot_subscriber_profile_update_limit_per_cron_job == "") $messengerbot_subscriber_profile_update_limit_per_cron_job = 100;
                                            ?>
                                            <label for="messengerbot_subscriber_profile_update_limit_per_cron_job"><?php echo $this->lang->line("Profile information update limit per cron job"); ?></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control"
                                                       name="messengerbot_subscriber_profile_update_limit_per_cron_job"
                                                       id="messengerbot_subscriber_profile_update_limit_per_cron_job"
                                                       value="<?php echo $messengerbot_subscriber_profile_update_limit_per_cron_job; ?>"
                                                       placeholder="<?php echo $this->lang->line("Avatar download limit per cron job"); ?>"
                                                       min="1">
                                                <div class="form-control-position">
                                                    <i class="bx bx-edit-alt"></i>
                                                </div>
                                            </fieldset>
                                            <span class="text-danger"><?php echo form_error('messengerbot_subscriber_profile_update_limit_per_cron_job'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">

                                        <div class="form-group">
                                            <?php
                                            $enable_tracking_subscribers_last_interaction = $this->config->item('enable_tracking_subscribers_last_interaction');
                                            if ($enable_tracking_subscribers_last_interaction == '') $enable_tracking_subscribers_last_interaction = 'yes';
                                            ?>
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input" value="yes"
                                                           name="enable_tracking_subscribers_last_interaction"
                                                           id="enable_tracking_subscribers_last_interaction1" <?php if ($enable_tracking_subscribers_last_interaction == 'yes') echo 'checked'; ?>>
                                                    <label for="enable_tracking_subscribers_last_interaction1"><?php echo $this->lang->line('Enable Tracking of Subscribers Last Interaction'); ?></label>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('enable_tracking_subscribers_last_interaction'); ?></span>
                                            </fieldset>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane card" id="persistent-menu"
                             aria-labelledby="persistent-menu" aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Persistent Menu"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <?php
                                            $persistent_menu_copyright_text = $this->config->item('persistent_menu_copyright_text');
                                            if ($persistent_menu_copyright_text == "") $persistent_menu_copyright_text = $this->config->item("product_name");
                                            ?>
                                            <label for="persistent_menu_copyright_text"><?php echo $this->lang->line("Copyright text"); ?></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control"
                                                       name="persistent_menu_copyright_text"
                                                       id="persistent_menu_copyright_text"
                                                       placeholder="<?php echo $this->lang->line("Copyright text"); ?>"
                                                       value="<?php echo $persistent_menu_copyright_text; ?>">
                                                <div class="form-control-position">
                                                    <i class="bx bx-copyright"></i>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('persistent_menu_copyright_text'); ?></span>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for=""><i class="bx bx-link"></i> </label>
                                            <?php
                                            $persistent_menu_copyright_url = $this->config->item('persistent_menu_copyright_url');
                                            if ($persistent_menu_copyright_url == "") $persistent_menu_copyright_url = base_url();
                                            ?>
                                            <label for="persistent_menu_copyright_url"><?php echo $this->lang->line("Copyright URL"); ?></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control"
                                                       name="persistent_menu_copyright_url"
                                                       id="persistent_menu_copyright_url"
                                                       placeholder="<?php echo $this->lang->line("Copyright URL"); ?>"
                                                       value="<?php echo $persistent_menu_copyright_url; ?>">
                                                <div class="form-control-position">
                                                    <i class="bx bx-link"></i>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('persistent_menu_copyright_url'); ?></span>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <?php if ($this->is_broadcaster_exist) : ?>
                            <div role="tabpanel" class="tab-pane card" id="messenger-broadcast"
                                 aria-labelledby="messenger-broadcast" aria-expanded="true">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Messenger Broadcast"); ?></h4>
                                    <?php echo $save_button; ?>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 hidden">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $number_of_message_to_be_sent_in_try = $this->config->item('number_of_message_to_be_sent_in_try');
                                                        if ($number_of_message_to_be_sent_in_try == "") $number_of_message_to_be_sent_in_try = 10;
                                                        ?>
                                                        <label for="number_of_message_to_be_sent_in_try"><?php echo $this->lang->line("Conversation Broadcast - number of message send per cron job"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="number_of_message_to_be_sent_in_try"
                                                                   id="number_of_message_to_be_sent_in_try"
                                                                   placeholder="<?php echo $this->lang->line("Conversation Broadcast - number of message send per cron job"); ?>"
                                                                   value="<?php echo $number_of_message_to_be_sent_in_try; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-run"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('number_of_message_to_be_sent_in_try'); ?></span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $update_report_after_time = $this->config->item('update_report_after_time');
                                                        if ($update_report_after_time == "") $update_report_after_time = 5;
                                                        ?>
                                                        <label for="update_report_after_time"><?php echo $this->lang->line("Conversation Broadcast - message sending report update frequency"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="update_report_after_time"
                                                                   id="update_report_after_time"
                                                                   placeholder="<?php echo $this->lang->line("Conversation Broadcast - message sending report update frequency"); ?>"
                                                                   value="<?php echo $update_report_after_time; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-run"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('update_report_after_time'); ?></span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $conversation_broadcast_hold_after_number_of_errors = $this->config->item('conversation_broadcast_hold_after_number_of_errors');
                                                        if ($conversation_broadcast_hold_after_number_of_errors == "") $conversation_broadcast_hold_after_number_of_errors = 10;
                                                        ?>
                                                        <label for="conversation_broadcast_hold_after_number_of_errors"><?php echo $this->lang->line("Conversation Broadcast - hold after number of errors"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="conversation_broadcast_hold_after_number_of_errors"
                                                                   id="conversation_broadcast_hold_after_number_of_errors"
                                                                   placeholder="<?php echo $this->lang->line("Conversation Broadcast - hold after number of errors"); ?>"
                                                                   value="<?php echo $conversation_broadcast_hold_after_number_of_errors; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-user"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('conversation_broadcast_hold_after_number_of_errors'); ?></span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row <?php if (!$this->is_broadcaster_exist) echo 'hidden'; ?>">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $broadcaster_number_of_message_to_be_sent_in_try = $this->config->item('broadcaster_number_of_message_to_be_sent_in_try');
                                                        if ($broadcaster_number_of_message_to_be_sent_in_try == "") $broadcaster_number_of_message_to_be_sent_in_try = 120;
                                                        ?>
                                                        <label for="broadcaster_number_of_message_to_be_sent_in_try"><?php echo $this->lang->line("Subscriber Broadcast - number of message send per cron job"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="broadcaster_number_of_message_to_be_sent_in_try"
                                                                   id="broadcaster_number_of_message_to_be_sent_in_try"
                                                                   placeholder="<?php echo $this->lang->line("Subscriber Broadcast - number of message send per cron job"); ?>"
                                                                   value="<?php echo $broadcaster_number_of_message_to_be_sent_in_try; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-run"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('broadcaster_number_of_message_to_be_sent_in_try'); ?></span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $broadcaster_update_report_after_time = $this->config->item('broadcaster_update_report_after_time');
                                                        if ($broadcaster_update_report_after_time == "") $broadcaster_update_report_after_time = 20;
                                                        ?>
                                                        <label for="broadcaster_update_report_after_time"><?php echo $this->lang->line("Subscriber Broadcast - message sending report update frequency"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="broadcaster_update_report_after_time"
                                                                   id="broadcaster_update_report_after_time"
                                                                   placeholder="<?php echo $this->lang->line("Subscriber Broadcast - message sending report update frequency"); ?>"
                                                                   value="<?php echo $broadcaster_update_report_after_time; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-edit"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('broadcaster_update_report_after_time'); ?></span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $subscriber_broadcaster_hold_after_number_of_errors = $this->config->item('subscriber_broadcaster_hold_after_number_of_errors');

                                                        if ($subscriber_broadcaster_hold_after_number_of_errors == "") $subscriber_broadcaster_hold_after_number_of_errors = 30;
                                                        ?>
                                                        <label for="subscriber_broadcaster_hold_after_number_of_errors"><?php echo $this->lang->line("Subscriber Broadcast - hold after number of errors"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="subscriber_broadcaster_hold_after_number_of_errors"
                                                                   id="subscriber_broadcaster_hold_after_number_of_errors"
                                                                   placeholder="<?php echo $this->lang->line("Subscriber Broadcast - hold after number of errors"); ?>"
                                                                   value="<?php echo $subscriber_broadcaster_hold_after_number_of_errors; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-error"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('subscriber_broadcaster_hold_after_number_of_errors'); ?></span>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        <?php endif; ?>

                        <div role="tabpanel" class="tab-pane card" id="group-posting" aria-labelledby="group-posting"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Facebook Poster"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php
                                            $facebook_poster_botenabled_pages = $this->config->item('facebook_poster_botenabled_pages');
                                            if ($facebook_poster_botenabled_pages == '') $facebook_poster_botenabled_pages = '0';
                                            ?>
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input" value="1"
                                                           name="facebook_poster_botenabled_pages"
                                                           id="facebook_poster_botenabled_pages1" <?php if ($facebook_poster_botenabled_pages == '1') echo 'checked'; ?>>
                                                    <label for="facebook_poster_botenabled_pages1"><?php echo $this->lang->line('Use only bot connection enabled pages for posting.'); ?></label>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('facebook_poster_botenabled_pages'); ?></span>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <?php if ($this->is_group_posting_exist) : ?>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <?php
                                                $facebook_poster_group_enable_disable = $this->config->item('facebook_poster_group_enable_disable');
                                                if ($facebook_poster_group_enable_disable == '') $facebook_poster_group_enable_disable = '0';
                                                ?>
                                                <fieldset>
                                                    <div class="checkbox">
                                                        <input type="checkbox" class="checkbox-input" value="1"
                                                               name="facebook_poster_group_enable_disable"
                                                               id="facebook_poster_group_enable_disable1" <?php if ($facebook_poster_group_enable_disable == '1') echo 'checked'; ?>>
                                                        <label for="facebook_poster_group_enable_disable1"><?php echo $this->lang->line('Do You Want To Enable Group Post?'); ?></label>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('facebook_poster_group_enable_disable'); ?></span>
                                                </fieldset>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>

                        <?php if ($this->basic->is_exist("modules", array("id" => 263)) || $this->basic->is_exist("modules", array("id" => 264))) { ?>
                            <div role="tabpanel" class="tab-pane card" id="sms_email_settings"
                                 aria-labelledby="sms_email_settings" aria-expanded="true">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("SMS/Email Manager"); ?></h4>
                                    <?php echo $save_button; ?>
                                </div>
                                <div class="card-body">
                                    <div class="row pills-stacked">
                                        <div class="col-md-2 col-sm-12">
                                            <ul class="nav nav-pills flex-column text-center text-md-left">
                                                <li class="nav-item hidden">
                                                    <a class="nav-link" id="sms_email_api_tab" id="sms_email_api_access"
                                                       data-toggle="pill" href="#sms_email_api_tab"
                                                       aria-expanded="false">
                                                        <?php echo $this->lang->line("SMS/Email API Access") ?>
                                                    </a>
                                                </li>

                                                <?php if ($this->basic->is_exist("modules", array("id" => 264))) { ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="sms_sending_content"
                                                           data-toggle="pill" href="#sms_sending_data"
                                                           aria-expanded="true">
                                                            <?php echo $this->lang->line("SMS"); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>

                                                <?php if ($this->basic->is_exist("modules", array("id" => 263))) { ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="email_sending_content"
                                                           data-toggle="pill" href="#email_sending_data"
                                                           aria-expanded="false">
                                                            <?php echo $this->lang->line("Email"); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="col-md-10 col-sm-12">
                                            <div class="tab-content p-0 shadow-none">
                                                <?php if ($this->basic->is_exist("modules", array("id" => 264))) { ?>
                                                    <div role="tabpanel" class="tab-pane active" id="sms_sending_data"
                                                         aria-labelledby="sms_sending_content"
                                                         aria-expanded="true">
                                                        <?php
                                                        $number_of_sms_to_be_sent_in_try = $this->config->item('number_of_sms_to_be_sent_in_try');
                                                        if ($number_of_sms_to_be_sent_in_try == "") $number_of_sms_to_be_sent_in_try = 100;
                                                        ?>
                                                        <label for="number_of_sms_to_be_sent_in_try"><?php echo $this->lang->line("Number of SMS send per cron job"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="number_of_sms_to_be_sent_in_try"
                                                                   id="number_of_sms_to_be_sent_in_try"
                                                                   placeholder="<?php echo $this->lang->line("Number of SMS send per cron job"); ?>"
                                                                   value="<?php echo $number_of_sms_to_be_sent_in_try; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-sort"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('number_of_sms_to_be_sent_in_try'); ?></span>
                                                        </fieldset>

                                                        <?php
                                                        $update_sms_sending_report_after_time = $this->config->item('update_sms_sending_report_after_time');
                                                        if ($update_sms_sending_report_after_time == "") $update_sms_sending_report_after_time = 50;
                                                        ?>
                                                        <label for="update_sms_sending_report_after_time"><?php echo $this->lang->line("SMS sending report update frequency"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="update_sms_sending_report_after_time"
                                                                   id="update_sms_sending_report_after_time"
                                                                   placeholder="<?php echo $this->lang->line("SMS sending report update frequency"); ?>"
                                                                   value="<?php echo $update_sms_sending_report_after_time; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-edit"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('update_sms_sending_report_after_time'); ?></span>
                                                        </fieldset>

                                                    </div>
                                                <?php } ?>

                                                <div class="tab-pane" id="sms_email_api_tab" role="tabpanel"
                                                     aria-labelledby="sms_email_api_tab"
                                                     aria-expanded="false">
                                                    <?php if ($this->basic->is_exist("modules", array("id" => 264))) { ?>
                                                        <h6><?php echo $this->lang->line("Give SMS API Access to User"); ?></h6>
                                                        <div class="form-group">
                                                            <?php
                                                            $sms_api_access = $this->config->item('sms_api_access');
                                                            if ($sms_api_access == '') $sms_api_access = '0';
                                                            echo form_dropdown('sms_api_access', array('0' => $this->lang->line('no'), '1' => $this->lang->line('yes')), $sms_api_access, 'class="select2 form-control " id="sms_api_access" style="width:100%"'); ?>
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('sms_api_access'); ?></span>
                                                    <?php } ?>
                                                    <?php if ($this->basic->is_exist("modules", array("id" => 263))) { ?>
                                                        <div class="form-group">
                                                            <label for=""><i
                                                                        class="bx bx-envelope"></i> <?php echo $this->lang->line("Give Email API Access to User"); ?>
                                                            </label>
                                                            <?php
                                                            $email_api_access = $this->config->item('email_api_access');
                                                            if ($email_api_access == '') $email_api_access = '0';
                                                            echo form_dropdown('email_api_access', array('0' => $this->lang->line('no'), '1' => $this->lang->line('yes')), $email_api_access, 'class="select2 form-control" id="email_api_access" style="width:100%"'); ?>
                                                            <span class="text-danger"><?php echo form_error('email_api_access'); ?></span>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <?php if ($this->basic->is_exist("modules", array("id" => 263))) { ?>
                                                    <div class="tab-pane" id="email_sending_data" role="tabpanel"
                                                         aria-labelledby="email_sending_content"
                                                         aria-expanded="false">

                                                        <?php
                                                        $number_of_email_to_be_sent_in_try = $this->config->item('number_of_email_to_be_sent_in_try');
                                                        if ($number_of_email_to_be_sent_in_try == "") $number_of_email_to_be_sent_in_try = 100;
                                                        ?>
                                                        <label for="number_of_email_to_be_sent_in_try"><?php echo $this->lang->line("Number of Email send per cron job"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="number_of_email_to_be_sent_in_try"
                                                                   id="number_of_email_to_be_sent_in_try"
                                                                   placeholder="<?php echo $this->lang->line("Number of Email send per cron job"); ?>"
                                                                   value="<?php echo $number_of_email_to_be_sent_in_try; ?>"
                                                                   min="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-sort"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('number_of_email_to_be_sent_in_try'); ?></span>
                                                        </fieldset>

                                                        <?php
                                                        $update_email_sending_report_after_time = $this->config->item('update_email_sending_report_after_time');
                                                        if ($update_email_sending_report_after_time == "") $update_email_sending_report_after_time = 50;
                                                        ?>
                                                        <label for="update_email_sending_report_after_time"><?php echo $this->lang->line("Email sending report update frequency"); ?></label>
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="number" class="form-control"
                                                                   name="update_email_sending_report_after_time"
                                                                   id="update_email_sending_report_after_time" <?php echo $this->lang->line("Email sending report update frequency"); ?>
                                                            ="placeholder" value=
                                                            "<?php echo $update_email_sending_report_after_time; ?>" min
                                                            ="1">
                                                            <div class="form-control-position">
                                                                <i class="bx bx-edit"></i>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('update_email_sending_report_after_time'); ?></span>
                                                        </fieldset>

                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <?php
                                                                $enable_open_rate = $this->config->item('enable_open_rate');
                                                                if ($enable_open_rate == "") $enable_open_rate = '0';
                                                                ?>
                                                                <fieldset>
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" class="checkbox-input"
                                                                               value="1" name="enable_open_rate"
                                                                               id="enable_open_rate1" <?php if ($enable_open_rate == '1') echo 'checked'; ?>>
                                                                        <label for="enable_open_rate1"><?php echo $this->lang->line('Enable Open Rate'); ?></label>
                                                                    </div>
                                                                    <span class="text-danger"><?php echo form_error('enable_open_rate'); ?></span>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-12 col-md-6">
                                                                <?php
                                                                $enable_click_rate = $this->config->item('enable_click_rate');
                                                                if ($enable_click_rate == "") $enable_click_rate = '0';
                                                                ?>
                                                                <fieldset>
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" class="checkbox-input"
                                                                               value="1" name="enable_click_rate"
                                                                               id="enable_click_rate1" <?php if ($enable_click_rate == '1') echo 'checked'; ?>>
                                                                        <label for="enable_click_rate1"><?php echo $this->lang->line('Enable Click Rate'); ?></label>
                                                                    </div>
                                                                    <span class="text-danger"><?php echo form_error('enable_click_rate'); ?></span>
                                                                </fieldset>
                                                            </div>
                                                        </div>


                                                    </div>
                                                <?php } ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div role="tabpanel" class="tab-pane card" id="email_auto_responder"
                             aria-labelledby="email_auto_responder" aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Email Auto Responder"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-12 col-md-4">
                                        <ul class="nav nav-pills flex-column text-center text-md-left">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="mailchimp_content" data-toggle="tab"
                                                   href="#mailchimp" role="tab" aria-controls="home"
                                                   aria-selected="true"><?php echo $this->lang->line("MailChimp Integration"); ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="sendinblue_content" data-toggle="tab"
                                                   href="#sendinblue" role="tab" aria-controls="home"
                                                   aria-selected="true"><?php echo $this->lang->line("Sendinblue Integration"); ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="activecampaign_content" data-toggle="tab"
                                                   href="#activecampaign" role="tab" aria-controls="home"
                                                   aria-selected="true"><?php echo $this->lang->line("Activecampaign Integration"); ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="mautic_content" data-toggle="tab" href="#mautic"
                                                   role="tab" aria-controls="home"
                                                   aria-selected="true"><?php echo $this->lang->line("Mautic Integration"); ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="acelle_content" data-toggle="tab" href="#acelle"
                                                   role="tab" aria-controls="home"
                                                   aria-selected="true"><?php echo $this->lang->line("Acelle Integration"); ?></a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="tab-content shadow-none no-padding" id="">

                                            <div class="tab-pane  active" id="mailchimp" role="tabpanel"
                                                 aria-labelledby="mailchimp_content">
                                                <div class="border-bottom">
                                                    <h4 class="card-title d-flex align-items-center font-small-2"><?php echo $this->lang->line("MailChimp Integration"); ?></h4>
                                                    <div class="heading-elements" style="top:0px;">
                                                        <a href="<?php echo base_url('email_auto_responder_integration/mailchimp_list'); ?>"
                                                           target="_BLANK" class="btn btn-outline-light"><i
                                                                    class="bx bx-plus"></i><span
                                                                    style="font-size: 12px !important;"><?php echo $this->lang->line('Add MailChimp API'); ?></span></a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Select MailChimp List where email will be sent when user signup. sign-up-{product short name} will be used as Tag Name in your MailChimp list."); ?></label>
                                                    <select class="select2 form-control" id="mailchimp_list_id"
                                                            name="mailchimp_list_id[]" multiple="">
                                                        <?php
                                                        echo "<option value='0'>" . $this->lang->line('Choose a List') . "</option>";
                                                        foreach ($mailchimp_list as $key => $value) {
                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                if (in_array($value2['table_id'], $selected_mailchimp_list_ids)) $selected = 'selected';
                                                                else $selected = '';
                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                            }
                                                            echo '</optgroup>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="tab-pane " id="sendinblue" role="tabpanel"
                                                 aria-labelledby="sendinblue_content">
                                                <div class="border-bottom">
                                                    <h4 class="card-title d-flex align-items-center font-small-2"><?php echo $this->lang->line("Sendinblue Integration"); ?></h4>
                                                    <div class="heading-elements" style="top:0px;">
                                                        <a href="<?php echo base_url('email_auto_responder_integration/sendinblue_list'); ?>"
                                                           target="_BLANK" class="btn btn-outline-light"><i
                                                                    class="bx bx-plus"></i><span
                                                                    style="font-size: 12px !important;"><?php echo $this->lang->line('Add Sendinblue API'); ?></span></a>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Select Sendinblue list where email will be sent when user signup."); ?></label>
                                                    <select class="select2 form-control" id="sendinblue_list_id"
                                                            name="sendinblue_list_id[]" multiple="">
                                                        <?php
                                                        echo "<option value='0'>" . $this->lang->line('Choose a List') . "</option>";
                                                        foreach ($sendinblue_list as $key => $value) {
                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                if (in_array($value2['table_id'], $selected_sendinblue_list_ids)) $selected = 'selected';
                                                                else $selected = '';
                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                            }
                                                            echo '</optgroup>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="activecampaign" role="tabpanel"
                                                 aria-labelledby="activecampaign_content">
                                                <div class="border-bottom">
                                                    <h4 class="card-title d-flex align-items-center font-small-2"><?php echo $this->lang->line("Activecampaign Integration"); ?></h4>
                                                    <div class="heading-elements" style="top:0px;">
                                                        <a href="<?php echo base_url('email_auto_responder_integration/activecampaign_list'); ?>"
                                                           target="_BLANK" class="btn btn-outline-light"><i
                                                                    class="bx bx-plus"></i><span
                                                                    style="font-size: 12px !important;"><?php echo $this->lang->line('Add Activecampaign API'); ?></span></a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Select Activecampaign list where email will be sent when user signup."); ?></label>
                                                    <select class="select2 form-control" id="activecampaign_list_id"
                                                            name="activecampaign_list_id[]" multiple="">
                                                        <?php
                                                        echo "<option value='0'>" . $this->lang->line('Choose a List') . "</option>";
                                                        foreach ($activecampaign_list as $key => $value) {
                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                if (in_array($value2['table_id'], $selected_activecampaign_list_ids)) $selected = 'selected';
                                                                else $selected = '';
                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                            }
                                                            echo '</optgroup>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="mautic" role="tabpanel"
                                                 aria-labelledby="mautic_content">
                                                <div class="border-bottom">
                                                    <h4 class="card-title d-flex align-items-center font-small-2"><?php echo $this->lang->line("Mautic Integration"); ?></h4>
                                                    <div class="heading-elements" style="top:0px;">
                                                        <a href="<?php echo base_url('email_auto_responder_integration/mautic_list'); ?>"
                                                           target="_BLANK" class="btn btn-outline-light"><i
                                                                    class="bx bx-plus"></i><span
                                                                    style="font-size: 12px !important;"><?php echo $this->lang->line('Add Mautic API'); ?></span></a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Select Mautic list where email will be sent when user signup. sign-up-{product short name} will be used as tag name in your Mautic list."); ?></label>
                                                    <select class="select2 form-control" id="mautic_list_id"
                                                            name="mautic_list_id[]" multiple="">
                                                        <?php
                                                        echo "<option value='0'>" . $this->lang->line('Choose a List') . "</option>";
                                                        foreach ($mautic_list as $key => $value) {
                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                if (in_array($value2['table_id'], $selected_mautic_list_ids)) $selected = 'selected';
                                                                else $selected = '';
                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                            }
                                                            echo '</optgroup>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="acelle" role="tabpanel"
                                                 aria-labelledby="acelle_content">
                                                <div class="border-bottom">
                                                    <h4 class="card-title d-flex align-items-center font-small-2"><?php echo $this->lang->line("Acelle Integration"); ?></h4>
                                                    <div class="heading-elements" style="top:0px;">
                                                        <a href="<?php echo base_url('email_auto_responder_integration/acelle_list'); ?>"
                                                           target="_BLANK" class="btn btn-outline-light"><i
                                                                    class="bx bx-plus"></i><span
                                                                    style="font-size: 12px !important;"><?php echo $this->lang->line('Add Acelle API'); ?></span></a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Select Acelle list where email will be sent when user signup."); ?></label>
                                                    <select class="select2 form-control" id="acelle_list_id"
                                                            name="acelle_list_id[]" multiple="">
                                                        <?php
                                                        echo "<option value='0'>" . $this->lang->line('Choose a List') . "</option>";
                                                        foreach ($acelle_list as $key => $value) {
                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                if (in_array($value2['table_id'], $selected_acelle_list_ids)) $selected = 'selected';
                                                                else $selected = '';
                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                            }
                                                            echo '</optgroup>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>


                                        </div>


                                    </div>
                                </div>

                            </div>

                        </div>

                        <?php if ($this->session->userdata('license_type') == 'double') { ?>
                            <div role="tabpanel" class="tab-pane card" id="support-desk" aria-labelledby="support-desk"
                                 aria-expanded="true">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Support Desk"); ?></h4>
                                    <?php echo $save_button; ?>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <?php
                                        $enable_support = $this->config->item('enable_support');
                                        if ($enable_support == '') $enable_support = '1';
                                        ?>
                                        <fieldset>
                                            <div class="checkbox">
                                                <input type="checkbox" class="checkbox-input" value="1"
                                                       name="enable_support"
                                                       id="enable_support1" <?php if ($enable_support == '1') echo 'checked'; ?>>
                                                <label for="enable_support1"><?php echo $this->lang->line('Enable Support Desk for Users'); ?></label>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('enable_support'); ?></span>
                                        </fieldset>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>

                        <div role="tabpanel" class="tab-pane card" id="file-upload" aria-labelledby="file-upload"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("File Upload"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <ul class="nav nav-pills flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="facebook_poster_content"
                                                   data-toggle="pill" href="#facebook_poster"
                                                   aria-selected="true"><?php echo $this->lang->line("Facebook Poster"); ?></a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="auto_reply_content" data-toggle="pill"
                                                   href="#auto_reply_up"
                                                   aria-selected="false"><?php echo $this->lang->line("Auto Reply"); ?></a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="comboposter_content" data-toggle="pill"
                                                   href="#comboposter"
                                                   aria-selected="false"><?php echo $this->lang->line("Comboposter"); ?></a>
                                            </li>

                                            <li class="nav-item hidden">
                                                <a class="nav-link" id="vidcaster_content" data-toggle="pill"
                                                   href="#vidcaster"
                                                   aria-selected="false"><?php echo $this->lang->line("Vidcaster Live"); ?></a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="messenger_content" data-toggle="pill"
                                                   href="#messenger_bot"
                                                   aria-selected="false"><?php echo $this->lang->line("Messenger Bot") ?></a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="tab-content p-0 shadow-none">

                                            <div class="tab-pane  active" id="facebook_poster" role="tabpanel"
                                                 aria-labelledby="facebook_poster_content">
                                                <?php
                                                $facebook_poster_image_upload_limit = $this->config->item('facebook_poster_image_upload_limit');
                                                if ($facebook_poster_image_upload_limit == "") $facebook_poster_image_upload_limit = 1;
                                                ?>
                                                <label for="facebook_poster_image_upload_limit"><?php echo $this->lang->line("Image Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-image"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="facebook_poster_image_upload_limit"
                                                               name="facebook_poster_image_upload_limit"
                                                               value="<?php echo $facebook_poster_image_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Image Upload Limit (MB)"); ?>"
                                                               aria-describedby="facebook_poster_image_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="facebook_poster_image_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('facebook_poster_image_upload_limit'); ?></span>
                                                </fieldset>

                                                <?php
                                                $facebook_poster_video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');
                                                if ($facebook_poster_video_upload_limit == "") $facebook_poster_video_upload_limit = 10;
                                                ?>
                                                <label for="facebook_poster_video_upload_limit"><?php echo $this->lang->line("Video Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-video"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="facebook_poster_video_upload_limit"
                                                               name="facebook_poster_video_upload_limit"
                                                               value="<?php echo $facebook_poster_video_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Video Upload Limit (MB)"); ?>"
                                                               aria-describedby="facebook_poster_video_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="facebook_poster_video_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('facebook_poster_video_upload_limit'); ?></span>
                                                </fieldset>

                                            </div>

                                            <div class="tab-pane fade" id="auto_reply_up" role="tabpanel"
                                                 aria-labelledby="auto_reply_content">
                                                <?php
                                                $autoreply_image_upload_limit = $this->config->item('autoreply_image_upload_limit');
                                                if ($autoreply_image_upload_limit == "") $autoreply_image_upload_limit = 1;
                                                ?>
                                                <label for="autoreply_image_upload_limit"> <?php echo $this->lang->line("Image Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-image"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="autoreply_image_upload_limit"
                                                               name="autoreply_image_upload_limit"
                                                               value="<?php echo $autoreply_image_upload_limit; ?>"
                                                               placeholder=" <?php echo $this->lang->line("Image Upload Limit (MB)"); ?>"
                                                               aria-describedby="autoreply_image_upload_limit2" min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="autoreply_image_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('autoreply_image_upload_limit'); ?></span>
                                                </fieldset>

                                                <?php
                                                $autoreply_video_upload_limit = $this->config->item('autoreply_video_upload_limit');
                                                if ($autoreply_video_upload_limit == "") $autoreply_video_upload_limit = 3;
                                                ?>
                                                <label for="autoreply_video_upload_limit"><?php echo $this->lang->line("Video Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-video"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="autoreply_video_upload_limit"
                                                               name="autoreply_video_upload_limit"
                                                               value="<?php echo $autoreply_video_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Video Upload Limit (MB)"); ?>"
                                                               aria-describedby="autoreply_video_upload_limit2" min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="autoreply_video_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('autoreply_video_upload_limit'); ?></span>
                                                </fieldset>

                                            </div>

                                            <div class="tab-pane fade" id="comboposter" role="tabpanel"
                                                 aria-labelledby="comboposter_content">
                                                <?php
                                                $comboposter_image_upload_limit = $this->config->item('comboposter_image_upload_limit');
                                                if ($comboposter_image_upload_limit == "") $comboposter_image_upload_limit = 1;
                                                ?>
                                                <label for="comboposter_image_upload_limit"><?php echo $this->lang->line("Image Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-image"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="comboposter_image_upload_limit"
                                                               name="comboposter_image_upload_limit"
                                                               value="<?php echo $comboposter_image_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Image Upload Limit (MB)"); ?>"
                                                               aria-describedby="comboposter_image_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="comboposter_image_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('comboposter_image_upload_limit'); ?></span>
                                                </fieldset>

                                                <?php
                                                $comboposter_video_upload_limit = $this->config->item('comboposter_video_upload_limit');
                                                if ($comboposter_video_upload_limit == "") $comboposter_video_upload_limit = 10;
                                                ?>
                                                <label for="comboposter_video_upload_limit"><?php echo $this->lang->line("Video Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-video"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="comboposter_video_upload_limit"
                                                               name="comboposter_video_upload_limit"
                                                               value="<?php echo $comboposter_video_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Video Upload Limit (MB)"); ?>"
                                                               aria-describedby="comboposter_video_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="comboposter_video_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('comboposter_video_upload_limit'); ?></span>
                                                </fieldset>

                                            </div>

                                            <div class="tab-pane fade" id="vidcaster" role="tabpanel"
                                                 aria-labelledby="vidcaster_content">
                                                <?php
                                                $vidcaster_image_upload_limit = $this->config->item('vidcaster_image_upload_limit');
                                                if ($vidcaster_image_upload_limit == "") $vidcaster_image_upload_limit = 1;
                                                ?>
                                                <label for="vidcaster_image_upload_limit"><?php echo $this->lang->line("Image Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-image"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="vidcaster_image_upload_limit"
                                                               name="vidcaster_image_upload_limit"
                                                               value="<?php echo $vidcaster_image_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Image Upload Limit (MB)"); ?>"
                                                               aria-describedby="vidcaster_image_upload_limit2" min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="vidcaster_image_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('vidcaster_image_upload_limit'); ?></span>
                                                </fieldset>

                                                <?php
                                                $vidcaster_video_upload_limit = $this->config->item('vidcaster_video_upload_limit');
                                                if ($vidcaster_video_upload_limit == "") $vidcaster_video_upload_limit = 30;
                                                ?>
                                                <label for="vidcaster_video_upload_limit"><?php echo $this->lang->line("Video Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-video"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="vidcaster_video_upload_limit"
                                                               name="vidcaster_video_upload_limit"
                                                               value="<?php echo $vidcaster_video_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Video Upload Limit (MB)"); ?>"
                                                               aria-describedby="vidcaster_video_upload_limit2" min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="vidcaster_video_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('vidcaster_video_upload_limit'); ?></span>
                                                </fieldset>

                                            </div>

                                            <div class="tab-pane fade" id="messenger_bot" role="tabpanel"
                                                 aria-labelledby="messenger_content">
                                                <?php
                                                $messengerbot_image_upload_limit = $this->config->item('messengerbot_image_upload_limit');
                                                if ($messengerbot_image_upload_limit == "") $messengerbot_image_upload_limit = 1;
                                                ?>
                                                <label for="messengerbot_image_upload_limit"><?php echo $this->lang->line("Image Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-image"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="messengerbot_image_upload_limit"
                                                               name="messengerbot_image_upload_limit"
                                                               value="<?php echo $messengerbot_image_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Image Upload Limit (MB)"); ?>"
                                                               aria-describedby="messengerbot_image_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="messengerbot_image_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('messengerbot_image_upload_limit'); ?></span>
                                                </fieldset>

                                                <?php
                                                $messengerbot_video_upload_limit = $this->config->item('messengerbot_video_upload_limit');
                                                if ($messengerbot_video_upload_limit == "") $messengerbot_video_upload_limit = 5;
                                                ?>
                                                <label for="messengerbot_video_upload_limit"><?php echo $this->lang->line("Video Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-video"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="messengerbot_video_upload_limit"
                                                               name="messengerbot_video_upload_limit"
                                                               value="<?php echo $messengerbot_video_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Video Upload Limit (MB)"); ?>"
                                                               aria-describedby="messengerbot_video_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="messengerbot_video_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('messengerbot_video_upload_limit'); ?></span>
                                                </fieldset>


                                                <?php
                                                $messengerbot_audio_upload_limit = $this->config->item('messengerbot_audio_upload_limit');
                                                if ($messengerbot_audio_upload_limit == "") $messengerbot_audio_upload_limit = 3;
                                                ?>
                                                <label for="messengerbot_audio_upload_limit"><?php echo $this->lang->line("Audio Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-music"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="messengerbot_audio_upload_limit"
                                                               name="messengerbot_audio_upload_limit"
                                                               value="<?php echo $messengerbot_audio_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("Audio Upload Limit (MB)"); ?>"
                                                               aria-describedby="messengerbot_audio_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="messengerbot_audio_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('messengerbot_audio_upload_limit'); ?></span>
                                                </fieldset>

                                                <?php
                                                $messengerbot_file_upload_limit = $this->config->item('messengerbot_file_upload_limit');
                                                if ($messengerbot_file_upload_limit == "") $messengerbot_file_upload_limit = 2;
                                                ?>
                                                <label for="messengerbot_file_upload_limit"><?php echo $this->lang->line("File Upload Limit (MB)"); ?></label>
                                                <fieldset class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                        class="bx bx-file"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                               id="messengerbot_file_upload_limit"
                                                               name="messengerbot_file_upload_limit"
                                                               value="<?php echo $messengerbot_file_upload_limit; ?>"
                                                               placeholder="<?php echo $this->lang->line("File Upload Limit (MB)"); ?>"
                                                               aria-describedby="messengerbot_file_upload_limit2"
                                                               min="1">

                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                  id="messengerbot_file_upload_limit2">mb</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('messengerbot_file_upload_limit'); ?></span>
                                                </fieldset>

                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane card" id="junk_data" aria-labelledby="junk_data"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Junk Data Deletion"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php
                                        $delete_junk_data_after_how_many_days = $this->config->item('delete_junk_data_after_how_many_days');
                                        if ($delete_junk_data_after_how_many_days == "") $delete_junk_data_after_how_many_days = 30;
                                        ?>
                                        <label for="delete_junk_data_after_how_many_days"><?php echo $this->lang->line("Delete broadcasting / auto-reply report data, log data after how many days?"); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="number" class="form-control"
                                                   name="delete_junk_data_after_how_many_days"
                                                   id="delete_junk_data_after_how_many_days"
                                                   placeholder="<?php echo $this->lang->line("Delete broadcasting / auto-reply report data, log data after how many days?"); ?>"
                                                   value="<?php echo $delete_junk_data_after_how_many_days; ?>" min="1">
                                            <div class="form-control-position">
                                                <i class="bx bx-calendar"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('delete_junk_data_after_how_many_days'); ?></span>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <?php if ($this->basic->is_exist("add_ons", array("project_id" => 41))) : ?>
                            <div role="tabpanel" class="tab-pane card" id="fb_live" aria-labelledby="fb_live"
                                 aria-expanded="true">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Facebook Live Streaming"); ?></h4>
                                    <?php echo $save_button; ?>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php if ($this->config->item('ffmpeg_path') == "") $ffmpeg_path = "ffmpeg"; else $ffmpeg_path = $this->config->item('ffmpeg_path'); ?>
                                            <label for="ffmpeg_path"><?php echo $this->lang->line("FFMPEG path"); ?></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control" name="ffmpeg_path"
                                                       id="ffmpeg_path"
                                                       placeholder="<?php echo $this->lang->line("FFMPEG path"); ?>"
                                                       value="<?php echo $ffmpeg_path; ?>">
                                                <div class="form-control-position">
                                                    <i class="bx bx-bug"></i>
                                                </div>
                                                <small><?php echo $this->lang->line('It can be different like in many server like this'); ?>
                                                    : <b>/usr/local/bin/ffmpeg</b></small>
                                                <span class="text-danger"><?php echo form_error('ffmpeg_path'); ?></span>
                                            </fieldset>
                                        </div>

                                        <div class="col-sm-12">
                                            <?php if ($this->config->item('maximum_simultaneous_live_stream') == "") $maximum_simultaneous_live_stream = 10; else $maximum_simultaneous_live_stream = $this->config->item('maximum_simultaneous_live_stream'); ?>
                                            <label for="maximum_simultaneous_live_stream"><?php echo $this->lang->line("Maximum simultaneous live stream"); ?></label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control"
                                                       name="maximum_simultaneous_live_stream"
                                                       id="maximum_simultaneous_live_stream"
                                                       placeholder="<?php echo $this->lang->line("Maximum simultaneous live stream"); ?>"
                                                       value="<?php echo $maximum_simultaneous_live_stream; ?>" min="1">
                                                <div class="form-control-position">
                                                    <i class="bx bx-expand"></i>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('maximum_simultaneous_live_stream'); ?></span>
                                            </fieldset>
                                        </div>

                                        <div class="col-sm-12">
                                            <?php if ($this->config->item('maximum_length_of_live_stream') == "") $maximum_length_of_live_stream = 1; else $maximum_length_of_live_stream = $this->config->item('maximum_length_of_live_stream'); ?>
                                            <label for="maximum_length_of_live_stream"><?php echo $this->lang->line("maximum length of live stream"); ?>
                                                (<?php echo $this->lang->line("hour"); ?>)</label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control"
                                                       name="maximum_length_of_live_stream"
                                                       id="maximum_length_of_live_stream"
                                                       placeholder="<?php echo $this->lang->line("maximum length of live stream"); ?> (<?php echo $this->lang->line("hour"); ?>)"
                                                       value="<?php echo $maximum_length_of_live_stream; ?>" min="1">
                                                <div class="form-control-position">
                                                    <i class="bx bx-time"></i>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('maximum_length_of_live_stream'); ?></span>
                                            </fieldset>
                                        </div>

                                        <div class="col-sm-12">
                                            <?php if ($this->config->item('allowed_video_size') == "") $allowed_video_size = 200; else $allowed_video_size = $this->config->item('allowed_video_size'); ?>
                                            <label for="allowed_video_size"><?php echo $this->lang->line("maximum allowed video size"); ?>
                                                (MB)</label>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="number" class="form-control" name="allowed_video_size"
                                                       id="allowed_video_size"
                                                       placeholder="<?php echo $this->lang->line("maximum allowed video size"); ?> (MB)"
                                                       value="<?php echo $allowed_video_size; ?>" min="1">
                                                <div class="form-control-position">
                                                    <i class="bx bx-save"></i>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('allowed_video_size'); ?></span>
                                            </fieldset>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        <?php endif; ?>

                        <div role="tabpanel" class="tab-pane card" id="server-status" aria-labelledby="server-status"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Server Status"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <?php

                                $sql = "SHOW VARIABLES;";
                                $mysql_variables = $this->basic->execute_query($sql);
                                $variables_array_format = array();
                                foreach ($mysql_variables as $my_var) {
                                    $variables_array_format[$my_var['Variable_name']] = $my_var['Value'];
                                }
                                $disply_index = array("version", "innodb_version", "innodb_log_file_size", "wait_timeout", "max_connections", "connect_timeout", "max_allowed_packet", "innodb_lock_wait_timeout");

                                $list1 = $list2 = "";
                                $make_dir = (!function_exists('mkdir')) ? $this->lang->line("Disabled") : $this->lang->line("Enabled");
                                $zip_archive = (!class_exists('ZipArchive')) ? $this->lang->line("Disabled") : $this->lang->line("Enabled");
                                $list1 .= "<li class='list-group-item'><b>mkdir</b> : " . $make_dir . "</li>";
                                $list2 .= "<li class='list-group-item'><b>ZipArchive</b> : " . $zip_archive . "</li>";

                                if (function_exists('curl_version')) $curl = "Enabled";
                                else $curl = "Disabled";

                                if (function_exists('mb_detect_encoding')) $mbstring = "Enabled";
                                else $mbstring = "Disabled";

                                if (function_exists('set_time_limit')) $set_time_limit = "Enabled";
                                else $set_time_limit = "Disabled";

                                if (function_exists('exec')) $exec = "Enabled";
                                else $exec = "Disabled";

                                $list2 .= "<li class='list-group-item'><b>curl</b> : " . $curl . "</li>";
                                $list1 .= "<li class='list-group-item'><b>exec</b> : " . $exec . "</li>";
                                $list2 .= "<li class='list-group-item'><b>mb_detect_encoding</b> : " . $mbstring . "</li>";
                                $list2 .= "<li class='list-group-item'><b>set_time_limit</b> : " . $set_time_limit . "</li>";


                                if (function_exists('ini_get')) {
                                    if (ini_get('safe_mode'))
                                        $safe_mode = "ON, please set safe_mode=off";
                                    else $safe_mode = "OFF";

                                    if (ini_get('open_basedir') == "")
                                        $open_basedir = "No Value";
                                    else $open_basedir = "Has value";

                                    if (ini_get('allow_url_fopen'))
                                        $allow_url_fopen = "TRUE";
                                    else $allow_url_fopen = "FALSE";

                                    $list1 .= "<li class='list-group-item'><b>safe_mode</b> : " . $safe_mode . "</li>";
                                    $list2 .= "<li class='list-group-item'><b>open_basedir</b> : " . $open_basedir . "</li>";
                                    $list1 .= "<li class='list-group-item'><b>allow_url_fopen</b> : " . $allow_url_fopen . "</li>";
                                    $list1 .= "<li class='list-group-item'><b>upload_max_filesize</b> : " . ini_get('upload_max_filesize') . "</li>";
                                    $list1 .= "<li class='list-group-item'><b>max_input_time</b> : " . ini_get('max_input_time') . "</li>";
                                    $list2 .= "<li class='list-group-item'><b>post_max_size</b> : " . ini_get('post_max_size') . "</li>";
                                    $list2 .= "<li class='list-group-item'><b>max_execution_time</b> : " . ini_get('max_execution_time') . "</li>";

                                }

                                $php_version = (function_exists('ini_get') && phpversion() != FALSE) ? phpversion() : ""; ?>

                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <ul class="list-group">
                                            <li class='list-group-item active'>PHP</li>
                                            <li class='list-group-item'><b>PHP version
                                                    : </b> <?php echo $php_version; ?></li>
                                            <?php echo $list1; ?>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <ul class="list-group">
                                            <li class='list-group-item active'>PHP</li>
                                            <?php echo $list2; ?>
                                        </ul>
                                    </div>
                                    <div class="col-sm-12">
                                        <br>
                                        <ul class="list-group">
                                            <li class='list-group-item active'>MySQL</li>

                                            <?php
                                            foreach ($disply_index as $value) {
                                                if (isset($variables_array_format[$value]))
                                                    echo "<li class='list-group-item'><b>" . $value . "</b> : " . $variables_array_format[$value] . "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                    <?php if ($this->basic->is_exist("add_ons", array("project_id" => 41))) : ?>
                                        <div class="col-sm-12">
                                            <br>
                                            <ul class="list-group">
                                                <li class='list-group-item active'>FFMPEG</li>
                                                <?php
                                                if (function_exists('ini_get')) {
                                                    $ffmpeg_path = $this->config->item("ffmpeg_path");

                                                    if ($ffmpeg_path == '') $ffmpeg_path = "ffmpeg";
                                                    echo "<li class='list-group-item'><b>exec()</b> function available : ";
                                                    if (function_exists('exec')) echo "<i class='bx bx-check-circle green'></i> yes"; else echo "<i class='bx bx-trash-alt red'></i> no";
                                                    echo "<li class='list-group-item'><b>FFMPEG version : </b>";

                                                    if (!function_exists('exec')) echo "unknown</li>";
                                                    else {
                                                        $a = exec($ffmpeg_path . " -version -loglevel error 2>&1", $error_message);
                                                        if ($a != '') echo $a . "</li>";
                                                        echo "<li class='list-group-item'>";
                                                        if (isset($error_message) && !empty($error_message))
                                                            echo '<pre class="language-javascript text-left"><code class="dlanguage-javascript"><span class="token keyword">FFMPEG Info :';
                                                        print_r($error_message);
                                                        echo '</span></code></pre>';
                                                        echo "</li>";
                                                    }
                                                }

                                                ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


</form>
