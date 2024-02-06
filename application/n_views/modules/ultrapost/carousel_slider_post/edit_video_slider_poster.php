<?php
$include_upload = 1;  //upload_js
$include_datatable = 0; //datatables
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

$content_generator = file_exists(APPPATH.'modules/n_generator/include/modal_message_universal.php');
?>

<?php
$carousel_content_json = $all_data[0]["carousel_content"];
$carousel_content_araay = json_decode($carousel_content_json, true);
if (!is_array($carousel_content_araay)) $carousel_content_araay = [];
$carousel_content_araay_len = count($carousel_content_araay);

$desplay_1 = "";
$desplay_2 = "";
$desplay_3 = "";
$desplay_4 = "";
$desplay_5 = "";

if ($carousel_content_araay_len == '0') $carousel_content_araay_len = '1';

if ($carousel_content_araay_len == "1") {
    $desplay_2 = "display: none";
    $desplay_3 = "display: none";
    $desplay_4 = "display: none";
    $desplay_5 = "display: none";
}
if ($carousel_content_araay_len == "2") {
    $desplay_3 = "display: none";
    $desplay_4 = "display: none";
    $desplay_5 = "display: none";
}

if ($carousel_content_araay_len == "3") {
    $desplay_4 = "display: none";
    $desplay_5 = "display: none";
}
if ($carousel_content_araay_len == "4") {
    $desplay_5 = "display: none";
}


$slider_image_duration = $all_data[0]["slider_image_duration"];
$right_slider_image_duration = $slider_image_duration / 1000;

$slider_transition_duration = $all_data[0]["slider_transition_duration"];
$right_slider_transition_duration = $slider_transition_duration / 1000;

$slider_images_json = $all_data[0]["slider_images"];
$slider_images_array = json_decode($slider_images_json, true);
if (!is_array($slider_images_array)) $slider_images_array = [];
$slider_images_array_len = count($slider_images_array);

$desplay_video_1 = "";
$desplay_video_2 = "";
$desplay_video_3 = "";
$desplay_video_4 = "";
$desplay_video_5 = "";
$desplay_video_6 = "";
$desplay_video_7 = "";

if ($slider_images_array_len == '0') $slider_images_array_len = '1';

if ($slider_images_array_len == "1") {
    $desplay_video_2 = "display: none";
    $desplay_video_3 = "display: none";
    $desplay_video_4 = "display: none";
    $desplay_video_5 = "display: none";
    $desplay_video_6 = "display: none";
    $desplay_video_7 = "display: none";
}

if ($slider_images_array_len == "2") {
    $desplay_video_3 = "display: none";
    $desplay_video_4 = "display: none";
    $desplay_video_5 = "display: none";
    $desplay_video_6 = "display: none";
    $desplay_video_7 = "display: none";
}

if ($slider_images_array_len == "3") {
    $desplay_video_4 = "display: none";
    $desplay_video_5 = "display: none";
    $desplay_video_6 = "display: none";
    $desplay_video_7 = "display: none";
}

if ($slider_images_array_len == "4") {
    $desplay_video_5 = "display: none";
    $desplay_video_6 = "display: none";
    $desplay_video_7 = "display: none";
}

if ($slider_images_array_len == "5") {
    $desplay_video_6 = "display: none";
    $desplay_video_7 = "display: none";
}
if ($slider_images_array_len == "6") {
    $desplay_video_7 = "display: none";
}

