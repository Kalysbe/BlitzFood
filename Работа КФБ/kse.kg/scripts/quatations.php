<?php
require_once("../config.inc.php");
$query = "
select * from
(
select tc.shortname as name, tc.namerus,ts.makedate(tc.zakdate),(case when ts.makedate(tc.zakdate) like '-' then '' else concat(', дата закрытия ',to_char(ts.makedate(tc.zakdate))) end) as dt,
       (select (max(ts.makeb(www.dot(round(price,2)), direct)))
       from ts.orders t where t.ownid=tc.ords_id) as b,
       (select sum(volume)
       from ts.orders t where t.ownid=tc.ords_id
       and t.price=(select max(ts.makeb(price, direct)) from ts.orders t where t.ownid=tc.ords_id)
       ) as bv,
       (select (min(ts.makes(www.dot(round(price,2)), direct)))
       from ts.orders t where t.ownid=tc.ords_id) as s,
       (select sum(volrest)
       from ts.orders t where t.ownid=tc.ords_id
       and t.price=(select min(ts.makes(price, direct)) from ts.orders t where t.ownid=tc.ords_id)
       ) as sv
  from ts.ts_currinstrument_arcts tc
 )
 where b is not null or s is not null
 ";

$conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], $_DB["ORA_CHARSET"]);
if (!$conn) {
	    $e = oci_error();
	        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, $query);
if (!$stid) {
	    $e = oci_error($conn);
	        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
$e = oci_error($stid);
trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

function FormatNum($num)
{
if (strlen($num) < 2)
return '0'.$num;
else return $num;
}
$i = 0;
$buffer = array();
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
	$i++;
	foreach ($row as $k => $item) {
		$buffer[$i][$k] = $item; 
		//echo $k . "====>" . $item . "<br />";
	}
}

foreach ($buffer as $v) {
	echo "<li class=\"green\">" . $v["NAME"] . "</li>";
}

?>
