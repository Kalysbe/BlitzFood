<?php

class Line2D {
	
	private $width;
	private $height;
	private $data;
	
	private $lineFill;
	private $lineStrokeFill;
	private $lineStrokeWidth;
	private $timeFormat;
	private $opacity; 
	private $lAxEnable;
	private $bAxEnable;
	private $gridEnable;
	
	private $ElAttr;
	private $TypeAttr;
	private $code;
	
	function __construct($w,$h)
	{
		$this->width  = $w;
		$this->height = $h;
		$this->data = '[]';
		
		$this->lineFill  = 'black';
		$this->lineStrokeFill  = 'none';
		$this->lineStrokeWidth = 2;
		$this->ElAttr = '';
		$this->TypeAttr = '';
		$this->opacity = 1;
		$this->lAxEnable = true;
		$this->bAxEnable = true;
		$this->gridEnable = true;
		$this->timeFormat = "d3.timeFormat(%d.%m.%Y)";
	}
	
	// Setters
	
	function setIdAttr($c) { 
		if ($this->TypeAttr == 'class')
			$this->ElAttr = '.'.$c;
		else if ($this->TypeAttr == 'id')
			$this->ElAttr = '#'.$c; }
	
	function setStrokeWidth($p) { $this->lineStrokeWidth = $p; }
	
	function setLineFill($p) { $this->lineFill = $p; }
	
	function setStrokeFill($p) { $this->lineStrokeFill= $p; }
	
	function setWidth($p) { $this->width = $p; }
	
	function setHeight($p) { $this->height = $p; }
	
	function setParameters($param) 
	{	
		if (!empty($param['lineFill']))
			$this->lineFill = $param['lineFill'];
		
		if (!empty($param['lineStrokeFill']))
			$this->lineStrokeFill = $param['lineStrokeFill'];
		
		if (!empty($param['lineStrokeWidth']))
			$this->lineStrokeWidth = $param['lineStrokeWidth'];
		
		if (!empty($param['TypeAttr']))
			$this->TypeAttr = $param['TypeAttr'];
		
		if (!empty($param['ElAttr'])) {
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
			$this->data = substr_replace($this->data, "];" , -2, 3);
		}
		
	}
	
	function createLine() {
		$this->code = <<<CODE
	<script>	
	var data = $this->data

	var left = 80;
	var bottom = 40;
	var width = $this->width - left*2;
	var height = $this->height - bottom*2;
 
	//var tF = d3.timeFormat("%d.%m.%Y");

	var x = d3.scaleTime()
		.domain([ 
			d3.min(data,function(d) {  return d.x; }),
			d3.max(data,function(d) {  return d.x; })
		])
		.range([5, width]);

	var line = d3.line()
		.x(function(d) {
			return x(d.x);
		})
		.y(function(d) {
			return y(d.y);
		})
		.defined(function(d) { return d;});
	
	
	var y = d3.scaleLinear()
		.domain([
			0,
			d3.max(data,function(d) {  return d.y; })
		,])
		.range([height,0]);
	
	var svg = d3.select('$this->ElAttr')
		.append('svg')
		.attr('width',width +(left*2))
		.attr('height',height +(bottom*2));
	
	
	
	
	var g = svg.append('g')
			.attr('transform','translate(' +left+','+bottom+')')

			
g.selectAll('rect')
			.data(data)
			.enter()
			.append('rect')
			.attr('x',function(d) { return x(d.x) -2.5; })
			.attr('y',function(d) { return y(d.y) - 3.5; })
			.attr('width',5)
			.attr('height',7)
			.attr('fill','teal')
			;
CODE;
	if ($this->gridEnable == true)
		$this->code .=<<<CODE
	
		for (l=height-35;l>0;l -= 35) {
		g.append('line')
			.attr('x1',0)
			.attr('x2',width)
			.attr('y1',l)
			.attr('y2',l)
			.attr('stroke','gray')
			.attr('opacity',0.7);
		}
CODE;

$this->code .=<<<CODE
		
		g.append('path')
			.attr('d',line(data))
			.attr('fill','$this->lineFill')
			.attr('stroke','$this->lineStrokeFill')
			.attr('stroke-width',$this->lineStrokeWidth)
			;
CODE;
	if ($this->bAxEnable == true)
		$this->code .=<<<CODE
	
		g.append('g')
			.attr('transform','translate(0,'+height+')')
			.attr('class','x-axis')
			.call(d3.axisBottom(x))
			.append('text')
			.text(function(d) { return d} )
				;
CODE;
	if ($this->lAxEnable == true)
		$this->code .=<<< CODE
	
		g.append('g')
			.attr('class','y-axis')
			.call(d3.axisLeft()
				.scale(y))
			;
CODE;
$this->code .= <<< CODE
		
		g.select('.x-axis')
			.selectAll('.tick')
			.select('text')
			.attr('y','20')
			.attr('transform','rotate(-40)')
			.style('font-size',12);

		</script>
CODE;
	}
	
	
	function getCode() 
	{ 
		$this->createLine();
		return $this->code;
	}

}

?>