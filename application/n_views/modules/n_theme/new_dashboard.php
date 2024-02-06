<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/charts/apexcharts.css?ver=<?php echo $n_config['theme_version']; ?>">
<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/extensions/swiper.min.css?ver=<?php echo $n_config['theme_version']; ?>">


<?php if ($rtl_on) { ?>
    <style>
        text {
            letter-spacing: normal;
        }
    </style>

<?php }

$include_alertify = 1;
$include_datetimepicker = 1;

if (isset($system_dashboard))
    $has_system_dashboard = 'yes';
else
    $has_system_dashboard = 'no';

$id_for_user = $this->user_id;

if (isset($system_dashboard)) {
    if (is_numeric($this->uri->segment(3))) {
        $id_for_user = $this->uri->segment(3);
    } else {
        $id_for_user = $this->uri->segment(2);
    }
}

$import_section = 'false';
if (file_exists(APPPATH . 'n_eco_user/dashboard_' . strtolower($current_language) . '.php')) {
    $import_section = APPPATH . 'n_eco_user/dashboard_' . strtolower($current_language) . '.php';
} else {
    if (file_exists(APPPATH . 'n_eco_user/dashboard_' . $n_config['dashboard_section_1_default'] . '.php')) {
        $import_section = APPPATH . 'n_eco_user/dashboard_' . $n_config['dashboard_section_1_default'] . '.php';
    }
}


if ($import_section != 'false') {
    $n_editor_data = file_get_contents($import_section);
    $n_editor_data = json_decode($n_editor_data, true);
} else {
    $n_editor_data = array();
    $n_editor_data['gjs-html'] = '';
    $n_editor_data['gjs-components'] = '';
    $n_editor_data['gjs-assets'] = '';
    $n_editor_data['gjs-css'] = '';
    $n_editor_data['gjs-styles'] = '';
}
?>

<style>
    <?php echo $n_editor_data['gjs-css']; ?>
