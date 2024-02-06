<style>
    .brand-logo,
    .brand-text,
    body.menu-collapsed.vertical-layout.vertical-menu-modern .main-menu .navbar-header .brand-text.dark_icon_br,
    body.menu-collapsed.vertical-layout.vertical-menu-modern .main-menu .navbar-header .brand-text.light_icon_br,
    body.menu-collapsed .main-menu.menu-dark.expanded .brand-logo.dark_icon,
    body.menu-collapsed .main-menu.menu-dark.expanded .brand-logo.dark_icon{
        display: none;
    }

    body.menu-open .menu-dark .brand-text.dark_icon_br,
    body.menu-expanded .menu-dark .brand-text.dark_icon_br,
    body.menu-collapsed.vertical-layout.vertical-menu-modern .main-menu.menu-dark.expanded .navbar-header .brand-text.dark_icon_br,
    body.menu-collapsed .main-menu.menu-dark .brand-logo.dark_icon{
        display: block;
    }

    body.menu-open .menu-light .brand-text.light_icon_br,
    body.menu-expanded .menu-light .brand-text.light_icon_br,
    body.menu-collapsed.vertical-layout.vertical-menu-modern .main-menu.menu-light.expanded .navbar-header .brand-text.light_icon_br,
    body.menu-collapsed .main-menu.menu-dark .brand-logo.dark_icon{
        display: block;
    }
</style>

<?php
if ($n_config['current_theme'] == 'light-layout') {
    $n_theme_scheme = 'menu-light';
} else {
    $n_theme_scheme = 'menu-dark';
}

?>


