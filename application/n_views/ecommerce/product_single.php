<script src="/n_assets/app-assets/vendors/js/extensions/swiper.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="/n_assets/js/photoswipe/photoswipe.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="/n_assets/js/photoswipe/photoswipe-ui-default.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<link rel="stylesheet" type="text/css"
      href="/n_assets/app-assets/vendors/css/extensions/swiper.min.css?ver=<?php echo $n_config['theme_version']; ?>">
<link rel="stylesheet" type="text/css"
      href="/n_assets/js/photoswipe/photoswipe.css?ver=<?php echo $n_config['theme_version']; ?>">
<link rel="stylesheet" type="text/css"
      href="/n_assets/js/photoswipe/default-skin/default-skin.css?ver=<?php echo $n_config['theme_version']; ?>">
<style>
    ul.swiper-wrapper li {
        list-style: none;
    }

    .gallery-top .swiper-slide a {
        display: flex;
    }

    .gallery-thumbs .swiper-slide {
        display: flex;
    }
</style>
<?php
include(FCPATH . 'application/n_views/default_ecommerce.php');
if (file_exists(FCPATH . 'application/n_eco_user/store_settings_' . $social_analytics_codes['id'] . '.php')) {
    include(FCPATH . 'application/n_eco_user/store_settings_' . $social_analytics_codes['id'] . '.php');
}

include(FCPATH . 'application/n_views/config.php');
?>
<?php
$js_store_id = isset($social_analytics_codes['store_id']) ? $social_analytics_codes['store_id'] : $social_analytics_codes['id'];
$subscriber_id = $this->session->userdata($product_data['store_id'] . "ecom_session_subscriber_id");
if ($subscriber_id == "") $subscriber_id = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";
$pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';

$currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
$currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";
$currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
$decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
$thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
$buy_button_title = isset($ecommerce_config['buy_button_title']) ? $ecommerce_config['buy_button_title'] : $this->lang->line("Buy Now");
$hide_add_to_cart = isset($ecommerce_config['hide_add_to_cart']) ? $ecommerce_config['hide_add_to_cart'] : "0";
$hide_buy_now = isset($ecommerce_config['hide_buy_now']) ? $ecommerce_config['hide_buy_now'] : "0";
$map_array = array();
$currency_left = $currency_right = "";
if ($currency_position == 'left') $currency_left = $currency_icon;
if ($currency_position == 'right') $currency_right = $currency_icon;
foreach ($attribute_price_map as $key => $value) {
    $x = $value["amount"] == 0 && $value["price_indicator"] == 'x' ? 'x' : '';
    $ammount_formatted = $currency_left . mec_number_format($value["amount"], $decimal_point, $thousand_comma) . $currency_right;
    $map_array[$value["attribute_id"]][$value["attribute_option_name"]] = $value["amount"] != 0 ? $value["price_indicator"] . $ammount_formatted : $x;
}

