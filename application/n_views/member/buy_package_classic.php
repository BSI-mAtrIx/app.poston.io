
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

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url('payment/transaction_log'); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-history"></i> <?php echo $this->lang->line("Transaction Log"); ?>
        </a>
    </div>
</div>


<div class="section-body">

    <div class="row">

        <?php if (file_exists(APPPATH . 'controllers/Coupon.php') and file_exists(APPPATH . 'controllers/User_coupon.php')) { ?>
            <div class="col-lg-6">
                <div class="card card-large-icons">
                    <div class="card-body">
                        <h4>More Ways to Pay.</h4>
                        <p>Our web shop lets you pay in 10+ different methods</p>
                        <a href="<?php echo base_url(); ?>payment/buy_package" class="card-cta">Shop Now <i
                                    class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-large-icons">
                    <div class="card-body">
                        <h4>Redeem Coupon</h4>
                        <p>If you've purchased a plan here is how to redeem it.</p>
                        <a href="<?php echo base_url(); ?>user_coupon/index" class="card-cta">Redeem Now <i
                                    class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php } ?>


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


        <div class="container">
            <div class="row card-deck mb-3">

                <?php
                $display_hide = 1;
                foreach ($payment_package as $pack) {
                    if ($pack['validity'] == 365) {
                        $pack['annual'] = 1;
                        $display_hide = 0;
                    } else {
                        $pack['annual'] = 0;
                    }
                    ?>

                    <div class="p-0 col-sm-12 col-md-4 mb-4 box-shadow annual_<?php echo $pack['annual'] ?> <?php if ($pack['highlight'] == '1') echo 'pricing-highlight'; ?>" <?php if ($pack['annual'] == 1) {
                        echo 'style="display:none;"';
                    } ?>>
                        <div class="card ">
                            <div class="card-header ">
                                <h4 class="text-center font-weight-normal col-12"><?php echo $pack["package_name"]; ?></h4>
                            </div>
                            <div class="card-body p-0">
                                <h1 class="card-title pricing-card-title text-center"><?php echo $curency_icon; ?><?php echo $pack["price"] ?>
                                    <small class="text-muted"><?php echo $pack["validity"] ?><?php echo $this->lang->line("days"); ?></small>
                                </h1>
                                <div class="scrollit mb-2 p-1"
                                     style="height: 450px;  position: relative; overflow: auto;">
                                    <ul class="list-unstyled pricing-details">
                                        <?php
                                        $module_ids = $pack["module_ids"];
                                        $monthly_limit = json_decode($pack["monthly_limit"], true);
                                        $module_names_array = $this->basic->execute_query('SELECT module_name,id FROM modules WHERE FIND_IN_SET(id,"' . $module_ids . '") > 0  ORDER BY module_name ASC');

                                        foreach ($module_names_array as $row) {
                                            $limit = 0;
                                            $limit = $monthly_limit[$row["id"]];
                                            if ($limit == "0") $limit2 = $this->lang->line("unlimited");
                                            else $limit2 = $limit;
                                            $limit2 = " : " . $limit2;
                                            echo '
                              <li class="pricing-item">
                                  <i class="bx bx-check"></i>
                                  <span>&nbsp;' . $this->lang->line($row["module_name"]) . $limit2 . '</span>
                              </li>';
                                        } ?>
                                    </ul>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn  btn-primary choose_package  mb-2"
                                            data-id="<?php echo $pack['id']; ?>"><?php echo $this->lang->line("Select Package"); ?>
                                        <i class="bx bx-right-arrow"></i></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

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


<div class="modal fade" tabindex="-1" role="dialog" id="payment_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-cart"></i> <?php echo $this->lang->line("Payment Options"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="waiting" style="width: 100%;margin: 20px 0;"><i
                            class="bx bx-loader-alt bx-spin blue" style="font-size:40px;"></i></div>
                <div id="button_place"></div>
                <br>
                <?php
                if ($last_payment_method != '') {

                    $payment_type = ($has_reccuring == 'true') ? $this->lang->line('Recurring') : $this->lang->line('Manual');

                    echo '<br><div class="alert alert-light alert-has-icon">
                  <div class="alert-icon"><i class="bx bx-bulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">' . $this->lang->line("Last Payment") . '</div>
                    ' . $this->lang->line("Last Payment") . ' : ' . $last_payment_method . ' (' . $payment_type . ')
                  </div>
                </div>';
                } ?>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <?php if ('yes' == $manual_payment): ?>
                    <button type="button" id="manual-payment-button" class="btn btn-outline-warning "><span
                                class="align-middle ml-25"><?php echo $this->lang->line('Manual Payment'); ?></span>
                    </button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>

<?php if ('yes' == $manual_payment): ?>
    <div class="modal fade" role="dialog" id="manual-payment-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bx-receipt"></i> <?php echo $this->lang->line("Manual payment"); ?></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">

                        <?php if (isset($manual_payment_instruction) && !empty($manual_payment_instruction)): ?>
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <!-- Manual payment instruction -->
                                    <h6 class="display-6"><i
                                                class="bx bx-bulb"></i> <?php echo $this->lang->line('Manual payment instructions'); ?>
                                    </h6>
                                    <?php echo $manual_payment_instruction; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Paid amount and currency -->
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="paid-amount"><i
                                                class="bx bx-receipt"></i> <?php echo $this->lang->line('Paid Amount'); ?>
                                        :</label>
                                    <input type="number" name="paid-amount" id="paid-amount" class="form-control"
                                           min="1">
                                    <input type="hidden" id="selected-package-id">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="paid-currency"><i
                                                class="bx bx-dollar-circle"></i> <?php echo $this->lang->line('Currency'); ?>
                                    </label>
                                    <?php echo form_dropdown('paid-currency', $currency_list, $currency, ['id' => 'paid-currency', 'class' => 'select2 form-control', 'style' => 'width:100%']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Image upload - Dropzone -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="bx bx-paperclip"></i> <?php echo $this->lang->line('Attachment'); ?> <?php echo $this->lang->line('(Max 5MB)'); ?>
                                    </label>
                                    <div id="manual-payment-dropzone" class="dropzone mb-1">
                                        <div class="dz-default dz-message">
                                            <input class="form-control" name="uploaded-file" id="uploaded-file"
                                                   type="hidden">
                                            <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                              style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                        </div>
                                    </div>
                                    <span class="text-danger">Allowed types: pdf, doc, txt, png, jpg and zip</span>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="paid-amount"><i
                                                class="bx bx-info-circle"></i> <?php echo $this->lang->line('Additional Info'); ?>
                                        :</label>
                                    &nbsp;
                                    <textarea name="additional-info" id="additional-info"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                    </div><!-- ends container -->
                </div><!-- ends modal-body -->

                <!-- Modal footer -->
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" id="manual-payment-submit" class="btn btn-primary"><span
                                class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash"></i>
                        <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


