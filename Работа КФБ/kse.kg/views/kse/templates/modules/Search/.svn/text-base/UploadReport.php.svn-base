<?php

$_no_page_redirect = 1;
if (isset($_POST["do_upload_report"])) {
    require_once("../../config.inc.php");
    require_once("../../mainfile.php");

    if ($_FILES["report_file"]["error"] === UPLOAD_ERR_OK) {
        
        // Creating name for report.
        // COMPANY_SYMBOL-Report_name-date.pdf

        // Getting company information
        $sql = "SELECT * FROM `ls_companies` WHERE (`ls_company_id`='" . $_POST["CompanyId"] . "')";
        $result = mysql_query($sql);
        $rows = mysql_num_rows($result);
        if ($rows != 1) {
            MainClass::getSingleton()->appendError("{UnknownListingCompany}");
        } else {
            $Company = mysql_fetch_object($result);
            // Get trade symbol
            $sql = "SELECT * FROM `ls_trade_symbols` WHERE (`ls_company_id`='" . $Company->ls_company_id . "') LIMIT 1";
            $result = mysql_query($sql);
            $rows = mysql_num_rows($result);
            if ($rows != 1) {
                MainClass::getSingleton()->appendError("{UnknownListingTradeSymbol}");
                $TradeSymbol = $Company->ls_company_id;
            } else {
                $obj = mysql_fetch_object($result);
                $TradeSymbol = $obj->trade_symbol;
            }
        }

        if (trim($_POST["report_date"]) == "")
            $date = date("Ymd");
        else
            $date = trim($_POST["report_date"]);
        $report_type = $_POST["report_type"];

        $filename = $TradeSymbol . "-" . $report_type . "-" . $date . ".pdf";
        copy($_FILES["report_file"]["tmp_name"] , "../../Listing/" . $filename);

        // Getting old reports with same type for this company
        $sql = "UPDATE `ls_reports` SET `status`='2' WHERE (
            `ls_company_id`='" . $Company->ls_company_id . "' AND
            `type`='" . $report_type . "'
        )";
        mysql_query($sql);
        
        $sql = "INSERT INTO `ls_reports` (
                `type`,
                `filetype`,
                `status`,
                `upload_date`,
                `report_date`,
                `filepath`,
                `ls_company_id`
            ) VALUES (
                '" . $report_type . "',
                '" . $_FILES["report_file"]["type"] . "',
                '1',
                '" . date("Y-m-d H:i:s") . "',
                '" . $date . "',
                '" . $filename . "',
                '" . $Company->ls_company_id . "'
            )";
        mysql_query($sql);

        Header ("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%") . "/ru/ListingDetails/" . $TradeSymbol);
        exit();

    } else {
        //MainClass::getSingleton()->appendError(file_upload_error_message($_FILES["mMarket"]["error"]));
        Header("Location: " . MainClass::getSingleton()->getSiteVar("%ROOT%"));
        exit();
    }
}

?>
