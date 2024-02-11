<?php


function FastChart_getModuleBuffer() {
	
	$link = MainClass::getSingleton()->getDbConnection();	
    $sql = "SELECT `date`,`index` FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 365";
    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;
    
	$jslib = "<div><div id='index_chart'></div><div id='cap_chart'></div></div>";
	
	$indexChart = <<< JS
		<script>
		google.charts.load('current',{'packages':['corechart'],'language':'ru'});
		google.charts.setOnLoadCallback(function(){
			indexChart();
			capChart();
		});
		
		function indexChart() {
		
		var data = new google.visualization.DataTable();
  
		data.addColumn('date','Дата');
		data.addColumn('number','Индекс');
		
		data.addRows([
		
JS;
	
	for ($i = 0; $i < $rows; $i++) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
        /*if (isset($Index[$i-1])&&($Index[$i - 1] == $obj->index))
                $Index[$i] = 0;
        else*/
        $indexChart .= "[new Date('".$obj->date."'),".$obj->index."],\n";
        //$Capitalization[$i] = round($obj->capitalization);
        
    }
	
	$indexChart = substr_replace($indexChart,'',-2,2);
	$indexChart .= "])\n;";
	
	$indexChart .= <<<JS
		var options = {
  	title : 'Индекс за текущий год',
	legeng: {position: "none"},
	titleTextStyle: {color: 'gray'},
    width : 200,
    height: 180,
	vAxis : {minValue: 0},
	explorer : {maxZoomIn: 3,maxZoomOut: 1,keepInBounds: true}
	
  };
  
  var chart = new google.visualization.AreaChart(document.getElementById('index_chart'));
      chart.draw(data, options);
  
	chart.draw(data,options); }
	
JS;
	
    $cur_year = date("Y");

    $capChart = <<<JS
	function capChart() {
		
		var data = new google.visualization.DataTable();
  
		data.addColumn('date','Дата');
		data.addColumn('number','Капитализация');
		
		data.addRows([
JS;
    $sql = "SELECT `date`,`capitalization` FROM `mod_cap_index` ORDER BY `date` DESC LIMIT 365";
    $result = mysqli_query($link, $sql);
    $rows = $result->num_rows;
    
	for ($i = 0; $i < $rows; $i = $i + 30) {
        mysqli_data_seek($result, $i);
        $obj = mysqli_fetch_object($result);
       
	   $capChart .= "[new Date('".$obj->date."'),".(round($obj->capitalization)/1000000)."],\n";
    }
	
	$capChart = substr_replace($capChart,'',-2,2);
	$capChart .= "])\n;";
	
	$capChart .= <<<JS
		var options = {
  	title : 'Капитализация за текущий год',
	titleTextStyle:  {color: 'gray'},
	fontSize: "10px",
	legeng: {position: "none"},
    width : 200,
    height: 180,
	vAxis : {minValue: 0,format: 'short'},
	explorer : {maxZoomIn: 3,maxZoomOut: 1,keepInBounds: true}
	
  };
  
  var chart = new google.visualization.AreaChart(document.getElementById('cap_chart'));
      chart.draw(data, options);
  
	chart.draw(data,options); }
	</script>
JS;
    
    return  $jslib.$indexChart.$capChart."<p align=\"center\"><small>{vmlnsom}</small></p>";
}

?>
