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
                                href="<?php echo base_url("comment_automation/comment_growth_tools"); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/comment_section_report"); ?>"><?php echo $this->lang->line("Report"); ?></a>
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
                    <form action="#" enctype="multipart/form-data" id="bulk_tag_campaign_form" method="post">
                        <input type="hidden" name="campaign_id" value="<?php echo $xdata[0]["id"]; ?>">
                        <input type="hidden" name="tag_campaign_tag_machine_enabled_post_list_id"
                               value="<?php echo $xdata[0]["tag_machine_enabled_post_list_id"]; ?>">
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
                                           class="form-control" name="campaign_name" id="campaign_name">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Select Commenter Range") ?> *
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Select Commenter Range"); ?>"
                                           data-content="<?php echo $this->lang->line("This range is sorted by comment time in decending order.") ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <select name="commenter_range" id="commenter_range" class="select2 form-control"
                                            style="width:100%;">
                                        <?php echo $commenter_range; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Tag Content") ?> *
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Tag Content") ?>"
                                           data-content="<?php echo $this->lang->line("Content to bulk tag commenters."); ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <textarea class="form-control" name="message" id="message"
                                              placeholder="<?php echo $this->lang->line("Content to bulk tag commenters."); ?>"
                                              style="height:100px !important;"><?php echo $xdata[0]["tag_content"]; ?></textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Do not tag these commenters") ?>
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Do not tag these commenters") ?>"
                                           data-content="<?php echo $this->lang->line("You can choose one or more. The commenters you choose here will be unlisted from this campaign and will not be tagged. Start typing a commenter name, it is auto-complete.") ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <select style="width:100%;" name="exclude[]" id="exclude" multiple
                                            class="tokenize-sample form-control exclude_autocomplete select2">
                                        <?php
                                        foreach ($xtag_exclude as $key => $value) {
                                            echo "<option selected value='" . $value["commenter_fb_id"] . "'>" . $value["commenter_name"] . "</option>";
                                        }
                                        ?>
                                    </select>
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
                                                   data-content="<?php echo $this->lang->line("upload image or video to embed with your bulk tag comment.") ?>"><i
                                                            class='bx bx-info-circle'></i></a>
                                            </label>

                                            <div class="form-group">
                                                <div id="image_video_upload"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <input type="hidden"
                                                   value="<?php echo $xdata[0]["uploaded_image_video"]; ?>"
                                                   name="uploaded_image_video" id="uploaded_image_video">
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

                                <!-- <div class="form-group" id="custom_input_div">
								    <label>
								   		<?php echo $this->lang->line("Tag List") . " [" . $this->lang->line("Up to") . ": " . $item_per_range . "]"; ?> *
								    	<a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Tag These Commenters") ?>" data-content="<?php echo $this->lang->line("Select the commenters you want to tag.") ?>"><i class='bx bx-info-circle'></i> </a>
								    </label>
								    <select style="width:100px;"  name="include[]" id="include" multiple="multiple" class="tokenize-sample form-control include_autocomplete">                                     
								    </select>
								</div>	 -->

                                <input type="hidden" name="schedule_type" value="later" id="schedule_type">

                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item">
                                        <label><?php echo $this->lang->line("Schedule time") ?> <a href="#"
                                                                                                   data-placement="top"
                                                                                                   data-toggle="popover"
                                                                                                   data-trigger="focus"
                                                                                                   title="<?php echo $this->lang->line("schedule time") ?>"
                                                                                                   data-content="<?php echo $this->lang->line("Select date and time when you want to process this campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a></label>
                                        <input value="<?php echo $xdata[0]["schedule_time"]; ?>"
                                               placeholder="<?php echo $this->lang->line("time"); ?>"
                                               name="schedule_time" id="schedule_time"
                                               class="form-control datetimepicker" type="text"/>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item">
                                        <label><?php echo $this->lang->line("Time zone") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("time zone") ?>"
                                               data-content="<?php echo $this->lang->line("server will consider your time zone when it process the campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <?php
                                        $time_zone[''] = $this->lang->line("please select");
                                        echo form_dropdown('time_zone', $time_zone, $xdata[0]["time_zone"], 'class="select2 form-control" id="time_zone" required style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                    </form>

                    <div class="clearfix"></div>
                    <div class="card-footer p-0" style="margin-top:20px;">
                        <button class="btn btn-primary" id="submit_post" name="submit_post" type="button"><i
                                    class="bx bx-edit"></i> <?php echo $this->lang->line("Update Campaign") ?> </button>
                        <a class="btn btn-light float-right"
                           onclick='goBack("comment_reply_enhancers/bulk_tag_campaign_list",0)'><i
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

    .preview {
        padding: 10px 0 !important;
    }


    .hidden {
        display: none;
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