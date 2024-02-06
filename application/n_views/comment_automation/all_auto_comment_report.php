<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 1;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
?>

<?php

if (ultraresponse_addon_module_exist()) $commnet_hide_delete_addon = 1;
else $commnet_hide_delete_addon = 0;

if (addon_exist(201, "comment_reply_enhancers")) $comment_tag_machine_addon = 1;
else $comment_tag_machine_addon = 0;
$report_page_name = urldecode($this->uri->segment(3));

$image_upload_limit = 1;
if ($this->config->item('autoreply_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('autoreply_image_upload_limit');

$video_upload_limit = 3;
if ($this->config->item('autoreply_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('autoreply_video_upload_limit');
if (!isset($is_instagram)) $is_instagram = '0';
?>

<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/select2_100.css?ver=' . $n_config['theme_version']); ?>">
<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/instagram/all_auto_comment_report.css?ver=' . $n_config['theme_version']); ?>">

<style type="text/css">
    div.tooltip {
        top: 0px !important;
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
                <div class="card-body data-card">
                    <div class="input-group mb-3" id="searchbox">
                        <div class="input-group-prepend">
                            <select class="select2 form-control" id="page_id">
                                <option value=""><?php echo $is_instagram == '1' ? $this->lang->line("Account Name") : $this->lang->line("Page Name"); ?></option>
                                <?php foreach ($page_info as $value): if ($is_instagram == '1' && $value['has_instagram'] == '0') continue; ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $page_id || $value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?> ><?php echo $is_instagram == '1' ? $value['insta_username'] : $value['page_name']; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <input type="text" class="form-control" value="<?php if ($post_id != 0) echo $post_id; ?>"
                               id="campaign_name" autofocus placeholder="<?php echo $this->lang->line('Search...'); ?>"
                               aria-label="" aria-describedby="basic-addon2">
                        <input type="hidden" class="form-control" value="<?php echo $is_instagram; ?>" id="is_instagram"
                               name="is_instagram">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="search_submit" type="button"><i
                                        class="bx bx-search"></i> <span
                                        class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Page ID"); ?></th>
                                <th><?php echo $this->lang->line("Avatar") ?></th>
                                <th><?php echo $this->lang->line("Name") ?></th>
                                <th class="min_width_70px"><?php echo $is_instagram == '1' ? $this->lang->line("Account") : $this->lang->line("Page"); ?></th>
                                <th><?php echo $this->lang->line("Post ID") ?></th>
                                <th><?php echo $this->lang->line("Actions") ?></th>
                                <th><?php echo $this->lang->line("Reply Sent") ?></th>
                                <th><?php echo $this->lang->line("status") ?></th>
                                <th><?php echo $this->lang->line("Last Reply Time") ?></th>
                                <th><?php echo $this->lang->line("Error Message") ?></th>
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


<div class="modal fade" id="view_report_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-comment-dots"></i> <?php echo $this->lang->line("Auto Comment Report"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body data-card">
                <div class="row">
                    <div class="col-12 col-md-9">
                        <input type="text" id="searching" name="searching" class="form-control width_200px"
                               placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive2">
                            <input type="hidden" id="put_row_id">
                            <table class="table table-bordered" id="mytable1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo $this->lang->line("Comment ID"); ?></th>
                                    <th><?php echo $this->lang->line("Comment"); ?></th>
                                    <th><?php echo $this->lang->line("comment time"); ?></th>
                                    <th><?php echo $this->lang->line("Schedule Type"); ?></th>
                                    <th><?php echo $this->lang->line("Comment Status"); ?></th>
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


<div class="modal fade" id="edit_auto_reply_message_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center pt-2 pb-2 pl-4 pr-4"><?php echo $this->lang->line("Please give the following information for post auto comment") ?></h3>
                <button type="button" id='edit_modal_close' class="close">&times;</button>
            </div>
            <form action="#" id="edit_auto_reply_info_form" method="post">
                <input type="hidden" name="edit_auto_reply_page_id_template" id="edit_auto_reply_page_id_template"
                       value="">
                <input type="hidden" name="edit_auto_reply_post_id_template" id="edit_auto_reply_post_id_template"
                       value="">
                <div class="modal-body" id="edit_auto_reply_message_modal_body">

                    <div class="text-center waiting previewLoader"><i class="bx bx-loader-alt bx-spin blue text-center"
                                                                      style="font-size: 40px;"></i></div>

                    <div class="row pt-2 pb-2 pr-4 pl-4">

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label>
                                    <i class="bx bx-rocket"></i> <?php echo $this->lang->line('Auto comment campaign name'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <br>
                                <input class="form-control" type="text" name="edit_campaign_name_template"
                                       id="edit_campaign_name_template"
                                       placeholder="Write your auto reply campaign name here">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group col-12 col-md-12 p-0">
                                <label>
                                    <i class="bx bxs-grid-alt"></i> <?php echo $this->lang->line('Auto Comment Template'); ?>
                                    <span class="text-danger">*</span>
                                </label>
                                <br>
                                <select class="form-control select2 w-100" id="edit_auto_comment_template_id"
                                        name="edit_auto_comment_template_id">
                                    <?php
                                    echo "<option value='0'>{$this->lang->line('Please select a template')}</option>";
                                    foreach ($auto_comment_template as $key => $val) {
                                        $id = $val['id'];
                                        $group_name = $val['template_name'];
                                        echo "<option value='{$id}'>{$group_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>

                        <br>
                        <div class="col-12">
                            <div class="form-group">
                                <label>
                                    <i class="bx bx-time"></i> <?php echo $this->lang->line('Schedule Type'); ?> <span
                                            class="text-danger">*</span>
                                    <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                       title=""
                                       data-content="<?php echo $this->lang->line('Onetime campaign will comment only the first comment of the selected template and periodic campaign will auto comment multiple time periodically as per your settings.'); ?>"
                                       data-original-title="<?php echo $this->lang->line('Schedule Type'); ?>"><i
                                                class="bx bx-info-circle"></i> </a>
                                </label>
                                <br>
                                <div class="custom-control custom-switch custom-control-inline">
                                    <input type="radio" name="edit_schedule_type" value="onetime"
                                           id="edit_schedule_type_o" class="custom-control-input">
                                    <label class="custom-control-label mr-1" for="edit_schedule_type_o"></label>
                                    <span><?php echo $this->lang->line('One Time'); ?></span>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="custom-control custom-switch custom-control-inline">
                                    <input type="radio" name="edit_schedule_type" value="periodic"
                                           id="edit_schedule_type_p" class="custom-control-input">
                                    <label class="custom-control-label mr-1" for="edit_schedule_type_p"></label>
                                    <span><?php echo $this->lang->line('Periodic'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group schedule_block_item_o col-12 col-md-6">
                                    <label><?php echo $this->lang->line('Schedule time'); ?></label>
                                    <input placeholder="<?php echo $this->lang->line('Time'); ?>"
                                           name="edit_schedule_time_o" id="edit_schedule_time_o"
                                           class="form-control datepicker_x" type="text"/>
                                </div>

                                <div class="form-group schedule_block_item_o col-12 col-md-6">
                                    <label><?php echo $this->lang->line('Time zone'); ?></label>
                                    <?php
                                    $time_zone[''] = $this->lang->line('Please Select');
                                    echo form_dropdown('edit_time_zone_o', $time_zone, set_value('time_zone'), ' class="form-control select2 w-100" id="edit_time_zone_o" required');
                                    ?>
                                </div>
                            </div>

                            <div class='schedule_block_item_new_p inatagram_padded_bordered_background_schedule_block'>
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="form-group schedule_block_item_new_p col-12 col-md-6">
                                        <label><?php echo $this->lang->line('Periodic Schedule time'); ?>
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus" title=""
                                               data-content="<?php echo $this->lang->line('Choose how frequently you want to comment'); ?>"
                                               data-original-title="<?php echo $this->lang->line('Periodic Schedule time'); ?>"><i
                                                        class="bx bx-info-circle"></i> </a>
                                        </label>
                                        <?php
                                        $periodic_time[''] = $this->lang->line('Please Select Periodic Time Schedule');
                                        echo form_dropdown('edit_periodic_time', $periodic_time, set_value('edit_periodic_time'), ' class="form-control select2 w-100" id="edit_periodic_time" required');
                                        ?>
                                    </div>

                                    <div class="form-group schedule_block_item_new_p col-12 col-md-6">
                                        <label><?php echo $this->lang->line('Time zone'); ?></label>
                                        <?php
                                        $time_zone[''] = $this->lang->line('Please Select');
                                        echo form_dropdown('edit_periodic_time_zone', $time_zone, set_value('edit_periodic_time_zone'), ' class="form-control select2 w-100" id="edit_periodic_time_zone" required');
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group schedule_block_item_new_p col-12 col-md-6">
                                        <label><?php echo $this->lang->line('Campaign Start time'); ?></label>
                                        <input placeholder="<?php echo $this->lang->line('Time'); ?>"
                                               name="edit_campaign_start_time" id="edit_campaign_start_time"
                                               class="form-control datepicker_x" type="text"/>
                                    </div>
                                    <div class="form-group schedule_block_item_new_p col-12 col-md-6">
                                        <label><?php echo $this->lang->line('Campaign End time'); ?></label>
                                        <input placeholder="<?php echo $this->lang->line('Time'); ?>"
                                               name="edit_campaign_end_time" id="edit_campaign_end_time"
                                               class="form-control datepicker_x" type="text"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group schedule_block_item_new_p col-12 col-md-6">
                                        <label>
                                            <?php echo $this->lang->line('Comment Between Time'); ?>
                                            <a href="#" data-placement="bottom" data-toggle="popover"
                                               data-trigger="focus" title=""
                                               data-content="<?php echo $this->lang->line("Set the allowed time of the comment. As example you want to auto comment by page from 10 AM to 8 PM. You don't want to comment other time. So set it 10:00 & 20:00"); ?>"
                                               data-original-title="<?php echo $this->lang->line('Comment Between Time'); ?>"><i
                                                        class="bx bx-info-circle"></i>
                                            </a>
                                        </label>
                                        <input placeholder="<?php echo $this->lang->line('Time'); ?>"
                                               name="edit_comment_start_time" id="edit_comment_start_time"
                                               class="form-control datetimepicker2" type="text"/>
                                    </div>
                                    <div class="form-group schedule_block_item_new_p col-12 col-md-6">
                                        <label class="inatagram_relative_top_right_22px"><?php echo $this->lang->line('to'); ?></label>
                                        <input placeholder="<?php echo $this->lang->line('Time'); ?>"
                                               name="edit_comment_end_time" id="edit_comment_end_time"
                                               class="form-control datetimepicker2" type="text"/>
                                    </div>
                                </div>

                                <div class="form-group schedule_block_item_new_p col-12 col-md-12">

                                    <label>
                                        <i class="bx bx-comment"></i> <?php echo $this->lang->line('Auto Comment Type'); ?>
                                        <span class="text-danger">*</span>
                                        <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                                           title=""
                                           data-content="<?php echo $this->lang->line('Random type will pick a comment from template randomly each time and serial type will pick the comment serially from selected template first to last.'); ?>"
                                           data-original-title="<?php echo $this->lang->line('Auto Comment Type'); ?>"><i
                                                    class="bx bx-info-circle"></i> </a>
                                    </label>
                                    <br>
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="edit_auto_comment_type" value="random"
                                               id="edit_random" class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="edit_random"></label>
                                        <span><?php echo $this->lang->line('Random'); ?></span>
                                    </div>
                                    <div class="custom-control custom-switch custom-control-inline">
                                        <input type="radio" name="edit_auto_comment_type" value="serially"
                                               id="edit_serially" class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="edit_serially"></label>
                                        <span><?php echo $this->lang->line('Serially'); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <br/>
                    </div>
                    <div class="row pt-2 pb-2 pl-4 pr-4">
                        <!-- added by mostofa on 26-04-2017 -->
                        <div class="smallspace clearfix"></div>
                    </div>

                    <div class="col-12 text-center" id="edit_response_status"></div>
                </div>
            </form>
            <div class="clearfix"></div>

            <div class="modal-footer padding_0_45px">
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

    .ajax-upload-dragdrop {
        width: 100% !important;
    }

    .renew_campaign {
        cursor: pointer;
    }
</style>