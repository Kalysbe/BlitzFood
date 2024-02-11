<?php
    // Создаем SimpleXML объект
	// $currency = simplexml_load_file('http://www.nbkr.kg/XML/daily.xml');
	$url = "http://www.nbkr.kg/XML/daily.xml";
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
?>
<html>
<head>
<title></title>
<style>
/* Курс валют */
table.kurs{width:200px; border:0px solid #ccc; text-align:center; margin:0 0 0 13px;}
.kurs td.kurs_caption{color:#808080; font-size:12px; padding:0 0 4px 0;}
.kurs td.kurs_iso{width:105px; border-bottom:1px dashed #ececec;}
.kurs td.kurs_value{width:105px; border-bottom:1px dashed #ececec;}
</style>
</head>
<body>
<h1>Курс валют:</h1>
<table cellpadding="0" cellspacing="0" class="kurs">
<tr>
<td class='kurs_caption'><?=$CurrencyRates['Date']?></td>
<td class='kurs_caption'>Сом</td>
</tr>
<tr>
<td class='kurs_iso'><img src="usd.png" />USD / KGS</td>
<td class='kurs_value'><?=$d_v?></td>
</tr>
<tr>
<td class='kurs_iso'><img src="eur.png" />EUR / KGS</td>
<td class='kurs_value'><?=$e_v?></td>
</tr>
<tr>
<td class='kurs_iso'><img src="kzt.png" />KZT / KGS</td>
<td class='kurs_value'><?=$k_v?></td>
</tr>
<tr>
<td class='kurs_iso'><img src="rus.png" />RUB / KGS</td>
<td class='kurs_value'><?=$r_v?></td>
</tr>
</table>
</body>
</html>