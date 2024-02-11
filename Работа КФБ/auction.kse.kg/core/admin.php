<?php

if (!defined('WEB_ROOT')){die ('Oops...');}
 include ('./core/admin_menu.php');

if ($go='database')
{
   switch ($page)
   {
      case 1:
      {
         if ($_SESSION[PORTAL.'USER']['admin']==1)
         {
            include ('./core/admin_issue.php');
         }
         break;
      }
      case 2:
      {
         if ($_SESSION[PORTAL.'USER']['admin']==1)
         {
            include ('./core/admin_orders.php');
            include ('./core/admin_deals.php');
         }
         break;
      }
      case 3:
      {
         include ('./core/admin_reports.php');
         break;
      }
      case 4:
      {
         include ('./core/minfin.php');
         break;
      }
      default: {include ('./core/about.php');}
   }
}

echo '<br><br><br>';

?>
