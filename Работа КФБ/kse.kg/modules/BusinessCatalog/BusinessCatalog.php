<?php

if (isset($_POST["doAdd"])) {
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");

    $name = $_POST["mName"];
    $text = $_POST["mText"];
    $group = $_POST["mGroup"];

    $sql = "INSERT INTO `mod_bc_entries` (`name`, `group`, `title`, `description`) VALUES (
        '" . $name . "', '" . $group . "', '" . $name . "', '" . $text . "'
    )";
    $link = MainClass::getSingleton()->getDbConnection();
	mysqli_query($link, $sql);

    Header ("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/" . $_SESSION["LANGUAGE"] . "/" . $group);
    exit();
}

$Module = "BusinessCatalog";

function BusinessCatalog_loadController() {

    $link = MainClass::getSingleton()->getDbConnection();
	$Controller = new ControllerClass();

    $Controller->appendVariable("ControllerInclusion", "modules/BusinessCatalog/BusinessCatalog.html");

    $route = MainClass::getSingleton()->getFullUriPath();
    $group = mysqli_real_escape_string($link, trim($route[2]));

    $sql = "SELECT * FROM `mod_bc_entries` WHERE (`group`='" . $group . "' OR `group`='') order by `name`";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);

    $BusinessCatalog = array();

    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        $BusinessCatalog[$i]['title'] = $obj->title;
        $BusinessCatalog[$i]['id'] = $obj->entry_id;
        $BusinessCatalog[$i]['text'] = trim($obj->description);
    }
    $Controller->appendVariable("BusinessCatalog", $BusinessCatalog);
    $Controller->appendVariable("Group", $group);

    return $Controller;
}

?>
