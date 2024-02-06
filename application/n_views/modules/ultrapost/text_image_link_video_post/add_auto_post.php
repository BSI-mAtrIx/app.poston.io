<?php
//TODO: change preview FB
//TODO: FIx MODAL
$image_upload_limit = 1;
if ($this->config->item('facebook_poster_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('facebook_poster_image_upload_limit');

$video_upload_limit = 10;
if ($this->config->item('facebook_poster_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');

?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/css/emojionearea.min.css" media="screen">
<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet" type="text/css"/>
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
                <div class="card-header border-bottom">
                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Campaign Form'); ?></h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs justify-content-center mb-0 pb-0" role="tablist"
                        style="width:100% !important">
                        <li class="nav-item">
                            <a id="text_post" class="nav-link post_type active" data-toggle="tab" href="#textPost"
                               role="tab" aria-selected="false"><i
                                        class="bx bxs-file"></i> <?php echo $this->lang->line('Text') ?></a>
                        </li>
                        <li class="nav-item">
                            <a id="link_post" class="nav-link post_type" data-toggle="tab" href="#linkPost" role="tab"
                               aria-selected="true"><i class="bx bx-link"></i> <?php echo $this->lang->line("Link") ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="image_post" class="nav-link post_type" data-toggle="tab" href="#imagePost" role="tab"
                               aria-selected="false"><i
                                        class="bx bx-image"></i> <?php echo $this->lang->line("Image"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a id="video_post" class="nav-link post_type" data-toggle="tab" href="#videoPost" role="tab"
                               aria-selected="false"><i
                                        class="bx bx-video"></i> <?php echo $this->lang->line("Video"); ?></a>
                        </li>
                    </ul>

                    <!-- tab body started -->
                    <div class="tab-content mt-1" id="post_tab_content">
                        <form action="#" enctype="multipart/form-data" id="auto_poster_form" method="post">
                            <label for="campaign_name"><?php echo $this->lang->line('Campaign Name'); ?></label>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input name="campaign_name" id="campaign_name"
                                       class="form-control" type="text"
                                       placeholder="<?php echo $this->lang->line('Campaign Name'); ?>">
                                <div class="form-control-position">
                                    <i class="bx bxs-compass"></i>
                                </div>
                                <span class="text-danger"><?php echo form_error('campaign_name'); ?></span>
                            </fieldset>

                            <div class="form-group">
                                <label for="message"><?php echo $this->lang->line('Message'); ?></label>
                                <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                   title="<?php echo $this->lang->line("message") ?>"
                                   data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                            class='bx bx-info-circle'></i> </a>
                                <textarea class="form-control" name="message" id="message"
                                          placeholder="<?php echo $this->lang->line('Type your message here...'); ?>"></textarea>
                            </div>

                            <div id="link_block">
                                <label for="link"><?php echo $this->lang->line('Paste link'); ?></label>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="text" class="form-control" name="link" id="link"
                                           placeholder="<?php echo $this->lang->line('Paste link'); ?>">
                                    <div class="form-control-position">
                                        <i class="bx bx-link"></i>
                                    </div>
                                </fieldset>

                                <div class="form-group hidden">
                                    <label for="link_caption"><?php echo $this->lang->line('Link caption'); ?></label>
                                    <input class="form-control" name="link_caption" id="link_caption" type="text">
                                </div>
                                <div class="form-group hidden">
                                    <label for="link_description"><?php echo $this->lang->line('Link description'); ?></label>
                                    <textarea class="form-control" name="link_description"
                                              id="link_description"></textarea>
                                </div>
                            </div>

                            <div id="image_block">
                                <label for="image_url"
                                       class="mt-1"><?php echo $this->lang->line('Image URL'); ?></label>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input name="image_url" id="image_url"
                                           class="form-control" type="text"
                                           placeholder="<?php echo $this->lang->line('Image URL'); ?>">
                                    <div class="form-control-position">
                                        <i class="bx bx-image"></i>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('image_url'); ?></span>
                                </fieldset>


                                <div class="form-group">
                                    <div id="image_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                    <br/>
                                </div>
                            </div>

                            <div id="video_block">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="video_url"><?php echo $this->lang->line('Video Link'); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="video_url" id="video_url"
                                                   class="form-control" type="text"
                                                   placeholder="<?php echo $this->lang->line('Video Link'); ?>"/>
                                            <div class="form-control-position">
                                                <i class="bx bx-link"></i>
                                            </div>
                                        </fieldset>

                                        <div class="form-group">
                                            <div id="video_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                            <br/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="video_thumb_url"><?php echo $this->lang->line('Video thumbnail URL'); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="video_thumb_url" id="video_thumb_url"
                                                   class="form-control" type="text"
                                                   placeholder="<?php echo $this->lang->line('Video thumbnail URL'); ?>"/>
                                            <div class="form-control-position">
                                                <i class="bx bx-image"></i>
                                            </div>
                                        </fieldset>

                                        <div class="form-group">
                                            <div id="video_thumb_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                            <br/>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="post_to_pages"><?php echo $this->lang->line("Post to pages"); ?>
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
                                                echo "<option value='{$id}'>{$page_name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="auto_reply_template">
                                            <?php echo $this->lang->line('Auto Reply Template') ?>
                                            <a href="#" data-placement="right" data-toggle="popover"
                                               data-trigger="focus"
                                               data-content="<?php echo $this->lang->line("Only Works For Pages."); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <select class="select2 form-control" id="auto_reply_template"
                                                name="auto_reply_template" style="width:100%;">
                                            <?php
                                            echo "<option value='0'>{$this->lang->line('Please select a template')}</option>";
                                            foreach ($auto_reply_template as $key => $val) {
                                                $id = $val['id'];
                                                $group_name = $val['ultrapost_campaign_name'];
                                                echo "<option value='{$id}'>{$group_name}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <?php if ($facebook_poster_group != '0' && $this->is_group_posting_exist): ?>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="post_to_groups"><?php echo $this->lang->line("Post to groups"); ?></label>
                                            <select multiple class="select2 form-control" id="post_to_groups"
                                                    name="post_to_groups[]" style="width: 100%;">
                                                <?php
                                                foreach ($fb_group_info as $key => $val) {
                                                    $id = $val['id'];
                                                    $group_name = $val['group_name'];
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

                                <div class="col-12 col-md-6">
                                    <fieldset>
                                        <p class="label_cust"><?php echo $this->lang->line("Posting Time") ?> <a
                                                    href="#" data-placement="top" data-toggle="popover"
                                                    data-trigger="focus"
                                                    title="<?php echo $this->lang->line("Posting Time") ?>"
                                                    data-content="<?php echo $this->lang->line("If you schedule a campaign, system will automatically process this campaign at mentioned time and time zone. Schduled campaign may take upto 1 hour longer than your schedule time depending on server's processing.") ?>"><i
                                                        class='bx bx-info-circle'></i> </a></p>
                                        <div class="checkbox">
                                            <input type="checkbox" name="schedule_type" id="schedule_type" value="now"
                                                   class="checkbox-input" checked>
                                            <label for="schedule_type"><?php echo $this->lang->line('Post Now'); ?></label>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('schedule_type'); ?></span>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="schedule_block_item col-12 col-md-6">
                                    <label for="schedule_time"><?php echo $this->lang->line('Schedule time'); ?></label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input name="schedule_time" id="schedule_time"
                                               class="form-control datepicker_x" type="text"
                                               placeholder="<?php echo $this->lang->line('Schedule time'); ?>">
                                        <div class="form-control-position">
                                            <i class="bx bx-time"></i>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('schedule_time'); ?></span>
                                    </fieldset>
                                </div>

                                <div class="schedule_block_item col-12 col-md-6">
                                    <label for="time_zone"><?php echo $this->lang->line('Time zone'); ?></label>
                                    <div class="form-group">
                                        <?php
                                        $time_zone[''] = $this->lang->line('Please Select');
                                        echo form_dropdown('time_zone', $time_zone, $this->config->item('time_zone'), ' class="form-control select2" id="time_zone" required');
                                        ?>
                                    </div>
                                </div>

                                <div class=" schedule_block_item col-12 col-md-6">
                                    <label for="repeat_times"><?php echo $this->lang->line('repost this post'); ?></label>
                                    <fieldset>
                                        <div class="input-group">
                                            <input type="number" name="repeat_times" id="repeat_times"
                                                   class="form-control"
                                                   placeholder="<?php echo $this->lang->line('repost this post'); ?>"
                                                   aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                      id="basic-addon2"><?php echo $this->lang->line('Times'); ?></span>
                                            </div>
                                        </div>
                                    </fieldset>

                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="schedule_block_item">
                                        <label for="time_interval"><?php echo $this->lang->line('time interval'); ?></label>
                                        <div class="form-group">
                                            <?php
                                            $time_interval[''] = $this->lang->line('Please Select Periodic Time Schedule');
                                            echo form_dropdown('time_interval', $time_interval, set_value('time_interval'), ' class="form-control select2" id="time_interval" required style="width:100%;"');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="card-footer p-0">
                                <input type="hidden" name="submit_post_hidden" id="submit_post_hidden"
                                       value="text_submit">
                                <button class="btn btn-primary" submit_type="text_submit" id="submit_post"
                                        name="submit_post" type="button"><i
                                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaign") ?>
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
                <div class="card-header border-bottom"><h4
                            class="card-title d-flex align-items-center"><?php echo $this->lang->line('Preview'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="section-title text-info mb-1">
                        <?php echo $this->lang->line('This preview may differ with actual post.'); ?>
                    </div>
                    <?php $profile_picture = "https://graph.facebook.com/me/picture?access_token={$fb_user_info[0]['access_token']}&width=150&height=150"; ?>
                    <ul class="list-unstyled list-unstyled-border">
                        <li class="media">
                            <img class="mr-3 rounded-circle" width="50" src="<?php echo $profile_picture; ?>"
                                 alt="avatar">
                            <div class="media-body">
                                <h6 class="media-title"><a href="#"><?php echo $fb_user_info[0]['name']; ?></a></h6>
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
                            <div class="preview_og_info_desc inline-block">
                            </div>
                            <div class="preview_og_info_link inline-block">
                            </div>
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
                <h4 class="modal-title"><?php echo $this->lang->line('Auto Post Campaign Status'); ?></h4>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('How to install APP in group.'); ?></h4>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
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
