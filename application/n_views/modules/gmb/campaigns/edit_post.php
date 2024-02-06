<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 0;
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
<?php
$file_upload_limit = 2;
if ($this->config->item('xerobiz_file_upload_limit') != '') {
    $file_upload_limit = $this->config->item('xerobiz_file_upload_limit');
}
?>
<style type="text/css">
    .card {
        margin-bottom: 0;
        border-radius: 0;
    }

    .main_card {
        box-shadow: none !important;
        height: 100%;
    }

    .collef {
        padding-right: 0px;
        border-right: 1px solid #f9f9f9;
    }

    .colmid {
        padding-left: 0px;
    }

    .card .card-header input {
        max-width: 100% !important;
    }

    .card .card-header h4 a {
        font-weight: 700 !important;
    }

    ::placeholder {
        color: white !important;
    }

    .full-documentation {
        cursor: pointer;
    }

    .input-group-prepend {
        margin-left: -1px;
    }

    .input-group-text {
        background: #eee;
    }

    .schedule_block_item label, label {
        color: #34395e !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        letter-spacing: .5px !important;
    }

    .card-body #post_tab_content {
        border: solid 1px #dee2e6;
        border-top: 0 !important;
        padding: 25px 20px;
    }
</style>
<style type="text/css" media="screen">
    /* .box-header{border-bottom:1px solid #ccc !important;margin-bottom:15px;} */
    /* .box-primary{border:1px solid #ccc !important;} */
    /* .box-footer{border-top:1px solid #ccc !important;} */
    .padding-5 {
        padding: 5px;
    }

    .padding-20 {
        padding: 20px;
    }

    .box-body, .box-footer {
        padding: 20px;
    }

    .box-header {
        padding-left: 20px;
    }

    .preview {
        font-family: helvetica, ​arial, ​sans-serif;
        padding: 20px;
    }

    /*.preLoader{ margin-bottom:30px !important; }*/
    .preview_cover_img {
        width: 45px;
        height: 45px;
        border: .5px solid #ccc;
    }

    .preview_page {
        padding-left: 7px;
        color: #365899;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
    }

    .preview_page_sm {
        padding-left: 7px;
        padding-top: 7px;
        color: #9197a3;
        font-size: 13px;
        font-weight: 300;
        cursor: pointer;
    }

    .preview_img {
        width: 100%;
        border: 1px solid #ccc;
        border-bottom: none;
        cursor: pointer;
    }

    .only_preview_img {
        width: 100%;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    .demo_preview {
        width: 100%;
        /*border: 1px solid #f5f5f5; */
        cursor: pointer;
    }

    .preview_og_info {
        position: relative;
        word-wrap: break-word;
        border: 1px solid #ccc;
        /*		box-shadow: 0px 0px 2px #ddd;
        -webkit-box-shadow: 0px 0px 2px #ddd;
        -moz-box-shadow: 0px 0px 2px #ddd;*/
        padding: 10px;
        cursor: pointer;
    }

    .preview_og_info_title {
        font-size: 23px;
        font-weight: 400;
        font-family: 'Times New Roman', helvetica, ​arial;
    }

    .preview_og_info_desc {
        margin-top: 5px;
        font-size: 13px;
    }

    .preview_og_info_link {
        position: relative;
        word-wrap: break-word;
        text-transform: uppercase;
        color: #9197a3;
        margin-top: 7px;
    }

    .preview_og_info_coupon {
        background-color: #f8f9fa;
        border: 2px dashed #dadce0;
        border-radius: 6px;
        margin-top: 12px;
        padding-bottom: 15px;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 15px;
        text-align: center;
        font-size: 20px;
    }

    .post_type {
        padding: 10px 12px;
        border: 1px solid<?php echo $THEMECOLORCODE;?>;
        font-weight: bold;
        color: <?php echo $THEMECOLORCODE;?>;
        margin-right: 2px;
    }

    .post_type.active {
        background: <?php echo $THEMECOLORCODE;?>;
        /*color: #fff;*/
    }

    .ms-choice span {
        padding-top: 2px !important;
    }

    .hidden {
        display: none;
    }

    .box-primary {
        -webkit-box-shadow: 0px 2px 14px -5px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 0px 2px 14px -5px rgba(0, 0, 0, 0.75);
        box-shadow: 0px 2px 14px -5px rgba(0, 0, 0, 0.75);
    }

    .ajax-upload-dragdrop {
        width: 100% !important;
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
                                href="<?php echo base_url('gmb'); ?>"><?php echo $this->lang->line('Google My Business'); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href='<?php echo base_url("gmb/posts"); ?>'><?php echo $this->lang->line("Post campaigns"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-7 collef">
            <div class="card main_card">
                <div class="card-header" style="border-bottom: 0;padding-bottom:0 !important;">
                    <ul class="nav nav-tabs" role="tablist" style="width:100% !important">
                        <li class="nav-item">
                            <a id="cta_post" class="nav-link post_type" data-toggle="tab" href="#ctaPost" role="tab"
                               aria-selected="false">
                                <i class="bx bx-file"></i>
                                <?php echo $this->lang->line('CTA') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="event_post" class="nav-link post_type" data-toggle="tab" href="#eventPost" role="tab"
                               aria-selected="true">
                                <i class="bx bx-link"></i>
                                <?php echo $this->lang->line("EVENT") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="offer_post" class="nav-link post_type" data-toggle="tab" href="#offerPost" role="tab"
                               aria-selected="false">
                                <i class="bx bx-image"></i>
                                <?php echo $this->lang->line("OFFER"); ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- starts card-body -->
                <div class="card-body" style="padding-top:0 !important;margin-top: -3px;">

                    <!-- starts tab-content -->
                    <div class="tab-content" id="post_tab_content">

                        <!-- starts form -->
                        <form action="" enctype="multipart/form-data" id="auto_poster_form" method="post">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Campaign Name'); ?></label>
                                <input type="input" class="form-control" name="campaign_name" id="campaign_name"
                                       value="<?php echo set_value('campaign_name', $campaign['campaign_name']); ?>">
                            </div>

                            <!-- starts cta_block -->
                            <div id="cta_block">
                                <div class="form-group">
                                    <label>
                                        <?php echo $this->lang->line('Action Type'); ?>
                                    </label>
                                    <?php
                                    if (isset($actionTypes) && count($actionTypes)) {
                                        echo form_dropdown(
                                            'cta_action_type',
                                            $actionTypes,
                                            $campaign['cta_action_type'],
                                            'class="form-control select2" id="cta_action_type" required style="width:100%;"'
                                        );
                                    }
                                    ?>
                                    <span id="cta_action_info"
                                          class="d-none text-muted small"><?php echo $this->lang->line('The number that you used to register on Google My Business will be set in the Call Now button.'); ?></span>
                                </div>
                                <div id="cta_action_box" class="form-group">
                                    <label for="cta_action_url"><?php echo $this->lang->line('Action URL: '); ?></label>
                                    <input type="url" name="cta_action_url" id="cta_action_url" class="form-control"
                                           value="<?php echo set_value('cta_action_url', $campaign['cta_action_url']); ?>">
                                </div>
                            </div>
                            <!-- ends cta_block -->

                            <!-- starts event_block -->
                            <div id="event_block" class="d-none">
                                <div class="form-group">
                                    <label for="event_post_title"><?php echo $this->lang->line('Post Title: '); ?></label>
                                    <input type="text" name="event_post_title" id="event_post_title"
                                           class="form-control"
                                           value="<?php echo set_value('event_post_title', $campaign['event_post_title']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="start_date_time"><?php echo $this->lang->line('Date Range'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="bx bx-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="start_date_time" id="start_date_time"
                                               class="form-control datepicker_x"
                                               value="<?php echo set_value('start_date_time', $campaign['start_date_time']); ?>">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><?php echo $this->lang->line('To'); ?></div>
                                        </div>
                                        <input type="text" name="end_date_time" id="end_date_time"
                                               class="form-control datepicker_x"
                                               value="<?php echo set_value('end_date_time', $campaign['end_date_time']); ?>">
                                    </div>
                                </div>
                            </div>
                            <!-- ends event_block -->

                            <!-- starts offer_block -->
                            <div id="offer_block" class="d-none">
                                <div class="form-group">
                                    <label for="offer_coupon_code"><?php echo $this->lang->line('Coupon Code: '); ?></label>
                                    <input type="text" name="offer_coupon_code" id="offer_coupon_code"
                                           class="form-control"
                                           value="<?php echo set_value('offer_coupon_code', $campaign['offer_coupon_code']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="offer_redeem_url"><?php echo $this->lang->line('Redeem URL: '); ?></label>
                                    <input type="text" name="offer_redeem_url" id="offer_redeem_url"
                                           class="form-control"
                                           value="<?php echo set_value('offer_redeem_url', $campaign['offer_redeem_url']); ?>">
                                </div>
                            </div>
                            <!-- ends offer_block -->

                            <div id="message_textarea" class="form-group">
                                <label><?php echo $this->lang->line('Summary'); ?></label>
                                <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                   title="<?php echo $this->lang->line("message") ?>"
                                   data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}">
                                    <i class='bx bx-info-circle'></i>
                                </a>
                                <textarea class="form-control" name="message" id="message"
                                          placeholder="<?php echo $this->lang->line('Type summery here...'); ?>"><?php echo set_value('summary', $campaign['summary']); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><i class="bx bx-image"></i> <?php echo $this->lang->line('Media URL'); ?></label>
                                <input class="form-control" name="media_url" id="media_url" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <div id="media_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                <br/>
                            </div>

                            <!-- location name -->
                            <div class="form-group">
                                <label>
                                    <?php echo $this->lang->line('Location Name'); ?>
                                </label>
                                <?php
                                if (count($locations) && count($campaign)) {
                                    echo form_dropdown(
                                        'location_name[]',
                                        $locations,
                                        $selected_locations,
                                        'class="form-control select2" id="location_name" style="width:100%;" multiple'
                                    );
                                }
                                ?>
                            </div>
                            <!-- ends location name -->

                            <!-- starts posting time section -->
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Posting Time") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("Posting Time") ?>"
                                               data-content="<?php echo $this->lang->line("If you schedule a campaign, system will automatically process this campaign at mentioned time and time zone. Schduled campaign may take upto 1 hour longer than your schedule time depending on server's processing.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label><br>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="schedule_type" value="now" id="schedule_type"
                                                   class="custom-switch-input" <?php echo (isset($campaign['schedule_type']) && 'now' == $campaign['schedule_type']) ? 'checked' : '' ?>>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Post Now'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- ends posting time section -->

                            <!-- starts scheduling time and timezone -->
                            <div id="schedule-post-box" class="row d-none">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Schedule time'); ?></label>
                                        <input placeholder="Time" name="schedule_time" id="schedule_time"
                                               class="form-control datepicker_x" type="text"
                                               value="<?php echo set_value('schedule_time', $campaign['schedule_time']); ?>">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>
                                            <?php echo $this->lang->line('Time zone'); ?>
                                        </label>
                                        <?php
                                        if (count($time_zone)) {
                                            $time_zone[''] = $this->lang->line('Please Select');
                                            echo form_dropdown(
                                                'time_zone',
                                                $time_zone,
                                                isset($campaign['time_zone']) ? $campaign['time_zone'] : $this->config->item('time_zone'),
                                                'class="form-control select2" id="time_zone" style="width:100%;"'
                                            );
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- ends scheduling time and timezone -->

                            <!-- clears floating divs -->
                            <div class="clearfix"></div>

                            <!-- starts create campaign button -->
                            <div class="card-footer p-0">
                                <input type="hidden" name="submitted_post_id" id="submitted_post_id"
                                       value="<?php echo $campaign['id']; ?>">
                                <input type="hidden" name="submitted_post_type" id="submitted_post_type"
                                       value="<?php echo $campaign['post_type']; ?>">
                                <button class="btn btn-primary" id="submit_post" name="submit_post" type="button"><i
                                            class="bx bx-paper-plane"></i>
                                    <?php echo $this->lang->line("Update Campaign") ?>
                                </button>
                                <a class="btn btn-light float-right" onclick='goBack("gmb/posts", 0)'>
                                    <i class="bx bx-x"></i> <?php echo $this->lang->line("Cancel") ?>
                                </a>
                            </div>
                            <!-- ends create campaign button -->

                        </form>
                        <!-- ends form -->
                    </div>
                    <!-- ends tab-content -->
                </div>
                <!-- ends card-body -->
            </div>
        </div>

        <!-- preview section -->
        <div class="col-12 col-md-5 colmid d-none d-sm-block">
            <div class="card main_card gmb-preview">
                <div class="card-header">
                    <h4><i class="bx bxl-google"></i> <?php echo $this->lang->line('Preview'); ?></h4>
                </div>
                <div class="card-body">
                    <!-- starts post_preview -->
                    <div class="post_preview">
                        <div class="post_preview_block">
                            <img src="<?php echo base_url('assets/images/demo_image.png'); ?>" class="preview_img"
                                 alt="No Image Preview">
                            <div class="preview_og_info">
                                <div class="preview_og_info_title inline-block"></div>
                                <div class="preview_og_info_date inline-block mb-2"></div>
                                <div class="preview_og_info_desc inline-block"></div>
                                <div class="preview_og_info_link inline-block"></div>
                                <div class="preview_og_info_coupon inline-block d-none">
                                    <div class="preview_coupon_code large"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted small"><?php echo $this->lang->line("This preview may differ from actual post."); ?></p>
                    </div>
                    <!-- ends post_preview -->
                </div>
            </div>
        </div>
        <!-- ends preview section -->
    </div>
</div>



