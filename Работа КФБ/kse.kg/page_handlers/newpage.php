<?php

$link_mysql = MainClass::getSingleton()->getDbConnection();

$sql = "SELECT * FROM `categories` WHERE (`status`>0)";
$result = mysqli_query($link_mysql, $sql);
$rows = mysqli_num_rows($result);


for ($i = 0; $i < $rows; $i++) {
    mysqli_data_seek($result, $i);
    $obj = mysqli_fetch_object($result);
    $Variables["Categories"][] = $obj->category_name;
}

