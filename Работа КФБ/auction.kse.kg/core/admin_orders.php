<?php

if (!defined('WEB_ROOT')){die ('Oops...');}

   include ('./core/auction_options.php');

$dt=MakeLongDate(date('d/m/Y'));

   echo "<table width='600px'>
         <tr>
         <td class='info_top'>
            <div align='center' style='padding:4px;background:#ffffff;'>
               <div style='color:#000000;' name='a_status' id='a_status'></div>
            </div>
         </td>
         </tr></table><div id='ord_list' name='ord_list'></div>";
   

?>

