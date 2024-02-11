<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

$grand_total=0;
$grand_volume=0;

$grand_total_n=0;
$grand_volume_n=0;

$grand_total_lot=0;
$grand_volume_lot=0;

$grand_total_n_lot=0;
$grand_volume_n_lot=0;

$sum_doh=0;
$sum_doh_n=0;

if ($_SESSION['STATUS']==1 || $_SESSION['STATUS']>=3)
{
   echo "<br><br><table class='table-deals'>
         <tr>
         <td class='info_top' colspan='9'>
            Сделки
         </td>
         </tr>

         <tr>
         <td class='info_title' width='90'>
            Дата
         </td>
         <td class='info_title' width='50'>
            Время
         </td>
         <td class='info_title' width='100'>
            Инструмент
         </td>
         <td class='info_title' width='100'>
            Счет
         </td>
         <td class='info_title' width='70'>
            <nobr>Цена покупки</nobr>
         </td>
         <td class='info_title' width='70'>
            Количество
         </td>
         <td class='info_title' width='150'>
            Сумма
         </td>
         <td class='info_title' width='90'>
            Доходность к погашению, %
         </td>
         <td class='info_title' width='150'>
            Покупатель
         </td></tr>";


  if ($c = ora_logon(OP1,OP2))
  {

    echo "
    <tr>
         <td class='info' colspan='9'>
            &nbsp;
         </td>
         </tr>
    <tr>
         <td class='info_comp' colspan='9'>
            <b>Конкурентные</b>
         </td>
         </tr>";

      $curs2 = oci_parse($c, "select shortname,to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, volume, date0, time0, acc.code, f.nick, to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total, t.notfull,
      /*((100-round(t.price,2))/round(t.price,2))*(360/ts.maket(curr.shortname))*100*/ t.profit as doh
      from ls.auction_deals t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc, ".TS.".firm f where t.curr_id=curr.id and t.idfirm=f.id and date0=".$dt." and acc.id=t.account
      and t.notfull in (1,3) order by shortname,price desc");
			
			oci_execute($curs2);
			
     /*if (is_resource($curs2))
     {
        $shortname=ora_getcolumn($curs2, 0);
        $price=ora_getcolumn($curs2, 1);
        $volume=ora_getcolumn($curs2, 2);
        $date0=MakeDate(ora_getcolumn($curs2, 3));
        $time0=MakeTime(ora_getcolumn($curs2, 4));
        $account=ora_getcolumn($curs2, 5);
        $firm=ora_getcolumn($curs2, 6);
        $total=ora_getcolumn($curs2, 7);
        $status=ora_getcolumn($curs2, 8);
        $doh=ora_getcolumn($curs2, 9);
        $name=$shortname;
        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        //$doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        $sum_doh+=$doh*$volume;

        echo "
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$shortname."
            </td>
          </tr>
        ";

        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".number_format($doh, 4, ',', ' ')."</td>
         <td class='".$class."'>".$firm."</td>
         </tr>";

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$volume;
       $grand_total_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume_lot+=$volume;
			*/
			$name='';
      while (oci_fetch($curs2)) {
        $shortname=oci_result($curs2, 1);
        $price=oci_result($curs2, 2);
        $volume=oci_result($curs2, 3);
        $date0=MakeDate(oci_result($curs2, 4));
        $time0=MakeTime(oci_result($curs2, 5));
        $account=oci_result($curs2, 6);
        $firm=oci_result($curs2, 7);
        $total=oci_result($curs2, 8);
        $status=oci_result($curs2, 9);
        $doh=oci_result($curs2, 10);

        $class='info';
        if (($name!=$shortname) & ($name!='')){
          echo "<tr><td class='info' colspan=5><b>Итого по лоту:</b></td><td class='info'><b>".number_format($grand_volume_lot, 0, ',', ' ')."</b></td><td class='info'><b>".number_format($grand_total_lot, 2, ',', ' ')."</b></td><td class='info'></td>&nbsp;<td class='info'>&nbsp;</td></tr>";
          $grand_total_lot=0;
          $grand_volume_lot=0;
        }
        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        //$doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        
		if (($name!=$shortname)){
		echo " 
          <!--<tr><td class='info' colspan=5><b>Итого:</b></td><td class='info'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td><td class='info'><b>".number_format($grand_total, 2, ',', ' ')."</b></td><td class='info'><b>".number_format(($sum_doh/$grand_volume), 2, ',', ' ')."</b></td><td class='info'>&nbsp;</td></tr>-->
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$shortname."
            </td>
          </tr>
        ";
        }
		
        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".number_format($doh, 2, ',', ' ')."</td>
         <td class='".$class."'>".$firm."</td>
         </tr>";

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_total_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume_lot+=$volume;
        $name=$shortname;
		$sum_doh+=$doh*floatval(str_replace(',','.',str_replace(' ','',$total)));
       }
     //}
	 #------------
     echo "<tr><td class='info' colspan=5><b>Итого по лоту:</b></td><td class='info'><b>".number_format($grand_volume_lot, 0, ',', ' ')."</b></td><td class='info'><b>".number_format($grand_total_lot, 2, ',', ' ')."</b></td><td class='info'></td>&nbsp;<td class='info'>&nbsp;</td></tr>";
     echo "<tr><td class='info' colspan=5><b>Итого по конкурентным:</b></td><td class='info'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td><td class='info'><b>".number_format($grand_total, 2, ',', ' ')."</b></td><td class='info'><b>".number_format(($sum_doh/$grand_total), 2, ',', ' ')."</b></td><td class='info'>&nbsp;</td></tr>";


    echo "
    <tr>
         <td class='info' colspan='9'>
            &nbsp;
         </td>
         </tr>
    <tr>
         <td class='info_comp' colspan='9'>
            <b>Неконкурентные</b>
         </td>
         </tr>";

      $curs2 = oci_parse($c, "select shortname,to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, volume, date0, time0, acc.code, f.nick, to_char(round(price,2)*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total, t.notfull,
      /*((100-round(t.price,2))/round(t.price,2))*(360/ts.maket(curr.shortname))*100*/ t.profit as doh
      from ls.auction_deals t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc, ".TS.".firm f where t.curr_id=curr.id and t.idfirm=f.id and date0=".$dt." and acc.id=t.account
      and t.notfull in (2,4) order by shortname,volume desc");
			oci_execute($curs2);
     /*if (is_resource($curs2))
     {
        $shortname=ora_getcolumn($curs2, 0);
        $price=ora_getcolumn($curs2, 1);
        $volume=ora_getcolumn($curs2, 2);
        $date0=MakeDate(ora_getcolumn($curs2, 3));
        $time0=MakeTime(ora_getcolumn($curs2, 4));
        $account=ora_getcolumn($curs2, 5);
        $firm=ora_getcolumn($curs2, 6);
        $total=ora_getcolumn($curs2, 7);
        $status=ora_getcolumn($curs2, 8);
        $doh=ora_getcolumn($curs2, 9);
        $name=$shortname;
        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        //$doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        $sum_doh_n+=$doh*$volume;

        echo "
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$shortname."
            </td>
          </tr>
        ";

        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".number_format($doh, 4, ',', ' ')."</td>
         <td class='".$class."'>".$firm."</td>
         </tr>";


       $grand_total_n+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume_n+=$volume;
       $grand_total_n_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume_n_lot+=$volume;

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$volume;
			*/
			$name='';
       while (oci_fetch($curs2)) {

        $shortname=oci_result($curs2, 1);
        $price=oci_result($curs2, 2);
        $volume=oci_result($curs2, 3);
        $date0=MakeDate(oci_result($curs2, 4));
        $time0=MakeTime(oci_result($curs2, 5));
        $account=oci_result($curs2, 6);
        $firm=oci_result($curs2, 7);
        $total=oci_result($curs2, 8);
        $status=oci_result($curs2, 9);
        $doh=oci_result($curs2, 10);

        $class='info';
        if (($name!=$shortname) & ($name!='')){
          echo "<tr><td class='info' colspan=5><b>Итого по лоту:</b></td><td class='info'><b>".number_format($grand_volume_n_lot, 0, ',', ' ')."</b></td><td class='info'><b>".number_format($grand_total_n_lot, 2, ',', ' ')."</b></td><td class='info'>&nbsp;</td><td class='info'>&nbsp;</td></tr>";
          $grand_total_n_lot=0;
          $grand_volume_n_lot=0;
        };

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        //$doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        $sum_doh_n+=$doh*$volume;
         if (($name!=$shortname)){
        echo "
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$shortname."
            </td>
          </tr>
        ";
        }
        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".number_format($doh, 2, ',', ' ')."</td>
         <td class='".$class."'>".$firm."</td>
         </tr>";

        $grand_total_n+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume_n+=$volume;
        $grand_total_n_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume_n_lot+=$volume;

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $name=$shortname;
       }
     //}
     echo "<tr><td class='info' colspan=5><b>Итого по лоту:</b></td><td class='info'><b>".number_format($grand_volume_n_lot, 0, ',', ' ')."</b></td><td class='info'><b>".number_format($grand_total_n_lot, 2, ',', ' ')."</b></td><td class='info'>&nbsp;</td><td class='info'>&nbsp;</td></tr>";
     echo "<tr>
     <td class='info' colspan=5><b>Итого по неконкурентным:</b></td>
     <td class='info'><b>".number_format($grand_volume_n, 0, ',', ' ')."</b></td>
     <td class='info'><b>".number_format($grand_total_n, 2, ',', ' ')."</b></td>
     <td class='info'><b>".number_format(($sum_doh_n/$grand_volume_n), 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     </tr>";


     echo "<tr>
         <td class='info' colspan='9'>
            &nbsp;
         </td>
         </tr>
     <tr><td class='info' colspan=5><b>Всего:</b></td><td class='info'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td><td class='info'><b>".number_format($grand_total, 2, ',', ' ')."</b></td><td class='info'><b></b></td><td class='info'>&nbsp;</td></tr>";


     echo "</table>";
     ora_logoff($c);
  }
  else
  {
     echo "Oracle Connect Error " . ora_error();
  }

}
//.number_format((($sum_doh+$sum_doh_n)/($grand_volume+$grand_volume_n)), 4, ',', ' ').
?>
