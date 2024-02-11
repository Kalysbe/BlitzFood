<?php

/* modules/TradeArchive/TradeArchive.html */
class __TwigTemplate_c9a7e8741221359e44cce954bb007e5d extends Twig_Template
{
    public function display(array $context)
    {
        // line 1
        echo "<h2>";
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradearchive", array(), "array");
        echo "</h2>

<div id=\"current_year\" class=\"trade_archive_block\">
    <br />
    <h4>";
        // line 5
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "currentyear", array(), "array");
        echo "</h4>
    <br />
    <table width=\"100%\" class=\"class1\">
        <tr>
            <th></th>
            <th>";
        // line 10
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "totaltradevolume", array(), "array");
        echo "</th>
            <th>";
        // line 11
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountofsecuritiespiece", array(), "array");
        echo "</th>
            <th>";
        // line 12
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountoftransactions", array(), "array");
        echo "</th>
            <th>";
        // line 13
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesprimary", array(), "array");
        echo "</th>
            <th width=12%>";
        // line 14
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradessecond", array(), "array");
        echo "</th>
            <th width=15%>";
        // line 15
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradeslisted", array(), "array");
        echo "</th>
            <th width=15%>";
        // line 16
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesnonlisted", array(), "array");
        echo "</th>

        </tr>
        ";
        // line 19
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['CurrentYear']) ? $context['CurrentYear'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Trade']) {
            echo "
        <tr>
            <th>";
            // line 21
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "Month", array(), "array");
            echo "/";
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "Year", array(), "array");
            echo "&nbsp; </th>
            <td align=\"right\"> ";
            // line 22
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "TotalVolume", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 23
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "SecondaryAmount", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 24
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "DealsAmount", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 25
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "PrimaryDeals", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 26
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "SecondaryDeals", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 27
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "ListingTrades", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 28
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "NonListingTrades", array(), "array");
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Trade'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 30
        echo "
        <tr>
            <th>";
        // line 32
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "total", array(), "array");
        echo "</th>
            <td align=\"right\">";
        // line 33
        echo $this->getAttribute((isset($context['total_current']) ? $context['total_current'] : null), "total_volume", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 34
        echo $this->getAttribute((isset($context['total_current']) ? $context['total_current'] : null), "secondary_amount", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 35
        echo $this->getAttribute((isset($context['total_current']) ? $context['total_current'] : null), "deals_amount", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 36
        echo $this->getAttribute((isset($context['total_current']) ? $context['total_current'] : null), "primary_deals", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 37
        echo $this->getAttribute((isset($context['total_current']) ? $context['total_current'] : null), "secondary_deals", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 38
        echo $this->getAttribute((isset($context['total_current']) ? $context['total_current'] : null), "listing_trades", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 39
        echo $this->getAttribute((isset($context['total_current']) ? $context['total_current'] : null), "non_listing_trades", array(), "array");
        echo "</td>
        </tr>
    </table>
</div>

<div id=\"past_year\" class=\"trade_archive_block\" style=\"display: none;\">
    <br />
    <h4>";
        // line 46
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "lastyear", array(), "array");
        echo "</h4>
    <br />
    <table width=\"100%\" class=\"class1\">
        <tr>
            <th></th>
            <th>";
        // line 51
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "totaltradevolume", array(), "array");
        echo "</th>
            <th>";
        // line 52
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountofsecuritiespiece", array(), "array");
        echo "</th>
            <th>";
        // line 53
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountoftransactions", array(), "array");
        echo "</th>
            <th>";
        // line 54
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesprimary", array(), "array");
        echo "</th>
            <th width=12%>";
        // line 55
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradessecond", array(), "array");
        echo "</th>
            <th width=15%>";
        // line 56
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradeslisted", array(), "array");
        echo "</th>
            <th width=15%>";
        // line 57
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesnonlisted", array(), "array");
        echo "</th>

        </tr>
        ";
        // line 60
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['PastYear']) ? $context['PastYear'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Trade']) {
            echo "
        <tr>
            <th>";
            // line 62
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "Month", array(), "array");
            echo "/";
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "Year", array(), "array");
            echo "&nbsp; </th>
            <td align=\"right\"> ";
            // line 63
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "TotalVolume", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 64
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "SecondaryAmount", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 65
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "DealsAmount", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 66
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "PrimaryDeals", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 67
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "SecondaryDeals", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 68
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "ListingTrades", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 69
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "NonListingTrades", array(), "array");
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Trade'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 71
        echo "
        <tr>
            <th>";
        // line 73
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "total", array(), "array");
        echo "</th>
            <td align=\"right\">";
        // line 74
        echo $this->getAttribute((isset($context['past_year_total']) ? $context['past_year_total'] : null), "total_volume", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 75
        echo $this->getAttribute((isset($context['past_year_total']) ? $context['past_year_total'] : null), "secondary_amount", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 76
        echo $this->getAttribute((isset($context['past_year_total']) ? $context['past_year_total'] : null), "deals_amount", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 77
        echo $this->getAttribute((isset($context['past_year_total']) ? $context['past_year_total'] : null), "primary_deals", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 78
        echo $this->getAttribute((isset($context['past_year_total']) ? $context['past_year_total'] : null), "secondary_deals", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 79
        echo $this->getAttribute((isset($context['past_year_total']) ? $context['past_year_total'] : null), "listing_trades", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 80
        echo $this->getAttribute((isset($context['past_year_total']) ? $context['past_year_total'] : null), "non_listing_trades", array(), "array");
        echo "</td>
        </tr>
    </table>
</div>

<div id=\"all_years\" class=\"trade_archive_block\" style=\"display: none;\">
    <br />
    <h4>";
        // line 87
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "onyear", array(), "array");
        echo "</h4>
    <br />
    <table width=\"100%\" class=\"class1\">
        <tr>
            <th></th>
            <th>";
        // line 92
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "totaltradevolume", array(), "array");
        echo "</th>
            <th>";
        // line 93
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountofsecuritiespiece", array(), "array");
        echo "</th>
            <th>";
        // line 94
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "amountoftransactions", array(), "array");
        echo "</th>
            <th width=14%>";
        // line 95
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesprimary", array(), "array");
        echo "</th>
            <th width=14%>";
        // line 96
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradessecond", array(), "array");
        echo "</th>
            <th width=14%>";
        // line 97
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradeslisted", array(), "array");
        echo "</th>
            <th width=14%>";
        // line 98
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "tradesnonlisted", array(), "array");
        echo "</th>

        </tr>
        ";
        // line 101
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array((isset($context['TotalYear']) ? $context['TotalYear'] : null));
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
        foreach ($context['_seq'] as $context['_key'] => $context['Trade']) {
            echo "
        <tr>
            <th>";
            // line 103
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "Year", array(), "array");
            echo "&nbsp; </th>
            <td align=\"right\"> ";
            // line 104
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "TotalVolume", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 105
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "SecondaryAmount", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 106
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "DealsAmount", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 107
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "PrimaryDeals", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 108
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "SecondaryDeals", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 109
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "ListingTrades", array(), "array");
            echo "</td>
            <td align=\"right\">";
            // line 110
            echo $this->getAttribute((isset($context['Trade']) ? $context['Trade'] : null), "NonListingTrades", array(), "array");
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Trade'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 112
        echo "
        <tr>
            <th>";
        // line 114
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "total", array(), "array");
        echo "</th>
            <td align=\"right\">";
        // line 115
        echo $this->getAttribute((isset($context['all_years_total']) ? $context['all_years_total'] : null), "total_volume", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 116
        echo $this->getAttribute((isset($context['all_years_total']) ? $context['all_years_total'] : null), "secondary_amount", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 117
        echo $this->getAttribute((isset($context['all_years_total']) ? $context['all_years_total'] : null), "deals_amount", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 118
        echo $this->getAttribute((isset($context['all_years_total']) ? $context['all_years_total'] : null), "primary_deals", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 119
        echo $this->getAttribute((isset($context['all_years_total']) ? $context['all_years_total'] : null), "secondary_deals", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 120
        echo $this->getAttribute((isset($context['all_years_total']) ? $context['all_years_total'] : null), "listing_trades", array(), "array");
        echo "</td>
            <td align=\"right\">";
        // line 121
        echo $this->getAttribute((isset($context['all_years_total']) ? $context['all_years_total'] : null), "non_listing_trades", array(), "array");
        echo "</td>
        </tr>
    </table>
</div>

<div class=\"results_view f_r\">
    ";
        // line 127
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "{Period}", array(), "array");
        echo "
    <a href=\"#\" id=\"tradearchive_current_link\" class=\"tradearchive_links current\">";
        // line 128
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "currentyear", array(), "array");
        echo "</a> /
    <a href=\"#\" id=\"tradearchive_past_link\" class=\"tradearchive_links\">";
        // line 129
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "lastyear", array(), "array");
        echo "</a> /
    <a href=\"#\" id=\"tradearchive_years_link\" class=\"tradearchive_links\">";
        // line 130
        echo $this->getAttribute((isset($context['lang']) ? $context['lang'] : null), "onyear", array(), "array");
        echo "</a>
</div>

<script type=\"text/javascript\">

    \$(\"#tradearchive_current_link\").bind(\"click\", function(){
        \$(\".trade_archive_block\").css(\"display\", \"none\");
        \$(\"#current_year\").css(\"display\", \"block\");
        \$(\".tradearchive_links\").removeClass(\"current\");
        \$(\"#tradearchive_current_link\").addClass(\"current\");
    });

    \$(\"#tradearchive_past_link\").bind(\"click\", function(){
        \$(\".trade_archive_block\").css(\"display\", \"none\");
        \$(\"#past_year\").css(\"display\", \"block\");
        \$(\".tradearchive_links\").removeClass(\"current\");
        \$(\"#tradearchive_past_link\").addClass(\"current\");
    });

    \$(\"#tradearchive_years_link\").bind(\"click\", function(){
        \$(\".trade_archive_block\").css(\"display\", \"none\");
        \$(\"#all_years\").css(\"display\", \"block\");
        \$(\".tradearchive_links\").removeClass(\"current\");
        \$(\"#tradearchive_years_link\").addClass(\"current\");
    });

</script>";
    }

}
