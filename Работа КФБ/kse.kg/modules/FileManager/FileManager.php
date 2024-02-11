<?php

$Module = "FileManager";

function FileManager_loadController() {
    $Controller = new ControllerClass();

    if ((MainClass::getSingleton()->checkUserLogin())&&(MainClass::getSingleton()->getUserLevel() == 99)) {
        $Controller->appendVariable("AdminRights", true);
		$link_mysql = MainClass::getSingleton()->getDbConnection();
		
        if (isset($_POST["doSaveChanges"])) {
            $sql = "UPDATE `attachments` SET `description`='" .
            mysqli_real_escape_string($link_mysql, $_POST["description"]) . "'
                WHERE (`attachment_id`='" . $_POST["attachment_id"] . "')";
            mysqli_query($link_mysql, $sql);
            echo mysqil_error($link_mysql);
        }
        $sql = "SELECT * FROM `attachments` ORDER BY `cr_date` DESC";
        $result = mysqli_query($link_mysql, $sql);
        $rows = mysqli_num_rows($result);
        $file_list = array();

        for ($i = 0; $i < $rows; $i++) {
            mysqli_data_seek($result, $i);
            $att = mysqli_fetch_object($result);
            $file_list[$i]['filename'] = $att->filename;
            $file_list[$i]['filepath'] = $att->filepath;
            $file_list[$i]['filesize'] = display_filesize($att->filesize);
            $file_list[$i]['cr_date'] = $att->cr_date;
            $file_list[$i]['description'] = $att->description;
            $file_list[$i]['attachment_id'] = $att->attachment_id;
        }
        $Controller->appendVariable("file_list", $file_list);
    }

    
    $Controller->appendVariable("ControllerInclusion", "modules/FileManager/FileManager.html");

    return $Controller;
}

?>
