<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));

require_once(__ROOT__ . '/config.inc.php');
require_once(__ROOT__ . '/mainfile.php');
// TODO: Totally remake this module
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

error_reporting(0);

// Парсинг json от oi.kse
$inputJson = file_get_contents('php://input');
$input = json_decode($inputJson, true);

$mysql_link = MainClass::getSingleton()->getDbConnection();
$name = $input['name'];
$sql = "SELECT brep_company_id, title FROM brep_companies WHERE lower(title) like '%" . $name ."%' limit 10";
//$result = mysqli_query($mysql_link, $sql);  
//$company = mysqli_fetch_object($result);
$result = mysqli_query($mysql_link, $sql);
$rows = mysqli_num_rows($result);
$buffer = array();
for ($i = 0; $i < $rows; $i++) {
    mysqli_data_seek($result, $i);
    $obj = mysqli_fetch_object($result);
    $buffer[$i]['brep_company_id'] = $obj->brep_company_id;
    $buffer[$i]['title'] = $obj->title;
}

echo json_encode($buffer);
//print_r($buffer);
//print_r($input);

exit;


?>