<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
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


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/bulk_comment_reply_campaign_list"); ?>"><?php echo $this->lang->line("Campaign List"); ?></a>
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
                    <form action="#" enctype="multipart/form-data" id="bulk_comment_reply_campaign_form" method="post">
                        <input type="hidden" name="campaign_id" value="<?php echo $xdata[0]["id"]; ?>">
                        <input type="hidden" name="bulk_comment_reply_campaign_enabled_post_list_id"
                               value="<?php echo $xdata[0]["tag_machine_enabled_post_list_id"]; ?>"
                               id="bulk_comment_reply_campaign_enabled_post_list_id">

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("campaign name") ?> *
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("campaign name"); ?>"
                                           data-content="<?php echo $this->lang->line("put a name so that you can identify it later"); ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <input value="<?php echo $xdata[0]["campaign_name"]; ?>" type="text"
                                           class="form-control" name="campaign_name2" id="campaign_name2">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("reply same commenter multiple times?") ?>
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("reply same commenter multiple times?") ?>"
                                           data-content="<?php echo $this->lang->line("same user may comment multiple time, do you want to reply all of them or not.") ?>"><i
                                                    class='bx bx-info-circle'></i></a>
                                    </label><br>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="reply_multiple"
                                               value="1" <?php if ($xdata[0]["reply_multiple"] == '1') echo 'checked'; ?>
                                               id="reply_multiple" class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="reply_multiple"></label>
                                        <span><?php echo $this->lang->line('Yes'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Reply Content") ?> *
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Reply Content") ?>"
                                           data-content="<?php echo $this->lang->line("Bulk comment reply content."); ?> Spintax example : {Hello|Hi|Hola} to you, {Mr.|Mrs.|Ms.} {{John|Tara|Sara}|Tom|Dave}"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>

                                    <span class='float-right'>
											<a data-toggle="tooltip" data-placement="top"
                                               title='<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>'
                                               class='btn-outline btn-sm' id='lead_tag_name'><i
                                                        class='bx bx-tag'></i> <?php echo $this->lang->line("Tag user") ?></a>
										</span>
                                    <span class='float-right'>
											<a data-toggle="tooltip" data-placement="top"
                                               title='<?php echo $this->lang->line("You can include #LEAD_USER_LAST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>'
                                               class='btn-outline btn-sm' id='lead_last_name'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("last name") ?></a>
										</span>
                                    <span class='float-right'>
											<a data-toggle="tooltip" data-placement="top"
                                               title='<?php echo $this->lang->line("You can include #LEAD_USER_FIRST_NAME# variable inside your message. The variable will be replaced by real names when we will send it.") ?>'
                                               class='btn-outline btn-sm' id='lead_first_name'><i
                                                        class='bx bx-user'></i> <?php echo $this->lang->line("first name") ?></a>
										</span>
                                    <textarea class="form-control" name="message2" id="message2"
                                              placeholder="<?php echo $this->lang->line("Bulk comment reply content."); ?> Spintax example : {Hello|Hi|Hola} to you, {Mr.|Mrs.|Ms.} {{John|Tara|Sara}|Tom|Dave}"
                                              style="height:130px !important;"><?php echo $xdata[0]["reply_content"]; ?></textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("delay between two replies [seconds]") ?> *
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("delay between two replies [seconds]") ?>"
                                           data-content="<?php echo $this->lang->line("Too frequent replies can be suspicious to Facebook. It is safe to use some seconds of delay. Zero means random delay."); ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <input value="<?php echo $xdata[0]["delay_time"]; ?>" class="form-control"
                                           name="delay_time" id="delay_time" type="number" min="0" value="0">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("image/video upload") ?>
                                                <a href="#" data-placement="bottom" data-toggle="popover"
                                                   data-trigger="focus"
                                                   title="<?php echo $this->lang->line("image/video upload") ?>"
                                                   data-content="<?php echo $this->lang->line("upload image or video to embed with your comment reply.") ?>"><i
                                                            class='bx bx-info-circle'></i></a>
                                            </label>
                                            <div class="form-group">
                                                <div id="image_video_upload2"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <input type="hidden"
                                                   value="<?php echo $xdata[0]["uploaded_image_video"]; ?>"
                                                   name="uploaded_image_video2" id="uploaded_image_video2">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <?php if ($xdata[0]["uploaded_image_video"] != "")
                                        {
                                        $ext_exp = explode('.', $xdata[0]["uploaded_image_video"]);
                                        $ext = array_pop($ext_exp);
                                        $video_array = array("flv", "mp4", "wmv");
                                        ?>
                                        <div class="form-group text-center">
                                            <label></label><br>
                                            <?php
                                            if (!in_array($ext, $video_array)) {
                                                echo '<a href="#" title="' . $this->lang->line('See image') . '" id="img_preview" img-src="' . base_url("upload/comment_reply_enhancers/") . $xdata[0]["uploaded_image_video"] . '" class="btn btn-primary" ><i class="bx bx-image"></i></a>';
                                            } else {
                                                echo '<a href="#" title="' . $this->lang->line('See Video') . '" id="vid_preview" vid-src="' . base_url("upload/comment_reply_enhancers/") . $xdata[0]["uploaded_image_video"] . '" class="btn btn-primary" ><i class="bx bx-video"></i></a>';
                                            }
                                            echo '</div>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="schedule_type2" value="later" id="schedule_type2">

                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item2">
                                        <label><?php echo $this->lang->line("schedule time") ?> <a href="#"
                                                                                                   data-placement="top"
                                                                                                   data-toggle="popover"
                                                                                                   data-trigger="focus"
                                                                                                   title="<?php echo $this->lang->line("schedule time") ?>"
                                                                                                   data-content="<?php echo $this->lang->line("Select date and time when you want to process this campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a></label>
                                        <input value="<?php echo $xdata[0]["schedule_time"]; ?>"
                                               placeholder="<?php echo $this->lang->line("time"); ?>"
                                               name="schedule_time2" id="schedule_time2"
                                               class="form-control datetimepicker" type="text"/>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item2">
                                        <label><?php echo $this->lang->line("time zone") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("time zone") ?>"
                                               data-content="<?php echo $this->lang->line("server will consider your time zone when it process the campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <?php
                                        $time_zone[''] = $this->lang->line("please select");
                                        echo form_dropdown('time_zone2', $time_zone, $xdata[0]["time_zone"], ' class="select2 form-control" id="time_zone2" required style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                    </form>

                    <div class="clearfix"></div>
                    <div class="card-footer p-0" style="margin-top:20px;">
                        <button class="btn btn-primary" id="submit_post2" name="submit_post2" type="button"><i
                                    class="bx bx-edit"></i> <?php echo $this->lang->line("Update Campaign") ?> </button>
                        <a class="btn btn-light float-right"
                           onclick='goBack("comment_reply_enhancers/bulk_comment_reply_campaign_list",0)'><i
                                    class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css" media="screen">
    .popover {
        min-width: 300px !important;
    }

    .tokenize-sample, .Tokenize {
        border: none !important;
        padding: 0 !important;
    }

    .box-header {
        border-bottom: 1px solid #ccc !important;
        margin-bottom: 15px;
    }

    .box-primary {
        border: 1px solid #ccc !important;
    }

    .box-body {
        padding: 10px 20px !important;
    }

    .preview {
        padding: 10px 0 !important;
    }

    .box-footer {
        border-top: 1px solid #ccc !important;
        padding: 10px 0;
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

    .box-body {
        font-family: helvetica, ​arial, ​sans-serif;
        padding: 20px;
        background: #fcfcfc;
    }

    #test_msg_box_body {
        background: #fff !important;
    }

    .box-footer {
        background: #fcfcfc;
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

    .TokensContainer {
        height: 140px !important;
    }

    .ajax-upload-dragdrop {
        width: 100% !important;
    }

    .content-wrapper {
        background: #eee !important;
    }
</style>

<div class="modal fade" id="preview_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>