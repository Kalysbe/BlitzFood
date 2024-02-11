<?php
//error_reporting(E_ALL);

if (!defined('WEB_ROOT')){die ('Oops...');}

include ('./core/minfin_menu.php');

if (isset($_GET['go'])){
  $go=$_GET['go'];
}
if (isset($_GET['page'])){
  $page=$_GET['page'];
}

$date1=date('d/m/Y');
$nProfit='0';
$nVolume_NBKR='0';
$nVolume_Nocomp_NBKR='0';
if (isset($_GET['nProfit']) || isset($_GET['nVolume_Nocomp_NBKR']) || isset($_GET['nVolume_NBKR'])){

	$nProfit=$_GET['nProfit'];
   $nVolume_Nocomp_NBKR=$_GET['nVolume_Nocomp_NBKR'];
   $nVolume_NBKR=$_GET['nVolume_NBKR'];
	$sql="update ls.auction_issue set profit_nocomp=".$nProfit.", Volume_Nocomp_NBKR=".$nVolume_Nocomp_NBKR.", 
   Volume_NBKR=".$nVolume_NBKR."
   where curr_id=".$page." and date0=".MakeLongDate($date1);
	//echo $sql;
	if ($c = ora_logon("ls@".SRV,"ls"))
	{
		$stmt=oci_parse($c,$sql);
		$res=oci_execute($stmt);
	//	if ($res) {echo 'true';} else {echo 'false';}
	}
}


