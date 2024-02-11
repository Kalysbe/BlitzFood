<?php

if (!defined('WEB_ROOT')){die ('Oops...');}
if (!defined('NamCost')){die ('Oops...');}

require_once('BondYield.php');

function convertDate($dateString) {
    $date = DateTime::createFromFormat('d/m/Y', $dateString);
    return $date->format('Y-m-d');
}

//function recalcPrice($repayment_date, $settlement_date, $summTotalKonkurent, $summKonkurent) {
function recalcPrice($repayment_date, $settlement_date, $recalcVal) {
	$T = (strtotime($repayment_date) - strtotime($settlement_date))/(60 * 60 * 24) - 1;
	
	//$recalcVal = ($summTotalKonkurent/$summKonkurent) * 100;
	//$recalVal = ceil(($summTotalKonkurent/($summKonkurent*NamCost)*100) * 100) / 100;
	$p = ((100 - $recalcVal) / ($recalcVal)) *(360 / 364);
	return $p*100;
}

function myRound($sum) {
   $rounded = array();
   $rounded[0] = round($sum,6);
   for($i = 1; $i <= 4 ; $i++) {
   $rounded[$i] = round($rounded[$i-1],$i+2);
}
 return $rounded[4];
}

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
$reps[1]='Сводная ведомость страница 1';

if ($_SESSION[PORTAL.'USER']['admin']==1 || $_SESSION[PORTAL.'USER']['admin']==5)
{
 
   $reps[3]='Сводная ведомость страница 2';
   $reps[4]='Информация по доп размещению';
   $reps[2]='Классификация заявок';

}
if ($_SESSION[PORTAL.'USER']['admin']==1)
{
   $reps[5]='Ведомость для ЦД';
}
$rp=0;
if (isset($_POST['rep']))
{
   $rp=intval($_POST['rep']);
}
if (isset($_GET['arg'])){
  sel($_GET['arg'],MakeLongDate($date1));
}