$product_link = base_url("ecommerce/product/" . $product_data['id']);
$product_link = mec_add_get_param($product_link, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

$current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
$cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
$current_cart_url = base_url("ecommerce/cart/" . $current_cart_id);
$current_cart_url = mec_add_get_param($current_cart_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

$current_cart_data = (isset($current_cart["cart_data"]) && is_array($current_cart["cart_data"])) ? $current_cart["cart_data"] : array();

$have_attributes = false;
$product_attributes = array_filter(explode(',', $product_data['attribute_ids']));
if (is_array($product_attributes) && !empty($product_attributes)) $have_attributes = true;

$quantity_in_cart = 0;
if (!$have_attributes) $quantity_in_cart = isset($current_cart_data[$product_data['id']]["quantity"]) ? $current_cart_data[$product_data['id']]["quantity"] : 0;
else if (isset($_GET['quantity'])) $quantity_in_cart = $_GET['quantity'];

$carousel = true;
if ($product_data['featured_images'] == "" && $product_data['thumbnail'] == "") $carousel = false;

if (empty($this->is_ecommerce_related_product_exist) and $this->is_ecommerce_related_product_exist != true) {
    $this->is_ecommerce_related_product_exist = false;
}
?>
<section class="app-ecommerce-details">
    <div class="card">
        <!-- Product Details starts -->
        <div class="card-body">
            <?php if ($this->ecommerce_review_comment_exist && $subscriber_id != "" && $this->user_id == '' && !empty($has_purchase_array)) : ?>
                <a id="rate_modal_button" href="" class="list-group-item w-100 text-center"
                   data-id="<?php echo isset($xreview[0]['id']) ? $xreview[0]['id'] : 0; ?>">
                    <?php echo $this->lang->line("Rate this item"); ?>
                    <?php if (isset($xreview[0]['rating'])) {
//                      $review_star_given = mec_display_rating_starts($xreview[0]['rating']);
//                      echo '<span class="float-right">'.$review_star_given.'</span>';
                    } ?>

                </a>
            <?php endif; ?>
            <div class="row my-2">

                <div class="col-12 col-md-5 align-items-center justify-content-center mb-2 mb-md-0">
                    <div class="align-items-center justify-content-center">
                        <?php $featured_images_array = ($product_data['featured_images'] != "") ? explode(',', $product_data['featured_images']) : array(); ?>
                        <?php if ($product_data['featured_images'] != "") { ?>
                            <div class="swiper-gallery swiper-container gallery-top">
                                <ul class="swiper-wrapper my-gallery">
                                    <?php
                                    $i = 0;
                                    foreach ($featured_images_array as $key => $value) {
                                        $imgSrc = base_url('upload/ecommerce/' . $value);

                                        ?>
                                        <li class="swiper-slide">
                                            <a title="click to zoom-in" href="<?php echo $imgSrc; ?>"
                                               data-size="<?php echo $n_config['recommend_photoswipe_resolution']; ?>">
                                                <img class="img-fluid" src="<?php echo $imgSrc; ?>"
                                                     alt="photo product <?php echo $i++; ?>">
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <!-- Add Arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper mt-25">
                                    <?php
                                    $i = 0;
                                    foreach ($featured_images_array as $key => $value) {
                                        $imgSrc = base_url('upload/ecommerce/' . $value);
                                        ?>
                                        <div class="swiper-slide">
                                            <img class="img-fluid" src="<?php echo $imgSrc; ?>"
                                                 alt="photo thumb product <?php echo $i++; ?>">
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                                <!-- Background of PhotoSwipe.
                                        It's a separate element, as animating opacity is faster than rgba(). -->
                                <div class="pswp__bg"></div>

                                <!-- Slides wrapper with overflow:hidden. -->
                                <div class="pswp__scroll-wrap">

                                    <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                                    <!-- don't modify these 3 pswp__item elements, data is added later on. -->
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

                                            <button class="pswp__button pswp__button--close"
                                                    title="Close (Esc)"></button>

                                            <button class="pswp__button pswp__button--share" title="Share"></button>

                                            <button class="pswp__button pswp__button--fs"
                                                    title="Toggle fullscreen"></button>

                                            <button class="pswp__button pswp__button--zoom"
                                                    title="Zoom in/out"></button>

                                            <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                            <!-- element will get class pswp__preloader--active when preloader is running -->
                                            <div class="pswp__preloader">
                                                <div class="pswp__preloader__icn">
                                                    <div class="pswp__preloader__cut">
                                                        <div class="pswp__preloader__donut"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                            <div class="pswp__share-tooltip"></div>
                                        </div>

                                        <button class="pswp__button pswp__button--arrow--left"
                                                title="Previous (arrow left)">
                                        </button>

                                        <button class="pswp__button pswp__button--arrow--right"
                                                title="Next (arrow right)">
                                        </button>

                                        <div class="pswp__caption">
                                            <div class="pswp__caption__center"></div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php include(APPPATH . "n_views/ecommerce/js_product_single.php"); ?>


                        <?php } else { ?>
                            <?php
                            $imgSrc = ($product_data['thumbnail'] != '') ? base_url('upload/ecommerce/' . $product_data['thumbnail']) : base_url('assets/img/products/product-1.jpg');
                            if (isset($product_data["woocommerce_product_id"]) && !is_null($product_data["woocommerce_product_id"]) && $product_data['thumbnail'] != '')
                                $imgSrc = $product_data['thumbnail'];
                            ?>
                            <img class="img-fluid d-block w-100" src="<?php echo $imgSrc; ?>">
                        <?php } ?>

                        <!-- gallery swiper ends -->
                    </div>
                </div>
                <div class="col-12 col-md-7 pl-md-1">
                    <h4><?php echo $product_data['product_name']; ?></h4>
                    <span class="card-text item-company"><?php echo $this->lang->line("Category"); ?> <a href="#"
                                                                                                         class="company-name"><?php echo isset($category_list[$product_data['category_id']]) ? $category_list[$product_data['category_id']] : $this->lang->line("Uncategorised"); ?></a></span>
                    <div class="ecommerce-details-price d-flex flex-wrap mt-1">
                        <h4 class="item-price mr-1"
                            id="calculated_price_basedon_attribute"><?php echo mec_display_price($product_data['original_price'], $product_data['sell_price'], $currency_icon, '1', $currency_position, $decimal_point, $thousand_comma); ?></h4>

                        <?php
                        if ($this->ecommerce_review_comment_exist && isset($review_data[0])) {
                            $rating = mec_average_rating($review_data[0]['total_point'], $review_data[0]['total_review']);
                            function nviews_display_rating_starts($rating_point = 0, $class = '')
                            {
                                if ($rating_point < 1) return "";
                                $ret = "";
                                $loop = 0;
                                for ($i = 1; $i <= $rating_point; $i++) {
                                    $loop++;
                                    $ret .= '<li class="ratings-list-item"><i class="bx bxs-star filled-star"></i></li>';
                                }
                                $start_bank = 5 - $loop;
                                if ($start_bank > 0)
                                    for ($i = 1; $i <= $start_bank; $i++) {
                                        $ret .= '<li class="ratings-list-item"><i class="bx bx-star unfilled-star"></i></li>';
                                    }
                                return $ret;
                            }

                            $review_star = nviews_display_rating_starts($rating, 'text-small');
                            if (!empty($rating)) {
                                echo '<ul class="unstyled-list list-inline pl-1 border-left">' . $review_star . '</ul>';
                            }
                        }
                        ?>

                    </div>
                    <?php if ($product_data['stock_display'] == '1') : ?>
                        <p class="card-text align-right">
                            <?php
                            if ($product_data['stock_item'] > 0) {
                                echo $this->lang->line("Available");
                                echo ' - <span class="text-success">' . $this->lang->line("Stock") . ' ' . $product_data['stock_item'] . '</span>';
                            } else {
                                echo $this->lang->line("Not Available");
                            }; ?>
                        </p>
                    <?php endif; ?>


                    <p class="card-text">

                    </p>


                    <?php if ($have_attributes): ?>
                        <hr/>
                        <div class="product-color-options">
                            <div id="details">

                                <?php if ($have_attributes)
                                { ?>
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
                            <div class="custom-control custom-checkbox d-block">
                              <input type="checkbox" data-attr="' . $value["id"] . '" name="' . $name . '"   value="' . $value2 . '" class="custom-control-input options" id="' . $temp_id . '" data-optional="' . $value["optional"] . '" ' . $selected_attr . '>
                              <label class="custom-control-label" for="' . $temp_id . '">' . $value2 . ' <b class="text-dark text-small">' . $tempu . '</b></label>
                            </div>';
                                                } else {

                                                    $options_print .= '                                               
                                               <fieldset>
                                                        <div class="radio">
                                                            <input type="radio" class="options"  data-attr="' . $value["id"] . '"  name="' . $name . '"  id="' . $value2 . '"  value="' . $value2 . '" id="radio1" data-optional="' . $value["optional"] . '" ' . $selected_attr . '>
                                                            <label for="' . $value2 . '">' . $value2 . ' <span class="text-dark ml-1">' . $tempu . '</span></label>
                                                        </div>
                                                    </fieldset>';
                                                }

                                            }

                                            echo '
                          <div class="card shadow-none mb-0 mt-0 pt-0 pb-0">
                            <div class="card-header border-0 pt-0 pb-0 pl-1">
                              <h6>' . $value["attribute_name"] . $star . '</h6>
                            </div>
                            <div class="card-body pt-0 pb-0 pl-1 ">
                             ' . $options_print . '   
                            </div>
                          </div>';
                                        }
                                    }
                                    ?>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <hr/>
                    <?php
                    if ($product_data['sales_count'] > 0) {
                        echo '<div class="badge badge-light-info d-inline-flex align-items-center mr-1 mb-1"><i class="bx bx-shopping-bag font-size-small mr-25"></i>' . $this->lang->line("Sales") . ' ' . $product_data['sales_count'] . '</div>';
                    }
                    ?>
                    <div class="pt-1">
                        <?php

                        //
                        //

                        $stock_item = $product_data['stock_item'];
                        $stock_prevent_purchase = $product_data['stock_prevent_purchase'];

                        if ($stock_prevent_purchase == '1' and $stock_item == '0') {
                            $hide_add_to_cart = 1;
                            $hide_buy_now = 1;

                            echo '<div class="alert alert-warning mb-2" role="alert">' . $this->lang->line('sorry, this item is out of stock. we are not taking any order right now.') . '</div>';
                        }

                        if ($hide_add_to_cart == '0'): ?>
                            <article class="article article-style-c width-55-per mx-auto" id="cart_actions">
                                <div class="article-details p-0">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <button class="btn btn-dark add_to_cart"
                                                        data-product-id="<?php echo $product_data['id']; ?>"
                                                        data-attributes="<?php echo $product_data['attribute_ids']; ?>"
                                                        data-action="remove" type="button" style="min-width: 20px;"
                                                        data-toggle="tooltip"
                                                        title="<?php echo $this->lang->line('Remove 1 from Cart'); ?>">
                                                    <i class="bx bx-minus"></i></button>
                                            </div>
                                            <input type="text" class="form-control text-center bg-white"
                                                   data-toggle="tooltip"
                                                   title="<?php echo $this->lang->line('Currently added to cart'); ?>"
                                                   id="item_count" readonly value="<?php echo $quantity_in_cart; ?>">
                                            <div class="input-group-append">
                                                <button style="min-width: 20px;"
                                                        class="btn btn-primary add_to_cart no_radius"
                                                        data-product-id="<?php echo $product_data['id']; ?>"
                                                        data-attributes="<?php echo $product_data['attribute_ids']; ?>"
                                                        data-action="add" type="button" data-toggle="tooltip"
                                                        title="<?php echo $this->lang->line('Add 1 to Cart'); ?>"><i
                                                            class="bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endif; ?>
                        <?php if ($hide_buy_now == '0'): ?>
                            <a href="" id="single_buy_now"
                               class="mt-1 width-55-per btn btn-primary add_to_cart buy_now btn-block <?php echo ($product_data['attribute_ids'] == '') ? '' : 'd-none'; ?> mx-auto"
                               data-attributes="<?php echo $product_data['attribute_ids']; ?>"
                               data-product-id="<?php echo $product_data['id']; ?>" data-action='add'><i
                                        class="bx bx-credit-card-alt"></i> <?php echo $this->lang->line($buy_button_title); ?>
                            </a>
                        <?php endif; ?>


                        <?php if ($n_eco_config['addthis_show'] == 'true') { ?>
                            <div class="<?php echo $n_eco_config['addthis_class']; ?> mt-2"></div>
                        <?php } ?>


                    </div>
                </div>
            </div>

            <!-- Product Details ends -->

            <div class="row pb-3">


                <div class="col-12 col-sm-12">

                    <div class="hero p-2" style="border-radius: 0 0 3px 3px;">
                        <div class="hero-inner">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">

                                <?php if (!empty($product_data['product_description'])): ?>
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="description-tab2" data-toggle="tab"
                                           href="#description" role="tab" aria-controls="description"
                                           aria-selected="false"><?php echo $this->lang->line("Details"); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (!empty($product_data['purchase_note'])): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo (!$have_attributes && empty($product_data['product_description']) && !$this->ecommerce_review_comment_exist) ? 'active show' : ''; ?>"
                                           id="purchase_note-tab2" data-toggle="tab" href="#purchase_note" role="tab"
                                           aria-controls="purchase_note"
                                           aria-selected="false"><?php echo $this->lang->line("Note"); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($this->ecommerce_review_comment_exist): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo (!$have_attributes && empty($product_data['product_description'])) ? 'active show' : ''; ?>"
                                           id="reviews-tab2" data-toggle="tab" href="#reviews" role="tab"
                                           aria-controls="reviews"
                                           aria-selected="false"><?php echo $this->lang->line("Reviews"); ?></a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a class="nav-link" id="comments_tab-tab2" data-toggle="tab" href="#comments_tab"
                                       role="tab" aria-controls="comments_tab"
                                       aria-selected="false"><?php echo $this->lang->line("Comments"); ?></a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered mb-2" id="myTab3Content">

                                <?php if (!empty($product_data['product_description'])): ?>
                                    <div class="tab-pane fade p-2 pb-0 active show" id="description" role="tabpanel"
                                         aria-labelledby="description-tab2">
                                        <?php echo str_replace('stzle', 'style', $product_data['product_description']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->ecommerce_review_comment_exist): ?>
                                    <div class="tab-pane fade pb-0 <?php echo (!$have_attributes && empty($product_data['product_description'])) ? 'active show' : ''; ?>"
                                         id="reviews" role="tabpanel" aria-labelledby="reviews-tab2">
                                        <div class="media-list media-bordered">
                                            <?php
                                            if (empty($review_list_data))
                                                echo '
                <div class="card shadow-none m-0" id="nodata" style="">
                <div class="card-body pb-2">
                  <div class="empty-state p-0">
                    <h6 class="mt-0">' . $this->lang->line("We could not find any review.") . '</h6>
                  </div>
                </div>
              </div>';
                                            else {
                                                foreach ($review_list_data as $key => $value) {

                                                    $profile_pic = ($value['profile_pic'] != "") ? "<img class='rounded-circle mr-3' style='height:50px;width:50px;' src='" . $value["profile_pic"] . "'>" : "<img class='rounded-circle mr-3' style='height:50px;width:50px;' src='" . base_url('assets/img/avatar/avatar-1.png') . "'>";
                                                    $image_path = ($value["image_path"] != "") ? "<img class='rounded-circle' style='height:50px;width:50px;' src='" . base_url($value["image_path"]) . "'>" : $profile_pic;
                                                    $review_url = base_url("ecommerce/review/" . $value["id"]);
                                                    $review_url = mec_add_get_param($review_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                                                    $reply_button = $hide_button = $reply_block = $review_reply_show = '';
                                                    if ($this->user_id != '') {
                                                        if ($value['review_reply'] == '') $reply_button = ' <a class="collpase_link d-inline float-right" data-toggle="collapse" href="#collapsereview' . $value["id"] . '" role="button" aria-expanded="false" aria-controls="collapsereview' . $value["id"] . '"><i class="bx bx-comment"></i> ' . $this->lang->line("Reply") . '</a>';
                                                        $hide_button = '<a data-id="' . $value["id"] . '" class="d-inline float-right pr-3 hide-review text-muted" href="#"><i class="bx bxs-hide"></i> ' . $this->lang->line("Hide") . '</a>';
                                                        if ($value['review_reply'] == '') $reply_block = '
                      <div class="input-group collapse pt-2" id="collapsereview' . $value["id"] . '">
                        <textarea class="form-control review_reply" name="review_reply" style="height:50px !important;"></textarea>
                        <button class="btn btn-primary leave_review_comment no_radius" parent-id="' . $value['id'] . '"><i class="bx bx-reply"></i> ' . $this->lang->line("Reply") . '</button>              
                      </div>';
                                                    }
                                                    $review_reply_text = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $value["review_reply"]); // find and replace links with ancor tag
                                                    if ($value['review_reply'] != '') {
                                                        $store_favicon_src = isset($social_analytics_codes['store_favicon']) ? base_url("upload/ecommerce/" . $social_analytics_codes['store_favicon']) : base_url('assets/img/avatar/avatar-1.png');
                                                        $storeName = isset($social_analytics_codes['store_name']) ? $social_analytics_codes['store_name'] : $this->lang->line("Admin");
                                                        $review_reply_show = '
                      <div class="media mt-3 w-100">
                            <img class="rounded-circle mr-3" style="height:50px;width:50px;" src="' . $store_favicon_src . '">
                            <div class="media-body">
                              <h6 class="mt-1 mb-0">' . $storeName . ' <i class="bx bx-user-circle text-primary"></i></h6>
                              <p style="font-size:11px;" class="m-0 text-muted d-inline">' . date("d M,y H:i", strtotime($value['replied_at'])) . '                    
                              <p class="mb-0">' . nl2br($review_reply_text) . '</p>
                            </div>
                        </div>';
                                                    }
                                                    $review_star_single = nviews_display_rating_starts($value['rating'], 'text-medium');
                                                    $review_text = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $value["review"]); // find and replace links with ancor tag
                                                    echo '
                    
                    <div class="media">
              <a class="align-self-center" href="javascript:void(0);">
                 ' . $image_path . '
              </a>
              <div class="media-body">
                <h4 class="media-heading mb-0 pb-0">' . $value["first_name"] . ' ' . $value["last_name"] . '<a class="float-right font-small-3 " target="_BLANK" href="' . $review_url . '">' . date("d M,y H:i", strtotime($value['inserted_at'])) . '</a></h4>
               <ul class="unstyled-list list-inline mt-0">' . $review_star_single . '</ul>
                <p class="mb-0 mt-0 text-justify"><b>' . $value["reason"] . '</b> : ' . nl2br($review_text) . '</p> 
              </div>
            </div>
            
            
                    <div class="media" id="review-' . $value["id"] . '">
                     
                      <div class="media-body">
                        <h6 class="mt-1 mb-0 w-100"></h6>
                        <p style="font-size:11px;" class="m-0 d-inline"></p>
                        ' . $reply_button . $hide_button . '
                        ' . $reply_block . $review_reply_show . '
                      </div>                        
                    </div>';
                                                }

                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($product_data['purchase_note'])): ?>
                                    <div class="tab-pane fade p-2 pb-0 <?php echo (!$have_attributes && empty($product_data['product_description']) && !$this->ecommerce_review_comment_exist) ? 'active show' : ''; ?>"
                                         id="purchase_note" role="tabpanel" aria-labelledby="purchase_note-tab2">
                                        <?php echo str_replace('stzle', 'style', $product_data['purchase_note']); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="tab-pane fade p-2 pb-0" id="comments_tab" role="tabpanel"
                                     aria-labelledby="comments_tab-tab2">
                                    <div class="col-12 always_padded">

                                        <?php if ($this->is_ecommerce_related_product_exist) : ?>

                                            <?php if (!empty($upsell_product_lists)) : ?>
                                                <?php
                                                $upsell_imgSrcs = ($upsell_product_lists[0]['thumbnail'] != '') ? base_url('upload/ecommerce/' . $upsell_product_lists[0]['thumbnail']) : base_url('assets/img/products/product-1.jpg');
                                                if (isset($upsell_product_lists[0]["woocommerce_product_id"]) && !is_null($upsell_product_lists[0]["woocommerce_product_id"]) && $upsell_product_lists[0]['thumbnail'] != '')
                                                    $upsell_imgSrcs = $upsell_product_lists[0]['thumbnail'];

                                                $upsell_product_url = base_url("ecommerce/product/" . $upsell_product_lists[0]['id']);
                                                $upsell_product_url = mec_add_get_param($upsell_product_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

                                                $downsell_product_url = base_url("ecommerce/product/" . $downsell_product_id);
                                                $downsell_product_url = mec_add_get_param($downsell_product_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

                                                $display_upsell_product_lists_product_price = mec_display_price($upsell_product_lists[0]['original_price'], $upsell_product_lists[0]['sell_price'], $currency_icon, '1', $currency_position, $decimal_point, $thousand_comma);
                                                $display_upsell_product_lists_product_discount = mec_display_price($upsell_product_lists[0]['original_price'], $upsell_product_lists[0]['sell_price'], $currency_icon, '4', $currency_position, $decimal_point, $thousand_comma);

                                                ?>
                                                <div class="row section" id="upsell_product" style="display: none;">
                                                    <div class="col-12 p-0">
                                                        <div class="section-title mt-3 mb-3"><?php echo $this->lang->line("You May Also Like") ?></div>
                                                    </div>
                                                    <div class="col-12 col-md-3 p-0">
                                                        <article class="article article-style-c mb-3 mt-1"
                                                                 style="width:250px;">
                                                            <div class="article-header">
                                                                <a href="<?php echo $upsell_product_url; ?>">
                                                                    <div class="article-image"
                                                                         data-background="<?php echo $upsell_imgSrcs; ?> "
                                                                         style="background-image: url('<?php echo $upsell_imgSrcs; ?>');"></div>
                                                                </a>
                                                                <?php echo $display_upsell_product_lists_product_discount; ?>

                                                            </div>
                                                            <div class="article-details pt-0 pb-0 pl-1 pr-1">
                                                                <div class="article-category mt-1 mb-0"><?php echo $display_upsell_product_lists_product_price; ?></div>
                                                                <div class="article-title mb-2">
                                                                    <a href="<?php echo $upsell_product_url; ?>"
                                                                       class="text-dark text-small"><?php echo $upsell_product_lists[0]['product_name']; ?></a>
                                                                </div>

                                                                <p class="d-none"><?php echo strip_tags($upsell_product_lists[0]['product_description']); ?></p>
                                                                <p class="d-none"><?php echo isset($category_list[$upsell_product_lists[0]['category_id']]) ? $category_list[$upsell_product_lists[0]['category_id']] : ''; ?></p>

                                                                <div>
                                                                    <?php if ($downsell_product_id != 0): ?>
                                                                        <a href="<?php echo $downsell_product_url; ?>"
                                                                           class="btn btn-outline-primary"
                                                                           data-toggle="tooltip"
                                                                           data-title="<?php echo $this->lang->line("Cancel"); ?>"><i
                                                                                    class="bx bx-time"></i></a>
                                                                    <?php else : ?>
                                                                        <a href="#"
                                                                           class="btn btn-outline-secondary disabled"
                                                                           data-toggle="tooltip"
                                                                           data-title="<?php echo $this->lang->line("Cancel"); ?>"><i
                                                                                    class="bx bx-time"></i></a>
                                                                    <?php endif; ?>
                                                                    <a href="<?php echo $upsell_product_url; ?>"
                                                                       class="btn btn-primary float-right"
                                                                       data-toggle="tooltip"
                                                                       data-title="<?php echo $this->lang->line("Continue"); ?>"><i
                                                                                class="bx bx-right-arrow-circle"></i></a>
                                                                </div>
                                                                &nbsp;
                                                            </div>
                                                        </article>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php
                                        if ($this->ecommerce_review_comment_exist):

                                            $js_user_id = isset($social_analytics_codes['user_id']) ? $social_analytics_codes['user_id'] : $social_analytics_codes['user_id'];
                                            $subscriberId = $this->session->userdata($js_store_id . "ecom_session_subscriber_id");
                                            if ($subscriberId == "") $subscriberId = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";
                                            if ($subscriberId == '') $subscriberId = $this->uri->segment(4);
                                            ?>
                                            <div class="card mb-0 shadow-none">
                                                <div class="card-header p-0 pt-3 pb-3">
                                                    <h4>
                                                        <i class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Leave a comment"); ?>
                                                    </h4>
                                                </div>
                                                <div class="card-body p-0">
                                                    <textarea id="new_comment" class="form-control comment_reply"
                                                              placeholder="<?php echo $this->lang->line('Write comment here'); ?>"></textarea>
                                                    <button class="btn btn-primary leave_comment mt-2" parent-id=''
                                                            id="leave_comment"><i
                                                                class="bx bx-comment"></i> <?php echo $this->lang->line("Comment"); ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card mt-2 mb-2 shadow-none" id="comment_section">
                                                <div class="card-header p-0 pt-3 pb-3">
                                                    <h4>
                                                        <i class="bx bx-comment"></i> <?php echo $this->lang->line("Comments"); ?>
                                                    </h4>
                                                </div>
                                                <div class="card-body p-0">

                                                    <div id="load_data"></div>

                                                    <div class="text-center" id="waiting"
                                                         style="width: 100%;margin: 30px 0;">
                                                        <i class="bx bx-loader-alt bx-spin blue"
                                                           style="font-size:60px;"></i>
                                                    </div>

                                                    <div class="card shadow-none m-0" id="nodata" style="display: none">
                                                        <div class="card-body">
                                                            <div class="empty-state p-0">
                                                                <h6 class="mt-0"><?php echo $this->lang->line("We could not find any comment.") ?></h6>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-outline-primary m-3 mb-4"
                                                            style="display: none;" id="load_more" data-limit="10"
                                                            data-start="0"><i
                                                                class="bx bx-book-reader"></i> <?php echo $this->lang->line("Load More"); ?>
                                                    </button>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>

                </div>


            </div>

        </div>
    </div>
</section>

<?php if ($this->is_ecommerce_related_product_exist) : ?>
    <?php if (!empty($related_product_lists)) : ?>
        <div class="row mt-2 section">
            <div class="col-12 p-0">
                <h4 class="card-title mt-3 mb-1"><?php echo $this->lang->line("Related Items") ?></h4>
            </div>
            <div class="col-12 p-0 mb-3">
                <div class="owl-carousel owl-theme" id="featured-products-carousel">
                    <?php foreach ($related_product_lists as $featured) : ?>
                        <?php
                        $imgSrcs = ($featured['thumbnail'] != '') ? base_url('upload/ecommerce/' . $featured['thumbnail']) : base_url('assets/img/products/product-1.jpg');
                        if (isset($featured["woocommerce_product_id"]) && !is_null($featured["woocommerce_product_id"]) && $featured['thumbnail'] != '')
                            $imgSrcs = $featured['thumbnail'];

                        $product_url = base_url("ecommerce/product/" . $featured['id']);
                        $product_url = mec_add_get_param($product_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

                        $display_featured_product_price = mec_display_price($featured['original_price'], $featured['sell_price'], $currency_icon, '1', $currency_position, $decimal_point, $thousand_comma);
                        $display_featured_product_discount = mec_display_price($featured['original_price'], $featured['sell_price'], $currency_icon, '4', $currency_position, $decimal_point, $thousand_comma);
                        ?>
                        <div class="card ecommerce-card product-single p-0 shadow-none"
                             data-cat="<?php echo $featured['category_id']; ?>">
                            <div class="item-img text-center">
                                <a href="<?php echo $product_url; ?>">
                                    <img
                                            class="img-fluid card-img-top"
                                            src="<?php echo $imgSrcs; ?>"
                                            alt="img-<?php echo $featured['product_name']; ?>"
                                    />
                                </a>
                            </div>
                            <div class="card-body">
                                <?php echo $display_featured_product_discount; ?>
                                <div class="item-wrapper">
                                    <div class="item-cost">
                                        <h6 class="item-price"><?php echo $display_featured_product_price; ?></h6>
                                    </div>
                                </div>
                                <h6 class="item-name font-medium-2">
                                    <a class="text-body"
                                       href="<?php echo $product_url; ?>"><?php echo $featured['product_name']; ?></a>
                                </h6>
                                <p class="card-text item-description">
                                    <?php
                                    echo strip_tags($featured['product_description']);
                                    if (empty($featured['product_description'])) echo "&nbsp;";
                                    ?>
                                </p>


                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="sticky-height"></div>


<?php include(APPPATH . "n_views/ecommerce/cart_js.php"); ?>
<?php include(APPPATH . "n_views/ecommerce/cart_style.php"); ?>
<?php include(APPPATH . "n_views/ecommerce/common_style.php"); ?>


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
    var ecommerce_review_comment_exist = '<?php echo $this->ecommerce_review_comment_exist;?>';
    var ecommerce_related_product_exist = '<?php echo $this->is_ecommerce_related_product_exist;?>';

    $(document).ready(function () {
        if (ecommerce_review_comment_exist == '1') {
            setTimeout(function () {
                var start = $("#load_more").attr("data-start");
                load_data(start, false, false, "");
            }, 1000);

            $(document).on('click', '#load_more', function (e) {
                var start = $("#load_more").attr("data-start");
                load_data(start, false, true, "");
            });

            $(document).on('click', '#rate_modal_button', function (e) {
                e.preventDefault();
                $("#ReviewModal").modal();
            });

            if (ecommerce_related_product_exist) {
                $("#featured-products-carousel").owlCarousel({
                    items: 3,
                    margin: 10,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    loop: false,
                    responsive: {
                        0: {
                            items: 3
                        },
                        768: {
                            items: 5
                        },
                        1200: {
                            items: 6
                        }
                    }
                });
            }

        }
    });
</script>

<?php include(APPPATH . "n_views/ecommerce/attribute_value.php"); ?>
<?php if ($this->ecommerce_review_comment_exist) include(APPPATH . "n_views/ecommerce/comment_js.php"); ?>

<style type="text/css">
    .article-title a {
        font-size: 10px !important;
        font-weight: 500 !important;
    }

    .article-category {
        font-size: 9px;
    }

    .article .article-details, .article .article-details a {
        line-height: 12px !important;
    }

    .article.article-style-c .article-header {
        height: 160px !important;
    }

    #upsell_product .article {
        width: 250px !important
    }

    .custom-control.custom-checkbox {
        margin-bottom: 10px;
    }

    .custom-control-label {
        line-height: 2rem;
        padding-left: 20px
    }

    .custom-control-label::before, .custom-control-label::after {
        height: 1.5rem;
        width: 1.5rem;
    }

    .custom-switch {
        margin-bottom: 10px;
    }

    .media-body h6 {
        font-weight: 700;
        font-size: 17px;
    }

    @media (max-width: 978px) {
        .sticky-height {
            height: 35px !important;
        }

        #cart_actions {
            border-radius: 0;
            z-index: 99;
            bottom: 78px;
            left: 0;
            width: 100%;
            background: #fff;
        }

        .col-12:not(.always_padded) {
            padding: 0;
        }

        .remove-margin {
            margin: 0 !important;
        }
    }

    @media (min-width: 768px) {
        .margin_md {
            margin-top: 10px;
        }
    }

    .hero p {
        font-size: 14px;
        line-height: 25px;
    }

    .text-medium {
        font-size: 12px !important;
    }
</style>

<?php if ($this->ecommerce_review_comment_exist) : ?>
    <div class="modal fade" id="ReviewModal" tabindex="-1" role="dialog" aria-labelledby="ReviewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ReviewModalLabel"><i
                                class="bx bx-star"></i> <?php echo $this->lang->line("Rate Item"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="bx bx-chevron-left"></i></span>
                    </button>
                </div>
                <div class="modal-body text-justify" id="ReviewModalBody">
                    <input type="hidden" id="insert_id" name="insert_id"
                           value="<?php echo isset($xreview[0]['id']) ? $xreview[0]['id'] : ""; ?>">
                    <div class="form-group">
                        <label for=""><?php echo $this->lang->line("Reason"); ?>*</label>
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
                        <label for=""><?php echo $this->lang->line("Rating"); ?>*</label>
                        <div class="selectgroup selectgroup-pills">
                            <?php
                            $select_rating = isset($xreview[0]['rating']) ? $xreview[0]['rating'] : 5;
                            for ($i = 1; $i <= 5; $i++) {
                                $checked = ($select_rating == $i) ? 'checked' : '';
                                echo '
                      <label class="selectgroup-item">
                        <input type="radio" name="rating" value="' . $i . '" class="selectgroup-input" ' . $checked . '>
                        <span class="selectgroup-button border">' . $i . ' <i class="bx bx-star orange"></i> </span>
                      </label>';
                            } ?>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo $this->lang->line("Review"); ?></label>
                        <div class="input-group">
                            <textarea class="form-control" style="height: 200px !important"
                                      placeholder="<?php echo $this->lang->line("Write a few words"); ?>" id="review"
                                      name="review"><?php echo isset($xreview[0]['review']) ? $xreview[0]['review'] : ""; ?></textarea>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo $this->lang->line("Related Order"); ?> *</label>
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

                    <div class="form-group mt-2">
                        <a href="" id="rate_now" class="btn btn-primary btn-block" tabindex="4">
                            <?php echo $this->lang->line("Submit Review"); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
if ($n_eco_config['addthis_show'] == 'true') {
    echo $n_eco_config['addthis_code'];
}
?>

<?php

if (file_exists(APPPATH . '/n_eco_user/before_body_store_id_' . $js_store_id . '.php')) {
    include(APPPATH . '/n_eco_user/before_body_store_id_' . $js_store_id . '.php');
}
?>
