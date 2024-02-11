<?php

require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );
mysqli_query($link, "SET NAMES 'utf8'");

$query_last = "select ts.makedate(t.date0) dealdate,t.ext isin, t.SHORTNAME, t.NAMERUS, max(t.PRICE) maxcost, 
    min(t.PRICE) mincost, sum(t.total) total, count(*) count_deal, sum(t.VOLUME) count_instr 
    from ts.f1a_q1 t 
    where t.date0=(select max(date0) from ts.f1a_q1) and ascii(t.DIRECT)=1 
    group by t.ext,t.SHORTNAME, t.NAMERUS, t.date0";
	
$query_week="select t.ext isin, t.SHORTNAME, t.NAMERUS, max(t.PRICE) maxcost, 
    min(t.PRICE) mincost, sum(t.total) total, count(*) count_deal, sum(t.VOLUME) count_instr 
    from ts.f1a_q1 t 
    where t.date0  between ((select max(date0) from ts.f1a_q1)-7) and (select max(date0) from ts.f1a_q1) and ascii(t.DIRECT)=1 
    group by t.ext,t.SHORTNAME, t.NAMERUS
    order by t.SHORTNAME";	
	
$query_month="select t.ext isin, t.SHORTNAME, t.NAMERUS, max(t.PRICE) maxcost, 
    min(t.PRICE) mincost, sum(t.total) total, count(*) count_deal, sum(t.VOLUME) count_instr 
    from ts.f1a_q1 t 
    where t.date0  between ((select max(date0) from ts.f1a_q1)-256) and (select max(date0) from ts.f1a_q1) and ascii(t.DIRECT)=1 
    group by t.ext,t.SHORTNAME, t.NAMERUS
    order by t.SHORTNAME";	
	
$query_year="select t.ext isin, t.SHORTNAME, t.NAMERUS, max(t.PRICE) maxcost, 
    min(t.PRICE) mincost, sum(t.total) total, count(*) count_deal, sum(t.VOLUME) count_instr 
    from ts.f1a_q1 t 
    where t.date0  between ((select max(date0) from ts.f1a_q1)-65536) and (select max(date0) from ts.f1a_q1) and ascii(t.DIRECT)=1 
    group by t.ext,t.SHORTNAME, t.NAMERUS
    order by t.SHORTNAME";	

#echo "my_query=".$query_last;

$query_array = array("query_last", "query_week", "query_month", "query_year");
$period_array = array("l", "w", "m", "y");


$conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], $_DB["ORA_CHARSET"]);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

function FormatNum($num)
{
	if (strlen($num) < 2)
		return '0'.$num;
	else return $num;
}

mysqli_query($link, "DELETE FROM `mod_trade_last`");

foreach($query_array as $arr_ind=>$val)
{
echo "perod: " . $val . "\n";
$stid = oci_parse($conn, $$val);
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

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {

    $sql = "INSERT INTO `mod_trade_last` (`period`,`isin`,
        `short_name`, `name_rus`, `max_cost`, `min_cost`,
        `total_volume`, `count_deal`, `count_instr`) VALUES
        ('".$period_array[$arr_ind]."', '" . $row["ISIN"] . "', '" . $row["SHORTNAME"] . "',
        '" . mb_convert_encoding($row["NAMERUS"], "UTF8", "Windows-1251") . "', " . $row["MAXCOST"] . ",
        " . $row["MINCOST"] . ", " . $row["TOTAL"] . ",
        " . $row["COUNT_DEAL"] . ", ". $row["COUNT_INSTR"] .")";
    mysqli_query($link, $sql);
}
}
?>
