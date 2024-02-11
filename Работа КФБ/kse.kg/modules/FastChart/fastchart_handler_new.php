<?php


function FastChart_getModuleBuffer() {
	$link = MainClass::getSingleton()->getDbConnection();	
    $sql = "SELECT `date`,`index` FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 365";
    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;
    for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        /*if (isset($Index[$i-1])&&($Index[$i - 1] == $obj->index))
                $Index[$i] = 0;
        else*/
                $Index[$i] = $obj->index;
        //$Capitalization[$i] = round($obj->capitalization);
        $Date[$i] = $obj->date;
    }

    $cur_year = date("Y");

    $Index = array_reverse($Index);
    $Date = array_reverse($Date);

    /*require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/FusionCharts/Includes/FusionCharts_Gen.php");

    $FC = new FusionCharts("Line","200","180");

    # Setting Relative Path of chart swf file.
    $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");

    # Store chart attributes in a variable
    $strParam=" caption={indexfor} " . $cur_year . " {god};decimalPrecision=0;formatNumberScale=0;rotateNames=1;showValues=0;showNames=0;showLimits=0;canvasBorderColor=CCCCCC;showAnchors=0;lineColor=FFA500;showShadow=0;yAxisMaxValue=140;numdivlines=5";

    # Set chart attributes
    $FC->setChartParams($strParam);

    foreach($Index as $k=>$v) {
        $FC->addChartData($v, "name=".$Date[$k]);
    }


    # Render chart
    $index_chart = $FC->renderChart(false, false);*/
	
	//------- D3 Charts
	#--------------------------------------------------
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/ChartsD3/D3Charts.php");
	
	#---------------------------------------------------------
	$lineParam = Array(							# Line Chart parameters
	"lineStrokeFill" => "orange",
	"lineFill" => "none",
	"lineStrokeWidth" => 2,
	"ElAttr" => 'indices',
	"TypeAttr" => 'class',
	"grid" => true,
	"bottomAxis" =>false
	);
	
	#---------------------------------------------------------
	$areaParam = Array(							# Area Chart parameters
	"areaFill" => "#10b2f3",
	"areaStrokeWidth" => 2.5,
	"idAttr" => 'Area2D305Div',
	"areaStrokeFill" => "#0a7fb9",
	"opacity" => 0.3,
	"grid" => false
	);
	
	#---------------------------------------------------------
	$chart = new D3Charts("Line",200,180);			# Create Line Chart
	$chart->setChartParam($lineParam);

	$data = array();
	
	for($i=0; $i < count($Date); $i++)
	{
		$data[$i]['x'] = $Date[$i];
		$data[$i]['y'] = $Index[$i];
	}
	
	$chart->addChartData($data);
	
   $index_chart = $chart->renderChart();
	
	#-----------------------------------------------------------------	
    $sql = "SELECT `date`,`capitalization` FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 365";
    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;
    for ($i = 0; $i < $rows; $i = $i + 30) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        /*if (isset($Index[$i-1])&&($Index[$i - 1] == $obj->index))
                $Index[$i] = 0;
        else*/
        //        $Index[$i] = $obj->index;
        $Capitalization[$i] = round($obj->capitalization);
        $Date[$i] = $obj->date;
    }
    $Capitalization = array_reverse($Capitalization);
    $Date = array_reverse($Date);
	
	#-------------------------------------------------------
	/*	
	$chart = new D3Charts("Area",200,180);			# Create Area Chart
	$chart->setChartParam($areaParam);

	$data = array();
	
	for($i=0;$i<$rows;$i++)
	{
		$data[$i]['x'] = $Date[$i];
	}
	for($i=0;$i<count($Capitalization);$i++)
		$data[$i]['y'] =  $Capitalization[$i];
	
	$chart->addChartData($data);
	$cap_chart = $chart->renderChart();*/
		
	//----------------------------------
	
    /*$FC = new FusionCharts("Area2D","200","180");

    # Setting Relative Path of chart swf file.
    $FC->setSwfPath(MainClass::getSingleton()->getSiteVar("%ROOT%") . "/lib/FusionCharts/Charts/");

    # Store chart attributes in a variable
    $strParam="caption={capitalizationfor} " . $cur_year . " {yearz};decimalPrecision=0;formatNumberScale=0;rotateNames=1;showValues=0;showNames=0;canvasBorderColor=CCCCCC;showAnchors=0;areaBorderColor=FFA500;areaBgColor=FFE7BB;showShadow=0";

    # Set chart attributes
    $FC->setChartParams($strParam);

    foreach($Capitalization as $k=>$v) {
        $FC->addChartData(round($v / 1000000), "name=".$Date[$k]);
    }

    # Render chart
    $cap_chart = $FC->renderChart(false, false);*/
    return $index_chart ."<p align=\"center\"><small>{vmlnsom}</small></p>";
	}

?>
