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
$reps[3]='Сводная ведомость';

if ($_SESSION[PORTAL.'USER']['admin']==1)
{
   $reps[1]='Приказы на покупку';
   $reps[2]='Сделки';
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
<form method='POST'><div name='report_options' id='report_options' class='panel'><br><br></div></form>
<script>report_options(".$rp.");</script>";
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
         if ($_SESSION[PORTAL.'USER']['admin']!=1){die ('Нет прав!');}
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
               $f.=' and price<>-1 ';
            }
            else
            {
               $f.=' and price=-1 ';
            }

               $curs5 = oci_parse($c, "select shortname, to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, volume, rowidtochar(t.rowid) as id, f.nick, t.status,acc.code
                 from ls.auction_orders t, ".TS.".ts_currinstrument_arcts curr, ".TS.".firm f, ".TS.".tradeaccount acc
                 where t.curr_id=curr.id and date0=".MakeLongDate($date1)." and t.idfirm=f.id and acc.id=t.account ".$f." order by price desc, time0");
								oci_execute($curs5);

   echo "<table>
         <tr>
         <td colspan='2' align='left'>
            <span class='print_caption'>Приказы на покупку</span>
         </td>
         <td colspan='3' align='right'>
            <span class='panel_item' onclick='print_version();'>Версия для печати</span>
            <span class='print_panel_item' onclick='normal_version();'>&#8592; Вернуться</span>
         </td>
         </tr>
         <tr>
         <td class='info_title' width='200'>
            Инструмент
         </td>
         <td class='info_title' width='70' align='right'>
            Цена
         </td>
         <td class='info_title' width='70' align='right'>
            Количество
         </td>
         <td class='info_title' width='70' align='right'>
            Счет
         </td>
         <td class='info_title'  align='right' width='150'>
            Выставлено
         </td></tr>";

    /*if (is_resource($curs5))
    {

        $namerus= ora_getcolumn($curs5, 0);
        $price=str_replace('-1,00','-',ora_getcolumn($curs5, 1));
        $volume=ora_getcolumn($curs5, 2);
        $id=ora_getcolumn($curs5, 3);
        $firm1=ora_getcolumn($curs5, 4);
        $status=ora_getcolumn($curs5, 5);
        $account=ora_getcolumn($curs5, 6);

        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        echo "<tr>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".$volume."</td>
         <td class='".$class."' align='right'>".$account."</td>
         <td class='".$class."' align='right'><nobr>".$firm1."</nobr></td>
         </tr>";
		*/
    while (oci_fetch($curs5)) {

        $namerus= oci_result($curs5, 1);
        $price=str_replace('-1,00','-',oci_result($curs5, 2));
        $volume=oci_result($curs5, 3);
        $id=oci_result($curs5, 4);
        $firm1=oci_result($curs5, 5);
        $status=oci_result($curs5, 6);
        $account=oci_result($curs5, 7);

        $class='info';

        if ($status==1){$class='info_done';}
        if ($status==2){$class='info_error';}
        if ($status==3){$class='info_notfull';}

        echo "<tr>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".$volume."</td>
         <td class='".$class."' align='right'>".$account."</td>
         <td class='".$class."' align='right'><nobr>".$firm1."</nobr></td>
         </tr>";
    }
    //}
         }
         echo "</table>";
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

              $curs6 = oci_parse($c, "select shortname,to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price1, volume, date0, time0, acc.code, f.nick, to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total, t.notfull from ls.auction_deals t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc, ".TS.".firm f where t.curr_id=curr.id and t.idfirm=f.id and date0=".MakeLongDate($date1)." and acc.id=t.account ".$f." order by price desc");
							oci_execute($curs6);

   echo "<table>
         <tr>
         <td colspan='4' align='left'>
            <span class='print_caption'>Сделки</span>
         </td>
         <td colspan='4' align='right'>
            <span class='panel_item' onclick='print_version();'>Версия для печати</span>
            <span class='print_panel_item' onclick='normal_version();'>&#8592; Вернуться</span>
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
         <td class='info_title' width='150' align='right'>
            Сумма
         </td>
         <td class='info_title' width='150' align='right'>
            Покупатель
         </td></tr>";

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
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".$volume."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."' align='right'>".$firm."</td>
         </tr>";
		*/
    while (oci_fetch($curs6)) {

        $shortname=oci_result($curs6, 1);
        $price=oci_result($curs6, 2);
        $volume=oci_result($curs6, 3);
        $date0=MakeDate(oci_result($curs6, 4));
        $time0=MakeTime(oci_result($curs6, 5));
        $account=oci_result($curs6, 6);
        $firm=oci_result($curs6, 7);
        $total=oci_result($curs6, 8);
        $status=oci_result($curs6, 9);

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
         <td class='".$class."' align='right'>".$price."</td>
         <td class='".$class."' align='right'>".$volume."</td>
         <td class='".$class."' align='right'>".$total."</td>
         <td class='".$class."' align='right'>".$firm."</td>
         </tr>";
    }
    //}
         }

     echo "<tr><td class='info' colspan=5><b>Итого:</b></td><td class='info' align='right'><b>".$grand_volume."</b></td><td class='info' align='right'><b>".number_format($grand_total, 2, ',', ' ')."</b></td><td class='info'>&nbsp;</td></tr>";

         echo "</table>";
         break;
      }

      case 3: {
         $st=0;
         $tp='Конкурентный';
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
where t.curr_id=c.id and date0=".MakeLongDate($date1)."
order by t.price desc");*/
                 $curs7 = oci_parse($c, "select ls.auction_make_comp(t.price) as comp, t.volume, t.price,
   t.volume*t.price as total,
   (select ts.makedate(date0) from ls.auction_deals d where d.order_id=t.rowid) as dl_date,
   (select ts.maketime(time0) from ls.auction_deals d where d.order_id=t.rowid) as dl_time,
   (select d.volume from ls.auction_deals d where d.order_id=t.rowid) as dl_volume,
   (select d.price from ls.auction_deals d where d.order_id=t.rowid) as dl_price,
   (select (d.volume*round(d.price,2)) from ls.auction_deals d where d.order_id=t.rowid) as dl_total,
   (select ((100-round(d.price,2))/round(d.price,2))*(360/ts.maket(c.shortname))*100 from ls.auction_deals d where d.order_id=t.rowid) as dl_doh,c.shortname,t.status
from ls.auction_orders t, ".TS.".currinstrument c
where t.curr_id=c.id and date0=".MakeLongDate($date1)."
order by t.price desc");
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

   echo "
        <table>
         <tr>
         <td colspan='10' align='left'>
         <span class='print_caption'>
         <div width='100%' align='center'>
            Ведомость предварительных результатов аукциона по размещению ГКВ
         </div> <br>
         </span>
         </td>
         </tr>
         <tr>
         <td colspan='8' align='left'>
         <b>
            Дата размещения: <u>".$date1."</u><br>
            ГКВ: <u>".$extcode."</u><br>
         </b>
         </td>
         <td colspan='2' align='right' valign='bottom'>
            <span class='panel_item' onclick='print_version();'>Версия для печати</span>
            <span class='print_panel_item' onclick='normal_version();'>&#8592; Вернуться</span>
         </td>
         </tr>
         <tr>
         <td class='info_title' width='90'>
            Тип приказа
         </td>
         <td class='info_title' width='100'>
            Объем приказа (шт.)
         </td>
         <td class='info_title' width='50'>
            Цена приказа (сом)
         </td>
         <td class='info_title' width='120'>
            Сумма приказа (сом)
         </td>
         <td class='info_title' width='170'>
            Дата/время сделки
         </td>
         <td class='info_title' width='100'>
            Объем сделки (шт.)
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

        $id=$id+$volume;
        if ($id>($v-$issue_vnc)){
        $id=$v-$issue_vnc;
        $st=$st+1;
        }

        if ($type!=$tp){$tc=1;$tp=$type;$tnc=1;}
        if ($tc==1)
        {
           echo "<tr><td class='info'><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td>
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
           echo "
           </tr><tr><td class='info' colspan='11'>&nbsp;</td></tr>";
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

        if ($price<0){$price='';}else{$price=number_format($price,2,',',' ');};
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
         <td class='".$class."' align='right'>&nbsp;</td>";
        if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0){
          if ($tot==$id && $dl_volume!=''){
            $radtype='checked';
          }
          else{
            $radtype='unchecked';
          }
        if ($id<=($v-$issue_vnc) && $st<2) {
          $dis='';
          $fun="onmousedown=selid('".$id."')";
        }
        else{
          $dis='disabled';
          $fun='';
        }
        echo "
         <td class='".$class."' align='right' id='".$id."' onclick=test('".$id."') >";
//         onmousedown='".$reid=$id."'
        if (($tp=='Конкурентный')){
          echo "
           <input type='radio' ".$dis." ".$radtype." name='Radio' value='111' id='rad".$id."'/>&nbsp;";
           //echo $id;
        }
        echo "
         </td> ";


        echo "
         </tr>";

    }
    }
    //     }
       }
     echo "
     <tr><td class='info'><b>Итого:</b></td><td class='info' align='right'><b>".number_format($grand_volume_nc, 0, ',', ' ')."</b></td>
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
     <tr><td class='info' colspan='11'>&nbsp;</td></tr>
     <tr><td class='info'><b>Всего:</b></td><td class='info' align='right'><b>".number_format($grand_volume, 0, ',', ' ')."</b></td>
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
               $cnt_users=oci_result($cc_us, 1);
            }
      }


         echo "</table>";
               if ($_SESSION[PORTAL.'USER']['admin']==2 && $_SESSION['MF']==0)
         {
            echo "<br><br>
                  <label>
                  <input type='button' id='but' style='color:blue;' value='Пересчитать предварительные результаты аукциона' onclick=selid()>
                  <input type='hidden' id='but1'>
                  </label>";
         }

         echo "
         <br><br>
         <hr>
         <br>
         <b>Всего: </b>
      <table>
      <tr>
      <td>
         <table>
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
      <td width='30px'>
      &nbsp;
      </td>
      <td>
         <table>
         <tr>
            <td class='info_title' width='100'>
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
               ".number_format($max_price,2,',',' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($min_price,2,',',' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($avg_price,2,',',' ')."
            </td>
         </tr>
         <tr>
            <td class='info'>
               <b>Доходность к погашению, %</b>
            </td>
            <td class='info' align='right'>
               ".number_format($min_doh,4,',',' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($max_doh,4,',',' ')."
            </td>
            <td class='info' align='right'>
               ".number_format($avg_doh,4,',',' ')."
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
            echo "<br><br><table>
            <tr>
               <td>
                  <form method='POST'>
                  <input type='submit' style='color:blue;' value='Подтвердить результаты аукциона'>
                  <input type='hidden' name='agree' value='1'>
                  </form>
               </td>
               <td>
                  <form method='POST'>
                  <input type='submit' style='color:red;' value='Отклонить результаты аукциона'>
                  <input type='hidden' name='agree' value='2'>
                  </form>
               </td>
            </tr>
            </table>
            <p>
            ";

         }


         break;
      }

   }
}

?>
