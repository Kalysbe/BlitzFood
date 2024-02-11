<?php

require_once("../config.inc.php");
$date = date("d.m.Y");
$url = 'https://www.nbkr.kg/XML/daily.xml';
$xml = file_get_contents($url);
$CurrencyRates = simplexml_load_string($xml);
// Создание переменных
$d_n = '';
$d_v = '';
$e_n = '';
$e_v = '';
$k_n = '';
$k_v = '';
$r_n = '';
$r_v = '';
// Доллар
if ($CurrencyRates->Currency[0]['ISOCode'] == 'USD')
{
    // Номинал
    $d_n = $CurrencyRates->Currency[0]->Nominal;
    // Значение
    $d_v = $CurrencyRates->Currency[0]->Value;
}
// Евро
if ($CurrencyRates->Currency[1]['ISOCode'] == 'EUR')
{
    // Номинал
    $e_n = $CurrencyRates->Currency[1]->Nominal;
    // Значение
    $e_v = $CurrencyRates->Currency[1]->Value;
}
// Тенге
if ($CurrencyRates->Currency[2]['ISOCode'] == 'KZT')
{
    // Номинал
    $k_n = $CurrencyRates->Currency[2]->Nominal;
    // Значение
    $k_v = $CurrencyRates->Currency[2]->Value;
}
// Рубль
if ($CurrencyRates->Currency[3]['ISOCode'] == 'RUB')
{
    // Номинал
    $r_n = $CurrencyRates->Currency[3]->Nominal;
    // Значение
    $r_v = $CurrencyRates->Currency[3]->Value;
}

/*$query = "
select USD, www.GETDIFF_mon(usdCng) as USDPicture, to_char(USDCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as USDCng,
       EUR, www.GETDIFF_mon(eurCng) as EURPicture, to_char(EURCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as EURCng,
       RUB, www.GETDIFF_mon(rubCng) as RUBPicture, to_char(RUBCng,'fm999G999G999G990D00', 'nls_numeric_characters='', ''''') as RUBCng,
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
$sql = array();*/

//while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {

echo '
<META http-equiv=Content-type content=text/html;charset=UTF-8>
<body style="background: #424242;" scroll="no" >
<table width="100%" height="80%">
  <tr>
  <td align="center" valign="middle">
  <TABLE  width=90% bgcolor="#424242" border=0 align="center" >
    <TR bgcolor="#424242"> 
      <TD colSpan=3  ><FONT color=##00FF00><h1>Учетный курс валют на '.$date.'</h1></FONT>&nbsp;&nbsp</TD>
      <TD   align="center"><font color="#FFFFFF"></font></TD>
      <TD   align=right> </TD>
    </TR>
    <TR bgcolor="#424242" valign="bottom"> 
      <td colSpan=2 align=center> 
        <font face="verdana" style="font-size:40px;font-weight:bold;" color="#ffff00" size="300">
           Валюта
        </FONT>
      </TD>
      <TD     width="35%" align="center">
        <font face="verdana" style="font-size:40px;font-weight:bold;" color="#ffff00" size="300">
           Курс
        </FONT>
      </TD>
      <TD   colspan=1 align=right>
        <font face="verdana" style="font-size:40px;font-weight:bold;" color="#ffff00" size="300">
          %
        </FONT>
      </TD>
    </TR>
    <tr><td colspan=5><hr></td></tr>
    <TR bgcolor="#424242" valign="bottom"> 
      <TD   width="5%">
      <IMG height=70 width=100 src="images/usd.gif">
      </td><td width="25%" valign="middle"> 
        <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
           USD
        </FONT>
      </TD>
      <TD     width="35%" align="right" valign="middle">
        <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
           '.$d_v.'
        </FONT>
      </TD>
      <TD   align="right" width="30%" valign="middle">
        <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
           0
        </FONT>
      </TD>
      <TD   align="right" width="5%" valign="middle">
           -
      </TD>
    </TR>
    <tr><td colSpan=5></td>
    </tr>
    <TR bgcolor="#424242" valign="bottom"> 
      <TD>
        <IMG height=70 width=100 src="images/euro.gif">
      </td>
      <td valign="middle">  
        <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
            EUR
        </FONT>
      </TD>
      <TD   align="right" valign="middle">
        <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
          '.$e_v.'
	  </FONT>
 	</TD>
      <TD   align="right" valign="middle">
        <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
	    0
	  </FONT>
      </TD>
      <TD   align="right" width="5%" valign="middle">
	  -
      </TD>
    </TR>
    <TR bgcolor="#424242" valign="bottom"> 
      <TD>
              <IMG height=70 width=100 src="images/rur.gif">
      </td>
      <td valign="middle">  
	  <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
	    RUB
	  </FONT>
      </TD>
      <TD   align="right" valign="middle">
	  <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
	    '.$r_v.'
	  </FONT>
      </TD>
      <TD   align="right" valign="middle">
	  <font face="verdana" style="font-size:55px;font-weight:bold;" color="#ffff00" size="300">
	    0
	  </FONT>
      </TD>
      <TD   align="right" width="5%" valign="middle">
	    -
      </TD>
    </TR>
   </TABLE>
  </td>
  </tr>
</table>
</body>
';
//};
?>
