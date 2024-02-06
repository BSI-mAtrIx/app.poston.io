<?php
$include_upload = 1;  //upload_js
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


<?php
include("application/n_views/sms_email_manager/email/email_section_css.php");
?>
<style>.note-editable {
        max-height: 450px !important;
    }</style>
<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot_broadcast"); ?>"><?php echo $this->lang->line("SMS/Email Broadcasting"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("sms_email_manager/email_campaign_lists"); ?>"><?php echo $this->lang->line("Email Campaigns"); ?></a>
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
            <div class="card">

                <div class="card-body">
                    <form action="#" id="edit_message_form" method="POST">
                        <input type="hidden" id="table_id" name="table_id"
                               value="<?php echo $message_data[0]['id']; ?>">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Message'); ?>
                                <a href="#" data-placement="top" data-toggle="popover"
                                   title="<?php echo $this->lang->line("include lead user first name"); ?>"
                                   data-content="<?php echo $this->lang->line("You can include Contacts #FIRST_NAME#, #LAST_NAME#, #UNSUBSCRIBE_LINK# as variable inside your message. The variable will be replaced by corresponding real values when we will send it."); ?>"><i
                                            class='bx bx-info-circle'></i> </a>
                            </label>
                            <textarea id="message" name="message" class="form-control"
                                      placeholder="<?php echo $this->lang->line("type your message here...") ?>"><?php echo $message_data[0]['email_message']; ?></textarea>
                        </div>
                    </form>
                </div>

                <div class="card-footer brTop">
                    <button class="btn btn-primary" id="updateMessage" name="updateMessage" type="button"><i
                                class="bx bx-edit"></i> <?php echo $this->lang->line("Update Message") ?> </button>

                    <a class="btn btn-light float-right" onclick='goBack("sms_email_manager/email_campaign_lists",0)'><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>
