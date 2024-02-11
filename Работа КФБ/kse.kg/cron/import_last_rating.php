<?php

require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );
mysqli_query($link, "SET NAMES 'utf8'");

$my_last_year=date( 'Y', time() );	


$query = "select my_year,
       nick1,
       nick2,
       total,
     fininstr,
     count_instr_market,
     total_market,
       count_instr,
       factor_volume,
       factor_amount,
     factor_instr,
       factor_market_volume,
       factor_market_amount,
       factor_volume+factor_amount+factor_instr+factor_market_volume+factor_market_amount as factor
from ts.factor
		where nick1 not like '%-G'";


/*$query_common = "select my_year, sum(total_common) total_common, sum(count_instr_common) count_instr_common from
(
select  to_number(substr(ts.makedate(t.date0),-4)) my_year, sum(t.total)/2 total_common, count(*)/2 count_instr_common
from ts.f1a_q1 t 
where to_number(substr(ts.makedate(t.date0),-4)) =".$my_last_year." and md='d'
group by to_number(substr(ts.makedate(t.date0),-4))

union all 

select to_number(substr(ts.makedate(t.date0),-4)) my_year, sum(t.total) total_common, count(*)/2 count_instr_common
from ts.f1a_q1 t 
where to_number(substr(ts.makedate(t.date0),-4))=".$my_last_year." and md='m'
group by to_number(substr(ts.makedate(t.date0),-4))
)  fff
group by my_year";

$query_common_market = "select my_year, sum(total_common_market) total_common_market, sum(count_instr_common_market) count_instr_common_market, sum(md) md from
(
select to_number(substr(ts.makedate(t.date0),-4)) my_year, sum(t.total) total_common_market, count(*)/2 count_instr_common_market, count(*)/2 md
from ts.f1a_q1 t 
where to_number(substr(ts.makedate(t.date0),-4))=".$my_last_year." and md='m'
group by to_number(substr(ts.makedate(t.date0),-4))
)
group by my_year, md";


$query_market = "select my_year, nick1, nick2, sum(total_market) total_market, sum(count_instr_market) count_instr_market from
(
select to_number(substr(ts.makedate(t.date0),-4)) my_year,t.nick1, t.nick2, sum(t.total)/2 total_market, count(*)/2 count_instr_market
from ts.f1a_q1 t 
where to_number(substr(ts.makedate(t.date0),-4))=".$my_last_year." and md='m'
group by t.nick1, t.nick2, to_number(substr(ts.makedate(t.date0),-4))
)  fff
group by nick1, nick2, my_year";


$query_array = array("query", "query_common", "query_common_market", "query_market"); */


function FormatNum($num)
{
	if (strlen($num) < 2)
		return '0'.$num;
	else return $num;
}

$conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], $_DB["ORA_CHARSET"]);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

mysqli_query($link, "delete from members_rating_info where year=".$my_last_year.";");

$stid = oci_parse($conn, $query);
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}


/*foreach($query_array as $val)
{
$stid = oci_parse($conn, $$val);
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}*/



// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
    print_r($row);
    $sql = "INSERT INTO `members_rating_info` (`company_name_short`,`company_name_full`,
        `volume`,`count_fin_instr`,`count_market_deal`,`volume_market_deal`,`factor_volume`,`factor_amount`,`factor_instr`,`factor_market_amount`,`factor_market_volume`,`amount`,`factor`,`year`) VALUES
        ('".$row["NICK1"]. "', '
        " .mb_convert_encoding($row["NICK2"], "UTF8", "Windows-1251"). "',
		" . $row["TOTAL"] . ",
		" . $row["FININSTR"] . ",
		" . $row["COUNT_INSTR_MARKET"] . ",
		" . $row["TOTAL_MARKET"] . ",
		" . $row["FACTOR_VOLUME"] . ",
		" . $row["FACTOR_AMOUNT"] . ",
		" . $row["FACTOR_INSTR"] . ",
		" . $row["FACTOR_MARKET_AMOUNT"] . ",
		" . $row["FACTOR_MARKET_VOLUME"] . ",
		" . $row["COUNT_INSTR"] . ",
		" . $row["FACTOR"] . ",
        " . $row["MY_YEAR"] . ")";
    mysqli_query($link, $sql);
}
?>
