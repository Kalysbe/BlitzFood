<?php

require_once("../config.inc.php");
require_once("../mainfile.php");

function update_index($name, $date, $index) {
	$link = MainClass::getSingleton()->getDbConnection();
	$sql = "SELECT * FROM `mod_indeces` 
		WHERE `name`='" . $name . "' AND `date`='" . $date . "'";
	$result = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($result);
	if ($rows == 0) {
		$sql = "INSERT INTO `mod_indeces` 
			(`name`, `index`, `date`) VALUES 
			('" . $name . "', '" . $index . "', '" . $date . "')";
		mysqli_query($link, $sql);
	}
}

$period = 30;

$world_indexes = "http://export.rbc.ru/free/index.0/free.fcgi?period=DAILY&tickers=NULL&lastdays=" . $period . "&separator=;&data_format=BROWSER";
$rus_indexes = "http://export.rbc.ru/free/rusindex.0/free.fcgi?period=DAILY&tickers=NULL&lastdays=" . $period . "&separator=;&data_format=BROWSER";
$spx_indexes = "http://export.rbc.ru/free/index.0/free.fcgi?period=DAILY&tickers=SPX&lastdays=10&separator=;&data_format=BROWSER";

$world_content = "";
$rus_content = "";
$spx_content = "";
error_reporting(255);
	$world_content = file_get_contents($world_indexes);
	$rus_content = file_get_contents($rus_indexes);
	$spx_content = file_get_contents($spx_indexes);
	echo $rus_content;
	$string = explode("\n", $world_content);
	foreach ($string as $line) {
		$array = explode(";", $line);
		switch ($array[0]) {
			case "DJI":
				update_index($array[0], $array[1], $array[2]);	
				break;
			default:
				break;
		};
	}

	$string = explode("\n", $rus_content);
	foreach ($string as $line) {
		$array = explode(";", $line);
		switch($array[0]) {
			case "MICEX10INDEX":
				update_index("MICEX", $array[1], $array[2]);
				break;
			case "RTSI":
				update_index($array[0], $array[1], $array[2]);
				break;
			default:
				break;
		};
	}

	$string = explode("\n", $spx_content);
	foreach ($string as $line) {
		$array = explode(";", $line);
		switch($array[0]) {
			case "SPX":
				update_index("SnP500", $array[1], $array[2]);
				break;
			default:
				break;
		};
	}

?>
