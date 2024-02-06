<style>
    .sidebar .show {
        background: #fff;
    }

    .sidebar .show .card {
        box-shadow: none;
        margin-top: 80px !important;
    }

    html .body-content-overlay.show {
        visibility: visible;
        transition: all .3s ease;
        opacity: 1;
        background-color: rgba(34, 41, 47, .2);
        border-radius: .1785rem;

    }

    html .body-content-overlay {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        display: block;
        z-index: 4;
        visibility: hidden;
        opacity: 0;
        transition: all .3s ease;
    }
</style>
<?php
$currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
$currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";
$currency_position = isset($ecommerce_config['currency_position']) ? $ecommerce_config['currency_position'] : "left";
$decimal_point = isset($ecommerce_config['decimal_point']) ? $ecommerce_config['decimal_point'] : 0;
$thousand_comma = isset($ecommerce_config['thousand_comma']) ? $ecommerce_config['thousand_comma'] : '0';
$buy_button_title = isset($ecommerce_config['buy_button_title']) ? $ecommerce_config['buy_button_title'] : $this->lang->line("Buy Now");
$is_category_wise_product_view = isset($ecommerce_config['is_category_wise_product_view']) ? $ecommerce_config['is_category_wise_product_view'] : "0";
$product_listing = isset($ecommerce_config['product_listing']) ? $ecommerce_config['product_listing'] : "list";
$hide_add_to_cart = isset($ecommerce_config['hide_add_to_cart']) ? $ecommerce_config['hide_add_to_cart'] : "0";
$hide_buy_now = isset($ecommerce_config['hide_buy_now']) ? $ecommerce_config['hide_buy_now'] : "0";

$currency_left = $currency_right = "";
if ($currency_position == 'left') $currency_left = $currency_icon;
if ($currency_position == 'right') $currency_right = $currency_icon;

$subscriber_id = $this->session->userdata($store_data['id'] . "ecom_session_subscriber_id");
if ($subscriber_id == "") $subscriber_id = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";
$pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';

$form_action = base_url('ecommerce/store/' . $store_data['store_unique_id']);
$form_action = mec_add_get_param($form_action, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));

