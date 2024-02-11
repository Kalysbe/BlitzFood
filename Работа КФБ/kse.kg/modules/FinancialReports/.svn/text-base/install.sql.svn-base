INSERT INTO `modules` (
    `name`,
    `title`,
    `description`,
    `status`,
    `main_handler`,
    `main_view`,
    `language`
) VALUES (
    'FinancialReports',
    'Финансовая отчетность',
    'Финансовые отчеты',
    '1',
    'finrep_handler.php',
    'finrep_view.html',
    'ru'
);
INSERT INTO `pages` (
    `page_uname`,
    `page_title`,
    `page_text`,
    `status`,
    `language`
) VALUES (
    'FinancialReports',
    'Финансовые отчёты',
    'modules/FinancialReports/FinRep.php',
    '8',
    'ru'
);

CREATE TABLE `mod_finrep_companies` (
    `company_id` INT(16) NOT NULL auto_increment,
    `company_name` VARCHAR(200) NOT NULL default '',
    `company_title` VARCHAR(500) NOT NULL default '',
    `status` TINYINT(1) NOT NULL default '0',
    `cr_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY (`company_id`)
);

CREATE TABLE `mod_finrep_files` (
    `file_id` INT(16) NOT NULL auto_increment,
    `filename` VARCHAR(1000) NOT NULL default '',
    `realfile` VARCHAR(1000) NOT NULL default '',
    `mime` VARCHAR(20) NOT NULL default '',
    `period_from` DATE NOT NULL default '0000-00-00',
    `period_to` DATE NOT NULL default '0000-00-00',
    `status` TINYINT(1) NOT NULL default '0',
    PRIMARY KEY (`file_id`)
);