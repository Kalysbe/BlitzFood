<?php
$_no_page_redirect = 1;

if (isset($_POST["doDelMarket"])) 
{
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");
	
	$link_mysql = MainClass::getSingleton()->getDbConnection();
	
    if (isset($_POST["id_row"])) 
    {
        $sql = "DELETE FROM `mod_fin_market` where fin_market_id=" . $_POST["id_row"] . " ;";
        //echo $sql;
        mysqli_query($link_mysql, $sql);

       Header("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/ru/FinMarket");
       exit;
    }
}
?>
