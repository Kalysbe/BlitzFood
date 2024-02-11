<?php
require_once("../../config.inc.php");

$servername = "localhost";
$username = "ksedbadmin";
$password = "kbyerc2010";
$dbname = "kse";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//for first table
$sql_tradestat = "SELECT * FROM mod_tradestat ORDER BY ts_result_id DESC LIMIT 1";
// for second table
$sql_trade_last = "SELECT * FROM `mod_trade_last` where period='l'";

$result_tradestat = $conn->query($sql_tradestat);
$result_trade_last = $conn->query($sql_trade_last);

if ($result_tradestat->num_rows > 0 && $result_trade_last->num_rows > 0) {

    $obj = mysqli_fetch_object($result_tradestat);

    $TradeLast = '';
    for ($i=0; $i< mysqli_num_rows($result_trade_last); $i++) {
        mysqli_data_seek($result_trade_last, $i);
        $trade_last=mysqli_fetch_object($result_trade_last);
        $TradeLast .= '
        <tr>
            <td>'.$trade_last->name_rus.'</td>
            <td>'.$trade_last->short_name.'</td>
            <td>'.$trade_last->max_cost.'</td>
            <td>'.$trade_last->min_cost.'</td>
            <td>'.round($trade_last->total_volume/1000,3).'</td>
            <td>'.$trade_last->count_deal.'</td>
        </tr>';
    };


   $tvc = '<font color="#ffffff">';
    $primary = '<font color="#ffffff">';
    $secondary = '<font color="#ffffff">';
    $listing = '<font color="#ffffff">';
    $nonlisting = '<font color="#ffffff">';

        if ($obj->total_volume_change > 0)
            $tvc = '<font color="#00FF00">&#9650;';
        elseif ($obj->total_volume_change < 0)
            $tvc = '<font color="red">&#9660;';
        if ($obj->primary_change > 0)
            $primary = '<font color="#00FF00">&#9650;';
        elseif ($obj->primary_change < 0)
            $primary = '<font color="red">&#9660;';
        else
            $primary = '<font color="#ffffff">';
        if ($obj->secondary_change > 0)
            $secondary = '<font color="#00FF00">&#9650;';
        elseif ($obj->secondary_change < 0)
            $secondary = '<font color="red">&#9660;';
        if ($obj->listing_change > 0)
            $listing = '<font color="#00FF00">&#9650;';
        elseif ($obj->listing_change < 0)
            $listing = '<font color="red">&#9660;';
        if ($obj->non_listing_change > 0)
            $nonlisting = '<font color="#00FF00">&#9650;';
        elseif ($obj->non_listing_change < 0)
            $nonlisting = '<font color="red">&#9660;';
    $buffer ='
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Торги за ' . $obj->day . "." . $obj->month . "." . $obj->year . '</title>
        <style>
        html, body {
            height:100%;
            background-color: #424242;
            margin:0;
        }
        table.darkTable {
            font-family: Verdana, Geneva, sans-serif;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            margin-top: 1%;
        }
        table.darkTable:last-child {
            margin-top: 3%;
        }
        table.darkTable td{
            border: 1px solid #555;
           
        }

        table.darkTable tbody td {
            font-size: 22px;
            font-weight: bold;
            color: #FFF700;
            
        }
        table.darkTable thead {
            background: #424242;
        }
        table.darkTable thead th {
            font-size: 22px;
            font-weight: bold;
            color: #00FF00;
            text-align: center;
        }
        h1 {
            font-family: Verdana, Geneva, sans-serif;
            font-weight: bold;
            color: #00FF00;
            text-align: center;
            margin: 0;
        }
    </style>
    </head>
    <body>
        <h1>Итоги последних сделок за '. $obj->day . '.' . $obj->month . '.' . $obj->year .'</h1>
        <table class="darkTable">
        <thead>
            <tr>
                <th></th>
                <th>Млн.сом</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Объем торгов</td>
                <td>'. $obj->total_volume .'</td>
                <td>'. $tvc . abs($obj->total_volume_percent) .'</td>
            </tr>
            <tr>
                <td>Первичный</td>
                <td>'. $obj->pervyi .'</td>
                <td>'. $primary .abs($obj->primary_percent) .'</td>
            </tr>
            <tr>
                <td>Вторичный</td>
                <td>'. $obj->secondary .'</td>
                <td>'. $secondary .abs($obj->secondary_percent) .'</td>
            </tr>
            <tr>
                <td>Листинг</td>
                <td>'. $obj->listing .'</td>
                <td>'. $listing .abs($obj->listing_percent) .'</td>
            </tr>
            <tr>
                <td>Нелистинг</td>
                <td>'. $obj->non_listing .'</td>
                <td>'. $nonlisting . abs($obj->non_listing_percent) .'</td>
            </tr>
        </tbody>
        </table>
        <table class="darkTable">
        <thead>
            <tr>
                <th>Наименования компании, вид ЦБ</th>
                <th>Торговый символ</th>
                <th>Max цена, сом</th>
                <th>Min цена, сом</th>
                <th>Объем торгов, тыс. сом</th>
                <th>Кол-во сделок</th>
            </tr>
        </thead>
        <tbody>
            '.$TradeLast.'
        </tbody>
        </table>
    </body>
    </html>
    ';
    
        echo $buffer;
} else {
  echo "<h2>Итоги торгов</h2>
        <div class=\"notice ui-corner-all\"><h3>Информация временно недоступна</h3></div>
        ";
}

$conn->close();
?>