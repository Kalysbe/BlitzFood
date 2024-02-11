<?php
define("HOST","localhost");
define("USER","kseuser");
define("PASS","kseuserpass");
define("DB","kse");
$link = mysql_connect(HOST,USER,PASS) or die (mysql_error());  
       
        mysql_select_db(DB, $link);
         
$sql_gold = "SELECT DATE_FORMAT(`cr_date`,'%d.%m.%Y %H:%i') AS `cr_date`,`bid`,`ask` FROM `Blog_Entries_eng` where name='gold' ORDER BY cr_date DESC LIMIT 1";
$sql_light = "SELECT * FROM `Blog_Entries_eng` where name='light' ORDER BY cr_date DESC LIMIT 1";
$sql_brent = "SELECT * FROM `Blog_Entries_eng` where name='brent' ORDER BY cr_date DESC LIMIT 1";
$result_gold = mysql_query($sql_gold) or die(mysql_error() ."<br/>". $sql_gold);
$result_light = mysql_query($sql_light) or die(mysql_error() ."<br/>". $sql_light);
$result_brent = mysql_query($sql_brent) or die(mysql_error() ."<br/>". $sql_brent);

echo " 
<body bgcolor='#000000'>
 <br>
<br><br><br><br><br><br>
<table border=0 align=center width=100% height=50% style= text-align:center; font-size:30px; color:#ffff00;>
<tr>
<td align='left'><font color=##00FF00><h1>Товарные рынки</h1></font></td>
</tr>
<tr bgcolor=''>
<td></td>
		<td><font face='verdana' style='font-size:40px;font-weight:bold;' color='#00FF00' size='300'>BID</font></td>
		<td><font face='verdana' style='font-size:40px;font-weight:bold;' color='#00FF00' size='300'>ASK</font></td>
</tr>";

while ($row = mysql_fetch_assoc($result_gold))
echo "<meta http-equiv='refresh' content='18000; URL=gold.php'>
<td align='left'><font color=##00FF00><h2>Данные на: ".$row['cr_date']."</h2></font></td>
     <tr>
	 <td align='left'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'><img src=\"../views/kse/images/gold.jpg\" width=\"80px\"/>&nbsp;Золото</td>
     <td align='right' valign='middle'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'>".$row['bid']."</td>
     <td align='right' valign='middle'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'>".$row['ask']."</td>
     </tr>";
while ($row = mysql_fetch_assoc($result_light))
echo "
     <tr>
	 <td align='left'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'><img src=\"../views/kse/images/light.jpg\" width=\"80px\" />&nbsp;Нефть Light</td>
     <td align='right' valign='middle'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'>".$row['bid']."</td>
     <td align='right' valign='middle'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'>".$row['ask']."</td>
     </tr>";
while ($row = mysql_fetch_assoc($result_brent))
echo "
     <tr>
	 <td align='left'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'><img src=\"../views/kse/images/oil.jpg\" width=\"80px\" />&nbsp;Нефть Brent</td>
     <td align='right' valign='middle'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'>".$row['bid']."</td>
     <td align='right' valign='middle'><font face='verdana' style='font-size:45px;font-weight:bold;' color='#ffff00' size='300'>".$row['ask']."</td>
     </tr>";

echo "</table>";