<?php
/*
 * This script is to update currency
 */
require_once("../config.inc.php");

mysql_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"]);
mysql_select_db($_DB["NAME"]);

#$query = "select nick1,nick2,volume from f1a_q1";
$query = "select makedate(date0) as date0,
	nick1 as nick1,
	nick2 as nick2,
	total as total from f1a_q1";

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
$sql = array();

$deals = array();

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {

	/*echo "<pre>";
	print_r($row);
	echo "</pre>";
	continue;*/

	$da = explode('/',$row['DATE0']);
	$year = $da[2];
	$nick = $row['NICK1'];
	$deals[$row['NICK1']][$year]['name'] = $row['NICK2'];
	if (!isset($deals[$nick][$year]['volume']))
		$deals[$nick][$year]['volume'] = 0;
	if (!isset($deals[$nick][$year]['amount']))
		$deals[$nick][$year]['amount'] = 0;
	$deals[$nick][$year]['volume'] = 
		$deals[$nick][$year]['volume'] + $row['TOTAL'];
	$deals[$nick][$year]['amount'] = 
		$deals[$nick][$year]['amount'] + 1;
	/*$deals[$row['NICK1']]['name'] = $row['NICK2'];
	if (!isset($deals['NICK1']['volume']))
		$deals['NICK1']['volume'] = 0;
	$deals[$row['NICK1']]['volume'] = $row['VOLUME'];
	if (!isset($deals[$row['NICK1']['amount']]))
		$deals[$row['NICK1']]['amount'] = 0;
	$deals[$row['NICK1']]['amount']++;*/
}
/*
echo "<pre>";
print_r($deals);
echo "</pre>";
 */
function toutf8($string) {
	return mb_convert_encoding($string, "UTF8", "Windows-1251");	
}	

foreach ($deals as $k=>$v) {
	echo $k . ":<br /> ";
	foreach ($v as $key=>$value) {
		echo $key . ":<br />";
		echo "volume=>" . $value['volume'] . "<br />";
			$sql = "SELECT * FROM `members_rating_info`
				WHERE (`company_name_short`='" . $k . "'
				AND `date`='" . $key . "-00-00'
			)	
			";
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			if ($rows == 0) {
			$sql = "INSERT INTO `members_rating_info`
				(`company_name_short`,
				`company_name_full`,
				`volume`, `amount`, `date`) VALUES (
					'" . $k . "',
					'" . toutf8($value['name']) . "',
					'" . round($value['volume'],2) . "',
					'" . $value['amount'] . "',
					'" . $key . "-00-00'
				)
				";
			mysql_query($sql);
			} else {
			$obj = mysql_fetch_object($result);
			$sql = "UPDATE `members_rating_info` SET 
				`company_name_full`=>'" . 
				toutf8($value['name']) . "',
				`volume`=>'" . round($value['volume'],2) . "',
				`amount`=>'" . $value['amount'] . "'
				WHERE (`mr_id`='" . $obj->mr_id . "')
				";
			mysql_query($sql);
			}
		
	}
}
?>
