<?php

$Module = "IndexAndCapitalization";

define("ONEDAY", 1);
define("PERIOD", 2);
define("LAST", 3);

class IndexAndCapitalization {
    private $index_query;
    private $capitalization_query;
    private $rows;
    private $oneday_index;    // Will display in table
    private $oneday_capitalization;
    private $oneday_date;
    private $period_index;    // Array of data for period
    private $period_capitalization;
    private $query;
    private $index_chart_param;
    private $cap_chart_param;

    public function __construct($last = true) {
        $this->period_index = array();
        $this->period_capitalization = array();
        $this->buildLastQuery();
        $this->index_chart_param = "caption={index};decimalPrecision=0;formatNumberScale=0;rotateNames=1;showValues=1;showAnchors=0;lineColor=FFA500;showShadow=0;yAxisMaxValue=140;";
        $this->cap_chart_param = "caption={capitalization};decimalPrecision=0;formatNumberScale=0;rotateNames=1;showValues=0;areaBorderColor=FFA500;areaBgColor=FFE7BB;showShadow=0;yAxisMaxValue=140;";

    }

    public function setDatePeriod($from, $to) {
		
		$link = MainClass::getSingleton()->getDbConnection();
		$from = mysqli_real_escape_string($link, trim($from));
        $to = mysqli_real_escape_string($link, trim($to));

        if ($from == "") {
            return LAST;
        }
        if ($to == "")
            $to = $from;

        if ($from == $to) {
            $this->index_query = "SELECT `date`, `index` FROM `mod_cap_index` WHERE (`date`='" . $to . "') ORDER BY `date` DESC";
            return ONEDAY;
        } elseif (str_replace("-", "", $from) > str_replace("-", "", $to)) {
            MainClass::getSingleton()->appendError("{BadIndexPeriod}");
            $this->buildLastQuery();
            return LAST;
        } elseif (str_replace("-", "", $from) < str_replace("-", "", $to)) {
            $this->index_query = "SELECT `date`, `index` FROM `mod_cap_index`
                WHERE (`date`>='" . $from . "' AND `date`<='" . $to . "') ORDER BY `date` DESC";
            return PERIOD;
        }
    }

    public function calculateIndex() {
		$link = MainClass::getSingleton()->getDbConnection();
		$result = mysqli_query($link, $this->index_query);
        $this->rows = mysqli_num_rows($result);
        if ($this->rows == 0) {
            
        } else {
            for ($i = 0; $i < $this->rows; $i++) {
                mysqli_data_seek($result, $i);
                $obj = mysqli_fetch_object($result);
                if ($i == 0) {
                    $this->oneday_index = $obj->index;
                    //$this->oneday_capitalization = $obj->capitalization;
                    $this->oneday_date = $obj->date;
                }
                $this->period_index[$i]['index'] = $obj->index;
                //$this->period[$i]['capitalization'] = $obj->capitalization;
                $this->period_index[$i]['date'] = $obj->date;
            }
        }
    }

    public function buildLastQuery() {
        $this->index_query = "SELECT `date`,`index` FROM `mod_cap_index`
             ORDER BY `date` DESC LIMIT 30";
        $this->capitalization_query = "SELECT `date`,`capitalization` FROM
            `mod_cap_index` ORDER BY `date` DESC LIMIT 365";
    }

    public function calculateCapitalization() {
		$link = MainClass::getSingleton()->getDbConnection();
        $result = mysqli_query($link, $this->capitalization_query);
        $rows = mysqli_num_rows($result);
        if ($rows == 0) {

        } else {
            for ($i = 0; $i < $rows; $i++) {
                mysqli_data_seek($result, $i);
                $obj = mysqli_fetch_object($result);
                if ($i == 0) {
                    $this->oneday_capitalization = $obj->capitalization;
                }
                $this->period_capitalization[$i]['capitalization'] = $obj->capitalization;
                $this->period_capitalization[$i]['date'] = $obj->date;
            }
        }
    }

    public function getSingleIndex() {
        return $this->oneday_index;
    }

    public function getSingleCapitalization() {
        return $this->oneday_capitalization;
    }

    public function getSingleDate() {
        return $this->oneday_date;
    }

    public function getIndexArray() {
        return $this->period_index;
    }

    public function getCapitalizationArray() {
        return $this->period_capitalization;
    }

    public function getIndexChartParameters() {
        return $this->index_chart_param;
    }

    public function getCapChartParameters() {
        return $this->cap_chart_param;
    }
};

