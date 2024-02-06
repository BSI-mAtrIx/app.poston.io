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

$content_generator = file_exists(APPPATH.'modules/n_generator/include/modal_message_universal.php');
?>

<?php

$image_upload_limit = 1;
if ($this->config->item('facebook_poster_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('facebook_poster_image_upload_limit');

$video_upload_limit = 10;
if ($this->config->item('facebook_poster_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');
?>

<img src="<?php echo base_url('assets/pre-loader/Fading squares2.gif'); ?>" class="center-block previewLoader"
     style="margin-top:20px;margin-bottom:10px;display:none">


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

    }
</style>

<?php if ($is_all_posted == 1): ?>
    <style type="text/css">
        .d_none_page {
            display: none;
        }

        .d_none_template {
            display: none;
        }

        .d_none_schedule {
            display: none;
        }
    </style>
<?php endif; ?>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Facebook Poster"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href='<?php echo base_url("ultrapost/cta_post"); ?>'><?php echo $this->lang->line("CTA Posts"); ?></a>
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
                <div class="card-header"><h4><i
                                class="bx bx-list-ul"></i> <?php echo $this->lang->line('Campaign Update Form'); ?></h4>
                </div>
                <div class="card-body">
                    <!-- tab body started -->
                    <div class="tab-content">
                        <form action="#" enctype="multipart/form-data" id="cta_poster_form" method="post">
                            <input type="hidden" value="<?php echo $all_data[0]["id"]; ?>" name="id">
                            <input type="hidden" value="<?php echo $all_data[0]["user_id"]; ?>" name="user_id">
                            <input type="hidden" value="<?php echo $all_data[0]["facebook_rx_fb_user_info_id"]; ?>"
                                   name="facebook_rx_fb_user_info_id">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Campaign Name'); ?></label>
                                <input type="input" class="form-control" name="campaign_name" id="campaign_name"
                                       value="<?php if (set_value('campaign_name')) echo set_value('campaign_name'); else {
                                           if (isset($all_data[0]['campaign_name'])) echo $all_data[0]['campaign_name'];
                                       } ?>">
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->lang->line('Message'); ?></label>
                                <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                   title="<?php echo $this->lang->line("message") ?>"
                                   data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                            class='bx bx-info-circle'></i> </a>
                                <textarea class="form-control" name="message" id="message"
                                          placeholder="<?php echo $this->lang->line('Type your message here...'); ?>"><?php if (isset($all_data[0]['message'])) echo $all_data[0]['message']; ?></textarea>
                                <?php if($content_generator){ ?>
                                    <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal=".emojionearea-editor" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Paste link'); ?></label>
                                        <input class="form-control" name="link" id="link" type="text"
                                               value="<?php if (set_value('link')) echo set_value('link'); else {
                                                   if (isset($all_data[0]['link'])) echo $all_data[0]['link'];
                                               } ?>">
                                    </div>
                                    <div class="form-group hidden">
                                        <label><?php echo $this->lang->line('Preview image URL'); ?></label>
                                        <input class="form-control" name="link_preview_image" id="link_preview_image"
                                               type="text">
                                    </div>
                                    <div class="form-group hidden">
                                        <div id="link_preview_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                        <br/>
                                    </div>
                                    <div class="form-group hidden">
                                        <label><?php echo $this->lang->line('Title'); ?></label>
                                        <input class="form-control" name="link_caption" id="link_caption" type="text">
                                    </div>
                                    <div class="form-group hidden">
                                        <label><?php echo $this->lang->line('Description'); ?></label>
                                        <textarea class="form-control" name="link_description"
                                                  id="link_description"></textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('CTA button type'); ?></label>
                                        <?php echo form_dropdown("cta_type", $cta_dropdown, $all_data[0]["cta_type"], "class='form-control' id='cta_type'"); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group cta_value_container_div">
                                        <label><?php echo $this->lang->line('CTA button action link'); ?></label>
                                        <input type="input" class="form-control" name="cta_value" id="cta_value">
                                    </div>

                                    <?php
                                    $facebook_rx_fb_user_info_id = isset($fb_user_info[0]["id"]) ? $fb_user_info[0]["id"] : 0;
                                    $facebook_rx_fb_user_info_name = isset($fb_user_info[0]["name"]) ? $fb_user_info[0]["name"] : "";
                                    $facebook_rx_fb_user_info_access_token = isset($fb_user_info[0]["access_token"]) ? $fb_user_info[0]["access_token"] : "";
                                    ?>
                                </div>

                                <div class="col-12 col-md-6 d_none_page">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Post to pages'); ?>
                                            <a href="#" data-placement="right" data-toggle="popover"
                                               data-trigger="focus"
                                               title="<?php echo $this->lang->line("Select Page"); ?>"
                                               data-content="<?php echo $this->lang->line("Select the page you want to post. You can select multiple page to post."); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <select multiple class="select2 form-control" id="post_to_pages"
                                                name="post_to_pages[]" style="width:100%;">
                                            <?php
                                            foreach ($fb_page_info as $key => $val) {
                                                $id = $val['id'];
                                                $page_name = $val['page_name'];

                                                $page_ids = explode(',', $all_data[0]['page_ids']);

                                                if (in_array($id, $page_ids))
                                                    echo "<option value='{$id}' selected>{$page_name}</option>";
                                                else
                                                    echo "<option value='{$id}'>{$page_name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- start again -->
                                <div class="col-12 col-md-6 d_none_template">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Auto Reply Template'); ?></label>
                                        <select class="select2 form-control" id="auto_reply_template"
                                                name="auto_reply_template" style="width:100%;">
                                            <?php
                                            echo "<option value='0'>{$this->lang->line('Please select a template')}</option>";
                                            foreach ($auto_reply_template as $key => $val) {
                                                $id = $val['id'];
                                                $group_name = $val['ultrapost_campaign_name'];
                                                if ($id == $all_data[0]['ultrapost_auto_reply_table_id'])
                                                    echo "<option value='{$id}' selected>{$group_name}</option>";
                                                else
                                                    echo "<option value='{$id}'>{$group_name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="schedule_type" value="later" id="schedule_type">
                            </div>

                            <div class="row d_none_schedule">
                                <div class="schedule_block_item col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Schedule time'); ?></label>
                                        <input placeholder="Time" name="schedule_time" id="schedule_time"
                                               class="form-control datepicker_x" type="text"
                                               value="<?php if (set_value('schedule_time')) echo set_value('schedule_time'); else {
                                                   if (isset($all_data[0]['schedule_time'])) echo $all_data[0]['schedule_time'];
                                               } ?>"/>
                                    </div>
                                </div>

                                <div class="schedule_block_item col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Time zone'); ?></label>
                                        <?php
                                        $time_zone[''] = 'Please Select';
                                        echo form_dropdown('time_zone', $time_zone, $all_data[0]['time_zone'], ' class="select2 form-control" id="time_zone" required style="width:100%;"');
                                        ?>
                                    </div>
                                </div>

                                <div class=" schedule_block_item col-12 col-md-6">
                                    <div class="input-group">
                                        <label class="input-group-addon"><?php echo $this->lang->line('Repost this post'); ?></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control"
                                                   value="<?php if (isset($all_data[0]['repeat_times'])) echo $all_data[0]['repeat_times']; ?>"
                                                   name="repeat_times" aria-describedby="basic-addon2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><?php echo $this->lang->line('Times'); ?></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="schedule_block_item">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('time interval'); ?></label>
                                            <?php

                                            $time_interval[''] = $this->lang->line('Please Select Periodic Time Schedule');
                                            echo form_dropdown('time_interval', $time_interval, $all_data[0]['time_interval'], ' class="select2 form-control" id="time_interval" required style="width:100%;"');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="card-footer p-0">
                                <button class="btn btn-primary" submit_type="text_submit" id="submit_post"
                                        name="submit_post" type="button"><i
                                            class="bx bx-edit"></i> <?php echo $this->lang->line("Update Campaign") ?>
                                </button>
                                <a class="btn btn-light float-right" onclick='goBack("ultrapost/cta_post",0)'><i
                                            class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- preview section -->
        <div class="col-12 col-md-5 colmid d-none d-sm-block">
            <div class="card main_card">
                <div class="card-header"><h4><i class="bx bxl-facebook"></i> <?php echo $this->lang->line('Preview'); ?>
                    </h4></div>
                <div class="card-body">
                    <div class="section-title text-info" style="margin: -30px 0px 10px 0px; font-weight: normal;">
                        <?php echo $this->lang->line('This preview may differ with actual post.'); ?>
                    </div>
                    <?php $profile_picture = "https://graph.facebook.com/me/picture?access_token={$facebook_rx_fb_user_info_access_token}&width=150&height=150"; ?>
                    <ul class="list-unstyled list-unstyled-border">
                        <li class="media">
                            <img class="mr-3 rounded-circle" width="50" height="50"
                                 src="<?php echo $profile_picture; ?>" alt="avatar">
                            <div class="media-body">
                                <h6 class="media-title"><a href="#"><?php echo $facebook_rx_fb_user_info_name; ?></a>
                                </h6>
                                <div class="text-small text-muted"><?php echo isset($app_info[0]['app_name']) ? $app_info[0]['app_name'] : $this->config->item("product_short_name"); ?>
                                    <div class="bullet"></div>
                                    <span class="text-primary"><?php echo $this->lang->line('Now'); ?></span>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <span class="preview_message"><br/></span>

                    <img src="<?php echo base_url('n_assets/img/placeholder.png'); ?>" class="preview_img"
                         alt="No Image Preview">
                    <div class="preLoader text-center" style="display: none;"></div>
                    <div class="preview_og_info clearfix">
                        <div class="preview_og_info_title inline-block"></div>
                        <div class="preview_og_info_desc inline-block">
                        </div>
                        <div class="preview_og_info_link inline-block pull-left">
                        </div>
                        <div class="button_container"><a
                                    class="cta-btn btn btn-sm btn-default float-right"><?php echo $this->lang->line('Message Page'); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="response_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h3 class="modal-title"><?php echo $this->lang->line('Update Campaign Status'); ?></h3>
            </div>
            <div class="modal-body">
                <div class="alert text-center" id="response_modal_content">
                </div>
            </div>
        </div>
    </div>
</div>


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

    .preview_og_info {
        border: 1px solid #ccc;
        box-shadow: 0px 0px 2px #ddd;
        -webkit-box-shadow: 0px 0px 2px #ddd;
        -moz-box-shadow: 0px 0px 2px #ddd;
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
        text-transform: uppercase;
        color: #9197a3;
        margin-top: 7px;
        font-size: 10px;
    }

    .ms-choice span {
        padding-top: 2px !important;
    }

    .hidden {
        display: none;
    }

    .btn-default {
        background: #fff;
        border-color: #ccc;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        padding: 3px 5px;
        color: #555;
    }

    .btn-default:hover {
        background: #eee;
        border-color: #ccc;
        color: #555;
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