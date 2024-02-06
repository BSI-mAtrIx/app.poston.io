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

<style type="text/css">
    @media (max-width: 575.98px) {
        #search_store_id {
            width: 75px;
        }

        #search_status {
            width: 80px;
        }

        #select2-search_store_id-container, #select2-search_status-container, #search_value {
            padding-left: 8px;
            padding-right: 5px;
        }
    }

    div.tooltip {
        top: 0px !important;
    }
</style>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body data-card p-0 pr-3">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <?php

                            $status_list[''] = $this->lang->line("Status");
                            echo
                                '<div class="input-group mb-3" id="searchbox">
                  <div class="input-group-prepend d-none">
                    ' . form_dropdown('search_store_id', $store_list, $this->session->userdata("ecommerce_selected_store"), 'class="form-control select2" id="search_store_id"') . '
                  </div>
                  <div class="input-group-prepend">
                    ' . form_dropdown('search_status', $status_list, '', 'class="form-control select2" id="search_status"') . '
                  </div>
                  <input type="text" class="form-control" id="search_value" autofocus name="search_value" placeholder="' . $this->lang->line("Search...") . '" style="max-width:300px;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_action"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
                  </div>
                </div>'; ?>
                        </div>

                        <div class="col-12 col-md-4 d-none d-sm-block">
                            <?php
                            echo $drop_menu = '<a href="javascript:;" id="search_date_range" class="btn btn-outline-primary float-right icon-left btn-icon"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="search_date_range_val">';
                            ?>
                        </div>
                        <div class="col-12 text-left">
                            <?php
                            echo '<a href="' . base_url("ecommerce/download_csv") . '" target="_BLANK" class="btn btn-outline-primary float-right"><i class="bx bx-file-blank"></i> ' . $this->lang->line("Download") . '</a>';

                            if(file_exists(APPPATH.'modules/n_printnode/controllers/N_printnode.php')){
                                echo '<a href="#" id="printnode_settings_open_modal" class="btn btn-outline-primary float-right">'.$this->lang->line("PrintNode Settings") .'</a>';
                            }

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
                                <th><?php echo $this->lang->line("Subscriber ID") ?></th>
                                <th><?php echo $this->lang->line("Store") ?></th>
                                <th><?php echo $this->lang->line("Status") ?></th>
                                <th><?php echo $this->lang->line("Coupon") ?></th>
                                <th><?php echo $this->lang->line("Amount") ?></th>
                                <th><?php echo $this->lang->line("Currency") ?></th>
                                <th><?php echo $this->lang->line("Invoice") ?></th>
                                <th><?php echo $this->lang->line("Transaction ID") ?></th>
                                <th><?php echo $this->lang->line("Manual Payment") ?></th>
                                <th><?php echo $this->lang->line("Method") ?></th>
                                <th><?php echo $this->lang->line("Ordered at") ?></th>
                                <th><?php echo $this->lang->line("Paid at") ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="manual-payment-modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-receipt"></i> <?php echo $this->lang->line("Manual Payment Information"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="change_payment_status_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $this->lang->line("Update Order Status"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <label><?php echo $this->lang->line("Additional Note"); ?> (<?php echo $this->lang->line("Optional"); ?>
                    )</label>
                <input type="hidden" id="status_changed_cart_id">
                <input type="hidden" id="status_changed_status">
                <textarea id="status_changed_note" class="form-control" style="min-height: 200px"></textarea>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" id="change_payment_status_submit"><i
                            class="bx bx-paper-plane"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>
