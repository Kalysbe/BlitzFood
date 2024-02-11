<?php

/* common_head.html */
class __TwigTemplate_d8f2cb01af7fb5fdb13f74c07c22968d extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<!--common_head
<script language=\"Javascript\" src=\"";
        // line 2
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/lib/FusionCharts/FusionCharts.js\"></script>
<script language=\"Javascript\" src=\"";
        // line 3
        echo (isset($context['root']) ? $context['root'] : null);
        echo "/scripts/jquery.tools.min.js\"></script>

<script type=\"text/javascript\">
    \$(function() {
        \$('div.scroll_quote').tooltip({tipClass: 'quote_tooltip'});
    });
</script>
end of common_head-->";
    }

}
