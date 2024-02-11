<?php
require_once("../config.inc.php");
$query = "select  round(Ind,2) as ind, www.getdiff_mon(indchng) as IndPicture, www.getdiff_mon(capchng) as CapPicture, www.formatchange(Indchng) as Indchng, round(cap/1000000,2) as cap 
from (select t.ind,t.cap, (ind/(select t2.ind from ts.capitalisation t2 where t2.date0=
       (select max(t1.date0) as maxdate from ts.capitalisation t1 where t1.date0<t.date0)
       )-1)*100 as indchng,
      (cap/(select t2.cap from ts.capitalisation t2 where t2.date0=
       (select max(t1.date0) as maxdate from ts.capitalisation t1 where t1.date0<t.date0)
       )-1)*100 as capchng
   from ts.capitalisation t
   where t.date0=(select max(t2.date0) from ts.capitalisation t2)
   order by  t.date0)";
   
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

echo '
<META http-equiv=Content-type content=text/html;charset=UTF-8>
<body bgcolor="#000000" scroll="no">
  <table bgcolor="#000000" width="100%" heigth="100%" border="0" cellpadding="3" cellspacing="1">
 </table>
<br>
<br><br><br><br><br><br>

<table border=0 align="center" valign="absmiddle" width="100%" height="50%">
<TR> 
  <td width="90%" align="center" >
  <font face="verdana" style="font-size:70px;font-weight:bold;" color="#ffff00" size="300">
    Индекс KSE - '.$row['IND'].'
  </font>
  </td>
  <td align="center">
  <font style="font-size:70px;font-weight:bold;" color="#ffff00" size="300">
   '.$row['INDPICTURE'].'
  </font>
  </td>
</TR>
<TR> 
  <td width="90%" align="center">
  <font face="verdana" style="font-size:70px;font-weight:bold;" color="#ffff00" size="100">
    Капитализация (млн.сом) - '.$row['CAP'].'
  </font>
  </TD>
  <td align="center">
  <font style="font-size:70px;font-weight:bold;" color="#ffff00" size="300">
  '.$row['CAPPICTURE'].'
  </font>
  </td>
</TR>
  </TABLE>
</body>';
};
?>