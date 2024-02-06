<?php
//todo: fix radio buttons
//todo: fix modals
?>

<?php
$include_emoji = 1;
//  $this->load->view("include/upload_js");
if (ultraresponse_addon_module_exist()) $commnet_hide_delete_addon = 1;
else $commnet_hide_delete_addon = 0;

if (addon_exist(201, "comment_reply_enhancers")) $comment_tag_machine_addon = 1;
else $comment_tag_machine_addon = 0;
?>

<?php

$Youdidntprovideallinformation = $this->lang->line("you didn't provide all information.");
$Pleaseprovidepostid = $this->lang->line("please provide post id.");
$Youdidntselectanyoption = $this->lang->line("you didn\'t select any option.");

$AlreadyEnabled = $this->lang->line("already enabled");
$ThispostIDisnotfoundindatabaseorthispostIDisnotassociatedwiththepageyouareworking = $this->lang->line("This post ID is not found in database or this post ID is not associated with the page you are working.");
$EnableAutoReply = $this->lang->line("enable auto reply");

$btn_spintax_html = '';
if(file_exists(APPPATH.'n_sgp/injectors/spintax.php')){
    include(APPPATH.'n_sgp/injectors/spintax.php');
}

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
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary mb-1 enable_page_response">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create new template"); ?>
        </a>
        <?php if ($selected_global_media_type == 'fb') { ?>
            <a href="#" class="btn btn-primary social_switch mb-1"
               data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>
        <?php } else { ?>
            <a href="#" class="btn btn-primary social_switch mb-1"
               data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>
        <?php } ?>
    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Template ID"); ?></th>
                                <th><?php echo $this->lang->line("Template Name"); ?></th>
                                <th><?php echo $this->lang->line("Page Name"); ?></th>
                                <th style="min-width: 150px"><?php echo $this->lang->line("Actions"); ?></th>
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


