<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
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
<?php
$redirect_url = site_url('messenger_bot/bot_settings/') . $page_info['id'] . '/1';


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

<style type="text/css">
    .card {
        border: 1px solid #f9f9f9;
    }

    .card .card-header {
        line-height: 30px;
        min-height: 0px;
        padding: 5px 25px;
    }

    .card .card-header h4 {
        font-size: 13px;
    }

    .card .card-body {
        padding-top: 0px;
    }

    .remove_reply {
        margin-right: -20px;
        margin-top: 5px;
    }

    .remove_carousel_template {
        margin-right: -20px;
        margin-top: 5px;
    }

    .button_border {
        padding: 5px 15px 0px 15px !important;
        margin: 5px 0px 0px;
        border: 1px dashed #ccc;
    }

    .item_remove {
        margin-top: 12px;
        margin-left: -20px;
        font-size: 20px !important;
        cursor: pointer !important;
        font-weight: 200 !important;
    }

    .add_template, .ref_template {
        font-size: 10px;
    }

    .emojionearea.form-control {
        padding-top: 12px !important;
    }

    .img_holder div:not(:first-child) {
        display: none;
        position: fixed;
        bottom: 187px;
        right: 40px;
    }

    .img_holder div:first-child {
        position: fixed;
        bottom: 187px;
        right: 40px;
    }

    .lead_first_name, .lead_last_name {
        background: #EEE;
        border-radius: 0;
    }

    .input-group-addon {
        border-radius: 0;
        font-weight: bold;
        /* color: orange;   */
        /*border: 1px solid #607D8B !important;*/
        border: none;
        background: none;
    }

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

        font-size: 15px !important;
    }

    .css-label-container {
        padding: 10px;
        border-radius: 5px;
    }

    .img_holder img {
        border: 1px solid #ccc;
    }

    .emojionearea.form-control, .emojionearea {
        min-height: 95px !important;
    }

    .emojionearea .emojionearea-editor {
        min-height: 80px !important;
        max-height: 80px !important;
    }

    .button-outline {
        background: #fff;
        border: .5px dashed #ccc;
    }

    .button-outline:hover {
        border: 1px dashed #6777EF !important;
        cursor: pointer;
    }

    /*  #add_bot_settings_modal .modal-body, #add_bot_settings_modal .modal-header
     {
       padding: 1px;
     } */
    .load_preview_modal {
        cursor: pointer;
    }

    .form-group label {
        width: 100%;
    }

    .select2 {
        width: 100% !important;
    }
</style>

