<?php
$include_upload = 1;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
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
$postback_id_str = $bot_info['postback_id'];
$postback_id_array = explode(",", $postback_id_str);
$full_message_json = $bot_info['message'];
$full_message_array = json_decode($full_message_json, true);
// $full_message = $full_message_array['message'];
$redirect_url = site_url('messenger_bot/bot_settings/') . $page_info['id'] . '/1';
$hide_generic_item = false;
if ($media_type == 'ig') {
    $redirect_url = site_url('messenger_bot/ig_bot_settings/') . $page_info['id'] . '/1/ig';
    $hide_generic_item = true;
}

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

$THEMECOLORCODE = "#607D8B";

?>


<style type="text/css">
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
        color: <?php echo $THEMECOLORCODE; ?> !important;
        font-size: 15px !important;
    }

    .css-label-container {
        padding: 10px;
        border: 1px dashed<?php echo $THEMECOLORCODE; ?>;
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

    .load_preview_modal {
        cursor: pointer;
    }

    <?php if($iframe == '1') : ?>
    .card-body {
        padding: 1px !important;
    }

    <?php endif; ?>
</style>


<?php if ($iframe != '1') : ?>

    <div class="section-header">
        <h1><i class='bx bx-edit'></i> <?php echo $this->lang->line("Edit Bot Settings"); ?> : <a target='_BLANK'
                                                                                                  href='https://facebook.com/<?php echo $page_info['page_id']; ?>'><?php echo $page_info['page_name']; ?></a>
        </h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a
                        href="<?php echo base_url('messenger_bot/bot_menu_section'); ?>"><?php echo $this->lang->line('Messenger Tools'); ?></a>
            </div>
            <div class="breadcrumb-item"><?php echo $page_title; ?></div>
        </div>
    </div>
<?php endif; ?>

<div class="card <?php if ($iframe == '1') echo 'shadow-none'; ?>">
    <div class="card-body">

        <?php if ($iframe != '1') : ?>
            <div class="text-center waiting" id="loader"><i class="bx bx-sync bx-spin blue text-center"
                                                            style="font-size: 40px;"></i></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12 col-md-9">
                <form action="#" method="post" id="messenger_bot_form" style="padding-left: 0;">
                    <input type="hidden" name="media_type" id="media_type" value="<?php echo $media_type; ?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $bot_info['id']; ?>">
                    <input type="hidden" name="page_id" id="page_id" value="<?php echo $page_info['page_id']; ?>">
                    <input type="hidden" name="page_table_id" id="page_table_id"
                           value="<?php echo $page_info['id']; ?>">
                    <?php
                    $type = 'reply';
                    if ($default_template == 'getstart') $type = 'get-started';
                    else if ($default_template == 'nomatch') $type = 'no match';
                    else if ($default_template == 'story-mention') $type = 'story-mention';
                    ?>
                    <input type="hidden" name="keyword_type" id="keyword_type" value="<?php echo $type; ?>">

                    <div class="row">
                        <?php if ($type == 'reply') : ?>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Bot Name"); ?></label>
                                    <input type="text" name="bot_name"
                                           value="<?php if (set_value('bot_name')) echo set_value('bot_name'); else {
                                               if (isset($bot_info['bot_name'])) echo $bot_info['bot_name'];
                                           } ?>" id="bot_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Please provide your keywords in comma separated"); ?></label>
                                    <input class="form-control" name="keywords_list" id="keywords_list"
                                           value="<?php if (set_value('keywords_list')) echo set_value('keywords_list'); else {
                                               if (isset($bot_info['keywords'])) echo $bot_info['keywords'];
                                           } ?>">
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="col-12" style="display: none;">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Bot Name"); ?></label>
                                    <input type="hidden" name="bot_name"
                                           value="<?php if (set_value('bot_name')) echo set_value('bot_name'); else {
                                               if (isset($bot_info['bot_name'])) echo $bot_info['bot_name'];
                                           } ?>" id="bot_name" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="keywords_list" id="keywords_list" value="">
                        <?php endif; ?>
                    </div>


                    <div class="row" id="postback_div" style="display: none;">
                        <div class="col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("Please select your postback id : "); ?></label>
                                <select class="form-control" id="keywordtype_postback_id_useless"
                                        name="keywordtype_postback_id_useless[]" disabled="disabled">
                                    <?php
                                    $hidden_input_value = '';
                                    $total_postback_id_array = array();
                                    foreach ($postback_ids as $value) {
                                        if (!in_array($value['postback_id'], $current_postbacks))
                                            $total_postback_id_array[] = strtoupper($value['postback_id']);

                                        if ($value["template_for"] == "unsubscribe" || $value["template_for"] == "resubscribe" || $value["template_for"] == "email-quick-reply" || $value["template_for"] == "phone-quick-reply" || $value["template_for"] == "location-quick-reply" || $value["is_template"] == "1") continue;

                                        $array_key = $value['postback_id'];
                                        $array_value = $value['postback_id'] . " (" . $value['bot_name'] . ")";
                                        if ($value['use_status'] == '0') {
                                            echo "<option value='{$array_key}'>{$array_value}</option>";
                                        } else {
                                            if (in_array($array_key, $postback_id_array)) {
                                                $hidden_input_value = $array_key;
                                                echo "<option value='{$array_key}' selected >{$array_value}</option>";
                                            }

                                        }
                                    }
                                    ?>
                                </select>
                                <input type='hidden' name='keywordtype_postback_id[]' id='keywordtype_postback_id'
                                       value='<?php echo $hidden_input_value; ?>'>
                            </div>
                        </div>
                    </div>


                    <!--   This div is added by Konok to make it sortable  -->

                    <div id="main_reply_sort">

                        <?php
                        if (!isset($full_message_array[1])) {
                            $full_message_array[1] = $full_message_array;
                            $full_message_array[1]['message']['template_type'] = $bot_info['template_type'];
                        }


                        $active_reply_count = 0;

                        for ($k = 1; $k <= 6; $k++) {

                            $full_message[$k] = isset($full_message_array[$k]['message']) ? $full_message_array[$k]['message'] : array();

                            if (isset($full_message[$k]["template_type"]))
                                $full_message[$k]["template_type"] = str_replace('_', ' ', $full_message[$k]["template_type"]);

                            ?>

                            <div class="card card-primary" id="multiple_template_div_<?php echo $k; ?>"
                                <?php

                                if (!isset($full_message[$k]["template_type"]))
                                    echo "style='display : none;'";
                                else {
                                    $active_reply_count++;
                                }
                                ?>
                            >

                                <div class="card-header">
                                    <h4 class="container">
                                        <?php echo $this->lang->line('Reply') . " " . $k; ?>
                                        <?php if ($k != 1 && $k == count($full_message_array)) : ?>
                                            <i class="bx bx-trash remove_reply float-right text-danger pointer"
                                               row_id="multiple_template_div_<?php echo $k; ?>" counter_variable=""
                                               title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                        <?php else : ?>
                                            <i class="bx bx-trash remove_reply float-right text-danger pointer"
                                               style="display: none;" row_id="multiple_template_div_<?php echo $k; ?>"
                                               counter_variable=""
                                               title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                        <?php endif; ?>
                                    </h4>
                                </div>
                                <div class="card-body">

                                    <div <?php if ($iframe == '1') echo 'style="padding: 0 15px 15px 15px !important;"' ?> >

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
                                                    if (isset($full_message[$k]["template_type"]) && $full_message[$k]["template_type"] == $value) $selected = 'selected';
                                                    else $selected = '';
                                                    echo '<option value="' . $value . '" ' . $selected . '>' . $this->lang->line($value) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- <br/> -->
                                        <div class="row <?php if ($media_type == "ig") echo "hidden"; ?>"
                                             id="delay_and_typing_on_<?php echo $k; ?>">
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
                                                                   class="custom-switch-input" <?php if (isset($full_message[$k]["typing_on_settings"]) && $full_message[$k]["typing_on_settings"] == 'on') echo 'checked'; ?> >
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
                                                    <input type="number" min="0"
                                                           value="<?php if (isset($full_message[$k]["delay_in_reply"])) echo $full_message[$k]["delay_in_reply"]; ?>"
                                                           name="delay_in_reply_<?php echo $k; ?>"
                                                           id="delay_in_reply_<?php echo $k; ?>" class="form-control">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><?php echo $this->lang->line('Sec'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <br/> -->

                                        <div class="row" id="text_div_<?php echo $k; ?>">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Please provide your reply message"); ?>
                                                        <a href="#" data-placement="bottom" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("Spintax"); ?>"
                                                           data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                    class='bx bx-info-circle'></i> </a>
                                                    </label>

                                                    <?php if ($media_type == 'fb') : ?>
                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_last_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                        </span>
                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                        </span>
                                                    <?php else : ?>
                                                        <span class='float-right hidden'>
                          <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                             data-placement="top" data-toggle="tooltip"
                             class='btn btn-default btn-sm full_lead_tag_name button-outline'><i
                                      class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                        </span>

                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_FULL_NAME# variable inside your message. The variable will be replaced by real Full Name when we will send it.") ?>"
                             data-placement="top" data-toggle="tooltip"
                             class='btn btn-default btn-sm full_lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("Full Name") ?></a>
                        </span>

                                                    <?php endif; ?>
                                                    <div class="clearfix"></div>
                                                    <textarea class="form-control" name="text_reply_<?php echo $k; ?>"
                                                              id="text_reply_<?php echo $k; ?>"><?php if (isset($full_message[$k]["template_type"]) && $full_message[$k]["template_type"] == 'text') echo $full_message[$k]['text']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="Ecommerce_div_<?php echo $k; ?>"
                                             style="display: none; margin-bottom: 10px;">
                                            <?php
                                            $selected_store_id = '';
                                            $buy_now_button_text = $this->lang->line('Buy Now');
                                            $current_products = [];
                                            if (isset($full_message[$k]["template_type"]) && $full_message[$k]["template_type"] == 'Ecommerce') {
                                                $product_url = isset($full_message[$k]['attachment']['payload']['elements'][0]['default_action']['url']) ? $full_message[$k]['attachment']['payload']['elements'][0]['default_action']['url'] : '';
                                                $product_url_array = explode('?', $product_url);
                                                array_pop($product_url_array);
                                                $product_url_array = explode('/', $product_url_array[0]);
                                                $product_id_single = array_pop($product_url_array);
                                                $selected_store_id = isset($all_products[$product_id_single]) ? $all_products[$product_id_single] : '';
                                                $buy_now_button_text = isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][0]['title']) ? $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][0]['title'] : $this->lang->line('Buy Now');

                                                $current_all_products = isset($full_message[$k]['attachment']['payload']['elements']) ? $full_message[$k]['attachment']['payload']['elements'] : [];
                                                $current_products = [];
                                                foreach ($current_all_products as $single_product) {
                                                    $single_product_url = isset($single_product['default_action']['url']) ? $single_product['default_action']['url'] : '';
                                                    $single_product_url_array = explode('?', $single_product_url);
                                                    array_pop($single_product_url_array);
                                                    $single_product_url_array = explode('/', $single_product_url_array[0]);
                                                    array_push($current_products, array_pop($single_product_url_array));
                                                }
                                            }
                                            ?>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Select your Ecommerce store"); ?>
                                                    </label>
                                                    <select class="form-control select2 ecommerce_store_info"
                                                            product_dropdown_id="ecommerce_product_ids<?php echo $k; ?>"
                                                            id="ecommerce_store_id<?php echo $k; ?>"
                                                            name="ecommerce_store_id<?php echo $k; ?>">
                                                        <option value=""><?php echo $this->lang->line('Select'); ?></option>
                                                        <?php foreach ($store_list as $key => $value) : ?>
                                                            <option value="<?php echo $key; ?>" <?php if ($key == $selected_store_id) echo "selected"; ?> > <?php echo $value; ?></option>
                                                        <?php endforeach; ?>
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
                                                        <option value=""><?php echo $this->lang->line('Select'); ?></option>
                                                        <?php
                                                        $product_list = isset($store_info[$selected_store_id]) ? $store_info[$selected_store_id] : [];
                                                        foreach ($product_list as $key => $value) :
                                                            ?>
                                                            <option value="<?php echo $key; ?>" <?php if (in_array($key, $current_products)) echo "selected"; ?> > <?php echo $value; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Please provide 'Buy Now' button text"); ?></label>
                                                    <input type="text" value="<?php echo $buy_now_button_text; ?>"
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
                                                        <?php
                                                        $selected_flow_campaign_id = 0;
                                                        if (isset($full_message[$k]["template_type"]) && $full_message[$k]["template_type"] == 'User Input Flow')
                                                            $selected_flow_campaign_id = $full_message[$k]['flow_campaign_id'];
                                                        foreach ($flow_campaigns as $value) :
                                                            ?>
                                                            <option value="<?php echo $value['id']; ?>" <?php $selected = ($value['id'] == $selected_flow_campaign_id) ? "selected" : "";
                                                            echo $selected; ?> ><?php echo $value['flow_name']; ?></option>
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
                                                           id="otn_title_<?php echo $k; ?>"
                                                           value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'One Time Notification') echo $full_message[$k]['attachment']['payload']['title']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("OTN Postback"); ?>
                                                    </label>
                                                    <?php
                                                    if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'One Time Notification')
                                                        $selected_otn_postback = $full_message[$k]['attachment']['payload']['payload'];
                                                    else
                                                        $selected_otn_postback = '';
                                                    $name_id = "otn_postback_" . $k;
                                                    echo form_dropdown($name_id, $otn_postback_list, $selected_otn_postback, 'id="' . $name_id . '" class="form-control push_otn_postback select2"');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="image_div_<?php echo $k; ?>" style="display: none;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Please provide your reply image"); ?></label>

                                                    <span class="badge badge-status blue load_preview_modal float-right"
                                                          item_type="image"
                                                          file_path="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'image') echo $full_message[$k]['attachment']['payload']['url']; ?>"><i
                                                                class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                    <input type="text"
                                                           placeholder="<?php echo $this->lang->line('Put your image URL here or click the upload button.'); ?>"
                                                           class="form-control"
                                                           name="image_reply_field_<?php echo $k; ?>"
                                                           id="image_reply_field_<?php echo $k; ?>"
                                                           value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'image') echo $full_message[$k]['attachment']['payload']['url']; ?>">
                                                    <div id="image_reply_<?php echo $k; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                    <img id="image_reply_div_<?php echo $k; ?>" style="display: none;"
                                                         height="200px;" width="400px;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="audio_div_<?php echo $k; ?>" style="display: none;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Please provide your reply audio"); ?></label>

                                                    <span class="badge badge-status blue load_preview_modal float-right"
                                                          item_type="audio"
                                                          file_path="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'audio') echo $full_message[$k]['attachment']['payload']['url']; ?>"><i
                                                                class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                    <input type="hidden" class="form-control"
                                                           name="audio_reply_field_<?php echo $k; ?>"
                                                           id="audio_reply_field_<?php echo $k; ?>"
                                                           value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'audio') echo $full_message[$k]['attachment']['payload']['url']; ?>">
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

                                        <div class="row" id="video_div_<?php echo $k; ?>" style="display: none;">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line("Please provide your reply video"); ?></label>

                                                    <span class="badge badge-status blue load_preview_modal float-right"
                                                          item_type="video"
                                                          file_path="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'video') echo $full_message[$k]['attachment']['payload']['url']; ?>"><i
                                                                class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                    <input type="hidden" class="form-control"
                                                           name="video_reply_field_<?php echo $k; ?>"
                                                           id="video_reply_field_<?php echo $k; ?>"
                                                           value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'video') echo $full_message[$k]['attachment']['payload']['url']; ?>">
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
                                                    <label><?php echo $this->lang->line("Please provide your reply file"); ?></label>

                                                    <span class="badge badge-status blue load_preview_modal float-right"
                                                          item_type="file"
                                                          file_path="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'file') echo $full_message[$k]['attachment']['payload']['url']; ?>"><i
                                                                class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                    <input type="hidden" class="form-control"
                                                           name="file_reply_field_<?php echo $k; ?>"
                                                           id="file_reply_field_<?php echo $k; ?>"
                                                           value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'file') echo $full_message[$k]['attachment']['payload']['url']; ?>">
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
                                                    <input class="form-control" name="media_input_<?php echo $k; ?>"
                                                           id="media_input_<?php echo $k; ?>"
                                                           value="<?php if (isset($full_message[$k]["template_type"]) && $full_message[$k]["template_type"] == 'media') echo $full_message[$k]['attachment']['payload']['elements'][0]['url']; ?>"/>
                                                </div>

                                                <!--   This hidden input is added by Konok to keep sorted order  -->
                                                <div id="media_postback_sort_<?php echo $k; ?>">


                                                    <?php $media_add_button_display = 0;
                                                    for ($i = 1; $i <= 3; $i++) : ?>
                                                        <div class="row button_border"
                                                             id="media_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                            $media_add_button_display++;
                                                        } ?> >
                                                            <div class="col-12 col-sm-4">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("button text"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="media_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           id="media_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-4">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("button type"); ?></label>
                                                                    <select class="form-control select2 media_type_class"
                                                                            id="media_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                            name="media_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                        <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                        <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web Url"); ?></option>

                                                                        <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                        <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                        <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Full]"); ?></option>

                                                                        <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Birthday"); ?></option>
                                                                        <option value="web_url_email" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Email"); ?></option>
                                                                        <option value="web_url_phone" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                        <option value="web_url_location" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Location"); ?></option>

                                                                        <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>


                                                                        <option value="post_back"
                                                                                id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                        <option value="post_back"
                                                                                id="resubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("re-subscribe"); ?></option>

                                                                        <option value="post_back"
                                                                                id="human_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                        <option value="post_back"
                                                                                id="robot_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-10 col-sm-3">

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
                                                                     id="media_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && (strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false))) echo 'style="display: none;"'; ?>>
                                                                    <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="media_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           id="media_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']; ?>">
                                                                </div>

                                                                <div class="form-group"
                                                                     id="media_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?>>
                                                                    <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="media_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           id="media_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']; ?>">
                                                                </div>

                                                            </div>

                                                            <?php if ($i != 1) : ?>
                                                                <div class="col-2 col-sm-1" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'])) if (count($full_message[$k]['attachment']['payload']['elements'][0]['buttons']) != $i) echo 'style="display: none;"'; ?>>
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
                                                <input type="hidden" name="media_postback_sort_order_<?php echo $k; ?>"
                                                       id="media_postback_sort_order_<?php echo $k; ?>">


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
                                                    <label><?php echo $this->lang->line("Please provide your reply message"); ?>
                                                        <a href="#" data-placement="bottom" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("Spintax"); ?>"
                                                           data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                    class='bx bx-info-circle'></i> </a>
                                                    </label>

                                                    <?php if ($media_type == 'fb') : ?>
                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_last_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                        </span>
                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                        </span>
                                                    <?php else : ?>
                                                        <span class='float-right hidden'>
                          <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                             data-placement="top" data-toggle="tooltip"
                             class='btn btn-default btn-sm full_lead_tag_name button-outline'><i
                                      class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                        </span>

                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_FULL_NAME# variable inside your message. The variable will be replaced by real Full Name when we will send it.") ?>"
                             data-placement="top" data-toggle="tooltip"
                             class='btn btn-default btn-sm full_lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("Full Name") ?></a>
                        </span>
                                                    <?php endif; ?>

                                                    <div class="clearfix"></div>
                                                    <textarea class="form-control"
                                                              name="quick_reply_text_<?php echo $k; ?>"
                                                              id="quick_reply_text_<?php echo $k; ?>"><?php if (isset($full_message[$k]["template_type"]) && $full_message[$k]["template_type"] == 'quick reply') echo $full_message[$k]['text']; ?></textarea>
                                                </div>

                                                <!--   This hidden input is added by Konok to keep sorted order  -->
                                                <div id="quick_reply_sort_<?php echo $k; ?>">

                                                    <?php $quickreply_add_button_display = 0;
                                                    for ($i = 1; $i <= 11; $i++) : ?>
                                                        <div class="row button_border"
                                                             id="quick_reply_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['quick_replies'][$i - 1])) echo 'style="display: none;"'; else {
                                                            $quickreply_add_button_display++;
                                                        } ?> >
                                                            <div class="col-12 col-sm-4">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("button text"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="quick_reply_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           id="quick_reply_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           value="<?php if (isset($full_message[$k]['quick_replies'][$i - 1]['title'])) echo $full_message[$k]['quick_replies'][$i - 1]['title']; ?>" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && ($full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_phone_number' || $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_email')) echo 'readonly'; ?>>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-sm-4">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("button type"); ?></label>
                                                                    <select class="form-control select2 quick_reply_button_type_class"
                                                                            id="quick_reply_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                            name="quick_reply_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                        <option value="post_back" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'text') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                        <?php if ($media_type != 'ig') : ?>
                                                                            <option value="phone_number" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("User Phone Number"); ?></option>
                                                                            <option value="user_email" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'user_email') echo 'selected'; ?> ><?php echo $this->lang->line("User E-mail Address"); ?></option>
                                                                        <?php endif; ?>
                                                                        <!-- <option value="location" <?php if (isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) && $full_message[$k]['quick_replies'][$i - 1]['content_type'] == 'location') echo 'selected'; ?> ><?php echo $this->lang->line("User's Location"); ?></option> -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-10 col-sm-3">
                                                                <div class="form-group"
                                                                     id="quick_reply_postid_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['quick_replies'][$i - 1]['content_type']) || $full_message[$k]['quick_replies'][$i - 1]['content_type'] != 'text') echo 'style="display: none;"'; ?>>
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
                                                                <div class="col-2 col-sm-1" <?php if (isset($full_message[$k]['quick_replies'])) if (count($full_message[$k]['quick_replies']) != $i) echo 'style="display: none;"'; ?> >
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
                                                <input type="hidden" name="quick_reply_sort_order_<?php echo $k; ?>"
                                                       id="quick_reply_sort_order_<?php echo $k; ?>">


                                                <div class="row clearfix">
                                                    <div class="col-12 text-center">
                                                        <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($quickreply_add_button_display == 11) echo 'style="display : none;"'; ?>
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
                                                        <a href="#" data-placement="bottom" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("Spintax"); ?>"
                                                           data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                    class='bx bx-info-circle'></i> </a>
                                                    </label>

                                                    <?php if ($media_type == 'fb') : ?>
                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_last_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
                        </span>
                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>"
                             data-toggle="tooltip" data-placement="top" class='btn-sm lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
                        </span>
                                                    <?php else : ?>
                                                        <span class='float-right hidden'>
                          <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                             data-placement="top" data-toggle="tooltip"
                             class='btn btn-default btn-sm full_lead_tag_name button-outline'><i
                                      class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                        </span>

                                                        <span class='float-right'>
                          <a title="<?php echo $this->lang->line("You can include #LEAD_FULL_NAME# variable inside your message. The variable will be replaced by real Full Name when we will send it.") ?>"
                             data-placement="top" data-toggle="tooltip"
                             class='btn btn-default btn-sm full_lead_first_name button-outline'><i
                                      class='bx bx-user'></i> <?php echo $this->lang->line("Full Name") ?></a>
                        </span>
                                                    <?php endif; ?>


                                                    <div class="clearfix"></div>
                                                    <textarea class="form-control"
                                                              name="text_with_buttons_input_<?php echo $k; ?>"
                                                              id="text_with_buttons_input_<?php echo $k; ?>"><?php if (isset($full_message[$k]["template_type"]) && $full_message[$k]["template_type"] == 'text with buttons') echo $full_message[$k]['attachment']['payload']['text']; ?></textarea>
                                                </div>

                                                <!--   This hidden input is added by Konok to keep sorted order  -->
                                                <div id="text_button_sort_<?php echo $k; ?>">

                                                    <?php $textwithbutton_add_button_display = 0;
                                                    for ($i = 1; $i <= 3; $i++) : ?>
                                                        <div class="row button_border"
                                                             id="text_with_buttons_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                            $textwithbutton_add_button_display++;
                                                        } ?> >
                                                            <div class="col-12 col-sm-4">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("button text"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="text_with_buttons_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           id="text_with_buttons_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['title']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-4">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line("button type"); ?></label>
                                                                    <select class="form-control select2 text_with_button_type_class"
                                                                            id="text_with_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                            name="text_with_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                        <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                        <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                        <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web Url"); ?></option>

                                                                        <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                        <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                        <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Full]"); ?></option>

                                                                        <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Birthday"); ?></option>
                                                                        <option value="web_url_email" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Email"); ?></option>
                                                                        <option value="web_url_phone" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                        <option value="web_url_location" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Location"); ?></option>


                                                                        <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>


                                                                        <option value="post_back"
                                                                                id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                        <option value="post_back"
                                                                                id="resubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("re-subscribe"); ?></option>

                                                                        <option value="post_back"
                                                                                id="human_postback" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                        <option value="post_back"
                                                                                id="robot_postback" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-10 col-sm-3">
                                                                <div class="form-group"
                                                                     id="text_with_button_postid_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN' || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'style="display: none;"'; ?> >
                                                                    <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                    <?php $pname = "text_with_button_post_id_" . $i . "_" . $k; ?>
                                                                    <?php
                                                                    $pdefault = (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'postback') ? $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload'] : "";
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
                                                                     id="text_with_button_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']) && (strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false || strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false || strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false || strpos($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false))) echo 'style="display: none;"'; ?>>
                                                                    <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="text_with_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           id="text_with_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['url']; ?>">
                                                                </div>

                                                                <div class="form-group"
                                                                     id="text_with_button_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?>>
                                                                    <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                    <input type="text" class="form-control"
                                                                           name="text_with_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           id="text_with_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                           value="<?php if (isset($full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['buttons'][$i - 1]['payload']; ?>">
                                                                </div>

                                                            </div>

                                                            <?php if ($i != 1) : ?>
                                                                <div class="col-2 col-sm-1" <?php if (isset($full_message[$k]['attachment']['payload']['buttons'])) if (count($full_message[$k]['attachment']['payload']['buttons']) != $i) echo 'style="display: none;"'; ?>>
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
                                                <input type="hidden" name="text_button_sort_order_<?php echo $k; ?>"
                                                       id="text_button_sort_order_<?php echo $k; ?>">


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

                                                <div class="card card-secondary">
                                                    <div class="card-header">
                                                        <h4><?php echo $this->lang->line('Generic Template'); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="padding: 10px 20px;">

                                                            <div class="row">
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line("Please provide your reply image"); ?>
                                                                            <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>

                                                                        <span class="badge badge-status blue load_preview_modal float-right"
                                                                              item_type="image"
                                                                              file_path="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['image_url']; ?>"><i
                                                                                    class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                                        <input type="text"
                                                                               placeholder="<?php echo $this->lang->line('Put your image URL here or click the upload button.'); ?>"
                                                                               class="form-control"
                                                                               name="generic_template_image_<?php echo $k; ?>"
                                                                               id="generic_template_image_<?php echo $k; ?>"
                                                                               value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['image_url']; ?>"/>
                                                                        <div id="generic_image_<?php echo $k; ?>"><?php echo $this->lang->line('upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line("image click destination link"); ?>
                                                                            <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="generic_template_image_destination_link_<?php echo $k; ?>"
                                                                               id="generic_template_image_destination_link_<?php echo $k; ?>"
                                                                               value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['default_action']['url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['default_action']['url']; ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line("title"); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="generic_template_title_<?php echo $k; ?>"
                                                                               id="generic_template_title_<?php echo $k; ?>"
                                                                               value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['title']; ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line("sub-title"); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="generic_template_subtitle_<?php echo $k; ?>"
                                                                               id="generic_template_subtitle_<?php echo $k; ?>"
                                                                               value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'generic template' && isset($full_message[$k]['attachment']['payload']['elements'][0]['subtitle'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['subtitle']; ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <span class="float-right"><span
                                                                        style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></span>
                                                            <div class="clearfix"></div>

                                                            <!--   This hidden input is added by Konok to keep sorted order  -->
                                                            <div id="generic_button_sort_<?php echo $k; ?>">

                                                                <?php $generic_add_button_display = 0;
                                                                for ($i = 1; $i <= 3; $i++) : ?>
                                                                    <div class="row button_border"
                                                                         id="generic_template_row_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                                        $generic_add_button_display++;
                                                                    } ?> >
                                                                        <div class="col-12 col-sm-4">
                                                                            <div class="form-group">
                                                                                <label><?php echo $this->lang->line("button text"); ?></label>
                                                                                <input type="text" class="form-control"
                                                                                       name="generic_template_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                       id="generic_template_button_text_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['title']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4">
                                                                            <div class="form-group">
                                                                                <label><?php echo $this->lang->line("button type"); ?></label>
                                                                                <select class="form-control select2 generic_template_button_type_class"
                                                                                        id="generic_template_button_type_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                        name="generic_template_button_type_<?php echo $i; ?>_<?php echo $k; ?>">
                                                                                    <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                                    <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                                    <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web Url"); ?></option>

                                                                                    <?php if (!$hide_generic_item) : ?>
                                                                                        <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                                        <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                                        <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Full]"); ?></option>
                                                                                    <?php endif; ?>

                                                                                    <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Birthday"); ?></option>
                                                                                    <option value="web_url_email" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Email"); ?></option>
                                                                                    <option value="web_url_phone" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                                    <option value="web_url_location" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Location"); ?></option>

                                                                                    <?php if (!$hide_generic_item) : ?>
                                                                                        <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>


                                                                                        <option value="post_back"
                                                                                                id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                                        <option value="post_back"
                                                                                                id="resubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("re-subscribe"); ?></option>

                                                                                        <option value="post_back"
                                                                                                id="human_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                                        <option value="post_back"
                                                                                                id="robot_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                                    <?php endif; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-10 col-sm-3">
                                                                            <div class="form-group"
                                                                                 id="generic_template_button_postid_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN' || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'style="display: none;"'; ?>>
                                                                                <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                                <?php $pname = "generic_template_button_post_id_" . $i . "_" . $k; ?>
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
                                                                                 id="generic_template_button_web_url_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']) && (strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false))) echo 'style="display: none;"'; ?>>
                                                                                <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                                <input type="text" class="form-control"
                                                                                       name="generic_template_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                       id="generic_template_button_web_url_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['url']; ?>">
                                                                            </div>
                                                                            <div class="form-group"
                                                                                 id="generic_template_button_call_us_div_<?php echo $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?>>
                                                                                <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                                <input type="text" class="form-control"
                                                                                       name="generic_template_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                       id="generic_template_button_call_us_<?php echo $i; ?>_<?php echo $k; ?>"
                                                                                       value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['elements'][0]['buttons'][$i - 1]['payload']; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <?php if ($i != 1) : ?>
                                                                            <div class="col-2 col-sm-1" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][0]['buttons'])) if (count($full_message[$k]['attachment']['payload']['elements'][0]['buttons']) != $i) echo 'style="display: none;"'; ?>>
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
                                                                    <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($generic_add_button_display == 3) echo 'style="display : none;"'; ?>
                                                                            id="generic_template_add_button_<?php echo $k; ?>">
                                                                        <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div> <!-- end of card body -->
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
                                                         style="<?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1])) echo 'display: none;'; ?>">
                                                        <div class="card card-secondary">
                                                            <div class="card-header">
                                                                <h4 class="full_width">
                                                                    <?php echo $this->lang->line('Carousel Template') . ' ' . $j; ?>
                                                                    <?php if (isset($full_message[$k]['attachment']['payload']['elements']) && ($j != 1 && $j == count($full_message[$k]['attachment']['payload']['elements']))) : ?>
                                                                        <i class="bx bx-time-circle remove_carousel_template float-right red"
                                                                           previous_row_id="carousel_div_<?php echo $j - 1; ?>_<?php echo $k; ?>"
                                                                           current_row_id="carousel_div_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           counter_variable="carousel_template_counter_<?php echo $k; ?>"
                                                                           template_add_button="carousel_template_add_button_<?php echo $k; ?>"
                                                                           title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                                    <?php else : ?>
                                                                        <i class="bx bx-time-circle remove_carousel_template float-right red"
                                                                           style="display: none;"
                                                                           previous_row_id="carousel_div_<?php echo $j - 1; ?>_<?php echo $k; ?>"
                                                                           current_row_id="carousel_div_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                           counter_variable="carousel_template_counter_<?php echo $k; ?>"
                                                                           template_add_button="carousel_template_add_button_<?php echo $k; ?>"
                                                                           title="<?php echo $this->lang->line('Remove this item'); ?>"></i>
                                                                    <?php endif; ?>
                                                                </h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div style="padding: 10px 20px;">

                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6">
                                                                            <div class="form-group">
                                                                                <label><?php echo $this->lang->line("Please provide your reply image"); ?>
                                                                                    <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>

                                                                                <span class="badge badge-status blue load_preview_modal float-right"
                                                                                      item_type="image"
                                                                                      file_path="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url']; ?>"><i
                                                                                            class="bx bx-show"></i> <?php echo $this->lang->line('preview'); ?></span>

                                                                                <input type="text"
                                                                                       placeholder="<?php echo $this->lang->line('Put your image URL here or click the upload button.'); ?>"
                                                                                       class="form-control"
                                                                                       name="carousel_image_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       id="carousel_image_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['image_url']; ?>"/>
                                                                                <div id="generic_imageupload_<?php echo $j; ?>_<?php echo $k; ?>"><?php echo $this->lang->line('upload'); ?></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6">
                                                                            <div class="form-group">
                                                                                <label><?php echo $this->lang->line("image click destination link"); ?>
                                                                                    <span style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></label>
                                                                                <input type="text" class="form-control"
                                                                                       name="carousel_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       id="carousel_image_destination_link_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['default_action']['url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['default_action']['url']; ?>"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6">
                                                                            <div class="form-group">
                                                                                <label><?php echo $this->lang->line("title"); ?></label>
                                                                                <input type="text" class="form-control"
                                                                                       name="carousel_title_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       id="carousel_title_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['title']; ?>"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6">
                                                                            <div class="form-group">
                                                                                <label><?php echo $this->lang->line("sub-title"); ?></label>
                                                                                <input type="text" class="form-control"
                                                                                       name="carousel_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       id="carousel_subtitle_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                       value="<?php if (isset($full_message[$k]['template_type']) && $full_message[$k]['template_type'] == 'carousel' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['subtitle'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['subtitle']; ?>"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <span class="float-right"><span
                                                                                style='color:orange !important;'>(<?php echo $this->lang->line("optional"); ?>)</span></span>
                                                                    <div class="clearfix"></div>

                                                                    <!--   This hidden input is added by Konok to keep sorted order  -->
                                                                    <div id="carousel_button_sort_<?php echo $j; ?>_<?php echo $k; ?>">


                                                                        <?php $carousel_add_button_display = 0;
                                                                        for ($i = 1; $i <= 3; $i++) : ?>
                                                                            <div class="row button_border"
                                                                                 id="carousel_row_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1])) echo 'style="display: none;"'; else {
                                                                                $carousel_add_button_display++;
                                                                            } ?>>
                                                                                <div class="col-12 col-sm-4">
                                                                                    <div class="form-group">
                                                                                        <label><?php echo $this->lang->line("button text"); ?></label>
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="carousel_button_text_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                               id="carousel_button_text_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['title'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['title']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 col-sm-4">
                                                                                    <div class="form-group">
                                                                                        <label><?php echo $this->lang->line("button type"); ?></label>
                                                                                        <select class="form-control select2 carousel_button_type_class"
                                                                                                id="carousel_button_type_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                                name="carousel_button_type_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>">
                                                                                            <option value=""><?php echo $this->lang->line('please select a type'); ?></option>
                                                                                            <option value="post_back" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback') echo 'selected'; ?> ><?php echo $this->lang->line("Post Back"); ?></option>
                                                                                            <option value="web_url" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web Url"); ?></option>

                                                                                            <option value="web_url_compact" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio'] == 'compact') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Compact]"); ?></option>
                                                                                            <option value="web_url_tall" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio'] == 'tall') echo 'selected'; ?> ><?php echo $this->lang->line("WebView [Tall]"); ?></option>
                                                                                            <option value="web_url_full" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['webview_height_ratio'] == 'full') echo 'selected'; ?>><?php echo $this->lang->line("WebView [Full]"); ?></option>

                                                                                            <option value="web_url_birthday" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false) echo 'selected'; ?>><?php echo $this->lang->line("User's Birthday"); ?></option>
                                                                                            <option value="web_url_email" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Email"); ?></option>
                                                                                            <option value="web_url_phone" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Phone"); ?></option>
                                                                                            <option value="web_url_location" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) && strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false) echo 'selected'; ?> ><?php echo $this->lang->line("User's Location"); ?></option>

                                                                                            <option value="phone_number" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'phone_number') echo 'selected'; ?> ><?php echo $this->lang->line("call us"); ?></option>


                                                                                            <option value="post_back"
                                                                                                    id="unsubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("unsubscribe"); ?></option>
                                                                                            <option value="post_back"
                                                                                                    id="resubscribe_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER') echo 'selected'; ?> ><?php echo $this->lang->line("re-subscribe"); ?></option>

                                                                                            <option value="post_back"
                                                                                                    id="human_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Human"); ?></option>
                                                                                            <option value="post_back"
                                                                                                    id="robot_postback" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback' && isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'selected'; ?> ><?php echo $this->lang->line("Chat with Robot"); ?></option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-10 col-sm-3">
                                                                                    <div class="form-group"
                                                                                         id="carousel_button_postid_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] != 'postback' || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'UNSUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'RESUBSCRIBE_QUICK_BOXER' || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_HUMAN' || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] == 'YES_START_CHAT_WITH_BOT') echo 'style="display: none;"'; ?> >
                                                                                        <label><?php echo $this->lang->line("PostBack id"); ?></label>
                                                                                        <?php $pname = "carousel_button_post_id_" . $j . "_" . $i . "_" . $k; ?>
                                                                                        <?php
                                                                                        $pdefault = (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'postback') ? $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload'] : "";
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
                                                                                         id="carousel_button_web_url_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) || (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']) && (strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_birthdate') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_email') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_phone') !== false || strpos($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'], 'webview_builder/get_location') !== false))) echo 'style="display: none;"'; ?>>
                                                                                        <label><?php echo $this->lang->line("Web Url"); ?></label>
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="carousel_button_web_url_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                               id="carousel_button_web_url_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url'])) echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['url']; ?>">
                                                                                    </div>
                                                                                    <div class="form-group"
                                                                                         id="carousel_button_call_us_div_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>" <?php if (!isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) || $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] != 'phone_number') echo 'style="display: none;"'; ?> >
                                                                                        <label><?php echo $this->lang->line("Phone Number"); ?></label>
                                                                                        <input type="text"
                                                                                               class="form-control"
                                                                                               name="carousel_button_call_us_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                               id="carousel_button_call_us_<?php echo $j . "_" . $i; ?>_<?php echo $k; ?>"
                                                                                               value="<?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']) && $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['type'] == 'phone_number') echo $full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'][$i - 1]['payload']; ?>">
                                                                                    </div>
                                                                                </div>

                                                                                <?php if ($i != 1) : ?>
                                                                                    <div class="col-2 col-sm-1" <?php if (isset($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons'])) if (count($full_message[$k]['attachment']['payload']['elements'][$j - 1]['buttons']) != $i) echo 'style="display: none;"'; ?> >
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
                                                                            <button class="btn btn-outline-primary float-right no_radius btn-xs" <?php if ($carousel_add_button_display == 3) echo 'style="display : none;"'; ?>
                                                                                    id="carousel_add_button_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                                <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more button"); ?>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div> <!-- end of card body -->
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>

                                            </div>

                                            <!--   This hidden input is added by Konok to keep sorted order  -->
                                            <input type="hidden" name="carousel_reply_sort_order_<?php echo $k; ?>"
                                                   id="carousel_reply_sort_order_<?php echo $k; ?>">


                                            <div class="col-12 clearfix">
                                                <button id="carousel_template_add_button_<?php echo $k; ?>"
                                                        class="btn btn-sm btn-outline-primary float-right no_radius"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("add more template"); ?>
                                                </button>
                                            </div>

                                        </div>


                                    </div> <!-- end of empty style div -->
                                </div> <!-- end of card body  -->
                            </div>
                        <?php } ?>

                    </div>
                    <!--   This hidden input is added by Konok to keep sorted order  -->
                    <input type="hidden" name="main_reply_sort_order" id="main_reply_sort_order">

                    <div class="row">
                        <div class="col-12 clearfix">
                            <button id="multiple_template_add_button"
                                    class="btn btn-outline-primary float-right no_radius" <?php if ($active_reply_count == 6) echo 'style="display: none;"'; ?> >
                                <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('add more reply'); ?>
                            </button>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="row">
                        <div class="col-6">
                            <button id="submit" class="btn btn-primary"><i
                                        class="bx bx-send"></i> <?php echo $this->lang->line('Update'); ?></button>
                        </div>
                        <?php if ($default_template == '0') : ?>
                            <div class="col-6">
                                <a class="btn btn-secondary float-right"
                                   href="<?php echo base_url("messenger_bot/bot_settings/") . $page_info['id'] . '/1'; ?>"><i
                                            class="bx bx-time"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Back"); ?>
                                </a></button>
                            </div>
                        <?php elseif ($default_template == 'postback') : ?>
                            <div class="col-6">
                                <a class="btn btn-secondary float-right"
                                   href="<?php echo base_url("messenger_bot/template_manager"); ?>"><i
                                            class="bx bx-arrow-back"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Back"); ?>
                                </a></button>
                            </div>
                        <?php elseif ($default_template == 'errlog') : ?>
                            <div class="col-6">
                                <a class="btn btn-secondary float-right"
                                   href="<?php echo base_url("messenger_bot/bot_list"); ?>"><i
                                            class="bx bx-arrow-back"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Back"); ?>
                                </a></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <?php if ($iframe != "1") : ?>
                <div class="hidden-xs hidden-sm col-md-3 img_holder">
                    <div id="text_preview_div" style="">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/text.png')) echo site_url() . "assets/images/preview/text.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/text.png"; ?>"
                                    class="img-rounded" alt="Text Preview"></center>
                    </div>

                    <div id="image_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/image.png')) echo site_url() . "assets/images/preview/image.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/image.png"; ?>"
                                    class="img-rounded" alt="Image Preview"></center>
                    </div>

                    <div id="audio_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/mp3.png')) echo site_url() . "assets/images/preview/mp3.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/mp3.png"; ?>"
                                    class="img-rounded" alt="Audio Preview"></center>
                    </div>

                    <div id="video_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/video.png')) echo site_url() . "assets/images/preview/video.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/video.png"; ?>"
                                    class="img-rounded" alt="Video Preview"></center>
                    </div>

                    <div id="file_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/file.png')) echo site_url() . "assets/images/preview/file.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/file.png"; ?>"
                                    class="img-rounded" alt="File Preview"></center>
                    </div>

                    <div id="quick_reply_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/quick_reply.png')) echo site_url() . "assets/images/preview/quick_reply.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/quick_reply.png"; ?>"
                                    class="img-rounded" alt="Quick Reply Preview"></center>
                    </div>

                    <div id="text_with_buttons_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/button.png')) echo site_url() . "assets/images/preview/button.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/button.png"; ?>"
                                    class="img-rounded" alt="Text With Buttons Preview"></center>
                    </div>

                    <div id="generic_template_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/generic.png')) echo site_url() . "assets/images/preview/generic.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/generic.png"; ?>"
                                    class="img-rounded" alt="Generic Template Preview"></center>
                    </div>

                    <div id="carousel_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/carousel.png')) echo site_url() . "assets/images/preview/carousel.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/carousel.png"; ?>"
                                    class="img-rounded" alt="Carousel Template Preview"></center>
                    </div>

                    <div id="media_preview_div" style="display: none;">
                        <center><img
                                    src="<?php if (file_exists(FCPATH . 'assets/images/preview/media.png')) echo site_url() . "assets/images/preview/media.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/media.png"; ?>"
                                    class="img-rounded" alt="Media Template Preview"></center>
                    </div>

                </div>
            <?php endif; ?>

        </div>
        <br>
        <div id="submit_status" class="text-center"></div>
        <input type="hidden" name="hidden_media_type" id="hidden_media_type" value="<?php echo $media_type; ?>">

    </div> <!-- end of card body -->
</div>

<?php if ($iframe != '1') : ?>

<?php endif; ?>


<br>
<?php if ($this->session->flashdata('bot_success') === 1) { ?>
    <div class="alert alert-success text-center shadow-none" id="bot_success"><i
                class="bx bx-check"></i> <?php echo $this->lang->line("Bot settings has been updated successfully."); ?>
    </div>
<?php } ?>



<?php
$areyousure = $this->lang->line("are you sure");
$somethingwentwrong = $this->lang->line("something went wrong.");
$doyoureallywanttodeletethisbot = $this->lang->line("do you really want to delete this bot?");
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

<div class="modal fade" id="modal_for_preview" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-show"></i> <?php echo $this->lang->line('item preview'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
</div>