<main class="main login-page">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $l->line('Reset password'); ?></li>
            </ul>
        </div>
    </nav>
    <!-- End of Breadcrumb -->
    <div class="page-content">
        <div class="container">
            <div class="login-popup">
                <h5><?php echo $this->lang->line('Reset your password'); ?></h5>


                <?php if(empty($_GET['token'])){ ?>
                    <form method="POST" id="reset_password" action="#" class="needs-validation" novalidate=""
                          _lpchecked="1">
                        <div class="form-group">
                            <label for="login_email"><?php echo $l->line('Email address'); ?></label>
                            <input type="text" class="form-control" name="username" id="login_email" required>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button type="submit" id="reset_password_submit"
                                        class="btn btn-primary mt-1"><?php echo $l->line('Reset password'); ?></button>
                            </div>
                        </div>

                    </form>
                <?php }else{ ?>
                    <form method="POST" id="reset_password_step_two" action="#" class="needs-validation" novalidate=""
                          _lpchecked="1">
                        <input type="hidden" value="<?php echo $_GET['token']; ?>" id="reset_token" />
                        <div class="form-group mb-5">
                            <label for="register_password"
                                   class="control-label"><?php echo $this->lang->line("New Password"); ?>*</label>
                            <input type="password" id="register_password_reset" autocomplete="new-password"
                                   placeholder="<?php echo $this->lang->line("Password"); ?>"
                                   class="form-control" name="" required autocomplete="off">
                            <input type="password" id="register_password_confirm_reset" autocomplete="new-password"
                                   placeholder="<?php echo $this->lang->line("Confirm Password"); ?>"
                                   class="form-control mt-5" name="" required autocomplete="off">
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button type="submit" id="reset_password_submit_step_two"
                                        class="btn btn-primary mt-1"><?php echo $l->line('Reset password'); ?></button>
                            </div>
                        </div>

                    </form>
                <?php } ?>


            </div>
        </div>
    </div>
</main>