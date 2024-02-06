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
                            if (isset($_GET['n_demo'])) { ?>
                                <a href="<?php echo base_url('dashboard'); ?>"
                                   class="btn btn-sm btn-light-primary"><?php echo $this->lang->line('Dashboard'); ?></a>
                            <?php } else { ?>
                                <a href="<?php echo base_url('dashboard?n_demo=1'); ?>"
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
if (isset($_GET['n_demo'])) {

    ?>
    <div class="alert alert-warning mb-2" role="alert">
        <span><?php echo $this->lang->line('example :'); ?><?php echo $this->lang->line('Dashboard'); ?><?php echo $this->lang->line('data'); ?></span>
    </div>
    <?php


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

<?php if (!empty($page_info)) { ?>
        <div class="row">
            <div class="col-5">
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
            <div class="col-5">
                <div class="input-group" id="period_stats">
                    <input type="text" class="form-control" id="period_stats_in" name="period_stats_in"
                           placeholder="<?php echo $this->lang->line("Period"); ?>"
                           value="<?php echo $period_range; ?>"/>
                </div>
            </div>
        </div>
<?php } ?>

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
    }



            echo '<div class="alert alert-warning mb-1" role="alert"><a href="' . base_url('/social_accounts/index') . '" class="text-white">';
            echo $this->lang->line('You haven not connected any account yet.');
            echo '</a></div>';




    ?>




        <?php
    if ($n_config['dashboard_section_init'] == '2') {


        if ($n_config['dashboard_section_1_on'] == 'true' or ($n_config['dashboard_section_1_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) { ?>

            <div class="row">
                <?php echo $n_editor_data['gjs-html']; ?>
            </div>

        <?php }
    } ?>


    <?php
    if ($n_config['dashboard_section_init'] == '3') {


        if ($n_config['dashboard_section_1_on'] == 'true' or ($n_config['dashboard_section_1_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) { ?>

            <div class="row">
                <?php echo $n_editor_data['gjs-html']; ?>
            </div>

        <?php }
    } ?>

</div>
