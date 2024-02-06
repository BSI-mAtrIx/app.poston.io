<?php
//todo: 000000 before release
?>
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


<style type="text/css">
    .multi_layout {
        margin: 0;
        background: #fff
    }

    .multi_layout .card {
        margin-bottom: 0;
        border-radius: 0;
    }

    .multi_layout p, .multi_layout ul:not(.list-unstyled), .multi_layout ol {
        line-height: 15px;
    }

    .multi_layout .list-group li {
        padding: 15px 10px 12px 25px;
    }

    .multi_layout {
        border: .5px solid #dee2e6;
    }

    .multi_layout .collef, .multi_layout .colmid {
        padding-left: 0px;
        padding-right: 0px;
        border-right: .5px solid #dee2e6;
    }

    .multi_layout .colmid .card-icon {
        border: .5px solid #dee2e6;
    }

    .multi_layout .colmid .card-icon i {
        font-size: 30px !important;
    }

    .multi_layout .main_card {
        box-shadow: none;
    }

    .multi_layout .collef .makeScroll {
        max-height: 550px;
        overflow: auto;
    }

    .multi_layout .list-group .list-group-item {
        border-radius: 0;
        border: .5px solid #dee2e6;
        border-left: none;
        border-right: none;
        cursor: pointer;
        z-index: 0;
    }

    .multi_layout .list-group .list-group-item:first-child {
        border-top: none;
    }

    .multi_layout .list-group .list-group-item:last-child {
        border-bottom: none;
    }

    .multi_layout .list-group .list-group-item.active {
        border: .5px solid #6777EF;
    }

    .multi_layout .mCSB_inside > .mCSB_container {
        margin-right: 0;
    }

    .multi_layout .card-statistic-1 {
        border: .5px solid #dee2e6;
        border-radius: 4px;
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

    .subscriber_info_modal {
        cursor: pointer;
    }

    .product-item {
        text-align: center;
    }

    .product-image img {
        max-width: 65px;
    }

    .product-name {
        font-size: 14px !important;
        margin-top: 15px;
    }

    .product-cta {
        margin-top: 10px;
    }

    #middle_column_content .card-wrap h4 {
        font-size: 1rem !important;
    }

    div.tooltip {
        top: 0px !important;
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


<?php if (empty($page_info)) { ?>

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

    <?php
} else { ?>
    <div class="row multi_layout">

        <div class="col-12 col-md-5 col-lg-3 collef">
            <div class="card main_card">
                <div class="card-header">
                    <div class="col-6 p-0">
                        <h4><i class="bx bx-news"></i> <?php echo $this->lang->line("Pages"); ?></h4>
                    </div>
                    <div class="col-6 p-0">
                        <input type="text" class="form-control float-right" id="search_page_list"
                               onkeyup="search_in_ul(this,'page_list_ul')" autofocus
                               placeholder="<?php echo $this->lang->line('Search...'); ?>">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="makeScroll">
                        <ul class="list-group" id="page_list_ul">
                            <?php
                            $i = 0;
                            foreach ($page_info as $value) {

                                $last_lead_sync = $this->lang->line("Never");
                                if ($value['last_lead_sync'] != '0000-00-00 00:00:00') $last_lead_sync = date_time_calculator($value['last_lead_sync'], true);
                                ?>
                                <li class="list-group-item page_list_item" page_table_id="<?php echo $value['id']; ?>">
                                    <div class="row">
                                        <div class="col-3 col-md-2 p-0"><img
                                                    onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                                                    width="45px" class="rounded-circle img_fb_onerror"
                                                    src="<?php echo $value['page_profile']; ?>"></div>
                                        <div class="col-9 col-md-10">
                                            <h6 class="page_name"><?php echo $value['page_name']; ?><?php echo $value['has_instagram'] == "1" ? "(" . $value['insta_username'] . ")" : ""; ?></h6>
                                            <span class="gray"><?php echo $value['page_id']; ?></span>
                                            <p class="font-small-2 mb-0" data-toggle="tooltip"
                                               title="<?php echo $this->lang->line('Last Scanned') ?>"><i
                                                        class="bx bx-time font-small-2"></i> <?php echo $last_lead_sync; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-7 col-lg-9 colmid" id="middle_column">

            <div class="text-center waiting">
                <i class="bx bx-loader-alt bx-spin blue text-center"></i>
            </div>

            <div id="middle_column_content"></div>

        </div>


    </div>
    <?php
} ?>


<?php
$disabledsuccessfully = $this->lang->line("Backgound scanning has been disabled successfully.");
$enabledsuccessfully = $this->lang->line("Backgound scanning has been enabled successfully.");
$youhavenotselected = $this->lang->line("You have not selected any subscriber to assign label. You can choose upto");
$leadsatatime = $this->lang->line("subscribers at a time.");
$youcanselectupto = $this->lang->line("You can select upto");
$leadsyouhaveselected = $this->lang->line(",you have selected");
$leads = $this->lang->line("subscribers.");
$youhavenotselectedanyleadtoassigngroup = $this->lang->line("You have not selected any subscriber to assign label.");
$youhavenotselectedanyleadgroup = $this->lang->line("You have not selected any label.");
$groupshavebeenassignedsuccessfully = $this->lang->line("Labels have been assigned successfully");
?>


<div class="modal fade" id="htm" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-user-check"></i> <?php echo $this->lang->line("Subscriber List"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body data-card">
                <div class="row">
                    <!-- <div class="col-12 waiting_response"></div> -->
                    <div class="col-12 col-md-9">
                        <?php echo
                            '<div class="input-group mb-3" id="searchbox">
                       <input type="text" class="form-control" id="search_value" name="search_value" placeholder="' . $this->lang->line("Search...") . '" style="max-width:50%;">
                        <div class="input-group-prepend" id="put_page_label_list">
                          
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="search_subscriber"><i class="bx bx-search"></i> ' . $this->lang->line("Search") . '</button>
                        </div>
                      </div>'; ?>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="dropdown dropleft large">
                            <button class="btn btn-primary dropdown-toggle float-right" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $this->lang->line('Options'); ?>
                            </button>
                            <div class="dropdown-menu large">
                                <a class="dropdown-item" href="#" button_id="" id="assign_group"><i
                                            class="bx bx-tag mr-1"></i> <?php echo $this->lang->line('Assign Label'); ?>
                                </a>
                                <a class="dropdown-item" href="#" id="download_list"><i
                                            class="bx bx-cloud-download mr-1"></i> <?php echo $this->lang->line('Download Full List'); ?>
                                </a>
                                <a class="dropdown-item" href="#" button_id="" id="migrate_list"><i
                                            class="bx bx-export mr-1"></i> <?php echo $this->lang->line('Migrate Full List to Bot'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
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
                                    <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                                    <th><?php echo $this->lang->line("Subscriber Name"); ?></th>
                                    <th><?php echo $this->lang->line("Label/Tag"); ?></th>
                                    <th><?php echo $this->lang->line("Thread ID"); ?></th>
                                    <th><?php echo $this->lang->line("Actions"); ?></th>
                                    <th><?php echo $this->lang->line("Synced at"); ?></th>
                                    <!-- <th><?php echo $this->lang->line("Status"); ?></th> -->
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

<div class="modal fade" id="import_lead_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-code-alt"></i> <?php echo $this->lang->line("Scan Page Inbox"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
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
                                        <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                           title=""
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
                                    echo form_dropdown('lead_limit', $scan_drop, '', 'class="select2 form-control" id="scan_limit" style="width:100%;"'); ?>
                                </div>

                                <div class="form-group col-12 col-lg-6" id="folder_con">
                                    <label>
                                        <?php echo $this->lang->line("Folder"); ?>
                                        <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                           title=""
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
                                    echo form_dropdown('folder', $scan_drop, '', 'class="select2 form-control" id="folder" style="width:100%;"'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default  " data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                <button type="button" class="btn btn-primary" id="start_scanning"><i
                            class="bx bx-check-circle"></i> <?php echo $this->lang->line("Start Scanning"); ?></button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="assign_group_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-tag"></i> <?php echo $this->lang->line("Assign Label"); ?></h3>
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


<div class="modal fade" id="subscriber_info_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-group"></i> <?php echo $this->lang->line("Subscribers"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
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