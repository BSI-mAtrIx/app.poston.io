<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Website Builder'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[website_builder.enabled]" id="website_builder.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('website_builder.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="website_builder.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('website_builder.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[website_builder.free]" id="website_builder.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('website_builder.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="website_builder.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('website_builder.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Website Builder"); ?><br />
    </p>

    <fieldset>
        <label for="website_builder.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="website_builder.sliders.0.unit" name="data[website_builder.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('website_builder.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('website_builder.sliders.0.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="website_builder.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="website_builder.sliders.0.max_val" name="data[website_builder.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('website_builder.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('website_builder.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[website_builder.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="website_builder.sliders.0.config"><?php echo $get_plan('website_builder.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

</div>