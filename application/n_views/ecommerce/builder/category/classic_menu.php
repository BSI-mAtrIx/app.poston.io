<div class="header-bottom sticky-content fix-top sticky-header has-dropdown">
    <div class="container">
        <div class="inner-wrap">
            <div class="header-left">
                <nav class="main-nav">
                    <ul class="menu">
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
                                $active_class = 'active';
                                $menu_active_set = '';
                            }

                            $product_url_cat = _link('ecommerce/category/' . $value['id'] . '_' . url_title($value["category_name"]));
                            $product_url_cat = mec_add_get_param($product_url_cat, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

                            $menu_build .= '<li class="' . $active_class . '">
                                <a href="' . $product_url_cat . '">' . $value["category_name"] . '</a>
                            </li>';

                            $active_class = '';

                        }

                        $product_url_cat = _link('ecommerce/store/' . $js_store_unique_id);
                        $product_url_cat = mec_add_get_param($product_url_cat, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

                        echo '<li class="' . $menu_active_set . '">
                                <a href="' . $product_url_cat . '">' . $l->line('Home') . '</a>
                            </li>';

                        echo $menu_build;


                        ?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>