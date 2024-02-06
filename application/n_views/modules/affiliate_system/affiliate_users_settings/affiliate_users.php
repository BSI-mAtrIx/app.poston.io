<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>


<style>
    /*.avatar-badge { background: 0 !important; }*/
    .avatar-item .avatar-badge {
        position: absolute;
        bottom: -3px;
        right: 0px;
        background-color: #fff;
        color: #000;
        box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
        border-radius: 50%;
        text-align: center;
        line-height: 20px;
        width: 18px;
        height: 18px;
    }

    div.tooltip_pd {
        top: 0px !important;
    }
</style>
<input type="hidden" name="csrf_token" id="csrf_token"
       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

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
        <a href="<?php echo site_url('affiliate_system/add_affiliate'); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Affiliate"); ?>
        </a>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body data-card">
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable_affiliate_users">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Avatar"); ?></th>
                                <th class="text-left"><?php echo $this->lang->line("Name"); ?></th>
                                <th><?php echo $this->lang->line("Email"); ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Registered"); ?></th>
                                <th><?php echo $this->lang->line("Last Login"); ?></th>
                                <th><?php echo $this->lang->line("Last Login IP"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="modal fade" tabindex="-1" role="dialog" id="change_password" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-key"></i> <?php echo $this->lang->line("Change Affiliator Password"); ?> (<span
                            id="putname"></span>)</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal"
                      action="<?php echo site_url() . 'affiliate_system/change_affiliate_password_action'; ?>"
                      method="POST">
                    <div id="wait"></div>
                    <input id="putid" value="" class="form-control" type="hidden">
                    <div class="form-group">
                        <label for="password"><?php echo $this->lang->line("New Password"); ?> * </label>
                        <input id="password" class="form-control password" type="password">
                        <div class="invalid-feedback"><?php echo $this->lang->line("You have to type new password twice"); ?></div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password"><?php echo $this->lang->line("Confirm New Password"); ?>
                            * </label>
                        <input id="confirm_password" class="form-control password" type="password">
                        <div class="invalid-feedback"><?php echo $this->lang->line("Passwords does not match"); ?></div>
                    </div>
                </form>
            </div>


            <div class="modal-footer bg-whitesmoke br">
                <button type="button" id="save_change_password_button" class="btn btn-primary"><i
                            class="bx bx-save"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>

        </div>
    </div>
</div>
