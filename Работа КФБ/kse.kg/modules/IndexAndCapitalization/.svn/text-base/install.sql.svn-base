INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'IndexAndCapitalization',
    'Индекс и Капитализация',
    'Индекс и Капитализация',
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
    'IndexAndCapitalization',
    'Индекс и Капитализация',
    'modules/IndexAndCapitalization/IndexAndCapitalization.php',
    '8',
    'ru'
);

DROP TABLE IF EXISTS `mod_cap_index`;
CREATE TABLE `mod_cap_index`
(
    `cap_index_id` INT(16) NOT NULL auto_increment,
    `date` DATE NOT NULL default '0000-00-00',
    `index` VARCHAR(30) NOT NULL default '',
    `capitalization` VARCHAR(32) NOT NULL default '',
    PRIMARY KEY (`cap_index_id`)
);