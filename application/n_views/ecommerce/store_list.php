<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 1;
$include_morris = 0;
$include_chartjs = 1;
$include_owlcar = 1;
?>
<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/charts/apexcharts.css?ver=<?php echo $n_config['theme_version']; ?>">
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/charts/apexcharts.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php $this->load->view('admin/theme/message'); ?>
<style>
    #search_page_id {
        min-width: 150px !important;
    }

    .list-unstyled-border li {
        border-bottom: none;
        margin-bottom: 10px;
        padding-top: 0;
    }

    .tickets-list .ticket-item {
        border-bottom: none;
        padding: 0;
        margin-bottom: 14px;
    }

    .tickets-list .ticket-item h4 {
        margin-bottom: 9px;
    }

    .media {
        margin-bottom: 12px;
    }

    .media .media-title {
        margin-bottom: 0;
        font-size: 14px;
    }

    .ticket-title h4 {
        color: #000 !important;
        margin-bottom: 3px !important;
        font-weight: 500 !important;
    }

    .website {
        font-size: 20px;
    }

    .website i {
        font-size: 20px !important;
    }

    .website h4 {
        font-size: 20px !important;
    }

    div.tooltip {
        top: 0px !important;
    }
</style>

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

    /*.multi_layout p, .multi_layout ul:not(.list-unstyled), .multi_layout ol{line-height: 15px;margin-top: 15px}*/
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
        box-shadow: none;
    }

    /*.multi_layout .collef .makeScroll{max-height: 500px;overflow:auto;}*/
    /*.multi_layout .colrig .makeScroll{max-height:750px;overflow:auto;}*/
    .multi_layout .list-group {
        padding-top: 6px;
    }

    .multi_layout .list-group .list-group-item {
        border-radius: 0;
        border: .5px solid #dee2e6;
        border-left: none;
        border-right: none;
        cursor: pointer;
        z-index: 0;
        padding: 21px;
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
        margin: 10px 0;
    }

    .multi_layout .card .card-header input {
        max-width: 100% !important;
    }

    .multi_layout .card .card-header h4 a {
        font-weight: 700 !important;
    }

    .product-item .product-name {
        font-weight: 500;
    }

    .badge-status {
        border-color: #eee;
    }

    /* #right_column_title i{font-size: 17px;} */
    #cart_activities {
        height: 710px;
        overflow: auto;
    }

    #right_column_bottom_content .shadow-none .card-header, #right_column_bottom_content .shadow-none .card-body {
        padding: 20px 0;
    }

    /*.multi_layout .card-statistic-1 .card-icon{border: .5px solid #dee2e6;}*/
    .multi_layout .card.card-statistic-1 .card-icon, .card.card-statistic-2 .card-icon {
        margin: 0;
        border-radius: 4px 0 0 4px;
        background: transparent;
    }

    .multi_layout .card-statistic-1 {
        border: .5px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 5px;
    }

    .multi_layout .card.card-statistic-1 .card-header, .multi_layout .card.card-statistic-2 .card-header {
        padding: 0;
        padding-top: 20px;
    }

    .multi_layout .card.card-statistic-1 .card-body, .multi_layout .card.card-statistic-2 .card-body {
        padding: 0;
    }

    #store_list_field .select2{max-width:75%;}

    /*#right_column_bottom_content div[class^='col'], #right_column_bottom_content  div[class*=' col']{padding-left: 5px;padding-right: 5px;}*/

</style>

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

