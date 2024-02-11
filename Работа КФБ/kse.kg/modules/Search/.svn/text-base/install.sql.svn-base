SET NAMES utf8;

DROP TABLE IF EXISTS `ls_categories`;
CREATE TABLE `ls_categories`
(
    `ls_cat_id` INT(16) NOT NULL auto_increment,
    `ls_full_name` VARCHAR(500) NOT NULL default '',
    `ls_short_name` VARCHAR(5) NOT NULL default '',
    PRIMARY KEY (`ls_cat_id`)
);

DROP TABLE IF EXISTS `ls_companies`;
CREATE TABLE `ls_companies`
(
    `ls_company_id` INT(16) NOT NULL auto_increment,
    `ls_company_name` VARCHAR(500) NOT NULL default '',
    `ls_cat_id` INT(16) NOT NULL default '0',
    `security` VARCHAR(200) NOT NULL default '',
    `sphere` VARCHAR(500) NOT NULL default '',
    `activity` VARCHAR(500) NOT NULL default '',
    `cr_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `owner` VARCHAR(1000) NOT NULL default '',
    `owner_position` VARCHAR(300) NOT NULL default '',
    `address`  VARCHAR(1000) NOT NULL default '',
    `phone`  VARCHAR(1000) NOT NULL default '',
    `auditor`  VARCHAR(1000) NOT NULL default '',
    `registrar` VARCHAR(1000) NOT NULL default '',
    `marketmaker` VARCHAR(1000) NOT NULL default '',
    PRIMARY KEY(`ls_company_id`)
);

DROP TABLE IF EXISTS `ls_info`;
CREATE TABLE `ls_info` (
    `ls_info_id` INT(16) NOT NULL auto_increment,
    `ls_company_id` INT(16) NOT NULL default '0',
    `last_price` VARCHAR(32) NOT NULL default '',
    `capitalization` VARCHAR(32) NOT NULL default '',
    `securities_amount` INT(16) NOT NULL default '0',
    PRIMARY KEY (`ls_info_id`)
);

DROP TABLE IF EXISTS `ls_trade_symbols`;
CREATE TABLE `ls_trade_symbols`
(
    `ls_ts_id` INT(16) NOT NULL auto_increment,
    `ls_company_id` INT(16) NOT NULL default '0',
    `trade_symbol` VARCHAR(20) NOT NULL default '',
    PRIMARY KEY(`ls_ts_id`)
);

DROP TABLE IF EXISTS `ls_securities`;
CREATE TABLE `ls_securities` (
    `ls_sec_id` INT(16) NOT NULL auto_increment,
    `ls_company_id` INT(16) NOT NULL default '0',
    `type` VARCHAR(300) NOT NULL default '',
    `num_of_emissions` INT(5) NOT NULL default '0',
    `num_of_securities` INT(16) NOT NULL default '0',
    `rate` VARCHAR(30) NOT NULL default '',
    `total` VARCHAR(30) NOT NULL default '',
    PRIMARY KEY (`ls_sec_id`)
);

DROP TABLE IF EXISTS `ls_reports`;
CREATE TABLE `ls_reports` (
    `ls_report_id` INT(16) NOT NULL auto_increment,
    `type` ENUM ('balance', 'prospect', 'fin_rep', 'cash_flow', 'cap_rep', 'news', 'analytics'),
    `filetype` VARCHAR(20) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `upload_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `report_date` DATE NOT NULL default '0000-00-00',
    `filepath` VARCHAR(1000) NOT NULL default '',
    `ls_company_id` INT(16) NOT NULL default '0',
    `language` VARCHAR(5) NOT NULL default '',
    PRIMARY KEY(`ls_report_id`)
);

INSERT INTO `modules` (`name`, `title`, `description`, `status`, `main_handler`, `main_view`, `language`) VALUES (
'Listing', 'Листинг', 'Листинг', '1', 'listing_handler.php', 'listing_view.html', 'ru'
);
INSERT INTO `pages` (
    `page_uname`,
    `page_title`,
    `page_text`,
    `status`,
    `language`
) VALUES (
    'ListingDetails',
    'Листинговый проспект',
    'modules/Listing/Details.php',
    '8',
    'ru'
);

