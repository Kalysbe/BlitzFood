<?php

/* modules/MembersRating/Rating.html */
class __TwigTemplate_75f14089017500189d7f82d2e0ab316a extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<h2>Рейтинг участников торгов ЗАО \"КФБ\" за ";
        echo (isset($context['current_year']) ? $context['current_year'] : null);
        echo " год</h2>
<br>
<table width=\"100%\" class=\"class1\">
    <tr>
        <th>Наименование компании</th>
        <th>Объем млн.сом</th>
        <th>Кол-во сделок</th>
\t\t<th>Кол-во фин. инструментов</th>
\t\t<th>Кол-во рыночных сделок</th>
\t\t<th>Объем рыночных сделок, тыс. сом</th>
\t\t<th>Итоговый балл</th>
    </tr>
";
        // line 13
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['rating']) ? $context['rating'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['company']) {
            echo "
    <tr>
        <td>";
            // line 15
            echo $this->getAttribute((isset($context['company']) ? $context['company'] : null), "name", array(), "array");
            echo "</td>
        <td align=\"right\">";
            // line 16
            echo $this->getAttribute((isset($context['company']) ? $context['company'] : null), "volume", array(), "array");
            echo "</td>
        <td align=\"right\">";
            // line 17
            echo $this->getAttribute((isset($context['company']) ? $context['company'] : null), "amount", array(), "array");
            echo "</td>
\t\t<td align=\"right\">";
            // line 18
            echo $this->getAttribute((isset($context['company']) ? $context['company'] : null), "count_fin_instr", array(), "array");
            echo "</td>
\t\t<td align=\"right\">";
            // line 19
            echo $this->getAttribute((isset($context['company']) ? $context['company'] : null), "count_market_deal", array(), "array");
            echo "</td>
\t\t<td align=\"right\">";
            // line 20
            echo $this->getAttribute((isset($context['company']) ? $context['company'] : null), "volume_market_deal", array(), "array");
            echo "</td>
\t\t<td align=\"right\">";
            // line 21
            echo $this->getAttribute((isset($context['company']) ? $context['company'] : null), "factor", array(), "array");
            echo "</td>
    </tr>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['company'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 23
        echo "
</table>
";
        // line 25
        if ((isset($context['current_year']) ? $context['current_year'] : null) == 2014) {
            echo "
<b> <font size=1>* пересчитано в связи с тем, что сделки по листинговым облигациям с 3 октября 2014 года являются партнерскими</b></font><br>
";
        }
        // line 27
        echo "

<div class=\"results_view f_r\"> Года
";
        // line 30
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['available_years']) ? $context['available_years'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['year']) {
            echo "
/ <a href=\"";
            // line 31
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/MembersRating/";
            echo (isset($context['year']) ? $context['year'] : null);
            echo "\"";
            if ((isset($context['year']) ? $context['year'] : null) == (isset($context['current_year']) ? $context['current_year'] : null)) {
                echo "

        class=\"current\"
     ";
            }
            // line 34
            echo ">";
            echo (isset($context['year']) ? $context['year'] : null);
            echo "</a>

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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['year'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 36
        echo "
</div>
";
    }

}
