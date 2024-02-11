<?php

require "Line2D.php";
require "Area2D.php";

class D3Charts {

	private $graph;
	
	function __construct($g,$w,$h)
	{
		switch ($g) 
		{
			case "Line" : $this->graph = new Line2D($w,$h);
			break;
			
			case "Area":  $this->graph = new Area2D($w,$h);
			break;
			
			default : $graph = NULL;
		}
	}
	
	function __destruct() { $this->graph = NULL; }
	
	
	function addChartData($data)  {		$this->graph->addData($data); 			}
	
	function setChartParam($param){		$this->graph->setParameters($param);	}
	
	function renderChart()		  {		return $this->graph->getCode();			}
	
}


?>