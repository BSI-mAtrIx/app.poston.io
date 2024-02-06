<style>

    .makeScroll {
        height: 500px;
        overflow: hidden;
    }

    .medium_text_and_button h4 {
        line-height: 40px !important;
    }

    .medium_text_and_button .card-header-action {
        margin-top: 5px !important;
    }

    .medium_account_token_field .import_medium_account {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    @media (max-width: 575.98px) {
        .avatar-item .avatar-badge {
            position: absolute;
            bottom: 5px;
            right: 95px;
            margin-right: 0;
        }
    }

    .modal-backdrop {
        display: none;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line('Social Accounts'); ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item "><a
                                href="<?php echo base_url('ultrapost'); ?>"><?php echo $this->lang->line('Comboposter'); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php

if ($this->session->userdata('account_import_error') != '') {

    echo "<div class='alert alert-danger text-center'><div class='d-flex align-items-center'><i class='bx bx-check-circle'></i><span> " . $this->session->userdata('account_import_error') . "</span></div></div>";
    $this->session->unset_userdata('account_import_error');
}


if ($this->session->userdata('limit_cross') != '') {

    echo "<div class='alert alert-danger text-center'><div class='d-flex align-items-center'><i class='bx bx-check-circle'></i><span> " . $this->session->userdata('limit_cross') . "</span></div></div>";
    $this->session->unset_userdata('limit_cross');
}

?>

<div class="content-body" id="stacked-pill">
    <div class="bg-transparent shadow-none">
        <div class="row pills-stacked">

            <div class="col-md-3 col-sm-12">
                <ul class="nav nav-pills flex-column text-center text-md-left">

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(102, $this->module_access)) : ?>
                        <li class="nav-item">
                            <a href="#bxl-twitter" class="nav-link align-items-center active" data-toggle="pill"
                               aria-expanded="true">
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

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(103, $this->module_access)) : ?>
                        <li class="nav-item">
                            <a href="#bxl-linkedin" class="nav-link align-items-center" data-toggle="pill"
                               aria-expanded="true">
                                <i class="bx bxl-linkedin"></i>
                                <?php echo $this->lang->line('Linkedin Accounts'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(105, $this->module_access)) : ?>
                        <li class="nav-item">
                            <a href="#bxl-reddit" class="nav-link align-items-center" data-toggle="pill"
                               aria-expanded="true">
                                <i class="bx bxl-reddit"></i>
                                <?php echo $this->lang->line('Reddit Accounts'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

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
                            <a href="#bxl-blogger" class="nav-link align-items-center" data-toggle="pill"
                               aria-expanded="true">
                                <i class="bx bxl-blogger"></i>
                                <?php echo $this->lang->line('Blogger Accounts'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(108, $this->module_access)) : ?>
                        <li class="nav-item">
                            <a href="#bxl-wordpress" class="nav-link align-items-center" data-toggle="pill"
                               aria-expanded="true">
                                <i class="bx bxl-wordpress"></i>
                                <?php echo $this->lang->line('Wordpress Accounts'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(109, $this->module_access)) : ?>
                        <li class="nav-item">
                            <a href="#bxl-wordpress-self" class="nav-link align-items-center" data-toggle="pill"
                               aria-expanded="true">
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

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(102, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card active" id="bxl-twitter" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Twitter Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $twitter_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($twitter_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['profile_image']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                 alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?>
                                                                ( @<?php echo $single_account['screen_name'] ?> )</h5>
                                                            <div class="font-small-2"><?php echo $this->lang->line('Followers'); ?>
                                                                : <?php echo $single_account['followers']; ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#"
                                                               class="btn-circle btn btn-outline-danger delete_account"
                                                               table_id="<?php echo $single_account['id']; ?>"
                                                               title="<?php echo $this->lang->line("Delete Account"); ?>"
                                                               data-placement="left" data-toggle="tooltip"
                                                               social_media="twitter">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!--
                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(104, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-tumblr" aria-labelledby="brand"  aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Tumblr Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $tumblr_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($tumblr_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['profile_image']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>" alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?> ( @<?php echo $single_account['screen_name'] ?> )</h5>
                                                            <div class="font-small-2"><?php echo $this->lang->line('Followers'); ?>: <?php echo $single_account['followers']; ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#" class="btn-circle btn btn-outline-danger delete_account" table_id="<?php echo $single_account['id']; ?>" title="<?php echo $this->lang->line("Delete Account"); ?>" data-placement="left" data-toggle="tooltip" social_media="tumblr">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                                                                            </tbody>
                                        </table>
                                    </div>
                                                                                </div>
                            </div>
                        </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                     -->

                    <!--
                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(33, $this->module_access)) : ?>
            <div role="tabpanel" class="tab-pane card" id="bxl-youtube" aria-labelledby="brand"  aria-expanded="true">
                <div class="card-header border-bottom">
                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Youtube Channels'); ?></h4>
                    <div class="heading-elements" style="top:13px;">
                        <?php echo $youtube_login_button; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                <?php foreach ($youtube_channel_list as $key => $single_account): ?>
                                    <?php $img_src = $single_account['profile_image']; ?>
                                    <tr>
                                        <td class="width-15-per p-0">
                                            <div class="avatar bg-rgba-primary p-25 ml-0">
                                                <img class="img-fluid" src="<?php echo $img_src; ?>" alt="img placeholder" height="70" width="70">
                                            </div>
                                        </td>
                                        <td class="pl-0">
                                            <div>
                                                <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?> ( @<?php echo $single_account['screen_name'] ?> )</h5>
                                                <div class="font-small-2"><?php echo $this->lang->line('Videos'); ?>: <?php echo $single_account['video_count']; ?></div>
                                                <div class="font-small-2"><?php echo $this->lang->line('Subscribers'); ?>: <?php echo $single_account['subscriber_count']; ?></div>
                                            </div>
                                        </td>
                                        <td class="width-40-per ">
                                            <div class="float-right">
                                                <a style="margin-top:10px;margin-right:5px;" href="#" class="btn-circle btn btn-outline-danger delete_account" table_id="<?php echo $single_account['id']; ?>" title="<?php echo $this->lang->line("Delete Account"); ?>" data-placement="left" data-toggle="tooltip">
                                                    <i class="bx bx-trash-alt"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>




                    </div>
                </div>
            </div>
        <?php endif; ?>
                    -->

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(103, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-linkedin" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Linkedin Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $linkedin_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($linkedin_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['profile_pic']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                 alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?></h5>
                                                            <div class="font-small-2"><?php echo $single_account['linkedin_id'] ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#"
                                                               class="btn-circle btn btn-outline-danger delete_account"
                                                               table_id="<?php echo $single_account['id']; ?>"
                                                               title="<?php echo $this->lang->line("Delete Account"); ?>"
                                                               data-placement="left" data-toggle="tooltip"
                                                               social_media="linkedin">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(105, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-reddit" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Reddit Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $reddit_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($reddit_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['profile_pic']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                 alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['username']; ?></h5>
                                                            <div class="font-small-2"><a
                                                                        href="<?php echo 'https://www.reddit.com' . $single_account['url'] ?>"
                                                                        target="_BLANK"><?php echo $this->lang->line("Visit Reddit"); ?></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#"
                                                               class="btn-circle btn btn-outline-danger delete_account"
                                                               table_id="<?php echo $single_account['id']; ?>"
                                                               title="<?php echo $this->lang->line("Delete Account"); ?>"
                                                               data-placement="left" data-toggle="tooltip"
                                                               social_media="reddit">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!--
                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(101, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-pinterest" aria-labelledby="brand"  aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Pinterest Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $pinterest_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($pinterest_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['image']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>" alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?> ( @<?php echo $single_account['user_name'] ?> )</h5>
                                                            <div class="font-small-2"><?php echo $this->lang->line('Boards'); ?>: <?php echo $single_account['boards']; ?></div>
                                                            <div class="font-small-2"><?php echo $this->lang->line('Pins'); ?>: <?php echo $single_account['pins']; ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#" class="btn-circle btn btn-outline-danger delete_account" table_id="<?php echo $single_account['id']; ?>" title="<?php echo $this->lang->line("Delete Account"); ?>" data-placement="left" data-toggle="tooltip" social_media="pinterest">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>




                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    -->

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(107, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-blogger" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Blogger Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $blogger_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($blogger_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['picture']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                 alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?>
                                                                ( @ <?php echo $single_account['blogger_id']; ?> )</h5>
                                                            <div class="font-small-2"><?php echo $this->lang->line('Blogs'); ?>
                                                                : <?php echo $single_account['blog_count']; ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#"
                                                               class="btn-circle btn btn-outline-danger delete_account"
                                                               table_id="<?php echo $single_account['id']; ?>"
                                                               title="<?php echo $this->lang->line("Delete Account"); ?>"
                                                               data-placement="left" data-toggle="tooltip"
                                                               social_media="blogger">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(108, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-wordpress" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Wordpress Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $wordpress_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($wordpress_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['icon']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                 alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?>
                                                                ( @<?php echo $single_account['blog_id']; ?> )</h5>
                                                            <div class="font-small-2"><?php echo $this->lang->line('Posts'); ?>
                                                                : <?php echo $single_account['posts']; ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#"
                                                               class="btn-circle btn btn-outline-danger delete_account"
                                                               table_id="<?php echo $single_account['id']; ?>"
                                                               title="<?php echo $this->lang->line("Delete Account"); ?>"
                                                               data-placement="left" data-toggle="tooltip"
                                                               social_media="wordpress">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(109, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-wordpress-self" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Wordpress Site (Self-Hosted)'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <?php echo $wordpress_self_hosted_login_button; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($wordpress_account_list_self_hosted as $key => $single_account): ?>
                                                <?php $img_src = base_url('assets/images/wordpress.png'); ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                 alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['domain_name']; ?></h5>
                                                            <div class="font-small-2"><?php echo $single_account['user_key'] ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#"
                                                               class="btn-circle btn btn-outline-danger delete_account"
                                                               data-site-id="<?php echo $single_account['id']; ?>"
                                                               title="<?php echo $this->lang->line("Delete Account"); ?>"
                                                               data-placement="left" data-toggle="tooltip"
                                                               id="delete-wssh-settings">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(277, $this->module_access)) : ?>
                        <div role="tabpanel" class="tab-pane card" id="bxl-medium" aria-labelledby="brand"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Medium Accounts'); ?></h4>
                                <div class="heading-elements" style="top:13px;">
                                    <a href="#" class="btn btn-outline-primary show_hide_medium_token_field"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Import Account'); ?>
                                    </a>
                                    <!-- <?php echo $medium_login_button; ?> -->
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group mb-0 mt-0 medium_account_token_field" style="display: none;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="medium_integration_token"
                                                   name="medium_integration_token"
                                                   placeholder="<?php echo $this->lang->line('Provide Integration Token'); ?>"
                                                   aria-label="">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary mt-0 import_medium_account"
                                                        type="button"><i
                                                            class="bx bx-paper-plane mr-1"></i> <?php echo $this->lang->line('Import'); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <?php foreach ($medium_account_list as $key => $single_account): ?>
                                                <?php $img_src = $single_account['profile_pic']; ?>
                                                <tr>
                                                    <td class="width-15-per p-0">
                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                            <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                 alt="img placeholder" height="70" width="70">
                                                        </div>
                                                    </td>
                                                    <td class="pl-0">
                                                        <div>
                                                            <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?></h5>
                                                            <div class="font-small-2"><?php echo $single_account['medium_id'] ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="width-40-per ">
                                                        <div class="float-right">
                                                            <a style="margin-top:10px;margin-right:5px;" href="#"
                                                               class="btn-circle btn btn-outline-danger delete_account"
                                                               table_id="<?php echo $single_account['id']; ?>"
                                                               title="<?php echo $this->lang->line("Delete Account"); ?>"
                                                               data-placement="left" data-toggle="tooltip"
                                                               social_media="medium">
                                                                <i class="bx bx-trash-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>
</div>
