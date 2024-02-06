<?php
switch ($body) {

    case 'product_single';
        if ($product_data['featured_images'] != "") {
            $featured_images_array = ($product_data['featured_images'] != "") ? explode(',', $product_data['featured_images']) : array();
            if (!empty($featured_images_array[0])) {
                $img_to_og_tags = $featured_images_array[0];
            }
        }

        if (empty($img_to_og_tags)) {
            $img_to_og_tags = ($product_data['thumbnail'] != '') ? base_url('upload/ecommerce/' . $product_data['thumbnail']) : base_url('assets/img/products/product-1.jpg');
        }

        echo '
        <meta property="og:type" content="product">
        <meta property="og:title" content="' . $product_data["product_name"] . '">
        <meta property="og:url" content="' . _link("ecommerce/product/" . $product_data['id'] . '_' . url_title($product_data['product_name'])) . '">';

        if (empty($img_to_og_tags)) {
            echo '
        <meta property="og:image" content="' . base_url($n_eco_builder_config['og_image_website']) . '">
        ';
        }


        echo '<meta property="og:image" content="' . base_url("upload/ecommerce/" . $img_to_og_tags) . '">
            <meta property="product:price.amount" content="' . mec_display_price($product_data['original_price'], $product_data['sell_price'], '', '0', $currency_position, $decimal_point, $thousand_comma) . '">
        <meta property="product:price.currency" content="' . $currency . '">
    ';

        break;

    default;

        echo '
        <meta property="og:type" content="website">
        <meta property="og:title" content="' . $page_title . '">
        <meta property="og:url" content="' . _link($store_home_url) . '">
        <meta property="og:description" content="' . $n_eco_builder_config['site_description'] . '">
    ';

        if (!empty($n_eco_builder_config['og_image_website'])) {
            echo '
        <meta property="og:image" content="' . base_url($n_eco_builder_config['og_image_website']) . '">
        ';
        }

        break;
}