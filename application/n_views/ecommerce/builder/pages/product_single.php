<?php
switch ($n_eco_builder_config['product_single_gallery_type']) {
    case 'product-gallery-vertical';
        $div_class_1 = ' product-gallery-vertical';
        $div_class_2 = '';
        break;
    case 'product-gallery-horizontal';
        $div_class_1 = '';
        $div_class_2 = ' row cols-4 gutter-sm';
        break;
}

$cat_name = isset($category_list[$product_data['category_id']]) ? $category_list[$product_data['category_id']] : $this->lang->line("Uncategorised");

$hide_reviews_listing = 'true';
$always_show_reviews = 'false';
if ($n_eco_builder_config['product_single_reviews_show'] == 'show' or $n_eco_builder_config['product_single_reviews_show'] == 'always_show') {
    $hide_reviews_listing = 'false';
}
if ($n_eco_builder_config['product_single_reviews_show'] == 'always_show') {
    $always_show_reviews = 'true';
}

$subscriber_id = $this->session->userdata($product_data['store_id'] . "ecom_session_subscriber_id");
if ($subscriber_id == "") $subscriber_id = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";

$have_attributes = false;
$product_attributes = array_filter(explode(',', $product_data['attribute_ids']));
if (is_array($product_attributes) && !empty($product_attributes)) $have_attributes = true;

$current_cart_data = (isset($current_cart["cart_data"]) && is_array($current_cart["cart_data"])) ? $current_cart["cart_data"] : array();

$quantity_in_cart = 0;
if (!$have_attributes) $quantity_in_cart = isset($current_cart_data[$product_data['id']]["quantity"]) ? $current_cart_data[$product_data['id']]["quantity"] : 0;
else if (isset($_GET['quantity'])) $quantity_in_cart = $_GET['quantity'];

foreach ($attribute_price_map as $key => $value) {
    $x = $value["amount"] == 0 && $value["price_indicator"] == 'x' ? 'x' : '';
    $ammount_formatted = $currency_left . mec_number_format($value["amount"], $decimal_point, $thousand_comma) . $currency_right;
    $map_array[$value["attribute_id"]][$value["attribute_option_name"]] = $value["amount"] != 0 ? $value["price_indicator"] . $ammount_formatted : $x;
}


