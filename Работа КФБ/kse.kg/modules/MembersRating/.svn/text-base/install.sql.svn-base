INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'MembersRating',
    'Рейтинг участников',
    'Рейтинг участников',
    '1',
    'members_rating_handler.php',
    'members_rating_view.html',
    'ru'
);
INSERT INTO `pages` (
    `page_uname`,
    `page_title`,
    `page_text`,
    `status`,
    `language`
) VALUES (
    'MembersRating',
    'Рейтинг участников',
    'modules/MembersRating/Rating.php',
    '8',
    'ru'
);

CREATE TABLE `members_rating_info` (
    `mr_id` INT(16) NOT NULL auto_increment,
    `company_name_short` VARCHAR(100) NOT NULL default '',
    `company_name_full` VARCHAR(300) NOT NULL default '',
    `volume` DECIMAL(20,2) NOT NULL default '0.0',
    `amount` INT(16) NOT NULL default '',
    `date` DATE NOT NULL default '0000-00-00',
    PRIMARY KEY(`mr_id`)
);