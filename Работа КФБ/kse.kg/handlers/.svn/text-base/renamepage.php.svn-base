<?php

if (isset($_POST["doRenamePage"])) {
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

    $Page = new Page("", $_POST["pageId"], true);
    $Page->setUname($_POST["mNewPageName"]);
    $Page->save();

    $_SESSION["MESSAGE"][] = "{PageSuccessfullyRenamed}";
    Header("Location: " . $_SITE["%ROOT%"] . "/" . $_SESSION["LANGUAGE"] . "/" . $Page->getUname());
    exit();
};