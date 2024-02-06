<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
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

<style>
    .bbw {
        border-bottom-width: thin !important;
        border-bottom: solid .5px #f9f9f9 !important;
        padding-bottom: 20px;
    }

    .note-editable {
        padding-top: 40px !important;
        min-height: 200px !important;
        max-height: 600px !important;
        border: none !important;
        padding-right: 0 !important;
    }

    .template_contents {
        min-height: 200px !important;
        max-height: 400px !important;
    }

    .button-outline {
        background: #fff;
        border: .5px dashed #ccc;
    }

    .button-outline:hover {
        border: 1px dashed #6777EF !important;
        cursor: pointer;
    }
</style>
<input type="hidden" name="sms_email_sequence_csrf_token" id="sms_email_sequence_csrf_token"
       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
<div class="hidden" id="add_bot_settings_modal" style="margin-bottom:50px;">
    <div class="modal-dialog" style="max-width:100%;margin:0px;">
        <div class="modal-content <?php if ($iframe == '1') echo 'shadow-none'; ?>">
            <?php if ($iframe != '1') : ?>
                <div class="modal-header" style="padding: 10px;">
                    <h3 class="modal-title" style="padding-left: 35px;"><i
                                class='bx bx-plus'></i> <?php echo $this->lang->line("Add Sequence"); ?></h3>
                </div>
            <?php endif; ?>
            <div class="modal-body  <?php if ($iframe == '1') echo 'p-0 overflow-hidden'; ?>">

                <div class="row">
                    <div class="col-12">
                        <form action="#" enctype="multipart/form-data" id="sms_email_sequence_form"
                              style="padding-left: 0;">
                            <input type="hidden" name="day_counter" id="day_counter"
                                   value="<?php echo $default_display; ?>">
                            <input type="hidden" name="hour_counter" id="hour_counter"
                                   value="<?php echo $default_display_hour; ?>">
                            <input type="hidden" name="page_id" id="page_id" value="<?php echo $page_auto_id; ?>">

                            <div class="row">
                                <div class="form-group col-12">
                                    <label><?php echo $this->lang->line("Campaign Name"); ?></label>
                                    <input type="text" name="campaign_name" id="campaign_name" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <label class="form-label"><?php echo $this->lang->line("Sequence Type"); ?></label>
                                    <div class="selectgroup selectgroup-pills">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="campaign_types" id="campaign_types" value="email"
                                                   class="selectgroup-input" checked>
                                            <span class="selectgroup-button"><?php echo $this->lang->line("Email"); ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="campaign_types" id="campaign_types" value="sms"
                                                   class="selectgroup-input">
                                            <span class="selectgroup-button"><?php echo $this->lang->line("SMS"); ?></span>
                                        </label>

                                    </div>
                                </div>
                            </div>

                            <div class="card border_me">
                                <div class="card-header">
                                    <h4>
                                        <i class="bx bx-time"></i> <?php echo $this->lang->line("Sequence Time"); ?>
                                    </h4>
                                </div>
                                <div class="card-body" id="sequence_body">

                                    <ul class="nav nav-tabs" id="sequence_tab" role="tablist">

                                        <li class="nav-item">
                                            <a class="nav-link active" id="sequence_tab2" data-toggle="tab"
                                               href="#hourwise" role="tab" aria-controls="profile"
                                               aria-selected="false"><?php echo $this->lang->line("24 Hour"); ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="sequence_tab1" data-toggle="tab" href="#daywise"
                                               role="tab"
                                               aria-selected="true"><?php echo $this->lang->line("Daily"); ?></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content tab-bordered">
                                        <div class="tab-pane fade" id="daywise" role="tabpanel"
                                             aria-labelledby="sequence_tab1">
                                            <div class="row">
                                                <?php
                                                $tooplip1 = '<a data-html="true" href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Starting & Closing Time") . '" data-content="' . $this->lang->line('System will start processing email from starting hour & terminate processing at closing hour of the day. The time interval must be minimum one hour. If your subscriber list for this campaign is large, you should select larger time interval in order to send all email properly.') . '"><i class="bx bx-info-circle"></i> </a>';
                                                ?>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Starting Time") . " " . $tooplip1; ?></label>
                                                        <input type="text" class="form-control timepicker_x"
                                                               value="00:00" id="between_start" name="between_start">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Closing Time") . " " . $tooplip1; ?></label>
                                                        <input type="text" class="form-control timepicker_x"
                                                               value="23:59" id="between_end" name="between_end">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Time Zone"); ?></label>
                                                        <?php echo form_dropdown('timezone', $timezones, $this->config->item('time_zone'), "class='select2 form-control' id='timezone' style='width:100%;'"); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            for ($i = 1; $i <= $how_many_days; $i++) {
                                                $hideshowclass = '';
                                                if ($i > $default_display) $hideshowclass = 'hidden';
                                                ?>
                                                <div class="row <?php echo $hideshowclass; ?>"
                                                     id="day_container<?php echo $i; ?>">

                                                    <div class="form-group col-3">
                                                        <div class="selectgroup w-100">
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" value="<?php echo $i; ?>"
                                                                       id="day<?php echo $i; ?>"
                                                                       class="selectgroup-input" checked>
                                                                <span class="selectgroup-button selectgroup-button-icon"><i
                                                                            class="bx bx-calendar"></i> <?php echo $this->lang->line('Day') . '-' . $i; ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-7">
                                                        <div id='sms_email_sequence_templates<?php echo $i; ?>'>
                                                            <?php
                                                            $template_id = "template_id" . $i;
                                                            $sms_email_sequence_templates[''] = "--- " . $this->lang->line("Do not send message") . " ---";
                                                            echo form_dropdown($template_id, $sms_email_sequence_templates, '', 'class="form-control template_id select2" id="' . $template_id . '" style="width:100%;"');
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <a href=""
                                                           title="<?php echo $this->lang->line("Refresh Template List"); ?>"
                                                           data-toggle="tooltip" data-id="<?php echo $i; ?>"
                                                           class="ref_template btn"><i class="bx bx-sync blue"></i></a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="row button_container">
                                                <div class="form-group col-7 offset-3">
                                                    <a id="add_more_day" href=""
                                                       class="btn btn-outline-primary btn-sm float-left"><i
                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add More Day'); ?>
                                                    </a>
                                                    <a id="remove_last_day" href=""
                                                       class="btn btn-outline-danger btn-sm float-right"><i
                                                                class="bx bx-time-circle"></i> <?php echo $this->lang->line('Remove Last Day'); ?>
                                                    </a>
                                                </div>
                                                <div class="form-group col-2">
                                                    <a target="_BLANK"
                                                       title="<?php echo $this->lang->line('Add New Template'); ?>"
                                                       data-toggle="tooltip" class="btn btn-default  add_template"
                                                       href=""><i class="bx bx-plus-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show active" id="hourwise" role="tabpanel"
                                             aria-labelledby="sequence_tab2">

                                            <?php
                                            for ($i = 0; $i <= $how_many_hours; $i++) {
                                                $hideshowclass = '';
                                                if ($i > $default_display_hour) $hideshowclass = 'hidden';

                                                if ($i == 0) {
                                                    $minutes = 1;
                                                    $displayname = $this->lang->line('1 Mins');
                                                }

                                                if ($i == 1) {
                                                    $minutes = 5;
                                                    $displayname = $this->lang->line('5 Mins');
                                                }

                                                if ($i == 2) {
                                                    $minutes = 15;
                                                    $displayname = $this->lang->line('15 Mins');
                                                }

                                                if ($i == 3) {
                                                    $minutes = 30;
                                                    $displayname = $this->lang->line('30 Mins');
                                                }

                                                if ($i > 3) {
                                                    $minutes = ($i - 3) * 60;
                                                    $displayname = ($i - 3) . " " . $this->lang->line('Hour');
                                                }

                                                ?>
                                                <div class="row <?php echo $hideshowclass; ?>"
                                                     id="hour_container<?php echo $i; ?>">

                                                    <div class="form-group col-3">
                                                        <div class="selectgroup w-100">
                                                            <label class="selectgroup-item">
                                                                <input type="checkbox" value="<?php echo $minutes; ?>"
                                                                       id="hour<?php echo $i; ?>"
                                                                       class="selectgroup-input" checked>
                                                                <span class="selectgroup-button selectgroup-button-icon"><i
                                                                            class="bx bx-time"></i> <?php echo $displayname; ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-7">
                                                        <div id='hour_sms_email_sequence_templates<?php echo $i; ?>'>
                                                            <?php
                                                            $template_id = "hour_template_id" . $i;
                                                            $sms_email_sequence_templates[''] = "--- " . $this->lang->line("Do not send message") . " ---";
                                                            echo form_dropdown($template_id, $sms_email_sequence_templates, '', 'class="form-control hour_template_id select2" id="' . $template_id . '" style="width:100%;"');
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <a href=""
                                                           title="<?php echo $this->lang->line("Refresh Template List"); ?>"
                                                           data-toggle="tooltip" data-id="<?php echo $i; ?>"
                                                           class="hour_ref_template btn"><i class="bx bx-sync blue"></i></a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="row button_container">
                                                <div class="form-group col-7 offset-3">
                                                    <a id="add_more_hour" href=""
                                                       class="btn btn-outline-primary btn-sm float-left"><i
                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add More Hour'); ?>
                                                    </a>
                                                    <a id="remove_last_hour" href=""
                                                       class="btn btn-outline-danger btn-sm float-right"><i
                                                                class="bx bx-time-circle"></i> <?php echo $this->lang->line('Remove Last Hour'); ?>
                                                    </a>
                                                </div>
                                                <div class="form-group col-2">
                                                    <a target="_BLANK"
                                                       title="<?php echo $this->lang->line('Add New Template'); ?>"
                                                       data-toggle="tooltip" class="btn btn-default  add_template"
                                                       href=""><i class="bx bx-plus-circle"></i></a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <br> <br>
            <div class="modal-footer <?php if ($iframe == '1') echo 'p-0 overflow-hidden'; ?>">
                <a id="submit_btn" href="" class="btn btn-primary"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line('Create Campaign'); ?></a>
                <a href="<?php echo base_url('sms_email_sequence/sms_email_sequence_message_campaign/' . $page_auto_id . '/1'); ?>"
                   class="btn btn-secondary float-right"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Back'); ?></a>

            </div>
        </div>
    </div>
</div>


<?php
echo '<div id="alert_message" class="text-center" style="padding:20px;margin-bottom:10px;border:.5px solid #dee2e6; color:#6777ef;background: #fff;">' . $this->lang->line("Campaign will be applied to those subscribers have email & phone number.") . '</div>';
echo "<div class='table-responsive data-card' id='setting_list'><table class='table table-bordered table-sm table-striped' id='ses_mytable'>";
echo "<thead>";
echo "<tr>";
echo "<th>" . $this->lang->line("SL") . "</th>";
echo "<th>" . $this->lang->line("Name") . "</th>";
echo "<th class='text-center'>" . $this->lang->line("Last Sent") . "</th>";
echo "<th class='text-center'>" . $this->lang->line("Campaign Type") . "</th>";
if ($this->is_engagement_exist) {
    echo "<th class='text-center'>" . $this->lang->line("Engagement Campaign") . "</th>";
}
echo "<th class='text-center'>" . $this->lang->line("Actions") . "</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
$i = 0;
foreach ($sms_email_sequence_settings as $key => $value) {
    $i++;
    if ($value['last_sent_at'] != "0000-00-00 00:00:00") $reply_at = date('M j, Y H:i', strtotime($value['last_sent_at']));
    else $reply_at = "<i class='bx bx-trash'></i>";

    $campaign_types = $value['campaign_type'];
    $details = '-';
    echo "<tr>";
    echo "<td>" . $i . "</td>";
    echo "<td>" . $value['campaign_name'] . "</td>";
    echo "<td class='text-center'>" . $reply_at . "</td>";
    echo "<td class='text-center'>" . $campaign_types . "</td>";
    if ($this->is_engagement_exist) {
        echo "<td class='text-center'>" . $details . "</td>";
    }

    $editurl = base_url("sms_email_sequence/edit_sequence_campaign/" . $value['id'] . '/' . $page_auto_id);
    if (isset($iframe) && $iframe == '1') {
        $editurl .= '/1';
    }

    $report_link = '';
    if ($value['message_content_hourly'] != '[]')
        $report_link .= '<li><a class="dropdown-item has-icon message_content" href="" data-day="0" data-id="' . $value['id'] . '"><i class="bx bx-time"></i> ' . $this->lang->line("24H Report") . '</a></li>';

    if ($value['message_content'] != '[]')
        $report_link .= '<li><a class="dropdown-item has-icon message_content" href="" data-day="1" data-id="' . $value['id'] . '"><i class="bx bx-calendar"></i> ' . $this->lang->line("Daily Report") . '</a></li>';

    $report_link .= '<div class="dropdown-divider"></div>';

    echo "<td class='text-center'>";
    echo '<a href="#" data-toggle="dropdown" class="btn btn-outline-primary btn-circle dropdown-toggle bot_actions no_caret"><i class="bx bx-briefcase"></i></a> 
            
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
             <div class="dropdown-header">' . $this->lang->line("Actions") . '</div>                         
              ' . $report_link . '
              <li><a class="dropdown-item has-icon" href="' . $editurl . '"><i class="bx bx-edit"></i> ' . $this->lang->line("Edit Sequence") . '</a></li>
              <div class="dropdown-divider"></div>
              <li><a class="dropdown-item has-icon delete_bot red" href="" campaignType="' . $value['campaign_type'] . '" id="' . $value['id'] . '"><i class="bx bx-trash-alt"></i> ' . $this->lang->line("Delete Sequence") . '</a></li>
            </ul>';

    echo "</td>";

    echo "</tr>";
}
echo "</tbody>";
echo "</table></div>";

$somethingwentwrong = $this->lang->line("Something went wrong.Please try again.");
$drop_menu = '<a id="add_bot_settings" href="" class="float-right btn btn-primary"><i class="bx bx-plus-circle"></i> ' . $this->lang->line("Add Sequence") . '</a>';
?>


<div class="modal fade" id="sms_email_message_content_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header smallpadding">
                <h3 class="modal-title"><i class="bx bx-show"></i> <?php echo $this->lang->line('Campaign Report'); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body smallpadding" id="sms_email_message_content_modal_content"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="sms_email_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 95% !important;max-width: 95% !important;">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-primary"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" id="name-div">
                        <div class="form-group">
                            <label><?php echo $this->lang->line("Template Name"); ?></label>
                            <input type="text" class="form-control" name="template_name" id="template_name">
                        </div>
                    </div>
                    <div class="col-12 col-md-6" id="subject-div">
                        <div class="form-group">
                            <label><?php echo $this->lang->line("Subject"); ?></label>
                            <input type="text" class="form-control" name="template_subject" id="template_subject">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line("content"); ?></label>
                            <span class='float-right'>
                        <a title="<?php echo $this->lang->line("You can include #LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                           data-toggle="tooltip" data-placement="top" class='btn-sm lead_last_name button-outline'><i
                                    class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                      </span>
                            <span class='float-right'>
                        <a title="<?php echo $this->lang->line("You can include #FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                           data-toggle="tooltip" data-placement="top" class='btn-sm lead_first_name button-outline'><i
                                    class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                      </span>
                            <textarea name="template_contents" id="template_contents"
                                      class="form-control template_contents"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button class="btn btn-primary" button-type="" id="save_template" name="save_template" type="button"><i
                            class="bx bxs-save"></i> <?php echo $this->lang->line("Save") ?> </button>
                <a class="btn btn-light float-right" data-dismiss="modal" aria-hidden="true"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
            </div>
        </div>
    </div>
</div>