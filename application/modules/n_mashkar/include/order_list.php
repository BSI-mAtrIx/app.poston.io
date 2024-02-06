<div class="modal fade" id="mashkor_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $this->lang->line('Mashkor Details'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                        class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <form id="mashkor_modal_form">
                    <div class="row">
                        <div class="col-12" id="mashkor_type">
                            <div class="alert border-info mb-2" role="alert" id="mashkor_type_1" style="display: none">
                                <div class="d-flex align-items-center">
                                    <span><?php echo $this->lang->line('CASH COD'); ?></span>
                                </div>
                            </div>
                            <div class="alert border-info mb-2" role="alert" id="mashkor_type_2" style="display: none">
                                <div class="d-flex align-items-center">
                                    <span><?php echo $this->lang->line('CARD COD'); ?></span>
                                </div>
                            </div>
                            <div class="alert border-info mb-2" role="alert" id="mashkor_type_3" style="display: none">
                                <div class="d-flex align-items-center">
                                    <span><?php echo $this->lang->line('CARD COD'); ?></span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="mashkor_type" id="mashkor_type" value="">
                        <input type="hidden" name="post_cart_id" id="post_cart_id" value="">
                        
                        <div class="col-12">
                            <fieldset class="form-group">
                                <label for="customer_name"><?php echo $this->lang->line('Customer name'); ?></label>
                                <input type="text" class="form-control" name="customer_name" id="customer_name" value="" />
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <fieldset class="form-group">
                                <label for="mobile_number"><?php echo $this->lang->line('Mobile number'); ?></label>
                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="" />
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="amount_to_collect"><?php echo $this->lang->line('Amount to collect'); ?></label>
                                <input type="text" class="form-control" name="amount_to_collect" id="amount_to_collect" value="" />
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="vendor_order_id"><?php echo $this->lang->line('Vendor Order ID'); ?></label>
                                <input type="text" class="form-control" name="vendor_order_id" id="vendor_order_id" value="" />
                            </fieldset>
                        </div>

                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="latitude"><?php echo $this->lang->line('latitude'); ?></label>
                                <input type="text" class="form-control" name="latitude" id="latitude" value="" />
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="longitude"><?php echo $this->lang->line('longitude'); ?></label>
                                <input type="text" class="form-control" name="longitude" id="longitude" value="" />
                            </fieldset>
                        </div>

                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="landmark"><?php echo $this->lang->line('landmark'); ?></label>
                                <input type="text" class="form-control" name="landmark" id="landmark" value="" />
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="area"><?php echo $this->lang->line('area'); ?></label>
                                <input type="text" class="form-control" name="area" id="area" value="" />
                            </fieldset>
                        </div>

                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="block"><?php echo $this->lang->line('block'); ?></label>
                                <input type="text" class="form-control" name="block" id="block" value="" />
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="street"><?php echo $this->lang->line('street'); ?></label>
                                <input type="text" class="form-control" name="street" id="street" value="" />
                            </fieldset>
                        </div>

                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="building"><?php echo $this->lang->line('building'); ?></label>
                                <input type="text" class="form-control" name="building" id="building" value="" />
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="room_number"><?php echo $this->lang->line('room number'); ?></label>
                                <input type="text" class="form-control" name="room_number" id="room_number" value="" />
                            </fieldset>
                        </div>

                    </div>
                </form>



            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" id="mashkor_create_order" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                        class="align-middle ml-25"><?php echo $this->lang->line("Create order in Mashkor"); ?></span></button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i
                        class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH.'modules/n_mashkar/include/order_list_js.php'); ?>