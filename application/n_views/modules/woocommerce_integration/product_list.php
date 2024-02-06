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
    #main_iframe #export_modal > div .modal-content {
        background: #ffffff !important;
    }
</style>
<style type="text/css">
    div.tooltip{top:0px!important;}
</style>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body data-card p-0 pt-1 pr-3">
                    <div class="row">
                        <div class="col-7 col-md-9">
                            <?php echo
                                '<div class="input-group mb-3" id="searchbox">
                  <div class="input-group-prepend d-none">
                  <input type="hidden" class="form-control" id="search_store_id" autofocus name="search_store_id" value="' . $config_id . '">
                  </div>
                  <input type="text" class="form-control" id="search_value" autofocus name="search_value" placeholder="' . $this->lang->line("Search...") . '" style="max-width:400px;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_action"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
                  </div>
                </div>'; ?>
                        </div>

                        <div class="col-12">
                            <a href="" id="export_to_ecommerce" class="btn btn-primary float-right"><i
                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Export to Ecommerce"); ?>
                            </a>
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
                                <th><?php echo $this->lang->line("Thumb") ?></th>
                                <th><?php echo $this->lang->line("Product") ?></th>
                                <th><?php echo $this->lang->line("Price") ?></th>
                                <th><?php echo $this->lang->line("Actions") ?></th>
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


<div class="modal fade" role="dialog" id="export_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-export"></i> <?php echo $this->lang->line("Export to Ecommerce"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bx bx-time"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if (empty($store_data)) echo "<div class='alert alert-danger text-center'>" . $this->lang->line("No ecommerce store found.") . "</div>";
                else {
                    $store_list[''] = $this->lang->line("Select Ecommerce Store");
                    foreach ($store_data as $key => $value) {
                        $store_list[$value['id']] = $value['store_name'];
                    }
                    echo form_dropdown('store_id', $store_list, '', "class='form-control select2' id='store_id' style='width:100%'");
                    echo "<br><br><a href='' id='export_now' class='btn btn-primary' style='width:200px;'><i class='bx bx-export'></i> " . $this->lang->line("Export") . "</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    ins {
        text-decoration: none;
    }
</style>
