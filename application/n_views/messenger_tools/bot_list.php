<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 0;
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
//todo: 000000 before release need changes


$image_upload_limit = 1;
if ($this->config->item('messengerbot_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('messengerbot_image_upload_limit');

?>

<style type="text/css">
    .button-outline {
        background: #fff;
        border: .5px dashed #ccc;
    }

    .button-outline:hover {
        border: 1px dashed #6777EF !important;
        cursor: pointer;
    }

    .multi_layout {
        margin: 0;
        background: #fff
    }

    .multi_layout .card {
        margin-bottom: 0;
        border-radius: 0;
    }

    .multi_layout p, .multi_layout ul:not(.list-unstyled), .multi_layout ol {
        line-height: 15px;
    }

    .multi_layout .list-group li {
        padding: 15px 10px 12px 25px;
    }

    .multi_layout {
        border: .5px solid #dee2e6;
    }

    .multi_layout .collef, .multi_layout .colmid, .multi_layout .colrig {
        padding-left: 0px;
        padding-right: 0px;
    }

    .multi_layout .collef, .multi_layout .colmid {
        border-right: .5px solid #dee2e6;
    }

    .multi_layout .main_card {
        min-height: 500px;
        box-shadow: none;
    }

    .multi_layout .collef .makeScroll {
        max-height: 790px;
        overflow: auto;
    }

    .multi_layout .list-group {
        padding-top: 6px;
    }

    .multi_layout .list-group .list-group-item {
        border-radius: 0;
        border: .5px solid #dee2e6;
        border-left: none;
        border-right: none;
        cursor: pointer;
        z-index: 0;
    }

    .multi_layout .list-group .list-group-item:first-child {
        border-top: none;
    }

    .multi_layout .list-group .list-group-item:last-child {
        border-bottom: none;
    }

    .multi_layout .list-group .list-group-item.active {
        border: .5px solid #6777EF;
    }

    .multi_layout .mCSB_inside > .mCSB_container {
        margin-right: 0;
    }

    .multi_layout .card-statistic-1 {
        border-radius: 0;
    }

    .multi_layout h6.page_name {
        font-size: 14px;
    }

    .multi_layout .card .card-header input {
        max-width: 100% !important;
    }

    .multi_layout .waiting, .modal_waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .multi_layout .waiting i, .modal_waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
    }

    .multi_layout .card .card-header h4 a {
        font-weight: 700 !important;
    }

    .product-item .product-name {
        font-weight: 500;
    }

    .badge-status {
        border-color: #eee;
    }

    /* #right_column_title i{font-size: 17px;} */

    .smallspace {
        padding: 10px 0;
    }

    .lead_first_name, .lead_last_name, .lead_tag_name {
        background: #fff !important;
    }

    .getstarted_lead_first_name, .getstarted_lead_last_name, .getstarted_lead_tag_name {
        background: #fff !important;
    }

    .ajax-file-upload-statusbar {
        width: 100% !important;
    }

    hr {
        margin-top: 10px;
    }

    .custom-top-margin {
        margin-top: 20px;
    }

    .sync_page_style {
        margin-top: 8px;
    }

    /* .wrapper,.content-wrapper{background: #fafafa !important;} */
    .well {
        background: #fff;
    }

    .emojionearea, .emojionearea.form-control {
        height: 140px !important;
    }

    .emojionearea.small-height {
        height: 140px !important;
    }

    /*import bot modal section*/
    .radio_check {
        display: block;
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none
    }

    .radio_check input {
        position: absolute;
        opacity: 0;
        cursor: pointer
    }

    .checkmark {
        position: absolute;
        top: 0px;
        right: 0;
        height: 18px;
        width: 18px;
        background-color: #ccc;
    }

    .radio_check:hover input ~ .checkmark {
        background-color: #eee
    }

    .radio_check input:checked ~ .checkmark {
        background-color: #2196F3
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none
    }

    .radio_check input:checked ~ .checkmark:after {
        display: block
    }

    .radio_check .checkmark:after {
        top: 5px;
        left: 5px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #fff
    }

    .template_sec {
        border: 1px solid #dcd7d7;
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
        padding-right: 0;
        overflow: hidden;
    }

    .template_img_section img {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px
    }

    .template_body_section {
        height: 94px;
        padding: 3px 10px 0 10px;
        border-left: none
    }

    .description_section {
        font-size: 10px;
        text-align: justify
    }

    .author-box .author-box-name {
        font-size: 14px;
    }

    .author-box .author-box-picture {
        width: 80px;
    }

    .type3 .ajax-upload-dragdrop {
        text-align: center;
    }

    .type3 .ajax-file-upload-filename {
        width: 100% !important;
    }

    .show > .dropdown-menu {
        z-index: 9999999;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: #fff;
        color: #6777ef;
        height: 30px;
        line-height: 27px;
        border: 1px solid #6777ef !important;
    }

    .single_question_block {
        border: .5px dashed #ccc;
        padding: 10px;
        margin-bottom: 15px;
    }

    .add_more_question_block {
        margin-top: 5px;
    }

    #ice_breaker_info {
        cursor: pointer;
    }

    #middle_column_content .card-icon {
        display: none;
    }

    #middle_column_content .card-footer {
    }

    #middle_column_content .card .card-body {
        padding: 20px 15px 0 15px;
    }

    #middle_column_content .card .card-body .card-title {
        margin-bottom: 0;
    }

    #middle_column_content .card-footer a {
        width: 100%;
        text-align: left !important;
        margin-bottom: 15px;
    }

    #middle_column_content .card-footer a span {
        float: right;
    }

    #middle_column_content .dropdown-toggle {
        color: #5A8DEE;
        cursor: pointer;
    }

    div.tooltip {
        top: 0px !important;
    }

    #middle_column_content .card .active {
        background-color: <?php echo $n_config['primary_color']; ?> !important;
    }

    #middle_column_content .card .active h5.card-title,
    #middle_column_content .card .active a {
        color: #fff;
    }

    #action_button_settings_lists .card h5 {
        border-bottom: 2px solid transparent;
        padding-bottom: 10px;
    }

    #action_button_settings_lists .card h5:hover {
        border-bottom: 2px solid <?php echo $n_config['primary_color']; ?> !important;
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

                    <?php if ($media_type == 'ig') {
                        ?>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("bot_instagram"); ?>"><?php echo $this->lang->line("Instagram Bot"); ?></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("messenger_bot/bot_menu_section"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                        </li>
                        <?php
                    } ?>

                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
