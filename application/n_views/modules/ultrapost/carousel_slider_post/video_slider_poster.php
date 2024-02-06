<?php
$content_generator = file_exists(APPPATH.'modules/n_generator/include/modal_message_universal.php');
//TODO: add preview FB
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

    .padding-20 {
        padding: 20px
    }

    .slide_content_block_d_none, .video_content_block_d_none {
        display: none;
    }

    .card-body #tab_contents {
        border: solid 1px #dee2e6;
        border-top: 0;
        padding: 30px 20px 30px 20px;
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
                                href='<?php echo base_url("ultrapost/carousel_slider_post"); ?>'><?php echo $this->lang->line("Carousel/Slider Posts"); ?></a>
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
            <div class="card main_card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs justify-content-center mb-0 pb-0" role="tablist"
                        style="width:100% !important;">
                        <li class="nav-item">
                            <a id="slider_post" class="nav-link post_type active" data-toggle="tab" href="#" role="tab"
                               aria-selected="false">
                                <i class="bx bx-image align-middle"></i>
                                <?php echo $this->lang->line('Carousel') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="video_post" class="nav-link post_type" data-toggle="tab" href="#" role="tab"
                               aria-selected="true">
                                <i class="bx bx-video align-middle"></i>
                                <?php echo $this->lang->line("Video Slide Show") ?>
                            </a>
                        </li>

                    </ul>
                    <div id="tab_contents">
                        <form action="#" enctype="multipart/form-data" id="video_slider_form" method="post">
                            <!-- common for carousel and video slider -->
                            <input type="hidden" name="auto_reply_template" id="auto_reply_template" value="0">
                            <div class="row" id="common_block">
                                <div class="col-12 col-md-6">

                                    <label for="campaign_name"><?php echo $this->lang->line('Campaign Name'); ?> <span
                                                class="text-danger">*</span></label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input name="campaign_name" id="campaign_name"
                                               class="form-control" type="text"
                                               placeholder="<?php echo $this->lang->line('Campaign Name'); ?>">
                                        <div class="form-control-position">
                                            <i class="bx bxs-compass"></i>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('campaign_name'); ?></span>
                                    </fieldset>

                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Post to pages'); ?> <span
                                                    class="text-danger">*</span></label>
                                        <select multiple class="form-control select2" id="post_to_pages"
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

                                <div class="col-12">
                                    <div class="form-group" style="display: none;">
                                        <?php
                                        $facebook_rx_fb_user_info_id = isset($fb_user_info[0]["id"]) ? $fb_user_info[0]["id"] : 0;
                                        $facebook_rx_fb_user_info_name = isset($fb_user_info[0]["name"]) ? $fb_user_info[0]["name"] : "";
                                        $facebook_rx_fb_user_info_access_token = isset($fb_user_info[0]["access_token"]) ? $fb_user_info[0]["access_token"] : "";
                                        ?>
                                        <label><?php echo $this->lang->line('Post to timeline/pages'); ?></label><br/>
                                        <input name="post_to_profile"
                                               value="<?php echo $facebook_rx_fb_user_info_id; ?>"
                                               id="post_to_profile_yes"
                                               type="radio"> <?php echo $this->lang->line('Post to timeline'); ?>
                                        (<?php echo $facebook_rx_fb_user_info_name; ?>) &nbsp;&nbsp;
                                        <input name="post_to_profile" value="No" id="post_to_profile_no" type="radio"
                                               checked> <?php echo $this->lang->line('No, don\'t post'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- End common for carousel and video slider -->

                            <!-- carousel block -->
                            <div class="row" id="slider_block">
                                <div class="col-12">
                                    <div class="card card-primary" id="slider_content">
                                        <div class="card-header"><h4><?php echo $this->lang->line('Carousel'); ?></h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label for="slider_link"><?php echo $this->lang->line('Slider Link'); ?>
                                                        <span class="text-danger">*</span></label>
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="slider_link"
                                                               id="slider_link"
                                                               placeholder="<?php echo $this->lang->line('Type link here...'); ?>">
                                                        <div class="form-control-position">
                                                            <i class="bx bx-link"></i>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="slider_message"><?php echo $this->lang->line('Message'); ?></label>
                                                        <a href="#" data-placement="right" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("message") ?>"
                                                           data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                    class='bx bx-info-circle'></i> </a>
                                                        <textarea class="form-control" name="slider_message"
                                                                  id="slider_message"
                                                                  placeholder="<?php echo $this->lang->line('Type your status here...'); ?>"></textarea>
                                                        <?php if($content_generator){ ?>
                                                            <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal=".emojionearea-editor" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-secondary">
                                                <div id="slider_content_1">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 1:'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_title_1"><?php echo $this->lang->line("Title"); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_title_1" id="post_title_1"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-text"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_link_1"><?php echo $this->lang->line('Action Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_1" id="post_link_1"
                                                                               placeholder="<?php echo $this->lang->line('Type link here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-link"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="post_description_1"><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_1"
                                                                                  id="post_description_1"
                                                                                  placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_image_link_1"><?php echo $this->lang->line('Image Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_image_link_1"
                                                                               id="post_image_link_1"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_1"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="slide_content_block_d_none" id="slider_conten_2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 2:'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <label for="post_title_2"><?php echo $this->lang->line("Title"); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_title_2" id="post_title_2"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-text"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_link_2"><?php echo $this->lang->line('Action Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_2" id="post_link_2"
                                                                               placeholder="<?php echo $this->lang->line('Type link here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-link"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="post_description_2"><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_2"
                                                                                  id="post_description_2"
                                                                                  placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_image_link_2"><?php echo $this->lang->line('Image Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_image_link_2"
                                                                               id="post_image_link_2"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_2"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="slide_content_block_d_none" id="slider_conten_3">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 3:'); ?></h4>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_title_3"><?php echo $this->lang->line("Title"); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_title_3" id="post_title_3"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-text"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_link_3"><?php echo $this->lang->line('Action Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_3" id="post_link_3"
                                                                               placeholder="<?php echo $this->lang->line('Type link here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-link"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="post_description_3"><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_3"
                                                                                  id="post_description_3"
                                                                                  placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_image_link_3"><?php echo $this->lang->line('Image Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_image_link_3"
                                                                               id="post_image_link_3"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_3"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="slide_content_block_d_none" id="slider_conten_4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 4:'); ?></h4>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_title_4"><?php echo $this->lang->line("Title"); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_title_4" id="post_title_4"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-text"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label for="post_link_4"><?php echo $this->lang->line('Action Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_4" id="post_link_4"
                                                                               placeholder="<?php echo $this->lang->line('Type link here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-link"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="post_description_4"><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_4"
                                                                                  id="post_description_4"
                                                                                  placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <label for="post_image_link_4"><?php echo $this->lang->line('Image Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_image_link_4"
                                                                               id="post_image_link_4"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_4"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="slide_content_block_d_none" id="slider_conten_5">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 5:'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <label for="post_title_5"><?php echo $this->lang->line("Title"); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_title_5" id="post_title_5"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type your post title here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-text"></i>
                                                                        </div>
                                                                </div>
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <label for="post_link_5"><?php echo $this->lang->line('Action Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_5" id="post_link_5"
                                                                               placeholder="<?php echo $this->lang->line('Type link here...'); ?>">
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-link"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="post_description_5"><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_5"
                                                                                  id="post_description_5"
                                                                                  placeholder="<?php echo $this->lang->line('Type your description here...'); ?>"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <label for="post_image_link_5"><?php echo $this->lang->line('Image Link'); ?>
                                                                        <span class="text-danger">*</span></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="post_image_link_5"
                                                                               id="post_image_link_5"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_5"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="clearfix">
                                                <p class="btn btn-outline-primary float-right mt-2" id="add_more"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add More Content'); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div> <!-- card card-primary end -->
                                </div>
                            </div>
                            <!-- end of carousel block -->

                            <!-- Video block -->
                            <div class="row" id="video_block">
                                <div class="col-12">
                                    <div class="card card-primary" id="video_content">
                                        <div class="card-header">
                                            <h4><?php echo $this->lang->line('Video-Slide'); ?></h4></div>
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="video_message"><?php echo $this->lang->line('Message'); ?></label>
                                                        <a href="#" data-placement="right" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("message") ?>"
                                                           data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                    class='bx bx-info-circle'></i> </a>
                                                        <textarea class="form-control" name="video_message"
                                                                  id="video_message"
                                                                  placeholder="<?php echo $this->lang->line('Type your message here...'); ?>"></textarea>
                                                        <?php if($content_generator){ ?>
                                                            <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal=".emojionearea-editor" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="video_image_duration"><?php echo $this->lang->line('Image Duration (second)'); ?></label>
                                                        <select class="select2 form-control" id="video_image_duration"
                                                                name="video_image_duration" style="width:100%;">
                                                            <option value="1"><?php echo $this->lang->line('1 sec'); ?></option>
                                                            <option value="2"><?php echo $this->lang->line('2 sec'); ?></option>
                                                            <option value="3"><?php echo $this->lang->line('3 sec'); ?></option>
                                                            <option value="4"><?php echo $this->lang->line('4 sec'); ?></option>
                                                            <option value="5"><?php echo $this->lang->line('5 sec'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="video_image_transition_duration"><?php echo $this->lang->line('Transition Duration (second)'); ?></label>
                                                        <select class="select2 form-control"
                                                                id="video_image_transition_duration"
                                                                name="video_image_transition_duration"
                                                                style="width:100%;">
                                                            <option value="1"><?php echo $this->lang->line('1 sec'); ?></option>
                                                            <option value="2"><?php echo $this->lang->line('2 sec'); ?></option>
                                                            <option value="3"><?php echo $this->lang->line('3 sec'); ?></option>
                                                            <option value="4"><?php echo $this->lang->line('4 sec'); ?></option>
                                                            <option value="5"><?php echo $this->lang->line('5 sec'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-secondary">
                                                <div id="video_image_div_1">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 1 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">

                                                                    <label for="video_image_link_1"><?php echo $this->lang->line('Image Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="video_image_link_1"
                                                                               id="video_image_link_1"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload Image'); ?></label>
                                                                        <div id="video_images_1"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="video_content_block_d_none" id="video_image_div_2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 2 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="video_image_link_2"><?php echo $this->lang->line('Image Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="video_image_link_2"
                                                                               id="video_image_link_2"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload Image'); ?></label>
                                                                        <div id="video_images_2"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="video_content_block_d_none" id="video_image_div_3">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 3 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="video_image_link_3"><?php echo $this->lang->line('Image Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="video_image_link_3"
                                                                               id="video_image_link_3"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload Image'); ?></label>
                                                                        <div id="video_images_3"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="video_content_block_d_none" id="video_image_div_4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 4 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="video_image_link_4"><?php echo $this->lang->line('Image Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="video_image_link_4"
                                                                               id="video_image_link_4"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload Image'); ?></label>
                                                                        <div id="video_images_4"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="video_content_block_d_none" id="video_image_div_5">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 5 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="video_image_link_5"><?php echo $this->lang->line('Image Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="video_image_link_5"
                                                                               id="video_image_link_5"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload Image'); ?></label>
                                                                        <div id="video_images_5"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="video_content_block_d_none" id="video_image_div_6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 6 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="video_image_link_6"><?php echo $this->lang->line('Image Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="video_image_link_6"
                                                                               id="video_image_link_6"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload Image'); ?></label>
                                                                        <div id="video_images_6"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="video_content_block_d_none" id="video_image_div_7">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 7 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <label for="video_image_link_7"><?php echo $this->lang->line('Image Link'); ?></label>
                                                                    <fieldset
                                                                            class="form-group position-relative has-icon-left">
                                                                        <input name="video_image_link_7"
                                                                               id="video_image_link_7"
                                                                               class="form-control" type="text"
                                                                               placeholder="<?php echo $this->lang->line('Type image link here...'); ?>"/>
                                                                        <div class="form-control-position">
                                                                            <i class="bx bx-image"></i>
                                                                        </div>
                                                                    </fieldset>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload Image'); ?></label>
                                                                        <div id="video_images_7"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="clearfix">
                                                    <p class="btn btn-outline-primary float-right mt-2"
                                                       id="add_more_video_image"><i
                                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add More Image'); ?>
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of video block -->

                            <!-- schedule block -->
                            <div class="row" id="posting_schedule_block">
                                <div class="col-6 padding-20">
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
                            <!-- end of schedule block -->

                            <div class="clearfix"></div>

                            <input type="hidden" name="content_counter" id="content_counter"/>
                            <input type="hidden" name="video_content_counter" id="video_content_counter"/>
                            <input type="hidden" name="content_type" id="content_type"/>
                        </form>

                        <div class="card-footer p-0">
                            <button class="btn btn-primary" submit_type="slider_submit" id="submit_post" type="button">
                                <i class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaign") ?>
                            </button>
                            <a class="btn btn-light float-right" onclick='goBack("ultrapost/carousel_slider_post",0)'><i
                                        class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="slider_response_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Auto Post Campaign Status'); ?></h4>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="alert text-center" id="slider_response_modal_content">

                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css" media="screen">

    .padding-20 {
        padding: 20px;
    }

    .ms-choice span {
        padding-top: 2px !important;
    }

</style>