<div class="hidden" id="add_bot_settings_modal">
    <div class="modal-dialog" style="max-width:100%;margin:0px;">
        <div class="modal-content shadow-none">
            <?php if ($iframe != '1') : ?>
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class='bx bx-plus-circle'></i> <?php echo $this->lang->line("Add Bot Reply Setting"); ?>
                        : <a target='_BLANK'
                             href='https://facebook.com/<?php echo $page_info['page_id']; ?>'><?php echo $page_info['page_name']; ?></a>
                    </h3>
                </div>
            <?php endif; ?>
            <div class="modal-body <?php if ($iframe == '1') echo 'p-0 shadow-none overflow-hidden'; ?>">

                <div class="row">
                    <div class="<?php if ($iframe == "1") echo 'col-12'; else echo 'col-12 col-md-9'; ?>">
                        <form action="#" method="post" id="messenger_bot_form" style="padding-left: 0;">
                            <input type="hidden" name="media_type" id="media_type" value="fb">
                            <input type="hidden" name="page_id" id="page_id"
                                   value="<?php echo $page_info['page_id']; ?>">
                            <input type="hidden" name="page_table_id" id="page_table_id"
                                   value="<?php echo $page_info['id']; ?>">
                            <input type="hidden" name="keyword_type" id="keyword_type" value="reply">

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Bot Name"); ?></label>
                                        <input type="text" name="bot_name" id="bot_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Please provide your keywords in comma separated"); ?></label>
                                        <input class="form-control" name="keywords_list" id="keywords_list">
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="postback_div" style="display: none;">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Please select your postback id"); ?></label>
                                        <select class="form-control" id="keywordtype_postback_id"
                                                name="keywordtype_postback_id[]">
                                            <?php
                                            $postback_id_array = array();
                                            foreach ($postback_ids as $value) {
                                                $postback_id_array[] = strtoupper($value['postback_id']);

                                                if ($value["template_for"] == "unsubscribe" || $value["template_for"] == "resubscribe" || $value["template_for"] == "email-quick-reply" || $value["template_for"] == "phone-quick-reply" || $value["template_for"] == "location-quick-reply" || $value["is_template"] == "1") continue;

                                                if ($value['use_status'] == '0') {
                                                    $array_key = $value['postback_id'];
                                                    $array_value = $value['postback_id'] . " (" . $value['bot_name'] . ")";
                                                    echo "<option value='{$array_key}'>{$array_value}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="main_reply_sort">

                                <?php for ($k = 1; $k <= 6; $k++) { ?>

                                    <div class="card card-primary"
                                         id="multiple_template_div_<?php echo $k; ?>" <?php if ($k != 1) echo "style='display : none;'"; ?> >
                                        <div class="card-header">
                                            <h4 class="container"><?php echo $this->lang->line('Reply') . " " . $k; ?>

                                                <?php if ($k != 1) : ?>
                                                    <i class="bx bx-trash remove_reply float-right text-danger pointer"
                                                       row_id="multiple_template_div_<?php echo $k; ?>"
                                                       counter_variable=""
                                                       title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                <?php endif; ?>
                                            </h4>


                                        </div>
                                        <div class="card-body">

                                            <div style="">
                                                <!-- <br/> -->
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text" style="font-weight: bold;">
                                                            <?php echo $this->lang->line("Select Reply Type") ?>
                                                        </div>
                                                    </div>
                                                    <select class="form-control form-control-new"
                                                            id="template_type_<?php echo $k; ?>"
                                                            name="template_type_<?php echo $k; ?>">
                                                        <?php
                                                        foreach ($templates as $key => $value) {
                                                            echo '<option value="' . $value . '">' . $this->lang->line($value) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <!-- <br/> -->

                                                <div class="row" id="delay_and_typing_on_<?php echo $k; ?>">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-6"><label for=""
                                                                                      style="margin-top: 8px; color: #34395e; font-size: 14px;"><?php echo $this->lang->line('Typing on display :'); ?></label>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="custom-switch mt-2 float-left">
                                                                    <input type="checkbox"
                                                                           name="typing_on_enable_<?php echo $k; ?>"
                                                                           id="typing_on_enable_<?php echo $k; ?>"
                                                                           class="custom-switch-input">
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span class="custom-switch-description"><?php echo $this->lang->line('Enable'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><?php echo $this->lang->line('Delay in reply'); ?></span>
                                                            </div>
                                                            <input type="number" min="0" value="0"
                                                                   name="delay_in_reply_<?php echo $k; ?>"
                                                                   id="delay_in_reply_<?php echo $k; ?>"
                                                                   class="form-control">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><?php echo $this->lang->line('Sec'); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <br/> -->

                                                <div class="row" id="Ecommerce_div_<?php echo $k; ?>"
                                                     style="display: none;">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Select your Ecommerce store"); ?>
                                                            </label>
                                                            <select class="form-control select2 ecommerce_store_info"
                                                                    product_dropdown_id="ecommerce_product_ids<?php echo $k; ?>"
                                                                    id="ecommerce_store_id<?php echo $k; ?>"
                                                                    name="ecommerce_store_id<?php echo $k; ?>">
                                                                <?php echo $ecommerce_stores; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Please select products for carousel/generic reply"); ?>
                                                            </label>
                                                            <select class="form-control select2 ecommerce_product_info"
                                                                    multiple="multiple"
                                                                    id="ecommerce_product_ids<?php echo $k; ?>"
                                                                    name="ecommerce_product_ids<?php echo $k; ?>[]">
                                                                <option value=""><?php echo $this->lang->line('Please select a store first.'); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Please provide 'Buy Now' button text"); ?></label>
                                                            <input type="text"
                                                                   name="ecommerce_button_text<?php echo $k; ?>"
                                                                   id="ecommerce_button_text<?php echo $k; ?>"
                                                                   class="form-control">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row" id="User_Input_Flow_div_<?php echo $k; ?>"
                                                     style="display: none;">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Please select a Flow Campaign"); ?>
                                                            </label>
                                                            <select class="form-control select2 flow_campaign_info"
                                                                    id="flow_campaign_id_<?php echo $k; ?>"
                                                                    name="flow_campaign_id_<?php echo $k; ?>">
                                                                <option value=""><?php echo $this->lang->line('Please select a Flow campaign.'); ?></option>
                                                                <?php foreach ($flow_campaigns as $value) : ?>
                                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['flow_name']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="One_Time_Notification_div_<?php echo $k; ?>"
                                                     style="display: none;">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Title"); ?>
                                                            </label>
                                                            <input class="form-control" type="text"
                                                                   name="otn_title_<?php echo $k; ?>"
                                                                   id="otn_title_<?php echo $k; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("OTN Postback"); ?>
                                                            </label>
                                                            <?php
                                                            $name_id = "otn_postback_" . $k;
                                                            echo form_dropdown($name_id, $otn_postback_list, '', 'id="' . $name_id . '" class="form-control push_otn_postback select2"');
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="text_div_<?php echo $k; ?>">
                                                    <div class="col-12">
                                                        <div class="form-group clearfix">
                                                            <label><?php echo $this->lang->line("Please provide your reply message"); ?>
                                                                <a href="#" data-placement="bottom"
                                                                   data-toggle="popover" data-trigger="focus"
                                                                   title="<?php echo $this->lang->line("Spintax"); ?>"
                                                                   data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                            class='bx bx-info-circle'></i> </a>
                                                            </label>

                                                            <span class='float-right'>
                                <a title="<?php echo $this->lang->line("You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   class='btn-sm lead_last_name button-outline'><i
                                            class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                              </span>
                                                            <span class='float-right'>
                                <a title="<?php echo $this->lang->line("You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   class='btn-sm lead_first_name button-outline'><i
                                            class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                              </span>

                                                            <div class="clearfix"></div>
                                                            <textarea class="form-control"
                                                                      name="text_reply_<?php echo $k; ?>"
                                                                      id="text_reply_<?php echo $k; ?>"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="image_div_<?php echo $k; ?>"
                                                     style="display: none;">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Please provide your reply image"); ?></label>
                                                            <input type="text"
                                                                   placeholder="<?php echo $this->lang->line('Put your image URL here or click the upload button.'); ?>"
                                                                   class="form-control"
                                                                   name="image_reply_field_<?php echo $k; ?>"
                                                                   id="image_reply_field_<?php echo $k; ?>">
                                                            <div id="image_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                            <img id="image_reply_div_<?php echo $k; ?>"
                                                                 style="display: none;" height="200px;" width="400px;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="audio_div_<?php echo $k; ?>"
                                                     style="display: none;">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Please provide your reply audio"); ?></label>
                                                            <input type="hidden" class="form-control"
                                                                   name="audio_reply_field_<?php echo $k; ?>"
                                                                   id="audio_reply_field_<?php echo $k; ?>">
                                                            <div id="audio_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                            <audio controls id="audio_tag_<?php echo $k; ?>"
                                                                   style="display: none;">
                                                                <source src="" id="audio_reply_div_<?php echo $k; ?>"
                                                                        type="audio/mpeg">
                                                                Your browser does not support the video tag.
                                                            </audio>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="video_div_<?php echo $k; ?>"
                                                     style="display: none;">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label><?php echo $this->lang->line("Please provide your reply video"); ?></label>
                                                            <input type="hidden" class="form-control"
                                                                   name="video_reply_field_<?php echo $k; ?>"
                                                                   id="video_reply_field_<?php echo $k; ?>">
                                                            <div id="video_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                            <video width="400" height="200" controls
                                                                   id="video_tag_<?php echo $k; ?>"
                                                                   style="display: none;">
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
                                                            <label><?php echo $this->lang->line("Please provide your reply file"); ?></label>
                                                            <input type="hidden" class="form-control"
                                                                   name="file_reply_field_<?php echo $k; ?>"
                                                                   id="file_reply_field_<?php echo $k; ?>">
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
                                                                   title="<?php echo $this->lang->line("How to get media URL?"); ?>"><i
                                                                            class='bx bx-info-circle'></i> </a>
                                                            </label>

                                                            <div class="clearfix"></div>
                                                            <input class="form-control"
                                                                   name="media_input_<?php echo $k; ?>"
                                                                   id="media_input_<?php echo $k; ?>"/>
                                                        </div>


                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                        <div id="media_postback_sort_<?php echo $k; ?>">


                                                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                                                <div class="row button_border"
                                                                     id="media_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                     style="display: none;">
                                                                    <div class="col-12 col-sm-4">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="media_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                   id="media_text_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-4">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                                            <select class="form-control media_type_class"
                                                                                    id="media_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                    name="media_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                                <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                                <option value="web_url"><?php echo $this->lang->line("Web Url"); ?></option>
                                                                                <option value="phone_number"><?php echo $this->lang->line("Call Us"); ?></option>

                                                                                <option value="web_url_compact"><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                                <option value="web_url_tall"><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                                <option value="web_url_full"><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                                <option value="web_url_birthday"><?php echo $this->lang->line("User's Birthday"); ?></option>

                                                                                <option value="web_url_email"><?php echo $this->lang->line("User's Email"); ?></option>
                                                                                <option value="web_url_phone"><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                                <option value="web_url_location"><?php echo $this->lang->line("User's Location"); ?></option>

                                                                                <option value="post_back"
                                                                                        id="unsubscribe_postback"><?php echo $this->lang->line("Unsubscribe"); ?></option>
                                                                                <option value="post_back"
                                                                                        id="resubscribe_postback"><?php echo $this->lang->line("Re-subscribe"); ?></option>

                                                                                <option value="post_back"
                                                                                        id="human_postback"><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                                <option value="post_back"
                                                                                        id="robot_postback"><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-10 col-sm-3">

                                                                        <div class="form-group"
                                                                             id="media_postid_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                            <select class="form-control push_postback"
                                                                                    name="media_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                    id="media_post_id_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                <option value=""><?php echo $this->lang->line("Select"); ?></option>
                                                                            </select>
                                                                            <a href=""
                                                                               class="add_template float-left"><i
                                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                            </a>
                                                                            <a href="" class="ref_template float-right"><i
                                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                            </a>
                                                                        </div>

                                                                        <div class="form-group"
                                                                             id="media_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="media_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                   id="media_web_url_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        </div>
                                                                        <div class="form-group"
                                                                             id="media_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="media_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                   id="media_call_us_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <?php if ($i != 1) : ?>
                                                                        <div class="col-2 col-sm-1">
                                                                            <br/>
                                                                            <i class="bx bx-time bx-2x red item_remove"
                                                                               template_type="not_quick_reply"
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

                                                        </div>
                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                        <input type="hidden"
                                                               name="media_postback_sort_order_<?php echo $k; ?>"
                                                               id="media_postback_sort_order_<?php echo $k; ?>">


                                                        <div class="row clearfix">
                                                            <div class="col-12 text-center">
                                                                <button class="btn btn-outline-primary float-right no_radius btn-xs"
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
                                                            <label><?php echo $this->lang->line("Please provide your reply message"); ?>
                                                                <a href="#" data-placement="bottom"
                                                                   data-toggle="popover" data-trigger="focus"
                                                                   title="<?php echo $this->lang->line("Spintax"); ?>"
                                                                   data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                            class='bx bx-info-circle'></i> </a>
                                                            </label>

                                                            <span class='float-right'>
                                <a title="<?php echo $this->lang->line("You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   class='btn-sm lead_last_name button-outline'><i
                                            class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                              </span>
                                                            <span class='float-right'>
                                <a title="<?php echo $this->lang->line("You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   class='btn-sm lead_first_name button-outline'><i
                                            class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                              </span>

                                                            <div class="clearfix"></div>
                                                            <textarea class="form-control"
                                                                      name="quick_reply_text_<?php echo $k; ?>"
                                                                      id="quick_reply_text_<?php echo $k; ?>"></textarea>
                                                        </div>


                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                        <div id="quick_reply_sort_<?php echo $k; ?>">

                                                            <?php for ($i = 1; $i <= 11; $i++) : ?>
                                                                <div class="row button_border"
                                                                     id="quick_reply_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                     style="display: none;">
                                                                    <div class="col-12 col-sm-4">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="quick_reply_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                   id="quick_reply_button_text_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <!-- 28/02/2018 -->
                                                                    <div class="col-12 col-sm-4">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                                            <select class="form-control quick_reply_button_type_class"
                                                                                    id="quick_reply_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                    name="quick_reply_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                                <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                                <?php if ($media_type != 'ig'): ?>
                                                                                    <option value="phone_number"><?php echo $this->lang->line("User Phone Number"); ?></option>
                                                                                    <option value="user_email"><?php echo $this->lang->line("User E-mail Address"); ?></option>
                                                                                <?php endif; ?>
                                                                                <!-- <option value="location"><?php echo $this->lang->line("User's Location"); ?></option> -->
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-10 col-sm-3">
                                                                        <div class="form-group"
                                                                             id="quick_reply_postid_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                            <select class="form-control push_postback"
                                                                                    name="quick_reply_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                    id="quick_reply_post_id_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                <option value=""><?php echo $this->lang->line("Select"); ?></option>
                                                                            </select>
                                                                            <a href=""
                                                                               class="add_template float-left"><i
                                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                            </a>
                                                                            <a href="" class="ref_template float-right"><i
                                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <?php if ($i != 1) : ?>
                                                                        <div class="col-2 col-sm-1">
                                                                            <br/>
                                                                            <i class="bx bx-time bx-2x red item_remove"
                                                                               template_type="quick_reply"
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

                                                        </div>
                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                        <input type="hidden"
                                                               name="quick_reply_sort_order_<?php echo $k; ?>"
                                                               id="quick_reply_sort_order_<?php echo $k; ?>">


                                                        <div class="row clearfix">
                                                            <div class="col-12 text-center">
                                                                <button class="btn btn-outline-primary float-right no_radius btn-xs"
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
                                                            <label><?php echo $this->lang->line("Please provide your reply message"); ?>
                                                                <a href="#" data-placement="bottom"
                                                                   data-toggle="popover" data-trigger="focus"
                                                                   title="<?php echo $this->lang->line("Spintax"); ?>"
                                                                   data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                            class='bx bx-info-circle'></i> </a>
                                                            </label>

                                                            <span class='float-right'>
                                <a title="<?php echo $this->lang->line("You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   class='btn-sm lead_last_name button-outline'><i
                                            class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                              </span>
                                                            <span class='float-right'>
                                <a title="<?php echo $this->lang->line("You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                                   data-toggle="tooltip" data-placement="top"
                                   class='btn-sm lead_first_name button-outline'><i
                                            class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                              </span>

                                                            <div class="clearfix"></div>
                                                            <textarea class="form-control"
                                                                      name="text_with_buttons_input_<?php echo $k; ?>"
                                                                      id="text_with_buttons_input_<?php echo $k; ?>"></textarea>
                                                        </div>


                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                        <div id="text_button_sort_<?php echo $k; ?>">

                                                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                                                <div class="row button_border"
                                                                     id="text_with_buttons_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                     style="display: none;">
                                                                    <div class="col-12 col-sm-4">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="text_with_buttons_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                   id="text_with_buttons_text_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-4">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                                            <select class="form-control text_with_button_type_class"
                                                                                    id="text_with_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                    name="text_with_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                                <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                                <option value="web_url"><?php echo $this->lang->line("Web Url"); ?></option>

                                                                                <option value="web_url_compact"><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                                <option value="web_url_tall"><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                                <option value="web_url_full"><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                                <option value="web_url_birthday"><?php echo $this->lang->line("User's Birthday"); ?></option>

                                                                                <option value="web_url_email"><?php echo $this->lang->line("User's Email"); ?></option>
                                                                                <option value="web_url_phone"><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                                <option value="web_url_location"><?php echo $this->lang->line("User's Location"); ?></option>

                                                                                <option value="phone_number"><?php echo $this->lang->line("Call Us"); ?></option>

                                                                                <option value="post_back"
                                                                                        id="unsubscribe_postback"><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                                <option value="post_back"
                                                                                        id="resubscribe_postback"><?php echo $this->lang->line("re-subscribe"); ?></option>

                                                                                <option value="post_back"
                                                                                        id="human_postback"><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                                <option value="post_back"
                                                                                        id="robot_postback"><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-10 col-sm-3">
                                                                        <div class="form-group"
                                                                             id="text_with_button_postid_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                            <select class="form-control push_postback"
                                                                                    name="text_with_button_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                    id="text_with_button_post_id_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                <option value=""><?php echo $this->lang->line("Select"); ?></option>
                                                                            </select>
                                                                            <a href=""
                                                                               class="add_template float-left"><i
                                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                            </a>
                                                                            <a href="" class="ref_template float-right"><i
                                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                            </a>
                                                                        </div>
                                                                        <div class="form-group"
                                                                             id="text_with_button_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="text_with_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                   id="text_with_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        </div>
                                                                        <div class="form-group"
                                                                             id="text_with_button_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="text_with_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                   id="text_with_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <?php if ($i != 1) : ?>
                                                                        <div class="col-2 col-sm-1">
                                                                            <br/>
                                                                            <i class="bx bx-time bx-2x red item_remove"
                                                                               template_type="not_quick_reply"
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

                                                        </div>
                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                        <input type="hidden"
                                                               name="text_button_sort_order_<?php echo $k; ?>"
                                                               id="text_button_sort_order_<?php echo $k; ?>">

                                                        <div class="row clearfix">
                                                            <div class="col-12 text-center">
                                                                <button class="btn btn-outline-primary float-right no_radius btn-xs"
                                                                        id="text_with_button_add_button_<?php echo $k; ?>">
                                                                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="row" id="generic_template_div_<?php echo $k; ?>"
                                                     style="display: none; margin-bottom: 10px;">
                                                    <div class="col-12">

                                                        <div class="card card-secondary">
                                                            <div class="card-header">
                                                                <h4><?php echo $this->lang->line('Generic Template'); ?></h4>
                                                            </div>
                                                            <div class="card-body">

                                                                <div class="row">
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("Please provide your reply image"); ?>
                                                                                <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                                            <input type="text"
                                                                                   placeholder="<?php echo $this->lang->line('Put your image URL here or click the upload button.'); ?>"
                                                                                   class="form-control"
                                                                                   name="generic_template_image_<?php echo $k; ?>"
                                                                                   id="generic_template_image_<?php echo $k; ?>"/>
                                                                            <div id="generic_image_<?php echo $k; ?>"><?php echo $this->lang->line('upload'); ?></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("image click destination link"); ?>
                                                                                <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="generic_template_image_destination_link_<?php echo $k; ?>"
                                                                                   id="generic_template_image_destination_link_<?php echo $k; ?>"/>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("title"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="generic_template_title_<?php echo $k; ?>"
                                                                                   id="generic_template_title_<?php echo $k; ?>"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6">
                                                                        <div class="form-group">
                                                                            <label><?php echo $this->lang->line("sub-title"); ?></label>
                                                                            <input type="text" class="form-control"
                                                                                   name="generic_template_subtitle_<?php echo $k; ?>"
                                                                                   id="generic_template_subtitle_<?php echo $k; ?>"/>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <span class="float-right"><span
                                                                            style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></span>
                                                                <div class="clearfix"></div>

                                                                <!--   This hidden input is added by Konok to keep sorted order  -->
                                                                <div id="generic_button_sort_<?php echo $k; ?>">


                                                                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                                                                        <div class="row button_border"
                                                                             id="generic_template_row_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                             style="display: none;">
                                                                            <div class="col-12 col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label><?php echo $this->lang->line("button text"); ?></label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="generic_template_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                           id="generic_template_button_text_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label><?php echo $this->lang->line("button type"); ?></label>
                                                                                    <select class="form-control generic_template_button_type_class"
                                                                                            id="generic_template_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                            name="generic_template_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                        <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                                        <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                                        <option value="web_url"><?php echo $this->lang->line("Web Url"); ?></option>

                                                                                        <option value="web_url_compact"><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                                        <option value="web_url_tall"><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                                        <option value="web_url_full"><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                                        <option value="web_url_birthday"><?php echo $this->lang->line("User's Birthday"); ?></option>

                                                                                        <option value="web_url_email"><?php echo $this->lang->line("User's Email"); ?></option>
                                                                                        <option value="web_url_phone"><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                                        <option value="web_url_location"><?php echo $this->lang->line("User's Location"); ?></option>

                                                                                        <option value="phone_number"><?php echo $this->lang->line("Call Us"); ?></option>

                                                                                        <option value="post_back"
                                                                                                id="unsubscribe_postback"><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                                        <option value="post_back"
                                                                                                id="resubscribe_postback"><?php echo $this->lang->line("re-subscribe"); ?></option>

                                                                                        <option value="post_back"
                                                                                                id="human_postback"><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                                        <option value="post_back"
                                                                                                id="robot_postback"><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-10 col-sm-3">
                                                                                <div class="form-group"
                                                                                     id="generic_template_button_postid_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                     style="display: none;">
                                                                                    <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                                    <select class="form-control push_postback"
                                                                                            name="generic_template_button_post_id_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                            id="generic_template_button_post_id_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                        <option value=""><?php echo $this->lang->line("Select"); ?></option>
                                                                                    </select>
                                                                                    <a href=""
                                                                                       class="add_template float-left"><i
                                                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                                    </a>
                                                                                    <a href=""
                                                                                       class="ref_template float-right"><i
                                                                                                class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="form-group"
                                                                                     id="generic_template_button_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                     style="display: none;">
                                                                                    <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="generic_template_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                           id="generic_template_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                </div>
                                                                                <div class="form-group"
                                                                                     id="generic_template_button_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                     style="display: none;">
                                                                                    <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="generic_template_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                           id="generic_template_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <?php if ($i != 1) : ?>
                                                                                <div class="col-2 col-sm-1">
                                                                                    <br/>
                                                                                    <i class="bx bx-time bx-2x red item_remove"
                                                                                       template_type="not_quick_reply"
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

                                                                </div>
                                                                <!--   This hidden input is added by Konok to keep sorted order  -->
                                                                <input type="hidden"
                                                                       name="generic_button_sort_order_<?php echo $k; ?>"
                                                                       id="generic_button_sort_order_<?php echo $k; ?>">


                                                                <div class="row clearfix">
                                                                    <div class="col-12 text-center">
                                                                        <button class="btn btn-outline-primary float-right no_radius btn-xs"
                                                                                id="generic_template_add_button_<?php echo $k; ?>">
                                                                            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div> <!--end of card-body -->
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row" id="carousel_div_<?php echo $k; ?>"
                                                     style="display: none; margin-bottom: 10px;">

                                                    <!--   This hidden input is added by Konok to keep sorted order  -->
                                                    <div class="col-12" id="carousel_reply_sort_<?php echo $k; ?>">


                                                        <?php for ($j = 1; $j <= 10; $j++) : ?>
                                                            <div class="col-12"
                                                                 id="carousel_div_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                 style="display: none;">

                                                                <div class="card card-secondary">
                                                                    <div class="card-header">
                                                                        <h4 class="full_width"><?php echo $this->lang->line('Carousel Template') . ' ' . $j; ?>
                                                                            <?php if ($j != 1) : ?>
                                                                                <i class="bx bx-time-circle remove_carousel_template float-right red"
                                                                                   previous_row_id="carousel_div_<?php echo $j - 1; ?>_<?php echo $k; ?>"
                                                                                   current_row_id="carousel_div_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                   counter_variable="carousel_template_counter_<?php echo $k; ?>"
                                                                                   template_add_button="carousel_template_add_button_<?php echo $k; ?>"
                                                                                   title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                                            <?php endif; ?>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="card-body">

                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label><?php echo $this->lang->line("Please provide your reply image"); ?>
                                                                                        <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                                                    <input type="text"
                                                                                           placeholder="<?php echo $this->lang->line('Put your image URL here or click the upload button.'); ?>"
                                                                                           class="form-control"
                                                                                           name="carousel_image_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                           id="carousel_image_<?php echo $j; ?>_<?php echo $k; ?>"/>
                                                                                    <div id="generic_imageupload_<?php echo $j; ?>_<?php echo $k; ?>"><?php echo $this->lang->line('upload'); ?></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label><?php echo $this->lang->line("image click destination link"); ?>
                                                                                        <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="carousel_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                           id="carousel_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label><?php echo $this->lang->line("title"); ?></label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="carousel_title_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                           id="carousel_title_<?php echo $j; ?>_<?php echo $k; ?>"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label><?php echo $this->lang->line("sub-title"); ?></label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           name="carousel_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                           id="carousel_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <span class="float-right"><span
                                                                                    style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></span>
                                                                        <div class="clearfix"></div>

                                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                                        <div id="carousel_button_sort_<?php echo $j; ?>_<?php echo $k; ?>">


                                                                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                                                                <div class="row button_border"
                                                                                     id="carousel_row_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                     style="display: none;">
                                                                                    <div class="col-12 col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label><?php echo $this->lang->line("button text"); ?></label>
                                                                                            <input type="text"
                                                                                                   class="form-control"
                                                                                                   name="carousel_button_text_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                                   id="carousel_button_text_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12 col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label><?php echo $this->lang->line("button type"); ?></label>
                                                                                            <select class="form-control carousel_button_type_class"
                                                                                                    id="carousel_button_type_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                                    name="carousel_button_type_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>">
                                                                                                <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                                                <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                                                <option value="web_url"><?php echo $this->lang->line("Web Url"); ?></option>

                                                                                                <option value="web_url_compact"><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                                                <option value="web_url_tall"><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                                                <option value="web_url_full"><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                                                <option value="web_url_birthday"><?php echo $this->lang->line("User's Birthday"); ?></option>

                                                                                                <option value="web_url_email"><?php echo $this->lang->line("User's Email"); ?></option>
                                                                                                <option value="web_url_phone"><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                                                <option value="web_url_location"><?php echo $this->lang->line("User's Location"); ?></option>

                                                                                                <option value="phone_number"><?php echo $this->lang->line("Call Us"); ?></option>

                                                                                                <option value="post_back"
                                                                                                        id="unsubscribe_postback"><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                                                <option value="post_back"
                                                                                                        id="resubscribe_postback"><?php echo $this->lang->line("re-subscribe"); ?></option>

                                                                                                <option value="post_back"
                                                                                                        id="human_postback"><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                                                <option value="post_back"
                                                                                                        id="robot_postback"><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-10 col-sm-3">
                                                                                        <div class="form-group"
                                                                                             id="carousel_button_postid_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                             style="display: none;">
                                                                                            <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                                            <select class="form-control push_postback"
                                                                                                    name="carousel_button_post_id_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                                    id="carousel_button_post_id_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>">
                                                                                                <option value=""><?php echo $this->lang->line("Select"); ?></option>
                                                                                            </select>
                                                                                            <a href=""
                                                                                               class="add_template float-left"><i
                                                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                                            </a>
                                                                                            <a href=""
                                                                                               class="ref_template float-right"><i
                                                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="form-group"
                                                                                             id="carousel_button_web_url_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                             style="display: none;">
                                                                                            <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                                            <input type="text"
                                                                                                   class="form-control"
                                                                                                   name="carousel_button_web_url_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                                   id="carousel_button_web_url_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>">
                                                                                        </div>
                                                                                        <div class="form-group"
                                                                                             id="carousel_button_call_us_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                             style="display: none;">
                                                                                            <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                                            <input type="text"
                                                                                                   class="form-control"
                                                                                                   name="carousel_button_call_us_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                                   id="carousel_button_call_us_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>">
                                                                                        </div>
                                                                                    </div>

                                                                                    <?php if ($i != 1) : ?>
                                                                                        <div class="col-2 col-sm-1">
                                                                                            <br/>
                                                                                            <i class="bx bx-time bx-2x red item_remove"
                                                                                               template_type="not_quick_reply"
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

                                                                        </div>
                                                                        <!--   This hidden input is added by Konok to keep sorted order  -->
                                                                        <input type="hidden"
                                                                               name="carousel_button_sort_order_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                               id="carousel_button_sort_order_<?php echo $j; ?>_<?php echo $k; ?>">


                                                                        <div class="row clearfix"
                                                                             style="padding-bottom: 10px;">
                                                                            <div class="col-12 text-center">
                                                                                <button class="btn btn-outline-primary float-right no_radius btn-xs"
                                                                                        id="carousel_add_button_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                                                </button>
                                                                            </div>
                                                                        </div>


                                                                    </div> <!-- end of card body -->
                                                                </div>
                                                            </div>
                                                        <?php endfor; ?>

                                                    </div>
                                                    <!--   This hidden input is added by Konok to keep sorted order  -->
                                                    <input type="hidden"
                                                           name="carousel_reply_sort_order_<?php echo $k; ?>"
                                                           id="carousel_reply_sort_order_<?php echo $k; ?>">

                                                    <div class="col-12 clearfix">
                                                        <button id="carousel_template_add_button_<?php echo $k; ?>"
                                                                class="btn btn-sm btn-outline-primary float-right no_radius">
                                                            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more template"); ?>
                                                        </button>
                                                    </div>

                                                </div>


                                            </div>

                                        </div> <!-- end of card body  -->
                                    </div>
                                <?php } ?>

                            </div>
                            <!--   This hidden input is added by Konok to keep sorted order  -->
                            <input type="hidden" name="main_reply_sort_order" id="main_reply_sort_order">


                            <div class="row">
                                <div class="col-12 clearfix">
                                    <button id="multiple_template_add_button"
                                            class="btn btn-outline-primary float-right no_radius"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('add more reply'); ?>
                                    </button>
                                </div>
                            </div>
                            <br/><br/>
                            <div class="row">
                                <div class="col-6">
                                    <button id="submit" class="btn btn-primary"><i class="bx bx-send"></i> <span
                                                class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-secondary float-right"
                                       href="<?php echo base_url("messenger_bot/bot_settings/") . $page_info['id'] . "/1"; ?>"><i
                                                class="bx bx-time"></i> <span
                                                class="align-middle ml-25"><?php echo $this->lang->line("Back"); ?>
                                    </a></button>
                                </div>
                            </div>

                        </form>

                    </div>

                    <?php if ($iframe != "1") : ?>
                        <div class="hidden-xs hidden-sm col-md-3 img_holder" style="">
                            <div id="text_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/text.png')) echo site_url() . "assets/images/preview/text.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/text.png"; ?>"
                                            class="img-rounded" alt="Text Preview"></center>
                            </div>

                            <div id="image_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/image.png')) echo site_url() . "assets/images/preview/image.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/image.png"; ?>"
                                            class="img-rounded" alt="Image Preview"></center>
                            </div>

                            <div id="audio_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/mp3.png')) echo site_url() . "assets/images/preview/mp3.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/mp3.png"; ?>"
                                            class="img-rounded" alt="Audio Preview"></center>
                            </div>

                            <div id="video_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/video.png')) echo site_url() . "assets/images/preview/video.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/video.png"; ?>"
                                            class="img-rounded" alt="Video Preview"></center>
                            </div>

                            <div id="file_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/file.png')) echo site_url() . "assets/images/preview/file.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/file.png"; ?>"
                                            class="img-rounded" alt="File Preview"></center>
                            </div>

                            <div id="quick_reply_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/quick_reply.png')) echo site_url() . "assets/images/preview/quick_reply.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/quick_reply.png"; ?>"
                                            class="img-rounded" alt="Quick Reply Preview"></center>
                            </div>

                            <div id="text_with_buttons_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/button.png')) echo site_url() . "assets/images/preview/button.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/button.png"; ?>"
                                            class="img-rounded" alt="Text With Buttons Preview"></center>
                            </div>

                            <div id="generic_template_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/generic.png')) echo site_url() . "assets/images/preview/generic.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/generic.png"; ?>"
                                            class="img-rounded" alt="Generic Template Preview"></center>
                            </div>

                            <div id="carousel_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/carousel.png')) echo site_url() . "assets/images/preview/carousel.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/carousel.png"; ?>"
                                            class="img-rounded" alt="Carousel Template Preview"></center>
                            </div>

                            <div id="media_preview_div">
                                <center><img
                                            src="<?php if (file_exists(FCPATH . 'assets/images/preview/media.png')) echo site_url() . "assets/images/preview/media.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/media.png"; ?>"
                                            class="img-rounded" alt="Media Template Preview"></center>
                            </div>

                        </div>
                    <?php endif; ?>

                </div>

                <br>
                <div id="submit_status" class="text-center"></div>

            </div>

        </div>
    </div>
</div>

<?php if ($this->session->flashdata('bot_success') === 1) { ?>
    <div class="alert alert-success text-center" id="bot_success"><i
                class="bx bx-check-circle"></i> <?php echo $this->lang->line("Bot reply has been saved successfully."); ?>
    </div>
<?php } ?>
<?php if ($this->session->flashdata('bot_update_success') === 1) { ?>
    <div class="alert alert-success text-center" id="bot_success"><i
                class="bx bx-check-circle"></i> <?php echo $this->lang->line("Bot reply has been saved successfully."); ?>
    </div>
<?php } ?>

<?php

$builder_load_url = base_url("visual_flow_builder/load_builder/{$page_info['id']}/1/{$media_type}");
$drop_menu = '
<a href="' . $builder_load_url . '" class="float-right btn btn-primary" target="_BLANK"><i class="bx bx-plus-circle"></i> ' . $this->lang->line("Set Keywords") . '</a>
<a id="add_bot_settings" href="#" class="float-right btn btn-primary"><i class="bx bx-plus-circle"></i> ' . $this->lang->line("Use Classic Builder") . '</a>';


?>

<div class="row">
    <div class="col-12">
        <?php echo $drop_menu; ?>
    </div>
</div>

<div class="table-responsive data-card" id="bot_list_datatable">
    <table class="table table-bordered table-sm table-striped" id="mytable">
        <thead>
        <tr>
            <th class="text-center"><?php echo $this->lang->line("SL"); ?></th>
            <th class="text-center"><?php echo $this->lang->line("Bot Name"); ?></th>
            <th class="text-center"><?php echo $this->lang->line("Keywords"); ?></th>
            <th class="text-center"><?php echo $this->lang->line("Status"); ?></th>
            <?php if ($visual_flow_builder_exist == 'yes') : ?>
                <th class="text-center"><?php echo $this->lang->line("Type"); ?></th>
            <?php endif; ?>
            <th class="text-center"><?php echo $this->lang->line("Actions"); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        foreach ($bot_settings as $key => $value) {
            if ($value['keyword_type'] == "email-quick-reply" || $value['keyword_type'] == "location-quick-reply" || $value['keyword_type'] == "birthday-quick-reply" || $value['keyword_type'] == "phone-quick-reply" || $value['keyword_type'] == "get-started" || $value['keyword_type'] == "no match" || $value['postback_id'] == "UNSUBSCRIBE_QUICK_BOXER" || $value['postback_id'] == "RESUBSCRIBE_QUICK_BOXER" || $value['postback_id'] == "YES_START_CHAT_WITH_HUMAN" || $value['postback_id'] == "YES_START_CHAT_WITH_BOT") continue;
            $i++;

            if ($value['last_replied_at'] != "0000-00-00 00:00:00") $reply_at = date('d M y - H:i:s');
            else $reply_at = "<span class='label label-warning'><i class='bx bx-trash'></i> " . $this->lang->line('No Replied Yet') . "</span>";

            if ($value['keyword_type'] == "reply") {
                if (strlen($value['keywords']) > 20) $keywords_display = substr($value['keywords'], 0, 20) . '...';
                else $keywords_display = $value['keywords'];
                $keywords_tooltip = '<a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Keywords") . '" data-content="' . str_replace(",", ", ", $value["keywords"]) . '"><i class="bx bx-info-circle gray"></i> </a>';
                $keywords_display = str_replace(',', ', ', $keywords_display) . " " . $keywords_tooltip;
            } else $keywords_display = "<span class='label label-light orange'><i class='bx bx-trash'></i></span>";

            if ($value['status'] == '1') {
                $current_status = '<i class="bx bx-play-circle green"></i> ' . $this->lang->line("Live");
            } else {
                $current_status = '<i class="bx bx-play-circle gray"></i> ' . $this->lang->line("Paused");
            }

            echo "<tr>";
            echo "<td class='text-center'>" . $i . "</td>";
            echo "<td>" . $value['bot_name'] . "</td>";
            echo "<td>" . $keywords_display . "</td>";
            echo "<td class='text-center'>" . $current_status . "</td>";
            if ($visual_flow_builder_exist == 'yes') {
                if (isset($value['visual_flow_type']) && $value['visual_flow_type'] == 'flow') {
                    echo "<td class='text-center'>" . $this->lang->line('Flow Builder') . "</td>";
                } else {
                    echo "<td class='text-center'>" . $this->lang->line('Classic Editor') . "</td>";
                }
            }

            $editurl = base_url("messenger_bot/edit_bot/" . $value['id']);

            if ($value['status'] == '1') {

                $state_text = $this->lang->line("Stop");
                $state_icon = '<i class="bx bx-stop-circle"></i>';
            } else {

                $state_text = $this->lang->line("Start");
                $state_icon = '<i class="bx bx-play-circle"></i>';
            }

            if (isset($iframe) && $iframe == '1') {
                $editurl .= '/1';
            }
            echo "<td class='text-center'>";
            $action_content = '<a href="#" data-toggle="dropdown" class="btn btn-outline-primary btn-circle dropdown-toggle bot_actions no_caret"><i class="bx bx-briefcase"></i></a> 
            
            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
             <h6 class="dropdown-header">' . $this->lang->line("Actions") . '</h6>
             <li><a class="dropdown-item has-icon bot_status_btn" href="#" table_id="' . $value['id'] . '">' . $state_icon . ' ' . $state_text . '</a></li>';

            if (addon_exist($module_id = 315, $addon_unique_name = "visual_flow_builder") && isset($value['visual_flow_type']) && $value['visual_flow_type'] == 'flow') {
                $flow_edit_url = base_url() . "visual_flow_builder/edit_builder_data/" . $value['visual_flow_campaign_id'] . "/0";
                $action_content .= '<li><a class="dropdown-item has-icon" target="_BLANK" href="' . $flow_edit_url . '"><i class="bx bx-edit"></i> ' . $this->lang->line("Edit Bot Reply") . '</a></li>';
            } else {
                $action_content .= '<li><a class="dropdown-item has-icon" href="' . $editurl . '"><i class="bx bx-edit"></i> ' . $this->lang->line("Edit Bot Reply") . '</a></li>';
            }
            if ($value['visual_flow_type'] == 'general') {
                $action_content .= '<div class="dropdown-divider"></div>
             <li><a class="dropdown-item has-icon delete_bot red" href="" id="' . $value['id'] . '"><i class="bx bx-trash"></i> ' . $this->lang->line("Delete Bot Reply") . '</a></li>';
            }

            $action_content .= '</ul>';
            echo $action_content;
            echo "</td>";

            echo "</tr>"; ?>
            <?php
        } ?>
        </tbody>
    </table>
</div>

<?php
$somethingwentwrong = $this->lang->line("something went wrong.");
$doyoureallywanttodeletethisbot = $this->lang->line("do you really want to delete this bot?");
?>


<?php
$areyousure = $this->lang->line("are you sure");
?>


<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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

<div class="modal fade" id="error_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><i
                            class="bx bx-info-circle"></i> <?php echo $this->lang->line('campaign error'); ?></h3>
            </div>
            <div class="modal-body">
                <div class="alert text-center alert-warning" id="error_modal_content">

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="media_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-info-circle"></i> <?php echo $this->lang->line("How to get media URL?"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                    <div class="table-responsive2">
                        <table class='table table-bordered table-hover table-striped'>
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
</div>