<?php if (!empty($page_info)) { ?>
    <fieldset class="form-group" id="store_list_field">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"
                       for="bot_list_select"><?php if ($media_type == 'ig') echo $this->lang->line("Accounts"); else echo $this->lang->line("Pages"); ?></label>
            </div>
            <select class="form-control select2" id="bot_list_select">

                <?php $i = 0;
                $current_store_data = array();
                foreach ($page_info as $value) {
                    if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                    ?>
                    <option value="<?php echo $value['id']; ?>" <?php if ($i == 0 || $value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
                        <?php
                        if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")) {
                            if (isset($media_type) && $media_type == "ig") {
                                echo $value['insta_username'] . " [" . $value['page_name'] . "]";
                            } else {
                                echo $value['page_name'];
                            }
                        } else {
                            echo $value['page_name'];
                        }
                        ?>
                    </option>

                    <?php $i++;
                } ?>
            </select>
        </div>
    </fieldset>
<?php } ?>
    </div>

    <div class="col-sm-12 col-md-6">
        <?php if ($selected_global_media_type == 'fb') { ?>
            <a href="#" class="btn btn-primary social_switch mb-1"
               data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>
        <?php } else { ?>
            <a href="#" class="btn btn-primary social_switch mb-1"
               data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>
        <?php } ?>
    </div>
</div>


