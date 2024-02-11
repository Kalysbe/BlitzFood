<?php

/* modules/Quotes/Quotes_gold.html */
class __TwigTemplate_51ed64def8da58f8689119d362ac7961 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<table class=\"class1\" width=\"100%\">
    <h3 style=\"color: #909090;text-align: center;font-size: 11px;\">Котировки сектора драгоценных металлов на ";
        // line 2
        echo (isset($context['date']) ? $context['date'] : null);
        echo "</h3>
<tr>
        <td rowspan='2'>";
        // line 4
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesymbol", array(), "array");
        echo "</td>
        <td class=\"\" rowspan='2'>";
        // line 5
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "qname", array(), "array");
        echo "</td>
\t\t<td colspan='2'>";
        // line 6
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "salequantity", array(), "array");
        echo "</td>
\t\t<td colspan='2'>";
        // line 7
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "buyquantity", array(), "array");
        echo "</td>
\t\t
\t\t<tr>
\t\t\t<td>";
        // line 10
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "qquantity", array(), "array");
        echo "</td>
\t\t\t<td>";
        // line 11
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "qprice", array(), "array");
        echo "</td>
\t\t\t<td>";
        // line 12
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "qquantity", array(), "array");
        echo "</td>
\t\t\t<td>";
        // line 13
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "qprice", array(), "array");
        echo "</td>
\t\t</tr>
</tr>
    ";
        // line 16
        $context['_parent'] = (array) $context;
        $context['_iterated'] = false;
        $context['_seq'] = twig_iterator_to_array((isset($context['Quotes']) ? $context['Quotes'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Quote']) {
            $context['_iterated'] = true;
            echo "
    <tr class=\"parse\">
        <td class=\"short_name\">";
            // line 18
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "short_name", array(), "array");
            echo "</td>
        <td class=\"full_name\">";
            // line 19
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "full_name", array(), "array");
            echo "</td>
        <td class=\"center sell_amount\">";
            // line 20
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "sell_amount", array(), "array");
            echo "</td>
        <td class=\"center sell_price\">";
            // line 21
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "sell_price", array(), "array");
            echo "</td>
        <td class=\"center buy_amount\">";
            // line 22
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "buy_amount", array(), "array");
            echo "</td>
        <td class=\"center buy_price\">";
            // line 23
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "buy_price", array(), "array");
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
        if (!$context['_iterated']) {
            // line 25
            echo "
    <tr>
        <td class=\"center\">-</td>
        <td class=\"center\">-</td>
        <td class=\"center\">-</td>
        <td class=\"center\">-</td>
        <td class=\"center\">-</td>
        <td class=\"center\">-</td>
    </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Quote'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 34
        echo "
</table>";
    }

}
