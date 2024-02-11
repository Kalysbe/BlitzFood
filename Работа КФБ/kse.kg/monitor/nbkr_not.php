<?php
define("HOST","localhost");
define("USER","kseuser");
define("PASS","kseuserpass");
define("DB","kse");
#require_once("config.inc.php");
$link = mysql_connect(HOST,USER,PASS) or die (mysql_error());  
       
        mysql_select_db(DB, $link);

$sql_4 = "SELECT * FROM nbkr_not where type='4' ORDER BY date DESC LIMIT 1";
#$sql_4 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `nbkr_not` where type='4'";
#$sql_5 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `nbkr_not` where type='5'";
$sql_5 = "SELECT * FROM nbkr_not where type='5' ORDER BY date DESC LIMIT 1";
#$sql_5 = "SELECT DATE_FORMAT(MAX(`date`),'%d-%m-%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `nbkr_not` where type='5'";
$sql_3 = "SELECT * FROM nbkr_not where type='3' ORDER BY date DESC LIMIT 1";
#$sql_3 = "SELECT DATE_FORMAT(MAX(`date`),'%d.%m.%Y') AS `date`,`ask`,`bid`,`min_percent`,`max_percent`,`average` FROM `nbkr_not` where type='3'";

$result_4 = mysql_query($sql_4) or die(mysql_error() ."<br/>". $sql_4);
$result_5 = mysql_query($sql_5) or die(mysql_error() ."<br/>". $sql_5);
$result_3 = mysql_query($sql_3) or die(mysql_error() ."<br/>". $sql_3);
echo " 
<link href='style.css' type='text/css' rel='stylesheet'> 
<body scroll='no'>
<table class='t_nbkr'>
<tr>
<th class='th_nbkr'>Ноты</th>
<th class='th_nbkr'>Дата</th>
<th class='th_nbkr'>Объем спроса<br>(тыс.сом)</th>
<th class='th_nbkr'>Объем предложения<br>(тыс.сом)</th>
<th class='th_nbkr'>Min.<br>доходность<br>%</th>
<th class='th_nbkr'>Max.<br>доходность<br>%</th>
<th class='th_nbkr'>Средневзвешенная<br>доходность<br>%</th>
</tr>";


while ($row = mysql_fetch_assoc($result_4))

echo "
     <tr>
	 <td class='td_nbkr'>7-дн</td>
	 <td class='td_nbkr_2'>".$row['date']."</td>
     <td class='td_nbkr'>".$row['ask']."</td>
	 <td class='td_nbkr'>".$row['bid']."</td>
	 <td class='td_nbkr'>".$row['min_percent']."</td>
	 <td class='td_nbkr'>".$row['max_percent']."</td>
	 <td class='td_nbkr'>".$row['average']."</td>
     </tr>";
while ($row = mysql_fetch_assoc($result_5))
echo "
<h3>Аукционы Нот</h3>
     <tr>
	 <td class='td_nbkr'>14-дн</td>
	 <td class='td_nbkr_2'>".$row['date']."</td>
     <td class='td_nbkr'>".$row['ask']."</td>
	 <td class='td_nbkr'>".$row['bid']."</td>
	 <td class='td_nbkr'>".$row['min_percent']."</td>
	 <td class='td_nbkr'>".$row['max_percent']."</td>
	 <td class='td_nbkr'>".$row['average']."</td>
     </tr>";

while ($row = mysql_fetch_assoc($result_3))
echo "
     <tr>
	 <td class='td_nbkr'>28-дн</td>
	 <td class='td_nbkr_2'>".$row['date']."</td>
     <td class='td_nbkr'>".$row['ask']."</td>
	 <td class='td_nbkr'>".$row['bid']."</td>
	 <td class='td_nbkr'>".$row['min_percent']."</td>
	 <td class='td_nbkr'>".$row['max_percent']."</td>
	 <td class='td_nbkr'>".$row['average']."</td>
     </tr>";

echo "</table>";