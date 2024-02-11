DROP TABLE IF EXISTS `mod_tradestat`;
CREATE TABLE `mod_tradestat` (
    `ts_result_id` INT(30) NOT NULL auto_increment,
    `day` INT(2) NOT NULL default '0',
    `month` INT(2) NOT NULL default '0',
    `year` INT(4) NOT NULL default '0',
    `full_date` DATETIME NOT NULL default '0000-00-00',
    `total_volume` VARCHAR(30) NOT NULL default '',
    `total_volume_percent` VARCHAR(30) NOT NULL default '',
    `total_volume_change` TINYINT(1) NOT NULL default '0',
    `primary` VARCHAR(30) NOT NULL default '',
    `primary_percent` VARCHAR(30) NOT NULL default '',
    `primary_change` TINYINT(1) NOT NULL default '0',
    `secondary` VARCHAR(30) NOT NULL default '',
    `secondary_percent` VARCHAR(30) NOT NULL default '',
    `secondary_change` TINYINT(1) NOT NULL default '0',
    `listing` VARCHAR(30) NOT NULL default '',
    `listing_percent` VARCHAR(30) NOT NULL default '',
    `listing_change` TINYINT(1) NOT NULL default '0',
    `non_listing` VARCHAR(30) NOT NULL default '',    
    `non_listing_percent` VARCHAR(30) NOT NULL default '',
    `non_listing_change` TINYINT(1) NOT NULL default '0',
    PRIMARY KEY (`ts_result_id`)
);

INSERT INTO `modules` (`name`, `title`, `description`, `status`, `main_handler`, `main_view`, `language`) VALUES (
'Tradestat', 'Статистика торгов', 'Статистика торгов', '1', 'tradestat_handler.php', 'tradestat_view.html', 'ru'
);