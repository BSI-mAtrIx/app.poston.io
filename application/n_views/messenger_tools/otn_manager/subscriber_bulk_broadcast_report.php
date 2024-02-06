<?php
//TODO: check modals

?>
<?php $this->load->view('admin/theme/message'); ?>
    <style>
        .show > .dropdown-menu {
            min-width: 300px !important;
            z-index: 999999;
            transform: translate3d(-300px, -15px, 0px) !important;
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
            <a href="<?php echo base_url('messenger_bot_broadcast/otn_create_subscriber_broadcast_campaign'); ?>"
               class="btn btn-primary mb-1">
                <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Campaign"); ?>
            </a>
        </div>
    </div>


    <style type="text/css">
        #search_page_id {
            width: 145px;
        }

        #search_status {
            width: 95px;
        }

        @media (max-width: 575.98px) {
            #search_page_id {
                width: 90px;
            }

            #search_status {
                width: 75px;
            }
        }

    </style>

<?php $status_options = array("" => $this->lang->line("Status"), "0" => $this->lang->line("Pending"), "1" => $this->lang->line("Processing"), "2" => $this->lang->line("Completed")) ?>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body data-card">
                        <div class="row">
                            <div class="col-12 col-md-9">
                                <?php echo
                                    '<div class="input-group mb-3" id="searchbox">
                  <div class="input-group-prepend">
                    ' . form_dropdown('search_page_id', $page_list, $this->session->userdata('selected_global_page_table_id'), 'class="select2 form-control" id="search_page_id"') . '
                  </div>
                  <div class="input-group-prepend">'; ?>

                                <select name="search_status" id="search_status" class="select2 form-control">
                                    <option value=""><?php echo $this->lang->line("status") ?></option>
                                    <option value="0"><?php echo $this->lang->line("Pending") ?></option>
                                    <option value="1"><?php echo $this->lang->line("Processing") ?></option>
                                    <option value="2"><?php echo $this->lang->line("Completed") ?></option>
                                    <option value="3"><?php echo $this->lang->line("Stopped") ?></option>
                                </select>
                            </div>

                            <input type="hidden" name="csrf_token" id="csrf_token"
                                   value="<?php echo $this->session->userdata('csrf_token_session'); ?>">


                            <?php
                            echo
                                '<input type="text" class="form-control" id="search_value" autofocus name="search_value" placeholder="' . $this->lang->line("Search...") . '" style="max-width:30%;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_action"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
                  </div>
                </div>'; ?>
                        </div>

                        <div class="col-12 col-md-3">

                            <?php
                            echo $drop_menu = '<a href="javascript:;" id="campaign_date_range" class="btn btn-primary float-right has-icon-left btn-icon"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="campaign_date_range_val">';
                            ?>


                        </div>
                    </div>

                    <div class="table-responsive2">
                        <input type="hidden" id="put_page_id">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("Name"); ?></th>
                                <th><?php echo $this->lang->line("Page Name") ?></th>
                                <th><?php echo $this->lang->line("Type") ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Subscriber"); ?></th>
                                <th><?php echo $this->lang->line("Sent"); ?></th>
                                <th><?php echo $this->lang->line("Delivered"); ?></th>
                                <th><?php echo $this->lang->line("Open"); ?></th>
                                <th><?php echo $this->lang->line("Scheduled at"); ?></th>
                                <th><?php echo $this->lang->line("Created at"); ?></th>
                                <th><?php echo $this->lang->line("Labels"); ?></th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="sent_report_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <?php
                    $delete_junk_data_after_how_many_days = $this->config->item("delete_junk_data_after_how_many_days");
                    if ($delete_junk_data_after_how_many_days == "") $delete_junk_data_after_how_many_days = 30;
                    ?>
                    <h3 class="modal-title"><i
                                class="bx bx-bullseye"></i> <?php echo $this->lang->line("Campaign Report"); ?>
                        <small>(<?php echo $this->lang->line("Details data shows for last") . " : " . $delete_junk_data_after_how_many_days . " " . $this->lang->line("days"); ?>
                            )</small></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>

                <div class="modal-body data-card">
                    <input type="hidden" id="hidden_cam_id">
                    <div id="sent_report_body"></div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable2">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("First Name"); ?></th>
                                <th><?php echo $this->lang->line("Last Name"); ?></th>
                                <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                                <th><?php echo $this->lang->line("Sent at"); ?></th>
                                <th><?php echo $this->lang->line("Delivered at"); ?></th>
                                <th><?php echo $this->lang->line("Opened at"); ?></th>
                                <th><?php echo $this->lang->line("Sent Response"); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
echo '
<div class="modal fade" id="error_message_learn" tabindex="-1" role="dialog" aria-labelledby="error_message_learn" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title"><i class="bx bx-bug"></i> ' . $this->lang->line("Common Error Message") . '</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="bx bx-x"></i>
        </button>
      </div>
      <div class="modal-body">

     <div class="section">               

        <h2 class="section-title"> ' . $this->lang->line("(#551) This person isn't available right now") . '</h2>
        <p>
        ' . $this->lang->line("This error messages comes from Facebook. The possible reasons are below") . ' : 
         <ol>
              <li>' . $this->lang->line("Subscriber deactivated their account.") . '</li>
              <li>' . $this->lang->line("Subscriber blocked your page.") . '</li>
              <li>' . $this->lang->line("Subscriber does not have activity for long days with your page.") . '</li>
              <li>' . $this->lang->line("The user may in conversation subscribers as got private reply of comment but never replied back.") . '</li>
              <li>' . $this->lang->line("APP may not have pages_messaging approval.") . '</li>
        </ol>
        ' . $this->lang->line("In this case system automatically mark the subscriber as unviable for future conversation broadcasting campaign. ") . '
        </p>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>'; ?>