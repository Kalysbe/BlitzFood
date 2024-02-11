<?php

if (isset($_POST["doAddPage"])) {
    require_once('../config.inc.php');
    require_once('../mainfile.php');
    require_once('../includes/page.class.php');

    $MainClass = MainClass::getSingleton();
    if (!$MainClass->checkUserLogin()) {
        $MainClass->appendError("{AvailableForLoggedUser}");
        Header("Location: " . $MainClass->getSiteVar("%ROOT%") . "/" .
            $_SESSION["LANGUAGE"] . "/Login");
        exit();
    }

    $Uname = $MainClass->parseInput($_POST["mPageName"]);
    $Title = $MainClass->parseInput($_POST["mPageTitle"]);
    $Text = $MainClass->parseInput($_POST["mPageText"]);
    $Namespace = $MainClass->parseInput($_POST["mPageNamespace"]);

    if ($MainClass->getRows("pages", "`page_uname`='" . $Uname . "'") > 0) {
        $MainClass->appendError("{PageMustBeUnique}");
        Header("Location: " . $MainClass->getSiteVar("%ROOT%") . "/" .
            $_SESSION["LANGUAGE"] . "/NewPage/" . $Uname);
        exit();
    }

    $Page = new Page();
    $Page->setStatus(1);
    $Page->setText($Text);
    $Page->setTitle($Title);
    $Page->setUname($Uname);
    $Page->save();

    foreach ($_FILES as $file) {
        if ($file["error"] === UPLOAD_ERR_OK) {
            $hash = md5($file["tmp_name"] . time());
            $new_file_name = $hash . "_" . $file["name"];
            copy($file["tmp_name"], $_SITE["%HOME%"] . "/files/pages/" . $new_file_name);

            $sql = "INSERT INTO `attachments` (`filename`, `filepath`, `name`, `mime`, `hashname`, `status`, `cr_date`, `filesize`)
                VALUES ('" . $new_file_name . "', '/files/pages/', '" .
                $file["name"] . "', '" . $file["type"] . "', '" . $hash . "', '1', '" . date("Y-m-d H:i:s") . "', '" . $file["size"] . "')";
            mysql_query($sql);
            if (mysql_error() == "")
                MainClass::getSingleton()->appendError(mysql_error());
            $sql = "INSERT INTO `page_attachments` (`attachment_id`, `page_id`)
                VALUES ('" . mysql_insert_id() . "', '" . $Page->getId() . "')";
            mysql_query($sql);
            if (mysql_error() == "")
                MainClass::getSingleton()->appendError(mysql_error());
        } else {
            MainClass::getSingleton()->appendError(file_upload_error_message($file["error"]));
        }
    }

    /*$sql = "INSERT INTO `pages` (`page_uname`, `page_title`, `page_text`,
        `creator`, `cr_date`, `cr_ip`, `status`, `category`, `language`)
        VALUES ('" . $Uname . "', '" . $Title . "', '" . $Text . "', '" . 
        $MainClass->getLoggedUid() . "', '" . time() . "', '" .
        $_SERVER["REMOTE_ADDR"] . "', '1', '0', '" . $_SESSION["LANGUAGE"] . "')";
    mysql_query($sql);
    */
    Header("Location: " . $MainClass->getSiteVar("%ROOT%") . "/" .
     
        $_SESSION["LANGUAGE"] . "/" . $Uname);
    exit();
} else echo "Restricted Area";

?>
