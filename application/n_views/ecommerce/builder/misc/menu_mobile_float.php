<div class="btn-group-fab" role="group" aria-label="FAB Menu">
    <div>

        <ul class="menu" style="display: none;">
            <?php

            $active_class = '';
            $menu_active_set = 'active';
            $menu_i = 0;
            unset($category_list['']);

            $menu_build = '';
            if (empty($category_id)) {
                $category_id = -1;
            }
            foreach ($category_list_raw as $key => $value) {
                $menu_i += 1;
                if ($menu_i > $n_eco_builder_config['menu_mobile_float_max_pos']) {
                    continue;
                }
                if ($menu_i == $n_eco_builder_config['menu_mobile_float_max_pos']) {
                    $menu_build .= '<li class="btn-sub">
                                <a href="#" class="mobile-menu-toggle">' . $l->line('More') . '</a>
                            </li>';
                    continue;
                }
                if ($category_id == $value['id']) {
                    $active_class = 'active';
                    $menu_active_set = '';
                }

                $product_url_cat = _link('ecommerce/category/' . $value['id'] . '_' . url_title($value["category_name"]));
                $product_url_cat = mec_add_get_param($product_url_cat, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

                $menu_build .= '<li class="  btn-sub ' . $active_class . '">
                                <a href="' . $product_url_cat . '">' . $value["category_name"] . '</a>
                            </li>';

                $active_class = '';


            }

            $product_url_cat = _link('ecommerce/store/' . $js_store_unique_id);
            $product_url_cat = mec_add_get_param($product_url_cat, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

            echo '<li class=" btn-sub ' . $menu_active_set . '">
                                <a href="' . $product_url_cat . '">' . $l->line('Home') . '</a>
                            </li>';

            echo $menu_build;


            ?>

        </ul>

    </div>
    <div class="btn-main-div">
        <button type="button" class="btn btn-main btn-primary has-tooltip" data-placement="left" title="Menu"><i
                    class="w-icon-hamburger"></i></button>
    </div>

</div>

<?php
$menu_mobile_float_bottom = '20px';
if ($n_eco_builder_config['show_mobile_menu'] == 'true') {
    $menu_mobile_float_bottom = '80px';
}
?>
<style>
    .btn-group-fab .btn-main-div {
        display: none;
    }

    @media (max-width: 479px) {
        .btn-group-fab {
            z-index: 9999;
            position: fixed;
            height: auto;
            width: 100%;
            bottom: <?php echo $menu_mobile_float_bottom; ?>;
        }

        .btn-group-fab div {
            position: relative;
            width: 100%;
            height: auto;
        }

        .btn-group-fab .btn {
            border-radius: 50%;
            margin-bottom: 4px;
            margin: 4px auto;
            padding: 5px;
        }

        .btn-group-fab .btn-main-div {
            text-align: center;
            z-index: 9;
            display: block;
        }

        .btn-group-fab .btn-main {
            width: 50px;
            height: 50px;
            z-index: 9;
            border-color: <?php echo $n_eco_builder_config['menu_mobile_float_background']; ?>;
            background-color: <?php echo $n_eco_builder_config['menu_mobile_float_background']; ?>;
        }

        .btn-group-fab .btn-sub {
            z-index: 8;
            border: 0;
            display: inline-block;
            width: 100%;
            background: #fff;
        }

        .btn-group-fab .btn-sub a {
            padding: 1rem 10px;
        }

        .btn-group-fab .menu {
            -webkit-transition: all 2s;
            transition: all 0.5s;
            text-align: center;
            max-width: 200px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 2px 35px rgb(0 0 0 / 10%);
        }

        .btn-group-fab.active .menu {
            display: block !important;
            -webkit-transition: all 2s;
            transition: all 0.5s;
        }
    }
</style>

<script>
    $(function () {
        $('.btn-group-fab').on('click', '.btn', function () {
            $('.btn-group-fab').toggleClass('active');
        });
        //$('has-tooltip').tooltip();
    });
</script>