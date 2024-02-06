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

<style type="text/css">
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

<!--  <style type="text/css">
   #search_store_id{width: 145px;}
   @media (max-width: 575.98px) {
     #search_store_id{width: 90px;}
   }
 </style> -->

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card p-0 pt-1 pr-3">
                    <div class="row">
                        <div class="col-7 col-sm-9 col-md-9">
                            <?php echo
                                '<div class="input-group mb-3" id="searchbox">
                  <div class="input-group-prepend d-none">
                    ' . form_dropdown('search_store_id', $store_list, $this->session->userdata("ecommerce_selected_store"), 'class="select2 form-control" id="search_store_id"') . '
                  </div>
                  <input type="text" class="form-control" id="search_value" autofocus name="search_value" placeholder="' . $this->lang->line("Search...") . '" style="max-width:400px;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_action"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
                  </div>
                </div>'; ?>
                        </div>
                        <div class="d-none d-sm-block col-sm-3 col-md-3">
                            <?php
                            echo $drop_menu = '<a href="javascript:;" id="search_date_range" class="btn btn-outline-primary float-right icon-left btn-icon d-inline"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="search_date_range_val">';
                            ?>
                        </div>
                        <div class="col-5 col-sm-12">
                            <a href="<?php echo base_url('ecommerce/add_coupon'); ?>"
                               class="btn float-right btn-primary"><i
                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?></a>
                            <?php
                            ?>
                        </div>
                    </div>

                    <div class="table-responsive2">
                        <input type="hidden" id="put_page_id">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("Coupon") ?></th>
                                <th><?php echo $this->lang->line("Amount") ?></th>
                                <th><?php echo $this->lang->line("Type") ?></th>
                                <th><?php echo $this->lang->line("Expiry Date") ?></th>
                                <th><?php echo $this->lang->line("Status") ?></th>
                                <th><?php echo $this->lang->line("Actions") ?></th>
                                <th><?php echo $this->lang->line("Store") ?></th>
                                <th><?php echo $this->lang->line("Free Shipping") ?></th>
                                <th><?php echo $this->lang->line("Used") ?></th>
                                <th><?php echo $this->lang->line("Updated at") ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



