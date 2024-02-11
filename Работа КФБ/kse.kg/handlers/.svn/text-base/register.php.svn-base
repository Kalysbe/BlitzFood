<?php

function goToRegisterPage() {
    Header ("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] . "/Register");
    exit();
}

if (isset($_POST["doRegister"])) {
    require_once('../config.inc.php');
    require_once('../mainfile.php');
    $MainClass = MainClass::getSingleton();

    $login = trim($MainClass->parseInput($_POST["mLogin"]));
    $pass = $MainClass->parseInput($_POST["mPass"]);
    $passConfirm = $MainClass->parseInput($_POST["mPassConfirm"]);
    $email = trim($MainClass->parseInput($_POST["mEmail"]));

    if (($login == "")||(strlen($login) < 6)||(strlen($login) > 32)) {
        $MainClass->appendError("{LoginIsBad}");
        goToRegisterPage();
    }

    if (!preg_match('/^[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?\.[A-Za-z0-9]{2,6}$/',
            $email)) {
        $MainClass->appendError("{EmailIsBad}");
        goToRegisterPage();
    }

    if ($pass != $passConfirm) {
        $MainClass->appendError("{PasswordsMismatch}");
        goToRegisterPage();
    }

    if (strlen($pass) < 6) {
        $MainClass->appendError("{PasswordsIsBad}");
        goToRegisterPage();
    }

    $pass = md5($pass);

    $sql = "SELECT * FROM `users` WHERE (`login`='" . $login . "' OR `email`='" . $email . "')";
    $result = mysql_query($sql);
    $rows = mysql_num_rows($result);
    if ($rows != 0) {
        $MainClass->appendError("{LoginOrEmailAlreadyExists}");
        goToRegisterPage();
    }

    $hash = md5($login . $email . $pass . $pass . $pass . $pass . $email . $login);

    $sql = "INSERT INTO `users` (`login`, `email`, `password`, `reg_date`, `reg_ip`, `hash`) VALUES (
        '" . $login . "',
        '" . $email . "',
        '" . $pass . "',
        '" . time() . "',
        '" . $_SERVER["REMOTE_ADDR"] . "',
        '" . $hash . "'
    )";
    mysql_query($sql);
    $MainClass->appendMessage("{SuccessfullyRegistered}");
    Header("Location: " . $MainClass->getSiteVar("%ROOT%"));
    exit();
}

?>
