<?php $n_greetings = rand_welcome(); ?>

<li class="dropdown dropdown-user nav-item">
    <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
        <div class="user-nav d-sm-flex d-none">
            <?php
            if ($n_config['greetings_on'] == 'true') {
                if ($n_config['greetings_random'] == 'true') {
                    echo '<span data-toggle="tooltip" data-placement="left" 
    title="" 
    data-original-title="Greetings from ' . $n_greetings['country_name'] . '">' . $n_greetings['greeting'] . '</span>';
                } else {
                    echo '<span>' . $this->lang->line("hello") . '</span>';
                }
            }
            ?>
            <span class="user-name"><?php echo $this->session->userdata('username'); ?></span>
        </div>
        <span>
            <img class="round" src="<?php echo $this->session->userdata("brand_logo"); ?>" alt="avatar" height="40"
                 width="40">
        </span>
    </a>


    <div class="dropdown-menu dropdown-menu-right">
        <?php
        if ($n_config['n_credits_on'] == 'true') {
            $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]); ?>

        <h6 class="dropdown-header">
                <strong><?php echo $this->lang->line('Credits'); ?>:</strong> <span
                            id="user_menu_cp"><?php echo $user_info[0]["n_credits"]; ?></span> CP
            </h6>

            <div class="dropdown-divider"></div>
        <?php } ?>

        <h6 class="dropdown-header"><?php echo $this->config->item("product_short_name") . " - " . $this->lang->line($this->session->userdata("user_type")); ?></h6>



        <a href="<?php echo base_url('myprofile/edit_profile'); ?>" class="dropdown-item">
            <i class="bx bx-user mr-50"></i> <?php echo $this->lang->line("Profile"); ?>
        </a>
        <a href="<?php echo base_url('calendar/index'); ?>" class="dropdown-item">
            <i class="bx bx-timer mr-50"></i> <?php echo $this->lang->line("Activities"); ?>
        </a>

        <?php if ($this->basic->is_exist("add_ons", array("unique_name" => "api_documentation"))) : ?>
            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(285, $this->module_access)) : ?>
                <a href="<?php echo base_url('native_api/get_api_key'); ?>" class="dropdown-item">
                    <i class="bx bx-plug mr-50"></i> <?php echo $this->lang->line("API Key"); ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>


        <div class="dropdown-divider"></div>


        <h6 class="dropdown-header">
            <i class="bx bxl-facebook-square"></i>
            <?php echo $this->lang->line("Facebook Account"); ?>
        </h6>

        <?php $current_account = isset($fb_rx_account_switching_info[$this->session->userdata("facebook_rx_fb_user_info")]['name']) ? $fb_rx_account_switching_info[$this->session->userdata("facebook_rx_fb_user_info")]['name'] : $this->lang->line("No Account"); ?>

        <a class="dropdown-item has-icon active dont_hide_dropdown_fb" data-toggle="collapse" href="#collapseExampleFBA"
           role="button" aria-expanded="false" aria-controls="collapseExampleFBA">
            <?php echo $current_account; ?> (<?php echo $this->lang->line("Change"); ?>)
        </a>
        <div class="collapse" id="collapseExampleFBA">
            <?php
            foreach ($fb_rx_account_switching_info as $key => $value_fb_rx) {
                $selected = '';
                if ($key == $this->session->userdata("facebook_rx_fb_user_info")) $selected = 'd-none';
                echo '<a href="" data-id="' . $key . '" class="dropdown-item account_switch ' . $selected . '"><i class="bx bx-toggle-right"></i> ' . $value_fb_rx['name'] . '</a>';
            }
            ?>
        </div>

        <!-- for gmb add-on -->
        <?php if ($gmb_addon_access == 'yes') : ?>
            <div class="dropdown-divider"></div>

            <h6 class="dropdown-header"><i
                        class="bx bx-power-off mr-50"></i> <?php echo $this->lang->line("GMB Account"); ?></h6>
            <?php $current_account = isset($gmb_account_switching_info[$this->session->userdata("google_mybusiness_user_table_id")]) ? $gmb_account_switching_info[$this->session->userdata("google_mybusiness_user_table_id")] : $this->lang->line("No Account"); ?>

            <a class="dropdown-item active dont_hide_dropdown_gmb" data-toggle="collapse" href="#collapseExampleGMB"
               role="button" aria-expanded="false" aria-controls="collapseExampleGMB">
                <?php echo $current_account; ?> (<?php echo $this->lang->line("Change"); ?>)
            </a>
            <div class="collapse" id="collapseExampleGMB">
                <?php
                foreach ($gmb_account_switching_info as $key => $value_gmb) {
                    $selected = '';
                    if ($key == $this->session->userdata("google_mybusiness_user_table_id")) $selected = 'd-none';
                    echo '<a href="" data-id="' . $key . '" class="dropdown-item gmb_account_switch ' . $selected . '"><i class="bx bx-toggle-right"></i> ' . $value_gmb . '</a>';
                }
                ?>
            </div>
        <?php endif; ?>
        <!-- end of gmb add-on -->

        <div class="dropdown-divider"></div>

        <a href="<?php echo base_url('change_password/reset_password_form'); ?>" class="dropdown-item">
            <i class="bx bx-key mr-50"></i> <?php echo $this->lang->line("Change Password"); ?>
        </a>

        <a href="<?php echo base_url('home/logout'); ?>" class="dropdown-item">
            <i class="bx bx-power-off mr-50"></i> <?php echo $this->lang->line("Logout"); ?>
        </a>


    </div>
</li>