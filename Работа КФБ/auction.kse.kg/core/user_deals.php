<?php

if (!defined('WEB_ROOT')){die ('Oops...');}
if (!defined('NamCost')){die ('Oops...');}
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
$grand_total_lot=0;
$grand_volume_lot=0;
$grand_dl_total_lot=0;
$grand_dl_volume_lot=0;


         if ($c = ora_logon(OP1,OP2))
         {

               $curs7 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
   t.volume*round(t.price,2) as total,
   (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
   (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
   (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
   (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
   (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
   (select ((100-d.price)/d.price)*(360/ts.maket(c.shortname))*100 from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,c.shortname,t.status
from ls.auction_orders t, ".TS.".currinstrument c
where t.curr_id=c.id and date0=".MakeLongDate($date1)."  and t.idfirm=".$_SESSION[PORTAL.'USER']['idfirm']."
order by c.shortname,t.price desc");
								oci_execute($curs7);

                 $curs8 = oci_parse($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol from ls.auction_issue ai where ai.date0=".MakeLongDate($date1));
								 oci_execute($curs8);

                 if (oci_fetch($curs8))
                 {
                    $issue_v=oci_result($curs8, 1);
                    $issue_vnc=oci_result($curs8, 2);
                    $svol=oci_result($curs8, 3);
                    $sncvol=oci_result($curs8, 4);
                 }

   echo "<table class='table-deals'>
         <tr>
         <td class='info_top' colspan='9'>
            Сделки
         </td>
         </tr>
         <tr>
         <td class='info_title'>
            Тип
         </td>
         <td class='info_title'>
            Объем приказа, шт
         </td>
         <td class='info_title'>
            Цена приказа
         </td>
         <td class='info_title'>
            Сумма приказа
         </td>
         <td class='info_title'>
            Дата/время сделки
         </td>
         <td class='info_title'>
            Объем сделки, шт
         </td>
         <td class='info_title'>
            Цена сделки
         </td>
         <td class='info_title'>
            Сумма сделки
         </td>
         <td class='info_title'>
            Доходность к погашению, %
         </td>
         </tr>";

    /*if (is_resource($curs7))
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
        $namerus=$shname;
        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
        if ($max_doh<$doh){$max_doh=$doh;};

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};


        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume+=$dl_volume;

        $grand_total_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume_lot+=$volume;
        $grand_dl_total_lot+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume_lot+=$dl_volume;


        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};

        echo "
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$shname."
            </td>
          </tr>
        ";

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
		*/
		$namerus='';
		
    while (oci_fetch($curs7)) {

        $type=oci_result($curs7, 1);
        $volume=oci_result($curs7, 2);
        $price=oci_result($curs7, 3);
        $total=oci_result($curs7, 4);
        $date=oci_result($curs7, 5);
        $time=oci_result($curs7, 6);
        $dl_volume=oci_result($curs7, 7);
        $dl_price=oci_result($curs7, 8);
        $dl_total=oci_result($curs7, 9);
        $doh=oci_result($curs7, 10);
        $shname=oci_result($curs7, 11);
        $status=oci_result($curs7,12);

        $class='info';
        if (($namerus!=$shname) & ($namerus!='')){
          echo "<tr><td class='info'><b>Итого по лоту1:</b></td><td class='info' align='right'><b>".number_format($grand_volume_lot, 0, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                <td class='info' align='right'><b>".number_format($grand_total_lot, 2, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                <td class='info' align='right'><b>".number_format($grand_dl_volume_lot, 0, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                <td class='info' align='right'><b>".number_format($grand_dl_total_lot, 2, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                </tr>
                ";
          $grand_total_lot=0;
          $grand_volume_lot=0;
          $grand_dl_total_lot=0;
          $grand_dl_volume_lot=0;
        }
        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
        if ($max_doh<$doh){$max_doh=$doh;};

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume+=$dl_volume;

        $grand_total_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume_lot+=$volume;
        $grand_dl_total_lot+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume_lot+=$dl_volume;

        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};
        if (($namerus!=$shname) & ($namerus!='')){
        echo "
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$shname."
            </td>
          </tr>
        ";
        }
		if ($type == "Konkurent") 
			{$type_rus="Конкурентные";} 
		else 
			{$type_rus="Неконкурентные";}
		
        echo "<tr>
         <td class='".$class."'>".$type_rus."</td>
         <td class='".$class."' align='right'>".number_format($volume,0,',',' ')."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."'>".$date." ".$time."</td>
         <td class='".$class."' align='right'>".$dl_volume."</td>
         <td class='".$class."' align='right'>".$dl_price."</td>
         <td class='".$class."' align='right'>".$dl_total."</td>
         <td class='".$class."' align='right'>".$doh."</td>
         </tr>";
         $namerus=$shname;
    }
    //}
         }
     echo "<tr><td class='info'><b>Итого по лоту:</b></td><td class='info' align='right'><b>".number_format($grand_volume_lot, 0, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                <td class='info' align='right'><b>".number_format($grand_total_lot, 2, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                <td class='info' align='right'><b>".number_format($grand_dl_volume_lot, 0, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                <td class='info' align='right'><b>".number_format($grand_dl_total_lot, 2, ',', ' ')."</b></td>
                <td class='info'>&nbsp;</td>
                </tr>
                <tr>
         </tr>
                ";
     echo "<tr><td class='info'><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td>
     
     <td class='info' align='right'><b>".number_format($grand_total, 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_volume, 0, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_total, 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     </tr>
     </table><br><br>";
/*
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
         <table>
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
  */
         //test


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
$min_price=100;
$max_price=0;
$dl_volume=0;
$dl_total=0;

$tp='Конкурентный';
$tc=0;
$tnc=0;

         $curs11 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
   t.volume*t.price as total,
   (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
   (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
   (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
   (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
   (select (d.volume*d.price) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
   (select ((100-d.price)/d.price)*(360/ts.maket(c.shortname))*100 from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,c.shortname,t.status
from ls.auction_orders t, ".TS.".currinstrument c
where t.curr_id=c.id and date0=".MakeLongDate($date1)."
order by t.price desc");
					oci_execute($curs11);


                 $curs12 = oci_parse($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol, curr.shortname, ai.pred from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
                 oci_execute($curs12);
								 $shname='';
                 if (oci_fetch($curs12))
                 {
                    $issue_v=oci_result($curs12, 1);
                    $issue_vnc=oci_result($curs12, 2);
                    $svol=oci_result($curs12, 3);
                    $sncvol=oci_result($curs12, 4);
                    $shname=oci_result($curs12, 5);
                    $v=oci_result($curs12, 6);
                 }

     /*if (is_resource($curs11)){

        $type=ora_getcolumn($curs11, 0);
        $volume=ora_getcolumn($curs11, 1);
        $price=ora_getcolumn($curs11, 2);
        $total=ora_getcolumn($curs11, 3);
        $date=ora_getcolumn($curs11, 4);
        $time=ora_getcolumn($curs11, 5);
        $dl_volume=ora_getcolumn($curs11, 6);
        $dl_price=ora_getcolumn($curs11, 7);
        $dl_total=ora_getcolumn($curs11, 8);
        $doh=ora_getcolumn($curs11, 9);
        $shname=ora_getcolumn($curs11, 10);
        $status=ora_getcolumn($curs11,11);

        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
        if ($max_doh<$doh){$max_doh=$doh;};

        if ($min_price>$dl_price && $dl_price>0 && $dl_price!=''){$min_price=$dl_price;};

        if ($max_price<$dl_price){$max_price=$dl_price;};

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume+=$dl_volume;

        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};

     };*/

        while (oci_fetch($curs11)) {

        $type=oci_result($curs11, 1);
        $volume=oci_result($curs11, 2);
        $price=oci_result($curs11, 3);
        $total=oci_result($curs11, 4);
        $date=oci_result($curs11, 5);
        $time=oci_result($curs11, 6);
        $dl_volume=oci_result($curs11, 7);
        $dl_price=oci_result($curs11, 8);
        $dl_total=oci_result($curs11, 9);
        $doh=oci_result($curs11, 10);
        $shname=oci_result($curs11, 11);
        $status=oci_result($curs11,12);

        //важно
        if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}


        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
        if ($max_doh<$doh){$max_doh=$doh;};

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

        if ($min_price>$dl_price && $dl_price>0 && $dl_price!=''){$min_price=$dl_price;};

        if ($max_price<$dl_price){$max_price=$dl_price;};

        //if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
        //if ($max_doh<$doh){$max_doh=$doh;};




        if ($tnc==1)
        {
           $grand_volume_nc+=$volume;
           $grand_dl_total_nc+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
           $grand_dl_volume_nc+=$dl_volume;
        }

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume+=$dl_volume;

        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};

       };
       //считаем количество учасников
      $cnt_sql_us="select count(*)
      from
      (
      select distinct t.idfirm from ls.auction_orders t, ts.tradeaccount tt where date0=".MakeLongDate($date1)."
      ) tab";
      if ($cnt_us = ora_logon("ls@".SRV,"ls"))
         {
            $cc_us=oci_parse($cnt_us,$cnt_sql_us);
						oci_execute($cc_us);
            if (oci_fetch($cc_us))
            {
               $cnt_users= oci_result($cc_us, 1);
            }
      }
       /// itogovaya tablica
       echo "
           <br><br>
           <hr>
           <br>
           <b>Всего: </b>
           <table class='table-deals'>
             <tr>
               <td valign='top' width=40%>
                 <table class='table-deals'>
                   <tr>
                     <td class='info_title'>&nbsp;</td>
                     <td class='info_title'>Конкур-е</td>
                     <td class='info_title'>Неконкур-е</td>
                     <td class='info_title'>Всего</td>
                   </tr>
         ";
                    if ($itogi = ora_logon("ls@".SRV,"ls"))
                    {

                      $curs8 = oci_parse($itogi, "select ai.volume,ai.volume_nocomp,
                      (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol,
                      (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol,
                      curr.shortname, ai.pred, ai.tot,
                      (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price>0) as ud_svol,
                      (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price<0) as ud_sncvol
                      from ls.auction_issue ai, ".TS.".currinstrument curr
                      where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
											oci_execute($curs8);
                      $shname='';
                      /*if (is_resource($curs8))
                      {
                        $svol=ora_getcolumn($curs8, 2);
                        $sncvol=ora_getcolumn($curs8, 3);
                        $shname=ora_getcolumn($curs8, 4);
                        $v=ora_getcolumn($curs8, 5);
                        $tot=ora_getcolumn($curs8, 6);
                        $ud_svol=ora_getcolumn($curs8, 7);
                        $ud_sncvol=ora_getcolumn($curs8, 8);
                        $pred_v=($v*70/100);
                        $pred_vnc=($v-$pred_v);
                        $pred_v=$pred_v*NamCost;
                        $pred_vnc=$pred_vnc*NamCost;
                        $svol=$svol*NamCost;
                        $sncvol=$sncvol*NamCost;
                        $ud_svol=$ud_svol*NamCost;
                        $ud_sncvol=$ud_sncvol*NamCost;
                        echo "
                          <tr><td class='info_shortname' colspan=4>".$shname."</td></tr>
                          <tr>
                            <td class='info'><b>Предложение, сом</b></td>
                            <td class='info' align='right'>".number_format($pred_v, 0, ',', ' ')."</td>
                            <td class='info' align='right'>".number_format($pred_vnc, 0, ',', ' ')."</td>
                            <td class='info' align='right'>".number_format($pred_v+$pred_vnc, 0, ',', ' ')."</td>
                          </tr>
                          <tr>
                            <td class='info'><b>Спрос, сом</b></td>
                            <td class='info' align='right'>".number_format($svol, 0, ',', ' ')."</td>
                            <td class='info' align='right'>".number_format($sncvol, 0, ',', ' ')."</td>
                            <td class='info' align='right'>".number_format($sncvol+$svol, 0, ',', ' ')."</td>
                          </tr>
                          <tr>
                            <td class='info'><b>Удовлетв. спрос, сом</b></td>
                            <td class='info' align='right'>".number_format($ud_svol, 0, ',', ' ')."</td>
                            <td class='info' align='right'>".number_format($ud_sncvol, 0, ',', ' ')."</td>
                            <td class='info' align='right'>".number_format($ud_svol+$ud_sncvol, 0, ',', ' ')."</td>
                          </tr>
                        ";
												*/
                        while (oci_fetch($curs8))
                        {
                          $svol=oci_result($curs8, 3);
                          $sncvol=oci_result($curs8, 4);
                          $shname=oci_result($curs8, 5);
                          $v=oci_result($curs8, 6);
                          $tot=oci_result($curs8, 7);
                          $ud_svol=oci_result($curs8, 8);
                          $ud_sncvol=oci_result($curs8, 9);
                          $pred_v=($v*70/100);
                             $pred_vnc=($v-$pred_v);
                             $pred_v=$pred_v*NamCost;
                             $pred_vnc=$pred_vnc*NamCost;
                             $svol=$svol*NamCost;
                             $sncvol=$sncvol*NamCost;
                             $ud_svol=$ud_svol*NamCost;
                             $ud_sncvol=$ud_sncvol*NamCost;
                             echo "
                               <tr><td class='info_shortname' colspan=4>".$shname."</td></tr>
                               <tr>
                                 <td class='info'><b>Предложение, сом</b></td>
                                 <td class='info' align='right'>".number_format($pred_v, 0, ',', ' ')."</td>
                                 <td class='info' align='right'>".number_format($pred_vnc, 0, ',', ' ')."</td>
                                 <td class='info' align='right'>".number_format($pred_v+$pred_vnc, 0, ',', ' ')."</td>
                               </tr>
                               <tr>
                                 <td class='info'><b>Спрос, сом</b></td>
                                 <td class='info' align='right'>".number_format($svol, 0, ',', ' ')."</td>
                                 <td class='info' align='right'>".number_format($sncvol, 0, ',', ' ')."</td>
                                 <td class='info' align='right'>".number_format($sncvol+$svol, 0, ',', ' ')."</td>
                               </tr>
                               <tr>
                                <td class='info'><b>Удовлетв. спрос, сом</b></td>
                                <td class='info' align='right'>".number_format($ud_svol, 0, ',', ' ')."</td>
                                <td class='info' align='right'>".number_format($ud_sncvol, 0, ',', ' ')."</td>
                                <td class='info' align='right'>".number_format($ud_svol+$ud_sncvol, 0, ',', ' ')."</td>
                                </tr>
                             ";
                        }
                      //}
                   }
                    echo "  </table>
               </td>
               <td style='padding-left: 10px' valign='top'>
                 ";
                 //$qwery_str="select jopa from dual";
                 $qwery_str="select max(shortname),min(dl_price),max(dl_price),
                 sum(dl_volume*round(dl_price,2))/sum(dl_volume) avg_price,
                 min(dl_doh),max(dl_doh),
                 ((100-round(sum(dl_volume*round(dl_price,2))/sum(dl_volume),2))/round(sum(dl_volume*round(dl_price,2))/sum(dl_volume),2))*(360/ts.maket(max(shortname)))*100 avg_doh
                 from (
                   select t.price,
                   (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
                   (select round(d.price,2) from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
                   (select ((100-round(d.price,2))/round(d.price,2))*(360/ts.maket(c.shortname))*100 from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,c.shortname shortname,
                    c.id as curr
                    from ls.auction_orders t, ".TS.".currinstrument c
                    where t.curr_id=c.id and date0=".MakeLongDate($date1)."
                    order by shortname ASC,t.price DESC )
                    group by curr";
                 $curs_pr = oci_parse($itogi,$qwery_str);
								 oci_execute($curs_pr);
                 echo "
                 <table class='table-deals'>
                   <tr>
                     <td class='info_title' width='100'>&nbsp;</td>
                     <td class='info_title'>Максимальная цена</td>
                     <td class='info_title'>Минимальная цена</td>
                     <td class='info_title'>Средневзвешенная цена</td>
                   </tr>";
                   /*if (is_resource($curs_pr))
                   {
                     $name=ora_getcolumn($curs_pr,0);
                     $max_price=ora_getcolumn($curs_pr,2);
                     $min_price=ora_getcolumn($curs_pr,1);
                     $avg_price=ora_getcolumn($curs_pr,3);
                     $min_doh=ora_getcolumn($curs_pr,4);
                     $max_doh=ora_getcolumn($curs_pr,5);
                     $avg_doh=ora_getcolumn($curs_pr,6);
                     echo "
                       <tr><td class='info_shortname' colspan=4>".$name."</td></tr>
                       <tr>
                         <td class='info'><b>Цены аукциона, сом</b></td>
                         <td class='info' align='right'>".number_format($max_price,2,',',' ')."</td>
                         <td class='info' align='right'>".number_format($min_price,2,',',' ')."</td>
                         <td class='info' align='right'>".number_format($avg_price,2,',',' ')."</td>
                       </tr>
                       <tr>
                         <td class='info'><b>Доходность к погашению, %</b></td>
                         <td class='info' align='right'>".number_format($min_doh,4,',',' ')."</td>
                         <td class='info' align='right'>".number_format($max_doh,4,',',' ')."</td>
                         <td class='info' align='right'>".number_format($avg_doh,4,',',' ')."</td>
                         </tr>
                     ";
										 */
                     while (oci_fetch($curs_pr))
                     {
                       $name=oci_result($curs_pr,1);
                     $max_price=oci_result($curs_pr,3);
                     $min_price=oci_result($curs_pr,2);
                     $avg_price=oci_result($curs_pr,4);
                     $min_doh=oci_result($curs_pr,5);
                     $max_doh=oci_result($curs_pr,6);
                     $avg_doh=oci_result($curs_pr,7);
                     echo "
                       <tr><td class='info_shortname' colspan=4>".$name."</td></tr>
                       <tr>
                         <td class='info'><b>Цены аукциона, сом</b></td>
                         <td class='info' align='right'>".number_format($max_price,2,',',' ')."</td>
                         <td class='info' align='right'>".number_format($min_price,2,',',' ')."</td>
                         <td class='info' align='right'>".number_format($avg_price,2,',',' ')."</td>
                       </tr>
                       <tr>
                         <td class='info'><b>Доходность к погашению, %</b></td>
                         <td class='info' align='right'>".number_format($min_doh,4,',',' ')."</td>
                         <td class='info' align='right'>".number_format($max_doh,4,',',' ')."</td>
                         <td class='info' align='right'>".number_format($avg_doh,4,',',' ')."</td>
                         </tr>
                     ";
                     }
                   //}
                   echo "
                 </table>
               </td>
              </tr>
              <tr><td><br><br><strong>Всего участников аукциона: ".$cnt_users."</strong></td></tr>
          </table>
         ";







?>
