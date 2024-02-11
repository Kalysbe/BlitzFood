<?php

/* modules/IndexAndCapitalization/IndexAndCapitalization.html */
class __TwigTemplate_9157d496cbf8e97e33ddb7962d9669c8 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "﻿<link rel=\"stylesheet\" type=\"text/css\" href=\"https://www.kse.kg/views/kse/styles/chart.css\">
<script src=\"https://www.kse.kg/views/kse/js/chart.js\"></script>
<script src=\"https://www.kse.kg/views/kse/js/chart_1.js\"></script>
<style type=\"text/css\">
    .amcharts-chart-div a {
        display: none!important;
    }
</style>
<h2 style=\"float: left;\">";
        // line 9
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "indexcapitalization", array(), "array");
        echo "</h2>

<div id=\"DatePicker\" style=\"width: 300px; float: right; margin: 0px; text-align: right;\">
    <h3>";
        // line 12
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{ForPeriod}", array(), "array");
        echo "</h3>
    <form action=\"\" method=\"POST\">
        ";
        // line 14
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{PeriodFrom}", array(), "array");
        echo ": <input type=\"text\" name=\"IndexDateFrom\" id=\"IndexDateFrom\" value=\"\" /><br /> ";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{PeriodTo}", array(), "array");
        echo ": <input type=\"text\" name=\"IndexDateTo\" id=\"IndexDateTo\" value=\"\" /><br />
        <input type=\"submit\" name=\"doByDate\" value=\"Показать\" />
    </form>
    <script type=\"text/javascript\">
        \$(\"#IndexDateFrom\").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        \$(\"#IndexDateTo\").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        \$(\"input:submit\").button();
    </script>
</div>

<br /><br />
<table width=\"400px\" class=\"class1\" style=\"margin-top: 50px; margin-bottom: 50px;\">
    <tr>
        <th class=\"date_cap\">";
        // line 31
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "indexon", array(), "array");
        echo " ";
        echo (isset($context['IndexDate']) ? $context['IndexDate'] : null);
        echo "</th>
        <th>&nbsp;</th>
    </tr>
    <tr class='index'>
        <td>";
        // line 35
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{index}", array(), "array");
        echo "</td>
        <td>";
        // line 36
        echo (isset($context['IndexValue']) ? $context['IndexValue'] : null);
        echo "</td>
    </tr>
    <tr class=\"capitalization\">
        <td>";
        // line 39
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{capitalizationMlnsom}", array(), "array");
        echo "</td>
        <td>";
        // line 40
        echo (isset($context['CapitalizationValue']) ? $context['CapitalizationValue'] : null);
        echo "</td>
    </tr>
</table>
<div id=\"IndexChart\" style=\"height:300px; width: 600px\"></div>
<div id=\"CapitalizationChart\">
    ";
        // line 45
        echo (isset($context['CapitalizationChart']) ? $context['CapitalizationChart'] : null);
        echo "
</div>
";
        // line 67
        echo "

<script type=\"text/javascript\">
    var chartData = [
    \t";
        // line 71
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['IndexChart']) ? $context['IndexChart'] : null));
        $countable = is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable);
        $length = $countable ? count($context['_seq']) : null;
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if ($countable) {
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context['_key'] => $context['IndexChart']) {
            echo " {
            \"date\": ";
            // line 72
            echo $this->getAttribute((isset($context['IndexChart']) ? $context['IndexChart'] : null), "x", array(), "array");
            echo ",
            \"latitude\": ";
            // line 73
            echo $this->getAttribute((isset($context['IndexChart']) ? $context['IndexChart'] : null), "y", array(), "array");
            echo ",
            \"distance\": ";
            // line 74
            echo $this->getAttribute((isset($context['IndexChart']) ? $context['IndexChart'] : null), "y", array(), "array");
            echo "
        },
        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if ($countable) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['IndexChart'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 76
        echo "

    ]; // График постороенный за месяц (индекс)

    var chart = AmCharts.makeChart(\"IndexChart\", {
        type: \"serial\",
        dataDateFormat: \"YYYY-MM-DD\",
        dataProvider: chartData,

        addClassNames: true,
        startDuration: 1,
        color: \"#909090\",
        marginLeft: 0,

        categoryField: \"date\",
        categoryAxis: {
            parseDates: true,
            minPeriod: \"DD\",
            autoGridCount: false,
            gridCount: 50,
            gridAlpha: 0.1,
            dateFormats: [{
                period: 'DD',
                format: 'DD'
            }, {
                period: 'WW',
                format: 'MMM DD'
            }, {
                period: 'MM',
                format: 'MMM'
            }, {
                period: 'YYYY',
                format: 'YYYY'
            }]
        },

        valueAxes: [{
            id: \"a1\",
            title: \"Индекс\",
            gridAlpha: 0,
            axisAlpha: 0
        }, {
            id: \"a2\",
            position: \"right\",
            gridAlpha: 0,
            axisAlpha: 0,
            labelsEnabled: false
        }],
        graphs: [{
            id: \"g1\",
            valueField: \"distance\",
            title: \"distance\",
            valueAxis: \"a1\",
            lineColor: \"#fff\",
            bulletColor: \"#fff\",
            bulletBorderColor: \"#ff\",
            alphaField: \"alpha\"
        }, {
            id: \"g2\",
            valueField: \"latitude\",
            classNameField: \"bulletClass\",
            title: \"latitude/city\",
            type: \"line\",
            valueAxis: \"a2\",
            lineColor: \"#4AA4E6\",
            lineThickness: 1,
            bullet: \"round\",
            bulletBorderColor: \"#263138\",
            bulletBorderAlpha: 1,
            bulletBorderThickness: 2,
            bulletColor: \"#263138\",
            labelPosition: \"right\",
            balloonText: \"Индекс:[[value]]\",
            showBalloon: true,
            animationPlayed: true
        }],

        chartCursor: {
            zoomable: false,
            categoryBalloonDateFormat: \"DD-MM-YYYY\",
            cursorAlpha: 0,
            valueBalloonsEnabled: false
        }
    }); // Месяц
</script>";
    }

}
