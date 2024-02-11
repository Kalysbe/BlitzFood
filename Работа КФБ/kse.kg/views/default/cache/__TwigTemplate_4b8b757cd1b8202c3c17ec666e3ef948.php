<?php

/* modules/FinMarket/FinMarket.html */
class __TwigTemplate_4b8b757cd1b8202c3c17ec666e3ef948 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "
";
        // line 2
        if ((isset($context['Logged']) ? $context['Logged'] : null)) {
            echo "
<script type=\"text/javascript\">
    function displayMarketForm() {
        \$(\"#NewMarketForm\").css('display', 'block');
    }

    function hideMarketForm() {
        \$(\"#NewMarketForm\").css('display', 'none');
    }
</script>

<input type=\"button\" value=\"Добавить файл\" id=\"NewFinMarket\" onClick=\"displayMarketForm()\" /><br />

<div id=\"NewMarketForm\" style=\"display: none\">
    <h2>Новый файл</h2>
    <br />
    <form action=\"";
            // line 18
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/modules/FinMarket/NewMarket.php\" method=\"POST\" enctype=\"multipart/form-data\">
        <label>Файл: </label><p><input type=\"file\" name=\"mMarket\" /></p>
        <label>Название: </label><p><input type=\"text\" name=\"mTitle\" value=\"\"  style=\"border: 1px solid #CCCCCC\"/></p>
        <label>Описание: </label><p><textarea name=\"mDescription\" cols=\"60\" rows=\"10\" style=\"border: 1px solid #CCCCCC\"></textarea></p>
        <label>&nbsp;</label><p><input type=\"submit\" name=\"doAddMarket\" value=\"Загрузить\" /></p>
    </form>
    <br />
    <input type=\"button\" value=\"Скрыть\" id=\"NewFinMarketCancel\" onClick=\"hideMarketForm()\"/><br />
    <br />
</div>
<Br /><br />
";
        }
        // line 29
        echo "

<ul class=\"FinMarket\">
    ";
        // line 32
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['FinMarketFiles']) ? $context['FinMarketFiles'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['File']) {
            echo "
    <li>
        <div class=\"fin_file\">
            <a href=\"";
            // line 35
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/FinMarket/";
            echo $this->getAttribute((isset($context['File']) ? $context['File'] : null), "Path", array(), "array");
            echo "\"><img src=\"";
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/views/kse/images/icon_pdf.jpg\" /></a>
        </div>
        <div class=\"fin_description\">
            <h3>";
            // line 38
            echo $this->getAttribute((isset($context['File']) ? $context['File'] : null), "Title", array(), "array");
            echo "</h3>
            <p>";
            // line 39
            echo $this->getAttribute((isset($context['File']) ? $context['File'] : null), "Description", array(), "array");
            echo "</p>
            <p class=\"meta\"><a href=\"";
            // line 40
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/FinMarket/";
            echo $this->getAttribute((isset($context['File']) ? $context['File'] : null), "Path", array(), "array");
            echo "\">Скачать &gt;&gt;&gt;</a> 
            ";
            // line 41
            if ((isset($context['Logged']) ? $context['Logged'] : null)) {
                echo "
                <!-- <input type=\"button\" name=\"doEditMarket\" id=\"doEditMarket\" value=\"Править\" /> -->
\t\t <form action=\"";
                // line 43
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/modules/FinMarket/DelMarket.php\" method=\"POST\" enctype=\"multipart/form-data\">
\t\t\t<input type=\"hidden\" name=\"id_row\" value=";
                // line 44
                echo $this->getAttribute((isset($context['File']) ? $context['File'] : null), "id_row", array(), "array");
                echo " />
\t\t\t<input type=\"submit\" value=\"удалить\" name=\"doDelMarket\" id=\"doDelMarket\" />
\t\t </form>
            ";
            }
            // line 47
            echo "

            </p>
        </div>
    </li>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['File'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 52
        echo "
</ul>
<br />
<br />
<br />
<div style=\"clear: both; margin-top:40px;\"></div>
Страницы: 
";
        // line 59
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['PagesList']) ? $context['PagesList'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Page']) {
            echo "
    <a href=\"";
            // line 60
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/FinMarket/";
            echo (isset($context['Page']) ? $context['Page'] : null);
            echo "\">";
            echo (isset($context['Page']) ? $context['Page'] : null);
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Page'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 61
        echo "
";
    }

}
