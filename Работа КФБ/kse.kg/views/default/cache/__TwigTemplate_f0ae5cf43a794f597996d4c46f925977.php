<?php

/* modules/Blogeng/Entry.html */
class __TwigTemplate_f0ae5cf43a794f597996d4c46f925977 extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<h3>";
        echo (isset($context['EntryTitle']) ? $context['EntryTitle'] : null);
        echo "</h3>
<p>";
        // line 2
        echo (isset($context['EntryText']) ? $context['EntryText'] : null);
        echo "</p>";
    }

}