</style>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <?php
            if ($other_dashboard == 1) : ?>
                <?php if ($system_dashboard == 'yes') : ?>
                    <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line('System Dashboard'); ?></h5>
                <?php else : ?>
                    <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line('Dashboard for') . " " . $user_name . " [" . $user_email . "]"; ?></h5>
                <?php endif; ?>
            <?php else : ?>
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line('Dashboard'); ?></h5>
            <?php endif; ?>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item active"><i class="bx bx-home-alt"></i></li>

                    <li class="movetoright">
                        <?php if ($n_config['start_modal_show'] == 'true' or ($n_config['start_modal_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) {
                            $n_modal_welcome_text = $this->lang->line('Welcome');
                            if (isset($n_config['welcome_modal_button_text_' . strtolower($current_language)]) and !empty($n_config['welcome_modal_button_text_' . strtolower($current_language)])) {
                                $n_modal_welcome_text = $n_config['welcome_modal_button_text_' . strtolower($current_language)];
                            }
                            ?>
                            <a data-toggle="modal" data-target="#start_modal_show" href="#"
                               class="btn btn-sm btn-light-primary"><?php echo $n_modal_welcome_text; ?></a>
                        <?php } ?>
                        <?php if ($n_config['disable_example_dashboard'] == 'true') {
                            if ($demo_dashboard==1) { ?>
                                <a href="<?php echo base_url('dashboard'); ?>"
                                   class="btn btn-sm btn-light-primary"><?php echo $this->lang->line('Dashboard'); ?></a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('demo_dashboard'); ?>"
                                   class="btn btn-sm btn-light-primary"><?php echo $this->lang->line('example :') . ' ' . $this->lang->line('Dashboard'); ?></a>
                            <?php }
                        } ?>

                    </li>

                </ol>

            </div>

        </div>
    </div>
</div>
<?php

if ($demo_dashboard==1) {

    ?>
    <div class="alert alert-warning mb-2" role="alert">
        <span><?php echo $this->lang->line('example :'); ?> <?php echo $this->lang->line('Dashboard'); ?> <?php echo $this->lang->line('data'); ?></span>
    </div>
    <?php


}

if(empty($system_dashboard)){
    $system_dashboard='no';
}

if($pages_not_exist==1  AND $system_dashboard=='no'){

    echo '<div class="alert alert-warning mb-1" role="alert"><a href="' . base_url('/social_accounts/index') . '" class="text-white">';
    echo $this->lang->line('You haven not connected any account yet.');
    echo '</a></div>';
}

if ($n_config['import_account_fb_alert'] == 'alert_dashboard') {
    $where_alert['where'] = array('user_id' => $id_for_user);
    $existing_accounts_alert = $this->basic->get_data('facebook_rx_fb_user_info', $where_alert);

    if (empty($existing_accounts_alert)) {
        echo '<div class="alert alert-warning mb-1" role="alert"><a href="' . base_url('/social_accounts/index') . '" class="text-white">';
        echo $this->lang->line('You haven not connected any account yet.');
        echo '</a></div>';
    }
}

if ($n_config['import_account_fb_alert'] == 'redirect_from_dashboard') {
    $where_alert['where'] = array('user_id' => $id_for_user);
    $existing_accounts_alert = $this->basic->get_data('facebook_rx_fb_user_info', $where_alert);
    if (empty($existing_accounts_alert)) {
        redirect(base_url('social_accounts/index'));
    }
}


$n_alerts = null;
if (file_exists(APPPATH . 'n_eco_user/alerts_all.php')) {
    $n_alerts = file_get_contents(APPPATH . 'n_eco_user/alerts_all.php');
    if (!empty($n_alerts)) {
        $n_alerts = json_decode($n_alerts, true);
    }
}
if (!empty($n_alerts['group-a'])) {
    foreach ($n_alerts['group-a'] as $k => $v) {
        echo '<div class="alert ' . $v['alert_type'] . ' mb-1" role="alert">';
        if (!empty($v['alert_text_' . strtolower($current_language)])) {
            echo $v['alert_text_' . strtolower($current_language)];
        } else {
            if (!empty($v['default'])) {
                echo $v['alert_text_' . strtolower($v['default'])];
            }
        }
        echo '</div>';
    }
}

?>


        <div class="row mb-2">
            <?php if (!empty($page_info)) { ?>
            <div class="col-md-5 col-sm-12">
                <fieldset class="form-group" id="store_list_field">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text"
                                   for="bot_list_select"><?php if ($media_type == 'ig') echo $this->lang->line("Accounts"); else echo $this->lang->line("Pages"); ?></label>
                        </div>
                        <select class="form-control select2" id="bot_list_select">
                            <optgroup label="<?php echo $this->lang->line('Facebook'); ?>">
                            <?php $i = 0;
                            $current_store_data = array();
                            $ig_group_select = '';
                            foreach ($page_info as $value) {
                                if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                                ?>

                                <option value="fb_<?php echo $value['id']; ?>" <?php if ('fb_'.$value['id'] == $this->session->userdata('d_page_mix')) echo 'selected'; ?>>
                                    <?php
                                        echo $value['page_name'];
                                    ?>
                                </option>

                                <?php
                                if($value['has_instagram']==1 AND addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")){

                                    $selected = 0;
                                    if ('ig_'.$value['id'] == $this->session->userdata('d_page_mix')){ $selected =  'selected'; }

                                    $ig_group_select .= '<option value="ig_'.$value['id'].'" '.$selected.' >
                                            '.$value['insta_username'].' ['.$value['page_name'].']</option>';

                                } ?>

                                <?php $i++;
                            } ?>
                            </optgroup>
                            <optgroup label="<?php echo $this->lang->line('Instagram'); ?>">
                                <?php echo $ig_group_select; ?>
                            </optgroup>
                        </select>
                    </div>
                </fieldset>
            </div>
            <?php } ?>
            <div class="col-md-5 col-sm-12">
                <div class="input-group" id="period_stats">
                    <input type="text" class="form-control" id="period_stats_in" name="period_stats_in"
                           placeholder="<?php echo $this->lang->line("Period"); ?>"
                           value="<?php echo $period_range; ?>"/>
                </div>
            </div>
        </div>


<div class="content-body n_dashboard">

    <?php
    if (file_exists(APPPATH . 'views/dashboard/inc_dashboard.php')) {
        include(APPPATH . 'n_views/dashboard/user_guide.php');
    }
    ?>

    <?php
    if ($n_config['dashboard_section_init'] == '1') {

        if ($n_config['dashboard_section_1_on'] == 'true' or ($n_config['dashboard_section_1_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) { ?>

            <div class="row">
                <?php echo $n_editor_data['gjs-html']; ?>
            </div>

        <?php }
    } ?>


    <div class="row">

        <div class="col-sm-12 col-md-4 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('Email campaigns overviews'); ?></h4>
                </div>
                <div class="card-body pb-1 pt-0">

                    <div class="email_cpg_chart"></div>

                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('Sms campaigns overviews'); ?></h4>
                </div>
                <div class="card-body pb-1 pt-0">

                    <div class="sms_cpg_chart"></div>

                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('Social posting overviews'); ?></h4>
                </div>
                <div class="card-body pb-1 pt-0">

                    <div class="posting_cpg_chart"></div>

                </div>
            </div>
        </div>

    </div>





        <?php
    if ($n_config['dashboard_section_init'] == '2') {


        if ($n_config['dashboard_section_1_on'] == 'true' or ($n_config['dashboard_section_1_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) { ?>

            <div class="row">
                <?php echo $n_editor_data['gjs-html']; ?>
            </div>

        <?php }
    } ?>

    <div class="row">

        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title"><?php echo $this->lang->line('Subscribers'); ?>
                        : <?php echo custom_number_format($total_subscribers); ?></h4>
                </div>
                <div class="card-body p-0">
                    <div id="sub_uns_area"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('Subscribers from Different Sources'); ?></h4>
                </div>
                <div class="card-body substat pb-0 pt-0">
                    <div class="d-flex mb-1">
                        <button id="subsdiff_rad" type="button" class="btn btn-sm btn-light-primary mr-1">
                            <?php echo $this->lang->line('Radial'); ?>
                        </button>
                        <button id="subsdiff_donut" type="button" class="btn btn-sm btn-primary glow">
                            <?php echo $this->lang->line('Donut'); ?>
                        </button>
                    </div>                    <div class="row">
                        <div class="col-md-7 col-sm-12 radialbar">
                            <div class="subscribers_source_radialbar"></div>
                        </div>
                        <div class="col-md-7 col-sm-12 donut" style="display:none; padding-bottom: 25px;">
                            <div class="subscribers_source_chart"></div>
                        </div>
                        <div class="col-md-5 col-sm-12 my-auto">

                            <ul style="display:grid;" class="list-inline justify-content-around mb-0 font-small-3">
                                <li class="list-inline-item"><span class="bullet bullet-xs bullet-primary mr-50"
                                                                   style="background-color:#5A8DEE"></span><?php echo $refferer_source_info['checkbox_plugin']['title']; ?>
                                </li>
                                <li class="list-inline-item"><span class="bullet bullet-xs bullet-info mr-50"
                                                                   style="background-color:#FDAC41"></span><?php echo $refferer_source_info['sent_to_messenger']['title']; ?>
                                </li>
                                <li class="list-inline-item"><span class="bullet bullet-xs bullet-warning mr-50"
                                                                   style="background-color:#FF5B5C"></span><?php echo $refferer_source_info['customer_chat_plugin']['title']; ?>
                                </li>
                                <li class="list-inline-item"><span class="bullet bullet-xs bullet-primary mr-50"
                                                                   style="background-color:#39DA8A"></span><?php echo $refferer_source_info['direct']['title']; ?>
                                </li>
                                <li class="list-inline-item"><span class="bullet bullet-xs bullet-info mr-50"
                                                                   style="background-color:#00CFDD"></span><?php echo $refferer_source_info['comment_private_reply']['title']; ?>
                                </li>
                                <li class="list-inline-item"><span class="bullet bullet-xs bullet-warning mr-50"
                                                                   style="background-color:#E6EAEE"></span><?php echo $refferer_source_info['me_link']['title']; ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>



    <?php
    if ($n_config['dashboard_section_init'] == '3') {


        if ($n_config['dashboard_section_1_on'] == 'true' or ($n_config['dashboard_section_1_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) { ?>

            <div class="row">
                <?php echo $n_editor_data['gjs-html']; ?>
            </div>

        <?php }
    } ?>

    <div class="row">
        <div class="col-xs-12 col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $this->lang->line('Male vs Female Subscribers'); ?></h4>
                </div>
                <div class="card-body p-0">
                    <div id="male_vs_female_chart" height="134"></div>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $this->lang->line('Subscriber Gain'); ?></h4>
                </div>
                <div class="card-body p-0">
                    <div id="stats_chart" height="134"></div>
                </div>
            </div>
        </div>

    </div>


</div>



<?php
$import_modal = 'false';
if (file_exists(APPPATH . 'n_eco_user/welcome_modal_' . strtolower($current_language) . '.php')) {
    $import_modal = APPPATH . 'n_eco_user/welcome_modal_' . strtolower($current_language) . '.php';
} else {
    if (file_exists(APPPATH . 'n_eco_user/welcome_modal_' . $n_config['start_modal_default'] . '.php')) {
        $import_modal = APPPATH . 'n_eco_user/welcome_modal_' . $n_config['start_modal_default'] . '.php';
    }
}


if ($import_modal != 'false') {
    $n_modal_data = file_get_contents($import_modal);
    $n_modal_data = json_decode($n_modal_data, true);
} else {
    $n_modal_data = array();
    $n_modal_data['gjs-html'] = '';
    $n_modal_data['gjs-components'] = '';
    $n_modal_data['gjs-assets'] = '';
    $n_modal_data['gjs-css'] = '';
    $n_modal_data['gjs-styles'] = '';
}

if ($n_config['start_modal_show'] == 'true' or ($n_config['start_modal_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) {

    echo '<style>' . $n_modal_data['gjs-css'] . '</style>';
    ?>

    <div class="modal fade text-left" id="start_modal_show" tabindex="-1" role="dialog" aria-labelledby="start_modal1"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1"><?php echo $n_modal_welcome_text; ?></h3>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body p-0 pt-1">
                    <?php echo $n_modal_data['gjs-html']; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" id="start_modal_hide" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><?php echo $this->lang->line('Close'); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>