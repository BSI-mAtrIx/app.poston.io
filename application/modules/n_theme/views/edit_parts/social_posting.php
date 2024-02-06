<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Social Posting'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[social_posting.enabled]" id="social_posting.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('social_posting.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="social_posting.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('social_posting.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[social_posting.free]" id="social_posting.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('social_posting.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="social_posting.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('social_posting.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Comboposter Blogger Account Import"); ?><br />
        <?php echo $this->lang->line("Comboposter Linkedin Account Import"); ?><br />
        <?php echo $this->lang->line("Comboposter Pinterest Account Import"); ?><br />
        <?php echo $this->lang->line("Comboposter Reddit Account Import"); ?><br />
        <?php echo $this->lang->line("Comboposter Wordpress Account Import"); ?><br />
        <?php echo $this->lang->line("Comboposter Youtube Account Import"); ?><br />
        <?php echo $this->lang->line("Social Poster - Account Import : Medium"); ?><br />
        <?php echo $this->lang->line("Social Poster - Account Import : WordPress (Self hosted)"); ?><br />
    </p>

    <fieldset>
        <label for="social_posting.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="social_posting.sliders.0.unit" name="data[social_posting.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('social_posting.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('social_posting.sliders.0.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="social_posting.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="social_posting.sliders.0.max_val" name="data[social_posting.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('social_posting.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('social_posting.sliders.0.max_val'); ?></span>
    </fieldset>


    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[social_posting.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="social_posting.sliders.0.config"><?php echo $get_plan('social_posting.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

    <h5><?php echo $this->lang->line('Slider 2'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Auto Feed - WordPress Feed Post"); ?><br />
        <?php echo $this->lang->line("Auto Feed - YouTube Video Post"); ?><br />
        <?php echo $this->lang->line("Comboposter HTML Post"); ?><br />
        <?php echo $this->lang->line("Comboposter Image Post"); ?><br />
        <?php echo $this->lang->line("Comboposter Link Post"); ?><br />
        <?php echo $this->lang->line("Comboposter Text Post"); ?><br />
        <?php echo $this->lang->line("Comboposter Video Post"); ?><br />
        <?php echo $this->lang->line("Instagram Posting : Image/Video Post"); ?><br />
        <?php echo $this->lang->line("RSS Auto Posting"); ?><br />
    </p>

    <fieldset>
        <label for="social_posting.sliders.1.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="social_posting.sliders.1.unit" name="data[social_posting.sliders.1.unit]"
                   class="form-control" value="<?php echo $get_plan('social_posting.sliders.1.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('social_posting.sliders.1.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="social_posting.sliders.1.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="social_posting.sliders.1.max_val" name="data[social_posting.sliders.1.max_val]"
                   class="form-control" value="<?php echo $get_plan('social_posting.sliders.1.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('social_posting.sliders.1.max_val'); ?></span>
    </fieldset>


    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[social_posting.sliders.1.config]" style="height:200px !important;" class="form-control"
                  id="social_posting.sliders.1.config"><?php echo $get_plan('social_posting.sliders.1.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>


</div>