<?php
define("HOST","192.168.0.38");
define("USER","kseuser");
define("PASS","kseuserpass");
define("DB","kse");
$link = mysql_connect(HOST,USER,PASS) or die (mysql_error());  
       
        mysql_select_db(DB, $link);

echo'<html>
  
   <body bgcolor="#000000" scroll="no"><center>
<table width="100%" border=0 bgcolor=black>
<tr align=center><td>
<font color="#00FF00"><h1>Аукцион ГКВ (показатель за год)</h1></font>
</td></tr>
<tr align=center><td>
      <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase=http://www.kse.kg/swflash.cab#version=6,0,0,0" width="900" height="650" id="Line" >
         <param name="movie" value="../lib/FusionCharts/Charts/FCF_MSLine.swf" />
         <param name="FlashVars" value="&dataURL=./data_for_chart/gkv_graf.xml&chartWidth=900&chartHeight=650">
         <param name="quality" value="high" />
         <embed src="../lib/FusionCharts/Charts/FCF_MSLine.swf" flashVars="&dataURL=./data_for_chart/gkv_graf.xml&chartWidth=900&chartHeight=650" chartcanvasbackground="ffffff" quality="high" width="900" height="650" name="Line" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>
      </object>
</td></tr>
</table>
</center>
</body>
</html>';


?>