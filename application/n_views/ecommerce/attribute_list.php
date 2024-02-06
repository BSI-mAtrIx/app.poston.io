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

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-body data-card p-0 pt-1 pr-3">

                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("Attribute"); ?></th>
                                <th><?php echo $this->lang->line("Values"); ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Store"); ?></th>
                                <th><?php echo $this->lang->line("Updated at"); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<?php $drop_menu = '<a class="btn btn-primary float-right" href="#" id="add_new_row"><i class="bx bx-plus-circle"></i> ' . $this->lang->line('Add') . '</a>'; ?>


<div class="modal fade" id="add_row_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Attribute") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form action="#" enctype="multipart/form-data" id="row_add_form" method="post">
                            <input type="hidden" id="store_id" name="store_id"
                                   value="<?php echo $this->session->userdata("ecommerce_selected_store"); ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name"> <?php echo $this->lang->line("Store") ?> *</label>
                                        <?php echo form_dropdown('', $store_list, $this->session->userdata("ecommerce_selected_store"), 'style="width:100%" disabled class="select2 form-control"'); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Attribute Name'); ?> *</label>
                                        <input type="text" class="form-control" name="attribute_name"
                                               id="attribute_name">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Attribute Values'); ?> *
                                            (<?php echo $this->lang->line('comma separated'); ?>)</label>
                                        <select id="attribute_values" name="attribute_values[]" multiple="true"
                                                style="width: 100%">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="multiselect" id="multiselect" value="1"
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1" for="multiselect"></label>
                                            <span>
                                        <?php echo $this->lang->line('Multi-select'); ?>
                                        <a href="#" class="d-inline" data-placement="top" data-toggle="popover"
                                           data-trigger="focus" title="<?php echo $this->lang->line("Multi-select") ?>"
                                           data-content='<?php echo $this->lang->line("If enabled, buyer can select multiple values for this attribute.") ?>'><i
                                                    class='bx bxs-help-circle'></i> </a>
                                      </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="optional" id="optional" value="1"
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1" for="optional"></label>
                                            <span>
                                        <?php echo $this->lang->line('Optional'); ?></span>
                                            <a href="#" class="d-inline" data-placement="top" data-toggle="popover"
                                               data-trigger="focus" title="<?php echo $this->lang->line("Optional") ?>"
                                               data-content='<?php echo $this->lang->line("If enabled, buyer can skip selecting this attribute.") ?>'><i
                                                        class='bx bxs-help-circle'></i> </a>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="status" id="status" value="1"
                                                   class="custom-control-input" <?php echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="status"></label>
                                            <span><?php echo $this->lang->line('Active'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <div class="col-12 p-0">
                    <button class="btn btn-primary" id="save_row" name="save_row" type="button"><i
                                class="bx bxs-save"></i> <?php echo $this->lang->line("Save") ?> </button>
                    <a class="btn btn-light float-right" data-dismiss="modal" aria-hidden="true"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update_row_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Attribute") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="update_row_modal_body"></div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <div class="col-12 p-0">
                    <button class="btn btn-primary" id="update_row" name="update_row" type="button"><i
                                class="bx bxs-save"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <a class="btn btn-light float-right" data-dismiss="modal" aria-hidden="true"><i
                                class="bx bx-time"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></a></button>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    .select2-search__field {
        width: 100% !important;
    }

    div.tooltip {
        top: 0px !important;
    }
</style>