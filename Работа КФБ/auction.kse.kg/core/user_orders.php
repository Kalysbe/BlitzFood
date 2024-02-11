<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

$curr='';
$price='';
$volume='';
$id='';
$comp=0;
$account=0;
$code='';
$tvol=0;
$pred=0;

$dt=MakeLongDate(date('d/m/Y'));

if (isset($_POST['currinstrument']))
{
	 $curr=intval($_POST['currinstrument']);
}

if (isset($_POST['account']))
{
   $account=intval($_POST['account']);
}

if (isset($_POST['price']))
{
   $price=floatval($_POST['price']);
}

if (isset($_POST['profit']))
{
   $profit=floatval($_POST['profit']);
}

if (isset($_POST['volume']))
{
   $volume=intval($_POST['volume']);
}

if (isset($_POST['comp']))
{
   $comp=intval($_POST['comp']);
}

if (isset($_GET['id']))
{
   $id=safe(trim($_GET['id']));
}


//количество сделок
$cnt_sql="select sum(count(*)) from ls.auction_orders t, ".TS.".tradeaccount tt where date0=".$dt." and userid=".$_SESSION[PORTAL.'USER']['id']." and t.price!=-1 and t.account=tt.id and tt.code like '%3001%' and curr_id=".$curr." group by t.price";

if ($cnt = ora_logon("ls@".SRV,"ls"))
         {
            $cc_orders=oci_parse($cnt,$cnt_sql);
						oci_execute($cc_orders);

            if(oci_fetch($cc_orders))
            {
               $cnt_orders= oci_result($cc_orders, 1);
            }
}

switch ($act)
{
   case 'add_orders':
   {
      if ($_SESSION['STATUS']==0)
      {

         $sql="select volume, pred from ls.auction_issue where curr_id=".$curr." and date0=".$dt;


         if ($c = ora_logon("ls@".SRV,"ls"))
         {
            $cc=oci_parse($c,$sql);
						oci_execute($cc);
            if (oci_fetch($cc))
            {
               $tvol= oci_result($cc, 1);
               $pred= oci_result($cc, 2);
            }

            //Проверяем на количество конкурентных сделок
            //echo $cnt_orders;
            if ($cnt_orders==5 and $comp!=1){die("Собственный приказ Участника торгов в конкурентной части должен содержать не больше 5 приказов! <a href='javascript:history.back();'>Вернуться</a>");} ;

            //if ($price>=100){die("Неверная цена приказа! <a href='javascript:history.back();'>Вернуться</a>");}
            if ($volume>$pred){die("Объем приказа не может быть больше объема лота! <a href='javascript:history.back();'>Вернуться</a>");}
            if ($volume<100 and $comp!=1){die("Минимальное количество ГКВ по каждому конкурентному приказу долно быть не менее 100 ГКВ! <a href='javascript:history.back();'>Вернуться</a>");}
			if ($profit<=0 and $comp!=1){die("Необходимо указать желаемую доходность! <a href='javascript:history.back();'>Вернуться</a>");}
            if ($volume<1 and $comp==1){die("Минимальное количество ГКВ по каждому неконкурентному приказу долно быть не менее 1 ГКВ! <a href='javascript:history.back();'>Вернуться</a>");}
            if ($comp==1)
            {
               $price='-1';
            }
            $tm=MakeLongTime(date('H:i:s'));
			$profit=$profit+0.00;
            $sql="insert into ls.auction_orders (curr_id, price, volume, idfirm, date0, time0, account, status, userid, profit) values (".
               $curr.",".$price.",".$volume.",".$_SESSION[PORTAL.'USER']['idfirm'].",".$dt.",".$tm.",".$account.",0,".$_SESSION[PORTAL.'USER']['id'].",".$profit.")";

            $stmt=oci_parse($c,$sql);
						oci_execute($stmt);
         }
         echo "Добавление. Подождите немного...<script>document.location='".WEB_ROOT."'</script>";
      }
      else
      {
         die ("Прием приказов в настоящее время невозможен. Попробуйте позже. <a href='javascript:history.back();'>Вернуться</a>");
      }
      break;
      exit();
   }
   case 'del_orders':
   {
      if ($_SESSION['STATUS']==0)
      {
         $sql="delete from ls.auction_orders where rowid = chartorowid('".$id."')";
         if ($c = ora_logon("ls@".SRV,"ls"))
         {
            $stmt=oci_parse($c,$sql);
						oci_execute($stmt);
         }
         echo "Удаление. Подождите немного...<script>document.location='".WEB_ROOT."'</script>";
      }
      else
      {
         die ("Удаление приказов в настоящее время невозможно. Попробуйте позже. <a href='javascript:history.back();'>Вернуться</a>");
      }
      break;
      exit();
   }
};
//include ('./core/user_menu.php');
   echo "<table>
         <tr>
         <td class='info_top' colspan='8'>
            <div align='center' style='padding:4px;background:#ffffff;'>
               <div style='color:#000000;' name='a_status' id='a_status'></div>
            </div>
         </td>
         </tr>";
//         include ('./core/user_menu.php');
         include ('./core/user_orders_ajax_list.php');
//         include ('./core/user_menu.php');
     $f="<input class='btn control' type='button' name='add_order_btn' id='add_order_btn' style='visibility:hidden' value='Ввести приказ' onclick='add_order();'>";

  echo  "</table>
  <br>".$f."<br>
  <div class='porting_alert' id='porting_alert' align='center'><div class='porting' id='porting'></div></div>
  <div name='user_orders' id='user_orders'></div>";


?>
