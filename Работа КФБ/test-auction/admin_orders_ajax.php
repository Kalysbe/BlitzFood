<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

$dt=MakeLongDate(date('d/m/Y'));
if ($_SESSION[PORTAL.'USER']['name']!='Administrator')
{
   die("Недостаточно прав для завершения операции!");
}

$vol_sum=0;

$vol_sum_n=0;
$vol_sum_lot=0;

$vol_sum_n_lot=0;


   echo "<table class='table-deals'><tr>
         <td class='info_top' colspan='7'>
            Приказы на покупку
         </td>
         </tr>

         <tr>
         <td class='info_title' width='200'>
            Инструмент
         </td>
         <td class='info_title' width='70'>
            Цена
         </td>
         <td class='info_title' width='70'>
            Доходность
         </td>
         <td class='info_title' width='70'>
            Количество
         </td>
	<td class='info_title' width='70'>
            Сумма
         </td>
         <td class='info_title' width='100'>
            Счет
         </td>
         <td class='info_title'  width='150'>
            Выставлено
         </td></tr>";

  if ($c = ora_logon(OP1,OP2))
  {
   //Comp

    echo "
    <tr>
         <td class='info' colspan='7'>
            &nbsp;
         </td>
         </tr>
    <tr>
         <td class='info_comp' colspan='7'>
            <b>Конкурентные</b>
         </td>
         </tr>";

    $curs1 = oci_parse($c, "select shortname, to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price,profit, volume,
    to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total,
    rowidtochar(t.rowid) as id, f.nick, t.status,acc.code, t.conf
              from ls.auction_orders t, ".TS.".ts_currinstrument_arcts curr, ".TS.".firm f, ".TS.".tradeaccount acc
              where t.curr_id=curr.id and date0=".$dt." and t.idfirm=f.id and price<>-1 and acc.id=t.account order by shortname,price desc");

             
		oci_execute($curs1);
    /*if (is_resource($curs1))
    {

        $namerus= ora_getcolumn($curs1, 0);
        $price=ora_getcolumn($curs1, 1);
        $volume=ora_getcolumn($curs1, 2);
        $id=ora_getcolumn($curs1, 3);
        $firm=ora_getcolumn($curs1, 4);
        $status=ora_getcolumn($curs1, 5);
        $acc=ora_getcolumn($curs1, 6);
        $name=$namerus;
        $class='info';

        $vol_sum+=$volume;
        $vol_sum_lot+=$volume;

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        echo "
          <tr>
            <td class='info_shortname' colspan='7'>
              Лот: ".$namerus."
            </td>
          </tr>
        ";

        echo "<tr>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".$volume."</td>
         <td class='".$class."'>".$acc."</td>
         <td class='".$class."'><nobr>".$firm."</nobr></td>
         </tr>";
		*/
		$name='';
    while (oci_fetch($curs1)) {

        $namerus= oci_result($curs1, 1);
        $price=oci_result($curs1, 2);
        $profit=oci_result($curs1, 3);
        $volume=oci_result($curs1, 4);
        $total=oci_result($curs1,5);
        $id=oci_result($curs1, 6);
        $firm=oci_result($curs1, 7);
        $status=oci_result($curs1, 8);
        $acc=oci_result($curs1, 9);
		$conf=oci_result($curs1, 10);

        $class='info';
        if (($name!=$namerus) & ($name!='')){
          echo"
          <tr>
         <td class='info_lot' colspan='3'>
            <b>Итого по лоту:</b>
         </td>
         <td class='info_lot'>
            <b>".number_format($vol_sum_lot, 0, ',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
            &nbsp;
         </td>
         </tr>
         ";
         $vol_sum_lot=0;
         $total_sum_lot=0;
        }
        if($conf==1) {
        $vol_sum+=$volume;
        $vol_sum_lot+=$volume;
        $total_sum+=floatval(str_replace(',','.',str_replace(' ','',$total)));;
        $total_sum_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));;
      }
        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}
				if ($conf==2){$class='info_red';}
				if ($conf==1){$class='info_green';}
				
        if (($name!=$namerus)){
        echo "
          <tr>
            <td class='info_shortname' colspan='7'>
              Лот: ".$namerus."
            </td>
          </tr>
        ";
        }
        echo "<tr>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".$profit."</td>
         <td class='".$class."'>".number_format($volume,0,',',' ')."</td>
	     <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".$acc."</td>
         <td class='".$class."'><nobr>".$firm."</nobr></td>
         </tr>";
       $name=$namerus;
    }
    //}
    echo"
          <tr>
         <td class='info_lot' colspan='3'>
            <b>Итого по лоту:</b>
         </td>
         <td class='info_lot'>
            <b>".number_format($vol_sum_lot, 0, ',', ' ')."</b>
         </td>
	    <td class='info_lot'>
            <b>".number_format($total_sum_lot,2,',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
            &nbsp;
         </td>
         </tr>
         ";
   //No Comp


    echo "<tr>
         <td class='info' colspan='3'>
            <b>Итого по конкурентным:</b>
         </td>
         <td class='info'>
            <b>".number_format($vol_sum, 0, ',', ' ')."</b>
         </td>
	<td class='info'>
            <b>".number_format($total_sum,2,',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
            &nbsp;
         </td>
         </tr>
         <tr>
         <td class='info' colspan='7'>
            &nbsp;
         </td>
         </tr>
         <tr>
         <td class='info_comp' colspan='7'>
            <b>Неконкурентные</b>
         </td>
         </tr>";

    $curs1 = oci_parse($c, "select shortname, price, volume, rowidtochar(t.rowid) as id, f.nick, t.status,acc.code, t.conf
              from ls.auction_orders t, ".TS.".ts_currinstrument_arcts curr, ".TS.".firm f, ".TS.".tradeaccount acc
              where t.curr_id=curr.id and date0=".$dt." and t.idfirm=f.id and price=-1 and acc.id=t.account order by shortname,volume desc");
		oci_execute($curs1);
    /*if (is_resource($curs1))
    {

        $namerus= ora_getcolumn($curs1, 0);
        $price=ora_getcolumn($curs1, 1);
        $volume=ora_getcolumn($curs1, 2);
        $id=ora_getcolumn($curs1, 3);
        $firm=ora_getcolumn($curs1, 4);
        $status=ora_getcolumn($curs1, 5);
        $acc=ora_getcolumn($curs1, 6);
        $name=$namerus;
        $class='info';

        $vol_sum_n+=$volume;
        $vol_sum_n_lot+=$volume;
        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}
        echo "
          <tr>
            <td class='info_shortname' colspan='7'>
              Лот: ".$namerus."
            </td>
          </tr>
        ";
        echo "<tr>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>-</td>
         <td class='".$class."'>".$volume."</td>
	<td class='".$class."'>".number_format($volume*100,2,',',' ')."</td>
         <td class='".$class."'>".$acc."</td>
         <td class='".$class."'><nobr>".$firm."</nobr></td>
         </tr>";
		*/
		$name='';
    while (oci_fetch($curs1)) {
        $namerus= oci_result($curs1, 1);
        $price=oci_result($curs1, 2);
        $volume=oci_result($curs1, 3);
        $id=oci_result($curs1, 4);
        $firm=oci_result($curs1, 5);
        $status=oci_result($curs1, 6);
        $acc=oci_result($curs1, 7);
		$conf=oci_result($curs1, 8);

        $class='info';
        if (($name!=$namerus) & ($name!='')){
          echo"
          <tr>
         <td class='info_lot' colspan='3'>
            <b>Итого по лоту:</b>
         </td>
         <td class='info_lot'>
            <b>".number_format($vol_sum_n_lot, 0, ',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
            &nbsp;
         </td>
         </tr>
         ";
         $vol_sum_n_lot=0;
        }

        if ($conf==1) {
         $vol_sum_n+=$volume;
         $vol_sum_n_lot+=$volume;
        }
        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}
				if ($conf==2){$class='info_red';}
				if ($conf==1){$class='info_green';}
				
        if (($name!=$namerus) ){
        echo "
          <tr>
            <td class='info_shortname' colspan='7'>
              Лот: ".$namerus."
            </td>
          </tr>
        ";
        }
        echo "<tr>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>-</td>
         <td class='".$class."'>-</td>
         <td class='".$class."'>".number_format($volume,0,',',' ')."</td>
 	<td class='".$class."'>".number_format($volume*100,2,',',' ')."</td>
         <td class='".$class."'>".$acc."</td>
         <td class='".$class."'><nobr>".$firm."</nobr></td>
         </tr>";
        $name=$namerus;
    }
    //}
    echo"
          <tr>
         <td class='info_lot' colspan='3'>
            <b>Итого по лоту:</b>
         </td>
         <td class='info_lot'>
            <b>".number_format($vol_sum_n_lot, 0, ',', ' ')."</b>
         </td>
	<td class='info_lot'>
            <b>".number_format($vol_sum_n_lot*100, 2, ',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
            &nbsp;
         </td>
         </tr>
         ";
    echo "<tr>
         <td class='info' colspan='3'>
            <b>Итого по неконкурентным:</b>
         </td>
         <td class='info'>
            <b>".number_format($vol_sum_n, 0, ',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
         <b>".number_format($vol_sum_n*NamCost, 2, ',', ' ')."</b>
         </td>
         </tr>
         <tr>
         <td class='info' colspan='7'>
            &nbsp;
         </td>
         </tr>
         <tr>
         <td class='info' colspan='3'>
            <b>Всего:</b>
         </td>
         <td class='info'>
            <b>".number_format(($vol_sum+$vol_sum_n), 0, ',', ' ')."</b>
         </td>
	<td class='info'>
            <b>".number_format($total_sum+($vol_sum_n*NamCost), 2, ',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
            &nbsp;
         </td>
         </tr>
         ";

    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error " . oci_error();
  }
  echo "</table>";

?>
