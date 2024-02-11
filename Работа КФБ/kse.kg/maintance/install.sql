SET NAMES utf8;

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
    `language_id` INT(16) NOT NULL auto_increment,
    `language_name` VARCHAR(200) NOT NULL default '',
    `language_code_long` VARCHAR(10) NOT NULL default '',
    `language_code_short` VARCHAR(3) NOT NULL default '',
    `language_file` VARCHAR(200) NOT NULL default '',
    PRIMARY KEY(`language_id`)
);

INSERT INTO `languages` (
    `language_name`, `language_code_long`, `language_code_short`, `language_file`
) VALUES ('Русский', 'ru_RU', 'ru', 'ru_RU.php');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
    `cat_id` INT(16) NOT NULL auto_increment,
    `category_name` VARCHAR(300) NOT NULL default '',
    `language` VARCHAR(3) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    PRIMARY KEY(`cat_id`)
);

INSERT INTO `categories` (`category_name`, `language`, `status`) VALUES (
    'Административная', 'ru', '1'
);

INSERT INTO `categories` (`category_name`, `language`, `status`) VALUES (
    'Общая', 'ru', '1'
);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
    `page_id` INT(16) NOT NULL auto_increment,
    `page_uname` VARCHAR(300) NOT NULL default '',
    `page_title` VARCHAR(500) NOT NULL default '',
    `page_text` LONGTEXT NOT NULL default '',
    `creator` INT(16) NOT NULL default '0',
    `cr_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `cr_ip` VARCHAR(21) NOT NULL default '',
    `update_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `update_ip` VARCHAR(21) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `category` INT(16) NOT NULL default '0',
    `language` VARCHAR(3) NOT NULL default '',
    PRIMARY KEY(`page_id`)
);

