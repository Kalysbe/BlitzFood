<?php
$Module = "ListingDetails";

require_once('listing_handler.php');

function rebuildDate($date) {
    return date("d.m.Y", strtotime($date));
    //return $date;
}

function ListingDetails_loadController() {
    $Controller = new ControllerClass();
	$link = MainClass::getSingleton()->getDbConnection();
    $Controller->appendVariable("ControllerInclusion", "modules/Listingeng/Details.html");

    $uri_path = MainClass::getSingleton()->getFullUriPath();
    if (count($uri_path) > 3) {
        if (trim($uri_path[3]) != "") {
            $Page = "Object";
            $TradeSymbol = $uri_path[3];
            // The one company was required
        }
    }

    $sql = "SELECT * FROM `ls_trade_symbols` WHERE (`trade_symbol`='" . $TradeSymbol . "')";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    if ($rows == 0) {
        $CompanyId = substr($TradeSymbol,4);
    } else {
        $obj = mysqli_fetch_object($result);
        $CompanyId = $obj->ls_company_id;
    }

    $sql = "SELECT * FROM `ls_companies` WHERE (`ls_company_id`='" . $CompanyId . "')";
    $CompanyResult = mysqli_query($link, $sql);
    $CompanyRows = mysqli_num_rows($CompanyResult);
    if ($CompanyRows != 1) {
        $Controller->appendVariable("ListingError", "{CompanyWasNotFound}");
    } else {
        $Company = mysqli_fetch_object($CompanyResult);
        $CompanyInfo = array();
        $CompanyInfo['CompanyId'] = $Company->ls_company_id;
        $CompanyInfo['CompanyName_eng'] = $Company->ls_company_name_eng;
        $CompanyInfo['Security_eng'] = $Company->security_eng;
        $CompanyInfo['Symbols'] = implode(" ", getTradeSymbols($Company->ls_company_id));
        $CompanyInfo['Sphere_eng'] = $Company->sphere_eng;
        $CompanyInfo['Activity_eng'] = $Company->activity_eng;
        $CompanyInfo['ListingDate'] = $Company->cr_date;
        $CompanyInfo['Owner_eng'] = $Company->owner_eng;
        $CompanyInfo['OwnerPosition_eng'] = $Company->owner_position_eng;
        $CompanyInfo['Address_eng'] = $Company->address_eng;
        $CompanyInfo['Phone'] = $Company->phone;
        $CompanyInfo['Auditor_eng'] = $Company->auditor_eng;
        $CompanyInfo['Registrar_eng'] = $Company->registrar_eng;
        $CompanyInfo['MarketMaker_eng'] = $Company->marketmaker_eng;

        // Work with reports
        $sql = "SELECT * FROM `ls_reports` WHERE (`ls_company_id`='" .
            $Company->ls_company_id . "') ORDER BY `report_date` DESC";
        $result = mysqli_query($link, $sql);
        $rows = mysqli_num_rows($result);

        $Reports = array();
        $ReportsArchive = array(
            "balance" => array(),
            "prospect" => array(),
            "fin_rep" => array(),
            "cash_flow" => array(),
            "cap_rep" => array(),
            "news" => array(),
            "analytics" => array(),
        );
        for ($i = 0; $i < $rows; $i++) {
            mysqli_data_seek($result, $i);
            $Report = mysqli_fetch_object($result);
            $_r = array();
            switch ($Report->type) {
                case "balance":
                    $_r['Name'] = 'Balance Sheet';
                    break;
                case "prospect":
                    $_r['Name'] = 'Listing prospect';
                    break;
                case "fin_rep":
                    $_r['Name'] = 'Financial report';
                    break;
                case "cash_flow":
                    $_r['Name'] = 'Cash flow';
                    break;
                case "cap_rep":
                    $_r['Name'] = 'Capital report';
                    break;
                case "news":
                    $_r['Name'] = 'News';
                    break;
                case "analytics":
                    $_r['Name'] = 'Analytics';
                    break;
                default:
                    $_r['Name'] = 'It is not known';
                    break;
            };

            $_r['Filepath'] = $Report->filepath;
            $_r['Status'] = $Report->status;
            $_r['Type'] = $Report->type;
            $_r['Date'] = rebuildDate($Report->report_date);
            if ($Report->status == 1)
                $Reports[] = $_r;
            elseif ($Report->status == 2) {
                $ReportsArchive[$Report->type][] = $_r;
            }
        }
        $Controller->appendVariable("Reports", $Reports);
        $Controller->appendVariable("ReportsArchive", $ReportsArchive);
        $Controller->appendVariable("CompanyInfo", $CompanyInfo);
        $Controller->appendVariable("SymbolsList", getTradeSymbols($Company->ls_company_id));


        $Controller->appendVariable("SymbolsNum", count(getTradeSymbols($Company->ls_company_id)) + 3);
    }
    

    return $Controller;
}
?>
