<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('gmb'); ?>"><?php echo $this->lang->line('Google My Business'); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-large-icons">
                <div class="card-body">
                    <h4><?php echo $this->lang->line("Post campaigns"); ?></h4>
                    <p><?php echo $this->lang->line("Create campaigns using CTA, Event or Offer posts"); ?></p>
                    <a href="<?php echo base_url("gmb/posts"); ?>"
                       class="card-cta"><?php echo $this->lang->line("Campaign list"); ?> <i
                                class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-large-icons">
                <div class="card-body">
                    <h4><?php echo $this->lang->line("Media campaigns"); ?></h4>
                    <p><?php echo $this->lang->line("Create campaings using images or videos"); ?></p>
                    <a href="<?php echo base_url("gmb/media_campaigns"); ?>"
                       class="card-cta"><?php echo $this->lang->line("Campaign list"); ?> <i
                                class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(305, $this->module_access)) : ?>
            <div class="col-lg-6">
                <div class="card card-large-icons">
                    <div class="card-body">
                        <h4><?php echo $this->lang->line("RSS Auto Post"); ?></h4>
                        <p><?php echo $this->lang->line("Create campaigns using RSS auto posts"); ?></p>
                        <a href="<?php echo base_url("gmb/rss"); ?>"
                           class="card-cta"><?php echo $this->lang->line("Campaign list"); ?> <i
                                    class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
