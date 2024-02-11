INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'Quotes',
    'Котировки онлайн',
    'Котировки онлайн',
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
    'Quotes',
    'Котировки онлайн',
    'modules/Quotes/Quotes.php',
    '8',
    'ru'
);

DROP TABLE IF EXISTS `mod_quotes`;
CREATE TABLE `mod_quotes`
(
    `quotes_id` INT(32) NOT NULL auto_increment,
    `short_name` VARCHAR(10) NOT NULL default '',
    `full_name` VARCHAR(1000) NOT NULL default '',
    `buy_amount` INT(16) NOT NULL default '0',
    `buy_price` VARCHAR(32) NOT NULL default '',
    `sell_amount` INT(16) NOT NULL default '0',
    `sell_price` VARCHAR(32) NOT NULL default '',
    PRIMARY KEY (`quotes_id`)
);