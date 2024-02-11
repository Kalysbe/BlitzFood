<?php

if (!defined('WEB_ROOT')){die ('Oops...');}
 include ('./core/new_minfin_menu.php');

if ($go='database')
{
   switch ($page)
   {
      case 1:
      {
         include ('./core/admin_reports.php');
         break;
      }
      default: {include ('./core/about.php');}
   }
}

echo '<br><br><br>';

?>
