<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Facebook'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[facebook.enabled]" id="facebook.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('facebook.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="facebook.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('facebook.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[facebook.free]" id="facebook.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('facebook.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="facebook.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('facebook.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Facebook Pages"); ?><br />
    </p>

    <fieldset>
        <label for="facebook.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="facebook.sliders.0.unit" name="data[facebook.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('facebook.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('facebook.sliders.0.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="facebook.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="facebook.sliders.0.max_val" name="data[facebook.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('facebook.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('facebook.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[facebook.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="facebook.sliders.0.config"><?php echo $get_plan('facebook.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

    <h5><?php echo $this->lang->line('Slider 2'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Facebook Posting : Live Streaming Campaigns"); ?><br />
        <?php echo $this->lang->line("Facebook Live Streaming - Crossposting/Auto Share/Comment"); ?><br />
    </p>

    <fieldset>
        <label for="facebook.sliders.1.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="facebook.sliders.1.unit" name="data[facebook.sliders.1.unit]"
                   class="form-control" value="<?php echo $get_plan('facebook.sliders.1.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('facebook.sliders.1.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="facebook.sliders.1.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="facebook.sliders.0.max_val" name="data[facebook.sliders.1.max_val]"
                   class="form-control" value="<?php echo $get_plan('facebook.sliders.1.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('facebook.sliders.1.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[facebook.sliders.1.config]" style="height:200px !important;" class="form-control"
                  id="facebook.sliders.1.config"><?php echo $get_plan('facebook.sliders.1.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

    <h5><?php echo $this->lang->line('Slider 3'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Facebook Posting : Text/Image/Link/Video Post"); ?><br />
        <?php echo $this->lang->line("Facebook Posting : Carousel/Slider Post"); ?><br />
        <?php echo $this->lang->line("Facebook Posting : CTA Post"); ?><br />
    </p>

    <fieldset>
        <label for="facebook.sliders.2.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="facebook.sliders.2.unit" name="data[facebook.sliders.2.unit]"
                   class="form-control" value="<?php echo $get_plan('facebook.sliders.2.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('facebook.sliders.2.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="facebook.sliders.2.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="facebook.sliders.0.max_val" name="data[facebook.sliders.2.max_val]"
                   class="form-control" value="<?php echo $get_plan('facebook.sliders.2.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('facebook.sliders.2.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[facebook.sliders.2.config]" style="height:200px !important;" class="form-control"
                  id="facebook.sliders.2.config"><?php echo $get_plan('facebook.sliders.2.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

</div>