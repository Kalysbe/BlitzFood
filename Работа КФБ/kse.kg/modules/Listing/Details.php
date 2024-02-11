<?php
$Module = "ListingDetails";

require_once('listing_handler.php');

function rebuildDate($date) {
    return date("d.m.Y", strtotime($date));
    //return $date;
}

function ListingDetails_loadController() {
	$link = MainClass::getSingleton()->getDbConnection();
    
	$Controller = new ControllerClass();
    $Controller->appendVariable("ControllerInclusion", "modules/Listing/Details.html");

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
        $CompanyInfo['CompanyName'] = $Company->ls_company_name;
        $CompanyInfo['Security'] = $Company->security;
        $CompanyInfo['Symbols'] = implode(" ", getTradeSymbols($Company->ls_company_id));
        $CompanyInfo['Sphere'] = $Company->sphere;
        $CompanyInfo['Activity'] = $Company->activity;
        $CompanyInfo['ListingDate'] = $Company->cr_date;
        $CompanyInfo['Owner'] = $Company->owner;
        $CompanyInfo['OwnerPosition'] = $Company->owner_position;
        $CompanyInfo['Address'] = $Company->address;
        $CompanyInfo['Phone'] = $Company->phone;
        $CompanyInfo['Auditor'] = $Company->auditor;
        $CompanyInfo['Registrar'] = $Company->registrar;
        $CompanyInfo['MarketMaker'] = $Company->marketmaker;
        $CompanyInfo['note'] = $Company->note;

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
			"corporate" => array(),
			"auditreport" => array(),
			"historyreport" => array()
        );
        for ($i = 0; $i < $rows; $i++) {
            mysqli_data_seek($result, $i);
            $Report = mysqli_fetch_object($result);
            $_r = array();
            switch ($Report->type) {
                case "balance":
                    $_r['Name'] = 'Бухгалтерский Баланс';
                    break;
                case "prospect":
                    $_r['Name'] = 'Листинговый проспект';
                    break;
                case "fin_rep":
                    $_r['Name'] = 'Отчет о финансовых результатах';
                    break;
                case "cash_flow":
                    $_r['Name'] = 'Отчет о движении денежных средств';
                    break;
                case "cap_rep":
                    $_r['Name'] = 'Отчет об изменениях в капитале';
                    break;
                case "news":
                    $_r['Name'] = 'Новости';
                    break;
                case "analytics":
                    $_r['Name'] = 'Сведения о соблюдении экономических нормативов';
                    break;
				case "corporate":
                    $_r['Name'] = 'Кодекс корпоративного управления';
                    break;
				case "auditreport":
                    $_r['Name'] = 'Аудиторское заключение';
                    break;
				case "historyreport":
                    $_r['Name'] = 'История компании';
                    break;
                default:
                    $_r['Name'] = 'Неизвестно';
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
