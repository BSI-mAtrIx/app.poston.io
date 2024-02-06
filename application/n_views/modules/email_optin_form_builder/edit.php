<?php
$include_upload = 1;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
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
    .form-wrap.form-builder .frmb .checkbox-group-field .field-label,
    .form-wrap.form-builder .frmb .checkbox-group-field .field-actions .copy-button,
    .form-wrap.form-builder .frmb .field-options .option-actions a.add,
    .text-field .form-group.name-wrap,
    .checkbox-group-field .form-group.name-wrap,
    .text-field .form-group.subtype-wrap,
    .paragraph-field .form-group.subtype-wrap,
    .maxlength-wrap {
        display: none !important;
    }

    .clear-all, .save-template {
        padding: .55rem 1.5rem;
        font-size: 12px;
        width: 50%;
    }

    .form-wrap.form-builder .cb-wrap.pull-left .form-actions {
        width: 100%;
    }

    .form-wrap.form-builder .stage-wrap {
        padding: 0 15px;
        border: 1px dashed #ccc;
        background-color: rgba(255, 255, 255, 0.25);
    }

    .ajax-upload-dragdrop {
        border: dashed 1px #c1c1c1;
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
                                href="<?php echo base_url("email_optin_form_builder"); ?>"><?php echo $this->lang->line("Email Phone Opt-in Form Builder"); ?></a>
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
                        <label><?php echo $this->lang->line("Form Name"); ?></label> <span class="red">*</span><a
                                href="#" data-toggle="tooltip" title=""
                                data-original-title="<?php echo $this->lang->line('This is actually for identifying form name in our system') ?>"><i
                                    class="bx bx-info-circle"></i></a>
                        <input id="form-name" type="text" name="form-name" class="form-control"
                               value="<?= set_value('form-name', $form_name, true) ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo $this->lang->line("Contact Group"); ?> <span class="red">*</span>
                            <a href="#" data-placement="top" data-toggle="popover"
                               title="<?php echo $this->lang->line("include lead user first name"); ?>"
                               data-content="<?php echo $this->lang->line("Select Contact groups so that new subscribers through this form will be assigned at these groups."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <small class="blue float-right pointer" id="create_contact_group"><i
                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Create Group'); ?>
                        </small>
                        <select name="contact_group[]" id="contact_group" class="form-control select2" multiple="">
                            <?php foreach ($contact_group_lists as $key => $value) {
                                if (in_array($key, $contact_ids)) {
                                    echo '<option value="' . $key . '" selected>' . $value . '</option>';
                                } else {
                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <!-- Emai sequence needs to code with php. pending -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo $this->lang->line("Email Sequence"); ?>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("If you select email sequence, then your new subscribers will be assigned to this sequence campaign and system will send emails to those subscribers email address according this email sequence campaign settings."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <select name="sequence_email_campaign_id" id="sequence_email_campaign_id"
                                class="form-control select2">
                            <option value=""><?php echo $this->lang->line('Select Email Sequence'); ?></option>
                            <?php
                            foreach ($sequence_email_campaign_lists as $value2) {
                                if ($value2['id'] == $sequence_email_campaign_id) {
                                    echo '<option value="' . $value2['id'] . '" selected>' . $value2['campaign_name'] . ' [' . $value2['campaign_type'] . ']</option>';
                                } else {
                                    echo '<option value="' . $value2['id'] . '">' . $value2['campaign_name'] . ' [' . $value2['campaign_type'] . ']</option>';
                                }

                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Sms sequence needs to code with php. pending -->

                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo $this->lang->line("SMS Sequence"); ?>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("If you select SMS sequence, then your new subscribers will be assigned to this sequence campaign and system will send SMS to those subscribers phone number according this SMS sequence campaign settings."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <select name="sequence_sms_campaign_id" id="sequence_sms_campaign_id"
                                class="form-control select2">
                            <option value=""><?php echo $this->lang->line('Select SMS Sequence'); ?></option>
                            <?php foreach ($sequence_sms_campaign_lists as $value3) {
                                if ($value3['id'] == $sequence_sms_campaign_id) {
                                    echo '<option value="' . $value3['id'] . '" selected>' . $value3['campaign_name'] . ' [' . $value3['campaign_type'] . ']</option>';
                                } else {
                                    echo '<option value="' . $value3['id'] . '">' . $value3['campaign_name'] . ' [' . $value3['campaign_type'] . ']</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <!-- Position of EMail Optin Form  needs to code with php. pending -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label><?php echo $this->lang->line("Form Display Type"); ?> <span class="red">*</span>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("Form Display Type refers where do you want to make form visible in your website."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <select name="form_position" id="form_position" class="form-control select2">
                            <option value=""><?php echo $this->lang->line('Select Display Type'); ?></option>
                            <option value="popup" <?php if ($form_position == 'right' || $form_position == 'center') echo "selected"; ?>><?php echo $this->lang->line('Pop-up'); ?></option>
                            <option value="fixed" <?php if ($form_position == 'fixed') echo "selected"; ?>><?php echo $this->lang->line('Fixed'); ?></option>
                            <option value="direct" <?php if ($form_position == 'direct') echo "selected"; ?>><?php echo $this->lang->line('Direct URL'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-6" id="popupType"
                    <?php
                    if ($form_position == 'right' || $form_position == 'center')
                        echo "style='display:block;'";
                    else echo "style='display:none;'";
                    ?>
                >
                    <div class="form-group">
                        <label><?php echo $this->lang->line('Pop-up Position'); ?> <span class="red">*</span>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("Pop-up Position refers where do you want to make form Poped up in your website."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <select name="popup_type" id="popup_type" class="form-control select2">
                            <option value=""><?php echo $this->lang->line('Select Pop-up Type'); ?></option>
                            <option value="right" <?php if ($form_position == 'right') echo "selected"; ?>><?php echo $this->lang->line('Bottom-right'); ?></option>
                            <option value="center" <?php if ($form_position == 'center') echo "selected"; ?>><?php echo $this->lang->line('Center'); ?></option>
                        </select>
                    </div>
                </div>

                <!-- interval time custom -->
                <div class="col-md-6"
                     id="interval_time" <?php if ($form_position == "fixed" || $form_position == "direct") echo "style='display:none;'" ?>>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('Pop-up Delay (second)'); ?>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("Pop-up delay refers to after how much time your form will be visible and it will work as second, for example, if you put 1 in the field then the form will be visible after 1 second. At initial stage of the form, this field won't be shown. Time interval is required for Bottom-right and Center position."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <input id="interval_time_input" type="text" name="interval_time" class="form-control"
                               value="<?php echo $interval_time / 1000; ?>">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="mb-3"><?php echo $this->lang->line('Response After Submission'); ?> <span
                                    class="red">*</span>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("include lead user first name"); ?>"
                               data-content="<?php echo $this->lang->line("Choose an option to make an event after successfull form submission."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="response_type" value="success_message_type"
                                   id="success_message_type" class="custom-control-input radio_button">
                            <label class="custom-control-label"
                                   for="success_message_type"><?php echo $this->lang->line("Set Success Message") ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="response_type" value="redirect_url_type" id="redirect_url_type"
                                   class="custom-control-input radio_button">
                            <label class="custom-control-label"
                                   for="redirect_url_type"><?php echo $this->lang->line("Set Redirect URL") ?></label>
                        </div>
                    </div>
                </div>

                <!-- upload image code for background image -->
                <div class="col-12 col-md-6">
                    <div class="form-group mb-0">
                        <label><?php echo $this->lang->line('Background Image'); ?> <?php echo $this->lang->line('(Max 1MB)'); ?>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("You can set a background image for your form which will be used as form background. Allowed files are .png, .jpg,.jpeg"); ?>"><i
                                        class='bx bx-info-circle'></i> </a>

                        </label>
                        <div id="uploademail_attachment"
                             class="pointer"><?php echo $this->lang->line('Upload'); ?></div>
                    </div>
                </div>

                <div class="col-12 col-md-6" id="success_message_div" style="display: none;">
                    <div class="form-group mb-0">
                        <label><?php echo $this->lang->line('Success Message'); ?> <span class="red">*</span>
                            <a href="#" data-placement="top" data-toggle="popover"
                               title="<?php echo $this->lang->line("include lead user first name"); ?>"
                               data-content="<?php echo $this->lang->line("Set a Success Message, so system will show this message after successfull form submission."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <input type="text" name="success_message" id="success_message"
                               value="<?= set_value('success_message', $success_message, true) ?>" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-md-6" id="redirect_url_div" style="display: none;">
                    <div class="form-group mb-0">
                        <label><?php echo $this->lang->line('Redirect URL'); ?> <span class="red">*</span>
                            <a href="#" data-placement="top" data-toggle="popover"
                               title="<?php echo $this->lang->line("include lead user first name"); ?>"
                               data-content="<?php echo $this->lang->line("Set Redirect URL, so that system will redirect to that URL after successfull form submission."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <input type="text" name="redirect_url" id="redirect_url"
                               value="<?= set_value('redirect_url', $redirect_url, true) ?>" class="form-control">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for=""><i
                                    class="bx bx-arch"></i> <?php echo $this->lang->line('Enable Country Code for Phone'); ?>
                        </label><br>
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="enable_country_code" id="enable_country_code" value="1"
                                   class="custom-switch-input" <?php if ($enable_country_code == '1') echo "checked"; ?>>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"><?php echo $this->lang->line('Enable'); ?></span>
                            <span class="text-danger"><?php echo form_error('enable_country_code'); ?></span>
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-6"
                     id="country_code_lists" <?php if ($enable_country_code == '1') echo 'style="display:block;"'; else echo 'style="display:none;"' ?>>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('Country Code'); ?>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("Pop-up Position refers where do you want to make form Poped up in your website."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label>
                        <select name="country_code_for_phone" id="country_code_for_phone" class="form-control select2"
                                style="width:100%;">
                            <option value=""><?php echo $this->lang->line('Default Country Code'); ?></option>
                            <?php
                            foreach ($formatted_country_codes as $key => $value) {
                                $selected_code = '';

                                if ($country_code_for_phone == $key) $selected_code = "selected";

                                echo "<option value={$key} {$selected_code}>{$value}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for=""><i
                                    class="fas fa-check-double"></i> <?php echo $this->lang->line('Double Opt-in for email'); ?>
                            <a href="#" data-placement="top" data-toggle="tooltip"
                               data-original-title="<?php echo $this->lang->line("If you enable double opt-in for email subscription, system will send a confirmation email to the submitted email address."); ?>"><i
                                        class='bx bx-info-circle'></i> </a>
                        </label><br>
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="is_double_optin" id="is_double_optin" value="1"
                                   class="custom-switch-input" <?php if ($is_double_optin == '1') echo "checked"; ?>>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"><?php echo $this->lang->line('Enable'); ?></span>
                            <span class="red"><?php echo form_error('is_double_optin'); ?></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12">
                    <div id="optin-form-builder"></div>
                </div>
            </div>
        </div>
    </div>
</div>


