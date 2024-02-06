<?php
$include_upload = 0;  //upload_js
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

<style type="text/css">
    .ajax-upload-dragdrop {
        width: 100% !important;
    }

    .item_remove {
        margin-top: 9px;
        margin-left: -20px;
        cursor: pointer !important;
    }

    .remove_reply {
        margin-top: -5px;
        cursor: pointer !important;
    }

    .waiting i {
        font-size: 40px;
    }

    .select2 {
        width: 100% !important;
    }

    .selectgroup-button-icon {
        height: 42px;
    }

    .smallpadding {
        padding: 10px !important;
    }

    .card-stats-item {
        padding: 5px 10px !important;
    }

    div.tooltip {
        top: 0px !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <?php
        $builder_load_url = base_url("visual_flow_builder/load_builder/" . $page_auto_id . '/1/' . $media_type);
        ?>
        <a target="_BLANK" href="<?php echo $builder_load_url; ?>" class="btn btn-primary"><i
                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Sequence"); ?></a>
    </div>
</div>


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
                        <form action="#" enctype="multipart/form-data" id="plugin_form" style="padding-left: 0;">
                            <input type="hidden" name="day_counter" id="day_counter"
                                   value="<?php echo $default_display; ?>">
                            <input type="hidden" name="hour_counter" id="hour_counter"
                                   value="<?php echo $default_display_hour; ?>">
                            <input type="hidden" name="page_id" id="page_id" value="<?php echo $page_auto_id; ?>">
                            <input type="hidden" name="media_type" id="media_type" value="<?php echo $media_type; ?>">

                            <div class="row">
                                <div class="form-group col-12">
                                    <label><?php echo $this->lang->line("Campaign Name"); ?></label>
                                    <input type="text" name="campaign_name" id="campaign_name" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <?php if ($media_type == 'fb') { ?>
                                        <label class="form-label">
                                            <?php echo $this->lang->line("Sequence Type"); ?>
                                            <?php if ($this->is_engagement_exist) { ?>
                                                <a href="#" data-placement="top" data-toggle="popover"
                                                   data-trigger="focus"
                                                   title="<?php echo $this->lang->line("Sequence Type"); ?>"
                                                   data-content="<?php echo $this->lang->line('You must create default type campaign. You can also create different campaigns for different messenger engagement tools. Subscribers from those tools will get different sequence message and others will get default message.'); ?>"><i
                                                            class='bx bx-info-circle'></i> </a>
                                            <?php } ?>

                                        </label>
                                        <div class="selectgroup selectgroup-pills">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="drip_type" id="drip_type1" value="default"
                                                       class="selectgroup-input" checked>
                                                <span class="selectgroup-button"><?php echo $this->lang->line("Default"); ?></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="drip_type" id="drip_type2" value="custom"
                                                       class="selectgroup-input">
                                                <span class="selectgroup-button"><?php echo $this->lang->line("Custom"); ?></span>
                                            </label>
                                            <?php
                                            if ($this->is_engagement_exist) {
                                                $drip_types_engagement = $drip_types;
                                                unset($drip_types_engagement['default']);
                                                unset($drip_types_engagement['custom']);
                                                $i = 2;
                                                foreach ($drip_types_engagement as $key => $value) {
                                                    $i++;
                                                    echo '
                            <label class="selectgroup-item">
                              <input type="radio" name="drip_type" id="drip_type' . $i . '"  value="' . $key . '" class="selectgroup-input">
                              <span class="selectgroup-button">' . $this->lang->line($value) . '</span>
                            </label>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php } else { ?>
                                        <input type="radio" name="drip_type" id="drip_type2" value="custom"
                                               class="selectgroup-input  d-none" checked>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="text-center waiting hidden" id="loader2">
                                <i class="bx bx-loader-alt bx-spin blue text-center"></i>
                                <br><br>
                            </div>

                            <div class="card hidden border_me" id="engagement_block">
                                <div class="card-header">
                                    <h4>
                                        <i class="bx bx-bullseye"></i> <?php echo $this->lang->line("Messenger Engagement Re-targeting"); ?>
                                    </h4>
                                </div>
                                <div class="card-body" id="put_engegement_content">

                                </div>
                            </div>


                            <div class="card border_me">
                                <div class="card-header">
                                    <h4>
                                        <i class="bx bx-time"></i> <?php echo $this->lang->line("Sequence Time"); ?>
                                    </h4>
                                </div>
                                <div class="card-body">

                                    <div class="well text-justify"
                                         style="border:1px solid #6777ef;padding:15px;color:#6777ef;">
                                        <?php echo $this->lang->line("Use DAILY NON-PROMOTIONAL sequence with message tag carefully. Message must not contain any advertisement or promotional material & use appropriate tag that's is applicable for sending message to those people. Using Message tag without proper reason may result in block your page's messaging option by Facebook."); ?>
                                        <br><u><a href='https://developers.facebook.com/docs/messenger-platform/policy/policy-overview/#subscription_messaging'
                                                  target='_BLANK'><?php echo $this->lang->line("Read more about messaging policy."); ?></a></u>
                                        <?php if (strtotime(date("Y-m-d")) <= strtotime("2020-3-4")) echo "<br><br><span class='text-danger'>" . $this->lang->line("Non-promo message sending with NON_PROMOTIONAL_SUBSCRIPTION tag will require pages_messaging_subscriptions permission approved. This permission has been deprecated on July 29, 2019. You can only use this tag until 4th March 2020 if your page has already pages_messaging_subscriptions permission approved.") . "<span>"; ?>
                                    </div>
                                    <br>

                                    <ul class="nav nav-tabs" id="sequence_tab" role="tablist">

                                        <li class="nav-item">
                                            <a class="nav-link active" id="sequence_tab2" data-toggle="tab"
                                               href="#hourwise" role="tab" aria-controls="profile"
                                               aria-selected="false"><?php echo $this->lang->line("24 Hour Promotional"); ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="sequence_tab1" data-toggle="tab" href="#daywise"
                                               role="tab"
                                               aria-selected="true"><?php echo $this->lang->line("Daily Non-promotional"); ?></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content tab-bordered">

                                        <div class="tab-pane fade" id="daywise" role="tabpanel"
                                             aria-labelledby="sequence_tab1">
                                            <div class="row">
                                                <?php
                                                $tooplip1 = '<a data-html="true" href="#" data-placement="top"  data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Starting & Closing Time") . '" data-content="' . $this->lang->line('System will start processing message from starting hour & terminate processing at closing hour of the day. The time interval must be minimum one hour. If your subscriber list for this campaign is large, you should select larger time interval in order to send all message properly.') . '"><i class="bx bx-info-circle"></i> </a>';
                                                ?>
                                                <div class="col-6 col-md-3">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Starting Time") . " " . $tooplip1; ?></label>
                                                        <input type="text" class="form-control timepicker_x"
                                                               value="00:00" id="between_start" name="between_start">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Closing Time") . " " . $tooplip1; ?></label>
                                                        <input type="text" class="form-control timepicker_x"
                                                               value="23:59" id="between_end" name="between_end">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Time Zone"); ?></label>
                                                        <?php echo form_dropdown('timezone', $timezones, $this->config->item('time_zone'), "class='form-control select2' id='timezone'"); ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line("Message Tag"); ?>
                                                            <a data-toggle="modal" href=''
                                                               data-target="#message_tags_modal"><i
                                                                        class='bx bx-info-circle'></i></a>
                                                        </label>
                                                        <?php echo form_dropdown('message_tag', $tag_list, '', 'class="select2 form-control" id="message_tag"'); ?>
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
                                                        <div id='push_postback<?php echo $i; ?>'>
                                                            <?php
                                                            $template_id = "template_id" . $i;
                                                            // $template_list['']=$this->lang->line("Message Template").' '.$this->lang->line("Day").'-'.$i;
                                                            $template_list[''] = "--- " . $this->lang->line("Do not send message") . " ---";
                                                            echo form_dropdown($template_id, $template_list, '', 'class="form-control template_id select2" id="' . $template_id . '"');
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
                                                       href="<?php echo base_url('messenger_bot/create_new_template/1/' . $page_auto_id . '/0/' . $media_type); ?>"><i
                                                                class="bx bx-plus-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show active" id="hourwise" role="tabpanel"
                                             aria-labelledby="sequence_tab2">

                                            <?php
                                            for ($i = 0; $i <= $how_many_hours; $i++) {
                                                $hideshowclass = '';
                                                if ($i > $default_display_hour) $hideshowclass = 'hidden';
                                                $minutes = $i * 60;
                                                $displayname = $i . " " . $this->lang->line('Hour');

                                                if ($i == 0) {
                                                    $minutes = 30;
                                                    $displayname = $this->lang->line('30 Mins');
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
                                                        <div id='hour_push_postback<?php echo $i; ?>'>
                                                            <?php
                                                            $template_id = "hour_template_id" . $i;
                                                            // $template_list['']=$this->lang->line("Message Template").' '.$this->lang->line("Day").'-'.$i;
                                                            $template_list[''] = "--- " . $this->lang->line("Do not send message") . " ---";
                                                            echo form_dropdown($template_id, $template_list, '', 'class="form-control hour_template_id select2" id="' . $template_id . '"');
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
                                                       href="<?php echo base_url('messenger_bot/create_new_template/1/' . $page_auto_id . '/0/' . $media_type); ?>"><i
                                                                class="bx bx-plus-circle"></i></a>
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
                <a href="<?php echo base_url('messenger_bot_enhancers/sequence_message_campaign/' . $page_auto_id . '/1/' . $media_type); ?>"
                   class="btn btn-secondary float-right"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Back'); ?></a>

            </div>
        </div>
    </div>
</div>


<?php
echo "<div class='table-responsive data-card' id='setting_list'><table class='table table-bordered table-sm table-striped' id='mytable'>";
echo "<thead>";
echo "<tr>";
echo "<th>" . $this->lang->line("SL") . "</th>";
echo "<th>" . $this->lang->line("Name") . "</th>";
// echo "<th class='text-center'>".$this->lang->line("Created")."</th>";
echo "<th class='text-center'>" . $this->lang->line("Last Sent") . "</th>";
echo "<th class='text-center'>" . $this->lang->line("Drip Type") . "</th>";
if ($this->is_engagement_exist && $media_type != 'ig') {
    echo "<th class='text-center'>" . $this->lang->line("Engagement Campaign") . "</th>";
}
echo "<th class='text-center'>" . $this->lang->line("Actions") . "</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
$i = 0;
foreach ($bot_settings as $key => $value) {
    $i++;
    if ($value['last_sent_at'] != "0000-00-00 00:00:00") $reply_at = date('d M y H:i', strtotime($value['last_sent_at']));
    else $reply_at = "<i class='bx bx-trash'></i>";

    $drip_type = $this->lang->line($drip_types[$value['drip_type']]);
    $details = '-';
    if ($value['drip_type'] != 'default' && $value['drip_type'] != 'custom') {
        $href = '';
        if ($value['drip_type'] == 'messenger_bot_engagement_checkbox')
            $href = 'messenger_bot_enhancers/checkbox_plugin_edit/';
        else if ($value['drip_type'] == 'messenger_bot_engagement_send_to_msg')
            $href = 'messenger_bot_enhancers/send_to_messenger_edit/';
        else if ($value['drip_type'] == 'messenger_bot_engagement_mme')
            $href = 'messenger_bot_enhancers/mme_link_edit/';
        else if ($value['drip_type'] == 'messenger_bot_engagement_messenger_codes')
            $href = 'messenger_bot_enhancers/messenger_codes_edit/';
        else if ($value['drip_type'] == 'messenger_bot_engagement_2way_chat_plugin')
            $href = 'messenger_bot_enhancers/customer_chat_edit/';

        if ($value['engagement_table_id'] != 0) {
            $href = base_url($href . $value['engagement_table_id'] . '/1');
            $details = '<a class="btn btn-default iframed" href="' . $href . '"><i class="bx bx-show"></i> ' . $this->lang->line("Details") . '</a>';
        }
    }

    echo "<tr>";
    echo "<td>" . $i . "</td>";
    echo "<td>" . $value['campaign_name'] . "</td>";
    // echo "<td class='text-center'>".date('d M y',strtotime($value['created_at']))."</td>";
    echo "<td class='text-center'>" . $reply_at . "</td>";
    echo "<td class='text-center'>" . $drip_type . "</td>";
    if ($this->is_engagement_exist && $media_type != 'ig') {
        echo "<td class='text-center'>" . $details . "</td>";
    }

    if (addon_exist($module_id = 315, $addon_unique_name = "visual_flow_builder") && $value['visual_flow_campaign_id'] != 0) {
        $editurl = base_url("visual_flow_builder/edit_builder_data/" . $value['visual_flow_campaign_id'] . "/0");
    } else {
        $editurl = base_url("messenger_bot_enhancers/edit_sequence_message_campaign/" . $value['id'] . '/' . $page_auto_id);
        if (isset($iframe) && $iframe == '1') {
            $editurl .= '/1';
        } else  $editurl .= '/0';
        $editurl .= '/' . $media_type;
    }

    if (stripos($editurl, "visual_flow_builder/edit_builder_data"))
        $target = "target='_BLANK'";
    else
        $target = "";

    $report_link = '';
    if ($value['message_content_hourly'] != '[]')
        $report_link .= '<li><a class="dropdown-item has-icon message_content" href="" data-day="0" data-id="' . $value['id'] . '"><i class="bx bx-time"></i> ' . $this->lang->line("24H Promo Report") . '</a></li>';

    if ($value['message_content'] != '[]')
        $report_link .= '<li><a class="dropdown-item has-icon message_content" href="" data-day="1" data-id="' . $value['id'] . '"><i class="bx bx-calendar"></i> ' . $this->lang->line("Daily Non-Promo Report") . '</a></li>';

    $report_link .= '<div class="dropdown-divider"></div>';

    echo "<td class='text-center'>";
    echo '<a href="#" data-toggle="dropdown" class="btn btn-outline-primary btn-circle dropdown-toggle bot_actions no_caret"><i class="bx bx-briefcase"></i></a> 
            
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
             <div class="dropdown-header">' . $this->lang->line("Actions") . '</div>                         
              ' . $report_link . '
              <li><a class="dropdown-item has-icon" href="' . $editurl . '" ' . $target . '><i class="bx bx-edit"></i> ' . $this->lang->line("Edit Sequence") . '</a></li>
              <div class="dropdown-divider"></div>
              <li><a class="dropdown-item has-icon delete_bot red" href="" id="' . $value['id'] . '"><i class="bx bx-trash-alt"></i> ' . $this->lang->line("Delete Sequence") . '</a></li>
            </ul>';

    echo "</td>";

    echo "</tr>";
}
echo "</tbody>";
echo "</table></div>";

$somethingwentwrong = $this->lang->line("Something went wrong.Please try again.");
// $drop_menu = '<a id="add_bot_settings" href="" class="float-right btn btn-primary"><i class="bx bx-plus-circle"></i> '.$this->lang->line("Add Sequence").'</a>';
$builder_load_url = base_url("visual_flow_builder/load_builder/" . $page_auto_id . '/1/' . $media_type);
$drop_menu = '';
?>


<div class="modal fade" id="message_content_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header smallpadding">
                <h3 class="modal-title"><i class="bx bx-show"></i> <?php echo $this->lang->line('Campaign Report'); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body smallpadding" id="message_content_modal_content">

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%" class="iframe_in_iframe" id="iframe_in_iframe"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>


<?php include("application/n_views/modules/messenger_bot_enhancers/message_tag_modal.php") ?>
