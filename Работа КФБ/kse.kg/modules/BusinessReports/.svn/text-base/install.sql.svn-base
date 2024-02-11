INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'BusinessReports',
    'BusinessReports',
    'BusinessReports',
    '1',
    'business_reports_handler.php',
    'business_reports_view.html',
    'ru'
);

DROP TABLE IF EXISTS `brep_companies`;
CREATE TABLE `brep_companies`
(
    `brep_company_id` INT(16) NOT NULL auto_increment,
    `brep_company_name` VARCHAR(500) NOT NULL default '',
    `title` VARCHAR(500) NOT NULL default '',
    `sphere` VARCHAR(500) NOT NULL default '',
    `activity` VARCHAR(500) NOT NULL default '',
    `cr_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `owner` VARCHAR(1000) NOT NULL default '',
    `owner_position` VARCHAR(300) NOT NULL default '',
    `address`  VARCHAR(1000) NOT NULL default '',
    `phone`  VARCHAR(1000) NOT NULL default '',
    `auditor`  VARCHAR(1000) NOT NULL default '',
    `registrar` VARCHAR(1000) NOT NULL default '',
    PRIMARY KEY(`brep_company_id`)
);

DROP TABLE IF EXISTS `brep_reports`;
CREATE TABLE `brep_reports` (
    `brep_report_id` INT(16) NOT NULL auto_increment,
    `type` ENUM ('bulletin', 'quarterly', 'annual', 'news', 'analytics'),
    `filetype` VARCHAR(20) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `upload_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    `report_date` DATE NOT NULL default '0000-00-00',
    `filepath` VARCHAR(1000) NOT NULL default '',
    `brep_company_id` INT(16) NOT NULL default '0',
    `language` VARCHAR(5) NOT NULL default '',
    PRIMARY KEY(`brep_report_id`)
);

