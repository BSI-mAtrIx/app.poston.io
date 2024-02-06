<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 1;
$include_mCustomScrollBar = 0;
$include_dropzone = 1;
$include_cropper = 1;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$jodit = 1;
?>

<style>
    div.tooltip {
        top: 0px !important;
    }
    .disabled{
        pointer-events:none;
        background:grey;
    }
</style>


<div class="section-header d-none">
    <h1><i class="bx bx-columns"></i> <?php echo $page_title; ?></h1>
    <div class="section-header-button">
        <a class="btn btn-primary" href="#" id="add_new_row"><i
                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Category'); ?></a>
    </div>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a
                    href="<?php echo base_url('messenger_bot'); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
        </div>
        <div class="breadcrumb-item"><a
                    href="<?php echo base_url('ecommerce'); ?>"><?php echo $this->lang->line("E-commerce"); ?></a></div>
        <div class="breadcrumb-item"><?php echo $this->lang->line("Category"); ?></div>
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
                                <th><?php echo $this->lang->line("Name"); ?></th>
                                <th><?php echo $this->lang->line("Active"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<?php $drop_menu = '<a class="btn btn-primary float-right ml-1" href="#" id="add_new_row"><i class="bx bx-plus-circle"></i> ' . $this->lang->line('Add') . '</a>'; ?>


<div class="modal fade" id="add_row_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Shipping Zone") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
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

                            <input type="hidden" class="form-control" name="country_list_ids" id="country_list_ids">
                            <input type="hidden" class="form-control" name="states_list_ids" id="states_list_ids">

                            <div class="row">
                                <div class="col-12 d-none">
                                    <div class="form-group">
                                        <label for="name"> <?php echo $this->lang->line("Store") ?> *</label>
                                        <?php echo form_dropdown('', $store_list, $this->session->userdata("ecommerce_selected_store"), 'style="width:100%" disabled class="select2 form-control"'); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="zone_name"><?php echo $this->lang->line('Zone Name'); ?> *</label>
                                        <input type="text" class="form-control" name="zone_name" id="zone_name">
                                    </div>
                                </div>



                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="active" id="active" value="1"
                                                   class="custom-control-input" <?php echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="active"></label>
                                            <span><?php echo $this->lang->line('Active'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="allow_order" id="allow_order" value="1"
                                                   class="custom-control-input" <?php echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="allow_order"></label>
                                            <span><?php echo $this->lang->line('Allow Order'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="required_state" id="required_state" value="1"
                                                   class="custom-control-input" >
                                            <label class="custom-control-label mr-1" for="required_state"></label>
                                            <span><?php echo $this->lang->line('State is required'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="country_list"> <?php echo $this->lang->line("Countries") ?> *</label>
                                        <?php echo form_dropdown('country_list', $country_list, '', 'style="width:100%" class="form-control country_list"'); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="states_list"> <?php echo $this->lang->line("States") ?></label>
                                        <?php echo form_dropdown('states_list', '' , '', 'style="width:100%" class="form-control states_list"'); ?>
                                    </div>
                                </div>

                                <?php
                                    foreach($delivery_list as $key => $val){

                                ?>
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="payment[<?php echo $val['id'];?>][price]"><?php echo $this->lang->line('Delivery name'); ?> *</label>
                                            <input type="text" class="form-control" readonly="readonly" name="payment[<?php echo $val['id'];?>][name]" id="payment[<?php echo $val['id'];?>][name]" value="<?php echo $val['name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="payment[<?php echo $val['id'];?>][price]"><?php echo $this->lang->line('Delivery price'); ?> *</label>
                                            <input type="text" class="form-control" name="payment[<?php echo $val['id'];?>][price]" id="payment[<?php echo $val['id'];?>][price]" value="<?php echo $val['default_price'];?>">
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="payment[<?php echo $val['id'];?>][active]" id="payment[<?php echo $val['id'];?>][active]" value="1"
                                                       class="custom-control-input">
                                                <label class="custom-control-label mr-1" for="payment[<?php echo $val['id'];?>][active]"></label>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <?php
                                    }
                                ?>



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
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Shipping Zone") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="update_row_modal_body">
                    <form action="#" enctype="multipart/form-data" id="row_update_form" method="post">
                        <input type="hidden" id="edit_store_id" name="edit_store_id"
                               value="<?php echo $this->session->userdata("ecommerce_selected_store"); ?>">

                        <input type="hidden" class="form-control" name="edit_worldwide" id="edit_worldwide">
                        <input type="hidden" class="form-control" name="edit_table_id" id="edit_table_id">
                        <input type="hidden" class="form-control" name="edit_country_list_ids" id="edit_country_list_ids">
                        <input type="hidden" class="form-control" name="edit_states_list_ids" id="edit_states_list_ids">

                        <div class="row">
                            <div class="col-12 d-none">
                                <div class="form-group">
                                    <label for="name"> <?php echo $this->lang->line("Store") ?> *</label>
                                    <?php echo form_dropdown('', $store_list, $this->session->userdata("ecommerce_selected_store"), 'style="width:100%" disabled class="select2 form-control"'); ?>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_zone_name"><?php echo $this->lang->line('Zone Name'); ?> *</label>
                                    <input type="text" class="form-control" name="edit_zone_name" id="edit_zone_name">
                                </div>
                            </div>



                            <div class="col-6">
                                <div class="form-group">
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="edit_active" id="edit_active" value="1"
                                               class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="edit_active"></label>
                                        <span><?php echo $this->lang->line('Active'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="edit_allow_order" id="edit_allow_order" value="1"
                                               class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="edit_allow_order"></label>
                                        <span><?php echo $this->lang->line('Allow Order'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="edit_required_state" id="edit_required_state" value="1"
                                               class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="edit_required_state"></label>
                                        <span><?php echo $this->lang->line('State is required'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_country_list"> <?php echo $this->lang->line("Countries") ?> *</label>
                                    <?php echo form_dropdown('edit_country_list', $country_list, '', 'style="width:100%" class="form-control edit_country_list"'); ?>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_states_list"> <?php echo $this->lang->line("States") ?></label>
                                    <select style="width:100%" class="form-control edit_states_list" id="edit_states_list" name="edit_states_list"></select>
                                </div>
                            </div>

                            <?php
                            foreach($delivery_list as $key => $val){

                                ?>
                                <div class="row edit_delivery_methods">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="edit_payment[<?php echo $val['id'];?>][price]"><?php echo $this->lang->line('Delivery name'); ?> *</label>
                                            <input type="text" class="form-control" readonly="readonly" name="edit_payment[<?php echo $val['id'];?>][name]" id="edit_payment[<?php echo $val['id'];?>][name]" value="<?php echo $val['name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="edit_payment_<?php echo $val['id'];?>_price"><?php echo $this->lang->line('Delivery price'); ?> *</label>
                                            <input type="text" class="form-control price_set_to_default" data-default-price="<?php echo $val['default_price'];?>" name="edit_payment[<?php echo $val['id'];?>][price]" id="edit_payment_<?php echo $val['id'];?>_price" value="<?php echo $val['default_price'];?>">
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="edit_payment[<?php echo $val['id'];?>][active]" id="edit_payment_<?php echo $val['id'];?>_active" value="1"
                                                       class="custom-control-input">
                                                <label class="custom-control-label mr-1 active_off" for="edit_payment_<?php echo $val['id'];?>_active"></label>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <?php
                            }
                            ?>






                        </div>
                    </form>
                </div>
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

    .dropzone {
        width: 100% !important;
    }
</style>




