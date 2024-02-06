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
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('social_apps/wordpress_settings_self_hosted'); ?>"><?php echo $this->lang->line("Wordpress settings (self-hosted)"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <form method="POST">
        <input type="hidden" name="csrf_token" id="csrf_token"
               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

        <div class="row">
            <div class="col-12">

                <?php if ($this->session->userdata('add_wssh_error')): ?>
                    <div class="alert alert-warning alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>×</span>
                            </button>
                            <?php echo $this->session->userdata('add_wssh_error'); ?>
                            <?php echo $this->session->unset_userdata('add_wssh_error'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- starts card -->
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title"><i
                                    class="bx bxs-help-circle"></i> <?php echo $this->lang->line("App Details"); ?></h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="domain_name"><i
                                                class="bx bx-globe"></i> <?php echo $this->lang->line("Wordpress blog URL"); ?>
                                    </label>
                                    <span data-toggle="tooltip"
                                          data-original-title="<?php echo $this->lang->line('Provide your wordpress blog URL.'); ?>"><i
                                                class="bx bxs-help-circle"></i></span>
                                    <input id="domain_name" name="domain_name"
                                           value="<?php echo isset($wp_settings['domain_name']) ? $wp_settings['domain_name'] : set_value('domain_name'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('domain_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="user_key"><i
                                                class="bx bx-pencil"></i> <?php echo $this->lang->line("User Key"); ?>
                                    </label>
                                    <span data-toggle="tooltip"
                                          data-original-title="<?php echo $this->lang->line('User Key can be achieved from the Wordpress Self-hosted Authentication section of the Wordpress > Users > Your Profile page.'); ?>"><i
                                                class="bx bxs-help-circle"></i></span>
                                    <input id="user_key" name="user_key"
                                           value="<?php echo isset($wp_settings['user_key']) ? $wp_settings['user_key'] : set_value('user_key'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('user_key'); ?></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="authentication_key"><i
                                                class="bx bx-id-card"></i> <?php echo $this->lang->line("Authentication Key"); ?>
                                    </label>
                                    <span data-toggle="tooltip"
                                          data-original-title="<?php echo $this->lang->line('Authentication Key needs to be put on the Wordpress Self-hosted Authentication section of the Wordpress > Users > Your Profile page.'); ?>"><i
                                                class="bx bxs-help-circle"></i></span>
                                    <input id="authentication_key" name="authentication_key"
                                           value="<?php echo isset($wp_settings['authentication_key']) ? $wp_settings['authentication_key'] : set_value('authentication_key', $auth_key); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('authentication_key'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="status" id="status" value="1"
                                       class="custom-control-input" <?php echo (isset($wp_settings['status']) && '1' == $wp_settings['status']) ? 'checked' : ''; ?>>
                                <label class="custom-control-label mr-1" for="status"></label>
                                <span><?php echo $this->lang->line('Active'); ?></span>
                                <span class="text-danger"><?php echo form_error('status'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <button class="btn btn-secondary float-right"
                                onclick='goBack("social_apps/wordpress_settings_self_hosted")' type="button"><i
                                    class="bx bx-trash"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>

                </div>
                <!-- ends card -->
            </div>
            <!-- ends col-12 -->
        </div>
        <!-- ends row -->
    </form>
</div>
<!-- ends section-body -->
