<?php

if (!defined('WEB_ROOT')){die('Oops...');}

$dt=MakeLongDate(date('d/m/Y'));

$option="<select name='currinstrument' style='width:145'>";

$data = array();
$row = array();
//Выбор алгоритма расчета для recalcPrice
$algorithm_calculation=0;
if($_SESSION['TYPE'] == 'ls.auction_NBKR_GKV' ){
      $algorithm_calculation = 2;
   }
   else {
      $algorithm_calculation = 1;
   }
//______________________________________________
  if ($c = ora_logon(OP1,OP2))
  {
    $curs = oci_parse($c, "select shortname, curr.id from ls.auction_issue t, ".TS.".ts_currinstrument_arcts curr where t.curr_id=curr.id and t.date0=".$dt." order by shortname");
		oci_execute($curs);
	
    //if (oci_fetch($curs))
    //{
    //    $namerus= oci_result($curs, 1);
    //    $id=ora_getcolumn($curs, 1);

    //    $option.= "<option value='".$id."'>".$namerus."</option>";
	//////
	
    while (oci_fetch($curs)) {

        $namerus=oci_result($curs, 1);
        $id=oci_result($curs, 2);

        $option.= "<option value='".$id."'>".$namerus."</option>";
		
		$row = getInstrumentProp($id);
		
		$data["{$id}"]  = array(
					settlement_date => $row['settlement_date'], 
					repayment_date => $row['repayment_date'], 
					coupon_annual_rate => $row['coupon_annual_rate'],  
					amount_ratio => $row['amount_ratio'],  
					freq_payments => $row['freq_payments']
				
				);
		
		/*$data = array(
		    $id => array(
			settlement_date => $row['settlement_date'], 
			repayment_date => $row['repayment_date'], 
			coupon_annual_rate => $row['coupon_annual_rate'],  
			amount_ratio => $row['amount_ratio'],  
			freq_payments => $row['freq_payments']
		)
		);*/
    //}
    }
    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error " . ora_error();
  }

$option.="</select>";

$opacc="<select name='account' style='width:145'>";


  if ($c = ora_logon(OP1,OP2))
  {
    $curso = oci_parse($c, "select acc.code,acc.id
from ".TS.".market m, ".TS.".sector s, ".TS.".tradeaccount acc, ".TS.".firm frm, ".TS.".moneyaccount money
where s.ownid=m.sect_id and m.mcode='T'
and acc.ownid=s.trdacsid
and acc.idorgan=frm.idorgan
and money.idfirm=frm.id
and acc.idmoney=money.id
and frm.id=".$_SESSION[PORTAL.'USER']['idfirm']);


    oci_execute($curso);
		//echo "select acc.code,acc.id from ".TS.".market m, ".TS.".sector s, ".TS.".tradeaccount acc, ".TS.".firm frm where s.ownid=m.sect_id and m.mcode='T' and acc.ownid=s.trdacsid and acc.idorgan=frm.idorgan and frm.id=".$_SESSION[PORTAL.'USER']['idfirm'];
		
    //if (is_resource($curso))
    //{
    //    $code= ora_getcolumn($curso, 0);
    //    $id=ora_getcolumn($curso, 1);

    //    $opacc.= "<option value='".$id."'>".$code."</option>";

    while (oci_fetch($curso)) {

        $code=oci_result($curso, 1);
        $id=oci_result($curso, 2);

        $opacc.= "<option value='".$id."'>".$code."</option>";
		
    }
    //}
    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error " . ora_error();
  }

$opacc.="</select>";




$out="
   <form method='POST' name='order_form' id='order_form'>
   
   <table>
   <tr><td colspan='2'>&nbsp</td></tr>
   <tr><td>Инструмент:</td><td>".$option."</td></tr>
   <tr><td>Торговый счет:</td><td>".$opacc."</td></tr>
   <tr><td>
   Желаемая доходность(%): </td><td><input type='text' name='profit' style='text-align:right' value='' onkeypress='event.returnValue=checkfloat()' onkeyup='recalcPrice(".json_encode($data).",".$algorithm_calculation.")'>
      </td></tr>
   <tr><td>Количество:</td><td><input name='volume' required style='text-align:right' value='100' onkeypress='event.returnValue=checkint();'></td></tr>
   <tr><td>
   Цена: </td><td><input type='text' style='text-align:right' readonly name='price' value='0.00' onkeypress='event.returnValue=checkfloat();'>
   </td></tr>
   <tr><td colspan='2'>&nbsp</td></tr>
   <tr><td align=right td colspan='2'>
   <nobr><input type='checkbox' value='1' name='comp' id='comp' onclick='block_field();'> Неконкурентный приказ</nobr>
   </td></tr>
   
   <tr><td colspan='2'>&nbsp</td></tr>
   <tr><td colspan='2' align='right'><input class='btn' type='submit' width='40' value='  Ок  '> <input class='btn danger' type='button' value='Отмена' onclick='close_porting();'></td></tr>
   <tr><td colspan='2'>&nbsp</td></tr>
   <input type='hidden' name='act' value='add_orders'>
   </table>
   </form>";

echo "<div class=\"window_caption\"><table width=\"100%\"><tr><td><b>Ввести приказ на аукцион</b></td><td align=\"right\"><span class=\"panel_item\" onclick=\"close_porting();\"><b>X</b></span></td></tr></table></div>".$out;
?>