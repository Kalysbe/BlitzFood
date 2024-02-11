<?php

if (!defined('WEB_ROOT')){die ('Oops...');}


$date1=$_SESSION['date1'];
$firm=$_SESSION['firm'];
$nocomp=$_SESSION['nocomp'];
$r=intval($_GET['r']);
if ($r==0){exit;};

      $nc=array('0'=>'Все','1'=>'Конкурентные','2'=>'Неконкурентные');

      $nocomps="<select name='nocomp'>";

      for ($i=0;$i<sizeof($nc);$i++)
      {
         $sel='';
         if ($i==$nocomp){$sel=' selected ';};
         $nocomps.="<option value='".$i."'".$sel.">".$nc[$i]."</option>";
      }

      $nocomps.="</select>";
      $nc_f="<tr><td>Показать:</td><td>".$nocomps."</td></tr>";
      echo "<br>
      <table>
        <tr>
          <td>
           Дата:</td><td><input value='".$date1."' readonly size='10' name='txtDate'><input type='button' value='...' onclick='displayCalendar(document.all.txtDate,\"dd/mm/yyyy\",this)'>
          </td>
        </tr>
      <tr>
        <td>".$nc_f."</td>
        <td>
         <input class='btn' type='submit' value='    Ok     '><input type='hidden' name='rep' value='".$r."'>
        </td>
      </tr>
      </table>
      <br>";
?>

