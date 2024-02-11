<?php

if (isset($_POST["doEditPage"])) {
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

    $Page = new Page("", $_POST["PageId"], true);
    $Page->setText($_POST["mPageText"]);
    $Page->setTitle($_POST["mPageTitle"]);
    $Page->save();

    $_SESSION["MESSAGE"][] = "{PageSuccessfullyEdited}";
    Header("Location: " . $_SITE["%ROOT%"] . "/" . $_SESSION["LANGUAGE"] . "/" . $Page->getUname());
    exit();
};


?>