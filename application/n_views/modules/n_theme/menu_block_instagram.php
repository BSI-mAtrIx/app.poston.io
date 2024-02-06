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

        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(320, $this->module_access))  : ?>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title">
                            <i class="bx bxs-cog"></i> <?php echo $this->lang->line("Bot Settings"); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Bot reply, Get started, Ice breakers etc"); ?></p>
                        <a href="<?php echo base_url("messenger_bot/bot_list/ig"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title">
                            <i class="bx bxs-cog"></i> <?php echo $this->lang->line("Post-back Manager"); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Postback ID & postback data management"); ?></p>
                        <a href="<?php echo base_url("messenger_bot/template_manager/ig"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?></a>
                    </div>
                </div>
            </div>

            <?php if ($this->basic->is_exist("add_ons", array("project_id" => 49))) { ?>
                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(292, $this->module_access)) { ?>
                    <!-- Instagram User input flow section -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><i
                                            class="bx bxs-cog"></i> <?php echo $this->lang->line("User Input Flow & Custom Fields"); ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p><?php echo $this->lang->line("Create flow campaign & custom fields to store user's data"); ?></p>

                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown" class="card-cta d-inline-flex align-items-center"
                                       style="font-weight: 500;"><?php echo $this->lang->line("Actions"); ?> <i
                                                class="bx bx-chevron-right"></i></a>
                                    <div class="dropdown-menu <?php if ($rtl_on) {
                                        echo 'dropdown-menu-right';
                                    } ?>">
                                        <div class="dropdown-header"><?php echo $this->lang->line("Tools"); ?></div>
                                        <a class="dropdown-item has-icon"
                                           href="<?php echo base_url('custom_field_manager/campaign_list/ig'); ?>"><i
                                                    class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("User Input Flow Campaign"); ?>
                                        </a>
                                        <a class="dropdown-item has-icon"
                                           href="<?php echo base_url('custom_field_manager/custom_field_list/ig'); ?>"><i
                                                    class="bx bxs-checkbox-checked mr-50"></i> <?php echo $this->lang->line("Custom Fields"); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>

        <?php endif; ?>


    </div>
</div>
