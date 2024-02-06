<?php
$product_url = _link("ecommerce/product/" . $value['id'] . '_' . url_title($value['product_name']));
$product_url = mec_add_get_param($product_url, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

$cat_name_n = isset($category_list[$value['category_id']]) ? $category_list[$value['category_id']] : $this->lang->line("Uncategorised");
$product_url_cat = _link("ecommerce/category/" . $value['category_id'] . '_' . url_title($cat_name_n));
$product_url_cat = mec_add_get_param($product_url_cat, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

?>
<div class="product-wrap product-<?php echo $value['id']; ?>">
    <div class="product text-center <?php if ($n_eco_builder_config['front_hide_add_to_cart_slideup'] == 'true') { ?>product-slideup-content<?php } ?>">
        <figure class="product-media">
            <a href="<?php echo $product_url; ?>">
                <img src="<?php echo $imgSrc; ?>" alt="Product" width="300"
                     height="338"/>
            </a>
            <?php
            $show_preperation_time = false;
            if (isset($ecommerce_config['is_preparation_time']) && $ecommerce_config['is_preparation_time'] == '1' && $value["preparation_time_unit"] != "") $show_preperation_time = true;
            $preperationtime = "";
            if ($show_preperation_time) {
                $system_preparation_time = isset($ecommerce_config['preparation_time']) ? $ecommerce_config['preparation_time'] : "30";
                $system_preparation_time_unit = isset($ecommerce_config['preparation_time_unit']) ? $ecommerce_config['preparation_time_unit'] : "minutes";
                $preparation_time = $value['preparation_time'] == "" ? $system_preparation_time : $value['preparation_time'];
                $preparation_time_unit = $value['preparation_time_unit'] == "" ? $system_preparation_time_unit : $value['preparation_time_unit'];
                //$preparation_time_unit = str_replace(array("minutes","hours","days"), array("m","h","d"), $preparation_time_unit);
                $preperationtime = $value["preparation_time_unit"] != "" ? $preparation_time . "" . $preparation_time_unit : "";

                ?>
                <div class="product-countdown-container">
                    <div class="product-countdown">
                            <span class="countdown-row countdown-show4">
                                <span class="countdown-section">
                                    <span class="countdown-amount"><?php echo $preparation_time . ' ' . $this->lang->line($preparation_time_unit); ?></span>
                                    <span class="countdown-period"><?php echo $this->lang->line('PREPARATION TIME'); ?></span>
                                </span>
                            </span>
                    </div>
                </div>

            <?php } ?>

        </figure>
        <div class="product-details">
            <div class="product-cat">
                <a href="<?php echo $product_url_cat; ?>"><?php echo $cat_name_n; ?></a>
            </div>
            <h3 class="product-name">
                <a href="<?php echo $product_url; ?>"><?php echo $value['product_name']; ?></a>
            </h3>
            <?php if ($hide_reviews_listing == 'false') {
                if ($this->ecommerce_review_comment_exist) {
                    $show = false;
                    if (empty($review_data[$value['id']]['total_review']) and $always_show_reviews == 'true') {
                        $review_data[$value['id']]['total_point'] = 0;
                        $review_data[$value['id']]['total_review'] = 0;
                        $show = true;
                    }
                    if (!empty($review_data[$value['id']]['total_review'])) {
                        $show = true;
                    }
                    if ($show) {
                        ?>
                        <div class="ratings-container">
                            <div class="ratings-full">
                                <span class="ratings"
                                      style="width: <?php echo rating_calc($review_data[$value['id']]['total_point'], $review_data[$value['id']]['total_review']); ?>%;"></span>
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <a href="<?php echo $product_url; ?>"
                               class="rating-reviews">(<?php echo $review_data[$value['id']]['total_review'] . ' ';
                                echo $l->line('Reviews'); ?>)</a>
                        </div>
                    <?php }
                }
            } ?>
            <div class="product-pa-wrapper">
                <div class="product-price">
                    <?php echo $display_price; ?>
                </div>
            </div>
        </div>
        <?php if ($n_eco_builder_config['front_hide_add_to_cart_slideup'] == 'true') { ?>

            <?php if ($value['attribute_ids'] == '') { ?>

                <div class="product-hidden-details">
                    <div class="product-action">
                        <a href="#"
                           class="btn-product btn-cart add_to_cart <?php echo $n_eco_builder_config['buy_button_class']; ?>"
                           title="Add to Cart"
                           data-attributes="<?php echo $value['attribute_ids']; ?>"
                           data-product-id="<?php echo $value['id']; ?>" data-action="add">
                            <i class="w-icon-cart"></i><span><?php echo $n_eco_builder_config['buy_button_selected']; ?></span></a>
                    </div>
                </div>

            <?php } else { ?>

                <div class="product-hidden-details">
                    <div class="product-action">
                        <a href="#"
                           class="btn-product btn-cart add_to_cart_modal <?php echo $n_eco_builder_config['buy_button_class']; ?>"
                           title="Add to Cart"
                           data-product-id="<?php echo $value['id']; ?>">
                            <i class="w-icon-cart"></i><span><?php echo $n_eco_builder_config['buy_button_selected']; ?></span></a>
                    </div>
                </div>

            <?php } ?>

        <?php } ?>
    </div>
</div>
