<?php
/*
 * Module name: TradeStat
 * Description: Display trading statistics for desired period (last day, last
 *              week, last month, last year).
 * Todo:        
 */
$Module = "TradeStat";

function TradeStat_loadController() {
    // Load common charts library
    $link = MainClass::getSingleton()->getDbConnection();
    require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/FusionCharts/Includes/FusionCharts_Gen.php");

    $Controller = new ControllerClass();
    $Uri = MainClass::getSingleton()->getFullUriPath();
    // Template for this module
    $Controller->appendVariable("ControllerInclusion", "modules/Tradestat/Tradestat.html");

    /*
     * Last Trades
     * Loads from database infomation for last trades
     */
    $sql = "SELECT * FROM `mod_tradestat` ORDER BY `ts_result_id` DESC LIMIT 1";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $obj = mysqli_fetch_object($result);
    $Last = array();
    // TODO: Clean this code
    // Images for changed values
    $Last['TotalVolumeImage'] = "";
    $Last['PrimaryImage'] = "";
    $Last['SecondaryImage'] = "";
    $Last['ListingImage'] = "";
    $Last['NonListingImage'] = "";

    if ($obj->total_volume_change > 0)
        $Last['TotalVolumeImage'] = "<font color=\"green\">&#9650;</font>";
    elseif ($obj->total_volume_change < 0)
        $Last['TotalVolumeImage'] = "<font color=\"red\">&#9660;</font>";
    if ($obj->primary_change > 0)
        $Last['PrimaryImage'] = "<font color=\"green\">&#9650;</font>";
    elseif ($obj->primary_change < 0)
        $Last['PrimaryImage'] = "<font color=\"red\">&#9660;</font>";
    else
        $Last['PrimaryImage'] = "";
    if ($obj->secondary_change > 0)
        $Last['SecondaryImage'] = "<font color=\"green\">&#9650;</font>";
    elseif ($obj->secondary_change < 0)
        $Last['SecondaryImage'] = "<font color=\"red\">&#9660;</font>";
    if ($obj->listing_change > 0)
        $Last['ListingImage'] = "<font color=\"green\">&#9650;</font>";
    elseif ($obj->listing_change < 0)
        $Last['ListingImage'] = "<font color=\"red\">&#9660;</font>";
    if ($obj->non_listing_change > 0)
        $Last['NonListingImage'] = "<font color=\"green\">&#9650;</font>";
    elseif ($obj->non_listing_change < 0)
        $Last['NonListingImage'] = "<font color=\"red\">&#9660;</font>";

    $Last['TotalVolume'] = $obj->total_volume;
    $Last['TotalVolumePercent'] = $obj->total_volume_percent;
    $Last['Primary'] = $obj->pervyi;
    $Last['PrimaryPercent'] = $obj->primary_percent;
    $Last['Secondary'] = $obj->secondary;
    $Last['SecondaryPercent'] = $obj->secondary_percent;
    $Last['Listing'] = $obj->listing;
    $Last['ListingPercent'] = $obj->listing_percent;
    $Last['NonListing'] = $obj->non_listing;
    $Last['NonListingPercent'] = $obj->non_listing_percent;
    $d = build_date_mysql($obj->full_date);
    $Controller->appendVariable("Date", $d["day"] . "." . $d["month"] . "." . $d["year"]);
    // Loading chart for this type of data
    $FC = new FusionCharts("Column2D","600","300");
    $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");
    $strParam="formatNumber=0;";
    $FC->setChartParams($strParam);
    $FC->addChartData(str_replace(",", ".", $Last['Primary']), "name=Первичный");
    $FC->addChartData(str_replace(",", ".", $Last['Secondary']), "name=Вторичный");
    $FC->addChartData(str_replace(",", ".", $Last['Listing']), "name=Листинг");
    $FC->addChartData(str_replace(",", ".", $Last['NonListing']), "name=Нелистинг");
    // Append structured and chart data to the controller
    $Controller->appendVariable("Last", $Last);
    $Controller->appendVariable("LastChart", $FC->renderChart(false, false));
    
     $sql = "SELECT * FROM `mod_trade_last` where period='l'";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $TradeLast = array();
    for ($i=0; $i<$rows; $i++) {
    mysqli_data_seek($result, $i);
    $obj=mysqli_fetch_object($result);
    $TradeLast[$i]['isin'] = $obj->isin;
    $TradeLast[$i]['ShortName'] = $obj->short_name;
    $TradeLast[$i]['NameRus'] = $obj->name_rus;
    $TradeLast[$i]['MaxCost'] = $obj->max_cost;
    $TradeLast[$i]['MinCost'] = $obj->min_cost;
    $TradeLast[$i]['Total_Volume'] = round($obj->total_volume/1000,3);
    $TradeLast[$i]['CountDeal'] = $obj->count_deal;
    $TradeLast[$i]['CountInstr'] = $obj->count_instr;
    }

    $Controller->appendVariable("TradeLast", $TradeLast);
    

    /*
     * For a current week
     */
    $day = date("d");
    $month = date("m");
    $year = date("Y");
    // Calculate date interval for a week ago
    $week_ago = date("Y-m-d", time() - 7 * 3600 * 24);
    $week_interval = date("d/m/Y", time() - 7 * 3600 * 24) . " - " . date("d/m/Y");
    $Controller->appendVariable("week_interval", $week_interval);

    $week_sql = "SELECT
        round (SUM(`total_volume`),4) AS `total_volume`,
        round (SUM(`pervyi`),4) AS `primary`,
        round (SUM(`secondary`),4) AS `secondary`,
        round (SUM(`listing`),4) AS `listing`,
        round (SUM(`non_listing`),4) AS `non_listing`,
        round (SUM(`total_volume_percent`),4) AS `total_volume_percent`,
        round (SUM(`primary_percent`),4) AS `primary_percent`,
        round (SUM(`secondary_percent`),4) AS `secondary_percent`,
        round (SUM(`listing_percent`),4) AS `listing_percent`,
        round (SUM(`non_listing_percent`),4) AS `non_listing_percent`
    FROM `mod_tradestat` WHERE (`full_date`>='" . $week_ago . "')
        ORDER BY `full_date` DESC
    ";

    $week_result = mysqli_query($link, $week_sql);
    $week_rows = mysqli_num_rows($week_result);

    if ($week_rows != 0) {
        $week_obj = mysqli_fetch_object($week_result);
        $Week['TotalVolume'] = $week_obj->total_volume;
        $Week['TotalVolumePercent'] = $week_obj->total_volume_percent;
        $Week['Primary'] = $week_obj->primary;
        $Week['PrimaryPercent'] = $week_obj->primary_percent;
        $Week['Secondary'] = $week_obj->secondary;
        $Week['SecondaryPercent'] = $week_obj->secondary_percent;
        $Week['Listing'] = $week_obj->listing;
        $Week['ListingPercent'] = $week_obj->listing_percent;
        $Week['NonListing'] = $week_obj->non_listing;
        $Week['NonListingPercent'] = $week_obj->non_listing_percent;
        
        $Controller->appendVariable("Week", $Week);
        
     $sql = "SELECT * FROM `mod_trade_last` where period='w'";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);
    $TradeWeek = array();
    for ($i=0; $i<$rows; $i++) {
    mysqli_data_seek($result, $i);
    $wobj=mysqli_fetch_object($result);
    $TradeWeek[$i]['ShortName'] = $wobj->short_name;
    $TradeWeek[$i]['isin'] = $wobj->isin;
    $TradeWeek[$i]['NameRus'] = $wobj->name_rus;
    $TradeWeek[$i]['MaxCost'] = $wobj->max_cost;
    $TradeWeek[$i]['MinCost'] = $wobj->min_cost;
    $TradeWeek[$i]['Total_Volume'] = round($wobj->total_volume/1000,3);
    $TradeWeek[$i]['CountDeal'] = $wobj->count_deal;
    $TradeWeek[$i]['CountInstr'] = $wobj->count_instr;
    }

    $Controller->appendVariable("TradeWeek", $TradeWeek);
        
        
        $sql = "SELECT total_volume, DATE_FORMAT(full_date,'%Y-%m-%d') AS full_date FROM mod_tradestat
            WHERE (full_date>=(SELECT DATE_SUB(CURDATE(), INTERVAL 1 Week)))";

        $result = mysqli_query($link, $sql);
        $rows = mysqli_num_rows($result);
        for ($i=0; $i<$rows; $i++) {
            //smysqli_data_seek($result, $i);
            $wobjChart=mysqli_fetch_object($result);
            $TradeWeekChart[$i]['total_volume'] = $wobjChart->total_volume;
            $TradeWeekChart[$i]['full_date'] = '"' . $wobjChart->full_date . '"';
        }
        $Controller->appendVariable("TradeWeekChart", $TradeWeekChart);

        /*
        
            $FC = new FusionCharts("Column2D","700","300");
        $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");
        $strParam="formatNumber=0;rotateNames=1;showShadow=0;showValues=0;canvasBorderColor=CCCCCC;lineColor=FFA500;showShadow=0;";
        $FC->setChartParams($strParam);
        $sql = "SELECT DATE_FORMAT(`full_date`,'%d-%m-%Y') AS `full_date`,`total_volume` FROM `mod_tradestat`
            WHERE (`full_date`>='" . $week_ago . "')
            ORDER BY `full_date` DESC LIMIT 7
        ";
        $result = mysqli_query($link, $sql);
        $rows = mysqli_num_rows($result);
        for ($i = $rows - 1; $i >= 0; $i--) {
            mysqli_data_seek($result, $i);
            $obj = mysqli_fetch_object($result);
            $FC->addChartData(str_replace(",",".",$obj->total_volume),"color=FFA500; name=" .$obj->full_date); 
        }
        $Controller->appendVariable("WeekChart", $FC->renderChart(false, false));

        */
    }
    

    /*
     * For last month
     */
    $sql = "SELECT
        round (SUM(`total_volume`),4) AS `total_volume`,
        round (SUM(`pervyi`),4) AS `primary`,
        round (SUM(`secondary`),4) AS `secondary`,
        round (SUM(`listing`),4) AS `listing`,
        round (SUM(`non_listing`),4) AS `non_listing`,
        round (SUM(`total_volume_percent`),4) AS `total_volume_percent`,
        round (SUM(`primary_percent`),4) AS `primary_percent`,
        round (SUM(`secondary_percent`),4) AS `secondary_percent`,
        round (SUM(`listing_percent`),4) AS `listing_percent`,
        round (SUM(`non_listing_percent`),4) AS `non_listing_percent`
    FROM `mod_tradestat` WHERE (
    `full_date`>='" . date("Y-m-00", time() - 60 * 60 * 24 * 30) . "'
    AND `full_date`<='" . date("Y-m-00") . "'
    ) ORDER BY `full_date` DESC";
    $Controller->appendVariable("month_name", date("{F}", time() - 60 * 60 * 24 * 30));
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);

    if ($rows != 0) {
        $obj = mysqli_fetch_object($result);
        $Month['TotalVolume'] = $obj->total_volume;
        $Month['TotalVolumePercent'] = $obj->total_volume_percent;
        $Month['Primary'] = $obj->primary;
        $Month['PrimaryPercent'] = $obj->primary_percent;
        $Month['Secondary'] = $obj->secondary;
        $Month['SecondaryPercent'] = $obj->secondary_percent;
        $Month['Listing'] = $obj->listing;
        $Month['ListingPercent'] = $obj->listing_percent;
        $Month['NonListing'] = $obj->non_listing;
        $Month['NonListingPercent'] = $obj->non_listing_percent;
        $Controller->appendVariable("Month", $Month);
        
        
        
        // Month trades chart
        $sql = "SELECT total_volume, DATE_FORMAT(full_date,'%Y-%m-%d') AS full_date FROM mod_tradestat
            WHERE (full_date>=(SELECT DATE_SUB(CURDATE(), INTERVAL 1 Month)))";

        $result = mysqli_query($link, $sql);
        $rows = mysqli_num_rows($result);
        for ($i=0; $i<$rows; $i++) {
            //smysqli_data_seek($result, $i);
            $wobjChart=mysqli_fetch_object($result);
            $TradeWeekChartMonth[$i]['total_volume'] = $wobjChart->total_volume;
            $TradeWeekChartMonth[$i]['full_date'] = '"' . $wobjChart->full_date . '"';
        }
        $Controller->appendVariable("TradeWeekChartMonth", $TradeWeekChartMonth);
    }

    /*
     * For a current year
     */
    /*
    $sql = "SELECT
        SUM(`total_volume`) AS `total_volume`,
        SUM(`primary`) AS `primary`,
        SUM(`secondary`) AS `secondary`,
        SUM(`listing`) AS `listing`,
        SUM(`non_listing`) AS `non_listing`,
        SUM(`total_volume_percent`) AS `total_volume_percent`,
        SUM(`primary_percent`) AS `primary_percent`,
        SUM(`secondary_percent`) AS `secondary_percent`,
        SUM(`listing_percent`) AS `listing_percent`,
        SUM(`non_listing_percent`) AS `non_listing_percent`
    FROM `mod_tradestat` WHERE (`full_date`>='" . date("Y-00-00") . "')";
    */
    $sql = "SELECT
        round (SUM(`total_volume`),4) AS `total_volume`,
        round (SUM(`pervyi`),4) AS `primary`,
        round (SUM(`secondary`),4) AS `secondary`,
        round (SUM(`listing`),4) AS `listing`,
        round (SUM(`non_listing`),4) AS `non_listing`,
        round (SUM(`total_volume_percent`),4) AS `total_volume_percent`,
        round (SUM(`primary_percent`),4) AS `primary_percent`,
        round (SUM(`secondary_percent`),4) AS `secondary_percent`,
        round (SUM(`listing_percent`),4) AS `listing_percent`,
        round (SUM(`non_listing_percent`),4) AS `non_listing_percent`
    FROM `mod_tradestat` WHERE (`full_date`>='" . date("Y-00-00") . "')";
    $result = mysqli_query($link, $sql);
    $rows = mysqli_num_rows($result);

    if ($rows != 0) {
        $obj = mysqli_fetch_object($result);
        $Year['TotalVolume'] = $obj->total_volume;
        $Year['TotalVolumePercent'] = $obj->total_volume_percent;
        $Year['Primary'] = $obj->primary;
        $Year['PrimaryPercent'] = $obj->primary_percent;
        $Year['Secondary'] = $obj->secondary;
        $Year['SecondaryPercent'] = $obj->secondary_percent;
        $Year['Listing'] = $obj->listing;
        $Year['ListingPercent'] = $obj->listing_percent;
        $Year['NonListing'] = $obj->non_listing;
        $Year['NonListingPercent'] = $obj->non_listing_percent;
        $Controller->appendVariable("Year", $Year);
        

        // Annual trades chart
        $FC = new FusionCharts("Column2D","700","300");
        $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");
        $strParam="formatNumber=0;rotateNames=1;showShadow=0;showValues=0;canvasBorderColor=CCCCCC;showNames=1;lineColor=FFA500;showShadow=0;showAnchors=0";
        $FC->setChartParams($strParam);

       /* $sql = "SELECT SUM(`total_volume`) AS `total_volume`,DATE_FORMAT(`full_date`,'%M, %Y') AS `full_date` FROM `mod_tradestat`
            WHERE (`full_date`>=(SELECT DATE_SUB(CURDATE(), INTERVAL 1 YEAR)))  GROUP BY `month`";*/
        $sql = "SELECT SUM(`total_volume`) AS `total_volume`,DATE_FORMAT(`full_date`, '%M') AS `full_date` FROM `mod_tradestat`
            WHERE (`full_date`>='" . date("Y-00-00") . "')  GROUP BY `month`, `full_date`";
        $result = mysqli_query($link, $sql);
        $rows = mysqli_num_rows($result);

        for ($i = 0; $i < $rows; $i++) {
            mysqli_data_seek($result, $i);
            $obj = mysqli_fetch_object($result);
            $FC->addChartData(str_replace(",",".",$obj->total_volume),"color=FFA500;name={" . $obj->full_date . "}"); 
        }

        $Controller->appendVariable("YearChart", $FC->renderChart(false, false));
        $Controller->appendVariable("YearName", date("Y"));
    }
    return $Controller;
}

?>
