<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

   $date=date('d/m/Y');
   $date0=MakeLongDate($date);


         $status=$_SESSION['STATUS'];
			$mf=$_SESSION['MF'];
			$conf=$_SESSION['CONF'];
         
         switch ($status)
         {
            case '-1': // Online
            {
               $icon="<img align='absmiddle' src='./img/gray.jpg'> Аукцион не начался";
               break;
            }
            case '0': // Online
            {
               $icon="<img align='absmiddle' src='./img/green.jpg'> Идет прием приказов";
               break;
            }
            case '1': // Estimate
            {
               if ($_SESSION[PORTAL.'USER']['admin']==1)
               {
                  if ($conf==0)
									{
										$icon="<img align='absmiddle' src='./img/red.jpg'> Подведение предварительных итогов<br> <font size='1'>(Ожидание подтверждения конфирмерами)</font>";
									}
									else
									{
										if ($mf==0)
										{
											$icon="<img align='absmiddle' src='./img/red.jpg'> Подведение предварительных итогов<br> <font size='1'>(Не подтверждено МинФином)</font>";
										}
										elseif ($mf==1)
										{
											$icon="<div style='background:#ccffcc;'><img align='absmiddle' src='./img/lamp.gif'> Подведение предварительных итогов <br> <font color='green'>(ПОДТВЕРЖДЕНО МинФином!)</font></div>";
										}
										else
										{
											$icon="<div style='background:#ffcccc;'><img align='absmiddle' src='./img/lamp.gif'> Подведение предварительных итогов <br> <font color='red'>(ОТКЛОНЕНО МинФином!)</font></div>";
										}
									}
               }
               else
               {
                  $icon="<img align='absmiddle' src='./img/red.jpg'> Подведение предварительных итогов";
               }
               break;
            }
            case '2': // Pause
            {
               $icon="<img align='absmiddle' src='./img/yellow.jpg'> Прием приказов приостановлен";
               break;
            }
            case '3': // Depo
            {
               $icon="<img align='absmiddle' src='./img/blue.jpg'> Итоги аукциона";
               break;
            }
            case '4': // Bank
            {
               $icon="<img align='absmiddle' src='./img/blue.jpg'> Итоги аукциона";
               break;
            }
            case '5': // End
            {
               $icon="<img align='absmiddle' src='./img/gray.jpg'> Аукцион завершен";
               break;
            }
            default: $icon='';
         }

   if (isset($_GET['numeric']))
   {
      echo $status;
   }
   else
      echo $icon;

?>

