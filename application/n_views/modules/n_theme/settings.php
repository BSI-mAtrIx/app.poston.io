<?php
$include_prism = 1;

function generate_preview(){

}

$imagecheck = function($part) use ($n_config) {
    if (!empty($n_config[$part]) and file_exists(FCPATH . 'assets/img/'.$part.'.png')) {
        echo '<a href="' . base_url() . 'assets/img/'.$part.'.png" target="_BLANK"><i class="text-success bx bxs-check-circle"></i></a>';
    }
};

?>
<style>
    .color-box {
        height: 35px;
        width: 35px;
        margin: 0.5rem;
        border-radius: 0.5rem;
        cursor: pointer;
    }

    .color-box.selected {
        box-shadow: 0 0 0 3px rgb(52 144 220 / 50%);
    }

    #pwa_splash label{text-wrap:wrap;}
</style>
<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item">NVX Theme Dashboard Helper</li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("Settings"); ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url('/n_theme/alerts_edit'); ?>" class="btn btn-primary mb-1"
           title="<?php echo $this->lang->line("Alerts editor"); ?>">
            <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Alerts Editor'); ?>
        </a>
        <a href="<?php echo base_url('/n_theme/helper_page'); ?>" class="btn btn-primary mb-1"
           title="<?php echo $this->lang->line("Alerts editor"); ?>">
            <i class='bx bx-help-circle'></i> <?php echo $this->lang->line('Helps Editor'); ?>
        </a>
    </div>
</div>

<?php $save_button = '<ul class="list-inline d-flex mb-0">
<li class="d-flex align-items-center mr-1">
<button type="submit" id="save-btn" class="btn btn-outline-success mr-1" >
                <i class="bx bx-save"></i>
                <span class="align-middle ml-25">' . $this->lang->line("Save") . '</span>
            </button>
</li>

<li class="d-flex align-items-center mr-1">
            <button class="btn btn-outline-danger mr-1" onclick=\'goBack("n_theme/settings")\' type="button"><i class="bx bx-trash"></i><span class="align-middle ml-25">' . $this->lang->line("Cancel") . '</span></button>
</li>

</ul>'; ?>

<?php $this->load->view('admin/theme/message'); ?>


