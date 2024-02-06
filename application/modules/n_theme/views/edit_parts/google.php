<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Google'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[google.enabled]" id="google.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('google.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="google.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('google.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[google.free]" id="google.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('google.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="google.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('google.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Google My Business: Account Import"); ?><br />
    </p>

    <fieldset>
        <label for="google.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="google.sliders.0.unit" name="data[google.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('google.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('google.sliders.0.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="google.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="google.sliders.0.max_val" name="data[google.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('google.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('google.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[google.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="google.sliders.0.config"><?php echo $get_plan('google.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

    <h5><?php echo $this->lang->line('Slider 2'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Google My Business: Answer To Questions"); ?><br />
        <?php echo $this->lang->line("Google My Business: Media Upload To Locations"); ?><br />
        <?php echo $this->lang->line("Google My Business: Post To Locations"); ?><br />
        <?php echo $this->lang->line("Google My Business: Reply To Reviews"); ?><br />
        <?php echo $this->lang->line("Google My Business: RSS Auto Posting"); ?><br />
    </p>

    <fieldset>
        <label for="google.sliders.1.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="google.sliders.1.unit" name="data[google.sliders.1.unit]"
                   class="form-control" value="<?php echo $get_plan('google.sliders.1.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('google.sliders.1.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="google.sliders.1.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="google.sliders.0.max_val" name="data[google.sliders.1.max_val]"
                   class="form-control" value="<?php echo $get_plan('google.sliders.1.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('google.sliders.1.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[google.sliders.1.config]" style="height:200px !important;" class="form-control"
                  id="google.sliders.1.config"><?php echo $get_plan('google.sliders.1.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>


</div>