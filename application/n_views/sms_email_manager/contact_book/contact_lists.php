<?php
/* include universal js */
$include_js_uni = "application/n_views/sms_email_manager/contact_book/contact_book_js.php";
?>
<link rel="stylesheet"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/file-uploaders/dropzone.min.css?ver=<?php echo $n_config['theme_version']; ?>">
<?php
//TODO: check modal
//TODO: forms icons
?>
<style>
    #contact_list_searching {
        max-width: 100% !important;
    }

    #group_id {
        width: 150px !important;
    }

    .dropzone {
        min-height: 0px !important;
    }

    .dz-message {
        margin: 65px !important;
    }

    .bbw {
        border-bottom-width: thin !important;
        border-bottom: solid .5px #f9f9f9 !important;
        padding-bottom: 20px;
    }

    .brTop {
        border-top: solid .5px #f9f9f9 !important;
    }

    @media (max-width: 575.98px) {
        #group_id {
            width: 130px !important;
        }

        #contact_list_searching {
            max-width: 77% !important;
        }
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
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("subscriber_manager"); ?>"><?php echo $this->lang->line("Subscriber Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary mb-1 add_new_contact">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Contact"); ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="input-group float-left" id="searchbox">
                                <!-- search by page name -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="group_id" name="group_id">
                                        <option value=""><?php echo $this->lang->line("Contact Group"); ?></option>
                                        <?php foreach ($contact_group_lists as $key => $value): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <input type="text" class="form-control" id="contact_list_searching"
                                       name="contact_list_searching"
                                       placeholder="<?php echo $this->lang->line('Search...'); ?>" aria-label=""
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="contact_list_search_submit"
                                            title="<?php echo $this->lang->line('Search'); ?>" type="button"><i
                                                class="bx bx-search"></i> <span
                                                class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="btn-group dropleft float-right">
                                <button type="button"
                                        class="btn btn-primary float-right has-icon-left btn-icon dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"> <?php echo $this->lang->line('Options'); ?> </button>
                                <div class="dropdown-menu dropleft">
                                    <a class="dropdown-item has-icon pointer" id="import_contact" href=""><i
                                                class="bx bx-cloud-download pr-1"></i> <?php echo $this->lang->line('Import'); ?>
                                    </a>
                                    <a class="dropdown-item has-icon pointer" id="export_contact" href=""><i
                                                class="bx bx-cloud-upload pr-1"></i> <?php echo $this->lang->line('Export'); ?>
                                    </a>

                                    <?php if ($this->sms_email_drip_exist) : ?>
                                        <?php if ($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array(270, 271))) > 0) : ?>
                                            <a class="dropdown-item has-icon pointer" id="assign_sms_email_sequence"
                                               href=""><i
                                                        class="bx bx-plug pr-1"></i> <?php echo $this->lang->line("Assign Sequence"); ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item has-icon pointer" id="delete_all_contacts" href=""><i
                                                class="bx bx-trash-alt pr-1"></i> <?php echo $this->lang->line('Delete'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/>
                                    <label for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("Contact ID"); ?></th>
                                <th><?php echo $this->lang->line("First Name"); ?></th>
                                <th><?php echo $this->lang->line("Last Name"); ?></th>
                                <th><?php echo $this->lang->line("Email"); ?></th>
                                <th><?php echo $this->lang->line("Phone"); ?></th>
                                <th><?php echo $this->lang->line("Contact Group"); ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
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


<div class="modal fade" id="add_contact_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width:60%;">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center">
                    <i class="bx bx-user-plus"></i> <?php echo $this->lang->line("New Contact"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form action="#" enctype="multipart/form-data" id="contact_add_form" method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('First Name'); ?></label>
                                        <input type="text" class="form-control" name="first_name" id="first_name">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Last Name'); ?></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Email'); ?></label>
                                        <input type="email" class="form-control" name="contact_email"
                                               id="contact_email">

                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Phone Number'); ?></label>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Contact Group'); ?>
                                            <a href="#" data-toggle='tooltip'
                                               title="<?php echo $this->lang->line("You Can select multiple contact group."); ?>"><i
                                                        class="bx bxs-help-circle"></i></a>
                                        </label>
                                        <select name="contact_group_name[]" id="contact_group_name" multiple
                                                class="select2 form-control" style="width:100%;">
                                            <?php
                                            foreach ($contact_group_lists as $key => $val) {
                                                echo "<option value='{$key}'>{$val}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Status") ?></label><br>
                                        <label class="custom-switch mt-2">
                                            <input type="checkbox" name="status" value="1" class="custom-switch-input"
                                                   checked>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description"><?php echo $this->lang->line('Active'); ?></span>
                                            <span class="red"><?php echo form_error('status'); ?></span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <div class="col-12 p-0">
                    <button class="btn btn-primary" id="save_contact" name="save_contact" type="button"><i
                                class="bx bxs-save"></i> <?php echo $this->lang->line("Save") ?> </button>
                    <a class="btn btn-light float-right" data-dismiss="modal" aria-hidden="true"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update_contact_form_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width:60%;">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center">
                    <i class="bx bx-user-edit"></i> <?php echo $this->lang->line("Update Contact"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="update_contact_modal_body"></div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <div class="col-12 p-0">
                    <button class="btn btn-primary" id="update_contact" name="update_contact" type="button"><i
                                class="bx bx-edit"></i> <?php echo $this->lang->line('Update'); ?></button>
                    <a class="btn btn-light float-right" data-dismiss="modal" aria-hidden="true"><i
                                class="bx bx-time"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></a></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="import_contacts_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="min-width:70%;">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title"><i
                            class="bx bx-cloud-upload"></i> <?php echo $this->lang->line('Import Contact (CSV)'); ?>
                </h3>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-primary btn-sm" target="_BLANK"
                   href="<?php echo base_url("assets/sample/contact_import_sample.csv"); ?>"><i
                            class="bx bx-save"></i> <?php echo $this->lang->line('Sample CSV'); ?></a>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <form action="#" method="POST" id="import_contact_csv" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('Contact Group'); ?></label>
                                        <select class="select2 form-control" multiple id="csv_group_id"
                                                name="csv_group_id[]" style="width:100%;">
                                            <?php foreach ($contact_group_lists as $key => $value): ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label"> <?php echo $this->lang->line('CSV File') ?>
                                            <a href="#" data-placement="top" data-toggle="popover"
                                               title="<?php echo $this->lang->line("Message"); ?>"
                                               data-content="<?php echo $this->lang->line("Upload your CSV file. You can see the original format of importing CSV file by downloading our Sample CSV file. Email/Phone number which are already added before will be ignored during importing if CSV file have them."); ?>"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <div id="dropzone" class="dropzone dz-clickable">
                                            <div class="dz-default dz-message" style="">
                                                <input class="form-control" name="csv_file" id="csv_file" placeholder=""
                                                       type="hidden">
                                                <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                                  style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-6"><br>
                        <div class="alert alert-light alert-has-icon">
                            <div class="alert-icon"><i class="bx bx-bulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title"><?php echo $this->lang->line('Message'); ?></div>
                                <?php echo $this->lang->line("If you used Microsoft Excel or any other spreadsheet program to fill up your contact CSV then please make sure the values were saved properly by opening the file with notepad or any other text editor. See the below image please."); ?>
                                <img src="<?php echo base_url("assets/images/sample.png") ?>" alt="sample_image"
                                     width="100%">
                            </div>
                        </div>

                    </div>

                    <div class="col-12" id="success_message_div">
                        <div class="alert alert-success">
                            <div id="success_message"></div>
                            <div id="contact_upload_error_file"></div>
                            <div id="upload_error_file_name" class="d-none"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke" id="import_contact_modal_footer">
                <button type="button" class="btn btn-primary" id="upload_imported_csv"><i
                            class="bx bx-cloud-upload"></i> <?php echo $this->lang->line('Import'); ?></button>
                <button type="button" class="btn btn-light float-right" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="assign_sqeuence_campaign_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style='min-width:40%;'>
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title"><i
                            class="bx bx-sort-numeric-up"></i> <?php echo $this->lang->line("Assign sms/email Sequence"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center"
                     style="padding:20px;margin-bottom:20px;border:.5px solid #dee2e6; color:#6777ef;background: #fff;"><?php echo $this->lang->line("Bulk sequence assign is available for Email & SMS cmapaign."); ?></div>
                <div id="sequence_campaigns"></div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <a class="btn btn-primary float-left" href="" id="assign_sequence_submit"><i
                            class="bx bxs-save"></i> <?php echo $this->lang->line("Assign Sequence") ?></a>
                <a class="btn btn-light float-right" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line("Close") ?></a>
            </div>
        </div>
    </div>
</div>

<?php
$modal_width = 'style="min-width:40%"';
if ($this->sms_email_drip_exist) {
    if ($this->basic->is_exist("modules", array("id" => 270)) && $this->basic->is_exist("modules", array("id" => 271))) {
        if ($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array('270', '271'))) != 0) {
            $modal_width = 'style="min-width:70%"';
        }
    }

}
?>

