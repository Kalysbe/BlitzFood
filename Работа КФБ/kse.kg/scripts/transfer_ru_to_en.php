<?php
/*
 * Transfer all the russian pages to english
 */

require_once('../config.inc.php');
require_once('../mainfile.php');

$sql = 'SELECT * FROM `pages` WHERE (`language`=\'ru\')';
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
for ($i = 0; $i < $rows; $i++) {
	mysql_data_seek($result, $i);
	$obj = mysql_fetch_object($result);
	$res = mysql_query("SELECT COUNT(page_id) AS count FROM `pages` 
		WHERE `page_uname`='" . $obj->page_uname . "' AND 
		`language`='en'");
	$num = mysql_fetch_object($res);
	if ($num->count == 0) {
		$sql = "INSERT INTO `pages` (`page_uname`, `page_title`,
		`page_text`, `creator`, `cr_date`, `cr_ip`, `update_date`,
		`update_ip`,`status`,`category`,`language`) VALUES (
			'" . $obj->page_uname . "',
			'" . $obj->page_title . "',
			'" . $obj->page_text . "',
			'" . $obj->creator . "',
			'" . $obj->cr_date . "',
			'" . $obj->cr_ip . "',
			'" . $obj->update_date . "',
			'" . $obj->update_ip . "',
			'" . $obj->status . "',
			'" . $obj->category . "',
			'en'	
		)";
		mysql_query($sql);
	}
}

?>
