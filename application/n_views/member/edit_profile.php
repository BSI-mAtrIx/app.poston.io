<?php
$name = isset($profile_info[0]["name"]) ? $profile_info[0]["name"] : "";
$email = isset($profile_info[0]["email"]) ? $profile_info[0]["email"] : "";
$time_zone = isset($profile_info[0]["time_zone"]) ? $profile_info[0]["time_zone"] : "";
$user_type = isset($profile_info[0]["user_type"]) ? $profile_info[0]["user_type"] : "";
$package_name = isset($profile_info[0]["package_name"]) ? $profile_info[0]["package_name"] : "";
$expired_date = isset($profile_info[0]["expired_date"]) ? date("jS F Y", strtotime($profile_info[0]["expired_date"])) : "";
$address = isset($profile_info[0]["address"]) ? $profile_info[0]["address"] : "";
$logo = isset($profile_info[0]["brand_logo"]) ? $profile_info[0]["brand_logo"] : "";
if ($logo == "") $logo = file_exists("assets/img/avatar/avatar-1.png") ? base_url("assets/img/avatar/avatar-1.png") : "https://mysitespy.net/envato_image/avatar.png";
else $logo = base_url() . 'member/' . $logo;
?>

<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
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

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <h2 class="section-title"><?php echo $this->lang->line('Hi'); ?>, <?php echo $name; ?> !</h2>
    <p class="section-lead">
        <?php echo $this->lang->line('Change information about yourself on this page.'); ?>
    </p>

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">


            <div class="card">
                <div class="card-header mx-auto pt-3">
                    <div class="avatar bg-rgba-primary p-50">
                        <img class="img-fluid" src="<?php echo $logo; ?>" alt="img placeholder" height="134"
                             width="134">
                    </div>
                </div>
                <div class="card-body text-center">
                    <h4><?php echo $name; ?></h4>
                    <p><?php echo $user_type; ?></p>
                    <!-- <p class="px-1">Jelly beans halvah cake chocolate gummies.</p> -->

                    <table class="table table-borderless text-left">
                        <tbody>
                        <tr>
                            <td><?php echo $this->lang->line('Email') ?>:</td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <?php if ($this->session->userdata('user_type') != 'Admin') : ?>
                            <tr>
                                <td><?php echo $this->lang->line('Package') ?>:</td>
                                <td class="users-view-latest-activity"><?php echo $package_name; ?></td>
                            </tr>

                            <tr>
                                <td><?php echo $this->lang->line('Expire') ?>:</td>
                                <td class="users-view-verified"><?php echo $expired_date; ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><?php echo $this->lang->line('Address') ?>:</td>
                            <td class="users-view-latest-activity"><?php echo $address; ?></td>
                        </tr>
                        </tbody>
                    </table>

                    <?php if ($this->session->userdata('user_type') == 'Member') { ?>
                        <a class="delete_full_access btn btn-outline-danger red pointer btn-sm"
                           title="<?php echo $this->lang->line('Delete Account'); ?>"><i
                                    class="bx bx-trash"></i> <?php echo $this->lang->line('Delete Account'); ?></a>
                        <?php
                    } ?>
                </div>
            </div>


        </div>
        <div class="col-12 col-md-12 col-lg-7">
            <?php
            $file_location_epayco = APPPATH.'modules/n_epayco/lib/profile_info.php';
            if(file_exists($file_location_epayco)){
                include($file_location_epayco);
            } ?>

            <div class="card">
                <form class="form-horizontal" enctype="multipart/form-data"
                      action="<?php echo site_url() . 'myprofile/edit_profile_action'; ?>" method="POST">
                    <input type="hidden" name="csrf_token" id="csrf_token"
                           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                    <div class="card-header">
                        <h4><i class="bx bx-edit"></i> <?php echo $this->lang->line('Edit Profile'); ?> </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label class="control-label" for=""><i
                                            class="bx bx-rocket"></i> <?php echo $this->lang->line("Name"); ?> *</label>
                                <div>
                                    <input name="name" value="<?php echo $name; ?>" class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label class="control-label" for=""><i
                                            class="bx bx-envelope"></i> <?php echo $this->lang->line("Email"); ?>
                                    *</label>
                                <div>
                                    <input name="email" value="<?php echo $email; ?>" class="form-control" type="email">
                                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label class="control-label" for=""><i
                                            class="bx bx-map-pin-alt"></i> <?php echo $this->lang->line("Address"); ?>
                                </label>
                                <div>
                                    <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('address'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for=""><i class="bx bx-image"></i> <?php echo $this->lang->line("image"); ?>
                                    (png)</label>
                                <div class="custom-file">
                                    <input name="logo" class="custom-file-input" type="file">
                                    <label class="custom-file-label">Choose File</label>
                                    <small>
                                        <?php echo $this->lang->line("Max Dimension"); ?> : 300 x
                                        300, <?php echo $this->lang->line("Max Size"); ?> : 200KB</small>
                                    <span class="text-danger"> <?php echo $this->session->userdata('logo_error');
                                        $this->session->unset_userdata('logo_error'); ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label class="control-label" for=""><i
                                            class="bx bx-user-clock"></i> <?php echo $this->lang->line("Time Zone"); ?>
                                </label>
                                <div>
                                    <select name="time_zone" id="time_zone" class="select2 form-control">
                                        <?php
                                        $time_zone_list[''] = $this->lang->line('Please select Time Zone');
                                        foreach ($time_zone_list as $key => $value) :
                                            ?>
                                            <option value="<?php echo $key; ?>" <?php if ($key == $time_zone) echo "selected"; ?> ><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="delete_dialog" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-info-circle"></i> <?php echo $this->lang->line("Delete Account?"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>

            <div class="modal-body">
                <div id="message_div">
                    <div class="text-center"><i style="font-size: 70px"
                                                class="bx bx-info-circle center-block orange"></i></div>
                    <br>
                    <h6><?php echo $this->lang->line("Deleting your account will delete all your data from our system and this account can not be restored again. Do you really want to delete your account?"); ?></h6>
                </div>
            </div>

            <div class="modal-footer" style="display: block">
                <button csrf_token="<?php echo $this->session->userdata('csrf_token_session'); ?>"
                        class="btn btn-danger delete_confirm  float-left"><i
                            class="bx bx-trash"></i> <?php echo $this->lang->line('Delete My Account'); ?></button>
                <button class="btn btn-light cancel_button  float-right"><i class="bx bx-trash"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
            </div>

        </div>
    </div>
</div>



