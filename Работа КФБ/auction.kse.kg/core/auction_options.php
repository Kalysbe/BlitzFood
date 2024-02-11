<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

   $date=date('d/m/Y');
   $date0=MakeLongDate($date);

   $bh='09';
   $bm='00';

   $eh='12';
   $em='00';

   $form='';
   $enable='';

   $aid='';

   $type='';
   
   $simple_sel = "";
   $gko5_sel = "";
//---------------------------------------------
if($_SESSION['TYPE'] == 'ls.auction_NBKR_GKV' ){
      $simple_sel = "selected='selected'";
   }
   else {
      $gko5_sel = "selected='selected'";
   }
//---------------------------------------------   
if (isset($_POST['bh']))
{
   $bh=intval($_POST['bh']);
}

if (isset($_POST['type']))
{
   $type=safe($_POST['type']);
}

if (isset($_POST['bm']))
{
   $bm=intval($_POST['bm']);
}

if (isset($_POST['eh']))
{
   $eh=intval($_POST['eh']);
}

if (isset($_POST['em']))
{
   $em=intval($_POST['em']);
}

if (isset($_GET['endauction']))
{
   $endauction=safe($_GET['endauction']);
   $sql="update ls.auction_options set status=5 where id='".$endauction."'";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
		$stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }
   echo "Завершение аукциона. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
   exit();
}

if (isset($_GET['auctionestimate']))
{
   $auctionestimate=safe($_GET['auctionestimate']);

   $sql="begin ".$_SESSION['TYPE']."; end;";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   $sql="update ls.auction_options set status=1 where id='".$auctionestimate."'";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }
   echo "Подготовка предварительных расчетов. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
   exit();
}

if (isset($_GET['auctionconfirmergo']))
{
   $auctionconfirmergo=safe($_GET['auctionconfirmergo']);

   $sql="update ls.auction_orders set conf=2 where conf=0 and date0=".$date0;
	 echo 'hhh-'.$sql;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

	 $sql="update ls.auction_options set conf=1 where id='".$auctionconfirmergo."'";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }
	 
	 $sql="update ls.auction_orders set status=0 where date0=".$date0;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }
	 
   $sql="delete from ls.auction_deals where status=0 and date0=".$date0;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   $sql="begin ".$_SESSION['TYPE']."; end;";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   echo "Пересчет предварительных расчетов. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
   exit();
}

if (isset($_GET['auctionreestimate']))
{
   $auctionreestimate=safe($_GET['auctionreestimate']);

   $sql="update ls.auction_orders set status=0 where date0=".$date0;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   $sql="delete from ls.auction_deals where status=0 and date0=".$date0;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   $sql="begin ".$_SESSION['TYPE']."; end;";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
		$stmt = oci_parse($c, $sql); 
		$res=oci_execute($stmt);
   }

   echo "Пересчет предварительных расчетов. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
   exit();
}

if (isset($_GET['cleanauction']))
{
   $cleanauction=safe($_GET['cleanauction']);

   $sql="delete from ls.auction_orders where date0=".$date0;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   $sql="delete from ls.auction_deals where date0=".$date0;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   $sql="delete from ls.auction_options where id='".$cleanauction."'";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   echo "Очистка аукциона. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
   exit();
}

