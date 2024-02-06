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

$video_upload_limit = 30;
if ($this->config->item('allowed_video_size') != '')
    $video_upload_limit = $this->config->item('allowed_video_size');

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

    .video_format {
        cursor: pointer;
    }

    .thumbnail_format {
        cursor: pointer;
    }

    .share_crosspost_mean {
        cursor: pointer;
    }

    .img-fluid {
        max-width: 100%;
    }

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
                                href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Facebook Poster"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("vidcasterlive/live_scheduler_list"); ?>"><?php echo $this->lang->line("Livestreaming"); ?></a>
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
                                class="bx bx-list-ul"></i> <?php echo $this->lang->line('Campaign Form'); ?></h4></div>
                <div class="card-body">
                    <form action="#" enctype="multipart/form-data" id="live_scheduler_form" method="post">

                        <input type="hidden" name="hidden_id" value="<?php echo $xdata[0]["id"]; ?>">
                        <div class="form-group">
                            <label><?php echo $this->lang->line("Campaign Name"); ?></label>
                            <input type="input" value='<?php echo $xdata[0]["scheduler_name"]; ?>' class="form-control"
                                   name="scheduler_name" id="scheduler_name">
                        </div>
                        <div class="form-group">
                            <label><?php echo $this->lang->line("Post Content"); ?></label>
                            <textarea class="form-control" name="message"
                                      id="message"><?php echo $xdata[0]["message"]; ?></textarea>
                            <?php if($content_generator){ ?>
                                <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal=".emojionearea-editor" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line("Broadcast pre-recorded video from system"); ?></label><br/>
                            <div class="row">
                                <div class="col-12 col-md-5">
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="use_system_video" id="use_system_video_1" value="yes"
                                               class="custom-control-input" <?php if ($xdata[0]["use_system_video"] == "yes") echo "checked"; ?> >
                                        <label class="custom-control-label mr-1" for="use_system_video_1"></label>
                                        <span><?php echo $this->lang->line('Yes'); ?></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="use_system_video" id="use_system_video_2" value="no"
                                               class="custom-control-input" <?php if ($xdata[0]["use_system_video"] == "no") echo "checked"; ?> >
                                        <label class="custom-control-label mr-1" for="use_system_video_2"></label>
                                        <span><?php echo $this->lang->line("No (I'll use third party broadcasting software)"); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row system_video">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Upload Video"); ?> <i
                                                class='blue bx bx-info-circle video_format'></i></label>
                                    <div class="form-group">
                                        <div id="live_video_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                    </div>
                                    <input class="preview_video_block" type="hidden" name="scheduled_video_url"
                                           value="<?php echo $xdata[0]["scheduled_video_url"]; ?>"
                                           id="scheduled_video_url">
                                    <a id="play-video" class="btn btn-sm btn-default btn-xs border_gray"><i
                                                class="bx bx-play-circle blue"></i> <?php echo $this->lang->line("Play Video"); ?>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <?php
                        $video_height = array(
                            '1920' => '1920',
                            '1280' => '1280',
                            '1080' => '1080',
                            '854' => '854',
                            '720' => '720',
                            '640' => '640',
                            '540' => '540',
                            '480' => '480',
                            '360' => '360'
                        );

                        $video_width = array(
                            '1920' => '1920',
                            '1280' => '1280',
                            '1080' => '1080',
                            '854' => '854',
                            '720' => '720',
                            '640' => '640',
                            '540' => '540',
                            '480' => '480',
                            '360' => '360'
                        );
                        ?>

                        <div class="row system_video">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Video width"); ?></label>
                                    <?php
                                    $video_width[''] = $this->lang->line('Please Select');
                                    echo form_dropdown('video_width', $video_width, $xdata[0]["video_width"], ' class="select2 form-control" id="video_width"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Video height"); ?></label>
                                    <?php
                                    $video_height[''] = $this->lang->line('Please Select');
                                    echo form_dropdown('video_height', $video_height, $xdata[0]["video_height"], ' class="select2 form-control" id="video_height"');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line("Schedule Type"); ?> *</label><br/>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="schedule_type" id="schedule_type_1" value="now"
                                               class="custom-control-input" <?php if ($xdata[0]["schedule_type"] == "now") echo "checked"; ?> >
                                        <label class="custom-control-label mr-1" for="schedule_type_1"></label>
                                        <span><?php echo $this->lang->line('Now'); ?></span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="schedule_type" id="schedule_type_2" value="later"
                                               class="custom-control-input" <?php if ($xdata[0]["schedule_type"] == "later") echo "checked"; ?> >
                                        <label class="custom-control-label mr-1" for="schedule_type_2"></label>
                                        <span><?php echo $this->lang->line('Later'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="hide_if_now">

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item">
                                        <label><?php echo $this->lang->line("Planned time to go live"); ?> *</label>
                                        <input name="schedule_time" id="schedule_time"
                                               value='<?php echo $xdata[0]["schedule_time"]; ?>'
                                               class="form-control date_time_picker" type="text"/>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item">
                                        <label><?php echo $this->lang->line("Time zone"); ?> *</label>
                                        <?php
                                        $time_zone[''] = $this->lang->line("Please Select");
                                        echo form_dropdown('time_zone', $time_zone, $xdata[0]["time_zone"], ' class="select2 form-control" id="time_zone" required');
                                        ?>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <input name="create_event" <?php if ($xdata[0]["create_event"] == "1") echo "checked"; ?>
                                       value="1" id="create_event_yes" type="radio">
                                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line("I want to create live event now."); ?>
                                <br/>
                                <input name="create_event" <?php if ($xdata[0]["create_event"] == "0") echo "checked"; ?>
                                       value="0" id="create_event_no" type="radio">
                                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line("I do not want to create live event, go live directly."); ?>
                            </div>

                            <div class="hide_if_no">
                                <div class="form-group hidden">
                                    <label><?php echo $this->lang->line("Thumbnail Image URL"); ?></label>
                                    <input class="form-control" value="<?php echo $xdata[0]["image_url"]; ?>"
                                           name="image_url" id="image_url" type="text">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Upload Thumbnail Image"); ?> <i
                                                class='blue bx bx-info-circle thumbnail_format'></i></label>
                                    <div id="image_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                    <a id="play-image" class="btn btn-sm btn-default btn-xs border_gray"><i
                                                class="bx bx-show blue"></i> <?php echo $this->lang->line("view image"); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <?php
                            $facebook_rx_fb_user_info_id = isset($fb_user_info[0]["id"]) ? $fb_user_info[0]["id"] : 0;
                            $facebook_rx_fb_user_info_name = isset($fb_user_info[0]["name"]) ? $fb_user_info[0]["name"] : "";
                            $facebook_rx_fb_user_info_access_token = isset($fb_user_info[0]["access_token"]) ? $fb_user_info[0]["access_token"] : "";
                            $profile_picture = "https://graph.facebook.com/me/picture?access_token={$facebook_rx_fb_user_info_access_token}&width=150&height=150";
                            ?>
                            <?php
                            $page_or_group_or_user = $xdata[0]["page_or_group_or_user"];
                            $page_or_group_or_user_id = $xdata[0]["page_group_user_id"];
                            $facebook_rx_fb_user_info_id = $xdata[0]["facebook_rx_fb_user_info_id"];
                            ?>
                            <label><?php echo $this->lang->line("Post to page/group"); ?> *</label>
                            <select class="select2 form-control" name="post_to" id="post_to">
                                <!-- <option <?php if ($page_or_group_or_user == 'user') echo 'selected'; ?> value="profile-<?php echo $facebook_rx_fb_user_info_id; ?>" picture="<?php echo $profile_picture; ?>" display_name="<?php echo $facebook_rx_fb_user_info_name; ?>" ><?php echo $facebook_rx_fb_user_info_name . " (" . $this->lang->line('Timeline') . ")"; ?></option> -->
                                <?php
                                foreach ($fb_page_info as $key => $val) {
                                    $id = $val['id'];
                                    $page_name = $val['page_name'];
                                    $page_profile = $val['page_profile'];
                                    $checked = '';
                                    if ($page_or_group_or_user == 'page' && $id == $page_or_group_or_user_id) $checked = 'selected';

                                    echo '<option value="page-' . $id . '" ' . $checked . ' picture="' . $page_profile . '" display_name="' . $page_name . '" >' . $page_name . ' (' . $this->lang->line("Page") . ')</option>';
                                }
                                ?>
                                <?php
                                foreach ($fb_group_info as $key => $val) {
                                    $id = $val['id'];
                                    $group_name = $val['group_name'];
                                    $group_profile = $val['group_profile'];
                                    $checked = '';
                                    if ($page_or_group_or_user == 'group' && $id == $page_or_group_or_user_id) $checked = 'selected';

                                    echo '<option value="group-' . $id . '" ' . $checked . ' picture="' . $group_profile . '" display_name="' . $group_name . '" >' . $group_name . ' (' . $this->lang->line("Group") . ')</option>';
                                }
                                ?>
                            </select>

                        </div>

                        <br>
                        <?php
                        if ($this->session->userdata("user_type") == "Admin" || in_array(254, $this->module_access)) $like_comment_Share_reply_block_class = "";
                        else $like_comment_Share_reply_block_class = "hidden";
                        ?>

                        <div id="like_comment_Share_reply_block"
                             class="<?php echo $like_comment_Share_reply_block_class; ?>">

                            <div class="form-group">
                                <label><?php echo $this->lang->line("Auto share as pages / Crosspost to pages"); ?> <i
                                            class='blue bx bx-info-circle share_crosspost_mean'></i></label>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="share_or_cross" id="share_or_cross_1"
                                                   value="nothing"
                                                   class="custom-control-input" <?php if ($xdata[0]["share_or_cross"] == "nothing") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="share_or_cross_1"></label>
                                            <span><?php echo $this->lang->line('Nothing'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="share_or_cross" id="share_or_cross_2"
                                                   value="crossposting"
                                                   class="custom-control-input" <?php if ($xdata[0]["share_or_cross"] == "crossposting") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="share_or_cross_2"></label>
                                            <span><?php echo $this->lang->line('Crossposting'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="share_or_cross" id="share_or_cross_3"
                                                   value="auto_share"
                                                   class="custom-control-input" <?php if ($xdata[0]["share_or_cross"] == "auto_share") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="share_or_cross_3"></label>
                                            <span><?php echo $this->lang->line('Auto share as pages'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group crosspost_block hidden">
                                <label><?php echo $this->lang->line("Crosspost to pages (only works for page post)"); ?></label><br/>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="crosspost_enable_disable"
                                                   id="crosspost_enable_disable_1" value="1"
                                                   class="custom-control-input" <?php if ($xdata[0]["crosspost_enable_disable"] == "1") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1"
                                                   for="crosspost_enable_disable_1"></label>
                                            <span><?php echo $this->lang->line('Enable'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="crosspost_enable_disable"
                                                   id="crosspost_enable_disable_2" value="0"
                                                   class="custom-control-input" <?php if ($xdata[0]["crosspost_enable_disable"] == "0") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1"
                                                   for="crosspost_enable_disable_2"></label>
                                            <span><?php echo $this->lang->line('Disable'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group crosspost_block_item">
                                <label><?php echo $this->lang->line("Select pages for Crosspost"); ?> *</label>
                                <select multiple="multiple" class="select2 form-control"
                                        id="crosspost_this_post_by_pages" name="crosspost_this_post_by_pages[]">
                                    <?php
                                    $crosspost_this_post_by_pages = json_decode($xdata[0]["crosspost_this_post_by_pages"], true);
                                    foreach ($fb_page_info as $key => $val) {
                                        $page_id = $val['page_id'];
                                        $page_name = $val['page_name'];
                                        if (in_array($page_id, $crosspost_this_post_by_pages))
                                            echo "<option selected='selected' value='{$page_id}'>{$page_name}</option>";
                                        else
                                            echo "<option value='{$page_id}'>{$page_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group auto_share_block hidden">
                                <label><?php echo $this->lang->line("Auto share this post (only works for page post)"); ?></label><br/>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_share_post" id="auto_share_post_1" value="1"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_share_post"] == "1") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="auto_share_post_1"></label>
                                            <span><?php echo $this->lang->line('Enable'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_share_post" id="auto_share_post_2" value="0"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_share_post"] == "0") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="auto_share_post_2"></label>
                                            <span><?php echo $this->lang->line('Disable'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group hidden">
                                <label><?php echo $this->lang->line("Auto share to timeline"); ?></label><br/>
                                <input name="auto_share_to_profile" <?php if ($xdata[0]["auto_share_to_profile"] == "1") echo "checked"; ?>
                                       value="<?php echo $facebook_rx_fb_user_info_id; ?>"
                                       id="auto_share_to_profile_yes"
                                       type="radio"> <?php echo $this->lang->line("Share to timeline"); ?>
                                (<?php echo $facebook_rx_fb_user_info_name; ?>) &nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="auto_share_to_profile" <?php if ($xdata[0]["auto_share_to_profile"] == "0") echo "checked"; ?>
                                       value="No" id="auto_share_to_profile_no"
                                       type="radio"> <?php echo $this->lang->line("No, do not share"); ?>
                            </div>

                            <div class="form-group auto_share_post_block_item">
                                <label><?php echo $this->lang->line("Select pages for auto share"); ?> *</label>
                                <select multiple="multiple" class="select2 form-control"
                                        id="auto_share_this_post_by_pages" name="auto_share_this_post_by_pages[]">
                                    <?php
                                    $auto_share_this_post_by_pages = json_decode($xdata[0]["auto_share_this_post_by_pages"], true);
                                    foreach ($fb_page_info as $key => $val) {
                                        $id = $val['id'];
                                        $page_name = $val['page_name'];
                                        if (in_array($id, $auto_share_this_post_by_pages))
                                            echo "<option selected='selected' value='{$id}'>{$page_name}</option>";
                                        else
                                            echo "<option value='{$id}'>{$page_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group hidden">
                                <label><?php echo $this->lang->line("Auto like this post as all other pages (only works for page post)"); ?></label><br/>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_like_post" id="auto_like_post_1" value="1"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_like_post"] == "1") echo "checked"; ?>>
                                            <label class="custom-control-label mr-1" for="auto_like_post_1"></label>
                                            <span><?php echo $this->lang->line('Enable'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_like_post" id="auto_like_post_2" value="0"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_like_post"] == "0") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="auto_like_post_2"></label>
                                            <span><?php echo $this->lang->line('Disable'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group hidden">
                                <label><?php echo $this->lang->line("Auto private reply on user comments"); ?></label><br/>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_private_reply" id="auto_private_reply_1"
                                                   value="1"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_private_reply"] == "1") echo "checked"; ?>>
                                            <label class="custom-control-label mr-1" for="auto_private_reply_1"></label>
                                            <span><?php echo $this->lang->line('Enable'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_private_reply" id="auto_private_reply_2"
                                                   value="0"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_private_reply"] == "0") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="auto_private_reply_2"></label>
                                            <span><?php echo $this->lang->line('Disable'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group auto_reply_block_item">
                                <label><?php echo $this->lang->line("Private reply"); ?> *</label>
                                <textarea class="form-control" name="auto_private_reply_text"
                                          id="auto_private_reply_text"><?php echo $xdata[0]["auto_private_reply"]; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php echo $this->lang->line("Auto comment"); ?></label><br/>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_comment" id="auto_comment_1" value="1"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_comment"] == "1") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="auto_comment_1"></label>
                                            <span><?php echo $this->lang->line('Enable'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="auto_comment" id="auto_comment_2" value="0"
                                                   class="custom-control-input" <?php if ($xdata[0]["auto_comment"] == "0") echo "checked"; ?> >
                                            <label class="custom-control-label mr-1" for="auto_comment_2"></label>
                                            <span><?php echo $this->lang->line('Disable'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group auto_comment_block_item">
                                <label><?php echo $this->lang->line("Comment"); ?> *</label>
                                <textarea class="form-control" name="auto_comment_text"
                                          id="auto_comment_text"><?php echo $xdata[0]["auto_comment_text"]; ?></textarea>
                            </div>

                        </div>

                        <div class="clearfix">
                            <button class="btn btn-primary" id="submit_post" name="submit_post" type="button"><i
                                        class="bx bx-duplicate"></i> <?php echo $this->lang->line("Clone Campaign"); ?>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>  <!-- end of col-6 left part -->

        <div class="col-12 col-md-5 colmid">
            <div class="card main_card">
                <div class="card-header"><h4><i class="bx bxl-facebook"></i> <?php echo $this->lang->line('Preview'); ?>
                    </h4></div>
                <div class="card-body">
                    <div class="preview">

                        <img src="<?php echo $profile_picture; ?>"
                             class="preview_cover_img inline pull-left text-center" alt="X">
                        <span class="preview_page"><?php echo $facebook_rx_fb_user_info_name; ?></span><span
                                id="live_text" style="color:#9197a3;"> plans to go live.</span><br/>
                        <span class="preview_page_sm">Now <?php echo isset($app_info[0]['app_name']) ? $app_info[0]['app_name'] : $this->config->item("product_short_name"); ?></span><br/><br/>
                        <span class="preview_message"><br/></span>
                        <div class="preview_only_img_block">
                            <div class="row" style="padding-top:100px;padding-left:30px">
                                <div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                                    <img src="<?php echo $profile_picture; ?>" alt="Thumb"
                                         style="width:100px;height:100px;border-radius:100px;padding:2px;background: #fff"
                                         ; class="schedule_image_preview">
                                </div>
                                <div class="col-12 col-mg-9 col-lg-9">
                                    <span class="schedule_time_preview"
                                          style="color:#fff;font-size:18px;font-weight: bold;"><?php $cur_date = date("-m-d H:i:s");
                                        echo date("F j", strtotime($cur_date)) . " at " . date("g:ia", strtotime($cur_date)); ?></span><br/>
                                    <span class="schedule_page_preview" style="color:#fff"><span
                                                class="schedule_page_preview_name"><?php echo $facebook_rx_fb_user_info_name; ?></span> plans to go live</span><br/>
                                    <a href="#" class="btn btn-light"
                                       style="background: transparent;color:#fff;padding:10px 20px;margin-top:7px;"> <i
                                                class="bx bx-calendar"></i> Get Reminder</a>
                                </div>
                            </div>
                        </div>

                        <div class="preview_direct_block">
                            <img src="<?php echo base_url('assets/images/video-thumbnail.jpg'); ?>" alt="Thumb"
                                 class="img-fluid">
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- end of col-6 right part -->
    </div>
</div>


<?php
$xauto_share_post = $xdata[0]["auto_share_post"];
$xauto_private_reply = $xdata[0]["auto_private_reply"];
$xauto_comment = $xdata[0]["auto_comment"];
$xcreate_event = $xdata[0]["create_event"];
$user_id = $this->session->userdata("user_id");
?>


<div class="modal fade" id="share_crosspost_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-repost"></i> <?php echo $this->lang->line("Share/Crossposting"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="section">
                    <div class="alert alert-info alert-has-icon">
                        <div class="alert-icon"><i class="bx bx-bulb"></i></div>
                        <div class="alert-body">
                            <div class="alert-title"><?php echo $this->lang->line('Info'); ?></div>
                            <?php echo $this->lang->line('This feature only works for Page post. It will not work if you go live to your any Groups.'); ?>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <h2 class="section-title"><?php echo $this->lang->line('Share'); ?></h2>
                    <p><?php echo $this->lang->line("Live video share means, other pages will share the actual broadcast video link to their site. Visitor can see from which page the actual broadcasting is happening. "); ?></p>
                </div>

                <div class="section">
                    <h2 class="section-title"><?php echo $this->lang->line('Crossposting'); ?></h2>
                    <p><?php echo $this->lang->line("Crossposting refers to streaming live broadcast to multiple Facebook pages without uploading to each pages or sharing the original live video.") . "<br/><br/>" . $this->lang->line("You will need setup one page for live streaming, and other page will crosspost the same live video as their page name. No one can determine in which page, the actual live broadcasting happening. Each page will broadcast the live video with its own comments & reactions from each page.") . "<br/><br/>" . $this->lang->line("You will also find details about Facebook Live Crossposting here") . " <a target='_blank' href='https://www.facebook.com/business/help/1385580858214929?id=1123223941353904'>https://www.facebook.com/business/help/1385580858214929?id=1123223941353904</a>"; ?></p>
                </div>

            </div>

            <div class="modal-footer">
                <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line("Close") ?></a>
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
                <h3 class="modal-title"><i
                            class="bx bx-flag"></i> <?php echo $this->lang->line("Live Campaign Status"); ?></h3>
            </div>
            <div class="modal-body">
                <div class="alert text-center" id="response_modal_content">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-live-video-library" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h3 class="modal-title"><i class="bx bxl-youtube"></i> <?php echo $this->lang->line("Video Library"); ?>
                </h3>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-play" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h3 class="modal-title"><i
                            class="bx bx-video"></i> <?php echo $this->lang->line("Image/Video Preview"); ?></h3>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>


<style type="text/css" media="screen">
    .box-header {
        border-bottom: 1px solid #ccc !important;
        margin-bottom: 15px;
    }

    .box-primary {
        border: 1px solid #ccc !important;
    }

    .box-footer {
        border-top: 1px solid #ccc !important;
    }

    .padding-5 {
        padding: 5px;
    }

    .padding-20 {
        padding: 20px;
    }

    .box-header {
        color: #3C8DBC;
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

    .only_preview_img {
        width: 100%;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    .ms-choice span {
        padding-top: 2px !important;
    }

    .hidden {
        display: none;
    }

    .preview_only_img_block {
        width: 100%;
        height: 300px;
        background: url('<?php echo base_url("assets/images/demo_live.jpg");?>') no-repeat;
        background-size: cover;
    }

    .btn-default:hover {
        background: transparent !important;
        border-color: #fff
    }

    .box-primary {
        -webkit-box-shadow: 0px 2px 14px -5px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 0px 2px 14px -5px rgba(0, 0, 0, 0.75);
        box-shadow: 0px 2px 14px -5px rgba(0, 0, 0, 0.75);
    }

    .ajax-upload-dragdrop {
        width: 100% !important;
    }

    .well {
        border-radius: 0;
    }

    label {
        color: orange;
    }

    .table-responsive label {
        color: #000;
    }

    .table-responsive label:hover {
        cursor: pointer;
    }
</style>