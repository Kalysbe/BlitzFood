<?php


$Module = "Orders";

function Orders_loadController() {
	$link = MainClass::getSingleton()->getDbConnection();
    $Controller = new ControllerClass();
    $Uri = MainClass::getSingleton()->getFullUriPath();

    $Controller->appendVariable("ControllerInclusion", "modules/Orders/Orders.html");

    return $Controller;
}

?>