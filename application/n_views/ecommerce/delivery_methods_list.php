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

<div class="section-header">
    <div class="section-header-button">
        <a class="btn btn-primary" href="#" id="add_new_row"><i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Delivery Method'); ?></a>
        <?php

        if(file_exists(APPPATH.'/modules/n_mashkar/controllers/N_mashkar.php')){
            echo '<a class="btn btn-primary" href="'.base_url('n_mashkar/integration/'.$this->session->userdata("ecommerce_selected_store")).'"><i class="bx bx-plus-circle"></i> '.$this->lang->line('Mashkor Integration').'</a>';
        } ?>

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


<?php $drop_menu = ''; ?>


<div class="modal fade" id="add_row_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Delivery Method") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
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
                                <div class="col-12 d-none">
                                    <div class="form-group">
                                        <label for="name"> <?php echo $this->lang->line("Store") ?> *</label>
                                        <?php echo form_dropdown('', $store_list, $this->session->userdata("ecommerce_selected_store"), 'style="width:100%" disabled class="select2 form-control"'); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="delivery_name"><?php echo $this->lang->line('Delivery Name'); ?> *</label>
                                        <input type="text" class="form-control" name="delivery_name" id="delivery_name">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="default_price"><?php echo $this->lang->line('Default price'); ?> *</label>
                                        <input type="text" class="form-control" name="default_price" id="default_price">
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="enable" id="enable" value="1"
                                                   class="custom-control-input" <?php echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="enable"></label>
                                            <span><?php echo $this->lang->line('Active'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="cod" id="cod" value="1"
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1" for="cod"></label>
                                            <span><?php echo $this->lang->line('Cash on Delivery'); ?></span>
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <?php
                            if(file_exists(APPPATH.'/modules/n_mashkar/controllers/N_mashkar.php')){ ?>
                                <h4><?php echo $this->lang->line('Mashkor Delivery');?></h4>
                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <?php
                                            $mashkor_cod_cash = '';
                                            ?>
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="mashkor_cod_cash" id="mashkor_cod_cash"
                                                       value="on"
                                                       class="custom-control-input" <?php if ($mashkor_cod_cash == 'on') echo 'checked'; ?>>
                                                <label class="custom-control-label mr-1" for="mashkor_cod_cash"></label>
                                                <span><?php echo $this->lang->line('Mashkor COD Cash'); ?></span>
                                                <span class="text-danger"><?php echo form_error('mashkor_cod_cash'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <?php
                                            $mashkor_cod_card = '';
                                            ?>
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="mashkor_cod_card" id="mashkor_cod_card"
                                                       value="on"
                                                       class="custom-control-input" <?php if ($mashkor_cod_card == 'on') echo 'checked'; ?>>
                                                <label class="custom-control-label mr-1" for="mashkor_cod_card"></label>
                                                <span><?php echo $this->lang->line('Mashkor COD CARD'); ?></span>
                                                <span class="text-danger"><?php echo form_error('mashkor_cod_card'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <?php
                                            $mashkor_online = '';
                                            ?>
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="mashkor_online" id="mashkor_online"
                                                       value="on"
                                                       class="custom-control-input" <?php if ($mashkor_online == 'on') echo 'checked'; ?>>
                                                <label class="custom-control-label mr-1" for="mashkor_online"></label>
                                                <span><?php echo $this->lang->line('Mashkor Online payment'); ?></span>
                                                <span class="text-danger"><?php echo form_error('mashkor_online'); ?></span>
                                            </label>
                                        </div>
                                    </div>


                                </div>
                            <?php }?>

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
                    <i class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Delivery Method") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="update_row_modal_body">
                    <form action="#" enctype="multipart/form-data" id="row_update_form" method="post">
                        <div class="row">
                    <input type="hidden" name="edit_table_id" id="edit_table_id">

                    <div class="col-12 d-none">
                        <div class="form-group">
                            <label for="store_list"> <?php echo $this->lang->line("Store") ?> *</label>
                            <?php echo form_dropdown('', $store_list, $this->session->userdata("ecommerce_selected_store"), 'style="width:100%" disabled class="select2 form-control"'); ?>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="edit_delivery_name"><?php echo $this->lang->line('Delivery Name'); ?> *</label>
                            <input type="text" class="form-control" name="edit_delivery_name" id="edit_delivery_name">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="edit_default_price"><?php echo $this->lang->line('Default price'); ?> *</label>
                            <input type="text" class="form-control" name="edit_default_price" id="edit_default_price">
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="edit_enable" id="edit_enable" value="1"
                                       class="custom-control-input">
                                <label class="custom-control-label mr-1" for="edit_enable"></label>
                                <span><?php echo $this->lang->line('Active'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="custom-switch mt-2">
                                <input type="checkbox" name="edit_cod" id="edit_cod" value="1"
                                       class="custom-control-input">
                                <label class="custom-control-label mr-1" for="edit_cod"></label>
                                <span><?php echo $this->lang->line('Cash on Delivery'); ?></span>
                            </label>
                        </div>
                    </div>
                        </div>

                        <?php
                        if(file_exists(APPPATH.'/modules/n_mashkar/controllers/N_mashkar.php')){ ?>
                            <h4><?php echo $this->lang->line('Mashkor Delivery');?></h4>
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <?php
                                        $mashkor_cod_cash = '';
                                        ?>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="mashkor_cod_cash" id="update_mashkor_cod_cash"
                                                   value="on"
                                                   class="custom-control-input" <?php if ($mashkor_cod_cash == 'on') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="update_mashkor_cod_cash"></label>
                                            <span><?php echo $this->lang->line('Mashkor COD Cash'); ?></span>
                                            <span class="text-danger"><?php echo form_error('mashkor_cod_cash'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <?php
                                        $mashkor_cod_card = '';
                                        ?>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="mashkor_cod_card" id="update_mashkor_cod_card"
                                                   value="on"
                                                   class="custom-control-input" <?php if ($mashkor_cod_card == 'on') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="update_mashkor_cod_card"></label>
                                            <span><?php echo $this->lang->line('Mashkor COD CARD'); ?></span>
                                            <span class="text-danger"><?php echo form_error('mashkor_cod_card'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <?php
                                        $mashkor_online = '';
                                        ?>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="mashkor_online" id="update_mashkor_online"
                                                   value="on"
                                                   class="custom-control-input" <?php if ($mashkor_online == 'on') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="update_mashkor_online"></label>
                                            <span><?php echo $this->lang->line('Mashkor Online payment'); ?></span>
                                            <span class="text-danger"><?php echo form_error('mashkor_online'); ?></span>
                                        </label>
                                    </div>
                                </div>


                            </div>
                        <?php }?>



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




