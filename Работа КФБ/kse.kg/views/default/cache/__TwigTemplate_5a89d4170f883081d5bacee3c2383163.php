<?php

/* modules/Quotes/Quotes_Salym.html */
class __TwigTemplate_5a89d4170f883081d5bacee3c2383163 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<style type=\"text/css\">
    ul li {
        list-style-type: none;
    }
</style>
<p style=\"font-weight: 500;\">
    <h3>Начался прием заявок на публичное размещение привилегированных акций (IPO) ОАО Микрофинансовая компания \"Салым Финанс\", который продлится до 23 сентября 2020 года.</h3>
</p>
<br>
<p>Параметры выпуска:</p><br>
<ul>
    <li>Вид публично предлагаемых ценных бумаг: именные привилегированные акции</li>
    <li>Размер дивиденда на одну привилегированную акцию: в размере 160 сом в год</li>
    <li>Номинальная стоимость одной именной привилегированной акции: 1 000 (одна тысяча) сом</li>
    <li>Количество ценных бумаг, предполагаемых к публичному предложению: 50 000 (пятьдесят тысяч) экземпляров</li>
    <li>Минимальный пакет продажи акций одному юридическому или физическому лицу: 25 (двадцать пять) экземпляров привилегированных акций</li>
\t<li>Андеррайтер выпуска: ОсОО Финансовая компания «Сенти»</li>
    <li>
        <div class=\"pdf_link\">
                                            <a href=\"https://www.kse.kg/files/upload/usloviya.pdf\" class=\"f_l\">
                                                <img src=\"https://www.kse.kg/views/kse/images/icon_pdf.png\" border=\"0\" alt=\"ListingRules_rus.pdf\"></a>
                                            <a href=\"https://www.kse.kg/files/upload/usloviya.pdf\" class=\"bullet_link pdf_link\">Условия предложения</a>
                                            <p class=\"pdf_size\">2.7 МБ</p>
                                        </div>
    </li>
    <li>
        <div class=\"pdf_link\">
                                            <a href=\"https://www.kse.kg/files/upload/prospekt.pdf\" class=\"f_l\">
                                                <img src=\"https://www.kse.kg/views/kse/images/icon_pdf.png\" border=\"0\" alt=\"ListingRules_rus.pdf\"></a>
                                            <a href=\"https://www.kse.kg/files/upload/prospekt.pdf\" class=\"bullet_link pdf_link\">Проспект ОАО МФК Салым Финанс</a>
                                            <p class=\"pdf_size\">5.7 МБ</p>
                                        </div>
    </li>
</ul>

<h3 style=\"color: #1464ad; margin: 15px; font-size: 14px\">Заявки участиков IPO в торговой системе ЗАО \"КФБ\"</h3>
<table class=\"class1\" width=\"100%\">
    
<tr>
        <td rowspan='2'>";
        // line 40
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesymbol", array(), "array");
        echo "</td>
        <td rowspan='2'>";
        // line 41
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "qname", array(), "array");
        echo "</td>
\t\t<td >";
        // line 42
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "buyquantity", array(), "array");
        echo "</td>
\t\t<td rowspan='2'>Дата</td>
        <td rowspan='2'>Время</td>
\t\t<tr>
\t\t\t<td>";
        // line 46
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "qquantity", array(), "array");
        echo "</td>
\t\t</tr>
        
</tr>
    ";
        // line 50
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
    <tr>
        <td>";
            // line 52
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "short_name", array(), "array");
            echo "</td>
        <td>";
            // line 53
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "full_name", array(), "array");
            echo "</td>
        <td class=\"center\">";
            // line 54
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "buy_amount", array(), "array");
            echo "</td>

        <td >";
            // line 56
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "date1", array(), "array");
            echo "</td>
        <td >";
            // line 57
            echo $this->getAttribute((isset($context['Quote']) ? $context['Quote'] : null), "time1", array(), "array");
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
            // line 59
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
        // line 68
        echo "
</table>";
    }

}
