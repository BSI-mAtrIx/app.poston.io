<?php
$image_upload_limit = 1;
if ($this->config->item('autoreply_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('autoreply_image_upload_limit');

$video_upload_limit = 3;
if ($this->config->item('autoreply_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('autoreply_video_upload_limit');
?>

<style>

    #page_id {
        width: 150px;
    }

    #post_id {
        max-width: 40%;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 90px;
        }

        #post_id {
            max-width: 50%;
        }
    }

    .pointer {
        cursor: pointer;
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
                                href="<?php echo base_url("comment_automation/comment_growth_tools"); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('admin/theme/message');
?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="input-group mb-3 float-left" id="searchbox">

                                <!-- search by page name -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="page_id" name="page_id">
                                        <option value=""><?php echo $this->lang->line("Page Name"); ?></option>
                                        <?php foreach ($page_info as $key => $value):
                                            if ($value['id'] == $auto_search_page_info_table_id) : ?>
                                                <option selected
                                                        value="<?php echo $value['id']; ?>"><?php echo $value['page_name']; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>><?php echo $value['page_name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <input type="text" class="form-control" id="post_id" name="post_id"
                                       value="<?php if ($post_id != 0) echo $post_id; ?>"
                                       placeholder="<?php echo $this->lang->line('Post ID'); ?>" aria-label=""
                                       aria-describedby="basic-addon2">

                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search_submit"
                                            title="<?php echo $this->lang->line('Search'); ?>" type="button"><i
                                                class="bx bx-search"></i> <span
                                                class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <a href="javascript:;" id="post_date_range"
                               class="btn btn-primary float-right has-icon-left btn-icon"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="post_date_range_val">
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Page ID"); ?></th>
                                <th><?php echo $this->lang->line("Avatar"); ?></th>
                                <th><?php echo $this->lang->line("page name"); ?></th>
                                <th><?php echo $this->lang->line("post ID"); ?></th>
                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(201, $this->module_access)) { ?>
                                    <th><?php echo $this->lang->line("Comment & Bulk Tag"); ?></th>
                                <?php } ?>
                                <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(202, $this->module_access)) { ?>
                                    <th><?php echo $this->lang->line("Bulk Comment Reply"); ?></th>
                                <?php } ?>
                                <th><?php echo $this->lang->line("Re-scan"); ?></th>
                                <th><?php echo $this->lang->line("Comments"); ?></th>
                                <th><?php echo $this->lang->line("Commenters"); ?></th>
                                <th><?php echo $this->lang->line("Last Scanned"); ?></th>
                                <th><?php echo $this->lang->line("Post Created"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$item_per_range = $this->config->item('item_per_range');
if ($item_per_range == '') $item_per_range = 50;

$somethingwentwrong = $this->lang->line("something went wrong.");
$pleasewait = $this->lang->line("please wait") . '...';
$startcommenternames = $this->lang->line("Start typing commenter names you want to excude from tag list");
$list_of_commenters = $this->lang->line("List of commenters which this campaign will tag");
$campaign_name_is_required = $this->lang->line("Campaign name is required.");
$tag_content_is_required = $this->lang->line("Tag content is required.");
$you_have_not_selected_commenters = $this->lang->line("You have not selected commenters.");
$no_subscribed_commenter_found = $this->lang->line("No subscribed commenter found.");
$reply_content_is_required = $this->lang->line("Reply content is required.");
$pleaseselectscheduletimetimezone = $this->lang->line("Please select schedule time/time zone.");
$areyousureyouwanttorescan = $this->lang->line("Are you Sure you want to Re-scan?");
?>

<div class="modal fade" id="comment_bulk_tag_campaign" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-center"><i
                            class="bx bx-purchase-tag-alt"></i> <?php echo $this->lang->line("Comment & Bulk Tag Campaign"); ?>
                </h6>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form action="#" enctype="multipart/form-data" id="bulk_tag_campaign_form" method="post">
                            <input type="hidden" name="tag_campaign_tag_machine_enabled_post_list_id"
                                   id="tag_campaign_tag_machine_enabled_post_list_id">
                            <input type="hidden" name="tag_campaign_tag_machine_commenter_count"
                                   id="tag_campaign_tag_machine_commenter_count">

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("campaign name") ?> *
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("campaign name"); ?>"
                                               data-content="<?php echo $this->lang->line("put a name so that you can identify it later"); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <input type="text" class="form-control" name="campaign_name" id="campaign_name">
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
                                                size="5" style="width:100%;"></select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Tag Content") ?> *
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus"
                                               title="<?php echo $this->lang->line("Tag Content") ?>"
                                               data-content="<?php echo $this->lang->line("Content to bulk tag commenters."); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <textarea class="form-control" name="message" id="message"
                                                  placeholder="<?php echo $this->lang->line("Content to bulk tag commenters."); ?>"
                                                  style="height:130px !important;"></textarea>
                                    </div>
                                </div>

                                <div class="col-12" style="padding-bottom: 100px;">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Do not tag these commenters") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("Do not tag these commenters") ?>"
                                               data-content="<?php echo $this->lang->line("You can choose one or more. The commenters you choose here will be unlisted from this campaign and will not be tagged. Start typing a commenter name, it is auto-complete.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <fieldset class="form-group">
                                            <select style="width:100%" name="exclude[]" id="exclude" multiple="multiple"
                                                    class="form-control tokenize-sample form-control exclude_autocomplete"></select>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $this->lang->line("image/video upload") ?>
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus"
                                               title="<?php echo $this->lang->line("image/video upload") ?>"
                                               data-content="<?php echo $this->lang->line("upload image or video to embed with your bulk tag comment.") ?>"><i
                                                        class='bx bx-info-circle'></i></a>
                                        </label>
                                        <div class="form-group">
                                            <div id="image_video_upload"><?php echo $this->lang->line("upload") ?></div>
                                        </div>
                                        <input type="hidden" name="uploaded_image_video" id="uploaded_image_video">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Schedule") ?></label><br>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="schedule_type" value="now" id="schedule_type"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label mr-1" for="schedule_type"></label>
                                            <span><?php echo $this->lang->line('Now'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row schedule_block_item">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Schedule time") ?> <a href="#"
                                                                                                   data-placement="top"
                                                                                                   data-toggle="popover"
                                                                                                   data-trigger="focus"
                                                                                                   title="<?php echo $this->lang->line("schedule time") ?>"
                                                                                                   data-content="<?php echo $this->lang->line("Select date and time when you want to process this campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a></label>
                                        <input placeholder="<?php echo $this->lang->line("time"); ?>"
                                               name="schedule_time" id="schedule_time"
                                               class="form-control datetimepicker2" type="text"/>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("time zone") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("time zone") ?>"
                                               data-content="<?php echo $this->lang->line("server will consider your time zone when it process the campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <?php
                                        $time_zone[''] = $this->lang->line("please select");
                                        echo form_dropdown('time_zone', $time_zone, $this->config->item('time_zone'), ' class="select2 form-control" id="time_zone" required style="width:100%;"');
                                        ?>
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
                        </form>
                    </div>

                </div>
                <div class="col-12 p-0" style="margin-top:20px;">
                    <button class="btn btn-primary" id="submit_post" name="submit_post" type="button"><i
                                class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaign") ?>
                    </button>
                    <a class="btn btn-light float-right" data-dismiss="modal" aria-hidden="true"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="bulk_comment_reply_campaign" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-center"><i
                            class="bx bx-comment-dots"></i> <?php echo $this->lang->line("Bulk Comment Reply Campaign"); ?>
                </h6>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form action="#" enctype="multipart/form-data" id="bulk_comment_reply_campaign_form"
                              method="post">
                            <input type="hidden" name="bulk_comment_reply_campaign_enabled_post_list_id"
                                   id="bulk_comment_reply_campaign_enabled_post_list_id">
                            <input type="hidden" name="bulk_comment_reply_campaign_commenter_count"
                                   id="bulk_comment_reply_campaign_commenter_count">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("campaign name") ?> *
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("campaign name"); ?>"
                                               data-content="<?php echo $this->lang->line("put a name so that you can identify it later"); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <input type="text" class="form-control" name="campaign_name2"
                                               id="campaign_name2">
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
                                                  style="height:130px !important;"></textarea>
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
                                            <input type="checkbox" name="reply_multiple" value="1" id="reply_multiple"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label mr-1" for="reply_multiple"></label>
                                            <span><?php echo $this->lang->line('Yes'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo $this->lang->line("image/video upload") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("image/video upload") ?>"
                                               data-content="<?php echo $this->lang->line("upload image or video to embed with your comment reply.") ?> "><i
                                                        class='bx bx-info-circle'></i></a>
                                        </label>
                                        <div class="form-group">
                                            <div id="image_video_upload2"><?php echo $this->lang->line("upload") ?></div>
                                        </div>
                                        <input type="hidden" name="uploaded_image_video2" id="uploaded_image_video2">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("delay between two replies [seconds]") ?> *
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("delay between two replies [seconds]") ?>"
                                               data-content="<?php echo $this->lang->line("Too frequent replies can be suspicious to Facebook. It is safe to use some seconds of delay. Zero means random delay."); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <input class="form-control" name="delay_time" id="delay_time" type="number"
                                               min="0" value="0">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Schedule") ?></label><br>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="schedule_type2" value="now" id="schedule_type2"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label mr-1" for="schedule_type2"></label>
                                            <span><?php echo $this->lang->line('Now'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item2">
                                        <label><?php echo $this->lang->line("schedule time") ?> <a href="#"
                                                                                                   data-placement="top"
                                                                                                   data-toggle="popover"
                                                                                                   data-trigger="focus"
                                                                                                   title="<?php echo $this->lang->line("schedule time") ?>"
                                                                                                   data-content="<?php echo $this->lang->line("Select date and time when you want to process this campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a></label>
                                        <input placeholder="<?php echo $this->lang->line("time"); ?>"
                                               name="schedule_time2" id="schedule_time2"
                                               class="form-control datetimepicker3" type="text"/>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group schedule_block_item2" style="padding-right:0;">
                                        <label><?php echo $this->lang->line("time zone") ?>
                                            <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                               title="<?php echo $this->lang->line("time zone") ?>"
                                               data-content="<?php echo $this->lang->line("server will consider your time zone when it process the campaign.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <?php
                                        $time_zone[''] = $this->lang->line("please select");
                                        echo form_dropdown('time_zone2', $time_zone, $this->config->item('time_zone'), ' class="select2 form-control" id="time_zone2" required style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 p-0" style="margin-top:20px;">
                    <button class="btn btn-primary" id="submit_post2" name="submit_post2" type="button"><i
                                class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaign") ?>
                    </button>
                    <a class="btn btn-light float-right" data-dismiss="modal" aria-hidden="true"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="comment_list_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-comment"></i> <?php echo $this->lang->line("Comment List"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="comment_list_body">
                <div class="row">
                    <div class="col-12 text-center page_post_link"></div>
                </div>
                <br/>
                <div class="row">
                    <!-- <div class="col-12 margin-top">
					  <input type="text" id="commenter_searching" name="commenter_searching" class="form-control" placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>                                          
					</div> -->
                    <div class="col-12">
                        <div class="data-card">
                            <input type="hidden" name="put_comment_table_id" id="put_comment_table_id">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable2">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("Commenter Name"); ?></th>
                                        <th><?php echo $this->lang->line("Comment ID"); ?></th>
                                        <th><?php echo $this->lang->line("Comment Time"); ?></th>
                                        <th><?php echo $this->lang->line("Comment"); ?></th>
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


<div class="modal fade" id="commenter_list_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-user"></i> <?php echo $this->lang->line("Commenter List"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="commenter_list_body">
                <div class="row">
                    <div class="col-12 text-center page_post_link"></div>
                </div>
                <br/>
                <div class="row">
                    <!-- <div class="col-12 margin-top">
					  <input type="text" id="commenter_searching" name="commenter_searching" class="form-control" placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>                                          
					</div> -->
                    <div class="col-12">
                        <div class="data-card">
                            <input type="hidden" name="put_table_id" id="put_table_id">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable1">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("Commenter Name"); ?></th>
                                        <th><?php echo $this->lang->line("Last Comment ID"); ?></th>
                                        <th><?php echo $this->lang->line("Last Comment Time"); ?></th>
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
        padding: 10px 10px !important;
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

    .padding-top-10 {
        padding: 10px;
    }

    .box-header {
        color: #3C8DBC;
    }

    .box-body {
        font-family: helvetica, arial, sans-serif;
        padding: 20px;

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
</style>



