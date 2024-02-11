<?php

// TODO: Totally remake this module
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once(__ROOT__ . '/config.inc.php');
require_once(__ROOT__ . '/mainfile.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


// Парсинг json от oi.kse
$inputJson = file_get_contents('php://input');
$input = json_decode($inputJson, true);

$link_mysql = MainClass::getSingleton()->getDbConnection();


//print_r($input);

if ($input['id']['type'] == 'RKV01' || $input['id']['type'] == 'RKV02') {
    $file = $input['id']['id'];
    $sql = "DELETE FROM brep_reports WHERE filepath = '$file'";
    $result = mysqli_query($link_mysql, $sql);
    //echo $input['id']['id'];
} else {
    $id = $input['id']['id'];
    $sql = "DELETE FROM Blog_Entries WHERE blogentry_id = '$id'";
    $result = mysqli_query($link_mysql, $sql);
}

?>