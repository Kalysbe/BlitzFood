<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

if (isset($_GET['id']))
{
   $id=safe(trim($_GET['id']));
}

$dt=MakeLongDate(date('d/m/Y'));
switch ($act)
{
  case 'conf_true_orders':
  {
    $sql="update ls.auction_orders set conf=1 where idfirm=".$id." and date0=".$dt; 
		echo 'sql='.$sql;
    if ($c = ora_logon("ls@".SRV,"ls"))
    {
			$stmt=oci_parse($c,$sql);
			oci_execute($stmt);
		}	
		echo "Удаление. Подождите немного...<script>document.location='".WEB_ROOT."'</script>";
		break;
    exit();
	}
	case 'conf_false_orders':
  {
    $sql="update ls.auction_orders set conf=2 where idfirm=".$id." and date0=".$dt; 
		echo 'sql='.$sql;
    if ($c = ora_logon("ls@".SRV,"ls"))
    {
			$stmt=oci_parse($c,$sql);
			oci_execute($stmt);
		};
		echo "Удаление. Подождите немного...<script>document.location='".WEB_ROOT."'</script>";		
		break;
    exit();
	}	
}

include ('./core/confirmer_menu.php');

//echo "<br><center><table width='100%'>
//         <tr>
//         <td class='info_top'>
//            <div align='center' style='padding:4px;background:#ffffff;'>
//               <div style='color:#000000;' name='a_status' id='a_status'></div>
//            </div>
//         </td>
//         </tr></table></center><br>";

$dt=MakeLongDate(date('d/m/Y'));
  echo $_SESSION['STATUS'];

  if (($_SESSION['STATUS']<1) || $_SESSION['STATUS']>1 || $_SESSION['CONF']==1)
	{
			echo "Этап предварительных расчетов еще не наступил...<br>Зайдите пожалуйста в установленное регламентом время.";
      exit();
	};

	echo '<br><table class="table-deals">
	<td class="info_top" colspan="4" align="left">
            <span>Приказы на покупку</span>
         </td>';
	echo '<tr>
			<td class="info_title" align="right">
            	<nobr>Компания</nobr>
			</td>
			<td class="info_title" align="right">
            	<nobr>Заявок на сумму (сом)</nobr>
			</td>
			<td class="info_title" align="right">
            	<nobr>Сумма 10% от заявок (сом)</nobr>
			</td>
			<td class="info_title">
            	<nobr>Признак участие</nobr>
			</td>
			<td class="info_title" align="right">
            	<nobr>Принять</nobr>
			</td>
			<td class="info_title" align="right">
            	<nobr>Отклонить</nobr>
			</td>
		  </tr>';
	
	/*if (($_SESSION['STATUS']>0) || ($_SESSION['CONF']==0))
  {
    $t="<a href='javascript:conf_true_ord(\"".WEB_ROOT."?act=conf_true_orders&id=".$id_firm."\");'><img src='./img/deleted.gif' alt='del' title='Подтвердить'></a>";		
		$f="<a href='javascript:conf_false_ord(\"".WEB_ROOT."?act=conf_false_orders&id=".$id_firm."\");'><img src='./img/delete.gif' alt='del' title='Отклонить'></a>";		
  }
  else
  {
	  $f="&nbsp;";
    $t="&nbsp;";		
  }
*/
	if ($c = @ora_logon(OP1,OP2))
  {
    $sql_query='select o.idfirm, n.nick ,sum(case when o.price=-1 then 100*o.volume else o.price*o.volume  end) vol,
		case when sum(o.conf)=0 or mod(sum(o.conf),count(*))<>0 then 0	  -- начальное состояние
     when sum(o.conf)/count(*) =1  then 1															-- подтвержденные
     else 2 end conf  																								-- отвергнутые подтверждателем
		from ls.AUCTION_ORDERS o, '.TS.'.firm n  where n.id=o.idfirm and o.idfirm in
			(select f.id from '.TS.'.firm f where f.idorgan='.$_SESSION[PORTAL.'USER']['idfirm'].') and date0='.$dt.' 
		group by o.idfirm, n.nick
		order by o.idfirm, n.nick';
		
		//echo $sql_query;
		$stmt = oci_parse($c, $sql_query);
		oci_execute($stmt);
		
    while(oci_fetch($stmt))
		{
		  $id_firm=oci_result($stmt, 1);
          $name_firm=oci_result($stmt, 2);
		  $total_vol_firm=oci_result($stmt, 3);
		  $conf_firm=oci_result($stmt, 4);  /* 2-отвергнутые, 1-подтвержденные, 0-не обработаные	*/
		  if(strpos($name_firm,'BANK') !== false) {
			$firm_priznak = 'Банковский';
	   	  }else{
			$firm_priznak='Небанковский';
		  };
			
			$row_color="info";
			if ($conf_firm==1)
			{
				$f="&nbsp;";
				$t="&nbsp;";		
				$row_color="info_green";
			}
			else if ($conf_firm==2)
			{
				$f="&nbsp;";
				$t="&nbsp;";		
				$row_color="info_red";
			}
			else
			{
				if (($_SESSION['STATUS']>0) || ($_SESSION['CONF']==0) )
				{
					$t="<a href='javascript:conf_true_ord(\"".WEB_ROOT."?act=conf_true_orders&id=".$id_firm."\");'><img src='./img/deleted.gif' alt='del' title='Подтвердить'></a>";		
					$f="<a href='javascript:conf_false_ord(\"".WEB_ROOT."?act=conf_false_orders&id=".$id_firm."\");'><img src='./img/delete.gif' alt='del' title='Отклонить'></a>";		
				}
				else
				{
					$f="&nbsp;";
					$t="&nbsp;";		
				}
			}
			
			echo '<tr>  
			            <td class="'.$row_color.'">'.$name_firm.'</td>
					    <td class="'.$row_color.'" align="right">'.number_format($total_vol_firm,2,',',' ').'</td>
						<td class="'.$row_color.'" align="right">'.number_format(($total_vol_firm*10)/100,2,',',' ').'</td>
						<td class="'.$row_color.'">'.$firm_priznak.'</td>
						<td class="'.$row_color.'" align="right">'.$t.'</td>
						<td class="'.$row_color.'" align="right">'.$f.'</td>
					</tr>';
    }
	}
	echo '</table>'
?>
