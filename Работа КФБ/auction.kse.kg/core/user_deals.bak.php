<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

$dt=MakeLongDate(date('d/m/Y'));
$grand_total=0;
$grand_volume=0;

$grand_total_n=0;
$grand_volume_n=0;

$sum_doh=0;
$sum_doh_n=0;

if ($_SESSION['STATUS']>=3)
{
   echo "<table class='table-deals'>
         <tr>
         <td class='info_top' colspan='8'>
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
         <td class='info_title' width='70'>
            Счет
         </td>
         <td class='info_title' width='70' align='right'>
            <nobr>Цена покупки</nobr>
         </td>
         <td class='info_title' width='70' align='right'>
            Количество
         </td>
         <td class='info_title' width='100' align='right'>
            Сумма
         </td>
         <td class='info_title' width='100' align='right'>
            Доходность к погашению, %
         </td>
         </tr>";

  if ($c = ora_logon(OP1,OP2))
  {

    echo "
    <tr>
         <td class='info' colspan='8'>
            &nbsp;
         </td>
         </tr>
    <tr>
         <td class='info_comp' colspan='8'>
            <b>Конкурентные</b>
         </td>
         </tr>";

      $curs2 = @ora_do($c, "select shortname,to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, volume, date0, time0, acc.code, to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total, t.notfull from ls.auction_deals t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc where t.curr_id=curr.id and t.idfirm=".$_SESSION[PORTAL.'USER']['idfirm']." and date0=".$dt." and acc.id=t.account and t.notfull in (1,3) order by price desc");

     if (is_resource($curs2))
     {
        $shortname=ora_getcolumn($curs2, 0);
        $price=ora_getcolumn($curs2, 1);
        $volume=ora_getcolumn($curs2, 2);
        $date0=MakeDate(ora_getcolumn($curs2, 3));
        $time0=MakeTime(ora_getcolumn($curs2, 4));
        $account=ora_getcolumn($curs2, 5);
        $total=ora_getcolumn($curs2, 6);
        $status=ora_getcolumn($curs2, 7);

        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        $doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        $sum_doh+=(((100-$price)/$price)*(360/MakeT($shortname))*100)*$volume;

        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."' align='right'>".$doh."</td>
         </tr>";

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$volume;

       while (ora_fetch($curs2)) {

        $shortname=ora_getcolumn($curs2, 0);
        $price=ora_getcolumn($curs2, 1);
        $volume=ora_getcolumn($curs2, 2);
        $date0=MakeDate(ora_getcolumn($curs2, 3));
        $time0=MakeTime(ora_getcolumn($curs2, 4));
        $account=ora_getcolumn($curs2, 5);
        $total=ora_getcolumn($curs2, 6);
        $status=ora_getcolumn($curs2, 7);

        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        $doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        $sum_doh+=(((100-$price)/$price)*(360/MakeT($shortname))*100)*$volume;

        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."' align='right'>".$doh."</td>
         </tr>";

         $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
         $grand_volume+=$volume;
       }
     }
     echo "<tr><td class='info' colspan=5><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td><td class='info' align='right'><b>".number_format($grand_total, 2, ',', ' ')."</b></td><td class='info' align='right'><b>".number_format(($sum_doh/$grand_volume), 4, ',', ' ')."</b></td></tr>";


    echo "
    <tr>
         <td class='info' colspan='8'>
            &nbsp;
         </td>
         </tr>
    <tr>
         <td class='info_comp' colspan='8'>
            <b>Неконкурентные</b>
         </td>
         </tr>";

      $curs2 = @ora_do($c, "select shortname,to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, volume, date0, time0, acc.code, to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total, t.notfull from ls.auction_deals t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc where t.curr_id=curr.id and t.idfirm=".$_SESSION[PORTAL.'USER']['idfirm']." and date0=".$dt." and acc.id=t.account and t.notfull in (2,4) order by volume desc");

     if (is_resource($curs2))
     {
        $shortname=ora_getcolumn($curs2, 0);
        $price=ora_getcolumn($curs2, 1);
        $volume=ora_getcolumn($curs2, 2);
        $date0=MakeDate(ora_getcolumn($curs2, 3));
        $time0=MakeTime(ora_getcolumn($curs2, 4));
        $account=ora_getcolumn($curs2, 5);
        $total=ora_getcolumn($curs2, 6);
        $status=ora_getcolumn($curs2, 7);

        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        $doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        $sum_doh_n+=(((100-$price)/$price)*(360/MakeT($shortname))*100)*$volume;

        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."' align='right'>".$doh."</td>
         </tr>";

       $grand_total_n+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume_n+=$volume;

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$volume;

       while (ora_fetch($curs2)) {

        $shortname=ora_getcolumn($curs2, 0);
        $price=ora_getcolumn($curs2, 1);
        $volume=ora_getcolumn($curs2, 2);
        $date0=MakeDate(ora_getcolumn($curs2, 3));
        $time0=MakeTime(ora_getcolumn($curs2, 4));
        $account=ora_getcolumn($curs2, 5);
        $total=ora_getcolumn($curs2, 6);
        $status=ora_getcolumn($curs2, 7);

        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

        $doh=number_format(((100-$price)/$price)*(360/MakeT($shortname))*100, 4, ',', ' ');
        $sum_doh_n+=(((100-$price)/$price)*(360/MakeT($shortname))*100)*$volume;

        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".number_format($volume, 0, ',', ' ')."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."' align='right'>".$doh."</td>
         </tr>";

         $grand_total_n+=floatval(str_replace(',','.',str_replace(' ','',$total)));
         $grand_volume_n+=$volume;

         $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
         $grand_volume+=$volume;
       }
     }
     echo "<tr><td class='info' colspan=5><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume_n, 0, ',', ' ')."</b></td><td class='info' align='right'><b>".number_format($grand_total_n, 2, ',', ' ')."</b></td><td class='info' align='right'><b>".number_format(($sum_doh_n/$grand_volume_n), 4, ',', ' ')."</b></td></tr>";


     echo "<tr>
         <td class='info' colspan='8'>
            &nbsp;
         </td>
         </tr>
     <tr><td class='info' colspan=5><b>Всего:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td><td class='info' align='right'><b>".number_format($grand_total, 2, ',', ' ')."</b></td><td class='info' align='right'><b>".number_format((($sum_doh+$sum_doh_n)/($grand_volume+$grand_volume_n)), 4, ',', ' ')."</b></td></tr>";

     echo "</table>";

     $curs8 = @ora_do($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol from ls.auction_issue ai where ai.date0=".$dt);

                 if (is_resource($curs8))
                 {
                    $issue_v=ora_getcolumn($curs8, 0);
                    $issue_vnc=ora_getcolumn($curs8, 1);
                    $svol=ora_getcolumn($curs8, 2);
                    $sncvol=ora_getcolumn($curs8, 3);
                 }

         echo "<br><br>
         <table class='table-deals'>
         <tr>
            <td class='info_title'>
               &nbsp;
            </td>
            <td class='info_title'>
               Конкурентные
            </td>
            <td class='info_title'>
               Неконкурентные
            </td>
         </tr>
         <tr>
            <td class='info'>
               Предложение
            </td>
            <td class='info' align='right'>
               ".number_format($issue_v, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($issue_vnc, 0, ',', ' ')."
            </td>
         </tr>
         <tr>
            <td class='info'>
               Спрос
            </td>
            <td class='info' align='right'>
               ".number_format($svol, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($sncvol, 0, ',', ' ')."
            </td>
         </tr>
         </table>
         <br>";

     $curs9 = @ora_do($c, "select maxdoh,mindoh,((100-avgpr)/avgpr)*(360/t)*100 as avgdoh from (
select max(((100-d.price)/d.price)*(360/ts.maket(c.shortname))*100) as maxdoh,
min(((100-d.price)/d.price)*(360/ts.maket(c.shortname))*100) as mindoh,
sum(d.volume*d.price) / sum(d.volume) as avgpr, max(ts.maket(c.shortname)) as t
from ls.auction_deals d, ".TS.".currinstrument c where
date0=".$dt."
and d.curr_id=c.id) tt");

                 if (is_resource($curs9))
                 {
                    $max_doh=ora_getcolumn($curs9, 0);
                    $min_doh=ora_getcolumn($curs9, 1);
                    $avg_doh=ora_getcolumn($curs9, 2);
                 }

     echo "         <table class='table-deals'>
         <tr>
            <td class='info_title' width='100'>
               &nbsp;
            </td>
            <td class='info_title'>
               Максимальная
            </td>
            <td class='info_title'>
               Минимальная
            </td>
            <td class='info_title'>
               Средневзвешенная
            </td>
         </tr>
         <tr>
            <td class='info'>
               Доходность к погашению, %
            </td>
            <td class='info' align='right'>
               ".number_format($max_doh,4,',',' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($min_doh,4,',',' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($avg_doh,4,',',' ')."
            </td>
         </tr>
         </table>
         ";

     ora_logoff($c);
  }
  else
  {
     echo "Oracle Connect Error " . ora_error();
  }

}

?>
