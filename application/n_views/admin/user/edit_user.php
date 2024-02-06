<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
?>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('admin/user_manager'); ?>"><?php echo $this->lang->line("User Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="row">
    <div class="col-12">

        <form class="form-horizontal" action="<?php echo site_url() . 'admin/edit_user_action'; ?>" method="POST">
            <input type="hidden" name="csrf_token" id="csrf_token"
                   value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
            <div class="card">
                <div class="card-body">

                    <input name="id" value="<?php echo $xdata['id']; ?>" class="form-control" type="hidden">

                    <div class="form-group">
                        <label for="name"> <?php echo $this->lang->line("Full Name") ?> </label>
                        <input name="name" value="<?php echo $xdata['name']; ?>" class="form-control" type="text">
                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email"> <?php echo $this->lang->line("Email") ?> *</label>
                                <input name="email" value="<?php echo $xdata['email']; ?>" class="form-control"
                                       type="text">
                                <span class="text-danger"><?php echo form_error('email'); ?></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="mobile"><?php echo $this->lang->line("Mobile") ?></label>
                                <input name="mobile" value="<?php echo $xdata['mobile']; ?>" class="form-control"
                                       type="text">
                                <span class="text-danger"><?php echo form_error('mobile'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address"> <?php echo $this->lang->line("Address") ?></label>
                        <textarea name="address" class="form-control"><?php echo $xdata['address'] ?></textarea>
                        <span class="text-danger"><?php echo form_error('address'); ?></span>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="user_type"> <?php echo $this->lang->line('User Type'); ?></label>
                                <div class="custom-switches-stacked mt-2">
                                    <div class="row">
                                        <div class="col-6 col-md-4">
                                            <div class="custom-switch">
                                                <input type="radio" name="user_type" id="user_type_1"
                                                       value="Member" <?php if ($xdata['user_type'] == 'Member') echo 'checked'; ?>
                                                       class="user_type custom-control-input">
                                                <label class="custom-control-label mr-1" for="user_type_1"></label>
                                                <span><?php echo $this->lang->line('Member'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="custom-switch">
                                                <input type="radio" name="user_type" id="user_type_2"
                                                       value="Admin" <?php if ($xdata['user_type'] == 'Admin') echo 'checked'; ?>
                                                       class="user_type custom-control-input">
                                                <label class="custom-control-label mr-1" for="user_type_2"></label>
                                                <span><?php echo $this->lang->line('Admin'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('user_type'); ?></span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status"> <?php echo $this->lang->line('Status'); ?></label><br>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="status" id="status" value="1"
                                           class="custom-control-input" <?php if ($xdata['status'] == '1') echo 'checked'; ?>>
                                    <label class="custom-control-label mr-1" for="status"></label>
                                    <span><?php echo $this->lang->line('Active'); ?></span>
                                    <span class="text-danger"><?php echo form_error('status'); ?></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="hidden">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="package_id"> <?php echo $this->lang->line("Package") ?> *</label>
                                <?php
                                $default_package = $xdata['package_id'];
                                if ($default_package == '0') $default_package = '1';
                                ?>
                                <?php echo form_dropdown('package_id', $packages, $default_package, 'class="form-control select2" style="width:100%;"'); ?>
                                <span class="text-danger"><?php echo form_error('package_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="expired_date"> <?php echo $this->lang->line("Expiry Date") ?> *</label>
                                <?php
                                $default_date = $xdata['expired_date'];
                                if ($default_date == '0000-00-00 00:00:00') $default_date = '';
                                ?>
                                <input name="expired_date" value="<?php echo $default_date; ?>"
                                       class="form-control datepicker" type="text">
                                <span class="text-danger"><?php echo form_error('expired_date'); ?></span>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="card-footer bg-whitesmoke">
                    <button name="submit" type="submit" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <button type="button" class="btn btn-secondary float-right"
                            onclick='goBack("admin/user_manager",0)'><i class="bx bx-trash"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
                </div>
            </div>
        </form>
    </div>
</div>


          


