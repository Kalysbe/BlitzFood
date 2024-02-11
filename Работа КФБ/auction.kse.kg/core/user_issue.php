<?php

$dt=MakeLongDate(date('d/m/Y'));

   $date=date('d/m/Y');
   $date0=MakeLongDate($date);
   $bt=0;
   $et=0;

if (!defined('WEB_ROOT')){die ('Oops...');}

   echo "<table border='0' class='table-deals'>
         <tr>
         <td class='info_top' colspan='6'>
            Лот
         </td>
         </tr>

         <tr>
			<th class='info_title'>
				Дата
			</th>
			<th class='info_title'>
				Время начала
			</th>
			<td class='info_title'>
				Время окончания
			</td>
			<td class='info_title'>
				Инструмент
			</td>
			<!-- <td class='info_title'>
				<nobr>Номинал</nobr>
			</td> -->
			<td class='info_title'>
				Кол-во конкурентных
			</td>
			<td class='info_title'>
				Кол-во неконкурентных
			</td>
		 </tr>";

  if ($c = ora_logon(OP1,OP2))
  {

    $cursao = oci_parse($c, 'select * from ls.auction_options where date0='.$date0); 
		oci_execute($cursao);

    if (oci_fetch($cursao))
    {
         $bt=oci_result($cursao, 2);
         $et=oci_result($cursao, 3);
         $astatus=oci_result($cursao, 4);
         $aid=oci_result($cursao, 5);
         $atype=oci_result($cursao, 6);

         list($bh,$bm)=split(':',MakeTime($bt));
         list($eh,$em)=split(':',MakeTime($et));
    }

    $curs = oci_parse($c, "select shortname, to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price, volume, rowidtochar(t.rowid), volume_nocomp from ls.auction_issue t, ".TS.".ts_currinstrument_arcts curr where t.curr_id=curr.id and t.date0=".$dt." order by shortname");
		oci_execute($curs);
    /*if (is_resource($curs))
    {

        $namerus= ora_getcolumn($curs, 0);
        $price=ora_getcolumn($curs, 1);
        $volume=ora_getcolumn($curs, 2);
        $id=ora_getcolumn($curs, 3);
        $volume_nocomp=ora_getcolumn($curs, 4);

        echo "<tr>
         <td class='info'>
            ".$date."
         </td>
         <td class='info'>
            ".MakeTime($bt)."
         </td>
         <td class='info'>
            ".MakeTime($et)."
         </td>
         <td class='info'>".$namerus."</td>
         <td class='info'>".$price."</td>
         <td class='info'>".$volume."</td>
         <td class='info'>".$volume_nocomp."</td>
         </tr>";
		*/
    while (oci_fetch($curs)) {

        $namerus= oci_result($curs, 1);
        $price=oci_result($curs, 2);
        $volume=oci_result($curs, 3);
        $id=oci_result($curs, 4);
        $volume_nocomp=oci_result($curs, 5);

        echo "
		<tr>
			<td   class='info'>
				".$date."
			</td>
			<td class='info'>
				".MakeTime($bt)."
			</td>
			<td class='info'>
				".MakeTime($et)."
			</td>
			<td class='info'><a href='javascript:show_issue_prop(\"".$namerus."\")'>".$namerus."</a></td>
			<!-- <td class='info'>".$price."</td> -->
			<td class='info'>".$volume."</td>
			<td class='info'>".$volume_nocomp."</td>
         </tr>";
    }
    //}
    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error " . ora_error();
  }

  echo  "</table>";


?>
