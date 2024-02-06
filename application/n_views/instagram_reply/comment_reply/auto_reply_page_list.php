<?php
//todo: 00000 before release

?>
<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;

$btn_spintax_html = '';
if(file_exists(APPPATH.'n_sgp/injectors/spintax.php')){
    include(APPPATH.'n_sgp/injectors/spintax.php');
}
?>

<style>
    /*ntheme*/
    .media {
        margin-bottom: 20px;
    }

    .avatar-item {
        position: relative;
    }

    .avatar-item img {
        border-radius: 50%;
    }

    .avatar-item i {
        margin-top: 4px;
    }

    .avatar-item .dropdown {
        cursor: pointer;
        position: absolute;
        bottom: -5px;
        right: 0;
        background-color: #fff;
        color: #000;
        box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
        border-radius: 50%;
        text-align: center;
        line-height: 25px;
        width: 25px;
        height: 25px;
    }

    .product-item {
        text-align: center;
    }

    #middle_column .btn {
        padding: 7px 23px !important;
    }

    #right_column .dropdown-menu {
    }

    #right_column .mCSB_container {
        height: 100% !important;
        min-height: 500px !important;
    }

    #store_list_field .select2-container {
        width: 70% !important;
    }

    div.tooltip_pd {
        top: 0px !important;
    }

    #middle_column .media-title {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .ticket-info div {
        display: inline;
    }

    .ticket-title {
        margin-bottom: 0px !important;
    }

    .ticket-title h4 {
        font-size: 1rem !important;
    }

    .ticket-item {
        padding: 15px !important;
    }

    #add_template_modal {
        z-index: 1053 !important;
    }

    #right_column ul {
        min-height: 500px!important;
    }


</style>


<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/instagram/instagram_comment_reply.css?ver=' . $n_config['theme_version']); ?>">
<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/instagram/instagram_template_manager.css?ver=' . $n_config['theme_version']); ?>">
<?php
$commnet_hide_delete_addon = $commnet_hide_delete_addon;
$comment_tag_machine_addon = 1;
if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot"))
    $instagram_reply_bot_addon = 1;
