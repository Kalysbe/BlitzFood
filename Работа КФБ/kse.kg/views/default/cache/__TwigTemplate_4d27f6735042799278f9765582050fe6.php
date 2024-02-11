<?php

/* modules/Search/Search.html */
class __TwigTemplate_4d27f6735042799278f9765582050fe6 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<h2 class=\"title\">Результат поиска</h2>
<ul>
<h3>Раскрытие информации</h3>
";
        // line 4
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['Search']) ? $context['Search'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Searches']) {
            echo "
\t<li><a href=\"http://www.kse.kg/ru/PublicInfo/";
            // line 5
            echo $this->getAttribute((isset($context['Searches']) ? $context['Searches'] : null), "brep_company_name", array(), "array");
            echo "\">";
            echo $this->getAttribute((isset($context['Searches']) ? $context['Searches'] : null), "title", array(), "array");
            echo "</a></li>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Searches'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 6
        echo "
</ul>

";
        // line 9
        if ((isset($context['ListingList']) ? $context['ListingList'] : null) != (isset($context['null']) ? $context['null'] : null)) {
            echo "
\t<h3>Листинг</h3>
\t";
            // line 11
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_iterator_to_array((isset($context['ListingList']) ? $context['ListingList'] : null));
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
            foreach ($context['_seq'] as $context['_key'] => $context['Listing']) {
                echo "
\t\t<li><a href=\"";
                // line 12
                echo $this->getAttribute((isset($context['Listing']) ? $context['Listing'] : null), 0, array(), "array");
                echo "\">";
                echo $this->getAttribute((isset($context['Listing']) ? $context['Listing'] : null), 1, array(), "array");
                echo "</a></li>
\t";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Listing'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 13
            echo "
";
        }
        // line 14
        echo "


<h3>Новости сайта</h3>
<ul>
";
        // line 19
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['NewSearch']) ? $context['NewSearch'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['NewSearch']) {
            echo "
\t";
            // line 20
            if ($this->getAttribute((isset($context['NewSearch']) ? $context['NewSearch'] : null), "blogentry_id", array(), "array") != (isset($context['null']) ? $context['null'] : null)) {
                echo "
\t\t<li>";
                // line 21
                echo $this->getAttribute((isset($context['NewSearch']) ? $context['NewSearch'] : null), "public_date", array(), "array");
                echo " <a href=\"http://www.kse.kg/ru/RussianAllNewsBlog/";
                echo $this->getAttribute((isset($context['NewSearch']) ? $context['NewSearch'] : null), "blogentry_id", array(), "array");
                echo "\"> ";
                echo $this->getAttribute((isset($context['NewSearch']) ? $context['NewSearch'] : null), "title", array(), "array");
                echo "</a></li>
\t";
            }
            // line 22
            echo "
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['NewSearch'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 23
        echo "
</ul>

<br /><br />
<div>";
        // line 27
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{TotalPages}", array(), "array");
        echo ": ";
        echo (isset($context['Pages']) ? $context['Pages'] : null);
        echo "</div>
";
        // line 28
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
    ";
            // line 29
            if ((isset($context['CurrentPage']) ? $context['CurrentPage'] : null) == (isset($context['Page']) ? $context['Page'] : null)) {
                echo "
    <b>";
                // line 30
                echo (isset($context['Page']) ? $context['Page'] : null);
                echo "</b>
    ";
            } else {
                // line 31
                echo "
    <a href=\"";
                // line 32
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/Search/search=";
                echo (isset($context['word']) ? $context['word'] : null);
                echo "&Page=";
                echo (isset($context['each']) ? $context['each'] : null);
                echo "\" class=\"page_link\" style=\"margin: 5px;\"> ";
                echo (isset($context['Page']) ? $context['Page'] : null);
                echo "</a>
    ";
            }
            // line 33
            echo "
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
        // line 34
        echo "
<!-- /Search --> ";
    }

}
