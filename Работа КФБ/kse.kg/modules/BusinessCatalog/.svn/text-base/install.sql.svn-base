INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'BusinessCatalog',
    'Бизнес каталог',
    'Бизнес каталог',
    '1',
    'business_catalog_handler.php',
    'business_catalog_view.html',
    'ru'
);

DROP TABLE IF EXISTS `mod_bc_entries`;
CREATE TABLE `mod_bc_entries` (
    `entry_id` INT(16) NOT NULL auto_increment,
    `name` VARCHAR(1000) NOT NULL default '',
    `group` VARCHAR(100) NOT NULL default '',
    `title` VARCHAR(1000) NOT NULL default '',
    `description` TEXT NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY(`entry_id`)
);
