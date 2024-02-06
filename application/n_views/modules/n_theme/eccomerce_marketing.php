<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ecommerce"); ?>"><?php echo $this->lang->line("E-commerce"); ?></a>
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
            <div class="card shadow-none">
                <div class="card-body p-0">
                    <form class="form-horizontal text-c"
                          action="<?php echo site_url() . 'n_theme/ecommerce_marketing_save'; ?>" method="POST">
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                        <p><?php echo $this->lang->line("You can add here Facebook Pixel, Google Pixel, Facebook Messenger codes. You can also put any other codes before <code>&lt;/body&gt;</code> tag. "); ?></p>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="codes_before_body" name="codes_before_body" rows="18"
                                      placeholder="Textarea" spellcheck="false"
                                      data-ms-editor="true"><?php echo $code_before_body; ?></textarea>
                        </fieldset>
                        <span class="text-danger"><?php echo form_error('codes_before_body'); ?></span>

                        <div class="card-footer p-0">
                            <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bx-save"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>