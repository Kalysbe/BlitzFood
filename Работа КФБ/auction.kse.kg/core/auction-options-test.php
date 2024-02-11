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
echo('$act='.$act);
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
					<input class='btn control' type='button' value='Предварительные расчеты' onclick='auction_estimate(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionestimate=".$aid."\");'>
					<input class='btn danger' type='button' value='Завершить аукцион' onclick='end_auction(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&endauction=".$aid."\");'>";
               $enable=' disabled ';
               break;
            }
            case '1': // Estimate
            {
               if ($conf==0)
							 {
									$btn_estimate="<input class='btn' type='button' value='Завершить этап конфирмеров' onclick='auction_confirmer_go(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionconfirmergo=".$aid."\");'>";
							 }
							 else
							 {
									$btn_estimate="<input class='btn success' type='button' value='Подтвердить предварительные расчеты' onclick='auction_estimate_go(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionestimatego=".$aid."\");'>";							 
							 };
							 $form="<input type='hidden' name='act' id='act' value='estimate_show'>
											<input class='btn control' type='button' value='Пересчитать' onclick='auction_reestimate(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&auctionreestimate=".$aid."\");'> 
											".$btn_estimate."
											<input class='btn danger' type='button' class='danger' value='Очистить аукцион' onclick='clean_auction(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&cleanauction=".$aid."\");'>";
               $enable=' disabled ';
               break;
            }
            case '2': // Pause
            {
               $form="<input type='hidden' name='act' id='act' value='pause_off'><input id='control' name='control' type='submit' value='Продолжить прием приказов'> <input type='button' class='danger' value='Завершить аукцион' onclick='end_auction(\"".WEB_ROOT."?admin&go=".$go."&page=".$page."&endauction=".$aid."\");'>";
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
         $form="<input type='hidden' name='act' value='start'><input class='btn' type='submit' value='Начать аукцион'>";
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
