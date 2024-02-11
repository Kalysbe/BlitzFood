<?php
define("HOST","localhost");
define("USER","kseuser");
define("PASS","kseuserpass");
define("DB","kse");
#require_once("config.inc.php");
$link = mysql_connect(HOST,USER,PASS) or die (mysql_error());  
       
        mysql_select_db(DB, $link);
         
$sql_3 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `gkv_3` where type='1'";
$sql_6 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `gkv_3` where type='2'";
$sql_12 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `gkv_3` where type='3'";

$result_1 = mysql_query($sql_3) or die(mysql_error() ."<br/>". $sql_3);
$result_2 = mysql_query($sql_6) or die(mysql_error() ."<br/>". $sql_6);
$result_3 = mysql_query($sql_12) or die(mysql_error() ."<br/>". $sql_12);

echo " 
<link href='style.css' type='text/css' rel='stylesheet'> 
<body scroll='no'>
<table class='t_nbkr'>
<h3>Аукционы ГКВ</h3>
<tr>
<th class='th_nbkr_2'>Тип ГКВ</th>
<th class='th_nbkr_2'>Дата</th>
<th class='th_nbkr_2'>Объем спроса<br>(тыс.сом)</th>
<th class='th_nbkr_2'>Объем предложения<br>(тыс.сом)</th>
<th class='th_nbkr_2'>Min.<br>доходность<br>%</th>
<th class='th_nbkr_2'>Max.<br>доходность<br>%</th>
<th class='th_nbkr_2'>Средневзвешенная<br>доходность<br>%</th>
</tr>";
while ($row = mysql_fetch_assoc($result_1))

echo "
     <tr>
	 <td class='td_nbkr_2'>3-мес</td>
     <td class='td_nbkr_2'>".$row['date']."</td>
     <td class='td_nbkr_2'>".$row['ask']."</td>
	 <td class='td_nbkr_2'>".$row['bid']."</td>
	 <td class='td_nbkr_2'>".$row['min_percent']."</td>
	 <td class='td_nbkr_2'>".$row['max_percent']."</td>
	 <td class='td_nbkr_2'>".$row['average']."</td>
     </tr>";
while ($row = mysql_fetch_assoc($result_2))
echo "
     <tr>
	 <td class='td_nbkr_2'>6-мес</td>
     <td class='td_nbkr_2'>".$row['date']."</td>
     <td class='td_nbkr_2'>".$row['ask']."</td>
	 <td class='td_nbkr_2'>".$row['bid']."</td>
	 <td class='td_nbkr_2'>".$row['min_percent']."</td>
	 <td class='td_nbkr_2'>".$row['max_percent']."</td>
	 <td class='td_nbkr_2'>".$row['average']."</td>
     </tr>";

while ($row = mysql_fetch_assoc($result_3))
echo "
     <tr>
	 <td class='td_nbkr_2'>12-мес</td>
     <td class='td_nbkr_2'>".$row['date']."</td>
     <td class='td_nbkr_2'>".$row['ask']."</td>
	 <td class='td_nbkr_2'>".$row['bid']."</td>
	 <td class='td_nbkr_2'>".$row['min_percent']."</td>
	 <td class='td_nbkr_2'>".$row['max_percent']."</td>
	 <td class='td_nbkr_2'>".$row['average']."</td>
     </tr>";

echo "</table>";