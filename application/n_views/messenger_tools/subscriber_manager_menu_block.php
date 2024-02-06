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

        <div class="col-sm-12 col-md-6 col-lg-6">

            <div class="col-sm-12">
                <h4 class="card-title pl-1"><?php echo $this->lang->line("Messenger Subscriber"); ?></h4>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Sync Subscribers"); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Sync, migrate, conversation..."); ?></p>
                        <a href="<?php echo base_url("subscriber_manager/bot_subscribers"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-user-circle"></i> <?php echo $this->lang->line("Bot Subscribers"); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Subscriber actions, assign label, download..."); ?></p>
                        <a href="<?php echo base_url("subscriber_manager/bot_subscribers"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-purchase-tag-alt"></i> <?php echo $this->lang->line("Labels/Tags"); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Subcriber label/tags, segmentation..."); ?></p>
                        <a href="<?php echo base_url("subscriber_manager/bot_subscribers"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <?php
        if ($this->basic->is_exist("modules", array("id" => 263)) || $this->basic->is_exist("modules", array("id" => 264))) {
            if ($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array('263', '264'))) != 0) { ?>
                <div class="col-sm-12 col-md-6 col-lg-6">

                    <div class="col-sm-12">
                        <h4 class="card-title pl-1"><?php if ($this->basic->is_exist("modules", array("id" => 263))) echo $this->lang->line("SMS/Email Subscriber (External)"); else echo $this->lang->line("SMS Subscriber (External)"); ?></h4>
                    </div>

                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i
                                            class="bx bx-group"></i> <?php echo $this->lang->line("Contact Group"); ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p><?php if ($this->basic->is_exist("modules", array("id" => 263))) echo $this->lang->line("Manage contacts by groups, sms/email campaign..."); else echo $this->lang->line("Manage contacts by groups, sms campaign..."); ?></p>
                                <a href="<?php echo base_url("sms_email_manager/contact_group_list"); ?>"
                                   class="no_hover card-cta d-inline-flex align-items-center style=" font-weight:
                                   500;"><?php echo $this->lang->line("Actions"); ?> <i
                                        class="bx bx-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i
                                            class="bx bx-book"></i> <?php echo $this->lang->line("Contact Book"); ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p><?php if ($this->basic->is_exist("modules", array("id" => 263))) echo $this->lang->line("Manage contacts, import, sms/email campaign..."); else echo $this->lang->line("Manage contacts, import, sms campaign..."); ?></p>
                                <a href="<?php echo base_url("sms_email_manager/contact_list"); ?>"
                                   class="no_hover card-cta d-inline-flex align-items-center style=" font-weight:
                                   500;"><?php echo $this->lang->line("Actions"); ?> <i
                                        class="bx bx-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <?php if ($this->basic->is_exist("modules", array("id" => 290))) { ?>
                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(290, $this->module_access)) { ?>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                        <h5 class="card-title"><i
                                                    class="bx bxl-pocket"></i> <?php echo $this->lang->line("Email Phone Opt-in Form Builder"); ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><?php if ($this->basic->is_exist("modules", array("id" => 290))) echo $this->lang->line("Custom Subscribers opt-in Form builder."); else echo $this->lang->line("Custom Subscribers opt-in Form builder."); ?></p>
                                        <a href="<?php echo base_url("email_optin_form_builder"); ?>"
                                           class="no_hover card-cta d-inline-flex align-items-center style="
                                           font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i
                                                class="bx bx-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>


                </div>
            <?php } ?>
        <?php } ?>

    </div>

</div>

