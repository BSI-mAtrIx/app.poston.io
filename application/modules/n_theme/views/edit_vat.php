<style>
    .row-actions{display:none;}
    tr:hover .row-actions{display:block;}
</style>
<?php
    $include_datatable = 1;
    $include_select2 = 1;

    $get_vat =  function($value) use ($vat_country){
        if(isset($vat_country[$value])){
            return $vat_country[$value];
        }else{ return 0;}
    };


?>

    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>price/plan_list"><?php echo $this->lang->line('Dynamic Price Plan Configuration'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<form action="<?php echo base_url('price/vat_save/'); ?>" id="vat_form" method="POST">
<div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $this->lang->line("Vat Country"); ?></h5>
                </div>
                <div class="card-body">
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                    <div class="row">
                        <?php foreach($country_list as $k => $v){
                            echo '<div class="col-6">
                            <fieldset>
                                <label for="id_'.$k.'">'.$this->lang->line($v).'</label>
                                <div class="input-group">
                                    <input type="text" id="id_'.$k.'" name="'.$k.'"
                                           class="form-control" value="'.$get_vat($k).'">
                                </div>
                                <span class="text-danger"></span>
                            </fieldset>
                        </div>';
                        } ?>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <button type="submit" form="vat_form" value="Submit" class="btn btn-primary"><?php echo $this->lang->line('Save Settings'); ?></button>
                        </div>
                    </div>


                </div>
            </div>
</div>
</form>