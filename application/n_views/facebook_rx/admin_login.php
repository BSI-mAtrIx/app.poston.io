<?php
if (isset($fb_login_button))
    $fb_login_button = str_replace("ThisIsTheLoginButtonForFacebook", $this->lang->line("Login with Facebook"), $fb_login_button);
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("Admin login section") ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('social_apps/index'); ?>"><?php echo $this->lang->line("Social APPs"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="card" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <?php if (isset($expired_or_not) && $expired_or_not == 1) : ?>
                    <h5 class="text-center"><i class="bx bxs-help-circle"
                                               style="font-size: 18px;"></i> <?php echo $this->lang->line("User access token is valid. you can login and get new user access token if you want."); ?>
                    </h5>
                <?php endif; ?>
                <br/>

                <?php if (isset($fb_login_button)) : ?>
                    <h3 class="text-center"><?php echo $fb_login_button; ?></h3>
                <?php endif; ?>

                <?php
                if (isset($message)) :
                    if (isset($error) && $error == 1) :
                        ?>
                        <img class="img-fluid" style="height: 300px"
                             src="<?php echo base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg'); ?>"
                             alt="image">
                        <h2 class="mt-0 text-danger"><?php echo $message; ?></h2>
                        <br/>
                    <?php else : ?>
                        <h2 class="mt-0 text-info"><?php echo $message; ?></h2>
                        <br/>
                    <?php
                    endif;
                endif;
                ?>
                <a href="<?php echo base_url("social_apps/index"); ?>"><i
                            class="bx bx-left-arrow-circle"></i> <?php echo $this->lang->line("go back"); ?></a>
            </div>
        </div>
    </div>
</div>
