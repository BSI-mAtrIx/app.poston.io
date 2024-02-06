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
$include_mCustomScrollBar = 0;
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
<?php if ('Member' == $this->session->userdata('user_type')): ?>
    <div class="row">
        <div class="col-12">

            <a href="<?php echo base_url('payment/buy_package'); ?>" class="btn btn-primary mb-1">
                <i class="bx bx-cart"></i> <?php echo $this->lang->line("Renew Package"); ?>
            </a>
        </div>
    </div>
<?php endif; ?>

<?php $this->load->view('admin/theme/message'); ?>

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
                                <th><?php echo $this->lang->line("Name"); ?></th>
                                <th><?php echo $this->lang->line("Email"); ?></th>
                                <th><?php echo $this->lang->line("Additional Info"); ?></th>
                                <th><?php echo $this->lang->line("Attachment"); ?></th>
                                <th style="min-width:100px;"><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Package"); ?></th>
                                <th><?php echo $this->lang->line("Package Price"); ?></th>
                                <th><?php echo $this->lang->line("Package Validity"); ?></th>
                                <th><?php echo $this->lang->line("Paid Amount"); ?></th>
                                <th><?php echo $this->lang->line("Paid At"); ?></th>
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
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<?php
$drop_menu = '<a href="javascript:;" id="payment_date_range" class="btn btn-primary float-right has-icon-left btn-icon"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="payment_date_range_val">';
?>

<?php if ('Admin' == $this->session->userdata('user_type')): ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="manual-payment-reject-modal" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bx-time-circle"></i> <?php echo $this->lang->line("Manual payment rejection"); ?>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <!-- Additional Info -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="paid-amount"><?php echo $this->lang->line('Describe, why do you want to reject this payment?'); ?></label>
                                    &nbsp;
                                    <textarea name="rejected-reason" id="rejected-reason"
                                              class="form-control"></textarea>
                                    <input type="hidden" id="mp-transaction-id">
                                    <input type="hidden" id="mp-action-type">
                                </div>
                            </div>
                        </div>

                    </div><!-- ends container -->
                </div><!-- ends modal-body -->

                <!-- Modal footer -->
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" id="manual-payment-reject-submit" class="btn btn-primary"><span
                                class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span></button>
                    <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal"><i
                                class="bx bx-trash"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" tabindex="-1" role="dialog" id="manual-payment-modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-receipt"></i> <?php echo $this->lang->line("Manual payment"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">

                    <!-- Manual payment instruction -->
                    <div id="manual-payment-instructions" class="row d-none">
                        <div class="col-lg-12 mb-4">
                            <div class="alert alert-light alert-has-icon">
                                <div class="alert-icon"><i class="bx bx-bulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title"><?php echo $this->lang->line('Manual payment instructions'); ?></div>
                                    <p id="payment-instructions"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paid amount and currency -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="form-group">
                                <label for="paid-amount"><i
                                            class="bx bx-receipt"></i> <?php echo $this->lang->line('Paid Amount'); ?>:</label>
                                <input type="number" name="paid-amount" id="paid-amount" class="form-control" min="1">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="form-group">
                                <label for="paid-currency"><i
                                            class="bx bx-dollar-circle"></i> <?php echo $this->lang->line('Currency'); ?>
                                </label>
                                <?php echo form_dropdown('paid-currency', $currency_list, [], ['id' => 'paid-currency', 'class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Image upload - Dropzone -->
                    <div class="row">
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
                                <textarea name="additional-info" id="additional-info" class="form-control"></textarea>
                            </div>
                            <input type="hidden" id="selected-package-id">
                            <input type="hidden" id="mp-resubmitted-id">
                        </div>
                    </div>

                </div><!-- ends container -->
            </div><!-- ends modal-body -->

            <!-- Modal footer -->
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" id="manual-payment-submit" class="btn btn-primary"><span
                            class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
            <div id="mp-spinner" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: #ffffff"
                 class="justify-content-center align-items-center d-flex"><i
                        class="bx bx-loader-alt bx-spin  text-primary"></i></div><!-- spinner -->
        </div>
    </div>
</div>

