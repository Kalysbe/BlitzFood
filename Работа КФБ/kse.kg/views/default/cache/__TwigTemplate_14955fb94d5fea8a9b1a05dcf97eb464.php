<?php

/* modules/Blog/List.html */
class __TwigTemplate_14955fb94d5fea8a9b1a05dcf97eb464 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<h2>";
        echo $this->getAttribute((isset($context['Blog']) ? $context['Blog'] : null), "Title", array(), "any");
        echo "</h2>

<div id=\"DatePicker\" style=\"width: 300px; float: right; margin: 0px; text-align: right;\">
    <h3>";
        // line 4
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{ForPeriod}", array(), "array");
        echo "</h3>
    <form action=\"\" method=\"POST\">
    ";
        // line 6
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{PeriodFrom}", array(), "array");
        echo ": <input type=\"text\" name=\"EntriesDateFrom\" id=\"EntriesDateFrom\" value=\"\" /><br />
    ";
        // line 7
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{PeriodTo}", array(), "array");
        echo ": <input type=\"text\" name=\"EntriesDateTo\" id=\"EntriesDateTo\" value=\"\" /><br />
    <input type=\"submit\" name=\"doByDate\" value=\"Показать\" />
    </form>
    <script type=\"text/javascript\">
        \$(\"#EntriesDateFrom\").datepicker({dateFormat: 'yy-mm-dd'});
        \$(\"#EntriesDateTo\").datepicker({dateFormat: 'yy-mm-dd'});
        \$(\"input:submit\").button();
    </script>
</div>

<ul>
";
        // line 18
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['Entries']) ? $context['Entries'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Entry']) {
            echo "
    <li><strong>";
            // line 19
            echo $this->getAttribute((isset($context['Entry']) ? $context['Entry'] : null), "Date", array(), "any");
            echo "</strong> <a href=\"";
            echo (isset($context['root']) ? $context['root'] : null);
            echo "/";
            echo (isset($context['lang_code']) ? $context['lang_code'] : null);
            echo "/";
            echo (isset($context['BlogName']) ? $context['BlogName'] : null);
            echo "/";
            echo $this->getAttribute((isset($context['Entry']) ? $context['Entry'] : null), "Id", array(), "any");
            echo "/";
            echo $this->getAttribute((isset($context['Entry']) ? $context['Entry'] : null), "Name", array(), "any");
            echo "\">";
            echo $this->getAttribute((isset($context['Entry']) ? $context['Entry'] : null), "Title", array(), "any");
            echo "</a>
    <br />";
            // line 20
            echo $this->getAttribute((isset($context['Entry']) ? $context['Entry'] : null), "Intro", array(), "any");
            echo "</li>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Entry'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 21
        echo "
</ul>
<br /><br />
<div>";
        // line 24
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{TotalPages}", array(), "array");
        echo ": ";
        echo (isset($context['PagesNum']) ? $context['PagesNum'] : null);
        echo "</div>
";
        // line 25
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['Pages']) ? $context['Pages'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['each']) {
            echo "
    ";
            // line 26
            if ((isset($context['CurrentPage']) ? $context['CurrentPage'] : null) == (isset($context['each']) ? $context['each'] : null)) {
                echo "
    <b>";
                // line 27
                echo (isset($context['each']) ? $context['each'] : null);
                echo "</b>
    ";
            } else {
                // line 28
                echo "
    <a href=\"";
                // line 29
                echo (isset($context['root']) ? $context['root'] : null);
                echo "/";
                echo (isset($context['lang_code']) ? $context['lang_code'] : null);
                echo "/";
                echo (isset($context['BlogName']) ? $context['BlogName'] : null);
                echo "/Page:";
                echo (isset($context['each']) ? $context['each'] : null);
                echo "\" class=\"page_link\" style=\"margin: 5px;\"> ";
                echo (isset($context['each']) ? $context['each'] : null);
                echo "</a>
    ";
            }
            // line 30
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['each'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
    }

}