<div class="main-menu menu-fixed <?php echo $n_theme_scheme; ?>  menu-accordion menu-shadow"
     data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="<?php echo base_url(); ?>">
                    <?php

                    if ($rtl_on) {
                        if (!empty($n_config['dark_icon_rtl'])) {
                            $n_config['dark_icon'] = $n_config['dark_icon_rtl'];
                        }
                        if (!empty($n_config['dark_logo_rtl'])) {
                            $n_config['dark_logo'] = $n_config['dark_logo_rtl'];
                        }
                        if (!empty($n_config['light_icon_rtl'])) {
                            $n_config['light_icon'] = $n_config['light_icon_rtl'];
                        }
                    }

                    $n_theme_on_sidebar_dnone = 'd-none';
                    if (!empty($n_theme_on_sidebar) and $n_theme_on_sidebar == 'menu-collapsed') {
                        $n_theme_on_sidebar_dnone = '';
                    }

                    if (!empty($n_config['dark_icon'])) { ?>
                        <div class="brand-logo dark_icon <?php echo $n_theme_on_sidebar_dnone; ?>">
                            <img class="img-fluid" src="<?php echo base_url();
                            echo $n_config['dark_icon']; ?>"
                                 alt='<?php echo $this->config->item("product_short_name"); ?>'/>
                        </div>
                    <?php }

                    if (!empty($n_config['light_icon'])) { ?>
                        <div class="brand-logo light_icon <?php echo $n_theme_on_sidebar_dnone; ?>">
                            <img class="img-fluid" src="<?php echo base_url();
                            echo $n_config['light_icon']; ?>"
                                 alt='<?php echo $this->config->item("product_short_name"); ?>'/>
                        </div>
                    <?php }

                    if (!empty($n_config['dark_logo'])) {
                        $logo_uri = base_url() . $n_config['dark_logo'];
                    } else {
                        $logo_uri = base_url() . 'assets/img/logo.png';
                        if ($rtl_on) {
                            if (!empty($n_config['light_logo_rtl'])) {
                                $logo_uri = base_url() . $n_config['light_logo_rtl'];
                            }
                        }
                    }
                    ?>
                    <img class="brand-text dark_icon_br" src="<?php echo $logo_uri; ?>"
                         alt='<?php echo $this->config->item("product_short_name"); ?>' style="max-width:170px;"/>
                    <img class="brand-text light_icon_br" src="<?php echo base_url() . 'assets/img/logo.png'; ?>"
                         alt='<?php echo $this->config->item("product_short_name"); ?>' style="max-width:170px;"/>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                            class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary"
                            data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation"
            data-icon-style="<?php echo $n_config['livicon_icon_style']; ?>">

            <li class="navigation-header text-truncate"><span class="menu-title">&nbsp;</span></li>

            <?php
            $admin_double_level2 = array('admin/activity_log', 'payment/accounts', 'payment/earning_summary', 'payment/transaction_log', 'blog/posts');
            $all_links = array();
            foreach ($menus as $single_menu) {
                $menu_html = '';
                $only_admin = $single_menu['only_admin'];
                $only_member = $single_menu['only_member'];
                $module_access = explode(',', $single_menu['module_access']);
                $module_access = array_filter($module_access);

                if ($n_config['sidebar_icons'] == 'livicons') {
                    $menu_class = 'menu-livicon';
                    switch ($single_menu['icon']) {
                        case 'fa fa-fire';
                            $single_menu['icon'] = 'desktop';
                            break;
                        case 'fas fa-laptop-code';
                            $single_menu['icon'] = 'cpu';
                            break;
                        case 'fas fa-coins';
                            $single_menu['icon'] = 'coins';
                            break;
                        case 'fa fa-cloud-download-alt';
                            $single_menu['icon'] = 'cloud-download';
                            break;
                        case 'fab fa-facebook-square';
                            $single_menu['icon'] = 'globe';
                            break;
                        case 'fas fa-address-book';
                            $single_menu['icon'] = 'notebook';
                            break;
                        case 'fas fa-paper-plane';
                            $single_menu['icon'] = 'paper-plane';
                            break;
                        case 'fas fa-robot';
                            $single_menu['icon'] = 'gears';
                            break;
                        case 'fa fa-share-square';
                            $single_menu['icon'] = 'share-alt';
                            break;
                        case 'fas fa-hands-helping';
                            $single_menu['icon'] = 'help';
                            break;
                        case 'fas fa-search';
                            $single_menu['icon'] = 'search';
                            break;
                        case 'fa fa-instagram';
                            $single_menu['icon'] = 'globe';
                            break;
                        case 'fa fa-store';
                            $single_menu['icon'] = 'shoppingcart';
                            break;
                        case 'fa fa-user-secret';
                            $single_menu['icon'] = 'lock';
                            break;
                        case 'fa fa-image';
                            $single_menu['icon'] = 'image';
                            break;
                        case 'fas fa-project-diagram';
                            $single_menu['icon'] = 'diagram';
                            break;
                        case 'fa fa-layer-group';
                            $single_menu['icon'] = 'list';
                            break;
                        case 'fa fa-magic';
                            $single_menu['icon'] = 'magic';
                            break;

                        case 'fas fa-people-carry';
                            $single_menu['icon'] = 'users';
                            break;

                        case 'fas fa-layer-group';
                            $single_menu['icon'] = 'list';
                            break;

                        case 'fab fa-wordpress';
                            $single_menu['icon'] = 'share';
                            break;

                        case 'fas fa-store-alt';
                            $single_menu['icon'] = 'briefcase';
                            break;

                        case 'fab fa-google';
                            $single_menu['icon'] = 'search';
                            break;

                        case 'fa fa-tasks';
                            $single_menu['icon'] = 'check';
                            break;

                        default;
                            $array = array("fa", "fas", 'fab');
                            if (0 < count(array_intersect(array_map('strtolower', explode(' ', $single_menu['icon'])), $array))) {
                                $single_menu['icon'] = 'globe';
                            }
                            break;
                    }
                }
                if ($n_config['sidebar_icons'] == 'boxicons') {
                    $menu_class = 'bx ';
                    switch ($single_menu['icon']) {
                        case 'fa fa-fire';
                            $single_menu['icon'] = 'bx-desktop';
                            break;
                        case 'fas fa-laptop-code';
                            $single_menu['icon'] = 'bx-laptop';
                            break;
                        case 'fas fa-coins';
                            $single_menu['icon'] = 'bx-coin-stack';
                            break;
                        case 'fa fa-cloud-download-alt';
                            $single_menu['icon'] = 'bx-cloud-download';
                            break;
                        case 'fab fa-facebook-square';
                            $single_menu['icon'] = 'bxl-facebook-square';
                            break;
                        case 'fas fa-address-book';
                            $single_menu['icon'] = 'bx-note';
                            break;
                        case 'fas fa-paper-plane';
                            $single_menu['icon'] = 'bx-paper-plane';
                            break;
                        case 'fas fa-robot';
                            $single_menu['icon'] = 'bx-wrench';
                            break;
                        case 'fa fa-share-square';
                            $single_menu['icon'] = 'bx-share-alt';
                            break;
                        case 'fas fa-hands-helping';
                            $single_menu['icon'] = 'bx-help-circle';
                            break;
                        case 'fas fa-search';
                            $single_menu['icon'] = 'bx-search';
                            break;
                        case 'fa fa-instagram';
                            $single_menu['icon'] = 'bxl-instagram';
                            break;
                        case 'fa fa-store';
                            $single_menu['icon'] = 'bx-cart';
                            break;
                        case 'fa fa-user-secret';
                            $single_menu['icon'] = 'bx-lock';
                            break;
                        case 'fa fa-image';
                            $single_menu['icon'] = 'bx-image';
                            break;
                        case 'fas fa-project-diagram';
                            $single_menu['icon'] = 'bx-network-chart';
                            break;
                        case 'fa fa-layer-group';
                            $single_menu['icon'] = 'bx-list-ul';
                            break;
                        case 'fa fa-magic';
                            $single_menu['icon'] = 'bxs-magic-wand';
                            break;

                        case 'fas fa-people-carry';
                            $single_menu['icon'] = 'bxs-user';
                            break;

                        case 'fas fa-layer-group';
                            $single_menu['icon'] = 'bx-list-ul';
                            break;

                        case 'fab fa-wordpress';
                            $single_menu['icon'] = 'bx-share-alt';
                            break;

                        case 'fas fa-store-alt';
                            $single_menu['icon'] = 'bx-briefcase';
                            break;

                        case 'fab fa-google';
                            $single_menu['icon'] = 'bxl-google';
                            break;

                        case 'fa fa-tasks';
                            $single_menu['icon'] = 'bx-checkbox-checked';
                            break;

                        default;
                            $array = array("fa", "fas", 'fab');
                            if (0 < count(array_intersect(array_map('strtolower', explode(' ', $single_menu['icon'])), $array))) {
                                $single_menu['icon'] = 'bx-globe';
                            }
                            break;
                    }
                }

                if ($single_menu['url'] == 'social_apps/index' && $single_menu['only_member'] == '1' && $this->config->item('backup_mode') === '0' && $this->session->userdata('user_type') == 'Member') continue; // static condition not to

                if ($single_menu['module_access'] == '278,279' && ($this->config->item('instagram_reply_enable_disable') === '0' || $this->config->item('instagram_reply_enable_disable') == '')) continue;
                if ($single_menu['module_access'] == '296' && ($this->config->item('instagram_reply_enable_disable') === '0' || $this->config->item('instagram_reply_enable_disable') == '')) continue;

                if (!addon_exist($module_id = 315, $addon_unique_name = "visual_flow_builder") && $single_menu['module_access'] == '315') continue;

                if ($single_menu['header_text'] != '') $menu_html .= '<li class="navigation-header text-truncate"><span class="menu-title">' . $this->lang->line($single_menu['header_text']) . '</span></li>';

                $extraText = '';
                if ($single_menu['add_ons_id'] != '0' && $this->is_demo == '1') $extraText = ' <label class="label label-warning" style="font-size:9px;padding:4px 3px;">Addon</label>';

                if ($single_menu['have_child'] == '1') {
                    $dropdown_class1 = "nav-item has-sub";
                    $dropdown_class2 = "";
                } else {
                    $dropdown_class1 = "nav-item";
                    $dropdown_class2 = "";
                }
                if ($single_menu['is_external'] == '1') $site_url1 = ""; else $site_url1 = site_url(); // if external link then no need to add site_url()
                if ($single_menu['is_external'] == '1') $parent_newtab = " target='_BLANK'"; else $parent_newtab = ''; // if external link then open in new tab
                if ($n_config['is_external_off'] == 'true') {
                    $parent_newtab = '';
                }
                $menu_html .= "<li id='".md5($single_menu['url'])."' class='" . $dropdown_class1 . "'><a {$parent_newtab} href='" . $site_url1 . $single_menu['url'] . "'  " . $dropdown_class2 . "><i class='" . $menu_class . ($menu_class == 'bx ' ? $single_menu['icon'] : '') . "' " . ($menu_class != 'bx ' ? "data-icon='" . $single_menu['icon'] . "'" : '') . "></i> <span class='menu-title text-truncate'>" . $this->lang->line($single_menu['name']) . $extraText . "</span></a>";

                array_push($all_links, $site_url1 . $single_menu['url']);

                if (isset($menu_child_1_map[$single_menu['id']]) && count($menu_child_1_map[$single_menu['id']]) > 0) {
                    $menu_html .= '<ul class="menu-content">';
                    foreach ($menu_child_1_map[$single_menu['id']] as $single_child_menu) {

                        $only_admin2 = $single_child_menu['only_admin'];
                        $only_member2 = $single_child_menu['only_member'];

                        if ($this->session->userdata('user_type') == 'Admin' && $this->session->userdata('license_type') != 'double' && in_array($single_child_menu['url'], $admin_double_level2)) continue;

                        if (($only_admin2 == '1' && $this->session->userdata('user_type') == 'Member') || ($only_member2 == '1' && $this->session->userdata('user_type') == 'Admin'))
                            continue;

                        if ($single_child_menu['is_external'] == '1') $site_url2 = ""; else $site_url2 = site_url(); // if external link then no need to add site_url()
                        if ($single_child_menu['is_external'] == '1') $child_newtab = " target='_BLANK'"; else $child_newtab = ''; // if external link then open in new tab

                        if ($single_child_menu['have_child'] == '1') $second_menu_href = '';
                        else $second_menu_href = "href='" . $site_url2 . $single_child_menu['url'] . "'";

                        $module_access2 = explode(',', $single_child_menu['module_access']);
                        $module_access2 = array_filter($module_access2);


                        $hide_second_menu = '';
                        if ($this->session->userdata('user_type') != 'Admin' && !empty($module_access2) && count(array_intersect($this->module_access, $module_access2)) == 0) $hide_second_menu = 'hidden';

                        $menu_html .= "<li id='".md5($single_child_menu['url'])."' class=''><a class='d-flex align-items-center' {$child_newtab} {$second_menu_href}><i class='bx bx-right-arrow-alt'></i><span class='menu-item text-truncate'>" . $this->lang->line($single_child_menu['name']) . "</span></a>";

                        array_push($all_links, $site_url2 . $single_child_menu['url']);

                        if (isset($menu_child_2_map[$single_child_menu['id']]) && count($menu_child_2_map[$single_child_menu['id']]) > 0) {
                            $menu_html .= "<ul class='menu-content'>";
                            foreach ($menu_child_2_map[$single_child_menu['id']] as $single_child_menu_2) {
                                $only_admin3 = $single_child_menu_2['only_admin'];
                                $only_member3 = $single_child_menu_2['only_member'];
                                if (($only_admin3 == '1' && $this->session->userdata('user_type') == 'Member') || ($only_member3 == '1' && $this->session->userdata('user_type') == 'Admin'))
                                    continue;
                                if ($single_child_menu_2['is_external'] == '1') $site_url3 = ""; else $site_url3 = site_url(); // if external link then no need to add site_url()
                                if ($single_child_menu_2['is_external'] == '1') $child2_newtab = " target='_BLANK'"; else $child2_newtab = ''; // if external link then open in new tab

                                $menu_html .= "<li><a {$child2_newtab} href='" . $site_url3 . $single_child_menu_2['url'] . "'><i class='" . $single_child_menu_2['icon'] . "'></i> " . $this->lang->line($single_child_menu_2['name']) . "</a></li>";

                                array_push($all_links, $site_url3 . $single_child_menu_2['url']);
                            }
                            $menu_html .= "</ul>";
                        }
                        $menu_html .= "</li>";
                    }
                    $menu_html .= "</ul>";
                }

                $menu_html .= "</li>";

                if ($single_menu['url'] == 'dashboard') {
                    if ($n_config['page_help_view'] == 'true' or ($n_config['page_help_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) {

                        if ($menu_class != 'bx ') {
                            $menu_html .= " <li id='".md5('help')."' class='nav-item'><a  href='" . base_url('help') . "'><i class='" . $menu_class . "' data-icon='" . $n_config['sidebar_icon_help_livicons'] . "'></i> <span class='menu-title text-truncate'>" . $this->lang->line('Help') . "</span></a></li>";
                        } else {
                            $menu_html .= " <li id='".md5('help')."' class='nav-item'><a  href='" . base_url('help') . "'><i class='" . $n_config['sidebar_icon_help_bx'] . "'></i> <span class='menu-title text-truncate'>" . $this->lang->line('Help') . "</span></a></li>";
                        }

                    }
                    if ($n_config['page_faq_view'] == 'true' or ($n_config['page_faq_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) {
                        if ($menu_class != 'bx ') {
                            $menu_html .= " <li id='".md5('faq')."' class='nav-item'><a  href='" . base_url('faq') . "'><i class='" . $menu_class . "' data-icon='" . $n_config['sidebar_icon_faq_livicons'] . "'></i> <span class='menu-title text-truncate'>" . $this->lang->line('FAQ') . "</span></a></li>";
                        } else {
                            $menu_html .= " <li id='".md5('faq')."' class='nav-item'><a  href='" . base_url('faq') . "'><i class='" . $n_config['sidebar_icon_faq_bx'] . "'></i> <span class='menu-title text-truncate'>" . $this->lang->line('FAQ') . "</span></a></li>";
                        }

                    }

                }

                if ($only_admin == '1') {
                    if ($this->session->userdata('user_type') == 'Admin')
                        echo $menu_html;
                } else if ($only_member == '1') {
                    if ($this->session->userdata('user_type') == 'Member')
                        echo $menu_html;
                } else {
                    if ($this->session->userdata("user_type") == "Admin" || empty($module_access) || count(array_intersect($this->module_access, $module_access)) > 0)
                        echo $menu_html;
                }
            }

            if ($this->session->userdata('license_type') == 'double' && $this->session->userdata('user_type') == 'Member') {
                $extra_menu = '';
                if ($n_config['extra_function'] == true) {
                    $extra_menu = '<li class="nav-item"><a href="' . base_url("extra/redeem_code") . '" class="nav-link"><i class="bx bx-right-arrow-alt"></i>' . $this->lang->line("Redeem code") . '</a></li>';
                }
                $extra_menu2 = '';
                if (file_exists(APPPATH . 'controllers/Coupon.php') and file_exists(APPPATH . 'controllers/User_coupon.php')) {
                    $extra_menu2 = '<li class="nav-item"><a href="' . base_url("user_coupon/index") . '" class="nav-link"><i class="bx bx-right-arrow-alt"></i>' . $this->lang->line("Apply coupon") . '</a></li>';
                }
                //todo: echo
                echo '
           <li class="navigation-header text-truncate"><span class="menu-title">' . $this->lang->line($n_config['payment_text_header_sidebar']) . '</span></li>
           <li class="nav-item has-sub">
             <a href="#"><i class="bx bx-dollar-circle"></i> <span>' . $this->lang->line($n_config['payment_text_sidebar']) . '</span></a>
             <ul class="menu-content">
               <li class="nav-item"><a href="' . base_url("payment/buy_package") . '" class="nav-link"><i class="bx bx-right-arrow-alt"></i>' . $this->lang->line("Renew Package") . '</a></li>
               ' . $extra_menu . $extra_menu2 . '
               <li class="nav-item"><a href="' . base_url("payment/transaction_log") . '" class="nav-link"><i class="bx bx-right-arrow-alt"></i>' . $this->lang->line("Transaction Log") . '</a></li>
               <li class="nav-item"><a href="' . base_url("payment/usage_history") . '" class="nav-link"><i class="bx bx-right-arrow-alt"></i>' . $this->lang->line("Usage Log") . '</a></li>
             </ul>
           </li>
           ';
            }
            ?>
        </ul>


        <?php
        if ($this->session->userdata('license_type') == 'double')
            if ($this->config->item('enable_support') == '1') {
                $support_menu = $this->lang->line("Support Desk");
                $support_icon = "bx bx-support";
                $support_url = base_url('simplesupport/tickets');

                echo '
          <div class="hide-sidebar-mini mt-1 text-center" id="support_button">
            <a href="' . $support_url . '" class="btn btn-primary btn-block btn-icon-split width-80-per mx-auto">
              <i class="' . $support_icon . '"></i> <span class="white">' . $support_menu . '</span>
            </a>
          </div>';

                echo '
          <div class="hide-sidebar-mini d-none text-center" id="support_icon">
            <a href="" class="btn btn-primary btn-block btn-icon-split width-80-per mx-auto">
              <i class="' . $support_icon . '"></i>
            </a>
          </div>';
            }
        ?>


    </div>
</div>
<!-- END: Main Menu-->


<?php
$all_links = array_unique($all_links);
$unsetkey = array_search(base_url() . '#', $all_links);
if ($unsetkey != FALSE)
    unset($all_links[$unsetkey]); // removing links without a real url

/* 
links that are not in database [custom link = sibebar parent]
No need to add a custom link if it's parent is controller/index
*/
$custom_links = array
(
    base_url("admin/general_settings") => base_url("admin/settings"),
    base_url("admin/frontend_settings") => base_url("admin/settings"),
    base_url("admin/smtp_settings") => base_url("admin/settings"),
    base_url("admin/email_template_settings") => base_url("admin/settings"),
    base_url("admin/analytics_settings") => base_url("admin/settings"),
    base_url("admin/advertisement_settings") => base_url("admin/settings"),
    base_url("admin/add_user") => base_url("admin/user_manager"),
    base_url("admin/edit_user") => base_url("admin/user_manager"),
    base_url("admin/login_log") => base_url("admin/user_manager"),
    base_url("payment/add_package") => base_url("payment/package_manager"),
    base_url("payment/update_package") => base_url("payment/package_manager"),
    base_url("payment/details_package") => base_url("payment/package_manager"),
    base_url("announcement/add") => base_url("announcement/full_list"),
    base_url("announcement/edit") => base_url("announcement/full_list"),
    base_url("announcement/details") => base_url("announcement/full_list"),
    base_url("addons/upload") => base_url("addons/lists"),
    base_url("comment_automation/all_auto_comment_report") => base_url("comment_automation/comment_section_report"),
    base_url("comment_automation/all_auto_comment_report/0/0") => base_url("instagram_reply/reports"),
    base_url("comment_automation/all_auto_reply_report") => base_url("comment_automation/comment_section_report"),
    base_url("comment_reply_enhancers/bulk_tag_campaign_list") => base_url("comment_automation/comment_section_report"),
    base_url("comment_reply_enhancers/bulk_comment_reply_campaign_list") => base_url("comment_automation/comment_section_report"),
    base_url("comment_reply_enhancers/all_response_report") => base_url("comment_automation/comment_section_report"),
    base_url("comment_reply_enhancers/all_like_share_report") => base_url("comment_automation/comment_section_report"),
    base_url("messenger_bot_enhancers/checkbox_plugin_list") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/checkbox_plugin_add") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/checkbox_plugin_edit") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/send_to_messenger_list") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/send_to_messenger_add") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/send_to_messenger_edit") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/mme_link_list") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/mme_link_add") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/mme_link_edit") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/customer_chat_plugin_list") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/customer_chat_add") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/customer_chat_edit") => base_url("messenger_bot"),
    base_url("messenger_bot_enhancers/subscriber_broadcast_campaign") => base_url("messenger_bot_broadcast"),
    base_url("messenger_bot_enhancers/create_subscriber_broadcast_campaign") => base_url("messenger_bot_broadcast"),
    base_url("messenger_bot_enhancers/edit_subscriber_broadcast_campaign") => base_url("messenger_bot_broadcast"),
    base_url("message_manager/message_dashboard") => base_url("subscriber_manager"),
    base_url("messenger_bot/tree_view") => base_url("messenger_bot"),
    base_url("messenger_bot_connectivity/analytics") => base_url("messenger_bot"),
    base_url("messenger_bot_connectivity/saved_template_view") => base_url("messenger_bot"),
    base_url("webview_builder") => base_url("messenger_bot"),
    base_url("webview_builder/manager") => base_url("messenger_bot"),
    base_url("autoposting/settings") => base_url("ultrapost"),
    base_url("instagram_poster") => base_url("ultrapost"),
    base_url("themes/upload") => base_url("themes/lists"),
    base_url("messenger_bot_connectivity/webview_builder_manager") => base_url("messenger_bot"),
    base_url("messenger_bot_connectivity") => base_url("messenger_bot"),
    base_url("messenger_bot_connectivity/edit_webview") => base_url("messenger_bot"),
    base_url("sms_email_manager/contact_group_list") => base_url("subscriber_manager"),
    base_url("sms_email_manager/contact_list") => base_url("subscriber_manager"),
    base_url("sms_email_manager/sms_campaign_lists") => base_url("messenger_bot_broadcast"),
    base_url("sms_email_manager/create_sms_campaign") => base_url("messenger_bot_broadcast"),
    base_url("sms_email_manager/edit_sms_campaign") => base_url("messenger_bot_broadcast"),
    base_url("sms_email_manager/email_campaign_lists") => base_url("messenger_bot_broadcast"),
    base_url("sms_email_manager/create_email_campaign") => base_url("messenger_bot_broadcast"),
    base_url("sms_email_manager/edit_email_campaign") => base_url("messenger_bot_broadcast"),

    base_url("comment_automation/comment_template_manager") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_automation/template_manager") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_automation/index") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_automation/comment_section_report") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_automation/all_auto_comment_report") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_automation/all_auto_reply_report") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_reply_enhancers/bulk_tag_campaign_list") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_reply_enhancers/bulk_comment_reply_campaign_list") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_reply_enhancers/all_response_report") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_reply_enhancers/all_like_share_report") => base_url("comment_automation/comment_growth_tools"),

    base_url("comment_reply_enhancers/post_list") => base_url("comment_automation/comment_growth_tools"),
    base_url("instagram_reply/template_manager") => base_url("comment_automation/comment_growth_tools"),
    base_url("instagram_reply/get_account_lists") => base_url("comment_automation/comment_growth_tools"),
    base_url("comment_automation/all_auto_comment_report") => base_url("comment_automation/comment_growth_tools"),
    base_url("instagram_reply/instagram_autoreply_report/post") => base_url("comment_automation/comment_growth_tools"),
    base_url("instagram_reply/instagram_autoreply_report/full") => base_url("comment_automation/comment_growth_tools"),
    base_url("instagram_reply/instagram_autoreply_report/mention") => base_url("comment_automation/comment_growth_tools"),


    base_url("affiliate_system/request_info") => base_url("affiliate_system/affiliate_users"),
    base_url("affiliate_system/add_affiliate") => base_url("affiliate_system/affiliate_users"),
    base_url("affiliate_system/edit_affiliate") => base_url("affiliate_system/affiliate_users"),


    base_url("comboposter/text_post/campaigns") => base_url("ultrapost"),
    base_url("comboposter/image_post/campaigns") => base_url("ultrapost"),
    base_url("comboposter/video_post/campaigns") => base_url("ultrapost"),
    base_url("comboposter/link_post/campaigns") => base_url("ultrapost"),
    base_url("comboposter/html_post/campaigns") => base_url("ultrapost"),

    base_url("comboposter/text_post/create") => base_url("ultrapost"),
    base_url("comboposter/image_post/create") => base_url("ultrapost"),
    base_url("comboposter/video_post/create") => base_url("ultrapost"),
    base_url("comboposter/link_post/create") => base_url("ultrapost"),
    base_url("comboposter/html_post/create") => base_url("ultrapost"),

    base_url("comboposter/text_post/edit") => base_url("ultrapost"),
    base_url("comboposter/image_post/edit") => base_url("ultrapost"),
    base_url("comboposter/video_post/edit") => base_url("ultrapost"),
    base_url("comboposter/link_post/edit") => base_url("ultrapost"),
    base_url("comboposter/html_post/edit") => base_url("ultrapost"),

    base_url("comboposter/text_post/clone") => base_url("ultrapost"),
    base_url("comboposter/image_post/clone") => base_url("ultrapost"),
    base_url("comboposter/video_post/clone") => base_url("ultrapost"),
    base_url("comboposter/link_post/clone") => base_url("ultrapost"),
    base_url("comboposter/html_post/clone") => base_url("ultrapost"),

    base_url("blog/add_post") => base_url("blog/posts"),
    base_url("blog/edit_post") => base_url("blog/posts"),
    base_url("blog/tag") => base_url("blog/posts"),
    base_url("blog/category") => base_url("blog/posts"),

    base_url("menu_manager/custom_page") => "",
    base_url("gmb/posts") => base_url("gmb/campaigns"),
    base_url("gmb/create_post") => base_url("gmb/campaigns"),
    base_url("gmb/media_campaigns") => base_url("gmb/campaigns"),
    base_url("gmb/create_media_campaign") => base_url("gmb/campaigns"),
    base_url("gmb/rss") => base_url("gmb/campaigns"),
    base_url("gmb/edit_post") => base_url("gmb/campaigns"),
    base_url("gmb/edit_media_campaign") => base_url("gmb/campaigns"),


    base_url("payment/accounts") => base_url("integration"),
    base_url("social_apps") => base_url("integration"),
    base_url("comboposter/social_accounts") => base_url("integration"),
    base_url("email_auto_responder_integration") => base_url("integration"),
    base_url("messenger_bot_connectivity/json_api_connector") => base_url("integration"),
    base_url("sms_email_manager/sms_api_lists") => base_url("integration"),
    base_url("sms_email_manager/smtp_config") => base_url("integration"),
    base_url("sms_email_manager/mandrill_api_config") => base_url("integration"),
    base_url("sms_email_manager/sendgrid_api_config") => base_url("integration"),
    base_url("sms_email_manager/mailgun_api_config") => base_url("integration"),
    base_url("woocommerce_abandoned_cart") => base_url("integration"),
    base_url("woocommerce_integration") => base_url("integration")

);


