<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

include ('./core/user_menu.php');


if ($go='database')
{
   switch ($page)
   {
      case 2:
      {
         if ($_SESSION[PORTAL.'USER']['admin']==0)
         {
            include ('./core/content.php');

         }
         break;
      }
      case 3:
      {
         include ('./core/user_reports.php');
         break;
      }
      default: {include ('./core/about.php');}
   }
}

echo '<br><br><br>';

?>