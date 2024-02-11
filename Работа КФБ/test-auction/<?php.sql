<?php

if (!defined('WEB_ROOT')){die ('Oops...');}
if (!defined('NamCost')){die ('Oops...');}

$date1=date('d/m/Y');
$firm=0;
$nocomp=0;

$grand_total=0;
$grand_volume=0;
$grand_dl_total=0;
$grand_dl_volume=0;
$grand_volume_nc=0;
$grand_dl_total_nc=0;
$grand_dl_volume_nc=0;
$issue_v=0;
$issue_vnc=0;
$svol=0;
$sncvol=0;
$shname='';
$avg_doh=0;
$min_doh=1000;
$max_doh=0;
$min_price=100;
$max_price=0;
$status=0;
if (isset($_POST['txtDate']))
{$date1=$_POST['txtDate'];}
if (isset($_POST['firm']))
{$firm=intval($_POST['firm']);}
if (isset($_POST['nocomp']))
{$nocomp=intval($_POST['nocomp']);}

$_SESSION['date1']=$date1;
$_SESSION['firm']=$firm;
$_SESSION['nocomp']=$nocomp;
$_SESSION['num']=0;
$reps=array(0=>'Выберите отчет');
$reps[1]='Сводная ведомость';

if ($_SESSION[PORTAL.'USER']['admin']==1)
{
   $reps[3]='Сводная ведомость 2';
   $reps[2]='Классификация заявок';
}
$rp=0;
if (isset($_POST['rep']))
{
   $rp=intval($_POST['rep']);
}
if (isset($_GET['arg'])){
  sel($_GET['arg'],MakeLongDate($date1));
}
/*
$r1="<option value='1'>Заявки на покупку</option>";
if (isset($_POST['rep']) && $_POST['rep']==2)
{
   $r2="<option value='2' selected>Сделки</option>";
}
else
{
   $r2="<option value='2'>Сделки</option>";
}
*/

if ($_SESSION[PORTAL.'USER']['admin']==2)
{
   if ($_SESSION['STATUS']<1)
   {
      echo "Этап предварительных расчетов еще не наступил...<br>Зайдите пожалуйста в установленное регламентом время.";
      exit();
   }
   /*if (isset($_POST['agree']))
   {
      $agree=intval($_POST['agree']);
      $sql="update ls.auction_options set mf=".$agree." where date0=".MakeLongDate($date1);
      if ($c = ora_logon("ls@".SRV,"ls"))
      {
         ora_do($c,$sql);
      }
      echo "Подтверждение результатов аукциона. Подождите немного...<script>document.location='".WEB_ROOT."?go=".$go."&page=".$page."'</script>";
      exit();
   } */
}

function mk_rp_select($item,$key)
{

   global $reports;
   global $rp;

   $mark='';
   if ($rp==$key){$mark=' selected ';};

   $reports.="<option value='".$key."'".$mark.">".$item."</option>";

}

$reports="<select name='report' onchange='report_options(this.value);'>";
array_walk($reps,'mk_rp_select');
$reports.="</select>";

if ($_SESSION[PORTAL.'USER']['admin']==1)
{
echo "<b>Отчет:</b><br><br>".$reports."

<form method='POST'><div name='report_options' id='report_options' class='panel'><br><br></div></form>";

}
else
{
   $_POST['rep']=3;
}