$current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
$cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
$current_cart_url = base_url("ecommerce/cart/" . $current_cart_id);
$current_cart_url = mec_add_get_param($current_cart_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
$url_cat = isset($_GET["category"]) ? $_GET["category"] : "";

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

$featured_product_lists = array();
foreach ($product_list as $feature_product) {

    if ($feature_product['is_featured'] == '0') continue;

    array_push($featured_product_lists, $feature_product);
}

if (empty($this->is_ecommerce_related_product_exist) and $this->is_ecommerce_related_product_exist != true) {
    $this->is_ecommerce_related_product_exist = false;
}

?>
<section id="ecommerce-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="ecommerce-header-items">
                <div class="result-toggler">
                    <button class="navbar-toggler shop-sidebar-toggler" type="button" data-toggle="collapse">
                        <span class="navbar-toggler-icon d-block d-lg-none"><i class="bx bx-menu"></i></span>
                    </button>
                    <!--                    <div class="search-results">16285 results found</div>-->
                </div>
                <div class="view-options d-flex">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn">
                            <input type="radio" name="radio_options" id="radio_option1" checked/>
                            <i class="bx bxs-grid-alt font-medium-3"></i>
                        </label>
                        <label class="btn btn-icon btn-outline-primary view-btn list-view-btn">
                            <input type="radio" name="radio_options" id="radio_option2"/>
                            <i class="bx bx-list-ul font-medium-3"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="sidebar-detached sidebar-left mt-0">
    <div class="sidebar"><!-- Ecommerce Sidebar Starts -->
        <div class="sidebar-shop">
            <div class="card">
                <div class="card-header">
                    <div class="row" style="width: 100%;">
                        <div class="col-11">
                            <h6 class="filter-heading d-lg-block"><?php echo $this->lang->line("Category"); ?></h6>
                        </div>
                        <div class="col-1 p-0 text-right">
                            <a class="pr-0 mt-0 shop-sidebar-toggler"><i
                                        class="bx bx-x font-medium-4 primary toggle-icon"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Price Filter starts -->
                    <div class="multi-range-price">
                        <?php
                        $active_class = $url_cat == '' ? 'border border-primary bg-white' : 'border bg-white';

                        echo '<div class="slide "><a class="pointer cat_nav nav-link list-left pt-1 pb-1 ' . $active_class . ' d-flex"  href="" data-val="">
                <div class="list-icon mr-1">
                  <div class="avatar bg-rgba-primary m-0">
                    <div class="avatar-content">
                      <img class="rounded-circle d-block" style="width:40px;height:40px;" src="' . base_url('assets/img/icon/shop.png') . '">
                    </div>
                  </div>
                </div>
                <div class="list-content font-medium-1">
                  ' . $this->lang->line("All Items") . '
                </div>
              </a></div>';

                        unset($category_list['']);

                        foreach ($category_list_raw as $key => $value) {

                            $url = $value['thumbnail'] == '' ? base_url('assets/img/icon/rocket.png') : base_url("upload/ecommerce/") . $value["thumbnail"];
                            $active_class2 = ($value['id'] == $url_cat) ? 'border border-primary bg-white' : 'border bg-white';
                            echo '<div class="slide "><a class="pointer cat_nav nav-link list-left pt-1 pb-1 ' . $active_class2 . ' d-flex"  href="" data-val="' . $value['id'] . '">
                <div class="list-icon mr-1">
                  <div class="avatar bg-rgba-primary m-0">
                    <div class="avatar-content">
                      <img class="rounded-circle d-block" style="width:40px;height:40px;" src="' . $url . '">
                    </div>
                  </div>
                </div>
                <div class="list-content font-medium-1">
                  ' . $value["category_name"] . '
                </div>
              </a></div>';

                            //echo '<div class="slide text-center"><a class="pointer cat_nav nav-link '.$active_class2.'" href="" ><img class="rounded-circle mx-auto d-block" style="width:40px;height:40px;" src="'.$url.'"></a></div>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (empty($product_list)) { ?>
    <div class="mt-1 pl-lg-2 pl-md-2" style="display: grid; column-gap: 2rem;" id="nodata">
        <div class="card ecommerce-card text-center">
            <div class="card-body">
                <div class="empty-state">
                    <img class="img-fluid" style="height: 200px"
                         src="<?php echo base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg'); ?>"
                         alt="image">
                    <h2 class="mt-0"><?php echo $this->lang->line("We could not find any item."); ?></h2>
                    <?php if ($_POST) { ?>
                        <a href="<?php echo $_SERVER['QUERY_STRING'] ? current_url() . '?' . $_SERVER['QUERY_STRING'] : current_url(); ?>"
                           class="btn btn-outline-primary mt-4"><i
                                    class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line("Search Again"); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
} ?>
<div class="mt-1 pl-lg-2 pl-md-2 d-none" style="display: grid; column-gap: 2rem;" id="nodata_search">
    <div class="card ecommerce-card text-center">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-fluid" style="height: 200px"
                     src="<?php echo base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg'); ?>" alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("We could not find any item."); ?></h2>
                <?php if ($_POST) { ?>
                    <a href="<?php echo $_SERVER['QUERY_STRING'] ? current_url() . '?' . $_SERVER['QUERY_STRING'] : current_url(); ?>"
                       class="btn btn-outline-primary mt-4"><i
                                class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line("Search Again"); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<section id="product-featured" class="grid-view mt-1 pl-lg-2 pl-md-2">

    <?php if ($this->is_ecommerce_related_product_exist) : ?>
        <?php if (!empty($featured_product_lists)) : ?>
            <div class="col-12 p-0 section-title" style="grid-column-start: 1;grid-column-end: 4;">
                <div class="col-12 p-0 ">
                    <h4 class="card-title mb-1"><?php echo $this->lang->line("Featured Products") ?></h4>
                </div>
                <div class="col-12 mb-3 p-0">
                    <div class="owl-carousel owl-theme" id="featured-products-carousel">
                        <?php foreach ($featured_product_lists as $featured) : ?>
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

</section>


<section id="product-container" class="<?php echo $product_listing; ?>-view mt-1 pl-lg-2 pl-md-2">


    <?php
    foreach ($product_list_grouped_ordered as $key_main => $value_main) :
        if ($is_category_wise_product_view == '1') {
            $echo_cat = isset($category_list[$key_main]) ? $category_list[$key_main] : $this->lang->line("Other Items");
            echo '<div class="col-12 p-0 section-title" style="grid-column-start: 1;grid-column-end: 4;" data-cat="' . $key_main . '"><h4 class="card-title mb-1">' . $echo_cat . '</h4></div>';
        }

        foreach ($value_main as $key => $value) :
            $product_link = base_url("ecommerce/product/" . $value['id']);
            $product_link = mec_add_get_param($product_link, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
            $show_preperation_time = false;
            if (isset($ecommerce_config['is_preparation_time']) && $ecommerce_config['is_preparation_time'] == '1' && $value["preparation_time_unit"] != "") $show_preperation_time = true;
            $preperationtime = "";
            if ($show_preperation_time) {
                $system_preparation_time = isset($ecommerce_config['preparation_time']) ? $ecommerce_config['preparation_time'] : "30";
                $system_preparation_time_unit = isset($ecommerce_config['preparation_time_unit']) ? $ecommerce_config['preparation_time_unit'] : "minutes";
                $preparation_time = $value['preparation_time'] == "" ? $system_preparation_time : $value['preparation_time'];
                $preparation_time_unit = $value['preparation_time_unit'] == "" ? $system_preparation_time_unit : $value['preparation_time_unit'];
                $preparation_time_unit = str_replace(array("minutes", "hours", "days"), array("m", "h", "d"), $preparation_time_unit);
                $preperationtime = $value["preparation_time_unit"] != "" ? $preparation_time . "" . $preparation_time_unit : "";
            }

            $imgSrc = ($value['thumbnail'] != '') ? base_url('upload/ecommerce/' . $value['thumbnail']) : base_url('assets/img/products/product-1.jpg');
            if (isset($value["woocommerce_product_id"]) && !is_null($value["woocommerce_product_id"]) && $value['thumbnail'] != '')
                $imgSrc = $value['thumbnail'];

            $display_price = mec_display_price($value['original_price'], $value['sell_price'], $currency_icon, '1', $currency_position, $decimal_point, $thousand_comma);

            $display_discount = mec_display_price($value['original_price'], $value['sell_price'], $currency_icon, '4', $currency_position, $decimal_point, $thousand_comma);

            $display_review = "";
            $rating = "";
            if ($this->ecommerce_review_comment_exist && isset($review_data[$value['id']])) :
                $float_review = 'float-right';
                $rating = mec_average_rating($review_data[$value['id']]['total_point'], $review_data[$value['id']]['total_review']);
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
                $display_review = '<ul class="unstyled-list list-inline">' . $review_star . '</ul>';
            endif;

            $lim = $hide_add_to_cart == '1' && $hide_buy_now == '1' ? 75 : 30;

            $display_short_description = strlen(strip_tags($value['product_description'])) > $lim ? substr(strip_tags($value['product_description']), 0, $lim) . '..' : strip_tags($value['product_description']);

            // $cart_lang = $cart_count>0 ? $this->lang->line("Add to Cart") : $this->lang->line("Cart");
            $cart_lang = $this->lang->line("Add to Cart");
            $buy_button_title = $this->lang->line($buy_button_title);
            $display_buy_button = $display_add_to_cart = "";

            if ($hide_buy_now == '0') {
                if ($value['attribute_ids'] == '') {
                    $display_buy_button = '<a  class="btn btn-primary btn-cart add_to_cart buy_now" data-attributes="' . $value['attribute_ids'] . '" data-product-id="' . $value['id'] . '" data-action"add"><i class="bx bx-credit-card"></i> <span class="add-to-cart">' . $buy_button_title . '</span></a>';
                } else {
                    $display_buy_button = '<a href="" class="btn btn-primary btn-cart add_to_cart_modal buy_now" data-product-id="' . $value['id'] . '"><i class="bx bx-credit-card"></i> <span class="add-to-cart">' . $buy_button_title . '</span></a>';
                }
            }

            if ($hide_add_to_cart == '0') {
                if ($value['attribute_ids'] == '') {
                    $display_add_to_cart = '<a href="" class="btn btn-light btn-wishlist add_to_cart" data-attributes="' . $value['attribute_ids'] . '" data-product-id="' . $value['id'] . '" data-action="add"><i class="bx bxs-cart-add"></i> <span>' . $cart_lang . '</span></a>';
                } else {
                    $display_add_to_cart = '<a href="" data-product-id="' . $value['id'] . '" class="btn btn-light btn-wishlist add_to_cart_modal"><i class="bx bxs-cart-add"></i> <span>' . $cart_lang . '</span></a>';
                }
            }
            ?>


            <div class="card ecommerce-card product-single" data-cat="<?php echo $value['category_id']; ?>">
                <div class="item-img text-center">
                    <a href="<?php echo $product_link; ?>">
                        <img
                                class="img-fluid card-img-top"
                                src="<?php echo $imgSrc; ?>"
                                alt="img-<?php echo $value['product_name']; ?>"
                        />
                    </a>
                </div>
                <div class="card-body">
                    <?php echo $display_discount; ?>
                    <div class="item-wrapper">
                        <div class="item-rating">
                            <?php echo $display_review; ?>
                        </div>
                        <div class="item-cost">
                            <h6 class="item-price"><?php echo $display_price; ?></h6>
                        </div>
                    </div>
                    <h6 class="item-name font-medium-2">
                        <a class="text-body"
                           href="<?php echo $product_link; ?>"><?php echo $value['product_name']; ?></a>
                    </h6>
                    <p class="card-text item-description">
                        <?php
                        echo $display_short_description;
                        if (empty($value['product_description'])) echo "&nbsp;";
                        ?>
                    </p>


                </div>
                <div class="item-options text-center">
                    <div class="item-wrapper">
                        <div class="item-cost">
                            <h4 class="item-price"><?php echo $display_price; ?></h4>
                        </div>
                    </div>
                    <?php
                    echo $display_add_to_cart;
                    echo $display_buy_button;
                    ?>
                </div>
            </div>

        <?php
        endforeach;
    endforeach; ?>


</section>


<script>
    var url_cat = '<?php echo $url_cat;?>';
    var is_category_wise_product_view = '<?php echo $is_category_wise_product_view;?>';
    $("document").ready(function () {
        if (url_cat != "") setTimeout(function () {
            $(".cat_nav[data-val=" + url_cat + "]").click();
        }, 500);
        $(document).on('click', '.cat_nav', function (e) {
            e.preventDefault();
            $("#search").val('');
            $('.cat_nav').removeClass('border-primary');
            $(this).addClass('border-primary');
            var cat = $(this).attr('data-val');
            if (cat == '0' || cat == '') {
                $('.product-single').removeClass('d-none');
                $(".section-title").show();
            } else {
                $(".section-title").hide();
                $('.product-single').addClass('d-none');
                $('.product-single[data-cat=' + cat + ']').removeClass('d-none');
            }
            var count = $('.product-single:visible').length;
            if (count == 0) {
                $("#nodata").addClass('d-none');
                $("#nodata_search").removeClass('d-none');
            } else {
                $("#nodata_search").addClass('d-none');
            }
        });

        $("#featured-products-carousel").owlCarousel({
            items: 4,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 4000,
            loop: false,
            onInitialized: function () {
                stage = jQuery('.owl-stage');
                stage.width(stage.width() * 2);
            },
            onRefreshed: function () {
                stage = jQuery('.owl-stage');
                stage.width(stage.width() * 2);
            },
            responsive: {
                0: {
                    items: 2
                },
                468: {
                    items: 3
                },
                768: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            }
        }).trigger('refresh.owl.carousel');

    });

    $(document).on('click', '.add_to_cart_modal', function (e) {
        e.preventDefault();
        var product_id = $(this).attr('data-product-id');
        var buy_now = '0';
        var subscriber_id = "<?php echo isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : ''; ?>";
        if ($(this).hasClass('buy_now')) buy_now = '1';
        if (buy_now) $(this).addClass('btn-progress');
        else {
            $(this).removeClass('btn-outline-primary');
            $(this).addClass('btn-progress');
            $(this).addClass('btn-primary');
        }
        $("#add_to_cart_modal_view .modal-body").html('<div class="text-center" id="waiting" style="width: 100%;margin: 30px 0;" <i class="bx bx-loader-alt bx-spin blue" style="font-size:60px;"></i></div>');
        $("#add_to_cart_modal_view").modal();
        $.ajax({
            context: this,
            type: 'POST',
            data: {product_id, buy_now, subscriber_id},
            url: '<?php echo base_url('ecommerce/add_to_cart_modal'); ?>',
            success: function (response) {
                $(this).removeClass("btn-progress");
                if (!buy_now) {
                    $(this).removeClass('btn-primary');
                    $(this).addClass('btn-outline-primary');
                }
                response = response.replaceAll('#add_to_cart_modal_view #cart_actions{position:fixed;bottom:0;left:0}', '');
                var data = response;
                data = data.replaceAll('fas fa-cart-plus', 'bx bxs-cart-add');
                data = data.replaceAll('fas fa-minus-circle', 'bx bx-minus-circle');


                $("#add_to_cart_modal_view .modal-body").html(data);
            }

        });
    });

    function search_product(obj, div_id) {  // obj = 'this' of jquery, div_id = id of the div
        var filter = $(obj).val().toUpperCase();
        if (filter.length > 0) {
            $(".section-title").hide();
            $(".cat_nav").removeClass('border-primary');
        } else {
            $(".section-title").show();
            $(".slide:first-child .cat_nav").addClass('border-primary');
        }

        $('#' + div_id + " .product-single").each(function () {
            var content = $(this).text().trim();
            if (content.toUpperCase().indexOf(filter) > -1) {
                $(this).removeClass('d-none');
            } else $(this).addClass('d-none');
        });
        var count = $('.product-single:visible').length;
        if (count == 0) $("#nodata_search").removeClass('d-none');
        else $("#nodata_search").addClass('d-none');

    }
</script>

<style type="text/css">
    .cat_nav {
        padding: 5px 10px;
        margin: 5px 0 5px 0;
        border-radius: 10px !important;
        margin-right: 5px;
        font-weight: normal !important;
        font-size: 12px;
    }

    .category_container {
        display: inline-flex;
        width: 100%;
        overflow-y: auto;
    }

    .category_container .slide {
        float: left;
    }

    .rounded {
        border-radius: 10px !important;
    }

    .rounded-left {
        border-radius: 10px 0 0 10px !important;
    }

    .nicescroll-cursors {
        top: 5px !important;
    }

    .preparation_time {
        opacity: .7;
        padding: 2px 0;
        border-radius: 0 0 0 10px !important;
        width: 70px;
        text-align: center;
        position: absolute;
        bottom: 8.5px;
        left: 4.5px;
        font-size: 10px !important;
        font-weight: 400;
    }

    .preparation_time2 {
        opacity: .7;
        padding: 2px 5px 2px 5px;
        border-radius: 0 !important;
        width: 100%;
        text-align: left;
        position: absolute;
        bottom: 0;
        font-size: 10px !important;
        font-weight: 400;
    }

    /*.display_review{padding:2px 0;border-radius:0!important;width:50px;text-align:right;position:absolute;top:0;right:0;font-size: 10px !important;font-weight: 400;}*/
    .preparation_time2 .orange {
        font-size: 8px !important;
        line-height: normal;
    }

    .preparation_time i, .preparation_time2 i, .display_review i {
        font-size: 8px !important;
    }

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

    #featured-products-carousel .article.article-style-c .article-header {
        height: 80px !important;
    }

    @media (max-width: 575.98px) {
        .article.article-style-c .article-header {
            height: 110px !important;
        }
    }
</style>


<?php include(APPPATH . "n_views/ecommerce/cart_js.php"); ?>
<?php include(APPPATH . "n_views/ecommerce/cart_style.php"); ?>
<?php include(APPPATH . "n_views/ecommerce/common_style.php"); ?>


<div class="modal fade" id="add_to_cart_modal_view" tabindex="-1" role="dialog"
     aria-labelledby="add_to_cart_modal_viewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="display: inline-table;">
            <div class="modal-header p-1">
                <h3 class="modal-title"
                    id="add_to_cart_modal_viewLabel"><?php echo $this->lang->line("Choose Options"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bx bx-chevron-left"></i></span>
                </button>
            </div>
            <div class="modal-body text-justify pt-0 pl-3 pr-3 pb-3">

            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        var gridViewBtn = $('.grid-view-btn');
        var listViewBtn = $('.list-view-btn');
        var ecommerceProducts = $('#product-container');
        var sidebarToggler = $('.shop-sidebar-toggler');
        var sidebarShop = $('.sidebar-shop');
        overlay = $('.body-content-overlay');

        // Grid View
        if (gridViewBtn.length) {
            gridViewBtn.on('click', function () {
                ecommerceProducts.removeClass('list-view').addClass('grid-view');
                listViewBtn.removeClass('active');
                gridViewBtn.addClass('active');
            });
        }

        // List View
        if (listViewBtn.length) {
            listViewBtn.on('click', function () {
                ecommerceProducts.removeClass('grid-view').addClass('list-view');
                gridViewBtn.removeClass('active');
                listViewBtn.addClass('active');
            });
        }

        // Show sidebar
        if (sidebarToggler.length) {
            sidebarToggler.on('click', function () {
                sidebarShop.toggleClass('show');
                overlay.toggleClass('show');
                $('body').addClass('modal-open');
            });
        }

        // Overlay Click
        if (overlay.length) {
            overlay.on('click', function (e) {
                sidebarShop.removeClass('show');
                overlay.removeClass('show');
                $('body').removeClass('modal-open');
            });
        }

    });
</script>
