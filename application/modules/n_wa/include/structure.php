<?php
$sql_cust = array();

$sql_cust[] = "CREATE TABLE IF NOT EXISTS `nwa_".$new_bot_id."_wa_postback` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `unique_id` VARCHAR(100) NOT NULL , `type` ENUM('keyword','command','trigger','condition') NOT NULL , `keyword` VARCHAR(255) NOT NULL , `command` VARCHAR(255) NOT NULL , `message` TEXT NOT NULL , `is_survey` INT(1) NOT NULL , `config` TEXT NOT NULL , UNIQUE (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` ADD `prev_id` VARCHAR(255) NOT NULL AFTER `config`, ADD `next_id` VARCHAR(255) NOT NULL AFTER `prev_id`;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` ADD `active` INT(1) NOT NULL AFTER `next_id`;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` ADD key(`keyword`);";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` ADD key(`command`);";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` ADD key(`active`);";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` CHANGE `type` `type` ENUM('keyword','command','trigger','condition','message') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` CHANGE `prev_id` `prev_id` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` CHANGE `next_id` `next_id` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` ADD `node_id` INT NOT NULL AFTER `active`, ADD UNIQUE (`node_id`);";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_wa_postback` ADD `STAT_SENT` INT(11) NOT NULL AFTER `node_id`;";

$sql_cust[] = "CREATE TABLE IF NOT EXISTS `nwa_".$new_bot_id."_labels` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `label_name` VARCHAR(255) NOT NULL , UNIQUE (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";

$sql_cust[] = "CREATE TABLE IF NOT EXISTS `nwa_".$new_bot_id."_user` ( `id` BIGINT(20) NOT NULL , `first_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL , `last_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `language_code` CHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `created_at` TIMESTAMP NULL DEFAULT NULL , `updated_at` TIMESTAMP NULL DEFAULT NULL , `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `phone` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `address` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL , `current_step` INT(11) NOT NULL DEFAULT '0' , `labels` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '' , `npoints` INT(11) NOT NULL DEFAULT '0' , UNIQUE (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_user` ADD `username` VARCHAR(255) NOT NULL AFTER `npoints`;";

$sql_cust[] = "ALTER TABLE `nwa_".$new_bot_id."_user` ADD `notes` TEXT NOT NULL AFTER `username`;";