function IndexAndCapitalization_loadController() {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/FusionCharts/Includes/FusionCharts_Gen.php");
    $Controller = new ControllerClass();
    $Uri = MainClass::getSingleton()->getFullUriPath();

    $Controller->appendVariable("ControllerInclusion", "modules/IndexAndCapitalization/IndexAndCapitalization.html");

    $icap = new IndexAndCapitalization();
    if (isset($_POST["doByDate"])) {
        $icap->setDatePeriod($_POST["IndexDateFrom"], $_POST["IndexDateTo"]);
    }
    $icap->calculateIndex();
    $icap->calculateCapitalization();
    $Controller->appendVariable("IndexDate", $icap->getSingleDate());
    $Controller->appendVariable("IndexValue", round($icap->getSingleIndex(), 4));
    $Controller->appendVariable("CapitalizationValue", round($icap->getSingleCapitalization() / 1000000, 2));

    $FC = new FusionCharts("Line","700","300");
    $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");
    $FC->setChartParams($icap->getIndexChartParameters());

    foreach(array_reverse($icap->getIndexArray()) as $k=>$v) {
        $FC->addChartData($v['index'], "name=" . $v['date']);
    }

    $Controller->appendVariable("IndexChart", $FC->renderChart(false, false));

    $FC = new FusionCharts("Area2D","700","300");
    $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");
    $FC->setChartParams($icap->getCapChartParameters());

    $i = 0;
    foreach(array_reverse($icap->getCapitalizationArray()) as $k=>$v) {
        $i++;
        if ($i >= 30) {
            $FC->addChartData($v['capitalization'], "name=" . $v['date']);
            $i = 0;
        }
    }

    $Controller->appendVariable("CapitalizationChart", $FC->renderChart(false, false));

    /*
    // Check if user requests to display data for choosen period
    if (isset($_POST["doByDate"])) {
        MainClass::getSingleton()->appendError("Сервис временно недоступен");
        if (($_POST["IndexDateFrom"] != "")&&($_POST["IndexDateTo"] != "")) {
            $today = date("Y-m-d");

            $by_date = true;
        }
    }

    // In case we won't display data by period we're display data for
    // present day
    if (!isset($by_date)) {
        $sql = "SELECT * FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 1";
        $result = mysql_query($sql);

        $obj = mysql_fetch_object($result);
        $Controller->appendVariable("IndexDate", $obj->date);
        $Controller->appendVariable("IndexValue", round($obj->index, 1) );
        $Controller->appendVariable("IndexCapitalization", round($obj->capitalization / 1000000, 1));
    } else {
        $sql = "SELECT * FROM `mod_cap_index` WHERE(`date`>'" .
        $_POST["IndexDateFrom"] . "' AND `date`<'" .
        $_POST["IndexDateTo"] . "') ORDER BY `date` DESC LIMIT 1";
        $result = mysql_query($sql);

        $obj = mysql_fetch_object($result);
        $Controller->appendVariable("IndexDate", $obj->date);
        $Controller->appendVariable("IndexValue", round($obj->index, 1) );
        $Controller->appendVariable("IndexCapitalization", round($obj->capitalization / 1000000, 1));
    }
    */
    /*
     * Preparing graph
     */
    /*
    if (!isset($by_date))
        $sql = "SELECT `date`,`index` FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 30";
    else {
        $sql = "SELECT `date`,`index` FROM `mod_cap_index` WHERE(`date`>'" .
        $_POST["IndexDateFrom"] . "' AND `date`<'" .
        $_POST["IndexDateTo"] . "') ORDER BY `date`";
    }
    $result = mysql_query($sql);
    $rows = mysql_num_rows($result);
    $Index = array();
    $Date = array();
    for ($i = 0; $i < $rows; $i++) {
        mysql_data_seek($result, $i);
        $obj = mysql_fetch_object($result);
        //if (isset($Index[$i-1])&&($Index[$i - 1] == $obj->index))
        //        $Index[$i] = 0;
        //else
        $Index[$i] = $obj->index;
        //$Capitalization[$i] = round($obj->capitalization);
        $Date[$i] = $obj->date;
    }

    if (!isset($by_date)) {
        $Index = array_reverse($Index);
        $Date = array_reverse($Date);
    }
    

    $Controller->appendVariable("IndexValues", implode(",", $Index));
    $Controller->appendVariable("IndexDates", implode(",", $Date));


    require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/FusionCharts/Includes/FusionCharts_Gen.php");

    $FC = new FusionCharts("Line","700","300");

    # Setting Relative Path of chart swf file.
    $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");

    # Store chart attributes in a variable
    $strParam="caption=Индекс;decimalPrecision=0;formatNumberScale=0;rotateNames=1;showValues=1;showAnchors=0;lineColor=FFA500;showShadow=0;yAxisMaxValue=140;";

    # Set chart attributes
    $FC->setChartParams($strParam);

    foreach($Index as $k=>$v) {
        $FC->addChartData($v, "name=".$Date[$k]);
    }

    # Render chart
    $Controller->appendVariable("IndexChart", $FC->renderChart(false, false));
    if (!isset($by_date))
        $sql = "SELECT `date`,`capitalization` FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 365";
    else {
        $sql = "SELECT `date`,`capitalization` FROM `mod_cap_index` WHERE(`date`>'" .
        $_POST["IndexDateFrom"] . "' AND `date`<'" .
        $_POST["IndexDateTo"] . "') ORDER BY `date`";
    }
    $result = mysql_query($sql);
    $rows = mysql_num_rows($result);
    $Capitalization = array();
    for ($i = 0; $i < $rows; $i = $i + 30) {
        mysql_data_seek($result, $i);
        $obj = mysql_fetch_object($result);
        //if (isset($Index[$i-1])&&($Index[$i - 1] == $obj->index))
        //        $Index[$i] = 0;
        //else
        //        $Index[$i] = $obj->index;
        $Capitalization[$i] = round($obj->capitalization);
        $Date[$i] = $obj->date;
    }
    if (!isset($by_date)) {
        $Capitalization = array_reverse($Capitalization);
        $Date = array_reverse($Date);
    }

    $FC = new FusionCharts("Area2D","700","300");

    # Setting Relative Path of chart swf file.
    $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");

    # Store chart attributes in a variable
    $strParam="caption=Капитализация;decimalPrecision=0;formatNumberScale=0;rotateNames=1;showValues=0;areaBorderColor=FFA500;areaBgColor=FFE7BB;showShadow=0;yAxisMaxValue=140";

    # Set chart attributes
    $FC->setChartParams($strParam);

    foreach($Capitalization as $k=>$v) {
        $FC->addChartData($v, "name=".$Date[$k]);
    }

    # Render chart
    $Controller->appendVariable("CapitalizationChart", $FC->renderChart(false, false));
    */
    return $Controller;
}

?>
