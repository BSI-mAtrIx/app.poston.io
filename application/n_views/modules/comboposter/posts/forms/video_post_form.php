<div class="card">
    <div class="card-header" style="border-bottom: 0;padding-bottom:0 !important;">
        <h4><?php echo $this->lang->line("Campaign Info"); ?></h4>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if ($post_action == 'edit' || $post_action == 'clone'): ?>
                <input type="hidden" name="table_id" value="<?php echo $campaign_form_info['id']; ?>">
            <?php endif ?>
            <div class="col-12 col-md-6">
                <label for="campaign_name"><?php echo $this->lang->line('Campaign Name'); ?></label>
                <fieldset class="form-group position-relative has-icon-left">
                    <input name="campaign_name" id="campaign_name"
                           value="<?php if ($post_action == 'edit' || $post_action == 'clone') echo $campaign_form_info['campaign_name']; ?>"
                           class="form-control" type="text"
                           placeholder="<?php echo $this->lang->line('Campaign Name'); ?>">
                    <div class="form-control-position">
                        <i class="bx bxs-compass"></i>
                    </div>
                    <span class="text-danger"><?php echo form_error('campaign_name'); ?></span>
                </fieldset>

                <!--
					<div class="form-group">
					    <label><?php echo $this->lang->line("Privacy Type (Youtube)"); ?> </label>
						
						<?php
                $privacy_type = array(
                    '0' => $this->lang->line("Please Select"),
                    'public' => $this->lang->line("Public"),
                    'private' => $this->lang->line("Private"),
                    'unlisted' => $this->lang->line("Unlisted"),
                );

                if ($post_action == 'add') {
                    $default_value = '0';
                } else if ($post_action == 'edit' || $post_action == 'clone') {
                    $default_value = $campaign_form_info['privacy_type'];
                }
                echo form_dropdown('privacy_type', $privacy_type, $default_value, 'class="select2 form-control" id="privacy_type"');
                ?>
					</div>
				-->

                <div class="form-group">
                    <label for="video_url"><?php echo $this->lang->line('Video URL'); ?></label>
                    <fieldset class="form-group position-relative has-icon-left">
                        <input type="input" class="form-control" name="video_url" id="video_url"
                               value="<?php if ($post_action == 'edit' || $post_action == 'clone') echo $campaign_form_info['video_url']; ?>"
                               placeholder="<?php echo $this->lang->line('Video URL'); ?>">
                        <div class="form-control-position">
                            <i class="bx bx-link"></i>
                        </div>
                    </fieldset>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang->line('Upload video'); ?>
                        <a href="#" data-placement="top" data-toggle="popover"
                           data-content="<?php echo $this->lang->line("Maximum video upload limit for Twitter is 15MB and Twitter doesn't support video URL, You need to upload video for Twitter.") . ' ' . $this->lang->line("Allowed files are .mp4,.mov,.avi,.wmv,.mpg,.flv"); ?>"><i
                                    class='bx bx-info-circle'></i>
                        </a>
                    </label>
                    <div id="upload_video" class="pointer"><?php echo $this->lang->line('Upload'); ?></div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <!-- <label><?php echo $this->lang->line("Title (Facebook, Youtube)"); ?> </label> -->
                    <label for="campaign_title"><?php echo $this->lang->line("Title (Facebook)"); ?> </label>
                    <fieldset class="form-group position-relative has-icon-left">
                        <input class="form-control" name="title" id="campaign_title" type="input"
                               value="<?php if ($post_action == 'edit' || $post_action == 'clone') echo $campaign_form_info['title']; ?>"
                               placeholder="<?php echo $this->lang->line('Title (Facebook, Youtube)'); ?>">
                        <div class="form-control-position">
                            <i class="bx bx-text"></i>
                        </div>
                    </fieldset>
                </div>

                <div class="form-group">
                    <label for="video_url_thumbnail"><?php echo $this->lang->line('Video Thumbnail URL (Facebook)'); ?></label>
                    <fieldset class="form-group position-relative has-icon-left">
                        <input type="input" class="form-control" name="video_url_thumbnail" id="video_url_thumbnail"
                               value="<?php if ($post_action == 'edit' || $post_action == 'clone') echo $campaign_form_info['thumbnail_url']; ?>"
                               placeholder="<?php echo $this->lang->line('Video Thumbnail URL (Facebook)'); ?>">
                        <div class="form-control-position">
                            <i class="bx bx-link"></i>
                        </div>
                    </fieldset>
                </div>

                <div class="form-group">
                    <label><?php echo $this->lang->line('Upload video thumbnail'); ?></label>
                    <div id="upload_video_thumbnail" class="pointer"><?php echo $this->lang->line('Upload'); ?></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <!-- <label><?php echo $this->lang->line('Message (Facebook, Twitter, Youtube)'); ?></label> -->
                    <label><?php echo $this->lang->line('Message (Facebook, Twitter)'); ?></label>
                    <textarea class="form-control"
                              placeholder="<?php echo $this->lang->line('Message (Facebook, Twitter, Youtube)'); ?>"
                              name="message" id="message" rows="11"
                              placeholder="<?php echo $this->lang->line('Type your message here...'); ?>"
                              style="height: 137px !important;"><?php if ($post_action == 'edit' || $post_action == 'clone') echo $campaign_form_info['message']; ?></textarea>
                    <?php if($content_generator){ ?>
                        <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="post_desc_caption" data-paste-universal="#message" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <fieldset>
                        <p class="label_cust"><?php echo $this->lang->line("Posting Time") ?> <a href="#"
                                                                                                 data-placement="top"
                                                                                                 data-toggle="popover"
                                                                                                 data-trigger="focus"
                                                                                                 title="<?php echo $this->lang->line("Posting Time") ?>"
                                                                                                 data-content="<?php echo $this->lang->line("If you schedule a campaign, system will automatically process this campaign at mentioned time and time zone. Schduled campaign may take upto 1 hour longer than your schedule time depending on server's processing.") ?>"><i
                                        class='bx bx-info-circle'></i> </a></p>
                        <div class="checkbox">
                            <input type="checkbox" name="schedule_type" id="schedule_type" value="now"
                                   class="checkbox-input" <?php if ($post_action == 'add' || (($post_action == 'edit' || $post_action == 'clone') && $campaign_form_info['schedule_type'] == 'now')) echo "checked"; ?>>
                            <label for="schedule_type"><?php echo $this->lang->line('Post Now'); ?></label>
                        </div>
                        <span class="text-danger"><?php echo form_error('schedule_type'); ?></span>
                    </fieldset>
                </div>
            </div>

            <div class="col-12">
                <div class="row">

                    <div class="schedule_block_item col-12 col-md-6" style="display: none;">
                        <label for="schedule_time"><?php echo $this->lang->line('Schedule time'); ?> <span
                                    class="text-danger">*</span></label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input name="schedule_time" id="schedule_time"
                                   value="<?php if ($post_action == 'edit' || $post_action == 'clone') echo $campaign_form_info['schedule_time']; ?>"
                                   class="form-control datepicker_x" type="text"
                                   placeholder="<?php echo $this->lang->line('Schedule time'); ?>">
                            <div class="form-control-position">
                                <i class="bx bx-time"></i>
                            </div>
                            <span class="text-danger"><?php echo form_error('schedule_time'); ?></span>
                        </fieldset>
                    </div>

                    <div class="schedule_block_item col-12 col-md-6" style="display: none;">
                        <label for="time_zone"><?php echo $this->lang->line('Time zone'); ?> <span
                                    class="text-danger">*</span></label>
                        <div class="form-group">
                            <?php
                            $time_zone[''] = $this->lang->line('Please Select');

                            if ($post_action == 'edit' || $post_action == 'clone') {
                                $default = $campaign_form_info['schedule_timezone'];
                            } else {
                                $default = $this->config->item('time_zone');
                            }

                            echo form_dropdown('time_zone', $time_zone, $default, ' class="form-control select2" id="time_zone" required');
                            ?>
                        </div>
                    </div>


                    <?php if ($post_action == 'add'
                        || ((isset($campaign_form_info['parent_campaign_id']) && $campaign_form_info['parent_campaign_id'] == "0")
                            || ($campaign_form_info['parent_campaign_id'] == null && $post_action == 'clone'))): ?>

                        <div class="schedule_block_item col-12 col-md-6" style="display: none;">
                            <label for="repeat_times"><?php echo $this->lang->line('repost this post'); ?></label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="number" name="repeat_times" id="repeat_times" class="form-control"
                                           placeholder="<?php echo $this->lang->line('repost this post'); ?>"
                                           aria-describedby="basic-addon2"
                                           value="<?php if ($post_action == 'edit' || $post_action == 'clone') {
                                               echo $campaign_form_info['repeat_times'];
                                           } else {
                                               echo 0;
                                           } ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                              id="basic-addon2"><?php echo $this->lang->line('Times'); ?></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="schedule_block_item col-12 col-md-6" style="display: none;">
                            <div class="schedule_block_item">
                                <label for="time_interval"><?php echo $this->lang->line('time interval'); ?></label>
                                <div class="form-group">
                                    <?php
                                    $time_interval[''] = $this->lang->line('Please Select Periodic Time Schedule');

                                    $current_value = "";
                                    if ($post_action == 'edit' || $post_action == 'clone') {
                                        $current_value = $campaign_form_info['time_interval'] != 0 ? $campaign_form_info['time_interval'] : "";
                                    }

                                    echo form_dropdown('time_interval', $time_interval, $current_value, ' class="form-control select2" id="time_interval" required style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                        </div>

                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>


    </div>
</div>          
