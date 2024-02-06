<?php
$excat = explode('_', $category_id);
$category_id = $excat[0];

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
        if (isset($category_list[$value["category_id"]])) {
            $product_list_grouped[$value["category_id"]][] = $value;
        } else {
            $product_list_grouped["other"][] = $value;
        }
    }

    foreach ($category_list as $key => $value) {
        if (isset($product_list_grouped[$key])) {
            $product_list_grouped_ordered[$key] = $product_list_grouped[$key];
        }
    }
    if (isset($product_list_grouped["other"])) {
        $product_list_grouped_ordered["other"] = $product_list_grouped["other"];
    }
} else {
    $product_list_grouped_ordered['none'] = $product_list;
}

$category_product_views_style = $n_eco_builder_config['category_product_views_style'];
if (isset($_GET['list_style'])) {
    $category_product_views_style = $_GET['list_style'];
}

?>


<main class="main">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo isset($category_list[$category_id]) ? $category_list[$category_id] : $this->lang->line("Uncategorised"); ?></li>
            </ul>
        </div>
    </nav>

    <!-- End of Breadcrumb -->
    <!-- End of Shop Banner -->
    <div class="container">
        <!-- Start of Shop Content -->
        <div class="shop-content">
            <!-- Start of Shop Main Content -->
            <div class="main-content">
                <div class="title-link-wrapper pb-1 mb-4">
                    <h2 class="title ls-normal mb-0"><?php echo isset($category_list[$category_id]) ? $category_list[$category_id] : $this->lang->line("Uncategorised"); ?></h2>
                </div>
                <?php if ($n_eco_builder_config['category_single_description'] == 'true') {

                    $cat_details = $this->basic->get_data("ecommerce_category", array('where' => array('id' => $category_id)));

                    if ($cat_details[0]['description'] != '') {
                        ?>
                        <div class="row align-items-center mb-4">
                            <?php
                            $col_cat_desc = 'col-md-12';
                            if ($cat_details[0]['thumbnail'] != '') {
                                $col_cat_desc = 'col-md-8';
                                ?>
                                <div class="col-md-4 mb-4">
                                    <figure>
                                        <img src="<?php echo base_url('upload/ecommerce/' . $cat_details[0]['thumbnail']); ?>"
                                             alt="Banner" style="background-color: #E6E6E6;" class="w-100">
                                    </figure>
                                </div>
                            <?php } ?>
                            <div class="col-md-8 mb-4">
                                <?php echo $cat_details[0]['description']; ?>
                            </div>
                        </div>


                    <?php }
                } ?>

                <nav class="toolbox sticky-toolbox sticky-content fix-top">
                    <div class="toolbox-left">
                        <?php include(APPPATH . 'n_views/ecommerce/builder/misc/sort_by.php'); ?>
                    </div>
                    <div class="toolbox-right">
                        <?php if ($n_eco_builder_config['category_product_views_style_buttons'] == 'true') { ?>
                            <div class="toolbox-item toolbox-layout">
                                <?php
                                $url_add_style = '?list_style=';
                                if (strpos($actual_link, '?') !== false) {
                                    $url_add_style = '&list_style=';
                                }
                                $actual_link = removeqsvar($actual_link, 'list_style');
                                ?>
                                <a href="<?php echo $actual_link . $url_add_style . 'boxed'; ?>"
                                   class="icon-mode-grid btn-layout <?php if ($category_product_views_style == 'boxed') {
                                       echo 'active';
                                   }; ?>">
                                    <i class="w-icon-grid"></i>
                                </a>
                                <a href="<?php echo $actual_link . $url_add_style . '2columnlist'; ?>"
                                   class="icon-mode-list btn-layout  <?php if ($category_product_views_style != 'boxed') {
                                       echo 'active';
                                   }; ?>">
                                    <i class="w-icon-list"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </nav>
                <div class="<?php if ($category_product_views_style == 'boxed') {
                    columns_width($n_eco_builder_config['category_perpage'], $n_eco_builder_config['mobile_columns_div']);
                }
                if ($category_product_views_style == '2columnlist') {
                    columns_width(2, $n_eco_builder_config['mobile_columns_div']);
                } ?>">

                    <?php
                    $hide_reviews_listing = $n_eco_builder_config['category_hide_reviews'];
                    if (!empty($product_list)) {
                        foreach ($product_list_grouped_ordered as $key_main => $value_main) { ?>
                            <?php foreach ($value_main as $key => $value) {
                                $imgSrc = ($value['thumbnail'] != '') ? base_url('upload/ecommerce/' . $value['thumbnail']) : base_url('assets/img/products/product-1.jpg');
                                if (isset($value["woocommerce_product_id"]) && !is_null($value["woocommerce_product_id"]) && $value['thumbnail'] != '')
                                    $imgSrc = $value['thumbnail'];
                                $display_price = mec_display_price($value['original_price'], $value['sell_price'], ' ' . $currency_icon . ' ', '1', $currency_position, $decimal_point, $thousand_comma);


                                switch ($category_product_views_style) {
                                    case '1columnlist';
                                        include(APPPATH . 'n_views/ecommerce/builder/product/1columnlist_v1.php');
                                        break;

                                    case '2columnlist';
                                        include(APPPATH . 'n_views/ecommerce/builder/product/1columnlist_v1.php');
                                        break;

                                    default;
                                        include(APPPATH . 'n_views/ecommerce/builder/product/product_v1.php');
                                        break;
                                }


                                ?>
                            <?php }; ?>
                        <?php }; ?>
                    <?php }; ?>


                </div>
                <div class="toolbox toolbox-pagination justify-content-between">
                    <p class="showing-info mb-2 mb-sm-0"></p>
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</main>


