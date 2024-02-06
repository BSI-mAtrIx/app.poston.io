<style>
    #settings .select2 {
        width: 100% !important;
    }

    .filter_frameworks_select .select2 {
        width: 100% !important;
    }

    .width-100p {
        width: 100%;
    }

    .blockOverlay {
        z-index: 2001 !important;
    }

    .blockPage {
        z-index: 2011 !important;
    }

    .select2 {
        width: 100% !important;
    }
</style>


<?php
$include_select2 = 1;
$include_dropzone = 1;
$include_cropper = 1;
$include_datetimepicker = 1;
$content_generator = file_exists(APPPATH.'modules/n_generator/include/modal_message_universal.php');

if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url(); ?>assets/n_adsmanager/jquery.blockUI.js"></script>

<?php } else { ?>
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
    <?php
    $jodit = 1;
    $include_select2 = 1;
}

if(!empty($_GET['fb_action'])){
    switch($_GET['fb_action']){
        case 'all_ad_accounts_were_connected';
        echo '<div class="alert alert-success mb-2" role="alert">
                 '.$this->lang->line('all_ad_accounts_were_connected').'
              </div>';
            break;
        case 'no_ad_accounts';
            echo '<div class="alert alert-warning mb-2" role="alert">
                 '.$this->lang->line('no_ad_accounts').'
              </div>';
            break;
        case 'error_occurred';
            echo '<div class="alert alert-danger mb-2" role="alert">
                 '.$this->lang->line('error_occurred').'
              </div>';
            break;
    }

}

if(!empty($info_msg)){
    echo '<div class="alert alert-warning mb-2" role="alert">
                 '.$this->lang->line($info_msg['text']).'
              </div>';
}

if (!empty($current_ad_acc)) {
    $cur_active_expire = date("jS F Y", strtotime($current_ad_acc["active_expire"]));
    $cur_active_expire2 = strtotime($current_ad_acc["active_expire"]);
} else {
    $cur_active_expire = 0;
    $cur_active_expire2 = 0;
}

?>

<div class="row mb-1">
    <div class="col-sm-12 col-md-3">
        <?php echo '<a class="btn btn-block btn-social btn-facebook" href="' . htmlspecialchars($login_to_fb_url) . '"><span class="bx bxl-facebook"></span><span class="ml-1">' . $this->lang->line('Login with Facebook') . '</span></a>'; ?>
    </div>

    <div class="col-sm-12 col-md-9">
        <?php if (!empty($ad_acc)) { ?>
            <fieldset class="form-group" style="width:100%;" id="store_list_field">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"
                               for="bot_list_select"><?php echo $this->lang->line("Ad Accounts"); ?></label>
                    </div>
                    <select class="form-control select2" id="bot_list_select">

                        <?php
                        $i = 0;
                        $active_acc = 0;
                        $current_store_data = array();
                        foreach ($ad_acc as $value) {
                            if ($value['network_id'] == $this->session->userdata("n_selected_account")) $current_store_data = $value;

                            $active = '';
                            $active_expire = date("jS F Y", strtotime($value["active_expire"]));
                            $active_expire2 = strtotime($value["active_expire"]);

                            if ($active_expire2 > time()) {
                                $active = $this->lang->line('Active');
                                $active_acc = 1;
                            }
                            ?>
                            <option value="<?php echo $value['network_id']; ?>" <?php if ($i == 0 || $value['network_id'] == $this->session->userdata('n_select_ad_acc')) echo 'selected'; ?>>
                                <?php
                                echo $value['user_name'] . ' (' . $value['net_id'] . ') ' . $active;
                                ?>
                            </option>

                            <?php $i++;
                        } ?>
                    </select>
                </div>
            </fieldset>
        <?php } ?>


    </div>
</div>

<?php if(!empty($n_info)){ ?>
<div class="col-12">

    <?php
    if($n_info['status'] == 'success'){
        echo '<div class="alert alert-success mb-2" role="alert">
                 '.$n_info['message'].'
              </div>';
    }
    if($n_info['status'] == 'danger'){
        echo '<div class="alert alert-danger mb-2" role="alert">
                 '.$n_info['message'].'
              </div>';
    } ?>

</div>
<?php } ?>

