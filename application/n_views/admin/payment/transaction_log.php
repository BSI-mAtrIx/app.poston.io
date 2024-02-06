<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$has_stripe_cust_id = 0;
$include_dropzone = 1;
?>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>payment/buy_package">
                            <?php
                            if ($this->session->userdata("user_type") == "Admin")
                                echo $this->lang->line("Subscription");
                            else echo $this->lang->line("Payment");
                            ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url('payment/transaction_log_manual'); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-dollar-circle"></i> <?php echo $this->lang->line("Manual Transaction Log"); ?>
        </a>
        <?php

        $n_user = $this->basic->get_data("users",array("where"=>array("users.id"=>$this->session->userdata("user_id"))),"users.*");

        if(!empty($n_user[0]['n_stripe_cust_id'])){
            $n_stripe_cust_id = $n_user[0]['n_stripe_cust_id'];
            $has_stripe_cust_id = 1;
        }

        if ($n_config['n_stripe_subscription_enabled'] == 'true'
            AND $has_stripe_cust_id == 1
        ) { ?>
            <a href="#" class="btn btn-primary mb-1" id="stripe_manage">
                <i class="bx bx-dollar-circle"></i> <?php echo $this->lang->line("Manage Subscription"); ?>
            </a>
        <?php } ?>
    </div>
</div>


<?php
$this->load->view('admin/theme/message');
if ($this->session->flashdata('xendit_currency_error') != '')
    echo "<div class='alert alert-danger text-center'><i class='bx bx-check-circle'></i> " . $this->session->flashdata('xendit_currency_error') . "</div>";
?>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Email"); ?></th>
                                <th><?php echo $this->lang->line("First Name"); ?></th>
                                <th><?php echo $this->lang->line("Last Name"); ?></th>
                                <th><?php echo $this->lang->line("Method"); ?></th>
                                <th><?php echo $this->lang->line("Cycle Start"); ?></th>
                                <th><?php echo $this->lang->line("cycle End"); ?></th>
                                <th><?php echo $this->lang->line("Paid at"); ?></th>

                                <?php if($n_config['dp_on'] == 'true'){
                                    echo '<th>'.$this->lang->line("Amount").'</th>';
                                    echo '<th>'.$this->lang->line("Invoice").'</th>';
                                }else{
                                    echo '<th>'.$this->lang->line("Amount") . ' ' . $curency_icon.'</th>';
                                }

                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th><?php echo $this->lang->line("Total"); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php if($n_config['dp_on'] == 'true'){
                                    echo '<th></th>';
                                }
                                ?>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

