<?php

$mWidth=1820;
$mHeigh=850;
$fXmlData='dyn_trade_type_inst.xml';
$strTitle='Объем торгов в разрезе видов ценных бумаг 2010-10 мес 2015 г.г.';
$typeGraph='FCF_Doughnut2D.swf';
#$typeGraph='FCF_Pie2D.swf';

header('Content-Type: text/html; charset=utf-8');
echo'<html>

<body bgcolor="#000000" scroll="no"><center>
<table width="100%" height=100% border=0 bgcolor="000000">
<tr height=20% align=center><td>
<font color="#ffffff"><h1>'.$strTitle.'</h1></font>
</td></tr>
<tr align=center><td>
      <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase=http://www.kse.kg/swflash.cab#version=6,0,0,0" width="'.$mWidth.'" height="'.$mHeigh.'" id="Column3D" >
         <param name="movie" value="http://www.kse.kg/lib/FusionCharts/Charts/'.$typeGraph.'" />
         <param name="FlashVars" value="&dataURL=./data_for_chart/'.$fXmlData.'&chartWidth='.$mWidth.'&chartHeight='.$mHeigh.'">
         <param name="quality" value="high" />
         <embed src="http://www.kse.kg/lib/FusionCharts/Charts/'.$typeGraph.'" flashVars="&dataURL=http://www.kse.kg/monitor/for_ub/data_for_chart/'.$fXmlData.'&chartWidth='.$mWidth.'&chartHeight='.$mHeigh.'" chartcanvasbackground="ffffff" quality="high" width="'.$mWidth.'" height="'.$mHeigh.'" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>
      </object>
</td></tr>
</table>
</center>
</body>
</html>';

?>