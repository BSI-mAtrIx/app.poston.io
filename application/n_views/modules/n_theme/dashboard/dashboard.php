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

if (isset($system_dashboard))
    $has_system_dashboard = 'yes';
else
    $has_system_dashboard = 'no';


$include_alertify = 1;
$include_datetimepicker = 1; //datetimepicker, daterange, moment

$id_for_user = $this->user_id;

if (isset($system_dashboard)) {
    if (is_numeric($this->uri->segment(3))) {
        $id_for_user = $this->uri->segment(3);
    } else {
        $id_for_user = $this->uri->segment(2);
    }
}

//TODO: system dashboard
//$has_system_dashboard


$this->db->select('count(id) as y, date_format(subscribed_at,"%m.%Y") AS x');
$this->db->from('messenger_bot_subscriber');
$this->db->where('permission = "1"');

if ($has_system_dashboard != 'yes') {
    $this->db->where("user_id = " . $id_for_user);
}

$this->db->where('YEAR(subscribed_at) = ' . date("Y"));
$this->db->group_by('date_format(subscribed_at,"%M%Y")');
$this->db->order_by('subscribed_at', 'asc');
$sub_data = $this->db->get()->result_array();

$sub_data_checking = array();
$sub_data_checking['01.' . date('Y')] = array('x' => '01.' . date('Y'), 'y' => 0);
$sub_data_checking['02.' . date('Y')] = array('x' => '02.' . date('Y'), 'y' => 0);
$sub_data_checking['03.' . date('Y')] = array('x' => '03.' . date('Y'), 'y' => 0);
$sub_data_checking['04.' . date('Y')] = array('x' => '04.' . date('Y'), 'y' => 0);
$sub_data_checking['05.' . date('Y')] = array('x' => '05.' . date('Y'), 'y' => 0);
$sub_data_checking['06.' . date('Y')] = array('x' => '06.' . date('Y'), 'y' => 0);
$sub_data_checking['07.' . date('Y')] = array('x' => '07.' . date('Y'), 'y' => 0);
$sub_data_checking['08.' . date('Y')] = array('x' => '08.' . date('Y'), 'y' => 0);
$sub_data_checking['09.' . date('Y')] = array('x' => '09.' . date('Y'), 'y' => 0);
$sub_data_checking['10.' . date('Y')] = array('x' => '10.' . date('Y'), 'y' => 0);
$sub_data_checking['11.' . date('Y')] = array('x' => '11.' . date('Y'), 'y' => 0);
$sub_data_checking['12.' . date('Y')] = array('x' => '12.' . date('Y'), 'y' => 0);

foreach ($sub_data as $k => $v) {
    $sub_data_checking[$v['x']] = $v;
}


$this->db->select('count(id) as y, date_format(subscribed_at,"%m.%Y") AS x');
$this->db->from('messenger_bot_subscriber');
$this->db->where('permission = "0"');
if ($has_system_dashboard != 'yes') {
    $this->db->where("user_id = " . $id_for_user);
}
$this->db->where('YEAR(subscribed_at) = ' . date('Y'));
$this->db->group_by('date_format(subscribed_at,"%M%Y")');
$this->db->order_by('subscribed_at', 'asc');
$uns_data = $this->db->get()->result_array();


$uns_data_checking = array();
$uns_data_checking['01.' . date('Y')] = array('x' => '01.' . date('Y'), 'y' => 0);
$uns_data_checking['02.' . date('Y')] = array('x' => '02.' . date('Y'), 'y' => 0);
$uns_data_checking['03.' . date('Y')] = array('x' => '03.' . date('Y'), 'y' => 0);
$uns_data_checking['04.' . date('Y')] = array('x' => '04.' . date('Y'), 'y' => 0);
$uns_data_checking['05.' . date('Y')] = array('x' => '05.' . date('Y'), 'y' => 0);
$uns_data_checking['06.' . date('Y')] = array('x' => '06.' . date('Y'), 'y' => 0);
$uns_data_checking['07.' . date('Y')] = array('x' => '07.' . date('Y'), 'y' => 0);
$uns_data_checking['08.' . date('Y')] = array('x' => '08.' . date('Y'), 'y' => 0);
$uns_data_checking['09.' . date('Y')] = array('x' => '09.' . date('Y'), 'y' => 0);
$uns_data_checking['10.' . date('Y')] = array('x' => '10.' . date('Y'), 'y' => 0);
$uns_data_checking['11.' . date('Y')] = array('x' => '11.' . date('Y'), 'y' => 0);
$uns_data_checking['12.' . date('Y')] = array('x' => '12.' . date('Y'), 'y' => 0);

