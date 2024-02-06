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

<?php $this->load->view('admin/theme/message'); ?>

<style type="text/css">
    #page_id {
        width: 120px;
    }

    #label_id {
        width: 100px;
    }

    .bbw {
        border-bottom-width: thin !important;
        border-bottom: solid .5px #f9f9f9 !important;
        padding-bottom: 20px;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 80px;
        }

        #label_id {
            width: 80px;
        }
    }

    .flex-column .nav-item .nav-link.active {
        background: #fff !important;
        color: #3516df !important;
        border: 1px solid #988be1 !important;
    }

    .flex-column .nav-item .nav-link .form_id, .flex-column .nav-item .nav-link .insert_date {
        color: #608683 !important;
        font-size: 12px !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
    }

    #middle_column_content_title {
        text-transform: none;
    }

    #middle_column_content_body h4 {
        width: 100%;
    }

    #middle_column_content_body .card-statistic-1 {
        min-height: 134px;
    }

</style>

<?php if(empty($page_info)) { ?>
    <div class="col-12 mb-1">
        <?php if ($selected_global_media_type == 'fb') { ?>
            <a href="#" class="btn btn-primary social_switch"
               data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>
        <?php } else { ?>
            <a href="#" class="btn btn-primary social_switch"
               data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>
        <?php } ?>
    </div>
    <div class="card" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-fluid" style="height: 200px"
                     src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("We could not find any page."); ?></h2>
                <p class="lead"><?php echo $this->lang->line("Please import account if you have not imported yet.") . "<br>" . $this->lang->line("If you have already imported account then enable bot connection for one or more page to continue.") ?></p>
                <a href="<?php echo base_url('social_accounts'); ?>" class="btn btn-outline-primary mt-4"><i
                            class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line("Continue"); ?></a>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="row">
    <div class="col-sm-12 col-md-6">
        <fieldset class="form-group" id="store_list_field">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"
                       for="bot_list_select"><?php if ($this->session->userdata('selected_global_media_type') == 'ig') echo $this->lang->line("Accounts"); else echo $this->lang->line("Pages"); ?></label>
            </div>
            <select class="form-control select2" id="bot_list_select">

                <?php
                $i = 0;
                $current_store_data = array();
                foreach ($page_info as $value) {
                    $last_lead_sync = $this->lang->line("Never");
                    if ($value['last_lead_sync'] != '0000-00-00 00:00:00') $last_lead_sync = date_time_calculator($value['last_lead_sync'], true);

                    ?>
                    <option value="<?php echo $value['id']; ?>" <?php if ($i == 0 || $value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>><?php
                        if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")) {
                            if (isset($media_type) && $media_type == "ig") {
                                echo $value['insta_username'] . " [" . $value['page_name'] . "]" . ' ' . $this->lang->line('Last Scanned') . ' ' . $last_lead_sync;
                            } else {
                                echo $value['page_name'] . ' ' . $this->lang->line('Last Scanned') . ' ' . $last_lead_sync;
                            }
                        } else {
                            echo $value['page_name'] . ' ' . $this->lang->line('Last Scanned') . ' ' . $last_lead_sync;
                        }

                        ?></option>

                    <?php $i++;
                } ?>
            </select>
        </div>
    </fieldset>
    </div>
        <div class="col-sm-12 col-md-6">
            <?php if ($selected_global_media_type == 'fb') { ?>
                <a href="#" class="btn btn-primary social_switch"
                   data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>
            <?php } else { ?>
                <a href="#" class="btn btn-primary social_switch"
                   data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>
            <?php } ?>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body data-card">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <?php

                                echo
                                    '<div class="input-group mb-3 " id="searchbox">


                          <div class="input-group-prepend" id="label_dropdown">
                         </div>


                  <div class="input-group-prepend">
                    <select class="select2 form-control" id="gender" name="gender">
                      <option value="">' . $this->lang->line("Gender") . '</option>
                      <option value="male">' . $this->lang->line("Male") . '</option>
                      <option value="female">' . $this->lang->line("Female") . '</option>
                    </select>
                  </div>

                  <select class="select2 form-control" id="email_phone_birth" name="email_phone_birth[]" multiple="multiple" style="max-width:40%;">
                    <option value="has_phone">' . $this->lang->line("Has Phone") . '</option>
                    <option value="has_email">' . $this->lang->line("Has Email") . '</option>
                    <option value="has_birthdate">' . $this->lang->line("Has Birth Date") . '</option>
                  </select>

                  <input type="text" class="form-control" autofocus id="search_value" name="search_value" placeholder="' . $this->lang->line("Search...") . '" style="max-width:30%;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_subscriber"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
                  </div>
                </div>'; ?>
                            </div>

                            <div class="col-12 col-md-2">

                                <div class="btn-group dropleft float-right">
                                    <button type="button"
                                            class="btn btn-primary float-right has-icon-left btn-icon dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo $this->lang->line("Options"); ?>
                                    </button>
                                    <div class="dropdown-menu dropleft">
                                        <a class="dropdown-item" href="#" button_id="" id="migrate_list"><i
                                                    class="bx bx-cloud-download pr-1"></i> <?php echo $this->lang->line('Migrate page conversations as subscribers'); ?>
                                        </a>
                                        <a class="dropdown-item"
                                           href="<?php echo base_url('subscriber_manager/download_result'); ?>"><i
                                                    class="bx bx-cloud-download pr-1"></i> <?php echo $this->lang->line("Download Result"); ?>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" id="assign_group" href=""><i
                                                    class="bx bx-tag pr-1"></i> <?php echo $this->lang->line("Assign labels to selected subscribers"); ?>
                                        </a>


                                        <?php if ($this->sms_email_drip_exist) : ?>
                                            <?php if ($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array(270, 271))) > 0) : ?>
                                                <a class="dropdown-item" id="assign_sms_email_sequence" href=""><i
                                                            class="bx bx-plug pr-1"></i> <?php echo $this->lang->line("Assign Sequence"); ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item red" id="bulk_delete_contact" href=""><i
                                                    class="bx bx-trash pr-1"></i> <?php echo $this->lang->line("Delete Subscriber"); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="multi_layout2">
                            <div id="middle_column">
                                <div class="card" id="middle_column_content">
                                    <div class="card-header">
                                        <h4 class="card-title" id="middle_column_content_title"></h4>
                                    </div>
                                    <div class="card-body" id="middle_column_content_body"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-md-9">

                                <div class="table-responsive2">
                                    <input type="hidden" id="put_page_id">
                                    <table class="table table-bordered" id="mytable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="vertical-align:middle;width:20px">
                                                <input class="regular-checkbox" id="datatableSelectAllRows"
                                                       type="checkbox"/><label for="datatableSelectAllRows"></label>
                                            </th>
                                            <th><?php echo $this->lang->line("Avatar"); ?></th>
                                            <th><?php echo addon_exist($module_id = 320, $addon_unique_name = "instagram_bot") ? $this->lang->line("Page/Account") : $this->lang->line("Page Name"); ?></th>
                                            <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                                            <th><?php echo $this->lang->line("First Name"); ?></th>
                                            <th><?php echo $this->lang->line("Last Name"); ?></th>
                                            <th><?php echo $this->lang->line("Full Name"); ?></th>
                                            <th><?php echo $this->lang->line("Actions"); ?></th>
                                            <th><?php echo $this->lang->line("Quick Info"); ?></th>
                                            <th><?php echo $this->lang->line("Label/Tag"); ?></th>
                                            <th><?php echo $this->lang->line("Thread ID"); ?></th>
                                            <th><?php echo $this->lang->line("Synced at"); ?></th>
                                            <th><?php echo $this->lang->line("Social Media"); ?></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card no_shadow">
                                    <div class="card-body data-card py-0 px-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <a class="btn btn-outline-primary add_label btn-block  mb-1" href="#">
                                                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Label"); ?>
                                                </a>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group float-left" id="searchbox">
                                                    <input type="text" class="form-control" id="searching"
                                                           name="searching" autofocus
                                                           placeholder="<?php echo $this->lang->line('Search Labels...'); ?>"
                                                           aria-label="" aria-describedby="basic-addon2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive2">
                                            <table class="table table-bordered bg-white" id="mytablelabel"
                                                   style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo $this->lang->line("ID"); ?></th>
                                                    <th><?php echo $this->lang->line("Label"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>


        </div>

    </div>

    </div>


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

        .multi_layout2 {
            margin: 0;
            background: #fff
        }

        .multi_layout2 .card {
            margin-bottom: 0;
            border-radius: 0;
        }

        .multi_layout2 p, .multi_layout2 ul:not(.list-unstyled), .multi_layout2 ol {
            line-height: 15px;
        }

        .multi_layout2 .list-group li {
            padding: 15px 10px 12px 25px;
        }

        .multi_layout2 {
            border: .5px solid #dee2e6;
        }

        .multi_layout2 .collef, .multi_layout2 .colmid {
            padding-left: 0px;
            padding-right: 0px;
            border-right: .5px solid #dee2e6;
        }

        .multi_layout2 .colmid .card-icon {
            border: .5px solid #dee2e6;
        }

        .multi_layout2 .colmid .card-icon i {
            font-size: 30px !important;
        }

        .multi_layout2 .main_card {
            box-shadow: none;
        }

        .multi_layout2 .collef .makeScroll {
            max-height: 550px;
            overflow: auto;
        }

        .multi_layout2 .list-group .list-group-item {
            border-radius: 0;
            border: .5px solid #dee2e6;
            border-left: none;
            border-right: none;
            cursor: pointer;
            z-index: 0;
        }

        .multi_layout2 .list-group .list-group-item:first-child {
            border-top: none;
        }

        .multi_layout2 .list-group .list-group-item:last-child {
            border-bottom: none;
        }

        .multi_layout2 .list-group .list-group-item.active {
            border: .5px solid #6777EF;
        }

        .multi_layout2 .mCSB_inside > .mCSB_container {
            margin-right: 0;
        }

        .multi_layout2 .card-statistic-1 {
            border: .5px solid #dee2e6;
            border-radius: 4px;
        }

        .multi_layout2 h6.page_name {
            font-size: 14px;
        }

        .multi_layout2 .card .card-header input {
            max-width: 100% !important;
        }

        .multi_layout2 .card .card-header h4 a {
            font-weight: 700 !important;
        }

        .multi_layout2 .card-primary {
            margin-top: 35px;
            margin-bottom: 15px;
        }

        .multi_layout2 .product-details .product-name {
            font-size: 12px;
        }

        .multi_layout2 .margin-top-50 {
            margin-top: 70px;
        }

        .multi_layout2 .waiting {
            height: 100%;
            width: 100%;
            display: table;
        }

        .multi_layout2 .waiting i {
            font-size: 60px;
            display: table-cell;
            vertical-align: middle;
            padding: 30px 0;
        }

        .subscriber_info_modal {
            cursor: pointer;
        }
    </style>

    <div class="modal fade" id="assign_group_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i class="bx bx-tag"></i> <?php echo $this->lang->line("Assign Label"); ?>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="get_labels">
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary float-left" href="" id="assign_group_submit"><i
                                class="bx bx-tag"></i> <?php echo $this->lang->line("Assign Label") ?></a>
                    <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Close") ?></a>
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
                         style="padding:20px;margin-bottom:20px;border:.5px solid #dee2e6; color:#6777ef;background: #fff;"><?php echo $this->lang->line("Bulk sequence assign is available for Email & SMS cmapaign. For Messenger, bulk campaign isn't available due to safety & avoiding breaking 24 Hours policy. "); ?></div>
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

    <div class="modal fade" id="subscriber_actions_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="padding:15px;">
                    <h3 class="modal-title"><?php echo $this->lang->line("Subscriber Actions"); ?></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>

                <div class="modal-body" id="subscriber_actions_modal_body" style="padding:0 15px 15px 15px;"
                     data-backdrop="static" data-keyboard="false">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="default-tab" data-toggle="tab" href="#default" role="tab"
                               aria-controls="default"
                               aria-selected="true"><?php echo $this->lang->line("Subscriber Data"); ?></a>
                        </li>

                        <?php if ($user_input_flow_exist == 'yes') : ?>
                            <li class="nav-item">
                                <a class="nav-link" id="flowanswers-tab" data-toggle="tab" href="#flowanswers"
                                   role="tab" aria-controls="flowanswers"
                                   aria-selected="false"><?php echo $this->lang->line("User Input Flow Answer"); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="customfields-tab" data-toggle="tab" href="#customfields"
                                   role="tab" aria-controls="customfields"
                                   aria-selected="false"><?php echo $this->lang->line("Custom Fields"); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($webview_access == 'yes') : ?>
                            <li class="nav-item">
                                <a class="nav-link" id="formdata-tab" data-toggle="tab" href="#formdata" role="tab"
                                   aria-controls="formdata"
                                   aria-selected="false"><?php echo $this->lang->line("Custom Form Data"); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($ecommerce_exist == 'yes') : ?>
                            <li class="nav-item">
                                <a class="nav-link" id="purchase-tab" data-toggle="tab" href="#purchase" role="tab"
                                   aria-controls="purchase"
                                   aria-selected="false"><?php echo $this->lang->line("Purchase History"); ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade active show" id="default" role="tabpanel"
                             aria-labelledby="default-tab">
                            <div class="row multi_layout">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="formdata" role="tabpanel" aria-labelledby="formdata-tab">
                            <div class="card shadow-none"
                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                                <div class="card-body">
                                    <div class="row formdata_div" style="padding-top:20px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="flowanswers" role="tabpanel" aria-labelledby="flowanswers-tab">
                            <div class="card shadow-none"
                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                                <div class="card-body">
                                    <div class="row flowanswers_div" style="padding-top:20px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="customfields" role="tabpanel" aria-labelledby="customfields-tab">
                            <div class="card shadow-none"
                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                                <div class="card-body">
                                    <div class="row customfields_div" style="padding-top:20px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                            <div class="card shadow-none data-card"
                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">
                                <div class="card-body">
                                    <div class="row purchase_div" style="padding-top:20px;"></div>
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <?php
                                            $status_list[''] = $this->lang->line("Status");
                                            echo
                                                '<div class="input-group mb-3" id="searchbox">
                            <div class="input-group-prepend d-none">
                              <input type="text" value="" name="search_subscriber_id" id="search_subscriber_id">
                            </div>
                            <div class="input-group-prepend d-none">
                              ' . form_dropdown('search_status', $status_list, '', 'class="select2 form-control" id="search_status"') . '
                            </div>
                            <input type="text" class="form-control" id="search_value2" autofocus name="search_value2" placeholder="' . $this->lang->line("Search...") . '" style="max-width:25%;">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="button" id="search_action"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
                            </div>
                          </div>'; ?>
                                        </div>

                                        <div class="col-12 col-md-3">

                                            <?php
                                            echo $drop_menu = '<a href="javascript:;" id="search_date_range" class="btn btn-primary float-right has-icon-left btn-icon"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="search_date_range_val">';
                                            ?>


                                        </div>
                                    </div>

                                    <div class="table-responsive2">
                                        <table class="table table-bordered" id="mytable2">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="vertical-align:middle;width:20px">
                                                    <input class="regular-checkbox" id="datatableSelectAllRows"
                                                           type="checkbox"/><label for="datatableSelectAllRows"></label>
                                                </th>
                                                <th style="max-width: 130px"><?php echo $this->lang->line("Status") ?></th>
                                                <th><?php echo $this->lang->line("Coupon") ?></th>
                                                <th><?php echo $this->lang->line("Amount") ?></th>
                                                <th><?php echo $this->lang->line("Currency") ?></th>
                                                <th><?php echo $this->lang->line("Method") ?></th>
                                                <th><?php echo $this->lang->line("Transaction ID") ?></th>
                                                <th><?php echo $this->lang->line("Invoice") ?></th>
                                                <th><?php echo $this->lang->line("Docs") ?></th>
                                                <th><?php echo $this->lang->line("Ordered at") ?></th>
                                                <th><?php echo $this->lang->line("Paid at") ?></th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="add_label" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="min-width: 30%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i
                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Label") ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="add_label_modal_body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="bx bx-tag"></i> <?php echo $this->lang->line('Label Name'); ?></label>
                                <input type="text" name="group_name" id="group_name" class="form-control">
                                <span id="name_err" class="red"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="result_status"></div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-secondary" data-dismiss="modal"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
                    <button id="create_label_main" type="button" class="btn  btn-primary"><i
                                class="bx bx-save"></i> <?php echo $this->lang->line('Save'); ?></button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="import_lead_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-qr"></i> <?php echo $this->lang->line("Scan Page Inbox"); ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col-12">
                            <div id="import_lead_body">
                                <div id="scan_load"></div>
                                <br>
                                <div class="row">
                                    <div class="form-group col-12 col-lg-6">
                                        <label>
                                            <?php echo $this->lang->line("Scan Latest Leads"); ?>
                                            <a href="#" data-placement="right" data-toggle="popover"
                                               data-trigger="focus" title=""
                                               data-content="<?php echo $this->lang->line('Scanning process scans your page conversation and import them as subscriber. We strongly recommend to use cron based scanning feature for first time, if your page conversation is huge. After importing all subscribers, the cron feature will not import any future new subscribers, you have to scan for latest subscribers manually occasionally using the scan limit feature. Although you can enable the cron based scanning again manually but be informed that it will rescan the full page conversation. If you are scanning for first time and your inbox conversation is moderate, then you can scan all of them at once. To get future new subscribers scan occasionally same as stated earlier.'); ?>"
                                               data-original-title="<?php echo $this->lang->line('Scan Latest Leads'); ?>"><i
                                                        class="bx bx-info-circle"></i> </a>
                                        </label>
                                        <?php
                                        $scan_drop =
                                            array
                                            (
                                                '' => $this->lang->line("Scan all subscribers"),
                                                "500" => "500 " . $this->lang->line("Subscribers"),
                                                "1000" => "1000 " . $this->lang->line("Subscribers"),
                                                "2000" => "2000 " . $this->lang->line("Subscribers"),
                                                "3000" => "3000 " . $this->lang->line("Subscribers"),
                                                "5000" => "5000 " . $this->lang->line("Subscribers"),
                                                "10000" => "10000 " . $this->lang->line("Subscribers"),
                                                "20000" => "20000 " . $this->lang->line("Subscribers"),
                                                "30000" => "30000 " . $this->lang->line("Subscribers"),
                                                "50000" => "50000 " . $this->lang->line("Subscribers"),
                                                "100000" => "100000 " . $this->lang->line("Subscribers")
                                            );
                                        echo form_dropdown('lead_limit', $scan_drop, '', 'class="form-control select2" id="scan_limit" style="width:100%;"'); ?>
                                    </div>

                                    <div class="form-group col-12 col-lg-6" id="folder_con">
                                        <label>
                                            <?php echo $this->lang->line("Folder"); ?>
                                            <a href="#" data-placement="right" data-toggle="popover"
                                               data-trigger="focus" title=""
                                               data-content="<?php echo $this->lang->line('The target folder from which to retrieve conversations.'); ?>"
                                               data-original-title="<?php echo $this->lang->line('Folder'); ?>"><i
                                                        class="bx bx-info-circle"></i> </a>
                                        </label>
                                        <?php
                                        $scan_drop =
                                            array
                                            (
                                                "inbox" => $this->lang->line("Inbox"),
                                                "page_done" => $this->lang->line("Done"),
                                                "spam" => $this->lang->line("Spam"),
                                                "other" => $this->lang->line("Other")
                                            );
                                        echo form_dropdown('folder', $scan_drop, '', 'class="form-control select2" id="folder" style="width:100%;"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default  " data-dismiss="modal"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Close"); ?></button>
                    <button type="button" class="btn btn-primary " id="start_scanning"><i
                                class="bx bx-check-circle"></i> <?php echo $this->lang->line("Start Scanning"); ?>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="subscriber_info_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-user"></i> <?php echo $this->lang->line("Subscribers"); ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="section">
                        <h2 class="section-title"><?php echo $this->lang->line('Conversation Subscribers'); ?></h2>
                        <p><?php echo $this->lang->line("Conversation Subscribers are, who have conversation in your page inbox. These users may come from Messenger Bot, Comment Private Reply, Click to Messenger Ads or Send Message CTA Post.  These users are eligible to get Conversation Broadcast message. Even if after getting private reply, users doesn't reply back will be counted for Conversation Broadcast."); ?></p>
                    </div>
                    <div class="section">
                        <h2 class="section-title"><?php echo $this->lang->line('BOT Subscribers'); ?></h2>
                        <p><?php echo $this->lang->line("BOT Subscribers are those users who have given message & get reply from Messenger BOT after enabling in our system. However you can also migrate Conversation Subscribers (Existing Subscribers) to BOT subscribers. In this case BOT subscribers are those who have given message to your page. BOT subscribers may less than Conversation subscribers for different reason like"); ?></p>
                        <ol>
                            <li><?php echo $this->lang->line("The user deactivated their account."); ?></li>
                            <li><?php echo $this->lang->line("The user blocked your page."); ?></li>
                            <li><?php echo $this->lang->line("The user don't have activity for long days with your page."); ?></li>
                            <li><?php echo $this->lang->line("The user may in conversation subscriber list as got private reply of comment but never reply may not eligible for BOT Subscriber."); ?></li>
                        </ol>
                    </div>
                    <div class="section">
                        <h2 class="section-title"><?php echo $this->lang->line('24H Subscribers'); ?></h2>
                        <p><?php echo $this->lang->line("Those users who interacted with your messenger bot within 24 hours. This subscribers are eligible to get promotional message through Subscriber Broadcast."); ?></p>
                    </div>
                    <div class="section">
                        <h2 class="section-title"><?php echo $this->lang->line('Unavailable'); ?></h2>
                        <p><?php echo $this->lang->line("You may find red color number as unavailable beside both Conversation Subscribers & BOT Subscribers means the number of users are unavailable for broadcast, because in last broadcasting campaign, Facebook responded with error during sending message to them. They will not be eligible for future broadcast campaign. However once that user send message to your page again, then user become available again."); ?></p>
                    </div>
                    <div class="section">
                        <h2 class="section-title"><?php echo $this->lang->line('Migrated Subscribers'); ?></h2>
                        <p><?php echo $this->lang->line("Those subscribers are migrated as BOT subscribers from Conversation Subscribers. These are basically all old subscribers achieved before using our system for Messenger BOT."); ?></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Close") ?></a>
                </div>

            </div>
        </div>
    </div>

    <style type="text/css">
        .chocolat-wrapper {
            z-index: 1060 !important;
        }
    </style>

<?php } ?>