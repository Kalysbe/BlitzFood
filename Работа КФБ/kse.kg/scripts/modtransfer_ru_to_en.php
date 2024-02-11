<?php
/*
 * Transfers modules from russian to english
 */

require_once('../config.inc.php');
require_once('../mainfile.php');

$sql = "SELECT * FROM `modules` WHERE `language`='ru'";
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
for ($i = 0; $i < $rows; $i++) {
	mysql_data_seek($result, $i);
	$obj = mysql_fetch_object($result);
	$res = mysql_query("SELECT COUNT(`mid`) AS count FROM `modules` 
		WHERE (`name`='" . $obj->name ."' AND `language`='en')");
	$num = mysql_fetch_object($res);
	if ($num->count == 0) {
		$sql = "INSERT INTO `modules` (`name`, `title`, `description`,
		`status`, `main_handler`, `main_view`, `language`) VALUES (
			'" . $obj->name . "',
			'" . $obj->title . "',
			'" . $obj->description . "',
			'" . $obj->status . "',
			'" . $obj->main_handler . "',
			'" . $obj->main_view . "', 'en'	
		)";
		mysql_query($sql);
		echo mysql_error();
	}
}
?>
