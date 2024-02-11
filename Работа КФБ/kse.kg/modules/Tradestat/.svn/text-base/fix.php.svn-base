<?php
require_once("../../config.inc.php");
require_once("../../mainfile.php");

$sql = "SELECT * FROM `mod_tradestat` WHERE (`full_date`='0000-00-00')";
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
for ($i = 0; $i < $rows; $i++) {
    echo 1;
    mysql_data_seek($result, $i);
    $obj = mysql_fetch_object($result);

    $full_date = $obj->year . "-" . $obj->month . "-" . $obj->day;
    $sql = "UPDATE `mod_tradestat` SET `full_date`='" . $full_date . "' WHERE (`ts_result_id`='" . $obj->ts_result_id . "')";
    mysql_query($sql);
}

?>
