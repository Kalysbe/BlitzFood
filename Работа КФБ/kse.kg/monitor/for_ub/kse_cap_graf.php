<?php

$mWidth=1820;
$mHeigh=950;
$fXmlData='kse_cap_graf.xml';
$strTitle='Капитализация КФБ (ноябрь 2014 - ноябрь 2015)';
$typeGraph='FCF_Area2D.swf ';
$bodycolor='#000000';

echo '<html>
  
<body bgcolor="'.$bodycolor.'" scroll="no"><center>
<table width="100%" border=0 bgcolor='.$bodycolor.'>
<tr align=center><td>
<font color="#ffffff"><h1>'.$strTitle.'</h1></font>
</td></tr>
<tr align=center><td>
      <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase=http://www.kse.kg/swflash.cab#version=6,0,0,0" width="'.$mWidth.'" height="'.$mHeigh.'" id="Line" >
         <param name="movie" value="http://www.kse.kg/lib/FusionCharts/Charts/'.$typeGraph.'" />
         <param name="FlashVars" value="&dataURL=http://www.kse.kg/monitor/for_ub/data_for_chart/'.$fXmlData.'&chartWidth='.$mWidth.'&chartHeight='.$mHeigh.'">
         <param name="quality" value="high" />
         <embed src="http://www.kse.kg/lib/FusionCharts/Charts/'.$typeGraph.'" flashVars="&dataURL=http://www.kse.kg/monitor/for_ub/data_for_chart/'.$fXmlData.'&chartWidth='.$mWidth.'&chartHeight='.$mHeigh.'" chartcanvasbackground="ffffff" quality="high" width="'.$mWidth.'" height="'.$mHeigh.'" name="Line" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>
      </object>
</td></tr>
</table>
</center>
</body>
</html>';

?>