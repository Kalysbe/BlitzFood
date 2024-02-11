<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));

require_once(__ROOT__ . '/config.inc.php');
require_once(__ROOT__ . '/mainfile.php');
// TODO: Totally remake this module
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

error_reporting(0);
$mysql_link = MainClass::getSingleton()->getDbConnection();

$sql = "SELECT cr_date, title, blogentry_id, name FROM Blog_Entries WHERE blog_id = 2 ORDER BY blogentry_id DESC LIMIT 20";
//$result = mysqli_query($mysql_link, $sql);  
//$company = mysqli_fetch_object($result);
$result = mysqli_query($mysql_link, $sql);
$rows = mysqli_num_rows($result);
$buffer = array();
for ($i = 0; $i < $rows; $i++) {
    mysqli_data_seek($result, $i);
    $obj = mysqli_fetch_object($result);
    $buffer[$i]['cr_date'] = $obj->cr_date;
    $buffer[$i]['title'] = $obj->title;
    $buffer[$i]['blog_id'] = $obj->blogentry_id;
    $buffer[$i]['name'] = $obj->name;
}

//print_r($buffer);
echo json_encode($buffer);

exit;


?>