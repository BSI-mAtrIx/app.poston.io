<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/comment_growth_tools"); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("instagram_reply") ?>"><?php echo $this->lang->line("Instagram Reply"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-1">
        <?php if ($selected_global_media_type == 'fb') { ?>
            <a href="#" class="btn btn-primary social_switch"
               data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>
        <?php } else { ?>
            <a href="#" class="btn btn-primary social_switch"
               data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>
        <?php } ?>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(251, $this->module_access)) : ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-comment-dots"></i> <?php echo $this->lang->line("Auto Comment Report"); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Report of auto comment on instagram accounts's post."); ?></p>
                        <a href="<?php echo base_url("comment_automation/all_auto_comment_report/0/0/1"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bx-comment-dots"></i> <?php echo $this->lang->line("Auto Comment Reply Report"); ?>
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Report of auto comment on instagram accounts's post."); ?></p>
                    <a href="<?php echo base_url("instagram_reply/instagram_autoreply_report/post"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                        <i class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <?php if ($instagram_reply_enhancers_access == 1) : ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-briefcase"></i> <?php echo $this->lang->line("Full Account Reply Reports"); ?>
                        </h5>
                    </div>

                    <div class="card-body">
                        <p><?php echo $this->lang->line("Report of Posts comment reply of Instagram Full Account."); ?></p>
                        <a href="<?php echo base_url("instagram_reply/instagram_autoreply_report/full"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-purchase-tag-alt"></i> <?php echo $this->lang->line("Mention Reply Report"); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Report of Mention of instagram accounts's post."); ?></p>
                        <a href="<?php echo base_url("instagram_reply/instagram_autoreply_report/mention"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>