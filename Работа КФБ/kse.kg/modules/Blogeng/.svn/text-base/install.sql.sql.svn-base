CREATE TABLE `Blogs` (
    `blog_id` INT(16) NOT NULL auto_increment,
    `blog_name` VARCHAR(500) NOT NULL default '',
    `blog_title` VARCHAR(1000) NOT NULL default '',
    `owner` INT(16) NOT NULL default '0',
    `cr_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `creator` INT(16) NOT NULL default '0',
    PRIMARY KEY(`blog_id`)
);

DROP TABLE IF EXISTS `Blog_Entries`;
CREATE TABLE `Blog_Entries` (
    `blogentry_id` INT(16) NOT NULL auto_increment,
    `blog_id` INT(16) NOT NULL default '0',
    `name` VARCHAR(1000) NOT NULL default '',
    `title` VARCHAR(1000) NOT NULL default '',
    `text` LONGTEXT NOT NULL default '',
    `author` INT(16) NOT NULL default '0',
    `cr_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `status` TINYINT(1) NOT NULL default '0',
    PRIMARY KEY(`blogentry_id`)

);

