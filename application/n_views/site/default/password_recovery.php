<div class="content-header row">
</div>
<div class="content-body"><!-- reset password start -->
    <section class="row flexbox-container">
        <div class="col-xl-7 col-10">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- left section-login -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right d-flex justify-content-center mb-0 p-2 h-100">
                            <div class="text-center mt-1">
                                <a href="<?php echo base_url(); ?>"><img
                                            src="<?php echo base_url(); ?>assets/img/logo.png"
                                            alt="<?php echo $this->config->item('product_name'); ?>" width="200"></a>
                            </div>
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2"><?php echo $this->lang->line("Reset Password"); ?></h4>

                                </div>
                                <?php
                                if ($n_config['login_change_language'] == 'true') {
                                    include(APPPATH . 'n_views/site/default/language_switch.php');
                                }
                                ?>
                            </div>
                            <div class="card-body" id="recovery_form">
                                <p class="text-muted"<?php echo $this->lang->line("You are one step away to get back access to your account") ?></p>
                                <form method="POST">
                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="code"><?php echo $this->lang->line("Password Reset Code"); ?>
                                            *</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                               placeholder="<?php echo $this->lang->line("Password Reset Code"); ?>">
                                        <div class="invalid-feedback"><?php echo $this->lang->line("Please enter your code"); ?></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="new_password"><?php echo $this->lang->line("New Password"); ?>
                                            *</label>
                                        <input type="password" class="form-control" id="new_password"
                                               name="new_password">
                                        <div class="invalid-feedback"><?php echo $this->lang->line("You have to type new password twice"); ?></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="new_password_confirm"><?php echo $this->lang->line("Confirm New Password"); ?>
                                            *</label>
                                        <input type="password" class="form-control" id="new_password_confirm"
                                               name="new_password_confirm">
                                        <div class="invalid-feedback"><?php echo $this->lang->line("Passwords does not match"); ?></div>
                                    </div>
                                    <button type="submit" id="submit"
                                            class="btn btn-primary glow position-relative w-100"><?php echo $this->lang->line("Reset Password"); ?>
                                        <i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <div class="d-flex"><img class="img-fluid"
                                                 src="<?php echo base_url(); ?>n_assets/app-assets/images/pages/reset-password.png"
                                                 alt="branding logo"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view("include/fb_px"); ?>
        <?php $this->load->view("include/google_code"); ?>
    </section>
    <!-- reset password ends -->


