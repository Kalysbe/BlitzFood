INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'FinMarket',
    'Финансовый рынок.KG',
    'Еженедельник Финансовый рынок.KG',
    '1',
    'finmarket_handler.php',
    'finmarket_view.html',
    'ru'
);
INSERT INTO `pages` (
    `page_uname`,
    `page_title`,
    `page_text`,
    `status`,
    `language`
) VALUES (
    'FinMarket',
    'Финансовый рынок.KG',
    'modules/FinMarket/FinMarket.php',
    '8',
    'ru'
);

CREATE TABLE `mod_fin_market` (
    `fin_market_id` INT(16) NOT NULL auto_increment,
    `filepath` VARCHAR(300) NOT NULL default '',
    `filesize` INT(16) NOT NULL default '0',
    `title` VARCHAR(1000) NOT NULL default '',
    `description` TEXT NOT NULL default '',
    `date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY(`fin_market_id`)
);