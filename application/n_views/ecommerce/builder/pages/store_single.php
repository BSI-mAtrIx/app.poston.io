<?php
$currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
$currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";
$is_category_wise_product_view = isset($ecommerce_config['is_category_wise_product_view']) ? $ecommerce_config['is_category_wise_product_view'] : "0";
$product_listing = isset($ecommerce_config['product_listing']) ? $ecommerce_config['product_listing'] : "list";
$currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
$decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
$thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
$product_list_grouped = array();
$product_list_grouped_ordered = array();
if ($is_category_wise_product_view == '1') {
    foreach ($product_list as $key => $value) {
        if (isset($category_list[$value["category_id"]]))
            $product_list_grouped[$value["category_id"]][] = $value;
        else $product_list_grouped["other"][] = $value;
    }
    foreach ($category_list as $key => $value) {
        if (isset($product_list_grouped[$key]))
            $product_list_grouped_ordered[$key] = $product_list_grouped[$key];
    }
    if (isset($product_list_grouped["other"])) $product_list_grouped_ordered["other"] = $product_list_grouped["other"];
} else $product_list_grouped_ordered['none'] = $product_list;

$hide_reviews_listing = $n_eco_builder_config['front_hide_reviews'];
?>


<main class="main">
    <?php
    //include(APPPATH.'n_views/ecommerce/builder/slider/full_width_v1.php');
    ?>
    <!-- End of Shop Banner -->
    <div class="<?php page_width($n_eco_builder_config['front_width_size']); ?>">
        <!-- Start of Shop Content -->
        <div class="shop-content">
            <!-- Start of Shop Main Content -->
            <div class="main-content">

                <?php
                $order_front = explode(',', $n_eco_builder_config['front_order']);
                foreach ($order_front as $k) {

                    switch ($k) {
                        case 'front_featured_products';
                            if ($this->is_ecommerce_related_product_exist) {
                                include(APPPATH . 'n_views/ecommerce/builder/pages/store_single/featured_section.php');
                            }
                            break;
                        case 'new_products';
                            include(APPPATH . 'n_views/ecommerce/builder/pages/store_single/new_section.php');
                            break;
                        case 'front_deals_products';
                            include(APPPATH . 'n_views/ecommerce/builder/pages/store_single/deals_section.php');
                            break;
                        case 'front_sales_products';
                            include(APPPATH . 'n_views/ecommerce/builder/pages/store_single/sales_section.php');
                            break;
                    }
                }
                ?>

            </div>
        </div>
    </div>
