<?php

require_once("../../config.inc.php");

$query = "
select * from 
(select rownum as rm, bb.* from
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
        (select sum(volume)
         from ts.orders t where t.ownid=tc.ords_id
         and t.price=(select max(ts.makes(price, direct)) from ts.orders t where t.ownid=tc.ords_id)
        ) as sv
        from ts.ts_currinstrument_arcts tc) bb
    where b is not null or s is not null )
     where rm between 1 and 15
    ";

$conn = oci_connect($_DB["ORA_USER"], $_DB["ORA_PASS"], $_DB["ORA_CSTRING"], 'AL32UTF8');
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

  echo'
      <META http-equiv=Content-type content=text/html charset=utf-8>
      <head> <style>.mytable td {border-bottom: 1px solid #555;}</style></head>
      <body scroll="no" style="background: #424242;">
      <font color=#00FF00 size=4>Котировки On-line</font>
      <br>
      <table bgcolor="#424242" width="100%" border="0" cellpadding="3" cellspacing="1">
        <TR>
          <TD  ROWSPAN=2 align="left" width="60%"><font color="#00FF00" size="5"face="verdana">Наименование</font></TD>
          <TD align="center" colspan=2><font color="#00FF00" size="5"face="verdana">Покупка</font></TD>
          <TD align="center" colspan=2><font color="#00FF00" size="5" face="verdana">Продажа</font></TD>
        </TR>
        <TR>
          
          <TD width="10%" align="center"><font color="#00FF00" size="4" face="verdana" ><b/>Кол-во</font></TD>
          <TD width="10%" align="center"><font color="#00FF00" size="4" face="verdana"><b/>Цена</font></TD>
          <TD width="10%" align="center"><font color="#00FF00" size="4" face="verdana"><b/>Кол-во</font></TD>
          <TD width="10%" align="center"><font color="#00FF00" size="4" face="verdana"><b/>Цена</font></TD>
          </TR>
        </table><hr>';
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
echo'      
    <table class="mytable" width="100%" border="0" cellpadding="3" cellspacing="1">
 	  <TR bgcolor="#424242">
	    <TD width="60%" style="CURSOR: HELP" align="left" title="'.$row['NAMERUS'].$row['DT'].'">
	       <font face="verdana" style="font-size:22px;font-weight:bold;" color="yellow" >
	         '.$row['NAMERUS'].'
	       </font> 
	    </TD>
	    <TD width="10%"align="right"><font face="verdana" style="font-size:22px;font-weight:bold;" color="yellow">'.$row['BV'].'&nbsp;</font></TD>
	    <TD width="10%"align="right"><font face="verdana" style="font-size:22px;font-weight:bold;" color="yellow">'.$row['B'].'&nbsp;</font></TD>
	    <TD width="10%"align="right"><font face="verdana" style="font-size:22px;font-weight:bold;" color="yellow">'.$row['SV'].'&nbsp;</font></TD>    
	    <TD width="10%"align="right"><font face="verdana" style="font-size:22px;font-weight:bold;" color="yellow">'.$row['S'].'&nbsp;</font></TD>
	</TR>      
      </table>
  ';
};
?>
