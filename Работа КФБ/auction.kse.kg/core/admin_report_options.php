<?php

if (!defined('WEB_ROOT')){die ('Oops...');}


$date1=$_SESSION['date1'];
$firm=$_SESSION['firm'];
$nocomp=$_SESSION['nocomp'];
$r=intval($_GET['r']);

if ($r==0){exit;};

$firms="<select name='firm'><option value='all'>Все</option>";

      if ($c = ora_logon(OP1,OP2))
      {

		$curs5 = oci_parse($c, "select distinct f.id,f.nick from ".TS.".firm f order by nick");
		oci_execute($curs5);

		while (oci_fetch($curs5)) {
			
         //if (is_resource($curs5))
         //{
         //   $sel='';
         //   $id=ora_getcolumn($curs5, 0);
         //   $nick=ora_getcolumn($curs5, 1);
         //   if ($id==$firm){$sel=' selected ';};
         //   $firms.="<option value='".$id."'".$sel.">".$nick."</option>";

           // while (ora_fetch($curs5)) {
               $sel='';
               $id=oci_result($curs5, 1);
               $nick=oci_result($curs5, 2);
               if ($id==$firm){$sel=' selected ';};
               $firms.="<option value='".$id."'".$sel.">".$nick."</option>";
            }
         //}
      }
      $firms.="</select>";

      $nc=array('0'=>'Все','1'=>'Конкурентные','2'=>'Неконкурентные');

      $nocomps="<select name='nocomp'>";

      for ($i=0;$i<sizeof($nc);$i++)
      {
         $sel='';
         if ($i==$nocomp){$sel=' selected ';};
         $nocomps.="<option value='".$i."'".$sel.">".$nc[$i]."</option>";
      }

      $nocomps.="</select>";

      $frm_f="<tr><td>Фирма:</td><td>".$firms."</td></tr>";
      $nc_f="<tr><td>Показать:</td><td>".$nocomps."</td></tr>";
      if ($r==3){$frm_f='';$nc_f='';};

      echo "<br>
      <table>
      <tr><td>Дата:</td><td><input value='".$date1."' readonly size='10' name='txtDate'><input type='button' value='...' onclick='displayCalendar(document.all.txtDate,\"dd/mm/yyyy\",this)'></td></tr>
      ".$frm_f.$nc_f."
      <tr><td>&nbsp;</td><td><input class='btn' type='submit' value='Ok'><input type='hidden' name='rep' value='".$r."'></td></tr>
      </table>
      <br>";


?>

