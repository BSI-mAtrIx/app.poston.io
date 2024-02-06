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
                                href="<?php echo base_url("woocommerce_integration"); ?>"><?php echo $this->lang->line("WooCommerce Integration"); ?></a>
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
            <form action="<?php echo base_url("woocommerce_integration/woocommerce_settings_update_action"); ?>"
                  method="POST">
                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                <input type="hidden" name="table_id" value="<?php echo $table_id ?>">
                <div class="card">
                    <div class="card-header"><h4 class="card-title"><i
                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("WooCommerce API Settings"); ?>
                        </h4></div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line("Consumer Key"); ?> *</label>
                                    <input name="consumer_key"
                                           value="<?php echo isset($woocommerce_settings['consumer_key']) ? $woocommerce_settings['consumer_key'] : set_value('consumer_key'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('consumer_key'); ?></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line("Consumer Secret"); ?> *</label>
                                    <input name="consumer_secret"
                                           value="<?php echo isset($woocommerce_settings['consumer_secret']) ? $woocommerce_settings['consumer_secret'] : set_value('consumer_secret'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('consumer_secret'); ?></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line("Website Home URL"); ?> *</label>
                                    <input name="home_url"
                                           value="<?php echo isset($woocommerce_settings['home_url']) ? $woocommerce_settings['home_url'] : set_value('home_url'); ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('home_url'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <button class="btn btn-primary" id="save-btn" type="submit"><i
                                    class="bx bx-save"></i> <?php echo $this->lang->line("Save & Sync Data"); ?>
                        </button>
                        <button class="btn btn-secondary float-right" onclick='goBack("woocommerce_integration")'
                                type="button"><i class="bx bx-trash"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
	   				

