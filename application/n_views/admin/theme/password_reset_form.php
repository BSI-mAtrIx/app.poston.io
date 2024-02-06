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
                                    <h4 class="text-center mb-2"><?php echo $this->lang->line("Change Password"); ?></h4>
                                </div>
                            </div>
                            <div class="card-body" id="recovery_form">
                                <?php
                                if ($this->session->userdata('error'))
                                    echo '<div class="alert alert-warning text-center">' . $this->session->userdata('error') . '</div>';
                                $this->session->unset_userdata('error');
                                ?>

                                <form method="POST"
                                      action="<?php echo base_url("change_password/reset_password_action"); ?>">
                                    <input type="hidden" name="csrf_token" id="csrf_token"
                                           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="old_password"><?php echo $this->lang->line("Old Password"); ?>
                                            *</label>
                                        <input type="password" class="form-control" id="old_password"
                                               name="old_password"
                                               placeholder="<?php echo $this->lang->line("Old Password"); ?>">
                                        <span class="text-danger"><?php echo form_error('old_password'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="new_password"><?php echo $this->lang->line("New Password"); ?>
                                            *</label>
                                        <input type="password" class="form-control" id="new_password"
                                               name="new_password"
                                               placeholder="<?php echo $this->lang->line("New Password"); ?>">
                                        <span class="text-danger"><?php echo form_error('new_password'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="confirm_new_password"><?php echo $this->lang->line("Confirm Password"); ?>
                                            *</label>
                                        <input type="password" class="form-control" id="confirm_new_password"
                                               name="confirm_new_password"
                                               placeholder="<?php echo $this->lang->line("Confirm Password"); ?>">
                                        <span class="text-danger"><?php echo form_error('confirm_new_password'); ?></span>
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" id="submit"
                                                class="btn btn-primary glow position-relative w-100"><?php echo $this->lang->line("Change Password"); ?>
                                            <i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                        <a class="btn btn-outline-primary glow position-relative w-100 mt-2"
                                           href="<?php echo base_url('member/edit_profile'); ?>"><i
                                                    class="bx bx-left-arrow-circle"></i> <?php echo $this->lang->line("Go Back"); ?>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <img class="img-fluid"
                             src="<?php echo base_url(); ?>n_assets/app-assets/images/pages/reset-password.png"
                             alt="branding logo">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- reset password ends -->


