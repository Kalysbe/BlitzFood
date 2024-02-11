<?php

require_once("../config.inc.php");
require_once("../mainfile.php");

function update_index($name, $date, $index)
{
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


error_reporting(255);

$date = date('Y-m-d');

// **************** RTSI START **********

$rus_content = file_get_contents('https://quote.rbc.ru/ticker/32543');

$string = explode("\n", $rus_content);


$output = array_slice($string, 841, 1);

$array = array_map('trim', $output);

foreach ($array as $k => $v) {
	$v = preg_replace('/-->/', '', $v);
	$v = str_replace(' ', '', $v);
	$v = str_replace(',', '.', $v);
	//update_index("RTSI",  $date, strip_tags($v));
	//echo $k . ' RTSI = ' . strip_tags($v) . "<br>";
}

// **************** RTSI END **********


// **************** DJI START **********

$dja_content = file_get_contents('https://quote.rbc.ru/ticker/106064');

$string = explode("\n", $dja_content);

$output = array_slice($string, 841, 1);

$array = array_map('trim', $output);

foreach ($array as $k => $v) {
	$v = preg_replace('/-->/', '', $v);
	$v = str_replace(',', '.', $v);
	$v = str_replace(' ', '', $v);
	//update_index("DJI",  $date, strip_tags($v));
	//echo $k . ' DJI = ' . strip_tags($v) . "<br>";
}

// **************** DJI END **********


// **************** IMOEX START **********

$IMOEX_content = file_get_contents('https://quote.rbc.ru/ticker/61867');

$string = explode("\n", $IMOEX_content);

$output = array_slice($string, 841, 1);

$array = array_map('trim', $output);

foreach ($array as $k => $v) {
	$v = preg_replace('/-->/', '', $v);
	$v = str_replace(',', '.', $v);
	$v = str_replace(' ', '', $v);
	//update_index("IMOEX",  $date, strip_tags($v));
	//echo $k . 'IMOEX = ' . strip_tags($v) . "<br>";
}

// **************** IMOEX END **********
