<?php

$menu['database']="";
$submenu['database'][2]="<img src='./img/list.gif' align='absmiddle'> Аукцион";

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

echo "<div class='menu'><table width='100%'><tr>
<td align='left'><span class='header'>
<img src='./img/favicon.png' alt=''><span class='auction-name'>".PORTAL."</span></span>";
echo "</td>
<td align='center' class='navigation-menu'>";
array_walk($menu,'print_menu');
echo "</td><td align='right' style='text-align:end;'><span class='menu_item logout'><a href='".WEB_ROOT."?logout'>Выход</a></span></td></tr></table>";
echo "</div>";

//submenu
if (isset($submenu[$go]))
{
   //echo "<div class='submenu_user'><table width='100%'><tr><td align='left'>";
   echo "<div class='submenu_user'><table width='100%'><tr><td align='left'>";
   array_walk($submenu[$go],'print_submenu');
   //echo "</td><td align='right'><span class='header'>".PORTAL."</span></tr></table></div>";
}
?>
