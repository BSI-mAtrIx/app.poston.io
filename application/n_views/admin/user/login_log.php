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
                                <th><?php echo $this->lang->line("User"); ?></th>
                                <th><?php echo $this->lang->line("Email"); ?></th>
                                <th><?php echo $this->lang->line("Login Time"); ?></th>
                                <th><?php echo $this->lang->line("Login IP"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sl = 0;
                            foreach ($info as $key => $value) {
                                $sl++;
                                $id = $value['user_id'];
                                echo "<tr>";
                                echo "<td>" . $sl . "</td>";
                                echo "<td><a href='" . base_url('admin/edit_user/' . $id) . "'>" . $value['user_name'] . "</a></td>";
                                echo "<td>" . $value['user_email'] . "</td>";
                                echo "<td>" . $value['login_time'] . "</td>";
                                echo "<td>" . $value['login_ip'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<?php
$drop_menu = '<div class="btn-group dropleft float-right"><button type="button" class="btn btn-primary float-right has-icon-left btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  ' . $this->lang->line("Options") . '  </button>  <div class="dropdown-menu dropleft"> <a class="dropdown-item are_you_sure_datatable" data-refresh="0" href="' . base_url('admin/delete_user_log') . '"><i class="bx bx-trash"></i> ' . $this->lang->line("Delete old data") . '</a></div> </div>';
?>


<div class="modal fade" tabindex="-1" role="dialog" id="change_password" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-key"></i> <?php echo $this->lang->line("Change Password"); ?>
                    (<span id="putname"></span>)</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo site_url() . 'admin/change_user_password_action'; ?>"
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
                            class="bx bxs-save"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash-alt"></i>
                    <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modal_send_sms_email" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Send Email"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div id="modalBody" class="modal-body">
                <div id="show_message" class="text-center"></div>

                <div class="form-group">
                    <label for="subject"><?php echo $this->lang->line("Subject"); ?> *</label><br/>
                    <input type="text" id="subject" class="form-control"/>
                    <div class="invalid-feedback"><?php echo $this->lang->line("Subject is required"); ?></div>
                </div>

                <div class="form-group">
                    <label for="message"><?php echo $this->lang->line("Message"); ?> *</label><br/>
                    <textarea name="message" style="height:300px !important;" class="form-control"
                              id="message"></textarea>
                    <div class="invalid-feedback"><?php echo $this->lang->line("Message is required"); ?></div>
                </div>

            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button id="send_sms_email" class="btn btn-primary"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Send"); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash-alt"></i>
                    <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>