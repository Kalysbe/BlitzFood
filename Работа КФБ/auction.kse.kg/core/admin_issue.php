<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

$dt=MakeLongDate(date('d/m/Y'));
$curr='';
$price='';
$volume='';
$id='';

if (isset($_POST['currinstrument']))
{
   $curr=intval($_POST['currinstrument']);
}

if (isset($_POST['settlement_date']))
{
   $settlement_date=MakeLongDate($_POST['settlement_date']);
}

if (isset($_POST['repayment_date']))
{
   $repayment_date=MakeLongDate($_POST['repayment_date']);
}

//if (isset($_POST['price']))
//{
//   $price=floatval($_POST['price']);
//}

if (isset($_POST['volume']))
{
   $volume=intval($_POST['volume']);
}

if (isset($_POST['volume_nocomp']))
{
   $volume_nocomp=intval($_POST['volume_nocomp']);
}

$volume_nocomp=round($volume*30/100);
$volume=$volume-$volume_nocomp;

if (isset($_GET['id']))
{
   $id=safe($_GET['id']);
}
$v=$volume+$volume_nocomp;
switch ($act)
{
   case 'add_issue':
   {
      
	  if ($c = ora_logon(OP1,OP2))
	  {
		  $sql_s = "select t.shortname, t.CUPONTAX, t.NOMINAL, t.PAYCNT, t.OP_CTRCURR, 1/* эта функ. в ТС не работает*/ from ".TS.".CURRINSTRUMENT t where t.ID=".$curr." order by t.shortname";
		  $stmt = oci_parse($c, $sql_s);
echo "hui".$sql_s;							
		  oci_execute($stmt);
		  while (oci_fetch($stmt)) {
			  $coupon_annual_rate = oci_result($stmt, 2); // годовая ставка
			  $amount_ratio = oci_result($stmt, 3);       // цена погашения(номинал)
			  $price=$amount_ratio;
			  $freq_payments = oci_result($stmt, 4);	  // частота выплат
			  $currency = oci_result($stmt, 5);			  // валюта
			  $basis = oci_result($stmt, 6);		  	  // базис act/360
		  }
		  ora_logoff($c);
	  } else
	  {
		  echo "Oracle Connect Error "; //. trigger_error(htmlentities(oci_error(['message'])), E_USER_ERROR);
	  }
	  
	  $sql="insert into ls.auction_issue (curr_id,price,volume, volume_nocomp,date0,pred,tot, SETTLEMENT_DATE, REPAYMENT_DATE, COUPON_ANNUAL_RATE, AMOUNT_RATIO, FREQ_PAYMENTS, CURRENCY, BASIS, price_nocomp, profit_nocomp) values (".
         $curr.",".$price.",".$volume.",".$volume_nocomp.",".$dt.",".$v.",".$volume.",".$settlement_date.",".$repayment_date.",".$coupon_annual_rate.",".$amount_ratio.",".$freq_payments.",".$currency.",".$basis.",0, 0)";
echo $sql;
		 if ($c = ora_logon("ls@".SRV,"ls"))
      {
        $stmt = oci_parse($c, $sql); 
				oci_execute($stmt);
      }
      echo "Добавление. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
      break;
      exit();
   }
   case 'del_issue':
   {
      $sql="delete from ls.auction_issue where rowid = chartorowid('".$id."')";
      if ($c = ora_logon("ls@".SRV,"ls"))
      {
         	$stmt = oci_parse($c, $sql); 
					oci_execute($stmt);
      }
      echo "Удаление. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
      break;
      exit();
   }
};

   echo "<table class='table-deals'>
         <tr>
         <tr class='info_top' colspan='7'>
            Лот
         </tr>
         </tr>

         <tr>
         <td class='info_title' width='200'>
            Инструмент
         </td>
         <td class='info_title' width='70'>
            <nobr>Номинал</nobr>
         </td>
		 <td class='info_title' width='80'>
            Дата расчета
         </td>
         <td class='info_title' width='80'>
            Дата погашения
         </td>
         <td class='info_title' width='70'>
            Кол-во конкурентных
         </td>
         <td class='info_title' width='70'>
            Кол-во неконкурентных
         </td>
         <td class='info_title' width='10'>&nbsp;</td>
         </tr>";

  if ($c = ora_logon(OP1,OP2))
  {
      $stmt = oci_parse($c, "select shortname, to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price, settlement_date, repayment_date, volume, rowidtochar(t.rowid), volume_nocomp from ls.auction_issue t, ".TS.".ts_currinstrument_arcts curr where t.curr_id=curr.id and t.date0=".$dt." order by shortname"); 
	  oci_execute($stmt);
	//if (is_resource($curs))
    //{

    //    $namerus= ora_getcolumn($curs, 0);
    //    $price=ora_getcolumn($curs, 1);
    //    $volume=ora_getcolumn($curs, 2);
     //   $id=ora_getcolumn($curs, 3);
    //    $volume_nocomp=ora_getcolumn($curs, 4);

     //   echo "<tr>
     //    <td class='info' width='200'>".$namerus."</td>
     //    <td class='info' width='70'>".$price."</td>
      //   <td class='info' width='70'>".$volume."</td>
      //   <td class='info' width='70'>".$volume_nocomp."</td>
     //    <td class='info' width='10'><a href='javascript:confirm_del(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&act=del_issue&id=".$id."\");'><img src='./img/delete.gif' alt='del' title='Удалить'></a></td>
      //   </tr>";

    while (oci_fetch($stmt)) {

        $namerus= oci_result($stmt, 1);
        $price=oci_result($stmt, 2);
		$settlement_date=MakeDate(oci_result($stmt,3));
		$repayment_date=MakeDate(oci_result($stmt, 4));
        $volume=oci_result($stmt, 5);
        $id=oci_result($stmt, 6);
        $volume_nocomp=oci_result($stmt, 7);

        echo "<tr>
         <td class='info' width='200'><a href='javascript:show_issue_prop(\"".$namerus."\")'>".$namerus."</a></td>
         <td class='info' width='70' align='right'>".$price."</td>
         <td class='info' width='100' align='right'>".$settlement_date."</td>
		   <td class='info' width='100' align='right'>".$repayment_date."</td>
		   <td class='info' width='70' align='right'>".$volume."</td>
         <td class='info' width='70' align='right'>".$volume_nocomp."</td>
         <td class='info' width='10'><a href='javascript:confirm_del(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&act=del_issue&id=".$id."\");'><img src='./img/delete.gif' alt='del' title='Удалить'></a></td>
         </tr>";
    }
    //}
    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error". oci_error();
  }

  echo  "</table><br>
         <button class='btn' onclick='add_lot();'>
            <svg xmlns='http://www.w3.org/2000/svg' height='24' width='24'>
               <path d='M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4Zm1 5q-2.075 0-3.9-.788-1.825-.787-3.175-2.137-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175 1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138 1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-2q3.35 0 5.675-2.325Q20 15.35 20 12q0-3.35-2.325-5.675Q15.35 4 12 4 8.65 4 6.325 6.325 4 8.65 4 12q0 3.35 2.325 5.675Q8.65 20 12 20Zm0-8Z'/>
            </svg>
            Добавить инструмент
         </button><br>
  <div class='porting_alert' id='porting_alert' align='center'><div class='porting' id='porting'></div></div>";


?>
