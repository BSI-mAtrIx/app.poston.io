<!-- Start of Mobile Menu -->
<div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay"></div>
    <!-- End of .mobile-menu-overlay -->

    <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
    <!-- End of .mobile-menu-close -->
    <?php
    $n_special_search = _link('ecommerce/search/' . $js_store_unique_id);
    $n_special_search = mec_add_get_param($n_special_search, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
    ?>
    <div class="mobile-menu-container scrollable">
        <form style="z-index:9999999" action="<?php echo $n_special_search; ?>" method="get" class="input-wrapper">
            <input name="subscriber_id" value="<?php echo $subscriberId; ?>" type="hidden"/>
            <input style="z-index:9999999" minlength="3" type="text" id="search_mobile" class="form-control"
                   name="search" autocomplete="off" placeholder="Search" required/>
            <button class="btn btn-search" type="submit">
                <i class="w-icon-search"></i>
            </button>
        </form>
        <!-- End of Search Form -->
        <div class="tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#main-menu" class="nav-link active"><?php echo $l->line('Main Menu'); ?></a>
                </li>
                <li class="nav-item">
                    <a href="#categories" class="nav-link"><?php echo $l->line('Categories'); ?></a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="main-menu">
                <ul class="mobile-menu">
                    <li>
                        <a href="<?php echo $home_url_ntheme; ?>"><?php echo $l->line('Home'); ?></a>
                    </li>
                    <li>
                        <a href="<?php e_link($my_account_link); ?>"><?php echo $l->line('My account'); ?></a>
                    </li>
                    <li>
                        <?php
                        $terms_url_ntheme = _link('ecommerce/terms/' . $js_store_unique_id);
                        $terms_url_ntheme = mec_add_get_param($terms_url_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
                        ?>
                        <a href="<?php echo $terms_url_ntheme; ?>"><?php echo $l->line('Terms'); ?></a>
                    </li>
                    <li>
                        <?php
                        $refund_policy_url_ntheme = _link('ecommerce/refund_policy/' . $js_store_unique_id);
                        $refund_policy_url_ntheme = mec_add_get_param($refund_policy_url_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
                        ?>
                        <a href="<?php echo $refund_policy_url_ntheme; ?>"><?php echo $l->line('Refund policy'); ?></a>
                    </li>
                    <?php if ($n_eco_builder_config['contact_page_on'] == 'true') {
                        $contact_ntheme = _link('ecommerce/contact/' . $js_store_unique_id);
                        $contact_ntheme = mec_add_get_param($contact_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
                        ?>
                        <li>
                            <a href="<?php echo $contact_ntheme; ?>"><?php echo $l->line('Contact'); ?></a>
                        </li>
                    <?php } ?>

                    <?php if (!$purchase_off and $subscriberId == "") { ?>
                        <li>
                            <a style="display:inline-block"
                               href="<?php e_link('ecommerce/login_signup/' . $js_store_unique_id); ?>"
                               class="login sign-in"><?php echo $l->line('Sign in'); ?></a>
                            <span class="delimiter">/</span>
                            <a style="display:inline-block"
                               href="<?php e_link('ecommerce/login_signup/' . $js_store_unique_id); ?>"
                               class="ml-0 login register"><?php echo $l->line('Register'); ?></a>
                        </li>

                    <?php } else { ?>
                        <li>
                            <a href="<?php echo $logout_ntheme; ?>"
                               class="login sign-out logout_btn"><?php echo $l->line('Logout'); ?></a>
                        </li>
                    <?php } ?>


                </ul>
            </div>
            <div class="tab-pane" id="categories">
                <ul class="mobile-menu">
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

                        $f_url = _link('ecommerce/category/' . $value['id'] . '_' . url_title($value["category_name"]));
                        $f_url = mec_add_get_param($f_url, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

                        $menu_build .= '<li class="' . $active_class . '">
                                <a href="' . $f_url . '">' . $value["category_name"] . '</a>
                            </li>';

                        $active_class = '';

                    }

                    echo '<li class="' . $menu_active_set . '">
                                <a href="' . $home_url_ntheme . '">' . $l->line('Home') . '</a>
                            </li>';

                    echo $menu_build;


                    ?>


                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End of Mobile Menu -->