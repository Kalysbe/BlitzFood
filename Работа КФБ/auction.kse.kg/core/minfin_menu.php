<?php
if (!defined('WEB_ROOT')){die('Oops!');}
//echo "<a href='index.php'>test</a>";
$i=0;
$date1=date('d/m/Y');
$menu['database']="Лот";
$f1='';
$f2='';
if ($c = ora_logon(OP1,OP2)){

 //$curs = @ora_do($c,"select c.extcode,t.curr_id from ls.auction_issue t,".TS.".ts_currinstrument_arcts c where  date0=".MakeLongDate($date1)." and c.id=t.curr_id order by c.extcode");
 $curs = oci_parse($c,"select * from (
                                   select 
									c.extcode,
									t.curr_id,
									t.mf as mfi,
                                    (select mf from ls.auction_options o where date0=".MakeLongDate($date1).") as mfo,
									c.shortname
                                   from ls.auction_issue t,".TS.".ts_currinstrument_arcts c
                                   where date0=".MakeLongDate($date1)." and c.id=t.curr_id order by c.extcode) t
                        where mfi=0 or mfo<>0");
	oci_execute($curs);
  /*if (is_resource($curs)){
    $i++;
    $ext = ora_getcolumn($curs, 0);
    $id = ora_getcolumn($curs, 1);
    $mf= ora_getcolumn($curs, 2);
    if ($mf==2){
      $f1="<font color='red'>";
      $f2="</font>";
    }
    else{
      $f1='';
      $f2='';
    }
    $submenu['database'][$id]="<img src='./img/list.gif' align='absmiddle'>".$f1.$ext.$f2."";
    //$page=$ext;
	*/	
    while (oci_fetch($curs)){
      $i++;
      $ext = oci_result($curs, 1);
      $id = oci_result($curs, 2);
      $mf= oci_result($curs, 3);
	  $shortname = oci_result($curs, 5);
      if ($mf==2){
        $f1="<font color='red'>";
        $f2="</font>";
      }
      else{
        $f1='';
        $f2='';
      }
	  $submenu['database'][$id]="<img src='./img/list.gif' align='absmiddle'> ".$f1.$shortname.$f2."";
      //$submenu['database'][$id]="<img src='./img/list.gif' align='absmiddle'> ".$f1.$ext.$f2."";
    }
  //}
}

/*if ($_SESSION[PORTAL.'USER']['admin']==2)
{


   $submenu['database'][2]="Аукцион";
}

$submenu['database'][3]="<img src='./img/report.gif' align='absmiddle'> ".$date1."";*/


if (!defined('WEB_ROOT')){die('Oops!');}

$go='database';
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
      echo("<span class='act_menu_item_user'><a href='".WEB_ROOT."?minfin&go=".$key."'>".$item."</a></span>&nbsp;");
   }
   else
      echo("<span class='menu_item_user'><a href='".WEB_ROOT."?minfin&go=".$key."'>".$item."</a></span>&nbsp;");
}

function print_submenu($item,$key)
{
   global $go,$page;
   $item='<nobr>'.$item.'</nobr>';
   if ($page==$key){
      echo("<span class='act_submenu_item_user'><a href='".WEB_ROOT."?minfin&go=".$go."&page=".$key."'>".$item."</a></span> ");
   }
   else{
      echo("<span class='submenu_item_user'><a href='".WEB_ROOT."?minfin&go=".$go."&page=".$key."'>".$item."</a></span> ");
   }
}

//menu
//echo "<div class='menu_user'><table width='100%' ><tr><td width='50%' align='left'>";
//echo "<div class='menu_user'><table width='100%' ><tr><td width='50%' align='left'>";
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
<br>
