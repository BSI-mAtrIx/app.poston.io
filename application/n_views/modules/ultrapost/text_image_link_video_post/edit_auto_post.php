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

$image_upload_limit = 1;
if ($this->config->item('facebook_poster_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('facebook_poster_image_upload_limit');

$video_upload_limit = 10;
if ($this->config->item('facebook_poster_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');
?>


<style type="text/css">
    .card .card-header input {
        max-width: 100% !important;
    }

    .card .card-header h4 a {
        font-weight: 700 !important;
    }

    .input-group-text {
        background: #eee;
    }

    .card-body #tab_contents {
        border: solid 1px #dee2e6;
        border-top: 0;
        padding: 30px 20px 30px 20px;
    }
</style>


<?php if ($is_all_posted == 1): ?>
    <style type="text/css">

        .d_none_page {
            display: none;
        }

        .d_none_group {
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


<?php
if ($this->session->userdata("user_type") == "Admin" || in_array(74, $this->module_access)) $like_comment_Share_reply_block_class = "";
else $like_comment_Share_reply_block_class = "hidden";
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
                                href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Facebook Poster"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href='<?php echo base_url("ultrapost/text_image_link_video"); ?>'><?php echo $this->lang->line("Text/Image/Link/Video Posts"); ?></a>
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
                            <a id="text_post" class="nav-link post_type" data-toggle="tab" href="#textPost" role="tab"
                               aria-selected="false"><?php echo $this->lang->line('Text') ?></a>
                        </li>
                        <li class="nav-item">
                            <a id="link_post" class="nav-link post_type" data-toggle="tab" href="#linkPost" role="tab"
                               aria-selected="true"> <?php echo $this->lang->line("Link") ?></a>
                        </li>
                        <li class="nav-item">
                            <a id="image_post" class="nav-link post_type" data-toggle="tab" href="#imagePost" role="tab"
                               aria-selected="false"><?php echo $this->lang->line("Image"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a id="video_post" class="nav-link post_type" data-toggle="tab" href="#videoPost" role="tab"
                               aria-selected="false"><?php echo $this->lang->line("Video"); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" style="padding-top:0 !important;margin-top: -3px;">
                    <!-- tab body started -->
                    <div class="tab-content" id="post_tab_content">
                        <form action="#" enctype="multipart/form-data" id="edit_poster_form" method="post">
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
                                <label><?php echo $this->lang->line("Message"); ?></label>
                                <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                   title="<?php echo $this->lang->line("message") ?>"
                                   data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                            class='bx bx-info-circle'></i> </a>
                                <textarea class="form-control" name="message"
                                          id="message"><?php if (isset($all_data[0]['message'])) echo $all_data[0]['message']; ?></textarea>
                            </div>

                            <div id="link_block">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Paste link"); ?></label>
                                    <input class="form-control" name="link" id="link" type="text"
                                           value="<?php if (set_value('link')) echo set_value('link'); else {
                                               if (isset($all_data[0]['link'])) echo $all_data[0]['link'];
                                           } ?>">
                                </div>
                                <!-- <div class="form-group">
										<label>Preview image URL</label>
										<input class="form-control" name="link_preview_image" id="link_preview_image" type="text" value="<?php if (set_value('link_preview_image')) echo set_value('link_preview_image'); else {
                                    if (isset($all_data[0]['link_preview_image'])) echo $all_data[0]['link_preview_image'];
                                } ?>">
									</div>
									<div class="form-group">
			                             <div id="link_preview_upload"><?php echo $this->lang->line('Upload'); ?></div>
			                            <br/>
			                        </div> -->
                                <div class="form-group hidden">
                                    <label><?php echo $this->lang->line("Link caption"); ?></label>
                                    <input class="form-control" name="link_caption" id="link_caption" type="text">
                                </div>
                                <div class="form-group hidden">
                                    <label><?php echo $this->lang->line("Link description"); ?></label>
                                    <textarea class="form-control" name="link_description"
                                              id="link_description"></textarea>
                                </div>
                            </div>

                            <div id="image_block">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Image URL"); ?></label>
                                    <input class="form-control" name="image_url" id="image_url" type="text"
                                           value="<?php if (set_value('image_url')) echo set_value('image_url'); else {
                                               if (isset($all_data[0]['image_url'])) echo $all_data[0]['image_url'];
                                           } ?>">
                                </div>
                                <div class="form-group">
                                    <div id="image_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                    <br/>
                                </div>
                            </div>

                            <div id="video_block">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("Video URL"); ?></label>
                                            <input class="form-control" name="video_url" id="video_url" type="text"
                                                   value="<?php if (set_value('video_url')) echo set_value('video_url'); else {
                                                       if (isset($all_data[0]['video_url'])) echo $all_data[0]['video_url'];
                                                   } ?>">
                                        </div>
                                        <div class="form-group">
                                            <div id="video_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                            <br/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("Video thumbnail URL"); ?></label>
                                            <input class="form-control" name="video_thumb_url" id="video_thumb_url"
                                                   type="text"
                                                   value="<?php if (set_value('video_thumb_url')) echo set_value('video_thumb_url'); else {
                                                       if (isset($all_data[0]['video_thumb_url'])) echo $all_data[0]['video_thumb_url'];
                                                   } ?>">
                                        </div>
                                        <div class="form-group">
                                            <div id="video_thumb_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
                                $facebook_rx_fb_user_info_id = isset($fb_user_info[0]["id"]) ? $fb_user_info[0]["id"] : 0;
                                $facebook_rx_fb_user_info_name = isset($fb_user_info[0]["name"]) ? $fb_user_info[0]["name"] : "";
                                $facebook_rx_fb_user_info_access_token = isset($fb_user_info[0]["access_token"]) ? $fb_user_info[0]["access_token"] : "";

                                ?>
                            </div>


                            <div class="row">
                                <div class="col-12 col-md-6 d_none_page">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Post to pages'); ?></label>
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

                                <?php if ($facebook_poster_group != '0' && $this->is_group_posting_exist): ?>
                                    <div class="col-12 col-md-12 d_none_group">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("Post to groups"); ?></label>
                                            <select multiple class="select2 form-control" id="post_to_groups"
                                                    name="post_to_groups[]" style="width:100%;">
                                                <?php
                                                foreach ($fb_group_info as $key => $val) {
                                                    $id = $val['id'];
                                                    $group_name = $val['group_name'];
                                                    $group_ids = explode(',', $all_data[0]['group_ids']);
                                                    if (in_array($id, $group_ids))
                                                        echo "<option value='{$id}' selected>{$group_name}</option>";
                                                    else
                                                        echo "<option value='{$id}'>{$group_name}</option>";
                                                }
                                                ?>
                                            </select>
                                            <small class="label label-light red full-documentation"><i
                                                        class="bx bx-info-circle"></i> <?php echo $this->lang->line("For posting to group, you must need to install the APP in your groups. Click here to read the full instruction."); ?>
                                            </small>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <input type="hidden" name="schedule_type" value="later" id="schedule_type">

                                <!-- <div class="col-12 col-md-6 d_none_schedule">
										<div class="form-group">
											<label><?php echo $this->lang->line("Posting Time") ?>
												<a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Posting Time") ?>" data-content="<?php echo $this->lang->line("If you schedule a campaign, system will automatically process this campaign at mentioned time and time zone. Schduled campaign may take upto 1 hour longer than your schedule time depending on server's processing.") ?>"><i class='bx bx-info-circle'></i> </a>
											</label><br>
										  	<label class="custom-switch mt-2">
												<input type="checkbox" name="schedule_type" value="now" id="schedule_type" class="custom-control-input" checked>
												<label class="custom-control-label mr-1" for="schedule_type"></label>
												<span><?php echo $this->lang->line('Post Now'); ?></span>
										  	</label>
										</div>
									</div> -->
                            </div>

                            <div class="row d_none_schedule">
                                <div class="schedule_block_item col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Schedule time"); ?></label>
                                        <input placeholder="Time" name="schedule_time" id="schedule_time"
                                               class="form-control datepicker_x" type="text"
                                               value="<?php if (set_value('schedule_time')) echo set_value('schedule_time'); else {
                                                   if (isset($all_data[0]['schedule_time'])) echo $all_data[0]['schedule_time'];
                                               } ?>"/>
                                    </div>
                                </div>

                                <div class="schedule_block_item col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Time zone"); ?></label>
                                        <?php
                                        $time_zone[''] = 'Please Select';
                                        echo form_dropdown('time_zone', $time_zone, $all_data[0]['time_zone'], ' class="form-control" id="time_zone" required style="width:100%;"');
                                        ?>
                                    </div>
                                </div>

                                <div class=" schedule_block_item col-12 col-md-6">
                                    <div class="input-group">
                                        <label class="input-group-addon"><?php echo $this->lang->line('repost this post'); ?></label>
                                        <div class="input-group">
                                            <input type="number"
                                                   value="<?php if (isset($all_data[0]['repeat_times'])) echo $all_data[0]['repeat_times']; ?>"
                                                   class="form-control" name="repeat_times"
                                                   aria-describedby="basic-addon2">
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
                                <input type="hidden" name="submit_post_hidden" id="submit_post_hidden"
                                       value="<?php echo $all_data[0]["post_type"]; ?>">
                                <button class="btn btn-primary" submit_type="text_submit" id="submit_post"
                                        name="submit_post" type="button"><i
                                            class="bx bx-edit"></i> <?php echo $this->lang->line("Submit Post"); ?>
                                </button>
                                <a class="btn btn-light float-right"
                                   onclick='goBack("ultrapost/text_image_link_video",0)'><i
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
                            <img class="mr-3 rounded-circle" width="50" src="<?php echo $profile_picture; ?>"
                                 alt="avatar">
                            <div class="media-body">
                                <h6 class="media-title"><a href="#"><?php echo $facebook_rx_fb_user_info_name; ?></a>
                                </h6>
                                <div class="text-small text-muted">
                                    <?php echo isset($app_info[0]['app_name']) ? $app_info[0]['app_name'] : $this->config->item("product_short_name"); ?>
                                    <div class="bullet"></div>
                                    <span class="text-primary">Now</span></div>
                            </div>
                        </li>
                    </ul>

                    <span class="preview_message"><br/></span>

                    <div class="preview_video_block">
                        <video controls="" width="100%" poster="" style="border:1px solid #ccc">
                            <source src=""></source>
                        </video>
                        <br/>
                        <div class="video_preview_og_info_desc inline-block">
                        </div>
                    </div>

                    <div class="preview_img_block">
                        <div class="preLoader text-center" style="display: none;"></div>
                        <img src="<?php echo base_url('n_assets/img/placeholder.png'); ?>" class="preview_img"
                             alt="No Image Preview">
                        <div class="preview_og_info">
                            <div class="preview_og_info_title inline-block"></div>
                            <div class="preview_og_info_desc inline-block"></div>
                            <div class="preview_og_info_link inline-block"></div>
                        </div>
                    </div>

                    <div class="preview_only_img_block">
                        <img src="<?php echo base_url('n_assets/img/placeholder.png'); ?>" class="only_preview_img"
                             alt="No Image Preview">
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

    .preview_og_info {
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
        font-family: 'Times New Roman', helvetica, arial;

    }

    .preview_og_info_desc {
        margin-top: 5px;
        font-size: 13px;
    }

    .preview_og_info_link {
        text-transform: uppercase;
        color: #9197a3;
        margin-top: 7px;
    }

    .ms-choice span {
        padding-top: 2px !important;
    }

    .hidden {
        display: none;
    }

