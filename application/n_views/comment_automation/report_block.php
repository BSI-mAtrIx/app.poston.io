<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt ml-25"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/comment_growth_tools"); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a>
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


<div class="content-body">
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
                        <p><?php echo $this->lang->line("Report of auto comment on page's post."); ?></p>
                        <a href="<?php echo base_url("comment_automation/all_auto_comment_report"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                            <i class="bx bx-chevron-right ml-25"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(80, $this->module_access)) : ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-reply"></i> <?php echo $this->lang->line("Auto reply report"); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Report of auto comment reply & private reply."); ?></p>
                        <a href="<?php echo base_url("comment_automation/all_auto_reply_report"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                            <i class="bx bx-chevron-right ml-25"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if ($this->basic->is_exist("add_ons", array("project_id" => 29)))
            if ($this->session->userdata('user_type') == 'Admin' || in_array(201, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bx-purchase-tag-alt"></i> <?php echo $this->lang->line("Comment bulk tag report"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Report of bulk tag in single comment."); ?></p>
                            <a href="<?php echo base_url("comment_reply_enhancers/bulk_tag_campaign_list"); ?>"
                               class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                                <i class="bx bx-chevron-right ml-25"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php
        if ($this->basic->is_exist("add_ons", array("project_id" => 29)))
            if ($this->session->userdata('user_type') == 'Admin' || in_array(202, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bx-conversation"></i> <?php echo $this->lang->line("Bulk comment reply report"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Report of tag in each reply of comment."); ?></p>
                            <a href="<?php echo base_url("comment_reply_enhancers/bulk_comment_reply_campaign_list"); ?>"
                               class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                                <i class="bx bx-chevron-right ml-25"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php
        if ($this->basic->is_exist("add_ons", array("project_id" => 29)))
            if ($this->session->userdata('user_type') == 'Admin' || in_array(204, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bx-reply-all"></i> <?php echo $this->lang->line("Full PageResponse Report"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Report of comment reply & private reply of full pages."); ?></p>
                            <a href="<?php echo base_url("comment_reply_enhancers/all_response_report"); ?>"
                               class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                                <i class="bx bx-chevron-right ml-25"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php
        if ($this->basic->is_exist("add_ons", array("project_id" => 29)))
            if ($this->session->userdata('user_type') == 'Admin' || in_array(206, $this->module_access)) : ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i
                                        class="bx bx-like"></i> <?php echo $this->lang->line("Auto Like & Share Report"); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><?php echo $this->lang->line("Report of sharing & liking by other page's you own."); ?></p>
                            <a href="<?php echo base_url("comment_reply_enhancers/all_like_share_report"); ?>"
                               class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("See Report"); ?>
                                <i class="bx bx-chevron-right ml-25"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

    </div>
</div>
