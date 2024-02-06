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
</style>


<div id="add_bot_settings_modal" style="margin-bottom:50px;">
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
                            <input type="hidden" name="campaign_id" id="campaign_id"
                                   value="<?php echo $xdata['id']; ?>">
                            <input type="hidden" name="media_type" id="media_type" value="<?php echo $media_type; ?>">

                            <div class="row">
                                <div class="form-group col-12">
                                    <label><?php echo $this->lang->line("Campaign Name"); ?></label>
                                    <input type="text" name="campaign_name" id="campaign_name" class="form-control"
                                           value="<?php echo $xdata['campaign_name']; ?>">
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
                                    </div>
                                    <br>

                                    <ul class="nav nav-tabs" id="sequence_tab" role="tablist">

                                        <li class="nav-item">
                                            <a class="nav-link active" id="sequence_tab2" data-toggle="tab"
                                               href="#hourwise" role="tab" aria-controls="profile"
                                               aria-selected="false"><?php echo $this->lang->line("24 Hour Promotional"); ?></a>
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
                                                               value="<?php echo $xdata['between_start']; ?>"
                                                               id="between_start" name="between_start">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Closing Time") . " " . $tooplip1; ?></label>
                                                        <input type="text" class="form-control timepicker_x"
                                                               value="<?php echo $xdata['between_end']; ?>"
                                                               id="between_end" name="between_end">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Time Zone"); ?></label>
                                                        <?php $selcted_timezone = ($xdata['timezone'] != "") ? $xdata['timezone'] : $this->config->item('time_zone'); ?>
                                                        <?php echo form_dropdown('timezone', $timezones, $selcted_timezone, "class='select2 form-control' id='timezone'"); ?>
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
                                                        <?php echo form_dropdown('message_tag', $tag_list, $xdata['message_tag'], 'class="select2 form-control" id="message_tag"'); ?>
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
                                                            $message_content = json_decode($xdata['message_content'], true);
                                                            $select_template = isset($message_content[$i]) ? $message_content[$i] : '';
                                                            $template_id = "template_id" . $i;
                                                            // $template_list['']=$this->lang->line("Message Template").' '.$this->lang->line("Day").'-'.$i;
                                                            $template_list[''] = "--- " . $this->lang->line("Do not send message") . " ---";
                                                            echo form_dropdown($template_id, $template_list, $select_template, 'class="form-control template_id select2" id="' . $template_id . '"');
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
                                                            $message_content_hourly = json_decode($xdata['message_content_hourly'], true);
                                                            $select_template_hourly = isset($message_content_hourly[$minutes]) ? $message_content_hourly[$minutes] : '';
                                                            $template_id = "hour_template_id" . $i;
                                                            // $template_list['']=$this->lang->line("Message Template").' '.$this->lang->line("Day").'-'.$i;
                                                            $template_list[''] = "--- " . $this->lang->line("Do not send message") . " ---";
                                                            echo form_dropdown($template_id, $template_list, $select_template_hourly, 'class="form-control hour_template_id select2" id="' . $template_id . '"');
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
                            class="bx bx-edit"></i> <?php echo $this->lang->line('Edit Campaign'); ?></a>
                <a href="<?php echo base_url('messenger_bot_enhancers/sequence_message_campaign/' . $page_auto_id . '/1/' . $media_type); ?>"
                   class="btn btn-secondary float-right"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Back'); ?></a>

            </div>
        </div>
    </div>
</div>


<?php
$somethingwentwrong = $this->lang->line("Something went wrong.Please try again.");
$is_engagement_exist = ($this->is_engagement_exist == true) ? '1' : '0';
?>


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
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>

<?php include("application/n_views/modules/messenger_bot_enhancers/message_tag_modal.php") ?>
