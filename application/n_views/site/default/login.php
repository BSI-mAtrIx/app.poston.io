<div class="content-header row">
</div>
<div class="content-body"><!-- login page start -->
    <section id="auth-login" class="row flexbox-container">
        <div class="col-xl-8 col-11">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">

                    <!-- left section-login -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="text-center mt-1">
                                <a href="<?php echo base_url(); ?>"><img
                                            src="<?php echo base_url(); ?>assets/img/logo.png"
                                            alt="<?php echo $this->config->item('product_name'); ?>" width="200"></a>
                            </div>
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="mb-2"><?php echo $this->lang->line("Login"); ?></h4>
                                </div>
                                <?php
                                if ($n_config['login_change_language'] == 'true') {
                                    include(APPPATH . 'n_views/site/default/language_switch.php');
                                }
                                ?>
                            </div>

                            <?php

                            if(isset($n_config['nvx_tech'])){
                                echo '<div class="alert alert-danger" role="alert">
                                        <div class="d-flex align-items-center">
                                          <i class="bx bx-error"></i>
                                          <span>
                                            ' . $this->lang->line('We are changing Facebook APP. If you have troubles with account, please contact with our support.') . '
                                          </span>
                                        </div>
                                      </div>';
                            }


                            if ($this->session->flashdata('login_msg') != '') {

                                echo '<div class="alert alert-danger" role="alert">
                                        <div class="d-flex align-items-center">
                                          <i class="bx bx-error"></i>
                                          <span>
                                            ' . str_replace('<p>', '<p class="mb-0">', $this->session->flashdata('login_msg')) . '
                                          </span>
                                        </div>
                                      </div>';

                            }
                            if ($this->session->flashdata('reset_success') != '') {
                                echo '<div class="alert alert-success" role="alert">
                                        <div class="d-flex align-items-center">
                                          <i class="bx bx-like"></i>
                                          <span>
                                          ' . str_replace('<p>', '<p class="mb-0">', $this->session->flashdata('reset_success')) . '
                                          </span>
                                        </div>
                                      </div>';
                            }
                            if ($this->session->userdata('reg_success') != '') {
                                echo '<div class="alert alert-success" role="alert">
                                        <div class="d-flex align-items-center">
                                          <i class="bx bx-like"></i>
                                          <span>
                                          ' . str_replace('<p>', '<p class="mb-0">', $this->session->flashdata('reg_success')) . '
                                          </span>
                                        </div>
                                      </div>';
                                $this->session->unset_userdata('reg_success');
                            }
                            if (form_error('username') != '' || form_error('password') != "") {
                                $form_error = "";
                                if (form_error('username') != '') $form_error .= form_error('username');
                                if (form_error('password') != '') $form_error .= form_error('password');
                                echo '<div class="alert alert-danger" role="alert">
                                        <div class="d-flex align-items-center">
                                          <i class="bx bx-error"></i>
                                          <span>
                                            ' . str_replace('<p>', '<p class="mb-0">', $form_error) . '
                                          </span>
                                        </div>
                                      </div>';

                            }

                            $default_user = $default_pass = "";
                            if ($this->is_demo == '1') {
                                $default_user = "NVXdemo@nvxgroup.com";
                                $default_pass = "NVXdemo";
                            }
                            ?>
                            <div class="card-body">
                                <div class="d-flex d-lg-flex flex-sm-nowrap flex-column justify-content-around">
                                    <?php if ($this->config->item('enable_signup_form') != '0') : ?>
                                        <?php
                                        $google_login_button2 = str_replace("ThisIsTheLoginButtonForGoogle", '<i class="bx bxl-google font-medium-3"></i><span class="pl-50 d-block text-center">' . $this->lang->line("Login with Google"), $google_login_button) . '</span>';
                                        $google_login_button2 = str_replace('btn-block btn-social btn-youtube', 'btn-social btn-google btn-block font-small-3 mb-md-1 mb-1', $google_login_button2);
                                        $google_login_button2 = str_replace('google<', 'Google<', $google_login_button2);
                                        $google_login_button2 = preg_replace("/<img[^>]+\>/i", "", $google_login_button2);
                                        echo $google_login_button2;
                                        ?>
                                        <?php
                                        $fb_login_button2 = str_replace("ThisIsTheLoginButtonForFacebook", '<i class="bx bxl-facebook-square font-medium-3"></i><span class="pl-50 d-block text-center">' . $this->lang->line("Login with Facebook"), $fb_login_button) . '</span>';
                                        $fb_login_button2 = str_replace('btn-block btn-social btn-facebook', 'btn-social btn-block mt-0 btn-facebook font-small-3 mb-lg-0 ', $fb_login_button2);
                                        $fb_login_button2 = str_replace('<span class="fab fa-facebook"></span>', '', $fb_login_button2);

                                        echo $fb_login_button2;
                                        ?>
                                    <?php endif; ?>
                                </div>

                                <div class="divider <?php if ($n_config['hide_login_via_email'] == 'true') {
                                    echo 'd-none';
                                } ?>">
                                    <div class="divider-text text-uppercase text-muted">
                                        <small><?php echo $this->lang->line("or login with email"); ?></small>
                                    </div>
                                </div>
                                <form method="POST" action="<?php echo base_url('home/login'); ?>"
                                      class="needs-validation <?php if ($n_config['hide_login_via_email'] == 'true') {
                                          echo 'd-none';
                                      } ?>" novalidate="">
                                    <input type="hidden" name="csrf_token" id="csrf_token"
                                           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                    <div class="form-group mb-50">
                                        <label class="text-bold-600"
                                               for="email"><?php echo $this->lang->line("Email Or FB ID"); ?></label>
                                        <input type="text" class="form-control" id="email"
                                               placeholder="<?php echo $this->lang->line("Email Or FB ID"); ?>"
                                               name="username" value="<?php echo $default_user ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-bold-600"
                                               for="password"><?php echo $this->lang->line("Password"); ?></label>
                                        <input type="password" class="form-control" id="password" name="password"
                                               placeholder="Password" value="<?php echo $default_pass ?>" required>
                                    </div>
                                    <div
                                            class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                        <div class="text-left"></div>
                                        <div class="text-right"><a href="<?php echo site_url(); ?>home/forgot_password"
                                                                   class="card-link"><small><?php echo $this->lang->line("Forgot your password?"); ?></small></a>
                                        </div>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-primary glow w-100 position-relative"><?php echo $this->lang->line("login"); ?>
                                        <i
                                                id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                </form>
                                <?php if ($this->config->item('enable_signup_form') != '0') : ?>
                                    <hr>
                                    <div class="text-center <?php if ($n_config['hide_login_via_email'] == 'true') {
                                        echo 'd-none';
                                    } ?>"><small
                                                class="mr-25"><?php echo $this->lang->line("Do not have an account?"); ?></small><a
                                                href="<?php echo base_url('home/sign_up'); ?>"><small><?php echo $this->lang->line("Create one"); ?></small></a>
                                    </div>
                                <?php endif; ?>
                                <div class="cursor-pointer unlock_login float-right mt-5 <?php if ($n_config['hide_login_via_email'] == 'false') {
                                    echo 'd-none';
                                } ?>" style="width:25px;height: 25px; "></div>
                            </div>
                        </div>
                    </div>
                    <!-- right section image -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <?php if ($n_config['login_page_text_show'] == 'false') { ?>
                            <div class="d-flex"><img class="img-fluid"
                                                     src="<?php echo base_url(); ?>n_assets/app-assets/images/pages/login.png"
                                                     alt="branding logo"></div>
                        <?php } else {
                            $current_language = $this->language;

                            $import_modal = 'false';
                            if (file_exists(APPPATH . 'n_eco_user/login_html_' . strtolower($current_language) . '.php')) {
                                $import_modal = APPPATH . 'n_eco_user/login_html_' . strtolower($current_language) . '.php';
                            } else {
                                if (file_exists(APPPATH . 'n_eco_user/login_html_' . $n_config['login_page_text_default'] . '.php')) {
                                    $import_modal = APPPATH . 'n_eco_user/login_html_' . $n_config['login_page_text_default'] . '.php';
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
</div>