$image_upload_limit = 1;
if ($this->config->item('facebook_poster_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('facebook_poster_image_upload_limit');

$video_upload_limit = 10;
if ($this->config->item('facebook_poster_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');

?>


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

<?php if ($is_all_posted == 1): ?>
    <style type="text/css">
        .d_none_page {
            display: none;
        }

        .d_none_template {
            display: none;
        }

        .d_none_schedule {
            display: none;
        }

    </style>
<?php endif; ?>


<!-- ============================== New view =============================================== -->


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

                    <ul class="nav nav-tabs" role="tablist" style="width:100% !important;margin-bottom:-7px;">
                        <li class="nav-item">
                            <a id="slider_post" class="nav-link post_type" data-toggle="tab" href="#" role="tab"
                               aria-selected="false"><i
                                        class="bx bxs-file-image"></i> <?php echo $this->lang->line('Carousel') ?></a>
                        </li>
                        <li class="nav-item">
                            <a id="video_post" class="nav-link post_type" data-toggle="tab" href="#" role="tab"
                               aria-selected="true"><i
                                        class="bx bxs-camera"></i> <?php echo $this->lang->line("Video Slide Show") ?>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="card-body" style="padding-top:0 !important;">
                    <div id="tab_contents">
                        <form action="#" enctype="multipart/form-data" id="video_edit_slider_form" method="post">
                            <input type="hidden" value="<?php echo $all_data[0]["id"]; ?>" name="id">
                            <input type="hidden" value="<?php echo $all_data[0]["user_id"]; ?>" name="user_id">
                            <input type="hidden" value="<?php echo $all_data[0]["facebook_rx_fb_user_info_id"]; ?>"
                                   name="facebook_rx_fb_user_info_id">
                            <input type="hidden" name="auto_reply_template" id="auto_reply_template" value="0">

                            <!-- common for carousel and video slider -->
                            <div class="row" id="common_block">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('Campaign Name'); ?></label>
                                            <input class="form-control" name="campaign_name" id="campaign_name"
                                                   value="<?php if (set_value('campaign_name')) echo set_value('campaign_name'); else {
                                                       if (isset($all_data[0]['campaign_name'])) echo $all_data[0]['campaign_name'];
                                                   } ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- done -->
                                <div class="col-12 col-md-6 d_none_page">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Post to pages'); ?> <span
                                                    class="red">*</span></label>
                                        <select multiple class="form-control select2" id="post_to_pages"
                                                name="post_to_pages[]" style="width:100%;">
                                            <?php
                                            foreach ($fb_page_info as $key => $val) {
                                                $id = $val['id'];
                                                $page_name = $val['page_name'];

                                                $page_ids = explode(',', $all_data[0]['page_ids']);

                                                if (in_array($id, $page_ids))
                                                    echo "<option value='{$id}' selected>{$page_name}</option>";
                                                else
                                                    echo "<option value='{$id}'>{$page_name}</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- done -->
                                <div class="col-12" style="display: none;">
                                    <div class="form-group">
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
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('Slider Link'); ?> <span
                                                                    class="red">*</span></label>
                                                        <input type="text" class="form-control" name="slider_link"
                                                               id="slider_link"
                                                               value="<?php if (set_value('slider_link')) echo set_value('slider_link'); else {
                                                                   if (isset($all_data[0]['carousel_link'])) echo $all_data[0]['carousel_link'];
                                                               } ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('Message'); ?></label>
                                                        <a href="#" data-placement="right" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("message") ?>"
                                                           data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                    class='bx bx-info-circle'></i> </a>
                                                        <textarea class="form-control" name="slider_message"
                                                                  id="slider_message"><?php if (isset($all_data[0]['message'])) echo $all_data[0]['message']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-secondary">
                                                <div style="<?php echo $desplay_1; ?>" id="slider_content_1">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 1:'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Title'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_title_1" id="post_title_1"
                                                                               value="<?php if (set_value('post_title_1')) echo set_value('post_title_1'); else {
                                                                                   if (isset($carousel_content_araay[0]['name'])) echo $carousel_content_araay[0]['name'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Action Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_1" id="post_link_1"
                                                                               value="<?php if (set_value('post_link_1')) echo set_value('post_link_1'); else {
                                                                                   if (isset($carousel_content_araay[0]['link'])) echo $carousel_content_araay[0]['link'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_1"
                                                                                  id="post_description_1"><?php if (set_value('post_description_1')) echo set_value('post_description_1'); else {
                                                                                if (isset($carousel_content_araay[0]['description'])) echo $carousel_content_araay[0]['description'];
                                                                            } ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_image_link_1"
                                                                               id="post_image_link_1"
                                                                               value="<?php if (set_value('post_image_link_1')) echo set_value('post_image_link_1'); else {
                                                                                   if (isset($carousel_content_araay[0]['picture'])) echo $carousel_content_araay[0]['picture'];
                                                                               } ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_1"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="<?php echo $desplay_2; ?>" id="slider_conten_2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 2:'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Title'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_title_2" id="post_title_2"
                                                                               value="<?php if (set_value('post_title_2')) echo set_value('post_title_2'); else {
                                                                                   if (isset($carousel_content_araay[1]['name'])) echo $carousel_content_araay[1]['name'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Action Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_2" id="post_link_2"
                                                                               value="<?php if (set_value('post_link_2')) echo set_value('post_link_2'); else {
                                                                                   if (isset($carousel_content_araay[1]['link'])) echo $carousel_content_araay[1]['link'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_2"
                                                                                  id="post_description_2"><?php if (set_value('post_description_2')) echo set_value('post_description_2'); else {
                                                                                if (isset($carousel_content_araay[1]['description'])) echo $carousel_content_araay[1]['description'];
                                                                            } ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_image_link_2"
                                                                               id="post_image_link_2"
                                                                               value="<?php if (set_value('post_image_link_2')) echo set_value('post_image_link_2'); else {
                                                                                   if (isset($carousel_content_araay[1]['picture'])) echo $carousel_content_araay[1]['picture'];
                                                                               } ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_2"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="<?php echo $desplay_3; ?>" id="slider_conten_3">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 3:'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Title'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_title_3" id="post_title_3"
                                                                               value="<?php if (set_value('post_title_3')) echo set_value('post_title_3'); else {
                                                                                   if (isset($carousel_content_araay[2]['name'])) echo $carousel_content_araay[2]['name'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Action Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_3" id="post_link_3"
                                                                               value="<?php if (set_value('post_link_3')) echo set_value('post_link_3'); else {
                                                                                   if (isset($carousel_content_araay[2]['link'])) echo $carousel_content_araay[2]['link'];
                                                                               } ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_3"
                                                                                  id="post_description_3"><?php if (set_value('post_description_3')) echo set_value('post_description_3'); else {
                                                                                if (isset($carousel_content_araay[2]['description'])) echo $carousel_content_araay[2]['description'];
                                                                            } ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_image_link_3"
                                                                               id="post_image_link_3"
                                                                               value="<?php if (set_value('post_image_link_3')) echo set_value('post_image_link_3'); else {
                                                                                   if (isset($carousel_content_araay[2]['picture'])) echo $carousel_content_araay[2]['picture'];
                                                                               } ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_3"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="<?php echo $desplay_4; ?>" id="slider_conten_4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 4:'); ?></h4>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Title'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_title_4" id="post_title_4"
                                                                               value="<?php if (set_value('post_title_4')) echo set_value('post_title_4'); else {
                                                                                   if (isset($carousel_content_araay[3]['name'])) echo $carousel_content_araay[3]['name'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Action Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_4" id="post_link_4"
                                                                               value="<?php if (set_value('post_link_4')) echo set_value('post_link_4'); else {
                                                                                   if (isset($carousel_content_araay[3]['link'])) echo $carousel_content_araay[3]['link'];
                                                                               } ?>"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_4"
                                                                                  id="post_description_4"><?php if (set_value('post_description_4')) echo set_value('post_description_4'); else {
                                                                                if (isset($carousel_content_araay[3]['description'])) echo $carousel_content_araay[3]['description'];
                                                                            } ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_image_link_4"
                                                                               id="post_image_link_4"
                                                                               value="<?php if (set_value('post_image_link_4')) echo set_value('post_image_link_4'); else {
                                                                                   if (isset($carousel_content_araay[3]['picture'])) echo $carousel_content_araay[3]['picture'];
                                                                               } ?>"/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Upload image'); ?></label>
                                                                        <div id="post_image_4"><?php echo $this->lang->line('Upload'); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="<?php echo $desplay_5; ?>" id="slider_conten_5">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Slider Content 5:'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Title'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_title_5" id="post_title_5"
                                                                               value="<?php if (set_value('post_title_5')) echo set_value('post_title_5'); else {
                                                                                   if (isset($carousel_content_araay[4]['name'])) echo $carousel_content_araay[4]['name'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Action Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_link_5" id="post_link_5"
                                                                               value="<?php if (set_value('post_link_5')) echo set_value('post_link_5'); else {
                                                                                   if (isset($carousel_content_araay[4]['link'])) echo $carousel_content_araay[4]['link'];
                                                                               } ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Description'); ?></label>
                                                                        <textarea style="min-height:130px;"
                                                                                  class="form-control"
                                                                                  name="post_description_5"
                                                                                  id="post_description_5"><?php if (set_value('post_description_5')) echo set_value('post_description_5'); else {
                                                                                if (isset($carousel_content_araay[4]['description'])) echo $carousel_content_araay[4]['description'];
                                                                            } ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?>
                                                                            <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                               name="post_image_link_5"
                                                                               id="post_image_link_5"
                                                                               value="<?php if (set_value('post_image_link_5')) echo set_value('post_image_link_5'); else {
                                                                                   if (isset($carousel_content_araay[4]['picture'])) echo $carousel_content_araay[4]['picture'];
                                                                               } ?>"/>
                                                                    </div>
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
                                                        <label><?php echo $this->lang->line('Message'); ?></label>
                                                        <a href="#" data-placement="right" data-toggle="popover"
                                                           data-trigger="focus"
                                                           title="<?php echo $this->lang->line("message") ?>"
                                                           data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                                    class='bx bx-info-circle'></i> </a>
                                                        <textarea class="form-control" name="video_message"
                                                                  id="video_message"><?php if (isset($all_data[0]['message'])) echo $all_data[0]['message']; ?></textarea>
                                                        <?php if($content_generator){ ?>
                                                            <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal=".emojionearea-editor" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('Image Duration (second)'); ?></label>
                                                        <select class="form-control select2" id="video_image_duration"
                                                                name="video_image_duration" style="width:100%;">
                                                            <option value="1" <?php if ($right_slider_image_duration == "1") echo "selected"; ?>>
                                                                1 sec
                                                            </option>
                                                            <option value="2" <?php if ($right_slider_image_duration == "2") echo "selected"; ?>>
                                                                2 sec
                                                            </option>
                                                            <option value="3" <?php if ($right_slider_image_duration == "3") echo "selected"; ?>>
                                                                3 sec
                                                            </option>
                                                            <option value="4" <?php if ($right_slider_image_duration == "4") echo "selected"; ?>>
                                                                4 sec
                                                            </option>
                                                            <option value="5" <?php if ($right_slider_image_duration == "5") echo "selected"; ?>>
                                                                5 sec
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('Transition Duration (second)'); ?></label>
                                                        <select class="form-control select2"
                                                                id="video_image_transition_duration"
                                                                name="video_image_transition_duration"
                                                                style="width:100%;">
                                                            <option value="1" <?php if ($right_slider_transition_duration == "1") echo "selected"; ?>>
                                                                1 sec
                                                            </option>
                                                            <option value="2" <?php if ($right_slider_transition_duration == "2") echo "selected"; ?>>
                                                                2 sec
                                                            </option>
                                                            <option value="3" <?php if ($right_slider_transition_duration == "3") echo "selected"; ?>>
                                                                3 sec
                                                            </option>
                                                            <option value="4" <?php if ($right_slider_transition_duration == "4") echo "selected"; ?>>
                                                                4 sec
                                                            </option>
                                                            <option value="5" <?php if ($right_slider_transition_duration == "5") echo "selected"; ?>>
                                                                5 sec
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-secondary">
                                                <div style="<?php echo $desplay_video_1; ?> " id="video_image_div_1">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 1 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="video_image_link_1"
                                                                               id="video_image_link_1"
                                                                               value="<?php if (set_value('video_image_link_1')) echo set_value('video_image_link_1'); else {
                                                                                   if (isset($slider_images_array[0])) echo $slider_images_array[0];
                                                                               } ?>">
                                                                    </div>
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

                                                <div style="<?php echo $desplay_video_2; ?>" id="video_image_div_2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 2 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="video_image_link_2"
                                                                               id="video_image_link_2"
                                                                               value="<?php if (set_value('video_image_link_2')) echo set_value('video_image_link_2'); else {
                                                                                   if (isset($slider_images_array[1])) echo $slider_images_array[1];
                                                                               } ?>">
                                                                    </div>
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

                                                <div style="<?php echo $desplay_video_3; ?>" id="video_image_div_3">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 3 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="video_image_link_3"
                                                                               id="video_image_link_3"
                                                                               value="<?php if (set_value('video_image_link_3')) echo set_value('video_image_link_3'); else {
                                                                                   if (isset($slider_images_array[2])) echo $slider_images_array[2];
                                                                               } ?>">
                                                                    </div>
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

                                                <div style="<?php echo $desplay_video_4; ?>" id="video_image_div_4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 4 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="video_image_link_4"
                                                                               id="video_image_link_4"
                                                                               value="<?php if (set_value('video_image_link_4')) echo set_value('video_image_link_4'); else {
                                                                                   if (isset($slider_images_array[3])) echo $slider_images_array[3];
                                                                               } ?>">

                                                                    </div>
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

                                                <div style="<?php echo $desplay_video_5; ?>" id="video_image_div_5">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 5 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="video_image_link_5"
                                                                               id="video_image_link_5"
                                                                               value="<?php if (set_value('video_image_link_5')) echo set_value('video_image_link_5'); else {
                                                                                   if (isset($slider_images_array[4])) echo $slider_images_array[4];
                                                                               } ?>">
                                                                    </div>
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

                                                <div style="<?php echo $desplay_video_6; ?>" id="video_image_div_6">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 6 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="video_image_link_6"
                                                                               id="video_image_link_6"
                                                                               value="<?php if (set_value('video_image_link_6')) echo set_value('video_image_link_6'); else {
                                                                                   if (isset($slider_images_array[5])) echo $slider_images_array[5];
                                                                               } ?>">
                                                                    </div>
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

                                                <div style="<?php echo $desplay_video_7; ?>" id="video_image_div_7">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><?php echo $this->lang->line('Image Content 7 :'); ?></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label><?php echo $this->lang->line('Image Link'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="video_image_link_7"
                                                                               id="video_image_link_7"
                                                                               value="<?php if (set_value('video_image_link_7')) echo set_value('video_image_link_7'); else {
                                                                                   if (isset($slider_images_array[6])) echo $slider_images_array[6];
                                                                               } ?>">
                                                                    </div>
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
                            <div id="posting_schedule_block">
                                <input type="hidden" name="schedule_type" value="later" id="schedule_later" checked>
                            </div>

                            <div class="row d_none_schedule" style="margin-top: 30px;">
                                <div class="schedule_block_item col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Schedule time'); ?></label>
                                        <input placeholder="Time" name="schedule_time" id="schedule_time"
                                               class="form-control datepicker_x" type="text"
                                               value="<?php if (set_value('schedule_time')) echo set_value('schedule_time'); else {
                                                   if (isset($all_data[0]['schedule_time'])) echo $all_data[0]['schedule_time'];
                                               } ?>"/>
                                    </div>
                                </div>

                                <div class="schedule_block_item col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Time zone'); ?></label>
                                        <?php
                                        $time_zone[''] = 'Please Select';
                                        echo form_dropdown('time_zone', $time_zone, $all_data[0]['time_zone'], ' class="form-control select2" id="time_zone" required style="width:100%;"');
                                        ?>
                                    </div>
                                </div>

                                <div class=" schedule_block_item col-12 col-md-6">
                                    <div class="input-group">
                                        <label class="input-group-addon"><?php echo $this->lang->line('repost this post'); ?></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control"
                                                   value="<?php if (isset($all_data[0]['repeat_times'])) echo $all_data[0]['repeat_times']; ?>"
                                                   name="repeat_times" id="repeat_times"
                                                   aria-describedby="basic-addon2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><?php echo $this->lang->line('Times'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="schedule_block_item">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('time interval'); ?></label>
                                            <?php
                                            $time_interval[''] = $this->lang->line('Please Select Periodic Time Schedule');
                                            echo form_dropdown('time_interval', $time_interval, $all_data[0]['time_interval'], ' class="form-control select2" id="time_interval" required style="width:100%;"');
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
                                <i class="bx bx-edit"></i> <?php echo $this->lang->line("Update Campaign") ?> </button>
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
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h3 class="modal-title"><?php echo $this->lang->line('Update Campaign Status'); ?></h3>
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