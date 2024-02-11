<?php
require_once('../config.inc.php');
require_once('../mainfile.php');
$MainClass = MainClass::getSingleton();
$link = MainClass::getSingleton()->getDbConnection();
if (!$MainClass->checkUserLogin()) {
    $MainClass->appendError("{AvailableForLoggedUser}");
    Header("Location: " . $MainClass->getSiteVar("%ROOT%") . "/" .
        $_SESSION["LANGUAGE"] . "/" . $MainClass->getSiteVar("MAIN_PAGE"));
    exit();
}

mysqli_query($link, "DELETE FROM `sessions` WHERE (`hash`='" . $_SESSION["HASH"] .
    "' OR `uid`='" . $MainClass->getLoggedUid() . "')");
unset($_SESSION["LOGGED"]);
unset($_SESSION["HASH"]);

Header("Location: " . $MainClass->getSiteVar("%ROOT%"));
exit();
?>