foreach ($uns_data as $k => $v) {
    $v['y'] = -$v['y'];
    $uns_data_checking[$v['x']] = $v;
}

if (isset($_GET['n_demo'])) {
    $subscribed = 30;
    $unsubscribed = 5;
    $total_message_sent = 60;

    $total_subscribers = 97;

    $seven_days_subscriber_gain = 25;


    $seven_days_subscriber_chart_data = array();
    $seven_days_subscriber_chart_data[] = random_int(0, 30);
    $seven_days_subscriber_chart_data[] = random_int(0, 30);
    $seven_days_subscriber_chart_data[] = random_int(0, 30);
    $seven_days_subscriber_chart_data[] = random_int(0, 30);
    $seven_days_subscriber_chart_data[] = random_int(0, 30);
    $seven_days_subscriber_chart_data[] = random_int(0, 30);
    $seven_days_subscriber_chart_data[] = random_int(0, 30);

    $hourly_subscriber_chart_data = $seven_days_subscriber_chart_data;


    $seven_days_subscriber_chart_label = array();
    $seven_days_subscriber_chart_label[] = date('jS M', strtotime(' -6 day'));
    $seven_days_subscriber_chart_label[] = date('jS M', strtotime(' -5 day'));
    $seven_days_subscriber_chart_label[] = date('jS M', strtotime(' -4 day'));
    $seven_days_subscriber_chart_label[] = date('jS M', strtotime(' -3 day'));
    $seven_days_subscriber_chart_label[] = date('jS M', strtotime(' -2 day'));
    $seven_days_subscriber_chart_label[] = date('jS M', strtotime(' -1 day'));
    $seven_days_subscriber_chart_label[] = date('jS M', strtotime(' +0 day'));

    $hourly_subscriber_gain = 4;

    $hourly_subscriber_chart_label = $seven_days_subscriber_chart_label;

    $male_subscribers = array();
    $male_subscribers[] = 15;
    $male_subscribers[] = 5;
    $male_subscribers[] = 25;
    $male_subscribers[] = 1;
    $male_subscribers[] = 9;
    $male_subscribers[] = 0;
    $male_subscribers[] = 20;

    $female_subscribers = array();
    $female_subscribers[] = 5;
    $female_subscribers[] = 1;
    $female_subscribers[] = 20;
    $female_subscribers[] = 9;
    $female_subscribers[] = 14;
    $female_subscribers[] = 25;
    $female_subscribers[] = 18;

    $male_female_date_list = $seven_days_subscriber_chart_label;


    $combined_info['email']['male'] = 15;
    $combined_info['email']['female'] = 5;
    $combined_info['email']['total_email_gain'] = 20;

    $combined_info['phone']['male'] = 7;
    $combined_info['phone']['female'] = 19;
    $combined_info['phone']['total_phone_gain'] = 26;

    $combined_info['birthdate']['male'] = 13;
    $combined_info['birthdate']['female'] = 9;
    $combined_info['birthdate']['total_birthdate_gain'] = 22;

    $refferer_source_info['checkbox_plugin']['subscribers'] = 15;
    $refferer_source_info['sent_to_messenger']['subscribers'] = 5;
    $refferer_source_info['customer_chat_plugin']['subscribers'] = 10;
    $refferer_source_info['direct']['subscribers'] = 2;
    $refferer_source_info['comment_private_reply']['subscribers'] = 20;
    $refferer_source_info['me_link']['subscribers'] = 3;

    $sub_data_checking = array();
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '01.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '02.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '03.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '04.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '05.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '06.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '07.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '08.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '09.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '10.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '11.' . date('Y'));
    $sub_data_checking[] = array('y' => random_int(0, 30), 'x' => '12.' . date('Y'));

    $uns_data = array();
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '01.' . date('Y'));
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '02.' . date('Y'));
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '04.' . date('Y'));
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '05.' . date('Y'));
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '07.' . date('Y'));
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '08.' . date('Y'));
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '11.' . date('Y'));
    $uns_data[] = array('y' => random_int(0, 30), 'x' => '12.' . date('Y'));

    foreach ($uns_data as $k => $v) {
        $v['y'] = -$v['y'];
        $uns_data_checking[$v['x']] = $v;
    }

}


