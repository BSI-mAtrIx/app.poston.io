<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("sms_email_sequence/template_lists/") . $templateType; ?>"><?php echo ucfirst($templateType) . ' ' . $this->lang->line("Template"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-body">
            <h2 class="section-title"><?php echo $this->lang->line("Template Name"); ?></h2>
            <div class="section-lead"><?php echo $template_data[0]['template_name']; ?></div>
            <h2 class="section-title"><?php echo $this->lang->line("Template Content"); ?></h2>
            <div class="alert alert-light section-lead mt-2"><?php echo $template_data[0]['content']; ?></div>
        </div>
    </div>
</div>
