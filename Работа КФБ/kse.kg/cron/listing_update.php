<?php
/*
 * This script is to update currency
 */

require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );
mysqli_query($link, "SET NAMES 'utf8'");

$query = "
	select t.name as name, t.name_eng as name_eng,

       t.id as id,

       (select min(tt.shortname) from ls.extra_security tt where tt.enterprise=t.id) AS symbol,

       WWW.GETTYPEOFSECS(t.name) as typeofsecs,
	   
	   WWW.GETTYPEOFSECS_ENG(t.name) as typeofsecs_eng,

       to_char(round(nvl(t.price,0),4),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as LastPrice,

       to_char(round(nvl(t.price* t.infusion/1000000,0),2),'fm999G999G990D00', 'nls_numeric_characters='', ''''') as LastPriceEPQ,

       to_char(infusion,'fm999G999G990', 'nls_numeric_characters='', ''''') as infusion,

       c.address as address,
	   
	   c.address_eng as address_eng,

       c.tel_fax as tel,

       c.fio_director as owner,
	   
	   c.fio_director_eng as owner_eng,

       c.post as position,
	   
	   c.post_eng as position_eng,

       c.job as job,
	   
	   c.job_eng as job_eng,

       (select reg.name from ls.registrar reg where reg.id=c.registrar) as registrar,
	   
	   (select reg.name_eng from ls.registrar reg where reg.id=c.registrar) as registrar_eng,

       (select aud.name from ls.auditor aud where aud.id=c.auditor) as auditor,
	   
	   (select aud.name_eng from ls.auditor aud where aud.id=c.auditor) as auditor_eng,

       (select mm.name from ls.market_maker mm where mm.id=c.market_maker) as market_maker,
	   
	   (select mm.name_eng from ls.market_maker mm where mm.id=c.market_maker) as market_maker_eng

       from ls.extra_enterprise t,ls.companies c

where t.ind=1 and t.id=c.id       
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

	// Getting company by symbol
	$sql = "SELECT * FROM `ls_trade_symbols` WHERE (`trade_symbol`='" . $row["SYMBOL"] . "')";
	$result = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($result);

	echo $row["SYMBOL"].'--row1--='.$rows.'\n';
	if ($rows > 0) {
		$Symbol = mysqli_fetch_object($result);
		
		$sql = "SELECT * FROM `ls_info` WHERE (`ls_company_id`='" . $Symbol->ls_company_id . "')";
		//print_r('selinf-'.$sql.'\n');
		$info_res = mysqli_query($link, $sql);
		$info_rows = mysqli_num_rows($info_res);
		
		echo $row["SYMBOL"].'--row='.$info_rows.'\n';
		if ($info_rows < 1) {

			$sql = "INSERT INTO `ls_info` (
				`ls_company_id`,
				`last_price`,
				`capitalization`,
				`securities_amount`
			) VALUES (
				'" . $Symbol->ls_company_id . "',
				'" . $row["LASTPRICE"] . "',
				'" . $row["LASTPRICEEPQ"] . "',
				'" . preg_replace('/\s*/m', '', $row["INFUSION"]) . "'
			)";

			mysqli_query($link, $sql);
			print_r ('insert!! ---- '.$sql);
			$sql = "INSERT INTO `ls_companies` (`ls_company_id`, `cat_id`) 
				VALUES ('" . $Symbols->ls_company_id . "', '1')";
			mysqli_query($link, $sql);
		} else {
			$sql = "UPDATE `ls_info` SET 
					`last_price`='" . $row["LASTPRICE"] . "',
					`capitalization`='" . $row["LASTPRICEEPQ"] . "',
					`securities_amount`='" . 
					preg_replace('/\s*/m', '', $row["INFUSION"]) . "'
				WHERE (`ls_company_id`='" . $Symbol->ls_company_id . "')
				";
			mysqli_query($link, $sql);

			$sql = "UPDATE `ls_companies` SET 
				`ls_company_name`='" . 
				mb_convert_encoding($row["NAME"], "UTF8", "Windows-1251") . "',
				`ls_company_name_eng`='" . 
				mb_convert_encoding($row["NAME_ENG"], "UTF8", "Windows-1251") . "',
				`activity`='" . 
				mb_convert_encoding($row["JOB"], "UTF8", "Windows-1251") . "',
				`activity_eng`='" . 
				mb_convert_encoding($row["JOB_ENG"], "UTF8", "Windows-1251") . "',
				`security`='" . 
				mb_convert_encoding($row["TYPEOFSECS"], "UTF8", "Windows-1251") . "',
				`security_eng`='" . 
				mb_convert_encoding($row["TYPEOFSECS_ENG"], "UTF8", "Windows-1251") . "',
				`owner`='" . 
				mb_convert_encoding($row["OWNER"], "UTF8", "Windows-1251") . "',
				`owner_eng`='" . 
				mb_convert_encoding($row["OWNER_ENG"], "UTF8", "Windows-1251") . "',
				`owner_position`='" . 
				mb_convert_encoding($row["POSITION"], "UTF8", "Windows-1251") . "',
				`owner_position_eng`='" . 
				mb_convert_encoding($row["POSITION_ENG"], "UTF8", "Windows-1251") . "',
				`address`='" . 
				mb_convert_encoding($row["ADDRESS"], "UTF8", "Windows-1251") . "',
				`address_eng`='" . 
				mb_convert_encoding($row["ADDRESS_ENG"], "UTF8", "Windows-1251") . "',
				`phone`='" . 
				mb_convert_encoding($row["TEL"], "UTF8", "Windows-1251") . "',
				`auditor`='" . 
				mb_convert_encoding($row["AUDITOR"], "UTF8", "Windows-1251") . "',
				`auditor_eng`='" . 
				mb_convert_encoding($row["AUDITOR_ENG"], "UTF8", "Windows-1251") . "',
				`registrar`='" . 
				mb_convert_encoding($row["REGISTRAR"], "UTF8", "Windows-1251") . "',
				`registrar_eng`='" . 
				mb_convert_encoding($row["REGISTRAR_ENG"], "UTF8", "Windows-1251") . "',
				`marketmaker`='" . 
				mb_convert_encoding($row["MARKET_MAKER"], "UTF8", "Windows-1251") . "',
				`marketmaker_eng`='" . 
				mb_convert_encoding($row["MARKET_MAKER_ENG"], "UTF8", "Windows-1251") . "'
				WHERE (`ls_company_id`='" . $Symbol->ls_company_id . "')
				";
			//echo "<pre>" . $sql . "</pre>";
			mysqli_query($link, $sql);
		}
		echo mysqli_error($link);
	}
}

?>
