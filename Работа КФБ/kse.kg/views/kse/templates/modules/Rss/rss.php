<?php

// Create connection
 $mysqli = new mysqli("localhost", "ksedbadmin", "kbyerc2010", "kse");
// Check connection
if ($mysqli->connect_errno) {
    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
    exit();
} 

// Новости в RSS
 $result = $mysqli->query("SELECT * FROM Blog_Entries ORDER BY cr_date DESC LIMIT 5");
 $rows = $result->num_rows;
// --------------------------------------


 $capitalization = $mysqli->query("SELECT `date`,`capitalization` FROM
            `mod_cap_index`  ORDER BY `date` DESC LIMIT 1"); // Запрос на получение значения капитализации

 $index = $mysqli->query("SELECT `date`,`index` FROM `mod_cap_index`
             GROUP BY `date`,`index` ORDER BY `date` DESC LIMIT 1"); // Запрос на получение значения индекса



// Функция которая формирует результат из запроса в БД и выдает индекс либо капитализацию

function GetResult($query, $index) {
	$row_first = mysqli_fetch_array($query);
	mysqli_data_seek($query , (mysqli_num_rows($query)-1));
	$resArr = mysqli_fetch_array($query);
	return $resArr[$index];
}

//---------------------------------------------

$Index = GetResult($index, 1); // Получаем икдекс
$Cap = round(GetResult($capitalization, 1) / 1000000, 2); // Капитализация деленая на 1000000 и округленная до 2
$today = date("d.m.y");


//  Получаем итоги последних торгов на текущий день

$Trade = $mysqli->query("SELECT * FROM `mod_trade_last` where period='l'");
$rows = $Trade->num_rows;
$TradeLast = array();
for ($i=0; $i<$rows; $i++) {
	$obj=mysqli_fetch_object($Trade);
	$TradeLast[$i]['ShortName'] = $obj->short_name;
	$TradeLast[$i]['NameRus'] = $obj->name_rus;
	$TradeLast[$i]['MaxCost'] = $obj->max_cost;
	$TradeLast[$i]['MinCost'] = $obj->min_cost;
	$TradeLast[$i]['Total_Volume'] = round($obj->total_volume/1000,3);
	$TradeLast[$i]['CountDeal'] = $obj->count_deal;
	$TradeLast[$i]['CountInstr'] = $obj->count_instr;
}

// Получение даты торгов

$date_sql = $mysqli->query("SELECT DATE_FORMAT(full_date,'%d-%m-%Y') AS full_date FROM `mod_tradestat` ORDER BY `ts_result_id` DESC LIMIT 1");
$date_val = GetResult($date_sql, 0);

//////////////////////////////

// Формируем таблицу в xml формате

$tableTrade = "<table>
        <header>
            <col name=\"name\"      				title=\"Наименования компании, вид ЦБ\"/>
            <col name=\"tradesymbol\"      			title=\"Торговый символ\"/>
            <col name=\"maxprice\"        			title=\"Max цена, сом\"/>
            <col name=\"minprice\"      			title=\"Min цена, сом\"/>
            <col name=\"tradevolume\"      			title=\"Объем торгов, тыс. сом\"/>
            <col name=\"amountoftransactions\"      title=\"Кол-во сделок\"/>
            <col name=\"amountofsecurities\"        title=\"Кол-во ЦБ\"/>
      	</header>
        <body>";
			foreach ($TradeLast as $value) {
				$ShortName 		= $value["ShortName"];
				$NameRus 		= $value["NameRus"];
				$MaxCost 		= $value["MaxCost"];
				$MinCost 		= $value["MinCost"];
				$Total_Volume 	= $value["Total_Volume"];
				$CountDeal 		= $value["CountDeal"];
				$CountInstr 	= $value["CountInstr"];
				$tableTrade .= "<row>
				<col name=\"name\">$ShortName</col>
			    <col name=\"tradesymbol\">$NameRus</col>
			    <col name=\"maxprice\">$MaxCost</col>
			    <col name=\"minprice\">$MinCost</col>
			    <col name=\"tradevolume\">$Total_Volume</col>
			    <col name=\"amountoftransactions\">$CountDeal</col>
			    <col name=\"amountofsecurities\">$CountInstr</col>
			    </row>";
			}
                
$tableTrade .="</body>
    </table>";

//-------------------------------------------

// Получение котировок

$Quotes = $mysqli->query("SELECT * FROM `mod_quotes`");
$rows = $Quotes->num_rows;
$QuotesList = array();
for ($i=0; $i<$rows; $i++) {
	$obj=mysqli_fetch_object($Quotes);
	$QuotesList[$i]['short_name'] = $obj->short_name;
	$QuotesList[$i]['full_name'] = $obj->full_name;
	if ($obj->buy_amount != 0)
        $QuotesList[$i]["buy_amount"] = $obj->buy_amount;
    else
        $QuotesList[$i]["buy_amount"] = "";
    $QuotesList[$i]["buy_price"] = $obj->buy_price;
    if ($obj->sell_amount != 0)
        $QuotesList[$i]["sell_amount"] = $obj->sell_amount;
    else
        $QuotesList[$i]["sell_amount"] = "";
    $QuotesList[$i]["sell_price"] = $obj->sell_price;
}

// Формирование таблицы

$tableQuotes = "<table>
        <header>
            <col name=\"short_name\"      				title=\"Торговый символ\"/>
            <col name=\"full_name\"      			title=\"Наименование\"/>
            <col name=\"buy_amount\"        			title=\"Предложения на продажу (кол-во)\"/>
            <col name=\"buy_price\"      			title=\"Предложения на продажу (цена)\"/>
            <col name=\"sell_amount\"      			title=\"Заявка на покупку (кол-во)\"/>
            <col name=\"sell_price\"      title=\"Заявка на покупку (цена)\"/>
      	</header>
        <body>";
			foreach ($QuotesList as $value) {
				$ShortName 		= $value["short_name"];
				$full_name 		= $value["full_name"];
				$buy_amount 	= $value["buy_amount"];
				$buy_price 		= $value["buy_price"];
				$sell_amount 	= $value["sell_amount"];
				$sell_price 	= $value["sell_price"];
				$tableQuotes .= "<row>
				<col name=\"short_name\">$ShortName</col>
			    <col name=\"full_name\">$full_name</col>
			    <col name=\"buy_amount\">$buy_amount</col>
			    <col name=\"buy_price\">$buy_price</col>
			    <col name=\"sell_amount\">$sell_amount</col>
			    <col name=\"sell_price\">$sell_price</col>
			    </row>";
			}
                
$tableQuotes .="</body>
    </table>";


//--------------------------------------------

 header( "Content-type: text/xml");




 // Вывод RSS




 echo "<?xml version='1.0' encoding='UTF-8'?>
 <rss version='2.0'>
 <channel>
 <title>Кыргызская Фондовая Биржа </title>
 <link>https://www.kse.kg</link>
 <description>rss.kse.kg</description>
 <language>ru</language>
 <item>
    <title>Индекс</title>
    <link>https://www.kse.kg/ru/IndexAndCapitalization</link>
    <description>$Index</description>
    <pubDate>$today </pubDate>
  </item>
  <item>
    <title>Капитализация</title>
    <link>https://www.kse.kg/ru/IndexAndCapitalization</link>
    <description>$Cap</description>
    <pubDate>$today </pubDate>
  </item>
  <item>
    <title>Итоги последних сделок</title>
    <link>https://www.kse.kg/ru/TradeResults</link>
    <description>$tableTrade</description>
    <pubDate>$date_val </pubDate>
  </item>
  <item>
    <title>Котировки</title>
    <link>https://www.kse.kg/ru/Quotes</link>
    <description>$tableQuotes</description>
    <pubDate>$today </pubDate>
  </item>

 ";
 

 for ($i = 0; $i < $rows; $i++) {
    $rss_obj=mysqli_fetch_object($result);
    $id = $rss_obj->blogentry_id;
    $title =  $rss_obj->title;
    // удаление всех html тегов из текста
    $text = strip_tags($rss_obj->text);
    $date =  $rss_obj->cr_date;
    $name =  $rss_obj->name;
    // поиск элементов массива в строке и замена на пустоту
    $text = str_ireplace( array('&nbsp;', '&raquo;', '&laquo;', '&ndash;', '&quot;' ),'', $text); 
    $url = "http://www.kse.kg/views/kse/images/logo_rss.png";
   echo "<item>
   <title>$title</title>
   <link>http://www.kse.kg/ru/RussianAllNewsBlog/$id/$name</link>
   <description>$text</description>
   <pubDate>$date</pubDate>
   <enclosure url=\"$url\" type=\"image/png\" />
   </item>";
 }
 echo "</channel></rss>";

 $result->close();
  $mysqli->close();

?>