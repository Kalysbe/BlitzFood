<?php

function goToLoginpage() {
    Header ("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] . "/Login");
}



if (isset($_POST["doLogin"])) {
    
	require_once('../config.inc.php');
    require_once('../mainfile.php');
	

    $MainClass = MainClass::getSingleton();
	$link = MainClass::getSingleton()->getDbConnection();
	
    if ((isset($_POST["mLogin"]))&&(isset($_POST["mPass"]))) {
        $username = $_POST["mLogin"];
        $password = md5($_POST["mPass"]);
        $type = "dynamic";
    } elseif ((isset($_POST["mfLogin"]))&&(isset($_POST["mfPass"]))) {
        $username = $_POST["mfLogin"];
        $password = md5($_POST["mfPass"]);
        $type = "static";
    } else {
        goToLoginpage();
        exit();
    }

    $sql = "SELECT * FROM `users` WHERE (`login`='" . $username . "' AND `password`='" . $password . "')";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    if ($rows == 0) {
        if ($type == "dynamic") {
            echo 0;
        } else {
            $MainClass->appendError("{BadLoginOrPassword}");
            goToLoginpage();
        }
    } elseif ($rows > 1) {
        if ($type == "dynamic") {
            echo 2;
        } else {
            $MainClass->appendError("{UnknownError}");
            goToLoginpage();
        }
    } else {
        $obj = mysqli_fetch_object($result);
        $hash = md5($obj->login . $obj->email . $obj->password . time());
        $_SESSION["LOGGED"] = true;
        $_SESSION["HASH"] = $hash;
        mysqli_query($link, "DELETE FROM `sessions` WHERE (`uid`='" . $obj->uid . "')");
		
		$sql = "INSERT INTO `sessions` (`hash`, `uid`, `last_activity`) VALUES
            ('" . $hash . "', '" . $obj->uid . "', '" . date("Y-m-d H:i:s")  . "')";
        mysqli_query($link, $sql);

        if ($type == "dynamic") {
            echo 1;
        } else {
            Header ("Location: " . $MainClass->getSiteVar("%ROOT%"));
            exit();
        }
    }
} 

?>
