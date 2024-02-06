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
                                <th><?php echo $this->lang->line("Serial"); ?></th>
                                <th><?php echo $this->lang->line("Thumbnail"); ?></th>
                                <th><?php echo $this->lang->line("Category"); ?></th>
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


<?php $drop_menu = '<a class="btn btn-primary float-right ml-1" href="#" id="add_new_row"><i class="bx bx-plus-circle"></i> ' . $this->lang->line('Add') . '</a> <a class="btn btn-outline-primary float-right" href=""  data-toggle="modal" data-target="#sort_modal"><i class="bx bx-sort"></i> ' . $this->lang->line('Sort') . '</a> '; ?>


<div class="modal fade" id="add_row_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content ">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Category") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
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
                                        <label><?php echo $this->lang->line('Category Name'); ?> *</label>
                                        <input type="text" class="form-control" name="category_name" id="category_name">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Thumbnail'); ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("Thumbnail"); ?>"
                                               data-content="<?php echo $this->lang->line("Maximum: 500KB, Format: JPG/PNG, Preference: Square image, Recommended dimension : 100x100"); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <div id="thumb-dropzone" class="dropzone mb-1">
                                            <div class="dz-default dz-message">
                                                <input class="form-control" name="thumbnail" id="uploaded-file"
                                                       type="hidden">
                                                <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                                  style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                            </div>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('thumbnail'); ?></span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Category Description'); ?> *</label>
                                        <textarea class="form-control" name="desc" id="desc"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
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
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Category") . " : " . $this->session->userdata("ecommerce_selected_store_title"); ?>
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

<div class="modal fade" id="sort_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-sort"></i> <?php echo $this->lang->line("Sort Category"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="sortable_main_div">
                    <?php
                    foreach ($all_categories as $key => $value) {
                        echo '
                     <li data-id=' . $value["id"] . ' class="list-group-item d-flex justify-content-between align-items-center mt-1 mb-1 no_radius text-dark" style="border:1px dashed #777">
                        ' . $value['category_name'] . '
                     </li>';
                    }
                    ?>
                </ul>

            </div>
            <div class="modal-footer bg-whitesmoke">
                <div class="col-12 p-0">
                    <button class="btn btn-primary" id="sort_cat" name="sort_cat" type="button"><i
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