/*if (isset($_GET['nVolume_Nocomp_NBKR'])){
    
	$nVolume_Nocomp_NBKR=$_GET['nVolume_Nocomp_NBKR'];
	
	$sql="update ls.auction_issue set Volume_Nocomp_NBKR=".$nVolume_Nocomp_NBKR." where curr_id=".$page." and date0=".MakeLongDate($date1);
	//echo $sql;
	if ($c = ora_logon("ls@".SRV,"ls"))
	{
		$stmt=oci_parse($c,$sql);
		$res=oci_execute($stmt);
	//	if ($res) {echo 'true';} else {echo 'false';}
	}
}

if (isset($_GET['nVolume_NBKR'])){
    
	$nVolume_NBKR=$_GET['nVolume_NBKR'];
	
	$sql="update ls.auction_issue set Volume_NBKR=".$nVolume_NBKR." where curr_id=".$page." and date0=".MakeLongDate($date1);
	//echo $sql;
	if ($c = ora_logon("ls@".SRV,"ls"))
	{
		$stmt=oci_parse($c,$sql);
		$res=oci_execute($stmt);
	//	if ($res) {echo 'true';} else {echo 'false';}
	}
}
*/
//если не выбран лот, показываем картинку.
if ($page==''){
  if (($_SESSION['STATUS']<1) || ($_SESSION['CONF']<1))
   {
      $str = "Этап предварительных расчетов еще не наступил...<br>Зайдите пожалуйста в установленное регламентом время.";
   }
   else{
     $str = "Для просмотра предварительных результатов нажмите на название лота в верхнем левом углу.";
   }
 echo "<br><br><br><br><br>
<div align='center'>
<div class='banner' align='center'>
Аукцион ГКВ<br>
Кыргызская Фондовая Биржа<br><br>
<img height='64' width='64px' src='./img/favicon.png'>
<br>
".$str."
<br>
<br>
</div>
</div>
<br><br><br>";
}
else{
if (isset($_GET['arg'])){
  //echo "arg:".$_GET['arg']."<br>";
  //echo "id:".$_GET['id']."<br>";
  //echo "date:".$date1."<br>";
  sel($_GET['arg'],MakeLongDate($date1),$_GET['id']);
}
//echo $go."<br>";
//echo $page;

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
// подтверждение минфином!!!!
if ($_SESSION[PORTAL.'USER']['admin']==2)
{
   if (($_SESSION['STATUS']<1) || ($_SESSION['CONF']<1))
   {
      echo "Этап предварительных расчетов еще не наступил...<br>Зайдите пожалуйста в установленное регламентом время.";
      exit();
   }
   if (isset($_POST['agree']))
   {
      $agree=intval($_POST['agree']);
      $sql="update ls.auction_issue set mf=".$agree." where curr_id=".$page." and date0=".MakeLongDate($date1);
      if ($c = ora_logon("ls@".SRV,"ls"))
      {
         $stmt=oci_parse($c,$sql);
				 oci_execute($stmt);
      }
      //---------если аукцион по данной бумаге отклонен.---------

      //1.удаляем все сделки по отклоненному лоту.
      //2.всем приказам по отклоненному лоту делаем статус 2
      //3.объем лота делаем равным нулю.
      if ($agree==2){
        //1.
        $sql="delete from ls.auction_deals where curr_id=".$page." and date0=".MakeLongDate($date1);
        if ($c = ora_logon("ls@".SRV,"ls")){
          $stmt=oci_parse($c,$sql);
					oci_execute($stmt);
        }
        //2.
        $sql="update ls.auction_orders set status=2 where curr_id=".$page." and date0=".MakeLongDate($date1);
        if ($c = ora_logon("ls@".SRV,"ls"))
        {
          $stmt=oci_parse($c,$sql);
					oci_execute($stmt);
        }
        //3.
        $sql="update ls.auction_issue set volume=0, volume_nocomp=0 where curr_id=".$page." and date0=".MakeLongDate($date1);
        if ($c = ora_logon("ls@".SRV,"ls"))
        {
         $stmt=oci_parse($c,$sql);
				 oci_execute($stmt);
        }
      }
      //--------конец процедуры отклонения аукциона по данной бумаге
      $curs_lot=oci_parse($c,"select count(*) from ls.auction_issue where mf=0 and date0=".MakeLongDate($date1)."");
			oci_execute($curs_lot);
      if (oci_fetch($curs_lot))
        {
          $cnt=oci_result($curs_lot, 1);
        }
				
      $curs_agree=oci_parse($c,"select count(*) from ls.auction_issue where mf=1 and date0=".MakeLongDate($date1)."");
			oci_execute($curs_agree);
      if (oci_fetch($curs_agree))
        {
          $cnt_agree=oci_result($curs_agree, 1);
        }
      if ($cnt==0){
              if ($cnt_agree>0){
                $ag=1;
              }
              else
              {
                $ag=2;
              }
                         $sql="update ls.auction_options set mf=".$ag." where date0=".MakeLongDate($date1);
                         if ($c = ora_logon("ls@".SRV,"ls"))
                         {
                            $stmt=oci_parse($c,$sql);
														oci_execute($stmt);
                         }
      }
      echo "Подтверждение результатов аукциона. Подождите немного...<script>document.location='".WEB_ROOT."?go=database'</script>";
      exit();
   }
}
// подтверждение минфином конец!!!!

$st=0;
         //$tp='Конкурентный';
		 $tp='Konkurent';
         $tc=0;
         $tnc=0;
         $num=0;
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
where t.curr_id=c.id t.curr_id=".$page." and date0=".MakeLongDate($date1)."
order by t.price desc");*/

// round((select ((100-round(d.price,2))/round(d.price,2))*/*(360/ts.maket(c.shortname))*/100 from ls.auction_deals d where d.order_id=t.rowid),4) as dl_doh,

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------
// change bprog 09.11.2015
//                $sql_l="select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
//														t.volume*t.price as total,
//														(select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
//														(select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
//														(select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
//														round((select d.price from ls.auction_deals d where d.order_id=t.rowid),2) as dl_price,
//														(select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
//														(select t.profit from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,
//														c.shortname,t.status
//													from ls.auction_orders t, ".TS.".currinstrument c
//													where t.curr_id=c.id and t.curr_id=".$page." and t.conf=1 and date0=".MakeLongDate($date1)."
//													order by t.price desc";

//$sql_l= "select ls.auction_make_comp(t.price) as comp, 
//                           sum(t.volume) as ord_volume, 
//                            t.price ord_price,
//                            sum(t.volume*t.price) as ord_total,
//                            max(ts.makedate(t.date0)) as dl_date,
//                            max(ts.maketime(t.time0)) as dl_time,
//                            sum(d.volume) as dl_volume,
//                            d.price dl_price,
//                            sum(d.volume)*round(d.price,2) as dl_total,
//                            t.profit dl_doh,
//                            c.shortname,
//	from ls.auction_orders t, ".TS.".currinstrument c, ls.auction_deals d
//	where t.curr_id=c.id and t.curr_id=".$page." and t.conf=1 and t.date0=".MakeLongDate($date1)." and d.order_id=t.rowid
//	group by ls.auction_make_comp(t.price), t.profit, t.price, d.price, c.shortname
//	order by t.profit desc";


//	$sql_profit = "select max(t.profit) from ls.AUCTION_ORDERS t where t.curr_id=".$page." and t.date0=".MakeLongDate($date1)." and t.status=2;"
//	$curs_profit = oci_parse($c, $sql_profit);
//	oci_execute($curs_profit);
//	if (oci_fetch($curs_profit))
//	{
//		$off_point_profit = oci_result($curs_profit, 1);
//	}
	
$sql_l="select tt.comp comp, 
       sum(tt.volume) volume, 
       tt.price price, 
       sum(tt.total) total, 
       tt.dl_date, tt.dl_time, 
       sum(tt.dl_volume) dl_volume, 
       tt.dl_price dl_price,
       sum(tt.dl_total) dl_total,
       tt.dl_doh dl_doh,
       tt.shortname shortname,
       tt.status status,
	   tt.profit profit
         
from 
(select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
                            t.volume*t.price as total,
                            (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
                            (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
                            (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
                            round((select d.price from ls.auction_deals d where d.order_id=t.rowid),2) as dl_price,
                            (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
                            (select t.profit from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,
                            c.shortname,t.status, 
							round((select d.profit from ls.auction_deals d where d.order_id=t.rowid),2) as profit --t.profit
                          from ls.auction_orders t, ".TS.".currinstrument c
                         where t.curr_id=c.id and t.curr_id=".$page." and t.conf=1 and date0=".MakeLongDate($date1)."
                          order by t.price desc) tt
group by tt.comp, tt.price, tt.dl_date, tt.dl_time, tt.dl_price, tt.dl_doh, tt.shortname, tt.status, tt.profit
order by tt.price desc";	

// end change bprog 09.11.2015
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
								
				$curs7 = oci_parse($c,	$sql_l);
								 
				oci_execute($curs7);
                $curs8 = oci_parse($c, "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.conf=1 and ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.conf=1 and ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol, curr.shortname, ai.pred, ai.tot from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and curr.id=".$page."  and ai.date0=".MakeLongDate($date1));
								 //echo "select ai.volume,ai.volume_nocomp, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price>0) as svol, (select sum(volume) from ls.auction_orders ao where ao.curr_id=ai.curr_id and ao.date0=ai.date0 and ao.price<0) as sncvol, curr.shortname, ai.pred, ai.tot from ls.auction_issue ai, ".TS.".currinstrument curr where curr.id=ai.curr_id and curr.id=".$page."  and ai.date0=".MakeLongDate($date1);
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
                 $curs_ex=oci_parse($c,"select t.extcode from ".TS.".currinstrument t where shortname ='".$shname."' and t.id=".$page." ");
								 oci_execute($curs_ex);
                 if (oci_fetch($curs_ex))
                 {
                    $extcode=oci_result($curs_ex, 1);
                 }

   echo "
         <table>
         <tr>
            <td>
               <span class='print_caption'>
               <div width='100%' align='center'>
                  Сводная ведомость
               </div> <br>
               </span>
            </td>
         </tr>
         <tr><td align='right'>".$date1."</td></tr>
         <tr><td>Общая информация по аукциону</td></tr>
         </table>
         <table class='new-report short' border='1' width='600px'>
               <tr>
                 <td>Дата аукциона</td>
                 <td>".$date1."</td>
               </tr>
               <tr>
                 <td>Вид ГЦБ</td>
                 <td></td>
               </tr>
               <tr>
                 <td>Срок обращение ГЦБ</td>
                 <td></td>
               </tr>
               <tr>
                 <td>Регистрационный номер</td>
                 <td>"./*$extcode*/$shname."</td>
               </tr>
               <tr>
                 <td>Количество ГЦБ (в штуках)</td>
                 <td>".number_format($grand_total, 2, ',', ' ')."</td>
               </tr>
               <tr>
                 <td>Объем предложения</td>
                 <td></td>
               </tr>
               <tr>
                 <td>Купонная ставка (%)</td>
                 <td></td>
               </tr>
               <tr>
                  <td>
                  <p>Количество участников</p>
                  Из них:
                  </td>
                  <td></td>
               </tr>
               <tr>
                  <td>Финансовый институты</td>
                  <td></td>
               </tr>
           <tr>
                <td>Институцональные инвесторы</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <p>Инвесторы</p>
                    резидент/Нерезидент
                </td>
                <td></td>
            </tr>
         </table>
         <table class='new-report' border='1'>
            <tr>
               <th>Обьем поступивших заявок на аукцион ГЦБ</th>
               <th>Кол-во ГЦБ (в штуках)</th>
               <th>По номиналу (в сомах)</th>
               <th>По факту (в сомах)</th>
               <th>% от общего обьема поступивших заявок (в %)</th>
            </tr>
            <tr>
               <td>На конкурентной основе</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>На неконкурентный основе</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td>Всего:</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
            </tr>
         </table>
         <div style='padding-top: 10px;'>
         <strong>Сводная ведомость поступивших заявок</strong>
     </div>
     <table class='new-report' border='1'>
         <tbody>
             <tr>
                 <th>Цена (сом)</th>
                 <th>Сумма заявок по номинальной цене (сом)</th>
                 <th>Обьем поступлений при удовлетворении заявок по данной (сом)</th>
                 <th>Доходность (в %)</th>
                 <th>Доходность по цене (в %)</th>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
         </tbody>
     </table>
        <table class='table-deals'>
        
         <tr>
         <td colspan='8' align='left'>
         <b>
            Дата размещения: <u></u><br>
            ГЦБ: <u>"./*$extcode*/$shname."</u><br>
         </b>
         </td>
         <td colspan='4' align='right' valign='bottom'>
            <span class='panel_item' onclick='print_version();'>Версия для печати</span>
            <span class='print_panel_item' onclick='normal_version();'>&#8592; Вернуться</span>
         </td>
         </tr>
         <tr>
         <td class='info_title' width='90'>
            Тип приказа
         </td>
         <td class='info_title' width='100'>
            Количество ЦБ в приказе (шт.)
         </td>
         <td class='info_title' width='100'>
            Доходность в приказе (%)
         </td>		 
         <td class='info_title' width='100'>
            Цена приказа (сом)
         </td>
         <td class='info_title' width='120'>
            Сумма приказа (сом)
         </td>
         <td class='info_title' width='170'>
            Дата/время сделки
         </td>
         <td class='info_title' width='100'>
            Количество ЦБ в сделке (шт.)
         </td>
         <td class='info_title' width='70'>
            Цена сделки (сом)
         </td>
         <td class='info_title' width='120'>
            Сумма сделки (сом)
         </td>
         <td class='info_title' width='100'>
            Доходность к погашению, %
         </td>
         <td class='info_title' width='100'>
            Отметка об утверждении
         </td> ";
         if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0){
         echo "
         <td class='info_title' width='30'>
            Т.О.
         </td>";
         }
         echo "
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
        $id=$volume;

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

        if ($dl_volume!=''){$dl_volume=number_format($dl_volume,0,',',' ');};
        if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        if ($doh!=''){$doh=number_format($doh,4,',',' ');};

        if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}

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
         <td class='".$class."' align='right'>&nbsp;</td>";
         if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0){
         echo "
         <td class='".$class."' align='right' id='".$id."' onclick=test('".$id."')>
         ";
         if ($_SESSION['num']==$id){
           $radtype='checked';
         }
         else{
           $radtype='unchecked';
         }

        echo "
         <label>
         <input type='radio' ".$radtype." name='Radio' value='111' id='rad".$id."'/>&nbsp;
         </label>";
         echo"
         </td>
         </tr>";
				}
		*/
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
        $doh=oci_result($curs7, 10);
        $shname=oci_result($curs7, 11);
        $status=oci_result($curs7,12);
		$ord_profit=oci_result($curs7,13);
		
        $id=$id+$volume;
        if ($id>($v-$issue_vnc)){
        //$id=$v-$issue_vnc;
        $st=$st+1;
        }

        if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}
        if ($tc==1)
        {
           echo "<tr><td class='info'><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td>
           <td class='info'>&nbsp;</td>
		   <td class='info'>&nbsp;</td>
           <td class='info' align='right'><b>".number_format($grand_total, 2, ',', ' ')."</b></td>
           <td class='info'>&nbsp;</td>
           <td class='info' align='right'><b>".number_format($grand_dl_volume, 0, ',', ' ')."</b></td>
           <td class='info'>&nbsp;</td>
           <td class='info' align='right'><b>".number_format($grand_dl_total, 2, ',', ' ')."</b></td>
           <td class='info'>&nbsp;</td>
           <td class='info'>&nbsp;</td>";
           if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0){
            echo"<td class='info'>&nbsp;</td>";
           }
           //if ($nProfit=='') {$nProfit=$dl_price;}
		   echo "
           </tr><tr><td class='info' colspan='12'>&nbsp;</td></tr>
		   <tr><td colspan='12'>&nbsp;</td>";
           $tc=0;

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

        if ($price<0){$price='';};//else{$price=number_format($price,2,',',' ');};
        if ($total<0){$total='';}else{$total=number_format($total,2,',',' ');};

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
        //if ($dl_price!=''){$dl_price=number_format($dl_price,2,',',' ');};
        if ($dl_total!=''){$dl_total=number_format($dl_total,2,',',' ');};
        //if ($doh!=''){$doh=sprintf("%.4f",$doh);};

        echo "<tr>
         <td class='".$class."'>"; if ($type == 'NeKonkurent'){ echo "Неконкурентный";} else { echo "Конкурентный";}  ; echo " </td>
         <td class='".$class."'>".number_format($volume,0,',',' ')."</td>
         <td class='".$class."'>".$ord_profit."</td>
		 <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".$date." ".$time."</td>
         <td class='".$class."'>".$dl_volume."</td>
         <td class='".$class."'>".$dl_price."</td>
         <td class='".$class."'>".$dl_total."</td>
         <td class='".$class."'>".number_format(($ord_profit), 2, ',', ' ')."</td>
         <td class='".$class."'>&nbsp;</td>";
		 
        if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0){
          if ($tot==$id && $dl_volume!=''){
            $radtype='checked';
          }
          else{
            $radtype='unchecked';
          }
					//echo $id.'---'.$v.'--'.$issue_vnc.'--'.$st;
					//ограничения по точке отсечения
        if ($id<=($v-$issue_vnc) && $st<2) {
          $dis='';
          //$fun="onmousedown=selid('".$id."')";
        }
        else{
          $dis='disabled';
          $fun='';
        }
				//echo 'dis='.$dis;
        echo "
         <td class='".$class."' align='right' id='".$id."' onclick=test('".$id."') > ";
//         onmousedown='".$reid=$id."'
//		  if (($type == 'Konkurent')){
//        if (($tp=='Конкурентный')){
          if (($tp=='Konkurent')){
          echo "
          <input type='radio' ".$dis." ".$radtype." name='Radio' value='111' id='rad".$id."'/>&nbsp;";
        }
        echo "
         </td> ";


        echo "
         </tr>";

    }
    }
    //}
       }
     echo "
     <tr><td class='info'><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume_nc, 0, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info'>&nbsp;</td>
	 <td class='info' align='right'>&nbsp;</td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_volume_nc, 0, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_total_nc, 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info'>&nbsp;</td>";
     if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0){
       echo "<td class='info'>&nbsp;</td>";
     }
     echo "
     </tr>
     <tr><td class='info' colspan='12'>&nbsp;</td></tr>
     <tr><td class='info'><b>Всего:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
	 <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_total, 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_volume, 0, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info' align='right'><b>".number_format($grand_dl_total, 2, ',', ' ')."</b></td>
     <td class='info'>&nbsp;</td>
     <td class='info'>&nbsp;</td>";

     if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0){
       echo "<td class='info'>&nbsp;</td>";
     }
     echo "
     </tr>";
     $issue_v=$v*70/100;
     $issue_vnc=$v-$issue_v;
     $avg_price=number_format(($grand_dl_total/$grand_dl_volume),2,',',' ');
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
      select distinct t.idfirm from ls.auction_orders t, ts.tradeaccount tt where t.curr_id=".$page." and date0=".MakeLongDate($date1)."
      ) tab";
			
      if ($cnt_us = ora_logon("ls@".SRV,"ls"))
         {
            $cc_us=oci_parse($cnt_us,$cnt_sql_us);
						oci_execute($cc_us);
            if (oci_fetch($cc_us))
            {
               $cnt_users=oci_result($cc_us, 1);
            }
      }

         echo "</table>";
         if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0)
         {
            echo "<br><br>
				  <table border=0>
						<td width='30%'>Кол-во конкурентных заявок рассчитанных МФКР: </td>
						<td><input class='volume-MFKR-input' type='text' size='6' style='text-align:right' name='nVolume_NBKR' value='".$nVolume_NBKR."' id='nVolume_NBKR'></td>				  
					<tr>
						<td width='30%'>Кол-во неконкурентных расчит. НБКР: </td>
						<td><input class='volume-MFKR-input' type='text' size='6' style='text-align:right' name='nVolume_Nocomp_NBKR' value='".$nVolume_Nocomp_NBKR."' id='nVolume_Nocomp_NBKR'></td>
					</tr>
					<tr>
						<td width='30%'>Дходность неконкурентных расчит. НБКР: </td>
						<td><input class='volume-MFKR-input' type='text' size='6' style='text-align:right' name='nProfit' value='".$nProfit."' id='nProfit'></td>
					</tr>	
                  </table><br>
				  <label>
                  <input class='btn control' type='button' id='but' value='Пересчитать предварительные результаты аукциона' onclick=selid(".$page.")>
                  <input type='hidden' id='but1'>
                  </label>
				  ";
         }

         echo "
         <br><br>
         <hr>
         <br>
         <b>Всего: </b>
      <table>
      <tr style='vertical-align: text-top;'>
      <td>
         <table class='table-deals'>
         <tr>
            <td class='info_title'>
               &nbsp;
            </td>
            <td class='info_title'>
               Конкур-е
            </td>
            <td class='info_title'>
               Неконкур-е
            </td>
            <td class='info_title'>
               Всего
            </td>
         </tr>
         <tr>
            <td class='info'>
               <b>Предложение, сом</b>
            </td>
            <td class='info' align='right'>
               ".number_format($issue_v, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($issue_vnc, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($issue_v+$issue_vnc, 0, ',', ' ')."
            </td>
         </tr>
         <tr>
            <td class='info'>
               <b>Спрос, сом</b>
            </td>
            <td class='info' align='right'>
               ".number_format($svol, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($sncvol, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($sncvol+$svol, 0, ',', ' ')."
            </td>
         </tr>
         <tr>
            <td class='info'>
               <b>Удовлетв. спрос, сом</b>
            </td>
            <td class='info' align='right'>
               ".number_format($grand_dl_volume-$grand_dl_volume_nc, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($grand_dl_volume_nc, 0, ',', ' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($grand_dl_volume, 0, ',', ' ')."
            </td>
         </tr>
         </table>
      </td>
      <td>
         <table class='table-deals'>
         <tr>
            <td class='info_title' width='170'>
               &nbsp;
            </td>
            <td class='info_title'>
               Максимальная цена
            </td>
            <td class='info_title'>
               Минимальная цена
            </td>
            <td class='info_title'>
               Средневзвешенная цена
            </td>
         </tr>
         <tr>
            <td class='info'>
               <b>Цены аукциона, сом</b>
            </td>
            <td class='info' align='right'>
               ".$max_price."
            </td>
            <td class='info' align='right'>
               ".$min_price."
            </td>
            <td class='info' align='right'>
               ".$avg_price."
            </td>
         </tr>
         <tr>
            <td class='info'>
               <b>Доходность к погашению, %</b>
            </td>
            <td class='info' align='right'>
               ".$min_doh."
            </td>
            <td class='info' align='right'>
               ".$max_doh."
            </td>
            <td class='info' align='right'>
               ".number_format(round($avg_doh,4),4,',','')."
            </td>
         </tr>
         </table>
      </td>
      </tr>
      <tr>
      <td><strong>Всего участников аукциона: ".$cnt_users."</strong></td>
      </tr>
      </table>
      <br><strong>Уполномоченное лицо: _____________________________________________</strong>
         ";




      if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0)
         {
            echo "<br><br><hr color='rgb(120,195,204)'><table>
            <tr>
               <td>
                  <form method='POST'>
                  <input class='btn' type='submit' value='Подтвердить результаты аукциона'>
                  <input type='hidden' name='agree' value='1'>
                  </form>
               </td>
	    </tr>
	    <tr>
               <td>
                  <form method='POST'>
                  <input class='btn danger' type='submit' value='Отклонить результаты аукциона'>
                  <input type='hidden' name='agree' value='2'>
                  </form>
               </td>
            </tr>
            </table>
            <p>
            ";

         }
echo '<br><br><br>';
}
?>

