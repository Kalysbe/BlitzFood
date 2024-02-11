
<html>
<head>
  <title></title>
</head>
<body>
<?php
#$url = 'http://92.245.102.37/';
$url = 'https://www.nbkr.kg/XML/daily.xml';
$xml = file_get_contents($url);
     $CurrencyRates = simplexml_load_string($xml);
    // Создание переменных
    $d_n = '';
    $d_v = '';
    $e_n = '';
    $e_v = '';
    $k_n = '';
    $k_v = '';
    $r_n = '';
    $r_v = '';
    // Доллар
    if ($CurrencyRates->Currency[0]['ISOCode'] == 'USD') {
        // Номинал
        $d_n = $CurrencyRates->Currency[0]->Nominal;
        // Значение
        $d_v = $CurrencyRates->Currency[0]->Value;
    }
    // Евро
    if ($CurrencyRates->Currency[1]['ISOCode'] == 'EUR') {
        // Номинал
        $e_n = $CurrencyRates->Currency[1]->Nominal;
        // Значение
        $e_v = $CurrencyRates->Currency[1]->Value;
    }
    // Тенге
    if ($CurrencyRates->Currency[2]['ISOCode'] == 'KZT') {
        // Номинал
        $k_n = $CurrencyRates->Currency[2]->Nominal;
        // Значение
        $k_v = $CurrencyRates->Currency[2]->Value;
    }
    // Рубль
    if ($CurrencyRates->Currency[3]['ISOCode'] == 'RUB') {
        // Номинал
        $r_n = $CurrencyRates->Currency[3]->Nominal;
        // Значение
        $r_v = $CurrencyRates->Currency[3]->Value;
    }
// echo '<p>'.$url.'</p>';

// echo $xml;

if ($xml==FALSE){
     echo "ERROR ERROR";
}
else
{
     // $table_start =strpos($page, 'Îôèöèàëüíûå êóðñû âàëþò');
     // $table_end  = strpos($page, 'Àâòîèíôîðìàòîð') ;
     // $str=substr($page, $table_start, $table_end - $table_start);

     // preg_match_all("|\">(\d*\.\d*)[\d\w].*?<tr>|is",$str,$valut);
     //print_r($valut);

     echo "<br>";
     echo "USD ". $d_v; 
     echo "<br>";
     echo "EUR ". $e_v; 
     echo "<br>";
     echo "RUB ". $r_v; 
}
?>
</body>
</html>