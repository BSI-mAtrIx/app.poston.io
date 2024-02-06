<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/extensions/nouislider.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/app-assets/css/plugins/extensions/noui-slider.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/app-assets/css/core/colors/palette-noui.css">

<?php
    function parse_slider_ar($data, $type){
        $data = explode(PHP_EOL, $data);
        foreach($data as $k => $v){
            $data[$k] = parse_slider($v, $type);
        }
        return $data;
    }

?>

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
<?php $build_js = ''; ?>

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

        <div class="container">
            <div class="row card-deck mb-3">
                <div class="p-0 col-sm-12 col-md-7 mb-4 box-shadow">
                <?php
                if(!empty($dp_parsed_plans_dyn)) {


                    foreach ($dp_parsed_plans_dyn[0]['config_plan'] as $key => $row) {
                        if ($row['enabled'] == 0) {
                            continue;
                        }
                        if ($row['free'] == 1) {
                            continue;
                        }
                        echo '
                            <div class="card mb-2">
                                <div class="card-header ">
                                    <div class="checkbox">
                                        <input type="checkbox" class="checkbox-input dpv_collapsed_open" id="' . $key . '_collapsed">
                                        <label for="' . $key . '_collapsed">
                                            <h4 class="font-weight-normal col-12">' . $this->lang->line('dpv_' . $key) . '</h4>
                                        </label>
                                    </div>
                                </div>';

                        echo '<div class="card-body" id="' . $key . '_collapsed_open" style="display:none;">';

                        echo '<strong class="mt-1"></strong>';

                        foreach ($row['sliders'] as $k => $slider) {
                            $config_ar_parsed = parse_slider_ar($slider['config'], $dp_parsed_plans_dyn[0]['id_type']);

                            echo '<h6>
                                        <fieldset class="form-group">
                                                <label for="slider_' . $key . '_' . $k . '_selected">' . $slider['lang'] . ':</label>
                                                <input type="text" class="form-control" class="slider_value" id="slider_' . $key . '_' . $k . '_selected">
                                            </fieldset>

                                  </h6>
                                    <div class="form-group">
                                        <div id="slider_' . $key . '_' . $k . '" class="mt-1 mb-3"></div>
                                    </div>';

                            $ui_slider = '';
                            $last_unlimited = 0;

                            foreach ($config_ar_parsed as $kv => $v) {
                                if ($kv == 0) {
                                    $ui_slider .= "'min': [" . $v['min_value'] . "],";
                                    $last_unlimited = $v['is_unlimited'];
                                    continue;
                                }
                                $per = $v['min_value'] / $slider['max_val'] * 100;
                                $ui_slider .= "'" . $per . "%': [" . $v['min_value'] . "],";

                                $last_unlimited = $v['is_unlimited'];
                            }

                            $build_js .= "         
                                    var uislider_" . $key . "_" . $k . " = document.getElementById('slider_" . $key . "_" . $k . "');
                            var range_" . $key . "_" . $k . " = {
                " . $ui_slider . "
                'max': [" . $slider['max_val'] . "]
            };
            
            var unli_".$key . "_" . $k." = ".$last_unlimited.";
            
            noUiSlider.create(uislider_" . $key . "_" . $k . ", {
                range: range_" . $key . "_" . $k . ",
                direction: direction,
                decimals: 0,
                start: 0,
                pips: {
                    mode: 'range',
                    decimals: 0,
                    format: {
                        to: function (value) {
                            if(" . $slider['max_val'] . " == value && unli_".$key . "_" . $k."==1){
                                return '" . $this->lang->line('Unlimited') . "';
                            }
                            return abbreviateNumber(value);
                        },
                        from: function (value) {
                            return Number(value.replace(',-', ''));
                        }
                    }
                },
                format: {
                    to: (v) => parseFloat(v).toFixed(0),
                    from: (v) => parseFloat(v).toFixed(0)
                }
            });
            
            uislider_" . $key . "_" . $k . ".noUiSlider.on('update', function (values, handle) {
                if(values[handle]==" . $slider['max_val'] . " && unli_".$key . "_" . $k."==1){
                    $('#slider_" . $key . "_" . $k . "_selected').val('" . $this->lang->line('Unlimited') . "');
                    return;
                }
                $('#slider_" . $key . "_" . $k . "_selected').val(values[handle]);
            });
            
            uislider_" . $key . "_" . $k . ".noUiSlider.on('change', function (values, handle) {
                get_price();
            });
            uislider_" . $key . "_" . $k . ".noUiSlider.on('set', function (values, handle) {
                get_price();
            });
            
            $(document).on('change', '#slider_" . $key . "_" . $k . "_selected', function (e){
                uislider_" . $key . "_" . $k . ".noUiSlider.set(this.value);
            });
            
            ";

                            if(count($config_ar_parsed)==1){
                                if($config_ar_parsed[0]['min_value'] == $slider['max_val']){
                                    $build_js .= "
                                $('#slider_" . $key . "_" . $k . "').hide();
                                $('#slider_" . $key . "_" . $k . "_selected').attr('readonly', true);
                                ";
                                }

                            }

                        }

                        echo '</div>';

                        echo '</div>';
                    }


                }


?>
                </div>

                <div class="p-0 col-sm-12 col-md-5 mb-4 box-shadow">
                            <div class="card" id="summary_cart" style="position:fixed!important;">

                                <div class="card-header ">
                                    <h4 class="font-weight-normal col-12"><?php echo $this->lang->line('Your package'); ?>:</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="scrollit mb-2 p-1"
                                         style="height: 22vh;  position: relative; overflow: auto;">
                                        <ul class="list-unstyled" id="pricing-details">

                                        </ul>
                                        <ul class="list-unstyled" id="free-details">

                                        </ul>
                                    </div>
                                    <hr />
                                    <div class="pl-1 pr-1">
                                        <ul class="list-unstyled pricing-summary">
                                            <li>
                                                <strong class="font-medium-1"><?php echo $this->lang->line('Summary'); ?></strong>
                                            </li>
                                            <li>
                                                <fieldset>
                                                    <div class="radio">
                                                        <input type="radio" name="summary_period" id="summary_period1" checked="" value="1">
                                                        <label for="summary_period1"><strong class="font-medium-1"><?php echo $this->lang->line('Total'); ?> (<span id="period_1_summary"></span>)</strong>
                                                            <strong class="font-medium-1" style="position: absolute;
    right: 0;" id="summary_total_price_1"></strong></label>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li>
                                                <fieldset>
                                                    <div class="radio">
                                                        <input type="radio" name="summary_period" id="summary_period2" value="2">
                                                        <label for="summary_period2"><strong class="font-medium-1"><?php echo $this->lang->line('Total'); ?> (<span id="period_2_summary"></span>)</strong>
                                                            <strong class="font-medium-1" style="position: absolute;
    right: 0;" id="summary_total_price_2"></strong></label>
                                                    </div>
                                                </fieldset>
                                            </li>
                                        </ul>
                                        <p class="font-small-3">*<?php echo $this->lang->line('You can apply coupon in next step.'); ?><br />*<?php echo $this->lang->line('You can also provide invoice data in next step.'); ?></p>
                                    </div>



                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary choose_package  mb-2"
                                                data-id=""><?php echo $this->lang->line("Select Package"); ?>
                                            <i class="bx bx-right-arrow"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>


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


