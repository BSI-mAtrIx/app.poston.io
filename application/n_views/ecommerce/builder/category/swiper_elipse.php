<div class="<?php echo $n_eco_builder_config['menu_swiper_width']; ?> mt-2">
    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            align-items: center;
            display: block;
        }


        .category-ellipse .category-name a {
            text-transform: uppercase;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0;
        }

        .category-ellipse .category-media {
            border: none;
            -webkit-transition: -webkit-box-shadow 0.3s, -webkit-transform 0.3s;
            transition: -webkit-box-shadow 0.3s, -webkit-transform 0.3s;
            transition: box-shadow 0.3s, transform 0.3s;
            transition: box-shadow 0.3s, transform 0.3s, -webkit-box-shadow 0.3s, -webkit-transform 0.3s;
        }

        .category-ellipse:hover .category-media, .swiper-active .category-media {
            -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .category-ellipse:hover .category-name, .swiper-active .category-name {
            color: <?php echo $n_eco_builder_config['menu_swiper_name_hover_color']; ?>;
        }

        .swiper-container {
            padding: 20px;
        }

        .category-ellipse .category-media {
            border-radius: <?php echo $n_eco_builder_config['menu_swiper_radius']; ?>% !important;
        }
    </style>
    <section class="category-ellipse-section">
        <div class="category-ellipse-section-swiper swiper-container swiper-theme shadow-swiper show-code-action">
            <div class="swiper-wrapper">

                <?php

                $active_class = '';
                $menu_active_set = 'active';
                unset($category_list['']);

                $menu_build = '';
                if (empty($category_id)) {
                    $category_id = -1;
                }
                foreach ($category_list_raw as $key => $value) {
                    if ($category_id == $value['id'] . '_' . url_title($value["category_name"])) {
                        $active_class = 'swiper-active';
                        $menu_active_set = '';
                    }
                    if (empty($value["thumbnail"])) {
                        $value["thumbnail"] = base_url('n_assets/img/category_placeholder.jpg');
                    } else {
                        $value["thumbnail"] = base_url('upload/ecommerce/' . $value["thumbnail"]);
                    }

                    $product_url_cat = _link('ecommerce/category/' . $value['id'] . '_' . url_title($value["category_name"]));
                    $product_url_cat = mec_add_get_param($product_url_cat, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

                    $menu_build .= '
                        <div class="swiper-slide category category-ellipse ' . $active_class . '">';

                    if ($n_eco_builder_config['menu_swiper_text_only'] == 'false') {
                        $menu_build .= '
                         <figure class="category-media">
                                <a href="' . $product_url_cat . '">
                                    <img src="' . $value["thumbnail"] . '" alt="' . $value["category_name"] . '"
                                         width="190" height="190"/>
                                </a>
                            </figure>';
                    }

                    $menu_build .= '<div class="category-content">
                                <h4 class="category-name">
                                    <a href="' . $product_url_cat . '">' . $value["category_name"] . '</a>
                                </h4>
                            </div>
                        </div>';

                    $active_class = '';

                }
                echo $menu_build;
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
</div>