<style type="text/css">
    .multi_layout {
        margin: 0;
        background: #fff
    }

    .multi_layout .card {
        margin-bottom: 0;
        border-radius: 0;
    }

    .multi_layout {
        border: 1px solid #dee2e6;
        border-top-width: 0;
    }

    .multi_layout .collef {
        padding-left: 0px;
        padding-right: 0px;
        border-right: 1px solid #dee2e6;
    }

    .multi_layout .colmid {
        padding-left: 0px;
        padding-right: 0px;
    }

    .multi_layout .card-statistic-1 {
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }

    .multi_layout .main_card {
        min-height: 100%;
    }

    .multi_layout h6.page_name {
        font-size: 14px;
    }

    .multi_layout .card .card-header input {
        max-width: 100% !important;
    }

    .multi_layout .card .card-header h4 a {
        font-weight: 700 !important;
    }

    .multi_layout .card-primary {
        margin-top: 35px;
        margin-bottom: 15px;
    }

    .multi_layout .product-details .product-name {
        font-size: 12px;
    }

    .multi_layout .margin-top-50 {
        margin-top: 70px;
    }

    .multi_layout .waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .multi_layout .waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
    }

    .multi_layout .collef .bgimage {
        border-radius: 5px;
        height: 250px;
        background-position: 50% 50%;
        background-size: cover;
        min-width: 140px;
        background-repeat: no-repeat;
        display: block;
    }

    .multi_layout .collef .subscriber_details {
        padding-right: 20px;
    }

    .multi_layout .colmid .section-title {
        padding-bottom: 10px;
    }

    .tab-content > .tab-pane {
        padding: 0;
    }

    @media (max-width: 575.98px) {
        .multi_layout .collef {
            border-right: none !important;
        }
    }

    #notes {
        min-height: 100px;
    }
</style>


<div class="modal fade" id="contact_details_modal">
    <div class="modal-dialog" style="min-width:80%;">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-primary"><i
                            class="bx bxs-help-circle"></i> <?php echo $this->lang->line("Contact Details"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="details_body">
                </div>
            </div>
        </div>
    </div>
</div>