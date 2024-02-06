<?php

$jodit = 1;

?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('admin/settings'); ?>"><?php echo $this->lang->line("Settings"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("admin/analytics_settings_action"); ?>" method="POST">

                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-xs-12"
                                   for=""><?php echo $this->lang->line("Paste Facebook Pixel Code"); ?>
                                (<?php echo $this->lang->line("Inside Script Tag"); ?>)
                            </label>
                            <?php
                            $pixel_code = file_get_contents(APPPATH . 'views/include/fb_px.php');
                            ?>
                            <div class="col-xs-12">
                                <textarea name="pixel_code"
                                          class="codeeditor"><?php echo trim($pixel_code); ?></textarea>
                                <span class="text-danger"><?php echo form_error('pixel_code'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12"
                                   for=""><?php echo $this->lang->line("Paste Google Analytics Code"); ?>
                                (<?php echo $this->lang->line("Inside Script Tag"); ?>)
                            </label>
                            <?php
                            $file_data = file_get_contents(APPPATH . 'views/include/google_code.php');
                            ?>
                            <div class="col-xs-12">
                                <textarea name="google_code"
                                          class="codeeditor"><?php echo trim($file_data); ?></textarea>
                                <span class="text-danger"><?php echo form_error('google_code'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <button class="btn btn-secondary float-right" onclick='goBack("admin/settings")' type="button">
                            <i class="bx bx-trash"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

