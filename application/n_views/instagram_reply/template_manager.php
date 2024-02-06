<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
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

<?php $this->load->view('admin/theme/message'); ?>
<?php

if (ultraresponse_addon_module_exist()) $commnet_hide_delete_addon = 1;
else $commnet_hide_delete_addon = 0;

if (addon_exist(201, "comment_reply_enhancers")) $comment_tag_machine_addon = 1;
else $comment_tag_machine_addon = 0;

if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot"))
    $instagram_reply_bot_addon = 1;
else
    $instagram_reply_bot_addon = 0;
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

<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/instagram/instagram_template_manager.css?ver=' . $n_config['theme_version']); ?>">
<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/instagram/instagram_comment_reply.css?ver=' . $n_config['theme_version']); ?>">

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
                                href="<?php echo base_url("instagram_reply"); ?>"><?php echo $this->lang->line("Instagram reply"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary mb-1 enable_auto_commnet">
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
                                <th><?php echo $this->lang->line("Account Name"); ?></th>
                                <th class="min_width_150px"><?php echo $this->lang->line("Actions"); ?></th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title padding_10_20_10_20px"><?php echo $this->lang->line("Please give the following information for auto reply") ?></h3>
                <button type="button" class="close" id='modal_close' data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form action="#" id="auto_reply_info_form" method="post">
                <div class="modal-body" id="auto_reply_message_modal_body">
                    <div class="row padding_10_20_10_20px">
                        <div class="col-12 col-md-4 mt-2">
                            <label><i class="bx bx-file-blank"></i> <?php echo $this->lang->line("Please select a page for auto-reply") ?>
                            </label>
                        </div>
                        <div class="col-12 col-md-8">
                            <?php
                            $page_list[''] = $this->lang->line('Select an Account');
                            echo form_dropdown('ig_account_page_id', $page_list, '', 'class="form-control select2" id="ig_account_page_id" style="width:100%"');
                            ?>
                        </div>
                    </div>
                    <!-- comment hide and delete section -->
                    <div class="row padding_10_20_10_20px <?php if (!$commnet_hide_delete_addon) echo "d_none"; ?>">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-block"></i> <?php echo $this->lang->line("what do you want about offensive comments?") ?>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="custom-switch">
                                                <input type="radio" name="delete_offensive_comment" value="hide"
                                                       id="delete_offensive_comment_hide" class="custom-switch-input"
                                                       checked>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description"><?php echo $this->lang->line('hide'); ?></span>
                                            </label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="custom-switch">
                                                <input type="radio" name="delete_offensive_comment" value="delete"
                                                       id="delete_offensive_comment_delete" class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description"><?php echo $this->lang->line('delete'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <div class="col-12 col-md-6" id="delete_offensive_comment_keyword_div">
                            <div class="form-group e4e6fc_border_dashed">
                                <label><i class="bx bx-tag"></i> <?php echo $this->lang->line("write down the offensive keywords in comma separated") ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control message height_70px"
                                          name="delete_offensive_comment_keyword" id="delete_offensive_comment_keyword"
                                          placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"></textarea>
                            </div>
                        </div>
                        <!-- private reply section -->
                        <div class="col-12 col-md-6 <?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                            <div class="form-group clearfix e4e6fc_border_dashed">
                                <label><small>
                                        <i class='bx bx-envelope'></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?>
                                    </small>
                                </label>
                                <div>
                                    <select class="form-group private_reply_postback select2"
                                            id="private_message_offensive_words" name="private_message_offensive_words">
                                        <option value=""><?php echo $this->lang->line('Please select an account first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <!-- end of private reply section -->
                    </div>
                    <!-- end of comment hide and delete section -->

                    <div class="row padding_10_20_10_20px">

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6"><label><i
                                                class="bx bx-sort-down"></i> <?php echo $this->lang->line("Do you want to reply comments of a user multiple times?") ?>
                                    </label></div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="multiple_reply" value="yes" id="multiple_reply"
                                                   class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Yes'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="smallspace clearfix"></div>

                        <div class="col-12 <?php if (!$commnet_hide_delete_addon) echo 'd_none'; ?>">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-show-slash"></i> <?php echo $this->lang->line("do you want to hide comments after comment reply?") ?>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="hide_comment_after_comment_reply" value="yes"
                                                   id="hide_comment_after_comment_reply" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Yes'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- comment hide and delete section -->

                        <br/><br/>

                        <div class="col-12">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="message_type" value="generic" id="generic"
                                       class="custom-control-input radio_button">
                                <label class="custom-control-label"
                                       for="generic"><?php echo $this->lang->line("generic comment reply for all") ?></label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="message_type" value="filter" id="filter"
                                       class="custom-control-input radio_button">
                                <label class="custom-control-label"
                                       for="filter"><?php echo $this->lang->line("send comment reply by filtering word/sentence") ?></label>
                            </div>
                        </div>

                        <div class="col-12 margin_top_15">
                            <div class="form-group">
                                <label><i class="bx bx-rocket"></i>
                                    <?php echo $this->lang->line("auto comment reply campaign name") ?> <span
                                            class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="auto_campaign_name"
                                       id="auto_campaign_name"
                                       placeholder="<?php echo $this->lang->line("write your auto comment reply campaign name here") ?>">
                            </div>
                        </div>
                        <div class="col-12 d_none" id="generic_message_div">
                            <div class="form-group e4e6fc_border_dashed clearfix">
                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("comment reply text") ?>
                                    <span
                                            class="text-danger">*</span>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("write your message which you want to send. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                                       data-toggle="tooltip" data-placement="top"
                                       class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                                </span>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>"
                                       data-toggle="tooltip" data-placement="top"
                                       class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                class='bx bx-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                </span>
                                <?php echo $btn_spintax_html; ?>

                                <div class="clearfix"></div>
                                <textarea class="form-control message height_170px" name="generic_message"
                                          id="generic_message"
                                          placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                <!-- private reply section -->
                                <br><br>
                                <div class="<?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    </label>
                                    <select class="form-group private_reply_postback select2"
                                            id="generic_message_private" name="generic_message_private">
                                        <option value=""><?php echo $this->lang->line('Please select an account first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                </div>
                                <!-- end of private reply section -->
                            </div>
                        </div>
                        <div class="col-12 d_none" id="filter_message_div">
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
                                <div class="form-group instagram_border_padded2 clearfix"
                                     id="filter_div_<?php echo $i; ?>">
                                    <label><i class="bx bx-tag"></i> <?php echo $this->lang->line("filter word/sentence") ?>
                                        <span class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, wanto to know, when") ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <input class="form-control filter_word" type="text"
                                           name="filter_word_<?php echo $i; ?>" id="filter_word_<?php echo $i; ?>"
                                           placeholder="<?php echo $this->lang->line("write your filter word here") ?>">
                                    <br/>
                                    <br/>
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("comment reply text") ?>
                                        <span class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("write your message which you want to send based on filter words. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <span class='float-right'>
                                        <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                                           data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                    class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                                    </span>
                                    <span class='float-right'>
                                        <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>"
                                           data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                    class='bx bx-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                    </span>
                                    <?php echo $btn_spintax_html; ?>

                                    <div class="clearfix"></div>
                                    <textarea class="form-control message height_170px"
                                              name="comment_reply_msg_<?php echo $i; ?>"
                                              id="comment_reply_msg_<?php echo $i; ?>"
                                              placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                    <!-- private reply section -->
                                    <br><br>
                                    <div class="<?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                                        <label>
                                            <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                        </label>
                                        <select class="form-group private_reply_postback select2"
                                                id="filter_message_<?php echo $i; ?>"
                                                name="filter_message_<?php echo $i; ?>">
                                            <option value=""><?php echo $this->lang->line('Please select an account first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i
                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                        </a>
                                        <a href="" class="ref_template float-right"><i
                                                    class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                        </a>
                                    </div>
                                    <!-- end of private reply section -->

                                </div>
                            <?php endfor; ?>

                            <div class="clearfix">
                                <input type="hidden" name="content_counter" id="content_counter"/>
                                <button type="button" class="btn btn-sm btn-outline-primary float-right"
                                        id="add_more_button"><i
                                            class="bx bx-plus"></i> <?php echo $this->lang->line("add more filtering") ?>
                                </button>
                            </div>

                            <div class="form-group instagram_border_margined_padded" id="nofilter_word_found_div">
                                <label><i class="bx bx-envelope"></i> <?php echo $this->lang->line("comment reply if no matching found") ?>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("Write the message,  if no filter word found. If you don't want to send message them, just keep it blank ."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                                       data-toggle="tooltip" data-placement="top"
                                       class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                                </span>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>"
                                       data-toggle="tooltip" data-placement="top"
                                       class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                class='bx bx-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                </span>
                                <?php echo $btn_spintax_html; ?>

                                <div class="clearfix"></div>
                                <textarea class="form-control message height_170px" name="nofilter_word_found_text"
                                          id="nofilter_word_found_text"
                                          placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                <!-- private reply section -->
                                <br><br>
                                <div class="<?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    </label>
                                    <select class="form-group private_reply_postback select2"
                                            id="nofilter_word_found_text_private"
                                            name="nofilter_word_found_text_private">
                                        <option value=""><?php echo $this->lang->line('Please select an account first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                    <br><br>
                                </div>
                                <!-- end of private reply section -->

                            </div>

                        </div>
                    </div>
                    <div class="col-12 text-center" id="response_status"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="modal-footer bg-whitesmoke padding_0_45px">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary float-left" id="save_button"><i
                                    class='bx bx-save'></i> <?php echo $this->lang->line("Submit") ?></button>
                    </div>

                    <div class="col-6">
                        <button class="btn btn-secondary float-right" id="modal_close"><i
                                    class='bx bx-time'></i> <?php echo $this->lang->line("cancel") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center"><?php echo $this->lang->line("Please give the following information for auto Reply") ?></h3>
                <button type="button" id='edit_modal_close' data-dismiss="modal" class="close">&times;</button>
            </div>
            <form action="#" id="edit_auto_reply_info_form" method="post">
                <input type="hidden" name="table_id" id="table_id" value="">
                <div class="modal-body" id="edit_auto_reply_message_modal_body">

                    <div class="text-center waiting previewLoader"><i
                                class="bx bx-sync bx-spin blue text-center font_size_40px"></i></div>
                    <br>

                    <div class="row padding_10_20_10_20px">
                        <div class="col-12 col-md-4 mt-2">
                            <label><i class="bx bx-file-blank"></i> <?php echo $this->lang->line("Please select a page for auto-reply") ?>
                            </label>
                        </div>
                        <div class="col-12 col-md-8" id="edit_account_lists">

                        </div>
                    </div>


                    <!-- comment hide and delete section -->
                    <div class="row padding_10_20_10_20px <?php if (!$commnet_hide_delete_addon) echo 'd_none'; ?>">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-block"></i> <?php echo $this->lang->line("what do you want about offensive comments?") ?>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="custom-switch">
                                                <input type="radio" name="edit_delete_offensive_comment" value="hide"
                                                       id="edit_delete_offensive_comment_hide"
                                                       class="custom-switch-input" checked>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description"><?php echo $this->lang->line('hide'); ?></span>
                                            </label>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="custom-switch">
                                                <input type="radio" name="edit_delete_offensive_comment" value="delete"
                                                       id="edit_delete_offensive_comment_delete"
                                                       class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description"><?php echo $this->lang->line('delete'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br/><br/>
                        <div class="col-12 col-md-6" id="edit_delete_offensive_comment_keyword_div">
                            <div class="form-group e4e6fc_border_dashed">
                                <label><i class="bx bx-tag"></i> <?php echo $this->lang->line("write down the offensive keywords in comma separated") ?>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("offensive keywords") ?>"
                                       data-content="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions"); ?> "><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <textarea class="form-control message height_170px"
                                          name="edit_delete_offensive_comment_keyword"
                                          id="edit_delete_offensive_comment_keyword"
                                          placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"></textarea>
                            </div>
                        </div>
                        <!-- private reply section -->
                        <div class="col-12 col-md-6 <?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                            <div class="form-group clearfix e4e6fc_border_dashed">
                                <label><small>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?>
                                    </small>
                                </label>
                                <div>
                                    <select class="form-group private_reply_postback select2"
                                            id="edit_private_message_offensive_words"
                                            name="edit_private_message_offensive_words">
                                        <!-- <?php echo $private_reply_postbacks; ?> -->
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <!-- end of private reply section -->
                    </div>
                    <!-- end of comment hide and delete section -->


                    <div class="row padding_10_20_10_20px">
                        <div class="col-12">

                            <div class="row">
                                <div class="col-12 col-md-6"><label><i
                                                class="bx bx-sort-down"></i> <?php echo $this->lang->line("Do you want to reply comments of a user multiple times?") ?>
                                    </label></div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="edit_multiple_reply" value="yes"
                                                   id="edit_multiple_reply" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Yes'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="smallspace clearfix"></div>

                        <!-- comment hide and delete section -->
                        <div class="col-12 <?php if (!$commnet_hide_delete_addon) echo 'd_none'; ?>">

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label><i class="bx bx-show-slash"></i> <?php echo $this->lang->line("do you want to hide comments after comment reply?") ?>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="edit_hide_comment_after_comment_reply"
                                                   value="yes" id="edit_hide_comment_after_comment_reply"
                                                   class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Yes'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- comment hide and delete section -->

                        <br/><br/>

                        <div class="col-12">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="edit_message_type" value="generic" id="edit_generic"
                                       class="custom-control-input radio_button">
                                <label class="custom-control-label"
                                       for="edit_generic"><?php echo $this->lang->line("generic comment reply for all") ?></label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="edit_message_type" value="filter" id="edit_filter"
                                       class="custom-control-input radio_button">
                                <label class="custom-control-label"
                                       for="edit_filter"><?php echo $this->lang->line("send comment reply by filtering word/sentence") ?></label>
                            </div>
                        </div>

                        <div class="col-12 margin_top_15">
                            <div class="form-group">
                                <label>
                                    <i class="bx bx-rocket"></i> <?php echo $this->lang->line("auto comment reply campaign name") ?>
                                    <span
                                            class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" name="edit_auto_campaign_name"
                                       id="edit_auto_campaign_name"
                                       placeholder="<?php echo $this->lang->line("write your auto comment reply campaign name here") ?>">
                            </div>
                        </div>
                        <div class="col-12 d_none" id="edit_generic_message_div">
                            <div class="form-group e4e6fc_border_dashed clearfix">
                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("comment reply text") ?>
                                    <span
                                            class="text-danger">*</span>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("message") ?>"
                                       data-content="<?php echo $this->lang->line("write your message which you want to send. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php if ($comment_tag_machine_addon) { ?>
                                    <span class='float-right'>
                                        <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                                           data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                    class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                                    </span>
                                <?php } ?>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>"
                                       data-toggle="tooltip" data-placement="top"
                                       class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                class='bx bx-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                </span>
                                <?php echo $btn_spintax_html; ?>

                                <div class="clearfix"></div>
                                <textarea class="form-control message height_170px" name="edit_generic_message"
                                          id="edit_generic_message"
                                          placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                <!-- private reply section -->
                                <br><br>
                                <div class="<?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    </label>
                                    <select class="form-group private_reply_postback select2"
                                            id="edit_generic_message_private" name="edit_generic_message_private">
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                </div>
                                <!-- end of private reply section -->

                            </div>
                        </div>
                        <div class="col-12 d_none" id="edit_filter_message_div">
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
                                <div class="form-group instagram_border_padded2 clearfix"
                                     id="edit_filter_div_<?php echo $i; ?>">
                                    <label>
                                        <i class="bx bx-tag"></i> <?php echo $this->lang->line("filter word/sentence") ?>
                                        <span
                                                class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("Write the word or sentence for which you want to filter comment. For multiple filter keyword write comma separated. Example -   why, want to know, when") ?>"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <input class="form-control filter_word" type="text"
                                           name="edit_filter_word_<?php echo $i; ?>"
                                           id="edit_filter_word_<?php echo $i; ?>"
                                           placeholder="<?php echo $this->lang->line("write your filter word here") ?>">

                                    <br>
                                    <label>
                                        <?php echo $this->lang->line("comment reply text") ?><span
                                                class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("message") ?>"
                                           data-content="<?php echo $this->lang->line("write your message which you want to send based on filter words. You can customize the message by individual commenter name."); ?>  Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <?php if ($comment_tag_machine_addon) { ?>
                                        <span class='float-right'>
                                            <a title="<?php echo $this->lang->line("You can tag user in your comment reply. Facebook will notify them about mention whenever you tag.") ?>"
                                               data-toggle="tooltip" data-placement="top"
                                               class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                        class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                                        </span>
                                    <?php } ?>
                                    <span class='float-right'>
                                        <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>"
                                           data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                    class='bx bx-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                    </span>
                                    <?php echo $btn_spintax_html; ?>

                                    <div class="clearfix"></div>
                                    <textarea class="form-control message height_170px"
                                              name="edit_comment_reply_msg_<?php echo $i; ?>"
                                              id="edit_comment_reply_msg_<?php echo $i; ?>"
                                              placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                    <!-- private reply section -->
                                    <br><br>
                                    <div class="<?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                                        <label>
                                            <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                        </label>
                                        <select class="form-group private_reply_postback select2"
                                                id="edit_filter_message_<?php echo $i; ?>"
                                                name="edit_filter_message_<?php echo $i; ?>">
                                            <option><?php echo $this->lang->line('Please select an account first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i
                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                        </a>
                                        <a href="" class="ref_template float-right"><i
                                                    class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                        </a>
                                    </div>
                                    <!-- end of private reply section -->

                                </div>
                            <?php endfor; ?>

                            <div class="clearfix">
                                <input type="hidden" name="edit_content_counter" id="edit_content_counter"/>
                                <button type="button" class="btn btn-sm btn-outline-primary float-right"
                                        id="edit_add_more_button"><i
                                            class="bx bx-plus"></i> <?php echo $this->lang->line("add more filtering") ?>
                                </button>
                            </div>

                            <div class="form-group instagram_border_padded3 clearfix" id="edit_nofilter_word_found_div">
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
                                           data-toggle="tooltip" data-placement="top"
                                           class='btn btn-default btn-sm lead_tag_name button-outline'><i
                                                    class='bx bx-tag'></i> <?php echo $this->lang->line("mention user") ?></a>
                                    </span>
                                <?php } ?>
                                <span class='float-right'>
                                    <a title="<?php echo $this->lang->line("You can include #LEAD_USER_NAME# variable inside your message. The variable will be replaced by real username when we will send it.") ?>"
                                       data-toggle="tooltip" data-placement="top"
                                       class='btn btn-default btn-sm lead_first_name button-outline'><i
                                                class='bx bx-user'></i> <?php echo $this->lang->line("Username") ?></a>
                                </span>
                                <?php echo $btn_spintax_html; ?>

                                <div class="clearfix"></div>
                                <textarea class="form-control message height_170px" name="edit_nofilter_word_found_text"
                                          id="edit_nofilter_word_found_text"
                                          placeholder="<?php echo $this->lang->line("type your comment reply here...") ?>"></textarea>

                                <!-- private reply section -->
                                <br><br>
                                <div class="<?php if (!$instagram_reply_bot_addon) echo "d_none"; ?>">
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    </label>
                                    <select class="form-group private_reply_postback select2"
                                            id="edit_nofilter_word_found_text_private"
                                            name="edit_nofilter_word_found_text_private">
                                        <option><?php echo $this->lang->line('Please select an account first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                    <br><br>
                                </div>
                                <!-- end of private reply section -->

                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 text-center" id="edit_response_status"></div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="modal-footer bg-whitesmoke padding_0_45px">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary float-left" id="edit_save_button"><i
                                    class='bx bx-save''></i> <?php echo $this->lang->line("save") ?></button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-secondary float-right cancel_button"><i
                                    class='bx bx-time'></i> <?php echo $this->lang->line("cancel") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-mega">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title full_width">
                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?>
                </h5>
                <button type="button" class="close red" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i
                            class="bx bx-refresh"></i> <?php echo $this->lang->line("Close & Refresh List"); ?></button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="dynamic_page_id" id="dynamic_page_id">