$custom_links[base_url("payment/transaction_log_manual")] = base_url("payment/transaction_log");


$custom_links_assoc_str = "{";
$loop = 0;
foreach ($custom_links as $key => $value_links) {
    $loop++;
    array_push($all_links, $key); // adding custom urls in all urls array

    /* making associative link -> parent array for js, js dont support special chars */
    $custom_links_assoc_str .= str_replace(array('/', ':', '-', '.'), array('FORWARDSLASHES', 'COLONS', 'DASHES', 'DOTS'), $key) . ":'" . $value_links . "'";
    if ($loop != count($custom_links)) $custom_links_assoc_str .= ',';
}
$custom_links_assoc_str .= "}";
// echo "<pre style='padding-left:300px;'>";
// print_r($all_links);
// echo "</pre>"; 
?>

<!-- 

<script type="text/javascript">

  var all_links_JS = [<?php echo '"' . implode('","', $all_links) . '"' ?>]; // all urls includes database & custom urls
  var custom_links_JS= [<?php echo '"' . implode('","', array_keys($custom_links)) . '"' ?>]; // only custom urls
  var custom_links_assoc_JS = <?php echo $custom_links_assoc_str ?>; // custom urls associative array link -> parent

  var sideBarURL = window.location;
  sideBarURL=String(sideBarURL).trim();
  sideBarURL=sideBarURL.replace('#_=_',''); // redirct from facebook login return extra chars with url

  function removeUrlLastPart(the_url)   // function that remove last segment of a url
  {
      var theurl = String(the_url).split('/');
      theurl.pop();      
      var answer=theurl.join('/');
      return answer;
  }

  // get parent url of a custom url
  function matchCustomUrl(find)
  {
    var parentUrl='';
    var tempu1=find.replace(/\//g, 'FORWARDSLASHES'); // decoding special chars that was encoded to make js array
    tempu1=tempu1.replace(/:/g, 'COLONS');
    tempu1=tempu1.replace(/-/g, 'DASHES');
    tempu1=tempu1.replace(/\./g, 'DOTS');

    if(typeof(custom_links_assoc_JS[tempu1])!=='undefined')
    parentUrl=custom_links_assoc_JS[tempu1]; // getting parent value of custom link

    return parentUrl;
  }

  if(jQuery.inArray(sideBarURL, custom_links_JS) !== -1) // if the current link match custom urls
  {    
    sideBarURL=matchCustomUrl(sideBarURL);
  } 
  else if(jQuery.inArray(sideBarURL, all_links_JS) !== -1) // if the current link match known urls, this check is done later becuase all_links_JS also contains custom urls
  {
     sideBarURL=sideBarURL;
  }
  else // url does not match any of known urls
  {  
    var remove_times=1;
    var temp_URL=sideBarURL;
    var temp_URL2="";
    var tempu2="";
    while(true) // trying to match known urls by remove last part of url or adding /index at the last
    {
      temp_URL=removeUrlLastPart(temp_URL); // url may match after removing last
      temp_URL2=temp_URL+'/index'; // url may match after removing last part and adding /index

      if(jQuery.inArray(temp_URL, custom_links_JS) !== -1) // trimmed url match custom urls
      {
        sideBarURL=matchCustomUrl(temp_URL);
        break;
      }
      else if(jQuery.inArray(temp_URL, all_links_JS) !== -1) //trimmed url match known links
      {
        sideBarURL=temp_URL;
        break;
      }
      else // trimmed url does not match known urls, lets try extending url by adding /index
      {
        if(jQuery.inArray(temp_URL2, custom_links_JS) !== -1) // extended url match custom urls
        {
          sideBarURL=matchCustomUrl(temp_URL2);
          break;
        }
        else if(jQuery.inArray(temp_URL2, all_links_JS) !== -1)  // extended url match known urls
        {
          sideBarURL=temp_URL2;
          break;
        }
      }
      remove_times++;
      if(temp_URL.trim()=="") break;
    }    
  }

  $('ul.sidebar-menu a').filter(function() {
     return this.href == sideBarURL;
  }).parent().addClass('active');
  $('ul.dropdown-menu a').filter(function() {
     return this.href == sideBarURL;
  }).parentsUntil(".sidebar-menu > .dropdown-menu").addClass('active');
</script>
 -->