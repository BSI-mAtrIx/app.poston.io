<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$jodit = 1;
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("menu_manager/get_page_lists"); ?>"><?php echo $this->lang->line("Page Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="#" id="update_custom_page" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="page_table_id" id="page_table_id" value="<?php echo $page_data[0]['id']; ?>">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Page Name'); ?></label>
                                    <input type="text" class="form-control" id="page_name" name="page_name"
                                           value="<?php echo $page_data[0]['page_name']; ?>">
                                    <div class="invalid-feedback"><?php echo $this->lang->line("Page Name is Required"); ?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Page Description'); ?></label>
                                    <textarea type="text" class="form-control" id="page_description"
                                              name="page_description"
                                              placeholder="<?php echo $this->lang->line("Type your page description here..."); ?>"><?php echo $page_data[0]['page_description']; ?></textarea>
                                    <div class="invalid-feedback"><?php echo $this->lang->line("Page Description is required"); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <button type="button" class="btn btn-primary" id="update_page"><i
                                    class="bx bx-edit"></i> <?php echo $this->lang->line("Update Page") ?></button>
                        <a class="btn btn-light float-right" onclick='goBack("menu_manager/get_page_lists",0)'><i
                                    class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<style>
    .note-toolbar {
        background: #eee !important;
    }

    .note-editable {
        min-height: 250px;
        max-height: 800px !important;
    }

    .note-placeholder {
        color: #cacaca;
    }

    .note-btn {
        padding: 2px 10px !important
    }
</style>