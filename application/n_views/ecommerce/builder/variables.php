<?php
$l = $this->lang;
$check_cn_nn = 0;
if (file_exists(APPPATH . 'custom_domain.php')) {
    include(APPPATH . 'custom_domain.php');
    if ($ncd_config['eco_custom_domain'] == 'true') {
        if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
            $check_cn_nn = 1;
        }
    }
}


if ($n_eco_builder_config['store_logo_show'] != 'none') {
    $n_logo_on_check = 0;
    if ($n_eco_builder_config['store_logo_show'] == 'favicon') {
        $n_store_logo_light = base_url($n_eco_builder_config['store_' . $n_eco_builder_config['header_color_logo'] . '_icon']);
        $n_store_logo_dark = base_url($n_eco_builder_config['store_' . $n_eco_builder_config['header_color_logo'] . '_icon']);
        $n_logo_on_check = 1;
    }
    if ($n_eco_builder_config['store_logo_show'] == 'logo') {
        $n_store_logo_light = base_url($n_eco_builder_config['store_logo_' . $n_eco_builder_config['header_color_logo']]);
        $n_store_logo_dark = base_url($n_eco_builder_config['store_logo_' . $n_eco_builder_config['header_color_logo']]);
        $n_logo_on_check = 1;
    }
    if ($n_logo_on_check == 0) {
        $n_store_logo_light = base_url($n_eco_builder_config['store_logo_' . $n_eco_builder_config['header_color_logo']]);
        $n_store_logo_dark = base_url($n_eco_builder_config['store_logo_' . $n_eco_builder_config['header_color_logo']]);
    }
}

$current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language");
$current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language");



$js_user_id = isset($social_analytics_codes['user_id']) ? $social_analytics_codes['user_id'] : $social_analytics_codes['user_id'];

$hide_add_to_cart = isset($n_eco_builder_config['hide_add_to_cart']) ? $n_eco_builder_config['hide_add_to_cart'] : '0';
$hide_buy_now = isset($n_eco_builder_config['hide_buy_now']) ? $n_eco_builder_config['hide_buy_now'] : "0";
$pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';

$purchase_off = $hide_add_to_cart == '1' && $hide_buy_now == '1' ? true : false;

$subscriberId = $this->session->userdata($js_store_id . "ecom_session_subscriber_id");
if ($subscriberId == "") $subscriberId = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";


if ($subscriberId == '') $subscriberId = $this->uri->segment(4); //todo

