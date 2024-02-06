<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>


<?php
//todo: 0000000 before release

if (ultraresponse_addon_module_exist()) $commnet_hide_delete_addon = 1;
else $commnet_hide_delete_addon = 0;

if (addon_exist(201, "comment_reply_enhancers")) $comment_tag_machine_addon = 1;
else $comment_tag_machine_addon = 0;

$image_upload_limit = 1;
if ($this->config->item('autoreply_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('autoreply_image_upload_limit');

$video_upload_limit = 3;
if ($this->config->item('autoreply_video_upload_limit') != '')
    $video_upload_limit = $this->config->item('autoreply_video_upload_limit');

$btn_spintax_html = '';
if(file_exists(APPPATH.'n_sgp/injectors/spintax.php')){
    include(APPPATH.'n_sgp/injectors/spintax.php');
}

?>

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

    .multi_layout .collef, .multi_layout .colmid, .multi_layout .colrig {
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
        max-height: 640px;
        overflow: auto;
    }

    .multi_layout .colrig .makeScroll {
        max-height: 605px;
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

    /*ntheme*/
    .media {
        margin-bottom: 20px;
    }

    .avatar-item {
        position: relative;
    }

    .avatar-item img {
        border-radius: 50%;
    }

    .avatar-item i {
        margin-top: 4px;
    }

    .avatar-item .dropdown {
        cursor: pointer;
        position: absolute;
        bottom: -5px;
        right: 0;
        background-color: #fff;
        color: #000;
        box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
        border-radius: 50%;
        text-align: center;
        line-height: 25px;
        width: 25px;
        height: 25px;
    }

    .product-item {
        text-align: center;
    }

    #middle_column .btn {
        padding: 7px 23px !important;
    }

    #right_column .dropdown-menu {
    }

    #right_column .mCSB_container {
        height: 100% !important;
        min-height: 500px !important;
    }

    #store_list_field .select2-container {
        width: 80% !important;
    }

    .product-image img {
        max-width: 80px;
    }

    #right_column ul {
        min-height: 500px !important;
    }


    #middle_column .media-body .badge {
        float: right;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        line-height: 39px;
        font-size: 1rem;
        background-color: rgba(90, 141, 238, .17);
        color: #5A8DEE !important;
        margin-top: 0px;
    }

    #middle_column .media-title {
        font-size: 1.1rem;
        font-weight: 500;
    }


</style>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block rounded">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("Comment Automation"); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
<?php if (!empty($page_info)) { ?>
    <fieldset class="form-group" id="store_list_field">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text" for="bot_list_select"><?php echo $this->lang->line("PAGES"); ?></label>
            </div>
            <select class="form-control select2" id="bot_list_select">

                <?php $i = 0;
                $current_store_data = array();
                foreach ($page_info as $value) {
                    if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                    ?>
                    <option value="<?php echo $value['id']; ?>" <?php if ($i == 0) echo 'selected'; ?>><?php echo $value['page_name']; ?></option>

                    <?php $i++;
                } ?>
            </select>
        </div>
    </fieldset>
<?php } ?>
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


<?php if (empty($page_info)) { ?>

    <div class="card" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-fluid" style="height: 200px"
                     src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("We could not find any page."); ?></h2>
                <p class="lead"><?php echo $this->lang->line("Please import account if you have not imported yet.") . "<br>" . $this->lang->line("If you have already imported account then enable bot connection for one or more page to continue.") ?></p>
                <a href="<?php echo base_url('social_accounts'); ?>" class="btn btn-outline-primary mt-4"><i
                            class="bx b"></i> <?php echo $this->lang->line("Continue"); ?></a>
            </div>
        </div>
    </div>

    <?php
} else { ?>


    <?php if (file_exists(APPPATH . 'show_comment_automation_message.txt') && $this->session->userdata('user_type') == 'Admin') : ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-light alert-has-icon  alert-dismissible show fade" style="margin-bottom:30px"
                     id="hide_comment_automation_message">
                    <div class="alert-icon"><i class="bx bx-paperclip"></i></div>
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert" data-toggle="tooltip"
                                title="<?php echo $this->lang->line("Close this mesage forever"); ?>">
                            <span>×</span>
                        </button>
                        <div class="alert-title"><?php echo $this->lang->line("Hello admin, please read me first"); ?></div>
                        <?php echo $this->lang->line("Comment automation features will not work until your Facebook app is fully approved and is in live mode."); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row multi_layout">


        <div class="col-12 col-md-7 col-lg-4 colmid shadow-none" id="middle_column">

        </div>

        <div class="col-12 col-md-12 col-lg-8 colrig shadow-none" id="right_column">

        </div>

    </div>

<?php } ?>


<input type="hidden" name="dynamic_page_id" id="dynamic_page_id">
