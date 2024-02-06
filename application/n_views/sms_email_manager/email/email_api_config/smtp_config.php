<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>

<style>.bbw {
        border-bottom-width: thin !important;
        border-bottom: solid .5px #f9f9f9 !important;
        padding-bottom: 20px;
    }

    .note-btn {
        padding: 0 10px !important
    }

    .note-editable {
        min-height: 200px !important
    }

    div.tooltip {
        top: 0px !important;
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
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('integration'); ?>"><?php echo $this->lang->line("Integration"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary mb-1 new_smtp">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New SMTP API"); ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Email"); ?></th>
                                <th><?php echo $this->lang->line("SMTP Host"); ?></th>
                                <th><?php echo $this->lang->line("SMTP Username"); ?></th>
                                <th><?php echo $this->lang->line("SMTP Password"); ?></th>
                                <th><?php echo $this->lang->line("SMTP Port"); ?></th>
                                <th><?php echo $this->lang->line("SMTP Type"); ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
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


<div class="modal fade" id="new_smtp_api_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title blue"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('New SMTP API'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form action="#" method="POST" id="add_new_smtp">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Email Address'); ?></label>
                                        <input type="text" class="form-control" id="smtp_email" name="smtp_email">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('SMTP Host'); ?></label>
                                        <input type="text" class="form-control" id="smtp_host" name="smtp_host">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('SMTP Port'); ?></label>
                                        <input type="text" class="form-control" id="smtp_port" name="smtp_port">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('SMTP Username'); ?></label>
                                        <input type="text" class="form-control" id="smtp_username" name="smtp_username">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('SMTP Password'); ?></label>
                                        <input type="text" class="form-control" id="smtp_password" name="smtp_password">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('SMTP Type'); ?></label>
                                        <select class="select2 form-control" id="smtp_type" name="smtp_type"
                                                style="width:100%;">
                                            <option value=""><?php echo $this->lang->line('Select SMTP Type'); ?></option>
                                            <option value="Default"><?php echo $this->lang->line('Default'); ?></option>
                                            <option value="tls"><?php echo $this->lang->line('tls'); ?></option>
                                            <option value="ssl"><?php echo $this->lang->line('ssl'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Status'); ?></label><br>
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="checkbox" name="smtp_status" value="1" id="smtp_status"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label mr-1" for="smtp_status"></label>
                                            <span><?php echo $this->lang->line('Active'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Sender Name'); ?></label>
                                        <input type="text" class="form-control" id="sender_name" name="sender_name">
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-primary" id="save_smtp"><i class="bx bxs-save"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="update_smtp_api_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title blue"><i
                            class="bx bx-edit"></i> <?php echo $this->lang->line('Update SMTP API'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="update_form_body">

                </div>
            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-primary" id="update_smtp"><i
                            class="bx bx-edit"></i> <?php echo $this->lang->line('Update'); ?></button>
                <button type="button" class="btn btn-light float-right" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_send_test_email" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bbw">
                <h3 class="modal-title blue"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Send Test Email"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>

            <div id="modalBody" class="modal-body">
                <div id="show_message" class="text-center mb-4"></div>
                <input type="hidden" value="" id="table_id" name="table_id">
                <input type="hidden" value="smtp" id="service_type" name="service_type">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="subject"><i
                                        class="bx bx-at"></i> <?php echo $this->lang->line("Recipient Email"); ?>
                            </label>
                            <input type="text" id="recipient_email" class="form-control"/>
                            <div class="invalid-feedback"><?php echo $this->lang->line("Email is required"); ?></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="subject"><i class="bx bx-bulb"></i> <?php echo $this->lang->line("Subject"); ?>
                            </label>
                            <input type="text" id="test_subject" class="form-control"/>
                            <div class="invalid-feedback"><?php echo $this->lang->line("Subject is required"); ?></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="bx bx-envelope"></i> <?php echo $this->lang->line("Message"); ?></label>
                            <textarea name="test_message" style="height:250px !important;"
                                      class="summernote form-control" id="test_message"></textarea>
                            <div class="invalid-feedback"><?php echo $this->lang->line("Message is required"); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke">
                <button id="send_test_email" class="btn btn-primary"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Send"); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>