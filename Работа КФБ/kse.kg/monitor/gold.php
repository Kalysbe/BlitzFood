<?php
define("HOST","localhost");
define("USER","kseuser");
define("PASS","kseuserpass");
define("DB","kse");
$link = mysql_connect(HOST,USER,PASS) or die (mysql_error());  
       
        mysql_select_db(DB, $link);
  $sql_date = "SELECT DATE_FORMAT(MAX(`cr_date`),'%d.%m.%Y') AS cr_date FROM `Blog_Entries_eng`";
       
$sql_gold = "SELECT * FROM `Blog_Entries_eng` where name='gold' ORDER BY cr_date DESC LIMIT 1";
$sql_light = "SELECT * FROM `Blog_Entries_eng` where name='light' ORDER BY cr_date DESC LIMIT 1";
$sql_brent = "SELECT * FROM `Blog_Entries_eng` where name='brent' ORDER BY cr_date DESC LIMIT 1";
$result_gold = mysql_query($sql_gold) or die(mysql_error() ."<br/>". $sql_gold);
$result_date = mysql_query($sql_date) or die(mysql_error() ."<br/>". $sql_date);
$result_light = mysql_query($sql_light) or die(mysql_error() ."<br/>". $sql_light);
$result_brent = mysql_query($sql_brent) or die(mysql_error() ."<br/>". $sql_brent);

echo " 
<link href='style.css' type='text/css' rel='stylesheet'> 
<body scroll='no'>
 <br>
<br><br><br><br><br><br>
<table class='t_gold'>
<tr>
<td align='left'><font color=##00FF00; size='6';>Товарные рынки</font></td>
</tr>
<tr>
<td></td>
		<td class='bid_ask'>BID</td>
		<td class='bid_ask'>ASK</td>
</tr>";
while ($row = mysql_fetch_assoc($result_date)) 
echo "

<td align='left'><font color='##00FF00'size='5'>Данные на: ".$row['cr_date']."</font></td>";
while ($row = mysql_fetch_assoc($result_gold))
echo "
     <tr>
	 <td class='t_left'><img src=\"../views/kse/images/gold.jpg\" width=\"80px\"/>&nbsp;Золото</td>
     <td class='t_right'>".$row['bid']."</td>
     <td class='t_right'>".$row['ask']."</td>
     </tr>";
while ($row = mysql_fetch_assoc($result_light))
echo "
     <tr>
	 <td class='t_left'><img src=\"../views/kse/images/light.jpg\" width=\"80px\" />&nbsp;Нефть Light</td>
     <td class='t_right'>".$row['bid']."</td>
     <td class='t_right'>".$row['ask']."</td>
     </tr>";
while ($row = mysql_fetch_assoc($result_brent))
echo "
     <tr>
	 <td class='t_left'><img src=\"../views/kse/images/oil.jpg\" width=\"80px\" />&nbsp;Нефть Brent</td>
     <td class='t_right'>".$row['bid']."</td>
     <td class='t_right'>".$row['ask']."</td>
     </tr>";

echo "</table>";