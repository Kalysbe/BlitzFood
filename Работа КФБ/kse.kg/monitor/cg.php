<?php
define("HOST","localhost");
define("USER","kseuser");
define("PASS","kseuserpass");
define("DB","kse");
$link = mysql_connect(HOST,USER,PASS) or die (mysql_error());  
       
        mysql_select_db(DB, $link);
         
$sql_cg = "SELECT DATE_FORMAT(`date`,'%d.%m.%Y') AS `date`,`price` FROM `cg` ORDER BY `date` DESC LIMIT 1";
$result_cg = mysql_query($sql_cg) or die(mysql_error() ."<br/>". $sql_cg);

echo " 
<link href='style.css' type='text/css' rel='stylesheet'> 
<body scroll='no'>
 <br>
<br><br><br><br><br><br>
<table class='t_gold'>
<tr>
<td align='left'><font color=##00FF00; size='6';>Centerra Gold Inc</font></td>
</tr>
<tr>
<td></td>
		<td class='bid_ask'>Цена</td>
</tr>";

while ($row = mysql_fetch_assoc($result_cg))
echo "
<td align='left'><font color='##00FF00'size='5'>Данные на: ".$row['date']."</font></td>
     <tr>
	 <td class='t_left'><img src=\"../views/kse/images/gold.jpg\" width=\"80px\"/>&nbsp;CG.TO</td>
     <td class='t_right'>".$row['price']." CAD</td>
     </tr>";

echo "</table>";