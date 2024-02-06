<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><?php echo $this->lang->line("System"); ?></li>
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
                    <h5 class="card-title"><i class="bx bxl-facebook"></i> <?php echo $this->lang->line("Facebook"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Set your Facebook app key, secret etc..."); ?></p>
                    <a href="<?php echo base_url("social_apps/facebook_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxl-google"></i> <?php echo $this->lang->line("Google"); ?></h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Set your Google app key, secret etc..."); ?></p>
                    <a href="<?php echo base_url("social_apps/google_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxl-twitter"></i> <?php echo $this->lang->line("Twitter"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Set your Twitter app key, secret etc..."); ?></p>
                    <a href="<?php echo base_url("social_apps/twitter_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxl-linkedin"></i> <?php echo $this->lang->line("Linkedin"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Set your Linkedin app key, secret etc..."); ?></p>
                    <a href="<?php echo base_url("social_apps/linkedin_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="bx bxl-reddit"></i> <?php echo $this->lang->line("Reddit"); ?></h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Set your Reddit app key, secret etc..."); ?></p>
                    <a href="<?php echo base_url("social_apps/reddit_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-6">
          <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                  <h5 class="card-title"><i class="bx bxl-pinterest"></i> <?php echo $this->lang->line("Pinterest"); ?></h5>
              </div>
            <div class="card-body">
              <p><?php echo $this->lang->line("Set your Pinterest app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/pinterest_settings"); ?>" class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?> <i class="bx bx-chevron-right"></i></a>
            </div>
          </div>
        </div> -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bxl-wordpress"></i> <?php echo $this->lang->line("Wordpress"); ?></h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Set your Wordpress app key, secret etc..."); ?></p>
                    <a href="<?php echo base_url("social_apps/wordpress_settings"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-6">
          <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                  <h5 class="card-title"><i class="bx bxl-tumblr"></i> <?php echo $this->lang->line("Tumblr"); ?>></h5>
              </div>
            <div class="card-body">
              <p><?php echo $this->lang->line("Set your Tumblr app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/tumblr_settings"); ?>" class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?> <i class="bx bx-chevron-right"></i></a>
            </div>
          </div>
        </div> -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bxl-wordpress"></i> <?php echo $this->lang->line("Wordpress (Self-Hosted)"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Set your Wordpress app url, name etc..."); ?></p>
                    <a href="<?php echo base_url("social_apps/wordpress_settings_self_hosted"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <!--         <div class="col-lg-6">
          <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                  <h5 class="card-title"><i class="bx bxl-medium"></i> <?php echo $this->lang->line("Medium"); ?></h5>
              </div>
            <div class="card-body">
              <p><?php echo $this->lang->line("Set your Medium app key, secret etc..."); ?></p>
              <a href="<?php echo base_url("social_apps/medium_settings"); ?>" class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Change Setting"); ?> <i class="bx bx-chevron-right"></i></a>
            </div>
          </div>
        </div>     -->

    </div>
</div>
