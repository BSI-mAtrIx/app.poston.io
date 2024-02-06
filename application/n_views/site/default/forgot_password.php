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
                                    <h4 class="text-center mb-2"><?php echo $this->lang->line("Password Recovery"); ?></h4>
                                </div>
                                <?php
                                if ($n_config['login_change_language'] == 'true') {
                                    include(APPPATH . 'n_views/site/default/language_switch.php');
                                }
                                ?>
                            </div>
                            <div class="card-body" id="recovery_form">
                                <p class="text-muted"><?php echo $this->lang->line("We will send you a email containing steps to reset password"); ?></p>
                                <form method="POST">
                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="email"><?php echo $this->lang->line("email"); ?> *</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="<?php echo $this->lang->line("email"); ?>">
                                        <div class="invalid-feedback"><?php echo $this->lang->line("Please enter your email"); ?></div>
                                    </div>
                                    <button type="submit" id="submit"
                                            class="btn btn-primary glow position-relative w-100"><?php echo $this->lang->line("Send Reset Link"); ?>
                                        <i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <?php if ($n_config['forgot_password_view'] == 'false') { ?>
                            <div class="d-flex"><img class="img-fluid"
                                                     src="<?php echo base_url(); ?>n_assets/app-assets/images/pages/reset-password.png"
                                                     alt="branding logo"></div>
                        <?php } else {
                            $current_language = $this->language;

                            $import_modal = 'false';
                            if (file_exists(APPPATH . 'n_eco_user/forgot_password_html_' . strtolower($current_language) . '.php')) {
                                $import_modal = APPPATH . 'n_eco_user/forgot_password_html_' . strtolower($current_language) . '.php';
                            } else {
                                if (file_exists(APPPATH . 'n_eco_user/forgot_password_html_' . $n_config['forgot_password_default_view'] . '.php')) {
                                    $import_modal = APPPATH . 'n_eco_user/forgot_password_html_' . $n_config['forgot_password_default_view'] . '.php';
                                }
                            }
                            if ($import_modal != 'false') {
                                $n_modal_data = file_get_contents($import_modal);
                                $n_modal_data = json_decode($n_modal_data, true);
                            } else {
                                $n_modal_data = array();
                                $n_modal_data['gjs-html'] = '';
                                $n_modal_data['gjs-components'] = '';
                                $n_modal_data['gjs-assets'] = '';
                                $n_modal_data['gjs-css'] = '';
                                $n_modal_data['gjs-styles'] = '';
                            }
                            echo '<style>' . $n_modal_data['gjs-css'] . '</style>';
                            echo $n_modal_data['gjs-html'];
                        } ?>


                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view("include/fb_px"); ?>
        <?php $this->load->view("include/google_code"); ?>
    </section>
    <!-- reset password ends -->



