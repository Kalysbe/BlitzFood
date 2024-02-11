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

$sql = "SELECT * FROM `attachments`,`page_attachments` WHERE (`attachments`.`attachment_id`=`page_attachments`.`attachment_id`
    AND `page_attachments`.`page_id`='" . $this->Id . "')";
$result = mysqli_query($link_mysql, $sql);
echo mysqli_error($link_mysql);
$rows = mysqli_num_rows($result);

$Attachments = array();

for ($i = 0; $i < $rows; $i++) {
    mysqli_data_seek($result, $i);
    $att = mysqli_fetch_object($result);
    $Attachments[$i]['filename'] = $att->filename;
    $Attachments[$i]['filepath'] = $att->filepath;
}

$Variables["PageAttachmentsHandler"] = $Attachments;