?>
<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li>
                    <a href="<?php e_link('ecommerce/category/' . $product_data['category_id'] . '_' . url_title($cat_name)) ?>"><?php echo $cat_name; ?></a>
                </li>
                <li><?php echo $product_data['product_name']; ?></li>
            </ul>
        </div>
    </nav>
    <!-- Start of Page Content -->
    <div class="page-content">
        <div class="container">
            <div class="main-content">
                <div class="product product-single row">
                    <div class="col-md-6 mb-4 mb-md-8">
                        <div class="product-gallery product-gallery-sticky <?php echo $div_class_1; ?> ">

                            <?php
                            if ($product_data['featured_images'] != "") { ?>
                                <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">
                                    <?php $featured_images_array = ($product_data['featured_images'] != "") ? explode(',', $product_data['featured_images']) : array(); ?>
                                    <?php if ($product_data['featured_images'] != "") { ?>
                                        <?php
                                        $i = 0;
                                        foreach ($featured_images_array as $key => $value) {
                                            $imgSrc = base_url('upload/ecommerce/' . $value);

                                            ?>
                                            <figure class="product-image" data-size="<?php echo $n_config['recommend_photoswipe_resolution']; ?>">
                                                <img src="<?php echo $imgSrc; ?>"
                                                     data-zoom-image="<?php echo $imgSrc; ?>"
                                                     alt="photo product <?php echo $i++; ?>" />
                                            </figure>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="product-thumbs-wrap">
                                    <div class="product-thumbs <?php echo $div_class_2; ?> ">

                                        <?php
                                        $i = 0;
                                        foreach ($featured_images_array as $key => $value) {
                                            $imgSrc = base_url('upload/ecommerce/' . $value);

                                            ?>
                                            <div class="product-thumb <?php if ($i == 0) {
                                                echo 'active';
                                            } ?>">
                                                <img src="<?php echo $imgSrc; ?>" style="max-height: 100px;"
                                                     alt="photo thumb product <?php echo $i; ?>">
                                            </div>
                                            <?php $i++;
                                        } ?>

                                    </div>
                                    <button class="thumb-up disabled">
                                        <i class="w-icon-angle-left"></i>
                                    </button>
                                    <button class="thumb-down disabled">
                                        <i class="w-icon-angle-right"></i>
                                    </button>
                                </div>

                            <?php } else {
                                $imgSrc = ($product_data['thumbnail'] != '') ? base_url('upload/ecommerce/' . $product_data['thumbnail']) : base_url('assets/img/products/product-1.jpg');
                                if (isset($product_data["woocommerce_product_id"]) && !is_null($product_data["woocommerce_product_id"]) && $product_data['thumbnail'] != '')
                                    $imgSrc = $product_data['thumbnail'];
                                ?>
                                <div class="product-image">
                                    <img src="<?php echo $imgSrc; ?>">
                                </div>


                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-6 mb-md-8">
                        <div class="product-details" data-sticky-options="{'minWidth': 767}">
                            <h1 class="product-title"><?php echo $product_data['product_name']; ?></h1>
                            <div class="product-bm-wrapper">
                                <div class="product-meta">
                                    <div class="product-categories">
                                        <?php echo $l->line('Category:'); ?>
                                        <span class="product-category"><a
                                                    href="<?php e_link('ecommerce/category/' . $product_data['category_id'] . '_' . url_title($cat_name)) ?>"><?php echo $cat_name; ?></a></span>
                                    </div>
                                </div>
                            </div>

                            <hr class="product-divider">

                            <?php if ($n_eco_builder_config['product_single_show_price_place'] == 'show_review_price' or $n_eco_builder_config['product_single_show_price_place'] == 'show_both_price') { ?>
                                <div class="product-price"
                                     id=""><?php echo mec_display_price($product_data['original_price'], $product_data['sell_price'], ' ' . $currency_icon . ' ', '1', $currency_position, $decimal_point, $thousand_comma); ?></div>
                            <?php } ?>

                            <?php if ($hide_reviews_listing == 'false') {
                                if ($this->ecommerce_review_comment_exist) {
                                    $show = false;
                                    if (empty($review_data[0]['total_review']) and $always_show_reviews == 'true') {
                                        $review_data[0]['total_point'] = 0;
                                        $review_data[0]['total_review'] = 0;
                                        $show = true;
                                    }
                                    if (!empty($review_data[0]['total_review'])) {
                                        $show = true;
                                    }
                                    if ($show) {
                                        ?>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings"
                                                      style="width: <?php echo rating_calc($review_data[0]['total_point'], $review_data[0]['total_review']); ?>%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="<?php e_link("ecommerce/product/" . $product_data['id'] . '_' . url_title($product_data['product_name'])); ?>"
                                               class="rating-reviews">(<?php echo $review_data[0]['total_review'] . ' ';
                                                echo $l->line('Reviews'); ?>)</a>
                                        </div>
                                    <?php }
                                }
                            } ?>

                            <?php
                            if ($n_eco_builder_config['product_single_show_sales'] == 'true' and $product_data['sales_count'] > 0) {
                                echo '<div class="alert alert-success d-inline-flex align-items-center "><i class=" w-icon-cart font-size-small pr-1"></i>' . $this->lang->line("Sales") . ' ' . $product_data['sales_count'] . '</div>';
                            }
                            ?>

                            <?php if ($product_data['stock_display'] == '1') : ?>
                                <p class="card-text align-right">
                                    <?php
                                    if ($product_data['stock_item'] > 0) {
                                        echo $this->lang->line("Available");
                                        echo ' - <span class="alert-success">' . $this->lang->line("Stock") . ' ' . $product_data['stock_item'] . '</span>';
                                    } else {
                                        echo $this->lang->line("Not Available");
                                    }; ?>
                                </p>
                            <?php endif; ?>

                            <hr class="product-divider">

                            <?php if ($have_attributes): ?>
                                <div class="product-color-options">
                                    <div id="details">
                                        <?php if ($have_attributes){ ?>
                                        <div class="col-12">
                                            <!-- <ul class="list-group mb-2"> -->
                                            <?php
                                            $attr_count = 0;

                                            foreach ($attribute_list as $key => $value) {

                                                if (in_array($value["id"], $product_attributes)) {
                                                    $attr_count++;
                                                    $name = "attribute_" . $attr_count;
                                                    $options_array = json_decode($value["attribute_values"], true);
                                                    $url_option = "option" . $value["id"];
                                                    $selected = isset($_GET[$url_option]) ? $_GET[$url_option] : "";
                                                    $selected = explode(',', $selected);

                                                    $star = ($value['optional'] == '0') ? '*' : '';
                                                    $options_print = "";
                                                    $count = 0;
                                                    foreach ($options_array as $key2 => $value2) {
                                                        $selected_attr = in_array($value2, $selected) ? "checked" : "";
                                                        $count++;
                                                        $temp_id = $name . $count;
                                                        $tempu = isset($map_array[$value["id"]][$value2]) ? $map_array[$value["id"]][$value2] : "";

                                                        $continue = false;
                                                        if ($tempu != '') {
                                                            $first_char = substr($tempu, 0, 1);
                                                            if ($first_char == 'x') $continue = true;
                                                        }
                                                        if ($continue) continue;
                                                        if ($value['multiselect'] == '1') {
                                                            $options_print .= '
                                <fieldset class="size">
                                                            <div class="form-checkbox  d-flex align-items-center justify-content-between">
                                  <input type="checkbox" data-attr="' . $value["id"] . '" name="' . $name . '"   value="' . $value2 . '" class=" custom-checkbox options " id="' . $temp_id . '" data-optional="' . $value["optional"] . '" ' . $selected_attr . '>
                                  <label class="d-inline-block options_single_prod" for="' . $temp_id . '" style="max-width:initial;white-space:nowrap;">' . $value2 . ' <strong class="text-dark ml-1">' . $tempu . '</strong></label>
                                </div>
                                                   </fieldset>';
                                                        } else {

                                                            $options_print .= '                                               
                                                   <fieldset class="size">
                                                            <div>
                                                                <input type="radio" class="custom-checkbox checkbox-round options"  data-attr="' . $value["id"] . '"  name="' . $name . '"  id="' . $value2 . '"  value="' . $value2 . '" id="radio1" data-optional="' . $value["optional"] . '" ' . $selected_attr . '>
                                                                <label for="' . $value2 . '" class="d-inline-block options_single_prod" style="white-space:nowrap;max-width:initial;">' . $value2 . ' <strong class="text-dark ml-1">' . $tempu . '</strong></label>
                                                            </div>
                                                   </fieldset>';
                                                        }

                                                    }

                                                    echo '
                              <div class="product-form mb-1">
                                <label class="mb-5 font-weight-bold">
                                  ' . $value["attribute_name"] . $star . '
                                </label>
                                <div class="flex-wrap d-flex align-items-center product-size-swatch">
                                 ' . $options_print . '   
                                </div>
                              </div>';
                                                }
                                            }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="product-variation-price" id="calculated_price_basedon_attribute">
                            </div>

                            <?php
                            $stock_item = $product_data['stock_item'];
                            $stock_prevent_purchase = $product_data['stock_prevent_purchase'];

                            if ($stock_prevent_purchase == '1' and $stock_item == '0') {
                                $hide_add_to_cart = 1;
                                $hide_buy_now = 1;

                                echo '<div class="alert alert-warning mb-2" role="alert">' . $this->lang->line('sorry, this item is out of stock. we are not taking any order right now.') . '</div>';
                            }


                            $show_preperation_time = false;
                            if (isset($ecommerce_config['is_preparation_time']) && $ecommerce_config['is_preparation_time'] == '1' && $product_data["preparation_time_unit"] != "") $show_preperation_time = true;
                            $preperationtime = "";
                            if ($show_preperation_time) {
                                $system_preparation_time = isset($ecommerce_config['preparation_time']) ? $ecommerce_config['preparation_time'] : "30";
                                $system_preparation_time_unit = isset($ecommerce_config['preparation_time_unit']) ? $ecommerce_config['preparation_time_unit'] : "minutes";
                                $preparation_time = $product_data['preparation_time'] == "" ? $system_preparation_time : $product_data['preparation_time'];
                                $preparation_time_unit = $product_data['preparation_time_unit'] == "" ? $system_preparation_time_unit : $product_data['preparation_time_unit'];
                                //$preparation_time_unit = str_replace(array("minutes","hours","days"), array("m","h","d"), $preparation_time_unit);
                                $preperationtime = $product_data["preparation_time_unit"] != "" ? $preparation_time . "" . $preparation_time_unit : "";

                                ?>
                                <div class="product-countdown-container">
                                    <div class="product-countdown">
                            <span class="countdown-row countdown-show4">
                                <span class="countdown-section">
                                    <span class="countdown-period"><?php echo $this->lang->line('PREPARATION TIME'); ?>: </span>
                                    <span class="countdown-amount"><?php echo $preparation_time . ' ' . $this->lang->line($preparation_time_unit); ?></span>

                                </span>
                            </span>
                                    </div>
                                </div>

                            <?php }

                            if ($hide_add_to_cart == '0'): ?>
                                <div class="fix-bottom <?php if ($n_eco_builder_config['product_single_sticky'] == 'true') { ?> product-sticky-content sticky-content  <?php } ?>">
                                    <div class="product-form container">
                                        <div class="product-qty-form">
                                            <div class="input-group">
                                                <input class="quantity form-control" inputmode="numeric" type="number"
                                                       data-quantityinput="<?php echo $quantity_in_cart; ?>"
                                                       data-toggle="tooltip"
                                                       title="<?php echo $this->lang->line('Currently added to cart'); ?>"
                                                       id="item_count"
                                                       value="<?php echo $quantity_in_cart; ?>">
                                                <button class="quantity-plus w-icon-plus"
                                                        data-product-id="<?php echo $product_data['id']; ?>"
                                                        data-attributes="<?php echo $product_data['attribute_ids']; ?>"
                                                        data-action="add" data-toggle="tooltip"
                                                        title="<?php echo $this->lang->line('Add 1 to Cart'); ?>"></button>
                                                <button class="quantity-minus w-icon-minus"
                                                        data-product-id="<?php echo $product_data['id']; ?>"
                                                        data-attributes="<?php echo $product_data['attribute_ids']; ?>"
                                                        data-action="remove" data-toggle="tooltip"
                                                        title="<?php echo $this->lang->line('Remove 1 from Cart'); ?>"></button>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-cart add_to_cart"
                                                data-product-id="<?php echo $product_data['id']; ?>"
                                                data-attributes="<?php echo $product_data['attribute_ids']; ?>"
                                                data-action="add">
                                            <i class="w-icon-cart"></i>
                                            <span><?php echo $this->lang->line('Add to Cart'); ?></span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <div class="social-links-wrapper">
                                <?php if ($n_eco_builder_config['addthis_show'] == 'true') { ?>
                                    <div class="<?php echo $n_eco_builder_config['addthis_class']; ?> mt-2"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                    <ul class="nav nav-tabs" role="tablist">

                        <li class="nav-item">
                            <a href="#product-tab-description" id="description-tab2"
                               class="nav-link active"><?php echo $this->lang->line("Details"); ?></a>
                        </li>

                        <?php if (!empty($product_data['purchase_note'])): ?>
                            <li class="nav-item">
                                <a href="#purchase_note" id="purchase_note-tab2"
                                   class="nav-link "><?php echo $this->lang->line("Note"); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->ecommerce_review_comment_exist): ?>
                            <li class="nav-item">
                                <a href="#product-tab-reviews"
                                   class="nav-link"><?php echo $this->lang->line("Reviews"); ?></a>
                            </li>
                        <?php endif; ?>


                        <li class="nav-item">
                            <a href="#comments_tab" class="nav-link"><?php echo $this->lang->line("Comments"); ?></a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="product-tab-description">
                            <?php echo htmlspecialchars_decode(str_replace('stzle', 'style', $product_data['product_description'])); ?>
                        </div>
                        <?php if (!empty($product_data['purchase_note'])): ?>
                            <div class="tab-pane" id="purchase_note">
                                <?php echo htmlspecialchars_decode(str_replace('stzle', 'style', $product_data['purchase_note'])); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->ecommerce_review_comment_exist): ?>
                            <div class="tab-pane" id="comments_tab">
                                <div class="card mb-0 shadow-none">
                                    <div class="card-header p-0 pt-3 pb-3">
                                        <h4><?php echo $this->lang->line("Leave a comment"); ?></h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <textarea id="new_comment" class="form-control comment_reply"
                                                  placeholder="<?php echo $this->lang->line('Write comment here'); ?>"></textarea>
                                        <button class="btn btn-primary leave_comment mt-2" parent-id=''
                                                id="leave_comment"><?php echo $this->lang->line("Comment"); ?></button>
                                    </div>
                                </div>
                                <div class="card mt-2 mb-2 shadow-none" id="comment_section">
                                    <div class="card-header p-0 pt-3 pb-3">
                                        <h4><i class="w-icon-comment"></i> <?php echo $this->lang->line("Comments"); ?>
                                        </h4>
                                    </div>
                                    <div class="card-body p-0">

                                        <ul class="comments list-style-none" id="load_data">

                                        </ul>

                                        <div class="text-center" id="waiting" style="width: 100%;margin: 30px 0;">
                                            <i class=" w-icon-return2 blue" style="font-size:60px;"></i>
                                        </div>

                                        <div class="card shadow-none m-0" id="nodata" style="display: none">
                                            <div class="card-body">
                                                <div class="empty-state p-0">
                                                    <h6 class="mt-0"><?php echo $this->lang->line("We could not find any comment.") ?></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary m-3 mb-4" style="display: none;" id="load_more"
                                                data-limit="10" data-start="0"><i
                                                    class="w-icon-play"></i> <?php echo $this->lang->line("Load More"); ?>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->ecommerce_review_comment_exist): ?>
                            <div class="tab-pane" id="product-tab-reviews">
                                <?php if (empty($review_list_data)) { ?>
                                    <div class="row mb-4">
                                        <div class="col-xl-4 col-lg-5 mb-4">
                                            <?php echo ' <h6 class="mt-0">' . $this->lang->line("We could not find any review.") . '</h6>'; ?>
                                        </div>
                                        <div class="col-xl-8 col-lg-7 mb-4">
                                            <div class="review-form-wrapper">
                                                <?php if ($this->ecommerce_review_comment_exist && $subscriber_id != "" && $this->user_id == '' && !empty($has_purchase_array)) : ?>
                                                    <h3 class="title tab-pane-title font-weight-bold mb-1"><?php echo $this->lang->line("Rate this item"); ?></h3>
                                                    <form action="#" method="POST" class="review-form">
                                                        <input type="hidden" id="insert_id" name="insert_id"
                                                               value="<?php echo isset($xreview[0]['id']) ? $xreview[0]['id'] : ""; ?>">
                                                        <div class="rating-form">
                                                            <label for="rating"><?php echo $this->lang->line("Your Rating Of This Product"); ?>
                                                                :</label>
                                                            <span class="rating-stars">
                                                                    <a class="star-1" href="#">1</a>
                                                                    <a class="star-2" href="#">2</a>
                                                                    <a class="star-3" href="#">3</a>
                                                                    <a class="star-4" href="#">4</a>
                                                                    <a class="star-5" href="#">5</a>
                                                                </span>
                                                            <select name="rating" id="rating" required=""
                                                                    style="display: none;">
                                                                <option value="">Rate…</option>
                                                                <option value="5">Perfect</option>
                                                                <option value="4">Good</option>
                                                                <option value="3">Average</option>
                                                                <option value="2">Not that bad</option>
                                                                <option value="1">Very poor</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cart_id"><?php echo $this->lang->line("Related Order"); ?>
                                                                *</label>
                                                            <div class="input-group">
                                                                <?php
                                                                $related_order = array();
                                                                $default_related_order = isset($xreview[0]['cart_id']) ? $xreview[0]['cart_id'] : "";
                                                                foreach ($has_purchase_array as $key => $value) {
                                                                    $related_order[$value["cart_id"]] = $this->lang->line("Order") . " #" . $value["cart_id"];
                                                                }
                                                                echo form_dropdown('cart_id', $related_order, $default_related_order, 'class="form-control" id="cart_id"');
                                                                ?>
                                                            </div>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><?php echo $this->lang->line("Reason"); ?>
                                                                *</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                       value="<?php echo isset($xreview[0]['reason']) ? $xreview[0]['reason'] : ""; ?>"
                                                                       class="form-control"
                                                                       placeholder="<?php echo $this->lang->line("Example : Quick Delivery"); ?>"
                                                                       id="reason" name="reason">
                                                            </div>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><?php echo $this->lang->line("Review"); ?></label>
                                                            <textarea class="form-control" cols="30" rows="6"
                                                                      placeholder="<?php echo $this->lang->line("Write a few words"); ?>"
                                                                      id="review"
                                                                      name="review"><?php echo isset($xreview[0]['review']) ? $xreview[0]['review'] : ""; ?></textarea>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <button type="submit" id="rate_now"
                                                                class="btn btn-dark"><?php echo $this->lang->line("Submit Review"); ?></button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php } else { ?>
                                    <div class="row mb-4">
                                        <div class="col-xl-4 col-lg-5 mb-4">
                                            <div class="ratings-wrapper">
                                                <div class="avg-rating-container">
                                                    <h4 class="avg-mark font-weight-bolder ls-50"> <?php echo rating_calc_points($review_data[0]['total_point'], $review_data[0]['total_review']); ?></h4>
                                                    <div class="avg-rating">
                                                        <p class="text-dark mb-1"><?php echo $l->line('Average Rating'); ?></p>
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings"
                                                                      style="width:  <?php echo rating_calc($review_data[0]['total_point'], $review_data[0]['total_review']); ?>%;"></span>
                                                                <span class="tooltiptext tooltip-top"></span>
                                                            </div>
                                                            <a href="<?php e_link("ecommerce/product/" . $product_data['id'] . '_' . url_title($product_data['product_name'])); ?>"
                                                               class="rating-reviews">(<?php echo $review_data[0]['total_review'] . ' ';
                                                                echo $l->line('Reviews'); ?>)</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--     todo:                                   <div class="ratings-list">-->
                                                <!--                                            <div class="ratings-container">-->
                                                <!--                                                <div class="ratings-full">-->
                                                <!--                                                    <span class="ratings" style="width: 100%;"></span>-->
                                                <!--                                                    <span class="tooltiptext tooltip-top"></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-bar progress-bar-sm ">-->
                                                <!--                                                    <span></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-value">-->
                                                <!--                                                    <mark>70%</mark>-->
                                                <!--                                                </div>-->
                                                <!--                                            </div>-->
                                                <!--                                            <div class="ratings-container">-->
                                                <!--                                                <div class="ratings-full">-->
                                                <!--                                                    <span class="ratings" style="width: 80%;"></span>-->
                                                <!--                                                    <span class="tooltiptext tooltip-top"></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-bar progress-bar-sm ">-->
                                                <!--                                                    <span></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-value">-->
                                                <!--                                                    <mark>30%</mark>-->
                                                <!--                                                </div>-->
                                                <!--                                            </div>-->
                                                <!--                                            <div class="ratings-container">-->
                                                <!--                                                <div class="ratings-full">-->
                                                <!--                                                    <span class="ratings" style="width: 60%;"></span>-->
                                                <!--                                                    <span class="tooltiptext tooltip-top"></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-bar progress-bar-sm ">-->
                                                <!--                                                    <span></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-value">-->
                                                <!--                                                    <mark>40%</mark>-->
                                                <!--                                                </div>-->
                                                <!--                                            </div>-->
                                                <!--                                            <div class="ratings-container">-->
                                                <!--                                                <div class="ratings-full">-->
                                                <!--                                                    <span class="ratings" style="width: 40%;"></span>-->
                                                <!--                                                    <span class="tooltiptext tooltip-top"></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-bar progress-bar-sm ">-->
                                                <!--                                                    <span></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-value">-->
                                                <!--                                                    <mark>0%</mark>-->
                                                <!--                                                </div>-->
                                                <!--                                            </div>-->
                                                <!--                                            <div class="ratings-container">-->
                                                <!--                                                <div class="ratings-full">-->
                                                <!--                                                    <span class="ratings" style="width: 20%;"></span>-->
                                                <!--                                                    <span class="tooltiptext tooltip-top"></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-bar progress-bar-sm ">-->
                                                <!--                                                    <span></span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="progress-value">-->
                                                <!--                                                    <mark>0%</mark>-->
                                                <!--                                                </div>-->
                                                <!--                                            </div>-->
                                                <!--                                        </div>-->
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-7 mb-4">
                                            <div class="review-form-wrapper">
                                                <?php if ($this->ecommerce_review_comment_exist && $subscriber_id != "" && $this->user_id == '' && !empty($has_purchase_array)) : ?>
                                                    <h3 class="title tab-pane-title font-weight-bold mb-1"><?php echo $this->lang->line("Rate this item"); ?></h3>
                                                    <form action="#" method="POST" class="review-form">
                                                        <input type="hidden" id="insert_id" name="insert_id"
                                                               value="<?php echo isset($xreview[0]['id']) ? $xreview[0]['id'] : ""; ?>">
                                                        <div class="rating-form">
                                                            <label for="rating"><?php echo $this->lang->line("Your Rating Of This Product"); ?>
                                                                :</label>
                                                            <span class="rating-stars">
                                                                    <a class="star-1" href="#">1</a>
                                                                    <a class="star-2" href="#">2</a>
                                                                    <a class="star-3" href="#">3</a>
                                                                    <a class="star-4" href="#">4</a>
                                                                    <a class="star-5" href="#">5</a>
                                                                </span>
                                                            <select name="rating" id="rating" required=""
                                                                    style="display: none;">
                                                                <option value="">Rate…</option>
                                                                <option value="5">Perfect</option>
                                                                <option value="4">Good</option>
                                                                <option value="3">Average</option>
                                                                <option value="2">Not that bad</option>
                                                                <option value="1">Very poor</option>
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cart_id"><?php echo $this->lang->line("Related Order"); ?>
                                                                *</label>
                                                            <div class="input-group">
                                                                <?php
                                                                $related_order = array();
                                                                $default_related_order = isset($xreview[0]['cart_id']) ? $xreview[0]['cart_id'] : "";
                                                                foreach ($has_purchase_array as $key => $value) {
                                                                    $related_order[$value["cart_id"]] = $this->lang->line("Order") . " #" . $value["cart_id"];
                                                                }
                                                                echo form_dropdown('cart_id', $related_order, $default_related_order, 'class="form-control" id="cart_id"');
                                                                ?>
                                                            </div>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><?php echo $this->lang->line("Reason"); ?>
                                                                *</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                       value="<?php echo isset($xreview[0]['reason']) ? $xreview[0]['reason'] : ""; ?>"
                                                                       class="form-control"
                                                                       placeholder="<?php echo $this->lang->line("Example : Quick Delivery"); ?>"
                                                                       id="reason" name="reason">
                                                            </div>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><?php echo $this->lang->line("Review"); ?></label>
                                                            <textarea class="form-control" cols="30" rows="6"
                                                                      placeholder="<?php echo $this->lang->line("Write a few words"); ?>"
                                                                      id="review"
                                                                      name="review"><?php echo isset($xreview[0]['review']) ? $xreview[0]['review'] : ""; ?></textarea>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        <button type="submit" id="rate_now"
                                                                class="btn btn-dark"><?php echo $this->lang->line("Submit Review"); ?></button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab tab-nav-boxed tab-nav-outline tab-nav-center">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="show-all">
                                                <ul class="comments list-style-none">
                                                    <?php foreach ($review_list_data as $key => $value) {
                                                        $review_text = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $value["review"]);
                                                        $profile_pic = ($value['profile_pic'] != "") ? $value["profile_pic"] : base_url('assets/img/avatar/avatar-1.png');
                                                        $review_url = _link("ecommerce/review/" . $value["id"]);
                                                        $review_url = mec_add_get_param($review_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                                                        ?>
                                                        <li class="comment">
                                                            <div class="comment-body">
                                                                <figure class="comment-avatar">
                                                                    <img src="<?php echo $profile_pic; ?>"
                                                                         style="border-radius: 50%"
                                                                         alt="Commenter Avatar" width="90" height="90">
                                                                </figure>
                                                                <div class="comment-content" style="width: 100%;">
                                                                    <h4 class="comment-author">
                                                                        <a href="<?php echo $review_url; ?>"><?php echo $value["first_name"] . ' ' . $value["last_name"]; ?></a>
                                                                        <span class="comment-date"><?php echo date("d M,y H:i", strtotime($value['inserted_at'])); ?></span>
                                                                    </h4>
                                                                    <div class="ratings-container comment-rating">
                                                                        <div class="ratings-full">
                                                                                <span class="ratings"
                                                                                      style="width: <?php echo rating_calc($value['rating'], 1); ?>%;"></span>
                                                                            <span
                                                                                    class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                    </div>
                                                                    <p><strong><?php echo $value["reason"]; ?></strong>
                                                                    </p>
                                                                    <p><?php echo nl2br($review_text); ?></p>
                                                                    <div class="comment-action">
                                                                        <?php if ($this->user_id != '') { ?>
                                                                            <a href="#"
                                                                               data-id="#collapsereview<?php echo $value["id"]; ?>"
                                                                               class="collapse_link  btn btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize"
                                                                               role="button" aria-expanded="false"
                                                                               aria-controls="collapsereview<?php echo $value["id"]; ?>">
                                                                                <i class="w-icon-comment"></i><?php echo $this->lang->line("Reply"); ?>
                                                                            </a>
                                                                            <a href="#"
                                                                               data-id="<?php echo $value["id"]; ?>"
                                                                               class="btn btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize hide-review">
                                                                                <i class="w-icon-search-minus"></i><?php echo $this->lang->line("Hide"); ?>
                                                                            </a>
                                                                        <?php } ?>
                                                                        <?php if (!empty($value["image_path"])) { ?>
                                                                            <div class="review-image">
                                                                                <a href="#">
                                                                                    <figure>
                                                                                        <img src="<?php echo base_url($value["image_path"]); ?>"
                                                                                             width="60" height="60"
                                                                                             alt=""
                                                                                             data-zoom-image=""<?php echo base_url($value["image_path"]); ?>
                                                                                        " />
                                                                                    </figure>
                                                                                </a>
                                                                            </div>
                                                                        <?php }
                                                                        if ($value['review_reply'] == '') {
                                                                            echo '
                          <div class="pt-2" id="collapsereview' . $value["id"] . '" style="display: none;">
                            <textarea class="form-control review_reply" name="review_reply" style="height:50px !important;"></textarea>
                            <button class="btn btn-dark leave_review_comment no_radius" parent-id="' . $value['id'] . '"><i class="w-icon-reports"></i> ' . $this->lang->line("Reply") . '</button>              
                          </div>';
                                                                        }

                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>

                                                        <?php


                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($this->is_ecommerce_related_product_exist) : ?>
                    <?php if (!empty($related_product_lists)) : ?>
                        <section class="related-product-section">
                            <div class="title-link-wrapper mb-4">
                                <h4 class="title"><?php echo $n_eco_builder_config['product_single_items_related_title']; ?></h4>
                                <!--                        <a href="#" class="btn btn-dark btn-link btn-slide-right btn-icon-right">More-->
                                <!--                            Products<i class="w-icon-long-arrow-right"></i></a>-->
                            </div>
                            <div class="owl-carousel owl-theme row cols-lg-3 cols-md-4 cols-sm-3 cols-<?php echo $n_eco_builder_config['mobile_columns_div']; ?>"
                                 data-owl-options="{
                                        'nav': false,
                                        'dots': false,
                                        'margin': 20,
                                        'autoplay':  <?php echo $n_eco_builder_config['product_single_autoplay_items_related']; ?>,
                                        'autoplayTimeout':  <?php echo $n_eco_builder_config['product_single_autoplaytimeout_items_related']; ?>,
                                        'responsive': {
                                            '0': {
                                                'items': <?php echo $n_eco_builder_config['product_single_width_0_items_related']; ?>
                                            },
                                            '576': {
                                                'items':  <?php echo $n_eco_builder_config['product_single_width_576_items_related']; ?>
                                            },
                                            '768': {
                                                'items':  <?php echo $n_eco_builder_config['product_single_width_768_items_related']; ?>
                                            },
                                            '992': {
                                                'items':  <?php echo $n_eco_builder_config['product_single_width_992_items_related']; ?>
                                            }
                                        }
                                    }">
                                <?php foreach ($related_product_lists as $featured) : ?>
                                    <?php
                                    $imgSrcs = ($featured['thumbnail'] != '') ? base_url('upload/ecommerce/' . $featured['thumbnail']) : base_url('assets/img/products/product-1.jpg');
                                    if (isset($featured["woocommerce_product_id"]) && !is_null($featured["woocommerce_product_id"]) && $featured['thumbnail'] != '')
                                        $imgSrcs = $featured['thumbnail'];

                                    $product_url = _link("ecommerce/product/" . $featured['id']);
                                    $product_url = mec_add_get_param($product_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

                                    $display_featured_product_price = mec_display_price($featured['original_price'], $featured['sell_price'], ' ' . $currency_icon . ' ', '1', $currency_position, $decimal_point, $thousand_comma);
                                    $display_featured_product_discount = mec_display_price($featured['original_price'], $featured['sell_price'], $currency_icon, '4', $currency_position, $decimal_point, $thousand_comma);
                                    ?>
                                    <div class="product" data-cat="<?php echo $featured['category_id']; ?>">
                                        <figure class="product-media">
                                            <a href="<?php echo $product_url; ?>">
                                                <img src="<?php echo $imgSrcs; ?>"
                                                     alt="img-<?php echo $featured['product_name']; ?>"
                                                     width="300" height="338"/>
                                            </a>
                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-cart w-icon-cart add_to_cart"
                                                   data-product-id="<?php echo $featured['id']; ?>"
                                                   data-attributes="<?php echo $featured['attribute_ids']; ?>"
                                                   data-action="add"
                                                   title="<?php echo $this->lang->line('Add to Cart'); ?>"></a>
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <h4 class="product-name"><a
                                                        href="<?php echo $product_url; ?>"><?php echo $featured['product_name']; ?></a>
                                            </h4>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <!--                                    <a href="product-default.html" class="rating-reviews">(3 reviews)</a>-->
                                            </div>
                                            <div class="product-pa-wrapper">
                                                <div class="product-price"><?php echo $display_featured_product_price; ?></div>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </section>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Root element of PhotoSwipe. Must have class pswp -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
        PhotoSwipe keeps only 3 of them in the DOM to save memory.
        Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" aria-label="Close (Esc)"></button>
                <button class="pswp__button pswp__button--zoom" aria-label="Zoom in/out"></button>

                <div class="pswp__preloader">
                    <div class="loading-spin"></div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button--arrow--left" aria-label="Previous (arrow left)"></button>
            <button class="pswp__button--arrow--right" aria-label="Next (arrow right)"></button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<!-- End of PhotoSwipe -->

<?php
if ($n_eco_builder_config['addthis_show'] == 'true') {
    echo '<script type="text/javascript" src="' . $n_eco_builder_config['addthis_code'] . '"> </script>';
}

?>
<script>
    var counter = 0;
    var current_product_id = "<?php echo $current_product_id; ?>";
    var current_store_id = "<?php echo $current_store_id; ?>";
    var currency_icon = "<?php echo $currency_icon; ?>";
    var currency_position = "<?php echo $currency_position; ?>";
    var decimal_point = "<?php echo $decimal_point; ?>";
    var thousand_comma = "<?php echo $thousand_comma; ?>";
    var store_favicon = "<?php echo isset($social_analytics_codes['store_favicon']) ? $social_analytics_codes['store_favicon'] : '';?>";
    var store_name = "<?php echo isset($social_analytics_codes['store_name']) ? $social_analytics_codes['store_name'] : '';?>";
    var product_name = "<?php echo isset($product_data['product_name']) ? $product_data['product_name'] : '';?>";

    var ecommerce_related_product_exist = '<?php echo $this->is_ecommerce_related_product_exist;?>';

</script>
