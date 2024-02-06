<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet" type="text/css"/>
<link rel="stylesheet"
      href="<?php echo base_url(); ?>n_assets/plugins/summernote/summernote-bs4.css?ver=<?php echo $n_config['theme_version']; ?>">
<input type="hidden" name="sms_email_sequence_csrf_token" id="sms_email_sequence_csrf_token"
       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot_broadcast"); ?>"><?php echo $this->lang->line("Broadcasting"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("sms_email_sequence/external_sequence_lists"); ?>"><?php echo $this->lang->line("Campaign List"); ?></a>
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
                    <form action="#" enctype="multipart/form-data" id="sms_email_sequence_form"
                          style="padding-left: 0;">
                        <input type="hidden" name="day_counter" id="day_counter"
                               value="<?php echo $default_display; ?>">
                        <input type="hidden" name="hour_counter" id="hour_counter"
                               value="<?php echo $default_display_hour; ?>">
                        <input type="hidden" name="page_id" id="page_id" value="0">

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

                            <div class="col-12">
                                <div class="hidden" id="sms_api_lists">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Select SMS API'); ?></label>
                                        <select class="select2 form-control" id="sms_api_id" name="sms_api_id"
                                                style="width:100%;">
                                            <option value=''><?php echo $this->lang->line('Select API'); ?></option>
                                            <?php
                                            foreach ($sms_option as $id => $option) {
                                                echo "<option value='{$id}'>{$option}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div id="email_api_lists">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Select Email API'); ?></label>
                                        <select class="select2 form-control" id="email_api_id" name="email_api_id"
                                                style="width:100%;">
                                            <option value=''><?php echo $this->lang->line('Select API'); ?></option>
                                            <?php
                                            foreach ($email_apis as $id => $option) {
                                                echo "<option value='{$id}'>{$option}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
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
                                        <a class="nav-link active" id="sequence_tab2" data-toggle="tab" href="#hourwise"
                                           role="tab" aria-controls="profile"
                                           aria-selected="false"><?php echo $this->lang->line("24 Hour"); ?>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="sequence_tab1" data-toggle="tab" href="#daywise"
                                           role="tab" aria-selected="true"><?php echo $this->lang->line("Daily"); ?></a>
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
                                                    <input type="text" class="form-control timepicker_x" value="00:00"
                                                           id="between_start" name="between_start">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Closing Time") . " " . $tooplip1; ?></label>
                                                    <input type="text" class="form-control timepicker_x" value="23:59"
                                                           id="between_end" name="between_end">
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
                                                                   id="day<?php echo $i; ?>" class="selectgroup-input"
                                                                   checked>
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
                                                                   id="hour<?php echo $i; ?>" class="selectgroup-input"
                                                                   checked>
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

                <div class="card-footer bg-whitesmoke">
                    <a id="submit_btn" href="" class="btn btn-primary"><i
                                class="bx bx-paper-plane"></i> <?php echo $this->lang->line('Create Campaign'); ?></a>
                    <a href="#" class="btn btn-secondary float-right"
                       onclick='goBack("sms_email_sequence/external_sequence_lists",0)'><i
                                class="bx bx-time"></i> <?php echo $this->lang->line('Back'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sms_email_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 70% !important;max-width: 70% !important;">
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