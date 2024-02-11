<?php

if (!defined('WEB_ROOT')){die('Oops!');}


$menu['database']="";

if ($_SESSION[PORTAL.'USER']['admin']==0)
{


   $submenu['database'][2]="Аукцион";
}

$submenu['database'][3]="Отчеты";


if (!defined('WEB_ROOT')){die('Oops!');}

$go='database';
$page=2;
if (isset($_GET['go']))
{
   $go=$_GET['go'];
}
if (isset($_GET['page']))
{
   $page=$_GET['page'];
}

function print_menu($item,$key)
{
   global $go;
   if ($go==$key){
      echo("<span class='act_menu_item_user'><a href='".WEB_ROOT."?user&go=".$key."'>".$item."</a></span>&nbsp;");
   }
   else
      echo("<span class='menu_item_user'><a href='".WEB_ROOT."?user&go=".$key."'>".$item."</a></span>&nbsp;");
}

function print_submenu($item,$key)
{
   global $go,$page;
   $item='<nobr>'.$item.'</nobr>';
   if ($page==$key){
      echo("<span class='act_submenu_item_user'><a href='".WEB_ROOT."?user&go=".$go."&page=".$key."'>".$item."</a></span> ");
   }
   else{
      echo("<span class='submenu_item_user'><a href='".WEB_ROOT."?user&go=".$go."&page=".$key."'>".$item."</a></span> ");
   }
}

//menu
//echo "<div class='menu_user'><table width='100%' ><tr><td width='50%' align='left'>";
//echo "<div class='menu_user'><table width='100%' ><tr><td width='50%' align='left'>";

array_walk($menu,'print_menu');
//echo "</td><td align='right'><span class='menu_item'><a href='".WEB_ROOT."?logout'></a></span></td></tr></table>";
echo "</div>";

//submenu
if (isset($submenu[$go]))
{
   echo "<div class='submenu_user'><table width='100%'><tr><td align='left'>";
   echo "<div class='submenu_user'><table width='100%'><tr>";
   echo "<td align='left'><span class='header'><img src='./img/favicon.png' alt=''><span class='auction-name'>".PORTAL."</span></span></td>";
   echo "<td class='navigation-menu'>";
   array_walk($submenu[$go],'print_submenu');
   echo "</td></tr></table></div>";
}

?>
<br>


