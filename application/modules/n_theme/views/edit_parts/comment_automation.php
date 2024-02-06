<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Comment Automation'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[comment_automation.enabled]" id="comment_automation.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('comment_automation.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="comment_automation.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('comment_automation.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[comment_automation.free]" id="comment_automation.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('comment_automation.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="comment_automation.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('comment_automation.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Comment Automation : Auto Comment Campaign"); ?><br />
        <?php echo $this->lang->line("Comment Automation : Auto Reply Posts"); ?><br />
        <?php echo $this->lang->line("Comment Reply Enhancers : Bulk Comment Reply Campaign"); ?><br />
        <?php echo $this->lang->line("Comment Reply Enhancers : Comment & Bulk Tag Campaign"); ?><br />
        <?php echo $this->lang->line("Comment Reply Enhancers : Comment Hide/Delete and Reply with multimedia content"); ?><br />
        <?php echo $this->lang->line("Comment Reply Enhancers : Full Page Auto Reply"); ?><br />
        <?php echo $this->lang->line("Instagram Auto Comment Reply"); ?><br />
        <?php echo $this->lang->line("Social Poster - Account Import : WordPress (Self hosted)"); ?><br />
    </p>

    <fieldset>
        <label for="comment_automation.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="comment_automation.sliders.0.unit" name="data[comment_automation.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('comment_automation.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('comment_automation.sliders.0.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="comment_automation.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="comment_automation.sliders.0.max_val" name="data[comment_automation.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('comment_automation.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('comment_automation.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[comment_automation.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="comment_automation.sliders.0.config"><?php echo $get_plan('comment_automation.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>


</div>