</style>


<div class="modal fade" id="full-documentation-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h3 class="modal-title"><?php echo $this->lang->line('How to install APP in group.'); ?></h3>
            </div>
            <div class="modal-body">
                <p>For posting to your Facebook groups you must need to install the app named
                    "<b><?php echo $current_app_name; ?></b>" in your Facebook group settings. The thumbnail of the app
                    "<b><?php echo $current_app_name; ?></b>" will be similar to the below image.</p>
                <div>
                    <img src="<?php echo $current_app_photo_url; ?>" alt="">
                </div>
                <br/>
                <p>You can follow the below steps to install the app "<b><?php echo $current_app_name; ?></b>" in your
                    Facebook group.</p>
                <ol>
                    <li>First, go to your Facebook group and click the "More" button. Then click the "Edit Group
                        Settings" menu from the dropdown list. As shown in the Step 1 section.
                    </li>
                    <li>Click on the "Add Apps" button in the Apps section. As shown in the Step 2 section.</li>
                    <li>Here a pop-up window will come from where you can browse apps for this group. In the search box
                        type "<b><?php echo $current_app_name; ?></b>" and then click on the app
                        "<b><?php echo $current_app_name; ?></b>" that matches your search result. As shown in Step 3
                        section.
                    </li>
                    <li>After clicking on the app "<b><?php echo $current_app_name; ?></b>" another pop-up windown will
                        appear. Now click on the "Add" button to add install this app in your group. As shown in Step 4
                        section.
                    </li>
                </ol>
                <br/>
                <h4 class="text-center"><b>Step 1</b></h4><br/>
                <img class="img-fluid"
                     src="<?php echo base_url('assets/images/group_posting_instructions/group_posting_instruction1.png'); ?>"
                     alt="">
                <br/>
                <h4 class="text-center"><b>Step 2</b></h4><br/>
                <img class="img-fluid"
                     src="<?php echo base_url('assets/images/group_posting_instructions/group_posting_instruction2.png'); ?>"
                     alt="">
                <br/>
                <h4 class="text-center"><b>Step 3</b></h4><br/>
                <img class="img-fluid"
                     src="<?php echo base_url('assets/images/group_posting_instructions/group_posting_instruction3.png'); ?>"
                     alt="">
                <br/>
                <h4 class="text-center"><b>Step 4</b></h4><br/>
                <img class="img-fluid"
                     src="<?php echo base_url('assets/images/group_posting_instructions/group_posting_instruction4.png'); ?>"
                     alt="">
                <br/>
                <h3 class="text-center"><b>You are done!</b></h3><br/>
            </div>
        </div>
    </div>
</div>
