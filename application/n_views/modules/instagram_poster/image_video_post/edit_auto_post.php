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
$image_upload_limit = 1;
if ($this->config->item('facebook_poster_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('facebook_poster_image_upload_limit');

$video_upload_limit = 100;
if ($this->config->item('facebook_poster_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');

$page_ids = isset($all_data[0]['page_ids']) ? explode(',', $all_data[0]['page_ids']) : [];
$group_ids = isset($all_data[0]['group_ids']) ? explode(',', $all_data[0]['group_ids']) : [];
$ig_page_ids = isset($all_data[0]['ig_page_ids']) ? explode(',', $all_data[0]['ig_page_ids']) : [];
?>
    <link rel="stylesheet"
          href="<?php echo base_url('n_assets/css/system/instagram/posting_style.css?ver=' . $n_config['theme_version']); ?>">

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("instagram_poster"); ?>"><?php echo $this->lang->line("Multimedia Post"); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="#" enctype="multipart/form-data" id="edit_poster_form" method="post">


        <div class="section-body">
            <div class="row justify-content-md-center">
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 collef">
                    <div class="card main_card">
                        <div class="card-header pb-0 p-1">
                            <h4 class="w-100 m-0 pr-0">
                                <span class="float-left"><i
                                            class="bx bx-share"></i> <?php echo $this->lang->line("Publish"); ?></span>
                                <input type="text" placeholder="<?php echo $this->lang->line('Search'); ?>..."
                                       class="form-control float-right" id="publish_item_search"
                                       onkeyup="search_in_class(this,'publish_item')">
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-justified w-100" role="tablist">
                                <li class="nav-item">
                                    <a id="p_pages" class="nav-link active" data-toggle="tab" href="#pc_pages"
                                       role="tab" aria-selected="false"><?php echo $this->lang->line('Pages') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a id="p_groups" class="nav-link" data-toggle="tab" href="#pc_groups" role="tab"
                                       aria-selected="true"><?php echo $this->lang->line("Groups") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a id="p_instagram" class="nav-link" data-toggle="tab" href="#pc_instagram"
                                       role="tab"
                                       aria-selected="false"><?php echo $this->lang->line("Instagram"); ?></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="pc_pages" aria-labelledby="home-tab" role="tabpanel">
                                    <?php if (!empty($fb_page_info)) : ?>
                                        <h6 class="mb-2 d-flex justify-content-between">
                                            <div class="custom-control custom-checkbox mt-1 ml-1 d-inline">
                                                <input type="checkbox" class="custom-control-input"
                                                       name="check_all_pages" id="check_all_pages" value="">
                                                <label class="mb-0 custom-control-label" for="check_all_pages">
                                                    <?php echo $this->lang->line('Pages'); ?></label>
                                            </div>
                                            <select class="form-control select2 d-inline ml-4" id="auto_reply_template"
                                                    name="auto_reply_template">
                                                <?php
                                                echo "<option value='0'>{$this->lang->line('Select Auto Reply Template')}</option>";
                                                foreach ($auto_reply_template as $key => $val) {
                                                    $id = $val['id'];
                                                    $group_name = $val['ultrapost_campaign_name'];
                                                    $checked = $all_data[0]['ultrapost_auto_reply_table_id'] == $id ? 'selected' : '';
                                                    echo "<option value='{$id}' " . $checked . ">{$group_name}</option>";
                                                }
                                                ?>
                                            </select>
                                        </h6>
                                        <ul class="list-unstyled list-unstyled-border publish_item_group nicescroll">
                                            <?php
                                            foreach ($fb_page_info as $key => $val) {
                                                $id = $val['id'];
                                                $checked = in_array($val['id'], $page_ids) ? 'checked' : '';
                                                echo '
								<li class="media px-1 pt-2 mx-0 border-0 publish_item">
	                                <div class="custom-control custom-checkbox mt-1"> 
	                                    <input type="checkbox" class="custom-control-input post_to_pages" name="post_to_pages[]" ' . $checked . ' id="post_to_pages-' . $val['id'] . '" value="' . $val['id'] . '">
	                                    <label class="mb-3 custom-control-label" for="post_to_pages-' . $val['id'] . '"></label>
	                                </div>
		                            <img class="mr-3 rounded-circle mt-1" width="35" src="' . $val['page_profile'] . '" onerror="this.onerror=null;this.src=\'' . base_url('assets/img/avatar/avatar-1.png') . '\'" alt="avatar">
	                                <label for="post_to_pages-' . $val['id'] . '">
		                                 <div class="media-body" >
		                                     <h6 class="page_list_media_title media-title ">' . $val['page_name'] . '</h6>
		                                	 <div class="text-small text-muted">' . $val['username'] . '</div>
		                                 </div>
	                                </label>
	                            </li>';
                                            }
                                            ?>
                                        </ul>
                                    <?php endif; ?>

                                </div>
                                <div class="tab-pane" id="pc_groups" aria-labelledby="home-tab" role="tabpanel">
                                    <?php if (!empty($fb_group_info) && $facebook_poster_group != '0' && $this->is_group_posting_exist) : ?>
                                        <h6 class="mb-2">
                                            <div class="custom-control custom-checkbox mt-1 ml-1 d-inline">
                                                <input type="checkbox" class="custom-control-input"
                                                       name="check_all_pages" id="check_all_groups" value="">
                                                <label class="mb-0 custom-control-label" for="check_all_groups">
                                                    <?php echo $this->lang->line('Groups'); ?></label>
                                            </div>
                                        </h6>
                                        <ul class="list-unstyled list-unstyled-border publish_item_group nicescroll">
                                            <?php
                                            foreach ($fb_group_info as $key => $val) {
                                                $id = $val['id'];
                                                $checked = in_array($val['id'], $group_ids) ? 'checked' : '';
                                                echo '
								<li class="media px-1 pt-2 pb-1 mx-0 my-1 border-0 publish_item">
	                                <div class="custom-control custom-checkbox mt-1"> 
	                                    <input type="checkbox" class="custom-control-input post_to_groups" name="post_to_groups[]" ' . $checked . ' id="post_to_groups-' . $val['id'] . '" value="' . $val['id'] . '">
	                                    <label class="mb-3 custom-control-label" for="post_to_groups-' . $val['id'] . '"></label>
	                                </div>
		                            <img class="mr-3 rounded-circle mt-1" width="35" src="' . $val['group_profile'] . '" onerror="this.onerror=null;this.src=\'' . base_url('assets/img/avatar/avatar-1.png') . '\'" alt="avatar">
	                                <label for="post_to_groups-' . $val['id'] . '">
		                                 <div class="media-body" >
		                                     <h6 class="page_list_media_title media-title ">' . $val['group_name'] . '</h6>
		                                	 <div class="text-small text-muted">' . $val['group_id'] . '</div>
		                                 </div>
	                                </label>
	                            </li>';
                                            }
                                            ?>
                                        </ul>
                                    <?php endif; ?>

                                </div>
                                <div class="tab-pane" id="pc_instagram" aria-labelledby="home-tab" role="tabpanel">
                                    <?php if (!empty($account_list) && ($this->session->userdata('user_type') == 'Admin' || in_array(296, $this->module_access))) : ?>
                                        <div id="post_to_instagram">
                                            <h6 class="mb-2 d-flex justify-content-between">
                                                <div class="custom-control custom-checkbox mt-1 ml-1 d-inline">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="check_all_accounts" id="check_all_accounts" value="">
                                                    <label class="mb-0 custom-control-label" for="check_all_accounts">
                                                        <?php echo $this->lang->line('Instagram'); ?></label>
                                                </div>
                                                <select class="form-control select2 d-inline ml-4"
                                                        id="instagram_reply_template_id"
                                                        name="instagram_reply_template_id">
                                                    <?php
                                                    echo "<option value='0'>{$this->lang->line('Select Auto Reply Template')}</option>";
                                                    foreach ($instagram_reply_template as $key => $val) {
                                                        $id = $val['id'];
                                                        $group_name = $val['auto_reply_campaign_name'];
                                                        $checked = $all_data[0]['instagram_reply_template_id'] == $id ? 'selected' : '';
                                                        echo "<option value='{$id}' " . $checked . ">{$group_name}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </h6>
                                            <ul class="list-unstyled list-unstyled-border publish_item_group nicescroll">
                                                <?php
                                                foreach ($account_list as $key => $val) {
                                                    $id = $val['id'];
                                                    $checked = in_array($val['id'], $ig_page_ids) ? 'checked' : '';
                                                    echo '
									<li class="media px-1 pt-2 pb-1 mx-0 my-1 border-0 publish_item">
		                                <div class="custom-control custom-checkbox mt-1"> 
		                                    <input type="checkbox" class="custom-control-input post_to_accounts" name="post_to_accounts[]" ' . $checked . ' id="post_to_accounts-' . $val['id'] . '" value="' . $val['id'] . '">
		                                    <label class="mb-3 custom-control-label" for="post_to_accounts-' . $val['id'] . '"></label>
		                                </div>
			                            <img class="mr-3 rounded-circle mt-1" width="35" src="' . $val['page_profile'] . '" onerror="this.onerror=null;this.src=\'' . base_url('assets/img/avatar/avatar-1.png') . '\'" alt="avatar">
		                                <label for="post_to_accounts-' . $val['id'] . '">
			                                 <div class="media-body" >
			                                     <h6 class="page_list_media_title media-title ">' . $val['insta_username'] . '</h6>
			                                	 <div class="text-small text-muted">' . $val['page_name'] . '</div>
			                                 </div>
		                                </label>
		                            </li>';
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-5 colmid">
                    <div class="card main_card">
                        <div class="card-body p-2">
                            <ul class="nav nav-tabs nav-justified w-100" role="tablist">
                                <li class="nav-item">
                                    <a id="text_post" class="nav-link post_type active" data-toggle="tab"
                                       href="#textPost" role="tab" aria-selected="false"><i
                                                class="bx bx-text"></i> <?php echo $this->lang->line('Text') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a id="link_post" class="nav-link post_type" data-toggle="tab" href="#linkPost"
                                       role="tab" aria-selected="true"><i
                                                class="bx bx-anchor"></i> <?php echo $this->lang->line("Link") ?></a>
                                </li>
                                <li class="nav-item">
                                    <a id="image_post" class="nav-link post_type" data-toggle="tab" href="#imagePost"
                                       role="tab" aria-selected="false"><i
                                                class="bx bx-image"></i> <?php echo $this->lang->line("Image/Carousel"); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="video_post" class="nav-link post_type" data-toggle="tab" href="#videoPost"
                                       role="tab" aria-selected="false"><i
                                                class="bx bx-video"></i> <?php echo $this->lang->line("Video"); ?></a>
                                </li>
                            </ul>
                            <!-- tab body started -->
                            <div class="tab-content" id="post_tab_content">
                                <?php include(APPPATH . "modules/instagram_poster/views/image_video_post/upload.php"); ?>
                                <input type="hidden" value="<?php echo $all_data[0]["id"]; ?>" name="id" id="hidden_id">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Campaign Name'); ?></label>
                                    <input type="input" class="form-control" name="campaign_name" id="campaign_name"
                                           value="<?php if (set_value('campaign_name')) echo set_value('campaign_name'); else {
                                               if (isset($all_data[0]['campaign_name'])) echo $all_data[0]['campaign_name'];
                                           } ?>">
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Caption"); ?></label>
                                    <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("caption") ?>"
                                       data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i
                                                class='bx bx-info-circle'></i> </a>
                                    <textarea class="form-control" name="message"
                                              id="message"><?php if (isset($all_data[0]['message'])) echo $all_data[0]['message']; ?></textarea>
                                    <?php if($content_generator){ ?>
                                        <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal=".emojionearea-editor" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                                    <?php } ?>
                                </div>

                                <div id="link_block">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Paste link'); ?></label>
                                        <input class="form-control" name="link" id="link" type="text"
                                               value="<?php if (set_value('link')) echo set_value('link'); else {
                                                   if (isset($all_data[0]['link'])) echo $all_data[0]['link'];
                                               } ?>">
                                    </div>

                                    <div class="form-group hidden">
                                        <label><?php echo $this->lang->line('Link caption'); ?></label>
                                        <input class="form-control" name="link_caption" id="link_caption" type="text">
                                    </div>
                                    <div class="form-group hidden">
                                        <label><?php echo $this->lang->line('Link description'); ?></label>
                                        <textarea class="form-control" name="link_description"
                                                  id="link_description"></textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="schedule_type" value="later" id="schedule_type">


                                <div class="row <?php if (isset($is_all_posted) && $is_all_posted == 1) echo 'd-none'; ?>">

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('Schedule time'); ?></label>
                                            <input placeholder="Time" name="schedule_time" id="schedule_time"
                                                   class="form-control datepicker_x" type="text"
                                                   value="<?php if (set_value('schedule_time')) echo set_value('schedule_time'); else {
                                                       if (isset($all_data[0]['schedule_time'])) echo $all_data[0]['schedule_time'];
                                                   } ?>"/>
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('Time zone'); ?></label>
                                            <?php
                                            $time_zone[''] = $this->lang->line('Please Select');
                                            echo form_dropdown('time_zone', $time_zone, $all_data[0]['time_zone'], ' class="form-control select2 w-100" id="time_zone" required');
                                            ?>
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <label class="input-group-addon"><?php echo $this->lang->line('repost this post'); ?></label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="repeat_times"
                                                       id="repeat_times" aria-describedby="basic-addon2"
                                                       value="<?php if (isset($all_data[0]['repeat_times'])) echo $all_data[0]['repeat_times']; ?>">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><?php echo $this->lang->line('Times'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('time interval'); ?></label>
                                                <?php
                                                $time_interval[''] = $this->lang->line('Please Select Periodic Time Schedule');
                                                echo form_dropdown('time_interval', $time_interval, $all_data[0]['time_interval'], ' class="form-control select2 w-100" id="time_interval" required');
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="clearfix"></div>

                                <div class="card-footer padding-0">
                                    <input type="hidden" name="submit_post_hidden" id="submit_post_hidden"
                                           value="<?php echo $all_data[0]["post_type"]; ?>">
                                    <button class="btn btn-primary " submit_type="text_submit" id="submit_post"
                                            name="submit_post" type="button"><i
                                                class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Submit"); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include(APPPATH . "n_views/modules/instagram_poster/image_video_post/preview.php"); ?>
            </div>
        </div>

    </form>

<?php include(APPPATH . "n_views/modules/instagram_poster/image_video_post/image_editor.php"); ?>

<?php include(APPPATH . "n_views/modules/instagram_poster/image_video_post/upload_requirement.php"); ?>