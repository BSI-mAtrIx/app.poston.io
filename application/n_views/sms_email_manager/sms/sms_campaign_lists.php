<?php
/* include universal js */
$include_js_uni = "application/n_views/sms_email_manager/sms/sms_section_global_js.php";
?>
<link rel="stylesheet"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/file-uploaders/dropzone.min.css?ver=<?php echo $n_config['theme_version']; ?>">
<?php $this->load->view('admin/theme/message'); ?>
<?php
//TODO: check modals
$include_dropzone = 1;
?>
<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    #searching_campaign {
        max-width: 50% !important;
    }

    #campaign_status {
        width: 110px !important;
    }

    @media (max-width: 575.98px) {
        #searching_campaign {
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
                                href="<?php echo base_url("messenger_bot_broadcast"); ?>"><?php echo $this->lang->line("Broadcasting"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url('sms_email_manager/create_sms_campaign'); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New SMS Campaign"); ?>
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
                            <div class="input-group mb-3 float-left" id="searchbox">
                                <!-- search by post type -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="campaign_status" name="campaign_status">
                                        <option value=""><?php echo $this->lang->line("Status"); ?></option>
                                        <option value="0"><?php echo $this->lang->line("Pending"); ?></option>
                                        <option value="1"><?php echo $this->lang->line("Processing"); ?></option>
                                        <option value="2"><?php echo $this->lang->line("Completed"); ?></option>
                                    </select>
                                </div>
                                <input type="text" class="form-control" id="searching_campaign"
                                       name="searching_campaign" autofocus
                                       placeholder="<?php echo $this->lang->line('Search...'); ?>" aria-label=""
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="sms_search_submit"
                                            title="<?php echo $this->lang->line('Search'); ?>" type="button"><i
                                                class="bx bx-search"></i> <span
                                                class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="javascript:;" id="post_date_range"
                               class="btn btn-primary float-right has-icon-left btn-icon"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="post_date_range_val">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable_sms_campaign">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("ID"); ?></th>
                                        <th><?php echo $this->lang->line("Name"); ?></th>
                                        <th><?php echo $this->lang->line("SMS API"); ?></th>
                                        <th><?php echo $this->lang->line("Total Sent"); ?></th>
                                        <th><?php echo $this->lang->line('Actions'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th><?php echo $this->lang->line('Scheduled at'); ?></th>
                                        <th><?php echo $this->lang->line('Created at'); ?></th>
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
    </div>

</div>


<!-- Report Modal (deprecated) -->
<div class="modal fade" id="campaign_report_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-bullseye"></i> <?php echo $this->lang->line("Campaign Report") ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="sent_report_body">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="bx bxs-help-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4><?php echo $this->lang->line('Campaign'); ?> (<span id="posting_status"></span>)
                                    </h4>
                                </div>
                                <div class="card-body" id="sms_campaign_name"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="bx bx-plug"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4><?php echo $this->lang->line('SMS API'); ?></h4>
                                </div>
                                <div class="card-body" id="api_name"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="bx bx-paper-plane"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4><?php echo $this->lang->line('Sent'); ?></h4>
                                </div>
                                <div class="card-body" id="sent_state"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="report_search" name="report_search" class="form-control"
                               placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>
                    </div>
                    <div class="col-6">
                        <div class="btn-group dropleft float-right" id="options_div">
                            <button type="button"
                                    class="btn btn-primary float-right has-icon-left btn-icon dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"> <?php echo $this->lang->line('Options'); ?> </button>
                            <div class="dropdown-menu dropleft">
                                <a class="dropdown-item has-icon pointer" id="edit_content" href=""><i
                                            class="bx bx-edit"></i> <?php echo $this->lang->line('Edit Content'); ?></a>
                                <a class="dropdown-item has-icon pointer restart_button" id="restart_button" table_id=""
                                   href=""><i class="bx bx-sync"></i> <?php echo $this->lang->line('Force Resume'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive2 data-card">
                            <input type="hidden" id="put_row_id">
                            <table class="table table-bordered" id="mytable_campaign_report">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('#'); ?></th>
                                    <th><?php echo $this->lang->line('id'); ?></th>
                                    <th><?php echo $this->lang->line("First Name"); ?></th>
                                    <th><?php echo $this->lang->line("Last Name"); ?></th>
                                    <th><?php echo $this->lang->line("Phone"); ?></th>
                                    <th><?php echo $this->lang->line('Sent At'); ?></th>
                                    <th><?php echo $this->lang->line('Response'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class='section'>
                    <div class='section-title'>
                        <?php echo $this->lang->line('Original Message'); ?>
                    </div>
                    <div class='alert alert-light' id="original_message"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="sms_logs_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-list-ul"></i> <?php echo $this->lang->line("SMS History") ?></h5>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-light alert-dismissible show fade" id="message_div">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert"><span>×</span></button>
                                This is a light alert.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="javascript:;" id="sms_log_date_range" class="btn btn-primary float-right has-icon-left btn-icon"><i class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?></a>
                        <input type="hidden" id="sms_log_date_range_val">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive2 data-card">
                            <table class="table table-bordered" id="mytable_sms_logs">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('#'); ?></th>
                                        <th><?php echo $this->lang->line('id'); ?></th>
                                        <th><?php echo $this->lang->line("SMS API"); ?></th>
                                        <th><?php echo $this->lang->line("Send To"); ?></th>
                                        <th><?php echo $this->lang->line('Sent Time'); ?></th>
                                        <th><?php echo $this->lang->line("SMS UID"); ?></th>
                                        <th><?php echo $this->lang->line("Delivery Status"); ?></th>
                                        <th><?php echo $this->lang->line("Message"); ?></th>
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
    </div>
</div>
 -->

