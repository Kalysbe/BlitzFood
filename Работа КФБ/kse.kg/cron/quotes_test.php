<?php
/*
 * This script is to update currency
 */
require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );
// select tc.ords_id from ts.ts_currinstrument_arcts tc where tc.ords_id = 3518514
// select ownid from ts.orders where ownid = 3391949
// $query = "
// 	select * from
// 	(
// 		select 
// 			tc.shortname as name, tc.namerus as rusname, tc.extcode as quotes, 
// 			(select (max(to_number(ts.makeb(www.dot(round(price,4)), direct)))) from ts.orders t where t.ownid=tc.ords_id) as b,
// 			(select sum(volume) from ts.orders t where t.ownid=tc.ords_id and t.price=(select max(to_number(ts.makeb(price, direct))) from ts.orders t where t.ownid=tc.ords_id)) as bv,
// 			tc.ords_id

// 		from ts.ts_currinstrument_arcts tc
// 	) where name like 'KAKB%'
// ";

// select 
// 			tc.ords_id as id,
// 			(select t.ownid from ts.orders t where t.ownid = id) as own

// 		from ts.ts_currinstrument_arcts tc

/*
select ts.makedate(date0) as date1, ts.maketime(time) as time1, volume as bv, price as b,
(select shortname from ts_currinstrument_arcts tc where ords_id = 3518500) as name,
(select namerus from ts_currinstrument_arcts tc where ords_id = 3518500) as namerus,
(select extcode from ts_currinstrument_arcts tc where ords_id = 3518500) as quotes 
 from ts.orders where ownid = 3518500
*/



$query = "select * from ts.orders where ownid = 6170282";

// $query = "select * from (
// 		select 
// 			tc.shortname as name, 
// 			tc.namerus as rusname, 
// 			(select (max(to_number(ts.makeb(www.dot(round(price,4)), direct)))) from ts.orders t where t.ownid=tc.ords_id) as b,
// 			(select sum(volume) from ts.orders t where t.ownid=tc.ords_id and t.price=(select max(to_number(ts.makeb(price, direct))) from ts.orders t where t.ownid=tc.ords_id)) as bv,
// 			(select ownid from ts.ord(string)ers where ownid = 3518500)
// 				from ts.ts_currinstrument_arcts tc where tc.ords_id = 3518500
// 		)";

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

$sql="delete from `mod_quotes_salym`;";
mysqli_query($link, $sql);
$row = [];

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {

	echo "<pre>";
	print_r($row);
	echo "</pre>";
	// foreach ($row as $k=>$v) {
	// if ($k == "TIME1") {
	// 		$sql = "SELECT * FROM `mod_quotes_salym` WHERE 
	// 			(`time1`='" . $v . "')";
	// 		$result = mysqli_query($link, $sql);
	// 		$rows = mysqli_num_rows($result);
	// 		echo 'rows='.$rows;
	// 		if ($rows == 0) {
				
		
				
	// 						$sql = "INSERT INTO `mod_quotes_salym` (
	// 							`short_name`,
	// 							`full_name`,
	// 							`buy_amount`,
	// 							`buy_price`,
	// 							`date1`,
	// 							`time1`	
	// 						) VALUES (
	// 							'" . $row["NAME"] . "',
	// 							'" . mb_convert_encoding($row["NAMERUS"], 
	// 								"UTF-8", "Windows-1251") . "',
	// 							'" . $row["BV"] . "',
	// 							'" . $row["B"] . "',
	// 							'" . $row["DATE1"] . "',
	// 							'" . $row["TIME1"] . "'
	// 						)";
	// 						#echo 'query='.$sql;
	// 						mysqli_query($link, $sql);
	// 						echo mysqli_error($link);
						
	// 			}
	// 		} 
	// 	}
	

}


?>
