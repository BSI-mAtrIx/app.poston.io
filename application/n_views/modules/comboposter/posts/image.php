<?php $include_view_prefix = FCPATH . 'application/n_views/modules/comboposter/'; ?>


<?php
/* include universal css */
include $include_view_prefix . 'posts/universal_css.php';
?>
<?php
if ($post_action == 'add') {

    $header = $this->lang->line("Create Post");
    $breadcrumb = $this->lang->line("Create post");
    $icon = 'bx bx-plus-circle';
    $campaign_btn = $this->lang->line("Create Campaign");
    $campaign_btn_icon = 'bx bx-paper-plane';
} else if ($post_action == 'edit') {

    $header = $this->lang->line("Edit Post");
    $breadcrumb = $this->lang->line("Edit post");
    $icon = 'bx bx-edit';
    $campaign_btn = $this->lang->line("Edit Campaign");
    $campaign_btn_icon = 'bx bx-edit';
} else if ($post_action == 'clone') {

    $header = $this->lang->line("Clone Post");
    $breadcrumb = $this->lang->line("Clone post");
    $icon = 'bx bx-duplicate';
    $campaign_btn = $this->lang->line("Clone Campaign");
    $campaign_btn_icon = 'bx bx-duplicate';
}
?>

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $header; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Comboposter"); ?></a>
                        </li>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("comboposter/image_post/campaigns"); ?>"><?php echo $this->lang->line("Image post"); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo $breadcrumb; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="section-body">
        <div class="row">
            <form action="#" enctype="multipart/form-data" id="comboposter_form" method="post" style="width: 100%;">

                <div class="col-12">
                    <?php
                    /* include form */
                    include $include_view_prefix . 'posts/forms/image_post_form.php';
                    ?>
                </div>

                <!-- Accounts -->
                <div class="col-12">
                    <div class="bg-transparent shadow-none">
                        <div class="row pills-stacked">

                            <div class="col-md-3 col-sm-12">
                                <ul class="nav nav-pills flex-column text-center text-md-left">

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(102, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-facebook" class="nav-link align-items-center active"
                                               data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-facebook"></i>
                                                <?php echo $this->lang->line('Facebook Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(102, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-twitter" class="nav-link align-items-center"
                                               data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-twitter"></i>
                                                <?php echo $this->lang->line('Twitter Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(104, $this->module_access)) : ?>
                                    <li class="nav-item">
                                        <a href="#bxl-tumblr" class="nav-link align-items-center" data-toggle="pill" aria-expanded="true">
                                            <i class="bx bxl-tumblr"></i>
                                            <?php echo $this->lang->line('Tumblr Accounts'); ?>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    -->

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(33, $this->module_access)) : ?>
                                    <li class="nav-item">
                                        <a href="#bxl-youtube" class="nav-link align-items-center" data-toggle="pill" aria-expanded="true">
                                            <i class="bx bxl-youtube"></i>
                                            <?php echo $this->lang->line('Youtube Channels') ?>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    -->

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(103, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-linkedin" class="nav-link align-items-center" data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-linkedin"></i>
                                                <?php echo $this->lang->line('Linkedin Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    -->

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(105, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-reddit" class="nav-link align-items-center" data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-reddit"></i>
                                                <?php echo $this->lang->line('Reddit Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    -->

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(101, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-pinterest" class="nav-link align-items-center" data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-pinterest"></i>
                                                <?php echo $this->lang->line('Pinterest Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    -->


                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(107, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-blogger" class="nav-link align-items-center"
                                               data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-blogger"></i>
                                                <?php echo $this->lang->line('Blogger Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>



                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(108, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-wordpress" class="nav-link align-items-center"
                                               data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-wordpress"></i>
                                                <?php echo $this->lang->line('Wordpress Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(109, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-wordpress-self" class="nav-link align-items-center"
                                               data-toggle="pill" aria-expanded="true">
                                                <i class="bx bxl-wordpress"></i>
                                                <?php echo $this->lang->line('Wordpress Site (Self-Hosted)'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(277, $this->module_access)) : ?>
                                        <li class="nav-item">
                                            <a href="#bxl-medium" class="nav-link align-items-center" data-toggle="pill"
                                               aria-expanded="true">
                                                <i class="bx bxl-medium"></i>
                                                <?php echo $this->lang->line('Medium Accounts'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>


                                </ul>
                            </div>

                            <div class="col-md-9 col-sm-12">
                                <div class="tab-content p-0 bg-transparent shadow-none">

                                    <div role="tabpanel" class="tab-pane active" id="bxl-facebook"
                                         aria-labelledby="brand" aria-expanded="true">
                                        <?php include $include_view_prefix . 'posts/social_accounts/facebook.php'; ?>
                                    </div>

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(102, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-twitter" aria-labelledby="brand"
                                             aria-expanded="true">
                                            <?php include $include_view_prefix . 'posts/social_accounts/twitter.php'; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(104, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-tumblr" aria-labelledby="brand"  aria-expanded="true">
                                            <?php //include $include_view_prefix.'posts/social_accounts/tumblr.php'; ?>
                                        </div>
                                    <?php endif; ?>
                                    -->

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(33, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-youtube" aria-labelledby="brand"  aria-expanded="true">
                                            <?php //include $include_view_prefix.'posts/social_accounts/youtube.php'; ?>
                                        </div>
                                    <?php endif; ?>
                                    -->

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(103, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-linkedin" aria-labelledby="brand"
                                             aria-expanded="true">
                                            <?php include $include_view_prefix . 'posts/social_accounts/linkedin.php'; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(105, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-reddit" aria-labelledby="brand"
                                             aria-expanded="true">
                                            <?php include $include_view_prefix . 'posts/social_accounts/reddit.php'; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!--
                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(101, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-pinterest" aria-labelledby="brand"  aria-expanded="true">
                                            <?php //include $include_view_prefix.'posts/social_accounts/pinterest.php'; ?>
                                        </div>
                                    <?php endif; ?>
                                    -->


                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(107, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-blogger" aria-labelledby="brand"
                                             aria-expanded="true">
                                            <?php include $include_view_prefix . 'posts/social_accounts/blogger.php'; ?>
                                        </div>
                                    <?php endif; ?>



                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(108, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-wordpress" aria-labelledby="brand"
                                             aria-expanded="true">
                                            <?php include $include_view_prefix . 'posts/social_accounts/wordpress.php'; ?>
                                        </div>
                                    <?php endif; ?>


                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(109, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-wordpress-self"
                                             aria-labelledby="brand" aria-expanded="true">
                                            <?php include $include_view_prefix . 'posts/social_accounts/wordpress_self_hosted.php'; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(277, $this->module_access)) : ?>
                                        <div role="tabpanel" class="tab-pane" id="bxl-medium" aria-labelledby="brand"
                                             aria-expanded="true">
                                            <?php include $include_view_prefix . 'posts/social_accounts/medium.php'; ?>
                                        </div>
                                    <?php endif; ?>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </form>

            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-footer">

                            <a class="btn btn-light " onclick='goBack("comboposter/image_post/campaigns",0)'><i
                                        class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>

                            <button class="btn btn-primary float-right" post_type="image"
                                    action_type="<?php echo $post_action; ?>" id="submit_post" type="button"><i
                                        class="<?php echo $campaign_btn_icon ?>"></i> <?php echo $campaign_btn; ?>
                            </button>


                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


<?php
/* include universal js */
$include_js_uni = $include_view_prefix . 'posts/universal_js.php';

/* include js for triggering preview for edit */
if ($post_action == 'edit') {
    $include_js_uni_2 = $include_view_prefix . 'posts/trigger_preview_for_edit.php';
}
?>