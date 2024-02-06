<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Whatsapp'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[whatsapp.enabled]" id="whatsapp.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('whatsapp.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="whatsapp.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('whatsapp.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[whatsapp.free]" id="whatsapp.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('whatsapp.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="whatsapp.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('whatsapp.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("WhatsApp Bot Connected"); ?><br />
    </p>

    <fieldset>
        <label for="whatsapp.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="whatsapp.sliders.0.unit" name="data[whatsapp.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('whatsapp.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('whatsapp.sliders.0.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="whatsapp.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="whatsapp.sliders.0.max_val" name="data[whatsapp.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('whatsapp.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('whatsapp.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[whatsapp.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="whatsapp.sliders.0.config"><?php echo $get_plan('whatsapp.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

    <h5><?php echo $this->lang->line('Slider 2'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("WhatsApp Bot Subscribers limit"); ?><br />
    </p>

    <fieldset>
        <label for="whatsapp.sliders.1.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="whatsapp.sliders.1.unit" name="data[whatsapp.sliders.1.unit]"
                   class="form-control" value="<?php echo $get_plan('whatsapp.sliders.1.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('whatsapp.sliders.1.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="whatsapp.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="whatsapp.sliders.0.max_val" name="data[whatsapp.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('whatsapp.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('whatsapp.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[whatsapp.sliders.1.config]" style="height:200px !important;" class="form-control"
                  id="whatsapp.sliders.1.config"><?php echo $get_plan('whatsapp.sliders.1.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

    <h5><?php echo $this->lang->line('Slider 3'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("WhatsApp Bot Custom API"); ?><br />
    </p>

    <fieldset>
        <label for="whatsapp.sliders.2.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="whatsapp.sliders.2.unit" name="data[whatsapp.sliders.2.unit]"
                   class="form-control" value="<?php echo $get_plan('whatsapp.sliders.2.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('whatsapp.sliders.2.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="whatsapp.sliders.0.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="whatsapp.sliders.0.max_val" name="data[whatsapp.sliders.0.max_val]"
                   class="form-control" value="<?php echo $get_plan('whatsapp.sliders.0.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('whatsapp.sliders.0.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[whatsapp.sliders.2.config]" style="height:200px !important;" class="form-control"
                  id="whatsapp.sliders.2.config"><?php echo $get_plan('whatsapp.sliders.2.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>


</div>