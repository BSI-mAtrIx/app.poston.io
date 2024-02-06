<style type="text/css">.no_hover:hover {
        text-decoration: none;
    }</style>

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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-primary">
                    <h4><?php echo $this->lang->line("Page Manager"); ?></h4>
                </div>
                <div class="card-body">

                    <p><?php echo $this->lang->line("Create, edit, delete custom pages"); ?></p>
                    <a href="<?php echo base_url("menu_manager/get_page_lists"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?> <i
                                class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-primary">
                    <h4><?php echo $this->lang->line("Link Manager"); ?></h4>
                </div>
                <div class="card-body">

                    <p><?php echo $this->lang->line("Create menu links, manage menu links"); ?></p>
                    <a href="<?php echo base_url("menu_manager/get_menu_lists"); ?>"
                       class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?> <i
                                class="bx bx-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>


