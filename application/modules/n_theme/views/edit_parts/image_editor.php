<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Image Editors'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[image_editor.enabled]" id="image_editor.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('image_editor.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="image_editor.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('image_editor.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[image_editor.free]" id="image_editor.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('image_editor.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="image_editor.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('image_editor.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Image Editor (Pixie)"); ?><br />
        <?php echo $this->lang->line("Image Editor N2"); ?><br />
        <?php echo $this->lang->line("Image Editor N3"); ?><br />
    </p>

    <fieldset>
        <label for="image_editor.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="image_editor.sliders.0.unit" name="data[image_editor.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('image_editor.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('image_editor.sliders.0.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="image_editor.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="image_editor.sliders.0.max_val" name="data[image_editor.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('image_editor.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('image_editor.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[image_editor.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="image_editor.sliders.0.config"><?php echo $get_plan('image_editor.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

</div>