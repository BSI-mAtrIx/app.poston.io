<div class="col-6 border-1 border-primary radius">
        <h2><?php echo $this->lang->line('Content Generator'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[content_generator.enabled]" id="content_generator.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('content_generator.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="content_generator.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('content_generator.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[content_generator.free]" id="content_generator.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('content_generator.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="content_generator.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('content_generator.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


        <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

        <p>
            <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
            >><?php echo $this->lang->line("Content Generator Characters (not used dissapear)"); ?><<<br />
            <?php echo $this->lang->line("AI Reply with Custom Library OpenAI"); ?><br />
            <?php echo $this->lang->line("Credits is another section"); ?><br />
        </p>

        <fieldset>
            <label for="content_generator.slider"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
            <div class="input-group">
                <input type="number" id="content_generator.sliders.0.unit" name="data[content_generator.sliders.0.unit]"
                       class="form-control" value="<?php echo $get_plan('content_generator.sliders.0.unit'); ?>">
            </div>
            <span class="text-danger"><?php echo form_error('content_generator.slider'); ?></span>
        </fieldset>

    <fieldset>
        <label for="content_generator.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="content_generator.sliders.0.max_val" name="data[content_generator.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('content_generator.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('content_generator.sliders.0.max_val'); ?></span>
    </fieldset>


    <div class="form-group">
            <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
            <textarea name="data[content_generator.sliders.0.config]" style="height:200px !important;" class="form-control"
                      id="content_generator.sliders.0.config"><?php echo $get_plan('content_generator.sliders.0.config'); ?></textarea>
            <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
        </div>



    </div>