INSERT INTO `pages` (`page_id`, `page_uname`, `page_title`, `page_text`, `status`, `category`, `language`)
VALUES ('1', 'login', 'Вход в систему', 'login_page.html', '4', '2', 'ru');
INSERT INTO `pages` (`page_id`, `page_uname`, `page_title`, `page_text`, `status`, `category`, `language`)
VALUES ('2', 'NewPage', 'Новая страница', 'new_page.html', '4', '1', 'ru');
INSERT INTO `pages` (`page_id`, `page_uname`, `page_title`, `page_text`, `status`, `category`, `language`)
VALUES ('3', 'EditPage', 'Правка страницы', 'edit_page.html', '4', '1', 'ru');
INSERT INTO `pages` (`page_id`, `page_uname`, `page_title`, `page_text`, `status`, `category`, `language`)
VALUES ('4', 'RenamePage', 'Переименовать страницу', 'page_rename.html', '4', '1', 'ru');
INSERT INTO `pages` (`page_id`, `page_uname`, `page_title`, `page_text`, `status`, `category`, `language`)
VALUES ('5', 'HidePage', 'Скрыть страницу', 'page_hide.html', '4', '1', 'ru');
INSERT INTO `pages` (`page_id`, `page_uname`, `page_title`, `page_text`, `status`, `category`, `language`)
VALUES ('6', 'Register', 'Регистрация', 'register_page.html', '4', '1', 'ru');

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE `attachments` (
    `attachment_id` INT(16) NOT NULL auto_increment,
    `filename` VARCHAR(500) NOT NULL default '',
    `filepath` VARCHAR(500) NOT NULL default '',
    `filesize` INT(16) NOT NULL default '0',
    `name` VARCHAR(500) NOT NULL default '',
    `mime` VARCHAR(500) NOT NULL default '',
    `hashname` VARCHAR(32) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `cr_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `description` VARCHAR(1000) NOT NULL default '',
    PRIMARY KEY (`attachment_id`)
);

DROP TABLE IF EXISTS `page_attachments`;
CREATE TABLE `page_attachments` (
    `p_atta_id` INT (16) NOT NULL auto_increment,
    `attachment_id` INT(16) NOT NULL default '0',
    `page_id` INT(16) NOT NULL default '0',
    PRIMARY KEY (`p_atta_id`)
);

DROP TABLE IF EXISTS `page_handlers`;
CREATE TABLE `page_handlers`(
    `phid` INT(16) NOT NULL auto_increment,
    `page_id` INT(16) NOT NULL default '0',
    `handler` VARCHAR(200) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    PRIMARY KEY(`phid`)
);

DROP TABLE IF EXISTS `page_extensions`;
CREATE TABLE `page_extensions` (
    `page_ext_id` INT(16) NOT NULL auto_increment,
    `page_id` INT(16) NOT NULL default '0',
    `ext_file` VARCHAR(1000) NOT NULL default '',
    PRIMARY KEY(`page_ext_id`)
);

INSERT INTO `page_handlers` (`page_id`, `handler`, `status`) VALUES (
    '2', 'newpage.php', '1'
);
INSERT INTO `page_handlers` (`page_id`, `handler`, `status`) VALUES (
    '3', 'editpage.php', '1'
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `uid` INT(16) NOT NULL auto_increment,
    `login` VARCHAR(200) NOT NULL default '',
    `email` VARCHAR(200) NOT NULL default '',
    `password` VARCHAR(32) NOT NULL default '',
    `reg_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `reg_ip` VARCHAR(21) NOT NULL default '',
    `hash` VARCHAR(32) NOT NULL default '',
    `level` TINYINT(2) NOT NULL default '0',
    PRIMARY KEY(`uid`)
);

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details`
(
    `udid`  INT(16) NOT NULL auto_increment,
    `uid` INT(16) NOT NULL default '0',
    PRIMARY KEY(`udid`)
);

INSERT INTO `users` (`login`, `email`, `password`, `level`) VALUES ('admin', 'admin@localhost', MD5('admin'), '99');

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
    `gid` INT(16) NOT NULL auto_increment,
    `name` VARCHAR(1000) NOT NULL default '',
    `title` VARCHAR(1000) NOT NULL default '',
    `level` TINYINT(2) NOT NULL default '0',
    PRIMARY KEY(`gid`)
);

DROP TABLE IF EXISTS `group_membership`;
CREATE TABLE `group_membership` (
    `gmid` INT(16) NOT NULL auto_increment,
    `gid` INT(16) NOT NULL default '0',
    `uid` INT(16) NOT NULL default '0',
    `level` TINYINT(2) NOT NULL default '0',
    PRIMARY KEY(`gmid`)
);

DROP TABLE IF EXISTS `page_access`;
CREATE TABLE `page_access` (
    `pa_id` INT(16) NOT NULL auto_increment,
    `page_id` INT(16) NOT NULL default '0',
    `min_level` TINYINT(2) NOT NULL default '0',
    PRIMARY KEY(`pa_id`)
);

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
    `sid` INT(16) NOT NULL auto_increment,
    `hash` VARCHAR(32) NOT NULL default '',
    `uid` INT(16) NOT NULL default '0',
    `last_activity` DATETIME NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY(`sid`)
);

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
    `mid` INT(16) NOT NULL auto_increment,
    `name` VARCHAR(200) NOT NULL default '',
    `title` VARCHAR(500) NOT NULL default '',
    `description` TEXT NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `main_handler` VARCHAR(200) NOT NULL default '',
    `main_view` VARCHAR(200) NOT NULL default '',
    `language` VARCHAR(3) NOT NULL default '',
    PRIMARY KEY(`mid`)
);

INSERT INTO `modules` (`mid`, `name`, `title`, `description`, `status`, `main_handler`, `main_view`, `language`) VALUES
('1', 'HelloWorld', 'Hello World Module', 'Experimental module', 1, 'hw_handler.php', 'hw_view.html', 'ru');

INSERT INTO `modules` (`mid`, `name`, `title`, `description`, `status`, `main_handler`, `main_view`, `language`) VALUES
('2', 'Blog', 'Blog', 'Blog is a good place for blogging or news feeds', 1, 'blog_handler.php', 'blog_view.html', 'ru');


DROP TABLE IF EXISTS `modules_applied`;
CREATE TABLE `modules_applied` (
    `mappid` INT(16) NOT NULL auto_increment,
    `mid` INT(16) NOT NULL default '0',
    `page_id` INT(16) NOT NULL default '0',
    `phrase` VARCHAR(200) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    PRIMARY KEY(`mappid`)
);

DROP TABLE IF EXISTS `modules_parameters`;
CREATE TABLE `modules_parameters` (
    `mod_param_id` INT(16) NOT NULL auto_increment,
    `mappid` INT(16) NOT NULL default '0',
    `name` VARCHAR(200) NOT NULL default '',
    `value` VARCHAR(500) NOT NULL default '',
    PRIMARY KEY(`mod_param_id`)
);

DROP TABLE IF EXISTS `views`;
CREATE TABLE `views` (
    `views_id` INT(16) NOT NULL auto_increment,
    `name` VARCHAR(200) NOT NULL default '',
    `title` VARCHAR(520) NOT NULL default '',
    `description` TEXT NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `inner_page` VARCHAR(200) NOT NULL default '',
    `inner_page_attachment` VARCHAR(200) NOT NULL default '',
    PRIMARY KEY(`views_id`)
);

DROP TABLE IF EXISTS `views_pages`;
CREATE TABLE `views_pages`
(
    `views_pages_id` INT(16) NOT NULL auto_increment,
    `views_name` VARCHAR(200) NOT NULL default '',
    `page_name` VARCHAR(200) NOT NULL default '',
    PRIMARY KEY(`views_pages_id`)
);

INSERT INTO `views` (`views_id`, `name`, `title`, `status`) VALUES (
    '1', 'default', 'Default template', '0');
INSERT INTO `views` (`views_id`, `name`, `title`, `status`) VALUES (
    '2', 'kse', 'Kyrgyz Stock Exchange', '1');
