<?php

require_once("../config.inc.php");

$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"] );
mysql_query("SET NAMES 'utf8'");

$query = "select my_year, nick1, nick2, sum(total) total, sum(count_instr) count_instr from
(
select  to_number(substr(ts.makedate(t.date0),-4)) my_year ,t.nick1, t.nick2, sum(t.total)/2 total, count(*)/2 count_instr
from ts.f1a_q1 t 
where to_number(substr(ts.makedate(t.date0),-4)) between 1995 and 2010 and md='d'
group by t.nick1, t.nick2, to_number(substr(ts.makedate(t.date0),-4))

union all 

select to_number(substr(ts.makedate(t.date0),-4)) my_year,t.nick1, t.nick2, sum(t.total) total, count(*) count_instr
from ts.f1a_q1 t 
where to_number(substr(ts.makedate(t.date0),-4)) between 1995 and 2010 and md='m'
group by t.nick1, t.nick2, to_number(substr(ts.makedate(t.date0),-4))
)  fff
group by nick1, nick2, my_year";
	

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

mysql_query("delete from members_rating_info");

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

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
    print_r($row);
    $sql = "INSERT INTO `members_rating_info` (`company_name_short`,`company_name_full`,
        `volume`, `amount`, `year`) VALUES
        ('".$row["NICK1"]. "', '
        " .mb_convert_encoding($row["NICK2"], "UTF8", "Windows-1251"). "',
        " . $row["TOTAL"] . ",
        " . $row["COUNT_INSTR"] . ",
        " . $row["MY_YEAR"] . ")";
    mysql_query($sql);
}

?>
