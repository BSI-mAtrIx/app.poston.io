<div class="col-6 border-1 border-primary radius">
    <h2><?php echo $this->lang->line('Ecommerce'); ?> </h2>

    <div class="row mt-2">
        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[ecommerce.enabled]" id="ecommerce.enabled" value="1"
                           class="custom-control-input" <?php if ($get_plan('ecommerce.enabled') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="ecommerce.enabled"></label>
                    <span><?php echo $this->lang->line('Enabled'); ?></span>
                    <span class="text-danger"><?php echo form_error('ecommerce.enabled'); ?></span>
                </label>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label class="custom-switch">
                    <input type="checkbox" name="data[ecommerce.free]" id="ecommerce.free" value="1"
                           class="custom-control-input" <?php if ($get_plan('ecommerce.free') == 1) echo 'checked'; ?>>
                    <label class="custom-control-label mr-1" for="ecommerce.free"></label>
                    <span><?php echo $this->lang->line('Set as free'); ?></span>
                    <span class="text-danger"><?php echo form_error('ecommerce.free'); ?></span>
                </label>
            </div>
        </div>
    </div>


    <h5><?php echo $this->lang->line('Slider 1'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("Messenger E-commerce"); ?><br />
        <?php echo $this->lang->line("WooCommerce Integration"); ?><br />
    </p>

    <fieldset>
        <label for="ecommerce.sliders.0.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="ecommerce.sliders.0.unit" name="data[ecommerce.sliders.0.unit]"
                   class="form-control" value="<?php echo $get_plan('ecommerce.sliders.0.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('ecommerce.sliders.0.unit'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[ecommerce.sliders.0.config]" style="height:200px !important;" class="form-control"
                  id="ecommerce.sliders.0.config"><?php echo $get_plan('ecommerce.sliders.0.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>

    <h5><?php echo $this->lang->line('Slider 2'); ?></h5>

    <p>
        <strong><?php echo $this->lang->line("This settings apply to"); ?>:</strong> <br />
        <?php echo $this->lang->line("E-commerce Digital Product"); ?><br />
        <?php echo $this->lang->line("Ecommerce Products Limit"); ?><br />
    </p>

    <fieldset>
        <label for="ecommerce.sliders.1.unit"><?php echo $this->lang->line('Slider unit (default 1)'); ?></label>
        <div class="input-group">
            <input type="number" id="ecommerce.sliders.1.unit" name="data[ecommerce.sliders.1.unit]"
                   class="form-control" value="<?php echo $get_plan('ecommerce.sliders.1.unit'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('ecommerce.sliders.1.unit'); ?></span>
    </fieldset>

    <fieldset>
        <label for="ecommerce.sliders.1.max_val"><?php echo $this->lang->line('Max Value for select'); ?></label>
        <div class="input-group">
            <input type="number" id="ecommerce.sliders.1.max_val" name="data[ecommerce.sliders.1.max_val]"
                   class="form-control" value="<?php echo $get_plan('ecommerce.sliders.1.max_val'); ?>">
        </div>
        <span class="text-danger"><?php echo form_error('ecommerce.sliders.1.max_val'); ?></span>
    </fieldset>

    <div class="form-group">
        <label><?php echo $this->lang->line("Dynamic Configuration"); ?> *</label><br/>
        <textarea name="data[ecommerce.sliders.1.config]" style="height:200px !important;" class="form-control"
                  id="ecommerce.sliders.1.config"><?php echo $get_plan('ecommerce.sliders.1.config'); ?></textarea>
        <span class="text-danger"><?php echo form_error('Dynamic Configuration'); ?></span>
    </div>


</div>