<?php
if (empty($ad_acc)) {
    ?>
    <div class="card text-center" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-fluid img_fb_onerror"
                     onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                     style="height: 200px"
                     src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("You haven't connected any Ads account yet.") ?></h2>
                <br/>
                <div class="text-center">
                    <p style="max-width: 250px; margin: 0 auto;" data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo $this->lang->line("you must be logged in your facebook account for which you want to refresh your access token. for synch your new page, simply refresh your token. if any access token is restricted for any action, refresh your access token."); ?>"> <?php if ($this->config->item('developer_access') != '1') echo '<a class="btn btn-block btn-social btn-facebook" href="' . htmlspecialchars($login_to_fb_url) . '"><span class="bx bxl-facebook"></span>' . $this->lang->line('Login with Facebook') . '</a>'; ?></p>

                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
if (!empty($ad_acc)) {
    ?>

    <div class="section-body ntheme main">
        <div class="row">
            <div class="col-sm-12">


                <div class="row pills-stacked">
                    <div class="col-md-2 col-sm-12">
                        <ul class="nav nav-pills flex-column text-center text-md-left">
                            <?php if ($this->session->userdata('user_type') == "Admin") { ?>
                                <li class="nav-item">
                                    <a class="nav-link" id="admin_settings_btn" data-toggle="pill"
                                       href="#admin_settings" aria-expanded="false">
                                        <?php echo $this->lang->line('Admin Settings'); ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link active" id="stacked-pill-1" data-toggle="pill"
                                   href="#vertical-pill-1" aria-expanded="true">
                                    <?php echo $this->lang->line('AD Account'); ?>
                                </a>
                            </li>
                            <?php if ($cur_active_expire2 > time()) { ?>
                                <li class="nav-item">
                                    <a class="nav-link disabled">
                                        <?php echo $this->lang->line('Classic Ads Manager'); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="cpg_view_btn" data-toggle="pill" href="#cpg_view"
                                       aria-expanded="false">
                                        <?php echo $this->lang->line('Campaigns'); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="adset_view_btn" data-toggle="pill" href="#adset_view"
                                       aria-expanded="false">
                                        <?php echo $this->lang->line('AD Set'); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ads_view_btn" data-toggle="pill" href="#ads_view"
                                       aria-expanded="false">
                                        <?php echo $this->lang->line('ADS'); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="con_track_view_btn" data-toggle="pill"
                                       href="#con_track_view" aria-expanded="false">
                                        <?php echo $this->lang->line('Conversion Tracking'); ?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom_audience_view_btn" data-toggle="pill"
                                       href="#custom_audience_view" aria-expanded="false">
                                        <?php echo $this->lang->line('Custom audiences'); ?>
                                    </a>
                                </li>


                            <?php } ?>

                        </ul>
                    </div>
                    <div class="col-md-10 col-sm-12">
                        <div class="tab-content tab-main-action">

                            <?php if ($this->session->userdata('user_type') == "Admin") { ?>
                                <?php
                                include(APPPATH . '/modules/n_adsmanager/views/main_view_admin_view.php');
                                ?>
                            <?php } ?>


                            <div role="tabpanel" class="tab-pane active" id="vertical-pill-1"
                                 aria-labelledby="stacked-pill-1"
                                 aria-expanded="true">

                                <h4 class="card-title">
                                    <?php echo $this->lang->line('Ad Account Overview'); ?>
                                </h4>

                                <p>
                                    <?php echo $this->lang->line('Your package allows you to manage ad accounts:'); ?>
                                </p>
                                <p>
                                    <?php echo $this->lang->line("For the best experience, please create a new Facebook Ad account and don't touch it."); ?>
                                </p>


                                <?php if ($active_acc == 0) { ?>

                                    <div class="font-weight-bold mb-2">
                                        <?php echo $this->lang->line('You don\'t have an active account in our system. Please select which account you want to use. After selecting, click the button.'); ?>
                                    </div>
                                <?php } ?>
                                <p>
                                    <?php

                                    if ($cur_active_expire2 > time()) {
                                        echo $this->lang->line('This account is used in our system:');
                                        echo ' ' . $current_ad_acc['user_name'] . ' (' . $current_ad_acc['net_id'] . ')';

                                        if ($current_ad_acc["active_expire"] == 1) {
                                            echo '<a id="stop_autorenew_ad_account" data-id="' . $current_ad_acc["network_id"] . '" class="btn btn-primary" href="#">' . $this->lang->line('I would like to stop the automatic renewal for this ad account: ');
                                            echo ' ' . $current_ad_acc['user_name'] . ' (' . $current_ad_acc['net_id'] . ') <i class="bx bx-chevron-right"></i></a>';
                                        } else {
                                            echo '<p>' . $this->lang->line('Auto renew for this ad account is not enabled.') . '</p>';
                                        }
                                    } else {
                                        echo '<a id="accept_ad_account" data-id="' . $current_ad_acc["network_id"] . '" class="btn btn-primary" href="#">' . $this->lang->line('I want to use this account:');
                                        echo ' ' . $current_ad_acc['user_name'] . ' (' . $current_ad_acc['net_id'] . ') <i class="bx bx-chevron-right"></i></a>';
                                    }


                                    ?>
                                </p>

                                <div class="alert alert-danger mb-2">
                                    <?php echo $this->lang->line('You can\'t change your ad account until 28 days.'); ?>
                                </div>


                                <div id="overview">

                                </div>


                            </div>

                            <div class="tab-pane" id="cpg_view" role="tabpanel" aria-labelledby="cpg_view"
                                 aria-expanded="false">

                                <div class="row" id="campaigns">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="row" colspan="3">
                                                        <button type="button" class="btn btn-success"
                                                                data-toggle="modal" data-target="#create_campaign">
                                                            <i class="icon-basket-loaded"></i>
                                                            <?php echo $this->lang->line('new_campaign'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-dark ads-delete-campaigns">
                                                            <i class="icon-trash"></i> <?php echo $this->lang->line('delete'); ?>
                                                        </button>
                                                    </th>
                                                    <th scope="row" colspan="3">
                                                        <button type="button"
                                                                class="btn btn-dark pull-right btn-ads-reports btn-load-campaign-insights"
                                                                data-toggle="modal"
                                                                data-target="#ads-campaigns-insights">
                                                            <i class="icon-graph"></i>
                                                            <?php echo $this->lang->line('insights'); ?>
                                                        </button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="checkbox-option-select">
                                                            <input id="ads-campaigns-all" name="ads-campaigns-all"
                                                                   type="checkbox">
                                                            <label for="ads-campaigns-all"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col"><?php echo $this->lang->line('name'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('status'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('campaign_objective'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('impressions'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('spent'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php


                                                echo '<tr>'
                                                    . '<td colspan="6" class="p-3">'
                                                    . $this->lang->line('no_campaigns_found')
                                                    . '</td>'
                                                    . '</tr>';


                                                ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="8" class="text-right">
                                                        <button type="button"
                                                                class="btn btn-dark btn-previous btn-campaign-pagination disabled">
                                                            <i class="far fa-arrow-alt-circle-left"></i>
                                                            <?php echo $this->lang->line('previous'); ?>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-dark btn-next btn-campaign-pagination disabled">
                                                            <?php echo $this->lang->line('next'); ?>
                                                            <i class="far fa-arrow-alt-circle-right"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane" id="adset_view" role="tabpanel" aria-labelledby="adset_view"
                                 aria-expanded="false">

                                <div class="row" id="ad-sets">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="row" colspan="3">
                                                        <button type="button" class="btn btn-success create_adset_btn"
                                                                data-toggle="modal" data-target="#create_adset">
                                                            <i class="icon-wallet"></i>
                                                            <?php echo $this->lang->line('new_ad_set'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-dark ads-delete-adsets"><i
                                                                    class="icon-trash"></i> <?php echo $this->lang->line('delete'); ?>
                                                        </button>
                                                    </th>
                                                    <th scope="row" colspan="3">
                                                        <button type="button"
                                                                class="btn btn-dark pull-right btn-ads-reports btn-load-ad-sets-insights"
                                                                data-toggle="modal" data-target="#ads-ad-sets-insights">
                                                            <i class="icon-graph"></i>
                                                            <?php echo $this->lang->line('insights'); ?>
                                                        </button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="checkbox-option-select">
                                                            <input id="ads-adsets-all" name="ads-adsets-all"
                                                                   type="checkbox">
                                                            <label for="ads-adsets-all"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col"><?php echo $this->lang->line('name'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('status'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('campaign'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('impressions'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('spent'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php


                                                echo '<tr>'
                                                    . '<td colspan="6" class="p-3">'
                                                    . $this->lang->line('no_adsets_found')
                                                    . '</td>'
                                                    . '</tr>';


                                                ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="8" class="text-right">
                                                        <button type="button"
                                                                class="btn btn-dark btn-previous btn-adsets-pagination disabled">
                                                            <i class="far fa-arrow-alt-circle-left"></i>
                                                            <?php echo $this->lang->line('previous'); ?>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-dark btn-next btn-adsets-pagination disabled">
                                                            <?php echo $this->lang->line('next'); ?>
                                                            <i class="far fa-arrow-alt-circle-right"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="ads_view" role="tabpanel" aria-labelledby="adset_view"
                                 aria-expanded="false">

                                <div class="row" id="ads">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="row" colspan="3">
                                                        <button type="button" class="btn btn-success"
                                                                id="ads-create-new-ad">
                                                            <i class="icon-puzzle"></i>
                                                            <?php echo $this->lang->line('New Ad'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-dark ads-delete-ad"><i
                                                                    class="icon-trash"></i> <?php echo $this->lang->line('delete'); ?>
                                                        </button>
                                                    </th>
                                                    <th scope="row" colspan="3">
                                                        <button type="button"
                                                                class="btn btn-dark pull-right btn-ads-reports btn-load-ad-insights"
                                                                data-toggle="modal" data-target="#ads-ad-insights">
                                                            <i class="icon-graph"></i>
                                                            <?php echo $this->lang->line('insights'); ?>
                                                        </button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="checkbox-option-select">
                                                            <input id="ads-ad-all" name="ads-ad-all" type="checkbox">
                                                            <label for="ads-ad-all"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col">
                                                        <?php echo $this->lang->line('name'); ?>
                                                    </th>
                                                    <th scope="col">
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle ads-status-filter-btn"
                                                                    type="button" id="dropdownMenuButton2"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <?php echo $this->lang->line('status'); ?>
                                                            </button>
                                                            <div class="dropdown-menu ads-status-filter-list"
                                                                 aria-labelledby="dropdownMenuButton2"
                                                                 x-placement="bottom-start">
                                                                <a class="dropdown-item" href="#" data-type="1">
                                                                    <?php echo $this->lang->line('ACTIVE'); ?>
                                                                </a>
                                                                <a class="dropdown-item" href="#" data-type="2">
                                                                    <?php echo $this->lang->line('PAUSED'); ?>
                                                                </a>
                                                                <a class="dropdown-item" href="#" data-type="3">
                                                                    <?php echo $this->lang->line('DELETED'); ?>
                                                                </a>
                                                                <a class="dropdown-item" href="#" data-type="4">
                                                                    <?php echo $this->lang->line('ARCHIVED'); ?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th scope="col">
                                                        <?php echo $this->lang->line('ad_set'); ?>
                                                    </th>
                                                    <th scope="col">
                                                        <?php echo $this->lang->line('impressions'); ?>
                                                    </th>
                                                    <th scope="col">
                                                        <?php echo $this->lang->line('spent'); ?>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php


                                                echo '<tr>'
                                                    . '<td colspan="6" class="p-3">'
                                                    . $this->lang->line('no_adsets_found')
                                                    . '</td>'
                                                    . '</tr>';


                                                ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="8" class="text-right">
                                                        <button type="button"
                                                                class="btn btn-dark btn-previous btn-ad-pagination disabled">
                                                            <i class="far fa-arrow-alt-circle-left"></i>
                                                            <?php echo $this->lang->line('previous'); ?>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-dark btn-next btn-ad-pagination disabled">
                                                            <?php echo $this->lang->line('next'); ?>
                                                            <i class="far fa-arrow-alt-circle-right"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="con_track_view" role="tabpanel" aria-labelledby="con_track_view"
                                 aria-expanded="false">

                                <div class="row" id="pixel-conversion">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="row">
                                                        <button type="button" class="btn btn-success"
                                                                data-toggle="modal" data-target="#pixel-new-coversion">
                                                            <i class="fas fa-chart-line"></i>
                                                            <?php echo $this->lang->line('new_conversion'); ?>
                                                        </button>
                                                    </th>
                                                    <th scope="row">
                                                    </th>
                                                    <th scope="row">
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col"><?php echo $this->lang->line('name'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('type'); ?></th>
                                                    <th scope="col"><?php echo $this->lang->line('url'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="8" class="text-right">
                                                        <button type="button"
                                                                class="btn btn-dark btn-previous btn-conversions-pagination disabled">
                                                            <i class="far fa-arrow-alt-circle-left"></i>
                                                            <?php echo $this->lang->line('previous'); ?>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-dark btn-next btn-conversions-pagination disabled">
                                                            <?php echo $this->lang->line('next'); ?>
                                                            <i class="far fa-arrow-alt-circle-right"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="custom_audience_view" role="tabpanel" aria-labelledby="custom_audience_view"
                                 aria-expanded="false">

                                <div class="row" id="custom_audience_main">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="row">
                                                        <button type="button" class="btn btn-success" id="new_custom_audiences_modal_btn"
                                                                data-toggle="modal" data-target="#new_custom_audiences_modal">
                                                            <?php echo $this->lang->line('New custom audiences'); ?>
                                                        </button>
                                                    </th>
                                                    <th scope="row">
                                                    </th>
                                                    <th scope="row">
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th scope="col"><?php echo $this->lang->line('name'); ?></th>
													<th scope="col"><?php echo $this->lang->line('status'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="8" class="text-right">
                                                        <button type="button"
                                                                class="btn btn-dark btn-previous btn-custom_audiences-pagination disabled">
                                                            <i class="far fa-arrow-alt-circle-left"></i>
                                                            <?php echo $this->lang->line('previous'); ?>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-dark btn-next btn-custom_audiences-pagination disabled">
                                                            <?php echo $this->lang->line('next'); ?>
                                                            <i class="far fa-arrow-alt-circle-right"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="ads-create-new-ad-view" role="tabpanel"
                                 aria-labelledby="ads-create-new-ad-view" aria-expanded="false">

                                <div class="">
                                    <?php echo form_open('n_adsmanager/new_cpg', array('class' => 'facebook-ads-create-new-ad', 'data-csrf' => $this->session->userdata('csrf_token_session'))); ?>

                                    <h4 class="card-title"><?php echo $this->lang->line('create_new_ad'); ?></h4>

                                    <div class="card-body">
                                        <div class="alerts-display-reports"></div>


                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="select_ad_campaign_btn" data-toggle="tab"
                                                   href="#select_ad_campaign" role="tab"
                                                   aria-controls="home-fill" aria-selected="true">
                                                    <?php echo $this->lang->line('select_ad_campaign'); ?>
                                                    <em class="required">(<?php echo $this->lang->line('required'); ?>
                                                        )</em>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="select_ad_set_btn" data-toggle="tab"
                                                   href="#select_ad_set" role="tab"
                                                   aria-controls="profile-fill" aria-selected="false">
                                                    <?php echo $this->lang->line('select_ad_set'); ?>
                                                    <em class="required">(<?php echo $this->lang->line('required'); ?>
                                                        )</em>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="create_ad_btn" data-toggle="tab"
                                                   href="#create_ad" role="tab"
                                                   aria-controls="messages-fill" aria-selected="false">
                                                    <?php echo $this->lang->line('create_ad'); ?>
                                                    <em class="required">(<?php echo $this->lang->line('required'); ?>
                                                        )</em>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content pt-1 shadow-none">
                                            <div class="tab-pane active" id="select_ad_campaign" role="tabpanel"
                                                 aria-labelledby="select_ad_campaign">
                                                <div id="ads-select-campaign">

                                                    <h4 class="card-title">
                                                        <?php echo $this->lang->line('ad_campaign'); ?>
                                                    </h4>
                                                    <p>
                                                        <?php echo $this->lang->line('ad_campaign_description'); ?>
                                                    </p>

                                                    <div class="form-group">
                                                        <select class="form-control" id="ads-select-ad-campaign"
                                                                name="ads-select-ad-campaign">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <a href="#" class="" data-toggle="modal"
                                                       data-target="#create_campaign"><?php echo $this->lang->line('Or create new campaign'); ?></a>

                                                </div>
                                            </div>
                                            <div class="tab-pane" id="select_ad_set" role="tabpanel"
                                                 aria-labelledby="select_ad_set">
                                                <div id="ads-select-ad-set">

                                                    <h4 class="card-title">
                                                        <?php echo $this->lang->line('ad_set'); ?>
                                                    </h4>
                                                    <p>
                                                        <?php echo $this->lang->line('ad_set_description'); ?>
                                                    </p>

                                                    <div class="form-group">
                                                        <select class="form-control" id="ads-selected-ad-set"
                                                                name="ads-selected-ad-set">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <a href="#" class="create_adset_btn from_creator"
                                                       data-toggle="modal"
                                                       data-target="#create_adset"><?php echo $this->lang->line('Or create new ad set'); ?></a>

                                                </div>
                                            </div>
                                            <div class="tab-pane" id="create_ad" role="tabpanel"
                                                 aria-labelledby="create_ad">

                                                <h4 class="card-title">
                                                    <?php echo $this->lang->line('ad_content'); ?>
                                                </h4>

                                                <input type="hidden" value="" name="data_campaign_id"
                                                       id="data_campaign_id"/>
                                                <input type="hidden" value="" name="data_campaign_objective"
                                                       id="data_campaign_objective"/>


                                                <div id="ads-create-ads">

                                                    <?php
                                                    include(APPPATH . '/modules/n_adsmanager/views/main_view_cpg_view.php');
                                                    ?>

                                                    <div class="row-input">
                                                        <div class="row clean">
                                                            <div class="col-6">
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="submit"
                                                                        class="btn btn-primary ads_save_ad_set"
                                                                        id="ads_save_ad_set">
                                                                    <i class="bx bx-save"></i> <?php echo $this->lang->line('save_ad'); ?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <?php echo form_close(); ?>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } ?>