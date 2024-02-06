<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 1;
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
    .add_template, .ref_template {
        font-size: 10px;
        margin-top: 5px
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
                                href="<?php echo base_url("messenger_bot"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot/webview_builder_manager"); ?>"><?php echo $this->lang->line("Webview manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="section-body">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo $this->lang->line("Form Name"); ?></label>&nbsp;<a href="#"
                                                                                             data-toggle="tooltip"
                                                                                             title=""
                                                                                             data-original-title="<?php echo $this->lang->line('This is actually for identifying form name in our system') ?>"><i
                                    class="bx bx-info-circle"></i></a>
                        <input id="form-name" type="text" name="form-name" class="form-control"
                               value="<?= set_value('form-name', $form_name, true) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('Form Title'); ?></label>&nbsp;<a href="#"
                                                                                              data-toggle="tooltip"
                                                                                              title=""
                                                                                              data-original-title="<?php echo $this->lang->line('The form title that will be shown on top of your form') ?>"><i
                                    class="bx bx-info-circle"></i></a>
                        <input id="form-title" type="text" name="form-title" class="form-control"
                               value="<?= set_value('form-title', $form_title, true) ?>">
                    </div>
                </div>
                <div class="col-md-6" id="page_section">
                    <div class="form-group">
                        <label><?php echo $this->lang->line("Select Page"); ?></label>
                        <select name="select-page" id="select-page" class="form-control">
                            <option value=""></option>
                            <?php foreach ($pages as $page): ?>
                                <option value="<?= $page['id'] ?>" <?= ($page['id'] == $page_id) ? 'selected' : '' ?>><?= $page['page_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="assign-label-wrapper" class="form-group">
                        <label class="d-block"><?php echo $this->lang->line("Assign Label"); ?>
                            <a class="blue float-right pointer" page_id_for_label="<?php echo $page_id; ?>"
                               id="create_label_webview"><i
                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Label"); ?>
                            </a>
                        </label>
                        <div id="select-assign-label">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="reply-template-wrapper" class="form-group">
                        <label><?php echo $this->lang->line("Reply Template"); ?></label>
                        <div id="select-reply-template"></div>
                        <a href="" class="add_template float-left" page_id_add_postback="<?php echo $page_id; ?>"><i
                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Template"); ?></a>
                        <a href="" class="ref_template float-right"
                           page_id_refresh_postback="<?php echo $page_id; ?>"><i
                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?></a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="webview-builder"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- postback template add modal -->
<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-sync"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("Close & Refresh List"); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>

