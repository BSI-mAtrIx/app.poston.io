<?php
$include_select2 = 1;
$include_dropzone = 1;
$include_cropper = 1;
$include_datatable=1;

$get_conf =  function($value) use ($mash_conf){
    $nvalue = explode('.', $value);

    if(isset($nvalue[1])){
        if(isset($mash_conf[$nvalue[0]][$nvalue[1]])){
            if(isset($nvalue[2]) AND isset($mash_conf[$nvalue[0]][$nvalue[1]][$nvalue[2]])){
                if(isset($nvalue[3]) AND isset($mash_conf[$nvalue[0]][$nvalue[1]][$nvalue[2]][$nvalue[3]])){
                    return $mash_conf[$nvalue[0]][$nvalue[1]][$nvalue[2]][$nvalue[3]];
                }
                return $mash_conf[$nvalue[0]][$nvalue[1]][$nvalue[2]];
            }
            return $mash_conf[$nvalue[0]][$nvalue[1]];
        }
    }
};

if (!defined('NVX')) { ?>
    <section class="section section_custom d-none">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <div class="content-header row d-none">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
    $jodit = 1;
    $include_select2 = 1;
}
?>



<?php include(APPPATH . 'modules/n_wa/include/alert_message.php'); ?>


    <div class="section-body ntheme main">
        <div class="card" id="nodata">
            <div class="card-header">
                <h5 class="card-title"><?php echo $this->lang->line('Mashkor Integration'); ?></h5>
                <div class="heading-elements">

                </div>
            </div>
            <div class="card-body">
                <?php
                if(!empty($get_conf('config.branch_id'))){ ?>
                    <a href="#" class="btn btn-primary mb-2" id="test_mashkor"><?php echo $this->lang->line('Test API'); ?></a>
                <?php } ?>

                <form method="POST" action="<?php echo base_url('n_mashkar/integration/'.$n_store_id ); ?>">
                    <h4><?php echo $this->lang->line('API details'); ?></h4>
                    <fieldset class="form-group d-none">
                        <label for="auth_key"><?php echo $this->lang->line('Authorization key'); ?></label>
                        <input type="text" class="form-control" name="auth_key" id="auth_key" placeholder="<?php echo $this->lang->line('Authorization key'); ?>" value="<?php echo $get_conf('config.auth_key'); ?>" />
                        <span class="text-danger"><?php echo form_error('auth_key'); ?></span>
                    </fieldset>
                    <fieldset class="form-group d-none">
                        <label for="x_api_key"><?php echo $this->lang->line('x-api-key'); ?></label>
                        <input type="text" class="form-control" name="x_api_key" id="x_api_key" placeholder="<?php echo $this->lang->line('x-api-key'); ?>" value="<?php echo $get_conf('config.x_api_key'); ?>" />
                        <span class="text-danger"><?php echo form_error('x_api_key'); ?></span>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="branch_id"><?php echo $this->lang->line('Branch ID'); ?></label>
                        <input type="text" class="form-control" name="branch_id" id="branch_id" placeholder="<?php echo $this->lang->line('Branch ID'); ?>" value="<?php echo $get_conf('config.branch_id'); ?>" />
                        <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="google_api"><?php echo $this->lang->line('Google API Key Website restriction (Directions API, Maps Embed API)'); ?></label>
                        <input type="text" class="form-control" name="google_api" id="google_api" placeholder="<?php echo $this->lang->line('Google Maps API'); ?>" value="<?php echo $get_conf('config.google_api'); ?>" />
                        <span class="text-danger"><?php echo form_error('google_api'); ?></span>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="google_api_2"><?php echo $this->lang->line('Google API Key Server side (Directions API, Maps Embed API)'); ?></label>
                        <input type="text" class="form-control" name="google_api_2" id="google_api_2" placeholder="<?php echo $this->lang->line('Google Maps API'); ?>" value="<?php echo $get_conf('config.google_api_2'); ?>" />
                        <span class="text-danger"><?php echo form_error('google_api_2'); ?></span>
                    </fieldset>


                    <div class="form-group d-none">
                        <?php
                        $sandbox = $get_conf('config.sandbox');
                        ?>
                        <label class="custom-switch mt-2">
                            <input type="checkbox" name="sandbox" id="sandbox"
                                   value="on"
                                   class="custom-control-input" <?php if ($sandbox == 'on') echo 'checked'; ?>>
                            <label class="custom-control-label mr-1" for="sandbox"></label>
                            <span><?php echo $this->lang->line('Sandbox enabled'); ?></span>
                            <span class="text-danger"><?php echo form_error('sandbox'); ?></span>
                        </label>
                    </div>

                    <h4 class="d-none"><?php echo $this->lang->line('Pricing details in KD'); ?></h4>
                    <fieldset class="form-group d-none">
                        <label for="price_5"><?php echo $this->lang->line('0-5 km'); ?></label>
                        <input type="text" class="form-control" name="price_5" id="price_5" placeholder="<?php echo $this->lang->line('0-5 km'); ?>" value="<?php echo $get_conf('price.price_5'); ?>" />
                        <span class="text-danger"><?php echo form_error('price_5'); ?></span>
                    </fieldset>
                    <fieldset class="form-group d-none">
                        <label for="price_8"><?php echo $this->lang->line('5-8 km'); ?></label>
                        <input type="text" class="form-control" name="price_8" id="price_8" placeholder="<?php echo $this->lang->line('5-8 km'); ?>" value="<?php echo $get_conf('price.price_8'); ?>" />
                        <span class="text-danger"><?php echo form_error('price_8'); ?></span>
                    </fieldset>
                    <fieldset class="form-group d-none">
                        <label for="price_1km"><?php echo $this->lang->line('8+ km'); ?></label>
                        <input type="text" class="form-control" name="price_1km" id="price_1km" placeholder="<?php echo $this->lang->line('8+ km'); ?>" value="<?php echo $get_conf('price.price_1km'); ?>" />
                        <span class="text-danger"><?php echo form_error('price_1km'); ?></span>
                    </fieldset>

                    <h4><?php echo $this->lang->line('Pickup details'); ?></h4>
                    <fieldset class="form-group">
                        <label for="customer_name"><?php echo $this->lang->line('Pickup name'); ?></label>
                        <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="<?php echo $this->lang->line('Pickup name'); ?>" value="<?php echo $get_conf('pickup.customer_name'); ?>" />
                        <span class="text-danger"><?php echo form_error('customer_name'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="paci_number"><?php echo $this->lang->line('PACI number'); ?></label>
                        <input type="text" class="form-control" name="paci_number" id="paci_number" placeholder="<?php echo $this->lang->line('PACI number'); ?>" value="<?php echo $get_conf('pickup.paci_number'); ?>" />
                        <span class="text-danger"><?php echo form_error('paci_number'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="mobile_number"><?php echo $this->lang->line('Mobile Number'); ?></label>
                        <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="<?php echo $this->lang->line('Mobile Number'); ?>" value="<?php echo $get_conf('pickup.mobile_number'); ?>" />
                        <span class="text-danger"><?php echo form_error('mobile_number'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="latitude"><?php echo $this->lang->line('latitude'); ?></label>
                        <input type="text" class="form-control" name="latitude" id="latitude" placeholder="<?php echo $this->lang->line('latitude'); ?>" value="<?php echo $get_conf('pickup.latitude'); ?>" />
                        <span class="text-danger"><?php echo form_error('latitude'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="longitude"><?php echo $this->lang->line('longitude'); ?></label>
                        <input type="text" class="form-control" name="longitude" id="longitude" placeholder="<?php echo $this->lang->line('longitude'); ?>" value="<?php echo $get_conf('pickup.longitude'); ?>" />
                        <span class="text-danger"><?php echo form_error('longitude'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="area"><?php echo $this->lang->line('Pick up area'); ?></label>
                        <input type="text" class="form-control" name="area" id="area" placeholder="<?php echo $this->lang->line('Pick up area'); ?>" value="<?php echo $get_conf('pickup.area'); ?>" />
                        <span class="text-danger"><?php echo form_error('area'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="block"><?php echo $this->lang->line('Block'); ?></label>
                        <input type="text" class="form-control" name="block" id="block" placeholder="<?php echo $this->lang->line('Block'); ?>" value="<?php echo $get_conf('pickup.block'); ?>" />
                        <span class="text-danger"><?php echo form_error('block'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="street"><?php echo $this->lang->line('Street'); ?></label>
                        <input type="text" class="form-control" name="street" id="street" placeholder="<?php echo $this->lang->line('Street'); ?>" value="<?php echo $get_conf('pickup.street'); ?>" />
                        <span class="text-danger"><?php echo form_error('street'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="building"><?php echo $this->lang->line('Building (optional)'); ?></label>
                        <input type="text" class="form-control" name="building" id="building" placeholder="<?php echo $this->lang->line('Building (optional)'); ?>" value="<?php echo $get_conf('pickup.building'); ?>" />
                        <span class="text-danger"><?php echo form_error('building'); ?></span>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="landmark"><?php echo $this->lang->line('Landmark (optional)'); ?></label>
                        <input type="text" class="form-control" name="landmark" id="landmark" placeholder="<?php echo $this->lang->line('Landmark (optional)'); ?>" value="<?php echo $get_conf('pickup.landmark'); ?>" />
                        <span class="text-danger"><?php echo form_error('landmark'); ?></span>
                    </fieldset>

                    <fieldset class="form-group d-none">
                        <label for="address"><?php echo $this->lang->line('Address'); ?></label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="<?php echo $this->lang->line('Address'); ?>" value="<?php echo $get_conf('pickup.address'); ?>" />
                        <span class="text-danger"><?php echo form_error('address'); ?></span>
                    </fieldset>

                    <button class="btn btn-primary" type="submit"><?php echo $this->lang->line('Save'); ?></button>

                </form>


            </div>
        </div>
    </div>