else
    $instagram_reply_bot_addon = 0;

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
                                href="<?php echo base_url("instagram_reply") ?>"><?php echo $this->lang->line("Instagram Reply"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if (!empty($account_info)) { ?>
            <fieldset class="form-group width-500" id="store_list_field">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"
                               for="bot_list_select"><?php echo $this->lang->line("Accounts"); ?></label>
                    </div>
                    <select class="form-control select2" id="bot_list_select">

                        <?php $i = 0;
                        $current_store_data = array();
                        foreach ($account_info as $value) {
                            if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                            ?>
                            <option value="<?php echo $value['id']; ?>" <?php if ($i == 0) echo 'selected'; ?>><?php echo $value['insta_username']; ?></option>

                            <?php $i++;
                        } ?>
                    </select>
                </div>
            </fieldset>
        <?php } ?>

    </div>
</div>

<div class="row">
    <div class="col-12 mb-1">
        <?php if ($selected_global_media_type == 'fb') { ?>
            <a href="#" class="btn btn-primary social_switch"
               data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>
        <?php } else { ?>
            <a href="#" class="btn btn-primary social_switch"
               data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>
        <?php } ?>
    </div>
</div>


<?php if (empty($account_info)) { ?>

    <div class="card" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-fluid" src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>"
                     alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("We could not find any page."); ?></h2>
                <p class="lead"><?php echo $this->lang->line("Please import account if you have not imported yet.") . "<br>" . $this->lang->line("If you have already imported account then enable bot connection for one or more page to continue.") ?></p>
                <a href="<?php echo base_url('social_accounts'); ?>" class="btn btn-outline-primary mt-4"><i
                            class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line("Continue"); ?></a>
            </div>
        </div>
    </div>

<?php } else { ?>

    <div class="row multi_layout">

        <div class="col-12 col-md-7 col-lg-4 colmid" id="middle_column">

        </div>

        <div class="col-12 col-md-12 col-lg-8 colrig" id="right_column">

        </div>

    </div>

<?php } ?>


<input type="hidden" name="dynamic_page_id" id="dynamic_page_id">


<?php
$Youdidntprovideallinformation = $this->lang->line("you didn't provide all information.");
$Pleaseprovidepostid = $this->lang->line("please provide post id.");
$Youdidntselectanyoption = $this->lang->line("you didn\'t select any option.");
$AlreadyEnabled = $this->lang->line("already enabled");
$ThispostIDisnotfoundindatabaseorthispostIDisnotassociatedwiththepageyouareworking = $this->lang->line("This post ID is not found in database or this post ID is not associated with the page you are working.");
$EnableAutoReply = $this->lang->line("enable auto reply");
$areyousure = $this->lang->line("are you sure");
$disablebot = $this->lang->line("Disable reply");
$enablebot = $this->lang->line("Enable reply");
$restart_bot = $this->lang->line("Re-start Reply");
?>


<div class="modal fade" id="auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title padding_10_20_10_20px"><?php echo $this->lang->line("Please give the following information for post auto reply") ?></h3>
                <button type="button" class="close" id='modal_close' aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <form action="#" id="auto_reply_info_form" method="post">
                <input type="hidden" name="auto_reply_page_id" id="auto_reply_page_id" value="">
                <input type="hidden" name="auto_reply_post_id" id="auto_reply_post_id" value="">
                <input type="hidden" name="manual_enable" id="manual_enable" value="">
                <input type="hidden" name="create_new_template" id="create_new_template" value="">
                <div class="modal-body" id="auto_reply_message_modal_body">

                    <div class="row padding_0_20px">
                        <div class="col-12 col-md-6">
                            <label><i class="bx bx-list-ul"></i> <?php echo $this->lang->line("do you want to use saved template?") ?>
                                <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                   title="<?php echo $this->lang->line("message") ?>"
                                   data-content="<?php echo $this->lang->line("If you want to set campaign from previously saved template, then keep 'Yes' & select from below select option. If you want to add new settings, then select 'NO' , then auto reply settings form will come."); ?>"><i
                                            class='bx bx-info-circle'></i> </a>
                            </label>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="custom-switch">
                                    <input type="checkbox" name="auto_template_selection" value="yes"
                                           id="template_select" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description"><?php echo $this->lang->line('Yes'); ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- comment hide and delete section -->

                    <div id="auto_reply_templates_section padding_10_20_10_20px">
                        <!-- <hr> -->
                        <div id="all_save_templates">
                            <div id="saved_templates">
                                <div class="row">
                                    <div class="form-group col-12 col-md-3">
                                        <label><i class="bx bx-reply"></i> <?php echo $this->lang->line('Auto Reply Template'); ?>
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus" title="<?php echo $this->lang->line("message") ?>"
                                               data-content="<?php echo $this->lang->line("Select any saved template of Auto Reply Campaign. If you want to modify any settings of this post campaign later, then edit this campaign & modify. Be notified that editing the saved template will not affect the campaign settings. To edit campaign, you need to edit post reply settings.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                    </div>

                                    <div class="col-12 col-md-9">
                                        <select class="form-control select2" id="auto_reply_template"
                                                name="auto_reply_template">
                                            <?php echo "<option value='0'>{$this->lang->line('Please select a template')}</option>"; ?>
                                        </select>
                                    </div>
                                </div> <!-- end of row  -->
                            </div>
                        </div>
                    </div>
                    <!-- end of use saved template section -->

                    <div id="new_template_section">
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
                                                    <input type="radio" name="delete_offensive_comment" value="hide"
                                                           id="delete_offensive_comment_hide"
                                                           class="custom-switch-input" checked>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description"><?php echo $this->lang->line('hide'); ?></span>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="custom-switch">
                                                    <input type="radio" name="delete_offensive_comment" value="delete"
                                                           id="delete_offensive_comment_delete"
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
                            <div class="col-12 col-md-12" id="delete_offensive_comment_keyword_div">
                                <div class="form-group e4e6fc_border_dashed">
                                    <label><i class="bx bx-tag"></i> <?php echo $this->lang->line("write down the offensive keywords in comma separated") ?>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control message height_70px"
                                              name="delete_offensive_comment_keyword"
                                              id="delete_offensive_comment_keyword"
                                              placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"></textarea>
                                </div>
                            </div>
                            <!-- private reply section -->
                            <?php if ($instagram_reply_bot_addon) : ?>
                                <div class="col-12 col-md-6">
                                    <div class="form-group clearfix e4e6fc_border_dashed">
                                        <label><small>
                                                <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?>
                                            </small>
                                        </label>
                                        <div>
                                            <select class="form-group private_reply_postback select2"
                                                    id="private_message_offensive_words"
                                                    name="private_message_offensive_words">
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
                            <?php endif; ?>
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
                                                <input type="checkbox" name="multiple_reply" value="yes"
                                                       id="multiple_reply" class="custom-switch-input">
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
                                                <input type="checkbox" name="hide_comment_after_comment_reply"
                                                       value="yes" id="hide_comment_after_comment_reply"
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
                                <?php if(ai_reply_exist()) : ?>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="message_type" value="ai_reply" id="ai_reply" class="custom-control-input radio_button">
                                        <label class="custom-control-label" for="ai_reply"><?php echo $this->lang->line("automated reply by AI") ?></label>
                                    </div>
                                <?php endif; ?>
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
                                                class="text-danger">*</span></a>
                                    </label>
                                    <input class="form-control" type="text" name="auto_campaign_name"
                                           id="auto_campaign_name"
                                           placeholder="<?php echo $this->lang->line("write your auto comment reply campaign name here") ?>">
                                </div>
                            </div>

                            <div class="col-12" id="ai_message_div" style="display: none;">
                                <div class="form-group clearfix" style="border: 1px dashed #e4e6fc; padding: 20px;">
                                    <label>
                                        <i class="fa fa-robot"></i> <?php echo $this->lang->line("AI training data") ?> <span class="red">*</span>
                                    </label>
                                    <textarea class="form-control" name="ai_training_data" id="ai_training_data" placeholder="<?php echo $this->lang->line("type your message here...") ?>" style="height:170px !important;"></textarea>
                                </div>

                                <label>
                                  <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?> [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>]
                                </label>
                                <div>
                                  <select class="form-group private_reply_postback select2" id="ai_message_private" name="ai_message_private">
                                    <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                  </select>

                                  <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template");?></a>
                                  <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                                </div>

                            </div>

                            <div class="col-12 d_none" id="generic_message_div">
                                <div class="form-group e4e6fc_border_dashed">
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
                                    <?php if ($instagram_reply_bot_addon) : ?>
                                        <br><br>
                                        <label>
                                            <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                        </label>
                                        <div>
                                            <select class="form-group private_reply_postback select2"
                                                    id="generic_message_private" name="generic_message_private">
                                                <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                            </select>

                                            <a href="" class="add_template float-left"><i
                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                            </a>
                                            <a href="" class="ref_template float-right"><i
                                                        class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
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
                                    <div class="form-group instagram_border_padded2" id="filter_div_<?php echo $i; ?>">
                                        <label><i class="bx bx-tag"></i> <?php echo $this->lang->line("filter word/sentence") ?>
                                            <span class="text-danger">*</span>
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus" title="<?php echo $this->lang->line("message") ?>"
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
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus"
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
                                        <?php if ($instagram_reply_bot_addon) : ?>
                                            <br><br>
                                            <label>
                                                <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                            </label>
                                            <div>
                                                <select class="form-group private_reply_postback select2"
                                                        id="filter_message_<?php echo $i; ?>"
                                                        name="filter_message_<?php echo $i; ?>">
                                                    <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                                </select>

                                                <a href="" class="add_template float-left"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                                </a>
                                                <a href="" class="ref_template float-right"><i
                                                            class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
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
                                    <?php if ($instagram_reply_bot_addon) : ?>
                                        <br><br>
                                        <label>
                                            <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                        </label>
                                        <div>
                                            <select class="form-group private_reply_postback select2"
                                                    id="nofilter_word_found_text_private"
                                                    name="nofilter_word_found_text_private">
                                                <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                            </select>

                                            <a href="" class="add_template float-left"><i
                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                            </a>
                                            <a href="" class="ref_template float-right"><i
                                                        class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <!-- end of private reply section -->

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end of new template section -->

                    <div class="col-12 text-center" id="response_status"></div>
                </div>
                <input type="hidden" name="ai_reply_enabled" value="0" id="ai_reply_enabled">
            </form>
            <div class="clearfix"></div>
            <div class="modal-footer bg-whitesmoke padding_0_45px">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-info float-left save_create" create_template="yes" id="save_button"><i
                                    class='bx bx-save'></i> <?php echo $this->lang->line("Submit & Save as Template") ?>
                        </button>
                    </div>

                    <div class="col-6">
                        <button class="btn btn-primary float-right" create_template="no" id="save_button"><i
                                    class='bx bx-save'></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span>
                        </button>
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
                <h3 class="modal-title text-center"><?php echo $this->lang->line("Please give the following information for post auto Reply") ?></h3>
                <button type="button" id='edit_modal_close' class="close">&times;</button>
            </div>
            <div class="modal-body" id="edit_auto_reply_message_modal_body">
                <div class="text-center waiting previewLoader"><i
                            class="bx bx-sync bx-spin blue text-center font_size_40px"></i></div>
                <br>
            <form action="#" id="edit_auto_reply_info_form" method="post">
                <input type="hidden" name="edit_auto_reply_page_id" id="edit_auto_reply_page_id" value="">
                <input type="hidden" name="edit_auto_reply_post_id" id="edit_auto_reply_post_id" value="">
                <div class="modal-body" id="edit_auto_reply_message_modal_body">

                    <div class="text-center waiting previewLoader"><i class="fas fa-spinner fa-spin blue text-center font_size_40px"></i></div><br>


                    <!-- comment hide and delete section -->
                    <div class="row padding_10_20_10_20px <?php if (!$commnet_hide_delete_addon) echo 'd_none'; ?> ">
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
                        <div class="col-12 col-md-12" id="edit_delete_offensive_comment_keyword_div">
                            <div class="form-group e4e6fc_border_dashed">
                                <label><i class="bx bx-tag"></i> <?php echo $this->lang->line("write down the offensive keywords in comma separated") ?>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("offensive keywords") ?>"
                                       data-content="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions"); ?> "><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <textarea class="form-control message height_70px"
                                          name="edit_delete_offensive_comment_keyword"
                                          id="edit_delete_offensive_comment_keyword"
                                          placeholder="<?php echo $this->lang->line("Type keywords here in comma separated (keyword1,keyword2)...Keep it blank for no actions") ?>"></textarea>
                            </div>
                        </div>

                        <!-- private reply section -->
                        <?php if ($instagram_reply_bot_addon) : ?>
                            <div class="col-12 col-md-6">
                                <div class="form-group clearfix e4e6fc_border_dashed">
                                    <label><small>
                                            <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply after deleting offensive comment") ?>
                                        </small>
                                    </label>
                                    <div>
                                        <select class="form-group private_reply_postback select2"
                                                id="edit_private_message_offensive_words"
                                                name="edit_private_message_offensive_words">
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
                        <?php endif; ?>
                        <!-- end of private reply section -->
                    </div>

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
                                        <input type="checkbox" name="edit_hide_comment_after_comment_reply" value="yes"
                                               id="edit_hide_comment_after_comment_reply" class="custom-switch-input">
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
                        <?php if(ai_reply_exist()) : ?>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="edit_message_type" value="ai_reply" id="edit_ai_reply" class="custom-control-input radio_button">
                                <label class="custom-control-label" for="edit_ai_reply"><?php echo $this->lang->line("automated reply by AI") ?></label>
                            </div>
                        <?php endif; ?>
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

                        <div class="col-12" id="edit_ai_message_div" style="display: none;">
                            <div class="form-group clearfix" style="border: 1px dashed #e4e6fc; padding: 20px;">
                                <label>
                                    <i class="fa fa-robot"></i> <?php echo $this->lang->line("AI training data") ?> <span class="red">*</span>
                                </label>
                                <textarea class="form-control" name="edit_ai_training_data" id="edit_ai_training_data" placeholder="<?php echo $this->lang->line("type your message here...") ?>" style="height:170px !important;"></textarea>
                            </div>

                            <label>
                              <i class="fas fa-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?> [<?php echo $this->lang->line('Maximum two reply message is supported.'); ?>]
                            </label>
                            <div>
                              <select class="form-group private_reply_postback select2" id="edit_ai_message_private" name="edit_ai_message_private">
                                <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                              </select>

                              <a href="" class="add_template float-left"><i class="fa fa-plus-circle"></i>     <?php echo $this->lang->line("Add Message Template");?></a>
                              <a href="" class="ref_template float-right"><i class="fa fa-refresh"></i> <?php echo $this->lang->line("Refresh List");?></a>
                            </div>

                        </div>

                    <div class="col-12 d_none" id="edit_generic_message_div">
                        <div class="form-group e4e6fc_border_dashed">
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
                            <?php if ($instagram_reply_bot_addon) : ?>
                                <br><br>
                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                </label>
                                <div>
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
                            <?php endif; ?>
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
                            <div class="form-group instagram_border_margined_padded2"
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
                                       name="edit_filter_word_<?php echo $i; ?>" id="edit_filter_word_<?php echo $i; ?>"
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
                                <?php if ($instagram_reply_bot_addon) : ?>
                                    <br><br>
                                    <label>
                                        <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                    </label>
                                    <div>
                                        <select class="form-group private_reply_postback select2"
                                                id="edit_filter_message_<?php echo $i; ?>"
                                                name="edit_filter_message_<?php echo $i; ?>">
                                            <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left"><i
                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                        </a>
                                        <a href="" class="ref_template float-right"><i
                                                    class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
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

                        <div class="form-group instagram_border_margined_padded" id="edit_nofilter_word_found_div">
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
                            <?php if ($instagram_reply_bot_addon) : ?>
                                <br><br>
                                <label>
                                    <i class="bx bx-envelope"></i> <?php echo $this->lang->line("Select a message template for private reply") ?>
                                </label>
                                <div>
                                    <select class="form-group private_reply_postback select2"
                                            id="edit_nofilter_word_found_text_private"
                                            name="edit_nofilter_word_found_text_private">
                                        <option><?php echo $this->lang->line('Please select a page first to see the message templates.'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Message Template"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"><i
                                                class="bx bx-refresh"></i> <?php echo $this->lang->line("Refresh List"); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <!-- end of private reply section -->

                        </div>

                    </div>
                </div>

                <div class="col-xs-12 text-center" id="edit_response_status"></div>
                    <input type="hidden" name="edit_ai_reply_enabled" value="0" id="edit_ai_reply_enabled">


        </form>

        <div class="clearfix"></div>
        <div class="modal-footer bg-whitesmoke padding_0_45px">
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-primary float-left" id="edit_save_button"><i class='bx bx-save'></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                </div>
                <div class="col-6">
                    <button class="btn btn-secondary float-right cancel_button"><i class='bx bx-time'></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

<div class="modal fade" id="media_insights_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg_f1f1f1">
            <div class="modal-header bbw">
                <h3 class="modal-title"><i
                            class="bx bx-bar-chart"></i> <?php echo $this->lang->line('Post Analytics'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" id="media_insights_modal_body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="all_comments_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div id="all_comments_modal_contents"></div>
            </div>
        </div>
    </div>
</div>


<!-- instand comment checker -->
<div class="modal fade" id="instant_comment_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-comment"></i> <?php echo $this->lang->line("Instant Comment") ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="instant_comment_page_id" id="instant_comment_page_id">
                <input type="hidden" name="instant_comment_post_id" id="instant_comment_post_id">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="bx bx-keyboard"></i> <?php echo $this->lang->line("Please provide a message as comment") ?>
                            </label>
                            <textarea class="form-control" name="instant_comment_message" id="instant_comment_message"
                                      placeholder="<?php echo $this->lang->line("Type your comment here.") ?>"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary submit_instant_comment"><i
                                    class="bx bx-paper-plane"></i> <?php echo $this->lang->line('Create Comment'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$Youdidntprovideallinformation = $this->lang->line("you didn\'t provide all information.");
$Pleaseprovidepostid = $this->lang->line("please provide post id.");
$Youdidntselectanytemplate = $this->lang->line("you have not select any template.");
$Youdidntselectanyoptionyet = $this->lang->line("you have not select any option yet.");
$Youdidntselectanyoption = $this->lang->line("you have not select any option.");

$AlreadyEnabled = $this->lang->line("already enabled");
$ThispostIDisnotfoundindatabaseorthispostIDisnotassociatedwiththepageyouareworking = $this->lang->line("This post ID is not found in database or this post ID is not associated with the page you are working.");
$EnableAutoReply = $this->lang->line("enable auto reply");
$TypeAutoCampaignname = $this->lang->line("You have not Type auto campaign name");
$YouDidnotchosescheduleType = $this->lang->line("You have not choose any schedule type");
$YouDidnotchosescheduletime = $this->lang->line("You have not select any schedule time");
$YouDidnotchosescheduletimezone = $this->lang->line("You have not select any time zone");
$YoudidnotSelectPerodicTime = $this->lang->line("You have not select any periodic time");
$YoudidnotSelectCampaignStartTime = $this->lang->line("You have not choose campaign start time");
$YoudidnotSelectCampaignEndTime = $this->lang->line("You have not choose campaign end time");
?>