<div class="row">
    <div class="col-sm-12 col-md-6">
        <?php if (!empty($store_data)) { ?>
            <fieldset class="form-group" id="store_list_field">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"
                               for="store_list_select"><?php echo $this->lang->line("STORE"); ?></label>
                    </div>
                    <select class="form-control select2 select2-icons" id="store_list_select">

                        <?php $i = 0;
                        $current_store_data = array();
                        foreach ($store_data as $value) {
                            if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;
                            if ($value['store_type'] == 'digital') {
                                $data_icon_e = 'bx bx-cloud-download';
                            } else {
                                $data_icon_e = 'bx bx-store';
                            }
                            ?>
                            <option data-icon="<?php echo $data_icon_e; ?>"
                                    value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) echo 'selected'; ?>><?php echo str_replace(array('https://', 'http://'), '', $value['store_name']); ?></option>

                            <?php $i++;
                        } ?>
                    </select>
                </div>
            </fieldset>
        <?php } ?>

    </div>

    <div class="pl-md-2 col-sm-12 col-md-6 d-flex">

        <a href="<?php echo base_url("ecommerce/add_store"); ?>" class="btn btn-primary mb-1 iframed"
           title="<?php echo $this->lang->line('Create Store'); ?>" data-toggle="tooltip">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Store"); ?>
        </a>

        <button id="notification_sound" data-active="false" class="btn btn-primary mb-1 ml-1"
                title="<?php echo $this->lang->line('Notification new order sound'); ?>" data-toggle="tooltip">
            <i class='bx bxs-bell-off'></i>
        </button>

        <button id="notification_sound_loop" data-active="false" class="btn btn-primary mb-1 ml-1"
                title="<?php echo $this->lang->line('Sound loop'); ?>" data-toggle="tooltip">
            <i class='bx bx-repeat'></i>
        </button>

    </div>



</div>

<div class="section-body">

    <?php if (!empty($store_data)) { ?>
        <div class="card hide_row_iframed">
            <div class="card-body">
                <div class="row">


                    <div class="col-12 col-sm-12 col-md-12 col-lg-10">
                        <div class="breadcrumb-item">
                            <form method="POST" action="<?php echo base_url('ecommerce/store_list') ?>">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="bx bx-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="store_id" id="store_id">
                                    <input type="text" class="form-control datepicker_x"
                                           value="<?php echo $this->session->userdata("ecommerce_from_date"); ?>"
                                           id="from_date" name="from_date" style="width:115px">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            -
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker_x"
                                           value="<?php echo $this->session->userdata("ecommerce_to_date"); ?>"
                                           id="to_date" name="to_date" style="width:115px">
                                    <select name='currency' id='currency' class='select2 form-control'
                                            style="width: 85px;">
                                        <?php
                                        foreach ($currecny_list_all as $key => $value) {
                                            if ($this->session->userdata("ecommerce_currency") == $key) $selected_curr = "selected='selected'";
                                            else $selected_curr = '';
                                            echo '<option value="' . $key . '" ' . $selected_curr . ' >' . $key . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <button class="btn btn-outline-primary" style="margin-left:1px" id="search_submit"
                                            type="submit"><i
                                                class="bx bx-search"></i> <?php echo $this->lang->line("Search"); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    <?php } ?>


    <?php if (empty($store_data)) { ?>
        <div class="card text-center" id="nodata">
            <div class="card-body">
                <div class="mt-3">
                    <iframe src="" frameborder="0" style="display: none;" width="100%"></iframe>
                </div>
                <div class="empty-state hide_in_iframe">
                    <img class="img-fluid" style="height: 200px"
                         src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                    <h2 class="mt-0"><?php echo $this->lang->line("We could not find any ecommerce store."); ?></h2>
                    <p class="lead"><?php echo $this->lang->line("You have to create a store first."); ?></p>
                    <a href="<?php echo base_url('ecommerce/add_store'); ?>"
                       title="<?php echo $this->lang->line('Create Store'); ?>" data-toggle="tooltip"
                       class="btn btn-primary iframed" class="btn btn-outline-primary mt-4"><i
                                class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line("Create Store"); ?>
                    </a>
                </div>
            </div>
        </div>

        <?php
    } else {
        $summary_earning = 0;
        $summary_recovered_cart = 0;
        $summary_reminder_cart = 0;
        $summary_checkout_cart = 0;
        $earning_chart_labels = array();
        $earning_chart_values = array();
        // $top_buyers = array();

        $from_date = strtotime($this->session->userdata("ecommerce_from_date"));
        $to_date = strtotime($this->session->userdata("ecommerce_to_date"));
        do {
            $temp = date("Y-m-d", $from_date);
            $temp2 = date("j M", $from_date);
            $earning_chart_values[$temp] = 0;
            $earning_chart_labels[] = $temp2;
            $from_date = strtotime('+1 day', $from_date);
        } while ($from_date <= $to_date);

//        foreach ($cart_data as $key => $value) {
//            if ($value['action_type'] == 'checkout') $summary_checkout_cart++;
//
//            if ($value["last_completed_hour"] > 0) {
//                $summary_reminder_cart++;
//                if ($value['action_type'] == 'checkout') $summary_recovered_cart++;
//            }
//
//            if ($value["status"] != 'pending' && $value["status"] != 'rejected') {
//                $summary_earning += $value["payment_amount"];
//                $updated_at_formatted = date("Y-m-d", strtotime($value['updated_at']));
//                if (isset($earning_chart_values[$updated_at_formatted])) $earning_chart_values[$updated_at_formatted] += $value["payment_amount"];
//                else $earning_chart_values[$updated_at_formatted] = $value["payment_amount"];
//
//                // if($value['buyer_country']!='')
//                // {
//                //   if(isset($top_buyers[$value['buyer_country']])) $top_buyers[$value['buyer_country']] += $value["payment_amount"];
//                //   else $top_buyers[$value['buyer_country']] = $value["payment_amount"];
//                // }
//            }
//        }
        // arsort($top_buyers);
        ?>
        <div class="row multi_layout">


            <?php
            $config_currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
            if ($this->session->userdata("ecommerce_currency") == '')
                $store_currency = isset($currency_icons[$config_currency]) ? $currency_icons[$config_currency] : "$";
            else $store_currency = isset($currency_icons[$this->session->userdata("ecommerce_currency")]) ? $currency_icons[$this->session->userdata("ecommerce_currency")] : "$";
            $currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
            $decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
            $thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
            $currency_left = $currency_right = "";
            if ($currency_position == 'left') $currency_left = $store_currency;
            if ($currency_position == 'right') $currency_right = $store_currency;

            $menu_array = array
            (
                0 => array
                (
                    'class' => '',
                    'href' => base_url('ecommerce'),
                    'title' => $this->lang->line('Dashboard'),
                    'icon' => 'bx bx-bar-chart-alt',
                    'attr' => ''
                ),
                1 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/order_list'),
                    'title' => $this->lang->line('Orders'),
                    'icon' => 'bx bx-cart',
                    'attr' => ''
                ),
                5 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "ecommerce/edit_store/" . $current_store_data['id'],
                    'title' => $this->lang->line('Store Settings'),
                    'icon' => 'bx bxs-cog',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                ),
                8 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "ecommerce/payment_accounts/" . $current_store_data['id'],
                    'title' => $this->lang->line('Checkout Settings'),
                    'icon' => 'bx bx-credit-card-alt',
                    'attr' => ''
                ),
