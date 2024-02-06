<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("System"); ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>


<div class="content-body">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxs-wrench"></i> <?php echo $this->lang->line("General"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("brand, logo, language, phpmail, https, upload..."); ?></p>
                    <a href="<?php echo base_url("admin/general_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right ml-25"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxs-store"></i> <?php echo $this->lang->line("Front-end"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Hide, theme, social, review, video..."); ?></p>
                    <a href="<?php echo base_url("admin/frontend_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right ml-25"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bxs-server"></i> <?php echo $this->lang->line("SMTP Settings"); ?></h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("SMTP email settings"); ?></p>
                    <a href="<?php echo base_url("admin/smtp_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right ml-25"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bx-mail-send"></i> <?php echo $this->lang->line("Email Template"); ?></h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Signup, change password, expiry, payment..."); ?></p>
                    <a href="<?php echo base_url("admin/email_template_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right ml-25"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bx-analyse"></i> <?php echo $this->lang->line("Analytics"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Gogole analytics, Facebook pixel code..."); ?></p>
                    <a href="<?php echo base_url("admin/analytics_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right ml-25"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxs-pin"></i> <?php echo $this->lang->line("Advertisement"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Banner, potrait, landscape image ads..."); ?></p>
                    <a href="<?php echo base_url("admin/advertisement_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right ml-25"></i></a>
                </div>
            </div>
        </div>


    </div>
</div>
