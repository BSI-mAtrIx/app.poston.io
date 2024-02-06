<?php
$show_debug = 0;
switch($current_verion){
    case 1;
        $n_db_version = 2;
        $this->save_vdb($n_db_version, $show_debug);

    case 2;
        $n_db_version = 3;

        $sql_cust ="ALTER TABLE `n_wa_bots` ADD `bsp_on` INT(1) NOT NULL DEFAULT '0';";
        $this->db->query($sql_cust);

        $this->save_vdb($n_db_version, $show_debug);

    case 3;
        $n_db_version = 4;

        $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->user_id]]);

        if(!isset($user_info[0]["n_credits"])){
            $sql_cust ="ALTER TABLE `users` ADD `n_credits` INT(11) NOT NULL DEFAULT '0';";
            $this->db->query($sql_cust);
        }

        $this->save_vdb($n_db_version, $show_debug);

    case 4;
        $n_db_version = 5;

        $sql_cust ="ALTER TABLE `n_wa_bots` ADD `allocation_config_id`  BIGINT(20) NOT NULL DEFAULT '0';";
        $this->db->query($sql_cust);

        $this->save_vdb($n_db_version, $show_debug);

    case 5;
        $n_db_version = 6;

        $sql_cust ="ALTER TABLE `n_wa_bots` ADD `min_cp_warning_email`  INT(11) NOT NULL DEFAULT '0';";
        $this->db->query($sql_cust);

        $this->save_vdb($n_db_version, $show_debug);

    case 6;
        $n_db_version = 7;

        $sql_cust ="ALTER TABLE `n_wa_bots` ADD `empty_cp_warning_email`  INT(11) NOT NULL DEFAULT '0';";
        $this->db->query($sql_cust);

        $this->save_vdb($n_db_version, $show_debug);

}