//          9 => array
//          (
//            'class'=>'iframed',
//            'href'=>base_url()."ecommerce/appearance_settings/".$current_store_data['id'],
//            'title'=>$this->lang->line('Appearance Settings'),
//            'icon'=>'bx bx-palette',
//            'attr'=>''
//          ),
                10 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "ecommerce/business_hour_settings",
                    'title' => $this->lang->line('Business Hour Settings'),
                    'icon' => 'bx bx-calendar-check',
                    'attr' => ''
                ),
                11 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "n_theme/ecommerce_codes/",
                    'title' => $this->lang->line('Marketing'),
                    'icon' => 'bx bx-target-lock',
                    'attr' => ''
                ),
//            12 => array
//            (
//                'class'=>'iframed',
//                'href'=>base_url()."n_theme/ecommerce_settings/",
//                'title'=>$this->lang->line('ecommerce').' '.$this->lang->line('settings'),
//                'icon'=>'bx bx-wrench',
//                'attr'=>''
//            ),

                12 => array
                (
                    'class' => '',
                    'href' => base_url() . "ecommerce_builder/" . $current_store_data['store_unique_id'],
                    'title' => $this->lang->line('ecommerce builder'),
                    'icon' => 'bx bx-link-external',
                    'attr' => 'target="_BLANK"'
                ),

                14 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/category_list'),
                    'title' => $this->lang->line('Categories'),
                    'icon' => 'bx bx-columns',
                    'attr' => ''
                ),
                17 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/attribute_list'),
                    'title' => $this->lang->line('Attributes'),
                    'icon' => 'bx bx-palette',
                    'attr' => ''
                ),
                20 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/product_list'),
                    'title' => $this->lang->line('Products'),
                    'icon' => 'bx bx-box',
                    'attr' => ''
                ),
                21 => array
                (
                    'class' => '',
                    'href' => base_url('ecommerce/store/' . $current_store_data['store_unique_id']),
                    'title' => $this->lang->line('Visit Store'),
                    'icon' => 'bx bx-news',
                    'attr' => 'target="_BLANK"'
                ),
                23 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/pickup_point_list'),
                    'title' => $this->lang->line('Delivery Points'),
                    'icon' => 'bx bx-map',
                    'attr' => ''
                ),
                24 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "ecommerce/qr_code/" . $current_store_data['id'],
                    'title' => $this->lang->line('QR Menu'),
                    'icon' => 'bx bx-barcode',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                ),
                26 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/coupon_list'),
                    'title' => $this->lang->line('Coupons'),
                    'icon' => 'bx bx-gift',
                    'attr' => ''
                ),
                28 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/customer_list'),
                    'title' => $this->lang->line('Signed-up Customers'),
                    'icon' => 'bx bx-group',
                    'attr' => ''
                ),
                36 => array
                (
                    'class' => 'iframed',
                    'href' => base_url('ecommerce/copy_url/' . $this->session->userdata("ecommerce_selected_store")),
                    'title' => $this->lang->line('Copy URL'),
                    'icon' => 'bx bx-copy',
                    'attr' => ''
                ),

                39 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "ecommerce/notification_settings/" . $current_store_data['id'],
                    'title' => $this->lang->line('Order Status Notification'),
                    'icon' => 'bx bx-bell',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                ),
                42 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "ecommerce/reminder_settings/" . $current_store_data['id'],
                    'title' => $this->lang->line('Confirmation & Reminder'),
                    'icon' => 'bx bxs-volume',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                ),
                45 => array
                (
                    'class' => 'reminder_report',
                    'href' => '',
                    'title' => $this->lang->line('Reminder Report'),
                    'icon' => 'bx bx-bullseye',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                ),
                46 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "custom_cname/delivery_methods_list/" . $current_store_data['id'],
                    'title' => $this->lang->line('Delivery Methods'),
                    'icon' => 'bx bxs-package',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                ),
                47 => array
                (
                    'class' => 'iframed',
                    'href' => base_url() . "custom_cname/shipping_zone_list/" . $current_store_data['id'],
                    'title' => $this->lang->line('Shipping zones'),
                    'icon' => 'bx bxs-package',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                ),
                48 => array
                (
                    'class' => 'delete_campaign',
                    'href' => '#',
                    'title' => $this->lang->line('Delete Store'),
                    'icon' => 'bx bx-trash-alt',
                    'attr' => 'campaign_id=' . $current_store_data['id']
                )
            );

            if ($n_config['eco_custom_domain'] == 'true') {
                $menu_array[13] = array(
                    'class' => 'iframed',
                    'href' => base_url() . "n_theme/custom_domain/",
                    'title' => $this->lang->line('ecommerce custom domain'),
                    'icon' => 'bx bx-link-external',
                    'attr' => ''
                );
            }
            ksort($menu_array);
            ?>

            <div class="col-md-3 col-lg-2 collef d-none d-lg-block" style="border:.5px solid #dee2e6;">
                <div class="card main_card">
                    <div class="card-header">
                        <h4><i class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Actions"); ?></h4>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column settings_menu" style="margin-top: 20px;">
                            <?php
                            $count_menu = 0;
                            foreach ($menu_array as $key => $value) {
                                $count_menu++;
                                $active_class = ($count_menu == 1) ? 'active' : '';
                                if ($current_store_data['store_type'] == 'digital' && $value['href'] == base_url('ecommerce/business_hour_settings')) continue;

                                if ($current_store_data['store_type'] == 'digital' && $value['href'] == base_url('ecommerce/pickup_point_list')) continue;
                                echo ' <li class="nav-item p-0 m-0"><a  data-original-title="' . $value['title'] . '" href="' . $value['href'] . '" class="no_radius nav-link ' . $value['class'] . ' ' . $active_class . '" ' . $value['attr'] . '><i class="' . $value['icon'] . ' align-middle"></i> <span class="align-middle">' . $value['title'] . '</span></a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <?php

            function _link($uri, $domain = '')
            {
                $custom = false;
                if ($domain != '') {
                    $domain = $domain . '/';
                    $custom = true;
                }

                if ($custom == true) {
                    if (strpos($uri, 'store') == false) {
                        return 'https://' . $domain . str_replace('ecommerce/', '', $uri);
                    } else {
                        return 'https://' . $domain;
                    }


                } else {
                    return base_url($uri);
                }
            }

            $n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
                "custom_id" => $current_store_data['id'],
                "user_id" => $this->user_id,
                'active' => 1
            )
            ));

            if (empty($n_cd_data)) {
                $custom_domain_set = '';
            } else {
                if ($n_cd_data[0]['active'] == 1) {
                    $custom_domain_set = $n_cd_data[0]['host_url'];
                } else {
                    $custom_domain_set = '';
                }

            }

            ?>

            <div class="col-12 col-md-12 col-lg-10 colrig" id="right_column">

                <div class="card main_card">
                    <div class="card-header">



                        <div class="col-sm-12 col-md-8 p-0 mb-1">
                            <h4 id="right_column_title" class="card-title font-medium-2"><i
                                        class="bx bx-bar-chart-alt"></i>

                                <a title="<?php echo $this->lang->line("Visit Store"); ?>" data-toggle="tooltip"
                                   target="_BLANK"
                                   href="<?php echo _link("ecommerce/store/" . $current_store_data['store_unique_id'], $custom_domain_set); ?>"><?php echo str_replace(array('https://', 'http://'), '', $current_store_data['store_name']); ?></a>
                                (<?php if ($current_store_data['page_id'] != 0) :
                                    echo '<a title="' . $this->lang->line("Visit Page") . '" data-toggle="tooltip" target="_BLANK" href="https://facebook.com/' . $current_store_data['fb_page_id'] . '">' . $current_store_data['page_name'] . '</a>';
                                else :
                                    echo $this->lang->line('No Page');
                                    ?>
                                <?php endif; ?>
                                ) <span id='iframe_title'> : <?php echo $this->lang->line("Dashboard"); ?></span></h4>
                        </div>
                        <div class="col-sm-12 col-md-4 p-0 mb-1 d-lg-none">
                            <div class="card-header-action dropleft float-right">
                                <a href="#" data-toggle="dropdown"
                                   class="btn btn-outline-primary dropdown-toggle"><?php echo $this->lang->line("Actions"); ?></a>
                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <?php
                                    foreach ($menu_array as $key => $value) {

                                        if ($current_store_data['store_type'] == 'digital' && $value['href'] == base_url('ecommerce/business_hour_settings')) continue;

                                        if ($current_store_data['store_type'] == 'digital' && $value['href'] == base_url('ecommerce/pickup_point_list')) continue;

                                        echo '<li><a data-original-title="' . $value['title'] . '" class="dropdown-item ' . $value['class'] . '" href=' . $value['href'] . ' ' . $value['attr'] . '><i class="' . $value['icon'] . '" ></i> &nbsp; ' . $value['title'] . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <iframe src="" frameborder="0" style="display: none;" width="100%"></iframe>
                        <div class="row hide_in_iframe mt-1">
                            <div class="col-12">

                                <div id="right_column_content">

                                    <div id="right_column_bottom_content">


                                        <div class="row">

                                            <div class="col-sm-3 col-12 dashboard-users-success">
                                                <div class="card card-statistic-1 p-1">


                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">
                                                            <i class="bx bx-dollar font-medium-5 align-middle"></i>
                                                            <span class="align-middle text-uppercase text-bold-600"><?php echo $this->lang->line('Today'); ?></span>
                                                        </h5>
                                                        <div class="statistics-data my-auto">
                                                            <div class="statistics">
                                                                <span class="font-medium-2 mr-50 text-bold-600"><?php echo $currency_left . round($n_stats_today['value'], $decimal_point)  . $currency_right; ?></span>
                                                                <span class="<?php if($n_stats_today['val_perc']>0){$txt_s = 'text-success';}else{$txt_s = 'text-danger';} echo $txt_s; ?>">(<?php echo $n_stats_today['val_perc']; ?>%)</span>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-uppercase text-muted"><?php echo $this->lang->line('NET SALES'); ?>: <?php echo $currency_left . round($n_stats_today['net_sales'], $decimal_point) . $currency_right; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-muted text-uppercase"><?php echo $this->lang->line('ORDERS'); ?>: <?php echo $n_stats_today['orders']; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-uppercase text-muted"><?php echo $this->lang->line('RECOVERED CARTS'); ?>: <?php echo $n_stats_today['rec_cart']; ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-12 dashboard-users-success">
                                                <div class="card card-statistic-1 p-1">


                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">
                                                            <i class="bx bx-dollar font-medium-5 align-middle"></i>
                                                            <span class="align-middle text-uppercase text-bold-600"><?php echo $this->lang->line('Month'); ?></span>
                                                        </h5>
                                                        <div class="statistics-data my-auto">
                                                            <div class="statistics">
                                                                <span class="font-medium-2 mr-50 text-bold-600 "><?php echo $currency_left . round($n_stats_month['value'], $decimal_point) . $currency_right; ?></span>
                                                                <span class="<?php if($n_stats_month['val_perc']>0){$txt_s = 'text-success';}else{$txt_s = 'text-danger';} echo $txt_s; ?>">(<?php echo $n_stats_month['val_perc']; ?>%)</span>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-muted"><?php echo $this->lang->line('NET SALES'); ?>: <?php echo $currency_left . round($n_stats_month['net_sales'], $decimal_point)  . $currency_right; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-muted text-uppercase"><?php echo $this->lang->line('ORDERS'); ?>: <?php echo $n_stats_month['orders']; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-muted text-uppercase"><?php echo $this->lang->line('RECOVERED CARTS
'); ?>: <?php echo $n_stats_month['rec_cart']; ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-12 dashboard-users-success">
                                                <div class="card card-statistic-1 p-1">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center ">
                                                            <i class="bx bx-dollar font-medium-5 align-middle"></i>
                                                            <span class="align-middle text-uppercase text-bold-600"><?php echo $this->lang->line('Year'); ?></span>
                                                        </h5>
                                                        <div class="statistics-data my-auto">
                                                            <div class="statistics">
                                                                <span class="font-medium-2 mr-50 text-bold-600"><?php echo $currency_left . round($n_stats_year['value'], $decimal_point) . $currency_right; ?></span>
                                                                <span class="<?php if($n_stats_year['val_perc']>0){$txt_s = 'text-success';}else{$txt_s = 'text-danger';} echo $txt_s; ?>">(<?php echo $n_stats_year['val_perc']; ?>%)</span>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-uppercase text-muted"><?php echo $this->lang->line('NET SALES'); ?>: <?php echo $currency_left . round($n_stats_year['net_sales'], $decimal_point)  . $currency_right; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-muted text-uppercase"><?php echo $this->lang->line('ORDERS'); ?>: <?php echo $n_stats_year['orders']; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-uppercase text-muted"><?php echo $this->lang->line('RECOVERED CARTS'); ?>: <?php echo  $n_stats_year['rec_cart']; ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-12 dashboard-users-success">
                                                <div class="card card-statistic-1 p-1">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center ">
                                                            <i class="bx bx-dollar font-medium-5 align-middle"></i>
                                                            <span class="align-middle text-uppercase text-bold-600"><?php echo $this->lang->line('Selected Period'); ?></span>
                                                        </h5>
                                                        <div class="statistics-data my-auto">
                                                            <div class="statistics">
                                                                <span class="font-medium-2 mr-50 text-bold-600"><?php echo $currency_left . round($n_stats_period['value'], $decimal_point) . $currency_right; ?></span>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-uppercase text-muted"><?php echo $this->lang->line('NET SALES'); ?>: <?php echo $currency_left . round($n_stats_period['net_sales'], $decimal_point) . $currency_right; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-muted text-uppercase"><?php echo $this->lang->line('ORDERS'); ?>: <?php echo $n_stats_period['orders']; ?></small>
                                                            </div>
                                                            <div class="statistics-date">
                                                                <i class="bx bx-radio-circle font-small-1 text-success mr-25"></i>
                                                                <small class="text-uppercase text-muted"><?php echo $this->lang->line('RECOVERED CARTS'); ?>: <?php echo  $n_stats_period['rec_cart']; ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div id="chart_new" class="mt-4 col-12"></div>
                                        </div>



                                        <div class="row">

                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card shadow-none">
                                                    <div class="card-header">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Top Selling Products"); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0">
                                                                <thead>
                                                                <tr>
                                                                    <th><?php echo $this->lang->line("Product"); ?></th>
                                                                    <th><?php echo $this->lang->line("Order"); ?></th>
                                                                    <th><?php echo $this->lang->line("Total Value"); ?></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $product_list_assoc = array();
                                                                $n_product_ids = array();
                                                                foreach ($product_list as $key => $value) {
                                                                    $product_list_assoc[$value["id"]] = $value;
                                                                }
                                                                foreach ($top_products as $key => $value) {
                                                                    $n_product_ids[] = $value["product_id"];
                                                                    $pro_id = $value["product_id"];

                                                                    $thumb = (isset($product_list_assoc[$pro_id]["thumbnail"]) && !empty($product_list_assoc[$pro_id]["thumbnail"])) ? base_url('upload/ecommerce/' . $product_list_assoc[$pro_id]["thumbnail"]) : base_url('assets/img/example-image.jpg');

                                                                    if (isset($product_list_assoc[$pro_id]["woocommerce_product_id"]) && !is_null                                                                                                            ($product_list_assoc[$pro_id]["woocommerce_product_id"]) && isset($product_list_assoc[$pro_id]["thumbnail"]) && !empty($product_list_assoc[$pro_id]["thumbnail"]))
                                                                        $thumb = $product_list_assoc[$pro_id]["thumbnail"];

                                                                    $pro_name = isset($product_list_assoc[$pro_id]["product_name"]) ? $product_list_assoc[$pro_id]["product_name"] : "";
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-bold-500"><a target="_BLANK"
                                                                                                     href="<?php echo base_url('ecommerce/product/' . $pro_id); ?>"><?php echo $pro_name; ?></a></td>
                                                                        <td><?php echo $value["sales_count"]; ?></td>
                                                                        <td><?php echo $value["sales_total_amount"]; ?></td>
                                                                    </tr>
                                                                    <?php
                                                                } ?>
                                                                </tbody>
                                                            </table>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>


                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card shadow-none">
                                                    <div class="card-header">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Orders"); ?></h4>
                                                    </div>
                                                    <div id="order_type" class="card-body">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card shadow-none">
                                                    <div class="card-header">
                                                        <h4 class="card-title"><?php echo $this->lang->line("Orders Source"); ?></h4>
                                                    </div>
                                                    <div id="subs_type" class="card-body">
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

        <?php
    } ?>

</div>


<?php include(APPPATH . 'n_views/ecommerce/cart_modal.php'); ?>

<div class="modal fade" id="reminder_data" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-bell"></i> <?php echo $this->lang->line("Reminder Report"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body data-card">
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
                            <th><?php echo $this->lang->line("Last Name") ?></th>
                            <th><?php echo $this->lang->line("Email"); ?></th>
                            <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                            <th><?php echo $this->lang->line("Reminder Hour"); ?></th>
                            <th><?php echo $this->lang->line("Sent at"); ?></th>
                            <th><?php echo $this->lang->line("API Response"); ?></th>
                            <th><?php echo $this->lang->line("Order"); ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>