<div class="modal fade" id="auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="min-width: 70%;">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title"
                    style="padding: 10px 20px 10px 20px;"><?php echo $this->lang->line("Please give the following information for post auto reply") ?></h3>
                <button type="button" class="close" id='modal_close' aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <form action="#" id="auto_reply_info_form" method="post">
                <input type="hidden" name="auto_reply_page_id" id="auto_reply_page_id" value="">
                <input type="hidden" name="auto_reply_post_id" id="auto_reply_post_id" value="">
                <input type="hidden" name="manual_enable" id="manual_enable" value="">

                <div class="modal-body" id="auto_reply_message_modal_body">

                    <div id="new_template_section">

                        <div class="row" style="padding: 10px 20px 10px 20px;">
                            <div class="col-12 col-md-4">
                                <label><i class="bx bxs-file"></i> <?php echo $this->lang->line("Please select a page for auto-reply") ?>
                                </label>
                            </div>
                            <div class="col-12 col-md-8">
                                <select class="select2 form-control" id="page_ids" name="page_ids[]">
                                    <option><?php echo $this->lang->line('Select a page'); ?></option>
                                    <?php
                                    foreach ($page_list as $key => $value) {
                                        echo '<optgroup label="' . addslashes($value['fb_user_name']) . '">';
                                        foreach ($value['data'] as $key2 => $value2) {
                                            echo "<option value='" . $value2['table_id'] . "'>" . $value2['page_name'] . "</option>";
                                        }
                                        echo '</optgroup>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <!-- comment hide and delete section -->
                        <div class="row"
                             style="padding: 10px 20px 10px 20px; <?php if (!$commnet_hide_delete_addon) echo "display: none;"; ?> ">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label><i class="bx bx-block"></i> <?php echo $this->lang->line("what do you want about offensive comments?") ?>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="radio" name="delete_offensive_comment" value="hide"
                                                       id="delete_offensive_comment_hide" class="custom-control-input"
                                                       checked>
                                                <label class="custom-control-label mr-1"
                                                       for="delete_offensive_comment_hide"></label>
                                                <span><?php echo $this->lang->line('hide'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="radio" name="delete_offensive_comment" value="delete"
                                                       id="delete_offensive_comment_delete"
                                                       class="custom-control-input">
                                                <label class="custom-control-label mr-1"
                                                       for="delete_offensive_comment_delete"></label>
                                                <span><?php echo $this->lang->line('delete'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/><br/>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-6" id="delete_offensive_comment_keyword_div">
                                        <div class="form-group" style="border: 1px dashed #ccc; padding: 10px;">
                                            <label><i class="bx bx-tag"></i>
                                                <small><?php echo $this->lang->line("write down the offensive keywords in comma separated") ?></small>
                                            </label>
                                            <textarea class="form-control message"
                                                      name="delete_offensive_comment_keyword"
                                                      id="delete_offensive_comment_keyword"
                                                      placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"
                                                      style="height:59px !important;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group clearfix"
                                             style="border: 1px dashed #ccc; padding: 10px;">
                                            <label><small>
                                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?>
                                                </small>
                                            </label>
                                            <div>
                                                <select class="form-group private_reply_postback"
                                                        id="private_message_offensive_words"
                                                        name="private_message_offensive_words">
                                                    <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                                </select>

                                                <a href="" class="add_template float-left"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                                </a>
                                                <a href="" class="ref_template float-right"><i
                                                            class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of comment hide and delete section -->

                        <div class="row" style="padding: 10px 20px 10px 20px;">
                            <!-- added by mostofa on 26-04-2017 -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-6"><label><i
                                                    class="bx bx-sort-down"></i> <?php echo $this->lang->line("do you want to send reply message to a user multiple times?") ?>
                                        </label></div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" name="multiple_reply" value="yes"
                                                       id="multiple_reply" class="custom-control-input">
                                                <label class="custom-control-label mr-1" for="multiple_reply"></label>
                                                <span><?php echo $this->lang->line('Yes'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="smallspace clearfix"></div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label><i class="bx bx-comment-dots"></i> <?php echo $this->lang->line("do you want to enable comment reply?") ?>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" name="comment_reply_enabled" value="yes"
                                                       id="comment_reply_enabled" class="custom-control-input" checked>
                                                <label class="custom-control-label mr-1"
                                                       for="comment_reply_enabled"></label>
                                                <span><?php echo $this->lang->line('Yes'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="smallspace clearfix"></div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label><i class="bx bx-comment"></i> <?php echo $this->lang->line("do you want to like on comment by page?") ?>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" name="auto_like_comment" value="yes"
                                                       id="auto_like_comment" class="custom-control-input">
                                                <label class="custom-control-label mr-1"
                                                       for="auto_like_comment"></label>
                                                <span><?php echo $this->lang->line('Yes'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="smallspace clearfix"></div>
                            <!-- comment hide and delete section -->
                            <div class="col-12" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label><i class="bx bx-show-slash"></i> <?php echo $this->lang->line("do you want to hide comments after comment reply?") ?>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" name="hide_comment_after_comment_reply"
                                                       value="yes" id="hide_comment_after_comment_reply"
                                                       class="custom-control-input">
                                                <label class="custom-control-label mr-1"
                                                       for="hide_comment_after_comment_reply"></label>
                                                <span><?php echo $this->lang->line('Yes'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- comment hide and delete section -->

                            <div class="smallspace clearfix"></div>


                            <div class="col-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="message_type" value="generic" id="generic"
                                           class="custom-control-input radio_button">
                                    <label class="custom-control-label"
                                           for="generic"><?php echo $this->lang->line("generic message for all") ?></label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="message_type" value="filter" id="filter"
                                           class="custom-control-input radio_button">
                                    <label class="custom-control-label"
                                           for="filter"><?php echo $this->lang->line("send message by filtering word/sentence") ?></label>
                                </div>
                            </div>
                            <div class="col-12" style="margin-top: 15px;">
                                <div class="form-group">
                                    <label>
                                        <i class="bx bx-rocket"></i> <?php echo $this->lang->line("auto reply campaign name") ?>
                                        <span class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("write your auto reply campaign name here") ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <input class="form-control" type="text" name="auto_campaign_name"
                                           id="auto_campaign_name"
                                           placeholder="<?php echo $this->lang->line("write your auto reply campaign name here") ?>">
                                </div>
                            </div>


                            <div class="col-12" id="generic_message_div" style="display: none;">
                                <div class="form-group clearfix" style="border: 1px dashed #ccc; padding: 10px;">
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Message for comment reply") ?>
                                        <span class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("write your message which you want to send. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <?php if ($comment_tag_machine_addon) { ?>
                                        <span class='float-right'>
                    <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                       data-toggle="tooltip" data-placement="top" class='btn-sm lead_tag_name button-outline'><i
                                class='bx bx-tag'></i>  <?php echo $this->lang->line("tag user") ?></a>
                  </span>
                                    <?php } ?>
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

                                    <?php echo $btn_spintax_html; ?>

                                    <div class="clearfix"></div>
                                    <textarea class="form-control message" name="generic_message" id="generic_message"
                                              placeholder="<?php echo $this->lang->line("type your message here...") ?>"
                                              style="height:170px !important;"></textarea>

                                    <!-- comment hide and delete section -->
                                    <br/>
                                    <div class="row clearfix" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                                        <div class="col-12 col-md-6">
                                            <label class="control-label"><i
                                                        class="bx bx-image"></i> <?php echo $this->lang->line("image for comment reply") ?>
                                            </label>
                                            <div class="form-group">
                                                <div id="generic_comment_image"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <div id="generic_image_preview_id"></div>
                                            <span class="text-danger" id="generic_image_for_comment_reply_error"></span>
                                            <input type="text" name="generic_image_for_comment_reply"
                                                   class="form-control" id="generic_image_for_comment_reply"
                                                   placeholder="<?php echo $this->lang->line("put your image url here or click the above upload button") ?>"
                                                   style="margin-top: -14px;"/>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="control-label"><i
                                                        class="bx bxl-youtube"></i> <?php echo $this->lang->line("video for comment reply") ?>
                                                [mp4 <?php echo $this->lang->line("Prefered"); ?>]
                                                <a href="#" data-placement="bottom" data-toggle="popover"
                                                   data-trigger="focus"
                                                   title="<?php echo $this->lang->line("video upload") ?>"
                                                   data-content="<?php echo $this->lang->line("image and video will not work together. Please choose either image or video.") ?> [mp4,wmv,flv]"><i
                                                            class='bx bx-info-circle'></i></a>
                                            </label>
                                            <div class="form-group">
                                                <div id="generic_video_upload"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <div id="generic_video_preview_id"></div>
                                            <span class="text-danger" id="generic_video_comment_reply_error"></span>
                                            <input type="hidden" name="generic_video_comment_reply" class="form-control"
                                                   id="generic_video_comment_reply"
                                                   placeholder="<?php echo $this->lang->line("Put your image url here or click upload") ?>"/>
                                        </div>
                                    </div>
                                    <br/><br/>
                                    <!-- comment hide and delete section -->


                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                        [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>]
                                    </label>
                                    <div>
                                        <select class="form-group private_reply_postback" id="generic_message_private"
                                                name="generic_message_private">
                                            <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i
                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                        </a>
                                        <a href="" class="ref_template float-right"><i
                                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                        </a>
                                    </div>

                                </div>
                            </div>


                            <div class="col-12" id="filter_message_div" style="display: none;">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label class="custom-switch">
                                            <input type="radio" name="trigger_matching_type" value="exact"
                                                   id="trigger_keyword_exact" class="custom-switch-input" checked>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Reply if the filter word exactly matches.'); ?></span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="custom-switch">
                                            <input type="radio" name="trigger_matching_type" value="string"
                                                   id="trigger_keyword_string" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Reply if any matches occurs with filter word.'); ?>
                                        </label>
                                    </div>
                                </div>
                                <br/>
                                <?php for ($i = 1; $i <= 20; $i++) : ?>
                                    <div class="form-group clearfix" id="filter_div_<?php echo $i; ?>"
                                         style="border: 1px dashed #ccc; padding: 10px; margin-bottom: 50px;">
                                        <label>
                                            <i class="bx bx-tag"></i> <?php echo $this->lang->line("filter word/sentence") ?>
                                            <span class="text-danger">*</span>
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus" title="<?php echo $this->lang->line("message") ?>"
                                               data-content="<?php echo $this->lang->line("Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <input class="form-control filter_word" type="text"
                                               name="filter_word_<?php echo $i; ?>" id="filter_word_<?php echo $i; ?>"
                                               placeholder="<?php echo $this->lang->line("write your filter word here") ?>">


                                        <!-- new feature comment reply section -->
                                        <br/>
                                        <label>
                                            <i class="bx bx-envelope"></i> <?php echo $this->lang->line("msg for comment reply") ?>
                                            <span class="text-danger">*</span>
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus" title="<?php echo $this->lang->line("message") ?>"
                                               data-content="<?php echo $this->lang->line("write your message which you want to send based on filter words. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <?php if ($comment_tag_machine_addon) { ?>
                                            <span class='float-right'>
                        <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                           data-toggle="tooltip" data-placement="top" class='btn-sm lead_tag_name button-outline'><i
                                    class='bx bx-tag'></i>  <?php echo $this->lang->line("tag user") ?></a>
                      </span>
                                        <?php } ?>
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
                                        <?php echo $btn_spintax_html; ?>

                                        <div class="clearfix"></div>
                                        <textarea class="form-control message"
                                                  name="comment_reply_msg_<?php echo $i; ?>"
                                                  id="comment_reply_msg_<?php echo $i; ?>"
                                                  placeholder="<?php echo $this->lang->line("type your message here...") ?>"
                                                  style="height:170px !important;"></textarea>

                                        <!-- comment hide and delete section -->
                                        <br/>
                                        <div class="clearfix" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label class="control-label"><i
                                                                class="bx bx-image"></i> <?php echo $this->lang->line("image for comment reply") ?>
                                                    </label>
                                                    <div class="form-group">
                                                        <div id="filter_image_upload_<?php echo $i; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                    </div>
                                                    <div id="generic_image_preview_id_<?php echo $i; ?>"></div>
                                                    <span class="text-danger"
                                                          id="generic_image_for_comment_reply_error_<?php echo $i; ?>"></span>
                                                    <input type="text"
                                                           name="filter_image_upload_reply_<?php echo $i; ?>"
                                                           class="form-control"
                                                           id="filter_image_upload_reply_<?php echo $i; ?>"
                                                           placeholder="<?php echo $this->lang->line("Put your image url here or click the above upload button") ?>"
                                                           style="margin-top: -14px;"/>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <label class="control-label"><i
                                                                class="bx bxl-youtube"></i> <?php echo $this->lang->line("video for comment reply") ?>
                                                        [mp4 <?php echo $this->lang->line("Prefered"); ?>]
                                                        <a href="#" data-placement="bottom" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("video upload") ?>"
                                                           data-content="<?php echo $this->lang->line("image and video will not work together. Please choose either image or video.") ?> [mp4,wmv,flv]"><i
                                                                    class='bx bx-info-circle'></i></a>
                                                    </label>
                                                    <div class="form-group">
                                                        <div id="filter_video_upload_<?php echo $i; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                    </div>
                                                    <div id="generic_video_preview_id_<?php echo $i; ?>"></div>
                                                    <span class="text-danger"
                                                          id="edit_generic_video_comment_reply_error_<?php echo $i; ?>"></span>
                                                    <input type="hidden"
                                                           name="filter_video_upload_reply_<?php echo $i; ?>"
                                                           class="form-control"
                                                           id="filter_video_upload_reply_<?php echo $i; ?>"
                                                           placeholder="<?php echo $this->lang->line("Put your image url here or click upload") ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- comment hide and delete section -->
                                        <br/>
                                        <label>
                                            <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                            [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>
                                            ]
                                        </label>
                                        <div>
                                            <select class="form-group private_reply_postback"
                                                    id="filter_message_<?php echo $i; ?>"
                                                    name="filter_message_<?php echo $i; ?>">
                                                <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                            </select>

                                            <a href="" class="add_template float-left"><i
                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                            </a>
                                            <a href="" class="ref_template float-right"><i
                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                            </a>
                                        </div>


                                    </div>
                                <?php endfor; ?>

                                <div class="clearfix">
                                    <input type="hidden" name="content_counter" id="content_counter"/>
                                    <button type="button" class="btn btn-sm btn-outline-primary float-right"
                                            id="add_more_button"><i
                                                class="bx bx-plus"></i> <?php echo $this->lang->line("add more filtering") ?>
                                    </button>
                                </div>

                                <div class="form-group clearfix" id="nofilter_word_found_div"
                                     style="margin-top: 10px; border: 1px dashed #ccc; padding: 10px;">
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("comment reply if no matching found") ?>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("Write the message,  if no filter word found. If you don't want to send message them, just keep it blank ."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <?php if ($comment_tag_machine_addon) { ?>
                                        <span class='float-right'>
                    <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                       data-toggle="tooltip" data-placement="top" class='btn-sm lead_tag_name button-outline'><i
                                class='bx bx-tag'></i>  <?php echo $this->lang->line("tag user") ?></a>
                  </span>
                                    <?php } ?>
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
                                    <?php echo $btn_spintax_html; ?>

                                    <div class="clearfix"></div>
                                    <textarea class="form-control message" name="nofilter_word_found_text"
                                              id="nofilter_word_found_text"
                                              placeholder="<?php echo $this->lang->line("type your message here...") ?>"
                                              style="height:170px !important;"></textarea>

                                    <!-- comment hide and delete section -->
                                    <br/>
                                    <div class="clearfix" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label class="control-label"><i
                                                            class="bx bx-image"></i> <?php echo $this->lang->line("image for comment reply") ?>
                                                </label>
                                                <div class="form-group">
                                                    <div id="nofilter_image_upload"><?php echo $this->lang->line("upload") ?></div>
                                                </div>
                                                <div id="nofilter_generic_image_preview_id"></div>
                                                <span class="text-danger" id="nofilter_image_upload_reply_error"></span>
                                                <input type="text" name="nofilter_image_upload_reply"
                                                       class="form-control" id="nofilter_image_upload_reply"
                                                       placeholder="<?php echo $this->lang->line("put your image url here or click the above upload button") ?>"
                                                       style="margin-top: -14px;"/>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="control-label"><i
                                                            class="bx bxl-youtube"></i> <?php echo $this->lang->line("video for comment reply") ?>
                                                    [mp4 <?php echo $this->lang->line("Prefered"); ?>]
                                                    <a href="#" data-placement="bottom" data-toggle="popover"
                                                       data-trigger="focus"
                                                       title="<?php echo $this->lang->line("video upload") ?>"
                                                       data-content="<?php echo $this->lang->line("image and video will not work together. Please choose either image or video.") ?> [mp4,wmv,flv]"><i
                                                                class='bx bx-info-circle'></i></a>
                                                </label>
                                                <div class="form-group">
                                                    <div id="nofilter_video_upload"><?php echo $this->lang->line("upload") ?></div>
                                                </div>
                                                <div id="nofilter_video_preview_id"></div>
                                                <span class="text-danger" id="nofilter_video_upload_reply_error"></span>
                                                <input type="hidden" name="nofilter_video_upload_reply"
                                                       class="form-control" id="nofilter_video_upload_reply"
                                                       placeholder="<?php echo $this->lang->line("put your image url here or click upload") ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <br/><br/>
                                    <!-- comment hide and delete section -->

                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply if no matching found") ?>
                                        [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>]
                                    </label>
                                    <div>
                                        <select class="form-group private_reply_postback"
                                                id="nofilter_word_found_text_private"
                                                name="nofilter_word_found_text_private">
                                            <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i
                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                        </a>
                                        <a href="" class="ref_template float-right"><i
                                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center" id="response_status"></div>
                </div>

                <!-- This hidden field is for detecting the clicked button type -->
                <input type="hidden" name="btn_type" value="" id="submit_btn_values">
            </form>
            <div class="clearfix"></div>

            <div class="modal-footer">


                <button type="button" class="btn btn-secondary mr-1 mb-1 cancel_button"><i class='bx bx-time'></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("cancel") ?></span></button>

                <button type="button" class="btn btn-primary mr-1 mb-1" id="save_button"><i class='bx bx-save'></i>
                    <span class="align-middle ml-25"><?php echo $this->lang->line("save") ?></span></button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="min-width: 70%;">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title"
                    style="padding: 10px 20px 10px 20px;"><?php echo $this->lang->line("Please give the following information for post auto reply") ?></h3>
                <button type="button" class="close" id='edit_modal_close' aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <form action="#" id="edit_auto_reply_info_form" method="post">
                <input type="hidden" name="table_id" id="table_id" value="">
                <input type="hidden" name="edit_auto_reply_post_id" id="edit_auto_reply_post_id" value="">
                <div class="modal-body" id="edit_auto_reply_message_modal_body">

                    <div class="text-center waiting previewLoader"><i class="bx bx-loader-alt bx-spin blue text-center"
                                                                      style="font-size: 40px;"></i></div>

                    <div class="row" style="padding: 10px 20px 10px 20px;">
                        <div class="col-12 col-md-4">
                            <label><i class="bx bxs-file"></i> <?php echo $this->lang->line("Please select a page for auto-reply") ?>
                            </label>
                        </div>
                        <div class="col-12 col-md-8">
                            <select class="select2 form-control" id="edit_page_ids" name="edit_page_ids[]">
                            </select>
                        </div>
                    </div>

                    <!-- comment hide and delete section -->
                    <div class="row"
                         style="padding: 10px 20px 10px 20px;<?php if (!$commnet_hide_delete_addon) echo "display: none;"; ?> ">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-block"></i> <?php echo $this->lang->line("what do you want about offensive comments?") ?>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="edit_delete_offensive_comment" value="hide"
                                                   id="edit_delete_offensive_comment_hide" class="custom-control-input"
                                                   checked>
                                            <label class="custom-control-label mr-1"
                                                   for="edit_delete_offensive_comment_hide"></label>
                                            <span><?php echo $this->lang->line('hide'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="edit_delete_offensive_comment" value="delete"
                                                   id="edit_delete_offensive_comment_delete"
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="edit_delete_offensive_comment_delete"></label>
                                            <span><?php echo $this->lang->line('delete'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <div class="col-12 col-md-6" id="edit_delete_offensive_comment_keyword_div">
                            <div class="form-group" style="border: 1px dashed #ccc; padding: 10px;">
                                <label><i class="bx bx-tag"></i>
                                    <small><?php echo $this->lang->line("write down the offensive keywords in comma separated") ?></small>
                                </label>
                                <textarea class="form-control message" name="edit_delete_offensive_comment_keyword"
                                          id="edit_delete_offensive_comment_keyword"
                                          placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"
                                          style="height:59px !important;"></textarea>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group clearfix" style="border: 1px dashed #ccc; padding: 10px;">
                                <label><small>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?>
                                    </small>
                                </label>
                                <div>
                                    <select class="form-group private_reply_postback"
                                            id="edit_private_message_offensive_words"
                                            name="edit_private_message_offensive_words">
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end of comment hide and delete section -->
                    <div class="row" style="padding: 10px 20px 10px 20px;">
                        <!-- added by mostofa on 26-04-2017 -->
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6"><label><i
                                                class="bx bx-sort-down"></i> <?php echo $this->lang->line("do you want to send reply message to a user multiple times?") ?>
                                    </label></div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="checkbox" name="edit_multiple_reply" value="yes"
                                                   id="edit_multiple_reply" class="custom-control-input">
                                            <label class="custom-control-label mr-1" for="edit_multiple_reply"></label>
                                            <span><?php echo $this->lang->line('Yes'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="smallspace clearfix"></div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-comment-dots"></i> <?php echo $this->lang->line("do you want to enable comment reply?") ?>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="checkbox" name="edit_comment_reply_enabled" value="yes"
                                                   id="edit_comment_reply_enabled" class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="edit_comment_reply_enabled"></label>
                                            <span><?php echo $this->lang->line('Yes'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="smallspace clearfix"></div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-comment"></i> <?php echo $this->lang->line("do you want to like on comment by page?") ?>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="checkbox" name="edit_auto_like_comment" value="yes"
                                                   id="edit_auto_like_comment" class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="edit_auto_like_comment"></label>
                                            <span><?php echo $this->lang->line('Yes'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="smallspace clearfix"></div>
                        <!-- comment hide and delete section -->
                        <div class="col-12" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-show-slash"></i> <?php echo $this->lang->line("do you want to hide comments after comment reply?") ?>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="checkbox" name="edit_hide_comment_after_comment_reply"
                                                   value="yes" id="edit_hide_comment_after_comment_reply"
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="edit_hide_comment_after_comment_reply"></label>
                                            <span><?php echo $this->lang->line('Yes'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- comment hide and delete section -->

                        <div class="smallspace clearfix"></div>

                        <div class="col-12">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="edit_message_type" value="generic" id="edit_generic"
                                       class="custom-control-input radio_button">
                                <label class="custom-control-label"
                                       for="edit_generic"><?php echo $this->lang->line("generic message for all") ?></label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="edit_message_type" value="filter" id="edit_filter"
                                       class="custom-control-input radio_button">
                                <label class="custom-control-label"
                                       for="edit_filter"><?php echo $this->lang->line("send message by filtering word/sentence") ?></label>
                            </div>

                        </div>
                        <div class="col-12" style="margin-top: 15px;">
                            <div class="form-group">
                                <label>
                                    <i class="bx bx-rocket"></i> <?php echo $this->lang->line("auto reply campaign name") ?>
                                    <span class="text-danger">*</span>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("write your auto reply campaign name here") ?>"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input class="form-control" type="text" name="edit_auto_campaign_name"
                                       id="edit_auto_campaign_name"
                                       placeholder="<?php echo $this->lang->line("write your auto reply campaign name here") ?>">
                            </div>
                        </div>

                        <div class="col-12" id="edit_generic_message_div" style="display: none;">
                            <div class="form-group clearfix" style="border: 1px dashed #ccc; padding: 10px;">
                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("message for comment reply") ?>
                                    <span class="text-danger">*</span>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("write your message which you want to send. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php if ($comment_tag_machine_addon) { ?>
                                    <span class='float-right'>
                <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                   data-toggle="tooltip" data-placement="top" class='btn-sm lead_tag_name button-outline'><i
                            class='bx bx-tag'></i>  <?php echo $this->lang->line("tag user") ?></a>
              </span>
                                <?php } ?>
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

                                <?php echo $btn_spintax_html; ?>

                                <div class="clearfix"></div>
                                <textarea class="form-control message" name="edit_generic_message"
                                          id="edit_generic_message"
                                          placeholder="<?php echo $this->lang->line("type your message here...") ?>"
                                          style="height:170px !important;"></textarea>


                                <!-- comment hide and delete scetion -->
                                <br/>
                                <div class="clearfix" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="control-label"><i
                                                        class="bx bx-image"></i> <?php echo $this->lang->line("image for comment reply") ?>
                                            </label>
                                            <div class="form-group">
                                                <div id="edit_generic_comment_image"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <div id="edit_generic_image_preview_id"></div>
                                            <span class="text-danger" id="generic_image_for_comment_reply_error"></span>
                                            <input type="text" name="edit_generic_image_for_comment_reply"
                                                   class="form-control" id="edit_generic_image_for_comment_reply"
                                                   placeholder="<?php echo $this->lang->line("put your image url here or click the above upload button") ?>"
                                                   style="margin-top: -14px;"/>
                                            <div class="overlay_wrapper">
                                                <span></span>
                                                <img src="" alt="image"
                                                     id="edit_generic_image_for_comment_reply_display" height="240"
                                                     width="100%" style="display:none;"/>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="control-label"><i
                                                        class="bx bxl-youtube"></i> <?php echo $this->lang->line("video for comment reply") ?>
                                                [mp4 <?php echo $this->lang->line("Prefered"); ?>]
                                                <a href="#" data-placement="bottom" data-toggle="popover"
                                                   data-trigger="focus"
                                                   title="<?php echo $this->lang->line("video upload") ?>"
                                                   data-content="<?php echo $this->lang->line("image and video will not work together. Please choose either image or video.") ?> [mp4,wmv,flv]"><i
                                                            class='bx bx-info-circle'></i></a>
                                            </label>
                                            <div class="form-group">
                                                <div id="edit_generic_video_upload"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <div id="edit_generic_video_preview_id"></div>
                                            <span class="text-danger"
                                                  id="edit_generic_video_comment_reply_error"></span>
                                            <input type="hidden" name="edit_generic_video_comment_reply"
                                                   class="form-control" id="edit_generic_video_comment_reply"
                                                   placeholder="<?php echo $this->lang->line("put your image url here or click upload") ?>"/>

                                            <div class="overlay_wrapper">
                                                <span></span>
                                                <video width="100%" height="240" controls
                                                       style="border:1px solid #ccc;display:none;">
                                                    <source src="" id="edit_generic_video_comment_reply_display"
                                                            type="video/mp4">
                                                    <?php echo $this->lang->line("your browser does not support the video tag.") ?>
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/><br/>
                                <!-- comment hide and delete scetion -->


                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>]
                                </label>
                                <div>
                                    <select class="form-group private_reply_postback" id="edit_generic_message_private"
                                            name="edit_generic_message_private">
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="col-12" id="edit_filter_message_div" style="display: none;">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="custom-switch">
                                        <input type="radio" name="edit_trigger_matching_type" value="exact"
                                               id="edit_trigger_keyword_exact" class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><?php echo $this->lang->line('Reply if the filter word exactly matches.'); ?></span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="custom-switch">
                                        <input type="radio" name="edit_trigger_matching_type" value="string"
                                               id="edit_trigger_keyword_string" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><?php echo $this->lang->line('Reply if any matches occurs with filter word.'); ?>
                                    </label>
                                </div>
                            </div>
                            <br/>
                            <?php for ($i = 1; $i <= 20; $i++) : ?>
                                <div class="form-group clearfix" id="edit_filter_div_<?php echo $i; ?>"
                                     style="border: 1px dashed #ccc; padding: 10px; margin-bottom: 50px;">
                                    <label>
                                        <i class="bx bx-tag"></i> <?php echo $this->lang->line("filter word/sentence") ?>
                                        <span class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, want to know, when") ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <input class="form-control filter_word" type="text"
                                           name="edit_filter_word_<?php echo $i; ?>"
                                           id="edit_filter_word_<?php echo $i; ?>"
                                           placeholder="<?php echo $this->lang->line("write your filter word here") ?>">


                                    <br/>
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("msg for comment reply") ?>
                                        <span class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("write your message which you want to send based on filter words. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <?php if ($comment_tag_machine_addon) { ?>
                                        <span class='float-right'>
                <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                   data-toggle="tooltip" data-placement="top" class='btn-sm lead_tag_name button-outline'><i
                            class='bx bx-tag'></i>  <?php echo $this->lang->line("tag user") ?></a>
              </span>
                                    <?php } ?>
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

                                    <?php echo $btn_spintax_html; ?>

                                    <div class="clearfix"></div>
                                    <textarea class="form-control message"
                                              name="edit_comment_reply_msg_<?php echo $i; ?>"
                                              id="edit_comment_reply_msg_<?php echo $i; ?>"
                                              placeholder="<?php echo $this->lang->line("type your message here...") ?>"
                                              style="height:170px !important;"></textarea>


                                    <!-- comment hide and delete section -->
                                    <br/>
                                    <div class="clearfix" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label class="control-label"><i
                                                            class="bx bx-image"></i> <?php echo $this->lang->line("image for comment reply") ?>
                                                </label>
                                                <div class="form-group">
                                                    <div id="edit_filter_image_upload_<?php echo $i; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                </div>
                                                <div id="edit_generic_image_preview_id_<?php echo $i; ?>"></div>
                                                <span class="text-danger"
                                                      id="edit_generic_image_for_comment_reply_error_<?php echo $i; ?>"></span>
                                                <input type="text"
                                                       name="edit_filter_image_upload_reply_<?php echo $i; ?>"
                                                       class="form-control"
                                                       id="edit_filter_image_upload_reply_<?php echo $i; ?>"
                                                       placeholder="<?php echo $this->lang->line("put your image url here or click the above upload button") ?>"
                                                       style="margin-top: -14px;"/>
                                                <div class="overlay_wrapper">
                                                    <span></span>
                                                    <img src="" alt="image"
                                                         id="edit_filter_image_upload_reply_display_<?php echo $i; ?>"
                                                         height="240" width="100%" style="display:none"/>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="control-label"><i
                                                            class="bx bxl-youtube"></i> <?php echo $this->lang->line("video for comment reply") ?>
                                                    [mp4 <?php echo $this->lang->line("Prefered"); ?>]
                                                    <a href="#" data-placement="bottom" data-toggle="popover"
                                                       data-trigger="focus"
                                                       title="<?php echo $this->lang->line("video upload") ?>"
                                                       data-content="<?php echo $this->lang->line("image and video will not work together. Please choose either image or video.") ?> [mp4,wmv,flv]"><i
                                                                class='bx bx-info-circle'></i></a>
                                                </label>
                                                <div class="form-group">
                                                    <div id="edit_filter_video_upload_<?php echo $i; ?>"><?php echo $this->lang->line("upload") ?></div>
                                                </div>
                                                <div id="edit_generic_video_preview_id_<?php echo $i; ?>"></div>
                                                <span class="text-danger"
                                                      id="edit_generic_video_comment_reply_error_<?php echo $i; ?>"></span>
                                                <input type="hidden"
                                                       name="edit_filter_video_upload_reply_<?php echo $i; ?>"
                                                       class="form-control"
                                                       id="edit_filter_video_upload_reply_<?php echo $i; ?>"
                                                       placeholder="<?php echo $this->lang->line("put your image url here or click upload") ?>"/>

                                                <div class="overlay_wrapper">
                                                    <span></span>
                                                    <video width="100%" height="240" controls
                                                           style="border:1px solid #ccc;display:none;">
                                                        <source src=""
                                                                id="edit_filter_video_upload_reply_display<?php echo $i; ?>"
                                                                type="video/mp4">
                                                        <?php echo $this->lang->line("your browser does not support the video tag.") ?>
                                                    </video>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- comment hide and delete section -->

                                    <br/>

                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                        [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>]
                                    </label>
                                    <div>
                                        <select class="form-group private_reply_postback"
                                                id="edit_filter_message_<?php echo $i; ?>"
                                                name="edit_filter_message_<?php echo $i; ?>">
                                            <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i
                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                        </a>
                                        <a href="" class="ref_template float-right"><i
                                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                        </a>
                                    </div>

                                </div>
                            <?php endfor; ?>


                            <div class="clearfix">
                                <input type="hidden" name="edit_content_counter" id="edit_content_counter"/>
                                <button type="button" class="btn btn-sm btn-outline-primary float-right"
                                        id="edit_add_more_button"><i
                                            class="bx bx-plus"></i> <?php echo $this->lang->line("add more filtering") ?>
                                </button>
                            </div>

                            <div class="form-group clearfix" id="edit_nofilter_word_found_div"
                                 style="margin-top: 10px; border: 1px dashed #ccc; padding: 10px;">
                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("comment reply if no matching found") ?>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("Write the message,  if no filter word found. If you don't want to send message them, just keep it blank ."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php if ($comment_tag_machine_addon) { ?>
                                    <span class='float-right'>
                <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                   data-toggle="tooltip" data-placement="top" class='btn-sm lead_tag_name button-outline'><i
                            class='bx bx-tag'></i>  <?php echo $this->lang->line("tag user") ?></a>
              </span>
                                <?php } ?>
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

                                <?php echo $btn_spintax_html; ?>
                                <div class="clearfix"></div>
                                <textarea class="form-control message" name="edit_nofilter_word_found_text"
                                          id="edit_nofilter_word_found_text"
                                          placeholder="<?php echo $this->lang->line("type your message here...") ?>"
                                          style="height:170px !important;"></textarea>


                                <!-- comment hide and delete section -->
                                <br/>
                                <div class="clearfix" <?php if (!$commnet_hide_delete_addon) echo "style='display: none;'"; ?> >
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="control-label"><i
                                                        class="bx bx-image"></i> <?php echo $this->lang->line("image for comment reply") ?>
                                            </label>
                                            <div class="form-group">
                                                <div id="edit_nofilter_image_upload"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <div id="edit_nofilter_generic_image_preview_id"></div>
                                            <span class="text-danger"
                                                  id="edit_nofilter_image_upload_reply_error"></span>
                                            <input type="text" name="edit_nofilter_image_upload_reply"
                                                   class="form-control" id="edit_nofilter_image_upload_reply"
                                                   placeholder="<?php echo $this->lang->line("put your image url here or click the above upload button") ?>"
                                                   style="margin-top: -14px;"/>

                                            <div class="overlay_wrapper">
                                                <span></span>
                                                <img src="" alt="image" id="edit_nofilter_image_upload_reply_display"
                                                     height="240" width="100%" style="display:none;"/>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="control-label"><i
                                                        class="bx bxl-youtube"></i> <?php echo $this->lang->line("video for comment reply") ?>
                                                [mp4 <?php echo $this->lang->line("Prefered"); ?>]
                                                <a href="#" data-placement="bottom" data-toggle="popover"
                                                   data-trigger="focus"
                                                   title="<?php echo $this->lang->line("video upload") ?>"
                                                   data-content="<?php echo $this->lang->line("image and video will not work together. Please choose either image or video.") ?> [mp4,wmv,flv]"><i
                                                            class='bx bx-info-circle'></i></a>
                                            </label>
                                            <div class="form-group">
                                                <div id="edit_nofilter_video_upload"><?php echo $this->lang->line("upload") ?></div>
                                            </div>
                                            <div id="edit_nofilter_video_preview_id"></div>
                                            <span class="text-danger"
                                                  id="edit_nofilter_video_upload_reply_error"></span>
                                            <input type="hidden" name="edit_nofilter_video_upload_reply"
                                                   class="form-control" id="edit_nofilter_video_upload_reply"
                                                   placeholder="<?php echo $this->lang->line("put your image url here or click upload") ?>"/>

                                            <div class="overlay_wrapper">
                                                <span></span>
                                                <video width="100%" height="240" controls
                                                       style="border:1px solid #ccc;display:none;">
                                                    <source src="" id="edit_nofilter_video_upload_reply_display"
                                                            type="video/mp4">
                                                    <?php echo $this->lang->line("your browser does not support the video tag.") ?>
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/><br/>
                                <!-- comment hide and delete section -->

                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply if no matching found") ?>
                                    [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>]
                                </label>
                                <div>
                                    <select class="form-group private_reply_postback"
                                            id="edit_nofilter_word_found_text_private"
                                            name="edit_nofilter_word_found_text_private">
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center" id="edit_response_status"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="modal-footer" style="padding-left: 45px; padding-right: 45px; ">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary float-left" id="edit_save_button"><i class='bx bx-save'></i>
                            <span class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-secondary float-right cancel_button"><i class='bx bx-time'></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .smallspace {
        padding: 10px 0;
    }

    .lead_first_name, .lead_last_name, .lead_tag_name {
        background: #fff !important;
    }

    .ajax-file-upload-statusbar {
        width: 100% !important;
    }

    .emojionearea, .emojionearea.form-control {
        height: 170px !important;
    }


    .emojionearea.small-height {
        height: 140px !important;
    }

    .overlay_wrapper {
        position: relative;
        max-height: 240px;
        width: 100%;
        overflow: hidden;
    }

    .overlay_wrapper span.remove_media {
        position: absolute;
        right: 5px;
        top: 5px;
        background-color: black;
        color: white;
        padding: 4px 15px;
        font-size: 12px;
        border-radius: 15px;
        transition: 0.4s;
        -o-transition: 0.4s;
        -webkit-transition: 0.4s;
        -moz-transition: 0.4s;
        -ms-transition: 0.4s;
        opacity: 0;
        cursor: pointer;
        visibility: hidden;
    }

    .overlay_wrapper:hover span.remove_media {
        display: block;
        opacity: 1;
        visibility: visible;
        z-index: 1000;
    }

    .add_template, .ref_template {
        font-size: 10px;
    }

    .button-outline {
        background: #fff;
        border: .5px dashed #ccc;
    }

    .button-outline:hover {
        border: 1px dashed #6777EF !important;
        cursor: pointer;
    }

    /*#edit_add_more_button, #add_more_button
    {
      z-index: 9999 !important;
    }*/
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
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-sync"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("Close & Refresh List"); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="dynamic_page_id" id="dynamic_page_id">
