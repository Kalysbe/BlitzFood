<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

$date1=date('d/m/Y');
$grand_total=0;
$grand_volume=0;
$grand_dl_total=0;
$grand_dl_volume=0;
$issue_v=0;
$issue_vnc=0;
$svol=0;
$sncvol=0;
$shname='';
$avg_doh=0;
$min_doh=1000;
$max_doh=0;
$status=0;

         if ($c = ora_logon(OP1,OP2))
         {

               $curs7 = @ora_do($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
   t.volume*round(t.price,2) as total,
   (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
   (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
   (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
   (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
   (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
   (select ((100-d.price)/d.price)*(360/ts.maket(c.shortname))*100 from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,c.shortname,t.status
from ls.auction_orders t, ".TS.".currinstrument c
where t.curr_id=c.id and date0=".MakeLongDate($date1)."  and t.idfirm=".$_SESSION[PORTAL.'USER']['idfirm']."
order by t.price desc");


                 $curs8 = @ora_do($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol from ls.auction_issue ai where ai.date0=".MakeLongDate($date1));

                 if (is_resource($curs8))
                 {
                    $issue_v=ora_getcolumn($curs8, 0);
                    $issue_vnc=ora_getcolumn($curs8, 1);
                    $svol=ora_getcolumn($curs8, 2);
                    $sncvol=ora_getcolumn($curs8, 3);
                 }


   echo "<table class='table-deals'>
         <tr>
         <td class='info_top' colspan='9'>
            Сделки
         </td>
         </tr>
         <tr>
         <td class='info_title' width='90'>
            Тип
         </td>
         <td class='info_title' width='100'>
            Объем приказа, шт
         </td>
         <td class='info_title' width='50'>
            Цена приказа
         </td>
         <td class='info_title' width='120'>
            Сумма приказа
         </td>
         <td class='info_title' width='100'>
            Дата/время сделки
         </td>
         <td class='info_title' width='100'>
            Объем сделки, шт
         </td>
         <td class='info_title' width='70'>
            Цена сделки
         </td>
         <td class='info_title' width='120'>
            Сумма сделки
         </td>
         <td class='info_title' width='100'>
            Доходность к погашению, %
         </td>
         </tr>";

    if (is_resource($curs7))
    {

        $type=ora_getcolumn($curs7, 0);
        $volume=ora_getcolumn($curs7, 1);
        $price=ora_getcolumn($curs7, 2);
        $total=ora_getcolumn($curs7, 3);
        $date=ora_getcolumn($curs7, 4);
        $time=ora_getcolumn($curs7, 5);
        $dl_volume=ora_getcolumn($curs7, 6);
        $dl_price=ora_getcolumn($curs7, 7);
        $dl_total=ora_getcolumn($curs7, 8);
        $doh=ora_getcolumn($curs7, 9);
        $shname=ora_getcolumn($curs7, 10);
        $status=ora_getcolumn($curs7,11);

        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
        if ($max_doh<$doh){$max_doh=$doh;};

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume+=$dl_volume;

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};

        echo "<tr>
         <td class='".$class."'>".$type."</td>
         <td class='".$class."' align='right'>".number_format($volume,0,',',' ')."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."'>".$date." ".$time."</td>
         <td class='".$class."' align='right'>".$dl_volume."</td>
         <td class='".$class."' align='right'>".$dl_price."</td>
         <td class='".$class."' align='right'>".$dl_total."</td>
         <td class='".$class."' align='right'>".$doh."</td>
         </tr>";

    while (ora_fetch($curs7)) {

        $type=ora_getcolumn($curs7, 0);
        $volume=ora_getcolumn($curs7, 1);
        $price=ora_getcolumn($curs7, 2);
        $total=ora_getcolumn($curs7, 3);
        $date=ora_getcolumn($curs7, 4);
        $time=ora_getcolumn($curs7, 5);
        $dl_volume=ora_getcolumn($curs7, 6);
        $dl_price=ora_getcolumn($curs7, 7);
        $dl_total=ora_getcolumn($curs7, 8);
        $doh=ora_getcolumn($curs7, 9);
        $shname=ora_getcolumn($curs7, 10);
        $status=ora_getcolumn($curs7,11);

        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
        if ($max_doh<$doh){$max_doh=$doh;};

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume+=$dl_volume;


        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};

        echo "<tr>
         <td class='".$class."'>".$type."</td>
         <td class='".$class."' align='right'>".number_format($volume,0,',',' ')."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."'>".$date." ".$time."</td>
         <td class='".$class."' align='right'>".$dl_volume."</td>
         <td class='".$class."' align='right'>".$dl_price."</td>
         <td class='".$class."' align='right'>".$dl_total."</td>
         <td class='".$class."' align='right'>".$doh."</td>
         </tr>";
    }
    }
         }

     echo "<tr><td class='info'><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_total, 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_volume, 0, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_total, 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     </tr>";

     $avg_price=($grand_dl_total/$grand_dl_volume);
     $avg_doh=((100-$avg_price)/$avg_price)*(360/MakeT($shname))*100;

         echo "</table><br><br>
         <b>Всего по аукциону:</b>
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
         <br>
         <table class='table-deals'>
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

         if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0)
         {
            echo "<br><br><table>
            <tr>
               <td>
                  <form method='POST'>
                  <input class='btn' type='submit' value='Подтвердить результаты аукциона'>
                  <input type='hidden' name='agree' value='1'>
                  </form>
               </td>
               <td>
                  <form method='POST'>
                  <input class='btn danger' type='submit' value='Отклонить результаты аукциона'>
                  <input type='hidden' name='agree' value='2'>
                  </form>
               </td>
            </tr>
            </table>";
         }



?>
