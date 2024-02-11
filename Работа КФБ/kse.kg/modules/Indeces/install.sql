INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'Indeces',
    'Индексы',
    'Отображает таблицу с индексами',
    '1',
    'indeces_handler.php',
    'indeces_view.html',
    'ru'
);

CREATE TABLE `mod_indeces` (
    `mod_indeces_id` INT(16) NOT NULL auto_increment,
    `name` VARCHAR(20) NOT NULL default '',
    `index` VARCHAR(32) NOT NULL default '',
    `percent` VARCHAR(32) NOT NULL default '',
    `change` TINYINT(1) NOT NULL default '0',
    `date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY(`mod_indeces_id`)
);