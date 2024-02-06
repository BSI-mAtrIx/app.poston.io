<style>
    .section-body a.btn {
        width: 100%;
        text-align: center;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("Comboposter"); ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("Comboposter"); ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url("social_accounts/index"); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Import Facebook Accounts"); ?>
        </a>
        <a href="<?php echo base_url("comboposter/social_accounts"); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Import Social Accounts"); ?>
        </a>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header border-bottom">
                    <?php if (($this->session->userdata('user_type') == 'Admin' || in_array(296, $this->module_access)) && $this->config->item('instagram_reply_enable_disable') == '1') : ?>
                        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Facebook/Instagram Poster"); ?></h4>
                    <?php else : ?>
                        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Comboposter"); ?></h4>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row">

                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(223, $this->module_access)) : ?>
                            <div class="col-sm-6 col-md-6">
                                <div class="text-center mx-auto my-1">
                                    <i class="bx bx-paper-plane font-large-2 text-info"></i>
                                </div>
                                <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Multimedia Post"); ?></p>
                                <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Text, Link, Image, Video"); ?></p>
                                <a href="<?php echo base_url("instagram_poster"); ?>"
                                   class="card-cta align-items-center btn btn-secondary"><i
                                            class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                </a>
                                <a href="<?php echo base_url("instagram_poster/image_video_poster"); ?>"
                                   class="card-cta align-items-center btn btn-success"><i
                                            class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(220, $this->module_access)) : ?>
                            <div class="col-sm-6 col-md-6">
                                <div class="text-center mx-auto my-1">
                                    <i class="bx bx-upvote font-large-2 text-info"></i>
                                </div>
                                <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("CTA Post"); ?></p>
                                <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Call to Action"); ?></p>
                                <a href="<?php echo base_url("ultrapost/cta_post"); ?>"
                                   class="card-cta align-items-center btn btn-secondary"><i
                                            class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                </a>
                                <a href="<?php echo base_url("ultrapost/cta_poster"); ?>"
                                   class="card-cta align-items-center btn btn-success"><i
                                            class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(222, $this->module_access)) : ?>
                            <div class="col-sm-6 col-md-6">
                                <div class="text-center mx-auto my-1">
                                    <i class="bx bx-video font-large-2 text-info"></i>
                                </div>
                                <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Carousel/Video Post"); ?></p>
                                <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Carousel, Slideshow"); ?></p>
                                <a href="<?php echo base_url("ultrapost/carousel_slider_post"); ?>"
                                   class="card-cta align-items-center btn btn-secondary"><i
                                            class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                </a>
                                <a href="<?php echo base_url("ultrapost/carousel_slider_poster"); ?>"
                                   class="card-cta align-items-center btn btn-success"><i
                                            class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->basic->is_exist("add_ons", array("project_id" => 41))) : ?>
                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(252, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bx-tv font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Facebook Livestreaming"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Go live with pre-recorded video"); ?></p>
                                    <a href="<?php echo base_url("vidcasterlive/live_scheduler_list"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                    <a href="<?php echo base_url("vidcasterlive/add_live_scheduler"); ?>"
                                       class="card-cta align-items-center btn btn-success"><i
                                                class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(296, $this->module_access)) : ?>
                            <?php if ($this->config->item('instagram_reply_enable_disable') == '1') : ?>
                                <div class="col-sm-6 col-md-6 d-none">
                                    <div class="text-center mx-auto my-1">
                                        <i class='bx bxl-instagram font-large-2 text-info'></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Instagram Posts"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Post on Instagram account..."); ?></p>
                                    <a href="<?php echo base_url("instagram_poster"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                    <a href="<?php echo base_url("instagram_poster/image_video_poster"); ?>"
                                       class="card-cta align-items-center btn btn-success"><i
                                                class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(100, $this->module_access)) : ?>
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Comboposter"); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(110, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bxs-file-txt font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Text Post"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Text Poster"); ?></p>
                                    <a href="<?php echo base_url("comboposter/text_post/campaigns"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                    <a href="<?php echo base_url("comboposter/text_post/create"); ?>"
                                       class="card-cta align-items-center btn btn-success"><i
                                                class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(111, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bx-image font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Image Post"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Image Poster"); ?></p>
                                    <a href="<?php echo base_url("comboposter/image_post/campaigns"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                    <a href="<?php echo base_url("comboposter/image_post/create"); ?>"
                                       class="card-cta align-items-center btn btn-success"><i
                                                class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(112, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bx-video font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Video Post"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Video Poster"); ?></p>
                                    <a href="<?php echo base_url("comboposter/video_post/campaigns"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                    <a href="<?php echo base_url("comboposter/video_post/create"); ?>"
                                       class="card-cta align-items-center btn btn-success"><i
                                                class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(113, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bx-link font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Link Post"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Link Poster"); ?></p>
                                    <a href="<?php echo base_url("comboposter/link_post/campaigns"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                    <a href="<?php echo base_url("comboposter/link_post/create"); ?>"
                                       class="card-cta align-items-center btn btn-success"><i
                                                class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(114, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bxs-file-html font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("HTML Post"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("HTML Poster"); ?></p>
                                    <a href="<?php echo base_url("comboposter/html_post/campaigns"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                    <a href="<?php echo base_url("comboposter/html_post/create"); ?>"
                                       class="card-cta align-items-center btn btn-success"><i
                                                class="bx bx-list-plus mr-1"></i> <?php echo $this->lang->line("Create new Post"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(223, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bx-menu font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Bulk Post Planner"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("Upload Text, Image, Link posts via CSV file"); ?></p>
                                    <a href="<?php echo base_url("post_planner"); ?>"
                                       class="card-cta align-items-center btn btn-secondary"><i
                                                class="bx bx-list-ul mr-1"></i> <?php echo $this->lang->line("Campaign List"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(256, $this->module_access)) : ?>
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-center mx-auto my-1">
                                        <i class="bx bx-sync font-large-2 text-info"></i>
                                    </div>
                                    <p class="text-bold-500 mb-0 line-ellipsis text-center font-medium-2"><?php echo $this->lang->line("Auto Post"); ?></p>
                                    <p class="text-muted text-center font-small-3 mb-1"><?php echo $this->lang->line("WP, YT auto post..."); ?></p>

                                    <a class="card-cta align-items-center btn btn-secondary"
                                       href="<?php echo base_url('autoposting/settings'); ?>">
                                        <i class="bx bx-rss mr-1"></i>
                                        <?php echo $this->lang->line("RSS feed post"); ?>
                                    </a>

                                    <?php if ($this->basic->is_exist("add_ons", array("unique_name" => "auto_feed_post"))) : ?>
                                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(269, $this->module_access)) : ?>
                                            <a class="card-cta align-items-center btn btn-info"
                                               href="<?php echo base_url('auto_feed_post/wordpress_settings'); ?>"><i
                                                        class="bx bxl-wordpress mr-1"></i> <?php echo $this->lang->line("WP feed post"); ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(276, $this->module_access)) : ?>
                                            <a class="card-cta align-items-center btn btn-danger"
                                               href="<?php echo base_url('auto_feed_post/youtube_settings'); ?>"><i
                                                        class="bx bxl-youtube mr-1"></i> <?php echo $this->lang->line("YouTube video post"); ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>


                                </div>
                            <?php endif; ?>


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
</div>
</div>

