<style>
    .row-actions{display:none;}
    tr:hover .row-actions{display:block;}
</style>
<?php
    $include_datatable = 0;
    $include_select2 = 1;
    $include_datetimepicker = 1;
?>

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>price/coupon_list"><?php echo $this->lang->line('Dynamic Price Plan Configuration'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<form action="<?php echo base_url('price/coupon_save/'.$id_coupon); ?>" id="plugin_form" method="POST">
<div class="section-body">


            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $this->lang->line("Dynamic Price Coupons"); ?></h5>
                </div>
                <div class="card-body">
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">


                        <fieldset>
                            <label for="coupon_code"><?php echo $this->lang->line('Coupon code'); ?></label>
                            <div class="input-group">
                                <input type="text" id="coupon_code" name="coupon_code"
                                       class="form-control" value="<?php echo (!empty($cinfo['coupon_code']) ? $cinfo['coupon_code'] : '');?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('coupon_code'); ?></span>
                        </fieldset>

                        <div class="row">
                            <div class="col-6">
                                <fieldset>
                                    <label for="date_active"><?php echo $this->lang->line('Start date (optional)'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="date_active" name="date_active"
                                               class="form-control" value="<?php echo (!empty($cinfo['date_active']) ? $cinfo['date_active'] : '');?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('date_active'); ?></span>
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <fieldset>
                                    <label for="date_expire"><?php echo $this->lang->line('End date (optional)'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="date_expire" name="date_expire"
                                               class="form-control" value="<?php echo (!empty($cinfo['date_expire']) ? $cinfo['date_expire'] : '');?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('date_expire'); ?></span>
                                </fieldset>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <fieldset>
                                    <label for="value"><?php echo $this->lang->line('Value coupon'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="value" name="value"
                                               class="form-control" value="<?php echo (!empty($cinfo['value']) ? $cinfo['value'] : '');?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('value'); ?></span>
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="value_type"><?php echo $this->lang->line('Coupon type'); ?></label>

                                    <?php
                                    $coupon_types = array(
                                            'fixed' => 'Fixed package discount',
                                            'percentage' => 'Percentage discount',
                                    );

                                    echo form_dropdown('value_type', $coupon_types, (!empty($cinfo['value_type']) ? $cinfo['value_type'] : 'fixed'), ['id' => 'value_type', 'class' => 'form-control select2', 'style' => 'width:100%']); ?>
                                </div>
                            </div>

                            <div class="col-6">
                                <fieldset>
                                    <label for="use_count"><?php echo $this->lang->line('Limit use'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="use_count" name="use_count"
                                               class="form-control" value="<?php echo (!empty($cinfo['use_count']) ? $cinfo['use_count'] : '');?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('use_count'); ?></span>
                                </fieldset>
                            </div>

                            <div class="col-6">
                                <fieldset>
                                    <label for="used_count"><?php echo $this->lang->line('Used count'); ?></label>
                                    <div class="input-group">
                                        <input type="text" id="used_count" name="used_count"
                                               class="form-control" value="<?php echo (!empty($cinfo['used_count']) ? $cinfo['used_count'] : 0);?>">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('used_count'); ?></span>
                                </fieldset>
                            </div>
                        </div>


                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="active"> <?php echo $this->lang->line('Coupon active'); ?></label><br>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="active" id="active" value="1"
                                           class="custom-control-input" <?php if(!empty($cinfo['active']) AND $cinfo['active'] == 1){ echo 'checked'; } ?>>
                                    <label class="custom-control-label mr-1" for="active"></label>
                                    <span><?php echo $this->lang->line('active'); ?></span>
                                    <span class="text-danger"><?php echo form_error('active'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-6 d-none">
                            <div class="form-group">
                                <label for="package_restriction"><?php echo $this->lang->line('Package restriction'); ?></label>

                                <?php
                                $coupon_types = array(
                                        '' => '',
                                    'fixed' => 'test dynamic'
                                );

                                echo form_dropdown('package_restriction', $coupon_types, (!empty($cinfo['config']['package_restriction']) ? $cinfo['config']['package_restriction'] : ''), ['id' => 'package_restriction', 'class' => 'form-control select2', 'style' => 'width:100%']); ?>
                            </div>
                        </div>


                        <div class="col-6 <?php if(!empty($cinfo['id'])){echo 'd-none';} ?>">
                            <fieldset>
                                <label for="generate_count"><?php echo $this->lang->line('How many codes generate? (random coupon codes)'); ?></label>
                                <div class="input-group">
                                    <input type="text" id="generate_count" name="generate_count"
                                           class="form-control" value="1">
                                </div>
                                <span class="text-danger"><?php echo form_error('generate_count'); ?></span>
                            </fieldset>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-primary"><?php echo $this->lang->line('SAVE');?></button>
                    </div>




                </div>
            </div>
</div>
</form>