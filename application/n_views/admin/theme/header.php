<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-light">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon bx bx-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <?php


                        if ($this->session->userdata('user_type') != 'Admin') {
                            $n_package = $this->session->userdata('package_info');
                            if (
                                ($this->session->userdata('license_type') == 'double'
                                    and isset($n_package['price'])
                                    and strtolower($n_package['price']) == 'trial'
                                    and $n_config['show_renew_button'] == 'true')
                                or
                                ($this->session->userdata('license_type') == 'double'
                                    and is_numeric(strtotime($this->session->userdata('expiry_date')))
                                    and strtotime($this->session->userdata('expiry_date')) - time() < (int)$n_config['show_renew_button_days'] * 24 * 60 * 60
                                    //and strtotime($this->session->userdata('expiry_date')) - time() > 0
                                    and $n_config['show_renew_button'] == 'true')
                            ) { ?>

                                <li class="nav-item d-none d-lg-block"><a class="btn btn-success"
                                                                          href="<?php echo base_url('payment/buy_package'); ?>"><i
                                                class="bx bx-package"></i><span
                                                class="align-middle ml-25"><?php echo $this->lang->line("renew package"); ?></span></a>
                                </li>

                            <?php }
                        } ?>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="nav-item nav-search"><a class="nav-link nav-link-search"
                                                       style="padding: 1.5rem 0.2rem 1.15rem 0.2rem;"><i
                                    class="ficon bx bx-search"></i></a>
                        <div class="search-input">
                            <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                            <input class="input" type="text" placeholder="<?php echo $this->lang->line('search'); ?>"
                                   tabindex="-1" data-search="template-search">
                            <div class="search-input-close"><i class="bx bx-x"></i></div>
                            <ul class="search-list"></ul>
                        </div>
                    </li>
                    <li class="dropdown dropdown-language nav-item <?php if ($n_config['show_lang_selector'] == 'false') {
                        echo 'd-none';
                    } ?>">

                        <?php $flag_current = LangToCode($current_language, $n_config); ?>
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="flag-icon flag-icon-<?php echo $flag_current; ?>"></i>
                            <span class="selected-language"><?php echo $current_language; ?></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            <?php
                            ksort($language_info);
                            foreach ($language_info as $key_lang => $value_lang) {
                                $selected = '';
                                // if($key==$this->session->userdata("facebook_rx_fb_user_info")) $selected='active';
                                //var_dump($value);
                                $flag = LangToCode($value_lang, $n_config);


                                echo '
                                    <a class="dropdown-item language_switch" href="#" data-id="' . $key_lang . '" data-language="' . $key_lang . '" ' . $selected . '><i class="flag-icon flag-icon-' . $flag . ' mr-50"></i> ' . $value_lang . '</a>
                                    ';
                            }
                            ?>
                        </div>


                    </li>
                    <li class="nav-item d-block" style="padding: 1rem 0.2rem 1.15rem 0.2rem"><a
                                class="nav-link layout-name"><i class="ficon bx bx-moon"></i></a></li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon bx bx-fullscreen"></i></a></li>
                    <!--                        <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon bx bx-search"></i></a>-->
                    <!--                            <div class="search-input">-->
                    <!--                                <div class="search-input-icon"><i class="bx bx-search primary"></i></div>-->
                    <!--                                <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="starter-list">-->
                    <!--                                <div class="search-input-close"><i class="bx bx-x"></i></div>-->
                    <!--                                <ul class="search-list"></ul>-->
                    <!--                            </div>-->
                    <!--                        </li>-->
                    <li class="dropdown dropdown-notification nav-item" style="padding: 1rem 0.2rem 1.15rem 0.2rem"><a
                                class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i
                                    class="ficon bx bx-bell"></i>
                            <?php if (count($annoucement_data) > 0) { ?>
                                <span class="badge badge-pill badge-primary badge-up"><?php echo count($annoucement_data); ?></span>
                            <?php } ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span
                                            class="notification-title"><?php echo count($annoucement_data) . " " . $this->lang->line("New"); ?><?php echo $this->lang->line('Notifications'); ?></span>
                                    <!--                                        <span class="text-bold-400 cursor-pointer">Mark all as read</span>-->
                                </div>
                            </li>
                            <?php foreach ($annoucement_data as $row) { ?>

                                <li class="scrollable-container media-list">
                                    <a class="d-flex justify-content-between"
                                       href="<?php echo site_url() . 'announcement/details/' . $row['id']; ?>">
                                        <div class="media d-flex align-items-center">
                                            <!--                                            <div class="media-left pr-0 -->
                                            <?php //echo "bg-".$row['color_class']; ?><!--">-->
                                            <!--                                                <div class="avatar mr-1 m-0"><i class="-->
                                            <?php //echo $row['icon']; ?><!--"></i></div>-->
                                            <!--                                            </div>-->
                                            <div class="media-body">
                                                <h6 class="media-heading"><span class="text-bold-500"> <?php
                                                    if (strlen($row['title']) > 50)
                                                        echo substr($row['title'], 0, 50) . "...";
                                                    else echo $row['title'];
                                                    ?></h6><small
                                                        class="notification-text"><?php echo date_time_calculator($row['created_at'], true); ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            <?php } ?>
                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item p-50 text-primary justify-content-center"
                                   href="<?php echo site_url() . 'announcement/full_list'; ?>"><?php echo $this->lang->line('View all'); ?></a>
                            </li>


                        </ul>
                    </li>

                    <?php
                    if ($this->session->userdata('license_type') == 'double') {
                        if ($this->config->item('enable_support') == '1') {
                            $result_sup = $this->basic->execute_query('SELECT * FROM fb_simple_support_desk WHERE last_replied_at > last_action_at AND last_replied_by != user_id AND user_id =' . $this->user_id);

                            $support_menu = $this->lang->line("Support Desk");
                            $support_url = base_url('simplesupport/tickets'); ?>

                            <li class="dropdown nav-item d-block" style="padding: 1rem 0.2rem 1.15rem 0.2rem">
                                <a class="nav-link" href="#" data-toggle="dropdown">
                                    <i class="ficon bx bx-support"></i>
                                    <?php if (count($result_sup) > 0) { ?>
                                        <span class="badge badge-pill badge-primary badge-up mt-1"><?php echo count($result_sup); ?></span>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span
                                                    class="notification-title"><?php echo count($result_sup) . " " . $this->lang->line("New"); ?><?php echo $this->lang->line('reply ticket'); ?></span>
                                            <!--                                        <span class="text-bold-400 cursor-pointer">Mark all as read</span>-->
                                        </div>
                                    </li>
                                    <?php foreach ($result_sup as $row) { ?>

                                        <li class="scrollable-container media-list">
                                            <a class="d-flex justify-content-between"
                                               href="<?php echo site_url() . 'simplesupport/reply/' . $row['id']; ?>">
                                                <div class="media d-flex align-items-center">
                                                    <div class="media-body">
                                                        <h6 class="media-heading"><span class="text-bold-500"> <?php
                                                            if (strlen($row['ticket_title']) > 50)
                                                                echo substr($row['ticket_title'], 0, 50) . "...";
                                                            else echo $row['ticket_title'];
                                                            ?></h6><small
                                                                class="notification-text"><?php echo date_time_calculator($row['last_replied_at'], true); ?></small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                    <?php } ?>
                                    <li class="dropdown-menu-footer">
                                        <a class="dropdown-item p-50 text-primary justify-content-center"
                                           href="<?php echo $support_url; ?>"><?php echo $this->lang->line('View all'); ?></a>
                                    </li>


                                </ul>
                            </li>
                        <?php }
                    } ?>


                    <?php if (file_exists(APPPATH . 'modules/n_task/controllers/N_task.php') and !file_exists(APPPATH . 'modules/n_task/install.txt')) {
                        $result_task = $this->basic->execute_query('SELECT * FROM tasks WHERE isnull(task_date_closed) AND task_due_date < NOW() + INTERVAL 3 DAY AND task_due_date > 1  AND user_id =' . $this->user_id . ' ORDER BY task_due_date ASC limit 10');

                        ?>


                        <li class="dropdown nav-item" style="padding: 1rem 0.2rem 1.15rem 0.2rem">
                            <a class="nav-link" href="#" data-toggle="dropdown">
                                <i class="ficon bx bx-task"></i>
                                <?php if (count($result_task) > 0) { ?>
                                    <span class="badge badge-pill badge-primary badge-up mt-1"><?php echo count($result_task); ?></span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span
                                                class="notification-title"><?php echo count($result_task) . " " . $this->lang->line("Tasks upcoming"); ?></span>
                                        <!--                                        <span class="text-bold-400 cursor-pointer">Mark all as read</span>-->
                                    </div>
                                </li>
                                <?php foreach ($result_task as $row) {
                                    $board_id = $this->basic->execute_query('SELECT container_board FROM containers WHERE container_id =' . $row['task_container'] . ' LIMIT 1');
                                    if (!empty($board_id)) {
                                        $nbid = $board_id[0]['container_board'];
                                    } else {
                                        continue;
                                        $nbid = '';
                                    }

                                    ?>

                                    <li class="scrollable-container media-list">
                                        <a class="d-flex justify-content-between"
                                           href="<?php echo site_url() . 'task/board/' . $nbid; ?>">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500"> <?php
                                                        if (strlen($row['task_title']) > 50)
                                                            echo substr($row['task_title'], 0, 50) . "...";
                                                        else echo $row['task_title'];
                                                        ?></h6><small
                                                            class="notification-text <?php if (date('Y-m-d', strtotime($row['task_due_date'])) < date('Y-m-d')) : ?>text-danger<?php endif; ?>"><i
                                                                class="bx bx-calendar font-size-small mr-25"></i>
                                                        <span class="font-size-small"><?php echo ($row['task_due_date'] != 0) ? date('M d', strtotime($row['task_due_date'])) : null; ?></span></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                <?php } ?>
                                <li class="dropdown-menu-footer">
                                    <a class="dropdown-item p-50 text-primary justify-content-center"
                                       href="<?php echo base_url('task/'); ?>"><?php echo $this->lang->line('View all'); ?></a>
                                </li>


                            </ul>
                        </li>
                    <?php }
                    include(FCPATH . 'application/n_views/admin/theme/usermenu.php'); ?>


                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->


<!--
    <?php //include(FCPATH.'application/views/admin/theme/notification.php'); ?>
    <?php //include(FCPATH.'application/views/admin/theme/usermenu.php'); ?>  
 -->

