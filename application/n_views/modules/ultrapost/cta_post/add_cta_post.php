<?php
//TODO: PREVIEW POST FB
$content_generator = file_exists(APPPATH.'modules/n_generator/include/modal_message_universal.php');
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
    .card {
        margin-bottom: 0;
        border-radius: 0;
    }

    .colmid {
        padding-left: 0;
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
                                href='<?php echo base_url("ultrapost/cta_post"); ?>'><?php echo $this->lang->line("CTA Posts"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card main_card">
                <div class="card-header border-bottom">
                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Campaign Form'); ?></h4>
                </div>
                <div class="card-body">
                    <!-- tab body started -->
                    <div class="tab-content">
                        <form action="#" enctype="multipart/form-data" id="cta_poster_form" method="post">

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
                                <?php if($content_generator){ ?>
                                    <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal=".emojionearea-editor" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <label for="link"><?php echo $this->lang->line('Paste link'); ?></label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="text" class="form-control" name="link" id="link"
                                               placeholder="<?php echo $this->lang->line('Paste link'); ?>">
                                        <div class="form-control-position">
                                            <i class="bx bx-link"></i>
                                        </div>
                                    </fieldset>

                                    <div class="form-group hidden">
                                        <label for="link_preview_image"><?php echo $this->lang->line('Preview image URL'); ?></label>
                                        <input class="form-control" name="link_preview_image" id="link_preview_image"
                                               type="text">
                                    </div>
                                    <div class="form-group hidden">
                                        <div id="link_preview_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                        <br/>
                                    </div>
                                    <div class="form-group hidden">
                                        <label for="link_caption"><?php echo $this->lang->line('Title'); ?></label>
                                        <input class="form-control" name="link_caption" id="link_caption" type="text">
                                    </div>
                                    <div class="form-group hidden">
                                        <label for="link_description"><?php echo $this->lang->line('Description'); ?></label>
                                        <textarea class="form-control" name="link_description"
                                                  id="link_description"></textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('CTA button type'); ?></label>
                                        <?php echo form_dropdown("cta_type", $cta_dropdown, "MESSAGE_PAGE", "class='select2 form-control' id='cta_type' style='width:100%;'"); ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group cta_value_container_div">
                                        <label for="cta_value"><?php echo $this->lang->line('CTA button action link'); ?></label>
                                        <input type="text" class="form-control" name="cta_value" id="cta_value">
                                    </div>
                                    <?php
                                    $facebook_rx_fb_user_info_id = isset($fb_user_info[0]["id"]) ? $fb_user_info[0]["id"] : 0;
                                    $facebook_rx_fb_user_info_name = isset($fb_user_info[0]["name"]) ? $fb_user_info[0]["name"] : "";
                                    $facebook_rx_fb_user_info_access_token = isset($fb_user_info[0]["access_token"]) ? $fb_user_info[0]["access_token"] : "";
                                    ?>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="post_to_pages"><?php echo $this->lang->line('Post to pages'); ?>
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
                                        <label for="auto_reply_template"><?php echo $this->lang->line('Auto Reply Template'); ?></label>
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
                                <button class="btn btn-primary" submit_type="text_submit" id="submit_post"
                                        name="submit_post" type="button"><i
                                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaign") ?>
                                </button>
                                <a class="btn btn-light float-right" onclick='goBack("ultrapost/cta_post",0)'><i
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
                <div class="card-header border-bottom">
                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Preview'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="section-title text-info" style="margin: -30px 0 10px 0; font-weight: normal;">
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
                                    <span class="text-primary"><?php echo $this->lang->line('Now'); ?></span></div>
                            </div>
                        </li>
                    </ul>

                    <span class="preview_message"><br/></span>

                    <img src="<?php echo base_url('n_assets/img/placeholder.png'); ?>" class="preview_img"
                         alt="No Image Preview">
                    <div class="preLoader text-center" style="display: none;"></div>
                    <div class="preview_og_info clearfix">
                        <div class="preview_og_info_title inline-block"></div>
                        <div class="preview_og_info_desc inline-block">
                        </div>
                        <div class="preview_og_info_link inline-block pull-left">
                        </div>
                        <div class="button_container"><a
                                    class="cta-btn btn btn-sm btn-default float-right"><?php echo $this->lang->line('Message Page'); ?></a>
                        </div>
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

    .preview_og_info {
        border: 1px solid #ccc;
        box-shadow: 0 0 2px #ddd;
        -webkit-box-shadow: 0 0 2px #ddd;
        -moz-box-shadow: 0 0 2px #ddd;
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
        font-size: 10px;
    }

    .ms-choice span {
        padding-top: 2px !important;
    }

    .hidden {
        display: none;
    }

    .btn-default {
        background: #fff;
        border-color: #ccc;
        border-radius: 2px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        padding: 3px 5px;
        color: #555;
    }

    .btn-default:hover {
        background: #eee;
        border-color: #ccc;
        color: #555;
    }
</style>