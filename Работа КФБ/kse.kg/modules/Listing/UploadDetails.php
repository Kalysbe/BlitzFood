<?php

if (isset($_POST['doUpdateNote'])) {
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");
    $link_mysql = MainClass::getSingleton()->getDbConnection();

    $note = $_POST['note'];
    $company_id = $_POST['CompanyId'];

    // Getting company information
    
        $sql = "SELECT * FROM `ls_trade_symbols` WHERE (`ls_company_id`='" . $company_id . "') LIMIT 1";
        $result = mysqli_query($link_mysql, $sql);
        $rows = mysqli_num_rows($result);
        
        $obj = mysqli_fetch_object($result);
        $TradeSymbol = $obj->trade_symbol;
        
    

    $sql = "UPDATE `ls_companies` SET `note`= '" . $note . "' WHERE 
        `ls_company_id`='" . $company_id . "'";

        mysqli_query($link_mysql, $sql);

        Header ("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/ru/ListingDetails/" . $TradeSymbol);

    exit();

}



?>