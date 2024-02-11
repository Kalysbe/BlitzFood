DROP TABLE IF EXISTS `mod_trade_last`;
CREATE TABLE `mod_trade_last` (
    `isin` VARCHAR(12) NOT NULL default ' ',
    `short_name` VARCHAR(10) NOT NULL default ' ',
    `name_rus` varchar(100) NOT NULL default ' ',
    `max_cast` float NOT NULL default '0',
    `min_cast` float NOT NULL default '0',
    `total_volume` float NOT NULL default '0',
    `count_deal` INT NOT NULL default '0',
    `count_instr` INT NOT NULL default '0'
);