if ($_SESSION[PORTAL.'USER']['admin']==2)
{
   if ($_SESSION['STATUS']<1)
   {
      echo "Этап предварительных расчетов еще не наступил...<br>Зайдите пожалуйста в установленное регламентом время.";
      exit();
   }
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

if ($_SESSION[PORTAL.'USER']['admin']==1 || $_SESSION[PORTAL.'USER']['admin']==5)
{
echo "
<script type='text/javascript' src='./js/script_htmltopdf4.js'></script> 
<script type='text/javascript' src='./js/htmltopdf.js'></script>
";
echo "".$reports."
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
             
                $curs7 = oci_parse($c, "select 
                ls.auction_make_comp(t.price) as comp, 
                t.volume, 
                t.price, 
                t.volume * t.price as total, 
                (select ts.makedate(date0) from ls.auction_deals d where d.order_id = t.rowid) as dl_date, 
                (select ts.maketime(time0) from ls.auction_deals d where d.order_id = t.rowid) as dl_time, 
                (select d.volume from ls.auction_deals d where d.order_id = t.rowid) as dl_volume, 
                (select d.price from ls.auction_deals d where d.order_id = t.rowid) as dl_price, 
               
                case when   t.volume * t.price < 0 then (select 
                    (
                      t.volume * round(d.price, 2)
                    ) 
                  from 
                    ls.auction_deals d 
                  where 
                    d.order_id = t.rowid
                )  else (
                  t.volume * t.price) end as dl_total,
                case when t.profit = 0 then i.profit_nocomp_avg else t.profit end as ord 
              from 
                ls.auction_orders t, 
                ".TS.".currinstrument c, 
                ls.auction_issue i 
              where 
                t.curr_id = c.id 
                and t.curr_id = i.curr_id 
                and t.conf != 2
                and t.date0 = ".MakeLongDate($date1)."
                and i.date0 = ".MakeLongDate($date1)."
              order by 
                shortname ASC, 
                ls.auction_make_comp(t.price) desc, 
                t.price DESC
              ");

                oci_execute($curs7);
                $curs8 = oci_parse($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol, curr.shortname, curr.namerus, ai.pred, ai.tot, ai.repayment_date, ai.freq_payments, ai.settlement_date from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
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
                          $cupon_tax > 0 ?  $cupon_tax = number_format($cupon_tax,2,',',' ') . '%' : $cupon_tax = '';
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
				   $repayment_date=oci_result($curs8, 9);
				   $freq_payments=oci_result($curs8, 10);
				   $settlement_date=oci_result($curs8, 11);
                   if($svol == ''){$svol = 0;};
                  if($sncvol == ''){$sncvol = 0;};
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
      select distinct t.idfirm from ls.auction_orders t, ts.tradeaccount tt where t.status != 2 and date0=".MakeLongDate($date1)."
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
		  
		                //считаем количество банковских
      $bank_users=" select count(*) from (
         select
         n.nick 
          from ls.AUCTION_ORDERS o, 
          ".TS.".firm n where o.status != 2 and n.id=o.idfirm and date0=".MakeLongDate($date1)." and n.nick LIKE '%BNK%' group by o.idfirm,
               n.nick order by o.idfirm, n.nick 
                  ) tab";
      if ($cnt_us = ora_logon("ls@".SRV,"ls"))
         {
            $cc_us_bank=oci_parse($cnt_us,$bank_users);
                        oci_execute($cc_us_bank);
            if (oci_fetch($cc_us_bank))
            {
               $cnt_users_bank= oci_result($cc_us_bank, 1);
            }
          }
		  
		  
          
      $appealPeriod = ''; 
      if(substr($shname,0,5) == "GBA02")
      {$appealPeriod = "2 года";}
      else if (substr($shname,0,5) == "GBA05") {
      {$appealPeriod = "5 лет";}
      }
      else if (substr($shname,0,5) == "GBA07") {
      {$appealPeriod = "7 лет";}
      }
       else if (substr($shname,0,2) == "GD") {
      {$appealPeriod = "364 дня";}
      }
      else{$appealPeriod = "";};    
	  #if(substr($shname,0,3) == "GBA03"){$appealPeriod = "3 года";} else{$appealPeriod = "728 дней";}; 

  echo "
  <button style='float: right;' class='btn control' onclick='print_version();'>Распечатать отчет</button>
  <button style='float: right;' class='btn' onclick='reportToPDF2();'>Скачать отчет</button>
<div id='wrapper-pdf'>
  <table width='100%'>
 <tr>
 <td colspan='10' align='left'>
 <span class='print_caption'>
 <div width='100%' align='center'>
 Сводная ведомость 
 </div> 
 <br>
 </span>
 </td>
 </tr>
 <tr>
 <td align='right' colspan='12'>
 ".$date1."
 </td>
 </tr>
 </table>
 <span style='font-size:15px;'>Общая информация по аукциону:</span>
       <table class='new-report short' border='1'>
         <tr>
               <td>Дата аукциона</td>
               <td>".$date1."</td>
         </tr>
         <tr>
               <td>Вид ГЦБ</td>
               <td>$typeGsb</td>
         </tr>
         <tr>
               <td>Срок обращения ГЦБ</td>
               <td>".$appealPeriod."</td>
         </tr>
         <tr>
               <td>Регистрационный номер</td>
               <td>".$shname."</td>
         </tr>
         <tr>
               <td>Количество ГЦБ (в штуках)</td>
               <td>".number_format($v/NamCost,0,',',' ')."</td>
         </tr>
         <tr>
                <td>Объем предложения</td>
                <td>".number_format($v,2,',',' ')."</td>
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
				<td>".$cnt_users_bank."</td>
         </tr>
         <tr>
                 <td>Институциональные инвесторы, в том числе страховые компании</td>
                 <td></td>
         </tr>
         <tr>
                 <td>Инвесторы <br/> резидент/Нерезидент</td>
                 <td>".$cnt_users."/0</td>
         </tr>
         </table>   ";

         echo "
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
   $totalsByTypee['Konkurent'] = array('volume' => 0, 'dl_total' => 0,'dl_total_nom' => 0);
   $totalsByTypee['NeKonkurent'] = array('volume' => 0, 'dl_total' => 0,'dl_total_nom' => 0);
   //Считаем общее количество заявок
   while (oci_fetch($curs9)) {
      $volume=oci_result($curs9, 2);
      $grand_volume_vsnew+=$volume;
  }
   //Заканчиваем считать общее количество заявок

       while (oci_fetch($curs7)) {
       $type=oci_result($curs7, 1);
       $volume=oci_result($curs7, 2);
       $price=oci_result($curs7, 3);
       $total=oci_result($curs7, 9);
       $date=oci_result($curs7, 5);
       $time=oci_result($curs7, 6);
       $dl_volume=oci_result($curs7, 7);
       $dl_price=oci_result($curs7, 8);
      //  $dl_total=oci_result($curs7, 9);
       $doh=oci_result($curs7, 13);
       $shname=oci_result($curs7, 11);
       $status=oci_result($curs7,12);
       $grand_dl_total_nom = $grand_volume*NamCost;
       $total_nom = $volume*NamCost;
       
     
      
     $totalsByTypee[$type]['volume'] += $volume;
     $totalsByTypee[$type]['dl_total'] += $total;
     $totalsByTypee[$type]['dl_total_nom'] += $volume*NamCost;
     
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
       $grand_volume_vs+=$volume;
       $grand_dl_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_dl_volume_vs+=$volume;
       $grand_dl_total_vs_nom = $grand_volume_vs*NamCost;
       

       if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
       if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
       if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
       if ($doh!=''){$doh;};
       $avg_price2 = $grand_dl_total_vs/$grand_volume_vs;

       $namerus=$shname;
   }

   

   foreach ($totalsByTypee as $type => $totals) {
     if($type == 'Konkurent'){$typerus = 'На конкурентной основе';}else{$typerus = 'На неконкурентной основе';};
     
     echo "<tr>
     <td style='max-width:300px;'>".$typerus."</td> 
     <td align='right'>".number_format($totals['volume'], 2,',',' ')."</td> 
     <td  align='right'>".number_format($totals['dl_total_nom'], 2,',',' ') . "</td> 
     <td  align='right'>".number_format($totals['dl_total'], 2,',',' ') . "</td> 
     <td  align='center'>".number_format(($totals['volume']/$grand_volume_vs)*100, 2, ',', ' ')." %</td>
     </tr>
     ";
 }
   echo "
     <tr>
     <td>Всего:</td>
         <td class='info'  align='right'>".number_format($grand_volume_vs, 2, ',', ' ')."</td>
         <td class='info'  align='right'>".number_format($grand_dl_total_vs_nom, 2, ',', ' ')."</td>
         <td class='info'  align='right'>".number_format($grand_dl_total_vs, 2, ',', ' ')."</td>
         <td class='info'  align='center'>100,00 %</td>
     </tr>
     </table>
   ";
      }  
      ///
      if ($c = ora_logon(OP1,OP2))
      {
             
         $curs7 = oci_parse($c, "
         select tt.comp comp,
  sum(tt.volume) volume,
  tt.price price,
  case when sum(tt.total) < 0 then sum(tt.dl_total) else sum(tt.total) end as total,
  case when profit = 0 then tt.profit1 else tt.profit end as profit
   from (select ls.auction_make_comp(t.price) as comp, 
  t.volume, 
  t.price,
   t.volume*t.price as total,  
  (select (t.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
  t.profit,
  round((select d.profit from ls.auction_deals d where d.order_id=t.rowid),2) as profit1
   from ls.auction_orders t, 
  ".TS.".currinstrument c where t.curr_id=c.id and t.conf != 2 and t.date0=".MakeLongDate($date1)." order by t.price desc) 
     tt group by
      tt.comp,
      tt.price,    
          tt.profit,
          tt.profit1 order by tt.comp desc, tt.price desc");
          

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
   <span style='font-size:15px;'>Сводная ведомость поступивших заявок:</span>
  <table class='new-report' border='1'>
     <tr>
     <th style='width:70px;'>Цена (сом)</th>
     <th>Сумма заявок по номинальной цене (сом)</th>
     <th>Объем поступлений при удовлетворении заявок по данной цене (сом)</th>
     <th style='width:155px;'>Доходность (в %)</th>
     <th style='width:130px;'>Доходность по цене (в %)</th>
     </tr>
  ";
 
$id=0;

$arrKonkurent = array();
$arrNeKonkurent = array();
$arr1 = array();
while (oci_fetch_array($curs7)) {
	$type=oci_result($curs7, 1);
	$volume=oci_result($curs7, 2);
	$price=oci_result($curs7, 3);
	$total=oci_result($curs7, 4);
	$doh=oci_result($curs7, 5);
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





	if ($status!=2){
	  if ($min_doh>$doh && $doh!=0){$min_doh=$doh;};
	  if ($max_doh<$doh && $doh!=0){$max_doh=$doh;};
	};

	if ($min_price>$dl_price && $dl_price>0){$min_price=$dl_price;};
	if ($max_price<$dl_price){$max_price=$dl_price;};

	// if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
	if ($total<0){$total='';}else{$total=$total;};

	// if ($doh!=''){$doh=number_format($doh,2,',',' ');};

	if($volume != 0) {
		
	   if($type == 'Konkurent') {
	   $sum += $volume; 
	   $sum_total += $total;
	   }
	   $summKonkurent = 0;
	   $summTotalKonkurent = 0;
		if ($sum > 0){$summKonkurent = $sum;}else{$summKonkurent =$volume;};
		if ($sum_total > 0){$summTotalKonkurent = $sum_total;}else{$summTotalKonkurent = $total;};
		$val = ceil($summTotalKonkurent/($summKonkurent*NamCost)*100 * 100) / 100;
		$shortNm = substr($shname,0,3);

      array_push($arr1, array('type' => $type,'price' =>$price, 'volume' =>$summKonkurent*100, 'total'=>$summTotalKonkurent,'doh' => $doh ));

      // $arr1['price'] = $price;
      // $arr1['volume'] = $summKonkurent;
      // $arr1['total'] = $summTotalKonkurent;
      // $arr1['doh'] = $doh;
   
		// if($shortNm == 'GD0'){
		// 	$y = recalcPrice(convertDate(MakeDate($repayment_date)), convertDate(MakeDate($settlement_date)), $val);
		// } else {
		// 	$y = BondYield::Calculate(convertDate(MakeDate($settlement_date)),$val, convertDate(MakeDate($repayment_date)),$cupon_tax,$freq_payments,NamCost);
		// }
		

	   // echo "<tr>
		// 	 <td class='info'  align='center'>".$price."</td>
		// 	 <td class='info'  align='right'>".number_format($summKonkurent*NamCost,2,',','  ')."</td>
		// 	 <td class='info'  align='right'>".number_format($summTotalKonkurent,2,',',' ')."</td>
		// 	 <td class='info'  align='center'>".number_format($y,2,',',' ') ."</td>
		// 	 <td class='info'  align='center'>".$doh."</td>";
			
	}
	$namerus=$shname;
}
$arrKonkurent = array();
$arrNeKonkurent = array();

foreach ($arr1 as $key => $value) {
   if ($value['type'] == 'NeKonkurent') {
       $arr1[$key]['doh2'] = $value['doh'];
       array_push($arrNeKonkurent, $arr1[$key]);
   } else {
       array_push($arrKonkurent, $value);
   }
}

$arr = $arrKonkurent;
$newarr = array();
$count = 0;
$prevSum = 0;
$firstVal = $arr[0]['doh'] * $arr[0]['volume'];
foreach ($arr as $key => $value) {
   array_push($newarr, $firstVal);
   if ($key > 0) {
       $count += ($value['volume'] - $prevSum) * $value['doh'];
   }
   $prevSum = $value['volume'];

   $newarr[$key] += $count;
   $arr[$key]['doh2'] = number_format(round($newarr[$key] / $arr[$key]['volume'], 2), 2, '.', '');
}

$arr = array_merge($arrNeKonkurent, $arr);
foreach ($arr as $item) {
   $formattedItem = array_map(function ($value) {
     return $value < 0 ? '' : number_format($value, 2, ',', ' ');
   }, $item);
   
   echo "
     <tr>
       <td class='info' align='center'>".$formattedItem['price']."</td>
       <td class='info' align='center'>".$formattedItem['volume']."</td>
       <td class='info' align='center'>".$formattedItem['total']."</td>
       <td class='info' align='center'>".$formattedItem['doh2']."</td>
       <td class='info' align='center'>".$formattedItem['doh']."</td>
     </tr>
   ";
 }
echo "
</table>
</div>
";
}    
        break;
      }

      case 2: {
         if ($_SESSION[PORTAL.'USER']['admin']!=1 && $_SESSION[PORTAL.'USER']['admin']!=5){die ('Нет прав!');};
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

               $curs6 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp,
               to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, 
               to_char(profit,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as profit, 
               volume, date0, time0, acc.code, rn.rusnick, to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total,
               ( select  profit  from  ls.auction_deals d  where d.order_id = t.rowid ) as profit_2
               from ls.auction_orders t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc, ".TS.".firm f,
               ls.nicks rn where t.curr_id=curr.id and t.conf != 2 and t.idfirm=f.id and date0=".MakeLongDate($date1)." and acc.id=t.account ".$f." and 
               f.nick = rn.nick order by comp desc, price desc");
               oci_execute($curs6);
               $curs61 = oci_parse($c, "select curr.shortname ,
               (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price>0) as ud_svol,
               (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price<0) as ud_sncvol,
			      ai.volume_nbkr+ai.volume_nocomp_nbkr as total_nbkr,ai.volume_nocomp_nbkr
                from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1)."");
           
               oci_execute($curs61);
               if (oci_fetch($curs61))
               {
                  $shortName=oci_result($curs61, 1);
                  $allTotal=oci_result($curs61,2);
                  $allNoConTotal=oci_result($curs61,3);
				      $total_nbkr = oci_result($curs61,4);
                  $total_nc_nbkr = oci_result($curs61,5);
                  $allNoConTotal ? $allNoConTotal = $allNoConTotal : '';
                  $allTotal=$allTotal+$allNoConTotal;
				      $allNoConTotal=$total_nc_nbkr !=0 ? $total_nc_nbkr : $allNoConTotal;
                  $allTotal=$total_nbkr !=0 ? $total_nbkr : $allTotal;
               }

   echo "
   <button class='btn control' style='float: right;' onclick='print_version();'>Распечатать отчет</button>
   <button style='float: right;' class='btn' onclick='reportToPDF2();'>Скачать отчет</button>
   <div id='wrapper-pdf'>
   <h4 align='center'>КЛАССИФИКАЦИЯ ЗАЯВОК</h4>
   <p align='right'>Дата: ".$date1."</p>
   <br/>
   <br/>
   <span style='font-size:15px;'>Общая информация по аукциону</span>
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
   <td>".number_format($allTotal*NamCost, 2, ',', ' ')."</td>
   </tr>
   <tr>
   <td>в т.ч Неконкурентные на сумму (сом)</td>
   <td>".number_format($allNoConTotal*NamCost,2,',',' ')."</td>
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
        $typee=oci_result($curs6, 1);
        $price=oci_result($curs6, 2);
        $profit=oci_result($curs6, 3);
        $volume=oci_result($curs6, 4);
        $date0=MakeDate(oci_result($curs6, 5));
        $time0=MakeTime(oci_result($curs6, 6));
        $account=oci_result($curs6, 7);
        $firm=oci_result($curs6, 8);
        $total=oci_result($curs6, 9);
        $profit2=oci_result($curs6, 10);
        oci_fetch($curs60);
		
        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}

       $grand_total+=floatval(str_replace(',','.',str_replace(' ','',$total)));
       $grand_volume+=$volume;
       if($typee == 'Konkurent'){$price;} else {$price='';};
       $newprofit = 0;
       is_null($profit2) ? $newprofit = $profit : $newprofit = $profit2;
        echo "<tr>
        <td class='info'>".$firm."</td>
        <td class='info'>".number_format($volume*NamCost, 2, ',', ' ')."</td>
        <td class='info'> ".$price."</td>
        <td class='info'>".number_format(str_replace(',', '.', $newprofit), 2, ',', ' ' )."</td>
         </tr>";
    }
         }

     echo "<tr>
      <td class='info'>Итого:</td>
      <td class='info'>".number_format($grand_volume*NamCost, 2, ',', ' ')."</td>
      <td class='info'>&nbsp;</td>
      <td class='info'>&nbsp;</td>
     </tr>";

         echo "</table>
         </div>";
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
                 $curs7 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
                 t.volume*t.price as total,
                 (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
                 (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
                 (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
                 (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
                 (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,c.shortname,t.status,  i.profit_nocomp_avg as profit,t.profit as ord
              from ls.auction_orders t, ".TS.".currinstrument c,ls.auction_issue i 
              where t.status != 2 and t.curr_id=c.id and t.curr_id = i.curr_id and t.date0=".MakeLongDate($date1)." and i.date0=".MakeLongDate($date1)."
              order by shortname ASC,t.price DESC");
						oci_execute($curs7);

               

                 $curs8 = oci_parse($c, "select ai.volume,ai.volume_nocomp,
                 (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0 and ao.status != 2) as svol,
                 (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0 and ao.status != 2) as sncvol,
                 curr.shortname, ai.pred, ai.tot,
                 (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price>0) as ud_svol,
                 (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price<0) as ud_sncvol
                 from ls.auction_issue ai, ".TS.".currinstrument curr
                 where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
             
                
                 oci_execute($curs8);
				 $shname='';
                 $curs_ex=oci_parse($c,"select t.extcode from ".TS.".currinstrument t where shortname ='".$shname."' ");
								 oci_execute($curs_ex);
								 
                 if (oci_fetch($curs_ex))
                 {
                    $extcode=oci_result($curs_ex, 1);
                 }

                 //тест
   echo "
   <button class='btn control' style='float: right;' onclick='print_version();'>Распечатать отчет</button>
   <button style='float: right;' class='btn' onclick='reportToPDF2();'>Скачать отчет</button>
   <div id='wrapper-pdf'>
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
 
  </table>
  <span style='font-size:15px;'>Итоги размещения:</span>
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
        </tr>
          ";
          if (oci_fetch($curs8))
          {
             $issue_v=oci_result($curs8, 1);
             $issue_vnc=oci_result($curs8, 2);
             $svol=oci_result($curs8, 3);
             $sncvol=oci_result($curs8, 4);
             $shname=oci_result($curs8, 5);
             $v=oci_result($curs8, 6);
             $tot=oci_result($curs8, 7);
             $ud_svol=oci_result($curs8, 8);
            $ud_sncvol=oci_result($curs8, 9);
            if($ud_svol == ''){$ud_svol = 0;};
            if($ud_sncvol == ''){$ud_sncvol = 0;};
            $shortNm = substr($shname,0,3);
          }
         $totalsByType['Konkurent'] = array('volume' => 0, 'dl_total' => 0,'dl_total_nom' => 0);
         $totalsByType['NeKonkurent'] = array('volume' => 0, 'dl_total' => 0,'dl_total_nom' => 0);
          
         //prev
            //prev
            $cursPredDate = oci_parse($c,"select * from  (select t.date0 from  ls.auction_orders t,
            ".TS.".currinstrument c,
            ls.auction_issue i where c.shortname like '%". $shortNm ."%' and t.status != 2 and t.curr_id=c.id and t.price > 0 and t.curr_id = i.curr_id and 
            t.date0 < ".MakeLongDate($date1)." and t.date0 > 132580632 and i.date0 < ".MakeLongDate($date1)." and i.date0 > 132580632 order by t.date0 desc ) where ROWNUM <= 1");
         
            oci_execute($cursPredDate);
             if (oci_fetch($cursPredDate)) {
                $pred_date = oci_result($cursPredDate,1);
             };
             
            $prev__curs7 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp,
            (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
            (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total
         from ls.auction_orders t, ".TS.".currinstrument c,ls.auction_issue i 
         where c.shortname like '%".$shortNm."%' and t.status != 2 and t.curr_id=c.id and t.curr_id = i.curr_id and t.date0 = ".$pred_date." and i.date0 = ".$pred_date."
         order by shortname ASC,t.price DESC");
  
             oci_execute($prev__curs7);
         $prev__totalsByType['Konkurent'] = array('volume' => 0, 'dl_total' => 0);
         $prev__totalsByType['NeKonkurent'] = array('volume' => 0, 'dl_total' => 0);
          
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

        //if (!isset($totalsByType[$type])) {}
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
           $tc=0;
           $grand_volume=0;
           $grand_total=0;
           $grand_dl_volume=0;
           $grand_dl_total=0;
           $grand_dl_total_nom=0;
        } 
        $class='info';
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
       
        $namerus=$shname;
		
		
    }
    while (oci_fetch($prev__curs7)) {
      $prev__type=oci_result($prev__curs7, 1);
      $prev__dl_volume=oci_result($prev__curs7, 2);
      $prev__dl_total=oci_result($prev__curs7, 3);
      $prev__totalsByType[$prev__type]['volume'] += $prev__dl_volume;
      $prev__totalsByType[$prev__type]['dl_total'] += $prev__dl_total;
  }
       $count = 0;
	    foreach ($totalsByType as $type => $totals) {
         $dl_price2 = 0;
         if($type == 'NeKonkurent') {
            $nPrice = $totals['dl_total']/$totals['volume'];
         }
         else if ($type == 'Konkurent') {
            $kPrice = $totals['dl_total']/$totals['volume'];
         }   
         if($nPrice > 0) {
            $dl_price2 = $nPrice;
         }
         else {
            $dl_price2 = $kPrice;
         }
         $value_dl = myRound($dl_price2);
       }
       $prev__count = 0;
	    foreach ($prev__totalsByType as $prev__type => $prev__totals) {
         $prev__dl_price2 = 0;
         if($prev__type == 'NeKonkurent') {
            $prev__nPrice = $prev__totals['dl_total']/$prev__totals['volume'];
         }
         else if ($prev__type == 'Konkurent') {
            $prev__kPrice = $prev__totals['dl_total']/$prev__totals['volume'];
         }   
         if($prev__nPrice > 0) {
            $prev__dl_price2 = $prev__nPrice;
         }
         else {
            $prev__dl_price2 = $prev__kPrice;
         }
         $prev__value_dl = myRound($prev__dl_price2);
       }
       foreach ($totalsByType as $type => $totals) {
         $count += 1;
         if($type == 'Konkurent')  {
			$typerus = 'На конкурентной основе';
		}
         else{$typerus = 'На неконкурентной основе';};
         echo "<tr>
         <td style='max-width:300px;'>".$typerus."</td> 
         <td align='right'>".number_format($totals['volume'], 2,',',' ')."</td> 
         <td align='right'>".number_format($totals['dl_total_nom'], 2,',',' ') . "</td> 
         <td align='right'>".number_format($totals['dl_total'], 2,',',' ') . " </td> 
         ";
         if($count == 1) {
            echo "<td class='info' rowspan='3' align='center'>".number_format($value_dl,2,',',' ')."</td>
            <td class='info' rowspan='3' align='center'>".number_format(myRound($doh),2,',',' ')." </td>";
         }
         echo "</tr>";
     }
          }
     
   
        echo "
        <tr>
        <td class='info'>Всего:</td>
        <td class='info' align='right'>".number_format($grand_volume_vs, 2, ',', ' ')."</td>
        <td class='info' align='right'>".number_format($grand_dl_total_vs_nom, 2, ',', ' ')."</td>
        <td class='info' align='right'>".number_format($grand_dl_total_vs, 2, ',', ' ')."</td>
        
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
                    if ($itogi = ora_logon("ls@".SRV,"ls"))
                    {
					  $shortNm = substr($shname,0,3);

                
						$curs83 = oci_parse($itogi, "select * from (select ai.volume,ai.volume_nocomp,
									  (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol,
									  (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol,
									  curr.shortname, ai.pred, ai.tot,
									  (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price>0) as ud_svol,
									  (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price<0) as ud_sncvol,
									  ai.date0
									  from ls.auction_issue ai, ".TS.".currinstrument curr
									  where curr.id=ai.curr_id and curr.shortname like '". $shortNm ."%' and ai.date0<".MakeLongDate($date1) . " and ai.date0 > 132580632 order by ai.date0 desc) where ROWNUM <= 1");
						
						oci_execute($curs83);
						while (oci_fetch($curs83))
							{
								$svolPred=oci_result($curs83, 3);
								$sncvolPred=oci_result($curs83, 4);
								$shnamePred=oci_result($curs83, 5);
								$vPred=oci_result($curs83, 6);
								$totPred=oci_result($curs83, 7);
								$ud_svolPred=oci_result($curs83, 8);
								$ud_sncvolPred=oci_result($curs83, 9);
								$datePred=oci_result($curs83, 10);
								$pred_vPred=($vPred*70/100);
								$pred_vncPred=($vPred-$pred_vPred);
								$pred_vPred=$pred_vPred*NamCost;
								$pred_vncPred=$pred_vncPred*NamCost;
								$svolPred=$svolPred*NamCost;
								$sncvolPred=$sncvolPred*NamCost;
								$ud_svolPred=$ud_svolPred*NamCost;
								$ud_sncvolPred=$ud_sncvolPred*NamCost;
							}
                      $curs8 = oci_parse($itogi, "select ai.volume,ai.volume_nocomp,
                      (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0 and ao.conf != 2) as svol,
                      (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0 and ao.conf != 2) as sncvol,
                      curr.shortname, ai.pred, ai.tot,
                      (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price>0) as ud_svol,
                      (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price<0) as ud_sncvol,
					       ai.volume_nbkr+ai.volume_nocomp_nbkr as total_nbkr_volume
                      from ls.auction_issue ai, ".TS.".currinstrument curr
                      where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
							oci_execute($curs8);
					  echo "
						   <br>
						   <br>
						   <br>
								 <table class='new-report' border='1'>
								 <tr>
									<th class='info_title'></th>
									<th class='info_title'>Текущий аукцион ".$shname.' '. str_replace('/', '.', $date1)."</th>
									<th class='info_title'>Предыдущий аукцион ".$shnamePred .' '. str_replace('/', '.',MakeDate($datePred)) . "</th>
									<th class='info_title'>Абсолютная разница</th>
								</tr>
								  
						 ";
                        while (oci_fetch($curs8))
                        {
                          $svol=oci_result($curs8, 3);
                          $sncvol=oci_result($curs8, 4);
                          $shname=oci_result($curs8, 5);
                          $v=oci_result($curs8, 6);
                          $tot=oci_result($curs8, 7);
                          $ud_svol=oci_result($curs8, 8);
                          $ud_sncvol=oci_result($curs8, 9);
						        $total_nbkr_volume=oci_result($curs8, 10);
                          $pred_v=($v*70/100);
                             $pred_vnc=($v-$pred_v);
                             $pred_v=$pred_v*NamCost;
                             $pred_vnc=$pred_vnc*NamCost;
                             $svol=$svol*NamCost;
                             $sncvol=$sncvol*NamCost;
                             $ud_svol=$ud_svol*NamCost;
                             $ud_sncvol=$ud_sncvol*NamCost;
							 
							  $totalNBKR = $total_nbkr_volume != 0 ? $total_nbkr_volume*NamCost : $ud_sncvol+$ud_svol;
							 $raznica1 = (($pred_v+$pred_vnc)/NamCost/1000)-(($pred_vPred+$pred_vncPred)/NamCost/1000); // Объем предложения (в тыс. сомах)
							 $raznica2 = (($svolPred+$sncvolPred)/1000 != 0) ? (($svol+$sncvol)/1000)-(($svolPred+$sncvolPred)/1000) : ""; // Объем спроса (по номиналу, в тыс сомах)
							 $raznica3 = (($ud_sncvolPred+$ud_svolPred)/1000 != 0) ? (($ud_sncvol+$ud_svol)/1000)-(($ud_sncvolPred+$ud_svolPred)/1000) : ""; // Объем размещения (по номиналу, в тыс сомах)
							
                      $prev__qwery_str="select 
                      max(shortname),
                      min(dl_price),max(dl_price), 
                      sum(dl_volume*round(dl_price,2))/sum(dl_volume) avg_price, 
                       max(prof) from ( select t.price, t.profit as prof, 
                       (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume, 
                       (select round(d.price,2) from ls.auction_deals d where d.order_id=t.rowid) as dl_price, 
                       c.shortname shortname, c.id as curr from ls.auction_orders t, 
                       ".TS.".currinstrument c where c.shortname like '%".$shortNm."%' and t.curr_id=c.id and date0 = ".$pred_date."  order by date0 DESC )  group by curr";
                  
                      $prev__curs_pr = oci_parse($itogi,$prev__qwery_str);
                      oci_execute($prev__curs_pr);
                      while (oci_fetch($prev__curs_pr))
                      {
                         $prev__name=oci_result($prev__curs_pr,1);
                         $prev__max_price=oci_result($prev__curs_pr,3);
                         $prev__min_price=oci_result($prev__curs_pr,2);
                         $prev__avg_price=oci_result($prev__curs_pr,4);
                         $prev__max_dohh=oci_result($prev__curs_pr,5);   
                      }
                            //prev
                  $prev__cenaParse = oci_parse($itogi,"
                  select t.price ,
                  t.profit as ord , i.profit_nocomp_avg as avg_doh from  ls.auction_orders t,
                  ".TS.".currinstrument c,
                  ls.auction_issue i where c.shortname like '%".$shortNm."%' and t.status != 2 and t.curr_id=c.id and t.price > 0 and t.curr_id = i.curr_id and 
                  t.date0 = ".$pred_date." and i.date0 = ".$pred_date." order by t.date0 desc");
              
                  oci_execute($prev__cenaParse);
                  while(oci_fetch($prev__cenaParse)) 
                  {
                     $prev__cena = oci_result($prev__cenaParse,1);
                     $prev__newdoh = oci_result($prev__cenaParse,2);
                     $prev__avg_doh = oci_result($prev__cenaParse,3);
                  }


                             echo "
                               <tr>
                                 <td class='info'>Объем предложения (в тыс. сомах)</td>
                                 <td class='info' align='right'>".number_format(($pred_v+$pred_vnc)/NamCost/1000, 2, ',', ' ')."</td>
                                 <td class='info' align='right'>".number_format(($pred_vPred+$pred_vncPred)/NamCost/1000, 2, ',', ' ')."</td>
                                 <td class='info' align='right'>".number_format($raznica1, 2, ',', ' ')."</td>
                               </tr>
                               <tr>
                                 <td class='info'>Объем спроса (по номиналу, в тыс сомах)</td>
                                 <td class='info' align='right'>".number_format(($svol+$sncvol)/1000, 2, ',', ' ')."</td>
                                 <td class='info' align='right'>".number_format(($svolPred+$sncvolPred)/1000, 2, ',', ' ')."</td>
                                 <td class='info' align='right'>" . number_format($raznica2, 2, ',', ' ') . "</td>
                               </tr>
                               <tr>
                                <td class='info'>Объем размещения (по номиналу, в тыс сомах)</td>
                                <td class='info' align='right'>".number_format($totalNBKR/1000, 2, ',', ' ')."</td>
                                <td class='info' align='right'>".number_format(($ud_sncvolPred+$ud_svolPred)/1000, 2, ',', ' ')."</td>
                                <td class='info' align='right'>" . number_format(($totalNBKR/1000)-(($ud_sncvolPred+$ud_svolPred)/1000), 2, ',', ' ') . "</td>
                                </tr>
                                <tr>
                                    <td>Средневзвешенная цена (в сомах)</td>
                                    <td align='right'>".number_format($value_dl,2,',',' ')."</td>
                                    <td align='right'>".number_format($prev__value_dl,2,',',' ')."</td>
                                    <td align='right'>".number_format((number_format($value_dl,2) - number_format($prev__value_dl,2)),2,',','')."</td>
                                </tr>
                                <tr>
                                    <td>Средневзвешенная доходность, (в %)</td>
                                    <td align='right'>".number_format($doh,2,',',' ')."</td>
                                    <td align='right'>".number_format($prev__avg_doh,2,',',' ')."</td>
                                    <td align='right'>".number_format(($doh - $prev__avg_doh),2,',',' ')."</td>
                                </tr>
                             ";
                        }
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

                  
                    //find cena 
                  $cenaParse = oci_parse($itogi,"select t.price ,t.profit as ord from ls.auction_orders t, ".TS.".currinstrument c,ls.auction_issue i where t.status != 2 and t.curr_id=c.id and t.price > 0 and t.curr_id = i.curr_id and t.date0=".MakeLongDate($date1)." and i.date0=".MakeLongDate($date1)." order by shortname ASC,t.price DESC");
                  oci_execute($cenaParse);
                  while(oci_fetch($cenaParse)) 
                  {
                     $cena = oci_result($cenaParse,1);
                     $newdoh = oci_result($cenaParse,2);
                  }
                 
                 $curs_pr = oci_parse($itogi,$qwery_str);
						oci_execute($curs_pr);
               

                     $doh_by_price = oci_parse($itogi,"select profit from LS.AUCTION_ORDERS t where DATE0=".MakeLongDate($date1)." and status = 1 and price = (select max(price) from LS.AUCTION_ORDERS t where DATE0=".MakeLongDate($date1).")");
                     oci_execute($doh_by_price);
                     if(oci_fetch($doh_by_price)) {
                        $doh_by_maxprice = oci_result($doh_by_price,1);
                     }
                     $prev_doh_by_price = oci_parse($itogi,"select profit from LS.AUCTION_ORDERS t where DATE0=".$pred_date." and status = 1 and price = (select max(price) from LS.AUCTION_ORDERS t where DATE0=".$pred_date.")");
                     oci_execute($prev_doh_by_price);
                     if(oci_fetch($prev_doh_by_price)) {
                        $prev_doh_by_maxprice = oci_result($prev_doh_by_price,1);
                     }
                  
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
                           <td class='info' align='right'>".number_format($max_price,2,',',' ')."</td>
                           <td class='info' align='right'>".number_format($prev__max_price,2,',',' ')."</td>
                           <td class='info' align='right'>".number_format($max_price - $prev__max_price,2,',',' ')."</td>
                        </tr>
                        <tr>
                           <td>Доходность , в % по максимальной цене (в %)</td>
                           <td align='right'>".number_format($doh_by_maxprice,2,',',' ')."</td>
                           <td align='right'>".number_format($prev_doh_by_maxprice,2,',',' ')."</td>
                           <td align='right'>".number_format($doh_by_maxprice - $prev_doh_by_maxprice,2,',',' ')."</td>
                        </tr>
                        <tr>
                           <td>Цена отсечения (в сомах)</td>
                           <td align='right'>".number_format($cena,2,',',' ')."</td>
                           <td align='right'>".number_format($prev__cena,2,',',' ')."</td>
                           <td align='right'>".number_format($cena - $prev__cena,2,',',' ')."</td>
                        </tr>
                        <tr>
                           <td>Доходность, в % по цене отсечения (в %)</td>
                           <td align='right'>".number_format($newdoh,2,',',' ')."</td>
                           <td align='right'>".number_format($prev__newdoh,2,',',' ')."</td>
                           <td align='right'>".number_format($newdoh-$prev__newdoh,2,',',' ')."</td>
                        </tr>
                        </table>
                        </div>
                     ";}
         break;
      }
      case 4: {
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
            $curs8 = oci_parse($c, "select
            curr.shortname, 
            curr.namerus,
            curr.cupontax,
             ai.pred,
              ai.tot,
               ai.repayment_date,
                ai.freq_payments,
                 ai.settlement_date from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1));
            oci_execute($curs8);
            if (oci_fetch($curs8))
            {
               $shname=oci_result($curs8, 1);
               $type = oci_result($curs8,2);
               $cupon = oci_result($curs8,3);
               $volume = oci_result($curs8,4);
               $volumeGsb = $volume/100;
               
            }
            $appealPeriod = ''; 
            if(substr($shname,0,5) == "GBA02")
            {$appealPeriod = "2 года";}
            else if (substr($shname,0,5) == "GBA05") {
            {$appealPeriod = "5 лет";}
            }
            else if (substr($shname,0,5) == "GBA07") {
            {$appealPeriod = "7 лет";}
            }
             else if (substr($shname,0,2) == "GD") {
            {$appealPeriod = "364 дня";}
            }
            else{$appealPeriod = "";};  
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
                       //считаем количество банковских
      $bank_users=" select count(*) from (
         select
         n.nick 
          from ls.AUCTION_ORDERS o, 
          ".TS.".firm n where n.id=o.idfirm and date0=".MakeLongDate($date1)." and n.nick LIKE '%BNK%' group by o.idfirm,
               n.nick order by o.idfirm, n.nick 
                  ) tab";
      if ($cnt_us = ora_logon("ls@".SRV,"ls"))
         {
            $cc_us_bank=oci_parse($cnt_us,$bank_users);
                        oci_execute($cc_us_bank);
            if (oci_fetch($cc_us_bank))
            {
               $cnt_users_bank= oci_result($cc_us_bank, 1);
            }
          }
                 
                 //тест
   echo "
   <button class='btn control' style='float: right;' onclick='print_version();'>Распечатать отчет</button>
   <button style='float: right;' class='btn' onclick='reportToPDF2();'>Скачать отчет</button>
   <div id='wrapper-pdf'>
  <table width='100%'>
  <tr>
  <td colspan='10' align='left'>
  <div width='100%' align='center'>
  <b>ИНФОРМАЦИЯ ПО ДОПРАЗМЕЩЕНИЮ</b>
  </div> <br>
  </td>
  </tr>
  <tr>
      <td colspan='12' align='right'>Дата: ".$date1."</td>
  </tr>

  </table>
  <span style='font-size:15px;'>Общая информация по допразмещению:</span>
        <table class='new-report' border='1'>
                 <tr>
                     <td>Дата дополнительного размещение</td>
                     <td>".$date1."</td>
                 </tr>
                 <tr>
                     <td>Вид ГЦБ</td>
                     <td>".$type."</td>
                 </tr>
                 <tr>
                     <td>Срок обращение ГЦБ</td>
                     <td>".$appealPeriod."</td>
                 </tr>
                 <tr>
                     <td>Регистрационный номер</td>
                     <td>".$shname."</td>
                 </tr>
                 <tr>
                     <td>Количество ГЦБ (в штуках)</td>
                     <td>".number_format($volumeGsb,0, ',' ,' ')."</td>
                 </tr>
                 <tr>
                     <td>Обьем эмиссии</td>
                     <td>".number_format($volume,2,',',' ')."</td>
                 </tr>
                 <tr>
                     <td>Средневзвешенная цена(сом)</td>
                     <td></td>
                 </tr>
                 <tr>
                     <td>Доходность (в %)</td>
                     <td></td>
                 </tr>
                 <tr>
                     <td>Купонная ставка (в %)</td>
                     <td>".number_format($cupon,2,',' ,' ')."</td>
                 </tr>
                 <tr>
                 <td>Количество участников <br/> Из них: </td>
                     <td>".$cnt_users."</td>
                 </tr>
                 <tr>
                     <td>Финансовые участники</td>
                     <td>".$cnt_users_bank."</td>
                 </tr>
                 <tr>
                     <td>Институциональные инвесторы</td>
                     <td></td>
                 </tr>
                 <tr>
                     <td>Инвесторы <br> резидент/Нерезидент</td>
                     <td>".$cnt_users." / 0</td>
                 </tr>
        </table>";

        $curs7 = oci_parse($c, "select 
        ls.auction_make_comp(t.price) as comp, 
        (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
         (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total
         from ls.auction_orders t, ".TS.".currinstrument c,ls.auction_issue i 
     where t.status != 2 and t.curr_id=c.id and t.curr_id = i.curr_id and t.date0=".MakeLongDate($date1)." and i.date0=".MakeLongDate($date1)."
     order by shortname ASC,t.price DESC");
 
         oci_execute($curs7);

		while (oci_fetch($curs7)) {
        $dl_volume=oci_result($curs7, 1);
        $dl_total=oci_result($curs7, 2);
        $grand_volume_vs+=$dl_volume;
        $grand_dl_total_vs+=floatval(str_replace(',','.',str_replace(' ','',$dl_total)));
        $grand_dl_total_vs_nom = $grand_volume_vs;
    }
          }
        echo "
        <br><br><br><br><br>
        <span style='font-size:15px;'>Итоги дополнительного размещение</span>
        <table class='new-report' border='1'>
        <tr>
        <th class='info_title'>Общее кол-во заявленных ГЦБ (в штуках)</th>   
        <th class='info_title'>Количество удовлетворенных ГЦБ (в штуках)</th>
        <th class='info_title'>Сумма удовлетворенных ГЦБ по факту (в сомах)</th>
       </tr>
        <tr>
            <td class='info' align='center'>".number_format($grand_volume_vs, 2, ',', ' ')."</td>
            <td class='info' align='center'>".number_format($grand_dl_total_vs_nom, 2, ',', ' ')."</td>
            <td class='info' align='center'>".number_format($grand_dl_total_vs, 2, ',', ' ')."</td>
        </tr>
        </table>
        ";   
         break;
      }
      case 5: {
         if ($_SESSION[PORTAL.'USER']['admin']!=1 && $_SESSION[PORTAL.'USER']['admin']!=5){die ('Нет прав!');};
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

               $curs6 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp,
               to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, 
               to_char(profit,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as profit, 
               ( select volume from ls.auction_deals d where d.order_id = t.rowid ) as volume,
               date0, time0, acc.code, rn.rusnick, 
               ( select volume * price from ls.auction_deals d where d.order_id = t.rowid ) as total,
               ( select  profit  from  ls.auction_deals d  where d.order_id = t.rowid ) as profit_2
               from ls.auction_orders t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc, ".TS.".firm f,ls.nicks rn where t.curr_id=curr.id and t.conf != 2 and t.idfirm=f.id and date0=".MakeLongDate($date1)." and acc.id=t.account ".$f." and f.nick = rn.nick order by comp desc, price desc");
         
               oci_execute($curs6);
               $curs61 = oci_parse($c, "select curr.shortname ,
               (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price>0) as ud_svol,
               (select sum(d.volume) from ls.auction_deals d,ls.auction_orders ao where d.curr_id=ai.curr_id and d.date0=ai.date0 and d.order_id=ao.rowid and ao.price<0) as ud_sncvol,
			   ai.volume_nbkr+ai.volume_nocomp_nbkr as total_nbkr,ai.volume_nocomp_nbkr
                from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and ai.date0=".MakeLongDate($date1)."");
           
               oci_execute($curs61);
               if (oci_fetch($curs61))
               {
                  $shortName=oci_result($curs61, 1);
                  $allTotal=oci_result($curs61,2);
                  $allNoConTotal=oci_result($curs61,3);
				      $total_nbkr = oci_result($curs61,4);
                  $total_nc_nbkr = oci_result($curs61,5);
                  $allNoConTotal ? $allNoConTotal = $allNoConTotal : '';
                  $allTotal=$allTotal+$allNoConTotal;
				      $allNoConTotal=$total_nc_nbkr !=0 ? $total_nc_nbkr : $allNoConTotal;
                  $allTotal=$total_nbkr !=0 ? $total_nbkr : $allTotal;
               }

   echo "
   <button class='btn control' style='float: right;' onclick='print_version();'>Распечатать отчет</button>
   <button style='float: right;' class='btn' onclick='reportToPDF2();'>Скачать отчет</button>
   <div id='wrapper-pdf'>
   <h4 align='center'>Ведомость для Центрального депозитария</h4>
   <p align='right'>Дата: ".$date1."</p>
   <br/>
   <br/>
   <span style='font-size:15px;'>Общая информация по аукциону</span>
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
   <td>".number_format($allTotal*NamCost, 2, ',', ' ')."</td>
   </tr>
   <tr>
   <td>в т.ч Неконкурентные на сумму (сом)</td>
   <td>".number_format($allNoConTotal*NamCost,2,',',' ')."</td>
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
         Фактическое количество гцб
         </th>
         <th class='info_title'>
            Фактическая стоимость (сом)
         </th>
         <th class='info_title'>
            Цена заявки (сом)
         </th>
         <th class='info_title'>
            Доходность по цене (в %)
         </th>
        </tr>";
    while (oci_fetch($curs6)) {
        $typee=oci_result($curs6, 1);
        $price=oci_result($curs6, 2);
        $profit=oci_result($curs6, 3);
        $volume=oci_result($curs6, 4);
        $date0=MakeDate(oci_result($curs6, 5));
        $time0=MakeTime(oci_result($curs6, 6));
        $account=oci_result($curs6, 7);
        $firm=oci_result($curs6, 8);
        $total=oci_result($curs6, 9);
        $profit2=oci_result($curs6, 10);
        oci_fetch($curs60);
		
        $class='info';

        if ($status==1 || $status==2){$class='info_done';}
        if ($status==3 || $status==4){$class='info_notfull';}
        $grand_volume+=$volume;
        $grand_total+=$total;
   
       if($typee == 'Konkurent'){$price;} else {$price='';};
       $newprofit = 0;
       is_null($profit2) ? $newprofit = $profit : $newprofit = $profit2;
        echo "<tr>
        <td class='info'>".$firm."</td>
        <td class='info'>".number_format($volume,0,',',' ')."</td>
        <td class='info'>".number_format($total, 2, ',', ' ')."</td>
        <td class='info'> ".$price."</td>
        <td class='info'>".number_format(str_replace(',', '.', $newprofit), 2, ',', ' ' )."</td>
         </tr>";
    }
         }

     echo "<tr>
      <td class='info'>Итого:</td>
      <td class='info'>".number_format($grand_volume, 0, ',', ' ')."</td>
      <td class='info'>".number_format($grand_total, 2, ',', ' ')."</td>
      <td class='info'>&nbsp;</td>
      <td class='info'>&nbsp;</td>
     </tr>";

         echo "</table>
         </div>";
         break;
      }
   }
   }


