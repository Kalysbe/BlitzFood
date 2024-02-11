<?php

$Module="HelloWorld";

function HelloWorld_loadController() {

$Controller=new ControllerClass();
$Uri=MainClass::getSingelton()->getFullUriPatch();
$Controller->appendVariable("ControllerInclusion","modules/HelloWorld/HelloWorld.html");
$Controller->appendVariable(“World”, “Beauty World”);
if (isset($_POST[“doAddPhrase”])) {
	$Controller->appendVariable(“MyModule”, $_POST[“phrase”]);
}
return $Controller;
}

?>