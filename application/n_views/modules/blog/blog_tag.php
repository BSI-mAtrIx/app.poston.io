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
                                href="<?php echo site_url() . 'blog/posts'; ?>"><?php echo $this->lang->line("Blog Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary mb-1" data-toggle="modal" data-target="#add_tag_modal">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Tag"); ?>
        </a>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Name"); ?></th>
                                <th><?php echo $this->lang->line("Created At"); ?></th>
                                <th><?php echo $this->lang->line("Updated At"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
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


<div class="modal fade" tabindex="-1" role="dialog" id="add_tag_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add New Tag"); ?> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form class="form-horizontal" name="tag_store" action="<?php echo site_url() . 'blog/tag_store'; ?>"
                  method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name"><?php echo $this->lang->line("Tag Name"); ?> * </label>
                        <input type="text" id="name" class="form-control name" name="name" value="">
                        <div class="invalid-feedback name_error"></div>
                    </div>
                </div>

                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" id="save_tag" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i>
                        <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="update_tag_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-edit"></i> <?php echo $this->lang->line("Update Tag"); ?> </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form class="form-horizontal" name="tag_update" action="<?php echo site_url() . 'blog/tag_update'; ?>"
                  method="POST">
                <input type="hidden" name="tag_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name"><?php echo $this->lang->line("Tag Name"); ?> * </label>
                        <input type="text" id="tag_name" class="form-control name" name="name">
                        <div class="invalid-feedback name_error"></div>
                    </div>
                </div>

                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" id="update_tag" class="btn btn-primary"><i
                                class="bx bxs-save"></i> <?php echo $this->lang->line("Update"); ?></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i>
                        <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                </div>
            </form>
        </div>
    </div>
</div>