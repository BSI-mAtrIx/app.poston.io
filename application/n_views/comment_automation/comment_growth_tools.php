<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '201', '202', '204', '206', '220', '222', '223', '251', '256'])) > 0) : ?>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo $this->lang->line("Facebook"); ?> </h4>
                            </div>

                            <div class="card-body">
                                <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                                    <?php if ($this->session->userdata("user_type") == "Admin" || in_array(251, $this->module_access)) : ?>
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/comment.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Comment Template'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('Comment template management...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '220', '222', '223', '256'])) > 0) : ?>
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/reply.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('comment_automation/template_manager'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Reply Template'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('Reply template management...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('comment_automation/template_manager'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>
                                    <?php endif; ?>


                                    <?php if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '204', '206', '251'])) > 0) : ?>
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/page.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('comment_automation/index'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Automation Campaign'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('Campaign Automation management...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('comment_automation/index'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>
                                    <?php endif; ?>


                                    <?php
                                    if ($this->basic->is_exist("add_ons", array("project_id" => 29))) :
                                        if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['201', '202'])) > 0) :
                                            ?>
                                            <li class="media mb-2">
                                                <img alt="image" class="mr-3" width="50"
                                                     src="<?php echo base_url('assets/img/icon/single_tag.png'); ?>">
                                                <div class="media-body">
                                                    <a href="<?php echo base_url('comment_reply_enhancers/post_list'); ?>">
                                                        <div class="media-title"><?php echo $this->lang->line('Tag Campaign'); ?></div>
                                                    </a>
                                                    <div class="text-job text-muted"><?php echo $this->lang->line('Tag campaign management...'); ?></div>
                                                </div>
                                                <div class="media-cta">
                                                    <a href="<?php echo base_url('comment_reply_enhancers/post_list'); ?>"
                                                       class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                                </div>
                                            </li>
                                        <?php
                                        endif;
                                    endif;
                                    ?>

                                    <?php if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['80', '201', '202', '204', '206'])) > 0) : ?>
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/clock.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('comment_automation/comment_section_report'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Report'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('All campaign reports...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('comment_automation/comment_section_report'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->userdata("user_type") == "Admin" || count(array_intersect($this->module_access, ['278', '279'])) > 0) : ?>
                    <?php if ($this->config->item('instagram_reply_enable_disable') == '1') : ?>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><?php echo $this->lang->line("Instagram"); ?> </h4>
                                </div>

                                <div class="card-body">
                                    <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/comment.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Comment Template'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('Comment template management...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('comment_automation/comment_template_manager'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/reply.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('instagram_reply/template_manager'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Reply Template'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('Reply template management...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('instagram_reply/template_manager'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/page.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('instagram_reply/get_account_lists'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Automation Campaign'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('Campaign Automation management...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('instagram_reply/get_account_lists'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>
                                        <li class="media mb-2">
                                            <img alt="image" class="mr-3" width="50"
                                                 src="<?php echo base_url('assets/img/icon/clock.png'); ?>">
                                            <div class="media-body">
                                                <a href="<?php echo base_url('instagram_reply/reports'); ?>">
                                                    <div class="media-title"><?php echo $this->lang->line('Report'); ?></div>
                                                </a>
                                                <div class="text-job text-muted"><?php echo $this->lang->line('All campaign reports...'); ?></div>
                                            </div>
                                            <div class="media-cta">
                                                <a href="<?php echo base_url('instagram_reply/reports'); ?>"
                                                   class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                            </div>
                                        </li>

                                        <?php if (file_exists(APPPATH . "modules/n_igstats/controllers/N_igstats.php")) { ?>

                                            <li class="media mb-2">
                                                <img alt="image" class="mr-3" width="50"
                                                     src="<?php echo base_url('assets/img/icon/clock.png'); ?>">
                                                <div class="media-body">
                                                    <a href="<?php echo base_url('n_igstats/index'); ?>">
                                                        <div class="media-title"><?php echo $this->lang->line('Statistics'); ?></div>
                                                    </a>
                                                    <div class="text-job text-muted"><?php echo $this->lang->line('Statistics'); ?></div>
                                                </div>
                                                <div class="media-cta">
                                                    <a href="<?php echo base_url('n_igstats/index'); ?>"
                                                       class="btn btn-outline-primary"><?php echo $this->lang->line('Detail'); ?></a>
                                                </div>
                                            </li>

                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
