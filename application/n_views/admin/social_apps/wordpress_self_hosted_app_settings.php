<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
?>

<style>
    .card {
        box-shadow: none !important;
    }

    .data-div {
        margin-left: 45px;
    }

    .margin-top {
        margin-top: 30px;
    }

    .flex-column .nav-item .nav-link.active {
        background: #fff !important;
        color: #3516df !important;
        border: 1px solid #988be1 !important;
    }

    .flex-column .nav-item .nav-link .form_id, .flex-column .nav-item .nav-link .insert_date {
        color: #608683 !important;
        font-size: 12px !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
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

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url('social_apps/add_wordpress_self_hosted_settings') ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add New Site'); ?>
        </a>
    </div>
</div>

</div>
<div class="section-body">
    <div class="row">
        <div class="col-12">

            <?php if ($this->session->userdata('edit_wssh_success')): ?>
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body text-center">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <?php echo $this->session->userdata('edit_wssh_success'); ?>
                    </div>
                </div>
                <?php $this->session->unset_userdata('edit_wssh_success'); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p><?php echo $this->lang->line("Make sure the REST API is NOT disabled of your wordpress blog."); ?></p>
                    <a class="btn btn-primary"
                       href="<?php echo base_url('assets/wordpress-self-hosted/wp-self-hosted-poster.zip'); ?>"><i
                                class="bx bx-save"></i> <?php echo $this->lang->line('Download API Plugin'); ?></a>
                </div>
                <div class="card-body data-card">
                    <div class="table-responsive">
                        <table id="wssh-datatable" class="table table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line('Domain Name'); ?></th>
                                <th><?php echo $this->lang->line('User Key'); ?></th>
                                <th><?php echo $this->lang->line('Authentication Key'); ?></th>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <th><?php echo $this->lang->line('Actions'); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