<form class="form-horizontal text-c" enctype="multipart/form-data"
      action="<?php echo site_url() . 'n_theme/save_settings'; ?>" method="POST">
    <input type="hidden" name="csrf_token" id="csrf_token"
           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

    <div class="content-body" id="stacked-pill">
        <div class="bg-transparent shadow-none">
            <div class="row pills-stacked">

                <div class="col-md-3 col-sm-12">
                    <ul class="nav nav-pills flex-column text-center text-md-left">
                        <li class="nav-item">
                            <a href="#features" class="nav-link align-items-center active" data-toggle="pill"
                               aria-expanded="true">
                                <i class="bx bx-category-alt"></i>
                                <?php echo $this->lang->line("Theme features"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#special_pages" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bx-sitemap'></i>
                                <?php echo $this->lang->line("Special pages"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#dashboard" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bxs-dashboard'></i>
                                <?php echo $this->lang->line("Dashboard"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#ecommerce_set" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bxs-shopping-bags'></i>
                                <?php echo $this->lang->line("Ecommerce"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#marketing_features" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bx-target-lock'></i>
                                <?php echo $this->lang->line("Marketing features"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#language" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bx-flag'></i>
                                <?php echo $this->lang->line("Language"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#pwa_settings" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bx-mobile-alt'></i>
                                <?php echo $this->lang->line("PWA"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#colors" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bxs-color-fill'></i>
                                <?php echo $this->lang->line("Appearence"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#rtl_set" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bxs-hand-right'></i>
                                <?php echo $this->lang->line("RTL Settings"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#pay_gat" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bx-dollar-circle'></i>
                                <?php echo $this->lang->line("Payment Gateways"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#cron_jobs" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bx-bot'></i>
                                <?php echo $this->lang->line("Cron jobs"); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#dynamic_price" class="nav-link" data-toggle="pill" aria-expanded="true">
                                <i class='bx bx-dollar'></i>
                                <?php echo $this->lang->line("Dynamic Pricing"); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="tab-content p-0 bg-transparent shadow-none">

                        <div role="tabpanel" class="tab-pane card active" id="features" aria-labelledby="features"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex "><?php echo $this->lang->line("Theme features"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Hide login via email on login page"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['hide_login_via_email'])) {
                                                $select_lan = $n_config['hide_login_via_email'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Show';
                                            $options['true'] = 'Hide';

                                            echo form_dropdown('hide_login_via_email', $options, $select_lan, 'class="select2 form-control" id="hide_login_via_email"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('hide_login_via_email'); ?></span>
                                        <span>Click on red area (normally invisible) to unshow login via email. Cursor change pointer after hover.</span>
                                        <div class="d-flex"><img class="img-fluid"
                                                                 src="<?php echo base_url('n_assets/img/hide_email.png'); ?>"/>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Default color scheme"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['current_theme'])) {
                                                $select_lan = $n_config['current_theme'];
                                            }
                                            $options = array();
                                            $options['light-layout'] = 'Light layout';
                                            $options['semi-dark-layout'] = 'Semi dark layout';
                                            $options['dark-layout'] = 'Dark layout';

                                            echo form_dropdown('current_theme', $options, $select_lan, 'class="select2 form-control" id="current_theme"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('current_theme'); ?></span>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Use NVX theme login page style?"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['use_nviews_login_page'])) {
                                                $select_lan = $n_config['use_nviews_login_page'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Use NVX Theme login page';
                                            $options['false'] = 'Dont use NVX Theme login page';

                                            echo form_dropdown('use_nviews_login_page', $options, $select_lan, 'class="select2 form-control" id="use_nviews_login_page"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('use_nviews_login_page'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="dark_logo">Logo for dark mode. (logo for light theme loaded from
                                                XeroChat settings)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="dark_logo"
                                                           name="dark_logo">
                                                    <label class="custom-file-label" for="dark_logo">Choose file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dark_logo_error'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="dark_icon">Icon for collapsed sidebar (dark mode), recommend
                                                size: 170x44</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="dark_icon"
                                                           name="dark_icon">
                                                    <label class="custom-file-label" for="dark_icon">Choose file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dark_icon_error'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="light_icon">Icon for collapsed sidebar (light mode)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="light_icon"
                                                           name="light_icon">
                                                    <label class="custom-file-label" for="light_icon">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('light_icon_error'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show greetings"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['greetings_on'])) {
                                                $select_lan = $n_config['greetings_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'show';
                                            $options['false'] = 'hide';

                                            echo form_dropdown('greetings_on', $options, $select_lan, 'class="select2 form-control" id="greetings_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('greetings_on'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Type greetings"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['greetings_random'])) {
                                                $select_lan = $n_config['greetings_random'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Random';
                                            $options['false'] = 'Depends by language';


                                            echo form_dropdown('greetings_random', $options, $select_lan, 'class="select2 form-control" id="greetings_random"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('greetings_random'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show example dashboard button"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['disable_example_dashboard'])) {
                                                $select_lan = $n_config['disable_example_dashboard'];
                                            }
                                            $options = array();
                                            $options['true'] = 'show';
                                            $options['false'] = 'hide';

                                            echo form_dropdown('disable_example_dashboard', $options, $select_lan, 'class="select2 form-control" id="disable_example_dashboard"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('disable_example_dashboard'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Animated helper button"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['helper_animation'])) {
                                                $select_lan = $n_config['helper_animation'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Animated';
                                            $options['false'] = 'NON-animated';

                                            echo form_dropdown('helper_animation', $options, $select_lan, 'class="select2 form-control" id="helper_animation"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('helper_animation'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Import account alert/redirect"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['import_account_fb_alert'])) {
                                                $select_lan = $n_config['import_account_fb_alert'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Disabled';
                                            $options['redirect_from_dashboard'] = 'Redirect only from dashboard';
                                            $options['alert_dashboard'] = 'Alert only in dashboard';
                                            $options['alert_all'] = 'Alert everywhere';

                                            echo form_dropdown('import_account_fb_alert', $options, $select_lan, 'class="select2 form-control" id="import_account_fb_alert"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('import_account_fb_alert'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Hide Download Template from saved templates"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['saved_template_hide_save_btn'])) {
                                                $select_lan = $n_config['saved_template_hide_save_btn'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Disabled';
                                            $options['true'] = 'Enabled';

                                            echo form_dropdown('saved_template_hide_save_btn', $options, $select_lan, 'class="select2 form-control" id="saved_template_hide_save_btn"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('saved_template_hide_save_btn'); ?></span>
                                    </div>


                                    <?php
                                    $credits_show = 'd-none';
                                    if(
                                            file_exists(APPPATH.'modules/n_generator/controllers/N_generator.php') OR
                                            file_exists(APPPATH.'modules/n_wallet/controllers/N_wallet.php')
                                    ) {
                                        $credits_show = '';
                                    }?>
                                    <div class="col-12 col-md-6 mb-1 <?php echo $credits_show; ?>">
                                        <h6><?php echo $this->lang->line("Show credits in usermenu"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_credits_on'])) {
                                                $select_lan = $n_config['n_credits_on'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Disabled';
                                            $options['true'] = 'Enabled';

                                            echo form_dropdown('n_credits_on', $options, $select_lan, 'class="select2 form-control" id="n_credits_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_credits_on'); ?></span>
                                    </div>

                                    <!--                                    <div class="col-12 col-md-6 mb-1">-->
                                    <!--                                        <div class="">-->
                                    <!--                                            <div id="customizer-theme-colors">-->
                                    <!--                                                <h5>Menu Colors</h5>-->
                                    <!--                                                <ul class="list-inline unstyled-list">-->
                                    <!--                                                    <li class="color-box bg-primary selected" data-color="theme-primary"></li>-->
                                    <!--                                                    <li class="color-box bg-success" data-color="theme-success"></li>-->
                                    <!--                                                    <li class="color-box bg-danger" data-color="theme-danger"></li>-->
                                    <!--                                                    <li class="color-box bg-info" data-color="theme-info"></li>-->
                                    <!--                                                    <li class="color-box bg-warning" data-color="theme-warning"></li>-->
                                    <!--                                                    <li class="color-box bg-dark" data-color="theme-dark"></li>-->
                                    <!--                                                </ul>-->
                                    <!--                                                <hr>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->

                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="language" aria-labelledby="language"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Language"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="payment_text_header_sidebar"><?php echo $this->lang->line("Sidebar menu: Payment header text"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-menu'></i></span>
                                                </div>
                                                <input type="text" id="payment_text_header_sidebar"
                                                       name="payment_text_header_sidebar" class="form-control"
                                                       value="<?php echo $n_config['payment_text_header_sidebar']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('payment_text_header_sidebar'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="default_lang_flowbuilder"><?php echo $this->lang->line("Sidebar menu: Payment link text"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-menu'></i></span>
                                                </div>
                                                <input type="text" id="payment_text_sidebar" name="payment_text_sidebar"
                                                       class="form-control"
                                                       value="<?php echo $n_config['payment_text_sidebar']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('payment_text_sidebar'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="default_lang_flowbuilder"><?php echo $this->lang->line("Default language flow builder"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="default_lang_flowbuilder"
                                                       name="default_lang_flowbuilder" class="form-control"
                                                       value="<?php echo $n_config['default_lang_flowbuilder']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('default_lang_flowbuilder'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="helper_default_lang"><?php echo $this->lang->line("Default language helper popup/modal"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="helper_default_lang" name="helper_default_lang"
                                                       class="form-control"
                                                       value="<?php echo $n_config['helper_default_lang']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('helper_default_lang'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Hide language selector"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['show_lang_selector'])) {
                                                $select_lan = $n_config['show_lang_selector'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('show_lang_selector', $options, $select_lan, 'class="select2 form-control" id="show_lang_selector"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('show_lang_selector'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Language changer before login"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['login_change_language'])) {
                                                $select_lan = $n_config['login_change_language'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('login_change_language', $options, $select_lan, 'class="select2 form-control" id="login_change_language"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('login_change_language'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Menu manager is_external open in new cart?"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['is_external_off'])) {
                                                $select_lan = $n_config['is_external_off'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Open same window';
                                            $options['false'] = 'Open in new cart';

                                            echo form_dropdown('is_external_off', $options, $select_lan, 'class="select2 form-control" id="is_external_off"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('is_external_off'); ?></span>
                                    </div>

                                </div>


                                <hr class="mb-2"/>


                                <div class="row">

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="arabic_lang_icon"><?php echo $this->lang->line("Arabic language flag"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="arabic_lang_icon" name="arabic_lang_icon"
                                                       class="form-control"
                                                       value="<?php echo $n_config['arabic_lang_icon']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('arabic_lang_icon'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="hebrew_lang_icon"><?php echo $this->lang->line("Hebrew language flag"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="hebrew_lang_icon" name="hebrew_lang_icon"
                                                       class="form-control"
                                                       value="<?php echo $n_config['hebrew_lang_icon']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('hebrew_lang_icon'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="spain_lang_icon"><?php echo $this->lang->line("Spain language flag"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="spain_lang_icon" name="spain_lang_icon"
                                                       class="form-control"
                                                       value="<?php echo $n_config['spain_lang_icon']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('spain_lang_icon'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 mb-1">
                                        <div class="row">

                                            <?php
                                            $path = FCPATH . '/n_assets/app-assets/fonts/flag-icon-css/flags/4x3/';
                                            $files = array_diff(scandir($path), array('.', '..'));
                                            foreach ($files as $kl => $vl) {
                                                $vl = str_replace('.svg', '', $vl);
                                                echo '<div class="width-5-per mb-1"><i class="flag-icon flag-icon-' . $vl . '"></i><br />' . $vl . '</div>';
                                            }

                                            ?>
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="special_pages" aria-labelledby="special_pages"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Special pages"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <h4 class="col-12 mb-1">Help page editor (BETA)</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Help page (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['page_help_view'])) {
                                                $select_lan = $n_config['page_help_view'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('page_help_view', $options, $select_lan, 'class="select2 form-control" id="page_help_view"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('page_help_view'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Help page (only view for admin)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['page_help_only_admin'])) {
                                                $select_lan = $n_config['page_help_only_admin'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('page_help_only_admin', $options, $select_lan, 'class="select2 form-control" id="page_help_only_admin"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('page_help_only_admin'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="page_help_default">Default display if not found translation
                                                (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="page_help_default" name="page_help_default"
                                                       class="form-control" placeholder="Empty for non display"
                                                       value="<?php echo $n_config['page_help_default']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('page_help_default'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Help page editor"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/editor_page/help_' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                                <hr/>

                                <div class="row">

                                    <h4 class="col-12 mb-1">FAQ page editor</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("FAQ page (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['page_faq_view'])) {
                                                $select_lan = $n_config['page_faq_view'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('page_faq_view', $options, $select_lan, 'class="select2 form-control" id="page_faq_view"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('page_faq_view'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("FAQ page (only view for admin)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['page_faq_only_admin'])) {
                                                $select_lan = $n_config['page_faq_only_admin'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('page_faq_only_admin', $options, $select_lan, 'class="select2 form-control" id="page_faq_only_admin"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('page_faq_only_admin'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="page_faq_default">Default display if not found translation
                                                (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="page_faq_default" name="page_faq_default"
                                                       class="form-control" placeholder="Empty for non display"
                                                       value="<?php echo $n_config['page_faq_default']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('page_faq_default'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Help page editor"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/faq_edit/' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                                <hr/>

                                <div class="row">

                                    <h4 class="col-12 mb-1">Login page text (replace image)</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show text (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['login_page_text_show'])) {
                                                $select_lan = $n_config['login_page_text_show'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('login_page_text_show', $options, $select_lan, 'class="select2 form-control" id="login_page_text_show"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('page_faq_view'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="login_page_text_default">Default display if not found
                                                translation (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="login_page_text_default"
                                                       name="login_page_text_default" class="form-control"
                                                       placeholder="Empty for non display"
                                                       value="<?php echo $n_config['login_page_text_default']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('login_page_text_default'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Help page editor"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/editor_page/login_html_' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                                <hr/>

                                <div class="row">

                                    <h4 class="col-12 mb-1">SignUp page text (replace image)</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show text (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['signup_page_view'])) {
                                                $select_lan = $n_config['signup_page_view'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('signup_page_view', $options, $select_lan, 'class="select2 form-control" id="signup_page_view"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('signup_page_view'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="signup_page_default_view">Default display if not found
                                                translation (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="signup_page_default_view"
                                                       name="signup_page_default_view" class="form-control"
                                                       placeholder="Empty for non display"
                                                       value="<?php echo $n_config['signup_page_default_view']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('signup_page_default_view'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Help page editor"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/editor_page/signup_html_' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                                <hr/>

                                <div class="row">

                                    <h4 class="col-12 mb-1">Account activation page text (replace image)</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show text (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['account_activation_view'])) {
                                                $select_lan = $n_config['account_activation_view'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('account_activation_view', $options, $select_lan, 'class="select2 form-control" id="account_activation_view"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('account_activation_view'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="account_activation_default_view">Default display if not found
                                                translation (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="account_activation_default_view"
                                                       name="account_activation_default_view" class="form-control"
                                                       placeholder="Empty for non display"
                                                       value="<?php echo $n_config['account_activation_default_view']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('account_activation_default_view'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Help page editor"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/editor_page/account_activation_html_' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                                <hr/>

                                <div class="row">

                                    <h4 class="col-12 mb-1">Forgot password page text (replace image)</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show text (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['forgot_password_view'])) {
                                                $select_lan = $n_config['forgot_password_view'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('forgot_password_view', $options, $select_lan, 'class="select2 form-control" id="forgot_password_view"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('signup_page_view'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="forgot_password_default_view">Default display if not found
                                                translation (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="forgot_password_default_view"
                                                       name="signup_page_default_view" class="form-control"
                                                       placeholder="Empty for non display"
                                                       value="<?php echo $n_config['forgot_password_default_view']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('forgot_password_default_view'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Help page editor"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/editor_page/forgot_password_html_' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="dashboard" aria-labelledby="dashboard"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Special pages"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">


                                <div class="row">

                                    <h4 class="col-12 mb-1">Dashboard section editor (BETA)</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Custom dashboard section (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['dashboard_section_1_on'])) {
                                                $select_lan = $n_config['dashboard_section_1_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('dashboard_section_1_on', $options, $select_lan, 'class="select2 form-control" id="dashboard_section_1_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('dashboard_section_1_on'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Custom dashboard section place"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['dashboard_section_init'])) {
                                                $select_lan = $n_config['dashboard_section_init'];
                                            }
                                            $options = array();
                                            $options['1'] = 'section 1 (before total subscribers)';
                                            $options['2'] = 'section 2 (Before last 7 days subscribers)';
                                            $options['3'] = 'section 3 (Before male vs subscribers)';

                                            echo form_dropdown('dashboard_section_init', $options, $select_lan, 'class="select2 form-control" id="dashboard_section_init"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('dashboard_section_init'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Custom dashboard section (only view for admin)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['dashboard_section_1_only_admin'])) {
                                                $select_lan = $n_config['dashboard_section_1_only_admin'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('dashboard_section_1_only_admin', $options, $select_lan, 'class="select2 form-control" id="dashboard_section_1_only_admin"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('dashboard_section_1_only_admin'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="dashboard_section_1_default">Default display if not found
                                                translation (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="dashboard_section_1_default"
                                                       name="dashboard_section_1_default" class="form-control"
                                                       placeholder="Empty for non display"
                                                       value="<?php echo $n_config['dashboard_section_1_default']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dashboard_section_1_default'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Theme settings"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/editor_page/dashboard_' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                                <hr/>

                                <div class="row">

                                    <h4 class="col-12 mb-1">Dashboard welcome modal</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Welcome modal (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['start_modal_show'])) {
                                                $select_lan = $n_config['start_modal_show'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('start_modal_show', $options, $select_lan, 'class="select2 form-control" id="start_modal_show"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('start_modal_show'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Welcome modal (only view for admin)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['start_modal_only_admin'])) {
                                                $select_lan = $n_config['start_modal_only_admin'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('start_modal_only_admin', $options, $select_lan, 'class="select2 form-control" id="start_modal_only_admin"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('start_modal_only_admin'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="start_modal_default">Default welcome modal (empty for no
                                                display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="start_modal_default" name="start_modal_default"
                                                       class="form-control" placeholder="Empty for non display"
                                                       value="<?php echo $n_config['start_modal_default']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('start_modal_default'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Welcome modal always show on start dashboard"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['start_modal_always_show'])) {
                                                $select_lan = $n_config['start_modal_always_show'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('start_modal_always_show', $options, $select_lan, 'class="select2 form-control" id="start_modal_always_show"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('start_modal_always_show'); ?></span>
                                    </div>


                                    <div class="col-12 mb-1">
                                        <p>Button text</p>
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) {
                                                $value_lang = strtolower($value_lang);
                                                if (!isset($n_config['welcome_modal_button_text_' . $value_lang])) {
                                                    continue;
                                                }
                                                ?>
                                                <div class="col-6 mb-1">

                                                    <fieldset>
                                                        <label for="welcome_modal_button_text_<?php echo $value_lang; ?>"><?php echo $value_lang; ?></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                            class='bx bx-flag'></i></span>
                                                            </div>
                                                            <input type="text"
                                                                   id="welcome_modal_button_text_<?php echo $value_lang; ?>"
                                                                   name="welcome_modal_button_text_<?php echo $value_lang; ?>"
                                                                   class="form-control" placeholder="Empty for default"
                                                                   value="<?php echo $n_config['welcome_modal_button_text_' . $value_lang]; ?>">
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('welcome_modal_button_text_' . $value_lang); ?></span>
                                                    </fieldset>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>

                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Theme settings"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/editor_page/welcome_modal_' . $key_lang); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>


                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="ecommerce_set" aria-labelledby="ecommerce_set"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Ecommerce"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="recommend_photoswipe_resolution">Photoswipe (full view photo)
                                                recommend photo resolution. 0x0 is auto</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-image'></i></span>
                                                </div>
                                                <input type="text" id="recommend_photoswipe_resolution"
                                                       name="recommend_photoswipe_resolution" class="form-control"
                                                       placeholder="Photoswipe (full view photo) recommend photo resolution. 0x0 is auto"
                                                       value="<?php echo $n_config['recommend_photoswipe_resolution']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('recommend_photoswipe_resolution'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="ecommerce_product_gallery">Max photos in product gallery</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-image'></i></span>
                                                </div>
                                                <input type="number" id="ecommerce_product_gallery"
                                                       name="ecommerce_product_gallery" class="form-control"
                                                       value="<?php echo $n_config['ecommerce_product_gallery']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('ecommerce_product_gallery'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Custom domain"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['eco_custom_domain'])) {
                                                $select_lan = $n_config['eco_custom_domain'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('eco_custom_domain', $options, $select_lan, 'class="select2 form-control" id="eco_custom_domain"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('eco_custom_domain'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="custom_domain_host">Main URL host (your app) without http</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="custom_domain_host" name="custom_domain_host"
                                                       class="form-control" value="<?php
                                                if (empty($n_config['custom_domain_host'])) {
                                                    $result = parse_url($this->config->base_url());
                                                    $n_config['custom_domain_host'] = $result['host'];
                                                }

                                                echo $n_config['custom_domain_host']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('custom_domain_host'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="custom_domain_host">Wildcard Domain for ecommerce / landing page builder without http</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="wildcard_domain" name="wildcard_domain"
                                                       class="form-control" value="<?php
                                                if (empty($n_config['wildcard_domain'])) {
                                                    $result = parse_url($this->config->base_url());
                                                    $n_config['wildcard_domain'] = $result['host'];
                                                }

                                                echo $n_config['wildcard_domain']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('wildcard_domain'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Ecommerce webhook"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['webhook_disable'])) {
                                                $select_lan = $n_config['webhook_disable'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Activated';
                                            $options['true'] = 'Disabled';

                                            echo form_dropdown('webhook_disable', $options, $select_lan, 'class="select2 form-control" id="webhook_disable"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('webhook_disable'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Ecommerce sitemap"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['sitemap_disable'])) {
                                                $select_lan = $n_config['sitemap_disable'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Activated';
                                            $options['true'] = 'Disabled';

                                            echo form_dropdown('sitemap_disable', $options, $select_lan, 'class="select2 form-control" id="sitemap_disable"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('sitemap_disable'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Ecommerce PWA"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['pwa_disable'])) {
                                                $select_lan = $n_config['pwa_disable'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Activated';
                                            $options['true'] = 'Disabled';

                                            echo form_dropdown('pwa_disable', $options, $select_lan, 'class="select2 form-control" id="pwa_disable"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('pwa_disable'); ?></span>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="marketing_features"
                             aria-labelledby="marketing_features" aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Marketing Features"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show renew button for trial package and before expire X days "); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['show_renew_button'])) {
                                                $select_lan = $n_config['show_renew_button'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('show_renew_button', $options, $select_lan, 'class="select2 form-control" id="show_renew_button"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('show_renew_button'); ?></span>

                                        <div class="d-flex"><img class="img-fluid"
                                                                 src="<?php echo base_url('n_assets/img/renew_button.png'); ?>"/>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="show_renew_button_days">Before X days show renew button
                                                (disabled if renew button hidden)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="number" id="show_renew_button_days"
                                                       name="show_renew_button_days" class="form-control"
                                                       value="<?php echo $n_config['show_renew_button_days']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('show_renew_button_days'); ?></span>
                                        </fieldset>
                                    </div>

                                </div>

                                <hr/>

                                <div class="row">

                                    <h4 class="col-12 mb-1">Price plan FAQ editor</h4>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Price plan FAQ editor (view for all)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['package_qa_show'])) {
                                                $select_lan = $n_config['package_qa_show'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('package_qa_show', $options, $select_lan, 'class="select2 form-control" id="package_qa_show"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('package_qa_show'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Price plan FAQ editor (only view for admin)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['package_qa_only_admin'])) {
                                                $select_lan = $n_config['package_qa_only_admin'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Show';
                                            $options['false'] = 'Hide';

                                            echo form_dropdown('package_qa_only_admin', $options, $select_lan, 'class="select2 form-control" id="package_qa_only_admin"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('package_qa_only_admin'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="package_qa_default">Default display if not found translation
                                                (empty for no display)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="package_qa_default" name="package_qa_default"
                                                       class="form-control" placeholder="Empty for non display"
                                                       value="<?php echo $n_config['package_qa_default']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('package_qa_default'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 mb-1">
                                        <div class="row">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>
                                                <div class="col-3 p-0 text-center mb-1">


                                                    <a title="<?php echo $this->lang->line("Help page editor"); ?>"
                                                       class="btn btn-outline-primary"
                                                       href="<?php echo base_url('/n_theme/faq_edit/' . $key_lang . '/payment'); ?>">
                                                        <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit') . ' ' . $key_lang; ?>
                                                    </a>

                                                </div>

                                            <?php } ?>

                                        </div>

                                    </div>


                                </div>

                                <hr/>

                                <div class="row">
                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("OneSignal Integration"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['onesignal_enabled'])) {
                                                $select_lan = $n_config['onesignal_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Enabled';
                                            $options['false'] = 'Disabled';

                                            echo form_dropdown('onesignal_enabled', $options, $select_lan, 'class="select2 form-control" id="onesignal_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('onesignal_enabled'); ?></span>

                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="onesignal_app_key"><?php echo $this->lang->line("OneSignal App Key"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="onesignal_app_key"
                                                       name="onesignal_app_key" class="form-control"
                                                       value="<?php echo $n_config['onesignal_app_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('onesignal_app_key'); ?></span>
                                        </fieldset>
                                    </div>

                                </div>


                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="pwa_settings" aria-labelledby="pwa_settings"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("PWA Settings"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("PWA On / Off"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['pwa_on'])) {
                                                $select_lan = $n_config['pwa_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('pwa_on', $options, $select_lan, 'class="select2 form-control" id="pwa_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('pwa_on'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="pwa_name">PWA app name (used in the banner)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bx-mobile-alt'></i></span>
                                                </div>
                                                <input type="text" id="pwa_name" name="pwa_name" class="form-control"
                                                       value="<?php echo $n_config['pwa_name']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('pwa_name'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="pwa_short_name">PWA app short name (used on the home
                                                screen)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bx-mobile-alt'></i></span>
                                                </div>
                                                <input type="text" id="pwa_short_name" name="pwa_short_name"
                                                       class="form-control"
                                                       value="<?php echo $n_config['pwa_short_name']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('pwa_short_name'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="pwa_description">PWA app description</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bx-mobile-alt'></i></span>
                                                </div>
                                                <textarea type="text" id="pwa_description" name="pwa_description"
                                                          class="form-control"><?php echo $n_config['pwa_description']; ?></textarea>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('pwa_description'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="pwa_theme_color">PWA theme color</label>
                                            <div class="input-group">
                                                <input type="text" id="pwa_theme_color" name="pwa_theme_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['pwa_theme_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('pwa_theme_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="pwa_background_color">PWA background color</label>
                                            <div class="input-group">
                                                <input type="text" id="pwa_background_color" name="pwa_background_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['pwa_background_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('pwa_background_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="pwa_icon_512">PWA Icon PNG: 512x512 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="pwa_icon_512"
                                                           name="pwa_icon_512">
                                                    <label class="custom-file-label" for="pwa_icon_512">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('pwa_icon_512'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("apple-mobile-web-app-status-bar-style"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['pwa_apple_status_bar'])) {
                                                $select_lan = $n_config['pwa_apple_status_bar'];
                                            }
                                            $options = array();
                                            $options['default'] = 'default';
                                            $options['black'] = 'black';
                                            $options['black-translucent'] = 'black-translucent';

                                            echo form_dropdown('pwa_apple_status_bar', $options, $select_lan, 'class="select2 form-control" id="pwa_apple_status_bar"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('pwa_apple_status_bar'); ?></span>
                                    </div>

                                </div>

                                <hr class="mb-3"/>

                                <div class="row" id="pwa_splash">
                                    <div class="col-12">
                                        <h4 class="card-title">IOS Splash Screen</h4>
                                        <p><a href="https://progressier.com/pwa-icons-and-ios-splash-screen-generator">Tool for help generate
                                                splash screen</a></p>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="ipad_splash"><?php $imagecheck('ipad_splash'); ?> ipad_splash png iPad Mini, Air (9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait) (1536px x
                                                2048px)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="ipad_splash"
                                                           name="ipad_splash">
                                                    <label class="custom-file-label" for="ipad_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('ipad_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="ipadpro1_splash"><?php $imagecheck('ipadpro1_splash'); ?> ipadpro1_splash png (10.5__iPad_Air_portrait) iPad Pro 10.5" (1668px x
                                                2224px)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="ipadpro1_splash"
                                                           name="ipadpro1_splash">
                                                    <label class="custom-file-label" for="ipadpro1_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('ipadpro1_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="ipadpro2_splash"><?php $imagecheck('ipadpro2_splash'); ?> ipadpro2_splash png iPad Pro 12.9" (12.9__iPad_Pro_portrait) (2048px x
                                                2732px)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="ipadpro2_splash"
                                                           name="ipadpro2_splash">
                                                    <label class="custom-file-label" for="ipadpro2_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('ipadpro2_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="ipadpro3_splash"><?php $imagecheck('ipadpro3_splash'); ?> ipadpro3_splash png (11__iPad_Pro__10.5__iPad_Pro_portrait) 1668x2388</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="ipadpro3_splash"
                                                           name="ipadpro3_splash">
                                                    <label class="custom-file-label" for="ipadpro3_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('ipadpro3_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="iphone5_splash"><?php $imagecheck('iphone5_splash'); ?> iphone5_splash png iPhone 5 (4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait) (640px x
                                                1136px)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="iphone5_splash"
                                                           name="iphone5_splash">
                                                    <label class="custom-file-label" for="iphone5_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('iphone5_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="iphone6_splash"><?php $imagecheck('iphone6_splash'); ?> iphone6_splash png iPhone 8, 7, 6s, 6 (iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait) (750px x
                                                1334px)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="iphone6_splash"
                                                           name="iphone6_splash">
                                                    <label class="custom-file-label" for="iphone6_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('iphone6_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="iphoneplus_splash"><?php $imagecheck('iphoneplus_splash'); ?> iphoneplus_splash png iPhone 8 Plus, 7 Plus,
                                                6s Plus, 6 Plus (iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait) (1242px x 2208px)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="iphoneplus_splash"
                                                           name="iphoneplus_splash">
                                                    <label class="custom-file-label" for="iphoneplus_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('iphoneplus_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="iphonex_splash"><?php $imagecheck('iphonex_splash'); ?> iphonex_splash png iPhone X (iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait) (1125px x
                                                2436px)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="iphonex_splash"
                                                           name="iphonex_splash">
                                                    <label class="custom-file-label" for="iphonex_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('iphonex_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="iphonexr_splash"><?php $imagecheck('iphonexr_splash'); ?> iphonexr_splash png (iPhone_11__iPhone_XR_portrait) 828x1792px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="iphonexr_splash"
                                                           name="iphonexr_splash">
                                                    <label class="custom-file-label" for="iphonexr_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('iphonexr_splash'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="iphonexsmax_splash">
                                                <?php $imagecheck('iphonexsmax_splash'); ?>
                                                iphonexsmax_splash png (iPhone_11_Pro_Max__iPhone_XS_Max_portrait) 1242x2688px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="iphonexsmax_splash"
                                                           name="iphonexsmax_splash">
                                                    <label class="custom-file-label" for="iphonexsmax_splash">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('iphonexsmax_splash'); ?></span>
                                        </fieldset>
                                    </div>




                                    <?php
                                    $n_ios_splash_name = '8_3__iPad_Mini_portrait';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); ?>
                                                8_3__iPad_Mini_portrait png 1488x2266px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '10_2__iPad_portrait';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                 png 1620x2160 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '10_9__iPad_Air_portrait';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1640x2360 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1284x2778 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1170x2532 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1179x2556 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_portrait';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1290x2796 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>


                                    <?php
                                    $n_ios_splash_name = '8_3__iPad_Mini_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2266x1488 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '9_7__iPad_Pro__7_9__iPad_mini__9_7__iPad_Air__9_7__iPad_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2048x1536 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '10_2__iPad_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2160x1620 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '10_5__iPad_Air_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2224x1668 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '10_9__iPad_Air_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2224x1668 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '11__iPad_Pro__10_5__iPad_Pro_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2388x1668 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>


                                    <?php
                                    $n_ios_splash_name = '12_9__iPad_Pro_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2388x1668 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = '4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1136x640 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>


                                    <?php
                                    $n_ios_splash_name = 'iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4_7__iPhone_SE_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1334x750 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2208x1242 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_11__iPhone_XR_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 1792x828  px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_11_Pro_Max__iPhone_XS_Max_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2688x1242 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2436x1125 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2532x1170 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2778x1284 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2557x1179 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>

                                    <?php
                                    $n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape';
                                    ?>
                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                png 2796x1290 px</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                        </fieldset>
                                    </div>


                                </div>

                                <hr class="mb-3"/>


                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="colors" aria-labelledby="colors"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Appearence Settings"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Style version flow builder"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['default_flowbuilder'])) {
                                                $select_lan = $n_config['default_flowbuilder'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Default flow builder';
                                            $options['false'] = 'NVX style flow builder';

                                            echo form_dropdown('default_flowbuilder', $options, $select_lan, 'class="select2 form-control" id="default_flowbuilder"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('default_flowbuilder'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Appearence On"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['theme_appeareance_on'])) {
                                                $select_lan = $n_config['theme_appeareance_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'Custom';
                                            $options['false'] = 'Default theme';

                                            echo form_dropdown('theme_appeareance_on', $options, $select_lan, 'class="select2 form-control" id="theme_appeareance_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('theme_appeareance_on'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="nav_font">Navigation google fonts name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-font'></i></span>
                                                </div>
                                                <input type="text" id="nav_font" name="nav_font" class="form-control"
                                                       value="<?php echo $n_config['nav_font']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('nav_font'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="body_font">Body google fonts name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-font'></i></span>
                                                </div>
                                                <input type="text" id="body_font" name="body_font" class="form-control"
                                                       value="<?php echo $n_config['body_font']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('body_font'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Sidebar icons family"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['sidebar_icons'])) {
                                                $select_lan = $n_config['sidebar_icons'];
                                            }
                                            $options = array();
                                            $options['livicons'] = 'LivIcons';
                                            $options['boxicons'] = 'BoxIcons';

                                            echo form_dropdown('sidebar_icons', $options, $select_lan, 'class="select2 form-control" id="sidebar_icons"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('sidebar_icons'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Sidebar icon style"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['livicon_icon_style'])) {
                                                $select_lan = $n_config['livicon_icon_style'];
                                            }
                                            $options = array();
                                            $options['original'] = 'Livicons original';
                                            $options['solid'] = 'Livicons solid';
                                            $options['filled'] = 'Livicons filled';
                                            $options['lines'] = 'Livicons lines';
                                            $options['lines-alt'] = 'Livicons lines-alt';
                                            $options['linesAlt'] = 'Livicons linesAlt';

                                            echo form_dropdown('livicon_icon_style', $options, $select_lan, 'class="select2 form-control" id="livicon_icon_style"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('livicon_icon_style'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Theme mobile full width (padding left/right set to 0px)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['theme_mobile_full_width'])) {
                                                $select_lan = $n_config['theme_mobile_full_width'];
                                            }
                                            $options = array();
                                            $options['false'] = 'Disabled';
                                            $options['true'] = 'Enabled';

                                            echo form_dropdown('theme_mobile_full_width', $options, $select_lan, 'class="select2 form-control" id="theme_mobile_full_width"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('theme_mobile_full_width'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Sidebar default view"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['current_sidebar'])) {
                                                $select_lan = $n_config['current_sidebar'];
                                            }
                                            $options = array();
                                            $options['menu-expanded'] = 'menu-expanded';
                                            $options['menu-collapsed'] = 'menu-collapsed';

                                            echo form_dropdown('current_sidebar', $options, $select_lan, 'class="select2 form-control" id="current_sidebar"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('current_sidebar'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="body_font_font_size">Body font size</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bx-font-size'></i></span>
                                                </div>
                                                <input type="text" id="body_font_font_size" name="body_font_font_size"
                                                       class="form-control"
                                                       value="<?php echo $n_config['body_font_font_size']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('body_font_font_size'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="card_title_font_size">Card title font size</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bx-font-size'></i></span>
                                                </div>
                                                <input type="text" id="card_title_font_size" name="card_title_font_size"
                                                       class="form-control"
                                                       value="<?php echo $n_config['card_title_font_size']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('card_title_font_size'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="sidebar_icon_help_bx">Icon HELP (BoxIcon)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-image'></i></span>
                                                </div>
                                                <input type="text" id="sidebar_icon_help_bx" name="sidebar_icon_help_bx"
                                                       class="form-control"
                                                       value="<?php echo $n_config['sidebar_icon_help_bx']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('sidebar_icon_help_bx'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="sidebar_icon_help_livicons">Icon HELP (LivIcons)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-image'></i></span>
                                                </div>
                                                <input type="text" id="sidebar_icon_help_bx"
                                                       name="sidebar_icon_help_livicons" class="form-control"
                                                       value="<?php echo $n_config['sidebar_icon_help_livicons']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('sidebar_icon_help_livicons'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="sidebar_icon_faq_bx">Icon FAQ (BoxIcon)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-image'></i></span>
                                                </div>
                                                <input type="text" id="sidebar_icon_faq_bx" name="sidebar_icon_faq_bx"
                                                       class="form-control"
                                                       value="<?php echo $n_config['sidebar_icon_faq_bx']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('sidebar_icon_faq_bx'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="sidebar_icon_faq_livicons">Icon FAQ (LivIcons)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-image'></i></span>
                                                </div>
                                                <input type="text" id="sidebar_icon_faq_bx"
                                                       name="sidebar_icon_faq_livicons" class="form-control"
                                                       value="<?php echo $n_config['sidebar_icon_faq_livicons']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('sidebar_icon_faq_livicons'); ?></span>
                                        </fieldset>
                                    </div>


                                </div>

                                <div class="row" id="colors_in">

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="theme_sidebar_color">Semi dark sidebar color</label>
                                            <div class="input-group">
                                                <input type="text" id="theme_sidebar_color" name="theme_sidebar_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['theme_sidebar_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('theme_sidebar_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="dark_icon_color">Sidebar icon color</label>
                                            <div class="input-group">
                                                <input type="text" id="dark_icon_color" name="dark_icon_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['dark_icon_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dark_icon_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="sidebar_text_color">Sidebar text color</label>
                                            <div class="input-group">
                                                <input type="text" id="sidebar_text_color" name="sidebar_text_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['sidebar_text_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('sidebar_text_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="primary_color">Primary color</label>
                                            <div class="input-group">
                                                <input type="text" id="primary_color" name="primary_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['primary_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('primary_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="primary_outline_color">Primary outline color</label>
                                            <div class="input-group">
                                                <input type="text" id="primary_outline_color"
                                                       name="primary_outline_color" class="form-control"
                                                       value="<?php echo $n_config['primary_outline_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('primary_outline_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="primary_color_hover">Primary hover color</label>
                                            <div class="input-group">
                                                <input type="text" id="primary_color_hover" name="primary_color_hover"
                                                       class="form-control"
                                                       value="<?php echo $n_config['primary_color_hover']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('primary_color_hover'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="light_primary_color">Light primary color</label>
                                            <div class="input-group">
                                                <input type="text" id="light_primary_color" name="light_primary_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['light_primary_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('light_primary_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="danger_color">Danger color</label>
                                            <div class="input-group">
                                                <input type="text" id="danger_color" name="danger_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['danger_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('danger_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="success_color">Success color</label>
                                            <div class="input-group">
                                                <input type="text" id="success_color" name="success_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['success_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('success_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="warning_color">Warning color</label>
                                            <div class="input-group">
                                                <input type="text" id="warning_color" name="warning_color"
                                                       class="form-control"
                                                       value="<?php echo $n_config['warning_color']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('warning_color'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="btn_primary_color_hover">Button primary hover color</label>
                                            <div class="input-group">
                                                <input type="text" id="btn_primary_color_hover"
                                                       name="btn_primary_color_hover" class="form-control"
                                                       value="<?php echo $n_config['btn_primary_color_hover']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('btn_primary_color_hover'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="dashboard_background">Dashboard background</label>
                                            <div class="input-group">
                                                <input type="text" id="dashboard_background" name="dashboard_background"
                                                       class="form-control"
                                                       value="<?php echo $n_config['dashboard_background']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dashboard_background'); ?></span>
                                        </fieldset>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="rtl_set" aria-labelledby="rtl_set"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("RTL Settings"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="rtl_langs">RTL languages, use comma for seperate
                                                language</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-flag'></i></span>
                                                </div>
                                                <input type="text" id="rtl_langs" name="rtl_langs" class="form-control"
                                                       value="<?php echo $n_config['rtl_langs']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('rtl_langs'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="nav_font_rtl">Navigation google fonts name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-font'></i></span>
                                                </div>
                                                <input type="text" id="nav_font_rtl" name="nav_font_rtl"
                                                       class="form-control"
                                                       value="<?php echo $n_config['nav_font_rtl']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('nav_font_rtl'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="body_font_rtl">Body google fonts name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bx-font'></i></span>
                                                </div>
                                                <input type="text" id="body_font_rtl" name="body_font_rtl"
                                                       class="form-control"
                                                       value="<?php echo $n_config['body_font_rtl']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('body_font_rtl'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="light_logo_rtl">Logo for light mode. </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="light_logo_rtl"
                                                           name="light_logo_rtl">
                                                    <label class="custom-file-label" for="light_logo_rtl">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('light_logo_rtl'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="dark_logo_rtl">Logo for dark mode.</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="dark_logo_rtl"
                                                           name="dark_logo_rtl">
                                                    <label class="custom-file-label" for="dark_logo_rtl">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dark_logo_rtl'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="dark_icon_rtl">Icon for collapsed sidebar (dark mode), recommend
                                                size: 170x44</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="dark_icon_rtl"
                                                           name="dark_icon_rtl">
                                                    <label class="custom-file-label" for="dark_icon_rtl">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dark_icon_rtl'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="light_icon_rtl">Icon for collapsed sidebar (light mode)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="light_icon_rtl"
                                                           name="light_icon_rtl">
                                                    <label class="custom-file-label" for="light_icon_rtl">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('light_icon_rtl'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="body_font_font_size_rtl">Body font size</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bx-font-size'></i></span>
                                                </div>
                                                <input type="text" id="body_font_font_size_rtl"
                                                       name="body_font_font_size_rtl" class="form-control"
                                                       value="<?php echo $n_config['body_font_font_size_rtl']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('body_font_font_size_rtl'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-4 mb-1">
                                        <fieldset>
                                            <label for="card_title_font_size_rtl">Card title font size</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bx-font-size'></i></span>
                                                </div>
                                                <input type="text" id="card_title_font_size_rtl"
                                                       name="card_title_font_size_rtl" class="form-control"
                                                       value="<?php echo $n_config['card_title_font_size_rtl']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('card_title_font_size_rtl'); ?></span>
                                        </fieldset>
                                    </div>

                                </div>


                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="pay_gat" aria-labelledby="pay_gat"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Payment Gateways"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <?php
                                $omise_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php')) {
                                    $omise_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $omise_hide; ?>">

                                    <div class="col-12">
                                        <h4>Omise Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="omise_public_key">Omise Public Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="omise_public_key" name="omise_public_key"
                                                       class="form-control"
                                                       value="<?php echo $n_config['omise_public_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('omise_public_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="omise_secret_key">Omise Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="omise_secret_key" name="omise_secret_key"
                                                       class="form-control"
                                                       value="<?php echo $n_config['omise_secret_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('omise_secret_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Omise On"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['omise_on'])) {
                                                $select_lan = $n_config['omise_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('omise_on', $options, $select_lan, 'class="select2 form-control" id="omise_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('omise_on'); ?></span>
                                    </div>

                                </div>

                                <?php
                                $paymongo_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php')) {
                                    $paymongo_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $paymongo_hide; ?>">

                                    <div class="col-12">
                                        <h4>Paymongo Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_paymongo_pub">Paymongo Public Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_paymongo_pub" name="n_paymongo_pub"
                                                       class="form-control"
                                                       value="<?php echo $n_config['n_paymongo_pub']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_paymongo_pub'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_paymongo_sec">Paymongo Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_paymongo_sec" name="n_paymongo_sec"
                                                       class="form-control"
                                                       value="<?php echo $n_config['n_paymongo_sec']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_paymongo_sec'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Paymongo Card On"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_paymongo_gateway_enabled'])) {
                                                $select_lan = $n_config['n_paymongo_gateway_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_paymongo_gateway_enabled', $options, $select_lan, 'class="select2 form-control" id="n_paymongo_gateway_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_paymongo_gateway_enabled'); ?></span>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Paymongo GCash On"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_paymongo_gateway_gcash_enabled'])) {
                                                $select_lan = $n_config['n_paymongo_gateway_gcash_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_paymongo_gateway_gcash_enabled', $options, $select_lan, 'class="select2 form-control" id="n_paymongo_gateway_gcash_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_paymongo_gateway_gcash_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Paymongo Paymaya On"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_paymongo_gateway_paymaya_enabled'])) {
                                                $select_lan = $n_config['n_paymongo_gateway_paymaya_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_paymongo_gateway_paymaya_enabled', $options, $select_lan, 'class="select2 form-control" id="n_paymongo_gateway_paymaya_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_paymongo_gateway_paymaya_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Paymongo GrabPay On"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_paymongo_gateway_grab_enabled'])) {
                                                $select_lan = $n_config['n_paymongo_gateway_grab_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_paymongo_gateway_grab_enabled', $options, $select_lan, 'class="select2 form-control" id="n_paymongo_gateway_grab_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_paymongo_gateway_grab_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <a href="#" id="enable_paymongo_webhook" class="btn btn-sm btn-light-primary">Enable
                                            webhook, need for gcash, grab pay</a>
                                    </div>


                                </div>

                                <?php
                                $paymentwall_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php')) {
                                    $paymentwall_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $paymentwall_hide; ?>">

                                    <div class="col-12">
                                        <h4>Paymentwall Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_paymentwall_pub">Paymentwall Project Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_paymentwall_pub" name="n_paymentwall_pub"
                                                       class="form-control"
                                                       value="<?php echo $n_config['n_paymentwall_pub']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_paymentwall_pub'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_paymentwall_sec">Paymentwall Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_paymentwall_sec" name="n_paymentwall_sec"
                                                       class="form-control"
                                                       value="<?php echo $n_config['n_paymentwall_sec']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_paymentwall_sec'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Paymentwall Card On"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_paymentwall_enabled'])) {
                                                $select_lan = $n_config['n_paymentwall_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_paymentwall_enabled', $options, $select_lan, 'class="select2 form-control" id="n_paymentwall_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_paymentwall_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-12 mb-1">
                                        Add this to Project Pingback URL:
                                        <p><?php echo base_url() . "n_paymentwall/webhook"; ?></p>
                                    </div>


                                </div>


                                <?php
                                $payu_latam_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_payu_latam/controllers/N_payu_latam.php')) {
                                    $payu_latam_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $payu_latam_hide; ?>">

                                    <div class="col-12">
                                        <h4>PayU LATAM Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_payu_latam_merchantid">PayU LATAM Merchant ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_payu_latam_merchantid"
                                                       name="n_payu_latam_merchantid" class="form-control"
                                                       value="<?php echo $n_config['n_payu_latam_merchantid']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_payu_latam_merchantid'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_payu_latam_accountid">PayU LATAM Account ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_payu_latam_accountid"
                                                       name="n_payu_latam_accountid" class="form-control"
                                                       value="<?php echo $n_config['n_payu_latam_accountid']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_payu_latam_accountid'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_payu_latam_api_key">PayU LATAM API KEY</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_payu_latam_api_key" name="n_payu_latam_api_key"
                                                       class="form-control"
                                                       value="<?php echo $n_config['n_payu_latam_api_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_payu_latam_api_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("PayU LATAM Sandbox (test mode)"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_payu_latam_sandbox'])) {
                                                $select_lan = $n_config['n_payu_latam_sandbox'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_payu_latam_sandbox', $options, $select_lan, 'class="select2 form-control" id="n_payu_latam_sandbox"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_payu_latam_sandbox'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("PayU LATAM Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_payu_latam_enabled'])) {
                                                $select_lan = $n_config['n_payu_latam_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_payu_latam_enabled', $options, $select_lan, 'class="select2 form-control" id="n_payu_latam_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_payu_latam_enabled'); ?></span>
                                    </div>

                                </div>


                                <?php
                                $coinbase_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_coinbase/controllers/N_coinbase.php')) {
                                    $coinbase_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $coinbase_hide; ?>">

                                    <div class="col-12">
                                        <h4>Coinbase Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_coinbase_shared_secret">Coinbase Shared Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_coinbase_shared_secret"
                                                       name="n_coinbase_shared_secret" class="form-control"
                                                       value="<?php echo $n_config['n_coinbase_shared_secret']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_coinbase_shared_secret'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_coinbase_api_key">Coinbase API Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_coinbase_api_key"
                                                       name="n_coinbase_api_key" class="form-control"
                                                       value="<?php echo $n_config['n_coinbase_api_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_coinbase_api_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Coinbase Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_coinbase_enabled'])) {
                                                $select_lan = $n_config['n_coinbase_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_coinbase_enabled', $options, $select_lan, 'class="select2 form-control" id="n_coinbase_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_coinbase_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-12 mb-1">
                                        Add this to Coinbase Webhook in Account settings:
                                        <p><?php echo base_url() . "n_coinbase/webhook"; ?></p>
                                    </div>

                                </div>


                                <?php
                                $moamalat_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php')) {
                                    $moamalat_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $moamalat_hide; ?>">

                                    <div class="col-12">
                                        <h4>MOAMALAT Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_moamalat_merchant_id">MOAMALAT Merchant ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_moamalat_merchant_id"
                                                       name="n_moamalat_merchant_id" class="form-control"
                                                       value="<?php echo $n_config['n_moamalat_merchant_id']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_moamalat_merchant_id'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_moamalat_terminal_id">MOAMALAT Terminal ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_moamalat_terminal_id"
                                                       name="n_moamalat_terminal_id" class="form-control"
                                                       value="<?php echo $n_config['n_moamalat_terminal_id']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_moamalat_terminal_id'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_moamalat_secret_key">Moamalat Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_moamalat_secret_key"
                                                       name="n_moamalat_secret_key" class="form-control" value="*****">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_moamalat_secret_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Moamalat test mode"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_moamalat_testmode'])) {
                                                $select_lan = $n_config['n_moamalat_testmode'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_moamalat_testmode', $options, $select_lan, 'class="select2 form-control" id="n_moamalat_testmode"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_moamalat_testmode'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Moamalat Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_moamalat_enabled'])) {
                                                $select_lan = $n_config['n_moamalat_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_moamalat_enabled', $options, $select_lan, 'class="select2 form-control" id="n_moamalat_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_moamalat_enabled'); ?></span>
                                    </div>

                                </div>

                                <?php
                                $sadad_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
                                    $sadad_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $sadad_hide; ?>">

                                    <div class="col-12">
                                        <h4>SADAD Gateway</h4>
                                    </div>


                                    <div class="col-12 col-md-12 mb-1">
                                        <fieldset>
                                            <label for="n_sadad_secret_key">SADAD Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_sadad_secret_key"
                                                       name="n_sadad_secret_key" class="form-control" value="<?php echo $n_config['n_sadad_secret_key']; ?>>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_sadad_secret_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("SADAD test mode"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_sadad_testmode'])) {
                                                $select_lan = $n_config['n_sadad_testmode'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_sadad_testmode', $options, $select_lan, 'class="select2 form-control" id="n_sadad_testmode"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_sadad_testmode'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("SADAD Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_sadad_enabled'])) {
                                                $select_lan = $n_config['n_sadad_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_sadad_enabled', $options, $select_lan, 'class="select2 form-control" id="n_sadad_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_sadad_enabled'); ?></span>
                                    </div>

                                </div>

                                <?php
                                $tap_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_tap/controllers/N_tap.php')) {
                                    $tap_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $tap_hide; ?>">

                                    <div class="col-12">
                                        <h4>TAP Payment</h4>
                                    </div>


                                    <div class="col-12 col-md-12 mb-1">
                                        <fieldset>
                                            <label for="n_tap_secret">TAP Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_tap_secret"
                                                       name="n_tap_secret" class="form-control" value="<?php echo $n_config['n_tap_secret']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_tap_secret'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("TAP Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_tap_on'])) {
                                                $select_lan = $n_config['n_tap_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_tap_on', $options, $select_lan, 'class="select2 form-control" id="n_tap_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_tap_on'); ?></span>
                                    </div>

                                </div>

                                <?php
                                $mashkor_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_mashkar/controllers/N_mashkar.php')) {
                                    $mashkor_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $mashkor_hide; ?>">

                                    <div class="col-12">
                                        <h4>Mashkor API</h4>
                                    </div>


                                    <div class="col-12 col-md-12 mb-1">
                                        <fieldset>
                                            <label for="mashkor_api_key">Mashkor API Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="mashkor_api_key"
                                                       name="mashkor_api_key" class="form-control" value="<?php echo $n_config['mashkor_api_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('mashkor_api_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-12 mb-1">
                                        <fieldset>
                                            <label for="mashkor_auth_key">Mashkor AUTH Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="mashkor_auth_key"
                                                       name="mashkor_auth_key" class="form-control" value="<?php echo $n_config['mashkor_auth_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('mashkor_auth_key'); ?></span>
                                        </fieldset>
                                    </div>

                                </div>

                                <?php
                                $mastercard_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_mastercard/controllers/N_mastercard.php')) {
                                    $mastercard_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $mastercard_hide; ?>">

                                    <div class="col-12">
                                        <h4>Mastercard Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_mastercard_api_pass">Mastercard API Password</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_mastercard_api_pass"
                                                       name="n_mastercard_api_pass" class="form-control" value="<?php echo $n_config['n_mastercard_api_pass']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_mastercard_api_pass'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_mastercard_merchant_id">Mastercard Merchant ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_mastercard_merchant_id"
                                                       name="n_mastercard_merchant_id" class="form-control" value="<?php echo $n_config['n_mastercard_merchant_id']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_mastercard_merchant_id'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Mastercard test mode"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_mastercard_testmode'])) {
                                                $select_lan = $n_config['n_mastercard_testmode'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_mastercard_testmode', $options, $select_lan, 'class="select2 form-control" id="n_mastercard_testmode"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_mastercard_testmode'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Mastercard Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_mastercard_enabled'])) {
                                                $select_lan = $n_config['n_mastercard_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_mastercard_enabled', $options, $select_lan, 'class="select2 form-control" id="n_mastercard_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_mastercard_enabled'); ?></span>
                                    </div>

                                </div>


                                <?php
                                $tdsp_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php')) {
                                    $tdsp_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $tdsp_hide; ?>">

                                    <div class="col-12">
                                        <h4>TDSP Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_tdsp_store_id">TDSP Store ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_tdsp_store_id"
                                                       name="n_tdsp_store_id" class="form-control"
                                                       value="<?php echo $n_config['n_tdsp_store_id']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_tdsp_store_id'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_moamalat_terminal_id">TDSP Auth Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_tdsp_auth_key"
                                                       name="n_tdsp_auth_key" class="form-control"
                                                       value="<?php echo $n_config['n_tdsp_auth_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_tdsp_auth_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("TDSP test mode"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_tdsp_sandbox'])) {
                                                $select_lan = $n_config['n_tdsp_sandbox'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_tdsp_sandbox', $options, $select_lan, 'class="select2 form-control" id="n_tdsp_sandbox"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_tdsp_sandbox'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("TDSP Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_tdsp_enabled'])) {
                                                $select_lan = $n_config['n_tdsp_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_tdsp_enabled', $options, $select_lan, 'class="select2 form-control" id="n_tdsp_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_tdsp_enabled'); ?></span>
                                    </div>

                                </div>

                                <?php
                                $n_stripe_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')) {
                                    $n_stripe_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $n_stripe_hide; ?>">

                                    <div class="col-12">
                                        <h4>Stripe Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_stripe_secret_key">Stripe Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_stripe_secret_key"
                                                       name="n_stripe_secret_key" class="form-control"
                                                       value="<?php echo $n_config['n_stripe_secret_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_stripe_secret_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_stripe_product_image">Stripe Product Image with https://</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_stripe_product_image"
                                                       name="n_stripe_product_image" class="form-control"
                                                       value="<?php echo $n_config['n_stripe_product_image']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_stripe_product_image'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Stripe Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_stripe_enabled'])) {
                                                $select_lan = $n_config['n_stripe_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_stripe_enabled', $options, $select_lan, 'class="select2 form-control" id="n_stripe_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_stripe_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Stripe Subscription Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_stripe_subscription_enabled'])) {
                                                $select_lan = $n_config['n_stripe_subscription_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_stripe_subscription_enabled', $options, $select_lan, 'class="select2 form-control" id="n_stripe_subscription_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_stripe_subscription_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-12 mb-1">
                                        Add this to Stripe Webhook in Account settings (<a href="https://dashboard.stripe.com/webhooks" target="_blank">Stripe Webhooks</a>):<br />
                                        Events:<br />
                                        checkout.session.completed<br />
                                        invoice.paid<br />
                                        invoice.payment_failed<br />
                                        <p><?php echo base_url() . "n_stripe/webhook"; ?></p>
                                    </div>

                                </div>


                                <?php
                                $epayco_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php')) {
                                    $epayco_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $epayco_hide; ?>">

                                    <div class="col-12">
                                        <h4>ePayco Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_epayco_pkey">ePayco Public Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_epayco_pkey"
                                                       name="n_epayco_pkey" class="form-control" value="<?php echo $n_config['n_epayco_pkey']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_epayco_pkey'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_epayco_api_private_key">ePayco Private Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_epayco_api_private_key"
                                                       name="n_epayco_api_private_key" class="form-control" value="<?php echo $n_config['n_epayco_api_private_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_epayco_api_private_key'); ?></span>
                                        </fieldset>
                                    </div>



                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("ePayco test mode"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_epayco_testmode'])) {
                                                $select_lan = $n_config['n_epayco_testmode'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_epayco_testmode', $options, $select_lan, 'class="select2 form-control" id="n_epayco_testmode"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_epayco_testmode'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("ePayco Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_epayco_enabled'])) {
                                                $select_lan = $n_config['n_epayco_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_epayco_enabled', $options, $select_lan, 'class="select2 form-control" id="n_epayco_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_epayco_enabled'); ?></span>
                                    </div>



                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("ePayco Standard Checkout"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_epayco_checkout'])) {
                                                $select_lan = $n_config['n_epayco_checkout'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_epayco_checkout', $options, $select_lan, 'class="select2 form-control" id="n_epayco_checkout"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_epayco_checkout'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("ePayco Subscription Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_epayco_subs_enabled'])) {
                                                $select_lan = $n_config['n_epayco_subs_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_epayco_subs_enabled', $options, $select_lan, 'class="select2 form-control" id="n_epayco_subs_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_epayco_subs_enabled'); ?></span>
                                    </div>

                                </div>

                                <?php
                                $sellix_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php')) {
                                    $sellix_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $sellix_hide; ?>">

                                    <div class="col-12">
                                        <h4>ePayco Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_sellix_api_key">Sellix Api Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_sellix_api_key"
                                                       name="n_sellix_api_key" class="form-control" value="<?php echo $n_config['n_sellix_api_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_sellix_api_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_sellix_webhook_secret">Sellix Webhook Secret</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_sellix_webhook_secret"
                                                       name="n_sellix_webhook_secret" class="form-control" value="<?php echo $n_config['n_sellix_webhook_secret']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_sellix_webhook_secret'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_sellix_merchant">Sellix Merchant</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_sellix_merchant"
                                                       name="n_sellix_merchant" class="form-control" value="<?php echo $n_config['n_sellix_merchant']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_sellix_merchant'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Sellix Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_sellix_enabled'])) {
                                                $select_lan = $n_config['n_sellix_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_sellix_enabled', $options, $select_lan, 'class="select2 form-control" id="n_sellix_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_sellix_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1 d-none">
                                        <h6><?php echo $this->lang->line("Sellix Subscription Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_sellix_subs_enabled'])) {
                                                $select_lan = $n_config['n_sellix_subs_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_sellix_subs_enabled', $options, $select_lan, 'class="select2 form-control" id="n_sellix_subs_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_sellix_subs_enabled'); ?></span>
                                    </div>

                                </div>

                                <?php
                                $chapa_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php')) {
                                    $chapa_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $chapa_hide; ?>">

                                    <div class="col-12">
                                        <h4>Chapa Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_chapa_secret_key">Chapa API Secret Key</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_chapa_secret_key"
                                                       name="n_chapa_secret_key" class="form-control" value="<?php echo $n_config['n_chapa_secret_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_chapa_secret_key'); ?></span>
                                        </fieldset>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Chapa Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_chapa_enabled'])) {
                                                $select_lan = $n_config['n_chapa_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_chapa_enabled', $options, $select_lan, 'class="select2 form-control" id="n_chapa_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_chapa_enabled'); ?></span>
                                    </div>


                                </div>

                                <?php
                                $zaincash_hide = 'd-none';
                                if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php')) {
                                    $zaincash_hide = '';
                                }
                                ?>
                                <div class="row <?php echo $zaincash_hide; ?>">

                                    <div class="col-12">
                                        <h4>ZainCash Gateway</h4>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_zaincash_merchant_secret">ZainCash API Merchant Secret</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_zaincash_merchant_secret"
                                                       name="n_zaincash_merchant_secret" class="form-control" value="<?php echo $n_config['n_zaincash_merchant_secret']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_zaincash_merchant_secret'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_zaincash_MSISDN">ZainCash API MSISDN</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_zaincash_MSISDN"
                                                       name="n_zaincash_MSISDN" class="form-control" value="<?php echo $n_config['n_zaincash_MSISDN']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_zaincash_MSISDN'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_zaincash_merchant_id">ZainCash API Merchant ID</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_zaincash_merchant_id"
                                                       name="n_zaincash_merchant_id" class="form-control" value="<?php echo $n_config['n_zaincash_merchant_id']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_zaincash_merchant_id'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="n_zaincash_convert_price">ZainCash Convert price to IQD (use 1 for IQD)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                                </div>
                                                <input type="text" id="n_zaincash_convert_price"
                                                       name="n_zaincash_convert_price" class="form-control" value="<?php echo $n_config['n_zaincash_convert_price']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('n_zaincash_convert_price'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("ZainCash Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_zaincash_enabled'])) {
                                                $select_lan = $n_config['n_zaincash_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_zaincash_enabled', $options, $select_lan, 'class="select2 form-control" id="n_zaincash_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_zaincash_enabled'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("ZainCash TestMode Enabled"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = 'false';
                                            if (isset($n_config['n_zaincash_testmode_enabled'])) {
                                                $select_lan = $n_config['n_zaincash_testmode_enabled'];
                                            }
                                            $options = array();
                                            $options['true'] = 'On';
                                            $options['false'] = 'Off';

                                            echo form_dropdown('n_zaincash_testmode_enabled', $options, $select_lan, 'class="select2 form-control" id="n_zaincash_testmode_enabled"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('n_zaincash_testmode_enabled'); ?></span>
                                    </div>



                                </div>


                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane card" id="cron_jobs" aria-labelledby="cron_jobs"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex "><?php echo $this->lang->line("Cron jobs"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="card">
                                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                        <h4><i class="bx bx-circle"></i>
                                            <?php echo $this->lang->line("Sitemap generator"); ?>
                                            <code><?php echo $this->lang->line("Once/5 Minutes"); ?></code></h4>
                                    </div>
                                    <div class="card-body">
                                        <pre class="language-javascript"><code class="dlanguage-javascript"><span
                                                        class="token keyword"><?php echo "curl " . site_url("custom_cname/generate_sitemap/30") . " >/dev/null 2>&1"; ?></span></code></pre>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                        <h4><i class="bx bx-circle"></i>
                                            <?php echo $this->lang->line("Webhook orders"); ?>
                                            <code><?php echo $this->lang->line("Once/3 Minutes"); ?></code></h4>
                                    </div>
                                    <div class="card-body">
                                        <pre class="language-javascript"><code class="dlanguage-javascript"><span
                                                        class="token keyword"><?php echo "curl " . site_url("custom_cname/n_webhook_order/20") . " >/dev/null 2>&1"; ?></span></code></pre>
                                    </div>
                                </div>

                                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                    <h4><i class="bx bx-circle"></i>
                                        <?php echo $this->lang->line("Webhook products"); ?>
                                        <code><?php echo $this->lang->line("Once/3 Minutes"); ?></code></h4>
                                </div>
                                <div class="card-body">
                                    <pre class="language-javascript"><code class="dlanguage-javascript"><span
                                                    class="token keyword"><?php echo "curl " . site_url("custom_cname/n_webhook_product/20") . " >/dev/null 2>&1"; ?></span></code></pre>
                                </div>
                            </div>


                        </div>

                        <div role="tabpanel" class="tab-pane card" id="dynamic_price" aria-labelledby="dynamic_price"
                             aria-expanded="true">
                            <div class="card-header border-bottom">
                                <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line("Dynamic pricing"); ?></h4>
                                <?php echo $save_button; ?>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Dynamic Price Plan"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['dp_on'])) {
                                                $select_lan = $n_config['dp_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'ON';
                                            $options['false'] = 'OFF';

                                            echo form_dropdown('dp_on', $options, $select_lan, 'class="select2 form-control" id="dp_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('dp_on'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line('Show Fixed Plan'); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['dp_fixed_show'])) {
                                                $select_lan = $n_config['dp_fixed_show'];
                                            }
                                            $options = array();
                                            $options['true'] = 'ON';
                                            $options['false'] = 'OFF';

                                            echo form_dropdown('dp_fixed_show', $options, $select_lan, 'class="select2 form-control" id="dp_fixed_show"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('dp_fixed_show'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show plans using Country IP location"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['dp_country_on'])) {
                                                $select_lan = $n_config['dp_country_on'];
                                            }
                                            $options = array();
                                            $options['true'] = 'ON';
                                            $options['false'] = 'OFF';
                                            echo form_dropdown('dp_country_on', $options, $select_lan, 'class="select2 form-control" id="dp_country_on"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('dp_country_on'); ?></span>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <h6><?php echo $this->lang->line("Show field to enter coupons"); ?></h6>
                                        <div class="form-group">
                                            <?php
                                            $select_lan = false;
                                            if (isset($n_config['dp_coupons_show'])) {
                                                $select_lan = $n_config['dp_coupons_show'];
                                            }
                                            $options = array();
                                            $options['true'] = 'ON';
                                            $options['false'] = 'OFF';
                                            echo form_dropdown('dp_coupons_show', $options, $select_lan, 'class="select2 form-control" id="dp_coupons_show"'); ?>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('dp_coupons_show'); ?></span>
                                    </div>


                                    <div class="col-12 col-md-6 mb-1">
                                        <fieldset>
                                            <label for="dp_country_maxmind_db_key"><?php echo $this->lang->line("MaxMind Api Key for GeoLite2 (required for showing plans by country IP)"); ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class='bx bxs-file-html'></i></span>
                                                </div>
                                                <input type="text" id="dp_country_maxmind_db_key"
                                                       name="dp_country_maxmind_db_key" class="form-control"
                                                       value="<?php echo $n_config['dp_country_maxmind_db_key']; ?>">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('dp_country_maxmind_db_key'); ?></span>
                                        </fieldset>
                                    </div>

                                    <div class="col-12 col-md-6 mb-1">
                                        <a title="<?php echo $this->lang->line("Download Database from MaxMind"); ?>"
                                           class="btn btn-outline-primary" target="_blank"
                                           href="<?php echo base_url('n_theme/update_maxmind'); ?>">
                                            <i class='bx bxs-file-html'></i> <?php echo $this->lang->line("Download Database from MaxMind"); ?>
                                        </a>
                                        <a title="<?php echo $this->lang->line("Test MaxMind"); ?>"
                                           class="btn btn-outline-primary" target="_blank"
                                           href="<?php echo base_url('n_theme/test_maxmind'); ?>">
                                            <i class='bx bxs-file-html'></i> <?php echo $this->lang->line("Test MaxMind"); ?>
                                        </a>
                                    </div>

                                    <div class="col-12 mb-1">
                                        <div class="row">

                                            <div class="col-6 p-0 text-center mb-1">
                                                <a title="<?php echo $this->lang->line("Manage Plans"); ?>"
                                                   class="btn btn-outline-primary"
                                                   href="<?php echo base_url('price/plan_list'); ?>">
                                                    <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Manage Plans'); ?>
                                                </a>
                                            </div>

                                            <div class="col-6 p-0 text-center mb-1">
                                                <a title="<?php echo $this->lang->line("Edit VAT Country"); ?>"
                                                   class="btn btn-outline-primary"
                                                   href="<?php echo base_url('price/vat_edit'); ?>">
                                                    <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Edit VAT Country'); ?>
                                                </a>
                                            </div>

                                            <div class="col-6 p-0 text-center mb-1">
                                                <a title="<?php echo $this->lang->line("Manage Coupons"); ?>"
                                                   class="btn btn-outline-primary"
                                                   href="<?php echo base_url('/price/coupon_list'); ?>">
                                                    <i class='bx bxs-file-html'></i> <?php echo $this->lang->line('Manage Coupons'); ?>
                                                </a>
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
    </div>


</form>
