<?php
define("HOST","localhost");
define("USER","kseuser");
define("PASS","kseuserpass");
define("DB","kse");
#require_once("config.inc.php");
$link = mysql_connect(HOST,USER,PASS) or die (mysql_error());  
       
        mysql_select_db(DB, $link);
         
$sql_3 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `gkv_3` where type='1' LIMIT 1";
$sql_6 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `gkv_3` where type='2' LIMIT 1";
$sql_12 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `gkv_3` where type='3' LIMIT 1";

$result_1 = mysql_query($sql_3) or die(mysql_error() ."<br/>". $sql_3);
$result_2 = mysql_query($sql_6) or die(mysql_error() ."<br/>". $sql_6);
$result_3 = mysql_query($sql_12) or die(mysql_error() ."<br/>". $sql_12);

echo " 
<link href='style.css' type='text/css' rel='stylesheet'> 
<body>
<table border=0 align=center valign=absmiddle width=100% height=50% style= text-align:center; font-size:30px; color:#ffff00;>
<h3 align='center'><font color='#00FF00' size='5'face='verdana'>Аукцион ГКВ</h3>
<tr>
<th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Тип ГКВ</th></tr>
<tr>
<th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Дата</th></tr>
<tr>
<th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Спрос (тыс.сом)</th></tr>
<tr>
<th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Продажа (тыс.сом)</th></tr>
<tr>
<th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Min доходность<br> по поданным заявкам</th></tr>
<tr>
<th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Max доходность<br>по поданным заявкам</th></tr>
<tr>
<th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Средневзвешенная доходность<br>по удовлетворенным заявкам</th>
</tr>";
while ($row = mysql_fetch_assoc($result_1))

echo "
     <tr>
	 <th width='10%' align='center'><font color='#00FF00' size='4' face='verdana' >Тип ГКВ</th>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>3-х мес.</td></tr>
	 <tr>
     <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['date']."</td></tr>
	 <tr>
     <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['ask']."</td></tr>
	 <tr>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['bid']."</td></tr>
	 <tr>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['min_percent']."</td></tr>
	 <tr>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['max_percent']."</td></tr>
	 <tr>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['average']."</td>
     </tr>";
while ($row = mysql_fetch_assoc($result_2))
echo "
     <tr>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>6-ти мес.</td>
     <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['date']."</td>
     <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['ask']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['bid']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['min_percent']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['max_percent']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['average']."</td>
     </tr>";

while ($row = mysql_fetch_assoc($result_3))
echo "
     <tr>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>12-ти мес.</td>
     <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['date']."</td>
     <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['ask']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['bid']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['min_percent']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['max_percent']."</td>
	 <td width='10%'align='center'><font face='verdana' style='font-size:25px;font-weight:bold;' color='#8B8B00'>".$row['average']."</td>
     </tr>";

echo "</table>";