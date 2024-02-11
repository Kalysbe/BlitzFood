<?php

if (!defined('WEB_ROOT')){die('Oops!');}

$menu['database']="База";

if ($_SESSION[PORTAL.'USER']['admin']==1)
{
   $submenu['database'][1]="Лот";
   $submenu['database'][2]="Аукцион";
}

$submenu['database'][3]="Отчеты";


if (!defined('WEB_ROOT')){die('Oops!');}

$go='';
$page='';
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
      echo("<span ><a href='".WEB_ROOT."?admin&go=".$key."'>".$item."</a></span>");
   }
   else
      echo("<span class='menu_item'><a href='".WEB_ROOT."?admin&go=".$key."'>".$item."</a></span>&nbsp;");
}

function print_submenu($item,$key)
{
   global $go,$page;
   $item='<nobr>'.$item.'</nobr>';
   if ($page==$key){
      echo("<span class='act_submenu_item'><a href='".WEB_ROOT."?admin&go=".$go."&page=".$key."'>".$item."</a></span> ");
   }
   else{
      echo("<span class='submenu_item'><a href='".WEB_ROOT."?admin&go=".$go."&page=".$key."'>".$item."</a></span> ");
   }
}

//menu
echo "<div class='menu'><table width='100%'>
<tr>
<td align='left'><span class='header'>
<img src='./img/favicon.png' alt=''><span class='auction-name'>".PORTAL."</span></span>";
echo "</td>
<td class='navigation-menu'>";
    array_walk($menu,'print_menu');
    if (isset($submenu[$go]))
    {
    array_walk($submenu[$go],'print_submenu');
    }
    echo "</td>
<td align='right' style='position:relative;text-align:end;'><span class='menu_item logout'><a href='".WEB_ROOT."?logout'>Выход</a></span></td></tr></table>";
echo "</div>";

//submenu
//if (isset($submenu[$go]))
//{
//   echo "<div class='submenu'><table width='100%'><tr><td align='left'>";
//   array_walk($submenu[$go],'print_submenu');
//   echo "</td><td align='right'></tr></table></div>";
//}

?>
<br>


