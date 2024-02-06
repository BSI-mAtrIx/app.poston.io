<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
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
$include_prism = 0;
?>

<style>
    .select2-container--disabled .select2-selection__rendered {
    }

    .select2-container--disabled .select2-selection--single {
        background: #eee !important;
        border: red !important;
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
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-0">
                                <select class="select2 form-control" id="search_request_status"
                                        name="search_request_status" style="width:30%;">
                                    </style>>
                                    <option value=""><?php echo $this->lang->line("Status"); ?></option>
                                    <option value="0"><?php echo $this->lang->line("Pending"); ?></option>
                                    <option value="1"><?php echo $this->lang->line("Approved"); ?></option>
                                    <option value="2"><?php echo $this->lang->line("Cancel"); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="javascript:;" id="request_date_range"
                               class="btn btn-primary icon-left btn-icon float-right"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="request_date_range_val">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 data-card">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable_affiliate_request_lists">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("ID"); ?></th>
                                        <th><?php echo $this->lang->line("email"); ?></th>
                                        <th><?php echo $this->lang->line("Method"); ?></th>
                                        <th><?php echo $this->lang->line("Earned") . ' ' . $curency_icon; ?></th>
                                        <th><?php echo $this->lang->line("Requested") . ' ' . $curency_icon; ?></th>
                                        <th><?php echo $this->lang->line("Status"); ?></th>
                                        <th><?php echo $this->lang->line("Issued"); ?></th>
                                        <th><?php echo $this->lang->line("Approved"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="method_details_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-dots-horizontal-rounded"></i> <?php echo $this->lang->line("Method Details"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body section">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-small"><?php echo $this->lang->line('Method Name'); ?></div>
                        <div class="section-lead" id="method_name"></div>

                        <div class="section-title text-small"><?php echo $this->lang->line('Method Details'); ?></div>
                        <div class="section-lead">
                            <div class="alert alert-light" id="method_details"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>