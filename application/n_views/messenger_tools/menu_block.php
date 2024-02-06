<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="row">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxs-cog"></i> <?php echo $this->lang->line("Bot Settings"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Bot reply, persistent menu, sequence message etc"); ?></p>
                    <a href="<?php echo base_url("messenger_bot/bot_list"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?> <i
                                class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bxs-grid"></i> <?php echo $this->lang->line("Post-back Manager"); ?></h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Postback ID & postback data management"); ?></p>
                    <a href="<?php echo base_url("messenger_bot/template_manager"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?> <i
                                class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(275, $this->module_access)) : ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bxs-grid"></i> <?php echo $this->lang->line("OTN Post-back Manager"); ?>
                            <i class="bx bxs-help-circle otn_info_modal" style="color: #6777EF;" data-toggle="modal"
                               data-target="#otn_info_modal"></i></h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("OTN Postback ID & postback data management"); ?></p>
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="no_hover"
                               style="font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i
                                        class="bx bx-chevron-right"></i></a>
                            <div class="dropdown-menu <?php if ($rtl_on) {
                                echo 'dropdown-menu-right';
                            } ?>">
                                <div class="dropdown-header"><?php echo $this->lang->line("Tools"); ?></div>
                                <a class="dropdown-item has-icon"
                                   href="<?php echo base_url("messenger_bot/otn_template_manager"); ?>"><i
                                            class="bx bxs-checkbox-checked"></i> <?php echo $this->lang->line("Manage Templates"); ?>
                                </a>
                                <a class="dropdown-item has-icon"
                                   href="<?php echo base_url("messenger_bot/otn_subscribers"); ?>"><i
                                            class="bx bx-bullseye"></i> <?php echo $this->lang->line("Report"); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bx-check-circle"></i> <?php echo $this->lang->line("Whitelisted Domains"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Whitelist domain for web url and other purposes"); ?></p>
                    <a href="<?php echo base_url("messenger_bot/domain_whitelist"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?> <i
                                class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <?php if ($this->is_engagement_exist) : ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bxs-bell-ring"></i> <?php echo $this->lang->line("Messenger Engagement"); ?>
                        </h5>
                    </div>

                    <div class="card-body">
                        <p><?php echo $this->lang->line("Checkbox, send to messenger, customer chat, m.me"); ?></p>

                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown"
                               class="no_hover card-cta d-inline-flex align-items-center"
                               style="font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i
                                        class="bx bx-chevron-right"></i></a>
                            <div class="dropdown-menu <?php if ($rtl_on) {
                                echo 'dropdown-menu-right';
                            } ?>">
                                <h6 class="dropdown-header"><?php echo $this->lang->line("Tools"); ?></h6>
                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(213, $this->module_access)) : ?>
                                    <a class="dropdown-item has-icon"
                                       href="<?php echo base_url('messenger_bot_enhancers/checkbox_plugin_list'); ?>"><i
                                            class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("Checkbox Plugin"); ?>
                                    </a><?php endif; ?>
                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(214, $this->module_access)) : ?>
                                    <a class="dropdown-item has-icon"
                                       href="<?php echo base_url('messenger_bot_enhancers/send_to_messenger_list'); ?>">
                                    <i class="bx bx-paper-plane mr-50"></i> <?php echo $this->lang->line("Send to Messenger"); ?>
                                    </a><?php endif; ?>
                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(215, $this->module_access)) : ?>
                                    <a class="dropdown-item has-icon"
                                       href="<?php echo base_url('messenger_bot_enhancers/mme_link_list'); ?>"><i
                                            class="bx bx-link mr-50"></i> <?php echo $this->lang->line("m.me Link"); ?>
                                    </a><?php endif; ?>
                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(217, $this->module_access)) : ?>
                                    <a class="dropdown-item has-icon"
                                       href="<?php echo base_url('messenger_bot_enhancers/customer_chat_plugin_list'); ?>">
                                    <i class="bx bx-comment-dots mr-50"></i> <?php echo $this->lang->line("Customer Chat Plugin"); ?>
                                    </a><?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php
        if ($this->session->userdata('user_type') == 'Admin' || in_array(257, $this->module_access)) : ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bxs-save"></i> <?php echo $this->lang->line("Saved Templates"); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Saved exported bot settings"); ?></p>
                        <a href="<?php echo base_url("messenger_bot/saved_templates"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if ($this->basic->is_exist("add_ons", array("project_id" => 31)))
            if ($this->session->userdata('user_type') == 'Admin' || in_array(258, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bx-plug"></i> <?php echo $this->lang->line("Json API Connector"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Connect bot data with 3rd party apps"); ?></p>
                            <a href="<?php echo base_url("messenger_bot_connectivity/json_api_connector"); ?>"
                               class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?>
                                <i class="bx bx-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


        <?php
        if ($this->basic->is_exist("add_ons", array("project_id" => 31)))
            if ($this->session->userdata('user_type') == 'Admin' || in_array(261, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bx-detail"></i> <?php echo $this->lang->line("Webform Builder"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Custom data collection form for messenger bot"); ?></p>
                            <a href="<?php echo base_url("messenger_bot_connectivity/webview_builder_manager"); ?>"
                               class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?>
                                <i class="bx bx-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php
        if ($this->basic->is_exist("add_ons", array("project_id" => 49)))
            if ($this->session->userdata('user_type') == 'Admin' || in_array(292, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bxl-stack-overflow"></i> <?php echo $this->lang->line("User Input Flow & Custom Fields"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Create flow campaign & custom fields to store user's data"); ?></p>

                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown"
                                   class="no_hover card-cta d-inline-flex align-items-center"
                                   style="font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i
                                            class="bx bx-chevron-right"></i></a>

                                <div class="dropdown-menu <?php if ($rtl_on) {
                                    echo 'dropdown-menu-right';
                                } ?>">
                                    <div class="dropdown-header"><?php echo $this->lang->line("Tools"); ?></div>
                                    <a class="dropdown-item has-icon"
                                       href="<?php echo base_url('custom_field_manager/campaign_list'); ?>"><i
                                                class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("User Input Flow Campaign"); ?>
                                    </a>
                                    <a class="dropdown-item has-icon"
                                       href="<?php echo base_url('custom_field_manager/custom_field_list'); ?>"><i
                                                class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("Custom Fields"); ?>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(265, $this->module_access)) : ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Email Auto Responder"); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Add MailChimp API & Pull list"); ?></p>

                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown"
                               class="no_hover card-cta d-inline-flex align-items-center"
                               style="font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i
                                        class="bx bx-chevron-right"></i></a>

                            <div class="dropdown-menu <?php if ($rtl_on) {
                                echo 'dropdown-menu-right';
                            } ?>">
                                <h6 class="dropdown-header"><?php echo $this->lang->line("Tools"); ?></h6>
                                <a class="dropdown-item has-icon"
                                   href="<?php echo base_url('email_auto_responder_integration/mailchimp_list'); ?>"><i
                                            class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("MailChimp Integration"); ?>
                                </a>
                                <a class="dropdown-item has-icon"
                                   href="<?php echo base_url('email_auto_responder_integration/sendinblue_list'); ?>"><i
                                            class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("Sendinblue Integration"); ?>
                                </a>
                                <a class="dropdown-item has-icon"
                                   href="<?php echo base_url('email_auto_responder_integration/activecampaign_list'); ?>"><i
                                            class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("Activecampaign Integration"); ?>
                                </a>
                                <a class="dropdown-item has-icon"
                                   href="<?php echo base_url('email_auto_responder_integration/mautic_list'); ?>"><i
                                            class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("Mautic Integration"); ?>
                                </a>
                                <a class="dropdown-item has-icon"
                                   href="<?php echo base_url('email_auto_responder_integration/acelle_list'); ?>"><i
                                            class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("Acelle Integration"); ?>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if ($this->basic->is_exist("modules", array("id" => 266))) :
            if ($this->session->userdata('user_type') == 'Admin' || in_array(266, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bx-shopping-bag"></i> <?php echo $this->lang->line("WooCommerce Abandoned Cart"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Track cart/checkout, recover abandoned cart..."); ?></p>

                            <div class="dropdown">
                                <a href="<?php echo base_url('woocommerce_abandoned_cart'); ?>"><?php echo $this->lang->line("Actions"); ?>
                                    <i class="bx bx-chevron-right"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>


    </div>
</div>


<style type="text/css">
    .otn_info_modal {
        cursor: pointer;
    }
</style>


<div class="modal fade" id="otn_info_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-group"></i> <?php echo $this->lang->line("OTN Subscribers"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="section">
                    <h2 class="section-title font-medium-2"><?php echo $this->lang->line('One-Time Notification'); ?></h2>
                    <p><?php echo $this->lang->line("The Messenger Platform's One-Time Notification allows a page to request a user to send one follow-up message after 24-hour messaging window have ended. The user will be offered to receive a future notification. Once the user asks to be notified, the page will receive a token which is an equivalent to a permission to send a single message to the user. The token can only be used once and will expire within 1 year of creation."); ?></p>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line("Close") ?></span>
                </button>
            </div>

        </div>
    </div>
</div>

