<?php
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
if ($CurrencyRates->Currency[0]['ISOCode'] == 'USD')
{
    // Номинал
    $d_n = $CurrencyRates->Currency[0]->Nominal;
    // Значение
    $d_v = $CurrencyRates->Currency[0]->Value;
}
// Евро
if ($CurrencyRates->Currency[1]['ISOCode'] == 'EUR')
{
    // Номинал
    $e_n = $CurrencyRates->Currency[1]->Nominal;
    // Значение
    $e_v = $CurrencyRates->Currency[1]->Value;
}
// Тенге
if ($CurrencyRates->Currency[2]['ISOCode'] == 'KZT')
{
    // Номинал
    $k_n = $CurrencyRates->Currency[2]->Nominal;
    // Значение
    $k_v = $CurrencyRates->Currency[2]->Value;
}
// Рубль
if ($CurrencyRates->Currency[3]['ISOCode'] == 'RUB')
{
    // Номинал
    $r_n = $CurrencyRates->Currency[3]->Nominal;
    // Значение
    $r_v = $CurrencyRates->Currency[3]->Value;
}

// echo "<br>";
// echo "USD " . $d_v;
// echo "<br>";
// echo "EUR " . $e_v;
// echo "<br>";
// echo "RUB " . $r_v;

require_once ("../config.inc.php");
$link = mysqli_connect($_DB["HOST"], $_DB["USER"], $_DB["PASS"], $_DB["NAME"]);
$date = date("Y-m-d 00:00:00");
$sql = array();

$sql['usd'] = "INSERT INTO `mod_currency` (
            `date`,
            `currency`,
            `currency_name`,
            `rate`,
            `flag`,
            `change_percent`
        ) VALUES (
            '" . $date . "',
            'USD',
            'USD',
            '" . $d_v . "',
            'flag_us.jpg',
            '0'
        )";

$sql['eur'] = "
        INSERT INTO `mod_currency` (
            `date`,
            `currency`,
            `currency_name`,
            `rate`,
            `flag`,
            `change_percent`
        ) VALUES (
            '" . $date . "',
            'EUR',
            'EUR',
            '" . $e_v . "',
            'flag_eu.jpg',
            '0'
            )
        ";

$sql['rub'] = "
        INSERT INTO `mod_currency` (
            `date`,
            `currency`,
            `currency_name`,
            `rate`,
            `flag`,
            `change_percent`
        ) VALUES (
            '" . $date . "',
            'RUB',
            'RUB',
            '" . $r_v . "',
            'flag_rus.jpg',
            '0'
        );
        ";
$delsql = "DELETE FROM `mod_currency` WHERE (`date`='" . $date . "')";
mysqli_query($link, $delsql);
foreach ($sql as $query)
{
    mysqli_query($link, $query);
}

