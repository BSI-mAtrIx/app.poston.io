<style type="text/css">
    .stripe-button-el, .stripe-button-el span {
        -moz-box-shadow: none;
        -ms-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        width: 100%
    }

    .stripe-button-el span {
        height: 50px;
        line-height: 50px;
    }

    #payment_options button:not(.stripe-button-el), #mollie-payment-button {
        font-size: 14px;
        font-weight: bold;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        background: #1275ff;
        background-image: -webkit-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
        background-image: -moz-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
        background-image: -ms-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
        background-image: -o-linear-gradient(#7dc5ee, #008cdd 85%, #30a2e4);
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        -webkit-border-radius: 4px;
        -moz-border-radius: 6px;
        -ms-border-radius: 6px;
        -o-border-radius: 6px;
        border-radius: 6px;
        /*margin-top:-2px;*/
        width: 100%;
        /*line-height: 50px;*/
        height: 52px;
        border-bottom-color: #015e94;
        color: #fff;
        border: none;
        cursor: pointer;
        display: inline-block;
    }

    #mollie-payment-button {
        line-height: 52px;
        text-align: center;
    }

    #mollie-payment-button:hover {
        text-decoration: none;
    }

    #payment_options button:hover:not(.stripe-button-el) {
        border-bottom-color: #015e94 !important;
    }

    .card {
        transition: none;
    }

</style>


<div class="content-header row">
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


<div class="section-body">

    <div class="row">

                <?php
                if(!empty($dp_plan)){
                    ?>
        <div id="annual-hide" class="col-12" style="margin:30px auto;text-align:center;">
            <div class="form-group">
                <div class="custom-switch mt-2">
                    <input type="checkbox" name="annual_plans" value="false" class="custom-control-input"
                           id="annual_plan_check">
                    <label class="custom-control-label mr-1" for="annual_plan_check"></label>
                    <span class="font-weight-bold"><?php echo $this->lang->line("Display annual plans"); ?></span>
                </div>
            </div>
        </div>
<?php } ?>

        <div class="container">
            <div class="row card-deck mb-3">
                <?php
                if(!empty($dp_plan)){
                    $display_hide = 1;
                    foreach ($dp_parsed_plans as $pack) {


                        if ($pack['id_type'] == 2) {
                            $pack['annual'] = 1;
                            $display_hide = 0;
                        } else {
                            $pack['annual'] = 0;
                        }
                        ?>

                        <div class="p-0 col-sm-12 col-md-4 mb-4 box-shadow annual_<?php echo $pack['annual'] ?> <?php if ($pack['highlight'] == 1) echo 'pricing-highlight'; ?>" <?php if ($pack['annual'] == 1) {
                            echo 'style="display:none;"';
                        } ?>>
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="text-center font-weight-normal col-12"><?php echo $pack["name"]; ?></h4>
                                </div>
                                <div class="card-body p-0">
                                    <h1 class="card-title pricing-card-title text-center"><?php echo $curency_icon; ?><?php echo $pack["price"] ?>
                                        <small class="text-muted"><?php echo $pack["validity_value"] ?> <?php echo $this->lang->line($pack['validity_type']); ?></small>
                                    </h1>
                                    <div class="scrollit mb-2 p-1"
                                         style="height: 22vh;  position: relative; overflow: auto;">
                                        <ul class="list-unstyled pricing-details">
                                            <?php
                                            foreach ($pack['config_plan'] as $key => $row) {
                                                if($row['enabled']==0){
                                                    continue;
                                                }
                                                echo '<strong class="mt-1">'.$this->lang->line('dpv_'.$key).'</strong>';
                                                foreach($row['sliders'] as $slider){
                                                    $dp_s = parse_slider($slider['config'], $pack['id_type']);

                                                    $limit = 0;
                                                    $limit = $dp_s['min_value'];
                                                    if ($dp_s['is_unlimited'] == 1) $limit2 = $this->lang->line("unlimited");
                                                    else $limit2 = $limit;
                                                    $limit2 = ": " . $limit2;
                                                    echo '
                              <li class="pricing-item">
                                  <i class="bx bx-check"></i>
                                  <span>&nbsp;' . $slider['lang'] . $limit2 . '</span>
                              </li>';

                                                }


                                            } ?>
                                        </ul>
                                    </div>
                                    <div class="text-center">
                                        <a type="button" class="btn  btn-primary  mb-2"
                                                href="<?php echo base_url('price/create_package/').$pack['id'].'/'.$pack['id_type']; ?>"><?php echo $this->lang->line("Select Package"); ?>
                                            <i class="bx bx-right-arrow"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }

                if($activated_url_dynamic==1){
                ?>
                <div class="col-12 text-center">
                    <a href="<?php echo base_url('/payment/buy_package/1'); ?>" class="btn btn-primary"><?php echo $this->lang->line('Or create your own package (click here)'); ?></a>
                </div>

                <?php } ?>
            </div>
        </div>
    </div>

    <?php
    if ($n_config['package_qa_show'] == 'true' or ($n_config['package_qa_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) {

        $import_section = 'false';
        if (file_exists(APPPATH . 'n_eco_user/payment_' . strtolower($current_language) . '.php')) {
            $import_section = APPPATH . 'n_eco_user/payment_' . strtolower($current_language) . '.php';
        } else {
            if (file_exists(APPPATH . 'n_eco_user/payment_' . $n_config['package_qa_default'] . '.php')) {
                $import_section = APPPATH . 'n_eco_user/payment_' . $n_config['package_qa_default'] . '.php';
            }
        }


        if ($import_section != 'false') {
            $n_editor_data = file_get_contents($import_section);
            $n_editor_data = json_decode($n_editor_data, true);
        } else {
            $n_editor_data = array();
        }

        ?>

        <div class="row">
            <div class="col-12">
                <div class="card bg-transparent shadow-none width-70-per" style="margin:auto;">
                    <div class="card-body">
                        <div id="accordion-icon-wrapper1" class="collapse-icon accordion-icon-rotate">
                            <div class="accordion" id="accordionWrapar2">
                                <?php
                                if (!empty($n_editor_data)) {
                                    foreach ($n_editor_data['group-a'] as $k => $v) { ?>
                                        <div class="card collapse-header">
                                            <div id="heading5" class="card-header" data-toggle="collapse" role="button"
                                                 data-target="#accordion<?php echo $k; ?>" aria-expanded="false"
                                                 aria-controls="accordion<?php echo $k; ?>">
                      <span class="collapse-title d-flex align-items-center"><i class="bx bxs-circle font-small-1"></i>
                        <?php echo $v['question']; ?>
                      </span>
                                            </div>
                                            <div id="accordion<?php echo $k; ?>" role="tabpanel"
                                                 data-parent="#accordionWrapar2" aria-labelledby="heading5"
                                                 class="collapse">
                                                <div class="card-body">
                                                    <?php echo $v['answer']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }

                                ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>


