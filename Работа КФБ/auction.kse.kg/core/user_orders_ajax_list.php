<?php

$vol_sum=0;
$total_sum=0;

$vol_sum_n=0;
$total_sum_n=0;
$total_sum_lot=0;
$vol_sum_lot=0;
$vol_sum_n_lot=0;

   echo "<table class='table-deals'>
	 <tr>
         <td class='info_top' colspan='9'>
            Приказы на покупку
         </td>
         </tr>

         <tr width='100%' style='min-width:100%'>
         <td class='info_title' width='70'>
            Дата
         </td>
         <td class='info_title' width='70'>
            Время
         </td>
         <td class='info_title' width='100'>
            Инструмент
         </td>
         <td class='info_title' width='70'>
            Счет
         </td>
		 <td class='info_title'>
            Желаемая доходность (%)
         </td>
         <td class='info_title'>
            <nobr>Цена покупки</nobr>
         </td>
         <td class='info_title'>
            Количество
         </td>
         <td class='info_title' width='100'>
            Сумма
         </td>
         <td class='info_title'>
         
         </td>
         </tr>";



  if ($c = ora_logon(OP1,OP2))
  {

   //Comp

    echo "

    <tr>
         <td class='info_comp' colspan='9'>
            <b>Конкурентные</b>
         </td>
         </tr>";
    //$name='';
    $curs = oci_parse($c, "select shortname, to_char(price,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as price, volume, rowidtochar(t.rowid), date0, time0, acc.code, t.status,to_char(price*volume,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as total, t.conf, to_char(profit,'fm999G999G990D00', 'nls_numeric_characters='', ''''') as profit from ls.auction_orders t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc where t.curr_id=curr.id and price<>-1 and t.idfirm=".$_SESSION[PORTAL.'USER']['idfirm']." and date0=".$dt." and acc.id=t.account order by shortname, price desc");
		oci_execute($curs);
    
		/*if (is_resource($curs))
    {
        $namerus= ora_getcolumn($curs, 0);
        $price=ora_getcolumn($curs, 1);
        $volume=ora_getcolumn($curs, 2);
        $id=ora_getcolumn($curs, 3);
        $date=MakeDate(ora_getcolumn($curs, 4));
        $time=MakeTimeFull(ora_getcolumn($curs, 5));
        $code=ora_getcolumn($curs, 6);
        $status=ora_getcolumn($curs, 7);
        $total=ora_getcolumn($curs, 8);
        $name=$namerus;
        $class='info';

        $vol_sum+=$volume;
        $total_sum+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        $vol_sum_lot+=$volume;
        $total_sum_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));

        if ($_SESSION['STATUS']>=3)
        {
           if ($status==1){$class='info_done';}
           if ($status==2){$class='info_error';}
           if ($status==3){$class='info_notfull';}
        }

        if ($_SESSION['STATUS']==0)
        {
           $f="<a href='javascript:confirm_del(\"".WEB_ROOT."?act=del_orders&id=".$id."\");'><img src='./img/delete.gif' alt='del' title='Удалить'></a>";
        }
        else
        {
           $f="&nbsp;";
        }
        echo "
          <tr>
            <td class='info_shortname' colspan='8'>
              Лот: ".$name."
            </td>
          </tr>
        ";
        echo "<tr>
         <td class='".$class."'>".$date."</td>
         <td class='".$class."'>".$time."</td>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>".$code."</td>
         <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".$volume."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".$f."</td>
         </tr>";
*/
		$name='';
    while (oci_fetch($curs)) {

        $namerus= oci_result($curs, 1);
        $price=oci_result($curs, 2);
        $volume=oci_result($curs, 3);
        $id=oci_result($curs, 4);
        $date=MakeDate(oci_result($curs, 5));
        $time=MakeTimeFull(oci_result($curs, 6));
        $code=oci_result($curs, 7);
        $status=oci_result($curs, 8);
        $total=oci_result($curs, 9);
		$conf=oci_result($curs, 10);
		$profit=oci_result($curs, 11);

        $class='info';

        $vol_sum+=$volume;
        $total_sum+=floatval(str_replace(',','.',str_replace(' ','',$total)));
        if (($name!=$namerus) & ($name!='')){
         echo "
          <!--итого по лоту -->
          <tr>
         <td class='info' colspan='6'>
            <b>Итого по лоту:</b>
         </td>
         <td class='info' align='right'>
            <b>".number_format($vol_sum_lot, 0, ',', ' ')."</b>
         </td>
         <td class='info' align='right' colspan='2'>
            <b>".number_format($total_sum_lot, 2, ',', ' ')."</b>
         </td>
         <!-- <td class='info'>&nbsp;</td>
         </tr> -->
         <!--итого по лоту -->
         ";
        $vol_sum_lot=0;
        $total_sum_lot=0;
        }
        $vol_sum_lot+=$volume;
        $total_sum_lot+=floatval(str_replace(',','.',str_replace(' ','',$total)));

        if ($_SESSION['STATUS']>=3)
        {
           if ($status==1){$class='info_done';}
           if ($status==2){$class='info_error';}
           if ($status==3){$class='info_notfull';}
					 if ($conf==2){$class='info_red';}
        }

        if ($_SESSION['CONF']==1)
        {
					 if ($conf==2){$class='info_red';}
        }	
		
		if ($_SESSION['STATUS']==0)
        {
           $f="<a href='javascript:confirm_del(\"".WEB_ROOT."?act=del_orders&id=".$id."\");'><img src='./img/delete.gif' alt='del' title='Удалить'></a>";
        }
        else
        {
           $f="&nbsp;";
        }
        if (($name!=$namerus) ){
        echo "
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$namerus."
            </td>
          </tr>
        ";

        }
        echo "<tr>
         <td class='".$class."'>".$date."</td>
         <td class='".$class."'>".$time."</td>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>".$code."</td>
         <td class='".$class."'>".$profit."</td>
		 <td class='".$class."'>".$price."</td>
         <td class='".$class."'>".number_format($volume, 0 ,',',' ')."</td>
         <td class='".$class."'>".$total."</td>
         <td class='".$class."'>".$f."</td>
         </tr>";
         $name=$namerus;
    }

    //}
    echo "
          <!--итого по лоту -->
          <tr>
         <td class='info' colspan='6'>
            <b>Итого по лоту:</b>
         </td>
         <td class='info'>
            <b>".number_format($vol_sum_lot, 0, ',', ' ')."</b>
         </td>
         <td class='info' colspan=2>
            <b>".number_format($total_sum_lot, 2, ',', ' ')."</b>
         </td>
         <!-- <td class='info'>&nbsp;</td> -->
         </tr>
         <tr>
         <td class='info' colspan='9'>
            &nbsp;
         </td>
         </tr>
         <!--итого по лоту -->
         ";
   //No Comp


    echo "<tr>
         <td class='info' colspan='6'>
            <b>Итого по конкурентным:</b>
         </td>
         <td class='info'>
            <b>".number_format($vol_sum, 0, ',', ' ')."</b>
         </td>
         <td class='info' colspan=2>
            <b>".number_format($total_sum, 2, ',', ' ')."</b>
         </td>
         <!-- <td class='info'>&nbsp;</td> -->
         </tr>
         <tr>
         <td class='info' colspan='9'>
            &nbsp;
         </td>
         </tr>

         <tr>
         <td class='info_comp' colspan='9'>
            <b>Неконкурентные</b>
         </td>
         </tr>";

    $curs = oci_parse($c, "select shortname,price, volume, rowidtochar(t.rowid), date0, time0, acc.code, t.status, t.conf from ls.auction_orders t, ".TS.".ts_currinstrument_arcts curr, ".TS.".tradeaccount acc where t.curr_id=curr.id and price=-1 and t.idfirm=".$_SESSION[PORTAL.'USER']['idfirm']." and date0=".$dt." and acc.id=t.account order by shortname,volume desc");
		oci_execute($curs);
		
    /*if (is_resource($curs))
    {

        $namerus= ora_getcolumn($curs, 0);
        $price=ora_getcolumn($curs, 1);
        $volume=ora_getcolumn($curs, 2);
        $id=ora_getcolumn($curs, 3);
        $date=MakeDate(ora_getcolumn($curs, 4));
        $time=MakeTimeFull(ora_getcolumn($curs, 5));
        $code=ora_getcolumn($curs, 6);
        $status=ora_getcolumn($curs, 7);
        $name=$namerus;
        $class='info';


        $vol_sum_n+=$volume;
        $vol_sum_n_lot+=$volume;

        if ($_SESSION['STATUS']>=3)
        {
           if ($status==1){$class='info_done';}
           if ($status==2){$class='info_error';}
           if ($status==3){$class='info_notfull';}
        }

        if ($_SESSION['STATUS']==0)
        {
           $f="<a href='javascript:confirm_del(\"".WEB_ROOT."?act=del_orders&id=".$id."\");'><img src='./img/delete.gif' alt='del' title='Удалить'></a>";
        }
        else
        {
           $f="&nbsp;";
        }
        echo "
          <tr>
            <td class='info_shortname' colspan='8'>
              Лот: ".$name."
            </td>
          </tr>
        ";
        echo "<tr>
         <td class='".$class."'>".$date."</td>
         <td class='".$class."'>".$time."</td>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>".$code."</td>
         <td class='".$class."' align='right'></td>
         <td class='".$class."' align='right'>".$volume."</td>
         <td class='".$class."' align='right'></td>
         <td class='".$class."'>".$f."</td>
         </tr>";
		*/
		$name='';
    while (oci_fetch($curs)) {

        $namerus= oci_result($curs, 1);
        $price=oci_result($curs, 2);
        $volume=oci_result($curs, 3);
        $id=oci_result($curs, 4);
        $date=MakeDate(oci_result($curs, 5));
        $time=MakeTimeFull(oci_result($curs, 6));
        $code=oci_result($curs, 7);
        $status=oci_result($curs, 8);
        $conf=oci_result($curs, 9);
				
        $class='info';
        if (($name!=$namerus) & ($name!='')){
          echo "
            <tr>
              <td class='info' colspan='5'>
                <b>Итого по лоту:</b>
              </td>
              <td class='info' align='right'>
                <b>".number_format($vol_sum_n_lot, 0, ',', ' ')."</b>
              </td>
              <td class='info' colspan='2'>&nbsp;</td>
            </tr>
          ";
        $vol_sum_n_lot=0;
        }
        $vol_sum_n+=$volume;
        $vol_sum_n_lot+=$volume;
        if ($_SESSION['STATUS']>=3)
        {
           if ($status==1){$class='info_done';}
           if ($status==2){$class='info_error';}
           if ($status==3){$class='info_notfull';}
        }
        if ($_SESSION['CONF']==1)
        {
					 if ($conf==2){$class='info_red';}
        }				
				

        if ($_SESSION['STATUS']==0)
        {
           $f="<a href='javascript:confirm_del(\"".WEB_ROOT."?act=del_orders&id=".$id."\");'><img src='./img/delete.gif' alt='del' title='Удалить'></a>";
        }
        else
        {
           $f="&nbsp;";
        }
        if ($name!=$namerus){
        echo "
          <tr>
            <td class='info_shortname' colspan='9'>
              Лот: ".$namerus."
            </td>
          </tr>
        ";
        }
        echo "<tr>
         <td class='".$class."'>".$date."</td>
         <td class='".$class."'>".$time."</td>
         <td class='".$class."'>".$namerus."</td>
         <td class='".$class."'>".$code."</td>
         <td class='".$class."' align='right'></td>
		 <td class='".$class."' align='right'></td>
         <td class='".$class."' align='right'>".$volume."</td>
         <td class='".$class."' align='right'>".number_format($volume * NamCost, 0, ',', ' ')."</td>
         <td class='".$class."'>".$f."</td>
         </tr>";
        $name=$namerus;
    }
    //}
    echo "
      <tr>
        <td class='info' colspan='6'>
          <b>Итого по лоту:</b>
        </td>
        <td class='info'>
          <b>".number_format($vol_sum_n_lot, 0, ',', ' ')."</b>
        </td>
        <td class='info' colspan='2'>
        <b>".number_format($vol_sum_n_lot*NamCost, 0, ',', ' ')."</b>
        </td>
      </tr>
      <td class='info' colspan='9'>
            &nbsp;
         </td>
      </tr>
    ";
    echo "
         <tr>
         <td class='info' colspan='6'>
            <b>Итого по неконкурентным:</b>
         </td>
         <td class='info'>
            <b>".number_format($vol_sum_n, 0, ',', ' ')."</b>
         </td>
         <td class='info' colspan='2'><b>".number_format($vol_sum_n*NamCost, 0, ',', ' ')."</b></td>
         </tr>
         <tr>
         <td class='info' colspan='9'>
            &nbsp;
         </td>
         </tr>
         <tr>
         <td class='info' colspan='6'>
            <b>Всего:</b>
         </td>
         <td class='info'>
            <b>".number_format(($vol_sum+$vol_sum_n), 0, ',', ' ')."</b>
         </td>
         <td class='info' colspan='2'>
            <b>".number_format($total_sum + ($vol_sum_n*NamCost), 2, ',', ' ')."</b>
         </td>
         <!-- <td class='info'>&nbsp;</td> -->
         </tr>
         ";

    ora_logoff($c);
  } else
  {
     echo "Oracle Connect Error " . ora_error();
  }
  echo '</table>';

?>
