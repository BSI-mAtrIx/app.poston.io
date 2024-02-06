<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_payment_amount($cart_id, $subscriber_id){
    $cart_data = priv_valid_cart_data($cart_id, $subscriber_id, 'payment_amount, store_id, coupon_code');

    if (!isset($cart_data[0]) || (isset($cart_data[0]) && $cart_data[0]["store_id"] == "")) {
        return false;
    }
    return $cart_data[0]['payment_amount'];
}

function priv_valid_cart_data($cart_id = 0, $subscriber_id = "", $select = "", $once = 0)
{
    $CI =& get_instance();

    $join = array('ecommerce_store' => "ecommerce_cart.store_id=ecommerce_store.id,left");
    $where = array('where' => array(
        "ecommerce_cart.subscriber_id" => $subscriber_id,
        "ecommerce_cart.id" => $cart_id,
        "action_type!=" => "checkout",
        "ecommerce_store.status" => "1"
    )
    );
    if ($select == "") $select = array("ecommerce_cart.*", "tax_percentage", "shipping_charge", "store_unique_id", "store_locale");
    $cart_data = $CI->basic->get_data("ecommerce_cart", $where, $select, $join, 1);
    //var_dump($cart_id=0,$subscriber_id="",$select="");
    if (empty($cart_data) and $once == 0) {
        $cart_data = priv_valid_cart_data($cart_id, $CI->session->userdata($cart_data[0]['store_id'] . '_temp_cart'), $select, 1);
    }
    return $cart_data;
}

function return_ecommerce_base_url($url){
    if (file_exists(APPPATH . 'custom_domain.php')) {
        include(APPPATH . 'custom_domain.php');
        if ($ncd_config['eco_custom_domain'] == 'true') {
            if ($_SERVER['HTTP_HOST'] != $ncd_config['custom_domain_host']) {
                return $url;
            }else{
                return 'ecommerce/'.$url;
            }
        }else{
            return 'ecommerce/'.$url;
        }
    }else{
        return 'ecommerce/'.$url;
    }
}
