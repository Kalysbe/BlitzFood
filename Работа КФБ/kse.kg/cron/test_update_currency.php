<!-- old site_update_currency.php -->


<html>
<head>
  <title></title>
</head>
<body>
<?php
#$url = 'http://92.245.102.37/';
$url = 'https://www.nbkr.kg/XML/daily.xml';
echo '<p>'.$url.'</p>';

$page=@file_get_contents($url);
echo $page;

if ($page==FALSE){
     echo "ERROR ERROR";
}
else
{
     $table_start =strpos($page, 'Îôèöèàëüíûå êóðñû âàëþò');
     $table_end  = strpos($page, 'Àâòîèíôîðìàòîð') ;
     $str=substr($page, $table_start, $table_end - $table_start);

     preg_match_all("|\">(\d*\.\d*)[\d\w].*?<tr>|is",$str,$valut);

     echo "<br>";
     echo "USD ".$valut[1][0]; 
     echo "<br>";
     echo "EUR ".$valut[1][1]; 
     echo "<br>";
     echo "RUB ".$valut[1][2]; 
}
?>
</body>
</html>