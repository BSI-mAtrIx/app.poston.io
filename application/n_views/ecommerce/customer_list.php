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
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
?>

<style>
    div.tooltip {
        top: 0px !important;
    }
</style>

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
                <div class="card-body data-card p-0">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <?php

                            echo
                                '<div class="input-group mb-3" id="searchbox">
                  <input type="text" class="form-control" autofocus id="search_value"  name="search_value" placeholder="' . $this->lang->line("Search...") . '" style="max-width:30%;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_subscriber"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
                  </div>
                </div>'; ?>
                        </div>

                        <div class="col-12 col-md-2">
                            <a class="btn btn-outline-primary float-right mr-1"
                               href="<?php echo base_url('ecommerce/download_result'); ?>"><i
                                        class="bx bx-cloud-download"></i> <?php echo $this->lang->line("Download"); ?>
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("Avatar"); ?></th>
                                <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                                <th><?php echo $this->lang->line("First Name"); ?></th>
                                <th><?php echo $this->lang->line("Last Name"); ?></th>
                                <th><?php echo $this->lang->line("Email"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Subscribed at"); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="change_password" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-key"></i> <?php echo $this->lang->line("Change Password"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" method="POST">
                    <div id="wait"></div>
                    <input id="user_id" value="" class="form-control" type="hidden">
                    <div class="form-group">
                        <label for="password"><?php echo $this->lang->line("Email"); ?> * </label>
                        <input id="user_email" value="" class="form-control" type="email">
                    </div>
                    <div class="form-group">
                        <label for="password"><?php echo $this->lang->line("New Password"); ?> * </label>
                        <input id="password" class="form-control password" type="password">
                        <div class="invalid-feedback"><?php echo $this->lang->line("You have to type new password twice"); ?></div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password"><?php echo $this->lang->line("Confirm New Password"); ?>
                            * </label>
                        <input id="confirm_password" class="form-control password" type="password">
                        <div class="invalid-feedback"><?php echo $this->lang->line("Passwords does not match"); ?></div>
                    </div>
                </form>
            </div>


            <div class="modal-footer bg-whitesmoke br">
                <button type="button" id="save_change_password_button" class="btn btn-primary"><i
                            class="bx bxs-save"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>

        </div>
    </div>
</div>