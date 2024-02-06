<?php if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>
<?php } else { ?>
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
<?php } ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form class="form-horizontal text-c" action="<?php echo site_url() . 'n_wa/config'; ?>"
                          method="POST">
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                        <div class="col-12 mb-1">
                            <div class="form-group">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="api_customer_on" id="api_customer_on" value="1"
                                           class="custom-control-input" <?php echo $api_customer_on; ?>>
                                    <label class="custom-control-label mr-1" for="api_customer_on"></label>
                                    <span><?php echo $this->lang->line('Whatsapp Customer API'); ?></span>
                                    <span class="text-danger"><?php echo form_error('api_customer_on'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-1">
                            <h3><?php echo $this->lang->line('BSP Only'); ?></h3>
                            <a href="https://www.facebook.com/business/help/1684730811624773?id=2129163877102343"><?php echo $this->lang->line('Apply for a credit line for your WhatsApp Business account
'); ?></a>
                        </div>

                        <div class="col-12 mb-1">
                            <div class="form-group">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="bsp_on" id="bsp_on" value="1"
                                           class="custom-control-input" <?php echo $bsp_on; ?>>
                                    <label class="custom-control-label mr-1" for="bsp_on"></label>
                                    <span><?php echo $this->lang->line('Whatsapp BSP ON'); ?></span>
                                    <span class="text-danger"><?php echo form_error('bsp_on'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-1">
                            <div class="form-group">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="bsp_on_version" id="bsp_on_version" value="1"
                                           class="custom-control-input" <?php echo $bsp_on_version; ?>>
                                    <label class="custom-control-label mr-1" for="bsp_on_version"></label>
                                    <span><?php echo $this->lang->line('Whatsapp BSP New Embed '); ?></span>
                                    <span class="text-danger"><?php echo form_error('bsp_on_version'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="bsp_config_id"><?php echo $this->lang->line('Provide Config ID (only for BSP new embed - business login)'); ?> <a href="https://developers.facebook.com/docs/whatsapp/embedded-signup/embed-the-flow#step-2--create-facebook-login-for-business-configuration" target="_blank">[<?php echo $this->lang->line('Follow step 2'); ?>]</a> </label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" class="form-control"  value="<?php echo $bsp_config_id; ?>"  name="bsp_config_id" id="bsp_config_id">
                                </div>
                            </fieldset>
                        </div>


                        <div class="col-12 mb-1">
                            <label for="business_id"><?php echo $this->lang->line('Provide business id'); ?></label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" class="form-control"  value="<?php echo $business_id; ?>"  name="business_id" id="business_id">
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-12 mb-1">
                            <label for="system_user_access_token"><?php echo $this->lang->line('Provide system user access token'); ?></label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" class="form-control"  value="<?php echo $system_user_access_token; ?>"  name="system_user_access_token" id="system_user_access_token">
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-12 mb-1">
                            <p><?php echo $this->lang->line('Current Credit Line'); ?>: <?php echo $api_wa_id_credit_line; ?></p>
                            <input type="hidden" name="current_credit_id" readonly value="<?php echo $api_wa_id_credit_line; ?>">

                            <p><?php echo $this->lang->line('If credit line is empty, then app not attach payment method to your client and cant detach credit line. Your client without credit line cant send messages.'); ?></p>

                            <label for="api_wa_credit_id"><?php echo $this->lang->line('Credit Line'); ?></label>
                            <?php
                            $arr2 = array
                            (
                                'dont' => $this->lang->line('Do not change'),
                                'disabled' => $this->lang->line('Disabled')
                            );

                            if(!empty($api_wa_credit_id) AND $api_wa_credit_id!='dont' AND $api_wa_credit_id!='disabled'){
                                $arr2[$api_wa_credit_id] = $api_wa_credit_id;
                            }

                            echo form_dropdown('api_wa_credit_id', $arr2, $api_wa_credit_id,  ['id' => 'api_wa_credit_id', 'class' => 'form-control']);
                            ?>

                            <a id='fetch_credit_line_button' href="#" class="btn btn-primary"><?php echo $this->lang->line('Fetch Credit Lines'); ?></a>
                        </div>

                        <div class="col-12 mb-1">
                            <label for="api_wa_currency"><?php echo $this->lang->line('WABA Currency'); ?></label>
                            <?php
                            $arr2 = array
                            (
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                'INR' => 'INR',
                                'IDR' => 'IDR',
                                'GBP' => 'GBP',
                                'AUD' => 'AUD',
                            );

                            echo form_dropdown('api_wa_currency', $arr2, $api_wa_currency,  ['id' => 'api_wa_currency', 'class' => 'form-control']);
                            ?>
                        </div>


                        <div class="col-12 mb-1">
                            <p><?php echo $this->lang->line('Easy tool to make new price'); ?></p>

                            <label for="convert_cp">margin / markup / % (100 = no price change)</label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="number" class="form-control"  value="100"  name="convert_cp" id="convert_cp">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="convert_cp_2">%</span>
                                    </div>
                                </div>
                            </fieldset>

                            <label for="convert_margin">USD * % * CONVERT = CP (example: if you use 1000 CP = 1 USD, then write here: 1000)</label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="number" class="form-control"  value="1000"  name="convert_margin" id="convert_margin">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="convert_margin_2">USD TO CP</span>
                                    </div>
                                </div>
                            </fieldset>

                            <label for="convert_margin">Precision (0 = without comma)</label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="number" class="form-control"  value="3"  name="convert_prec" id="convert_prec">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="convert_prec_2">USD TO CP</span>
                                    </div>
                                </div>
                            </fieldset>
                            <a href="#" id="convert_cp_action" class="btn btn-primary mt-1">Convert price</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('Country'); ?></th>
                                    <th><?php echo $this->lang->line('Marketing'); ?><br /><small>(<?php echo $this->lang->line('initiated by business'); ?>)</small></th>
                                    <th><?php echo $this->lang->line('Utility'); ?><br /><small>(<?php echo $this->lang->line('initiated by business'); ?>)</small></th>
                                    <th><?php echo $this->lang->line('Authentication'); ?><br /><small>(<?php echo $this->lang->line('initiated by business'); ?>)</small></th>
                                    <th><?php echo $this->lang->line('Service'); ?><br /><small>(<?php echo $this->lang->line('initiated by contact'); ?>)</small></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                foreach($data_pricing as $k => $v){
                                    echo '
                                    <tr>
                                    <td class="text-bold-500">'.$this->lang->line($v['name']).'</td>
                                    <td>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in USD" value="'.$v['price']['marketing']['usd'].'"  name="price['.$k.'][marketing][usd]" id="for_data_marketing_'.$k.'_1" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_marketing_'.$k.'_1_2">USD</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in CP" value="'.$v['price']['marketing']['cp'].'"  name="price['.$k.'][marketing][cp]" id="for_data_marketing_'.$k.'_2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_marketing_'.$k.'_2_2">CP</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                    </td>
                                    <td>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in USD" value="'.$v['price']['utility']['usd'].'"  name="price['.$k.'][utility][usd]" id="for_data_utility_'.$k.'_1" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_utility_'.$k.'1__2">USD</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in CP" value="'.$v['price']['utility']['cp'].'"  name="price['.$k.'][utility][cp]" id="for_data_utility_'.$k.'_2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_utility_'.$k.'_2_2">CP</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                    </td>
                                    <td>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in USD" value="'.$v['price']['authentication']['usd'].'"  name="price['.$k.'][authentication][usd]" id="for_data_authentication_'.$k.'_1" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_authentication_'.$k.'1__2">USD</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in CP" value="'.$v['price']['authentication']['cp'].'"  name="price['.$k.'][authentication][cp]" id="for_data_authentication_'.$k.'_2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_authentication_'.$k.'_2_2">CP</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                    </td>
                                    <td>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in USD" value="'.$v['price']['service']['usd'].'"  name="price['.$k.'][service][usd]" id="for_data_service_'.$k.'_1" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_service_'.$k.'1__2">USD</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="price in CP" value="'.$v['price']['service']['cp'].'"  name="price['.$k.'][service][cp]" id="for_data_service_'.$k.'_2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="for_data_service_'.$k.'_2_2">CP</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                    </td>
                                </tr>
                                
                                
                                ';

                                }


                                ?>



                                </tbody>
                            </table>

                            <div class="col-12 mb-1">
                                <h4><?php echo $this->lang->line('Email message to User low CP credits'); ?></h4>

                                <label for="min_cp_warning_email"><?php echo $this->lang->line('Minimum CP to send email'); ?></label>
                                <fieldset>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  value="<?php echo $min_cp_warning_email; ?>"  name="min_cp_warning_email" id="min_cp_warning_email">
                                    </div>
                                </fieldset>

                                <label for="min_cp_warning_email_title"><?php echo $this->lang->line('Email title'); ?></label>
                                <fieldset>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  value="<?php echo $min_cp_warning_email_title; ?>"  name="min_cp_warning_email_title" id="min_cp_warning_email_title">
                                    </div>
                                </fieldset>

                                <label for="min_cp_warning_email_text"><?php echo $this->lang->line("Email text"); ?></label>
                                <textarea class="form-control" id="min_cp_warning_email_text" name="min_cp_warning_email_text"
                                          placeholder="Answer"><?php echo $min_cp_warning_email_text; ?></textarea>
                            </div>

                            <div class="col-12 mb-1">
                                <h4><?php echo $this->lang->line('Email message to User not have CP credits'); ?></h4>

                                <label for="empty_cp_warning_email_title"><?php echo $this->lang->line('Email title'); ?></label>
                                <fieldset>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  value="<?php echo $empty_cp_warning_email_title; ?>"  name="empty_cp_warning_email_title" id="empty_cp_warning_email_title">
                                    </div>
                                </fieldset>

                                <label for="empty_cp_warning_email_text"><?php echo $this->lang->line("Email text"); ?></label>
                                <textarea class="form-control" id="empty_cp_warning_email_text" name="empty_cp_warning_email_text"
                                          placeholder="Answer"><?php echo $empty_cp_warning_email_text; ?></textarea>
                            </div>



                            <div class="col-12 mb-1">
                            <button type="submit" id="save-btn" class="btn btn-outline-success mr-1">
                                <i class="bx bx-save"></i>
                                <span class="align-middle ml-25"><?php echo $this->lang->line("Save"); ?></span>
                            </button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