<?php if (empty($page_info)) { ?>

    <div class="card" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-fluid" style="height: 200px"
                     src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("We could not find any page."); ?></h2>
                <p class="lead"><?php echo $this->lang->line("Please import account if you have not imported yet.") . "<br>" . $this->lang->line("If you have already imported account then enable bot connection for one or more page to continue.") ?></p>
                <a href="<?php echo base_url('social_accounts'); ?>" class="btn btn-outline-primary mt-4"><i
                            class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line("Continue"); ?></a>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="row multi_layout">


        <div class="col-12 col-md-7 col-lg-3 colmid" id="middle_column">

            <div class="text-center waiting">
                <i class="bx bx-loader-alt bx-spin blue text-center"></i>
            </div>

            <div id="middle_column_content"></div>
        </div>

        <div class="col-12 col-md-12 col-lg-9 colrig" id="right_column">

            <div class="text-center waiting">
                <i class="bx bx-loader-alt bx-spin blue text-center"></i>
            </div>

            <div class="card main_card">
                <div class="card-header padding-left-10 padding-right-10">
                    <div class="col-12 p-0">
                        <h4 id="right_column_title"></h4>
                    </div>
                    <?php if ($custom_field_exist == 'yes') : ?>
                        <div class="col-12 col-md-6 p-0 text-md-left mb-1">
                            <a class="btn btn-outline-primary variables" href="#"><i
                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Variables'); ?></a>
                        </div>
                    <?php else : ?>
                        <div class="col-12 col-md-6 p-0 text-md-left mb-1">
                        </div>
                    <?php endif; ?>
                    <div class="col-12 col-md-4 p-0 text-md-right mb-1">
                        <a href="#" data-toggle="dropdown"
                           class="btn btn-outline-primary dropdown-toggle"><?php echo $this->lang->line("Options"); ?></a>
                        <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <div class="dropdown-header"><?php echo $this->lang->line("Actions"); ?></div>

                            <?php if ($media_type != 'ig') : ?>
                                <li><a class="dropdown-item has-icon analytics_page" href="#"> <i
                                                class="bx bx-bar-chart mr-1"></i> <?php echo $this->lang->line("Page Analytics"); ?>
                                    </a></li>
                                <li><a class="dropdown-item has-icon analytics_bot" href="#"><i
                                                class="bx bx-pie-chart mr-1"></i> <?php echo $this->lang->line("Messenger bot analytics"); ?>
                                    </a></li>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(257, $this->module_access)) : ?>
                                <li><a class="dropdown-item has-icon export_bot" media_type="<?php echo $media_type; ?>"
                                       table_id="" href="#"><i
                                                class="bx bx-export mr-1"></i> <?php echo $this->lang->line("Export bot settings"); ?>
                                    </a></li>
                                <li><a class="dropdown-item has-icon" media_type="<?php echo $media_type; ?>"
                                       table_id=""
                                       href="<?php echo base_url('messenger_bot/saved_templates/') . $media_type; ?>"><i
                                                class="bx bx-import mr-1"></i> <?php echo $this->lang->line("Import bot settings"); ?>
                                    </a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="card-body" style="padding: 10px 17px 10px 10px;">
                    <div class="row">
                        <div class="col-12">

                            <div id="right_column_content">
                                <iframe src="" frameborder="0" width="100%"></iframe>

                                <div id="right_column_bottom_content" style="display: none;">
                                    <style>
                                        .wizard-steps .wizard-step:before {
                                            content: none !important;
                                        }
                                    </style>
                                    <div class="" id="action_button_settings_block" data-backdrop="static"
                                         data-keyboard="false" style="display: none; padding: 0px;">
                                        <div class="row" id="action_button_settings_lists"></div>
                                        <!-- <div class="row">
                      <div class="col-12 col-md-6">
                          <a href="#" class="pointer">
                            <div class="card card-large-icons card-condensed">
                              <div class="card-icon">
                                <i class="bx bx-x"></i>
                              </div>
                              <div class="card-body">
                                <h4><?php echo $this->lang->line('Checkbox Plugin'); ?></h4>
                              </div>
                            </div>
                          </a>

                      </div>
                      <div class="col-12 col-md-6">
                        <a href="#" class="pointer">
                          <div class="card card-large-icons card-condensed">
                            <div class="card-icon">
                              <i class="bx bx-paper-plane"></i>
                            </div>
                            <div class="card-body">
                              <h4><?php echo $this->lang->line('Send to Messenger'); ?></h4>
                            </div>
                          </div>
                        </a>
                      </div>
                      <div class="col-12 col-md-6">
                        <a href="#" class="pointer">
                          <div class="card card-large-icons card-condensed">
                            <div class="card-icon">
                              <i class="bx bx-link"></i>
                            </div>
                            <div class="card-body">
                              <h4><?php echo $this->lang->line('M.me Link'); ?></h4>
                            </div>
                          </div>
                        </a>
                      </div>
                      <div class="col-12 col-md-6">
                        <a href="#" class="pointer">
                          <div class="card card-large-icons card-condensed">
                            <div class="card-icon">
                              <i class="bx bx-comment"></i>
                            </div>
                            <div class="card-body">
                              <h4><?php echo $this->lang->line('Customer Chat Plugin'); ?></h4>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div> -->
                                    </div>

                                    <div class="settings_block" id="sequence_message_settings_block"
                                         data-backdrop="static" data-keyboard="false"
                                         style="display: none; padding: 0px;">
                                        <div class="row" id="sequence_message_settings_lists">
                                            <div class="col-12 col-md-6">
                                                <a href="http://localhost/xerochat/messenger_bot/edit_template/2272/1/default"
                                                   class="pointer iframed" data-height="795" target="_BLANK">
                                                    <div class="card card-large-icons card-condensed">
                                                        <div class="card-icon" style="width:70px !important;">
                                                            <i class="bx bx-bot"></i>
                                                        </div>
                                                        <div class="card-body">
                                                            <h4>Chat with Robot Template</h4>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="settings_block" id="messenger_engagement_settings_block"
                                         data-backdrop="static" data-keyboard="false"
                                         style="display: none; padding: 0px;">
                                        <div class="row" id="messenger_engagement_settings_lists"></div>
                                    </div>

                                    <div class="settings_block" id="user_input_settings_block" data-backdrop="static"
                                         data-keyboard="false" style="display: none; padding: 0px;">
                                        <div class="row" id="user_input_settings_lists"></div>
                                    </div>


                                    <div class="" id="enable_start_button_modal" data-backdrop="static"
                                         data-keyboard="false" style="display: none; padding: 0px;">
                                        <form id="getstarted_icebreaker_form" method="POST">
                                            <input type="hidden" name="ice_breaker_for" id="ice_breaker_for"
                                                   value="<?php echo $media_type; ?>">
                                            <div class="modal-dialog modal-full"
                                                 style="margin: 0 !important; min-width: 100%;">
                                                <div class="modal-content shadow-none">
                                                    <div class="modal-body p-0" id="enable_start_button_modal_body">

                                                        <div class="<?php if ($media_type == "ig") echo "hidden"; ?>">
                                                            <div class="section">
                                                                <h2 class="section-title"
                                                                    style="margin-top:0"><?php echo $this->lang->line('Get started & welcome message'); ?></h2>
                                                                <!-- <p>&nbsp;</p>                                    -->
                                                            </div>
                                                            <br>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('Get started button status'); ?></label>
                                                                <select class="form-control"
                                                                        name="started_button_enabled"
                                                                        id="started_button_enabled">
                                                                    <option value="1"><?php echo $this->lang->line("enabled"); ?></option>
                                                                    <option value="0"><?php echo $this->lang->line("disabled"); ?></option>
                                                                </select>
                                                            </div>


                                                            <div class="" id="delay_con2">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo $this->lang->line('Welcome Message'); ?>
                                                                        <a href="#" data-placement="bottom"
                                                                           data-html="true" data-toggle="popover"
                                                                           data-trigger="focus"
                                                                           title="<?php echo $this->lang->line("Welcome Message") ?>"
                                                                           data-content="<?php echo $this->lang->line("The greeting text on the welcome screen is your first opportunity to tell a person why they should start a conversation with your Messenger bot. Some things you might include in your greeting text might include a brief description of what your bot does, such as key features, or a tagline. This is also a great place to start establishing the style and tone of your bot.Greetings have a 160 character maximum, so keep it concise.") . "<br><br>" . $this->lang->line("Variables") . " : <br>{{user_first_name}}<br>{{user_last_name}}<br>{{user_full_name}}"; ?>">&nbsp;&nbsp;<i
                                                                                    class='bx bx-info-circle'></i> </a>
                                                                    </label>


                                                                    <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can include {{user_last_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                               data-toggle="tooltip" data-placement="top"
                                               class='btn-sm getstarted_lead_last_name button-outline'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                                          </span>
                                                                    <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can include {{user_first_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                               data-toggle="tooltip" data-placement="top"
                                               class='btn-sm getstarted_lead_first_name button-outline'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                                          </span>

                                                                    <div class="clearfix"></div>

                                                                    <textarea name="welcome_message"
                                                                              id="welcome_message" class="form-control"
                                                                              style="height:100px;"></textarea>
                                                                    <a href="#" target="_BLANK"
                                                                       class="btn btn-outline-warning float-right btn-sm"
                                                                       id="getstarted_button_edit_url"><i
                                                                                class="bx bx-edit"></i> <?php echo $this->lang->line("edit get started reply"); ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <br><br>
                                                        </div>


                                                        <!-- ice breaker section -->
                                                        <div class="section">
                                                            <h2 class="section-title"><?php echo $this->lang->line('Ice breakers'); ?>
                                                                <i class="bx bxs-help-circle text-primary"
                                                                   id="ice_breaker_info"></i></h2>
                                                            <p><?php echo $this->lang->line('FAQ : Frequently Asked Questions'); ?>   </p>
                                                        </div>
                                                        <br>

                                                        <div class="input-group" style="margin-bottom: 15px;">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"
                                                                     style="font-weight: bold;">
                                                                    <?php echo $this->lang->line("Ice Breakers Status"); ?>
                                                                </div>
                                                            </div>
                                                            <select class="form-control" id="ice_breaker_status"
                                                                    name="ice_breaker_status">
                                                                <option value="1"><?php echo $this->lang->line('Enabled'); ?></option>
                                                                <option value="0"><?php echo $this->lang->line('Disabled'); ?></option>
                                                            </select>
                                                        </div>

                                                        <div id="questionaries_block">

                                                        </div>


                                                        <!-- end of ice breaker section -->

                                                        <br>
                                                        <input type="hidden" name="page_info_table_id_icebreaker"
                                                               id="page_info_table_id_icebreaker">
                                                        <div class="clearfix">
                                                            <a href="#" target="_BLANK" id="enable_start_button_submit"
                                                               class="btn btn-primary float-left"><i
                                                                        class="bx bx-check-circle"></i> <?php echo $this->lang->line("save"); ?>
                                                            </a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <div class="" id="mark_seen_chat_settings" data-backdrop="static"
                                         data-keyboard="false" style="display: none; padding: 0px;">
                                        <div class="modal-dialog modal-full"
                                             style="margin: 0 !important; min-width: 100%;">
                                            <div class="modal-content shadow-none">
                                                <div class="modal-body p-0 ">

                                                    <div class="form-group <?php if ($media_type == "ig") echo "hidden"; ?>">
                                                        <label><?php echo $this->lang->line('Mark as seen status'); ?></label>
                                                        <select class="form-control" name="mark_seen_status"
                                                                id="mark_seen_status">
                                                            <option value="1"><?php echo $this->lang->line("enabled"); ?></option>
                                                            <option value="0"><?php echo $this->lang->line("disabled"); ?></option>
                                                        </select>
                                                    </div>


                                                    <div class="form-group">
                                                        <label>
                                                            <?php echo $this->lang->line('Chat with human Email'); ?>
                                                        </label>
                                                        <input type="text" class="form-control" name="chat_human_email"
                                                               id="chat_human_email">
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch custom-control-inline">
                                                            <input type="checkbox" name="no_match_found_reply"
                                                                   value="enabled" id="no_match_found_reply"
                                                                   class="custom-control-input">
                                                            <label class="custom-control-label mr-1"
                                                                   for="no_match_found_reply"></label>
                                                            <span><?php echo $this->lang->line('Reply if no match found'); ?></span>
                                                        </div>
                                                    </div>

                                                    <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(265, $this->module_access)) : ?>
                                                    <div class="<?php if ($media_type == "ig") echo "hidden"; ?>">
                                                        <h5 class="mt-4 mb-1"><?php echo $this->lang->line('Email Autoresponder Integration'); ?></h5>
                                                        <div class="row">

                                                            <div class="col-sm-6 col-12">
                                                                <div class="form-group">
                                                                    <label style="width: 100%;" for="mailchimp_list_id">
                                                                        <?php echo $this->lang->line("Select MailChimp List"); ?>
                                                                        <i
                                                                                class="bx bx-info-circle"
                                                                                data-toggle="tooltip"
                                                                                data-original-title="<?php echo $this->lang->line('Send collected email from Quick Reply to your MailChimp account list. Page Name will be added as Tag Name in your MailChimp list.'); ?>"
                                                                        ></i>
                                                                        <a href=""
                                                                           class="text-danger float-right error_log_report2"
                                                                           data-type="Email Autoresponder"
                                                                           data-service="Mailchimp">
                                                                            <i class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                        </a>
                                                                        <a
                                                                                class="float-right font-small-2"
                                                                                href="<?php echo base_url('email_auto_responder_integration/mailchimp_list'); ?>"
                                                                                target="_BLANK">
                                                                            <?php echo $this->lang->line('Add API'); ?>
                                                                        </a>
                                                                    </label>
                                                                    <select class=" form-control select2" id="mailchimp_list_id" name="mailchimp_list_id[]" multiple="">
                                                                        <?php
                                                                        // echo "<option value='0'>".$this->lang->line('Choose a List')."</option>";
                                                                        foreach ($mailchimp_list as $key => $value) {
                                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                                if (in_array($value2['table_id'], $selected_mailchimp_list_ids)) $selected = 'selected';
                                                                                else $selected = '';
                                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                                            }
                                                                            echo '</optgroup>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-12">
                                                                <div class="form-group">
                                                                    <label style="width: 100%;"  for="sendinblue_list_id2">
                                                                        <?php echo $this->lang->line("Select Sendinblue List"); ?>
                                                                        <i
                                                                                class="bx bx-info-circle"
                                                                                data-toggle="tooltip"
                                                                                data-original-title="<?php echo $this->lang->line('Select Sendinblue list where email will be sent when user signup.'); ?>"
                                                                        ></i>
                                                                        <a href=""
                                                                           class="text-danger float-right error_log_report2"
                                                                           data-type="Email Autoresponder"
                                                                           data-service="Sendinblue"><i
                                                                                    class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                        </a>
                                                                        <a
                                                                                class="float-right font-small-2"
                                                                                href="<?php echo base_url('email_auto_responder_integration/sendinblue_list'); ?>"
                                                                                target="_BLANK"><?php echo $this->lang->line('Add API'); ?>
                                                                        </a>
                                                                    </label>
                                                                    <select class="select2 form-control"
                                                                            id="sendinblue_list_id2"
                                                                            name="sendinblue_list_id2[]" multiple="">
                                                                        <?php
                                                                        // echo "<option value='0'>".$this->lang->line('Choose a List')."</option>";
                                                                        foreach ($sendinblue_list as $first_key => $first_value) {
                                                                            echo '<optgroup label="' . addslashes($first_value['tracking_name']) . '">';
                                                                            foreach ($first_value['data'] as $second_key => $second_value) {
                                                                                if (in_array($second_value['table_id'], $selected_sendinblue_list_ids)) $selected = 'selected';
                                                                                else $selected = '';
                                                                                echo "<option value='" . $second_value['table_id'] . "' " . $selected . ">" . $second_value['list_name'] . "</option>";
                                                                            }
                                                                            echo '</optgroup>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-12">
                                                                <div class="form-group">
                                                                    <label style="width: 100%;" for="activecampaign_list_id2">
                                                                        <?php echo $this->lang->line("Select Activecampaign List"); ?>
                                                                        <i
                                                                                class="bx bx-info-circle"
                                                                                data-toggle="tooltip"
                                                                                data-original-title="<?php echo $this->lang->line('Select Activecampaign list where email will be sent when user signup.'); ?>"
                                                                        ></i>
                                                                        <a href="" class="text-danger float-right error_log_report2"
                                                                           data-type="Email Autoresponder"
                                                                           data-service="Activecampaign"><i
                                                                                    class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                        </a>
                                                                        <a
                                                                                class="float-right font-small-2"
                                                                                href="<?php echo base_url('email_auto_responder_integration/activecampaign_list'); ?>"
                                                                                target="_BLANK"><?php echo $this->lang->line('Add API'); ?>
                                                                        </a>
                                                                    </label>
                                                                    <select class="select2 form-control"
                                                                            id="activecampaign_list_id2"
                                                                            name="activecampaign_list_id2[]" multiple="">
                                                                        <?php
                                                                        // echo "<option value='0'>".$this->lang->line('Choose a List')."</option>";
                                                                        foreach ($activecampaign_list as $key => $value) {
                                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                                if (in_array($value2['table_id'], $selected_activecampaign_list_ids)) $selected = 'selected';
                                                                                else $selected = '';
                                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                                            }
                                                                            echo '</optgroup>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-12">
                                                                <div class="form-group">
                                                                    <label style="width: 100%;" for="mautic_list_id2">
                                                                        <?php echo $this->lang->line("Select Mautic List"); ?>
                                                                        <i
                                                                                class="bx bx-info-circle"
                                                                                data-toggle="tooltip"
                                                                                data-original-title="<?php echo $this->lang->line('Select Mautic list where email will be sent when user signup. Page name will be added as tag name in your Mautic list.'); ?>"
                                                                        ></i>
                                                                        <a href="" class="text-danger float-right error_log_report2"
                                                                           data-type="Email Autoresponder" data-service="Mautic"><i
                                                                                    class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                        </a>
                                                                        <a
                                                                                class="float-right font-small-2"
                                                                                href="<?php echo base_url('email_auto_responder_integration/mautic_list'); ?>"
                                                                                target="_BLANK"><?php echo $this->lang->line('Add API'); ?>
                                                                        </a>
                                                                    </label>
                                                                    <select class="select2 form-control" id="mautic_list_id2"
                                                                            name="mautic_list_id2[]" multiple="">
                                                                        <?php
                                                                        // echo "<option value='0'>".$this->lang->line('Choose a List')."</option>";
                                                                        foreach ($mautic_list as $key => $value) {
                                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                                if (in_array($value2['table_id'], $selected_mautic_list_ids)) $selected = 'selected';
                                                                                else $selected = '';
                                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                                            }
                                                                            echo '</optgroup>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-12">
                                                                <div class="form-group">
                                                                    <label style="width: 100%;" for="sendinblue_list_id2">
                                                                        <?php echo $this->lang->line("Select Acelle List"); ?>
                                                                        <i
                                                                                class="bx bx-info-circle"
                                                                                data-toggle="tooltip"
                                                                                data-original-title="<?php echo $this->lang->line('Select Acelle list where email will be sent when user signup.'); ?>"
                                                                        ></i>
                                                                        <a href="" class="text-danger float-right error_log_report2"
                                                                           data-type="Email Autoresponder" data-service="Acelle"><i
                                                                                    class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                        </a>
                                                                        <a
                                                                                class="float-right font-small-2"
                                                                                href="<?php echo base_url('email_auto_responder_integration/acelle_list'); ?>"
                                                                                target="_BLANK"><?php echo $this->lang->line('Add API'); ?>
                                                                        </a>
                                                                    </label>
                                                                    <select class="select2 form-control" id="acelle_list_id2"
                                                                            name="acelle_list_id2[]" multiple="">
                                                                        <?php
                                                                        // echo "<option value='0'>".$this->lang->line('Choose a List')."</option>";
                                                                        foreach ($acelle_list as $key => $value) {
                                                                            echo '<optgroup label="' . addslashes($value['tracking_name']) . '">';
                                                                            foreach ($value['data'] as $key2 => $value2) {
                                                                                if (in_array($value2['table_id'], $selected_acelle_list_ids)) $selected = 'selected';
                                                                                else $selected = '';
                                                                                echo "<option value='" . $value2['table_id'] . "' " . $selected . ">" . $value2['list_name'] . "</option>";
                                                                            }
                                                                            echo '</optgroup>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                    </div>
                                                </div>
                                                <?php endif; ?>

                                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(264, $this->module_access)) : ?>
                                                    <div class="mt-4 <?php if ($media_type == "ig") echo "hidden"; ?>">

                                                        <div class="section">
                                                            <h5 class="section-title"><?php echo $this->lang->line('SMS Integration'); ?></h5>
                                                        </div>

                                                        <div class="form-group">
                                                            <label style="width: 100%;">
                                                                <?php echo $this->lang->line("Select SMS API"); ?>
                                                                <i
                                                                        class="bx bx-info-circle"
                                                                        data-toggle="tooltip"
                                                                        data-original-title="<?php echo $this->lang->line('Send automated SMS to users who provide phone number through Quick Reply.'); ?>"
                                                                ></i>


                                                                <a href=""
                                                                   class="text-danger float-right error_log_report2"
                                                                   data-type="SMS Sender"><i
                                                                            class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                </a>
                                                                <a
                                                                        class="float-right font-small-2"
                                                                        href="<?php echo base_url('sms_email_manager/sms_api_lists'); ?>"
                                                                        target="_BLANK"><?php echo $this->lang->line('Add SMS API'); ?></a>
                                                            </label>

                                                            <select class="select2 form-control" id="sms_api_id"
                                                                    name="sms_api_id">
                                                                <option value=''><?php echo $this->lang->line('Select API'); ?></option>
                                                                <?php
                                                                foreach ($sms_option as $id => $option) {
                                                                    $selected = '';
                                                                    if ($id == $sms_api_id) $selected = 'selected';
                                                                    echo "<option value='{$id}' {$selected}>{$option}</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="sms_reply_message"> <?php echo $this->lang->line('SMS Reply Message'); ?> </label>

                                                            <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can include {{user_last_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                               data-toggle="tooltip" data-placement="top"
                                               class='btn-sm sms_api_last_name button-outline'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                                          </span>
                                                            <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can include {{user_first_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                               data-toggle="tooltip" data-placement="top"
                                               class='btn-sm sms_api_first_name button-outline'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                                          </span>

                                                            <div class="clearfix"></div>

                                                            <textarea name="sms_reply_message" id="sms_reply_message"
                                                                      class="form-control"
                                                                      style="height:100px;"><?php echo $sms_reply_message; ?></textarea>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(263, $this->module_access)) : ?>
                                                    <div class="mt-4 <?php if ($media_type == "ig") echo "hidden"; ?>">
                                                        <div class="section">
                                                            <h5 class="section-title"><?php echo $this->lang->line('Email Integration'); ?>
                                                                <span style="font-size: 12px !important;"></span>
                                                            </h5>
                                                            <p></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label style="width: 100%;">
                                                                <?php echo $this->lang->line("Select Email API"); ?>
                                                                <i
                                                                        class="bx bx-info-circle"
                                                                        data-toggle="tooltip"
                                                                        data-original-title="<?php echo $this->lang->line('Send automated Email to users who provide email address through Quick Reply.'); ?>"
                                                                ></i>
                                                                <a href=""
                                                                   class="text-danger float-right error_log_report2"
                                                                   data-type="Email Sender"><i
                                                                            class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                </a>
                                                                <a
                                                                        class="float-right font-small-2"
                                                                        href="<?php echo base_url('messenger_bot_broadcast/index'); ?>"
                                                                        target="_BLANK"><?php echo $this->lang->line('Add Email API'); ?></a>
                                                            </label>

                                                            <select class="select2 form-control" id="email_api_id"
                                                                    name="email_api_id">
                                                                <option value=''><?php echo $this->lang->line('Select API'); ?></option>
                                                                <?php
                                                                foreach ($email_apis as $id => $option) {
                                                                    echo "<option value='{$id}'>{$option}</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label> <?php echo $this->lang->line('Email Reply Message'); ?> </label>

                                                            <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can include {{user_last_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                               data-toggle="tooltip" data-placement="top"
                                               class='btn-sm email_api_last_name button-outline'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                                          </span>
                                                            <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can include {{user_first_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                               data-toggle="tooltip" data-placement="top"
                                               class='btn-sm email_api_first_name button-outline'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                                          </span>

                                                            <div class="clearfix"></div>

                                                            <textarea name="email_reply_message"
                                                                      id="email_reply_message" class="form-control"
                                                                      style="height:100px;"></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>
                                                                <?php echo $this->lang->line("Email Subject"); ?>
                                                            </label>
                                                            <input type="text" id="email_reply_subject"
                                                                   name="email_reply_subject" class="form-control">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                    <?php if ($this->is_sms_email_drip_exist) : ?>
                                                        <h5 class="mt-4 mb-1 <?php if ($media_type == "ig") echo "d-none"; ?>"><?php echo $this->lang->line('Sequence Integration'); ?></h5>
                                                    <div class="row">

                                                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(270, $this->module_access)) : ?>

                                                        <div class="col-sm-6 col-12 <?php if ($media_type == "ig") echo "d-none"; ?>">
                                                            <h6><?php echo $this->lang->line('SMS Sequence Integration'); ?></h6>
                                                            <div class="form-group ">
                                                                <label style="width: 100%;" for="sequence_sms_api_id">

                                                                    <?php echo $this->lang->line("Select SMS API"); ?>
                                                                    <i
                                                                            class="bx bx-info-circle"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="<?php echo $this->lang->line('Set SMS sequence campaign for users, who provide phone number address through quick reply or post-back button.'); ?>"
                                                                    ></i>
                                                                    <a href=""
                                                                       class="text-danger float-right error_log_report2"
                                                                       data-type="Email Autoresponder"
                                                                       data-service="Mailchimp">
                                                                        <i class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                    </a>
                                                                    <a
                                                                            class="float-right font-small-2"
                                                                            href="<?php echo base_url('/integration#list-autoresponder-list'); ?>"
                                                                            target="_BLANK">
                                                                        <?php echo $this->lang->line('Add API'); ?>
                                                                    </a>
                                                                </label>
                                                                <select class="form-control select2"
                                                                        id="sequence_sms_api_id"
                                                                        name="sequence_sms_api_id" style="width:100%;">
                                                                    <option value=''><?php echo $this->lang->line('Select API'); ?></option>
                                                                    <?php
                                                                    foreach ($sms_option as $id => $option) {
                                                                        $selected = '';
                                                                        if ($id == $sequence_sms_api_id) $selected = 'selected';
                                                                        echo "<option value='{$id}' {$selected}>{$option}</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                        </div>
                                                                <div class="form-group">
                                                                    <label style="width: 100%;"><?php echo $this->lang->line("Select Sequence Campaign"); ?>
                                                                        <small><a href="" class="refresh_campaign_lists"
                                                                                  cam_type="sms"><?php echo $this->lang->line("Refresh Lists"); ?></a></small></label>
                                                                    <div id="sequence_sms_campaign_div"></div>
                                                                </div>
                                                        </div>
                                                        <?php endif; ?>

                                                        <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(271, $this->module_access)) : ?>
                                                            <div class="col-sm-6 col-12 <?php if ($media_type == "ig") echo "hidden"; ?>">
                                                                <h6><?php echo $this->lang->line('Email Sequence Integration'); ?></h6>
                                                                <div class="form-group ">
                                                                    <label style="width: 100%;" for="sequence_email_api_id">

                                                                        <?php echo $this->lang->line("Select Email API"); ?>
                                                                        <i
                                                                                class="bx bx-info-circle"
                                                                                data-toggle="tooltip"
                                                                                data-original-title="<?php echo $this->lang->line('Set email sequence campaign for users, who provide email address through quick reply or post-back button.'); ?>"
                                                                        ></i>
                                                                        <a href=""
                                                                           class="text-danger float-right error_log_report2"
                                                                           data-type="Email Autoresponder"
                                                                           data-service="Mailchimp">
                                                                            <i class="bx bx-history"></i> <?php echo $this->lang->line('API Log'); ?>
                                                                        </a>
                                                                        <a
                                                                                class="float-right font-small-2"
                                                                                href="<?php echo base_url('/integration#list-email-list'); ?>"
                                                                                target="_BLANK">
                                                                            <?php echo $this->lang->line('Add API'); ?>
                                                                        </a>
                                                                    </label>
                                                                    <select class="select2 form-control"
                                                                            id="sequence_email_api_id"
                                                                            name="sequence_email_api_id"
                                                                            style="width:100%;">
                                                                        <option value=''><?php echo $this->lang->line('Select API'); ?></option>
                                                                        <?php
                                                                        foreach ($email_apis as $id => $option) {
                                                                            $selected = '';
                                                                            if ($id == $sequence_email_api_id) $selected = 'selected';
                                                                            echo "<option value='{$id}' {$selected}>{$option}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                          </div>
                                                                    <div class="form-group">
                                                                        <label style="width: 100%;"><?php echo $this->lang->line("Select Sequence Campaign"); ?>
                                                                            <small><a href="" class="refresh_campaign_lists"
                                                                                      cam_type="email"><?php echo $this->lang->line("Refresh Lists"); ?></a></small></label>
                                                                        <div id="sequence_email_campaign_div"></div>
                                                                    </div>
                                                                </div>
                                                        <?php endif; ?>

                                                    </div>
                                                <?php endif; ?>


                                                <a href="#" id="mark_seen_save_button" class="btn btn-primary"><i
                                                            class="bx bx-check-circle"></i> <?php echo $this->lang->line("Save"); ?>
                                                </a>

                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <input type="hidden" name="hidden_media_type" id="hidden_media_type" value="<?php echo $media_type; ?>">


<?php } ?>


<div class="modal fade" id="ice_breaker_info_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bxs-help-circle"></i> <?php echo $this->lang->line('Ice Breakers Reference'); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="section">
                    <h2 class="section-title"><?php echo $this->lang->line('Client Requirements'); ?></h2>
                    <ul>
                        <li><?php echo $this->lang->line('Messenger for Android +v240'); ?></li>
                        <li><?php echo $this->lang->line('Messenger for iOS +v240'); ?></li>
                    </ul>
                </div>
                <div class="section">
                    <h2 class="section-title"><?php echo $this->lang->line('Page Profile Priority'); ?></h2>
                    <p><?php echo $this->lang->line('Some of the profile elements like Ice Breakers and Get Started button are incompatible with each other. So when both are set one will take precedence over the other. Here is the priority from highest to lowest:'); ?></p>
                    <ol>
                        <li><?php echo $this->lang->line('API Ice Breakers'); ?></li>
                        <li><?php echo $this->lang->line('Get Started button'); ?></li>
                        <li><?php echo $this->lang->line('Custom Questions set via the Page Inbox UI'); ?></li>
                    </ol>
                </div>
                <div>
                    <p>
                        <b>NB: </b><?php echo $this->lang->line('Editing Custom Questions from the Page Inbox UI is disabled when Ice Breakers are set via API. This is to prevent breaking the experience set by the installed app.'); ?>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-time"></i> <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button> -->
            </div>
        </div>
    </div>
</div>


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


<div class="modal fade" id="err-log2" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 30px;">
                <h3 class="modal-title"><i
                            class="bx bx-history"></i> <?php echo $this->lang->line("Last 7 Days API Log"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 margin-top">
                        <input type="text" id="error_searching2" name="error_searching2" class="form-control"
                               placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>
                        <input type="hidden" id="auto_responder_type" name="auto_responder_type">
                        <input type="hidden" id="autoresponder_service_name" name="autoresponder_service_name" value="">

                    </div>
                    <div class="col-12">
                        <div class="data-card">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable2">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("Settings Type"); ?></th>
                                        <th><?php echo $this->lang->line("Status"); ?></th>
                                        <th><?php echo $this->lang->line("Email/Phone"); ?></th>
                                        <th><?php echo $this->lang->line("Auto Responde Type"); ?></th>
                                        <th><?php echo $this->lang->line("API Name"); ?></th>
                                        <th><?php echo $this->lang->line("Inserted at"); ?></th>
                                        <th><?php echo $this->lang->line("Actions"); ?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="err-log" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 30px;">
                <h3 class="modal-title"><i
                            class="bx bx-bug"></i> <?php echo $this->lang->line("Last 7 Days Error Report"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- <div class="col-12 table-responsive" id="error_response_div" style="padding: 20px;"></div> -->
                    <div class="col-12 margin-top">
                        <input type="text" id="error_searching" name="error_searching" class="form-control"
                               placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>
                    </div>
                    <div class="col-12">
                        <div class="data-card">
                            <input type="hidden" name="put_page_id" id="put_page_id">
                            <input type="hidden" name="media_type_error" id="media_type_error">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable1">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("Bot Name"); ?></th>
                                        <th><?php echo $this->lang->line("Error Message"); ?></th>
                                        <th><?php echo $this->lang->line("Error Time"); ?></th>
                                        <th><?php echo $this->lang->line("Actions"); ?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="export_bot_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 30px;">
                <h3 class="modal-title"><i
                            class="bx bx-export"></i> <?php echo $this->lang->line("Export Bot Settings"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="export_bot_modal_body">

                <form id="export_bot_form" method="POST">
                    <div class="col-12">
                        <div class="well text-justify" style="border:1px solid #6777ef;padding:15px;color:#6777ef;">
                            <?php echo $this->lang->line("Webview form will not be exported/imported. If bot settings have webview form created, then after importing that bot settings for a page, you will need to create new form & change the form URL by the new URL for that page."); ?>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="export_id" id="export_id">
                    <input type="hidden" name="export_media_type" id="export_media_type">
                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Template Name'); ?> *</label>
                            <input type="text" name="template_name" class="form-control" id="template_name">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Template Description'); ?> </label>
                            <textarea type="text" rows="4" name="template_description" class="form-control"
                                      id="template_description"></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Template Preview Image'); ?> [Square image like
                                (400x400) is recommended]</label>
                            <span style="cursor:pointer;" class="badge badge-status blue load_preview_modal float-right"
                                  item_type="image" file_path=""><i
                                        class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                            <input type="hidden" name="template_preview_image" class="form-control"
                                   id="template_preview_image">
                            <div id="template_preview_image_div"><?php echo $this->lang->line("upload") ?></div>
                        </div>
                    </div>

                    <?php if ($this->session->userdata("user_type") == 'Admin') { ?>
                        <div class="col-12">

                            <div class="form-group">
                                <div class="control-label"><?php echo $this->lang->line('Template Access'); ?> *</div>
                                <div class="custom-switches-stacked mt-2">
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="template_access" value="private" id="only_me_input"
                                               class="custom-control-input" checked>
                                        <label class="custom-control-label mr-1" for="only_me_input"></label>
                                        <span><?php echo $this->lang->line("Only me"); ?></span>
                                    </div>
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="template_access" value="public" id="other_user_input"
                                               class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="other_user_input"></label>
                                        <span><?php echo $this->lang->line("Me as well as other users"); ?></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 hidden" id="allowed_package_ids_con">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Choose User Packages'); ?> *</label><br/>
                                <?php echo form_dropdown('allowed_package_ids[]', $package_list, '', 'class="select2 form-control" id="allowed_package_ids" multiple'); ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-6"><a href="#" id="export_bot_submit" class="btn btn-primary"><i
                                        class="bx bx-export"></i> <?php echo $this->lang->line("Export"); ?></a></div>
                        <div class="col-6"><a href="#" id="cancel_bot_submit" class="btn btn-secondary float-right"><i
                                        class="bx bx-x-circle"></i> <?php echo $this->lang->line("Cancel"); ?></a></div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="import_bot_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 30px;">
                <h3 class="modal-title"><i
                            class="bx bx-import"></i> <?php echo $this->lang->line("Import Bot Settings"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="import_bot_modal_body">
                <div id="preloader" class="text-center waiting hidden"><i
                            class="bx bx-loader-alt bx-spin blue text-center" style="font-size: 40px;"></i></div>

                <form id="import_bot_form" method="POST">
                    <div class="col-12">
                        <div class="well text-justify" style="border:1px solid #6777ef;padding:15px;color:#6777ef;">
                            <?php echo $this->lang->line("Webview form will not be exported/imported. If bot settings have webview form created, then after importing that bot settings for a page, you will need to create new form & change the form URL by the new URL for that page."); ?>
                        </div>
                    </div>
                    <br>

                    <input type="hidden" name="import_id" id="import_id">

                    <!-- New section -->
                    <?php if (!empty($saved_template_list)) : ?>
                        <!-- zilani -->
                        <p class="text-center"
                           style="font-weight: bold;"><?php echo $this->lang->line('Choose from previous template'); ?></p>
                        <br>
                        <div class="makeScroll" style="max-height: 520px;overflow: auto;">
                            <div class="row">

                                <?php $i = 1;
                                foreach ($saved_template_list as $key => $val) :
                                    $id = $val['id'];
                                    $template_name = isset($val['template_name']) ? $val['template_name'] : '';
                                    $description = isset($val['description']) ? $val['description'] : '';
                                    $preview_image = isset($val['preview_image']) ? $val['preview_image'] : '';
                                    $added_date = date("M j, y H:i", strtotime($val['saved_at']));
                                    ?>
                                    <div class="col-12 col-sm-6 col-md-4">
                                        <div class="card author-box">
                                            <div class="card-body" style="border:.5px solid #eee;">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="avatar-item">
                                                            <?php if ($preview_image != '' && file_exists('upload/image/' . $val['user_id'] . '/' . $preview_image)) : ?>
                                                                <a target="_BLANK"
                                                                   href="<?php echo base_url('messenger_bot/saved_template_view/' . $id); ?>"
                                                                   data-toggle='tooltip'
                                                                   title="<?php echo $this->lang->line('Click here to see template details'); ?>">
                                                                    <img alt="image" width="80" height="80"
                                                                         src="<?php echo base_url('upload/image/' . $val['user_id'] . '/' . $preview_image); ?>"
                                                                         class="rounded">
                                                                </a>
                                                            <?php else : ?>
                                                                <a target="_BLANK"
                                                                   href="<?php echo base_url('messenger_bot/saved_template_view/' . $id); ?>"
                                                                   data-toggle='tooltip'
                                                                   title="<?php echo $this->lang->line('Click here to see template details'); ?>">
                                                                    <img alt="image"
                                                                         style="width:80px !important;height:80px !important;"
                                                                         src="<?php echo base_url("assets/img/avatar/avatar-1.png"); ?>"
                                                                         class="rounded">
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-8">
                                                        <div class="author-box-details" style="margin-left: 0;">
                                                            <div class="author-box-name">
                                                                <div class="row">
                                                                    <div class="col-10">
                                                                        <h6 class="text-left">
                                                                            <?php
                                                                            if (strlen($template_name) > 17) {
                                                                                $short_template_name = substr($template_name, 0, 16);
                                                                                echo $short_template_name . "...";
                                                                            } else {
                                                                                echo $template_name;
                                                                            }
                                                                            ?>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="custom-control custom-radio"
                                                                             data-toggle='tooltip'
                                                                             title="<?php echo $this->lang->line('Click here to select this template'); ?>">
                                                                            <input type="radio" name="template_id"
                                                                                   class="post_to custom-control-input"
                                                                                   value="<?php echo $id; ?>"
                                                                                   id="<?php echo $id; ?>">
                                                                            <label class="custom-control-label"
                                                                                   for="<?php echo $id; ?>"
                                                                                   style="display:inline !important;"></label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="author-box-description" style="margin-top: 0;">
                                                                <p class="text-justify">
                                                                    <?php
                                                                    if (strlen($description) > 60) {
                                                                        $short_des = substr($description, 0, 59);
                                                                        echo $short_des . "...";
                                                                    } else {
                                                                        echo $description;
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                            <div class="w-100 d-sm-none"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; endforeach; ?>
                            </div>
                        </div>
                        <!-- zilani -->

                        <!-- <div class="container-fluid">
                    <div class="row">
                      <p class="text-center" style="font-weight: bold;"><?php echo $this->lang->line('Choose from previous template'); ?></p>
                      <div class="yscroll" style="height: 400px;overflow: auto;">
                          <?php foreach ($saved_template_list as $key => $val) :
                            $id = $val['id'];
                            $template_name = isset($val['template_name']) ? $val['template_name'] : '';
                            $description = isset($val['description']) ? $val['description'] : '';
                            $preview_image = isset($val['preview_image']) ? $val['preview_image'] : '';
                            $added_date = date("M j, y H:i", strtotime($val['saved_at']));
                            ?>

                          <div class="col-12 col-md-6">
                            <div class="box box-solid" style="">
                              <div class="box-body" style="padding-top: 10px;padding-bottom: 0;">
                                <h4 style="border:1px solid #fafafa; font-size: 15px; text-align: center; padding: 7px 10px; margin-top: 0;">
                                    <?php
                            if (strlen($template_name) > 22) {
                                $short_template_name = substr($template_name, 0, 19);
                                echo $short_template_name . "...";
                            } else {
                                echo $template_name;
                            }
                            ?>
                                        <div class="form-check float-right">
                                            <div class="clearfix"></div>
                                             <label class="radio_check">
                                               <input type="radio" name="template_id" class="post_to" value="<?php echo $id; ?>" id="<?php echo $id; ?>" >
                                               <span class="checkmark" data-toggle='tooltip' title="<?php echo $this->lang->line('Click here to select this template'); ?>" ></span>
                                             </label>
                                           </div> 
                                           <div class="clearfix"></div>
                                </h4>
                                <div class="media">
                                  <div class="media-left">
                                                                                
                                          <?php if ($preview_image != '') : ?>
                                                <a data-toggle='tooltip' title="<?php echo $this->lang->line('Click here to see template details'); ?>" target="_BLANK" href="<?php echo base_url('messenger_bot_export_import/view/' . $id); ?>">
                                                  <img style="width: 100px;height: 100px;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);" class="media-object" src="<?php echo base_url('upload/image/' . $val['user_id'] . '/' . $preview_image); ?>" alt="preview image"><br>
                                                </a>
                                                <?php else : ?>
                                                  <a data-toggle='tooltip' title="<?php echo $this->lang->line('click here to see template details'); ?>" target="_BLANK" href="<?php echo base_url('messenger_bot_export_import/view/' . $id); ?>">
                                                    <img style="width: 100px;height: 100px;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);"  class="media-object" src="https://via.placeholder.com/100x100.png" alt="preview image"><br>
                                                  </a>
                                          <?php endif; ?>
                                  </div>
                                  <div class="media-body">
                                      <div class="clearfix">
                                          <p class="text-justify">
                                            <?php
                            if (strlen($description) > 173) {
                                $short_des = substr($description, 0, 170);
                                echo $short_des . "...";
                            } else {
                                echo $description;
                            }
                            ?>
                                          </p>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php endforeach; ?>
                      </div>
                    </div>
                  </div> -->
                    <?php endif; ?>
                    <!-- end new section -->
                    <br>
                    <div class="col-12 text-center type2"
                         style="font-weight: bold;"><?php echo $this->lang->line('OR'); ?></div>
                    <br>
                    <div class="col-12 type3">
                        <div class="text-center">
                            <label><?php echo $this->lang->line('Upload Template JSON'); ?></label>
                            <div class="form-group">
                                <div id="json_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                <input type="hidden" id="json_upload_input" name="json_upload_input">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6"><a href="#" id="import_bot_submit" class="btn btn-primary"><i
                                        class="bx bx-import"></i> <?php echo $this->lang->line("Import"); ?></a></div>
                        <div class="col-6"><a href="#" id="cancel_import_bot" class="btn btn-secondary float-right"><i
                                        class="bx bx-x-circle"></i> <?php echo $this->lang->line("Cancel"); ?></a></div>
                    </div>

                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_for_preview" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-show"></i> <?php echo $this->lang->line('item preview'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="image_preview_div_modal" style="display: none;">
                    <img id="modal_preview_image" width="100%" src="">
                </div>
                <div id="video_preview_div_modal" style="display: none;">
                    <video width="100%" id="modal_preview_video" controls>

                    </video>
                </div>
                <div id="audio_preview_div_modal" style="display: none;">
                    <audio width="100%" id="modal_preview_audio" controls>

                    </audio>
                </div>
                <div>
                    <input class="form-control" type="text" id="preview_text_field">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="variable_data_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-book-reader"></i> <?php echo $this->lang->line("All Variables you currently have"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" data-backdrop="static" data-keyboard="false">
                <div class="row">
                    <div class="col-12">
                        <div class="section">
                            <div class="section-title"><?php echo $this->lang->line('Variable'); ?></div>
                            <p><?php echo $this->lang->line('After you have saved a response in Custom Field, you can use it as a variable in your message reply to subscriber.'); ?></p>
                        </div>
                        <div class="section">
                            <div class="section-title"><?php echo $this->lang->line('How to use Variable?'); ?></div>
                            <p><?php echo $this->lang->line('To use variable for Custom Field, write the variable surrounding by #  like') . "<b> #Custom Field#</b>"; ?></p>
                        </div>
                        <div class="section" id="variable_display_section">
                            <!-- content goes here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>

        </div>
    </div>
</div>
