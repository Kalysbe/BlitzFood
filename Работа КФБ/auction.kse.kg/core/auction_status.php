<?php

if (!defined('WEB_ROOT')){die ('Oops...');}
   $timezone = "Asia/Bishkek";
   if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
   $date=date('d/m/Y');
   $date0=MakeLongDate($date);
   $status=-1;
   $type='';

   if ($c = ora_logon(OP1,OP2))
   {
      $curs = oci_parse($c, 'select * from ls.auction_options where date0='.$date0);
      oci_execute($curs);
      if (oci_fetch($curs))
      {
         $status=oci_result($curs, 4);
         $type=oci_result($curs, 6);
         $mf=oci_result($curs, 7);
	 $conf=oci_result($curs, 8);
      }
      ora_logoff($c);
   };

   $_SESSION['STATUS']=$status;
   $_SESSION['TYPE']=$type;
   $_SESSION['MF']=$mf;
   $_SESSION['CONF']=$conf;
   
?>
