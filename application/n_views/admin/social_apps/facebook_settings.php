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
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <b><?php echo $this->lang->line("App Domain") . "</b> : <span class='blue'>" . get_domain_only(base_url()); ?></span>
                    <br/>
                    <b><?php echo $this->lang->line("Site URL") . " :</b> <span class='blue'>" . base_url(); ?></span>
                        <br/><br>
                        <b><?php echo $this->lang->line("Privacy Policy URL") . " :</b> <span class='blue'>" . base_url('home/privacy_policy'); ?></span>
                            <br/>
                            <b><?php echo $this->lang->line("Terms of Service URL") . " :</b> <span class='blue'>" . base_url('home/terms_use'); ?></span>
                                <br/><br>

                                <b><?php echo $this->lang->line("Webhook Callback URL") . " :</b> <br><span class='blue'>" . base_url('home/central_webhook_callback'); ?></span>
                                    <br/>
                                    <?php
                                    if ($this->config->item('central_webhook_verify_token') == '') {
                                        $verify_token = substr(uniqid(mt_rand(), true), 0, 10);
                                        include('application/config/my_config.php');
                                        // if(!isset($config['central_webhook_verify_token']))
                                        // {
                                        $config['central_webhook_verify_token'] = $verify_token;
                                        file_put_contents('application/config/my_config.php', '<?php $config = ' . var_export($config, true) . ';');
                                        redirect($this->uri->uri_string());
                                        // }
                                    }
                                    ?>
                                    <b><?php echo $this->lang->line("Webhook Verify Token") . " :</b> <span class='blue'>" . $this->config->item('central_webhook_verify_token'); ?></span>
                                        <br/>

            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">

            <div class="card-body" style="min-height: 165px;">

                <b><?php echo $this->lang->line("Valid OAuth Redirect URI") . " </b>: <br><br><span class='blue'>" . base_url("home/facebook_login_back"); ?></span>
                    <br>
                    <span class="blue"><?php echo base_url('home/redirect_rx_link'); ?></span><br/>
                    <span class="blue"><?php echo base_url('social_accounts/manual_renew_account'); ?></span><br/>
                    <!-- <span class="blue"><?php echo base_url('facebook_rx_account_import/redirect_custer_link'); ?></span> -->

            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("social_apps/facebook_settings_update_action"); ?>" method="POST">
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
                                   value="<?php echo isset($facebook_settings['app_name']) ? $facebook_settings['app_name'] : set_value('app_name'); ?>"
                                   class="form-control" type="text">
                            <span class="text-danger"><?php echo form_error('app_name'); ?></span>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-id-card"></i> <?php echo $this->lang->line("App ID"); ?>
                                    </label>
                                    <input name="api_id"
                                           value="<?php echo isset($facebook_settings['api_id']) ? $facebook_settings['api_id'] : set_value('api_id'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('api_id'); ?></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-key"></i> <?php echo $this->lang->line("App Secret"); ?>
                                    </label>
                                    <input name="api_secret"
                                           value="<?php echo isset($facebook_settings['api_secret']) ? $facebook_settings['api_secret'] : set_value('api_secret'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('api_secret'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
                            $status = isset($facebook_settings['status']) ? $facebook_settings['status'] : "";
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
	   				