if (isset($_POST['rep']))
{
   switch ($_POST['rep'])
   {
      case 1: {
        $grand_total_vs=0;
        $grand_volume_vs=0;
        $grand_dl_total_vs=0;
        $grand_dl_volume_vs=0;
        $st=0;
        $tp='Конкурентный';
        $tc=0;
        $tnc=0;
        $num=0;
        $namerus='';
       
        if ($c = ora_logon(OP1,OP2))
        {
             
                $curs7 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
  t.volume*t.price as total,
  (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
  (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
  (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
  (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
  (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
   i.profit_nocomp_avg as profit,t.profit as ord
from ls.auction_orders t, ".TS.".currinstrument c,ls.auction_issue i 
where t.curr_id=c.id and t.curr_id = i.curr_id and t.date0=".MakeLongDate($date1)." and i.date0=".MakeLongDate($date1)."
order by shortname ASC,t.price DESC");


                                 oci_execute($curs7);

                $curs8 = oci_parse($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol, curr.shortname, curr.namerus, ai.pred, ai.tot from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
                oci_execute($curs8);
              
                $curs9 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp,  
                (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume from ls.auction_orders t,
                ".TS.".currinstrument c,ls.auction_issue i where t.curr_id=c.id and t.curr_id = i.curr_id and t.date0=".MakeLongDate($date1)." and i.date0=".MakeLongDate($date1)." order by shortname ASC,t.price DESC");
               
                oci_execute($curs9);


                $curs81 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp,
                sum(t.volume) as volume,
                avg(t.price) as price,
                c.cupontax
                from ls.auction_orders t, ".TS.".currinstrument c  
                where t.curr_id=c.id and date0=".MakeLongDate($date1)." group by ls.auction_make_comp(t.price), c.cupontax");
                
                     oci_execute($curs81);
                     if (oci_fetch($curs81))
                        {
                          $cupon_tax=oci_result($curs81, 4);
                        }
               
                                $shname='';
                if (oci_fetch($curs8))
                {
                   $issue_v=oci_result($curs8, 1);
                   $issue_vnc=oci_result($curs8, 2);
                   $svol=oci_result($curs8, 3);
                   $sncvol=oci_result($curs8, 4);
                   $shname=oci_result($curs8, 5);
                   $typeGsb=oci_result($curs8, 6);
                   $v=oci_result($curs8, 7);
                   $tot=oci_result($curs8, 8);
                }
                $curs_ex=oci_parse($c,"select t.extcode from ".TS.".currinstrument t where shortname ='".$shname."' ");
                                oci_execute($curs_ex);
                                
                if (oci_fetch($curs_ex))
                {
                   $extcode=oci_result($curs_ex, 1);
                }

      
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
          
      $appealPeriod = ''; 
      if(substr($shname,0,3) == "GBA"){$appealPeriod = "364 дней";} else{$appealPeriod = "2 года";};   

  echo "
  <button class='btn control' onclick='print_version();'>Распечатать отчет</button>
 <table width='100%'>
 <tr>
 <td colspan='10' align='left'>
 <span class='print_caption'>
 <div width='100%' align='center'>
 Сводная ведомость 
 </div> <br>
 </span>
 </td>
 </tr>
 <tr>
 <td align='right' colspan='12'>
 ".$date1."
 </td>
 </tr>
 <tr>
 <td colspan='8' align='left'>
 <b>
    Общая информация по аукциону: <br>
 </b>
 </td>
 <td colspan='2' valign='bottom' align='right'>

 </td>
 </tr>
 </table>
       <table class='new-report short' border='1'>
         <tr class='info'>
               <td class='info'>Дата аукциона</td>
               <td class='info'>".$date1."</td>
         </tr>
         <tr class='info'>
               <td class='info'>Вид ГЦБ</td>
               <td class='info'>$typeGsb</td>
         </tr>
         <tr class='info'>
               <td class='info'>Срок обращения ГЦБ</td>
               <td class='info'>".$appealPeriod."</td>
         </tr>
         <tr class='info'>
               <td class='info'>Регистрационный номер</td>
               <td class='info'>".$shname."</td>
         </tr>
         <tr class='info'>
               <td class='info'>Количество ГЦБ (в штуках)</td>
               <td class='info'>".number_format($v/NamCost,2,',',' ')."</td>
         </tr>
         <tr class='info'>
                <td class='info'>Объем предложения</td>
                <td class='info'>".number_format($v,2,',',' ')."</td>
         </tr>
         <tr>
                 <td>Купонная ставка (%)</td>
                 <td>".$cupon_tax."</td>
         </tr>
         <tr>
                 <td>Количество участников <br/> Из них: </td>
                 <td>".$cnt_users."</td>
         </tr>
         <tr>
                 <td>Финансовые институты</td>
                 <td></td>
         </tr>
         <tr>
                 <td>Институциональные инвесторы</td>
                 <td></td>
         </tr>
         <tr>
                 <td>Инвесторы <br/> резидент/Нерезидент</td>
                 <td></td>
         </tr>
         </table>   ";

         echo "
         <br/>
         <br/>
         <br/>
         <table class='new-report' border='1'>
            <tr>
            <th>Объем поступивших заявок на аукцион ГЦБ</th>
            <th>Кол-во ГЦБ (в штуках)</th>
            <th>По номиналу (в сомах)</th>
            <th>По факту (в сомах)</th>
            <th>% от общего объема поступивших заявок (в %)</th>
            </tr>
         ";

   $id=0;

   //Считаем общее количество заявок
   while (oci_fetch($curs9)) {
      $volume=oci_result($curs9, 2);
      $grand_volume_vsnew+=$volume;
  }
   //Заканчиваем считать общее количество заявок
   $volumeByType = array(); 
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
       $doh=oci_result($curs7, 13);
       $shname=oci_result($curs7, 11);
       $status=oci_result($curs7,12);
       $grand_dl_total_nom = $grand_volume*NamCost;
       $dl_total_nom = $dl_volume*NamCost;
       
     
       if (!isset($totalsByType[$type])) {
         $totalsByType[$type] = array('volume' => 0, 'dl_total' => 0,'dl_total_nom' => 0);
     }
     $totalsByType[$type]['volume'] += $dl_volume;
     $totalsByType[$type]['dl_total'] += $dl_total;
     $totalsByType[$type]['dl_total_nom'] += $dl_total_nom;
     
       $id=$id+$volume;
       if ($id>($v-$issue_vnc)){
       $id=$v-$issue_vnc;
       $st=$st+1;
       }

       if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}
       



       if ($tc==1)
      
       {
      //   echo "
      //   <tr class='removed'>
      //   <td>На конкурентной основе</td>
      //   <td class='info'>".number_format($grand_volume, 2, ',', ' ')."</td>
      //   <td class='info'>".number_format($grand_dl_total_nom, 2, ',', ' ')."</td>
      //   <td class='info'>".number_format($grand_dl_total, 2, ',', ' ')."</td>
      //   <td>".number_format(($grand_volume/$grand_volume_vsnew)*100, 2, ',', ' ')."</td>
      // </tr>
      // ";
          $tc=0;
          $grand_volume=0;
          $grand_total=0;
          $grand_dl_volume=0;
          $grand_dl_total=0;
          $grand_dl_total_nom=0;
       } 

       $class='info';

       if ($status==1){$class='info_done';}
       if ($status==2){$class='info_error';}
       if ($status==3){$class='info_notfull';}

       if ($status!=2){
         if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
         if ($max_doh<$doh && $doh!=0){$max_doh=$doh;};
       };

       if ($min_price>$dl_price && $dl_price>0){$min_price=$dl_price;};
       if ($max_price<$dl_price){$max_price=$dl_price;};

       if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
       if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

       if ($tnc==1)
       {
        
          $grand_volume_nc+=$volume;
          $grand_dl_total_nc+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
          $grand_dl_volume_nc+=$dl_volume;
       }

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$dl_volume;
       $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
       $grand_dl_total_nom = $grand_volume*NamCost;
       $grand_dl_volume+=$dl_volume;

       $grand_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume_vs+=$dl_volume;
       $grand_dl_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
       $grand_dl_volume_vs+=$dl_volume;
       $grand_dl_total_vs_nom = $grand_volume_vs*NamCost;
       

       if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
       if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
       if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
       if ($doh!=''){$doh;};
     

       $namerus=$shname;
   }
   $count = 0;
   foreach ($totalsByType as $type => $totals) {
     $count += 1;
     if($type == 'Konkurent'){$type = 'На конкурентной основе';}else{$type = 'На неконкурентной основе';};
     
     echo "<tr>
     <td style='max-width:300px;'>".$type."</td> 
     <td>".number_format($totals['volume'], 2,',',' ')."</td> 
     <td>".number_format($totals['dl_total_nom'], 2,',',' ') . "</td> 
     <td>".number_format($totals['dl_total'], 2,',',' ') . "</td> 
     <td>".number_format(($totals['volume']/$grand_volume_vsnew)*100, 2, ',', ' ')." %</td>
     </tr>
     ";
 }
   echo "
     <tr>
     <td>Всего:</td>
         <td class='info'>".number_format($grand_volume_vs, 2, ',', ' ')."</td>
         <td class='info'>".number_format($grand_dl_total_vs_nom, 2, ',', ' ')."</td>
         <td class='info'>".number_format($grand_dl_total_vs, 2, ',', ' ')."</td>
         <td class='info'>100,00 %</td>
     </tr>
     </table>
   ";
      }  
      ///
      if ($c = ora_logon(OP1,OP2))
      {
             
         $curs7 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
         t.volume*t.price as total,
         (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
         (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
         (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
         (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
         (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
         (select d.profit from ls.auction_deals d where d.order_id=t.rowid) as profit
      from ls.auction_orders t, ".TS.".currinstrument c 
      where t.curr_id=c.id and t.date0=".MakeLongDate($date1)."
      order by shortname ASC,ls.auction_make_comp(t.price) DESC,t.price DESC");
   

        



                          oci_execute($curs7);

         $curs8 = oci_parse($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol, curr.shortname, ai.pred, ai.tot from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
         oci_execute($curs8);
                         $shname='';
         if (oci_fetch($curs8))
         {
            $issue_v=oci_result($curs8, 1);
            $issue_vnc=oci_result($curs8, 2);
            $svol=oci_result($curs8, 3);
            $sncvol=oci_result($curs8, 4);
            $shname=oci_result($curs8, 5);
            $v=oci_result($curs8, 6);
            $tot=oci_result($curs8, 7);
         }
         $curs_ex=oci_parse($c,"select t.extcode from ".TS.".currinstrument t where shortname ='".$shname."' ");
                         oci_execute($curs_ex);
                         
         if (oci_fetch($curs_ex))
         {
            $extcode=oci_result($curs_ex, 1);
         }

         //тест
      

         



  echo "
  <br/>
  <br/>
  <br/>
  <b>
  Сводная ведомость поступивших заявок:
  </b>
  <table class='new-report' border='1'>
     <tr>
     <th>Цена</th>
     <th>Сумма заявок по номинальной цене (сом)</th>
     <th>Объем поступлений при удовлетворении заявок по данной цене (сом)</th>
     <th>Доходность (в %)</th>
     <th>Доходность по цене (в %)</th>
     </tr>
  ";

$id=0;
while (oci_fetch($curs7)) {

$type=oci_result($curs7, 1);
$volume=oci_result($curs7, 2);
$price=oci_result($curs7, 3);
$total=oci_result($curs7, 9);
$date=oci_result($curs7, 5);
$time=oci_result($curs7, 6);
$dl_volume=oci_result($curs7, 7);
$dl_price=oci_result($curs7, 8);
$dl_total=oci_result($curs7, 9);
$doh=oci_result($curs7, 10);
$shname=oci_result($curs7, 11);
$status=oci_result($curs7,12);
$grand_dl_total_nom = $grand_volume*NamCost;
$id=$id+$volume;
if ($id>($v-$issue_vnc)){
$id=$v-$issue_vnc;
$st=$st+1;
}

if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}
if ($tc==1)

{
   $tc=0;
   $grand_volume=0;
   $grand_total=0;
   $grand_dl_volume=0;
   $grand_dl_total=0;
   $grand_dl_total_nom=0;
} 

$class='info';

if ($status==1){$class='info_done';}
if ($status==2){$class='info_error';}
if ($status==3){$class='info_notfull';}

if ($status!=2){
  if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
  if ($max_doh<$doh && $doh!=0){$max_doh=$doh;};
};

if ($min_price>$dl_price && $dl_price>0){$min_price=$dl_price;};
if ($max_price<$dl_price){$max_price=$dl_price;};

if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
if ($total<0){$total='';}else{$total=$total;};

if ($tnc==1)
{
 
   $grand_volume_nc+=$volume;
   $grand_dl_total_nc+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
   $grand_dl_volume_nc+=$dl_volume;
}

$grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
$grand_volume+=$volume;
$grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
$grand_dl_total_nom = $grand_volume*NamCost;
$grand_dl_volume+=$dl_volume;

$grand_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$total)));
$grand_volume_vs+=$volume;
$grand_dl_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
$grand_dl_volume_vs+=$dl_volume;
$grand_dl_total_vs_nom = $grand_volume_vs*NamCost;


if ($dl_volume!=''){$dl_volume = $dl_volume*NamCost;};
if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
if ($doh!=''){$doh=number_format($doh,2,',',' ');};
// if($dl_volume != 0) {
   
// echo "<tr>
// <td class='info'>".$price."</td>
// <td class='info'>$dl_volume</td>
// <td class='info'>".$total."</td>
// <td class='info'>".$doh."</td>
// <td class='info'>".$doh."</td>";
// }
if($dl_volume != 0) {
   if($type == 'Konkurent') {
   $sum += $dl_volume; 
   $sum_total += $total;
   }
   $summKonkurent = 0;
   $summTotalKonkurent = 0;
    if ($sum > 0){$summKonkurent = $sum;}else{$summKonkurent =$dl_volume;};
    if ($sum_total > 0){$summTotalKonkurent = $sum_total;}else{$summTotalKonkurent = $total;};
   echo "<tr>
         <td class='info'>".$price."</td>
         <td class='info'>".number_format($summKonkurent,2,',','  ')."</td>
         <td class='info'>".number_format($summTotalKonkurent,2,',',' ')."</td>
         <td class='info'>".$doh."</td>
         <td class='info'>".$doh."</td>";
        
}
$namerus=$shname;
}
echo "
</table>
";
}    
        break;
      }

      case 2: {
         if ($_SESSION[PORTAL.'USER']['admin']!=1){die ('Нет прав!');};
         if ($c = ora_logon(OP1,OP2))
         {

            if ($firm==0)
            {
               $f='';
            }
            else
            {
               $f=' and t.idfirm='.$firm.' ';
            }

            if ($nocomp==0)
            {
               $f.='';
            }
            elseif ($nocomp==1)
            {
               $f.=' and t.notfull in (1,3) ';
            }
            else
            {
               $f.=' and t.notfull in (2,4) ';
            }

               $curs6 = oci_parse($c, "select shortname,
               to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, 
               to_char(profit,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as profit, 
               volume, date0, time0, acc.code, f.nick, to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total, t.notfull from ls.auction_deals t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc, ".TS.".firm f where t.curr_id=curr.id and t.idfirm=f.id and date0=".MakeLongDate($date1)." and acc.id=t.account ".$f." order by price desc");
              
               oci_execute($curs6);
               $curs60 = oci_parse($c,"select ls.auction_make_comp(t.price) as comp,(select d.price from ls.auction_deals d where d.order_id=t.rowid) as price
               from ls.auction_orders t, ".TS.".currinstrument c 
            where t.curr_id=c.id and t.date0=".MakeLongDate($date1)."
            AND (SELECT d.price FROM ls.auction_deals d WHERE d.order_id = t.rowid) > 0 
            order by price DESC");
            oci_execute($curs60);
            
               $curs61 = oci_parse($c, "select curr.shortname, ai.pred,ai.volume_nocomp from ls.auction_issue ai, ".ts.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1)."");
           
               oci_execute($curs61);
               if (oci_fetch($curs61))
               {
                  $shortName=oci_result($curs61, 1);
                  $allTotal=oci_result($curs61,2);
                  $allNoConTotal=($allTotal*30)/100;
               }



   echo "
   <button class='btn control' onclick='print_version();'>Распечатать отчет</button>
   <h4 align='center'>КЛАССИФИКАЦИЯ ЗАЯВОК</h4>
   <p align='right'>Дата: ".$date1."</p>
   <br/>
   <br/>
   <span><b>Общая информация по аукциону</b></span>
   <br/>
   <br/>
   <table class='new-report short' border='1'>
   <tr>
   <td>Регистрационный номер</td>
   <td>".$shortName."</td>
   </tr>
   <tr>
   <td>Дата аукциона</td>
   <td>".$date1."</td>
   </tr>
   <tr>
   <td>Объем выпуска (сом)</td>
   <td>".number_format($allTotal, 2, ',', ' ')."</td>
   </tr>
   <tr>
   <td>в т.ч Неконкурентные на сумму (сом)</td>
   <td>".number_format($allNoConTotal, 2, ',', ' ')."</td>
   </tr>
   </table>
   <br/>
   <br/>
   <br/>
   <table class='new-report' border='1'>
         <tr>
         <th class='info_title'>
            Наименование дилера
         </th>
         <th class='info_title'>
            Номинальная стоимость (сом)
         </th>
         <th class='info_title'>
            Цена заявки (сом)
         </th>
         <th class='info_title'>
            Доходность по цене (в %)
         </th>
        </tr>";

    /*if (is_resource($curs6))
    {

        $shortname=ora_getcolumn($curs6, 0);
        $price=ora_getcolumn($curs6, 1);
        $volume=ora_getcolumn($curs6, 2);
        $date0=MakeDate(ora_getcolumn($curs6, 3));
        $time0=MakeTime(ora_getcolumn($curs6, 4));
        $account=ora_getcolumn($curs6, 5);
        $firm=ora_getcolumn($curs6, 6);
        $total=ora_getcolumn($curs6, 7);
        $status=ora_getcolumn($curs6, 8);

        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$volume;

        echo "<tr>
         <td class='".$class."'>".$date0."</td>
         <td class='".$class."'>".$time0."</td>
         <td class='".$class."'>".$shortname."</td>
         <td class='".$class."'>".$account."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".$volume."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".$firm."</td>
         </tr>";
		*/
    while (oci_fetch($curs6)) {
        $shortname=oci_result($curs6, 1);
        $price=oci_result($curs6, 2);
        $profit=oci_result($curs6, 3);
        $volume=oci_result($curs6, 4);
        $date0=MakeDate(oci_result($curs6, 5));
        $time0=MakeTime(oci_result($curs6, 6));
        $account=oci_result($curs6, 7);
        $firm=oci_result($curs6, 8);
        $total=oci_result($curs6, 9);
        $status=oci_result($curs6, 10);
        oci_fetch($curs60);
        $typee = oci_result($curs60,1);
        
        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$volume;
       if($typee == 'Konkurent'){$price;} else {$price='';};

        echo "<tr>
        <td class='info'>".$firm."</td>
        <td class='info'>".number_format($volume*NamCost, 2, ',', ' ')."</td>
        <td class='info'> ".$price."</td>
        <td class='info'>".$profit."</td>
         </tr>";
    }
    //}
         }

     echo "<tr>
      <td class='info'>Итого:</td>
      <td class='info'>".number_format($grand_volume*NamCost, 2, ',', ' ')."</td>
      <td class='info'>&nbsp;</td>
      <td class='info'>&nbsp;</td>
     </tr>";

         echo "</table>";
         break;
      }

      case 3: {
         $grand_total_vs=0;
         $grand_volume_vs=0;
         $grand_dl_total_vs=0;
         $grand_dl_volume_vs=0;
         $st=0;
         $tp='Konkur';
         $tc=0;
         $tnc=0;
         $num=0;
         $namerus='';
         
         if ($c = ora_logon(OP1,OP2))
         {
               /*$curs7 = @ora_do($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
   t.volume*t.price as total,
   (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
   (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
   (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
   (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
   (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
   (select ((100-round(d.price,2))/round(d.price,2))*(360/ts.maket(c.shortname))*100 from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,c.shortname,t.status
from ls.auction_orders t, ".TS.".currinstrument c
where t.curr_id=c.id and date0=".MakeLongDate($date1)."
order by t.price desc");*/
                 $curs7 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
   t.volume*t.price as total,
   (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
   (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
   (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
   (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
   (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,c.shortname,t.status,  i.profit_nocomp_avg as profit,t.profit as ord
from ls.auction_orders t, ".TS.".currinstrument c,ls.auction_issue i 
where t.curr_id=c.id and t.curr_id = i.curr_id and t.date0=".MakeLongDate($date1)." and i.date0=".MakeLongDate($date1)."
order by shortname ASC,t.price DESC");



								  oci_execute($curs7);

                 $curs8 = oci_parse($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol, curr.shortname, ai.pred, ai.tot from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
                 oci_execute($curs8);
								 $shname='';
                 if (oci_fetch($curs8))
                 {
                    $issue_v=oci_result($curs8, 1);
                    $issue_vnc=oci_result($curs8, 2);
                    $svol=oci_result($curs8, 3);
                    $sncvol=oci_result($curs8, 4);
                    $shname=oci_result($curs8, 5);
                    $v=oci_result($curs8, 6);
                    $tot=oci_result($curs8, 7);
                 }
                 $curs_ex=oci_parse($c,"select t.extcode from ".TS.".currinstrument t where shortname ='".$shname."' ");
								 oci_execute($curs_ex);
								 
                 if (oci_fetch($curs_ex))
                 {
                    $extcode=oci_result($curs_ex, 1);
                 }

                 //тест
                 

   echo "
   <button class='btn control' onclick='print_version();'>Распечатать отчет</button>
  <table width='100%'>
  <tr>
  <td colspan='10' align='left'>
  <div width='100%' align='center'>
  <b>Сводная ведомость</b>

  </div> <br>
  </td>
  </tr>
  <tr>
            <td colspan='12' align='right'>Дата: ".$date1."</td>
  </tr>
  <tr>
  <td colspan='8' align='left'>
  <b>
     Итоги размещения:<br>
  </b>
  </td>
  </tr>
  </table>
        <table class='new-report' border='1'>
       
       
         <tr>
         <th class='info_title' width='200'>
            размещено:
         </th>
         <th class='info_title'>
            Кол-во ГЦБ (в штуках)
         </th>
               
         <th class='info_title' >
            Сумма удовлетворенных заявок (по номиналу, в сомах)
         </th>
         <th class='info_title'>
            Сумма удовлетворенных заявок (по факту, в сомах)
         </th>
         <th class='info_title'>
            Средневзвешенная цена (сом)
         </th>
         <th class='info_title'>
             Доходность (в %)
         </th>
        
          ";


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
        $id=$volume;
        $namerus=$shname;

        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if($status!=2){
          if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
          if ($max_doh<$doh && $doh!=0){$max_doh=$doh;};
        };
        if ($min_price>$dl_price && $dl_price>0){$min_price=$dl_price;};
        if ($max_price<$dl_price){$max_price=$dl_price;};

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume+=$dl_volume;

        $grand_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume_vs+=$volume;
        $grand_dl_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume_vs+=$dl_volume;

        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};

        if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}
        echo "
          <tr>
            <td class='info_shortname' colspan='10'>
              Лот: ".$shname."
            </td>
          </tr>
        ";
        echo "<tr>
         <td class='".$class."'>".$type."</td>
         <td class='".$class."'>".number_format($volume,0,',',' ')."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".$date." ".$time."</td>
         <td class='".$class."'>".$dl_volume."</td>
         <td class='".$class."'>".$dl_price."</td>
         <td class='".$class."'>".$dl_total."</td>
         <td class='".$class."'>".$doh."</td>
         <td class='".$class."'>&nbsp;</td>";
			*/
         
         $volumeByType = array(); 
       
    $id=0;
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
        $doh=oci_result($curs7, 12);
        $shname=oci_result($curs7, 10);
        $status=oci_result($curs7,11);

        $grand_dl_total_nom = $grand_volume*NamCost;
        $dl_total_nom = $dl_volume*NamCost;

           if (!isset($totalsByType[$type])) {
        $totalsByType[$type] = array('volume' => 0, 'dl_total' => 0,'dl_total_nom' => 0);
    }
    $totalsByType[$type]['volume'] += $dl_volume;
    $totalsByType[$type]['dl_total'] += $dl_total;
    $totalsByType[$type]['dl_total_nom'] += $dl_total_nom;


        $id=$id+$volume;
        if ($id>($v-$issue_vnc)){
        $id=$v-$issue_vnc;
        $st=$st+1;
        }
        if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}
        if ($tc==1)
        {
         //   echo "<tr class='removed1'><td class='info'> На конкурентной основе</td>
         //   <td class='info'>".number_format($grand_volume, 0, ',', ' ')."</td>
         //   <td class='info'>".number_format($grand_dl_total_nom, 2, ',', ' ')."</td>
         //   <td class='info'>".number_format($grand_dl_total, 2, ',', ' ')."</td>
         //   <td class='info' rowspan='3'>".number_format($dl_price, 2, ',', ' ')."</td>
         //   <td class='info' rowspan='3'>".$doh."</td>
         //  ";
      
           $tc=0;
           $grand_volume=0;
           $grand_total=0;
           $grand_dl_volume=0;
           $grand_dl_total=0;
           $grand_dl_total_nom=0;
        } 

     
        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        if ($status!=2){
          if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
          if ($max_doh<$doh && $doh!=0){$max_doh=$doh;};
        };

        if ($min_price>$dl_price && $dl_price>0){$min_price=$dl_price;};
        if ($max_price<$dl_price){$max_price=$dl_price;};

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

        if ($tnc==1)
        {
           $grand_volume_nc+=$volume;
           $grand_dl_total_nc+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
           $grand_dl_volume_nc+=$dl_volume;
        }

        $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume+=$dl_volume;
        $grand_dl_total+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_total_nom = $grand_volume*NamCost;
        $grand_dl_volume+=$dl_volume;

        $grand_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $grand_volume_vs+=$dl_volume;
        $grand_dl_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_volume_vs+=$dl_volume;
        $grand_dl_total_vs_nom = $grand_volume_vs*NamCost;


        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh;};
        $namerus=$shname;
    }
    $count = 0;
    foreach ($totalsByType as $type => $totals) {
      $count += 1;
      if($type == 'Konkurent'){$type = 'На конкурентной основе';}else{$type = 'На неконкурентной основе';};
      
      echo "<tr>
      <td style='max-width:300px;'>".$type."</td> 
      <td>".number_format($totals['volume'], 2,',',' ')."</td> 
      <td>".number_format($totals['dl_total_nom'], 2,',',' ') . "</td> 
      <td>".number_format($totals['dl_total'], 2,',',' ') . "</td> 
      ";
      if($count == 1) {
         echo "<td class='info' rowspan='3'>".number_format($grand_dl_total_vs/$grand_volume_vs,2,',',' ')."</td>
         <td class='info' rowspan='3'>".number_format($doh,2,',',' ')."</td>";
      }
      echo "</tr>";
  }
       }
  

     echo "
     <tr>
     <td class='info'>Всего:</td>
     <td class='info'>".number_format($grand_volume_vs, 2, ',', ' ')."</td>
     <td class='info'>".number_format($grand_dl_total_vs_nom, 2, ',', ' ')."</td>
     <td class='info'>".number_format($grand_dl_total_vs, 2, ',', ' ')."</td>
     
     </tr>
     ";
     $issue_v=$v*70/100;
     $issue_vnc=$v-$issue_v;
     $avg_price=round(($grand_dl_total/$grand_dl_volume),2);
     $avg_doh=((100-$avg_price)/$avg_price)*(360/MakeT($shname))*100;
     $issue_v=$issue_v*NamCost;
     $issue_vnc=$issue_vnc*NamCost;
     $svol=$svol*NamCost;
     $sncvol=$sncvol*NamCost;
     $grand_dl_volume_nc=$grand_dl_volume_nc*NamCost;
     $grand_dl_volume=$grand_dl_volume*NamCost;

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


         echo "</table>";

          /// itogovaya tablica
         echo "
           <br>
           <br>
           <br>
                 <table class='new-report' border='1'>
                 <tr>
                    <th class='info_title'></th>
                    <th class='info_title'>Текущий аукцион ".$shname."</th>
                    <th class='info_title'>Предыдущий аукцион</th>
                    <th class='info_title'>Абсолютная разница</th>
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

                      print_r("select ai.volume,ai.volume_nocomp,
                      (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol,
                      (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol,
                      curr.shortname, ai.pred, ai.tot,
                      (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price>0) as ud_svol,
                      (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price<0) as ud_sncvol
                      from ls.auction_issue ai, ".TS.".currinstrument curr
                      where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
                     
											oci_execute($curs8);
                      $shname='';
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
                               
                               <tr>
                                 <td class='info'>Объем предложения (в тыс. сомах)</td>
                                 <td class='info'>".number_format(($pred_v+$pred_vnc)/NamCost/1000, 2, ',', ' ')."</td>
                                 <td class='info'></td>
                                 <td class='info'></td>
                               </tr>
                               <tr>
                                 <td class='info'>Объем спроса (по номиналу, в тыс сомах)</td>
                                 <td class='info'>".number_format(($svol)/1000, 2, ',', ' ')."</td>
                                 <td class='info'></td>
                                 <td class='info'></td>
                               </tr>
                               <tr>
                                <td class='info'>Объем размещения (по номиналу, в тыс сомах)</td>
                                <td class='info'>".number_format(($ud_sncvol+$ud_svol)/1000, 2, ',', ' ')."</td>
                                <td class='info'></td>
                                <td class='info'></td>
                                </tr>
                                <tr>
                                    <td>Средневзвешенная цена (в сомах)</td>
                                    <td>".number_format($grand_dl_total_vs/$grand_volume_vs,2,',',' ')."</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Средневзвешенная доходность, (в %)</td>
                                    <td>".number_format($doh,2,',',' ')."</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               
                                
                             ";
                        }
                      //}
                   }
                  
                 //$qwery_str="select jopa from dual";
                 $qwery_str="select 
                 max(shortname),
                 min(dl_price),max(dl_price), 
                 sum(dl_volume*round(dl_price,2))/sum(dl_volume) avg_price, 
                  max(prof) from ( select t.price, t.profit as prof, 
                  (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume, 
                  (select round(d.price,2) from ls.auction_deals d where d.order_id=t.rowid) as dl_price, 
                  c.shortname shortname, c.id as curr from ls.auction_orders t, 
                  ".TS.".currinstrument c where t.curr_id=c.id and date0=".MakeLongDate($date1)." order by shortname ASC,t.price DESC ) group by curr";

           
          
                 $curs_pr = oci_parse($itogi,$qwery_str);
								 oci_execute($curs_pr);
                 
                     while (oci_fetch($curs_pr))
                     {
                      $name=oci_result($curs_pr,1);
											$max_price=oci_result($curs_pr,3);
											$min_price=oci_result($curs_pr,2);
											$avg_price=oci_result($curs_pr,4);
                                 $max_dohh=oci_result($curs_pr,5);
                     echo "
                      
                        <tr>
                           <td class='info'>Максимальная цена (в сомах)</td>
                           <td class='info'>".number_format($max_price,2,',',' ')."</td>
                           <td class='info'></td>
                           <td class='info'></td>
                        </tr>
                      
                        <tr>
                           <td>Доходность , в % по максимальной цене (в %)</td>
                           <td>".number_format($max_doh,2,',',' ')."</td>
                           <td></td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Цена отсечения (в сомах)</td>
                           <td>".number_format($grand_dl_total_vs/$grand_volume_vs,2,',',' ')."</td>
                           <td></td>
                           <td></td>
                        </tr>
                        <tr>
                           <td>Доходность, в % по цене отсечения (в %)</td>
                           <td>".number_format($doh,2,',',' ')."</td>
                           <td></td>
                           <td></td>
                        </tr>
                     ";
                     }
                   //}
                   echo "
                 
              
          </table>
         ";
         break;
      }

   }

}
