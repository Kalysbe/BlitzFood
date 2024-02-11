<?php

   if (!defined('WEB_ROOT')){die ('Oops...');}
//   include ('./core/user_menu.php');
   include ('./core/user_issue.php');
   echo '<br><br><hr>';

   echo "<div name='orders' id='orders' width='100%'>";
   include ('./core/user_orders.php');
   echo "</div><br><div name='deals' id='deals' width='100%'></div><br><hr>
   <input class='btn' type='button' onclick='document.location=document.location' value='Обновить (F5)'>

   ";
//   echo "<input class='btn' type='button' value='Отчеты' onclick=document.location='".WEB_ROOT."core/user_reports_options.php'>";
   //include ('./core/user_deals.php');

?>
