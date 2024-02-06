<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$check_ef = false;
if (file_exists(APPPATH . 'custom_domain.php')) {
    include(APPPATH . 'custom_domain.php');

    if ($ncd_config['eco_custom_domain'] == 'false' OR is_cli()) {
        $check_ef = true;
    } else {
        switch ($_SERVER['HTTP_HOST']) {

            case $ncd_config['custom_domain_host'];
                $check_ef = true;
                break;

            default;


                $route['default_controller'] = "custom_cname";
                $route['sitemap.txt'] = "custom_cname/sitemap";
                $route['language_changer'] = 'home/language_changer';

                $route['mailform/(:any)'] = 'custom_cname/mailform/$1';

                $route['empty_cart'] = 'custom_cname/empty_cart';
                $route['cod_payment'] = 'custom_cname/cod_payment';
                $route['register_action'] = 'custom_cname/register_action';


                $route['reset_password_action_step_two'] = 'custom_cname/reset_password_action_step_two';
                $route['reset_password_action'] = 'custom_cname/reset_password_action';
                $route['login_action'] = 'custom_cname/login_action';
                $route['my_orders_data'] = 'custom_cname/my_orders_data';
                $route['guest_login_action'] = 'custom_cname/guest_login_action';
                $route['logout'] = 'custom_cname/logout';


                $route['ajax_get_shipping_zone'] = 'custom_cname/ajax_get_shipping_zone';
                $route['apply_store_delivery_method'] = 'custom_cname/apply_store_delivery_method';
                $route['apply_cart_additional_data'] = 'custom_cname/apply_cart_additional_data';
                $route['save_profile_data'] = 'custom_cname/save_profile_data';
                $route['update_cart_item'] = 'custom_cname/update_cart_item';
                $route['delete_cart_item'] = 'custom_cname/delete_cart_item';
                $route['add_to_cart_modal'] = 'custom_cname/add_to_cart_modal';
                $route['comment_list_data'] = 'custom_cname/comment_list_data';


                $route['robots.txt'] = "custom_cname/robots";
                $route['bot_instagram'] = 'n_theme/bot_instagram';
                $route['ecommerce_review_comment/new_review'] = 'custom_cname/new_review';
                $route['ecommerce_review_comment/new_comment'] = 'custom_cname/new_comment';

                $route['n_paymongo'] = 'n_paymongo';
                $route['n_paymongo/(:any)'] = 'n_paymongo/$1';
                $route['n_paymongo/(:any)/(:any)'] = 'n_paymongo/$1/$2';
                $route['n_paymongo/(:any)/(:any)/(:any)'] = 'n_paymongo/$1/$2/$3';
                $route['n_paymongo/(:any)/(:any)/(:any)/(:any)'] = 'n_paymongo/$1/$2/$3/$4';
                $route['n_paymongo/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_paymongo/$1/$2/$3/$4/$5';
                $route['n_paymongo/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_paymongo/$1/$2/$3/$4/$5/$6';

                $route['n_paymentwall'] = 'n_paymentwall';
                $route['n_paymentwall/(:any)'] = 'n_paymentwall/$1';
                $route['n_paymentwall/(:any)/(:any)'] = 'n_paymentwall/$1/$2';
                $route['n_paymentwall/(:any)/(:any)/(:any)'] = 'n_paymentwall/$1/$2/$3';
                $route['n_paymentwall/(:any)/(:any)/(:any)/(:any)'] = 'n_paymentwall/$1/$2/$3/$4';
                $route['n_paymentwall/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_paymentwall/$1/$2/$3/$4/$5/$6';

                $route['n_tdsp'] = 'n_tdsp';
                $route['n_tdsp/(:any)'] = 'n_tdsp/$1';
                $route['n_tdsp/(:any)/(:any)'] = 'n_tdsp/$1/$2';
                $route['n_tdsp/(:any)/(:any)/(:any)'] = 'n_tdsp/$1/$2/$3';
                $route['n_tdsp/(:any)/(:any)/(:any)/(:any)'] = 'n_tdsp/$1/$2/$3/$4';
                $route['n_tdsp/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_tdsp/$1/$2/$3/$4/$5/$6';

                $route['n_tap'] = 'n_tap';
                $route['n_tap/(:any)'] = 'n_tap/$1';
                $route['n_tap/(:any)/(:any)'] = 'n_tap/$1/$2';
                $route['n_tap/(:any)/(:any)/(:any)'] = 'n_tap/$1/$2/$3';
                $route['n_tap/(:any)/(:any)/(:any)/(:any)'] = 'n_tap/$1/$2/$3/$4';
                $route['n_tap/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_tap/$1/$2/$3/$4/$5/$6';

                $route['n_epayco'] = 'n_epayco';
                $route['n_epayco/(:any)'] = 'n_epayco/$1';
                $route['n_epayco/(:any)/(:any)'] = 'n_epayco/$1/$2';
                $route['n_epayco/(:any)/(:any)/(:any)'] = 'n_epayco/$1/$2/$3';
                $route['n_epayco/(:any)/(:any)/(:any)/(:any)'] = 'n_epayco/$1/$2/$3/$4';
                $route['n_epayco/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_epayco/$1/$2/$3/$4/$5/$6';

                $route['N_sellix'] = 'N_sellix';
                $route['n_stripe/(:any)'] = 'n_stripe/$1';
                $route['n_stripe/(:any)/(:any)'] = 'n_stripe/$1/$2';
                $route['n_stripe/(:any)/(:any)/(:any)'] = 'n_stripe/$1/$2/$3';
                $route['n_stripe/(:any)/(:any)/(:any)/(:any)'] = 'n_stripe/$1/$2/$3/$4';
                $route['n_stripe/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_stripe/$1/$2/$3/$4/$5/$6';


                $route['n_moamalat'] = 'n_moamalat';
                $route['n_moamalat/(:any)'] = 'n_moamalat/$1';
                $route['n_moamalat/(:any)/(:any)'] = 'n_moamalat/$1/$2';
                $route['n_moamalat/(:any)/(:any)/(:any)'] = 'n_moamalat/$1/$2/$3';
                $route['n_moamalat/(:any)/(:any)/(:any)/(:any)'] = 'n_moamalat/$1/$2/$3/$4';
                $route['n_moamalat/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_moamalat/$1/$2/$3/$4/$5/$6';

                $route['n_sellix'] = 'n_sellix';
                $route['n_sellix/(:any)'] = 'n_sellix/$1';
                $route['n_sellix/(:any)/(:any)'] = 'n_sellix/$1/$2';
                $route['n_sellix/(:any)/(:any)/(:any)'] = 'n_sellix/$1/$2/$3';
                $route['n_sellix/(:any)/(:any)/(:any)/(:any)'] = 'n_sellix/$1/$2/$3/$4';
                $route['n_sellix/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_sellix/$1/$2/$3/$4/$5/$6';

                $route['n_chapa'] = 'n_chapa';
                $route['n_chapa/(:any)'] = 'n_chapa/$1';
                $route['n_chapa/(:any)/(:any)'] = 'n_chapa/$1/$2';
                $route['n_chapa/(:any)/(:any)/(:any)'] = 'n_chapa/$1/$2/$3';
                $route['n_chapa/(:any)/(:any)/(:any)/(:any)'] = 'n_chapa/$1/$2/$3/$4';
                $route['n_chapa/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_chapa/$1/$2/$3/$4/$5/$6';

                $route['n_zaincash'] = 'n_zaincash';
                $route['n_zaincash/(:any)'] = 'n_zaincash/$1';
                $route['n_zaincash/(:any)/(:any)'] = 'n_zaincash/$1/$2';
                $route['n_zaincash/(:any)/(:any)/(:any)'] = 'n_zaincash/$1/$2/$3';
                $route['n_zaincash/(:any)/(:any)/(:any)/(:any)'] = 'n_zaincash/$1/$2/$3/$4';
                $route['n_zaincash/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_zaincash/$1/$2/$3/$4/$5/$6';

                $route['N_tap'] = 'N_tap';
                $route['n_sadad/(:any)'] = 'n_sadad/$1';
                $route['n_sadad/(:any)/(:any)'] = 'n_sadad/$1/$2';
                $route['n_sadad/(:any)/(:any)/(:any)'] = 'n_sadad/$1/$2/$3';
                $route['n_sadad/(:any)/(:any)/(:any)/(:any)'] = 'n_sadad/$1/$2/$3/$4';
                $route['n_sadad/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_sadad/$1/$2/$3/$4/$5/$6';

                $route['n_payu_latam'] = 'n_payu_latam';
                $route['n_payu_latam/(:any)'] = 'n_payu_latam/$1';
                $route['n_payu_latam/(:any)/(:any)'] = 'n_payu_latam/$1/$2';
                $route['n_payu_latam/(:any)/(:any)/(:any)'] = 'n_payu_latam/$1/$2/$3';
                $route['n_payu_latam/(:any)/(:any)/(:any)/(:any)'] = 'n_payu_latam/$1/$2/$3/$4';
                $route['n_payu_latam/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_payu_latam/$1/$2/$3/$4/$5/$6';

                $route['n_coinbase'] = 'n_coinbase';
                $route['n_coinbase/(:any)'] = 'n_coinbase/$1';
                $route['n_coinbase/(:any)/(:any)'] = 'n_coinbase/$1/$2';
                $route['n_coinbase/(:any)/(:any)/(:any)'] = 'n_coinbase/$1/$2/$3';
                $route['n_coinbase/(:any)/(:any)/(:any)/(:any)'] = 'n_coinbase/$1/$2/$3/$4';
                $route['n_coinbase/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_coinbase/$1/$2/$3/$4/$5/$6';

                //$route['(:any)'] = 'custom_cname/$1';
                $route['(:any)/robots.txt'] = 'custom_cname/index/$1/robots.txt';
                $route['(:any)/sitemap.xml'] = 'custom_cname/index/$1/sitemap.xml';
                $route['ecommerce/(:any)'] = 'custom_cname/$1';
                $route['ecommerce/checkout/(:any)'] = 'custom_cname/checkout/$2';
                $route['(:any)/(:any)'] = 'custom_cname/$1/$2';

                $route['ecommerce/(:any)/(:any)'] = 'custom_cname/$1/$2';
                $route['(:any)/(:any)/(:any)'] = 'custom_cname/$1/$2/$3';
                $route['ecommerce/(:any)/(:any)/(:any)'] = 'custom_cname/$1/$2/$3';
                $route['(:any)/(:any)/(:any)/(:any)'] = 'custom_cname/$1/$2/$3/$4';
                $route['(:any)/(:any)/(:any)/(:any)/(:any)'] = 'custom_cname/$1/$2/$3/$4/$5';





                $route['404_override'] = 'home/error_404';



                $route['(:any)'] = 'custom_cname/index/$1';

                break;

        }
    }
} else {
    $check_ef = true;
}


if ($check_ef) {
    $route['default_controller'] = "home";
    $route['404_override'] = 'home/error_404';
    $route['dashboard'] = "n_theme/new_dashboard";
    $route['demo_dashboard'] = "n_theme/demo_dashboard";
    $route['dashboard/get_subscriber_data_div'] = "n_theme/get_subscriber_data_div";
    $route['dashboard/get_subscriber_data_div/(:any)'] = "n_theme/get_subscriber_data_div/$1";
    $route['dashboard/(:any)'] = "n_theme/new_dashboard/$1";
    $route['dashboard/(:any)/(:any)'] = "n_theme/new_dashboard/$1/$2";

    $route['faq'] = 'n_theme/faq';
    $route['help'] = 'n_theme/help';
    $route['task'] = 'n_task/index';
    $route['bot_instagram'] = 'n_theme/bot_instagram';

    $route['ecommerce_builder/(:num)'] = 'n_theme/ecommerce_builder/$1';
    $route['ecommerce_builder/(:any)/(:any)'] = 'n_theme/$1/$2';
    $route['ecommerce_builder/(:any)/(:any)/(:any)'] = 'n_theme/$1/$2/$3';
    $route['ecommerce_builder/(:any)/(:any)/(:any)/(:any)'] = 'n_theme/$1/$2/$3/$4';

    $route['ecommerce'] = 'custom_cname/store_list';

    $route['ecommerce/(:any)'] = 'custom_cname/$1';
    $route['ecommerce/(:any)/(:any)'] = 'custom_cname/$1/$2';
    $route['ecommerce/(:any)/(:any)/(:any)'] = 'custom_cname/$1/$2/$3';
    $route['ecommerce/(:any)/(:any)/(:any)/(:any)'] = 'custom_cname/$1/$2/$3/$4';

    $route['ecommerce/ajax_get_payment_button/(:any)/(:any)/(:any)/(:any)'] = 'custom_cname/ajax_get_payment_button/$1/$2/$3/$4';

    $route['task/(:any)'] = 'n_task/$1';
    $route['task/(:any)/(:any)'] = 'n_task/$1/$2';
    $route['task/(:any)/(:any)/(:any)'] = 'n_task/$1/$2/$3';
    $route['task/(:any)/(:any)/(:any)/(:any)'] = 'n_task/$1/$2/$3/$4';
    $route['task/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_task/$1/$2/$3/$4/$5';
    $route['task/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'n_task/$1/$2/$3/$4/$5/$6';
}

/* End of file routes.php */
/* Location: ./application/config/routes.php */