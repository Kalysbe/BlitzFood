<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));

require_once(__ROOT__ . '/config.inc.php');
require_once(__ROOT__ . '/mainfile.php');
// TODO: Totally remake this module
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

error_reporting(0);
$mysql_link = MainClass::getSingleton()->getDbConnection();
$inputJson = file_get_contents('php://input');
$input = json_decode($inputJson, true);
$id = $input['blog_id'];

$sql = "SELECT title, name, text, cr_date FROM Blog_Entries WHERE blogentry_id =" . $id;
//$result = mysqli_query($mysql_link, $sql);  
//$company = mysqli_fetch_object($result);
$result = mysqli_query($mysql_link, $sql);
$rows = mysqli_num_rows($result);
$buffer = array();
for ($i = 0; $i < $rows; $i++) {
    mysqli_data_seek($result, $i);
    $obj = mysqli_fetch_object($result);
    $buffer[$i]['title'] = $obj->title;
    $buffer[$i]['name'] = $obj->name;
    $buffer[$i]['text'] = $obj->text;
    $buffer[$i]['cr_date'] = $obj->cr_date;
}

//print_r($buffer);
echo json_encode($buffer);

exit;


?>