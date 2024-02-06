<div class="content-header row">
</div>
<div class="content-body"><!-- register section starts -->
    <section class="row flexbox-container">
        <div class="col-xl-8 col-10">
            <div class="card bg-authentication mb-0">
                <div class="row m-0">
                    <!-- register section left -->
                    <div class="col-md-6 col-12 px-0">
                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                            <div class="text-center mt-1">
                                <a href="<?php echo base_url(); ?>"><img
                                            src="<?php echo base_url(); ?>assets/img/logo.png"
                                            alt="<?php echo $this->config->item('product_name'); ?>" width="200"></a>
                            </div>
                            <div class="card-header pb-1">
                                <div class="card-title">
                                    <h4 class="text-center mb-2"><?php echo $this->lang->line("Sign Up"); ?></h4>
                                </div>
                                <?php
                                if ($n_config['login_change_language'] == 'true') {
                                    include(APPPATH . 'n_views/site/default/language_switch.php');
                                }
                                ?>
                            </div>
                            <?php
                            if ($this->session->userdata('reg_success') == 1) {
                                echo "<div class='alert alert-success' role='alert'><div class='d-flex align-items-center'><i class='bx bx-like'></i><span>" . $this->lang->line("An activation code has been sent to your email. please check your inbox to activate your account.") . "</span></div></div>";
                                $hide_login = 1;
                                $this->session->unset_userdata('reg_success');
                            }
                            if ($this->session->userdata('reg_success') == 'limit_exceed') {
                                echo "<div class='alert alert-danger' role='alert'><div class='d-flex align-items-center'><i class='bx bx-like'></i><span>" . $this->lang->line("Signup has been disabled. Please contact system admin.") . "</span></div></div>";
                                $this->session->unset_userdata('reg_success');
                            }
                            if (form_error('name') != '' || form_error('email') != '' || form_error('confirm_password') != '' || form_error('password') != "") {
                                $form_error = "";
                                if (form_error('name') != '') $form_error .= str_replace(array("<p>", "</p>"), array("", ""), form_error('name')) . "<br>";
                                if (form_error('email') != '') $form_error .= str_replace(array("<p>", "</p>"), array("", ""), form_error('email')) . "<br>";
                                if (form_error('password') != '') $form_error .= str_replace(array("<p>", "</p>"), array("", ""), form_error('password')) . "<br>";
                                if (form_error('confirm_password') != '') $form_error .= str_replace(array("<p>", "</p>"), array("", ""), form_error('confirm_password')) . "<br>";
                                echo "<div class='alert alert-danger' role='alert'><div class='d-flex align-items-center'><i class='bx bx-like'></i><span>" . $form_error . "</span></div></div>";

                            }
                            if (form_error('captcha'))
                                echo "<div class='alert alert-danger' role='alert'><div class='d-flex align-items-center'><i class='bx bx-like'></i><span>" . form_error('captcha') . "</span></div></div>";
                            else if ($this->session->userdata("sign_up_captcha_error") != '') {
                                echo "<div class='alert alert-danger' role='alert'><div class='d-flex align-items-center'><i class='bx bx-like'></i><span>" . $this->session->userdata("sign_up_captcha_error") . "</span></div></div>";
                                $this->session->unset_userdata("sign_up_captcha_error");
                            }
                            ?>
                            <div class="card-body">
                                <?php if(empty($hide_login)){ ?>

                                <form method="POST" action="<?php echo site_url('home/sign_up_action'); ?>">
                                    <input type="hidden" name="csrf_token" id="csrf_token"
                                           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                    <div class="form-group mb-2">
                                        <label for="frist_name"><?php echo $this->lang->line("Name"); ?> *</label>
                                        <input type="text" class="form-control" id="frist_name" name="name" autofocus
                                               required value="<?php echo set_value('name'); ?>"
                                               placeholder="<?php echo $this->lang->line("Name"); ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="text-bold-600"
                                               for="email"><?php echo $this->lang->line("Email"); ?> *</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                               value="<?php echo set_value('email'); ?>" autocomplete="username"
                                               placeholder="<?php echo $this->lang->line("Email"); ?> *"></div>
                                    <div class="form-group mb-2">
                                        <label class="text-bold-600"
                                               for="password"><?php echo $this->lang->line("Password"); ?> *</label>
                                        <input type="password" autocomplete="new-password" class="form-control"
                                               id="password" required name="password"
                                               value="<?php echo set_value('password'); ?>"
                                               placeholder="<?php echo $this->lang->line("Password"); ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="text-bold-600"
                                               for="password2"><?php echo $this->lang->line("Confirm Password"); ?>
                                            *</label>
                                        <input type="password" autocomplete="new-password" class="form-control"
                                               id="password2" required name="confirm_password"
                                               value="<?php echo set_value('confirm_password'); ?>"
                                               placeholder="<?php echo $this->lang->line("Confirm Password"); ?>">
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="captcha"><?php echo $this->lang->line("Captcha"); ?> *</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                  id="basic-addon3"><?php echo $num1 . "+" . $num2 . " = ?"; ?></span>
                                            <input type="number" class="form-control" required id="captcha"
                                                   name="captcha"
                                                   placeholder="<?php echo $this->lang->line("Put your answer here"); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" required class="custom-control-input"
                                                   id="agree">
                                            <label class="custom-control-label" for="agree"><a target="_BLANK"
                                                                                               href="<?php echo site_url(); ?>home/terms_use"><?php echo $this->lang->line("I agree with the terms and conditions"); ?></a></label>
                                        </div>
                                    </div>

                                    <button type="submit"
                                            class="btn btn-primary glow position-relative w-100"><?php echo $this->lang->line("sign up"); ?>
                                        <i
                                                id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                </form>

                                <?php } ?>

                                <hr>
                                <div class="text-center"><small class="mr-25"><?php echo $this->lang->line('Already have an account?');?> </small><a
                                            href="<?php echo base_url('home/login'); ?>"><small><?php echo $this->lang->line('Sign in');?></small> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- image section right -->
                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                        <?php if ($n_config['signup_page_view'] == 'false') { ?>
                            <div class="d-flex"><img class="img-fluid"
                                                     src="<?php echo base_url(); ?>n_assets/app-assets/images/pages/register.png"
                                                     alt="branding logo"></div>
                        <?php } else {
                            $current_language = $this->language;

                            $import_modal = 'false';
                            if (file_exists(APPPATH . 'n_eco_user/signup_html_' . strtolower($current_language) . '.php')) {
                                $import_modal = APPPATH . 'n_eco_user/signup_html_' . strtolower($current_language) . '.php';
                            } else {
                                if (file_exists(APPPATH . 'n_eco_user/signup_html_' . $n_config['login_page_text_default'] . '.php')) {
                                    $import_modal = APPPATH . 'n_eco_user/signup_html_' . $n_config['login_page_text_default'] . '.php';
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
    <!-- register section endss -->
