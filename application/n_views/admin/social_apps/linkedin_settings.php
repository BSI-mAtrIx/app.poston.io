<style>
    .blue {
        color: #2C9BB3 !important;
    }
</style>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('social_apps/settings'); ?>"><?php echo $this->lang->line("Social Apps"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('integration'); ?>"><?php echo $this->lang->line("Integration"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <b><?php echo $this->lang->line("Redirect URLs") . "</b> : <span class='blue'>" . base_url('comboposter/login_callback/linkedin'); ?></span>
                    <br/>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("social_apps/linkedin_settings_update_action"); ?>" method="POST">
                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                <input type="hidden" name="table_id" value="<?php echo $table_id ?>">
                <div class="card">
                    <div class="card-header"><h4 class="card-title"><i
                                    class="bx bxs-help-circle"></i> <?php echo $this->lang->line("App Details"); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""><i class="bx bx-pencil"></i> <?php echo $this->lang->line("App Name"); ?>
                            </label>
                            <input name="app_name"
                                   value="<?php echo isset($linkedin_settings['app_name']) ? $linkedin_settings['app_name'] : set_value('app_name'); ?>"
                                   class="form-control" type="text">
                            <span class="text-danger"><?php echo form_error('app_name'); ?></span>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-id-card"></i> <?php echo $this->lang->line("Client ID"); ?>
                                    </label>
                                    <input name="client_id"
                                           value="<?php echo isset($linkedin_settings['client_id']) ? $linkedin_settings['client_id'] : set_value('client_id'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('client_id'); ?></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-key"></i> <?php echo $this->lang->line("Client Secret"); ?>
                                    </label>
                                    <input name="client_secret"
                                           value="<?php echo isset($linkedin_settings['client_secret']) ? $linkedin_settings['client_secret'] : set_value('client_secret'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('client_secret'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
                            $status = isset($linkedin_settings['status']) ? $linkedin_settings['status'] : "";
                            if ($status == '') $status = '1';
                            ?>
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="status" id="status" value="1"
                                       class="custom-control-input" <?php if ($status == '1') echo 'checked'; ?>>
                                <label class="custom-control-label mr-1" for="status"></label>
                                <span><?php echo $this->lang->line('Active'); ?></span>
                                <span class="text-danger"><?php echo form_error('status'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <button class="btn btn-secondary float-right" onclick='goBack("social_apps/index")'
                                type="button"><i class="bx bx-trash"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
