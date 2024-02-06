<?php
//TODO: 001 need more changes
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/css/emojionearea.min.css" media="screen">
<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet" type="text/css"/>
<style type="text/css">
    /* Global Spinner Style */
    .xit-spinner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        z-index: 1000;
    }

    .xit-spinner i {
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -45%);
    }

    /* Styles for post planner */
    #pp-upload-container #wizard-selected .wizard-step {
        cursor: pointer;
        padding: 15px;
    }

    #pp-upload-container #wizard-selected .wizard-step-layer {

        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    #pp-upload-container .wizard-steps .wizard-step::before {
        display: none !important;
    }

    #pp-source-link i {
        font-size: 18px;
    }

    #pp-datatable-container {
        position: relative;
        min-height: 100px;
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
                                href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Comboposter"); ?></a>
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
                <div class="card-body data-card">

                    <div id="pp-csv-info" class="d-none">
                        <div class="alert bg-rgba-secondary" role="alert">

                            <div class="d-flex align-items-center">
                                <i class="bx bx-bulb"></i>
                                <span>
                <?php echo $this->lang->line("Upload a CSV file with the following header fields - <strong>campaign_name</strong>, <strong>campaign_type</strong>, <strong>message</strong>, and <strong>source</strong>. These fields must exist in the header of the CSV file. These are mandatory. But some values of them are optional. The order of the header fields should be in the order as you are seeing here but random order may not be a problem. The <strong>campaign_type</strong> must be <strong>text</strong>, <strong>image</strong>, or <strong>link</strong>."); ?>
              </span>
                            </div>
                        </div>


                        <p class="text-center">
                            <a class="btn btn-info"
                               href="<?php echo base_url('assets/post-planner/sample.csv'); ?>"><?php echo $this->lang->line('To get the idea, download the sample.csv file'); ?>
                            </a>
                        </p>
                    </div>

                    <div id="pp-upload-container" class="row justify-content-center mt-5 pt-5 d-none">

                        <div id="wizard-selected" class="wizard-steps ">
                            <div class="wizard-step text-primary border border-primary" id="upload_this">
                                <div class="wizard-step-icon text-center">
                                    <i class="bx bx-upload font-large-3"></i>
                                </div>
                                <div class="wizard-step-label pl-2 pr-2">
                                    <?php echo $this->lang->line("Upload csv file for Text, Image, and Link posts"); ?>
                                </div>
                                <div class="wizard-step-layer" data-post-type="text"></div>
                            </div>

                            <!-- <div class="wizard-step text-info border border-info" data-post-type="img">
                                    <div class="wizard-step-icon">
                                        <i class="bx bx bx-image"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <?php // echo $this->lang->line('Upload image posts'); ?>
                                    </div>
                                    <div class="wizard-step-layer" data-post-type="image"></div>
                                </div>
                                <div class="wizard-step text-warning border border-warning" data-post-type="lnk">
                                    <div class="wizard-step-icon">
                                        <i class="bx bx-link"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                        <?php // echo $this->lang->line('Upload link posts'); ?>
                                    </div>
                                    <div class="wizard-step-layer" data-post-type="link"></div>
                                </div> -->

                            <!-- Spinner -->
                            <div class="xit-spinner d-none text-primary">
                                <i class="bx bx-loader-alt bx-spin"></i>
                            </div>
                        </div><!-- ends #wizard-selected -->

                        <input id="postfile" class="d-none" type="file" name="postfile" accept="text/csv">
                    </div> <!-- ends #pp-upload-container -->

                    <div id="pp-datatable-container">

                        <form id="pp-settings-form" method="post">

                            <div id="pp-actions-button" class="mb-1 d-none">
                                <p class="d-block"><?php echo $this->lang->line("Click on a button below to set up campaign settings"); ?></p>

                                <div class="btn-group btn-group-medium" role="group" aria-label="Actions">
                                    <button id="pp-manual-button" data-settings-type="manual" type="button"
                                            class="btn btn-info" data-toggle="tooltip"
                                            data-original-title="<?php echo $this->lang->line("Click here to set up campaign settings manually"); ?>"><?php echo $this->lang->line("Manual"); ?></button>
                                    <button id="pp-automatic-button" data-settings-type="automatic" type="button"
                                            class="btn btn-primary" data-toggle="tooltip"
                                            data-original-title="<?php echo $this->lang->line("Click here to make campaign settings automated"); ?>"><?php echo $this->lang->line("Automatic"); ?></button>
                                </div>
                                <button id="pp-link-clear-cached-data" class="btn btn-link d-none" data-toggle="tooltip"
                                        data-original-title="<?php echo $this->lang->line("We are now displaying cached CSV data that was imported previously"); ?>"><?php echo $this->lang->line("Clear cached CSV data"); ?></button>
                            </div>

                            <div id="pp-datatable-wrapper" class="table-responsive2 d-none">
                                <table id="pp-csv-data-table" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("Campaign Name"); ?></th>
                                        <th><?php echo $this->lang->line("Campaign Type"); ?></th>
                                        <th><?php echo $this->lang->line("Source"); ?></th>
                                        <th><?php echo $this->lang->line("Actions"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody id="csv-data-container"></tbody>
                                </table>
                            </div>

                            <div id="pp-schedule-settings" class="mt-3 d-none">
                                <p class="h5"><?php echo $this->lang->line("Schedule settings"); ?></p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="postStartDate"><?php echo $this->lang->line("Post start-datetime"); ?>
                                                *</label>
                                            <input id="postStartDate" class="form-control" type="text"
                                                   name="postStartDate"
                                                   placeholder="<?php echo $this->lang->line("Set start Date"); ?>"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("Post between two times"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><?php echo $this->lang->line("From"); ?></span>
                                                </div>
                                                <input type="text" id="postStartTime" class="form-control"
                                                       placeholder="00:00">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text border-left-0"><?php echo $this->lang->line("To"); ?></span>
                                                </div>
                                                <input type="text" id="postEndTime" class="form-control"
                                                       placeholder="23:59">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="postInterval"><?php echo $this->lang->line("Post interval") ?>
                                                *</label>
                                            <select name="postInterval" class="select2 form-control" id="postInterval"
                                                    required style="width:100%;">
                                                <option value="1"><?php echo $this->lang->line("1 Minute"); ?></option>
                                                <option value="2"><?php echo $this->lang->line("2 Minutes"); ?></option>
                                                <option value="3"><?php echo $this->lang->line("3 Minutes"); ?></option>
                                                <option value="4"><?php echo $this->lang->line("4 Minutes"); ?></option>
                                                <option value="5"><?php echo $this->lang->line("5 Minutes"); ?></option>
                                                <option value="6"><?php echo $this->lang->line("6 Minutes"); ?></option>
                                                <option value="7"><?php echo $this->lang->line("7 Minutes"); ?></option>
                                                <option value="8"><?php echo $this->lang->line("8 Minutes"); ?></option>
                                                <option value="9"><?php echo $this->lang->line("9 Minutes"); ?></option>
                                                <option value="10"
                                                        selected="selected"><?php echo $this->lang->line("10 Minutes"); ?></option>
                                                <option value="15"><?php echo $this->lang->line("15 Minutes"); ?></option>
                                                <option value="20"><?php echo $this->lang->line("20 Minutes"); ?></option>
                                                <option value="25"><?php echo $this->lang->line("25 Minutes"); ?></option>
                                                <option value="30"><?php echo $this->lang->line("30 Minutes"); ?></option>
                                                <option value="35"><?php echo $this->lang->line("35 Minutes"); ?></option>
                                                <option value="40"><?php echo $this->lang->line("40 Minutes"); ?></option>
                                                <option value="45"><?php echo $this->lang->line("45 Minutes"); ?></option>
                                                <option value="50"><?php echo $this->lang->line("50 Minutes"); ?></option>
                                                <option value="55"><?php echo $this->lang->line("55 Minutes"); ?></option>
                                                <option value="60"><?php echo $this->lang->line("1 hour"); ?></option>
                                                <option value="90"><?php echo $this->lang->line("1 hour and half"); ?></option>
                                                <option value="120"><?php echo $this->lang->line("2 hours"); ?></option>
                                                <option value="150"><?php echo $this->lang->line("2 hours and half"); ?></option>
                                                <option value="180"><?php echo $this->lang->line("3 hours"); ?></option>
                                                <option value="210"><?php echo $this->lang->line("3 hours and half"); ?></option>
                                                <option value="240"><?php echo $this->lang->line("4 hours"); ?></option>
                                                <option value="270"><?php echo $this->lang->line("4 hours and half"); ?></option>
                                                <option value="300"><?php echo $this->lang->line("5 hours"); ?></option>
                                                <option value="1440"><?php echo $this->lang->line("1 day"); ?></option>
                                                <option value="2880"><?php echo $this->lang->line("2 days"); ?></option>
                                                <option value="4320"><?php echo $this->lang->line("3 days"); ?></option>
                                                <option value="7200"><?php echo $this->lang->line("5 days"); ?></option>
                                                <option value="8640"><?php echo $this->lang->line("6 days"); ?></option>
                                                <option value="10080"><?php echo $this->lang->line("7 days"); ?></option>
                                                <option value="43200"><?php echo $this->lang->line("1 month"); ?></option>
                                                <option value="86400"><?php echo $this->lang->line("2 months"); ?></option>
                                                <option value="259200"><?php echo $this->lang->line("6 months"); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="postDayOff"><?php echo $this->lang->line("Do not post on day(s)"); ?></label>
                                            <select name="postDayOff" class="select2 form-control" id="postDayOff"
                                                    multiple style="width:100%;">
                                                <option value="Saturday"><?php echo $this->lang->line("Saturday"); ?></option>
                                                <option value="Sunday"><?php echo $this->lang->line("Sunday"); ?></option>
                                                <option value="Monday"><?php echo $this->lang->line("Monday"); ?></option>
                                                <option value="Tuesday"><?php echo $this->lang->line("Tuesday"); ?></option>
                                                <option value="Wednesday"><?php echo $this->lang->line("Wednesday"); ?></option>
                                                <option value="Thursday"><?php echo $this->lang->line("Thursday"); ?></option>
                                                <option value="Friday"><?php echo $this->lang->line("Friday"); ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="recyclePost">
                                                <?php echo $this->lang->line('Repost') ?>
                                                <a href="#" data-placement="top" data-toggle="popover"
                                                   data-trigger="focus" title=""
                                                   data-content="<?php echo $this->lang->line('Please provide the number below that how many times you want to repost each post again.'); ?>"
                                                   data-original-title="Repost"><i class="bx bx-info-circle"></i> </a>
                                            </label>
                                            <input id="recyclePost" class="form-control" type="number"
                                                   name="recyclePost" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="pp-social-settings" class="col-12 mt-5 text-center d-none">
                                <button id="social-settings-button" class="btn btn-primary">
                                    <?php echo $this->lang->line("Next"); ?>
                                </button>
                            </div>

                            <!-- Keeps information of settings type -->
                            <input id="settings-type" type="hidden" name="settingsType">

                        </form><!-- ends form -->

                        <!-- Spinner -->
                        <div class="xit-spinner text-primary">
                            <i class="bx bx-loader-alt bx-spin "></i>
                        </div>

                    </div><!-- ends #pp-datatable-container -->
                </div><!-- ends .card-body -->
            </div><!-- ends .card -->
        </div><!-- ends .col-12 -->
    </div><!-- ends .row -->
</div><!-- ends .section-body -->


<div class="modal fade" id="settings_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bxs-cog"></i> <?php echo $this->lang->line("Campaign Settings") ?>
                    <span id="put_feed_name"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" id="feed_setting_container"></div>

            <div class="modal-footer" style="padding-left: 30px;padding-right: 30px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_settings"><i
                            class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                <button type="button" class="btn btn-primary" id="save_settings" style="margin-left: 0;"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaigns"); ?></button>
            </div>

            <!-- Spinner -->
            <div class="xit-spinner text-primary">
                <i class="bx bx-loader-alt bx-spin "></i>
            </div>
        </div>
    </div>
</div>
