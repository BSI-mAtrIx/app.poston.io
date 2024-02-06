<style>.note-btn {
        padding: 0 10px !important
    }

    .note-editable {
        min-height: 200px !important
    }</style>


<?php
$jodit = 1;
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
                                href="<?php echo base_url('admin/settings'); ?>"><?php echo $this->lang->line("Settings"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<?php if ($test_btn == 1) { ?>
    <div class="row">
        <div class="col-12">
            <a id="add_new_domain" href="#" class="btn btn-primary mb-1 send_test_mail">
                <i class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Send Test Email"); ?>
            </a>
        </div>
    </div>
<?php } ?>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("admin/smtp_settings_action"); ?>" method="POST">

                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for=""><i
                                        class="bx bx-at"></i> <?php echo $this->lang->line("Sender Email Address"); ?>
                            </label>
                            <input name="email_address"
                                   value="<?php echo isset($xvalue['email_address']) ? $xvalue['email_address'] : ""; ?>"
                                   class="form-control" type="email">
                            <span class="text-danger"><?php echo form_error('email_address'); ?></span>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-server"></i> <?php echo $this->lang->line("SMTP Host"); ?>
                                    </label>
                                    <input name="smtp_host"
                                           value="<?php echo isset($xvalue['smtp_host']) ? $xvalue['smtp_host'] : ""; ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('smtp_host'); ?></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-plug"></i> <?php echo $this->lang->line("SMTP Port"); ?>
                                    </label>
                                    <input name="smtp_port"
                                           value="<?php echo isset($xvalue['smtp_port']) ? $xvalue['smtp_port'] : ""; ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('smtp_port'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-user-circle"></i> <?php echo $this->lang->line("SMTP User"); ?>
                                    </label>
                                    <input name="smtp_user"
                                           value="<?php echo isset($xvalue['smtp_user']) ? $xvalue['smtp_user'] : ""; ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('smtp_user'); ?></span>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><i
                                                class="bx bx-key"></i> <?php echo $this->lang->line("SMTP Password"); ?>
                                    </label>
                                    <input name="smtp_password"
                                           value="<?php echo isset($xvalue['smtp_password']) ? $xvalue['smtp_password'] : ""; ?>"
                                           class="form-control" type="text">
                                    <span class="text-danger"><?php echo form_error('smtp_password'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="smtp_type"><i
                                        class="bx bx-shield"></i> <?php echo $this->lang->line('Connection Type'); ?>
                                ?</label>
                            <?php
                            $smtp_type = isset($xvalue['smtp_type']) ? $xvalue['smtp_type'] : "";
                            if ($smtp_type == '') $smtp_type = 'Default';
                            ?>
                            <div class="custom-switches-stacked mt-2">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="smtp_type" id="smtp_type_1" value="Default"
                                                   class="custom-control-input" <?php if ($smtp_type == 'Default') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="smtp_type_1"></label>
                                            <span><?php echo $this->lang->line('Default'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-2">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="smtp_type" id="smtp_type_2" value="tls"
                                                   class="custom-control-input" <?php if ($smtp_type == 'tls') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="smtp_type_2"></label>
                                            <span>TLS</span>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-2">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="smtp_type" id="smtp_type_3" value="ssl"
                                                   class="custom-control-input" <?php if ($smtp_type == 'ssl') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="smtp_type_3"></label>
                                            <span>SSL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger"><?php echo form_error('smtp_type'); ?></span>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <button class="btn btn-secondary float-right" onclick='goBack("admin/settings")' type="button">
                            <i class="bx bx-trash"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_send_test_email" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title blue"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Send Test Email"); ?></h3>
                <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;
                </button>
            </div>

            <div id="modalBody" class="modal-body">
                <div id="show_message" class="text-center"></div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="recipient_email"><i
                                        class="bx bx-at"></i> <?php echo $this->lang->line("Recipient Email"); ?>
                            </label>
                            <input type="text" id="recipient_email"
                                   value="<?php echo $this->session->userdata('user_login_email'); ?>"
                                   class="form-control"/>
                            <div class="invalid-feedback"><?php echo $this->lang->line("Email is required"); ?></div>
                        </div>


                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="subject"><i class="bx bx-bulb"></i> <?php echo $this->lang->line("Subject"); ?>
                            </label>
                            <input type="text" id="subject" class="form-control" value="This is test subject message"/>
                            <div class="invalid-feedback"><?php echo $this->lang->line("Subject is required"); ?></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="message"><i
                                        class="bx bx-envelope"></i> <?php echo $this->lang->line("Message"); ?></label>
                            <textarea name="message" style="height:300px !important;" class="form-control" id="message">
                  This is test message. If you got this message SMTP works fine.
              </textarea>
                            <div class="invalid-feedback"><?php echo $this->lang->line("Message is required"); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke">
                <button id="send_test_email" class="btn btn-primary"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Send"); ?></button>
                <button type="button" onclick="javascript:window.location.reload()" class="btn btn-secondary"
                        data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>