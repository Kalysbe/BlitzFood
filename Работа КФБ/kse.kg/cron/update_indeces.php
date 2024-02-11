<?php
/*
 * This script is to update currency
 */



require_once("../config.inc.php");

mysql_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"]);
mysql_select_db($_DB["NAME"]);

$query = "
	select * from ls.indexes where (date0=(select max(t2.date0) from ls.indexes t2)
)
	
	";

$conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], $_DB["ORA_CHARSET"]);
if (!$conn) {
	$e = oci_error();
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	exit();
}

$stid = oci_parse($conn, $query);
if (!$stid) {
	$e = oci_error($conn);
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	exit();
}

// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
	$e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	exit();
}

function FormatNum($num)
{
	if (strlen($num) < 2)
	return '0'.$num;
	else return $num;
}

$buffer = array();

$date = date("Y-m-d 00:00:00");

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
	echo "<pre>";
	print_r($row);
	echo "</pre>";
	continue;
	foreach ($row as $k=>$v) {
		if ($k != "DATE0") {
		mysql_query("INSERT INTO `mod_indeces` (
			`name`,
			`index`,
			`date`
		)
		VALUES (
			'" . $k . "',
			'" . $v . "',
			'" . $date . "'
			)
			");
		}
	}

}
?>
