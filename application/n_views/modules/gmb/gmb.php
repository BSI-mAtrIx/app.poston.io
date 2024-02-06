<?php
$include_upload = 1;  //upload_js
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
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("Location Information"); ?></h5>
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


<style type="text/css">
    .button-outline {
        background: #fff;
        border: .5px dashed #ccc;
    }

    .button-outline:hover {
        border: 1px dashed #6777EF !important;
        cursor: pointer;
    }

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

    .multi_layout .collef, .multi_layout .colmid, .multi_layout .colrig, .multi_layout .colend {
        padding-left: 0px;
        padding-right: 0px;
    }

    .multi_layout .collef, .multi_layout .colmid {
        border-right: .5px solid #dee2e6;
    }

    .multi_layout .main_card {
        min-height: 500px;
        box-shadow: none;
    }

    .multi_layout .collef .makeScroll {
        max-height: 700px;
        overflow: auto;
    }

    .multi_layout .colrig .makeScroll {
        max-height: 700px;
        overflow: auto;
    }

    /*.multi_layout .colend .makeScroll{max-height: 500px;overflow:auto;}*/
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
        border-radius: 0;
    }

    .multi_layout h6.page_name {
        font-size: 14px;
    }

    .multi_layout .card .card-header input {
        max-width: 100% !important;
    }

    .multi_layout .media-title {
        font-size: 13px;
    }

    .multi_layout .media-body {
        padding-left: 15px;
    }

    .multi_layout .media-body .small {
        font-size: 10px;
        color: #000;
        margin-top: 12px;
    }

    .multi_layout .summary .summary-item {
        margin-top: 0;
    }

    .multi_layout .card-primary {
        margin-top: 35px;
        margin-bottom: 15px;
    }

    .multi_layout .product-details .product-name {
        font-size: 12px;
    }

    .multi_layout .set_cam_by_post:after {
        content: none !important;
    }

    .multi_layout .colrig .media {
        padding-bottom: 0;
    }

    .multi_layout .list-unstyled-border li {
        border-bottom: none;
    }

    .multi_layout .colmid .card-body {
        padding: 12px 10px;
    }

    .multi_layout .colrig .card-body {
        padding: 12px 20px;
    }

    .multi_layout .waiting, .modal_waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .multi_layout .waiting i, .modal_waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
    }

    .multi_layout .card .card-header h4 a {
        font-weight: 700 !important;
    }

    ::placeholder {
        color: #ccc !important;
    }

    .smallspace {
        padding: 10px 0;
    }

    .lead_first_name, .lead_last_name, .lead_tag_name {
        background: #fff !important;
    }

    .ajax-file-upload-statusbar {
        width: 100% !important;
    }

    hr {
        margin-top: 10px;
    }

    .custom-top-margin {
        margin-top: 20px;
    }

    .sync_page_style {
        margin-top: 8px;
    }

    /* .wrapper,.content-wrapper{background: #fafafa !important;} */
    .well {
        background: #fff;
    }

    .emojionearea, .emojionearea.form-control {
        height: 140px !important;
    }


    .emojionearea.small-height {
        height: 140px !important;
    }

</style>

<?php if (!empty($location_info)) { ?>
<div class="row">
<div class="col-sm-12 col-md-6">
    <fieldset class="form-group" id="store_list_field">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"
                       for="location_list_ul"><?php echo $this->lang->line("Location list"); ?></label>
            </div>
            <select class="form-control select2" id="location_list_ul">

                <?php
                $i = 0;
                foreach ($location_info as $value) {
                    $profile_photo = $value['profile_google_url'];
                    if ($profile_photo == '') $profile_photo = base_url('assets/img/product-4-50.png');
                    ?>
                    <option value="<?php echo $value['id']; ?>" <?php if ($i == 0) echo 'selected'; ?>>
                        <?php
                        $address_info = json_decode($value['address'], true);

                        ?>

                        <?php

                        echo $value['location_display_name'] . ' (';
                        echo isset($address_info['postalCode']) ? $address_info['postalCode'] : "";
                        echo ", ";
                        echo isset($address_info['locality']) ? $address_info['locality'] : "";
                        echo ')';

                        $i++;
                        ?></option>
                <?php } ?>
            </select>
        </div>
    </fieldset>
</div>
</div>
<?php } ?>


<?php if (empty($location_info))
{ ?>

    <div class="card" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-fluid" style="height: 200px"
                     src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("We could not find any data.") ?></h2>
                <a href="<?php echo base_url('gmb/business_accounts'); ?>" class="btn btn-outline-primary mt-4"><i
                            class="bx bx-cloud-download"></i> <?php echo $this->lang->line("Import Account"); ?></a>
            </div>
        </div>
    </div>

    <?php
}
else
{ ?>
<div class="row multi_layout">

    <div class="col-12 col-md-7 col-lg-3 colmid" id="middle_column">

    </div>

    <div class="col-12 col-md-12 col-lg-9 colend" id="right_column">

        <div class="text-center waiting">
            <i class="bx bx-spin bx-loader blue text-center"></i>
        </div>

        <div class="card main_card">
            <div class="card-header padding-left-10 padding-right-10">
                <div class="col-6 p-0">
                    <h4 id="right_column_title"></h4>
                </div>
                <h6 class="col-6 p-0">
                    <a href="#" data-toggle="dropdown"
                       class="btn btn-outline-primary dropdown-toggle float-right"><?php echo $this->lang->line("Options"); ?></a>
                    <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <h6 class="dropdown-header"><?php echo $this->lang->line("Actions"); ?></h6>
                        <li><a class="dropdown-item has-icon new_review_url" style="cursor: pointer;"><i
                                        class="bx bx-code"></i> <?php echo $this->lang->line("New review URL"); ?></a>
                        </li>
                        <li><a class="dropdown-item has-icon location_insight" href="#"><i
                                        class="bx bx-line-chart"></i> <?php echo $this->lang->line("Location insights"); ?>
                            </a></li>

                    </ul>
            </div>

            <div class="card-body" style="padding: 10px 17px 10px 10px;">
                <div class="row">
                    <div class="col-12">

                        <div id="right_column_content">
                            <iframe src="" frameborder="0" width="100%"></iframe>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>


    <style type="text/css">.ajax-upload-dragdrop {
            width: 100% !important;
        }</style>

    <!-- Modal -->
    <div class="modal fade" id="new_review_url_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i
                                class="bx bx-code"></i> <?php echo $this->lang->line('New review URL'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="new_review_url_content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>