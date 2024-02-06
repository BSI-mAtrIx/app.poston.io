<?php
$include_upload = 1;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
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
$redirect_url = site_url('');

$full_message_json = $xdata['message'];
$full_message_array = json_decode($full_message_json, true);

$image_upload_limit = 1;
if ($this->config->item('messengerbot_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('messengerbot_image_upload_limit');

$video_upload_limit = 5;
if ($this->config->item('messengerbot_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('messengerbot_video_upload_limit');

$audio_upload_limit = 3;
if ($this->config->item('messengerbot_audio_upload_limit') != '')
    $audio_upload_limit = $this->config->item('messengerbot_audio_upload_limit');

$file_upload_limit = 2;
if ($this->config->item('messengerbot_file_upload_limit') != '')
    $file_upload_limit = $this->config->item('messengerbot_file_upload_limit');

?>

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
                                href="<?php echo base_url("messenger_bot_broadcast/otn_subscriber_broadcast_campaign"); ?>"><?php echo $this->lang->line("OTN Subscriber Broadcast"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    .multi_layout {
        margin: 0;
        background: #fff
    }

    .multi_layout .card {
        margin-bottom: 0;
        border-radius: 0;
    }

    .multi_layout {
        border: .5px solid #dee2e6;
    }

    .multi_layout .collef, .multi_layout .colmid {
        padding-left: 0px;
        padding-right: 0px;
        border-right: .5px solid #dee2e6;
    }

    .multi_layout .colmid .card-icon {
        border: .5px solid #dee2e6;
    }

    .multi_layout .colmid .card-icon i {
        font-size: 30px !important;
    }

    .multi_layout .main_card {
        box-shadow: none !important;
    }

    .multi_layout .mCSB_inside > .mCSB_container {
        margin-right: 0;
    }

    .multi_layout .card-statistic-1 {
        border: .5px solid #dee2e6;
        border-radius: 4px;
    }

    .multi_layout h6.page_name {
        font-size: 14px;
    }

    .multi_layout .card .card-header input {
        max-width: 100% !important;
    }

    .multi_layout .card .card-header h4 a {
        font-weight: 700 !important;
    }

    .multi_layout .card-primary {
        margin-top: 35px;
        margin-bottom: 15px;
    }

    .multi_layout .product-details .product-name {
        font-size: 12px;
    }

    .multi_layout .margin-top-50 {
        margin-top: 70px;
    }

    .multi_layout .waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .multi_layout .waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
    }

    /*   .emojionearea, .emojionearea.form-control
      {
        height: 120px !important;
      } */

    /*  .emojionearea.small-height
     {
       height: 120px !important;
     } */
    .button_border {
        padding: 35px 15px 15px 15px;
        margin: 5px 0px 0px;
        border: 1px dashed #ccc;
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

<div class='text-center'
     style='padding:12px;border:.5px solid #dee2e6; color:#6777ef;background: #fff;'><?php echo $this->lang->line("The Messenger Platform's One-Time Notification allows a page to request a user to send one follow-up message after 24-hour messaging window have ended. The user will be offered to receive a future notification. Once the user asks to be notified, the page will receive a token which is an equivalent to a permission to send a single message to the user. The token can only be used once and will expire within 1 year of creation."); ?>
</div>

<div class="row multi_layout">

    <div class="col-12 col-md-8 col-lg-8 collef">
        <form action="#" enctype="multipart/form-data" id="messenger_bot_form" method="post">

            <input type="hidden" name="csrf_token" id="csrf_token"
                   value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

            <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $xdata['id']; ?>">
            <div class="card main_card">
                <div class="card-header">
                    <h4><i class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Campaign Details"); ?></h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <?php echo $this->lang->line("Campaign Name") ?>
                                </label>
                                <input type="text" name="campaign_name" id="campaign_name" class="form-control"
                                       value="<?php echo $xdata['campaign_name']; ?>">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <?php echo $this->lang->line("Select Page"); ?>
                                </label>
                                <input type="hidden" name="fb_page_id" id="fb_page_id">
                                <select class="select2 form-control" id="page" name="page">
                                    <option value=""><?php echo $this->lang->line("Select Page"); ?></option>
                                    <?php
                                    foreach ($page_info as $key => $val) {
                                        $id = $val['id'];
                                        $page_name = $val['page_name'];
                                        echo "<option value='{$id}' data-count='" . $val['current_subscribed_lead_count'] . "'>{$page_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden" id="otn_postback_div">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label style="width:100%">
                                    <?php echo $this->lang->line("OTN postback template") ?>
                                </label>
                                <span id="otn_postback_section"><?php echo $this->lang->line("Loading OTN templates..."); ?></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="broadcast_type" id="broadcast_type" value="OTN">
                    <input type="hidden" name="message_tag" id="message_tag" value="">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>
                                <?php echo $this->lang->line("Targeting Options"); ?>
                            </h4>
                        </div>
                        <div class="card-body">

                            <div class="row hidden" id="dropdown_con">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label style="width:100%">
                                            <?php echo $this->lang->line("Target by Labels") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("Choose Labels"); ?>"
                                               data-content="<?php echo $this->lang->line("If you do not want to send to all page subscriber then you can target by labels."); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <span id="first_dropdown"><?php echo $this->lang->line("Loading labels..."); ?></span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label style="width:100%">
                                            <?php echo $this->lang->line("Exclude by Labels") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("Exclude Labels"); ?>"
                                               data-content="<?php echo $this->lang->line("If you do not want to send to a specific label, you can mention it here. Unsubscribe label will be excluded automatically."); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <span id="second_dropdown"><?php echo $this->lang->line("Loading labels..."); ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="row">

                                <div class="form-group col-12 col-md-3">
                                    <label>
                                        <?php echo $this->lang->line("Gender"); ?>

                                    </label>
                                    <?php
                                    $gender_list = array("" => $this->lang->line("Select"), "male" => "Male", "female" => "Female");
                                    echo form_dropdown('user_gender', $gender_list, $xdata['user_gender'], ' class="select2 form-control" id="user_gender"');
                                    ?>
                                </div>


                                <div class="form-group col-12 col-md-5">
                                    <label><?php echo $this->lang->line("Time Zone") ?></label>
                                    <?php
                                    $time_zone_numeric[''] = $this->lang->line("Select");
                                    echo form_dropdown('user_time_zone', $time_zone_numeric, $xdata['user_time_zone'], ' class="select2 form-control" id="user_time_zone"');
                                    ?>
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <label><?php echo $this->lang->line("Locale") ?></label>
                                    <?php
                                    $locale_list[''] = $this->lang->line("Select");
                                    echo form_dropdown('user_locale', $locale_list, $xdata['user_locale'], ' class="select2 form-control" id="user_locale"');
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br><br>

                    <?php
                    $postback_id_array = array();
                    foreach ($postback_ids as $value) {
                        $postback_id_array[] = strtoupper($value['postback_id']);
                    }
                    ?>

                    <?php
                    for ($k = 1; $k <= 1; $k++) {
                        $full_message[$k] = isset($full_message_array['message']) ? $full_message_array['message'] : array();

                        ?>
                        <div class="card card-primary" id="multiple_template_div_<?php echo $k; ?>"
                            <?php
                            if ($k != 1)
                                echo "style='display : none;'";
                            ?>
                        >
                            <div class="card-header">
                                <h4 class="full_width"><i class='bx bx-file'></i>
                                    <?php
                                    if ($k == 1)
                                        echo $this->lang->line("Message Template");
                                    ?>
                                </h4>
                            </div>
                            <div class="card-body">

                                <div>

                                    <br/>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" style="font-weight: bold;">
                                                <?php echo $this->lang->line("Select Message Type") ?>
                                            </div>
                                        </div>
                                        <select class="form-control form-control-new"
                                                id="template_type_<?php echo $k; ?>"
                                                name="template_type_<?php echo $k; ?>">
                                            <?php
                                            $template_type = $xdata['template_type'];
                                            foreach ($templates as $key => $value) {
                                                if ($template_type == $value) $selected = 'selected';
                                                else $selected = '';
                                                echo '<option value="' . $value . '" ' . $selected . '>' . $this->lang->line($value) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <br/>

                                    <div class="row" id="text_div_<?php echo $k; ?>">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your message"); ?></label>

                                                <span class='float-right'>
	                      <a title="<?php echo $this->lang->line("You can include {{last_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_last_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
	                    </span>
                                                <span class='float-right'>
	                      <a title="<?php echo $this->lang->line("You can include {{first_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
	                    </span>
                                                <div class="clearfix"></div>
                                                <textarea class="form-control" name="text_reply_<?php echo $k; ?>"
                                                          id="text_reply_<?php echo $k; ?>"><?php if ($template_type == 'text') echo $full_message[$k]['text']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="image_div_<?php echo $k; ?>" style="display: none;">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your image"); ?></label>

                                                <span class="badge badge-status blue load_preview_modal float-right"
                                                      item_type="image" file_path=""><i
                                                            class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                <input type="hidden" class="form-control"
                                                       name="image_reply_field_<?php echo $k; ?>"
                                                       id="image_reply_field_<?php echo $k; ?>"
                                                       value="<?php if ($template_type == 'image') echo $full_message[$k]['attachment']['payload']['url']; ?>">
                                                <div id="image_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                <img id="image_reply_div_<?php echo $k; ?>" style="display: none;"
                                                     height="200px;" width="400px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="audio_div_<?php echo $k; ?>" style="display: none;">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your audio"); ?></label>

                                                <span class="badge badge-status blue load_preview_modal float-right"
                                                      item_type="audio" file_path=""><i
                                                            class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                <input type="hidden" class="form-control"
                                                       name="audio_reply_field_<?php echo $k; ?>"
                                                       id="audio_reply_field_<?php echo $k; ?>"
                                                       value="<?php if ($template_type == 'audio') echo $full_message[$k]['attachment']['payload']['url']; ?>">
                                                <div id="audio_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                <audio controls id="audio_tag_<?php echo $k; ?>" style="display: none;">
                                                    <source src="" id="audio_reply_div_<?php echo $k; ?>"
                                                            type="audio/mpeg">
                                                    Your browser does not support the audio tag.
                                                </audio>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="video_div_<?php echo $k; ?>" style="display: none;">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your video"); ?></label>

                                                <span class="badge badge-status blue load_preview_modal float-right"
                                                      item_type="video" file_path=""><i
                                                            class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                <input type="hidden" class="form-control"
                                                       name="video_reply_field_<?php echo $k; ?>"
                                                       id="video_reply_field_<?php echo $k; ?>"
                                                       value="<?php if ($template_type == 'video') echo $full_message[$k]['attachment']['payload']['url']; ?>">
                                                <div id="video_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                <video width="400" height="200" controls
                                                       id="video_tag_<?php echo $k; ?>" style="display: none;">
                                                    <source src="" id="video_reply_div_<?php echo $k; ?>"
                                                            type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="file_div_<?php echo $k; ?>" style="display: none;">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your file"); ?></label>

                                                <span class="badge badge-status blue load_preview_modal float-right"
                                                      item_type="file" file_path=""><i
                                                            class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                <input type="hidden" class="form-control"
                                                       name="file_reply_field_<?php echo $k; ?>"
                                                       id="file_reply_field_<?php echo $k; ?>"
                                                       value="<?php if ($template_type == 'file') echo $full_message[$k]['attachment']['payload']['url']; ?>">
                                                <div id="file_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row" id="media_div_<?php echo $k; ?>"
                                         style="display: none; margin-bottom: 10px;">
                                        <div class="col-12">

                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your media URL"); ?>
                                                    <a href="#" class="media_template_modal"
                                                       title="<?php echo $this->lang->line("How to get meida URL?"); ?>"><i
                                                                class='bx bx-info-circle'></i> </a>
                                                </label>

                                                <div class="clearfix"></div>
                                                <input class="form-control" name="media_input_<?php echo $k; ?>"
                                                       id="media_input_<?php echo $k; ?>"
                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['url']; ?>"/>
                                            </div>

                                            <?php $media_add_button_display = 0;
                                            for ($i = 1; $i <= 3; $i++) : ?>
                                                <div class="row button_border"
                                                     id="media_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                    $media_add_button_display++;
                                                } ?> >
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="media_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="media_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                            <select class="form-control media_type_class"
                                                                    id="media_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                    name="media_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web URL"); ?></option>


                                                                <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Birthday"); ?></option>


                                                                <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("Call Us"); ?></option>

                                                                <?php if ($has_broadcaster_addon == 1) : ?>
                                                                    <option value="post_back"
                                                                            id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                    <option value="post_back"
                                                                            id="resubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("re-subscribe"); ?></option>
                                                                <?php endif; ?>
                                                                <option value="post_back"
                                                                        id="human_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                <option value="post_back"
                                                                        id="robot_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-3">

                                                        <div class="form-group"
                                                             id="media_postid_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'style="display: none;"'; ?> >
                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                            <?php $pname = "media_post_id_" . $i . "_" . $k; ?>
                                                            <?php
                                                            $pdefault = (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback') ? $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] : "";
                                                            if ($pdefault == 'UNSUBSCRIBE_QUICK_BOXER')
                                                                $poption['UNSUBSCRIBE_QUICK_BOXER'] = $this->lang->line('unsubscribe');
                                                            if ($pdefault == 'RESUBSCRIBE_QUICK_BOXER')
                                                                $poption['RESUBSCRIBE_QUICK_BOXER'] = $this->lang->line('re-subscribe');
                                                            if ($pdefault == 'YES_START_CHAT_WITH_HUMAN')
                                                                $poption['YES_START_CHAT_WITH_HUMAN'] = $this->lang->line('Chat with Human');
                                                            if ($pdefault == 'YES_START_CHAT_WITH_BOT')
                                                                $poption['YES_START_CHAT_WITH_BOT'] = $this->lang->line('Chat with Robot');
                                                            ?>
                                                            <?php echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"'); ?>
                                                            <a href="" class="add_template float-left"><i
                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                            </a>
                                                            <a href="" class="ref_template float-right"><i
                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                            </a>

                                                        </div>

                                                        <div class="form-group"
                                                             id="media_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false)) echo 'style="display: none;"'; ?>>
                                                            <label><?php echo $this->lang->line("web url"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="media_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="media_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']; ?>">
                                                        </div>

                                                        <div class="form-group"
                                                             id="media_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?>>
                                                            <label><?php echo $this->lang->line("phone number"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="media_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="media_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']; ?>">
                                                        </div>

                                                    </div>

                                                    <?php if ($i != 1) : ?>
                                                        <div class="hidden-xs col-sm-2 col-md-1" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'])) if (count($full_message[$k]['attachment']['payload']['elements'][0]['buttons']) != $i) echo 'style="display: none;"'; ?>>
                                                            <br/>
                                                            <i class="bx bx-time bx-2x red item_remove"
                                                               row_id="media_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               first_column_id="media_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               second_column_id="media_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_postback="media_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_weburl="media_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_callus="media_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               counter_variable="media_counter_<?php echo $k; ?>"
                                                               add_more_button_id="media_add_button_<?php echo $k; ?>"
                                                               title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            <?php endfor; ?>

                                            <div class="row clearfix">
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($media_add_button_display == 3) echo 'style="display : none;"'; ?>
                                                            id="media_add_button_<?php echo $k; ?>"><i
                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="row" id="quick_reply_div_<?php echo $k; ?>"
                                         style="display: none; margin-bottom: 10px;">
                                        <div class="col-12">

                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your message"); ?></label>

                                                <span class='float-right'>
	                      <a title="<?php echo $this->lang->line("You can include {{last_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_last_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
	                    </span>
                                                <span class='float-right'>
	                      <a title="<?php echo $this->lang->line("You can include {{first_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
	                    </span>
                                                <div class="clearfix"></div>
                                                <textarea class="form-control" name="quick_reply_text_<?php echo $k; ?>"
                                                          id="quick_reply_text_<?php echo $k; ?>"><?php if ($template_type == 'quick reply') echo $full_message[$k]['text']; ?></textarea>
                                            </div>

                                            <?php $quickreply_add_button_display = 0;
                                            for ($i = 1; $i <= 3; $i++) : ?>
                                                <div class="row button_border"
                                                     id="quick_reply_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['quick_replies'][$i - 1])) echo 'style="display: none;"'; else {
                                                    $quickreply_add_button_display++;
                                                } ?> >
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="quick_reply_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="quick_reply_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['quick_replies'][$i - 1]['title'])) echo $full_message[$k]['quick_replies'][$i - 1]['title']; ?>" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && ($full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_phone_number' || $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_email')) echo 'readonly'; ?> >
                                                        </div>
                                                    </div>
                                                    <!-- 28/02/2018 -->
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                            <select class="form-control quick_reply_button_type_class"
                                                                    id="quick_reply_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                    name="quick_reply_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                <option value="post_back" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'text') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                <option value="phone_number" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("user phone number"); ?></option>
                                                                <option value="user_email" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_email') echo 'selected'; ?> ><?php echo $this->lang->line("user email address"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-3">
                                                        <div class="form-group"
                                                             id="quick_reply_postid_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                             style="display: none;">
                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                            <?php $pname = "quick_reply_post_id_" . $i . "_" . $k; ?>
                                                            <?php $pdefault = (isset($full_message[$k]['quick_replies'][$i - 1]['payload'])) ? $full_message[$k]['quick_replies'][$i - 1]['payload'] : ""; ?>
                                                            <?php echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"'); ?>
                                                            <a href="" class="add_template float-left"><i
                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                            </a>
                                                            <a href="" class="ref_template float-right"><i
                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                            </a>
                                                        </div>

                                                    </div>

                                                    <?php if ($i != 1) : ?>
                                                        <div class="hidden-xs col-sm-2 col-md-1" <?php if (isset($full_message[$k]['quick_replies'])) if (count($full_message[$k]['quick_replies']) != $i) echo 'style="display: none;"'; ?> >
                                                            <br/>
                                                            <i class="bx bx-time bx-2x red item_remove"
                                                               row_id="quick_reply_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               first_column_id="quick_reply_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               second_column_id="quick_reply_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_postback="quick_reply_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_weburl="" third_callus=""
                                                               counter_variable="quick_reply_button_counter_<?php echo $k; ?>"
                                                               add_more_button_id="quick_reply_add_button_<?php echo $k; ?>"
                                                               title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                        </div>
                                                    <?php endif; ?>


                                                </div>
                                            <?php endfor; ?>

                                            <div class="row clearfix">
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($quickreply_add_button_display == 3) echo 'style="display : none;"'; ?>
                                                            id="quick_reply_add_button_<?php echo $k; ?>"><i
                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" id="text_with_buttons_div_<?php echo $k; ?>"
                                         style="display: none; margin-bottom: 10px;">
                                        <div class="col-12">

                                            <div class="form-group">
                                                <label><?php echo $this->lang->line("Please provide your message"); ?></label>

                                                <span class='float-right'>
	                      <a title="<?php echo $this->lang->line("You can include {{last_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_last_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
	                    </span>
                                                <span class='float-right'>
	                      <a title="<?php echo $this->lang->line("You can include {{first_name}} variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
	                    </span>
                                                <div class="clearfix"></div>
                                                <textarea class="form-control"
                                                          name="text_with_buttons_input_<?php echo $k; ?>"
                                                          id="text_with_buttons_input_<?php echo $k; ?>"><?php if ($template_type == 'text with buttons') echo $full_message[$k]['attachment']['payload']['text']; ?></textarea>
                                            </div>

                                            <?php $textwithbutton_add_button_display = 0;
                                            for ($i = 1; $i <= 3; $i++) : ?>
                                                <div class="row button_border"
                                                     id="text_with_buttons_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                    $textwithbutton_add_button_display++;
                                                } ?> >
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="text_with_buttons_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="text_with_buttons_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['title']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                            <select class="form-control text_with_button_type_class"
                                                                    id="text_with_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                    name="text_with_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web URL"); ?></option>

                                                                <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Birthday"); ?></option>

                                                                <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>
                                                                <option value="post_back"
                                                                        id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-3">
                                                        <div class="form-group"
                                                             id="text_with_button_postid_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'style="display: none;"'; ?> >
                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                            <?php $pname = "text_with_button_post_id_" . $i . "_" . $k; ?>
                                                            <?php
                                                            $pdefault = (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback') ? $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] : "";
                                                            if ($pdefault == 'UNSUBSCRIBE_QUICK_BOXER')
                                                                $poption['UNSUBSCRIBE_QUICK_BOXER'] = $this->lang->line('unsubscribe');
                                                            if ($pdefault == 'RESUBSCRIBE_QUICK_BOXER')
                                                                $poption['RESUBSCRIBE_QUICK_BOXER'] = $this->lang->line('re-subscribe');
                                                            ?>
                                                            <?php echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"'); ?>
                                                            <a href="" class="add_template float-left"><i
                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                            </a>
                                                            <a href="" class="ref_template float-right"><i
                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                            </a>
                                                        </div>
                                                        <div class="form-group"
                                                             id="text_with_button_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false)) echo 'style="display: none;"'; ?>>
                                                            <label><?php echo $this->lang->line("web url"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="text_with_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="text_with_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']; ?>">
                                                        </div>
                                                        <div class="form-group"
                                                             id="text_with_button_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?> >
                                                            <label><?php echo $this->lang->line("phone number"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="text_with_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="text_with_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']; ?>">
                                                        </div>
                                                    </div>

                                                    <?php if ($i != 1) : ?>
                                                        <div class="hidden-xs col-sm-2 col-md-1" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'])) if (count($full_message[$k]['attachment']['payload']['buttons']) != $i) echo 'style="display: none;"'; ?>>
                                                            <br/>
                                                            <i class="bx bx-time bx-2x red item_remove"
                                                               row_id="text_with_buttons_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               first_column_id="text_with_buttons_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               second_column_id="text_with_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_postback="text_with_button_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_weburl="text_with_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_callus="text_with_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               counter_variable="text_with_button_counter_<?php echo $k; ?>"
                                                               add_more_button_id="text_with_button_add_button_<?php echo $k; ?>"
                                                               title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                        </div>
                                                    <?php endif; ?>


                                                </div>
                                            <?php endfor; ?>

                                            <div class="row clearfix">
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($textwithbutton_add_button_display == 3) echo 'style="display : none;"'; ?>
                                                            id="text_with_button_add_button_<?php echo $k; ?>"><i
                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" id="generic_template_div_<?php echo $k; ?>"
                                         style="display: none; margin-bottom: 10px;">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("Please provide your image"); ?>
                                                            <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>

                                                        <span class="badge badge-status blue load_preview_modal float-right"
                                                              item_type="image" file_path=""><i
                                                                    class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                        <input type="hidden" class="form-control"
                                                               name="generic_template_image_<?php echo $k; ?>"
                                                               id="generic_template_image_<?php echo $k; ?>"
                                                               value="<?php if ($template_type == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['image_url']; ?>"/>
                                                        <div id="generic_image_<?php echo $k; ?>"><?php echo $this->lang->line('upload'); ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("image click destination link"); ?>
                                                            <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                        <input type="text" class="form-control"
                                                               name="generic_template_image_destination_link_<?php echo $k; ?>"
                                                               id="generic_template_image_destination_link_<?php echo $k; ?>"
                                                               value="<?php if ($template_type == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['default_action']['url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['default_action']['url']; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("title"); ?></label>
                                                        <input type="text" class="form-control"
                                                               name="generic_template_title_<?php echo $k; ?>"
                                                               id="generic_template_title_<?php echo $k; ?>"
                                                               value="<?php if ($template_type == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['title']; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("sub-title"); ?></label>
                                                        <input type="text" class="form-control"
                                                               name="generic_template_subtitle_<?php echo $k; ?>"
                                                               id="generic_template_subtitle_<?php echo $k; ?>"
                                                               value="<?php if ($template_type == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['subtitle'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['subtitle']; ?>"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="float-right"><span
                                                        style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></span>
                                            <div class="clearfix"></div>
                                            <?php $generic_add_button_display = 0;
                                            for ($i = 1; $i <= 3; $i++) : ?>
                                                <div class="row button_border"
                                                     id="generic_template_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                    $generic_add_button_display++;
                                                } ?> >
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="generic_template_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="generic_template_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-3 col-md-4">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                            <select class="form-control generic_template_button_type_class"
                                                                    id="generic_template_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                    name="generic_template_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web URL"); ?></option>

                                                                <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Birthday"); ?></option>

                                                                <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>
                                                                <option value="post_back"
                                                                        id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-3">
                                                        <div class="form-group"
                                                             id="generic_template_button_postid_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'style="display: none;"'; ?> >
                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                            <?php $pname = "generic_template_button_post_id_" . $i . "_" . $k; ?>
                                                            <?php
                                                            $pdefault = (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback') ? $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] : "";
                                                            if ($pdefault == 'UNSUBSCRIBE_QUICK_BOXER')
                                                                $poption['UNSUBSCRIBE_QUICK_BOXER'] = $this->lang->line('unsubscribe');
                                                            if ($pdefault == 'RESUBSCRIBE_QUICK_BOXER')
                                                                $poption['RESUBSCRIBE_QUICK_BOXER'] = $this->lang->line('re-subscribe');
                                                            ?>
                                                            <?php echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"'); ?>
                                                            <a href="" class="add_template float-left"><i
                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                            </a>
                                                            <a href="" class="ref_template float-right"><i
                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                            </a>
                                                        </div>
                                                        <div class="form-group"
                                                             id="generic_template_button_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false)) echo 'style="display: none;"'; ?>>
                                                            <label><?php echo $this->lang->line("web url"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="generic_template_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="generic_template_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']; ?>">
                                                        </div>
                                                        <div class="form-group"
                                                             id="generic_template_button_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?> >
                                                            <label><?php echo $this->lang->line("phone number"); ?></label>
                                                            <input type="text" class="form-control"
                                                                   name="generic_template_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   id="generic_template_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                   value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']; ?>">
                                                        </div>
                                                    </div>

                                                    <?php if ($i != 1) : ?>
                                                        <div class="hidden-xs col-sm-2 col-md-1" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'])) if (count($full_message[$k]['attachment']['payload']['elements'][0]['buttons']) != $i) echo 'style="display: none;"'; ?>>
                                                            <br/>
                                                            <i class="bx bx-time bx-2x red item_remove"
                                                               row_id="generic_template_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               first_column_id="generic_template_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               second_column_id="generic_template_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_postback="generic_template_button_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_weburl="generic_template_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               third_callus="generic_template_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                               counter_variable="generic_with_button_counter_<?php echo $k; ?>"
                                                               add_more_button_id="generic_template_add_button_<?php echo $k; ?>"
                                                               title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            <?php endfor; ?>

                                            <div class="row clearfix">
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($generic_add_button_display == 3) echo 'style="display : none;"'; ?>
                                                            id="generic_template_add_button_<?php echo $k; ?>"><i
                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" id="carousel_div_<?php echo $k; ?>"
                                         style="display: none; margin-bottom: 10px;">
                                        <?php for ($j = 1; $j <= 10; $j++) : ?>
                                            <div class="col-12" id="carousel_div_<?php echo $j; ?>_<?php echo $k; ?>"
                                                 style="<?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1])) echo 'display: none;'; ?>">
                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <h4><?php echo $this->lang->line('Carousel Template') . ' ' . $j; ?></h4>
                                                    </div>
                                                    <div class="card-body">

                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("Please provide your image"); ?>
                                                                        <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>

                                                                    <span class="badge badge-status blue load_preview_modal float-right"
                                                                          item_type="image" file_path=""><i
                                                                                class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                                    <input type="hidden" class="form-control"
                                                                           name="carousel_image_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           id="carousel_image_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           value="<?php if ($template_type == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url']; ?>"/>
                                                                    <div id="generic_imageupload_<?php echo $j; ?>_<?php echo $k; ?>"><?php echo $this->lang->line('upload'); ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("image click destination link"); ?>
                                                                        <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                                    <input type="text" class="form-control"
                                                                           name="carousel_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           id="carousel_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           value="<?php if ($template_type == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['default_action']['url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['default_action']['url']; ?>"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("title"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="carousel_title_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           id="carousel_title_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           value="<?php if ($template_type == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['title']; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("sub-title"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="carousel_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           id="carousel_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           value="<?php if ($template_type == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['subtitle'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['subtitle']; ?>"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <span class="float-right"><span
                                                                    style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></span>
                                                        <div class="clearfix"></div>
                                                        <?php $carousel_add_button_display = 0;
                                                        for ($i = 1; $i <= 3; $i++) : ?>
                                                            <div class="row button_border"
                                                                 id="carousel_row_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                                $carousel_add_button_display++;
                                                            } ?>>
                                                                <div class="col-12 col-sm-3 col-md-4">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line("button text"); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="carousel_button_text_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                               id="carousel_button_text_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['title']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-3 col-md-4">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line("button type"); ?></label>
                                                                        <select class="form-control carousel_button_type_class"
                                                                                id="carousel_button_type_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                name="carousel_button_type_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>">
                                                                            <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                            <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                            <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web URL"); ?></option>


                                                                            <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                            <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                            <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?>><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                            <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?>><?php echo $this->lang->line("User's Birthday"); ?></option>


                                                                            <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>
                                                                            <option value="post_back"
                                                                                    id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-4 col-md-3">
                                                                    <div class="form-group"
                                                                         id="carousel_button_postid_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'style="display: none;"'; ?> >
                                                                        <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                        <?php $pname = "carousel_button_post_id_" . $j . "_" . $i . "_" . $k; ?>
                                                                        <?php
                                                                        $pdefault = (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback') ? $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] : "";
                                                                        if ($pdefault == 'UNSUBSCRIBE_QUICK_BOXER')
                                                                            $poption['UNSUBSCRIBE_QUICK_BOXER'] = $this->lang->line('unsubscribe');
                                                                        if ($pdefault == 'RESUBSCRIBE_QUICK_BOXER')
                                                                            $poption['RESUBSCRIBE_QUICK_BOXER'] = $this->lang->line('re-subscribe');
                                                                        ?>
                                                                        <?php echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"'); ?>
                                                                        <a href="" class="add_template float-left"><i
                                                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                        </a>
                                                                        <a href="" class="ref_template float-right"><i
                                                                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                        </a>
                                                                    </div>
                                                                    <div class="form-group"
                                                                         id="carousel_button_web_url_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false)) echo 'style="display: none;"'; ?>>
                                                                        <label><?php echo $this->lang->line("web url"); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="carousel_button_web_url_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                               id="carousel_button_web_url_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']; ?>">
                                                                    </div>
                                                                    <div class="form-group"
                                                                         id="carousel_button_call_us_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?> >
                                                                        <label><?php echo $this->lang->line("phone number"); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="carousel_button_call_us_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                               id="carousel_button_call_us_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']; ?>">
                                                                    </div>
                                                                </div>

                                                                <?php if ($i != 1) : ?>
                                                                    <div class="hidden-xs col-sm-2 col-md-1" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'])) if (count($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons']) != $i) echo 'style="display: none;"'; ?> >
                                                                        <br/>
                                                                        <i class="bx bx-time bx-2x red item_remove"
                                                                           row_id="carousel_row_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                           first_column_id="carousel_button_text_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                           second_column_id="carousel_button_type_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                           third_postback="carousel_button_post_id_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                           third_weburl="carousel_button_web_url_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                           third_callus="carousel_button_call_us_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                           counter_variable="carousel_add_button_counter_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           add_more_button_id="carousel_add_button_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                                    </div>
                                                                <?php endif; ?>

                                                            </div>
                                                        <?php endfor; ?>

                                                        <div class="row clearfix" style="padding-bottom: 10px;">
                                                            <div class="col-12 text-center">
                                                                <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($carousel_add_button_display == 3) echo 'style="display : none;"'; ?>
                                                                        id="carousel_add_button_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div> <!-- end of card body -->
                                                </div>
                                            </div>
                                        <?php endfor; ?>

                                        <div class="col-12 clearfix">
                                            <button id="carousel_template_add_button_<?php echo $k; ?>"
                                                    class="btn btn-sm btn-outline-primary float-right no_radius"><i
                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more template"); ?>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="row" id="list_div_<?php echo $k; ?>"
                                         style="display: none; padding-top: 20px;">
                                        <div class="col-12">
                                            <div class="row" id="list_with_buttons_row">
                                                <div class="col-12 col-sm-4 col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("bottom button text"); ?></label>
                                                        <input type="text" class="form-control"
                                                               name="list_with_buttons_text_<?php echo $k; ?>"
                                                               id="list_with_buttons_text_<?php echo $k; ?>"
                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['title'])) echo $full_message[$k]['attachment']['payload']['buttons'][0]['title']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-4 col-md-4">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line("bottom button type"); ?></label>
                                                        <select class="form-control list_with_button_type_class"
                                                                id="list_with_button_type_<?php echo $k; ?>"
                                                                name="list_with_button_type_<?php echo $k; ?>">
                                                            <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                            <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['type']) && $full_message[$k]['attachment']['payload']['buttons'][0]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                            <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['type']) && $full_message[$k]['attachment']['payload']['buttons'][0]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web URL"); ?></option>

                                                            <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][0]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                            <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][0]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                            <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][0]['webview_height_ratio'] == 'full') echo 'selected'; ?>><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                            <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][0]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Birthday"); ?></option>


                                                            <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['type']) && $full_message[$k]['attachment']['payload']['buttons'][0]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-4 col-md-4">
                                                    <div class="form-group"
                                                         id="list_with_button_postid_div_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][0]['payload']) || $full_message[$k]['attachment']['payload']['buttons'][0]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['buttons'][0]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['buttons'][0]['payload'] == 'RESUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['buttons'][0]['payload'] == 'YES_START_CHAT_WITH_HUMAN' || $full_message[$k]['attachment']['payload']['buttons'][0]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'style="display: none;"'; ?> >
                                                        <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                        <?php $pname = "list_with_button_post_id_" . $k; ?>
                                                        <input type="text" class="form-control push_postback"
                                                               name="list_with_button_post_id_<?php echo $k; ?>"
                                                               id="list_with_button_post_id_<?php echo $k; ?>"
                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][0]['type'] == 'postback') echo $full_message[$k]['attachment']['payload']['buttons'][0]['payload']; ?>">
                                                    </div>
                                                    <div class="form-group"
                                                         id="list_with_button_web_url_div_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][0]['url']) || (isset($full_message[$k]['attachment']['payload']['buttons'][0]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][0]['url'], 'webview_builder/get_birthdate') !== false)) echo 'style="display: none;"'; ?> >
                                                        <label><?php echo $this->lang->line("web url"); ?></label>
                                                        <input type="text" class="form-control"
                                                               name="list_with_button_web_url_<?php echo $k; ?>"
                                                               id="list_with_button_web_url_<?php echo $k; ?>"
                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['url'])) echo $full_message[$k]['attachment']['payload']['buttons'][0]['url']; ?>">
                                                    </div>
                                                    <div class="form-group"
                                                         id="list_with_button_call_us_div_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][0]['payload']) || $full_message[$k]['attachment']['payload']['buttons'][0]['type'] != 'phone_number') echo 'style="display: none;"'; ?> >
                                                        <label><?php echo $this->lang->line("phone number"); ?></label>
                                                        <input type="text" class="form-control"
                                                               name="list_with_button_call_us_<?php echo $k; ?>"
                                                               id="list_with_button_call_us_<?php echo $k; ?>"
                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][0]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][0]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['buttons'][0]['payload']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php for ($j = 1; $j <= 4; $j++) : ?>
                                            <div class="col-12" id="list_div_<?php echo $j; ?>_<?php echo $k; ?>"
                                                 style="<?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1])) echo 'display: none;'; ?> padding-top: 20px;">
                                                <div style="border: 1px dashed #ccc; background:#fcfcfc;padding:10px 15px;">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line("Please provide your reply image"); ?></label>

                                                                <span class="badge badge-status blue load_preview_modal float-right"
                                                                      item_type="image"
                                                                      file_path="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url']; ?>"><i
                                                                            class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                                <input type="hidden" class="form-control"
                                                                       name="list_image_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       id="list_image_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url']; ?>"/>
                                                                <div id="list_imageupload_<?php echo $j; ?>_<?php echo $k; ?>"><?php echo $this->lang->line('upload'); ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line("image click destination link"); ?></label>
                                                                <input type="text" class="form-control"
                                                                       name="list_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       id="list_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['default_action']['url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['default_action']['url']; ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line("title"); ?></label>
                                                                <input type="text" class="form-control"
                                                                       name="list_title_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       id="list_title_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['title']; ?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line("sub-title"); ?></label>
                                                                <input type="text" class="form-control"
                                                                       name="list_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       id="list_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['subtitle'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['subtitle']; ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endfor; ?>

                                        <div class="col-12 clearfix">
                                            <button <?php if (isset($full_message[$k]['attachment']['payload']['elements']) && count($full_message[$k]['attachment']['payload']['elements']) == 4) echo "style='display : none;'"; ?>
                                                    id="list_template_add_button_<?php echo $k; ?>"
                                                    class="btn btn-sm btn-outline-primary float-right no_radius"><i
                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more template"); ?>
                                            </button>
                                        </div>

                                    </div>


                                </div>
                            </div> <!-- end of card body -->
                        </div>
                    <?php } ?>
                    <br><br>
                    <input type="hidden" name="schedule_type" value="<?php echo $xdata['schedule_type']; ?>">

                    <div class="row">
                        <div class="form-group schedule_block_item col-12 col-md-6">
                            <label><?php echo $this->lang->line("schedule time") ?> <a href="#" data-placement="top"
                                                                                       data-toggle="popover"
                                                                                       data-trigger="focus"
                                                                                       title="<?php echo $this->lang->line("schedule time") ?>"
                                                                                       data-content="<?php echo $this->lang->line("Select date, time and time zone when you want to start this campaign.") ?>"><i
                                            class='bx bx-info-circle'></i> </a></label>
                            <input placeholder="<?php echo $this->lang->line("Choose Time"); ?>"
                                   value="<?php echo $xdata['schedule_time']; ?>" name="schedule_time"
                                   id="schedule_time" class="form-control datepicker_x" type="text"/>
                        </div>

                        <div class="form-group schedule_block_item col-12 col-md-6">
                            <label><?php echo $this->lang->line("time zone") ?></label>
                            <?php
                            $time_zone[''] = $this->lang->line("Select");
                            echo form_dropdown('time_zone', $time_zone, $xdata['timezone'], ' class="select2 form-control" id="time_zone"');
                            ?>
                        </div>
                    </div>


                </div>

                <div class="card-footer">
                    <button class="btn btn-primary" id="submit" name="submit" type="button"><i
                                class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Campaign") ?> </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12 col-md-4 col-lg-4 colmid" id="middle_column">
        <div class="card main_card">
            <div class="card-header">
                <h4><i class="bx bx-bullseye"></i> <?php echo $this->lang->line("Summary"); ?></h4>
            </div>
            <div class="card-body">
                <?php include(FCPATH . "application/n_views/messenger_tools/otn_manager/summary.php") ?>
            </div>
        </div>
    </div>
</div>

<?php
$areyousure = $this->lang->line("Are you sure?");
?>

<style type="text/css">
    .item_remove {
        margin-top: 12px;
        margin-left: -20px;
        font-size: 20px !important;
        cursor: pointer !important;
        font-weight: 200 !important;
    }

    .remove_reply {
        margin: 10px 10px 0 0;
        font-size: 25px !important;
        cursor: pointer !important;
        font-weight: 200 !important;
    }

    .add_template, .ref_template {
        font-size: 10px;
    }

    /* .emojionearea.form-control{padding-top:12px !important;} */
    .img_holder div:not(:first-child) {
        display: none;
        position: fixed;
        bottom: 87px;
        right: 40px;
    }

    .img_holder div:first-child {
        position: fixed;
        bottom: 87px;
        right: 40px;
    }

    .input-group-addon {
        border-radius: 0;
        font-weight: bold;
        /* color: orange;   */
        /*border: 1px solid #607D8B !important;*/
        border: none;
        background: none;
    }

    /* .form-control-new
    {
    border: 1px solid #607D8B;
    height: 40px;
    width:100%;
    } */
    input[type=radio].css-checkbox {
        position: absolute;
        z-index: -1000;
        left: -1000px;
        overflow: hidden;
        clip: rect(0 0 0 0);
        height: 1px;
        width: 1px;
        margin: -1px;
        padding: 0;
        border: 0;
    }

    input[type=radio].css-checkbox + label.css-label {
        padding-left: 24px;
        height: 19px;
        display: inline-block;
        line-height: 19px;
        background-repeat: no-repeat;
        background-position: 0 0;
        font-size: 19px;
        vertical-align: middle;
        cursor: pointer;

    }

    input[type=radio].css-checkbox:checked + label.css-label {
        background-position: 0 -19px;
    }

    label.css-label {
        background-image: url(<?php echo base_url('assets/images/csscheckbox.png'); ?>);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        color: #000 !important;
        font-size: 15px !important;
    }

    .css-label-container {
        padding: 10px;
        border: 1px dashed #000;
        border-radius: 5px;
    }

    .img_holder img {
        border: 1px solid #ccc;
    }

    .load_preview_modal {
        cursor: pointer !important;
    }

</style>

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
                <button data-dismiss="modal" type="button" class="btn-sm btn btn-outline-dark"><i
                            class="bx bx-sync"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("Close & Refresh List"); ?></span>
                </button>
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


<div class="modal fade" id="media_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bxs-help-circle"></i> <?php echo $this->lang->line("How to get meida URL?"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div>

                    <p><?php echo $this->lang->line("To get the Facebook URL for an image or video, do the following:"); ?></p>
                    <ul>
                        <li><?php echo $this->lang->line("Click the image or video thumbnail to open the full-size view"); ?>
                            .
                        </li>
                        <li><?php echo $this->lang->line("Copy the URL from your browser's address bar.<"); ?>/li>
                    </ul>
                    <p><?php echo $this->lang->line("Facebook URLs should be in the following base format:"); ?></p>
                    <table class='table table-condensed table-bordered table-hover table-striped'>
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line("Media Type"); ?></th>
                            <th><?php echo $this->lang->line("Media Source"); ?></th>
                            <th><?php echo $this->lang->line("URL Format"); ?></th>
                        </tr>
                        </thead>
                        <thead>
                        <tr>
                            <td><?php echo $this->lang->line("Video"); ?></td>
                            <td><?php echo $this->lang->line("Facebook Page"); ?></td>
                            <td>https://business.facebook.com/<b>PAGE_NAME</b>/videos/<b>NUMERIC_ID</b></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->lang->line("Video"); ?></td>
                            <td><?php echo $this->lang->line("Facebook Account"); ?></td>
                            <td>https://www.facebook.com/<b>USERNAME</b>/videos/<b>NUMERIC_ID</b>/</td>
                        </tr>
                        <tr>
                            <td><?php echo $this->lang->line("Image"); ?></td>
                            <td><?php echo $this->lang->line("Facebook Page"); ?></td>
                            <td>https://business.facebook.com/<b>PAGE_NAME</b>/photos/<b>NUMERIC_ID</b></td>
                        </tr>
                        <tr>
                            <td><?php echo $this->lang->line("Image"); ?></td>
                            <td><?php echo $this->lang->line("Facebook Account"); ?></td>
                            <td>https://www.facebook.com/photo.php?fbid=<b>NUMERIC_ID</b></td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