if (isset($_GET['auctionestimatego']))
{

   //$f=file_get_contents('http://192.168.0.26/auction/?act=move_auction_deals_stop');
   //sleep(3);

   $auctionestimatego=safe($_GET['auctionestimatego']);
   $sql="update ls.auction_options set status=3 where id='".$auctionestimatego."'";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
    $stmt = oci_parse($c, $sql); 
	  oci_execute($stmt);
   }

   /*$sql="begin ".TS.".auction_move_deals(".$date0."); end;";
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
      ora_do($c,$sql);
   }

   $sql="update ls.auction_deals set status=1 where status=0 and date0=".$date0;
   if ($c = ora_logon("ls@".SRV,"ls"))
   {
      ora_do($c,$sql);
   }*/

   echo "Подготовка к расчетам. Подождите немного...";
   //$f=file_get_contents('http://192.168.0.26/auction/?act=move_auction_deals_start');
   //sleep(3);

   echo "<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";

   exit();
}
//echo('$act='.$act);
switch ($act)
{
   case 'start':
   {
      $bt=MakeLongTime($bh.':'.$bm.':00');
      $et=MakeLongTime($eh.':'.$em.':00');
      $sql="insert into ls.auction_options (date0,begin_time,end_time,status,id, type) values (".
         $date0.",".$bt.",".$et.",0,'".md5(time())."','".$type."')";
      if ($c = ora_logon("ls@".SRV,"ls"))
      {
				$stmt = oci_parse($c, $sql); 
				oci_execute($stmt);
      }
      echo "Старт аукциона. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
      exit();
   }
   case 'pause_on':
   {
      $sql="update ls.auction_options set status=2 where date0=".$date0;
      if ($c = ora_logon("ls@".SRV,"ls"))
      {
        $stmt = oci_parse($c, $sql); 
				oci_execute($stmt);
      }
      echo "Аукцион приостанавливается. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
      exit();
   }
   case 'pause_off':
   {
      $sql="update ls.auction_options set status=0 where date0=".$date0;
      if ($c = ora_logon("ls@".SRV,"ls"))
      {
        $stmt = oci_parse($c, $sql); 
				oci_execute($stmt);
      }
      echo "Старт аукциона. Подождите немного...<script>document.location='".WEB_ROOT."?admin&go=".$go."&page=".$page."'</script>";
      exit();
   }
   case 'estimate_show':
   {
      echo 'Here are estimates!';
      exit();
   }
}


   if ($c = ora_logon(OP1,OP2))
   {
      $stmt = oci_parse($c, 'select * from ls.auction_options where date0='.$date0); 
			oci_execute($stmt);
			if (oci_fetch($stmt)) {
         $bt=oci_result($stmt, 2);
         $et=oci_result($stmt, 3);
         $status=oci_result($stmt, 4);
         $aid=oci_result($stmt, 5);
         $type=oci_result($stmt, 6);
				 $conf=oci_result($stmt, 8);

         list($bh,$bm)=split(':',MakeTime($bt));
         list($eh,$em)=split(':',MakeTime($et));

         //echo $status;

         switch ($status)
         {
            case '0': // Online
            {
             $form="<input type='hidden' name='act' id='act' value='pause_on'>
					<input class='btn control' id='control' name='control' type='submit' value='Приостановить прием приказов'>
					<input class='btn' type='button' value='Предварительные расчеты' onclick='auction_estimate(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionestimate=".$aid."\");'>
					<input type='button' class='btn danger' value='Завершить аукцион' onclick='end_auction(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&endauction=".$aid."\");'>";
               $enable=' disabled ';
               break;
            }
            case '1': // Estimate
            {
               if ($conf==0)
							 {
									$btn_estimate="<button class='btn' onclick='auction_confirmer_go(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionconfirmergo=".$aid."\");'>
                           <svg xmlns='http://www.w3.org/2000/svg' height='24' width='24'>
                              <path d='m9.55 18-5.7-5.7 1.425-1.425L9.55 15.15l9.175-9.175L20.15 7.4Z'/>
                           </svg>
                           Завершить этап конфирмеров
                           </button>";
							 }
							 else
							 {
									$btn_estimate="<button class='btn success' onclick='auction_estimate_go(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionestimatego=".$aid."\");'>
                           <svg xmlns='http://www.w3.org/2000/svg' height='24' width='24'>
                              <path d='m9.55 18-5.7-5.7 1.425-1.425L9.55 15.15l9.175-9.175L20.15 7.4Z'/>
                           </svg>
                           Подтвердить предварительные расчеты
                           </button>";							 
							 };
							 $form="<input type='hidden' name='act' id='act' value='estimate_show'>
											<button class='btn control' onclick='auction_reestimate(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionreestimate=".$aid."\");'>
                                    <svg xmlns='http://www.w3.org/2000/svg' height='24' width='24'>
                                       <path d='M11 20.95q-3.025-.375-5.012-2.638Q4 16.05 4 13q0-1.65.65-3.163Q5.3 8.325 6.5 7.2l1.425 1.425q-.95.85-1.437 1.975Q6 11.725 6 13q0 2.2 1.4 3.887 1.4 1.688 3.6 2.063Zm2 0v-2q2.175-.4 3.587-2.075Q18 15.2 18 13q0-2.5-1.75-4.25T12 7h-.075l1.1 1.1-1.4 1.4-3.5-3.5 3.5-3.5 1.4 1.4-1.1 1.1H12q3.35 0 5.675 2.325Q20 9.65 20 13q0 3.025-1.987 5.288Q16.025 20.55 13 20.95Z'/>
                                    </svg>
                                   Пересчитать
                                 </button>
											".$btn_estimate."
											<button class='btn danger' onclick='clean_auction(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&cleanauction=".$aid."\");'>
                                 <svg xmlns='http://www.w3.org/2000/svg' height='24' width='24'>
                                 <path d='M7 21q-.825 0-1.412-.587Q5 19.825 5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413Q17.825 21 17 21ZM17 6H7v13h10ZM9 17h2V8H9Zm4 0h2V8h-2ZM7 6v13Z'/>
                                 </svg>
                                 Очистить аукцион
                                 </button>";
               $enable=' disabled ';
               break;
            }
            case '2': // Pause
            {
               $form="<input type='hidden' name='act' id='act' value='pause_off'><input class='btn control' id='control' name='control' type='submit' value='Продолжить прием приказов'> <input type='button' class='btn danger' value='Завершить аукцион' onclick='end_auction(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&endauction=".$aid."\");'>";
               $enable=' disabled ';
               break;
            }
            case '3': // Depo
            {
               $form="<input type='button' class='btn danger' value='Очистить аукцион' onclick='clean_auction(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&cleanauction=".$aid."\");'>";
               $enable=' disabled ';
               break;
            }
            case '4': // Bank
            {
               $form="";
               $enable=' disabled ';
               break;
            }
            case '5': // End
            {
               $form="";
               $enable=' disabled ';
               break;
            }
         }
      }
      else
      {
         $form="<input class='btn' type='hidden' name='act' value='start'><input class='btn start-auction' type='submit' value='Начать аукцион'>";
      }

      ora_logoff($c);
   }

   $ords='';

   if ($_SESSION['STATUS']!=1 && $_SESSION['STATUS']<3)
   {
      $ords="<tr><td colspan=2>&nbsp;</td></tr>
         <tr><td colspan=2>Прием приказов:<hr></td></tr>
         <tr class='auction_time'><td>Время начала:</td>
         <td><input ".$enable." type='text' value='".$bh."' name='bh' size='2' maxlength='2' onkeypress='event.returnValue=checkint();'>:<input ".$enable." type='text' value='".$bm."' name='bm'  size='2' maxlength='2' onkeypress='event.returnValue=checkint();'></td></tr>
         <tr class='auction_time'><td>Время завершения:</td>
         <td><input ".$enable." type='text' value='".$eh."' name='eh' size='2' maxlength='2' onkeypress='event.returnValue=checkint();'>:<input ".$enable." type='text' value='".$em."' name='em'  size='2' maxlength='2' onkeypress='event.returnValue=checkint();'></td></tr>
         <tr><td colspan=2><hr></td></tr>";
   };
	

   $tp="<select style='width:200' name='type' ".$enable."><option {$simple_sel} value='ls.auction_NBKR_GKV'>Аукцион НБКР по ГКВ</option>";
   $tp.="<option {$gko5_sel} value='ls.auction_NBKR_GKO5'>Аукцион НБКР по ГКО</option></select>";

   echo "<div><b>Аукцион:</b><br><br>
         <form action='".WEB_ROOT."?admin&go=".$go."&page=".$page."' method='POST' class='setting-block'>
         <table>
         <tr><td>Дата:</td><td>".$date."</td></tr>
         <tr><td>Алгоритм:</td><td>".$tp."</td></tr>
         ".$ords."
         </table><br>
         <input type='hidden' name='auctid' value='".$aid."'>
         ".$form."
         </form>
      </div><div name='update_res' id='update_res' style='display:none;'></div><br><br>";

?>
