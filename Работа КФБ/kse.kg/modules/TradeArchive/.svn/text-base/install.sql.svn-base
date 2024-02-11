INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'TradeArchive',
    'Архив торгов',
    'Архив торгов',
    '1',
    'tradearchive_handler.php',
    'tradearchive_view.html',
    'ru'
);
INSERT INTO `pages` (
    `page_uname`,
    `page_title`,
    `page_text`,
    `status`,
    `language`
) VALUES (
    'TradeArchive',
    'Архив торгов',
    'modules/TradeArchive/Archive.php',
    '8',
    'ru'
);

DROP TABLE IF EXISTS `mod_trade_archive`;
CREATE TABLE `mod_trade_archive`
(
    `trade_archive_id` INT(16) NOT NULL auto_increment,
    `total_volume` VARCHAR(30) NOT NULL default '',
    `sec_amount` INT(16) NOT NULL default '0',
    `deals_amount` INT(16) NOT NULL default '0',
    `primary_deals` VARCHAR(32) NOT NULL default '',
    `secondary_deals` VARCHAR(32) NOT NULL default '',
    `listing_trades` VARCHAR(32) NOT NULL default '',
    `nonlisting_trades` VARCHAR(32) NOT NULL default '',
    `month` TINYINT(2) NOT NULL default '0',
    `year` SMALLINT(4) NOT NULL default '0',
    PRIMARY KEY(`trade_archive_id`)
);