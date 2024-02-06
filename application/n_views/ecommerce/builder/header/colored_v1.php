<!-- Start of Header -->
<header class="header">
    <div class="header-top" style="background: <?php echo $n_eco_builder_config['background_color_header_top']; ?>;">
        <div class="container">
            <div class="header-left">
                <p class="welcome-msg"><?php echo $n_eco_builder_config['header_text']; ?></p>
            </div>
            <div class="header-right">
                <?php
                $current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language");
                $flag_current = LangToCode($current_language, $n_config);


                $n_eco_builder_config['store_lang'] = explode(',', $n_eco_builder_config['store_lang']);

                if (!empty($n_eco_builder_config['store_lang']) and count($n_eco_builder_config['store_lang']) > 2) {

                    ?>
                    <div class="dropdown">
                        <a href="#language"><i
                                    class="flag-icon flag-icon-<?php echo $flag_current; ?>"></i> <?php echo $current_language; ?>
                        </a>
                        <div class="dropdown-box">

                            <?php

                            ksort($language_info);
                            foreach ($n_eco_builder_config['store_lang'] as $key_lang => $value_lang) {
                                if (empty($value_lang)) {
                                    continue;
                                }
                                if (!file_exists(APPPATH . 'language/' . strtolower($value_lang) . '/v_5_0_a_lang.php')) {
                                    continue;
                                }

                                $selected = '';

                                $flag = LangToCode($value_lang, $n_config);

                                echo '<a class="dropdown-item language_switch" href="#" data-id="' . strtolower($value_lang) . '" data-language="' . $value_lang . '" ' . $selected . '><i class="flag-icon flag-icon-' . $flag . ' mr-50"></i> ' . $value_lang . '</a>';
                            }
                            ?>

                        </div>
                    </div>
                    <!-- End of Dropdown Menu -->
                    <span class="divider d-lg-show"></span>
                <?php } ?>
                <?php if ($n_eco_builder_config['contact_page_on'] == 'true') { ?>
                    <a href="<?php
                    $contact_ntheme = _link('ecommerce/contact/' . $js_store_unique_id);
                    $contact_ntheme = mec_add_get_param($contact_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
                    echo $contact_ntheme; ?>" class="d-lg-show"><?php echo $l->line('Contact'); ?></a>
                <?php } ?>


                <?php if ($subscriberId != "") {
                    if (!$purchase_off) { ?>
                        <a href="<?php e_link($my_account_link); ?>"
                           class="d-lg-show"><?php echo $this->lang->line("My Account"); ?></a>
                    <?php }
                } ?>

                <?php if (!$purchase_off and $subscriberId == "") { ?>
                    <a href="<?php e_link('ecommerce/login_signup/' . $js_store_unique_id); ?>"
                       class="d-lg-show login sign-in"><i class="w-icon-account"></i><?php echo $l->line('Sign in'); ?>
                    </a>
                    <span class="delimiter d-lg-show">/</span>
                    <a href="<?php e_link('ecommerce/login_signup/' . $js_store_unique_id); ?>"
                       class="ml-0 d-lg-show login register"><?php echo $l->line('Register'); ?></a>

                <?php } else { ?>
                    <?php
                    $logout_ntheme = _link('ecommerce/login_signup/' . $js_store_unique_id);
                    $logout_ntheme = mec_add_get_param($logout_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
                    ?>
                    <a href="<?php echo $logout_ntheme; ?>" class="d-lg-show login sign-out logout_btn"><i
                                class="w-icon-logout"></i><?php echo $l->line('Logout'); ?></a>

                <?php } ?>


            </div>
        </div>
    </div>
    <!-- End of Header Top -->

    <div class="header-middle"
         style="background: <?php echo $n_eco_builder_config['background_color_header_middle']; ?>;">
        <div class="container">
            <div class="header-left mr-md-4">
                <a href="#" class="mobile-menu-toggle w-icon-hamburger">
                </a>
                <?php

                $home_url_ntheme = _link('ecommerce/store/' . $js_store_unique_id);
                $home_url_ntheme = mec_add_get_param($home_url_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));


                if ($n_eco_builder_config['store_logo_show'] != 'none') { ?>
                    <a href="<?php echo $home_url_ntheme; ?>" class="logo ml-lg-0">
                        <?php if ($n_eco_builder_config['store_logo_show'] != 'none') { ?>
                            <img src="<?php echo $n_store_logo_light; ?>" alt="logo"
                                 width="<?php echo $n_eco_builder_config['logo_width_header']; ?>"
                                 height="<?php echo $n_eco_builder_config['logo_height_header']; ?>"/>
                        <?php }


                        ?>

                    </a>
                <?php }

                if ($n_eco_builder_config['show_store_name'] == 'true') {
                    echo '<a href="' . $home_url_ntheme . '" class="logo ml-lg-0"><span class="store_name_n">' . $social_analytics_codes['store_name'] . '</span></a>';
                }


                $n_special_search = _link('ecommerce/search/' . $js_store_unique_id);
                $n_special_search = mec_add_get_param($n_special_search, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

                ?>
                <?php if ($n_eco_builder_config['header_search'] == 'true') { ?>
                    <form method="get" action="<?php echo $n_special_search; ?>"
                          class="input-wrapper header-search hs-expanded hs-round d-none d-md-flex">
                        <input name="subscriber_id" value="<?php echo $subscriberId; ?>" type="hidden"/>
                        <input type="text" minlength="3" class="form-control bg-white" name="search" id="search"
                               placeholder="Search in..." required/>
                        <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                        </button>
                    </form>
                <?php } ?>
            </div>
            <div class="header-right ml-4 ">
                <div class="header-call d-xs-show d-lg-flex align-items-center d-none" style="display: none!important;">
                    <a href="tel:#" class="w-icon-call"></a>
                    <div class="call-info d-lg-show ">
                        <h4 class="chat font-weight-normal font-size-md text-normal ls-normal mb-0">
                            <a href="mailto:#" class="text-capitalize">Live Chat</a> or :</h4>
                        <a href="tel:#" class="phone-number font-weight-bolder ls-50">0(800)123-456</a>
                    </div>
                </div>

                <style type="text/css">
                    .cart-dropdown i {
                        font-size: 2.6rem;
                        color: inherit;
                        height: 2.6rem;
                    }

                    .cart-dropdown .cart-count {
                        position: relative;
                        right: -15px;
                        top: -32px;
                    }
                </style>

                <a href="<?php echo $href; ?>"
                   class="cart_url_api cart-dropdown label-down link" <?php echo $hide_cart; ?>>
                    <i class="w-icon-cart show_cart_count ">
                        <span class="cart-count cart_item_count <?php if ($cart_count == 0) {
                            echo ' d-none';
                        } ?>"><?php echo $cart_count; ?></span>
                    </i>
                    <span class="cart-label"><?php echo $this->lang->line("Cart"); ?></span>
                </a>
            </div>
        </div>
    </div>
    <!-- End of Header Middle -->

    <?php
    switch ($n_eco_builder_config['menu_style']) {
        case 'classic_menu';
        case 'both';
            include(APPPATH . 'n_views/ecommerce/builder/category/classic_menu.php');
            break;
        case 'swiper';
            // include(APPPATH.'n_views/ecommerce/builder/category/swiper_elipse.php');
            break;
    }

    ?>
</header>
<!-- End of Header -->