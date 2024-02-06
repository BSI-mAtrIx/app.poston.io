<div class="card">
    <div class="card-header border-bottom">
        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Campaign Info"); ?></h4>
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
            </div>

            <div class="col-12 col-md-6">
                <label for="campaign_title"><?php echo $this->lang->line("Title"); ?></label>
                <fieldset class="form-group position-relative has-icon-left">
                    <input name="title" id="campaign_title"
                           value="<?php if ($post_action == 'edit' || $post_action == 'clone') echo $campaign_form_info['title']; ?>"
                           class="form-control" type="text" placeholder="<?php echo $this->lang->line("Title"); ?>">
                    <div class="form-control-position">
                        <i class="bx bx-text"></i>
                    </div>
                    <span class="text-danger"><?php echo form_error('title'); ?></span>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label><?php echo $this->lang->line('Rich Content'); ?></label>
                    <textarea class="form-control" name="rich_content"
                              id="rich_content_html_section"><?php if ($post_action == 'edit' || $post_action == 'clone') echo htmlspecialchars_decode($campaign_form_info['rich_content']); ?></textarea>
                    <?php if($content_generator){ ?>
                        <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="blog_section_writer" data-paste-universal=".note-editable" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
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