$store_home_url = 'ecommerce/store/' . $js_store_unique_id;
$store_home_url = mec_add_get_param($store_home_url, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

$reset_password_url = 'ecommerce/reset_password/' . $js_store_unique_id;
$reset_password_url = mec_add_get_param($reset_password_url, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

if (isset($social_analytics_codes)) {
    $store_id = isset($social_analytics_codes['store_id']) ? $social_analytics_codes['store_id'] : $social_analytics_codes['id'];
}

$my_orders_link = "ecommerce/my_orders/" . $store_id;
$my_orders_link = mec_add_get_param($my_orders_link, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

$my_account_link = "ecommerce/my_account/" . $store_id;
$my_account_link = mec_add_get_param($my_account_link, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

function _link($uri, $skip = false)
{
    $ncd_config['eco_custom_domain'] = false;
    if (file_exists(APPPATH . 'custom_domain.php')) {
        include(APPPATH . 'custom_domain.php');
    }
    if (isset($_GET['builder']) and $_GET['builder'] == 1 and $skip == false) {
        if (strpos($uri, '?') !== false) {
            $uri = $uri . '&builder=1';
        } else {
            $uri = $uri . '?builder=1';
        }
    }
    $custom = false;

    if ($ncd_config['eco_custom_domain'] == 'true') {
        if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
            $custom = true;
        }
    }
    if ($custom == true) {
        return base_url(str_replace('ecommerce/', '', $uri));
    } else {
        return base_url($uri);
    }
}

function e_link($uri, $skip = false)
{
    echo _link($uri, $skip);
}

function page_width($string)
{
    if ($string == 'full_width') {
        $width = 'container-fluid';
    } else {
        $width = 'container';
    }
    echo $width;
}

function rating_calc($rating_point, $reviews)
{
    if ($reviews == 0) {
        return 0;
    }
    $loop = floor($rating_point / $reviews);
    $ret = $loop * 20;
    return $ret;
}

function rating_calc_points($rating_point, $reviews)
{
    if ($reviews == 0) {
        return 0;
    }
    $loop = floor($rating_point / $reviews);
    $ret = number_format(round($loop, 2), 2, '.', ' ');
    return $ret;
}

function columns_width($int, $int_mobile)
{
    switch ((int)$int) {
        case 2;
            $perpage_class = 'product-wrapper row cols-xl-2 cols-sm-1 cols-xs-2 cols-1';
            break;
        case 3;
            $perpage_class = 'product-wrapper row cols-md-3 cols-sm-2 cols-' . $int_mobile;
            break;
        case 4;
            $perpage_class = 'product-wrapper row cols-lg-4 cols-md-3 cols-sm-2 cols-' . $int_mobile;
            break;
        case 5;
            $perpage_class = 'product-wrapper row cols-lg-5 cols-md-4 cols-sm-3 cols-' . $int_mobile;
            break;
        case 6;
            $perpage_class = 'product-wrapper row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-' . $int_mobile;
            break;
        case 7;
            $perpage_class = 'product-wrapper row cols-xl-7 cols-lg-6 cols-md-4 cols-sm-3 cols-' . $int_mobile;
            break;
        case 8;
            $perpage_class = 'product-wrapper row cols-xl-8 cols-lg-6 cols-md-4 cols-sm-3 cols-' . $int_mobile;
            break;
    }
    echo $perpage_class;
}

$cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
$currentCart = isset($current_cart) ? $current_cart : array();
$hide_cart = $purchase_off ? 'style="display:none;"' : '';
$current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
$current_cart_url = _link("ecommerce/cart/" . $current_cart_id);
$current_cart_url = mec_add_get_param($current_cart_url, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
$href = $terms = $refund = '';
if ($subscriberId != "" && $current_cart_id != 0) $href = $current_cart_url;

if (empty($href)) {
    $href = _link("ecommerce/empty_cart/");
    if ($check_cn_nn == 0) {
        $href .= $js_store_unique_id;
    }
    if (!empty($subscriberId)) {
        $href .= '?subscriber_id=' . $subscriberId;
    }
}

$currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
$currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";
$currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";


$decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
$thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';

$is_guest_login = isset($ecommerce_config['is_guest_login']) ? $ecommerce_config['is_guest_login'] : "0";

$currency_left = $currency_right = "";
if ($currency_position == 'left') $currency_left = $currency_icon;
if ($currency_position == 'right') $currency_right = $currency_icon;

$pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';

if ($n_eco_builder_config['buy_button_type'] == 'add_to_cart') {
    $n_eco_builder_config['buy_button_selected'] = $n_eco_builder_config['add_to_cart_button_title'];
} else {
    $n_eco_builder_config['buy_button_selected'] = $n_eco_builder_config['buy_button_title'];
}

if ($n_eco_builder_config['buy_button_type'] == 'buy_now') {
    $n_eco_builder_config['buy_button_class'] = 'buy_now';
} else {
    $n_eco_builder_config['buy_button_class'] = '';
}

$manual_payment_instruction = isset($ecommerce_config['manual_payment_instruction']) ? $ecommerce_config['manual_payment_instruction'] : '';


function _e_scanAll($myDir)
{
    $dirTree = array();
    $di = new RecursiveDirectoryIterator($myDir, RecursiveDirectoryIterator::SKIP_DOTS);

    $i = 0;
    foreach (new RecursiveIteratorIterator($di) as $filename) {

        $dir = str_replace($myDir, '', dirname($filename));
        // $dir = str_replace('/', '>', substr($dir,1));

        $org_dir = str_replace("\\", "/", $dir);

        if ($org_dir)
            $file_path = $org_dir . "/" . basename($filename);
        else
            $file_path = basename($filename);

        $file_full_path = $myDir . "/" . $file_path;
        $file_size = filesize($file_full_path);
        $file_modification_time = filemtime($file_full_path);

        $dirTree[$i]['file'] = $file_full_path;
        $i++;
    }
    return $dirTree;
}

function _e_language_list()
{
    $myDir = APPPATH . 'language';
    $file_list = _e_scanAll($myDir);
    foreach ($file_list as $file) {
        $i = 0;
        $one_list[$i] = $file['file'];
        $one_list[$i] = str_replace("\\", "/", $one_list[$i]);
        $one_list_array[] = explode("/", $one_list[$i]);
    }
    foreach ($one_list_array as $value) {
        $pos = count($value) - 2;
        $lang_folder = $value[$pos];
        $final_list_array[] = $lang_folder;
    }
    $final_array = array_unique($final_list_array);
    $array_keys = array_values($final_array);
    foreach ($final_array as $value) {
        $uc_array_valus[] = ucfirst($value);
    }
    $array_values = array_values($uc_array_valus);
    $final_array_done = array_combine($array_keys, $array_values);
    return $final_array_done;
}

$language_info = _e_language_list();

$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

function removeqsvar($url, $varname)
{
    list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
    parse_str($qspart, $qsvars);
    unset($qsvars[$varname]);
    $newqs = http_build_query($qsvars);
    return $urlpart . '?' . $newqs;
}

