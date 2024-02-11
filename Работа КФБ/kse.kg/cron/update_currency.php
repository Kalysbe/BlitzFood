<?php
/*
 * This script is to update currency
 */
require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );

$query = "
select USD, www.GETDIFF(eurCng) as USDPicture, to_char(USDCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as USDCng,
       EUR, www.GETDIFF(eurCng) as EURPicture, to_char(EURCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as EURCng,
       RUB, www.GETDIFF(rubCng) as RUBPicture, to_char(RUBCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as RUBCng,
       date1
from (select USD, www.prevUSD(t.date0) as USDCng,
        EUR, www.prevEUR(t.date0) as EURCng,
        RUB, www.prevRUB(t.date0) as RUBCng,
        ts.makedate(date0) as date1
      from ls.cur t
      where t.date0=(select max(t1.date0) from ls.cur t1))
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
$sql = array();

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
	$sql[] = "INSERT INTO `mod_currency` (
			`date`,
			`currency`,
			`currency_name`,
			`rate`,
			`flag`,
			`change_percent`
		) VALUES (
			'" . $date . "',
			'USD',
			'USD',
			'" . $row["USD"] . "',
			'flag_us.jpg',
			'" . $row["USDCNG"] . "'
		)";


	$sql[] = "
		INSERT INTO `mod_currency` (
			`date`,
			`currency`,
			`currency_name`,
			`rate`,
			`flag`,
			`change_percent`
		) VALUES (
			'" . $date . "',
			'EUR',
			'EUR',
			'" . $row["EUR"] . "',
			'flag_eu.jpg',
			'" . $row["EURCNG"] . "'
			)
		";

	$sql[] = "
		INSERT INTO `mod_currency` (
			`date`,
			`currency`,
			`currency_name`,
			`rate`,
			`flag`,
			`change_percent`
		) VALUES (
			'" . $date . "',
			'RUB',
			'RUB',
			'" . $row["RUB"] . "',
			'flag_rus.jpg',
			'" . $row["RUBCNG"] . "'
		);
		";
}
if (count($sql) > 0)
$delsql = "DELETE FROM `mod_currency` WHERE (`date`='" . $date . "')";
mysqli_query($link, $delsql);

foreach ($sql as $query) {
	mysqli_query($link, $query);
}

?>