$month_name_array = array(
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
);

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


    .list-unstyled-border li {
        margin-bottom: 45px !important;
    }

    .swiper-button-prev, .swiper-button-next {
        background-image: none;
        width: 35px;
        font-size: 2.53rem;
    }

    .swiper-button-prev:focus, .swiper-button-next:focus {
        outline: none;
    }

    .swiper-button-prev:after, .swiper-button-next:after {
        font-family: 'boxicons';
    }

    .swiper-button-prev:after {
        content: '\e9af';
    }

    .swiper-button-next:after {
        content: '\e9b2';
    }

    @media only screen and (max-width: 768px) {
        .swiper-button-prev {
            font-size: 1.47rem;
            top: 55%;
        }

        .swiper-button-next {
            font-size: 1.47rem;
            top: 55%;
            width: 15px;
        }

        .swiper-parallax .swiper-slide {
            padding: 1rem 1.2rem;
        }

        .swiper-parallax img {
            height: 100% !important;
        }
    }

    #last_auto_reply_table thead tr {
        border-top: 1px solid #DFE3E7 !important;
        border-bottom: 1px solid #DFE3E7 !important;
    }

    .substat {
        padding-top: 0 !important;
    }

    .substat ul li {
        min-width: 140px;
    }

    .subscribers_source_chart > div {
        margin: 0 auto !important;
    }

    body.dark-layout .swiper-container .swiper-slide {
        background-color: transparent !important;
    }

    .alert p {
        margin-bottom: 0;
    }

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

        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title"><?php echo $this->lang->line('Total Subscribers'); ?>
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

                    <div class="row">
                        <div class="col-md-7 col-sm-12 radialbar">
                            <div class="subscribers_source_radialbar"></div>
                        </div>
                        <div class="col-md-7 col-sm-12 donut" style="display:none; padding-bottom: 25px;">
                            <div class="subscribers_source_chart"></div>
                        </div>
                        <div class="col-md-5 col-sm-12 my-auto">
                            <div class="d-flex mb-1">
                                <button id="subsdiff_rad" type="button" class="btn btn-sm btn-light-primary mr-1">
                                    Radial
                                </button>
                                <button id="subsdiff_donut" type="button" class="btn btn-sm btn-primary glow">Donut
                                </button>
                            </div>
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
    if ($n_config['dashboard_section_init'] == '2') {


        if ($n_config['dashboard_section_1_on'] == 'true' or ($n_config['dashboard_section_1_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) { ?>

            <div class="row">
                <?php echo $n_editor_data['gjs-html']; ?>
            </div>

        <?php }
    } ?>

    <div class="row">
        <div class="col-xl-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body pt-1 pb-0 pl-0 pr-0 text-left">
                    <h3 class="pl-1 mb-0"><?php echo custom_number_format($seven_days_subscriber_gain); ?></h3>
                    <span class="pl-1 text-muted"><?php echo $this->lang->line('Last 7 days subscribers'); ?></span>
                    <div id="seven_days_subscriber_chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body pt-1 pb-0 pl-0 pr-0 text-left">
                    <h3 class="pl-1 mb-0"><?php echo custom_number_format($hourly_subscriber_gain); ?></h3>
                    <span class="pl-1 text-muted"><?php echo $this->lang->line('24 hours interaction'); ?></span>
                    <div id="hourly_subscriber_chart"></div>
                </div>
            </div>
        </div>


        <div class="col-xl-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body pt-1 pb-0 pl-0 pr-0 text-left">
                    <h3 class="pl-1 mb-0"><?php echo custom_number_format($total_message_sent); ?></h3>
                    <span class="pl-1 text-muted"><?php echo $this->lang->line('Message Sent'); ?></span>
                    <div id="seven_days_messages_chart"></div>
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
        <div class="col-xs-12 col-md-8 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $this->lang->line('Male vs Female Subscribers'); ?></h4>
                </div>
                <div class="card-body p-0">
                    <div id="male_vs_female_chart" height="134"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 col-xl-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center pb-50">
                    <h4 class="card-title"><?php echo $this->lang->line("Subscriber's data"); ?></h4>

                </div>
                <div class="card-body" id="top-5-scroll">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="selected_period">
                            <?php echo $this->lang->line("This Month"); ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButtonchart">
                            <a href="#" class="dropdown-item period_change"
                               period="today"><?php echo $this->lang->line("Today"); ?></a>
                            <a href="#" class="dropdown-item period_change"
                               period="week"><?php echo $this->lang->line("Last 7 Days"); ?></a>
                            <a href="#" class="dropdown-item period_change active"
                               period="month"><?php echo $this->lang->line("This Month"); ?></a>
                            <a href="#" class="dropdown-item period_change"
                               period="year"><?php echo $this->lang->line("This Year"); ?></a>
                        </div>
                    </div>
                    <div class="text-center waiting hidden" id="period_loader"><i
                                class="bx bx-loader-circle text-center" style="font-size: 40px;"></i></div>

                    <div class="d-flex market-statistics-1 pb-2 pt-1" id="period_change_content">
                        <!-- data -->
                        <div class="statistics-data my-auto">
                            <div class="statistics">
                                <span class="font-medium-2 mr-50 text-bold-600"
                                      id="total_email_gain"><?php echo number_format($combined_info['email']['total_email_gain']); ?></span>
                                (<i class="bx
bx-male"></i><span id="email_male_number"><?php echo number_format($combined_info['email']['male']); ?></span>, <i
                                        class="bx
bx-female"></i><span id="email_male_number"><?php echo number_format($combined_info['email']['female']); ?></span>)
                            </div>
                            <div class="statistics-date">
                                <small class="text-muted"><?php echo $this->lang->line('E-mail address gain'); ?></small>
                            </div>
                        </div>
                        <!-- chart-statistics-1 -->
                        <div class="mx-auto donut-style">
                            <div id="donut-email" class="mx-1"></div>
                        </div>

                    </div>

                    <div class="d-flex market-statistics-1 pb-2 pt-1" id="period_change_content">
                        <!-- data -->
                        <div class="statistics-data my-auto">
                            <div class="statistics">
                                <span class="font-medium-2 mr-50 text-bold-600"
                                      id="total_phone_gain"><?php echo number_format($combined_info['phone']['total_phone_gain']); ?></span>
                                (<i class="bx
bx-male"></i><span id="phone_male_number"><?php echo number_format($combined_info['phone']['male']); ?></span>, <i
                                        class="bx
bx-female"></i><span id="phone_male_number"><?php echo number_format($combined_info['phone']['female']); ?></span>)
                            </div>
                            <div class="statistics-date">
                                <small class="text-muted"><?php echo $this->lang->line('Phone number gain'); ?></small>
                            </div>
                        </div>
                        <!-- chart-statistics-1 -->
                        <div class="mx-auto donut-style">
                            <div id="donut-phone" class="mx-1"></div>
                        </div>
                    </div>

                    <div class="d-flex market-statistics-1 pb-2 pt-1" id="period_change_content">
                        <!-- data -->
                        <div class="statistics-data my-auto">
                            <div class="statistics">
                                <span class="font-medium-2 mr-50 text-bold-600"
                                      id="total_birthdate_gain"><?php echo number_format($combined_info['birthdate']['total_birthdate_gain']); ?></span>
                                (<i class="bx
bx-male"></i><span id="birthdate_male_number"><?php echo number_format($combined_info['birthdate']['male']); ?></span>,
                                <i class="bx
bx-female"></i><span id="birthdate_male_number"><?php echo number_format($combined_info['birthdate']['female']); ?></span>)
                            </div>
                            <div class="statistics-date">
                                <small class="text-muted"><?php echo $this->lang->line('birthdate number gain'); ?></small>
                            </div>
                        </div>
                        <!-- chart-statistics-1 -->
                        <div class="mx-auto donut-style">
                            <div id="donut-birthdate" class="mx-1"></div>
                        </div>

                    </div>


                    <!--
              <li class="media">
                <img class="mr-3 rounded" width="55" src="<?php echo base_url('assets/img/icon/locale.jpg'); ?>" alt="product">
                <div class="media-body">
                  <div class="media-title"><?php echo $this->lang->line('Location gain'); ?></div>
                  <div class="mt-1">
                    <div class="budget-price">
                      <div class="budget-price-square bg-danger" id="location_male_percentage" data-width="30%"></div>
                      <div class="budget-price-label" id="location_male_number">$9,660</div>
                    </div>
                    <div class="budget-price">
                      <div class="budget-price-square bg-primary" id="location_female_percentage" data-width="45%"></div>
                      <div class="budget-price-label" id="location_female_number">$13,972</div>
                    </div>
                  </div>
                </div>
              </li>
              -->

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6 col-xl-6">
            <section id="component-swiper-multiple" class="n_subs">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center pb-50">
                        <h4 class="card-title"><?php echo $this->lang->line('Latest Subscribers'); ?></h4>
                    </div>
                    <div class="card-body p-0 pb-1">
                        <ul class="list-group list-group-flush">
                            <?php
                            $id_page_inbox = array();
                            foreach ($latest_subscriber_list as $value) :

                                if (empty($id_page_inbox[$value['page_id']])) {
                                    $inbox_dt = $this->basic->get_data("facebook_rx_fb_page_info", array("where" => array("facebook_rx_fb_user_info_id" => $this->session->userdata("facebook_rx_fb_user_info"), 'page_id' => $value['page_id'])), array('page_name', 'id'));
                                    if (!empty($inbox_dt[0])) {
                                        $id_page_inbox[$value['page_id']] = $inbox_dt[0]['id'];
                                    } else {
                                        $id_page_inbox[$value['page_id']] = 0;
                                    }

                                }

                                ?>

                                <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                    <div class="list-left d-flex">
                                        <div class="list-icon mr-1">
                                            <div class="avatar bg-rgba-primary m-0">
                                                <div class="avatar-content">
                                                    <img class="img-fluid img_fb_onerror"
                                                         onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                                                         src="<?php echo $value['image_path']; ?>"
                                                         alt="img placeholder" height="134" width="134">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-content">
                                            <span class="list-title"><?php if ($value['full_name'] != '') echo $value['full_name']; else echo $value['first_name'] . ' ' . $value['last_name']; ?></span>
                                            <small class="text-muted d-block"><a style="cursor: pointer;"
                                                                                 href="https://facebook.com/<?php echo $value['page_id']; ?>"
                                                                                 target="_BLANK"><?php echo $value['page_name']; ?></a></small>
                                        </div>
                                    </div>
                                    <span class="text-right"><?php echo $value['subscribed_at']; ?><br/>

                                    <?php if ($other_dashboard == 0) { ?>
                                        <small><a
                                                    type="button"
                                                    data-toggle="tooltip"
                                                    href="<?php echo base_url() . 'message_manager/message_dashboard/' . $id_page_inbox[$value['page_id']]; ?>"
                                                    target="_BLANK"
                                                    class="glow font-small-2"
                                                    <?php if ($value['link'] == 'disabled') {
                                                        echo 'data-original-title="' . $this->lang->line('Please go to subscriber manager menu and then sync leads to get this link.') . '"';
                                                        echo 'data-placement="bottom"';
                                                    } ?>
                                                    ><?php echo $this->lang->line('Go to Inbox'); ?></a></small>
                                    <?php } ?>
                                </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $this->lang->line('Last Auto Reply'); ?></h4>
                    <!-- <div class="card-header-action">
              <a href="<?php echo base_url('comment_automation/all_auto_reply_report'); ?>" target="_BLANK" class="btn btn-danger"><?php echo $this->lang->line('View More'); ?> </a>
            </div> -->
                </div>
                <div class="table-responsive">
                    <table id="last_auto_reply_table" class="table table-borderless">
                        <thead>
                        <tr>
                            <!-- <th><?php echo $this->lang->line("sl"); ?></th> -->
                            <th><?php echo $this->lang->line("reply to"); ?></th>
                            <th><?php echo $this->lang->line("reply time"); ?></th>
                            <th><?php echo $this->lang->line("Comment ID"); ?></th>
                            <th><?php echo $this->lang->line("Comment"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $sl = 0;
                        foreach ($my_last_auto_reply_data as $key => $value) : $sl++; ?>
                            <tr>
                                <!-- <td><?php echo $sl; ?></td> -->
                                <td class="font-weight-600"><?php echo $value["commenter_name"]; ?></td>
                                <td><?php echo date("jS M y H:i", strtotime($value["reply_time"])); ?></td>
                                <td><a target='_blank'
                                       href='https://facebook.com/<?php echo $value['comment_id']; ?>'><?php echo $value["comment_id"]; ?></a>
                                </td>
                                <td>
                                    <?php echo $value["comment_text"]; ?>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        if ($sl == 0) echo "<tr><td class='text-center' colspan='4'>No data found.</td></tr>";
                        ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <?php
                    $where = array(
                        'where' => array(
                            'posting_status' => '2'
                        )
                    );
                    if ($has_system_dashboard != 'yes') {
                        $where['where']['user_id'] = $id_for_user;
                    }
                    $recently_message_sent_completed_campaing_info = $this->basic->get_data('messenger_bot_broadcast_serial', $where, $select = '', $join = '', $limit = '5', $start = NULL, 'created_at DESC');
                    ?>

                    <h5><?php if (count($recently_message_sent_completed_campaing_info) >= 5) echo 5; else echo count($recently_message_sent_completed_campaing_info); ?><?php echo $this->lang->line("Completed Messenger Broadcast") ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        <div class="yscroll">
                            <ul class="list-group list-group-flush">
                                <?php $sl = 0;
                                foreach ($recently_message_sent_completed_campaing_info as $value) : if ($sl == 5) break; ?>
                                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                        <div class="list-left d-flex">
                                            <div class="list-content">
                                                <span class="list-title"><?php echo $value['campaign_name']; ?></span>
                                                <small class="text-muted d-block"><?php echo $this->lang->line('Sent') . ":"; ?><?php echo $value["successfully_sent"]; ?></small>
                                            </div>
                                        </div>
                                        <span class="text-right"><?php echo date("d M y H:i", strtotime($value["created_at"])); ?></span>
                                    </li>
                                    <?php $sl++; endforeach ?>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo base_url('messenger_bot_enhancers/subscriber_broadcast_campaign'); ?>"
                               target="_BLANK" class="btn btn-sm btn-light-primary">
                                <?php echo $this->lang->line('View All'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php if (count($upcoming_post_campaign_array) >= 5) echo 5; else echo count($upcoming_post_campaign_array); ?><?php echo $this->lang->line("Upcoming Facebook Poster Campaign") ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        <div class="yscroll">
                            <?php
                            $post_names = array(
                                'image_submit' => $this->lang->line('Image Post'),
                                'video_submit' => $this->lang->line('Video Post'),
                                'link_submit' => $this->lang->line('Link Post'),
                                'text_submit' => $this->lang->line('Text Post'),
                                'carousel_post' => $this->lang->line('Carousel Post'),
                                'slider_post' => $this->lang->line('Slider Post'),
                                'cta_post' => $this->lang->line('CTA Post'),
                            );
                            ?>
                            <ul class="list-group list-group-flush">
                                <?php $sl = 0;
                                foreach ($upcoming_post_campaign_array as $value) : if ($sl == 5) break; ?>
                                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                        <div class="list-left d-flex">
                                            <div class="list-content">
                                                <span class="list-title"><?php echo $value['campaign_name']; ?></span>
                                                <small class="text-muted d-block">                                                <?php
                                                    $post_type = '';
                                                    if (isset($value['post_type'])) $post_type = $post_names[$value['post_type']];
                                                    if (isset($value['cta_type'])) $post_type = $post_names['cta_post'];
                                                    echo $post_type;
                                                    ?>
                                                </small>
                                            </div>
                                        </div>
                                        <span class="text-right"><?php echo date("d M y H:i", strtotime($value["schedule_time"])); ?></span>
                                    </li>
                                    <?php $sl++; endforeach ?>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo base_url('ultrapost/index'); ?>" target="_BLANK"
                               class="btn btn-sm btn-light-primary">
                                <?php echo $this->lang->line('View All'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-hero">
                <div class="card-header">
                    <h5><?php if (count($recently_completed_post_array) >= 5) echo 5; else echo count($recently_completed_post_array); ?><?php echo $this->lang->line("Completed Facebook Poster Campaign") ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="tickets-list">
                        <div class="yscroll">
                            <ul class="list-group list-group-flush">
                                <?php $sl = 0;
                                foreach ($recently_completed_post_array as $value) : if ($sl == 5) break; ?>
                                    <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                        <div class="list-left d-flex">
                                            <div class="list-content">
                                                <span class="list-title"><?php echo $value['campaign_name']; ?></span>
                                                <small class="text-muted d-block">                                                                                                  <?php
                                                    $post_type = '';
                                                    if (isset($value['post_type'])) $post_type = $post_names[$value['post_type']];
                                                    if (isset($value['cta_type'])) $post_type = $post_names['cta_post'];
                                                    echo $post_type;
                                                    ?>
                                                </small>
                                            </div>
                                        </div>
                                        <span class="text-right"><?php echo date("d M y H:i", strtotime($value["last_updated_at"])); ?></span>
                                    </li>
                                    <?php $sl++; endforeach ?>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo base_url('ultrapost/index'); ?>" target="_BLANK"
                               class="btn btn-sm btn-light-primary">
                                <?php echo $this->lang->line('View All'); ?>
                            </a>
                        </div>
                    </div>
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







