<?php

if (!defined('WEB_ROOT')){die('Oops...');}

if (isset($_GET['issue'])) 
{
   $name_issue=($_GET['issue']);
}
$dt=MakeLongDate(date('d/m/Y'));
$namerus = "";
$settlement_date = "";
$repayment_date = "";
$coupon_annual_rate = "";

	if ($c = ora_logon(OP1,OP2))
  {
		$sql = oci_parse($c, "select curr.namerus,ts.makedate(issue.settlement_date),
									ts.makedate(issue.repayment_date) , issue.coupon_annual_rate
							  from tsm.market m, tsm.sector s, tsm.subsector ss, tsm.currinstrument curr,ls.auction_issue issue 
							  where m.sect_id=s.ownid and s.ssecsid=ss.ownid and ss.inst_id=curr.ownid and m.mcode='T' 
									and issue.date0=".$dt." and curr.id=issue.curr_id and issue.curr_id = 
										(select id from tsm.currinstrument where shortname like '%".$name_issue."%')"); 
								
		oci_execute($sql);
		oci_fetch($sql);
		
		$namerus         	= oci_result($sql,1);
		$settlement_date 	= oci_result($sql,2);
		$repayment_date  	= oci_result($sql,3);
		$coupon_annual_rate = oci_result($sql,4);
		
		
    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error "; //. trigger_error(htmlentities(oci_error(['message'])), E_USER_ERROR);
  }

/*
$option="<select name='currinstrument'>";

  if ($c = ora_logon(OP1,OP2))
  {
	$stmt = oci_parse($c, "select curr.shortname, curr.id from ".TS.".market m, ".TS.".sector s, ".TS.".subsector ss, ".TS.".currinstrument curr where m.sect_id=s.ownid and s.ssecsid=ss.ownid and ss.inst_id=curr.ownid and m.mcode='T'
							order by curr.shortname"); 
	oci_execute($stmt);

    while (oci_fetch($stmt)) {
        $namerus= oci_result($stmt, 1);
        $id=oci_result($stmt, 2);
        $option.= "<option value='".$id."'>".$namerus."</option>";
    }
    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error "; //. trigger_error(htmlentities(oci_error(['message'])), E_USER_ERROR);
  }

$option.="</select>";

$out="<form method='POST'>
   <br>
   <table border=0>
   <tr><td style='padding: 3px;'>Инструмент:</td><td>".$option."</td>   </tr>
   <tr><td colspan='2' align='right'></td></tr>
   <tr><td><input type='button' value='Закрыть' onclick='close_porting();'></td></tr>
   <tr><td colspan='2' align='right'><input type='hidden' name='act' value='add_issue'></td></tr>
   </table>
   </form>";*/ 
   $out =" <br>
   <table border=0>
   <tr><td style='padding: 1px;'>Тип Бумаги:</td><td>".$namerus."</td>   </tr>
   <tr><td style='padding: 1px;'>Дата расчета:</td><td>".$settlement_date."</td>   </tr>
   <tr><td style='padding: 1px;'>Дата погашения:</td><td>".$repayment_date."</td>   </tr>
	";
	if ($coupon_annual_rate != "0")
		$out .= "<tr><td style='padding: 3px;'>Купонная ставка:</td><td>".$coupon_annual_rate."%</td>   </tr>";
	$out .= "<tr><td colspan='2' align='right'></td></tr>
   <tr><td><input type='button' value='Закрыть' onclick='close_porting();'></td></tr>
   </table>";
header("Content-type=text/html;charset=windows-1251");   
echo "<div class=\"window_caption\"><table width=\"100%\"><tr><td align=middle><b>Параметры инструмента - ".$name_issue."</b></td><td align=\"right\"><span class=\"panel_item\" onclick=\"close_porting();\"><b>X</b></span></td></tr></table></div>".$out;

?>
