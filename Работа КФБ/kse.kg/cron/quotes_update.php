<?php
/*
 * This script is to update currency
 */
require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );

$query = "
	select * from
	(
		select tc.shortname as name, tc.namerus, tc.extcode as quotes, ts.makedate(tc.zakdate),(case when ts.makedate(tc.zakdate) like '-' then '' else concat(', дата закрытия ',to_char(ts.makedate(tc.zakdate))) end) as dt,
		       (select (max(to_number(ts.makeb(www.dot(round(price,4)), direct))))
		              from ts.orders t where t.ownid=tc.ords_id) as b,
			             (select sum(volume)
				            from ts.orders t where t.ownid=tc.ords_id
					           and t.price=(select max(to_number(ts.makeb(price, direct))) from ts.orders t where t.ownid=tc.ords_id)
						          ) as bv,
							         (select (min(to_number(ts.makes(www.dot(round(price,4)), direct))))
								        from ts.orders t where t.ownid=tc.ords_id) as s,
									       (select sum(volrest)
									              from ts.orders t where t.ownid=tc.ords_id
										             and t.price=(select min(to_number(ts.makes(price, direct))) from ts.orders t where t.ownid=tc.ords_id)
											            ) as sv
												      from ts.ts_currinstrument_arcts tc
												       )
												        where b is not null or s is not null
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

$sql="delete from `mod_quotes`;";
mysqli_query($link, $sql);

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {

	// echo "<pre>";
	// print_r($row);
	// echo "</pre>";

	foreach ($row as $k=>$v) {
		if ($k == "NAME") {
			$sql = "SELECT * FROM `mod_quotes` WHERE 
				(`short_name`='" . $v . "')";
			$result = mysqli_query($link, $sql);
			$rows = mysqli_num_rows($result);
			echo 'rows='.$rows;
			if ($rows == 0) {
				
				$sql = "INSERT INTO `mod_quotes` (
					`short_name`,
					`isin`,
					`full_name`,
					`buy_amount`,
					`buy_price`,
					`sell_amount`,
					`sell_price`	
				) VALUES (
					'" . $row["NAME"] . "',
					'" . $row["QUOTES"] . "',
					'" . mb_convert_encoding($row["NAMERUS"], 
						"UTF-8", "Windows-1251") . "',
					'" . $row["BV"] . "',
					'" . $row["B"] . "',
					'" . $row["SV"] . "',
					'" . $row["S"] . "'
				)";
				#echo 'query='.$sql;
				mysqli_query($link, $sql);
				//echo mysqli_error($link);
			} else {
				$sql = "UPDATE `mod_quotes` SET 
					`full_name`='" . 
					mb_convert_encoding($row["NAMERUS"], "UTF-8", "Windows-1251") . "',
					`buy_amount`='" . $row["BV"] . "',
					`isin`='" . $row["QUOTES"] . "',
					`buy_price`='" . $row["B"] . "',
					`sell_amount`='" . $row["SV"] . "',
					`sell_price`='" . $row["S"] . "'
					WHERE (`short_name`='" . $row["NAME"] . "')";
				mysqli_query($link, $sql);		
				
			}
		}
	}

}


?>
