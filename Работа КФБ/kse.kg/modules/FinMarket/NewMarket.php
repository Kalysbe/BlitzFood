<?php
$_no_page_redirect = 1;
if (isset($_POST["doAddMarket"])) {
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");

	$link_mysql = MainClass::getSingleton()->getDbConnection();

    if ($_FILES["mMarket"]["error"] === UPLOAD_ERR_OK) {
        copy($_FILES["mMarket"]["tmp_name"] , "../../FinMarket/" . $_FILES["mMarket"]["name"]);
        if (trim($_POST["mTitle"]) == "") {
            $Title = $_FILES["mMarket"]["name"];
        } else 
            $Title = $_POST["mTitle"];

        $Description = $_POST["mDescription"];
        $Filesize = $_FILES["mMarket"]["size"];

        $sql = "INSERT INTO `mod_fin_market` (`filepath`, `filesize`, `title`, `description`, `date`) VALUES (
            '" . $_FILES["mMarket"]["name"] . "',
            '" . $Filesize . "',
            '" . $Title . "',
            '" . $Description . "',
            '" . date("Y-m-d H:i:s") . "'
        )";
        mysqli_query($link_mysql, $sql);
        Header("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/ru/FinMarket");
        exit;
    } else {
        MainClass::getSingleton()->appendError(file_upload_error_message($_FILES["mMarket"]["error"]));
        Header("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%"));
        exit();
    }
}
if (isset($_POST["doEditMarket"])) {
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");
    echo 'edit';
}

?>
