<main class="main login-page">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $l->line('Login / Sign Up'); ?></li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->
    <div class="page-content">
        <div class="container">
            <div class="login-popup">
                <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                    <ul class="nav nav-tabs text-uppercase" role="tablist">
                        <li class="nav-item">
                            <a href="#sign-in" class="nav-link active"><?php echo $l->line('Sign In'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="#sign-up" class="nav-link"><?php echo $l->line('Sign Up'); ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="sign-in">
                            <form method="POST" id="log" action="#" class="needs-validation" novalidate=""
                                  _lpchecked="1">
                                <div class="form-group">
                                    <label for="login_email"><?php echo $l->line('Email address'); ?></label>
                                    <input type="text" class="form-control" name="username" id="login_email" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="login_password"><?php echo $l->line('Password'); ?></label>
                                    <input type="password" class="form-control" name="password" id="login_password"
                                           required>
                                    <a href="<?php e_link($reset_password_url); ?>"><?php echo $this->lang->line('Forgot password?'); ?></a>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <button type="submit" id="login_submit"
                                                class="btn btn-primary mt-1"><?php echo $l->line('Login'); ?></button>
                                    </div>
                                    <div class="col-md-6">
                                        <?php if ($is_guest_login == '1') {
                                            if ($n_eco_builder_config['guest_register_form_type'] == 'text') {
                                                ?>
                                                <div class="form-checkbox text-right mt-2">
                                                    <a href="#"
                                                       id="guest_register_form"><?php echo $l->line('Continue as guest'); ?></a>
                                                </div>
                                                <?php
                                            }
                                            if ($n_eco_builder_config['guest_register_form_type'] == 'btn') {
                                                ?>
                                                <button type="submit" id="guest_register_form"
                                                        class="btn btn-primary login_from_popup mt-1"><?php echo $l->line('Continue as guest'); ?></button>
                                                <?php
                                            }
                                            ?>
                                        <?php } ?>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane" id="sign-up">
                            <form method="POST" id="reg" action="#" class="needs-validation" novalidate=""
                                  _lpchecked="1">


                                <div class="form-group">
                                    <label for="register_first_name"><?php echo $this->lang->line("Name"); ?>*</label>

                                    <input type="text" class="form-control" minlength="7"
                                           placeholder="<?php echo $this->lang->line("First Name"); ?>"
                                           id="register_first_name" name="" required autofocus autocomplete="off">
                                    <input type="text" class="form-control mt-5" minlength="7"
                                           placeholder="<?php echo $this->lang->line("Last Name"); ?>"
                                           id="register_last_name" name="" required autofocus autocomplete="off">

                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group">
                                    <label for="register_email"><?php echo $this->lang->line("Email"); ?>*</label>
                                    <input type="email" class="form-control" autocomplete="email"
                                           placeholder="<?php echo $this->lang->line("Email"); ?>" id="register_email"
                                           name="" required autofocus autocomplete="off">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="register_password"
                                           class="control-label"><?php echo $this->lang->line("Password"); ?>*</label>
                                    <input type="password" id="register_password" autocomplete="new-password"
                                           placeholder="<?php echo $this->lang->line("Password"); ?>"
                                           class="form-control" name="" required autocomplete="off">
                                    <input type="password" id="register_password_confirm" autocomplete="new-password"
                                           placeholder="<?php echo $this->lang->line("Confirm Password"); ?>"
                                           class="form-control mt-5" name="" required autocomplete="off">
                                </div>

                                <button href="#" id="register_submit"
                                        class="btn btn-primary"><?php echo $this->lang->line("Register"); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>