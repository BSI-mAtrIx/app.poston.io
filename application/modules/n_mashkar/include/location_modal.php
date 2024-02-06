<div class="n_modal mfp-hide" id="Mashkor_Modal_Location">
    <div>
        <h4><?php echo $this->lang->line("Mashkor Delivery Details"); ?></h4>
<div class="modal-body" id="mashkor_delivery_body">
    <input type="hidden" id="lat" name="lat">
    <input type="hidden" id="lng" name="lng">


    <div class="row gutter-sm">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="mash_landmark"><?php echo $this->lang->line('Landmark'); ?></label>
                <input type="text" class="form-control form-control-md" name="landmark" id="mash_landmark" value="" required="">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="mash_block"><?php echo $this->lang->line('Block'); ?></label>
                <input type="text" class="form-control form-control-md" name="block" id="mash_block" value="" required="">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="mash_building"><?php echo $this->lang->line('Building'); ?></label>
                <input type="text" class="form-control form-control-md" name="building" id="mash_building" value="">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="mash_room_number"><?php echo $this->lang->line('Room number'); ?></label>
                <input type="text" class="form-control form-control-md" name="room_number" id="mash_room_number" value="">
            </div>
        </div>
    </div>




    <div id="map" style="height: 400px; width: 100%;"></div>

</div>
<a type="button" data-close="0"
        class="btn btn-primary btn-block no_radius p-3 m-1 save_mashkor_details"><?php echo $this->lang->line("Save location"); ?> </a>
</div>
<button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close save_mashkor_details"><span>×</span></button>
</div>
