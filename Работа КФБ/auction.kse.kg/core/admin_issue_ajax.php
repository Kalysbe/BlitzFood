<?php

if (!defined('WEB_ROOT')){die('Oops...');}

$option="<select name='currinstrument'>";

  if ($c = ora_logon(OP1,OP2))
  {
	$stmt = oci_parse($c, "select curr.shortname, curr.id from ".TS.".market m, ".TS.".sector s, ".TS.".subsector ss, ".TS.".currinstrument curr where m.sect_id=s.ownid and s.ssecsid=ss.ownid and ss.inst_id=curr.ownid and m.mcode='T'
							order by curr.shortname"); 
	oci_execute($stmt);

    while (oci_fetch($stmt)) {
        $namerus= oci_result($stmt, 1);
        $id=oci_result($stmt, 2);
        $option.= "<option value='".$id."'>".$namerus."</option>";
    }
    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error "; //. trigger_error(htmlentities(oci_error(['message'])), E_USER_ERROR);
  }

$option.="</select>";

$out="<form method='POST' class='modal-add-auction'>
   <br>
   <table border=0>
   <tr><td style='padding: 3px;'>Инструмент:</td><td>".$option."</td>   </tr>
   <!-- <tr><td style='padding: 3px;'>Номинал:</td><td><input name='price' value='100' align='right' onkeypress='event.returnValue=checkfloat();'></td>   </tr> -->
   <tr><td style='padding: 3px;'>Дата расчета:</td><td><input name='settlement_date' align='right' value='".date('d.m.Y')."'  required pattern='(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d' onkeypress='event.returnValue=checkfloat();'></td>   </tr>
   <tr><td style='padding: 3px;'>Дата погашения:</td><td><input name='repayment_date' align='right' value='".date('d.m.Y')."' required pattern='(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d' onkeypress='event.returnValue=checkfloat();'></td>   </tr>
   <tr><td style='padding: 3px;'>Объем эмиссии:</td><td><input name='volume' align='right' value='' required onkeypress='event.returnValue=checkint();'></td>   </tr>
   <tr><td style='padding: 3px;'>Из них неконкурентных (%):</td><td><input name='volume_nocomp' align='right' value='30'  maxlength='3' onkeypress='event.returnValue=checkint();'></td></tr>
   <tr><td colspan='2' align='right'></td></tr>
   <tr><td colspan='2' align='right'>
   <button class='btn success' type='submit'><svg xmlns='http://www.w3.org/2000/svg' height='24' width='24'><path d='m9.55 18-5.7-5.7 1.425-1.425L9.55 15.15l9.175-9.175L20.15 7.4Z'/></svg>Добавить</button>
   <button class='btn danger' onclick='close_porting();'>
   <svg xmlns='http://www.w3.org/2000/svg' height='24' width='24'>
          <path d='M6.4 19 5 17.6l5.6-5.6L5 6.4 6.4 5l5.6 5.6L17.6 5 19 6.4 13.4 12l5.6 5.6-1.4 1.4-5.6-5.6Z'/>
    </svg>
   Отмена
   </button>
   </td></tr>
   <tr><td colspan='2' align='right'><input type='hidden' name='act' value='add_issue'></td></tr>
   </table>
   </form>";

echo "<div class=\"window_caption\"><table width=\"100%\"><tr><td align=middle><b>Добавить инструмент на аукцион</b></td><td align=\"right\"><span class=\"panel_item\" onclick=\"close_porting();\"><b style='color:red;'>X</b></span></td></tr></table></div>".$out;

?>

