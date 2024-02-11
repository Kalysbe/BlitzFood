INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'BuySellOrders',
    'Покупка/продажа ЦБ',
    'Покупка/продажа ЦБ',
    '1',
    'buysell_handler.php',
    'buysell_view.html',
    'ru'
);
INSERT INTO `pages` (
    `page_uname`,
    `page_title`,
    `page_text`,
    `status`,
    `language`
) VALUES (
    'BuySellOrders',
    'Покупка/Продажа ЦБ',
    'modules/BuySellOrders/bs.php',
    '8',
    'ru'
);

DROP TABLE IF EXISTS `mod_bs_archive`;
CREATE TABLE `mod_bs_archive` (
    `bs_id` INT(16) NOT NULL auto_increment,
    `operation` ENUM('buy', 'sell'),
    `amount` VARCHAR(300) NOT NULL default '',
    `company` VARCHAR(500) NOT NULL default '',
    `price` VARCHAR(500) NOT NULL default '',
    `text` TEXT NOT NULL default '',
    `date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `ip` VARCHAR(15) NOT NULL default '',
    `agent` VARCHAR(1000) NOT NULL default '',
    PRIMARY KEY (`bs_id`)
);

DROP TABLE IF EXISTS `mod_bs_recipients`;
CREATE TABLE `mod_bs_recipients` (
    `bs_rec_id` INT(16) NOT NULL auto_increment,
    `email` VARCHAR(500) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    PRIMARY KEY (`bs_rec_id`)
);