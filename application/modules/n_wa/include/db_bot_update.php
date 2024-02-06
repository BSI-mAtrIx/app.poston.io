<?php
switch($bot_current_version){
    case 1;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

//        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_user` ADD `username` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '';";
//        $this->db->query($sql_cust);

    case 2;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

//        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_user` ADD `notes` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '';";
//        $this->db->query($sql_cust);

    case 3;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_user` CHANGE `language_code` `language_code` CHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;";
        $this->db->query($sql_cust);

    case 4;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_wa_postback` CHANGE `type` `type` ENUM('keyword','command','trigger','condition','message','no_match') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;";
        $this->db->query($sql_cust);

    case 5;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="CREATE TABLE `nwa_".$bot_id."_messages` ( `chat_id` BIGINT(20) NOT NULL , `id` BIGINT(20) UNSIGNED NOT NULL , `user_id` BIGINT(20) NULL DEFAULT NULL , `date` TIMESTAMP NULL DEFAULT NULL , `text` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `entities` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `media` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `reply_markup` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL );";
        $this->db->query($sql_cust);

    case 6;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_messages` ADD UNIQUE(`chat_id`, `id`);";
        $this->db->query($sql_cust);

    case 7;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_messages` ADD PRIMARY KEY(`id`);";
        $this->db->query($sql_cust);

    case 8;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_messages` CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;";
        $this->db->query($sql_cust);

    case 9;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_user` ADD `state_human_agents_new` INT(1) NOT NULL DEFAULT '0', ADD `state_human_agents` INT(1) NOT NULL DEFAULT '0';";
        $this->db->query($sql_cust);

    case 10;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_user` ADD `entry_point` TINYTEXT NOT NULL DEFAULT '';";
        $this->db->query($sql_cust);

    case 11;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_messages`
         ADD `status` INT NULL DEFAULT NULL,
         ADD `status_error` TEXT NOT NULL DEFAULT '';";
        $this->db->query($sql_cust);

    case 12;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_messages` ADD `mess_id` TINYTEXT NOT NULL DEFAULT '';";
        $this->db->query($sql_cust);

    case 13;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="CREATE TABLE `nwa_".$bot_id."_conversations_stats` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `conv_id` VARCHAR(255) NOT NULL , `type` VARCHAR(50) NOT NULL , `status` INT(1) NOT NULL , `timestamp` INT(11) NOT NULL , `charged` INT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`));";
        $this->db->query($sql_cust);

    case 14;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_conversations_stats` ADD UNIQUE(`conv_id`);";
        $this->db->query($sql_cust);

    case 15;

        $bot_current_version = $bot_current_version+1;
        $this->save_bot_db($bot_current_version, $bot_id);

        $sql_cust ="ALTER TABLE `nwa_".$bot_id."_conversations_stats` ADD `price` FLOAT(11) NOT NULL, ADD `country` VARCHAR(255) NOT NULL;";
        $this->db->query($sql_cust);








}

$n_db_version = $bot_current_version;