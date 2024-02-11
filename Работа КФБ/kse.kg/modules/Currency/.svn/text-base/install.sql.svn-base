INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'Currency',
    'Курс валют',
    'Курс валют',
    '1',
    'currency_handler.php',
    'currency_view.html',
    'ru'
);

DROP TABLE IF EXISTS `mod_currency`;
CREATE TABLE `mod_currency` (
    `mod_currency_id` INT(16) NOT NULL auto_increment,
    `date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `currency` VARCHAR(10) NOT NULL default '',
    `currency_name` VARCHAR(32) NOT NULL default '',
    `rate` VARCHAR(32) NOT NULL default '',
    `flag` VARCHAR(32) NOT NULL default '',
    `change_percent` VARCHAR(32) NOT NULL default '',
    PRIMARY KEY(`mod_currency_id`)
);