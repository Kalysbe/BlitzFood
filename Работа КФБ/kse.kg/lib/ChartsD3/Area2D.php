<?php
class Area2D { 

	private $width;
	private $height;
	private $data;
	
	private $areaFill;
	private $areaStrokeFill;
	private $areaStrokeWidth;
	private $ElAttr;
	private $TypeAttr;
	private $opacity;
	private $lAxEnable;
	private $bAxEnable;
	private $gridEnable;
	
	private $code;
	
	function __construct($w,$h)
	{
		$this->width  = $w;
		$this->height = $h;
		$this->data = '[]';
		
		$this->areaFill  = '#30c8ca';
		$this->areaStrokeFill  = 'none';
		$this->areaStrokeWidth = 2;
		$this->ElAttr = '';
		$this->TypeAttr = '';
		$this->opacity = 1;
		
		$this->lAxEnable = true;
		$this->bAxEnable = true;
		$this->gridEnable = true;
	}
	
	function setIdAttr($c) { 
		if ($this->TypeAttr == 'class')
			$this->ElAttr = '.'.$c;
		else if ($this->TypeAttr == 'id')
			$this->ElAttr = '#'.$c;
	}
	
	function setStrokeWidth($p) { $this->areaStrokeWidth = $p; }
	
	function setAreaFill($p) { $this->areaFill = $p; }
	
	function setStrokeFill($p) { $this->areaStrokeFill= $p; }
	
	function setWidth($p) { $this->width = $p; }
	
	function setHeight($p) { $this->height = $p; }
	
	
	function setParameters($param) 
	{	
		if (!empty($param['areaFill']))
			$this->areaFill = $param['areaFill'];
		
		if (!empty($param['areaStrokeFill']))
			$this->areaStrokeFill = $param['areaStrokeFill'];
		
		if (!empty($param['areaStrokeWidth']))
			$this->areaStrokeWidth = $param['areaStrokeWidth'];
		
		if (!empty($param['TypeAttr']))
			$this->TypeAttr = $param['TypeAttr'];
		
		if (!empty($param['ElAttr'])){
			if ($this->TypeAttr == 'class')
				$this->ElAttr = '.'.$param['ElAttr'];
			else if ($this->TypeAttr == 'id')
				$this->ElAttr = '#'.$param['ElAttr'];
			else $this->ElAttr = $param['ElAttr'];
		}
		
		if (!empty($param['opacity']))
			$this->opacity = $param['opacity'];
		
		if (array_key_exists('leftAxis',$param))
			$this->lAxEnable = $param['leftAxis'];
	
		if (array_key_exists('grid',$param))
			$this->gridEnable = $param['grid'];
		
		if (array_key_exists('bottomAxis',$param))
			$this->bAxEnable = $param['bottomAxis'];
	}
	
	
	
	function addData($data) 
	{
		$this->parseData($data);
	}
	
	function parseData($data) 
	{
		if (empty($data)) 
			$this->data = '[]';
		else 
		{	
			
			$this->data = '[ ';
			foreach ($data as $d)
				$this->data .= "{ x: new Date(d3.timeParse('" .$d['x'] ."')) , y: ". $d['y']. " } ,\n";
			$this->data = substr_replace($this->data, "];" , -2, 2);
		}
		
	}
	
	function getCode() 
	{ 
		$this->createArea();
		return $this->code;
	}
	
	function createArea()
	{
		$this->code = <<< JS
	<script>
	
	var data = $this->data

	var left = 120; 
	var bottom = 30;
	var width = $this->width - left * 2;
	var height = $this->height - bottom * 2;

	//var timeFormat = d3.timeFormat("%d.%m.%Y");
	
	var x = d3.scaleTime()
		.range([5, width]);
		
	var y = d3.scaleLinear()
		.range([height,0]);
	
	var line = d3.line()
		.x(function(d) {
			return x(d.x);
		})
		.y(function(d) {
			return y(d.y);
		})
		.defined(function(d) { return d;});
	

	var area1 = d3.area()
		.x(function(d) {
			return x(d.x);
		})
		.y1(function(d) {
			return y(d.y);
		})
		.defined(function(d) { return d;})
		
		
		x.domain(d3.extent(data, function(d) { return d.x;  } ));
		y.domain([0, d3.max(data,function(d) { return d.y; }) ]);
		area1.y0(y(0));
		

	
	var svg = d3.select('$this->ElAttr')
		.append('svg')
		.attr('width',width +(left*2))
		.attr('height',height +(bottom*2));
	
	
	var g = svg.append('g')
			.attr('transform','translate(' +left+','+bottom+')')
			;
JS;
if ($this->gridEnable == true)
		$this->code .=<<<CODE
	
		for (l=height-35;l>0;l -= 35) {
		g.append('line')
			.attr('x1',0)
			.attr('x2',width)
			.attr('y1',l)
			.attr('y2',l)
			.attr('stroke','gray')
			.attr('opacity',0.5);
		}
CODE;
	$this->code .= <<< JS
		g.append('path')
			.datum(data)
			.attr('d',area1)
			.attr('fill','$this->areaFill')
			//.attr('stroke','$this->areaStrokeFill')
			.attr('stroke-width',$this->areaStrokeWidth)
			.attr('opacity',$this->opacity)
			;
		g.append('path')
			.datum(data)
			.attr('d',line(data))
			.attr('stroke','$this->areaStrokeFill')
			.attr('stroke-width',$this->areaStrokeWidth)
			.attr('fill','none');
JS;
	if ($this->bAxEnable == true )
		$this->code .= <<<CODE
		g.append('g')
			.attr('transform','translate(0,'+height+')')
			.attr('class','x-axis')
			.call(d3.axisBottom(x).ticks(8))
			;
CODE;
	if ($this->lAxEnable == true)
		$this->code .= <<<CODE
		g.append('g')
			.attr('class','y-axis')
			.call(d3.axisLeft(y)
			)
			;
CODE;
	
	$this->code .= <<<JS
		g.select('.x-axis')
			.selectAll('.tick')
			.select('text')
			.attr('y','15')
			.style('font-size',12);
		
	</script>
JS;
		
	}

}
?>